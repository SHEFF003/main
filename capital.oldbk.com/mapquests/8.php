<?php
	// ����� ������������ �������
	$q_status = array(
		0 => "����� ������������� ������.",
		1 => "������ � �������� ��� ������.",
		2 => "������ � �������� ��� ������.",
		3 => "������ � �������� ��� ������.",
		4 => "������ � ����������� ��� ������.",
		5 => "������ ������ � �������.",
		6 => "������� ������.",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 8) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlfort") {
		if ($step == 6) {
			$mlqfound = false;
			$todel = QItemExistsID($user,3003027);
			if ($todel !== FALSE) $mlqfound = true;
	
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					if (!$questexist['addinfo']) {
						$mldiag = array(
							0 => "����� ����, �� ���! ����� ���� �� �������, �������� ����� ������ � ����� ����������� ���� � ����� ������. � ���� ��, �� ��� ������ � ������� �����, � ��������� ���� � ��� ������ �� ����� �������. ������ ������ �� ��� � �������? ��� ���������� ������ ����� ��������� ����� ������� � ������ ���, ������ � ����� ���� �������. �� �� ������ ������� ����, �� � ����� ������������ ������. �� ��� ��� ���� ������� �������.",
							4 => "������� (�������� �������)",
						);
					} else {
						$mldiag = array(
							0 => "����� ����, �� ���! ����� ���� �� �������, �������� ����� ������ � ����� ����������� ���� � ����� ������. � ���� ��, �� ��� ������ � ������� �����, � ��������� ���� � ��� ������ �� ����� �������. �� ��� ����� ������� ��� ������. ��� ���������� ������ ����� ��������� ����� ������� � ������ ���, ������ � ����� ���� �������. ���� ��� �������� � �������, ��� ������ � ����� ���� � ����� ���� ����. �� ������ ������ ������.  ������� ������ � ��� ������. ����� ��������� �������",
							4 => "������� (�������� �������)",
							5 => "�������, � �����������, ��� ����� ���� ������, � ������� ��� ����."
						);
					}
				} elseif ($_GET['qaction'] == 5 && $mlqfound && $questexist['addinfo']) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItemTo($user,"��������",$todel) or QuestDie();
					SetQuestStep($user,8,7) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					// �������� �������
					mysql_query('START TRANSACTION') or QuestDie();

					if (!$questexist['addinfo']) {
						$r = AddQuestRep($user,200) or QuestDie();
						$m = AddQuestM($user,1,"��������") or QuestDie();
						$e = AddQuestExp($user) or QuestDie();
			
						PutQItem($user,105,"��������",7,$todel,255) or QuestDie();
	
						$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
						addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					} else {
						$r = AddQuestRep($user,100) or QuestDie();
						$m = AddQuestM($user,1,"��������") or QuestDie();
						$e = AddQuestExp($user) or QuestDie();
			
						PutQItem($user,105,"��������",7,$todel,255,"shop",3) or QuestDie();
	
						$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
						addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					}
	
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 2) {
					unsetQA();
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();	
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��  ������ ��, ��� � ������?",
				);
				if ($mlqfound) $mldiag[1] = "��, ��� �������. �� ��� � �������.";
				$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
				$mldiag[3] = "��� ���. ����� ������.";
			}
		} elseif ($step == 7) {
			$mlqfound = false;
			$todel = QItemExistsID($user,3003028);
			if ($todel !== FALSE) $mlqfound = true;

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "����� ����! ������ � ������� �� ���� ������ � �� �������! ������ ������� ��������� ������, ��� ������ �������! �� ���� ����� ������ �������! �� ��� ��� ���� ������� �������.",
						4 => "�������.",
					);
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "��, ������ �� ���������, ����� ������� �� ������� ������ ���, ���� ������ �� ����� � ������ ����. ������� �� ���-���� ���� � ������ ����������� �������.",
						5 => "�������.",
					);				
				} elseif ($_GET['qaction'] == 5 && !$mlqfound) {
					// �������� ������� ��� �������
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,100) or QuestDie();
					$m = AddQuestM($user,1,"��������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
			
					PutQItem($user,105,"��������",7,array(),255,"shop",3) or QuestDie();
	
					$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					// �������� ������� �� ������
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,150) or QuestDie();
					$m = AddQuestM($user,2,"��������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
			
					PutQItem($user,105,"��������",7,$todel,255,"shop",3) or QuestDie();
	
					$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(0 => "������, ��  ������ ��, ��� ������?");
				if ($mlqfound) {
					$mldiag[1] = "��, ��� ������, ������� �� �����.";
				} else {
					$mldiag[2] = "���, � �� ���� ����� ������.";
				}
				$mldiag[3] = "���, � �� ���� ����� ������. ����� ����� ������.";
			}
		} else {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2) {
					unsetQA();
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��  ������ ��, ��� � ������?",
				);
				$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����).";
				$mldiag[3] = "��� ���. ����� ������.";
			}
		}
	}

	if ($sf == "mlvillage") {
		if ($step == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��, ���������� � ��� ����� ����� ���, �������� ���� �� ������� �� �������. �����, ���� ��� ����� ���� ������� � ���� ��������, �� ������� ������������. ����� ��������, ��� ������ ���� ����� �������. ������,  �������, ��� ����-���� � ����� � ���� ���������.  �����-�� �� � ��������, ����� �� ��� ������.",
						3 => "������� �������! ��� � ������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,8,1) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
					1 => "�������� ������ ���� �� ������ �������, �������, ��� ��� ��� ����� �� �����, �� ������ �� ������ ��� ���?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlhunter") {
		if ($step == 1) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�������, ��������?  � ������� ������ �� ���� ��������. ������ �� ������. �� �����, �� �����. � ����� � ������� ������ ����, � ������������ ���� �������, ��� ��� ��� ������. ���� ����� ���� ������������ ���� ����� ���������, � ���� ����� ����� ������, �� � �� ������ ����� ����� ���� ���������� ��� �������. �������� � �������� ��������, ����� �� ������� ����.",
						3 => "�������, ��� � ��������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,8,2) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
					1 => "������, �� �� ������ ���� ��� ������������� �������? ",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlwood") {
		if ($step == 2) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "������, ����� � ������� �����, ����� ������ ��������� �� ����� ����. ���� �� �������  ��� ���, �� ��  ��������� ������ �� �� ����.  � � ������ �� �����  �������� ���������� � �����������,  ���� �� �������. ����� ��� ��� ���������. ��� ������ � ����� �����.",
						3 => "�������� ����������� � �����������, ��� ��������� �������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,8,3) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ����� ��������� ����������. � �������� ��� � ������, ��� ��� ��� � ��� �����. ����� ��������� ��� ���� ������� ������?",
					1 => "������, ��� ������� ������, �� ����� ������ �� �����. ����� �� ������� ����?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlrouge") {
		if ($step == 3) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "���� ����� ����, ������� �� ������� ���� ����� ���������� ������, �� ������� � ���� �� ��������. ����� � ������� ����� � �� �����. �� ��������� ����� ������ ������ ����, ����������� ��������, �� ���� ������, ��� ������ ���� ��������. � ����� ��� � � �������� �������. ���� �������� ��, ������, �������, ���� �����������, �� ���������  - ������ ����.",
						3 => "������ ���, ������� ���� �������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,8,4) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��-��, ��������, ����� � ��� �������� ����� ����������! �� ����� ���� �� �������?",
					1 => "� �� ����. ��� ����� ������ ���� ���� �����, ��� � ��� �������, ����� ������ �� ����� � �� ������. ����� �� �������� ���� �� ������� ��� ��� ���?",
					2 => "������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlmage") {
		if ($step == 4 && !QItemExists($user,3003026)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��������� ��� ��� �� ������� �����, ���� ������� �����������. ������ ��, �� ������ �������, �� ������ ������, �� ����� �� �������. �� � �������� ������� ��������... �����-����� ���������... ����� ������� ���, � ���� ��� ����� ���, ����� ������� �������, � ��, ������ ��� ������� ������� ���������, ��������� �� ���. �� ����� ��������� �� ��� ���� ����������.",
						3 => "������������, ������ ����� � ���� � ��������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003026,"���",0,array()) or QuestDie();
					mysql_query('COMMIT') or QuestDie();

					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>����� ���</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					unsetQA();				
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�� ����� ���� ����� ���������.  ����� ������ � �� ������ ����?  ������.",
					1 => "������, �� ��������� �����. ��� ������� ���������, �������� �� ���� ������� ������. ���������, ���  ������� ����� ������ � ������ ������. ����� ��� �� ��������, � ������� ������� ����. ����� ������, ��� ������?",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
		if ($step == 5) {
			if (isset($_GET['qaction'])) {
				unsetQA();
				return;
			}
			$mldiag = array(
				0 => "������, �� ������ �������?",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				1 => "��� ���. ����� ������.",
			);
		}

		if ($step == 6) {
			if ($questexist['addinfo']) {
				return;
			}

			$mlqfound = false;
			$info = QItemExistsID($user,3003027);
			if ($info !== FALSE) $mlqfound = true;
	
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "����������� ���������. �� ������� ����������� ������, ��� ����� � ���� �� ���. ������, ��� ������ ������ �����, �� �� ��, ��� � ���� ����� ������ ������, � ������ ������ ���� ������. � ������� ����� ���������, �� � ������� �������� � ���� ������.",
						3 => "��� , � �� ������������ ����� ������. ������ ��� �� ������� � � ��� �� � ��������� � ��������.",
						4 => "������������, ���� ������. ���� �������, ��� ������� ���.",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "��, ���-�, ���� ����, �� ������, ��� �� ����� �� ��������!",
						5 => "� ���������, ���� ������.",
						6 => "�����, � �������, �� ����� ������� �����.",
					);
				} elseif (($_GET['qaction'] == 4 || $_GET['qaction'] == 5) && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					mysql_query('UPDATE oldbk.`inventory` SET `img` = "baby3.gif" WHERE id = '.$info[0]) or QuestDie();
					PutQItem($user,667667,"���") or QuestDie();

					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>����� ������� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					UpdateQuestInfo($user,8,"1") or QuestDie();
                                        mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ �������?",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					2 => "��� ���. ����� ������.",
				);
				if ($mlqfound) $mldiag[1] = "��, ��� �������, �������� ������ �����";
				ksort($mldiag);
			}
		}
		if ($step == 7) {
			if (QItemExists($user,3003028) !== FALSE || $questexist['addinfo'] == 3) {
				return;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�� ��� ����� ��� ������, � ����� �� �������, � ������ ������ �����? ��, �� �����, ��� ��������! ���������� �� ����� ����, � �� ��, � ������� ���� ������ �����!",
						3 => "���, ��� ������� � �� ����! ������ ����� � ���������, ��� ����!",
						4 => "��, ��� ���, �� ������ ������. ����� ������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					if ($questexist['addinfo'] > 1) {
						// ��� c ����� - ������� )
						mysql_query('START TRANSACTION') or QuestDie();
						StartQuestBattle($user,538, array(
							"hp" => 9000, 
							"maxhp" => 9000,
							"sila" => 9000,
							"lovk" => 9000,
							"inta" => 9000,
							"min_u" => 900,
							"max_u" => 1000,
							"vinos" => 9000,
							"level" => $user['level'],
							),1,'��������! ��������! ���� ��� �� ��� ��������� ���� �����! ������ �� �� �����, ��� �������� ���� ���� �� ������� �������?!�') or QuestDie();
						mysql_query('COMMIT') or QuestDie();

						unsetQA();
						Redirect('fbattle.php');
					} else {
						// ��� � ������� �����
						mysql_query('START TRANSACTION') or QuestDie();
						StartQuestBattle($user,538) or QuestDie();
						UpdateQuestInfo($user,8,"2") or QuestDie();
						mysql_query('COMMIT') or QuestDie();
						unsetQA();
						Redirect('fbattle.php');
					}
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "����� ���������? ��� �� ���� ��� �����?",
					1 => "� ���� ������� ������, ������� ����� ������� ��������. �� ������� �������, ����� �� �������������� �� ���� ������.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

?>