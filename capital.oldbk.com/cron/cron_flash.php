#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php";
if( !lockCreate("cron_flash_job") ) {
    exit("Script already running.");
}

	
//���� ��� ������� ���� - �� �����
$get_all_batt=mysql_query("select * from battle where (type=61 or type = 40 or type = 41) and win=3 and status=0");
if (mysql_num_rows($get_all_batt)>0)
{
 while($battle = mysql_fetch_array($get_all_batt))
 {
	if (($battle[t3]!='') and ($battle[t1_dead]=='')) // ���� ���� 3-� ������� � ��� �� � ����������
 {	
	$battle_id=$battle[id];
	$timeout=$battle[timeout]*60;//sec
	
	//������ �������� ������ ���� ���� ����� �� ���� 3� ��� ����� ��������
	$count_t_life=mysql_query("select count(id), battle_t from users where battle={$battle_id} and hp>0 group by battle_t");
	if (mysql_num_rows($count_t_life)>=3)
	{
	echo "run";
	$pretendent=mysql_query("select * from users u LEFT JOIN battle_user_time bt ON bt.battle=u.battle and bt.owner=u.id
				 where u.battle='{$battle_id}' and u.hp>0 and ( (bt.timer1>0 and bt.timer1<=(UNIX_TIMESTAMP()-{$timeout}) ) 
				 OR (bt.timer2>0 and bt.timer2<=(UNIX_TIMESTAMP()-{$timeout})) OR (bt.timer3>0 and bt.timer3<=(UNIX_TIMESTAMP()-{$timeout})))");
	while($telo = mysql_fetch_array($pretendent)) 
	{
		if  ( ($telo[timer1] >0) and  ($telo[timer1]<= (time()-$timeout) ) )
			{
			//��� ������ ��� �������� �� 1� ����
			$test_team=1;			
			}
		elseif  ( ($telo[timer2] >0) and  ($telo[timer2]<= (time()-$timeout) ) )
			{
			//��� ������ ��� �������� �� 2� ����
			$test_team=2;			
			}
		elseif  ( ($telo[timer3] >0) and  ($telo[timer3]<= (time()-$timeout) ) )
			{
			//��� ������ ��� �������� �� 3� ����
			$test_team=3;			
			}
			
	 if ($test_team>0)		
	 	{
	 	//������� �������
		$get_fd=mysql_fetch_array(mysql_query("select count(id) from battle_fd where battle={$battle_id} and razmen_from='{$telo[id]}' and to_t={$test_team}"));
		$get_liveusers_en=mysql_fetch_array(mysql_query("select count(id) from users where battle={$battle_id} and  battle_t={$test_team} and hp>0 ;"));
		$get_liveclons_en=mysql_fetch_array(mysql_query("select count(id) from users_clons where battle={$battle_id} and  battle_t={$test_team} and hp>0 ;"));		
		
		if ($get_fd[0] < ($get_liveusers_en[0]+$get_liveclons_en[0]) )
			{
			//�� ����� ������
			echo " battle : $battle_id | Telo $telo[login]  | TEST T $test_team <br>";
			
			//������ ������ :)
				$demag=(int)($telo[maxhp]*0.33);
				//������
				$curhp=$telo[hp]-$demag;
				if ($curhp<=0) {$curhp=0;}
				
				mysql_query("UPDATE `users` SET `hp` =".$curhp."  WHERE `id` = ".$telo['id']." and hp>0 and battle={$battle_id} ");

				
				if (mysql_affected_rows()>0)
				{
				
				//��������� ������ ���� ���� �� ������� �� ������� ��  ������ ��� ������� ������	
				mysql_query("INSERT INTO `battle_user_time` SET `battle`='{$battle_id}',`owner`='{$telo[id]}',`timer{$test_team}`='".time()."' ON DUPLICATE KEY UPDATE `timer{$test_team}`='".time()."'");
				
				//� ���
					if (( $telo['hidden'] > 0 ) and ( $telo['hiddenlog'] =='' ) )
					{
					//addlog($battle_id,'<span class=date>'.date("H:i").'</span> '.nick_in_battle($telo,$telo[battle_t]).' ������� ������ ������ �� �����������, ������� ����� <B>-??</B> [??/??]<BR>');
					$telo[sex]=1;
					 addlog($battle_id,"!:X:".time().':'.nick_new_in_battle($telo).':'.($telo[sex]+1040).":<B>-??</B> [??/??]\n");
					 
					 if ($curhp<=0)
					 	{
					 	//������ ����� - ����� � ���
 						//$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
						//addlog($battle_id,'<span class=date>'.date("H:i").'</span> '.nick_in_battle($telo,$telo[battle_t]).' <b>'.$action[$rda].$sexi[1].'</b>!<BR>');
						addlog($battle_id,"!:D:".time().":".nick_new_in_battle($telo).":".get_new_dead($telo)."\n");						
					 	}
					}
					else
					{
					$stuser = load_perevopl($telo);
					if ($stuser['sex'] == 1) { $action = ""; } else { $action="�"; }
					$telo[sex]=$stuser['sex'];
					//addlog($battle_id,'<span class=date>'.date("H:i").'</span> '.nick_in_battle($stuser,$telo[battle_t]).' ������� ������ ������ �� �����������, ������� �����  <B>-'.$demag.'</B> ['.($curhp).'/'.$telo['maxhp'].']<BR>');
					 addlog($battle_id,"!:X:".time().':'.nick_new_in_battle($telo).':'.($stuser[sex]+1040).":<B>-{$demag}</B> [{$curhp}/{$telo[maxhp]}]\n");
					 if ($curhp<=0)
					 	{
					 	//������ ����� - ����� � ���
// 						$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
//						addlog($battle_id,'<span class=date>'.date("H:i").'</span> '.nick_in_battle($stuser,$telo[battle_t]).' <b>'.$action[$rda].$sexi[$telo[sex]].'</b>!<BR>');
						addlog($battle_id,"!:D:".time().":".nick_new_in_battle($telo).":".get_new_dead($telo)."\n");
						
						
					 	}
					
					}
				
				}
				else
				{
				echo "�� ������ , ��� ���� <br>\n";
				}
			
			
			
			}
		}
	}
	
	
	

    }
    else
    {
    echo "� ��� ���� ������ 2-� �������<br>\n";
    }
    
    
  }
  else
  {
  echo "�� 3-� ����. ��� <br>\n";
  }

}//������

}
else
{
echo "��� ���� <br>\n";
}

lockDestroy("cron_flash_job");

?>