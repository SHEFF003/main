<?php
	// ����� �������
	$q_status = array(
		0 => "������ ��� ���������� ���.",
	);
	
	if (!isset($questexist) || $questexist === FALSE || $questexist['q_id'] != 11) return;

	$step = $questexist['step'];

	$sf = basename(basename($_SERVER['PHP_SELF']),".php");

	if ($sf == "mlfort") {
		$mlqfound = false;
		$todel = QItemExistsID($user,3003039);
		if ($todel !== FALSE) $mlqfound = true;

		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1 && $step == 4 && $mlqfound) {
				$mldiag = array(
					0 => "�� ��, ����� ������! ������ ������� ���� �� �� �� ������, �� ������ ��� �������� ������� � ��������������. � ����, �����, ������� ��������� �� ��������. ������ ���� ������, ��� � ��� ��������.",
					10 => "�������, ������ ����� ������ (�������� �������)",
				);
			} elseif ($_GET['qaction'] == 10 && $step == 4 && $mlqfound) {
				// �������� ������� � �������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,200) or QuestDie();
				$m = AddQuestM($user,3,"��������") or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				PutQItemTo($user,"��������",$todel) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>".$r."</b> ���������, <b>".$e."</b> ����� � <b>".$m."</b> ��. �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 11 && $step == 4 && !$mlqfound) {
				// �������� ������� ��� ������
				mysql_query('START TRANSACTION') or QuestDie();

				$r = AddQuestRep($user,200) or QuestDie();
				$e = AddQuestExp($user) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>".$r."</b> ���������, <b>".$e."</b> ����� �� ���������� ������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} elseif ($_GET['qaction'] == 2 && $step == 4 && !$mlqfound) {
				$mldiag = array(
					0 => "��� � ����� �������� ������ �� � ���� ����, �� ���� ���������, � ���� �� ��������,  ��� ��� ��������, ������ � ������ ��� ��� ������� ������������. ��, ��� � � �������, ��� �� �� �������� �������������� � �����������. ������� ���������� � ���� ��� � ������ ����������� ��������. � �� ������ ����, ����� ��������� �������.",
					11 => "�������, ������ ����� ������ (�������� �������)",
				);
			} elseif ($_GET['qaction'] == 5) {
				mysql_query('START TRANSACTION') or QuestDie();
				unsetQuest($user) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();				
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, �� ������ ��, � ��� � ������?",
			);
			if ($step == 4) {
				if ($mlqfound) {
					$mldiag[1] = "��,  ��� ������, ������� ���� �� ������ � ����������� ���� � ��������";
				} else {
					$mldiag[2] = "��, � ��� ��������, �� � ����� ����������� ���� � �������� ���� ���.";
				}
				
			}
			$mldiag[5] = "���, � ���� ���������� �� ������� (� ����, ��� ����� ����� ��������� ������ ����� 20 �����)";
			$mldiag[11111] = "���, � ��� �� �����, ����� ������.";
		}	
	}

	if ($step == 0 && (isset($_GET['quest']) && $_GET['quest'] == 1 || isset($_GET['qaction']) && $_GET['qaction'] < 1000)) {
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				$mldiag = array(
					0 => "�� ��, ���������. ����� ���, ����� ����? �������� � ��� � ��������� ����� ������ ����, ��� ��. �� ������ �� ��� �� ������, ����� ��� ���� ����������� ������� �� ������. ��������!!!...",
					3 => "�� ���, � � ������ ���� ������. �������, �� �� ����� �������� � �����������. �� ����� 10 ����� ������� ��� ������� ������ � ���� ������?",
				);
			} elseif ($_GET['qaction'] == 5 && $user['money'] >= 10) {
					mysql_query('START TRANSACTION') or QuestDie();
					$rec = array();
		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-10;
					$rec['target']=0;
					$rec['target_login']="����������";
					$rec['type']=252; // ����� ���������� ����
					$rec['sum_kr']=10;
					add_to_new_delo($rec) or QuestDie(); //�����

					// �������� ������
					mysql_query('UPDATE oldbk.`users` set money = money - 10 WHERE id = '.$user['id']) or QuestDie();

					SetQuestStep($user,11,1) or QuestDie();
					$step = 1;
					$_GET['qaction'] = 1;
					mysql_query('COMMIT') or QuestDie();
			} elseif ($_GET['qaction'] == 4) {
					$mldiag = array(
						0 => "��, ������, ���� �������. �� ����� ���-��� �������. � ���� ���� ���� ��������� � ����� ������� ������ �������. ��� ��� �� ��� ��������� � ��������, � �������� ��� ���� ������ ����� �������. ���� ������, ����� 10 �������� � ������ �������� ���� ���� � �����.",
					);
					if ($user['money'] >= 10) $mldiag[5] = "��, ��� ������, � �������� �������� � ���� � ���.";
					$mldiag[6] = "������, �� � ���� ��� ������ ������� �����.";
			} elseif ($_GET['qaction'] == 3) {
				$mldiag = array(
					0 => "��� ������ ��������? ����, �� ������� ���������. �� �����, ��������. �������, �� ����� ����, � �� ����� � ���� ������� ��������.",
					4 => "��� ��, �������, �� ����, ������ ������ �������."
				);
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "������, ������ � ���� �������� ������ ����. �� ������������ ��� �� ����?",
				1 => "�� ������ �� ����, �� � ���������. ����� ����� � �����-�� ����, ������� � ���� � �������� ������. � �������, ��� ���� �� ��� ��� �����-�� ���������. � ���� ��������, ����� ������� �������.",
				2 => "������ ����������, ������ �������� ����. ����� ������.",
			);
		}	
	}

	if ($step == 1 && (isset($_GET['quest']) && $_GET['quest'] == 1 || isset($_GET['qaction']) && $_GET['qaction'] < 1000)) {
		$ai = explode("/",$questexist['addinfo']);
		for ($i = 0; $i < count($ai); $i++) {
			if ($ai[$i] == 1) {
				// �������� �����
				mysql_query('START TRANSACTION') or QuestDie();
				SetQuestStep($user,11,2) or QuestDie();
				$step = 2;
				mysql_query('COMMIT') or QuestDie();
				unset($_GET['qaction']);
			}
		}

		$bgood = true;
		for ($i = 0; $i < count($ai); $i++) {
			if ($ai[$i] != 2) {
				$bgood = false;
			}
		}
		if ($bgood) {
			// ������� ����
			mysql_query('START TRANSACTION') or QuestDie();
			SetQuestStep($user,11,3) or QuestDie();
			mysql_query('COMMIT') or QuestDie();
			$step = 3;
			unset($_GET['qaction']);
		}


		if ($step == 1) {
			if (isset($_GET['qaction'])) {
				if ($_GET['qaction'] == 1) {
					$mldiag = array(0 => "�������");
					if ($ai[0] == 0) $mldiag[2] = "�������� 1";
					if ($ai[1] == 0) $mldiag[3] = "�������� 2";
					if ($ai[2] == 0) $mldiag[4] = "�������� 3";
					if ($ai[3] == 0) $mldiag[5] = "�������� 4";
					if ($ai[4] == 0) $mldiag[6] = "�������� 5";
				} elseif ($_GET['qaction'] == 6 && $ai[4] == 0) {
					// ����
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[4] = 1;					
					UpdateQuestInfo($user,11,implode("/",$ai)) or QuestDie();
					unsetQA();
					StartQuestBattle($user,531,array(
						'krit_mf' => 120,
						'akrit_mf' => 100,
						'uvor_mf' => 100,
						'auvor_mf' => 120,
						'bron1' => 16,
						'bron2' => 17,
						'bron3' => 13, 
						'bron4' => 14,
					)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					Redirect('fbattle.php');
				} elseif ($_GET['qaction'] == 5 && $ai[3] == 0) {
					// ����������
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[3] = 1;
					UpdateQuestInfo($user,11,implode("/",$ai)) or QuestDie();
					unsetQA();
					StartQuestBattle($user,531,array(
						'krit_mf' => 80,
						'akrit_mf' => 135,
						'uvor_mf' => 130,
						'auvor_mf' => 130,
						'bron1' => 16,
						'bron2' => 17,
						'bron3' => 13, 
						'bron4' => 14,
					)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					Redirect('fbattle.php');
				} elseif ($_GET['qaction'] == 4 && $ai[2] == 0) {
					// ��������
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[2] = 1;
					unsetQA();
					UpdateQuestInfo($user,11,implode("/",$ai)) or QuestDie();
					StartQuestBattle($user,531,array(
						'krit_mf' => 150,
						'akrit_mf' => 185,
						'uvor_mf' => 100,
						'auvor_mf' => 100,
						'bron1' => 16,
						'bron2' => 27,
						'bron3' => 13, 
						'bron4' => 14,
					)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					Redirect('fbattle.php');
				} elseif ($_GET['qaction'] == 3 && $ai[1] == 0) {
					// ������
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[1] = 1;
					UpdateQuestInfo($user,11,implode("/",$ai)) or QuestDie();
					unsetQA();
					StartQuestBattle($user,531,array(
						'krit_mf' => 150,
						'akrit_mf' => 50,
						'uvor_mf' => 50,
						'auvor_mf' => 150,
						'bron1' => 16,
						'bron2' => 17,
						'bron3' => 13, 
						'bron4' => 14,
					)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					Redirect('fbattle.php');
				} elseif ($_GET['qaction'] == 2 && $ai[0] == 0) {
					// ����
					mysql_query('START TRANSACTION') or QuestDie();
					$ai[0] = 1;
					UpdateQuestInfo($user,11,implode("/",$ai)) or QuestDie();
					unsetQA();
					StartQuestBattle($user,531,array(
						'krit_mf' => 150,
						'akrit_mf' => 155,
						'uvor_mf' => 86,
						'auvor_mf' => 141,
						'bron1' => 16,
						'bron2' => 17,
						'bron3' => 13, 
						'bron4' => 14,
					)) or QuestDie();
					mysql_query('COMMIT') or QuestDie();
					Redirect('fbattle.php');
				} else {
					unsetQA();
				}
			} else {
				$mldiag = array(
					0 => "��������? ������� ����������.",
					1 => "�����.",
				);
			}
		}
	}

	if ($step == 2 && (isset($_GET['quest']) && $_GET['quest'] == 1 || isset($_GET['qaction']) && $_GET['qaction'] < 1000)) {
		// ��������
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,105,"����������",7,array(),255,"shop",3) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������ �������</b> �� ������� � ����������� �������!";
				addchp ($msg,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or QuestDie();

				SetQuestStep($user,11,4) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA(); 
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "�� �� ����� �� �� ������� ����, ��� � ���� �����������. �� ������, ����� �����-������ � ��������� ��� ���� ������� ������. �� ������� ���� ��������� �� � ���, ����� �� ������ ��� ��������� ��������� � ������������.",
				1 => "�������, ��� ��������.",
			);
		}	
	}

	if ($step == 3 && (isset($_GET['quest']) && $_GET['quest'] == 1 || isset($_GET['qaction']) && $_GET['qaction'] < 1000)) {
		// ������� ����
		if (isset($_GET['qaction'])) {
			if ($_GET['qaction'] == 1) {
				// �������� �������
				mysql_query('START TRANSACTION') or QuestDie();
				PutQItem($user,3003039,"����������",0,array()) or QuestDie();

				$msg = "<font color=red>��������!</font> �� �������� <b>������ � ��������</b> �� ������� � ����������� �������!";

				SetQuestStep($user,11,4) or QuestDie();
				mysql_query('COMMIT') or QuestDie();
				unsetQA();
			} else {
				unsetQA();
			}
		} else {
			$mldiag = array(
				0 => "��, �� �� � �����! �� ����� �, ��� �� � ���� ����������. �� ��� �������, �� �������� ���� �������. ��� ����� ������ ������ ������ ������. � ��� ���������� ����� ����� ��������, ������� ���. ��, ��� ��������� ������ ������� �����.",
				1 => "�������� ������, �� � ������ ��� ���������! ",
			);
		}		
	}

?>