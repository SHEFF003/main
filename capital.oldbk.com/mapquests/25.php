<?php
	// ����� ����������� �������������
	$q_status = array(
		0 => "�������� ����������� ����������",
		1 => "������� ����������� �������",
		2 => "������� ����������� �����������",
		3 => "������� ����������� ��������",
		4 => "������� ����������� ���������",
		5 => "��������� ��� ��������� �������� ���� ����� ������",
		6 => "��������� � ����",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 25) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");
	
	$ai = explode("/",$questexist['addinfo']);

	if ($sf == "mlmage") {
		$mlqfound = false;

		if ($step == 2) {
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				$mldiag = array(
					0 => "��������. � ���� ���� � ���������� ���-��� ���������. ��-��-���-���",
					3 => "���, � ��� ��� �� ���������� ������� �� ��������� ������ �����? �������, ���, � �� ���� �����.",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,150) or QuestDie();
				$m = AddQuestM($user,1,"���") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItem($user,144144,"���",0,$todel,255) or QuestDie();

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
				0 => "������, �� ������ ��, ��� � ������?",
				1 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				2 => "�������! ��� ����������� ����������, ��� ������������ � ������� ����������� ������. ",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				11111 => "���� ��� ���, ��� ����� ��� �����.",
			);
			if (!$mlqfound) unset($mldiag[2]);
		}	
	}

	if ($sf == "mlpost") {
		if ($step == 0 && QItemExists($user,3003087)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "���������� ������? ��. ��, ����� �������� �� �� �����������. ����������� ���������, ����������� ���������, ������� ���� � ��������. ����������� ����������� ���� ������ �������� ������ ����� ������� � ����� ����� ���� ���� �����.",
						3 => "�� ��, ��������, ������ �� �����.",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "���������� ����������� ���, �� ��� � �� ����������� �� ���� �� ����� ������� ���� � � �� ����� ������� �������� ����.",
						4 => "�� ��� ����� ������������ �� ���� � � �� �� ����� ��������� ����� ����� ��� �������, ���� ���-�� �� ������ �� ��� ��������!",
					);
				} elseif ($_GET['qaction'] == 4) {
					$mldiag = array(
						0 => "���� ������, � ����� ������ �� �����. ����� �������� ��� ���. � ������ ����� �����������, � ������ ����� �������� ��, ������ �� ����� �������� � ������ �����! � ���-���� ������� ��� ���� ������ ���� �� ��������� ������ �� � ���������� ���, ���� ������, ��� ���� ���� ����������! ��� �� ����� ��� �� ������� ��������� � ���� � ���� ������. ���� ��� �������� �� ����� ������� � ����� �� ������.",
						5 => "� �������-�� ��� ����� �������� ��������, �� ��� ������ ����� ������-�� � �� ������ ��������� ���� ������. �� ���� �������� ��� ���� �� � ����. �� �������� ���� ����� ��� ��� ���������� ���� ���������� ��� ����� ���������� �������� �������� ���������.",
					);
				} elseif ($_GET['qaction'] == 5) {
					$mldiag = array(
						0 => "��� � ������. ��� ���� ����� �����.",
						6 => "�� ����� ������ �� ������. ����!",
					);
				} elseif ($_GET['qaction'] == 6) {
					mysql_query('START TRANSACTION') or QuestDie();				
					SetQuestStep($user,25,1);	
					PutQItem($user,3003088,"���������",0,QItemExistsID($user,3003087)) or QuestDie();
					PutQItem($user,3003088,"���������") or QuestDie();
					PutQItem($user,3003088,"���������") or QuestDie();
					PutQItem($user,3003088,"���������") or QuestDie();

					addchp ('<font color=red>��������!</font> ��������� ������� ��� <b>�����������</b> (x4) ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					mysql_query('COMMIT') or QuestDie();			
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "����������� ����, ������, �� ���� �������. ������� ����� ��� ������ �����?",
					1 => "����������� ��������� � ����, �� ����, ����� ����������� �������, �� �������, ��� �� �� �� ������������� �������� � ����. � ���� ��� �����-�� ��������� � ����������� �������.",
					11111 => "������ ����������, ��� ��������!",
				);
			}	
		}
		if ($step == 1) {
			$mlqfound = false;
			if ($ai[0] == 1 && $ai[1] == 1 && $ai[2] == 1 && $ai[3] == 1) {
				$mlqfound = true;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "� ��� ��� ������ ��� ��������. ��� ����������� ���������� � �� ���������.",
						3 => "��� � �������, �����, �������� �� ���� ����. ����!",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,25,2);
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "��, � ������ ���� ����� �����. � ��� ���� ������?",
					11111 => "��� ���, ����� �������!",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}
	}

	if ($sf == "mlvillage") {
		if ($step == 1 && $ai[0] == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003088,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && $mlqfound) {
					$mldiag = array(
						0 => "��, �� �������? ����� � ���� ����� ��� ����. ���� ������� ����� �������� ��������� ���� �� �� ����� ������ ��������. �����, ��� ������, �������� ����",
						2004 => "��� � ��������. ����!",
					);
				} elseif ($_GET['qaction'] == 2004 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 1;
					UpdateQuestInfo($user,25,implode("/",$ai)) or QuestDie();
					PutQItemTo($user,"������",$todel) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��� ���� ���� ������?",
					2001 => "��� ���������� ���� �� ������������ ������ ��� ��������!",
					11111 => "�� � ������ ��� ��������, ��� �����.",
				);
				if (!$mlqfound) unset($mldiag[2001]);
			}
		}

		if ($step == 1 && $ai[1] == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003088,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "�������������! ���� ���������� ����������, ��� ����� ���� �� ����� ���� � ������ ����, ������ ����� ��� ���-������ �����! ���� �������, ��� ��. ������ � ���� � ��������� �� ����������. ����� �� �� � ����������",
						3 => "�� �� ��� �� ��� �� ���� � �������� �� ���������. ����!",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[1] = 1;
					UpdateQuestInfo($user,25,implode("/",$ai)) or QuestDie();
					PutQItemTo($user,"����������",$todel) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
					1 => "� ���� ��� ���� ����������� �� ����. �� ����� �������� ������ ���� � ���� ������ ���� �� ������������ ������ ��� ��������!",
					11111 => "������� ������ ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	

		}
	}

	if ($sf == "mlwood") {
		if ($step == 1 && $ai[2] == 0) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003088,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "���� ��������? � ����? �� �� ��������� ��� ��� �������� ��� ��� ����� ��� �������� ��������� �� ����. ����� ��, ������ �� � ���. ����� ��� ������ ����������.",
						3 => "������ ��� � ����������! ����!",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[2] = 1;
					UpdateQuestInfo($user,25,implode("/",$ai)) or QuestDie();
					PutQItemTo($user,"�������",$todel) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ����� ��������� ����������. � �������� ��� � ������, ��� ��� ��� � ��� �����. ����� ��������� ��� ���� ������� ������?",
					1 => "�� ��������� ���� � ������. �� ������ �������� ���� ����������� �� ��� ���� ��������! ",
					11111 => "������ ������������� �����. ��� �����.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	

		}
	}

	if ($sf == "mlfort") {
		if ($step == 1 && $ai[3] == 0) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003088,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��, ��� �� ��� ���� ���� ��������? ����� ������, �� �� ������. ���� � ������ �������� ������ ������� ������������� � ��� ��� ������ ������������ ���������� �������� �������� ���� �� �����. �����, ������� �� ��� ������.",
						3 => "��������� �������! ��� � ��������. ����!",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[3] = 1;
					UpdateQuestInfo($user,25,implode("/",$ai)) or QuestDie();
					PutQItemTo($user,"��������",$todel) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������� ������, �� ������������. ��� ���������� �����, � �� �������. ��� ��� �������� � �� ����. �� ��� ����� ��� �����? �������, ������!",
					1 => "� � ���� �� ����. ��� ������ �������� ���� ����������� �� ��� ���� ��������. ",
					11111 => "������� ���-������ � ������ ���",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	

		}
	}

	if ($sf == "mlwitch") {
		if ($step >= 1 && $ai[4] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "���� �������� � ����� ���������?! � ���� �� ���������� �� ����������?! �� ������� ����, ��� �������. �� ������-�� �� ������� �� ���� ����������. �� �� �� �����, �� ������ ���, ������ �� �������.",
						3 => "���, ������� � ������� �����. ����!",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[4] = 1;
					UpdateQuestInfo($user,25,implode("/",$ai)) or QuestDie();

					// �������� �����
					PutQItem($user,105,"������",7,array(),255,"shop",3) or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b> �� ����� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����?",
					1 => "� �� ������ �� ����, �� � �� ������ ���. � ���� ���� �������� � � ����� �������� � ��� ������ ����������� ��� ���������� ���?",
					11111 => "��� �����, �������� �� ������������.",
				);
			}	

		}
	}

?>