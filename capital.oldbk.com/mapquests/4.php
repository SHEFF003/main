<?php
	// ����� ��������� ������� 
	$q_status = array(
		0 => "������ ���������� ��������� �������.",
		1 => "������� ���������� � ������������.",
		2 => "������� ���������� � �������.",
		3 => "������� ���������� � ����������.",
		4 => "������� ���������� � �����������.",
		5 => "������� �������.",
	);
	

	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 4) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlpost") {
		$mlqfound = false;
		$todel = QItemExistsID($user,3003015);
		if ($todel !== FALSE) $mlqfound = true;

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��, ��� �� ����� �������! ��� �������! � �� � �� ��������, ��� �� �� �������. �� �� �������������, ��� ��� ���� ����� ��� ������.  ��� � ������, � ���� �����������.",
					3 => "�������� �������",
				);
			} elseif ($_GET['qaction'] == 5) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
                                mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				// �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,200) or QuestDie();
				$m = AddQuestM($user,1,"���������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItem($user,105,"���������",7,$todel,255) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();


				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
			);

			if ($mlqfound) $mldiag[1] = "��, ��� ���� �������, ��� ���� � �����������.";
			$mldiag[5] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
			$mldiag[2] = "���, � ��� �� �����. ����� ������.";

		}
	}

	if ($sf == "mlvillage") {
		if ($step == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�������, ��������? ���, �� ����� ���� ��� ����������, ���� � ��� �����, �� ����� ��������� � ������ �� ��������� ���������. �� ���� ����� ������ �� ���������. ����� � ������, �� ����� �� ������� ����-���� ������, �����, �������� ���-������.",
						3 => "�������, ��� � ������."
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,4,1) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
					1 => "��������� ������� ������ �������. �� �� �������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlknight") {
		if ($step == 1) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��, ������� ��� ���������, ��� ��� � ����� ����� ������� ����� ���� ������ �� ����, ��� ������ ������ ������ ����� ������������ � �� ���������. ��� ������, ���-��� ����. � �� �����, ��� ��� ��� �������� ����� �� ���� ������. � ��� �������, �� ����. �� �������. ������ � ���������, �� ������ � ����� ���� ���. ",
						3 => "�������, ��� � ������."
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,4,2) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ ������. ������� ��������� � ������ � ��������� � ������, ��� ������� �� �����?",
					1 => "��������� ������� ������ �������. �� �� �������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlboat") {
		if ($step == 2) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�� �����,  � ����������� � ����� ����������, � ����� ����, ������, ����������� ���������. ���� �� ��� �������, �� ��������� ��� ���������. ��� ��� ������, ������� �������. �� ���� �, ��� ���������� ���� �� ������. �� � �����-�� � ��� �� ������ ���������. ",
						4 => "������� �� �����, ����� � �����������, � �� �� ��������."
					);
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "��������� ���������. ������� 1 ������, � �������.",
						33333 => "��������� 1 ������.",
						5 => "����������� � ����.",
					);
				} elseif ($_GET['qaction'] == 4) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,4,3) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������.",
					1 => "��������� ������� ������ �������. �� �� �������?",
					2 => "��� �� ������������� �� �� �������. ������� ��� ����� ������?",
					3 => "�� ����, � ������ �������� ����. ����� ������."
				);
			}
		} else {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "��������� ���������. ������� 1 ������, � �������.",
						33333 => "��������� 1 ������.",
						4 => "����������� � ����.",
					);
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������.",
					2 => "��� �� ������������� �� �� �������. ������� ��� ����� ������?",
					3 => "�� ����, � ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlrouge") {
		if ($step == 3 && !QItemExists($user,3003015)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��� ��� ������!  �������, ������, ���  ������� � ���?  �� � ���� ���� � � ���, ��, ����-�� ��� � ����? ��� �� �����, ���  �� �� ���� ��� ������ �������? ��, ����� �� ������� ������  - ����� ���� �� �������,  ��� ����� � ���� ������ �������� ������� �� � ��� ����� ?",
						3 => "��� � ���� ������� ����� ����������. ��� 10 �������� �� �������.",
						4 => "� �� ������ �������� ������, � ��� � ��� �������� ���.",
						5 => "�, �������, ����� ������.",
					);

					if ($user['money'] < 10) unset($mldiag[3]);
				} elseif ($_GET['qaction'] == 3 && $user['money'] >= 10) {
					// 10 �������� �� �������
					mysql_query('START TRANSACTION') or QuestDie();
					$rec = array();
		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-10;
					$rec['target']=0;
					$rec['target_login']="���������";
					$rec['type']=252; // ����� ���������� ����
					$rec['sum_kr']=10;
					add_to_new_delo($rec) or QuestDie(); //�����

					// �������� ������
					mysql_query('UPDATE oldbk.`users` set money = money - 10 WHERE id = '.$user['id']) or QuestDie();

					// ��� ����
					PutQItem($user,3003015,"���������") or QuestDie();

					// ��������
					addchp ('<font color=red>��������!</font> ��������� ������� ��� <b>�������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 4) {
					// ������� � �����������
					mysql_query('START TRANSACTION') or QuestDie();
					StartQuestBattle($user,535) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					Redirect('fbattle.php');
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������-��, � ��� ����� �� ������! ��� ������, �� ���� �� ��� �����. � ��� �� ������� ���� � ��� ���?",
					1 => "��������� ������� ������ �������. �� �� �������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}
?>