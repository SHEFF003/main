#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php"; //CAPLITAL CITY ONLY
if( !lockCreate("cron_weeks_job") ) {
    exit("Script already running.");
}
//������ ����� 1 ��� � 00 ������ �����������

	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$tstart = $mtime;
	$ckl=0;
	//���� �������� �����
	$get_active=mysql_fetch_array(mysql_query("select * from ivents where stat=1"));
	if ($get_active['id']>0)
		{
		$last_a_id=$get_active['id'];
		unset($arr_ivents[$last_a_id]);
		$ckl=$get_active['cc'];
		//��������� 
		echo "��������:".$get_active['nazv'];
		mysql_query("update ivents set stat=0, last_finish=NOW(), cc=cc+1 where id='{$get_active['id']}' ");
		if (mysql_affected_rows()>0)
			{
			echo " - ok";
			}
		echo "\n";
		}


	echo "������� ����� �����:";
	$get_new=mysql_fetch_array(mysql_query("select * from ivents where cc<='{$ckl}' and `off`=0 and last_finish<(now()-INTERVAL 15 DAY) order by cc , rand()  limit 1")); //��������� �� ������� ������ ������� ������������� ��������� 15 ���� �.�. �� ������ ���� 3 ��. 1 �� ��� ��������� ������ ���

	
		if ($get_new['id']>0)
		{
		echo $get_new['id']." - ".$get_new['nazv'];
		echo "\n";
		}
		else
		{
		echo " ���� ������ ��� � ����� ����� ";
		echo "\n";
			$get_new=mysql_fetch_array(mysql_query("select * from ivents where `off`=0 and  last_finish<(now()-INTERVAL 15 DAY) order by rand() limit 1")); //��������� �� ������� ������ ������� ������������� ��������� 15 ���� �.�. �� ������ ���� 3 ��. 1 �� ��� ��������� ������ ���		
			
			if ($get_new['id']>0)
				{
				echo $get_new['id']." - ".$get_new['nazv'];
				echo "\n";
				}
				else
				{
				echo "������ ���������� ������!";
				echo "\n";
				}
		}
		
		if ($get_new['id']>0)
		{
		//��������
		mysql_query("update ivents set stat=1 where id='{$get_new['id']}' ");
		}

	/*
	������ �� ������ ������ 12 �������. ������ ���� �������� ���, ���� ����� ���� ���� ��������� ������ ���� ��������� ������ � ���� �� ����� ��������� � ���.
	������ ��������, 12 ���� � �����. ������ �������� ������ ����� � ��������. ����� �������� �� ���������� 11 � ��������, ����� �� 10��.. � ��� ���� �� �������� ����. ����� ��� �������.
	��������� 2 ������ � ����� ������������ � ������ 2 ������ � ����� ����� ��� � ������� �� ��������� (���� �� ���������� ���������� ���� �� ������)
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

lockDestroy("cron_weeks_job");
?>