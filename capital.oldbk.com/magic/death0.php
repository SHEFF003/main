<?php
// magic �������������
	//if (rand(1,2)==1) {

$coma[] = "��� ���. ������ �������, ��� ������ ����� �����. ";
$coma[] = "��� ����� ����������� � ������� ������. ";
$coma[] = "��� ������ �� ����-�� ������� ���������� �������� ";
$coma[] = "��� �� ��� ����� ";
$coma[] = "�������� ���, �������� ������ ";
$coma[] = "����� ������� � �����������... ����� ������ ���, ������� �����. ";
$coma[] = "�� � ���� �� ���� �� �����... ���... ";
$coma[] = "���� ����� � ������ ������, ����� �������� � ���������� �����! ";
$coma[] = "�� ��������� � ��������� ����... �� ���������... ����, �����, ��� ��� ������. �����, ������. ";
$coma[] = "�� �������� ����� ������, ������� ���� �� ���� �����. ����� ����� ��������, ������ ��� ������. ";
$coma[] = "�� �������� ���������... ";
$coma[] = "���������� ������ � ����� ������ ";
$coma[] = "�������, �� ����� �������� ��������� ";
$coma[] = "�� ��� ������ �������� ";
$coma[] = "�� �� ����� ���������� ���� ";
$coma[] = "� ���������� �� ���� �� ������ � ��������, � ����� ������ �� �����, ������ � ������. ";
$coma[] = "�����, �� ����! ";
$coma[] = "������ �������, ���� ������������ ��� ������ �����";
$coma[] = "����� ����� �� ��, �� ������ ��������! ";
$coma[] = "���� ��� �� ��� ���� ����... ";
$coma[] = "� ���� ���� �� �������� ����� ���� ";
$coma[] = "� ���� ��� ���� � �� �������. ";
$coma[] = "� ��� ���� ����� ������ ������, �� �� �� �� �������";
$coma[] = "� ���������� ��� ���� �� ������ � ��������, � ����� ������ �� �����, ������ � ������.";


		if (!($_SESSION['uid'] >0)) header("Location: index.php");

		$tar = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
		$target=$_POST['target'];
		if($tar['level']<5)
		{
			if ($tar['id']) 
			{
				$tar=check_users_city_data($tar[id]);
				
				if($tar[id_city]==$user[id_city] || ADMIN)
				{
					if ($tar['block'] == 1) 
					{
						echo "<font color=red><b>�� ��������� \"$target\" ��� ���� �������� ������ </b></font>";
					}
					else 
					{
						$ok=0;
						if ($user['align'] > '2' && $user['align'] < '3') {
							$ok=1;
						}
						elseif (($user['align'] > '1.8' && $user['align'] < '2') && ($tar['align'] > '1' && $tar['align'] < '2') && ($user['align'] > $tar['align'])) {
							$ok=1;
						}
						elseif (($user['align'] > '1.8' && $user['align'] < '2') && !($tar['align'] > '2' && $tar['align'] < '3') && !($tar['align'] > '1' && $tar['align'] < '2')) {
							$ok=1;
						}
						elseif (($user['align'] == '1.7' && $tar['level'] == '0') && !($tar['align'] > '2' && $tar['align'] < '3')) {
							$ok=1;
						}
						if ($ok == 1) {
							if (mysql_query("UPDATE ".$db_city[$tar[id_city]]."`users` SET `block`='1' WHERE `id` = {$tar['id']} LIMIT 1;")) {
								Test_Arsenal_Items($tar,0,0,1);
								
								$ldtarget=$target;
								$ldblock=1;
								if ($user['sex'] == 1) {$action="�������";}
								else {$action="��������";}
								if ($user['align'] > '2' && $user['align'] < '3')  {
									$angel="�����";
								}
								elseif ($user['align'] > '1' && $user['align'] < '2') {
									$angel="�������";
								}
								$mess="$angel &quot;{$user['login']}&quot; $action �������� ������ �� &quot;$target&quot;.";
								$messch="$angel &quot;{$user['login']}&quot; $action �������� ������ �� &quot;$target&quot;..";
	
								mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
								mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','14');");

								// �������� ��� ���� �� �������� �����
								mysql_query('UPDATE oldbk.rentalshop SET maxendtime = "'.time().'" WHERE owner = '.$tar['id']);

								addch("<img src=i/magic/death.gif> $messch",$user['room'],$user['id_city']);
								addchp($coma[rand(0,count($coma)-1)],"�����������",$user['room'],$user['id_city']);
								echo "<font color=red><b>������� �������� �������� ������ �� ��������� \"$target\"</b></font>";
								deny_money_out($tar,"�� ��� �������� �������� ������");
							}
							else {
								echo "<font color=red><b>��������� ������!<b></font>";
							}
						}
						else {
							echo "<font color=red><b>�� �� ������ �������� �������� ������ �� ����� ���������!<b></font>";
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
		}
		else
		{
           		echo "<font color=red><b>�� �� ������ ������� ������ 4-��� ������!..<b></font>";
		}
?>
