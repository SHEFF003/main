<?php
	// ����� ������� ������
	$q_status = array(
		0 => "������ ���� ������� ������ ������� (%N1%/1), ������ ���� (%N2%/1), ������ ������� ���� (%N3%/1), ������� ������ ��������� (%N4%/1) � ��������� ���� (%N5%/1).",
		1 => "������� � ���������� � ���������� ��� ����",
		2 => "������� � ������ � ���������� ��� �������",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 17) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlmage") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003062);
		$qi2 = QItemExistsID($user,3003063);
		$qi3 = QItemExistsID($user,3003064);
		$qi4 = QItemExistsID($user,3003065);
		$qi5 = QItemExistsID($user,3003066);
		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE && $qi4 !== FALSE && $qi5 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2,$qi3,$qi4,$qi5);
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��� � ������. ����� ��� ���� � ������ ���� � ��������. � � ���� ���� ������� � ����� ���, �� ������� ��� ������.",
					3 => "�������, ��� ��������.",
					4 => "�������, � ���� � ���� ��� ��������� �� ���������!",
				);
			} elseif ($_GET['qaction'] == 4 && $mlqfound) {
				$mldiag = array(
					0 => "���������? �� ���-�, ������, �� ����, ���� �� ��� �������� ��� �����, ���� ��� ������ ���������. ������ ������ ������ �� ��� ������!",
					5 => "�� ������ �������� ���� ������ � �������, ��� ���� ���������� ���, ��� ��� ����� ���������� � ����� ������ ���� �� 1 ������, ��� ������.",
					3 => "�� ���� �������� ���� �����, � ����� �����",
				);
			} elseif ($_GET['qaction'] == 5 && $mlqfound) {
				$mldiag = array(
					0 => "��.. �� 1 ������? � �� ������ �� �������? �� ������ ��� �������� �����. ����� ������� �� ������ � ��� ������� �� ��������������. �� �� 1 ������ �����, ��� ���, ��� �������!",
					6 => "�������, ��� ��������",
				);
			} elseif ($_GET['qaction'] == 66) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				
			} elseif ($_GET['qaction'] == 6 && $mlqfound) {
				// ������� ������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,200) or QuestDie();
				$m = AddQuestM($user,1,"���") or QuestDie();
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

				PutQItem($user,$item,"���",0,$todel,255,"eshop") or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ��������������� ".$txt."HP�</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				// ������� ������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,100) or QuestDie();
				$m = AddQuestM($user,1,"���") or QuestDie();
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

				PutQItem($user,$item,"���",0,$todel,255,"eshop") or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ��������������� ".$txt."HP�</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
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
				1 => "��, ��� ���� ��� ������, ������� ������ ��������� � ������ ��������� �����.",
				66 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				2 => "���, � ��� �� ��� �����. ����� ������.",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}
	}

	if ($sf == "mlwitch") {
		if (!$questexist['addinfo']) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�� ��, ������� � ����, ��� �� ����� �� ���������� ��������. ������ ���.. ������ ������ ���� ��� ������ ������ ������? ����� �� ������ ������ ��� ������. ������� � �� ���� ����, �� ������ �� ������. �����-�� �� � ����������, �� �������� ���, ��� ������. �� ����� �����, ��� ������. �, ��� ���������, �������� ���� �������.",
						3 => "������, � ������ ��, ��� �� �������.",
						2 => "���, ��� ������� ������ ��� ����.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();				
					UpdateQuestInfo($user,17,"1") or QuestDie();	
					mysql_query('COMMIT') or QuestDie();			
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����?",
					1 => "� � ���� � �������� �� ����. �� ���������� �������� ��������� ���������� ����� � ������ � ���� ������� ������ ���������.",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}			
		} elseif ($questexist['addinfo'] == 1) {
			$mldiag = array(
				0 => "������, �� ������ ��, ��� � �������?",
				11111 => "���, � ��� �� ��� ������. ����� ������.",
			);
		} elseif ($questexist['addinfo'] == 2) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��� ������ ��� ���������. �� ��������� � ����, ��, ��� �� �������. ������ ������ �������� ����� ��� �������, ��� ����� �� ��� ���� ��� �������.",
						2 => "�������, ��� ��������",
					);
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003065,"������") or QuestDie();;
	
					addchp ('<font color=red>��������!</font> ������ �������� ��� <b>������� ������ ���������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					UpdateQuestInfo($user,17,"3") or QuestDie();	
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � �������?",
					1 => "��, � ����������� ���������� � �� ����� �������� ������ �� �������.",
					11111 => "���, � ��� �� ��� ������. ����� ������.",
				);
			}		
		}
	}

	if ($sf == "mlvillage" && $questexist['addinfo'] == 1) {
		if (((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 1000 && $_GET['qaction'] < 2000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1001) {
					$mldiag = array(
						0 => "��, ��, �������! ����� � � ��������, ����������, ��� ����������� �������, �� ��� ����� � ���� �� �����������. � ������, ���� � ��������, �� ��� �� �������� � ��� ����� ������������, ��� �����. ������� ���� �� ��������. ����� ���� � �������� � �������� ������ �� ������� �������. ���� �, ��� ���� ������ �� ����� ���������� ����������������. ������ � �����, � ���� �������� ���� �������, �� ���� ���� ������ � ��� ��� �������.",
						1003 => "������, ��� ��������.",
					);
				} elseif ($_GET['qaction'] == 1003) {
					mysql_query('START TRANSACTION') or QuestDie();				
					UpdateQuestInfo($user,17,"2") or QuestDie();				
					mysql_query('COMMIT') or QuestDie();			
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "����������� ����, ������, � ����� �������� �������. ������ �� �� ������� ������� � ��������� � ��������� ������ ��� ���������� �� ���� � ����� ������ ���������?",
					1001 => "������ ����, � ������ � ���� � ��������� � ���, ��� ��� ������� ���������� �������� �����-�� ������� ����� � ������������� ��������. ������ �������, ��� �� ������ ����� ��� ������.",
					1002 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlpiligrim" && !QItemExists($user,3003066)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "������ �����? ������-������, � ������ �� ���� �������� �� ������? �� ������ �� ��������� ��� ������ ������ ��� ��� � � ����, ��� �� �� ��������� ���� ����. �� ���-� �������� � ����� � ���� ������. ��� � ���� ������ �����, �� � �� ������ ��� ���� ���-���. ������ �� �������, ������� ��� �� ���� ������ � ����� ��� ���� ���������� ��� � ���, ��� ��� ����� ���������� � ����� ������ ���� �� 1 ������, ��� ������.",
					2 => "������, � ������, ��� �� ������.",
				);
			} elseif ($_GET['qaction'] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003066,"��������") or QuestDie();;
	
				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>��������� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();			
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �������, � �� ��� ���-�� ������. ����� ����� ������ �����. �����������, �� ������ �������� ��������� ��� ���� ������� ����?",
				1 => "� � ���� � �������� �� ����. ������ ������ ��������� ����� ��� ������-�� ������.",
				3 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}		
	}
?>