#!/usr/bin/php
<?php
ini_set('display_errors','On');
$CITY_NAME='capitalcity';
include "/www/".$CITY_NAME.".oldbk.com/cron/init.php";

if( !lockCreate("cron_voln") ) {
    exit("Script already running.");
}

include "/www/".$CITY_NAME.".oldbk.com/fsystem.php";
//include "/www/".$CITY_NAME.".oldbk.com/mobs_config.php";
include "/www/".$CITY_NAME.".oldbk.com/mobs_config_dragon.php";

$VR_GODA=date("n");

$ZIMA_array=array(12,1,2);
$VESNA_array=array(3,4,5);
$LETO_array=array(6,7,8);
$OSEN_array=array(9,10,11);

	$ZIMA = false;
	$VESNA = false;
	$OSEN = false;
	$LETO = false;

if (in_array($VR_GODA,$ZIMA_array)) {
	$ZIMA=true;
} elseif (in_array($VR_GODA,$VESNA_array)) {
	$VESNA=true;
} elseif (in_array($VR_GODA,$OSEN_array)) {
	$OSEN=true;
} else {
	$LETO=true;
}


function mk_bot($proto,$botlogin,$botonlie,$botroom,$team)
{
//
$telo=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '{$proto}' LIMIT 1;"));

					$telo_items=load_mass_items_by_id($telo);
					mysql_query("INSERT INTO `users_clons` SET `login`='".$botlogin."',`sex`='{$telo['sex']}',
					`level`='{$telo['level']}',`align`='{$telo['align']}',`klan`='{$telo['klan']}',`sila`='{$telo['sila']}',
					`lovk`='{$telo['lovk']}',`inta`='{$telo['inta']}',`vinos`='{$telo['vinos']}',
					`intel`='{$telo['intel']}',`mudra`='{$telo['mudra']}',`duh`='{$telo['duh']}',`bojes`='{$telo['bojes']}',`noj`='{$telo['noj']}',
					`mec`='{$telo['mec']}',`topor`='{$telo['topor']}',`dubina`='{$telo['dubina']}',`maxhp`='{$telo['maxhp']}',`hp`='{$telo['maxhp']}',
					`maxmana`='{$telo['maxmana']}',`mana`='{$telo['mana']}',`sergi`='{$telo['sergi']}',`kulon`='{$telo['kulon']}',`perchi`='{$telo['perchi']}',
					`weap`='{$telo['weap']}',`bron`='{$telo['bron']}',`r1`='{$telo['r1']}',`r2`='{$telo['r2']}',`r3`='{$telo['r3']}',`helm`='{$telo['helm']}',
					`shit`='{$telo['shit']}',`boots`='{$telo['boots']}',`nakidka`='{$telo['nakidka']}',`rubashka`='{$telo['rubashka']}',`shadow`='{$telo['shadow']}',`battle`=0,
					`id_user`='{$telo['id']}',`at_cost`='{$telo_items['allsumm']}',`kulak1`=0,`sum_minu`='{$telo_items['min_u']}',
					`sum_maxu`='{$telo_items['max_u']}',`sum_mfkrit`='{$telo_items['krit_mf']}',`sum_mfakrit`='{$telo_items['akrit_mf']}',
					`sum_mfuvorot`='{$telo_items['uvor_mf']}',`sum_mfauvorot`='{$telo_items['auvor_mf']}',`sum_bron1`='{$telo_items['bron1']}',
					`sum_bron2`='{$telo_items['bron2']}',`sum_bron3`='{$telo_items['bron3']}',`sum_bron4`='{$telo_items['bron4']}',`ups`='{$telo_items['ups']}',
					`injury_possible`=0, `battle_t`='{$team}', bot='{$botonlie}' , bot_online='{$botonlie}', bot_room='{$botroom}' ;");
					$bot = mysql_insert_id();
					//������ ����� ��� ���� ��� �� ������������ �� ����
					$bot_data=$telo;
					$bot_data[id]=$bot;
					$bot_data[login]=$botlogin;
return $bot_data;
}



function start_drevos()
{
$BOTS_conf=array(86,87);

	$get_snows_time=mysql_fetch_array(mysql_query("select * from `variables` where `var`='drevos_out_time' ;"));
	$outtime=$get_snows_time['value'];

	if (date("H")>=$outtime)
	{
	//��������� ����������� �� ��� �������
	$get_snows=mysql_fetch_array(mysql_query("select * from `variables` where `var`='drevos_out' ;"));

	if (($get_snows[value]>0) )
	{
	echo "����-���� ����(�������):���� ���� \n";
	}
	else
	{

  		echo "����-���� ����: ���������... \n";
		//1. ���� ����� ���� ��� �� ������� - ���������
		$get_bots=mysql_fetch_array(mysql_query("select * from users_clons where id_user in (".implode(",",$BOTS_conf).") and bot_online!=-2 limit 1;"));
		if ($get_bots[id]>0)
		{
	 		echo "����-���� ����(�������): ���� ��� ����! \n";
		}
		else
		{
		echo "����-���� ����(�������): ����� ����... ������ \n";
		// ������� ��� ���� ��� ����� �����������
		mysql_query("UPDATE `variables` SET `value`=`value`+1 WHERE `var`='drevos_out';");

		$broom=20; // ������� ��� ����� ���
		$botnames=array();
		$botids=array();


				$get_allbot_name=mysql_query("select id, login  from users where id in (".implode(",",$BOTS_conf).")");
				while($r=mysql_fetch_array($get_allbot_name))
				{
				$botnames[]=$r['login'];
				$botids[]=$r['id'];
				}

				if ($botids[1]==0)
					{
					$botids[1]=$botids[0]; // ���� ��� ������ 1 ��  ������ ���
					$botnames[1]=$botnames[0];
					$botnames[0].=' (������)';
					$botnames[1].=' (������)';
					}

			 $bot1=mk_bot($botids[0],$botnames[0],2,$broom,1);
 			 $bot2=mk_bot($botids[1],$botnames[1],2,$broom,2);

			mysql_query("INSERT INTO `battle`
						(
							`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`t1hist`,`t2hist`,`blood`,`status_flag`,`CHAOS`
						)
						VALUES
						(
							NULL,'<b>����-����</b>','����','3','3','0','".$bot1['id']."','".$bot2['id']."','".time()."','".time()."','".BNewHist($bot1)."','".BNewHist($bot2)."','0','10','2'
						)");
			$id = mysql_insert_id();
			//������ ����� ���
			mysql_query("UPDATE `users_clons` SET `battle` = {$id} WHERE `id` = {$bot1[id]} or `id` = {$bot2[id]} ;");
			echo "����-����: ������� ��� {$id}  \n";

			addlog($id,"!:S:".time().":".BNewHist($bot1).":".BNewHist($bot2)."\n");
			echo "��� ���� ���� (�������) ������!! ���!";

			$TEXT='<font color=red> �������� ������� ������! �� ����������� ������� ������� � �������� �����������! ������� ������� ������� � ������� ����� � �������� �� ������ 150% ������� <a href="http://oldbk.com/encicl/?/runes_info.html" target=_blank>������������</a> � �� 2000 ���������! </font>';
			addch2all($TEXT);

		   }






       }
    }
    elseif((int)(date("H"))==2)
    {
   	echo "����-���� (�������): �������� �����! \n";
     	mysql_query("UPDATE `variables` SET `value`=0 WHERE `var`='drevos_out';");
     	$mtime=mt_rand(16,21);
     	mysql_query("UPDATE `variables` SET `value`='{$mtime}' WHERE `var`='drevos_out_time';");
    }
    else
    {
    echo "����-���� (�������): �� ����� \n";
    }

}

function drevos_stop_hil()
{
$BOTS_conf=array(86,87);
	$get_snow_bot=mysql_fetch_array(mysql_query("select * from users_clons where id_user in (".implode(",",$BOTS_conf).") and bot_online!=-2 and hil<10000  Limit 1;"));




  if ($get_snow_bot[id]>0)
  {
  	//2. ���� ��� � ��� ��������� �����
  	 $get_snow_battle=mysql_fetch_array(mysql_query("select UNIX_TIMESTAMP(`date`) as d  from battle where id='{$get_snow_bot[battle]}' Limit 1;"));
  	 if ($get_snow_battle[d]>0)
  	 {
  	 //3, ��������� ����� ���������
  	 	if (($get_snow_battle['d']+2400)<= time() )
  	 	{
		 //echo " ������ 40 ���";
		 //������ ����� �����
		 mysql_query("UPDATE users_clons set hil=10000 where id_user in (".implode(",",$BOTS_conf).") and bot_online!=-2 ;");
  	 	}
  	 	else
  	 	{
  	 	//echo " ������ 40 ���";
  	 	}

  	 }
  }

}


function start_snowmans()
{
$BOTS_conf=array(89);

	$get_snows_time=mysql_fetch_array(mysql_query("select * from `variables` where `var`='snowmans_out_time' ;"));
	$outtime=$get_snows_time['value'];

	if (date("H")>=$outtime)
	{
	//��������� ����������� �� ��� �������
	$get_snows=mysql_fetch_array(mysql_query("select * from `variables` where `var`='snowmans_out' ;"));

	if (($get_snows[value]>0) )
	{
	echo "����-���� ����:���� ���� \n";
	}
	else
	{

  		echo "����-���� ����: ���������... \n";
		//1. ���� ����� ���� ��� �� ������� - ���������
		$get_bots=mysql_fetch_array(mysql_query("select * from users_clons where id_user in (".implode(",",$BOTS_conf).")  and bot_online!=-2 limit 1;"));
		if ($get_bots[id]>0)
		{
	 		echo "����-���� ����: ���� ��� ����! \n";
		}
		else
		{
		echo "����-���� ����: ����� ����... ������ \n";
		// ������� ��� ���� ��� ����� �����������
		mysql_query("UPDATE `variables` SET `value`=`value`+1 WHERE `var`='snowmans_out';");

		$broom=20; // ������� ��� ����� ���
		$botnames=array();
		$botids=array();


				$get_allbot_name=mysql_query("select id, login  from users where id in (".implode(",",$BOTS_conf).")");
				while($r=mysql_fetch_array($get_allbot_name))
				{
				$botnames[]=$r['login'];
				$botids[]=$r['id'];
				}

				if ($botids[1]==0)
					{
					$botids[1]=$botids[0]; // ���� ��� ������ 1 ��  ������ ���
					$botnames[1]=$botnames[0];
					$botnames[0].=' (������)';
					$botnames[1].=' (������)';
					}

			 $bot1=mk_bot($botids[0],$botnames[0],2,$broom,1);
 			 $bot2=mk_bot($botids[1],$botnames[1],2,$broom,2);

			mysql_query("INSERT INTO `battle`
						(
							`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`t1hist`,`t2hist`,`blood`,`status_flag`,`CHAOS`
						)
						VALUES
						(
							NULL,'<b>����-����</b>','����','3','3','0','".$bot1['id']."','".$bot2['id']."','".time()."','".time()."','".BNewHist($bot1)."','".BNewHist($bot2)."','0','10','2'
						)");
			$id = mysql_insert_id();
			//������ ����� ���
			mysql_query("UPDATE `users_clons` SET `battle` = {$id} WHERE `id` = {$bot1[id]} or `id` = {$bot2[id]} ;");
			echo "����-����: ������� ��� {$id}  \n";

			addlog($id,"!:S:".time().":".BNewHist($bot1).":".BNewHist($bot2)."\n");
			echo "��� ���� ���� ������!! ���!";

			$TEXT='<font color=red> �������� ������� ������! �� ����������� ������� ������� � �������� ���������! ������� ������� ������� � ������� ����� � �������� �� ������ 150% ������� <a href="http://oldbk.com/encicl/?/runes_info.html" target=_blank>������������</a> � �� 2000 ���������! </font>';
			addch2all($TEXT);

		   }






       }
    }
    elseif((int)(date("H"))==2)
    {
   	echo "����-����: �������� �����! \n";
     	mysql_query("UPDATE `variables` SET `value`=0 WHERE `var`='snowmans_out';");
     	$mtime=mt_rand(16,21);
     	mysql_query("UPDATE `variables` SET `value`='{$mtime}' WHERE `var`='snowmans_out_time';");
    }
    else
    {
    echo "����-���� ���������: �� ����� \n";
    }

}

function snowmans_stop_hil()
{
$BOTS_conf=array(89);

	 //1. ���� ����� ���� ������

	$get_snow_bot=mysql_fetch_array(mysql_query("select * from users_clons where id_user in (".implode(",",$BOTS_conf).") and bot_online!=-2 and hil<10000  Limit 1;"));




  if ($get_snow_bot[id]>0)
  {
  	//2. ���� ��� � ��� ��������� �����
  	 $get_snow_battle=mysql_fetch_array(mysql_query("select UNIX_TIMESTAMP(`date`) as d  from battle where id='{$get_snow_bot[battle]}' Limit 1;"));
  	 if ($get_snow_battle[d]>0)
  	 {
  	 //3, ��������� ����� ���������
  	 	if (($get_snow_battle['d']+2400)<= time() )
  	 	{
		 //echo " ������ 40 ���";
		 //������ ����� �����
		 mysql_query("UPDATE users_clons set hil=10000 where id_user in (".implode(",",$BOTS_conf).") and bot_online!=-2 ;");
  	 	}
  	 	else
  	 	{
  	 	//echo " ������ 40 ���";
  	 	}

  	 }
  }

}

function make_attack_by_bot($BOT,$jert) // ������
{
//
//������� - �� ������ �� ���!
	mysql_query("UPDATE `users_clons` SET `battle` = 1 WHERE `id`= ".$BOT[id]." and battle=0 and bot_room=".$jert[room]." ; ");
		if (mysql_affected_rows()>0)
		{
		//��� ������� ����������� - ��� �� � ��� � � ������ �������
			//������� ����
			mysql_query("UPDATE `users` SET `battle` = 1 WHERE `id`= ".$jert[id]." and battle=0 and hp > 10 and zayavka=0 and room=".$BOT[bot_room]." ; ");
			if (mysql_affected_rows()>0)
			{
			//��� ������� ����������� - �.�. �� � ��� � ��������� � ������� ����
			// �������� ���
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sv = array(10,10,10,10,10);  //������ ����
$blood=0; // �� ��������� ��� �� �������� ������ �����
//2. ������� ���
				if (($BOT[id_user]>=42) and ($BOT[id_user]<=65))
				{
				$bbcom='<b>��� � ������� ��������</b>';

						if ($BOT['level']>=10)
						{
						$blood=1;
						}
				}
				else
				{
				$bbcom='<b>��� � ����������� �����</b>';
				}
				mysql_query("INSERT INTO `battle` (`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`win`,`t1hist`,`t2hist`,`blood`,`CHAOS`,`status_flag`)
							VALUES
							(NULL,'{$bbcom}','','".$sv[rand(0,4)]."','6','0','".$BOT['id']."','".$jert['id']."','".time()."','".time()."',3,'".BNewHist($BOT)."','".BNewHist($jert)."','{$blood}','0','0')");
				$battleid = mysql_insert_id();
				//��������� ����
				mysql_query("UPDATE `users_clons` SET `battle` = {$battleid} , `battle_t`=1  WHERE `id`= {$BOT['id']}");
				//���������� ������
				if($jert['hp'] > $jert['maxhp'])
					{
					mysql_query("UPDATE `users` SET `hp` = `maxhp`, `battle_t`=2, `battle`={$battleid}  WHERE `id` = {$jert['id']} ;");
					}
				 else
					 {
					   mysql_query("UPDATE `users` SET  `battle_t`=2, `battle`={$battleid}   WHERE `id` = {$jert['id']} ;");
					 }
//3. ������� ���
					//$rr = "<b>".nick_align_klan($BOT)."</b> � <b>".nick_align_klan($jert)."</b>";
//�������� ���
					$attack_txt=array('�����','����������', '���������');
					//addlog($battleid,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");
					addlog($battleid,"!:S:".time().":".BNewHist($BOT).":".BNewHist($jert)."\n");
					addchp('<font color=red>��������!</font> <B>'.$BOT[login].'</B> '.($attack_txt[mt_rand(0,(count($attack_txt)-1))]).' �� ���.<BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$jert[login].'{[]}',$jert[room],$jert[id_city]);

//��� ������
			return true;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			}
			else
			{
			//��� �� ����������� �.�. ������ ��� ���� � ��� ���....������ ����� ����
			mysql_query("UPDATE `users_clons` SET `battle` = 0 WHERE `id`= ".$BOT[id]." ; ");
			// �������� �������
			return false;
			}

		}
		else
		{
		//������������� �������
		return false;
		}



}

function get_mobs_bylvlgroup($input,$lvl)
{
//����� ��������� ����� ������� ������ �� ��������� ������ (�������)
$out=array();
	foreach($input as $id=>$dat)
		{
		foreach($dat as $key=>$val)
			{
				if (($key=='group_level') and ($val==$lvl) )
					{
					$out[]=$dat;
					}
			}
		}

return $out;
}


if (true)
{
//��� ����� ������
	$get_d=mysql_query("select * from variables where var='demon_time'  ");
	if (mysql_num_rows($get_d) >0)
		{
		$f=mysql_fetch_array($get_d);

		  if ($f['value'] <= time())
		  			{
		  			echo "1. ��������  ���� <br>";
		  				   $bots_online = mysql_fetch_array(mysql_query("select * from `users_clons`  WHERE `id_user`=10000 and  `bot_online`=2; "));
		  				   if ($bots_online['id']>0)
		  				   	{
		  				   	echo "���� ��� <br>";

			  				   	// ������ � ��� ������

									/*
		  				   			if (((date("i")%5)==0) ) //  or (true)
		  				   			{
									echo "�������� � ��� <br>";
		  				   			// 1 ��� � 5 ���
		  				   			$mi=round(date("i")/5);

		  				   				//������ ��������� ����, ������� ���� ������ � ��� 1 ��� � 5 �����:
										$msg= array('������� ��� ���� ������ � ������� �������� ��������� ����������...',
										'� ���� ������� ���������� ����������. ���� ��������.',
										'��, �������, �������� ���������.',
										'������������� �������, ���� ����������� ��������. � ���� ���� ������� �������� �����?..',
										'��� �������������� ���� ������ �����!',
										'���� - ��� ��������!',
										'��� ����� ����������������������������������?',
										'� ���� ������� ������� ���������� ����� ������ �����!',
										'������� ��� ���� ������ � ������� �������� ��������� ����������...',
										'� ���� ������� ���������� ����������. ���� ��������.',
										'��, �������, �������� ���������.',
										'������������� �������, ���� ����������� ��������. � ���� ���� ������� �������� �����?..',
										'��� �������������� ���� ������ �����!');

									 addchp($msg[$mi],$bots_online['login'],$bots_online[bot_room],$bot_city);
									 }
									*/

								if ($bots_online['battle']>0)
								{
								echo "����� ������ �����: {$bots_online['bot_count']} \n";
								if ($bots_online['bot_count']<13)
									{
									echo "���� ������� ������ <br>";
									// ������ ��������� ���� ���
									//1. ������� ������� �����

           	   	 								$bots_online_clons = mysql_fetch_array(mysql_query("select sum(hp) as hp_clons from `users_clons`  WHERE `id_user`=10000 and `battle`='{$bots_online[battle]}' and hp>0 and  `bot_online`=0; "));

           	   	 								$pack=300000; //  ����� �� ��

           	   	 								echo "��: {$bots_online_clons['hp_clons']} hp \n";


           	   	 						if (($bots_online_clons['hp_clons'] <$pack ))
									   {

             	   	 								$BOT= mysql_fetch_array(mysql_query("select * from users where id=10000; "));
											$BOT[protid]=$BOT[id];
											$BOT[protlogin]=$BOT[login];
											$BOT_items=load_mass_items_by_id($BOT);

										//��������� ��  4 ����
										for ($keyto=$bots_online['bot_count'];$keyto<=($bots_online['bot_count']+4);$keyto++)
		       					           	   	{

	       					           	   	 		//����� ������� ��������� �� ���������� �� ���
		           	   	 			   			$data_battle=mysql_fetch_array(mysql_query("SELECT SQL_NO_CACHE * FROM battle where id={$bots_online['battle']} ; "));
					           	   	 			if ( ($data_battle[win]==3)AND($data_battle[status]==0) AND($data_battle['t1_dead']=='' ) )
					           	   	 			{


	       					           	   	 		$BOT['login']=$BOT['protlogin'];
											$BOT['login']=$BOT['login']." (K��� ".($keyto+1).")";

											echo " ������ ����� {$BOT['login']} <br>";

											mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
											`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
											`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
											`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
											`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
											`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
											`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
											`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`='0',`bot`=2,
											`id_user`='{$BOT[protid]}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
											`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
											`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
											`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
											`injury_possible`=0, `battle_t`='{$bots_online[battle_t]}' , bot_online = 0, bot_room='{$bots_online[bot_room]}'   ;"); //������ =0 �.�. ���  �����


											$BOT['id'] = mysql_insert_id();//����� ���-����
	       					           	   	 		// ������ � ��� ����� �� � �������
	       					           	   	 		$time=time();
	       					           	   	 		$za=$bots_online[battle_t];

	       					           	   	 		$add_sql='';
	       					           	   	 		if  ($data_battle['status_flag']!=4)
	       					           	   	 				{
	       					           	   	 				//������ ��� �� �������
			       					           	   	 		$add_sql=" status_flag=4,  type=6, blood=1, coment='<b>��� ���������� �������-����</b>' , " ;

	       					           	   	 				}

 	      					           	   	 		mysql_query('UPDATE `battle` SET '.$add_sql.' to1='.$time.', to2='.$time.', `t'.$za.'`=CONCAT(`t'.$za.'`,\';'.$BOT['id'].'\') , `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($BOT).'\') WHERE `id` = '.$bots_online[battle].' and win=3 and t1_dead=""  ');
      					           	   	 			if (mysql_affected_rows()>0)
      					           	   	 				{
      					           	   	 				//��� ���� ������ ���� �� ���
      					           	   	 				mysql_query("UPDATE `users_clons` SET `battle`='{$bots_online[battle]}' WHERE `id`='{$BOT['id']}' ");

				      					           	   	 	// ���������� �������� � � ���
													$BOT[battle_t]=$bots_online[battle_t];
													$ac=($BOT[sex]*100)+mt_rand(1,2);

													addlog($bots_online[battle],"!:W:".time().":".BNewHist($BOT).":".$BOT[battle_t].":".$ac."\n");


			       					           	   	 		// ��������� �������
			       					           	   	 		mysql_query("UPDATE `users_clons` SET `bot_count`=`bot_count`+1 WHERE `id`='{$bots_online['id']}';");
			       					           	   		}
			       					           	   		else
			       					           	   		{
			       					           	   		// ��� ���������� - ���� �� ����� ����� - ������� ���
			       					           	   		mysql_query("DELETE FROM `users_clons` WHERE `id`='{$BOT['id']}'  LIMIT 1 ");
			       					           	   		break;
			       					           	   		}
	       					           	   	 		}
	       					           	   	 		else
	       					           	   	 		{
												break;
	       					           	   	 		}

	       					           	   		}
	       					           	   	    }

	       					           	   	}
	       					           	   	elseif ($bots_online['hil']!=100000)
	       					           	   		{
	       					           	   		echo "������������� ��� <br>";
	       					           	   		mysql_query("UPDATE users_clons set hil=100000 where id_user=10000 and bot_online=2;");
	       					           	   		echo "������ ���� ���������� ����<br>";

										$next_time=mktime(mt_rand(19,21),0,0,date("n"),(date("d")),date("Y")+1); //+1 ���

	       					           	   		mysql_query("UPDATE `oldbk`.`variables` SET `value`='{$next_time}' WHERE `var`='demon_time';");

	       					           	   		}
	       					           	   	else
	       					           	   	{
	       					           	   		echo "��� ��� ����...��������� <br>";
	       					           	   	}
	       					           	   	}
	       					           	   	else
	       					           	   	{
	       					           	   	echo "��� ���? \n";
	       					           	   	}






		  				   	}
		  				   	else
		  				   	{
		  				   	echo "��� ����  �������";
							//������ ��� ����� ������ ���� ���� ��� �� ��� ������ � ������
											$BOT= mysql_fetch_array(mysql_query("select * from users where id=10000 ;"));
											//��������� ���� �������
											$botroom=50; //50

											//�������� ��� ��� �������� ��� � ���� �������

											$TEXTsta="<font color=red>��������! ����� ������ �������� �� �������! ���� ���������� �������-���� ������ ������� �� �������� �������, ������ ����� ���� ������!</font>";
											addch2all($TEXTsta,$bot_city);


											$BOT[protid]=$BOT[id];
											$BOT_items=load_mass_items_by_id($BOT);
											mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
												`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
												`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
												`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
												`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
												`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
												`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
												`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`=0,`bot`=2,
												`id_user`='{$BOT['id']}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
												`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
												`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
												`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
												`injury_possible`=0, `battle_t`=0 , bot_online = 2, bot_room='{$botroom}'   ;");
												if (mysql_affected_rows() > 0)
													{
													$BOT['id'] = mysql_insert_id();
													echo "��� ������ {$BOT['id']} <br> ";
													}
													else
													{
													echo "error 1";
													}
		  				   	}
		  			}
		  			elseif ($f['value']-3600<= time())
		  			{
		  				/*
					     �� 6 ����� �� ��������� ������� ���� ���� �������� � ����:
		  				*/
		  				/*
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='friday_time_1h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<img src=http://i.oldbk.com/i/align_4.9.gif><b>����� ������ <a href=http://capitalcity.oldbk.com/inf.php?10000 target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> �� �������� ������� ������� <b>���� ���</b>! ��� ������ � ���������� ���?";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='friday_time_1h' ;");
				           	}
				           	*/
					}
		  			elseif ($f['value']-10800<= time())
		  			{

		  				/*
					     �� 3 ����� �� ��������� ������� ���� ���� �������� � ����:
		  				*/
		  				/*
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='friday_time_3h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<img src=http://i.oldbk.com/i/align_4.9.gif><b>����� ������ <a href=http://capitalcity.oldbk.com/inf.php?10000 target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> ������� � ����� ��� ����� <b>��� ����</b>. ��, �����������!";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='friday_time_3h' ;");
				           	}
				           	*/
					}
		  			elseif ($f['value']-21600<= time())
		  			{
		  				/*
					     �� 6 ����� �� ��������� ������� ���� ���� �������� � ����:
		  				*/
		  				/*
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='friday_time_6h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<img src=http://i.oldbk.com/i/align_4.9.gif><b>����� ������<a href=http://capitalcity.oldbk.com/inf.php?10000 target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> �� ����� ������� �������� ����� ���� <b>����� �����</b>! ��� � �����������!";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='friday_time_6h' ;");
				           	}
				           	*/
					}
		  			else
		  			{
		  			echo "��� �� ����� ��� ������ \n";
		  			}
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//if (date("w")==5) // �������
{
//��� �������
	$get_friday=mysql_query("select * from variables where var='friday_time'  ");
	if (mysql_num_rows($get_friday) >0)
		{
		$f=mysql_fetch_array($get_friday);

		  if ($f['value'] <= time())
		  			{
		  				   echo "1. ��������  ������� <br>\n";
		  				   $bots_online = mysql_fetch_array(mysql_query("select * from `users_clons`  WHERE `id_user`=190672 and  `bot_online`=2; "));
		  				   if ($bots_online['id']>0)
		  				   	{
		  				   	echo "���� ��� <br>";
		  				   	// ������ � ��� ������
		  				   		if (((date("i")%5)==0) ) //  or (true)
		  				   			{
									echo "�������� � ��� <br>";
		  				   			// 1 ��� � 5 ���
		  				   			$mi=round(date("i")/5);

		  				   				//������ ��������� ����, ������� ���� ������ � ��� 1 ��� � 5 �����:
										$msg= array('������� ��� ���� ������ � ������� �������� ��������� ����������...',
										'� ���� ������� ���������� ����������. ���� ��������.',
										'��, �������, �������� ���������.',
										'������������� �������, ���� ����������� ��������. � ���� ���� ������� �������� �����?..',
										'��� �������������� ���� ������ �����!',
										'���� - ��� ��������!',
										'��� ����� ����������������������������������?',
										'� ���� ������� ������� ���������� ����� ������ �����!',
										'������� ��� ���� ������ � ������� �������� ��������� ����������...',
										'� ���� ������� ���������� ����������. ���� ��������.',
										'��, �������, �������� ���������.',
										'������������� �������, ���� ����������� ��������. � ���� ���� ������� �������� �����?..',
										'��� �������������� ���� ������ �����!');

									 addchp($msg[$mi],$bots_online['login'],$bots_online[bot_room],$bot_city);
									 }

								if ($bots_online['battle']>0)
								{
								echo "����� ������ �����: {$bots_online['bot_count']} \n";
								if ($bots_online['bot_count']<4) // ����� �����
									{
									echo "���� ������� ������ <br> \n";
									// ������ ��������� ���� ���
									//1. ������� ������� �����

           	   	 								$bots_online_clons = mysql_fetch_array(mysql_query("select sum(hp) as hp_clons from `users_clons`  WHERE `id_user`=190672 and `battle`='{$bots_online[battle]}' and hp>0 and  `bot_online`=0; "));

           	   	 								$pack=300000; //  ����� �� ��

           	   	 								echo "��: {$bots_online_clons['hp_clons']} hp \n";


           	   	 						if (($bots_online_clons['hp_clons'] <$pack ))
									   {

             	   	 								$BOT= mysql_fetch_array(mysql_query("select * from users where id=190672; "));
											$BOT[protid]=$BOT[id];
											$BOT[protlogin]=$BOT[login];
											$BOT_items=load_mass_items_by_id($BOT);

										//��������� ��  4 ����
										for ($keyto=$bots_online['bot_count'];$keyto<=($bots_online['bot_count']+4);$keyto++)
		       					           	   	{

	       					           	   	 		//����� ������� ��������� �� ���������� �� ���
		           	   	 			   			$data_battle=mysql_fetch_array(mysql_query("SELECT SQL_NO_CACHE * FROM battle where id={$bots_online['battle']} ; "));
					           	   	 			if ( ($data_battle[win]==3)AND($data_battle[status]==0) AND($data_battle['t1_dead']=='' ) )
					           	   	 			{


	       					           	   	 		$BOT['login']=$BOT['protlogin'];
											$BOT['login']=$BOT['login']." (K��� ".($keyto+1).")";

											echo " ������ ����� {$BOT['login']} <br>";

											mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
											`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
											`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
											`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
											`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
											`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
											`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
											`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`='0',`bot`=2,
											`id_user`='{$BOT[protid]}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
											`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
											`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
											`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
											`injury_possible`=0, `battle_t`='{$bots_online[battle_t]}' , bot_online = 0, bot_room='{$bots_online[bot_room]}'   ;"); //������ =0 �.�. ���  �����


											$BOT['id'] = mysql_insert_id();//����� ���-����
	       					           	   	 		// ������ � ��� ����� �� � �������
	       					           	   	 		$time=time();
	       					           	   	 		$za=$bots_online[battle_t];
 	      					           	   	 		mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', `t'.$za.'`=CONCAT(`t'.$za.'`,\';'.$BOT['id'].'\') , `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($BOT).'\') WHERE `id` = '.$bots_online[battle].' and win=3 and t1_dead=""  ');
      					           	   	 			if (mysql_affected_rows()>0)
      					           	   	 				{
      					           	   	 				//��� ���� ������ ���� �� ���
      					           	   	 				mysql_query("UPDATE `users_clons` SET `battle`='{$bots_online[battle]}' WHERE `id`='{$BOT['id']}' ");

				      					           	   	 	// ���������� �������� � � ���
													$BOT[battle_t]=$bots_online[battle_t];
													$ac=($BOT[sex]*100)+mt_rand(1,2);

													addlog($bots_online[battle],"!:W:".time().":".BNewHist($BOT).":".$BOT[battle_t].":".$ac."\n");


			       					           	   	 		// ��������� �������
			       					           	   	 		mysql_query("UPDATE `users_clons` SET `bot_count`=`bot_count`+1 WHERE `id`='{$bots_online['id']}';");
			       					           	   		}
			       					           	   		else
			       					           	   		{
			       					           	   		// ��� ���������� - ���� �� ����� ����� - ������� ���
			       					           	   		mysql_query("DELETE FROM `users_clons` WHERE `id`='{$BOT['id']}'  LIMIT 1 ");
			       					           	   		break;
			       					           	   		}
	       					           	   	 		}
	       					           	   	 		else
	       					           	   	 		{
												break;
	       					           	   	 		}

	       					           	   		}
	       					           	   	    }

	       					           	   	}
	       					           	   	elseif ($bots_online['hil']!=100000)
	       					           	   		{

	       					           	   			$data_battle=mysql_fetch_array(mysql_query("SELECT SQL_NO_CACHE * FROM battle where id={$bots_online['battle']} ; "));
	       					           	   			if ( ($data_battle[win]==3)AND($data_battle[status]==0) AND($data_battle['t1_dead']=='' ) )
	       					           	   				{
	       					           	   				//��� ����
	       					           	   					$std=date_create($data_battle['date']);
	       					           	   					if (time()-$std->getTimestamp() >=5400) //��� ���� ������ ��� 1,5 �
	       					           	   					{
				       					           	   		echo "������������� ��� <br> \n";
				       					           	   		mysql_query("UPDATE users_clons set hil=100000 where id_user=190672 and bot_online=2;");
				       					           	   		}
				       					           	   		else
				       					           	   		{
													echo "��� ���� ".(time()-$std->getTimestamp())."���. �� ����� ������������� ��� <br>\n";
				       					           	   		}
			       					           	   		}
	       					           	   		}
	       					           	   	else
	       					           	   	{
	       					           	   		echo "��� ��� ����...��������� <br>\n";
	       					           	   	}
	       					           	   	}
	       					           	   	else
	       					           	   	{
	       					           	   	echo "��� ���? \n";
	       					           	   	}






		  				   	}
		  				   	else
		  				   	{
		  				   	//��� ����
		  				   	$get_out=mysql_fetch_array(mysql_query("select * from variables where var='friday_out'"));
		  				   	if ($get_out['value']>0)
		  				   		{
		  				   		echo "��� ��� ��� \n";

	       					           	   		echo "������ ���� ��������� ������� <br> \n";
										$next_time=mktime(mt_rand(19,21),0,0,date("n"),(date("d")+7),date("Y"));
	       					           	   		mysql_query("UPDATE `oldbk`.`variables` SET `value`='{$next_time}' WHERE `var`='friday_time';");
	       					           	   		mysql_query("UPDATE `variables` SET `value`=0  where `var`='friday_time_1h' or `var`='friday_time_3h' or `var`='friday_time_6h' or var='friday_out' ");

		  				   		}
		  				   		else
		  				   		{

						  				   	echo "��� ����  �������";
											//������ ��� ����� ������ ���� ���� ��� �� ��� ������ � ������
											$BOT= mysql_fetch_array(mysql_query("select * from users where id=190672 ;"));
											//��������� ���� �������
											$botroom=21;

											//�������� ��� ��� �������� ��� � ���� �������
											 $TEXTsta="<font color=red>��������! ������� ������������ ��� � ���������� ������������� � ��������� ����� �� ������������ �����!</font>";
											addch2all($TEXTsta,$bot_city);

											$BOT[protid]=$BOT[id];
											$BOT_items=load_mass_items_by_id($BOT);
											mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
												`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
												`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
												`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
												`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
												`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
												`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
												`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`=0,`bot`=2,
												`id_user`='{$BOT['id']}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
												`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
												`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
												`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
												`injury_possible`=0, `battle_t`=0 , bot_online = 2, bot_room='{$botroom}'   ;");
												if (mysql_affected_rows() > 0)
													{
													$BOT['id'] = mysql_insert_id();
													echo "��� ������ {$BOT['id']} <br> ";
													mysql_query("UPDATE `oldbk`.`variables` SET `value`='1' WHERE `var`='friday_out'");
													}
													else
													{
													echo "error 1";
													}
								}
		  				   	}
		  			}
		  			elseif ($f['value']-3600<= time())
		  			{
		  				/*
					     �� 6 ����� �� ��������� ������� ���� ���� �������� � ����:
		  				*/
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='friday_time_1h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<img src=http://i.oldbk.com/i/align_4.9.gif><b>�������<a href=http://capitalcity.oldbk.com/inf.php?190672 target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> �� �������� ������� ������� <b>���� ���</b>! ��� ������ � ���������� ���?";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='friday_time_1h' ;");
				           	}
					}
		  			elseif ($f['value']-10800<= time())
		  			{
		  				/*
					     �� 6 ����� �� ��������� ������� ���� ���� �������� � ����:
		  				*/
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='friday_time_3h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<img src=http://i.oldbk.com/i/align_4.9.gif><b>�������<a href=http://capitalcity.oldbk.com/inf.php?190672 target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> ������� � ����� ��� ����� <b>��� ����</b>. ��, �����������!";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='friday_time_3h' ;");
				           	}
					}
		  			elseif ($f['value']-21600<= time())
		  			{
		  				/*
					     �� 6 ����� �� ��������� ������� ���� ���� �������� � ����:
		  				*/
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='friday_time_6h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<img src=http://i.oldbk.com/i/align_4.9.gif><b>�������<a href=http://capitalcity.oldbk.com/inf.php?190672 target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> �� ����� ������� �������� ����� ���� <b>����� �����</b>! ��� � �����������!";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='friday_time_6h' ;");
				           	}
					}
		  			else
		  			{
		  			echo "��� �� ����� ������� \n ";
		  			}
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (true) // �����
{
//���
$PROTO_BOT=9;
$botroom=20; //��

	$get_tbot=mysql_query("select * from variables where var='tykvabot_time'  ");
	if (mysql_num_rows($get_tbot) >0)
		{
		$f=mysql_fetch_array($get_tbot);

		  if ($f['value'] <= time())
		  			{
		  			echo "1. ��������  ����� <br>";
		  				   $bots_online = mysql_fetch_array(mysql_query("select * from `users_clons`  WHERE `id_user`='{$PROTO_BOT}' and  `bot_online`=2; "));
		  				   if ($bots_online['id']>0)
		  				   	{
		  				   	echo "���� ��� <br>";

		  				   		// ������ � ��� ������
		  				   		/*
		  				   		if (((date("i")%5)==0) ) //  or (true)
		  				   			{
									echo "�������� � ��� <br>";
		  				   			// 1 ��� � 5 ���
		  				   			$mi=round(date("i")/5);

		  				   				//������ ��������� ����, ������� ���� ������ � ��� 1 ��� � 5 �����:
										$msg= array('������� ��� ���� ������ � ������� �������� ��������� ����������...',
										'� ���� ������� ���������� ����������. ���� ��������.',
										'��, �������, �������� ���������.',
										'������������� �������, ���� ����������� ��������. � ���� ���� ������� �������� �����?..',
										'��� �������������� ���� ������ �����!',
										'���� - ��� ��������!',
										'��� ����� ����������������������������������?',
										'� ���� ������� ������� ���������� ����� ������ �����!',
										'������� ��� ���� ������ � ������� �������� ��������� ����������...',
										'� ���� ������� ���������� ����������. ���� ��������.',
										'��, �������, �������� ���������.',
										'������������� �������, ���� ����������� ��������. � ���� ���� ������� �������� �����?..',
										'��� �������������� ���� ������ �����!');

									 addchp($msg[$mi],$bots_online['login'],$bots_online[bot_room],$bot_city);
									 }
								*/

								if ($bots_online['battle']>0)
								{
								echo "����� ������ �����: {$bots_online['bot_count']} \n";
								if ($bots_online['bot_count']<4) // ����� �����
									{
									echo "���� ������� ������ <br>";
									// ������ ��������� ���� ���
									//1. ������� ������� �����

           	   	 								$bots_online_clons = mysql_fetch_array(mysql_query("select sum(hp) as hp_clons from `users_clons`  WHERE `id_user`='{$PROTO_BOT}' and `battle`='{$bots_online[battle]}' and hp>0 and  `bot_online`=0; "));

           	   	 								$pack=300000; //  ����� �� ��

           	   	 								echo "��: {$bots_online_clons['hp_clons']} hp \n";


           	   	 						if (($bots_online_clons['hp_clons'] <$pack ))
									   {

             	   	 								$BOT= mysql_fetch_array(mysql_query("select * from users where id='{$PROTO_BOT}'; "));
											$BOT[protid]=$BOT[id];
											$BOT[protlogin]=$BOT[login];
											$BOT_items=load_mass_items_by_id($BOT);

										//��������� ��  4 ����
										for ($keyto=$bots_online['bot_count'];$keyto<=($bots_online['bot_count']+4);$keyto++)
		       					           	   	{

	       					           	   	 		//����� ������� ��������� �� ���������� �� ���
		           	   	 			   			$data_battle=mysql_fetch_array(mysql_query("SELECT SQL_NO_CACHE * FROM battle where id={$bots_online['battle']} ; "));
					           	   	 			if ( ($data_battle[win]==3)AND($data_battle[status]==0) AND($data_battle['t1_dead']=='' ) )
					           	   	 			{


	       					           	   	 		$BOT['login']=$BOT['protlogin'];
											$BOT['login']=$BOT['login']." (K��� ".($keyto+1).")";

											echo " ������ ����� {$BOT['login']} <br>";

											mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
											`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
											`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
											`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
											`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
											`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
											`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
											`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`='0',`bot`=2,
											`id_user`='{$BOT[protid]}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
											`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
											`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
											`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
											`injury_possible`=0, `battle_t`='{$bots_online[battle_t]}' , bot_online = 0, bot_room='{$bots_online[bot_room]}'   ;"); //������ =0 �.�. ���  �����


											$BOT['id'] = mysql_insert_id();//����� ���-����
	       					           	   	 		// ������ � ��� ����� �� � �������
	       					           	   	 		$time=time();
	       					           	   	 		$za=$bots_online[battle_t];
 	      					           	   	 		mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', `t'.$za.'`=CONCAT(`t'.$za.'`,\';'.$BOT['id'].'\') , `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($BOT).'\') WHERE `id` = '.$bots_online[battle].' and win=3 and t1_dead=""  ');
      					           	   	 			if (mysql_affected_rows()>0)
      					           	   	 				{
      					           	   	 				//��� ���� ������ ���� �� ���
      					           	   	 				mysql_query("UPDATE `users_clons` SET `battle`='{$bots_online[battle]}' WHERE `id`='{$BOT['id']}' ");

				      					           	   	 	// ���������� �������� � � ���
													$BOT[battle_t]=$bots_online[battle_t];
													$ac=($BOT[sex]*100)+mt_rand(1,2);

													addlog($bots_online[battle],"!:W:".time().":".BNewHist($BOT).":".$BOT[battle_t].":".$ac."\n");


			       					           	   	 		// ��������� �������
			       					           	   	 		mysql_query("UPDATE `users_clons` SET `bot_count`=`bot_count`+1 WHERE `id`='{$bots_online['id']}';");
			       					           	   		}
			       					           	   		else
			       					           	   		{
			       					           	   		// ��� ���������� - ���� �� ����� ����� - ������� ���
			       					           	   		mysql_query("DELETE FROM `users_clons` WHERE `id`='{$BOT['id']}'  LIMIT 1 ");
			       					           	   		break;
			       					           	   		}
	       					           	   	 		}
	       					           	   	 		else
	       					           	   	 		{
												break;
	       					           	   	 		}

	       					           	   		}
	       					           	   	    }

	       					           	   	}
	       					           	   	elseif ($bots_online['hil']!=100000)
	       					           	   		{
	       					           	   		echo "������������� ��� <br>";
	       					           	   		mysql_query("UPDATE users_clons set hil=100000 where id_user='{$PROTO_BOT}' and bot_online=2;");

	       					           	   		echo "������ ���� ����������<br>";

										$next_time=mktime(12,0,0,date("n"),date("d"),(date("Y")+1) );

	       					           	   		mysql_query("UPDATE `oldbk`.`variables` SET `value`='{$next_time}' WHERE `var`='tykvabot_time';");


	       					           	   		mysql_query("UPDATE `variables` SET `value`=0  where `var`='tykvabot_time_1h' or `var`='tykvabot_time_3h' or `var`='tykvabot_time_6h' ");


	       					           	   		}
	       					           	   	else
	       					           	   	{
	       					           	   		echo "��� ��� ����...��������� <br>";
	       					           	   	}
	       					           	   	}
	       					           	   	else
	       					           	   	{
	       					           	   	echo "��� ���? \n";
	       					           	   	}






		  				   	}
		  				   	else
		  				   	{
		  				   	echo "��� ����  �������";
							//������ ��� ����� ������ ���� ���� ��� �� ��� ������ � ������
											$BOT= mysql_fetch_array(mysql_query("select * from users where id='{$PROTO_BOT}' ;"));
											//��������� ���� �������

											//�������� ��� ��� �������� ��� � ���� �������


											$TEXTsta="<font color=red>��������! ����� ������������ ��� � ���������� ������������� � ����������� ����� �� ����������� �������!</font>";
											addch2all($TEXTsta,$bot_city);

											$BOT[protid]=$BOT[id];
											$BOT_items=load_mass_items_by_id($BOT);
											mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
												`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
												`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
												`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
												`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
												`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
												`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
												`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`=0,`bot`=2,
												`id_user`='{$BOT['id']}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
												`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
												`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
												`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
												`injury_possible`=0, `battle_t`=0 , bot_online = 2, bot_room='{$botroom}'   ;");
												if (mysql_affected_rows() > 0)
													{
													$BOT['id'] = mysql_insert_id();
													echo "��� ������ {$BOT['id']} <br> ";
													}
													else
													{
													echo "error 1";
													}
		  				   	}
		  			}

		  			elseif ($f['value']-3600<= time())
		  			{
		  				// �� 1 ����� �� ��������� ������� ���� ���� �������� � ����:
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='tykvabot_time_1h'  "));
		  				if ($get_6h['value']==0)
		  				{
						 $TEXTsta="<b>�����<a href=http://capitalcity.oldbk.com/inf.php?{$PROTO_BOT} target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> �� �������� ������� ������� <b>���� ���</b>! ��� ������ � ������������ ���?";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='tykvabot_time_1h' ;");
				           	}
					}
		  			elseif ($f['value']-10800<= time())
		  			{
						//   �� 2 ����� �� ��������� ������� ���� ���� �������� � ����:
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='tykvabot_time_3h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<b>�����<a href=http://capitalcity.oldbk.com/inf.php?{$PROTO_BOT} target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> ������� � ����� ��� ����� <b>��� ����</b>. ��, �����������!";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='tykvabot_time_3h' ;");
				           	}
					}
		  			elseif ($f['value']-21600<= time())
		  			{
						//    �� 6 ����� �� ��������� ������� ���� ���� �������� � ����:
	  					$get_6h=mysql_fetch_array(mysql_query("select * from variables where var='tykvabot_time_6h'  "));
		  				if ($get_6h['value']==0)
		  				{
						$TEXTsta="<b>�����<a href=http://capitalcity.oldbk.com/inf.php?{$PROTO_BOT} target=_blank><img src=http://i.oldbk.com/i/inf.gif></a>:</b> �� ����� ������� �������� ����� ���� <b>����� �����</b>! ��� � �����������!";
						addch2all($TEXTsta,$bot_city);
				           	mysql_query("UPDATE `variables` SET `value`=1  where `var`='tykvabot_time_6h' ;");
				           	}
					}
		  			else
		  			{
		  			echo "��� �� ����� �����";
		  			}
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//������� - � ������������ �������� �� ������� ������
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (true)
{
$all_lvl=0;
$not_time=0;
//1. ����������� ����� ������ ���� ����
$sqlget="select * from variables where var like 'bots_start_time_level_%' ";
$q_get=mysql_query($sqlget);
if (mysql_num_rows($q_get) >0)
 {
 // ���� ������ ��������
  echo "���� ������...��������<br>";

  	$bots_lvls=array();
	while($r=mysql_fetch_array($q_get))
			{
			$lvls=(int)str_replace('bots_start_time_level_','',$r['var']);
			$bots_lvls[$lvls]=$r['value'];
			$all_lvl++;
			}
ksort($bots_lvls);
print_r($bots_lvls);

	foreach($bots_lvls as $bot_lvl=>$bot_time)
		{
echo "����: ".$bot_lvl."  \n ";
				   if ($bot_time <= time())
				   	{
				   	echo "<b>����� �������  ��� $bot_lvl </b><br> \n ";

									//�������� � ������ ��� ������
				  					$getmsg=mysql_fetch_array(mysql_query("select * from variables where var='message".$bot_lvl."_time_start'  "));
					  				if ($getmsg['value']==0)
					  				{
									$TEXT="��������! �������! ���� ������� ������! ������� ������� ����������� �������! ��� �� ������ ������ �� ���������!";
									echo $TEXT;
									echo "\n";
									addch2levels($TEXT,$bot_lvl,$bot_lvl,0);
							           	mysql_query("UPDATE `variables` SET `value`=1  where var='message".$bot_lvl."_time_start'  ;");
							           	}



				   	$config_mobs=get_mobs_bylvlgroup($v_mobs,$bot_lvl); // �������� �� ������� ������ �����
				   	$dead_bot=0;
			   		$all_bot=0;

						//������� ���� �� �����
							foreach($config_mobs as $keymob=>$valmob)
							{
							if ($config_mobs[$keymob]['master_bot'] > 0)
						                       {
							$all_bot++;
										echo "�������� ������ ������ ���� �� ���� ������ <br>\n";
											// ����� �� ��� � �������
											// � ����������� bot_online = 2 � ��������� ������ 2-�
											$bbot=mysql_query("select * from users_clons where id_user=".$config_mobs[$keymob]['master_bot']." and bot_online = 2;");
											        if (mysql_num_rows($bbot) >0)
												{
												$bbot=mysql_fetch_array($bbot);
												echo " ���� ������ ������ ������ ��� ������  <br>\n";

												if (mt_rand(1,200)<=5)
												 {
												 //�������� ������ ��������� ������ ��� � �������
												 $fr=mt_rand(0,count($bot_mess)-1);
												 addchp($bot_mess[$fr],$bbot[login],$bbot[bot_room],$bot_city);
												 }

												//��������� � ��� ��� ��� ������ ���
												 if (!($bbot[battle] > 0))
												 {
												 $nextgo=false;

							       					       echo "���: ".$bbot[login]." �� � ���! <br>\n";
							       					        ///
							       					        // ������ ���� ���������
							       					        // ���� �� ���� �������
							       					        /* http://tickets.oldbk.com/issue/oldbk-1507 - ��������� ���� ���������*/
													$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=14"));
													//������ ����� ��������
													if ($get_ivent['stat']==1)
													{
							       					        echo "������ ����� ��������!!! ��� ������! <br>\n";
							       					        $kandid = "select * FROM  `users`  WHERE `odate` >= ".(time()-60)." AND
							       					        					 `room` = ".$bbot['bot_room']." AND bot=0  AND
							       					        					  hp > (maxhp*0.33) AND battle=0 AND zayavka=0  AND klan!='radminion' AND klan!='Adminion' AND
							       					        					  `level` >= ".$config_mobs[$keymob]['min_level']." AND
							       					        					  `level` <= ".$config_mobs[$keymob]['max_level']." AND
							       					        					  id not in (SELECT `owner` FROM `effects` WHERE (`type` = 11 OR `type` = 12 OR `type` = 13 OR `type` = 14 OR `type` = 830 ) ) ORDER by level DESC;";

													$kand=mysql_query($kandid);
													if (mysql_num_rows($kand)>0)
							       					        		{
							       					        		$telo=mysql_fetch_array($kand);
							       					        		echo "���� ��������...������� ������� �� ".$telo[login]."  <br>\n";

							       					        		if (make_attack_by_bot($bbot,$telo))
						     					        		     	     {
						     					        		     	     //�������� ��� ����� ����
						     					        		     	     echo "���������� ������� <br>";
						     					        		     	     //������������ ������
						     					        		     	     $bbot=mysql_query("select * from users_clons where id_user=".$config_mobs[$keymob]['master_bot']." and bot_online = 2;");
						     					        		     	     $bbot=mysql_fetch_array($bbot);

															     $fr=mt_rand(0,count($bot_mess)-1);
										 					     addchp($bot_mess[$fr],$bbot[login],$bbot[bot_room],$bot_city);
						     					        		     	     }
						     					        		     	     else
						     					        		     	     {
						     					        		     	     echo "������� �� �����...c���� ��� ���� ������  <br>\n";
						     					        		     	     }

							       					        		}
							       					        		else
							       					        		{
							       					        		$nextgo=true;
							       					        		}
							       					        }
					       					        		else
						       					        		{
						       					        		$nextgo=true;
						       					        		}



							       					        	if ($nextgo==true)
							       					        		{
							       					        		echo " ����������� � ������ �������  <br>\n";
							       					        		// �������� � �������� � ������ �������
															//��������� ���� �������
															$br=$config_mobs[$keymob]['room'];
															$rnd_room=mt_rand(0,count($br)-1);
															$botroom=$br[$rnd_room];
															echo " ������� ��� ��� �������� $botroom  <br>\n";
							       					        		mysql_query("UPDATE `users_clons` SET `bot_room`='{$botroom}' WHERE `id`='{$bbot['id']}';");
							       					        		}
							       					   }

												//��������� � ��� ��� ���? 2-� ���
												 if ($bbot[battle] > 0)
							       					        {
							       					        // �� � ���
							       					        echo "<i>���:</i> ".$bbot[login]." � ���!  <br>\n";
							       					          // ��������� �������� �� �� ���� ������� �����
							       					           $bots_team=$config_mobs[$keymob]['bots'];
							       					           if ($bbot[bot_count] >=(count($bots_team)-1))
							       					           	{
							       					           	 echo "���� ������ ��� ��������  <br>\n";
							       					           	}
							       					           	else
							       					           	{
							       					           	echo "����� ��� ��� �� ��� - ���������  <br>\n";
							       					           	   foreach($bots_team as $keyto=>$valto)
							       					           	   	{
							       					           	   	 if ($keyto>$bbot[bot_count])
							       					           	   	 		{
							       					           	   	 		//����� ������� ��������� �� ���������� �� ���
								           	   	 			   			$data_battle=mysql_fetch_array(mysql_query("SELECT SQL_NO_CACHE * FROM battle where id={$bbot[battle]} ; "));
											           	   	 			if ( ($data_battle[win]!=3)AND($data_battle[status]!=0))
											           	   	 			{
											           	   	 			break;
											           	   	 			}

							       					           	   	 	echo "��������� ���� - $valto  <br>\n";

						             	   	 								$BOT= mysql_fetch_array(mysql_query("select * from users where id=".$valto." ;"));
																	$BOT[protid]=$BOT[id];
																	$BOT_items=load_mass_items_by_id($BOT);
																	$BOT['login']=$BOT['login']." (".($keyto+1).")";

																	mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
																	`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
																	`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
																	`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
																	`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
																	`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
																	`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
																	`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`='{$bbot[battle]}',`bot`=2,
																	`id_user`='{$BOT['id']}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
																	`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
																	`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
																	`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
																	`injury_possible`=0, `battle_t`='{$bbot[battle_t]}' , bot_online = 1, bot_room='{$bbot[bot_room]}'   ;"); //������ =1 �.�. ��� �� ������ ����
																	echo mysql_error();
																	$BOT['id'] = mysql_insert_id();
							       					           	   	 		// ������ � ��� ����� �� � �������
							       					           	   	 		$time=time();
							       					           	   	 		$za=$bbot[battle_t];
						 	      					           	   	 		mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', `t'.$za.'`=CONCAT(`t'.$za.'`,\';'.$BOT['id'].'\') , `t'.$za.'hist`=CONCAT(`t'.$za.'hist`,\''.BNewHist($BOT).'\') WHERE `id` = '.$bbot[battle].'  ;');

							       					           	   	 		// ���������� �������� � � ���
							       					           	   	 		if ($BOT['sex'] == 1) {$action="����������";}	else {$action="�����������";}
							       					           	   	 		$sexi[0]='���������';
																	$sexi[1]='��������';

																	$BOT[battle_t]=$bbot[battle_t];
																	$ac=($BOT[sex]*100)+mt_rand(1,2);

																	addlog($bbot[battle],"!:W:".time().":".BNewHist($BOT).":".$BOT[battle_t].":".$ac."\n");

							       					           	   	 		// ��������� �������
							       					           	   	 		mysql_query("UPDATE `users_clons` SET `bot_count`=`bot_count`+1 WHERE `id`='{$bbot['id']}';");

							       					           	   	 		}
							       					           	   	}

							       					           	}


							       					        }
												}
												else
												{
												echo " ���� ���� � ������� id:{$config_mobs[$keymob]['master_bot']} <br>\n";

												// �������� ������ �� �������� ���� �� ��������� ����� �� ��� ��� �������?
									           		$run_master=mysql_fetch_array(mysql_query("select * from variables where var='bots_lvl_".$config_mobs[$keymob]['group_level']."_".$config_mobs[$keymob]['master_bot']."_is_run' ; "));
												           if ($run_master[value] >0)
											                        	{
									                		        	// � ���� ����� ������ ��� ��� ������� � ��� ��� � ��� �����
									                        			echo "���� ��� ��� ��� � ������� ��� �����  <br>\n";
									                        			 $dead_bot++;
									                        			}
								                        				else
												                	    	{

																	echo "���� ��� ������� � ������ <br>\n";

																	//������ ��� ����� ������ ���� ���� ��� �� ��� ������ � ������
																	mysql_query("INSERT `variables` (`var`,`value`) values('bots_lvl_".$config_mobs[$keymob]['group_level']."_".$config_mobs[$keymob]['master_bot']."_is_run', '1' ) ON DUPLICATE KEY UPDATE `value` =1;");

																	$BOT= mysql_fetch_array(mysql_query("select * from users where id=".$config_mobs[$keymob]['master_bot']." ;"));
																	//��������� ���� �������
																	$br=$config_mobs[$keymob]['room'];
																	$rnd_room=mt_rand(0,count($br)-1);
																	$botroom=$br[$rnd_room];
																	echo " ������� ��� ��� �������� $botroom  <br>\n";

																	//�������� ��� ��� �������� ��� � ���� �������
																	 $fr=mt_rand(0,count($bot_mess)-1);
																	 addchp($bot_mess[$fr],$BOT['login']." (1)",$botroom,$bot_city);

																	$BOT[protid]=$BOT[id];
																		$BOT_items=load_mass_items_by_id($BOT);
																		mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']." (1)',`sex`='{$BOT['sex']}',
																		`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
																		`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
																		`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
																		`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
																		`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
																		`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
																		`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`=0,`bot`=2,
																		`id_user`='{$BOT['id']}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
																		`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
																		`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
																		`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
																		`injury_possible`=0, `battle_t`=0 , bot_online = 2, bot_room='{$botroom}'   ;");
																		echo mysql_error();
																		$BOT['id'] = mysql_insert_id();

																}
												}
										} // ������ ���
						                       } //��.����


						   		if ($dead_bot >=$all_bot)
						   			{
						   			echo "������ ����� ������� - ��� ����� ������ <br>\n";

										$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=14"));
										//������ ����� ��������
										if ($get_ivent['stat']==1)
										{
										$next_time=time()+(6*60*60);//6 � ��������� �����
										echo "������ ����� ��������!!! 6�  ��������� ����� <br>\n";
										}
										else
										{
										$next_time=time()+(12*60*60);//12 � ��������� �����
										echo "12�  ��������� ����� <br>\n";
										}


									echo "�������� ���� ����� ���� ��������� ������ ���� ������ <br>\n";
							           	mysql_query("UPDATE `variables` SET `value`=0  where `var` like 'bots_lvl_".$bot_lvl."_%_is_run' ;");
									echo "UPDATE `variables` SET `value`=0  where `var` like 'bots_lvl_".$bot_lvl."_%_is_run' ; <br> \n" ;

									echo "�������� ��������� ������ ����� �������� <br>\n";
							           	mysql_query("UPDATE `variables` SET `value`=0  where var like 'message".$bot_lvl."_time_%'  ;");
							           	echo "UPDATE `variables` SET `value`=0  where var like 'message".$bot_lvl."_time_%'  ;";

							           	  //������ ������ ����� ����.������
							  	 	mysql_query("UPDATE `variables` SET `value`='{$next_time}' where `var`='bots_start_time_level_".$bot_lvl."' ;");
							  	 	echo "UPDATE `variables` SET `value`='{$next_time}' where `var`='bots_start_time_level_".$bot_lvl."' ; <br>\n" ;

									$TEXT="<font color=red>��������! ����� �������� ������. ������ � ����� ����� ��������� �� ����� ������...</font>";
									echo $TEXT;echo "\n";
									addch2levels($TEXT,$bot_lvl,$bot_lvl,0);
						   			}
				   	echo "LVL: $bot_lvl / DEAD=$dead_bot /  ALL=$all_bot <br> \n";
				   	echo "--------------------------------<br> \n";

				   	}
				   	else  if ($bot_time-900 <= time())
				   	{
				   	echo "�� ������ ��� $bot_lvl -� ����� <br> - �������� �������� 900 \n";
	  					$getmsg=mysql_fetch_array(mysql_query("select * from variables where var='message".$bot_lvl."_time_15m'  "));
		  				if ($getmsg['value']==0)
		  				{
		  					$cmobs=get_mobs_bylvlgroup($v_mobs,$bot_lvl); // �������� �� ������� ������ �����
		  					$botid=$cmobs[0]['master_bot'];
		  					$Bt= mysql_fetch_array(mysql_query("select * from users where id=".$botid." ;"));

						$TEXT="<img src=http://i.oldbk.com/i/align_4.9.gif><b>".$Bt['login']."<a href=http://capitalcity.oldbk.com/inf.php?".$Bt['id']." target=_blank><img src=http://i.oldbk.com/i/inf.gif></a></b></font><font color=black>: ������! � ��� ���� �����, ����� �������� ���� ������. �� ������ ������! ����� <b>15 �����</b> ���� ��� ������� � ������! ";
						echo $TEXT;
						echo "\n";
						addch2levels($TEXT,$bot_lvl,$bot_lvl,0);
				           	mysql_query("UPDATE `variables` SET `value`=1  where var='message".$bot_lvl."_time_15m'  ;");
				           	}

				   	}
				   	else  if ($bot_time-10800 <= time())
				   	{
				   	echo "�� ������ ��� $bot_lvl -� ����� <br> - �������� �������� 10800 \n";
				   		//������ (12)����������: ��� ����. ��� �������� ����� ��� ����! �� ��� ������. ������ ����� ������ �� ��� �� ��������� � �����!
	  					$getmsg=mysql_fetch_array(mysql_query("select * from variables where var='message".$bot_lvl."_time_3h'  "));
		  				if ($getmsg['value']==0)
		  				{
		  					$cmobs=get_mobs_bylvlgroup($v_mobs,$bot_lvl); // �������� �� ������� ������ �����
		  					$botid=$cmobs[0]['master_bot'];
		  					$Bt= mysql_fetch_array(mysql_query("select * from users where id=".$botid." ;"));

						$TEXT="<img src=http://i.oldbk.com/i/align_4.9.gif><b>".$Bt['login']."<a href=http://capitalcity.oldbk.com/inf.php?".$Bt['id']." target=_blank><img src=http://i.oldbk.com/i/inf.gif></a></b></font><font color=black>: ��� ����. ��� �������� ����� <b>��� ����</b>! �� ��� ������. ������ ����� ������ �� ��� �� ��������� � �����! ";
						echo $TEXT;
						echo "\n";
						addch2levels($TEXT,$bot_lvl,$bot_lvl,0);
				           	mysql_query("UPDATE `variables` SET `value`=1  where var='message".$bot_lvl."_time_3h'  ;");
				           	}


				   	}
				   	else  if ($bot_time-21600 <= time())
				   	{
				   	echo "�� ������ ��� $bot_lvl -� ����� <br> - �������� �������� 21600 \n";
				   		//������ (12)����������: ���� ��� � ����! ��� ����� ����� ����� ����� �� ������, ����� �� ������ ��� ����� �� ���!
				   		$getmsg=mysql_fetch_array(mysql_query("select * from variables where var='message".$bot_lvl."_time_6h'  "));
		  				if ($getmsg['value']==0)
		  				{
		  					$cmobs=get_mobs_bylvlgroup($v_mobs,$bot_lvl); // �������� �� ������� ������ �����
		  					$botid=$cmobs[0]['master_bot'];
		  					$Bt= mysql_fetch_array(mysql_query("select * from users where id=".$botid." ;"));

						$TEXT="<img src=http://i.oldbk.com/i/align_4.9.gif><b>".$Bt['login']."<a href=http://capitalcity.oldbk.com/inf.php?".$Bt['id']." target=_blank><img src=http://i.oldbk.com/i/inf.gif></a></b></font><font color=black>: ���� ��� � ����! ��� ����� ����� <b>����� �����</b> �� ������, ����� �� ������ ��� ����� �� ���!";
						echo $TEXT;
						echo "\n";
						addch2levels($TEXT,$bot_lvl,$bot_lvl,0);
				           	mysql_query("UPDATE `variables` SET `value`=1  where var='message".$bot_lvl."_time_6h'  ;");
				           	}

				   	}
				   	else
				   	{
				   	echo "�� ������ ��� $bot_lvl -� ����� <br> \n";
				   	echo date("Y.m.d H:i:s",$bot_time);
				   	echo "<br>\n";
					$not_time++;
				   	}
		}

   //��������
//   1. "����� �������� ������..." �������� ������ ���� ��� ������ �������� ���� �� �������
//2. "������� ������� �����" �������� � ���������� ������ �������� ����� ��������

   	/*
	if ($not_time==$all_lvl) // � ���� ����� �� �����
           	{
           	// ���������� ������ �������
           	echo "��� ���� ������� - ����� �� ������� <br> \n";
           	$sys_warn="select * from variables where var='bots_finish_sysm' ; ";
		$sys_warn=mysql_fetch_array(mysql_query($sys_warn));
			 if ($sys_warn[value]==0) //�������� ��� �� ����
			 	{
		  	 	$TEXT="<font color=red>��������! ����� �������� ������. ������ � ����� ����� ��������� �� ����� ������...</font>";
		  	 	echo $TEXT;
		  	 	echo "<br>\n";
				addch2all($TEXT,$bot_city);
				mysql_query("UPDATE variables set value=1 where var='bots_finish_sysm' ; ");
				//������ ����� ��������� ��������
				mysql_query("UPDATE  variables  set  value =0 where var='bots_start_sysm' ; ");
				}
				else
				{
				echo "�������� � ������  ��� ���� <br>\n";
				}

           	}
           	else
           	   if ($not_time==$all_lvl-1)
			   	{
			   	$sys_warn="select * from variables where var='bots_start_sysm' ; ";
				$sys_warn=mysql_fetch_array(mysql_query($sys_warn));
				 if ($sys_warn[value]==0) //�������� ��� �� ����
				 	{
					$TEXT="<font color=red>��������! �������! ���� ������� ������! ������� ������� ����������� �������! ��� �� ������ ������ �� ���������!</font>";
					addch2all($TEXT,$bot_city);
			  	 	echo $TEXT;
			  	 	echo "<br>\n";
					mysql_query("UPDATE variables set value=1 where var='bots_start_sysm' ; ");
					//����� ����� �������� ��������
					mysql_query("UPDATE variables set value=0 where var='bots_finish_sysm' ; ");
					}
					else
					{
					echo "�������� � ������ ����� ��� ���� <br>\n";
					}
			   	}
           	*/


          }
///////////////////////////////////////////////////////////////////////////////////////////////////////////
	   else
				{
				echo "��� ������ � ������ ����!...\n";
				}
	}

///////////////////
/////////���� ����� select * from users where id>=137 and id<=164
	$hbots_rooms=array(44);
	//�������� ����� ������� ���� ��������� ��� �����������
	$get_hbots=mysql_query("select * from users where id>=137 and id<=164 and fullhptime<=UNIX_TIMESTAMP()");
	if (mysql_num_rows($get_hbots) >0)
		{
			while($hbot=mysql_fetch_array($get_hbots))
			{
			shuffle($hbots_rooms);
			$hbotroom=$hbots_rooms[0];

				$get_move_bots=mysql_fetch_array(mysql_query("select * from users_clons where id_user={$hbot['id']};"));
				if ($get_move_bots['id']>0)
					{
						echo "���� ����� H��� protoBOT {$hbot['id']} => {$get_move_bots['id']} --- " ;
						if ($get_move_bots['battle']==0)
							{
							echo "�� � ��� ����� ������� � room {$hbotroom}  \n";
							//��������� �� �������
							mysql_query("update users_clons set bot_room='{$hbotroom}' where id='{$get_move_bots['id']}' and battle=0 limit 1;");
							}
							else
							{
							echo " � ��� \n";
							}

					}
					else
					{
					echo "��� ������ H���� protoBOT {$hbot['id']} = �������! \n";
						$hbot_items=load_mass_items_by_id($hbot);
						mysql_query("INSERT INTO `users_clons` SET `login`='".$hbot['login']."',`sex`='{$hbot['sex']}',
						`level`='{$hbot['level']}',`align`='{$hbot['align']}',`klan`='{$hbot['klan']}',`sila`='{$hbot['sila']}',
						`lovk`='{$hbot['lovk']}',`inta`='{$hbot['inta']}',`vinos`='{$hbot['vinos']}',
						`intel`='{$hbot['intel']}',`mudra`='{$hbot['mudra']}',`duh`='{$hbot['duh']}',`bojes`='{$hbot['bojes']}',`noj`='{$hbot['noj']}',
						`mec`='{$hbot['mec']}',`topor`='{$hbot['topor']}',`dubina`='{$hbot['dubina']}',`maxhp`='{$hbot['maxhp']}',`hp`='{$hbot['maxhp']}',
						`maxmana`='{$hbot['maxmana']}',`mana`='{$hbot['mana']}',`sergi`='{$hbot['sergi']}',`kulon`='{$hbot['kulon']}',`perchi`='{$hbot['perchi']}',
						`weap`='{$hbot['weap']}',`bron`='{$hbot['bron']}',`r1`='{$hbot['r1']}',`r2`='{$hbot['r2']}',`r3`='{$hbot['r3']}',`helm`='{$hbot['helm']}',
						`shit`='{$hbot['shit']}',`boots`='{$hbot['boots']}',`nakidka`='{$hbot['nakidka']}',`rubashka`='{$hbot['rubashka']}',`shadow`='{$hbot['shadow']}',`battle`=0,`bot`=3,
						`id_user`='{$hbot['id']}',`at_cost`='{$hbot_items['allsumm']}',`kulak1`=0,`sum_minu`='{$hbot_items['min_u']}',
						`sum_maxu`='{$hbot_items['max_u']}',`sum_mfkrit`='{$hbot_items['krit_mf']}',`sum_mfakrit`='{$hbot_items['akrit_mf']}',
						`sum_mfuvorot`='{$hbot_items['uvor_mf']}',`sum_mfauvorot`='{$hbot_items['auvor_mf']}',`sum_bron1`='{$hbot_items['bron1']}',
						`sum_bron2`='{$hbot_items['bron2']}',`sum_bron3`='{$hbot_items['bron3']}',`sum_bron4`='{$hbot_items['bron4']}',`ups`='{$hbot_items['ups']}',
						`injury_possible`=0, `battle_t`=0 , bot_online = 2, bot_room='{$hbotroom}'   ;");
						echo mysql_error();
					}


			}
		}
		else
		{
		echo "��� ����� ����� ��� ���������. \n";
		}
////////////

//���� �����
if (false)
{
///////////////////
/////////���� ����� - �������� ����� ������ � �������
	$hbots_rooms=array(1,5,9,10,8,20,21,66,26,50);
	//�������� ����� ������� ���� ��������� ��� �����������
	$get_hbots=mysql_query("select * from users where ((id>=165 and id<=186) OR (id>=281 and id<=286))   and fullhptime<=UNIX_TIMESTAMP()");
	if (mysql_num_rows($get_hbots) >0)
		{
			while($hbot=mysql_fetch_array($get_hbots))
			{
			shuffle($hbots_rooms);
			$hbotroom=$hbots_rooms[0];

				$get_move_bots=mysql_fetch_array(mysql_query("select * from users_clons where id_user={$hbot['id']};"));
				if ($get_move_bots['id']>0)
					{
						echo "���� ����� H��� protoBOT {$hbot['id']} => {$get_move_bots['id']} --- " ;
						if ($get_move_bots['battle']==0)
							{
							echo "�� � ��� ����� ������� � room {$hbotroom}  \n";
							//��������� �� �������
							mysql_query("update users_clons set bot_room='{$hbotroom}' where id='{$get_move_bots['id']}' and battle=0 limit 1;");
							}
							else
							{
							echo " � ��� \n";
							}

					}
					else
					{
					echo "��� ������ H���� protoBOT {$hbot['id']} = �������! \n";
						$hbot_items=load_mass_items_by_id($hbot);
						mysql_query("INSERT INTO `users_clons` SET `login`='".$hbot['login']."',`sex`='{$hbot['sex']}',
						`level`='{$hbot['level']}',`align`='{$hbot['align']}',`klan`='{$hbot['klan']}',`sila`='{$hbot['sila']}',
						`lovk`='{$hbot['lovk']}',`inta`='{$hbot['inta']}',`vinos`='{$hbot['vinos']}',
						`intel`='{$hbot['intel']}',`mudra`='{$hbot['mudra']}',`duh`='{$hbot['duh']}',`bojes`='{$hbot['bojes']}',`noj`='{$hbot['noj']}',
						`mec`='{$hbot['mec']}',`topor`='{$hbot['topor']}',`dubina`='{$hbot['dubina']}',`maxhp`='{$hbot['maxhp']}',`hp`='{$hbot['maxhp']}',
						`maxmana`='{$hbot['maxmana']}',`mana`='{$hbot['mana']}',`sergi`='{$hbot['sergi']}',`kulon`='{$hbot['kulon']}',`perchi`='{$hbot['perchi']}',
						`weap`='{$hbot['weap']}',`bron`='{$hbot['bron']}',`r1`='{$hbot['r1']}',`r2`='{$hbot['r2']}',`r3`='{$hbot['r3']}',`helm`='{$hbot['helm']}',
						`shit`='{$hbot['shit']}',`boots`='{$hbot['boots']}',`nakidka`='{$hbot['nakidka']}',`rubashka`='{$hbot['rubashka']}',`shadow`='{$hbot['shadow']}',`battle`=0,`bot`=3,
						`id_user`='{$hbot['id']}',`at_cost`='{$hbot_items['allsumm']}',`kulak1`=0,`sum_minu`='{$hbot_items['min_u']}',
						`sum_maxu`='{$hbot_items['max_u']}',`sum_mfkrit`='{$hbot_items['krit_mf']}',`sum_mfakrit`='{$hbot_items['akrit_mf']}',
						`sum_mfuvorot`='{$hbot_items['uvor_mf']}',`sum_mfauvorot`='{$hbot_items['auvor_mf']}',`sum_bron1`='{$hbot_items['bron1']}',
						`sum_bron2`='{$hbot_items['bron2']}',`sum_bron3`='{$hbot_items['bron3']}',`sum_bron4`='{$hbot_items['bron4']}',`ups`='{$hbot_items['ups']}',
						`injury_possible`=0, `battle_t`=0 , bot_online = 2, bot_room='{$hbotroom}'   ;");
						echo mysql_error();
					}


			}
		}
		else
		{
		echo "��� ����� ���� ��� ���������. \n";
		}
////////////
}






	if  ($ZIMA)
	{
		echo "���� ���� ���������� \n";

		start_snowmans();
		snowmans_stop_hil();
	}
	else
	{
		///���� ����  �������
		start_drevos();
		drevos_stop_hil();
	}

lockDestroy("cron_voln");
?>
