<?

if (!($_SESSION['uid'] >0)) header("Location: index.php");

		$boxpass=$_POST['target'];
 if ($boxpass)
 	{
		$sv_id=(int)($_GET['use']);
		$svitok = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `id` ='{$sv_id}'  AND `setsale`=0 AND `bs_owner`='{$user[in_tower]}' AND `magic`=88  AND arsenal_klan = '' AND `owner` = '{$user['id']}' LIMIT 1;"));
		
		if ($svitok[id] > 0)
		{
		//GET TIME
	    	$st=magicinf(88);
	    	$stt=time()+$st[time];
		 //i have ?
		  $effect88 = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '88' LIMIT 1;"));
		    if ($effect88[id]>0)
		    	{
		    	//YES
				//if ($_SESSION['boxisopen']=='open')
				//{
				// ����������� ����� ����
				//������� ������
				//mysql_query("DELETE FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '88' LIMIT 1;");
				//������ �����
				//mysql_query("INSERT INTO `effects` SET `type`=88,`name`='�����',`time`='{$stt}', `owner`='{$user[id]}', `add_info`='{$boxpass}';");
			  	//echo "������ �� ��������� �������!";
 				// $bet=1;
				//}
				// else
				// {
				echo "�� �� ������ ������������ ���� �� ������� ������";
				// }
		    	}
		    	else
		    	{
		    	//NO

		    	// ������ �����
			mysql_query("INSERT INTO `effects` SET `type`=88,`name`='�����',`time`='{$stt}', `owner`='{$user[id]}', `add_info`='{$boxpass}';");

		    	//������ ������� ��
		    	unset($_SESSION['boxisopen']); 
		  	echo "������ �� ��������� ����������!";
 			 $bet=1;
			$sbet = 1;
		    	}
		  
		
		 
		
		}
	}


?>