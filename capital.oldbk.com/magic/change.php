<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='�������������� ����� ����������';
$baff_type=796;

	//. ��������� ����  �� �� ��� ��� ������ ����
$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and type='{$baff_type}' ; "));
if ($get_test_baff[id] > 0) {

	err('�� ��� ��� ���� ���� ������!');
}
elseif (($user['battle'] > 0) and ($magic['us_type']==2)) {
	err('����� ������������ ������ ��� ���!');
}
elseif ($user['in_tower'] != 0) {
	err('����� ��� �� ��������!');
} else {
	$magictime=1999999999; //������ ������

	$prc[796]=3;  //+3 c����

	$prc_add=$prc[$rowm['prototype']];

	
	
	if ($prc_add>0)
	{
		mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}', add_info='{$rowm['img']}:{$prc_add}:{$prc_mf}' ,`name`='{$baff_name}',`time`='{$magictime}',`owner`='{$user[id]}';"); 
		if (mysql_affected_rows()>0) 
		{
			$bet=1;
			$sbet = 1;
			echo "������������ �������! ������� ������ �{$baff_name}�.<br>";
			$MAGIC_OK=1;
		}
	}
	else
		{
		echo "������ ������!";
		}
} 
	



?>
