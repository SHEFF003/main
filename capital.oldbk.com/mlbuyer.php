<?php
	$mlglobal = 1;
	require_once('mlglobal.php');

	$questexist = false;
	$q = mysql_query('SELECT * FROM oldbk.map_quests WHERE owner = '.$user['id']) or die();
	if (mysql_num_rows($q) > 0) {
		$questexist = mysql_fetch_assoc($q) or die();
	}

	$q31 = false;
	$q = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31"') or die();
	if (mysql_num_rows($q) > 0) {
		$q31 = mysql_fetch_assoc($q);
	}
	if ($q31 !== false && $q31['val'] == 13) $q31 = false;

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
            <!--INPUT TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/mlbuyer.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')"-->
            <input class="button-mid btn" type="button" name="�����" value="�����" OnClick="location.href='?exit=1'">
        </div>
	</TD></TR>
	<TR><TD align=center colspan=2>

<table width=1><tr><td>

<div id="maindiv" style="position:relative;"><img src="http://i.oldbk.com/i/map/mlbuyer_bg.jpg" id="mainbg">
<a href="?quest"><img style="z-index:3; position: absolute; left: 120px; top: 90px;" src="http://i.oldbk.com/i/map/mlbuyer_pers1.png" alt="�������" title="�������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/mlbuyer_pers1_h.png'" onmouseout="this.src='http://i.oldbk.com/i/map/mlbuyer_pers1.png'"/></a>
<?php

$q_goodbuyer = array(9,14,18,20,26,28);

$get_test_baff = mysql_fetch_array(mysql_query("select * from effects where owner = '{$_SESSION['uid']}'  and  type=111010  "));
if (($get_test_baff[id] > 0)) {
	$collection_bonus=1+round(($get_test_baff['add_info']/100),2);
} else {
	$collection_bonus=1;
}

