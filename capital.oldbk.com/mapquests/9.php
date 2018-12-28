<?php
	// ����� ���������� �������
	$q_status = array(
		0 => "����� ��� ���� ������ ������ (%N1%/1), �������� ����� (%N2%/1) � ����������� ����� ��� ��������� (%N3%/1).",
		1 => "�������� �������� ���� (%N1%/1).",
		2 => "�������� ������� ������� ���� (%N1%/1).",
		3 => "�������� �������� ������ ������� (%N1%/1) ��� ����� ������� (%N2%/5).",
	);


	// �������� ������-�����.
	function SelectQuestion($quest = 0) {
		if ($quest == 0) {
			$query      = mysql_query("SELECT count(*) AS count FROM oldbk.victorina");
			$count      = mysql_fetch_assoc($query);
			$quest = rand(1, $count['count']);
		}
		$data = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`victorina` WHERE `id` = ".$quest." LIMIT 1;"));
		$data['Q'] = ObfuscateQ($data['Q']);
		return $data;
	}

	// ������ ����� ������ ������ ��������.
	function ObfuscateQ($q)	{
		$letters = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
		$replace = array("a", "e", "A", "o", "p", "u", "E", "K", "M", "C", "c", "y", "3", "H", "B", "O", "P", "k", "n", "T", "X", "b");
	
		$q=str_replace($letters,$replace,$q);
		return $q;
	}
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 9) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlmage") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003030);
		$qi2 = QItemExistsID($user,3003033);
		$qi3 = QItemExistsID($user,3003034);

		if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
			$todel = array_merge($qi1,$qi2,$qi3);
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��, ������ �������. �������, ����� �� ���� � ������, ��, ����,  �� ������ ������ ������ � ���������! ������� ������� ���������. ��, � � ���� ����� �� �������, ����� ������ �� �����.",
					4 => "������ � ����� ������� (�������� �������)",
				);
			} elseif ($_GET['qaction'] == 4 && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,200) or QuestDie();
				$m = AddQuestM($user,4,"���") or QuestDie();
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


				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();

				unsetQA();
			} elseif ($_GET['qaction'] == 3) {
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
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
			);
			if ($mlqfound) $mldiag[1] = "��, ��� ������, ����� � ����������� �����.";
			$mldiag[3] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
			$mldiag[2] = "���, � ��� �� ��� ������. ����� ������.";

		}
	}

	if ($sf == "mlwood") {
		if (QItemExists($user,3003030)) return;

		$ai = explode("/",$questexist['addinfo']);

		if ($ai[0] == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "����, ������ �� � ���. ��� ������� � ������ � ����� ������� ��� ����� ������. ���������� ��� ����, �� � � ���� ������ �� ��� �� ������. ������� ��� ������, � � ���� ������� ����� �������.",
						3 => "������������, � ����� �������.",
					);	
				} elseif ($_GET['qaction'] == 3) {
					$ai[0] = 1;
					mysql_query('START TRANSACTION') or QuestDie();
					UpdateQuestInfo($user,9,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ����� ��������� ����������. � �������� ��� � ������, ��� ��� ��� � ��� �����. ����� ��������� ��� ���� ������� ������?",
					1 => "����������, ��� ����� ������ ������ ��� �������, �� ������ ����� �������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
		if ($ai[0] == 1) {
			$mlqfound = false;
			$todel = QItemExistsID($user,3003029);
			if ($todel !== FALSE) $mlqfound = true;

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��� �������, ������ �� ����� � ������. ����� ���� ������. ��� � ������, ������ �� ������� ������.",
						3 => "���������",
					);
				} elseif ($_GET['qaction'] == 3 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003030,"�������",0,$todel) or QuestDie();

					// ��������
					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>������ ��� �������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					$ai[0] = 0;
					UpdateQuestInfo($user,9,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
				);
				if ($mlqfound) $mldiag[1] = "��, ��� ���� ����, � ������ ������?";
				$mldiag[2] = "��� ���. ����� ������.";
			}		
		}
	}

	if ($sf == "mlhunter") {
		if (QItemExists($user,3003032)) return;

		$ai = explode("/",$questexist['addinfo']);
		if ($ai[1] == 1) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "���� ����, ������ � ��� ������� ����. �� � �� ��� ���-��� ������. �������, ��� �������� ��� ������ �� ������ �������. ������ ���� ������. ��������� ��� ������, ����� � ���� ��������. ",
						3 => "������ ������ ��� ��� ��� �� �������. � ��� ����� ������ ����� �����?",
					);
				} elseif ($_GET['qaction'] == 4) {
					$ai[1] = 2;
					mysql_query('START TRANSACTION') or QuestDie();
					UpdateQuestInfo($user,9,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 3) {
					$mldiag = array(
						0 => "�������, ��� � ������ ����� ������ ����� �����������. �� ���� ��� �� �������, ������ �������� ��� 5 ������ �������. � ��� ������ �� ���� ����������. �������� ������ ���� ������ ����� ������. ���� �� �� ������� �������, ������ ��������.",
						4 => "������������, ������� ���� ��� ������ ��� �����.",
					);
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
					1 => "� � ���������� �� �������, �������, ��� ��� �� ��� ������ � ���� ������� ���� ������, �� ��� ����� �� �����. ��� ���, � ��� ������.",
					2 => "������ ����������, ������ �������� ����. ����� ������."
				);
			}
		}
		if ($ai[1] == 2) {
			$mlq1 = QItemEXistsCountID($user,1,1);
			$mlq2 = QItemEXistsCountID($user,3003031,5);

			if (isset($_GET['qaction'])) {
				if (($_GET['qaction'] == 1 && $mlq1) || ($_GET['qaction'] == 2 && $mlq2)) {
					$mldiag = array(
						0 => "�� ���-�, �� �������� ������� � � ���� ������. ��� ���� ������� ����, � ������� �������, ��� � ���� ����� ���������, ����� ������� � ���� �� ����� �������.",
						11111 => "�������, ����������� �������.",
					);

					mysql_query('START TRANSACTION') or QuestDie();
					if ($_GET['qaction'] == 1) {
						PutQItem($user,3003032,"�������",0,$mlq1) or QuestDie();
					} else {
						PutQItem($user,3003032,"�������",0,$mlq2) or QuestDie();
					}
                                        mysql_query('COMMIT') or QuestDie();
					// ��������
					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>������� ����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
				);
				if ($mlq1) $mldiag[1] = "��, ��� ��, ��� �� ������. (������ ������)";
				if ($mlq2) $mldiag[2] = "��, ��� ��, ��� �� ������. (������ 5 ������)";
				$mldiag[11111] = "���, � ��� �� ��� ������. ����� ������.";
			}		
		}
	}

	if ($sf == "mlvillage") {
		$ai = explode("/",$questexist['addinfo']);

		if ((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000)) {
			if (QItemExists($user,3003033)) return;

			if ($ai[1] == 0) {
				if (isset($_GET['qaction'])) {
					if ($_GET['qaction'] == 2001) {
						$mldiag = array(
							0 => "�������� �������� ����� ��� ���� ������ - ���� 3-4 �����. � �� ��� ������� �������� ������ ������. � ������ �� �������� �������� ����� �� �����. ��� ��� � �� ������, � �� ������ � ��������. �����, ��� � ��� �� ��� ������ � ���� ������, �� ��� ������ ����� �� ����.",
							2003 => "������������, � ����� �������."
						);
					} elseif ($_GET['qaction'] == 2003) {
						$ai[1] = 1;
						mysql_query('START TRANSACTION') or QuestDie();
						UpdateQuestInfo($user,9,implode("/",$ai)) or QuestDie();
						mysql_query('COMMIT') or QuestDie();
						unsetQA();
					} else {
						unsetQA();
					}
				} else {
					$mldiag = array(
						2000 => "������, ��� ���� ���� ������?",
						2001 => "��� ����� �������� ����� ��� �������. �� ������ �������?",
						2002 => "������ ����������, ������ �������� ����. ����� ������.",
					);
				}			
			}
			if ($ai[1] == 1 || $ai[1] == 2) {
				$mlqfound = false;
				$todel = QItemExistsID($user,3003032);
				if ($todel !== FALSE) $mlqfound = true;

				if (isset($_GET['qaction'])) {
					if ($_GET['qaction'] == 2001 && $mlqfound) {
						$mldiag = array(
							0 => "��� ��� ����, ��� ����. �� ���� ������ ������! �������! ����� �������� �����, ��� �� ���������, � � ����� ��������� ����, ����� ����� ��������!",
							2003 => "�������, ������� ���������!",
						);
					} elseif ($_GET['qaction'] == 2003 && $mlqfound) {
						mysql_query('START TRANSACTION') or QuestDie();
						PutQItem($user,3003033,"������",0,$todel) or QuestDie();

						// ��������
						addchp ('<font color=red>��������!</font> ������ ������� ��� <b>����� ��� �������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

						$ai[1] = 0;
						UpdateQuestInfo($user,9,implode("/",$ai)) or QuestDie();
						mysql_query('COMMIT') or QuestDie();
						unsetQA();					
					} else {
						unsetQA();
					}
				} else {
					$mldiag = array(
						0 => "������, �� ������ ��� ��, ��� � ������?",
					);
	
					if ($mlqfound) $mldiag[2001] = "��, ��� ������� ����.";
					$mldiag[2002] = "���, � ��� �� ��� ������. ����� ������.";
				}
				
			}
		}

		if ($ai[0] == 1 && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			if (QItemExists($user,3003029)) return;

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "� �� ���� ��� � ���. � ����� � ���� ����� ���. ����, ���� ��� ��������� ���� � ����� �� ��� ������� ��������, ����� ������, � ������� ��� �������. ��������, � ��� ��� ������  �����, ����� ������ �� ����. �������� ��� ����� ����� � ��� ���, ��� �� ������� ���������. � ��� � ����� ��� �������� � ������� ���.",
					);

					if ($ai[3] < 6) $mldiag[3] = "������������, ����� �������.";
					if ($user['money'] >= 2) $mldiag[4] = "���, � ����� �������. ����� 2 �������.";
					$mldiag[11111] = "������, �� ��� ���� ����";
				} elseif ($_GET['qaction'] == 4 && $user['money'] >= 2) {
					mysql_query('START TRANSACTION') or QuestDie();
					$rec = array();
		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-2;
					$rec['target']=0;
					$rec['target_login']="����������";
					$rec['type']=252; // ����� ���������� ����
					$rec['sum_kr']=2;
					add_to_new_delo($rec) or QuestDie(); //�����

					// �������� ������
					mysql_query('UPDATE oldbk.`users` set money = money - 2 WHERE id = '.$user['id']) or QuestDie();

					// ��� ����
					PutQItem($user,3003029,"����������") or QuestDie();
					mysql_query('COMMIT') or QuestDie();

					// ��������
					addchp ('<font color=red>��������!</font> ���������� ������� ��� <b>���� ��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					unsetQA();
				} elseif ($_GET['qaction'] == 6) {
					unset($_SESSION['map_quest9']);
					$mldiag = array(
						0 => "���, ��� �� ���������� �����. ���������� ��� ���?",
						3 => "��, �������� ��� ���.",
					);
					if ($user['money'] >= 2) $mldiag[4] = "���, � ����� �������. ����� 2 �������.";
				} elseif ($_GET['qaction'] == 7) {
					unset($_SESSION['map_quest9']);
					$mldiag = array(
						0 => "���, ��� �� ���������� �����. ���������� ��� ���?",
					);
					if ($user['money'] >= 2) $mldiag[4] = "���, � ����� �������. ����� 2 �������.";
					$mldiag[11111] = "������, �� ��� ���� ����.";
				} elseif ($_GET['qaction'] == 3 && $ai[3] < 6) {
					if (!isset($_SESSION['map_quest9'])) {
						$q = SelectQuestion();
						$_SESSION['map_quest9'] = $q['id'];
					} else {
						$q = SelectQuestion($_SESSION['map_quest9']);
					}

					if (isset($_POST['answer'])) {
						if ($q['A'] != $_POST['answer']) {
							$ai[3]++;
							mysql_query('START TRANSACTION') or QuestDie();
							UpdateQuestInfo($user,9,implode("/",$ai)) or QuestDie();
							mysql_query('COMMIT') or QuestDie();
							if ($ai[3] < 6) {
								Redirect("mlvillage.php?qaction=6");
							} else {
								Redirect("mlvillage.php?qaction=7");
							}
						} else {
							// ��� ����
							mysql_query('START TRANSACTION') or QuestDie();
							PutQItem($user,3003029,"����������") or QuestDie();
							mysql_query('COMMIT') or QuestDie();

							// ��������
							addchp ('<font color=red>��������!</font> ���������� ������� ��� <b>���� ��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
							$mldiag = array(
								0 => "�����, ��� � ��� �� ���������! ��� ���� ���� ��� �������� � ������ � �-���!",
								11111 => "����.",
							);
							return;
						}
					}

					// ���������� �������
					$mldiag = array(
						0 => $q['Q'],
						1 => '<!-- NOLINK -->�����: <form method=post><input type="text" name="answer"><input type=submit value="��������"></form>',
					);
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
					1 => "� �� ��������, �� ������������ ������, ������ ��� ��� ��������. �� ��������?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

	if ($sf == "mlbuyer") {
		if (QItemExists($user,3003034))	{
			$mldiag = array(
				0 => "�������, �������. ����� � ����� ���������?",
				33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
				11111 => "������ ����������, ������ �������� ����. ����� ������.",
			);
			return;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "�������, ��������? �� ��� � � ����� ���������� ������� �������?  ���� �� ������, ���������������,  ����� �������, ������� �� ������, ������� �� ��������. ����� ���, ���� ���������� � �������� �������� �������, ����� ��� � ��������.",
					3 => "���-���, ����� � �������� ����������? �����, ���� ����.",
				);
			} elseif ($_GET['qaction'] == 4) {
				// �������� ��� � �������
				mysql_query('START TRANSACTION') or QuestDie();
				StartQuestBattleCount($user,532, 10) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				Redirect("fbattle.php");
				unsetQA();
			} elseif ($_GET['qaction'] == 5) {
				if ($user['money'] >= 5) {
					mysql_query('START TRANSACTION') or QuestDie();
					$rec = array();
		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-5;
					$rec['target']=0;
					$rec['target_login']="�������";
					$rec['type']=252; // ����� ���������� ����
					$rec['sum_kr']=5;
					add_to_new_delo($rec) or QuestDie(); //�����
	
					// �������� ������
					mysql_query('UPDATE oldbk.`users` set money = money - 5 WHERE id = '.$user['id']) or QuestDie();
	
					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>����������� �����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					// ��� ����
					PutQItem($user,3003034,"�������") or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					$mldiag = array(
						0 => "���, ����� ����������� �����",
						11111 => "�������, ����",
					);
				} else {
					$mldiag = array(
						0 => "� ��� ��� 5 ��.",
						11111 => "������, ����.",
					);
				}
			} elseif ($_GET['qaction'] == 3) {
				$mldiag = array(
					0 => "�� ���, ���� ������� ������� ���������. ������ ��� �� �����, ��� ���������, ������ ���������, �� ��� �� ������ ���� � ��������. �������� � ���� � ������� �����, ������� �����. ������ ��� ������. ������� �� ��� �� ���������. ���� ������� �� ��������, �������� ���� �������.",
					4 => "������������, ������ �����!",
					5 => "���, �� �� ������ � ������� ��� ������. ����� 5 �������� � ����� �����.",
				);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�������, �������. ����� � ����� ���������?",
				33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
				1 => "������� ��� �����������, ������� � ���� ����� �����. �� ��������?",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}

	}
?>