#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php";
if( !lockCreate("cron_effects_job") ) {
    exit("Script already running.");
}

$HH=(int)(date("H",time()));
$now_time=time();
					if (($HH>=9) and ($HH<21)) 
						{
						//echo "����";
						 mysql_query("update effects SET `time`=FLOOR({$now_time}+((`time`-{$now_time})*0.75)) , eff_bonus=1 where (type=11 OR type=12 OR type=13 OR type=14) and eff_bonus=0 and owner in (select id from users where pasbaf=851 and in_tower = 0 and room not in (197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282) )");					
						//��������� ����� �������� ���������� �� ��������� ������� �������� �� 20%.
						 mysql_query("update effects SET `time`=FLOOR({$now_time}+((`time`-{$now_time})*0.8)) , eff_bonus=1 where (type=2 and pal=0) and eff_bonus=0 and owner in (select id from users where pasbaf=852 and in_tower = 0 and room not in (197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282) )");											 
						}
						else
						{
						//� 21:00 �� 09:00
						//echo "����"; ������� ��� ������ �� 10%
						 mysql_query("update effects SET `time`=FLOOR({$now_time}+((`time`-{$now_time})*0.9))  , eff_bonus=1 where (type=11 OR type=12 OR type=13 OR type=14) and eff_bonus=0 and owner in (select id from users where pasbaf=842 and in_tower = 0 and room not in (197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282) )");
						}



function count_of_abil($v)
{
//����� �������� ������� �������� ���� �� �������������� � ����� ����� �����

 if ($v>=70000)
 {  return 15;  }
 elseif  ($v >= 60000)
 {  return 14;  }
 elseif ($v >=50000)
 {  return 13;  }
 elseif ($v >=43000)
 { return 12;  }
 elseif ($v >=36000)
 { return 11;  }
 elseif ($v >=30000)
 { return 10; }
 elseif ($v >=24000)
 { return 9;  }
 elseif ($v >=20000)
 { return 8; }
 elseif ($v >=16000)
 { return 7; }
 elseif ($v >= 13000)
 { return 6; }
 elseif ($v >=10000)
 { return 5; }
 elseif ($v >= 7500)
 { return 4; }
 elseif ($v >= 5000)
 { return 3; }
 elseif ($v >=3000)
 { return 2; }
 elseif ($v >=1500 )
 { return 1; }
 else
 { return 0; }

}

   //������ ������� IP ��� ����������� �� ���� ���� � ���
   mysql_query("DELETE from reg_ip WHERE time<".(time()-3600).";");

 //������ ������ ��� �� �������
 mysql_query("delete from users_bonus where finish_time<=NOW() ");

function delete_eff($ef_id) { 
	mysql_query("DELETE FROM `effects` WHERE `id` = ".$ef_id.";"); 
	return mysql_affected_rows();
}

// ������ � ����
$effs = mysql_query("SELECT * FROM `effects` WHERE `time` <= ".time().";");

