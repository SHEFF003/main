<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='������� ������';
$baff_type=804;//803-������

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
else {
	
	
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type=803 ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��� ������������ ��� ��������, �������� ��� ���������!');
	}
	else
	 {
	 $my_t=$user[battle_t];
	 $my_baff_t='t'.$my_t.'_baff_804';
	 $get_imun_baff= mysql_fetch_array(mysql_query("select * from battle_data where battle='{$user[battle]}' ; "));
	if ( ($get_imun_baff[$my_baff_t]+60*60) > time())
		{
		$ltm=($get_imun_baff[$my_baff_t]+60*60);
		err("�� ������� ������������ ��� ��������  ����� ".floor(($ltm-time())/60/60)." �. ".round((($ltm-time())/60)-(floor(($ltm-time())/3600)*60))." ���.");
		}
		else
		{
		//2. ���������  ������� ���� ��� � ���� ��� ������������� ��� ���������� 
		$get_count_baff=mysql_query("select  * from effects where battle='{$user[battle]}' and type=803  and owner in (select id from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp >0); ");
		$kow=0;
		while ($baff_owners = mysql_fetch_array($get_count_baff))
			   	{
				$kow++;
				$remem_own[$kow]=$baff_owners[owner];
				$remem_time[$kow]=$baff_owners[time];
				$remem_baff_id[$kow]=$baff_owners[id];
			   	}
		
			if ($kow==0)
			{
			//������ � �������
				mysql_query("INSERT INTO `effects` SET `type`='803',`name`='������ ������� ������', `time`='".(time()+60)."', `owner`='{$user[id]}',`battle`='{$user[battle]}';");//1 ������
				if (mysql_affected_rows()>0)
				{
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>. <i>(����� ����...)</i> <BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(����� ����...)</i>\n");
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			}
			else if ($kow==1)
			{
			//���� 1 � ���������
				mysql_query("INSERT INTO `effects` SET `type`='803',`name`='����������� ������� ������',`time`='".$remem_time[1]."',`owner`='{$user[id]}',`battle`='{$user[battle]}';");//����� ��������� � ������ ������
				if (mysql_affected_rows()>0)
				{

					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>. <i>(��������� ����...)</i> <BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(��������� ����...)</i>\n");
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			}
			else
			{
			   $data_battle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user[battle]} ; "));
			
			//���� ���� � ������� � ������� ���
			//������� ������ ����
			foreach($remem_own as $ic=>$owner)
				{
				mysql_query("DELETE from effects where `type`='803' and owner='{$owner}' and battle='{$user[battle]}'  ;"); 	
				}	

				//������ �������� ���� ����� � ���� ������� � �� ��������� � �� ���������
				$get_all_life=mysql_query("select * from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp>0 and hidden=0");
				while ($my_owner = mysql_fetch_array($get_all_life))
						{
						 $idiluz=mt_rand(10,99).date("H").mt_rand(1,9).date("i").mt_rand(1,9).date("s");
						 $du=$data_battle[timeout]*2*60;
						mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`idiluz`) values ('".$my_owner['id']."','������� �����������',".(time()+$du).",200,'".$idiluz."');");
						mysql_query("UPDATE `users` SET `hidden`='{$idiluz}' where `id`='{$my_owner['id']}';");
						}
				
				//������ ��������� �� 
				mysql_query("INSERT INTO `battle_data` SET battle='{$user[battle]}' , {$my_baff_t}=".time()."  ON DUPLICATE KEY UPDATE  {$my_baff_t}=".time()." ; ");
				
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, <i>(������ ����...)</i> <BR>');								
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(������ ����...)</i>\n");
		       	       
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				
			   }
			   
			}
		}	
		


	} 
	



?>