if (isset($_GET['qaction']) && $_GET['qaction'] == 33333) {
	/*
	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['how']) && intval($_POST['how']) > 0) {
		$how = intval($_POST['how']);
		mysql_query('START TRANSACTION') or die();

		$q = mysql_query('SELECT * FROM inventory WHERE prototype = 3003060 AND owner = '.$user['id']) or die();
		if (mysql_num_rows($q) < $how) {
			// ������ ������ ��� ����
			$mldiag = array(
				0 => "� ��� ��� ������ ����������.",
				33333 => "����� ��������� ��� ���.",
			);
		} else {
			$ids = "";
			$money = 0;
			for ($i = 0; $i < $how; $i++) {
				$it = mysql_fetch_assoc($q) or die();
				$money += 3;
				mysql_query('DELETE FROM inventory WHERE id = '.$it['id']) or die();
				$ids .= get_item_fid($it).",";
			}

			if ($money > 0) {
				$ids = substr($ids,0,strlen($ids)-1);

				$rec = array();
	    			$rec['owner']=$user[id];
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money']+$money;
				$rec['target']=0;
				$rec['target_login']="�������";
				$rec['type']=259; // ������� ������ �� ���������
				$rec['aitem_id']=$ids;
				$rec['item_name']="������";
				$rec['item_count']=$how;
				$rec['item_type']=50;
				$rec['item_cost']=3;
				$rec['item_dur']=0;
				$rec['item_maxdur']=1;
				$rec['item_proto']=3003060;
				$rec['item_arsenal']='';
				$rec['sum_kr']=$money;

				add_to_new_delo($rec) or die();

				mysql_query('UPDATE users SET money = money + '.$money.' WHERE id = '.$user['id']) or die();

				if ($how == 1) {
					$text = "������";
				} else {
					$text = "�����";
				}

				$mldiag = array(
					0 => "�� ������� ".$how." ".$text."  �� ".$money." ��.",
					11111 => "�����, ��� ��������!",
				);
			}
		}
		mysql_query('COMMIT') or die();
	} else*/ 
	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['howst']) && intval($_POST['howst']) > 0) {
		$how = intval($_POST['howst']);
		mysql_query('START TRANSACTION') or die();

		$q = mysql_query('SELECT * FROM inventory WHERE prototype in (15551,15552,15553,15554,15555,15556,15557,15558) AND owner = '.$user['id']) or die();
		if (mysql_num_rows($q) < $how) {
			// ������ ������ ��� ����
			$mldiag = array(
				0 => "� ��� ��� ������ ����������.",
				33333 => "����� ��������� ��� ���.",
			);
		} else {
			$ids = "";
			$money = 0;
			for ($i = 0; $i < $how; $i++) {
				$it = mysql_fetch_assoc($q) or die();
				$money += (150*$collection_bonus);
				mysql_query('DELETE FROM inventory WHERE id = '.$it['id']) or die();
				$ids .= get_item_fid($it).",";
			}

			if ($money > 0) {
				$ids = substr($ids,0,strlen($ids)-1);

				$rec = array();
	    			$rec['owner']=$user[id];
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money']+$money;
				$rec['target']=0;
				$rec['target_login']="�������";
				$rec['type']=259; // ������� ������ �� ���������
				$rec['aitem_id']=$ids;
				$rec['item_name']="������";
				$rec['item_count']=$how;
				$rec['item_type']=50;
				$rec['item_cost']=(150*$collection_bonus);
				$rec['item_dur']=0;
				$rec['item_maxdur']=1;
				$rec['item_proto']=15550;
				$rec['item_arsenal']='';
				$rec['sum_kr']=$money;

				add_to_new_delo($rec) or die();

				mysql_query('UPDATE users SET money = money + '.$money.' WHERE id = '.$user['id']) or die();

				$text = "������";

				$mldiag = array(
					0 => "�� ������� ".$how." ".$text." �� ".$money." ��.",
					11111 => "�����, ��� ��������!",
				);
			}
		}
		mysql_query('COMMIT') or die();
	/*
	} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['howb']) && intval($_POST['howb']) > 0) {
		// �������� ������
		$how = intval($_POST['howb']);

		mysql_query('START TRANSACTION') or die();

		if ($user['money'] < $how*6) {
			// ������ ������ ��� ����
			$mldiag = array(
				0 => "� ��� ��� ������� ��.",
				33333 => "����� ��������� ��� ���.",
			);
		} else {
			// �������� ������
			mysql_query('UPDATE users SET money = money - '.($how*6).' WHERE id = '.$user['id']);

			// ����� � ����
			$rec = array();
    			$rec['owner']=$user[id];
			$rec['owner_login']=$user[login];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money']-($how*6);
			$rec['target']=0;
			$rec['target_login']="�������";
			$rec['type']=252; // �������� ����� ����
			$rec['item_name']="������";
			$rec['item_count']=$how;
			$rec['item_type']=50;
			$rec['item_cost']=3;
			$rec['item_dur']=0;
			$rec['item_maxdur']=1;
			$rec['item_proto']=3003060;
			$rec['item_arsenal']='';
			$rec['sum_kr']=($how*6);

			add_to_new_delo($rec) or die();


			$user['money'] -= ($how*6);

			// ����� ������
			for ($i = 0; $i < $how; $i++) {
				if (!PutQItem($user,3003060,"�������",0,array(),99)) die();
			}
			
			if ($how == 1) {
				$text = "������";
			} else {
				$text = "�����";
			}

			$mldiag = array(
				0 => "�� ������ ".$how." ".$text."  �� ".($how*6)." ��.",
				11111 => "�����, ��� ��������!",
			);

		}
		mysql_query('COMMIT') or die();
	*/
	} else {
//		$q = mysql_query('SELECT * FROM inventory WHERE prototype  = 3003060 AND owner = '.$user['id']) or die();
		$q2 =mysql_query('SELECT * FROM inventory WHERE prototype in (15551,15552,15553,15554,15555,15556,15557,15558) and owner = '.$user['id']) or die();

		$mldiag = array(
			0 => "� ��� ".mysql_num_rows($q2)." ������. ������ ����� ������� �� ".(150*$collection_bonus)." ��",
			//1 => '<!-- NOLINK -->������� �����: <form method=post><input type="text" name="how"> ���� <input type=submit value="�������"></form>',
			//2 => '<!-- NOLINK -->������: <form method=post><input type="text" name="howb"> ���� <input type=submit value="������"></form>',
			3 => '<!-- NOLINK -->������� ������: <form method=post><input type="text" name="howst"> ���� <input type=submit value="�������"></form>',
			11111 => "�����, ��� ��������!",
		);
	}


	$mlquest = "300/100";
	require_once('mlquest.php');		
} else {
	if (isset($_GET['quest']) || isset($mldiag) || isset($_GET['qaction'])) {
		if ($questexist !== FALSE && in_array($questexist['q_id'],$q_goodbuyer) !== FALSE) {
			// ���� ����� - ���������� ��������� ����������
			// � $midiag ����� ��������� �����������, ���� �� ����� - ������ ���� �� ��������� � ������ � ����� "������" ������ ������ ���� �� miquest.php
			require_once('./mapquests/'.$questexist['q_id'].'.php');
		} else {
			// ���� ������, �������������
			if ($q31 === false) {
				$mldiag = array(
					0 => "�������, �������. ����� � ����� ���������?",
					33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
					11111 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			} else {
				$mlbuyer = false;
			        if ($q31['val'] == 0 && QItemExists($user,3003092)) {
					$mlbuyer = array(
						0 => array(
							0 => "�������, �������. ����� � ����� ���������?",
							"d1" => "� ���� � ���� ������ ����������. ������, ��� ������� ����� ��������� ������, ������� �������� ��� �� ����, � ���� �� �������, � ��� ����� ����� ��� ������ ������� ������. �����, ������ ��, ��� ��� �������?",
							33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
							11111 => "������ ����������, ������ �������� ����. ����� ������.",
						),
						1 => array(
							0 => "�� �� ������ � ����� ��������. � ���� ������� ���, ��������, 100 ������ �����, � ������� ������� ���� �� �������. �� ��� ���� ����� ���� ���� ������, � ������ ���� ����� ������. ������ �, ��� � ������ ������� ����� ������� ������ ������. ���� ��������� ��� 10 ����� �������, ��� �� � ����, ������ ����. ������ ���� ����� � ����, � ��������, ��� � ��� ����� �������.",
							"q0" => "������. ����� �����, � ����� ������� � ���� �� ��������.",
							"d2" => "�� ���� � � ��� �����, � ����, � �� ��������. ����� ��� ������ ���� ��������� �����?",
						),
						2 => array(
							0 => "��... ����� � ������. ������� ��� 3 ������ � �� �����.",
							"q1" => "������. ����� �����, � ����� ������� � ���� � ����.",
							"q0" => "���, ������� � ����� ����� ������. ������� �����, ���� � ����� ���� ������.",
							11111 => "���, ���� ����� ������ �� ����������. ����.",
						),
					);
				}

				$todel = false;
				if ($q31['val'] == 1 || $q31['val'] == 2) {
					$mlbuyer = array(
						0 => array(
							0 => "�� ������ ��� ��, ��� � ������?",
							"q3" => "��, ��� ���� 10 ������� ������.",
							"q4" => "��, ��� ���� 3 ������.",
							33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
							"11111" => "���, � ��� �� ��� �����, ������� �����.",
						),
						"next" => array(
							0 => "��������� � � ����� ������. ��� �� ��� ������, ��� ��������. ��� ���� ����� ��������� ����� � ��������� ������. ��� ���, �� �� ������, �� ����� ����������. ������ �, ��� � ��� � ������ ����� ������ ���� �� ������������. ������� ��� 20 �����, � � ������ ���� ���� �����.",
							"11111" => "�����, ����� � ��� ���� ��� ����. ������ �� �� ���������� �����-�� �������.",
						),
						"next2" => array(
							0 => "��� �������, � ��� ������ ����������� � ���� �������.",
							"11111" => "�������. ����.",
						),
					);
					if ($q31['val'] == 1) {
						$todel = QItemExistsCountID($user,777771,10);
						$mlbuyer[0]["q555"] = "���,  � ���������, ���� ������ �� ���������� �� ������, �� ������� �� ������������. � ����� �������, ��� ������� ���� �� ������, � 3 ������.";
						unset($mlbuyer[0]["q4"]);
						if ($todel === false) unset($mlbuyer[0]["q3"]);
					}
					if ($q31['val'] == 2) {
						$todel = QItemExistsCountIDP($user,array(15551,15552,15553,15554,15555,15556,15557,15558),3);

						$mlbuyer[0]["q555"] = "���, � ���������, ���� ������ �� ���������� �� ������, �� ������� �� ������������. � ����� �������, ��� ������� ���� �� ������, � 10 ������� ������.";
						unset($mlbuyer[0]["q3"]);
						if ($todel === false) unset($mlbuyer[0]["q4"]);
					}
				}

				if ($q31['val'] == 3) {
					$mlbuyer = array(
						0 => array(
							0 => "�� ������ ��� ��, ��� � ������?",
							"q5" => "��, ��� ���� 20 ����� �� ������������. ������ ���� ������.",
							33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
							"11111" => "���, � ��� �� ��� �����, ������� �����.",
						),
						"next" => array(
							0 => "�� �� ���� ������ �����������, � � ����� ���� ������� ����. ������ � ����� ���������. ���� ��� ������� ����� �� ���� ����, � ������. ������ ���� ��� 4 ����� � ��� ����������� � ����� ���������. ���� ���� ��������, �� ���� � ����� ������ ����� ��� �����. �����-�� �� � ���������, �� ����� �� ����� ������ � ����� ���-�� ������. � �����  �����������, �, ���� �������, �� ������� ���� ���������.",
							"11111" => "������, ����� � ���������. �� �� ������ �� ������ � ��� �����. �� ��� ��� ��������.",
						),
					);

					$todel = QItemExistsCountIDP($user,array(3101,3102,3103,3201,3202,3203,3204,3205,3206,3207),20);
					if ($todel === false) unset($mlbuyer[0]["q5"]);
				}

				if ($q31['val'] == 4 || $q31['val'] == 5) {
					$mlbuyer = array(
						0 => array(
							0 => "�� ����� ��, ��� � ������?",
							33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
							"11111" => "���, � ��� �� ��� �����, ������� �����.",
						),
					);
				}

				if ($q31['val'] == 6) {
					$mlbuyer = array(
						0 => array(
							0 => "�� ����� ��, ��� � ������?",
							"d1" => "��, �������� ������, ��� ����� 4 ����� � �������, ����������, ��������� � ���������-�������. ���� � ���� �����?",
							33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
							"11111" => "���, � ��� �� ��� �����, ������� �����.",
						),
						1 => array(
							0 => "���, ������ � ���� ����� ���, �� � ����� ���� ��� �� ����� �������. ������ ��� ����, ���� ��������� ������ ����, ��� �������� ������������� ����-�� �� 100 ������ ������� ����. ����� ���� ����, ��� ����� ��� �������� ������.",
							"d2" => "�����, ������, ��� ������� ��� �����?",
						),
						2 => array(
							0 => "����� ����� ����� ���������� � ����������� ��������� �����. �������, ��� ���� ������������ ��, ���� ���� �������� ���� ��������� �� ���������. � �������, ��� � ��������� ������ � ��� ������ ������� ������� ������. ���� ��� �������, �� ����� ������ ����� ��������� ��, ��� ��������� ���� ���. ��� � �������� � ������� ��� �� 100 ���� ������� �� ������.",
							"q6" => "��������� ���������, �� � �����, ���������. �� �������!",
						)
					);
				}

				if ($q31['val'] == 7) {
					$mlbuyer = array(
						0 => array(
							0 => "�� ������ ��� ��, ��� � ������?",
							"q7" => "��, ��� ���� �� 100 ������ ������� ����. ����� ��������� ������� �����.",
							33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
							"11111" => "���, � ��� �� ��� �����, ������� �����.",
						),
						"next" => array(
							0 => "������, ������... ��� ��� ���� �����... � ������ �������� ������ �� ������ �����������... ��� �������... ���! ������, ��� 4 ����� ������������! �� ����� �� �����������. ������ �� ��� ��� ���� �����-�� ��������. �����-�� �� ����� � ����� � ����, ����� ���� �� ������ ���� ������.",
							"q6" => "������� �� ������.",
						)
					);

					$qi1 = QItemExistsCountID($user,3301,100);
					$qi2 = QItemExistsCountID($user,3302,100);
					$qi3 = QItemExistsCountID($user,3303,100);
					$qi4 = QItemExistsCountID($user,3304,100);
	
					if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE && $qi4 !== FALSE) {
						$todel = array_merge($qi1,$qi2,$qi3,$qi4);
					} else {
						unset($mlbuyer[0]["q7"]);
					}
				}

				
				if ($mlbuyer !== FALSE) {
					if (!isset($_GET['qaction'])) $_GET['qaction'] = "d0";
	
					$qa = $_GET['qaction'];
					$num = -1;
					if (!is_numeric($qa[0])) {
						$num = intval(substr($qa,1));
					}
	
					if ($qa[0] == "d" && isset($mlbuyer[$num])) {
						$mldiag = $mlbuyer[$num];
					} elseif ($qa[0] == "q") {
						if ($num == 0 && $q31['val'] == 0) {
							$todel = QItemExistsCountID($user,3003092,1);
							if ($todel !== FALSE) {
								mysql_query('START TRANSACTION') or QuestDie();
								mysql_query('UPDATE oldbk.map_var SET val = 1 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
								PutQItemTo($user,"�������",$todel);
				                                mysql_query('COMMIT') or QuestDie();
							}
							UnsetQA();
						}
						if ($num == 1 && $q31['val'] == 0) {
							$todel = QItemExistsCountID($user,3003092,1);
							if ($todel !== FALSE) {
								mysql_query('START TRANSACTION') or QuestDie();
								mysql_query('UPDATE oldbk.map_var SET val = 2 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
								PutQItemTo($user,"�������",$todel);
				                                mysql_query('COMMIT') or QuestDie();
							}
							UnsetQA();
						}

						if ($num == 555 && ($q31['val'] == 1 || $q31['val'] == 2)) {
							// �������� ������ �� ����
							mysql_query('START TRANSACTION') or QuestDie();
							if ($q31['val'] == 1) {
								mysql_query('UPDATE oldbk.map_var SET val = 2 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
							}
							if ($q31['val'] == 2) {
								mysql_query('UPDATE oldbk.map_var SET val = 1 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
							}
			                                mysql_query('COMMIT') or QuestDie();
							$mldiag = $mlbuyer["next2"];
						}

						if ($num == 3 && $q31['val'] == 1 && $todel !== false) {
							// �������� ������ �� ����
							mysql_query('START TRANSACTION') or QuestDie();
							PutQItemTo($user,"�������",$todel);
							mysql_query('UPDATE oldbk.map_var SET val = 3 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
			                                mysql_query('COMMIT') or QuestDie();
							$mldiag = $mlbuyer["next"];
						}
						if ($num == 4 && $q31['val'] == 2 && $todel !== false) {
							// �������� ������
							mysql_query('START TRANSACTION') or QuestDie();
							mysql_query('UPDATE oldbk.map_var SET val = 3 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
							PutQItemTo($user,"�������",$todel);
			                                mysql_query('COMMIT') or QuestDie();
							$mldiag = $mlbuyer["next"];
						}
						if ($num == 5 && $q31['val'] == 3 && $todel !== false) {
							// �������� ����
							mysql_query('START TRANSACTION') or QuestDie();
							mysql_query('UPDATE oldbk.map_var SET val = 4 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
							PutQItemTo($user,"�������",$todel);
			                                mysql_query('COMMIT') or QuestDie();
							$mldiag = $mlbuyer["next"];
						}
						if ($num == 6 && $q31['val'] == 6) {
							mysql_query('UPDATE oldbk.map_var SET val = 7 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
							UnsetQA();
						}
						if ($num == 7 && $q31['val'] == 7 && $todel !== FALSE) {
							mysql_query('START TRANSACTION') or QuestDie();
							mysql_query('UPDATE oldbk.map_var SET val = 8 WHERE owner = '.$user['id'].' AND var = "q31"') or QuestDie();
							PutQItemTo($user,"�������",$todel);
							addchp ('<font color=red>��������!</font> ������� ������� ��� <b>�����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']);
							PutQItem($user,3003092,"�������") or QuestDie();
			                                mysql_query('COMMIT') or QuestDie();
							$mldiag = $mlbuyer["next"];
						}
					} else {
						UnsetQA();
					}
				} else {
					$mldiag = array(
						0 => "�������, �������. ����� � ����� ���������?",
						33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
						11111 => "������ ����������, ������ �������� ����. ����� ������.",
					);
				}
			}
	
		}
	
		$mlquest = "300/100";
		if (isset($_GET['quest']) || isset($_GET['qaction'])) require_once('mlquest.php');		
	}                                                                                                       
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