<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='��� ������';
$baff_type=430;

	//. ��������� ����  �� �� ��� ��� ������ ����
$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and type='{$baff_type}' ; "));
if ($get_test_baff[id] > 0) {

	err('�� ��� ��� ���� ��� ��������!');
}
elseif (($user['battle'] == 0) and ($magic['us_type']==1)) {
	err('����� ������������ ������ � ���!');
}
elseif ($user['in_tower'] != 0) {
	err('����� ��� �� ��������!');
} else {
	$magictime=1999999999; //������ ������

	$prc[100430]=0.5; //50%
	$prc[100431]=0.7; //70%
	$prc[100432]=0.9; //90%	
	
	$prc=$prc[$rowm['prototype']];
	
	if ($prc>0)
	{
		mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}', battle='{$user['battle']}' , lastup='1' ,add_info='{$prc}' ,`name`='{$baff_name}',`time`='{$magictime}',`owner`='{$user[id]}';"); // 1 ������
		if (mysql_affected_rows()>0) {
			$bet=1;
			$sbet = 1;
			echo "������������ �������! ������� ������ �{$baff_name}�.<br>";
			$MAGIC_OK=1;

		  	//����� � ��� ���� ����
			if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
			elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
		
			addlog($user['battle'],"!:X:".time().':'.nick_new_in_battle($user).':'.(($user[sex]*100000)+$rowm['prototype'] )."\n");  	
       	       			
		}
	}
	else
		{
		echo "������ ������!";
		}
} 
	



?>
