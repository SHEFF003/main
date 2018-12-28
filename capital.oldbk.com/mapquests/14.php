<?php
	// ����� ���������� ����
	$q_status = array(
		0 => "�������� ���� ������ ������ ���� (%N1%/1), ������ ���� (%N2%/1) � ������� ���������� (%N3%/1).",
		1 => "������� � ������ � ������ ��� ����������.",
		2 => "������� � ���������� � ������ ��� ����������.",
		3 => "������� � �������� � ������ ��� ����������.",
		4 => "������� � ��������� � � ����������� � ������ ��� ����������.",
		5 => "�������� ��������� ��� ������� (%N1%/1).",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 14) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	$ai = explode("/",$questexist['addinfo']);

	if ($sf == "mlmage") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003047);
		$qi2 = QItemExistsID($user,3003048);
		$qi3 = QItemExistsID($user,3003050);
		$qi4 = QItemExistsID($user,3003051);
		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE && $qi4 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2,$qi3,$qi4);
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��, ��� �, �� ������� ��������� � ����������. ����� ���� ������� �� ������.",
					5 => "����� (����� �������)",
				);
			} elseif ($_GET['qaction'] == 5 && $mlqfound) {
				// �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,150) or QuestDie();
				$m = AddQuestM($user,1,"���") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItem($user,105,"���",7,$todel,255,"shop",3) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();


				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();
			} elseif ($_GET['qaction'] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();					
				UnsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				UnsetQA();			
			} else {
				UnsetQA();
			}
			
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
			);
			if ($mlqfound) $mldiag[1] = "��,  ��� ���� ������ �����, ������ ������ ���� � ����������.";
        		$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
			$mldiag[3] = "���, � ��� �� ��� ������. ����� ������.";
		}
	}

	if ($sf == "mlwitch" && $ai[0] == 0) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, ��, ����, � ��� �� ��������. ��� ����� ���������� � ����, �� ������ � ������� ���� �����. ����� ��� ���-��. �������� �������, ������, ��������� ���� ������ �������. �����, ��� ����������� ��� �� ��������. �� � � ��� �������� �� �����, �� ����� � ���� �����������.",
					3 => "����, �������, �������� ��������",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[0] = 1;
				UpdateQuestInfo($user,14,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����? ",
				1 => "��� � ������� ����������, �������, �������, � ���� ��������. ��� ���������� ������ �����-�� ������ ����� � ������� ���� �� ���� �������.",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}
	}

	if ($sf == "mlrouge" && $ai[0] == 1) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��-��! ��, ���� ����! �������� ���� �������. ������, ���� ������, ����� �� ������� ������� ���������, ������, �� ���������� �� ������� ����-�� ��������. ������, ����� ����� ���� �� ����� ����� �����, �� ������, �� ����������. ��������� ��������� ���������, �� �� ����� �� �� �� ���������. � ������� �� �� ����� ������� ��������. ������ � ���� ������������, ���� �� ���� ���� �������.",
					3 => "����, �����, �������, � ��������.",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[0] = 2;
				UpdateQuestInfo($user,14,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��������-��, � ��� ����� �� ������! ��� ������, �� ���� �� ��� �����.  � ��� �� ������� ���� � ��� ���?",
				1 => "� ���������� ������� ����������. �����-�� �� ��� � ������, �� �������, ������. �� ����� �� ��� ��� ����? �����, ��������� ��� ���?",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}
	}

	if ($sf == "mlbuyer" && $ai[0] == 2) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "���.. ����� � ����� ���� ��� ������� ������� � ����. ����� � �� ������� ���������, �� ��� ������� ������� ����������. ����� �������� �� �����������, �� ��� ���-��� �������� ����������. ������ ������� � ����� �� � ��������� ��������. � ��� ��������, �� ������. �������-�� �������, ������ �� �������� �������. �� � ������� ��� �� �� ��� �����. ������ ����� ������ ��� �������� ���, �� ������� ��� ������� �� ����� � ���������. ��� ��� ��� �������� � ���������, � ������ � �����������. ����, �������, ��� �� ����� �� ��������.",
					3 => "������� �� �������, ��� � ������.",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[0] = 3;
				UpdateQuestInfo($user,14,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�������, �������. ����� � ����� ���������?",
				33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
				1 => "��� ������� ����, ������� ����������. �����-�� ��� ���� � ������, ����� � �����������, � �����, �������, �� �������-�����������. �� ������ ��������� � ����������� ������. �����, ������, � ���� ��� ������?",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}
	} elseif ($sf == "mlbuyer") {
		$mldiag = array(
			0 => "�������, �������. ����� � ����� ���������?",
			33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
			11111 => "������ ����������, ������ �������� ����. ����� ������.",
		);
	}

	if ($sf == "mlpiligrim" && $ai[0] == 3) {
		if ($ai[1] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�, ��! ��� ����� ������. � ����� ���� ���� ������? � �� � �� �������, ��������, ���� � ��� �������. �����, �������, � �����, ����� �������� �����.",
						3 => "��, �����������, ��� �����-�� ���������� ������� ���� ��������. ��� ������ ���� ������ ��� ���������.",
					);
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "�� �� �  ����� � � ����������� �� ����, ���� ��� � ���� ����, �� ������ ��� � ���� ����������� �� �����. ��, ��� �� �������� �� � ���, ���������� ��� ������� ���������. �������� ������, ��� �������. ������ ���  �� �����, �� �������. � ����� ������ ������� ���� ����� �� ���������� ����. ��� �� ����, � ���������� ������� ��, �������.",
						5 => "������������, ������ ���� ��� �������.",
					);
				} elseif ($_GET['qaction'] == 5) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[1] = 1;
					UpdateQuestInfo($user,14,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �������, � �� ��� ���-�� ������. ����� ����� ������ �����. �����������, �� ������ �������� ��������� ��� ���� ������� ����?",
					1 => "�� ���, �������� �� ���� ����������. �������, ���-�� ��� ����� �� � ������������ ������� ���������� ��������� �������? �����, ����������� � ���� ��� ��������? ������ ����������, ������ �������� ����. ����� ������.",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		} elseif ($ai[1] == 1) {
			$mlqfound = false;
			$todel = QItemExistsID($user,3003049);
			if ($todel !== FALSE) $mlqfound = true;

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003047,"��������",0,$todel) or QuestDie();

					addchp ('<font color=red>��������!</font> �������� ������� ��� <b>�������� ��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[1] = 2;
					UpdateQuestInfo($user,14,implode("/",$ai)) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
				);
				if ($mlqfound) $mldiag[1] = "��, ��� ���� �������� ���. ����� ��������.";
				$mldiag[2] = "���, � ��� �� �����, ����� ������.";
			}		
		}
	}

	if ($sf == "mlvillage" && $ai[0] == 3) {
		if ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && $_GET['qaction'] < 1000)) {
			if ($ai[2] == 0) {
				if (isset($_GET['qaction'])) {
					if ($_GET['qaction'] == 1) {
						$mldiag = array(
							0 => "��, ��� �� �� �����, ��� ���� ������ ������ ����-�� �����������. �� ��� �� �����������, ������ � � ��� ���� ����. � ��� ����� ����, ������ ��� � ���� ��� ������ �� �����. ������, ��� �� 5 ��������, ���� �� �����. � ���� ����� ������ ������� �����, ����, ��� �������� ���� �����  �������.",
							3 => "��������, ��������? ����� ��� ����!",
						);
						if ($user['money'] >= 5) $mldiag[4] = "��� �������, ��� 5 ��������, ����� �������.";
						$mldiag[11111] = "������� ��� ������ � ������� ������ ������. ";
					} elseif ($_GET['qaction'] == 3) {
						mysql_query('START TRANSACTION') or QuestDie();
						StartQuestBattle($user,531) or QuestDie();
						mysql_query('COMMIT') or QuestDie();					
						Redirect('fbattle.php');
						unsetQA();
					} elseif ($_GET['qaction'] == 4 && $user['money'] >= 5) {
						mysql_query('START TRANSACTION') or QuestDie();					
						$rec = array();
			    			$rec['owner']=$user[id];
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money']-5;
						$rec['target']=0;
						$rec['target_login']="����������";
						$rec['type']=252; // ����� ���������� ����
						$rec['sum_kr']=5;
						add_to_new_delo($rec) or QuestDie();
	
						// �������� ������
						mysql_query('UPDATE oldbk.`users` set money = money - 5 WHERE id = '.$user['id']) or QuestDie();
	
						// ��� ����
						PutQItem($user,3003048,"����������") or QuestDie();
	
						// ��������
						addchp ('<font color=red>��������!</font> ���������� ������� ��� <b>�������� ��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
						$ai[2] = 1;
						UpdateQuestInfo($user,14,implode("/",$ai)) or QuestDie();
						unsetQA();
						mysql_query('COMMIT') or QuestDie();
					} else {
						unsetQA();
					}
				} else {
					$mldiag = array(
						0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
						1 => "������, � �� ����. �������, � ���� ���� �������� ������� ��������. � ������ �������� �������� � ���������. ���� ��� ���� �� �����, �����, ������?",
						2 => "������ ����������, ������ �������� ����. ����� ������.",
					);
				}
			}
		}
	}

	if ($sf == "mlboat") {
		$mlqfound = QItemExists($user,3003050);

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, �������, ��� ��� �� �������� ����� ������� ����� ������ ������ ������. �� �������� ���� ��� ����� ������ � ��������. �� ������ ��� ���� ����� �������. ������� ��� �� ���������, ��� � ������� ������.",
				);

				if ($user['money'] >= 1) {
					$mldiag[3] = "������, ����� 1 ��., � �������.";
				} else {
					$mldiag[11111] = "������, �� ����� ���.";
				}
			} elseif ($_GET['qaction'] == 3 && $mlqfound === FALSE) {
				// ��������������
				mysql_query('START TRANSACTION') or QuestDie();
				$rec = array();
				$rec['owner']=$user[id];
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money']-1;
				$rec['target']=0;
				$rec['target_login']="��������";
				$rec['type']=252; // ����� ���������� ����
				$rec['sum_kr']=1;
				add_to_new_delo($rec) or QuestDie();

				PutQItem($user,3003050,"��������");

				addchp ('<font color=red>��������!</font> �� �������� <b>������ ������ ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				if ($user['room'] == ($maprel+$maprelall+1)) {
					mysql_query('UPDATE oldbk.users SET money = money - 1, room = '.($maprel+$maprelall+2).' WHERE id = '.$user['id']) or QuestDie();
				} elseif ($user['room'] == ($maprel+$maprelall+2)) {
					mysql_query('UPDATE oldbk.users SET money = money - 1, room = '.($maprel+$maprelall+1).' WHERE id = '.$user['id']) or QuestDie();
				}
				mysql_query('COMMIT') or QuestDie();

				Redirect("mlboat.php");
			} elseif ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "��������� ���������. ������� 1 ������, � �������.",
					33333 => "��������� 1 ������.",
					11111 => "����������� � ����.",
				);			
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�����������. ��� ����� ������ � ������� ��������. ��������� ������� � ���������. ",
				1 => "��� �� ����� ��������������. � ���� � ���� �������. ����� ��� ������� ��������� ������ ����, �� � ������ ����� �� �������. �����, �������� ��� � �������� ���� �������?",
				2 => "��� �� ������������� �� �� �������. ������� ��� ����� ������?",
				11111 => "�� ����, � ������ �������� ����. ����� ������.",
			);
			if ($mlqfound !== FALSE) unset($mldiag[1]);
		}

	}

	if ($sf == "mlhunter") {
		$mlqfound = QItemExists($user,3003051);

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��-��! � �� ���� ������ � ��� ��������?! �������, ��� ��� ����� ��������. ��������, � ���� ����� �� ����� ���� ������ ������� ���������? � ����� ���, ��� ���. ��, �������, ��� ���������, ����. ������ �����, ����� ���� �����. �� ������, ����� ������ ���� � ��� �� �����.",
					3 => "�������, ������ ����� �� �������� �������.",
				);

			} elseif ($_GET['qaction'] == 3 && $mlqfound === FALSE) {
				// ��������������
				mysql_query('START TRANSACTION') or QuestDie();

				PutQItem($user,3003051,"�������");

				addchp ('<font color=red>��������!</font> ������� ������� ��� <b>������ �����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				mysql_query('COMMIT') or QuestDie();

				Redirect("mlboat.php");
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
				1 => "�� ���, ������ � ���� � �������� ���������. �� �������� �� � ���� ������� �����?",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
			if ($mlqfound !== FALSE) unset($mldiag[1]);
		}

	}

?>