<?php

$us = mysql_fetch_array(mysql_query("SELECT *  FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
$magic = mysql_fetch_array(mysql_query("SELECT `chanse` FROM `magic` WHERE `id` = '15' ;"));
$effect = mysql_fetch_array(mysql_query("SELECT `time` FROM `effects` WHERE `owner` = '{$us['id']}' and `type` = '2' LIMIT 1;"));

if ($user['intel'] >= 1 && $klan_abil != 1) {
		$int=$magic['chanse'] + ($user['intel'] - 1)*3;
		if ($int>98){$int=99;}
	}
	elseif($klan_abil==1)    //���� ������� ��� ������ (�������� �� �����, ���� 100%)
	{
		$int=101;
	}
else {$int=0;}
if ($CHAOS==1) { $int=101; }

if (($us['room']==23) OR ($user['room']==23))
	{
	//��������
	 if ((test_lic_mag($us)) AND ($us['room']==23))
	 	{
	 	$candoit=false;
		 }
		 else
		 {
		 $candoit=true;
		 }

	 if ((test_lic_mag($user)) AND ($user['room']==23))
	 	{
	 	$candoit2=false;
		 }
		 else
		 {
		 $candoit2=true;
		 }		 
		 
	}
	else
	{
	$candoit=true;
	$candoit2=true;	
	}


if ($candoit2==false) { echo "� �������� ���������� ��� ������� �������� �������� ��������!"; }
elseif ($candoit==false) { echo "� �������� ���������� �� ���� ������ �������� �������� ��������!"; }
elseif (($user['battle'] > 0) and  ($user['id'] !=12) and ($user['id'] !=190672)) {echo "�� � ���...";}
elseif ($effect['time']) {echo "�� ��������� ��� ���� �������� ��������"; }
elseif ($user['room'] != $us['room']) { echo "�������� � ������ �������!"; }
elseif ($us['odate'] < (time()-60) ) {echo "�������� �� � ����!";}
elseif ($us['hidden'] >0 ) {echo "�������� �� � ����!";}
elseif ($us['deal'] >= 1) { echo "�� �� ������ �������� �������� �������� �� ����� ���������"; }
elseif ($us['klan'] =='pal') { echo "�� �� ������ �������� �������� �������� �� ����� ���������"; }
elseif ($user['klan'] =='pal') { echo "�� �� ������ �������� �������� �������� ���� �������"; }
elseif ($us['align'] > 2 && $us['align'] < 3) { echo "�������� ������� ���� �� ������?.."; }
elseif ($us['id'] ==12) { echo "�������� ������� ���� �� ������?.."; }
elseif (rand(1,100) < $int) {

			$nick = nick7($user['id']);
			addch("<img src=i/magic/sleep.gif>�������� &quot;{$nick}&quot; ������� �������� �������� �� &quot;{$_POST['target']}&quot;, ������ 30 ���.",$user['room'],$user['id_city']);

			$juser = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
			mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$juser['id']."','�������� ��������',".(time()+1800).",2);");
			mysql_query("UPDATE users set slp=1 where id={$juser['id']} ;");
				echo "<font color=red><b>�� ��������� \"{$_POST['target']}\" �������� �������� �������� </b></font>";
				$bet=1;
				$sbet = 1;

} else {
				echo "������ ���������� � ����� �����...";
				$bet=1;
			}
?>