while($eff = mysql_fetch_array($effs)) {

if ($eff['owner'] >= _BOTSEPARATOR_ )
{
	switch ($eff['type']) {
		case 10:
			delete_eff($eff['id']);
		break;
	}
}


if ($eff['owner'] < _BOTSEPARATOR_ )
{
	switch ($eff['type']) 
	{
		case 101050:
			mysql_query("UPDATE `users` SET `sila`=`sila`-'".$eff['sila']."', `lovk`=`lovk`-'".$eff['lovk']."', `inta`=`inta`-'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0) {
				delete_eff($eff['id']);
            }
			break;
		case 11:
			mysql_query("UPDATE `users` SET `sila`=`sila`+'".$eff['sila']."', `lovk`=`lovk`+'".$eff['lovk']."', `inta`=`inta`+'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}	
		break;
		case 12:
			mysql_query("UPDATE `users` SET `sila`=`sila`+'".$eff['sila']."', `lovk`=`lovk`+'".$eff['lovk']."', `inta`=`inta`+'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;
		case 13:
			mysql_query("UPDATE `users` SET `sila`=`sila`+'".$eff['sila']."', `lovk`=`lovk`+'".$eff['lovk']."', `inta`=`inta`+'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;
		case 14:
			mysql_query("UPDATE `users` SET `sila`=`sila`+'".$eff['sila']."', `lovk`=`lovk`+'".$eff['lovk']."', `inta`=`inta`+'".$eff['inta']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			delete_eff($eff['id']);
		break;
		case 4:
			mysql_query("UPDATE `users` SET `align`='0', palcom=''  WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			$mess = "����� �� ����� �� ��������� �����";
			mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$eff['owner']."','$mess','".time()."');");

			if (mysql_affected_rows()>0)
				{
					delete_eff($eff['id']);
				}				
		break;
		case 444:
			mysql_query("UPDATE `users` SET `room`='1', in_tower='0' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
					delete_eff($eff['id']);
					$mess="������� �� ��������� �� ��������� �����.";
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$eff['owner']."','$mess','".time()."');");
					mysql_query("INSERT INTO oldbk.`jail_log`(uid,type,date_time) VALUES ('".$eff['owner']."','0','".time()."')");
				}			
		break;
		case 200:
			mysql_query("UPDATE `users` SET `hidden`='0' WHERE `id` = '".$eff['owner']."' and hidden='{$eff['idiluz']}' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;
		
		case 202:
		//��� ������ ����������� � ��� - ���������� - ����� ��� ���� ���� ���-�� ������� ����� ������ - ���� ������
				mysql_query("UPDATE `users` SET `hidden`='0', `hiddenlog`=''  WHERE `id` = '".$eff['owner']."'  LIMIT 1;");
				mysql_query("delete  from effects where owner='{$user[id]}' and (type=200 or type=1111)");
				delete_eff($eff['id']);
		break;
		
		case 1111:
			mysql_query("UPDATE `users` SET `hidden`='0', `hiddenlog`='' WHERE `id` = '".$eff['owner']."' and hidden='{$eff['idiluz']}' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;

		case 2000:
			//���� � ������� ����� �������� � �������� ������� ����� ��������
			mysql_query("DELETE from oldbk.naim_message where owner='{$eff['owner']}' ; ");
			delete_eff($eff['id']);

		break;


		case 4200:
			if (delete_eff($eff['id']) > 0) {
				$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
				if ($telo !== false) {
					telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ����������.');

					// ��� �� �������, � ���� �� ������ ��������� � ������ ���� ��� ��� ���

					// ��������� �� ����� �� ��� � ����� �� ������� � ������� ���
					/*
					$qm = mysql_query('SELECT * FROM map_groups WHERE leader = '.$telo['id'].' and team = ""');
					if (mysql_num_rows($qm) > 0) {
						// ���� �� �����
						$m = mysql_fetch_assoc($qm);
						mysql_query('UPDATE map_groups SET magicfast = 0 WHERE id = '.$m['id']);
					}*/
					
				}
			}

		break;
		case 4201:
			if (delete_eff($eff['id']) > 0) {
				$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
				if ($telo !== false) {
					mysql_query('UPDATE users SET unikstatus = "" WHERE id = '.$telo['id'].' LIMIT 1');
					telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ����������� ������.');
				}
			}

		break;

		case 9103:
			if (delete_eff($eff['id']) > 0) {
				$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
				if ($telo !== false) {
					telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ������� ���� +'.($eff['add_info']*100).'%�.');
				}
			}

		break;


		case 420:
			if (delete_eff($eff['id']) > 0) {
				$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
				if ($telo !== false) {
					telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ��������� ����.');
				}
			}

		break;

		case 440:
			if (delete_eff($eff['id']) > 0) {
				$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
				if ($telo !== false) {
					telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ������������ �������.');
				}
			}

		break;

		case 557:
			if (delete_eff($eff['id']) > 0) {
				$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
				if ($telo !== false) {
					telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ������� �� ����� ������.');
				}
			}

		break;

		case 30000:
				//��� �������� ����������� -c ��������� ����
				$get_lic_mag=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$eff['owner']}' and type=50000;"));
				if (!($get_lic_mag['id']>0))
				{
				//��� ���.���� - ����� ������� ����
				 mysql_query("UPDATE `oldbk`.`users_perevod` SET `lim`=100 WHERE `owner`='{$eff['owner']}' ; ");
				 }
			delete_eff($eff['id']);
		break;		
		
		case 50000:
				//��� �������� ����������� -c ��������� ������
				$get_lic_mag=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$eff['owner']}' and type=30000;"));
				if (!($get_lic_mag['id']>0))
				{
				//��� ���.������ - ����� ������� ����
				 mysql_query("UPDATE `oldbk`.`users_perevod` SET `lim`=100 WHERE `owner`='{$eff['owner']}' ; ");
				 }
			delete_eff($eff['id']);
		break;				
		
		case 555:
			mysql_query("UPDATE `users` SET `trv`='0' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;
		case 222:
			mysql_query("UPDATE `users` SET `align`='".$eff['add_info']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;
		case 2:
			$qtype2 = mysql_query('SELECT * FROM effects WHERE type = 2 and owner = '.$eff['owner']);
			if (mysql_num_rows($qtype2) == 1) {
				mysql_query("UPDATE users set slp=0 where id={$eff['owner']} ;");
				if (mysql_affected_rows()>0) {
					delete_eff($eff['id']);
				}				
			} else {
				delete_eff($eff['id']);
			}
		break;
		case 102:
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-'".$eff['add_info']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;

		case 160:
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-'".$eff['add_info']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;

		case 170:
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-'".$eff['add_info']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;

		case 171:
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-'0.1' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;

		case 907:
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-'".$eff['add_info']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� <b>�'.$eff['name'].'�</b>.');
				}				
		break;

		case 9102:
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-'".$eff['add_info']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;

		case 20005:
				if ($eff['add_info']=='cooldown')
				{
					//������ ��������
					delete_eff($eff['id']);
				}
				else
				{
				$eff_tmp=array();
				$eff_bonus=0;
				$eff_cd=0;
				$eff_naem=0;
					$eff_tmp=explode(":",$eff['add_info']);
					$eff_bonus=$eff_tmp[0];
					$eff_cd=$eff_tmp[1]*60*60; 
					$eff_naem=$eff_tmp[2];
					mysql_query("UPDATE `users` SET `expbonus`=expbonus-'".$eff_bonus."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
					if ((mysql_affected_rows()>0))
					{
						//������������ ����� � �������
						mysql_query("UPDATE `oldbk`.`effects` SET `time`=`time`+'{$eff_cd}',`add_info`='cooldown' WHERE `id`='{$eff['id']}' "); //+20 �
						$naem=mysql_fetch_assoc(mysql_query("SELECT * FROM users_clons WHERE id = '{$eff_naem}' "));
						if (($naem['id']>0) and ($naem['passkills']!='') )
							{
								$paskill=unserialize($naem['passkills']);
								$paskill[20005]['active']=0;
								mysql_query("UPDATE `users_clons` SET passkills='".serialize($paskill)."'  WHERE `id`='{$naem['id']}'  limit 1");	
							}
						
					}				
				}
		break;

		case 20006:
				if ($eff['add_info']=='cooldown')
				{
					//������ ��������
					delete_eff($eff['id']);
				}
				else
				{
				$eff_tmp=array();
				$eff_bonus=0;
				$eff_cd=0;
				$eff_naem=0;
					$eff_tmp=explode(":",$eff['add_info']);
					$eff_bonus=$eff_tmp[0];
					$eff_cd=$eff_tmp[1]*60*60; 
					$eff_naem=$eff_tmp[2];
					mysql_query("UPDATE `users` SET `rep_bonus`=rep_bonus-'".$eff_bonus."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
					if ((mysql_affected_rows()>0) )
					{
						//������������ ����� � �������
						mysql_query("UPDATE `oldbk`.`effects` SET `time`=`time`+'{$eff_cd}',`add_info`='cooldown' WHERE `id`='{$eff['id']}' "); //+20 �
						$naem=mysql_fetch_assoc(mysql_query("SELECT * FROM users_clons WHERE id = '{$eff_naem}' "));
						if (($naem['id']>0) and ($naem['passkills']!='') )
							{
								$paskill=unserialize($naem['passkills']);
								$paskill[20006]['active']=0;
								mysql_query("UPDATE `users_clons` SET passkills='".serialize($paskill)."'  WHERE `id`='{$naem['id']}'  limit 1");	
							}
						
					}				
				}
		break;
		
		case 20007:
				if ($eff['add_info']=='cooldown')
				{
					//������ ��������
					delete_eff($eff['id']);
				}
				else
				{
				$eff_tmp=array();
				$eff_bonus=0;
				$eff_cd=0;
				$eff_naem=0;
					$eff_tmp=explode(":",$eff['add_info']);
					$eff_bonus=$eff_tmp[0];
					$eff_cd=$eff_tmp[1]*60*60; 
					$eff_naem=$eff_tmp[2];

						//������������ ����� � �������
						mysql_query("UPDATE `oldbk`.`effects` SET `time`=`time`+'{$eff_cd}',`add_info`='cooldown' WHERE `id`='{$eff['id']}' "); //+20 �
						$naem=mysql_fetch_assoc(mysql_query("SELECT * FROM users_clons WHERE id = '{$eff_naem}' "));
						if (($naem['id']>0) and ($naem['passkills']!='') )
							{
								$paskill=unserialize($naem['passkills']);
								$paskill[20007]['active']=0;
								mysql_query("UPDATE `users_clons` SET passkills='".serialize($paskill)."'  WHERE `id`='{$naem['id']}'  limit 1");	
							}
						
				}
		break;

		case 667:
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-0.1 WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;
		
		case 669:
		
			$adddbonus=explode(":",$eff['add_info']);
			$dbonus=$adddbonus[2];
			mysql_query("UPDATE `users` SET `expbonus`=expbonus-'{$dbonus}' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			
			if ($adddbonus[3]=='users_flag')
					{
					mysql_query("DELETE FROM `oldbk`.`users_flag` WHERE `owner`='{$eff['owner']}' ");
					}
			
			if (mysql_affected_rows()>0)
				{
				if (delete_eff($eff['id']) > 0) 
								{
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) 
									{
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� <b>�'.$eff['name'].'�</b>.');
									}
								}
				}
		break;		

		case 717:
			mysql_query("UPDATE battle set teams='' WHERE `id` = '{$eff[battle]}' ;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}				
		break;
		
		case 9999:
			$ownusr=mysql_fetch_array(mysql_query('select * from oldbk.users where id='.$eff['owner'].' LIMIT 1;'));
			delete_eff($eff['id']);
			$txt='��������� ����� � '.$eff['add_info'].' ���������...';
			addchp ($txt,'{[]}'.$ownusr['login'].'{[]}');
		break;
		
		case 826:
				mysql_query("UPDATE users set intel=intel-{$eff[intel]} WHERE  room not in (197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282,999,10000,72001,210,270) AND in_tower=0  AND  `id` = '".$eff['owner']."' LIMIT 1;");
				if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}
		break;		

		case 2020:
				
				$dbattle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id= '{$eff[battle]}'  "));
				   if (($dbattle['win']==3)	and  ($dbattle['t1_dead']=='') and ($dbattle['status']==0))
				   {
				   //��� ����
				   $add_info=explode(":",$eff['add_info']) ;
				   $uteam=$add_info[1]; //�������
				   if ($uteam>0) {   addlog($eff[battle],"!:X:".time().'::'.(2020+$uteam)."\n"); }
				   }
				delete_eff($eff['id']);				
		break;		
		
		case 1001:
		//����� �� ���� ��� �� � ������� ��������
		//���� � ���� ������� �� ������� �� ���� - �������� ��� �������� ��������!!!
		
				//��� ��������� ���� ������� � ������
				$decexp="";
				if ($eff['add_info']!='')
					{
					$decexp=" `expbonus`=`expbonus`-'".$eff['add_info']."' , ";
					
					}
		
			mysql_query("UPDATE users set ".$decexp." maxhp=maxhp-bpbonushp, bpbonushp=0 WHERE  room not in (197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282,999,10000,72001) AND in_tower=0 AND  `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
					if (delete_eff($eff['id']) > 0) {
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� �'.$eff['name'].'�.');
									}
								}
				mysql_query("UPDATE deztow_realchars set bpbonushp=0 WHERE `owner` = '".$eff['owner']."' LIMIT 1;");				
				}
				else
				{
				$dnr=array(197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282,999,10000,72001);
				$get_test=mysql_fetch_array(mysql_query('select * from users where id='.$eff['owner'].' LIMIT 1;'));
				if (($get_test['id']>0) AND ($get_test['in_tower']==0) AND ($get_test['bpbonushp']==0) AND (!(in_array($get_test['room'],$dnr)) )  )
					{
					if (delete_eff($eff['id']) > 0) {
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� �'.$eff['name'].'�.');
									}
								}
						
						
						
					}
				}
				
				
		break;
		case 1002:
		//����� �� ���� ��� �� � ������� ��������
		
		//��� ��������� ���� ������� � ������
				$decexp="";
				if ($eff['add_info']!='')
					{
					$decexp=" `expbonus`=`expbonus`-'".$eff['add_info']."' , ";
					}
		
		
			mysql_query("UPDATE users set   ".$decexp."  maxhp=maxhp-bpbonushp, bpbonushp=0 WHERE room not in (197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282,999,10000,72001) AND in_tower=0 AND  `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				if (delete_eff($eff['id']) > 0) {
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� �'.$eff['name'].'�.');
									}
								}
				mysql_query("UPDATE deztow_realchars set bpbonushp=0 WHERE `owner` = '".$eff['owner']."' LIMIT 1;");				
				}
				else
				{
				$dnr=array(197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282,999,10000,72001);
				$get_test=mysql_fetch_array(mysql_query('select * from users where id='.$eff['owner'].' LIMIT 1;'));
				if (($get_test['id']>0) AND ($get_test['in_tower']==0) AND ($get_test['bpbonushp']==0) AND (!(in_array($get_test['room'],$dnr)) )  )
					{
					if (delete_eff($eff['id']) > 0) 
								{
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� �'.$eff['name'].'�.');
									}
								}
					}
				}	
		break;
		case 1003:
		//����� �� ���� ��� �� � ������� ��������
		
		//��� ��������� ���� ������� � ������
				$decexp="";
				if ($eff['add_info']!='')
					{
					$decexp=" `expbonus`=`expbonus`-'".$eff['add_info']."' , ";
					}
		
			mysql_query("UPDATE users set   ".$decexp."  maxhp=maxhp-bpbonushp, bpbonushp=0 WHERE room not in (197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282,999,10000,72001) AND in_tower=0 AND `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
					if (delete_eff($eff['id']) > 0) 
								{
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� �'.$eff['name'].'�.');
									}
								}
				mysql_query("UPDATE deztow_realchars set bpbonushp=0 WHERE `owner` = '".$eff['owner']."' LIMIT 1;");				
				}
				else
				{
				$dnr=array(197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282,999,10000,72001);
				$get_test=mysql_fetch_array(mysql_query('select * from users where id='.$eff['owner'].' LIMIT 1;'));
				if (($get_test['id']>0) AND ($get_test['in_tower']==0) AND ($get_test['bpbonushp']==0) AND (!(in_array($get_test['room'],$dnr)) )  )
					{
						if (delete_eff($eff['id']) > 0) 
								{
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� �'.$eff['name'].'�.');
									}
								}
					}
				}			
		break;
		
		case 9100:  // ���������
			$mb=explode(":",$eff['add_info']);
			$mb=$mb[1];
			mysql_query("UPDATE users set rep_bonus=rep_bonus-".$mb." WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
						if (delete_eff($eff['id']) > 0) 
								{
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ���������� +'.round($mb*100).'%�.');
									}
								}
				}	

		break;
		
		case 20180601:  // ��������� �� ������ 
			$mb=$eff['add_info'];
			mysql_query("UPDATE users set rep_bonus=rep_bonus-".$mb." WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
						if (delete_eff($eff['id']) > 0) 
								{
									$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
									if ($telo !== false) {
										telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� ���������� +'.round($mb*100).'%�.');
									}
								}
				}	

		break;		
		
		case 4997:  //�� 8-� �����. ��� 102, ��� ��� ����� ������� � ����� � �������. �� ���� ����������� ������� ���
			mysql_query("UPDATE users set expbonus=expbonus-".$eff['add_info']." WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}	

		break;
		
		
		case 4998:  //�� ������ ���� (��� ����� 102) �� � �������� ���, ���� ������ ���.
			//mysql_query("UPDATE users set expbonus=expbonus-0.5 WHERE `id` = '".$eff['owner']."' LIMIT 1;");
			delete_eff($eff['id']);
		break;
		case 5001:  //����� �������
			mysql_query("INSERT INTO users_last_align (`owner`,`align`) VALUES
							       ('".$eff['owner']."','".$eff['add_info']."')
						ON DUPLICATE KEY UPDATE align='".$eff['add_info']."';");

				delete_eff($eff['id']);
					
		break;
	        case 4999:
 			$us=mysql_fetch_array(mysql_query('select * from users where id='.$eff['owner'].' LIMIT 1;'));
                       	$prem_shad=array();
	            	$data=mysql_query('select * from users_shadows where type=3 AND sex='.$us[sex].';');
		            while($row=mysql_fetch_array($data))
		            {
		            	$prem_shad[]=($us[sex]==1?'m':'g').$row[name];
		            }
		            $sh=explode('.',$us[shadow]);
		            if(in_array($sh[0],$prem_shad))
		            {
		            	$sh[0]='0';
		            }                                                   

			if ($us['m16'] > 0) dropitemid_telo(34,$us);
			if ($us['m17'] > 0) dropitemid_telo(35,$us);
			if ($us['m18'] > 0) dropitemid_telo(36,$us);
			if ($us['m19'] > 0) dropitemid_telo(37,$us);
			if ($us['m20'] > 0) dropitemid_telo(38,$us);

			$sql="UPDATE users set `expbonus`=expbonus-0.1, prem=0, shadow='".$sh[0].".gif' WHERE `id` = '".$eff['owner']."' LIMIT 1;";
			mysql_query($sql);
			
				if (mysql_affected_rows()>0)
				{
				delete_eff($eff['id']);
				}	
			
			break;
		
		case 5999:
 			$us=mysql_fetch_array(mysql_query('select * from users where id='.$eff['owner'].' LIMIT 1;'));
                       	$prem_shad=array();
	            	$data=mysql_query('select * from users_shadows where type=3 AND sex='.$us[sex].';');
		            while($row=mysql_fetch_array($data))
		            {
		            	$prem_shad[]=($us[sex]==1?'m':'g').$row[name];
		            }
		            $sh=explode('.',$us[shadow]);
		            if(in_array($sh[0],$prem_shad))
		            {
		            	$sh[0]='0';
		            }                                                   


			if ($us['m16'] > 0) dropitemid_telo(34,$us);
			if ($us['m17'] > 0) dropitemid_telo(35,$us);
			if ($us['m18'] > 0) dropitemid_telo(36,$us);
			if ($us['m19'] > 0) dropitemid_telo(37,$us);
			if ($us['m20'] > 0) dropitemid_telo(38,$us);


			if ($eff['id']>22829696) // ������������ gold
				{
				$sql="UPDATE users set `expbonus`=expbonus-0.15, prem=0, shadow='".$sh[0].".gif' WHERE `id` = '".$eff['owner']."' LIMIT 1;";				
				}
				else
				{
				$sql="UPDATE users set `expbonus`=expbonus-0.1, prem=0, shadow='".$sh[0].".gif' WHERE `id` = '".$eff['owner']."' LIMIT 1;";
				}

			mysql_query($sql);
			
				if (mysql_affected_rows()>0)
				{
				//������� �������� ������-��������� �������� � ����� ������
				//��������� - 1 ������� ��� � �����
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`=55;");
				//�������� - 2�� (30���) ��� � �����
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-2 where `owner`='{$eff['owner']}' and `magic_id`=15;");					

				//8. ������ �������� - 1�� � ����� (������ �� ���� � ������ �������)
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`=4847;");	 			
	
				//����� ������ ����� �������, ���� ���� �� �������)
				///mysql_query("DELETE from  `oldbk`.`users_abils` where `owner`='{$eff['owner']}' and `magic_id`=4848;");	
				delete_eff($eff['id']);
				}	
			
			break;
		
		case 6999:
 			$us=mysql_fetch_array(mysql_query('select * from users where id='.$eff['owner'].' LIMIT 1;'));
 			if ($us['id']>0)
 			{
                       	$prem_shad=array();
	            	$data=mysql_query('select * from users_shadows where type=3 AND sex='.$us[sex].';');
		            while($row=mysql_fetch_array($data))
		            {
		            	$prem_shad[]=($us[sex]==1?'m':'g').$row[name];
		            }
		            $sh=explode('.',$us[shadow]);
		            if(in_array($sh[0],$prem_shad))
		            {
		            	$sh[0]='0';
		            }                                                   

			if ($us['m16'] > 0) dropitemid_telo(34,$us);
			if ($us['m17'] > 0) dropitemid_telo(35,$us);
			if ($us['m18'] > 0) dropitemid_telo(36,$us);
			if ($us['m19'] > 0) dropitemid_telo(37,$us);
			if ($us['m20'] > 0) dropitemid_telo(38,$us);


				if ($eff['id']>22829696) // ������������ �������
					{
					$sql="UPDATE users set `expbonus`=expbonus-0.2, prem=0, shadow='".$sh[0].".gif' WHERE `id` = '".$eff['owner']."' LIMIT 1;";					
					}
					else
					{
					$sql="UPDATE users set `expbonus`=expbonus-0.15, prem=0, shadow='".$sh[0].".gif' WHERE `id` = '".$eff['owner']."' LIMIT 1;";
					}
			mysql_query($sql);

		
				if (mysql_affected_rows()>0)
				{
				//������� ����������  ������-�� ������� �������� � ����� ������
				//1. 2 ��������� � ����� =>1 ����� ��������
				$abil[1]=5007152; //����  1; // �����
				$abil[2]=5007154; //������ ���� wrath_ground   2  ����� 
				$abil[3]=5007153; //����������/ wrath_air 3; //������ (����, ������
				$abil[4]=5007155; //���������� ����	wrath_water  4; //���� 
			
				$need_astih=get_mag_stih($us); // �������� �� ������
				$need_astih=$need_astih[0]; //�� 0� ����� ������ ������
				
				if ($eff['id']>22737004) // ������������
				{
				//��������� - 1 ������� ��� � �����
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`=55;");
				//�������� - 2�� (30���) ��� � �����
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-2 where `owner`='{$eff['owner']}' and `magic_id`=15;");					
				}
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`='{$abil[$need_astih]}' ");
				//2. ������� ����� ����� �� ���� ��� ������� - 1�� � �����
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`=57;");
				//3. 2 �������� ���� � �����
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-2 where `owner`='{$eff['owner']}' and `magic_id`=56;");				
				//4. �������� - 1�� � �����				
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`=2526;");				
				//8. ������ �������� - 5�� � ����� (������ �� ���� � ������ �������)
				mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-5 where `owner`='{$eff['owner']}' and `magic_id`=4847;");
				//����� ������ - ����� �������, ���� ���� �� �������)
				//mysql_query("DELETE from  `oldbk`.`users_abils` where `owner`='{$eff['owner']}' and `magic_id`=4848;");	
				
				
				
					//	������ ������ "������� ��������" (5��./�����)
					mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-5 where `owner`='{$eff['owner']}' and `magic_id`=54;");					

				 	//  ������ ������ "������ �� ����� �� ���� ���" (1��./�����)					
					mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`=556557;");					
					
					//������ ������ "������ �� ����� ������" (1��./�����)
					mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$eff['owner']}' and `magic_id`=557561;");										
			
				
				
				
				
				delete_eff($eff['id']);
				}	
			   }
			   else
			   	{
			   	//��� ����� ������� �����
			   	delete_eff($eff['id']);
			   	}
			break;			
			
			
			
			
			default:
			if (delete_eff($eff['id']) > 0) {
				$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$eff['owner']));
				if ($telo !== false) {
					
					if ($eff['type']==930)
						{
						$vl=explode(":",$eff['name']);
						$eff['name']=$vl[1];
						}
				
					telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� <b>�'.$eff['name'].'�</b>.');
				}
			}
	}
}
}

//������ ������ �� ������� (������������, ����� ����� ��������������� � ������)


{
	$data=mysql_query("select u.*,u1.login as tlogin, ct.room as troom from oldbk.city_trap ct 
	left join oldbk.users u
	on ct.owner=u.id
	left join oldbk.users u1 
	on ct.target=u1.id
	where timer<'".(time())."';");
	mysql_query("delete from oldbk.city_trap where timer<'".(time())."';");
	while($o=mysql_fetch_assoc($data))
	{
		telepost_new($o,'<font color=red>��������!</font> ���� ������� �� ��������� <b>'.$o[tlogin].'</b> ������������� � ������� <b>'.$rooms[$o[troom]].'</b> �������� ���� � �����������.');
	}
}

	//������ ������ � ����
	$get_list=mysql_query("SELECT * FROM `labirint_zayav` WHERE `stamp` <= ".(time()-18000).";");
	while($labzz = mysql_fetch_array($get_list))
	 {
	 	mysql_query("delete from labirint_zayav where id={$labzz[Id]}");
	 	mysql_query("UPDATE users set labzay=0 where labzay={$labzz[Id]}");
	 }




	//��������� �� ����� (������ 2 ���� ����� ��������� �����)

     //����� ��� � ����������� ������, � ������ ������.
     $check_wars=array();
     $stop_id=array();
     $data=mysql_query('SELECT * FROM  oldbk.`clans_war_log` cwl
     WHERE cwl.start_time<='.time().' AND cwl.type=2;');
     //������� ����� ����
	if(mysql_num_rows($data)>0)
	{
	     	while($row=mysql_fetch_assoc($data))
	     	{
	     		$check_battle_cap=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.battle WHERE war_id='{$row['war_id']}' AND win=3 LIMIT 1;"));
	     		$check_battle_ava=mysql_fetch_assoc(mysql_query("SELECT * FROM avalon.battle WHERE war_id='{$row['war_id']}' AND win=3 LIMIT 1;"));
			$check_battle_ang=mysql_fetch_assoc(mysql_query("SELECT * FROM angels.battle WHERE war_id='{$row['war_id']}' AND win=3 LIMIT 1;"));	     		
	     		if($check_battle_cap[id]>0 || $check_battle_ava[id]>0 || $check_battle_ang[id]>0 )
	     		{
	     			//STOP
	     			//���������� ���� ���� ����������� �����, �� � ��� ���� ���  �� ����������� ���.
	     			$stop_id[$row['war_id']]=$row['war_id'];
	     		}
	     		else
	     		{
				$data2=mysql_query('SELECT c1.short as agr_short, c2.short as def_short FROM oldbk.`clans_war_2` cw2
				left join clans c1
				on cw2.agressor = c1.id
				left join clans c2
				on cw2.defender = c2.id
				
				WHERE war_id='.$row['war_id'].';');
				while($row2=mysql_fetch_assoc($data2))
				{
				//  print_r($row2);
					$dels[$row2[agr_short]].=$row2[def_short].',';
					$dels[$row2[def_short]].=$row2[agr_short].',';
				}
	     	
	     	//������� ������ � ������ ������
	     	//���� ������ �������� � �������� �������
	     			mysql_query("DELETE from oldbk.naim_message where war_id='{$row['war_id']}' ; ");
	     		}
	     	}
	}

	foreach($dels as $name => $value)
	{
		$value=substr($value,0,-1);
		$names=explode(',',$value);
		del_clan_war_files($name,$names);
	}


	if(count($stop_id)>0)
	{
		//���������� ���� ���� ����������� �����, �� � ��� ���� ���  �� ����������� ���.
		$sql=' AND cwl.war_id not in ('.(implode(',',$stop_id)).') ';
	}
	else
	{
		$sql='';
	}
	
	//������ ���� ���� ��� ���������� �����.
	$rez=array();
	$data=mysql_query('SELECT cwl.war_id,cw2.agressor,cw2.defender,cw2.win1,cw2.win2 
			FROM oldbk.`clans_war_log` cwl
			left join oldbk.`clans_war_2` cw2
			on cwl.war_id=cw2.war_id
			WHERE cwl.`type`=2 AND  cwl.`start_time`<='.time().' '.$sql.';');
	while($row=mysql_fetch_assoc($data))
	{
		$rez[$row['war_id']]['agressor'][$row['agressor']]=$row['win1'];
		$rez[$row['war_id']]['defender'][$row['defender']]=$row['win2'];
	}
	$counts=array();
	foreach($rez as $k=>$v)
	{
		foreach($v as $kk=>$vv)
		{
			foreach($vv as $kkk=>$vvv)
			{
				if($kk=='agressor')
				{
					$counts[$k]['agressor']+=$vvv;
				}
				if($kk=='defender')
				{
					$counts[$k]['defender']+=$vvv;
				}
			}
		}
	}

	foreach($counts as $k=>$v)
	{
       		$sql='UPDATE oldbk.`clans_war_log` SET type=3, fin_w="���������. '.(date('d-m-Y H:i',time())).' �� ������ '.$v['agressor'].' : '.$v['defender'].'." ';

		
		if($v['agressor']>$v['defender']) // ������� ��������
		{
			$sql.=' ,winner=1';
			//��������� ���� ������ �� ������� ��������� �������. ������������ ������� ��� ������
			
			foreach($rez[$k]['agressor'] as $kl_id=>$vo_val)
			{
			$get_abil_count=count_of_abil($vo_val);
			 if ($get_abil_count >0)
			 	{
			 		mysql_query("INSERT INTO `oldbk`.`clans_abil_war` SET `magic`=59,`klan`='{$kl_id}',`count`='{$get_abil_count}',`leftdays`=5 ON DUPLICATE KEY UPDATE `count`='{$get_abil_count}',`leftdays`=5  ;");
			 	}
			}
			
		}
		else
		if($v['agressor']<$v['defender']) //������� ��������
		{
			$sql.=' ,winner=2';
			//��������� ���� ������ �� ������� ��������� �������. ������������ ������� ��� ������
			
			foreach($rez[$k]['defender'] as $kl_id=>$vo_val)
			{
				$get_abil_count=count_of_abil($vo_val);
			 	if ($get_abil_count >0)
			 	{
			 	mysql_query("INSERT INTO `oldbk`.`clans_abil_war` SET `magic`=59,`klan`='{$kl_id}',`count`='{$get_abil_count}',`leftdays`=5 ON DUPLICATE KEY UPDATE `count`='{$get_abil_count}',`leftdays`=5;");
			 	}
			}
			
		}
		else
		if($v['agressor']==$v['defender'])
		{
			$sql.=' ,winner=3';
		}

	   	$sql.=' WHERE war_id="'.$k.'" AND type=2;';
	  	mysql_query($sql);
	}
	
    // ����� ������ �����

    $data=mysql_query('SELECT cwv.*, c1.short as agrr_short, c1.align as agrr_align, c1.rekrut_klan as agrr_rekrut_klan, c2.short as def_short, c2.align as def_align, c2.rekrut_klan as def_rekrut_klan
    FROM oldbk.`clans_war_vizov` cwv
						left join oldbk.`clans` c1
						on cwv.agressor_id = c1.id
						left join oldbk.`clans` c2
						on cwv.defender_id = c2.id
    WHERE cwv.defender_answer=0 AND cwv.status=0 AND cwv.timer >0;');
    //��������� �� �����
    if(mysql_num_rows($data)>0)
    {
    	while($row=mysql_fetch_array($data))
    	{
    	   $txt_agrr_rec='';
	       $txt_def_rec='';
    	   $start_timer2=check_start_war_time('2',$row[timer]);
    	   
           if($start_timer2<=0)
           {

	           if($row['agrr_rekrut_klan']>0)
	           {
	           		$a1=mysql_fetch_array(mysql_query('SELECT * from oldbk.`clans` WHERE id='.$row['agrr_rekrut_klan'].';'));
	           		$txt_agrr_rec=' � �������� '.(show_klan_name($a1['short'],$a1['align']));
	           }
	           if($row['def_rekrut_klan']>0)
	           {
	           	  	$a2=mysql_fetch_array(mysql_query('SELECT * from oldbk.`clans` WHERE id='.$row['def_rekrut_klan'].';'));
	           	  	$txt_def_rec=' � ������� '.(show_klan_name($a2['short'],$a2['align']));
	           }
	           $begin=time()+60*60*24;
	          // $begin=$row[timer]+60*60*24;
               //timer ���������
			
		$txt1='���� '.(show_klan_name($row['def_short'],$row['def_align'])).$txt_def_rec; //�������� �������
		$txt=(show_klan_name($row['agrr_short'],$row['agrr_align'])).$txt_agrr_rec; // ����������
		$beg=', ������ ����������� ����� '.(date('d-m-Y H:i',$begin)); 
                        					
			
			
	    		mysql_query('update oldbk.`clans_war_vizov` set defender_answer=1, timer = '.$begin.' where id='.$row['id'].' ;');
	    		//�������� ��� ������
	      	
	      		mysql_query('insert into oldbk.`clans_war_log` set
	      		txt="'.$txt.'", txt1="'.$txt1.'", def_answer=1, begin_txt="'.$beg.'",
	      		type=1,
	      		start_time='.$begin.', war_id='.$row['id'].';');
            }
    	}
    }

	$sql='select cwv.id as vizov_id,cwv.agressor_id,cwv.defender_id,cwv.def_receive,cwv.defender_answer,cwv.timer,
	cwv.status,c1.rekrut_klan as agressor_rec,c2.rekrut_klan as defender_rec
	from oldbk.`clans_war_vizov` cwv
    	left join oldbk.`clans` c1 on
    		c1.id=cwv.agressor_id
    	left join oldbk.`clans` c2 on
    		c2.id=cwv.defender_id
		where cwv.status=0
    	AND cwv.defender_answer>0 AND cwv.timer <= "'.time().'";';
    $data=mysql_query($sql);
    if(mysql_num_rows($data)>0)
    {
    	// 1 ������ �� ����� ���� �����
    	while($row=mysql_fetch_assoc($data))
    	{
            mysql_query('update oldbk.`clans_war_vizov` set status=1 WHERE id='.$row['vizov_id'].';');
            mysql_query('DELETE FROM oldbk.`clans_war_log` WHERE war_id='.$row['vizov_id'].' AND type=1;');
    		//�������� ����� �� �����. �������� ������ ����������, �������� �� �����.
    		if($row['defender_answer']==1)
    		{
                //�������� ������ �� ��������...
                $add_agrr='INSERT INTO oldbk.`clans_war_2`
					(war_id,agressor,defender,`date`,agr_active,def_active,osnova) VALUES
					("'.$row['vizov_id'].'","'.$row['agressor_id'].'","'.$row['defender_id'].'","'.(time()+60*60*24*3).'","1","0","1"),';

				$agrr_clans=array();
				$def_clans=array();
				$agrr_clans[]=$row['agressor_id'];
				$def_clans[]=$row['defender_id'];
                //������� ��������� ������� ���������
                if($row['agressor_rec']>0)
                {
                    $add_agrr.='("'.$row['vizov_id'].'","'.$row['agressor_rec'].'","'.$row['defender_id'].'","'.(time()+60*60*24*3).'","1","0","0"),';
                    $agrr_clans[]=$row['agressor_rec'];
                }
                //������ ��������� ������� ���������
                if($row['defender_rec']>0)
                {
                    $add_agrr.='("'.$row['vizov_id'].'","'.$row['agressor_id'].'","'.$row['defender_rec'].'","'.(time()+60*60*24*3).'","1","0","0"),';
                    $def_clans[]=$row['defender_rec'];
                }
                //���� ��� � ������ ��������� � ������ ���������, �� ������ �� ��� � ���� �� �����
                if($row['agressor_rec']>0&&$row['defender_rec']>0)
                {
                	$add_agrr.='("'.$row['vizov_id'].'","'.$row['agressor_rec'].'","'.$row['defender_rec'].'","'.(time()+60*60*24*3).'","1","0","0"),';

                }
                //����� �� ����� ��� ������ � ���� ������.
                $add_agrr=substr($add_agrr,0,-1).';';
               // echo $add_agrr;
                mysql_query($add_agrr);

                $txt='����������� ����� ����� ';
                $agrr_o_file=array();
               	$data1=mysql_query('SELECT * FROM oldbk.`clans` where id in ('.(implode(',',$agrr_clans)).')');
               	while($row3=mysql_fetch_array($data1))
               	{
                   $agrr_o_file[$row3[short]]='';
                   $txt.=show_klan_name($row3['short'],$row3['align']).',';
               	}
               	$txt=substr($txt,0,-1);

                $txt1='';

               	$data1=mysql_query('SELECT * FROM oldbk.`clans` where id in ('.(implode(',',$def_clans)).')');
               	while($row4=mysql_fetch_array($data1))
               	{
                   foreach($agrr_o_file as $agr_name => $v)
                   {
                      $agrr_o_file[$agr_name].=$row4['short'].','; 
                   }
                   $txt1.=show_klan_name($row4['short'],$row4['align']).',';
               	}

                foreach($agrr_o_file as $agr_name => $v)
                {
                      $agrr_o_file[$agr_name]=substr($agrr_o_file[$agr_name],0,-1);
                      write_clan_war_files($agr_name,$agrr_o_file[$agr_name]);
                }

                $txt1=substr($txt1,0,-1).'.';

               	//$add_agrr=substr($add_agrr,0,-1).';';

               	$sql2='insert into oldbk.`clans_war_log` set txt="'.$txt.'",txt1="'.$txt1.'", type=2, start_time='.(time()+60*60*24*3).', war_id='.$row['vizov_id'].',
               	fin_w="��������� - '.(date('d-m-Y H:i',(time()+60*60*24*3))).'";';
                mysql_query($sql2);
    		}
    		elseif($row['defender_answer']==2) //��� � ��������� (3 �� 3) ��������  + �������. 6 �� 6 �����
            {
                $klans_in_war_agrr=array();
				$klans_in_war_deff=array();
                $klans_in_war_agrr[0]=$row['agressor_id'];  //0-� - ������ ��������� ���������
                $klans_in_war_deff[0]=$row['defender_id'];  //0-� - ������ ��������� ���������

                if($row['agressor_rec']>0)
                {
                    $klans_in_war_agrr[]=$row['agressor_rec'];
                }
                //������ ��������� ������� ���������
                if($row['defender_rec']>0)
                {
                    $klans_in_war_deff[]=$row['defender_rec'];
                }
                $klans_who_dont_answered=array();
                //��������� ������� ���� ��� ��������� ������. ���� ���� ���� - �� ���� ��� ID ������ ���� � ����� �������.
            	$sql='
            	select cwa.id,cwa.war_klan,cwa.helper_klan,cwa.helper_answer,cwa.id_zayavka,c1.rekrut_klan as rec_helper
            	from oldbk.`clans_war_ally` cwa
                left join oldbk.`clans` c1
                on c1.id=cwa.helper_klan
            	where cwa.id_zayavka='.$row['vizov_id'].';';
            	//echo $sql;

            	$data_al=mysql_query($sql);
           	if(mysql_num_rows($data_al)>0)
		{
			while($row_al=mysql_fetch_assoc($data_al))
			{
		            	 if($row['agressor_id']==$row_al['war_klan'] && $row_al['helper_answer']==1)
		            	 {
		                            $klans_in_war_agrr[]=$row_al['helper_klan'];
		                            if($row_al['rec_helper']>0)
		                            {
		                            	$klans_in_war_agrr[]=$row_al['rec_helper'];
		                            }
		            	 }
	                         elseif($row['defender_id']==$row_al['war_klan'] && $row_al['helper_answer']==1)
	                         {
	                         	$klans_in_war_deff[]=$row_al['helper_klan'];
	                         	if($row_al['rec_helper']>0)
	                            {
	                            	$klans_in_war_deff[]=$row_al['rec_helper'];
	                            }
	                         }
	                         elseif($row_al['helper_answer']==0)
	                         {
	                             $klans_who_dont_answered[]=$row_al['helper_klan'];
	                         }
               		}
               	}
               	//�������� ������������ ����

               	mysql_query('update oldbk.`clans_war_ally` set status=1 WHERE status=0 AND id_zayavka='.$row['vizov_id'].' and helper_answer=1;');
                //������� �� ���������� ������ �� ����, � ���������� �����
                if(count($klans_who_dont_answered)>0)
                {
                	include "/www/capitalcity.oldbk.com/clan_kazna.php";
	                $sql='DELETE from oldbk.`clans_war_ally` WHERE id_zayavka='.$row['vizov_id'].' and helper_answer=0 AND status=0 AND helper_klan in ('.(implode(',',$klans_who_dont_answered)).');';
	                mysql_query($sql);
	                if(mysql_affected_rows()>0)
	                {
	                 	$data=mysql_query('select u.*,c.id as cid
	                 	from oldbk.`clans` cl
	                 	left join oldbk.`users` u
	                    on cl.glava = u.id
	                 	where cl.id in ('.(implode(',',$klans_who_dont_answered)).');');
	                 	while($klans_owner=mysql_fetch_array($data))
	                 	{
                                 	$klans_owner=check_users_city_data($klans_owner[id]);
				
				 	$klan_kazna_aggr=clan_kazna_have($klans_owner[cid]);
						
					if($klan_kazna_aggr)
					{
						put_to_kazna($klans_owner[uid],1,($war_price*0.5),$klans_owner[klan],$klans_owner);	
					}
					else
					{
      					 	$rec['owner']=$klans_owner[id];
						 $rec['owner_login']=$klans_owner[login];
						 $rec['owner_balans_do']=$klans_owner[money];
						 $klans_owner['money'] += ($war_price*0.5);
						 $rec['owner_balans_posle']=$klans_owner[money];
						 $rec['target']=0;
						 $rec['target_login']='��, ������� �� ����� ������� ������';
						 $rec['type']=110;//����� ������, ������������� ������
						 $rec['sum_kr']=($war_price*$toched*0.5);
						 $rec['item_count']=$toched;
       						 add_to_new_delo($rec);

                        			 mysql_query("update ".$db_city[$glava['id_city']]."`users` set money=money+".($war_price*0.5)." WHERE id=".$klans_owner['id'].";");
                        			 
					}
			         
	                 	}
	                }
                }

               	$add_agrr='INSERT INTO oldbk.`clans_war_2`
					(war_id,agressor,defender,`date`,agr_active,def_active,osnova) VALUES ';
               	foreach($klans_in_war_agrr as $k1=>$argessor_id)
               	{
                	foreach($klans_in_war_deff as $k2=>$defender_id)
               		{
               			$add_agrr.='('.$row['vizov_id'].','.$argessor_id.','.$defender_id.','.(time()+60*60*24*3).',1,1,'.($k1==0&&$k2==0?'1':'0').'),';
               		}
               	}


               	$add_agrr=substr($add_agrr,0,-1).';';
                mysql_query($add_agrr);
                //������� ���������� ������. ������ ��� ������ � ������� ����� clans_war_2. ��� �� � �������.
                mysql_query('DELETE from oldbk.`clans_war_ally` WHERE id_zayavka='.$row['vizov_id'].' AND status=1;');
                	//log

               	$txt='����� ����� ';
               	$agrr_a_file=array();
               	$agrr_d_file=array();

               	$data=mysql_query('SELECT * FROM oldbk.`clans` where id in ('.(implode(',',$klans_in_war_agrr)).')');
               	while($row3=mysql_fetch_array($data))
               	{
                   $txt.=show_klan_name($row3['short'],$row3['align']).',';
                   $agrr_a_file[$row3[short]]='';
               	}
               	$txt=substr($txt,0,-1);
                $txt1=' ';
               	$data=mysql_query('SELECT * FROM oldbk.`clans` where id in ('.(implode(',',$klans_in_war_deff)).')');
               	while($row4=mysql_fetch_array($data))
               	{
                   $txt1.=show_klan_name($row4['short'],$row4['align']).',';
                   foreach($agrr_a_file as $agr_name => $v)
                   {
                      $agrr_a_file[$agr_name].=$row4['short'].',';
                   }
                   $agrr_d_file[$row4[short]]='';
               	}

                $txt1=substr($txt1,0,-1);
               //	$add_agrr=substr($add_agrr,0,-1).';';

                foreach($agrr_a_file as $agr_name => $v)
                {
                      $agrr_a_file[$agr_name]=substr($agrr_a_file[$agr_name],0,-1);
                      write_clan_war_files($agr_name,$agrr_a_file[$agr_name]);
                       foreach($agrr_d_file as $def_name => $vv)
                       {
                           $agrr_d_file[$def_name].=$agr_name.',';
                       }
                }

                foreach($agrr_d_file as $def_name => $v)
                {
                	 $agrr_d_file[$def_name]=substr($agrr_d_file[$def_name],0,-1);
                     write_clan_war_files($def_name,$agrr_d_file[$def_name]);
                }

               	$sql2='insert into oldbk.`clans_war_log` set txt="'.$txt.'",txt1="'.$txt1.'", type=2, start_time='.(time()+60*60*24*3).', war_id='.$row['vizov_id'].', fin_w="��������� - '.(date('d-m-Y H:i',(time()+60*60*24*3))).'";';
                mysql_query($sql2);
                //������� ���� � ������ �� ��������� �������
            }

    	}

    }

////////////////////////////
//��������� �� �� �������������
$delay=23*60*60;//23 ���� - ������� �� ������� ������ ���� ��������
$next_cp=rand(2,4)*24*60*60; // 2-4 ��� ��������� ���������
/// ��������� �� ��
//1. �������� ������ ���������
	$cp_a=mysql_fetch_array(mysql_query("SELECT * FROM `variables` where `var`='cp_attack_on' ;"));
	if ($cp_a[value]>0)
	 {
	 //echo "��������";
	  // �������� ���������?
	    $end_time=mysql_fetch_array(mysql_query("SELECT * FROM `variables` where `var`='cp_attack_time_end' ;"));
	     if ($end_time[value]<=time())
	     {
     		// ��������� � ��������� ���� �����
	        mysql_query("UPDATE `variables` SET `value`=0 where `var`='cp_attack_on' ;");
	        $next_time=time()+$next_cp;
	 		mysql_query("UPDATE `variables` SET `value`='{$next_time}' where `var`='cp_attack_time_start' ;");

	     }
	     else
	     {
	     //echo "�� ����";
	     }
	 }
	 else
	 {
	// echo "���������";
	 //��������� �� ������ ��������
	  $start_time=mysql_fetch_array(mysql_query("SELECT * FROM `variables` where `var`='cp_attack_time_start' ;"));

	     if ($start_time[value]<=time())
	     {
	     //��������
    	        mysql_query("UPDATE `variables` SET `value`=1 where `var`='cp_attack_on' ;");
    	       //��������� ����� ����������
	        $next_time_end=time()+$delay;
    	       mysql_query("UPDATE `variables` SET `value`='{$next_time_end}' where `var`='cp_attack_time_end' ;");
	     }
	     else
	     {
	    // echo " �� ���� �������� ���... ";
	     }


	 }
//������������� ����� ��������

	/*
	$handle = opendir('/www_logs/combats_wars/');
	mysql_query("TRUNCATE oldbk.`clans_war_city_sync`;");
	$sql="INSERT INTO clans_war_city_sync (name,war_with) VALUES ";
	while (false !== ($entry = readdir($handle))) 
	{
		if($entry!='.'&&$entry!='..')
		{
	        	$load = file("/www_logs/combats_wars/".$entry);
	        	$sql.="('".$entry."','".$load[0]."'),";
	        }
    	}
	$sql=substr($sql,0,-1).";";
	mysql_query($sql);
	*/


//��������������� ������
//��������� ������, ���� ������ ������ �� ���������������, ��� ��������� ������
	{
		mysql_query("UPDATE oldbk.clans SET tax_timer='".(time()+60*60*24*7)."' WHERE tax_date<'".time()."' AND tax_date>0 AND tax_timer=0;");	
	}
	//�������� ��������������� ������ ��� �������������� (�� ��������� ���������� �������
	unset_klan();

///��������� �������� - ������� �����������
mysql_query("DELETE from clans_war_new_times where fintime<=NOW()");
//������ ������� ������
mysql_query("DELETE from clans_war_new_protect where fintime<=NOW()");

$protect_attak=86400; // ������: ���� ���� ������� ����� �� � ���� ���� ����� ����� �� ��������� � �����
//���������  ����� ����
//1. ��������  ����� ��� ���������
$get_all_new_voin=mysql_query("SELECT * from oldbk.clans_war_new where ftime<=NOW() and winner=0");
while($wrow = mysql_fetch_array($get_all_new_voin)) 
	{
print_r($wrow);
	$agr_clans=array();
	$def_clans=array();
	$inf_voin=array();	
	$sum_by_level=array();
			if ($wrow['wtype']==1)
				{
echo "���������� �������� �����....";				
				//��������� -��������
				//2.	������� ���� �� ������� ���
				$batt_now=mysql_fetch_array(mysql_query("SELECT id from battle where war_id='{$wrow['id']}'  and win=3 LIMIT 1;"));
					if (!($batt_now['id']>0))
						{
echo "���� ����  ����� ������� ��� �������";
						$get_info_voin=mysql_query("SELECT *  from oldbk.clans_war_new_voin where war_id='{$wrow['id']}' ");
							while($voin = mysql_fetch_array($get_info_voin))
								{
								$sum_by_level[$voin['level']][$voin['stor']]+=$voin['voin'];
									if ($voin['stor']=='agr')
									{
									$inf_voin['agr']+=$voin['voin'];
									$agr_clans[$voin['clan_id']]+=$voin['voin'];
									}
								elseif ($voin['stor']=='def')
									{
									$inf_voin['def']+=$voin['voin'];
									$def_clans[$voin['clan_id']]+=$voin['voin'];
									}
								}
						/////�������� ��� �������
						//��� ����� ���� ���������� ���.����� ��� ������� ������ �� ��������	
print_r($sum_by_level);						
							$kol_agr=0;
							$kol_def=0;
							foreach($sum_by_level as $key => $val) 
							{
							$winsarr=array();						
								foreach($val as $k => $v) 
									{
									$winsarr[$k]=$v;
									}
								
								if ($winsarr['agr']>$winsarr['def'])
										{
										$kol_agr++;
										}
								elseif ($winsarr['agr']<$winsarr['def'])
										{
										$kol_def++;
										}
							}

							// ������ �������� ��� ������� �  ����� �� ����������� ��������� �����	
							$war_win='';
								if ($kol_agr==$kol_def)
								{
								// ������ ������� ���������� ������, ����������� ��������� ����, ���������� ������� ���������� ����.
									$get_winned=mysql_fetch_array(mysql_query("select (select sum(winned) from oldbk.clans_war_new_voin  where war_id='{$wrow['id']}' and stor='agr') as wins_agr, (select sum(winned) from oldbk.clans_war_new_voin  where war_id='{$wrow['id']}' and stor='def') as wins_def"));
									if ($get_winned['wins_agr']>$get_winned['wins_def'])
										{
										$war_win='agr';
										}
									elseif ($get_winned['wins_agr']<$get_winned['wins_def'])
										{
										$war_win='def';
										}
									else
										{
										$war_win='none';									
										}	
								}
								elseif ($kol_agr>$kol_def)
										{
										$war_win='agr';
										}
								elseif($kol_agr<$kol_def)
										{
										$war_win='def';										
										}
								else 	
									{
									$war_win='none';									
									}
							
							//������� ������
								if ($war_win=='agr')
									{
									echo "�������� ���������";
									print_r($agr_clans);
									foreach($agr_clans as $kl_id=>$vo_val)
										{
										$get_abil_count=count_of_abil($vo_val);
											if ($get_abil_count >0)
									 		{
								 			mysql_query("INSERT INTO `oldbk`.`clans_abil_war_new` SET `magic`=59,`klan`='{$kl_id}',`count`='{$get_abil_count}',`leftdays`=10 ON DUPLICATE KEY UPDATE `count`='{$get_abil_count}',`leftdays`=10  ;");
									 		}
										}
									mysql_query("UPDATE `oldbk`.`clans_war_new` SET `winner`=1 WHERE `id`='{$wrow['id']}' ");		
									
											//���������� ������ - �����������
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['agressor']}' or base_klan='{$wrow['agressor']}'");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� ������� � �������� ����� ������ '.$wrow['def_txt'];
											send_tele_to_clans2($klan_names,$msg);
											//���������� ������ - �����������
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['defender']}' or base_klan='{$wrow['defender']}'");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� �������� � �������� ����� ������ '.$wrow['agr_txt'];
											send_tele_to_clans2($klan_names,$msg);
																	
									}
								elseif ($war_win=='def')
									{
									echo "�������� ���������";
									//������ ������� �� ������ ������������� �� ��������
									print_r($def_clans);
									foreach($def_clans as $kl_id=>$vo_val)
										{
										$get_abil_count=count_of_abil($vo_val);
											 if ($get_abil_count >0)
									 		{
								 			mysql_query("INSERT INTO `oldbk`.`clans_abil_war_new` SET `magic`=59,`klan`='{$kl_id}',`count`='{$get_abil_count}',`leftdays`=10 ON DUPLICATE KEY UPDATE `count`='{$get_abil_count}',`leftdays`=10  ;");
									 		}
										}
									mysql_query("UPDATE `oldbk`.`clans_war_new` SET `winner`=2 WHERE `id`='{$wrow['id']}' ");	
									
											//���������� ������ - �����������
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['defender']}' or base_klan='{$wrow['defender']}'");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� ������� � �������� ����� ������ '.$wrow['agr_txt'];
											send_tele_to_clans2($klan_names,$msg);
											//���������� ������ - �����������
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['agressor']}' or base_klan='{$wrow['agressor']}'");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� �������� � �������� ����� ������ '.$wrow['def_txt'];
											send_tele_to_clans2($klan_names,$msg);											
											
																		
									}
								else
									{
											mysql_query("UPDATE `oldbk`.`clans_war_new` SET `winner`=3 WHERE `id`='{$wrow['id']}' ");
												
											//���������� ������ - �����������
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['agressor']}' or base_klan='{$wrow['agressor']}' or id='{$wrow['defender']}' or base_klan='{$wrow['defender']}'");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='�������� �������� ����� '.$wrow['agr_txt'].' ������ '.$wrow['def_txt'].' - <b>�����</b>';
											send_tele_to_clans2($klan_names,$msg);	
												
									}							
							//������� ����������� - ��� ������
							mysql_query("delete from `oldbk`.`naim_message` where war_id='{$wrow['id']}' ");
							//� ���������� �� ����	
							mysql_query("UPDATE users SET naim='0' , naim_war='0' where naim_war='{$wrow['id']}'  ");
							
							//������ ��� ��� ����
							mysql_query("delete from `oldbk`.`clans_war_city_sync` where war_id='{$wrow['id']}' ");
						
						
							//�������� ����� �����
							foreach($agr_clans as $kl_id=>$vo_val)
							{
							mysql_query("INSERT INTO `oldbk`.`clans_war_new_protect` SET `clanid`='{$kl_id}',`fintime`=NOW() + INTERVAL ".$protect_attak." SECOND ");
							}
							foreach($def_clans as $kl_id=>$vo_val)
							{
							mysql_query("INSERT INTO `oldbk`.`clans_war_new_protect` SET `clanid`='{$kl_id}',`fintime`=NOW() + INTERVAL ".$protect_attak." SECOND ");
							}							

						
						
						}
						else
						{
						echo "���� ���...\n";
						}
				}
			elseif ($wrow['wtype']==2)
				{
echo "���������� ���������� ����� \n";							
				//���������-����������
				//2.	������� ���� �� ������� ���
				$batt_now=mysql_fetch_array(mysql_query("SELECT id from battle where war_id='{$wrow['id']}' and win=3 LIMIT 1;"));
					if (!($batt_now['id']>0))
						{
						//���� ���� 
						// ����� ������� ��� �������
						$get_info_voin=mysql_query("SELECT stor, voin, clan_id  from oldbk.clans_war_new_voin where war_id='{$wrow['id']}' ");
						while($voin = mysql_fetch_array($get_info_voin))
							{
								if ($voin['stor']=='agr')
									{
									$inf_voin['agr']+=$voin['voin'];
									$agr_clans[$voin['clan_id']]+=$voin['voin'];
									}
								elseif ($voin['stor']=='def')
									{
									$inf_voin['def']+=$voin['voin'];
									$def_clans[$voin['clan_id']]+=$voin['voin'];
									}
							}
						print_r($inf_voin);						
						//�������� ��� �������
							if ($inf_voin['agr']>$inf_voin['def'])
								{
								echo "������ ���������";
								mysql_query("UPDATE `oldbk`.`clans_war_new` SET `winner`=1 WHERE `id`='{$wrow['id']}' ");
								//������ ������� �� ������ ������������� �� ��������
								//��������� ���� ������ �� ������� ��������� �������. ������������ ������� ��� ������
								print_r($agr_clans);
								foreach($agr_clans as $kl_id=>$vo_val)
									{
									$get_abil_count=count_of_abil($vo_val);
									 if ($get_abil_count >0)
								 	{
							 		mysql_query("INSERT INTO `oldbk`.`clans_abil_war_new` SET `magic`=59,`klan`='{$kl_id}',`count`='{$get_abil_count}',`leftdays`=10 ON DUPLICATE KEY UPDATE `count`='{$get_abil_count}',`leftdays`=10  ;");
								 	}
									}
									
									
									//���������� ������ - �����������
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['agressor']}' or base_klan='{$wrow['agressor']}' or id in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and agressor='{$wrow['agressor']}' and active=1) or base_klan in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and agressor='{$wrow['agressor']}' and active=1)");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� ������� � ���������� ����� ������ '.$wrow['def_txt'];
											send_tele_to_clans2($klan_names,$msg);
									//���������� ������ - �����������
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['defender']}' or base_klan='{$wrow['defender']}' or id in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and defender='{$wrow['defender']}' and active=1) or base_klan in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and defender='{$wrow['defender']}' and active=1)");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� �������� � ���������� ����� ������ '.$wrow['agr_txt'];
											send_tele_to_clans2($klan_names,$msg);											
								}
							elseif ($inf_voin['agr']<$inf_voin['def'])
								{
								echo "������ ���������";
								mysql_query("UPDATE `oldbk`.`clans_war_new` SET `winner`=2 WHERE `id`='{$wrow['id']}' ");													
								//������ ������� �� ������ ������������� �� ��������
								print_r($def_clans);
								foreach($def_clans as $kl_id=>$vo_val)
									{
									$get_abil_count=count_of_abil($vo_val);
									 if ($get_abil_count >0)
								 	{
							 		mysql_query("INSERT INTO `oldbk`.`clans_abil_war_new` SET `magic`=59,`klan`='{$kl_id}',`count`='{$get_abil_count}',`leftdays`=10 ON DUPLICATE KEY UPDATE `count`='{$get_abil_count}',`leftdays`=10  ;");
								 	}
									}
								
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['defender']}' or base_klan='{$wrow['defender']}' or id in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and defender='{$wrow['defender']}' and active=1) or base_klan in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and defender='{$wrow['defender']}' and active=1)");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� ������� � ���������� ����� ������ '.$wrow['agr_txt'];
											send_tele_to_clans2($klan_names,$msg);		
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['agressor']}' or base_klan='{$wrow['agressor']}' or id in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and agressor='{$wrow['agressor']}' and active=1) or base_klan in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and agressor='{$wrow['agressor']}' and active=1)");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='��� ���� �������� � ���������� ����� ������ '.$wrow['def_txt'];
											send_tele_to_clans2($klan_names,$msg);
													
								}
							elseif ($inf_voin['agr']==$inf_voin['def'])
								{
								echo "�����";
								mysql_query("UPDATE `oldbk`.`clans_war_new` SET `winner`=3 WHERE `id`='{$wrow['id']}' ");
								
											$klan_names=array();
											$clns=mysql_query("select * from clans where id='{$wrow['agressor']}' or base_klan='{$wrow['agressor']}' or id='{$wrow['defender']}' or base_klan='{$wrow['defender']}' or id in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}' and active=1) or base_klan in (select clanid from oldbk.clans_war_new_ally where warid='{$wrow['id']}'  and active=1)");
											while($kk = mysql_fetch_array($clns)) 
											{
											$klan_names[]=$kk['short'];
											}
											$msg='�������� ���������� ����� '.$wrow['agr_txt'].' ������ '.$wrow['def_txt'].' - <b>�����</b>';
											send_tele_to_clans2($klan_names,$msg);
								
								}
							
							//������� ����������� - ��� ������
							mysql_query("delete from `oldbk`.`naim_message` where war_id='{$wrow['id']}' ");
							//� ���������� �� ����		
							mysql_query("UPDATE users SET naim='0' , naim_war='0' where naim_war='{$wrow['id']}'  ");	
							
							//������ ��� ��� ����
							mysql_query("delete from `oldbk`.`clans_war_city_sync` where war_id='{$wrow['id']}' ");
						
						
							//�������� ����� �����
							foreach($agr_clans as $kl_id=>$vo_val)
							{
							mysql_query("INSERT INTO `oldbk`.`clans_war_new_protect` SET `clanid`='{$kl_id}',`fintime`=NOW() + INTERVAL ".$protect_attak." SECOND ");
							}
							foreach($def_clans as $kl_id=>$vo_val)
							{
							mysql_query("INSERT INTO `oldbk`.`clans_war_new_protect` SET `clanid`='{$kl_id}',`fintime`=NOW() + INTERVAL ".$protect_attak." SECOND ");
							}	
						
								
						}
						else
						{
						echo "���� ���....\n";
						}
				}
	}

function send_tele_to_clans2($klan_name,$msg)
{

		$data=mysql_query("select * from oldbk.users where klan in ('".implode("','",$klan_name)."') ;");
		echo "select * from oldbk.users where klan in ('".implode("','",$klan_name)."') ;";
		echo $msg;

		 						while($sok=mysql_fetch_array($data))
							 	{
	 							telegraph_new($sok,$msg,'2',time()+(2*24*3600));
							 	}
}

		///���������� "�������� �����"
		//����� ������� �������� �����
		mysql_query("UPDATE `users_clons` SET `injury_possible`=1 WHERE battle=1 and injury_possible=0 ");
		if (mysql_affected_rows()>0)
			{
			//���� �������� - ����� ����� ������� ���������� �����
			echo "���� ���� ��������� ��� ��������...\n";
			}
			else
			{
			//������ ������ �� �����, � ���� ������� ��� ��������� �����
			//����� ������� ����� ��������� ������
			mysql_query("delete from users_clons where battle=1 and injury_possible=1");
				if (mysql_affected_rows()>0)
				{
				echo "������� �������� �����!\n";			
				}
			}

///////////////////////////////
//�������� ��������� ����� �� �����
///
	$get_lots=mysql_query("select * from exchange where fintime<=NOW();");
	while($lots = mysql_fetch_array($get_lots)) 
	{
		return_lot_from_exchange($lots['id']);
	}



///////////// �������� ��� �����
	//�������� �������
	$getlec=mysql_query("select owner from effects where type=40000");
	$lecsarray=array();
	while($rlec = mysql_fetch_array($getlec)) 
	{
		$lecsarray[]=$rlec['owner'];
	}

	//������	
	$nolic[11]="<font color=red>��������!</font> �������� <font color=#676565><b>������ ������</b></font>, �������������� �������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/friends.php?pals=4\")>�������</a> ��� ������ �������� <a href=http://oldbk.com/commerce/index.php?act=persabil target=_blank>�������� �����</a>.";
	$nolic[12]="<font color=red>��������!</font> �������� <font color=#34a122><b>������� ������</b></font>, �������������� �������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/friends.php?pals=4\")>�������</a> ��� ������ �������� <a href=http://oldbk.com/commerce/index.php?act=persabil target=_blank>�������� �����</a>";	
	$nolic[13]="<font color=red>��������!</font> �������� <font color=#2145ad><b>������� ������</b></font>, �������������� �������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/friends.php?pals=4\")>�������</a> ��� ������ �������� <a href=http://oldbk.com/commerce/index.php?act=persabil target=_blank>�������� �����</a>. ��� ������������ ����������� <b>���������</b>, ������� ����� ���������� � <b>���. ��������</b> � ������� <b>����������</b>.";
	
	$lic[11]="<font color=red>��������!</font> �������� <font color=#676565><b>������ ������</b></font>, �������������� ������� ������� ������ �����, �������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/friends.php?pals=4\")>�������</a> ��� ������ �������� <a href=http://oldbk.com/commerce/index.php?act=persabil target=_blank>�������� �����</a>.";
        $lic[12]="<font color=red>��������!</font> �������� <font color=#34a122><b>������� ������</b></font>, �������������� ������� ������� ������� �����, �������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/friends.php?pals=4\")>�������</a> ��� ������ �������� <a href=http://oldbk.com/commerce/index.php?act=persabil target=_blank>�������� �����</a>.";
      	$lic[13]="<font color=red>��������!</font> �������� <font color=#2145ad><b>������� ������</b></font>, �������������� ������� ������� ������� �����, �������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/friends.php?pals=4\")>�������</a> ��� ������ �������� <a href=http://oldbk.com/commerce/index.php?act=persabil target=_blank>�������� �����</a>. ��� ������������ ����������� <b>���������</b>, ������� ����� ���������� � <b>���. ��������</b> � ������� <b>����������</b>.";

	$get_travms=mysql_query("select u.*, e.id as trvid, e.type as ettype, e.name as ename from effects e LEFT JOIN users u ON e.owner=u.id where e.type in (11,12,13) and e.lastup=0 limit 50 ");	
	
	while($trvtelo = mysql_fetch_array($get_travms)) 
	{
		
		if (in_array($trvtelo['id'],$lecsarray))
			{
			$trvsys=$lic[$trvtelo['ettype']];
			}
			else
			{
			$trvsys=$nolic[$trvtelo['ettype']];			
			}
			
		if ($trvsys!='') telepost_new($trvtelo,$trvsys);		
		mysql_query("UPDATE `effects` SET `lastup`=1 WHERE `id`='{$trvtelo['trvid']}' ");
	}


lockDestroy("cron_effects_job");
?>