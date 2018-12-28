<?php
	// ����� ��������� �����
	$q_status = array(
		0 => "������� ���������� �����",
		1 => "��������� ������������ ���������� �������", // step 0
		2 => "����� ����, ���� ���������� ������� �����", // step 2
		3 => "����� ����, ��� ����� �����", // step 3
		4 => "������ � ���������� ��� �������� ����", // step 4
		5 => "������� ������ ������ ���� � �����", // step 5
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 26) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlrouge" && $step == 0) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "�� ����� ��, ��� ������� ������ � ��, ��� ����� �������� �������, ����������! ���, � �������, ���� ��� ��� ����� ����������",
					3 => "�� �����, ������ ���������"
				);
			} elseif ($_GET['qaction'] == 3) {
				// ��� � �����������
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
				1 => "�� ������ ���� �������� ����� � ��� �������� ������������, ��� ��� ��� ��� �� ��������. ������� ����� ��-��������.",
				2 => "������ ������������ �� ����, ������ ����������",
			);
		}	
	}

	if ($sf == "mlrouge" && $step == 1) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "� ��� � ����� �� ���, �� �� �����-�� ����� � ������ �-��, �� ����� � ������ � ������� ������� �� �� �����, ������ � ��������, ���� ����� ��� ��� ��� � ����.",
					3 => "���� �� ������ � � �������. � ������� ����� �������������� ����� ��������� ��������.",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				SetQuestStep($user,26,2) or QuestDie();
				mysql_query('COMMIT') or QuestDie();					
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, ������, � ���� ������� �����, ��� ������� ����� � ������� �� ���������!",
				1 => "������ ��� �����, ������!",
			);
		}	
	}

	if ($sf == "mlbuyer" && $step == 2) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "������, ������-�� �� ����� ��� ��� ��������� �� ������� ������, ���, ����������� �� ������ ����� � ��������, ������ ������ � ����� �� ����� �� ��� ���� �������, ��� ����� � ���� ���-����� ��� ���.",
					2 => "� ��� �� ���, ���� �� � ����?!",
				);
			} elseif ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "������ ������ �������� �������������. � �� ��������� ����� ����� ��������, �������� ���, ��� ����������� � ��� ��� � �������� �������, ������ � ��� ��������, ��� ���� �� ������� �������-����������, ��� ��� ������� � ���������� ����� ����, �� � ��� ���� ����������� �� ����� ������",
					3 => "�������, � �����. �������. ����!",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();				
				SetQuestStep($user,26,3) or QuestDie();
				mysql_query('COMMIT') or QuestDie();			
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�������, �������. ����� � ����� ���������?",
				33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
				1 => "���������� ������ ������� ����� �� ����� � ����� � ����. ����� � ����� ���� �����",
				11111 => "� ���� ����������, ��� �����",
			);
		}
	} elseif ($sf == "mlbuyer") {
		$mldiag = array(
			0 => "�������, �������. ����� � ����� ���������?",
			33333 => "���� � ���� ���-��� ��� ���� ����������, � ����� � � ���� ��� ����. �� ������ ����������?",
			11111 => "������ ����������, ������ �������� ����. ����� ������.",
		);
	}

	if ($sf == "mlknight" && $step == 3) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, ������ ���� �� �������� � ��� ��������� �����. �� ������ �������, ��� ��� ���� ��������? � �� ���� �� ����!",
					2 => "�����, ��������� �� ��� ������, ��� ���� �����������, ������ �������� ����. ���� ������ �������� ������� ����� � ��������� ���������.",
				);
			} elseif ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "� �� � ���, �� �� ����. ���-���, �� ������ �� ���� ��� ���� � ���, ��� � ����� ����� ������ ��� ����, ��� �� ������� ��������, ��� ������� � ������ ����� �����. ���� �� �� ������ ����, ������� ����� � ��� ������������. ��������, ��� ����� �������, �� ��� ������ ��� ������ ��������� ���� � ������ � ��� �� �������!",
					3 => "� �������� �� ���� ����������. ��������, �� ������ ���-�� ���������. ",
				);
			} elseif ($_GET['qaction'] == 3) {
				$mldiag = array(
					0 => "������� � ���� ���-��, ��� ������� ������� ����� ������� ����, � � �� �������� � �����.",
					4 => "����� �������, �� ������� ��� ��� ����!",
				);
			} elseif ($_GET['qaction'] == 4) {
				mysql_query('START TRANSACTION') or QuestDie();				
				SetQuestStep($user,26,4) or QuestDie();
				mysql_query('COMMIT') or QuestDie();			
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, ������ ������. ������� ��������� � ������ � ��������� � ������, ��� ������� �� �����?",
				1 => "��, ��������, � ��������� ����� �� ������� ������ ������� � ���������������� ���������? ��� ����� ���� � ��������� ���������?",
				11111 => "������, ����� ���, ��������� � ������ ���.",
			);
		}
	}

	if ($sf == "mlknight" && $step == 5) {
		$mlqfound = false;
		$qi1 = QItemExistsCountID($user,3003090,1);

		if ($qi1 !== FALSE) {
			$mlqfound = true;
			$todel = $qi1;
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "�� ����� �������! ��� ������ ����������� ��� �������� � � ����� ���� �����.",
					2 => "���������",
				);
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				$mldiag = array(
					0 => "�������, ��� ����������! �� �����! ����� �������. ���, ����� ����� � ������� �� ���� ����������, ��� � ����������� ��� ����������. � ����, ����������, ����.",
					3 => "��� � ������. ����!",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				SetQuestStep($user,26,6) or QuestDie();

				PutQItem($user,3003089,"������",0,$todel) or QuestDie();

				$msg = "<font color=red>��������!</font> ������ ������� ��� <b>�����</b>";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
				1 => "���, �����, ��������� ����� �������� ������ ����� ��� ���� ����� � ������ ����� ���, ��� ������� ��������� ���� ������� �����.",
				11111 => "������, ����� ���, ��������� � ������ ���.",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}
	}


	if ($sf == "mlvillage") {
		if ($step == 4 && ((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001) {
					$mldiag = array(
						0 => "����������, ��� ���? ���������� ����, ��� �� ������ �����. ���, ������ ������ ������ ���� � ���������� �����, ����� ������� ����� ������ ���� ������ �����, � ����� ������ ���, ��� ���� ��������� ���� ������� �����.",
						2004 => "��������� ���, ���� ������������, ���� ��� ������� � � ������, ������ �� ������ ����� ���������� ����� � ����. ����!",
					);
				} elseif ($_GET['qaction'] == 2099) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} elseif ($_GET['qaction'] == 2004) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,26,5) or QuestDie();

					PutQItem($user,3003090,"���������") or QuestDie();

					$msg = "<font color=red>��������!</font> ��������� ������� ��� <b>������ ���� � �����</b>";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					2001 => "� ���������, ���, �� � ����� �����! ������ ��� ��������� � ����� ������, �� ������� �� � �� ����� �� ������������� ����������� �������� � � ���� �����-�� �������� � �� ����������� ������, ������ ����, ����������� ��� ����?",
					2099 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "� ���������, ���.",
				);
			}
		} elseif ($step == 6 && ((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003089,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && $mlqfound) {
					$mldiag = array(
						0 => "���� ����, ��� ���, ���� ����. �� ����� ����� ��� �� ������, �� ��� ��?...",
						2004 => "�������� �� �������",
					);
				} elseif ($_GET['qaction'] == 2099) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} elseif ($_GET['qaction'] == 2004 && $mlqfound) {
					// �������� �������
					mysql_query('START TRANSACTION') or QuestDie();
		
					$r = AddQuestRep($user,100) or QuestDie();
					$m = AddQuestM($user,2,"���������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
	
					PutQItem($user,4002,"���������",0,$todel,255,"eshop") or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>������� �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
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
					2001 => "��, ���, ����� �����. ������ �������� ����, ��� �� ��������� ���� ��� � ��� �����.",
					2099 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "��� ���, ��� ����� ������ �������.",
				);
				if (!$mlqfound) unset($mldiag[2001]);
			}
		} elseif ((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000)) {
			if (isset($_GET['qaction']) && $_GET['qaction'] == 2099) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			}
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
				2099 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				11111 => "� ���������, ���.",
			);
		}
	}
?>