<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }


$baff_name='�������';
$baff_type=848;//849

if ($user['battle'] != 0) 
{	
	echo "��� �� ������ �����..."; 
}
else {
	$get_imun_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}'  and type='849' ; "));
		if (($get_imun_baff[id] > 0) )
			{
			err("�� ������� ������������ ��� ��������  ����� ".floor(($get_imun_baff['time']-time())/60/60)." �. ".round((($get_imun_baff['time']-time())/60)-(floor(($get_imun_baff['time']-time())/3600)*60))." ���.");
			}
		else
		{
		
			mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`='".(time()+(60*60))."', `owner`='{$user[id]}' ;");
			if (mysql_affected_rows()>0)
				{
			mysql_query("INSERT INTO `effects` SET `type`='849',`name`='�������� �� ������������� �������� �������',`time`='".(time()+24*60*60)."',`owner`='{$user[id]}' ;");//24 ����� ��������
		
			 $mag_gif='<img src=i/magic/2n3.jpg>';
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
			addch($mag_gif." <B>{$fuser['login']}</B> {$sexi} ����� &quot;".$baff_name."&quot;",$user['room'],$user['id_city']);
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			
		}


	} 
	



?>
