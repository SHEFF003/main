<?php
use components\Helper\StatsHelper;

/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.11.2015
 *
 * @var int $need_money_stat
 * @var int $free_stats_have
 * @var int $need_money_all_masters
 * @var \components\Component\Slim\Slim $app
 * @var \components\models\user\UserZnahar $user
 */ ?>

<tr class="odd">
    <td>
        <table class="stats">
            <colgroup>
                <col width="100px">
                <col width="50px">
                <col width="100px">
                <col width="50px">
            </colgroup>
            <tbody>
            <tr>
                <td><?= StatsHelper::$stats['sila'] ?></td>
                <td>
                    <strong><?= $user->sila ?></strong>
                </td>
                <td>
                    <?= StatsHelper::$stats['intel'] ?>
                </td>
                <td>
                    <strong><?= $user->intel ?></strong>
                </td>
                <td></td>
            </tr>
            <tr>
                <td><?= StatsHelper::$stats['lovk'] ?></td>
                <td>
                    <strong><?= $user->lovk ?></strong>
                </td>
                <td>
                    <?= StatsHelper::$stats['mudra'] ?>
                </td>
                <td>
                    <strong><?= $user->mudra ?></strong>
                </td>
                <td></td>
            </tr>
            <tr>
                <td><?= StatsHelper::$stats['inta'] ?></td>
                <td>
                    <strong><?= $user->inta ?></strong>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><?= StatsHelper::$stats['vinos'] ?></td>
                <td>
                    <strong><?= $user->vinos ?></strong>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5">
                    <form id="form-change" action="<?= $app->urlFor('znahar', array('action' => 'move')) ?>" method="post">
                        ���������
                        <select name="from">
                            <?php foreach(StatsHelper::getStatsIdName() as $id => $title): ?>
                                <option value="<?= $id ?>"><?= $title ?></option>
                            <?php endforeach; ?>
                        </select> �
                        <select name="target">
                            <?php foreach(StatsHelper::getStatsIdName() as $id => $title): ?>
                                <?php
                                    $key = StatsHelper::getKeyById($id);
                                    $add = '';
                                    if($free_stats_have || $need_money_stat == 0)
                                        $add = '0 ��.';
                                    else
                                        $add = $user->getCost($id).' ��.';
                                ?>
                                <option value="<?= $id ?>"><?= $title.' '.$add ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a href="javascript:void(0);" onclick="$('#form-change').submit();" class="button-mid btn" title="���������">���������</a>
                    </form>
                    <div style="color: red;margin-top: 5px;">
                    <?php
                    switch (true) {
                        case $need_money_stat == 0:
                            echo '� ��� �������� ���������� �����������������!';
                            break;
                        case $free_stats_have != 0:
                            echo sprintf('� ��� �������� %d ���������� �����������������!', $free_stats_have);
                            break;
                        default:
                            echo '��������� ���������� ����������������� ����� �������� � ��������� �����������!';
                            break;
                    }
                    ?>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr class="even">
    <td>
        <div>
            �������� ��� �������������� ���������: <strong><?= $need_money_all_stat ?> ��.</strong>
            <a href="<?= $app->urlFor('znahar', array('action' => 'dropstat'))?>" class="button-mid btn" title="��������">��������</a>
        </div>
        <div>
            �������� ��� ������ �������� ������� � ������: <strong><?= $need_money_all_masters ?> ��.</strong>
            <a href="<?= $app->urlFor('znahar', array('action' => 'dropmaster'))?>" class="button-mid btn" title="��������">��������</a>
        </div>
        <div>
            � ��� � �������: <strong><?= $user->money ?></strong> ��.
        </div>
    </td>
</tr>
