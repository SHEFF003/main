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

	$magictime=0;
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
			
		if(($tar[id_city]==$user[id_city]) || ADMIN)
		{	
			
			$effect = mysql_fetch_array(mysql_query("SELECT `time` FROM ".$db_city[$tar[id_city]]."`effects` WHERE `owner` = '{$tar['id']}' and `type` = '2' LIMIT 1;"));
			if ($effect['time']) 
			{
				echo "<font color=red><b>�� ��������� \"$target\" ��� ���� �������� �������� </b></font>";
			}
			else 
			{
				$ok=1;
				if ($ok == 1) 
				{
					
					$ldtarget=$target;

					$magictime="���������."; 							
						
					
					if ($user['sex'] == 1) {$action="�������";}
					else {$action="��������";}
					if ($user['align'] > '2' && $user['align'] < '3')  
					{
						$angel="�����";
					}
					elseif ($user['align'] > '1' && $user['align'] < '2') 
					{
						$angel="�������";
					}
					$mess="$angel &quot;{$user['login']}&quot; $action �������� �������� �� &quot;$realnametarget&quot; ������ $magictime";
					$messch="$angel &quot;{$user['login']}&quot; $action �������� �������� �� &quot;$target&quot; ������ $magictime";	

					addch("<img src=i/magic/sleep.gif> $messch",$user['room'],$user['id_city']);
			                if($tar[room]!=$user[room])
			                {
			                	addchp (' <img src=i/magic/sleep.gif> '.$messch,'{[]}'.$tar['login'].'{[]}',$tar['room'],$tar['id_city']);
			                }

					addchp($coma[rand(0,count($coma)-1)],"�����������",$user['room'],$user['id_city']);
					echo "<font color=red><b>������� �������� �������� �������� �� ��������� \"$target\"</b></font>";
				
		
				}
				else 
				{
					echo "<font color=red><b>�� �� ������ �������� �������� �������� �� ����� ���������!<b></font>";
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
