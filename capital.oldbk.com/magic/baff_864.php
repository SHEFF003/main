<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$targ=($_POST['target']);
$baff_name='������ ���������';
$baff_type=864;//824

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
else {
	
	//if ($user[battle_t]==1)  {  $enem_t=2; 	}  else {  $enem_t=1; }
	
	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `login` = '{$targ}' and battle='{$user[battle]}' and battle_t!='{$user[battle_t]}' and hp>0 and mklevel>0 AND (id_user = 85 or id_user >= 554 and id_user <= 563) LIMIT 1;"));
	if ($jert[id] >0)
	{
	
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type=824 ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��� ������������ ��� ��������, �������� ��� ���������!');
	}
	else
	 {
 	 $get_var_baff= mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$jert[battle]}' and owner='{$jert[id]}' ;"));
	 if ($get_var_baff[baf_823_use]>0)
		{
		err("� \"".$jert[login]."\" ��������� �� ������������� ����� �������� �� ����� ���!");			
		}
		else
		{
		//2. ���������  ������� ���� ��� � ���� ��� ������������� ��� ���������� + �������� ���� ������ � add_info
		$get_count_baff=mysql_query("select  * from effects where battle='{$user[battle]}' and type=824 and add_info='{$jert[id]}' and owner in (select id from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp >0); ");
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
				mysql_query("INSERT INTO `effects` SET `type`='824',`name`='������ ������ ���������', add_info='{$jert[id]}'  ,`time`='".(time()+60)."', `owner`='{$user[id]}',`battle`='{$user[battle]}';");//1 ������
				if (mysql_affected_rows()>0)
				{

				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� '.nick_in_battle($jert,$jert[battle_t]).'. <i>(����� ����...)</i> <BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":<i>(����� ����...)</i>\n");
				
				
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			}
			else if ($kow==1)
			{
			//���� 1 � ���������
				mysql_query("INSERT INTO `effects` SET `type`='824',`name`='����������� ������ ���������', add_info='{$jert[id]}' ,`time`='".$remem_time[1]."',`owner`='{$user[id]}',`battle`='{$user[battle]}';");//����� ��������� � ������ ������
				if (mysql_affected_rows()>0)
				{

				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� '.nick_in_battle($jert,$jert[battle_t]).'. <i>(��������� ����...)</i> <BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":<i>(��������� ����...)</i>\n");
		       	       
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			}
			else
			{
			//���� ���� � ������� � ������� ���
			//������� ������ ����
			$mids = array();
			foreach($remem_own as $ic=>$owner) {
				$mids[] = $owner;
				mysql_query("DELETE from effects where `type`='824' and owner='{$owner}' and battle='{$user[battle]}' and add_info='{$jert[id]}'  ;"); 	
			}
				
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					
				$del_hp=(int)((mt_rand(40,70)*0.01)*$jert[hp]);
				$touserhp = floor(($del_hp/2)/3);
				if ($del_hp>0) {
					mysql_query("UPDATE `users_clons` SET `hp` =`hp`- ".$del_hp."  WHERE `id` = ".$jert['id']." and hp>0 ;");
				} else {
					$no_up=true;
				}

				if ((mysql_affected_rows()>0) or ($no_up)) {
					$jert[hp]-=$del_hp;

					
//					addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, ��  '.nick_in_battle($jert,$jert[battle_t]).', ������� ����� <font color=red><B>-'.$del_hp.'</B></font> ['.$jert[hp].'/'.$jert['maxhp'].'] <i>(������ ����...)</i> <BR>');
			       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":, ������� ����� <b><font color=red>-".((($jert[hidden]>0)and($jert[hiddenlog]==''))?"??</font></b> [??/??]":"{$del_hp}</font></b> [{$jert[hp]}/{$jert[maxhp]}]")."  <i>(������ ����...)</i>\n");								
					
					$mids[] = $user['id'];
					$q = mysql_query('SELECT * FROM users WHERE id IN ('.implode(",",$mids).')');
					while($u = mysql_fetch_assoc($q)) {
						$newhp = $u[hp]+$touserhp;
						if ($newhp > $u['maxhp']) $newhp = $u['maxhp'];
						mysql_query('UPDATE users SET hp = '.$newhp.' WHERE id = '.$u['id']);

						if ($u['hidden'] > 0) {
							$newhp = "??";
							$u['maxhp'] = "??";
						}
//						addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($u,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b> � ����������� ������� ����� <font color=black><B>+'.$touserhp.'</B></font> ['.$newhp.'/'.$u['maxhp'].'] <BR>');
				       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::������� ����� +<b><font color=red>".((($u[hidden]>0)and($u[hiddenlog]=='')) ? "??</font></b> [??/??]" : "{$touserhp}</font></b> [{$newhp}/{$u[maxhp]}]\n"));				       	       
				       	       
				       	       
					}

					//������ ������� ������
					mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_823_use`) values('".$jert['battle']."', '".$jert['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_823_use` =`baf_823_use`+1;");
	
					$bet=1;
					$sbet = 1;
					echo "��� ������ ������!";
					$MAGIC_OK=1;

				} else {
					err('������ ��� ������!');
				}
			}
		}	
		
	   }	
	
	}
	else
	     {
	     err('����� ����� ���������� ������ "'.$targ.'"  �� ������!');
	     }


	} 
	



?>
