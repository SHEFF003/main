<?php
	// ����� �������� �������
	$q_status = array(
		0 => "��������� ������� ��������� � ������ ������.",
		1 => "�������� ������ 10 ������� ������� ���� (%N1%/10), 5 ������ ������� ����� (%N2%/5), 5 �������� ������� (%N3%/5), 10 ���� ��������� ����������� (%N4%/10) � ����� �������� ���� (%N5%/1).",
		2 => "������� ������ � ���� ��� � ���������.",
		3 => "������� ������ ���������.",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 16) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlpiligrim") {
		$mlqfound = false;
		$todel = QItemExistsID($user,3003057);
		if ($todel !== FALSE) {
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} elseif ($_GET['qaction'] == 4 && ($step == 2 || $step == 3) && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,250) or QuestDie();
				$m = AddQuestM($user,2,"��������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItem($user,144144,"��������",0,$todel,255) or QuestDie();
				PutQItem($user,105,"��������") or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>��������� �����������</b> � <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();
			} elseif ($_GET['qaction'] == 3 && ($step == 2 || $step == 3) && $mlqfound) {
				$mldiag = array(
					0 => "��� ��� ������ ����! ����� � � ����! ����� ����������� �������!",
					4 => "�������, ��� ��������",
				);
			} elseif ($_GET['qaction'] == 2 && ($step == 2 || $step == 3) && $mlqfound) {
				$mldiag = array(
					0 => "�������! � ��� � ������, ������ ��� ���� �� ��������?",
					3 => "��� �� �� ��������?!. ��� ������ ��� ����, ������� ��������.",
				);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��, ��� � ������?",
				1 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				2 => "��, � ����� ������ � ��� ������, ��� ��� �������.",
				11111 => "���, � ������ �������� ����.",
			);
			if (($step != 2 && $step != 3) || !$mlqfound) unset($mldiag[2]);
		}
	}

	if ($sf == "mlwitch") {
		if ($step == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��� ��� ������� �������! ����� ����� ����� ��������! �� ��� �, ����� ����������� �� ����, ��� �� �� ������ ��� ������. ��� ����� 10 ������� ������� �����, 5 ������ ������� �����, 5 �������� �������, 10 ������� ��������� ����������� �  ����� �������� ����. ������ �� ������� � ����, � ������� ����� ��������� ����� ����� ������ ����� ����� ������.",
						3 => "������, � ������� ��, ��� �� �������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,16,1) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����? ",
					1 => "�������� ������ ��������, ��� ����������� ���������, ����� ������� ����� ��� ������������ ��������, � ������ ���� ������, ���� �����.",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
		if ($step == 1) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003058,10);
			$qi2 = QItemExistsCountID($user,3003038,5);
			$qi3 = QItemExistsCountID($user,3003002,5);
			$qi4 = QItemExistsCountID($user,3003059,10);
			$qi5 = QItemExistsID($user,3003061);
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE && $qi4 !== FALSE && $qi5 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3,$qi4,$qi5);
			}


			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��� � ������. ������ � ���� ���������� � ������������. ������ �������� ���������, ��� �� ������� �� ��� �������� ���������. ��, ������ ���� �� ��������, �������� ���������.",
						3 => "�������, ��� ��������.",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003057,"������",0,$todel) or QuestDie();;
	
					addchp ('<font color=red>��������!</font> ������ �������� ��� <b>������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					SetQuestStep($user,16,2) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � �������?",
					1 => "��, ���  ������ ������� �����, ����� ������, �������� ������, �������� ���������� � �����.",
					2 => "���, � ��� �� ��� �����. ����� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}
		}
	}

	if ($sf == "mlmage" && $step == 1 && !QItemExists($user,3003061)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "������� �����. � ��� ��������, ����� ���, �������, ��� �������. ��� ���� �����, �� � ��������. ��������� ��� ���� �� �������� �� ������. � ���� �� ��������� � ����� �� ���� � ������� ����� ������������ ���� ��� �����.",
					3 => "������, � ������� ���� ������.",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003061,"���") or QuestDie();;

				addchp ('<font color=red>��������!</font> ��� ������� ��� <b>����� �������� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();

			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�� ����� ���� ����� ���������.  ����� ������ � �� ������ ����?  ������.",
				1 => "� ������ � ���� � �������� �� �������� ������. ������ ����� �������� ���� ��� �������� ��������. ������ ������������� ����� �� ������ ���������.",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}	
	}

	if ($sf == "mlmage" && $step == 2) {
		$mlqfound = false;
		$todel = QItemExistsID($user,3003057);
		if ($todel !== FALSE) {
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "�������, ������� �����. ������, �� ���� ����� ����������, ���� ������ ������� ������ ������� �� ������. �� ��� �, ����� �� ��������� ������� � ��������� ������� �� ���� � ���� � ���� ���� ���� ������, �� �� ����� ������� �� ���� ���! ���� ���, ������ ����! ����� �����-�� ������ � �������� ���� �� ��������� �� ������ ����.",
					3 => "�������, ��� ��������",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,667667,"���") or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>����� ������� ����</b> �� ����� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				SetQuestStep($user,16,3) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA(); 
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
				1 => "��, ��� ������, ������� �� ������.",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				2 => "���, � ��� �� ��� �����. ����� ������.",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}	
	}
?>