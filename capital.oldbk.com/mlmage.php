<?php

	$mlglobal = 1;
	require_once('mlglobal.php');

	require_once('castles_config.php');
	require_once('castles_functions.php');

	$questEngine = false;
	if(isset($_GET['qaction']) && isset($_GET['d'])) {
		$questEngine = true;
	}
	$mldiag = array();


		$questexist = false;
		$qcomplete = false;
		$q31 = false;
	if($questEngine === false) {

		$q = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31"') or die();
		if (mysql_num_rows($q) > 0) {
			$q31 = mysql_fetch_assoc($q);
		}
		if ($q31 !== false && $q31['val'] == 13) $q31 = false;


		$qlist = array(9,14,17,25);
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

		$mlmage = array(
			0 => array(
				"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���?",
				"d1" => "��, � ����� ������. ������, ��� ���� �������.",
				"33333" => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				"44444" => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
			),
			1 => array(
				"0"  => "� ���� ���� ��������� ������ � ����, �� ������������ �� ������� ��������� ������ ����. ������, � ��� �� ����� ��� ������ �������?",
				"d2" => "���������� �������",
				"d3" => "���������� ����",
				"d4" => "������� ������",
				"d5" => "����������� �������������",
				"1"  => "��� �� �������� �� ���� �� ����� ������. ������.",
			),
			2 => array(
				"0"  => "�� �� ��� ����� �� ���, ����. ������� ����� � ������ ���� ������� ���������� �������. ��� ����, ����� ��, ��� ����� �������, ������  ������ ������, �������� ����� � ����������� ����� ��� ���������. ����� � ������ ����� �������, � ���� ������ ��������� �������.",
				"q9" => "������, � ������� ���, ��� �� �������",
				"d1" => "���, � �� ����� ����� �������",
			),
			3 => array(
				"0"  => "��� ������ � ������� ������ � ���������� ���������� �����, ������� ���, ��� ��� ���� �����. ���� ��� ������ ������� ����, ������ �����, 15 ������������ � ������������, ������� ��, ����� ����, ����� ����������� ������, ������� ����� � ����� ����. �������� ������ �������, �� ��� ��� �������� ���������� ����� � ������������ ���������� �����. �� ������� ������ ������ ������ ����, ������� ����� � �������� �����������. �����-�� �� �������� � ������, �� ��� ������, ����� �� ����. ���� ��������� ��� ���, ���� �� ������� � �����������.",
				"q14" => "������, � ������� ���, ��� �� �������",
				"d1" => "���, � �� ����� ����� �������",
			),
			4 => array(
				"0"  => "�� �������� �������. ������� ���������� ���� ��� ���������� ���������� ����������� ������. ������ � ���� ���� ��� ������ ������ ���� ���� � �������, ���� � ������� ����. ���� ��������� ��� ������ ������ ������, � ����� ��������� �����. �� �� ������ ��������� � �������� ������ �� ��������� ������ ��������� � � ��������� �� ������� ��������� �����. ���� ��������� ���, ��� ��� ����� � �����������.",
				"q17" => "������, � ������� ���, ��� �� �������.",
				"d1" => "���, � �� ����� ����� �������",
			),
			5 => array(
				"0"  => "������ � ��. �� �� ��������� ������ ��� �� �� ������������� ���� ���� ��������! � ��� ���������� ����, ���� ����, ����� � ��� ��� ������� ���. ������ ��� ���������� ����������� � ������ �� ����������, �� ����, ��� ��� ������ ���� ���������� � ����. ���� ��� ���������� ������ �� ������� ���� � ��� ���� � ���� �� ����������, ���, � ���� ����� �������� �� �������.",
				"d6" => "������� � ����� �������� ��������� ��� ��������? ���� ��� ��� �� ������.",
			),
			6 => array(
				"0"  => "��� ����������, ������-��. �� ��� ���, ��������� ��� ������� ��� ��� ������� ������� ������ ��� �������� �����?",
				"q25" => "�����, �����. ������� ���� ���������� �����������. �� ������ � ���� ������� �� �����. ����!",
				"d1" => "������-�� ��������� ������������� �� �� ������� (����������)",
			),
			"thx" => array(
				"0" => "�������, �� ��� ����� ��������!",
				"11111" => "����.",
			),
		);

		$todel = false;
		if ($q31 !== FALSE && QItemExists($user,3003092)) {
			if ($q31['val'] == 8) {
				$mlmage[0]["d7"] = "������ ���� �������� ������� �����, ������� �������� �� ���������� ��������� ������. ��� ����� � ��� ������������, �� ����� �� �����������. ����� �� ������, ��� �� �������� �� ���� ��������?";
				$mlmage[7] = array(
					0 => "���... ���������� ������. ��� ����� � ������ ������, �� � ����� �� ������ �� ����. ����� ��������� � ��� ����������. ������� ��� 50 ������� ���� � � ����� ������� �� ��� �������, ������� �������� ����� ���������.",
					"q31" => "������������, � ������� ���� ��� �����.",
				);
			}

			if ($q31['val'] == 9) {
				$mlmage[0] = array(
					"0"  => "����������� ����, ������! ��� ������� ���� ����? ����� ������, �����, ����������� ��� ������ ������? ���� �� �������� �� ������� � ��������� � ����� �����������, �� �������� �� �� ������ ��� ��� � ���? ��� �� ������ ��� ��, ��� � ������?",
					"d7" => "��, ����� 50 ������� ���� ��� ������ ��������.",
					"1"  => "���, � ��� �� ��� �����, ������� �����.",
					"33333" => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					"44444" => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					"1"  => "���, � �� �� ���, ��� �������� ���� ������. ������.",
				);
				$todel = QItemExistsCountID($user,667667,50);
				if ($todel == false) unset($mlmage[0]["d7"]);

				$mlmage[7] = array(
					0 => "������ �� �� ���������. �� ��� �... ������� �����, �� ���� � ��� ���� �����������. ����� ���������� ���, ��� ������ ���� ������� ������� ������ ����� ��� �������. ��� �������, ������� ������ ������ ���, ��� ����� ������� �����, � ����� ����� ������ ���, ��� ������ ������ �������.  �� ����� ����. ����� ��� ��������� �������, ������� ������ ��������� �����, ������, ��� ������� �����. ����� ������� � ����� � ����������, ����� � ���� � ��������� ���������� �������� ����������, � ������� �������� � ��������.",
					"q32" => "������� �� ������! ����!",
				);
			}
		}

		if (isset($_GET['qaction']) && strlen($_GET['qaction']) && $questexist === FALSE || isset($_GET['quest']) && $questexist === FALSE) {
			if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";

			$qa = $_GET['qaction'];
			$num = -1;
			if (!is_numeric($qa[0])) {
				$num = intval(substr($qa,1));
			} else {
				$num = intval($qa);
			}
			if ($qa[0] == "d" && isset($mlmage[$num])) {
				$mldiag = $mlmage[$num];

				// ��� ������ ����� �����������
				if (isset($qcomplete[9]) && isset($mldiag["d2"])) unset($mldiag['d2']);
				if (isset($qcomplete[14]) && isset($mldiag["d3"])) unset($mldiag['d3']);
				if (isset($qcomplete[17]) && isset($mldiag["d4"])) unset($mldiag['d4']);
				if (isset($qcomplete[25]) && isset($mldiag["d5"])) unset($mldiag['d5']);
			} elseif ($qa[0] == "q") {
				if ($num == 9 && !isset($qcomplete[9]))  {
					// ����� - . ���������� �������
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,9,"0/0/0/0") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlmage["thx"];
				} elseif ($num == 14 && !isset($qcomplete[14])) {
					// ����� - . ���������� ����
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,14,"0/0/0") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlmage["thx"];
				} elseif ($num == 17 && !isset($qcomplete[17])) {
					// ����� - . ������� ������
					mysql_query('START TRANSACTION') or QuestDie();
					SetNewQuest($user,17,"0") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					$mldiag = $mlmage["thx"];
				} elseif ($num == 25 && !isset($qcomplete[25])) {
					// ����� - ����������� �������������
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003087,"���") or QuestDie();
					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>�����������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']);
					SetNewQuest($user,25,"0/0/0/0/0") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($num == 31 && $q31 !== false && $q31['val'] == 8) {
					mysql_query('UPDATE oldbk.map_var SET val = 9 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
					UnsetQA();
				} elseif ($num == 32 && $q31 !== false && $q31['val'] == 9 && $todel !== FALSE) {
					mysql_query('START TRANSACTION') or QuestDie();
					mysql_query('UPDATE oldbk.map_var SET val = 10 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
					PutQItemTo($user,"���",$todel);
					PutQItem($user,3003093,"���") or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					UnsetQA();
				}
			} elseif ($num >= 33333) {
				// do nothing
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
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlmage.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table width=1><tr><td>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlmage_bg.jpg" id="mainbg">
<a href="?quest"><img style="z-index:3; position: absolute; left: 225px; top: 80px;" src="http://i.oldbk.com/i/map/mlmage_pers1.png" alt="���" title="���" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlmage_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlmage_pers1.png'"/></a>
<?php
$q_goodbuyer = array(10,12,14,15,16,17,22,23,25,6,8,9,29,30);

$BotDialog = new \components\Component\Quests\QuestDialogNew(\components\Helper\BotHelper::BOT_MAG);

if (isset($_GET['qaction']) && ($_GET['qaction'] >= 44444 && $_GET['qaction'] <= 44450) && $questEngine === false) {
	if ($_GET['qaction'] == 44444) {
		$mldiag = array(
			0 => "������� �������� ����, ������� ��������� �����, - �������� ������� � �����, � ��� ����� � �����... ���� �����, ������ ����. �� ����, ���� ���� ���� ������������ ��������� ���������� ������, �� ���� ��� ������ ��������� �� ������ �� 10 ������ � ������ ����� ����������, ��� ��� ��� ������ ����� ����� ��� ������ ����������� �����.",
			//44445 => " ��� ���� ��������� ���������� ������ � ��� ���� 20 ������. ���� ������ ������� �������. ������� ��� ����� ������?",
			44446 => "��� ���� ������������ ��������� ���������� ������, �� ��� ���� 10 ������. ������� ����� ������ ������� �� ��������?",
			//44447 => "��� ���� ��������� ���������� ������ � ��� ���� 20 ������. ����� ������ ���� �����?",
			11111 => "�, �������, ����� �������.",
		);
	}
	/*
	if ($_GET['qaction'] == 44445) {
		$q = mysql_query('select * from oldbk.inventory where owner = '.$user['id'].' and type=30 and dressed=0 and up_level<20 and ups>=add_time ORDER BY `update` DESC ') or die();
		if (mysql_num_rows($q) >0) {
			$bt = "";
			if ((int)($_GET['r'])>0) {
				$rid=(int)($_GET['r']);
				$answ=mk_runs_lvl_up($rid);
				$bt .= "<font color=red>".$answ[msg]."</font><br><br>";
				$q = mysql_query('select * from oldbk.inventory where owner = '.$user['id'].' and type=30 and dressed=0 and up_level<20 and ups>=add_time ORDER BY `update` DESC ') or die();
			}


			$bt .= '<font color=red>���� ������� � �������� ������:</font>';	
			$mldiag[0] = $bt;
			$bt = "";

			while($row = mysql_fetch_assoc($q)) {
				ob_start();
				$bt .= '<!-- NOLINK --><TABLE>';
				showitem ($row,0, false,'','<a href=?qaction=44445&r='.$row[id].'><small><b>(������� ������� �� '.($row[up_level]+1).' �����)</b></small></a>', 0, 0);
				$bt .= ob_get_contents();
				ob_end_clean();
				$bt .= '</TABLE>';
				$mldiag[] = $bt;
				$bt = "";
			}
			$mldiag[11111] = "�, �������, ����� �������.";
		} else {
			$mldiag = array(
				0 => "� ������� �� ������� ���, ������� � �������� ������.",
				11111 => "�, �������, ����� �������.",
			);
		}
	}
	else
	*/
	if ($_GET['qaction'] == 44446) {
		$q = mysql_query('select * from oldbk.inventory where owner = '.$user['id'].' and type=30 and dressed=0 and up_level<10 ORDER BY `update` DESC ') or die();
		if (mysql_num_rows($q) >0) {
			$bt = "";
			if ((int)($_GET['r'])>0) {
				$rid=(int)($_GET['r']);
				$answ=mk_runs_full_lvl_up($rid);
				$bt.="<font color=red>".$answ[msg]."</font><br><br>";
				$q = mysql_query('select * from oldbk.inventory where owner = '.$user['id'].' and type=30 and dressed=0 and up_level<10 ORDER BY `update` DESC ') or die();
			}

			$bt .= '���� ���� 10 ������ ��������� � ������� ��������:';	
			$mldiag[0] = $bt;
			$bt = "";

			while($row = mysql_fetch_assoc($q)) {
				ob_start();
				$bt .= '<!-- NOLINK --><TABLE>';
				showitem ($row,0, false,'','<a href=?qaction=44446&r='.$row[id].'><small><b>(�������� ������� �� '.$runs_lvl_cost[$row[up_level]+1].' ���.)</b></small></a>', 0, 0);
				$bt .= ob_get_contents();
				ob_end_clean();
				$bt .= '</TABLE>';
				$mldiag[] = $bt;
				$bt = "";
			}
			$mldiag[11111] = "�, �������, ����� �������.";
		} else {
			$mldiag = array(
				0 => "� ������� �� ������� ��� ���� 10 ������ ��������� � ������� ��������.",
				11111 => "�, �������, ����� �������.",
			);
		}
	}
	/*
	else
		if ($_GET['qaction'] == 44447) 
		{
		//�������������� ������
			$mldiag = array(
			0 => "��� ��� ������ �������� ������ ������ ���� ��� ������������. ��� ����� \"���������� ������ ��������\", ������� ��������� � ������ � �������� ������ �� �������� �������. �������� ��� ����� ������ ���� �����:<br>
			<small><b>
			���� 20 ������ ������� �� 21 - ���������� ������ �������� I<br>
			���� 21 ������ ������� �� 22 - ���������� ������ �������� II<br>
			���� 22 ������ ������� �� 23 - ���������� ������ �������� III<br>
			���� 23 ������ ������� �� 24 - ���������� ������ �������� IV<br>
			���� 24 ������ ������� �� 25 - ���������� ������ �������� V<br>
			���� 25 ������ ������� �� 26 - ���������� ������ �������� VI<br>
			���� 26 ������ ������� �� 27 - ���������� ������ �������� VII<br>
			���� 27 ������ ������� �� 28 - ���������� ������ �������� VIII<br>
			���� 28 ������ ������� �� 29 - ���������� ������ �������� IX<br>
			���� 29 ������ ������� �� 30 - ���������� ������ �������� X.</b></small>",
			11111 => " ������, � ������� �� �������.",
			44448 => " � ���� ���� ������ ������.",
		);
		
		
		}
	else
	if ($_GET['qaction'] == 44448) {
	//���� ������ 20��
		$q = mysql_query('select * from oldbk.inventory where owner = '.$user['id'].' and type=30 and dressed=0 and up_level>=20 and ups>=add_time ORDER BY `update` DESC ') or die();
		if (mysql_num_rows($q) >0) {
			$bt = "";
			if ((int)($_GET['r'])>0) {
				$rid=(int)($_GET['r']);
				$answ=mk_runs_lvl_up($rid);
				$bt .= "<font color=red>".$answ[msg]."</font><br><br>";
				$q = mysql_query('select * from oldbk.inventory where owner = '.$user['id'].' and type=30 and dressed=0 and up_level>=20 and ups>=add_time ORDER BY `update` DESC ') or die();
			}


			$bt .= '<font color=red>���� ������� � �������� ������:</font>';	
			$mldiag[0] = $bt;
			$bt = "";
 	  		$scnam=array("21"=>"I" , "22"=>"II" , "23"=>"III" , "24"=>"IV" , "25"=>"V" , "26"=>"VI" , "27"=>"VII" , "28"=>"VIII" , "29"=>"IX" , "30"=>"X"  ) ;
			while($row = mysql_fetch_assoc($q)) {
				ob_start();
				$bt .= '<!-- NOLINK --><TABLE>';
	 	  		//��������
				 $addtext=' "���������� ������ �������� '.$scnam[($row[up_level]+1)].'"'; 
				showitem ($row,0, false,'','<a href=?qaction=44448&r='.$row[id].'><small><b>(������� ������� �� '.$addtext.')</b></small></a>', 0, 0);
				$bt .= ob_get_contents();
				ob_end_clean();
				$bt .= '</TABLE>';
				$mldiag[] = $bt;
				$bt = "";
			}
			$mldiag[11111] = "�, �������, ����� �������.";
		} else {
			$mldiag = array(
				0 => "� ������� �� ������� ���, ������� � �������� ������.",
				11111 => "�, �������, ����� �������.",
			);
		}
	}
	*/

	//$mlquest = "400/100";

	//if (!ADMIN) unset($mldiag[44444]);

	//require_once('mlquest.php');
}

if (isset($_GET['qaction']) && ($_GET['qaction'] >= 33333 && $_GET['qaction'] <= 33341) && $questEngine === false) {
	// ��� �������� � �����
	if (($_GET['qaction'] >= 33335 && $_GET['qaction'] <= 33341)) {
		$booknum = $_GET['qaction']-33335;

		$pages = array();
	        $q = mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access FROM  oldbk.`inventory` i WHERE i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner!='{$user[id]}' and i.type = 300"); 
		while($b = mysql_fetch_assoc($q)) {
			$color = ceil(($b['prototype'] - 3003100) / 5)-1;
			$pages[$color][$b['prototype']]++;
		}

		$ids = array();

		if (count($pages[$booknum]) == 5) {
			$q = mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access FROM  oldbk.`inventory` i WHERE i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner!='{$user[id]}' and i.type = 300 AND i.prototype >= ".(3003100+(($booknum)*5)+1)." AND i.prototype <= ".(3003100+((($booknum)*5)+5))." GROUP BY i.prototype");
			while($b = mysql_fetch_assoc($q)) {
				$ids[] = $b['id'];
				if (count($ids) == 5) break;
			}
		}

		$emoney = false;
		if (count($ids) == 5) {
			// ��������� ������ 
			/*
			$q = mysql_query('SELECT * FROM inventory WHERE prototype = 3003060 AND owner = '.$user['id'].' LIMIT 6') or die();
			if (mysql_num_rows($q) == 6) {
				while($m = mysql_fetch_assoc($q)) {
					$ids[] = $m['id'];
				}
			} else {
			*/
			if ($user['money'] < 250) {
				$mldiag = array(
					0 => "��������� �� �������, ����������� ����� ����� 250 ��.",
					11111 => "�����, � �������.",
				);
			} else {
				$emoney = true;
			}
		}

		if ($emoney) {
			// ����� �����
			mysql_query('START TRANSACTION') or die();
			mysql_query('DELETE FROM oldbk.inventory WHERE id IN ('.implode(",",$ids).')') or die();

			mysql_query('UPDATE users SET money = money - 250 WHERE id = '.$user['id']) or die();
			                                                             
			$selfclan = mysql_query('SELECT * FROM oldbk.clans WHERE short = "'.$user['klan'].'"') or die();
			$selfclan = mysql_fetch_assoc($selfclan);
			if ($selfclan) {
				PutBookToArs($user,3003131,$booknum,$selfclan['id']) or die();
			}

			$log_text = '"'.$user[login].'" ������� � ���� 5 ������� �� '.$cbookpagesm[$booknum]["name"].' ���������� �����';
			mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')") or die();
			mysql_query('COMMIT') or die();
			
			$mldiag = array(
				0 => "����� ���� ����� � ����������, � �����.",
				11111 => "�������.",
			);
		}
	}

	if ($_GET['qaction'] == 33333) {
		$pages = array();
	        $q = mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access FROM  oldbk.`inventory` i WHERE i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner!='{$user[id]}' and i.type = 300"); 
		while($b = mysql_fetch_assoc($q)) {
			$color = ceil(($b['prototype'] - 3003100) / 5)-1;
			$pages[$color][$b['prototype']]++;
		}

		$mldiag = array(
			0 => "������ �������, ���� ������� �����. �� ���������� ������ ���� ������ �� ������. ����� 250 ��. � ������ �������� � ���������� ����� ������ �����.",
		);

		while(list($k,$v) = each($pages)) {
			if (count($v) == 5) {
				$mldiag[33335+$k] = "������ ��� ".$cbookpagesm[$k]["name"]." ���������� �����";
			}
		}

		$mldiag[11111] = "���, � ���������. � ����� ����� � ������ ���.";
	}

	//$mlquest = "400/100";

	//if (!ADMIN) unset($mldiag[44444]);

	//require_once('mlquest.php');
} elseif($questEngine === false) {
	if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
		if ($questexist !== FALSE && in_array($questexist['q_id'],$q_goodbuyer) !== FALSE) {
			// ���� ����� - ���������� ��������� ����������
			// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
			require_once('./mapquests/'.$questexist['q_id'].'.php');
		} else {
			// ���� ������, �������������
			if (empty($mldiag)) {
				$mldiag = array(
					0  => "�� ����� ���� ����� ���������.  ����� ������ � �� ������ ����? ������.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				);

				$mldiag[11111] = "������ ����������, ������ �������� ����. ����� ������.";
			}
		}

		if(!isset($_GET['qaction']) || $_GET['qaction'] == 'd0' || $_GET['qaction'] == '') {
			$_temp = isset($mldiag[11111]) ? $mldiag[11111] : null;
			unset($mldiag[11111]);
			foreach ($BotDialog->getMainDialog() as $dialog) {
				$key = '&d='.$dialog['dialog'];
				$mldiag[$key] = $dialog['title'];
			}
			if($_temp) {
				$mldiag[11111] = $_temp;
			}
		}

		//$mlquest = "400/100";

		//if (!ADMIN) unset($mldiag[44444]);

		//if (isset($_GET['quest']) || isset($_GET['qaction'])) require_once('mlquest.php');
	}	
}

if($questEngine === true) {
	//����� � ������ �������
	$dialog_id = isset($_GET['d']) ? (int)$_GET['d'] : null;
	$action_id = isset($_GET['a']) ? (int)$_GET['a'] : null;
	$dialog = $BotDialog->dialog($dialog_id, $action_id);
	if($dialog !== false) {
		$mldiag[0] = $dialog['message'];
		foreach ($dialog['actions'] as $action) {
			$key = '&a='.$action['action'];
			if(isset($action['dialog'])) {
				$key .= '&d='.$action['dialog'];
			}
			$mldiag[$key] = $action['message'];
		}
	}
}

if (isset($_GET['quest']) || isset($_GET['qaction'])) {
	$mlquest = "400/100";
	require_once('mlquest.php');
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