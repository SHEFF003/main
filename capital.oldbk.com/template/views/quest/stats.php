<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 08.01.2016
 */ ?>
<style>
    table td {
        text-align: center;
        vertical-align: middle !important;
    }
</style>
<ul>
    <li>TYPE ID: </li>
    <li>1 - ����</li>
    <li>3 - ���</li>
    <li>4 - ������������� �����</li>
    <li>5 - �������</li>
    <li>6 - �������</li>
    <li>7 - ���������</li>
</ul>
<table border="1">
    <thead>
        <tr>
            <th>�����</th>
            <th>����� �����</th>
            <th>���������</th>
            <th>��� � �������� ��� �� ���������</th>
            <th>������� ������</th>
            <th>����� �� ������</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($stats as $quest): ?>
        <tr>
            <td><?= $quest['quest'] ?> (<?= $quest['start'] ?> - <?= $quest['end'] ?>)</td>
            <td><?= $quest['user_count'] ?></td>
            <td><?= $quest['user_count_finished'] ?></td>
            <td><?= $quest['user_process'] ?></td>
            <td><?= count($quest['part']) ?></td>
            <td>
                <ul>
                    <?php foreach ($quest['part'] as $_part): ?>
                        <li>TYPE ID: (<?= $_part['type_id'] ?>): <?= $_part['count']; ?> (Type count:  <?= $_part['need_count'] ?>)</li>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
