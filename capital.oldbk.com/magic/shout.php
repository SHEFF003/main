<?php
		if (!($_SESSION['uid'] >0))
		{
			header("Location: index.php");
			die();
		}

$targ = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
if ($targ[id]>0)
{
	$magic = magicinf(9999);
	$duration = $magic['time']*60;
		
	//������ ���� ��� ������ - �����
	mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`add_info`) values ('".$user['id']."','��������� �����',".(time()+$duration).",9999,'{$targ[login]}');");
	//������ ���� ����  - ����� - ��� ���� ��������� �����
	if ($targ[id_city]==1)
	{
		$eff_city='avalon.';
	}
	else
	{
		$eff_city='oldbk.';
	}
	mysql_query("INSERT INTO ".$eff_city."`effects` (`owner`,`name`,`time`,`type`,`add_info`) values ('".$targ['id']."','��������� �����',".(time()+$duration).",9999,'{$user[login]}');");		
	
	echo "<font color=red><b>�� ������������� ��������� ������� � ".$targ[login]."...</b></font>";
	
	addchp('<font color=red>��������!</font> �� ������������� ��������� ������� � '.$user[login].'','{[]}'.$targ[login].'{[]}',-1,0);
	$bet=1;
	$sbet = 1;


}
else
{
err('�������� �� ������!');
}

?>
