<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }


$baff_name='������ ���������';
$baff_type=1732;//819-��������

if ($user['battle'] != 0) 
{	
	echo "��� �� ������ �����..."; 
}
elseif ($user['trv'] != 0) 
{	
	echo "�� ��� �������� �� �����..."; 
}
else {
	$get_imun_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}'  and type='819' ; "));
		if (($get_imun_baff[id] > 0) )
			{
			err("�� ������� ������������ ��� ��������  ����� ".floor(($get_imun_baff['time']-time())/60/60)." �. ".round((($get_imun_baff['time']-time())/60)-(floor(($get_imun_baff['time']-time())/3600)*60))." ���.");
			}
		else
		{
			mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`='1999999999', `lastup`=1 ,`owner`='{$user[id]}' ;");
			if (mysql_affected_rows()>0)
				{
			mysql_query("UPDATE `users` SET `trv`='1' where `id`='{$user['id']}';");
			mysql_query("INSERT INTO `effects` SET `type`='819',`name`='�������� �� ������������� ������ ���������',`time`='".(time()+6*60*60)."',`owner`='{$user[id]}' ;");//6����� ��������
		
			 $mag_gif='<img src=i/magic/2n2.jpg>';
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
				echo "��� ������ ������! �� ���������� �� ����� �� ��������� ���!";
				$MAGIC_OK=1;
				}
			
		}


	} 
	



?>
