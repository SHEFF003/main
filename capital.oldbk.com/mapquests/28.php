<?php
	// ����� ���������� �����
	$q_status = array(
		0 => "�������� ���������� ����� ������ ������ (%N1%/1)",
		1 => "�������� ��������� �������� ���� (%N1%/1),  ����������� ������ (%N2%/1), ���������� ������(%N3%/1)",
		2 => "����������� � ���������",
		3 => "�������� �� ����������� ��� ��� �����������",
		4 => "��������� ����������� ���",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 28) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	$ai = explode("/",$questexist['addinfo']);

	// ai[0] - 0 - ������, 
	// ����� ����� ��������� (1-2), 
	// ���������� �������� 10�� - 3
	// ������ �� ��������� - 4
	// ������� ����� � ���������� - 5
	// ������������ ��������� � ������� ���������� - 6
	// �������� ����� �� ��������� �� ���������� - 7
	// ������� �� ������ ��� ����������� - 8
	// �������� ��� �� ����������� - 9

	if ($sf == "mlvillage") {
		if (((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003200,1);
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && $mlqfound) {
					$mldiag = array(
						0 => "��, ����� �������. ��� ������ ��� � ��� �� �������� ����� ���������� ��������� ������� ��������� ���� ��� ���.",
						2004 => "������ ��� ������.",
					);
				} elseif ($_GET['qaction'] == 2099) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} elseif ($_GET['qaction'] == 2004 && $mlqfound) {
					// �������� �������
					mysql_query('START TRANSACTION') or QuestDie();

					if ($ai[0] == 2) {		
						$r = AddQuestRep($user,150) or QuestDie();
						$m = AddQuestM($user,3,"���������") or QuestDie();
						$e = AddQuestExp($user) or QuestDie();
		
						PutQItem($user,144144,"���������",0,$todel,255) or QuestDie();

						$msg = "<font color=red>��������!</font> �� �������� <b>��������� �����������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
						addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					}


					if ($ai[0] == 5) {		
						$r = AddQuestRep($user,150) or QuestDie();
						$m = AddQuestM($user,4,"���������") or QuestDie();
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

						PutQItem($user,$item,"���������",0,$todel,255,"eshop") or QuestDie();

						$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ��������������� ".$txt."HP�</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
						addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					}

					if ($ai[0] == 10) {
						$r = AddQuestRep($user,200) or QuestDie();
						$m = AddQuestM($user,2,"���������") or QuestDie();
						$e = AddQuestExp($user) or QuestDie();

						PutQItem($user,105,"���������",7,$todel,255) or QuestDie();
			
						$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
						addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					}

					if ($ai[0] == 7) {
						$r = AddQuestRep($user,150) or QuestDie();
						$m = AddQuestM($user,2,"���������") or QuestDie();
						$e = AddQuestExp($user) or QuestDie();

						PutQItem($user,50078,"���������",0,$todel,255,"eshop") or QuestDie();
			
						$msg = "<font color=red>��������!</font> �� �������� <b>�������� ���������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
						addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();					
					}
	
					UnsetQuest($user) or QuestDie();
					UnsetQA();
					mysql_query('COMMIT') or QuestDie();
				} elseif (isset($_GET['qaction']) && $_GET['qaction'] == 2099) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();		
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					2001 => "������ ������ ����, ��� �������� ��������, ����� ����� ��� �� ������ ������ ������, �� ��������� � ���������� �����������.",
					2099 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					11111 => "��� ���, ��� ����� ������ �������.",
				);
				if (!$mlqfound) unset($mldiag[2001]);
			}
		} 
	}


	if ($sf == "mlpiligrim") {
		if ($ai[0] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�� �������� �� ���, ������ ������ �� ����� ��� ���� ������. �� �� ���� ��� ������ ����������� ��� ���� � ������� ��� �������� ����, ����������� ������ � ���������� ������, � � ���� ����� ������. ���� ������ ��������� � ��� �� ��� � ��� ���������� ������� �������, ��� �� ��� � ����� ��������",
						2 => "���� ����������� ���� ����������! ����� �������! ����! ",
					);
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 1;
					UpdateQuestInfo($user,28,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();				
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �������, � �� ��� ���-�� ������. ����� ����� ������ �����. �����������, �� ������ �������� ��������� ��� ���� ������� ����?",
					1 => "����������� ����! �� ���� ������, ������ �������. ����� � ���� ���-��, �� ����� ����� �������, �����, ����� �� ��������� ������� ��������������. �� ���������� � ��� ��������� ���� �����?",
					11111 => "������ �������� ����, �� ������� ��������.",
				);
			}	
		}
		if ($ai[0] == 1) {
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003201);
			$qi2 = QItemExistsID($user,3003202);
			$qi3 = QItemExistsID($user,3003203);
	
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��� � ������. ��� ������ ��������� ��������� �����. ������� ����, �������.",
						2 => "��������� �����������, �� �� ����� � �������",
					);
				} elseif ($_GET['qaction'] == 2 && $mlqfound) {
					$mldiag = array(
						0 => "��, ��� ��� � ������! ���� ����� ���� ����������� �����! ���������� ��������� ��� ��������.",
						3 => "������������� �������. ����!",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003200,"��������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> �������� ������� ��� <b>����� ������ ������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[0] = 2;
					UpdateQuestInfo($user,28,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();				
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					1 => "��, ��� �����: �����, ������, �������",
					11111 => "���� �� ������, ����� �������!",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}
		if ($ai[0] == 3) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "� �������? �������, ��������! ��� ������ ����� ��, ��� ��� �� ��� ���, �������?",
						3 => "������� �� ����. �������, � �� �� ����� ����� ������, ��������. � ������� � ��� �����! ����!",
					);
				} elseif ($_GET['qaction'] == 3) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 4;
					UpdateQuestInfo($user,28,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();				
					unsetQA();
				} elseif ($_GET['qaction'] == 2) {
					// ������, ����� � ������������
					mysql_query('START TRANSACTION') or QuestDie();
					StartQuestBattle($user,535) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
	
					unsetQA();
					Redirect('fbattle.php');
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �������, � �� ��� ���-�� ������. ����� ����� ������ �����. �����������, �� ������ �������� ��������� ��� ���� ������� ����?",
					1 => "����������! �������, � ����������, �� ����������, ��� ��� ����� � �������?...",
					2 => "����������! ��� ������!",
					11111 => "������ ���� ��������",
				);
			}	
		}

		if ($ai[0] == 6) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "��, ����� ���. ��� ����� ������������� ����� ���� ������. ���, ������ ���. ��� �������� �������, �� �������� �� ����������� � � ���� ������������� � ��� �����.  � ��� �� ������! � ���������,��� ������ ������ ���� ����������.",
						2 => "��� �������, ����� �������� ����� � �������� ������� ��� ��������!",
					);
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003200,"��������") or QuestDie();

					addchp ('<font color=red>��������!</font> �������� ������� ��� <b>����� ������ ������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					// ����� ������
					$ai[0] = 7;
					UpdateQuestInfo($user,28,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();				
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ������� ����, ��� ����� ������ ���������! �� ������ �� ����� � ������������ ������?",
					1 => "������ ���� ������ �������. � ����� ��� � �������?",
				);
			}	
		}
	}

	if ($sf == "mlwood" && $ai[0] == 1) {
		$mlqfound = false;
		$qi1 = QItemExistsCountID($user,3003201,1);
	
		if ($qi1 === FALSE) {
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��� �� ������? ���� ������?! ��� �� ������?! �� ���?... ���� ������. � �� �� ���� � �������� ����� ��� � ���� ������ ����, ��� �� ���� � ���������� ���� � ������ �� �������, � �� ��� ������ �����, ��� ��������-��?... ��� ���, ��������, �� ������?",
					2 => "��� ����� ������������ ���������� ���������. ��� ����� �����-�� �� ������?",
				);
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				$mldiag = array(
					0 => "��, �� �� ������-�� ���� �� �����, �-�� ��� ��� ������� �� ��� ������, �����-�� ����� ��������.",
					3 => "�� ���� ��� �� ������, ����� ������, �������� ��� ���?!",
				);                         
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				$mldiag = array(
					0 => "�� ������-������ ��� ������ � ����� ��������? � ���������� ��� ������� ��� �� ��������, � ���������� ����������� � ������  ���� �� ��� � ���� �������� �������� ��� ����� ����.",
					4 => "�������, ��, ��� ����! ����������� �������, ��� �� �������� � ����������... ����!",
				);
			} elseif ($_GET['qaction'] == 4 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003201,"��������") or QuestDie();
				addchp ('<font color=red>��������!</font> �������� ������� ��� <b>���������� ������</b> ','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��, ����� ��������� ����������. � �������� ��� � ������, ��� ��� ��� � ��� �����. ����� ��������� ��� ���� ������� ������?",
				1 => "������� ���� � ���� � ����! ���������� ���������� ���������� ������! ������� ���� �����, �������, ��� �������� ��������� � �� ����� �� ������ �������!",
				11111 => "� ����� �����",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}
	}

	if ($sf == "mlbuyer" && $ai[0] == 1) {
		$mlqfound = false;
		$qi1 = QItemExistsCountID($user,3003202,1);
	
		if ($qi1 === FALSE) {
			$mlqfound = true;
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "� ��������� ���������� ����� �� �������? ��� ����� ��� ��� �������? �-�� ����, ��� �� �� ����� ����� � � �� �����-���� ���� ��������� 10 �������� � ������� ����. � ������ ��� �������� �����������.",
					2 => "� ���� ���� ������� ����������, ��� ���-�� ���� �����.",
					3 => "������, ��� ���� 10 ��������.",
				);
				if ($user['money'] < 10) unset($mldiag[3]);
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				StartQuestBattle($user,535) or QuestDie();
				mysql_query('COMMIT') or QuestDie();

				unsetQA();
				Redirect('fbattle.php');
			} elseif ($_GET['qaction'] == 3 && $mlqfound && $user['money'] >= 10) {
				mysql_query('START TRANSACTION') or QuestDie();

				$rec = array();
	    			$rec['owner']=$user[id];
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money']-10;
				$rec['target']=0;
				$rec['target_login']="�������";
				$rec['type']=252; // ����� ���������� ����
				$rec['sum_kr']=10;
				add_to_new_delo($rec) or QuestDie();

				// �������� ������
				mysql_query('UPDATE oldbk.`users` set money = money - 10 WHERE id = '.$user['id']) or QuestDie();

				// ��� ����
				PutQItem($user,3003202,"�������") or QuestDie();

				// ��������
				addchp ('<font color=red>��������!</font> ������� ������� ��� <b>����������� ������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				unsetQA();

				mysql_query('COMMIT') or QuestDie();				
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�������, �������. ����� � ����� ���������?",
				1 => "���������� ��� ��������� ��� ������� ����� ����������� ������. �������, ���� ������ ����� �� ��� �� ������ ���� � ����� ������ �������-����������� � ������ ������������.",
				33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
				11111 => "������������� �����, ��� �����.",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}
	}

	if ($sf == "mlhunter" && $ai[0] == 1) {
		$mlqfound = false;
		$qi1 = QItemExistsCountID($user,3003203,1);
	
		if ($qi1 === FALSE) {
			$mlqfound = true;
		}


		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��, ��� �������� ���� ���� �� ��������� ��� ���� ��� �������� ��� ���� �� ��� �������� ���, ����� �����.",
					2 => "�������� �������! ����!",
				);
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();

				// ��� ����
				PutQItem($user,3003203,"�������") or QuestDie();

				// ��������
				addchp ('<font color=red>��������!</font> ������� ������� ��� <b>�������� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				unsetQA();

				mysql_query('COMMIT') or QuestDie();				
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
				1 => "������, ������ ��������� ������ ������, ���� � ���� ����������� ����. ���������� ��� ������ ������������ ���, �� ������� �������, ��� ����� �������� �����, � � �� ����, ��� ������ �� ������� ��� ��� �� �����. �� �������� ���? �� ����� ������ ��� �������� ��������� �� �����, � ������ �����, �����.",
				11111 => "� ����� �����",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}
	}

	if ($sf == "mlrouge") {
		if ($ai[0] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�� ��� ������ � ��� ���, � ����, ��� ���� � �������. ����� ������ �� �����, ��� �������� � ��� ��� �� ����?",
						2 => "�������� ������� ����� �����, ������� �� ��� ����� �������� ����� � ����. � �������  ���������?",
					);
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "������. � ��� �� �� ������ ���������� ��� �� ����� ������?",
						3 => "�� � ��� ����� ���� ����� �������-������� ������, �����? ��� ������ 5��?",
						4 => "��� ������ ������ �� ������? ����� ����, � � ���� ���-�� ��� ������?",
					);
					if ($user['money'] < 5) unset($mldiag[3]);
				} elseif ($_GET['qaction'] == 3 && $user['money'] >= 5) {
					$mldiag = array(
						0 => "5 �����? �� �� ����� ������ � �� ���� �� ����� �� ������� ������ �����",
						5 => "������, ����� ����� ���� 10��?",
						11111 => "�� �� ��� � ���� ���. � �����.",
					);
					if ($user['money'] < 10) unset($mldiag[5]);
				} elseif ($_GET['qaction'] == 5 && $user['money'] >= 10) {
					$mldiag = array(
						0 => "��� ��� ������ ������ ����! ���� ������.",
						6 => "����� 10 ��. � ��� �� ��� ��� ���������?",
						11111 => "� ���������. � �����.",
					);				
				} elseif ($_GET['qaction'] == 6 && $user['money'] >= 10) {
					$mldiag = array(
						0 => "����������� � ���������, � �� ��������� �� ����� � �������, ����� �� ������ ������. ��� � ��� �� �������� ��� ����������� � �� ���� �� ����� ������� ����������.",
						7 => "�������, ��� � �������!",
					);
				} elseif ($_GET['qaction'] == 7 && $user['money'] >= 10) {
					// ����� 10 ��
					mysql_query('START TRANSACTION') or QuestDie();
					$rec = array();
		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-10;
					$rec['target']=0;
					$rec['target_login']="���������";
					$rec['type']=252; // ����� ���������� ����
					$rec['sum_kr']=10;
					add_to_new_delo($rec) or QuestDie();
	
					// �������� ������
					mysql_query('UPDATE oldbk.`users` set money = money - 10 WHERE id = '.$user['id']) or QuestDie();

					$ai[0] = 3;
					UpdateQuestInfo($user,28,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();				
					unsetQA();
				} elseif ($_GET['qaction'] == 4) {
					// ������ �� ������
					$mldiag = array(
						0 => "�� ������-�� ���� ��� ���� ������  ��� ������ ���� �������� ��������� �� �����������, � ��� ��� ��� �� ����, ��� � ���. ������ ��������, �������� �� � ����� �������� ����� ���� �� ������� �����, �� ��� �� �����, �� �������. � �� �� ��� ����� ��� ��� ��������� ��������, �� ��������.",
						8 => "�� �����!",
						11111 => "��� �� ���������, � ����� �����!",
					);
				} elseif ($_GET['qaction'] == 8) {
					mysql_query('START TRANSACTION') or QuestDie();

					$ai[0] = 8;
					UpdateQuestInfo($user,28,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();				
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������-��, � ��� ����� �� ������! ��� ������, �� ���� �� ��� �����. � ��� �� ������� ���� � ��� ���?",
					1 => "����-����, ������� ������ ������. �� ���� � ������. ������ ���� � ������� ������������.",
					11111 => "���������� ������, ��� �����",
				);
			}	
		}
		if ($ai[0] == 4) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�����-�� � ���, �� ��� ������ ������ �� ��� ��������. ���� ��� � ���� ������������. ������ ����������!",
						2 => "��� ��� ����������? �� �� ����� ���!",
					);
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "� �� �����, � ��� �� ��������? ����� ����� � �����������? ������ ������!",
						3 => "��� �� ���. �����������!",
					);
				} elseif ($_GET['qaction'] == 3) {
					// ����� � ������������ �� �����
					mysql_query('START TRANSACTION') or QuestDie();
					StartQuestBattle($user,535) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
	
					unsetQA();
					Redirect('fbattle.php');
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ����������. ����� �� ������� ���������. ������, ��������, ��, �����, �� �� �� ������ ���, ��������� ������, ����� ���� �� ����� ������ ����� � ����� � ������� ������� ����!",
					1 => "��-��, ��� ��� ����� ���������. ����� � ���?",
				);
			}	
		}

		///////////////
		if ($ai[0] == 8 || $ai[0] == 9) {
			$mlqfound = false;
			if ($ai[0] == 9) {
				$qi1 = QItemExistsID($user,3003204,1);
			} else {
				$qi1 = false;
			}
	
			if ($qi1 !== FALSE) {
				$mlqfound = true;
				$todel = $qi1;
			}


			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "�����-�� � ���, �� ��� ������ ������ �� ��� ��������. ���� ��� � ���� ������������. ������ ����������!",
						2 => "��� ��� ����������? �� �� ����� ���!",
					);
				} elseif ($_GET['qaction'] == 2 && $mlqfound) {
					$mldiag = array(
						0 => "� �� �����, � ��� �� ��������? ����� ����� � �����������? ������ ������!",
						3 => "��� �� ���. �����������!",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					// ����� � ������������ �� �����
					mysql_query('START TRANSACTION') or QuestDie();
					StartQuestBattle($user,535) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
	
					unsetQA();
					Redirect('fbattle.php');
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "��, ��� ��� �� �����������. �� ��������� ���� ����� �������? ����� � ���?",
					11111 => "���� ��� ���, ����� ��������",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}	
		}

	}

	if ($sf == "mlvillage") {
		if ($ai[0] == 8 && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "������ ����������, ��������?! ��, ��� ����� ��� ������ �� ������� ��� ��������!",
						2 => "��� ����������, ��� ��� �������� ���� ������ �����.",
					);
				} elseif ($_GET['qaction'] == 2) {
					$mldiag = array(
						0 => "�� ����, �� ��� ��� ��� �������, � � ��� ������ ������� � ��������� �� �����, �� ������� � ��� ������ ������! ����� ���� � ����� ������!",
						3 => "�����, �� �� ������� ����� �����, � ��� ����� �����, ��� �� ��� ��������� ������, ������� � �� �������. ��� ��� ����� ����� ��� ����������� ��������.",
						5 => "������� ��� ���� ������?",
					);
				} elseif ($_GET['qaction'] == 3) {
					// ����� � ��������� �����
					$mldiag = array(
						0 => "������, �� ����� ������ �� ������, �� ��������� �� �� �� ������������? � ��, ������, �������� ������!",
						4 => "��� ������ � ��������, ��� �� ��� ����������!",
					);
				} elseif ($_GET['qaction'] == 4) {
					mysql_query('START TRANSACTION') or QuestDie();
					StartQuestBattle($user,531) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
	
					unsetQA();
					Redirect('fbattle.php');				
				} elseif ($_GET['qaction'] == 5) {
					// ����� ��������� ��
					$mldiag = array(
						0 => "�� �����-�� 8 ��. � ������ �� �������, � ���� ������� � ����� ��������� �����. ��������� ��, �� � ���� ������",
						6 => "���, ����� ���� 8 ��.",
						3 => "� ���� ��� ������ �����, � ��� ����� �����, ��� �� ��� ��������� ������, ������� � �� �������. ��� ��� ����� ����� ��� ����������� ��������.",
					);
					if ($user['money'] < 8) unset($mldiag[6]);
				} elseif ($_GET['qaction'] == 6 && $user['money'] >= 8) {
					$mldiag = array(
						0 => "�����������! � ����� ������� ����� ����! ���, ����� ��������, ��� � ������ ����������� � ��������� �� �� ���� ��������� ������!",
						7 => "�����������. ����!",
					);
				} elseif ($_GET['qaction'] == 7 && $user['money'] >= 8) {
					mysql_query('START TRANSACTION') or QuestDie();
	
					$rec = array();
		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-8;
					$rec['target']=0;
					$rec['target_login']="����������";
					$rec['type']=252; // ����� ���������� ����
					$rec['sum_kr']=8;
					add_to_new_delo($rec) or QuestDie();
	
					// �������� ������
					mysql_query('UPDATE oldbk.`users` set money = money - 8 WHERE id = '.$user['id']) or QuestDie();
	
					// ��� ����
					PutQItem($user,3003204,"����������") or QuestDie();
	
					// ��������
					addchp ('<font color=red>��������!</font> ���������� ������� ��� <b>���  ��� �����������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[0] = 9;
					UpdateQuestInfo($user,28,implode("/",$ai)) or QuestDie();

					mysql_query('COMMIT') or QuestDie();				
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
					1 => "�� ����, �� ������ �� ��-������.  ���������� ���� �������, ������ ���� ����������, �-�� � ������ �������� � ����� ����.",
					11111 => "�������, � ������ �������",
				);
			}
		}
	}


?>