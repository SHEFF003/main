<?php
if (!($_SESSION['uid'] >0)) header("Location: index.php");	
//����� ������ ��� ��������� 3-� ���������� ���
// �������� ������ ����
$myeff = getalleff($user['id']);
$deflastuse = 10;
// ������� ��� ������ �� ������� �� ����������
$rooms_jert_arkan=array (15,17,18,36,56,54,55); 

include "/www/capitalcity.oldbk.com/config_ko.php";


if ((time()-$_SESSION['last_attak_use']>=$deflastuse) OR (!(isset($_SESSION['last_attak_use'])))) {
	$_SESSION['last_attak_use']=time();//���������� ����� ���

	if ($user['battle'] > 0) {
		echo "�� � ���...";
		return;
	} elseif (isset($myeff['owntravma'])) {
		echo "� ����� �������, ������ �������!";
		return;
	} elseif (isset($myeff[830])) {
		echo "�� ���������� ��� ����������!";
		return;
	} elseif ($user['lab']>0 or $user['room'] == 45 or $user['room']==8 or $user['room']==90)  {
		echo "��������� � ���� ������� ���������!";
		return;
	} elseif (($user['room'] >=197)AND($user['room'] <=199)) {
		echo "��������� � ���� ������� ���������!";
		return;
	} elseif ($user['zayavka'] > 0) {
		echo "�� �������� ��������...";
		return;
	} elseif ($user['room'] == 60 || ($user['room'] >= 49998 && $user['room'] <= 53600) || ($user['room'] >= 70000 && $user['room'] <= 72001) || ($user['room'] >= 91 && $user['room'] <= 97)) {
		echo "��� ��� �� ��������...";
		return;
	} elseif (($user['room'] >=210)AND($user['room'] <=300)) {
		echo "��� ��� �� ��������...";
		return;
	} elseif (($user['room'] == 31) || $user['room'] == 43 || $user['room'] == 200 || $user['room'] == 10000) {
		echo "��������� � ���� ������� ���������!";
		return;
	} elseif ($user['hp'] < $user['maxhp']*0.33) {
		echo "�� ������� ��������� ��� ���������!";
		return;
	} elseif (($user['room'] != 1) and ($OARKAN)) {
		echo "�� ������ ������������ ����� ������ �������� � ������� ��� ��������!";
		return;
	} elseif ($user['room'] == 999 || $user['ruines'] > 0 || $user['in_tower'] > 0 || $user['room'] == 72) {
		echo "��������� � ���� ������� ���������!";
		return;
	}

	// ������� ������
	$is_bot = false;

	$q = mysql_query("SELECT * FROM `users` WHERE `login` = '".mysql_real_escape_string($_POST['target'])."' AND id != ".$user['id']) or die();
	if (mysql_num_rows($q) == 0) {
	
		echo "������ �� �������...";
		return;

		// ��������� �� ������
		$is_bot = true;
		$q = mysql_query("SELECT * FROM `users_clons` WHERE `login` = '{$_POST['target']}' LIMIT 1;") or die();
		if (mysql_num_rows($q) == 0) {
			echo "������ �� �������...";
			return;
		}
	}

	$jert = mysql_fetch_assoc($q);

	if (($jert['room']==23) AND ($jert['battle']==0)) {
		//�������� � �� � ���
		if (test_lic_mag($jert)) {
			$candoit=false;
		} else {
			$candoit=true;
		}
	} else {
		$candoit=true;
	}

	if ($candoit==false) { 
		err("� �������� ���������� �� ���� ������ ������� � ������ ���!"); 
		return;
	} elseif ($jert['klan'] =='pal' && $jert['battle'] == 0) {
		err("������ ������� �� �������� ���� �� �� � ���!");
		return;	
	} elseif ($jert['zayavka'] > 100000000) {
		err("�������� ��������� � ������� �� ��� �����������...");
		return;	
	}
	// ���� ���� � ��� - ��������� ��� � �������
	$bd = array();
	if ($jert['battle'] > 0) {
		if ($OARKAN) {
			echo "����� ��� ������ �����";
			return;
		}

		$bd = mysql_query('SELECT *, UNIX_TIMESTAMP(`date`) as udate FROM battle WHERE id = '.$jert['battle']) or die();
		$bd = mysql_fetch_assoc($bd);

		// ��������� ���
		if ($bd['type'] != 40 && $bd['type'] != 41) {
			echo "�� �� ������ ��������� � ���� ��� ����� ��������������";
			return;
		}

		if($bd['teams'] != '') {
			echo "��� ������ �� �������������... ".$bd['teams'];
			return;
		}

		$user_align=(int)($user['align']);
		$jert_align=(int)($jert['align']);
		if ($user_align == 1) {
			$user_align = 6;
		}
	
		if ($jert_align == 1) {
			$jert_align = 6;
		}
		// ��������� ��� ��� ����� ���������� �� ������ �������
//		$q = mysql_query('SELECT * FROM users WHERE battle_t = '.$jert['battle_t'].' and align = "'.$user['align'].'" and battle = '.$jert['battle']);
		
		if ($jert['battle_t']==1) { $za=2; } else {$za=1; }
		$q = mysql_query('SELECT * FROM users WHERE battle_t = '.$za.' and align = "'.$user_align.'" and battle = '.$jert['battle']);
		if (mysql_num_rows($q) == 0) 
		{
//			echo "������ ����������� � ��� ������ ����� ����������...";
			echo "������ ����������� � ��� �� ��� ����������...";
			return;
		}


	if (!(((time()>$KO_start_time46) and (time()<$KO_fin_time46)) ))  // '������ ����������';
		{
		$bd_levels=explode("|",$bd['damage']);
	
		if ( ($user['level'] != $bd_levels[0]) and ($user['level'] != $bd_levels[1]) )
		{
			if ($bd_levels[1]==$bd_levels[0])
			{
			echo "� ���� ��� ����� ����������� ������ ".$bd_levels[0]."�� ������. ��� ������� �� ��������� ��������� � ���� ���.";
			}
			else
			{
			echo "� ���� ��� ����� ����������� ������ ".$bd_levels[0]."�� � ".$bd_levels[1]."�� ������. ��� ������� �� ��������� ��������� � ���� ���.";
			}
			return;
		}
		}

	
		if (!($bd['status'] == 0 && $bd['win'] == 3 && $bd['t1_dead'] == "")) {
			echo "������ ���������...";
			return;
		}
	}

	// ��������� ������
	$user_align=(int)($user['align']);
	$jert_align=(int)($jert['align']);
	if ($user_align == 1) {
		$user_align = 6;
	}

	if ($jert_align == 1) {
		$jert_align = 6;
	}
	
	if (!$is_bot) {
		$jeff = getalleff($jert['id']);

		if ($jert['ldate'] < (time()-60) ) {
			echo "�������� �� � ����!";
			return;
		} elseif (($user['room'] != $jert['room'] || $jert['id_city'] != $user['id_city']) && !($OARKAN)) {
			echo "�������� � ������ �������!";
			return;
		} elseif (($OARKAN) and (!(in_array($jert['room'],$rooms_jert_arkan))) ) {
			echo "�������� �� ��������� � ����� �����������!";
			return;
		} elseif (isset($jeff[830])) {
			echo "�������� ��������� ��� ����������...";
			return;
		} elseif (isset($jeff['owntravma']) && !$jert['battle']) {
			echo "�������� ������ �����������...";
			return;
		} elseif ($jert['hp'] < $jert['maxhp']*0.33  && !$jert['battle']) {
			echo "������ ������� �����!";
			return;
		} elseif ($jert['deal'] > 0 && $jert['battle'] == 0) {
			echo "������ ������� �� ������!";
			return;
		} elseif ($jert['klan'] == "Adminion" || $jert['klan'] == "radminion" || $jert['id'] == 546433) {
			echo "�� �����...";
			return;
		} elseif ($jert['hp'] < 1  && $jert['battle']>0) {
			echo "�� �� ������ ������� �� ���������!";
			return;
		} elseif ($jert['align'] > 1 && $jert['align'] < 2 && $jert['battle'] == 0 && ($jert['room'] == 1 || $jert['room'] == 2 || $jert['room'] == 3 || $jert['room'] == 4)) {
			echo "�� �� ������ ������� �� �������� � ���� �������!";
			return;
		}

		if ($jert['battle'] == 0) 
		{
			/*if (!((($user['level']==($jert['level']-1)) OR ($user['level']==($jert['level'])) OR ($user['level']==($jert['level']+1) ) )  and ($jert['level']>8)))
			{
				echo "�������� ����� ������ �� ���� ������� ���  +/- 1 ������� �  �� ������ 9�� !";
				return;
			}*/
			
			if (!(((time()>$KO_start_time46) and (time()<$KO_fin_time46)) ))  // '������ ����������';
			{
				if (!((  ($user['level']==($jert['level']))  )  and ($jert['level']>8)))
				{
					echo "�������� ����� ������ �� ���� �������  �  �� ������ 9�� !";
					return;
				}
			}
		}
	
	} else {
		if ($jert['hp'] < 1  && $jert['battle']>0) {
			echo "�� �� ������ ������� �� ���������!";
			return;
		}
	}


	if ($user_align == $jert_align) {
		echo "������ �������� �� �����!";
		return;
	}

	if ($jert_align != 2 && $jert_align != 3 && $jert_align != 6) {
		echo "�� ������ �������� ������ �� ���������� �� �����������";
		return;
	}                                                                    

	if ($user_align != 2 && $user_align != 3 && $user_align != 6) {
		echo "�� �� ������ �������� ��� ����������";
		return;
	}                                                                    


	if ($OARKAN && $jert['level'] != $user['level'] && !$is_bot) {
		echo "�������� ����� ������ �� ���� �������!";
		return;
	}

	// �� ��, ��������
	if ($jert['battle'] > 0) {
	
		$za=($jert['battle_t']==1?2:1); 		

		$user['battle_t']=$za;
		$TEST_CAN_I_GO=can_i_go_battle($user,$bd,$za);
		if ($TEST_CAN_I_GO) {			
			// ���� ��� - ��������������
		
			$sstatus = "";
			if ($bd['type'] == 40) {
				if (users_in_battle($jert['battle']) >= 9) {
					$sstatus = 'coment="�������� ��������������", blood = 1, type = "41",';
				} 
			}
						
			$time = time();
			
			if ($jert['battle_t'] == 1) {
				$meteam = 2;
				$enemyteam = 1;
			} else {
				$meteam = 1;
				$enemyteam = 2;
			}
						
			$za = $meteam;
			mysql_query('UPDATE `battle` SET '.$sstatus.' to1='.$time.', to2='.$time.', `t'.$za.'`=CONCAT(`t'.$za.'`,\';'.$user['id'].'\') , `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($user).'\') WHERE `id` = '.$jert['battle'].' and status=0 and win=3 and t1_dead="" ;');
						
			if (mysql_affected_rows()>0) {
				  //������ ������
				  $need_update_user = true;
			} else {
				  $need_update_user = false;
			}
						
						
			if ($need_update_user) {
				$sexi[0] = '���������';
				$sexi[1] = '��������';
				
				if (($user['hidden'] > 0)and($user['hiddenlog'] =='') ) { 
					$usrlogin='<i>���������</i>'; 
					$user[sex]=1;
					$doit_txt=$sexi[1];							
				} else  { 
					$fuser = load_perevopl($user); 
					$usrlogin=$fuser['login']; 
					$user[sex]=$fuser[sex];
					$doit_txt=$sexi[$user['sex']];
				}
												
												
				addch ("<b>".$usrlogin."</b> ".$doit_txt." � <a href=logs.php?log=".$jert['battle']." target=_blank>�������� ��</a>.  ",$user['room'],$user['id_city']);
				$user['battle'] = $jert['battle'];
				$user[battle_t]=$meteam;
						
				$ac=($user[sex]*100)+mt_rand(1,2);
				addlog($jert['battle'],"!:W:".time().":".BNewHist($user).":".$user[battle_t].":".$ac."\n");	
						
				mysql_query("UPDATE users SET `battle` =".$bd['id'].",`zayavka`=0 , `battle_t`='{$za}' WHERE `id`= ".$user['id']);
				if (!$OARKAN) {
					//header("Location: fbattle.php");
					js_goto_fbattle();
					die();
				} else {
					$bet = 1;
					$sbet = 1;
					//header("Location: fbattle.php");
					js_goto_fbattle();
				}
			} else {
				echo "��������� �� �������...";
				return;
			}
		} else {
		   	echo err('<br>�� ���� �� ������ ���������, ���� ����� �� ������...');
			return;
		}
	} elseif (!$is_bot) {
//echo "�������";	
		if ($jert['zayavka'] > 0)
		{
  		//addchp ('Debug opposition Zid:'.$jert['zayavka'].'/JUid:'.$jert['id'],'{[]}Bred{[]}');
  		}
		// ���� ��� - ������
		if ($OARKAN) {
			$sql="UPDATE `users` SET `battle` = 1 WHERE `id` = {$jert['id']} AND `battle` = 0 AND `room` = ".$jert['room']." LIMIT 1";
		} else {
			$sql="UPDATE `users` SET `battle` = 1 WHERE `id` = {$jert['id']} AND `room` = {$user['room']} AND `battle` = 0 LIMIT 1";
		}
		mysql_query($sql);

		if (mysql_affected_rows() > 0) {
			// �������� �� ������
			if($jert['zayavka'] > 0 ) {
				$zay = mysql_fetch_array(mysql_query("SELECT * FROM `zayavka` WHERE `id`=".$jert['zayavka'].";"));
				// ������ ����� ������
				$jertv_team = explode(";",$zay['team1']);
				if (in_array ($jert['id'],$jertv_team)) {
					// �� �� ���
					$new_team = str_replace($jert['id'].";","",$zay['team1']);
					$needup=1;
					$other_team=$zay['team2'];
				} else {
					//������ ���
					$new_team = str_replace($jert['id'].";","",$zay['team2']);
					$needup=2;
					$other_team=$zay['team1'];
				}
									
				if ($zay['price'] > 0) {
					$current_money=$jert[money];
					if (mysql_query("UPDATE users SET money=money+".$zay[price]." WHERE id='".$jert['id']."'")) {
						//new_delo
						$rec['owner']=$jert[id];
						$rec['owner_login']=$jert[login];
						$rec['owner_balans_do']=$jert['money'];
						$jert['money']=$jert['money']+$zay['price'];
						$rec['owner_balans_posle']=$jert['money'];
						$rec['target']=0;
						$rec['target_login']='';
						$rec['type']=69;
						$rec['sum_kr']=$zay[price];
						add_to_new_delo($rec); //�����
						addchp ('<font color=red>��������!</font> ��� ���������� '.$zay[price].' ��. ������. ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);
						$fond_sql = "  ,`fond`=`fond`-{$zay[price]} ";
					}
				} else {
					$fond_sql='';
				}

				//���� ��� ������� � ������ ������ �� ������� ������
				if ( ($new_team=='') AND ($other_team=='')) {
					//������� �����
		  		//addchp ('Debug opposition -del Zid:'.$jert['zayavka'].'/JUid:'.$jert['id'],'{[]}Bred{[]}');

					
					mysql_query("DELETE FROM `zayavka` WHERE id = {$jert['zayavka']};");
				} else 
					{
		  		//addchp ('Debug opposition -update Zid:'.$jert['zayavka'].'/JUid:'.$jert['id'],'{[]}Bred{[]}');					
					// ���� �� �� ����� ��������
					$sqlta="UPDATE  `zayavka` SET  zcount=zcount-1,  team{$needup} = replace (team{$needup},'{$jert['id']};','') ,  t{$needup}hist = replace (t{$needup}hist,'".BNewHist($jert)."','') ".$fond_sql."  WHERE  id = {$jert['zayavka']};";
					mysql_query($sqlta);
				}
			}

			//echo "�������� ���";
			mysql_query("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time()." WHERE  `hp` > `maxhp` AND `id` = '".$user['id']."' LIMIT 1;") or die();
			mysql_query("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time().",`zayavka` = 0 WHERE  `hp` > `maxhp` AND `id` = '".$jert['id']."' LIMIT 1;") or die();

//			$levelstart = $user['level'];
			$levelstart = $user['level']."|".$jert['level'];

			$q = mysql_query('START TRANSACTION') or die();

			$sq1 = "";
			$sq2 = "";

			$sq1 .= '"'.$user['id'].'",';
			$sq2 .= '"'.mysql_real_escape_string(BNewHist($user)).'",';
			


			$sq1 .= '"'.$jert['id'].'",';
			$sq2 .= '"'.mysql_real_escape_string(BNewHist($jert)).'",';

			$addsql = $sq1.$sq2;


			mysql_query('INSERT INTO `battle` (`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`t1hist`,`t2hist`,`to1`,`to2`,`blood`,`CHAOS`,`damage`,`win`)
					VALUES
					(
						"��������������",
						"",
						"'.mt_rand(3,3).'",
						"40",
						"0",
						'.$addsql.'
						"'.time().'",
						"'.time().'",
						"0","-1","'.$levelstart.'","3"
					)
			') or die("Error mk battle");

			$battle_id = mysql_insert_id();
			
			$user['battle_t']=1;
			$jert['battle_t']=2;
			
			if (start_line_battle($battle_id,$user,$jert)==false) {
				die();
			}

	
			$arkansql = "";
			if ($OARKAN) {
				$arkansql = ', room = 1 ';
			}

			mysql_query('UPDATE `users` SET `battle` = '.$battle_id.', `battle_t` = 2 , zayavka=0  '.$arkansql.' WHERE `id`= '.$jert['id']) or die();
			mysql_query('UPDATE `users` SET `battle` = '.$battle_id.', `battle_t` = 1,  zayavka=0   WHERE `id`= '.$user['id']) or die();
			
			$link_battle_id=$battle_id;
			
			$q = mysql_query('COMMIT') or die();

			if ($user['hidden'] > 0) {
				$action='������';
				addch('<img src=i/magic/attack.gif> <b><i>���������</i></b>, �������� ����� ���������, �������� <a href=http://capitalcity.oldbk.com/logs.php?log='.$link_battle_id.' target=_blank>'.$action.'</a> �� <b>'.$jert['login'].'</b>.',$user['room']) or die();
			} else {
				if ($user['sex'] == 1) {$action="�����";}	else {$action="������";}
				addch('<img src=i/magic/attack.gif> <b>'.$user['login'].'</b>, �������� ����� ���������, �������� <a href=http://capitalcity.oldbk.com/logs.php?log='.$link_battle_id.' target=_blank>'.$action.'</a> �� <b>'.$jert['login'].'</b>.',$user['room']) or die();
			}

			$p2 = '<b>'.nick_align_klan($user).'</b> � <b>'.nick_align_klan($jert).'</b>';
			addlog($battle_id,"!:S:".time().":".BNewHist($user).":".BNewHist($jert)."\n");

			// ��������� ���� �����
			addchp ('<font color=red>��������!</font> �� ��� ������!<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert['login'].'{[]}',-1,$jert['id_city']) or die();

			if (!$OARKAN) {
				//header("Location: fbattle.php");
				js_goto_fbattle();
				die();
			} else {
				$sbet = 1;
				$bet = 1;
				//header("Location: fbattle.php");
				js_goto_fbattle();
			}
		} else {
			echo "��������� �� �������...";
			return;
		}
	} else {
		echo "��������� �� �������...";
		return;
	}
} else {
	err('�� ��� ������!');
}	
?>