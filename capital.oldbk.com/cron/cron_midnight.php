#!/usr/bin/php
<?php
ini_set('display_errors','On');
$CITY_NAME='capitalcity';
include "/www/".$CITY_NAME.".oldbk.com/cron/init.php";
require_once("/www/".$CITY_NAME.".oldbk.com/config_ko.php");
if( !lockCreate("cron_midnight_job") ) {
    exit("Script already running.");
}
echo date("d.m.y H:i:s").'\r\n';
$gotime=time(); //����� �������

//������ �������	 ������� � 0
mysql_query("UPDATE `variables` SET `value`=0 WHERE `var`='lab_key_count_d' ");	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ������ � 00:03:00 - ������ 
////////////////�������� ���������� ���� ��� ����� ����
//1. ������ �� ���� ���� � ���� ������������ �� ������� ������� � ��� - ������ 24-� �����
mysql_query("delete from users_timer where (UNIX_TIMESTAMP(tbattle)<UNIX_TIMESTAMP()-86400) AND (UNIX_TIMESTAMP(ttime)<UNIX_TIMESTAMP()-86400)");
echo "\n ������� ������:".mysql_affected_rows();


//��������� ���� ��� � 0 ��� ������� ��������  �� ����
mysql_query("update  users_timer set   cbattle=0, ctime=0,  cday=0 where  getflag=0;   ");
echo "\n ��������� ���� ��������� :".mysql_affected_rows();

// ������� ���� ������ 7 - ��� �������� �� ������ ����
//���� ����� ��� 6� ���� � ������ ������� ����� 24� ����� �����
//������ �� ��� � 0 � ��� ����
//mysql_query("update  users_timer set   cbattle=0, ctime=0,  getflag=0 , cday=0 where  cday=6 and  getflag=1 AND   (UNIX_TIMESTAMP(tday)<=UNIX_TIMESTAMP()-86400)");
mysql_query("update  users_timer set   cbattle=0, ctime=0,  getflag=0 , cday=0 where  cday=6 and  getflag=1 "); //��� ������� �.�. ���� ��������� �.�. ����������� 1 ��� ������
echo "\n �������� � 6�� �� 0 ����:".mysql_affected_rows();
///������� �� ����� ����� , ���� ��� ������� ������� �� ���������� ���� � ����� ��� ������ ���� ����� ����� �����
//mysql_query("update  users_timer set   cbattle=0, ctime=0,  getflag=0 , cday=cday+1 where  getflag=1 AND   (UNIX_TIMESTAMP(tday)<=UNIX_TIMESTAMP()-86400)");


mysql_query("update  users_timer set   cbattle=0, ctime=0,  getflag=0 , cday=cday+1 where  getflag=1 "); //��� ������� �.�. ���� ��������� �.�. ����������� 1 ��� ������
echo "\n ���������� �� ��������� ����:".mysql_affected_rows();

//��������� ���� ���������
mysql_query("update  users_timer set   cbattle=0, ctime=0");
echo "\n ��������� ���� ��������� :".mysql_affected_rows();
echo "-------------------------------\n";



lockDestroy("cron_midnight_job");
?>