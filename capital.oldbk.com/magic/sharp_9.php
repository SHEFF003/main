<?php
if (!($_SESSION['uid'] >0)) header("Location: index.php");
if ($_POST['target']!='')
{
if ($user['battle'] > 0) {
	echo "�� � ���...";
} else	{

	$dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE naem = 0 and `setsale`=0 AND `bs_owner`='{$user[in_tower]}' AND (arsenal_klan = '' OR arsenal_owner=1 ) AND `owner` = '{$user['id']}' AND `id` = '{$_POST['target']}'  AND type=3 and gmeshok = 0 LIMIT 1;"));
	$svitok = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE  magic=192 AND `setsale`=0 AND `bs_owner`='{$user[in_tower]}' AND (arsenal_klan = '' OR arsenal_owner=1 )  AND `owner` = '{$user['id']}' LIMIT 1;"));
	//�������� �� ��� ����������
	$predmet=explode("+",$dress[name]);
	$start=(int)($predmet[1]);
	if ($start > 9)
	{
	echo "��� �������� �� +9 ��� ���� ...";
	}
	elseif( (($svitok['prototype']==190192) and ($svitok['sowner']>0) ) and ($dress['arsenal_klan'] != '') )
	{
	echo "<font color=red><b>���� ������� ������ �������� ������� �������� �����!<b></font>";
	}
	elseif($dress['sowner']>0  && $dress['sowner'] != $user['id']) 
	{
		echo "<font color=red><b>������ �������� ����� ������<b></font>";
	}	
	else
	{

	$new_name=$predmet[0]."+9";

	$add_sql_update='';
	
	if (($svitok['prototype']==190192) and ($svitok['sowner']>0) )
			{
			$add_sql_update=" `sowner`='".$user['id']."' ,  ";
			}
	
	$sharp=9-$start;


		if ($dress && $svitok) {
		
			 if ($dress[otdel]==1) 
			 		{ 
			 		$asql="`nnoj` = `nnoj`+{$sharp}, `ninta` = `ninta`+{$sharp}";
			 		}
			 else
			 if ($dress[otdel]==11) 
			 		{
 					$asql="`ntopor` = `ntopor`+{$sharp}, `nsila` = `nsila`+{$sharp}";
			 		}
			 else
			 if ($dress[otdel]==12) 
			 		{
					 $asql="`ndubina` = `ndubina`+{$sharp}, `nlovk` = `nlovk`+{$sharp}";
					}
			else
 			 if ($dress[otdel]==13) 
 			 		{
				 	$asql="`nmech` = `nmech`+{$sharp}, `nvinos` = `nvinos`+{$sharp}";
				 	}
				 	else
				 	{
				 	$asql='';
				 	}
		
			if ($asql!='')
			      {
				      $present='';
			      		if ($dress['present']=='')
			      			{
			      			$present=", present='��������' ";
			      			}

			      
				if (mysql_query("UPDATE oldbk.`inventory` SET {$add_sql_update}  `sharped` = 1 {$present} , `name` = '{$new_name}', `minu` = `minu`+{$sharp}, `maxu`=`maxu`+{$sharp}, `cost` = `cost`+30 , ".$asql."   WHERE `id` = {$dress['id']} LIMIT 1;")) 
				{
					if ($start>0) { $dodo="����"; } 
					echo "<font color=red><b>������� \"{$dress['name']}\" ������ ".$dodo."������� �� +9! ����� ��������� ������� ����� �������� ������ �������.<b></font> ";
					$bet=1;
					$sbet = 1;
					if(!$_SESSION['beginer_quest'][none]) 
					{				
						// �����
					        $last_q=check_last_quest(30);
					        if($last_q) 
						{
							quest_check_type_30($last_q,$user[id],6,1);
						}
					      
					}
				
				}
				else 
				{
				echo "<font color=red><b>��������� ������!<b></font>";
				}
			     }
			     else
			     {
				echo "<font color=red><b>���� ��� ������ �� �������� ���� �������!<b></font>";			     
			     }
		} else {
			echo "<font color=red><b>������������ ��� �������� ��� ������������ ������<b></font>";
		}

	 }
}
}
?>