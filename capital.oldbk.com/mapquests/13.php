<?php
	// ����� ����� ��� ��������
	$q_status = array(
		0 => "�������� �������� �������� ������� ����� (%N1%/3), ���� (%N2%/1) � �������� ������� ����� (%N3%/1)",
		1 => "����� 10 ����������� � ��������� (%N1%/10)",
		2 => "������� ������ ������ � ����������",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 13) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	$ai = explode("/",$questexist['addinfo']);

	if ($sf == "mlwood") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003044);
		$qi2 = QItemExistsID($user,3003046);
		$qi3 = QItemExistsCountID($user,3003045,3);
		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2,$qi3);
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "�� ������ ������� �����, ��� � �������. ��� ��� ������, ��� ������. � ���� �� �������� �������������. ����� �� �����.",
					3 => "�������, ������ ��� ������ ",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,250) or QuestDie();
				$m = AddQuestM($user,2,"�������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItem($user,15562,"�������",0,$todel,255,"eshop") or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ �����������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� ������?",
			);
			if ($mlqfound) $mldiag[1] = "��,  ��� �����, ������ ����, �������� ������� �����, �������� ���� �� ���������. ����� ����� ����� �����, ����� ������.";
			$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
			$mldiag[11111] = "���, � ��� �� �����, ����� ������.";
		}		
	}

	if ($sf == "mlhunter" && !QItemExists($user,3003044)) {
		if ($ai[0] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "������� ����� �������, � ���  ����� � �������. ������� ������ ������� �� ������. ������ � �� ������. �� � � ���� � ���� ������� ���� � ��������� ����� ���������� � ���� ������ �������������. �������� ����� � ���� ���. ������ ������ �������� ������, � ������ ��� � ������ ���� ������. �� � ����� ��� ������. �� ����� ��������� � �������� �����, �� ������� ��� ��������, �� ������ ��������� � �������� ��� � ���� �� ����������. �� ������ �������� � ������� 10, ������� ����� ���� �����������. �����, ��������� � ����, ���-������ �����. � � ���� ���� ���� ����������.",
						2 => "������������, � ������ ���� �������� �����������.",
					);
				} elseif ($_GET['qaction'] == 2) {
					$ai[0] = 1;
					mysql_query('START TRANSACTION') or QuestDie();
					UpdateQuestInfo($user,13,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
					1 => "������ ������� � ���� ���� �� ����� ��� ��������. �� ��� ��������������, ��� ���� �������.",
					11111 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		} else {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $ai[0] == 11) {
					$mldiag = array(
						0 => "��, ����, ������� ���� ��������. ��������� ��� ���� �������, �� �������, �� �� �������� ��� ������ ������! �������!... ����� ����, ��� �� ������. ������, ��� � ���� ������� ����. �������� ������� ����� ���������.",
						2 => "�������, ��� ��������.",
					);
				} elseif ($_GET['qaction'] == 2 && $ai[0] == 11) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003044,"�������",0,array()) or QuestDie();

					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[0] = 0;
					UpdateQuestInfo($user,13,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
				);
				if ($ai[0] == 11) {
					$mldiag[1] = "��, ���������� � ������������. ������ � ���� ������ ����.";
				}
				$mldiag[11111] = "���, � ��� �� �����, ����� ������.";
			}
		}
	}

	if ($sf == "mlpost" && QItemExists($user,3003043)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "������� �� ��������. �������� �������� ����� 5 ����� ����������, � ��� ����� ���� �������� ��� ������. �������, �����������. ������� ������, ��� ��� ����� ���������� � ������ ����. � ����� ����������� ������, ����� �� � ��� �� ����� �� ������� �� ������� �������� ����.",
					2 => "����������� �������, �����.",
				);
			} elseif ($_GET['qaction'] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItemTo($user,"���������",QItemExistsID($user,3003043)) or QuestDie();

				$ai[1] = 2;
				UpdateQuestInfo($user,13,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "����������� ����, ������, �� ���� �������. ������� ����� ��� ������ �����?",
				1 => "������ ������ ���� ������ ������� ��������. ��� �����.",
				11111 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}		
	}

	if ($sf == "mlknight" && !QItemExists($user,3003046)) {
		if ($ai[1] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "����� ����, �� ������ ������. �� ��� ������ ��������� ������ � ���-��� ��������� �� ����� ��������� �����. ��� ����� � �����, ���� �� ��� ������������. ������ ������ �� ��� ���������, ���� � ��� �������. ����� ����������� ��� � �� ���� ������ � ����������, ������ �� ���� ������, � � �� ������� ���������. � ������ �����������, �����, ����� �����.",
						2 => "������, ����� ������, � ����� �������.",
					);
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003043,"�������� ������",0,array()) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[1] = 1;
					UpdateQuestInfo($user,13,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ ������. ������� ��������� � ������ � ��������� � ������, ��� ������� �� �����?",
					1 => "������ � ���� � ��������. ������� ���� ������� ����� �������, ��� �� ����� �����, � �� �������������� ������. ����� � ���� �� ������� �������� ������� ����� ��� �� ���������?",
					11111 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		} else {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $ai[1] == 2) {
					$mldiag = array(
						0 => "��� �������, �� ��� ������� �����! � � ��� ���� ����� ��� ����� �����, ��� �������. ��� �����. ������ �����, ������� ��� ����� �� ������.",
						2 => "�������, ��� ��������.",
					);
				} elseif ($_GET['qaction'] == 2 && $ai[1] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003046,"�������� ������",0,array()) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>�������� �����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[1] = 0;
					UpdateQuestInfo($user,13,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
				);
				if ($ai[1] == 2) {
					$mldiag[1] = "��,  ������� ���������� ���� ������, ����������� ������ ��������. � ������ ��������, ���  ���� � ����� ���� �� ����.";
				}
				$mldiag[11111] = "���, � ��� �� �����, ����� ������.";
			}
		}
	}

?>