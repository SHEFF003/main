<?php
	// ����� �������� ��������
	$q_status = array(
		0 => "�������� �������� �������� �� ������ (%N1%/1).",
		1 => "�������� ������ 5 �������� ������� (%N1%/5), ����� ������� (%N2%/1) � ����� (%N3%/1).",
	);
	

	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 1) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlhunter") {
		// ����� ��������� ������� ��������
		$mlqfound = false;
		$todel = QItemExistsID($user,3003004);
		if ($todel !== FALSE) $mlqfound = true;

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == "1" && $mlqfound) {
				$mldiag = array(
					"0" => "���, �������, ������ � ������ ������ �� ����! �� ���� ���� �������������. ���� ���� � ������� ����� �������� ��������������� ����������. �� ���� ������ � �������� ���� ������ ������, ������� ������� ���� ����������� �������.",
					"111" => "�������� �������",
				);
			} elseif ($_GET['qaction'] == "2") {
				mysql_query('START TRANSACTION') or QuestDie();
				UnsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				UnsetQA();			
			} elseif ($_GET['qaction'] == "111" && $mlqfound) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,150) or QuestDie();
				$m = AddQuestM($user,1,"�������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItem($user,105,"�������",7,$todel,255,'shop',3) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				UnsetQuest($user) or QuestDie();
				UnsetQA();
				mysql_query('COMMIT') or QuestDie();				
			} else {
				UnsetQA();
			}
		} else {
			$mldiag = array(
				"0" => "������, �� ������ ��� ��, ��� � ������?",
			);		
			
			if ($mlqfound) $mldiag[1] = "��, ��� ���� �������� �� ������. �������, ��� ���� �������.";
			
			$mldiag[2] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)"; 
			$mldiag[3] = "���, � ��� �� ��� ������. ����� ������."; 
		}
	}

	if ($sf == "mlwitch") {
		if ($step == 0) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == "1") {
					$mldiag = array(
						"0" => "��� ���? ��� ����� ���������� ��� ������� ������. �� ���-�, ��� ������, ��� ��  �����, ���� ������� �� ������. ��� � ������ ������ ������, �� ��� ����, � ����  ��� ���������� ����� ��� ��� ������������. ���� �� ��������� ��� 5 �������� �������, ����� ������� � �����, � ��� ������ ����������, � ������� ����� �������.",
						"3" => "������, � ������� ���� ���, ��� �����.",
						"4" => "���, ��� ������� ������, � ����� ������ �� ����� �����.",
					);
				} elseif ($_GET['qaction'] == "3") {
					mysql_query('START TRANSACTION') or QuestDie();
					SetQuestStep($user,1,1) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					UnsetQA();
				} else {
					UnsetQA();
				}
			} else {
				$mldiag = array(
					"0" => "�������, �������, ��������� � ��� ������� ���� � ��� ����?",
					"1" => "������� ������ �������, ������ �������� ��� �������� �� ����.",
					"2" => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		} elseif ($step == 1) {
			// ����� ��������� ������� �������� �������, ����� � ������
			$mlqfound = false;
			$qi1 = QItemExistsID($user,3003001);
			$qi2 = QItemExistsCountID($user,3003002,5);
			$qi3 = QItemExistsID($user,3003003);

			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					// ����� �������� ��������
					mysql_query('START TRANSACTION') or QuestDie();
					PutQItem($user,3003004,"������",0,$todel) or QuestDie();;

					addchp ('<font color=red>��������!</font> ������ �������� ��� <b>�������� ��������</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					SetQuestStep($user,1,2) or QuestDie();;
                                        mysql_query('COMMIT') or QuestDie();
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � �������?",
				);

				if ($mlqfound) $mldiag[1] = "��, ��� ����� ���, ��� ����� ��� �����.";
	
				$mldiag[2] = "���, � ��� �� ��� ������. ����� ������.";
			}
		} elseif (isset($_GET['qaction'])) {
			UnsetQA();
		}
	}

	if ($sf == "mlvillage") {
		// 3003001 - �����

		if ($step == 1 && !QItemExists($user,3003001) && ((isset($_GET['quest']) && $_GET['quest'] == 1) || (isset($_GET['qaction']) && $_GET['qaction'] < 1000))) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == "1") {
					$mldiag = array(
						0 => "����� ��� ������ ������ ��������� �� ��� ����-��. ���� �����, ��� ��� � ���� ������� ������. ���� ������������, ��� ����� ��������, �� ��� �� ���, � �� ��������� ������� �� ������, ������� � ���������� ����. � ��� � �� �����, ����� �� ������������� �������. �� �� �����, ��� ����� �� ���� � �� ��������. �����-�� ��� �������� ���� �� �������� �������, � ����� � �����. ���� �� ������ �����, ������� ��� 1 �� � �������� ���������. �� ���� � ���� ��� �����, � �� �������� ���� ���������� �������,  � �������� � ���� ���������, � ���� ����� ������� ������. ���� ������� ��� ������, � ��� ���� ����� � �������. ",
					);

					if ($user['money'] >= 1) $mldiag[3] = "��������� 1 �� � ����� �����";
					if ($user['hp'] >= 2) $mldiag[4] = "��������� � ���������";

					$mldiag[5] = "����������� � ����.";
				} elseif ($_GET['qaction'] == 3 && $user['money'] >= 1) {
					mysql_query('START TRANSACTION') or QuestDie();					
					$rec = array();
		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-1;
					$rec['target']=0;
					$rec['target_login']="����������";
					$rec['type']=252; // ����� ���������� ����
					$rec['sum_kr']=1;
					add_to_new_delo($rec) or QuestDie();

					// �������� ������
					mysql_query('UPDATE oldbk.`users` set money = money - 1 WHERE id = '.$user['id']) or QuestDie();

					// ��� ����
					PutQItem($user,3003001,"����������") or QuestDie();

					// ��������
					addchp ('<font color=red>��������!</font> ���������� ������� ��� <b>�����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();
					unsetQA();
					mysql_query('COMMIT') or QuestDie();
				} elseif ($_GET['qaction'] == 4 && $user['hp'] >= 2) {
					// 530 - ��������
					mysql_query('START TRANSACTION') or QuestDie();
					StartQuestBattle($user,531) or QuestDie();
					mysql_query('COMMIT') or QuestDie();					
					Redirect('fbattle.php');
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
					1 => "�� ����. ������ ����� ����� ��� ��������� ��������. � ���� ����?",
					2 => "������ ����������, ������ �������� ����. ����� ������.",
				);
			}
		}
	}
?>