<?php
	$mlglobal = 1;
	require_once('mlglobal.php');

	$questexist = false;
	$qcomplete = false;
	$qlist = array(19,22);
	$q = mysql_query('SELECT * FROM oldbk.map_quests WHERE owner = '.$user['id']) or die();
	if (mysql_num_rows($q) > 0) {
		$questexist = mysql_fetch_assoc($q) or die();
	} else {
		$q = mysql_query('SELECT * FROM map_var WHERE var = "cango" AND owner = '.$user['id'].' AND val > '.time()) or die();
		if (mysql_num_rows($q) > 0) {
			$questexist['q_id'] = 0;
		}

		$q = mysql_query('SELECT * FROM map_qvar WHERE var = "qcomplete" AND owner = '.$user['id']) or die();
		if (mysql_num_rows($q) > 0) {
			$qcomplete = mysql_fetch_assoc($q);
			$qt = explode("/",$qcomplete['val']);
			$qcomplete = array();
			while(list($k,$v) = each($qt)) {
				$qcomplete[$v] = 1;
			}
			$q0 = true;
			reset($qlist);
			while(list($k,$v) = each($qlist)) {
				if (!isset($qcomplete[$v])) {
					$q0 = false;
					break;
				}
			}
			if ($q0) $questexist['q_id'] = 0;
		}
	}


	$mlhorse = array(
		1 => array(
			"0"  => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
			"d2" => "������ �� �������",
			"d3" => "������� ������",
			"1"  => "��� �� �������� �� ���� �� ����� ������. ������.",
		),
		2 => array(
			"0"  => "������, ��� �� ��������. ��� ���-��� ������ ���������. � ����� ������� ������� � ��������. � ������ ������� ������� �����, ���� ������ � ����� ��������, �� ������� �������� ���-��� ����� ����������. ���� ����� � ���� ���� ������ � � � ����� �� ��������.",
			"q19" => "������, � ������, ��� ���� ������?",
			"11111" => "���, � �� ����� ��� �������, ����.",
		),
		3 => array(
			"0"  => "��� ������ ������! ��� ������� ������ ��������  - ��������� ��� ������ ���� ��� ����� � ������ �� � ����� ������ �� ����. ������ � ������ ��� ����� ���������! � ������ � ���������� � ������� ���� �������� ��������",
			"q22" => "������, ������ ��� �����. ����!",
			"11111" => "���, ��� ��� �� ��������, ����.",
		),
		"thx19" => array(
			"0" => "������� ��� ������� ������, ���� �������� ���� ���������� ��� �����, �� � ���� �������� �� �������� ��.",
			"11111" => "������, � ������� ���� ��� ��� �����.",
		),
	);

	if ((isset($_GET['qaction']) && strlen($_GET['qaction']) && $questexist === FALSE) && $user['room'] <= ($maprel+$maprelall+8)) {
		$qa = $_GET['qaction'];
		$num = -1;
		if (!is_numeric($qa[0])) {
			$num = intval(substr($qa,1));
		} else {
			$num = $_GET['qaction'];
		}
		if ($num < 30000) {
			if ($qa[0] == "d" && isset($mlhorse[$num])) {
				$mldiag = $mlhorse[$num];
	
				// ��� ������ ����� �����������
				if (isset($qcomplete[19]) && isset($mldiag["d2"])) unset($mldiag['d2']);
				if (isset($qcomplete[22]) && isset($mldiag["d3"])) unset($mldiag['d3']);
			} elseif ($qa[0] == "q") {
				if ($num == 19 && !isset($qcomplete[19])) {
					// ����� - ������ �� ������� 
					mysql_query('START TRANSACTION') or QuestDie();				
					SetNewQuest($user,19,"0/0/0") or QuestDie();
	                                mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlhorse["thx19"];
				}

				if ($num == 22 && !isset($qcomplete[22])) {
					// ����� - ������� ������
					mysql_query('START TRANSACTION') or QuestDie();				
					SetNewQuest($user,22) or QuestDie();
	                                mysql_query('COMMIT') or QuestDie();
					unsetQA();
				}

			} else {
				UnsetQA();
			}	
		}
	}
?>


<HTML><HEAD>
<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
    <link rel="stylesheet" href="/i/btn.css" type="text/css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<script type="text/javascript" src="/i/globaljs.js"></script>
<script>
var loc = parent.location.href.toString();
if (loc.indexOf("/map.php") != -1) {
	parent.location.href = "<?php echo $self; ?>";
}
</script>
<style> 
    IMG.aFilter { filter:Glow(Color=d7d7d7,Strength=9,Enabled=0); cursor:hand }
</style>
<style type="text/css"> 
img, div { behavior: url(/i/city/ie/iepngfix.htc) }
</style>
</HEAD>
<body id="body" leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#d7d7d7" onResize="return; ImgFix(this);">
<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0">
<TR>
	<TD align=center></TD>
	<TD align=right>
		<div class="btn-control">
            <input class="button-mid btn" type="button" style="cursor: pointer;" name="��������" value="��������" OnClick="location.href='?'+Math.random();">
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlhorse.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table width=1><tr><td>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlhorse_bg.png" id="mainbg">
<a href="?quest"><img style="z-index:3; position: absolute; left: 300px; top: 100px;" src="http://i.oldbk.com/i/map/mlhorse_pers1.png" alt="�����" title="�����" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlhorse_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlhorse_pers1.png'"/></a>
<?php

$q_goodhorse = array(19,22,24);

