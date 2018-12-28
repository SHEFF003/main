<?php
	// ����� �������� �����
	$q_status = array(
		0 => "�������� ����������� ��������� (%N1%/1), ��������� ������� (%N2%/1) � ��������� ������ ��������� ������� (%N3%/1).",
		1 => "�������� ������� 4 ������� ����. (%N1%/4)",
		2 => "�������� ������ 2 ��������. (%N1%/2)",
		3 => "������� ������ ��������� � ���������� � ��������� �� ��������.",
	);
	

	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 2) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlvillage") {
		if ($step == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			// ����������
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003006); // ��������
			$qi2 = QItemExistsID($user,3003008); // ������
			$qi3 = QItemExistsID($user,3003010); // �������
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��, ��� � ���! �� ������ ���, ��� ��� �����, � ������ � ������ ����� ������� � ���� �����! ������� ���� ������������� �� ������. �� ��������� �������������� � ������, � ������ ���� ��������� ���� �����������.",
						5 => "�������� �������",
					);
				} elseif ($_GET['qaction'] == 5 && $mlqfound) {
					// �������
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,250) or QuestDie();
					$m = AddQuestM($user,2,"����������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();

					if ($user['level'] == 6) {
						$item = 33029;
					} elseif ($user['level'] == 7) {
						$item = 33030;
					} else {
						$item = 33031;
					}

	
					PutQItem($user,$item,"����������",0,$todel,255) or QuestDie();
	
					$msg = "<font color=red>��������!</font> �� �������� <b>���� �����</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					UnsetQuest($user) or QuestDie();
					UnsetQA();
					mysql_query('COMMIT') or QuestDie();
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();					
					UnsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					UnsetQA();			
				} else {
					UnsetQA();
				}
				
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
				);
				if ($mlqfound) $mldiag[1] = "��, ��� ���, ��� ����� ��� ������.";

				$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
				$mldiag[3] = "���, � ��� �� ��� ������. ����� ������.";
			}
		}

		if ($step == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			// ������
			if (QItemExists($user,3003006)) {
				if (isset($_GET['qaction'])) unsetQA();
				return;
			}

			$ai = $questexist['addinfo'];
			$ai = explode("/",$ai);

			$mlqfound = false;
			$todel = QItemExistsCountID($user,3003005,4);

			if ($todel !== FALSE) {
				$mlqfound = true;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001) {
					$mldiag = array(
						0 => "����� ��� ����� ���������? ���������, ��� �� � ���� ������? ��������� ������ ����� �� ��� �������� �� ��� ��������. ����������, ��� �� �� ���� �� ���� �� ������ ������ ��������. ������� ��� 4 ������� ���� � �������, � � ������ ��� �����.",
						2100 => "������, � ������� ���� ���, ��� �����.",
						11111 => "���, ��� ������� ������, � ����� ������ �� ����� �����.",
					);
				} elseif ($_GET['qaction'] == 2003 && $mlqfound) {
					$mldiag = array(
						0 => "�� ������ ���������.  �����, ��� ���������� ����� ����������� �������� ��� ����� �������. ����� ���������.",
						2200 => "������� ���������.",
					);
				} elseif ($_GET['qaction'] == 2200 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();					
					PutQItem($user,3003006,"������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>���������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[0] = 0;
					UpdateQuestInfo($user,2,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} elseif ($_GET['qaction'] == 2100) {
					$ai[0] = 1;
					mysql_query('START TRANSACTION') or QuestDie();					
					UpdateQuestInfo($user,2,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();					
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				if ($ai[0] == 0) {
					$mldiag = array(
						0 => "������, ��� ���� ���� ������?",
						2001 => "���������� ������ ���� � ���� �� ���������.",
						11111 => "������ ����������, ������ �������� ����. ����� ������.",
					);
				} elseif ($ai[0] == 1) {
					$mldiag = array(
						0 => "������, �� ������ ��� ��, ��� � ������?",
					);				
					if ($mlqfound) $mldiag[2003] = "��, ��� 4 ������� ����, ��� �� ������.";
					$mldiag[2004] = "���, � ��� �� ��� ������. ����� ������.";
				}
			}
		}
	}

	if ($sf == "mlwitch") {
		if (QItemExists($user,3003008)) {
			if (isset($_GET['qaction'])) unsetQA();
			return;
		}

		$ai = $questexist['addinfo'];
		$ai = explode("/",$ai);

		$mlqfound = false;
		$todel = QItemExistsCountID($user,3003007,2);
		if ($todel !== FALSE) {
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, ���� � ���� �����, ��, ���� �������� �� ������� ��� ��������� �������. �� ����� ���������� �������, � ������ ��� �����. ���� ����, ������� ��� ���� ������� �������� � ������ �����, ��� ������ � ���������� ������. ������ �� ���� ������ �������, ���� ���� ������� ����� ����� � ���� ����� ����.",
					3 => "������, � ������� ���� ���, ��� �����.",
					4 => "���, ��� ������� ������, � ����� ������ �� ����� �����.",
				);
			} elseif ($_GET['qaction'] == 10 && $mlqfound) {
				$mldiag = array(
					0 => "������ �������? ��� �������! ������ ��� �����, ��� ������ � � ��������� ��������. ����� ���� ������, �� �� ������ ��������. ����� ���� �� ����!",
					12 => "������� ������ ��������� �������",
				);
			} elseif ($_GET['qaction'] == 12 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003008,"������",0,$todel) or QuestDie();

				addchp ('<font color=red>��������!</font> ������ �������� ��� <b>������ ��������� �������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				$ai[1] = 0;
				UpdateQuestInfo($user,2,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				
			} elseif ($_GET['qaction'] == 3) {
				$ai[1] = 1;
				mysql_query('START TRANSACTION') or QuestDie();
				UpdateQuestInfo($user,2,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			if ($ai[1] == 0) {
				$mldiag = array(
					0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����?",
					1 => "���������� ������ ������ ��������� ������� ��� ������ �������� ������.",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			} elseif ($ai[1] == 1) {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � �������?",
				);
				if ($mlqfound) $mldiag[10] = "��, ��� ������� � ������ ����� � ���������� ������.";
				$mldiag[11] = "���, � ��� �� ��� ������. ����� ������.";
			}
		}
	}

	if ($sf == "mlpiligrim") {
		if (QItemExists($user,3003010)) {
			if (isset($_GET['qaction'])) unsetQA();
			return;
		}

		$ai = $questexist['addinfo'];
		$ai = explode("/",$ai);

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, ���������� ����� � ���� �������. �����, ����� ���� �� ����� ������ ����� ������� �������. ������, ������ ������ ����? ���-�� ��������� ����� ��������� ����� ���� �� ��� ����������, � � ���� ���� ������� ������. ������ ��� ���������� � �����������, � ���-��� ����� ����������� ��� ���� �������. ",
					3 => "������, � ������ ��, ��� �� �������.",
					4 => "���, ��� ������� ������, � ����� ������ �� ����� �����.",
				);
			} elseif ($_GET['qaction'] == 3 && $ai[2] == 0) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003009,"��������",0) or QuestDie();

				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				$ai[2] = 1;
				UpdateQuestInfo($user,2,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				
			} elseif ($_GET['qaction'] == 5 && $ai[2] == 2) {
				$mldiag = array(
					0 => "������� ���� �� ������. ��� ���, ��� ��������� ������ ��� ������ �����, �����? �� �������, �������, ��� ��� ������ ����� ���������� �������. ����� ������� � ���� ��� �����������. ������ �� �������� ����� �� ������, � �� ����������.",
					7 => "������� �������",
				);
			} elseif ($_GET['qaction'] == 7 && $ai[2] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003010,"��������",0) or QuestDie();

				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>�������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				$ai[2] = 0;
				UpdateQuestInfo($user,2,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				
			} else {
				unsetQA();
			}
		} else {
			if ($ai[2] == 0) {
				$mldiag = array(
					0 => "������, �������, � �� ��� ���-�� ������. ����� ����� ������ �����. �����������, �� ������ �������� ��������� ��� ���� ������� ����?",
					1 => "���������� ������ �������� ��� ������� �� ����.",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			} elseif ($ai[2] == 1 || $ai[2] == 2) {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
				);
	
				if ($ai[2] == 2) $mldiag[5] = "��, ���� ������ ��� � ����������.";

				$mldiag[6] = "���, � ��� �� ��� ������. ����� ������.";
			}
		}
	}

	if ($sf == "mlpost") {
		$ai = $questexist['addinfo'];
		$ai = explode("/",$ai);

		$mlqfound = false;
		$todel = QItemExistsID($user,3003009);
		if ($todel !== FALSE) {
			$mlqfound = true;
		}
	
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == "1" && $mlqfound) {
				$mldiag = array(
					0 => "�� ����-��, � � ������ ��������� � ���� �� ������. ������� � ���� ��� �������� ��������� ����� �������, ����� ���� � ��� �������� ��� ���� ������. ��� � ���� ������-������-������. ����� ��������, ��� ��� ��������� �� ������ ��� ��������. ����� ������, ��� �� ������.",
					3 => "������ ������.",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItemTo($user,"���������",$todel) or QuestDie();

				$ai[2] = 2;
				UpdateQuestInfo($user,2,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();							
			} else {
				unsetQA();
			}
		} else {
			if ($ai[2] == 1) {
				$mldiag = array(
					0 => "����������� ����, ������, �� ���� �������. ������� ����� ��� ������ �����?",
				);

		        	if ($mlqfound) $mldiag[1] = "�������� ������� ��� ���� ������ �������.";
				$mldiag[2] = "������ ����������, ������ �������� ����. ����� ������.";
			}
		}
	}
?>