<?php
// ����� "��� �����"
if (rand(1,100)!=1) {
	
	if (!($_SESSION['uid'] >0)) header("Location: index.php");
	
	mysql_query("UPDATE `users` SET `hp`=`maxhp` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
	
	echo "<font color=red><b>�� ���������� ���� ����...<b></font>";
	$bet=1;
	$sbet = 1;
}
?>