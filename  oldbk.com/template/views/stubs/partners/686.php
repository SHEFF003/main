<?php
$ext_meta_id = (int)($_GET['ext_meta_id']);
$price_rur = 35; // � ���� � ������, � ����� ������ ��� ��������� 20
$hash = md5("'$price_rur'33689"); // � ���-���, ������� ����������� �� �������: md5("'$price_rur'60039")
$target[663] = 517;
$target[685] = 518;
$target[686] = 519;
$target_id = $target[$_REQUEST['pid']];
//	���� target_id ������ � ���������� �� ����� ����� ������������ � ��������������� �������� "���� 1", "���� 2", ... , "���� N".
//��������! ��� ���������� ���-���� �������� �������� �� ������������ � ��� �������. ��������� ������ ���������� � ��������� ��������: md5("'0.09'60039")
//�������� ���������� ���������� ���������� ����� 10 �����.
$linklux = "http://luxup.ru/extmeta/?ext_meta_id={$ext_meta_id}&lx_price={$price_rur}&user_id=37563&lx_price_hash={$hash}&target_id={$target_id}";
$fd = fopen($linklux, "r");
fclose($fd);