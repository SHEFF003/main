<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$sub_name[3]='������';
$sub_name[2]='�����������';
$sub_name[6]='�������';
$sub_name[0]='�����';
$get_align=(int)($user[align]);
if ($get_align==1) {$get_align=6;}

$baff_name=$sub_name[$get_align].' ���������';
$baff_type=830;//831/832/833

$can_use_rooms=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,26,36,50,51,52,53,54,55,56,57,66);

if ($user['battle'] != 0) 
{	
	echo "��� �� ������ �����..."; 
}
elseif (!(in_array($user[room],$can_use_rooms)))
{
err('������������ ����� ��� ���������');
}
elseif($user[zayavka]>0)
{
err('������������ ����� ��� ���������, �� � ������ �� ���!');
}
else {
	$get_imun_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}'  and type='833' ; "));
		if (($get_imun_baff[id] > 0) )
			{
			err("�� ������� ������������ ��� ��������  ����� ".floor(($get_imun_baff['time']-time())/60/60)." �. ".round((($get_imun_baff['time']-time())/60)-(floor(($get_imun_baff['time']-time())/3600)*60))." ���.");
			}
		else
		{
			mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`='".(time()+3600)."',`owner`='{$user[id]}' ;");
			if (mysql_affected_rows()>0)
				{
			mysql_query("INSERT INTO `effects` SET `type`='833',`name`='�������� �� ������������� ���������',`time`='".(time()+28800)."',`owner`='{$user[id]}' ;");//8 ����� ��������
			
			 if ($get_align==0) 
			 {
			 mysql_query("update effects SET `time`=FLOOR(".time()."+((`time`-".time().")*0.5)) , eff_bonus=1 where (type=11 OR  type=12 OR type=13 OR type=14) and eff_bonus=0 and owner='{$user[id]}' ;");
			 }
			
			
			 $mag_gif='<img src=i/magic/'.$get_align.'n5.jpg>';
			 if(($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
			 {
			 $fuser['login']='<i>���������</i>';
			 $sexi='�����������';
			 }
			 else
			 {
			 $fuser=load_perevopl($user); //�������� � �������� ��������� ���� ����
			 if ($fuser['sex'] == 1) {$sexi='�����������';  }	else { $sexi='������������';}
			 }
			addch($mag_gif." <B>{$fuser['login']}</B> ����������� ����� &quot;".$baff_name."&quot;",$user['room'],$user['id_city']);
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������! �� �����������!";
				$MAGIC_OK=1;
				}
			
		}


	} 
	



?>
