<?php

	if (!($_SESSION['uid'] >0)) header("Location: index.php");
	$chanse = 80+$user['intel'];
	require_once('./dt_rooms.php');
		// �����
	$q = mysql_query('SELECT * FROM dt_items WHERE type = 1 AND room = '.$user['room']) or die();
	if (mysql_num_rows($q) > 0) {
		echo "<font color=red><b>� ���� ������� ��� ���� �������!<b></font>";
	} else {
		if($user['intel'] >= 8) {
			if(rand(1,100) <= $chanse) {
				# ok, 
				if ($user['sex'] == 1) {$action="���������";}
				else {$action="����������";}
        
				$komnata = $dt_rooms[$user['room']][0];
				echo "<font color=red><b>�� ���������� ������� � ''{$komnata}''</b></font>";	
				mysql_query('INSERT INTO `dt_items` (type,name,img,room,extra) VALUES ("1","�������","",'.$user['room'].','.$user['id'].')') or die();
				$bet=1;			
				$sbet = 1;
			} else {
				# ������
				echo "<font color=red><b>������ ���������� � ����� �����...<b></font>";
				$bet = 1;
			}
		}else {
			echo "<font color=red><b>������������ ���������..<b></font>";
		}
	}
?>
