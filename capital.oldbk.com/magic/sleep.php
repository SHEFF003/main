<?php

$coma[] = "� ��� ������ ������ ������ ��� ��������.";
$coma[] = "� ��� ��� ������? ;)";
$coma[] = "� ������ ��� �� ��� ���� ";
$coma[] = "���������� ���� ������� �������?";
$coma[] = "��� �������� �����, � ������� ��������!!!";
$coma[] = "��������? ��� ���� ������� ��������� �������.";
$coma[] = "��� � ��� ���� ��� �� ��� ��������";
$coma[] = "� ����� ������� ������... ������ �� ���� ��������� �� ����������! ";
$coma[] = "�������� ������ �������� �������� ��������... ";
$coma[] = "����� �� ��� ";
$coma[] = "��� ����� ����� ����� ������ ";
$coma[] = "�������, �� ����������� ";
$coma[] = "�����. � ������ ���� �� �������.";
$coma[] = "������, ���� ��� ������� � ���� ���� ";
$coma[] = "� ������...";
$coma[] = "�������� - ������. ����� ���� �������. ";
$coma[] = "�������� �� �����, ������ ��� ��� ��������� �� ������... (�), �� ��� ������ � �������������!";
$coma[] = "�������� - ��� ������ ���� ������������ ��� ��������.";
$coma[] = "�� ���� ����� ���!";
$coma[] = "��� ����� ������ ������... ";
$coma[] = "�� ���������, �� �������� ������.";
$coma[] = "��, ���, �����?";
$coma[] = "��, �������-��!";
$coma[] = "� ��� � ���� ��������� ����� ��������, ����� � ��� � ��������� �� �� � ���! ";
$coma[] = "�� ������ �������.";
$coma[] = "���� �� �������� �������� ����� - ��������.";
$coma[] = "�������� ���������, ����� ���� ���������.";
$coma[] = "���� ��� ����� ������, ������ ��� �����������.";
$coma[] = "���� ��� �������, ���� ��� ��������. ";
$coma[] = "������� ���� �����. ����� ��������� ��������... ";
$coma[] = "���� �������, ��� �� ��������. ";
$coma[] = "� ��� ���� ����� ������� �������� ";
$coma[] = "������ ����� ������, ��� ������ ����� ����� ���������. ";
$coma[] = "��� ��������� ���������� ��� ������ � ������ ";
$coma[] = "��� ���� ��������.";
$coma[] = "��� ���� ��� ���� ";
$coma[] = "� ��� ����� ������, ������ � ��� ���� ����� ��������.";
$coma[] = "� ������� �� ������, �� ��� ��� ��� �������� ";
$coma[] = "�������, �� ������ �������. ";


if (!($_SESSION['uid'] >0)) header("Location: index.php");
$_POST['timer']=isset($_POST['timer'])?(int)$_POST['timer']:'';

if($_POST['timer']>'0' && $_POST['timer'] <= '1'){$_POST['timer']='0.5';}
if($_POST['timer']>'1' && $_POST['timer'] <= '15'){$_POST['timer']='15';}
if($_POST['timer']>'15' && $_POST['timer'] <= '30'){$_POST['timer']='30';}
if($_POST['timer']>'30' && $_POST['timer'] <= '60'){$_POST['timer']='60';}
if($_POST['timer']>'60' && $_POST['timer'] <= '180'){$_POST['timer']='180';}
if($_POST['timer']>'180' && $_POST['timer'] <= '360'){$_POST['timer']='360';}
if($_POST['timer']>'360' && $_POST['timer'] <= '720'){$_POST['timer']='720';}
if($_POST['timer']>'720' && $_POST['timer'] <= '1440'){$_POST['timer']='1440';}

$admindays = false;

if (isset($_REQUEST['admindays']) && ADMIN) {
	$_REQUEST['admindays'] = intval($_REQUEST['admindays']);
	if ($_REQUEST['admindays'] > 0) {
		$_POST['timer'] = $_REQUEST['admindays']*60*24;
		$admindays = true;
	}
}


	$magictime=time()+($_POST['timer']*60);
	$target=$_POST['target'];
	//for hiddens sleep

	if ( strpos($target,"���������:" ) !== FALSE )
	{
		$hitarget=explode(":",$target);
		$target=$hitarget[0];
		$realtar=mysql_fetch_array(mysql_query("SELECT * FROM effects WHERE `idiluz` = '{$hitarget[1]}' LIMIT 1;"));
		$tar = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '{$realtar[owner]}' LIMIT 1;"));
		$realnametarget=$tar[login];
	}
	else
	{
		$realnametarget=$target;
		$tar = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
	}
