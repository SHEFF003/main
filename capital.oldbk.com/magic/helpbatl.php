<?php
// by fred 20 07 2012
// v.4 - ����� ���������� ���� ����� �������������� ��� 3-� ���������� ���

if (!($zastup) && !($magic['id'])) {
	$magic = magicinf(53);
}

$do_not_help=array(10000,9,190672,101,102,103,104,105,106,107,108,109,110,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,137,138,139,140,141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166,167,168,169,170,171,172,173,174,175,176,177,178,179,180,181,182,183,184,185,186,187);


$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));

if ($jert [klan]==$user[klan]) {
	$zastup_za_svoego=true;

}


if($jert['battle'] > 0) {
	$check_bexit = mysql_fetch_array(mysql_query("SELECT * FROM `battle_vars` WHERE `owner` = '{$user['id']}' and battle = '{$jert['battle']}' LIMIT 1;"));

	$bd = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$jert['battle'].' LIMIT 1;'));

	if  ($bd['damage']!='')
		{
		$batslvls=explode('|',$bd['damage']);
		}

	if( (($bd['type']==100) or ($bd['type']==101)) && $zastup_za_svoego==true )
	{

		//���������, ����� �� �� ��������� � �������� ���..
		//����� ���� � ��� ���� ����������� �����, � ���� �� ����� � ��� ����� ����� �� ������ �������.
		$klan=mysql_fetch_array(mysql_query('SELECT * from oldbk.`clans` where short = "'.$user['klan'].'" LIMIT 1'));

		//�������� ����� ID ������ ��� ���������, ����� ��� ������ ���������� � ������.
		$bcp_id=$klan[id];
		$klan[id]=($klan[base_klan]>0?$klan[base_klan]:$klan[id]);

		//���������, ���� �� � ���� �����, ��� � �������� ��� ����������
		$data=mysql_query('SELECT * from oldbk.`clans_war_2`
		WHERE (
			(agressor='.$klan[id].' OR defender = '.$klan[id].') AND `date`>'.time().' AND war_id='.$bd['war_id'].'
		)
		ORDER BY id DESC LIMIT 1');
		if(mysql_num_rows($data)>0)
		{
			$zastup_za_svoego=true;
		}
		else
		{
			$zastup_za_svoego=false;
		}

		$klan[id]=$bcp_id;
	}

	$p190672=mysql_fetch_array(mysql_query ("SELECT * FROM `users` WHERE `id` in (190672,10000) and battle='{$jert['battle']}'  LIMIT 1;")); //��������� ����� �� ������� ��� ���� ��� ����

	if (  ($p190672['battle'] >0 )  and ($p190672['battle_t'] !=$jert['battle_t']) )
	{
		if ($user['weap']>0)
				{
				//test weap
				$test_user_weap=mysql_fetch_array(mysql_query("select * from oldbk.inventory where id ='{$user['weap']}' limit 1;"));

				if ((($test_user_weap['prototype'] >=55510301 ) AND ($test_user_weap['prototype'] <=55510352) ) OR ($test_user_weap['prototype'] ==1006233 ) OR ($test_user_weap['prototype'] ==1006232 ) OR ($test_user_weap['prototype'] ==1006234 ) OR ($test_user_weap['otdel'] ==6 ) )
					{
						//����� � ������ ����� ���������

					}
					else
					if ($test_user_weap['nlevel']<$user['level'] )
						{
						$low_level='�� �� ������ ������ �� ������� ����� ��������� � ������� ���� ������ ������';
						}
				}
				else
				{
				$low_level='�� �� ������ ������ �� ������� ����� ��������� ��� ������';
				}
	}


	if (($bd[type]==2)AND($bd[exp]!='')) {
		$user_align=(int)($user[align]);
		if ($user_align==1) {$user_align=6;}

		//decode
		$aaligns=explode(";",$bd[exp]);
		//���������� ��� ���� �������
		if ($jert['battle_t']==2) {
			$my_aligns1=$aaligns[2];
			$my_aligns2=$aaligns[3];
			$targ_aligns1=$aaligns[0];
			$targ_aligns2=$aaligns[1];
		} else 	{
			$my_aligns1=$aaligns[0];
			$my_aligns2=$aaligns[1];
			$targ_aligns1=$aaligns[2];
			$targ_aligns2=$aaligns[3];
		}
	}

	if($jert['battle_t']==1) { $attack_to = 2; } else { $attack_to = 1; }
}


