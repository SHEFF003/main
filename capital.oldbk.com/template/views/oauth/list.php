<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 03.11.2015
 *
 * @var array() $user_list
 * @var array() $user_empty
 */ ?>
<style>
    .red {
        color: red;
    }
    ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
</style>
�����: <?= count($user_list); ?>
<table border="1" style="table-layout: fixed">
    <colgroup>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>�����</th>
        <th>��������� ip</th>
        <th>��������� �������� ip</th>
        <th>�����</th>
        <th>����</th>
        <th>���-�� ����</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($user_list as $user_id => $user): ?>
            <tr>
                <td valign="top">
                    <span class="<?= $user['fight'] == 0 ? 'red' : ''; ?>"><?= $user['login'] ?> (<?= $user_id ?>)</span>
                </td>
                <td valign="top">
                    <ul>
                        <?php foreach ($user['ip'] as $ip => $date): ?>
                            <li>
                                <?= $ip ?> (<?= date('d.m.Y H:i:s', $date); ?>)
                            </li>
                        <?php endforeach ?>
                    </ul>
                </td>
                <td valign="top">
                    <ul>
                        <?php foreach ($user['last'] as $ip => $date): ?>
                            <li>
                                <?= $ip ?> (<?= date('d.m.Y H:i:s', $date); ?>)
                            </li>
                        <?php endforeach ?>
                    </ul>
                </td>
                <td valign="top">
                    <?= implode('<br>', $user['lichka']) ?>
                </td>
                <td valign="top">
                    <?= implode('<br>', $user['delo']) ?>
                </td>
                <td valign="top">
                    <?= $user['fight'] ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

������ ������, ������� � ��� ����� ������ �� ������
�����: <?= count($user_empty); ?>
<table border="1" style="table-layout: fixed">
    <colgroup>
        <col>
        <col>
        <col>
        <col>
        <col>
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>�����</th>
        <th>��������� ip</th>
        <th>��������� �������� ip</th>
        <th>�����</th>
        <th>����</th>
        <th>���-�� ����</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($user_empty as $user_id => $user): ?>
        <tr>
            <td valign="top">
                <span class="<?= $user['fight'] == 0 ? 'red' : ''; ?>"><?= $user['login'] ?> (<?= $user_id ?>)</span>
            </td>
            <td valign="top">
                <ul>
                    <?php foreach ($user['ip'] as $ip => $date): ?>
                        <li>
                            <?= $ip ?> (<?= date('d.m.Y H:i:s', $date); ?>)
                        </li>
                    <?php endforeach ?>
                </ul>
            </td>
            <td valign="top">
                <ul>
                    <?php foreach ($user['last'] as $ip => $date): ?>
                        <li>
                            <?= $ip ?> (<?= date('d.m.Y H:i:s', $date); ?>)
                        </li>
                    <?php endforeach ?>
                </ul>
            </td>
            <td valign="top">
                <?= implode('<br>', $user['lichka']) ?>
            </td>
            <td valign="top">
                <?= implode('<br>', $user['delo']) ?>
            </td>
            <td valign="top">
                <?= $user['fight'] ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>