<?
//type>=110 and type<=150 - ���� ���� ��� ����� ��


$jert=$telo;

$myeff = getalleff($user['id']);
$jeff = getalleff($jert['id']);

//������� ��� ������ �� ������� �� ����������
$rooms_jert_arkan=array (15,17,18,36,56,54,55); 

//������� � ������� �����  66
$kv_rooms_ok=array(20,21,26,66,50,191);

///�� 50000 �� 53000 //�������
//� �� 53000 �� 54000 ���� ������ ��������

//addchp ('<font color=red>KLAN-ATTAK</font>'.$user['login'].' vrag: '.$jert['login'].' /wid'.$havewar['id'],'{[]}Bred{[]}');

$time_out=3;


// ���� ������ � ��� ������� ������
if ($jert['battle']>0)
{
	$check_bexit = mysql_fetch_array(mysql_query("SELECT bexit_count,bexit_team FROM `battle_vars` WHERE `owner` = '{$user['id']}' and battle = '{$jert['battle']}' LIMIT 1;"));
	$bd = mysql_fetch_array(mysql_query ('SELECT * FROM `battle` WHERE `id` = '.$jert['battle'].' LIMIT 1;'));

//addchp ('<font color=red>KLAN-ATTAK-1</font>'.$user['login'].' vrag: '.$jert['login'].' /wid'.$havewar['id'],'{[]}Bred{[]}');
}
else
{
//���������� ����� ��� ��� ���������
	if ($havewar['wtype']==1)
	{
	//����� �� �������
	$battle_type=140;
	}
	else
	{
	//���������� �����
	$battle_type=150;
	}
}


$grant_continue = false;
if($user[klan]!='')
{
	
	$klan = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
	if($klan[rekrut_klan]>0)
	{
		$recrut=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `id` = '".$klan[rekrut_klan]."' LIMIT 1;"));
		if($jert[klan]==$recrut[short])
		{
			$jert[klan]=$user[klan];	
		}
	}
	else
	if($klan[base_klan]>0)
	{

		$base_klan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `id` = '".$klan[base_klan]."' LIMIT 1;"));
		if($jert[klan]==$base_klan[short])
		{
			$jert[klan]=$user[klan];
		}
	}

}

if (($jert['room']==23) AND ($jert['battle']==0))
	{
	//�������� � �� � ���
	 if (test_lic_mag($jert))
	 	{
	 	$candoit=false;
		 }
		 else
		 {
		 $candoit=true;
		 }
	}
	else
	{
	$candoit=true;
	}

