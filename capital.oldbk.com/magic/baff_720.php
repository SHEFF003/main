<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$targ=($_POST['target']);
$baff_name='������� �����������';
$baff_type=720;//820

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
else {
	
	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}' and battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp<=0   LIMIT 1;"));
	if ($jert[id] ==$user[id])
	{
	err('������ ������������ �� ���� :(');
	} elseif(in_array($jert['id'], array(3, 4))) {
		err('������ ������������ �� ����� ���������');
	}
	else
	if ($jert[id] >0)
	{
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type='820' ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��� ������������ ��� ��������, �������� ��� ���������!');
	}
	else
	 {
 	 $get_var_baff= mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$jert[battle]}' and owner='{$jert[id]}' ;"));
	 if ($get_var_baff[baf_720_use]>0)
		{
		err("� \"".$jert[login]."\" ��������� �� ������������� ����� �������� �� ����� ���!");			
		}
		else
		{
		//2. ���������  ������� ���� ��� � ���� ��� ������������� ��� ���������� + �������� ���� ������ � add_info
		$get_count_baff=mysql_query("select  * from effects where battle='{$user[battle]}' and type=820 and add_info='{$jert[id]}' and owner in (select id from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp >0); ");
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
				mysql_query("INSERT INTO `effects` SET `type`='820',`name`='������ ������� �����������', add_info='{$jert[id]}'  ,`time`='".(time()+60)."', `owner`='{$user[id]}',`battle`='{$user[battle]}';");//1 ������
				if (mysql_affected_rows()>0)
				{
				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� ��������� '.nick_in_battle($jert,$jert[battle_t]).'. <i>(����� ����...)</i> <BR>');
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
				mysql_query("INSERT INTO `effects` SET `type`='820',`name`='����������� ������� �����������', add_info='{$jert[id]}' ,`time`='".$remem_time[1]."',`owner`='{$user[id]}',`battle`='{$user[battle]}';");//����� ��������� � ������ ������
				if (mysql_affected_rows()>0)
				{
				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� ��������� '.nick_in_battle($jert,$jert[battle_t]).'. <i>(��������� ����...)</i> <BR>');
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
			mysql_query("INSERT INTO `effects` SET `type`='720',`name`='{$baff_name}',`time`=1999999999,`owner`='{$jert[id]}',`lastup`=6,`battle`='{$jert[battle]}';");//6 (����� 5) ����
			//������� ������ ����
			foreach($remem_own as $ic=>$owner)
				{
			mysql_query("DELETE from effects where `type`='820' and owner='{$owner}' and battle='{$user[battle]}' and add_info='{$jert[id]}'  ;"); 	
				}
				
				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

			
			//���������� 
			$add_hp=(int)($jert[maxhp]*0.25);
			$jert[hp]=$add_hp;
			
			//����� ������������ ������� ��� �������
			 mysql_query("delete from  battle_fd  where razmen_to='{$jert['id']}' or razmen_from='{$jert['id']}';");
			
			
			mysql_query("UPDATE `users` SET `hp` =".$add_hp."  WHERE `id` = ".$jert['id']."  ;");
			// ����� ������
				if ($jert[battle_t]==1) 
				{ 
				$boec_t1[$jert[id]][hp]=$jert[hp] ;  
				}
				else if ($jert[battle_t]==2) 
				{  
				$boec_t2[$jert[id]][hp]=$jert[hp];  
				}
				else if ($jert[battle_t]==3) 
				{  
				$boec_t3[$jert[id]][hp]=$jert[hp];  
				}				
			
				
//			addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>,  �������� '.nick_in_battle($jert,$jert[battle_t]).' <b>�������</b>, ������� ����� +<b><font color=red>'.((($jert[hidden]>0)and($jert[hiddenlog]==''))?"??</font></b> [??/??]":"{$add_hp}</font></b> [{$jert[hp]}/{$jert[maxhp]}]").'  <i>(������ ����...)</i> <BR>');								

	       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":<b>�������</b>, ������� ����� +<b><font color=red>".((($jert[hidden]>0)and($jert[hiddenlog]==''))?"??</font></b> [??/??]":"{$add_hp}</font></b> [{$jert[hp]}/{$jert[maxhp]}]")."  <i>(������ ����...)</i>\n");								

			if ($jert[battle_t]==1)
			{
			$tt1=2;
			$tt2=3;			
			}
			elseif ($jert[battle_t]==2)
			{
			$tt1=1;
			$tt2=3;			
			}
			elseif ($jert[battle_t]==3)
			{
			$tt1=1;
			$tt2=2;			
			}			
			//��������� ������� - ��� �� ���� ������
			mysql_query("INSERT INTO `battle_user_time` SET `battle`='{$user['battle']}',`owner`='{$jert[id]}',`timer{$tt1}`='".time()."' ,`timer{$tt2}`='".time()."' ON DUPLICATE KEY UPDATE `timer{$tt1}`='".time()."' , `timer{$tt2}`='".time()."'" );
				
			//������ ������� ������
			mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_720_use`) values('".$jert['battle']."', '".$jert['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_720_use` =`baf_720_use`+1;");

				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
			}
		}	
		
	   }	
	
	}
	else
	     {
	     err('����� ������� ��������� "'.$targ.'"  �� ������!');
	     }


	} 
	



?>
