<?php
// magic �������������
	//if (rand(1,2)==1) {
		if (!($_SESSION['uid'] >0)) header("Location: index.php");
		
		$target=$_POST['target'];
		$tar = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;")); 
		$magictime=time()+604800;
		if ($tar['id']) 
		{
			$tar=check_users_city_data($tar[id]);
			
			if($tar[id_city]==$user[id_city] || ADMIN==true)
			{
				if ($tar['klan']!='' ) 
				{
					echo "<font color=red><b>�������� \"$target\" ������� � �����!</b></font>";
				}
				else 
				{
					$ok=0;
					if ($user['align'] > '2' && $user['align'] < '3' && $moj[$_POST['use']]==1) {
						$ok=1;
					}
					elseif ($user['align'] > '1' && $user['align'] < '2' && $moj[$_POST['use']]==1) {
						$ok=1;
					}
					if ($ok == 1) {
						if($tar[id_city]==$user[id_city])
						{	
							if (mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$tar['id']."','����������� ��������','".$magictime."','20');")) {
								$messtel="��������, ��� �������� ���� ����� �������";
								$mess="".$user['login']." ������ ������� ��� ".$_POST['target']." ���� ����� �������";
								mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
								mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','1');");
								
								tele_check_new($tar,$messtel);
								
								echo "<font color=red><b>������� ���������� �������� ��������� \"$target\"</b></font>";			
							} 
							else {
								echo "<font color=red><b>��������� ������!<b></font>";
							}
						}
						else
						if(ADMIN==true)
						{
							
							if (mysql_query("INSERT INTO ".$db_city[$tar[id_city]]."`effects` (`owner`,`name`,`time`,`type`) values ('".$tar['id']."','����������� ��������','".$magictime."','20');")) {
								$messtel="��������, ��� �������� ���� ����� �������";
								$mess="".$user['login']." ������ ������� ��� ".$_POST['target']." ���� ����� �������";
								mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
								mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','1');");
								
								tele_check_new($tar,$messtel);
								
								echo "<font color=red><b>������� ���������� �������� ��������� \"$target\"</b></font>";			
							} 
							else {
								echo "<font color=red><b>��������� ������!<b></font>";
							}
						}
						
					}
					else {
						echo "<font color=red><b>�� �� ������ ��������� ��������!<b></font>";
					}
				}
			}
			else
			{
				echo "<font color=red><b>�������� \"$target\" � ������ ������!<b></font>";
			}
		}
		else 
		{
			echo "<font color=red><b>�������� \"$target\" �� ����������!<b></font>";
		}
?>
