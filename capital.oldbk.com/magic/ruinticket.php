<?
if (!($_SESSION['uid'] >0)) header("Location: index.php");

$q = mysql_query("SELECT * FROM `ruines_var` WHERE  `var`='cango' and `owner`='".$user[id]."';");
if (mysql_num_rows($q) > 0) {
	$pr = mysql_fetch_assoc($q);

	if ($pr['val']-time() > 8*3600) {
		echo "���-�� �� ���������...";
	} else {
		mysql_query("DELETE FROM `ruines_var` WHERE  `var`='cango' and `owner`='".$user[id]."';");
		echo "�� ������������ ������� � �����...<i>��������� ���� �������.</i>";
		$bet=1;
		$sbet = 1;
	}
} else {
	echo "����� � ��� ������� ��� ���...</i>";
}
?>