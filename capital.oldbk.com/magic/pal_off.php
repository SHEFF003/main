<?php
// magic �������������
	//if (rand(1,2)==1) {

		if (!($_SESSION['uid'] >0)) header("Location: index.php");

		$tar = mysql_fetch_array(mysql_query("SELECT `id`,`align` FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
		$target=$_POST['target'];
		if ($tar['id']) {
			if ($tar['align'] > '1' && $tar['align'] < '2') {
				$ok=0;
				if ($user['align'] > '2' && $user['align'] < '3') {
					$ok=1;
				}
				elseif (($user['align'] == '1.99') && ($tar['align'] != '1.99')) {
					$ok=1;
				}
				if ($ok == 1) {
					if (mysql_query("UPDATE `users` SET `align`='0',`status`='',`klan`='' WHERE `id` = {$tar['id']} LIMIT 1;")) {
						if ($user['sex'] == 1) {$action="�����";}
						else {$action="������";}
						if ($user['align'] > '2' && $user['align'] < '3')  {
							$angel="�����";
						}
						elseif ($user['align'] > '1' && $user['align'] < '2') {
							$angel="�������";
						}
						$mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; ������ &quot;�������&quot;.";

						mysql_query("DELETE FROM pal_rights WHERE pal_id = {$tar['id']}");
						mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
						mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','5');");
						echo "<font color=red><b>�������� \"$target\" ����� ������ \"�������\"</b></font>";
					}
					else {
						echo "<font color=red><b>��������� ������!<b></font>";
					}
				}
				else {
					echo "<font color=red><b>�� �� ������ ����� ����� ����� ���������!<b></font>";
				}
			}
			else {
				echo "<font color=red><b>�������� \"$target\" �� ������� � ������ </b></font>";
			}
		}
		else {
			echo "<font color=red><b>�������� \"$target\" �� ����������!<b></font>";
		}
?>