if ($zastup) {
	$int=101;
}
else
{

	if($magic['chanse']==100)
	{
		$int=101;
	}
	else
	if ($user['intel'] >= 0) {
		$int=$magic['chanse'] + ($user['intel'] - 4)*3;
		if ($int>98){
			$int=101;
		}
	}
	else
	{
		$int=0;
	}
}



$grant_continue = false;

$myeff = getalleff($user['id']);

if ($user['battle'] > 0) {
		echo "�� � ���...";
} elseif ( ( $bd[coment]=='<b>��� � ������� ��������</b>' ) or ( $bd[coment]=='<b>��� � ����������� �����</b>' ) or ( $bd[coment]=='��� � �������� �����' ) or ( $bd[coment]=='<b>��� � ����� �������</b>' ) or ( $bd[coment]=='<b>��� � �������</b>' )  )
{
	echo "��� ��� �� ��������...";
} elseif ($bd['type'] == 23 && !$user['uclass']) {
	echo '��� ������������� � ��������� ��� � ��� ������ ���� ���������� �����';
} elseif($jert['battle']==0) {
	echo '<font color=red>������� �� � ���...</font>';
} elseif ($jert['ldate'] < (time()-60)) {
	echo "�������� �� � ����!";
} elseif ($jert['hidden'] > 0) {
	echo "�������� �� � ����!";
} elseif (isset($myeff['owntravma'])) {
	echo "� ����� �������, ����� �������!";
} elseif (isset($myeff[830])) {
	echo "�� ���������� ��� ����������!";
} elseif ($low_level!='') {
	echo $low_level;
} elseif (in_array($jert['id'],$do_not_help))
{
 	echo "������ ���� �� ����� ������� � <b>{$jert[login]}</b>!";

} elseif($bd['teams']!='' || ($user['room'] >= 49998 && $user['room'] <= 53600))
				{
				     $h=explode(":||:",$bd['teams']);
				      if ($h[0]==20000)
				      	{
						echo "��� ����������...";
				      	}
				      	else
				      	{
					echo "��� ������ �� �������������...".$bd['teams'];
					}
				}
			 	elseif( ($bd['type']==100) and (!($zastup_za_svoego)))
			 	{
				 echo "��� �������� ���...";
				}
				elseif( ($bd['type']==140) OR ($bd['type']==141)  OR ($bd['type']==150) OR ($bd['type']==151)  )
			 	{
				 echo "��� �������� ���...";
				}
				elseif( ($bd['type']==101) and (!($zastup_za_svoego)))
			 	{
				 echo "��� �������� ���...";
				}
				elseif (($user['room'] >=210)AND($user['room'] <=300) || ($user['room'] >= 50000 && $user['room'] <= 53600) || ($user['room'] >= 70000 && $user['room'] <= 72001)) {
				echo "��� ��� �� ��������...";
				}
				elseif($jert['id']==$user['id'])
				{
				 echo '<font color=red>��������?...</font>';
				}
				elseif ($user['zayavka'] > 0)
				{
				echo "�� �������� ��������...";
				}
				elseif($jert[bot]==1)
				{
				echo "��� ��� �� �������...";
				}
				elseif ($user[align]==3 and ($jert[align]==6 or $jert[align]==1 or $jert[klan]=='pal') and ($bd['CHAOS']==0) )
				{
				// ��� �� ���� ������ �� ����� ����������� �� ��������
				echo "�� �� ������ ����������� �� ��������� ���� ����������!";
				}
				elseif ($jert[align]==3 and ($user[align]==6 or $user[align]==1 or $user[klan]=='pal') and ($bd['CHAOS']==0) )
				{
				// ��� �� ���� ���� �� ����� ����������� �� �������
					echo "�� �� ������ ����������� �� ��������� ���� ����������!";
				} elseif ( (($bd[type]==2)AND($bd[exp]!='')) AND ($user_align==0 OR $user_align==4) ) {
					echo "�� �������� ��������� � ���� ���, � ��� �� �� ����������!";
				} elseif ($bd[type]== 40 || $bd[type] == 41) {
					echo "�� �������� ��� ��� ��������������!";
				} elseif (  (($bd[type]==2)AND($bd[exp]!='')) AND ($user_align!=$my_aligns1 AND $user_align!=$my_aligns2) ) {
				echo "�� �������� ��������� �� ��� �������, � ��� �� �� ����������!";
				} elseif (  (($bd[type]==2)AND($bd[exp]!='')) AND (($user_align==$targ_aligns1 OR $user_align==$targ_aligns1)AND($user_align!=2)) ) {
				echo "�� �������� ��������� ������ ����� ����������!";
				}
				 elseif ($user['room'] != $jert['room'])
				{
					echo "�������� � ������ �������!";
				}
				elseif ($jert['room'] == 31 || $jert['room'] == 43 || $jert['room'] == 200 || $jert['room']==60)
				{
					echo "��������� � ���� ������� ���������!";
				}
				elseif (($jert['klan'] == 'radminion' || $jert['align'] == '2.7') && ($user['klan'] != 'radminion'))
				{
					echo "����������� ���-�� ��� ���! �� ������...";
				}
				 elseif ($user['hp'] < $user['maxhp']*0.33)
				{
						echo "�� ������� ��������� ��� ���!";
				}
				elseif ($bd[fond]>0)
				{
						echo "������ ��������� � ��� �� ������!";
				}
				elseif (($jert['hp'] < 1)  AND  ($jert['battle'] > 1))
				{
						echo "�� �� ������ ����������� �� ���������!";
				}
						 elseif ($jert['battle']>1 && $check_bexit['bexit_count']>0)
				{
							  echo '<font color=red>�� �������� ������ ������-����� � ���� ���...</font>';
							  if($user['klan'] == 'radminion') {echo 'attackk ['.$check_bexit['bexit_count'].'/1]';}
				}
				elseif ( ($jert['battle']>0) && ($bd['damage']!='') && ($batslvls[0]!=$user['level'] && $batslvls[1]!=$user['level'])   )
				{
						echo '<font color=red>����� � ���� ��� ����� ������ �� ������, � ������� �� �����..</font>';
				}


				elseif(!(rand(1,100) < $int))
				{
					echo "������ ���������� � ����� �����...";
					$bet=1;
				}
				elseif(!isset($_POST['dropability']) && $jert['battle']>0)
				{
				// ����� ������ �������
	                    		$is_clan = false;
					if ($user['klan']!='')
					{

	                        		$uklan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '".$user['klan']."' LIMIT 1;"));
					        if($uklan['base_klan']>0)
					        {
					        	$baseklan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `id` = '".$uklan['base_klan']."' LIMIT 1;"));
					        	$sql="'".$user['klan']."', '".$baseklan['short']."'";
					        }
					        else
					        if($uklan['rekrut_klan']>0)
					        {
					        	$rekrutklan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `id` = '".$uklan['rekrut_klan']."' LIMIT 1;"));
					        	$sql="'".$user['klan']."', '".$rekrutklan['short']."'";
					        }
					        else
					        {
					        	$sql="'".$user['klan']."'";
					        }

						$clans_query = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE  battle={$jert['battle']} and battle_t={$attack_to} and `klan` in (".$sql.") LIMIT 1 ; "));
						if ($clans_query[id] >0)
						{
							$is_clan = true;
						}
					}
				////
						if($is_clan)
						{
							$grant_continue = false;
							echo "<form id='formability' action='".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."' method='POST'><input id='target' name='target' type='hidden' value='".$jert['login']."' /><input id='dropability' name='dropability' type='hidden' value='1'/></form><script type='text/javascript'>var cat = confirm('� �ac ����� ���� ������ � ����������, ���� �� ����������. �������?');if(cat) { document.getElementById('formability').submit(); }</script>";
						}
						else
						{
						$grant_continue = true;
						}

				}
				else
				{
					$grant_continue = true;
				}


	if ($bd['coment']=="<b>��� �� ����������� �������</b>")
	{
						$za=$jert['battle_t'];
						$user['battle_t']=$za;
						$TEST_CAN_I_GO=can_i_go_battle($user,$bd,$za,true); // � ������� ��� ������� �� ��
						if ($TEST_CAN_I_GO)
						{
						// ����� ������� �������
						//���� ���� ��������� ��� ����������
								if ($user['hidden']>0)
								{
								mysql_query("UPDATE users set hidden=0 , hiddenlog='' where id='{$user['id']}' ");
								mysql_query("DELETE from effects where (type=1111 OR type=200)  and owner='{$user['id']}' and idiluz!=0;");
								$user['hidden']=0;
								$user['hiddenlog']='';
								}
								//���� ������ � �����������
							if ($jert['hidden']>0)
								{
								mysql_query("UPDATE users set hidden=0 , hiddenlog='' where id='{$jert['id']}' ");
								mysql_query("DELETE from effects where (type=1111 OR type=200)  and owner='{$jert['id']}' and idiluz!=0;");
								$jert['hidden']=0;
								$jert['hiddenlog']='';
								}

						}
						else
						{
						err('<br>�� ���� �� ������ ���������, ���� ����� �� ������...');
						$grant_continue=false;
						}
	}


