<?php
	// ����� ����� ����������
	$q_status = array(
		0 => "������ ���������� ������� ������ (%N1%/1), ���� (%N2%/1) � ������� ������ ��� �����. (%N3%/1)",
		1 => "�������� ������� ����. (%N1%/2)",
		2 => "�������� �������� ����. (%N1%/1)",
	);
	

	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 5) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlpost") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003018);
		$qi2 = QItemExistsID($user,3003017);
		$qi3 = QItemExistsID($user,3003016);

		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
			$todel = array_merge($qi1,$qi2,$qi3);
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "������� �� �����. �����, ������� �� ��� � ���������? �-�� � ������ ����� ������, �� �� ��� ������ �����, � ����� ��� ����. �� ����-����, �������� ������, � ����� ������ ����������. �����, ������� ��� ��� ����� ����� ������. ������� �� ������. ���� ������ �������� �������, ���� ��������.",
					3 => "�������� �������",
				);
			} elseif ($_GET['qaction'] == 5) {
                                mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
                                mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,150) or QuestDie();
				$m = AddQuestM($user,1,"���������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				if ($user['level'] == 6) {
					$item = 5202;
					$txt = "90";
				} elseif ($user['level'] == 7) {
					$item = 5202;
					$txt = "90";
				} elseif ($user['level'] == 8) {
					$item = 5205;
					$txt = "180";
				} elseif ($user['level'] == 9) {
					$item = 5205;
					$txt = "180";
				} else {
					$item = 5205;
					$txt = "180";
				}

				PutQItem($user,$item,"���������",0,$todel,255,"eshop") or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ��������������� ".$txt."HP�</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
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

			if ($mlqfound) $mldiag[1] = "��, ��� ���, ��� ����� ��� �����.";
			$mldiag[5] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
			$mldiag[2] = "���, � ��� �� ��� ������. ����� ������.";
		}
	}

	if ($sf == "mlvillage") {
		if ($step == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			if (QItemExists($user,3003016)) {
				if (isset($_GET['qaction'])) unsetQA();
				return;
			}

			$ai = explode("/",$questexist['addinfo']);
			$mlqfound = false;

			if ($ai[0] == 1) {
				$todel = QItemExistsCountID($user,3003005,2);
	
				if ($todel !== FALSE) {
					$mlqfound = true;
				}
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001) {
					$mldiag = array(
						0 => "��������� �������? ��-�� � �����, ����� �� �� �������� �� �������. � ��� ��� ���, �����������. ��, ��� �-� ��� ��������, ������� �������, ����������. ������ ��� ���� ������, �� ��� �� ���� ���� ���������. ���� ��������� ��� ����, ����� ��� � ������ ����. �� ��� ������ ��� ����� ���� �����, ������.",
						2003 => "������, � ������� ���� ���, ��� �����.",
						2004 => "���, ��� ������� ������, � ����� ������ �� ����� �����.",
					);
				} elseif ($_GET['qaction'] == 2005 && $mlqfound) {
	                                mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003016,"������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[0] = 0;
					UpdateQuestInfo($user,5,implode("/",$ai)) or QuestDie();;
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} elseif ($_GET['qaction'] == 2003 && $ai[0] == 0) {
					$ai[0] = 1;
					mysql_query('START TRANSACTION') or QuestDie();
					UpdateQuestInfo($user,5,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				if ($ai[0] == 0) {
					$mldiag = array(
						0 => "������, ��� ���� ���� ������?",
						2001 => "��������� ������� � ���� ���� ���� ���� ����� �����, �� �� ������� ������ ������. �� �� ��������?",
						2002 => "������ ����������, ������ �������� ����. ����� ������.",
					);
				} else {
					$mldiag = array(
						0 => "������, �� ������ ��� ��, ��� � ������?",
					);
					if ($mlqfound) $mldiag[2005] = "��, ��� ����, ��� �� ������.";
					$mldiag[2006] = "���, � ��� �� ��� ������. ����� ������.";
				}
			}
		}

		if ($step == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			$ai = explode("/",$questexist['addinfo']);
			if ($ai[1] != 1) {
				if (isset($_GET['qaction'])) unsetQA();
				return;
			}

			if (QItemExists($user,3003012)) {
				if (isset($_GET['qaction'])) unsetQA();
				return;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�� ���� �����, ����� ������� �� ���. � ���� ������ ������ ����, � ���� ������ �����. � ������ ������, �� ����� ��� � ������ �����, ������ ���� ����. �� ���� ����� ����, ����� ������ � ����� ����� ���� �� �������. � ��� ����, ����� �������? ������� � ���� �����������, ��� ���������. ���������� �������� ����������.  ����� ��������� ����, �������� ���, ������ �����, ��� �� ���� ������.",
						3 => "������������, �����������  �������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003012,"����������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ���������� ������� ��� <b>����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
					1 => "������� ������ �������� ��������� ���������, � ���� �� ��������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlhunter") {
		if ($step == 0) {
			if (QItemExists($user,3003017)) {
				if (isset($_GET['qaction'])) unsetQA();
				return;
			}

			$ai = explode("/",$questexist['addinfo']);
			$mlqfound = false;
			$todel = QItemExistsID($user,3003012);
			if ($todel !== FALSE) $mlqfound = true;

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "����. ���� ����? � �������? ��� ����������, �������, �� �����, �� ���� ������ �������, �� ������ �������� � �����. ���� �����, � ��� ������ � ������� ��������. � ������ ������ ��� �� �����. ���� ����������, ���� ������ �� ��������� ���������. ����?",
						3 => "������, � ������� ���� ���, ��� �����.",
						4 => "���, ��� ������� ������, � ����� ������ �� ����� �����. .",
					);
				} elseif ($_GET['qaction'] == 5 && $ai[1] == 1 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003017,"�������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[1] = 0;
					UpdateQuestInfo($user,5,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();								
				} elseif ($_GET['qaction'] == 3 && $ai[1] == 0) {
					$ai[1] = 1;
					mysql_query('START TRANSACTION') or QuestDie();
					UpdateQuestInfo($user,5,implode("/",$ai)) or QuestDie();;
                                        mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				if ($ai[1] == 0) {
					$mldiag = array(
						0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������? ",
						1 => "� ���������� �� ������� ���� �� ����� �����, �� �� ��������?",
						2 => "������ ����������, ������ �������� ����. ����� ������.",
					);
				} else {
					$mldiag = array(
						0 => "������, �� ������ ��� ��, ��� � ������?"
					);
			
					if ($mlqfound) $mldiag[5] = "��, ��� ���� ������� ���������, ���������� ������� � �������� �� ����. ";
					$mldiag[6] = "���, � ��� �� ��� �����. ����� ������.";
				}
			}
		}
	}

	if ($sf == "mlknight") {
		if ($step == 0) {
			if (QItemExists($user,3003018)) {
				if (isset($_GET['qaction'])) unsetQA();
				return;
			}


			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��� � ������, ������������. � ������� ���� ���� � ����� ��������, �������. �� ������� ����� ������, �� ���� �� �������������,  ��� � ��� �����. ���  � ������� �������, ����� ������ ������, ��� ��������� ��������. ������ � �� ���, �� �������",
						3 => "�������� �����. ����� ������� �����, �� ������ �����������?"
					);
				} elseif ($_GET['qaction'] == 6) {
					// ����� ����
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003018,"������",0,array()) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>������� �����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					unsetQA();
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						5 => "����, �������, ���-�� ��� � ���� ������? � �� ����� ����������, ����� �������. � �� ������� �����, ���� ���� �� ������ ������ ��������.",
						6 => "�������, � �����, ��� ������� ���-������."
					);
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�, ��� ������, ��� �� �����. �������-�������. � ��� ��� �� ���� ������, ��������� ������. ���� ������� ��������  � ����, ���� �������� �������. ��������� ������� ���� � ������������. � ��������� ����, ���� �� �������  �� � �������� ����, ��� ������, ������ �� ������. �����, ������� �� ����, � � ����� ���������?",
					1 => "��, �������, � ������� ��������� �� ������ ������ ���������� �������.",
					2 => "���, � ������ �������� ����. ����� ������.",
				);
			}
		}
	}

?>