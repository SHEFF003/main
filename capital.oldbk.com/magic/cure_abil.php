<?php
if ($user['battle'] > 0) {
	echo "�� � ���...";
}
else
if ($user['hp']==$user['maxhp'])
	{
	echo "�� � ��� ����� ���...";
	}
elseif ($user['in_tower'] == 1) {echo "�� � ����� ������!";}
elseif ($user['in_tower'] == 2) {echo "�� � ������!";}
else
{
	if (!($_SESSION['uid'] >0)) header("Location: index.php");
	mysql_query("UPDATE `users` SET `hp`=`maxhp` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");

	echo "<font color=red><b>�� ��������� �������� �� �������...</b></font>";
	$bet=1;
	$sbet = 1;
}
?>