<?php
	$mlglobal = 1;
	require_once('mlglobal.php');

	$questexist = false;
	$qcomplete = false;
	$qlist = array(15,21);
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

	if (isset($_GET['qaction']) && $_GET['qaction'] == "33333" && $user['money'] >= 1) {
		// ��������������
		if ($user['money'] >= 1) {
			mysql_query('START TRANSACTION') or QuestDie();
			$rec = array();
			$rec['owner']=$user[id];
			$rec['owner_login']=$user[login];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money']-1;
			$rec['target']=0;
			$rec['target_login']="��������";
			$rec['type']=252; // ����� ���������� ����
			$rec['sum_kr']=1;
			add_to_new_delo($rec) or QuestDie();
	
			if ($user['room'] == ($maprel+$maprelall+1)) {
				mysql_query('UPDATE oldbk.users SET money = money - 1, room = '.($maprel+$maprelall+2).' WHERE id = '.$user['id']) or QuestDie();
			} elseif ($user['room'] == ($maprel+$maprelall+2)) {
				mysql_query('UPDATE oldbk.users SET money = money - 1, room = '.($maprel+$maprelall+1).' WHERE id = '.$user['id']) or QuestDie();
			}
			mysql_query('COMMIT') or QuestDie();
		}
		Redirect("mlboat.php");
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
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlboat1.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table width=1><tr><td>

<?php

$q_goodboat = array(3,4,14,15,18,21,30);

if ($user['room'] == ($maprel+$maprelall+1)) {
?>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlboat1_bg.jpg" id="mainbg">
<a href="?quest"><img style="z-index:3; position: absolute; left: 320px; top: 85px;" src="http://i.oldbk.com/i/map/mlboat_pers1.png" alt="��������" title="��������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlboat_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlboat_pers1.png'"/></a>
<?php
if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
	if ($questexist !== FALSE && in_array($questexist['q_id'],$q_goodboat) !== FALSE) {
		// ���� ����� - ���������� ��������� ����������
		// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
		require_once('./mapquests/'.$questexist['q_id'].'.php');
	} else {
		// ���� ������, �������������
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��������� ���������. ������� 1 ������, � �������.",
					33333 => "��������� 1 ������.",
					4 => "����������� � ����.",
				);
			} elseif ($_GET['qaction'] == 11 && $questexist === FALSE) {
				$mldiag = array(
					0 => "���� ��������� �� ���� ������ ��� �� ��������� ���� ��� ������ � ������ ������ ����� ������� ������ �� �����������, �� ������ ��� ���� � ���-�� ������. �������� �, ��� ���� ������ �� ����� �������, �� ���� ����� �� ������. � ���� ���������� �� �������, ��� �� �������. ����� ��� ��������  ������ � ���-�� ������� � ����� �����������. �������� �����������?",
					10 => "� ���������� ������",
					2 => "���, � �� ����� ����� �������",
				);
			} elseif ($_GET['qaction'] == 10 && $questexist === FALSE && !isset($qcomplete[15])) {
				// ����� - ������������� �����
				mysql_query('START TRANSACTION') or QuestDie();
				SetNewQuest($user,15) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = array(
					0 => "�������, �� ��� ����� ��������!",
					11111 => "����",
				);
			} elseif ($_GET['qaction'] == 14 && $questexist === FALSE && !isset($qcomplete[21])) {
				// ����� - ������ ����
				mysql_query('START TRANSACTION') or QuestDie();
				SetNewQuest($user,21,"0/0/0") or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = array(
					0 => "�������, �� ��� ����� ��������!",
					11111 => "����",
				);
			} elseif ($_GET['qaction'] == 13 && $questexist === FALSE) {
				$mldiag = array(
					0 => "������ ������� ��� � ���� ���� � ������� �����, � ������� �� ���������� ���. ��������, ���� ������� �������� ������ � �������?",
					14 => "������, � ��� � ������.",
					2 => "����� � ���� ��� �� ��� �������. ",
				);

			} elseif ($_GET['qaction'] == 12 && $questexist === FALSE) {
				$mldiag = array(
					0 => "��� ����� ����� ��� ����� � ������� ������� ����, ��� ����� ������������� ����� ����, �� ������ ��� ��� ���� �������, ���� ���� ����. ������ ��� ������ ��� ��������, ��� �� � � ������ ��� ������������ �������� � ������ ������ �� ������.",
					13 => "� ��� �� ���� ���������?",
					2 => "����� � ���� ��� �� ��� �������. ",
				);
			} elseif ($_GET['qaction'] == 2 && $questexist === FALSE) {
				$mldiag = array(
					0 => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
					11 => "������ ����",
					12 => "������������� �����",
					11111 => "��� �� �������� �� ���� �� ����� ������. ������.",
				);

				// ��� ����� ������ ���������
				if (isset($qcomplete[15])) unset($mldiag[11]);
				if (isset($qcomplete[21])) unset($mldiag[12]);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������. ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
				1 => "��� �� ������������� �� �� �������. ������� ��� ����� ������?",
				2 => "� ����� ������. ������, ��� ���� �������.",
				3 => "�� ����, � ������ �������� ����. ����� ������.",
			);
			if ($questexist !== FALSE) {
				$mldiag[0] = "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������";
				unset($mldiag[2]);
			}
		}
	}

	$mlquest = "0/0";
	if (isset($_GET['quest']) || isset($_GET['qaction'])) require_once('mlquest.php');		
}	
?>
</div>