function HorseSD($user,$maprel,$maprelall,$questexist) {
	$map_horseprice = 10;
	$addtxt = " ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?";

	$mldiag = array();

	if (isset($_GET['qaction'])) {
		if ($_GET['qaction'] == 30001 && $user['horse']) {
			$q = mysql_query('START TRANSACTION') or QuestDie();
			$addmoney = $map_horseprice*0.5;
			mysql_query('UPDATE oldbk.`users` SET money = money + '.$addmoney.', podarokAD = 0 WHERE id = '.$user['id']) or QuestDie();
			$rec = array();

    			$rec['owner']=$user[id]; 
			$rec['owner_login']=$user[login];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money']+$addmoney;
			$rec['target_login']="�����";
			$rec['sum_kr'] = $addmoney;
			$rec['type'] = 258;
			if(add_to_new_delo($rec) === FALSE) QuestDie();
		
			$q = mysql_query('COMMIT') or QuestDie();

			$mldiag = array(
				0 => "�� ������� ������ � �������� ".$addmoney." ��.",
				11111 => "�������, ����!",
			);				
		} elseif ($_GET['qaction'] == 30002 && !$user['horse']) {
			$mldiag = array(
				0 => "���� ���� ������ ���-�� ������, ������ �� �� ������ ��� ���? �� ����� ���� � ���� ������.",
				30003 => "��, � ���� ����� ��� ������� ������� ��� ������.",
				30004 => "���, ��� ��� �����, ��� ��� �������.",
			);
		} elseif (($_GET['qaction'] == 30003 || $_GET['qaction'] == 30004) && !$user['horse']) {
			$q = mysql_query('START TRANSACTION') or QuestDie();
			$getmoney = $map_horseprice;

			if ($user['money'] < $getmoney) {
				Redirect('mlhorse.php');
			}

	
			$alarmhorse = $_GET['qaction'] == 30003 ? 1 : 0;

			mysql_query('UPDATE oldbk.`users` SET money = money - '.$getmoney.', podarokAD = 1, injury_possible  = '.$alarmhorse.' WHERE id = '.$user['id']) or QuestDie();

			$rec = array();
    			$rec['owner']=$user[id]; 
			$rec['owner_login']=$user[login];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money']-$getmoney;
			$rec['sum_kr'] = $getmoney;
			$rec['target_login']="�����";
			$rec['type'] = 257;
			if(add_to_new_delo($rec) === FALSE) QuestDie();

			$q = mysql_query('COMMIT') or QuestDie();

			$mldiag = array(
				0 => "�� ��������� ������ � ���������: ".$getmoney." ��.",
				11111 => "�������, ����!",
			);
		} elseif ($_GET['qaction'] == 30000) {
			$mldiag = array(
				0 => "����������� ����, ������! ��� � ���� ���� ������? � ����� ������� ����� ������ ������ �� 10 ��. ��� ������� �� �� 5 ��. ",
			);
			if ($user['horse']) {
				$mldiag[30001] = "� ���� ������� ������ �� ".($map_horseprice*0.5)." ��.";
			} else {
				if ($user['money'] >= 10) $mldiag[30002] = "� ���� ������ ������ �� ".$map_horseprice." ��.";
			}
			if ($user['room'] <= ($maprel+$maprelall+8) && $questexist === FALSE) {
				$mldiag[0] .= $addtxt;
				$mldiag["d1"] = "��, � ����� ������. ������, ��� ���� �������.";
			}
			$mldiag[11111] = "���, ��� ������ �� ����, ����!";
		} else {
			unsetQA();
		}
	} else {
		$mldiag = array(
			0 => "����������� ����, ������! ��� � ���� ���� ������? � ����� ������� ����� ������ ������ �� 10 ��. ��� ������� �� �� 5 ��.",
		);
		if ($user['horse']) {
			$mldiag[30001] = "� ���� ������� ������ �� ".($map_horseprice*0.5)." ��.";
		} else {
			if ($user['money'] >= 10) $mldiag[30002] = "� ���� ������ ������ �� ".$map_horseprice." ��.";
		}

		if ($user['room'] <= ($maprel+$maprelall+8) && $questexist === FALSE) {
			$mldiag[0] .= $addtxt;
			$mldiag["d1"] = "��, � ����� ������. ������, ��� ���� �������.";
		}
		$mldiag[11111] = "���, ��� ������ �� ����, ����!";
	}
	return $mldiag;
}



if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
	if ($questexist !== FALSE && in_array($questexist['q_id'],$q_goodhorse) !== FALSE) {
		// ���� ����� - ���������� ��������� ����������, ��������� ����������� ������ ���� ���������� ������� ��������� � ��������-�������� ������
		// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
		if (isset($_GET['qaction']) && $_GET['qaction'] >= 30000) {
			$mldiag = HorseSD($user,$maprel,$maprelall,$questexist);
		} else { 
			require_once('./mapquests/'.$questexist['q_id'].'.php');
		}
	} else {
		// ���� ������, �������������
		if (isset($_GET['quest']) || (isset($_GET['qaction']) && $_GET['qaction'] >= 30000)) {
			$mldiag = HorseSD($user,$maprel,$maprelall,$questexist);
		}
	}

	$mlquest = "5/100";
	if (isset($_GET['quest']) || isset($_GET['qaction'])) require_once('mlquest.php');		
}	
?>
</div>


</td></tr></table>
 
</div>
</TD>
</TR>
</TABLE>

<?php
	require_once('mldown.php');
?>