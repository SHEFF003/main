#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php"; //CAPLITAL CITY ONLY
if( !lockCreate("cron_chat_job") ) {
    exit("Script already running.");
}
//������ ���� ������������ 600 ������ =10 �����

	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$tstart = $mtime;


echo "\n";
mysql_query("delete from chat where `cdate` < DATE_SUB(NOW(), INTERVAL 10 MINUTE)");
echo "������� ����� ������� ����:".mysql_affected_rows();
echo "\n";


echo "������ ������ ��������: \n";
$get_all_ot=mysql_query("select * from tur_stat where start=0 and UNIX_TIMESTAMP(btime) < UNIX_TIMESTAMP()-14400");
while($orow=mysql_fetch_array($get_all_ot))
{
	//������
	print_r($orow);
	mysql_query("UPDATE users set  id_grup=0 where  (id='{$orow['u1']}' or  id='{$orow['u2']}' or id='{$orow['u3']}' ) and id>0  and  id_grup='{$orow['id']}' ");
	mysql_query("DELETE from `tur_stat` WHERE `id`='{$orow['id']}' and  start=0 ");	
}

/*
echo "������ ����:";
mysql_query("delete from battle where id<330000000 limit 50000");

echo mysql_affected_rows();
echo "\n";
echo "������ ���� hist:";
mysql_query("delete from battle_hist where battle_id<330000000 limit 50000");
echo mysql_affected_rows();
echo "\n";
echo "������ ���� battle_hist_hidden:";
mysql_query("delete from battle_hist_hidden where battle_id<330000000 limit 50000");
echo mysql_affected_rows();
echo "\n";
echo "������ ���� battle_time_out:";
mysql_query("delete from battle_time_out where battle<330000000 limit 5000");
echo mysql_affected_rows();
echo "\n";
*/

	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	//���������� ����� ��������� � ������ ����������
	$tend = $mtime;
	//��������� �������
	$totaltime = ($tend - $tstart);
	//�������
echo "����� ������:".$totaltime;
echo "\n";

lockDestroy("cron_chat_job");
?>