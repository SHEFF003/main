<?php
	$mlglobal = 1;
	require_once('mlglobal.php');

	$qe = false;
	$q = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32"') or die();
	if (mysql_num_rows($q) > 0) {
		$qe = mysql_fetch_assoc($q);
	}
	

	if ($qe['val'] >= 8) unsetQA();

	$mlstranger = array(
		0 => array(
			"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? � ����� ���� ���� ���� ����� �����,  � ������ ����� ������ ������������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� ������ �� �� ����, ������ ��� ��� � ���?",
			"d1" => "��, � ����� ������. ������, ��� ���� �������.",
			"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
		),
		1 => array(
			"0" => "������� ���� �� ������� ������, �� ������� �������� ��� �������� �������. ��� �� ������, � ����� � ����� ����� � ��� ����� ��� �������� �� �����. �����-�� � ����� ������ � ��� ������ ������ � �� ���� ��� ������. ���� �������� ���� \"����������� ������\" � �� ���� ��������, ������� �� ���� ����� �����. ������� � ������� ������, �� ����� ������� �������� ���� � ������ �� ���������� ����... � ��� �������, �� ������� �� ��� ���������� �� ��� ����, ��� ������� ������ ������ �����������, ���� ������� ������� ������... �� � ��� ��������� ���� � ����, ��� ������� �� � ������, ������ ��� ����� �� ��������� ����. � � �������� ��� �������� �� ���� ���������...",
			"d2" => "����� ���������� � ������������ �������, ���������... ��� �� ���������?",
		),        
		2 => array(
			"0" => "��������� ������� ���� ������ ����������. ������� ����� ����������� ������� ���������� ��������, ����� ������� � �� ���� �����������. ���� �������� ��������� � ������ ������� ���� ������� � �������� ���� � ����� ����, ��� �� ������ � ���� ���� ������ ������������ �����, � ��� � �� ��������� �����, ��� ��� ��������. ������ � �������� ��������� �� ����� ����� � ������� �����, ������� ������ ��������� ��� �������. � ���� ����� ������, ������� ��� ��� �������������� ����, � ����� ��������� �����. �� ����������� �� �� ��� ������? ����� ���� �� ������ ����������� ���� ���� � � ����� ���� ��� ���� ������? ���� �� ������� ��������� ��� �������, �� �� ������� ����������� ������, � ��� ��������� ����� �����.",
			"d3" => "��� ���������� �����������. ������� � ����� ����������� ���� ����.  ������, ��� ���� �������?",
		),
		3 => array(
			"0" => "���� ���� ����� �������, � ������ ��� �� ������ ������ ��������� �� � �������� ��� ������� ����� ���������. ��� ��������� ������ ��������������� ����, ��� � ����� ����, ������������ �����, � ���� ����� ��������� �����. ������ �������� ����������� ���� ���������, ������ ������� ��� � ������ ���������.",
			"d4" => "� �����, ������ �������!",
		),
		4 => array(
			"0" => "����, ������ ������� - ���� �� ������������� ��� ������ ����� � � ��� �������, ������� 50 �������� ���� � ��������. �� ���� �� ������ ������ � ��������, �� ������� 10 �������� � ������ ������� �����.  � ����� ������� �� ��� �� ��������� ��������.",
			"q1" => "� ������� 50 ���������� �������� ���� (����� �������)",
			"q2" => "� ������� 10 �������� � ������. (����� �������)",
			"33333" => "���, � ���-���� �� ����� �� ��� ���������, ������!",
		),
		"thx" => array(
			"0" => "�������, �� ��� ����� ��������!",
			"11111" => "����.",
		),
	);

	$zg = false;
	if (strpos($user['medals'],'k202;') !== false) {
		$zg = true;
	} else {
		$mlstranger[1] = array(
			0 => "������� �� ������� ��� ������, �� ��� ������� ���� �������� ��������� 	������� � �������� ����. � ����� ���� ����� ����� ����� \"���� �����\". ����� �� ��������� ���� ����, � ���� ��� ������� ���� ������.",
			33333 => "� �� ����� ����� � �������, ��� �� �����, � ������� �� ��������! �� ��� ������ ���� �������, �� � �������, ����� ������� ���� ����. ������!",
		);
	}


	if (isset($_GET['qaction']) && strlen($_GET['qaction']) && $qe === FALSE || isset($_GET['quest']) && $qe === FALSE) {
		if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";

		$qa = $_GET['qaction'];
		$num = -1;
		if (!is_numeric($qa[0])) {
			$num = intval(substr($qa,1));
		}
		if ($qa[0] == "d" && isset($mlstranger[$num])) {
			$mldiag = $mlstranger[$num];
		} elseif ($qa[0] == "q") {
			if ($num == 1 && $zg) {
				// � ������� 50 ���������� ����
				mysql_query('START TRANSACTION') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32","1")') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s1","0")') or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = $mlstranger["thx"];
			}

			if ($num == 2 && $zg) {
				// � ������� 10 �������� � ������
				mysql_query('START TRANSACTION') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32","2")') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s2","0")') or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = $mlstranger["thx"];
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
<body id="body" leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#e2e0e1" onResize="return; ImgFix(this);">
<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0">
<TR>
	<TD align=center></TD>
	<TD align=right>
		<div class="btn-control">
            <input class="button-mid btn" type="button" style="cursor: pointer;" name="��������" value="��������" OnClick="location.href='?'+Math.random();">
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlstranger.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table border = 0 width=1><tr><td valign=top>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlstranger_bg.jpg" id="mainbg">
<?php
if (isset($qe) && $qe !== false && $qe['val'] >= 8) {
} else {
?>
<a href="?quest=1"><img style="z-index:3; position: absolute; left: 470px; top: 125px;" src="http://i.oldbk.com/i/map/mlstranger_pers1.png" alt="�����������" title="�����������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlstranger_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlstranger_pers1.png'"/></a>
<?php 
}
?>
</div>
<?php
if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
	if ($qe !== FALSE) {
		// ���� ����� - ��� ��������� ����������
		require_once('./mapquests/32.php');
	} else {
		// ���� ������, �������������
	}

	$mlquest = "500/100";
	if (isset($_GET['quest']) || isset($_GET['qaction'])) require_once('mlquest.php');		
}	
?>
</td></tr></table>
 
</div>
</TD>
</TR>
</TABLE>

<?php
	require_once('mldown.php');
?>