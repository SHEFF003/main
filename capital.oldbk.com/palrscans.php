<?php
die();
	session_start();

	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

	include "connect.php";
	include "functions.php";

	if (!(ADMIN || ($user['align'] == "1.5" || $user['align'] == "1.7" || $user['align']  == "1.9" || $user['align'] == '1.91' || $user['align'] == '1.99'))) die();

$message = array(
	0 => "������� ������������ ����-����� ����������, ������� ���������� ��������� ����� ������ �������������� ��������� (JPG, ������ �� 2 ��, �������, �� ����������: %NICKS%. ���� �������������� �� �������: %DATE% ����� �������� �������� �����������, ���� � ������.",
	1 => "������� ������������ \"�����-����\" ��������� � ���������, ������� ���������� ��������� ����� ������ �������������� ��������� (JPG, ������ �� 2 ��, �������, �� ����������: %NICKS%. ���� �������������� �� �������: %DATE% ����� �������� �������� �����������, ���� � ������.",
);

$ld = array(
	0 => "��������� ����-����� ���������� �� ����������: %NICKS%. ���� �������������� �� �������: %DATE%",
	1 => "��������� \"�����-����\" ��������� � ��������� �� ����������: %NICKS%. ���� �������������� �� �������: %DATE%",
);


?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script type="text/javascript" src="/i/globaljs.js"></script>
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/steel/steel.css" />
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/jscal2.js"></script>
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/lang/ru2.js"></script>
<script>
var cnick = 2;
function addnick() {
	var obj = document.getElementById("nicks");
	cnick++;
	obj.innerHTML += cnick+'. <input type="text" name="nick'+cnick+'"><br>';
}
function changeld(id) {
	for (i = 0; ;i++) {
		tmp = document.getElementById("ld"+i);
		if (tmp) {
			tmp.style.display = "none";
		} else {
			break;
		}
	}	
	document.getElementById("ld"+id).style.display = "";
}
</script>
</HEAD>
<body bgcolor="#e2e0e0">
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$nicks = array();
	for ($i = 1;;$i++) {
		if (isset($_POST['nick'.$i])) {
			$_POST['nick'.$i] = trim($_POST['nick'.$i]);
			if (strlen($_POST['nick'.$i])) {
				$nicks[] = '"'.mysql_real_escape_string($_POST['nick'.$i]).'"';
			}
		} else {
			break;
		}
	}
	if (count($nicks) > 0) {
		$q = mysql_query('SELECT * FROM users WHERE login IN ('.implode(",",$nicks).')');
		if (mysql_num_rows($q) == count($nicks)) {
			if (isset($_POST['message']) && isset($message[$_POST['message']])) {
				$nicks = array();
				while($u = mysql_fetch_assoc($q)) {
					$nicks[] = '"'.mysql_real_escape_string($u['login']).'"';					
				}

				$q = mysql_query('SELECT * FROM users WHERE login IN ('.implode(",",$nicks).')');
				while($u = mysql_fetch_assoc($q)) {
					echo '<b>'.$u['login'].'</b>: ';
	
					$mess = $ld[$_POST['message']];
					$mess = str_replace("%NICKS%",implode(",",$nicks),$mess);
					$mess = str_replace("%DATE%", date("d.m.Y H:i",time()+72*3600),$mess);
					$mess = "��������� �� ".$user['login'].": ".$mess;
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$u['id']."','".mysql_real_escape_string($mess)."','".time()."')");
					echo '������ ��������� ������ � ������ ����. ';

					$mess = $message[$_POST['message']];
					$mess = str_replace("%NICKS%",implode(",",$nicks),$mess);
					$mess = str_replace("%DATE%", date("d.m.Y H:i",time()+72*3600),$mess);
					echo telegraph_new($u,$mess);
					echo '<br>';
				}
				
			} else {
				err("��� ��������� �� ������");
			}
		} else {
			err("�� ��� ���� �������, �������� ������");
		}
	}
}
?>
<h2>������� ���� ��� ������� ������ <a href="#" OnClick='addnick();return false;'>+</A></h2>
<form method="POST">
<span id = "nicks">
1. <input type="text" name="nick1"><br>
2. <input type="text" name="nick2"><br>
</span>
<h2>��������� ��� ���������:</h2>
<table>
<?php
while(list($k,$v) = each($message)) {
	echo '<tr><td><input OnClick="changeld('.$k.');" type=radio name=message value="'.$k.'"></td><td>'.$v.'</td></tr>';
}
?>
</table>
<h2>��������� ��� ������ � ��:</h2>
<table>
<?php
while(list($k,$v) = each($ld)) {
	echo '<tr><td style="display:none;" id="ld'.$k.'">'.$v.'</td></tr>';
}
?>
</table>
<input type="submit" value="����������">
</form>
</body>
</html>
