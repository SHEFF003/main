<?php 
	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die();}
if ($user['maxmana']==$user['mana'])	
	{
	echo "<font color=red><b>� ��������� � ��� ������ �����  ���������� �������!<b></font>";
	}
elseif ($user['battle']>0)	
	{
	echo "<font color=red><b>�� � ���...<b></font>";
	}
else
	{
	mysql_query("UPDATE `users` SET `mana`=`maxmana` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
	echo "<font color=red><b>�� ��������� ���������� �������!<b></font>";
	$bet=1;
	$sbet = 1;
	}
?>