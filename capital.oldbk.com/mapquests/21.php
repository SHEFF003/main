<?php
	// ����� ������������� �����
	$q_status = array(
		0 => "���������� � ������� � ������� �����.",
		1 => "�������� ��������� ������ (%N1%/1), ����� (%N2%/1), ����� (%N3%/1)",
		2 => "�������� ������� ���� (%N1%/2)",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 21) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");
	
	$ai = explode("/",$questexist['addinfo']);

	if ($sf == "mlboat") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003075);
		$qi2 = QItemExistsID($user,3003076);
		$qi3 = QItemExistsID($user,3003077);

		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2,$qi3);
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				$mldiag = array(
					0 => "�������� ����������, ������� ����� ������ ��� �������.",
					3 => "������ ��� ������. ������, ������������ ������ �� ���� ������ �������� � ������.",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,250) or QuestDie();
				$m = AddQuestM($user,2,"��������") or QuestDie();
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

				PutQItem($user,$item,"��������",0,$todel,255,"eshop") or QuestDie();
				PutQItem($user,105,"��������",7,array(),255,"shop",3) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ��������������� ".$txt."HP�</b> � <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ����� � ���, ��� � ������?",
				1 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����).",
				2 => "�����? � �� ������ �����, � ��� � ������ ��� ��� �����! ��� ���� �������, �� � ���������. ��� �����, ������ � ������",
				11111 => "��� ���, ��� ����� � �������!",
			);
			if (!$mlqfound) unset($mldiag[2]);
		}                                        	
	}

	if ($sf == "mlvillage") {
		if ($ai[0] == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001) {
					$mldiag = array(
						0 => "��-��� ����� ������������. ��� ������� ����� ���� ����������� ������, ����� � �����. �� � ��� ��������� ������, ����������. � �������� � �������� � ������, � ��������� ���� �������� ����� ���-�� ���. ",
						2003 => "��, ���� ���-�� �����, ����� ������, ��������� ��� ������.",
					);
				} elseif ($_GET['qaction'] == 2003) {
					$mldiag = array(
						0 => "��, ������, ������ �����. ������� ����� �� �������, � ���� ��� �������� ���. ������� ��� ���� ������ ����, � ����� ���� ������.",
						2004 => "�� ���������� ���� ���, ��� �� ����� ������, � ��� ������.",
					);
				} elseif ($_GET['qaction'] == 2004) {
					$mldiag = array(
						0 => "��� � ����������! �� �������.",
						2005 => "����.",
					);
				} elseif ($_GET['qaction'] == 2005) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 1;
					UpdateQuestInfo($user,21,implode("/",$ai)) or QuestDie();					
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��� ���� ���� ������?",
					2001 => "�����������! �������� ������ ���� ������� ���� � ������ � � ���� ��� ����� �������� ��� ����� ����",
					2002 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}

		if ($ai[0] == 1 && ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			$mlqfound = false;
			$todel = QItemExistsCountID($user,3003005,2);

			if ($todel !== FALSE) {
				$mlqfound = true;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && $mlqfound) {
					$mldiag = array(
						0 => "��, �� ��� ������, ������. �� ��� ������ � ����� ���� ������. ��� ������, �� ����� ������, ������ ��������",
						2003 => "����, ���.",
					);
				} elseif ($_GET['qaction'] == 2003 && $mlqfound) {
					$mldiag = array(
						0 => "���, �����. ��������� ������ ��������� � ���������� �����������. � ������� ��� ��� � ��� �������� ��� ������� ���� ���������� � ������.",
						2004 => "����������� �������, ����!",
					);
				} elseif ($_GET['qaction'] == 2004 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 2;
					UpdateQuestInfo($user,21,implode("/",$ai)) or QuestDie();					

					PutQItem($user,3003075,"������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();


					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��� ���� ���� ������?",
					2001 => "���� ������, ��� �� ������.",
					2002 => "����� �����",
				);
				if (!$mlqfound) unset($mldiag[2001]);
			}
		}
	}

	if ($sf == "mlwood" && $ai[0] > 0) {
		if ($ai[1] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "���� ��, ����� �������� ����! � �� �� ������� ���, � �� ��� ���� ��, ���� ��� � ��� �� ���. ��� ��� �� �������� � ��� � ���� �����. �� �� ������, �� ���, ��������  ��������� �����, ���� �� ��� �������, ������ � ���, ������ � ����� ���� �������� - ��� ���.",
						2 => "����� ����, ���� ������, ���������",
					);
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "��� ��������, �� �����?",
						3 => "�� �����, ������. ����� ���� �����.",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "��� � ������. ������ ����� � ����������� �� �������.",
						4 => "����.",
					);
				} elseif ($_GET['qaction'] == 4) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[1] = 1;
					UpdateQuestInfo($user,21,implode("/",$ai)) or QuestDie();					

					PutQItem($user,3003078,"�������") or QuestDie();

					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>�����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();					
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ����� ��������� ����������. � �������� ��� � ������, ��� ��� ��� � ��� �����. ����� ��������� ��� ���� ������� ������?",
					1 => "������ ������. �� ��������� ������ � ����������� �������� ������� ��� �����. ������ ������, ��� ��� ����� � ����� �� ��������� ���������.",
					11111 => "������ �� ������������, � ����� �����  ",
				);
			}                                        	
		}
		if ($ai[1] == 2) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��, ������ � ������ ������ � �������� ������ �������, ��� ����� ���� ���� ��� ����� ������, � ����� � ��� ������ ����, ���, ����� �� ��� ���� ���� �������. �����, �������, ��� ��� �����, ����� ���� �����.",
						2 => "�������, ����.",
					);
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[1] = 3;
					UpdateQuestInfo($user,21,implode("/",$ai)) or QuestDie();					

					PutQItem($user,3003076,"�������") or QuestDie();

					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>�����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();					
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "������. �������� ������ � ����� ���� ���� ��� ����� ������.",
					11111 => "���� ��� ���.",
				);
			}                                        	
		}
	}

	if ($sf == "mlfort" && $ai[1] == 1 && QItemExists($user,3003078)) {
		$todel = QItemExistsID($user,3003078);

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "������� ��������� ��, �������� ������ � ��� ����� �����. �����, ����� ���� ���� ����� ��������, ����� ��� ����� �����.",
					2 => "����.",
				);
			} elseif ($_GET['qaction'] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[1] = 2;
				UpdateQuestInfo($user,21,implode("/",$ai)) or QuestDie();					
				PutQItemTo($user,"�������",$todel) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();					
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������� ������, �� ������������. ��� ���������� �����, � �� �������. ��� ��� �������� � �� ����. �� ��� ����� ��� �����? �������, ������!",
				1 => "������� ���� ������. � ����. ����� ����� ��������, �������, ��������� ������.",
				11111 => "������ ����� ����������. ��� �����",
			);
		}                                        	
	}

	if ($sf == "mlpiligrim" && $ai[0] > 0 && $ai[2] == 0) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "�� ��� �������! ��� ����� ����� ���������? � ������ ����, ��� �����, ������ ����� ��� �����!",
					2 => "� ������ ������, � �������� ��������� ��� ����������� � �� ��� �� ��������� ��� ������... �� ������ ��� ����, �, � �������, ��������, ����� ������������ ���� ������, �������� � ���� �������� ������� �����? ��� �� ��� ����, ��� ��� ���� �������",
				);
			} elseif ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "�� �������, ������ �������! ���� ������� �����!",
					3 => "�������� �������, �� ��������� ���� ���� ���� �����! ����!",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[2] = 1;
				UpdateQuestInfo($user,21,implode("/",$ai)) or QuestDie();					

				PutQItem($user,3003077,"��������") or QuestDie();
				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>�����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']);

				mysql_query('COMMIT') or QuestDie();
				unsetQA();					
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �������, � �� ��� ���-�� ������. ����� ����� ������ �����. �����������, �� ������ �������� ��������� ��� ���� ������� ����?",
				1 => "�����������! � � ���� � ��������� ��������. ���� � ���, ��� �� ��������� �� �������� �� ����� ����� ����� � ��������� � ���� ����� ������ ����������� �������, ����� ��� �������� � �����, �� ���� ����������� �������������, ��������� �� ������!",
				11111 => "��, �������, ������ �������",
			);
		}                                        		
	}
?>