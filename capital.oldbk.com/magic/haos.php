<?php

// magic �������������
	//if (rand(1,2)==1) {
$coma[] = "� ���� ��� �������?!";
$coma[] = "��, � ���� ��� ����� � ������ ���� ���. ";
$coma[] = "����� ������, �� ����������!";
$coma[] = "����� ����� ������� �����, � �� ����!";
$coma[] = "� � ���� �������� � ����� �������... ";
$coma[] = "��� � ���� ���� �� ";
$coma[] = "�� ������� � ���� ��������, �� ����!";
$coma[] = "� ���� ���� ����� �������";
$coma[] = "������ ��� ����, ��� ��� ������� ������???";
$coma[] = "������ ���� ������ �������� �� ��������.";
$coma[] = "���, ��� �������� ����� ������, �� ����� ������ ������ �� ���.";
$coma[] = "����� ��� ������, � ����� ���� ���������. ";
$coma[] = "���� ��������� ";
$coma[] = "� ������ �� �����.";
$coma[] = "������ ���� ���������, ������ �������!";
$coma[] = "��-��-��, ����� ���� ����� ���! ";
$coma[] = "��������� ��� �����, � �� ��� ����� �����������. ";
$coma[] = "����. ������� ��� �� ����������. ";
$coma[] = "����� �����������!";


		if (!($_SESSION['uid'] >0)) header("Location: index.php");
		
		$magictime=time()+($_POST['timer']*60*1440);
		$tar = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
		$target=$_POST['target'];
		if ($tar['id']) 
		{
			$tar=check_users_city_data($tar[id]);
			if($tar[id_city]==$user[id_city] || ADMIN)
			{
			//����� ���������� "����_����" � ������� ����
				$effect = mysql_fetch_array(mysql_query("SELECT * FROM ".$db_city[$tar[id_city]]."`effects` WHERE `owner` = '{$tar['id']}' and `type` = '4' LIMIT 1;"));
	
				if ($effect['time']) {
					$time_still=$effect['time'] - time();
					$time_new=$magictime - time();
					if ($time_still < $time_new) {
						$ok=0;
						if ($user['align'] > '2' && $user['align'] < '3' && $moj[$_POST['use']]==1) 
						{
						$ok=1;
						}
						elseif (($user['align'] > '1' && $user['align'] < '2') && ($tar['align'] > '1' && $tar['align'] < '2') && ($user['align'] > $tar['align']) && $moj[$_POST['use']]==1 ) 
						{
							$ok=1;
						}
						elseif (($user['align'] > '1' && $user['align'] < '2') && !($tar['align'] > '2' && $tar['align'] < '3') && !($tar['align'] > '1' && $tar['align'] < '2') && $moj[$_POST['use']]==1) 
						{
							$ok=1;
						}
						if ($ok == 1) {
							if (mysql_query("UPDATE ".$db_city[$tar[id_city]]."`effects` SET `time`='$magictime' WHERE `id` = '{$effect['id']}' LIMIT 1;")) {
								$ldtarget=$target;
								$ldblock=1;
	
								switch($_POST['timer']) {
									case "2": $magictime="��� ���."; break;
									case "3": $magictime="��� ���."; break;
									case "7": $magictime="������."; break;
									case "14": $magictime="��� ������."; break;
									case "30": $magictime="�����."; break;
									case "60": $magictime="��� ������."; break;
									case "365": $magictime="���������."; break;
								}
								if ($user['sex'] == 1) {$action="��������";}
								else {$action="���������";}
								if ($user['align'] > '2' && $user['align'] < '3')  {
									$angel="�����";
								}
								elseif ($user['align'] > '1' && $user['align'] < '2') {
									$angel="�������";
								}
								$mess="��������� �����. $angel &quot;{$user['login']}&quot; $action � ���� &quot;$target&quot; ������ $magictime";
								$messch="��������� �����. $angel &quot;{$user['login']}&quot; $action � ���� &quot;$target&quot; ������ $magictime.";
	
								mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
								mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','8');");

								// �������� ��� ���� �� �������� �����
								mysql_query('UPDATE oldbk.rentalshop SET maxendtime = "'.time().'" WHERE owner = '.$tar['id']);
	
								addch("<img src=i/magic/haos.gif> $messch",$user['room'],$user['id_city']);
								if($tar[room]!=$user[room])
					                        {
					                        	addchp (' <img src=i/magic/haos.gif> '.$messch,'{[]}'.$tar['login'].'{[]}',$tar['room'],$tar['id_city']);
					                        }
								addchp($coma[rand(0,count($coma)-1)],"�����������",$user['room'],$user['id_city']);
								echo "<font color=red><b>������� �������� �������� ����� �� ��������� \"$target\"</b></font>";
								cancel_exchange_all($tar['id']);
								
										//��������  ����� �� �����
										$get_lots=mysql_query("select * from exchange where owner='{$tar['id']}' ");
										while($lots = mysql_fetch_array($get_lots)) 
										{
											return_lot_from_exchange($lots['id']);
										}
								
							}
							else {
								echo "<font color=red><b>��������� ������!<b></font>";
							}
						}
						else {
							echo "<font color=red><b>�� �� ������ �������� �������� ����� �� ����� ���������!<b></font>";
						}
					}
					else {
						echo "<font color=red><b>�� �� ������ ��������� ���� ���������!</b></font>";
					}
				}
				else {
					$ok=0;
					if ($user['align'] > '2' && $user['align'] < '3') {
						$ok=1;
					}
					elseif (($user['align'] > '1.6' && $user['align'] < '2') && ($tar['align'] > '1' && $tar['align'] < '2') && ($user['align'] > $tar['align'])) {
						$ok=1;
					}
					elseif (($user['align'] > '1.6' && $user['align'] < '2') && !($tar['align'] > '2' && $tar['align'] < '3') && !($tar['align'] > '1' && $tar['align'] < '2')) {
						$ok=1;
					}
					if ($ok == 1) 
					{
						if ($_POST['timer']!=365)
						{
						mysql_query("INSERT INTO ".$db_city[$tar[id_city]]."`effects` (`owner`,`name`,`time`,`type`) values ('".$tar['id']."','�������� �����','$magictime',4);") ;
						 if (!(mysql_affected_rows()>0)) { $ok =0 ;}						
						}

						if ($ok == 1)	 
						   {
						    Test_Arsenal_Items($tar,0,0,1);
	
						    	$exp=0;
						    	$exp=($tar[align]==1.5?($exp-0.1):$exp);
				                        $exp=($tar[align]==1.7?($exp-0.2):$exp);
				                        $exp=($tar[align]==1.9?($exp-0.3):$exp);
				                        $exp=($tar[align]==1.91?($exp-0.4):$exp);
				                        $exp=($tar[align]==1.99?($exp-0.5):$exp);
				                        foreach($db_city as $k=>$v)
							{
								mysql_query("UPDATE ".$v."`users` SET `align`='4', klan='', status='', expbonus=expbonus+".$exp." WHERE `id` = {$tar['id']} LIMIT 1;");
							}
							
							
							undressall($tar['id'],$tar['id_city']); 
							$ldtarget=$target;
							$ldblock=1;
	
							switch($_POST['timer']) {
								case "2": $magictime="��� ���."; break;
								case "3": $magictime="��� ���."; break;
								case "7": $magictime="������."; break;
								case "14": $magictime="��� ������."; break;
								case "30": $magictime="�����."; break;
								case "60": $magictime="��� ������."; break;
								case "365": $magictime="���������."; break;
							}
							if ($user['sex'] == 1) {$action="��������";}
							else {$action="���������";}
							if ($user['align'] > '2' && $user['align'] < '3')  {
								$angel="�����";
							}
							elseif ($user['align'] > '1' && $user['align'] < '2') {
								$angel="�������";
							}
							$mess="$angel &quot;{$user['login']}&quot; $action � ���� &quot;$target&quot; ������ $magictime";
							$messch="$angel &quot;{$user['login']}&quot; $action � ���� &quot;$target&quot; ������ $magictime.";
	
	                       /* if($tar['align']!=0)
	                        {
		                        mysql_query("INSERT INTO `effects`
								(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
								('".$eff_align_type."','����� �������','".$tar['id']."','".$eff_align_time."','".$tar['align']."');");
	                        }
	                        */
							mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
							mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','8');");

							// �������� ��� ���� �� �������� �����
							mysql_query('UPDATE oldbk.rentalshop SET maxendtime = "'.time().'" WHERE owner = '.$tar['id']);

							addch("<img src=i/magic/haos.gif> $messch",$user['room'],$user['id_city']);
							addchp($coma[rand(0,count($coma)-1)],"�����������",$user['room'],$user['id_city']);
							echo "<font color=red><b>������� �������� �������� ����� �� ��������� \"$target\"</b></font>";
							cancel_exchange_all($tar['id']);
						}
						else {
							echo "<font color=red><b>��������� ������!<b></font>";
						}
					}
					else {
						echo "<font color=red><b>�� �� ������ �������� �������� ����� �� ����� ���������!<b></font>";
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
