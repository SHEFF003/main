<?php
	$mlglobal = 1;
	require_once('mlglobal.php');

	$q31 = false;
	$q = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31"') or die();
	if (mysql_num_rows($q) > 0) {
		$q31 = mysql_fetch_assoc($q);
	}
	if ($q31 !== false && $q31['val'] == 13) $q31 = false;

	$questexist = false;
	$qcomplete = false;
	$qlist1 = array(2,23);
	$qlist2 = array(26,27,28);
	$qlist3 = array(18);
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
			
			if (isset($_GET['qaction'])) {
				$qa = $_GET['qaction'];
				if (!is_numeric($qa[0])) {
					$num = intval(substr($qa,1));
				} else {
					$num = intval($qa);
				}
	
				if ($num < 1000) {
					$_GET['quest'] = 1;
				} elseif ($num > 1000 && $num < 2000) {
					$_GET['quest'] = 2;
				} elseif ($num > 2000 && $num < 3000) {
					$_GET['quest'] = 3;
				}
			}

			$q0 = true;
			$qname = "qlist".$_GET['quest'];
			if (isset($$qname) && is_array($$qname)) {
				reset($$qname);
				while(list($k,$v) = each($$qname)) {
					if (!isset($qcomplete[$v])) {
						$q0 = false;
						break;
					}
				}
			}
			if ($q0 && !$q31) $questexist['q_id'] = 0;
		}
	}


	$mlvillage1 = array(
		0 => array(
			"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
			"d1" => "��, � ����� ������. ������, ��� ���� �������.",
			"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
		),
		1 => array(
			"0"  => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
			"d2" => "�������� �����",
			"d3" => "���� ��� �����������",
			"1"  => "��� �� �������� �� ���� �� ����� ������. ������.",
		),
		2 => array(
			"0"  => "����� � ���� ���� ��������, � � ���� �������� ������ ������� �� ������� ���� �������. ��� ����� ��� �� ������� ��������, ���������� ������� � ��������� ������ ��������� �������. ���� �� ��������� ��� ��� ���, � �� �������� �������������.",
			"q2" => "������, � ������� ���� ���, ��� �����.",
			"d1" => "���, � �� ����� ��� �������",
		),
		3 => array(
			"0" => "� �����-��, � ��� �� ����, ��� ��� �����, �� ���� ��� ��������� ����� ���� � ����! �������� ��� ������ � ��� ��������� � ������� ������. �� ��� ������, ��� ��� �������� � ����� ��� ���� ���� ������� �� ��������� ����� ��� ����, �� ���������. �����������? � � ����� �� ��������.",
			"d4"=> "����? ���� �� ���� �� ���� ���������� ��������� � ���� ���� �����, ���������� � ��������. �� ������ ����� ����������, �� ��� ��?",
			"d1" => "���, � �� ����� ��� �������",			
		),
		4 => array(
			"0" => "������� �� ������� ��� �� ����  - �� ��� ��������. �������� �� ������� ��� ���?",
			"q23"=> "�����, ����� ���� ����. ����!",
			"d1" => "�������, ��� ����� - ���. ",			
		),
		"t1" => array(
			"0" => "�������, �� ��� ����� ��������!",
			"11111" => "����.",
		),
	);

	$mlvillage2 = array(
		0 => array(
			"0"  => "����������� ����, ������, � ����� �������� �������. ������ �� �� ������� ������� � ��������� � ��������� ������ ��� ���������� �� ���� � ����� ������ ���������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
			"d1001" => "��, � ����� ������. ������, ��� ���� �������.",
			"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
		),
		1001 => array(
			"0"  => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
			"d1002" => "���������� �����",
			"d1003" => "������",
			"d1004" => "���������� �����",
			"11111"  => "��� �� �������� �� ���� �� ����� ������. ������.",
		),
		1002 => array(
			"0"  => "�������� ������������ ���� ��������� ������ �-�� � ������ ������� �� ���. �����, ��� ��������� � ����� ������ ��������� ���, ����������� ���� ������� ������� � ���� ��������! Ÿ ����������, �������, ���������� �������!",
			"q1026" => "����� ������������ ������ �������� �������������!",
			"d1001" => "������ ������, ��� ��� �����",
		),
		1003 => array(
			"0"  => "�������� ���� �������� � ��������� �����, ��� ���. ���� ������ � ��� ��� � ���� � �� ������������, � ����� ���-������ ������� ����������� �����. ����� ������ �����... ��������, ��� �������. �� ����� ������, ��� ������, ����������� ��� ������. ���� �� �� ����������, ����� �� ����� ���� ����� �������.",
			"q1027" => "������, � ���������� ���������, ��� ��� �� �������.",
			"d1001" => "���, ��� ������� ������, � �� ������.",
		),
		1004 => array(
			"0"  => "��� ���, �� ���� ����� �����, ��� � ������ ������� ���� �������� ���������� ������� �������� �� ��������� �����. �������, ��� ��� ��� ������, � ��� ��� ��� �� ����� ���� ����������� � ������ �����",
			"d1005" => "��� � ���� ������, ������ ����? ������� ��� �����������? �������� ��� ����� ���� �����?",
			"d1001" => "��� ��� ���� ���������.",
		),
		1005 => array(
			"0"  => "��� ��! ��� ��! ������� � �����! ������� ������ �� ����. � ����� �����, ����� ��� ����� ���� �� ����������� ���, ��� ���� ������ ���� � ����� ��������� � ��� �������� ����������� ���� ������� ������.",
			"d1006" => "��������, �� ������ �� ���������, ������ ����, ���� ����� ������� � ������?",
		),
		1006 => array(
			"0"  => "������ ��? �������� ���� ��� �������� ����� � �������� ��� ������� ����� ������ ������, ���� �� �������� ��� ������� � ������ � ����� �������. ����� � ������� � ���������. �� ����������, �������, ��������� ������� �������. ���� �� ����, ��� ����� ������, �� ����� �� ������� ��������� �����?",
			"q1028" => "������ �� �� ������� ����� ������� � �������! ����! ",
			"d1001" => "���, �� ����� ��� ��� ������� �� ���.",
		),
		"t1026" => array(
			"0" => "�������, �� ��� ����� ��������!",
			"11111" => "����.",
		),
	);

	$q31stepcomplete = false;
	if ($q31 !== FALSE) {
		if ($q31['val'] == 10 && QItemExists($user,3003092)) {
			$mlvillage2[0]["d1007"] = "� ������ � ���� �� �������, ������ ����. �� ����� �� �� � ������������ ��������� ���������� ���-������ � ������� ��������, ������� ���� ���������, ���� ������� ������� ����� ������� ������� ������?";
			$mlvillage2[1007] = array(
				0 => "�� ��� �� ���  �����, ��� ���� ����� ��������?  ����� ��� ����. �� ������ ��������� ������, �������� ��� �������, � ��� ��� ������ ������� ������.  ������� �� ��� ����� 15 �������� ������, ������� �� �������� ����� ������ ������, ����� 100 ��� ������ ���� �����������  ��������, ����������� ������ � ���������, ������ ������ ����� ���� �����, � ������� ���� ������, ������ ������ � ��������� ����, ������� � 600 ����������� ������, ���������� � 30 ���� ������ ������� ����� � ����������� ����� ������ ������������ ������������� ��������� ������ ����������������. ���, ��� ������ ������ ������� ������.",
				"d1008" => "������-��... �� ����� �� ����� � ��� ������. �������� ������ �������� 600 ����������� ����, ������� ���� � 30 ������ ������ ������� ����� � ����������� � ����������.  ��� ��� �� �����! � ��� ��� ���� ��� ���������, ������ ����?",
			);
			$mlvillage2[1008] = array(
				0 => "�� ����� �����. � �� � ������� ����� ������� ���� �����?  ����� �������� ���. ���, ���� � ����������� ������ � �������� � ������ ������ ������� �����. � � ���� ����� ��� ���������� � � ������ ����������� ����� �����, ��� ���� ������� � ����������.",
				"q1031" => "�������, ������ ����! ��� � ��������! ��� ���� ����� � ��������.",
			);
		}
		if ($q31['val'] == 11) {
			$mlvillage2[0] = array(
				"0"  => "����������� ����, ������, � ����� �������� �������. ������ �� �� ������� ������� � ��������� � ��������� ������ ��� ���������� �� ���� � ����� ������ ���������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���? ��� ����� ������� 600 ����������� ���� � ���� ���� � 30 ������ ������ ������� �����?",
				"d1001" => "��, � ����� ������. ������, ��� ���� �������.",
				"d1008" => "��, � ������� ������ � 600 ����������� ���� � ���� ���� � 30 ������ ������ ������� �����!",
				"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
			);
			// ��������� ������� 600 ����������� ���� � 30 ������ ��
			$q = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31a" AND val >= 30');
			$q2 = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31v" AND val >= 600');
			if (mysql_num_rows($q) > 0 && mysql_num_rows($q2) > 0) {
				$q31stepcomplete = true;
			}
			if (!$q31stepcomplete) unset($mlvillage2[0]["d1008"]);

			$mlvillage2[1008] = array(
				0 => "�� �� ��������� �����! ��� ������� � �� ������� ������� ���� �����. ���, ��� ���� ��������, ��� ����������� ������ 300 ����� ����� ��������� ����, ��� ����� ���� ����� ����������� ���-�� ������ � �� ����� ������. ����� ������ � ����������� �� ��������. ����� �� ������ ������ ��������?",
				"q1032" => "������� ����! ��� �� �������� ������! �� ����������� ����� ��� ���� ��������� ����� � ������ �� ������ ������! ���� ��� � ���� ��������� � ��������� �������.",
			);
		}
	}




	$mlvillage3 = array(
		0 => array(
			"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
			"d2001" => "��, � ����� ������. ������, ��� ���� �������.",
			"2001"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
		),
		2001 => array(
			"0"  => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
			"d2002" => "�������� ������",
			"11111"  => "��� �� �������� �� ���� �� ����� ������. ������.",
		),
		2002 => array(
			"0"  => "���� � ���� �����, ������� ���������� ��� �� ���������� ��������� �������, ������� ����������� � ����� ����� �� ���� � ���� �� ���������� ��������.  ��� ���� ������ �� ������ �� ������ ������������, �� � � ������ �����. ������� ��������� ������ ���������� ������� ���� � � ���� ���� ��� ��� �� ��� ������������. ����� �� �� ��� ������ � ����?",
			"q2018" => "��, � ����� ���� ������",
			"d2001" => "���, ��� ������� ������ ��� ����",
		),
		"2999thx" => array(
			"0" => "�������, �� ��� ����� ��������!",
			"11111" => "����.",
		),
	);


	if (isset($_GET['qaction']) && strlen($_GET['qaction']) && $questexist === FALSE || isset($_GET['quest']) && $questexist === FALSE) {
		if (isset($_GET['qaction'])) {
			$qa = $_GET['qaction'];
			if (!is_numeric($qa[0])) {
				$num = intval(substr($qa,1));
			} else {
				$num = intval($qa);
			}

			if ($num < 1000) {
				$_GET['quest'] = 1;
			} elseif ($num > 1000 && $num < 2000) {
				$_GET['quest'] = 2;
			} elseif ($num > 2000 && $num < 3000) {
				$_GET['quest'] = 3;
			}
		}

		if ($_GET['quest'] == 1) {
			if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";
	
			$qa = $_GET['qaction'];
			$num = -1;
			if (!is_numeric($qa[0])) {
				$num = intval(substr($qa,1));
			}
			if ($qa[0] == "d" && isset($mlvillage1[$num])) {
				$mldiag = $mlvillage1[$num];

				// ��� ������ ����� �����������
				if (isset($qcomplete[2]) && isset($mldiag["d2"])) unset($mldiag['d2']);
				if (isset($qcomplete[23]) && isset($mldiag["d3"])) unset($mldiag['d3']);
			} elseif ($qa[0] == "q") {
				if ($num == 2 && !isset($qcomplete[2])) {
					// ����� - �������� �����
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,2,"0/0/0") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlvillage1["t1"];
				}                 			

				if ($num == 23 && !isset($qcomplete[23])) {
					// ����� - ���� ��� �����������
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,23) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				}                 			
			} else {
				UnsetQA();
			}
		}

		if ($_GET['quest'] == 2) {
			if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";
	
			$qa = $_GET['qaction'];
			$num = -1;
			if (!is_numeric($qa[0])) {
				$num = intval(substr($qa,1));
			}
			if ($qa[0] == "d" && isset($mlvillage2[$num])) {
				$mldiag = $mlvillage2[$num];

				// ��� ������ ����� �����������
				if (isset($qcomplete[26]) && isset($mldiag["d1002"])) unset($mldiag['d1002']);
				if (isset($qcomplete[27]) && isset($mldiag["d1003"])) unset($mldiag['d1003']);
				if (isset($qcomplete[28]) && isset($mldiag["d1004"])) unset($mldiag['d1004']);
			} elseif ($qa[0] == "q") {
				if ($num == 1026 && !isset($qcomplete[26])) {
					// ����� - ����� ���������
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,26) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlvillage2["t1026"];
				}                 			
				if ($num == 1027 && !isset($qcomplete[27])) {
					// ����� - ������
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,27) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlvillage2["t1026"];
				}                 			
				if ($num == 1028 && !isset($qcomplete[28])) {
					// ����� - ���������� �����
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,28,"0/0/0") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlvillage2["t1026"];
				}                 			
				if ($num == 1031 && $q31 !== false && $q31['val'] == 10) {
					mysql_query('UPDATE oldbk.map_var SET val = 11 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
					unsetQA();
				}
				if ($num == 1032 && $q31 !== false && $q31['val'] == 11 && $q31stepcomplete == true) {
					mysql_query('UPDATE oldbk.map_var SET val = 12 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
					unsetQA();
				}
			} else {
				UnsetQA();
			}
		}


		if ($_GET['quest'] == 3) {
			if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";
	
			$qa = $_GET['qaction'];
			$num = -1;
			if (!is_numeric($qa[0])) {
				$num = intval(substr($qa,1));
			}
			if ($qa[0] == "d" && isset($mlvillage3[$num])) {
				$mldiag = $mlvillage3[$num];

				// ��� ������ ����� �����������
				if (isset($qcomplete[18]) && isset($mldiag["d2002"])) unset($mldiag['d2002']);
			} elseif ($qa[0] == "q") {
				if ($num == 2018 && !isset($qcomplete[18])) {
					// ����� - �������� ������
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,18,"0") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlvillage3["2999thx"];
				}                 			
			} else {
				UnsetQA();
			}
		}
	}

	// 11 �����, ����� ������
	if ($questexist !== FALSE && !isset($_GET['quest']) && !isset($_GET['qaction']) && $questexist['q_id'] == 11 && ($questexist['step'] == 1 || $questexist['step'] == 2 || $questexist['step'] == 3)) {
		$_GET['quest'] = 1;
		$_GET['qaction'] = 1;
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
		<div>
            <input class="button-mid btn" type="button" style="cursor: pointer;" name="��������" value="��������" OnClick="location.href='?'+Math.random();">
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlvillage.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table width=1><tr><td>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlvillage_bg.jpg" id="mainbg">
<a href="?quest=1"><img style="z-index:3; position: absolute; left: 55px; top: 180px;" src="http://i.oldbk.com/i/map/mlvillage_pers1.png" alt="����������" title="����������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlvillage_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlvillage_pers1.png'"/></a>
<a href="?quest=2"><img style="z-index:3; position: absolute; left: 250px; top: 185px;" src="http://i.oldbk.com/i/map/mlvillage_pers2.png" alt="���������" title="���������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlvillage_pers2_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlvillage_pers2.png'"/></a>
<a href="?quest=3"><img style="z-index:3; position: absolute; left: 420px; top: 180px;" src="http://i.oldbk.com/i/map/mlvillage_pers3.png" alt="������" title="������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlvillage_pers3_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlvillage_pers3.png'"/></a>
<?php
if (isset($_GET['quest']) || isset($_GET['qaction'])) {
	if ($questexist !== FALSE) {
		// ���� ����� - ���������� ��������� ����������
		// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
		require_once('./mapquests/'.$questexist['q_id'].'.php');
	} else {
		// ���� ������, �������������
	}

	if (isset($_GET['quest']) && $_GET['quest'] == 1 || isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] < 1000) {
		$mlquest = "0/0";
	} elseif (isset($_GET['quest']) && $_GET['quest'] == 2 || isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 1000 && $_GET['qaction'] < 2000) {
		$mlquest = "100/70";
	} elseif (isset($_GET['quest']) && $_GET['quest'] == 3 || isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000) {
		$mlquest = "200/70";
	} else die();
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