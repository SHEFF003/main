<?php

	$to = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE login = "'.$_POST['target'].'" and room = '.$user['room'].' and id != '.$user['id']));

	if ($to) {
		$sex[0] = "������";
		$sex[1] = "�����";

		$mesta = array("������","������","���","���","����","���","����");

		$mesto = $mesta[mt_rand(0,count($mesta)-1)];

		addch('<img src=i/magic/tomat.gif>�������� &quot;<b>'.$user['login'].'</b>&quot; '.$sex[$user['sex']].' ��������� � &quot;<b>'.$to['login'].'</b>&quot;, ����� ����� � '.$mesto.'!') or die();
		addchp ('<font color=red>��������!</font> �������� &quot;<b>'.$user['login'].'</b>&quot; ����� � ��� ���������. ������� ������: ��������������� �����','{[]}'.$to['login'].'{[]}',$to['room'],$to['id_city']);


		$add_time_eff=time()+($magic['time']*60);

		$female_obraz = array(1,3,6);
		$male_obraz = array(2,4,5,7,8,9);

		if ($to['sex'] == 0) {
			$skin_id = '1april_obrazevent_0'.$female_obraz[mt_rand(0,count($female_obraz)-1)];
		} else {
			$skin_id = '1april_obrazevent_0'.$male_obraz[mt_rand(0,count($male_obraz)-1)];
		}

		mysql_query('DELETE FROM effects WHERE owner = '.$to['id'].' and type = 301 LIMIT 1');
		mysql_query("INSERT INTO `effects` SET `type`= '301',`name`='���������� �����, ���������� � ���� ������� ������� ��������',`time`='{$add_time_eff}',`owner`='{$to[id]}', add_info='".$skin_id."'");

		$bet=1;
		$sbet=1;
		$MAGIC_OK=1;
		echo '�� ������������ �������.';

        try {
            global $app;
            $User = new \components\models\User($user);
            $Quest = $app->quest
                ->setUser($User)
                ->get();
            $Checker = new \components\Component\Quests\check\CheckerMagic();
            $Checker->magic_id = 300413;
            if(($Item = $Quest->isNeed($Checker)) !== false) {
                $Quest->taskUp($Item);
            }
        } catch (Exception $ex) {
            \components\Helper\FileHelper::writeArray(array(
                'magic' => '5276',
                'error' => $ex->getMessage(),
                'trace' => $ex->getTraceAsString()
            ), 'error_log');
        }

	} else {
		echo '�������� �� ������ � ���� �������';
	}


/*



	$effect = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}'  and `type` = '301' LIMIT 1;")); 
	if (!$effect['id']) {			
		$add_time_eff=time()+($magic['time']*60);

		mysql_query("INSERT INTO `effects` SET `type`= '301',`name`='��������������� ����� - ���������� �����, ���������� � ���� ������� ������� ��������',`time`='{$add_time_eff}',`owner`='{$user[id]}', add_info='".$skin_id."'");

		$bet=1;
		$sbet=1;
		$MAGIC_OK=1;
		echo '�� ����������� �������.';
	} else {
		echo '� ��� ��� ���� ������������ �����.';
	}
	
*/
?>