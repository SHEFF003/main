<?php
$head = <<<HEADHEAD
	<HTML><HEAD>
	<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
	<link rel="stylesheet" href="/i/btn.css" type="text/css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<script type="text/javascript" src="/i/globaljs.js"></script>
	<script>
			var timerID;
			function refreshPeriodic() {
				location.href='ruines_start.php?'+Math.random();
			}
			timerID = setTimeout("refreshPeriodic()",30000);
	</script>
	<style>
    		IMG.aFilter { filter:Glow(Color=d7d7d7,Strength=9,Enabled=0); cursor:hand }
		img { behavior: url(/i/city/ie/iepngfix.htc) }
	</style>
	</HEAD>

	<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 onload="top.setHP(%HP%,%MAXHP%);">

 	<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0" style="z-index:2;">
	<TR valign=top>
	<TD width=3% align=center>&nbsp;</TD>
	<TD width=40%><h3>����� ������� ����� - ������ �� ������</h3></div>%CURHP%<br><font color=red>%STATUS%</font></TD>
	<TD align=right nowrap>
		<div class="btn-control">
			<INPUT class="button-dark-mid btn" TYPE="button" value="�������" style="background-color:#A9AFC0" onclick="window.open('ruines_profile.php', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
			<INPUT class="button-dark-mid btn" TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/ruines_start.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
			<input class="button-mid btn" type=button value='���� ��������' onClick="location.href='ruines_log.php?'+Math.random();"> 
			<input class="button-mid btn" type=button value='��������' onClick="location.href='ruines_start.php?'+Math.random();"> 
			<INPUT class="button-mid btn" TYPE=button value="���������" onClick="location.href='ruines_start.php?exit=1';">
		</div>
	</TD>
	</TD></TR>
	<TR height=100%><td>&nbsp;</td><TD valign=top>
HEADHEAD;

$center= <<<CENTER
	<DIV id="dv2" style="display:">&nbsp;&nbsp;<A href="#" onclick="dv1.style.display=''; dv2.style.display='none'; return false">������� ������</A></DIV>
	<DIV id="dv1" style="display: none">
	<FIELDSET><LEGEND><B>������� ������</B> </LEGEND>
	<form method=POST>
	<!--
	������ ������ 
	<SELECT NAME=levellogin>
		<option value="0-0" %LVL8%>8-8</option>
		<option value="1-0" %LVL9%>9-9</option>
		<option value="1-1">9-10</option>
		<option value="2-0" %LVL10%>10-10</option>
		<option value="2-1" %LVL10% %LVL11%>10-11</option>
	</SELECT><br>
	-->
	<script>
	function ShowHide(id) {
		obj = document.getElementById(id);
		if (obj) {
			if (obj.style.display != "none") {
				obj.style.display = "none";
			} else {
				obj.style.display = "";
			}
		}
	}
	</script>
	<input type=hidden name="levellogin" value="1-0">
	<span id="tpass">
	����������� <INPUT TYPE=text NAME='comment' maxlength=40 size=40><BR>
	������ ������� <INPUT TYPE=text NAME='pass1' maxlength=20 size=20><BR></span>
	��������� ������ �� 12 ������� <INPUT TYPE=checkbox NAME='chaos' OnClick="ShowHide('tpass');"><BR>
	<INPUT TYPE=submit name=open value="������ ������">&nbsp;<BR></form></FIELDSET>
	<BR></DIV>
CENTER;

$bottom = <<<BOTTOM
	</TD>
	<TD valign=top>

	<div id="maindiv" style="position:relative;z-index:1;"><img src="http://i.oldbk.com/i/map/npc_komendant_fon1.jpg" id="mainbg">
	<a href="?quest=1"><img style="z-index:3; position: absolute; left: 80px; top: 50px;" src="http://i.oldbk.com/i/map/npc_komendant.png" alt="���������" title="���������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/npc_komendant_hover.png'" onmouseout="this.src='http://i.oldbk.com/i/map/npc_komendant.png'"/></a>
	</div>

	</TD>
	</TR>
	</table>

	</BODY>
	</HTML>
