<?php
function BRedirect($path) {
	header("Location: ".$path); 
	die();
} 

function BMyDie() {
	BRedirect("fbattle.php");
}


if (!($_SESSION['uid'] >0)) header("Location: index.php");

if ($user['battle'] == 0) {
	echo "��� ������ �����...";
} else {
	// �����������
	if(!$magic[id])
	{
		$magic = magicinf(17);
	}
	
	if($magic['chanse']==100)
	{
		$int=101;
	}
	else
	if ($user['intel'] >= 3) {
		$int=$magic['chanse'] + ($user['intel'] - 3)*3;
		if ($int>98)
		{$int=99;}
	} 
	else 
	{
		$int=0;
	}
	
	if ($CHAOS==1) { 
		$int=101;
		$get_counter=mysql_fetch_array(mysql_query("select * from battle_vars where battle={$user[battle]} and owner={$user[id]} ; "));
		if ($get_counter[unclons_use]>=$haos_unclone[kol]) {
			echo "��������� ����� � ���� ���...";
			$stop=1;
		}
	}
	
	///��������� ����� :)
	$get_life_users=mysql_fetch_array(mysql_query("select id from users where battle='{$user[battle]}' and  battle_t!='{$user[battle_t]}' and hp >0 LIMIT 1;"));
	if (!($get_life_users[id]>0))
	{
	//��� ����� ����� � ���!
		//��������� ����� ������/����� , ����� ������������ �� �������
		$test_life_clons = mysql_fetch_array(mysql_query("SELECT id FROM `users_clons` WHERE battle='{$user[battle]}' and  battle_t!='{$user[battle_t]}' and hp >0 and `login` != '".$_POST['target']."' LIMIT 1; ")) ;
			if (!($test_life_clons[id]>0))
				{
				echo "������ ���������� ���������� ������ �����...";
				$stop=1;	
				}
	}
	
	
	if ($stop!=1) {
		// ��������������� ��������
		// ��� ���� � ���� �����
		//if ($user[battle_t]==1) { $my_team_n=1; $en_team_n=2; } else { $my_team_n=2; $en_team_n=1; }
		$my_team_n=$user[battle_t];
		
		$q = mysql_query('START TRANSACTION') or bmydie();
		$q = mysql_query("SELECT * FROM `users_clons` WHERE battle='{$user[battle]}' and  battle_t!='{$user[battle_t]}' and hp >0 and `login` = '".$_POST['target']."' FOR UPDATE") or bmydie();
		$bot = mysql_fetch_array($q);
		$en_team_n=$bot[battle_t];
		
		if  (($bot[id_user] > 29 )  and ($bot[id_user] < 250 )) {
   			echo "����� ����� �� ����������";
		} else if  ($bot && strpos($_POST['target'],"����") && $bot['battle_t'] != $user[battle_t] && $bot['hp'] > 0 && $bot['battle'] == $user['battle']) {
			// ���� ����������
			// ��������� ������� �����
			$clon = $bot;

			//$bot = $bot[0]; 
			//$bd = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$user['battle'].' LIMIT 1;'));
			$bd = $data_battle;
			// ���� ���� ��� ����� ����� ����� ����������
			$good = 0; // 0 - ����������, 1 - �������� ������ ���� � 1.5 ���� ����, 2 - �������� ������ ���� ���� ��� �����, 3 - ����� ����������
			//1. ���������� ����� ����� ���� ������, ������ � ���� �� 1 �� �� �����
			$level_diff = $clon[level]-$user[level]; // 7 - 7 = 0, ok. 8-7=1, bad, 6-8=-2 ok, 8-6=2, bad
			if($level_diff > 2) {$good = 0;} // 0 - ����������
			if($level_diff == 1) {$good = 1;} // 1 - �������� ������ ���� � 1.5 ���� ���� 
			if($level_diff <= 0) {$good = 2;} // 2 - �������� ������ ���� ���� ��� �����	
			if ($user['ruines'] > 0) {$good = 2;} // ���� � ������ - ������������ ����� ��������
			if ($user['in_tower'] == 15) {$good = 2;} // ���� � ������ - ������������ ����� ��������

			if($good == 0) {
				echo "�� �� ������ ���������� ����� �����, �� ������ �� {$level_diff} ������...";
			} 					
			//2. ���������� ����� ���� ������� ���� ���� ���� �������� ��� � 1.5 ���� ������ ��� � �����
			if($good == 1) {
				$need_intel = round($clon[intel]+(($clon[intel]/2)-0.1),0);
				if($need_intel>$user[intel]) {echo "�� �� ������ ���������� ����� �����, ��� ����� {$need_intel} ���������.";}else{$good = 3;}
			}
			//3. ���������� ����� ������ ������ � ���� ���� ���� ���� �������� ��� ����� �����. ����� ��� ������ 
			if($good == 2) {
				if($clon[intel] > $user[intel]) {echo "�� �� ������ ���������� ����� �����, ��� ����� {$clon[intel]} ���������.";}else{$good = 3;}
			}			
			
			if($good == 3) { // ���������� �����
				if (rand(1,100) < $int) { // ����������� ��������			
					mysql_query("UPDATE `users_clons` SET `battle_t` =".$user[battle_t]."  WHERE `id` = ".$bot['id']) or bmydie();

					// � ������ ��������� ������ ��� �� ������������ �� ����					
					if ($bot[battle_t]==1) 
					{
						unset($boec_t1[$bot[id]]); 
						if ($user[battle_t]==2)
							{
							$boec_t2[$bot[id]]=$bot; 
							$data_battle[t2].=';'.$bot[id]; 
							$data_battle[t2hist].=BNewHist($bot); 
							}
						elseif ($user[battle_t]==3)
							{
							$boec_t3[$bot[id]]=$bot; 
							$data_battle[t3].=';'.$bot[id]; 
							$data_battle[t3hist].=BNewHist($bot); 
							}
							
					} elseif ($bot[battle_t]==2) 
					{ 
						unset($boec_t2[$bot[id]]); 
						if ($user[battle_t]==1)
							{
							$boec_t1[$bot[id]]=$bot; 
							$data_battle[t1].=';'.$bot[id]; 
							$data_battle[t1hist].=BNewHist($bot); 
							}
						elseif ($user[battle_t]==3)
							{
							$boec_t3[$bot[id]]=$bot; 
							$data_battle[t3].=';'.$bot[id]; 
							$data_battle[t3hist].=BNewHist($bot); 
							}
					}
					elseif ($bot[battle_t]==3) { 
						unset($boec_t2[$bot[id]]); 
						
						if ($user[battle_t]==1)
							{
							$boec_t1[$bot[id]]=$bot; 
							$data_battle[t1].=';'.$bot[id]; 
							$data_battle[t1hist].=BNewHist($bot); 
							}
						elseif ($user[battle_t]==2)
							{
							$boec_t2[$bot[id]]=$bot; 
							$data_battle[t2].=';'.$bot[id]; 
							$data_battle[t2hist].=BNewHist($bot); 
							}							
					}

				
					$time = time();
					
					if ($data_battle[t3]!='')
					{
					mysql_query("UPDATE battle SET to1=".$time.", to2=".$time.", to3=".$time.", t".$my_team_n."=CONCAT(t".$my_team_n.",';".$bot[id]."') , t".$my_team_n."hist=CONCAT(t".$my_team_n."hist,'".BNewHist($bot)."') ,  t".$en_team_n."=REPLACE(t".$en_team_n.",';".$bot[id]."',''), t".$en_team_n."hist=REPLACE(t".$en_team_n."hist,'".BNewHist($bot)."','') WHERE id = ".$user['battle']." ;") or bmydie();
					}
					else
					{
					mysql_query("UPDATE battle SET to1=".$time.", to2=".$time.", t".$my_team_n."=CONCAT(t".$my_team_n.",';".$bot[id]."') , t".$my_team_n."hist=CONCAT(t".$my_team_n."hist,'".BNewHist($bot)."') ,  t".$en_team_n."=REPLACE(t".$en_team_n.",';".$bot[id]."',''), t".$en_team_n."hist=REPLACE(t".$en_team_n."hist,'".BNewHist($bot)."','') WHERE id = ".$user['battle']." ;") or bmydie();
					}

				
					$bet=1;
					$sbet = 1;
					$MAGIC_OK=1;

				
					echo "�� ���������� �����";
					if ($CHAOS==1) {
						mysql_query("INSERT battle_vars (`battle`, `owner`, `unclons_use`) values ('{$user[battle]}', '{$user[id]}' , '1' ) ON DUPLICATE KEY UPDATE `unclons_use`=`unclons_use`+1 ; ") or bmydie();
					}
					
//					addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' ��������� ����� '.nick_in_battle($bot,$bot[battle_t]).' �� ���� �������<BR>');
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					$btext=str_replace(':','^',nick_in_battle($bot,$bot[battle_t])).' �� ���� �������.';
			       	       addlog($user['battle'],"!:X:".time().':'.nick_new_in_battle($user).':'.($user[sex]+1000).":".$btext."\n");
				} else {
					echo "������ ���������� � ����� �����...";
					$bet=1;
				}				
			} 
		} else {
			echo "��� ������ �����";
		}
		$q = mysql_query('COMMIT') or bmydie();
	}
}

?>