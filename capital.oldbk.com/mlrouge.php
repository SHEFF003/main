<?php
	$mlglobal = 1;
	require_once('mlglobal.php');

	$questexist = false;
	$qcomplete = false;
	$qlist = array(3,24);
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


	$mlrouge = array(
		0 => array(
			"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
			"d1" => "��, � ����� ������. ������, ��� ���� �������.",
			"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
		),
		1 => array(
			"0"  => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
			"d2" => "����������� ���������",
			"d3" => "���������� � �������",
			"1"  => "��� �� �������� �� ���� �� ����� ������. ������.",
		),
		2 => array(
			"0"  => "���� � ��� ��������.  ��� �� ����������� ���� ���� �� �� ������� ����, � �������� �� � �����. �������, ��� �� ���-�� ��� � ���� ������. ��, �� � ��� ������ , ��� �� �� �������� �� �����? ���� � �� �������� ��������� ����������� ��� �� �� �������, � �� � ���� �� �������� �� �����. � �� � ����� �� ���������.",
			"q3" => "������, � �������� ������������",
			"d1" => "���, � �� ����� ��� �������",
		),
		3 => array(
			"0"  => "��� ����� ���� � ������������ ������, � � ��� � ���������� ��� ������ ������. ��� ���������, � ������� ����������� �� ������ ������. � ��� � ������� � ��� ��� �����, � ���� ���, ����� �� ���-������ ���������� � ��������� ��� ���� ���� ����������, �� ��������?",
			"d4" => "������, � �������� ����������� ��� ��� ������.",
			"d1" => "���, ����� ��� ��� �����������",
		),
		4 => array(
			"0"  => "������, ������ ��� ��� ���. ��� ��������� � ������ � ��� � �� ������� ������. ���� ��������� �� ����� � ������. �����-�� ������ ����� ������, ���� � ������ ������, ���� ��� ���.  �� ��������� ��� ��� ����-������, ���� �� ��� ���������? �� � ����� �� ���������.",
			"q24" => "�����-�����, ����� �. ��� ������� � �� ���������. ������ ��� �����.",
			"d1" => "���, ����� ��� ��� �����������",
		),

		"thx" => array(
			"0" => "�������, �� ��� ����� ��������!",
			"11111" => "����.",
		),
	);

	if (isset($_GET['qaction']) && strlen($_GET['qaction']) && $questexist === FALSE || isset($_GET['quest']) && $questexist === FALSE) {
		if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";

		$qa = $_GET['qaction'];
		$num = -1;
		if (!is_numeric($qa[0])) {
			$num = intval(substr($qa,1));
		}
		if ($qa[0] == "d" && isset($mlrouge[$num])) {
			$mldiag = $mlrouge[$num];

			// ��� ������ ����� �����������
			if (isset($qcomplete[3]) && isset($mldiag["d2"])) unset($mldiag['d2']);
			if (isset($qcomplete[24]) && isset($mldiag["d3"])) unset($mldiag['d3']);
		} elseif ($qa[0] == "q") {
			if ($num == 3 && !isset($qcomplete[3])) {
				// ����� - ����������� ���������
				mysql_query('START TRANSACTION') or QuestDie();
				SetNewQuest($user,3) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = $mlrouge["thx"];
			}

			if ($num == 24 && !isset($qcomplete[24])) {
				// ����� - ���������� � �������
				mysql_query('START TRANSACTION') or QuestDie();
				SetNewQuest($user,24,"0/0") or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = $mlrouge["thx"];
			}
		} else {
			UnsetQA();
		}
	}


	// 26 �����, ����� ���� ��������
	if ($questexist !== FALSE && !isset($_GET['quest']) && !isset($_GET['qaction']) && $questexist['q_id'] == 26 && $questexist['step'] == 1) {
		$_GET['quest'] = 1;
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
            <input class="button-mid btn" type="button" name="��������" style="cursor: pointer;" value="��������" OnClick="location.href='?'+Math.random();">
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlrouge.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table width=1><tr><td>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlrouge_bg.jpg" id="mainbg">
<a href="?quest"><img style="z-index:3; position: absolute; left: 170px; top: 125px;" src="http://i.oldbk.com/i/map/mlrouge_pers1.png" alt="���������" title="���������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlrouge_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlrouge_pers1.png'"/></a>
<?php
if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
	if ($questexist !== FALSE) {
		// ���� ����� - ���������� ��������� ����������
		// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
		require_once('./mapquests/'.$questexist['q_id'].'.php');
	} else {
		// ���� ������, �������������
	}

	$mlquest = "320/100";
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