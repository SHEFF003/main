<?php
	// ����������� �����
	if (!isset($qe) || $qe === FALSE) return;
	$step = $qe['val'];

	if ($step == 1 || $step == 2) {
		$s1val = 0;
		$s2val = 0;
		if ($step == 1) {
			$s1val = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s1"'));
			$s1val = $s1val['val'];
		}
		if ($step == 2) {
			$s2val = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s2"'));
			$s2val = $s2val['val'];
		}

		$fstep = false;
		if ($step == 1 && $s1val >= 50) $fstep = true;
		if ($step == 2 && $s2val >= 10) $fstep = true;


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, ������� �����, ��� �� ������ - �������� 50 �������� ���� � �������� ��� 10 �������� � ������ ������� �����? �� ����, ��� ����� ����� ���� ������� ���������� ����� �� �������������.",
					2 => "� ������� 50 ���������� �������� ���� (����� �������)",
					3 => "� ������� 10 �������� � ������. (����� �������)",
					11112 => "���, � ��������� ������ �������.",
				);
				if ($step == 1) unset($mldiag[2]);
				if ($step == 2) unset($mldiag[3]);
			} elseif ($_GET['qaction'] == 2 && $step != 1) {
				mysql_query('START TRANSACTION') or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s1"') or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s2"') or QuestDie();
				mysql_query('UPDATE oldbk.map_var SET val = 1 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s1","0")') or QuestDie();
				mysql_query('COMMIT') or QuestDie();					
				unsetQA();
			} elseif ($_GET['qaction'] == 3 && $step != 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s1"') or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s2"') or QuestDie();
				mysql_query('UPDATE oldbk.map_var SET val = 2 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s2","0")') or QuestDie();
				mysql_query('COMMIT') or QuestDie();					
				unsetQA();
			} elseif ($_GET['qaction'] == 4 && $fstep) {
				$mldiag = array(
					0 => "�������! ����� �� �� ������ ��� 50 000 ����� ��������� � ��������������?",
					5 => "��, ������� ���������.",
					11112 => "���, � ���� ������� ��� �� ���������, � ����� �������.",
				);
				if ($user['repmoney'] < 50000) unset($mldiag[5]);
			} elseif ($_GET['qaction'] == 5 && $fstep && $user['repmoney'] >= 50000) {
				$mldiag = array(
					0 => "� ������ �������� �� ������ ���������. ���� ������ �������  - ��������, �� ������ ���� ��������, �� � �����������. ������� ��� 40 ����� �����, ������� � ����� ���� ��������� � ������ ������ ��������. � ����, ��� �� ������� � ����� ������, � ��������� �����, �� ��������� � � ������ ������� ������. ���� ��������� ��� 40 �����, ��� ����� ��������, ��� �� �������� ������ �������� � ������ ������ ��������� ����, �� ������� �� �� ���� ������.",
					6 => "� ������� ���� ����.",
				);			
			} elseif ($_GET['qaction'] == 6 && $fstep && $user['repmoney'] >= 50000) {
				mysql_query('START TRANSACTION') or QuestDie();

				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s1"') or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s2"') or QuestDie();
				mysql_query('UPDATE oldbk.map_var SET val = 3 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();

				$q = mysql_query('UPDATE oldbk.users SET `repmoney` = `repmoney` - 50000 WHERE id = '.$user['id']);
				if ($q === FALSE) return FALSE;

		  		$rec['owner']=$user[id]; 
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money'];
				$rec['owner_rep_do']=$user['repmoney'];
				$rec['owner_rep_posle']=$user['repmoney']-50000;
				$rec['target_login']="������";
				$rec['sum_rep'] = 50000;
				$rec['type'] = 395;
				if (add_to_new_delo($rec) === FALSE) QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� �������� ��, ��� ������?",
				11111 => "���, � ��� �� ��� ������. � ����� �����.",
				1 => "���, � ���� �������� �������, ��� ��������?",
				4 => "��, � �������� ��� ��� ������.",
				11112 => "������ ���� ��������, ��� �����.",
			);
			if (!$fstep) unset($mldiag[4]);
		}	
	}

	if ($step == 3) {
		$fstep = false;

		$q = mysql_query('SELECT * FROM oldbk.inventory WHERE owner = "'.$user['id'].'" AND prototype IN (3101,3102,3103,3201,3202,3203,3204,3205,3206,3207) LIMIT 40');
		if (mysql_num_rows($q) == 40) $fstep = true;
		$todel = array();
		while($i = mysql_fetch_assoc($q)) {
			$todel[] = $i['id'];
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1  && $fstep) {
				$mldiag = array(
					0 => "�������! ����� �� �� ������ ��� 50 000 ����� ��������� � ��������������?",
					2 => "��, ������� ���������.",
					11112 => "���, � ���� ������� ��� �� ���������, � ����� �������.",
				);
				if ($user['repmoney'] < 50000) unset($mldiag[2]);
			} elseif ($_GET['qaction'] == 2 && $fstep && $user['repmoney'] >= 50000) {
				$mldiag = array(
					0 => "�� ������ ����, ��� ���� ������ �������, � ��� ����� ��������� ����������. �� ������ ��������, ��� �� ����������, � �������� 100 ����������� ����, 20 ���� �� ����������� �������. ����� ����� �� ������ ��������, ��� �� �� ������ ���� ��� ����, � 50 ������� � ����� �����������.",
					3 => "� ������ ���.",
				);
			} elseif ($_GET['qaction'] == 3 && $fstep && $user['repmoney'] >= 50000) {
				mysql_query('START TRANSACTION') or QuestDie();

				PutQItemTo($user,'�����������',$todel) or QuestDie();

				mysql_query('UPDATE oldbk.map_var SET val = 4 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();

				$q = mysql_query('UPDATE oldbk.users SET `repmoney` = `repmoney` - 50000 WHERE id = '.$user['id']);
				if ($q === FALSE) return FALSE;

		  		$rec['owner']=$user[id]; 
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money'];
				$rec['owner_rep_do']=$user['repmoney'];
				$rec['owner_rep_posle']=$user['repmoney']-50000;
				$rec['target_login']="������";
				$rec['sum_rep'] = 50000;
				$rec['type'] = 395;
				if (add_to_new_delo($rec) === FALSE) QuestDie();

				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s41","0")') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s42","0")') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s43","0")') or QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� �������� ��, ��� ������?",
				11111 => "���, � ��� �� ��� ������. � ����� �����.",
				1 => "��, � �������� ��� ��� ������. ������� 40 �����.",
				11112 => "������ ���� ��������, ��� �����.",
			);
			if (!$fstep) unset($mldiag[1]);
		}		
	}

	if ($step == 4) {
		$fstep = false;

		$qq1 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s41"'));
		$qq2 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s42"'));
		$qq3 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s43"'));
		if ($qq1['val'] >= 100 && $qq2['val'] >= 20 && $qq3['val'] >= 50) $fstep = true;


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1  && $fstep) {
				$mldiag = array(
					0 => "�������! ����� �� �� ������ ��� 50 000 ����� ��������� � ��������������?",
					2 => "��, ������� ���������.",
					11112 => "���, � ���� ������� ��� �� ���������, � ����� �������.",
				);
				if ($user['repmoney'] < 50000) unset($mldiag[2]);
			} elseif ($_GET['qaction'] == 2 && $fstep && $user['repmoney'] >= 50000) {
				$mldiag = array(
					0 => "�� �������� � ���� �������. ��� ������, ��� �� ��� ����� �� �������! ��������� ������� ����� ������� ��������. �����-�� � ������� ����� ���� � ��������� ��� �����, � ������� ���� 50 ���������� �����. ������ �� ������ ������  50 ����� ���� � �������� ���.",
					3 => "� ������� ���� ����� ����.",
				);
			} elseif ($_GET['qaction'] == 3 && $fstep && $user['repmoney'] >= 50000) {
				mysql_query('START TRANSACTION') or QuestDie();

				mysql_query('UPDATE oldbk.map_var SET val = 5 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();

				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s41"') or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s42"') or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s43"') or QuestDie();

				$q = mysql_query('UPDATE oldbk.users SET `repmoney` = `repmoney` - 50000 WHERE id = '.$user['id']);
				if ($q === FALSE) return FALSE;

		  		$rec['owner']=$user[id]; 
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money'];
				$rec['owner_rep_do']=$user['repmoney'];
				$rec['owner_rep_posle']=$user['repmoney']-50000;
				$rec['target_login']="������";
				$rec['sum_rep'] = 50000;
				$rec['type'] = 395;
				if (add_to_new_delo($rec) === FALSE) QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� �������� ��, ��� ������?",
				11111 => "���, � ��� �� ��� ������. � ����� �����.",
				1 => "��, � �������� ��� ��� ������.",
				11112 => "������ ���� ��������, ��� �����.",
			);
			if (!$fstep) unset($mldiag[1]);
		}		
	}


	if ($step == 5) {
		$fstep = false;

		$todel = QItemExistsCountID($user,667667,50);

		if ($todel !== FALSE) {
			$fstep = true;
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1  && $fstep) {
				$mldiag = array(
					0 => "�������! ����� �� �� ������ ��� 50 000 ����� ��������� � ��������������?",
					2 => "��, ������� ���������.",
					11112 => "���, � ���� ������� ��� �� ���������, � ����� �������.",
				);
				if ($user['repmoney'] < 50000) unset($mldiag[2]);
			} elseif ($_GET['qaction'] == 2 && $fstep && $user['repmoney'] >= 50000) {
				$mldiag = array(
					0 => "�� ����� � ������ �������! ��� �������, ��� �� �� ������� ����������� ����� � ���� � �����, ����� �������� �������� � ��� �� ���������� � ������. ������ ������� ����� 30 ��� � ������� ��� 10 ������� ����� ������.",
					3 => "� ������ ���.",
				);
			} elseif ($_GET['qaction'] == 3 && $fstep && $user['repmoney'] >= 50000) {
				mysql_query('START TRANSACTION') or QuestDie();

				mysql_query('UPDATE oldbk.map_var SET val = 6 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s6","0")') or QuestDie();

				PutQItemTo($user,'�����������',$todel) or QuestDie();

				$q = mysql_query('UPDATE oldbk.users SET `repmoney` = `repmoney` - 50000 WHERE id = '.$user['id']);
				if ($q === FALSE) return FALSE;

		  		$rec['owner']=$user[id]; 
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money'];
				$rec['owner_rep_do']=$user['repmoney'];
				$rec['owner_rep_posle']=$user['repmoney']-50000;
				$rec['target_login']="������";
				$rec['sum_rep'] = 50000;
				$rec['type'] = 395;
				if (add_to_new_delo($rec) === FALSE) QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� �������� ��, ��� ������?",
				11111 => "���, � ��� �� ��� ������. � ����� �����.",
				1 => "��, � �������� ��� ��� ������. ������� �����.",
				11112 => "������ ���� ��������, ��� �����.",
			);
			if (!$fstep) unset($mldiag[1]);
		}		
	}

	if ($step == 6) {
		$fstep = false;

		$qq1 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s6"'));
		$todel = QItemExistsCountID($user,3002500,10);

		if ($todel !== FALSE && $qq1['val'] >= 30) {
			$fstep = true;
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1  && $fstep) {
				$mldiag = array(
					0 => "�������! ����� �� �� ������ ��� 50 000 ����� ��������� � ��������������?",
					2 => "��, ������� ���������.",
					11112 => "���, � ���� ������� ��� �� ���������, � ����� �������.",
				);
				if ($user['repmoney'] < 50000) unset($mldiag[2]);
			} elseif ($_GET['qaction'] == 2 && $fstep && $user['repmoney'] >= 50000) {
				$mldiag = array(
					0 => "����, ������� ����� ���� ���, �� ������! �� ������� ����, ������ ������, ��� �� �� ������ �����, � ����������! ��������� ������, ������� ���� ���� ���������, ��� ��������, ��� �� ����� ��������� � ����� ���� ����� �������� ��������, � �� ��������� �� ������, ����������, ���� ������ ������ � �������� ������. ����� ������� � 50 ��������� ���� ��� � 1 ������ ���. ������ ����, ��� ������ ���� ��������� ��������� ���, � �� ����������. ������� ���� ������� ����� ��� ��� � �������� - �� ���������. ��� �� ������� ��������� ������, �� � ����������� �� ������. 50 ��������� ���� ��� 1 ����� ������� ��� - ��� ��������� - ����� ������� �� ��������.",
					3 => "� ������ ���.",
				);
			} elseif ($_GET['qaction'] == 3 && $fstep && $user['repmoney'] >= 50000) {
				mysql_query('START TRANSACTION') or QuestDie();

				mysql_query('UPDATE oldbk.map_var SET val = 7 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();

				PutQItemTo($user,'�����������',$todel) or QuestDie();
				mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s6"') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s71","0")') or QuestDie();
				mysql_query('INSERT INTO oldbk.map_var (`owner`,`var`,`val`) VALUES ('.$user['id'].',"q32s72","0")') or QuestDie();

				$q = mysql_query('UPDATE oldbk.users SET `repmoney` = `repmoney` - 50000 WHERE id = '.$user['id']);
				if ($q === FALSE) return FALSE;

		  		$rec['owner']=$user[id]; 
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money'];
				$rec['owner_rep_do']=$user['repmoney'];
				$rec['owner_rep_posle']=$user['repmoney']-50000;
				$rec['target_login']="������";
				$rec['sum_rep'] = 50000;
				$rec['type'] = 395;
				if (add_to_new_delo($rec) === FALSE) QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� �������� ��, ��� ������?",
				11111 => "���, � ��� �� ��� ������. � ����� �����.",
				1 => "��, � �������� ��� ��� ������. ���, ������ ������.",
				11112 => "������ ���� ��������, ��� �����.",
			);
			if (!$fstep) unset($mldiag[1]);
		}		
	}
	if ($step == 7) {
		$qq1 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s71"'));
		$qq2 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s72"'));

		$fstep = false;
		if ($qq1['val'] >= 50) $fstep = 1;
		if ($qq2['val'] >= 1) $fstep = 2;

		if ($fstep == 2) {
			// ������
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1  && $fstep) {
					$mldiag = array(
						0 => "����� � ����� ������� ��� ��� ���������� �� ����� ���� � ����� �� ����� �����������. ������� �� ���� ��� ��� �� ����� ���� ��������� � ��������������. �� �������� ����������� �������! � � �������� ����� ���� ���� ������ ������������ �����. ���� ��� � ������! �� � ����� ����, �� ������� ���� �������, ������ ���� �������� ���������� ���������� �����. ����� ����, ����������� ����! � ��� ���� ���������� �����...",
						2 => "����� ����, �����������. ������� ������ �����! (��������� �����)",
					);
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();
	
					mysql_query('UPDATE oldbk.map_var SET val = 8 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();
	
					mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s71"') or QuestDie();
					mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s72"') or QuestDie();
					mysql_query('UPDATE oldbk.users SET medals = CONCAT(medals,"k203;") WHERE id = '.$user['id']) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					Redirect("mlstranger.php");
				}
			} else {
				$mldiag = array(
					0 => "������, �� �������� ��, ��� ������?",
					11111 => "���, � ��� �� ��� ������. � ����� �����.",
					1 => "��, � �������� ��� ��� ������.",
					11112 => "������ ���� ��������, ��� �����.",
				);
			}		
		} elseif ($fstep == 1) {
			// 50 �����
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1  && $fstep) {
					$mldiag = array(
						0 => "�������! ����� �� �� ������ ��� 50 000 ����� ��������� � ��������������?",
						2 => "��, ������� ���������.",
						11112 => "���, � ���� ������� ��� �� ���������, � ����� �������.",
					);
					if ($user['repmoney'] < 50000) unset($mldiag[2]);
				} elseif ($_GET['qaction'] == 2 && $fstep && $user['repmoney'] >= 50000) {
					$mldiag = array(
						0 => "�� �������� ����������� �������! � � �������� ����� ���� ���� ������ ������������ �����. ���� ��� � ������! �� � ����� ����, �� ������� ���� �������, ������ ���� �������� ���������� ���������� �����. ����� ����, ����������� ����! � ��� ���� ���������� �����...",
						3 => "����� ����, �����������! ������� ������ �����! (��������� �����).",
					);
				} elseif ($_GET['qaction'] == 3 && $fstep && $user['repmoney'] >= 50000) {
					mysql_query('START TRANSACTION') or QuestDie();
	
					mysql_query('UPDATE oldbk.map_var SET val = 8 WHERE owner = '.$user['id'].' AND var = "q32"') or QuestDie();
	
					mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s71"') or QuestDie();
					mysql_query('DELETE FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32s72"') or QuestDie();
	
					$q = mysql_query('UPDATE oldbk.users SET `repmoney` = `repmoney` - 50000 WHERE id = '.$user['id']);
					if ($q === FALSE) return FALSE;
	
			  		$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['owner_rep_do']=$user['repmoney'];
					$rec['owner_rep_posle']=$user['repmoney']-50000;
					$rec['target_login']="������";
					$rec['sum_rep'] = 50000;
					$rec['type'] = 395;
					if (add_to_new_delo($rec) === FALSE) QuestDie();
					mysql_query('UPDATE oldbk.users SET medals = CONCAT(medals,"k203;") WHERE id = '.$user['id']) or QuestDie();	
					mysql_query('COMMIT') or QuestDie();
					Redirect("mlstranger.php");
				}
			} else {
				$mldiag = array(
					0 => "������, �� �������� ��, ��� ������?",
					11111 => "���, � ��� �� ��� ������. � ����� �����.",
					1 => "��, � �������� ��� ��� ������.",
					11112 => "������ ���� ��������, ��� �����.",
				);
			}		
		} else {
			$mldiag = array(
				0 => "������, �� �������� ��, ��� ������?",
				11111 => "���, � ��� �� ��� ������. � ����� �����.",
				11112 => "������ ���� ��������, ��� �����.",
			);
		}
	}
