<?php
/*
     ������ "������� �������", �������� � "���" � ������� � ��� �� ����������� ������� (������ ����)
         ������������ ������ ����� ������ �� ������ ������� ������ ������ ��� +1 ������� �� ������
         ������ ����� �������� "���� ������� �������", %
     ������ ��������, �� ������� ����� ������������ ������ "������� �������":
         ��� ������ ������� ����� +
         ��� �������+
         ��� �����������+
         ��� ������� ������������ ���������+
  
     ������ ����������� ������ ������:
         �������� �������������� � ������ ���������� ���+
         ��������-����� ������ ���� ��� �� ������ ���������� ���+
         ��������� ��� ������� �� ����������� ����� � �����������, ���� ���� ��������� ���� � ���������� ������, ��������� �� � ��������� ������������������
         � ������ ������ �������� �������� �������� ������ "�������� ������� ...", ��� ��������� ��� ��������� �����������
     �����������
         � ������ ������: �����������! �� ������� ������� <��������_�������>, ������ ������� �������� � ��� ���������.
         � ������ �������: ��� �� ������� ������� �������

 ���� ������ ���������� ������� ������������� ����� ������, ������������ �� ������, ��� ��� �������
�������� ����, ������� ���������� ����������� � ������ �����, �.�. ��������� �� ����� ���� ������, ��� � �������

 15/45/65/95%


 
 

*/



if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$ituse=(int)$_GET['use'];


$bots_laba=array(219,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,241,244,261,262,263,264,265,266,267,268,269,270,271,272,273,274,275,276,277,278,279); 
$bots_drakons=array(42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65); 
$bots_IH=array(102,107,108,109,110,101,103,104,105,106); 
$bots_derevo=array(86,87,89);


if ($magic['id']==122124) //    ���������� ������ �� ������ - �����������, �������, ��, ������� ����������� ����
	{
if ($user['id']==14897) echo "AR1/";	
	$bots_list=array_merge($bots_laba,$bots_drakons,$bots_IH,$bots_derevo);
	}
	elseif ($magic['id']==122123) //    ����� ������ �� ���� - �������, ��, ������� ����������� ����
	{
if ($user['id']==14897) echo "AR2/";		
	$bots_list=array_merge($bots_laba,$bots_drakons,$bots_IH);
	}
	elseif ($magic['id']==122122) //     ������� ������ �� ���� - ��, ������� ����������� ����
	{
if ($user['id']==14897) echo "AR3/";		
	$bots_list=array_merge($bots_laba,$bots_IH);
	}	
	else //          ����� ������ �� ����� - ������� ����������� ����
	{
if ($user['id']==14897) echo "AR4/";		
	$bots_list=$bots_laba;
	}

if ($user['id']==14897)
	{
	print_r($bots_list);
	}

if ($user['battle'] == 0)  { echo "��� ������ �����..."; }
elseif($user[hp]<=0) {  err('��� ��� ��� �������!');        }
else {
	
			$test_life_bot = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `login` = '".mysql_real_escape_string($_POST['target'])."'  and battle='{$user[battle]}' and battle_t!='{$user[battle_t]}' LIMIT 1; ")) ;

			if  (($test_life_bot['id']>0) and ($test_life_bot['hp']>0) and ($test_life_bot['bot_online'] >=1 OR $user['lab']>0))
			{
			// ���� ��� � �����
				if (in_array($test_life_bot ['id_user'],$bots_list))
						{
						
						if  ($test_life_bot['level']<=$user['level']+1)
							{
								mysql_query("INSERT INTO `oldbk`.`get_lock_bots` SET `battle`='{$user[battle]}' ,`owner`='{$user['id']}',`chanse`='{$magic['chanse']}', `used_proto`='{$magic['id']}'  ,`idbot`='{$test_life_bot['id']}',`name_bot`='{$test_life_bot['login']}',`proto_bot`='{$test_life_bot['id_user']}' , `level_bot`= '{$test_life_bot['level']}' ;");
								if (mysql_affected_rows()>0)
									{
									$cc=0;
									$all_bots_namea.=($cc==0?"":", ").nick_align_klan($test_life_bot);
										if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
										elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
										$btext=str_replace(':','^',$all_bots_namea);
										
										$outstr=0;
										$string_conf[122121]=1;
										$string_conf[122122]=2;										
										$string_conf[122123]=3;										
										$string_conf[122124]=4;	
										
										if  ($string_conf[$magic['id']]>0) $outstr=$string_conf[$magic['id']];
										$sstt="1".$outstr."50";
										$sstt=(int)$sstt;
								       	       addlog($user['battle'],"!:X:".time().':'.nick_new_in_battle($user).':'.($user[sex]+$sstt).":".trim($btext)."\n");
								       	       
								       	       
								       	       		$bet=1;
											$sbet = 1;
											echo "������ ����������� ������  \"{$rowm['name']}\"  ";
											$MAGIC_OK=1;
								       	       
									}
									else
									{
									err('�� ��� ���������� ������� ��� ����� ������� ...');  			
									}
							}
							else
							{
							err('������������ ������ ����� ������ �� ������� ������ ������ ��� +1 ������� �� ������.'); 
							}

						}
						else
						{
						err('����� ������ ������ ������� �����, ����� ������� ����� �������.');  			
						}
			}
			elseif  (($test_life_bot['id']>0) and ($test_life_bot['hp']>0) and ($test_life_bot['bot_online'] ==-2 ))
			{
			err('�� �� ������ �������� ������� ����� �������!');  			
			}
			else
			{
			err('���� ������ ��� �� ����� ��� ��� ������ �������...');  			
			}

	} 
?>