if ($candoit==false)
{ 
	err("� �������� ���������� �� ���� ������ ������� � ������ ���!"); 
}
elseif (($user['level']!=$jert['level']) AND ($havewar['wtype']==1) )
{
	$buff.=err('<br>� ��� �������� �����, ����� �������� ������ �� ���� �������!');
} elseif ($jert['zayavka'] > 100000000) {
	$buff.=err('<br>�������� ��������� � ������� �� ��� �����������...');
}
elseif (($startbattle==false) AND ($jert['battle']==0) )
{
	$buff.=err("<br>�� �� ������ ������ ����� ���, ����� � ������� ����������...");
}
elseif ($jert['ldate'] < (time()-60) && $jert['battle']==0) 
{
	$buff.=err("<br>�������� �� � ����!");
}
elseif (($jert['deal']==1) and ($jert['battle']==0) )
{
$buff.=err("� ������ ������ ������ �������� �����...");
}
elseif (  ($jert['align']==1.3 || $jert['align']==1.5 || $jert['align']==1.7) and ($jert['battle']==0) )
{
$buff.=err("� �������� ����� ����� ������ ������ �������� �����...");
}
elseif ( ($user['deal']==1) and ($jert['battle']==0) )
{
$buff.=err("��� ������ ������ �������� �����...");
}
elseif (  ($user['align']==1.3 || $user['align']==1.5 || $user['align']==1.7) and ($jert['battle']==0) )
{
$buff.=err("��� ������ ������ �������� �����...");
}
elseif ($user['battle'] > 0) 
{
	$buff.=err("<br>�� � ���...");
}
elseif (($user['room'] != $jert['room']) and (!($USE_ARKAN))) 
{
	$buff.=err("<br>�������� � ������ �������!");
}
elseif($jert[id_city]!=$user[id_city])
{
	$buff.=err('<br>�������� � ������ ������!');
}
elseif (isset($myeff['owntravma'])) 
{
	$buff.=err("<br>� ����� �������, ����� �������!");
} elseif (isset($myeff[830])) 
{
	$buff.=err("<br>�� ���������� ��� ����������!");
}elseif (($user['lab']>0) or ($user['room']==45) or ($jert['room']==45) or ($jert['lab']>0) || ($user['room'] >= 70000 && $user['room'] <= 72001) || ($user['room'] >= 91 && $user['room'] <= 97))  
{
	$buff.=err("<br>��������� � ���� ������� ���������!");
}elseif($user['in_tower']>0 || ($user['room'] >= 49998 && $user['room'] <= 60000))
{
	$buff.=err("<br>��� ��� �� ��������...");
}elseif (($user['room'] >=197)AND($user['room'] <=199)) 
{
     $buff.=err("<br>��������� � ���� ������� ���������!");
}
elseif (($user['room'] ==999)  OR ($user['room'] == 60 ) )
{
     $buff.=err("<br>��������� � ���� ������� ���������!");
}
elseif ($user['room'] ==72001) {
     $buff.=err("<br>��������� � ���� ������� ���������!");
}
elseif ($jert['room'] == 31 || $jert['room'] == 43 || $jert['room'] == 200 || $jert['room'] == 10000 || $jert['room'] == 72) 
{
	$buff.=err("<br>��������� � ���� ������� ���������!");
}
elseif (($user['room'] >=210)AND($user['room'] <=300)) 
{
	$buff.=err("<br>��� ��� �� ��������...");
}
 elseif($jert['id'] == $user['id']) 
{
	$buff.=err("<br>��������?..");
} elseif($bd['teams']!='')
{
	$buff.=err("<br>��� ������ �� �������������...".$bd['teams']);
} elseif(  !(($bd['type']>=110) and ($bd['type']<=150)) and ($jert['battle']>0) )
{
	$buff.=err("<br>��� �� �������� ���...");
} 
elseif ($check_bexit['bexit_count']>0 and $check_bexit['bexit_team']==$jert[battle_t] and $jert[battle] > 0) 
{
	$buff.=err("<br>�� ��� ���� � ��� �� ��������������� �������... ������ ��������� ������ �� ������...");
} elseif ($user['zayavka'] > 0) 
{
	$buff.=err("<br>�� �������� ��������...");
} elseif (isset($jeff[830])) 
{
	$buff.=err("<br>�������� ��������� ��� ����������...");
}
elseif (isset($jeff['owntravma']) && !$jert['battle']) 
{
	$buff.=err("<br>�������� �����������...");
}
 elseif ($user['klan'] != '' && ($user['klan'] == $jert['klan'] && $jert['klan'] != 'radminion')) 
{
	$buff.=err("<br>����� ����� ����� ��������.");
} 
elseif (($user['room'] != 1) and ($USE_ARKAN)) {
	$buff.=err("<br>�� ������ ������������ ����� ������ �������� � ������� ��� ��������!");
}
elseif (($USE_ARKAN) and (!(in_array($jert['room'],$rooms_jert_arkan))) ) 
{
	$buff.=err("<br>�������� �� ��������� � ����� �����������!");
}
elseif  (!((in_array($jert['room'],$kv_rooms_ok)) OR  ($jert['room']>=50000 && $jert['room']<=53000)))
{
	$buff.=err("<br>����� �������� ������ ��� ����� ��� � ��������!");
}
elseif ( ($USE_ARKAN) and ($jert[battle]>0)) 
{
	$buff.=err("<br>����� ����� ��� ������ �����...");
}
elseif ($jert['level'] < 1) 
{
	$buff.=err("<br>������� ��������� ��� ������� �����������!");
}
elseif ($jert['hp'] < $jert['maxhp']*0.33  && !$jert['battle']) 
{
	$buff.=err("<br>������ ������� �����!");
}
elseif ($user['hp'] < $user['maxhp']*0.33) 
{
	$buff.=err("<br>�� ������� ��������� ��� ���������!");
} 
elseif ($jert['hp'] < 1  && $jert['battle']>0) 
{
	$buff.=err("<br>�� �� ������ ������� �� ���������!");
} 
elseif ($jert['battle']>1 && $check_bexit['bexit_count']>1) 
{
  $buff.=err('<br>�� �������� ������ ������-����� � ���� ���...');
}
else
{
	  $grant_continue = true;
}


