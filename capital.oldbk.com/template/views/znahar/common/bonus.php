<?php
use components\models\effect\Element;
use components\Helper\StringHelper;

/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.11.2015
 *
 * @var \components\models\User $user
 * @var boolean $isHaveZnaharStats
 */ ?>

<table class="table border" cellspacing="0" cellpadding="0">
    <colgroup>
        <col width="20%">
        <col width="20%">
        <col width="20%">
        <col width="20%">
        <col width="20%">
    </colgroup>
    <thead>
    <tr class="head-line spoiler-block">
        <th colspan="5">
            <div class="head-left"></div>
            <div class="head-title">�������������� ����� ��� ���������</div>
            <div class="head-right"></div>
            <a class="spoiler right spoiler-down" href="javascript:void(0);"></a>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr class="even hidden">
        <td colspan="5">
            �� ������ �������� � ����� ��������������� �������������� ��� �������� ��������� ��������� ��������������. ������ ������ 5 �����, �� ����� ��� �������� ������������ ��������� ����������.
        </td>
    </tr>
    <tr class="odd hidden">
        <td colspan="5" align="center">
            <?php if($isHaveZnaharStats): ?>
                <a href="<?= $app->urlFor('znahar', array('action' => 'dropbonus'))?>" class="button-mid btn" title="��������">��������</a>
            <?php else: ?>
                <a href="<?= $app->urlFor('znahar', array('action' => 'addbonus'))?>" class="button-mid btn" title="������������">������������</a>
            <?php endif; ?>
        </td>
    </tr>
    </tbody>
</table>
