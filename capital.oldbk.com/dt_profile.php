<?php
	session_start();
	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

	include "connect.php";
	include 'functions.php';
	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
	if ($user['room'] != '10000') { header('location: main.php'); die(); }

	$min_sila=15;
	$min_lovka=15;
	$min_inta=15;
	$min_vinos=15;
	
	$stats=107;

	// ������� �� ���������
	$q = mysql_query('SELECT * FROM dt_profile WHERE `owner` = '.$user['id']);
	if (mysql_num_rows($q) == 0) {
		$q = mysql_query('SELECT * FROM dt_usersvar WHERE `owner` = '.$user['id'].' and var = "defprofile"');
		if (mysql_num_rows($q) == 0) {
			// ���������� �������
			mysql_query('INSERT INTO dt_usersvar (owner,var,val) VALUES ('.$user['id'].',"defprofile","1")');
			mysql_query('INSERT INTO dt_profile (owner,name,sila,lovk,inta,vinos,intel) VALUES ('.$user['id'].',"������� ������ (��������������� �������)",20,20,41,20,6) ');
			mysql_query('INSERT INTO dt_profile (owner,name,sila,lovk,inta,vinos,intel) VALUES ('.$user['id'].',"������� ������ (��������������� �������)",25,25,26,25,6) ');
		}
	}

	
	undressall($_SESSION['uid']);

	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));

	if ((int)$_GET['delsn']>0) {
		mysql_query("DELETE FROM `dt_profile` WHERE `id`='".(int)$_GET['delsn']."' AND `owner` = ".$user['id']);
	}

	if(isset($_POST['name']) && !empty($_POST['name'])) {
		$_POST['sila'] = intval($_POST['sila']);
		$_POST['lovk'] = intval($_POST['lovk']);
		$_POST['inta'] = intval($_POST['inta']);
		$_POST['intel'] = intval($_POST['intel']);
		$_POST['vinos'] = intval($_POST['vinos']);
		$_POST['mudra'] = intval($_POST['mudra']);

		if($_POST['sila'] < $min_sila) {
			$error=1;
		} elseif($_POST['lovk'] < $min_lovka) {
			$error=1;
		} elseif($_POST['inta'] < $min_inta) {
			$error=1;
		} elseif($_POST['vinos'] < $min_vinos) {
			$error=1;
		} elseif($_POST['mudra'] < 0) {
			$error=1;
		} elseif ($stats == ($_POST['sila']+$_POST['lovk']+$_POST['inta']+$_POST['vinos']+$_POST['intel']+$_POST['mudra'])) { 
			$prize = '0';
			if($_POST['prize']==1) {
				$prize = '0';
			} elseif($_POST['prize'] == 2) {
				$prize = '1';
			}
			
			mysql_query('
				INSERT `dt_profile` (`owner`,`name`,`sila`,`lovk`,`inta`,`vinos`,`intel`,`mudra`,`prize`)
				VALUES (
					'.$user['id'].',
					"'.$_POST['name'].'",
					'.$_POST['sila'].',
					'.$_POST['lovk'].',
					'.$_POST['inta'].',
					'.$_POST['vinos'].',
					'.$_POST['intel'].',
					'.$_POST['mudra'].',
					'.$prize.'
				)  ON DUPLICATE KEY UPDATE
					`sila` = '.$_POST['sila'].',
					`lovk` = '.$_POST['lovk'].',
					`inta` = '.$_POST['inta'].',
					`vinos` = '.$_POST['vinos'].',
					`intel` = '.$_POST['intel'].',
					`mudra` = '.$_POST['mudra'].',
					`prize` = '.$prize
				) or die(mysql_error());
			echo "<font color=red><b>���������.</b></font>";
		} else {
			$error=1;

		}

		if($error==1) {
			echo "<font color=red><b>���-�� �� �� �� �������... ��������� ����� ��� �������������. <br>���������� ������������ ��� �����!</b></font>";
		}
	}


	$tec = array();
	if (isset($_GET['id'])) {
		$tec = mysql_fetch_array(mysql_query("SELECT * FROM `dt_profile` WHERE `owner` = ".$user['id']." AND `id` = ".intval($_GET['id'])));
	}

	if(isset($_GET['setdef'])) {
		mysql_query("UPDATE `dt_profile` SET `def` = 1 WHERE `owner` = ".$user['id']." AND `id` = ".(int)$_GET['setdef']);
		mysql_query("UPDATE `dt_profile` SET `def` = 0 WHERE `owner` = ".$user['id']." AND `id` <> ".(int)$_GET['setdef']);
		echo "<font color=red><b>���������.</b></font>";
	}
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
    <link rel="stylesheet" href="/i/btn.css" type="text/css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script type="text/javascript" src="/i/globaljs.js"></script>
