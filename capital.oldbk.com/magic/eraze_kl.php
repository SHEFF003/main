<?php
// magic �������������
	//if (rand(1,2)==1) {

		if (!($_SESSION['uid'] >0))
		{
			header("Location: index.php");
			die();
		}

			$effect = mysql_fetch_array(mysql_query("SELECT `time` FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '5001' LIMIT 1;"));
			if ($effect['time']) {
					if (mysql_query("DELETE FROM`effects` WHERE `owner` = '{$user['id']}' and `type` = '5001' LIMIT 1 ;")) {

						$mess="���� ����� �� ������� ����� ������������";
						mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$user['id']."','$mess','".time()."');");
						echo "<font color=red><b>������� ���� ����� ���������� </b></font>";
						$bet=1;
						$sbet = 1;
					}
					else {
						echo "<font color=red><b>��������� ������!<b></font>";
					}

			}
			else {
				echo "<font color=red><b>�� ��������� ��� ������ �� ����������.</b></font>";
			}

?>
