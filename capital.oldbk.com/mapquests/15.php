<?php
	// ����� ������ ����
	$q_status = array(
		0 => "������ � ��������� � ����������� �� ����.",
		1 => "������ � ������ � ����������� �� ����.",
		2 => "��������� � ������� ������� ���� � �������� ��� � ������.",
		3 => "������ ���� ��� ����� (%N1%/10) � �������� � � �������. �������� ���� � ������.",
		4 => "�������� ���� � ������.",
		5 => "����� ��� ������ ����� ���� (%N1%/1), 10 ����� � ������ �������� (%N2%/10) � ����� ���� (%N3%/1).",
		6 => "������� ����������� ���������.",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 15) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlpiligrim" && $step == 0) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "���, ��� ��� �������. ������ �������� �� ������ � �� �����. �� ���� �� ��� ������ ����� � ����� ���� � ����� ��� �������� ���� ����� ����������� � ����� �����. � ��� ��������, ��� �� ���������� � ��� ������. ����� ������� �������, �� ��� �� ���-�� ������� � ���� � ����� �����, ��� ��������, �� �� �������� ����. � ����� ����������� � �������, ��� � �� ����. ���� ��� ������, ��� ��� ���-�� �������. �����-�� �� � ������, ������� ��� �� �� �����.",
					3 => "�������, ��� � ������.",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				SetQuestStep($user,15,1) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �������, � �� ��� ���-�� ������. ����� ����� ������ �����. �����������, �� ������ �������� ��������� ��� ���� ������� ����?",
				1 => "���� �� ���� ���������. �������� �������, ��� ���� ������ ��� ����� � ��� ������, ��� ������. ����� �� ������ � �����, � ��� ���� ������?",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}	
	}

	if ($sf == "mlwitch" && $step == 1) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��� ��� ���, � � ��, �����, ��� �� ���� ��������� ��� �� ���� ����, � ��� ������ ���� �� ���� ����������. ���� ����� �����. ����� ����-�� �� ������� ��������, ��� ������ ����� ��� ������ ��������. ���, ��� ���� �����. ���� � ������� � ����� � ���� ����� ������� �����, ����� ������ �� ����� �������, � �� ���������. � � ���� � ������ ������ ������ ����������� �������. ������ �� �����, ���� ����� �������, ��� �� �������.",
					3 => "������������, � ����� �������.",
				); 
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				SetQuestStep($user,15,2) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����? ",
				1 => "���� � ��� � �����, ���� ������ ��� �����. ������, ��� ���������� ��� �� ��������. �����, �� ������� ������?",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}
	}

	if ($sf == "mlvillage" && $step == 2) {
		if ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001) {
					$mldiag = array(
						0 => "��������� ����, �� ���� ����� ���� ����������. �� ���� �� �����, � � ���� ������� �������. �� ������ 10 ������ ���� ����� �����.",
						2003 => "������������, � ����� �������.",
					);
				} elseif ($_GET['qaction'] == 2003) {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,15,3) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��� ���� ���� ������?",
					2001 => "������ ���� ����� ������. ���� ���� ��������, �� ������ ����� ������� �����������. ������ �� ��� ����� ����� ����� ������� �����, ������� �� ������ �������. �� ���� �������.",
					2002 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}		
		}		
	}

	if ($sf == "mlvillage" && $step == 3) {
		if ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000)) {
			$mlqfound = false;
			$todel = QItemExistsCountID($user,3003005,10);
			if ($todel !== FALSE) $mlqfound = true;

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && $mlqfound) {
					$mldiag = array(
						0 => "������ �� ���������, � � ���� ��� ��� ������. ������� ���, ����� ����� ����� �����.",
						2003 => "� �� �������, �� ����� �� ����. ���� ����� �������, ��� �� ������.",
					);
				} elseif ($_GET['qaction'] == 2004 && $mlqfound) {
					// ������� ����
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,15,4) or QuestDie();
					PutQItem($user,3003052,"������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ ������� ��� <b>������� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 2003 && $mlqfound) {
					$mldiag = array(
						0 => "�� ��� � ���, ����� ���� ����� � ���� � ������. ������� ���, �������, �������, �� �� �������. ���� ������ �� �������.",
						2004 => "������� �� ������, ��� ��������.",
					);
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ��� ���� ���� ������?",
				);
				if ($mlqfound) $mldiag[2001] = "��,  ��� 10 ������ ���� ��� �����.";
				$mldiag[2002] = "���, � ��� �� �����, ����� ������.";
			}		
		}		
	}

	if ($sf == "mlwitch" && $step == 4) {
		$mlqfound = false;
		$todel = QItemExistsID($user,3003052);
		if ($todel !== FALSE) $mlqfound = true;

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��� � ������, � � ����� ������ ������. ����� ���, ��� ����� � ���� ����. ��������  ����� ����� ����, 10 ����� � ������ �������� � ����� ����. ����������, ������� ��� ��, ���� �� �������, � ����������� ����� ������.",
					3 => "������, � ������� ���, ��� ���� �����.",
				); 
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				SetQuestStep($user,15,5) or QuestDie();
				PutQItemTo($user,"������",$todel) or QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � �������?",
				1 => "��,  ��� ����� ������� �����, ������� ���� ������� ������",
				2 => "���, � ��� �� �����, ����� ������.",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}                                        
	}

	if ($sf == "mlmage" && $step == 5 && !QItemExists($user,3003054)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��� ���� ��������, ��������? ��� � �����, ������ ���� ������ ����. ���� � ���� ����� ����. ������ ��� ���� �� ��� ��, �� ���� �� ���� ����� ����� ���, � ��� � �����, �� ���� �������. �� ��� ��� �� ������ ����� ��������. �� ������, ����� ������ � ����� ����� �� ���� �������� � �������� ������� �����?",
					3 => "��, �������� ��� ����� � ����.",
				); 
			} elseif ($_GET['qaction'] == 3) {
				$mldiag = array(
					0 => "��� � � ����� ������ ���� �����. ����� ����� ���� � ���� ������ � ������. ���� �������, ��� ��� ����� ������.",
					4 => "������� �� ������.",
				); 
			} elseif ($_GET['qaction'] == 4) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003054,"���") or QuestDie();

				addchp ('<font color=red>��������!</font> ��� ������� ��� <b>����� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�� ����� ���� ����� ���������.  ����� ������ � �� ������ ����? ������.",
				1 => "� � ���� �� ���� ����������. ���-�� ������� ����, � ������ ��� ����������� ����� ����� ����. �� �� ������, ��� �� ����� �����?",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}                                        	
	}

	if ($sf == "mlboat" && $step == 5 && !QItemExists($user,3003055)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "������ ����?! ������ � � �����, �� �����, ��� ��� ������ �������� �� ��� ��������. � ��� � ��� ��� ����� �������� ����� �������. ������ ���� � ���� ��� ������� ������� ��������, ������ ���� ����� ������ ����� �����  ����, � ���� � ������. � �� �������� � ���� �����.",
					4 => "�������, ����� �������.",
				); 
			} elseif ($_GET['qaction'] == 5) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} elseif ($_GET['qaction'] == 4) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003055,"��������") or QuestDie();

				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>����� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ����� � ���, ��� � ������?",
				5 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				1 => "��,  ����� ������ �� ���� ����. ���� ����� � ����� ������. ������ ������� ������� �����������. ��� ����� ����� ����� ����.",
				2 => "���, � ��� �� �����, ����� ������.",
			);
		}                                        	
	}

	if ($sf == "mlboat" && $step < 5) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ����� � ���, ��� � ������?",
				1 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����).",
				2 => "���, � ��� �� �����, ����� ������.",
			);
		}                                        	
	}

	if ($sf == "mlwitch" && $step == 5) {
		$mlqfound = false;
		$qi1 = QItemExistsCountID($user,3003053,10);
		$qi2 = QItemExistsID($user,3003054);
		$qi3 = QItemExistsID($user,3003055);
		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2,$qi3);
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "�������-��, � �� ������ �� ������� �� ����������. ����� ��� ����� ������, ������ ���� � ���. �������, ���� ���� ���� ������� ������ �����. ����� ��� ������, �� �� ������ �� ����������. ������ ����� �� ��� ������ �����. ������� ���������, ���� ������ ��� �� �������� ����. ���� �� �� ��������, �� ��� ���������.",
					3 => "������� �� �����, ��� � ������.",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003056,"������",0,$todel) or QuestDie();

				addchp ('<font color=red>��������!</font> ������ �������� ��� <b>�����������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				SetQuestStep($user,15,6) or QuestDie();

				mysql_query('COMMIT') or QuestDie();
				unsetQA();					
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � �������?",
				1 => "��,  ��� ����� ����, ����� ���� � ����� � ������ ��������.",
				2 => "���, � ��� �� �����, ����� ������.",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}                                        	
	}

	if ($sf == "mlboat" && $step == 6) {
		$todel = QItemExistsId($user,3003056);
		$mlqfound = false;
		if ($todel !== FALSE) $mlqfound = true;

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} elseif ($_GET['qaction'] == 4 && $mlqfound) {
				// �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,200) or QuestDie();
				$m = AddQuestM($user,1,"��������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItem($user,144144,"��������",0,$todel,255) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>��������� �����������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();

			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				$mldiag = array(
					0 => "�������, ��� �� ��������! ������� ���� �� ������! ������ �� ���� � �����,  � ���-�� ���, ���� ���� ����� �������!",
					4 => "������ ��� ������ (�������� �������)",
				);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
				1 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				3 => "��,  ��� ����� ������ ����� �����������. ������� ��� ���� �� �������� ����, � ���� �� �� ��������, �� ��� ���������.",
				2 => "���, � ��� �� �����, ����� ������.",
			);
			if (!$mlqfound) unset($mldiag[3]);
		}                                        	
	}
?>