//
	


	if ($tar['id']) 
	{
		$tar=check_users_city_data($tar[id]);
			
		if($tar[id_city]==$user[id_city] || ADMIN)
		{	

			if ($user['id'] ==5) { $user['align']=1.1;}
			
			$updatetime = 0;
			$effect = mysql_fetch_array(mysql_query("SELECT * FROM ".$db_city[$tar[id_city]]."`effects` WHERE `owner` = '{$tar['id']}' and `type` = '2' and pal = 1 LIMIT 1;"));
			if ($effect['time'] && isset($_POST['updatetime'])) {
				$updatetime = 1;
			} elseif ($effect['time']) {
				echo "<font color=red><b>�� ���� ��������� ��� ���� �������� ��������!<b></font>";
				return;
			}

			$ok=0;
			if ((($user['align'] > '2' && $user['align'] < '3') || $user['align']==7) && $moj[$_POST['use']]==1) 
			{
				$ok=1;
			}
			elseif (($user['align'] > '1' && $user['align'] < '2' && $moj[$_POST['use']]==1) && ($tar['align'] > '1' && $tar['align'] < '2') && ($user['align'] > $tar['align'])) 
			{
				$ok=1;
			}
			elseif (($user['align'] > '1' && $user['align'] < '2' && $moj[$_POST['use']]==1) && !($tar['align'] > '2' && $tar['align'] < '3') && !($tar['align'] > '1' && $tar['align'] < '2')) 
			{
				$ok=1;
			}


			if ($tar['id'] ==12) { $ok=0; }
			if ($tar['id'] ==190672) { $ok=0; }
				
			if ($ok == 1) 
			{
				if ($updatetime) {
					$q = mysql_query('UPDATE effects SET time = time + '.($_POST['timer']*60).' WHERE id = '.$effect['id'].' LIMIT 1');
				} else {
					$q = mysql_query("INSERT INTO ".$db_city[$tar[id_city]]."`effects`
					(`owner`,`name`,`time`,`type`,`pal`)
					values
					('".$tar['id']."','�������� ��������','$magictime',2,1);");
				}

				if ($q) {
					$ldtarget=$target;
					switch($_POST['timer']) 
					{
						case "0.5": $magictime="��������"; break;
						case "15": $magictime="15 ���."; break;
						case "30": $magictime="30 ���."; break;
						case "60": $magictime="1 ���."; break;
						case "180": $magictime="3 ����."; break;
						case "360": $magictime="6 �����."; break;
						case "720": $magictime="12 �����."; break;
						case "1440": $magictime="1 �����."; break;
						case "2880": $magictime="2-� �����."; break;
						case "4320": $magictime="3-� �����."; break;	
						case "10080": $magictime="1 ������."; break;								
						
					}

					if ($admindays) {
						$magictime = $_REQUEST['admindays']." ����.";
					}


					if ($user['align'] > '2' && $user['align'] < '3')  
					{
						$angel="�����";
					}
					elseif ($user['align'] > '1' && $user['align'] < '2') 
					{
						$angel="�������";
					}

					if ($updatetime == 1) {
						if ($user['sex'] == 1) {$action="��������";} else {$action="���������";}
						$mess="$angel &quot;{$user['login']}&quot; $action �������� �������� ��������� &quot;$realnametarget&quot;, ���������� ���� $magictime";
						$messch="$angel &quot;{$user['login']}&quot; $action �������� �������� ��������� &quot;$target&quot;, ���������� ���� $magictime";
	
						echo "<font color=red><b>������� �������� �������� �������� �� ��������� \"$target\"</b></font>";
					} else {
						if ($user['sex'] == 1) {$action="�������";} else {$action="��������";}
						$mess="$angel &quot;{$user['login']}&quot; $action �������� �������� �� &quot;$realnametarget&quot; ������ $magictime";
						$messch="$angel &quot;{$user['login']}&quot; $action �������� �������� �� &quot;$target&quot; ������ $magictime";
		
						echo "<font color=red><b>������� �������� �������� �������� �� ��������� \"$target\"</b></font>";
					}

					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
					mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','10');");
	
					mysql_query("UPDATE ".$db_city[$tar[id_city]]."users set slp=1 where id={$tar['id']} ;");

					addch("<img src=i/magic/sleep.gif> $messch",$user['room'],$user['id_city']);
					addchp($coma[rand(0,count($coma)-1)],"�����������",$user['room'],$user['id_city']);

			                if($tar[room]!=$user[room]) {
			                	addchp (' <img src=i/magic/sleep.gif> '.$messch,'{[]}'.$tar['login'].'{[]}',$tar['room'],$tar['id_city']);
			                }

				}
				else 
				{
					echo "<font color=red><b>��������� ������!<b></font>";
				}
			}
			else 
			{
				echo "<font color=red><b>�� �� ������ �������� �������� �������� �� ����� ���������!<b></font>";
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
