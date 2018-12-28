<?php
	// ����� ����������� �����
	$q_status = array(
		0 => "����� ����� �������� ������ � �������",
		1 => "����� �������� ����� (%N1%/3), ����� ������� ���� (%N2%/1), �������� (%N3%/1) ��� ������",
		2 => "������� ����������� ����� ��������� ������",
		3 => "��������� � ������",
		4 => "������, ��� �� ������� ��������� � ������",
		5 => "�������� ���������� � �������",
		6 => "����� ������ ���������� ��������� �����",
		7 => "��������� � ������",
		8 => "�������� ���� ������ �������������",
		9 => "������� ����������� ��� ���� (%N1%/10)",
		10=> "����������� ����������",
		11=> "��������� � ������",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 29) return;

	$step = $questexist['step'];
                                            
	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	$ai = explode("/",$questexist['addinfo']);

	// ��������� � ������ - 3
	// ������������ ������ � ������ ���� - 4
	// ����� ����� ������� - 5
	// ����� ����� ����� - 6
	// ����� ����� ������� � ������ ���������� - 7
	// ���� ����� - 8,10,11
	// ���� ����� - 9

	if ($sf == "mlwitch") {
		if ($step == 0) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003205,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��, �������, �������. ���, �� ��� ��, ���������. ����� ������, ����� ����, ����� �������� ���������, ����� ��� �������� �����, ����� ��� ������ ����� ��� ���! ����� �����������. �����������, ���, ��� ����, ��� ���� ����. � ��� ��� ���������",
						3 => "������������ �� �������?",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "��, ��� �� ��� ���������! ��� ��� ������� � ����� �������! ���, ����� ������ ����, ��� ��� �����, �����, � ���� �� ��������� ������ ������� � ��������� �������� � �������� ������� �����. � ��� �������� �������� ��������.",
						4 => "�������? �����, � ���� �� �����������, ��� ���.",
					);
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					$mldiag = array(
						0 => "�������� � ��� ����� ��������.  �� ������ ��� �������. �������� �� ������� ����� ���� � ����� ����� � � ������ �������. �����!",
						5 => "����� ��� �� �����������. ����!",
					);
				} elseif ($_GET['qaction'] == 5 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					// �������� �����
					$it = QItemExistsID($user,3003205);
					PutQItemTo($user,'������',$it) or QuestDie();

					SetQuestStep($user,29,1) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � �������?",
					1 => "��, ���, ����� ���� ������.",
					99 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "���, � ��� �� ��� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	

		} elseif ($step == 1) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003206);
			$qi2 = QItemExistsID($user,3003059);
			$qi3 = QItemExistsCountID($user,3003002,3);
	
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "����������. � � ���� �� �����������, ��� ��� ������ ������������� � ���� ����������, ������ �������� �������� ������ ��, ��� �������� �� � �������� ���������� ����������<br>�������� � ��������<br>���������� ������<br>��� � ����� ������<br>���� ������ �����<br>������� ��������, <br>� �������� ����<br>������ ��� �������,<br>�� ��� ���� �������!<br>",
						3 => "��� �� ��� � ����� ������?",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "��� ���������� � ����� �� ���� ��� ��� �� ��������... ��, ����� ������. �������� ������ ������� ��� ��������� ������. � ���� �� ����, ���� ��� ��������� �� ����? �� �� ������ ������ �������� �����, ��� �� ������ �������������� ���������� �� ��������� ��� ����, ����� ���������  ��� �������?",
						4 => "����� �������, �� �����, ������ ����� ������ ������, ������ ����� ������.",
					);
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003207,"������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ������ �������� ��� <b>����������� �����</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					SetQuestStep($user,29,2) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � �������?",
					1 => "��� ��� �����������. � ��������.",
					99 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "���, � ��� �� ��� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		} elseif ($step == 3) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�������� - �� �� �����! ����� ��� �� ��������� ��� � � ��������� �����, �� ������� ������ ��� �����. ��� ���� �������, ��� � � �������.",
						3 => "������� �������. ��������� ���� ���. ",
					);
				} elseif ($_GET['qaction'] == 3) {
					// ����� �������
					// ��� �Ѩ ��
					mysql_query('START TRANSACTION') or QuestDie();

					$r = AddQuestRep($user,150) or QuestDie();
					$m = AddQuestM($user,3,"������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
	
					PutQItem($user,105,"������",7,array(),255) or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					UnsetQuest($user) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � �������?",
					1 => "�������, ������. ���������� ��� ��������� ��������� ����� ��������� �� ������������� ������. ������-��, � �������, �������� ����?",
					99 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "���, � ��� �� ��� ������.",
				);
			}	
		} elseif ($step == 4) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					// ����� ����� �������
					$mldiag = array(
						0 => "��� ����� - �� ����. ������ �� ��� � �� ��� ���������� �������, ������� ��������������, ���� ���������. � ������ � ������, ��� ������ ���� �� �����-������ ���������� ���, ������ � ����, �� ������ � �������. ����������� ��� � �� ����� �� ����� ���.",
						3 => "������� �������. ��������� ���� ���. ",
					);
				} elseif ($_GET['qaction'] == 3) {
					// ����� �����
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003208,"������") or QuestDie();

					addchp ('<font color=red>��������!</font> ������ �������� ��� <b>�������� ����</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					SetQuestStep($user,29,5) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} elseif ($_GET['qaction'] == 2) {
					// ����� ����� �����
					$mldiag = array(
						0 => "���?! ��� �� ������ �������� ����?! ���������� �� ����� ������ ������!",
						4 => "��, ��� �� ��� ���������",
					);
				} elseif ($_GET['qaction'] == 4) {
					// �������� ��� � �������
					mysql_query('START TRANSACTION') or QuestDie();
					StartQuestBattle($user,542) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
	
					unsetQA();
					Redirect('fbattle.php');
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � �������?",
					1 => "� ���� �� �������, �������. ��, � ������ ��� ��� �� � �������� ������, ������ �� �����������, ������ � ����� ���� � ���� ���� �������, ��� �� ��� ���� �� �������, ����������� ���� �� ������?",
					2 => "���, � �� ������� �� ������ ������� ���� ������! � ������ ������� � ��� ����� ���� ��� ������?!",
					99 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "�� ������� � ��� ��. ����� � �����",
				);
			}	
		} else {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ���� ���������?",
					99 => "� ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "������ ���� �����...",
				);
			}	
		}

	}

	if ($sf == "mlknight") {
		if ($step == 2 && QItemExists($user,3003207)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					// ������� �����
					$mldiag = array(
						0 => "��� ��� ����������� � ��� �������! � ��, ������ ����, ����� � ������? ������������, �������� ������ ���� ����!",
						3 => "�� ���, �������, � ������� ��������. ������� ���, ������ ��, ������� ���! � �� ���, ���, ����� ���������� ��� ���. ����!",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();

					// �������� �����
					$it = QItemExistsID($user,3003207);
					PutQItemTo($user,'������',$it) or QuestDie();

					SetQuestStep($user,29,3) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "� ��� �� ��� ������� ������� ������, � ��� ��� ���� �����? ������ ����� ������ ���� ������ �������?",
						4 => "�� ������ �����, �� � �� ������ ������� ��������� � ��� �������� ������, ������� ������� ����������� �����. �������� - ����� ����, �� ��� ������, ��� �� ����� �� ����� �� �����.",
					);
				} elseif ($_GET['qaction'] == 4) {
					$mldiag = array(
						0 => "������� �� ��������������! ���� �� ����, ��� ���� ������������. ������ � ���� ���������! ����, �������, ��������� ���� �� ������, ��� �� ��� �� ���� �����, ������ ���� � ������ �������, ��������� ����� ��� �������.",
						5 => "��� ��� ������. �� ��� ��� �������� ��� ��������� � ������ ������ � �� ��� �������.",
						6 => "�����, � ��� �� ��������� ���-������ ��� ����.",
					);
				} elseif ($_GET['qaction'] == 5) {
					// ����� ������� �����
					// ��� �Ѩ ��
					mysql_query('START TRANSACTION') or QuestDie();

					// �������� �����
					$it = QItemExistsID($user,3003207);
					PutQItemTo($user,'������',$it) or QuestDie();

					// ����� �������
					$r = AddQuestRep($user,150) or QuestDie();
					$m = AddQuestM($user,2,"������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
	
					PutQItem($user,15567,"������",0,array(),255,"eshop") or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ����� �����������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					UnsetQuest($user) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 6) {
					$mldiag = array(
						0 => "��� ����� ����������� � ����� �������! � ���� ���������� �� ����� ����������, �� ���� ����������!",
						7 => "���������� �� ������ ����������!",
					);				
				} elseif ($_GET['qaction'] == 7) {
					mysql_query('START TRANSACTION') or QuestDie();

					// �������� �����
					$it = QItemExistsID($user,3003207);
					PutQItemTo($user,'������',$it) or QuestDie();

					SetQuestStep($user,29,4) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ ������. ������� ��������� � ������ � ��������� � ������, ��� ������� �� �����?",
					1 => "����������� ��� ������! � ���� ��� ������� ��� ����. ���������� ������� �����-�� �������, ����� � ���� ��������, ���, �������� �������� ����� � ��� �����.",
					2 => "����������. � ������, ��� �� ������������ ���� � ������ �������� �������",
					11111 => "���, � ��� �� ��� ������.",
				);
			}	

		}

		if ($step == 7 || $step == 11) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��� ��� �� ���, �����, ������, �� ����!",
						3 => "���� ������������ ����������! ����������� � ��� ������ �� ���������� ����� ������ ����, ����� ��, ��� ��� ���������� �� ������� � ������",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "�����������! � ���������� ���������� � �����, ��� �� ��������� �� ��� �������� ���� �����!  � ���, ����� ���, � ���� ���� ��������� �������������!",
						4 => "������� �������.",
					);
				} elseif ($_GET['qaction'] == 4) {
					// ����� �������
					// ��� �����
					mysql_query('START TRANSACTION') or QuestDie();

					// ����� �������
					if ($step == 7) {
						$r = AddQuestRep($user,200) or QuestDie();
						$m = AddQuestM($user,3,"������") or QuestDie();
						$e = AddQuestExp($user) or QuestDie();
		
						PutQItem($user,15562,"������",0,array(),255,"eshop") or QuestDie();
	
						$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ �����������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
						addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					}

					if ($step == 11) {
						// ��� ��� ��������, ���� ����� �����, ������ ����� ���������
						if ($ai[1] == 1) {
							// �������� �����
							$r = AddQuestRep($user,150) or QuestDie();
							$m = AddQuestM($user,2,"������") or QuestDie();
							$e = AddQuestExp($user) or QuestDie();
			
							PutQItem($user,667667,"������",0,array(),255) or QuestDie();

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

							PutQItem($user,$item,"������",0,array(),255,"eshop") or QuestDie();

							$msg = "<font color=red>��������!</font> �� �������� <b>����� ������� ����</b> � <b>������� ������ ��������������� ".$txt."HP�</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
							addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();         

						} else {
							// ����� �����
							$r = AddQuestRep($user,200) or QuestDie();
							$m = AddQuestM($user,3,"������") or QuestDie();
							$e = AddQuestExp($user) or QuestDie();
			
							PutQItem($user,105,"������",7,array(),255) or QuestDie();
							$item = 3101;
							$howmuch = 5;
							if (mt_rand(0,100) < 70) {
								$item = 3103;
								$howmuch = 20;
							}
	
							PutQItem($user,$item,"������",0,array(),255,"eshop") or QuestDie();
		
							$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b> � <b>��� �� ������������ ".$howmuch." ��.</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
							addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();         
						}
					}
	
					UnsetQuest($user) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 6) {
					$mldiag = array(
						0 => "��� ����� ����������� � ����� �������! � ���� ���������� �� ����� ����������, �� ���� ����������!",
						7 => "���������� �� ������ ����������!",
					);				
				} elseif ($_GET['qaction'] == 7) {
					mysql_query('START TRANSACTION') or QuestDie();

					// �������� �����
					$it = QItemExistsID($user,3003207);
					PutQItemTo($user,'������',$it) or QuestDie();

					SetQuestStep($user,29,4) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "��! � �����, ��� �� ������� ������� ������ � ������! �� �� ���������",
					11111 => "��� ����� ��� ������",
				);
			}	

		}
	}

	if ($sf == "mlvillage") {
		if (($step == 5 && QItemExists($user,3003208)) || ($step == 10 && QItemExists($user,3003209)) && ((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001) {
					$mldiag = array(
						0 => "��, ��� ���, ������� � � ����. �� ���� ���! ������� ��� ������ � ����. ",
						2004 => "�� ����� �������������, �� ���� ����� ��� �������� �� ������ ��������� � ������� �������. ",
					);
				} elseif ($_GET['qaction'] == 2004) {
					mysql_query('START TRANSACTION') or QuestDie();

					// �������� �����
					if ($step == 5) {
						$it = QItemExistsID($user,3003208);
						PutQItemTo($user,'���������',$it) or QuestDie();
						SetQuestStep($user,29,7) or QuestDie();
					}

					if ($step == 10) {
						$it = QItemExistsID($user,3003209);
						PutQItemTo($user,'���������',$it) or QuestDie();
						SetQuestStep($user,29,11) or QuestDie();
					}

		
					UnsetQA();
					mysql_query('COMMIT') or QuestDie();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "����������� ����, ������, � ����� �������� �������. ������ �� �� ������� ������� � ��������� � ��������� ������ ��� ���������� �� ���� � ����� ������ ���������?",
					2001 => "���� ������, ���� ������������. � ��������� �������� ������ � � ���. � ���� ��� �������� ����, ��� ����������� ����� �������. ���� �����, ������ �? ��� ��� ����� ��������� ���������� ������� �� ���",
					11111 => "������� � ������ �������",
				);
			}
		}
	}

	if ($sf == "mlmage") {
		if ($step == 6 && QItemExists($user,3003208)) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "����� � ����, �������� � ����, �� ��� ������ �������� ����  - � �� ����.",
						2 => "���� � ���, ��� ������ �������� �������� �������� ��������� �� �� � ��� ���������� �������, � � �� ���� ������������ �, ������ ��� ���� �� ����������� ��� ������� ",
					);
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "�� � ���� ����� �������� � ������� �����, ������ ��� ����� ���-������ �� ��� �����.",
						3 => "� ���� ���� � �������� ����, ����� ����������?",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "������. ��� ������  ��� ���� ����� ��������� �������� ������������� ��. ��� ��������.",
						4 => "���-�� �� ���?",
					);
				} elseif ($_GET['qaction'] == 4) {
					$mldiag = array(
						0 => "������. ��� ������  ��� ���� ����� ��������� �������� ������������� ��. ��� ��������.",
						5 => "���-�� �� ���?",
					);
				} elseif ($_GET['qaction'] == 5) {
					$mldiag = array(
						0 => "������ �������, ��, ������, � ���� ��������� �������. ���� �������� ������� �����������, ���� ��� ������ ������������� ��� �����. ������ � ��� � ������ ��� ������� ������������ ���� ������� � ���� � ����� �� ��������� ������ � ������ �����������, ��� ���� ��.",
						6 => "� ������� ���� ������.",
						7 => "���������� ����������� � ��� �� ������.",
					);
				} elseif ($_GET['qaction'] == 6) {
					// ���� ������
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,29,8) or QuestDie();
					// �������� �����
					$it = QItemExistsID($user,3003208);
					PutQItemTo($user,'���������',$it) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 7) {
					// ��� �������� �����
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,29,9) or QuestDie();
					// �������� �����
					$it = QItemExistsID($user,3003208);
					PutQItemTo($user,'���������',$it) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�� ����� ���� ����� ���������. ����� ������ � �� ������ ����? ������.",
					1 => "����������� ����, �������. � ������ ������� ���� � ������, ���� ������� � ���� ���� �����.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					11111 => "������ ����� ����������.",
				);
			}	
		}
		// �����
		if ($step == 8) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,9,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "� ������ ��� ������ ������ ��������? ���������� �������� ����� �����, ����� ���� ���� ������, �������� ��� ����� ��� ���� ������.",
						3 => "��, ��� ��? ���?",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "��! ������ � ������ ������! �� ��� ������ � ��� ��� ������� � �����, � ������� ���� �������, � ����������. �����!",
						4 => "�������� �������!",
					);
				} elseif ($_GET['qaction'] == 4 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003209,"���",0,$todel) or QuestDie();
					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>�������� ���� ������ ����������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					SetQuestStep($user,29,10) or QuestDie();
					$ai[0] = 1;
					UpdateQuestInfo($user,29,implode("/",$ai)) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					1 => "��, ��� ������",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					11111 => "���, � ��� �� ��� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}

		// �����������
		if ($step == 9) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003210,10);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "�����������. ��� ����� ��������� ����� ��� �� ���������� ������� � ��������� ������ ���� ���������� ������� ���� ������. ��� ����� ���.",
						3 => "������ ���������, � �������.",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					$mldiag = array(
						0 => "���, �� ������, �������� ���� �������� ���������� ��! ������ � ������ ������! �� ��� ������ � ��� ��� ������� � �����, � ������� ���� �������, � ����������. �����!",
						5 => "�������� �������!",
					);
				} elseif ($_GET['qaction'] == 5 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003209,"���",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> ��� ������� ��� <b>�������� ���� ������ ����������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[1] = 1;
					UpdateQuestInfo($user,29,implode("/",$ai)) or QuestDie();

					SetQuestStep($user,29,10) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					1 => "��, ���, ������ ����������� ��� �� � ������!",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					11111 => "���, � ��� �� ��� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}

		// ����� �� �����������
		if (($step == 10 || $step == 11) && $ai[0] == 1) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003210);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��, ��� ���������� � ����� �������, ������ ���, �������� �� ��, ��� ���� ��� �� ���� ������� � ��� �������������. � ������������� �� ���� �������� ����� �� ���� ��� �������� ��������������.",
						3 => "�������� �������! ���� ����� ����� �����-�� ������ � � ������ � ����� �������!",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					$ai[0] = 0;
					UpdateQuestInfo($user,29,implode("/",$ai)) or QuestDie();

					// �������� �����
					PutQItem($user,667667,"���",0,$todel,255,"shop",1) or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>����� ������� ����</b> �� ����� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();


					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 99) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�� ����� ���� ����� ���������. ����� ������ � �� ������ ����? ������.",
					33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
					44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
					1 => "�� ��� ��� ����� � ���� �������, ���������, ��� � ����� ������ ���� ������. ���, �����, ������ ��� ���� ������� ������������, ��� �� ���� �� �������� ������ ������� �� ����!",
					11111 => "�������� �� ������������",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}
	}

?>