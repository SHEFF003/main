<?php
	// ����� ������ �� ������� 
	$q_status = array(
		0 => "�������� ������ ������� (%N1%/1), ���������� ����� (%N2%/1) � ���� (%N3%/1).",
		1 => "�������� ������� 10 �������� ���� (%N1%/10)",
		2 => "�������� �������� �����.",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 19) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	$ai = explode("/",$questexist['addinfo']);

	if ($sf == "mlhorse") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003069);
		$qi2 = QItemExistsID($user,3003070);
		$qi3 = QItemExistsID($user,3003072);

		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2,$qi3);
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��� �������! ������� ������! ������ � ������� ��� ������� � �������! � �� ����� ����������� �������. �� ���������� ������, �����, ��� ��������� ��������.",
					2 => "�������, ��� �������",
				);
			} elseif ($_GET['qaction'] == 66) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,150) or QuestDie();
				$m = AddQuestM($user,2,"�����") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();
	
				PutQItem($user,144144,"�����",0,$todel,255) or QuestDie();
	
				$msg = "<font color=red>��������!</font> �� �������� <b>��������� �����������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();

			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
				1 => "��, ��� ���� ����� ��� �����, ���� � ����� �������.",
				30000 => "������� � �������",
				66 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				11111 => "���, � ��� �� ��� ������. ����� ������.",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}		
	}

	if ($sf == "mlvillage" && $ai[0] < 2) {
		if ($ai[0] == 0 && (((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000)))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001) {
					$mldiag = array(
						0 => "�� �� ��� ������� �� �������, �� ������ ���� ����� ��� ������. ��������� ������� �������� ���� � ������ ���� ������� �� 5 �����.",
						2003 => "������, � ������� ���� ���, ��� �����.",
						2002 => "���, ��� ������� ������, � ����� ������ �� ����� �����.",
					);
				} elseif ($_GET['qaction'] == 2003) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 1;
					UpdateQuestInfo($user,19,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��� ���� ���� ������?",
					2001 => "� � ���� �� ������ � ��������. ������� � ������� �������. ������ ������� �����.",
					2002 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
		if ($ai[0] == 1 && (((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000)))) {
			$mlqfound = false;
			$todel = QItemExistsCountID($user,3003005,10);
			if ($todel !== FALSE) {
				$mlqfound = true;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && $mlqfound) {
					$mldiag = array(
						0 => "������ ���������. �� � � ������ ���� ������ ������. ����� ���� �������, �� ������ ������ �� ���� �������.",
						2003 => "�������, ����������� �������.",
					);
				} elseif ($_GET['qaction'] == 2003 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003069,"������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>�������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[0] = 2;
					UpdateQuestInfo($user,19,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					2001 => "��, ��� 10 �������� ����, ��� �� ������.",
					2002 => "���, � ��� �� ��� ������. ����� ������.",
				);
				if (!$mlqfound) unset($mldiag[2001]);
			}
		}
	}

	if ($sf == "mlwood" && $ai[1] < 2) {
		if ($ai[1] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "����� �����, ��������? ����, �������. �� ������ ����� ������ ���������. ������ � ���������, �� ��� ����� ����� ������, �� ��� ����� �� ��������. ��������� �����, � ��� ������ �������.",
						3 => "������, � ������� ���� �����.",
						2 => "���, ��� ������� ������, � ����� ������ �� ����� �����. ",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[1] = 1;
					UpdateQuestInfo($user,19,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ����� ��������� ����������. � �������� ��� � ������, ��� ��� ��� � ��� �����. ����� ��������� ��� ���� ������� ������?",
					1 => "� ������ ����� �� �������� ���������� ����������. ������ ������� ���� ��������, �� �� ��������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}

		if ($ai[1] == 1) {
			$mlqfound = false;
			$todel = QItemExistsID($user,3003071);
			if ($todel !== FALSE) {
				$mlqfound = true;
			}

			$qi1 = QItemExistsID($user,3003012);

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��� ������� �����, �� ������� ��������. ��� �������! ����� ���� ����� ��� �����. ��, ������, � ���� ������� ���� ��������, � ������ �� � ��� � ������.  ���� � ��������� ���� � ������� ��! �� �� �����, ���� �����, ��� �� ����� �����.",
						3 => "�������, ��� ��������.",
					);
					if ($qi1 !== FALSE) {
						$mldiag[4] = "�, ��� � ���� � ��������� ���� � �������� ������ � �����! �����! ����� �� ��������!";
					}
				} elseif ($_GET['qaction'] == 4 && $mlqfound && $qi1) {
					$mldiag = array(
						0 => "��� �������! ����� �������! ��������� � ��������! ������������� �� ����. ����� �������, ���������!",
						5 => "�������, ��� ��������",
					);
				} elseif ($_GET['qaction'] == 5 && $mlqfound && $qi1) {
					mysql_query('START TRANSACTION') or QuestDie();

					$todel = array_merge($qi1,$todel);

					PutQItem($user,3003070,"�������",0,$todel) or QuestDie();

					PutQItem($user,105,"�������",7,array(),255,"shop",3) or QuestDie();
	
					$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b> �� ����� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[1] = 2;
					UpdateQuestInfo($user,19,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003070,"�������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>�����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[1] = 2;
					UpdateQuestInfo($user,19,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					1 => "��, ��� �����, ��� �� ������.",
					2 => "���, � ��� �� ��� ������. ����� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}
		}
	}

	if ($sf == "mlfort" && $ai[1] == 1 && !QItemExists($user,3003071)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, �����! ��, �����! ��� 2 ������ ��������, �������� � �����������. �������� �����, �������� ����� � ����� �� ���� ��� ���. ����� ��������� �� ����. �����, ������� ���, �� �� �������	�� ������.",
					3 => "�������, �������.",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003071,"�������",0,array()) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				

			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������� ������, �� ������������. ��� ���������� �����, � �� �������. ��� ��� �������� � �� ����. �� ��� ����� ��� �����? �������, ������!",
				1 => "� � ���� � �������� �� ��������. �������, �� ��� ����� ����� ����� ������, �� ����� �������� �� ������.",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}		
	}

	if ($sf == "mlknight" && $ai[2] == 0) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "����? ��, �� �����! � ��� ���� ������� �������, ��� � �� ����� ���� ������, ���� �� ������. ������, ������� ������� ������ �������. � � ���� �� ������ ���� �������� ��������� ���. ���� ������� ������, ������� � ������ ���������� �������.",
					3 => "�������. � �� ���� � �������� ����������. ������� ���-������ ���, �������, ��������� �� �����.",
				);
			} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003072,"������") or QuestDie();
					PutQItem($user,3003012,"������") or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>����</b> � <b>����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[2] = 2;
					UpdateQuestInfo($user,19,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, ������ ������. ������� ��������� � ������ � ��������� � ������, ��� ������� �� �����?",
				1 => "� �� ���� � ����. ����� ������� � ���� � �������� ������� � ��������, ��� ���� �� �������. �����, �� �� ����� ������� ������� ������?",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}			
	}

	if ($sf == "mlwood" && $ai[1] == 2 && QItemExists($user,3003012)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��� �������! ����� �������! ��������� � ��������! ������������� �� ����. ����� �������, ���������!",
					3 => "�������, ��� ��������",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				$todel = QItemExistsID($user,3003012);

				PutQItem($user,105,"�������",7,$todel,255,"shop",3) or QuestDie();
	
				$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b> �� ����� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				$ai[1] = 3;
				UpdateQuestInfo($user,19,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, ����� �� ������ ��� ����?",
				1 => "��, ����� ��������� ���� � �������� ������! ����� �� ��������!",
				2 => "���, ������ ���� ��������.",
			);
		}		
	}
?>