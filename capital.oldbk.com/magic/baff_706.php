<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$targ=($_POST['target']);
$baff_name='��� �����';
$baff_type=706;

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
else {
	
		
	
	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}' and battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp>0   LIMIT 1;"));
	if ($jert[id] ==$user[id])
	{
	err('������ ������������ �� ���� :(');
	}
	else
	if ($jert[id] >0)
	{
	//1. ��������� ����  �� �� ���� ��� ������ ����
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$jert[id]}' and battle='{$user[battle]}' and type='{$baff_type}' ; "));

		if ($get_test_baff[id] > 0) 
		{
		err('�� "'.$jert[login].'" ��� ���� ��� ��������!');
		}
		else
		{
		$get_var_baff= mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$jert[battle]}' and owner='{$jert[id]}' ;"));
		
		if ($get_var_baff[baf_706_use]>0)
			{
			err("� \"".$jert[login]."\" ��������� �� ������������� ����� �������� �� ����� ���!");			
			}
			else
			{
				
			mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`=1999999999,`owner`='{$jert[id]}',`lastup`=1,`battle`='{$user[battle]}';");
			if (mysql_affected_rows()>0)
				{
				mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_706_use`) values('".$jert['battle']."', '".$jert['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_706_use` =`baf_706_use`+1;");
				
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
				
				//addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� ��������� '.nick_in_battle($jert,$jert[battle_t]).'.<BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert)."\n");
				
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
	     
	     err('����� ����� ��������� "'.$targ.'"  �� ������!');
	     }


	} 
	


?>
