<?php
	// ����� "����� ������ ��� ������"
	if (!isset($maprel)) {
		include('map_config.php');
	}

	$questexist = false;
	$q = mysql_query('SELECT * FROM map_quests WHERE owner = '.$user['id']) or die();
	if (mysql_num_rows($q) > 0) {
		$questexist = mysql_fetch_assoc($q) or die();
	}
	
	// 8�� �����
	if ($questexist !== FALSE && $questexist['q_id'] == 30 && $questexist['step'] == 6) {
		require_once('mlfunctions.php');
		mysql_query('START TRANSACTION');
		if (!SetQuestStep($user,30,7)) QuestDie();
		mysql_query('COMMIT');
		$bet = 1;
		$sbet = 1;
		echo '����� ������ ������ ������������, ������ �������� ����� ��� �������...';
	} else {
		echo '����� ������ ������������ �������...';
		$bet = 1;
	}
?>