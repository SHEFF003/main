<?php
// ����� ������� ��� ����
if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) {
 header("Location: index.php");
 die();
}
if (!$user['battle'] == 0) {	echo "�� � ���..."; }
else
if ($user['ruines'] == 0) {	echo "����� ������������ ������ � ������..."; }
else
{
 mysql_query('INSERT INTO `effects` (`owner`,`name`,`time`,`type`) VALUES ("'.$user['id'].'","����� �������",'.(time()+(60*10)).',605)');
 echo "�� ������ ����� �������...";
 $bet = 1;
 $sbet = 1;
}
?>