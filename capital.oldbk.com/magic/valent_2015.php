<?
if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) {
	header("Location: index.php");
	die();
}

if (!(isset($_GET['clearstored'])))
{

$che=(int)($_POST['target']);
/*
echo "TEST";
echo "<br>";
print_r($_GET);
echo "<br>";
print_r($_POST);
*/
$effarray=array(
		9100=>'��������� ��������� +30%',
		9102=>'��������� ����� +30%',
		9103=>'��������� ������� ����� +30%',
		9104=>'������� � �������� -30%',						
		9105=>'������� � ��������� -30%',
		9106=>'������� � ����� -30%');
		
	if (array_key_exists($che,$effarray))
	{
		$effect = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}'  and `type` = '{$che}' LIMIT 1;")); 
			
		$add_time_eff=time()+($magic['time']*60);
		$updok=0;
		if ($effect['id']>0)
		{

			if ($che==9102) // ����
			{
			//���� ���������
			if ($effect['add_info']!='0.3')
				{
				//������ ��� ������ = ���������� ��������
					mysql_query("UPDATE `oldbk`.`effects` SET `time`='{$add_time_eff}' , `name`='{$effarray[$che]}'  , add_info='0.3'  WHERE `id`='{$effect['id']}' ");
					if(mysql_affected_rows()>0)
					{
					$updok=1;
					mysql_query("UPDATE users set expbonus=expbonus-'{$effect['add_info']}'+'0.3' where id='{$user[id]}' ; ");		
					}
				}
				else
				{
				//���� ������� ������	
					mysql_query("UPDATE `oldbk`.`effects` SET `time`='{$add_time_eff}' WHERE `id`='{$effect['id']}' ");
					if(mysql_affected_rows()>0)
					{
					$updok=1;
					}
				}
			}
			elseif ($che==9100) // ����
				{
				$have_bonus=explode(":",$effect['add_info']);
				$have_bonus=$have_bonus[1];

					if ($have_bonus<0.3)				
						{
							mysql_query("UPDATE `oldbk`.`effects` SET `time`='{$add_time_eff}' , `name`='{$effarray[$che]}'  ,   add_info='{$rowm['img']}:0.3'   WHERE `id`='{$effect['id']}' ");
							if(mysql_affected_rows()>0)
							{
							$updok=1;
							mysql_query("UPDATE users set rep_bonus=rep_bonus-'{$have_bonus}'+'0.3' where id='{$user[id]}' ; ");		
							}
						}
						else
						{
						//���� ������� ������	- ������ ������ �������
							mysql_query("UPDATE `oldbk`.`effects` SET `time`='{$add_time_eff}' WHERE `id`='{$effect['id']}' ");
							if(mysql_affected_rows()>0)
							{
							$updok=1;
							}
						}

				}
				else //  ������
				{
				
					if ($effect['add_info']!='0.3')
						{
						//������ ��� ������ = ���������� ��������
							mysql_query("UPDATE `oldbk`.`effects` SET `time`='{$add_time_eff}' , `name`='{$effarray[$che]}'  , add_info='0.3'  WHERE `id`='{$effect['id']}' ");
							if(mysql_affected_rows()>0)
							{
							$updok=1;
							}
						}
						else
						{
						//���� ������� ������	
							mysql_query("UPDATE `oldbk`.`effects` SET `time`='{$add_time_eff}' WHERE `id`='{$effect['id']}' ");
							if(mysql_affected_rows()>0)
							{
							$updok=1;
							}
						}
				
				}
				
				
			
		}
		
		if ($updok==0)
		{
		
			if ($che==9102)
				{
				//���� ���������
				mysql_query("INSERT INTO `effects` SET `type`= '{$che}',`name`='{$effarray[$che]}',`time`='{$add_time_eff}',`owner`='{$user[id]}', add_info='0.3' ;");
				mysql_query("UPDATE users set expbonus=expbonus+'0.3' where id='{$user[id]}' ; ");		
				}
			elseif ($che==9100)
				{
				mysql_query("INSERT INTO `effects` SET `type`= '{$che}',`name`='{$effarray[$che]}',`time`='{$add_time_eff}',`owner`='{$user[id]}',  add_info='{$rowm['img']}:0.3' ;");
				mysql_query("UPDATE users set rep_bonus=rep_bonus+'0.3' where id='{$user[id]}' ; ");		
				}
				else
				{
				mysql_query("INSERT INTO `effects` SET `type`= '{$che}',`name`='{$effarray[$che]}',`time`='{$add_time_eff}',`owner`='{$user[id]}',  add_info='0.3' ;");
				}
		}
		

		echo "<font color=red>������ ������������ ����� <b>\"{$effarray[$che]}\"</b></font>";
/*
		$sbet = 1;
				
		//���� �� ������� �� ���������
		if ($rowm['present']=='')
		{
		$bet=1;
		}
		else
		{
		
		if (($rowm['maxdur'] <= ($rowm['duration']+1))and ($rowm['magic']) )
			{*/
			$rowm['duration']=0; // �������� ���� �� ���������
			$goden=time()+15552000;
			mysql_query("UPDATE oldbk.`inventory` SET `magic` = 0 , `present` = '�� ��. ���������', `dategoden`='{$goden}' ,`goden`=180, `ekr_flag` = 0, sowner = ".$user['id']." WHERE `id` = {$rowm['id']} LIMIT 1;");
/*
			}
		}
*/
	}
	else
	{
			echo "<font color=red><b>:)</b></font>";
	}
}
?>