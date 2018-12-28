<?php


namespace components\Controller\forum;


use Carbon\Carbon;
use components\Eloquent\Forum;
use components\Eloquent\User;
use components\Exceptions\ForumException;
use components\Helper\Rvs;
use components\Helper\Str;

class PostController extends ForumController
{
    /**
     * @param $id
     *
     * �������� ����� � ������
     */
    public function createPostAction($id)
    {
        //������ �������
        $request = $this->app->request;
        //$_POST ������
        $post_data = $request->post();
        $text = $post_data['text'];

        try {

            if (!$this->user) {
                throw new ForumException('�� ��');
            }

            //�������� ������ ���������� �� �����
//            $this->checkToken();

            //������ �� ���� ��������� �������� =)) ( � ���� ������ ������ ������ � ��� ����� !)
            $rvs = Rvs::detect($post_data, [
                'text' => [
                    'contains',
                    'rvs_links',
                ],
            ], true);

            if ($rvs !== false) {
                $text = '/?RVS';
            }

            if ($this->app->session->get('captcha_data')['show'] && !\components\Helper\Captcha::validate()) {
                throw new ForumException('�������� �������� ���!');
            }


            if ($this->spamDetect()) {
                throw new ForumException('�� ����� �������...');
            }

            \Validator::extend(
                'forum_rvs',
                function ($attribute, $value, $parameters)
                {
                    return $value !== '/?RVS';
                }
            );

            //��������� �������� ������
            $validator = \Validator::make(
                ['text' => $text],
                [
                    'text' => [
                        'required',
                        'forum_rvs',
                    ],
                ],
                [
                    'text.required' => '����� �� ����� ���� ������',
                    'text.forum_rvs' => '���',
                ]
            );

            if ($validator->fails()) {
                throw new ForumException($validator->errors()->first());
            }

            $text = strip_tags(nl2br(htmlspecialchars_decode(trim($text))), '<b><i><u><code><br><blockquote>');
            $text = Str::closetags($text);
            $text = Str::stripTagAttributes($text);
            $text = Str::makeLink($text);
//            $text = \Xss::clean($text);

            if (trim(strip_tags($text)) == '') {
                throw new ForumException('����������� �������');
            }


            //���
            $topic = Forum::find($id);

            //���������� �� ��� ��� ����� �� ������
            if (!$topic || (!$this->user->isAdmin() && !$this->user->isPaladin() && $topic->isDeleted('top'))) {
                return $this->app->redirectWithError('���� ������� � ������, ���� � �� ����������', $this->app->urlFor('forum'));
            }

            //����������� ����� ��� �������� �����
            $categories = $this->getCategories();
            //���� �� � ����� ����� ������� � �����
            $conf_query = $categories->where('id', '=', $topic->parent);

            if (!$this->user->isAdmin() && !$this->user->isAdminion()) {
                $conf_query = $conf_query
                    ->where('min_level', '<=', $this->user->level)
                    ->where('max_level', '>=', $this->user->level);
            }

            $conf = $conf_query->first();

            if (!$conf) {
                throw new ForumException('�� ���� ��� ������!');
            }

            //��� ��� ������
            if ($topic->isClosed() && (!$this->user->isAdmin() && !$this->user->isPaladin())) {
                throw new ForumException('���� ������� ��� ����������');
            }

            //���� � ��� ����� ������ � ����� � ������
            if ($this->user->hasChaos() && !$topic->canCreatePostWithChaos()) {
                throw new ForumException('��������� ��������� ������ �� ������');
            }

            //�������� � ������� �������� � ����� ������ (hardcode)
            if ($this->user->hasForumSilence() && !$conf->canCreateWithSilens($this->user)) {
                throw new ForumException('�� ��������� �������� ��������� ��������');
            }

            $hidden = $this->user->isAdmin() || $this->user->isAdminion() || $this->user->isHighPaladin()
                ? $this->user->getAttribute('hidden')
                : 0;

            //��� ���, ����� ����� ����
            $new_post = Forum::create([
                'type' => 2,
                'text' => $text,
                'parent' => $topic->id,
                'min_align' => $topic->min_align,
                'max_align' => $topic->max_align,
                'author' => $this->user->id,
                'date' => Carbon::now()->format('d.m.y H:i:s'),
                'a_info' => [
                    $this->user->login,
                    $this->user->klan,
                    $this->user->align,
                    $this->user->level,
                    $hidden,
                ]
            ]);

            //���-�� ����� �� ��� (
            if (!$new_post) {
                throw new ForumException('������ �������� �����');
            }

            //��������� � ������ ����� ����
            $new_post->addToIndex(['text']);

            $update_data = [
                'updated' => Carbon::now()
            ];

            //��������� ��� ���� ������ �������
            if (isset($post_data['andclose']) && ($this->user->isAdmin() || $this->user->isAdminion() || $this->user->isHighPaladin())) {

                $update_data = array_merge($update_data, [
                    'close' => 1,
                    'closepal' => $this->user->id,
                    'close_info' => [
                        $this->user->login,
                        $this->user->klan,
                        $this->user->align,
                        $this->user->level,
                        $this->user->getAttribute('hidden'),
                    ],
                ]);

            }

            //��������� ���
            $topic->update($update_data);

            //������������� ���� � �������� ���������� ���������
            $this->setLastMessageTime();

            //���������� ������� � ����
            $this->app->redirect($this->app->request->getReferer() . '#p' . $new_post->id);

        } catch (ForumException $exception) {

            //���������� ��������� ����� ���������
            $this->app->flash('text', $post_data['text']);

            //���������� �����
            $this->app->redirectWithError($exception->getMessage());
        }

    }