</HEAD>
<body bgcolor=e2e0e0>
<h3>������� �������������</h3>
����� �� ��������� ������� � ��? ��������� ���� ����� ���, ��� �� ������, � ���������� � �������! ��������� �� ��������� �������, ���������� ���. �� ������ ��������� �������������� ����� ��������, � ������ �� �� ������� �� �������!
<BR><BR>
<table width=100% bordercolor=silver border=1 cellpadding=0 cellspacing=0>
	<tr bgcolor=silver>
		<td>��������</td><td width=25%>�� ��.</td><td>�������</td>
	</tr>
	<?php
	 $data = mysql_query("SELECT * FROM `dt_profile` WHERE `owner` = ".$user['id']);
	 while($row = mysql_fetch_array($data)) 
	 {
		echo "<tr onclick='location.href=\"?id={$row['id']}\";' style='cursor:pointer;'><td><B>{$row['name']}</B></td><td><a href='?setdef=".($row['def']?"":$row['id'])."'>".($row['def']?"<font color=red>�� ���������</font>":"����������")."</a></td>
		<td><a href='?delsn=".$row['id']."&ddname=".$row['name']."'>X</a></td></tr>\n";
	 }
	?>
</table><BR>
<div class="btn-control">
    <INPUT class="button-mid btn" TYPE=button value="��������" onclick="window.location.href='dt_profile.php';">
</div>
<script>
	function countall() {
		document.getElementById('stats').value = <?=$stats ?>-Math.abs(document.getElementById('sila').value)-Math.abs(document.getElementById('lovk').value)-Math.abs(document.getElementById('inta').value)-Math.abs(document.getElementById('vinos').value)-Math.abs(document.getElementById('intel').value)-Math.abs(document.getElementById('mudra').value);
	}
</script>
<form method="POST">
	����.: <input type="text" name="name" value="<?=$tec['name']?>"><br>
	����: ����<input type="radio" name="prize" value=1 <?=($tec['prize']==0?'checked':'')?> > ��������� <input type="radio" name="prize" value=2 <?=($tec['prize']==1?'checked':'')?>>
	<table cellpadding=0 cellspacing=0 >
		<tr bgcolor=silver>
			<td>�������������� &nbsp;</td><td>����.</td>
		</tr>
		<tr>
			<td>����� ����</td><td><?=$user[bpbonussila]?> �� ����� �����</td>
		</tr>

		<tr>
			<td>����</td><td><input type="text" id="sila" size=4 onblur="countall();" value="<?=$tec['sila']?>" name="sila"><���. <?=$min_sila?>></td>
		</tr>
		<tr>
			<td>��������</td><td><input type="text" id="lovk" size=4 onblur="countall();" value="<?=$tec['lovk']?>" name="lovk"><���. <?=$min_lovka?>></td>
		</tr>
		<tr>
			<td>��������</td><td><input type="text" id="inta" size=4 onblur="countall();" value="<?=$tec['inta']?>" name="inta"><���. <?=$min_inta?>></td>
		</tr>
		<tr>
			<td>������������</td><td><input type="text" id="vinos" size=4 onblur="countall();" value="<?=$tec['vinos']?>" name="vinos"><���. <?=$min_vinos?>></td>
		</tr>
		<tr>
			<td>���������</td><td><input type="text" id="intel" size=4 onblur="countall();" value="<?=$tec['intel']?>" name="intel"></td>
		</tr>
		<tr>
			<td>��������</td><td><input type="text" id="mudra" size=4 onblur="countall();" value="<?=$tec['mudra']?>" name="mudra"></td>
		</tr>
		<tr>
			<td>���������</td><td><input type="text" id="stats" name="stats" size=4 disabled value="<?=$stats?>"></td>
		</tr>
	</table>
	<div class="btn-control">
        <input class="button-big btn" type="submit" OnClick="if (document.getElementById('stats').value!=0) { alert('������ ������������� ������! '); return false; }" value="���������/��������">
    </div>
</form>
</body>
</html>
