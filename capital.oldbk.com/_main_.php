<?
/*ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/
$m_selectime = 0;
$m_usetime = 0;
$m_massatime = 0;
$m_alltime = microtime(true);
$m_part1 = 0;
$m_part2 = 0;
$m_rendertime = 0;
$m_udr = 0;

if ((isset($_GET['sh_razdel'])) and ($_GET['sh_razdel']<0) and ($_GET['sh_razdel']>4) )
{
	$_GET['sh_razdel']=4;
}


if (isset($_GET['invload'])) die();

//��������� ��� �����
///////////////////////////
//http://capitalcity.oldbk.com/main.php?setch=1&got=1&room8=%C2%EE%E9%F2%E8

if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {
	$miniBB_gzipper_encoding = 'x-gzip';
}
if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
	$miniBB_gzipper_encoding = 'gzip';
}
if (isset($miniBB_gzipper_encoding)) {
	ob_start();    }
function percent($a, $b) {
	$c = $b/$a*100;
	return $c;
}
//////////////////////////////
session_start();
$errkom='';


if (!($_SESSION['uid'] >0))
{
	header("Location: index.php");
	die;
}
include "connect.php";
include "functions.php";
include "map_config.php";

use components\models\OAuthUser;
use \PragmaRX\Google2FA\Google2FA;

function count_complects($type)
{
global $user;
$typestrt=" and type='{$type}'  ";

	if ($type==1)
		{
		$typestrt=" and type<=1  ";
		}
		
$q=mysql_query("select count(*) as kol from oldbk.users_complect2 where owner='{$user['id']}' ".$typestrt);
if (mysql_num_rows($q)>0)
	{
	$get_count=mysql_fetch_array($q);
	return $get_count['kol'];	
	}
return false;
}

function can_goto_room_in_club($ro)
{
	global $_SESSION,$user;

	$way_array=array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,36,43,44,54,55,56,57,20);

	if (in_array($user['room'],$way_array))
	{
		if ($ro==76)
		{
				if (true)
				{
				err("<B>������� �������!</B>");
				}
				else
				if ($user['level']<7)
				{
				err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");
				}
				elseif ($user['zayavka']>0)
				{
				err("<B>�� �� ������ ������� � ��� �������. �� � ������...</B>");
				}
				else
				//������� � �������� ��� ���� �������
				if ($user['battle'] == 0 && $user['hidden'] == 0 && $user['in_tower'] == 0) 
				{
					$eff = mysql_num_rows(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND (`type` >=11 AND `type` <= 14);"));
					if ($eff == 0) 
					{
				  		mysql_query("DELETE FROM users_bonus where owner='{$user['id']}'  ; "); // ������� ������
				  		$user = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '{$user['id']}' LIMIT 1;")); // ������������
					
						$sk_row=" `sila`='{$user[sila]}',`lovk`='{$user[lovk]}',`inta`='{$user[inta]}',`vinos`='{$user[vinos]}',`intel`='{$user[intel]}',
						`mudra`='{$user[mudra]}',`duh`='{$user[duh]}',`bojes`='{$user[bojes]}',`noj`='{$user[noj]}',`mec`='{$user[mec]}',`topor`='{$user[topor]}',`dubina`='{$user[dubina]}',
						`maxhp`='{$user[maxhp]}',`hp`='{$user[hp]}',`maxmana`='{$user[maxmana]}',`mana`='{$user[mana]}',`sergi`='{$user[sergi]}',`kulon`='{$user[kulon]}',`perchi`='{$user[perchi]}',
						`weap`='{$user[weap]}',`bron`='{$user[bron]}',`r1`='{$user[r1]}',`r2`='{$user[r2]}',`r3`='{$user[r3]}',`runa1`='{$user[runa1]}',`runa2`='{$user[runa2]}',`runa3`='{$user[runa3]}',`helm`='{$user[helm]}',`shit`='{$user[shit]}',`boots`='{$user[boots]}',
						`stats`='{$user[stats]}',`master`='{$user[master]}',`nakidka`='{$user[nakidka]}',`rubashka`='{$user[rubashka]}',`mfire`='{$user[mfire]}',`mwater`='{$user[mwater]}',`mair`='{$user[mair]}',`mearth`='{$user[mearth]}',
						`mlight`='{$user[mlight]}',`mgray`='{$user[mgray]}',`mdark`='{$user[mdark]}', `bpbonushp`='{$user[bpbonushp]}' , `uclass`='{$user['uclass']}' ";
			
						$asql="INSERT INTO oldbk.`class_profile` SET `owner`='{$user[id]}',`prof`=0, ".$sk_row." ON DUPLICATE KEY UPDATE  ".$sk_row;
						mysql_query($asql);
			
					 	mysql_query("update oldbk.inventory set dressed=0 where id IN (".GetDressedItems($user,DRESSED_ITEMS).")");
			
						// ������� �� ������
							 if ($user['level'] == 7) {
							$arr['stats'] = 64;
							$arr['vinos'] = 10;
							$arr['master'] = 8;
							} elseif ($user['level'] == 8) {
							$arr['stats'] = 78;
							$arr['vinos'] = 11;
							$arr['master'] = 9;
							} elseif ($user['level'] == 9) {
							$arr['stats'] = 94;
							$arr['vinos'] = 13;
							$arr['master'] = 10;
							} elseif ($user['level'] == 10) {
							$arr['stats'] = 112;
							$arr['vinos'] = 16;
							$arr['master'] = 11;
							} elseif ($user['level'] == 11) {
							$arr['stats'] = 164;
							$arr['vinos'] = 19;
							$arr['master'] = 12;
							} elseif ($user['level'] == 12) {
							$arr['stats'] = 192;
							$arr['vinos'] = 23;
							$arr['master'] = 14;
							} elseif ($user['level'] == 13) {
							$arr['stats'] = 226;
							$arr['vinos'] = 28;
							$arr['master'] = 16;
							} elseif ($user['level'] >= 14) {
							$arr['stats'] = 263;
							$arr['vinos'] = 40;
							$arr['master'] = 17;
							}
			
			                        $arr['hp']=$arr['vinos']*6;
			
			
						mysql_query("UPDATE `users` SET
							`users`.`sila`=3,`users`.`lovk`=3,`users`.`inta`=3,`users`.`vinos`='{$arr[vinos]}',`users`.`intel`=0,`users`.`mudra`=0,
							`users`.`duh`=0,`users`.`bojes`=0,`users`.`noj`=0,`users`.`mec`=0,`users`.`topor`=0,`users`.`dubina`=0,
							`users`.`maxhp`='{$arr[hp]}',`users`.`hp`='{$arr[hp]}',`users`.`maxmana`=0,`users`.`mana`=0,`users`.`sergi`=0,`users`.`kulon`=0,
							`users`.`perchi`=0,`users`.`weap`=0,`users`.`bron`=0,`users`.`r1`=0,`users`.`r2`=0,`users`.`r3`=0,`users`.`helm`=0,`users`.`runa1`=0,`users`.`runa2`=0,`users`.`runa3`=0,
							`users`.`shit`=0,`users`.`boots`=0,`users`.`stats`='{$arr[stats]}',`users`.`master`='{$arr[master]}',`users`.`nakidka`=0,`users`.`rubashka`=0,`users`.`mfire`=0,
							`users`.`mwater`=0,`users`.`mair`=0,`users`.`mearth`=0,`users`.`mlight`=0,`users`.`mgray`=0,`users`.`mdark`=0,`users`.`bpbonushp`=0,
							`users`.`room` = '76' WHERE `users`.`id`  = '{$user[id]}'
						");
						header("Location: class_armory.php"); die(); 
					}
					else
					{
					err("<B>�������������� ���� �� �������...</B>");
					}
		
				}
		
		}
		else
		{
				mysql_query("UPDATE `users` SET `users`.`room` = '{$ro}' WHERE  `users`.`id` = '{$_SESSION['uid']}' and battle=0 ;");
				if (mysql_affected_rows()>0)
				{
					move_to_trup($ro);
				}
		}
	}
	else
	{
		err("<B>�������� ������� ������ � ����������� �������</B>");
	}
}


function render_sost_row($ro1,$ro2,$ro3)
{
	return '
								 <tr class="separate">
								                <td class="row-left">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-center">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-right">
								                    <div class="separate"></div>
								                </td>
								            </tr>
							<tr class="element">
							                <td class="row-left">
							                    '.$ro1.'
							                </td>
							                <td class="row-center">
							                '.$ro2.'
							                </td>
						                	<td class="row-right">
						                	 '.$ro3.'
							                </td>
							            </tr>';

}

if(!isset($user) || $user === false) {
	header("Location: index.php");
	die;
}
if ($user['in_tower'] == 4) { header('Location: jail.php'); die(); }

if (isset($_GET['invload3']) && $user['battle'] == 0 && $user['battle_fin'] == 0 && isset($_GET['InvCurPos'],$_GET['screenres'])) {

	$_GET['InvCurPos'] = intval($_GET['InvCurPos']);
	$_GET['screenres'] = intval($_GET['screenres']);
	if ($_GET['screenres'] > 0 && $_GET['InvCurPos'] >= 0) {
		switch($_SESSION['razdel']) {

			case 4:
				$sub = isset($_SESSION['invsub4']) ? $_SESSION['invsub4'] : 0;
				$giftfilter = "";
				switch($sub) {
					case 0:
						$giftfilter = ' and otdel = 72 ';
						break;
					case 1:
						$giftfilter = ' and otdel != 72 ';
						break;
					case 2:
						$giftfilter = ' and present = "" ';
						break;
				}


				$sql = "SELECT * FROM oldbk.`inventory` WHERE `owner` = '".$user['id']."' and type = 200 AND id NOT IN (".GetDressedItems($user).") AND `setsale` = 0 AND bs_owner = ".$user['in_tower']." ".$giftfilter." ORDER by `update` DESC LIMIT ".$_GET['InvCurPos'].",".$_GET['screenres'];
				$q = mysql_query($sql);
				while($row = mysql_fetch_assoc($q)) {
					showitem2($row);
				}
				break;
			case 6:
				$sub = isset($_SESSION['invsub6']) ? $_SESSION['invsub6'] : -1;
				switch($sub) {
					case 0:
						$where = "AND ((`prototype` > 3000 and `prototype` < 3030) or (`prototype` > 103000 and `prototype` < 103030) or otdel = 62)";
						break;
					default:
						$where = "AND prototype NOT IN (1011002,1011001,1010016) AND ( (`prototype` > 3003000 and `prototype` < 3003100) or (`prototype` > 3003200 and `prototype` < 3003400) or (prototype >= 1010000 and prototype <=1020000) or type=77 or (prototype >= 15551 and prototype <= 15568) )";
						

						//�������
						if  ($_GET['InvCurPos'] == 0)
						{						
							if (($user['znak']>0) and time()<mktime(23,59,59,6,30,2017) )
								{
								$row['img']='item2016_signhero.gif';
								$row['name']='���� �����';						
								$row['cost']=0;							
								$row['duration']=0;													
								$row['massa']=0;																			
								$row['maxdur']=1;
								$row['dategoden']=mktime(23,59,59,6,30,2017);							
								$row['goden']=round(($row['dategoden']-time())/60/60/24); if ($row['goden']<1) {$row['goden']=1;}
								$row['letter']='���� ������ ������������ ��������� �����, ������� ���������� ����� � ������.';
								showitem2($row,$user['znak']);
								}
						}
	
						break;
				}
				
					$sql = "SELECT *, count(*) as `itemscount` FROM (SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM oldbk.`inventory` WHERE `owner` = '".$_SESSION['uid']."' ".$where." AND id NOT IN (".GetDressedItems($user).") AND `setsale` = 0 AND bs_owner = ".$user['in_tower']." ORDER by `dategoden2` ASC,`update` DESC) as `inv` GROUP BY `prototype` ORDER BY `update` DESC LIMIT ".$_GET['InvCurPos'].",".$_GET['screenres'];
					$q = mysql_query($sql);
						while($row = mysql_fetch_assoc($q)) 
						{
						showitem2($row,$row['itemscount']);
						}
					
				break;


		}
	}
	die();
}

if (isset($_GET['invload2']) && $user['battle'] == 0 && $user['battle_fin'] == 0 && isset($_GET['prototype'],$_GET['id'],$_GET['otdel'])) {
	load_hidden_items();
}


if (isset($_GET['savescrolls'])) {
	$set_scrolls = unserialize($user['gruppovuha']);
	if (isset($set_scrolls[10]) && $set_scrolls[10] > 0) {
		$set_scrolls[10] = 0;
	} else {
		$set_scrolls[10] = 1;
	}

	$set_scrolls = serialize($set_scrolls);
	mysql_query("UPDATE `users` SET `gruppovuha` = '".mysql_real_escape_string($set_scrolls)."' WHERE `id` = '{$user['id']}' LIMIT 1;");

	$q = mysql_query('SELECT * FROM users_complect_scrolls WHERE owner = '.$user['id']);
	if (!mysql_num_rows($q)) {
		$mlist = [];
		for ($i = 1; $i < 21; $i++) {
			if ($user['m'.$i] > 0) $mlist['m'.$i] = $user['m'.$i];
		}

		$addsql = "";
		if (count($mlist)) {
			$q = mysql_query('SELECT * FROM inventory WHERE id IN ('.implode(",",$mlist).')');
			if (mysql_num_rows($q) > 0) {
				while($i = mysql_fetch_assoc($q)) {
					reset($mlist);
					while(list($ka,$va) = each($mlist)) {
						if ($va == $i['id']) {
							$addsql .= $ka.' = "'.$i['id'].'|'.$i['prototype'].'",';
						}
					}
				}
			} 
		}


		mysql_query('INSERT INTO users_complect_scrolls SET '.$addsql.' owner = '.$user['id']);		
	}

	die();
}


/*
if ($user['palcom'] != "�������� ���" && $user['level'] < 4 && CITY_ID == 0 && $user['battle'] == 0 && $user['zayavka'] == 0 && $user['in_tower'] == 0 && $user['lab'] == 0 && $user['klan']!='radminion' ) {
	$user['room'] = 26;
	$_POST['target'] = "avalon";
	$ABIL = 1;
	require_once('./magic/city_teleport.php');
	die();
}
*/

if ($user['align'] == 4) {
	//unset($_GET['dress']);  //  http://tickets.oldbk.com/issue/oldbk-1277
	unset($_GET['destruct']);
	unset($_GET['complect']);
	//unset($_GET['use']); http://tickets.oldbk.com/issue/oldbk-1453
}

if($_SESSION['vk'] && $user['level']>2 && !$_SESSION['vk_agree'])
{
	$sql = 'SELECT * FROM oldbk.beginers_quests_step WHERE owner='.$user['id'].' AND quest_id=7;';

	$data = mysql_query($sql);
	if(mysql_num_rows($data)>0)
	{
		while($row=mysql_fetch_array($data))
		{
			if($row['status']==1)
			{
				?><script>alert('�� ����������� �������� ��������, ������� �� ��������� ��������� ����������� ���� � �� ��������� ����� ���. ����������. \n\r �������� ������������ ����� ������� ��� ����� � ���� �� ������ oldbk.com, ��� ��������� ��� ������ ����������� � ����������� ������������ ��� ����������� ���� � ������������.')</script>

				<?
				$_SESSION['vk_agree']=1;
			}
		}
	}

}
if(!$_SESSION['beginer_quest']['none'])
{
	$last_q=check_last_quest(4);
	if($last_q)
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
		quest_check_type_4($last_q);
	}

	$last_q=check_last_quest(7);
	if($last_q && ($_POST['email'] || $_POST['sex'] || $_POST[psw2] || $_POST['psw']))
	{
		//echo 'qweqweq';
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
		quest_check_type_7($last_q,$_POST);
	}

	$last_q=check_last_quest(2);
	if($last_q)
	{
		quest_check_type_2($last_q);
	}

	$last_q=check_last_quest(5);
	if($last_q)
	{
		quest_check_type_5($last_q);
	}

}




if (($user['battle'] != 0) OR ($user['battle_fin'] != 0)) { header('location: fbattle.php'); die(); }

//������ ��������� ��������� ���� ��� ��������� � ��������� ����
if ( (isset($_GET['edit'])) AND ($user['room']>=197) AND ($user['room']<=199))
{
	unset($_GET['edit']);
}

if(($user['klan'] == 'radminion' || $user['klan'] == 'Adminion' || $user['id'] == 1326 || $user['id'] == 188) )
{
	echo "{$user['klan']} information: ".exec('hostname')." - ";
	echo "<font style='font-size:9px'>".exec('uptime')."</font>";
	echo " GZip_info:<!- GZipper_Stats ->  <br>";
}


//������ ��������� ��������� ���� ��� ��������� � ������� ���������
if (   ( (isset($_GET['edit'])) AND ($user['room']>210) AND ($user['room']<=239))
		OR ( (isset($_GET['edit'])) AND ($user['room']>270) AND ($user['room']<299)) || ($user['room'] == 72001 && $user['in_tower'] > 0) )

{

/////////////////////////////////////////�������� ��������� ��� ������ �������
	?>
	<HTML><HEAD>
		<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/main.css">
        <link rel="stylesheet" href="/i/btn.css" type="text/css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<META Http-Equiv=Cache-Control Content=no-cache>
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
		<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
		<script type="text/javascript" src="/i/globaljs.js"></script>
		<SCRIPT LANGUAGE="JavaScript">

			function returned2(s){
				location.href='restal210.php?'+s+'tmp='+Math.random();
			}


		</SCRIPT>
		<script type="text/javascript" src="http://i.oldbk.com/i/showthing.js"></script>
	<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>)">
	<input type=hidden id=penemy value=0>
	<input type=hidden id=txtblockzone value=0>
	<div id=hint3 class=ahint style="z-index:500;"></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td valign=top>

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td valign=top align=left width=250><? showpersinv($user)?><center>



							</center>
							<BR>
						</td>

						<TD valign=top >
							<br/>
							����: <a href="http://oldbk.com/encicl/?/exp.html" target="_blank"><?=$user['exp']?></a> (<?=$user['nextup']?>)<BR>
							�������: <? if (($user['level']==13) and ($user['exp']>=8000000000) ) { echo "<font color=#F03C0E><b>{$user['level']}</b></font>"; } else { echo $user['level']; } ?><BR>
							�����: <?=$user['win']?><BR>
							���������: <?=$user['lose']?><BR>
							������: <b><?=$user['money']?></b> ��. <BR>
							������: <b><?=$user['gold']?></b> <img src="http://i.oldbk.com/i/icon/coin_icon.png" alt="������" title="������" style="margin-bottom: -2px;"> <BR>							
							<?php
							if($user['klan']) {
								$clan = mysql_query_cache('SELECT * FROM clans WHERE short = "'.$user['klan'].'"',false,60*60);
								$clan = $clan[0];

								echo "����: {$clan['name']}<BR>";
							}?>
							<HR>
							<!--���������-->
							<table border=0><tr><td>

										����: <?=$user['sila']?><BR>
										��������: <?=$user['lovk']?><BR>
										��������: <?=$user['inta']?><BR>
										������������: <?=$user['vinos']?><BR>
										<?echo($user['level']>3)?"���������: {$user['intel']}":""; echo ($user['stats'] && ($user['level']>3))?"":"";  if($user['level']>3) echo"<BR>"?>
										<?echo($user['level']>6)?"��������: {$user['mudra']}":""; echo ($user['stats'] && ($user['level']>6))?"":"";  if($user['level']>6) echo"<BR>"?>

										<!-- Added: 27.04.2010 Auth: Weathered -->
										<hr/>
										<?
										function get_wep_type($idwep)
										{
											if ($idwep == 0 || $idwep == null || $idwep == '') { return "kulak"; }
											$wep = mysql_fetch_array(mysql_query('SELECT `otdel`,`minu`,`prototype` FROM oldbk.`inventory` WHERE `id` = '.$idwep.' LIMIT 1;'));
											if($wep[0] == '1') { return "noj"; }
											elseif($wep[0] == '12') { return "dubina"; }
											elseif($wep[0] == '11') { return "topor"; }
											elseif($wep[0] == '13') {return "mech";	}
											elseif($wep['prototype'] == 501) { return "kostil1";}
											elseif($wep['prototype'] == 502) { return "kostil2";}
											elseif( ($wep[0] == '6') and  (($wep['prototype']>=55510301) and ($wep['prototype']<=55510401)))  {return "elka";	}
											elseif( ($wep[0] == '6') and  (($wep['prototype']>=410001) and ($wep['prototype']<=410030)))  {return "buket";	}
											elseif($wep[1] > 0) { return "buket"; } else { return "kulak"; }
										}


										$user_dressed = mysql_fetch_array(mysql_query('SELECT sum(minu),sum(maxu),sum(mfkrit),sum(mfakrit),sum(mfuvorot),sum(mfauvorot),sum(bron1),sum(bron2),sum(bron3),sum(bron4),sum(ab_mf), sum(ab_bron), sum(ab_uron), count(if(unik=1,1,null)) as unik , count(if(unik=2,1,null)) as supunik   FROM oldbk.`inventory` WHERE id in ('.GetDressedItems($user,DRESSED_ITEMS).')'));

										$user_level = $user['level'];

										$aeff = getalleff($user['id']);

										$master = 0;
										$wt=get_wep_type($user['weap']);

										if ($user['id']==14897)
										{
											echo "Echo !!!!!";
											echo $wt;
										}

										switch($wt)
										{
											case "noj": $master += $user['noj']; break;
											case "dubina": $master += $user['dubina']; break;
											case "topor": $master += $user['topor']; break;
											case "mech": $master += $user['mec']; break;
											case "elka":
											{
												$ma=$user['noj'];
												if ($ma<$user['topor']) { $ma=$user['topor'];}
												if ($ma<$user['dubina']) { $ma=$user['dubina'];}
												if ($ma<$user['mec']) { $ma=$user['mec'];}
												$master +=$ma;
												break;
											}
											case "buket":
											{
												$ma=$user['noj'];
												if ($ma<$user['topor']) { $ma=$user['topor'];}
												if ($ma<$user['dubina']) { $ma=$user['dubina'];}
												if ($ma<$user['mec']) { $ma=$user['mec'];}
												$master +=$ma;
												break;
											}
											case "kostil1":
											{
												$user_dressed[6]-=6;
												$user_dressed[7]-=6;
												$user_dressed[8]-=6;
												$user_dressed[9]-=6;
												break;
											}
											case "kostil2":
											{
												$user_dressed[6]-=10;
												$user_dressed[7]-=10;
												$user_dressed[8]-=10;
												$user_dressed[9]-=10;
												break;
											}
										}

										$min_damage = round((floor($user['sila']/3) + 1) + $user_level + $user_dressed[0] * (1 + 0.07 * $master));
										$max_damage =  round((floor($user['sila']/3) + 4) + $user_level + $user_dressed[1] * (1 + 0.07 * $master));

										if($weapon_type == 'kulak' && $user['align'] == '2')
										{
											$min_damage += $user_level;
											$max_damage += $user_level;
										};

										$arrmf['uvorota']=0;
										$arrmf['auvorota']=0;
										$arrmf['krita']=0;
										$arrmf['akrita']=0;


										//���������� ������ ��
										if (isset($aeff[900]))
										{
											$arrmf['uvorota']+=(int)($aeff[900]['add_info']);
										}
										if (isset($aeff[901]))
										{
											$arrmf['auvorota']+=(int)($aeff[901]['add_info']);
										}
										if (isset($aeff[902]))
										{
											$arrmf['krita']+=(int)($aeff[902]['add_info']);
										}
										if (isset($aeff[903]))
										{
											$arrmf['akrita']+=(int)($aeff[903]['add_info']);
										}

										if (isset($aeff[904]))
										{
											//���� ��
											$user_dressed[10]+=(int)($aeff[904]['add_info']);
										}
										if (isset($aeff[905]))
										{
											//�����
											$user_dressed[11]+=(int)($aeff[905]['add_info']);
										}
										if (isset($aeff[906]))
										{
											//����
											$user_dressed[12]+=(int)($aeff[906]['add_info']);
										}
										/////////////////////////


										$arrmf['uvorota']+=$user_dressed[4] + $user['lovk'] * 5;
										$arrmf['auvorota']+=$user_dressed[5] + $user['lovk'] * 5 + $user['inta'] * 2;
										$arrmf['krita']+=$user_dressed[2] + $user['inta'] * 5;
										$arrmf['akrita']+=$user_dressed[3] + $user['inta'] * 5 + $user['lovk'] * 2;

										//���������� 100-� ��������
										$arrmf_uvorota=$arrmf['uvorota'];
										$arrmf_auvorota=$arrmf['auvorota'];
										$arrmf_krita=$arrmf['krita'];
										$arrmf_akrita=$arrmf['akrita'];


										if ($user_dressed[10]>0)
										{
											//���� ���� ������ �� �� ��
											//���� ����� �� �� - �� ����������� � ������������ ���������� �������� ������.
											$add_to_mf=getmaxmf($arrmf);
											$arrmf[$add_to_mf]+=(int)($arrmf[$add_to_mf]*($user_dressed[10]/100));
											$green_out[$add_to_mf]=$user_dressed[10];
										}


										if ($user_dressed[11]>0 || isset($aeff[791])) {
											$plusbron = 0;

											if ($user_dressed[11] > 0) {
												$user_dressed[6]+=(int)($user_dressed[6]*($user_dressed[11]/100));
												$user_dressed[7]+=(int)($user_dressed[7]*($user_dressed[11]/100));
												$user_dressed[8]+=(int)($user_dressed[8]*($user_dressed[11]/100));
												$user_dressed[9]+=(int)($user_dressed[9]*($user_dressed[11]/100));
												$plusbron += $user_dressed[11];
											}

											if (isset($aeff[791])) {
												$user_dressed[6]+=(int)($user_dressed[6]*(15/100));
												$user_dressed[7]+=(int)($user_dressed[7]*(15/100));
												$user_dressed[8]+=(int)($user_dressed[8]*(15/100));
												$user_dressed[9]+=(int)($user_dressed[9]*(15/100));
												$plusbron += 15;
											}

											$gree_out_bron=" <font color=green>(+".$plusbron."%)</font>";
										}
										if ($user_dressed[12]>0 || isset($aeff[792])) {

											$plusuron = 0;
											if($user_dressed[12]>0) {
												$min_damage+=(int)($min_damage*($user_dressed[12]/100));
												$max_damage+=(int)($max_damage*($user_dressed[12]/100));
												$plusuron += $user_dressed[12];
											}

											if (isset($aeff[792])) {
												$min_damage+=(int)($min_damage*(5/100));
												$max_damage+=(int)($max_damage*(5/100));
												$plusuron += 5;
											}

											$gree_out_uron=" <font color=green>(+".$plusuron."%)</font>";
										}

										//����-���
										if (strpos($user['medals'], 'k202;') !== false)
										{
											$user_dressed[13]+=1; // �����
										}
										//�����-����-���
										if (strpos($user['medals'], 'k203;') !== false)
										{
											$user_dressed[14]+=1; //������
										}
										//////���������� ����� �����
										$unik_bonus_data=get_unik_bonus_data($user_dressed[13],$user_dressed[14]);										
										if (($unik_bonus_data) and ($unik_bonus_data[0]>0) )
										{
										//��������� �����
											$arrmf['uvorota']+=round($arrmf_uvorota*(0.01*$unik_bonus_data[0]));
											$arrmf['auvorota']+=round($arrmf_auvorota*(0.01*$unik_bonus_data[0]));
											$arrmf['krita']+=round($arrmf_krita*(0.01*$unik_bonus_data[0]));
											$arrmf['akrita']+=round($arrmf_akrita*(0.01*$unik_bonus_data[0]));
											$green_out['uvorota']+=$unik_bonus_data[0];
											$green_out['auvorota']+=$unik_bonus_data[0];
											$green_out['krita']+=$unik_bonus_data[0];
											$green_out['akrita']+=$unik_bonus_data[0];
										}
										/////////////////////////

										// ��+1% �� ����
										if (isset($aeff[793])) {
											$arrmf['uvorota']+=round($arrmf['uvorota']*0.01);
											$arrmf['auvorota']+=round($arrmf['auvorota']*0.01);
											$arrmf['krita']+=round($arrmf['krita']*0.01);
											$arrmf['akrita']+=round($arrmf['akrita']*0.01);

											$green_out['uvorota']+=1;
											$green_out['auvorota']+=1;
											$green_out['krita']+=1;
											$green_out['akrita']+=1;
										}
										?>
										����: <? echo $min_damage; ?> - <? echo $max_damage.$gree_out_uron; ?> <br/>
										������������<br/>
										&nbsp; ������: &nbsp;<? echo $arrmf['uvorota']."% ".(($green_out['uvorota']>0)?"<font color=green>(+".$green_out['uvorota']."%)</font>":"");?><br/>
										&nbsp; ����������: &nbsp;<? echo $arrmf['auvorota']."% ".(($green_out['auvorota']>0)?"<font color=green>(+".$green_out['auvorota']."%)</font>":"");?><br/>
										&nbsp; ����: &nbsp;<? echo $arrmf['krita']."% ".(($green_out['krita']>0)?"<font color=green>(+".$green_out['krita']."%)</font>":"");?><br/>
										&nbsp; ��������: &nbsp;<? echo $arrmf['akrita']."% ".(($green_out['akrita']>0)?"<font color=green>(+".$green_out['akrita']."%)</font>":"");?><br/>
										�����<br/>
										&nbsp; ������: &nbsp;<? echo $user_dressed[6].$gree_out_bron; ?><br/>
										&nbsp; �������: &nbsp;<? echo $user_dressed[7].$gree_out_bron; ?><br/>
										&nbsp; �����: &nbsp;<? echo $user_dressed[8].$gree_out_bron; ?><br/>
										&nbsp; ���: &nbsp;<? echo $user_dressed[9].$gree_out_bron; ?><br/>

										<!-- </> -->
										<HR>
										���������� ��������:<BR>
										&nbsp; ������ � ���������: <?=$user['noj']?><BR>
										&nbsp; ������: <?=$user['mec']?><BR>
										&nbsp; ��������, ��������: <?=$user['dubina']?><BR>
										&nbsp; �������� � ��������: <?=$user['topor']?><BR>
										<?if ($user['level'] > 3) {?>
											���������� ����������:<BR>
											&nbsp; ������ ����: <?=$user['mfire']?><BR>
											&nbsp; ������ ����: <?=$user['mwater']?><BR>
											&nbsp; ������ �������: <?=$user['mair']?><BR>
											&nbsp; ������ �����: <?=$user['mearth']?><BR>
											&nbsp; ����� �����: <?=$user['mlight']?><BR>
											&nbsp; ����� �����: <?=$user['mgray']?><BR>
											&nbsp; ����� ����: <?=$user['mdark']?><BR> <?
										}?>

									</td></tr></table>

						</TD>


					</tr>
				</table>

			</td>
			<td valign=top align=right>
				<h3><?=$rooms[$user['room']]?></h3>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align=left><font color=red><b>��������!</b> ��������� ������� �������� �� ������ � ��������� �������!<br>
								<?
								if ($user['in_tower'] == 10)  {
									echo "</td><td align=right>";
									echo "<form method=GET action='castles_tur.php'>
		<INPUT TYPE=button OnClick=\"location.href='castles_tur.php';\" value=\"���������\"><br>
		</form>
		</td></tr></table>";
								} else {
									echo "</td><td align=right>";
									echo "<form method=GET action='restal210.php'>
		<INPUT TYPE=button value=\"���������\" onClick=\"returned2('ref=3.14');\"><br>
		</form>
		</td></tr></table>";
								}
								?>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td valign=top>

										</td>
										<td valign=top>
											<div style="MARGIN-LEFT:15px; MARGIN-TOP: 10px;">
											</div>
										</td>
									</tr>
								</table>


						</td>
					</tr>
				</table>


	</body>
	</html>

	<?
/////////////////////////////////////////////////////////////////////////////////////
	unset($_GET['edit']);
	die();
}



#if ($user['in_tower'] == 1) { header('Location: towerin.php'); die(); }
//echo 'HERE '.$hollyday;

function check_razdel($rzd,$user,$klan=0,$show=0)
{
	global $user_real_sex;
	$sql='';
	$sx=0;
	$chrzd['sql']='';
	$chrzd=array();
	
	$old_nom=str_replace('.gif', '', $user['shadow']);
	$old_nom=(int)($old_nom[1].$old_nom[2].$old_nom[3].$old_nom[4]);
	
	if($rzd==4 && ($user['shadow']=='0.gif' OR $user['shadow']=='m0.gif'  OR ( ($user['shadow'][0]=='m' || $user['shadow'][0]=='g')  and $old_nom<20 and $old_nom>0)  )) //������� ������  ���� ������ ��� ��� �� ������
	{
		$chrzd['sql']=" type=4 AND sex='".(int)($user_real_sex)."' ";
		$chrzd[1]=1;
		$chrzd['txt']='';
		$chrzd['txt1']='<font color=red>��������! ����� ��������� ���������� ������ ���� ���. ����� �� ��� ������� �� �������.</font>';
	}
	elseif($rzd==1 && $klan['id']>0)       //��������
	{
		$chrzd['sql']=' type=1 AND klan='.$klan['id'];
		$chrzd[1]=1;
		$chrzd['txt']='';
	}
	elseif(($rzd==2) and ($user['id']>0))   //������������
	{
		$chrzd['sql']=' type=2 AND owner='.$user['id'];
		$chrzd[1]=0;
		$chrzd['txt']='� ��� ��� ������������� ������';
	}
	elseif(($rzd==3 && $show==1) || ($rzd==3 && $user['prem']>0))    //�������� ������
	{
		$chrzd['sql']=" type=3 AND sex='".(int)($user_real_sex)."' ";
		$chrzd[1]=1;
		$chrzd['txt']='';
	}

	if($rzd==3 && $user['prem']==0)
	{
		$chrzd['txt']='�� �� ������ ����� ���� ����� �� ����...';
	}
	elseif($rzd==4 && $user['shadow']!='0.gif')
	{
		$chrzd['txt']='� ��� ��� ���� �����';
	}
	elseif($rzd==1 && !$klan['id'])
	{
		$chrzd['txt']='� ������ ����� ��� ������';
	}
	return $chrzd;
}


$mess='';
if ($user['klan'])
{
	$klan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
	$data=mysql_query('select * from oldbk.users_shadows where type=1 AND klan='.$klan['id'].';');
	$g=0;
	while($row=mysql_fetch_assoc($data))
	{
		$klan_sh[$g]=$row;
		$g++;
	}
	//$shadow = $klan;

	$sql =mysql_query("SELECT * FROM oldbk.`gellery` WHERE `owner` = ".$user['id'].";");
	$fg1=0;
	while($data=mysql_fetch_array($sql))
	{
		$my_klan_img[$fg1]=$data['img'];
		$fg1++;
	}

	/*
		       	if((int)$_POST['setshadowclan'] && strip_tags($_POST['img'])!='')
				{
					//�������� �������� �� ����� ����.
					//��������� � �� ����� �� �� ��� ���� ��� �����
					if(!in_array($_POST['img'],$my_klan_img))
					{
		                $sql ="SELECT * FROM oldbk.`gellery_prot` WHERE img='".$_POST['img']."' AND `klan_owner` = '".$klan['id']."' LIMIT 1;";
		        		$data=mysql_fetch_array(mysql_query($sql));
		          		if($data['id']>0)
		            	{
		                   	if(mysql_query('insert into oldbk.gellery set owner='.$user['id'].', img= "'.$data['img'].'", otdel='.$data['otdel'].', exp_date='.$data['exp_date'].';'))
		                   	{
		                   		echo '<font color=red><b>�������� ���������</b></font>';
		                 		$sql =mysql_query("SELECT * FROM oldbk.`gellery` WHERE `owner` = ".$user['id'].";");
							    $fg1=0;
							    while($data=mysql_fetch_array($sql))
							    {
							    	$my_klan_img[$fg1]=$data['img'];
									$fg1++;
							    }
		                   	}
		                }
		            }
				}  // �������� �� ��� ��� � ��� ����
				*/

	$sql=mysql_query("SELECT * FROM oldbk.`gellery_prot` WHERE `klan_owner` = '".$klan['id']."';");
	$fg=0;
	while($data=mysql_fetch_array($sql))
	{
		if(!in_array($data['img'],$my_klan_img))
		{
			$klan_img[$fg]=$data;
			$fg++;
		}
	}

	$shadow_sql='klan='.$klan['id'].' or';
}
$shadow=array();
if ($user['id']>0)
{
	$sql='select * from users_shadows where ('.$shadow_sql.' owner='.$user['id'].') and sex='.(int)($user_real_sex).' ;';

	$data=mysql_query($sql);
	while($row=mysql_fetch_array($data))
	{
		if($row['type']==1 && $row['sex']==0)
		{
			$shadow['klg']=1;
		}
		if($row['type']==1 && $row['sex']==1)
		{
			$shadow['klm']=1;
		}
		if($row['type']==2 && $row['owner']==$user['id'])
		{
			$shadow['my']=1;
		}
	}
}
if ((int)$_GET['obraz'] && $_GET['sh_razdel'] && ($user['shadow'] == '0.gif' || count($klan_sh)>0 || $user['prem']>0 || $shadow['klg']==1 || $shadow['klm']==1 || $shadow['my']==1))
{

	$chrzd=check_razdel($_GET['sh_razdel'],$user,$klan);
	$data=mysql_fetch_assoc(mysql_query('select * from oldbk.users_shadows where '.$chrzd['sql'].' '.($chrzd[1]==1?'AND sex="'.(int)($user_real_sex).'"':'').' and id='.(int)($_GET['obraz']).' LIMIT 1;'));
	if($data)
	{
		//print_r($data);
		//  echo '<br>';
		//([id] => 51 [owner] => 28453 [klan] => [name] => umklajdet [sex] => 1 [type] => 2 )
		mysql_query("UPDATE `users` SET `shadow` = '".($chrzd[1]==1?($data['sex']==1?'m':'g'):'').$data['name'].".gif' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
		$user['shadow'] = ($chrzd[1]==1?($data['sex']==1?'m':'g'):'').$data['name'].'.gif';
	}
	else
	{
		echo $chrzd['txt'];
	}

}




if($_POST['ssave']==1)
{
	save_gruppovuha();
}

if ($user['hp'] > $user['maxhp'])
{
	mysql_query("UPDATE `users` SET `hp`=`maxhp` where id='".$user['id']."' LIMIT 1;   ");
}
$can_move=true;
$eff_data=mysql_query("select * from effects where owner='".$user['id']."' AND type= 10 LIMIT 1");
if(mysql_num_rows($eff_data)>0)
{
	$effects=mysql_fetch_assoc($eff_data);
	$st=$effects['time']-time();
	$txt='������.';
	if($st<0)
	{
		$st=0;
	}
	else
		if($st>60)
		{
			$st=round($st/60,2);
			$txt='�����.';
		}
	$can_move=false;
	err("<B>�� �� ������ ������������� ��� ".$st." ".$txt.".</B>");

	if ((isset($_GET['edit'])) AND ($user['in_tower']==0))
	{
		$die_invent=true;
		unset($_GET['dress']);
		unset($_GET['drop']);
		unset($_GET['undress']);
		unset($_GET['complect']);
		unset($_GET['use']);
	}

}


if($_GET['got'])
{
	if ($user['lab'] == 1) { header('Location: lab.php'); die(); }
	if ($user['lab'] == 2) { header('Location: lab2.php'); die(); }
	if ($user['lab'] == 3) { header('Location: lab3.php'); die(); }
	if ($user['lab'] == 4) { header('Location: lab4.php'); die(); }
	if ($user['room'] == 43) { header('Location: znahar.php'); die(); }
	if ($user['room'] == 44) { header('Location: roomtest.php'); die(); }
	if ($user['room'] == 45) { header('Location: startlab.php'); die(); }
	if ($user['room'] == 46) { header('Location: prokat.php'); die(); }
	if ($user['room'] == 47)  { header('Location: rentalshop.php'); die(); }
	if ($user['room'] == 70)  { header('Location: pawnbroker.php'); die(); }
	if ($user['room'] == 71)  { header('Location: auction.php'); die(); }
	if ($user['room'] == 72)  { header('Location: fair.php'); die(); }
	if ($user['room'] == 76)  { header('Location: class_armory.php'); die(); }	
	if ($user['room'] >= 91 && $user['room'] <= 97)  { header('Location: craft.php'); die(); }
	if ($user['room'] == 60) { header('Location: bplace.php'); die(); }

	if ($user['room'] == 999) { header('Location: ruines_start.php'); die(); }
	if ($user['room'] == 90) { header('Location: lord.php'); die(); }
	if ($user['room'] == 10000) { header('Location: dt_start.php'); die(); }
	if (($user['room'] > 10000) and ($user['room'] < 11000))  { header('Location: dt.php'); die(); }

	if ($user['room'] == 61000) { header('Location: station.php'); die(); }
	if (($user['room'] > 61000) and ($user['room'] < 62000))  { header('Location: station_go.php'); die(); }
	if (($user['room'] >=1000) and ($user['room'] <=10000))  { header('Location: ruines.php'); die(); }
	if (($user['room'] >500) and ($user['room'] <=560))  { header('Location: towerin.php'); die(); }

	if ($user['room'] >= 50000 && $user['room'] <= 53600) { header('Location: map.php'); die(); }
	if ($user['room'] == 70000) { header('Location: castles.php'); die(); }
	if ($user['room'] > 70000 && $user['room'] < 71000) { header('Location: castles_pre.php'); die(); }
	if ($user['room'] > 71000 && $user['room'] < 72000) { header('Location: castles_inside.php'); die(); }
	if ($user['room'] == 72001) { header('Location: castles_tur.php'); die(); }

	reset($map_locations);

	while(list($k,$v) = each($map_locations))
	{
		if ($v['room'] == $user['room']) { header('Location: '.$v['redirect']); die(); }
	}

	if ($user['room'] == 197 || $user['room'] == 199)  { header('Location: armory.php'); die(); }
	if ($user['room'] == 198)  { header('Location: castles_armory.php'); die(); }

	if (($user['in_tower'] ==3) and ($user['room']<90000))   { header('Location: restal210.php'); die(); } // ���� �������
	if ($user['in_tower'] ==3)   { header('Location: restal270.php'); die(); }
	if (($user['room'] >= 200)AND($user['room'] <= 300))  { header('Location: restal.php'); die(); }

	if ($user['room'] == 80)  { header('Location: garb.php'); die(); }

	$eff_data=mysql_query("select * from effects where owner='".$user['id']."' AND type= 830 LIMIT 1");
	if(mysql_num_rows($eff_data)>0)
	{
		$can_move=false;
		err("<B>�� ���������� ��� ���������� � �� ������ �������������</B>");
	}
}

if($user['room'] == 57 && !$_GET['setch'] && !$_GET['edit'] && !$_GET['goto'] && !isset($_POST['transreport']) && !isset($_POST['oldpass']))
{
	header('Location: war_list.php'); die();
}
elseif($user['room'] == 76 && !$_GET['setch'])
{
	header('Location: class_armory.php'); die();
}


if($_GET['got'] && $_GET['room1'] && $can_move) {  can_goto_room_in_club(1); }
elseif($_GET['got'] && $_GET['room2'] && $can_move) { can_goto_room_in_club(2); }
elseif($_GET['got'] && $_GET['room3'] && $can_move) { can_goto_room_in_club(3);}
elseif($_GET['got'] && $_GET['room4'] && $can_move) { can_goto_room_in_club(4);}
elseif($_GET['got'] && $_GET['room5'] && $can_move) { 	if($user['level'] > 0)  {  can_goto_room_in_club(5);}	else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");} 	}
elseif($_GET['got'] && $_GET['room6'] && $can_move) { 	if($user['level'] > 0)  { can_goto_room_in_club(6);}	else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room7'] && $can_move) { 	if($user['level'] > 0) 	{ can_goto_room_in_club(7);}	else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room8'] && $can_move) { 	if($user['level'] > 3) 	{ can_goto_room_in_club(8);}	else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room9'] && $can_move) { 	if ($user['level'] > 3) { can_goto_room_in_club(9);}	else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room10'] && $can_move) { if($user['level'] > 6) { can_goto_room_in_club(10);}   else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room11'] && $can_move) {	if($user['level'] > 9) { can_goto_room_in_club(11);}	else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room12'] && $can_move){	if($user['level'] > 12) {can_goto_room_in_club(12);}	else { err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room13'] && $can_move){ if($user['level'] > 15) {	can_goto_room_in_club(13);}	else	{ err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");} }
elseif($_GET['got'] && $_GET['room14'] && $can_move){ if($user['level'] > 18) { can_goto_room_in_club(14);} else { err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}}
elseif($_GET['got'] && $_GET['room19'] && $can_move) { if ($user['level'] > 0) { if(($user['sex'] == 0) or (($user['hidden']>0) and ($user['hiddenlog']==''))  ) { can_goto_room_in_club(19);	}else {	err("<B>�� �� ������ ������� � ��� �������. ��� �� ��������...</B>");}} else {	err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}	}
elseif($_GET['got'] && $_GET['room15'] && $can_move) { 	if ((($user['align'] > 1 && $user['align'] < 2 ) || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) {	can_goto_room_in_club(15);}else	{err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>");	}}
elseif($_GET['got'] && $_GET['room17'] && $can_move) { if ((($user['align'] == 3) || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) { can_goto_room_in_club(17);	}else {	err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>");	}}
elseif($_GET['got'] && $_GET['room18'] && $can_move) { 	if (((($user['align'] == 3) && ($klan['glava'] == $user['id'])) || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) {	can_goto_room_in_club(18);} else	{ err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>"); }}
elseif($_GET['got'] && $_GET['room16'] && $can_move) { if((($user['align'] > 1.8 && $user['align'] < 2) || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) { can_goto_room_in_club(16); }else { err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>"); }	}
elseif($_GET['got'] && $_GET['room36'] && $can_move) { 	if((($user['align'] == 2)  || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) { can_goto_room_in_club(36); }else { err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>");}}
elseif($_GET['got'] && $_GET['room54'] && $can_move) { if((($user['align'] == 6)  || ($user['align'] > 1 && $user['align'] < 2 ) || ($user['align']==1) || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) { can_goto_room_in_club(54);}else	{err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>");	}}
elseif($_GET['got'] && $_GET['room55'] && $can_move) { if(((($user['align'] == 1) && ($klan['glava'] == $user['id'])) ||(($user['align'] == 6) && ($klan['glava'] == $user['id'])) || ($user['align'] == 1.99) || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) {can_goto_room_in_club(55);}else	{ err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>");}}
elseif($_GET['got'] && $_GET['room56'] && $can_move) {	if(((($user['align'] == 2) && ($klan['glava'] == $user['id'])) || ($user['align'] > 2 && $user['align'] < 3 ))OR($user['align']==5)) {	can_goto_room_in_club(56);}else	{ err("<B>�� �� ������ ������� � ��� �������. ���������� �� ��...</B>");}}
elseif($_GET['got'] && $_GET['room57'] && $can_move) {  if($user['level'] >3) { can_goto_room_in_club(57);    }    else	   { err("<B>�� �� ������ ������� � ��� �������. ������� �������...</B>");}}
elseif($_GET['got'] && $_GET['room43'] && $can_move) {	if($user['level'] > 0) {	if((int)$user['zayavka'] > 0) {	err("<B>������ ������� � ��� ������� ����� ������ ������ �� ���.</B>");	} else	{can_goto_room_in_club(43);}	}else	{err("<B>�� �� ������ ������� � ��� �������. ������� �������..</B>");	}		}
elseif($_GET['path']=='1.100.1.50'  && $can_move )
{
	if ($user['lab'] == 1) { header('Location: lab.php'); die(); }
	if ($user['lab'] == 2) { header('Location: lab2.php'); die(); }
	if ($user['lab'] == 3) { header('Location: lab3.php'); die(); }
	if ($user['lab'] == 4) { header('Location: lab4.php'); die(); }
	if ($user['room'] == 43) { header('Location: znahar.php'); die(); }
	if ($user['room'] == 44) { header('Location: roomtest.php'); die(); }
	if ($user['room'] == 45) { header('Location: startlab.php'); die(); }
	if ($user['room'] == 46) { header('Location: prokat.php'); die(); }
	if ($user['room'] == 47)  { header('Location: rentalshop.php'); die(); }
	if ($user['room'] == 70)  { header('Location: pawnbroker.php'); die(); }
	if ($user['room'] == 71)  { header('Location: auction.php'); die(); }
	if ($user['room'] == 72)  { header('Location: fair.php'); die(); }
	if ($user['room'] >= 91 && $user['room'] <= 97)  { header('Location: craft.php'); die(); }
	if ($user['room'] == 999) { header('Location: ruines_start.php'); die(); }
	if ($user['room'] == 90) { header('Location: lord.php'); die(); }

	if ($user['room'] == 10000) { header('Location: dt_start.php'); die(); }
	if (($user['room'] > 10000) and ($user['room'] < 11000))  { header('Location: dt.php'); die(); }


	if ($user['room'] == 61000) { header('Location: station.php'); die(); }
	if (($user['room'] > 61000) and ($user['room'] < 62000))  { header('Location: station_go.php'); die(); }
	if (($user['room'] >=1000) and ($user['room'] <=10000))  { header('Location: ruines.php'); die(); }

	if ($user['room'] >= 50000 && $user['room'] <= 53600) { header('Location: map.php'); die(); }
	if ($user['room'] == 70000) { header('Location: castles.php'); die(); }
	if ($user['room'] > 70000 && $user['room'] < 71000) { header('Location: castles_pre.php'); die(); }
	if ($user['room'] > 71000 && $user['room'] < 72000) { header('Location: castles_inside.php'); die(); }
	if ($user['room'] == 72001) { header('Location: castles_tur.php'); die(); }

	reset($map_locations);
	while(list($k,$v) = each($map_locations)) {
		if ($v['room'] == $user['room']) { header('Location: '.$v['redirect']); die(); }
	}

	if ($user['room'] == 197 || $user['room'] == 199)  { header('Location: armory.php'); die(); }
	if ($user['room'] == 198)  { header('Location: castles_armory.php'); die(); }
	
	if (($user['in_tower'] ==3) and ($user['room']<90000))   { header('Location: restal210.php'); die(); } // ���� �������	
	if ($user['in_tower'] ==3)   { header('Location: restal270.php'); die(); }
	if (($user['room'] >= 200)AND($user['room'] <= 300))  { header('Location: restal.php'); die(); }
	if ($user['room'] == 80)  { header('Location: garb.php'); die(); }
	if ($user['in_tower'] == 1) { header('Location: towerin.php'); die(); }
	if ($user['in_tower'] == 15) { header('Location: dt.php'); die(); }
	if ($user['room'] == 60) { header('Location: bplace.php'); die(); }

	$goodrooms = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,36,54,55,56,57);

	//��������
	if (array_search($user['room'],$goodrooms) !== FALSE) {
		can_goto_room_in_club(0);
	}

}
elseif($_GET['got'] && $_GET['room200oldTur']  && $can_move) {
	if($user['level'] > 0) {
		can_goto_room_in_club(200);
	}
	else{
		err("<B>�� �� ������ ������� � ��� �������. ������� �������..</B>");
	}
}
elseif($_GET['got'] && $_GET['room201']  && $can_move) {
	if($user['level'] > 0) {
		can_goto_room_in_club(201);
	}
	else{
		err("<B>�� �� ������ ������� � ��� �������. ������� �������..</B>");
	}
}
elseif($_GET['got'] && $_GET['room44']  && $can_move)
{
	if (($user['klan']=='Adminion')OR($user['klan']=='radminion')OR($user['klan']=='testTest')OR($user['id']==188) or ($user['id']>370686 and $user['id']<370713 and $user['id']!=370711 and $user['id']!=370688 and $user['id']!=370708 and $user['id']!=370703 and $user['id']!=370692 and $user['id']!=370693 and $user['id']!=370694 and $user['id']!=370695))
	{
		can_goto_room_in_club(44);
	}
	else
	{
		err("<B>�� �� ������ ������� � ��� �������.</B>");
	}
}
elseif($_GET['got'] && $_GET['room75'])
{
	if ($user['id'] == 8540)
	{
		can_goto_room_in_club(75);
	}
	else
	{
		err("<B>�� �� ������ ������� � ��� �������.</B>");
	}
}
elseif($_GET['got'] && $_GET['room76'])
{
	//if (($user['klan'] == 'radminion') OR ($user['klan'] == 'testTest') )
	if ($user['level']>=8)
	{
		can_goto_room_in_club(76);
	}
	else
	{
		err("<B>�� �� ������ ������� � ��� �������.</B>");
	}
}


if ($_GET['flag']>0)
{
	$flagid=(int)($_GET['flag']);

	if ($flagid>0)
	{
		$test_flag=mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where id='{$flagid}' and owner='{$user['id']}' and setsale=0 and (prototype>=171171 and prototype<=171202);"));
		if ($test_flag['id']>0)
		{
			require_once("config_ko.php");
			$flag_png=$flag[$test_flag['prototype']]."_100x100.png";
			mysql_query("INSERT INTO `oldbk`.`users_flag` SET `owner`='{$user['id']}',`flag`='{$flag_png}',`flag_name`='{$test_flag['name']}'  ON DUPLICATE KEY UPDATE `flag`='{$flag_png}' ,`flag_name`='{$test_flag['name']}' ;");
			if (mysql_affected_rows()>0)
			{
				err('���� ����������!');
			}
			else
			{
				err('����� ���� ��� ����������!');
			}
		}
		else
		{
			err('������: ������ ���� � ��� �� ������!');
		}
	}
}
elseif (($_GET['usedays']>0) AND ($_POST['daystext']!=''))
{
	$flagid=(int)($_GET['usedays']);

	if ($flagid>0)
	{
		$test_flag=mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where id='{$flagid}' and owner='{$user['id']}' and setsale=0 and (prototype>=180001 and prototype<=180007);"));
		if ($test_flag['id']>0)
		{
			$mig[180001]='mon_100x100.png';
			$mig[180002]='tue_100x100.png';
			$mig[180003]='wed_100x100.png';
			$mig[180004]='thu_100x100.png';
			$mig[180005]='fri_100x100.png';
			$mig[180006]='sat_100x100.png';
			$mig[180007]='sun_100x100.png';

			$flag_png=$mig[$test_flag['prototype']]; // ��������

			$daystext=str_replace("&quot;","",$_POST['daystext']);
			$daystext=str_replace("&#39;","",$daystext);
			$daystext=str_replace("&#96;","",$daystext);
			$daystext=str_replace("&lt;","",$daystext);
			$daystext=str_replace("&gt;","",$daystext);
			mysql_query("INSERT INTO `oldbk`.`users_flag` SET `owner`='{$user['id']}',`flag`='{$flag_png}',`flag_name`='".mysql_real_escape_string($daystext)."'  ON DUPLICATE KEY UPDATE `flag`='{$flag_png}' ,`flag_name`='".mysql_real_escape_string($daystext)."' ;");
			if (mysql_affected_rows()>0)
			{
				err('����� ����������!');
			}
			else
			{
				err('����� ����� ��� ����������!');
			}
		}
		else
		{
			err('������: ������ ���� ������ � ��� �� ������!');
		}
	}
}
else
	if ($_GET['hiddenoff']) {
		hiddenoff($user['id']);
	} elseif ($_GET['uprune']) {
		$answ=mk_runs_lvl_up(intval($_GET['uprune']));
		echo "<font color=red>".$answ[msg]."</font>";
	} elseif ($_GET['illusionoff']) {
		illusionoff($user['id']);
	} elseif ($_GET['unikoff']) {
		mysql_query("DELETE from effects where type=4201 and owner = ".(int)($user['id']));
		mysql_query('UPDATE users SET unikstatus = "" WHERE id = '.$user['id'].' LIMIT 1');
	} 
	elseif ($_GET['carnavaloff']) {
		mysql_query("DELETE from effects where type=301 and owner = ".(int)($user['id']));
	} elseif ($_GET['carnavaloff2']) {
		mysql_query("DELETE from effects where type=302 and owner = ".(int)($user['id']));
	} elseif ($_GET['medoff']) {
		mysql_query("DELETE from effects where type=830 and owner = ".(int)($user['id']));
	} elseif (isset($_GET['rejectklan'])) {
		mysql_query('DELETE FROM effects WHERE owner = '.$user['id'].' and type = 110110 and id = '.intval($_GET['rejectklan']));
	} elseif (isset($_GET['approveklan'])) {
		$q = mysql_query('SELECT * FROM effects WHERE owner = '.$user['id'].' and type = 110110 and id = '.intval($_GET['approveklan']));
		if (mysql_num_rows($q) > 0 && $user['klan'] == "" && $user['align'] == 0) {
			// ���� �����������, ���������
			$newklan = mysql_fetch_assoc($q);
			$newklan = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE short = "'.$newklan['add_info'].'"'));

			if ($newklan['id'] > 0 && $newklan['align'] != "") {

				//��������� ������ ����
				$al = $newklan['align'];
				$qlist = array();
				$i = 0;

				$data=mysql_query("SELECT * FROM oldbk.beginers_quest_list WHERE  aganist like '%".(int)$al."%';");
				while($q_data=mysql_fetch_array($data)) {
					$qlist[$i]=$q_data[id];
					$i++;
				}

				mysql_query("UPDATE oldbk.beginers_quests_step set status =1 WHERE owner='".$user['id']."' AND quest_id in (".(implode(",",$qlist)).")");

				echo '<font color=red>�� ������� ������� � ����.</font>';

				$la=0;
				$last_aligh=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_last_align` WHERE `owner` = '".$user['id']."' LIMIT 1;"));   //��� ����� ������� �� ��������� ������
				if($last_aligh[id]>0) {
					$la = $last_aligh[align];
				}


				$eff_align_type=5001;
				$eff_align_time=time()+60*60*24*30*2;


				$cheff=mysql_fetch_array(mysql_query("SELECT * from `effects` WHERE type = '".$eff_align_type."' AND owner = '".$user['id']."' LIMIT 1;"));

				if($cheff['add_info'] == $newklan['align']) {
					$la = 0;
				}

				if($newklan['align'] != 0 && $la != $newklan['align'] && !$cheff[id]) {
					$sql="INSERT INTO `effects`
					(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
					('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','".$newklan['align']."');";
					mysql_query($sql);

					//������ ���, ���������.
				}

				//��������� �������� ��������, ���� ������� ����...
				$data=mysql_query('select * from oldbk.gellery_prot where klan_owner = '.$newklan[id].';');
				while($row = mysql_fetch_array($data)) {
					$sql='insert into oldbk.gellery set owner='.$user[id].',img="'.$row[img].'", exp_date='.$row[exp_date].',otdel='.$row[otdel].';';
					mysql_query($sql);
				}

				for($i=0; $i<count($db_city); $i++) {
					mysql_query('update '.$db_city[$i].'`users` set `status`= \'����\', `klan` = \''.$newklan['short'].'\', `align` = \''.$newklan['align'].'\' WHERE `id` = '.$user['id'].';');
				}


				mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$user['id']."','������ � ���� ".$newklan['short']."','".time()."');");

				// ������� ��� ��������� �����������
				mysql_query('DELETE FROM effects WHERE owner = '.$user['id'].' and type = 110110');
			} else {
				echo '<font color="red"><b>�� �� ������ ������� ��� �����������</b></font>';
			}
		} else {
			echo '<font color="red"><b>�� �� ������ ������� ��� �����������</b></font>';
		}
	}

if (isset($_GET['gallery'])) { $_POST['gallery']=1; }

if (($user['in_tower']==3) AND ($_POST['gallery'])) { unset($_POST['gallery']); }

if($_POST['gallery'] || ((int)$_GET['pic']&&(int)$_GET['dressimg']>=0) || (int)$_GET['del_pick']>0) //  �������
{
	$_GET['pic']=(int)($_GET['pic']);

	if($_GET['pic']>0&&$_GET['dressimg']==0&&!$_POST['target'])
	{
		$piccha= mysql_fetch_assoc(mysql_query('select g.*,
   		(select type from oldbk.shop as s where g.otdel=s.razdel limit 1 ) as type
   		from oldbk.gellery as g where id="'.$_GET['pic'].'" AND  owner = '.$user['id'].';'));
		$sql=check_hollydays($piccha,$hollyday);
		//AND type=".$piccha['type']." ������� �����, ���� �� ������ ������ � ������...
		$sql="select * from oldbk.inventory where owner = ".$user['id']."
    	AND add_pick='".$piccha['img']."' AND ".$sql."
    	AND bs_owner = 0 AND `setsale`=0 AND labonly=0 LIMIT 1";
		if($user['id']==28453)
		{
			//	echo $sql.'<br>';
		}
		$shmotka=mysql_fetch_assoc(mysql_query($sql));
		//if($shmotka['dressed']==0)
		{
			if($shmotka['add_pick']==$piccha['img'])
			{
				undress_img($shmotka);
				$mess='�������� ����� � ' . $shmotka['name'];
			}
		}
		/*else
		{
			$mess='������� ������� '. $shmotka['name'];
		}
		*/

	}

	if($_GET['pic']>0&&$_GET['dressimg']==1&&(int)$_POST['target']>0)
	{
		$_GET['pic']=(int)($_GET['pic']);
		$_POST['target']=(int)($_POST['target']);
		//������� �� ������ ��������

		$piccha= mysql_fetch_assoc(mysql_query('select g.*,
    	(select type from oldbk.shop as s where g.otdel=s.razdel limit 1 ) as type
    	from oldbk.gellery as g
    	where id="'.$_GET['pic'].'" AND exp_date>'.time().' AND owner = '.$user['id'].' AND dressed = 0;'));
		$sql=check_hollydays($piccha,$hollyday);

		$shmotka=mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where id = '".(int)$_POST['target']."' AND owner = ".$user['id']." AND ".$sql."
    	AND bs_owner = 0 AND `dressed`=0  AND labonly=0 AND `setsale`=0 and prototype not in (946,947,948,949,950,951,952,953,954,955,956,957) "));

		if($piccha['id']==$_GET['pic'] && $shmotka['id']==$_POST['target'])
		{
			$ok=0;
			//��������  ������ � ��������
			if($shmotka['add_pick']!='')
			{
				if(undress_img($shmotka))
				{
					$ok=1;
				}
			}
			else
			{
				$ok=1;
			}                                             //  nknown column 'pick_time' in 'field list'.
			if($ok==1)
			{
				mysql_query('update oldbk.inventory set add_pick="'.$piccha['img'].'", pick_time="'.$piccha['exp_date'].'" WHERE id='.$shmotka['id'].' AND owner = '.$user['id'].';');
				mysql_query('update oldbk.gellery set dressed=1 WHERE id='.$piccha['id'].' AND owner = '.$user['id'].';');
				$mess = '�������� ����� �� '.$shmotka['name'];
			}
		}
	}

	if($_GET['del_pick']>0)
	{
		$_GET['del_pick']=(int)($_GET['del_pick']);
		mysql_query('DELETE from oldbk.gellery where id="'.$_GET['del_pick'].'" AND owner ='.$user['id'].' AND dressed=0;');
	}
	//echo '�������';
	$img_array=array();



	$otdels_array=array(
			1=>'�������,����',11=>'������',12=>'������,������',13=>'����',14=>'���� � ��������',
			2=>'������',21=>'��������',22=>'������ �����',23=>'������� �����',6=>'�����',24=>'�����',
			3=>'����',
			4=>'������',41=>'��������',42=>'������');


	$colum_array=array(1,2,3,4,28,27,5,8,9,10,11);// ������� �� �����

	//������ �������������� �����
	$columotdel_array[4]=1;
	$columotdel_array[41]=2;
	$columotdel_array[1]=3;
	$columotdel_array[11]=3;
	$columotdel_array[12]=3;
	$columotdel_array[13]=3;
	$columotdel_array[14]=3;
	$columotdel_array[23]=4;
	$columotdel_array[42]=5;
	$columotdel_array[24]=8;
	$columotdel_array[21]=9;
	$columotdel_array[3]=10;
	$columotdel_array[2]=11;
	$columotdel_array[22]=28;
	$columotdel_array[6]=27;



	if ($user['klan']!='')
	{
		if ($_GET['clan']=='1')
		{
			$_SESSION['showklangell']=1;
		}
		else
			if (($_GET['clan']=='0') OR (!(isset($_SESSION['showklangell']))) )
			{
				$_SESSION['showklangell']=0;
			}


		$klan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
		
		if ($klan['glava']==$user['id'])
				{
				$ican_del_img=true;
				}
		
		$klsql=mysql_query("select * from oldbk.gellery_prot where klan_owner='{$klan['id']}'");
		while($dt=mysql_fetch_assoc($klsql))
		{
			$klans_images[]=$dt['img'];
		}
	}
	else
	{
		if ( (!(isset($_SESSION['showklangell']))) OR ($_SESSION['showklangell']!=0) )
		{
			$_SESSION['showklangell']=0;
		}
	}

	$sql=mysql_query('select g.* from oldbk.gellery as g where owner = '.$user['id'].' AND exp_date >'.time().' AND g.otdel!=99 order by otdel');

	$maxitems=1;
	while($data=mysql_fetch_assoc($sql))
	{
		if ($user['klan']!='')
		{
			//������ �� ���� ��������
			if ( ($_SESSION['showklangell']!=1) and (in_array($data['img'],$klans_images))  )
			{
				//���� ������ ������� � �������� � ������ ������ ���������� �� , ��� ����
				continue;
			}
			else if ((!(in_array($data['img'],$klans_images))) and ($_SESSION['showklangell']==1) )
			{
				//������� ���� ����� ��������
				continue;
			}
		}


		$data['type']=$columotdel_array[$data['otdel']];

		if(!$next_type || $data['type']!=$next_type)
		{
			$next_type=$data['type'];
			$counter=0;
		}
		$img_array[$data['type']][$counter]=$data;
		if ($maxitems<=$counter) {$maxitems=$counter+1;}
		$counter++;
	}

	?>
	<!DOCTYPE html>
	<HTML>
	<HEAD>
		<title></title>
		<link rel="stylesheet" href="newstyle20.css" type="text/css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<META Http-Equiv=Cache-Control Content=no-cache>
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
		<script type="text/javascript" src="/i/globaljs.js"></script>
		<script>
			function createrequestobject()
			{
				var request;
				if (window.XMLHttpRequest)
				{
					try
					{
						request = new XMLHttpRequest();
					}
					catch (e){}
				}
				else if (window.ActiveXObject)
				{
					try
					{
						request = new ActiveXObject('Msxml2.XMLHTTP');
					}
					catch (e)
					{
						try
						{
							request = new ActiveXObject('Microsoft.XMLHTTP');
						}
						catch (e){}
					}
				}

				return request;
			}

			function selecttarget(scrollid)
			{
				var targertinput = document.getElementById('target');
				targertinput.value = scrollid;

				var targetform = document.getElementById('formtarget');
				targetform.submit();
			}

			function getchoice(type,nlevel)
			{
				if (typeof(nlevel) == "undefined") { var nlevel=0; }
							
				var container = document.getElementById("itemcontainer");
				var request = createrequestobject();
				if (request)
				{
					request.open("POST", "itemschoice.php?otdel=" + type +"&get=1&nlevel=" + nlevel, true);
					request.onreadystatechange = function()
					{
						if (request.readyState == 4)
						{
							if (request.status == 200)
							{
								container.innerHTML = request.responseText;
							}
							else
							{
								container.innerHTML = "<font color='red'><B>��������� ������</font>";
							}
						}
					};
					request.send(null);
				}
				else
				{
					container.innerHTML = "<font color='red'><B>��������� ������</font>";
				}
			}

		
			function showitemschoice(title, type, script,nlevel)
			{
				if (typeof(nlevel) == "undefined") { var nlevel=0; }
				
				var choicehtml = "<form style='display:none' id='formtarget' action='" + script + "' method=POST><input type='hidden' id='target' name='target'><input type='hidden' id='nlevel' name='nlevel' value='"+nlevel+"'>";
				choicehtml += "</form><table width='100%' cellspacing='1' cellpadding='0' bgcolor='CCC3AA'>";
				choicehtml += "<tr><td align='center'><B><span id='title'>" + title + "</span></td>";
				choicehtml += "<td width='20' align='right' valign='top' style='cursor: pointer' onclick='closehint3(true);'>";
				choicehtml += "<big><b>x</td></tr><tr><td colspan='2' id='tditemcontainer'><div id='itemcontainer' style='width:100%'>";
				choicehtml += "</div></td></tr></table>";

				var el = document.getElementById("hint3");
				el.innerHTML = choicehtml;
				el.style.width = 400 + 'px';
				el.style.visibility = "visible";
				el.style.left = 100 + 'px';
				el.style.top = 100 + 'px';
				Hint3Name = "target";

				getchoice(type,nlevel);
			}

			function closehint3(clearstored){
				if(clearstored)
				{
					var targetform = document.getElementById('formtarget');
					targetform.action += "&clearstored=1";
					targetform.submit();
				}
				document.getElementById("hint3").style.visibility="hidden";
				Hint3Name='';
			}
		</script>
		<script type="text/javascript" src="http://i.oldbk.com/i/showthing.js"></script>
		<!-- Asynchronous Tracking GA top piece counter -->
		<script type="text/javascript">

			var _gaq = _gaq || [];

			var rsrc = /mgd_src=(\d+)/ig.exec(document.URL);
			if(rsrc != null) {
				_gaq.push(['_setCustomVar', 1, 'mgd_src', rsrc[1], 2]);
			}

			_gaq.push(['_setAccount', 'UA-17715832-1']);
			_gaq.push(['_addOrganic', 'm.yandex.ru', 'text', true]);
			_gaq.push(['_addOrganic', 'images.yandex.ru', 'text', true]);
			_gaq.push(['_addOrganic', 'blogs.yandex.ru', 'text', true]);
			_gaq.push(['_addOrganic', 'video.yandex.ru', 'text', true]);
			_gaq.push(['_addOrganic', 'go.mail.ru', 'q']);
			_gaq.push(['_addOrganic', 'm.go.mail.ru', 'q', true]);
			_gaq.push(['_addOrganic', 'mail.ru', 'q']);
			_gaq.push(['_addOrganic', 'google.com.ua', 'q']);
			_gaq.push(['_addOrganic', 'images.google.ru', 'q', true]);
			_gaq.push(['_addOrganic', 'maps.google.ru', 'q', true]);
			_gaq.push(['_addOrganic', 'nova.rambler.ru', 'query']);
			_gaq.push(['_addOrganic', 'm.rambler.ru', 'query', true]);
			_gaq.push(['_addOrganic', 'gogo.ru', 'q']);
			_gaq.push(['_addOrganic', 'nigma.ru', 's']);
			_gaq.push(['_addOrganic', 'search.qip.ru', 'query']);
			_gaq.push(['_addOrganic', 'webalta.ru', 'q']);
			_gaq.push(['_addOrganic', 'sm.aport.ru', 'r']);
			_gaq.push(['_addOrganic', 'akavita.by', 'z']);
			_gaq.push(['_addOrganic', 'meta.ua', 'q']);
			_gaq.push(['_addOrganic', 'search.bigmir.net', 'z']);
			_gaq.push(['_addOrganic', 'search.tut.by', 'query']);
			_gaq.push(['_addOrganic', 'all.by', 'query']);
			_gaq.push(['_addOrganic', 'search.i.ua', 'q']);
			_gaq.push(['_addOrganic', 'index.online.ua', 'q']);
			_gaq.push(['_addOrganic', 'web20.a.ua', 'query']);
			_gaq.push(['_addOrganic', 'search.ukr.net', 'search_query']);
			_gaq.push(['_addOrganic', 'search.com.ua', 'q']);
			_gaq.push(['_addOrganic', 'search.ua', 'q']);
			_gaq.push(['_addOrganic', 'poisk.ru', 'text']);
			_gaq.push(['_addOrganic', 'go.km.ru', 'sq']);
			_gaq.push(['_addOrganic', 'liveinternet.ru', 'ask']);
			_gaq.push(['_addOrganic', 'gde.ru', 'keywords']);
			_gaq.push(['_addOrganic', 'affiliates.quintura.com', 'request']);
			_gaq.push(['_trackPageview']);
			_gaq.push(['_trackPageLoadTime']);
		</script>
		<!-- Asynchronous Tracking GA top piece end -->
	</HEAD>
	<body >
	<?
	make_quest_div();
	?>
	<div id=hint3 class=ahint style="z-index:500;"></div>
	<div id="page-wrapper">
		<div class="btn-control">
			<div class="button-mid btn" onClick="location.href='main.php?gallery=<? echo mt_rand(1111,9999);?>';">��������</div>
			<div class="button-mid btn" onClick="location.href='main.php?edit=<? echo mt_rand(1111,9999);?>';">���������</div>
		</div>
		<table align="center" class="table-list pic-items" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="14px">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="9%">
				<col width="14px">
			</colgroup>
			<thead>
			<tr class="head-line">
				<th class="center" colspan="7">
					<div class="head-left"></div>
					<?

					if ($_SESSION['showklangell']==1)
					{
						echo '<a href="main.php?gallery='.mt_rand(1111,9999).'&clan=0">������ ��������</a>';
					}
					else
					{
						echo '<div class="head-title"><span class="active">������ ��������</span></div>';
					}
					if ($user['klan']!='')
					{
						echo    '<div class="head-separate right"></div>';
					}
					?>

				</th>
				<th class="center" colspan="6">
					<?
					if ($user['klan']!='')
					{
						if ($_SESSION['showklangell']==1)
						{
							echo '<div class="head-title"><span class="active">�������� ��������</span></div>';
						}
						else
						{
							echo   '<a href="main.php?gallery='.mt_rand(1111,9999).'&clan=1">�������� ��������</a>';
						}
					}
					?>
					<div class="head-right"></div>
				</th>
			</tr>
			</thead>
			<tbody>
			<tr class="title-row">
				<td class="row-left"></td>
				<td class="odd">
					������
				</td>
				<td class="even">
					��������
				</td>
				<td class="odd">
					������
				</td>
				<td class="even">
					�����
				</td>
				<td class="even">
					������ �����
				</td>
				<td class="even">
					�����
				</td>
				<td class="odd">
					������
				</td>
				<td class="even">
					����
				</td>
				<td class="odd">
					��������
				</td>
				<td class="even">
					���
				</td>
				<td class="odd">
					������
				</td>
				<td class="row-right"></td>
			</tr>
			<tr>
				<td class="row-left"></td>
				<td colspan="11" class="separate"></td>
				<td class="row-right"></td>
			</tr>



			<?
			/*
echo "<pre>";
print_r($img_array);
echo "</pre>";
echo count($img_array);
echo "<br>";
echo $maxitems;
*/


			for ($ii=0;$ii<$maxitems;$ii++)   		// ������ ������ �� ������������� ���������� ��������
			{
				echo '<tr>
                		<td class="row-left"></td>';

				foreach($colum_array as $k=>$v)
				{
					$clr = $k % 2 == 0 ? 'odd' : 'even';

					echo ' <td class="'.$clr.' item-block">';


					if (is_array($img_array[$v]))
					{
						$elem=$img_array[$v][$ii];

						if (is_array($elem))
						{
							echo ' <div class="item-head">';
							echo '<img src=http://i.oldbk.com/i/sh/'.$elem['img'].'><br>';
							echo ($elem['exp_date']<1999999999?'<small>'.date("Y.m.d H:i",$elem['exp_date']).'</small>':'');
							echo '</div>
			                <div class="item-footer">';

					$del_link="<a OnClick=\"if (!confirm('������� ��������?')) { return false; } \" href='main.php?del_pick=".$elem['id']."'>&nbsp;<img src='http://i.oldbk.com/i/clear.gif'></a>";
					
						if (($user['klan']!='') and ($_SESSION['showklangell']==1) )
						{
								if ($ican_del_img!=true)
								{
								$del_link='';
								}
						}

						echo ($elem['dressed']==0?"<div class=\"button-mid btn\" onclick=\"showitemschoice('�������� ������� ��������� ��������', '".$elem['otdel']."', 'main.php?pic=".$elem['id']."&amp;dressimg=1');\">������</div>
		                 		".$del_link:"
		                 		<div class=\"button-mid btn\" OnClick=\"location.href='main.php?pic=".$elem['id']."&dressimg=0';\">�����</div>")."";

							echo '</div>';
						}
					}


					echo '</td>';
				}
				echo '<td class="row-right"></td>
	            </tr>
        	    <tr>
	                <td class="row-left"></td>
        	        <td colspan="11" class="separate"></td>
	                <td class="row-right"></td>
        	  </tr>';
			}
			?>
			</tbody>
			<tfoot>
			<tr class="obraz-footer">
				<td class="" colspan="2">
					<div class="footer-left"></div>
				</td>
				<td class="" colspan="9">
					<div class="footer-center"></div>
				</td>
				<td class="" colspan="2">
					<div class="footer-right"></div>
				</td>
			</tr>
			</tfoot>
		</table>
		<div class="block-hint">
			������ � �������� ������ ��� ������ ��������� ����� ���������� � <a href="http://oldbk.com/commerce/index.php" target="_blank">������������ ������</a>
		</div>
	</div>
	<? include_once "end_files.php"; ?>
	</body>
	</html>


	<?

/////////////////////////////////////////////////////
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////

	die;
}


$_security_action = false;
$security_actions = ['set_2fa', 'unset_2fa', 'prepare_2fa', 'second_password_prepare', 'second_password_set'];
foreach ($security_actions as $_s_action) {
    if(isset($_POST[$_s_action])) {
		$_security_action = true;
    }
}
if($_security_action || (@$_POST['changepsw'] || @$_POST['second_password'] || isset($_POST['unset_second_password']) || isset($_POST['btn_set_advises'])) OR ($_POST['ipsetup']) || ($_POST['setautobank']) || ($_POST['unsetbank']) || ($_POST['scansubmit'])  || isset($_FILES['upfile']))
{
	?>
	<HTML><HEAD>
		<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
        <link rel="stylesheet" href="/i/btn.css" type="text/css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<META Http-Equiv=Cache-Control Content=no-cache>
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
		<script type="text/javascript" src="/i/globaljs.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

		<style>
			.sn_list ul {
				margin: 0;
				padding: 0;
				list-style: none;
			}
			.sn_list ul li {
				display: inline-block;
			}
			.sn_list ul li img.active {
				opacity: 0.5;
				-ms-filter: "alpha(opacity=50)";
				filter: alpha(opacity=50);
			}
			input[type="submit"][disabled] {
   				color: gray;
			}
		</style>
		<script>

			function showhide(id)
			{
				if (document.getElementById(id).style.display=="none")
				{document.getElementById(id).style.display="block";}
				else
				{document.getElementById(id).style.display="none";}
			}
					
		</script>
	</HEAD>
	
	<body bgcolor=e2e0e0>
	<FORM ACTION="_main_.php" METHOD=POST>
		<table width=100%><tr><td><h3>������������</h3></td><td align=right>
                    <div class="btn-control">
                        <INPUT class="button-mid btn" TYPE=button value="���������" onClick="location.href='main.php?edit=1&tmp=<?=mt_rand(1111,9999);?>';">
                    </div>
                </td></tr>
		</table>
		<table width="100%" border=0>
			<tr valign=top>
				<td valign="top" width="50%" valign=top>
					<fieldset style="text-align:justify;">
						<legend><b>������� ������</b></legend>
						<?php
						$ip=$_SERVER['REMOTE_ADDR'];
						include ("alg.php");
						if ($_POST['oldpass'] && $_POST['npass'] && $_POST['npass2']) {
							$ops = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}'"));
							if (mysql_real_escape_string($ops['pass']) == in_smdp_new($_POST['oldpass'])) {
								if (in_smdp($_POST['npass']) === mysql_real_escape_string($user['oldpass'])) {
									echo "<font color=red><b>�� ����������� ������ ������.</b></font>"; 
								} else {
									if($_POST['npass'] == $_POST['npass2']) {
										if(mysql_query("UPDATE `users` SET `pass` = '".in_smdp_new($_POST['npass'])."' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"))
										{
											//��������� ������� ���������� ������
											mysql_query("INSERT oldbk.`users_pas_ch` (`owner`,`login` ,`last`) values('".$_SESSION['uid']."','".$ops['login']."' , '".time()."') ON DUPLICATE KEY UPDATE `last`='".time()."' ; ");
	
											echo "<font color=red><b>������ ������ ������.</b></font>";
											$str_delo="INSERT INTO oldbk.`lichka` (`id` , `pers` , `text`, `date`)
												VALUES
												('','{$_SESSION['uid']}','<font color=green>������ ������</font>. Ip � �������� ����������� �����: ".$ip."','".time()."');";
											//echo $str_delo;
											if(!mysql_query($str_delo))
											{
												//echo mysql_error();
											}
	
										}
									} else	{ 
										echo "<font color=red><b>�� ��������� ����� ������.</b></font>"; 
									}
								}
							} else { 
								echo "<font color=red><b>�������� ������ ������.</b></font>"; 
							}
						}
						?>
						<table>
							<tr>
								<td align=right>������ ������:</td><td><input type=password name="oldpass"></td>
							</tr>
							<tr>
								<td align=right>����� ������:</td><td><input type=password name="npass"></td>
							</tr>
							<tr>
								<td align=right>����� ������ (��� ���):</td><td><input type=password name="npass2"></td>
							</tr>
							<tr>
								<td align=right>
                                    <div class="btn-control">
                                        <input class="button-mid btn" type=submit value="������� ������" name="changepsw">
                                    </div>
                                </td><td></td>
							</tr>
						</table>
					</fieldset>
					
<br>
					<fieldset style="text-align:justify;">
						<legend><b>������ ������</b></legend>
						<?php
                        /** @var \components\models\User2fa $user2fa */
						$user2fa = \components\models\User2fa::find($user['id']);

						if(!isset($_POST['second_password_set'])) {
						    unset($_SESSION['second_pass_generate']);
						}
						$second_password = isset($_SESSION['second_pass_generate']) ? $_SESSION['second_pass_generate'] : null;
						$second_password_confirm = isset($_POST['second_password_value']) ? $_POST['second_password_value'] : -1;
						$len = $second_password ? strlen($second_password) : 0;

						if(isset($_POST['second_password_prepare'])) {
							$len = 4;
							switch (intval($_POST['pwdlenght'])) {
								case 1:
									$len = 0;
									break;
								case 2:
									$len = 4;
									break;
								case 3:
									$len = 6;
									break;
								case 4:
									$len = 8;
									break;
								default:
									$len = 4;
									break;
							}
							$second_password = "";
							for ($i = 0; $i < $len; $i++) {
								$second_password .= rand(0, 9);
							}
							$_SESSION['second_pass_generate'] = $second_password;
						}

						$second_pass_error = null;
						if(isset($_POST['second_password_set'])) {
						    if($second_password == $second_password_confirm) {
								mysql_query("UPDATE users SET second_password = '".($len > 0 ? md5($second_password) : "")."' WHERE id = " . $_SESSION['uid']);
								echo "<font color=red><b>������ ������ ����������</b></font>";
								$user['second_password'] = md5($second_password);

								$str_delo="INSERT INTO oldbk.`lichka` (`id` , `pers` , `text`, `date`) VALUES 	('','{$_SESSION['uid']}','<font color=green>������ ������ ����������</font>. Ip � �������� ����������� ��������: ".$ip."','".time()."');";
								mysql_query($str_delo);

								if($user2fa && ($user2fa->isEnabled() || $user2fa->isPrepared())) {
									$user2fa->disable();
								}
								$second_password = null;
								unset($_SESSION['second_pass_generate']);
                            } else {
								$second_pass_error = '������ �� ���������';
                            }

						}

						if(isset($_POST['unset_second_password'])) {
							mysql_query("UPDATE users SET second_password = '' WHERE id = " . $_SESSION['uid']);
							unset($user['second_password']);
							echo "<font color=red><b>������ ������ ����</b></font>";

							$str_delo="INSERT INTO oldbk.`lichka` (`id` , `pers` , `text`, `date`) VALUES 	('','{$_SESSION['uid']}','<font color=green>������ ������ ����</font>. Ip � �������� ����������� ��������: ".$ip."','".time()."');";
							mysql_query($str_delo);


						}
						?>
						<table width="100%">
							<tr>
								<td>
                                    <?php if($second_password): ?>
                                        <font color=red><b>��� ������ ������: <?= $second_password ?>.</b></font>
                                    <?php endif; ?>
									<ul>�������� ������� ���������:
										<li><input type="radio" name="pwdlenght" value="2" /> ������� (4 �����)
										<li><input type="radio" name="pwdlenght" value="3" /> ������� (6 ������)
										<li><input type="radio" name="pwdlenght" value="4" /> ������� (8 ������)
									</ul>
                                    <?php if($second_password): ?>
                                        <?php if($second_pass_error): ?>
                                            <font color=red><b><?= $second_pass_error ?></b></font>
                                        <?php endif; ?>
                                        <div>
                                            <input name="second_password_value" type="text" value="">
                                            <input class="button-mid btn" type="submit" name="second_password_set" value="�����������" />
                                        </div>
                                    <?php endif; ?>
								</td>
							</tr>

							<tr>
								<td>
									<div class="btn-control">
                                        <input class="button-mid btn" type="submit" name="second_password_prepare" value="����������" />
										<?php if($user['second_password']) {?><input class="button-big btn" type="submit" name="unset_second_password" value="����� ������ ������" /> <?php } ?>
                                    </div>
									<br /><small><font color=red><b>��������!</b></font> ������ ������ ������� �� ����������� �����, ���������� ��� ������ ���-���� ���. ������ ����������� ��� ��������� ������� ������!</small>
								</td>
							</tr>
						</table>
					</fieldset>


					<?php
					$google2fa = new Google2FA();
					$_2fa_error = '';

					if(isset($_POST['prepare_2fa'])) {
						if (!$user2fa) {
							$user2fa = new \components\models\User2fa();
							$user2fa->user_id = $user['id'];
							$user2fa->created_at = time();
						}

						$user2fa->prepare($google2fa);
					}

					if(isset($_POST['set_2fa']) && isset($_POST["2fa_code"]) && $user2fa) {
						if($google2fa->verifyKey($user2fa->secret, $_POST["2fa_code"])) {
							$user2fa->enable();
                        } else {
						    $_2fa_error = '����� �� �����';
                        }
					}

					if(isset($_POST['unset_2fa']) && $user2fa && ($user2fa->isEnabled() || $user2fa->isPrepared())) {
						$user2fa->disable();
					}

					?>

                    <fieldset style="text-align:justify;">
                        <legend><b>Google Authenticator</b></legend>

                        <table width="100%">
                            <tr>
                                <td>
									<?php if(!$user2fa || $user2fa->isDisabled()): ?>
                                        <div class="btn-control">
                                            <input class="button-mid btn" type="submit" name="prepare_2fa" value="��������" />
                                        </div>
									<?php else: ?>
                                        <table>
                                            <tr>
                                                <td>
													<?php
													$google2fa_url = $google2fa->getQRCodeGoogleUrl(
														'https://oldbk.com',
														mb_convert_encoding($user['login'], "utf-8", "windows-1251").'@oldbk.com',
														$user2fa->secret
													);
													?>
                                                    <img src="<?= $google2fa_url ?>" alt=""><br>
                                                    <div class="btn-control">
                                                        <input class="button-mid btn" type="submit" name="unset_2fa" value="���������" />
                                                    </div>
                                                </td>
                                                <td>
													<?php if($user2fa->isPrepared()): ?>
                                                        <input name="2fa_code" placeholder="������� 6 ���� ����">
                                                        <div class="btn-control">
                                                            <input class="button-mid btn" type="submit" name="set_2fa" value="�����������" />
                                                        </div>
														<?php if($_2fa_error): ?>
                                                            <br><div style="color:red;"><?= $_2fa_error ?></div>
														<?php endif; ?>
													<?php endif; ?>
                                                </td>
                                            </tr>
                                        </table>
									<?php endif; ?>
                                    <br /><small><font color=red><b>��������!</b></font> ������� �� ��������� <a href="https://support.google.com/accounts/answer/1066447?co=GENIE.Platform%3DAndroid&hl=ru" target="_blank">Google Authenticator</a></small>
                                    <br /><small><font color=red><b>��������!</b></font> ����� ���� ���������� ������ ���� �� ��������� ������, ���� ������ ������, ���� Google Authenticator</small>
                                    <br /><small><font color=red><b>��������!</b></font> ��� �������� � �������� ���������� Google Authenticator �������� ����������� �������������� � ����.</small>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
					
				<br>

						<?php
						
						/*
						<fieldset style="text-align:justify; ">
						<legend><b>�������� ������������� ������� ��������</b></legend>
						if (isset($_FILES['upfile'])) {
							if ($_FILES['upfile']['error'] == UPLOAD_ERR_OK) {
								$imageinfo = @getimagesize($_FILES['upfile']['tmp_name']);
								if ($imageinfo !== FALSE && ($imageinfo[2] == IMAGETYPE_GIF || $imageinfo[2] == IMAGETYPE_PNG || $imageinfo[2] == IMAGETYPE_JPEG || $imageinfo[2] == IMAGETYPE_BMP)) {
									if($_FILES['upfile']['size'] <= 3*1024*1024) {
										if ($imageinfo[2] == IMAGETYPE_GIF) $ext = "gif";
										if ($imageinfo[2] == IMAGETYPE_PNG) $ext = "png";
										if ($imageinfo[2] == IMAGETYPE_JPEG) $ext = "jpeg";
										if ($imageinfo[2] == IMAGETYPE_BMP) $ext = "bmp";
				
										$filename = $user['id'].'_'.time().'_'.md5(file_get_contents($_FILES['upfile']['tmp_name'])).".".$ext;
				
										require_once('./cloud/cloud_api.php');
										CloudPut($_FILES['upfile']['tmp_name'],'oldbkstatic','i/usersscans/'.$filename);
										CloudSetACL('oldbkstatic','i/usersscans/',$filename,"public");
				
										$q = mysql_query('INSERT INTO oldbk.users_scans (owner,status,filename,sdate) VALUES ("'.$user['id'].'","0","'.$filename.'","'.time().'")');
										if ($q !== FALSE) {
											err('���� ������� ��������, �������� ��������� ���������.');
										}
									} else {
										err('������ ����� ��������� 2��');
									}
								} else {
									err('�������� �������� ������');
								}
							} else {
								err('������ �������� �����');
							}
						}


						</form>
						<form enctype="multipart/form-data" method="post">
							<table class='btable2' style="text-align:left;"><tr>
									<td nowrap>������� ����</td>
									<td width=100%><input type='file' autocomplete=off id='upfile' name='upfile' size=50 value=''></td></tr>
								<tr><td colspan=2><b>(�� ����� 3��, ������ jpeg/gif/bmp/png)</b></td></tr>
								<tr><td><input id="upsubmit" disabled="disabled" type='submit' class='submitinput' name='scansubmit' value='��������� '></td></tr>
							</table>
						</form>
						<FORM ACTION="main.php" METHOD=POST>
						<script>
							$('#upfile').bind('change', function() {
				            			var size = this.files[0].size/1024/1024;
								if (size > 3) {
									alert("������ ����������� �� ������ ��������� 3 MB")
									$("#upsubmit").attr('disabled', 'disabled');
								} else {
									$("#upsubmit").removeAttr('disabled');
								}
				        		});
						</script>
					</fieldset>					
					*/
					?>
				</td>

				<td valign="top">
					<fieldset style="text-align:justify;">
						<?


						$get_ip_setups=unserialize($user['gruppovuha']);

						if (isset($_POST['ipsetup']))
						{
							if (isset($_POST['lookip'])) 
								{
								$get_ip_setups[6]=1; 
								}
								else
								{
								$get_ip_setups[6]=0; 
								}
								
							if (isset($_POST['controlip'])) 
								{  
								$get_ip_setups[7]=1; 
								}
								else
								{
								$get_ip_setups[7]=0; 
								}
							
							if (isset($_SESSION['gruppovuha'][8])) 
								{
								$get_ip_setups[8]=$_SESSION['gruppovuha'][8]; 
								}
							
							//print_r($get_ip_setups);
							$seve_ip_setups=serialize($get_ip_setups);
							
							mysql_query("UPDATE `users` SET `gruppovuha` = '".$seve_ip_setups."' WHERE `id` = '{$user['id']}' LIMIT 1;");
							//echo "UPDATE `users` SET `gruppovuha` = '".$seve_ip_setups."' WHERE `id` = '{$user['id']}' LIMIT 1;";
							if (mysql_affected_rows()>0)
							{
								echo "<font color=red><b>��������� ������� ��������.</b></font><br>";
							}
						} ?>

						<legend><b>��������� IP ������</b></legend>
		                <input type=checkbox name=lookip<?= (($get_ip_setups[6]==0)?"":" checked='checked' ") ?>>�������� ���� ��������� IP ����� � ���� ��������!<br>
		                <input type=checkbox name=controlip <?= (($get_ip_setups[7]==0)?"":" checked='checked' ") ?>>�������������� ���� IP �� ����� ����! (�������������)<br>
		                <div class="btn-control">
                            <input class="button-mid btn" type=submit name=ipsetup value='���������'>
                        </div>
					</fieldset>
					
				<br>
				
					<?php
					$oauth_list = OAuthUser::getOAuthList();
					$user_active_sn = array();
					$_query = mysql_query(sprintf('select sn_type, sn_id from users_sn where user_id = %d and is_deleted = 0', $user['id']));
					while($user_sn = mysql_fetch_array($_query))
						$user_active_sn[] = $user_sn['sn_type'];

					?>
					<fieldset style="text-align:justify;">
						<legend><b>���������� ����</b></legend>
						<div class="sn_list">
							<ul>
								<?php foreach(OAuthUser::getOAuthList() as $sn_type => $info): ?>
									<li>
										<?php if(in_array($sn_type, $user_active_sn)): ?>
											<img class="active" src="<?= $info['img'] ?>">
										<?php else: ?>
											<a href="/action/oauth/<?= $info['action'] ?>/index?callback=assign" target="_blank">
												<img src="<?= $info['img'] ?>">
											</a>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</fieldset>					
					
					<br>
						<?
						//if ($user['klan']=='radminion')
						{
						?>
						<fieldset style="text-align:justify;">
						<legend><b>��������� ����������� � �����</b></legend>
						<?
						$get_ip_setups=unserialize($user['gruppovuha']);
						
						if  ( (isset($_POST['setautobank'])) or ($_POST['unsetbank']==1) )
						{
							if (($_POST['autobankid']==0) or  ($_POST['unsetbank']==1) )
							{
								//����������
								$set_new_bankid=0;
							}
							else
							{
						
									if(isset($_POST['autobankid']) && isset($_POST['autopass'])) 
										{
											$data = mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = '".$user['id']."' AND `id`= '".$_POST['autobankid']."' AND `pass` = '".md5($_POST['autopass'])."';");
											$data = mysql_fetch_array($data);
											if($data['id']>0) 
											{
											//echo "ok";
												if(!$_SESSION['bankid']) 
												{
												//���� ��� �� ��������� ���������
												$_SESSION['bankid'] =$data['id'];
												}
												$set_new_bankid=$data['id'];
																					
											} else {
												err('�������� ������.');
											}
										
										}
							}

							if ($set_new_bankid!=$get_ip_setups[9])
								{
								$get_ip_setups[9]=$set_new_bankid;
									$seve_ip_setups=serialize($get_ip_setups);
									mysql_query("UPDATE `users` SET `gruppovuha` = '".$seve_ip_setups."' WHERE `id` = '{$user['id']}' LIMIT 1;");
									if (mysql_affected_rows()>0)
									{
										err("��������� ������� ��������.<br>");
									}
								}					
						}
							if ($get_ip_setups[9]>0)
							{
							echo "����������� ����������� �� ���� �:{$get_ip_setups[9]} <br> ";
							echo "<a onclick=\"showhide('bnkaform');\" href=\"javascript:Void();\">��������</a> | <a href=\"javascript:void(0);\" onClick=\"document.getElementById('unsetbank').value=1; document.banksetauto.submit();\"  >����������</a> <br><br>";
							$shfrm=" style=\"display:none;\"  ";
							}
							else
							{
							$shfrm=" style=\"display:block;\" ";
							}
						
						echo "<div id=\"bnkaform\" {$shfrm} > ";
						?>
						<form method="post" name="banksetauto">
							<table border=0  style="text-align:left;">
								<tr>
									<td nowrap>���������� ����:</td>
									<td >
									<?
									$banks = mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = ".$user['id'].";");
									echo "<select style='width:150px' name=autobankid>";
									echo "<option value=0>---</option>";
									while ($rah = mysql_fetch_array($banks)) 
									{
									$chk='';
										if ($rah['id']==$get_ip_setups[9])
											{
											$chk=' selected="selected" ';
											}
											echo "<option {$chk} >",$rah['id'],"</option>";
									}
									echo "</select>";
									?>
									</td>
								</tr>
								<tr>
									<td nowrap>������:</td>
									<td ><input type=password name=autopass size=21 value=""> </td>
								</tr>								
								<tr><td colspan="2" align=center><input type=hidden name='unsetbank' id='unsetbank' value=''>
                                        <div class="btn-control">
                                            <input class="button-mid btn submitinput" type='submit' name='setautobank' value='�� '>
                                            <input class="button-mid btn submitinput" type='submit' name='cansel' value='���'>
                                        </div>
                                    </td></tr>
							</table>
						</form>
						</div>
						
						
					<small><font color=red><b>��������!</b></font> ��������� ����� ����� ������� ������������ ����� ��������� ��� ����� ������� � ��������. <br>
					������� ������ "��", �� ������������, ��� ����������� � �������� � ���� ������.<br>
					������������� �� ����� ��������������� �� ������������� ������ ����� ����������������.<br></small>
						
					</fieldset>
					<?
					}
					?>
					

			<? if($user['level'] < 5) { ?>
						<br>
						<fieldset style="text-align:justify; min-height:160px;">
							<legend><b>������� ��������</b></legend>
							<?
							$show_advises=explode(',',$user['show_advises']);

							if(isset($_POST['btn_set_advises']))
							{
								if(isset($_POST["check_advises_on_off"])) { $show_advises[0] = 1; }else{ $show_advises[0] = 0; }
								$show_advises_b=implode(',',$show_advises);
								if(mysql_query("UPDATE `users` SET `show_advises` = '".$show_advises_b."' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"))
								{
									echo "<font color=red><b>��������� ������ ��������� ������� ��������.</b></font>";
								}
							}
							?>
							<table>
								<tr><td>
										<?
										if($show_advises[0] == 1)
										{
											echo "<input type='checkbox' name='check_advises_on_off' checked='1' />";
										}
										else
										{
											echo "<input type='checkbox' name='check_advises_on_off' />";
										}
										?>
										���������� ���������</td>
									<td><input type="submit" name="btn_set_advises" value="����������"/></td></tr>
							</table>
						</fieldset>
				<?}?>
		
	</td>
	</tr>
	</table>
	</form>
	<? include_once "end_files.php"; ?>
	</body>
	</html>
	<?php

/////////////////////////////////////////////////////
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////

	die();
}

if(@$_POST['editanketa']) {
	echo "<script></script>";
}

if((@$_REQUEST['transreport']) or (@$_REQUEST['gethistory'])) {
	?>
	<HTML><HEAD>
		<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
        <link rel="stylesheet" href="/i/btn.css" type="text/css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<META Http-Equiv=Cache-Control Content=no-cache>
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
		<script type="text/javascript" src="/i/globaljs.js"></script>
	</HEAD>
	<body bgcolor=e2e0e0>
	<FORM ACTION="main.php" METHOD=POST>
		<P align=right>
            <div class="btn-control" style="text-align: right">
                <INPUT class="button-dark-mid btn" TYPE=button value="���������" style="background-color:#A9AFC0" onClick="window.open('help/schet.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
                <INPUT class="button-mid btn" TYPE=submit value="���������" name=edit>
            </div>
        </P>
		<H3>����� � ���������</H3>

		�� ������ �������� ����� � ��������� ��������/����� �� ���/� ��� �� ��������� ����. ������ �������, ����� <B>0.5 ��.</B><BR>
		� ��� �� �����: <B>
			<?
			if ($_POST['date']&&($user['money']>= 0.5)) {
				echo round($user['money']-0.5,2);
			} else {
				echo $user['money'];
			}
			?>
		</B> ��.<BR>
		������� ����, �� ������� ������ �������� �����: <INPUT TYPE=text NAME=date value="<?=date("d.m.y")?>"> <div class="btn-control" style="display: inline-block"><INPUT class="button-mid btn" TYPE=submit name=transreport value="�������� �����"></div>
	</FORM>
	<!-- <BR><BR>
	<FORM ACTION="main.php" METHOD=POST>
	�� ������ �������� ����� � ������ ���������. ������ ����������<BR>
	<INPUT TYPE=submit name=gethisory value="�������� �����">
	</FORM> -->

	<?php

	/*if (isset($_POST['gethistory']))
		{
		echo "������� � ���������� ��������� ��������� � ���������.";
		$data = mysql_query("SELECT * FROM oldbk.`logitemmf` WHERE `owner` = '{$_SESSION['uid']}'  ;");
		while ($row = mysql_fetch_array($data)) {
			$rr=$row['was']."<br>".$row['add']."\n<br>";
			mysql_query("INSERT INTO oldbk.`inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`)VALUES('{$_SESSION['uid']}','������','50',0,0,'paper100.gif','������� � ������� ��������� ��� ��������� \"{$user['login']}\" :\n{$rr}',1,0) ;");
									}


		}
	else */
	if ($_POST['date']&&($user['money']>= 0.5)) {
		$ddate = explode(".",$_POST['date']);
		if (count($ddate) == 3) {
			mysql_query("UPDATE `users` set `money` = `money`- '0.5' WHERE id = {$_SESSION['uid']}");
			echo "������� � ��������� �� ��������� \"{$user['login']}\" �� ".$_POST['date'].":<BR>";

			if (mktime(0,0,0,$ddate[1],$ddate[0],$ddate[2])<=1322690400)
			{
				//������ �������
				$data = mysql_query("SELECT * FROM oldbk.`delo` WHERE `pers` = '{$_SESSION['uid']}' AND (`type` = 1 OR TYPE = 99 OR TYPE = 44 ) AND `date` > '".mktime(0,0,0,$ddate[1],$ddate[0],$ddate[2])."' AND `date` < '".mktime(23,59,59,$ddate[1],$ddate[0],$ddate[2])."' ;");
				while ($row = mysql_fetch_array($data)) {
					$row['text'] = preg_replace("/id:\((.*)\)/U", "",$row['text']);
					$rr .= date("H:i:s",$row['date']).": {$row['text']}\n<br>";
					echo date("H:i:s",$row['date']).": {$row['text']}<BR>";
				}
			}
			elseif (mktime(0,0,0,$ddate[1],$ddate[0],$ddate[2])<=mktime(0,0,0,12,8,2016))
			{

				//������ � ������ ����
				$rr='';
				//����� �������
				$data = mysql_query("SELECT * FROM oldbk.`new_delo_old2` WHERE `owner` = '{$user['id']}'  AND `sdate` > '".mktime(0,0,0,$ddate[1],$ddate[0],$ddate[2])."' AND `sdate` < '".mktime(23,59,59,$ddate[1],$ddate[0],$ddate[2])."' ;");
				while ($row = mysql_fetch_array($data)) {
					$d_out=get_delo_rec($row,0);
					$rr .= $d_out."\n<br>";
					echo $d_out."<BR>";
				}
			}
			elseif (mktime(0,0,0,$ddate[1],$ddate[0],$ddate[2])<=mktime(23,59,59,4,23,2015))
			{

				//������ � ������ ����
				$rr='';
				//����� �������
				$data = mysql_query("SELECT * FROM oldbk.`new_delo_old` WHERE `owner` = '{$user['id']}'  AND `sdate` > '".mktime(0,0,0,$ddate[1],$ddate[0],$ddate[2])."' AND `sdate` < '".mktime(23,59,59,$ddate[1],$ddate[0],$ddate[2])."' ;");
				while ($row = mysql_fetch_array($data)) {
					$d_out=get_delo_rec($row,0);
					$rr .= $d_out."\n<br>";
					echo $d_out."<BR>";
				}
			}
			else
			{
				$rr='';
				//����� �������
				$data = mysql_query("SELECT * FROM oldbk.`new_delo` WHERE `owner` = '{$user['id']}'  AND `sdate` > '".mktime(0,0,0,$ddate[1],$ddate[0],$ddate[2])."' AND `sdate` < '".mktime(23,59,59,$ddate[1],$ddate[0],$ddate[2])."' ;");
				while ($row = mysql_fetch_array($data)) {
					$d_out=get_delo_rec($row,0);
					$rr .= $d_out."\n<br>";
					echo $d_out."<BR>";
				}

			}

			$rec = array();
			$rec['owner']=$user['id'];
			$rec['owner_login']=$user['login'];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money']-0.5;
			$rec['target']=0;
			$rec['target_login']="�������";
			$rec['type']=236; // ������ �� ����������
			$rec['sum_kr']=0.5;
			add_to_new_delo($rec); //�����

			mysql_query("INSERT INTO oldbk.`inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`)VALUES('{$_SESSION['uid']}','������','50',1,0,'paper100.gif','������� � ��������� �� ��������� \"{$user['login']}\" �� ".$_POST['date'].":\n{$rr}',1,0) ;");
		}
	}
	?>

	<? include_once "end_files.php"; ?>
	</BODY>
	</HTML>
	<?php

/////////////////////////////////////////////////////
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////

	die();
}


if($_GET['effects'])
{
	?>
	<!DOCTYPE html>
	<html>
	<head lang="ru">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title></title>
		<link rel="stylesheet" href="newstyle20.css" type="text/css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="/i/globaljs.js"></script>
		<script type="text/javascript">

			function runmagic1(title, magic, name){

				var el = document.getElementById("hint3");

				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</b></BIG></td></tr><tr><td colspan=2>'+

						'<form action="main.php?edit=1&effects=1" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="00"> <INPUT TYPE=hidden NAME="use" value="'+magic+'">'+

						'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD align=left><INPUT id="'+name+'" TYPE=text NAME="'+name+'">'+

						'</TD><TD width=30><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';

				el.style.visibility = "visible";

				el.style.left = 100 + 'px';

				el.style.top = 100 + 'px';

				document.getElementById(name).focus();

				Hint3Name = name;

			}

			function show(ele) {
				var srcElement = document.getElementById(ele);
				var srcapod= document.getElementById('apod');
				if(srcElement != null) {
					if(srcElement.style.display == "block") {
						srcElement.style.display= 'none';
						srcapod.style.display= 'block';
					}
					else {
						srcElement.style.display='block';
						srcapod.style.display= 'none';
					}
				}
			}

		</script>
		<style>
			tr.spoiler-click {
				cursor: pointer;
			}
			#page-wrapper .table-list tr.spoiler-click:hover th .head-spoiler-btn.b {
				background-image: url("http://i.oldbk.com/i/sostojanie/btt3b.png");
			}
			#page-wrapper .table-list tr.spoiler-click:hover th .head-spoiler-btn.a {
				background-image: url("http://i.oldbk.com/i/sostojanie/btt3.png");
			}
		</style>
	</head>
	<body>
	<div id=hint3 class=ahint style="z-index:500;"></div>
	<?
	//	make_quest_div();
	?>
	<div id="page-wrapper">
		<div class="btn-control">

			<div class="button-mid btn" onClick="location.href='main.php?edit=1&effects=<? echo mt_rand(1111,9999);?>';" >��������</div>
			<div class="button-mid btn" onClick="location.href='main.php?back=<? echo mt_rand(1111,9999);?>';">���������</div>

		</div>
		<?
		$_GET['cancel']=(int)($_GET['cancel']);
		$out_buff='';

		if ($_GET['cancel']==7777) 
		{
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=7777 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"��������� ���������\" - ������!<br>";
			}
		}
		else if ( ($_GET['cancel']>=10901) and ($_GET['cancel']<=10904)) 
		{
			$cncl=$_GET['cancel'];
			$eff = mysql_fetch_assoc(mysql_query("SELECT * FROM effects WHERE type = '{$cncl}' and owner ='{$user['id']}' limit 1;"));
			if ($eff) 
				{
					mysql_query("DELETE from effects  WHERE id='{$eff['id']}' and type = '{$cncl}' and owner ='{$user['id']}' LIMIT 1;");
					if (mysql_affected_rows()>0)
								{
									$out_buff="������ \"{$eff['name']}\" - ������!<br>";
								}	
				}
		}
		else
		if ($_GET['cancel']==150)
		{
			//������� ������ ���� �� ����
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=150 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"���� �����\" - ������!<br>";
			}
		}
		elseif ($_GET['cancel']==555)
		{
			//������� ������ ���� �� ����
			$eff = mysql_fetch_assoc(mysql_query('SELECT * FROM effects WHERE type = 555 and owner = '.$user['id']));
			if ($eff) 
			{
				mysql_query("UPDATE `users` SET `trv`=0 WHERE `id` = '".$eff['owner']."' LIMIT 1;");
				if (mysql_affected_rows()>0) 
				{
					mysql_query("DELETE from effects where owner = ".$user['id']." and type = 555 and id = ".$eff['id']." LIMIT 1;");
					$out_buff="������ \"".($eff['name'])."\" - ������!<br>";
				}				
			}

		}		
		elseif ($_GET['cancel']==102)
		{
			//������� ������ ���� �� ����
			$eff = mysql_fetch_assoc(mysql_query('SELECT * FROM effects WHERE type = 102 and owner = '.$user['id']));
			if ($eff) {
				mysql_query("UPDATE `users` SET `expbonus`=expbonus-'".$eff['add_info']."' WHERE `id` = '".$eff['owner']."' LIMIT 1;");
				if (mysql_affected_rows()>0) {
					mysql_query("DELETE from effects where owner = ".$user['id']." and type = 102 and id = ".$eff['id']." LIMIT 1;");
					$out_buff="������ \"".($eff['add_info']*100)."% �����\" - ������!<br>";
				}				
			}

		}
		elseif ($_GET['cancel']==420420)
		{
			//������� ������ ���� �� ����
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=420420 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"������ ����\" - ������!<br>";
			}
		}
		elseif ($_GET['cancel']==440)
		{
			//������� ������ ���� �� ����
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=440 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"����������� ������\" - ������!<br>";
			}
		}
		elseif ($_GET['cancel']==130)
		{
			//������� ������ ���� �� ����
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=130 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"������ ������\" - ������!<br>";
			}
		}
		elseif ($_GET['cancel']==420)
		{
			//������� ������ ���� �� ����
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=420 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"�������� ����\" - ������!<br>";
			}
		}		
		elseif ($_GET['cancel']==920)
		{
			//������� ������ ���� �� ����
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=920 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"����������� ��\" - ������!<br>";
			}
		}
		elseif ($_GET['cancel']==930)
		{
			//������� ������ ���� �� ����
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=930 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"����������� ��\" - ������!<br>";
			}
		}
		elseif ($_GET['cancel']==160)
		{
			mysql_query("UPDATE effects  set `time`=1 where owner='{$user['id']}' and type=160 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"��������� ����\" - ����� ������ � ������� ������!<br>";
			}
		}		
		elseif ($_GET['cancel']==9100)
		{
			mysql_query("UPDATE effects  set `time`=1 where owner='{$user['id']}' and type=9100 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"���������� ���������� ���������\" - ����� ������ � ������� ������!<br>";
			}
		}		
		elseif  (($_GET['cancel']>=900) AND ($_GET['cancel']<=908) )
		{

			if ($_GET['cancel']==907)
			{
				//������ - ������ ������� ��� ���� ���� ���� ��� ���� ��� ������ - ��� �������� �����
				mysql_query("UPDATE effects  set `time`=1 where owner='{$user['id']}' and type=907 LIMIT 1;");
			}
			else
			{
				mysql_query("DELETE from effects where owner='{$user['id']}' and type=".$_GET['cancel']." LIMIT 1;");
			}

			if (mysql_affected_rows()>0)
			{
				$out_buff="������ \"C����-����������\" - ������!<br>";
			}
		}
		elseif ( (($_GET['cancel']>=9101) AND ($_GET['cancel']<=9107) ) OR ($_GET['cancel']==669) OR ($_GET['cancel']==667) OR ($_GET['cancel']==557) OR ($_GET['cancel']==4999) OR ($_GET['cancel']==5999) OR ($_GET['cancel']==6999)    )
		{
			mysql_query("UPDATE effects  set `time`=1 where owner='{$user['id']}' and type='".(int)($_GET['cancel'])."' LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="������ - ����� ������  � ������� ������!<br>";
			}
		}		
		elseif 	($_GET['cancel']==50000)
		{
			mysql_query("UPDATE effects  set `time`=1 where owner='{$user['id']}' and type=50000 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="\"�������� ����\" - ����� ������� � ������� ������!<br>";
			}
		}
		elseif 	($_GET['cancel']==40000)
		{
		
			mysql_query("DELETE from effects where owner='{$user['id']}' and type=40000 LIMIT 1; ");
			if (mysql_affected_rows()>0)
			{
				$out_buff="\"�������� ������\" - �������!<br>";
				telepost_new($telo,'<font color=red>��������!</font> ���������� �������� ������� <b>��������� �������</b>.');
			}
		}
		elseif 	($_GET['cancel']==30000)
		{
			mysql_query("UPDATE effects  set `time`=1 where owner='{$user['id']}' and type=30000 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="\"�������� ��������\" - ����� ������� � ������� ������!<br>";
			}
		}
		elseif 	($_GET['cancel']==2000)
		{
			mysql_query("UPDATE effects  set `time`=1 where owner='{$user['id']}' and type=2000 LIMIT 1;");
			if (mysql_affected_rows()>0)
			{
				$out_buff="\"�������� ��������\" - ����� ������� � ������� ������!<br>";
			}
		}

		if ($out_buff!='')
		{
			echo '<div class="block-hint"><font color=red><strong>'.$out_buff.'</strong></font></div><br>';
		}

		?>


		<table align="center"  class="table-list sostoyanie" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="280px">
				<col>
				<col width="280px">
			</colgroup>
			<thead>
			<tr class="head-line spoiler-click">
				<th class="center" colspan="7">
					<div class="head-left"></div>
					<div class="head-title"><span>�������</span></div>
					<div class="head-spoiler-btn pointer" data-type="hidden"></div>
					<div class="head-right"></div>
				</th>
			</tr>
			</thead>

			<tbody>

			<?php

			$i = 0;
			include "craft_config.php";
			include "craft_functions.php";

			$prof = GetUserProfData($user);

			$proflist = array(6,12,7,11,8,5,10,13,9);
			


			while(list($v,$k) = each($proflist)) {
				if ($craftlisttype[$k] == 1) continue; // ���������� ���������� �����
				if ($i == 0) {
					echo '
					<tr class="element">
						<td class="row-left">
						</td>
						<td class="row-center">
						<table width="100%" cellpadding=0 cellspacing=0>
						<colgroup>
							<col width="60px">
							<col width="40%">
							<col width="60px">
							<col width="*">
						</colgroup>
						<tr>
					';
				}

				echo '<td style="padding:3px;" valign="top"><img src="http://i.oldbk.com/i/craft/prof'.$k.'.png"></td><td style="padding:3px;" valign="top"><b>'.$craftlistrname[$k].' ['.$prof[$craftlist[$k].'level'].']</b><br>���� '.$prof[$craftlist[$k].'exp'].'/'.$craftexptable[$prof[$craftlist[$k].'level']+1].'<br>';
					
			if ($prof[$craftlist[$k].'level']>0)
				{
				$kproflvl=$prof[$craftlist[$k].'level'];
				switch($k) {
						case 5: // ����� 
								echo "�������������� ����� �� ���: +".(20*$kproflvl)."��";
						break;			 					
				
						case 6:		//������
								
								echo "����� �����: ".(1*$kproflvl)."-".(2*$kproflvl)."";
						break;
						
						case 7: //  ��������� 
								echo "����������� �����: +".round((0.25*$kproflvl),2)."%";
						break;

						case 8: //  �������
								echo "�������� �����: +".round((0.5*$kproflvl),2)."%";
						break;

						case 9: // �������
								echo "��. ������ ����. ������: +".round((20*$kproflvl))."%"; //����� �� ��������: +20 ��������� / ������� �������
						break;

						case 10: // ������ 
								echo "��. ������ ��������.: +".round((20*$kproflvl))."%"; //����� �� �������: + 20 ����������� / ������� ������� 
						break;

						case 11: // �������
								echo "������ �� �����: +".round((2*$kproflvl),2)."%";
						break;						

						case 12: // ��� 
								echo "����� ����������� �����: ".(1*$kproflvl)."-".(2*$kproflvl)."";
						break;			 					


						case 13: // �������
								echo "���� �������� ������ � ���: +".round((2*$kproflvl),2)."%";
						break;			 					
						}
				echo "<br>";		
				}
							
				echo $craftlistdesc[$k];
				echo "<br>";
				echo '</td>';
				
				if ($i == 1) {
					echo '  </tr></table>
						<div class="separate"> </div>
						</td>
						<td class="row-right">
						</td>
						</tr>
					';
				}
				$i++;
				if ($i == 2) $i = 0;
			}

			if ($i == 1) {
					echo '  
						<td></td><td></td>
						</tr></table>
						<div class="separate"> </div>
						</td>
						<td class="row-right">
						</td>
						</tr>
					';
			}

			?>

			</tbody>
			<tfoot>
			<tr class="obraz-footer">
				<td>
					<div class="footer-left"></div>
				</td>
				<td>
					<div class="footer-center"></div>
				</td>
				<td>
					<div class="footer-right"></div>
				</td>
			</tr>
			</tfoot>
		</table>


		<table align="center"  class="table-list sostoyanie" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="280px">
				<col>
				<col width="280px">
			</colgroup>
			<thead>
			<tr class="head-line spoiler-click">
				<th class="center" colspan="7">
					<div class="head-left"></div>
					<div class="head-title"><span>����������</span></div>
					<div class="head-spoiler-btn pointer" data-type="hidden"></div>
					<div class="head-right"></div>
				</th>
			</tr>
			</thead>

			<tbody>
			<?
			$usrp=mysql_fetch_array(mysql_query("select *, DATE_FORMAT(dtime,'%Y-%m-%d') as dday , DATE_FORMAT(NOW(),'%Y-%m-%d') as dnow  from oldbk.users_progress where owner=".$user['id']));
			if ($usrp['owner']==$user['id'])
			{
				//���� ������
				if ($usrp['dnow']!=$usrp['dday'])
				{
					//�� ���������� - ������ ��� ������ � 0, ��� ������ �� ������� � �������� ����� ���������� ������ ���������
					$usrp['dexp']=0;
					$usrp['drep']=0;
					$usrp['dwins']=0;
					$usrp['dlose']=0;
					$usrp['druns']=0;
				}

			}
			?>
			<tr class="element">
				<td class="row-left">
				</td>
				<td class="row-center" align="center">

					<table align="center"  class="table" cellspacing="0" cellpadding="0" border=0 width="600px" style="padding:0px;">
						<colgroup>
							<col width="225px">
							<col width="75px">
							<col width="225px">
							<col width="75px">
						</colgroup>
						<thead>
						<tr class="head">
							<th class="center" colspan="2" align=center>���������� �� �������</th>
							<th class="center" colspan="2" align=center>����� ����������</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td colspan=4 style="padding:5px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element" >
							<td style="padding:10px;">����:</td>
							<?
							if ($user['prem']>=2)
							{
								echo '<td style="padding:10px;"><strong>'.(int)$usrp['dexp'].'</strong>';
							}
							else
							{
								echo "<td style=\"padding:0px;\"><a href=\"http://capitalcity.oldbk.com/bank.php?p=1#akk\"><img src='/images/close_gold.gif' title='��� ������� ��������� Gold account ��� Platinum account' alt='��� ������� ��������� Gold account ��� Platinum account'></a>";
							}
							?></td>

							<td style="padding:10px;">������� �������:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$user['skulls'].'</strong>';
								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element">
							<td style="padding:10px;">���������:</td>
							<?
							if ($user['prem']>=1)
							{
								echo '<td style="padding:10px;"><strong>'.(int)$usrp['drep'].'</strong>';
							}
							else
							{
								echo "<td style=\"padding:0px;\"><a href=\"http://capitalcity.oldbk.com/bank.php?p=1#akk\" ><img src='/images/close_silver.gif' title='��� ������� ��������� Silver account ��� ����' alt='��� ������� ��������� Silver account ��� ����'></a>";
							}
							?></td>
							<td style="padding:10px;">��������������:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$user['voinst'].$mvoin.'</strong>';
								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element" >
							<td style="padding:10px;">������:</td>
							<td style="padding:10px;"><strong><?=(int)$usrp['dwins'];?></strong></td>

							<td style="padding:10px;">����� ���������:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$user['rep'].'</strong>';
								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element">
							<td style="padding:10px;">���������:</td>
							<td style="padding:10px;"><strong><?=(int)$usrp['dlose'];?></strong></td>

							<td style="padding:10px;">����� � ����� ������:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$usrp['awinbs'].'</strong>';
								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element" >
							<td style="padding:10px;">������ ����:</td>
							<td style="padding:10px;"><strong><?=(int)$usrp['druns'];?></strong></td>

							<td style="padding:10px;">����� � ������ �������� �����:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$usrp['awinruins'].'</strong>';
								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>

							<td style="padding:10px;">���� � �������� �����:</td>
							<td style="padding:10px;"><?

								echo '<strong>'.(int)$usrp['abattlehaos'].'</strong>';

								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element" >
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>

							<td style="padding:10px;">������ � �������� �����:</td>
							<td style="padding:10px;"><?

								echo '<strong>'.(int)$usrp['alabcount'].'</strong>';

								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>

							<td style="padding:10px;">������ � ����� �����������:</td>
							<?
							if ($user['prem']>=1)
							{
								echo '<td style="padding:10px;"><strong>'.(int)$usrp['alordcount'].'</strong>';
							}
							else
							{
								echo "<td style=\"padding:0px;\"><a href=\"http://capitalcity.oldbk.com/bank.php?p=1#akk\"><img src='/images/close_silver.gif' title='��� ������� ��������� Silver account ��� ����' alt='��� ������� ��������� Silver account ��� ����'></a>";
							}
							?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>

						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>

							<td style="padding:10px;">���������: ������</td>
							<td style="padding:10px;"><?

								echo '<strong>'.(int)$usrp['ar240count'].'</strong>';

								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>


						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>

							<td style="padding:10px;">���������: ���������</td>
							<?
							if ($user['prem']>=2)
							{
								echo '<td style="padding:10px;"><strong>'.(int)$usrp['ar270count'].'</strong>';
							}
							else
							{
								echo "<td style=\"padding:0px;\"><a href=\"http://capitalcity.oldbk.com/bank.php?p=1#akk\"><img src='/images/close_gold.gif' title='��� ������� ��������� Gold account ��� Platinum account' alt='��� ������� ��������� Gold account ��� Platinum account'></a>";
							}
							?></td>
						</tr>

						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>


						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>
							<td style="padding:10px;">������: ��������</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$usrp['aquestzag'].'</strong>';
							?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>



						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>
							<td style="padding:10px;">����� � ������� ���������:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$user['winstbat'].'</strong>';
								?></td>
						</tr>
						<tr>
						<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						

						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>
							<td style="padding:10px;">����� � ������� ���������:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$user['elkbat'].'</strong>';
								?></td>
						</tr>
						<tr class="element">
							<td style="padding:10px;"> </td>
							<td style="padding:10px;"> </td>
							<td style="padding:10px;">��� �� �������:</td>
							<td style="padding:10px;"><?
								echo '<strong>'.(int)$user['buketbat'].'</strong>';
								?></td>
						</tr>
						<tr>
							<td colspan=4 style="padding:0px;"><div class="separate" style="left:-20px"> </div></td>
						</tr>
						</tbody>
					</table>
				</td>
				<td class="row-right">
				</td>
			</tr>
			</tbody>
			<tfoot>
			<tr class="obraz-footer">
				<td>
					<div class="footer-left"></div>
				</td>
				<td>
					<div class="footer-center"></div>
				</td>
				<td>
					<div class="footer-right"></div>
				</td>
			</tr>
			</tfoot>
		</table>



		<table align="center"  class="table-list sostoyanie" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="280px">
				<col>
				<col width="280px">
			</colgroup>
			<thead>
			<tr class="head-line spoiler-click">
				<th class="center" colspan="7">
					<div class="head-left"></div>
					<div class="head-title"><span>�����������</span></div>
					<div class="head-spoiler-btn pointer" data-type="hidden"></div>
					<div class="head-right"></div>
				</th>
			</tr>
			</thead>
			<tbody>
			<?
			/*
			$deflim=100;
			$litstr=100;
			$prevods=mysql_fetch_array(mysql_query("select * from oldbk.users_perevod where owner=".$user['id']));

			if (($prevods['owner']==$user['id']) and ($prevods['lim']==-1) )
			{
				$litstr="��� �����������";
				$valstr='';
			}
			elseif (($prevods['owner']==$user['id']) and ($prevods['lday']==date("Y-m-d") ) )
			{
				$litstr=$prevods['lim'];
				$valstr=(int)($prevods['val']);
			}
			elseif (($prevods['owner']==$user['id'])  )
			{
				$litstr=$prevods['lim'];
				$valstr=0;
			}
			else
			{
				$valstr=0;
			}
			
			echo '<tr class="element">
				<td class="row-left">
					����� �� ��������
				</td>
				<td class="row-center">
					�� ����� �� ������ ��������� <strong>'.$litstr.'</strong> �������, ��� ���������� ������ ������ <strong>�������� ��������</strong>.
				</td>
				<td class="row-right">
					��������� �������: <strong>'.$valstr.'</strong>
				</td>
			</tr>';
			*/
			
			
			
				echo '
								 <tr class="separate">
								                <td class="row-left">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-center">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-right">
								                    <div class="separate"></div>
								                </td>
								            </tr>
							<tr class="element">
							                <td class="row-left">
							                   <a href="http://oldbk.com/encicl/rastilka.html" target=_blank>���������: ��������</a><br><img src="http://i.oldbk.com/i/city/sub/cap_rist_solo.png" height="30px" >
							                </td>
							                <td class="row-center">
							                ��� ��������� <strong>��������� ��������</strong> �� ��������� ���������� ��������� �����, ��������� ������� ����� ��� ������ �<a href="http://oldbk.com/encicl/?/mag1/scrol_rist20.html" target=_blank>������� ��������� -20%</a>� 
							                </td>
						                	<td class="row-right">';
						
						$ristef = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND type=8270 ;"));		                
						if ($ristef['id']>0)
								{
								echo ' ��������  <strong>'.prettyTime(null,$ristef['time']).'</strong>';
								}
								else
								{
								echo  '<font color=green><strong>��������</strong></font>';
								}
						                	
							   echo '</td>
							            </tr>';
			
			
			
			$hlim=10;
			$testrist=mysql_fetch_array(mysql_query("select * from oldbk.ristalka where owner=".$user['id']));
			$testrist['chaos']=(int)($testrist['chaos']);
			if ($hlim>$testrist['chaos'])
			{
				//�������� ������
				$ef = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND type=9105 ;"));
				if ($ef[id]>0)
				{
					$hlim=(int)($hlim-($hlim*$ef[add_info]));
				}

			}


				echo '
								 <tr class="separate">
								                <td class="row-left">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-center">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-right">
								                    <div class="separate"></div>
								                </td>
								            </tr>
							<tr class="element">
							                <td class="row-left"><a href="http://oldbk.com/encicl/rastilka.html" target=_blank>���������: ������</a><br><img src="http://i.oldbk.com/i/city/sub/cap_rist_monstr.png" height="30px" ></td>
							                <td class="row-center">��� ��������� <strong>��������� ��������</strong> �� ��������� ���������� <strong>'.$hlim.' ����</strong>, ��������� ���������� ����� ��� ������ �<a href="http://oldbk.com/encicl/?/mag1/scrol_rist20.html" target=_blank>������� ��������� -20%</a>�
							                </td>
						                	<td class="row-right">';
								if ($testrist['chaos']<$hlim)
								{						                	
						                echo '��������:<strong>'.($hlim-$testrist['chaos']).' ����.</strong>';
						                }
						                else
						                {
								echo  '<font color=green><strong>��������</strong></font>';						                
						                }
				echo '				</td>
							            </tr>';
			
			
			
			//�������� ���� - ���� ��� �� ����� ������
			if ($user['lab']==0)
			{
				$labc=mysql_fetch_array(mysql_query("select * from oldbk.`labirint_var` where  `var`= 'labstarttime' and `owner`='".$user['id']."';"));
				$regulyator=72000;//20 �����

				$LAB_BONUS_TIME = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}'  and `type` = '9104' LIMIT 1;"));

				if ($LAB_BONUS_TIME['id']>0)
				{
					$regulyator-=(int)($regulyator*$LAB_BONUS_TIME['add_info']);
				}

				$time_lan_ok=false;
				if ((($labc['val']+$regulyator) > time()  ) and ($labc['val']>0))
				{
					$H=floor(($regulyator -(time()- $labc['val']))/60/60);
					$M=round( (($regulyator -(time()-$labc['val']))/60) - ($H*60) );
				}
				else
					{
					$time_lan_ok=true;
					}
					
					$lab_need_bat=10;
					if (($user['level']>=4) and ($user['level']<=6) ) { $lab_need_bat=5; }

					$lab_battle_ok=false;
					$okneedbattle=0;					
					//$testrist=mysql_fetch_array(mysql_query("select * from oldbk.ristalka where owner={$user['id']}"));
					if (($testrist['chaos']<$lab_need_bat) and ($testrist['labp']==0) )
					{
				
					$okneedbattle=($lab_need_bat-$testrist['chaos']);
					}
					else
						{
						$lab_battle_ok=true;
						}
					
					
					if ($okneedbattle<0) { $okneedbattle=0; }
					
					echo '
								 <tr class="separate">
								                <td class="row-left">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-center">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-right">
								                    <div class="separate"></div>
								                </td>
								            </tr>
							<tr class="element">
							                <td class="row-left"><a href="http://oldbk.com/encicl/labchaos.html" target=_blank>�������� �����</a><br><img src="http://i.oldbk.com/i/city/sub/lab_png.png" height="30px" ></td>
							                <td class="row-center">��� ��������� ������� <strong>�������� �����</strong> ���������� <strong>'.$lab_need_bat.' ����</strong> � ��������� �����, ��������� ���������� ����� ��� ������ �<a href="http://oldbk.com/encicl/?/mag1/scrol_lab20.html" target=_blank>������� ��������� ����� -20%</a>�</td>
						                	<td class="row-right">';
						        if (($time_lan_ok==true) AND ($lab_battle_ok==true)) 
						        {
							echo  '<font color=green><strong>��������</strong></font>';
						        }
						        else
						        {
							echo  '��������: <strong>'.$okneedbattle.' ����</strong>';
							echo ', <strong>'.(int)$H.' �. '.(int)$M.' ���.</strong>';
							}
					echo '		                </td>
							            </tr>';


				
			}


			//�������� �����
			if ($user['ruines']==0)
			{
					echo '
								 <tr class="separate">
								                <td class="row-left">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-center">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-right">
								                    <div class="separate"></div>
								                </td>
								            </tr>
							<tr class="element">
							                <td class="row-left">
							                <a href="http://oldbk.com/encicl/ruins.html" target=_blank>����� ������� �����</a><br><img src="http://i.oldbk.com/i/city/sub/ruins_png.png" height="30px" ></td>
							                <td class="row-center">��� ��������� <strong>���� ������� �����</strong> ���������� ��������� �����, ��������� ������� ����� ��� ������ �<a href="http://oldbk.com/encicl/?/mag1/scrol_zam20.html" target=_blank>������� ����� ������� ����� -20%</a>�
							                </td>
						                	<td class="row-right">';
						        
				$q = mysql_query('SELECT * FROM `ruines_var` WHERE `owner` = '.$user['id'].' AND var = "cango" AND val > '.time()) or die();
				if (mysql_num_rows($q) > 0)
				{
					// ���� ��
					$kd = mysql_fetch_assoc($q) or die();
					$H = floor(($kd['val']-time())/60/60);
					$M = round((($kd['val']-time())/60) - ($H*60));
			              echo '��������:<strong>'.$H.' �. '.$M.' ���.</strong>';					
				}						        
				else
					{
					echo  '<font color=green><strong>��������</strong></font>';						                												
					}
				
							      echo '</td>
							            </tr>';
			}
			
				echo '
								 <tr class="separate">
								                <td class="row-left">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-center">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-right">
								                    <div class="separate"></div>
								                </td>
								            </tr>
							<tr class="element">
							                <td class="row-left"><a href="http://oldbk.com/encicl/park.html" target=_blank>������� ��������</a><br><img src="http://i.oldbk.com/i/city/sub/cap_gate.png" height="30px" ></td>
							                <td class="row-center">
							                 �� ��������� ������ ������� � <strong>��������</strong> ���������� ��������� �����, ��������� ������� ����� ��� ������ �<a href="http://oldbk.com/encicl/?/mag1/scrol_zag20.html" target=_blank>������� ������ � �������� -20%</a>�
							                </td>
						                	<td class="row-right">';
						          
						$q = mysql_query('SELECT * FROM oldbk.`map_var` WHERE `owner` = '.$user['id'].' AND var = "cango" AND val > '.time()) or die();
						if (mysql_num_rows($q) > 0)
						{
							// ���� ��
							$kd = mysql_fetch_assoc($q) or die();
							$H = floor(($kd['val']-time())/60/60);
							$M = round((($kd['val']-time())/60) - ($H*60));
							echo ' ��������:<strong>'.$H.' �. '.$M.' ���.</strong>';							
						}						          
						else
							{
							echo  '<font color=green><strong>��������</strong></font>';						                							
							}
						          
						                	

							echo ' </td>
							            </tr>';

			

			// �������� ������ �� ������� ����� �������
			$q = mysql_query('SELECT * FROM oldbk.map_qvar WHERE owner = "'.$user['id'].'" and var = "lastcity"');
			if (mysql_num_rows($q) > 0) {
				$lastcity = mysql_fetch_assoc($q) or die();
				$t = explode(":",$lastcity['val']);
				if ($t[0] > time()) {
					$H = floor(($t[0]-time())/60/60);
					$M = round((($t[0]-time())/60) - ($H*60));
					$ccc = array(0 => "AvalonCity", 1 => "CapitalCity");
					echo '
									 <tr class="separate">
									                <td class="row-left">
									                    <div class="separate"></div>
									                </td>
									                <td class="row-center">
									                    <div class="separate"></div>
									                </td>
									                <td class="row-right">
									                    <div class="separate"></div>
									                </td>
									            </tr>
								<tr class="element">
								                <td class="row-left">
								                    �������
								                </td>
								                <td class="row-center">
								                ������� ����� ������� � '.$ccc[$t[1]].'
								                </td>
							                	<td class="row-right">
							                	 �����:<strong>'.$H.' �. '.$M.' ���.</strong>
								                </td>
								            </tr>';

				}
			}
			
			//��������� �����
			
					echo '
								 <tr class="separate">
								                <td class="row-left">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-center">
								                    <div class="separate"></div>
								                </td>
								                <td class="row-right">
								                    <div class="separate"></div>
								                </td>
								            </tr>
							<tr class="element">
							                <td class="row-left">
							                <a href="#">����� ����� �����������</a><br><img src="http://i.oldbk.com/i/city/sub/lord_castle2.png" height="30px" ></td>
							                <td class="row-center">��� ��������� <strong>����� ����� ����������� </strong> ���������� ��������� �����. 
							                ����������� �<a href="https://oldbk.com/encicl/predmeti/propusk_lordraz5.html" target=_blank>������� � ����� �����������</a>�, ����� ������ ��������� ����� ��������.
							                </td>
						                	<td class="row-right">';
						        
				$q = mysql_query('SELECT * FROM `lord_var` WHERE `owner` = '.$user['id'].' AND var = "cango" AND val = '.mktime(0,0,0)) or die();
				if (mysql_num_rows($q) > 0)
				{
					// ���� ��
					$kd = mysql_fetch_assoc($q) or die();
					$H = floor((mktime(23,59,59)-time())/60/60);
					$M = round(((mktime(23,59,59)-time())/60) - ($H*60));
			              echo '��������:<strong>'.$H.' �. '.$M.' ���.</strong>';					
				}						        
				else
					{
					echo  '<font color=green><strong>��������</strong></font>';						                												
					}
				
							      echo '</td>
							            </tr>';
			
			
			

			?>
			</tbody>
			<tfoot>
			<tr class="obraz-footer">
				<td>
					<div class="footer-left"></div>
				</td>
				<td>
					<div class="footer-center"></div>
				</td>
				<td>
					<div class="footer-right"></div>
				</td>
			</tr>
			</tfoot>
		</table>

		<table align="center" class="table-list sostoyanie" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="280px">
				<col>
				<col width="280px">
			</colgroup>
			<thead>
			<tr class="head-line spoiler-click">
				<th class="center" colspan="7">
					<div class="head-left"></div>
					<div class="head-title"><span>�������</span></div>
					<div class="head-spoiler-btn pointer" data-type="hidden"></div>
					<div class="head-right"></div>
				</th>
			</tr>
			</thead>
			<tbody>
			<?
			//������ �� �����
			
			/*
����� �������:

     �������� ������� 30����, ������ ���������������� http://i.oldbk.com/i/city/sub/altr_g.png
     ��� ��� ������� ������ ������ ������ ����� �����


������� �������:

     ������� 1� ������: ������ �� ��������� ����������: 50%. 
     ������� 2� ������: ��������� >>>   - ������ � ����� �� ����� � ����� ���� http://oldbk.com/encicl/arena.html


������ ������� �������:

     ������ ������� ������� ������ � ��.��.��., ���� � ������� ������ ��� 24 ���� ��� �����. ������: �������� 1 �. 10 �. 14 ���.
     ������ ������� ������� ������ � ��.��., ���� � ������� ������ ��� 24 ����. ������: �������� 10 �. 14 ���.
     ������ ������� ������� ������ � ��., ���� � ������� ������ 60 �����. ������: �������� 14 ���.			
			*/

			$q = mysql_query('SELECT * FROM craft_job WHERE owner = '.$user['id'].' and status = 1');
			if (mysql_num_rows($q) > 0) {
				$cs = mysql_fetch_assoc($q);
				$rc = mysql_query('SELECT * FROM craft_formula WHERE craftid = '.$cs['rcid']);
				if (mysql_num_rows($rc)) {
					$rc = mysql_fetch_assoc($rc);

					$all = $cs['itemcount']*$cs['crafttime']*60;
					$left = (((($cs['itemleft'])*$cs['crafttime'])*60)+$cs['craftlefttime']);
					
					echo  render_sost_row('<img width=30 height=30 src="http://i.oldbk.com/i/craft/prof'.$rc['craftgetprof'].'.png"><br><strong>'.$craftlistrname[$rc['craftgetprof']].'</strong>','������������ <b>�'.$cs['itemname'].'�</b> � ���������� '.($cs['itemleft']+1).' ��. ','�������� <strong>'.prettyTime(null,time()+$left).'</strong>');
				}
			
			}

			$get_bonus_items=mysql_fetch_array(mysql_query("select count(item_id) as kol, finish from bonus_items where owner='{$user['id']}' and finish> UNIX_TIMESTAMP()   group by owner"));
			if ($get_bonus_items['kol']>0)
				{
				echo  render_sost_row('<img src="http://i.oldbk.com/i/city/sub/altr_g.png" height="30px" ><br><strong>����� ����� �����</strong>','������ �� ��������� ���������� ('.$get_bonus_items['kol'].' ���������) : 50%.<br>
                            				<a href="http://oldbk.com/encicl/arena.html" target=_blank>��������� &gt;&gt;&gt;</a>','�������� <strong>'.prettyTime(null,$get_bonus_items['finish']).'</strong>');
                            	}


			$eff=array();
			$i=0;
			$user_prof=GetUserProfLevels($user);
			
			$cheff=mysql_query("SELECT * from  `effects` WHERE owner = '".$user['id']."' order by time");
			while($row=mysql_fetch_array($cheff)) 
			{
				if ($row['type']==8270) continue; // ���������� - ������������ � ������������

				$eff[$i]=$row;
				if (($eff[$i]['time']-time()) < 0) { $eff[$i]['time']=time()+2; }
				$i++;

				if ($row['type']==9104)	{
					$LAB_BONUS_TIME=$row['add_info'];
				} elseif (($row['type']==10901) OR ($row['type']==10902) OR ($row['type']==10903) OR ($row['type']==10904)) {
					$usr_eff_sti[$row['type']]=$row;
				}
			}
			for($i=0;$i<count($eff);$i++) 
			{
				if($user['prem']==1 && $eff[$i]['type']==4999) {
				
				if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">����������</a>';
					} else {
						$offvar='&nbsp;';
					}
				
					echo  render_sost_row('<a href=https://oldbk.com/encicl/prem.html target=_blank><img border=0 src=http://i.oldbk.com/i/036.gif></a><br><strong>Silver account</strong>','
                            				&nbsp;&nbsp;&nbsp- ���������� ���� +10%<br>
                            				&nbsp;&nbsp;&nbsp- ���������� ��������� +10%<br>
                            				&nbsp;&nbsp;&nbsp- ���������� ������ �������� +10%<br>
                            				&nbsp;&nbsp;&nbsp- ����� ���������� ������� +50<br>
                            				&nbsp;&nbsp;&nbsp- ������ �� ������� ���������� +5%<br>
                            				&nbsp;&nbsp;&nbsp- ����������  "��������" +500 <br>
                            				����� �������� ����� ������������ <a href="https://oldbk.com/encicl/prem.html" target=_blank>�����</a>','�������� <strong> '. (round((($eff[$i]['time']-time())/60/60/24),1)).'</strong> ����.'.$offvar);
				} elseif($user['prem']==2 && $eff[$i]['type']==5999) {
				
				if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">����������</a>';
					} else {
						$offvar='&nbsp;';
					}				
				
					echo  render_sost_row('<a href=https://oldbk.com/encicl/prem.html target=_blank><img border=0 src=http://i.oldbk.com/i/037.gif></a><br><b>Gold account</b>','
                            				&nbsp;&nbsp;&nbsp;- ���������� ���� +15%<br>
                            				&nbsp;&nbsp;&nbsp;- ���������� ��������� +10%<br>
                            				&nbsp;&nbsp;&nbsp;- ���������� ������ �������� +15%<br>
                            				&nbsp;&nbsp;&nbsp;- ����� ���������� ������� +250<br>
                            				&nbsp;&nbsp;&nbsp;- ������ �� ������� ���������� +10%<br>
                            				&nbsp;&nbsp;&nbsp;- ����������  "��������" +1000 <br>
                            				����� �������� ����� ������������ <a href="https://oldbk.com/encicl/prem.html" target=_blank>�����</a>','
                            				�������� <strong>'. (round((($eff[$i]['time']-time())/60/60/24),1)).'</strong> ����.'.$offvar);
				} elseif($user['prem']==3 && $eff[$i]['type']==6999) {
				
				if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">����������</a>';
					} else {
						$offvar='&nbsp;';
					}				
				
					echo  render_sost_row('<a href=https://oldbk.com/encicl/prem.html target=_blank><img border=0 src=http://i.oldbk.com/i/137.gif></a> <br><b>Platinum account</b>','
                            				&nbsp;&nbsp;&nbsp;- ���������� ���� +20%<br>
                            				&nbsp;&nbsp;&nbsp;- ���������� ��������� +10%<br>
                            				&nbsp;&nbsp;&nbsp;- ���������� ������ �������� +20%<br>
                            				&nbsp;&nbsp;&nbsp;- ����� ���������� ������� +500<br>
                            				&nbsp;&nbsp;&nbsp;- ������ �� ������� ���������� +15%<br>
                            				&nbsp;&nbsp;&nbsp;- ����������  "��������" +1500 <br>
                            				����� �������� ����� ������������ <a href="https://oldbk.com/encicl/prem.html" target=_blank>�����</a>','
                            				�������� <strong> '. (round((($eff[$i]['time']-time())/60/60/24),1)).'</strong> ����.'.$offvar);
				} elseif($eff[$i]['type']==4200) {
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/scroll_speed1_2.gif><br>��������� ��������','����������� � 2 ���� �������� ������������ � ��������, ������ ������������ ��� ��������� ������������.','�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong>');
				} elseif($eff[$i]['type']==4201) {
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/scroll_status1_2.gif><br>���������� ������','������, ������� ������������ � ���������� � ���������','�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong><br><a href="?unikoff=1&effects=1">�������� ������</a>');
				} elseif($eff[$i]['type']==5001) {
					echo  render_sost_row('<img src=http://i.oldbk.com/i/magic/skl_timeout.gif><br>����� ����������','����� <img src=http://i.oldbk.com/i/align_'.$eff[$i]['add_info'].'.gif>','�������� <strong>'. (round((($eff[$i]['time']-time())/60/60/24),1)).'</strong> ����.');
				} elseif($eff[$i]['type']==420) {
					$kr=(int)($eff[$i]['add_info']*100);
					$ksimg[5]='http://i.oldbk.com/i/sh/bigscroll_stoneskin_2.gif';
					$ksimg[10]='http://i.oldbk.com/i/sh/bigscroll_stoneskin_2.gif';					
					$ksimg[15]='http://i.oldbk.com/i/sh/bigscroll_stoneskin_2.gif';					
					$ksimg=$ksimg[$kr];
					
					if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">����������</a>';
					} else {
						$offvar='&nbsp;';
					}	
					
					echo  render_sost_row('<img src='.$ksimg.' alt=""><br>������ �'.$eff[$i]['name'].'�','<STRONG>��������� � ��� '.$kr.'% �� ����������� �����</STRONG>','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong>'.$offvar);
				} elseif($eff[$i]['type']==7777) 
				{
					echo  render_sost_row('<img src="http://i.oldbk.com/i/sh/labinsurance0_2.gif" alt="��������� ���������" title="��������� ���������"><br>������ �'.$eff[$i]['name'].'�','<STRONG>� ������ ����� ������ � ����������� ���������, ����� � ������ ����� ������ ��������� ������ � �� ������� ������������� ���� � ������� ���������� 
					�<a href="http://oldbk.com/encicl/?/mag2/labteleport.html" target=_blank>�������� ���������</a>�</STRONG>','<br><a href="?cancel=7777&effects=1">����������</a>');
				}
				elseif($eff[$i]['type']==9100) {
					
					$pr=explode(":",$eff[$i]['add_info']);
					$kr_a=(int)($pr[1]*100);
					
					$ksimg='http://i.oldbk.com/i/sh/'.$pr[0];

					if ($eff[$i]['time']-2>time()) {
						$cncl_repli='<br> <a href=main.php?effects=1&cancel=9100>��������</a>';					
					} else {
						$cncl_repli='';
					}
					echo  render_sost_row('<img src='.$ksimg.' alt=""><br>��������� +'.$kr_a.'%','<STRONG>��������� +'.$kr_a.'% � ���������� ���������.</STRONG>','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong>'.$cncl_repli);
				} elseif($eff[$i]['type']==440) {
					$pr=explode(":",$eff[$i]['add_info']);

					$kr_a=(int)($pr[1]*100);
					$kr_b=(int)($pr[2]*100);					
					$ksimg='http://i.oldbk.com/i/sh/'.$pr[0];

					echo  render_sost_row('<img src='.$ksimg.' alt=""><br>������ �'.$eff[$i]['name'].'�','<STRONG>����������� ����������� � ������������ ���� �� '.$kr_a.'%, ��� ���� �������� ���������� � ����� �� '.$kr_b.'%.</STRONG>','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong><br><a href="main.php?effects=1&cancel=440">����������</a>');
				} elseif($eff[$i]['type']==111010) {
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/card1_koloda.gif><br>��������� ������ ���������','<STRONG>��������� ��������� ���� ����� ���������� ������ � �������� ��������� � �������� 20% </STRONG>','�������� <strong>'. prettyTime(null,$eff[$i]['time']).'</strong>');
				}  elseif($eff[$i]['type']==112010) {
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/cards2_kl3oia_coloda.gif><br>��������� ����������� ��������','<STRONG>��������� ��������� ������� ��� ������� <a href="http://oldbk.com/encicl/?/eda/angel_blagocard.html" target="_blank">����������� ����������</a>, ������ �������� 7 ����. </STRONG>','�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong>');
				}
				elseif($eff[$i]['type']==113010) {
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/coloda_winter.gif><br>��������� ��������','<STRONG>��������� ��������� ���� ����������� �������� ��� � ����� �������� ��� </STRONG>','�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong>.');
				} elseif($eff[$i]['type']==110110) {
					require_once "castles_functions.php";
					echo  render_sost_row('����������� �������� � ���� '.CGetClan2($eff[$i]['add_info']).' ','<a href="?approveklan='.$eff[$i]['id'].'&effects=1">�������</a> <a href="?rejectklan='.$eff[$i]['id'].'&effects=1">��������</a> ','�������� <strong>'. (round((($eff[$i]['time']-time())/60/60/24),1)).'</strong> ����.');
				} elseif($eff[$i]['type']==11 || $eff[$i]['type']==12 || $eff[$i]['type']==13 || $eff[$i]['type']==14) {
					switch($eff[$i]['type']) {
						case 14: $trt = "�����������"; break;
						case 13: $trt = "�������"; break;
						case 12: $trt = "�������"; break;
						case 11: $trt = "������"; break;
						default: $trt = ""; break;
					}
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/travma.gif" width=40><br><strong>'.$trt.'</strong> ������',' '.($eff[$i]['sila']?'���� -'.$eff[$i]['sila']:'').($eff[$i]['lovk']?'�������� -'.$eff[$i]['lovk']:'').($eff[$i]['inta']?'�������� -'.$eff[$i]['inta']:'').' ','�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong>');
				} elseif ($eff[$i]['type'] == 2) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/sleep.gif" width=40><br>�������� ��������.',' <strong>��� ����������� ������ � ���</strong> ', '�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong>');
				} elseif ( ($eff[$i]['type'] == 10) and ( floor(($eff[$i]['time']-time())/60/60) > 100 ) ) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/chains.gif" width=40><br>����� � ������','��� ����������� ���������.',' ');
				} elseif ($eff[$i]['type'] == 10) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/chains.gif" width=40><br>����.','�� ������ ���������',' �������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong>');
				} elseif ($eff[$i]['type'] == 3) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/sleepf.gif" width=40><br>�������� ��������� ��������',' ��� ����������� ������ �� ������.','�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong>');
				} elseif ($eff[$i]['type'] == 33) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/snezhok.gif" width=40><br>�������� �����������',' �������� ����� :) ',' �������� <strong> '.prettyTime(null,$eff[$i]['time']).'</strong>');
				} elseif (($eff[$i]['type']==1001) OR ($eff[$i]['type']==1002) OR ($eff[$i]['type']==1003)) {
					$ef1001img="http://i.oldbk.com/i/magic/bonus2.gif";
					$efexp='';
					if ($eff[$i]['add_info']!='') {
						$ef1001img="http://i.oldbk.com/i/magic/vduh.gif";
						$efexp=', ����: <b>+'.round($eff[$i]['add_info']*100).'%</b>';
						$IHAVE_VDUH=$eff[$i]['type'];
					}
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/act_duh_spring.html" target=_blank><IMG height=25 src="'.$ef1001img.'" width=40></a><br>�������� ��������:'.$eff[$i]['name'].' ','(+'.$user['bpbonushp'].'HP) '.$efexp.' ',' �������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong>');
				} elseif ($eff[$i]['type']==2025) {
					echo  render_sost_row($eff[$i]['name'].' ','���� ��������� ������� ����� �������� �� 25%',' �������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong>');
				} elseif ( $eff[$i]['type']==4997) {
					echo  render_sost_row('�������� ��������:'.$eff[$i]['name'].' ','(+'.($eff[$i]['add_info']*100).' %) ',' �������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong>');
				} elseif ( ( $eff[$i]['type']==8210) OR ( $eff[$i]['type']==8240) OR ( $eff[$i]['type']==8270)) {
					echo  render_sost_row($eff[$i]['name'].' ',' ����������� ',' ����� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong>');
				} elseif ($eff[$i]['type'] == 222) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/haos_vamp1.gif" width=40><br>���� ������������ �����','&nbsp','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif ($eff[$i]['type'] == 830) {
					$get_align=(int)($user['align']);
					if ($get_align==1) {$get_align=6;}
					echo  render_sost_row('<IMG height=25 src="http://capitalcity.oldbk.com/i/magic/'.$get_align.'n5.jpg" width=40><br>���������','&nbsp','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="?medoff=1&effects=1">���������� ���������</a>');
				} elseif ($eff[$i]['type'] == 200) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/hidden.gif" width=40><br>�����������','&nbsp','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="?hiddenoff=1&effects=1">�������� �������</a>');
				} elseif ($eff[$i]['type'] == 301) {
					echo  render_sost_row($eff[$i]['name'],$eff[$i]['name'],'�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="?carnavaloff=1&effects=1">�������� �������</a>');
				} elseif ($eff[$i]['type'] == 302) {
					echo  render_sost_row($eff[$i]['name'],$eff[$i]['name'],'<strong>�� ���</strong><br><a href="?carnavaloff2=1&effects=1">�������� �������</a>');
				} elseif ($eff[$i]['type'] == 9999) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/sh/shout.gif" width=40><br>��������� �����','��������� ����� � <b>'.$eff[$i]['add_info'].'</b>','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif ($eff[$i]['type'] == 826) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/2n1.jpg" width=40><br>'.$eff[$i]['name'].'','���������:+'.$eff[$i]['intel'].'','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif ($eff[$i]['type'] == 827) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/2n1.jpg" width=40><br>'.$eff[$i]['name'].'','&nbsp','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif ($eff[$i]['type'] == 1111) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/illusion.gif" width=40><br>��������������','&nbsp','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="?illusionoff=1&effects=1">�������� �������</a>');
				} elseif ($eff[$i]['type'] == 555) 
				{
					if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">����������</a>';
					} else {
						$offvar='&nbsp;';
					}
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/sh/no_cure3_2.gif" width=40><br>������ �� �����','������ �� ��������� ������','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif ($eff[$i]['type'] == 556) {
					echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/no_cure2.gif" width=40><br>������ �� �����','������ �� ��������� ������','<strong>�� ��������� ���������� ���</strong>');
				} elseif ($eff[$i]['type'] == 557) {
					if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">����������</a>';
					} else {
						$offvar='&nbsp;';
					}
																							
					if ($eff[$i]['add_info'] == 0.7) {
						echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/sh/scroll_antimagic1_2.gif" width=40><br>������ �� ����� ������','������ �� ����������� ����� �� 30%','<strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
					} elseif ($eff[$i]['add_info'] == 0.5) {
						echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/sh/scroll_antimagic2_2.gif" width=40><br>������ �� ����� ������','������ �� ����������� ����� �� 50%','<strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
					} elseif ($eff[$i]['add_info'] == 0.3) {
						echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/sh/scroll_antimagic3_2.gif" width=40><br>������ �� ����� ������','������ �� ����������� ����� �� 70%','<strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
					} elseif ($eff[$i]['add_info'] == 0.85) {
						echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/sh/scroll_antimagic0_2.gif" width=40><br>������ �� ����� ������','������ �� ����������� ����� �� 15%','<strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
					} else {
						echo  render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/no_cure2.gif" width=40><br>������ �� ����� ������','������ �� ����������� ����� �� '.(int)($eff[$i]['add_info']*100).'%','<strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
					}
				} elseif ($eff[$i]['type'] == 102) {
					if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">��������</a>';
					} else {
						$offvar='&nbsp;';
					}
					echo  render_sost_row('<img src=http://i.oldbk.com/i/magic/add_exp.gif><br>���� +100%','&nbsp','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong> '.$offvar);
				} elseif ($eff[$i]['type'] == 605) {
					echo  render_sost_row('"'.$eff[$i]['name'].'"','���������� ������������','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif ($eff[$i]['type'] == 667) {
					if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">��������</a>';
					} else {
						$offvar='&nbsp;';
					}
					echo  render_sost_row('<img src=http://i.oldbk.com/i/magic/ruin_stoikost2.gif><br> "'.$eff[$i]['name'].'"','���� +10%','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif ($eff[$i]['type'] == 20) {
					echo  render_sost_row('<img src=http://i.oldbk.com/i/magic/check.gif><br> '.$eff[$i]['name'].'','"'.$eff[$i]['name'].'"','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif ($eff[$i]['type'] == 10901) {
					$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">��������</a>';
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/wrath_ares.gif><br>'.$eff[$i]['name'],'���� ����������� ������������ ������ �� ������ ������ ���� - <strong>������ 100% ��������</strong>.','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif ($eff[$i]['type'] == 10902) {
					$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">��������</a>';
					echo  render_sost_row('<img src=http://i.oldbk.com/i/magic/wrath_ground_status.gif><br>'.$eff[$i]['name'],'���� ����������� ������������ ������ �� ������ ������ ����� - <strong>������ 100% ��������</strong>.','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif ($eff[$i]['type'] == 10903) {
					$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">��������</a>';
					echo  render_sost_row('<img src=http://i.oldbk.com/i/magic/wrath_air_status.gif><br>'.$eff[$i]['name'],'���� ����������� ������������ ������ �� ������ ������ ������� - <strong>������ 100% ��������</strong>.','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif ($eff[$i]['type'] == 10904) {
					$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">��������</a>';
					echo  render_sost_row('<img src=http://i.oldbk.com/i/magic/wrath_water_status.gif><br>'.$eff[$i]['name'],'���� ����������� ������������ ������ �� ������ ������ ���� - <strong>������ 100% ��������</strong>.','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif ($eff[$i]['type'] == 150) {
					//������� ��� ������ ����� ��� ���������� �� ����� . �������� ���� ������ 3� ������ �������� ��� ������ �� ������
					if (($eff[$i]['lastup']>0) AND ($user['mfire']<3)) { $user['mfire']=(int)($eff[$i]['lastup']); }

					if ($user['mfire']>100) { $usermfire=100; } else { $usermfire=$user['mfire'];}

					if ($usermfire>0) {
						if ($user['mudra']>50) {
							$user_mudra=50;
						} else {
							$user_mudra=$user['mudra'];
						}
                                                $txt_min_150=$user_mudra+$usermfire;

						$vl=explode(":",$eff[$i]['add_info']);
						$eff[$i]['add_info']=$vl[1];
						$txt_max_150=((int)($eff[$i]['add_info'])*$usermfire);
					} else {
						$txt_min_150=1;
						$txt_max_150=1;
					}

					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$txt_min_150+=(1*$user_prof['magelevel']);
						$txt_max_150+=(2*$user_prof['magelevel']);
						}

					if ($txt_min_150>1000) {$txt_min_150=1000;}
					if ($txt_max_150>1000) {$txt_max_150=1000;}


					if ($txt_min_150<1) {$txt_min_150=1;}
					if ($txt_max_150<1) {$txt_max_150=1;}
					if ($txt_min_150>$txt_max_150) { $txt_min_150=$txt_max_150; }

					if (!(in_array(1,get_mag_stih($user,$usr_eff_sti)))) { $zzodik=" <font color=red>-50%</font> "; } else { $zzodik=""; }
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/mag1/'.str_replace('.gif','.html',$vl[0]).'" target=_blank><img src=http://i.oldbk.com/i/sh/'.$vl[0].'></a><br>'.$eff[$i]['name'].'','���� �� ����� ����:<b> '.$txt_min_150.'-'.$txt_max_150.' '.$zzodik.'</b> <br> ���: ��� ������ '.(int)($vl[2]).'%, ��� ��������� '.round($vl[2]/4,2).'%','�������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="main.php?effects=1&cancel=150">����������</a>');
				} elseif ($eff[$i]['type'] == 130) {
					//������� ��� ������ ����� ��� ���������� �� ����� . �������� ���� ������ 3� ������ �������� ��� ������ �� ������
					if (($eff[$i]['lastup']>0) AND ($user['mair']<3)) { $user['mair']=(int)($eff[$i]['lastup']); }

					if ($user['mair']>100) { $usermair=100; } else { $usermair=$user['mair'];}

					if ($usermair>0) {
						
						$user_mudra=$user['mudra'];
						if ($user_mudra>50) { $user_mudra=50; }
					
						$txt_min_130=$user_mudra+$usermair;
						$vl=explode(":",$eff[$i]['add_info']);
						$eff[$i]['add_info']=$vl[1];
						$txt_max_130=((int)($eff[$i]['add_info'])*$usermair);
					} else {
						$txt_min_130=0;
						$txt_max_130=0;
					}
					
					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$txt_min_130+=(1*$user_prof['magelevel']);
						$txt_max_130+=(2*$user_prof['magelevel']);
						}
					
					if ($txt_min_130>1000) {$txt_min_130=1000;}
					if ($txt_max_130>1000) {$txt_max_130=1000;}

					if (!(in_array(3,get_mag_stih($user,$usr_eff_sti))))  { $zzodik=" <font color=red>-50%</font> "; } else { $zzodik=""; }
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/mag1/'.str_replace('.gif','.html',$vl[0]).'" target=_blank><img src=http://i.oldbk.com/i/sh/'.$vl[0].'></a><br>'.$eff[$i]['name'].' ',' ���� �� ����� �������:<b> '.$txt_min_130.'-'.$txt_max_130.' '.$zzodik.'</b> <br> ���: ��� ������ '.(int)($vl[2]).'%, ��� ��������� '.round($vl[2]/4,2).'%',' �������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong> <br><a href="main.php?effects=1&cancel=130">����������</a>');
				} elseif ($eff[$i]['type'] == 920) {
					$vl=explode(":",$eff[$i]['add_info']);

					$eff[$i]['add_info']=$vl[1];

					if (($eff[$i]['lastup']>0) AND ($user['mearth']<1)) { $user['mearth']=(int)($eff[$i]['lastup']); }
					if ($user['mearth']>100) { $usermearth=100; } else { $usermearth=$user['mearth'];}

					if ($usermearth>0) {
						$user_mudra=$user['mudra'];
						if ($user_mudra>50) { $user_mudra=50; }
						$txt_min_920=(int)($user_mudra/5);
						$txt_max_920=$usermearth;
					} else {
						$txt_min_920=1;
						$txt_max_920=1;
					}

						if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$txt_min_920+=(1*$user_prof['magelevel']);
						$txt_max_920+=(2*$user_prof['magelevel']);
						}

					$txt_min_920 = intval($txt_min_920 * 0.5);
					$txt_max_920 = intval($txt_max_920 * 0.5);

					if ($txt_min_920>1000) {$txt_min_920=1000;}
					if ($txt_max_920>1000) {$txt_max_920=1000;}

					if ($txt_min_920<1) {$txt_min_920=1;}
					if ($txt_max_920<1) {$txt_max_920=1;}


					if ($txt_min_920>$txt_max_920) { $txt_min_920=$txt_max_920; }

					if (!(in_array(2,get_mag_stih($user,$usr_eff_sti))))  { $zzodik=" <font color=red>-50%</font> "; } else { $zzodik=""; }
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/mag1/'.str_replace('.gif','.html',$vl[0]).'" target=_blank><img src=http://i.oldbk.com/i/sh/'.$vl[0].'></a><br>'.$eff[$i]['name'].' ','���� �� ����� �����:<b> '.$txt_min_920.'-'.$txt_max_920.' '.$zzodik.' </b> <br> ���: ��� ������ '.(int)($vl[2]).'%, ��� ��������� '.round($vl[2]/4,2).'%','�������� <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="main.php?effects=1&cancel=920">����������</a>');

				} elseif ($eff[$i]['type'] == 930) {
					$vl=explode(":",$eff[$i]['name']);
					$eff[$i]['name']=$vl[1];

					if (($eff[$i]['lastup']>0) AND ($user['mwater']<1)) { $user['mwater']=(int)($eff[$i]['lastup']); }

					if ($user['mwater']>100) { $usermwater=100; } else { $usermwater=$user['mwater'];}
					if ($usermwater>0) {
						$user_mudra=$user['mudra'];
						if ($user_mudra>50) { $user_mudra=50; }
						$txt_min_930=(int)($user_mudra+$usermwater);
						$txt_max_930=$usermwater*10;
					} else {
						$txt_min_930=1;
						$txt_max_930=1;
					}

					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$txt_min_930+=(1*$user_prof['magelevel']);
						$txt_max_930+=(2*$user_prof['magelevel']);
						}

					if ($txt_min_930>1000) {$txt_min_930=1000;}
					if ($txt_max_930>1000) {$txt_max_930=1000;}

					if ($txt_max_930<1) {$txt_max_930=1;}
					if ($txt_min_930<1) {$txt_min_930=1;}

					if ($txt_min_930>$txt_max_930) { $txt_min_930=$txt_max_930; }

					if (!(in_array(4,get_mag_stih($user,$usr_eff_sti)))) { $zzodik=" <font color=red>-50%</font> "; } else { $zzodik=""; }
                                        
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/mag1/'.str_replace('.gif','.html',$vl[0]).'" target=_blank><img src=http://i.oldbk.com/i/sh/'.$vl[0].'></a><br>'.$eff[$i]['name'].'','���� �� ����� ����:<b> '.$txt_min_930.'-'.$txt_max_930.' '.$zzodik.'</b> <br> ���: ��� ������ '.(int)($vl[2]).'%, ��� ��������� '.round($vl[2]/4,2).'%','�������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="main.php?effects=1&cancel=930">����������</a>');

				} elseif ($eff[$i]['type'] == 791) {
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/zamkiknigi.html" target=_blank><img src=http://i.oldbk.com/i/sh/cbp2.gif></a><br> "������� ���������� �����"','<b>���������� +15% ����� �� ��������� ���.</b>','<strong>�� ��������� ���</strong>');
				} elseif ($eff[$i]['type'] == 792) {
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/zamkiknigi.html" target=_blank><img src=http://i.oldbk.com/i/sh/cbp1.gif></a><br> "������� ���������� �����"','<b>���������� +5% ����� �� ��������� ���.</b>','<strong>�� ��������� ���</strong>');
				} elseif ($eff[$i]['type'] == 793) {
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/zamkiknigi.html" target=_blank><img src=http://i.oldbk.com/i/sh/cbp3.gif></a><br> "Ƹ���� ���������� �����"','<b>���������� +1% �� ��� ������������ �� ��������� ���.</b>','<strong>�� ��������� ���</strong>');
				} elseif ($eff[$i]['type'] == 794) {
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/zamkiknigi.html" target=_blank><img src=http://i.oldbk.com/i/sh/cbp5.gif></a><br> "������ ���������� �����"','<b>���������� ���������� ���� �� ���������� ������ "������� �������������� �������" (0/1).</b>','<strong>�� ��������� ���</strong>');
				} elseif ($eff[$i]['type'] == 795) {
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/zamkiknigi.html" target=_blank><img src=http://i.oldbk.com/i/sh/cbp4.gif></a><br> "����� ���������� �����"','<b>� ������� 20 ��������� �����, ������ ���� ���������, �������� ���� ����������, �������� ��������������� ����� ������ ��������� (�� �� �����, ��� ��������� ������������ �� ���������).</b>','<strong>�� ��������� ���</strong>');
				} elseif ($eff[$i]['type'] == 160) {
					$img_bonus="svitok_exp_".($eff[$i]['add_info']*100).".gif";
																												
					if ($eff[$i]['time']-2>time()) {
						$cncl='<br> <a href=main.php?effects=1&cancel=160>��������</a>';					
					} else {
						$cncl='';
					}

					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/'.$img_bonus.'><br> "��������� ����"','<b>'.$eff[$i]['name'].'</b>','�������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$cncl);
				} elseif ($eff[$i]['type'] == 171) {
					$img_bonus="svitok_exp_10.gif";
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/'.$img_bonus.'><br> "��������� ����"','<b>'.$eff[$i]['name'].' - '.$eff[$i]['add_info'].'</b>','�������� <strong> '.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif ($eff[$i]['type'] == 170) {
					$img_bonus="svitok_exp_".($eff[$i]['add_info']*100).".gif";
					echo  render_sost_row('<img src=http://i.oldbk.com/i/sh/'.$img_bonus.'><br> "��������� ����"','<b>'.$eff[$i]['name'].'</b>','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
				} elseif (($eff[$i]['type'] == 9101)||($eff[$i]['type'] == 9102)||($eff[$i]['type'] == 9103)||($eff[$i]['type'] == 9104)||($eff[$i]['type'] == 9105)||($eff[$i]['type'] == 9106)||($eff[$i]['type'] == 9107)) {
					$bonimgs[9102]='scrol_exp20.gif';																												
					$bonimgs[9103]='scrol_run20.gif';																												
					$bonimgs[9104]='scrol_lab20.gif';																												
					$bonimgs[9105]='scrol_rist20.gif';																												
					$bonimgs[9106]='scrol_zam20.gif';																												
					$bonimgs[9107]='scrol_zag20.gif';	

					$bonname[9101]='��������� +20%';																												
					$bonname[9102]='���� +20%';
					$bonname[9103]='������ ���� +20%';																												
					$bonname[9104]='������� ��������� ����� -20%';																												
					$bonname[9105]='������� ��������� -20%';																												
					$bonname[9106]='������� ����� ������� �����  -20%';																												
					$bonname[9107]='������� ������ � �������� -20%';	

					if ($eff[$i]['add_info'] == "0.3" && $eff[$i]['type'] == 9102) 
					{
						$bonimgs[9102]='svitok_exp_30.gif';
						$bonname[9102]='���� +30%';
					}

					if ($eff[$i]['add_info'] == "0.3" && $eff[$i]['type'] == 9103) 
					{
						$bonimgs[9103]='scroll_run2_2.gif';
						$bonname[9103]='������ ���� +30%';
					}
					
					if ($eff[$i]['add_info'] == "0.3" && $eff[$i]['type'] == 9104) 
					{
						$bonimgs[9104]='valentine2015.gif';
						$bonname[9104]='������� � �������� -30%';
					}
					elseif ($eff[$i]['add_info'] == "0.5" && $eff[$i]['type'] == 9104) 
					{
						$bonimgs[9104]='scroll_lab2.gif';
						$bonname[9104]='������� � �������� -50%';
					}
					
					if ($eff[$i]['add_info'] == "0.3" && $eff[$i]['type'] == 9105) 
					{
						$bonimgs[9105]='valentine2015.gif';
						$bonname[9105]='������� � ��������� -30%';
					}elseif ($eff[$i]['add_info'] == "0.5" && $eff[$i]['type'] == 9105) 
					{
						$bonimgs[9105]='scroll_rista2.gif';
						$bonname[9105]='������� � ��������� -50%';
					}
					
					if ($eff[$i]['add_info'] == "0.3" && $eff[$i]['type'] == 9106) 
					{
						$bonimgs[9106]='valentine2015.gif';
						$bonname[9106]='������� ����� ������� ����� -30%';
					}elseif ($eff[$i]['add_info'] == "0.5" && $eff[$i]['type'] == 9106) 
					{
						$bonimgs[9106]='scroll_ruin2.gif';
						$bonname[9106]='������� ����� ������� ����� -50%';
					}
					
					if ($eff[$i]['add_info'] == "0.5" && $eff[$i]['type'] == 9107) 
					{
						$bonimgs[9107]='scroll_zagor2.gif';
						$bonname[9107]='������� ������ � �������� -50%';
					}
					

					if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">����������</a>';
					} else {
						$offvar='&nbsp;';
					}
	
					echo  render_sost_row('<a href="http://oldbk.com/encicl/?/mag1/'.str_replace('.gif','.html',$bonimgs[$eff[$i]['type']]).'" target=_blank><img src="http://i.oldbk.com/i/sh/'.$bonimgs[$eff[$i]['type']].'" alt=""></a><br>'.$bonname[$eff[$i]['type']].'',''.$eff[$i]['name'].'','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif (($eff[$i]['type'] == 669) ) {
					$bonimgs=explode(":",$eff[$i]['add_info']);

					if ($eff[$i]['time']-2>time()) {
						$offvar = '<br><a href="?effects=1&cancel='.$eff[$i]['type'].'">��������</a>';
					} else {
						$offvar='&nbsp;';
					}
					$eff_link='<a href="http://oldbk.com/encicl/?/mag1/'.str_replace('.gif','.html',$bonimgs[0]).'" target=_blank>';
					$eff_img='http://i.oldbk.com/i/sh/'.$bonimgs[0];
					
					if (strpos($bonimgs[0], 'flag') !== false) 
							{					
							$eff_link='<a href="http://oldbk.com/encicl/?/act_euro2016.html" target=_blank>';							
							$eff_img='http://i.oldbk.com/i/euro2016/'.$bonimgs[0];
							}
							
					
					echo  render_sost_row($eff_link.'<img src="'.$eff_img.'" alt="" WIDTH="30" HEIGHT="30"></a><br>'.$eff[$i]['name'],''.$bonimgs[1].'','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$offvar);
				} elseif ($eff[$i]['type'] == 50000) {
					if ($eff[$i]['time']-2>time()) {
						$cncl_strt='<a href=main.php?effects=1&cancel=50000>��������</a>';
					} else {
						$cncl_strt='&nbsp;';
					}	
					echo  render_sost_row('<img src=http://i.oldbk.com/i/inf_mag.gif><br>'.$eff[$i]['name'].'','','�������� <strong>  '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>'.$cncl_strt);
				} elseif ($eff[$i]['type'] == 40000) {
					if ($eff[$i]['time']-2>time()) {
						$cncl_strt='<a href=main.php?effects=1&cancel=40000>��������</a>';
					} else {
						$cncl_strt='&nbsp;';
					}
					echo  render_sost_row('<img src=http://i.oldbk.com/i/inf_lekar.gif><br>'.$eff[$i]['name'],'','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.  </strong>'.$cncl_strt);
				} elseif ($eff[$i]['type'] == 30000) {
					if ($eff[$i]['time']-2>time()) {
						$cncl_strt= '<a href=main.php?effects=1&cancel=30000>��������</a>';
					} else {
						$cncl_strt='&nbsp;';
					}
					echo  render_sost_row('<img src=http://i.oldbk.com/i/inf_torg.gif><br>'.$eff[$i]['name'],'','�������� <strong> '.((int)((($eff[$i]['time']-time())/60/60/24)))." �. ".floor(($eff[$i]['time']-(((int)((($eff[$i]['time']-time())/60/60/24)))*24*60*60)-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.  </strong>'.$cncl_strt);
				} elseif ($eff[$i]['type'] == 2000) {
					$bufout.='';
					
					if ($user['naim']==0) {
						// ���� ���� �� �����
						$opcl=(int)$_GET['cl'];
						if ($opcl>0) {
							$opf =mysql_fetch_array(mysql_query("select * from oldbk.naim_message where owner='{$user['id']}' and stat=0 and in_klan_id='{$opcl}' ; "));
							if ($opf['id']>0) {
								if ($_GET['naim']=='y') {
									if ($user['money']>=30) {
										mysql_query("UPDATE users set money=money-30 where id='{$user['id']}' and money>=30;");
										if (mysql_affected_rows()>0) {
											$rec = array();
											$rec['owner']=$user['id'];
											$rec['owner_login']=$user['login'];
											$rec['owner_balans_do']=$user['money'];
											$rec['owner_balans_posle']=$user['money']-30;
											$rec['target']=0;
											$rec['target_login']="";
											$rec['type']=321; // ������ �� ����������
											$rec['sum_kr']=30;
											add_to_new_delo($rec); //�����

											mysql_query("UPDATE oldbk.naim_message set stat=1 where owner='{$user['id']}' and in_klan_id='{$opcl}' and stat=0 ; ");

											if (mysql_affected_rows()>0) {
												//���������� ������ ����� ��� ������� ������
												$bufout.="������� ����������� � ������!<br> ";
												//������� ��������� - ����������� ������
												$get_sender=check_users_city_data($opf['sender']);
												if($get_sender['odate'] >= (time()-60))	{
													addchp ('<font color=red>��������!</font> ������� '.$user['login'].' ������ ���� �����������!','{[]}'.$get_sender['login'].'{[]}');
												} else {
													mysql_query("INSERT INTO oldbk.`telegraph`   (`owner`,`date`,`text`) values ('".$get_sender['id']."','','".'<font color=red>��������!</font> ������� '.$user['login'].' ������ ���� �����������!'."');");
												}
												$del_other_mess=1;

												//������ ���� ������ ��� �� �������� ����� �����
												mysql_query("UPDATE users SET naim='{$opf['in_klan_id']}' , naim_war='{$opf['war_id']}' where id='{$user['id']}'  ");

												//l��������� � ��� ����� � ���� ��� ������
												//�������� �������
												$get_klan_sotor=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new  where id='{$opf['war_id']}' and (agressor='{$opf['in_klan_id']}' OR defender='{$opf['in_klan_id']}') LIMIT 1;"));

												if ($user['klan']!='') {
													$klan_gif="<img src=http://i.oldbk.com/i/klan/".$user['klan'].".gif border=0>";
												} else {
													$klan_gif='';
												}

												if ($user['align']>0) {
													$align_gif="<img src=http://i.oldbk.com/i/align_".$user['align'].".gif border=0>";
												} else {
													$align_gif='';
												}

												$inf_gif="<a target=_blank href=/inf.php?".$user['id']."><img border=0 src=http://i.oldbk.com/i/inf.gif></a>";

												if ($get_klan_sotor['agressor']==$opf['in_klan_id']) {
													//������� ���������
													mysql_query("UPDATE oldbk.clans_war_new SET agr_txt=CONCAT(agr_txt,',������� ".$align_gif.$klan_gif." <b>{$user['login']}</b>[".$user['level']."]".$inf_gif."')   where id='{$opf['war_id']}' ; ");
												} elseif ($get_klan_sotor['defender']==$opf['in_klan_id']) {
													//������� ���������
													mysql_query("UPDATE oldbk.clans_war_new SET def_txt=CONCAT(def_txt,',������� ".$align_gif.$klan_gif." <b>{$user['login']}</b>[".$user['level']."]".$inf_gif."')   where id='{$opf['war_id']}' ; ");
												}
											}
										}
									} else {
										$bufout.='<font color=red>������������ �������� ��� �������� ������!</font><br>';
									}
								} elseif ($_GET['naim']=='n') {
									mysql_query("DELETE from oldbk.naim_message where owner='{$user['id']}' and in_klan_id='{$opcl}' ; ");
									if (mysql_affected_rows()>0) {
										//���������� ������ ����� �� ������
										$bufout.="��������� � ������!<br>";
										$get_sender=check_users_city_data($opf['sender']);
										if($get_sender['odate'] >= (time()-60)) {
											addchp ('<font color=red>��������!</font> ������� '.$user['login'].' ������� ��� � ������!','{[]}'.$get_sender['login'].'{[]}');
										} else {
											mysql_query("INSERT INTO oldbk.`telegraph`   (`owner`,`date`,`text`) values ('".$get_sender['id']."','','".'<font color=red>��������!</font> ������� '.$user['login'].' ������� ��� � ������!'."');");
										}
									}
								}
							}
						}

						//�������� ������ �����������
						$all_naim_mess=0;
						$get_in_mess=mysql_query("select *,(select short from oldbk.clans where id=in_klan_id) as clan_name from oldbk.naim_message where owner='{$user['id']}' and stat=0  ");
						while($grm=mysql_fetch_array($get_in_mess)) {
							if ($del_other_mess==1)	{
								//���������� ���� ��������
								mysql_query("DELETE from oldbk.naim_message where owner='{$user['id']}' and in_klan_id='{$grm['in_klan_id']}' ; ");
								if (mysql_affected_rows()>0) {
									//���������� ������ ����� �� ������
									$bufout.= " ������� �����������! ����� ".$grm['in_klan_id']."  <br>";
									$get_sender=check_users_city_data($grm['sender']);
									if($get_sender['odate'] >= (time()-60)) {
										addchp ('<font color=red>��������!</font> ������� '.$user['login'].' ������� ��� � ������!','{[]}'.$get_sender['login'].'{[]}');
									} else {
										mysql_query("INSERT INTO oldbk.`telegraph`   (`owner`,`date`,`text`) values ('".$get_sender['id']."','','".'<font color=red>��������!</font> ������� '.$user['login'].' ������� ��� � ������!'."');");
									}
								}
							} else {
								$all_naim_mess++;
								$bufout.= "[{$grm['indata']}] ����:<b>".$grm['clan_name']."</b> ������ ������. <a href=?edit=1&effects=1&naim=y&cl={$grm['in_klan_id']}>������</a>|<a href=?edit=1&effects=1&naim=n&cl={$grm['in_klan_id']}>��������</a><br> ";
							}
						}

						if (($del_other_mess!=1) and ($all_naim_mess==0)) {
							$bufout.= "� ��� ���� ��� �����������!";//��� ����� ��������
							$bufout.= ' <a href=main.php?effects=1&cancel=2000>��������</a>';
						} elseif ($all_naim_mess>0) {
							$bufout.= "<br><br><small>* ������� ����� � ������ <b>30 ��</b></small>";
						}

					} else {
						//� �����, ���� ����� � ������
						$havewar=mysql_fetch_array(mysql_query("SELECT * from oldbk.clans_war_new  where id='{$user['naim_war']}'  "));
						if ( ($havewar['id']>0) and ($havewar['winner']==0) and (strtotime($havewar['stime'])<=time() ) ) {
							$wrtxttype[1]='�������� �����';
							$wrtxttype[2]='���������� �����';
							include ('klan_war_new.php');
	
							$bufout.= $wrtxttype[$havewar['wtype']]." ".$havewar['agr_txt']. ' <b> ������ </b>' .$havewar['def_txt'];
							$bufout.= '<a href=towerlog.php?war='.$havewar['id'].' target=_blank> �� </a>';
							$bufout.= "<br>";
							$bufout.= '<a href="#" onclick="javascript:runmagic1(\'���������\',\'post_attack\',\'target\',\'target1\') "><img title="��������� ��������" src="i/magic/attack.gif"></a>';

							//�������� �������
							if   ($havewar['agressor']==$user['naim']) {
								$voin=get_voins($user['naim_war'],'agr');
								$get_count_arkan=(int)$havewar['agr_ark'];
								$my_need_ark =(int)($voin['my']['total']/500)+3; // 3 ����������� ������
								$my_side_is='agr';
							} elseif ($havewar['defender']==$user['naim']) {
								$voin=get_voins($user['naim_war'],'def');
								$get_count_arkan=(int)$havewar['def_ark'];
								$my_need_ark =(int)($voin['my']['total']/500)+3; // 3 ����������� ������
								$my_side_is='def';
							} else { die(); }


							if ($get_count_arkan<$my_need_ark) {
								$bufout.= '<a href="#" onclick="javascript:runmagic1(\'�����\',\'post_attack2\',\'target\',\'target1\') "><img title="����� '.$get_count_arkan.'/'.$my_need_ark.'"  src="http://i.oldbk.com/i/magic/arkan.gif"></a>';
								$can_use_arkan=true;
							} else {
								$bufout.= '<img title="����� '.$get_count_arkan.'/'.$my_need_ark.'" src="http://i.oldbk.com/i/klan_arkan_p.gif">';
								$can_use_arkan=false;
							}

							if (($_POST['use'] =='post_attack2') AND ($_POST[target]!='') AND ($can_use_arkan==true)) {
								$_POST['use']='post_attack';
								$USE_ARKAN=true;
							} elseif (($_POST['use'] =='post_attack2') AND ($_POST[target]!='') AND ($can_use_arkan==false)) {
								$bufout.= "<br>������ ����������� :( <br>";
								unset($_POST);
							}

							// �� �������
							if ( (($_POST['use'] =='post_attack') AND ($_POST['target']!='')) OR ( (int)($_GET['post_attack'])>0)) {
								if ( (int)($_GET['post_attack'])>0) {
									$telo=mysql_fetch_array(mysql_query('SELECT * from users where id = "'.(int)($_GET['post_attack']).'" LIMIT 1'));
								} else {
									$telo=mysql_fetch_array(mysql_query('SELECT * from users where login = "'. strip_tags($_POST['target']).'" LIMIT 1'));
								}

								if (strtotime($havewar['ftime'])>=time()) {
									$startbattle=true;
								} else {
									$startbattle=false;
								}

								if ((($telo['id']>0) AND ($telo['klan']!='') ) OR ($telo['naim_war'] == $havewar['id'])) {
									if ($telo['klan']!='')	{
										//���� ���� � � �����
										//��������� ����
										$target_clan=mysql_fetch_array(mysql_query('SELECT * from oldbk.clans where short ="'.$telo['klan'].'" LIMIT 1'));
										$target_clan['id']=($target_clan['base_klan']>0?$target_clan['base_klan']:$target_clan['id']); // ���� ���� ���� ������ = ����� �� ����� ������
									} else if ($telo['naim']>0) {
										//���� ���� - �� ��������� ���� ��������
										$target_clan=mysql_fetch_array(mysql_query('SELECT * from oldbk.clans where id ="'.$telo['naim'].'" LIMIT 1'));
									}

									if ($target_clan['id']>0) {
										//������ ��������� ����� �� �� �� ���� �������
										if ($my_side_is=='agr') {
											if ($havewar['defender']!=$target_clan['id']) {
												// ���� ���� �� ������� �������� ������� �� ������ ����
												// ���� �������� �� ���� �� �������� �������� ������� - �� ����  � �������� ���������
												$target_clan_ally=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_ally where warid='{$havewar['id']}' and defender='{$havewar['defender']}' and clanid='{$target_clan['id']}'"));
												if (!($target_clan_ally['id']>0)) {
													$stop=true;
												}
											}
										} else {
											if ($havewar['agressor']!=$target_clan['id']) {
												// ���� ���� �� ������� �������� ������� �� ������ ����
												// ���� �������� �� ���� �� ������� �������� ������� - �� ����  � �������� ���������
												$target_clan_ally=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_ally where warid='{$havewar['id']}' and agressor='{$havewar['agressor']}' and clanid='{$target_clan['id']}'"));
												if (!($target_clan_ally['id']>0)) {
													$stop=true;
												}
											}
										}
									} else {
										$stop=true;
									}

									//fix
									if (($stop) AND ($telo['naim_war'] == $havewar['id'])) {
										//�������� ����� �� ����� - � ���� ������
										$target_clan=mysql_fetch_array(mysql_query('SELECT * from oldbk.clans where id ="'.$telo['naim'].'" LIMIT 1'));
										if ($my_side_is=='agr') {
											if ($havewar['defender']==$target_clan['id']) {
												//��� ���
												$stop=false;
											}
										} else {
											if ($havewar['agressor']==$target_clan['id']) {
												$stop=false;
											}
										}
									}

									//
									if ($stop) {
										$bufout.='<font color=red><br>� ��� ��� ����� � ���� ������!</font><br>';
									}
								} elseif (($telo['id']>0) AND ($telo['klan']=='')) {
									$bufout.='<font color=red><br>���� �������� �� � �����!</font><br>';
									$stop=true;
								} else {
									$bufout.='<font color=red><br>����� �������� �� ������!</font><br>';
									$stop=true;
								}

								if($stop==false) {
									//���� ��� ��� �� �������� ������
									$klan_war=true;
									//$startbattle - ����� �� �������� ���
									//$USE_ARKAN - ��� ���� ����������� �����
									$bufout.="<br>";
									include "magic/klanattack_new.php";
									//�������� ������ ���������
									//���� � ��� - �� � �����? � ����� �� ���������?
									//���� �� � ��� - �� ��������.
									if($napal==1) {
										header("Location: fbattle.php");
										$bufout.='<script>location.href = "fbattle.php";</script>';
									}
								}
							}

							////���������

						} else if ( ($havewar['id']>0) and ($havewar['winner']==0)) {
							//����������
							$wrtxttype[1]='�������� �����';
							$wrtxttype[2]='���������� �����';
							$bufout.= $wrtxttype[$havewar['wtype']]." ".$havewar['agr_txt']. ' <b> ������ </b>' .$havewar['def_txt']." <br><small>(���������� � �����)</small> ";
						}
        				}

					echo  render_sost_row('<img src=http://i.oldbk.com/i/inf_naim.gif><br> '.$eff[$i]['name'].' <b>',$bufout.'&nbsp;',' ��������  <strong>'. (round((($eff[$i]['time']-time())/60/60/24),1)).'</b> ����.</strong>');
				} elseif (($eff[$i]['type']>=900) AND ($eff[$i]['type']<=903)) {
					echo  render_sost_row('C����-����������',' '.$eff[$i]['name'].':+'.$eff[$i]['add_info'].' M�.',' ��������  <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="main.php?effects=1&cancel='.$eff[$i]['type'].'">����������</a>');
				} elseif (($eff[$i]['type']>=904) AND ($eff[$i]['type']<=906)) {
					echo  render_sost_row('C����-����������',' '.$eff[$i]['name'].':+'.$eff[$i]['add_info'].' %.',' ��������  <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���.</strong><br><a href="main.php?effects=1&cancel='.$eff[$i]['type'].'">����������</a>');
				} elseif ($eff[$i]['type']==908) {
					echo  render_sost_row('C����-����������',' '.$eff[$i]['name'].':+'.$eff[$i]['add_info'].' %.',' ��������  <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="main.php?effects=1&cancel='.$eff[$i]['type'].'">����������</a>');
				} elseif ($eff[$i]['type']==907) {
					echo  render_sost_row('C����-����������',' '.$eff[$i]['name'].':+'.($eff[$i]['add_info']*100).' %.',' ��������  <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong><br><a href="main.php?effects=1&cancel='.$eff[$i]['type'].'">����������</a>');
				} elseif ($eff[$i]['type']==796) {
					$eff_inf=explode(':',$eff[$i]['add_info']);
					echo  render_sost_row('<img src="http://i.oldbk.com/i/sh/'.$eff_inf[0].'" alt="'.$eff[$i]['name'].'" title="'.$eff[$i]['name'].'"><br>'.$eff[$i]['name'],' ������������� <b>'.$eff_inf[1].'</b> ����� ���������� � ��������� ���','<strong>�� ��������� ���������� ���</strong>');
				} elseif ($eff[$i]['type']==420420) {
					echo  render_sost_row('<img src="http://i.oldbk.com/i/city/sub/vesna_cap_ruins2.png" alt="������ ����" title="������ ����" width="30" height="30"><br><b>������ ����</b>','�� ������ � ��������� ������� ���� ������� ����� ������� <b>'.$eff[$i]['add_info'].' ���������</b>','�������� <strong>'.prettyTime(null,$eff[$i]['time']).'</strong><br><a href="main.php?effects=1&cancel='.$eff[$i]['type'].'">����������</a>');
				} else {
					//��� ��������� �������
					if ($eff[$i]['time']!=1999999999) {
						echo  render_sost_row(''.$eff[$i]['name'],' &nbsp',' ��������  <strong>'.floor(($eff[$i]['time']-time())/60/60).' �. '.round((($eff[$i]['time']-time())/60)-(floor(($eff[$i]['time']-time())/3600)*60)).' ���. </strong>');
					}
				}
			}

			// ����� ������ ������
			$get_bonus=mysql_fetch_array(mysql_query("select sum(ab_mf) as ab_mf , sum(ab_bron) as ab_bron , sum(ab_uron) as ab_uron ,  count(if(unik=1,1,null)) as s_unik , count(if(unik=2,1,null)) as supunik  from oldbk.inventory where id IN (".GetDressedItems($user,DRESSED_ITEMS).")"));


			//����-���
			if (strpos($user['medals'], 'k202;') !== false)
			{
				$get_bonus['s_unik']+=1;
			}
			if (strpos($user['medals'], 'k203;') !== false)
			{
				$get_bonus['supunik']+=1;
			}

			if ( ($get_bonus['ab_mf']>0) or ($get_bonus['ab_bron']>0) or ($get_bonus['ab_uron']>0))
			{
				//�� �����
				echo  render_sost_row('<img src=http://i.oldbk.com/i/artbonus.gif><br><small> <b> �������� �� ���������� </b></small>',''.(($get_bonus['ab_mf']>0)?"�������� ������������� ��.:+{$get_bonus['ab_mf']}%<br>":"").(($get_bonus['ab_bron']>0)?"�������� �����:+{$get_bonus['ab_bron']}%<br>":"").(($get_bonus['ab_uron']>0)?"�������� �����:+{$get_bonus['ab_uron']}%<br>":"").'','&nbsp');
			}

				$unik_bonus_data=get_unik_bonus_data($get_bonus['s_unik'],$get_bonus['supunik']);
				
				if (($unik_bonus_data) and ($unik_bonus_data[0]>0) )				
					{
					echo  render_sost_row('<a href="'.$unik_bonus_data['url'].'" target=_blank><img src="'.$unik_bonus_data['img'].'"></a><br><small> <b>��������</b></small>',$unik_bonus_data['name'].'<br>'.$unik_bonus_data['txt'],'&nbsp;');
					}

			$eff=array();
			$sql="SELECT * from `users_bonus` WHERE owner = '".$user['id']."'";

			$cheff=mysql_fetch_array(mysql_query($sql));

				if ($cheff['finish_time']!='')
				{
				$finstr='�������� <strong>'.prettyTime(null,strtotime($cheff['finish_time']).'</strong>');
				}
				else
				{
				$finstr='<strong>�� ��������� ���������� ���</strong>';
				}
			echo  ($cheff['sila']>0?render_sost_row('���','���� +'.$cheff['sila'].'',$finstr):'') ;
			echo  ($cheff['lovk']>0?render_sost_row('���','�������� +'.$cheff['lovk'].'',$finstr):'');
			echo  ($cheff['inta']>0?render_sost_row('���','�������� +'.$cheff['inta'].'',$finstr):'');
			echo  ($cheff['intel']>0?render_sost_row('���','��������� +'.$cheff['intel'].'',$finstr):'');
			echo  ($cheff['mudra']>0?render_sost_row('���','�������� +'.$cheff['mudra'].'',$finstr):'');
			echo  ($cheff['maxhp']>0?render_sost_row('���','�����(��) +'.$cheff['maxhp'].'',$finstr):'');
			echo  ($cheff['expbonus']>0?render_sost_row('���','���� +'.($cheff['expbonus']*100).'%',$finstr):'');
				
			?>

			</tbody>
			<tfoot>
			<tr class="obraz-footer">
				<td>
					<div class="footer-left"></div>
				</td>
				<td>
					<div class="footer-center"></div>
				</td>
				<td>
					<div class="footer-right"></div>
				</td>
			</tr>
			</tfoot>
		</table>
		<a name="quests"></a>

		<table align="center" class="table-list sostoyanie" cellspacing="0" cellpadding="0">
			<colgroup>
				<col width="280px">
				<col>
				<col width="280px">
			</colgroup>
			<thead>
			<tr class="head-line spoiler-click">
				<th class="center" colspan="7">
					<div class="head-left"></div>
					<div class="head-title"><span>������</span></div>
					<div class="head-spoiler-btn pointer" data-type="hidden"></div>
					<div class="head-right"></div>
				</th>
			</tr>
			</thead>
			<tbody>
			<?
			$User = new \components\models\User($user);
			$Quest = $app->quest
				->setUser($User)
				->get();
			foreach($Quest->getDescriptions() as $_quest) {
				echo render_sost_row($_quest[0], $_quest[1], $_quest[2]);
			}

			if (($get_bonus['s_unik']>0) and ($get_bonus['s_unik']<6))
			{
	
				if ($unik_bonus_data['u']==0)
				{
				echo render_sost_row('<img src=http://i.oldbk.com/i/unic_bonus1.gif><br><small> <b>��������</b></small>','��������� �����: ('.$get_bonus['s_unik'].'/6 ����. ����� )','&nbsp;');
				}
			}
			elseif (($get_bonus['s_unik']>=6) and ($get_bonus['s_unik']<9))
			{
				if ($unik_bonus_data['u']<=1)
				{
				echo render_sost_row('<img src=http://i.oldbk.com/i/unic_bonus2.gif><br><small> <b>��������</b></small>','����������� �����: ('.$get_bonus['s_unik'].'/9 ����. �����)','&nbsp;');
				}
			}
			elseif (($get_bonus['s_unik']>=9) and ($get_bonus['s_unik']<12))
			{
					if ($unik_bonus_data['u']<=2)
					{				
					echo render_sost_row('<img src=http://i.oldbk.com/i/unic_bonus3.gif><br><small> <b>��������</b></small>','������� �����: ('.$get_bonus['s_unik'].'/12 ����. �����)','&nbsp;');
					}
			}
			elseif (($get_bonus['s_unik']>=12) and ($get_bonus['s_unik']<13))
			{
					if ($unik_bonus_data['u']<=3)
					{
					echo render_sost_row('<img src=http://i.oldbk.com/i/unic_bonus4.gif><br><small> <b>��������</b></small>','���������� �����: ('.$get_bonus['s_unik'].'/13 ����. �����)','&nbsp;');
					}
			}

			//////////
			if (($get_bonus['supunik']>0) and ($get_bonus['supunik']<6))
			{
				echo render_sost_row('<img src=http://i.oldbk.com/i/sunic_bonus0.gif><br><small> <b>��������</b></small>','����������� ��������� �����: ('.$get_bonus['supunik'].'/6 ��. ����. ����� )','&nbsp;');
			}
			elseif (($get_bonus['supunik']>=6) and ($get_bonus['supunik']<9))
			{
				echo render_sost_row('<img src=http://i.oldbk.com/i/sunic_bonus1.gif><br><small> <b>��������</b></small>','����������� ����������� �����: ('.$get_bonus['supunik'].'/9 ��. ����. �����)','&nbsp;');
			}
			elseif (($get_bonus['supunik']>=9) and ($get_bonus['supunik']<12))
			{
				echo render_sost_row('<img src=http://i.oldbk.com/i/sunic_bonus2.gif><br><small> <b>��������</b></small>','����������� ������� �����: ('.$get_bonus['supunik'].'/12 ��. ����. �����)','&nbsp;');
			}
			elseif (($get_bonus['supunik']>=12) and ($get_bonus['supunik']<13))
			{
				echo render_sost_row('<img src=http://i.oldbk.com/i/sunic_bonus3.gif><br><small> <b>��������</b></small>','����������� ���������� �����: ('.$get_bonus['supunik'].'/13 ��. ����. �����)','&nbsp;');
			}


			require_once("config_ko.php");
			
			if ($user['klan']=='radminion') $KO_start_time22=time()-1;
			
			if ( ((time()>$KO_start_time22) and (time()<$KO_fin_time22)) )
			{
				$get_buket_battle=mysql_fetch_array(mysql_query("select * from oldbk.battle_buket where owner='{$user[id]}' "));
				echo render_sost_row('<img src=http://i.oldbk.com/i/sh/item_treelenta1.gif>','<b>�������� �� ������ �������</b> ','<strong>'.(int)($get_buket_battle['bcount']).'/21 ��� </strong>');
			}


			if ((time()>$KO_start_time3) and (time()<$KO_fin_time3))
			{
				$bonuses[0]="<a href='http://oldbk.com/encicl/?/eda/zavtrak_3average.html' target=_blank>������ �������</a> 1 ��."; 
				$bonuses[1]="<a href='http://oldbk.com/encicl/mag1/scroll_antimagic1.html' target=_blank>������� ������ ������� �� �����</a> 1 ��.";
		
				$bonuses[2]="<a href='http://oldbk.com/encicl/?/mag2/scroll_callanimal1.html' target=_blank>������� ������ �������</a> 1 ��.";
				$bonuses[3]="<a href='http://oldbk.com/encicl/?/mag1/cure3.html' target=_blank>������� �����</a> 1 ��.";

				//������� ������ ��������� �����, � ����������� �� ������ ���������
					$val4[1]="<a href='http://oldbk.com/encicl/mag1/scroll_wrath_ares1.html' target=_blank>������� ������ ����� �����</a> 1 ��.";
					$val4[2]="<a href='http://oldbk.com/encicl/mag1/scroll_wrath_ground1.html' target=_blank>������� ������ ������ �������</a> 1 ��.";
					$val4[3]="<a href='http://oldbk.com/encicl/mag1/scroll_wrath_air1.html' target=_blank>������� ������ ���� �������</a> 1 ��.";
					$val4[4]="<a href='http://oldbk.com/encicl/mag1/scroll_wrath_water1.html' target=_blank>������� ������ ����� ������</a> 1 ��.";												

				$t = get_mag_stih($user);				
				$bonuses[4]=$val4[$t[0]];
				
				$bonuses[5]="<a href='http://oldbk.com/encicl/?/mag1/helpbattle_e.html' target=_blank>�����������</a> 1 ��. � <a href='http://oldbk.com/encicl/?/mag1/fg1.html' target=_blank>��������� ����</a> 1 ��.";
				$bonuses[6]="5 ���. �� ���� � �����, <a href='http://oldbk.com/encicl/?/mag1/svitok_exp_10.html' target=_blank>���������� ���� (+10%)</a> 1 ��. � 1000 ���������";


				$get_user_day=mysql_fetch_array(mysql_query("select * from oldbk.users_timer where owner='{$user['id']}' "));

				if ($get_user_day)
				{

					//�� ���
					$prsbat=10; //10% �� ���
					$needbattle=5; $needbattle_txt= "����";
					if ($get_user_day['cday']==6) {  $prsbat=5; $needbattle=10; $needbattle_txt="������"; }
					
					$myp=$get_user_day['cbattle']*$prsbat;
					if ($myp>50) $myp=50;
					//�� ������
					$mypo=$get_user_day['ctime']*10;
					if ($mypo>50) $mypo=50;
					$myp+=$mypo;

					if ($get_user_day['getflag']==0)
					{
						$gg='_2.gif';
						$textget='';
					}
					else
					{
						$gg='.gif';
						$textget='<br><small>(����� �� ������� ����� �������)</small>';
					}
					$imgs=$get_user_day['cday']+1;
					$buff_out='';
					if ($textget=='')
					{
						$buff_out.='��������� �������: <b>'.$bonuses[$get_user_day['cday']].'</b>';
					} else {
						$buff_out.=$textget;
					}

					$needtxt="�������� � ���� ���� ����� (".($get_user_day['ctime']>5?5:$get_user_day['ctime'])."/5) � ������� ���� � ".$needbattle_txt." �������� ���� � �������� �������-���� (".(($get_user_day['cbattle']>$needbattle)?$needbattle:$get_user_day['cbattle'])."/".$needbattle.").<br>";
					
						$ddys[0]='<br>���� ������';
						$ddys[1]='<br>���� ������';						
						$ddys[2]='<br>���� ������';						
						$ddys[3]='<br>���� ���������';						
						$ddys[4]='<br>���� �����';						
						$ddys[5]='<br>���� ������';						
						$ddys[6]='<br>���� �������';						
					
					echo render_sost_row('<IMG  src="http://i.oldbk.com/i/action/action_summer_war_d'.$imgs.$gg.'" ><br><small><b><a href="http://oldbk.com/encicl/?/act_line.html" target=_blank>������ ��� ���������:'.$ddys[$get_user_day['cday']].'</a></b></small>',$needtxt.'������� ����������: <b>'.$myp.'%</b>. '.$buff_out,'�������� <strong>'.prettyTime(null,mktime(0,0,0,date("m"),date("d")+1,date("Y"))).'</strong>' );
				}
				else
				{
					//��� ������� ������ 1� ���� � 0� ����������
					$needtxt="�������� � ���� ���� ����� (0/5) � ������� ���� � ���� �������� ���� � �������� �������-���� (0/5).<br>";
					echo render_sost_row('<IMG  src="http://i.oldbk.com/i/action/action_summer_war_d1_2.gif"><br><small><b><a href="http://oldbk.com/encicl/?/act_line.html" target=_blank>������ ��� ���������:<br>���� ������</a></b></small>',$needtxt.'������� ����������: <b>0%</b>. ��������� �������: <b>'.$bonuses[0].'</b> ','�������� <strong>'.prettyTime(null,mktime(0,0,0,date("m"),date("d")+1,date("Y"))).'</strong>' );

				}

			}
			//////////���� ����� ��

				//	if ($user['id']==14897)
			{
				if ((time()>$KO_start_time4) and (time()<$KO_fin_time4))
				{
					$bonuses[0]="<a target=_blank href='https://oldbk.com/encicl/mag1/elixmana_1.html'>������� ����� ����</a>";

					$addname[0]="<a target=_blank href='https://oldbk.com/encicl/mag1/scroll_wrath_ares0_2.html'>����� ������ ����� �����</a>"; //����  0; // �����
					$addname[1]="<a target=_blank href='https://oldbk.com/encicl/mag1/scroll_wrath_ares0_2.html'>����� ������ ����� �����</a>"; //����  1; // �����
					$addname[2]="<a target=_blank href='https://oldbk.com/encicl/mag1/scroll_wrath_ground0_2.html'>����� ������ ������ �������</a>"; //������ ���� wrath_ground   2  �����
					$addname[3]="<a target=_blank href='https://oldbk.com/encicl/mag1/scroll_wrath_air0_2.html'>����� ������ ���� �������</a>"; //����������/ wrath_air 3; //������ (����, ������
					$addname[4]="<a target=_blank href='https://oldbk.com/encicl/mag1/scroll_wrath_water0_2.html'>����� ������ ����� ������</a>"; //���������� ����	wrath_water  4; //����

					$need_astih=get_mag_stih($user); // �������� �� ������
					$need_astih=$need_astih[0]; //�� 0� ����� ������ ������

					$bonuses[1]=$addname[$need_astih];

					$bonuses[2]="<a target=_blank href='https://oldbk.com/encicl/mag2/scroll_callanimal0_2.html'>����� ������ �������</a>";
					$bonuses[3]="<a target=_blank href='https://oldbk.com/encicl/mag1/scrol_lab20.html'>������� ��������� ����� -20%</a>"; // ������� �� 4� ���� - ������ ����������� => 20% ������� �������� (0/5)


					$bonuses[4]="<a target=_blank  href='https://oldbk.com/encicl/mag1/helpbattle_e.html' target=_blank>�����������</a>";
					$bonuses[5]="<a target=_blank href='https://oldbk.com/encicl/mag1/svitok_exp_20.html'>���������� ���� (+20%)</a> (24�.) � <a target=_blank href='https://oldbk.com/encicl/amun/fg2.html'>��������� ���� (x2)</a>"; //������� �� 6� ���� - ������ ����� ������ ����2 http://oldbk.com/encicl/amun/fg2.html, ������ ������ ����� +10%, ������ +20% http://oldbk.com/encicl/mag1/scrol_exp20.html


					//������� ������� ������ ��������
					$get_weekt=mysql_fetch_array(mysql_query("select * from oldbk.users_timer_week where owner='{$user['id']}' "));
					$runexph=(int)$get_weekt['cweek']+1;
					$runexph=(int)$runexph*100;//100
					if ($runexph>1100) {$runexph=1100;}
					
					$strex=sprintf("%'.04d\n", $runexph);
					
					$bonuses[6]="5 ���, 1000 ��������� � �<a target=_blank href='https://oldbk.com/encicl/amun/exp_runs_".$strex.".html'>������ ���� ".$runexph." ��.</a>�! "; //� ������� �� 7� ���� - [������ 5���] �������� �� [5��� �� �������� ���� �����]

					$get_user_day=mysql_fetch_array(mysql_query("select * from oldbk.users_timer where owner='{$user['id']}' "));

						$efftime=mktime(23,59,59,date("m"),date("d"),date("Y"));
						$tmout='�������� <strong>'.floor(($efftime-time())/60/60).' �. '.round((($efftime-time())/60)-(floor(($efftime-time())/3600)*60)).' ���.</strong>';

					if ($get_user_day)
					{




						//�� ���
						$prsbat=10; //10% �� ���
						if ($get_user_day['cday']==6) $prsbat=5; //5 �� ���
						$myp=$get_user_day['cbattle']*$prsbat;
						if ($myp>50) $myp=50;
						//�� ������
						$mypo=$get_user_day['ctime']*10;
						if ($mypo>50) $mypo=50;
						$myp+=$mypo;


						if (  ((date("G")==0) AND ((int)(date("i")>=0)) AND ((int)(date("i")<=3)) ) AND ($get_user_day['getflag']==0) and ($myp>=100) )
						{
							//���������� ����� �.�. ���� �� ������ � "�� ��� ����������"
							$get_user_day['cday']=0;
							$get_user_day['cbattle']=0;
							$get_user_day['ctime']=0;
							$myp=0;
						}


						if ($get_user_day['getflag']==0)
						{
							$gg='_2.gif';
							$textget='';

						}
						else
						{
							$gg='.gif';
							$textget='<br><small>(����� �� ������� ����� �������)</small>';
						}
						$imgs=$get_user_day['cday']+1;
						$buff_out='';
						if ($textget=='')
						{
							$buff_out.='��������� �������: <b>'.$bonuses[$get_user_day['cday']].'</b>';
						}
						else
						{
							$buff_out.=$textget;
						}

						$need_onl=5;						
						if ($get_user_day['cday']==6) 
							{
							$need_bat=10;
							$need_bat_txt='������';
							}
							else
							{
							$need_bat=5;
							$need_bat_txt='����';
							}
						
						$infaa='�������� � ���� ���� ������ ����� ('.$get_user_day['ctime'].'/'.$need_onl.') � ������� ������� � '.$need_bat_txt.' ��������� ��� ������� ���� ('.$get_user_day['cbattle'].'/'.$need_bat.').';
						echo render_sost_row('<IMG  src="http://i.oldbk.com/i/action/action_winter_war_d'.$imgs.$gg.'" ><br> <small><b><a href="https://oldbk.com/encicl/act_line_winter.html" target=_blank>������ �����</a></b></small>',$infaa.'<br>������� ����������: <b>'.$myp.'%</b>.'.$buff_out,$tmout);
					}
					else
					{
						//��� ������� ������ 1� ���� � 0� ����������
						
						echo render_sost_row('<IMG  src="http://i.oldbk.com/i/action/action_winter_war_d1_2.gif" > <br><small><b><a href="https://oldbk.com/encicl/act_line_winter.html" target=_blank>������ �����</a></b></small>','�������� � ���� ���� ������ ����� (0/5) � ������� ������� � ���� ��������� ��� ������� ���� (0/5).<br>������� ����������: <b>0%</b>. ��������� �������: <b>'.$bonuses[0].'</b>',$tmout);

					}

				}
			}
			/////////////

			if ((time()>$KO_start_time5) and (time()<$KO_fin_time5))
			{
				//����� ����� -�������� ���

				if ( ($user['wcount'] > 0) AND $IHAVE_VDUH!=1003 )
				{
					if ($IHAVE_VDUH==1001) { $textvd="II"; }
					elseif ($IHAVE_VDUH==1002) { $textvd="III"; }
					else { $textvd="I"; }
				//	echo render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/vduh.gif" width=40><br> <small><b>�������� ��� ��������� '.$textvd.'</b></small>','�� ������ �������� 5 ����� ������ � ��������� ���������. ('.$user['wcount'].'/5)','&nbsp;');
					
					if ( ($user['wcount'] > 0) and ($user['wcount'] <5 ) )
					{
					echo render_sost_row('<a href="http://oldbk.com/encicl/?/act_duh_spring.html" target=_blank><IMG height=25 src="http://i.oldbk.com/i/magic/vduh.gif" width=40></a><br> <small><b>�������� ��� ��������� I</b></small>','�� ������ �������� 5 ����� ������ � ����������� ���������. ('.$user['wcount'].'/5)','&nbsp;');
					}
					else
					if ( ($user['wcount'] >= 5) and ($user['wcount'] <10 ) )
					{
						echo render_sost_row('<a href="http://oldbk.com/encicl/?/act_duh_spring.html" target=_blank><IMG height=25 src="http://i.oldbk.com/i/magic/vduh.gif" width=40></a><br> <small><b>�������� ��� ��������� II</b></small>','�� ������ �������� 10 ����� ������ � ����������� ���������. ('.$user['wcount'].'/10)','&nbsp;');
					}
					else	if ( ($user['wcount'] >= 10) and ($user['wcount'] <15 ) )
					{
						echo render_sost_row('<a href="http://oldbk.com/encicl/?/act_duh_spring.html" target=_blank><IMG height=25 src="http://i.oldbk.com/i/magic/vduh.gif" width=40></a><br> <small><b>�������� ��� ��������� III</b></small>','�� ������ �������� 15 ����� ������ � ����������� ���������. ('.$user['wcount'].'/15)','&nbsp;');
					}
					
				}
			}
			else

			{
				//������� ���
				if ( ($user['wcount'] > 0) and ($user['wcount'] <5 ) )
				{
					echo render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/bonus2.gif" width=40><br> <small><b>��� ��������� I</b></small>','�� ������ �������� 5 ����� ������ � ����������� ���������. ('.$user['wcount'].'/5)','&nbsp;');
				}
				else
					if ( ($user['wcount'] >= 5) and ($user['wcount'] <10 ) )
					{
						echo render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/bonus2.gif" width=40><br> <small><b>��� ��������� II</b></small>','�� ������ �������� 10 ����� ������ � ����������� ���������. ('.$user['wcount'].'/10)','&nbsp;');
					}
					else	if ( ($user['wcount'] >= 10) and ($user['wcount'] <15 ) )
					{
						echo render_sost_row('<IMG height=25 src="http://i.oldbk.com/i/magic/bonus2.gif" width=40><br> <small><b>��� ��������� III</b></small>','�� ������ �������� 15 ����� ������ � ����������� ���������. ('.$user['wcount'].'/15)','&nbsp;');
					}
			}



			if((int)$_GET['reject']>0)
			{
				$_GET['reject']=(int)($_GET['reject']);
				$sql='update oldbk.beginers_quests_step set status=1 where quest_id="'.$_GET['reject'].'" AND owner ='.$user['id'].';';
				if(mysql_query($sql))
				{
					unset($_SESSION['beginer_quest'][$_GET['reject']]);
				}
			}


			$sql = 'select * from oldbk.beginers_quests_step bqs
				where bqs.owner='.$user['id'].' and status!=1 ;';
			$data = mysql_query ($sql);
			while ($row = mysql_fetch_array($data)) {
				if ($row['quest_id'] == 143) {
					$img = '<img src="http://i.oldbk.com/i/fight_flowers.png"><br>';
				} else {
					$img = '';
				}

				if($row['status']==1)
				{
					$sql1 = 'SELECT * FROM oldbk.beginers_quests WHERE id= '.$row['quest_id'].';';
					$data1 = mysql_fetch_array(mysql_query ($sql1) );

					echo render_sost_row($img.'<strong>'.$data1[qname].'</strong>','<strong>��������</strong>','&nbsp;');
				}
				else
				{
					$buffout=show_quest_dialogs_for_new_sost($row['quest_id'],1);
					echo render_sost_row($img.$buffout[1],$buffout[2],$buffout[3]);

				}
			}


			// ����� 31 - ����� � ������� ��������
			$q = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31"');
			if (mysql_num_rows($q) > 0) {
				$q = mysql_fetch_assoc($q);
				if ($q['val'] == 11) {
					$q = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31a"'));
					$q2 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q31v"'));
					if (!$q['val']) $q['val'] = 0;
					if (!$q2['val']) $q2['val'] = 0;

					if ($q['val'] > 30) $q['val'] = 30;
					if ($q2['val'] > 600) $q2['val'] = 600;

					echo render_sost_row('<img src="http://i.oldbk.com/i/202medal.png"><br><b>����������� �����</b>','�� ������ �������� 600 ����� � ����������� ������ � ������� ���� � 30 ������ ������ ������� �����. (<b>'.$q['val'].'/30</b> � <b>'.$q2['val'].'/600</b>)','&nbsp;');
				} elseif ($q['val'] != 13) {
					$bufout='';
					if ($q['val'] == 0) $bufout.='������� � ��������.<br>';
					elseif ($q['val'] == 1) $bufout.= '�������� 10 ������� ������ �������� ���������.<br>';
					elseif ($q['val'] == 2) $bufout.= '�������� 3 ������ �������� ���������.<br>';
					elseif($q['val'] == 3) $bufout.= '�������� 20 ����� �� ������������ �������� ���������.<br>';
					elseif ($q['val'] == 4) $bufout.= '������� � ���������.<br>';
					elseif ($q['val'] == 5) $bufout.= '�������� 15 ������� ���������.<br>';
					elseif ($q['val'] == 6) $bufout.= '��������� � ��������.<br>';
					elseif ($q['val'] == 7) $bufout.= '�������� �������� �� 100 ������ ������� ���� (���� �1, ���� �2, ���� �3, ���� �4).<br>';
					elseif ($q['val'] == 8) $bufout.= '������� � ����.<br>';
					elseif ($q['val'] == 9) $bufout.= '�������� ���� 50 ���� ������ ����.<br>';
					elseif ($q['val'] == 10) $bufout.= '������� � ����������.<br>';
					elseif ($q['val'] == 11) $bufout.= '�������� � 600 ����������� ������ � 30 ������ ������ ������� �����, ������ ���� �� ������� �����.<br>';
					elseif ($q['val'] == 12) $bufout.= '������ ��������� ������ 150 ����� ����� ���������, ������� �� �������� ��������� � �������� �� ����<br>';

					echo render_sost_row('<a href="http://oldbk.com/encicl/?/geroickv.html" target="_blank"><img align=center src="http://i.oldbk.com/i/202medal.png"><br> <b>����������� �����</b></a>',$bufout,'&nbsp;');
				}

			}

			$q = mysql_query('SELECT * FROM oldbk.map_var WHERE owner = '.$user['id'].' AND var = "q32"');
			if (mysql_num_rows($q) > 0) {
				$q = mysql_fetch_assoc($q);
				if ($q['val'] == 1) {
					$qq = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s1"'));
					if ($qq['val'] > 50) $qq['val'] = 50;
					$bufout = '�������� 50 ���������� �������� ���. (<b>'.$qq['val'].'/50</b>)';
				}
				if ($q['val'] == 2) {
					$qq = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s2"'));
					if ($qq['val'] > 10) $qq['val'] = 10;
					$bufout = '�������� 10 �������� � �����. (<b>'.$qq['val'].'/10</b>)';
				}

				if ($q['val'] == 3) {
					$qz = mysql_query('SELECT * FROM oldbk.inventory WHERE owner = "'.$user['id'].'" AND prototype IN (3101,3102,3103,3201,3202,3203,3204,3205,3206,3207) LIMIT 40');
					$chkcount = mysql_num_rows($qz);
					$bufout = '�������� 40 �����. (<b>'.$chkcount.'/40</b>)';
				}

				if ($q['val'] == 4) {
					$qq1 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s41"'));
					$qq2 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s42"'));
					$qq3 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s43"'));

					if ($qq1['val'] > 100) $qq1['val'] = 100;
					if ($qq2['val'] > 20) $qq2['val'] = 20;
					if ($qq3['val'] > 50) $qq3['val'] = 50;

					$bufout = '�������� 100 ����������� ���, 20 ��� �� ��, �������� 50 ������� � ����� �����������. (<b>'.$qq1['val'].'/100</b>, <b>'.$qq2['val'].'/20</b>, <b>'.$qq3['val'].'/50</b>)';
				}

				if ($q['val'] == 5) {
					$qq1 = mysql_query('SELECT * FROM oldbk.inventory WHERE owner = "'.$user['id'].'" AND prototype = 667667 LIMIT 50');
					$chkcount = mysql_num_rows($qq1);
					$bufout = '�������� 50 ������ ����. (<b>'.$chkcount.'/50</b>)';
				}

				if ($q['val'] == 6) {
					$qq2 = mysql_query('SELECT * FROM oldbk.inventory WHERE owner = "'.$user['id'].'" AND prototype = 3002500 LIMIT 10');
					$chkcount = mysql_num_rows($qq2);
					$qq1 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s6"'));
					if ($qq1['val'] > 30) $qq1['val'] = 30;
					$bufout = '�������� 10 ������� � 30 ����� ��� �������� �����. (<b>'.$chkcount.'/10</b>, <b>'.$qq1['val'].'/30</b>)';
				}

				if ($q['val'] == 7) {
					$qq1 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s71"'));
					$qq2 = mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.map_var WHERE owner = "'.$user['id'].'" AND var = "q32s72"'));

					if ($qq1['val'] > 50) $qq1['val'] = 50;
					if ($qq2['val'] > 1) $qq2['val'] = 1;

					$bufout = '������� ������� � 50 ��������� ���� ��� � 1 ������ ���. (<b>'.$qq1['val'].'/50</b>, <b>'.$qq2['val'].'/1</b>)';
				}
				if ($q['val'] < 8) {
					echo render_sost_row('<a href="http://oldbk.com/encicl/?/legendkv.html" target="_blank"><img align=center src="http://i.oldbk.com/i/203medal.gif"><br> <b>����������� �����</b></a>',$bufout,'&nbsp;');
				}
			}

			$q = mysql_query('SELECT * FROM oldbk.ny_quest_var WHERE owner = '.$user['id'].' AND var = "q1"');
			if (mysql_num_rows($q) > 0) {
				$nyq = mysql_fetch_assoc($q);
				echo render_sost_row('<img src="http://i.oldbk.com/i/fighttype7.gif" alt=""><br> <b>������� �������</b></a>','��� ���������� �������� ������ � 25-�� ������� ��������� ���� � ������ ��������� (13 �����, �� ������ ���). ��� ����� ��������, ���� ���� ����� ������� ����. <b>('.$nyq['val'].'/25)</b> <br>�������: 6000 ���������, ��������� �����.','&nbsp;');
			}

			?>
			</tbody>
			<tfoot>
			<tr class="obraz-footer">
				<td>
					<div class="footer-left"></div>
				</td>
				<td>
					<div class="footer-center"></div>
				</td>
				<td>
					<div class="footer-right"></div>
				</td>
			</tr>
			</tfoot>
		</table>

		<?
		/*
		<div class="block-hint">
				<h2><font color=black>����� � ������� ���������: <?php echo $user['winstbat']; ?></font></h2>
		</div>
		*/
		?>

		<div class="block-hint">
			<h2><font color=black>������ � ������� (���������� � ���������� � ���������):</font></h2>
			<div align=center>
				<?
				$med = explode("|",$user['medals']);
				$medals[0] = explode(";",$med[0]); //�������� ������

				if(count($med[1]>0))
				{
					$medals[1] = explode(";",$med[1]); //�������� ������
				}

				$txt_vis='';
				$txt_hid='|';
				if($_POST['save_med'])
				{
					foreach($medals as $k=>$v)
					{
						for ($i=0;$i<count($v)-1;$i++)
						{

							//echo $v[$i].' - '.$i.' : '.$_POST[$v[$i]]. '; ';

							if($_POST[$v[$i]]=='on')
							{
								$txt_vis.=$v[$i].';';
							}
							else
							{
								$txt_hid.=$v[$i].';';
							}
						}
					}
					$txt_vis.=$txt_hid;
					mysql_query('update users set medals="'.$txt_vis.'" WHERE id="'.$user['id'].'" ;');

					$med = explode("|",$txt_vis);
					$medals[0] = explode(";",$med[0]); //�������� ������
					if(count($med[1]>0))
					{
						$medals[1] = explode(";",$med[1]); //�������� ������
					}

					$new_medals = isset($_POST['Medals']) ? $_POST['Medals'] : array();
					$enabled_medals = array();
					$disabled_medals = array();
					foreach ($new_medals as $_medal_id => $_medal_status) {
						if($_medal_status) {
							$enabled_medals[] = $_medal_id;
						} else {
							$disabled_medals[] = $_medal_id;
						}
					}

					if($enabled_medals) {
						$_data = array(
							'is_enabled' => 1,
						);
						\components\models\UserBadge::whereIn('id', $enabled_medals)
                            ->where('user_id', '=', $user['id'])
                            ->update($_data);
					}
					if($disabled_medals) {
						$_data = array(
							'is_enabled' => 0,
						);
						\components\models\UserBadge::whereIn('id', $disabled_medals)
							->where('user_id', '=', $user['id'])
							->update($_data);
					}
				}




				echo '
		<form action="?edit=1&effects=1" method="POST" name="medal">
		<table align=middle><tr>
			<td><table class="main"><tr>';
				$new_user_medals = \components\models\UserBadge::findByUserIdAll($user['id']);
				$isMedals = ($new_user_medals || strlen($user['medals'])>3);
				if($isMedals) {
					if(strlen($user['medals'])>3)
					{
						foreach($medals as $k=>$v)
						{

							for ($i=0;$i<count($v);$i++)
							{
								if (empty($v[$i])) continue;
								echo '<td  align=center valign=bottom>';
								show_medals($v[$i]);
								echo '<br><br>';
								if(strlen($v[$i])>0)
								{
									if($k==0)
									{
										echo '<input type="checkbox" name="'.$v[$i].'" checked>';
									}
									else
									{
										echo '<input type="checkbox" name="'.$v[$i].'" >';
									}
								}
								echo '</td>';
							}

						}
					}
					$medals_string = '';
					foreach($new_user_medals as $medal) {
						$medals_string .= '<td  align=center valign=bottom>';
						$medals_string .= sprintf('<img src="%s" alt="%s" onmouseout="HideThing(this)" onmouseover="ShowThing(this,25,25,\'%s\')"><br><br>',
							$medal['img'], $medal['alt'], $medal['alt']);

						$medals_string .= sprintf('<input type="hidden" value="0" name="Medals[%s]">', $medal['id']);
						$medals_string .= sprintf('<input type="checkbox" value="1" name="Medals[%s]" %s>',
							$medal['id'], $medal['is_enabled'] ? 'checked' : '');
						$medals_string .= '</td>';
					}
					echo $medals_string;

					echo '<td valign=bottom><input type="hidden" name="save_med" value="yes"> <div class="button-mid btn" onClick="document.medal.submit();">���������</div></td><td align=right width=180></td></tr></table></form>';
				} else {
					echo '<td>� ��� ��� ������� ��� ������.</td></tr></table></td><td align=right width=180></td></tr></table></form>';
				}
				?>
			</div>
		</div>
	</div>
	<script>
		$(function(){
			$('table .head-spoiler-btn').addClass('b');
			$('table[data-hidden="true"] .head-spoiler-btn').removeClass('b').addClass('a');
			$(document.body).on('click', '.spoiler-click', function(){
				var $self = $(this);
				var $spoiler = $self.find('.head-spoiler-btn');

				var $table = $spoiler.closest('table');
				var $td = $table.find('tr td');
				$td.slideToggle('fast');

				if($table.data('hidden') == true) {
					$spoiler.removeClass('a').addClass('b');
					$table.data('hidden', false);
				} else {
					$spoiler.removeClass('b').addClass('a');
					$table.data('hidden', true);
				}
			});
		});
	</script>
	<? include_once "end_files.php"; ?>
	</body>
	</html>
	<?

/////////////////////////////////////////////////////
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////

	die();
}

if($_GET['refer']==1)
{
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
        <link rel="stylesheet" href="/i/btn.css" type="text/css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<script type="text/javascript" src="/i/globaljs.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	</head>
	<link rel="stylesheet" href="/i/btn.css" type="text/css">
	<style>
		body {
			background-color: rgb(226, 224, 224);
		}
		#menu_wrap {
			background-image: url('http://i.oldbk.com/i/i/refer/menu_bg2.jpg');
			background-repeat: repeat-x;
			position: absolute;
			left: 0;
			right: 0;
			height: 33px;
		}
		#menu_wrap .block {
			width: 1055px;
			min-width: 1055px;
			margin: 0 auto;
			position: relative;
			height: 33px;
			overflow: hidden;
		}
		#menu_wrap .block #menu {
			margin: 0;
			padding: 0;
			list-style: none;
			float: left;
			height: 33px;
			background-image: url('http://i.oldbk.com/i/i/refer/menu_bg1.jpg');
			background-repeat: repeat-x;
		}
		#menu_wrap #menu li {
			float: left;
		}
		#menu_wrap div.left, #menu_wrap div.right {
			background-repeat: no-repeat;
			width: 126px;
			height: 33px;
			float: left;
		}
		#menu_wrap div.left {
			background-image: url('http://i.oldbk.com/i/i/refer/decor_left.jpg');
		}
		#menu_wrap div.right {
			background-image: url('http://i.oldbk.com/i/i/refer/decor_right.jpg');
		}
		#menu_wrap #menu li.item {
			font: 11px Tahoma;
			color: #777777;
			min-width: 160px;
			text-align: center;
			padding-top: 9px;
			cursor: pointer;
			width: 200px;
			height: 33px;
			white-space: nowrap;
		}
		#menu_wrap #menu li.item.active {
			color: #66b100;
			background-image: url('http://i.oldbk.com/i/i/refer/menu_hover1.jpg');
		}
		#menu_wrap #menu li.item:not(.active) {
			background-image: url('http://i.oldbk.com/i/i/refer/menu_hover0.jpg')
		}
		#menu_wrap #menu li.item:hover, #menu_wrap #menu li.item.active {
			background-repeat: repeat-x;
			font-weight: bold;
			font-size: 11px;
			padding-top: 9px;
		}
		#menu_wrap .tab {
			width: 1000px;
			margin: 0 auto;
			margin-top: 20px;
			font: 13px Tahoma;
		}
		#menu_wrap table {
			width: 100%;
		}
		#menu_wrap table th {
			background-color: #f1f0f0;
			border: 1px solid #cbcbcb;
			margin: 1px;
			color: #003388;
			font-weight: bold;
			height: 25px;
			font-size: 12px;
		}
		#menu_wrap table.main > tbody > tr > td {
			border: 1px solid #cbcbcb;
			margin: 1px;
			padding: 5px;
			background-color: #e8e6e6;
			color: #323232;
			font-size: 12px;
		}
		#menu_wrap table ul.list {
			list-style: none;
			margin: 0;
			padding: 0;
		}
		#menu_wrap table ul.list li.title {
			color: #003388;
			font-weight: bold;
		}
		#menu_wrap table ul.list li.item {
			background-image: url('http://i.oldbk.com/i/i/refer/dot.gif');
			background-repeat: no-repeat;
			background-position: 0 6px;
			padding-left: 15px;
		}
	</style>
	<body>
	<?
	//make_quest_div();
	if (isset($_POST['cashout']) || isset($_POST['cashout2']) || isset($_POST['cashout3'])) {
		$_GET['txt'] = 1;
	}

	?>
	<div align="right" style="margin:0px;padding:0px;">
		<div class="button-mid btn" onClick="location.href='?edit=1&refer=1';">��������</div>
		<div class="button-mid btn" onClick="location.href='?edit=0.467837356797105';">���������</div>
	</div>


	<div id="menu_wrap">
		<div class="block">
			<div class="left"></div>
			<ul id="menu">
				<li class="item <?php if (!isset($_GET['txt'])) echo 'active'; ?>" data-tab="1">������� ������</li>
				<li class="item" data-tab="2">��������� � OldBK</li>
				<li class="item" data-tab="4">����������� �������</li>
				<li class="item <?php if (isset($_GET['txt'])) echo 'active'; ?>" data-tab="5">�������� ����������� �������</li>
			</ul>
			<div class="right"></div>
		</div>

		<div data-tab-body="1" class="tab" <?php if (isset($_GET['txt'])) echo 'style="display:none;"'; ?>>
			<TABLE class="main">
				<tr>
					<TD>
						<font color=#003388><b>� ����� ���������� ��� �������� ������ - �������, ����������� � ���������.</b></font><br><br>
						�� <font color=#003388><b>"�������"</b></font> ����� ������ ��������������, ������, �������� ������ �����, ���������, ������� � ������ ������� �����������.<br>
						�� <font color=#003388><b>"�����������"</b></font> ����� ������ ������� (����������) ������ � �������������� � �������� "�������" � �������� ������ ������������� ������.<br>
						�� <font color=#003388><b>"���������"</b></font> ����� ������ �������� ��������� � ������, � �������� ������ ��������� � ������������ ������.<br>

						<font color=#003388>�������, ����������� � ��������� ����� ���������� ������� ����� ��� ������ � ����������� <img src="http://i.oldbk.com/i/deal.gif" border=0> <a href="http://capitalcity.oldbk.com/friends.php?pals=3">������� �����</a>.</font><br><br>


						<font color=#003388><b>� ����� ����� ���������� ����������� ��������� �������� �����.</b></font> <br>
						<br><br>
					</td></tr>

			</table>
		</div>

		<div data-tab-body="2" class="tab" style="display:none;">
			<TABLE class="main">
				<tr><Th>
						����������� � ��������� ����� ������ � ����������� <img src="http://i.oldbk.com/i/deal.gif" border=0> <a href="http://capitalcity.oldbk.com/friends.php?pals=3">������� �����</a>.
					</th></tr><tr><td>

						<font color=#003388><b><u>�������</u> ����� ����������:</b></font> <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>������� ���� � ����</b> � ���������� ������ ��������� � ������������ � <a href=http://oldbk.com/encicl/exp.html target=_blank>�������� �����</a> <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>����������� � ����:</b> ��������, ��������� � ������� �������� �������� <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>� ��������� �����:</b> ������ ������� � �������, ��������� � ����������� ��������� ��� ��� ���� ��� �������� ��������� �� ���������<br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>� ���������:</b> ������� ��� �� ������ <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>� ����� ������:</b> ��������� � ����������� ��������� ��� <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>�� �������:</b> ������� ������� �� ���������� �������<br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>� �����:</b> �������� ����� ������������ �� �������<br>
					</td></tr><tr><td>

						<font color=#003388><b><u>���������</u> ����� ����������:</b></font> <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>� ��������� �����:</b> �� ����� �������� � ����, ���������� �������, �������� ��������<br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>� ����������� ����:</b> ������� ��� ��������� �� 5-10-15 ����� ������<br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>� ��������� ���� � ����� � �������� �����:</b> ������� ��������� �� ������ <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>��� ���������� �������</b> ������ � ����� � �� �������<br>
					</td></tr><tr><td>

						<font color=#003388><b><u>�����������</u> ����� ����������:</b></font> <br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>�� �����:</b> ����� ����������� �� ������� � ������ �������<br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> ������� � ���� ������ �� <b>����������� �������</b><br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> ������� � ���� ������ �� <b>�������� ����������� �������</b><br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> � <b>������ ������� �����:</b> ������� ����������� �� ������<br>
					</td></tr><tr><td>

					</td></tr>
			</table>

		</div>

		<div data-tab-body="3" class="tab" style="display:none;">
			<TABLE class="main">
				<tr><TD>
						<font color=#003388><b><u>�������� ������</u> � ����� ����� ����������:</b></font> <br>

						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> ������� � ���� ������ �� <b>�������� ����������� �������</b><br>
						<small>����� �������� �� ���� ����� ��������� � ������� "�������� ����������� �������"</small><br><br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> ������� � ����� ������� �� <b>����������� ���������</b><br>
						<small>����� �������� � ����������� ��������� ����� ��������� <a href=http://oldbk.com/partners/ target=_blank>�����</a>.</small>
					</td></tr></table></center>


		</div>

		<div data-tab-body="4" class="tab" style="display:none;">
			<TABLE class="main">
				<tr><td colspan=3>
						<font color=#003388><b>����������� ������� - ��� ����������� ��������������� ��������� ������������ � ����.</b></font><br><br>
						��� �������� ����� � <b>�����</b>, �� ������������� ��������� ������ <b>����������� ������</b>, ������� ������ ������� ����� ������� � ��������.<br>

						<font color=#003388><b>������ ��������, �������������������� � ����� �� ����� ����������� ������, �� ���������� �� 8�� ������ ������ ��������� ��� �����������</b></font>.<br><br>

						<font color=#003388>��� ���������� ����� ��������� ���������� ������, ��� ������������� ����� ���������� �� ��������������� ����:</font><br>
						
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>10��</b> ������ - <b>40 ���</b><br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>11��</b> ������ - <b>60 ���</b><br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>12��</b> ������ - <b>150 ���</b><br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>13��</b> ������ - <b>250 ���</b><br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <b>14��</b> ������ - <b>400 ���</b><br><br>
					</td>
				</tr>
				<tr>
					<td align=center bgcolor="#A5A5A5">
						<b><font color=#003388>����� �����</font></b>
					</td>
					<td align=center bgcolor="#A5A5A5">
						<b><font color=#003388>���� ����������� ������</font></b>
					</td>
					<td align=center bgcolor="#A5A5A5">
						<b><font color=#003388>���� ��������</font></b>
					</td>
				</tr>

				<?

				$i=0;
				$cheff=mysql_query("SELECT * from  oldbk.`bank` WHERE owner = '".$user['id']."' order by id");
				while($row=mysql_fetch_array($cheff))
				{
					$eff[$i]=$row;
					$i++;
				}

				if(count($eff)>0)
				{
					$i=0;
					$refs=mysql_query("SELECT ur.user,ur.ref,ur.owner, u.id as id,u.login,u.level,u.klan,u.align,id_city from oldbk.users_referals ur
				inner join oldbk.users u
				on u.id = ur.user
				WHERE ur.owner = '".$user['id']."' order by ur.id");
					while($row=mysql_fetch_assoc($refs))
					{
						if($row['id_city']==1)
						{
							$user_ref=check_users_city_data($row['id']);
						}
						else
						{
							$user_ref=$row;
						}
						$rf[$row['ref']][$row['id']]=$user_ref;
					}


					for($i=0;$i<count($eff);$i++)
					{
						echo '<tr>';
						echo '<td width="150" valign=top>&nbsp;&nbsp;'.$eff[$i]['id'].'</td>
					<td valign=top align=left width="300">&nbsp;<b>http://oldbk.com/?fr='.$eff[$i]['id'].'</b>&nbsp;</td><td>&nbsp;&nbsp;';
						if(count($rf[$eff[$i]['id']])>0)
						{
							foreach ($rf[$eff[$i]['id']] as $k=>$v)
							{
								echo s_nick($v['id'],$v['align'],$v['klan'],$v['login'],$v['level']). ' ';
							}
						}
						else
						{
							echo '�� ���� ������ ��� �� ���������������� �� ������ ���������.';
						}
						echo '</td></tr>';
					}
				}
				else
				{
					echo '<tr><td colspan=3>��� ������ �������� ���� � ����� �� ������������ �����. </td></tr>';
				}
				?>
			<tr><td colspan=3>
			* �����! ����������� ���� �������, ��� ������ ������ ���� � ���� ����������� ������� �������, ����� ������ �������� �� �������� ��� �� ������ ������������ ������. ���������� � ����� ��������� � ������������ �� ��� �� ��� ����� �������� �� ����������� �������������� ������ � �����, �� ����� ����������� �� ������ �� ��������.
			</td></tr>
			</TABLE>
                        
		</div>


		<div data-tab-body="5" class="tab" <?php if (!isset($_GET['txt'])) echo 'style="display:none;"'; ?>>
			<center>
				<TABLE class="main">
					<tr><td colspan=2>
							<center>
								<?php
								/*
			if (isset($_POST['cashout'])) {
				$_GET['txt'] = 1;
				$_POST['cashout'] = intval($_POST['cashout']);
				$q = mysql_fetch_assoc(mysql_query('SELECT * FROM rid_users WHERE owner = '.$user['id']));
				if ($q['profit'] >= 5 && $_POST['cashout'] <= $q['profit'] && $_POST['cashout'] > 0) {
					if ($_POST['cashout'] % 5 != 0) {
						err('����� ������ ���� ������ 5');
					} elseif (!isset($_POST['tos'])) {
						err('�� ������ ���� �������� � ��������� ������');
					} else {
						$numcount = 0;
						$nominals = array(25,20,15,10,5);
						$nomvch = array (
							5   => 5005,
							10  => 5010,
							15  => 5015,
							20  => 5020,
							25  => 5025,
						);


						$retmoney = $_POST['cashout'];
						$newret = array();
						while(list($k,$v) = each($nominals)) {
							$z = floor($retmoney / $v);
							if ($z > 0) {
								$newret[$v] = $z;
								$retmoney = $retmoney - ($z*$v);
							}
						}

						$vdress = array();
						$nomlist = "";
						while(list($k,$v) = each($newret)) {
							if (!isset($vdress[$k])) {
								$t = mysql_query('select * from oldbk.shop where id = '.$nomvch[$k]) or die();
								$vdress[$k] = mysql_fetch_array($t);
							}
							$dress = $vdress[$k];
							if ($dress['id'] > 0) {
								for($i = 0; $i < $v; $i++) {
									$nomlist .= $k."$, ";
									mysql_query("INSERT INTO oldbk.`inventory`
										(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
										`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
										`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
										`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`
										)
										VALUES
										('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
										'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
										'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
										,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$us['id']}'
										);
									") or die();
									$numcount++;
								}
							}
						}
	 					if (strlen($nomlist)) {
	 					 	$nomlist = substr($nomlist,0,strlen($nomlist)-2);
							if ($numcount >= 2) {
								$_SESSION['vyvodtxt'] = "������� ������ �������� ".$nomlist;
							} else {
								$_SESSION['vyvodtxt'] = "������� ����� ������� ".$nomlist;
							}
						}
						mysql_query('UPDATE rid_users SET profit = profit - '.$_POST['cashout'].' WHERE owner = '.$user['id']);
						mysql_query('INSERT INTO rid_history (`owner`,`when`,`summa`,`type`) VALUES ("'.$user['id'].'","'.time().'","'.$_POST['cashout'].'","1")');
						echo '<script>location.href="?edit=1&refer=1&txt=1;"</script>';
						die();
					}
				} else {
					err('������������ �������');
				}
			}
			else
			*/
								if (isset($_POST['cashout2'])) {
									$_GET['txt'] = 1;
									$_POST['cashout2'] = round($_POST['cashout2'],2);
									$q = mysql_fetch_assoc(mysql_query('SELECT * FROM rid_users WHERE owner = '.$user['id']));
									if ($q['profit'] > 0 && $_POST['cashout2'] <= $q['profit'] && $_POST['cashout2'] > 0) {
										if (!isset($_POST['tos'])) {
											err('�� ������ ���� �������� � ��������� ������');
										} else {
											$q = mysql_query('SELECT * FROM bank WHERE owner = '.$user['id'].' AND id = '.intval($_POST['banknum']));
											if (mysql_num_rows($q) == 1) {
												$bb = mysql_fetch_assoc($q);
												$_SESSION['vyvodtxt'] = "������� ������ ".$_POST['cashout2']." ���.";
												mysql_query('UPDATE bank SET ekr = ekr + '.$_POST['cashout2'].' WHERE id = '.$bb['id']);
												$bb['ekr'] += $_POST['cashout2'];
												mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�� �������� �� ���� (�����) <b>{$_POST['cashout2']} ���.</b>, �������� <b>0 ���.</b> <i>(�����: {$bb['cr']} ��., {$bb['ekr']} ���.)</i>','{$bb['id']}');");
												mysql_query('UPDATE rid_users SET profit = profit - '.$_POST['cashout2'].' WHERE owner = '.$user['id']);
												mysql_query('INSERT INTO rid_history (`owner`,`when`,`summa`,`type`) VALUES ("'.$user['id'].'","'.time().'","'.$_POST['cashout2'].'","3")');
												echo '<script>location.href="?edit=1&refer=1&txt=1;"</script>';
												die();
											}
										}
									} else {
										err('������������ �������');
									}
								}
								/*
			elseif (isset($_POST['cashout3'])) {
				$_GET['txt'] = 1;
				$_POST['cashout3'] = intval($_POST['cashout3']);
				$q = mysql_fetch_assoc(mysql_query('SELECT * FROM rid_users WHERE owner = '.$user['id']));
				if ($q['profit'] >= 5 && $_POST['cashout3'] <= $q['profit'] && $_POST['cashout3'] > 0) {
					if ($_POST['cashout3'] % 5 != 0) {
						err('����� ������ ���� ������ 5');
					} elseif (!isset($_POST['tos'])) {
						err('�� ������ ���� �������� � ��������� ������');
					} else {
						$numcount = 0;
						$nominals = array(300,200,100,40,25,20,15,5);
						$nomvch = array (
							5   => 100005,
							15  => 100015,
							20  => 100020,
							25  => 100025,
							40  => 100040,
							100 => 100100,
							200 => 100200,
							300 => 100300
						);


						$retmoney = $_POST['cashout3'];
						$newret = array();
						while(list($k,$v) = each($nominals)) {
							$z = floor($retmoney / $v);
							if ($z > 0) {
								$newret[$v] = $z;
								$retmoney = $retmoney - ($z*$v);
							}
						}

						$vdress = array();
						$nomlist = "";
						while(list($k,$v) = each($newret)) {
							if (!isset($vdress[$k])) {
								$t = mysql_query('select * from oldbk.eshop where id = '.$nomvch[$k]) or die();
								$vdress[$k] = mysql_fetch_array($t);
							}
							$dress = $vdress[$k];
							if ($dress['id'] > 0) {
								for($i = 0; $i < $v; $i++) {
									$nomlist .= $k."���, ";
									mysql_query("INSERT INTO oldbk.`inventory`
										(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
										`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
										`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
										`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`
										)
										VALUES
										('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
										'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
										'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
										,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$us['id']}'
										);
									") or die();
									$numcount++;
								}
							}
						}
	 					if (strlen($nomlist)) {
	 					 	$nomlist = substr($nomlist,0,strlen($nomlist)-2);
							if ($numcount >= 2) {
								$_SESSION['vyvodtxt'] = "������� ������ ������� ".$nomlist;
							} else {
								$_SESSION['vyvodtxt'] = "������� ����� ������ ".$nomlist;
							}
						}
						mysql_query('UPDATE rid_users SET profit = profit - '.$_POST['cashout3'].' WHERE owner = '.$user['id']);
						mysql_query('INSERT INTO rid_history (`owner`,`when`,`summa`,`type`) VALUES ("'.$user['id'].'","'.time().'","'.$_POST['cashout3'].'","2")');
						echo '<script>location.href="?edit=1&refer=1&txt=1;"</script>';
						die();
					}
				} else {
					err('������������ �������');
				}
			}
			*/

								if (!empty($_SESSION['vyvodtxt'])) {
									err($_SESSION['vyvodtxt']);
									$_SESSION['vyvodtxt'] = "";
								}

								?>
							</center>

							<font color=#003388><b>�������� ����������� ������� - ��� ����������� ��������� �������� �����, ������������, �������� ������������� ������.</b></font><br><br>

							���� ������ �������� ����������� ������, ������� ������ ������� ����� ������� � ��������, ��������� � "����" ������ ���������.<br>

							<font color=#003388><b>������ ��������, �������������������� � ����� �� ���� ������, ���������� ����� �������� ���������.<br>
									������ $, ������� ��� �������� ������� ������ � ����, �������� ��� �����, ������� �� ������� ������������ �� ������ ����������.</b></font><br><br>

							��� ������ �� ����������� �� <b>�������� ����������� �������</b>, ��� ������ ������ ��� �������� �����������.<br>
							��������� �������� ����������� - <b>5%</b> �� ����� ��������� � ���� ����� �������� ���������.<br>
							<b>������ 100$ ������������ ����</b> � ������ ���� ����������� ������� <b>������� 0.1%</b> � ��� �������� ����������� (�� �� ����� 7% �����������).<br><br>

							<font color=#003388><b>����������� �� �������� ����������� ������� �������� �� ������ ������� �� ��� ���������� ����:</b></font><br>
							<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <img src="http://i.oldbk.com/i/pay_bank.png" border="0"> �������� ����������� �� ���� ���������� ����<br>


						</td></tr>
					<tr><td align=center colspan=2>
							<div style="width:500px;text-align:left;">
								<br>���� ����������� ������: <b>http://oldbk.com/?rid=<?php echo $user['id']; ?></b><BR><BR>
								�������� ���������: <b><?php
									$q = mysql_fetch_assoc(mysql_query('SELECT count(*) as ccount FROM rid_refs WHERE owner = '.$user['id']));
									if (!$q['ccount']) $q['ccount'] = 0;
									echo $q['ccount'];

									?><br>
									<?php
									$q = mysql_fetch_assoc(mysql_query('SELECT * FROM rid_users WHERE owner = '.$user['id']));
									if (!$q) {
										$q['allprofit'] = 0;
										$q['profit'] = 0;
										$q['interest'] = 5.0;
									}

									echo '</b>��� �������� �����������: <b>'.sprintf("%.1f",$q['interest']).'</b><br><br>';
									echo '��������� ���������: <b>'.$q['allprofit'].'$</b><br>';
									echo '�������� ��� ������: <b>'.$q['profit'].'$</b><br>';

									?>

									<?php
									$q = mysql_query('SELECT * FROM bank WHERE owner = '.$user['id']);
									$banko = '';
									if (mysql_num_rows($q)) $banko = '<option value="1">�������� ����������� �� ���������� ����</option>';

									echo '<br><br><script>function chselform(f) {for(i=1;i<4;i++) {document.getElementById("cashout"+i).style.display = "none"; if (f.selectedIndex != 0) document.getElementById("cashout"+f.selectedIndex).style.display = "";} }</script>';
									echo '������� ��������: <select id="chselform" OnChange="chselform(this);" style="width:250px;"><option value="0">�������� ������ ������ �������</option>'.$banko.'

						</select><br><br>';
									/*
						<font color=#003388><i><img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <img src="http://i.oldbk.com/i/pay_vau4.png" border="0"> �������� ������� ������������� ������<br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <img src="http://i.oldbk.com/i/pay_bank.png" border="0"> �������� ����������� �� ���� ���������� ����<br>
						<img src=http://i.oldbk.com/i/i/refer/dot.gif border=0> <img src="http://i.oldbk.com/i/pay_real.gif" border="0"> �������� ������� ��� ������������ ������ �� � �������� ������ ����� ������������ �����</i></font><br><br>


						<option value="2">�������� ������� ������������� ������</option>
						<option value="3">�������� ������� ��� ������ �������� �����</option>
						*/

									$bankopt = '';
									while($b = mysql_fetch_assoc($q)) {
										$bankopt .= '<option value="'.$b['id'].'">'.$b['id'].'</option>';
									}
									echo '<div style="display:none;" id="cashout1"><form method="POST" action="?edit=1&refer=1">';
									echo '����� �����: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="banknum" style="width:120px;">'.$bankopt.'</select>
						<br>����� ������:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="cashout2" value="0" style="width:100px;"> $<br><br>
						<input type="checkbox" name="tos"> � �����������, ��� ���� ������� ��������<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;�� ��������� ���������� ���� <br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="������� ��������">';
									echo '</form></div>';

									echo '<div style="display:none;" id="cashout3"><form method="POST" action="?edit=1&refer=1">';
									echo '����� ������ (������ ���� ������ 5): <input type="text" name="cashout" value="5"> $ <br><br>
						<input type="checkbox" name="tos"> � �����������, ��� ���� �������� �������<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��� ������ �������� ����� ����� ������������ ����� <br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="������� ��������">';
									echo '</form></div>';

									echo '<div style="display:none;" id="cashout2"><form method="POST" action="?edit=1&refer=1">';
									echo '����� ������ (������ ���� ������ 5): <input type="text" name="cashout3" value="5"> $ <br><br>
						<input type="checkbox" name="tos"> � �����������, ��� ���� ������� ��������<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;� �������� ������������� ������ <br><br>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="������� ��������">';
									echo '</form></div><br>';


									?>
							</div>
						</td></tr>

					<tr>
						<td valign=top width=50% style="padding: 0 75px;">

							<table><tr><td colspan="3"  valign=top>
										<center><font color=#003388><b>��������� 10 ���������� �������:</b></font></center></td></tr>
								<?php
								$q = mysql_query('SELECT * FROM rid_sales WHERE owner = '.$user['id'].' ORDER BY id DESC LIMIT 10');
								$i = 1;
								while($t = mysql_fetch_assoc($q)) {
									echo '<tr><td><b>'.$i.'.</b></td><td>'.date("d/m/Y H:i:s",$t['when']).'</td><td>'.$t['bonus'].'</td></tr>';
									$i++;
								}
								?>
								</td>
								</tr></table>
						</td><td valign=top style="padding: 0 75px;">
							<table><tr><td colspan="3"  valign=top>
										<center><font color=#003388><b>��������� 10 ������� �������:</b></font></center></td></tr>
								<?php
								$q = mysql_query('SELECT * FROM rid_history WHERE owner = '.$user['id'].' ORDER BY id DESC LIMIT 10');
								$i = 1;
								while($t = mysql_fetch_assoc($q)) {
									if ($t['type'] == 1) {
										$et = '�������';
									} elseif ($t['type'] == 2) {
										$et = '�������';
									} elseif ($t['type'] == 3) {
										$et = '����';
									}
									echo '<tr><td><b>'.$i.'.</b></td><td>'.$et.'</td><td>'.date("d/m/Y H:i:s",$t['when']).'</td><td>'.$t['summa'].'</td></tr>';
									$i++;
								}
								?>
								</td></tr></table>

						</td></tr></table>

				</td>
				</tr>
				</table>
			</center>
			</td></tr>
			</table>

		</div>
	</div>

	<script>
		$(function(){
			$(document.body).on('click', '#menu li', function(event){
				$('#menu li').removeClass('active');

				var $self = $(this);
				$self.addClass('active');

				if ($self.attr('data-tab') == 5) {
					$("#chselform :first").attr("selected", "selected");
					for(i=1;i<4;i++) {document.getElementById("cashout"+i).style.display = "none";}
				}

				$('#menu_wrap .tab').hide();
				$('#menu_wrap [data-tab-body="'+$self.attr('data-tab')+'"]').show();
			});
		});
	</script>

	<? include_once "end_files.php"; ?>
	</body>
	</html>
	<?

/////////////////////////////////////////////////////
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////

	die();
}





if ($_GET['setshadow'] ) // ������
{
	if((!$_GET['sh_razdel']) or (($user['prem']==0) and ($_GET['sh_razdel']==3)) )
	{
		$_GET['sh_razdel']=4;
	}
	?>
	<!DOCTYPE html>
	<html>
	<HEAD>
		<title></title>
		<link rel="stylesheet" href="newstyle20.css" type="text/css">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<script type="text/javascript" src="/i/globaljs.js"></script>
	</HEAD>
	<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
	<!--444-->
	<?
	make_quest_div();
	$razd_array[4]='����������� ������';
	$razd_array[2]='������ ������';
	if($user['klan']!='') { $razd_array[1]='�������� ������';	}
	if ($user['prem']>0) { $razd_array[3]='������� ������';	}

	$kpm=count($razd_array);
	$kpmw=(int)(100/$kpm);
	?>
	<div id="page-wrapper">
		<div class="btn-control">
			<div class="button-mid btn" onClick="location.href='main.php?edit=<? echo mt_rand(1111,9999);?>';" >���������</div>
		</div>
		<div class="text-head"> ������� ����� ��������� "<?=$user['login']?>"
		</div>

		<table align="center" id="ob" class="table-list" cellspacing="0" cellpadding="0">
			<colgroup>
				<?
				for($i=1;$i<$kpm;$i++)
				{
					echo '<col width="'.$kpmw.'%">';
				}
				?>
			</colgroup>
			<thead>
			<tr class="head-line">
				<?


				$kp=1;
				foreach($razd_array as $k=>$v)
				{
					echo  '<th class="center">';
					if ($kp==1) { echo '<div class="head-left"></div>'; }
					elseif ((($kp==2) and ($razd_array[1]!='' OR  $razd_array[3]!='' ) ) )
					{
						echo '<div class="head-separate left"></div>';
					}


					if ($k==$_GET['sh_razdel'])
					{
						//�������� ����
						echo '<div class="head-title"><span class="active">'.$v.'</span></div>';
					}
					else
					{
						//����������
						echo '<a href="/main.php?edit='.mt_rand(1111,9999).'&setshadow=1&sh_razdel='.$k.'">'.$v.'</a>';
					}
					if ((($kp==2) and ($razd_array[1]!='' OR  $razd_array[3]!='' ) ) OR (($kp==3) and ($razd_array[3]!='' ) ) 	)
					{
						//���� ���� ��� �������
						echo '<div class="head-separate right"></div>';
					}
					elseif ($kp!=1)
					{
						echo '<div class="head-right"></div>';
					}
					echo "</th>\n";
					$kp++;
				}

				//echo $kp;
				?>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td colspan="<? echo ($kp-1);?>">
					<table style="width: 100%" class="obraz-list" cellspacing="0" cellpadding="0">
						<colgroup>
							<col width="90px">
							<col width="auto">
							<col width="90px">
						</colgroup>
						<tbody>
						<tr>
							<td class="row-left"></td>
							<td class="row-center">

								<?
								{
									$chrzd=check_razdel($_GET['sh_razdel'],$user,$klan,1);
									echo "<div align=center>".$chrzd[txt1].'</div>' ;
									
									
									
									echo '                                    <ul class="obraz-items">';
									if ($chrzd['sql']!='')
									{
										$sql='select * from oldbk.users_shadows where '.$chrzd['sql']. ';';

										$data=mysql_query($sql);
										$err=mysql_error();
										if ($err)
										{
											$fp = fopen ("/www/other/4818.txt","a"); //��������
											flock ($fp,LOCK_EX); //���������� �����
											fputs($fp ,$sql."\n".$err."\n"); //������ � ������
											fflush ($fp); //�������� ��������� ������ � ������ � ����
											flock ($fp,LOCK_UN); //������ ����������
											fclose ($fp); //��������
										}
										$g=0;
										while($row=mysql_fetch_assoc($data))
										{
											$pers_shadow[$g]=$row;
											$g++;
										}
									}
									if(count($pers_shadow)>0)
									{

										for($r=0;$r<(ceil(count($pers_shadow)));)
										{

											//	for($c=0;$c<5;$c++)
											{
												echo '<li class="obraz-item">
			                	                            <div class="obraz-item-head">
										<img src="http://i.oldbk.com/i/shadow/'.($chrzd[1]==1?($pers_shadow[$r]['sex']==1?'m':'g'):'').$pers_shadow[$r]['name'].'.gif">
			                                	            </div>
			                                        	    <div class="obraz-item-footer">
			                                                	<div class="button-mid btn" >'.($pers_shadow[$r]!=''?'<a href="?edit=1&obraz='.$pers_shadow[$r]['id'].'&sh_razdel='.$_GET['sh_razdel'].'">���������</a>':'').'</div>
				                                            </div>
			        	                                </li>';
												$r++;
											}
										}
									}
									else
									{
										echo $chrzd['txt'];
									}
								}
								/* ��������� �� ��� ��� � ��� ����
                   elseif($_GET['sh_razdel'] == 5)
		    {
		               	  if (count($klan_img)>0)
							{
							?>
								<script>
								function subm(id)
								{

									var targetform = document.getElementById(id);
									targetform.submit();
								}
								</script>
								<table width=100%>
									<tr>
										<td>
											<h3>�������� ���� � �������� �������� �������� ������.</h3>
										</td>
										<td align=right>
										</td>
									</tr>
									<tr>
										<td align=center style="color:red;">



											<table>
												<tr>


												<? for($gg=0;$gg<count($klan_img);$gg++)
												{
					                                echo '<td><form name="img_'.$klan_img[$gg]['id'].'" action="?edit=1" method="post" id="img_'.$klan_img[$gg]['id'].'">
					                                	  <input name="setshadowclan" type="hidden" value="1">
					                                	  <input name="img" type="hidden" value="'.$klan_img[$gg]['img'].'">';

													echo '<img src=http://i.oldbk.com/i/sh/'.$klan_img[$gg]['img'].'><br>';
										            echo "<a onclick=\"subm('img_".$klan_img[$gg]['id']."');\" href=#><small>��������</small></a>";
										            echo '</form></td>';
												}
												?>

												</tr>
											</table>

										</td>
									</tr>
								</table>
								<?
							}

		           }
                   */


								?>


								</ul>


							</td>
							<td class="row-right"></td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			</tbody>
			<tfoot>
			<tr class="obraz-footer">
				<td class="">
					<div class="footer-left"></div>
				</td>
				<?
				for ($i=3;$i<$kp;$i++)
				{
					echo    '
			             <td class="">
		                    <div class="footer-center"></div>
                			</td>';
				}
				?>
				<td class="">
					<div class="footer-right"></div>
				</td>
			</tr>
			</tfoot>
		</table>
		<div class="block-hint">
			������ � �������� ������ ��� ������ ��������� ����� ���������� � <a href="http://oldbk.com/commerce/index.php" target="_blank">������������ ������</a>
		</div>
	</div>
	<? include_once "end_files.php"; ?>
	</body>
	</html>
	<?php

/////////////////////////////////////////////////////
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////

	die();
}

/*else if ($_GET['setshadow'])
	{
	 err('<center>� ��� ��� ������� ��� ������!</center>');

	} */

//



if (@$_GET['setch'])
{
	if(!$_SESSION['beginer_quest']['none'])
	{
		$last_q=check_last_quest(4);
		if($last_q)
		{
			$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
			quest_check_type_4($last_q);
			//��������� ������ �� ���-�
		}

		$last_q=check_last_quest(2);
		if($last_q)
		{
			//ECHO '2  TESTSTSTE EDF';
			quest_check_type_2($last_q);
			//��������� ������ �� ���-�
		}
		if(!$_SESSION['beginer_quest']['none'])
		{
			$last_q=check_last_quest(5);
			if($last_q)
			{
				quest_check_type_5($last_q);
				//��������� ������ �� ���-�
			}
		}
	}

	if (!($online = $memcache->get("onlinecityall1"))) {
		$q = mysql_query("select room, count(id) as kol from `users`  WHERE `ldate` >= ".(time()-80)." GROUP by room");
		$online = GetMCacheFromQuery($q);
		$memcache->set("onlinecityall1",$online,0,60);
	}

	if (!($_classes_in_game = $memcache->get("onlinecityallclasses"))) {
		$_classes_in_game = [
			1 => 0,
			2 => 0,
			3 => 0,
			4 => 0,
			'total' => 0
		];

		$q = mysql_query("select count(id) as kol, uclass from `users`  WHERE `ldate` >= ".(time()-80)." GROUP by uclass");
		$online_classes = GetMCacheFromQuery($q);

		while(list($k,$v) = each($online_classes))
		{
			$_classes_in_game['total'] += $v['kol'];
			if(in_array($v['uclass'], [1, 2, 3])) {
				$_classes_in_game[$v['uclass']] += $v['kol'];
			} else {
				$_classes_in_game[4] += $v['kol'];
			}
		}
		$memcache->set("onlinecityallclasses",$_classes_in_game,0,60);
	}

	$all_in_the_game=0;
	while(list($k,$v) = each($online))
	{
		$or[$v['room']]=$v['kol'];
		$all_in_the_game+=$v['kol'];//
	}

	//region add other to uvorot class count
	if((int)($all_in_the_game * 1.08) > $_classes_in_game['total']) {
		$_classes_in_game[1] += (int)($all_in_the_game * 1.08) - $_classes_in_game['total'];
	} else {
		$_classes_in_game[1] -= $_classes_in_game['total'] - (int)($all_in_the_game * 1.08);
	}
	//endregion

	?>
	<!DOCTYPE html>
	<html xmlns="http://www.w3.org/1999/html">
	<HEAD>
		<link rel="stylesheet" href="newstyle20.css" type="text/css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
		<script type="text/javascript" src="/i/globaljs.js"></script>
		<style>
			.ahm {
				FONT-WEIGHT: bold; COLOR: #003388; TEXT-DECORATION: none
			}
			.ahm:visited {
				FONT-WEIGHT: bold; C
			OLOR: #003388; TEXT-DECORATION: none
			}
			.ahm:active {
				COLOR: #6f0000
			}
			.ahm:hover {
				COLOR: #0066ff
			}
		</style>


	</HEAD>

	<body id="body" leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>)">
	<!--555-->
	<?
	make_quest_div();
	?>
	<script src="i/jquery.drag.js" type="text/javascript"></script>
	<script>


		function inforoom(id,event)
		{
			if (window.event)
			{
				event = window.event;
			}
			if (event && event.ctrlKey)
			{
				window.open('ch.php?online=1&scan=1&room='+id, 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes');
			}
			else
			{
				$.get('infroom.php?room='+id+'&online=1&scan=1', function(data) {
					$('#pl_list').html(data);
					$('#pl_list').show(200, function() {
					});
				});
			}

		}

		function closeinfo()
		{
			$('#pl_list').hide(200);
		}

		top.changeroom=<?=$user['room']?>;

	</script>
	<div id="pl_list" style="z-index: 300; position: absolute; left: 50px; top: 30px;
				width: 400px; background-color: #eeeeee; cursor: move;
				border: 1px solid black; display: none;">

	</div>




	<?
	$active=array();
	$active[$user['room']]='<div class="active"></div>';
	$_online_string_ = sprintf('����������� <strong>%d</strong>, ���������� <strong>%d</strong>, ������ <strong>%d</strong>, ��� ������ <strong>%d</strong>', $_classes_in_game[1], $_classes_in_game[2], $_classes_in_game[3], $_classes_in_game[4]);

	echo '
<div id="page-wrapper" class="map-wrapper">
    <div class="btn-control">
        <div class="left-text">
        <div class="nickname-wrapper"><strong>'.s_nick($user['id'],$user['align'],$user['klan'],$user['login'],$user['level']).'</strong></div>
	    <div class="text-title">����� �����</div>
            <div class="hint-text">(������ � ����: <strong>'.((int)($all_in_the_game*1.08)).'</strong> ����������: '.$_online_string_.')</div>
        </div>
	<div class="button-mid btn" name="setch" title="��������" onClick="location.href=\'main.php?setch=1&tmp='.mt_rand(1111,9999).'\';">��������</div>
	<div class="button-mid btn" name="combats" title="��������" onClick="location.href=\'zayavka.php\';"><strong>��������</strong></div>
	<div class="button-mid btn" name="invent" title="��������� / ���������" onClick="location.href=\'main.php?edit=1\';">���������</div>
	<div class="button-mid btn" name="effects" onclick="location.href=\'?edit=1&effects=1\'" value="���������" title="���������">���������</div>
	<div class="button-dark-mid btn" name="helps" onClick="window.open(\'help/combats.html\', \'help\', \'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes\')" title="���������">���������</div>
	<div class="button-mid btn" name="backpage" onClick="location.href=\'main.php\';" title="���������">���������</div>
    </div>
        <div class="btn-control">';
	if ($user['room']==20)
	{
		echo '<img src="http://i.oldbk.com/i/world_map2/flag_position.png" border=0>';
	}
	echo '<div class="button-big btn" name="backpage" onClick="location.href=\'main.php?goto=plo\';" title="����� �� ����������� �������">����� �� ����������� �������</div>
	</div>
    <div class="hr_n"></div>
    <table align="center" class="table-list map" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo novi4ki"></div>
                        <div class="map-block-mid novi4ki">
                            <div class="map-block-head">
                                ������� ��� �������� 1 <div class="head-level">(������� 0)</div>
				'.$active[1].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room1='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[1]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(1,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right novi4ki"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo novi4ki"></div>
                        <div class="map-block-mid novi4ki">
                            <div class="map-block-head">
                                ������� ��� �������� 2 <div class="head-level">(������� 0)</div>
				'.$active[2].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room2='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[2]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(2,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right novi4ki"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo novi4ki"></div>
                        <div class="map-block-mid novi4ki">
                            <div class="map-block-head">
                                ������� ��� �������� 3 <div class="head-level">(������� 0)</div>
				'.$active[3].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room3='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[3]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(3,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right novi4ki"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo novi4ki"></div>
                        <div class="map-block-mid novi4ki">
                            <div class="map-block-head">
                                ������� ��� �������� 4 <div class="head-level">(������� 0)</div>
				'.$active[4].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room4='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[4]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(4,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right novi4ki"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo voinov"></div>
                        <div class="map-block-mid voinov">
                            <div class="map-block-head">
                                ��� ������ 1 <div class="head-level">(������� 1-3)</div>
				'.$active[5].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room5='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[5]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(5,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right voinov"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo voinov"></div>
                        <div class="map-block-mid voinov">
                            <div class="map-block-head">
                                ��� ������ 2 <div class="head-level">(������� 1-3)</div>
				'.$active[6].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room6='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[6]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(6,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right voinov"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo voinov"></div>
                        <div class="map-block-mid voinov">
                            <div class="map-block-head">
                                ��� ������ 3 <div class="head-level">(������� 1-3)</div>
				'.$active[7].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room7='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[7]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(7,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right voinov"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo torgovij"></div>
                        <div class="map-block-mid torgovij">
                            <div class="map-block-head">
                                �������� ��� <div class="head-level">(������� 4-21)</div>
				'.$active[8].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room8='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[8]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(8,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right torgovij"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo rycarskij"></div>
                        <div class="map-block-mid rycarskij">
                            <div class="map-block-head">
                                ��������� ��� <div class="head-level">(������� 4-6)</div>
				'.$active[9].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room9='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[9]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(9,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right rycarskij"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo bashnja"></div>
                        <div class="map-block-mid bashnja">
                            <div class="map-block-head">
                                ����� �������-����� <div class="head-level">(������� 7-9)</div>
				'.$active[10].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room10='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[10]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(10,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right bashnja"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo koldovskoj"></div>
                        <div class="map-block-mid koldovskoj">
                            <div class="map-block-head">
                                ���������� ��� <div class="head-level">(������� 10-12)</div>
				'.$active[11].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room11='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[11]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(11,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right koldovskoj"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo eduhov"></div>
                        <div class="map-block-mid eduhov">
                            <div class="map-block-head">
                                ���� ����� <div class="head-level">(������� 13-15)</div>
				'.$active[12].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room12='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[12]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(12,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right eduhov"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo astral"></div>
                        <div class="map-block-mid astral">
                            <div class="map-block-head">
                                ���������� ����� <div class="head-level">(������� 16-19)</div>
				'.$active[13].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room13='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[13]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(13,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right astral"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo fire"></div>
                        <div class="map-block-mid fire">
                            <div class="map-block-head">
                                �������� ��� <div class="head-level">(������� 19-21)</div>
				'.$active[14].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room14='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[14]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(14,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right fire"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo paladinov"></div>
                        <div class="map-block-mid paladinov">
                            <div class="map-block-head">
                                ��� ���������
				'.$active[15].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room15='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[15]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(15,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right paladinov"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo sovet"></div>
                        <div class="map-block-mid sovet">
                            <div class="map-block-head">
                                ����� ������ ��������
				'.$active[16].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room16='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[16]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(16,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right sovet"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo tma"></div>
                        <div class="map-block-mid tma">
                            <div class="map-block-head">
                                ��� ����
				'.$active[17].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room17='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[17]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(17,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right tma"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo netral"></div>
                        <div class="map-block-mid netral">
                            <div class="map-block-head">
                                ��� ������
				'.$active[36].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room36='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[36]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(36,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right netral"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo svet"></div>
                        <div class="map-block-mid svet">
                            <div class="map-block-head">
                                ��� �����
				'.$active[54].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room54='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[54]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(54,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right svet"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo buduar"></div>
                        <div class="map-block-mid buduar">
                            <div class="map-block-head">
                                ������ <div class="head-level">(������� 1-21)</div>
				'.$active[19].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room19='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[19]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(19,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right buduar"></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo tma2"></div>
                        <div class="map-block-mid tma2">
                            <div class="map-block-head">
                                ������� ����
				'.$active[18].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room18='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[18]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(18,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right tma2"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo netral2"></div>
                        <div class="map-block-mid netral2">
                            <div class="map-block-head">
                                ������� ������
				'.$active[56].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room56='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[56]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)"  onClick="inforoom(56,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right netral2"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo svet2"></div>
                        <div class="map-block-mid svet2">
                            <div class="map-block-head">
                                ������� �����
				'.$active[55].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room55='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[55]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(55,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right svet2"></div>
                    </div>
                </td>
                <td>
                    <div class="map-block">
                        <div class="map-block-logo clanwars"></div>
                        <div class="map-block-mid clanwars">
                            <div class="map-block-head">
                                ��� �������� ���� <div class="head-level">(������� 4-21)</div>
				'.$active[57].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room57='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[57]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(57,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right clanwars"></div>
                    </div>
                </td>
            </tr>';


	if (($user['klan']=='Adminion')OR($user['klan']=='radminion')OR($user['klan']=='testTest')OR($user['id']==188) or ($user['id']>370686 and $user['id']<370713 and $user['id']!=370711 and $user['id']!=370688 and $user['id']!=370708 and $user['id']!=370703 and $user['id']!=370692 and $user['id']!=370693 and $user['id']!=370694 and $user['id']!=370695))
	{
		echo '
		<tr>
		<td>
                    <div class="map-block">
                        <div class="map-block-logo netral2"></div>
                        <div class="map-block-mid netral2">
                            <div class="map-block-head">
                                �������� �������
				'.$active[44].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room44='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[44]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(44,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right netral2"></div>
                    </div>
                </td>';

		if (($user['id'] == 8540)  )
		{

			echo '
		<td>
                    <div class="map-block">
                        <div class="map-block-logo netral2"></div>
                        <div class="map-block-mid netral2">
                            <div class="map-block-head">
                                �������
				'.$active[75].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������" onClick="location.href=\'main.php?setch=1&got=1&room75='.mt_rand(1111,9999).'\';">�����</div><div class="room-amount">&nbsp;('.(int)($or[75]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(75,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right netral2"></div>
                    </div>
                </td>';

		}
		//��������! � ������� ������������ ��� ������� ������ ������������ ���������, ��� ������� �� ������ ��������� �������� � ���� ����� ����� �������������. ������� ������ � ������������� �� ��� ����� �����
		echo '
		<td>
                    <div class="map-block">
                        <div class="map-block-logo voinov"></div>
                        <div class="map-block-mid voinov">
                            <div class="map-block-head">
                                ��� �������
				'.$active[76].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������"  '."OnClick=\"if (!confirm('������� �������!')) { return false; } else { location.href='main.php?setch=1&got=1&room76=".mt_rand(1111,9999)."' } \"  ".'>�����</div><div class="room-amount">&nbsp;('.(int)($or[76]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(76,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right voinov"></div>
                    </div>
                </td>';

		echo '</tr>';
	}
	else
		{
		/*
		echo '
		<tr>
		<td>';
		echo '
		<td>
                    <div class="map-block">
                        <div class="map-block-logo voinov"></div>
                        <div class="map-block-mid voinov">
                            <div class="map-block-head">
                                ��� �������
				'.$active[76].'
                            </div>
                            <div class="map-block-bottom">
                                <div class="button-mid btn" name="setch" title="����� � �������"  '."OnClick=\"if (!confirm('��������! � ������� ������������ ��� ������� ������ ������������ ���������, ��� ������� �� ������ ��������� �������� � ���� ����� ����� �������������. ������� ������ � ������������� �� ��� ����� �����!')) { return false; } else { location.href='main.php?setch=1&got=1&room76=".mt_rand(1111,9999)."' } \"  ".'>�����</div><div class="room-amount">&nbsp;('.(int)($or[76]).')</div>
                                <div class="room-info">
                                    <a href="javascript:void(0)" onClick="inforoom(76,event);"><img src="http://i.oldbk.com/i/world_map2/i_2.jpg"></a>
                                </div>
                            </div>
                        </div>
                        <div class="map-block-right voinov"></div>
                    </div>
                </td>';
		echo '</tr>';		
		*/

		
		
		}
	
	



	echo '</tbody>
    </table>
</div>';



	?>
	<div align=right>

		<!--LiveInternet counter--><script type="text/javascript"><!--
			document.write("<a href='http://www.liveinternet.ru/click' "+
					"target=_blank><img src='http://counter.yadro.ru/hit?t54.2;r"+
					escape(document.referrer)+((typeof(screen)=="undefined")?"":
					";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
							screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
					";"+Math.random()+
					"' alt='' title='LiveInternet: �������� ����� ���������� �"+
					" ����������� �� 24 ����' "+
					"border='0' ><\/a>")
			//--></script><!--/LiveInternet-->


		<!--Rating@Mail.ru counter-->
		<script language="javascript" type="text/javascript"><!--
			d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
		<script language="javascript1.1" type="text/javascript"><!--
			a+=';j='+navigator.javaEnabled();js=11;//--></script>
		<script language="javascript1.2" type="text/javascript"><!--
			s=screen;a+=';s='+s.width+'*'+s.height;
			a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
		<script language="javascript1.3" type="text/javascript"><!--
			js=13;//--></script><script language="javascript" type="text/javascript"><!--
			d.write('<a href="http://top.mail.ru/jump?from=1765367" target="_blank">'+
					'<img src="http://df.ce.ba.a1.top.mail.ru/counter?id=1765367;t=49;js='+js+
					a+';rand='+Math.random()+'" alt="�������@Mail.ru" border="0" '+
					'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
		<noscript><a target="_blank" href="http://top.mail.ru/jump?from=1765367">
				<img src="http://df.ce.ba.a1.top.mail.ru/counter?js=na;id=1765367;t=49"
					 height="31" width="88" border="0" alt="�������@Mail.ru"></a></noscript>
		<script language="javascript" type="text/javascript"><!--
			if(11<js)d.write('--'+'>');//--></script>
		<!--// Rating@Mail.ru counter--></div>
<?php

if(!$_SESSION['beginer_quest']['none'])
{
	$last_q=check_last_quest(4);
	if($last_q)
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
		quest_check_type_4($last_q);
		//��������� ������ �� ���-�
	}

	$last_q=check_last_quest(2);
	if($last_q)
	{
		//ECHO '2  TESTSTSTE EDF';
		quest_check_type_2($last_q);
		//��������� ������ �� ���-�
	}
	if(!$_SESSION['beginer_quest']['none'])
	{
		$last_q=check_last_quest(5);
		if($last_q)
		{
			quest_check_type_5($last_q);
			//��������� ������ �� ���-�
		}
	}
}

?>
	<? include_once "end_files.php"; ?>
	</body>
	</html>
	<?php

/////////////////////////////////////////////////////
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////

	die();
}

//=======================================���������===================================================================



// ������


if (($_SESSION['boxisopen']!='open') AND (@$_GET['edit']))
{
	//i have ��� ?
	$effect88 = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '88' LIMIT 1;"));
	if ($effect88[id]>0)
	{
		if (isset($_POST['enterbox']))
		{
			// check pass
			if ($effect88[add_info]==$_POST['boxpass'])
			{
				//del eff
				mysql_query("DELETE FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '88' LIMIT 1;");
				$_SESSION['boxisopen']='open';
				unset($entform);
				//
			}
			else
			{
				$errbox='<font color=red>������: ������������ ������!</font>';
				$entform=true;
			}
		}
		else
		{
			$entform=true;
		}

		if ($entform)
		{
			// ���� ����
			unset($_GET['edit']);
			?>
			<HTML>
			<HEAD>
				<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
                <link rel="stylesheet" href="/i/btn.css" type="text/css">
				<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
				<META Http-Equiv=Cache-Control Content=no-cache>
				<meta http-equiv=PRAGMA content=NO-CACHE>
				<META Http-Equiv=Expires Content=0>
				<script type="text/javascript" src="/i/globaljs.js"></script>
			</HEAD>
			<script type="text/javascript" src="http://i.oldbk.com/i/showthing.js"></script>
			<body bgcolor=e2e0e0>
			<!--6666-->
			<?
			make_quest_div();
			?>
			<div align=right>
				<?
				if (($user['room']==22) OR ($user['room']==23) OR ($user['room']==35) OR ($user['room']==25) OR ($user['room']==27) )
				{
					echo "<FORM action=\"city.php\" method=\"GET\"><p><INPUT TYPE=\"submit\" value=\"���������\" name=\"cp\"></p></form>";
				}
				else
				{
					echo "<FORM ACTION=\"main.php\" METHOD=POST><p><INPUT TYPE=submit value=\"���������\" name='back'></P></form>";
				}
				?>
			</div>
			<H3>�����</H3>
			<? echo "$errbox"; ?>
			<BR>
			<FORM ACTION="main.php?edit=1" METHOD=POST>
				������� ������ ������� � ���������
				<INPUT TYPE=hidden name=edit value=1>
				<INPUT TYPE=password name=boxpass>
				<INPUT TYPE=submit name=enterbox value="�����">
			</FORM>
			<BR><BR>

			<? include_once "end_files.php"; ?>
			</BODY>
			</HTML>
			<?

/////////////////////////////////////////////////////
			if (isset($miniBB_gzipper_encoding)) {
				$miniBB_gzipper_in = ob_get_contents();
				$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
				$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
				$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
				$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
				$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
				$percent = round($gzpercent);
				$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
				$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
				ob_clean();
				header('Content-Encoding: '.$miniBB_gzipper_encoding);
				echo $miniBB_gzipper_out;
			}
/////////////////////////////////////////////////////

			die("");
		}
	}
	else
	{
		//� ���� ��� ������ - ��� �� �����������
		//���������� � ����������
		//$_SESSION['boxisopen']='open';
	}
}

if ((@$_GET['edit'])AND($_SESSION['boxisopen']=='open')) {

	if(isset($_GET['up']) && !empty($_GET['up'])) {

		if($_GET['up']==1){
			$stats=array('sila','lovk','inta','vinos','intel','mudra');
			$add=array();
			for($jjj=0;$jjj<count($stats);$jjj++)
			{
				$add[$stats[$jjj]]=((int)$_GET[$stats[$jjj]]>0?$_GET[$stats[$jjj]]:0);
			}

			/* $sila=((int)$_GET['sila']>0?$_GET['sila']:0);
		        $lovk=((int)$_GET['lovk']>0?$_GET['lovk']:0);
		        $inta=((int)$_GET['inta']>0?$_GET['inta']:0);
		        $vinos=((int)$_GET['vinos']>0?$_GET['vinos']:0);
	            $intel=((int)$_GET['intel']>0?$_GET['intel']:0);
                $mudra=((int)$_GET['mudra']>0?$_GET['mudra']:0);
                 */
			//�� ��������� ����������� ������ - ������� ���������� ����� �������� �� �����, ���� ���� � ���� ������ ��������� ������...
			if ($add['sila']>0) { setup_user_stats("sila",$add['sila']);}
			elseif  ($add['lovk']>0)  { setup_user_stats("lovk",$add['lovk']);}
			elseif  ($add['inta']>0)  { setup_user_stats("inta",$add['inta']);}
			elseif  ($add['vinos']>0)  { setup_user_stats("vinos",$add['vinos']);}
			elseif  ($add['intel']>0)  { setup_user_stats("intel",$add['intel']);}
			elseif  ($add['mudra']>0)  { setup_user_stats("mudra",$add['mudra']);}

		}

		switch ($_GET['up']) {
			case 21 :
				if ($user['master'] >0 && $user['noj'] < 5)	mysql_query("UPDATE `users` SET `noj` = `noj`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' AND noj < 5 LIMIT 1;");
				break;
			case 22 :
				if ($user['master'] >0 && $user['mec'] < 5)	mysql_query("UPDATE `users` SET `mec` = `mec`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' AND mec < 5 LIMIT 1;");
				break;
			case 23 :
				if ($user['master'] >0 && $user['dubina'] < 5)	mysql_query("UPDATE `users` SET `dubina` = `dubina`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' AND dubina < 5 LIMIT 1;");
				break;
			case 24 :
				if ($user['master'] >0 && $user['topor'] < 5)	mysql_query("UPDATE `users` SET `topor` = `topor`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' AND topor < 5 LIMIT 1;");
				break;
			case 25 :
				if ($user['master'] >0)	mysql_query("UPDATE `users` SET `mfire` = `mfire`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
				break;
			case 26 :
				if ($user['master'] >0)	mysql_query("UPDATE `users` SET `mwater` = `mwater`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
				break;
			case 27 :
				if ($user['master'] >0)	mysql_query("UPDATE `users` SET `mair` = `mair`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
				break;
			case 28 :
				if ($user['master'] >0)	mysql_query("UPDATE `users` SET `mearth` = `mearth`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
				break;
			case 29 :
				if ($user['master'] >0)	mysql_query("UPDATE `users` SET `mlight` = `mlight`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
				break;
			case 210 :
				if ($user['master'] >0)	mysql_query("UPDATE `users` SET `mgray` = `mgray`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
				break;
			case 211 :
				if ($user['master'] >0)	mysql_query("UPDATE `users` SET `mdark` = `mdark`+1, `master`=`master`-1 WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
				break;
		}
	}

	if (isset($_GET['drop'])) {
		$_GET['drop']=(int)$_GET['drop'];
		dropitem($_GET['drop']);
		//ref_drop ($user['id']);
	}
	if (isset($_GET['dress'])) {
		if ($user['ruines'] > 0) {
			if (!isset($_SESSION['ruinesactivity']['dress'])) {
				$_SESSION['ruinesactivity']['dress'] = 1;
				$q = mysql_query('SELECT * FROM ruines_activity_log WHERE mapid = '.$user['ruines'].' and owner = '.$user['id'].' and var = "dress"');
				if (mysql_num_rows($q) == 0) {
					mysql_query('INSERT INTO ruines_activity_log (mapid,owner,var,val) VALUES("'.$user['ruines'].'","'.$user['id'].'","dress","1")');
				}
			}
		}

		$_GET['dress']=(int)($_GET['dress']);
		dressitem($_GET['dress']);
		//ref_drop ($user['id']);
	}

	if(isset($_GET['pocket'])) {
		$in_out = (int)$_GET['pocket'];
		$item = (int)$_GET['item'];
		$result = put_into_pocket($in_out, $item);
	}

//start edit bf fred for setup stats
	if ($_GET['setup']) {
		$_GET['setup']=(int)$_GET['setup'];
		if($_GET['st_count']>1){
			$_GET['st_count']=floor((int)$_GET['st_count']);
		}
		else
		{
			$_GET['st_count']=1;
		}
		if (isset($_GET['sila'])) { setupitem($_GET['setup'],"sila",$_GET['st_count']);}
		else if (isset($_GET['lovk']))  { setupitem($_GET['setup'],"lovk",$_GET['st_count']);}
		else if (isset($_GET['inta']))  { setupitem($_GET['setup'],"inta",$_GET['st_count']);}
		else if (isset($_GET['intel']))  { setupitem($_GET['setup'],"intel",$_GET['st_count']);}
		else if (isset($_GET['gmp']))  { setupitem($_GET['setup'],"mp",$_GET['st_count']);}
	}
	else
		if ($_GET['mfsetup']) {
			$_GET['mfsetup']=round((int)$_GET['mfsetup']);

			$kr=(int)$_GET['krit'];
			$akr=(int)$_GET['akrit'];
			$uv=(int)$_GET['uvorot'];
			$auv=(int)$_GET['auvorot'];


			if ($kr>0) { setupitemmf($_GET['mfsetup'],"krit",$kr);}
			elseif ($akr>0)  { setupitemmf($_GET['mfsetup'],"akrit",$akr);}
			else if ($uv>0)  { setupitemmf($_GET['mfsetup'],"uvorot",$uv);}
			else if ($auv>0)  { setupitemmf($_GET['mfsetup'],"auvorot",$auv);}
		}
	////fin
	/*
		Array ( [destruct] => 1 [set] => 3001 [count] => 2 )
		Array ( [edit] => 1 [razdel] => 5 [destruct] => 3001 )

		Array ( [destruct] => 1 [set] => 98 [count] => 2 )
		Array ( [edit] => 1 [razdel] => 1 [destruct] => 98 )
		  */
	/*
    print_r($_GET);
    echo '<br>';
    print_r($_POST);
     */
	if($_POST['destruct']==1)
	{
		$_GET['destruct']=(int)$_POST['set'];
	}
	if (@$_GET['destruct'])
	{
		//print_r($_POST); echo '<br>';
		//print_r($_GET);
		$_GET['destruct']=(int)($_GET['destruct']);
		//group item drop by Umk
		if((int)$_POST['set']&&(int)$_POST['count'])
		{
			$_POST['count']=(int)$_POST['count'];
			//[gift] => 0 [dur] => 0 [destruct] => 1 [set] => 97 [count] => 3


			if($_POST['gift']==0)
			{
				$sql='AND present = ""';
			}
			else
			{
				$sql='AND present != ""';
			}
			$delo_str='id:(';
			$del_sql='';
			$sk='SELECT * FROM oldbk.inventory WHERE
       			`owner` = '.$_SESSION['uid'].' AND `group` = 1 '.$sql.' AND duration = '.(int)$_POST['dur'].'
       			AND `prototype` = '.$_GET['destruct'].' AND
       			`dressed` = 0 AND `setsale` = 0 AND present != "�������� �����" AND bs_owner='.$user['in_tower'].' LIMIT '.$_POST['count'].';';
			//echo $sk;
			$cc=0;
			$drop=mysql_query($sk);
			while($row=mysql_fetch_assoc($drop))
			{
				if (!$row['can_drop']) continue;

				$issart = 0;
				if ((($drs['ab_uron'] > 0 || $drs['ab_bron'] > 0 || $drs['ab_mf'] > 0 || $drs['art_param'] != "")  AND $drs['type'] != 30) || ($drs['type'] == 30 && $drs['up_level'] > 5) || $drs['prototype'] == 3003092 || $drs['prototype'] == 3003093 || $drs['prototype'] == 111000 || $drs['prototype'] == 509 || $drs['prototype'] == 3003227 || $drs['prototype'] == 12802 || $drs['prototype'] == 3003226 || $drs['prototype'] == 3003228) {
					$issart = 1;
				}

				if (!$issart || ($issart && ($user['in_tower'] > 0 || $drs['labonly'] > 0))) {
				} else {
					continue;
				}

				$delo_str.=get_item_fid($row).',';
				$item_name=$row['name'];
				$del_sql.=$row['id'].', ';
				$cc++;
				if (!($drs['bs_owner'])) { $drs['bs_owner']=$row['bs_owner']; }
				if (!($drs['labonly'])) { $drs['labonly']=$row['labonly']; }
			}


			if (!($drs['bs_owner']>0 || $drs['labonly']==1))
			{
				//���� ������� ������
				/*
                    			if (!(give_count($user['id'],$cc) ))
                    			{
                    			$okk=0;
                    			echo err('���������� ��������� ��������, � ��� ������������ ������ �������!');
                    			}
                    			*/
			}


			if ($okk==1 && strlen($del_sql))
			{
				$delo_str= substr($delo_str,0,-1).')';
				$del_sql= substr($del_sql,0,-2);
				$delo_str='"'.$user['login'].'" �������� ������� "'.$item_name.'" (x'.$cc.')'.$delo_str;


				if(mysql_query('DELETE FROM oldbk.inventory WHERE id in
                	('.$del_sql.') AND `owner` = '.$_SESSION['uid'].' AND `dressed` = 0 AND `setsale` = 0 AND present != "�������� �����" AND bs_owner='.$user['in_tower'].';'))
				{
					if($drs['bs_owner']>0 || $drs['labonly']==1)
					{
						//��� ��� ��� � �� ��� � ����- ����� �������� � ���� ��� �� �� ���������� (���������� ������).
					}
					else
					{
						//new_delo
						$rec['owner']=$user['id'];
						$rec['owner_login']=$user['login'];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money'];
						$rec['target']=0;
						$rec['target_login']='��������';
						$rec['type']=19;//�������� �������
						$rec['sum_kr']=0;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=$delo_str;
						$rec['item_name']=$row['name'];
						$rec['item_count']=$cc;
						$rec['item_type']=$row['type'];
						$rec['item_cost']=$row['cost'];
						$rec['item_dur']=$row['duration'];
						$rec['item_maxdur']=$row['maxdur'];
						$rec['item_ups']=$row['ups'];
						$rec['item_unic']=$row['unic'];
						$rec['item_incmagic']=$row['includemagicname'];
						$rec['item_incmagic_count']=$row['includemagicuses'];
						$rec['item_arsenal']='';
						add_to_new_delo($rec); //�����
					}
				}

			}
		}
		//single item drop
		// check if not from arsenal fixed by Umk
		else
		{
			$dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$user['id']}'
			  				AND present != '�������� �����' AND `id` = '{$_GET['destruct']}' LIMIT 1;"));


			$okk = 1;
			$issart = 0;
			if ((($dress['ab_uron'] > 0 || $dress['ab_bron'] > 0 || $dress['ab_mf'] > 0 || $dress['art_param'] != "")  AND $dress['type'] != 30) || ($dress['type'] == 30 && $dress['up_level'] > 5) || $dress['prototype'] == 3003092 || $dress['prototype'] == 3003093 || $dress['prototype'] == 111000|| $dress['prototype'] == 509 || $dress['prototype'] == 3003227 || $dress['prototype'] == 12802 || $dress['prototype'] == 3003226 || $dress['prototype'] == 3003228) {
				$issart = 1;
			}

			if (!$issart || ($issart && ($user['in_tower'] > 0 || $dress['labonly'] > 0))) {
				$okk = 1;
			} else {
				$okk = 0;
			}

			if (!$dress['can_drop']) $okk = 0;

			if($dress['id'] && $okk)
			{

				if($dress['arsenal_klan'] == '' && $okk) {
					if($dress['present'] != '�������� �����')
					{
						$okk=1;

						if (!($dress['bs_owner']>0 || $dress['labonly']==1))
						{
							/*
								if (!(give_count($user['id'],1) ))
			                    			{
                    						$okk=0;
			                    			echo err('���������� ��������� ��������, � ��� ������������ ������ �������!');
                    						}
                    						*/
						}


						if ($okk==1)
						{
							destructitem($dress['id']);
						}
					}

					if($dress['bs_owner']==1 || $dress['bs_owner']==2 || $dress['bs_owner']==3 || $dress['labonly']==1)
					{
						//��� ��� ��� � �� ��� � ����- ����� �������� � ���� ��� �� �� ���������� (���������� ������).
					}
					elseif(($dress['present'] != '�������� �����') AND ($okk==1))
					{
						//� ��� ��� ��������.
						//new_delo
						$rec['owner']=$user['id'];
						$rec['owner_login']=$user['login'];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money'];
						$rec['target']=0;
						$rec['target_login']='��������';
						$rec['type']=19;//�������� �������
						$rec['sum_kr']=0;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=get_item_fid($dress);
						$rec['item_name']=$dress['name'];
						$rec['item_count']=1;
						$rec['item_type']=$dress['type'];
						$rec['item_cost']=$dress['cost'];
						$rec['item_dur']=$dress['duration'];
						$rec['item_maxdur']=$dress['maxdur'];
						$rec['item_ups']=$dress['ups'];
						$rec['item_unic']=$dress['unic'];
						$rec['item_incmagic']=$dress['includemagicname'];
						$rec['item_incmagic_count']=$dress['includemagicuses'];
						$rec['item_arsenal']='';
						add_to_new_delo($rec); //�����
					}

					if($dress['present'] == '�������� �����')
					{
						echo "<font color=red><b>���� ������� ������ ���������.</b></font>";
					}
					elseif ($okk==1)
					{
						echo "<font color=red><b>������� \"".$dress['name']."\" ��������.</b></font>";
					}
				}
				else
				{
					echo "<font color=red><b>������ �������� ���� �� �������� �����!</b></font>";
				}
			}
		}
	}

	if (@$_GET['use']) {
		$_GET['use']=(int)$_GET['use'];
		$t1 = microtime(true);
		usemagic($_GET['use'],$_POST['target']);
		$m_usetime = microtime(true)-$t1;
	}
	if (@$_GET['exchange'] > 0) {
		$_GET['exchange']=(int)$_GET['exchange'];
		$q = mysql_query('SELECT * FROM inventory WHERE id = '.$_GET['exchange'].' and owner = '.$user['id'].' AND prototype IN (100015,100020,100025,100040,100100,100200,100300)');
		$vau4 = array(100015,100020,100025,100040,100100,100200,100300);
		$vau = mysql_fetch_assoc($q);
		if (in_array($vau['prototype'],$vau4) !== false) {
			$tabl = array(
					100015 => array(5,5,5),
					100020 => array(15,5),
					100025 => array(20,5),
					100040 => array(20,20),
					100100 => array(40,40,20),
					100200 => array(100,100),
					100300 => array(200,100),
			);

			$vv2 = array();
			$vv2[100015] = "5+5+5";
			$vv2[100020] = "15+5";
			$vv2[100025] = "20+5";
			$vv2[100040] = "20+20";
			$vv2[100100] = "40+40+20";
			$vv2[100200] = "100+100";
			$vv2[100300] = "200+100";


			$q = mysql_query('START TRANSACTION') or die();

			// ������� ������ ������
			$q = mysql_query('DELETE FROM inventory WHERE id = '.$vau['id']);

			// ��������
			$newv = $tabl[$vau['prototype']];
			while(list($k,$v) = each($newv)) {
				$t = mysql_query('select * from oldbk.eshop where id = '.($v+100000)) or die();
				$dress = mysql_fetch_assoc($t) or die();

				$sowner = $user['id'];
				if (!$vau['sowner']) $sowner = 0;


				mysql_query("INSERT INTO oldbk.`inventory`
						(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
						`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`,`present`
						)
						VALUES
						('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
						'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
						,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$vau['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$sowner}','{$vau['present']}'
						);
					") or die();

				// new_delo
				$rec = array();
				$rec['owner']=$user[id];
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user['money'];
				$rec['owner_balans_posle']=$user['money'];
				$rec['target_login']="������ �������";
				$rec['type']=344; //������� ������
				$rec['sum_kr']=0;
				$rec['sum_ekr']=$v;
				$rec['sum_kom']=0;
				$rec['item_id']=get_item_fid(array("idcity" => $user['id_city'], "id" => mysql_insert_id()));
				$rec['aitem_id']=$vau['id'];
				$rec['item_name']=$dress[name];
				$rec['item_count']=1;
				$rec['item_type']=$dress['type'];
				$rec['item_cost']=$dress['cost'];
				$rec['item_dur']=$dress['duration'];
				$rec['item_maxdur']=$dress['maxdur'];
				$rec['item_ups']=$dress['ups'];
				$rec['item_unic']=$dress['unic'];
				$rec['item_incmagic']=$dress['includemagicname'];
				$rec['item_incmagic_count']=$dress['includemagicuses'];
				$rec['item_arsenal']='';
				$rec['bank_id']='';
				$rec['item_proto']=$dress['prototype'];
				$rec['item_sowner']=($vau['sowner']>0?1:0);
				$rec['item_incmagic_id']=$dress['includemagic'];
				$rec['add_info']=$vau['name'];
				if (add_to_new_delo($rec) === FALSE) die();

			}

			echo "<font color=red>������ �������� ������ ".($vau['prototype']-100000)." ��� �� ".$vv2[$vau['prototype']]." ���.</font>";
			$q = mysql_query('COMMIT') or die();
		}
	}
	if (@$_GET['undress']) {
		$_GET['undress']=(int)$_GET['undress'];
		undressall($user['id']);
		//reload
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$user['id']}' ;"));
		// dug fix hp
		if ($user['hp'] > $user['maxhp'])  { $user['hp']=$user['maxhp']; mysql_query("UPDATE `users` SET `hp`=`maxhp` where id='".$user['id']."' ;"); }

		//ref_drop ($user['id']);
	}

	if ($user['in_tower']==3) 
	{
		unset($_GET['complect']);
		unset($_GET['delcomplect']);
		unset($_POST['savecomplect']);

		if ($_GET['setprofile'])
		{
			$prof_id=(int)($_GET['setprofile']);
			if ($prof_id>0)
			{
				$proff = mysql_fetch_array(mysql_query("SELECT * FROM `ntur_profile` WHERE `owner` = '{$user['id']}' and id='{$prof_id}'  ")) ;
				if ($proff['id']>0)
				{
					//������� ��� ������
					undressall($user['id']);
					//���������� �����
					if ($user['level'] >=8) {	$mast = 9; } else { $mast = 5; }

					mysql_query('UPDATE `users` SET
							`sila` = "'.$proff['sila'].'",
							`lovk` = "'.$proff['lovk'].'",
							`inta` = "'.$proff['inta'].'",
							`vinos` = "'.$proff['vinos'].'",
							`intel` = "'.$proff['intel'].'",
							`mudra` = "'.$proff['mudra'].'",
							`sergi`=0, `kulon`=0,`perchi`=0,`weap`=0,`bron`=0,`r1`=0,`r2`=0,	`r3`=0,	`helm`=0,`shit`=0,`boots`=0, `m1`=0,`m2`=0,	`m3`=0,	`m4`=0,	`m5`=0,
							`m6`=0,	`m7`=0,	`m8`=0,	`m9`=0,	`m10`=0, `m11`=0,`m12`=0,`m13`=0, `m14`=0,`m15`=0,`m16`=0,`m17`=0,`m18`=0,`m19`=0,`m20`=0,`nakidka`=0,`rubashka`=0,	`stats` = 0, `noj` = 0,	`mec` = 0, `topor` = 0,	`dubina` = 0,`mfire` = 0,	`mwater` = 0, 	`mair` = 0,`mearth` = 0, 	`mlight` = 0, `mgray` = 0,
							`mdark` = 0,
							`master` = "'.$mast .'",
							`maxhp` = "'.($proff['vinos']*6).'",
							`hp` = "'.($proff['vinos']*6).'",
							`bpbonussila` = 0,`mana` = 0,`maxmana` = 0,`bpbonushp` = 0
							WHERE `id` = '.$user['id'] ) ;
				}
			}
		}
		elseif ($_GET['setreset'])
		{
			//����� ������ � ������ � ������� 270
			//������� ��� ������
			undressall($user['id']);
			//������ ������ - ������������ �� ���� �������
			$asts[4]=34;
			$avin[4]=7;
			$ahp[4]=42;
			$maste[4] = 5;


			$asts[8]=78;
			$avin[8]=11;
			$ahp[8]=66;
			$maste[8] = 9;

			$my_tur_type=4; // ���� �� ��������� 4�
			if ($user['level'] >= 8 ) { $my_tur_type=8; } //���� 8�� =8�

			$vinos=$avin[$my_tur_type];
			$hp=$ahp[$my_tur_type];
			$stats=$asts[$my_tur_type];
			$mast=$maste[$my_tur_type];

			mysql_query_100('UPDATE `users` SET
							`sila` = "3",
							`lovk` = "3",
							`inta` = "3",
							`vinos` = "'.$vinos.'",
							`intel` = "0",
							`mudra` = "0",
							`stats` = "'.$stats.'",
							`sergi`=0,
							`kulon`=0,
							`perchi`=0,
							`weap`=0,
							`bron`=0,
							`r1`=0,
							`r2`=0,
							`r3`=0,
							`helm`=0,
							`shit`=0,
							`boots`=0,
							`m1`=0,
							`m2`=0,
							`m3`=0,
							`m4`=0,
							`m5`=0,
							`m6`=0,
							`m7`=0,
							`m8`=0,
							`m9`=0,
							`m10`=0,
							`m11`=0,
							`m12`=0,
							`m13`=0,
							`m14`=0,
							`m15`=0,
							`m16`=0,
							`m17`=0,
							`m18`=0,
							`m19`=0,
							`m20`=0,
							`nakidka`=0,
							`rubashka`=0,
							`noj` = 0,
							`mec` = 0,
							`topor` = 0,
							`dubina` = 0,
							`mfire` = 0,
							`mwater` = 0,
							`mair` = 0,
							`mearth` = 0,
							`mlight` = 0,
							`mgray` = 0,
							`mdark` = 0,
							`master` = "'.$mast.'",
							`maxhp` = "'.$hp.'",
							`hp` = "'.$hp.'",
							`bpbonussila` = 0,
							`mana` = 0,
							`maxmana` = 0,
							`bpbonushp` = 0
						WHERE `id` = '.$user['id']
			) ;
		}

	}

	if ((int)$_GET['delcomplect']) {

		$todelkomp=mysql_fetch_assoc(mysql_query('select * from oldbk.users_complect2 where owner="'.$user['id'].'" and id="'.(int)$_GET['delcomplect'].'" limit 1'));	
		if ($todelkomp['id']>0)
		{
		mysql_query("DELETE FROM oldbk.`users_complect2` WHERE `id` = ".$_GET['delcomplect']." AND `owner` = ".$user['id'].";");
		$get_settings_ktab=unserialize($user['gruppovuha']); //�����  ���������
		$get_settings_ktab[8]=(int)$todelkomp['type']; // �� 8� ������� ��������� ������� ���
		$save_settings_ktab=serialize($get_settings_ktab);
		
		mysql_query("UPDATE `users` SET `gruppovuha` = '".$save_settings_ktab."'  WHERE `id` = '".$user['id']."' LIMIT 1;");		
		}
		
	}
	if ($_GET['complect']) {
		if ($user['room'] != 999 && $user['room'] != 72001 && $user['room']!=270 && $user['room']!=10000) {

			if ($user['ruines'] > 0) {
				if (!isset($_SESSION['ruinesactivity']['dress'])) {
					$_SESSION['ruinesactivity']['dress'] = 1;
					$q = mysql_query('SELECT * FROM ruines_activity_log WHERE mapid = '.$user['ruines'].' and owner = '.$user['id'].' and var = "dress"');
					if (mysql_num_rows($q) == 0) {
						mysql_query('INSERT INTO ruines_activity_log (mapid,owner,var,val) VALUES("'.$user['ruines'].'","'.$user['id'].'","dress","1")');
					}
				}
			}


			$hp = $user['hp'];
			$data = mysql_fetch_assoc(mysql_query('select * from oldbk.users_complect2 where owner="'.$user['id'].'" and id="'.(int)$_GET['complect'].'" limit 1'));

			if ($data['id']>0) {
				// ������� ��������
				//$m_test = microtime(true);
				dressitemkomplekt($user,$data);
				//echo 'All: '.(microtime(true)-$m_test).'<br>';
	
				$get_settings_ktab=unserialize($user['gruppovuha']); //�����  ���������
				
				$get_settings_ktab[8]=(int)$data['type']; // �� 8� ������� ��������� ������� ���
				$save_settings_ktab=serialize($get_settings_ktab);
	
				mysql_query("UPDATE `users` SET `hp` = '".$hp."' , `gruppovuha` = '".$save_settings_ktab."'  WHERE `id` = '".$user['id']."' LIMIT 1;");
				mysql_query("UPDATE `users` SET `hp` = `maxhp` WHERE `hp` > `maxhp` AND `id` = '".$user['id']."' LIMIT 1;");
				$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
			}
		}
		else
		{
			echo "<font color=red>������ ������� �������� � ���� �������</font<";
		}
	}


	ref_drop($user['id']);
	
/*
if ($user['klan']=='radminion')	
{
	if ($user['uclass']>0)	
	{
			$old_uclass=$user['uclass'];
			$new_uclass=ref_uclass();
			if ($old_uclass!=$new_uclass)
				{
				//
				mysql_query("UPDATE `oldbk`.`users` SET `uclass`='{$new_uclass}' WHERE `id`='".$user['id']."' LIMIT 1;");
				$user['uclass']=$new_uclass;
				ref_drop($user['id']);		
				}
	}
}
*/

		$limits_to_save[0]=10; //	� ��� ��������� ��� �������-�������� 10 ��������� �� ��������
		$limits_to_save[1]=15; //		� ��� ������-�������� 15 ��������� �� �������
		$limits_to_save[2]=30; //		� ��� ����-�������� 30 ���������� �� �������	 	
		$limits_to_save[3]=75; //			� ��� ������� 75 ���������� �� �������
		$limits_to_save=$limits_to_save[$user['prem']];

	if (isset($_GET['movecomplect']))
		{

			$mvid=(int)($_GET['movecomplect']);
			if ($mvid>0)
				{

				$tomovecompl=mysql_fetch_array(mysql_query('SELECT * FROM oldbk.`users_complect2` WHERE owner='.$user['id'].' AND id="'.$mvid.'";'));
					if ($tomovecompl['id']>0)
						{

							$tomove=$tomovecompl['type']+1;
							if ($tomove>5) { $tomove=1; }
						
							$count_tab=mysql_fetch_array(mysql_query('SELECT count(id) as kol FROM oldbk.`users_complect2` WHERE owner='.$user['id'].' AND type="'.$tomove.'";'));
							
							if ($count_tab['kol']<$limits_to_save)
								{
								//���������

									mysql_query("UPDATE `oldbk`.`users_complect2` SET `type`='{$tomove}' WHERE `id`='{$tomovecompl['id']}' ");
									if (mysql_affected_rows()>0)
										{
										err('�������� ������ ���������!');
										}
									
								}
								else
								{
								err('��������� �� ��������� ������� ������, ���������� ���������� �� ��� �������� ������!');
								}
						
						}
						else
						{
						err('�������� �� ������!');
						}
				}
				
		
	}
	elseif (isset($_POST['savecomplect'])) 
	{

		$currktab=(int)($_POST['currktab']);
		if (!(($currktab>1) and ($currktab<6))) { $currktab=1; }
		
		

			$_POST['savecomplect']=trim($_POST['savecomplect']);
			if (preg_match('/[\/\:*?"<>|+%&#\']/',$_POST['savecomplect']) || $_POST['savecomplect']==='')
			{
			$errkom=1;
			}
			else	
			{
					if (strlen($_POST['savecomplect'])>17)
								{
								$_POST['savecomplect']=substr($_POST['savecomplect'], 0,17)."...";
								}
			
					$existcompl=mysql_fetch_array(mysql_query('SELECT * FROM oldbk.`users_complect2` WHERE owner='.$user['id'].' AND name="'.mysql_real_escape_string($_POST['savecomplect']).'";'));

					if ($existcompl['id']>0) { $limits_to_save++; } //��� ���������� ��������� +1 
					
					if (count_complects($currktab)<$limits_to_save)
					{
		
					$errkom='';
					$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
			
						//��������� ��������
						$odetShmot=mysql_query("select id,prototype from oldbk.inventory where id=".$user['sergi']." or id=".$user['kulon']." or id=".$user['perchi']." or id=".
								$user['weap']." or id=".$user['bron']." or id=".$user['r1']." or id=".$user['r2']." or id=".$user['r3']." or id=".
								$user['helm']." or id=".$user['shit']." or id=".$user['m1']." or id=".$user['m2']." or id=".$user['m3']." or id=".$user['m4'].
								" or id=".$user['m5']." or id=".$user['m6']." or id=".$user['m7']." or id=".$user['m8']." or id=".$user['m9']." or id=".$user['m10'].
								" or id=".$user['m11']." or id=".$user['m12']." or id=".$user['m13']." or id=".$user['m14']." or id=".$user['m15']." or id=".$user['m16']." or id=".$user['m17']." or id=".$user['m18']." or id=".$user['m19']." or id=".$user['m20']." or id=".$user['nakidka']." or id=".$user['rubashka']." or id=".$user['boots']." or id=".$user['runa1']." or id=".$user['runa2']." or id=".$user['runa3']);

						$sql = "";

						while ($res=mysql_fetch_array($odetShmot)) {
						        $slot = "";
							if ($res['id'] == $user['sergi']) $slot = "sergi";
							if ($res['id'] == $user['kulon']) $slot = "kulon";
							if ($res['id'] == $user['perchi']) $slot = "perchi";
							if ($res['id'] == $user['weap']) $slot = "weap";
							if ($res['id'] == $user['bron']) $slot = "bron";
							if ($res['id'] == $user['r1']) $slot = "r1";
							if ($res['id'] == $user['r2']) $slot = "r2";
							if ($res['id'] == $user['r3']) $slot = "r3";
							if ($res['id'] == $user['helm']) $slot = "helm";
							if ($res['id'] == $user['shit']) $slot = "shit";
        						if ($res['id'] == $user['m1']) $slot = "m1";
							if ($res['id'] == $user['m2']) $slot = "m2";
							if ($res['id'] == $user['m3']) $slot = "m3";
							if ($res['id'] == $user['m4']) $slot = "m4";
							if ($res['id'] == $user['m5']) $slot = "m5";
							if ($res['id'] == $user['m6']) $slot = "m6";
							if ($res['id'] == $user['m7']) $slot = "m7";
							if ($res['id'] == $user['m8']) $slot = "m8";
							if ($res['id'] == $user['m9']) $slot = "m9";
							if ($res['id'] == $user['m10']) $slot = "m10";
							if ($res['id'] == $user['m11']) $slot = "m11";
							if ($res['id'] == $user['m12']) $slot = "m12";
							if ($res['id'] == $user['m13']) $slot = "m13";
							if ($res['id'] == $user['m14']) $slot = "m14";
							if ($res['id'] == $user['m15']) $slot = "m15";
							if ($res['id'] == $user['m16']) $slot = "m16";
							if ($res['id'] == $user['m17']) $slot = "m17";
							if ($res['id'] == $user['m18']) $slot = "m18";
							if ($res['id'] == $user['m19']) $slot = "m19";
							if ($res['id'] == $user['m20']) $slot = "m20";
							if ($res['id'] == $user['nakidka']) $slot = "nakidka";
							if ($res['id'] == $user['rubashka']) $slot = "rubashka";
							if ($res['id'] == $user['boots']) $slot = "boots";
							if ($res['id'] == $user['runa1']) $slot = "runa1";
							if ($res['id'] == $user['runa2']) $slot = "runa2";
							if ($res['id'] == $user['runa3']) $slot = "runa3";

							$sql .= $slot.' = "'.$res['id'].'|'.$res['prototype'].'",';
						}

			
						if(strlen($sql)) {

							mysql_query('DELETE FROM oldbk.`users_complect2` WHERE owner = '.$user['id'].' and name = "'.mysql_real_escape_string($_POST['savecomplect']).'"');

							$sql = substr($sql,0,-1);
						
							$sql="
								INSERT INTO oldbk.`users_complect2`  
									SET owner = '{$user['id']}', name = '".mysql_real_escape_string($_POST['savecomplect'])."', ".$sql.", type = '{$currktab}'
							";

							mysql_query($sql);

							echo '<font color=red><b>�� '.($existcompl['id']>0?'������������':'���������').' �������� "'.$_POST['savecomplect'].'"</b></font>';
						}
			
						if(!$_SESSION['beginer_quest']['none']) {
							$last_q=check_last_quest(9);
							if($last_q) {
								quest_check_type_9($last_q); //�������� ������. ����� �����
							}
						}
				
				}
				else
				{
				echo '<font color=red><b>�� �������� ������ ����������� ����������!</b></font>';				
				}		
						
			}
		

			$get_settings_ktab=unserialize($user['gruppovuha']);
			$get_settings_ktab[8]=(int)$currktab;
			$save_settings_ktab=serialize($get_settings_ktab);
			mysql_query("UPDATE `users` SET `gruppovuha` = '".$save_settings_ktab."'  WHERE `id` = '".$user['id']."' LIMIT 1;");
		
	}
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	//testbpalignklan();
	//geteffbp();


	/*if ($user['maxhp'] != $user['vinos']*6) {

		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	} */

	?>
	<HTML><HEAD>
		<link rel=stylesheet type="text/css" href="i/main.css">
        <link rel="stylesheet" href="/i/btn.css" type="text/css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">

		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
		<script type="text/javascript" src="/i/globaljs.js"></script>
		
		<style type="text/css">
				td.komplact
				{
				   background: #C7C7C7;	
				}
				
				td.komplpas
				{
				   background: #A5A5A5;
				}
				
				tr.komplhover:hover 
				{
					background:#A5A5A5;
				}
			
		</style>
		<script>
			var currentktab = 1;
			
			function kmtab(n) {
				if (n == currentktab) return;
				
				document.getElementById("mestab"+currentktab).style.display = "none";
				document.getElementById("kmtab"+currentktab).className = "komplpas";
			
				document.getElementById("mestab"+n).style.display = "";
				document.getElementById("kmtab"+n).className = "komplact";
				currentktab = n;
				
				  $.get('savesession.php?curtab='+n, function(data) 
				  	{
					  $('#pl').html(data);
					});
			}

			function save(f){
				f.submit();
				return true;
			}

			function save1(id){

				var gg;
				var f = document.f1;
				id='rzd'+id;
				gg=document.getElementById(id).value;
				if(gg==0)
				{document.getElementById(id).value=1;}
				else
				{document.getElementById(id).value=0;}
				f.submit();
				return true;
			}

			function closehiddeninv(id) {
				// free
				$("#id_"+id).html('<img src="http://i.oldbk.com/i/ajax-loader.gif" border=0>');

				document.getElementById('id_'+id).style.display = 'none';
				document.getElementById('txt_'+id).style.display = 'block';
				document.getElementById('txt1_'+id).style.display = 'none';
			}

			function showhiddeninv(proto,id,otdel) {
				document.getElementById('id_'+proto).style.display = 'block';
				document.getElementById('txt_'+proto).style.display = 'none';
				document.getElementById('txt1_'+proto).style.display = 'block';

				// ajax load
				$.ajax({
					url: "main.php?invload2=1&prototype="+proto+"&id="+id+"&otdel="+otdel,
					cache: false,
					async: true,
					success: function(data){
						$("#id_"+proto).html(data);
					}
				});
			}

			function AddCount(name, txt, drop, href) {
				var el = document.getElementById("hint3");

				el.innerHTML = '<form method=post style="margin:0px; padding:0px;"><table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>�������� ����. ����</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
						'<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr>'+
						'<INPUT TYPE="hidden" name="gift" value="'+drop+'"><INPUT TYPE="hidden" name="dur" value="'+href+'"><INPUT TYPE="hidden" name="destruct" value="1"><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B><I>'+txt+'</td></tr><tr><td width=80% align=right>'+
						'���������� (��.) <INPUT TYPE="text" NAME="count" size=4 ></td><td width=20%>&nbsp;<INPUT TYPE="submit" value=" �� ">'+
						'</TD></TR></TABLE></td></tr></table></form>';
				el.style.visibility = "visible";
				el.style.left = (document.body.scrollLeft - 20) + 100 + 'px';
				el.style.top = (document.body.scrollTop + 5) + 100 + 'px';
				document.getElementById("count").focus();

			}
			var Hint3Name = '';
			// ���������, �������� �������, ��� ���� � �������
			function findlogin(title, script, name){
				var el = document.getElementById("hint3");
				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="6">'+
						'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}
			function check_msg_len(name,len) {
				var l=document.getElementById(name).value.length;
				document.getElementById(name+'ln').innerHTML = '('+l+' /'+len+' ��������.)';
			}
			function usepaper(title, script, name, len){
				var el = document.getElementById("hint3");
				el.innerHTML = '<table width="100%" cellspacing="1" cellpadding="0" bgcolor="CCC3AA"><tr><td align="center"><B>'+title+' <div id="'+name+'ln">(0 /'+len+' ��������.)</div></td><td width="20" align="right" valign="top" style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method="POST"><table width="100%" cellspacing="0" cellpadding="2" bgcolor="FFF6DD"><tr><td colspan="2"><INPUT TYPE="hidden" name="sd4" value="6">'+
						'������� �����:<small></TD></TR><TR><TD width=50% align=right><textarea rows="5" cols="40" id="'+name+'" NAME="'+name+'" maxlength="'+len+'" onchange="check_msg_len(\''+name+'\',\''+len+'\');" onselect="check_msg_len(\''+name+'\',\''+len+'\');" onclick="check_msg_len(\''+name+'\',\''+len+'\');" onkeyup="check_msg_len(\''+name+'\',\''+len+'\');"></textarea></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}



			function createrequestobject()
			{
				var request;
				if (window.XMLHttpRequest)
				{
					try
					{
						request = new XMLHttpRequest();
					}
					catch (e){}
				}
				else if (window.ActiveXObject)
				{
					try
					{
						request = new ActiveXObject('Msxml2.XMLHTTP');
					}
					catch (e)
					{
						try
						{
							request = new ActiveXObject('Microsoft.XMLHTTP');
						}
						catch (e){}
					}
				}

				return request;
			}

			function getchoice(type,nlevel)
			{
				if (typeof(nlevel) == "undefined") { var nlevel=0; }
							
				var container = document.getElementById("itemcontainer");
				var request = createrequestobject();
				if (request)
				{
					request.open("POST", "itemschoice.php?get=1&" + type + "=1&nlevel=" + nlevel, true);
					request.onreadystatechange = function()
					{
						if (request.readyState == 4)
						{
							if (request.status == 200)
							{
								container.innerHTML = request.responseText;
							}
							else
							{
								container.innerHTML = "<font color='red'><B>��������� ������</font>";
							}
						}
					};
					request.send(null);
				}
				else
				{
					container.innerHTML = "<font color='red'><B>��������� ������</font>";
				}
			}

			function shownoobrings(title, type, script) {
				var el = document.getElementById("hint3");
				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method=POST><table border = 2 width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td>'+
						'<select name="noobring">'+
						'<option value="222222230">������ ���� �������</option>'+
						'<option value="222222231">������ ������� ����</option>'+
						'<option value="222222232">������ ������� ����������</option>'+
						'<option value="222222233">������ ������������ �����</option>'+
						'<option value="222222234">������ ������� �������</option>'+
						'<option value="222222235">������ ������ �����</option>'+
						'</select>'+
						'<INPUT TYPE="submit" value=" �������� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}


			function showelka(title, type, script) {
				var el = document.getElementById("hint3");
				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method=POST><table border = 2 width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td>'+
						//'<select name="elka">'+
				<?php
						/*
						$q = mysql_query_cache('SELECT * FROM eshop WHERE id = 55510350',false,3600);
						while(list($k,$v) = each($q)) {
							echo "'<option value=\"".$v['id']."\">".$v['name']."</option>'+\r\n";
						}*/                                   

						$q = mysql_query_cache('SELECT * FROM eshop WHERE id = 55510350',false,3600);
						while(list($k,$v) = each($q)) {
							echo "'<input type=hidden name=\"elka\" value=\"".$v['id']."\">".$v['name']."'+\r\n";
						}

				?>
						//'</select>'+
						'<INPUT TYPE="submit" value=" �������� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}

			function showelka2(title, type, script) {
				var el = document.getElementById("hint3");
				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method=POST><table border = 2 width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td>'+
						//'<select name="elka2">'+
				<?php
						/*
						$q = mysql_query_cache('SELECT * FROM eshop WHERE id = 55510351',false,3600);
						while(list($k,$v) = each($q)) {
							echo "'<option value=\"".$v['id']."\">".$v['name']."</option>'+\r\n";
						}                                   
						*/

						$q = mysql_query_cache('SELECT * FROM eshop WHERE id = 55510351',false,3600);
						while(list($k,$v) = each($q)) {
							echo "'<input type=hidden name=\"elka2\" value=\"".$v['id']."\">".$v['name']."'+\r\n";
						}                                   

				?>
						//'</select>'+
						'<INPUT TYPE="submit" value=" �������� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}


			function showhide(id)
			{
				if (document.getElementById(id).style.display=="none")
				{document.getElementById(id).style.display="block";}
				else
				{document.getElementById(id).style.display="none";}
			}

		function getchoice_big(title,item,rstep)
			{
			
				var titl = document.getElementById("title");
				titl.innerHTML = title;

				var container = document.getElementById("itemcontainer");
				var request = createrequestobject();
				if (request)
				{
					request.open("POST", "itemschoice.php?get=1&" + rstep + "=1&item=" + item, true);
					request.onreadystatechange = function()
					{
						if (request.readyState == 4)
						{
							if (request.status == 200)
							{
								container.innerHTML = request.responseText;
							}
							else
							{
								container.innerHTML = "<font color='red'><B>��������� ������</font>";
							}
						}
					};
					request.send(null);
				}
				else
				{
					container.innerHTML = "<font color='red'><B>��������� ������</font>";
				}
			}

			function showitemschoice(title, type, script,nlevel)
			{
				if (typeof(nlevel) == "undefined") { var nlevel=0; }
							
				var choicehtml = "<form style='display:none' id='formtarget' action='" + script + "' method=POST><input type='hidden' id='target' name='target'><input type='hidden' id='nlevel' name='nlevel' value='"+nlevel+"'>";
				choicehtml += "</form><table width='100%' cellspacing='1' cellpadding='0' bgcolor='CCC3AA'>";
				choicehtml += "<tr><td align='center'><B><span id='title'>" + title + "</span></td>";
				choicehtml += "<td width='20' align='right' valign='top' style='cursor: pointer' onclick='closehint3(true);'>";
				choicehtml += "<big><b>x</td></tr><tr><td colspan='2' id='tditemcontainer'><div id='itemcontainer' style='width:100%'>";
				choicehtml += "</div></td></tr></table>";

				var el = document.getElementById("hint3");
				el.innerHTML = choicehtml;
				el.style.width = 450 + 'px';
				el.style.visibility = "visible";
				el.style.left = 100 + 'px';
				el.style.top = 100 + 'px';
				Hint3Name = "target";

				getchoice(type,nlevel);
			}

			function selecttarget(scrollid)
			{
				var targertinput = document.getElementById('target');
				targertinput.value = scrollid;

				var targetform = document.getElementById('formtarget');
				targetform.submit();
			}

			// ���������, �������� �������, ��� ���� � �������
			function okno(title, script, name,coma,errk){
				var errkom=''; var com=''; mesg='������� �������� ��������'; 
				var el = document.getElementById("hint3");
				var sendcurktab="";
				if (errk==1) { errkom='������ ������������ �������: /:*?"<>|+%&#\'\\<br>'; com=coma}
				if (errk==2) { mesg='' }
				if (name=='savecomplect') { sendcurktab = '<INPUT TYPE=hidden name=currktab value="'+currentktab+'"> ' ; mesg='������� ��������' ; }
				
				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2><font color=red>'+
						errkom+'</font>'+mesg+'</TD></TR><TR><TD width=50% align=right>'+sendcurktab+'<INPUT TYPE=text maxlength="150" id="'+name+'" NAME="'+name+'" value="'+com+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}

			function oknoCity(title, script, name,coma,errk){
				var errkom=''; var com='';
				var el = document.getElementById("hint3");
				if (errk==1) { errkom='������ ������������ �������: /:*?"<>|+%&#\'\\<br>'; com=coma}
				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2><font color=red>'+
						errkom+'</font>������� �������� ������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" NAME="'+name+'" value="'+com+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}

			function oknoTeloCity(title, script, name,city,coma,errk){
				var errkom=''; var com='';
				var el = document.getElementById("hint3");
				if (errk==1) { errkom='������ ������������ �������: /:*?"<>|+%&#\'\\<br>'; com=coma}
				el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<form action="'+script+'" method=POST><table border=0 width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2><font color=red>'+
						errkom+'</font>������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</small></TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" NAME="'+name+'" value="'+com+'"></TD><TD width=50%></TD></TR><tr><td colspan=2>������� �������� ������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+city+'" NAME="'+city+'" value="'+com+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
				el.style.visibility = "visible";
				el.style.left = 100;
				el.style.top = 100;
				document.getElementById(name).focus();
				Hint3Name = name;
			}

			// ���������, �������� �������, ��� ���� � ������
			function oknoPass(title, script, name,coma){
				var el = document.getElementById("hint3");
				el.innerHTML = '<form action="'+script+'" method=POST><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
						'������� ������ ��� �������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=password NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></td></tr></table></form>';
				el.style.visibility = "visible";
				el.style.left = 100 + 'px';
				el.style.top = 100 + 'px';
				document.getElementById(name).focus();
				Hint3Name = name;
			}

			function oknovauch(title, script, name,proto){
				var el = document.getElementById("hint3");
				var vv = new Array();
				var vv2 = new Array();

				vv[100015] = 15;
				vv[100020] = 20;
				vv[100025] = 25;
				vv[100040] = 40;
				vv[100100] = 100;
				vv[100200] = 200;
				vv[100300] = 300;

				vv2[100015] = "5+5+5";
				vv2[100020] = "15+5";
				vv2[100025] = "20+5";
				vv2[100040] = "20+20";
				vv2[100100] = "40+40+20";
				vv2[100200] = "100+100";
				vv2[100300] = "200+100";


				el.innerHTML = '<form action="'+script+'" method=POST><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
						'<table border=0 width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td align=center>'+
						'��������� ������ '+vv[proto]+' ��� <br>�� '+vv2[proto]+' ���.</TD></TR><TR><TD width=100% align=center colspan=2><INPUT TYPE="submit" value="��"> <INPUT TYPE="button" OnClick="closehint3();" value="���"></TD></TR></TABLE></td></tr></table></form>';
				el.style.visibility = "visible";
				el.style.left = document.body.clientWidth / 2 + 'px';
				el.style.top = 100 + 'px';
				document.getElementById(name).focus();
				Hint3Name = name;
			}


			function returned2(s){
				if (top.oldlocation != '') { top.frames['main'].location.href = top.oldlocation+'?'+s+'tmp='+Math.random(); top.oldlocation=''; }
				else { top.frames['main'].location.href = 'main.php?'+s+'tmp='+Math.random(); }
			}
			function closehint3(clearstored){
				if(clearstored)
				{
					var targetform = document.getElementById('formtarget');
					targetform.action += "&clearstored=1";
					targetform.submit();
				}
				document.getElementById("hint3").style.visibility="hidden";
				Hint3Name='';
			}

			function savescrolls() {
			  	$.get('main.php?savescrolls', function(data) {
				});
			}
		</script>
		<script type="text/javascript" src="http://i.oldbk.com/i/showthing.js"></script>
	</HEAD>
	<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>)">
	<!--7777--->
	<?
	make_quest_div();
	?>
	<div id=hint3 class=ahint style="z-index:500;"></div>
	<FORM METHOD=POST ACTION="main.php?edit=1" name=f22>
		<TABLE border=0 width=100% cellspacing="0" cellpadding="0">
			<TR>
				<td valign=top align=left width=250><?php

					showpersinv($user);

					$m_part1 = microtime(true)-$m_alltime;
					$m_part2 = microtime(true);

					$part2 = "<center>";
					$part2 .= "<a href='main.php?edit=1&undress=all'>����� ���</a><BR>";


					if ($user['in_tower'] != 3) {
						$part2 .= "<a  onclick = \"okno('��������� ��������','main.php?edit=1','savecomplect','');\" href='#'>��������� ��������</a><br>";
						$set_scrolls = unserialize($user['gruppovuha']);
						if (isset($set_scrolls[10]) && $set_scrolls[10] > 0) {
							$part2 .= "<input OnClick=\"savescrolls();\" type=\"checkbox\" checked>�������������� �������<br>";
						} else {
							$part2 .= "<input OnClick=\"savescrolls();\" type=\"checkbox\">�������������� �������<br>";
						}
					}

					if (($user['id']==14897) OR ($user['id']==190672) )
					{
						if ($_GET['supermode']==1)
						{
							mysql_query('UPDATE `oldbk`.`users` SET `sila`=100,`lovk`=200,`inta`=200,`vinos`=50,`intel`=1000,`maxhp`=50000,`hp`=50000 WHERE `id`='.$user['id']) or die();
							if (mysql_affected_rows()>0)
							{
								$part2 .="<br> ������ ����������� �����!<br>";
							}
						}

						$part2 .="<br><br><a href=/main.php?edit=1&supermode=1> ����� ����� - �������</a>";
					}

					$part2 .= '</center><BR>';

					if ($user['in_tower'] == 3) {
						//��������� ��� �������
						$part2 .= "<center><b>������� �������������:</b></center><br>";
						$data = mysql_query('SELECT * FROM `ntur_profile` WHERE `owner` = '.$user['id']) or die();
						while($row = mysql_fetch_array($data)) {
							$part2 .= "<a href='main.php?edit=1&setprofile=".$row['id']."'>��������� \"".$row['name']."\"</a><BR>";
						}

						$part2 .= "<hr><a href='main.php?edit=1&setreset=1'>�������� ����� � ������</a><BR>";
					} else {
						// ��������� ��� ��������� �����
						if ($user['align'] != 4) 
						{
						
							if 	(isset($_SESSION['gruppovuha']))
								{
								$get_settings_ktab=$_SESSION['gruppovuha'];
								}
								else
								{
								$get_settings_ktab=unserialize($user['gruppovuha']); //�����  ���������
								}
								
						if ($get_settings_ktab[8]<=0) $get_settings_ktab[8]=1;
						
						$echo_kompl = '<center>
						<div id="newkomplekt" style="margin:0px;padding:0px;z-index:999;width:200px;text-align:center;overflow:note;background-color: #A5A5A5;" align=center>
						    <table border="0" cellspacing="0" cellpadding="0" bordercolor="#000000" width="100%" style="text-align:center;background-color: #A5A5A5;">
						 	 <tr>
							    <td nowrap width=40 height="26" id="kmtab1" class="komplact" OnClick="kmtab(1);return false;"><a href="#" OnClick="kmtab(1);return false;" class="icons"><img src="http://i.oldbk.com/i/diz/icon_comp_home.png" alt="�������� ���������" title="�������� ���������"></a></td>
							    <td nowrap width=40 height="26" id="kmtab2" class="komplpas" OnClick="kmtab(2);return false;"><a href="#" OnClick="kmtab(2);return false;" class="icons"><img src="http://i.oldbk.com/i/diz/icon_comp_lab.png" alt="��������� ���������" title="��������� ���������"></a></td>
							    <td nowrap width=40 height="26" id="kmtab3" class="komplpas" OnClick="kmtab(3);return false;"><a href="#" OnClick="kmtab(3);return false;" class="icons"><img src="http://i.oldbk.com/i/diz/icon_comp_ruine.png" alt="��������� ����" title="��������� ����"></a></td>
							    <td nowrap width=40 height="26" id="kmtab4" class="komplpas" OnClick="kmtab(4);return false;"><a href="#" OnClick="kmtab(4);return false;" class="icons"><img src="http://i.oldbk.com/i/diz/icon_comp_zamki.png" alt="��������� ������" title="��������� ������"></a></td>
							    <td nowrap width=40 height="26" id="kmtab5" class="komplpas" OnClick="kmtab(5);return false;"><a href="#" OnClick="kmtab(5);return false;" class="icons"><img src="http://i.oldbk.com/i/diz/icon_comp_bs.png" alt="��������� ����� ������" title="��������� ����� ������"></a></td>	    
							  </tr>
							</table>';
						
							$data = mysql_query('select * from oldbk.`users_complect2` where owner="'.$user['id'].'";');
							if(mysql_num_rows($data)>0) 
							{
							$out_by_types=array();
								while($komplekt = mysql_fetch_assoc($data)) 
								{
									if ($komplekt['type']==0) $komplekt['type']=1;
									
									if (strlen($komplekt['name'])>17)
										{
										$komplekt['name']=substr($komplekt['name'], 0,17)."...";
										}
									
									$out_by_types[$komplekt['type']][$komplekt['id']] = "<tr class=\"komplhover\"><td style=\"text-align:justify;\">&nbsp;<a onclick=\"if (!confirm('�� �������, ��� ������ ������� ��������?')) { return false; }\" href='main.php?edit=1&delcomplect=".$komplekt['id']."'><img src='http://i.oldbk.com/i/clear.gif'></a> <a href='main.php?edit=1&complect=".$komplekt['id']."'><small>".$komplekt['name']."</small></a></td> <td align='right'><a href='main.php?edit=1&movecomplect=".$komplekt['id']."'><img  src='http://i.oldbk.com/i/ar.png' alt='��������� �� ��������� �������' title='��������� �� ��������� �������' ></a></td></tr>";
								}
							}

						
							$echo_kompl.= '<div style="text-align:left;margin-top:0px;margin-left:0px;margin-bottom:0px;background-color: #C7C7C7;">';


							
								for($tt=1;$tt<=5;$tt++)
									{
						 			$echo_kompl.='<div id="mestab'.$tt.'" style="margin-top:0px;'.($tt!=1?'display:none;':'').'"><br><table>';
						 				 if (count($out_by_types[$tt])>0)
						 				 	{
											foreach($out_by_types[$tt] as $id => $kdata) 
												{
									 			$echo_kompl.=$kdata;
											 	}
											
								 			$echo_kompl.="<tr><td colspan=2><div align=center><small>������� �� ��������, ����� ������ ���.</small></div></td></tr>";
											}
											else
											{
								 			$echo_kompl.='<tr><td colspan=2><div align=center><small><i>���� �����</i></small></div></td></tr>';
											}
											
						 			$echo_kompl.='</table><br></div><script>kmtab('.$get_settings_ktab[8].'); </script>';
									}
							$echo_kompl.='</div>
							</div><br><br></center>';
						$part2 .= $echo_kompl;
						}
					}

					// ������������
					if(($user['align']>1&&$user['align']<2)||($user['align']>2&&$user['align']<3)) {
						$access = check_rights($user);
					}

					$autocost = 15;

					if ($access['can_forum_del'] || $user['deal'] > 0 || $user['prem'] > 0) {
						$autocost=0;
					}

					if ($_POST['autoanswer'] != '') {
						if ($user['money'] >= $autocost) {
							mysql_query("INSERT oldbk.`autoanswer` (`id`,`answer`)values('".$_SESSION['uid']."','".$_POST['autoanswer']."') ON DUPLICATE KEY UPDATE `answer` ='".$_POST['autoanswer']."';");

							if($autocost>0) {
								mysql_query("UPDATE `users` SET `money` = `money`-".$autocost." WHERE `id` = '".$_SESSION['uid']."' LIMIT 1;");

								//new_delo
								$rec['owner'] = $user['id'];
								$rec['owner_login']=$user['login'];
								$rec['owner_balans_do']=$user['money'];
								$user['money']=$user['money']-$autocost;
								$rec['owner_balans_posle']=$user['money'];
								$rec['target']=0;
								$rec['target_login']='������������';
								$rec['type']=17;
								$rec['sum_kr']=$autocost;
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
							}
						} else {
							$part2 .= "<font color=red>� ��� ������������ �����.</font>";
						}
					}

					$part2 .= '<table>';
					$part2 .= '<tr><td>&nbsp;</td><td><small>';
					$answer = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`autoanswer` WHERE `id` = '".$_SESSION['uid']."' LIMIT 1;"));
					$part2 .=  "<br><form method=post action=\"orden.php\"><h4>����� �������������.</h4>";
					$part2 .= "������� �����: ".$answer['answer']."<br><br>";
					$part2 .= '����� '.($autocost > 0 ? '('.$autocost.' ��.)':'').': <br><input name="autoanswer" type="text" value="">&nbsp;<input type="submit" value="���������">';
					$part2 .= '</form>';
					$part2 .= '</td></tr><tr><td>&nbsp;</td><td></td></tr></table></td><TD valign=top width=207><br>';

					$part2 .= '����: <a href="http://oldbk.com/encicl/?/exp.html" target="_blank">'.$user['exp'].'</a>';

					if (($user['level']==13) and ($user['exp']>=8000000000) )
					{
						//��� ����� �� ���������� ��������� ��
						$part2 .='<BR>';
						$part2 .= '�������: <font color=#F03C0E><b>'.$user['level'].'</b></font><BR>';
					}
					else
					{
						$part2 .="(".$user['nextup'].")";
						$part2 .='<BR>';
						$part2 .= '�������: '.$user['level'].'<BR>';
					}




					$part2 .= '�����: '.$user['win'].'<BR>���������: '.$user['lose'];

						$mvoinst = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_voin` WHERE `owner` = '".$_SESSION['uid']."' LIMIT 1;"));
						$mvoinst['voin']=(int)$mvoinst['voin'];
						$mvoin=" <a href='http://top.oldbk.com/?r=ppl'  target='_blank'  title='�� ������� �����' alt='�� ������� �����'>(".$mvoinst['voin'].")</a>";
						
					//$part2 .= '������� �������: '.$user['skulls'].'<BR>��������������: '.$user['voinst'].$mvoin.'<BR>������: <b>'.$user['money'].'</b> ��. <BR>';
					$part2 .= '<BR>������: <b>'.$user['money'].'</b> ��. ';
					$part2 .= '<BR>������: <b>'.$user['gold'].'</b> <img src="http://i.oldbk.com/i/icon/coin_icon.png" alt="������" title="������" style="margin-bottom: -2px;"> <BR>';					

					if($user['level'] >=4) {
						//	$part2 .= '��������� �������: <b>'.$user['repmoney'].'</b><BR>����� ���������: <b>'.$user['rep'].'</b><BR>';
						$part2 .= '��������� �������: <b>'.$user['repmoney'].'</b><BR>';
					}

					if($user['klan']) {
						$part2 .= "����: ".$user['klan']."<BR>";
					}

					if($user['uclass']>0) {
						$part2 .= "����� ���������: <b>{$nclass_name[$user['uclass']]}</b><br>";
					}


					$part2 .= '<HR>	<!--���������--><table border=0><tr><td>';

					$part2 .= '����: '.$user['sila'];
					if ($user['stats'] > 0) $part2 .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ������ ������������ � ����\",\"1\")) { window.location=\"?up=1&edit=1&sila=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
					$part2 .= "<br>";

					$part2 .= '��������: '.$user['lovk'];
					if($user['stats'] > 0) $part2 .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ������ ������������ � ��������\",\"1\")) { window.location=\"?up=1&edit=1&lovk=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
					$part2 .= "<br>";

					$part2 .= '��������: '.$user['inta'];
					if($user['stats'] > 0) $part2 .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ������ ������������ � ��������\",\"1\")) { window.location=\"?up=1&edit=1&inta=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
					$part2 .= "<br>";

					$part2 .= '������������: '.$user['vinos'];
					if ($user['stats'] > 0) $part2 .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ������ ������������ � ������������\",\"1\")) { window.location=\"?up=1&edit=1&vinos=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
					$part2 .= "<br>";

					if ($user['level']>3) {
						$part2 .= '���������: '.$user['intel'];
						if($user['stats'] > 0) $part2 .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ������ ������������ � ��������\",\"1\")) { window.location=\"?up=1&edit=1&intel=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
						$part2 .= "<br>";
					}

					if($user['level']>6) {
						$part2 .= "��������: ".$user['mudra'];
						if($user['stats']) $part2 .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ������ ������������ � ��������\",\"1\")) { window.location=\"?up=1&edit=1&mudra=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
						$part2 .= "<br>";
					}

					$part2 .= '<FONT COLOR="green">��������� ����������: '.$user['stats'].'</FONT><hr>';

					/*
	function get_wep_type($idwep)
	{
	if ($idwep == 0 || $idwep == null || $idwep == '') { return "kulak"; }
		$wep = mysql_fetch_array(mysql_query('SELECT `otdel`,`minu`, `prototype` FROM oldbk.`inventory` WHERE `id` = '.$idwep.' LIMIT 1;'));
		if($wep[0] == '1') { return "noj"; }
		elseif($wep[0] == '12') { return "dubina"; }
		elseif($wep[0] == '11') { return "topor"; }
		elseif($wep[0] == '13') {return "mech";	}
		elseif($wep['prototype'] == 501) { return "kostil1";}
		elseif($wep['prototype'] == 502) { return "kostil2";}
		elseif( ($wep[0] == '6') and  (($wep['prototype']>=55510301) and ($wep['prototype']<=55510401)))  {return "elka";	}
		elseif($wep[1] > 0) { return "buket"; } else { return "kulak"; }
	}
*/
					$m_udr = microtime(true);
					//	$query = mysql_query('SELECT minu,maxu,mfkrit,mfakrit,mfuvorot,mfauvorot,bron1,bron2,bron3,bron4,ab_mf,ab_bron,ab_uron,unik,dressed FROM oldbk.`inventory` WHERE id in ('.GetDressedItems($user,DRESSED_ITEMS).')');

					//	$user_dressed = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0, 12 => 0, 13 => 0);

					/*
	sum(minu) - 0
	sum(maxu) - 1
	sum(mfkrit) - 2
	sum(mfakrit) - 3
	sum(mfuvorot) - 4
	sum(mfauvorot) - 5
	sum(bron1) - 6
	sum(bron2) - 7
	sum(bron3) - 8
	sum(bron4) - 9
	sum(ab_mf) - 10
	sum(ab_bron) - 11
	sum(ab_uron) - 12
	sum(unik) - 13
	*/

					/*	while($ud = mysql_fetch_assoc($query)) {
		$user_dressed[0] += $ud['minu'];
		$user_dressed[1] += $ud['maxu'];
		$user_dressed[2] += $ud['mfkrit'];
		$user_dressed[3] += $ud['mfakrit'];
		$user_dressed[4] += $ud['mfuvorot'];
		$user_dressed[5] += $ud['mfauvorot'];
		$user_dressed[6] += $ud['bron1'];
		$user_dressed[7] += $ud['bron2'];
		$user_dressed[8] += $ud['bron3'];
		$user_dressed[9] += $ud['bron4'];

		$user_dressed[10] += $ud['ab_mf'];
		$user_dressed[11] += $ud['ab_bron'];
		$user_dressed[12] += $ud['ab_uron'];
		$user_dressed[13] += $ud['unik'];
	}
*/

					$m_udr = microtime(true)-$m_udr;

					$aeff = getalleff($user['id']);

					$user_level = $user['level'];

					$master = 0;
					switch($WEP_TYPE)
					{
						case "noj": $master += $user['noj']; break;
						case "dubina": $master += $user['dubina']; break;
						case "topor": $master += $user['topor']; break;
						case "mech": $master += $user['mec']; break;
						case "elka":
							$ma=$user['noj'];
							if ($ma<$user['topor']) { $ma=$user['topor'];}
							if ($ma<$user['dubina']) { $ma=$user['dubina'];}
							if ($ma<$user['mec']) { $ma=$user['mec'];}
							$master +=$ma;
							break;
						case "buket":
							$ma=$user['noj'];
							if ($ma<$user['topor']) { $ma=$user['topor'];}
							if ($ma<$user['dubina']) { $ma=$user['dubina'];}
							if ($ma<$user['mec']) { $ma=$user['mec'];}
							$master +=$ma;
							break;
						case "kostil":
						{
							$master = 0;
							break;
						}
					}

					$min_damage = round((floor($user['sila']/3) + 1) + $user_level + $USER_MF_DATA['minu'] * (1 + 0.07 * $master));
					$max_damage =  round((floor($user['sila']/3) + 4) + $user_level + $USER_MF_DATA['maxu'] * (1 + 0.07 * $master));

					$prof_data=GetUserProfLevels($user);

					if($weapon_type == 'kulak' && $user['align'] == '2') {
						$min_damage += $user_level;
						$max_damage += $user_level;
					};
					

					
					//`smithlevel` - ������ 
					// ����� �����:  1-2 �� ������ ������� ���������� (� ����������� � ������������ ����)
					if ($prof_data['smithlevel']>0)
						{
						$min_damage += (int)($prof_data['smithlevel']*1) ;
						$max_damage +=(int)($prof_data['smithlevel']*2) ;
						}

					$arrmf['uvorota']=0;
					$arrmf['auvorota']=0;
					$arrmf['krita']=0;
					$arrmf['akrita']=0;

					//���������� ������ ��
					if (isset($aeff[900]))
					{
						$arrmf['uvorota']+=(int)($aeff[900]['add_info']);
					}
					if (isset($aeff[901]))
					{
						$arrmf['auvorota']+=(int)($aeff[901]['add_info']);
					}
					if (isset($aeff[902]))
					{
						$arrmf['krita']+=(int)($aeff[902]['add_info']);
					}
					if (isset($aeff[903]))
					{
						$arrmf['akrita']+=(int)($aeff[903]['add_info']);
					}

					if (isset($aeff[904]))
					{
						//���� ��
						$USER_MF_DATA['ab_mf']+=(int)($aeff[904]['add_info']);
					}
					if (isset($aeff[905]))
					{
						//�����
						$USER_MF_DATA['ab_bron']+=(int)($aeff[905]['add_info']);
					}
					if (isset($aeff[906]))
					{
						//����
						$USER_MF_DATA['ab_uron']+=(int)($aeff[906]['add_info']);
					}
					/////////////////////////


					//���������     ����������� �����: +...% (����������, ��� �� �����)      0,25% �� ������ ������� ����������
					if ($prof_data['armorerlevel']>0)
							{
							$USER_MF_DATA['ab_uron']+=($prof_data['armorerlevel']*0.25);
							}

					// �������      �������� �����: +...%      0,5% �� ������ ������� ����������															
					if ($prof_data['armorsmithlevel']>0)
						{
							$USER_MF_DATA['ab_bron']+=($prof_data['armorsmithlevel']*0.5);						
						}

					// ������ (���������������� ��������)     //����� �� �������: + 20 ����������� / ������� ������� 
					if ($prof_data['jewelerlevel']>0)					
						{
						$USER_MF_DATA['mfauvorot']+=round(20*$prof_data['jewelerlevel']);
						}

						// ������� (������ ����������� ������)   //����� �� ��������: +20 ��������� / ������� �������
					if ($prof_data['tailorlevel']>0)					
						{
						$USER_MF_DATA['mfakrit']+=round(20*$prof_data['tailorlevel']);
						}						
						


					$arrmf['uvorota']+=$USER_MF_DATA['mfuvorot'] + $user['lovk'] * 5;
					$arrmf['auvorota']+=$USER_MF_DATA['mfauvorot'] + $user['lovk'] * 5 + $user['inta'] * 2;
					$arrmf['krita']+=$USER_MF_DATA['mfkrit'] + $user['inta'] * 5;
					$arrmf['akrita']+=$USER_MF_DATA['mfakrit'] + $user['inta'] * 5 + $user['lovk'] * 2;

					//���������� 100-� ��������
					$arrmf_uvorota=$arrmf['uvorota'];
					$arrmf_auvorota=$arrmf['auvorota'];
					$arrmf_krita=$arrmf['krita'];
					$arrmf_akrita=$arrmf['akrita'];

					if ($USER_MF_DATA['ab_mf']>0) {
						//���� ���� ������ �� �� ��
						//���� ����� �� �� - �� ����������� � ������������ ���������� �������� ������.
						$add_to_mf=getmaxmf($arrmf);
						$arrmf[$add_to_mf]+=(int)($arrmf[$add_to_mf]*($USER_MF_DATA['ab_mf']/100));
						$green_out[$add_to_mf]=$USER_MF_DATA['ab_mf'];
					}

					if ($USER_MF_DATA['ab_bron']>0 || isset($aeff[791])) {
						$plusbron = 0;

						if ($USER_MF_DATA['ab_bron'] > 0) {
							$USER_MF_DATA['bron1']+=(int)($USER_MF_DATA['bron1']*($USER_MF_DATA['ab_bron']/100));
							$USER_MF_DATA['bron2']+=(int)($USER_MF_DATA['bron2']*($USER_MF_DATA['ab_bron']/100));
							$USER_MF_DATA['bron3']+=(int)($USER_MF_DATA['bron3']*($USER_MF_DATA['ab_bron']/100));
							$USER_MF_DATA['bron4']+=(int)($USER_MF_DATA['bron4']*($USER_MF_DATA['ab_bron']/100));
							$plusbron += $USER_MF_DATA['ab_bron'];
						}

						if (isset($aeff[791])) {
							$USER_MF_DATA['bron1']+=(int)($USER_MF_DATA['bron1']*(15/100));
							$USER_MF_DATA['bron2']+=(int)($USER_MF_DATA['bron2']*(15/100));
							$USER_MF_DATA['bron3']+=(int)($USER_MF_DATA['bron3']*(15/100));
							$USER_MF_DATA['bron4']+=(int)($USER_MF_DATA['bron4']*(15/100));
							$plusbron += 15;
						}

						$gree_out_bron = " <font color=green>(+".$plusbron."%)</font>";
					}

					if ($USER_MF_DATA['ab_uron']>0 || isset($aeff[792])) {

						$plusuron = 0;
						if($USER_MF_DATA['ab_uron']>0) {
							$min_damage+=(int)($min_damage*($USER_MF_DATA['ab_uron']/100));
							$max_damage+=(int)($max_damage*($USER_MF_DATA['ab_uron']/100));
							$plusuron += $USER_MF_DATA['ab_uron'];
						}

						if (isset($aeff[792])) {
							$min_damage+=(int)($min_damage*(5/100));
							$max_damage+=(int)($max_damage*(5/100));
							$plusuron += 5;
						}

						$gree_out_uron = " <font color=green>(+".$plusuron."%)</font>";
					}

					//����-���
					if (strpos($user['medals'], 'k202;') !== false) {
						$USER_MF_DATA['unik']+=1;
					}

					if (strpos($user['medals'], 'k203;') !== false) {
						$USER_MF_DATA['supunik']+=1;
					}

						//////���������� ����� �����
						$unik_bonus_data=get_unik_bonus_data($USER_MF_DATA['unik'],$USER_MF_DATA['supunik']);
						if (($unik_bonus_data) and ($unik_bonus_data[0]>0) )
						{
						//��������� �����												
						$arrmf['uvorota']+=round($arrmf_uvorota*(0.01*$unik_bonus_data[0]));
						$arrmf['auvorota']+=round($arrmf_auvorota*(0.01*$unik_bonus_data[0]));
						$arrmf['krita']+=round($arrmf_krita*(0.01*$unik_bonus_data[0]));
						$arrmf['akrita']+=round($arrmf_akrita*(0.01*$unik_bonus_data[0]));
						$green_out['uvorota']+=$unik_bonus_data[0];
						$green_out['auvorota']+=$unik_bonus_data[0];
						$green_out['krita']+=$unik_bonus_data[0];
						$green_out['akrita']+=$unik_bonus_data[0];
						} 


					if (isset($aeff[793])) {
						$arrmf['uvorota']+=round($arrmf['uvorota']*0.01);
						$arrmf['auvorota']+=round($arrmf['auvorota']*0.01);
						$arrmf['krita']+=round($arrmf['krita']*0.01);
						$arrmf['akrita']+=round($arrmf['akrita']*0.01);

						$green_out['uvorota']+=1;
						$green_out['auvorota']+=1;
						$green_out['krita']+=1;
						$green_out['akrita']+=1;
					}


					$part2 .= "����: ".$min_damage." - ".$max_damage.$gree_out_uron."<br>������������<br>";
					$part2 .= "&nbsp; ������: &nbsp;".$arrmf['uvorota']."% ";
					if($green_out['uvorota']>0) {
						$part2 .= "<font color=green>(+".$green_out['uvorota']."%)</font>";
					}
					$part2 .= "<br>";
					$part2 .= "&nbsp; ����������: &nbsp;". $arrmf['auvorota']."% ";
					if ($green_out['auvorota']>0) {
						$part2 .= "<font color=green>(+".$green_out['auvorota']."%)</font>";
					}
					$part2 .= "<br>";
					$part2 .= "&nbsp; ����: &nbsp;".$arrmf['krita']."% ";
					if ($green_out['krita']>0) {
						$part2 .= "<font color=green>(+".$green_out['krita']."%)</font>";
					}
					$part2 .= "<br>";
					$part2 .= "&nbsp; ��������: &nbsp;".$arrmf['akrita']."% ";
					if ($green_out['akrita'] > 0) {
						$part2 .= "<font color=green>(+".$green_out['akrita']."%)</font>";
					}
					$part2 .= "<br>�����<br>";

					$part2 .= " &nbsp; ������: &nbsp;".$USER_MF_DATA['bron1'].$gree_out_bron."<br>";
					$part2 .= " &nbsp; �������: &nbsp;".$USER_MF_DATA['bron2'].$gree_out_bron."<br>";
					$part2 .= " &nbsp; �����: &nbsp;".$USER_MF_DATA['bron3'].$gree_out_bron."<br>";
					$part2 .= " &nbsp; ���: &nbsp;".$USER_MF_DATA['bron4'].$gree_out_bron."<br>";

					//if ($user['uclass'] == 3 && $user['in_tower'] == 0 && $user['lab'] == 0) {
						if (true) //($user['room']==44)
							{
							$part2 .= " &nbsp; �������������:&nbsp;".round(get_rabota_boni_lvls($user)*100,2)."-".round((get_rabota_boni_lvls($user)+0.2)*100,2)."%<br>";						
							}
							else
							{
							$part2 .= " &nbsp; �������������:&nbsp;".round(get_rabota_boni($user)*100,2)."-".round((get_rabota_boni($user)+0.2)*100,2)."%<br>";
							}
					//}


					$part2 .= "<HR>	���������� ��������:<BR>";

					$part2 .= " &nbsp; ������ � ���������: ".$user['noj'];
					if(($user['master']) and ($user['noj']<5)) {
						$part2 .= "<a href='?up=21&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
					}
					$part2 .= "<br>";
					$part2 .= " &nbsp; ������: ".$user['mec'];
					if(($user['master']) and ($user['mec']<5)) {
						$part2 .= "<a href='?up=22&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
					}
					$part2 .= "<br>";
					$part2 .= " &nbsp; ��������, ��������: ".$user['dubina'];
					if(($user['master']) and ($user['dubina']<5)) {
						$part2 .= "<a href='?up=23&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
					}
					$part2 .= "<br>";
					$part2 .= " &nbsp; �������� � ��������: ".$user['topor'];
					if(($user['master'])and ($user['topor']<5)) {
						$part2 .= "<a href='?up=24&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
					}
					$part2 .= "<br>";

					if ($user['level'] > 3) {
						$part2 .= '���������� ����������:<BR>';
						$part2 .= ' &nbsp; ������ ����: '.$user['mfire'];
						if($user['master']>0) {
							$part2 .= "<a href='?up=25&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
						}
						$part2 .= "<br>";
						$part2 .= " &nbsp; ������ ����: ".$user['mwater'];
						if($user['master']>0) {
							$part2 .= "<a href='?up=26&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
						}
						$part2 .= "<br>";
						$part2 .= " &nbsp; ������ �������: ".$user['mair'];
						if($user['master']>0) {
							$part2 .= "<a href='?up=27&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
						}
						$part2 .= "<br>";
						$part2 .= "������ �����: ".$user['mearth'];
						if($user['master']>0) {
							$part2 .= "<a href='?up=28&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
						}
						$part2 .= "<br>";
						$part2 .= " &nbsp; ����� �����: ".$user['mlight'];
						if($user['master']>0) {
							$part2 .= "<a href='?up=29&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
						}
						$part2 .= "<br>";
						$part2 .= "&nbsp; ����� �����: ".$user['mgray'];
						if($user['master']>0) {
							$part2 .= "<a href='?up=210&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
						}
						$part2 .= "<br>";
						$part2 .= "&nbsp; ����� ����: ".$user['mdark'];
						if($user['master']>0) {
							$part2 .= "<a href='?up=211&edit=1'><img src=http://i.oldbk.com/i/up.gif></a>";
						}
						$part2 .= "<br>";
					}

					$part2 .= '<FONT COLOR="#333399">��������� ����������: '.$user['master'].'</font>


		</td></tr></table>

	</TD>

	<TD valign=top>
	<link rel="stylesheet" href="/i/btn.css" type="text/css">
	<IMG SRC="http://i.oldbk.com/i/1x1.gif" WIDTH="1" HEIGHT="5" BORDER=0 ALT=""><div align=right class="btn-control inventory">
<FORM METHOD=POST ACTION="?edit=1" name=f1>
	<INPUT class="button-mid btn" TYPE="button" name="encicl" value="����������" title="����������" onClick="window.open(\'https://oldbk.com/encicl/\', \'1d\', \'location=yes,menubar=yes,status=yes,toolbar=yes,scrollbars=yes\')">
	<INPUT class="button-mid btn" TYPE="button" onclick="location.href=\'?edit=1&effects=1\'" value="���������" title="���������">
	<INPUT class="button-mid btn" TYPE="button" onclick="location.href=\'?edit=1&setshadow=1\'" value="������" title="������">';

					if ($user['in_tower'] == 0) {
						$part2 .= '<INPUT class="button-mid btn" TYPE="submit" name="gallery" value="�������" title="�������">';
					} elseif ($user['in_tower'] == 3) {
						$part2 .= "<input class=\"button-mid btn\" value=\"������� �������������\" style=\"background-color:#A9AFC0\" onclick=\"window.open('restal_profile.php', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')\" type=\"button\"> ";
					}

					$part2 .= '
	<INPUT class="button-mid btn" TYPE="button" name="editanketa" value="������" title="������" onClick="window.open(\'register.php?edit=1\', \'1d\', \'height=500,width=800,location=yes,menubar=yes,status=yes,toolbar=yes,scrollbars=yes\')">
	<INPUT class="button-big btn" TYPE="submit" name="changepsw" value="������������" title="������������" style="FONT-WEIGHT: bold;">
	<INPUT class="button-big btn" TYPE="submit" name="transreport" value="����� � ���������" title="����� � ���������">
	<INPUT class="button-dark-mid btn" TYPE="button" value="���������" style="background-color:#A9AFC0" onClick="window.open(\'help/invent.html\', \'help\', \'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes\')">
	';

					if ((($user['room']>=1) and ($user['room']<=19)) or ($user['room']==36) or  ($user['room']==54) or  ($user['room']==56) or  ($user['room']==57)) {
						$part2 .= '
		<INPUT class="button-mid btn" TYPE=button name=combats value="��������" onClick="location.href=\'zayavka.php\';" style="font-weight:bold;">
		<INPUT class="button-big btn" TYPE=button name=setch style="FONT-WEIGHT: bold;" title="����� �����" value="����� �����" onClick="location.href=\'main.php?setch='.mt_rand(111111,999999).'\';">';
					}

					$part2 .= '
	<INPUT class="button-mid btn" TYPE="button" onClick="location.href=\'main.php\';" value="���������" title="���������">
	</div>';


					$_SESSION['razdel'] = isset($_GET['razdel']) ? max(0, min(7, intval($_GET['razdel']))) : (isset($_SESSION['razdel']) ? $_SESSION['razdel'] : 0);

					if (isset($_GET['filt']))
					{
						$filt=(int)($_GET['filt']);
						if ($filt>0)
						{
							if (($filt==6)or ($filt==7)) { $filt=5; }
							elseif (($filt>=13) and ($filt<30)) { $filt=12; }
							elseif ($filt>=30)  { $filt=30; }

							if ($filt==12)	{ $_SESSION['razdel']=1; } else { $_SESSION['razdel']=0;}

							$_GET['page']=0;
						}
						else
						{
							unset($filt);
						}
					}

					if ($_SESSION['gruppovuha']!='')
					{
					$gruppovuha = $_SESSION['gruppovuha'];
					}
					else
					{
					$gruppovuha = unserialize($user['gruppovuha']);
					}

//echo "DD";
//print_r($gruppovuha);

                         
					$part2 .= '
		<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
		<TR>
			<TD>
			<TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 0) ? "#A5A5A5":"#C7C7C7").'"><input name="ssave" type="hidden" value=1>
				<input type="hidden" id="rzd0" name="rzd0" value="'.($gruppovuha[0]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[0]=='1'?'1':'0').'.gif" onClick="save1(0);" style="cursor: pointer;"><A HREF="?edit=1&razdel=0">&nbsp;��������������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 1) ? "#A5A5A5":"#C7C7C7").'"><input type="hidden" id="rzd1" name="rzd1" value="'.($gruppovuha[1]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[1]=='1'?'1':'0').'.gif" onClick="save1(1);" style="cursor: pointer;"><A HREF="?edit=1&razdel=1">&nbsp;��������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 2) ? "#A5A5A5":"#C7C7C7").'"><input type="hidden" id="rzd2" name="rzd2" value="'.($gruppovuha[2]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[2]=='1'?'1':'0').'.gif" onClick="save1(2);" style="cursor: pointer;"><A HREF="?edit=1&razdel=2">&nbsp;������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 4) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?edit=1&razdel=4">&nbsp;�������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 6 && isset($_GET['sub']) && $_GET['sub'] == 1) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?edit=1&razdel=6&sub=1">&nbsp;���������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 6 && isset($_GET['sub']) && $_GET['sub'] == 0) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?edit=1&razdel=6&sub=0">&nbsp;�������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 3) ? "#A5A5A5":"#C7C7C7").'"><input type="hidden" id="rzd3" name="rzd3" value="'.($gruppovuha[3]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[3]=='1'?'1':'0').'.gif" onClick="save1(3);" style="cursor: pointer;"><A HREF="?edit=1&razdel=3">&nbsp;������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['razdel'] === 7) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?edit=1&razdel=7">���������</A></TD>

				</TR>
			</TABLE>
			</TD>
		</TR>
		<TR>
		<TD align=center><B>
	';


					// �����
					echo $part2;

					if ($die_invent==true)	{
						err("������ � ��������� ������������!");
						unset($_GET['edit']);
						include_once "end_files.php";

						echo '<BODY></HTML>';

						if (isset($miniBB_gzipper_encoding)) {
							$miniBB_gzipper_in = ob_get_contents();
							$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
							$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
							$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
							$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
							$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
							$percent = round($gzpercent);
							$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
							$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
							ob_clean();
							header('Content-Encoding: '.$miniBB_gzipper_encoding);
							echo $miniBB_gzipper_out;
						}
						die();
					}


					$group_by=0;
					$razdel=(intval($_SESSION['razdel']));
					if (isset($_GET['all'])) { $_SESSION['allp']=(int)($_GET['all']);}

					if ($_POST['rzd0']) {	$_SESSION['curp0']=0;}
					if ($_POST['rzd1']) {	$_SESSION['curp1']=0;}
					if ($_POST['rzd2']) {	$_SESSION['curp2']=0;}
					if ($_POST['rzd3']) {	$_SESSION['curp3']=0;}
					if ($_POST['rzd4']) {	$_SESSION['curp4']=0;}
					if ($_POST['rzd5']) {	$_SESSION['curp5']=0;}
					if ($_POST['rzd6']) {	$_SESSION['curp6']=0;}
					if ($_POST['rzd7']) {	$_SESSION['curp6']=0;}

					if (($_SESSION['need_clear_curp']!=true) and ($user['in_tower']>0)) {
						//���������� ��������� ������� ������� � ��������� - �.�. ������� � ��,�����
						$_SESSION['curp0']=0;
						$_SESSION['curp1']=0;
						$_SESSION['curp2']=0;
						$_SESSION['curp3']=0;
						$_SESSION['curp4']=0;
						$_SESSION['curp5']=0;
						$_SESSION['curp6']=0;
						$_SESSION['curp7']=0;
						$_SESSION['need_clear_curp']=true;
					} elseif (($_SESSION['need_clear_curp']==true) and ($user['in_tower']==0)) {
						//���������� ��������� ������� ������� � ��������� - �.�. ������� �� ��,�����
						$_SESSION['curp0']=0;
						$_SESSION['curp1']=0;
						$_SESSION['curp2']=0;
						$_SESSION['curp3']=0;
						$_SESSION['curp4']=0;
						$_SESSION['curp5']=0;
						$_SESSION['curp6']=0;
						$_SESSION['curp7']=0;
						$_SESSION['need_clear_curp']=false;
					}


					$m_part2 = microtime(true)-$m_part2;

					$t1 = microtime(true);


					$t1mm = microtime(true);
					$my_massa=0;
					$q = mysql_query("SELECT IFNULL(sum(`massa`),0) as massa , setsale, bs_owner, dressed  FROM oldbk.inventory WHERE `owner` = '{$user['id']}'   GROUP by setsale,bs_owner,dressed ");
					while ($row = mysql_fetch_array($q)) {
						if (($user['in_tower'] == $row['bs_owner']) AND   ($row['setsale'] ==0 )  AND   ($row['dressed'] ==0)) {
							$my_massa+=$row['massa'];
						}
					}
					$_SESSION['cache_inv_massa']="������ (���: ".$my_massa."/".get_meshok().")</B>";
					echo $_SESSION['cache_inv_massa'];

					$m_massatime = microtime(true)-$t1;

					$t1 = microtime(true);

					$podarok_order='';


					$_SESSION['razdel'] = intval($_SESSION['razdel']);

					switch($_SESSION['razdel']) {
						case 1: //zakljatija
							$where = "AND `type` = 12 ";
							$grrr=$gruppovuha[1]=='1'?'1':'0';
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp1']; } else {$_SESSION['curp1']=$_GET['page'];}
							break;
						case 2: //pro4ee
							$where = "AND `type` > 12 AND `type` NOT IN (99,200,555,556) AND `type` !=27 AND `type` !=28 AND `type` !=30 AND `type` !=33 and otdel != 62 AND `type` !=77  AND ( (`prototype` < 3001 or `prototype` > 3030) and (`prototype` < 103001 or `prototype` > 103030) and (`prototype` < 15551 or `prototype` > 15568)) ";
							$where .= 'AND NOT ((`prototype` > 3003000 and `prototype` < 3003100) or (`prototype` > 3003200 and `prototype` < 3003400) or (`prototype` > 3000 and `prototype` < 3030) or (`prototype` > 103000 and `prototype` < 103030) or (prototype >=1010000 and prototype <=1020000))';
							$grrr=$gruppovuha[2]=='1'?'1':'0';
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp2']; } else {$_SESSION['curp2']=$_GET['page'];}
							break;
						case 3: //karman
							$where = "AND `karman` = 1 ";
							$grrr=$gruppovuha[3]=='1'?'1':'0';
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp3']; } else {$_SESSION['curp3']=$_GET['page'];}
							break;
						default: //abmundir
							if ($filt==4) {
								$where = "AND (`type` in (4,27,28) ) ";
							} elseif ($filt>0) {
								$where = "AND (`type`='{$filt}' ) ";
							} else {
								$where = "AND (`type` < 12 OR `type`=27 OR `type`=28  OR `type`=555 OR `type`=556 OR  `type`=30 OR  `type`=33  ) ";
							}
							$grrr = ($gruppovuha[0]=='1'?'1':'0');
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp0']; } else {$_SESSION['curp0']=$_GET['page'];}
							break;
					}

					$count = 0;
					if($grrr == 1) {
						$sql = "SELECT *, count(*) as `itemscount` FROM (SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM oldbk.`inventory` WHERE `owner` = '".$_SESSION['uid']."' ".$where." AND id NOT IN (".GetDressedItems($user).") AND `setsale` = 0 AND bs_owner = ".$user['in_tower']." ORDER by `dategoden2` ASC,`update` DESC) as `inv` GROUP BY `prototype` ORDER BY ".$podarok_order." `update` DESC";
					} else {
						$sql = "SELECT * FROM oldbk.`inventory` WHERE `owner` = '".$_SESSION['uid']."' ".$where." AND id NOT IN (".GetDressedItems($user).") AND `setsale` = 0 AND bs_owner = ".$user['in_tower']." ".$giftfilter." ORDER by ".$podarok_order." `update` DESC";
					}
					//		echo $sql ;
					if ($_SESSION['razdel'] != 4 && $_SESSION['razdel'] != 6 && $_SESSION['razdel'] != 7 )  {
						$query = mysql_query($sql);
					} else {
						$query = false;
					}
					//		echo mysql_error();
					$m_selectime = microtime(true) - $t1;

					?>
				</TD>
			</TR>
			<TR><TD align=center><!--������-->
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					<script>
						var $jq1113 = jQuery.noConflict( true );
						var invitemclicked = 0;

						function absInvPosition(obj) {
							var x = y = 0;
							while(obj) {
								x += obj.offsetLeft;
								y += obj.offsetTop;
								obj = obj.offsetParent;
							}
							return {x:x, y:y};
						}

						function ToggleInvP(id) {
							if (invitemclicked) {
								var tmp = invitemclicked;
								invitemclicked = 0;
								//HideInvThing(null,"info"+tmp);
								HideInvThing($jq1113('[data-id="'+tmp+'"]'));
							} else {
								invitemclicked = id;
							}
						}

						$jq1113(function(){
							$jq1113(document.body).on('mouseover', '.gift-block', function(e){
								if(invitemclicked)
									return;
								e = e || window.event;

								var $self = $jq1113(this).addClass('active');
								var item_id = $self.data('id');

								var windowSize = getWindowSize();
								var hint_x = e.pageX + 10;
								var hint_y = e.pageY + 10;

								var $hint = $jq1113('#info' + item_id).css({'max-width':'500px','min-width':'200px'});
								if (e.clientX + $hint.width() >= windowSize.w && (e.clientX - $hint.width()) > 20) {
									hint_x = hint_x - $hint.width() - 20;
								}
								if (e.clientY + $hint.height() >= windowSize.h && (e.clientY - $hint.height()) > 20) {
									hint_y = hint_y - $hint.height() - 10;
								}
								//console.log(hint_y, $hint.height(), windowSize.h);

								$hint.css({'left': hint_x, 'top': hint_y}).show();
							});

							$jq1113(document.body).on('mouseout', '.gift-block', function(e){
								HideInvThing($jq1113(this));
							});
						});

						function getWindowSize() {
							var myWidth = 0, myHeight = 0;
							if( typeof( window.innerWidth ) == 'number' ) {
								//Non-IE
								myWidth = window.innerWidth;
								myHeight = window.innerHeight;
							} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
								//IE 6+ in 'standards compliant mode'
								myWidth = document.documentElement.clientWidth;
								myHeight = document.documentElement.clientHeight;
							} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
								//IE 4 compatible
								myWidth = document.body.clientWidth;
								myHeight = document.body.clientHeight;
							}

							return {w: myWidth, h: myHeight};
						}

						function HideInvThing($self) {
							if(invitemclicked)
								return;

							$self.removeClass('active');
							var item_id = $self.data('id');
							$jq1113('#info' + item_id).hide();
						}

						function ShowInvThing(obj, id) {
							//console.log(obj, id);
							var $self = $(obj);
							if (!invitemclicked) {
								//console.log($self);
								var item_id = $self.data('id');
								var $hint = $('#info' + item_id).show();

								var $imgclear = $('#imgclear' + item_id);
								if ($imgclear.length) {
									$imgclear.show();
								}

								var $imgapply = $('#imgapply' + item_id);
								if ($imgapply.length) {
									$imgapply.show();
								}

								var $imginv = $('#imginv' + item_id);
								if ($imginv) {
									$imginv.css({'opacity':'0.2'});
								}

								img_x = absInvPosition(obj).x; // ������� ������ ���������
								img_y = absInvPosition(obj).y;
								yshift = 75; // ����������� ��������
								xshift = 75;

								//console.log('�����', img_x, img_y);
								//console.log('����', $hint.width(), $hint.height());
								//console.log('����', $(window).width(), $(window).height());

								//alert('���������� ����: ' + img_x + ' - ' + img_y);
								//alert('������: ' + $("#"+id).width() + ' - ' + $("#"+id).height());
								//alert('����: ' + $(window).width() + ' - ' + $(window).height());
								//alert('���� ����: ' + $('body').width() + ' - ' + $('body').height());

								//1305 + 944 1419
								if (img_x + $hint.width() >= $(window).width()) { // ���� ������� ����� + ������ ������� ������ ������
									img_x = img_x - $hint.width() + xshift; // �� �� ������� ������� �������� ������ �������
								} else {
									img_x=img_x+xshift;
								}

								if (img_y + $hint.height() >= $(window).height()) {
									img_y = img_y - $hint.height() + yshift;
								} else {
									img_y=img_y+yshift;
								}

								//alert('���������� ����: ' + img_x + ' - ' + img_y);

								$hint.css({'top': img_y + "px", 'left': img_x + "px"});
							}

						}

						$jq1113(document).ready(function() {
							var InvinProgress = false;
							var InvCurPos = -1;

							var scrH = $(window).height();
							var scrHP = $("#mainitemtd").height();

							$jq1113(window).scroll(function() {
								howitems = Math.round(window.screen.availWidth / 10);

								var scro = $(this).scrollTop();
								var scrHP = $("#mainitemtd").height();
								var scrH2 = 0;
								scrH2 = scrH + scro;
								var leftH = scrHP - scrH2;

								if(InvCurPos == -1 || (leftH < 200 && !inProgress)) {
									if (InvCurPos == -1) InvCurPos = 0;
									$jq1113.ajax({
										url: 'main.php',
										async: true,
										method: 'GET',
										data: {"InvCurPos" : InvCurPos,"invload3" : "1","screenres" :  howitems},
										beforeSend: function() {
											$jq1113("#id_mainloader").show();
											inProgress = true;
										}
									}).done(function(data) {
										inProgress = false;
										$jq1113("#id_mainloader").hide();
										if (data.length > 0) {
											InvCurPos += howitems;
											$jq1113("#mainitemtd").html($jq1113("#mainitemtd").html() + data);
										} else {
											// ����������� ����
											InvCurPos = 0;
											inProgress = true;
										}
									});
								}
							});
							$jq1113(window).scroll();
							$(window).resize(function() {
								$jq1113(window).scroll();
							});
						});

					</script>
					<style>
						.invthing {
							position:absolute;
							z-index:9;
							border: 1px solid black;
							background-color:#ffffe1;
							min-width:10px;
							max-width:500px;
							padding-left:5px;
							padding-right:5px;
							padding-top:2px;
							padding-bottom:2px;
							box-shadow: 5px 5px 10px rgba(0,0,0,0.5);
							-moz-box-shadow: 5px 5px 10px rgba(0,0,0,0.5);
							-webkit-box-shadow: 5px 5px 10px rgba(0,0,0,0.5);
							border-radius:5px 0px 5px 5px;
							-moz-border-radius: 5px 0px 5px 5px;
							-webkit-border-radius: 5px 0px 5px 5px;
							line-height: 10px;
							font-size: 9px;

						}
						.invclear {
							position: absolute;
							top: 2px;
							left: 3px;
							display:none;
						}

						.invapply {
							position: absolute;
							top: 2px;
							left: 41px;
							display:none;
						}

						.invgroupcount {
							position: absolute;
							top: 41px;
							left: 3px;
							font-weight:bold;
							background-color:#717070;
							width:42px;
							#color:#06F;
							#color:#038;
							#color:#0066CC;
							color:white;
							filter:alpha(opacity=90);
							-moz-opacity: 0.9;
							opacity: 0.9;
							text-align:center;
						}

						.gift-block {
							margin-top:5px;
							width: 64px;
						}

						.gift-block .gift-image {
							opacity: 1;
						}
						.gift-block.active .gift-image {
							opacity: 0.2;
							/* IE 8 */
							-ms-filter: "alpha(opacity=20)";
							filter: alpha(opacity=20);
						}
						.gift-block.active .invclear, .gift-block.active .invapply {
							display: block;

						}
					</style>
					<TABLE BORDER=0 WIDTH=100% CELLSPACING="0" CELLPADDING="1" BGCOLOR="#A5A5A5">
						<?



						if ($_SESSION['razdel'] == 4) {
							echo '<tr><td colspan=2  bgcolor="#C7C7C7" height=18 align="center">';
							$sub = -1;
							if (isset($_SESSION['invsub4']) && !isset($_GET['sub'])) {
								$sub = $_SESSION['invsub4'];
							} else {
								$sub = isset($_GET['sub']) ? intval($_GET['sub']) : -1;
							}

							switch($sub) {
								default:
									echo '<a style="font-weight:normal;" href="?edit=1&razdel=4&sub=0">����������</a> | <a style="font-weight:normal;" href="?edit=1&razdel=4&sub=1">�������</a> | <a style="font-weight:normal;" href="?edit=1&razdel=4&sub=2">�� ����������</a>';
									$_SESSION['invsub4'] = -1;
									break;
								case 0:
									echo '<a href="?edit=1&razdel=4&sub=0">����������</a> | <a style="font-weight:normal;" href="?edit=1&razdel=4&sub=1">�������</a> | <a style="font-weight:normal;" href="?edit=1&razdel=4&sub=2">�� ����������</a>';
									$_SESSION['invsub4'] = 0;
									break;
								case 1:
									echo '<a style="font-weight:normal;" href="?edit=1&razdel=4&sub=0">����������</a> | <a href="?edit=1&razdel=4&sub=1"><b>�������</b></a> | <a style="font-weight:normal;" href="?edit=1&razdel=4&sub=2">�� ����������</a>';
									$_SESSION['invsub4'] = 1;
									break;
								case 2:
									echo '<a href="?edit=1&razdel=4&sub=0" style="font-weight:normal;">����������</a> | <a style="font-weight:normal;" href="?edit=1&razdel=4&sub=1">�������</a> | <a href="?edit=1&razdel=4&sub=2">�� ����������</a>';
									$_SESSION['invsub4'] = 2;
									break;
							}

							echo '</td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" style="width:18px;"></td><td bgcolor="#C7C7C7" id="mainitemtd"></td></tr>';
							echo '<tr><td colspan=2 bgcolor="#C7C7C7">';
							echo '<div id="id_mainloader" style="text-align:center;"><img src="http://i.oldbk.com/i/ajax-loader.gif" border="0"></div>';
							echo '</td></tr>';
						} else if ($_SESSION['razdel'] == 6) {
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 height=18 align="center">';
							$sub = -1;
							if (isset($_SESSION['invsub6']) && !isset($_GET['sub'])) {
								$sub = $_SESSION['invsub6'];
							} 
							else {
								$sub = isset($_GET['sub']) ? intval($_GET['sub']) : -1;
							}

							switch($sub) {
								default:
									$_SESSION['invsub6'] = -1;
									break;
								case 0:
									$_SESSION['invsub6'] = 0;
									break;

							}

							echo '</td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" style="width:18px;"></td><td bgcolor="#C7C7C7" id="mainitemtd"></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2>';
							echo '<div id="id_mainloader" style="text-align:center;"><img src="http://i.oldbk.com/i/ajax-loader.gif" border="0"></div>';
							echo '</td></tr>';
						} else if ($_SESSION['razdel'] == 7) {
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="left">&nbsp;&nbsp;&nbsp;<STRONG>��������� ������ ���������</STRONG><br>&nbsp;&nbsp;&nbsp;��������� ��������� ���� ����� ���������� ������ � �������� ��������� � �������� 20% </td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 height=30 align="center">';
							echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'></div>";

							//������ � �������
							include "cards_config.php";							

							$sql = "SELECT *, count(*) as `itemscount` FROM oldbk.`inventory` WHERE `owner` = '".$_SESSION['uid']."' AND type=99 AND `setsale` = 0 AND bs_owner = ".$user['in_tower']."  group by prototype ORDER by  `prototype` ";
							$q = mysql_query($sql);
							while($row = mysql_fetch_assoc($q))
							{
									if ($row['prototype']>=111000 and $row['prototype']<=111010)
										{
										$coll1[$row['prototype']]=$row;
										}
									else	if ($row['prototype']>=112000 and $row['prototype']<=112010)
										{
										$show_col2=true;
										$coll2[$row['prototype']]=$row;
										}
									else	if ($row['prototype']>=113000 and $row['prototype']<=113010)
										{
										$show_col3=true;
										$coll3[$row['prototype']]=$row;
										}
									else	if ($row['prototype']>=114000 and $row['prototype']<=114010)
										{
										$show_col4=true;
										$coll4[$row['prototype']]=$row;
										}										
									
							}

							foreach($coll1 as $ids => $item)
							{
								$row=$item;
								if (!(isset($row['id']))) { $row['id']=$ids; }

								if ((($row[id]==111010) or ($row['prototype']==111010)) and ($yes_ihave!=true))
								{
									echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> + </div>";
								}

								showitem2($row,$row['itemscount']);

								if ((($row[id]==111010) or ($row['prototype']==111010)) and ($yes_ihave!=true))
								{
									echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> = </div>";
								}

							}
							////////////////
							//if ($show_col2==true)
							{
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="left">&nbsp;&nbsp;&nbsp;<STRONG>��������� ����������� ��������</STRONG><br>&nbsp;&nbsp;&nbsp;��������� ��������� ������� ��� ������� <a href="http://oldbk.com/encicl/?/eda/angel_blagocard.html" target="_blank">����������� ����������</a>, ������ �������� 7 ����. </td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 height=30 align="center">';
							echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'></div>";
							
									foreach($coll2 as $ids => $item)
									{
										$row=$item;
										if (!(isset($row['id']))) { $row['id']=$ids; }
		
										if ((($row[id]==112010) or ($row['prototype']==112010)) and ($yes_ihave!=true))
										{
											echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> + </div>";
										}
		
										showitem2($row,$row['itemscount']);
		
										if ((($row[id]==112010) or ($row['prototype']==112010)) and ($yes_ihave!=true))
										{
											echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> = </div>";
										}
		
									}
							}
							////////////////
							//if ($show_col3==true)
							{
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="left">&nbsp;&nbsp;&nbsp;<STRONG>��������� ��������</STRONG><br>&nbsp;&nbsp;&nbsp;��������� ��������� ���� ����������� �������� ��� � ����� �������� ���</td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 height=30 align="center">';
							echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'></div>";
							
									foreach($coll3 as $ids => $item)
									{
										$row=$item;
										if (!(isset($row['id']))) { $row['id']=$ids; }
		
										if ((($row[id]==113010) or ($row['prototype']==113010)) and ($yes_ihave!=true))
										{
											echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> + </div>";
										}
		
										showitem2($row,$row['itemscount']);
		
										if ((($row[id]==113010) or ($row['prototype']==113010)) and ($yes_ihave!=true))
										{
											echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> = </div>";
										}
		
									}
							}
							///////////		
							
							////////////////
							if (true)
							{
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="left">&nbsp;&nbsp;&nbsp;<STRONG>��������� ������ ������� �����</STRONG><br>&nbsp;&nbsp;&nbsp;��������� ��������� ������� ��� ������� ������ �<a href=http://oldbk.com/encicl/?/mag1/ruineticket1.html target=_blank>������� � �����</a>�</td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 height=30 align="center">';
							echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'></div>";
							
									foreach($coll4 as $ids => $item)
									{
										$row=$item;
										if (!(isset($row['id']))) { $row['id']=$ids; }
		
										if ((($row[id]==114010) or ($row['prototype']==114010)) and ($yes_ihave!=true))
										{
											echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> + </div>";
										}
		
										showitem2($row,$row['itemscount']);
		
										if ((($row[id]==114010) or ($row['prototype']==114010)) and ($yes_ihave!=true))
										{
											echo "<div style='float: left; top: 15px; position: relative; padding: 8px; font-size: 18px; font-style: bold;'> = </div>";
										}
		
									}
							}
							///////////													

							echo '</td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2 align="center"><hr></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" style="width:18px;"></td><td bgcolor="#C7C7C7" id="mainitemtd"></td></tr>';
							echo '<tr><td bgcolor="#C7C7C7" colspan=2>';
							echo '<div id="id_mainloader" style="text-align:center;"><img src="http://i.oldbk.com/i/ajax-loader.gif" border="0"></div>';
							echo '</td></tr>';
						}

						else {

							$displc = 0;
							$displcn = 0;
							$_SESSION['lim'] = 10;
							$_GET['page'] = (int)$_GET['page'];
							if ($_GET['page'] < 0) {$_GET['page']=0;}

							$lastpresentid = -1;

							$ret = "";

							$count = mysql_num_rows($query);
							$count_all = $count;

							$art_items_ids=array();

							while($row = mysql_fetch_assoc($query)) {

								if ($row['art_param']!='')
								{
									$art_items_ids[]=$row['id'];// ���������� �� �����
								}

								if($grrr == 1) {
									// ���� �� ���������, �� ����� �������� ��������
									// ���� ������� � �������� - �� �� �������� ���������� �� ������
									if($row['otdel']==7 || $row['otdel']==71 || $row['otdel']==72|| $row['otdel']==73) {
										if ($lastpresentid == -1) {
											$inv_shmot[] = $row;
											end($inv_shmot);
											$lastpresentid = key($inv_shmot);
										} else {
											$inv_shmot[$lastpresentid]['itemscount'] += $row['itemscount'];
											$count--;
										}
									} else {
										// ���� ��� ��������� - �� �� �� ���������
										$inv_shmot[] = $row;
									}
								} else {

									$inv_shmot[]=$row;

									if ($_SESSION['allp'] != 1) {
										if ($displcn >= $_GET['page']*$_SESSION['lim']+$_SESSION['lim']) break;
									}
									$displcn++;
								}
							}

							if (!empty($ret)) {
								$displc = $count;
							}


// ������ ������ �� ������ �����
							if ((is_array($art_items_ids)) and (count($art_items_ids)>0) )
							{
								$bonus_data=mysql_query("select * from oldbk.art_bonus where itemid in (".implode(",",$art_items_ids).")");
								if (mysql_num_rows($bonus_data)>0)
								{
									while($art_row = mysql_fetch_assoc($bonus_data))
									{
										$art_bonus_array[$art_row['itemid']]=$art_row;
									}
								}
							}



							if($grrr == 1) {
								$ret = "";
								reset($inv_shmot);

								foreach ($inv_shmot as $key => $row) {
									if ((($_SESSION['allp'] != 1) and ($displc >= $_GET['page']*$_SESSION['lim']) AND ($displc < $_GET['page']*$_SESSION['lim']+$_SESSION['lim'])) || $_SESSION['allp'] == 1) {
										if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }

										if ($row['itemscount'] == 1) {
											$ret .= "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";

											if ($row['art_param']!='')
											{

												if (is_array($art_bonus_array[$row['id']]))
												{
													$row['bonus_info']=$art_bonus_array[$row['id']]['info'];
													$row['art_proto_id']=$art_bonus_array[$row['id']]['art_proto'];
													$row['art_proto_name']=$art_bonus_array[$row['id']]['art_proto_name'];
													$row['art_proto_img']=$art_bonus_array[$row['id']]['art_proto_img'];													
												}
											}

											$ret .= showitem($row,0,false,$color,'',0,0,1);
											$ret .= "</table>";
										} else {
											$ret .= "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
											$ret .= showitem($row,0,false,$color,'',0,0,1);
											$ret .= "<tr BGCOLOR='".$color."' ><td colspan=2>";
											$ret .= '<div  id=txt_'.$row['prototype'].' style="display: block;">';
											if ($row['otdel'] == "") $row['otdel'] = 0;
											$ret .= "<a href=\"#".$row['prototype']."\" Onclick=\"showhiddeninv(".$row['prototype'].",".$row['id'].",".$row['otdel'].");\"> �������� ��� ".($row['itemscount']-1)."��.</a></div>";
											$ret .= '<div  id="txt1_'.$row['prototype'].'" style="display: none;">';
											$ret .= "<a href=\"#".$row['prototype']."\" Onclick=\"closehiddeninv(".$row['prototype'].");\">������</a></div></td></tr>";
											$ret .= '</table><div style="display: none;" id="id_'.$row['prototype'].'"><img src="http://i.oldbk.com/i/ajax-loader.gif" border=0></div>';

										}
									}
									$displc++;

									if ($_SESSION['allp'] != 1) {
										if ($displc >= $_GET['page']*$_SESSION['lim']+$_SESSION['lim']) break;
									}
								}
								$displc = $count;
							}
							else
							{
								$displcno=0;
								foreach ($inv_shmot as $key => $row)
								{
									if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }

									if ((($_SESSION['allp'] != 1) and ($displcno >= $_GET['page']*$_SESSION['lim']) AND ($displcno < $_GET['page']*$_SESSION['lim']+$_SESSION['lim'])) || $_SESSION['allp'] == 1) {

										if ($row['art_param']!='')
										{

											if (is_array($art_bonus_array[$row['id']]))
											{
												$row['bonus_info']=$art_bonus_array[$row['id']]['info'];
												$row['art_proto_id']=$art_bonus_array[$row['id']]['art_proto'];
												$row['art_proto_name']=$art_bonus_array[$row['id']]['art_proto_name'];
												$row['art_proto_img']=$art_bonus_array[$row['id']]['art_proto_img'];													
											}
										}
										$ret .= showitem($row,0,false,$color,'',0,0,1);
									}

									$displcno++;
								}
								$displc = $count_all;
							}
//echo $displc  ;

							if ($_SESSION['allp']==1) {
								echo "[<a href='?edit=1&razdel=".$razdel."&all=0'>��������</a>]";
							} else {
								$pgs[0]=$displc;

								$_GET['page']=(int)$_GET['page'];
								if (($_GET['page']*$_SESSION['lim']) >= $pgs[0]) {
									$_GET['page']=0;
								}

								$pgs = $pgs[0]/$_SESSION['lim'];
								if ($pgs>1) {
									echo "��������: ";
								}
								$pages_str='';

								$page = (int)$_GET['page']>0 ? (((int)$_GET['page']+1)>$pgs ? ($pgs-1):(int)$_GET['page']):0;
								$page=ceil($page);

								if ($pgs>1) {
									for ($i=0;$i<ceil($pgs);$i++)
										if (($i>($page-5))&&($i<=($page+4)))
											$pages_str.=($i==$page ? "&nbsp;<b>".($i+1)."</b>&nbsp;":"&nbsp;<a href='?edit=1&razdel=".$razdel."&page=".($i)."'>".($i+1)."</a>&nbsp;");
									$pages_str.=($page<$pgs-5 ? "...":"");
									$pages_str=($page>4 ? "<a href='?edit=1&razdel=".$razdel."&page=".($page-1)."'> < </a> ... ":"").$pages_str.(($page<($pgs-1) ? "<a href='?edit=1&razdel=".$razdel."&page=".($page+1)."' > ></a> ":""));
								}

								$FirstPage=(ceil($pgs)>4 ? $_GET['page']>0 ? "<a href='?edit=1&razdel=".$razdel."&page=0'>   << </a>":"":"");
								$LastPage=(ceil($pgs)>4 ? (ceil($pgs)-1)!=$_GET['page'] ? "<a href='?edit=1&razdel=".$razdel."&page=".(ceil($pgs)-1)."'>   >> </a>":"":"");
								$pages_str=$FirstPage.$pages_str.$LastPage;
								echo $pages_str; echo " [<a href='?edit=1&razdel=".$razdel."&all=1'>���</a>]";
							}




							if ($count === 0) {
								echo "<tr><td align=center bgcolor=#C7C7C7>�����</td></tr>";
							} else {
								echo $ret;
							}

							if ($pgs>1) {
								echo "<TR><TD colspan=2 align=center>";
								echo "��������: ";
								echo $pages_str;
								echo "</TD></TR>";
							}
						}

						?>



					</TABLE>
				</TD></TR>
		</TABLE>

		</TD>
	</FORM>
	</TR>
	</TABLE>
	<?php
	if ($errkom==1){
		?>
		<script language="javaScript">okno('��������� ��������','main.php?edit=1','savecomplect','<?=$_POST['savecomplect']?>',1)</script>
		<?php
	}
	if(!$_SESSION['beginer_quest']['none'])
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
		$quest_nm=check_quest_step();
		$last_q=check_last_quest(4);
		if($last_q)
		{

			quest_check_type_4($last_q);
			//i?iaa?yai eaanou ia oa?-e
		}

		$last_q=check_last_quest(2);
		if($last_q)
		{
			//ECHO '2  TESTSTSTE EDF';
			quest_check_type_2($last_q);
		}
		if(!$_SESSION['beginer_quest']['none'])
		{
			$last_q=check_last_quest(5);
			if($last_q)
			{
				quest_check_type_5($last_q);
			}
		}
	}
	?>
	<? include_once "end_files.php"; ?>
	</BODY>

	</HTML>
	<?php

	

/////////////////////////////////////////////////////
	$m_rendertime = microtime(true)-$t1mm;
	echo '<!-- Select: '.$m_selectime.' UseTime: '.$m_usetime.' RenderTime: '.$m_rendertime.' Massa: '.$m_massatime.' Part1: '.$m_part1.' Part2: '.($m_part2).' UDR: '.$m_udr.' All: '.(microtime(true)-$m_alltime).' -->';
	if (isset($miniBB_gzipper_encoding)) {
		$miniBB_gzipper_in = ob_get_contents();
		$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
		$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
		$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
		$percent = round($gzpercent);
		$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
		$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
		ob_clean();
		header('Content-Encoding: '.$miniBB_gzipper_encoding);
		echo $miniBB_gzipper_out;
	}
/////////////////////////////////////////////////////
	die();
}

//==========================================================================================================
if ($user['room'] == 20) { header('Location: city.php'); die(); }
if ($user['room'] == 21) { header('Location: city.php'); die(); }
if ($user['room'] == 66) { header('Location: city.php'); die(); }
if ($user['room'] == 191) { header('Location: city.php'); die(); }
if ($user['room'] == 22) { header('Location: shop.php'); die(); }
if ($user['room'] == 23) { header('Location: repair.php'); die(); }
if ($user['room'] == 24) { header('Location: elka.php'); die(); }
if ($user['room'] == 26) { header('Location: city.php'); die(); }
if ($user['room'] == 25) { header('Location: comission.php'); die(); }
if ($user['room'] == 29) { header('Location: bank.php'); die(); }
if ($user['room'] == 34) { header('Location: fshop.php'); die(); }
if ($user['room'] == 28) { header('Location: klanedit.php'); die(); }
if ($user['room'] == 49) { header('Location: church.php'); die(); }
if ($user['room'] == 51) { header('Location: bench.php'); die(); }
if ($user['room'] == 52) { header('Location: bench.php'); die(); }
if ($user['room'] == 53) { header('Location: bench.php'); die(); }
if ($user['room'] == 27) { header('Location: post.php'); die(); }
if ($user['room'] == 31) { header('Location: tower.php'); die(); }
if ($user['room'] == 35) { header('Location: eshop.php'); die(); }
if ($user['room'] >= 37 AND $user['room'] <= 41) { header('Location: gotzamok.php'); die(); }
if ($user['room'] == 42) { header('Location: lotery.php'); die(); }
if ($user['room'] == 43) { header('Location: znahar.php'); die(); }
if ($user['room'] == 999) { header('Location: ruines_start.php'); die(); }
if ($user['room'] == 90) { header('Location: lord.php'); die(); }

if ($user['room'] == 10000) { header('Location: dt_start.php'); die(); }
if (($user['room'] > 10000) and ($user['room'] < 11000))  { header('Location: dt.php'); die(); }

if ($user['room'] == 61000) { header('Location: station.php'); die(); }
if (($user['room'] > 61000) and ($user['room'] < 62000))  { header('Location: station_go.php'); die(); }
if (($user['room'] >=1000) and ($user['room'] <=10000))  { header('Location: ruines.php'); die(); }

if ($user['room'] >= 50000 && $user['room'] <= 53600) { header('Location: map.php'); die(); }
if ($user['room'] == 70000) { header('Location: castles.php'); die(); }
if ($user['room'] > 70000 && $user['room'] < 71000) { header('Location: castles_pre.php'); die(); }
if ($user['room'] > 71000 && $user['room'] < 72000) { header('Location: castles_inside.php'); die(); }
if ($user['room'] == 72001) { header('Location: castles_tur.php'); die(); }

reset($map_locations);
while(list($k,$v) = each($map_locations)) {
	if ($v['room'] == $user['room']) { header('Location: '.$v['redirect']); die(); }
}


// ���� �� �����
if ($user['room'] == 53601) { header('Location: mlpereprava.php'); die(); }
if ($user['room'] == 53602) { header('Location: mlpereprava.php'); die(); }

if ($user['room'] == 197 || $user['room'] == 199)  { header('Location: armory.php'); die(); }
if ($user['room'] == 198)  { header('Location: castles_armory.php'); die(); }
if (($user['in_tower'] ==3) and ($user['room']<90000))   { header('Location: restal210.php'); die(); } // ���� �������
if ($user['in_tower'] ==3)   { header('Location: restal270.php'); die(); }
if (($user['room'] >= 200)AND($user['room'] <= 300))  { header('Location: restal.php'); die(); }
if ($user['room'] == 80)  { header('Location: garb.php'); die(); }
if ($user['room'] == 201) { header('Location: f'); die(); }
if ($user['room'] == 401) { header('Location: hell.php'); die(); }
if ($user['room'] == 43) { header('Location: znahar.php'); die(); }
if ($user['room'] == 44) { header('Location: roomtest.php'); die(); }
if ($user['room'] == 45) { header('Location: startlab.php'); die(); }
if ($user['room'] == 46) { header('Location: prokat.php'); die(); }
if ($user['room'] == 47)  { header('Location: rentalshop.php'); die(); }
if ($user['room'] == 48) { header('Location: cshop.php'); die(); }
if ($user['lab'] == 1) { header('Location: lab.php'); die(); }
if ($user['lab'] == 2) { header('Location: lab2.php'); die(); }
if ($user['lab'] == 3) { header('Location: lab3.php'); die(); }
if ($user['lab'] == 4) { header('Location: lab4.php'); die(); }
if ($user['room'] == 50) { header('Location: city.php'); die(); }
if ($user['room'] == 60) { header('Location: city.php'); die(); }
if ($user['room'] == 70)  { header('Location: pawnbroker.php'); die(); }
if ($user['room'] == 71)  { header('Location: auction.php'); die(); }
if ($user['room'] == 72)  { header('Location: fair.php'); die(); }
if ($user['room'] >= 91 && $user['room'] <= 97)  { header('Location: craft.php'); die(); }


//if ($user['room'] == 61) { header('Location: dcamp.php'); die(); }
//if ($user['room'] == 62) { header('Location: lcamp.php'); die(); }

if ($user['in_tower'] == 15) { header('Location: dt.php'); die(); }
//��
if ($user['in_tower'] == 1) { header('Location: towerin.php'); die(); }

?>
<HTML><HEAD>
	<link rel=stylesheet type="text/css" href="i/main.css">
    <link rel="stylesheet" href="/i/btn.css" type="text/css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<script type="text/javascript" src="/i/globaljs.js"></script>
	<script>
		var Hint3Name = '';
		// ���������, �������� �������, ��� ���� � �������
		function findlogin(title, script, name){
			var el = document.getElementById("hint3");
			el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
					'<form action="'+script+'" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
					'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=50% align=right><INPUT id="'+name+'" TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
			el.style.visibility = "visible";
			el.style.left = 100 + 'px';
			el.style.top = 100 + 'px';
			document.getElementById(name).focus();
			Hint3Name = name;
		}
		// ���������, �������� �������, ��� ���� � �������
		function okno(title, script, name,coma){
			var el = document.getElementById("hint3");
			el.innerHTML = '<form action="'+script+'" method=POST><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
					'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
					'������� �������� ��������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></td></tr></table></form>';
			el.style.visibility = "visible";
			el.style.left = 100 + 'px';
			el.style.top = 100 + 'px';
			document.getElementById(name).focus();
			Hint3Name = name;
		}

		function oknoCity(title, script, name,coma,errk){
			var errkom=''; var com='';
			var el = document.getElementById("hint3");
			if (errk==1) { errkom='������ ������������ �������: /:*?"<>|+%&#\'\\<br>'; com=coma}
			el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
					'<form action="'+script+'" method=POST><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2><font color=red>'+
					errkom+'</font>������� �������� ������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" NAME="'+name+'" value="'+com+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
			el.style.visibility = "visible";
			el.style.left = 100;
			el.style.top = 100;
			document.getElementById(name).focus();
			Hint3Name = name;
		}

		function oknoTeloCity(title, script, name,city,coma,errk){
			var errkom=''; var com='';
			var el = document.getElementById("hint3");
			if (errk==1) { errkom='������ ������������ �������: /:*?"<>|+%&#\'\\<br>'; com=coma}
			el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
					'<form action="'+script+'" method=POST><table border=0 width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2><font color=red>'+
					errkom+'</font>������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</small></TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" NAME="'+name+'" value="'+com+'"></TD><TD width=50%></TD></TR><tr><td colspan=2>������� �������� ������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+city+'" NAME="'+city+'" value="'+com+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></FORM></td></tr></table>';
			el.style.visibility = "visible";
			el.style.left = 100;
			el.style.top = 100;
			document.getElementById(name).focus();
			Hint3Name = name;
		}

		// ���������, �������� �������, ��� ���� � ������
		function oknoPass(title, script, name,coma){
			var el = document.getElementById("hint3");
			el.innerHTML = '<form action="'+script+'" method=POST><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
					'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
					'������� ������ ��� �������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=password NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></td></tr></table></form>';
			el.style.visibility = "visible";
			el.style.left = 100 + 'px';
			el.style.top = 100 + 'px';
			document.getElementById(name).focus();
			Hint3Name = name;
		}

		function closehint3(){
			document.getElementById("hint3").style.visibility="hidden";
			Hint3Name='';
		}
	</script>
	<script>
		//function refreshPeriodic()
		//{
		//	location.href='main.php';//reload();
		//	timerID=setTimeout("refreshPeriodic()",30000);
		//}
		//timerID=setTimeout("refreshPeriodic()",30000);
	</script>
	<script type="text/javascript" src="http://i.oldbk.com/i/showthing.js"></script>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 onLoad="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>)">
<input type=hidden id=penemy value=0>
<input type=hidden id=txtblockzone value=0>
<!--8888-->
<?
make_quest_div();
?>
<?php

//	$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM oldbk.`inventory` WHERE `owner` = '{$user['id']}' AND `dressed` = 0 AND `setsale` = 0 ; "));
if($my_massa > get_meshok() && $_GET['goto'])
{
	echo "<font color=red><b>� ��� ���������� ������, �� �� ������ ������������...</b></font>";
	$_GET['goto']=0;
}
$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$u['id']."' AND (`type` = 14 OR `type` = 13);"));
if($eff && $_GET['goto']) {
	echo "<font color=red><b>� ��� ������� ������, �� �� ������ ������������...</b></font>";
	$_GET['goto']=0;
}

//if(@$_GET['goto'] == 'plo') {
if($_GET['goto']) {

	//fix ollllllllllldddd bug
	if(($user['zayavka']!=0) and ($user['zayavka']<100000000))
	{
		$get_zay=mysql_fetch_array(mysql_query("select * from zayavka where id={$user['zayavka']} ; "));
		if ($get_zay[0] > 0)
		{
			// zayavka is true
		}
		else
		{
			// is bug
			mysql_query("UPDATE users set zayavka=0 where id={$user['id']};");
			$user['zayavka']=0;
		}
	}


	if($user['zayavka']== 0) {
		mysql_query("UPDATE `users`  SET `users`.`room` = '20' WHERE `users`.`id` = '{$_SESSION['uid']}' and battle=0 ;");

		if (mysql_affected_rows()>0)
		{
			die("
			<script>
				function cityg(){
					location.href='city.php';
				}
				setTimeout('cityg()', ".($user['klan']=='Adminion'||$user['klan']=='radminion'?'1':'5000').");
			</script>
			<center><BR><BR><BR>
				<i>������ �� ����������� �������...</i>
			</center>");
		}
	} else
	{
		echo "<font color=red><b>������ ������ �� ��� � �������� �� �����? ��������...</b></font>";
	}
}
if (@$_GET['use']) {
	$_GET['use']=(int)$_GET['use'];
	usemagic($_GET['use'],$_POST['target']);
}

if(!$_SESSION['beginer_quest']['none'])
{
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
	$quest_nm=check_quest_step();
	$last_q=check_last_quest(4);
	if($last_q)
	{

		quest_check_type_4($last_q);
		//��������� ������ �� ���-�
	}

	$last_q=check_last_quest(2);
	if($last_q)
	{
		//ECHO '2  TESTSTSTE EDF';
		quest_check_type_2($last_q);
	}
	if(!$_SESSION['beginer_quest']['none'])
	{
		$last_q=check_last_quest(5);
		if($last_q)
		{
			quest_check_type_5($last_q);
		}
	}
}

?>
<link rel="stylesheet" href="/i/btn.css" type="text/css">
<div id=hint3 class=ahint style="z-index:500;"></div>
<?php

	require_once("config_ko.php");
	if ((time()>$KO_start_time19) and (time()<$KO_fin_time19))
		{
		if (isset($_SESSION['ny_quest_q1'])) {
			echo '
				<div id="questdiv" style="z-index: 300; position: absolute; left: 50px; top: 30px; background: #DEDCDD url(http://capitalcity.oldbk.com/i/quest/fp_1.png) no-repeat; background-position: top;width: 688px; border: 1px solid black; padding-top:17px;">
				<table width=100% height=100% cellpadding=20 cellspacing=0 style="background: url(http://capitalcity.oldbk.com/i/quest/fp_2.jpg) repeat-y;">
				<tr>
				<td valign="top">
				<b style="color:#038;">����� "������� �������" ��������!</b>
				<br><br>
				<a href="#" OnClick="$(\'#questdiv\').hide();return false;">�������</a></center>
				</td></tr>
				</tr>
				</table>
				<img src="http://capitalcity.oldbk.com/i/quest/fp_3.png">
				</div>
			';
			unset($_SESSION['ny_quest_q1']);
		}
		}

?>

<TABLE width=100% cellspacing=0 cellpadding=0>
	<TR>
		<TD valign=top align=left width=250>
			<?=showpersout($_SESSION['uid'])?>
		</TD>
		<FORM METHOD=GET ACTION="main.php">
			<TD valign=top align=right>
				<IMG SRC='http://i.oldbk.com/i/1x1.gif' WIDTH=1 HEIGHT=5><BR>
				<ul class="btn-control main">
					<li>
						<div class="button-big btn" name="combats" title="��������" onClick="location.href='zayavka.php';"><strong>��������</strong></div>
					</li>
					<li>
						<div class="button-big btn" title="��������� / ���������" onClick="location.href='main.php?edit=1';">��������� / ���������</div>
					</li>
					<li>
						<div class="button-big btn" title="����� �����" onClick="location.href='main.php?setch=����� �����';"><strong>����� �����</strong></div>
					</li>
					<li>
						<div class="button-big btn" title="����� �� ����������� �������" onClick="location.href='main.php?goto=plo';">����� �� ����������� �������</div>
					</li>
					<li>
						<div class="button-big btn" title="���������" onClick="location.href='?edit=1&effects=1'">���������</div>
					</li>
					<li>
						<div class="button-big btn" title="�������� �����" onClick="location.href='main.php?sssetch=�������� �����';">�������� �����</div>
					</li>
				</ul>
				<HR>
				<small>
					<A HREF="http://oldbk.com/news.php" target=_blank>�������</A> /  <A HREF="http://oldbk.com/encicl/" target=_blank>������������</A> /  <A HREF="http://oldbk.com/forum.php" target=_blank>�����</A> /  <A HREF="http://top.oldbk.com/" target=_blank>�������</A> / <A HREF="http://oldbk.com/commerce/index.php?uid=<?php echo $_SESSION['uid']; ?>&alog=<? echo $_SESSION['sid']; ?>" target=_blank>���.�����</A> &nbsp;&nbsp;&nbsp;
					<BR><BR>
					<b>������� ������:</b>&nbsp;&nbsp;
					<?

					$date = date("dmY");
					$data=mysql_query("select * from topsites.top where  cat=0 AND klan !='Ice' and ban=0 and date like '".$date." | %' order by hoststoday DESC, hitsin DESC, allhosts DESC LIMIT 5;");
					while($row = mysql_fetch_assoc($data))
					{
						if ($row['klan']=='align_1.99') { $row['klan']='����� ���������'; }

						$row['url']=str_replace('http://','',$row['url']);
						$row['url']=str_replace('http//','',$row['url']);
						$row['url']=str_replace('http','',$row['url']);

						echo "<nofollow><noindex>[<a href='http://".$row['url']."' target='_blank'>".$row['klan']."</a>] &nbsp;</noindex></nofollow>";
					}

					?>
					&nbsp;<br></small>

				<HR>
				<div style="padding-right:10px;">
					<div class="button-mid btn" title="������" onClick="location.href='friends.php?pals=1';">������</div>
					<div class="button-big btn" title="�������� ������" onClick="location.href='friends.php?pals=2';">�������� ������</div>
					<div class="button-big btn" title="������ ������" onClick="location.href='friends.php?pals=3';">������ ������</div>
					<div class="button-big btn" title="RDJ � �����" onClick="location.href='friends.php?pals=10';">RDJ � �����</div>
				</div>

				<BR><BR><small>
					<B>��������!</B> ������� � ������ �� �������� ������ �� ������ ���������. �� ������� ������ �� ������ ������, ���� "����� �����", "�������", "���, ��� ��� ���� �� ������". ������ �� ����� �� ���������, �� ������, �� �������������, <U>������ ����������</U> ��� ����� ������ �����.<BR>
					<I>�������������.</I></small>
				<BR><BR>

				<!-- Yandex.Metrika counter -->
				<script type="text/javascript">
					(function (d, w, c) {
						(w[c] = w[c] || []).push(function() {
							try {
								w.yaCounter1256934 = new Ya.Metrika({id:1256934,
									accurateTrackBounce:true, webvisor:true});
							} catch(e) {}
						});

						var n = d.getElementsByTagName("script")[0],
								s = d.createElement("script"),
								f = function () { n.parentNode.insertBefore(s, n); };
						s.type = "text/javascript";
						s.async = true;
						s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

						if (w.opera == "[object Opera]") {
							d.addEventListener("DOMContentLoaded", f);
						} else { f(); }
					})(document, window, "yandex_metrika_callbacks");
				</script>
				<noscript><div><img src="//mc.yandex.ru/watch/1256934" style="position:absolute; left:-9999px;" alt="" /></div></noscript>

				<!--LiveInternet counter--><script type="text/javascript"><!--
					document.write("<a href='http://www.liveinternet.ru/click' "+
							"target=_blank><img src='http://counter.yadro.ru/hit?t54.2;r"+
							escape(document.referrer)+((typeof(screen)=="undefined")?"":
							";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
									screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
							";"+Math.random()+
							"' alt='' title='LiveInternet: �������� ����� ���������� �"+
							" ����������� �� 24 ����' "+
							"border='0' ><\/a>")
					//--></script><!--/LiveInternet-->


				<!--Rating@Mail.ru counter-->
				<script language="javascript" type="text/javascript"><!--
					d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
				<script language="javascript1.1" type="text/javascript"><!--
					a+=';j='+navigator.javaEnabled();js=11;//--></script>
				<script language="javascript1.2" type="text/javascript"><!--
					s=screen;a+=';s='+s.width+'*'+s.height;
					a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
				<script language="javascript1.3" type="text/javascript"><!--
					js=13;//--></script><script language="javascript" type="text/javascript"><!--
					d.write('<a href="http://top.mail.ru/jump?from=1765367" target="_blank">'+
							'<img src="http://df.ce.ba.a1.top.mail.ru/counter?id=1765367;t=49;js='+js+
							a+';rand='+Math.random()+'" alt="�������@Mail.ru" border="0" '+
							'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
				<noscript><a target="_blank" href="http://top.mail.ru/jump?from=1765367">
						<img src="http://df.ce.ba.a1.top.mail.ru/counter?js=na;id=1765367;t=49"
							 height="31" width="88" border="0" alt="�������@Mail.ru"></a></noscript>
				<script language="javascript" type="text/javascript"><!--
					if(11<js)d.write('--'+'>');//--></script>
				<!--// Rating@Mail.ru counter-->


			</TD>
		</FORM>
	</TR>
</TABLE>
<!-- Asynchronous Tracking GA bottom piece counter-->
<script type="text/javascript">
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
	})();
</script>

<!-- Asynchronous Tracking GA bottom piece end -->
<?
include_once "end_files.php";
?>
</BODY>
</HTML>
<?

/////////////////////////////////////////////////////
if (isset($miniBB_gzipper_encoding)) {
	$miniBB_gzipper_in = ob_get_contents();
	$miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
	$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
	$miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
	$miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
	$gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
	$percent = round($gzpercent);
	$miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
	$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
	ob_clean();
	header('Content-Encoding: '.$miniBB_gzipper_encoding);
	echo $miniBB_gzipper_out;
}
/////////////////////////////////////////////////////

?>
