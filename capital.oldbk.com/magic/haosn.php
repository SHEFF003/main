<?php

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
if ($_POST['timer'] == 365) $magictime = $magictime + (10*365*24*3600);

$tar = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
$target=$_POST['target'];
if ($tar['id']) {
	$tar=check_users_city_data($tar[id]);
	if($tar[id_city]==$user[id_city] || ADMIN) {
		$effect = mysql_fetch_array(mysql_query("SELECT * FROM ".$db_city[$tar[id_city]]."`effects` WHERE `owner` = '{$tar['id']}' and `type` = '4' LIMIT 1;"));
	
		$ok=0;
		if ($user['align'] > '2' && $user['align'] < '3') {
			$ok=1;
		} elseif (($user['align'] > '1.6' && $user['align'] < '2') && ($tar['align'] > '1' && $tar['align'] < '2') && ($user['align'] > $tar['align'])) {
			$ok=1;
		} elseif (($user['align'] > '1.6' && $user['align'] < '2') && !($tar['align'] > '2' && $tar['align'] < '3') && !($tar['align'] > '1' && $tar['align'] < '2')) {
			$ok=1;
		}

		if ($ok == 1) {
			if($_POST['timer']==365 && (ADMIN) && ($_POST[ekr]>0 || !($_POST[kr]>0))) {
				$ok=1;
			} elseif($_POST['timer']==365 && $_POST[ekr] == 0 && $_POST[kr] == 0) {
				$ok=1;
			} elseif($_POST['timer']==365 && $_POST[kr]>0) {
				$ok=1;
			} elseif($_POST['timer']<365) {
				$ok=1;
			} else {
				echo '<font color=red><b>������� �� ������ �������� ������</b></font><br>';
				$ok = 0;
			}
		}


		if ($ok == 1) {
       			$vik=array();
			$for_del = 0;

			switch($_POST['timer'])	{
				case "2": $magictime_txt="��� ���."; $vik[ekr]=10; break;
				case "3": $magictime_txt="��� ���."; $vik[ekr]=15;break;
				case "7": $magictime_txt="������."; $vik[ekr]=35; break;
				case "14": $magictime_txt="��� ������."; $vik[ekr]=70; break;
				case "30": $magictime_txt="�����."; $vik[ekr]=150; break;
				case "31": $magictime_txt="����� (����)."; $vik[ekr]=300; break;
				case "60": $magictime_txt="��� ������."; $vik[ekr]=300; break;
				case "365": $magictime_txt="���������."; $for_del=1; break;
				default: die(); break;
			}


			if(isset($_POST[kr]) && $_POST['timer']==365) {
				$vik[kr]=(int)$_POST[kr];
				$ok=1;
			} elseif(isset($_POST[ekr]) && $_POST['timer']==365 && (ADMIN)) {
				$vik[ekr]=(int)$_POST[ekr];
				$ok=1;
				$for_del=0;
			} elseif($_POST['timer']<365 && isset($_POST[ekr]) && (ADMIN)) {
				$vik[ekr]=(int)$_POST[ekr];
				if ($vik[ekr] == 0) {
					switch($_POST['timer'])	{
						case "2": $vik[ekr]=10; break;
						case "3": $vik[ekr]=15;break;
						case "7": $vik[ekr]=35; break;
						case "14": $vik[ekr]=70; break;
						case "30": $vik[ekr]=150; break;
						case "31": $vik[ekr]=300; break;
						case "60": $vik[ekr]=300; break;
					}
				}
				$ok=1;
			} elseif($_POST['timer']<365) {
				$ok=1;
				//��� ������ �������� � ������, ����� ������� - ������� ���� � �����
			} else {
				$ok=0;
				echo '��� �� �� ���...';
			}


			if ($effect['time'] > 0 && ($effect['time'] - time()) >= $magictime-time()) {
				echo "<font color=red><b>�� �� ������ �������� ���� ������, ��� ���!</b></font>";
				$ok = 0;
			}

			if ($ok == 1) {
				if (!$effect['time']) {
					Test_Arsenal_Items($tar,0,0,1);
					$exp=0;
					$exp=($tar[align]==1.5?($exp-0.1):$exp);
					$exp=($tar[align]==1.7?($exp-0.2):$exp);
					$exp=($tar[align]==1.9?($exp-0.3):$exp);
					$exp=($tar[align]==1.91?($exp-0.4):$exp);
					$exp=($tar[align]==1.99?($exp-0.5):$exp);
					foreach($db_city as $k=>$v) {
						mysql_query("UPDATE ".$v."`users` SET `align`='4', klan='', status='', expbonus=expbonus+".$exp." WHERE `id` = {$tar['id']} LIMIT 1;");
					}

					undressall($tar['id'],$tar['id_city']); 
				} else {
					// ���� ��� �����, �������-���������
					mysql_query("DELETE FROM ".$db_city[$tar[id_city]]."`effects` WHERE id = ".$effect['id']);
				}

				mysql_query("INSERT INTO ".$db_city[$tar[id_city]]."`effects` (`owner`,`name`,`time`,`type`,`add_info`,`pal`,`lastup`) values ('".$tar['id']."','�������� �����','$magictime',4,'".serialize($vik)."','".$for_del."','".time()."')");
								
				if ($user['sex'] == 1) {
					if ($effect['time']) {
						$action="������������";
					} else {
						$action="��������";
					}
				} else {
					if ($effect['time']) {
						$action="�������������";
					} else {
						$action="���������";
					}
				}
	
				if ($user['align'] > '2' && $user['align'] < '3')  {
					$angel="�����";
				} elseif ($user['align'] > '1' && $user['align'] < '2') {
					$angel="�������";
				}

				$mess = "$angel &quot;{$user['login']}&quot; $action � ���� &quot;$target&quot; ������ ".$magictime_txt .(($vik[kr]>0?' �����: '.$vik[kr].'��.':'').($vik[ekr]>0?' {ee}�����: '.$vik[ekr].'���.{ee}':''));
				$messch = "$angel &quot;{$user['login']}&quot; $action � ���� &quot;$target&quot; ������ ".$magictime_txt;

				mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
				mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','8');");
				$ldblock = 1;
				$ldtarget=$target;
				// �������� ��� ���� �� �������� �����
				if (!$eff['time']) mysql_query('UPDATE oldbk.rentalshop SET maxendtime = "'.time().'" WHERE owner = '.$tar['id']);
	
				addch("<img src=i/magic/haos.gif> $messch",$user['room'],$user['id_city']);
				addchp($coma[rand(0,count($coma)-1)],"�����������",$user['room'],$user['id_city']);
				echo "<font color=red><b>������� �������� �������� ����� �� ��������� \"$target\"</b></font>";
				deny_money_out($tar,"�� ��� �������� �������� �����");
				@file_get_contents('http://blog.oldbk.com/api/refresh.html?game_id='.$tar['id']);
			}
		} else {
			echo "<font color=red><b>�� �� ������ �������� �������� ����� �� ����� ���������!<b></font>";
		}
	} else {
		echo "<font color=red><b>�������� \"$target\" � ������ ������!<b></font>";
	}	
} else {
	echo "<font color=red><b>�������� \"$target\" �� ����������!<b></font>";
}
?>