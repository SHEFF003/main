<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$targ=($_POST['target']);
$baff_name='�����������';
$baff_type=846;//847

if ($user['battle'] != 0) 
{	
	echo "��� �� ������ �����..."; 
}
else {

$HH=(int)(date("H",time()));
if (($HH>=9) and ($HH<21))
	{
	//echo "����";
	$get_imun_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}'  and type='847' ; "));
		if (($get_imun_baff[id] > 0) )
			{
			err("�� ������� ������������ ��� ��������  ����� ".floor(($get_imun_baff['time']-time())/60/60)." �. ".round((($get_imun_baff['time']-time())/60)-(floor(($get_imun_baff['time']-time())/3600)*60))." ���.");
			}
		else
		{
		$us = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
		
		if ($us[id]==$user[id])
			{
			err('������ ������������ �� ����!');
			}
 		elseif ($us['battle'] > 0) 
 			{
			err("�������� � ���...");
			}
		elseif ($user['room'] != $us['room']) 
			{
			err("�������� � ������ �������!");
			}
		elseif ($user['id_city'] != $us['id_city']) 
			{
			err("�������� � ������ ������!");
			}	
		elseif ($us['ldate'] < (time()-60)) 
			{
			err("�������� �� � ����!");
			}
		else
			{
			$travma = mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$us['id']."' AND (`type`='11' OR `type`='12' OR `type`='13' );");
				if (!$travma) 
				{
				err("� ��������� ��� �����...");
				}
				else			
				{
				
				while ($owntravma=mysql_fetch_array($travma)) 
					{
					if ($owntravma['time']-15*60<=time())
						{
						deltravma($owntravma['id']);
						$good=1;
						}
					}
				
					if ($good==1)
					{
					mysql_query("INSERT INTO `effects` SET `type`='847',`name`='�������� �� ������������� �������� �����������',`time`='".(time()+1*60*60)."',`owner`='{$user[id]}' ;");//1 ����� ��������
					
					//������ ������
					mysql_query("UPDATE `users` SET  `sila`=`sila`-'50' WHERE `id` = '".$user[id]."' LIMIT 1;");
					mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$user[id]."','�����������',".(time()+2*60).",14,'50','0','0','0');");
					
					 $mag_gif='<img src=i/magic/6n1.jpg>';
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
					echo "��� ������ ������!";
					$MAGIC_OK=1;
					}
					else
					{
					err('� ��������� ������ �������� ����� ��� �� 15 �����');
					}
				}
			}
			
		}

	}
	else
	{
	err('����� ������������ ������ ����!');
	}
} 




?>
