<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='��� �����';
$baff_type=716;//816

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
else {
	
	//1. ��������� ����  �� �� ��� ��� ������ ����
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type='{$baff_type}' ; "));

		if (($get_test_baff[id] > 0) and ($get_test_baff[lastup]>0))
		{
		err('�� ��� ��� ���� ��� ��������!');
		}
		else
		{
		$get_imun_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}'  and type='816' ; "));
		if (($get_imun_baff[id] > 0) )
			{
			err("�� ������� ������������ ��� �������� ����� ".floor(($get_imun_baff['time']-time())/60/60)." �. ".round((($get_imun_baff['time']-time())/60)-(floor(($get_imun_baff['time']-time())/3600)*60))." ���.");
			}
			else
			{
			mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`=1999999999,`owner`='{$user[id]}',`lastup`=1,`battle`='{$user[battle]}';");
			if (mysql_affected_rows()>0)
				{
				mysql_query("INSERT INTO `effects` SET `type`='816',`name`='��������� �� �������� ��� �����',`time`=".(time()+12*60*60).",`owner`='{$user[id]}',`battle`='{$user[battle]}';");//12 �����

				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>.<BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."\n");				
				
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			}
		
		}


	} 
	


?>
