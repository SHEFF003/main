<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='���������';
$baff_type=705;

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif ($user['hp']>=$user['maxhp']) { err("�������� ������!"); }
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
elseif (can_hill($user))	{  err('�� �������� �� ������ ������������ �������������� �����.'); }
else {
	
	
		// ���� ��������� �������������� �� � ���?		
			$get_var_baff= mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$user[battle]}' and owner='{$user[id]}' ;"));
		if ($get_var_baff[baf_705_use]>0)
			{
			err('����� ������������ ������ ��� � ���!');			
			}
			else
			{
				//$cure_value=(int)($user[maxhp]*0.05);
				$cure_value=90;
				if(($user['hp'] + $cure_value) > $user['maxhp'])
				{
				$add_hp=$user['maxhp']-$user['hp'];
				}
				else
				{
				$add_hp=$cure_value;
				}
				
				mysql_query("UPDATE `users` SET `hp` =`hp`+ ".$add_hp."  WHERE `id` = ".$user['id']." and hp>0 ;");

				if (mysql_affected_rows()>0)
				{
				$user[hp]+=$add_hp ;  
						
				mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_705_use`) values('".$user['battle']."', '".$user['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_705_use` =`baf_705_use`+1;");
		
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//					addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b> � �����������'.$action.' ������� ����� <B>+'.$cure_value.'</B>['.$user[hp].'/'.$user['maxhp'].']<BR>');
			       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::������� ����� +<b><font color=red>".((($user[hidden]>0)and($user[hiddenlog]==''))?"??</font></b> [??/??]\n":"{$cure_value}</font></b> [{$user[hp]}/{$user[maxhp]}]\n"));
					
					

				// ����� ������
				if ($user[battle_t]==1) 
				{ 
				$boec_t1[$user[id]][hp]=$user[hp] ;  
				}
				elseif ($user[battle_t]==2)  
				{  
				$boec_t2[$user[id]][hp]=$user[hp];  
				}
				elseif ($user[battle_t]==3)  
				{  
				$boec_t3[$user[id]][hp]=$user[hp];  
				}				

				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
				else
				{
				err('������ ������ ������!');    
				}
			        
			        
			}
		
		


	} 
	


?>
