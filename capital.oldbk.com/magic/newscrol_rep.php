<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='���������� ���������� ���������';
$baff_type=9100;

	//. ��������� ����  �� �� ��� ��� ������ ����
$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and type='{$baff_type}' ; "));
if ($get_test_baff[id] > 0) {

	err('�� ��� ��� ���� ��� ��������!');
}
elseif (($user['battle'] > 0) and ($magic['us_type']==2)) {
	err('����� ������������ ������ � ���!');
}
elseif ($user['in_tower'] != 0) {
	err('����� ��� �� ��������!');
} else {

	$magictime=time()+($magic['time']*60);

	$prc[19010]=0.1; 	
	$prc[19020]=0.2; 	

	$prc=$prc[$rowm['prototype']];

	
	
	if ($prc>0) 
	{
		mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',  add_info='{$rowm['img']}:{$prc}' ,`name`='{$baff_name}',`time`='{$magictime}',`owner`='{$user[id]}';"); 
		if (mysql_affected_rows()>0) {
		mysql_query("UPDATE `users` SET `rep_bonus`=`rep_bonus`+'{$prc}' WHERE `id`='{$user['id']}'  ");
			$bet=1;
			$sbet = 1;
			echo "������������ �������! ������� ������ �{$baff_name} +".($prc*100)."%�.<br>";
			$MAGIC_OK=1;
       	       			
		}
	}
	else
		{
		echo "������ ������!";
		}
} 
	



?>
