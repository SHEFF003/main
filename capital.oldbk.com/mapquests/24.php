<?php
	// ����� ���������� � �������
	$q_status = array(
		0 => "�������� � ���������� ���� ���������� (%N1%/1) � ���� (%N2%/1)",
		1 => "�������� ������ ����� (%N1%/5) � ��������",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 24) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");
	
	$ai = explode("/",$questexist['addinfo']);

	if ($sf == "mlrouge") {
		$mlqfound = false;
		$qi1 = QItemExistsID($user,3003085);
		$qi2 = QItemExistsID($user,3003086);

		if ($qi1 !== FALSE && $qi2 !== FALSE) {
			$mlqfound = true;
			$todel = array_merge($qi1,$qi2);
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();		
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				$mldiag = array(
					0 => "��� ��� ������, ��� ��� �� �������! ��, ��� �  ������� � � ����� �� ���������! ������ ��� ���� �������!",
					3 => "��������� ���. ����!",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,150) or QuestDie();
				$m = AddQuestM($user,2,"���������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();


				$item = 3101;
				$howmuch = 5;
				if (mt_rand(0,100) < 70) {
					$item = 3103;
					$howmuch = 20;
				}

				PutQItem($user,$item,"���������",0,$todel,255,"eshop") or QuestDie();
				PutQItem($user,105,"���������") or QuestDie();
	
				$msg = "<font color=red>��������!</font> �� �������� <b>��� �� ������������ ".$howmuch." ��.</b> � <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��������? � � � �� �����, ��� ���� ����� �����. ��, ����� ����� ������?",
				1 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
				2 => "�� ������, �� ����� ��� ������. ��� ���� ������, �� � ��� �� ���������. ��� ��� �������������� � ���������, �� ����, ���� �� ��� ���������.",
				11111 => "���� �������, ������� �����",
			);
			if (!$mlqfound) unset($mldiag[2]);
		}
	}

	if ($sf == "mlvillage") {
		if ($ai[0] == 0 && ((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 1000 && $_GET['qaction'] < 2000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1001) {
					$mldiag = array(
						0 => "��� ����� ��������� ��� ���, ��� ���� � ������ ���� �� ����� ���� � �������� ��������?",
						1003 => "��� ��� ������ � ��� ���� ����������, ��� ����� ��� ���������� � ������, ��� �� ����� ��� ���� �������� ������� ����, �� ������� ����, ��� �� ���� ��, �� ��� ����� ��������� ������.",
					);
				} elseif ($_GET['qaction'] == 1003) {					
					$mldiag = array(
						0 => "���� ���� ��������, �� ������ ������ � ������� ���, ��-�� ���������� ������� ���� ��������� ����������� ��� �������� ������� ���, ��� ������ �����, ��� ������� ������������. ������ ���� � �����, �� ��� �� ��������� ������� � ������. �����, ��� � ������ ����, � �� �� �������.",
						1004 => "��������� ���, ������ ����.",
					);
				} elseif ($_GET['qaction'] == 1004) {
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 1;
					UpdateQuestInfo($user,24,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();			
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "����������� ����, ������, � ����� �������� �������. ������ �� �� ������� ������� � ��������� � ��������� ������ ��� ���������� �� ���� � ����� ������ ���������?",
					1001 => "������ ����, ���� �������, ����� � ������ � �������� ����� ������. �� ������, ����� �� ���� ��������� � �������� ��������� ��� ��������� � �������� �������� � ����������, ������� ���������� � ������.",
					11111 => "�������, � �� ���� �����.",
				);
			}
		}
	}

	if ($sf == "mlhorse" && $ai[0] != 1) {
		$mldiag = array(
			0 => "����������� ����, ������! ��� � ���� ���� ������? � ����� ������� ����� ������ ������ �� 10 ��. ��� ������� �� �� 5 ��. � ����� � ���� �� ��� ����� ����?",
			30000 => "������� � �������",
			11111 => "����� ������� � ���� � ������ ���.",
		);
	}

	if ($sf == "mlhorse" && $ai[0] == 1) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "� ������� ����� �� ����� � �� ���� ���� ������. ��������� ����� � ��� � ������� �������� � ��-�� ��������� ����������� ��� ���������� ������� ���� ��� ������� � ������. �������� � ���� ������� ���������� � ����. �����, ��� ������ �� ����.",
					2 => "������� �� �����. ����!",
				);
			} elseif ($_GET['qaction'] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[0] = 2;
				UpdateQuestInfo($user,24,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();			
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "����������� ����, ������! ��� � ���� ���� ������? � ����� ������� ����� ������ ������ �� 10 ��. ��� ������� �� �� 5 ��. � ����� � ���� �� ��� ����� ����?",
				1 => "��������� ����������� ���������� � ����. ���� � ���, ��� � �������� � ������� ��������� � ���� ��� �� ������� ��������� ������� ���� � ����� �� ������ ����� ��������� �������� ����",
				30000 => "������� � �������",
				11111 => "����� ������� � ���� � ������ ���.",
			);
		}
	}

	if ($sf == "mlknight" && $ai[0] == 2) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "����� � ������, ��������? �� ���� ���, �� ������� ��������� ����� ������������ ������ ��� � �� ������ �������������.",
					2 => "�������� �������! ����!",
				);
			} elseif ($_GET['qaction'] == 2) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[0] = 3;
				UpdateQuestInfo($user,24,implode("/",$ai)) or QuestDie();

				PutQItem($user,3003085,"�������� ������") or QuestDie();
				addchp ('<font color=red>��������!</font> �������� ������ ������� ��� <b>����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				mysql_query('COMMIT') or QuestDie();			
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, ������ ������. ������� ��������� � ������ � ��������� � ������, ��� ������� �� �����?",
				1 => "���� � ���� ������ �����, � �������� ���� ������ ��������� ��! � �����, �� �����. � ���� �� �������� ������� ����? ��� ��������� ������ ����� � ������!",
				11111 => "� ����� �����",
			);
		}
	}

	if ($sf == "mlhunter" && $ai[1] == 0) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "�� �� ����� ����� ���������� ������� ��� �����?",
					2 => "����� ������ ��� ������ ����. �� � �� ���� ��� ������, ��� ������� ���� ������ ����������, ��������� �� ����?",
				);
			} elseif ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "��������, ������ ���, �� �� ������ ����� � ����! � �� ������ ���������� �� ����� � �����! ���� ������ ��������� - ��� ��� ��� ���������� ������ � ������ ����������. �� � ����� ������, ������� ������ ��� ���� ������-������ ������ ����� ������ �������� ��� ������ ����� �����.",
					3 => "� ��� �����! ����� �������!",
				);
			} elseif ($_GET['qaction'] == 3) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[1] = 1;
				UpdateQuestInfo($user,24,implode("/",$ai)) or QuestDie();

				mysql_query('COMMIT') or QuestDie();			
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
				1 => "��������! ������! ��������� ��������� ��� � �������� ���������-����������� � � ���, ��� ������� ������� �������� ������� ��� ������ ������, ��� �� ������ ����� � �������. ���������� ��������� ������� ����� �� �������� ��� ����!",
				11111 => "��� ���� ����, �� �������.",
			);
		}
	}


	if ($sf == "mlhunter" && $ai[1] == 1) {
		$mlqfound = false;
		$todel = QItemExistsCountID($user,3003042,5);
		if ($todel !== FALSE) $mlqfound = true;

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "��, ��� ��� ��� ��, ��� �����! ����� �����������, ��� �� �� ���� ������� ������ ���� ���������� �������.",
					2 => "�������! ������� �������! ����!",
				);
			} elseif ($_GET['qaction'] == 2 && $mlqfound) {
				mysql_query('START TRANSACTION') or QuestDie();
				$ai[1] = 2;
				UpdateQuestInfo($user,24,implode("/",$ai)) or QuestDie();
				PutQItem($user,3003086,"�������",0,$todel) or QuestDie();
				addchp ('<font color=red>��������!</font> ������� ������� ��� <b>���� ����������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
				mysql_query('COMMIT') or QuestDie();			
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��� ��, ��� � ������?",
				1 => "��, ���, ����� ������� ����� ������? ������ �������, �� ������ �������.",
				11111 => "��� ���",
			);
			if (!$mlqfound) unset($mldiag[1]);
		}
	}

	if ($sf == "mlwitch" && $ai[1] == 2 && QItemExists($user,3003042)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, � ���������� ��� �� ������ ��� ����� ���������. �� �� ������ ��� ����. �����-�� ���� ���� � ���� � ���������. � � ��� ���, ��� ��������� ������� � ����� �����, ��� ����� ��������. �����, ������� �� ����, � �����, � ����� � ��� ��� ���������, �� ����. �� � ���������� ��� ������ � ��� ������. � �� ����� �� ��� ���������, ������ ���� � ������ �� �������?",
					2 => "�������, � ��� ��! ��� ����� ���� ������� ������, ������.",
					
				);
			} elseif ($_GET['qaction'] == 3) {
				// �������� 20 �� �� �����
				mysql_query('START TRANSACTION') or QuestDie();				
				$rec = array();
	    			$rec['owner']=$user[id];
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money']+20;
				$rec['target']=0;
				$rec['target_login']="������";
				$rec['type']=259; // ������� ������ �� ���������
				$rec['sum_kr']=20;
				add_to_new_delo($rec) or QuestDie(); //�����

				// �������� ������
				mysql_query('UPDATE oldbk.`users` set money = money + 20 WHERE id = '.$user['id']) or QuestDie();

				// �������� ��� �����
				$it = QItemExistsID($user,3003042);
				PutQItemTo($user,'������',$it) or QuestDie();

				// ��������
				addchp ('<font color=red>��������!</font> ������ �������� ��� <b>20 ��.</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				$ai[1] = 2;
				UpdateQuestInfo($user,24,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 2) {
				$mldiag = array(
					0 => "��, ��� ��� �� �������. ��� �� ������, ��� �� ��� ��������. � ����� ������ ���� �������� �� ������� ������ �������. �����, �� ��� �� �������? ����� �� �������, 20 �������� �� ��� ���� ���. �������?",
					3 => "������, �������, ����� ��� ���, ������ ����� ��������. � ������ ��� �������� ������. ������� ���� �����.",
				);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��������� ����� �� ��� ��������� �����, � ���� ���-�� ����. ��� ������� ���� � ��� ����?",
				1 => "� � ���� � ����� ��������. ������ � ������� �� ���� � ����� ������������� �� ����, ��� ��������. ��������� �������, ��� ��� � ���������� ��� ����� ����. � �� ��� ������� �� ����?",
				11111 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}	
	}
?>