if ($grant_continue) 
{

		if($jert['battle'] > 0)
		{
		$za=($jert['battle_t']==1?2:1); 		

                    if($havewar['id']==$bd['war_id'])
                    {
							$user['battle_t']=$za;
							$TEST_CAN_I_GO=can_i_go_battle($user,$bd,$za);
							if ($TEST_CAN_I_GO)
							{
								$time = time();
								$sexi[0]='���������';
								$sexi[1]='��������';

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

						//��������� �������� ��� ���� ���. ����� ������ 30
						   $usr_in_b=users_in_battle($jert['battle']);
						   if (($bd['type']==140) and ($usr_in_b >= 29) )
						   	{
						   	   $sstatus=" type=141 ,";
						   	}
						   elseif (($bd['type']==150) and ($usr_in_b >= 29) )
						   	{
						   	   $sstatus=" type=151 ,";
						   	}						   	
						   else
						    	{
						    	$sstatus='';
						    	}	

								mysql_query('UPDATE `battle` SET '.$sstatus.'  to1='.$time.', to2='.$time.', `t'.$za.'`=CONCAT(`t'.$za.'`,\';'.$user['id'].'\') , `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($user).'\')   WHERE `id` = '.$jert['battle'].' ;');


								$fuser = $user; 
								$usrlogin=$fuser['login']; 
								$doit_txt=$sexi[$user[sex]];
							

							addch ("<b>".$usrlogin."</b> ".$sexi[$user[sex]]." � <a href=logs.php?log=".$jert['battle']." target=_blank>�������� ��</a>.  ",$user['room'],$user['id_city']);

							$ac=($user[sex]*100)+mt_rand(1,2);

							addlog($jert['battle'],"!:W:".time().":".BNewHist($user).":".$user[battle_t].":".$ac."\n");	

							//���� �������� ���

							mysql_query("UPDATE users SET `battle` =".$jert['battle'].",`zayavka`=0 , `battle_t`='{$za}' WHERE `id`= ".$user['id']);

							mysql_query("INSERT IGNORE INTO battle_dam_exp (battle,owner) VALUES ('{$jert['battle']}','{$user['id']}')");

							mysql_query("INSERT `battle_vars` (battle,owner,update_time,type)  VALUES ('{$jert['battle']}','{$user['id']}','{$time}','1') ON DUPLICATE KEY UPDATE `update_time` = '{$time}' ;");
						        ///////////////////////////////////////////////////////////
				                        $napal=1;
							}
							else
							{
					              	    $buff.=err('<br>�� ���� �� ������ ���������, ���� ����� �� ������...');
				                	    $astop=1;		
							}
                    }
		     else
                     {
                	    $buff.=err('<br>��� �� ���� �����!');
                	    $astop=1;
		       }
					///////////////////////////////////////////////                    				                  
		}
		elseif($startbattle==true)  //����� �������� ���
				{
					// �������� ���
					if($jert['deal']==1)
					{
						$buff.=err('<br>� ������ ������ ������ �������� �����...');
					}
					else
					if($jert['align']==1.3 || $jert['align']==1.5 || $jert['align']==1.7)
					{
						$buff.=err('<br>� �������� ����� ����� ������ ������ �������� �����...');
					}
					else
					if($user['deal']==1)
					{
						$buff.=err('<br>��� ������ ������ �������� �����...');
					}
					else
					if($user[align]==1.3 || $user[align]==1.5 || $user[align]==1.7)
					{
						$buff.=err('<br>��� ������ ������ �������� �����...');
					}
					else
					{
					
						//����������
						if ($USE_ARKAN) 
								{
									$tsql="UPDATE `users` SET `battle` = 1 WHERE `id` = {$jert['id']} AND `battle` = 0 and id_city='{$user[id_city]}'  LIMIT 1;";
								} else 
								{
									$tsql="UPDATE `users` SET `battle` = 1 WHERE `id` = {$jert['id']} AND `room` = {$telo['room']} AND `battle` = 0 and id_city='{$user[id_city]}'  LIMIT 1;";
								}

						mysql_query($tsql);
						if (mysql_affected_rows()>0)
						{
						// ���� ��� � ������, �������� ���
						if($jert['zayavka'] > 0 )
						{
							//������ ��� ������ ���� ���
							$zay = mysql_fetch_array(mysql_query("SELECT * FROM `zayavka` WHERE `id`=".$jert['zayavka'].";"));
							// ������ ����� ������
						       $jertv_team = explode(";",$zay['team1']);
							if (in_array ($jert['id'],$jertv_team))
								{
								// �� �� ���
								$new_team = str_replace($jert['id'].";","",$zay['team1']);
								$needup=1;
								$other_team=$zay['team2'];
								}
								else
								{
								//������ ���
								$new_team = str_replace($jert['id'].";","",$zay['team2']);
								$needup=2;
								$other_team=$zay['team1'];
								}

						// ���� ������ ���� �� �����
							if ($zay[price]>0)
							{
						  		$current_money=$jert[money];

								if (mysql_query("UPDATE users SET money=money+".$zay[price]." WHERE id='".$jert['id']."'")) // ������
								{
													//new_delo
									  		    		$rec['owner']=$jert[id];
													$rec['owner_login']=$jert[login];
													$rec['owner_balans_do']=$jert['money'];
													$jert[money]=$jert[money]+$zay[price];
													$rec['owner_balans_posle']=$jert['money'];
													$rec['target']=0;
													$rec['target_login']='';
													$rec['type']=69;
													$rec['sum_kr']=$zay[price];
													$rec['sum_ekr']=0;
													$rec['sum_kom']=0;
													$rec['item_id']='';
													$rec['item_name']='';
													$rec['item_count']=0;
													$rec['item_type']=0;
													$rec['item_cost']=0;
													$rec['item_dur']=0;
													$rec['item_maxdur']=0;
													$rec['item_ups']=0;
													$rec['item_unic']=0;
													$rec['item_incmagic']='';
													$rec['item_incmagic_count']='';
													$rec['item_arsenal']='';
													add_to_new_delo($rec); //�����
								addchp ('<font color=red>��������!</font> ��� ���������� '.$zay[price].' ��. ������. ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);
								$fond_sql="  ,`fond`=`fond`-{$zay[price]} ";
								}

							} /// ������ ��� �� ������
							else
							{
								$fond_sql='';
							}

						//���� ��� ������� � ������ ������ �� ������� ������
							if ( ($new_team=='') AND ($other_team==''))
							{
							//������� �����
								mysql_query("DELETE FROM `zayavka` WHERE id = {$jert['zayavka']};");
							}
							else
							{
							// ���� �� �� ����� ��������
								mysql_query("UPDATE  `zayavka` SET  zcount=zcount-1, team{$needup} = '{$new_team}' , t{$needup}hist = replace (t{$needup}hist,',".BNewHist($jert)."','') ".$fond_sql."  WHERE	id = {$jert['zayavka']};");
							}

						} // zay
						
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
						
						
						mysql_query("INSERT INTO `battle`
							(
								`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`blood`,`CHAOS`
							)
							VALUES
							(
								NULL,'','','".$time_out."','{$battle_type}','1','".$user['id']."','".$jert['id']."','".time()."','".time()."','1','2'
							)");

						$battle_id = mysql_insert_id();
						$time = time();
						$user['battle_t']=1;

// var_dump($wpers);
						
						start_line_battle($battle_id,$user,$jert);

						$t1h =BNewHist($user);
						$t2h =BNewHist($jert);

						addch ("<a href=logs.php?log=".$battle_id." target=_blank>���</a> ����� <B><b>".$user_nick."</b> � <b>".nick_align_klan($jert)."</b> �������.   ",$user['room'],$user['id_city']);
						addlog($battle_id,"!:S:".time().":".$t1h.":".$t2h."\n");
						//������� ������
						mysql_query("INSERT INTO battle_vars (battle,owner,update_time,type) VALUES ('{$battle_id}','{$user['id']}','{$time}','1'), ('{$battle_id}','{$jert['id']}','{$time}','1')");

						if ($USE_ARKAN) 
						{ 
						//-1 � �� �������
						// �������� +1 � ������������� ������ �� ������ �������
							
						mysql_query("UPDATE oldbk.`clans_war_new` SET `{$my_side_is}_ark`=`{$my_side_is}_ark`+1 WHERE `id`='{$havewar['id']}';");
						
						$add_sql_arkan=' , room=1 '; 
						} else { $add_sql_arkan='';}
						
						mysql_query("UPDATE `users` SET `battle` = {$battle_id} , `zayavka`=0 ".$add_sql_arkan." , `battle_t`=2 WHERE `id` = {$jert['id']} ;");
						mysql_query("UPDATE `users` SET `battle` = {$battle_id} , `zayavka`=0 , `battle_t`=1 WHERE `id` = {$user['id']} ;");
						mysql_query_100("UPDATE battle set `war_id`='{$havewar['id']}',`status`=0,`t1hist`='".BNewHist($user)."' , `t2hist`='".BNewHist($jert)."' where id={$battle_id};");
						$napal=1;
					}
					else
					{
		                	$astop=1;
					$buff.=err('<br>�� ������� �������, ���������� ��� ���...');
					}
 				    }
				}
                else
                {
                	$astop=1;
                	$buff.=err('<br>�� �� ������ ������ �������� ���...');
                }


				if($napal==1 && $astop!=1)
				{
				if ($user['sex'] == 1) {$action="�����";}	else {$action="������";}
				$link_battle_id=$battle_id;
					if($USE_ARKAN)
					{
					addchp ('<font color=red>��������!</font> ��� ������ �������� <B>'.$user['login'].'</B>.<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);					
					addchp ('<font color=red>��������!</font> �� ������� ��������� <B>'.$jert['login'].'</B>.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);										
					}				
					addch("<img src=i/magic/attack.gif> <B>{$user['login']}</B>, �������� ����� ���������, �������� <a href=http://capitalcity.oldbk.com/logs.php?log=".$link_battle_id." target=_blank>".$action."</a> �� &quot;{$jert[login]}&quot;",$user['room'],$user['id_city']);
					addchp ('<font color=red>��������!</font> �� ��� '.$action.' <B>'.$user['login'].'</B>.<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert['login'].'{[]}',$jert['room'],$jert['id_city']);
					$user_nick=nick_align_klan($user);
				}
		 
}
?>
