<?php
	// ����� ����� ������ 
	$q_status = array(
		0 => "������ �������� ������� ������ ��� ����� (%N1%/1), ����� (%N2%/10) � �� (%N3%/1).",
		1 => "����� 10 ������ � ���� ������ ������ �������� (%N1%/10)",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 7) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlhunter") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003023);
		$qi2 = QItemExistsCountID($user,3003024,10);
		$qi3 = QItemExistsID($user,3003025);

		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2,$qi3);
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == "1" && $mlqfound) {
				// �� ������
				$mldiag = array(
					0 => "������� ������, ������ ���������. ������ � � ���� ������ ������. ������� ����� � �� �����! ����� ��������� �������!",
					7 => "��������� (�������� �������)",
				);
			} elseif ($_GET['qaction'] == "7" && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,250) or QuestDie();
				$m = AddQuestM($user,3,"�������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				if ($user['level'] == 6) {
					$item = 33029;
				} elseif ($user['level'] == 7) {
					$item = 33030;
				} else {
					$item = 33031;
				}


				PutQItem($user,$item,"�������",0,$todel,255) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>���� �����</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();


				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
				
				
			} elseif ($_GET['qaction'] == "2") {
				$todel = QItemExistsID($user,3003022);
				mysql_query('START TRANSACTION') or QuestDie();
				if ($todel !== FALSE) {
					PutQItemTo($user,"�������",$todel) or QuestDie();
				}

				UnsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				UnsetQA();			
			} elseif ($_GET['qaction'] == "4" && !QItemExists($user,3003022)) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003022,"�������",0,array()) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				addchp ('<font color=red>��������!</font> ������� ������� ��� <b>��������� ������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				UnsetQA();
			} else {
				UnsetQA();
			}
		} else {
			$mldiag = array(
				"0" => "������, �� ������ ��� ��, ��� � ������?",
			);		
			
			if ($mlqfound) $mldiag[1] = "��, ��� ���� ������, ������� ����� � �� ��� �����.";
			$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)"; 
			$mldiag[3] = "���, � ��� �� ��� ������. ����� ������."; 
			if (!QItemExists($user,3003022)) $mldiag[4] = "���, � ��� �� ��� ������, �� ������������. �� ��� ���� ������ �������. �� ���� �� ������� ������������?"; 
		}
	}
	if ($sf == "mlwood") {
		if (QItemExists($user,3003023)) {
			return;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && !$questexist['addinfo']) {
				$mldiag = array(
					0 => "��, �������� ������ ������ ������ ����. ������� ����� � � ���������. ���� � ���� �����, �� ������������ � ���� �� �������. ������ ������ ���� ��� �����. � �� ����, ������ ������� ������ �����. ������ � ���� ���, �� ������� ������ � ���. ������ ���� ������ ��������� ����� ������ ��� ���������. ������� �� ����� �����. ���� �������, �����, ������ 10 ��� ������. ���� �� � �����������, � � � ����� �� ��������.",
					5 => "������������, ����� ��� �� ������.",
				);
			} elseif ($_GET['qaction'] == 3 && $questexist['addinfo'] == 11) {
				$mldiag = array(
					0 => "��� �������, � �� ������, ����� �� ���� �� ����� ���. ����� ���� ������, � ������ �������� �� ���� �������. �����, ����� ������� � �����.",
					6 => "����������� �������. ���������.",
				);
			} elseif ($_GET['qaction'] == 6 && $questexist['addinfo'] == 11) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003023,"�������",0,array()) or QuestDie();
				addchp ('<font color=red>��������!</font> ������� ������� ��� <b>������ ��� �����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				UpdateQuestInfo($user,7,0) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 5) {
				mysql_query('START TRANSACTION') or QuestDie();
				UpdateQuestInfo($user,7,1) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			if ($questexist['addinfo']) {
				$mldiag = array(0 => "������, �� ������ ��, ��� � ������?");
				if ($questexist['addinfo'] == 11) {
					// ����� ����
					$mldiag[3] = "��, ������ � ����� ���� ������ �� ��������, ������ ����� ��������.";
				}
				$mldiag[4] = "���, � ��� �� ��� ������. ����� ������.";
			} else {
				$mldiag = array(
					0 => "��, ����� ��������� ����������. � �������� ��� � ������, ��� ��� ��� � ��� �����. ����� ��������� ��� ���� ������� ������?",
					1 => "������� ������ ������ ��� ����� �����. �� �� ��������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlwitch") {
		if (QItemExists($user,3003025)) {
			return;
		}

		$mlqfound = false;
		$todel = QItemExistsID($user,3003022);
		if ($todel !== FALSE) $mlqfound = true;

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(0 => "�� �� ���� ������� ��� ��� ���, �� �������, � ��� ��� �� ��� �����������? ���� ������� �� ����� ���� ������ ��� ��� ����. ��� ���, ��� ��� �� ���. ������ �������� ����-�� �� ������ �� �������, ������� ���� �� ���� ��������. � ��� � ��������� �� ����������!");
				if ($mlqfound) $mldiag[3] = "�� �������, ��� � ��� ������! �� �� ������ �������� ������� ���� � �������������!";
				$mldiag[4] = "��, ��� ���, �� ������ ������.  ����� ������.";
			} elseif ($_GET['qaction'] == 6 && $mlqfound) {
				// �������� ��
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003025,"������",0,$todel) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				addchp ('<font color=red>��������!</font> ������ �������� ��� <b>��</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				$mldiag = array(
					0 => "���� ��, ������ ���-�� �� ���� �� ������. �� ���� �� �� ��� ������ ��������? �� �� �����, ������ ����� ���� �� ���� �������������� � ���� ����. ����� �� � ������ � �����.",
					6 => "������� (������� ��)",
				);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����?",
				1 => "������ ��������� ��� ��� ���������� �����.",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}
	}
?>