    /**
     * @param $params
     *
     * ������/������� ���� � ������
     */
    public function deletePostAction($params)
    {
        $request = $this->app->request;

        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->isForumModerator()) {
                throw new ForumException('��� ���� ����������');
            }

            if (!$this->user->canPostDelete()) {
                throw new ForumException('��� ���� �������� ������');
            }

            $get_topic = $params[0];
            $get_post = $params[1];

            $post = Forum::find($get_post);

            if (!$post) {
                throw new ForumException('���� �� ������');
            }

            //������� �� ����
            if ($request->get('hard')) {

                if ($post->isMain()) {
                    throw new ForumException('���� ���� �� ����� ���� ������ �� ����, ��� �������� ������ ������� ��������������� ����');
                }

                if (!$this->user->canPostDelete('hard')) {
                    throw new ForumException('��� ����');
                }

                //������� �� ����
                $post->delete();

                //������� �� �������
                $post->deleteFromIndex();

                $this->app->flash('noty', [
                    'type' => 'success',
                    'msg' => '���� ������ �� ����',
                ]);

                return $this->app->redirect($request->getReferer());
            }

            $post->delpal = $this->user->id;
            $post->del_info = [
                $this->user->login,
                $this->user->klan,
                $this->user->align,
                $this->user->level,
                $this->user->getAttribute('hidden'),
            ];

            //������� �������� (��� ������� �������)
            if ($request->post('delete_post_reason') != '') {
                $reason = strip_tags($request->post('delete_post_reason'), '<a>');

                $pal_comments = $post->pal_comments ?: [];

                $comment_author = false;

                if ($a = $request->post('reason_author')) {

                    $ra = array_shift($a);

                    if($ra == -1 && $this->user->canBeInvisible()) {//���������
                        $comment_author = [
                            null,
                            null,
                            0,
                            null,
                            -1,
                            $this->user->id
                        ];
                    } else {
                        throw new ForumException('��...� ��� ������ ������ �� ��� ���������!');
                    }

                }

                array_push($pal_comments, [
                    'author' => $comment_author,
                    'text' => '<small>(' . Carbon::now()->format('d.m.y H:i:s') . ')</small> ' . $reason
                ]);

                $post->pal_comments = array_values($pal_comments);
            }

            $post->save();

//            if ($post->appeal) {
//                $post->appeal->delete();
//            }

            $this->app->flash('noty', [
                'type' => 'success',
                'msg' => '���� ������',
            ]);

