<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='����� �� ��� �� 1%';
$baff_type=793;

	//. ��������� ����  �� �� ��� ��� ������ ����
$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and type='{$baff_type}' ; "));
if ($get_test_baff[id] > 0) {
	err('�� ��� ��� ���� ��� ��������!');
} elseif ($user['in_tower'] == 16) {
	err('����� ��� �� ��������!');
} else {
	mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`=1999999999,`owner`='{$user[id]}';");
	if (mysql_affected_rows()>0) {
		$bet=1;
		$sbet = 1;
		echo "��� ������ ������!";
		$MAGIC_OK=1;
	}
} 
	



?>
