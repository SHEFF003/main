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
	$qlist = array(6,16,20);
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
			if ($q0 && !$q31) $questexist['q_id'] = 0;
		}
	}

	$mlpiligrim = array(
		0 => array(
			"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
			"d1" => "��, � ����� ������. ������, ��� ���� �������.",
			"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
		),
		1 => array(
			"0"  => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
			"d2" => "���������� ������",
			"d3" => "�������� �������",
			"d4" => "�������� �������",
			"1"  => "��� �� �������� �� ���� �� ����� ������. ������.",
		),
		2 => array(
			"0"  => "������ �� �� ��� �����. ��� ������� ����, �����, ������� ���, ��� ���. ��, � � ��� ����, ��� ��� ������, � ��� ����� � ���� �����. �� ��� �� ������ � �� ����� �����-�� ������� � ������� ��������. �� ��������� ������. �����, �� ����������, ��� ��� � ���� �����������?",
			"q6" => "������, � �������� ��������",
			"d1" => "���, � �� ����� ��� �������",
		),
		3 => array(
			"0"  => "���� ������� ���, ��� ��������� ������������� ����� ��� ������������ ��������. ����� � �������� ������ � ������� ��, ��� ����������� ��������� , ����� ������� �����. � ������ �� ������ ������� ��� �����������, �� � ���� ����� ���, ������ �� ��, � � ���� �����������.",
			"q16" => "������, � ������ ��, ��� �� �������",
			"d1" => "���, � �� ����� ����� �������",
		),
		4 => array(
			"0"  => "������� � ���������� ����������� � ��������� �� �������� ������.  �������? ����� �� ������, ��� ��� ��� ���� �����������? ������ �� �����-�� �������, �� ����� �� � �� ��. ��������, ���������� ��� - ��������� � ����",
			"d5" => "���� � ��������� ����� � �� ������ ��� �� � ����� ���� ����������� ���� �������?",
		),
		5 => array(
			"0"  => "���������� �����! ��, ��� ���� �� ������ �������. � ������ ����� ������� � ��������� ���������.",
			"q20" => "������, � ����������.",
			"d1" => "���, � �� ����� ����� �������",
		),
		"thx" => array(
			"0" => "�������, �� ��� ����� ��������!",
			"11111" => "����.",
		),
	);

	$todel = false;
	if ($q31 !== FALSE) {
		if ($q31['val'] == 4) {
			$mlpiligrim[0]["d6"] = "�� ���� � � ���� �������. �� ������ �� � ����� ����������� ��� ����� �������, ������� ��� � ������ ������� ������� ������? �������� ����� ������ ��������� ������ �� ����������, �� ����� �� ����� ����� ����� � ���� �����, ���� �������, ��� ����� ����� ����� ������.";
			$mlpiligrim[6] = array(
				0 => "�� ��� �� ���, � ������� ���������� ���� ����� ������? ���� ��, �� ���� ����� ����� �����. ������, ��� �� �� ������, ������ ������ ����. ������� � ����� ���� ��������, �� ���, ���� ��������� ������� �� ��������. ������� ��� 15 �������, ���� � �� �� ����� ������ �������. � � ���� ������ � �������.",
				"q31" => "������ ������ ����� ����������, �� � ��������.",
			);
		}
		if ($q31['val'] == 5) {
			$mlpiligrim[0] = array(
				"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���? ��� �� ������ ��� ��, ��� � ������?",
				"d1" => "��, � ����� ������. ������, ��� ���� �������.",
				"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
				"q32" => "��, ��� ���� 15 �������. �������� ��� ������ ��� �����.",
				"1"  => "���, � ��� �� ��� �����, ������� �����.",
			);
			$todel = QItemExistsCountID($user,3002500,15);
			if ($todel == false) unset($mlpiligrim[0]["q32"]);
			$mlpiligrim["next"] = array(
				0 => "�������, ������ ��������� ������� ����� ������ ���� ����������. � ��� ������ ����� �����  4 ��������� ����� � �������, �����������, ��������� � ���������-�������. ���� ������� ������ ����� � ���������� ��� ������ � �����, �� ����� ���������.",
				"11111" => "������� �� ������. �����!",
			);
		}
	}


	if (isset($_GET['qaction']) && strlen($_GET['qaction']) && $questexist === FALSE || isset($_GET['quest']) && $questexist === FALSE) {
		if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";

		$qa = $_GET['qaction'];
		$num = -1;
		if (!is_numeric($qa[0])) {
			$num = intval(substr($qa,1));
		}
		if ($qa[0] == "d" && isset($mlpiligrim[$num])) {
			$mldiag = $mlpiligrim[$num];

			// ��� ������ ����� �����������
			if (isset($qcomplete[6]) && isset($mldiag["d2"])) unset($mldiag['d2']);
			if (isset($qcomplete[16]) && isset($mldiag["d3"])) unset($mldiag['d3']);
			if (isset($qcomplete[20]) && isset($mldiag["d4"])) unset($mldiag['d4']);
		} elseif ($qa[0] == "q") {
			if ($num == 6 && !isset($qcomplete[6])) {
				// ����� - ���������� ������ 
				mysql_query('START TRANSACTION') or QuestDie();				
				SetNewQuest($user,6) or QuestDie();
				PutQItem($user,3003019,"��������",0,$todel) or QuestDie();
                                mysql_query('COMMIT') or QuestDie();
				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>���������� ������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']);

				$mldiag = $mlpiligrim["thx"];
			}
			if ($num == 16 && !isset($qcomplete[16])) {
				// ����� - �������� �������� 
				mysql_query('START TRANSACTION') or QuestDie();				
				SetNewQuest($user,16) or QuestDie();
                                mysql_query('COMMIT') or QuestDie();

				$mldiag = $mlpiligrim["thx"];
			}
			if ($num == 20 && !isset($qcomplete[20])) {
				// ����� - �������� �������
				mysql_query('START TRANSACTION') or QuestDie();				
				PutQItem($user,3003073,"��������") or QuestDie();
				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>�������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']);
				SetNewQuest($user,20) or QuestDie();
                                mysql_query('COMMIT') or QuestDie();

				$mldiag = $mlpiligrim["thx"];
			}
			if ($num == 31 && $q31 !== false && $q31['val'] == 4) {
				mysql_query('UPDATE oldbk.map_var SET val = 5 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
				UnsetQA();
			}
			if ($num == 32 && $q31 !== false && $q31['val'] == 5 && $todel !== false) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItemTo($user,"��������",$todel);
				mysql_query('UPDATE oldbk.map_var SET val = 6 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
                                mysql_query('COMMIT') or QuestDie();
				$mldiag = $mlpiligrim["next"];
			}
		} else {
			UnsetQA();
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
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlpiligrim.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table width=1><tr><td>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlpiligrim_bg.jpg" id="mainbg">
<a href="?quest"><img style="z-index:3; position: absolute; left: 285px; top: 70px;" src="http://i.oldbk.com/i/map/mlpiligrim_pers1.png" alt="��������" title="��������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlpiligrim_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlpiligrim_pers1.png'"/></a>
<?php
if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
	if ($questexist !== FALSE) {
		// ���� ����� - ���������� ��������� ����������
		// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
		require_once('./mapquests/'.$questexist['q_id'].'.php');
	} else {
		// ���� ������, �������������
	}

	$mlquest = "0/0";
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