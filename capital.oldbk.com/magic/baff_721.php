<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$targ=($_POST['target']);
$baff_name='����������';
$baff_type=721;//821-������

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
else {
	
	//if ($user[battle_t]==1)  {  $enem_t=2; 	}  else {  $enem_t=1; }
	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}' and battle='{$user[battle]}' and battle_t!='{$user[battle_t]}' and hp>0   LIMIT 1;"));
	if ($jert[id] >0)
	{
	
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type=821 ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��� ������������ ��� ��������, �������� ��� ���������!');
	}
	else
	 {
 	 $get_var_baff= mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$jert[battle]}' and owner='{$jert[id]}' ;"));
	 if ($get_var_baff[baf_721_use]>0)
		{
		err("� \"".$jert[login]."\" ��������� �� ������������� ����� �������� �� ����� ���!");			
		}
		else
		{
		//2. ���������  ������� ���� ��� � ���� ��� ������������� ��� ���������� + �������� ���� ������ � add_info
		$get_count_baff=mysql_query("select  * from effects where battle='{$user[battle]}' and type=821 and add_info='{$jert[id]}' and owner in (select id from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp >0); ");
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
				mysql_query("INSERT INTO `effects` SET `type`='821',`name`='������ ����������', add_info='{$jert[id]}'  ,`time`='".(time()+60)."', `owner`='{$user[id]}',`battle`='{$user[battle]}';");//1 ������
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
				mysql_query("INSERT INTO `effects` SET `type`='821',`name`='����������� ����������', add_info='{$jert[id]}' ,`time`='".$remem_time[1]."',`owner`='{$user[id]}',`battle`='{$user[battle]}';");//����� ��������� � ������ ������
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
			//������� ������ ����
			foreach($remem_own as $ic=>$owner)
				{
			mysql_query("DELETE from effects where `type`='821' and owner='{$owner}' and battle='{$user[battle]}' and add_info='{$jert[id]}'  ;"); 	
				}
				
				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

				
				mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`=1999999999,`owner`='{$jert[id]}',`lastup`=5,`battle`='{$user[battle]}';");// ������ ���������� ��� �� ������ �� 5 �����
//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� ��������� '.nick_in_battle($jert,$jert[battle_t]).'.  <i>(������ ����...)</i> <BR>');								
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":<i>(������ ����...)</i>\n");

				//������ ������� ������
				mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_721_use`) values('".$jert['battle']."', '".$jert['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_721_use` =`baf_721_use`+1;");

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
	     err('����� ����� ������ "'.$targ.'"  �� ������!');
	     }


	} 
	



?>
