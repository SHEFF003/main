<?
if (!($_SESSION['uid'] >0)) {
	header("Location: index.php");
	die();
}

 if (!isset($_GET['clearstored']))
{
	
	if ($magic['id']==20180601 || $magic['id']==20180602 || $magic['id']==20180603)
	 {
	 	
	 	$maskeff[20180603]=907;	//����
	 	$maskeff[20180602]=908;	//��	 	
	 	$maskeff[20180601]=20180601;	//����
	 	
	 	
	 	$etype=$maskeff[$magic['id']];
	 	
		$effect = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}'  and `type` = '{$etype}' LIMIT 1;")); 
		$wtime= magicinf($etype);
		if (!($effect['id']))
			{
			$flagid=(int)($_POST['target']);
			include('/www/capitalcity.oldbk.com/chm2018.php');
			
			mysql_query("INSERT INTO `oldbk`.`users_flag` SET `owner`='{$user['id']}',`flag`='{$euflags[$flagid]['flag']}',`flag_name`='{$euflags[$flagid]['name']}' on DUPLICATE KEY UPDATE `flag`='{$euflags[$flagid]['flag']}',`flag_name`='{$euflags[$flagid]['name']}' ; ");
										
			$add_time_eff=time()+($magic['time']*60);
				
				if ($magic['id']==20180603)
				{
				mysql_query("INSERT INTO `effects` SET `type`={$etype},`name`='{$euflags[$flagid]['flag']}:���������� �����, ���� +30%',`time`='{$add_time_eff}',`owner`='{$user[id]}' ,  add_info='0.3'   ;");				
				mysql_query("UPDATE users set expbonus=expbonus+0.3 where id='{$user[id]}' ; ");
				if (mysql_affected_rows()>0)
					{
					echo "<font color=red>�� ���������� �{$euflags[$flagid]['name']}�, � �������� ������ <b>+30% �����</b></font>";
					$bet=1;
					$sbet = 1;
					
								if ($rowm['ekr_flag']==1)
								{
								//������ �� ������ ���������� ����������� ������
								mysql_query("UPDATE oldbk.inventory set ekr_flag=0,  present='�����' where id='{$rowm['id']}' limit 1;");
								}
					
					}
				}
				else
				if ($magic['id']==20180602)
				{
				mysql_query("INSERT INTO `effects` SET `type`={$etype},`name`='{$euflags[$flagid]['flag']}:���������� �����, ������� ����� +30%',`time`='{$add_time_eff}',`owner`='{$user[id]}' ,  add_info='30'   ;");				

				if (mysql_affected_rows()>0)
					{
					echo "<font color=red>�� ���������� �{$euflags[$flagid]['name']}�, � �������� ������ <b>+30% ������� �����</b></font>";
					$bet=1;
					$sbet = 1;
					
								if ($rowm['ekr_flag']==1)
								{
								//������ �� ������ ���������� ����������� ������
								mysql_query("UPDATE oldbk.inventory set ekr_flag=0,  present='�����' where id='{$rowm['id']}' limit 1;");
								}
					
					}
				}
				else
				if ($magic['id']==20180601)
				{
				mysql_query("INSERT INTO `effects` SET `type`={$etype},`name`='{$euflags[$flagid]['flag']}:���������� �����, ��������� +30%',`time`='{$add_time_eff}',`owner`='{$user[id]}' ,  add_info='0.3'   ;");				
				if (mysql_affected_rows()>0)
					{
					mysql_query("UPDATE `users` SET `rep_bonus`=`rep_bonus`+0.3 WHERE `id`='{$user['id']}'  ");
					
					echo "<font color=red>�� ���������� �{$euflags[$flagid]['name']}�, � �������� ������ <b>+30% ���������</b></font>";
					$bet=1;
					$sbet = 1;
					
								if ($rowm['ekr_flag']==1)
								{
								//������ �� ������ ���������� ����������� ������
								mysql_query("UPDATE oldbk.inventory set ekr_flag=0,  present='�����' where id='{$rowm['id']}' limit 1;");
								}
					
					}
				}
				

			} else 
			{
				echo "<font color=red><b>� ��� ��� ���� ����� ������!</b></font>";
			}
	}
}
?>