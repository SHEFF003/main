<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php");die();}
	if ($user[level] !=$magic[nlevel]) 
	{
	err('�� �� ������ ������������ ��� ��������, ������������ �������!');
	}
	else
	{
	//��������� �� ������ ��������
	$get_lic=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and type in (40000,2000,30000)  ;"));
	if ($get_lic['id']>0)
	{
	err('�� �� ������ ������������ ��� ��������, � ��� ��� ���� �������� ������� ����!');
	}
	else
	{
	
	//1. �������� �������
	$get_eff=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and type=50000;"));
	$duration=$magic['time']*60;
	 if ($get_eff[id]>0)
	 	{
	 	//����
		mysql_query("INSERT INTO `effects` (`id`,`owner`,`name`,`time`,`type`) values ('{$get_eff[id]}','".$user['id']."','�������� ����',".(time()+$duration).",50000) ON DUPLICATE KEY UPDATE `time`=`time`+{$duration};");
		mysql_query("INSERT INTO oldbk.users_perevod  (`owner`,`val`,`lday`,`lim`) values ('{$user['id']}',0,CURDATE(),'-1') ON DUPLICATE KEY UPDATE `lim`=-1");
		err('������ �������� �������� ����!');
		$bet=1;
		$sbet=1;
	 	}
	 	else
	 	{
		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','�������� ����',".(time()+$duration).",50000);");
		mysql_query("INSERT INTO oldbk.users_perevod  (`owner`,`val`,`lday`,`lim`) values ('{$user['id']}',0,CURDATE(),'-1') ON DUPLICATE KEY UPDATE `lim`=-1");		
		err('������ ������� �������� ����!');
		$bet=1;
		$sbet=1;		
	 	}
	 }
	}
?>