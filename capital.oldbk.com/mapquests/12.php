<?php
	// ����� �������� ��������
	$q_status = array(
		0 => "������� ���� ������ (����������, ����, ��������), �������� ��� �������� (%N1%/3) � ��������� � ����������.",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 12) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	$ai = explode("/",$questexist['addinfo']);

	if ($sf == "mlpost") {
		$mlqfound = false;
		$todel = QItemExistsCountID($user,3003041,3);
		if ($todel !== FALSE && $ai[0] == 1 && $ai[1] == 1 && $ai[2] == 1) {
			$mlqfound = true;
		}

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $mlqfound) {
				$mldiag = array(
					0 => "�������, �� ��� ����� �����! �� ���� ���� �������������. ������� ����, ��� ����.",
					3 => "������ ����� ������ (�������� �������)",
				);
			} elseif ($_GET['qaction'] == 3 && $mlqfound) {
				// ����� ������� �� �����
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,250) or QuestDie();
				$m = AddQuestM($user,2,"���������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				if ($user['level'] == 6) {
					$item = 33029;
				} elseif ($user['level'] == 7) {
					$item = 33030;
				} else {
					$item = 33031;
				}

				PutQItem($user,$item,"���������",0,$todel,255) or QuestDie();
				PutQItem($user,119,"���������",0,array(),255) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>���� �����</b>, <b>������������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 2) {
				// �������� ������
				$it = QItemExistsID($user,3003040);
				mysql_query('START TRANSACTION') or QuestDie();
				if ($it !== FALSE) {
					PutQItemTo($user,'���������',$it) or QuestDie();
				}

				// �������� ��������
				$it = QItemExistsID($user,3003041);
				if ($it !== FALSE) {
					PutQItemTo($user,'���������',$it) or QuestDie();
				}

				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��, ��� � ������?",
			);
			if ($mlqfound) $mldiag[1] = "��,  ��� ��� �������� � ��������� ����� � �� ����������, ���� � ��������. ������ ���, ��� �� ������.";
			$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
			$mldiag[1111] = "���, � ��� �� �����, ����� ������.";
		}
	}

	if ($sf == "mlwitch" && $ai[3] == 0 && QItemExists($user,3003042)) {
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

				$ai[3] = 1;
				UpdateQuestInfo($user,12,implode("/",$ai)) or QuestDie();
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

	if ($sf == "mlhunter" && $ai[0] == 0 && QItemExists($user,3003040)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1001) {
				$mldiag = array(
					0 => "��� �������, �� ������ ������� ��� �������. � ��� ����������� �����, ��� ������ �� �������, � ��� ����������� ��������� �������. ����� ������ ������ � ����� ��������. ���� ������ ����� ��� ������������ ��������. � � ���� � ������ ����������, ������ ����.",
					1002 => "������ �������, �������, �� ��� ��� ��������, ���� ���������� ��������.",
				);
			} elseif ($_GET['qaction'] == 1002) {
				// ��������
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003041,"�������",0,QItemExistsCountID($user,3003040,1)) or QuestDie();

				addchp ('<font color=red>��������!</font> ������� ������� ��� <b>��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				$ai[0] = 1;
				UpdateQuestInfo($user,12,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��, ������, �� ���� ���� � ��� �� ����, ���� ��� ����������?",
				1001 => "������ ���� ������ �� ����������. �� ��������, �� � ���������� ������ � ����, ��� � ������ ���� �������� �����.",
				11111 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}
	}

	if ($sf == "mlmage" && $ai[1] == 0 && QItemExists($user,3003040)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1001) {
				$mldiag = array(
					0 => "��� ����� ������ � � ����! ����� ���� ������ � ����������, � �� ����� ��� �� ����� � ����� �����������, ������� ���? ��� � ���� ���������� � ���� ������� �������.",
					1003 => "������ �������, �������, �� ��� ��� ��������, ���� ���������� ��������.",
				);
			} elseif ($_GET['qaction'] == 1003) {
				$mldiag = array(
					0 => "��������, �������, ����� � ��� � ����� ������ ���������. ������ ������ � ��������� ������� �� ������. ��� ���� �������� � �����, �� ������� ��� ������.",
					1002 => "�����, �� ���� ������.",
				);
			} elseif ($_GET['qaction'] == 1002) {
				// ��������
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003041,"���",0,QItemExistsCountID($user,3003040,1)) or QuestDie();

				addchp ('<font color=red>��������!</font> ��� ������� ��� <b>��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				$ai[1] = 1;
				UpdateQuestInfo($user,12,implode("/",$ai)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�� ����� ���� ����� ���������.  ����� ������ � �� ������ ����?  ������.",
				1001 => "������ ���� ����� ������� �� ����������. �� ��������, ������ ���� ��������. ",
				33333 => "�������, �� ������ ������� ���������� ����� �� ��������� �������. ���� ��������� ���� � ����� ������.",
				44444 => "� ������ ����� �����, ��� �� ������ ������� ���������� ���� �������. ���� ��� ������, �� ��� �� �� �������� ���������.",
				11111 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}
	}

	if ($sf == "mlvillage" && $ai[2] == 0 && QItemExists($user,3003040)) {
		if (((isset($_GET['quest']) && $_GET['quest'] == 2) || (isset($_GET['qaction']) && $_GET['qaction'] > 1000 && $_GET['qaction'] < 2000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1001) {
					$mldiag = array(
						0 => "��� �������, � ���-��� ���� ���� �����. ��� �-� ���������� ��������, � � �� ������ ��������� ��� � ����� �������� �������. ����� �������� � ������ � �����.",
						1002 => "����� ��������, ������ ����",
					);
				} elseif ($_GET['qaction'] == 1002) {
					// ��������
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003041,"���������",0,QItemExistsCountID($user,3003040,1)) or QuestDie();
	
					addchp ('<font color=red>��������!</font> ��������� ������� ��� <b>��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
	
					$ai[2] = 1;
					UpdateQuestInfo($user,12,implode("/",$ai)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "����������� ����, ������, � ����� �������� �������. ������ �� �� ������� ������� � ��������� � ��������� ������ ��� ���������� �� ���� � ����� ������ ���������?",
					1001 => "� � ���� � ������� �� ����������, ������ ����. �� �������� � ������ ���� �������� �����. ��� ���� ������, � ���������, � ���������.",
					11111 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}

?>