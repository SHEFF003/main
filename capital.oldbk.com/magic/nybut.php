<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die();}
if ($user['hp']==$user['maxhp'])
{
	echo "<font color=red><b>� ��������� � ��� ������ ��!<b></font>";
} elseif ($user['battle']>0) {
	echo "<font color=red><b>�� � ���...<b></font>";
} elseif ($user['room']==402)	{
	echo "<font color=red><b>�� � �������...<b></font>";
} elseif (rand(1,100)!=1) {
	mysql_query("UPDATE `users` SET `hp`=`maxhp` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
	echo "<font color=red><b>�� ������������...<b></font>";
	$bet=1;
	$sbet = 1;
}
?>