if ($grant_continue)
{
	if(isset($_POST['dropability']) )
	{
		Test_Arsenal_Items($user);
		mysql_query("UPDATE users set klan='', status='', align=0 where id='{$user['id']}'");
		mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$user['id']."','�������� � �������� ������ �������, � ������� ���������� ".$user[klan].", ���������� �� {$_POST['target']} ','".time()."');");
		ref_drop($user['id']);
	}
$sbet = 1;
$bet=1;


						if ($zastup )
						{
							 $mag_name=$baff_name;
							 $mag_gif='<img src=i/magic/'.$get_align.'n4.jpg>';
						}
						else
						{
							$mag_name='������ ��������';
							$mag_gif='<img src=i/magic/helpbatl.gif>';
						}





						if(($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
						 {
							addch($mag_gif." <B><i>���������</i></B>, �������� ����� ".$mag_name.",  ���������� �� &quot;{$_POST['target']}&quot;",$user['room'],$user['id_city']);
							addchp ('<font color=red>��������!</font> �� ��� ���������� <B><i>���������</i></B>.<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);
							$sexi='��������';
						}
						else
						{
							$fuser=load_perevopl($user); //�������� � �������� ��������� ���� ����
							if ($fuser['sex'] == 1) {$action="����������"; 	$sexi='��������';  }	else {$action="�����������"; $sexi='���������';}
							addch($mag_gif." <B>{$fuser['login']}</B>, �������� ����� ".$mag_name.", ".$action." �� &quot;{$_POST['target']}&quot;",$user['room'],$user['id_city']);
							addchp ('<font color=red>��������!</font> �� ��� '.$action.' <B>'.$fuser['login'].'</B>.<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);
						}



					if ($jert['battle_t']==1) {$za=1;} else {$za=2;}
					$time = time();
					if ($check_bexit['bexit_count']>0)
					{
						mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($user).'\')   WHERE `id` = '.$jert['battle'].' ;');
					}
					else
					{
					//������ ������ ������ ���� ����

					if (($bd['type']!=100) and ($bd['type']!=101) and ($bd['type']!=4) and ($bd['type']!=5) )
					{
						  if ($bd[status_flag]==0)
						   {
						    if  (users_in_battle($jert['battle']) >= 99)
						    	{
						    	if ($bd['CHAOS']>0)
						    	   {
						    	   //���� ����
						    	    $sstatus=" status_flag=10 ,";
						    	   }
						    	   else
						    	   {
						    	   //�� ����
   						    	    $sstatus=" status_flag=1 ,";
						    	   }
						    	}
						    	else
						    	{
						    	$sstatus='';
						    	}
						   }
						   else { $sstatus=''; }
					}
					else { $sstatus=''; }


					mysql_query('UPDATE `battle` SET '.$sstatus.' to1='.$time.', to2='.$time.', `t'.$za.'`=CONCAT(`t'.$za.'`,\';'.$user['id'].'\') , `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($user).'\')   WHERE `id` = '.$jert['battle'].' ;');
					}


				//	addlog($jert['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle_hist($user,$za).'  '.$sexi.'  � ��������!<BR>');
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					$user[battle_t]=$za;
					$ac=($user[sex]*100)+mt_rand(1,2);
	//				addlog($jert['battle'],"!:V:".time().":".nick_new_in_battle($user).":".$ac."\n");
					addlog($jert['battle'],"!:W:".time().":".BNewHist($user).":".$user[battle_t].":".$ac."\n");


					//���� �������� ���

					mysql_query("UPDATE users SET `battle` =".$jert['battle'].",`zayavka`=0 , `battle_t`='{$za}' WHERE `id`= ".$user['id']);

					/// ��� ��� ��� ����  �������� ���� ������ � ����
					mysql_query("INSERT `battle_vars` (battle,owner,update_time,type)  VALUES ('{$jert['battle']}','{$user['id']}','{$time}','1') ON DUPLICATE KEY UPDATE `update_time` = '{$time}' ;");
				        ///////////////////////////////////////////////////////////





					header("Location:fbattle.php");
					//die("<script>location.href='fbattle.php';</script>");
}


?>
