<?php


namespace components\Controller\forum;


use Carbon\Carbon;
use components\Eloquent\ForumModerator;
use components\Eloquent\User;
use components\Enum\Forum\ForumPermission;
use components\Exceptions\ForumException;

/**
 * Class ManageForumPermissionController
 * @package components\Controller\forum
 */
class ManageForumPermissionController extends ForumController
{
    /**
     * ������ �����
     */
    public function manageAction()
    {

        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->canManagePermissions()) {
                throw new ForumException('��� ����');
            }

            if ($login = $this->app->request->get('moderator_login')) {

                $user = User::where('login', $login)->first(['id']);

                if (!$user) {
                    throw new ForumException('�������� �� ������');
                }

                return $this->app->redirectTo('manage_user', ['id' => $user->id]);
            }

            $this->app->view()->appendLayoutData([
                'categories' => $this->getCategories(),
            ]);

            $paladins = User::paladins()
                ->with('moderator')
                ->orderByDesc('align')
                ->get();


            $pal_ids = $paladins->pluck('id');

            $moderators = ForumModerator::with('user')
                ->whereNotIn('user_id', $pal_ids)
                ->get();


            //�������� ������
            $this->render('forum/manage/permission/list', [
                'paladins' => $paladins,
                'moderators' => $moderators,
            ]);

        } catch (ForumException $exception) {
            $this->app->redirectWithError($exception->getMessage());
        }


    }

    /**
     * @param $id
     * @return string
     *
     * ������ ����
     */
    public function manageUserAction($id)
    {
        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->canManagePermissions()) {
                throw new ForumException('��� ����');
            }

            $this->app->view()->appendLayoutData([
                'categories' => $this->getCategories(),
            ]);


            $moderator = User::with(['moderator'])
                ->withCount(['moderatorAppeals' => function($q){
                    $q->onlyTrashed();
                    $date = Carbon::now();
                    $q->whereYear('deleted_at', '=', $date->year);
                    $q->whereMonth('deleted_at', '=', $date->month);
                }])
                ->find($id);

            //�������� ������
            return $this->render('forum/manage/permission/user_permission', [
                'moderator' => $moderator,
                'permissions' => ForumPermission::getConstants(),
            ]);

        } catch (ForumException $exception) {
            $this->app->redirectTo('forum');
        }

    }

    /**
     * @param $id
     *
     * ���������� ����
     */
    public function manageUserSaveAction($id)
    {

        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->canManagePermissions()) {
                throw new ForumException('��� ����');
            }

            $post = $this->app->request->post();

            $current_user = User::find($id);

            if (!$current_user) {
                throw new ForumException('��� ������ �����');
            }

            $pal_rights = ForumModerator::updateOrCreate(
                [
                    'user_id' => $current_user->id
                ],
                [
                    'permissions' =>  !empty($post) ? array_keys($post) : NULL,
                ]
            );

            if (!$pal_rights) {
                throw new ForumException('�� ������� ��������� (');
            }

            $this->app->flash('noty', [
                'type' => 'success',
                'msg' => '����� ���������',
            ]);

            $this->app->redirect($this->app->request->getReferer());


        } catch (ForumException $exception) {
            $this->app->redirectWithError($exception->getMessage());
        }
    }

    /**
     * @param $id
     */
    public function manageUserDeleteAction($id)
    {
        try {

            if (!$this->user) {
                throw new ForumException('��� ����');
            }

            if (!$this->user->canManagePermissions()) {
                throw new ForumException('��� ����');
            }


            $moder = ForumModerator::find($id);

            if (!$moder) {
                throw new ForumException('��� ������');
            }

            $moder->delete();

            $this->app->flash('noty', [
                'type' => 'success',
                'msg' => '��������� ������',
            ]);

            $this->app->redirect($this->app->request->getReferer());


        } catch (ForumException $exception) {
            $this->app->redirectWithError($exception->getMessage());
        }

    }
}