#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php";
//include '/www/capitalcity.oldbk.com/functions.php';
include '/www/capitalcity.oldbk.com/ruines_config.php';
include "/www/capitalcity.oldbk.com/fsystem.php";



if( !lockCreate("cron_move_job") ) {
   exit("Script already running.");
}
echo "Running move-bot ...\n";


	/// ������������ �����
	function MyDie($txt) {
		lockDestroy("cron_move_job");
		die();
	}

	function CronRuinesBotMove() {
		$attacktime = 60*3; // �������� �� ��������� ��� �����

		global $rooms,$team_colors;
		mysql_query('START TRANSACTION') or Mydie(mysql_error().":".__LINE__);

		// �������� ���� ����� �� � ��� � � ������ � ����� = 5
		$qb = mysql_query('SELECT * FROM `users_clons` WHERE `bot_online` = 5 AND `bot_room` BETWEEN 1000 AND 10000 AND battle = 0 FOR UPDATE') or Mydie(mysql_error().":".__LINE__);
		if (mysql_num_rows($qb) > 0) {
			while($bot = mysql_fetch_assoc($qb)) {
				$du = (int) ($bot['bot_room'] * 0.01);
				$du = $du * 100;
				$broom = $bot['bot_room'] - $du;
				$croom = $rooms[$broom];
				$directions = array();

				if ($croom[1]) $directions[] = $croom[1];
				if ($croom[2]) $directions[] = $croom[2];
				if ($croom[3]) $directions[] = $croom[3];
				if ($croom[4]) $directions[] = $croom[4];
				shuffle($directions);
				$newroom = array_shift($directions);
				$newbroom = $newroom+$du;

				// ���������
				$q = mysql_query('UPDATE `users_clons` SET `bot_room` = '.$newbroom.' WHERE `id` = '.$bot['id'].' AND `battle` = 0') or Mydie(mysql_error().":".__LINE__);
				if (TRUE) {
					// �������

					// ��� �������
					// ���� �� �������, � $bot['bot_room'] ��� ������ �������
					$mids = array();
					$list = mysql_query('SELECT * FROM `users` WHERE `room` = '.$bot['bot_room'].' AND `in_tower` = 2') or Mydie(mysql_error().":".__LINE__);
					while($u = mysql_fetch_assoc($list)) {
						$mids[] = $u['id'];
					}
					if (count($mids)) addch_group ('<font color=red>��������!</font> <B>'.$bot['login'].'</B> ���������� � <B>'.$rooms[$newroom][0].'</B>.',$mids);

					// ������ � �������
					$attack_list = array();
					$list = mysql_query('SELECT * FROM `users` WHERE `room` = '.$newbroom.' AND `in_tower` = 2') or Mydie(mysql_error().":".__LINE__);
					while($u = mysql_fetch_assoc($list)) {
						$attack_list[] = $u['id'];
					}
					if (count($attack_list)) addch_group('<font color=red>��������!</font> <B>'.$bot['login'].'</B> ����� � �������.',$attack_list);
					
					// ���������
					if (count($attack_list) && mt_rand(0,5) == 3) {
						// �������� ������
						shuffle($attack_list);
						$jert_id = array_shift($attack_list);

						$q = mysql_query('SELECT * FROM `users` WHERE `id` = "'.$jert_id.'" FOR UPDATE') or Mydie(mysql_error().":".__LINE__);
						if (mysql_num_rows($q)) {
							$jert = mysql_fetch_assoc($q);

							// ��������� ����� ������ 3 ������ � ������� ������ �����
							$qt = mysql_query('SELECT * FROM `ruines_map` WHERE id = '.$jert['ruines']) or Mydie(mysql_error().":".__LINE__);
							$map = mysql_fetch_assoc($qt);

							
							if (($map['starttime'] + $attacktime) < time()) {
								// ������ ���� ��� ����
								mysql_query('UPDATE `users_clons` SET `hp` = `maxhp` WHERE `id` = '.$bot['id']) or Mydie(mysql_error().":".__LINE__);
	
								if($jert['battle'] == 0) {
									if ($jert['battle_fin'] == 0)  {
										// ����
										if ($jert['hp'] == 0) {
											mysql_query('UPDATE `users` SET `hp` = 2 WHERE `id` = '.$jert['id']) or Mydie(mysql_error().":".__LINE__);
										}
		
										mysql_query('UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = '.time().' WHERE  `hp` > `maxhp` AND `id` = '.$jert['id']) or Mydie(mysql_error().":".__LINE__);
		
										mysql_query('INSERT INTO `battle` (`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`win`,`t1hist`,`t2hist`,`blood`,`CHAOS`)
												VALUES
												(
													"��� � ������",
													"",
													"'.mt_rand(1,3).'",
													"11",
													"0",
													"'.$bot['id'].'",
													"'.$jert['id'].'",
													"'.time().'",
													"'.time().'",
													3,
													"'.mysql_real_escape_string(BNewHist($bot)).'",
													"'.mysql_real_escape_string(BNewHist($jert)).'",
													"0","0"
												)
										') or Mydie(mysql_error().":".__LINE__);
				
										$id = mysql_insert_id();
				
										// ������ ��������� ���� � ���������� ��� �� � ���
										mysql_query('UPDATE `users_clons` SET `battle` = '.$id.', `battle_t` = 1  WHERE `id`= '.$bot['id']) or Mydie(mysql_error().":".__LINE__);
										mysql_query('UPDATE `users` SET `battle` = '.$id.', `battle_t` = 2  WHERE `id`= '.$jert['id']) or Mydie(mysql_error().":".__LINE__);
				
										addch('<img src=i/magic/attack.gif> <b>'.$bot['login'].'</b>, �������� ����� ���������, �������� ����� �� <b>'.$jert['login'].'</b>.',$newbroom);
										$p2 = '<b>'.nick_align_klan($bot).'</b> � <b>'.nick_align_klan($jert).'</b>';
										//addlog($id,'���� ���������� <span class=date>'.date("Y.m.d H.i").'</span>, ����� '.$p2.' ������� ����� ���� �����. <BR>');
										addlog($id,"!:S:".time().":".BNewHist($bot).":".BNewHist($jert)."\n");

										// ���
										$log = '<span class=date>'.date("d.m.y H:i").'</span> '.nick_hist($bot).' ����� �� <font color='.$team_colors[$jert['id_grup']].'>'.nick_hist($jert).'</font> ��������� <a href="logs.php?log='.$id.'" target="_blank">��� ��</a><BR>';
										mysql_query('UPDATE `ruines_log` SET `log` = CONCAT(`log`,"'.mysql_real_escape_string($log).'") WHERE id = '.$map['id']) or Mydie(mysql_error().":".__LINE__);
	
										// ��������� ���� �����
										addchp ('<font color=red>��������!</font> �� ��� ����� <b>'.$bot['login'].'</b>.<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);
									}
								} else {
									// ������� ��� ������
									$q = mysql_query('SELECT * FROM `battle` WHERE `id` = '.$jert['battle']) or Mydie(mysql_error().":".__LINE__);
									if (mysql_num_rows($q)) {
										$bd = mysql_fetch_assoc($q);
										
										$t1 = explode(";",$bd['t1']);
	
										// ����������� ���-���
										if ($jert['battle_t'] == 1) {
											$meteam = 2;
											$enemyteam = 1;
										} else {
											$meteam = 1;
											$enemyteam = 2;
										}
	
										addch('<img src=i/magic/attack.gif> <b>'.$bot['login'].'</b> �������� � <a href=logs.php?log='.$jert['battle'].' target=_blank>�������� ��</a>.',$newbroom);
										//addlog($jert['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle_hist($bot,$meteam).' �������� � ��������!<BR>');
										$bot[battle_t]=$meteam;
										$ac=($bot[sex]*100)+mt_rand(1,2);
//										addlog($jert['battle'],"!:V:".time().":".nick_new_in_battle($bot).":".$ac."\n");			
										addlog($jert['battle'],"!:W:".time().":".BNewHist($bot).":".$bot[battle_t].":".$ac."\n");															
										
	
										// ��������� ���� � ������ ���
										mysql_query('UPDATE `battle` SET `t'.$meteam.'` = CONCAT(`t'.$meteam.'`,";'.$bot['id'].'"),  `t'.$meteam.'hist`= CONCAT(`t'.$meteam.'hist`,",'.mysql_real_escape_string(BNewHist($bot)).'")  ,`to'.$meteam.'` = "'.time().'", `to'.$enemyteam.'` = "'.(time()-1).'"  WHERE `id` = '.$jert['battle']) or Mydie(mysql_error().":".__LINE__);

										// ���������� ���� ����� ���
										mysql_query('UPDATE `users_clons` SET `battle` = '.$jert['battle'].', `battle_t`= '.$meteam.' WHERE `id`= '.$bot['id']) or Mydie(mysql_error().":".__LINE__);

										// ���
										$log = '<span class=date>'.date("d.m.y H:i").'</span>  '.nick_hist($bot).' �������� � �������� ������ <font color='.$team_colors[$jert['id_grup']].'>'.nick_hist($jert).'</font> <a href="logs.php?log='.$jert['battle'].'" target="_blank">��� ��</a><BR>';
										mysql_query('UPDATE `ruines_log` SET `log` = CONCAT(`log`,"'.mysql_real_escape_string($log).'") WHERE id = '.$map['id']) or Mydie(mysql_error().":".__LINE__);

		
										// ��������� ���� �����
										addchp ('<font color=red>��������!</font> �� ��� ����� <b>'.$bot['login'].'</b>.<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);
									}
								}
							}
						}
					}
				}
			}
		}
		mysql_query('COMMIT') or Mydie(mysql_error().":".__LINE__);
	}
	CronRuinesBotMove();




echo "Finishing script. Destroy lock.\n";
lockDestroy("cron_move_job");


?>