<?php
} elseif ($user['room'] == ($maprel+$maprelall+2)) {
?>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlboat2_bg.jpg" id="mainbg">
<a href="?quest"><img style="z-index:3; position: absolute; left: 480px; top: 100px;" src="http://i.oldbk.com/i/map/mlboat_pers1.png" alt="��������" title="��������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlboat_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlboat_pers1.png'"/></a>
<?php
if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
	if ($questexist !== FALSE && in_array($questexist['q_id'],$q_goodboat) !== FALSE) {
		// ���� ����� - ���������� ��������� ����������, ��������� ����������� ������ ���� ���������� ������� ���������
		// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
		require_once('./mapquests/'.$questexist['q_id'].'.php');
	} else {
		// ���� ������, �������������
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��������� ���������. ������� 1 ������, � �������.",
					33333 => "��������� 1 ������.",
					4 => "����������� � ����.",
				);
			} elseif ($_GET['qaction'] == 11 && $questexist === FALSE) {
				$mldiag = array(
					0 => "���� ��������� �� ���� ������ ��� �� ��������� ���� ��� ������ � ������ ������ ����� ������� ������ �� �����������, �� ������ ��� ���� � ���-�� ������. �������� �, ��� ���� ������ �� ����� �������, �� ���� ����� �� ������. � ���� ���������� �� �������, ��� �� �������. ����� ��� ��������  ������ � ���-�� ������� � ����� �����������. �������� �����������?",
					10 => "� ���������� ������",
					2 => "���, � �� ����� ����� �������",
				);
			} elseif ($_GET['qaction'] == 10 && $questexist === FALSE && !isset($qcomplete[15])) {
				// ����� - ������������� �����
				mysql_query('START TRANSACTION') or QuestDie();
				SetNewQuest($user,15) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = array(
					0 => "�������, �� ��� ����� ��������!",
					11111 => "����",
				);
			} elseif ($_GET['qaction'] == 14 && $questexist === FALSE && !isset($qcomplete[21])) {
				// ����� - ������ ����
				mysql_query('START TRANSACTION') or QuestDie();
				SetNewQuest($user,21,"0/0/0") or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				$mldiag = array(
					0 => "�������, �� ��� ����� ��������!",
					11111 => "����",
				);
			} elseif ($_GET['qaction'] == 13 && $questexist === FALSE) {
				$mldiag = array(
					0 => "������ ������� ��� � ���� ���� � ������� �����, � ������� �� ���������� ���. ��������, ���� ������� �������� ������ � �������?",
					14 => "������, � ��� � ������.",
					2 => "����� � ���� ��� �� ��� �������. ",
				);

			} elseif ($_GET['qaction'] == 12 && $questexist === FALSE) {
				$mldiag = array(
					0 => "��� ����� ����� ��� ����� � ������� ������� ����, ��� ����� ������������� ����� ����, �� ������ ��� ��� ���� �������, ���� ���� ����. ������ ��� ������ ��� ��������, ��� �� � � ������ ��� ������������ �������� � ������ ������ �� ������.",
					13 => "� ��� �� ���� ���������?",
					2 => "����� � ���� ��� �� ��� �������. ",
				);
			} elseif ($_GET['qaction'] == 2 && $questexist === FALSE) {
				$mldiag = array(
					0 => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
					11 => "������ ����",
					12 => "������������� �����",
					11111 => "��� �� �������� �� ���� �� ����� ������. ������.",
				);

				// ��� ����� ������ ���������
				if (isset($qcomplete[15])) unset($mldiag[11]);
				if (isset($qcomplete[21])) unset($mldiag[12]);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������. ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
				1 => "��� �� ������������� �� �� �������. ������� ��� ����� ������?",
				2 => "� ����� ������. ������, ��� ���� �������.",
				3 => "�� ����, � ������ �������� ����. ����� ������.",
			);
			if ($questexist !== FALSE) {
				$mldiag[0] = "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������";
				unset($mldiag[2]);
			}
		}
	}

	$mlquest = "0/0";
	if (isset($_GET['quest']) || isset($_GET['qaction'])) require_once('mlquest.php');		
}	
?>
</div>


<?php
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