BOTTOM;

	function Redirect($path) {
		header("Location: ".$path); 
		die();
	} 

	function DrawNicks($str) {
		if (empty($str)) return "";
		$str = unserialize($str);
		$ret = '';
		if (is_array($str)) {
			while(list($k,$v) = each($str)) {
				$ret .= $v.', ';
			}
		}
		if (strlen($ret)) $ret = substr($ret,0,strlen($ret)-2);
		return $ret;
	}

	session_start();

	if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) Redirect("index.php");	

	require_once('connect.php');
	require_once('functions.php');
	require_once('ruines_config.php');

	if ($user['room'] != 999) Redirect("main.php");
	if ($user['battle'] != 0 || $user['battle_fin'] != 0) { Redirect("fbattle.php"); }


	$_SESSION['ruinesactivity'] = array();
	
	if (isset($_GET['exit'])) {
		if ($user['zayavka'] > 0) {
			// ���� ����� � ������ - �� ������� �� �����
			Redirect('ruines_start.php?status=0');
		}
		mysql_query('UPDATE `users` SET `users`.`room` = "50" WHERE `users`.`id` = '.$_SESSION['uid']) or die();
		Redirect('city.php');
	}

	// �������� �� ����

	$redflag = FALSE;
	if($user['level'] < 8) {
		$redflag = '���� ������ � 8-�� ������.';
	}

	if($user['hidden']) {
		$redflag = '���������� ��� �� �����...';
	}

	if ($redflag === FALSE) {
		// ��������� �� �� ���� � �����
		$q = mysql_query('SELECT * FROM `ruines_var` WHERE `owner` = '.$user['id'].' AND var = "cango" AND val > '.time()) or die();
		if (mysql_num_rows($q) > 0) {
			// ���� ��
			$kd = mysql_fetch_assoc($q) or die();
			$redflag = '�� ���������� ��������� ����: '.prettyTime(null,$kd['val']);
		}
	}

	$wins = 0;
	$q = mysql_query_cache('SELECT * FROM ruines_var WHERE owner = '.$user['id'].' AND var = "wins"',false,60);
	if (count($q)) {
		$wins = $q[0]['val'];
	}

	if ($redflag === FALSE) {
		// ��������� ���� �� ������
		$q = mysql_query_cache('SELECT * FROM `effects` where owner = '.$user['id'].' AND (`type`= 11 OR `type`= 12 OR `type`= 13 OR `type`= 14 )',false,10);

		if (count($q) > 0) {
			$redflag = '�� �� ������ ����������� � ������� � �������.';
		}
	}

	if($user['align'] == 4) {
		$redflag = '��������� �� ����������� ���� �� ����� �������� �����.';
	}

	if ($redflag !== FALSE) {
		$head = str_replace('%CURHP%',nick_hist($user).' '.setHP($user['hp'],$user['maxhp'],false),$head);
		$head = str_replace('%HP%',$user['hp'],$head);
		$head = str_replace('%MAXHP%',$user['maxhp'],$head);
		$head = str_replace('%STATUS%','',$head);
		$head = str_replace('%WINS%',$wins,$head);
		echo $head;
		echo '<font color=red>'.$redflag.'</font>';

		$BotDialog = new \components\Component\Quests\QuestDialogNew(\components\Helper\BotHelper::BOT_KOMENDANT);
		$mldiag = array();
		$mlquest = "600/100";
		if(isset($_GET['qaction']) && isset($_GET['d'])) {
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
	
		if (isset($_GET['quest']) && empty($mldiag)) {
			$mldiag = array(
				0 => "����������� ���� � ������ ������� �����, ������ ����! � �����-�� ��� ����������� ����� ����� � ���� ���������� ���� ����� ����������� �� ���� �����.",
				//1 => "� ��� ���� ���, ��� ��� �����. �� ��������.",
			);
			foreach ($BotDialog->getMainDialog() as $dialog) {
				$key = '&d='.$dialog['dialog'];
				$mldiag[$key] = $dialog['title'];
			}
	
			$mldiag[1] = "� ��� ���� ���, ��� ��� �����. �� ��������.";
		}
		if(!empty($mldiag)) {
			require_once('mlquest.php');
		}
	
		echo $bottom;
		die();
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['open'],$_POST['levellogin'],$_POST['comment'],$_POST['pass1'])) {
			$_POST['levellogin'] = 0;

			$_POST['num'] = 6; // ������� �� 6 ������
			if (isset($_POST['chaos'])) {
				$_POST['pass1'] = "";
				$_POST['num'] = 12;
				$_POST['comment'] = "";
			}
			if ($_POST['levellogin'] >= 0 && $_POST['levellogin'] <= 2 && $lvl >= 0 && $lvl <= 1) {
				// ������ ������
				if ($user['zayavka'] > 0) {
					// ���� ����� � ������ - �� ��� ������� ��� ����
					Redirect('ruines_start.php?status=1');
				}

				$q  = mysql_query('SELECT * FROM `ruines_profile` WHERE `owner` = '.$user['id'].' AND `def` = 1') or die();
				if (mysql_num_rows($q) != 1) {
					Redirect('ruines_start.php?status=9');
				}

				if (isset($_POST['chaos'])) {
					$q = mysql_query('SELECT * FROM ruines_start WHERE type = 1');
					if (mysql_num_rows($q) > 0) {
						Redirect('ruines_start.php?status=10');
					}
				}	


				if ($user['money'] < $gomoney) {
					// ��� �����
					Redirect('ruines_start.php?status=7');
				}

				$q = mysql_query('START TRANSACTION') or die();

				// �������� ������
				mysql_query('UPDATE `users` set money = money - '.$gomoney.' WHERE id = '.$user['id']) or die();

			        //new_delo
				$rec = array();
	    			$rec['owner']=$user[id]; 
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money']-$gomoney;
				$rec['target']= 0 ;
				$rec['target_login']="�����";
				$rec['type']=200; // �������� �� �����
				$rec['sum_kr']= $gomoney;
				add_to_new_delo($rec); //�����

				// ��������� ������ � �������
				// owner - ���, ��� ������ ������. �� ������������
				// type - ������� �� 6 ������� ��� ���� �� 12
				// ownerlvl - ���������� ���� ������������ �� ������ ��������� ������, �� ��� ������ � �������� �� ������������ ) ������� ��������� ���: 8(������ ���������� � 8��)+������� �� �����������(������ �����)
				// num - ���������� � ������ �� ���� �������
				// lvl - �������� ��� ������ ��� ������� ownerlvl + 1, ���� 0 - �� ������ ��� ownerlvl

				$type = isset($_POST['chaos']) ? 1 : 0;	
		
				$q = mysql_query('
					INSERT INTO `ruines_start`
					(`owner`,`type`,`ownerlvl`,`num`,`lvl`,`t1_logins`,`t1_loginscache`,`t1_pass`,`comment`,`starttime`)
					VALUES (
						'.$user['id'].',
						"'.$type.'", 
						'.(8+$_POST['levellogin']).',
						'.$_POST['num'].',
						"'.$lvl.'",
						"'.$user['id'].';",
						"'.mysql_real_escape_string(serialize(array($user['id'] => nick_hist($user)))).'",
						"'.$_POST['pass1'].'",
						"'.$_POST['comment'].'",
						"'.time().'"
					)
				') or die();
				
				$id = mysql_insert_id();
			
				// ������ ������ � �����
				$q = mysql_query('UPDATE `users` SET zayavka = '.$id.' WHERE id = '.$user['id']) or die();

				$q = mysql_query('COMMIT') or die();
			}
		}

		if (isset($_POST['reject']) && $user['zayavka'] > 0) {
			$q = mysql_query('START TRANSACTION') or die();
			$q = mysql_query('SELECT * FROM `ruines_start` WHERE id = '.$user['zayavka'].' FOR UPDATE') or die();
			if (mysql_num_rows($q) > 0) {
				$data = mysql_fetch_assoc($q) or die();
				// ��������� ������ �� ������. ���� ������ - ��� ������ �������� ������
				$t1 = explode(';',$data['t1_logins']);
				if ((count($t1)-1) == $data['num']) {
					// ������ ������, �������� ������
					$q = mysql_query('COMMIT') or die();
					Redirect('ruines_start.php?status=2');
				}

				// ��� ����� ����� �� ������
				$newt1 = "";
				while(list($k,$v) = each($t1)) {
					if (!empty($v) && $v !== $user['id']) {
						$newt1 .= $v.';';
					}
				}

				// ���������� ������
				mysql_query('UPDATE `users` set money = money + '.$gomoney.' WHERE id = '.$user['id']) or die();

				// ����� � ����
			        //new_delo
				$rec = array();
	    			$rec['owner']=$user[id]; 
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money']+$gomoney;
				$rec['target'] = 0;
				$rec['target_login'] = "�����";
				$rec['type'] = 201; // ������ �� �����
				$rec['sum_kr']= $gomoney;
				add_to_new_delo($rec); //�����

				if (empty($newt1)) {
					// ������ ��������� ������ - �������
					mysql_query('DELETE FROM `ruines_start` WHERE id = '.$data['id']) or die();
				} else {
					// ��������� ������ � �������������� ����������� �����
					$t1cache = unserialize($data['t1_loginscache']);
					unset($t1cache[$user['id']]);
					$t1cache = serialize($t1cache);

					mysql_query('UPDATE `ruines_start` SET 
						starttime = "'.time().'",
						t1_logins = "'.$newt1.'",
						t1_loginscache = "'.mysql_real_escape_string($t1cache).'"
						WHERE id = '.$data['id']
					) or die();
				}
				mysql_query('UPDATE `users` SET zayavka = 0 WHERE id = '.$user['id']) or die();
			}
			$q = mysql_query('COMMIT') or die();
		}

		if (isset($_POST['accept'])) {
			if ($user['zayavka'] > 0) {
				// ���� ����� � ������ - �� �������
				Redirect('ruines_start.php?status=1');
			}

			if ($user['money'] < $gomoney) {
				// ��� �����
				Redirect('ruines_start.php?status=8');
			}

			$q  = mysql_query('SELECT * FROM `ruines_profile` WHERE `owner` = '.$user['id'].' AND `def` = 1') or die();
			if (mysql_num_rows($q) != 1) {
				Redirect('ruines_start.php?status=9');
			}


			$q = mysql_query('START TRANSACTION') or die();
			reset($_POST);
			while(list($k,$v) = each($_POST)) {
				$t = explode('_',$k);
				if (count($t) == 3) {
					if ($t[0] == 'go') {
						$id = intval($t[1]);
						$team = intval($t[2]);
						if ($team != 1) die();
						$q = mysql_query('SELECT * FROM `ruines_start` WHERE id = '.$id.' FOR UPDATE') or die();
						if (mysql_num_rows($q) > 0) {
							$data = mysql_fetch_assoc($q) or die();

							try {
								$_can = \components\Helper\location\BaseLocation::getLocation(
									\components\Helper\location\BaseLocation::LOCATION_RUINE,
									$user
								);

								$_can->can($id);
							} catch (Exception $ex) {
								Redirect('ruines_start.php?status='.$ex->getCode());
							}

							// ��������� ������
							$pass = stripslashes(@$_POST['pass_'.$id.'_'.$team]);
							if ($pass !== $data['t'.$team.'_pass']) {
								$q = mysql_query('COMMIT') or die();
								Redirect('ruines_start.php?status=4');						
							}

							// ��������� ���-�� ������� � �������
							$num = count(explode(';',$data['t'.$team.'_logins']))-1;
							if ($num >= $data['num']) {
								$q = mysql_query('COMMIT') or die();
								Redirect('ruines_start.php?status=5');
							}

							$tcache = unserialize($data['t'.$team.'_loginscache']);
							$tcache[$user['id']] = nick_hist($user);

							// �������� ������
							mysql_query('UPDATE `users` set money = money - '.$gomoney.' WHERE id = '.$user['id']) or die();

						        //new_delo
							$rec = array();
				    			$rec['owner']=$user[id]; 
							$rec['owner_login']=$user[login];
							$rec['owner_balans_do']=$user['money'];
							$rec['owner_balans_posle']=$user['money']-$gomoney;
							$rec['target']= 0 ;
							$rec['target_login']="�����";
							$rec['type']=200; // �������� �� �����
							$rec['sum_kr']= $gomoney;
							add_to_new_delo($rec); //�����
	
							// �� ��, ��������� ����� � �������
							mysql_query('UPDATE `ruines_start` SET 
								starttime = "'.time().'",
								t'.$team.'_logins = "'.($data['t'.$team.'_logins'].$user['id'].';').'",
								t'.$team.'_loginscache = "'.mysql_real_escape_string(serialize($tcache)).'" WHERE id = '.$id
							) or die();						
		
							// ������ ������ � �����
							$q = mysql_query('UPDATE `users` SET zayavka = '.$id.' WHERE id = '.$user['id']) or die();
						}
					}
				}
			}
			$q = mysql_query('COMMIT') or die();
		}

		Redirect('ruines_start.php');
	}

	if (isset($_GET['do']) && $_GET['do'] == "clear" && isset($_GET['zid'])) {
		if (($user['align'] > 1 && $user['align'] < 2) || $user['klan'] == "radminion" || $user['klan'] == "Adminion") {
			$id = intval($_GET['zid']);
			$q = mysql_query('START TRANSACTION') or die();
			$q = mysql_query('SELECT * FROM `ruines_start` WHERE id = '.$id.' FOR UPDATE') or die();
			if (mysql_num_rows($q) > 0) {
				mysql_query('UPDATE `ruines_start` SET comment = "����������� �����" WHERE id = '.$id) or die();
			}
			$q = mysql_query('COMMIT') or die();
			Redirect('ruines_start.php');
		}
	}


	$head = str_replace('%HP%',$user['hp'],$head);
	$head = str_replace('%CURHP%',nick_hist($user).' '.setHP($user['hp'],$user['maxhp'],false),$head);
	$head = str_replace('%MAXHP%',$user['maxhp'],$head);
	$head = str_replace('%WINS%',$wins,$head);

	$status = "";
	if ($user['zayavka'] > 0) {
		$status = '������� ������ �������...';
	}

	if (isset($_GET['status'])) {
		switch($_GET['status']) {
			case 0:
				$status = '�� �� ������ �������� ����� �������� � ������.';
			break;
			case 1:
				$status = '�� ��� ���������� � ������.';
			break;
			case 2:
				$status = '�� ��� �� ������ �������� ������, �������� ������.';
			break;
			case 3:
				$status = '������� �� ���...';
			break;
			case 4:
				$status = '������ �� ���...';
			break;
			case 5:
				$status = '������� �����������.';
			break;
			case 6:
				$status = '�� �� ������ ������� ������ � ������ �������� ������, ��� ������� �� �������������.';
			break;
			case 7:
				$status = '��� ������ ������ ���������� 10 ��.';
			break;
			case 8:
				$status = '��� ������������� � ������ ���������� 10 ��.';
			break;
			case 9:
				$status = '��� �������� ������ ��� ������������� � ������ ��� ����� ������� ������������� �� ���������.';
			break;
			case 10:
				$status = '����������� ������ ��� ����������, �������������� � ��� ��� ��������� � ������ � �������� �����.';
			break;
			case 11:
				$status = '� ������ IP ��� ������ ������ �� �������.';
			break;
			case 12:
				$status = '������ �� �������.';
			break;
		}
	}

	if ($user['zayavka'] > 0) {
		$status .= '<form method="POST"><input name="reject" value="�������� ������" type="submit"></form>';
	}

	$head = str_replace('%STATUS%',$status,$head);

	// ���������� ������:
	$q = mysql_query('SELECT * FROM `ruines_start` WHERE id != 100 ORDER BY type DESC,id DESC') or die();
	$rs = '<form method = "POST"><input type=hidden name="accept" value="1"><table>';
	while($data = mysql_fetch_assoc($q)) {
		$t1nicks = DrawNicks($data['t1_loginscache']);

		$timetokill = "";

		$t = unserialize($data['t1_loginscache']);
		$c = count($t);

		if ($data['id'] != $user['zayavka']) {
			// ���� �� � ���� ������ - �������� ���� ����� �������
			list($k,$nick) = each($t);
			$t1nicks = $nick;
			if ($c > 1) $t1nicks .= ' � ��� '.($c-1).' �������.';
		}

		if ($data['num'] == $c) {
			$timeleft = round((($data['starttime']+(30*60))-time())/60);
			if ($timeleft <= 0) $timeleft = "1";
			$timetokill = ' <i>(������ ��������� ����� '.$timeleft.' ���.)</i>';
		}

		if ($data['type'] == 0) {
			$clear = "";
			if (($user['align'] > 1 && $user['align'] < 2) || $user['klan'] == "radminion" || $user['klan'] == "Adminion") {
				$clear = ' <a href="?zid='.$data['id'].'&do=clear"><img src="i/clear.gif"></a>';
			}
			$rs .= '<tr><td>������ �� '.$data['num'].' ������� <span style="color:gray;"><i>('.htmlspecialchars($data['comment'],ENT_QUOTES).$clear.') </i> '.$timetokill.'</span></td></tr>';
		} else {
			$rs .= '<tr><td>������ �� '.$data['num'].' �������, � ����������� ��������������</td></tr>';
		}
		$rs .= '<tr><td><div class="btn-control">'.( ($user['zayavka'] == 0) ? ((($data['t1_pass'] !== "") ? '������: <input type=text name="pass_'.$data['id'].'_1">' : "").' <input class="button-big btn" type="submit" name="go_'.$data['id'].'_1" value="��������������">') : '').($data['type'] == 1 ? " ������ ".$c." ������� " : " ������: ".$t1nicks).'</div></td></tr>';
		$rs .= '<tr><td>&nbsp;</td></tr>';
	}
	$rs .= '</table></form>';

	echo $head;
	echo str_replace('%LVL'.$user['level'].'%','selected',$center).$rs;

	$BotDialog = new \components\Component\Quests\QuestDialogNew(\components\Helper\BotHelper::BOT_KOMENDANT);
	$mldiag = array();
	$mlquest = "600/100";
	if(isset($_GET['qaction']) && isset($_GET['d'])) {
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

	if (isset($_GET['quest']) && empty($mldiag)) {
		$mldiag = array(
			0 => "����������� ���� � ������ ������� �����, ������ ����! � �����-�� ��� ����������� ����� ����� � ���� ���������� ���� ����� ����������� �� ���� �����.",
			//1 => "� ��� ���� ���, ��� ��� �����. �� ��������.",
		);
		foreach ($BotDialog->getMainDialog() as $dialog) {
			$key = '&d='.$dialog['dialog'];
			$mldiag[$key] = $dialog['title'];
		}

		$mldiag[1] = "� ��� ���� ���, ��� ��� �����. �� ��������.";
	}
	if(!empty($mldiag)) {
		require_once('mlquest.php');
	}
	echo $bottom;	
?>