<?php

use \components\Helper\TimeHelper;
/**
 * Created by PhpStorm.
 * User: me
 * Date: 14.10.2018
 * Time: 01:41
 *
 * @var \components\models\clanTournament\ClanTournamentRequest[] $requests
 * @var boolean $canAccept
 */ ?>
<style>
    #page-wrapper a.btn {
        color: black;
        height: 20px;
        background-repeat: no-repeat;
        line-height: 11px;
    }
    #tournament-request {
        min-width: 1150px;
    }
</style>
<div id="znahar-wrapper" class="container-wrapper">
    <div class="title">
        <div class="h3">
            �������� ������
        </div>
        <div id="buttons">
            <a class="button-mid btn" href="<?= $app->urlFor('clan.tournament', array('action' => 'index')) ?>" title="��������">��������</a>
            <a class="button-mid btn" href="<?= $app->urlFor('clan.tournament', array('action' => 'exit')) ?>" title="���������">���������</a>
        </div>
    </div>
    <div>

    </div>
    <div class="container-fluid" id="tournament-request">
        <div class="row">
            <div class="col-8">
				<?php foreach ($app->flashData() as $type => $message): ?>
                    <div class="alert alert-<?= $type ?>">
						<?= $message; ?>
                    </div>
				<?php endforeach; ?>
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr class="head-line">
                        <th>
                            <div class="head-left"></div>
                            <div class="head-title">������� ������� � �������</div>
                            <div class="head-right"></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd">
                        <td>
                            <ul>
								<?php foreach ($requests as $request): ?>
                                    <li>
                                        <div class="date"><?= (new DateTime())->setTimestamp($request->created_at)->format('Y-m-d H:i:s') ?></div>
                                        <em>������� ������ �� ������ <strong>"<?= $request->comment ?>"- ����: <?= $request->getLigaName() ?></strong></em>
										<?php if($canAccept && !$request->user): ?>
                                            <a href="<?= $app->urlFor('clan.tournament', ['action' => 'accept', 'tid' => $request->id]) ?>" class="btn button-big">������� �������</a>
										<?php endif; ?>
                                        <div class="mhint">����������: <?= $request->users_count; ?> (������ �������� ����� <?= TimeHelper::prettyTime(null, $request->started_at) ?>)</div>
                                    </li>
								<?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <div style="color: red;font-style: italic;">
                                <div>
                                    1. �� ������ ���������� � ���� ������� �� ������ ������ �������
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table" cellspacing="0" cellpadding="0">
                    <thead>
                    <tr class="head-line">
                        <th>
                            <div class="head-left"></div>
                            <div class="head-title">������� ��������</div>
                            <div class="head-right"></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd">
                        <td>
                            <div style="text-align: center;">
                                ������� ���� ������
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-4">

            </div>
        </div>
    </div>
</div>
<script>
    setInterval(function(){window.location.reload();}, 20 * 1000);
</script>