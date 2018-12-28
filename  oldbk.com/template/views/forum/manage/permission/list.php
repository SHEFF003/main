<div class="row px-3">
    <div class="col">

        <h4>�����</h4>
        <table class="table table-hover table-responsive">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">�����</th>
                <th scope="col">������</th>
                <th scope="col">�����</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($paladins as $key => $paladin) : ?>
                <tr>
                    <td>
                        <?=$key+1?>
                    </td>
                    <td>
                        <a href="<?=$app->urlFor('manage_user', ['id' => $paladin->id])?>"><?=$this->renderPartial('common/renderuser', ['user' => $paladin->toArray()])?></a>
                    </td>
                    <td>
                        <?=$paladin->status?>
                    </td>
                    <td class="text-center">
                        <? if (!$paladin->moderator || ($paladin->moderator && !$paladin->moderator->permissions)) :?>
                            <span class="badge badge-danger">���</span>
                        <? else: ?>
                            <span class="badge badge-success">����</span>
                        <? endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

<div class="row">
    <div class="col">

        <h4>������ ����������</h4>

        <? if(count($moderators)) : ?>
            <table class="table table-hover table-responsive">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">�����</th>
                    <th scope="col">�����</th>
                    <th scope="col"><span class="oi oi-trash"></span></th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($moderators as $key => $moderator) : ?>
                    <tr>
                        <td>
                            <?=$key+1?>
                        </td>
                        <td>
                            <a href="<?=$app->urlFor('manage_user', ['id' => $moderator->user->id])?>"><?=$this->renderPartial('common/renderuser', ['user' => $moderator->user->toArray()])?></a>
                        </td>
                        <td class="text-center">
                            <? if (!$moderator->permissions) :?>
                                <span class="badge badge-danger">���</span>
                            <? else: ?>
                                <span class="badge badge-success">����</span>
                            <? endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?=$app->urlFor('manage_delete_permission', ['id' => $moderator->user->id])?>" >
                                <img title="������� ����������?" src="/assets/forum/i/clear.gif" width="10" height="10">
                            </a>
                        </td>
                    </tr>

                <? endforeach; ?>
                </tbody>
            </table>
        <? endif; ?>

    </div>
</div>


<div class="row">
    <div class="col-6">

        <form action="" method="get">

            <div class="input-group">
                <input type="text" name="moderator_login" class="form-control" id="moderator_login" aria-describedby="moderHelp" placeholder="����� �� ������">

                <span class="input-group-btn">
                    <input type="submit" class="btn btn-primary" value="�����">
                </span>
            </div>

        </form>

    </div>
</div>



