<?php
	// ����� �������� ������
	$q_status = array(
		0 => "�������� ������� 10 �������� ���� (%N1%/10), 2 ����� ����� ������� (%N2%/2), ��������� ������ ���� (%N3%/1) � ����������� ������ (%N4%/1).",
		1 => "������� � ����������� �� ������������ ������� � ��������� � ��������.",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 18) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlvillage") {
		if (((isset($_GET['quest']) && $_GET['quest'] == 3) || (isset($_GET['qaction']) && is_numeric($_GET['qaction']) && $_GET['qaction'] > 2000 && $_GET['qaction'] < 3000))) {
			$mlqfound = false;
			$qi1 = QItemExistsCountID($user,3003005,10);
			$qi2 = QItemExistsCountID($user,3003067,2);
			$qi3 = QItemExistsID($user,3003034);
			$qi4 = QItemExistsID($user,3003050);
			if ($qi1 !== FALSE && $qi2 !== FALSE && $qi3 !== FALSE && $qi4 !== FALSE) {
				$mlqfound = true;
				$todel = array_merge($qi1,$qi2,$qi3,$qi4);
			}

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 2001 && $mlqfound) {
					$mldiag = array(
						0 => "��� �������, ����� ���-��� �������! ���������� ������ �������� � ����� ����� ���������� � ������. �� ���� ���, ������ ������ ������ ������ ������������ ����� ����. ����� ���� ������� � ������ � �����. � � ������� �����.",
						2002 => "�������, ��� ��������",
					);
				} elseif ($_GET['qaction'] == 2066) {
					mysql_query('START TRANSACTION') or QuestDie();
					unsetQuest($user) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					unsetQA();				
				} elseif ($_GET['qaction'] == 2002 && $mlqfound) {
					// �������
					mysql_query('START TRANSACTION') or QuestDie();
	
					$r = AddQuestRep($user,200) or QuestDie();
					$m = AddQuestM($user,1,"������") or QuestDie();
					$e = AddQuestExp($user) or QuestDie();
	
					PutQItem($user,15564,"������",0,$todel,255,"eshop") or QuestDie();

					$msg = "<font color=red>��������!</font> �� �������� <b>������� ������ ������� �����</b>, <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
					addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

	
					UnsetQuest($user) or QuestDie();
					UnsetQA();
					mysql_query('COMMIT') or QuestDie();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��� ��, ��� � ������?",
					2001 => "��, ��� ����������� �����, ����� ��������� ������ ����, ����� ������� � ����.",
					2066 => "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)",
					2002 => "���, � ��� �� ��� �����. ����� ������.",
				);
				if (!$mlqfound) unset($mldiag[2001]);
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
				echo '<script>location.href="mlboat.php";</script>';
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

	if ($sf == "mlbuyer") {
		if (!$questexist['addinfo']) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(
						0 => "�������, ��������? ��, ���� ���������. � � ��� �� ��� ������� ���� ����� ������, �� ������ �� � ���� ������ ����������. ������-������ � ������� � ���������, �� �� ������. ���� ������� ������� �� � �����������, �������� ���� �����.",
						2 => "������, � ����� ���� ���� �������.",
						3 => "���, ��� ������� ������, � ����� ������ �� ����� �����.",
					);
				} elseif ($_GET['qaction'] == 2) {
					mysql_query('START TRANSACTION') or QuestDie();				
					UpdateQuestInfo($user,18,"1") or QuestDie();	
					mysql_query('COMMIT') or QuestDie();			
					unsetQA();
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "�������, �������. ����� � ����� ���������?",
					33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
					1 => "������� ��� �����������, ������� � ���� ����� �����. �� ��������?",
					11111 => "������ ����������, ������ �������� ����. ����� ������."
				);
			}
		} elseif ($questexist['addinfo'] == 1) {
			$mlqfound = false;
			$todel =  QItemExistsID($user,3003068);
			if ($todel !== FALSE) $mlqfound = true;

			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1 && $mlqfound) {
					$mldiag = array(
						0 => "��, ��� �����! ��, ��� �, ������ ������ �����. ����� �������� ������, �� ������ ����� �� �������, � �� ������ ��� ���� �� �������, �� ��� ���� �������.",
						2 => "�������, ��� ��������."
					);
				} elseif ($_GET['qaction'] == 2 && $mlqfound) {
					mysql_query('START TRANSACTION') or QuestDie();

					PutQItem($user,3003034,"�������",0,$todel) or QuestDie();

					UpdateQuestInfo($user,18,"2") or QuestDie();	
	
					addchp ('<font color=red>��������!</font> ������� ������� ��� <b>����������� �����</b>','{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

					mysql_query('COMMIT') or QuestDie();
					unsetQA();

				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "������, �� ������ ��, ��� � ������?",
					1 => "��, ��� ���� ������� � ������������ �������. �� ������ ��� ��������.",
					11111 => "���, � ��� �� ��� ������. ����� ������.",
				);
				if (!$mlqfound) unset($mldiag[1]);
			}
		} else {
			$mldiag = array(
				0 => "�������, �������. ����� � ����� ���������?",
				33333 => "���� � ���� ���-��� ��� ���� ����������. �� ������ ����������, � ����� � ������?",
				11111 => "������ ����������, ������ �������� ����. ����� ������."
			);
		}
	}

	if ($sf == "mlrouge" && $questexist['addinfo'] == 1 && !QItemExists($user,3003068)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "��, ��, ����� ��������� �� ���������� � ��� ���������! ����� � ��� ��� ����� ������ �� �������. �� � ������ ����� � ���� ����������. ��, ��� �� ����� ������, ����� �� ����!",
					3 => "������, ��������� ��� ����.",
					2 => "��.. �, �������, �����",
				);	
			} elseif ($_GET['qaction'] == 3) {
				// �������� ��� � �������
				mysql_query('START TRANSACTION') or QuestDie();
				StartQuestBattleCount($user,535, mt_rand(2,3)) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				Redirect("fbattle.php");
				unsetQA();			
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��������-��, � ��� ����� �� ������! ��� ������, �� ���� �� ��� �����.  � ��� �� ������� ���� � ��� ���?",
				1 => "�� �� �������� �. � ������ � � ��� ������� ��, ��� ��� �� �����������. ������� ����������� ���� �������� �������. ��� ����� ������� ��� ������ ������.",
				2 => "������, ������ ���� ��������. ������.",
			);
		}	
	}
?>