            $this->app->redirect($request->getReferer());

        } catch (ForumException $exception) {
            $this->app->redirectWithError($exception->getMessage());
        }

    }

    /**
     * @param $params
     *
     * �������������� ����� � ������
     */
    public function restorePostAction($params)
    {
        $request = $this->app->request;

        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->isForumModerator()) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->canPostRestore()) {
                throw new ForumException('��� ����');
            }

            $get_topic = $params[0];
            $get_post = $params[1];

            $post = Forum::find($get_post);

            if (!$post) {
                throw new ForumException('���� �� ������');
            }

            $post->update([
                'delpal' => null,
                'del_info' => null,
            ]);

            $this->app->flash('noty', [
                'type' => 'success',
                'msg' => '���� ������������',
            ]);

            $this->app->redirect($request->getReferer());

        } catch (ForumException $exception) {
            $this->app->redirectWithError($exception->getMessage());
        }

    }

    /**
     * @param $params
     *
     * �������������� �����
     */
    public function editPostAction($params)
    {
        $request = $this->app->request;

        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->canEditPost()) {
                throw new ForumException('��� ����');
            }

            $post = Forum::where('id', $params[1])->first();

            if(!$post) {
                throw new ForumException('���� �� ������');
            }

            if($request->isGet()) {

                $text = strip_tags(trim($post->text), '<b><i><u><code><blockquote><div><img>');

                return $this->renderJSON([
                    'status' => 1,
                    'text' => $text,
                    'type' => 'success',
                ]);
            }

            $text = strip_tags(nl2br(htmlspecialchars_decode(trim($request->post('edit_post')))), '<b><i><u><code><br><blockquote><div><img>');
            $text = Str::closetags($text);
            $text = Str::stripTagAttributes($text);
            $text = Str::makeLink($text);
//            $text = \Xss::clean($text);

            //��������� ����
            $post->text = $text;
            $post->save();

            try {
                //�������� ������
                $post->updateIndex(['text']);
            } catch (\Exception $exception) {

            }

            $this->app->flash('noty', [
                'type' => 'success',
                'msg' => '���� ��������������',
            ]);

            $this->app->redirect($request->getReferer());

        } catch (ForumException $exception) {
            //���������� �����
            $this->app->redirectWithError($exception->getMessage());
        }

    }

    /**
     * @param $params
     *
     * ���������� ��������
     */
    public function addCommentAction($params)
    {

        $request = $this->app->request;

        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->canCommentWrite()) {
                throw new ForumException('�� ���� ��� ������!');
            }

            $get_topic = $params[0];
            $get_post = $params[1];
            $comment = strip_tags(nl2br(htmlspecialchars_decode($request->post('comment'))), '<a><br>');
            $comment = Str::closetags($comment);
            $comment = Str::stripTagAttributes($comment);
            $comment = Str::makeLink($comment);

            $post = Forum::find($get_post);

            if (!$post) {
                throw new ForumException('���� �� ������');
            }

            $pal_comments = $post->pal_comments ?: [];

            $c_a = $request->post('comment_author');

            $comment_author = [
                $this->user->login,
                $this->user->klan,
                $this->user->align,
                $this->user->level,
                (($c_a && is_array($c_a) && !empty($c_a)) ? array_shift($c_a): $this->user->getAttribute('hidden')),
                $this->user->id,
            ];

            array_push($pal_comments, [
                'author' => $comment_author,
                'text' => '<small>(' . Carbon::now()->format('d.m.y H:i:s') . ')</small> ' . $comment
            ]);

            $post->pal_comments = array_values($pal_comments);

            $post->save();

            $this->app->flash('noty', [
                'type' => 'success',
                'msg' => '����������� ��������',
                'id' => $post->id,
            ]);

            $this->app->redirect($request->getReferer());

        } catch (ForumException $exception) {
            $this->app->redirectWithError($exception->getMessage());
        }
    }

    /**
     * @param $params
     *
     * �������� ��������� (����������� =))
     */
    public function removeCommentAction($params)
    {

        $request = $this->app->request;

        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }


            if (!$this->user->canCommentDelete()) {
                throw new ForumException('��� ����');
            }

            $get_topic = $params[0];
            $get_post = $params[1];
            $comment_number = $this->app->request->get('comment_number');

            $post = Forum::find($get_post);

            if (!$post) {
                throw new ForumException('���� �� ������');
            }

            $pal_comments = $post->pal_comments;

            unset($pal_comments[$comment_number]);

            $post->pal_comments = !empty($pal_comments) ? array_values($pal_comments) : null;
            $post->save();

            $this->app->flash('noty', [
                'type' => 'success',
                'msg' => '����������� ������',
                'id' => $post->id,
            ]);

            $this->app->redirect($request->getReferer());

        } catch (ForumException $exception) {
            $this->app->redirectWithError($exception->getMessage());
        }

    }
}