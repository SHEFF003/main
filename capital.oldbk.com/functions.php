<?php
//24/04/2013 - multicity+new
define("olddelo",0); //�������� ������ ������� ���� - ��������� �� ��� ��� ��� ���� ����� ����� ��� �����
include "configcity.php"; // ���������� ��������� ������
include "cr.php"; // ���������� ���������


if(isset($_SERVER["PHP_SELF"]) && $_SERVER["PHP_SELF"] == "/functions.php") {
   	die('Incorrent access');
}

if (isset($_SESSION['KO_login'])) {
	header("Location: http://capitalcity.oldbk.com/index.php?exit=ture");
	die('<script> window.location=\'http://capitalcity.oldbk.com/index.php?exit=yes\';</script>');
}

$db_city[0]='oldbk.';
$db_city[1]='avalon.';
$db_city[2]='angels.';
$city_name[0]='CapitalCity';
$city_name[1]='AvalonCity';
$city_name[2]='AngelsCity';

$nodress=array(19104,19105,19106,19107,1120,56661,56662,56663,56664,56665,56666,56667,56668,20104,20105,20106,20107,19104,19105,19106,19107);

$noclass_items_ok=array(3,12,27,28,34);

$nclass_name[0]='�����';     //����������� = ������ ��������
$nclass_name[1]='���������';
$nclass_name[2]='��������';
$nclass_name[3]='����';
$nclass_name[4]='�����';     //����� ������ ����� = ����� ��������



header("Cache-Control: no-cache");
if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']) )     	 	{     	$_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_CF_CONNECTING_IP'];    	}

$ip = $_SERVER['REMOTE_ADDR'];

include "new_delo.php";
include("banlist.php");
include "addfunction.php";
require_once('memcache.php');
require_once('runs_exp_table.php');

$rep_rate=20;
$hollyday=0; //��������� �� ��������� ������� �������,:
 /*
 ���� 1:
 ��������-����� �� ������.
 ������, �������, ����, ���� ���� - �� ���������� �� �������. ����� ���� �������� ����� ������� �� ����� ��������
 ������� �����, ������ �����, ����� - ����� ���� �������� ����� �������������� �� ����� ���� ������������� ��������
 �����
 */

if (!defined("DRESSED_BOTH")) define("DRESSED_BOTH",0);
if (!defined("DRESSED_ITEMS")) define("DRESSED_ITEMS",1);
if (!defined("DRESSED_MAGIC")) define("DRESSED_MAGIC",2);

function GetDressedItems($user,$type = DRESSED_BOTH) {
	$ret = "";

	if ($type == DRESSED_BOTH || $type == DRESSED_ITEMS) {
		if ($user['sergi']) $ret .= $user['sergi'].",";
		if ($user['kulon']) $ret .= $user['kulon'].",";
		if ($user['perchi']) $ret .= $user['perchi'].",";
		if ($user['weap']) $ret .= $user['weap'].",";
		if ($user['bron']) $ret .= $user['bron'].",";
		if ($user['r1']) $ret .= $user['r1'].",";
		if ($user['r2']) $ret .= $user['r2'].",";
		if ($user['r3']) $ret .= $user['r3'].",";
		if ($user['helm']) $ret .= $user['helm'].",";
		if ($user['shit']) $ret .= $user['shit'].",";
		if ($user['boots']) $ret .= $user['boots'].",";
		if ($user['nakidka']) $ret .= $user['nakidka'].",";
		if ($user['rubashka']) $ret .= $user['rubashka'].",";
		if ($user['runa1']) $ret .= $user['runa1'].",";
		if ($user['runa2']) $ret .= $user['runa2'].",";
		if ($user['runa3']) $ret .= $user['runa3'].",";
	}

	if ($type == DRESSED_BOTH || $type == DRESSED_MAGIC) {
		for ($i = 1; $i <= 20; $i++) {
			if ($user['m'.$i]) $ret .= $user['m'.$i].",";
		}
	}

	if (strlen($ret)) {
		$ret = substr($ret,0,strlen($ret)-1);
		return $ret;
	} else {
		return "0";
	}
}


function getMaximumSlot($prem) {
	if ($prem == 1) return 16;
	if ($prem == 2) return 18;
	if ($prem == 3) return 20;
}

function getAddSlot($prem) {
	if ($prem == 1) return 1;
	if ($prem == 2) return 3;
	if ($prem == 3) return 5;
}


     function get_battle_array($battle) {
        $query_fd = mysql_query("SELECT razmen_to,razmen_from,attack,block FROM battle_fd WHERE battle='{$battle}'");
        $tmp_array = array();
        while($fd = mysql_fetch_array($query_fd)) {
           $tmp_array[$fd['razmen_from']][$fd['razmen_to']][0] = $fd['attack'];
           $tmp_array[$fd['razmen_from']][$fd['razmen_to']][1] = $fd['block'];
        }
        return $tmp_array;
     }

function GetShopCount() {
	if ($_SERVER["SERVER_NAME"]=='angelscity.oldbk.com') {
		return "angcount";
	}
	elseif ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com') {
		return "avacount";
	} else {
		return "count";
	}
}


function CheckRealPartners($tid,$summa,$dealer = 0) {
	if($dealer == 326 || $dealer == 8540 || $dealer == 28453 || $dealer == 14897 || $dealer == 102904) {
		return;
	}

	$q = mysql_query('SELECT * FROM rid_refs WHERE ref = '.$tid);
	if (mysql_num_rows($q) > 0) {
		$partner = mysql_fetch_assoc($q);
		$partner = $partner['owner'];
		if ($partner) {
			$q = mysql_query('SELECT * FROM rid_users WHERE owner = '.$partner);
			if (mysql_num_rows($q) > 0) {
				$partner = mysql_fetch_assoc($q);
				if ($partner['interest'] > 0) {
					$bonus = round(($summa/100*$partner['interest']),2);

					// ��������� ������� � ����������� �������
					mysql_query('UPDATE rid_users SET allprofit = allprofit + '.$bonus.', profit = profit + '.$bonus.' WHERE owner = '.$partner['owner']);

					mysql_query('INSERT INTO rid_sales (`when`,`owner`,`ref`,`summa`,`interest`,`bonus`,`dealer`)
						VALUES (
							"'.time().'",
							"'.$partner['owner'].'",
							"'.$tid.'",
							"'.$summa.'",
							"'.$partner['interest'].'",
							"'.$bonus.'",
							"'.$dealer.'"
						)
					');

					// ��������� %
					$partner['allprofit'] += $bonus;
					$koef = floor($partner['allprofit'] / 100); // ������ 100$ ������� ��������� 0.1%
					$koef = $koef * 0.1;
					if ($koef > 2) $koef = 2; // �������� 2% ��������� (�.�. �� 7 ���� 5 ���������)

					$koef += 5; // 5% ���������
					if ($partner['interest'] != $koef) {
						// ��������� ����� %. ���� ����� ������ ��������� % ������� - �� �� ����������� �������� � ������� �������� ������� ���� ����� ����� �����������
						mysql_query('UPDATE rid_users SET `interest` = "'.$koef.'" WHERE owner = '.$partner['owner']);
					}
				}
			}
		}
	}
}


function close_dangling_tags($html){
  $html=str_replace('/>','>',$html);
  #put all opened tags into an array
  preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU",$html,$result);
  $openedtags=$result[1];

  #put all closed tags into an array
  preg_match_all("#</([a-z]+)>#iU",$html,$result);
  $closedtags=$result[1];
  $len_opened = count($openedtags);
  # all tags are closed
  if(count($closedtags) == $len_opened){
    return $html;
  }

  $openedtags = array_reverse($openedtags);
  # close tags
  for($i=0;$i < $len_opened;$i++) {
    if (!in_array($openedtags[$i],$closedtags)){
      $html .= '</'.$openedtags[$i].'>';
    } else {
      unset($closedtags[array_search($openedtags[$i],$closedtags)]);
    }
  }
  return $html;
}


	define('_BOTSEPARATOR_',10000000);

	$exptable = require(__DIR__ . '/components/config/exp.php');
	$naem_parm = require(__DIR__ . '/components/config/naem_param.php');
	$neam_skill_tree = require(__DIR__ . '/components/config/neam_skill_tree.php');
	$neam_skill_templ = require(__DIR__ . '/components/config/neam_skill_templ.php');
	$can_inc_magic = require(__DIR__ . '/components/config/can_inc_magic.php');

function undressallfast($id) {
	if (is_array($id)) {
		$ids = $id;
	} else {
		$ids = array(0 => $id);
	}
	while(list($k,$v) = each($ids)) {
		$v = intval($v);
		if (empty($v) || $v >= _BOTSEPARATOR_) unset($ids[$k]);
	}
	if (count($ids)) {
		$q = mysql_query('UPDATE oldbk.inventory SET dressed = 0 WHERE owner IN ('.implode(",",$ids).') and dressed = 1');
		if ($q === false) return false;

		$q = mysql_query('UPDATE `users` SET
					`sergi` = 0,
					`kulon` = 0,
					`perchi` = 0,
					`weap` = 0,
					`bron` = 0,
					`r1` = 0,
					`r2` = 0,
					`r3` = 0,
					`runa1` = 0,
					`runa2` = 0,
					`runa3` = 0,
					`helm` = 0,
					`shit` = 0,
					`boots` = 0,
					`m1` = 0,
					`m2` = 0,
					`m3` = 0,
					`m4` = 0,
					`m5` = 0,
					`m6` = 0,
					`m7` = 0,
					`m8` = 0,
					`m9` = 0,
					`m10` = 0,
					`m11` = 0,
					`m12` = 0,
					`m13` = 0,
					`m14` = 0,
					`m15` = 0,
					`m16` = 0,
					`m17` = 0,
					`m18` = 0,
					`m19` = 0,
					`m20` = 0,
					`nakidka` = 0,
					`rubashka` = 0
				WHERE `id` IN ('.implode(",",$ids).')'
		);
		if ($q === false) return false;

	}
	return true;
}


function myadderror2 ($error) {
	$fp = fopen ("/www/cache/locks/myerr.txt","a"); //��������
	flock ($fp,LOCK_EX);
	fputs($fp ,":[".date("d/m/Y H:i:s",time())."]:".$error."\r\n"); //������ � ������
	fflush ($fp);
	flock ($fp,LOCK_UN);
	fclose ($fp);
}
function round_time($ts, $step)
{
	return(floor(floor($ts/60)/60)*3600+floor(date("i",$ts)/$step)*$step*60);
}

	if (isset($_SESSION['uid']))
	{
		$query = mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");

		if (mysql_num_rows($query) != 1) {
			myadderror2(mysql_error());
		}

		$user = mysql_fetch_assoc($query);
		$user_real_sex=$user['sex'];
		$user['realsex']=$user_real_sex;

		if (isset($_SESSION['users_room']))
			{
				if ($_SESSION['users_room']!=$user['room'])
					{
					//del inf files
					$filename='/www/cache/infroom/'.$user['id'].'.dat';
					if (file_exists($filename))
						{
						unlink($filename);
						}
					$filename='/www/cache/infroom/'.$user['login'].'.dat';
					if (file_exists($filename))
						{
						unlink($filename);
						}
					$_SESSION['users_room']=$user['room'];
					}
			}
			else
			{
			$_SESSION['users_room']=$user['room'];
			}

		if(($user[align]>1 && $user[align]<2) || $user[deal]==-1)
		{
			if(!$_SESSION['pal_viz_time'] || $_SESSION['pal_viz_time']<time())
			{
				$_SESSION['pal_viz_time']=time()+60*15; //������ 5 ����� ������ ��������������� �����

				$chatactive = 1;
				if (!isset($_SESSION['lastpalupdate'])) $_SESSION['lastpalupdate'] = time();
				if ($_SESSION['lastpalupdate'] < time()-2*60) $chatactive = 0;
				mysql_query("INSERT into oldbk.pal_vizits SET owner='".$user['id']."' ,room='".$user[room]."', id_city=1, `chatactive` = ".$chatactive." ,`date`='".round_time(time(),15)."';");
			}
		}

		if($user[klan]=='Adminion' || $user[klan]=='radminion')
		{
			define("ADMIN",true);
			define("NEWAI",true);
		}
		else
		{
			define("ADMIN",false);
			define("NEWAI",false);
		}

		if  (  ($user['block'] == 1) OR (in_array($ip,$ban_ip_array)) )
 		{
		 $_SESSION['block']=1;
		 die("<script>location.href='index.php?exit=3.14zde';</script>");
		}
		//fix sex

		/* if ($user[id]==14897)
		 	{
		 	print_r($user);
		 	}
		 */
		if ($user[hidden]>0) {$user['sex']=1; }

		//���� ����
		if (  ( ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com') OR ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com') )  AND ($user[id_city]==2))
		   {
		   session_destroy();
		   header("Location: http://angelscity.oldbk.com");
		   die();
		   }
		else if ( (($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com') OR ($_SERVER["SERVER_NAME"]=='angelscity.oldbk.com') )   AND ($user[id_city]==1))
		   {
		   session_destroy();
		   header("Location: http://avaloncity.oldbk.com");
		   die();
		   }
		else if (  (($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com') OR ($_SERVER["SERVER_NAME"]=='angelscity.oldbk.com') ) AND ($user[id_city]==0))
		   {
		   session_destroy();
		   header("Location: http://capitalcity.oldbk.com");
		   die();
		   }

		if($_SESSION['sid'] != $user['sid'])
		{
		  $_SESSION['uid'] = null;
		  $paramsz=mt_rand(11111111,999999999);
		   die ("<script>".(!is_array($_SESSION['vk'])?"top.":"parent.")."location.href='index.php?exit=$paramsz';</script>");
		}


		if($user !== false)
		{

				//������� �� ������
				if ( ($_SESSION['users_ingame']['s2min']==0) and ($_SESSION['users_time']>0) and (time()-$_SESSION['users_time']>=120) )
					{
						/*
						�� ������ 2 ������ ������� �������� � ��� �������� � �������:
						�� ������� � ���� 2 ������ � ��������: ���� 3 ��., ���� ����� [4] 1 ��., ������������ 1 ��. ��������� ������� ����� ������ ����� 30 ����� ���������� � ����.
						*/
						$get_items[]=DropBonusItem(105104,$user,"�����","",7,3,20,false);

						$get_items[]=DropBonusItem(33028,$user,"�����","",7,1,20,false);
						$get_items[]=DropBonusItem(119,$user,"�����","",7,1,20,false);

						if (count($get_items) >0)
						{
						$all_items=implode(", ",$get_items);
						addchp ('<font color=red>��������!</font> �� ������� � ���� <b>2 ������</b> � ��������: '.$all_items.' ��������� ������� ����� ������ ����� 30 ����� ���������� � ����.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
						mysql_query("INSERT INTO `oldbk`.`users_ingame` SET `owner`='{$user['id']}',`s2min`=1 ON DUPLICATE KEY UPDATE s2min=1;");
						$_SESSION['users_ingame']['s2min']=1;
						}
					}
				elseif (($_SESSION['users_ingame']['s30min']==0) and ($_SESSION['users_time']>0) and (time()-$_SESSION['users_time']>=1800) )
					{
					/*
					 �� ������ 30 ����� ������� �������� � ��� �������� � �������:
					�� ������� � ���� 30 ����� � ��������: ������ ������� 5 ��., ���� ������� [7] 1 ��., ������� ������ ������� 1 ��. ��������� ������� ����� ������ ����� 30 ����� ���������� � ����.
					*/
						$get_items[]=DropBonusItem(105102,$user,"�����","",7,5,20,false);
						$get_items[]=DropBonusItem(33037,$user,"�����","",7,1,20,false);
						$get_items[]=DropBonusItem(14005,$user,"�����","",7,1,20,false);

						if (count($get_items) >0)
						{
						$all_items=implode(", ",$get_items);
						addchp ('<font color=red>��������!</font> �� ������� � ���� <b>30 �����</b> � ��������: '.$all_items.' ��������� ������� ����� ������ ����� 30 ����� ���������� � ����.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
						mysql_query("INSERT INTO `oldbk`.`users_ingame` SET `owner`='{$user['id']}',`s30min`=1 ON DUPLICATE KEY UPDATE s30min=1;");
						$_SESSION['users_ingame']['s30min']=1;
						}
					}
				elseif (($_SESSION['users_ingame']['s60min']==0) and ($_SESSION['users_time']>0) and (time()-$_SESSION['users_time']>=3600) )
					{
					/*
					�� ������� � ���� 1 ��� � ��������: ������ ������� 2 ��., ������� ������ ���� ������� 1 ��., ������� ������ ��������������� 180HP� 3 ��., ������ ������� 1 ��.
					* ������ ����� ������ �������, ����-�� �������� ������ �����
					*/
						$get_items[]=DropBonusItem(105103,$user,"�����","",7,2,20,false);
						$get_items[]=DropBonusItem(5205,$user,"�����","",7,3,20,false);

									$t = get_mag_stih($user);
									$proto = 150158;//default
									// $t[0] - �� 1 �� 4, 1 - �����, 2 - �����, 3 - ������, 4 - ����
									if ($t[0] == 1) $proto = 150158;		//������� ������ ����� �����
									if ($t[0] == 2) $proto = 920928;		//������� ������ ������ �������
									if ($t[0] == 3) $proto = 130138;		//������� ������ ���� �������
									if ($t[0] == 4) $proto = 930938;			//������� ������ ����� ������

									$get_items[]=DropBonusItem($proto,$user,"�����","",7,1,20,false);

						if (($user['level']>=7) and ($user['level']<=14) )
									{
									/*
									 7 ������� - ������ �������
									 8 ������� - ������ ����������
									 9 ������� - ������ �����
									 10 ������� - ������ �������� �����
									 11 ������� - ������ �������� �����
									 12 ������� - ������ ������������ �����
									 13 ������� - ������ ��������� ����
									 14 ������� - ������ ������������ �����
									*/
									$get_items[]=DropBonusItem((7000+$user['level']),$user,"�����","",0,1,20,false);
									}
						if (count($get_items) >0)
						{
						$all_items=implode(", ",$get_items);
						addchp ('<font color=red>��������!</font> �� ������� � ���� <b>1 ���</b> � ��������: '.$all_items,'{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
						mysql_query("INSERT INTO `oldbk`.`users_ingame` SET `owner`='{$user['id']}',`s60min`=1 ON DUPLICATE KEY UPDATE s60min=1;");
						$_SESSION['users_ingame']['s60min']=1;
						}
					}






			// fix hp -���� ����
			if ($user[hp] > $user[maxhp])  { $user[hp]=$user[maxhp]; mysql_query("UPDATE `users` SET `hp`=`maxhp` where id='".$user['id']."' ;"); }

			//fix mp- ���� ����
			if ($user[mana] > $user[maxmana])  { $user[mana]=$user[maxmana]; mysql_query("UPDATE `users` SET `mana`=`maxmana` where id='".$user['id']."' ;"); }


			if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
				$curip = $_SERVER['HTTP_CF_CONNECTING_IP'];
			} else {
				$curip = $_SERVER['REMOTE_ADDR'];
			}

			if ($_SESSION['ip'] != $curip) {
			 	$get_ip_setups=unserialize($user['gruppovuha']);

			 	if ($get_ip_setups[7] == 1) {
					die('������ ������������, ��������� IP �����. ����������� � ����.');
				}
			}

                if ($_SESSION['adm_view']==1)
				{
				}
				else
				{
				//����������� �������� ��� �������
				if ($_SESSION['o_up']<time()-30)
						{
							if (($user[ldate]<time()) OR ($user[bot]>0) )   // ���� ����� ������ ��� ������� �� ������ ����� - ���� ������ ���� �� �������
						 	{
							mysql_query_100("UPDATE users set ldate='".time()."' where id={$user['id']}; ");
							//save_otime_to_file_2($user['id']);
							}

						$_SESSION['o_up']=time();
						}
				//��� � ��� - ������ ���������� �������� ��� �������
				require_once('config_ko.php');
				if ((time()>$KO_start_time3) and (time()<$KO_fin_time3))
						{
						//����� ��������
						if ($_SESSION['onl_1up']==0) { $_SESSION['onl_1up']=time(); } // ��� ������ � ������ - �� ������ ������� ����� � ���� ���

						if ($_SESSION['onl_1up']<time()-3600) //1 ��� � ���
								{
							 	mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`ctime`=1,`ttime`=NOW() ON DUPLICATE KEY UPDATE `ctime`=`ctime`+1,`ttime`=NOW() ;");
								$_SESSION['onl_1up']=time();

								$get_user_day=mysql_fetch_array(mysql_query("select * from oldbk.users_timer where owner='{$user['id']}' "));
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

										if ($myp==10)
										{
										//���������� ��������
										$txtdata[0]='������� ��� ���������: ���� ������';
										$txtdata[1]='������� ��� ���������: ���� ������';
										$txtdata[2]='������� ��� ���������: ���� ������';
										$txtdata[3]='������� ��� ���������: ���� ���������';
										$txtdata[4]='������� ��� ���������: ���� �����';
										$txtdata[5]='������� ��� ���������: ���� ������';
										$txtdata[6]='������� ��� ���������: ���� �������';

										$txtdata=$txtdata[$get_user_day['cday']];

										$mtext="� ��� ��������� ����� ������� <a href=http://oldbk.com/encicl/?/act_line.html target=_blank>".$txtdata."</a>! ����������� �������� ����� ����� ������ �<a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1&effects=1#quests\")>���������</a>� ���������.";
										addchp ('<font color=red>��������!</font> '.$mtext,'{[]}'.$user[login].'{[]}',$user['room'],$user['id_city']);
										}
									}


								}

						}
				elseif ((time()>$KO_start_time4) and (time()<$KO_fin_time4))
						{
						//����� ��������
						if ($_SESSION['onl_1up']==0) { $_SESSION['onl_1up']=time(); } // ��� ������ � ������ - �� ������ ������� ����� � ���� ���

						if ($_SESSION['onl_1up']<time()-3600) //1 ��� � ���
								{
							 	mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`ctime`=1,`ttime`=NOW() ON DUPLICATE KEY UPDATE `ctime`=`ctime`+1,`ttime`=NOW() ;");
								$_SESSION['onl_1up']=time();
								}

						}



                		}

				if($user['show_advises'] == 1)
				{
					//show_advises($user['level']);
				}

		$upscont=true;
		if(($user['exp']>=8000000000) and ($user['id']!=686284) and ($user['id']!=686285) and ($user['id']!=686286) ) //�������
		{
			$get14lvl=mysql_fetch_array(mysql_query("select * from oldbk.variables where var='users14lvl'"));
			if ($get14lvl['value']=='false')
			{
			//��� �� �������� �� ������
			$upscont=false;
			}
			else
			{
			// �������� -�� ������
			// --- ��������� ����� ������� ��������
				$get14event=mysql_fetch_array(mysql_query("select * from `oldbk`.`users_14lvl` where owner='{$user['id']}' "));
				if ($get14event['onflag']==0)
					{
							//������� ��� � ��������� ����.
							mysql_query("UPDATE `oldbk`.`users_14lvl` SET `onflag`=1 WHERE owner='{$user['id']}' and `onflag`=0 ");
							if(mysql_affected_rows()>0)
							{
								//���� ����������� � ��������� ��
								//������ 0� �� � ����� �� ����
								mysql_query("update users set `exp`=8000000000, expbonus=expbonus+1 where id ='{$user['id']}'");
								if(mysql_affected_rows()>0)
									{
									//����� � ���� � ��� ��� ������� �� � ������� ����� �����
										$rec=array();
					  		    			$rec['owner']=$user['id'];
										$rec['owner_login']=$user['login'];
										$rec['owner_balans_do']=$user['money'];
										$rec['owner_balans_posle']=$user['money'];
										$rec['target_login']='��';
										$rec['type']=113;
										$rec['add_info']=$user['exp'];
										add_to_new_delo($rec);
									}
							}
					}
					elseif ( ($get14event['onflag']==1) and ($user['exp']>=(8000000000+$get14event['exp']) ) )
					{
					//���� ������� ����� ��� ������� ������� ���� �������� - ���� ����� ����� �� ����
					//������ ���� ��� ����� ��� ����
					mysql_query("UPDATE `oldbk`.`users_14lvl` SET `onflag`=2 WHERE owner='{$user['id']}' and `onflag`=1 ");
							if(mysql_affected_rows()>0)
							{
								mysql_query("update users set  expbonus=expbonus-1 where id ='{$user['id']}'");
								if(mysql_affected_rows()>0)
								{
								//����� �� ���� � ����
										$rec=array();
					  		    			$rec['owner']=$user['id'];
										$rec['owner_login']=$user['login'];
										$rec['owner_balans_do']=$user['money'];
										$rec['owner_balans_posle']=$user['money'];
										$rec['target_login']='��';
										$rec['type']=114;
										$rec['add_info']=$user['exp'];
										add_to_new_delo($rec);
								}
							}
					}
			}

		}



		if ($upscont!=true)
		{
		//���� �� ������

		}
		else
    		if($user['exp'] >= $user['nextup'] && (!$user['in_tower'])) {
    			if ( (($user[room]>210) and ($user[room]<239)) OR (($user[room]>270) and ($user[room]<282)) )
    				{
    				//����  ���������

    				}
    				elseif ($user[room]==76)
    				{
    				//����  �����������

    				}
    				else
    				{

				$akk_rate=0;
				$akk_rate=($user[prem]==1?0.1:$akk_rate);
				$akk_rate=($user[prem]==2?0.15:$akk_rate);
				$akk_rate=($user[prem]==3?0.20:$akk_rate);

			                $money=$exptable[$user['nextup']][3]+$exptable[$user['nextup']][3]*$akk_rate;

				        mysql_query("UPDATE `users` SET `nextup` = ".$exptable[$user['nextup']][5].",
				            	`stats` = stats+".$exptable[$user['nextup']][0].",
					`master` = `master`+".$exptable[$user['nextup']][1].",
					`vinos` = `vinos`+".$exptable[$user['nextup']][2].",
					`money` = `money`+'".$money."',
					`level` = `level`+".$exptable[$user['nextup']][4]." WHERE `id` = '{$user['id']}'");

					$apmesag=true;

					//new_delo
					$rec=array();
  		    			$rec['owner']=$user['id'];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']+$money;
					$rec['target']=0;
					$rec['target_login']='��';
					$rec['type']=10;
					$rec['sum_kr']=$money;
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;//��������
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
					$rec['battle']=0;
					add_to_new_delo($rec);

		        if($user['level'] < 5) {
			        mysql_query("INSERT INTO oldbk.`inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`present`,`magic`,`otdel`,`isrep`,`prototype`,`notsell`,`goden`,`dategoden`)
				    VALUES('".$user['id']."','������ �������','50','1','0','zavtrak_3average.gif','10','�����������','8','6','0',105103,1,30,".(time()+30*24*3600).") ;");

				    $getitem='������ �������';
		        }

				mysql_query("UPDATE `users` SET `maxhp` = (IFNULL((SELECT SUM(`ghp`) FROM oldbk.`inventory`
				WHERE id IN (".GetDressedItems($user,DRESSED_ITEMS).")),0) + (users.vinos*6) + (users.bpbonushp) + (IFNULL((select maxhp from users_bonus where owner=`users`.id),0)) )
				WHERE id=".(int)$_SESSION['uid']." ;");


		        if($exptable[$user['nextup']][4]>0)
		        {
       				$user['level']++;
				$lvlmesag=true;
				// ����� �������� �������� �����
				//if ($user['klan'] == "radminion") {
					if ($user['level'] <= 7) {
						/*
						$whatreal = 5001;
						$whatrealtxt = '<img src="http://i.oldbk.com/i/magic/attention.png" border="0"> ��������! �� ����� '.$user['level'].' ������� � �������� 1$, ������� � �������, �� ������� ���������� � ��������.  �� ��������� � ��� � <img src="http://i.oldbk.com/i/a___inv.gif" border="0"> ��������� � ������� ������. ����� �������� � ������ ����� ������� � <a href="http://oldbk.com/encicl/?/earning.html" target="_blank">���������� �����</a>!';

						if ($user['level'] == 6) $whatreal = 5002;
						if ($user['level'] == 7) $whatreal = 5003;
						if ($user['level'] == 6 || $user['level'] == 7) {
							$whatrealtxt = '<img src="http://i.oldbk.com/i/magic/attention.png" border="0"> ��������! �� ����� '.$user['level'].' ������� � �������� '.($whatreal-5000).'$, ������� � �������, �� ������� ���������� � ��������.  ��� ��������� � ��� � <img src="http://i.oldbk.com/i/a___inv.gif" border="0"> ��������� � ������� ������. ����� �������� � ������ ����� ������� � <a href="http://oldbk.com/encicl/?/earning.html" target="_blank">���������� �����</a>!';
						}
	                                        */
						if ($user['level'] == 5) {
							// ����� ������������� ����������
							$sertid = 536;

							$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$sertid}' LIMIT 1;"));
							if ($dress[id]>0)  {

								$dress['sowner'] = $user['id'];
								$dress['present'] = "������������� �����";

								mysql_query("INSERT INTO oldbk.`inventory`
								(`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
									`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
									`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`  ,
									`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`nsex`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`arsenal_klan` , `arsenal_owner`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`,`includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `sowner`, `present`
								)
								VALUES
								('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
								'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress[nsex]}',
								'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."',
								'{$dress['goden']}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','','0','0','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}', '{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}' , '{$dress['sowner']}' , '{$dress['present']}'
								)");
								$serttxt = '<img src="http://i.oldbk.com/i/magic/attention.png" border="0"> ��������! �� ����� 5� ������� � �������� "���������� �� ��������� ������ ���������� 200 ��.". ���������� ��������� � ��� � <img src="http://i.oldbk.com/i/a___inv.gif" border="0"> ��������� � ������� ������. �������� ������ ����� ����� �� ���������, ����� �� ������� "������������" ��� ������������.';
								addchp($serttxt,'{[]}'.$user['login'].'{[]}');
							}
						}
						/*
						$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$whatreal}' LIMIT 1;"));
						if ($dress[id]>0)  {
							$dress['sowner'] = $user['id'];
							$dress['present'] = "������������� �����";


							mysql_query("INSERT INTO oldbk.`inventory`
							(`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
								`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
								`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`  ,
								`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`nsex`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`arsenal_klan` , `arsenal_owner`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`,`includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost` , `sowner`, `present`
							)
							VALUES
							('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
							'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress[nsex]}',
							'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."',
							'{$dress['goden']}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','','0','0','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}', '{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}' , '{$dress['sowner']}' , '{$dress['present']}'
							)");
							addchp($whatrealtxt,'{[]}'.$user['login'].'{[]}');
						}
						*/
					}
				//}




       				if($user['level']==3)//�������� ����� 2  � ����� 7, ���� ���� �� ���������
       				{
		                        mysql_query("INSERT oldbk.`beginers_quests_step` (`owner`,`quest_id`) VALUES ('".$user['id']."','2');");
		                        mysql_query("INSERT oldbk.`beginers_quests_step` (`owner`,`quest_id`,`qtype`) VALUES ('".$row[id]."','7','7');");
		                        unset($_SESSION['beginer_quest']);
       				}
       				if($user['level']==4)//�������� ����� 3
       				{
		                        mysql_query("INSERT oldbk.`beginers_quests_step` (`owner`,`quest_id`) VALUES ('".$user['id']."','3');");
		                        unset($_SESSION['beginer_quest']);
       				}
                    		if($user['level']==6)//�������� ����� 4 //�������
       				{
		                        mysql_query("INSERT oldbk.`beginers_quests_step` (`owner`,`quest_id`) VALUES ('".$user['id']."','4');");
		                        unset($_SESSION['beginer_quest']);
       				}
       				if($user['level']==5)//�������� ����� 5  //���������
       				{
					/*
		                        mysql_query("INSERT oldbk.`beginers_quests_step` (`owner`,`quest_id`) VALUES ('".$user['id']."','5');");
		                        unset($_SESSION['beginer_quest']);
					*/
       				}
       				if($user['level']==7)//�������� ����� 6  //���������
       				{
		                        mysql_query("INSERT oldbk.`beginers_quests_step` (`owner`,`quest_id`) VALUES ('".$user['id']."','6');");
		                        unset($_SESSION['beginer_quest']);
       				}
		        //ADD by FRed
		        //����������� � xml ���� ��� ���� � ���������
		            $pidd=get_pid($user);
		            if ($pidd[partner]>0)
		            {
		            //��� �����������
		            		$rezzz=make_record($user['id'],$pidd[partner],10,$user['level']);
		            }
		            if($user['level']==4)
		            {
		            	//���������� �������
                       		mysql_query('delete from oldbk.users_znahar where owner = '.$user['id'].';');
		            }
		        /////////////////////////////////////

		         if ($user[level]==4)
		        {
         			// ���������

			     $pp_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$user['id']}' LIMIT 1;"));
   		      	      if ($pp_user['partner']==312 and $pp_user['fraud']!=1)
			      {
			      		//echo "TEST";
		       		       echo "<script type=\"text/javascript\" src=\"http://clickky.ru/offer/complete/50091\"></script>";
		       	      }
		       	      elseif ($pp_user['partner']==607 and $pp_user['fraud']!=1)
		       	      {
				$pritem= mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` WHERE `id` = '3205' LIMIT 1;")); // ��� 100��
				$needpres='�����';
				mysql_query("INSERT INTO oldbk.`inventory` (`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`duration` ,`maxdur`,`isrep`,`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`labonly`,`labflag`,`present`,`group`,`letter`,`sowner`,`idcity`
				)
				VALUES
				('{$pritem['id']}','{$user['id']}','{$pritem['name']}','{$pritem['type']}',{$pritem['massa']},{$pritem['cost']},'{$pritem['img']}',{$pritem['duration']},{$pritem['maxdur']},{$pritem['isrep']},'{$pritem['gsila']}','{$pritem['glovk']}','{$pritem['ginta']}','{$pritem['gintel']}','{$pritem['ghp']}','{$pritem['gnoj']}','{$pritem['gtopor']}','{$pritem['gdubina']}','{$pritem['gmech']}','{$pritem['gfire']}','{$pritem['gwater']}','{$pritem['gair']}','{$pritem['gearth']}','{$pritem['glight']}','{$pritem['ggray']}','{$pritem['gdark']}','{$pritem['needident']}','{$pritem['nsila']}','{$pritem['nlovk']}','{$pritem['ninta']}','{$pritem['nintel']}','{$pritem['nmudra']}','{$pritem['nvinos']}','{$pritem['nnoj']}','{$pritem['ntopor']}','{$pritem['ndubina']}','{$pritem['nmech']}','{$pritem['nfire']}','{$pritem['nwater']}','{$pritem['nair']}','{$pritem['nearth']}','{$pritem['nlight']}','{$pritem['ngray']}','{$pritem['ndark']}',
				'{$pritem['mfkrit']}','{$pritem['mfakrit']}','{$pritem['mfuvorot']}','{$pritem['mfauvorot']}','{$pritem['bron1']}','{$pritem['bron2']}','{$pritem['bron3']}','{$pritem['bron4']}','{$pritem['maxu']}','{$pritem['minu']}','{$pritem['magic']}','{$pritem['nlevel']}','{$pritem['nalign']}','".(($pritem['goden'])?($pritem['goden']*24*60*60+time()):"")."','{$pritem['goden']}','{$pritem['nsex']}','{$pritem['razdel']}','','','{$needpres}','{$pritem['group']}','{$pritem['letter']}','','{$user[id_city]}'
				) ;");

		       	      $pritem['id']=mysql_insert_id();
		       	      $pritem['idcity']=$user[id_city];
       	                       addchp ('<font color=red>��������!</font> �� �������� 4�� ������ � �������� ������� �� ������������� ����� - <b>��� �� ������������ 100��</b>, ������� �� ������ ���������� � ����������� � ��������� �����. ��� ��������� � ����� ��������� � ������� ������.','{[]}'.$user['login'].'{[]}',$user[room],$user[id_city]);

		       	                //new_delo
  		    			$rec['owner']=$user['id'];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='�����';
					$rec['type']=288; //?????
					$rec['sum_kr']=0;
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;//��������
					$rec['item_id']=get_item_fid($pritem);
					$rec['item_name']=$pritem[name];
					$rec['item_count']=1;
					$rec['item_type']=$pritem['type'];
					$rec['item_cost']=$pritem['cost'];
					$rec['item_dur']=$pritem['duration'];
					$rec['item_maxdur']=$pritem['maxdur'];
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=0;
					$rec['add_info']='';
					add_to_new_delo($rec); //�����


		       	      }

		        }
		        else
		         if ($user['level']==8)
		         {
				addchp("<font color=green><b>��� ���� �������� ����� ������ ��������� � �������� ����� ������, �������� ������� �� �������� �����.</b></font>",'{[]}'.$user['login'].'{[]}',$user[room],$user[id_city]);
							/*
							$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='100199' LIMIT 1;"));
							if ($dress[id]>0)
							{

								$dress['sowner'] = $user['id'];
								$dress['present'] = "�����";

								mysql_query("INSERT INTO oldbk.`inventory`
								(`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`img_big`,`rareitem`,`maxdur`,`isrep`,
									`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
									`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`  ,
									`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`nsex`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`arsenal_klan` , `arsenal_owner`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`,`includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `sowner`, `present`
								)
								VALUES
								('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}', '{$dress['img_big']}', '{$dress['rareitem']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
								'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress[nsex]}',
								'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."',
								'{$dress['goden']}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','','0','0','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}', '{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}' , '{$dress['sowner']}' , '{$dress['present']}'
								)");

								telepost_new($user,'<font color=red>��������!</font> ��������! �� ����� 8� ������� � �������� �'.link_for_item($dress).'�, ������ ��������� � ��� � <img src="http://i.oldbk.com/i/a___inv.gif" border="0"> ��������� � ������� ��������.');

								 //new_delo
			  		    			$rec['owner']=$user['id'];
								$rec['owner_login']=$user[login];
								$rec['owner_balans_do']=$user['money'];
								$rec['owner_balans_posle']=$user['money'];
								$rec['target']=0;
								$rec['target_login']='�����';
								$rec['type']=2888;
								$rec['sum_kr']=0;
								$rec['sum_ekr']=0;
								$rec['sum_kom']=0;//��������
								$rec['item_id']=get_item_fid($dress);
								$rec['item_name']=$dress[name];
								$rec['item_count']=1;
								$rec['item_type']=$dress['type'];
								$rec['item_cost']=$dress['cost'];
								$rec['item_dur']=$dress['duration'];
								$rec['item_maxdur']=$dress['maxdur'];
								$rec['item_ups']=0;
								$rec['item_unic']=0;
								$rec['item_incmagic']='';
								$rec['item_incmagic_count']='';
								$rec['item_arsenal']='';
								$rec['bank_id']=0;
								$rec['add_info']='';
								add_to_new_delo($rec); //�����
							}
							*/


		         }
		         else
		         if ($user[level]==5)
		         	{
				      // ���������
				     $pp_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$user['id']}' LIMIT 1;"));

				      if ($pp_user['partner']==319 and $pp_user['fraud']!=1)
				      {
				      ?>
<script>
var univar1='<?=$user['id'];?>';
document.write('<img src="http://mixmarket.biz/uni/tev.php?id=1294930432&r='+escape(document.referrer)+'&t='+(new Date()).getTime()+'&a1='+univar1+'" width="1" height="1"/>');</script>
<noscript><img src="http://mixmarket.biz/uni/tev.php?id=1294930432&a1=<?=$user['id'];?>" width="1" height="1"/></noscript>
					<?
				      }
				    else
					if ($pp_user['partner']==70 and $pp_user['fraud']!=1)
					{
?>
<!-- Google Code for &#1044;&#1086;&#1089;&#1090;&#1080;&#1078;&#1077;&#1085;&#1080;&#1077; 5&#1075;&#1086; &#1091;&#1088;&#1086;&#1074;&#1085;&#1103; Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1005908691;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "1JRcCI2t4gIQ0-XT3wM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1005908691/?label=1JRcCI2t4gIQ0-XT3wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?
}

		         	}
		         	//else
		         	//if ($user[level]==6)
		         	// {
		         	 //�������� 6��� - ��������
		         	 // ���������
				    // $pp_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$user['id']}' LIMIT 1;"));

				     /*
				     if ($pp_user['partner']==68 and $pp_user['fraud']!=1)
				      {
				      echo "
				      <script>
				      var univar1='".$user['id']."';
				      document.write('<img src=\"http://mixmarket.biz/uni/tev.php?id=1294931935&r='+escape(document.referrer)+'&t='+(new Date()).getTime()+'&a1='+univar1+'\" width=\"1\" height=\"1\"/>');</script>
				      <noscript><img src=\"http://mixmarket.biz/uni/tev.php?id=1294931935&a1=".$user['id']."\" width=\"1\" height=\"1\"/></noscript>";
				      }


				      if ($pp_user['partner']==80 and $pp_user['fraud']!=1)
				      {
				      echo "
				      <script type=\"text/javascript\">
					var admitadCampaign='8f9833519e';
					var admitadPaymentType='lead';
					var admitadOrderId='0';
					var admitadClientId='".$user['id']."';
					var admitadTracking='USER_6_LEVEL_UP';
					</script>
					<script type=\"text/javascript\" src=\"http://www.ad.admitad.com/js/register.js\"></script>
					<img src=\"http://www.ad.admitad.com/register/8f9833519e/script_type/img/\" width=\"1\" height=\"1\" alt=\"\" />";
				      }
				      */
		         	// }
		        	$ss[0]='������a';
		        	$ss[1]='�������';
		        	$str='�������� <B>'.$user['login'].'</B> '.$ss[$user[sex]].' �� '.($user['level']).' �������. ';
			addch($str,$user[room],$user[id_city]);

	             $data=mysql_fetch_assoc(mysql_query('select * from oldbk.users_referals where user = '.$user['id'].' LIMIT 1;'));

	             //����������� ������� - ���������� ��������
                     if($data[owner]>0 && $user['level']>7)
                     {
                        $refowner = mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '".$data[owner]."' LIMIT 1;"));
                        $money_befor= mysql_fetch_array(mysql_query("SELECT * FROM oldbk.bank where id='".$data[ref]."' LIMIT 1"));
                        $addmoney=0;
                        $addmoney=($user['level']==10?'40':$addmoney);
                        $addmoney=($user['level']==11?'60':$addmoney);
                        $addmoney=($user['level']==12?'150':$addmoney);
                        $addmoney=($user['level']==13?'250':$addmoney);
                        $addmoney=($user['level']==14?'400':$addmoney);

			if ($addmoney>0)
			{
                        $sql='update oldbk.bank set ekr=ekr+'.$addmoney.' WHERE id= '.$data[ref].' and owner = '.$data[owner].';';
                        mysql_query($sql);
			if(mysql_affected_rows()>0)
				{
                        		//new_delo
  		    			$rec['owner']=$refowner[id];
					$rec['owner_login']=$refowner[login];
					$rec['owner_balans_do']=$refowner['money'];
					$rec['owner_balans_posle']=$refowner['money'];
					$rec['target']=$user['id'];
					$rec['target_login']=$user['login'];
					$rec['type']=11;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$addmoney;
					$rec['sum_kom']=0;//��������
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
					$rec['bank_id']=$data['ref'];
					$rec['add_info']='������ ��: '.$money_befor[ekr];
					add_to_new_delo($rec);
				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','���������� <b>{$addmoney} ���.</b> �� ���������� ���������� <b>{$user[login]}</b> ������ {$user['level']}. (<i>�����: {$money_befor['cr']} ��., ".($money_befor['ekr']+$addmoney)." ���. </i>)','{$data['ref']}');");

				mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr) values ('8','�����������','{$data[ref]}','{$refowner['login']}','{$addmoney}');");
				telepost_new($refowner,'<font color=red>��������!</font> �� ��� ���� �'.$data['ref'].' ���������� '.$addmoney.' ���. �� ������������� �� ���������� ���������� <b>'.$user[login].'</b> ������ '.$user['level'].'  ');
				}
                        }
                     }
		////////////////////////////////////////////////////////////

		        }

	        	$user = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));


				if($user['level'] < 1 && $user['show_advises'] == 1)
				{
					//show_up_advises($exptable[$user['nextup']]);
				}


					//����� �������, ���� ���� �������:
					//����� �������, ���� ��� ��������:
					//����� ��, ���� ���� �������:
					//����� ��, ���� ��� ��������:

						if (($lvlmesag) and ($getitem))
						{
						$getitem=" � <b>".$getitem."</b>";
						$mes="�����������! �� �������� ".$user['level']." ������! �� �������� ����������� ��������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1\")>�������������</a>. ���� �������: ".strval($money)." ��. ".$getitem.".";
						}
						elseif (($lvlmesag) and ($getitem==false))
						{
						$mes="�����������! �� �������� ".$user['level']."  ������! �� �������� ����������� ��������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1\")>�������������</a>. ���� �������: ".strval($money)." ��.";
						}
						elseif (($apmesag) and ($getitem))
						{
						$getitem=" � <b>".$getitem."</b>";
						$mes="�����������! �� �������� ���������� ��������� �� ����� ������ � �������� ����������� ��������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1\")>�������������</a>. ���� �������: ".strval($money)." ��. ".$getitem.".";
						}
						elseif (($apmesag) and ($getitem==false))
						{
						$mes="�����������! �� �������� ���������� ��������� �� ����� ������ � �������� ����������� ��������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1\")>�������������</a>. ���� �������: ".strval($money)." ��.";
						}

						if ($mes!='')
						{
						addchp("<font color=green><b>".$mes."</b></font>",'{[]}'.$user['login'].'{[]}',$user[room],$user[id_city]);
						//addchp('<font color=red>��������!</font> FINFO '.$user['login'].' message lvl/up ','{[]}Bred{[]}',-1,0);
						}




			}// ����������� ���������



		    }
        }
	}
	else
	{
		define("ADMIN",false);
	}
	function show_up_advises($user_exp_data)
	{
		$user_advises_status = mysql_fetch_array(mysql_query("SELECT * FROM user_advises_status WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"));
		if($user_advises_status['first_entry'] != "")
		{
			if($user_exp_data[5] == 45 && $user_advises_status['first_up'] == "")
			{
				if(mysql_query("UPDATE user_advises_status SET first_up='".time()."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
				{
					$up_message = "����������! �� ���� ������� ������ � ���� ������ ��. ������� ����� �� ������ ���������� � ���������� (<a href=http://oldbk.com/encicl/exp.html>http://oldbk.com/encicl/exp.html</a>). ������ � ���� �������� ��� ���� ���������������� ��������, � � ��������� ����� ����� ���������. ������� �����, ��� �� 4-�� ������ � ���� ��������� �� ����� ��������.";
				}
			}
			elseif($user_exp_data[5] == 75 && $user_advises_status['second_up'] == "")
			{
				if(mysql_query("UPDATE user_advises_status SET second_up='".time()."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
				{
					$up_message = "�� ��������� ������ �������! ���� ���� �� �� �� ��� �������, �� ����� ���� ���� ����� �������. ������ ��������� �� ����� ��������� ���� ��������� � �������. �� ������� ������������ ���������� ���������. � ��������� �� ������� ��������� ���������. ��� ����� ���������� �� ������ ��� �� 4�� ������.";
				}
			}
			elseif($user_exp_data[5] == 110 && $user_advises_status['third_up'] == "")
			{
				if(mysql_query("UPDATE user_advises_status SET third_up='".time()."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
				{
					$up_message = "����������, �� ���� ��������� ��. ����� � ��������� �� ������ ��������������� ������, ������� ����� ������ ���������, �������� ���������. ����, ��� ����� ���������� ����� ���� ��� � ������� ��� ����� ������ ���� �����. �� �������� ����� �� ������� ������ �������. �� 4�� ������ �� ������ ��������� ���������������� ����� � ������. ";
				}
			}
		}

		if($up_message != "")
		{
			addchp("[<a><span>�����������</span></a>] ".$up_message, '{[]}'.$user[login].'{[]}');
		}
	}

	function show_first_entry($user_advises_status)
	{
		if($_SESSION["first_entry_delay"] == "")
		{
			$_SESSION["first_entry_delay"] = time();
			return;
		}
		else
		{
			$time = time();
			$first_entry_delay = $_SESSION["first_entry_delay"];
			if(($time - $first_entry_delay) * 60 < 360)
			{
				return;
			}
		}

		$first_entry_message = "����������� ����, �������. �� ������ ������ � ���������� �����, ������������������� ���. ������� ��� ������� ������ ���� ���������������� � ����� �����? � ���� ������������ ���� �������� �� 4-�� ������, �� ���� �� �� ���������� � ���� ������, ������� ��� ������ � \"����������/��������� -> ������������\".";
		if($user_advises_status['ADV_CNT'] == 0)
		{
			if(mysql_query("INSERT INTO user_advises_status (first_entry, user_id) VALUES(".time().", '{$_SESSION['uid']}');"))
			{
				addchp("[<a><span>�����������</span></a>] ".$first_entry_message, '{[]}'.$user[login].'{[]}');
			}
		}
		else
		{
			if(mysql_query("UPDATE user_advises_status SET first_entry=".time()." WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
			{
				addchp("[<a><span>�����������</span></a>] ".$first_entry_message, '{[]}'.$user[login].'{[]}');
			}
		}
	}

	function show_first_battle()
	{
		$user_advises_status = mysql_fetch_array(mysql_query("SELECT first_battle FROM user_advises_status WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"));
		if($user_advises_status['first_battle'] == "" &&
			mysql_query("UPDATE user_advises_status SET first_battle='".time()."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
		{
			$first_battle_message = "�������������� �������� ��������� � ���� �������� 20 ���, �� ������ ������������ � ����. � ������ ������ ���� �� ������ ������ <img src=http://i.oldbk.com/i/a___inv.gif align=absmiddle border=0 />. ��� ���� ���������. � ������� \"������\", � ���� ���� ���������, ������� ����������� ����������� ���� ��������. ������������ ��� ����� 5 ���.";
			addchp("[<a><span>�����������</span></a>] ".$first_battle_message, '{[]}'.$user[login].'{[]}');
		}
	}

	function show_advises($level)
	{
		if($level > 4)
		{
			return;
		}

		$user_advises_status = mysql_fetch_array(mysql_query("SELECT *, count(1) AS ADV_CNT FROM user_advises_status WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"));

		$last_advise_time = $level_array[1];
		$time = time();
		if($last_advise_time <= 0)
		{
			$last_advise_time = time() - 240 * 60;
		}

		if(($time - $last_advise_time) * 60 < 120)
		{
			return;
		}

		if($level == 0)
		{
			if($user_advises_status['first_entry'] == "")
			{
				show_first_entry($user_advises_status);
			}
			else
			{
				$level_info = $user_advises_status['lvl0'];
				$level_array = unserialize($level_info);
				$last_advise = (int)$level_array[0];
				switch($last_advise)
				{
					case 0:
						$level_array = array(1, time());
						$advise_message = "������, ���������� ���� ��������� � ���� ������������ <a href='http://oldbk.com/encicl/'>http://oldbk.com/encicl/</a>";
						break;
					case 1:
						$level_array = array(2, time());
						$advise_message = "��� ������, ���� ���������� ������������ ���� ����� � ������. ��� ����� ����� ������ ����� ������ \"���������\" <img src=http://i.oldbk.com/i/a___inv.gif align=absmiddle border=0 />. ����� � ����������� ����, �������� � �.�. �� ������ ������ <img src=http://i.oldbk.com/i/up.gif align=absmiddle border=0 />. �� ����� ���������� ������ ���, ����� � ���� ����� ����������� ���-�� ������������.";
						break;
					case 2:
						$level_array = array(3, time());
						$advise_message = "���� �������� ������� � ���� ���� ��������� ����������. ������� �� <img src=http://i.oldbk.com/i/up.gif align=absmiddle border=0 /> �� ������������ ���� �����. �� �� ����� �� ������ ������� � ����������� �������� �������.";
						break;
					case 3:
						$level_array = array(4, time());
						$advise_message = "���� ���� ���� ���� ����� � ��������� ������ �������, ��� ����� ���� ����. �������� - ����������� ���������� �� ����� ����������. �������� - ����������� ������� ����������� ���� (���� ������� ����). ������������ ���������� ������ ����� ������� ����� (��).";
						break;
					case 4:
						$level_array = array(5, time());
						$advise_message = "������ ������� ���� ������ \"��������\",  ��� � ����� ��� � ��� ��������. �� ������ ������ ���� ������ �� ���, ���� ������� �����. ���� ���� ������ �� ����� ������� � ������� 5 �����, �� �������� ����������� �������� ��� � ����������� ������.";
						break;
					case 5:
						$level_array = array(6, time());
						$advise_message = "���� � ����, �� ������� ������ ���������� ��������� �������� � ���������� ������ � ������ � �� ������. �� 1 ������ �� ������ ������ � ������ ������ <img src=http://i.oldbk.com/i/align_1.9.gif border=0 align=absmiddle /> ���������. ��� ���, � ����� ��������� ������ �����.";
						break;
					default:
						$advise_message = "";
						break;
				}

				if($advise_message != "" &&
					mysql_query("UPDATE user_advises_status SET lvl0='".serialize($level_array)."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
				{
					addchp("[<a><span>�����������</span></a>] ".$advise_message, '{[]}'.$user[login].'{[]}');
				}
			}
		}
		elseif($user_advises_status['first_entry'] == "")
		{
			return;
		}
		elseif($level == 1)
		{
			$level_info = $user_advises_status['lvl1'];
			$level_array = unserialize($level_info);
			$last_advise = (int)$level_array[0];

			switch($last_advise)
			{
				case 0:
					$level_array = array(1, time());
					$advise_message = "����������, �� ������ ������� ������! � ���� ���� ����������� ������������ 4 ��������� �����. ������ ���� ��������� ���������� ���, ��������, ��������� ������ � ����������� ����������� � �������� �����. ��� ���������� ��������� ����� �� ��������� ����� � ����� ������ � ������ ���������� � ����.";
					break;
				case 1:
					$level_array = array(2, time());
					$advise_message = "������ �� ������ ��������� ������� � ���������, ������� ����������� �� ����������� ������� (��) � �������� ���� �� ������������ �����. ��� �� ������ ������� ����������� ����. ����� ����� ���� ������ �������� ������ ����������� ������� �����. ������, ���� �� �� ������ �������� ����������� (������ �����, � ����������� - ����) � �������, �� ������ ������ �������� ��, ������� ������� �� ����������� � ����� �� ����� ��������� ������. ������� ���� � ����� ��������� ���� � 0.5 ��.";
					break;
				case 2:
					$level_array = array(3, time());
					$advise_message = "�����, ����� ���������, ���� ������ \������\ <img src=http://i.oldbk.com/i/b___friend.gif align=absmiddle border=0 />. ���, ����� ����� ������, ������� �� ����������, �� ������ ������� ������ ��������� � ������� ������.";
					break;
				case 3:
					$level_array = array(4, time());
					$advise_message = "� ������� ������ �� ������ ���������������� ����������� ���� (�������� � ����� ���� �� ������� � 4 ������), �������� �������������� ����� ��� ������� ����������. ���� �������� ���� � �������� ���, ��� ����� ������� ���� ���� ��� ������ ���-�� ������ � ���������.";
					break;
				default:
					$advise_message = "";
					break;
			}

			if($advise_message != "" &&
				mysql_query("UPDATE user_advises_status SET lvl1='".serialize($level_array)."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
			{
				addchp("[<a><span>�����������</span></a>] ".$advise_message, '{[]}'.$user[login].'{[]}');
			}
		}
		elseif($level == 2)
		{
			$level_info = $user_advises_status['lvl2'];
			$level_array = unserialize($level_info);
			$last_advise = (int)$level_array[0];

			switch($last_advise)
			{
				case 0:
					$level_array = array(1, time());
					$advise_message = "����������! �� ���� ������ ������� � ���� ����� �������� ��������� � ����������� ���. �� ������� �������� ����� � ������ ������� http://capitalcity.oldbk.com/news.php. ��� �� ������ ������ ������������ �� ���������� � ������������� � ����. ����� ������ �� ������� ������ ������� �� ��������� <img src=http://i.oldbk.com/i/ArtButton.gif align=absmiddle border=0 />. ��� �� ������ ������ �������� ��������, �����, ���������� �������� �������, ��������� ������. ��� �� �� ������ ������������ ���� ������. �� ���������� �������� ����� ����� - ������ ������, ������� ������� � ��������� ������� ����.";
					break;
				default:
					$advise_message = "";
					break;
			}

			if($advise_message != "" &&
				mysql_query("UPDATE user_advises_status SET lvl2='".serialize($level_array)."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
			{
				addchp("[<a><span>�����������</span></a>] ".$advise_message, '{[]}'.$user[login].'{[]}');
			}
		}
		elseif($level == 3)
		{
			$level_info = $user_advises_status['lvl3'];
			$level_array = unserialize($level_info);
			$last_advise = (int)$level_array[0];

			switch($last_advise)
			{
				case 0:
					$level_array = array(1, time());
					$advise_message = "���������� �� ������� �������� ������! �� �������� ����� �������� ������ �������. ������ ��������, ��� � ��������� ��� ������� ��������� � ���� ���� ������� \"��������� ��������\". �� ������ ��������� ��� ��������� ������� ���������� ��� �������� �� ��������. �����, � ��������� ���� ������� \"������\". ���� ���������� � ������ �� ������� ������ � ������, ���� ����� � ���� � �������������� ��� � ��������� ����� ��������� ������ ���������.";
					break;
				default:
					$advise_message = "";
					break;
			}

			if($advise_message != "" &&
				mysql_query("UPDATE user_advises_status SET lvl3='".serialize($level_array)."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
			{
				addchp("[<a><span>�����������</span></a>] ".$advise_message, '{[]}'.$user[login].'{[]}');
			}
		}
		elseif($level == 4)
		{
			$level_info = $user_advises_status['lvl4'];
			$level_array = unserialize($level_info);
			$last_advise = (int)$level_array[0];

			switch($last_advise)
			{
				case 0:
					$level_array = array(1, time());
					$advise_message = "���������� � ��������� ������� � ��������� �� �������� �����. ������ �� ������ ������������ ����� � � ���������, ������� ����������� ���� ��� ��������� ���������� � ��������������� �����. ��������������� ����� � �� �������� ������������ � ��������� ����������. ��� �� ����� �������� ���������� ����.";
					break;
				case 1:
					$level_array = array(2, time());
					$advise_message = "������ �� ������ �������� � ����� ������������� ���� ����, �� ����  �� ��� ��� �� ����������� �� �����������, �� ��������� ������, ��� � ���� ������ �� �� ������� �� ��������.";
					break;
				case 2:
					$level_array = array(3, time());
					$advise_message = "����� ���� ����� �� �������� ���� �����! ����� �������, � ���� ��������� ����� ��������� ������ ���� - �������� �����, ����� ������, ����, ������������ ������� � ������� �����. ��� ����� ������, ������� � ����� ������, ��� �����, ���� ����� ��������� �����. ����� �� �� ���������� � ���� �������. �����, ����!";
					break;
				default:
					$advise_message = "";
					break;
			}

			if($advise_message != "" &&
				mysql_query("UPDATE user_advises_status SET lvl4='".serialize($level_array)."' WHERE user_id='{$_SESSION['uid']}' LIMIT 1;"))
			{
				addchp("[<a><span>�����������</span></a>] ".$advise_message, '{[]}'.$user[login].'{[]}');
			}
		}
	}

	$rooms = array ("��������� �������","������� ��� ��������","������� ��� �������� 2","������� ��� �������� 3","������� ��� �������� 4","��� ������ 1","��� ������ 2","��� ������ 3","�������� ���",
	"��������� ���","����� �������-�����","���������� ���","����� �����","���������� �����","�������� ���","��� ���������","����� ������ ��������","��� ����","������� ����","������",
	"����������� �������","����������� �����","�������","��������� ����������","���������� ����","������������ �������","�������� �����","�����","������������ ������","����","���",
	"����� ������","���������� �����","�������� �����","��������� �������","������� '�������'","��� ������","���������� ����� - ��������","���������� ����� - �������","���������� ����� - ���������� ����",
	"���������� ����� - ����������","���������� ����� - ������� ������","������� ���������","������� �������","������� �44","���� � �������� �����","��������� �����","�������� �����","�������� �����","���� ������ ������","�������� �������",
	"������� ��������","������� ��������","��������� ��������","��� �����","������� �����","������� ������","��� �������� ����","������� �58","������� �59","����� �����","������� �61","������� �62","������� �63","������� �64","������� �65","66"=>'�������� �����',
"200"=> "���������",

//�������
"70" => "�������",
"71" => "�������",
"72" => "�������",
"75" => "�������",
"76" => "��� �������",
//
"80" => "�������",
"90" => "����� ����� �����������",
"91" => "�������", // � 91 � �� 97 ������ �� ������ � 191 �� ����� ��������
"92" => "�������",
"93" => "����������� ����� � ���������",
"94" => "���������� �������� � �������",
"95" => "���������� ��������",
"96" => "����� �����������",
"191" => "����� ��������",

//�������
"197"=>"��������� �������",
"198"=>"��������� �������",
"199"=>"��������� �������",

"270"=>"���� � ��������� ��������",
"271"=> "��������� ��������[1]",
"272"=> "��������� ��������[2]",
"273"=> "��������� ��������[3]",
"274"=> "��������� ��������[4]",
"275"=> "��������� ��������[5]",
"276"=> "��������� ��������[6]",
"277"=> "��������� ��������[7]",
"278"=> "��������� ��������[8]",
"279"=> "��������� ��������[9]",
"280"=> "��������� ��������[10]",
"281"=> "��������� ��������[11]",
"282"=> "��������� ��������[12]",
// ��������� ��������
"240"=>"���� � ��������� ��������",
"241"=> "��������� ��������[1]",
"242"=> "��������� ��������[2]",
"243"=> "��������� ��������[3]",
"244"=> "��������� ��������[4]",
"245"=> "��������� ��������[5]",
"246"=> "��������� ��������[6]",
"247"=> "��������� ��������[7]",
"248"=> "��������� ��������[8]",
"249"=> "��������� ��������[9]",
"250"=> "��������� ��������[10]",
"251"=> "��������� ��������[11]",
"252"=> "��������� ��������[12]",
"253"=> "��������� ��������[13]",
//�������� �������
"210"=>"���� � �������� �������",
"211"=> "�������� �������[1]",
"212"=> "�������� �������[2]",
"213"=> "�������� �������[3]",
"214"=> "�������� �������[4]",
"215"=> "�������� �������[5]",
"216"=> "�������� �������[6]",
"217"=> "�������� �������[7]",
"218"=> "�������� �������[8]",
"219"=> "�������� �������[9]",
"220"=> "�������� �������[10]",
"221"=> "�������� �������[11]",
"222"=> "�������� �������[12]",
"223"=> "�������� �������[13]",

//��� � ���������� ���������
"300" => "��� � ���������� ���������",

//���� ����� 400-450
"400" => "�������� �����",
"401" => "���� � �������� ������",
"402" => "�������� ������",

// ��
"501" => "��������� �����",
"502" => "�������",
"503" => "����� 3",
"504" => "����� 2",
"505" => "�������� ����� 2",
"506" => "����� 4",
"507" => "����� 1",
"508" => "��������� �������",
"509" => "��� ������ 2",
"510" => "�������� ����� 1",
"511" => "����� �� �����",
"512" => "��� ������ 2",
"513" => "����",
"514" => "��������� �������",
"515" => "��� ������ 1",
"516" => "������ ��� 2",
"517" => "������ ��� 1",
"518" => "������� ��� 3",
"519" => "��� ������ 1",
"520" => "��� ������ 3",
"521" => "��������� 3",
"522" => "��� ��������",
"523" => "���������",
"524" => "������� ���-����",
"525" => "������� ���",
"526" => "���������",
"527" => "��������� 1",
"528" => "���������� ����",
"529" => "�����.����-����",
"530" => "������ �������",
"531" => "��������� ��� 1",
"532" => "������� ��� 2",
"533" => "���������� 1",
"534" => "��������� 2",
"535" => "������ �����. �����",
"536" => "������� � �������",
"537" => "���������� 3",
"538" => "����� �� ����.����",
"539" => "������� ���-�������",
"540" => "�������� � ������ 1",
"541" => "����� �����. ����",
"542" => "��������� 4",
"543" => "��������� ��� 3",
"544" => "��������� ��� 2",
"545" => "��������� ������� 1",
"546" => "�������� � ������ 2",
"547" => "������ �����. ����� 2",
"548" => "�����.����-�����",
"549" => "���������� 2",
"550" => "��������� ������� 3",
"551" => "��������� ������� 2",
"552" => "�������� � ������ 3",
"553" => "�������",
"554" => "���������",
"555" => "��� ��������",
"556" => "�������� � ������ 4",
"557" => "������ �������",
"558" => "������ ������",
"559" => "������� � �������",
"560" => "������" ,
"600" => "�������",

"10000" => "����� ������",
"999" => "���� � �����",
"61000" => "������",
"72001" => "�������� �������",
"72002" => "����� �����",
);

if (CITY_ID == 0) {
	$rooms[49] = "���� �������";
}


function nick_pal($id,$align,$klan,$login,$level,$status,$logs)
{
	$rights = mysql_fetch_array(mysql_query ('SELECT * FROM `pal_rights` WHERE `pal_id` = '.$id.' LIMIT 1;'));
	$aalign=$align;
	if($rights['logs']==1){$chk='checked';$class='green';}else{$chk='';$class='red';}
	if($rights['ext_logs']==1){$chk1='checked';}

	$klan = mysql_fetch_array(mysql_query("SELECT vozm FROM `clans` WHERE `short` = '{$klan}' LIMIT 1;"));
	$polno = array();
	$polno = unserialize($klan['vozm']);

    $chan = mysql_fetch_array(mysql_query("SELECT * FROM `chanels` WHERE `klan`='pal' AND `user` = '".$id."';"));   //���������


	$align="<img src=http://i.oldbk.com/i/align_".$align.".gif border=0>";
//���
	$r_info="<tr><td>".$align."<b>".$login."</b>[".$level."]<a target=_blank href=inf.php?".$id.">
						<img border=0 src=http://i.oldbk.com/i/inf.gif></a></td><td>".//�������������� �������
				"<input size=40 name=q id='st_".$id."' type='text' value='".$status."' onchange=\"javascript:statusck('".$id."');\" ></td>".//�������� ���������
				"<td id=td_".$id." class=".$class.">";
						if($aalign>'1.5'){   //������ � ������� ���������
							$r_info.="<input ".$chk." id='prlog_".$id."' type='checkbox' onclick=\"javascript:prlog_pal('".$id."','0');\"> || ";
						}
                        if($aalign>'1.5'){ //������ � ����������� ���������
							$r_info.="<input ".$chk1." id='prexlog_".$id."' type='checkbox' onclick=\"javascript:prlog_pal('".$id."','1');\"></td>";
						}
         $klanrights = array(0=>'vin_', 1=>'tus_', 2=>'ars_'); //�������� �����. � �� ������������  (��� ���������� ����� �������� � pal_rights.php, � ���������� ��������� � ����)
                for($i=0;$i<count($klanrights);$i++)
                {
 						$r_info.="<td id=t".$klanrights[$i].$id." class=";
							if($polno[$id][$i]==1){$r_info.="green ";}else{$r_info.="red ";}
						$r_info.="><input ";
							if($polno[$id][$i]==1){$r_info.="checked ";}
						$r_info.=" id='".$klanrights[$i].$id."' type='checkbox' onclick=\"javascript:klanrights('".$id."','".$i."','".$klanrights[$i]."');\"></td>";
                }
        $r_info.="<td><input size=12 id='ch_".$id."' type='text' value='".$chan['name']."' onchange=\"javascript:chanels('".$id."');\" ></td>";
        $r_info.="</tr>";

	return $r_info;

}


function s_nick($id,$align,$klan,$login,$level)
{

  if($align!=''){
  $align="<img src=http://i.oldbk.com/i/align_".$align.".gif border=0>";
  }
  else
  {
   $align='';
  }
  if($klan!=''){
  $klan="<img src=http://i.oldbk.com/i/klan/".$klan.".gif border=0>";
        }
        else
        {
         $klan='';
        }

  $r_info=$align.$klan."<b>".$login."</b>[".$level."]<a target=_blank href=/inf.php?".$id."><img border=0 src=http://i.oldbk.com/i/inf.gif></a>";
  return $r_info;

}

function s_nicknaem($id,$align,$klan,$login,$level)
{

  if($align!=''){
  $align="<img src=http://i.oldbk.com/i/align_".$align.".gif border=0>";
  }
  else
  {
   $align='';
  }
  if($klan!=''){
  $klan="<img src=http://i.oldbk.com/i/klan/".$klan.".gif border=0>";
        }
        else
        {
         $klan='';
        }

  $r_info=$align.$klan."<b>".$login."</b>";
  return $r_info;

}


// nick
function nick ($user) {
	$id = $user['id'];

	/*if(!$user['battle']){
		mysql_query("UPDATE `users` SET `hp` = '10' WHERE  `hp` < '0' AND `id` = '{$id}' LIMIT 1;");
		mysql_query("DELETE FROM `effects` WHERE `time` <= ".time()." AND `owner` = '{$id}';");
		if ((time()-$user['fullhptime'])/60 > 0)
		{
			mysql_query("UPDATE `users` SET `hp` = `hp`+((".time()."-`fullhptime`)/60)*(`maxhp`/30), `fullhptime` = ".time()." WHERE  `hp` < `maxhp` AND `id` = '{$id}' LIMIT 1;");
		}
		mysql_query("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time()." WHERE  `hp` > `maxhp` AND `id` = '{$id}' LIMIT 1;");
	}*/
	?>
	<div style="width:200px;text-align:center;">
        <img src="http://i.oldbk.com/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<? if (($user['level']==13) and ($user['exp']>=8000000000) ) { echo "<font color=#F03C0E><b>{$user['level']}</b></font>"; } else { echo $user['level']; } ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a>
        <div style="width:200px;text-align:left;position:relative;height:12px;margin:0 auto;margin-bottom:3px;display:inline-block;" id=HP>
            <IMG style="position:absolute;" SRC=http://i.oldbk.com/i/herz.gif WIDTH=10 HEIGHT=10 ALT="������� �����">
            <div style="height: 12px;display:block;margin-left:10px;text-align:center;background: url('http://i.oldbk.com/i/1silver.gif');">
                <IMG style="position:absolute;left:10px;" SRC=http://i.oldbk.com/i/1green.gif WIDTH='<?=(190*($user['hp']/$user['maxhp']))?>' HEIGHT=12 ALT="������� �����" name=HP1 id=HP1>
                <span style="z-index: 2;font-weight: bold;position: relative;line-height: 11px;font-size:10px;color: white;text-shadow: 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black;">
                    <?php echo $user['hp']."/".$user['maxhp'] ?>
                </span>
            </div>
        </div>
    </div>
<?}


// nick
function nick2 ($id) {

	if($id > _BOTSEPARATOR_)
	{
		 $user2 = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
		if ( strpos($user2['login'],"��������� (����" ) !== FALSE )
		{
		$user2['hp'] = "??";
		$user2['level'] = "??";
		$user2['maxhp'] = "??";
		$user2['align']=0;
		$user2['klan']="";
		}

	} else {
//check hidden fred

		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' ;"));

				if (($user['hidden'] > 0) and ($user['hiddenlog']!=''))
				{
				  $fake=explode(",",$user['hiddenlog']);
					$user['id'] = $fake[0];
					$user['login'] = $fake[1];
					$user['level'] = $fake[2];
					$user['align'] = $fake[3];
					$user['sex'] = $fake[4];
					$user['klan'] = $fake[5];
				}
				else
				if($user['hidden'] > 0)
		 			{
					$user['login'] = "<i>���������</i>";
					$user['hp'] = "??";
					$user['maxhp'] = "??";
					$user['level'] = "??";
					$user['align']=0;
					$user['klan']="";
					$user['id'] = $user['hidden'];
					}

	}
	if($user2) {$user = $user2;}
	if (($user[0]) or ($user['login'] == "<i>���������</i>") )
	{
	?>
	<img src="http://i.oldbk.com/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<? if (($user['level']==13) and ($user['exp']>=8000000000) ) { echo "<font color=#F03C0E><b>{$user['level']}</b></font>"; } else { echo $user['level']; } ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a>
<?
	return 1;
	} else {
		echo $user['id'];
	}
}

function nick22 ($id) {

	if($id > _BOTSEPARATOR_)
	{
	 $user2 = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
	} else {
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
	}
	if($user2) {$user = $user2;}
	if ($user[0])
	{
	?>
	<img src="http://i.oldbk.com/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<? if (($user['level']==13) and ($user['exp']>=8000000000) ) { echo "<font color=#F03C0E><b>{$user['level']}</b></font>"; } else { echo $user['level']; } ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a>
<?
	return 1;
	} else {
		echo $user['id'];
	}
}

function nick9 ($id,$st) {
	if($id > _BOTSEPARATOR_)
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
	} else {
//check hidden fred
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' ;"));

				if  (($user['hidden'] > 0) and ($user['hiddenlog']!=''))
					{
					$fake=explode(",",$user['hiddenlog']);
					$user['id'] = $fake[0];
					$user['login'] = $fake[1];
					$user['level'] = $fake[2];
					$user['align'] = $fake[3];
					$user['sex'] = $fake[4];
					$user['klan'] = $fake[5];
					}
				else
					if($user['hidden'] > 0)
					 {
					$user['login'] = "<i>���������</i>";
					$user['hp'] = "??";
					$user['maxhp'] = "??";
					$user['level'] = "??";
					$user['align']=0;
					$user['klan']="";
					$user['id'] = $user['hidden'];
					}

	}
	if (($user[0]) or ($user['login'] == "<i>���������</i>") )
	{

		$mm .= "<img src=\"http://i.oldbk.com/i/align_".($user['align']>0 ? $user['align']:"0").".gif\">";
		if ($user['klan'] <> '') {
			$mm .= '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; }
			$mm .= "<span onclick=\"top.AddTo('".$user['login']."')\" oncontextmenu=\"return OpenMenu(event,".$user['level'].")\" class='{$st}'>{$user['login']}</span> [{$user['level']}]<a href=inf.php?{$user['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$user['login']}\"></a>";
	}
	return $mm;
}

// nick
function nick4 ($id, $st, $user_id, $team_check) {
	if($id > _BOTSEPARATOR_)
		{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));


	if(!($user['hp'] > 0))
	{
		$team_check = false;
	}

	//fix for hiddens colons by Fred
	if ( strpos($user['login'],"��������� (����" ) !== FALSE )
		{
		$user['login'] = "<i>".$user['login']."</i>";
		$user['hp'] = "??";
		$user['level'] = "??";
		$user['id'] = $user['id'];
		$user['maxhp'] = "??";
		$user['align']=0;
		$user['klan']="";
		}

	} else {

//check hidden fred
		//$hidden = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE type=200 and `owner` = '{$id}' LIMIT 1;"));
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' ;"));

			if  (($user['hidden'] > 0) and ($user['hiddenlog']!=''))
					{
					$fake=explode(",",$user['hiddenlog']);
					$user['id'] = $fake[0];
					$user['login'] = $fake[1];
					$user['level'] = $fake[2];
					$user['align'] = $fake[3];
					$user['sex'] = $fake[4];
					$user['klan'] = $fake[5];
					}
			else
			if($user['hidden'] > 0)
					 {
					$user['login'] = "<i>���������</i>";
					$user['hp'] = "??";
					$user['maxhp'] = "??";
					$user['level'] = "??";
					$user['align']=0;
					$user['klan']="";
					$user['id'] = $user['hidden'];
					}

	}
	if (($user[0]) or ($user['login'] == "<i>���������</i>") )
	{
		if($team_check && !($id > _BOTSEPARATOR_))
		{
			$time = time();
			$battle_data = mysql_query("SELECT bfd.razmen_from, bfd.time_blow, btl.timeout, btl.type FROM battle_fd bfd INNER JOIN battle btl ON btl.id = bfd.battle WHERE bfd.battle='".$user['battle']."' AND btl.status_flag > 0 AND btl.win = 3 AND bfd.razmen_to='".$user_id."' AND bfd.razmen_from='".$user['id']."' AND bfd.time_blow > 0;");
			while($row = mysql_fetch_row($battle_data))
			{
			 if (($row[3]==60)or($row[3]==61))
			 {
				if(($time - $row[1]) >= ($row[2] * 60 - 120))
				{
					$st = "B3";
				}
			 }
			 else
			 {
				if(($time - $row[1]) >= ($row[2] * 60 - 30))
				{
					$st = "B3";
				}
			}

			}
		}
		return "<span onclick=\"top.AddTo('".$user['login']."')\" oncontextmenu=\"return OpenMenu(event,".$user['level'].")\" class={$st}>".$user['login']."</span> [".$user['hp']."/".$user['maxhp']."]";
	}
}

// nick
function nick7 ($id) {
	if($id > _BOTSEPARATOR_)
	{
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
	} else {
		//check hidden fred
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' ;"));
		if($user['hidden'] > 0)
		 {
					$user['login'] = "<i>���������</i>";
					$user['hp'] = "??";
					$user['maxhp'] = "??";
					$user['level'] = "??";
					$user['align']=0;
					$user['klan']="";
					$user['id'] = $user['hidden'];
					}

	}
	if (($user[0]) or ($user['login'] == "<i>���������</i>") )
	{
		return $user['login'];
	}
}

function nick77 ($id) {
	if($id > _BOTSEPARATOR_)
	{
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
	} else
	{
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
	}
	if ($user[0])
	{
		return $user['login'];
	}
}


// nick
function nick5 ($id,$st) {
	if($id > _BOTSEPARATOR_)
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));

	if ( strpos($user['login'],"��������� (����" ) !== FALSE )
		{
		$user['hp'] = "??";
		$user['level'] = "??";
		$user['maxhp'] = "??";
		$user['align']=0;
		$user['klan']="";
		}
	} else {
//check hidden fred
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' ;"));
/*
				if  (($user['hidden'] > 0) and ($user['hiddenlog']!=''))
					{
					$fake=explode(",",$user['hiddenlog']);
					$user['id'] = $fake[0];
					$user['login'] = $fake[1];
					$user['level'] = $fake[2];
					$user['align'] = $fake[3];
					$user['sex'] = $fake[4];
					$user['klan'] = $fake[5];
					}
				else
					if($user['hidden'] > 0)
		 			{
					$user['login'] = "<i>���������</i>";
					$user['hp'] = "??";
					$user['maxhp'] = "??";
					$user['level'] = "??";
					$user['align']=0;
					$user['klan']="";
					$user['id'] = $user['hidden'];
					}
*/

	}
	if (($user[0]) or ($user['login'] == "<i>���������</i>") )
		{
		return "<span class={$st}>".$user['login']."</span>";
	}
}

// nick
function nick6 ($id) {
	if($id > _BOTSEPARATOR_)
	{
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
	} else
	{
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
	}
	if($user[0]) {
		return "".$user['login']."</b> [".$user['level']."]  <a href=inf.php?".$user['id']." target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � ".$user['login']."\"></a><B>";
	}
}
function nick_align_klan($telo)
{
if (($telo[hidden] > 0 ) and ($telo[hiddenlog]!=''))
  {
  //����������
  $fake=explode(",",$telo['hiddenlog']);
		$telo['id']=$fake[0];
		$telo['login']=$fake[1];
		$telo['level']=$fake[2];
		$telo['align']=$fake[3];
		$telo['sex']=$fake[4];
		$telo['klan']=$fake[5];

$mm .= "<img src=\"http://i.oldbk.com/i/align_".($telo['align']>0 ? $telo['align']:"0").".gif\">";
		if ($telo['klan'] <> '')
	{
			$mm .= '<img title="'.$telo['klan'].'" src="http://i.oldbk.com/i/klan/'.$telo['klan'].'.gif">';
	}
	$mm .= "<B>{$telo['login']}</B> [{$telo['level']}]<a href=inf.php?{$telo['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$telo['login']}\"></a>";
  }
elseif ($telo[hidden] > 0 )
  {
  $mm .="<B><i>���������</i></B><a href=inf.php?{$telo[hidden]} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � ���������}\"></a>";
  }
else
{
$mm .= "<img src=\"http://i.oldbk.com/i/align_".($telo['align']>0 ? $telo['align']:"0").".gif\">";
		if ($telo['klan'] <> '')
	{
			$mm .= '<img title="'.$telo['klan'].'" src="http://i.oldbk.com/i/klan/'.$telo['klan'].'.gif">';
	}
	$mm .= "<B>{$telo['login']}</B> [";

	if (($telo['level']==13) and ($telo['exp']>=8000000000) )
	{
	$mm .="<font color=#F03C0E><b>".$telo['level']."</b></font>";
	}
	else
	{
	$mm .=$telo['level'];
	}
	$mm .="]<a href=inf.php?{$telo['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$telo['login']}\"></a>";
}

	return $mm;
}

// nick3
function nick3 ($id) {
	if($id > _BOTSEPARATOR_)
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
		if ( strpos($user['login'],"��������� (����" ) !== FALSE )
		{
		$user['hp'] = "??";
		$user['level'] = "??";
		$user['maxhp'] = "??";
		$user['align']=0;
		$user['klan']="";
		}
	} else {
//check hidden fred
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' ;"));

		if (($user['hidden'] > 0) and ($user['hiddenlog']!=''))
			{
				$fake=explode(",",$user['hiddenlog']);
				$user['id'] = $fake[0];
				$user['login'] = $fake[1];
				$user['level'] = $fake[2];
				$user['align'] = $fake[3];
				$user['sex'] = $fake[4];
				$user['klan'] = $fake[5];
				}
		else
		if($user['hidden'] > 0)
		 {
					$user['login'] = "<i>���������</i>";
					$user['hp'] = "??";
					$user['maxhp'] = "??";
					$user['level'] = "??";
					$user['align']=0;
					$user['klan']="";
					$user['id'] = $user['hidden'];
					}

	}

	if (($user[0]) or ($user['login'] == "<i>���������</i>") )
		 {

		$mm .= "<img src=\"http://i.oldbk.com/i/align_".($user['align']>0 ? $user['align']:"0").".gif\">";
		if ($user['klan'] <> '') {
			$mm .= '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; }
			$mm .= "<B>{$user['login']}</B> [{$user['level']}]<a href=inf.php?{$user['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$user['login']}\"></a>";
	}
	return $mm;
}

// nick33 for pals
function nick33 ($id) {

	if($id > _BOTSEPARATOR_)
	{
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
	} else {
	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
	}

	if (($user[0]) )
		 {

		$mm .= "<img src=\"http://i.oldbk.com/i/align_".($user['align']>0 ? $user['align']:"0").".gif\">";
		if ($user['klan'] <> '') {
			$mm .= '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; }
			$mm .= "<B>{$user['login']}</B> [{$user['level']}]<a href=inf.php?{$user['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$user['login']}\"></a>";
	}
	return $mm;
}



// ������� ��
function setHP($hp,$maxhp,$battle) {
	$hidden=false;

	if (($hp[0]=='?') and ($hp[1]=='?'))
		{
		$hidden=true; $hp=100;$maxhp=100;
		}

		if ( $hp < $maxhp*0.33 ) {
			$polosa = 'http://i.oldbk.com/i/1red.gif';
		}
		elseif ( $hp < $maxhp*0.66 ) {
			$polosa = 'http://i.oldbk.com/i/1yellow_1.gif';
		}
		else {
			$polosa = 'http://i.oldbk.com/i/1green.gif';
		}

		$rr = "<div style=\"display:inline-block;vertical-align:middle;width:200px;text-align:left;position:relative;height:12px;margin:0 auto;margin-bottom:3px;\" ";
		if (!$battle) {
			$rr .= ' id=HP ';
		}
		$rr .= "><IMG style=\"position:absolute;\" SRC=http://i.oldbk.com/i/herz.gif WIDTH=10 HEIGHT=10 ALT=\"������� �����\">
            <div style=\"height: 12px;display:block;margin-left:10px;text-align:center;background: url('http://i.oldbk.com/i/1silver.gif');\">
            <IMG style=\"position:absolute;left:10px;\" SRC='{$polosa}' WIDTH=";
		$rr .= (190*($hp/$maxhp));
		$rr .= ' HEIGHT=12 ALT="������� �����" name=HP1>';
//		$rr .= '<span style="z-index: 2;font-weight: bold;position: relative;line-height: 10px;font-size:10px;color: white;">';
		$rr .= '<span style="z-index: 2;font-weight: bold;position: relative;line-height: 11px;font-size:10px;color: white;text-shadow: 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black;">';

		if ($hidden==true) { $rr .= '??/??'; } else { $rr .= $hp.'/'.$maxhp; }
		$rr .= '</span></div></div>';

		return $rr;
}

function setMP($mp,$maxmp,$battle) {
        $hidden=false;
        if ($mp=='??') { $hidden=true; $mp=10;$maxmp=10; }

		$rr = "<div style=\"display:inline-block;vertical-align:middle;width:200px;text-align:left;position:relative;height:12px;margin:0 auto;margin-bottom:3px;\" ";

		if (!$battle) {
			$rr .= ' id=MP ';
		}
		$rr .= "><IMG style=\"position:absolute;\" SRC=http://i.oldbk.com/i/Mherz.gif WIDTH=10 HEIGHT=10 ALT=\"������� ����\">
                <div style=\"height: 12px;display:block;margin-left:10px;text-align:center;background: url('http://i.oldbk.com/i/1silver.gif');\">
                <IMG style=\"position:absolute;left:10px;\" SRC='http://i.oldbk.com/i/1blue.gif' WIDTH=";
		$rr .= (190*($mp/$maxmp));
		$rr .= ' HEIGHT=12 ALT="������� ����" name=MP1>';
		$rr .= '<span style="z-index: 2;font-weight: bold;position: relative;line-height: 11px;font-size:10px;color: white;text-shadow: 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black;">';
		if ($hidden) {	$rr .= '??/??'; } else {	$rr .= $mp.'/'.$maxmp; }
		$rr .= '</span></div></div>';

		return $rr;
}

function setST($st,$level) {

if ($st=='??') { $hidden=true; $st=100;$maxst=100; }
 else { $maxst=($level*500); $st=$maxst-$st;    }

		$rr = "<div ";

		$rr .= "><IMG SRC=http://i.oldbk.com/i/ruby.gif WIDTH=10 HEIGHT=10 ALT=\"������� ���������\"><IMG SRC='http://i.oldbk.com/i/stamina.gif' WIDTH=";
		$rr .= (150*($st/$maxst));
		$rr .= ' HEIGHT=10 ALT="������� ���������" name=ST1><IMG SRC=http://i.oldbk.com/i/1silver.gif WIDTH=';
		$rr .= (150-150*($st/$maxst));
		$rr .= ' HEIGHT=10 ALT="������� ���������" name=ST2>: ';
		if ($hidden) {	$rr .= '??/??</div>'; } else {	$rr .= $st.'/'.$maxst.'</div>'; }
		return $rr;
}

function setnaemEN($energy,$maxenergy,$battle) {
		$energy=(int)($energy);
		$rr = "<div style=\"display:inline-block;vertical-align:middle;width:200px;text-align:left;position:relative;height:12px;margin:0 auto;margin-bottom:3px;\" ";
		if (!$battle) {
			$rr .= ' id=ENERGY ';
		}
		$rr .= "><IMG style=\"position:absolute;\" SRC=http://i.oldbk.com/i/ruby.gif WIDTH=10 HEIGHT=10 ALT=\"������� �������\" TITLE=\"������� �������\">
                <div style=\"height: 12px;display:block;margin-left:10px;text-align:center;background: url('http://i.oldbk.com/i/1silver.gif');\">
                <IMG style=\"position:absolute;left:10px;\" SRC='http://i.oldbk.com/i/stamina.gif' WIDTH=";
		$rr .= (190*($energy/$maxenergy));
		$rr .= ' HEIGHT=12 ALT="������� �������" TITLE="������� �������" name=ENERGY1>';
		$rr .= '<span style="z-index: 2;font-weight: bold;position: relative;line-height: 11px;font-size:10px;color: white;text-shadow: 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black, 0 0 0.1em black;">';
		$rr .= $energy.'/'.$maxenergy;
		$rr .= '</span></div></div>';
		return $rr;
}


function showScrollSlot($dress, $magic) {
	global $user;
	$script = $user['battle'] ? 'fbattle' : 'main';
	if ($dress != null) {
		if ($dress['magic']) {
			echo "<a  onclick=\"";
			if($magic['targeted'] == 8) {
				echo "oknoPass('������� ������', '".$script.".php?use={$dress['id']}', 'target'); ";
			}
			else
			if($magic['targeted'] == 10) {
				echo "oknoCity('������� �������� ������(capital,avalon)', '".$script.".php?use={$dress['id']}', 'target'); ";
			}
			else
			if($magic['targeted'] == 13) {
				echo "oknoTeloCity('������� ��� �  �������� ������(capital,avalon)', '".$script.".php?use={$dress['id']}', 'target','city'); ";
			}
			else
			if($magic['targeted'] == 1) {
				echo "okno('������� �������� ��������', '".$script.".php?use={$dress['id']}', 'target'); ";
			}
			else
			if($magic['targeted'] == 15) {
				echo "okno('������� ����� ������ ����������� �����', '".$script.".php?use={$dress['id']}', 'target',null,2); ";
			}
			 else {
     			if($magic['targeted'] == 2) {
		    		echo "findlogin('������� ��� ���������', '".$script.".php?use={$dress['id']}', 'target'); ";
	    		}
	    		else
	    		if(($magic['targeted'] == 0) AND ($magic['name'] == '���������') and ($user['in_tower']==0) )
	    		{
	    		  echo "if(confirm('������������ ������?')) { window.location='".$script.".php?use=".$dress['id']."';}";
	    		}
	    		else
	    		if(($magic['targeted'] == 0) AND ($magic['name'] == '���������') and ($user['in_tower']>0) )
	    		{
		    		echo "findlogin('������� ��� ���������', '".$script.".php?use={$dress['id']}', 'target'); ";
	    		}
	    		else {
			    	if($magic['targeted'] == 3) {
				    	echo "comment_fight('������� �����������', '".$script.".php?use={$dress['id']}', 'target'); ";
				    } else {
					    echo "if(confirm('������������ ������?')) { window.location='".$script.".php?use=".$dress['id']."';}";
				    }
			    }
			}
			echo "\" href='#'>";
		}
		echo '<img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 title="'.$dress['name'].'  ��������� '.$dress['duration'].'/'.$dress['maxdur'].'"  ��������� '.$dress['duration'].'/'.$dress['maxdur'].'" height=25 alt="������������  '.$dress['name']."\n��������� ".$dress['duration']."/".$dress['maxdur'].'"></a>';
	} else {

		if (($user['id']>0) and ($user['battle']==0))
		{
		    echo "<a href=\"?edit=1&filt=12\"><img src=http://i.oldbk.com/i/w13.gif width=40 height=25  alt='������ ���� �����' title='������ ���� �����'></a>";
		}
		else
		{
		    echo "<img src=http://i.oldbk.com/i/w13.gif width=40 height=25  alt='������ ���� �����' title='������ ���� �����'>";
	  	}
	}
}

function hiddenoff($telo) {
$eff = mysql_fetch_assoc(mysql_query("SELECT * FROM effects WHERE type = '200' and owner ='{$telo['id']}' and idiluz!=0 limit 1;"));
	if ($eff)
  {
  mysql_query("DELETE from effects where type=200 and owner ='{$telo['id']}' and idiluz!=0;");
  mysql_query("update users set hidden=0 where id='{$telo['id']}' ;");
  log_cancel_delo($telo,$eff);
  }
}

function illusionoff($telo) {
$eff = mysql_fetch_assoc(mysql_query("SELECT * FROM effects WHERE type = '1111' and owner ='{$telo['id']}' and idiluz!=0 limit 1;"));
	if ($eff)
  {
  mysql_query("DELETE from effects where type=1111 and owner ='{$telo['id']}' and idiluz!=0;");
  mysql_query("update users set hidden=0, hiddenlog='' where id='{$telo['id']}' ;");
  log_cancel_delo($telo,$eff);
  }
}

function echoscroll($slot,$dress=null) {
		global $user;
		if ($user['battle']) {
			$script = 'fbattle';
		} else {
			$script = 'main';
		}
		if ($user[$slot] > 0) {
			$row['id'] = $user[$slot];

			 if (!($dress))
			    {
			    $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `id` = '{$user[$slot]}' LIMIT 1;"));
			     }

			if ($dress['magic']) {
				$magic = magicinf ($dress['magic']);
				echo "<a  onclick=\"";
				if($magic['targeted']==1) {
					echo "okno('������� �������� ��������', '".$script.".php?use={$row['id']}', 'target'); ";
				}else
				if($magic['targeted'] == 10) {
				echo "oknoCity('������� �������� ������(capital,avalon)', '".$script.".php?use={$row['id']}', 'target'); ";
				}
				else
				if($magic['targeted'] == 13) {
				echo "oknoTeloCity('������� ��� �  �������� ������(capital,avalon)', '".$script.".php?use={$row['id']}', 'target','city'); ";
				}
				else
				if($magic['targeted']==15) {
					echo "okno('������� ����� ������ ����������� ����', '".$script.".php?use={$row['id']}', 'target',null,2); ";
				}
				else
				if($magic['targeted']==2) {
					echo "findlogin('������� ��� ���������', '".$script.".php?use={$row['id']}', 'target'); ";
				}else {
				if($magic['targeted']==3) {
					echo "comment_fight('������� �����������', '".$script.".php?use={$row['id']}', 'target'); ";
				} else {
					//echo "if(confirm('������������ ������?')) { window.location='".$script.".php?use=".$row['id']."';}";
					echo "if(confirm('������������ ������?')) {
							 window.location='".$script.".php?use=".$row['id']."&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;

							}";


				}
				}
				echo "\" href='#'>";
			echo '<img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 title="'.$dress['name'].'  ��������� '.$dress['duration'].'/'.$dress['maxdur'].'"  ��������� '.$dress['duration'].'/'.$dress['maxdur'].'" height=25 alt="������������  '.$dress['name']."\n��������� ".$dress['duration']."/".$dress['maxdur'].'"></a>';
			}
			else { echo "<img src=http://i.oldbk.com/i/w13.gif width=40 height=25  alt='������ ���� �����'>"; }

		} else { echo "<img src=http://i.oldbk.com/i/w13.gif width=40 height=25  alt='������ ���� �����'>"; }
	}
//Cheshire
function shincmag($dress) {
	if($dress['type']!='5') {
		$dr['res_x'] = 60;
    	} elseif($dress['type'] == '5') {
    		$dr['res_x'] = 20;
    	}

    	if($dress['type'] == 1 || $dress['type']=='2' || $dress['type']=='5') {
		$dr['res_y']=20;
    	} elseif($dress['type']=='3' || $dress['type']=='8' || $dress['type']=='10') {
        	$dr['res_y']=60;
    	} elseif($dress['type']=='9' || $dress['type']=='11') {
        	$dr['res_y']=40;
    	} elseif($dress['type']=='4') {
        	$dr['res_y']=80;
	}

    	if($dress['includemagicmax']>0){
		$dr['koef']=$dress['includemagicdex']/$dress['includemagicmax'];

	}

	return $dr;
}

function showMagicHref($dress, $magic) {
	global $user;
	$script = $user['battle'] ? 'fbattle' : 'main';
    	echo "<a  onclick=\"";

    	$dr=shincmag($dress);

	if($magic['targeted'] == 1) {
		echo "okno('������� �������� ��������', '{$script}.php?use={$dress['id']}', 'target')";
	} elseif($magic['targeted'] == 10) {
		echo "oknoCity('������� �������� ������(capital,avalon)', '".$script.".php?use={$dress['id']}', 'target'); ";
	} elseif($magic['targeted'] == 13) {
				echo "oknoTeloCity('������� ��� �  �������� ������(capital,avalon)', '".$script.".php?use={$dress['id']}', 'target','city'); ";
	} elseif($magic['targeted'] == 15) {
		echo "okno('������� ����� ������ ����������� �����', '{$script}.php?use={$dress['id']}', 'target',null,2)";
	} elseif($magic['targeted'] == 2) {
		echo "findlogin('".$magic['name']."', '{$script}.php?use={$dress['id']}', 'target')";
	} else {
		  echo "if(confirm('������������ ������?')) {
					 window.location='".$script.".php?use=".$dress['id']."&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;
			}";
	}

	 $elkas='';

	if (((($dress['prototype'] >= 55510301) AND ($dress['prototype'] <= 55510311)) || (($dress['prototype'] >= 55510328) AND ($dress['prototype'] <= 55510333))) or ($dress['prototype']==55510350) or ($dress['prototype']==55510351) or ($dress['prototype']==55510352) or ($dress['prototype']==410027) or ($dress['prototype']==410028)) {
	 	$elkas="<br>����������� ����: <b>".$dress['up_level']."</b>";
 	}

	echo "\" href='#'>";


	$vstr = render_vstroj($dress['includemagicdex']);
	echo '<div style="position:relative;">'.$vstr.'<img src="http://i.oldbk.com/i/sh/'.$dress[img].'" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,'.($dr[res_x]-5).','.($dr[res_y]-5).',\'<b>'.$dress['name']."</b>".$elkas."<br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'<br>  �������� �����: '.$magic['name'].'\')"></div></a>';
}
  //���� ����� + �������.
function showMagicHref2($dress,$dress2,$magic) {
	global $user;
	$script = $user['battle'] ? 'fbattle' : 'main';

    	echo "<a  onclick=\"";
	if($magic['targeted'] == 1) {     //���� ����� + �������.
		echo "okno('������� �������� ��������', '{$script}.php?use={$dress2['id']}', 'target')";
	}
	elseif($magic['targeted'] == 10) {
				echo "oknoCity('������� �������� ������(capital,avalon)', '{$script}.php?use={$dress2['id']}', 'target')";
			}
	elseif($magic['targeted'] == 13) {
				echo "oknoTeloCity('������� ��� �  �������� ������(capital,avalon)', '".$script.".php?use={$dress2['id']}', 'target','city'); ";
	}
	elseif($magic['targeted'] == 15) {
		echo "okno('������� ����� ������ ����������� �����', '{$script}.php?use={$dress2['id']}', 'target',null,2)";
	}
	elseif($magic['targeted'] == 2) {
		echo "findlogin('".$magic['name']."', '{$script}.php?use={$dress2['id']}', 'target')";
	} else {
		//echo "if (confirm('������������ ������?')) window.location='".$script.".php?use=".$dress2['id']."';";
		  echo "if(confirm('������������ ������?')) {
					window.location='".$script.".php?use=".$dress2['id']."&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;}";


	}
	echo "\" href='#'>";

	$dr = shincmag($dress2);

	$vstr = render_vstroj($dress2['includemagicdex']);
	echo '<div style="position:relative;">'.$vstr.'<img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").''.(($dress['includemagic'])?'<br><br><b>�������� �����: '.$magic['name'].' '.$dress['includemagicdex'].' �� '.$dress['includemagicmax'].' ��.</b>':'').'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������: {$dress2['text']}":"").''.(($dress2['includemagic'])?'<br><br><b>�������� �����: '.$magic2['name'].' '.$dress2['includemagicdex'].' �� '.$dress2['includemagicmax'].' ��.</b>':'').'</span></td></tr></table>\')"></div></a>';

}

function showMagicHref3($dress, $dress2, $magic) {
	global $user;
	$script = $user['battle'] ? 'fbattle' : 'main';


    	echo "<a  onclick=\"";
	if($magic['targeted'] == 1) {
		echo "okno('������� �������� ��������', '{$script}.php?use={$dress['id']}', 'target')";
	}
	 elseif($magic['targeted'] == 10) {
		echo "oknoCity('������� �������� ������(capital,avalon)', '{$script}.php?use={$dress['id']}', 'target')";
	}
	elseif($magic['targeted'] == 13) {
				echo "oknoTeloCity('������� ��� �  �������� ������(capital,avalon)', '".$script.".php?use={$dress['id']}', 'target','city'); ";
	}
	elseif($magic['targeted'] == 15) {
		echo "okno('������� ����� ������ ����������� �����', '{$script}.php?use={$dress['id']}', 'target',null,2)";
	}
	elseif($magic['targeted'] == 2) {
		echo "findlogin('".$magic['name']."', '{$script}.php?use={$dress['id']}', 'target')";
	} else {
		//echo "if (confirm('������������ ������?')) window.location='".$script.".php?use=".$dress['id']."';";
		  echo "if(confirm('������������ ������?')) {
							 window.location='".$script.".php?use=".$dress['id']."&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;

							}";


	}
	echo "\" href='#'>";


	$dr = shincmag($dress);

	$vstr = render_vstroj($dress['includemagicdex']);


	echo '<div style="position:relative;">'.$vstr.'<img src="http://i.oldbk.com/i/sh/'.$dress[img].'"
	onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,'.($dr[res_x]-5).','.($dr[res_y]-5).',\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").''.(($dress['includemagic'])?'<br><br><b>�������� �����: '.$magic['name'].' '.$dress['includemagicdex'].' �� '.$dress['includemagicmax'].' ��.</b>':'').'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������: {$dress2['text']}":"").''.(($dress2['includemagic'])?'<br><br><b>�������� �����: '.$magic2['name'].' '.$dress2['includemagicdex'].' �� '.$dress2['includemagicmax'].' ��.</b>':'').'</span></td></tr></table>\')"></div></a>';


}


function showMagicHref4($dress, $dress2, $magic) {

	global $user;
	$script = $user['battle'] ? 'fbattle' : 'main';



     echo "<a  onclick=\"";
	if($magic['targeted'] == 1) {
		echo "okno('������� �������� ��������', '{$script}.php?use={$dress['id']}', 'target')";
	}
	elseif($magic['targeted'] == 10) {
		echo "oknoCity('������� �������� ������(capital,avalon)', '{$script}.php?use={$dress['id']}', 'target')";
	}
	elseif($magic['targeted'] == 13) {
				echo "oknoTeloCity('������� ��� �  �������� ������(capital,avalon)', '".$script.".php?use={$dress['id']}', 'target','city'); ";
	}
	elseif($magic['targeted'] == 15) {
		echo "okno('������� ����� ������ ����������� �����', '{$script}.php?use={$dress['id']}', 'target',null,2)";
	}
	 elseif($magic['targeted'] == 2) {
		echo "findlogin('".$magic['name']."', '{$script}.php?use={$dress['id']}', 'target')";
	} else {
		//echo "if (confirm('������������ ������?')) window.location='".$script.".php?use=".$dress['id']."';";
		  echo "if(confirm('������������ ������?')) {
							 window.location='".$script.".php?use=".$dress['id']."&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;

							}";


	}
	echo "\" href='#'>";

	$dr = shincmag($dress);

	$vstr = render_vstroj($dress['includemagicdex']);

	echo '<div style="position:relative;">'.$vstr.'<img src="http://i.oldbk.com/i/sh/'.$dress[img].'" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,'.($dr[res_x]-5).','.($dr[res_y]-5).',\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").''.(($dress['includemagic'])?'<br><br><b>�������� �����: '.$magic['name'].' '.$dress['includemagicdex'].' �� '.$dress['includemagicmax'].' ��.</b>':'').'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������: {$dress2['text']}":"").''.(($dress2['includemagic'])?'<br><br><b>�������� �����: '.$magic2['name'].' '.$dress2['includemagicdex'].' �� '.$dress2['includemagicmax'].' ��.</b>':'').'</span></td></tr></table>\')" ></div></a>';

}

//����� �����+�������+�������
//�������� �� dress2
function showMagicHref21($dress,$dress2,$dress3,$magic,$magic2,$magic3) {
	global $user;
	$script = $user['battle'] ? 'fbattle' : 'main';

	if ($dress['includemagicdex'])
	   {
	   $out_item=$dress;
	   $out_magic=$magic;
	   $it=1;
	   }
	   elseif ($dress2['includemagicdex'])
	   {
	   $out_item=$dress2;
   	   $out_magic=$magic2;
	   $it=2;
	   }
	   else
	   {
	   $out_item=$dress3;
   	   $out_magic=$magic3;
  	   $it=3;
	   }

	{
        echo "<a  onclick=\"";
    	if($out_magic['targeted'] == 1) {     //���� ����� + �������.
		echo "okno('������� �������� ��������', '{$script}.php?use={$out_item['id']}', 'target')";
	}
	elseif($out_magic['targeted'] == 10) {
				echo "oknoCity('������� �������� ������(capital,avalon)', '{$script}.php?use={$out_item['id']}', 'target')";
			}
	elseif($out_magic['targeted'] == 13) {
				echo "oknoTeloCity('������� ��� �  �������� ������(capital,avalon)', '{$script}.php?use={$out_item['id']}', 'target','city')";
			}
	elseif($out_magic['targeted'] == 15) {
		echo "okno('������� ����� ������ ����������� �����', '{$script}.php?use={$out_item['id']}', 'target',null,2)";
	}
	elseif($out_magic['targeted'] == 2) {
		echo "findlogin('".$out_magic['name']."', '{$script}.php?use={$out_item['id']}', 'target')";
	} else {
		  echo "if(confirm('������������ ������?')) {
					window.location='".$script.".php?use=".$out_item['id']."&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;}";
	}
	echo "\" href='#'>";
	}

	$dr = shincmag($dress2);


	$vstr = render_vstroj($dress2['includemagicdex']);

	echo '<div style="position:relative;">'.$vstr.'<img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)"
	onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").''.(($dress['includemagic'])?'<br><br><b>�������� �����: '.$magic['name'].' '.$dress['includemagicdex'].' �� '.$dress['includemagicmax'].' ��.</b>':'').'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������: {$dress2['text']}":"").''.(($dress2['includemagic'])?'<br><br><b>�������� �����: '.$magic2['name'].' '.$dress2['includemagicdex'].' �� '.$dress2['includemagicmax'].' ��.</b>':'').'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress3['img'].' width=60 height=80><br><b>'.$dress3['name']."</b><br>��������� ".$dress3['duration']."/".$dress3['maxdur']."<br>��������� ��: ".(($dress3['ghp']>0)?"<br>������� ����� +{$dress3['ghp']}":"")." ".(($dress3['gsila']!=0)?"<br>� ����:{$dress3['gsila']}":"")." ".(($dress3['glovk']!=0)?"<br>� ��������:{$dress3['glovk']}":"")." ".(($dress3['ginta']!=0)?"<br>� ��������:{$dress3['ginta']}":"")." ".(($dress3['gintel']!=0)?"<br>� ���������:{$dress3['gintel']}":"")." ".(($dress3['gmp']!=0)?"<br>� ��������:{$dress3['gmp']}":"")." ".(($dress3['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress3['mfkrit']}%":"")." ".(($dress3['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress3['mfakrit']}%":"")." ".(($dress3['mfuvorot']!=0)?"<br>� ��. ������������:{$dress3['mfuvorot']}%":"")." ".(($dress3['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress3['mfauvorot']}%":"")." ".(($dress3['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress3['gnoj']}":"")." ".(($dress3['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress3['gtopor']}":"")." ".(($dress3['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress3['gdubina']}":"")." ".(($dress3['gmech']!=0)?"<br>� �������� ������:+{$dress3['gmech']}":"")." ".(($dress3['gfire']!=0)?"<br>� �������� ������ ����:+{$dress3['gfire']}":"")." ".(($dress3['gwater']!=0)?"<br>� �������� ������ ����:+{$dress3['gwater']}":"")." ".(($dress3['gair']!=0)?"<br>� �������� ������ �������:+{$dress3['gair']}":"")." ".(($dress3['gearth']!=0)?"<br>� �������� ������ �����:+{$dress3['gearth']}":"")." ".(($dress3['glight']!=0)?"<br>� �������� ����� �����:+{$dress3['glight']}":"")." ".(($dress3['ggray']!=0)?"<br>� �������� ����� �����:+{$dress3['ggray']}":"")." ".(($dress3['gdark']!=0)?"<br>� �������� ����� ����:+{$dress3['gdark']}":"")." ".(($dress3['bron1']!=0)?"<br>� ����� ������:{$dress3['bron1']}":"")." ".(($dress3['bron2']!=0)?"<br>� ����� �������:{$dress3['bron2']}":"")." ".(($dress3['bron3']!=0)?"<br>� ����� �����:{$dress3['bron3']}":"")." ".(($dress3['bron4']!=0)?"<br>� ����� ���:{$dress3['bron4']}":"")." ".(($dress3['text']!=null)?"<br>  �� ������ ������: {$dress3['text']}":"").''.(($dress3['includemagic'])?'<br><br><b>�������� �����: '.$magic3['name'].' '.$dress3['includemagicdex'].' �� '.$dress3['includemagicmax'].' ��.</b>':'').'</span></td></tr></table>\')" ></div></a>';


}

function prettyTime($start_timestamp = null, $end_timestamp = null)
{
    $start_datetime = new DateTime();
    if($start_timestamp !== null) {
        $start_datetime->setTimestamp($start_timestamp);
    }

    $end_datetime = new DateTime();
    if($end_timestamp !== null) {
        $end_datetime->setTimestamp($end_timestamp);
    }

    if(($end_datetime->getTimestamp() - $start_datetime->getTimestamp()) <= 60) {
       return '����� ������';
    }

    $interval = $end_datetime->diff($start_datetime);

    $time_type = array(
        'm' => '%m ���.',
        'd' => '%d ��.',
        'h' => '%h �.',
        'i' => '%i ���.',
    );
    $format_arr = array();
    foreach($time_type as $property => $format) {
        if($interval->{$property} != 0) {
            $format_arr[] = $format;
        }
    }

    if(empty($format_arr)) {
        return null;
    }

    return $interval->format(implode(' ', $format_arr));
}


// �������� ����� � ����
function showpersout($id, $pas = 0, $battle = 0, $me = 0,$admin=0) {
	global $rooms, $LIC_NAIM, $LIC_TORG, $LIC_MAG, $LIC_LEK, $nclass_name ;
  	if($id > _BOTSEPARATOR_)
  	{
		$bot = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `id` = '{$id}' LIMIT 1;"));
		$id = $bot['id_user'];
		if ($id == 84) {
			$user = $bot;
			$user['origid'] = $bot['id'];
			$user['room'] =	$bot['bot_room'];
			$user['id'] = 84;
		} elseif ($bot['owner']>0)
		{
		$user = $bot;
		}
		else {
			$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$bot['id_user']}' LIMIT 1;"));
			$user['login'] = $bot['login'];
			$user['hp'] = $bot['hp'];
			$user['maxhp'] = $bot['maxhp'];
			$user['level'] = $bot['level'];
			//$user['id'] = $bot['id'];
			$user['battle']=$bot['battle'];
		}
	} else {
    		$user = mysql_fetch_array(mysql_query("SELECT *, (select chaos from  ristalka where owner=u.id) as users_chaos  FROM `users` u  WHERE `id` = '{$id}' LIMIT 1;"));
	}
	if ($user['id']==$_SESSION['uid']) {$admin=1; } // ���� ���������� ���� ���� �� ��� ����������
	if (preg_match("/^(.*?)\.(.*?)\.(.*?) (.*?):(.*?) /",$user['palcom'],$mt)) {
			 $red_dat=$mt[2].".".$mt[1].".".$mt[3]." ".$mt[4].":".$mt[5];
			 $user['palcom']=$red_dat." ".preg_replace("/^(.*?)\.(.*?)\.(.*?) (.*?):(.*?) /","",$user['palcom']);
	}

	$is301 = false;
	$is302 = false;
	$isunikstatus = false;
	$obez = false;

	if (isset($user['origid'])) {
		$queryeff = mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$user['origid']." and `time`> UNIX_TIMESTAMP()  ORDER BY `type` DESC;");
	} else {
		$queryeff = mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$user['id']." and `time`> UNIX_TIMESTAMP()  ORDER BY `type` DESC;");
	}

  //�������� ���������������� �������� �� �������

  $uimg=get_users_gellery($user);

	// ������������ ������



	$effarray = array();

	while($r = mysql_fetch_assoc($queryeff)) {
		$effarray[] = $r;
		if ($r['type'] == 301) {
			$is301 = $r['add_info'];
		}
		if ($r['type'] == 302) {
			$is302 = $r['add_info'];
		}
		if ($r['type'] == 4201 && $obez == false) {
			$unikstatus = $user['unikstatus'];
		}
		if ($r['type'] == 5) {
			$obez = true;
			$unikstatus = false;
		}
	}


	if ($user['in_tower'] != 0) {
		$is301 = false;
		$is302 = false;
	}


	if ($user['id'] == 84) {
		// fix for DT arch
		$user['id'] = $user['id_user'];
		$query = mysql_query(
			'select * from oldbk.inventory where
			id in ('.GetDressedItems($user).')'
		);
		$user['id'] = 84;
	} else {
		$query = mysql_query(
			'select * from oldbk.inventory where
			id in ('.GetDressedItems($user).')'
		);
	}
	$magicIds   = array();
	$magicIds[] = 0;
	$magicItems = array();
	$wearItems  = array();



	while($row = mysql_fetch_assoc($query)) {
		$row['name']=str_replace('\\','\\\\',$row['name']);
		$row[img_url]=$row[img];

          /* - ������ ��� �� ��������
          if($row[add_pick]!=''&& $row[pick_time]>time()) {
        		$row[img]=$row[add_pick];
        	}
          */


                    if (($row['id']==$user['r1']) and ($uimg[5][1]!='')) {$row['img']=$uimg[$row['type']][1];}
                      elseif (($row['id']==$user['r2']) and ($uimg[5][2]!='')) {$row['img']=$uimg[$row['type']][2];}
                        elseif (($row['id']==$user['r3']) and ($uimg[5][3]!='')) {$row['img']=$uimg[$row['type']][3];}
                          elseif (($row['id']==$user['shit']) and ($uimg[10][1]!='')) {$row['img']=$uimg[10][1];}
                            elseif (($row['id']==$user['weap']) and ($uimg[3][1]!='')) {$row['img']=$uimg[3][1];}
                            elseif (($uimg[$row['type']][1]!='') AND ($row['type']!=5)  AND ($row['type']!=3)  AND ($row['type']!=10))  { $row[img]=$uimg[$row['type']][1]; }





	    	$wearItems[$row['id']] = $row;

		if($row['includemagic'] > 0) {
	        	$magicIds[] = $row['includemagic'];
		}
		if($row['magic'] > 0) {
	        	$magicIds[] = $row['magic'];
		}
	}


	$querys = mysql_query_cache("SELECT * FROM oldbk.magic  where id  IN (" . implode(", ", $magicIds) . ")",false,600);
	while(list($k,$row) = each($querys)) {
	    $magicItems[$row['id']] = $row;
	}

	if ($is301 !== false) {
		if ($user['sergi']) $wearItems[$user['sergi']]['img'] = $is301."sergi.gif";
		if ($user['kulon']) $wearItems[$user['kulon']]['img'] = $is301."kulon.gif";
		if ($user['perchi']) $wearItems[$user['perchi']]['img'] = $is301."per4i.gif";
		if ($user['weap']) $wearItems[$user['weap']]['img'] = $is301."weapon.gif";
		if ($user['bron']) $wearItems[$user['bron']]['img'] = $is301."armor.gif";
		if ($user['r1']) $wearItems[$user['r1']]['img'] = $is301."ring1.gif";
		if ($user['r2']) $wearItems[$user['r2']]['img'] = $is301."ring2.gif";
		if ($user['r3']) $wearItems[$user['r3']]['img'] = $is301."ring3.gif";
		if ($user['helm']) $wearItems[$user['helm']]['img'] = $is301."helm.gif";
		if ($user['shit'])  $wearItems[$user['shit']]['img'] = $is301."shield.gif";
		if ($user['boots']) $wearItems[$user['boots']]['img'] = $is301."boots.gif";
		if ($user['nakidka']) $wearItems[$user['nakidka']]['img'] = $is301."armor.gif";
		if ($user['rubashka']) $wearItems[$user['rubashka']]['img'] = $is301."armor.gif";
	}
	if ($is302 !== false) {
		if ($user['sergi']) $wearItems[$user['sergi']]['img'] = $is302."sergi.gif";
		if ($user['kulon']) $wearItems[$user['kulon']]['img'] = $is302."kulon.gif";
		if ($user['perchi']) $wearItems[$user['perchi']]['img'] = $is302."per4i.gif";
		if ($user['weap']) $wearItems[$user['weap']]['img'] = $is302."weapon.gif";
		if ($user['bron']) $wearItems[$user['bron']]['img'] = $is302."armor.gif";
		if ($user['r1']) $wearItems[$user['r1']]['img'] = $is302."ring1.gif";
		if ($user['r2']) $wearItems[$user['r2']]['img'] = $is302."ring2.gif";
		if ($user['r3']) $wearItems[$user['r3']]['img'] = $is302."ring3.gif";
		if ($user['helm']) $wearItems[$user['helm']]['img'] = $is302."helm.gif";
		if ($user['shit'])  $wearItems[$user['shit']]['img'] = $is302."shield.gif";
		if ($user['boots']) $wearItems[$user['boots']]['img'] = $is302."boots.gif";
		if ($user['nakidka']) $wearItems[$user['nakidka']]['img'] = $is302."armor.gif";
		if ($user['rubashka']) $wearItems[$user['rubashka']]['img'] = $is302."armor.gif";
	}


?>
	<CENTER>

<?
 	/// ������ ��
 	$darkbs = 0;
 	if($user['room'] > 500 && $user['room'] < 561) {
		$tr = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = TRUE"));
		if($tr['type']==2 OR $tr['type']==7 OR $tr['type']==9 OR $tr['type']==11 OR $tr['type']==14) {

			$mumu = mysql_fetch_array(mysql_query("SELECT `room` FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
			if($user['room'] != $mumu['room']) {
				$darkbs = 1;
			}
		}
	}

 	if($user['room'] > 10000 && $user['room'] < 11000) {
		$tr = mysql_fetch_array(mysql_query("SELECT * FROM `dt_map` WHERE `active` = 1"));
		if ($tr['darktype']) {
			$mumu = mysql_fetch_array(mysql_query("SELECT `room` FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
			if($user['room'] != $mumu['room']) {
				$darkbs = 1;
			}
		}
	}
	if ($darkbs) {$user['hp'] = $user['maxhp'];}
?>


<?
//fred hidden
//$hidden = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE type=200 and `owner` = '{$id}' LIMIT 1;"));

if ( strpos($user['login'],"��������� (����" ) !== FALSE )
		{
			if ($_SERVER['PHP_SELF'] == '/inf.php') {
				?> <A style="cursor:pointer;" OnClick="StrToPrivate('<?=$user['login']?>'); return false;"><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A><B><i><?=$user['login']?></i></B> [??]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a> <?
			} else {
				?> <A HREF="javascript:top.AddToPrivate('<?=$user['login']?>', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A><B><i><?=$user['login']?></i></B> [??]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a> <?
			}
		}
		else
		if ((($user['hidden'] > 0) and ($_SESSION['uid'] != $id) and ($battle)  ) )
		 {
			//�������� - ������� � ��������� ���
			if ($_SERVER['PHP_SELF'] == '/inf.php') {
				?> <A style="cursor:pointer;" OnClick="StrToPrivate('���������');return false;"><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A><B><i>���������</i></B> [??]<a href=inf.php?<?=$user['hidden']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � ���������"></a> <?
			} else {
				?> <A HREF="javascript:top.AddToPrivate('���������', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A><B><i>���������</i></B> [??]<a href=inf.php?<?=$user['hidden']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � ���������"></a> <?
			}


		if ($user['block']) {
					echo "<BR><FONT class=private>�������� ������������!</font>";
					}
		echo "<br><br>";

//fin ��������
		}
		else
		{
		//�������
			if ($_SERVER['PHP_SELF'] == '/inf.php') {
				?> <A style="cursor:pointer;" OnClick="StrToPrivate('<?=$user['login']?>'); return false;"><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A><img src="http://i.oldbk.com/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<? if (($user['level']==13) and ($user['exp']>=8000000000) ) { echo "<font color=#F03C0E><b>{$user['level']}</b></font>"; } else { echo $user['level']; } ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a> <?
			} else {
				?> <A HREF="javascript:top.AddToPrivate('<?=$user['login']?>', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A><img src="http://i.oldbk.com/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img title="'.$user['klan'].'" src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<? if (($user['level']==13) and ($user['exp']>=8000000000) ) { echo "<font color=#F03C0E><b>{$user['level']}</b></font>"; } else { echo $user['level']; } ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a> <?
			}
			if ($user['block']) {
				echo "<BR><FONT class=private>�������� ������������!</font>";
			}
			//teni fix
			if(($user['hidden'] > 0) and ($_SESSION['uid'] != $id)) {
				echo setHP($user['maxhp'],$user['maxhp'],$battle);
			} else {
				if ($user['maxmana']) {
					echo setHP($user['hp'],$user['maxhp'],$battle,1);
				} else {
					echo setHP($user['hp'],$user['maxhp'],$battle);
				}
			}
			if ($user['maxmana']) {
				echo setMP($user['mana'],$user['maxmana'],$battle,1);
			}

		if (($user['fullentime'] >0) and ($user['owner'] >0))
		{
		//���� ���������� ����� � � ���� ���� ����� ������ ������� �� ������ ��
		echo setnaemEN($user['energy'],($user['level']*5),$battle);
		}
//fin ����
		}


	$addstyle = "";
	if ($unikstatus && ($_SERVER['PHP_SELF'] == '/inf.php')) {
		echo '<div style="position:relative;z-index:50;background: url(http://i.oldbk.com/i/chat/info_icon_status2.png) no-repeat; width:196px;height:79px;"><div style="width:195px; display: table-cell;vertical-align:middle;height:57px;"><div style="display: inline-block;word-wrap: break-word; width: 190px;font-size:8pt;">'.htmlspecialchars($unikstatus,ENT_QUOTES).'</div></div></div>';
		$addstyle = 'style = "margin-top:-12px;"';
	}
	?>


	<TABLE cellspacing=0 <?=$addstyle; ?> cellpadding=0>
<?if (($user['level'] > 3) && !$pas && !$battle) {?>
<TR>
	<TD colspan=3>
	<?
    $dress = isset($wearItems[$user['m1']]) ? $wearItems[$user['m1']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m2']]) ? $wearItems[$user['m2']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m3']]) ? $wearItems[$user['m3']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m4']]) ? $wearItems[$user['m4']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m5']]) ? $wearItems[$user['m5']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

?>
	</TD>
</TR>
<TR>
	<TD colspan=3>
<?
    $dress = isset($wearItems[$user['m6']]) ? $wearItems[$user['m6']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m7']]) ? $wearItems[$user['m7']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m8']]) ? $wearItems[$user['m8']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m9']]) ? $wearItems[$user['m9']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);

	$dress = isset($wearItems[$user['m10']]) ? $wearItems[$user['m10']] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);
?>
	</TD>
</TR>
<tr>
	<td colspan="3">
<?
$repcount = (int)$user['rep']/ 20000;
if($repcount < 0) $repcount = 0;
if($repcount > 5) $repcount = 5;
for($i = 1; $i <= $repcount; $i++)
{
	$dress = isset($wearItems[$user['m1'.$i]]) ? $wearItems[$user['m1'.$i]] : null;
	showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);
}

?>
	</td>
</tr>

<?php
if ($user['prem'] > 0 && $user['in_tower'] == 0) {
	echo '<tr><td>';
	for ($i = 16; $i <= getMaximumSlot($user['prem']); $i++) {
		$dress = isset($wearItems[$user['m'.$i]]) ? $wearItems[$user['m'.$i]] : null;
		showScrollSlot($dress, $dress != null && isset($magicItems[$dress['magic']]) ? $magicItems[$dress['magic']] : null);
	}
	echo '</td></tr>';
}

?>

<?}?>
<TR>
	<TD valign=top>
	<?
//in battle - hidden items -fred
if((($user['hidden'] > 0) && $battle && $_SESSION['uid'] != $id ) ||  strpos($user['login'],"��������� (����" ) !== FALSE  ) {
    echo " <img src='http://i.oldbk.com/i/shadow/mhidden_full.gif' title='���������' alt='���������'><br /></table> ";
}
elseif(($_SESSION['uid'] != $id ) and (strpos($user['shadow'],"chaos_bot" ) !== false || strpos($user['shadow'],"ruine_botskelet" ) !== false)) {
    echo " <img src='http://i.oldbk.com/i/shadow/".$user['shadow']."' title='".$user['login']."' alt='".$user['login']."'><br /></table> ";
}
else {
//-->

?>
<TABLE width=196 cellspacing=0 cellpadding=0 ><tr><td valign=top>
<TABLE width=100% cellspacing=0 cellpadding=0>
	<TR><TD <?=(((($wearItems[$user['sergi']]['maxdur']-2)<=$wearItems[$user['sergi']]['duration'] && $wearItems[$user['sergi']]['duration'] > 2 && (!$pas OR ($battle AND $me)))?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":""))?>>
<?php
		if ($user['sergi'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['sergi']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {

				$ehtml=render_img_html($dress);



				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������� �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������� �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
				echo '<a href="?edit=1&filt=1"><img src="http://i.oldbk.com/i/w1.gif" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\'������ ���� ������\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w1.gif" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\'������ ���� ������\')">';
			}
		}
	?></a></TD></TR>
	<TR><TD <?=(((($wearItems[$user['kulon']]['maxdur']-2)<=$wearItems[$user['kulon']]['duration'] && $wearItems[$user['kulon']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?> ><?php
		if ($user['kulon'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['kulon']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
//				$ehtml=str_replace('.gif','.html',$dress['img_url']);
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� �������� �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� �������� �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=2"><img src="http://i.oldbk.com/i/w2.gif" width=60 height=20 onMouseOut="HideThing(this)"  onMouseOver="ShowThing(this,55,15,\'������ ���� ��������\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w2.gif" width=60 height=20 onMouseOut="HideThing(this)"  onMouseOver="ShowThing(this,55,15,\'������ ���� ��������\')">';
			}
		}
	?></A></TD></TR>
	<TR><TD <?=(((($wearItems[$user['weap']]['maxdur']-2)<=$wearItems[$user['weap']]['duration'] && $wearItems[$user['weap']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?> >
	<?php
		if ($user['weap'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['weap']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			}
			else
			{
				$ehtml=render_img_html($dress);
				$dress['text']=str_replace("&#39;", "\&#39;", $dress['text']);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur'].(($dress['minu']>0)?"  <br>���� {$dress['minu']}-{$dress['maxu']}":"")."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br> �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur'].(($dress['minu']>0)?"  <br>���� {$dress['minu']}-{$dress['maxu']}":"")." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br> �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=3"><img src="http://i.oldbk.com/i/w3.gif" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'������ ���� ������\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w3.gif" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'������ ���� ������\')">';
			}
		}
	?></A></TD></TR>
	<TR><TD <?=(((($wearItems[$user['rubashka']]['maxdur']-2)<=$wearItems[$user['rubashka']]['duration'] && $wearItems[$user['rubashka']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>
		<?=(((($wearItems[$user['bron']]['maxdur']-2)<=$wearItems[$user['bron']]['duration'] && $wearItems[$user['bron']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>
	        <?=(((($wearItems[$user['nakidka']]['maxdur']-2)<=$wearItems[$user['nakidka']]['duration'] && $wearItems[$user['nakidka']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>
	><?php
	//������ ��� ���� ����� , �� �� � ���������!!
		if ( ( ($user['rubashka'] == 0) and ($user['bron'] == 0) and ($user['nakidka'] > 0) ) and  (!$darkbs))
		{
		// ������ ������� (��� �������)
			$dress = $wearItems[$user['nakidka']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":"").' src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":"").' src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'\')" >';
				}
			}
		}
		elseif ((($user['rubashka'] == 0) and ($user['bron'] > 0) and ($user['nakidka'] > 0) ) and  (!$darkbs))
		{
		// ����� � ������� (��� �������)
			$dress = $wearItems[$user['nakidka']];
			$dress2 = $wearItems[$user['bron']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me)))
			{
			//1�������� � �������
			   if ($dress2['includemagicdex']&& (!$pas OR ($battle AND $me)))
			   	{
			   	//3. �������� � � �����
				 showMagicHref3($dress,$dress2, $magicItems[$dress['includemagic']]);
				} else
				{
				//4. �������� ������ � ������� � ����� ����
				showMagicHref4($dress, $dress2,$magicItems[$dress['includemagic']]);
				}
			} else {
			//2��� �������� � �������
			   if ($dress2['includemagicdex']&& (!$pas OR ($battle AND $me)))
			   {
   			   //5. �������� � ����� , �� � �������
			   	showMagicHref2($dress, $dress2,$magicItems[$dress2['includemagic']]);
			   }
			   else
			   {

			   //6. ��� �������� �� � ������� � �� � �����
				$ehtml=render_img_html($dress);

				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td></tr></table>\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']." ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td></tr></table>\')" >';
				}
			  }
			}


		}
		elseif ( (($user['rubashka'] == 0) and ($user['bron'] > 0) and ($user['nakidka']==0)) and  (!$darkbs))
		{
		// ������ ����� (��� �������)
			$dress = $wearItems[$user['bron']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'\')" >';
				}
			}
		}
		elseif ( ( ($user['rubashka'] >0) and ($user['bron'] == 0) and ($user['nakidka'] > 0) ) and  (!$darkbs))
		{
		// ������ ������� + �������
			$dress = $wearItems[$user['nakidka']];
			$dress2 = $wearItems[$user['rubashka']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me)))
			{

			   if ($dress2['includemagicdex']&& (!$pas OR ($battle AND $me)))
			   	{

				 showMagicHref3($dress,$dress2, $magicItems[$dress['includemagic']]);
				} else
				{

				showMagicHref4($dress, $dress2,$magicItems[$dress['includemagic']]);
				}
			} else {

			   if ($dress2['includemagicdex']&& (!$pas OR ($battle AND $me)))
			   {

			   	showMagicHref2($dress, $dress2,$magicItems[$dress2['includemagic']]);
			   }
			   else
			   {

			   //6. ��� �������� �� � ������� � �� � �����
				$ehtml=render_img_html($dress);

				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td></tr></table>\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']." ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td></tr></table>\')" >';
				}
			   }
			}


		}
		elseif ( (($user['rubashka'] > 0 ) and ($user['bron'] > 0) and ($user['nakidka']==0)) and  (!$darkbs))
		{
		// ������ ����� + �������
			$dress = $wearItems[$user['bron']];
			$dress2 = $wearItems[$user['rubashka']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me)))
			{

			   if ($dress2['includemagicdex']&& (!$pas OR ($battle AND $me)))
			   	{
				 showMagicHref3($dress2,$dress, $magicItems[$dress['includemagic']]);
				} else
				{

				showMagicHref4($dress, $dress2,$magicItems[$dress['includemagic']]);
				}
			} else {

			   if ($dress2['includemagicdex']&& (!$pas OR ($battle AND $me)))
			   {

			   	showMagicHref2($dress, $dress2,$magicItems[$dress2['includemagic']]);
			   }
			   else
			   {

			   //6. ��� �������� �� � ������� � �� � �����
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td></tr></table>\')" >';
			   	}
			   	else
			   	{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']." ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td></tr></table>\')" >';
			   	}
			   }
			}


		}
		elseif ( (($user['rubashka'] > 0 ) and ($user['bron'] > 0) and ($user['nakidka'] > 0)) and  (!$darkbs))
		{
		// ������ ������� + ����� +�������
			$dress = $wearItems[$user['nakidka']];
			$dress2 = $wearItems[$user['bron']];
			$dress3 = $wearItems[$user['rubashka']];
			if ( ( ($dress['includemagicdex']) OR ($dress2['includemagicdex']) OR ($dress3['includemagicdex'])  )  && (!$pas OR ($battle AND $me)))
			{
			 showMagicHref21($dress,$dress2,$dress3,$magicItems[$dress['includemagic']],$magicItems[$dress2['includemagic']],$magicItems3[$dress['includemagic']] );
			}
		   	else
			   {
			   //6. ��� �������� �����
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']."<br>��������� ��: ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['gsila']!=0)?"<br>� ����:{$dress2['gsila']}":"")." ".(($dress2['glovk']!=0)?"<br>� ��������:{$dress2['glovk']}":"")." ".(($dress2['ginta']!=0)?"<br>� ��������:{$dress2['ginta']}":"")." ".(($dress2['gintel']!=0)?"<br>� ���������:{$dress2['gintel']}":"")." ".(($dress2['gmp']!=0)?"<br>� ��������:{$dress2['gmp']}":"")." ".(($dress2['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress2['mfkrit']}%":"")." ".(($dress2['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress2['mfakrit']}%":"")." ".(($dress2['mfuvorot']!=0)?"<br>� ��. ������������:{$dress2['mfuvorot']}%":"")." ".(($dress2['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress2['mfauvorot']}%":"")." ".(($dress2['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress2['gnoj']}":"")." ".(($dress2['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress2['gtopor']}":"")." ".(($dress2['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress2['gdubina']}":"")." ".(($dress2['gmech']!=0)?"<br>� �������� ������:+{$dress2['gmech']}":"")." ".(($dress2['gfire']!=0)?"<br>� �������� ������ ����:+{$dress2['gfire']}":"")." ".(($dress2['gwater']!=0)?"<br>� �������� ������ ����:+{$dress2['gwater']}":"")." ".(($dress2['gair']!=0)?"<br>� �������� ������ �������:+{$dress2['gair']}":"")." ".(($dress2['gearth']!=0)?"<br>� �������� ������ �����:+{$dress2['gearth']}":"")." ".(($dress2['glight']!=0)?"<br>� �������� ����� �����:+{$dress2['glight']}":"")." ".(($dress2['ggray']!=0)?"<br>� �������� ����� �����:+{$dress2['ggray']}":"")." ".(($dress2['gdark']!=0)?"<br>� �������� ����� ����:+{$dress2['gdark']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress3['img'].' width=60 height=80><br><b>'.$dress3['name']."</b><br>��������� ".$dress3['duration']."/".$dress3['maxdur']."<br>��������� ��: ".(($dress3['ghp']>0)?"<br>������� ����� +{$dress3['ghp']}":"")." ".(($dress3['gsila']!=0)?"<br>� ����:{$dress3['gsila']}":"")." ".(($dress3['glovk']!=0)?"<br>� ��������:{$dress3['glovk']}":"")." ".(($dress3['ginta']!=0)?"<br>� ��������:{$dress3['ginta']}":"")." ".(($dress3['gintel']!=0)?"<br>� ���������:{$dress3['gintel']}":"")." ".(($dress3['gmp']!=0)?"<br>� ��������:{$dress3['gmp']}":"")." ".(($dress3['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress3['mfkrit']}%":"")." ".(($dress3['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress3['mfakrit']}%":"")." ".(($dress3['mfuvorot']!=0)?"<br>� ��. ������������:{$dress3['mfuvorot']}%":"")." ".(($dress3['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress3['mfauvorot']}%":"")." ".(($dress3['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress3['gnoj']}":"")." ".(($dress3['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress3['gtopor']}":"")." ".(($dress3['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress3['gdubina']}":"")." ".(($dress3['gmech']!=0)?"<br>� �������� ������:+{$dress3['gmech']}":"")." ".(($dress3['gfire']!=0)?"<br>� �������� ������ ����:+{$dress3['gfire']}":"")." ".(($dress3['gwater']!=0)?"<br>� �������� ������ ����:+{$dress3['gwater']}":"")." ".(($dress3['gair']!=0)?"<br>� �������� ������ �������:+{$dress3['gair']}":"")." ".(($dress3['gearth']!=0)?"<br>� �������� ������ �����:+{$dress3['gearth']}":"")." ".(($dress3['glight']!=0)?"<br>� �������� ����� �����:+{$dress3['glight']}":"")." ".(($dress3['ggray']!=0)?"<br>� �������� ����� �����:+{$dress3['ggray']}":"")." ".(($dress3['gdark']!=0)?"<br>� �������� ����� ����:+{$dress3['gdark']}":"")." ".(($dress3['bron1']!=0)?"<br>� ����� ������:{$dress3['bron1']}":"")." ".(($dress3['bron2']!=0)?"<br>� ����� �������:{$dress3['bron2']}":"")." ".(($dress3['bron3']!=0)?"<br>� ����� �����:{$dress3['bron3']}":"")." ".(($dress3['bron4']!=0)?"<br>� ����� ���:{$dress3['bron4']}":"")." ".(($dress3['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress3['text']!=null)?"<br>  �� ������ ������: {$dress3['text']}":"").'</span></td></tr></table>\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress['img'].' width=60 height=80><br><b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress2['img'].' width=60 height=80><br><b>'.$dress2['name']."</b><br>��������� ".$dress2['duration']."/".$dress2['maxdur']." ".(($dress2['ghp']>0)?"<br>������� ����� +{$dress2['ghp']}":"")." ".(($dress2['bron1']!=0)?"<br>� ����� ������:{$dress2['bron1']}":"")." ".(($dress2['bron2']!=0)?"<br>� ����� �������:{$dress2['bron2']}":"")." ".(($dress2['bron3']!=0)?"<br>� ����� �����:{$dress2['bron3']}":"")." ".(($dress2['bron4']!=0)?"<br>� ����� ���:{$dress2['bron4']}":"")." ".(($dress2['text']!=null)?"<br>  �� ������ ������ '{$dress2['text']}'":"").'</span></td><td><span  style=font-size:9px><img src=http://i.oldbk.com/i/sh/'.$dress3['img'].' width=60 height=80><br><b>'.$dress3['name']."</b><br>��������� ".$dress3['duration']."/".$dress3['maxdur']." ".(($dress3['ghp']>0)?"<br>������� ����� +{$dress3['ghp']}":"")." ".(($dress3['bron1']!=0)?"<br>� ����� ������:{$dress3['bron1']}":"")." ".(($dress3['bron2']!=0)?"<br>� ����� �������:{$dress3['bron2']}":"")." ".(($dress3['bron3']!=0)?"<br>� ����� �����:{$dress3['bron3']}":"")." ".(($dress3['bron4']!=0)?"<br>� ����� ���:{$dress3['bron4']}":"")." ".(($dress3['text']!=null)?"<br>  �� ������ ������: {$dress3['text']}":"").'</span></td></tr></table>\')" >';
				}
			 }

		}
		else
		if ( ( ($user['rubashka'] > 0) and ($user['bron'] == 0) and ($user['nakidka'] == 0) ) and  (!$darkbs))
		{
		// ������ �������
			$dress = $wearItems[$user['rubashka']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":"").' src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  '.((($dress['maxdur']-2)<=$dress['duration'] && $dress['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":"").' src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ ������: {$dress['text']}":"").'\')" >';
				}
			}
		}
		else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=4"><img src="http://i.oldbk.com/i/w4.gif" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'������ ���� �����\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w4.gif" width=60 height=80 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\'������ ���� �����\')">';
			}
		}
	?></a></TD></TR>
	<TR><TD><TABLE cellspacing=0 cellpadding=0><tr>
		<td <?=(((($wearItems[$user['r1']]['maxdur']-2)<=$wearItems[$user['r1']]['duration'] && $wearItems[$user['r1']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>><?php
		if ($user['r1'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['r1']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=5"><img src="http://i.oldbk.com/i/w6.gif" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'������ ���� ������\')" ></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w6.gif" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'������ ���� ������\')" >';
			}
		}
	?></A></td>
		<td <?=(((($wearItems[$user['r2']]['maxdur']-2)<=$wearItems[$user['r2']]['duration'] && $wearItems[$user['r2']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>><?php
		if ($user['r2'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['r2']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=5"><img src="http://i.oldbk.com/i/w6.gif" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'������ ���� ������\')" ></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w6.gif" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'������ ���� ������\')" >';
			}
		}
	?></A></td>
		<td <?=(((($wearItems[$user['r3']]['maxdur']-2)<=$wearItems[$user['r3']]['duration'] && $wearItems[$user['r3']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>><?php
		if ($user['r3'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['r3']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ������ �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=5"><img src="http://i.oldbk.com/i/w6.gif" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'������ ���� ������\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w6.gif" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\'������ ���� ������\')">';
			}
		}
	?></A></td></tr></table>
</TD></TR>
</TABLE>
	</TD>
		<TD valign=top>
		<?
			$printData  = "";
			$travmaData = "";
			$chaosData  = "";
			$zaklyatie ="";
			$obraz=$user['shadow'];

			reset($effarray);
			while(list($k,$row) = each($effarray))
			{
				if ($row['time'] < time()) {
					$row['time'] = time();
				}
				$prettyTime = prettyTime(null, $row['time']);
				if ($row['type'] == 11 || $row['type'] == 12 || $row['type'] == 13 || $row['type'] == 14) {
				    if(empty($travmaData))
				    	{
		                		switch($row['type']) {
						    	case 14: $trt = "�����������"; break;
							case 13: $trt = "�������"; break;
							case 12: $trt = "�������"; break;
							case 11: $trt = "������"; break;
							default: $trt = ""; break;
						}
						if(!empty($trt))
						{
					           	$travmaData = "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/travma.gif\" width=40></TD><TD><SMALL>� ��������� $trt ������.</SMALL></TD></TR>";
					            	if ($trt=='�����������')
							{
								$travmaData = "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/travma.gif\" width=40></TD><TD><SMALL>� ��������� $trt ������, ��� ".$prettyTime."</SMALL></TD></TR>";
							}
						}
					}
					if ($row['sila']) {
  					    $printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - �������� �������� \"����\", ��� ".$prettyTime."</SMALL></TD></TR>";
					}
					if ($row['lovk']) {
     					$printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - �������� �������� \"��������\", ��� ".$prettyTime."</SMALL></TD></TR>";
					}
					if ($row['inta']) {
					    $printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/travma.gif\" width=40></TD><TD><SMALL>\"{$row['name']}\" - �������� �������� \"��������\", ��� ".$prettyTime."</SMALL></TD></TR>";
					}
				}

				if ($row['type'] == 101050) {
					$printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/travma.gif\" width=40></TD><TD><SMALL>�������������� ����� ��� ���������: +75 ����, �������� � �������� ��� ".$prettyTime."</SMALL></TD></TR>";
				}


				if ((floor(($row['time']-time())/60/60) > 100 ) and ($row['type'] == 10) )
				 {
				 	$printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/chains.gif\" width=40></TD><TD><SMALL>����� � ������ � �� ����� �������������</SMALL></TD></TR>";
				 }
				else
				if ($row['type'] == 10) {
					$printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/chains.gif\" width=40></TD><TD><SMALL>�� ��������� �������� ����. �� ����� ��������� ��� ".$prettyTime."</SMALL></TD></TR>";
				}

				if ($row['type'] == 2)
				{
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/sleep.gif\" width=40></TD><TD><SMALL>\"��������\", ��� ".$prettyTime."</SMALL></TD></TR>";
				}
				if ($row['type'] == 150) {
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/sh/wrath_ares.gif\" width=40></TD><TD><SMALL>\"���� �����\", ��� ".$prettyTime."</SMALL></TD></TR>";
				}
				if ($row['type'] == 130) {
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/wrath_air_status.gif\" width=40></TD><TD><SMALL>\"��� �������\", ��� ".$prettyTime."</SMALL></TD></TR>";
				}
				if ($row['type'] == 920) {
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/wrath_ground_status.gif\" width=40></TD><TD><SMALL>\"����� ������\", ��� ".$prettyTime."</SMALL></TD></TR>";
				}
				if ($row['type'] == 930) {
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/wrath_water_status.gif\" width=40></TD><TD><SMALL>\"���� �����\", ��� ".$prettyTime."</SMALL></TD></TR>";
				}


				if ($row['type'] == 3052)
				{
					$zaklyatie .= "<TR><TD><a href='http://oldbk.com/encicl/?/eda/dinner_dragon1.html' target=_blank><IMG height=25 src=\"http://i.oldbk.com/i/sh/dinner_dragon1.gif\" width=40></a></TD><TD><SMALL>���: \"����� ���� �������\"</SMALL></TD></TR>";
				}

				if ($row['type'] == 3053)
				{
					$zaklyatie .= "<TR><TD><a href='http://oldbk.com/encicl/?/eda/dinner_dragon2.html' target=_blank><IMG height=25 src=\"http://i.oldbk.com/i/sh/dinner_dragon2.gif\" width=40></a></TD><TD><SMALL>���: \"������� ���� �������\"</SMALL></TD></TR>";
				}

				if ($row['type'] == 3054)
				{
					$zaklyatie .= "<TR><TD><a href='http://oldbk.com/encicl/?/eda/dinner_viking1.html' target=_blank><IMG height=25 src=\"http://i.oldbk.com/i/sh/dinner_viking1.gif\" width=40></a></TD><TD><SMALL>���: \"����� ���� �������\"</SMALL></TD></TR>";
				}

				if ($row['type'] == 3055)
				{
					$zaklyatie .= "<TR><TD><a href='http://oldbk.com/encicl/?/eda/dinner_viking2.html' target=_blank><IMG height=25 src=\"http://i.oldbk.com/i/sh/dinner_viking1.gif\" width=40></a></TD><TD><SMALL>���: \"������� ���� �������\"</SMALL></TD></TR>";
				}

				if ($row['type'] == 3) {
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/sleepf.gif\" width=40></TD><TD><SMALL>\"�������� ��������\", ��� ".$prettyTime."</SMALL></TD></TR>";
				}

				if ($row['type'] == 33) {
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/snezhok.gif\" width=40></TD><TD><SMALL>\"�����������\", ��� ".$prettyTime."</SMALL></TD></TR>";
				}

				if (($row['type']==1001) OR ($row['type']==1002) OR ($row['type']==1003) )
				   {
					$ef1001img="http://i.oldbk.com/i/magic/bonus2.gif";
					$efexp='';
									if ($row['add_info']!='')
									{
									$ef1001img="http://i.oldbk.com/i/magic/vduh.gif";
									$elnis='<a href="http://oldbk.com/encicl/?/act_duh_spring.html" target=_blank>';
									$elnif='</a>';
									$efexp=', ����: <b>+'.round($row['add_info']*100).'%</b>';
									}
				 $zaklyatie .= "<TR><TD>".$elnis."<IMG height=25 src=\"".$ef1001img."\" width=40>".$elnif."</TD><TD><SMALL>\"".$row['name']."\":(+".$user[bpbonushp]."HP) ".$efexp." , ��� ".$prettyTime."</SMALL></TD></TR>";
				   }

//FRED new

				if ($row['type']==667) {
				$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/ruin_stoikost2.gif\" width=40></TD><TD><SMALL>\"".$row['name']."\":(���� +10%) , ��� ".$prettyTime."</SMALL></TD></TR>";
							}


				if ($row['type']==9898 && ($_SESSION['uid'] == 8540 || $_SESSION['uid'] == 7937 || $_SESSION['uid'] == 102904 || $_SESSION['uid'] == 326)) {
					require_once "GeoIP/geoip.inc";
					require_once "GeoIP/geoipregionvars.php";
					$gi = geoip_open("GeoIP/GeoIP.dat",GEOIP_STANDARD);
					$cname = "";
					while(list($k,$v) = each($gi->GEOIP_COUNTRY_CODES)) {
						if ($v == $row['add_info']) {
							$cname = $gi->GEOIP_COUNTRY_NAMES[$k];
						}
					}

					$printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/prisonipgif.gif\" width=40></TD><TD><SMALL>������: ".$cname." </SMALL></TD></TR>";
					geoip_close($gi);
				}

				if ($row['type']==9899 && ($_SESSION['uid'] == 8540 || $_SESSION['uid'] == 7937 || $_SESSION['uid'] == 102904 || $_SESSION['uid'] == 326)) {
					require_once "GeoIP/geoip.inc";
					require_once "GeoIP/geoipregionvars.php";
					$gi = geoip_open("GeoIP/GeoIP.dat",GEOIP_STANDARD);
					$cname = "";
					while(list($k,$v) = each($gi->GEOIP_COUNTRY_CODES)) {
						if ($v == $row['add_info']) {
							$cname = $gi->GEOIP_COUNTRY_NAMES[$k];
						}
					}

					$printData .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/prisonipgif.gif\" width=40></TD><TD><SMALL>�� �� ������: ".$cname." </SMALL></TD></TR>";
					geoip_close($gi);
				}



				if ($row['type']==555) {
				$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/sh/no_cure3_2.gif\" width=40></TD><TD><SMALL>\"".$row['name']."\", ��� ".$prettyTime."</SMALL></TD></TR>";
							}

				if ($row['type']==656) {

				$add_info=explode("::",$row['add_info']);
				$hiimg='http://i.oldbk.com/i/sh/'.$add_info[1];

				$zaklyatie .= "<TR><TD><IMG height=25 src=\"{$hiimg}\" width=40></TD><TD><SMALL>".$row['name'].", ��� ".$prettyTime."</SMALL></TD></TR>";
							}

				if ($row['type']==556) {
					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/no_cure2.gif\" width=40></TD><TD><SMALL>\"".$row['name']."\"</SMALL></TD></TR>";
							}


				if ($row['type']==557) {

				if ($row['add_info']==0.7)
					{
					$pica='http://i.oldbk.com/i/sh/scroll_antimagic1_2.gif';
					}
				elseif ($row['add_info']==0.5)
					{
					$pica='http://i.oldbk.com/i/sh/scroll_antimagic2_2.gif';
					}
				elseif ($row['add_info']==0.3)
					{
					$pica='http://i.oldbk.com/i/sh/scroll_antimagic3_2.gif';
					}
				elseif ($row['add_info']==0.85)
					{
					$pica='http://i.oldbk.com/i/sh/scroll_antimagic0_2.gif';
					}
					else
					{
					$pica='http://i.oldbk.com/i/magic/no_cure2.gif';
					}


				$zaklyatie .= "<TR><TD><IMG height=25 src=\"{$pica}\" width=40></TD><TD><SMALL>\"".$row['name']."\", ��� ".$prettyTime."</SMALL></TD></TR>";
							}

				if ($row['type']==2000)
				{
					$LIC_NAIM=$row['time'];
				}

				if ($row['type']==30000)
				{
					$LIC_TORG=$row['time'];
				}

				if ($row['type']==40000)
				{
					$LIC_LEK=$row['time'];
				}

				if ($row['type']==50000)
				{
					$LIC_MAG=$row['time'];
				}




				if ($row['type'] == 200 && $_SESSION['uid'] == $id)
				{
				$zaklyatie .= "<TR><TD><IMG height=25 src=\"i/magic/hidden.gif\" width=40></TD><TD><SMALL>\"�������\", ��� ".$prettyTime;

				if ($_SERVER['PHP_SELF']=='/main.php')
					{
					$zaklyatie .= "<a href='?hiddenoff=1'>�������� �������</a>";
					}
					$zaklyatie .= "</SMALL></TD></TR>";
				}

		                if($row[type]==300)
		                {
		                   $obraz=$row[add_info];
		                }

				if($row['type'] == 4) {
			            $time_still = $row['time'] - time();
			            $tmp = floor($time_still/2592000);
		                $i = 0;
		                if ($tmp > 0) {
			                $i++;
			                if ($i < 3) {
							    $out .= $tmp." ���. ";
							}
			                $time_still = $time_still-$tmp*2592000;
		                }
		                $tmp = floor($time_still/604800);
		                if ($tmp > 0) {
			                $i++;
			                if ($i<3) {$out .= $tmp." ���. ";}
			                $time_still = $time_still-$tmp*604800;
		                }
		                $tmp = floor($time_still/86400);
		                if ($tmp > 0) {
			                $i++;
			                if ($i<3) {$out .= $tmp." ��. ";}
			                $time_still = $time_still-$tmp*86400;
		                }
		                $tmp = floor($time_still/3600);
		                if ($tmp > 0) {
			                $i++;
			                if ($i<3) {$out .= $tmp." �. ";}
			                $time_still = $time_still-$tmp*3600;
		                }
		                $tmp = floor($time_still/60);
		                if ($tmp > 0) {
			                $i++;
			                if ($i < 3) {$out .= $tmp." ���. ";}
		                }
			            $chaosData = "<br>���� ��� <i>$out</i>";
				}


				//������ ������
				if ($row['type'] >= 22223 && $row['type']<=22228) {

					$zaklyatie .= "<TR><TD><IMG height=25 src=\"http://i.oldbk.com/i/magic/1april_item_".$row[type].".gif\" width=40></TD><TD><SMALL>\"".$row[name]."\"</SMALL></TD></TR>";
				}
			}

			if ($zaklyatie!='')
				{
				$printData .='<TR><TD colspan="2" align="center"><small><b>��� ������������ ��������:</b></small></TD></TR>';
				$printData .=$zaklyatie;
				}


		if (date("n") == 2 && (date("j") == 23 || date("j") == 24))
		{
            		$myeff=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$_SESSION['uid']." AND `type`=4998 LIMIT 1;"));
				/*  23 ������� */
			if($myeff[id]>0 && $user[sex]==0)
			{
				$obraz='23feb2013_'.(mt_rand(1,16)).'.gif';
               		}
		}
		elseif (date("n") == 3 && (date("j") == 8 || date("j") == 9))	{
            		$myeff=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$_SESSION['uid']." AND `type`=4998 LIMIT 1;"));
				/* 8 �����,  */
			if($myeff[id]>0 && $user[sex]==1)
			{
				$obraz='8mar2013_'.(mt_rand(1,16)).'.gif';
               		}
		}




		/*������ ������*/ //2015
		/*
		if((time()>=mktime(0,0,0,4,1) && time() < mktime(23,59,59,4,1) && $_SESSION['uid']))
		{
			$iObraz=mt_rand(1,25);
			if(strlen($iObraz)==1)
			{
				$iObraz='0'.$iObraz;
			}

			if($user[sex]==1)
			{
				$obraz='01april_m'.$iObraz.'.gif';
			}
			else
			{
				$obraz='01april_f'.$iObraz.'.gif';
			}
		}
		*/
            $sh_href='';
            $sh_href2='';
            if($user[prem]>0)
            {
            	$data=mysql_query('select * from users_shadows where type=3 AND sex='.$user[sex].';');
            	while($row=mysql_fetch_assoc($data))
            	{
                  if(strpos($obraz,$row[name])!== FALSE)
					 {
						//echo 'qwe';
						$sh_href ='<a href="http://www.oldbk.com/encicl/obrazy/silver/'.($user[sex]==1?'male':'female').'/'.$row[name].'.html"  target=_blank>';
						$sh_href2='</a>';
				     }
            	}
            }

	    if ($is301 !== false) {
			$obraz = $is301."obraz.gif";
	    }
	    if ($is302 !== false) {
			$obraz = $is302."obraz.gif";
	    }


		?>


		<?=$sh_href?><img src="http://i.oldbk.com/i/shadow/<?=$obraz?>" width=76 height=209 alt="<?=$user['login']?>"><?=$sh_href2?>

	</TD>
<TD width=62 valign=top>
	<!--</TD><TD valign=top><img src="http://i.oldbk.com/i/shadow/1a<? $fuck = array('f','m'); echo $fuck[$user['sex']]; ?><?=rand(1,10)?>.gif" width=76 height=209 alt="<?=$user['login']?>"></TD><TD width=62 valign=top>>-->
<TABLE width=100% cellspacing=0 cellpadding=0>
	<TR><TD <?=(((($wearItems[$user['helm']]['maxdur']-2)<=$wearItems[$user['helm']]['duration'] && $wearItems[$user['helm']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>><?php
		if ($user['helm'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['helm']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);

     				if ($admin==1)
     				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ����� �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ����� �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=8"><img src="http://i.oldbk.com/i/w9.gif" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'������ ���� ����\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w9.gif" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'������ ���� ����\')">';
			}
		}
	?></A></TD></TR>
	<TR><TD <?=(((($wearItems[$user['perchi']]['maxdur']-2)<=$wearItems[$user['perchi']]['duration'] && $wearItems[$user['perchi']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>><?php
		if ($user['perchi'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['perchi']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ��������� �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ��������� �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=9"><img src="http://i.oldbk.com/i/w11.gif" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'������ ���� ��������\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w11.gif" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'������ ���� ��������\')">';
			}
		}
	?></A></TD></TR>
	<TR><TD <?=(((($wearItems[$user['shit']]['maxdur']-2)<=$wearItems[$user['shit']]['duration'] && $wearItems[$user['shit']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>><?php
		if ($user['shit'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['shit']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=10"><img src="http://i.oldbk.com/i/w10.gif" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'������ ���� ���\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w10.gif" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'������ ���� ���\')">';
			}
		}
	?></A></TD></TR>
	<TR><TD <?=(((($wearItems[$user['boots']]['maxdur']-2)<=$wearItems[$user['boots']]['duration'] && $wearItems[$user['boots']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>><?php
		if ($user['boots'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['boots']];
			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me))) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				if ($admin==1)
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['unik']!=0)?"<br><font color=red>� ���������� ����</font>":"")." ".(($dress['text']!=null)?"<br>  �� �������� �������������: {$dress['text']}":"").'\')" >';
				}
				else
				{
				echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img  src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'<b>'.$dress['name']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� �������� �������������: {$dress['text']}":"").'\')" >';
				}
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=11"><img src="http://i.oldbk.com/i/w12.gif" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'������ ���� �����\')"></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/w12.gif" width=60 height=40 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\'������ ���� �����\')">';
			}
		}

         //onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\'������ ���� ����\')">

	?></A></TD></TR>

</TABLE></td></tr></table>
</TD></TR>
</TABLE>

<?
//if (($user['id']==14897 ) OR ($user['id']==102904 ) OR ($user['id']==457757 ) OR ($user['id']==326 ) OR ($user['id']==8540 )  )
 {
?>
<TABLE cellspacing=0 cellpadding=0 border=0 style="background-image: url('http://i.oldbk.com/i/runes_slots.jpg'); background-position: center bottom; background-repeat: no-repeat;"><tr>
		<td width=59 height=48 align=right  <?=(((($wearItems[$user['runa1']]['maxdur']-2)<=$wearItems[$user['runa1']]['duration'] && $wearItems[$user['runa1']]['duration'] > 2 && $pas==true )?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":""))?>><?php
$r=0;
		if ($user['runa1'] > 0 && !$darkbs)
		{
			$dress = $wearItems[$user['runa1']];

			if (($dress['type'] == 30) and ($admin) ) // ������� �� ���� �������
				{
				// ����������  ��� ���� ���� ������
					if ($dress['ups'] >= $dress['add_time'])
					{
					$mig=explode(".",$dress['img']);
					$dress['img']=$mig[0]."_up.".$mig[1];
					}
				}

			if ($dress['includemagicdex']&& (!$pas OR ($battle AND $me)))	{
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				 if ($admin==1)
				 {
				 echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'<b>'.$dress['name']."</b><br>�������:<b>".$dress['up_level']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\','.$r.')" >';
				 }
				 else
				 {
				 echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'<b>'.$dress['name']."</b><br>�������:<b>".$dress['up_level']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\','.$r.')" >';
				 }
			}
		} else
		{
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=31"><img src="http://i.oldbk.com/i/none.gif" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,30,30,\'������ ���� ����\','.$r.')" ></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/none.gif" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,30,30,\'������ ���� ����\','.$r.')" >';
			}
		}
?></A></td>
		<td width=74 height=48 align=center <?=(((($wearItems[$user['runa2']]['maxdur']-2)<=$wearItems[$user['runa2']]['duration'] && $wearItems[$user['runa2']]['duration'] > 2 && $pas==true )?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":""))?>><?php
		if ($user['runa2'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['runa2']];

			if (($dress['type'] == 30) and ($admin) ) // ������� �� ���� �������
				{
				// ����������  ��� ���� ���� ������
					if ($dress['ups'] >= $dress['add_time'])
					{
					$mig=explode(".",$dress['img']);
					$dress['img']=$mig[0]."_up.".$mig[1];
					}
				}


			if (($dress['includemagicdex'] > 0) && ($pas==true)) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				 if ($admin==1)
				 {
				 echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'<b>'.$dress['name']."</b><br>�������:<b>".$dress['up_level']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\','.$r.')" >';
				 }
				 else
				 {
				 echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'<b>'.$dress['name']."</b><br>�������:<b>".$dress['up_level']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\','.$r.')" >';
				 }
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=31"><img src="http://i.oldbk.com/i/none.gif" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'������ ���� ����\','.$r.')" ></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/none.gif" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'������ ���� ����\','.$r.')" >';
			}
		}
	?></A></td>
		<td width=57 height=48 align=left  <?=(((($wearItems[$user['runa3']]['maxdur']-2)<=$wearItems[$user['runa3']]['duration'] && $wearItems[$user['runa3']]['duration'] > 2 && $pas==true )?" style='background-image:url(http://i.oldbk.com/i/blink.gif);' ":""))?>><?php
		if ($user['runa3'] > 0 && !$darkbs) {
			$dress = $wearItems[$user['runa3']];

			if (($dress['type'] == 30) and ($admin) ) // ������� �� ���� �������
				{
				// ����������  ��� ���� ���� ������
					if ($dress['ups'] >= $dress['add_time'])
					{
					$mig=explode(".",$dress['img']);
					$dress['img']=$mig[0]."_up.".$mig[1];
					}
				}


			if (($dress['includemagicdex'] > 0) && ($pas==true)) {
				showMagicHref($dress, $magicItems[$dress['includemagic']]);
			} else {
				$ehtml=render_img_html($dress);
				 if ($admin==1)
				 {
				 echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'<b>'.$dress['name']."</b><br>�������:<b>".$dress['up_level']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']."<br>��������� ��: ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['gsila']!=0)?"<br>� ����:{$dress['gsila']}":"")." ".(($dress['glovk']!=0)?"<br>� ��������:{$dress['glovk']}":"")." ".(($dress['ginta']!=0)?"<br>� ��������:{$dress['ginta']}":"")." ".(($dress['gintel']!=0)?"<br>� ���������:{$dress['gintel']}":"")." ".(($dress['gmp']!=0)?"<br>� ��������:{$dress['gmp']}":"")." ".(($dress['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress['mfkrit']}%":"")." ".(($dress['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress['mfakrit']}%":"")." ".(($dress['mfuvorot']!=0)?"<br>� ��. ������������:{$dress['mfuvorot']}%":"")." ".(($dress['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress['mfauvorot']}%":"")." ".(($dress['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress['gnoj']}":"")." ".(($dress['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress['gtopor']}":"")." ".(($dress['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress['gdubina']}":"")." ".(($dress['gmech']!=0)?"<br>� �������� ������:+{$dress['gmech']}":"")." ".(($dress['gfire']!=0)?"<br>� �������� ������ ����:+{$dress['gfire']}":"")." ".(($dress['gwater']!=0)?"<br>� �������� ������ ����:+{$dress['gwater']}":"")." ".(($dress['gair']!=0)?"<br>� �������� ������ �������:+{$dress['gair']}":"")." ".(($dress['gearth']!=0)?"<br>� �������� ������ �����:+{$dress['gearth']}":"")." ".(($dress['glight']!=0)?"<br>� �������� ����� �����:+{$dress['glight']}":"")." ".(($dress['ggray']!=0)?"<br>� �������� ����� �����:+{$dress['ggray']}":"")." ".(($dress['gdark']!=0)?"<br>� �������� ����� ����:+{$dress['gdark']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\','.$r.')" >';
				 }
				 else
				 {
				 echo '<a href="http://oldbk.com/encicl/'.$ehtml.'" target="_blank"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'<b>'.$dress['name']."</b><br>�������:<b>".$dress['up_level']."</b><br>��������� ".$dress['duration']."/".$dress['maxdur']." ".(($dress['ghp']>0)?"<br>������� ����� +{$dress['ghp']}":"")." ".(($dress['bron1']!=0)?"<br>� ����� ������:{$dress['bron1']}":"")." ".(($dress['bron2']!=0)?"<br>� ����� �������:{$dress['bron2']}":"")." ".(($dress['bron3']!=0)?"<br>� ����� �����:{$dress['bron3']}":"")." ".(($dress['bron4']!=0)?"<br>� ����� ���:{$dress['bron4']}":"")." ".(($dress['text']!=null)?"<br>  �� ���� �������������: {$dress['text']}":"").'\','.$r.')" >';
				 }
			}
		} else {
			if (!$pas OR ($battle AND $me))
			{
			echo '<a href="?edit=1&filt=31"><img src="http://i.oldbk.com/i/none.gif" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'������ ���� ����\','.$r.')" ></a>';
			}
			else
			{
			echo '<img src="http://i.oldbk.com/i/none.gif" width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,17,\'������ ���� ����\','.$r.')" >';
			}
		}
	?></A></td>

        </tr></table>
<?
}
?>


<?
//<--
}

?>
</CENTER><CENTER>

<TABLE cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
		  <?
	if(!$battle){
?>
        <? if ($pas){ ?><TR>
          <TD align=middle colSpan=2><B>
          <?
          if (CITY_ID==0)  { $city_name_is='CapitalCity'; }
     	  else if (CITY_ID==1)  { $city_name_is='AvalonCity'; }
     	  else if (CITY_ID==2)  { $city_name_is='AngelsCity'; }
          echo $city_name_is;
          ?></B></TD></TR>
        <TR>
          <TD colSpan=2 align=center>
		  <SMALL><?php
//if hidden offline too

           	if($user['room'] > 500 && $user['room'] < 561) {
				if($user['id']==83 || $user['id']==136)
				{
				    $ls = mysql_fetch_array(mysql_query("select count(`id`) as cc, SUM(`bot`) as bb from `users` WHERE `in_tower` = 1;"));
				    $alive_man=$ls[0]-$ls[1];
					$alive_bot=$ls[1];
					if($alive_man==1)
					{
					 	$show_arh_place=1;
					}
					else
					{
						$show_arh_place=0;
					}
				}

				$tr = mysql_fetch_array(mysql_query("SELECT * FROM `deztow_turnir` WHERE `active` = TRUE"));

				if($tr['type']==1 OR $tr['type']==6 OR $tr['type']==8 OR $tr['type']==10 OR $show_arh_place==1) {
					$rrm = '����� ������, "'.$rooms[$user['room']].'" </b><br> ��������� � ������� <a target=_blank href="/towerlog.php?id='.$tr['id'].'"><b>>>></a></b>';
				} elseif($user['odate'] >= ((time()-120))) {
					$rrm = '"����� ������</b>" <br> ��������� � ������� <b><a target=_blank href=/towerlog.php?id='.$tr['id'].'>>></a></b>';
				} else {
		                    	echo "��������� � ������ ������ ��� � ����� ��� � ���� �������� ���<br>";
		                }
		                echo '�������� ������ ��������� � �����.<BR><CENTER><B>'.$rrm.'</B>';
		} elseif ($user['room'] > 10000 && $user['room'] < 11000) {
				if($user['id'] == 84) {
				    $ls = mysql_fetch_array(mysql_query("select count(`id`) as usercount from `users` WHERE `in_tower` = 15"));
				    $alive_man = $ls[0];
				    if($alive_man==1) {
					$show_arh_place=1;
				    } else {
				        $show_arh_place=0;
				    }
				}

				$tr = mysql_fetch_array(mysql_query("SELECT * FROM `dt_map` WHERE `active` = 1"));

				include "dt_rooms.php";
				if($tr['whitetype']==1 OR $show_arh_place==1) {
					$rrm = '����� ������, "'.$dt_rooms[$user['room']][0].'" </b><br> ��������� � ������� <a target=_blank href="/dt_log.php?id='.$tr['id'].'"><b>>>></a></b>';
				} elseif($user['odate'] >= ((time()-120)) || $user['id'] == 84) {
					$rrm = '"����� ������</b>" <br> ��������� � ������� <b><a target=_blank href=/dt_log.php?id='.$tr['id'].'>>></a></b>';
				} else {
		                    	echo "��������� � ������ ������ ��� � ����� ��� � ���� �������� ���<br>";
		                }
		                echo '�������� ������ ��������� � �����.<BR><CENTER><B>'.$rrm.'</B>';
	    	} else
			if ($user['odate'] >= ((time()-120)) && (!($user['hidden']>0)) ) {
				if ($user['in_tower'] ==3 )
				{
					$rrm = '"�������:��������� ��������" <a target=_blank href=/nturlog.php?id='.$user['id_grup'].'>��</a>';
				}
				elseif ($user['lab'] > 0 )
				{
					$rrm = '"�������� �����"';
				}
				else if ($user['ruines'] > 0 )
				{
					$rrm = '"�����"</B><br> ��������� � <B><a target=_blank href=/ruines_log.php?id='.$user['ruines'].'>������� �</a>';
				} elseif ($user['room'] >= 61001 && $user['room'] < 62000) {
					$rrm = '"������"';
				} elseif ($user['room'] >= 49998 && $user['room'] <= 60000) {
					include "map_config.php";
					reset($map_locations);
					$bfound = false;
					while(list($k,$v) = each($map_locations)) {
						if ($user['room'] == $v['room']) {
						    	$rrm .= '"'.$v['name'].'"';
							$bfound = true;
						}
					}
					if (!$bfound) $rrm .= '"�������"';
				} elseif ($user['room'] >= 70000 && $user['room'] <= 72000) {
				    	$rrm = '"�����"';
				}
				else
				{
				$rrm = '"'.$rooms[$user['room']].'"';
				}
				echo '�������� ������ ��������� � �����.<BR><CENTER><B>'.$rrm.'</B>';
			}
			else
			{
				if (($user[bot]==1) and ($user[id]>=571) and ($user[id]<=595))
				{
				    echo '�������� ������ ��������� � �����.<BR><CENTER><B>"������� ��� ��������"</B>';
				}
				else
				if ($user[bot]==1)
				{
				   $get_bot_online=mysql_fetch_array(mysql_query("select * from users_clons where bot=2 and bot_room>0 and bot_online>0 and id_user='{$user['id']}' LIMIT 1;"));
				   if ($get_bot_online[id]>0)
				    {
				    $rrm = '"'.$rooms[$get_bot_online['bot_room']].'"';
				    echo '�������� ������ ��������� � �����.<BR><CENTER><B>'.$rrm.'</B>';
				     if ($get_bot_online[battle]>0)
				       {
				       $bot_batt=1;
				       echo '<BR>�������� ������ � <a target=_blank href="logs.php?log=',$get_bot_online[battle],'">��������</a>';
				       }
				    }
				    else
				    {
 	  				echo "��������� � ������ ������ ��� � ����� ��� � ���� �������� ���!!<br>";
				    }
				}
				else
				{
					echo "��������� � ������ ������ ��� � ����� ��� � ���� �������� ���!<br>";

					if($user[in_tower]==4)
					{
						echo "<b>�������� ��������� � ��������� � �������.</b><br>";
					}
				}

				if ( (($user[klan]!='radminion')AND($user[klan]!='Adminion')AND($user[klan]!='r�dminion') AND ($user[align]!=7) AND (($user[align]>=3)OR($user[align]<=2))))
				{
				  if ($user[bot]!=1)
				  {

					    if (($user[ldate]>0) and ($user[odate]>0))
						{
							$ldate=$user[ldate];
							$odate=$user[odate];
						}
					else if  (($user[ldate]>0) and ($user[odate] ==0 ))
						{
							$ldate=$user[ldate];
							$odate=$user[ldate];
						}
					else if  (($user[ldate]==0) and ($user[odate] > 0 ))
						{
							$ldate=$user[odate];
							$odate=$user[odate];
						}
						else
						{
						 	//������ � ������� ���� ����� ������ �� ��� ��
 							$getld=mysql_fetch_array(mysql_query("select max(`date`) as ldate from oldbk.iplog where owner={$user['id']}"));
							if ($getld[ldate]>0)
								 	{
								 		$ldate=$getld[ldate];
										$odate=$getld[ldate];
										mysql_query("update users set ldate='{$ldate}', odate='{$odate}' where id={$user['id']}");
						 			}
						}

						if (($ldate>0) and ($odate>0))
						{
							if(($user['hidden']>0)and($user['hiddenlog']==''))
								{
									$odate-=60;
								}
								else
								if(($user['hidden']>0)and($user['hiddenlog']!=''))
								{
									$odate-=60;
								}

						/*
							if(($user['hidden']>0)and($user['hiddenlog']==''))
							{ //����� ������ � ���������
                             					$eff=mysql_fetch_array(mysql_query('select * from effects where owner='.$user['id'].' AND (type=200 OR type=202 ) LIMIT 1 ;'));
							 	$ldate=time()-(18000-($eff['time']-time()));//7200
							 	$odate=$ldate;
							}
							else
							if(($user['hidden']>0)and($user['hiddenlog']!=''))
							{ //����� ������ � �����������
                             					$eff=mysql_fetch_array(mysql_query('select * from effects where owner='.$user['id'].' AND type=1111;'));
							 	$ldate=time()-(18000-($eff['time']-time()));//7200
							 	$odate=$ldate;
							}
						*/


							$odates=outtimeb($odate);
							echo "<div align=cenet><b>�� ��� ���: ".date("d.m.Y H:i",$odate)."<br>";
							echo "($odates �����)</b></div>";
						}
				    }
				}
			}

			if (($user['battle'] > 0) and (!($user['hidden']>0)) )
			{
				if($user['id']==83 || $user['id']==102 ||$user['id']==136)
				{
				 $a_batt_id=mysql_fetch_array(mysql_query('select battle from users_clons where id_user='.$user['id'].' limit 1'));
                   		 $user['battle']=$a_batt_id[battle];
				}
					if ($bot_batt!=1) { echo '<BR>�������� ������ � <a target=_blank href="logs.php?log=',$user['battle'],'">��������</a>'; }
			}

			?></CENTER></SMALL></TD></TR><?
			}
			// ������� ������ ����� � ��.  ������ ����� �������.  ��� ��������� ������. ������������ ������ ��������
			print $travmaData.$printData;
			?>
			</TBODY></TABLE></CENTER>


</TD>
	<TD valign=top <?=(!$pas?"style='width:350px;'":"")?>>
<table><tr><td>
����: <?=$user['sila']?><BR>
��������: <?=$user['lovk']?><BR>
��������: <?=$user['inta']?><BR>
������������: <?=$user['vinos']?><BR>
<?php
if ($user['level'] > 3) {
?>
���������: <?=$user['intel']?><BR>
<?php
}
if ($user['level'] > 6) {
?>
��������: <?=$user['mudra']?><BR>
<?php
}
if (!$pas && (($user['stats'] > 0) OR ($user['master'] > 0))) {
?>
<a href="main.php?edit=1">+ �����������</a>
<?
}
?>
<HR>
<?php
	if ($_SESSION['uid'] == $id)
	{
		echo '����: <a href="http://oldbk.com/encicl/?/exp.html" target="_blank">'.$user['exp'].'</a>';
		if (($user['level']==13) and ($user['exp']>=8000000000) )
		{
		//��� ����� �� ���������� ��������� ��
		echo "<BR>";
		echo "�������: <font color=#F03C0E><b>{$user['level']}</b></font> <BR>";
		}
		else
		{
		echo "(".$user['nextup'].")";
		echo "<BR>";
		echo "�������: {$user['level']} <BR>";
		}

	}
?>

�����: <?=$user['win']?><BR>
���������: <?=$user['lose']?><BR>
������� �������: <?=$user['skulls']?><BR>
����������� ���: <? echo (int)($user['users_chaos']);?><BR>
<?php

if ($_SESSION['uid'] == 8540 || $_SESSION['uid'] == 182783 || $_SESSION['uid'] == 457757 || $_SESSION['uid'] == 102904) {
	echo '����� � ������� ���������: '.$user['winstbat'].'<br>';
}

if (!$pas) {
?>
������: <b><?=$user['money']?></b> ��.<BR>
������: <b><?=$user['gold']?></b> <img src="http://i.oldbk.com/i/icon/coin_icon.png" alt="������" title="������" style="margin-bottom: -2px;"><BR>
<?php
}

if($user['id']==546433)
	{
	echo "<a href='http://oldbk.com/encicl/klani/clans.php?clan=radminion' target=_blank>radminion</a> - ".close_dangling_tags($user['status'])."<BR>";
	}
elseif(($user['klan'] && !$pas) and ($user['klan']!='pal')) {
	echo "����: {$user['klan']}<BR>";
} elseif(($user['klan']) and ($user['klan']!='pal'))  {
	if (($user['align'] == 3.99) or ($user['klan']=='Arm'))   {
		echo "<b>������ ������</B> - {$user['status']}<BR>";
	} else {
		echo "<a href='http://oldbk.com/encicl/klani/clans.php?clan=".close_dangling_tags($user['klan'])."' target=_blank>".close_dangling_tags($user['klan'])."</a> - ".close_tags_new($user['status'])."<BR>";
	}
} elseif($user['align'] > 0) {
	if ((($user['align'] > 1) && ($user['align'] < 2)) or ($user['klan']=='pal'))   { echo '<a href="http://paladins.oldbk.com/" target="_blank"><b>����������� �����</B></a> - '.$user['status'].'<BR>'; }
	if (($user['align'] == 3)) { echo "<b>������ ��������</B><BR>"; }
	if (($user['align'] == 2)) { echo "<b>����������� ��������</B><BR>"; }
	if (($user['align'] == 6)) { echo "<b>������� ��������</B><BR>"; }
	if (($user['align'] == 1)) { echo "<b>������� ��������</B><BR>"; }
}


if ($pas) {
$date1 = explode(" ", $user['borntime']);
$date2 = explode("-", $date1[0]);
$date3 = "".$date2[2].".".$date2[1].".".$date2[0]."";

if ($user['uclass']>0)
		{
		echo "����� ���������: <b>{$nclass_name[$user['uclass']]}</b><BR>";
		}

?>
����� ��������: <b><?=$user['borncity']?></b><BR>
�����������: <b><?=$user['citizen']?></b><BR>
<?php
if (isset($user['naem_id']) && $user['naem_id'] > 0) {
	if ($_SESSION['uid'] == $user['owner'] || $admin) {
		?>���� �������� ���������: <?=$date3?><BR><?php
	}
} else {
	?>
	���� �������� ���������: <?=$date3?><BR>
	<hr>
<?
}
	if($user['palcom'] && $pas)
	{

		if ($user['id']==19350)
			{
			echo "<FONT class=private>";
			echo "{$user['palcom']}</font>";
			}
			else
			{
			echo "��������� �� ��������� � ������� �������� � ����/����������:<BR><FONT class=private>";
		    	$paltext= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a target=_blank href=\"$3\" >$3</a>", $user['palcom']);
			echo "{$paltext}</font>";
				if ($user['block'] == 1 || $user['align'] == 4)
				{

					echo "<br>��� ������ �� �����/�����: <a target=_blank href=\"https://oldbk.com/forum/topic/230358537\">https://oldbk.com/forum/topic/230358537</a>";
				}
			}
	}

if ($user['align'] == 4)
  {
	if ($chaosData!='')
	{
	print $chaosData;
	}
	else
	{
	echo "<br>���� - <i>���������</i>";
	}
  }
}

?>
</td></tr></table><?}
else {
?>
<TR>
          <TD colSpan=2 style="padding-left:25px;">
<?
	if ( ( ($user['hidden']>0) and ($_SESSION['uid'] != $id)   )  or (( strpos($user['login'],"��������� (����" ) !== FALSE )))
	{
	echo "����: ??<BR>";
	echo "��������: ??<BR>";
	echo "��������: ??<BR>";
	echo "������������: ??<BR>";
	echo "���������: ??<BR>";
	echo "��������: ??<BR>";
	}
	else
	{
	echo "����: $user[sila]<BR>";
	echo "��������: $user[lovk]<BR>";
	echo "��������: $user[inta]<BR>";
	echo "������������: $user[vinos]<BR>";
	if ($user['level'] > 3) {
	echo "���������: $user[intel]<BR>";
					}
	if ($user['level'] > 6) {
	echo "��������: $user[mudra]<BR>";
	}				}

 ?>
 </td></tr></table>
 <?
}
}


function showitem2 ($row, $groupcount = 0, $retdata = 0, $orden = 0, $check_price = false,$act='',$priv=0,$shbg=false) {
	global $user, $klan_ars_back, $giftars, $IM_glava, $anlim_show, $anlim_items, 	$nodress , $nclass_name , $can_inc_magic ;
	$vau4 = array(100005,100015,100020,100025,100040,100100,100200,100300);

	$ret = "";

	if (!empty($row['img_big']))
	{
		$row['img'] = $row['img_big'];
	}

	//opacity: 0.2;
	if ($groupcount<0 )
	{
		$ret .= '<div class="gift-block" data-id="'.$row['id'].'"  style="float:left;position:relative;cursor:pointer;"><img class="gift-image" id="imginv'.$row['id'].'" style="opacity: 0.2;" src="http://i.oldbk.com/i/sh/'.$row['img'].'">';

	}
	else
	{
		if ($act!='')
		{
		$bgshow='';
		if ($shbg==true) { $bgshow=' style="background-color:#C7C7C7;" '; }
		$ret .= '<div class="gift-block" data-id="'.$row['id'].'" OnClick="'.$act.';" style="float:left;position:relative;cursor:pointer;"><img class="gift-image" '.$bgshow.' id="imginv'.$row['id'].'" src="http://i.oldbk.com/i/sh/'.$row['img'].'">';
		}
		else
		{
		$ret .= '<div class="gift-block" data-id="'.$row['id'].'" OnClick="ToggleInvP('.$row['id'].');" style="float:left;position:relative;cursor:pointer;"><img class="gift-image" id="imginv'.$row['id'].'" src="http://i.oldbk.com/i/sh/'.$row['img'].'">';
		}
	}

	if (!$row['can_drop'] || $row['prototype'] == "509" || $row['prototype'] == "3003227" || $row['prototype'] == "12802" || $row['prototype'] == "3003226" ||$row['prototype'] == "3003228" || $row['prototype'] == "3003092" || $row['prototype'] == "3003093" || $groupcount<0 || ($row['prototype'] >= "111000" &&  $row['prototype'] <= "119000") || $row['prototype'] == "3003226" || $row['prototype'] == "509" || $row['prototype'] == "" || ($_SERVER['PHP_SELF'] == '/lab4.php') ) {
		// ���� ������� ������ ����������
		$ret .= '%RETAPPLY%';
	} else {
		$ret .= '<img class="invclear" id="imgclear'.$row['id'].'" src="http://i.oldbk.com/i/buttons/clear3.png" onclick="if (confirm(\'������� '.str_replace('"',"\\'",$row['name']).' ����� ������, �� �������?\')) window.location=\'main.php?edit=1&destruct='.$row['id'].'\';"> %RETAPPLY%';
	}

	$retapply = '<img class="invapply" src="http://i.oldbk.com/i/buttons/apply3.png" id="imgapply'.$row['id'].'" %RETAPPLYACTION%>';

	if ($groupcount > 0) $ret .= '<span class="invgroupcount">'.$groupcount.'</span>';

	$ret .= '</div>';
	$ret .= '<div style="display:none;" id="info'.$row['id'].'" class="invthing"><table border=0 style="width:100%;">';


	if($row['add_pick'] != '' && $row['pick_time']>time()) {
		$row['img'] = $row['add_pick'];
	}


	if (($row['type'] == 30) and ($row['owner']==$user['id']) ) // ������� �� ���� �������
	{
	// ����������  ��� ���� ���� ������
		if ($row['ups'] >= $row['add_time'])
		{
		$mig=explode(".",$row['img']);
		$row['img']=$mig[0]."_up.".$mig[1];
		}
	}


	if ($row['type'] == 12 && !empty($row['img_big'])) {
		$row['img'] = $row['img_big'];
	}


	if($row['dategoden'] && $row['dategoden'] <= time()) {
		destructitem($row['id']);
		if($row['setsale']>0) {
			mysql_query("DELETE FROM oldbk.`comission_indexes` WHERE id_item = '".$row[id]."' LIMIT 1");
		}

		if ($row['labonly']==0) {
			$rec['owner']=$user['id'];
			$rec['owner_login']=$user[login];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money'];
			$rec['target']=0;
			$rec['target_login']='���� ��������';
			$rec['type']=35;
			$rec['sum_kr']=0;
			$rec['sum_ekr']=0;
			$rec['sum_kom']=0;
			$rec['item_id']=get_item_fid($row);
			$rec['item_name']=$row['name'];
			$rec['item_count']=1;
			$rec['item_type']=$row['type'];
			$rec['item_cost']=$row['cost'];
			$rec['item_dur']=$row['duration'];
			$rec['item_maxdur']=$row['maxdur'];
			$rec['item_ups']=$row['ups'];
			$rec['item_unic']=$row['unik'];
			$rec['item_incmagic']=$row['includemagicname'];
			$rec['item_incmagic_count']=$row['includemagicuses'];
			$rec['item_arsenal']='';
			add_to_new_delo($rec); //�����
		}
	}

	$magic = magicinf ($row['magic']);

	$incmagic = magicinf($row['includemagic']);
	$incmagic['name'] = $row['includemagicname'];
	$incmagic['cur'] = $row['includemagicdex'];
	$incmagic['max'] = $row['includemagicmax'];
	$incmagic['uses'] = $row['includemagicuses'];

	if(!$magic) {
		$magic['chanse'] = $incmagic['chanse'];
		$magic['time'] = $incmagic['time'];
		$magic['targeted'] = $incmagic['targeted'];
	}

	$artinfo = "";
	$issart = 0;
	if ((($row['ab_uron'] > 0 || $row['ab_bron'] > 0 || $row['ab_mf'] > 0 || $row['art_param'] != "")  AND $row['type'] != 30) || ($row['type'] == 30 && $row['up_level'] > 5)) {
		if ($row['type'] != 30) $artinfo = ' <IMG SRC="http://i.oldbk.com/i/artefact.gif" WIDTH="18" HEIGHT="16" BORDER=0 TITLE="��������" alt="��������"> ';
		$issart = 1;
	}


	if (!$row[GetShopCount()] || $row['inv']==1|| $groupcount<0 ) {
		$ch=0;

		if($row['type'] < 12) {
			$ch=1;
		} elseif($row['type'] == 27 || $row['type'] == 28) {
			$ch=2;
		}
		$ret .= '<TR valign="top">';
		$ret .= '<TD nowrap valign="top" width="60" ';
		if ($ch > 0) {
			if (($row['maxdur']-2)<=$row['duration'] && $row['duration'] > 2) {
				$ret .= " style=\"background-image:url('http://i.oldbk.com/i/blink.gif');\" ";
			}
		}
		$ret .= " >";

		$dr=shincmag($row);

		if ($groupcount<0) $ch=0;


		if ($row['prototype']>=2013001 && $row['prototype']<=2013004) {
			$ret .= "<div style='position:relative;'><a href='http://oldbk.com/encicl/?/laretz.html' target=_blank>";
			if ($ch == 1) {
				$ret .= render_vstroj($row['includemagicdex']);
			}
			$ret .= "<img src='http://i.oldbk.com/i/sh/".$row['img']."'></a></div></td><td nowrap valign=top>";
		} else {
			$ret .= "<div style='position:relative;'>";
			if ($ch == 1) {
				$ret .= render_vstroj($row['includemagicdex']);
			}
			$ret .= "<img src='http://i.oldbk.com/i/sh/".$row['img']."'></div></td><td nowrap valign=top>";
		}

		$rettmp = "";

		if(isset($row['idcity'])) {
			if ($row['showbill'] == true) {
				$sh_id = "����� �: ".$row['id'];
			} else {
				$sh_id = get_item_fid($row);
			}
		}

		if($row['chk_arsenal'] == 0) {
			$ch_al=$user['align'];
			if($user['klan']=='pal') {
				$ch_al = 6; //���� ��� �����
				$ch_al2 = 1 ; //���� ��� �����
			}
			else
			{
				$ch_al2=0;
			}

			if ( (	($user['sila'] >= $row['nsila']) &&
							($user['lovk'] >= $row['nlovk']) &&
							($user['inta'] >= $row['ninta']) &&
							($user['vinos'] >= $row['nvinos']) &&
							($user['intel'] >= $row['nintel']) &&
							($user['mudra'] >= $row['nmudra']) &&
							($user['level'] >= $row['nlevel']) &&
							(((int)$ch_al == $row['nalign']) OR ($row['nalign'] == 0) OR ($user[align]==5) OR ($ch_al2 == $row['nalign']) ) &&
							($user['noj'] >= $row['nnoj']) &&
							($user['topor'] >= $row['ntopor']) &&
							($user['dubina'] >= $row['ndubina']) &&
							($user['mec'] >= $row['nmech']) &&
							($user['mfire'] >= $row['nfire']) &&
							($user['mwater'] >= $row['nwater']) &&
							($user['mair'] >= $row['nair']) &&
							($user['mearth'] >= $row['nearth']) &&
							($user['mlight'] >= $row['nlight']) &&
							($user['mgray'] >= $row['ngray']) &&
							($user['mdark'] >= $row['ndark']) &&
							($row['type'] < 13 OR ($row['type']==50) OR $row['type']==27 OR $row['type']==28 OR $row['type']==30  ) &&
							($row['needident'] == 0)
					) OR ($row['type']==33)  )
			{
				if ((($row['type']==12) OR ($row['magic']) OR ($incmagic['cur'])) && $orden == 0 && $act == '') {
					if ($user['align'] != 4) {
						$rettmp .= " onclick=\"";

						if($magic['id'] == 109 OR $magic['id'] == 43 OR $magic['id'] == 200 OR $magic['id'] == 500 OR $magic['id'] == 65 OR $magic['id'] == 95 OR $magic['id'] == 9595 OR $magic['id'] == 96) {
							$rettmp .= "showitemschoice('�������� ������������ ������', 'scrolls', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 306020) {
							$rettmp .= "showitemschoice('�������� �������� ����������', 'usesalign', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 106604) {
							$rettmp .= "showitemschoice('�������� �������� ������', 'usesbaff', 'main.php?edit=1&use=".$row['id']."');";
						}
						elseif($magic['id'] == 110) {
							$rettmp .= "showitemschoice('�������� ������ ������ ������', 'moveemagic', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 227) {
							$rettmp .= "showitemschoice('�������� ������� ��� ����������', 'del_time', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 67) {
							$rettmp .= "showitemschoice('�������� ����� ��� ��������', 'makefreeup_bron', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 68) {
							$rettmp .= "showitemschoice('�������� ������ ��� ��������', 'makefreeup_ring', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 69) {
							$rettmp .= "showitemschoice('�������� ����� ��� ��������', 'makefreeup_kulon', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 70) {
							$rettmp .= "showitemschoice('�������� �������� ��� ��������', 'makefreeup_perchi', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 71) {
							$rettmp .= "showitemschoice('�������� ���� ��� ��������', 'makefreeup_shlem', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 72) {
							$rettmp .= "showitemschoice('�������� ��� ��� ��������', 'makefreeup_shit', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 73) {
							$rettmp .= "showitemschoice('�������� ������ ��� ��������', 'makefreeup_sergi', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 74) {
							$rettmp .= "showitemschoice('�������� ������ ��� ��������', 'makefreeup_boots', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 76) {
							$rettmp .= "showitemschoice('�������� ������ ��� �����������', 'lab_teleport', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 201) {
							$rettmp .= "showitemschoice('�������� ������� ��� �������� �����', 'delitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif(($magic['id'] == 84) OR ($magic['id'] == 85) OR ($magic['id'] == 86) OR ($magic['id'] == 87) ) {
							$rettmp .= "showitemschoice('�������� ����', 'add_runs_exp', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 29) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 30) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 31) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 32) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 5) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 25) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 26) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 27) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 28) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 33) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 34) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 35) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 36) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 37) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 38) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 39) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 40) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 41) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 42) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100001) {
							$rettmp .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120001) {
							$rettmp .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_1_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100002) {
							$rettmp .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120002) {
							$rettmp .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_2_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100003) {
							$rettmp .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 130003) {
							$rettmp .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_3_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100004) {
							$rettmp .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120004) {
							$rettmp .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_4_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100005) {
							$rettmp .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120005) {
							$rettmp .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_5_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100006) {
							$rettmp .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_6', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120006) {
							$rettmp .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_6_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100011) {
							$rettmp .= "showitemschoice('�������� ������� ��� ��������� 1', 'item_bonus_1', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100012) {
							$rettmp .= "showitemschoice('�������� ������� ��� ��������� 2', 'item_bonus_2', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif(($magic['id'] == 100013) and ($row['sowner']==0)) {
							$rettmp .= "showitemschoice('�������� ������� ��� ��������� 3', 'item_bonus_3e', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100013) {
							$rettmp .= "showitemschoice('�������� ������� ��� ��������� 3', 'item_bonus_3', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100014) {
							$rettmp .= "showitemschoice('�������� ������� ��� ��������� ��������� III�', 'item_bonus_big', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif(($magic['id'] == 100015) and ($row['sowner']==0)) {
							$rettmp .= "showitemschoice('�������� ������� ��� ��������� 4', 'item_bonus_4e', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100015) {
							$rettmp .= "showitemschoice('�������� ������� ��� ��������� 4', 'item_bonus_4', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100016) {
							$rettmp .= "showitemschoice('�������� ������� ��� �".$row['name']."�', 'item_bonus_big_4', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						}
						 elseif($magic['id'] == 8090) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 90) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_6', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 91) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 92) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 93) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 94) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 190) {
							$rettmp .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 191) {
							$rettmp .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif(($magic['id'] == 181)||($magic['id'] == 182)||($magic['id'] == 183)||($magic['id'] == 184)||($magic['id'] == 185))  {
							$rettmp .= "showitemschoice('�������� �������������� ��� ��������� ������', 'bysshop', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 172)   {
							$rettmp .= "showitemschoice('�������������:', 'usedays', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 3) {
							$rettmp .= "showitemschoice('�������� ������� ��� �������������', 'identitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 214 or $magic['id'] == 218 or $magic['id'] == 222) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 215 or $magic['id'] == 219 or $magic['id'] == 223) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 216 or $magic['id'] == 220 or $magic['id'] == 224) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_9', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 217 or $magic['id'] == 221 or $magic['id'] == 225) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_10', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 317 or $magic['id'] == 321 or $magic['id'] == 325) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_11', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 1025) {
							$rettmp .= "shownoobrings('�������� ������', 'noobrings', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 1030) {
							$rettmp .= "showelka('�������� ������� ����', 'elka', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 1031) {
							$rettmp .= "showelka2('�������� ������� ����', 'elka2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 326 or $magic['id'] == 327 or $magic['id'] == 328) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_12', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['targeted'] == 8) {
							$rettmp .= "oknoPass('������� ������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 1) {
							$rettmp .= "okno('������� �������� ��������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 10) {
							$rettmp .= "oknoCity('������� �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 13) {
							$rettmp .= "oknoTeloCity('������� ��� � �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target','city')";
						} elseif($magic['targeted'] == 15) {
							$rettmp .= "okno('������� ����� ������ ����������� �����', 'main.php?edit=1&use=".$row['id']."', 'target',null,2)";
						} elseif($magic['targeted'] == 2) {
							$rettmp .= "findlogin('������� ��� ���������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif(($magic['targeted'] == 0) AND ($magic['name'] == '���������') and ($user['battle'] == 0)) {
							$rettmp .= "findlogin('������� ��� ���������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['id'] == 100) {
							$rettmp .= "usepaper('������', 'main.php?edit=1&use=".$row['id']."', 'target','100')";
						} elseif($magic['id'] == 101) {
							$rettmp .= "usepaper('������', 'main.php?edit=1&use=".$row['id']."', 'target','200')";
						} elseif($magic['id'] == 102) {
							$rettmp .= "usepaper('������', 'main.php?edit=1&use=".$row['id']."', 'target','500')";
						} elseif($magic['id'] == 4201 || $magic['id'] == 4202 || $magic['id'] == 4203) {
							$rettmp .= "usepaper('���������� ������', 'main.php?edit=1&use=".$row['id']."', 'target','60')";
						} elseif($magic['id'] == 4204) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4204', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4205) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4205', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4206) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4206', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4207) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� �����', 'rihtbron', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120) {
							$rettmp .= "showitemschoice('�������� ���������� ������� ��� ���������', 'upunik', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 121) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upitem', 'main.php?edit=1&use=".$row['id']."');";
						} elseif(($magic['targeted'] == 0) AND ($magic['name'] == '���������') and ($user['in_tower']==0)) {
				    		  	$rettmp .= "if(confirm('������������ ������?')) { window.location='main.php?edit=1&use=".$row['id']."';}";
						} elseif($magic['id'] == 199) {
							$rettmp .= "showitemschoice('�������� �������� ������', 'usesmagic', 'main.php?edit=1&use=".$row['id']."');";
						}
						else {
							$rettmp .= "window.location='main.php?edit=1&use=".$row['id']."';";
						}
						$rettmp .= '" ';
						/*

						if ($magic['id'] == 4004000) {
							$ret .= "\" href='#'>�������</a> ";
						} else {
							$ret .= "\" href='#'>���-��</a> ";
						}
						if ($magic['id'] == 171) {
							$ret .= "<br><a href=\"main.php?edit=1&flag=".$row['id']."\">������</a> ";
						}
						elseif ($magic['id'] == 172) {
							$ret .= "<br><a onclick=\"okno('������� �����:', 'main.php?edit=1&usedays=".$row['id']."', 'daystext','',2);\" href='#'>������</a> ";
						}
						*/

					}

				}

				/*
				if($act == '') {
					if (($row['type'] != 50 && $orden == 0) AND ((($row['sowner']>0) AND ($user['id'] == $row['sowner'])) OR ($row['sowner'] == 0))) {

					if (!(in_array($row['prototype'],$nodress) ))
							{
							 if ($user['align'] != 4) $ret .= "<BR><a href='?edit=1&dress=".$row['id']."'>������</a> ";
							 }
					}

					$is_in_pocket = (int)$row['karman'];
					if($is_in_pocket == 0 && $orden==0 && $user['in_tower'] != 16) {
						$ret .= "<br><a href='?edit=1&pocket=1&item=".$row['id']."'>��������</a> ";
					} elseif($is_in_pocket != 0 && $orden == 0 && $user['in_tower'] != 16) {
						$ret .= "<br><a href='?edit=1&pocket=2&item=".$row['id']."'>�������</a> ";
					}
				 }*/
			} elseif ((($row['type']==50) OR ($row['type']==12) OR ($row['magic']) OR ($incmagic['cur'])) and ($row['type'] != 13)) {
				if($act == '') {
					//if ($user['align'] != 4)
					if (true)
					{
						$rettmp .= "onclick=\"";
						if($magic['id'] == 43 OR $magic['id'] == 200 OR $magic['id'] == 65) {
							$rettmp .= "showitemschoice('�������� ������������ ������', 'scrolls', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 306020) {
							$rettmp .= "showitemschoice('�������� �������� ����������', 'usesalign', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 106604) {
							$rettmp .= "showitemschoice('�������� �������� ������', 'usesbaff', 'main.php?edit=1&use=".$row['id']."');";
						}
						elseif($magic['id'] == 201) {
							$rettmp .= "showitemschoice('�������� ������� ��� �������� �����', 'delitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 3) {
							$rettmp .= "showitemschoice('�������� ������� ��� �������������', 'identitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 214 or $magic['id'] == 218 or $magic['id'] == 222) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 215 or $magic['id'] == 219 or $magic['id'] == 223) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 216 or $magic['id'] == 220 or $magic['id'] == 224) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_9', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 217 or $magic['id'] == 221 or $magic['id'] == 225) {
							$rettmp .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_10', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['targeted'] == 1) {
							$rettmp .= "okno('������� �������� ��������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 10) {
							$rettmp .= "oknoCity('������� �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 13) {
							$rettmp .= "oknoTeloCity('������� ��� � �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target','city')";
						} elseif($magic['targeted'] == 15) {
							$rettmp .= "okno('������� ����� ������ ����������� �����', 'main.php?edit=1&use=".$row['id']."', 'target',null,2)";
						} elseif($magic['targeted'] == 2) {
							$rettmp .= "findlogin('������� ��� ���������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['id'] == 4) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 29) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 30) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 31) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 32) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_m4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 5) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 25) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 26) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 27) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 28) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_t1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 33) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 34) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 35) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 36) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 37) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 38) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 39) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 40) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 41) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 76) {
							$rettmp .= "showitemschoice('�������� ������ ��� �����������', 'lab_teleport', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 42) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 8090) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 90) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_6', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 91) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 92) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 93) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 94) {
							$rettmp .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 190) {
							$rettmp .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 191) {
							$rettmp .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 910) {
							$rettmp .= "showitemschoice('�������� �������� ������', 'usev2015', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4204) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4204', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4205) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4205', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4206) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4206', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4207) {
							$rettmp .= "showitemschoice('�������� ���� ��� �������� �����', 'rihtbron', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4201 || $magic['id'] == 4202 || $magic['id'] == 4203) {
							$rettmp .= "usepaper('���������� ������', 'main.php?edit=1&use=".$row['id']."', 'target','60')";
						} elseif($magic['id'] == 199) {
							$rettmp .= "showitemschoice('�������� �������� ������', 'usesmagic', 'main.php?edit=1&use=".$row['id']."');";
						} else {
							$rettmp .= "window.location='main.php?edit=1&use=".$row['id']."';";
						}

						$rettmp .= '" ';

						/*
						if ($magic['id'] == 4004000) {
							$ret .= "\" href='#'>�������</a><br> ";
						} else {
							$ret .= "\" href='#'>���-��</a><br> ";
						}*/
					}
				}
			}

			/*
			if (in_array($row['prototype'],$vau4) && $row['prototype'] != 100005) {
				$ret .= "<a  onclick=\"";
				$ret .= "oknovauch('��������� ������', 'main.php?edit=1&exchange=".$row['id']."', 'target','".$row['prototype']."')";
				$ret .= "\" href='#'>���������</a> ";
			}
			*/

			/*
			if($orden == 0 && $act=='') {
				//fixed for group deleting resources in inv  by Umk
				if ($user['align'] != 4) {
					if($row['group_by'] == 1 && $row[GetShopCount()]>1) {
						if($row['present'] != '') {
							$gift=1;
						} else {
							$gift=0;
						}
	        				//$ret .= "<img src=http://i.oldbk.com/i/clear.gif style=\"cursor: pointer;\"  alt=\"��������� ��������� ����\" onclick=\"AddCount('".$row['prototype']."', '".$row['name']."','".$gift."','".$row['duration']."')\">";
					} elseif($row['present'] != '�������� �����' && $user['in_tower'] != 16) {
						if (!$issart || ($issart && ($user['in_tower'] > 0 || $row['labonly'] > 0))) {
							//$ret .= "<img src=http://i.oldbk.com/i/clear.gif style=\"cursor: pointer;\" onclick=\"if (confirm('������� ".$row['name']." ����� ������, �� �������?')) window.location='main.php?edit=1&destruct=".$row['id']."'\">";
						}
			    		} elseif ($user['in_tower'] == 16 && $row['type'] != 12 && $row['type'] != 13) {
						$ret .= "<br><a href='castles_o.php?ret=".$row['id']."&razdel=".$row['type']."'>������� �� �����</a> ";
			    		}
				}

			} elseif($act != '') {
				$ret .= $act;
			}
			*/
		}/* elseif($row['chk_arsenal'] == 1) {
			$ret .= "<A HREF='klan_arsenal.php?get=1&sid=".$user['sid']."&item=".$row['id_ars']."'>����� �� ��������</A>";

			if ($row['owner_original'] == 1) {
				$ret .= '<br><b>������� �� �����</b>';

				if ($IM_glava==1) {
	            			//����� ����� ����� ��������� ���������
					if ($row['all_access'] == 1) {
		            			$ret .= "<small><input type=checkbox name='mass_cl[".$row['id']."]' checked='checked' onclick=\"show('all_cl_".$row['id']."'); \"> ������ ����</small>";
					} else {
		            			$ret .= "<small><input type=checkbox name='mass_cl[".$row['id']."]' onclick=\"show('all_cl_".$row['id']."'); \"> ������ ����</small>";
					}

					if ($row['all_access'] == 0) {
						$ret .= "<br><div style=\"display:block;\" id=\"all_cl_".$row['id']."\"><small><a href=# onclick=\"window.open('klan_arsenal_access.php?it=".$row['id']."', 'access', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')\">���������� ������</a></small></div>";
					} else {
						$ret .= "<br><div style=\"display:none;\" id=\"all_cl_".$row['id']."\"><small><a href=# onclick=\"window.open('klan_arsenal_access.php?it=".$row['id']."', 'access', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')\">���������� ������</a></small></div>";
					}
				}
			} else {
				$ret .= '<br>����:<br><b>'. global_nick($row['owner_original']).'</b> <a target=_blank href=/inf.php?'.$row['owner_original'].'><img border=0 src="http://i.oldbk.com/i/inf.gif"></a>';
			}
		} elseif($row['chk_arsenal'] == 2) {
			if($row['owner_current'] == 0) {
				$ret .= "<BR><A HREF='klan_arsenal.php?my=1&get=1&sid=".$user['sid']."&item=".$row['id_ars']."'>�������</A>";
			} else {
				$ret .= "<BR>������������: <BR>";
				$ret .= "<b>".global_nick($row['owner_current'])."</b>";
				$ret .= ' <a target=_blank href=/inf.php?'.$row['owner_current'].'><img border=0 src=http://i.oldbk.com/i/inf.gif></a>';
				$ret .= "<BR><A HREF='klan_arsenal.php?my=1&get=1&sid=".$user['sid']."&item=".$row['id_ars']."&getmy=1'>�������</A>";
			}
		} elseif($row['chk_arsenal'] == 3) {
			$ret .= '<A HREF="klan_arsenal.php?put=1&sid='.$user['sid'].'&item='.$row['id'].'">����� � �������</A>';
			if ($giftars == 1) {
				$ret .= "<br><br><a  onclick=\"";
				$ret .= "if(confirm('�� ������������� ������ �������� �������� ������� ������������?')) { window.location='klan_arsenal.php?put=2&sid=".$user['sid']."&item=".$row['id']."';}";
				$ret .= "\" href='#'>";
				$ret .= "�������� � �������</a>";
			}
		} elseif($row['chk_arsenal'] == 4) {
           		$ret .= '<A HREF="klan_arsenal.php?return=1&sid='.$user['sid'].'&item='.$row['id'].'">�������</A>';
		} elseif($row['chk_arsenal'] == 5) {
			if($row['owner'] == 22125) {
				$ret .= "<BR>�� ������������.<BR>";
			} else {
				$ret .= "<BR>������������: <BR>";
				$ret .= "<b>".global_nick($row['owner'])."</b>";
				$ret .= ' <a target=_blank href=/inf.php?'.$row['owner'].'><img border=0 src=http://i.oldbk.com/i/inf.gif></a>';
				if ($klan_ars_back==1) {
				 	// ���� �� �������
			         	$ret .= '<br><A HREF="klan_arsenal.php?back=1&item='.$row['id'].'">������</A>';
				}
			}
		} elseif($row['chk_arsenal'] == 6) {
           		$ret .= '<A HREF="klan_arsenal.php?mybox=1&sid='.$user['sid'].'&item='.$row['id'].'">������� �� �������</A>';
		} elseif($row['chk_arsenal']>=3003131 && $row['chk_arsenal']<= 3003135) {
			$ret .= '<A HREF="klan_arsenal.php?usebook='.$row['id'].'">������������</A>';
		} elseif($row['chk_arsenal'] == 7) {
			$ret .= '<A HREF="klan_arsenal.php?mybox=2&sid='.$user['sid'].'&item='.$row['id'].'">�������� � ������</A>';
		}
		*/
		//$ret .= "<td>";
	}

	if (strlen($rettmp)) {
		$retapply = str_replace('%RETAPPLYACTION%',$rettmp,$retapply);
		$ret = str_replace('%RETAPPLY%',$retapply,$ret);
	} else {
		$ret = str_replace('%RETAPPLY%','',$ret);
	}

	if ($row['nalign']==1) {
		$row['nalign']='1.5';
	}


	$ehtml = str_replace('.gif','',$row['img']);

	$razdel=array(
			1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
			24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun", 61=>'eda' , 62=>'res'
	);

	$row['otdel'] == '' ? $xx = $row['razdel'] : $xx = $row['otdel'];

	if($razdel[$xx] == '') {
		$dola = array(5001,5002,5003,5005,5010,5015,5020,5025);

		if (in_array($row['prototype'],$vau4)) {
			$razdel[$xx]='vaucher';
		} elseif (in_array($row['prototype'],$dola)) {
			$razdel[$xx]='earning';
		}
		else {

			$oskol=array(15551,15552,15553,15554,15555,15556,15557,15558,15561,15562,15568,15563,15564,15565,15566,15567);
			if (in_array($row['prototype'],$oskol))
			{
				$razdel[$xx]="amun/".$ehtml;
			}
			else
			{
				$razdel[$xx]='predmeti';
			}
		}
	} else {

		$razdel[$xx]=$razdel[$xx]."/".$ehtml;

	}

	if ($row['art_param'] != '') {
		if ($row['arsenal_klan'] != '')	{
			// ��������
			$razdel[$xx]='art_clan';
		} elseif ($row['sowner'] != 0) {
			//������
			$razdel[$xx]='art_pers';
		}
	}


	$anlim_txt="";
	if (($anlim_show) and (in_array($row['prototype'],$anlim_items))) {
		$anlim_txt = ' <IMG SRC="http://i.oldbk.com/i/noobs.png" WIDTH="14" HEIGHT="8" BORDER=0 TITLE="��� ���� ������ ����� ������ � ���.��������" alt="��� ���� ������ ����� ������ � ���.��������"> ';
	}

	$pod = explode(':|:',$row['present']);
	if(count($pod) > 1) {
		$txt = $pod[0];
	} else {
		$txt = $row['present'];
	}

	if ($row['otdel']==72)
	{
		$ret .= "<a href=https://oldbk.com/commerce/index.php?act=perspres target=_blank>".$row['name']."</a>";
	}
	else
		if ($razdel[$xx]=='mag1/036')
		{
			$ret .= "<a href=https://oldbk.com/encicl/prem.html target=_blank>".$row['name']."</a>";
		}
		elseif ($razdel[$xx]=='mag1/037')
		{
			$ret .= "<a href=https://oldbk.com/encicl/prem.html target=_blank>".$row['name']."</a>";
		}
		elseif ($razdel[$xx]=='mag1/137')
		{
			$ret .= "<a href=https://oldbk.com/encicl/prem.html target=_blank>".$row['name']."</a>";
		}
		else
		{
			$ret .= "<a href=https://oldbk.com/encicl/".$razdel[$xx].".html target=_blank>".$row['name']."</a>";
		}

	if ($groupcount<0)
	{

		$ret .= "<br><br><small><b>��� � �������</b></small>";
	}



	if ($row['present']) {
		$ret .= "<img src=http://i.oldbk.com/i/align_".$row['nalign'].".gif> ".$artinfo.$anlim_txt.' <IMG SRC="http://i.oldbk.com/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="���� ������� ��� ������� '.$txt.'. �� �� ������� �������� ���� ������� ����-���� ���." ALT="���� ������� ��� ������� '.$txt.'. �� �� ������� �������� ���� ������� ����-���� ���.">';
	} else {

		if (($groupcount>=0) and ($row['nalign']!='') )
		{
			$ret .= "<img src=http://i.oldbk.com/i/align_".$row['nalign'].".gif> ".$artinfo.$anlim_txt;
		}
	}

	if ($row['ekr_flag'] > 0) $ret .= '<img src="http://i.oldbk.com/i/berezka06.gif" title="������� �� �������" alt="������� �� �������"> ';
	$ret .= '<BR>';

	$ret .= '</td></tr><tr><td colspan="2">';

	if ($groupcount<0)
	{
		if ($row['letter']!='')
			{
			$ret .= "<br>".$row['letter'];
			}
	}

	$row_prototype=isset($row['prototype'])?$row['prototype']:$row['id'];

	if (($row_prototype==949)||($row_prototype==950)||($row_prototype==951)) {
		$row['cost'] = 1;
	} elseif ((($row_prototype>=946) and ($row_prototype <=957))) {
		$row['cost'] = 1;
	}


	if ($groupcount>=0) {
		$ret .= "(���: ".$row['massa'].")<br>";

		if ($row['no'] == 1) {
			// nothing
		} elseif ($row['getfrom'] == 43 && $row['repcost'] > 0) {
			$ret .= "<b>����: ".$row['repcost']." ���.</b> &nbsp;";
		} elseif ($row['repcost'] > 0) {

			if($row['setsale'] > 0) {
				$row['cost']=$row['setsale'];
			}

			if($check_price) {
				if($user['repmoney'] < $row['repcost'])	{
					$ret .= "<b>����: <font color='red'>".$row['repcost']."</font> ���.</b> &nbsp;";
				} else {
					$ret .= "<b>����: ".$row['repcost']." ���.</b> &nbsp;";
				}
			} elseif((int)$row['type'] == 12) {
				$ret .= "<b>����: ".$row['cost']." ��.</b>  &nbsp;";
			} else {
				$ret .= "<b>����: ".$row['cost']." ��.</b>  &nbsp;";
			}
		} elseif($row['ecost'] > 0 && ($_SERVER['PHP_SELF'] != '/comission.php')) {
			$ret .= "<b>����: ".$row['ecost']." ���.</b> &nbsp; &nbsp;";
		} elseif($row['cost'] > 0 && $row['setsale'] > 0 && ($_SERVER['PHP_SELF'] == '/comission.php')) {
			$ret .= "<b>����: ".$row['setsale']." ��.</b> &nbsp; (���.����. ".$row['cost']." ��.)&nbsp;";
		} else {
			$ret .= "<b>����: ".$row['cost']." ��.</b> &nbsp; &nbsp;";
		}

		if ($row['no'] == 1) {
			// nothing
		} elseif($row[GetShopCount()]) {
			if ($_SERVER['PHP_SELF'] == '/eshop.php') {
				$ret .= "<small>(����������:<b>&#8734;</b>)";

				if ($user['klan'] == 'radminion') {
					$ret .= "(<b> ".$row[GetShopCount()]."</b>)";
				}

				$ret .= "</small>";
			} else {
				if (($_SERVER['PHP_SELF'] == '/shop.php') AND in_array($row['id'],$anlim_items) AND ($anlim_show)) {
					$ret .= '<small>(����������: <IMG SRC="http://i.oldbk.com/i/noobs.png" WIDTH="14" HEIGHT="8" BORDER=0 TITLE="��� ���� ������ ����� ������ � ���.��������" alt="��� ���� ������ ����� ������ � ���.��������">)</small>';
				} else {
					$ret .= "<small>(����������:<b> {$row[GetShopCount()]}</b>)</small>";
				}
			}

			if($user['prem']>0 && ($_SERVER['PHP_SELF'] == '/shop.php')) {
				$akkname[1]='Silver';
				$akkname[2]='Gold';
				$akkname[3]='Platinum';

				$cost=sprintf("%01.2f", ($row['cost']*0.9));
				$ret .= "<br><b>����: ".$cost." ��.</b> (��� ".$akkname[$user[prem]]." account)";
			}
		}

		if ($row['present'] != "�������� �����" && $row['present'] != "��������� �����" && $row['arsenal_owner'] == 0) {
			if ($row['letter'] && (($_SERVER['PHP_SELF'] == '/fshop.php') || ($row['type']==3 and $row['otdel']==6 and $row['present']==''))) {
			 	$ret .= "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span>";
			} elseif ($row['letter'] && $row['type'] == 200) {
				$ret .= "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span>";
			} elseif ($row['letter'] && (!($row['prototype']==20000 or ($row['prototype']>=55510000 and $row['prototype']<=55520000)  or ($row[otdel] >=70 AND $row[otdel] <=76) or ($row[razdel] >=70 AND $row[razdel] <=76) or $row['type']==200 or $row['type']==100 or $row[otdel]==7  or $row[razdel]==7  or ($row[prototype]>= 2014001 and $row[prototype] <= 2014008)))) {
				$ret .= "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'>".$row['letter']."</span>";
			} elseif($row['letter'] && $user['in_tower'] != 16 && $row['prototype'] != 3006000) {
				$ret .= "<br>�� ������ ������� �����: <span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span><br>���������� ��������: ".strlen($row['letter']);
			} elseif (($row['id'] == 501) OR ($row['prototype'] == 501) OR ($row['id'] == 502) OR ($row['prototype'] == 502) ) {
				$ret .=  "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'>��� ������������ �����</span>";
			}
		}


		if ($row['type'] == 30) {
			// ���������� ������� ����
			if (isset($row['ups'])) {
				$ret .= "<br><b>�������: ".$row['up_level']." </b> ����: <b><a href=\"http://oldbk.com/encicl/?/runes_opyt_table.html\" target=\"_blank\">".$row['ups']."</b></a> (".$row['add_time'].")";
			} else {
				$ret .= "<br><b>�������: ".(int)($row[up_level])." </b> ";
			}
		}

		$ret .= "<BR>�������������: ".$row['duration']."/".$row['maxdur']."<BR>";
		if ($sh_id) { $ret .= "(".$sh_id.")<br>"; }


		if (!$row['needident']) {
			// ���������� ������ � ��� �����������
			$art_param = explode(',',$row['art_param']);

			if ($row['type'] != 30) {
				 // ���� ups - ��� ��� ������������ ��� �������� ����� ���� ��� �������� �� �������
				if (($row['type'] < 12 || $row['type'] == 28) && $row['type'] != 3 and strpos($row['name'],'(��)') !== false and strpos($row['name'],'�����') === false) {
					if ($row['mfkrit'] > 0 || $row['mfakrit'] > 0 || $row['mfuvorot'] > 0 || $row['mfauvorot'] > 0) {
						$ret .= "���������: <b>".(int)($row['ups'])."/5</b> ���<BR>";
					}
				}
			}

			if ($row['gmeshok'] OR $row['gsila'] OR $row['mfkrit'] OR $row['mfakrit']  OR $row['mfuvorot'] OR $row['mfauvorot']  OR $row['glovk'] OR $row['ghp'] OR $row['ginta'] OR $row['gintel'] OR $row['gnoj'] OR $row['gtopor'] OR $row['gdubina'] OR $row['gmech'] OR $row['gfire'] OR $row['gwater'] OR $row['gair'] OR $row['gearth'] OR $row['gearth'] OR $row['glight'] OR $row['ggray'] OR $row['gdark'] OR $row['minu'] OR $row['maxu'] OR $row['bron1'] OR $row['bron2'] OR $row['bron3'] OR $row['bron4']) {
				$ret .= "<br><B>��������� ��:</b><BR>";
			}

			if ($row['minu']) {
				$ret .= "� ����������� ��������� �����������: ".$row['minu']."<BR>";
			}
			if ($row['maxu']) {
				$ret .= "� ������������ ��������� �����������: ".$row['maxu']."<BR>";
			}

			if (isset($_GET['otdel']) && in_array($_GET['otdel'],$unikrazdel) && ($_SERVER['PHP_SELF'] == "/eshop.php")) {
				if($row['gsila'] or in_array('gsila', $art_param)) {
					$ret .= "� ����: ";
					if ($row['gsila'] > 0) $ret .= "+";
					$ret .= $row['gsila'];
				}
				if($row['stbonus']>0 and ((($row['gsila'] != 0) and ($row['art_param']=='')) or in_array('gsila', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['gsila'] !=0 or in_array('gsila', $art_param)) $ret .= "<br>";


				if($row['glovk'] or in_array('glovk', $art_param)) {
					$ret .= "� ��������: ";
					if ($row['glovk']>0) $ret .= "+";
					$ret .= $row['glovk'];
				}
				if ($row['stbonus'] > 0 and ((($row['glovk'] != 0) and ($row['art_param']=='')) or in_array('glovk', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['glovk'] != 0 or in_array('glovk', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['ginta'] or in_array('ginta', $art_param)) {
					$ret .= "� ��������: ";
					if ($row['ginta'] > 0) $ret .= "+";
					$ret .= $row['ginta'];
				}
				if ($row['stbonus']>0 and ((($row['ginta'] != 0) and ($row['art_param'] == '')) or in_array('ginta', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['ginta'] != 0 or in_array('ginta', $art_param)) {
					$ret .= "<br>";
				}


				if ($row['gintel'] or in_array('gintel', $art_param)) {
					$ret .= "� ���������: ";
					if ($row['gintel'] > 0) $ret .= "+";
					$ret .= $row['gintel'];
				}
				if ($row['stbonus']>0 and ((($row['gintel'] != 0) and ($row['art_param'] == '')) or in_array('gintel', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['gintel']!=0 or in_array('gintel', $art_param)) {
					$ret .= "<br>";
				}


				if ($row['gmp'] or in_array('gmp', $art_param)) {
					$ret .= "� ��������: ";
					if($row['gmp'] > 0) $ret .= "+";
					$ret .= $row['gmp'];
				}
				if ($row['stbonus']>0 and ((($row['gmp']!=0) and ($row['art_param'] == '')) or in_array('gmp', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['gmp'] != 0 or in_array('gmp', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['ghp']) $ret .= "� ������� �����: +".$row['ghp']."<BR>";

				if ($row['mfkrit'] or in_array('mfkrit', $art_param)) {
					$ret .= "� ��. ����������� ������: ";
					if ($row['mfkrit'] > 0) $ret .= "+";
					$ret .= $row['mfkrit']."%";
				}
				if ($row['mfbonus'] > 0 and ((($row['mfkrit'] != 0) and ($row['art_param'] == '')) or in_array('mfkrit', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['mfkrit'] != 0 or in_array('mfkrit', $art_param)) {
					$ret .= "<br>";
				}


				if($row['mfakrit'] or in_array('mfakrit', $art_param)) {
					$ret .= "� ��. ������ ����. ������: ";
					if ($row['mfakrit'] > 0) $ret .= "+";
					$ret .= $row['mfakrit']."%";
				}
				if($row['mfbonus'] > 0 and ((($row['mfakrit'] != 0) and ($row['art_param']=='')) or in_array('mfakrit', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['mfakrit'] != 0 or in_array('mfakrit', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['mfuvorot'] or in_array('mfuvorot', $art_param)) {
					$ret .= "� ��. ������������: ";
					if ($row['mfuvorot'] > 0) $ret .= "+";
					$ret .= $row['mfuvorot']."%";
				}
				if ($row['mfbonus']>0 and ((($row['mfuvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfuvorot', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['mfuvorot'] != 0 or in_array('mfuvorot', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['mfauvorot'] or in_array('mfauvorot', $art_param)) {
					$ret .= "� ��. ������ ��������.: ";
					if($row['mfauvorot'] > 0) $ret .= "+";
					$ret .= $row['mfauvorot']."%";
				}
				if ($row['mfbonus'] >0 and ((($row['mfauvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfauvorot', $art_param))) {
					$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
				}
				if ($row['mfauvorot'] != 0 or in_array('mfauvorot', $art_param)) {
					$ret .= "<br>";
				}
			} elseif ($_SERVER['PHP_SELF'] != '/main.php' && $_SERVER['PHP_SELF'] != '/__main.php') {
				  // �� ���������� "+" ��� ������ - � �������� ������ � main.php
				if ($row['gsila'] > 0) {
					$ret .= "� ����: +".$row['gsila']."<br>";
				} elseif ($row['gsila'] < 0) {
					$ret .= "� ����: ".$row['gsila']."<br>";
				}

				if ($row['glovk'] > 0) {
					$ret .= "� ��������: +".$row['glovk']."<br>";
				} elseif ($row['glovk'] < 0) {
					$ret .= "� ��������: ".$row['glovk']."<br>";
				}

				if ($row['ginta'] > 0) {
					$ret .= "� ��������: +".$row['ginta']."<br>";
				} elseif ($row['ginta'] < 0) {
					$ret .= "� ��������: ".$row['ginta']."<br>";
				}

				if ($row['gintel'] > 0) {
					$ret .= "� ���������: +".$row['gintel']."<br>";
				} elseif ($row['gintel'] < 0) {
					$ret .= "� ���������: ".$row['gintel']."<br>";
				}

				if ($row['gmp'] > 0) {
					$ret .= "� ��������: +".$row['gmp']."<br>";
				} elseif ($row['gmp'] < 0) {
					$ret .= "� ��������: ".$row['gmp']."<br>";
				}

				if ($row['ghp'] > 0) {
					$ret .= "� ������� �����: +".$row['ghp']."<br>";
				} elseif ($row['ghp'] < 0) {
					$ret .= "� ������� �����: ".$row['ghp']."<br>";
				}

				if ($row['mfkrit'] > 0) {
					$ret .= "� ��. ����������� ������: +".$row['mfkrit']."%<br>";
				} elseif ($row['mfkrit'] < 0) {
					$ret .= "� ��. ����������� ������: ".$row['mfkrit']."%<br>";
				}


				if ($row['mfakrit'] > 0) {
					$ret .= "� ��. ������ ����. ������: +".$row['mfakrit']."%<br>";
				} elseif ($row['mfakrit'] < 0) {
					$ret .= "� ��. ������ ����. ������: ".$row['mfakrit']."%<br>";
				}

				if ($row['mfuvorot'] > 0) {
					$ret .= "� ��. ������������: +".$row['mfuvorot']."%<br>";
				} elseif ($row['mfuvorot'] < 0) {
					$ret .= "� ��. ������������: ".$row['mfuvorot']."%<br>";
				}

				if ($row['mfauvorot'] > 0) {
					$ret .= "� ��. ������ ��������.: +".$row['mfauvorot']."%<br>";
				} elseif ($row['mfauvorot'] < 0) {
					$ret .= "� ��. ������ ��������.: ".$row['mfauvorot']."%<br>";
				}
			} else {
				if($row['gsila'] or in_array('gsila', $art_param)) {
					$ret .= "� ����: ";
					if ($row['gsila'] > 0) $ret .= "+";
					$ret .= $row['gsila'];
				}
				if($row['stbonus']>0 and ((($row['gsila'] != 0) and ($row['art_param']=='')) or in_array('gsila', $art_param))) {
					$ret .= "<a href='?edit=1&sila=1&setup=".$row['id']."'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['gsila'] !=0 or in_array('gsila', $art_param)) $ret .= "<br>";


				if($row['glovk'] or in_array('glovk', $art_param)) {
					$ret .= "� ��������: ";
					if ($row['glovk']>0) $ret .= "+";
					$ret .= $row['glovk'];
				}
				if ($row['stbonus'] > 0 and ((($row['glovk'] != 0) and ($row['art_param']=='')) or in_array('glovk', $art_param))) {
					$ret .= "<a href='?edit=1&lovk=1&setup=".$row['id']."'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['glovk'] != 0 or in_array('glovk', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['ginta'] or in_array('ginta', $art_param)) {
					$ret .= "� ��������: ";
					if ($row['ginta'] > 0) $ret .= "+";
					$ret .= $row['ginta'];
				}
				if ($row['stbonus']>0 and ((($row['ginta'] != 0) and ($row['art_param'] == '')) or in_array('ginta', $art_param))) {
					$ret .= "<a href='?edit=1&inta=1&setup=".$row['id']."'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['ginta'] != 0 or in_array('ginta', $art_param)) {
					$ret .= "<br>";
				}


				if ($row['gintel'] or in_array('gintel', $art_param)) {
					$ret .= "� ���������: ";
					if ($row['gintel'] > 0) $ret .= "+";
					$ret .= $row['gintel'];
				}
				if ($row['stbonus']>0 and ((($row['gintel'] != 0) and ($row['art_param'] == '')) or in_array('gintel', $art_param))) {
					$ret .= "<a href='?edit=1&intel=1&setup=".$row['id']."'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['gintel']!=0 or in_array('gintel', $art_param)) {
					$ret .= "<br>";
				}


				if ($row['gmp'] or in_array('gmp', $art_param)) {
					$ret .= "� ��������: ";
					if($row['gmp'] > 0) $ret .= "+";
					$ret .= $row['gmp'];
				}
				if ($row['stbonus']>0 and ((($row['gmp']!=0) and ($row['art_param'] == '')) or in_array('gmp', $art_param))) {
					$ret .= "<a href='?edit=1&gmp=1&setup=".$row['id']."'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['gmp'] != 0 or in_array('gmp', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['ghp']) $ret .= "� ������� �����: +".$row['ghp']."<BR>";

				if ($row['mfkrit'] or in_array('mfkrit', $art_param)) {
					$ret .= "� ��. ����������� ������: ";
					if ($row['mfkrit'] > 0) $ret .= "+";
					$ret .= $row['mfkrit']."%";
				}
				if ($row['mfbonus'] > 0 and ((($row['mfkrit'] != 0) and ($row['art_param'] == '')) or in_array('mfkrit', $art_param))) {
					$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ����\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&krit=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['mfkrit'] != 0 or in_array('mfkrit', $art_param)) {
					$ret .= "<br>";
				}


				if($row['mfakrit'] or in_array('mfakrit', $art_param)) {
					$ret .= "� ��. ������ ����. ������: ";
					if ($row['mfakrit'] > 0) $ret .= "+";
					$ret .= $row['mfakrit']."%";
				}
				if($row['mfbonus'] > 0 and ((($row['mfakrit'] != 0) and ($row['art_param']=='')) or in_array('mfakrit', $art_param))) {
					$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ��������\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&akrit=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['mfakrit'] != 0 or in_array('mfakrit', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['mfuvorot'] or in_array('mfuvorot', $art_param)) {
					$ret .= "� ��. ������������: ";
					if ($row['mfuvorot'] > 0) $ret .= "+";
					$ret .= $row['mfuvorot']."%";
				}
				if ($row['mfbonus']>0 and ((($row['mfuvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfuvorot', $art_param))) {
					$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ������\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&uvorot=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['mfuvorot'] != 0 or in_array('mfuvorot', $art_param)) {
					$ret .= "<br>";
				}

				if ($row['mfauvorot'] or in_array('mfauvorot', $art_param)) {
					$ret .= "� ��. ������ ��������.: ";
					if($row['mfauvorot'] > 0) $ret .= "+";
					$ret .= $row['mfauvorot']."%";
				}
				if ($row['mfbonus'] >0 and ((($row['mfauvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfauvorot', $art_param))) {
					$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ����������\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&auvorot=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
				}
				if ($row['mfauvorot'] != 0 or in_array('mfauvorot', $art_param)) {
					$ret .= "<br>";
				}

			}

			if($row['present'] != '') {
				$prez = explode(':|:',$row['present']);
			}

			if($row['gnoj']) $ret .= "� ���������� �������� ������ � ���������: +".$row['gnoj']."<BR>";
			if($row['gtopor']) $ret .= "� ���������� �������� �������� � ��������: +".$row['gtopor']."<BR>";
			if($row['gdubina']) $ret .= "� ���������� �������� �������� � ��������: +".$row['gdubina']."<BR>";
			if($row['gmech']) $ret .= "� ���������� �������� ������: +".$row['gmech']."<BR>";
			if($row['gfire']) $ret .= "� ���������� �������� ������� ����: +".$row['gfire']."<BR>";
			if($row['gwater']) $ret .= "� ���������� �������� ������� ����: +".$row['gwater']."<BR>";
			if($row['gair']) $ret .= "� ���������� �������� ������� �������: +".$row['gair']."<BR>";
			if($row['gearth']) $ret .= "� ���������� �������� ������� �����: +".$row['gearth']."<BR>";
			if($row['glight']) $ret .= "� ���������� �������� ������ �����: +".$row['glight']."<BR>";
			if($row['ggray']) $ret .= "� ���������� �������� ����� ������: +".$row['ggray']."<BR>";
			if($row['gdark']) $ret .= "� ���������� �������� ������ ����: +".$row['gdark']."<BR>";
			if($row['bron1']) $ret .= "� ����� ������: ".$row['bron1']."<BR>";
			if($row['bron2']) $ret .= "� ����� �������: ".$row['bron2']."<BR>";
			if($row['bron3']) $ret .= "� ����� �����: ".$row['bron3']."<BR>";
			if($row['bron4']) $ret .= "� ����� ���: ".$row['bron4']."<BR>";
			if($row['gmeshok']) $ret .= "� ����������� ������: +".$row['gmeshok']."<BR>";


			if ($row['stbonus'] > 0) {
				$ret .= "��������� ����������: <b>".$row['stbonus']."</b><BR>";
			}
			if ($row['mfbonus'] > 0) {
				$ret .= "��������� ���������� ��: <b>".$row['mfbonus']."</b><BR>";
			}

			if ($row['nsila'] OR $row['nlovk'] OR $row['ninta'] OR $row['nvinos'] OR $row['nlevel'] OR ($incmagic['max'] && $incmagic['nlevel'] > 0) OR $row['nintel'] OR $row['nmudra'] OR $row['nnoj'] OR $row['ntopor'] OR $row['ndubina'] OR $row['nmech'] OR $row['nfire'] OR $row['nwater'] OR $row['nair'] OR $row['nearth'] OR $row['nearth'] OR $row['nlight'] OR $row['ngray'] OR $row['ndark']) {
				$ret .= "<br><b>��������� �����������:</b><BR>";
			}

			if ($row['nsex'] == 1) {
				$ret .= "� ���: <b>�������</b><br>";
			}

			if ($row['nsex'] == 2) {
				$ret .= "� ���: <b>�������</b><br>";
			}

		if ($row['nclass'] >0)
			{
				if ($nclass_name[$row['nclass']]!='')
				{
					if (($row['nclass']!=$user['uclass']) and ($row['nclass']!=4))
					{
					$ret .= "� <font color=\"red\">����� ���������: <b>{$nclass_name[$row['nclass']]}</b></font><br>";
					}
					else
					{
					$ret .= "� ����� ���������: <b>{$nclass_name[$row['nclass']]}</b><br>";
					}
				}
			}



			if ($row['nsila'] > 0) {
				$ret .= "� ";
				if ($row['nsila'] > $user['sila']) {
					$ret .= '<font color="red">����: '.$row['nsila'].'</font>';
				} else {
					$ret .= '����: '.$row['nsila'];
				}
				$ret .= "<BR>";
			}
			if ($row['nlovk'] > 0) {
				$ret .= "� ";
				if ($row['nlovk'] > $user['lovk']) {
					$ret .= '<font color="red">��������: '.$row['nlovk'].'</font>';
				} else {
					$ret .= '��������: '.$row['nlovk'];
				}
				$ret .= "<BR>";
			}
			if ($row['ninta'] > 0) {
				$ret .= "� ";
				if ($row['ninta'] > $user['inta']) {
					$ret .= '<font color="red">��������: '.$row['ninta'].'</font>';
				} else {
					$ret .= '��������: '.$row['ninta'];
				}
				$ret .= "<BR>";
			}
			if ($row['nvinos'] > 0) {
				$ret .= "� ";
				if ($row['nvinos'] > $user['vinos']) {
					$ret .= '<font color="red">������������: '.$row['nvinos'].'</font>';
				} else {
					$ret .= '������������: '.$row['nvinos'];
				}
				$ret .= "<BR>";
			}
			if ($row['nlevel'] > 0 || ($incmagic['max'] && $incmagic['nlevel'] > 0)) {
				$ret .= "� ";
				if ($row['nlevel'] >= $incmagic['nlevel'] )
				{
					if ($row['nlevel'] > $user['level']) {
						$ret .= '<font color="red">�������: '.$row['nlevel'].'</font>';
					} else {
						$ret .= '�������: '.$row['nlevel'];
					}
				} else {
					if ($incmagic['nlevel'] > $user['level']) {
						$ret .= '<font color="red">�������: '.$incmagic['nlevel'].'</font>';
					} else {
						$ret .= '�������: '.$incmagic['nlevel'];
					}
				}
				$ret .= "<BR>";
			}
			if ($row['nintel'] > 0) {
				$ret .= "� ";
				if ($row['nintel'] > $user['intel']) {
					$ret .= '<font color="red">���������: '.$row['nintel'].'</font>';
				} else {
					$ret .= '���������: '.$row['nintel'];
				}
				$ret .= "<BR>";
			}
			if ($row['nmudra'] > 0) {
				$ret .= "� ";
				if ($row['nmudra'] > $user['mudra']) {
					$ret .= '<font color="red">��������: '.$row['nmudra'].'</font>';
				} else {
					$ret .= '��������: '.$row['nmudra'];
				}
				$ret .= "<BR>";
			}
			if ($row['nnoj'] > 0) {
				$ret .= "� ";
				if ($row['nnoj'] > $user['noj']) {
					$ret .= '<font color="red">���������� �������� ������ � ���������: '.$row['nnoj'].'</font>';
				} else {
					$ret .= '���������� �������� ������ � ���������: '.$row['nnoj'];
				}
				$ret .= "<BR>";
			}
			if ($row['ntopor'] > 0) {
				$ret .= "� ";
				if ($row['ntopor'] > $user['topor']) {
					$ret .= '<font color="red">���������� �������� �������� � ��������: '.$row['ntopor'].'</font>';
				} else {
					$ret .= '���������� �������� �������� � ��������: '.$row['ntopor'];
				}
				$ret .= "<BR>";
			}
			if ($row['ndubina'] > 0) {
				$ret .= "� ";
				if ($row['ndubina'] > $user['dubina']) {
					$ret .= '<font color="red">���������� �������� �������� � ��������: '.$row['ndubina'].'</font>';
				} else {
					$ret .= '���������� �������� �������� � ��������: '.$row['ndubina'];
				}
				$ret .= "<BR>";
			}
			if ($row['nmech'] > 0) {
				$ret .= "� ";
				if ($row['nmech'] > $user['mec']) {
					$ret .= '<font color="red">���������� �������� ������: '.$row['nmech'].'</font>';
				} else {
					$ret .= '���������� �������� ������: '.$row['nmech'];
				}
				$ret .= "<BR>";
			}
			if ($row['nfire'] > 0) {
				$ret .= "� ";
				if ($row['nfire'] > $user['mfire']) {
					$ret .= '<font color="red">���������� �������� ������� ����: '.$row['nfire'].'</font>';
				} else {
					$ret .= '���������� �������� ������� ����: '.$row['nfire'];
				}
				$ret .= "<BR>";
			}
			if ($row['nwater'] > 0) {
				$ret .= "� ";
				if ($row['nwater'] > $user['mwater']) {
					$ret .= '<font color="red">���������� �������� ������� ����: '.$row['nwater'].'</font>';
				} else {
					$ret .= '���������� �������� ������� ����: '.$row['nwater'];
				}
				$ret .= "<BR>";
			}
			if ($row['nair'] > 0) {
				$ret .= "� ";
				if ($row['nair'] > $user['mair']) {
					$ret .= '<font color="red">���������� �������� ������� �������: '.$row['nair'].'</font>';
				} else {
					$ret .= '���������� �������� ������� �������: '.$row['nair'];
				}
				$ret .= "<BR>";
			}
			if ($row['nearth'] > 0) {
				$ret .= "� ";
				if ($row['nearth'] > $user['mearth']) {
					$ret .= '<font color="red">���������� �������� ������� �����: '.$row['nearth'].'</font>';
				} else {
					$ret .= '���������� �������� ������� �����: '.$row['nearth'];
				}
				$ret .= "<BR>";
			}
			if ($row['nlight'] > 0) {
				$ret .= "� ";
				if ($row['nlight'] > $user['mlight']) {
					$ret .= '<font color="red">���������� �������� ������ �����: '.$row['nlight'].'</font>';
				} else {
					$ret .= '���������� �������� ������ �����: '.$row['nlight'];
				}
				$ret .= "<BR>";
			}
			if ($row['ngray'] > 0) {
				$ret .= "� ";
				if ($row['ngray'] > $user['mgray']) {
					$ret .= '<font color="red">���������� �������� ����� ������: '.$row['ngray'].'</font>';
				} else {
					$ret .= '���������� �������� ����� ������: '.$row['ngray'];
				}
				$ret .= "<BR>";
			}
			if ($row['ndark'] > 0) {
				$ret .= "� ";
				if ($row['ndark'] > $user['mdark']) {
					$ret .= '<font color="red">���������� �������� ������ ����: '.$row['ndark'].'</font>';
				} else {
					$ret .= '���������� �������� ������ ����: '.$row['ndark'];
				}
				$ret .= "<BR>";
			}

			if ($row['magic'] == 8888) {
				$ret .= "� �������, ������, ����������� ����������<br>";
			}

			// �����������
			if (
				$row['prokat_idp']>0 ||
				($magic['img'] && $row['type'] == 12 && $row['labonly']==0 && $row['dategoden'] == 0) ||
				((!$magic['img'] || $row['labonly']==1 || $row['dategoden'] > 0) && $row['type'] == 12) ||
				($magic['name'] && ($magic['us_type'] > 0 || $magic['target_type'] > 0)) ||
				$row['labonly'] == 1 ||
				!$row['isrep'] ||
				$row['sowner'] > 0 ||
				$row['goden'] ||
				$row['present'] == "�������� �����" ||
				$row['arsenal_owner'] != 0 ||
				$row['naem'] > 0 || $row['craftnaem'] > 0
			) {
				$ret .= "<br><b>�����������:</b><br>";
			}


		        if($row['naem'] > 0 || $row['craftnaem'] > 0) {
				$naemid = $row['naem'] ? $row['naem'] : $row['craftnaem'];
				$so = mysql_query_cache('SELECT * from naem_proto WHERE id = '.$naemid,false,600);
				if (count($so)) {
					$so = $so[0];
		        		$naem = s_nicknaem($so['id'],$so['align'],$so['klan'],$so['login']);
					$ret .= '<font color=red>������ ���� ����� ����� ������ ������</font> '.$naem.'<br>';
				} else {
					$ret .= '<font color=red>������ ���� ����� ����� ������ ������</font><br>';
				}

				$ret .= "<font color=maroon>������� �� �������� �����������</font><BR>";
				$ret .= "<font color=maroon>������� �� �������� ���������</font><BR>";
				$ret .= "<font color=maroon>������� ������ ���������</font><BR>";
				if ($row['type'] == 3) $ret .= "<font color=maroon>������� ������ ��������</font><BR>";
				$ret .= "<font color=maroon>������� ������ ��������</font><BR>";
				$ret .= "<font color=maroon>������� ������ �������, �������� ��� ��������</font><BR>";

			}

		        if($row['sowner'] > 0) {
				if($row['sowner'] != $user['id']) {
					$so = mysql_query_cache('SELECT * from oldbk.users WHERE id = '.$row['sowner'].' AND id_city = 0',false,600);
					if (!count($so)) {
			        		$so = mysql_query_cache('SELECT * from avalon.users WHERE id = '.$row['sowner'].' AND id_city = 1',false,600);
					}
					if (!count($so)) {
			        		$so = mysql_query_cache('SELECT * from angels.users WHERE id = '.$row['sowner'].' AND id_city = 2',false,600);
					}

					if (count($so)) {
						$so = $so[0];
			        		$sowner = s_nick($so['id'],$so['align'],$so['klan'],$so['login'],$so['level']);
					}
		        	} else {
			        	$sowner = s_nick($user['id'],$user['align'],$user['klan'],$user['login'],$user['level']);
				}

		        	if ($row['type'] == 250) {
		        		$ret .= '<font color=red>������ ���� �����������</font> '.$sowner.'<br>';
				} elseif ($row['type'] == 210) {
					$ret .= '<font color=red>������ ���� ����� ������������</font> '.$sowner.'<br>';
				} elseif ($row['type'] == 200) {
					$ret .= '<font color=red>���� ������� ����� �������� ������</font> '.$sowner.'<br>';
				} elseif (($row['prototype'] >=56661) and  ($row['prototype'] <=56663)) {
					$ret .= '<font color=red>����� ������������� �� �������, �� ������ �������� � ��������� '.$sowner.'</font><br>';
				} else {
		        		$ret .= '<font color=red>������ ���� ����� ������ ������</font> '.$sowner.'<br>';
				}
			}


			if ($row['present'] == "�������� �����" || $row['present'] == "��������� �����" || $row['arsenal_owner'] == 1) {
			 	$ret .= "<span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span><br>";
			}

			if ($row['goden']) {
				$ret .= "� ���� ��������: {$row['goden']} ��. ";
				if (!$row[GetShopCount()] or $_SERVER['PHP_SELF'] == '/comission.php' or ($_SERVER['PHP_SELF'] == '/main.php' || $_SERVER['PHP_SELF'] == '/__main.php') or $_SERVER['PHP_SELF'] == '/fair.php') {
					$ret .= "(�� ".date("d.m.Y H:i",$row['dategoden']).")";
				}
				$ret .= "<BR>";
			}


			if (($row_prototype==949)||($row_prototype==950)||($row_prototype==951)) {
				$ret .='<small><font color=red>���������� �������� ����� ���� ������� ��������� � ����� ������ ������</font></small><br>';
			} elseif ((($row_prototype>=946) and ($row_prototype <=957))) {
				$ret .='<small><font color=red>���������� �������� ����� ���� ������� ���������</font></small><br>';
			}


			if ((($row['is_owner']==1) and ($row['id']>=56661 ) and ($row['id']<=56664 ) ) and ($check_price && $priv)) {
				$ret .= '<small><font color=red>����� ������������� �� �������, �� ������ �������� � ���������!</font></small>';
			} elseif($check_price && $priv) {
				$ret .= '<small><font color=red>����� ������� ���� ����� ��������� � ���������.</font></small>';
			} elseif ($row['is_owner']==1) {
				$ret .= '<small><font color=red>����� ������� ���� ����� ��������� � ���������.</font></small>';
			} elseif (($_SERVER['PHP_SELF'] == '/cshop.php') AND ($row['id'] == 1000001 || $row['id'] == 1000002 || $row['id'] == 1000003)) {
				$ret .= '<small><font color=red>����� ������� ������� ����� ���������� ��������.</font></small>';
			}

			if (!(isset($row['prototype']))) {
				$row['prototype'] = $row['id'];
			}

			if ($row['id'] == 56663 || $row['id'] == 56664 || $row['prototype'] == 56663 || $row['prototype'] == 56664) {
				$ret .= '<small><font color=red>����� ������������� �� �������, �� ������ �������� � ���������!</font></small><br>';
			}


			if($row['prokat_idp']>0) $ret .= "� ��������: ".floor(($row['prokat_do']-time())/60/60)." �. ".round((($row['prokat_do']-time())/60)-(floor(($row['prokat_do']-time())/3600)*60))." ���.<br>";
			if($magic['img'] && $row['type'] == 12 && $row['labonly']==0 && $row['dategoden'] == 0 && (in_array($row['id'],$can_inc_magic) OR in_array($row['prototype'],$can_inc_magic) )   ) $ret .= "� ����� ������������ � ����<BR>";
			if((!$magic['img'] || $row['labonly']==1 || $row['dategoden'] > 0 || (!(in_array($row['id'],$can_inc_magic) OR in_array($row['prototype'],$can_inc_magic) )) ) && $row['type'] == 12 ) $ret .= "� �� ����� ������������ � ����<BR>";

			if ($row['magic'] == 8888) {
				$ret .=  "� ����� ���� ����������� ������ �� ���� �������<br>";
			}

			if($magic['name'] && $magic['us_type'] == 2) $ret .= "� ����� ������������ ������ ��� ���<BR>";
			if($magic['name'] && $magic['us_type'] == 1) $ret .= "� ����� ������������ ������ � ���<BR>";
			if($magic['name'] && $magic['target_type'] == 1) $ret .= "� ����� ������������ ������ �� ����<BR>";

			if ($row['labonly']==1) {
				$ret .= "<font color=maroon>������� �������� ����� ������ �� ���������</font><BR>";
			}
			if(!$row['isrep']) {
				$ret .= "<font color=maroon>������� �� �������� �������</font><BR>";
			}

			if ((($row_prototype>=946) and ($row_prototype <=957)))	{
				$ret .= "<font color=maroon>������� �� �������� �����������</font><BR>";
				$ret .= "<font color=maroon>������� �� �������� ������</font><BR>";
			}


			// ��������
			if (
				($row['id'] == 30012) OR ($row['prototype'] == 30012) ||
				(($row['id'] == 501) OR ($row['prototype'] == 501) OR ($row['id'] == 502) OR ($row['prototype'] == 502)) ||
				($magic['name'] && $row['type'] == 50) ||
				$row['rareitem'] > 0 ||
				$row['present'] ||
				$row['type'] == 27 ||
				$row['type'] == 34 ||
				$row['type'] == 35 ||
				$row['type'] == 28 ||
				$row['unik'] == 1 ||
				(($row['unik']==2) and ($row['type']!=200)) ||
				($magic['name'] && $row['type'] != 50) ||
				($row['text'] && $row[type]==3) ||
				($row['text'] && $row[type]==5)	||
				$row['present_text'] ||
				$incmagic['max'] ||
				$magic['chanse'] ||
				$magic['time']
			) {
				$ret .= "<br><b>��������:</b><br>";
			}

			if ($row['art_proto_id']>0)
			{
			$protorow=$row;
			$protorow['img']=$row['art_proto_img'];
			$protorow['art_param']='';
			$protorow['name']=$row['art_proto_name'];
			$ret .= "�������� ���������: ".link_for_item($protorow)."<br>";
			}



			if ($row['type'] == 27)	{
				$ret .= "� ����� �������� ��� �����<br>";
			} elseif ($row['type'] == 28) {
				$ret .= "� ����� �������� ��� �����<br>";
			} elseif ($row['type'] == 34) {
				$ret .= "� ������ ������<br>";
			} elseif ($row['type'] == 35) {
				$ret .= "� ��������� ������<br>";
			}

			if ($magic['name'] && $row['type'] == 50) {
				if (stripos(substr($magic['name'],0,-4),'<br>') !== false) {
					$ret .= "� ".$magic['name'];
				} else {
					$ret .= "� ".$magic['name']."<BR>";
				}
			}


			if (($row['id'] == 30012) OR ($row['prototype'] == 30012)) {
				$ret .=  "� � ��� ���� ����������� ���� �������� ������<br>";
			}

			if($magic['name'] && $row['type'] != 50) $ret .= "<font color=maroon>�������� ��������:</font> ".$magic['name']."<BR>";

			if($row['unik']==1) {
				$ret .= "<font color=maroon><small><b>���� � ���������� ������������</b></small></font><br>";
			} elseif(($row['unik']==2) and ($row['type']!=200))  {
				$ret .= "<font color=#990099><small><b>���� � ���������� ���������� ������������</b></small></font><br>";
			}

			if($row['present']) $ret .= "������� ��: <b>".$prez[0]."</b><br>";

			if ($row['text'] && $row[type]==3) {
				$ret .= "�� ����� ������������� �������: ".$row['text']."<BR>";
			}
			if ($row['text'] && $row[type]==5) {
				$ret .= "�� ������ ������������� �������: ".$row['text']."<BR>";
			}
			if ($row['present_text']) {
				$ret .= "�� ������� ������� �����: ".$row['present_text']."<BR>";
			}
			if ($incmagic['max']) {
				$ret .= "�������� �������� <img src=\"http://i.oldbk.com/i/magic/".$incmagic['img']."\" title=\"".$incmagic['name']."\"> ".$incmagic['cur']."/".$incmagic['max']." ��.<BR> ";
				$ret .= "���������� �����������: ".$incmagic['uses']."<br>";

			}
			if ($magic['chanse']) {
				$ret .= "����������� ������������: ".$magic['chanse']."%<BR>";
			}
			if ($magic['time']) {
				$ret .= "����������������� �������� �����: ".get_delay_time($magic['time'])." <BR>";
			}

			if ($row['rareitem'] == 1) {
				$ret .= '<font color="#34a122"><b>������ �������</b></font><BR>';
			}
			if ($row['rareitem'] == 2) {
				$ret .= '<font color="#2145ad"><b>������� �������</b></font><BR>';
			}
			if ($row['rareitem'] == 3) {
				$ret .= '<font color="#760c90"><b>����������� �������</b></font><BR>';
			}
		} else {
			$ret .= "<font color=maroon><B>�������� �������� �� ����������������</B></font><BR>";
		}

		// ������ ������� �������

		//@TODO places ������� � ����� ���������� �����, ����� �������� � LocationHelper::getPlace($place_id) (c) ����
		$places = array(
			1 => '������� ������ �� �������',
			2 => '������� ������� � ������� �����',
			3 => '������� ������� �� ����������� ����',
			4 => '������� ������� �� �������� �������',
			5 => '������� ������� �� ���������� �������',
			6 => '������� ������� �� ������� �����',
			7 => '������� ������� � ������� ������� ��� ���������',
			8 => '������� ������� �� ������ ������� �����',
			9 => '������� ������� - �����',
			10 => '������� ������� - �� ����� � ���������� �����',
			11 => '������� ������� � �������� ��������� �����',
			12 => '������� ������� � ������������ ��������� �����',
			13 => '������� ������� � ���������� ����� ��������',
			14 => '������� ������� � ���������� �����',
			20 => '������� ������� - ������� �������',
			21 => '������� ������� � ������� ���������� �����',
			30 => '������� ������� �� ������ �����',
			31 => '������� ������� �� ���������� ��������',
			32 => '������� ������� �� ���� ���-2018�',
			33 => '������� ������� �� ����������� ����',
			34 => '������� ������� �� ��������� ����������� ��������',
			35 => '������� ������� �� ������������ �����',
			36 => '������� ������� �� ������� �7 ��� �����!�',
			37 => '������� ������� �� ��������� ������ ������� �����',
			38 => '������� ������� �� ������� �8 ��� �����!�',
			40 => '������� ������� � ��������',
			41 => '������� ������ � ���.��������',
			42 => '������� ������ � �������',
			43 => '������� ������ � �������� �����',
			44 => '������� ���� � ������ � ��������� �����',
			45 => '������� ������ � ������ ������� �����',
			46 => '������� ������� �� ���������',
			47 => '������� ������� �� ������ �����',
			48 => '������� ������� �� ������������� ������ �����',
			56 => '������� ������� �� ���������� ��������' ,
			57 => '������� ������� � ���' ,
			77 => '������� ������� �� 7-�� ��������� �����',
			91 => '������� ���������� � ������� �������-����',
			92 => '������� ���������� � ������� �������-����',
			93 => '������� ���������� � ����������� ����� � ��������� �������-����',
			94 => '������� ���������� � ���������� �������� � ������� �������-����',
			95 => '������� ���������� � ���������� �������� �������-����',
			107 => '������� ������� �� ������� �������',
			108 => '������� ������� �� ������� ����������',
			109 => '������� ������� �� ������� �����',
			110 => '������� ������� �� ������� �������� �����',
			111 => '������� ������� �� ������� �������� �����',
			112 => '������� ������� �� ������� ������������ �����',
			113 => '������� ������� �� ������� ��������� ����',
			114 => '������� ������� �� ������� ������������ �����',
			120 => '������� ������� �� ����������� �����',
			121 => '������� ������� �� ���������� �����',
			122 => '������� ������� �� �������� �����',
			130 => '������� ������� �� ������� � ���������� � ����� �����������',
			131 => '������� ������� �� ����������� ���� �������',
			132 => '������� ������� �� �������� ����������� ����',
			141 => '������� ������� �� ������ ��������',
			142 => '������� ������� �� ��������� �����',
			143 => '������� ������� �� ����������� �������',
			144 => '������� ������� �� ������ �������',
      145 => '������� ������� �� ����� � ���������',
			151 => '������� ������� �� ������ ������������ �������',
			152 => '������� ������� �� �������� ������������ �������',
			153 => '������� ������� �� �������� ������������ �������',
			154 => '������� ������� �� ������������ ������������ �������',
			160 => '������� ������� �� ����� ������ ������� ����������',
			161 => '������� ������� �� ������� ������ ������� ����������',
			162 => '������� ������� �� ������� ������ ������� ����������',
			163 => '������� ������� �� ����������� ������ ������� ����������',

			//������ 200-300 ��� �������� (����)
			200 => '������� ������� �� ������� � �������� ��������� ���',
		);

		if (isset($places[$row['getfrom']])) {
		    $ret .= '<small><font color=maroon><b>'.$places[$row['getfrom']].'</b></font></small><BR>';
		}


		if  (($row['ab_mf'] > 0) or ($row['ab_bron'] > 0) or ($row['ab_uron']>0) || ($row['prototype'] >= 55510301 && $row['prototype'] <= 55510401) || ($row['prototype'] == 410027) ) {
			$ret .= "��������:<br>";
			if ($row['ab_mf'] > 0) $ret .= "� ������������� ��.:+".$row['ab_mf']."%<br>";
			if ($row['ab_bron'] > 0) $ret .= "� �����:+".$row['ab_bron']."%<br>";
			if ($row['ab_uron'] > 0) $ret .= "� �����:+".$row['ab_uron']."%<br>";

			/*
			$ekr_elka = array(55510312,55510313,55510314,55510315,55510316,55510317,55510318,55510319,55510320,55510321,55510322,55510334,55510335,55510336,55510337,55510338,55510339);
			$art_elka = array(55510323,55510324,55510325,55510326,55510327,55510340,55510341,55510342,55510343,55510344);
			*/

			$ekr_elka = array(55510350);
			$art_elka = array(55510351);
			$sart_elka = array(55510352);

			$elkabonus = 0;
			if (($row['prototype'] >= 410021 AND $row['prototype'] <= 410026) AND (time()>mktime(0,0,0,7,5,2017))  )
			{
				// ����� ������� ����� ������� �����
				$elkabonus = 10;
			}
			elseif ((($row['prototype'] >= 55510301) AND ($row['prototype'] <= 55510311)) || (($row['prototype'] >= 55510328) AND ($row['prototype'] <= 55510333))) {
				//�������� ����
				$elkabonus = 1;
			} elseif (in_array($row['prototype'],$ekr_elka)) {
				//������� ����
				$elkabonus = 2;
			} elseif (in_array($row['prototype'],$art_elka)) {
				//������� ����
				$elkabonus = 3;
			} elseif (in_array($row['prototype'],$sart_elka)) {
				$elkabonus = 10;
			} elseif ($row['prototype'] == 410027) {
				$elkabonus = 5;
			} elseif ($row['prototype'] == 410028) {
				$elkabonus = 10;
			}


			if ($elkabonus > 0) {
				$ret .= "� ������� �����: +".$elkabonus."%<br>";
			}
		} elseif (($_SERVER['PHP_SELF'] == '/cshop.php') AND (($row['id']>=6000) AND ($row['id'] <=6017))) {
			$runs_5lvl_param=array(
					"6000" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
					"6001" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
					"6002" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
					"6003" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
					"6004" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
					"6005" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
					"6006" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
					"6007" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
					"6008" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
					"6009" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
					"6010" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
					"6011" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
					"6012" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
					"6013" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
					"6014" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
					"6015" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
					"6016" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
					"6017" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			);

			//������ ����������� ��� � cshop
			$ab = $runs_5lvl_param[$row[id]];
			$ret .= "��������:<br>";

			if ($ab['ab_mf'] > 0) $ret .= "� ������������� ��.:0%<br>";
			if ($ab['ab_bron'] > 0) $ret .= "� �����:0%<br>";
			if ($ab['ab_uron'] > 0) $ret .= "� �����:0%<br>";
		}



		if (get_rkm_bonus_by_magic($row['magic'])>0)
			{
			$ret .= "� ������� ����� �� ���. �����: +".get_rkm_bonus_by_magic($row['magic'])."%<br>";
			}


		//����������� ��������� �� �����
		if (($row['bonus_info']!='') or ($row['charka']!='') )
		{
			$bohtml=array(
					'bron1' => '����� ������',
					'bron2' => '����� �������',
					'bron3' => '����� �����',
					'bron4' => '����� ���',
					'ghp' =>'������� �����' ,
					'mfkrit' =>'��. ����������� ������' ,
					'mfakrit' => '��. ������ ����. ������' ,
					'mfuvorot' => '��. ������������',
					'mfauvorot' =>'��. ������ ��������.',
					'gsila' =>'����' ,
					'glovk' => '��������' ,
					'ginta' => '��������',
					'gintel' =>'���������',
					'gmp' =>'��������',

					'fstat' =>'��������� ����������',
					'fmf' =>  '��������� ���������� ��' ,
					'stbonus' =>'��������� ����������',
					'mfbonus' =>  '��������� ���������� ��' ,

					'gw' => '���������� �������� �������' ,
					'gm' => '���������� ���������� c�����',

					'gnoj' =>'���������� �������� ������ � ���������' ,
					'gtopor' =>'���������� �������� �������� � ��������',
					'gdubina' => '���������� �������� ��������, ��������',
					'gmech' =>'���������� �������� ������',
					'gfire' =>'���������� ���������� c����� ����',
					'gwater' => '���������� ���������� c����� ����',
					'gair' => '���������� ���������� c����� �������',
					'gearth' => '���������� ���������� c����� �����',
					'ab_mf' =>'�������� ������������� ��',
					'ab_bron' => '�������� �����',
					'ab_uron' => '�������� �����');

			$pp=array(
					'mfkrit' =>'%' ,
					'mfakrit' => '%' ,
					'mfuvorot' => '%',
					'mfauvorot' =>'%',
					'mfbonus' =>'%',
					'ab_mf' =>'%',
					'ab_bron' => '%',
					'ab_uron' => '%');

			if ($row['bonus_info']!='')
			{
				$inputbonus=unserialize($row['bonus_info']); //��� ������
				if (is_array($inputbonus))
				{
					$ret .= "<small><b><a onclick=\"showhide('art_{$row['id']}');\" href=\"javascript:Void();\">������ ���������:</a></small><BR>";
					$ret .= "<div id=art_{$row['id']} style=\"display:none;\"><small><b>";
					ksort($inputbonus);
					foreach($inputbonus as $blevl => $bdata) {
						$outtxt = 'X';
						if ($blevl == 1) $outtxt = 'I';
						if ($blevl == 2) $outtxt = 'II';
						if ($blevl == 3) $outtxt = 'III';
						if ($blevl == 4) $outtxt = 'IV';
						if ($blevl == 5) $outtxt = 'V';
						if ($blevl == 6) $outtxt = 'VI';

						$ret .= "&nbsp;&nbsp;��������� {$outtxt} ������:<br>";
						foreach($bdata as $k => $v)
						{
							if ($bohtml[$k]!='')
							{
								$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
							}
						}
					}
					$ret .= "</b></small></div>";
				}
			}
			if ($row['charka']!='')
			{

				$charka=substr($row['charka'], 2,strlen($row['charka'])-1); //���������� ������ ��� �������
				$inputbonus=unserialize($charka); //��� ������

				if (is_array($inputbonus))
				{
					$ret .= "<small><b><a onclick=\"showhide('art_{$row['id']}');\" href=\"javascript:Void();\">������ ���������:</a></small><BR>";
					$ret .= "<div id=art_{$row['id']} style=\"display:none;\"><small><b>";
					ksort($inputbonus);
					foreach($inputbonus as $blevl => $bdata)
					{

						$outtxt = 'X';
						if ($blevl == 1) $outtxt = 'I';
						if ($blevl == 2) $outtxt = 'II';
						if ($blevl == 3) $outtxt = 'III';
						if ($blevl == 4) $outtxt = 'IV';
						if ($blevl == 5) $outtxt = 'V';
						if ($blevl == 6) $outtxt = 'VI';

						$ret .= "&nbsp;&nbsp;��������� {$outtxt} ������:<br>";
						foreach($bdata as $pk => $pv)
						{
							foreach($pv as $k => $v)
							{
							  if ($bohtml[$k]!='')
							  	{
								$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
								}
							}
						}
					}
					$ret .= "</b></small></div>";
				}
			}



		}


		/*http://tickets.oldbk.com/issue/oldbk-286
		if (($row['idcity']==1) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'avaloncity.oldbk.com'))) {
			$ret .= "<small>������� � AvalonCity</small>";
		} elseif (($row['idcity']==2) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'angelscity.oldbk.com'))) {
			$ret .= "<small>������� � AngelsCity</small>";
		} elseif (($row['idcity'] == 0) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'capitalcity.oldbk.com'))) {
			$ret .= "<small>������� � CapitalCity</small>";
		}
		*/

		if($row['unik']==1) {
			$ret .= "<font color=red><small><b>���� � ���������� ������������.</b></small></font>";
		}
		elseif(($row['unik']==2) and ($row['type']!=200) )  {
			$ret .= "<font color=#990099><small><b>���� � ���������� ���������� ������������.</b></small></font>";
		}

		if($row['type'] == 555) {
			$ret .= "<br><small><font color=red>������ ������ �������� �� ����������� � �������. �������� ������ �� ����� ����� � ��������� ����������. ������� ������ ����� ��������� �� ������ � ���� ���� - <a target=_blank href=http://oldbk.com/forum.php?topic=228962139>http://oldbk.com/forum.php?topic=228962139</a>. ������������� �����</red></small>";
		}

	}


	if (($row['bs_owner']==0) and ($user['ruines']==0) and ($row['labonly']==0) and ($row['prototype']!=55510000)) {
		$ups_types=array(1,2,3,4,5,8,9,10,11);
		$ebarr=array(128,17,149,148);


		if ((strpos($row['name'], '[') == true) AND (in_array($row['prototype'],$ebarr))) {
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		} elseif ((strpos($row['name'], '[') == true) AND ($row['art_param']!='')) {
			//�� ����� ������:
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		} elseif ((strpos($row['name'], '[') == true) AND (($row['type']==28) OR $row['prototype']==100028 OR $row['prototype']==100029 OR $row['prototype']==173173 OR $row['prototype']==2003 OR $row['prototype']==195195)) {
			//�� ����� ������� ���� �������:
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		} elseif ((strpos($row['name'], '[') == true) AND (in_array($row['type'],$ups_types)) AND $row['ab_mf']==0  AND $row['ab_bron']==0  AND $row['ab_uron'] == 0) {
			// �� ���� ����
			//�� �������
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		}
	}

	if($row['type']==556) {
		$ret .= "<br><small><font color=red>������ ������� ������� �� ����������� � �������. ������������� �����</red></small>";
	}

	if (strlen($row['craftedby'])) {
		$ret .= '<br>������� ������ �������� '.BNewRender($row['craftedby']).'<BR>';;
	}


	$ret .= "</td></tr></table></div>";
	if ($retdata > 0) {
		return $ret;
	} else {
		echo $ret;
	}
}



function showitem ($row, $orden = 0, $check_price = false,$color='',$act='',$rep_rate=0, $priv=0,$retdata = 0,$color2 = '') {
	global $user, $klan_ars_back, $giftars, $IM_glava, $anlim_show, $anlim_items,$nodress,$PREM_DISCOUNT, $nclass_name, $noclass_items_ok, $can_inc_magic, $can_dress_item, $can_drop_item ;
	$vau4 = array(100005,100015,100020,100025,100040,100100,100200,100300);
	$unikrazdel = array(6,2,21,22,23,24,3,4,41,42);
  $can_dress_item=false;
  $can_drop_item=false;
	$row['name'] = html_entity_decode($row['name'], ENT_QUOTES);

	$link_for_item_name=link_for_item($row);

	$ret = "";



	if($row['add_pick'] != '' && $row['pick_time']>time()) {
       		$row['img'] = $row['add_pick'];
	}

	if (($row['type'] == 30) and ($row['owner']==$user['id'])) { // ������� �� ���� �������
		// ����������  ��� ���� ���� ������
		if ($row['ups'] >= $row['add_time']) {
			$mig = explode(".",$row['img']);
			$row['img'] = $mig[0]."_up.".$mig[1];
		}
	}

	if (/*$row['type'] == 12 && */ !empty($row['img_big']))
	{
		$row['img'] = $row['img_big'];
	}

	if($row['dategoden'] && $row['dategoden'] <= time()) {
		destructitem($row['id']);
		if($row['setsale']>0) {
			mysql_query("DELETE FROM oldbk.`comission_indexes` WHERE id_item = '".$row[id]."' LIMIT 1");
		}

		if ($row['labonly']==0) {
			$rec['owner']=$user['id'];
			$rec['owner_login']=$user[login];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money'];
			$rec['target']=0;
			$rec['target_login']='���� ��������';
			$rec['type']=35;
			$rec['sum_kr']=0;
			$rec['sum_ekr']=0;
			$rec['sum_kom']=0;
			$rec['item_id']=get_item_fid($row);
			$rec['item_name']=$row['name'];
			$rec['item_count']=1;
			$rec['item_type']=$row['type'];
			$rec['item_cost']=$row['cost'];
			$rec['item_dur']=$row['duration'];
			$rec['item_maxdur']=$row['maxdur'];
			$rec['item_ups']=$row['ups'];
			$rec['item_unic']=$row['unik'];
			$rec['item_incmagic']=$row['includemagicname'];
			$rec['item_incmagic_count']=$row['includemagicuses'];
			$rec['item_arsenal']='';
			add_to_new_delo($rec); //�����
		}
	}

	$magic = magicinf ($row['magic']);

	$incmagic = magicinf($row['includemagic']);
	$incmagic['name'] = $row['includemagicname'];
	$incmagic['cur'] = $row['includemagicdex'];
	$incmagic['max'] = $row['includemagicmax'];
	$incmagic['uses'] = $row['includemagicuses'];

	if(!$magic) {
		$magic['chanse'] = $incmagic['chanse'];
		$magic['time'] = $incmagic['time'];
		$magic['targeted'] = $incmagic['targeted'];
	}

	$artinfo = "";
	$issart = 0;
	if ((($row['ab_uron'] > 0 || $row['ab_bron'] > 0 || $row['ab_mf'] > 0 || $row['art_param'] != "")  AND $row['type'] != 30) || ($row['type'] == 30 && $row['up_level'] > 5)) {
		if ($row['type'] != 30) $artinfo = ' <IMG SRC="http://i.oldbk.com/i/artefact.gif" WIDTH="18" HEIGHT="16" BORDER=0 TITLE="��������" alt="��������"> ';
		$issart = 1;
	}

	if ($row['prototype'] == 1237) {
		$act = '<a target="_blank" href="printticket.php?id='.$row['id'].'">�����������</a>';
	}


	if (!$row[GetShopCount()] || $row['inv']==1) {
		$ch=0;


		if($row['type'] < 12) {
			$ch=1;
		} elseif($row['type'] == 27 || $row['type'] == 28) {
			$ch=2;
		}
		$ret .= "<TR bgcolor=".$color.">";
		if ($color2 != '') {
			$ret .= "<TD align=center style=\"background-color:".$color2.";\" width=150 ";
		} else {
			$ret .= "<TD align=center style=\"background-color:transparent;\" width=150 ";
		}
		if ($ch > 0) {
			if (($row['maxdur']-2)<=$row['duration'] && $row['duration'] > 2) {
				$ret .= " style=\"background-image:url('http://i.oldbk.com/i/blink.gif');\" ";
			}
		}
		$ret .= " >";

		$dr=shincmag($row);

		if ($row['prototype']>=2013001 && $row['prototype']<=2013004) {
			$ret .= "<div style='position:relative;width:".$dr['res_x']."px;'><a href='http://oldbk.com/encicl/?/laretz.html' target=_blank>";
			if ($ch == 1) {
				$ret .= render_vstroj($row['includemagicdex']);
			}
			$ret .= "<img src='http://i.oldbk.com/i/sh/".$row['img']."'></a></div><BR>";
		} else {
			$ret .= "<div style='position:relative;width:".$dr['res_x']."px;'>";
			if ($ch == 1) {
				$ret .= render_vstroj($row['includemagicdex']);
			}
			$ret .= "<img src='http://i.oldbk.com/i/sh/".$row['img']."'></div><BR>";
		}

		if(isset($row['idcity'])) {
			if ($row['showbill'] == true) {
				$sh_id = "����� �: ".$row['id'];
			} else {
				$sh_id = get_item_fid($row);
			}
			$ret .= "<center><small>(".$sh_id.")</small></center><br>";
		}

		if($row['chk_arsenal'] == 0) {

			$ch_al=$user['align'];
			if($user['klan']=='pal') {
				$ch_al = 6; //���� ��� �����
				$ch_al2 = 1 ; //���� ��� �����
			} else {
				$ch_al2=0;
			}

			if ( (	($user['sila'] >= $row['nsila']) &&
				($user['lovk'] >= $row['nlovk']) &&
				($user['inta'] >= $row['ninta']) &&
				($user['vinos'] >= $row['nvinos']) &&
				($user['intel'] >= $row['nintel']) &&
				($user['mudra'] >= $row['nmudra']) &&
				($user['level'] >= $row['nlevel']) &&
				(((int)$ch_al == $row['nalign']) OR ($row['nalign'] == 0) OR ($user[align]==5) OR ($ch_al2 == $row['nalign']) ) &&
				($user['noj'] >= $row['nnoj']) &&
				($user['topor'] >= $row['ntopor']) &&
				($user['dubina'] >= $row['ndubina']) &&
				($user['mec'] >= $row['nmech']) &&
				($user['mfire'] >= $row['nfire']) &&
				($user['mwater'] >= $row['nwater']) &&
				($user['mair'] >= $row['nair']) &&
				($user['mearth'] >= $row['nearth']) &&
				($user['mlight'] >= $row['nlight']) &&
				($user['mgray'] >= $row['ngray']) &&
				($user['mdark'] >= $row['ndark']) &&
				($row['type'] < 13 OR ($row['type']==50) OR $row['type']==27 OR $row['type']==28 OR $row['type']==30 OR $row['type']==34 OR $row['type']==35 ) &&
				($row['needident'] == 0)
			) OR ($row['type']==33)  )
			 {

				if ((($row['type']==12) OR ($row['magic']) OR ($incmagic['cur'])) && $orden == 0 && $act == '') {
					if ( (($magic['id']==76) OR ($magic['id']==77) OR ($magic['id']==78)  OR ($magic['id']==7777)) and ($user['lab']==0) ) {
						//�� ���������� ������������� ��� ��������� ������� ��� ����
					} elseif (($row['sowner']==0) OR ($row['sowner']==$user['id']) ) {
						$ret .= "<a  onclick=\"";

						if($magic['id'] == 109 OR $magic['id'] == 43 OR $magic['id'] == 200 OR $magic['id'] == 500 OR $magic['id'] == 65 OR $magic['id'] == 95 OR $magic['id'] == 9595 OR $magic['id'] == 96) {
							$ret .= "showitemschoice('�������� ������������ ������', 'scrolls', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 306020) {
							$ret .= "showitemschoice('�������� �������� ����������', 'usesalign', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 106604) {
							$ret .= "showitemschoice('�������� �������� ������', 'usesbaff', 'main.php?edit=1&use=".$row['id']."');";
						}
						 elseif($magic['id'] == 110) {
							$ret .= "showitemschoice('�������� ������ ������ ������', 'moveemagic', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 227) {
							$ret .= "showitemschoice('�������� ������� ��� ����������', 'del_time', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 67) {
							$ret .= "showitemschoice('�������� ����� ��� ��������', 'makefreeup_bron', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 68) {
							$ret .= "showitemschoice('�������� ������ ��� ��������', 'makefreeup_ring', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 69) {
							$ret .= "showitemschoice('�������� ����� ��� ��������', 'makefreeup_kulon', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 70) {
							$ret .= "showitemschoice('�������� �������� ��� ��������', 'makefreeup_perchi', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 71) {
							$ret .= "showitemschoice('�������� ���� ��� ��������', 'makefreeup_shlem', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 72) {
							$ret .= "showitemschoice('�������� ��� ��� ��������', 'makefreeup_shit', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 73) {
							$ret .= "showitemschoice('�������� ������ ��� ��������', 'makefreeup_sergi', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 74) {
							$ret .= "showitemschoice('�������� ������ ��� ��������', 'makefreeup_boots', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 76) {
							$ret .= "showitemschoice('�������� ������ ��� �����������', 'lab_teleport', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 201) {
							$ret .= "showitemschoice('�������� ������� ��� �������� �����', 'delitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif(($magic['id'] == 84) OR ($magic['id'] == 85) OR ($magic['id'] == 86) OR ($magic['id'] == 87) ) {
							$ret .= "showitemschoice('�������� ����', 'add_runs_exp', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 29) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 30) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 31) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 32) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 5) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 25) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 26) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 27) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 28) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 33) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 34) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 35) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 36) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 37) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 38) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 39) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 40) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 41) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 42) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100001) {
							$ret .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100002) {
							$ret .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100003) {
							$ret .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100004) {
							$ret .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100005) {
							$ret .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100006) {
							$ret .= "showitemschoice('�������� �������� ��� ���������', 'art_bonus_6', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120001) {
							$ret .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_1_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120002) {
							$ret .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_2_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120003) {
							$ret .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_3_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120004) {
							$ret .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_4_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120005) {
							$ret .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_5_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120006) {
							$ret .= "showitemschoice('�������� �������� ��� �������� ���������', 'art_bonus_6_big', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100011) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 1', 'item_bonus_1', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100012) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 2', 'item_bonus_2', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif(($magic['id'] == 100013) and ($row['sowner']==0)) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 3', 'item_bonus_3e', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100013) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 3', 'item_bonus_3', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100014) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� ��������� III�', 'item_bonus_big', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif(($magic['id'] == 100015) and ($row['sowner']==0)) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 4', 'item_bonus_4e', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100015) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 4', 'item_bonus_4', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 100016) {
							$ret .= "showitemschoice('�������� ������� ��� �".$row['name']."�', 'item_bonus_big_4', 'main.php?edit=1&use=".$row['id']."','".$row['nlevel']."');";
						} elseif($magic['id'] == 8090) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 90) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_6', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 91) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 92) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 93) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 94) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 190) {
							$ret .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 191) {
							$ret .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 192) {
							$ret .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_9', 'main.php?edit=1&use=".$row['id']."');";
						} elseif(($magic['id'] == 181)||($magic['id'] == 182)||($magic['id'] == 183)||($magic['id'] == 184)||($magic['id'] == 185))  {
							$ret .= "showitemschoice('�������� �������������� ��� ��������� ������', 'bysshop', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 172)   {
							$ret .= "showitemschoice('�������������:', 'usedays', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 3) {
							$ret .= "showitemschoice('�������� ������� ��� �������������', 'identitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 214 or $magic['id'] == 218 or $magic['id'] == 222) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 215 or $magic['id'] == 219 or $magic['id'] == 223) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 216 or $magic['id'] == 220 or $magic['id'] == 224) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_9', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 217 or $magic['id'] == 221 or $magic['id'] == 225) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_10', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 317 or $magic['id'] == 321 or $magic['id'] == 325) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_11', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 1025) {
							$ret .= "shownoobrings('�������� ������', 'noobrings', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 1030) {
							$ret .= "showelka('�������� ������� ����', 'elka', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 1031) {
							$ret .= "showelka2('�������� ������� ����', 'elka2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 326 or $magic['id'] == 327 or $magic['id'] == 328) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_12', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['targeted'] == 8) {
							$ret .= "oknoPass('������� ������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 1) {
							$ret .= "okno('������� �������� ��������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 10) {
							$ret .= "oknoCity('������� �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 13) {
							$ret .= "oknoTeloCity('������� ��� � �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target','city')";
						} elseif($magic['targeted'] == 15) {
							$ret .= "okno('������� ����� ������ ����������� �����', 'main.php?edit=1&use=".$row['id']."', 'target',null,2)";
						} elseif($magic['targeted'] == 2) {
							$ret .= "findlogin('������� ��� ���������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif(($magic['targeted'] == 0) AND ($magic['name'] == '���������') and ($user['in_tower'] > 0)) {
							$ret .= "findlogin('������� ��� ���������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['id'] == 100) {
							$ret .= "usepaper('������', 'main.php?edit=1&use=".$row['id']."', 'target','100')";
						} elseif($magic['id'] == 101) {
							$ret .= "usepaper('������', 'main.php?edit=1&use=".$row['id']."', 'target','200')";
						} elseif($magic['id'] == 102) {
							$ret .= "usepaper('������', 'main.php?edit=1&use=".$row['id']."', 'target','500')";
						} elseif($magic['id'] == 4201 || $magic['id'] == 4202 || $magic['id'] == 4203) {
							$ret .= "usepaper('���������� ������', 'main.php?edit=1&use=".$row['id']."', 'target','60')";
						} elseif($magic['id'] == 4204) {
							$ret .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4204', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4205) {
							$ret .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4205', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4206) {
							$ret .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4206', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4207) {
							$ret .= "showitemschoice('�������� ���� ��� �������� �����', 'rihtbron', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 120) {
							$ret .= "showitemschoice('�������� ���������� ������� ��� ���������', 'upunik', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 121) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upitem', 'main.php?edit=1&use=".$row['id']."');";
						} elseif(($magic['targeted'] == 0) AND ($magic['name'] == '���������') and ($user['in_tower']==0)) {
				    		  	$ret .= "if(confirm('������������ ������?')) { window.location='main.php?edit=1&use=".$row['id']."';}";
						} elseif (($magic['targeted'] == 0) AND ($magic['file'] == 'cast_mearth.php'|| $magic['file'] == 'cast_water.php' || $magic['file'] == 'cast_air.php' || $magic['file'] == 'cast_fire.php'  )) {
				    		  	$ret .= "if(confirm('������������ ������?')) { window.location='main.php?edit=1&use=".$row['id']."';}";
						} elseif($magic['id'] == 199) {
							$ret .= "showitemschoice('�������� �������� ������', 'usesmagic', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 2016615) {
							$ret .= "showitemschoice('�������� �������� ����', 'euro2016', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 20180601 || $magic['id'] == 20180602 || $magic['id'] == 20180603)
							{
							$ret .= "showitemschoice('�������� �������� ����', 'chm2018', 'main.php?edit=1&use=".$row['id']."');";
						}
						else {
							$ret .= "window.location='main.php?edit=1&use=".$row['id']."';";
						}


						if ($magic['id'] == 4004000) {
							$ret .= "\" href='#'>�������</a> ";
						} else {
							$ret .= "\" href='#'>���-��</a> ";
						}

						if ($magic['id'] == 171) {
							$ret .= "<br><a href=\"main.php?edit=1&flag=".$row['id']."\">������</a> ";
						} elseif ($magic['id'] == 172) {
							$ret .= "<br><a onclick=\"okno('������� �����:', 'main.php?edit=1&usedays=".$row['id']."', 'daystext','',2);\" href='#'>������</a> ";
						}
					}
				}

				if($act == '') {
					if (($row['type'] != 50 && $orden == 0) AND ((($row['sowner']>0) AND ($user['id'] == $row['sowner'])) OR ($row['sowner'] == 0))) {

						if (!(in_array($row['prototype'],$nodress))) {
							$dress_yes = true;
							if ($row['gsila']<0) {
								if ($row['gsila']+$user['sila']<$row['nsila']) {
									$dress_yes=false;
								}
							}
							if ($row['glovk']<0) {
								if  ($row['glovk']+$user['lovk']<$row['nlovk']) {
									$dress_yes=false;
								}
							}
							if ($row['ginta']<0) {
								if  ($row['ginta']+$user['inta']<$row['ninta']) {
									$dress_yes=false;
							 	}
							}


							if ($row['nclass'] >0) {
								if ($row['nclass']==4)
								{
								//����� ������� ���� �� ������
								}
								else
								if ($row['nclass']!=$user['uclass']) {
								//����� �� ������������ �����
									$dress_yes=false;
							 	}
							}
							elseif ( ($user['uclass']>0) and ($row['nlevel'] <=7) )
							{
							//����� �������� ������ � ������� ���� 7�� � ���� ������

							}
							elseif ( (($user['uclass']>0) and ($row['nclass']==0)) and (!(in_array($row['type'],$noclass_items_ok)))  )
							{
								$dress_yes=false;
							}


							if($magic['name'] && $magic['us_type'] == 2) $dress_yes = false;
							if ($row['otdel']==55) $dress_yes = false; // ����� ������������ = ��������
							if ($row['naem'] && !$_SESSION['naeminv']) $dress_yes = false; // ������ ��� �������� �� �������

							if ($dress_yes == true) {
								$ret .= "<BR><a href='?edit=1&dress=".$row['id']."'>������</a> "; $can_dress_item=true;
							}
						}
					}

					$is_in_pocket = (int)$row['karman'];
					if($is_in_pocket == 0 && $orden==0 && $user['in_tower'] != 16) {
						if (!$_SESSION['naeminv']) $ret .= "<br><a href='?edit=1&pocket=1&item=".$row['id']."'>��������</a> ";
					} elseif($is_in_pocket != 0 && $orden == 0 && $user['in_tower'] != 16) {
						if (!$_SESSION['naeminv']) $ret .= "<br><a href='?edit=1&pocket=2&item=".$row['id']."'>�������</a> ";
					}
				 }
			} elseif ((($row['type']==50) OR ($row['type']==12) OR ($row['magic']) OR ($incmagic['cur'])) and ($row['type'] != 13)) {
				if($act == '') {
					//if ($user['align'] != 4)
					if (true)
						{
						$ret .= "<a  onclick=\"";
						if($magic['id'] == 43 OR $magic['id'] == 200 OR $magic['id'] == 65) {
							$ret .= "showitemschoice('�������� ������������ ������', 'scrolls', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 306020) {
							$ret .= "showitemschoice('�������� �������� ����������', 'usesalign', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 106604) {
							$ret .= "showitemschoice('�������� �������� ������', 'usesbaff', 'main.php?edit=1&use=".$row['id']."');";
						}
						elseif($magic['id'] == 201) {
							$ret .= "showitemschoice('�������� ������� ��� �������� �����', 'delitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 3) {
							$ret .= "showitemschoice('�������� ������� ��� �������������', 'identitems', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 214 or $magic['id'] == 218 or $magic['id'] == 222) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 215 or $magic['id'] == 219 or $magic['id'] == 223) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 216 or $magic['id'] == 220 or $magic['id'] == 224) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_9', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 217 or $magic['id'] == 221 or $magic['id'] == 225) {
							$ret .= "showitemschoice('�������� ������� ��� ���������', 'upgrade_10', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['targeted'] == 1) {
							$ret .= "okno('������� �������� ��������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 10) {
							$ret .= "oknoCity('������� �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['targeted'] == 13) {
							$ret .= "oknoTeloCity('������� ��� � �������� ������ (capital,avalon)', 'main.php?edit=1&use=".$row['id']."', 'target','city')";
						} elseif($magic['targeted'] == 15) {
							$ret .= "okno('������� ����� ������ ����������� �����', 'main.php?edit=1&use=".$row['id']."', 'target',null,2)";
						} elseif($magic['targeted'] == 2) {
							$ret .= "findlogin('������� ��� ���������', 'main.php?edit=1&use=".$row['id']."', 'target')";
						} elseif($magic['id'] == 4) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 29) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 30) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 31) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 32) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_m4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 5) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 25) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 26) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 27) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 28) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_t1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 33) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 34) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 35) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 36) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 37) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 38) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 39) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 40) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n3', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 41) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n4', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 42) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 8090) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 90) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_6', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 91) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_d5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 92) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_m5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 93) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_n5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 94) {
							$ret .= "showitemschoice('�������� ������ ��� �������', 'sharp_ekr_t5', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 190) {
							$ret .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_7', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 191) {
							$ret .= "showitemschoice('�������� ������ ��� ������� ��� �����������', 'sharp_8', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 910) {
							$ret .= "showitemschoice('�������� �������� ������', 'usev2015', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4204) {
							$ret .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4204', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4205) {
							$ret .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4205', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4206) {
							$ret .= "showitemschoice('�������� ���� ��� �������� HP', 'rihthp4206', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4207) {
							$ret .= "showitemschoice('�������� ���� ��� �������� �����', 'rihtbron', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 4201 || $magic['id'] == 4202 || $magic['id'] == 4203) {
							$ret .= "usepaper('���������� ������', 'main.php?edit=1&use=".$row['id']."', 'target','60')";
						} elseif($magic['id'] == 199) {
							$ret .= "showitemschoice('�������� �������� ������', 'usesmagic', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 2016615) {
							$ret .= "showitemschoice('�������� �������� ����', 'euro2016', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 20180601 || $magic['id'] == 20180602 || $magic['id'] == 20180603) {
							$ret .= "showitemschoice('�������� �������� ����', 'chm2018', 'main.php?edit=1&use=".$row['id']."');";
						}
						else {
							$ret .= "window.location='main.php?edit=1&use=".$row['id']."';";
						}

						if ($magic['id'] == 4004000) {
							$ret .= "\" href='#'>�������</a><br> ";
						} elseif (($row['magic']>0) or ($incmagic['cur'])) {
							$ret .= "\" href='#'>���-��</a><br> ";
						}
					}
				}
			}

			if ($row['naem']) {
				$ret .= '<BR><BR><a href="#" onclick="if (confirm(\'������� ����� ������ � ��������! �� �������� ��������� ����������� �� ���� ���������, ��������������� �� ��� ������������. �� �������, ��� ������ ������� �������?\')) window.location=\''.$_SERVER['PHP_SELF'].'?edit=1&uncraft='.$row['id'].'\';">������� �������</a><BR><BR>';
			}


			if (in_array($row['prototype'],$vau4) && $row['prototype'] != 100005) {
				$ret .= "<a  onclick=\"";
				$ret .= "oknovauch('��������� ������', 'main.php?edit=1&exchange=".$row['id']."', 'target','".$row['prototype']."')";
				$ret .= "\" href='#'>���������</a> ";
			}

			if($orden == 0 && $act=='') {
				//fixed for group deleting resources in inv  by Umk
				if ($user['align'] != 4) {
					if($row['group_by'] == 1 && $row[GetShopCount()]>1) {
						if($row['present'] != '') {
							$gift=1;
						} else {
							$gift=0;
						}
	        				$ret .= "<img src=http://i.oldbk.com/i/clear.gif style=\"cursor: pointer;\"  alt=\"��������� ��������� ����\" onclick=\"AddCount('".$row['prototype']."', '".$row['name']."','".$gift."','".$row['duration']."')\"></TD>";
					} elseif($row['present'] != '�������� �����' && $user['in_tower'] != 16) {
						if (!$issart || ($issart && ($user['in_tower'] > 0 || $row['labonly'] > 0))) {
							if ($row['can_drop']) {
								$ret .= "<img src=http://i.oldbk.com/i/clear.gif style=\"cursor: pointer;\" onclick=\"if (confirm('������� ".$row['name']." ����� ������, �� �������?')) window.location='main.php?edit=1&destruct=".$row['id']."'\"></TD>";
                $can_drop_item=true;
                //if ($user['id']==14897) { echo "icd:".$can_drop_item;}
              }
						}
			    		} elseif ($user['in_tower'] == 16 && $row['type'] != 12 && $row['type'] != 13) {
						$ret .= "<br><a href='castles_o.php?ret=".$row['id']."&razdel=".$row['type']."'>������� �� �����</a> ";
			    		}
				}

			} elseif($act != '') {
				$ret .= $act;
			}

		} elseif($row['chk_arsenal'] == 1) {
			$ret .= "<A HREF='klan_arsenal.php?get=1&sid=".$user['sid']."&item=".$row['id_ars']."'>����� �� ��������</A>";

			if ($row['owner_original'] == 1) {
				$ret .= '<br><b>������� �� �����</b>';

				if ($IM_glava==1) {
	            			//����� ����� ����� ��������� ���������
					if ($row['all_access'] == 1) {
		            			$ret .= "<small><input type=checkbox name='mass_cl[".$row['id']."]' checked='checked' onclick=\"show('all_cl_".$row['id']."'); \"> ������ ����</small>";
					} else {
		            			$ret .= "<small><input type=checkbox name='mass_cl[".$row['id']."]' onclick=\"show('all_cl_".$row['id']."'); \"> ������ ����</small>";
					}

					if ($row['all_access'] == 0) {
						$ret .= "<br><div style=\"display:block;\" id=\"all_cl_".$row['id']."\"><small><a href=# onclick=\"window.open('klan_arsenal_access.php?it=".$row['id']."', 'access', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')\">���������� ������</a></small></div>";
					} else {
						$ret .= "<br><div style=\"display:none;\" id=\"all_cl_".$row['id']."\"><small><a href=# onclick=\"window.open('klan_arsenal_access.php?it=".$row['id']."', 'access', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')\">���������� ������</a></small></div>";
					}
				}
			} else {
				$ret .= '<br>����:<br><b>'. global_nick($row['owner_original']).'</b> <a target=_blank href=/inf.php?'.$row['owner_original'].'><img border=0 src="http://i.oldbk.com/i/inf.gif"></a>';
			}
		} elseif($row['chk_arsenal'] == 2) {
			if($row['owner_current'] == 0) {
				$ret .= "<BR><A HREF='klan_arsenal.php?my=1&get=1&sid=".$user['sid']."&item=".$row['id_ars']."'>�������</A>";
			} else {
				$ret .= "<BR>������������: <BR>";
				$ret .= "<b>".global_nick($row['owner_current'])."</b>";
				$ret .= ' <a target=_blank href=/inf.php?'.$row['owner_current'].'><img border=0 src=http://i.oldbk.com/i/inf.gif></a>';
				$ret .= "<BR><A HREF='klan_arsenal.php?my=1&get=1&sid=".$user['sid']."&item=".$row['id_ars']."&getmy=1'>�������</A>";
			}
		} elseif($row['chk_arsenal'] == 3) {
			$ret .= '<A HREF="klan_arsenal.php?put=1&sid='.$user['sid'].'&item='.$row['id'].'">����� � �������</A>';
			if ($giftars == 1) {
				$ret .= "<br><br><a  onclick=\"";
				$ret .= "if(confirm('�� ������������� ������ �������� �������� ������� ������������?')) { window.location='klan_arsenal.php?put=2&sid=".$user['sid']."&item=".$row['id']."';}";
				$ret .= "\" href='#'>";
				$ret .= "�������� � �������</a>";
			}
		} elseif($row['chk_arsenal'] == 4) {
           		$ret .= '<A HREF="klan_arsenal.php?return=1&sid='.$user['sid'].'&item='.$row['id'].'">�������</A>';
		} elseif($row['chk_arsenal'] == 5) {
			if($row['owner'] == 22125) {
				$ret .= "<BR>�� ������������.<BR>";
			} else {
				$ret .= "<BR>������������: <BR>";
				$ret .= "<b>".global_nick($row['owner'])."</b>";
				$ret .= ' <a target=_blank href=/inf.php?'.$row['owner'].'><img border=0 src=http://i.oldbk.com/i/inf.gif></a>';
				if ($klan_ars_back==1) {
				 	// ���� �� �������
			         	$ret .= '<br><A HREF="klan_arsenal.php?back=1&item='.$row['id'].'">������</A>';
				}
			}
		} elseif($row['chk_arsenal'] == 6) {
           		$ret .= '<A HREF="klan_arsenal.php?mybox=1&sid='.$user['sid'].'&item='.$row['id'].'">������� �� �������</A>';
		} elseif($row['chk_arsenal'] == 66) {
           		$ret .= '<A HREF="?p=6&showinbox=1&item='.$row['id'].'">������� �� �������</A>';
           		if ($row['chk_arsenal_count']>1)
           		{
           		$ret .= '<img src="http://i.oldbk.com/i/up.gif" width="11" height="11" border="0" alt="������� ��������� ����" title="������� ��������� ����" style="cursor: pointer" onclick="AddCount(event,'.$row['prototype'].', \''.$row['name'].'\',1,\'\','.$row['chk_arsenal_count'].'); return false;">';
           		}

		}
		elseif($row['chk_arsenal']>=3003131 && $row['chk_arsenal']<= 3003135) {
			$ret .= '<A HREF="klan_arsenal.php?usebook='.$row['id'].'">������������</A>';
		} elseif($row['chk_arsenal'] == 7) {
			$ret .= '<A HREF="klan_arsenal.php?mybox=2&sid='.$user['sid'].'&item='.$row['id'].'">�������� � ������</A>';
		} elseif($row['chk_arsenal'] == 77) {
			$ret .= '<A HREF="?p=6&showinbox=0&item='.$row['id'].'">�������� � ������</A>';
			if ($row['chk_arsenal_count']>1)
           		{
           		$ret .= '<img src="http://i.oldbk.com/i/up.gif" width="11" height="11" border="0" alt="�������� ��������� ����" title="�������� ��������� ����" style="cursor: pointer" onclick="AddCount(event,'.$row['prototype'].', \''.$row['name'].'\',0,\'\','.$row['chk_arsenal_count'].'); return false;">';
           		}
		}

	    	$ret .= "<td valign=top>";
	}

	if ($row['nalign']==1) {
		$row['nalign']='1.5';
	}


	$ehtml = str_replace('.gif','',$row['img']);

	$razdel=array(
		1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
		24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun", 61=>'eda' , 62=>'res', 72 =>''
	);

	$row['otdel'] == '' ? $xx = $row['razdel'] : $xx = $row['otdel'];

	if ($row['type']==30) {
		$razdel[$xx]="runs/".$ehtml;
	} elseif($razdel[$xx] == '') {
            	$dola = array(5001,5002,5003,5005,5010,5015,5020,5025);

		if (in_array($row['prototype'],$vau4)) {
			$razdel[$xx]='vaucher';
		} elseif (in_array($row['prototype'],$dola)) {
			$razdel[$xx]='earning';
		} else {
			$oskol=array(15551,15552,15553,15554,15555,15556,15557,15558,15561,15562,15568,15563,15564,15565,15566,15567);
			if (in_array($row['prototype'],$oskol)) {
				$razdel[$xx]="amun/".$ehtml;
			} else {
				$razdel[$xx]='predmeti/'.$ehtml;
			}
		}
	} else {
		$razdel[$xx]=$razdel[$xx]."/".$ehtml;

	}

	if (($row['art_param'] != '') and ($row['type']!=30)) {
		if ($row['arsenal_klan'] != '')	{
			// ��������
			$razdel[$xx]='art_clan';
		} elseif ($row['sowner'] != 0) {
				//������
			$razdel[$xx]='art_pers';
		}
	}


	$anlim_txt="";
	if (($anlim_show) and (in_array($row['prototype'],$anlim_items))) {
		$anlim_txt = ' <IMG SRC="http://i.oldbk.com/i/noobs.png" WIDTH="14" HEIGHT="8" BORDER=0 TITLE="��� ���� ������ ����� ������ � ���.��������" alt="��� ���� ������ ����� ������ � ���.��������"> ';
	}

	$pod = explode(':|:',$row['present']);
	if(count($pod) > 1) {
		$txt = $pod[0];
	} else {
		$txt = $row['present'];
	}

	if ($row['otdel']==72) {
		$ret .= "<a href=https://oldbk.com/commerce/index.php?act=perspres target=_blank>".$row['name']."</a>";
	} elseif ($razdel[$xx]=='mag1/036') {
		$ret .= "<a href=https://oldbk.com/encicl/prem.html target=_blank>".$row['name']."</a>";
	} elseif ($razdel[$xx]=='mag1/037') {
		$ret .= "<a href=https://oldbk.com/encicl/prem.html target=_blank>".$row['name']."</a>";
	} elseif ($razdel[$xx]=='mag1/137') {
		$ret .= "<a href=https://oldbk.com/encicl/prem.html target=_blank>".$row['name']."</a>";
	} else {
		$ret .= $link_for_item_name; //"<a href=http://oldbk.com/encicl/".$razdel[$xx].".html target=_blank>".$row['name']."</a>";
	}


	$eshopadd = "";

	if ( ($row['ekr_flag']>0) and (($row['id']==2016401)||($row['prototype']==2016401) ) )
	{
	$addimg = '<img src="http://i.oldbk.com/i/berezka06.gif" title="������� ����� �������� �����������" alt="������� ����� �������� �����������"> ';
	}
	elseif ((isset($_GET['otdel']) && (in_array($_GET['otdel'],$unikrazdel) ) && ($_SERVER['PHP_SELF'] == "/eshop.php")  ) or ($row['ekr_flag']>0) ) {
		$addimg = '<img src="http://i.oldbk.com/i/berezka06.gif" title="������� �� �������" alt="������� �� �������"> ';
	} else {
		$addimg = "";
	}

	if ((($_SERVER['PHP_SELF'] == "/eshop.php") or ($_SERVER['PHP_SELF'] == "/shop.php") or ($_SERVER['PHP_SELF'] == "/cshop.php") ) and (strpos($row['name'], '�������������� �������') !== false) and (time()<mktime(23,59,59,3,20,2016))) {
		$hillact= " <small><b>������ 20% �� ����� ������� �����</b></small> ";
	}


	if ($row['present']) {
		$ret .= "<img src=http://i.oldbk.com/i/align_".$row['nalign'].".gif> (���: ".$row['massa'].") ".$artinfo.$anlim_txt.'  '.$addimg.' <IMG SRC="http://i.oldbk.com/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="���� ������� ��� ������� '.$txt.'. �� �� ������� �������� ���� ������� ����-���� ���." ALT="���� ������� ��� ������� '.$txt.'. �� �� ������� �������� ���� ������� ����-���� ���."><BR>';
	} else {
		$ret .= "<img src=http://i.oldbk.com/i/align_".$row['nalign'].".gif> (���: ".$row['massa'].") ".$addimg." ".$artinfo.$anlim_txt.' <BR>';
	}


	if (isset($row['fairlimit'])) {
		if (!$row['fairhidecount2'] || ADMIN) {
			$ret .= '<small><font color=red><b>�������� '.$row['fairlimit'].' ��.</b></font></small> <BR>';
		}
	}

	if (isset($row['fairstartsell']) && ADMIN && $row['fairstartsell'] > 0) {
		$ret .= '<b>����� ������ � '.date("d/m/Y H:i:s",$row['fairstartsell']).'</b></font><BR>';
	}
	if (isset($row['fairendsell']) && ADMIN && $row['fairendsell'] > 0) {
		$ret .= '<b>������� �� '.date("d/m/Y H:i:s",$row['fairendsell']).'</b></font><BR>';
	}

	$row_prototype=isset($row['prototype'])?$row['prototype']:$row['id'];

	if (($row_prototype==949)||($row_prototype==950)||($row_prototype==951)) {
		$row['cost'] = 1;
	} elseif ((($row_prototype>=946) and ($row_prototype <=957))) {
		$row['cost'] = 1;
	}


	if (isset($row['fairprice']) || $row['gold'] > 0) {
		if (!isset($row['fairprice'])) $row['fairprice'] = $row['gold'];
		$ret .= "<b>����: ".$row['fairprice']." <img src=\"http://i.oldbk.com/i/icon/coin_icon.png\" style=\"margin-bottom: -2px;\"></b> &nbsp;";
	} else {
		if ($row['no'] == 1) {
			// nothing
		} elseif ($row['getfrom'] == 43 && $row['repcost'] > 0) {
			$ret .= "<b>����: ".$row['repcost']." ���.</b> &nbsp;";
		} elseif ((($row['repcost'] > 0) and ($row['ecost'] ==0)) or ($_SERVER['PHP_SELF'] == '/cshop.php')) {
			if($row['setsale'] > 0) {
				$row['cost']=$row['setsale'];
			}
			if($check_price) {
				if($user['repmoney'] < $row['repcost'])	{
					$ret .= "<b>����: <font color='red'>".$row['repcost']."</font> ���.</b> &nbsp;";
				} else {
					$ret .= "<b>����: ".$row['repcost']." ���.</b> &nbsp;";
				}
			} elseif((int)$row['type'] == 12) {
				$ret .= "<b>����: ".$row['cost']." ��.</b>  &nbsp;";
			} else {
				$ret .= "<b>����: ".$row['cost']." ��.</b>  &nbsp;";
			}
		} elseif($row['repcost'] > 0 && $row['ecost'] == 0 && $row['cost'] == 0) {
			$ret .= "<b>����: ".$row['repcost']." ���.</b> &nbsp;";
		} elseif($row['repcost'] > 0 && ($row['sowner'] > 0) && ($_SERVER['PHP_SELF'] != '/comission.php')) {
			$ret .= "<b>����: ".$row['repcost']." ���.</b> &nbsp;";
		} elseif($row['ecost'] > 0 && ($_SERVER['PHP_SELF'] != '/comission.php')) {
			$ret .= "<b>����: ".$row['ecost']." ���.</b> &nbsp; &nbsp;";
		} elseif($row['cost'] > 0 && $row['setsale'] > 0 && ($_SERVER['PHP_SELF'] == '/comission.php')) {
			$ret .= "<b>����: ".$row['setsale']." ��.</b> &nbsp; (���.����. ".$row['cost']." ��.)&nbsp;";
		} else {
			$ret .= "<b>����: ".$row['cost']." ��.</b> &nbsp; &nbsp;";
		}
	}

	if ($row['no'] == 1) {
		// nothing
	} elseif($row[GetShopCount()]) {

		$ret.=$hillact;

		if ( ($_SERVER['PHP_SELF'] == '/eshop.php') or (($_SERVER['PHP_SELF'] == '/shop.php') and (strpos($row['name'], '�������������� �������') !== false) and ($_GET['newsale']!=1)  ) )  {
			$ret .= "<small>(����������:<b>&#8734;</b>)";

			if ($user['klan'] == 'radminion') {
				$ret .= "(<b> ".$row[GetShopCount()]."</b>)";
			}

			$ret .= "</small>";
		} elseif ($_SERVER['PHP_SELF'] == '/craft.php') {
			if ($row['craftprotocount'] > 1) {
				$ret .= "<small>(����������: <font color=red><b>".$row['craftprotocount']."</font></b>)</small>";
			} else {
				$ret .= "<small>(����������: <b>".$row['craftprotocount']."</b>)</small>";
			}
		} elseif ($_SERVER['PHP_SELF'] == '/fair.php') {
			if ($row[GetShopCount()] == -1) {
				$ret .= "<small>(<b>����� ������</b>)</small>";
			} else {
				if (!$row['fairhidecount'] || ADMIN) {
					$ret .= "<small>(����������:<b> {$row[GetShopCount()]}</b>)</small>";
				}
			}
		} else {
			if (($_SERVER['PHP_SELF'] == '/shop.php') AND in_array($row['id'],$anlim_items) AND ($anlim_show)) {
				$ret .= '<small>(����������: <IMG SRC="http://i.oldbk.com/i/noobs.png" WIDTH="14" HEIGHT="8" BORDER=0 TITLE="��� ���� ������ ����� ������ � ���.��������" alt="��� ���� ������ ����� ������ � ���.��������">)</small>';
			} else {
				$ret .= "<small>(����������:<b> {$row[GetShopCount()]}</b>)</small>";
			}
		}
		if ($PREM_DISCOUNT) {
			if($user['prem']>0 && ($_SERVER['PHP_SELF'] == '/shop.php') && strpos($_SERVER['QUERY_STRING'],'newsale') === false) {
				$akkname[1]='Silver';
				$akkname[2]='Gold';
				$akkname[3]='Platinum';

				$cost=sprintf("%01.2f", ($row['cost']*0.9));
				$ret .= "<br><b>����: ".$cost." ��.</b> (��� ".$akkname[$user[prem]]." account)";
			}
		}
	}


	// ���� ����, ������ (��� ���) � ���������� ��������� ��� ���������


	if ($row['present'] != "�������� �����" && $row['present'] != "��������� �����" && $row['arsenal_owner'] == 0) {
		if ($row['letter'] && (($_SERVER['PHP_SELF'] == '/fshop.php') || ($row['type']==3 and $row['otdel']==6 and $row['present']==''))) {
		 	$ret .= "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span>";
		} elseif ($row['letter'] && $row['type'] == 200) {
			$ret .= "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span>";
		} elseif ($row['letter'] && (!($row['prototype']==20000 or ($row['prototype']>=55510000 and $row['prototype']<=55520000)  or ($row[otdel] >=70 AND $row[otdel] <=76) or ($row[razdel] >=70 AND $row[razdel] <=76) or $row['type']==200 or $row['type']==100 or $row[otdel]==7  or $row[razdel]==7  or ($row[prototype]>= 2014001 and $row[prototype] <= 2014008)))) {
			$ret .= "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'>".$row['letter']."</span>";
		} elseif($row['letter'] && $user['in_tower'] != 16 && $row['prototype'] != 3006000) {
			$ret .= "<br>�� ������ ������� �����: <span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span><br>���������� ��������: ".strlen($row['letter']);
		} elseif (($row['id'] == 501) OR ($row['prototype'] == 501) OR ($row['id'] == 502) OR ($row['prototype'] == 502) ) {
			$ret .=  "<br><span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'>��� ������������ �����</span>";
		}
	}



	if ($row['type'] == 30) {
		// ���������� ������� ����
		$addlvl = "";
		if ($row['ups'] >= $row['add_time']) {
			$addlvl = ' <a href="?edit=1&uprune='.$row['id'].'" style="color:red;"><img src="http://i.oldbk.com/i/up.gif" border="0"></a> ';
		}

		if (isset($row['ups'])) {
			$ret .= "<br><b>�������: ".$row['up_level']." </b> ����: <b><a href=\"http://oldbk.com/encicl/?/runes_opyt_table.html\" target=\"_blank\">".$row['ups']."</b></a> (".$row['add_time'].") ".$addlvl;
		} else {
			$ret .= "<br><b>�������: ".(int)($row[up_level])." </b> ";
		}
	}

	$ret .= "<br>�������������: ".$row['duration']."/".$row['maxdur']."<BR>";

	if (!$row['needident']) {
		// ���������� ������ � ��� �����������
		$art_param = explode(',',$row['art_param']);

		if ($row['type'] != 30) {
			 // ���� ups - ��� ��� ������������ ��� �������� ����� ���� ��� �������� �� �������
			if (($row['type'] < 12 || $row['type'] == 28) && $row['type'] != 3 and strpos($row['name'],'(��)') !== false and strpos($row['name'],'�����') === false) {
				if ($row['mfkrit'] > 0 || $row['mfakrit'] > 0 || $row['mfuvorot'] > 0 || $row['mfauvorot'] > 0) {
					$ret .= "���������: <b>".(int)($row['ups'])."/5</b> ���<BR>";
				}
			}
		}

		if ($row['gmeshok'] OR $row['gsila'] OR $row['mfkrit'] OR $row['mfakrit']  OR $row['mfuvorot'] OR $row['mfauvorot']  OR $row['glovk'] OR $row['ghp'] OR $row['ginta'] OR $row['gintel'] OR $row['gnoj'] OR $row['gtopor'] OR $row['gdubina'] OR $row['gmech'] OR $row['gfire'] OR $row['gwater'] OR $row['gair'] OR $row['gearth'] OR $row['gearth'] OR $row['glight'] OR $row['ggray'] OR $row['gdark'] OR $row['minu'] OR $row['maxu'] OR $row['bron1'] OR $row['bron2'] OR $row['bron3'] OR $row['bron4'] OR $row['craftbonus'] OR $row['craftspeedup'] OR $row['mfchance']) {
			$ret .= "<br><B>��������� ��:</b><BR>";
		}

		if ($row['minu']) {
			$ret .= "� ����������� ��������� �����������: ".$row['minu']."<BR>";
		}
		if ($row['maxu']) {
			$ret .= "� ������������ ��������� �����������: ".$row['maxu']."<BR>";
		}

		if ($row['craftbonus']) {
			$ret .= "� ����� ����������: ".$row['craftbonus']."<BR>";
		}

		if ($row['craftspeedup']) {
			$ret .= "� ��������� ����� ������������ �� ".$row['craftspeedup']."%<BR>";
		}

		if ($row['mfchance']) {
			$ret .= "� ���� �����������: ".$row['mfchance']."%<BR>";
		}


		if (isset($_GET['otdel']) && in_array($_GET['otdel'],$unikrazdel) && ($_SERVER['PHP_SELF'] == "/eshop.php")) {
			if($row['gsila'] or in_array('gsila', $art_param)) {
				$ret .= "� ����: ";
				if ($row['gsila'] > 0) $ret .= "+";
				$ret .= $row['gsila'];
			}
			if($row['stbonus']>0 and ((($row['gsila'] != 0) and ($row['art_param']=='')) or in_array('gsila', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['gsila'] !=0 or in_array('gsila', $art_param)) $ret .= "<br>";


			if($row['glovk'] or in_array('glovk', $art_param)) {
				$ret .= "� ��������: ";
				if ($row['glovk']>0) $ret .= "+";
				$ret .= $row['glovk'];
			}
			if ($row['stbonus'] > 0 and ((($row['glovk'] != 0) and ($row['art_param']=='')) or in_array('glovk', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['glovk'] != 0 or in_array('glovk', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['ginta'] or in_array('ginta', $art_param)) {
				$ret .= "� ��������: ";
				if ($row['ginta'] > 0) $ret .= "+";
				$ret .= $row['ginta'];
			}
			if ($row['stbonus']>0 and ((($row['ginta'] != 0) and ($row['art_param'] == '')) or in_array('ginta', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['ginta'] != 0 or in_array('ginta', $art_param)) {
				$ret .= "<br>";
			}


			if ($row['gintel'] or in_array('gintel', $art_param)) {
				$ret .= "� ���������: ";
				if ($row['gintel'] > 0) $ret .= "+";
				$ret .= $row['gintel'];
			}
			if ($row['stbonus']>0 and ((($row['gintel'] != 0) and ($row['art_param'] == '')) or in_array('gintel', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['gintel']!=0 or in_array('gintel', $art_param)) {
				$ret .= "<br>";
			}


			if ($row['gmp'] or in_array('gmp', $art_param)) {
				$ret .= "� ��������: ";
				if($row['gmp'] > 0) $ret .= "+";
				$ret .= $row['gmp'];
			}
			if ($row['stbonus']>0 and ((($row['gmp']!=0) and ($row['art_param'] == '')) or in_array('gmp', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['gmp'] != 0 or in_array('gmp', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['ghp']) $ret .= "� ������� �����: +".$row['ghp']."<BR>";

			if ($row['mfkrit'] or in_array('mfkrit', $art_param)) {
				$ret .= "� ��. ����������� ������: ";
				if ($row['mfkrit'] > 0) $ret .= "+";
				$ret .= $row['mfkrit']."%";
			}
			if ($row['mfbonus'] > 0 and ((($row['mfkrit'] != 0) and ($row['art_param'] == '')) or in_array('mfkrit', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['mfkrit'] != 0 or in_array('mfkrit', $art_param)) {
				$ret .= "<br>";
			}


			if($row['mfakrit'] or in_array('mfakrit', $art_param)) {
				$ret .= "� ��. ������ ����. ������: ";
				if ($row['mfakrit'] > 0) $ret .= "+";
				$ret .= $row['mfakrit']."%";
			}
			if($row['mfbonus'] > 0 and ((($row['mfakrit'] != 0) and ($row['art_param']=='')) or in_array('mfakrit', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['mfakrit'] != 0 or in_array('mfakrit', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['mfuvorot'] or in_array('mfuvorot', $art_param)) {
				$ret .= "� ��. ������������: ";
				if ($row['mfuvorot'] > 0) $ret .= "+";
				$ret .= $row['mfuvorot']."%";
			}
			if ($row['mfbonus']>0 and ((($row['mfuvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfuvorot', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['mfuvorot'] != 0 or in_array('mfuvorot', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['mfauvorot'] or in_array('mfauvorot', $art_param)) {
				$ret .= "� ��. ������ ��������.: ";
				if($row['mfauvorot'] > 0) $ret .= "+";
				$ret .= $row['mfauvorot']."%";
			}
			if ($row['mfbonus'] >0 and ((($row['mfauvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfauvorot', $art_param))) {
				$ret .= " <img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'>";
			}
			if ($row['mfauvorot'] != 0 or in_array('mfauvorot', $art_param)) {
				$ret .= "<br>";
			}
		} elseif ($_SERVER['PHP_SELF'] != '/main.php' && $_SERVER['PHP_SELF'] != '/_main.php') {
			  // �� ���������� "+" ��� ������ - � �������� ������ � main.php
			if ($row['gsila'] > 0) {
				$ret .= "� ����: +".$row['gsila']."<br>";
			} elseif ($row['gsila'] < 0) {
				$ret .= "� ����: ".$row['gsila']."<br>";
			}

			if ($row['glovk'] > 0) {
				$ret .= "� ��������: +".$row['glovk']."<br>";
			} elseif ($row['glovk'] < 0) {
				$ret .= "� ��������: ".$row['glovk']."<br>";
			}

			if ($row['ginta'] > 0) {
				$ret .= "� ��������: +".$row['ginta']."<br>";
			} elseif ($row['ginta'] < 0) {
				$ret .= "� ��������: ".$row['ginta']."<br>";
			}

			if ($row['gintel'] > 0) {
				$ret .= "� ���������: +".$row['gintel']."<br>";
			} elseif ($row['gintel'] < 0) {
				$ret .= "� ���������: ".$row['gintel']."<br>";
			}

			if ($row['gmp'] > 0) {
				$ret .= "� ��������: +".$row['gmp']."<br>";
			} elseif ($row['gmp'] < 0) {
				$ret .= "� ��������: ".$row['gmp']."<br>";
			}

			if ($row['ghp'] > 0) {
				$ret .= "� ������� �����: +".$row['ghp']."<br>";
			} elseif ($row['ghp'] < 0) {
				$ret .= "� ������� �����: ".$row['ghp']."<br>";
			}

			if ($row['mfkrit'] > 0) {
				$ret .= "� ��. ����������� ������: +".$row['mfkrit']."%<br>";
			} elseif ($row['mfkrit'] < 0) {
				$ret .= "� ��. ����������� ������: ".$row['mfkrit']."%<br>";
			}


			if ($row['mfakrit'] > 0) {
				$ret .= "� ��. ������ ����. ������: +".$row['mfakrit']."%<br>";
			} elseif ($row['mfakrit'] < 0) {
				$ret .= "� ��. ������ ����. ������: ".$row['mfakrit']."%<br>";
			}

			if ($row['mfuvorot'] > 0) {
				$ret .= "� ��. ������������: +".$row['mfuvorot']."%<br>";
			} elseif ($row['mfuvorot'] < 0) {
				$ret .= "� ��. ������������: ".$row['mfuvorot']."%<br>";
			}

			if ($row['mfauvorot'] > 0) {
				$ret .= "� ��. ������ ��������.: +".$row['mfauvorot']."%<br>";
			} elseif ($row['mfauvorot'] < 0) {
				$ret .= "� ��. ������ ��������.: ".$row['mfauvorot']."%<br>";
			}
		} else {
			if($row['gsila'] or in_array('gsila', $art_param)) {
				$ret .= "� ����: ";
				if ($row['gsila'] > 0) $ret .= "+";
				$ret .= $row['gsila'];
			}
			if($row['stbonus']>0 and ((($row['gsila'] != 0) and ($row['art_param']=='')) or in_array('gsila', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ���������� ������������ � ����\",\"1\")) { window.location=\"?edit=1&setup=".$row['id']."&sila=1&st_count=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['gsila'] !=0 or in_array('gsila', $art_param)) $ret .= "<br>";


			if($row['glovk'] or in_array('glovk', $art_param)) {
				$ret .= "� ��������: ";
				if ($row['glovk']>0) $ret .= "+";
				$ret .= $row['glovk'];
			}
			if ($row['stbonus'] > 0 and ((($row['glovk'] != 0) and ($row['art_param']=='')) or in_array('glovk', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ���������� ������������ � ��������\",\"1\")) { window.location=\"?edit=1&setup=".$row['id']."&lovk=1&st_count=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['glovk'] != 0 or in_array('glovk', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['ginta'] or in_array('ginta', $art_param)) {
				$ret .= "� ��������: ";
				if ($row['ginta'] > 0) $ret .= "+";
				$ret .= $row['ginta'];
			}
			if ($row['stbonus']>0 and ((($row['ginta'] != 0) and ($row['art_param'] == '')) or in_array('ginta', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ���������� ������������ � ��������\",\"1\")) { window.location=\"?edit=1&setup=".$row['id']."&inta=1&st_count=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['ginta'] != 0 or in_array('ginta', $art_param)) {
				$ret .= "<br>";
			}


			if ($row['gintel'] or in_array('gintel', $art_param)) {
				$ret .= "� ���������: ";
				if ($row['gintel'] > 0) $ret .= "+";
				$ret .= $row['gintel'];
			}
			if ($row['stbonus']>0 and ((($row['gintel'] != 0) and ($row['art_param'] == '')) or in_array('gintel', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ���������� ������������ � ���������\",\"1\")) { window.location=\"?edit=1&setup=".$row['id']."&intel=1&st_count=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['gintel']!=0 or in_array('gintel', $art_param)) {
				$ret .= "<br>";
			}


			if ($row['gmp'] or in_array('gmp', $art_param)) {
				$ret .= "� ��������: ";
				if($row['gmp'] > 0) $ret .= "+";
				$ret .= $row['gmp'];
			}
			if ($row['stbonus']>0 and ((($row['gmp']!=0) and ($row['art_param'] == '')) or in_array('gmp', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� ���������� ������������ � ��������\",\"1\")) { window.location=\"?edit=1&setup=".$row['id']."&gmp=1&st_count=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['gmp'] != 0 or in_array('gmp', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['ghp']) $ret .= "� ������� �����: +".$row['ghp']."<BR>";

			if ($row['mfkrit'] or in_array('mfkrit', $art_param)) {
				$ret .= "� ��. ����������� ������: ";
				if ($row['mfkrit'] > 0) $ret .= "+";
				$ret .= $row['mfkrit']."%";
			}
			if ($row['mfbonus'] > 0 and ((($row['mfkrit'] != 0) and ($row['art_param'] == '')) or in_array('mfkrit', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ����\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&krit=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['mfkrit'] != 0 or in_array('mfkrit', $art_param)) {
				$ret .= "<br>";
			}


			if($row['mfakrit'] or in_array('mfakrit', $art_param)) {
				$ret .= "� ��. ������ ����. ������: ";
				if ($row['mfakrit'] > 0) $ret .= "+";
				$ret .= $row['mfakrit']."%";
			}
			if($row['mfbonus'] > 0 and ((($row['mfakrit'] != 0) and ($row['art_param']=='')) or in_array('mfakrit', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ��������\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&akrit=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['mfakrit'] != 0 or in_array('mfakrit', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['mfuvorot'] or in_array('mfuvorot', $art_param)) {
				$ret .= "� ��. ������������: ";
				if ($row['mfuvorot'] > 0) $ret .= "+";
				$ret .= $row['mfuvorot']."%";
			}
			if ($row['mfbonus']>0 and ((($row['mfuvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfuvorot', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ������\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&uvorot=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['mfuvorot'] != 0 or in_array('mfuvorot', $art_param)) {
				$ret .= "<br>";
			}

			if ($row['mfauvorot'] or in_array('mfauvorot', $art_param)) {
				$ret .= "� ��. ������ ��������.: ";
				if($row['mfauvorot'] > 0) $ret .= "+";
				$ret .= $row['mfauvorot']."%";
			}
			if ($row['mfbonus'] >0 and ((($row['mfauvorot'] != 0) and ($row['art_param'] == '')) or in_array('mfauvorot', $art_param))) {
				$ret .= "<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ����������\",\"1\")) { window.location=\"?edit=1&mfsetup=".$row['id']."&auvorot=\"+obj+\"\"; }' href='#'><img src='http://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>";
			}
			if ($row['mfauvorot'] != 0 or in_array('mfauvorot', $art_param)) {
				$ret .= "<br>";
			}

		}

		if($row['present'] != '') {
			$prez = explode(':|:',$row['present']);
		}

		if($row['gnoj']) $ret .= "� ���������� �������� ������ � ���������: +".$row['gnoj']."<BR>";
		if($row['gtopor']) $ret .= "� ���������� �������� �������� � ��������: +".$row['gtopor']."<BR>";
		if($row['gdubina']) $ret .= "� ���������� �������� �������� � ��������: +".$row['gdubina']."<BR>";
		if($row['gmech']) $ret .= "� ���������� �������� ������: +".$row['gmech']."<BR>";
		if($row['gfire']) $ret .= "� ���������� �������� ������� ����: +".$row['gfire']."<BR>";
		if($row['gwater']) $ret .= "� ���������� �������� ������� ����: +".$row['gwater']."<BR>";
		if($row['gair']) $ret .= "� ���������� �������� ������� �������: +".$row['gair']."<BR>";
		if($row['gearth']) $ret .= "� ���������� �������� ������� �����: +".$row['gearth']."<BR>";
		if($row['glight']) $ret .= "� ���������� �������� ������ �����: +".$row['glight']."<BR>";
		if($row['ggray']) $ret .= "� ���������� �������� ����� ������: +".$row['ggray']."<BR>";
		if($row['gdark']) $ret .= "� ���������� �������� ������ ����: +".$row['gdark']."<BR>";
		if($row['bron1']) $ret .= "� ����� ������: ".$row['bron1']."<BR>";
		if($row['bron2']) $ret .= "� ����� �������: ".$row['bron2']."<BR>";
		if($row['bron3']) $ret .= "� ����� �����: ".$row['bron3']."<BR>";
		if($row['bron4']) $ret .= "� ����� ���: ".$row['bron4']."<BR>";
		if($row['gmeshok']) $ret .= "� ����������� ������: +".$row['gmeshok']."<BR>";


		if ($row['stbonus'] > 0) {
			$ret .= "��������� ����������: <b>".$row['stbonus']."</b><BR>";
		}
		if ($row['mfbonus'] > 0) {
			$ret .= "��������� ���������� ��: <b>".$row['mfbonus']."</b><BR>";
		}

		if ($row['nsila'] OR $row['nlovk'] OR $row['ninta'] OR $row['nvinos'] OR $row['nlevel'] OR ($incmagic['max'] && $incmagic['nlevel'] > 0) OR $row['nintel'] OR $row['nmudra'] OR $row['nnoj'] OR $row['ntopor'] OR $row['ndubina'] OR $row['nmech'] OR $row['nfire'] OR $row['nwater'] OR $row['nair'] OR $row['nearth'] OR $row['nearth'] OR $row['nlight'] OR $row['ngray'] OR $row['ndark']) {
			$ret .= "<br><b>��������� �����������:</b><BR>";
		}

		if ($row['nsex'] == 1) {
			$ret .= "� ���: <b>�������</b><br>";
		}

		if ($row['nsex'] == 2) {
			$ret .= "� ���: <b>�������</b><br>";
		}


	if (($_SERVER['PHP_SELF'] == '/admin_shop.php')  )
	{
		$ret .= "<form method=post ><b>����� ���������:</b>
			<input type=hidden name=sclid value='{$row['id']}'>
					<select name='setitemclass'>
					<option value='0' ".($row['nclass']==0?"selected":"")." >�����</option>
					<option value='1' ".($row['nclass']==1?"selected":"").">���������</option>
					<option value='2' ".($row['nclass']==2?"selected":"").">��������</option>
					<option value='3' ".($row['nclass']==3?"selected":"").">����</option>
					<option value='4' ".($row['nclass']==4?"selected":"").">����� �����-�������������</option></select>
					<input type=submit name=givesklonka value='����������'></form><br>";
	}
	else
		if (($row['nclass'] >0) )
			{
				if ($nclass_name[$row['nclass']]!='')
				{
					if (($row['nclass']!=$user['uclass']) and ($row['nclass']!=4) )
					{
					$ret .= "� <font color=\"red\">����� ���������: <b>{$nclass_name[$row['nclass']]}</b></font><br>";
					}
					else
					{
					$ret .= "� ����� ���������: <b>{$nclass_name[$row['nclass']]}</b><br>";
					}
				}
			}


		if ($row['nsila'] > 0) {
			$ret .= "� ";
			if ($row['nsila'] > $user['sila']) {
				$ret .= '<font color="red">����: '.$row['nsila'].'</font>';
			} else {
				$ret .= '����: '.$row['nsila'];
			}
			$ret .= "<BR>";
		}
		if ($row['nlovk'] > 0) {
			$ret .= "� ";
			if ($row['nlovk'] > $user['lovk']) {
				$ret .= '<font color="red">��������: '.$row['nlovk'].'</font>';
			} else {
				$ret .= '��������: '.$row['nlovk'];
			}
			$ret .= "<BR>";
		}
		if ($row['ninta'] > 0) {
			$ret .= "� ";
			if ($row['ninta'] > $user['inta']) {
				$ret .= '<font color="red">��������: '.$row['ninta'].'</font>';
			} else {
				$ret .= '��������: '.$row['ninta'];
			}
			$ret .= "<BR>";
		}
		if ($row['nvinos'] > 0) {
			$ret .= "� ";
			if ($row['nvinos'] > $user['vinos']) {
				$ret .= '<font color="red">������������: '.$row['nvinos'].'</font>';
			} else {
				$ret .= '������������: '.$row['nvinos'];
			}
			$ret .= "<BR>";
		}
		if ($row['nlevel'] > 0 || ($incmagic['max'] && $incmagic['nlevel'] > 0)) {
			$ret .= "� ";
			if ($row['nlevel'] >= $incmagic['nlevel']) {
				if ($row['nlevel'] > $user['level']) {
					$ret .= '<font color="red">�������: '.$row['nlevel'].'</font>';
				} else {
					$ret .= '�������: '.$row['nlevel'];
				}
			} else {
				if ($incmagic['nlevel'] > $user['level']) {
					$ret .= '<font color="red">������� : '.$incmagic['nlevel'].'</font> <small>(��� ������������� �����)</small>';
				} else {
					$ret .= '�������: '.$incmagic['nlevel'];
				}
			}
			$ret .= "<BR>";
		}
		if ($row['nintel'] > 0) {
			$ret .= "� ";
			if ($row['nintel'] > $user['intel']) {
				$ret .= '<font color="red">���������: '.$row['nintel'].'</font>';
			} else {
				$ret .= '���������: '.$row['nintel'];
			}
			$ret .= "<BR>";
		}
		if ($row['nmudra'] > 0) {
			$ret .= "� ";
			if ($row['nmudra'] > $user['mudra']) {
				$ret .= '<font color="red">��������: '.$row['nmudra'].'</font>';
			} else {
				$ret .= '��������: '.$row['nmudra'];
			}
			$ret .= "<BR>";
		}
		if ($row['nnoj'] > 0) {
			$ret .= "� ";
			if ($row['nnoj'] > $user['noj']) {
				$ret .= '<font color="red">���������� �������� ������ � ���������: '.$row['nnoj'].'</font>';
			} else {
				$ret .= '���������� �������� ������ � ���������: '.$row['nnoj'];
			}
			$ret .= "<BR>";
		}
		if ($row['ntopor'] > 0) {
			$ret .= "� ";
			if ($row['ntopor'] > $user['topor']) {
				$ret .= '<font color="red">���������� �������� �������� � ��������: '.$row['ntopor'].'</font>';
			} else {
				$ret .= '���������� �������� �������� � ��������: '.$row['ntopor'];
			}
			$ret .= "<BR>";
		}
		if ($row['ndubina'] > 0) {
			$ret .= "� ";
			if ($row['ndubina'] > $user['dubina']) {
				$ret .= '<font color="red">���������� �������� �������� � ��������: '.$row['ndubina'].'</font>';
			} else {
				$ret .= '���������� �������� �������� � ��������: '.$row['ndubina'];
			}
			$ret .= "<BR>";
		}
		if ($row['nmech'] > 0) {
			$ret .= "� ";
			if ($row['nmech'] > $user['mec']) {
				$ret .= '<font color="red">���������� �������� ������: '.$row['nmech'].'</font>';
			} else {
				$ret .= '���������� �������� ������: '.$row['nmech'];
			}
			$ret .= "<BR>";
		}
		if ($row['nfire'] > 0) {
			$ret .= "� ";
			if ($row['nfire'] > $user['mfire']) {
				$ret .= '<font color="red">���������� �������� ������� ����: '.$row['nfire'].'</font>';
			} else {
				$ret .= '���������� �������� ������� ����: '.$row['nfire'];
			}
			$ret .= "<BR>";
		}
		if ($row['nwater'] > 0) {
			$ret .= "� ";
			if ($row['nwater'] > $user['mwater']) {
				$ret .= '<font color="red">���������� �������� ������� ����: '.$row['nwater'].'</font>';
			} else {
				$ret .= '���������� �������� ������� ����: '.$row['nwater'];
			}
			$ret .= "<BR>";
		}
		if ($row['nair'] > 0) {
			$ret .= "� ";
			if ($row['nair'] > $user['mair']) {
				$ret .= '<font color="red">���������� �������� ������� �������: '.$row['nair'].'</font>';
			} else {
				$ret .= '���������� �������� ������� �������: '.$row['nair'];
			}
			$ret .= "<BR>";
		}
		if ($row['nearth'] > 0) {
			$ret .= "� ";
			if ($row['nearth'] > $user['mearth']) {
				$ret .= '<font color="red">���������� �������� ������� �����: '.$row['nearth'].'</font>';
			} else {
				$ret .= '���������� �������� ������� �����: '.$row['nearth'];
			}
			$ret .= "<BR>";
		}
		if ($row['nlight'] > 0) {
			$ret .= "� ";
			if ($row['nlight'] > $user['mlight']) {
				$ret .= '<font color="red">���������� �������� ������ �����: '.$row['nlight'].'</font>';
			} else {
				$ret .= '���������� �������� ������ �����: '.$row['nlight'];
			}
			$ret .= "<BR>";
		}
		if ($row['ngray'] > 0) {
			$ret .= "� ";
			if ($row['ngray'] > $user['mgray']) {
				$ret .= '<font color="red">���������� �������� ����� ������: '.$row['ngray'].'</font>';
			} else {
				$ret .= '���������� �������� ����� ������: '.$row['ngray'];
			}
			$ret .= "<BR>";
		}
		if ($row['ndark'] > 0) {
			$ret .= "� ";
			if ($row['ndark'] > $user['mdark']) {
				$ret .= '<font color="red">���������� �������� ������ ����: '.$row['ndark'].'</font>';
			} else {
				$ret .= '���������� �������� ������ ����: '.$row['ndark'];
			}
			$ret .= "<BR>";
		}

		if ($row['magic'] == 8888) {
			$ret .= "� �������, ������, ����������� ����������<br>";
		}

		// �����������
		if (
			$row['prokat_idp']>0 ||
			($magic['img'] && $row['type'] == 12 && $row['labonly']==0 && $row['dategoden'] == 0) ||
			((!$magic['img'] || $row['labonly']==1 || $row['dategoden'] > 0) && $row['type'] == 12) ||
			($magic['name'] && ($magic['us_type'] > 0 || $magic['target_type'] > 0)) ||
			$row['labonly'] == 1 ||
			!$row['isrep'] ||
			$row['sowner'] > 0 ||
			$row['goden'] ||
			$row['present'] == "�������� �����" ||
			$row['arsenal_owner'] != 0 ||
			($row['is_owner'] > 0 && ($row_prototype == 9099 || $row_prototype == 190199)) ||
			$row['notsell'] ||
			($row['getfrom'] == 43 && $row['repcost'] > 0 && $row['sowner'] > 0) ||
			($row['repcost'] > 0 && $row['is_owner'] > 0 && $_SERVER['PHP_SELF'] == '/cshop.php') ||
			$row['naem'] > 0 || $row['craftnaem'] > 0
		) {
			$ret .= "<br><b>�����������:</b><br>";
		}

	        if($row['naem'] > 0 || $row['craftnaem'] > 0) {
			$naemid = $row['naem'] ? $row['naem'] : $row['craftnaem'];
			$so = mysql_query_cache('SELECT * from naem_proto WHERE id = '.$naemid,false,600);
			if (count($so)) {
				$so = $so[0];
	        		$naem = s_nicknaem($so['id'],$so['align'],$so['klan'],$so['login']);
				$ret .= '<font color=red>������ ���� ����� ����� ������ ������</font> '.$naem.'<br>';
			} else {
				$ret .= '<font color=red>������ ���� ����� ����� ������ ������</font><br>';
			}

			$ret .= "<font color=maroon>������� �� �������� �����������</font><BR>";
			$ret .= "<font color=maroon>������� �� �������� ���������</font><BR>";
			$ret .= "<font color=maroon>������� ������ ���������</font><BR>";
			if ($row['type'] == 3) $ret .= "<font color=maroon>������� ������ ��������</font><BR>";
			$ret .= "<font color=maroon>������� ������ ��������</font><BR>";
			$ret .= "<font color=maroon>������� ������ �������, �������� ��� ��������</font><BR>";

		}

	        if($row['sowner'] > 0) {
			if($row['sowner'] != $user['id']) {
				$so = mysql_query_cache('SELECT * from oldbk.users WHERE id = '.$row['sowner'].' AND id_city = 0',false,600);
				if (!count($so)) {
		        		$so = mysql_query_cache('SELECT * from avalon.users WHERE id = '.$row['sowner'].' AND id_city = 1',false,600);
				}
				if (!count($so)) {
		        		$so = mysql_query_cache('SELECT * from angels.users WHERE id = '.$row['sowner'].' AND id_city = 2',false,600);
				}

				if (count($so)) {
					$so = $so[0];
		        		$sowner = s_nick($so['id'],$so['align'],$so['klan'],$so['login'],$so['level']);
				}
	        	} else {
		        	$sowner = s_nick($user['id'],$user['align'],$user['klan'],$user['login'],$user['level']);
			}

	        	if ($row['type'] == 250) {
	        		$ret .= '<font color=red>������ ���� �����������</font> '.$sowner.'<br>';
			} elseif ($row['type'] == 210) {
				$ret .= '<font color=red>������ ���� ����� ������������</font> '.$sowner.'<br>';
			} elseif ($row['type'] == 200) {
				$ret .= '<font color=red>���� ������� ����� �������� ������</font> '.$sowner.'<br>';
			} elseif ( (($row['prototype'] >=56661) and  ($row['prototype'] <=56663)) or ($row['prototype']==9099) or ($row['prototype']==190199) or ($row['id']==9099) or ($row['id']==190199) or ($row['id']==190191) or ($row['prototype']==190191) or ($row['prototype']==190192) or ($row['prototype']==1121) )  {
				$ret .= '<font color=red>����� ������������� �� �������, �� ������ �������� � ��������� '.$sowner.'</font><br>';
			} elseif ( ($row['prototype']==56666 OR ($row['prototype']==1122) ) and ($row['sowner'] >0) and ($row['getfrom']==35) )  {
				//��������� ������
				$ret .= '<font color=red>����� ������������� �� �������, �� ������ �������� � ��������� '.$sowner.'</font><br>';
			}
			else {
	        		$ret .= '<font color=red>������ ���� ����� ������ ������</font> '.$sowner.'<br>';
			}
		}

		if ($row['present'] == "�������� �����" || $row['present'] == "��������� �����" || $row['arsenal_owner'] == 1) {
		 	$ret .= "<span style='display: inline-block;border: 1px solid;padding: 4px;border-style: inset;border-width: 1px;margin-top: 6px;margin-bottom: 6px;'> ".$row['letter']."</span><br>";
		}



		if ($row['goden']) {
			$ret .= "� ���� ��������: {$row['goden']} ��. ";
			if (!$row[GetShopCount()] or $_SERVER['PHP_SELF'] == '/comission.php' or ($_SERVER['PHP_SELF'] == '/main.php') ) {
				if ($row['dategoden']-time()<=(24*60*60)) {
					$ret .= "��������: <strong>".prettyTime(null,$row['dategoden'])."</strong> ";
				}
				$ret .= "(�� ".date("d.m.Y H:i",$row['dategoden']).")";

			}
			$ret .= "<BR>";
		}


		if ((($row_prototype>=946) and ($row_prototype <=957))) {
			$ret .='<small><font color=red>���������� ������������ ������ ����� 4-� ��������� �������, � ��� ����� �� ����� ������ ������</font></small><br>';
		}


		if ((($row['is_owner']==1 and $row['id']>=56661 and $row['id']<=56663) and ($check_price && $priv)) || ($row['is_owner'] == 1 && ($row_prototype == 9099 || $row_prototype == 190199 || $row_prototype == 190191 || $row_prototype == 190192 || $row_prototype == 1121))) {
			$ret .= '<small><font color=red>����� ������������� �� �������, �� ������ �������� � ���������!</font></small><br>';
		}

		if(($check_price && $priv) || $row['is_owner']==1) {
			$ret .= '<small><font color=red>����� ������� ���� ����� ��������� � ���������.</font></small><br>';
		} elseif (($_SERVER['PHP_SELF'] == '/cshop.php') AND ($row['id'] == 1000001 || $row['id'] == 1000002 || $row['id'] == 1000003)) {
			$ret .= '<small><font color=red>����� ������� ������� ����� ���������� ��������.</font></small><br>';
		}

		if (!(isset($row['prototype']))) {
			$row['prototype'] = $row['id'];
		}

		if ($row['id'] == 56663 || $row['id'] == 56664 || $row['id'] == 9597 || $row['prototype'] == 56663 || $row['prototype'] == 56664 || $row['prototype'] == 9597 || ($row['getfrom'] == 31 && $row['prototype'] == 56666) || ($_SERVER['PHP_SELF'] == '/fshop.php' && $row['id'] == 56666)) {
			$ret .= '<small><font color=red>����� ������������� �� �������, �� ������ �������� � ���������!</font></small><br>';
		}

		if($row['prokat_idp']>0) $ret .= "� ��������: ".floor(($row['prokat_do']-time())/60/60)." �. ".round((($row['prokat_do']-time())/60)-(floor(($row['prokat_do']-time())/3600)*60))." ���.<br>";
		if($magic['img'] && $row['type'] == 12 && $row['labonly']==0 && $row['dategoden'] == 0 && (in_array($row['id'],$can_inc_magic) OR in_array($row['prototype'],$can_inc_magic) ) ) {
			$ret .= "� ����� ������������ � ����<BR>";
			if (($row['getfrom'] == 43 && $row['repcost'] > 0 && $row['sowner'] > 0) || ($row['repcost'] > 0 && $row['is_owner'] > 0 && $_SERVER['PHP_SELF'] == '/cshop.php')) {
		       		$ret .= '<small><font color=red>��� ����������� ����� ������, �������, � ������� ������������ ������, ������ �������� � ��������� ������.</small></font><br>';
			}
		}
		if((!$magic['img'] || $row['labonly']==1 || $row['dategoden'] > 0 || (!(in_array($row['id'],$can_inc_magic) OR in_array($row['prototype'],$can_inc_magic) )) ) && $row['type'] == 12 )   $ret .= "� �� ����� ������������ � ����<BR>";

		if ($row['magic'] == 8888) {
			$ret .=  "� ����� ���� ����������� ������ �� ���� �������<br>";
		}

		if($magic['name'] && $magic['us_type'] == 2) $ret .= "� ����� ������������ ������ ��� ���<BR>";
		if($magic['name'] && $magic['us_type'] == 1) $ret .= "� ����� ������������ ������ � ���<BR>";
		if($magic['name'] && $magic['target_type'] == 1) $ret .= "� ����� ������������ ������ �� ����<BR>";

		if ($row['labonly']==1) {
			$ret .= "<font color=maroon>������� �������� ����� ������ �� ���������</font><BR>";
		}
		if(!$row['isrep']) {
			if (($_SERVER['PHP_SELF'] == "/fair.php" || $row['getfrom'] == 1) && ($row['dategoden'] > 0 || ($_SERVER['PHP_SELF'] == "/fair.php" && $row['razdel'] != 63)) && $row['type'] < 12 && ($row['gold'] > 0 || $_SERVER['PHP_SELF'] == "/fair.php")) {
				$ret .= "<font color=maroon>������� �������� ������� ������ �� ������</font><BR>";
			} else {
				$ret .= "<font color=maroon>������� �� �������� �������</font><BR>";
			}
		}

		if ((($row_prototype>=946) and ($row_prototype <=957)))	{
			$ret .= "<font color=maroon>������� �� �������� �����������</font><BR>";
			$ret .= "<font color=maroon>������� �� �������� ������</font><BR>";
		}

		if ($row['notsell']) {
			$ret .= "<font color=maroon>������� �� �������� ������� � ���. �������</font><BR>";
		}


		// ��������
		if (
			($row['id'] == 30012) OR ($row['prototype'] == 30012) ||
			(($row['id'] == 501) OR ($row['prototype'] == 501) OR ($row['id'] == 502) OR ($row['prototype'] == 502)) ||
			($magic['name'] && $row['type'] == 50) ||
			$row['rareitem'] > 0 ||
			$row['present'] ||
			$row['type'] == 27 ||
			$row['type'] == 28 ||
			$row['type'] == 34 ||
			$row['type'] == 35 ||
			$row['unik'] == 1 ||
			(($row['unik']==2) and ($row['type']!=200)) ||
			($magic['name'] && $row['type'] != 50) ||
			($row['text'] && $row[type]==3) ||
			($row['text'] && $row[type]==5)	||
			$row['present_text'] ||
			$incmagic['max'] ||
			$magic['chanse'] ||
			$magic['time']
		) {
			$ret .= "<br><b>��������:</b><br>";
		}

			/*
			�������� ������ � ���������
			819519071,857609931,852989950,841683378,828483816,826403146,828543140,806025808,789827764,787121628,827489408,827028176,787065587
			*/
			$item_old_nlevel=array(819519071,857609931,841683378,828483816,826403146,828543140,806025808,789827764,827489408,827028176,787065587);
			if (in_array($row['id'],$item_old_nlevel))
			{
			$ret .= "<font color=red>��� �������� ����������� ��������� ����� �������� ������� ������� ���������� �������� ���������� � ������������ ����� ����� ������ 10-�� ������.</font><br>";
			}



			if ($row['art_proto_id']>0)
			{
			$protorow=$row;
			$protorow['img']=$row['art_proto_img'];
			$protorow['name']=$row['art_proto_name'];
			$protorow['art_param']='';
			$ret .= "�������� ���������: ".link_for_item($protorow)."<br>";
			}

		if ($row['type'] == 27)	{
			$ret .= "� ����� �������� �� �����<br>";
		} elseif ($row['type'] == 28) {
			$ret .= "� ����� �������� ��� �����<br>";
		} elseif ($row['type'] == 34) {
			$ret .= "� ������ ������<br>";
		} elseif ($row['type'] == 35) {
			$ret .= "� ��������� ������<br>";
		}


		if ($magic['name'] && $row['type'] == 50) {
			if (stripos(substr($magic['name'],-4),'<br>') !== false) {
				$ret .= "� ".$magic['name'];
			} else {
				$ret .= "� ".$magic['name']."<BR>";
			}
		}


		if (($row['id'] == 30012) OR ($row['prototype'] == 30012)) {
			$ret .=  "� � ��� ���� ����������� ���� �������� ������<br>";
		}



		if (get_rkm_bonus_by_magic($row['magic'])>0)
			{
			$ret .= "� ������� ����� �� ���. �����: +".get_rkm_bonus_by_magic($row['magic'])."%<br>";
			}



		if($magic['name'] && $row['type'] != 50) $ret .= "<font color=maroon>�������� ��������:</font> ".$magic['name']."<BR>";

		if($row['unik']==1) {
			$ret .= "<font color=maroon><small><b>���� � ���������� ������������</b></small></font><br>";
		} elseif(($row['unik']==2) and ($row['type']!=200))  {
			$ret .= "<font color=#990099><small><b>���� � ���������� ���������� ������������</b></small></font><br>";
		}

		if($row['present']) $ret .= "������� ��: <b>".$prez[0]."</b><br>";

		if ($row['text'] && $row[type]==3) {
			$ret .= "�� ����� ������������� �������: ".$row['text']."<BR>";
		}
		if ($row['text'] && $row[type]==5) {
			$ret .= "�� ������ ������������� �������: ".$row['text']."<BR>";
		}
		if ($row['present_text']) {
			$ret .= "�� ������� ������� �����: ".$row['present_text']."<BR>";
		}
		if ($incmagic['max']) {
			$ret .= "�������� �������� <img src=\"http://i.oldbk.com/i/magic/".$incmagic['img']."\" title=\"".$incmagic['name']."\"> ".$incmagic['cur']."/".$incmagic['max']." ��.<BR> ";
			$ret .= "���������� �����������: ".$incmagic['uses']."<br>";
		}
		if ($magic['chanse']) {
			$ret .= "����������� ������������: ".$magic['chanse']."%<BR>";
		}
		if ($magic['time']) {
			$ret .= "����������������� �������� �����: ".get_delay_time($magic['time'])." <BR>";
		}

		if ($row['rareitem'] == 10) {
			$ret .= '<font color="#676565"><b>������� �������</b></font><BR>';
		}
		elseif ($row['rareitem'] == 1) {
			$ret .= '<font color="#34a122"><b>������ �������</b></font><BR>';
		}
		elseif ($row['rareitem'] == 2) {
			$ret .= '<font color="#2145ad"><b>������� �������</b></font><BR>';
		}
		elseif ($row['rareitem'] == 3) {
			$ret .= '<font color="#760c90"><b>����������� �������</b></font><BR>';
		}
	} else {
		$ret .= "<font color=maroon><B>�������� �������� �� ����������������</B></font><BR>";
	}

	// ������ ������� �������

	//@TODO places ������� � ����� ���������� �����, ����� �������� � LocationHelper::getPlace($place_id) (c) ����
	$places = array(
		1 => '������� ������ �� �������',
		2 => '������� ������� � ������� �����',
		3 => '������� ������� �� ����������� ����',
		4 => '������� ������� �� �������� �������',
		5 => '������� ������� �� ���������� �������',
		6 => '������� ������� �� ������� �����',
		7 => '������� ������� � ������� ������� ��� ���������',
		8 => '������� ������� �� ������ ������� �����',
		9 => '������� ������� - �����',
		10 => '������� ������� - �� ����� � ���������� �����',
		11 => '������� ������� � �������� ��������� �����',
		12 => '������� ������� � ������������ ��������� �����',
		13 => '������� ������� � ���������� ����� ��������',
		14 => '������� ������� � ���������� �����',
		20 => '������� ������� - ������� �������',
		21 => '������� ������� � ������� ���������� �����',
		30 => '������� ������� �� ������ �����',
		31 => '������� ������� �� ���������� ��������',
		32 => '������� ������� �� ���� ���-2018�',
		33 => '������� ������� �� ����������� ����',
		34 => '������� ������� �� ��������� ����������� ��������',
		35 => '������� ������� �� ������������ �����',
		36 => '������� ������� �� ������� �7 ��� �����!�',
		37 => '������� ������� �� ��������� ������ ������� �����',
		38 => '������� ������� �� ������� �8 ��� �����!�',
		40 => '������� ������� � ��������',
		41 => '������� ������ � ���.��������',
		42 => '������� ������ � �������',
		43 => '������� ������ � �������� �����',
		44 => '������� ���� � ������ � ��������� �����',
		45 => '������� ������ � ������ ������� �����',
		46 => '������� ������� �� ���������',
		47 => '������� ������� �� ������ �����',
		48 => '������� ������� �� ������������� ������ �����',
		56 => '������� ������� �� ���������� ��������' ,
		57 => '������� ������� � ���' ,
		77 => '������� ������� �� 7-�� ��������� �����',
		91 => '������� ���������� � ������� �������-����',
		92 => '������� ���������� � ������� �������-����',
		93 => '������� ���������� � ����������� ����� � ��������� �������-����',
		94 => '������� ���������� � ���������� �������� � ������� �������-����',
		95 => '������� ���������� � ���������� �������� �������-����',
		107 => '������� ������� �� ������� �������',
		108 => '������� ������� �� ������� ����������',
		109 => '������� ������� �� ������� �����',
		110 => '������� ������� �� ������� �������� �����',
		111 => '������� ������� �� ������� �������� �����',
		112 => '������� ������� �� ������� ������������ �����',
		113 => '������� ������� �� ������� ��������� ����',
		114 => '������� ������� �� ������� ������������ �����',
		120 => '������� ������� �� ����������� �����',
		121 => '������� ������� �� ���������� �����',
		122 => '������� ������� �� �������� �����',
		130 => '������� ������� �� ������� � ���������� � ����� �����������',
		131 => '������� ������� �� ����������� ���� �������',
		132 => '������� ������� �� �������� ����������� ����',

		141 => '������� ������� �� ������ ��������',
		142 => '������� ������� �� ��������� �����',
		143 => '������� ������� �� ����������� �������',
		144 => '������� ������� �� ������ �������',
    145 => '������� ������� �� ����� � ���������',
		151 => '������� ������� �� ������ ������������ �������',
		152 => '������� ������� �� �������� ������������ �������',
		153 => '������� ������� �� �������� ������������ �������',
		154 => '������� ������� �� ������������ ������������ �������',
		160 => '������� ������� �� ����� ������ ������� ����������',
		161 => '������� ������� �� ������� ������ ������� ����������',
		162 => '������� ������� �� ������� ������ ������� ����������',
		163 => '������� ������� �� ����������� ������ ������� ����������',

		//������ 200-300 ��� �������� (����)
		200 => '������� ������� �� ������� � �������� ��������� ���',

        //������ 301-400 ��� ������� (����)
		301 => '������� ������� � ������� ���-2018�',

	);
	if (isset($places[$row['getfrom']])) {
		$ret .= '<small><font color=maroon><b>'.$places[$row['getfrom']].'</b></font></small><BR>';
	}


	if  (($row['ab_mf'] > 0) or ($row['ab_bron'] > 0) or ($row['ab_uron']>0) || ($row['prototype'] >= 55510301 && $row['prototype'] <= 55510401) || ($row['prototype'] == 410027) ) {
		$ret .= "<br><b>��������:</b><br>";
		if ($row['ab_mf'] > 0) $ret .= "� ������������� ��.:+".$row['ab_mf']."%<br>";
		if ($row['ab_bron'] > 0) $ret .= "� �����:+".$row['ab_bron']."%<br>";
		if ($row['ab_uron'] > 0) $ret .= "� �����:+".$row['ab_uron']."%<br>";

/*
		$ekr_elka = array(55510312,55510313,55510314,55510315,55510316,55510317,55510318,55510319,55510320,55510321,55510322,55510334,55510335,55510336,55510337,55510338,55510339);
		$art_elka = array(55510323,55510324,55510325,55510326,55510327,55510340,55510341,55510342,55510343,55510344);
*/

		$ekr_elka = array(55510350);
		$art_elka = array(55510351);
		$sart_elka = array(55510352);


		$elkabonus = 0;

		if (($row['prototype'] >= 410021 AND $row['prototype'] <= 410026) AND (time()>mktime(0,0,0,7,5,2017))  )
		{
		// ����� ������� ����� ������� �����
			$elkabonus = 10;
		}
		elseif ((($row['prototype'] >= 55510301) AND ($row['prototype'] <= 55510311)) || (($row['prototype'] >= 55510328) AND ($row['prototype'] <= 55510333)) ) {
			//�������� ����
			$elkabonus = 1;
		} elseif ((in_array($row['prototype'],$ekr_elka))  || ($row['prototype'] >= 410021 AND $row['prototype'] <= 410026) || ($row['prototype'] >= 410130 AND $row['prototype'] <= 410135) || ($row['prototype'] >= 410001 AND $row['prototype'] <= 410008) )   {
			//������� ����
			$elkabonus = 2;
		} elseif (in_array($row['prototype'],$art_elka)) {
			//������� ����
			$elkabonus = 3;
		} elseif (in_array($row['prototype'],$sart_elka)) {
			$elkabonus = 10;
		} elseif ($row['prototype'] == 410027) {
			$elkabonus = 5;
		} elseif ($row['prototype'] == 410028) {
			$elkabonus = 10;
		}


		if ($elkabonus > 0) {
			$ret .= "� ������� �����: +".$elkabonus."%<br>";
		}

		if ($row['prototype'] == 55510351) {
			$ret .= "� �����: +10%<br>";
		}
		if ($row['prototype'] == 55510352) {
			$ret .= "� �����: +30%<br>";
			$ret .= "� ���������� ���������: +20%<br>";
		}
		if ($row['prototype'] == 410027) {
			$ret .= "� �����: +10%<br>";
			$ret .= "� ���������� ���������: +10%<br>";
		}
		if ($row['prototype'] == 410028) {
			$ret .= "� �����: +30%<br>";
			$ret .= "� ���������� ���������: +20%<br>";
		}
	} elseif (($_SERVER['PHP_SELF'] == '/cshop.php') AND (($row['id']>=6000) AND ($row['id'] <=6017))) {
		$runs_5lvl_param=array(
			"6000" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6001" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6002" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6003" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6004" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6005" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6006" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6007" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6008" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6009" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6010" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6011" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6012" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6013" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6014" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6015" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6016" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6017" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
		);

		//������ ����������� ��� � cshop
		$ab = $runs_5lvl_param[$row[id]];
		$ret .= "��������:<br>";

		if ($ab['ab_mf'] > 0) $ret .= "� ������������� ��.:0%<br>";
		if ($ab['ab_bron'] > 0) $ret .= "� �����:0%<br>";
		if ($ab['ab_uron'] > 0) $ret .= "� �����:0%<br>";
	}

	//����������� ��������� �� �����
	if (($row['bonus_info']!='') or ($row['charka']!='')) {
		$bohtml=array(
		'bron1' => '����� ������',
		'bron2' => '����� �������',
		'bron3' => '����� �����',
		'bron4' => '����� ���',
		'ghp' =>'������� �����' ,
		'mfkrit' =>'��. ����������� ������' ,
		'mfakrit' => '��. ������ ����. ������' ,
		'mfuvorot' => '��. ������������',
		'mfauvorot' =>'��. ������ ��������.',
		'gsila' =>'����' ,
		'glovk' => '��������' ,
		'ginta' => '��������',
		'gintel' =>'���������',
		'gmp' =>'��������',

		'fstat' =>'��������� ����������',
		'fmf' =>  '��������� ���������� ��' ,

		'stbonus' =>'��������� ����������',
		'mfbonus' =>  '��������� ���������� ��' ,

		'gw' => '���������� �������� �������' ,
		'gm' => '���������� ���������� c�����',

		'gnoj' =>'���������� �������� ������ � ���������' ,
		'gtopor' =>'���������� �������� �������� � ��������',
		'gdubina' => '���������� �������� ��������, ��������',
		'gmech' =>'���������� �������� ������',
		'gfire' =>'���������� ���������� c����� ����',
		'gwater' => '���������� ���������� c����� ����',
		'gair' => '���������� ���������� c����� �������',
		'gearth' => '���������� ���������� c����� �����',
		'ab_mf' =>'�������� ������������� ��',
		'ab_bron' => '�������� �����',
		'ab_uron' => '�������� �����');

		$pp=array(
		'mfkrit' =>'%' ,
		'mfakrit' => '%' ,
		'mfuvorot' => '%',
		'mfauvorot' =>'%',
		'mfbonus' =>'%',
		'ab_mf' =>'%',
		'ab_bron' => '%',
		'ab_uron' => '%');

		if ($row['bonus_info']!='') {
			$inputbonus=unserialize($row['bonus_info']); //��� ������
			if (is_array($inputbonus)) {
				$ret .= "<small><b><a onclick=\"showhide('art_{$row['id']}');\" href=\"javascript:Void();\">������ ���������:</a></small><BR>";
				$ret .= "<div id=art_{$row['id']} style=\"display:none;\"><small><b>";
				ksort($inputbonus);
				foreach($inputbonus as $blevl => $bdata) {
					$outtxt = 'X';
					if ($blevl == 1) $outtxt = 'I';
					if ($blevl == 2) $outtxt = 'II';
					if ($blevl == 3) $outtxt = 'III';
					if ($blevl == 4) $outtxt = 'IV';
					if ($blevl == 5) $outtxt = 'V';
					if ($blevl == 6) $outtxt = 'VI';

					$ret .= "&nbsp;&nbsp;��������� {$outtxt} ������:<br>";
					foreach($bdata as $k => $v) {
						if ($bohtml[$k]!='')
					  	{
						$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
						}
					}
				}
				$ret .= "</b></small></div>";
			}
		}

		if ($row['charka']!='') {
			$charka=substr($row['charka'], 2,strlen($row['charka'])-1); //���������� ������ ��� �������
			$inputbonus=unserialize($charka); //��� ������

			if (is_array($inputbonus)) {
				$ret .= "<small><b><a onclick=\"showhide('art_{$row['id']}');\" href=\"javascript:Void();\">������ ���������:</a></small><BR>";
				$ret .= "<div id=art_{$row['id']} style=\"display:none;\"><small><b>";
				ksort($inputbonus);
				foreach($inputbonus as $blevl => $bdata) {
					$outtxt = 'X';
					if ($blevl == 1) $outtxt = 'I';
					if ($blevl == 2) $outtxt = 'II';
					if ($blevl == 3) $outtxt = 'III';
					if ($blevl == 4) $outtxt = 'IV';
					if ($blevl == 5) $outtxt = 'V';
					if ($blevl == 6) $outtxt = 'VI';

					$ret .= "&nbsp;&nbsp;��������� {$outtxt} ������:<br>";
					foreach($bdata as $pk => $pv) {
						foreach($pv as $k => $v) {
						  if ($bohtml[$k]!='')
						  	{
							$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
							}
						}
					}
				}
				$ret .= "</b></small></div>";
			}
		}
	}

	if (isset($_GET['otdel']) && in_array($_GET['otdel'],$unikrazdel) && ($_SERVER['PHP_SELF'] == "/eshop.php")) {
		$tmp = mt_rand(0,9999999);
		$ret .= "<small><b><a onclick=\"showhide('unik_{$row['id']}_{$tmp}');return false;\" href=\"#\">�����������:</a></small><BR>";
		$ret .= "<div id='unik_{$row['id']}_{$tmp}' style=\"display:none;\"><small><b>";


		if ($row['gsila'] > 0 || $row['glovk'] > 0 || $row['ginta'] > 0 || $row['gintel'] > 0 || $row['gmp'] > 0) {
			$ret .= "� �����: +3<br>";
		}
		if ($row['ghp'] > 0) $ret .= "� ������� �����: +20<br>";
		if ($row['bron1'] > 0 || $row['bron2'] || $row['bron3'] || $row['bron4']) $ret .= "� �����: +3<br>";

		$ret .= "</b></small></div>";
	}

	if (strlen($row['mfinfo'])) {
		$tmp2 = mt_rand(0,9999999);
		$tmp = unserialize($row['mfinfo']);
		if ($tmp !== false && count($tmp) > 0) {
			$ret .= "<small><b><a onclick=\"showhide('unikinfo_{$row['id']}_{$tmp2}');return false;\" href=\"#\">�����������:</a></small><BR>";
			$ret .= "<div id='unikinfo_{$row['id']}_{$tmp2}' style=\"display:none;\"><small><b>";

			if (isset($tmp['stats']) && $tmp['stats'] > 0) {
				$ret .= "� �����: +".$tmp['stats']."<br>";
			}
			if (isset($tmp['hp']) && $tmp['hp'] > 0) {
				$ret .= "� ������� �����: +".$tmp['hp']."<br>";
			}
			if (isset($tmp['bron']) && $tmp['bron'] > 0) {
				$ret .= "� �����: +".$tmp['bron']."<br>";
			}

			$ret .= "</b></small></div>";
		}
	}


	/* http://tickets.oldbk.com/issue/oldbk-286
	if (($row['idcity']==1) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'avaloncity.oldbk.com'))) {
		$ret .= "<small>������� � AvalonCity</small>";
	} elseif (($row['idcity']==2) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'angelscity.oldbk.com'))) {
		$ret .= "<small>������� � AngelsCity</small>";
	} elseif (($row['idcity'] == 0) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'capitalcity.oldbk.com'))) {
		$ret .= "<small>������� � CapitalCity</small>";
	}
	*/

	// ���������� �� ���� ������

	if($row['type'] == 555) {
		$ret .= "<br><small><font color=red>������ ������ �������� �� ����������� � �������. �� ������ ������� ��� ������ � ���. �������.</red></small>";
	}

	if (($row['bs_owner']==0) and ($user['ruines']==0) and ($row['labonly']==0) and ($row['prototype']!=55510000)) {
		$ups_types=array(1,2,3,4,5,8,9,10,11);
		$ebarr=array(128,17,149,148);


		if ((strpos($row['name'], '[') == true) AND (in_array($row['prototype'],$ebarr))) {
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		} elseif ((strpos($row['name'], '[') == true) AND ($row['art_param']!='') )
			{//�� ����� ������:
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		} elseif ((strpos($row['name'], '[') == true) AND (($row['type']==28) OR $row['prototype']==100028 OR $row['prototype']==100029 OR $row['prototype']==173173 OR $row['prototype']==2003 OR $row['prototype']==195195)) {
			//�� ����� ������� ���� �������:
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		} elseif ( (strpos($row['name'], '[') == true) AND (in_array($row['type'],$ups_types)) AND $row['ab_mf']==0  AND $row['ab_bron']==0  AND $row['ab_uron']==0) { // �� ���� ����
			//�� �������
			$ret .= "<br><small><font color=red>��������! ��� ������ ���� ���� ���������� � ������������ �����, ������ ��������� ������.</red></small>";
		}
	}

	if (($row['art_param']!='') and ($row['nsila']==5000)) {
		$ret .= "<br><small><font color=red>���������� �������, ������� ���������� �������� � ������������ ������ � ������� ��������� ����������� �� ���������� ����� ���������.</red></small>";
	}


	if($row['type']==556) {
		$ret .= "<br><small><font color=red>������ ������� ������� �� ����������� � �������. ������������� �����</font></small>";
	}

	if($row['bonus_ghp']>0) {
		$ret .= "<br><br><font color=red>������� ������: <br> ";

		if ($row['bonus_ghp'] > 0)   { $ret .= "� ������� �����: +".$row['bonus_ghp']."<br>"; }
		if ($row['bonus_gsila'] > 0) { $ret .= "� ����: +".$row['bonus_gsila']."<br>";  }
		if ($row['bonus_glovk'] > 0) { $ret .= "� ��������: +".$row['bonus_glovk']."<br>";  }
		if ($row['bonus_ginta'] > 0) {$ret .= "� ��������: +".$row['bonus_ginta']."<br>";  }
		if ($row['bonus_gintel'] > 0){$ret .= "� ���������: +".$row['bonus_gintel']."<br>"; }

		if ($row['bonus_mfkrit']>0) 	{$ret .= "� ��. ����������� ������: +".$row['bonus_mfkrit']."%<br>"; }
		if ($row['bonus_mfakrit']>0) 	{$ret .= "� ��. ������ ����. ������: +".$row['bonus_mfakrit']."%<br>"; }
		if ($row['bonus_mfuvorot']>0) {	$ret .= "� ��. ������������: +".$row['bonus_mfuvorot']."%<br>"; }
		if ($row['bonus_mfauvorot']>0) {$ret .= "� ��. ������ ��������.: +".$row['bonus_mfauvorot']."%<br>"; }

		if ($row['bonus_gfire']>0) {$ret .= "� ���������� ���������� c����� ����: +".$row['bonus_gfire']."<br>"; }
		if ($row['bonus_gwater']>0) {$ret .= "� ���������� ���������� c����� ����: +".$row['bonus_gwater']."<br>"; }
		if ($row['bonus_gair']>0) {$ret .= "� ���������� ���������� c����� �������: +".$row['bonus_gair']."<br>"; }
		if ($row['bonus_gearth']>0) {$ret .= "� ���������� ���������� c����� �����: +".$row['bonus_mfauvorot']."<br>"; }

		$ret.="</font>";
	}

	if (strlen($row['craftedby'])) {
		$ret .= '<br>������� ������ �������� '.BNewRender($row['craftedby']).'<BR>';;
	}

	$ret .= "</td></TR>";

	if ($retdata > 0) {
		return $ret;
	} else {
		echo $ret;
	}
}


function setup_user_stats($che,$count=1) {
	$count=(int)($count);
	//���� ��������� ����� �� ���� ����!
	// �������� �� ����� �����
	$allisgood = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id = '{$_SESSION['uid']}' and stats >=".$count." LIMIT 1;"));

	$ok=0;
	$ok=($allisgood[stats]>=$count?1:0);
	$ok=($che=='intel'?($allisgood['level'] > 3?1:0):$ok);
	$ok=($che=='mudra'?($allisgood['level'] > 6?1:0):$ok);

 	if($ok==1) {
		$cheup=$che;
		$cheup=$allisgood[$cheup]+$count;
		$bonusup=$allisgood[stats]-$count;
		mysql_query("UPDATE users SET `".$che."`= ".$cheup.",`stats` = ".$bonusup." WHERE  id=".$allisgood[id].";");

		if($allisgood['in_tower'] == 15) {
			 mysql_query("UPDATE `dt_realchars`
			 		SET `".$che."`= ".$cheup.",`stats` = ".$bonusup."
			 		WHERE `owner` = '{$_SESSION['uid']}' LIMIT 1;");
		}
    		if($che=='vinos') {
		         mysql_query("UPDATE `users` SET `maxhp` = (IFNULL((SELECT SUM(`ghp`) FROM oldbk.`inventory`
					WHERE id IN (".GetDressedItems($allisgood,DRESSED_ITEMS).")),0) + (users.vinos*6) + (users.bpbonushp))
					WHERE id=".(int)$_SESSION['uid']." ;");
		}
	    	if($che=='mudra') {
	        	mysql_query("UPDATE `users` SET
	         		`maxmana` = (mudra*10), `mana` =  IF((mudra*10)<mana,(mudra*10),mana)
	          		WHERE id=".(int)$_SESSION['uid']." ;");
	    	}
	} else {
 		echo '<font color=red><b>�� ���� ��� ������...</b></font>';
 	}
}

function setup_naem_stats($che,$count=1,$naem) {
	$count=(int)($count);
	//���� ��������� ����� �� ���� ����!
	// �������� �� ����� �����
	$allisgood = mysql_fetch_array(mysql_query("SELECT * FROM users_clons WHERE id = '{$naem['id']}' and stats >=".$count." LIMIT 1;"));

	$ok=0;
	$ok=($allisgood['stats']>=$count?1:0);
	$ok=($che=='intel'?($allisgood['level'] > 3?1:0):$ok);
	$ok=($che=='mudra'?($allisgood['level'] > 6?1:0):$ok);

 	if($ok==1) {
		$cheup=$che;
		$cheup=$allisgood[$cheup]+$count;
		$bonusup=$allisgood[stats]-$count;
		mysql_query("UPDATE users_clons SET `".$che."`= ".$cheup.",`stats` = ".$bonusup." WHERE  id=".$allisgood['id'].";");

    		if($che=='vinos') {
		         mysql_query("UPDATE `users_clons` SET `maxhp` = (IFNULL((SELECT SUM(`ghp`) FROM oldbk.`inventory`
					WHERE id IN (".GetDressedItems($allisgood,DRESSED_ITEMS).")),0) + (users_clons.vinos*6))
					WHERE id=".(int)$naem['id']." ;");
		}
	    	if($che=='mudra') {
	        	mysql_query("UPDATE `users_clons` SET
	         		`maxmana` = (mudra*10), `mana` =  IF((mudra*10)<mana,(mudra*10),mana)
	          		WHERE id=".(int)$naem['id']." ;");
	    	}
	} else {
 		echo '<font color=red><b>�� ���� ��� ������...</b></font>';
 	}
}

//setupitem - ������� ������ �� ������
function setupitem($id,$che,$count=1) {
//���� ��������� ����� �� ���� ����!
// �������� �� ����� �����
$gche="g".$che;
$allisgood = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory WHERE id = '{$id}' and owner = '{$_SESSION['uid']}' and stbonus >=".$count." and dressed= 0  LIMIT 1;"));

//���������� ������ � ��� �����������
$art_param=explode(',',$allisgood['art_param']);

if (
	(($allisgood[id]=$id) and ($allisgood[stbonus]>=$count) and ($allisgood[$gche] !=0) or ($allisgood[$gche] !=0)) OR
	(($allisgood[id]=$id) and ($allisgood[stbonus]>=$count) and (in_array($gche, $art_param))  )

   )
 {
	//���� ���������� ������
	// ����������� ������ ���� � �������� �� ������
		$cheup="g{$che}";
		$cheup=$allisgood[$cheup]+$count;
		$bonusup=$allisgood[stbonus]-$count;
		mysql_query("UPDATE oldbk.inventory SET g{$che}= '{$cheup}',`stbonus` = '{$bonusup}' WHERE id='{$allisgood[id]}';");

 }else
 {
 	echo '<font color=red><b>������������ ���������� ��� �������������, ���������� ������ ������ ��������.</b></font>';
 }

}

//setupitemMF - ������� ������ �� ������

function setupitemmf($id,$che,$count=1) {
//���� ��������� ����� �� ���� ����!
// �������� �� ����� �����
$mche="mf".$che;

$allisgood = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory WHERE id = '{$id}' and owner = '{$_SESSION['uid']}' and mfbonus >=".$count." and dressed= 0  LIMIT 1;"));
//���������� ������ � ��� �����������
$art_param=explode(',',$allisgood['art_param']);
if (
	(($allisgood[id]=$id) and  ($allisgood[mfbonus]>=$count) and ($allisgood[$mche] !=0) ) OR
	(($allisgood[id]=$id) and  ($allisgood[mfbonus]>=$count) and (in_array($mche, $art_param)))
   )
	 {
	//���� ���������� ������
	// ����������� ������ MF � �������� �� ������
	$cheup="mf{$che}";
	$cheup=$allisgood[$cheup]+$count;
	$bonusup=$allisgood[mfbonus]-$count;

	mysql_query("UPDATE oldbk.inventory SET mf{$che}= '{$cheup}',`mfbonus` = '{$bonusup}' WHERE id='{$allisgood[id]}';");

	 }
	 else
	 {
	 	echo '<font color=red><b>�� ���� ��� ������...</b></font>';
	 }

}

// magic
function magicinf ($id) {

	if ($id>0)
		{
		$q = mysql_query_cache("SELECT * FROM oldbk.`magic` WHERE   `id` = '{$id}' LIMIT 1;",false,600);
		return $q[0];
//		$q = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`magic` WHERE   `id` = '{$id}' LIMIT 1;"));
//		return $q;
		}
		else
		{
		return null;
		}
}


function render_vstroj($count) {
	if ($count < 1) return "";

	if ($count > 4) {
		$ret = '<div class="vstroj-outer double">';
	} else {
		$ret .= '<div class="vstroj-outer">';
	}
	for ($i = 0; $i < ceil($count/4);$i++) {
		$ret .= '<ul>';
		for ($z = 0; $z < 4; $z++) {
			if (($i*4)+$z >= $count) {
				$ret .= '</ul>';
				break 2;
			}
			$ret .= '<li class="vstroj-item"><div class="point"></div></li>';
		}
		$ret .= '</ul>';
	}
	$ret .= '</div>';
	return $ret;
}


// �������� ����� � ����
function showpersinv($user,$isnaem = 0) {
	global $mysql,$USER_MF_DATA,$WEP_TYPE,$WEP_TYPE2,$nclass_name;
	$WEP_TYPE='';
	$WEP_TYPE2='';
	//$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
	$id=$user['id'];

	$all_dressed_load=mysql_query('select * from oldbk.inventory where
		id in ('.GetDressedItems($user).')'
	);
	if(mysql_affected_rows()>0)
		    {
		     $all_item_mass=array();
		       while($item_row=mysql_fetch_array($all_dressed_load))
		       {
			$item_row['name']=str_replace('\\','\\\\',$item_row['name']);

		        $all_item_mass[$item_row[id]]=$item_row;

		        // ��� �������� � main.php - � �������� ��� �������

		        	if (($user['shit']==$item_row['id']) AND (($item_row['prototype']==501)||($item_row['prototype']==502))   )
		        	{
		        	//����������� ���� �� ������� � ����� ����
		        	$item_row['minu']=0;
				$item_row['maxu']=0;
		        	}
		        	elseif (($user['weap']==$item_row['id']) AND (($item_row['prototype']==501)||($item_row['prototype']==502))   )
		        	{
		        	//����������� ����� �� ������� � ����� ������
		        	$item_row['bron1']=0;
		        	$item_row['bron2']=0;
		        	$item_row['bron3']=0;
		        	$item_row['bron4']=0;
		        	}

			if ($item_row['type']==34)
			{
			$USER_MF_DATA['min_u2']+=$item_row['minu'];
			$USER_MF_DATA['max_u2']+=$item_row['maxu'];
			}
			else
			{
			$USER_MF_DATA['minu']+=$item_row['minu'];
			$USER_MF_DATA['maxu']+=$item_row['maxu'];
			}


			$USER_MF_DATA['mfkrit']+=$item_row['mfkrit'];
			$USER_MF_DATA['mfakrit']+=$item_row['mfakrit'];
			$USER_MF_DATA['mfuvorot']+=$item_row['mfuvorot'];
			$USER_MF_DATA['mfauvorot']+=$item_row['mfauvorot'];
			$USER_MF_DATA['bron1']+=$item_row['bron1'];
			$USER_MF_DATA['bron2']+=$item_row['bron2'];
			$USER_MF_DATA['bron3']+=$item_row['bron3'];
			$USER_MF_DATA['bron4']+=$item_row['bron4'];
			$USER_MF_DATA['ab_mf']+=$item_row['ab_mf'];
			$USER_MF_DATA['ab_bron']+=$item_row['ab_bron'];
			$USER_MF_DATA['ab_uron']+=$item_row['ab_uron'];

			if ($item_row['unik']==1)
				{
				$USER_MF_DATA['unik']++;
				}
			elseif ($item_row['unik']==2)
				{
				$USER_MF_DATA['supunik']++;
				}


		       }
		    }
?>
	<CENTER>
	<img src="http://i.oldbk.com/i/align_<?echo ($user['align']>0 ? $user['align']:"0");?>.gif"><?php if ($user['klan'] <> '') { echo '<img src="http://i.oldbk.com/i/klan/'.$user['klan'].'.gif">'; } ?><B><?=$user['login']?></B> [<? if (($user['level']==13) and ($user['exp']>=8000000000) ) { echo "<font color=#F03C0E><b>{$user['level']}</b></font>"; } else { echo $user['level']; } ?>]<a href=inf.php?<?=$user['id']?> target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � <?=$user['login']?>"></a> <?php
		if ($isnaem == 1 && $user['in_tower'] == 0) {
			?>
			<a href="?edit=1&naeminv"><img title="������������� �� ��������� �������" alt="������������� �� ��������� �������" src="http://i.oldbk.com/i/naem/redo_forward.png"></a>
			<?php
		} elseif ($isnaem == 2 && $user['in_tower'] == 0) {
			?>
			<a href="?edit=1&normalinv"><img title="������������� �� ��������� ������" alt="������������� �� ��������� ������" src="http://i.oldbk.com/i/naem/redo_forward.png"></a>
			<?php
		}
		?>
	<?
	if (($user[lab]==2) OR ($user[lab]==4))
	{
	echo setHP($user['hp'],$user['maxhp'],1);
	}
	else
	{
	echo setHP($user['hp'],$user['maxhp'],$battle);
	}

	if ($user['maxmana']) {
		echo setMP($user['mana'],$user['maxmana'],$battle);
	}

	if (($isnaem == 2) and ($user['fullentime'] >0 ))
	{
	//���� ���������� ����� � � ���� ���� ����� ������ ������� �� ������ ��
		echo setnaemEN($user['energy'],($user['level']*5),$battle);
	}

	?>
<TABLE cellspacing=0 cellpadding=0>
<?if ($user['level'] > 3 && $isnaem != 2) {?>
<TR>
	<TD colspan=3>
	<?
		if ($user['m1'] > 0) {

			 $dress=$all_item_mass[$user['m1']];
			 if ($dress[id]>0)
			   {
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
				echo '<a href="?edit=1&drop=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
			   }
			   else
			   {
			   // ���� ����� �������������� ������
			   	mysql_query("UPDATE `users` SET `m1`=0 WHERE `id`={$user['id']} LIMIT 1; ");
			   	$mess='������ ���� �����';
			   	echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';

			   }
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}

		if ($user['m2'] > 0) {

			 $dress=$all_item_mass[$user['m2']];
			 if ($dress[id]>0)
			{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=13"><img  onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
			}
			else
			{
		      // ���� ����� �������������� ������
		    mysql_query("UPDATE `users` SET `m2`=0 WHERE `id`={$user['id']} LIMIT 1; ");
			$mess='������ ���� �����';
			echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
			}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		  }

		if ($user['m3'] > 0) {

			 $dress=$all_item_mass[$user['m3']];
			 if ($dress[id]>0)
			{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=14"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
			}
			else
			{
		      // ���� ����� �������������� ������
		         mysql_query("UPDATE `users` SET `m3`=0 WHERE `id`={$user['id']} LIMIT 1; ");
			$mess='������ ���� �����';
			echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
			}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		  }

		if ($user['m4'] > 0) {

			$dress=$all_item_mass[$user['m4']];
			 if ($dress[id]>0)
			{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=15"><img  onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
			}
			else
			{
 	        	// ���� ����� �������������� ������
	        	  mysql_query("UPDATE `users` SET `m4`=0 WHERE `id`={$user['id']} LIMIT 1; ");
			  $mess='������ ���� �����';
			  echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
			  }
			} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		  	}

		if ($user['m5'] > 0) {

			$dress=$all_item_mass[$user['m5']];
			 if ($dress[id]>0)
		{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=16"><img  onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
		}
		else
		{
	        mysql_query("UPDATE `users` SET `m5`=0 WHERE `id`={$user['id']} LIMIT 1; ");
		$mess='������ ���� �����';
		echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		  }
	?>
	</TD>
</TR>
<TR>
	<TD colspan=3>
	<?
		if ($user['m6'] > 0) {

			$dress=$all_item_mass[$user['m6']];
		 if ($dress[id]>0)
		{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=17"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
		}
		else
		{
	        mysql_query("UPDATE `users` SET `m6`=0 WHERE `id`={$user['id']} LIMIT 1; ");
		$mess='������ ���� �����';
		echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
		if ($user['m7'] > 0) {

		$dress=$all_item_mass[$user['m7']];
		 if ($dress[id]>0)
		{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=18"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
		}
		else
		{
	        mysql_query("UPDATE `users` SET `m7`=0 WHERE `id`={$user['id']} LIMIT 1; ");
		$mess='������ ���� �����';
		echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif width=40 height=25></a>';
		}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif width=40 height=25></a>';
		}
		if ($user['m8'] > 0) {

		$dress=$all_item_mass[$user['m8']];
		if ($dress[id]>0)
		{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=19"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
		}
		else
		{
	        mysql_query("UPDATE `users` SET `m8`=0 WHERE `id`={$user['id']} LIMIT 1; ");
		$mess='������ ���� �����';
		echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
		if ($user['m9'] > 0) {

		$dress=$all_item_mass[$user['m9']];
		 if ($dress[id]>0)
		{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=20"><img  onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
		}
		else
		{
			        mysql_query("UPDATE `users` SET `m9`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		  }
		if ($user['m10'] > 0) {

		$dress=$all_item_mass[$user['m10']];
		 if ($dress[id]>0)
		{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop=21"><img  onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
		}
		else
		{
			        mysql_query("UPDATE `users` SET `m10`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';

		}
		} else {
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
	?>
	</TD>
</TR>
<tr>
	<td colspan="3">
<?
$repcount = (int)$user['rep']/ 20000;
if($repcount < 0) $repcount = 0;
if($repcount > 5) $repcount = 5;
for($i = 1; $i <= $repcount; $i++)
{
	if ($user['m1'.$i] > 0)
	{

		$dress=$all_item_mass[$user['m1'.$i]];
		if ($dress[id]>0)
		{
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
			echo '<a href="?edit=1&drop='.(21 + $i).'"><img  onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
		}
		else
		{
			mysql_query("UPDATE `users` SET `m1".$i."`=0 WHERE `id`={$user['id']} LIMIT 1; ");
			$mess='������ ���� �����';
			echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
	}
	else
	{
		$mess='������ ���� �����';
		echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
	}
}
?>
	</td>
</tr>
<?php
if ($user['prem'] > 0 && $user['in_tower'] == 0) {
	echo '<tr><td>';
	for ($i = 16; $i <= getMaximumSlot($user['prem']); $i++) {
		if ($user['m'.$i] > 0) {
			$dress=$all_item_mass[$user['m'.$i]];
			if ($dress['id'] > 0) {
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'];
				echo '<a href="?edit=1&drop='.(18 + $i).'"><img  onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=40 height=25></a>';
			} else {
				mysql_query("UPDATE `users` SET `m".$i."`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
			}
		} else {
			$mess='������ ���� �����';
			echo '<a href="?edit=1&filt=12"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,35,20,\''.$mess.'\')" src=http://i.oldbk.com/i/w13.gif  width=40 height=25></a>';
		}
	}
	echo '</td></tr>';
}
?>


<?}?>
<TR>
<TD valign=top>
<TABLE width=196 cellspacing=0 cellpadding=0 ><tr><td valign=top>
<TABLE width=100% cellspacing=0 cellpadding=0 >
	<TR><TD
	<?php

		if ($user['sergi'] > 0) {
			$dress=$all_item_mass[$user['sergi']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}
				else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������� ������������� '.$dress['text']:'');

				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);
					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=1"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=20></a></div>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `sergi`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ������';
				echo '<a href="?edit=1&filt=1"><img src="http://i.oldbk.com/i/w1.gif" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\''.$mess.'\')"></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ������';
			echo '<a href="?edit=1&filt=1"><img src="http://i.oldbk.com/i/w1.gif" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\''.$mess.'\')"></a>';
		}
	?></TD></TR>
	<TR><TD <?php
		if ($user['kulon'] > 0) {

			$dress=$all_item_mass[$user['kulon']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}
				else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������������� '.$dress['text']:'');

				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}

				echo '<a href="?edit=1&drop=2"><div style="position:relative;">'.$vstr.'<img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\''.$mess.'\')"></div></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `kulon`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ��������';
				echo '<a href="?edit=1&filt=2"><img src="http://i.oldbk.com/i/w2.gif" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\''.$mess.'\')"></a>';
			}
		}
		else
		{
			echo '>';
			$mess='������ ���� ��������';
			echo '<a href="?edit=1&filt=2"><img src="http://i.oldbk.com/i/w2.gif" width=60 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,15,\''.$mess.'\')"></a>';
		}
	?></TD></TR>
	<TR><TD <?php
		if ($user['weap'] > 0) {
			$WEP_TYPE="kulak";// default
			$dress=$all_item_mass[$user['weap']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}
				else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$dress['text']=str_replace("&#39;", "\&#39;", $dress['text']);
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������������� '.$dress['text']:'');

				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=3"><div style="position:relative;">'.$vstr.'<img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')"></div></a>';

				//����������� ���� ������ ��� main.php
				if($dress['otdel'] == '1') { $WEP_TYPE="noj"; }
				elseif($dress['otdel'] == '12') { $WEP_TYPE="dubina"; }
				elseif($dress['otdel'] == '11') { $WEP_TYPE="topor"; }
				elseif($dress['otdel'] == '13') { $WEP_TYPE="mech";	}
				elseif(($dress['prototype'] == 501) OR ($dress['prototype'] == 502) ) { $WEP_TYPE="kostil";}
				elseif( ($dress['otdel'] == '6') and  (($dress['prototype']>=55510301) and ($dress['prototype']<=55510401)))  { $WEP_TYPE="elka";	}
				elseif( ($dress['otdel'] == '6') and  (($dress['prototype']>=410001) and ($dress['prototype']<=410030)))  { $WEP_TYPE="buket";	}
				elseif($dress['minu'] > 0) { $WEP_TYPE="buket"; } else { $WEP_TYPE="kulak"; }
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `weap`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ������';
				echo '<a href="?edit=1&filt=3"><img onMouseOut="HideOpisShmot()" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/w3.gif" width=60 height=60 ></a>';
			}
		}
		else{
			$WEP_TYPE="kulak";
			echo '>';
			$mess='������ ���� ������';
			echo '<a href="?edit=1&filt=3"><img onMouseOut="HideOpisShmot()" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/w3.gif" width=60 height=60 ></a>';
		}
	?></TD></TR>
	<TR><TD
	<?=(((($all_item_mass[$user['rubashka']]['maxdur']-2)<=$all_item_mass[$user['rubashka']]['duration'] && $all_item_mass[$user['rubashka']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>
	<?=(((($all_item_mass[$user['bron']]['maxdur']-2)<=$all_item_mass[$user['bron']]['duration'] && $all_item_mass[$user['bron']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>
	<?=(((($all_item_mass[$user['nakidka']]['maxdur']-2)<=$all_item_mass[$user['nakidka']]['duration'] && $all_item_mass[$user['nakidka']]['duration'] > 2 && !$pas)?" style='background-image:url(http://i.oldbk.com/i/blink.gif);'  ":""))?>
	> <?php
	// ������ ��� ���������
	if (($user['bron'] > 0) and ($user['nakidka'] > 0 ) and ($user['rubashka'] == 0 ) )
		{
		// � ����� � ������� - ���������� ������ �������

			$dress=$all_item_mass[$user['nakidka']];

			if (!($dress[id]>0)) { mysql_query("UPDATE `users` SET `nakidka`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}


			$dress2=$all_item_mass[$user['bron']];
			if (!($dress2[id]>0)) { mysql_query("UPDATE `users` SET `bron`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress2['add_pick']!=''&& $dress2['pick_time']>time()){$dress2['img']=$dress2['add_pick'];}
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������ '.$dress['text']:'');
			$mess.='<br>--------------------<br>'.$dress2['name'].'<br>��������� '.$dress2['duration'].'/'.$dress2['maxdur'].''.(($dress2['ghp']>0)?'<br>������� ����� +'.$dress2['ghp']:'').(($dress2['text']!=null)?'<br>�� ������ ������ '.$dress2['text']:'');

			if ($dress['includemagicdex']) {
				$dr = shincmag($dress);

				$vstr = render_vstroj($dress['includemagicdex']);
			}
			elseif ($all_item_mass[$user['bron']]['includemagicdex']) {
				$dr = shincmag($all_item_mass[$user['bron']]);

				$vstr = render_vstroj($all_item_mass[$user['bron']]['includemagicdex']);
			}

			else {
				$vstr = '';
			}

			echo '<a href="?edit=1&drop=27"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80></div></a>';

		}
		 else
		if (($user['bron'] == 0) and ($user['nakidka'] > 0 ) and ($user['rubashka'] == 0 ))
		{
		//������ �������

			$dress=$all_item_mass[$user['nakidka']];
			if ($dress[id]>0)
			{
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������ '.$dress['text']:'');

				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=27"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80></div></a>';
			}
			else
			{
				mysql_query("UPDATE `users` SET `nakidka`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=4"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/w4.gif" width=60 height=80></a>';
			}

		}
		else
		if (($user['bron'] > 0) and ($user['nakidka'] == 0 ) and ($user['rubashka'] == 0 ) )
		{
		// ������ �����

			$dress=$all_item_mass[$user['bron']];
			if ($dress[id]>0)
			{
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������ '.$dress['text']:'');

				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=4"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80></div></a>';
			}
			else
			{
				mysql_query("UPDATE `users` SET `bron`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=4"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/w4.gif" width=60 height=80></a>';
			}
		}
		else
		if (($user['bron'] == 0) and ($user['nakidka'] == 0 ) and ($user['rubashka'] > 0 ))
		{
		//������ �������

			$dress=$all_item_mass[$user['rubashka']];
			if ($dress[id]>0)
			{
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������ '.$dress['text']:'');
				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=28"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80></div></a>';
			}
			else
			{

				mysql_query("UPDATE `users` SET `rubashka`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=4"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/w4.gif" width=60 height=80></a>';
			}

		}
		elseif (($user['bron'] == 0) and ($user['nakidka'] > 0 ) and ($user['rubashka'] > 0 ))
		{
			//  ������� + ������� -  ��� �����
			$dress=$all_item_mass[$user['nakidka']];

			if (!($dress[id]>0)) { mysql_query("UPDATE `users` SET `nakidka`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}


			$dress2=$all_item_mass[$user['rubashka']];

			if (!($dress2[id]>0)) { mysql_query("UPDATE `users` SET `rubashka`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress2['add_pick']!=''&& $dress2['pick_time']>time()){$dress2['img']=$dress2['add_pick'];}
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������ '.$dress['text']:'');
			$mess.='<br>--------------------<br>'.$dress2['name'].'<br>��������� '.$dress2['duration'].'/'.$dress2['maxdur'].''.(($dress2['ghp']>0)?'<br>������� ����� +'.$dress2['ghp']:'').(($dress2['text']!=null)?'<br>�� ������ ������ '.$dress2['text']:'');

			if ($dress['includemagicdex']) {
				$dr = shincmag($dress);

				$vstr = render_vstroj($dress['includemagicdex']);
			} else {
				$vstr = '';
			}
			echo '<a href="?edit=1&drop=27"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80></div></a>';

		}
		elseif (($user['bron'] > 0) and ($user['nakidka'] == 0 ) and ($user['rubashka'] > 0 ))
		{
		// ����� + ������� ��� �������
			$dress=$all_item_mass[$user['bron']];

			if (!($dress[id]>0)) { mysql_query("UPDATE `users` SET `bron`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}


			$dress2=$all_item_mass[$user['rubashka']];

			if (!($dress2[id]>0)) { mysql_query("UPDATE `users` SET `rubashka`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress2['add_pick']!=''&& $dress2['pick_time']>time()){$dress2['img']=$dress2['add_pick'];}
			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������ '.$dress['text']:'');
			$mess.='<br>--------------------<br>'.$dress2['name'].'<br>��������� '.$dress2['duration'].'/'.$dress2['maxdur'].''.(($dress2['ghp']>0)?'<br>������� ����� +'.$dress2['ghp']:'').(($dress2['text']!=null)?'<br>�� ������ ������ '.$dress2['text']:'');

			if ($dress['includemagicdex']) {
				$dr = shincmag($dress);

				$vstr = render_vstroj($dress['includemagicdex']);
			} else {
				$vstr = '';
			}
			echo '<a href="?edit=1&drop=4"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80></div></a>';

		}
		elseif (($user['bron'] > 0) and ($user['nakidka'] > 0 ) and ($user['rubashka'] > 0 ))
		{
			//��� ������
			$dress=$all_item_mass[$user['nakidka']];

			if (!($dress[id]>0)) { mysql_query("UPDATE `users` SET `nakidka`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}


			$dress2=$all_item_mass[$user['bron']];

			if (!($dress2[id]>0)) { mysql_query("UPDATE `users` SET `bron`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress2['add_pick']!=''&& $dress2['pick_time']>time()){$dress2['img']=$dress2['add_pick'];}

			$dress3=$all_item_mass[$user['rubashka']];

			if (!($dress3[id]>0)) { mysql_query("UPDATE `users` SET `rubashka`=0 WHERE `id`={$user['id']} LIMIT 1; "); } //���� ���� ���� ������� ��
			if($dress3['add_pick']!=''&& $dress3['pick_time']>time()){$dress3['img']=$dress3['add_pick'];}

			$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������ '.$dress['text']:'');
			$mess.='<br>--------------------<br>'.$dress2['name'].'<br>��������� '.$dress2['duration'].'/'.$dress2['maxdur'].''.(($dress2['ghp']>0)?'<br>������� ����� +'.$dress2['ghp']:'').(($dress2['text']!=null)?'<br>�� ������ ������ '.$dress2['text']:'');
			$mess.='<br>--------------------<br>'.$dress3['name'].'<br>��������� '.$dress3['duration'].'/'.$dress3['maxdur'].''.(($dress3['ghp']>0)?'<br>������� ����� +'.$dress3['ghp']:'').(($dress3['text']!=null)?'<br>�� ������ ������ '.$dress3['text']:'');

			if ($dress['includemagicdex']) {
				$dr = shincmag($dress);

				$vstr = render_vstroj($dress['includemagicdex']);
			}
			elseif ($all_item_mass[$user['bron']]['includemagicdex']) {
				$dr = shincmag($all_item_mass[$user['bron']]);

				$vstr = render_vstroj($all_item_mass[$user['bron']]['includemagicdex']);
			}
			else {
				$vstr = '';
			}
			echo '<a href="?edit=1&drop=27"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=80></div></a>';

		}
		else
		{
			$mess='������ ���� �����';
			echo '<a href="?edit=1&filt=4"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,75,\''.$mess.'\')" src="http://i.oldbk.com/i/w4.gif" width=60 height=80></a>';
		}
	?></TD></TR>
	<TR><TD>
	<TABLE cellspacing=0 cellpadding=0><tr>
		<td <?php
		if ($user['r1'] > 0) {

			$dress=$all_item_mass[$user['r1']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}
				else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������������� '.$dress['text']:'');
				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=5"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20></div></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `r1`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ������';
				echo '<a href="?edit=1&filt=5"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/w6.gif" width=20 height=20 ></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ������';
			echo '<a href="?edit=1&filt=5"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/w6.gif" width=20 height=20 ></a>';
		}
	?></td>
		<td <?php
		if ($user['r2'] > 0) {

			$dress=$all_item_mass[$user['r2']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������������� '.$dress['text']:'');

				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<div style="position:relative;"><a href="?edit=1&drop=6">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20></div></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `r2`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ������';
				echo '<a href="?edit=1&filt=5"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/w6.gif" width=20 height=20 ></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ������';
			echo '<a href="?edit=1&filt=5"><img src="http://i.oldbk.com/i/w6.gif" width=20 height=20 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')"></a>';
		}
	?></td>
		<td <?php
		if ($user['r3'] > 0) {

			$dress=$all_item_mass[$user['r3']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������ ������������� '.$dress['text']:'');
				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=7"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=20 height=20></div></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `r3`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ������';
				echo '<a href="?edit=1&filt=5"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/w6.gif" width=20 height=20 alt="������ ���� ������" ></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ������';
			echo '<a href="?edit=1&filt=5"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/w6.gif" width=20 height=20 alt="������ ���� ������" ></a>';
		}
	?></td>

        </tr></table>
</TD></TR>
</TABLE>
	</TD><TD valign=top><img src="http://i.oldbk.com/i/shadow/<?=$user['shadow']?>" height=209 alt="<?=$user['login']?>"></TD><TD valign=top>
<TABLE width=100% cellspacing=0 cellpadding=0>
	<TR><TD <?php
		if ($user['helm'] > 0) {

			$dress=$all_item_mass[$user['helm']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ����� ������������� '.$dress['text']:'');
				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=8"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60></div></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `helm`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ����';
				echo '<a href="?edit=1&filt=8"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/w9.gif" width=60 height=60></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ����';
			echo '<a href="?edit=1&filt=8"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/w9.gif" width=60 height=60></a>';
		}
	?></TD></TR>
	<TR><TD <?php
		if ($user['perchi'] > 0) {

			$dress=$all_item_mass[$user['perchi']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ��������� ������������� '.$dress['text']:'');
				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=9"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=40></div></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `perchi`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ��������';
				echo '<a href="?edit=1&filt=9"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\''.$mess.'\')" src="http://i.oldbk.com/i/w11.gif" width=60 height=40></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ��������';
			echo '<a href="?edit=1&filt=9"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\''.$mess.'\')" src="http://i.oldbk.com/i/w11.gif" width=60 height=40></a>';
		}
	?></TD></TR>
	<TR><TD <?php
		if ($user['shit'] > 0) {

			$dress=$all_item_mass[$user['shit']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ���� ������������� '.$dress['text']:'');
				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=10"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=60></div></a>';

				//����������� ���� ������ ��� main.php
				if ($dress['type']==34)
				{
				if($dress['otdel'] == '1') { $WEP_TYPE2="noj"; }
				elseif($dress['otdel'] == '12') { $WEP_TYPE2="dubina"; }
				elseif($dress['otdel'] == '11') { $WEP_TYPE2="topor"; }
				elseif($dress['otdel'] == '13') { $WEP_TYPE2="mech";	}
				//elseif(($dress['prototype'] == 501) OR ($dress['prototype'] == 502) ) { $WEP_TYPE2="kostil";}
				//elseif( ($dress['otdel'] == '6') and  (($dress['prototype']>=55510301) and ($dress['prototype']<=55510401)))  { $WEP_TYPE2="elka";	}
				elseif( ($dress['otdel'] == '6') and  (($dress['prototype']>=410001) and ($dress['prototype']<=410030)))  { $WEP_TYPE2="buket";	}
				//elseif($dress['minu'] > 0) { $WEP_TYPE2="buket"; } else { $WEP_TYPE2="kulak"; }
				}


			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `shit`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ���';
				echo '<a href="?edit=1&filt=10"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/w10.gif" width=60 height=60></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ���';
			echo '<a href="?edit=1&filt=10"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,55,\''.$mess.'\')" src="http://i.oldbk.com/i/w10.gif" width=60 height=60></a>';
		}
	?></TD></TR>
	<TR><TD <?php
		if ($user['boots'] > 0) {

			$dress=$all_item_mass[$user['boots']];
			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!='' && $dress['pick_time']>time()) {  $dress['img']=$dress['add_pick'];	}
				$mess='����� <b>'.$dress['name'].'</b><br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ������� ������� '.$dress['text']:'');
				if ($dress['includemagicdex']) {
					$dr = shincmag($dress);

					$vstr = render_vstroj($dress['includemagicdex']);
				} else {
					$vstr = '';
				}
				echo '<a href="?edit=1&drop=11"><div style="position:relative;">'.$vstr.'<img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=60 height=40></div></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `boots`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� �����';
				echo '<a href="?edit=1&filt=11"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\''.$mess.'\')" src="http://i.oldbk.com/i/w12.gif" width=60 height=40></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� �����';
			echo '<a href="?edit=1&filt=11"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,55,35,\''.$mess.'\')" src="http://i.oldbk.com/i/w12.gif" width=60 height=40></a>';
		}
	?></TD></TR>
</TABLE></td></tr></table>
</TD></TR>
</TABLE>
<?php
if ($isnaem != 2) {
?>
<TABLE cellspacing=0 cellpadding=0 border=0 style="background-image: url('http://i.oldbk.com/i/runes_slots.jpg'); background-position: center bottom; background-repeat: no-repeat;"><tr>
		<td width=59 height=48 align=right <?php
		if ($user['runa1'] > 0) {

			$dress=$all_item_mass[$user['runa1']];

			if (($dress['type'] == 30) ) // ������� �� ���� �������
				{
				// ����������  ��� ���� ���� ������
					if ($dress['ups'] >= $dress['add_time'])
					{
					$mig=explode(".",$dress['img']);
					$dress['img']=$mig[0]."_up.".$mig[1];
					}
				}


			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}
				else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>�������: '.$dress['up_level'].'<br>����: '.$dress['ups'].'<br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ���� ������������� '.$dress['text']:'');
				echo '<a href="?edit=1&drop=31"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 ></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `runa1`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ����';
				echo '<a href="?edit=1&filt=31"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src=http://i.oldbk.com/i/none.gif width=30 height=30 ></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ����';
			echo '<a href="?edit=1&filt=31"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src=http://i.oldbk.com/i/none.gif width=30 height=30  ></a>';
		}
	?></td>
		<td width=74 height=48 align=center <?php
		if ($user['runa2'] > 0) {

			$dress=$all_item_mass[$user['runa2']];

			if (($dress['type'] == 30) ) // ������� �� ���� �������
				{
				// ����������  ��� ���� ���� ������
					if ($dress['ups'] >= $dress['add_time'])
					{
					$mig=explode(".",$dress['img']);
					$dress['img']=$mig[0]."_up.".$mig[1];
					}
				}


			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>�������: '.$dress['up_level'].'<br>����: '.$dress['ups'].'<br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ���� ������������� '.$dress['text']:'');
				echo '<a onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" href="?edit=1&drop=32"><img src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 ></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `runa2`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ����';
				echo '<a href="?edit=1&filt=31"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src=http://i.oldbk.com/i/none.gif width=30 height=30 ></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ����';
			echo '<a href="?edit=1&filt=31"><img src=http://i.oldbk.com/i/none.gif width=30 height=30 onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')"></a>';

		}
	?></td>
		<td width=57 height=48 align=left <?php
		if ($user['runa3'] > 0) {

			$dress=$all_item_mass[$user['runa3']];

			if (($dress['type'] == 30) ) // ������� �� ���� �������
				{
				// ����������  ��� ���� ���� ������
					if ($dress['ups'] >= $dress['add_time'])
					{
					$mig=explode(".",$dress['img']);
					$dress['img']=$mig[0]."_up.".$mig[1];
					}
				}


			if ($dress[id]>0)
			{
				if(($dress['maxdur']-2)<=$dress['duration']  && $dress['duration'] > 2)
				{
					echo " style='background-image:url(http://i.oldbk.com/i/blink.gif);'>";
				}else
				{
					echo '>';
				}
				if($dress['add_pick']!=''&& $dress['pick_time']>time()){$dress['img']=$dress['add_pick'];}
				$mess='����� <b>'.$dress['name'].'</b><br>�������: '.$dress['up_level'].'<br>����: '.$dress['ups'].'<br>��������� '.$dress['duration'].'/'.$dress['maxdur'].''.(($dress['ghp']>0)?'<br>������� ����� +'.$dress['ghp']:'').(($dress['text']!=null)?'<br>�� ���� ������������� '.$dress['text']:'');
				echo '<a href="?edit=1&drop=33"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src="http://i.oldbk.com/i/sh/'.$dress['img'].'" width=30 height=30 ></a>';
			}
			else
			{
				echo '>';
				mysql_query("UPDATE `users` SET `runa3`=0 WHERE `id`={$user['id']} LIMIT 1; ");
				$mess='������ ���� ����';
				echo '<a href="?edit=1&filt=31"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src=http://i.oldbk.com/i/none.gif width=30 height=30 ></a>';
			}
		}
		else{
			echo '>';
			$mess='������ ���� ����';
			echo '<a href="?edit=1&filt=31"><img onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,17,\''.$mess.'\')" src=http://i.oldbk.com/i/none.gif width=30 height=30 ></a>';

		}
	?></td>

        </tr></table>
<?
}
?>

</CENTER> <?php
}



function dressscrollkomplekt ($user,$compl) {
	return dressitemkomplekt($user,$compl,true);
}

// ������� ������� � �����
function undressscrolls($id,$id_city=-1, $in_trans = false) {
	if (!$in_trans) {
		$q = mysql_query('START TRANSACTION');
		if ($q === false) return false;

		// �������
		$q = mysql_query('SELECT * FROM users WHERE id = '.$id.' FOR UPDATE');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}
		$telo = mysql_fetch_assoc($q);
	} else {
		$q = mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}'");
		if ($q === false) return false;

		$telo = mysql_fetch_assoc($q);
	}

	if (!isset($telo['id'])) {
		if (!$in_trans) mysql_query('COMMIT');
		return false;
	}


	//��� �������� ���� ������
	$db_city[0]='oldbk.';
	$db_city[1]='avalon.';
	$db_city[2]='angels.';

	if ($db_city[$id_city]=='') {
		$db_prexif='';
	} else {
		$db_prexif=$db_city[$id_city];
	}

	$idslist = [];

	for($st = 1; $st < 21; $st++) {
		if ($telo['m'.$st] > 0) $idslist[] = $telo['m'.$st];
		$fieldlist .= 'm'.$st.' = 0,';
	}

	$fieldlist = substr($fieldlist,0,-1);

	$sql = "UPDATE ".$db_prexif."users SET ".$fieldlist." WHERE id = '".$telo['id']."'";
	$q = mysql_query($sql);
	if ($q === false) {
		if (!$in_trans) mysql_query('COMMIT');
		return false;
	}


	$sql = 'UPDATE oldbk.inventory SET dressed = 0 WHERE id IN ('.implode(",",$idslist).')';
	$q = mysql_query($sql);

	if ($q === false) {
		if (!$in_trans) mysql_query('COMMIT');
		return false;
	}

	if (!$in_trans) mysql_query('COMMIT');
	return true;
}

// ������� �������
function undressallinv($user,$id,$id_city=-1, $in_trans = false, $nocheck = false) {
	if (!$in_trans) {
		$q = mysql_query('START TRANSACTION');
		if ($q === false) return false;

		// �������
		$q = mysql_query('SELECT * FROM users_clons WHERE id = '.$id.' FOR UPDATE');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}
		$telo = mysql_fetch_assoc($q);
	} else {
		$q = mysql_query("SELECT * FROM `users_clons` WHERE `id` = ".$id);
		if ($q === false) return false;

		$telo = mysql_fetch_assoc($q);
	}

	if (!isset($telo['id'])) {
		mysql_query('COMMIT');
		return false;
	}


	//��� �������� ���� ������
	$db_city[0]='oldbk.';
	$db_city[1]='avalon.';
	$db_city[2]='angels.';

	if ($db_city[$id_city]=='') {
		$db_prexif='';
	} else {
		$db_prexif=$db_city[$id_city];
	}

        //                9     10     11    12        13      14    15      16    17
	$stats = array('hp','sila','lovk','inta','intel','noj','topor','dubina','mech','fire','water','air','earth','light','gray','dark','mp');
	$slots = array('sergi','kulon','perchi','weap','bron','r1','r2','r3','helm','shit','boots','nakidka','rubashka');

	$fieldlist='';
	for($st=0; $st<count($stats); $st++) {
		$fieldlist.= 'sum(i.g'.$stats[$st].') as g'.$stats[$st];
 		if($st != count($stats)-1) {
  			$fieldlist.=', ';
 		}
	}

	/*
	$fieldlist='sum(i.ghp) as ghp, sum(i.gsila) as gsila, sum(i.glovk) as glovk, sum(i.ginta) as ginta, sum(i.gintel) as gintel, sum(i.gnoj) as gnoj, sum(i.gtopor) as gtopor,
	sum(i.gdubina) as gdubina, sum(i.gmech) as gmech, sum(i.gfire) as gfire, sum(i.gwater) as gwater, sum(i.gair) as gair, sum(i.gearth) as gearth, sum(i.glight) as glight,
	sum(i.ggray) as ggray, sum(i.gdark) as gdark, sum(i.gmp) as gmp';   */

	$sql = "select u.*, ".$fieldlist." from ".$db_prexif."users as u
		LEFT JOIN oldbk.inventory as i
		ON i.owner=u.id and i.dressed='2'
		WHERE u.id = '".$user['id']."' and naem = ".$telo['naem_id']." GROUP by dressed";

	$q = mysql_query($sql);

	if ($q === false) {
		if (!$in_trans) mysql_query('COMMIT');
		return false;
	}


	$rez = mysql_fetch_assoc($q);

	if ($user['bpzay'] != -1) {
		$fieldlist='';

		$m='';
		$fieldlist .= 'maxhp=(vinos*6), maxmana = (mudra*10), ';

		for($st=1;$st<count($stats);$st++) {
			 $m = $st < 9 ? '' : 'm';
			 $rez['g'.$stats[$st]]=$rez['g'.$stats[$st]]==''?'0':$rez['g'.$stats[$st]];

			 if($st == 8)  {
				$fieldlist .= 'mec = mec-'.$rez['g'.$stats[$st]]. ', ';
			 } elseif($st == 16) {
			 	$fieldlist .= 'mudra = mudra-'.$rez['g'.$stats[$st]]. ', ';
				$telo['mudra'] -= $rez['g'.$stats[$st]];
			 } else {
				$fieldlist .= $m.$stats[$st].' = '.$m.$stats[$st].' - '.$rez['g'.$stats[$st]].', ';
			 }
		}

		for($st=0;$st<count($slots);$st++) {
			$fieldlist .= $slots[$st].' = 0';
			if($st<count($slots)-1) {
				$fieldlist .= ', ';
			}
		}


		$sql = "UPDATE ".$db_prexif."users_clons SET
			".$fieldlist.",
			hp = maxhp,
			mana = maxmana,
			sum_minu = 0,
			sum_maxu = 0,
			sum_mfkrit = 0,
			sum_mfakrit = 0,
			sum_mfuvorot = 0,
			sum_mfauvorot = 0,
			sum_bron1 = 0,
			sum_bron2 = 0,
			sum_bron3 = 0,
			sum_bron4 = 0


			WHERE id = '".$telo['id']."' ";

		$q = mysql_query($sql);

		if ($q === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}


		$sql = "UPDATE oldbk.inventory SET dressed=0 WHERE owner = '".$user['id']."' and dressed = 2 and naem = ".$telo['naem_id'];

		$q = mysql_query($sql);
		if ($q === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}

		if (!$in_trans) mysql_query('COMMIT');
		return true;
	} else {
		err("�� ������ � ������� �� ���!");
		if ($q === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}
	}

	if (!$in_trans) mysql_query('COMMIT');

	return true;
}


// ������� �����
function undressall($id,$id_city=-1, $in_trans = false, $nocheck = false) {
	if (!$in_trans) {
		$q = mysql_query('START TRANSACTION');
		if ($q === false) return false;

		// �������
		$q = mysql_query('SELECT * FROM users WHERE id = '.$id.' FOR UPDATE');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}
		$telo = mysql_fetch_assoc($q);
	} else {
		$q = mysql_query("SELECT * FROM `users` WHERE `id` = '{$id}'");
		if ($q === false) return false;

		$telo = mysql_fetch_assoc($q);
	}

	if (!isset($telo['id'])) {
		mysql_query('COMMIT');
		return false;
	}


	//��� �������� ���� ������
	$db_city[0]='oldbk.';
	$db_city[1]='avalon.';
	$db_city[2]='angels.';

	if ($db_city[$id_city]=='') {
		$db_prexif='';
	} else {
		$db_prexif=$db_city[$id_city];
	}

        //                9     10     11    12        13      14    15      16    17
	$stats = array('hp','sila','lovk','inta','intel','noj','topor','dubina','mech','fire','water','air','earth','light','gray','dark','mp');
	$slots = array('sergi','kulon','perchi','weap','bron','r1','r2','r3','helm','shit','boots','nakidka','rubashka','runa1','runa2','runa3');

	$fieldlist='';
	for($st=0; $st<count($stats); $st++) {
		$fieldlist.= 'sum(i.g'.$stats[$st].') as g'.$stats[$st];
 		if($st != count($stats)-1) {
  			$fieldlist.=', ';
 		}
	}

	/*
	$fieldlist='sum(i.ghp) as ghp, sum(i.gsila) as gsila, sum(i.glovk) as glovk, sum(i.ginta) as ginta, sum(i.gintel) as gintel, sum(i.gnoj) as gnoj, sum(i.gtopor) as gtopor,
	sum(i.gdubina) as gdubina, sum(i.gmech) as gmech, sum(i.gfire) as gfire, sum(i.gwater) as gwater, sum(i.gair) as gair, sum(i.gearth) as gearth, sum(i.glight) as glight,
	sum(i.ggray) as ggray, sum(i.gdark) as gdark, sum(i.gmp) as gmp';   */

	$sql = "select u.*, ".$fieldlist." from ".$db_prexif."users as u
		LEFT JOIN oldbk.inventory as i
		ON i.owner=u.id and i.dressed='1'
		WHERE u.id = '".$id."' GROUP by dressed";

	$q = mysql_query($sql);
	if ($q === false) {
		if (!$in_trans) mysql_query('COMMIT');
		return false;
	}


	$rez = mysql_fetch_assoc($q);

	if ($telo['bpzay'] != -1) {
		$fieldlist='';

		$m='';
		$fieldlist .= 'maxhp=(vinos*6 + bpbonushp), maxmana = (mudra*10), ';

		for($st=1;$st<count($stats);$st++) {
			 $m = $st < 9 ? '' : 'm';
			 $rez['g'.$stats[$st]]=$rez['g'.$stats[$st]]==''?'0':$rez['g'.$stats[$st]];

			 if($st == 8)  {
				$fieldlist .= 'mec = mec-'.$rez['g'.$stats[$st]]. ', ';
			 } elseif($st == 16) {
			 	$fieldlist .= 'mudra = mudra-'.$rez['g'.$stats[$st]]. ', ';
				$telo['mudra'] -= $rez['g'.$stats[$st]];
			 } else {
				$fieldlist .= $m.$stats[$st].' = '.$m.$stats[$st].' - '.$rez['g'.$stats[$st]].', ';
			 }
		}

		for($st=1;$st<21;$st++) {
			$fieldlist.='m'.$st.'=0, ';
		}


		for($st=0;$st<count($slots);$st++) {
			$fieldlist .= $slots[$st].' = 0';
			if($st<count($slots)-1) {
				$fieldlist .= ', ';
			}
		}


		$add_exp_bonus = "";

		//����������� ������
		$q = mysql_query("SELECT * FROM oldbk.`inventory` as i WHERE `id` = '{$rez['weap']}' AND `owner` = '{$id}' and naem = 0");

		if ($q === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}

		$item = mysql_fetch_array($q);

		if ($item['prototype'] == 55510351) {
			//��������� ������� ���� ���� -10%
			$add_exp_bonus=" `users`.expbonus=`users`.expbonus-'0.1', ";
		}

		if ($item['prototype'] == 55510352) {
			//��������� ������� ���� ���� -10%
			$add_exp_bonus=" `users`.expbonus=`users`.expbonus-'0.3', `users`.rep_bonus=`users`.rep_bonus-'0.2',";
		}

		if ($item['prototype'] == 410027) {
			//��������� ������� ���� ���� -10%
			$add_exp_bonus=" `users`.expbonus=`users`.expbonus-'0.1', `users`.rep_bonus=`users`.rep_bonus-'0.1',";
		}

		if ($item['prototype'] == 410028) {
			//��������� ������� ���� ���� -10%
			$add_exp_bonus=" `users`.expbonus=`users`.expbonus-'0.3', `users`.rep_bonus=`users`.rep_bonus-'0.2',";
		}

		//���
		$add_exp_bonus2 = "";

		$q2 = mysql_query("SELECT * FROM oldbk.`inventory` as i WHERE `id` = '{$rez['shit']}' AND `owner` = '{$id}' and naem = 0");

		if ($q2 === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}

		$item2 = mysql_fetch_array($q2);


		if ($item2['prototype'] == 410027) {
			// -10%
			$add_exp_bonus2=" `users`.expbonus=`users`.expbonus-'0.1', `users`.rep_bonus=`users`.rep_bonus-'0.1',";
		}


		$sql = "UPDATE ".$db_prexif."users SET ".$add_exp_bonus." ".$add_exp_bonus2."  ".$fieldlist." WHERE id = '".$id."' ";

		$q = mysql_query($sql);
		if ($q === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}

		///��� ����


		$sql = "UPDATE oldbk.inventory SET dressed=0 WHERE owner = '".$id."' and dressed = 1";

		$q = mysql_query($sql);
		if ($q === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}







		if (check_hp($id,0,$id_city)) {
			if (!$nocheck) {
				if ($telo['mana'] > $telo['mudra']*10) {
					$q = mysql_query("UPDATE `users` SET `mana`=`maxmana` where id='".$telo['id']."' and mana>maxmana limit 1;");
					if ($q === false) {
						if (!$in_trans) mysql_query('COMMIT');
						return false;
					}
				}
			}

			if (!$in_trans) mysql_query('COMMIT');
			return true;
		} else {
			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}
		}

	} else {
		err("�� ������ � ������� �� ���!");
		if ($q === false) {
			if (!$in_trans) mysql_query('COMMIT');
			return false;
		}
	}

	if (!$in_trans) mysql_query('COMMIT');

	return true;
}

// ������� ����� � ������
//id_city  -1 -������� �����, 0-�������, 1-������
function undressalltrz($id,$id_city=-1,$nocheck = false) {
	return undressall($id,$id_city,true,$nocheck);
}


// ����� �������
function dropitem($slot, $in_trans = false,$telo = false) {
	global $user;

	if ($telo !== false) {
		$usr = $telo;
	} else {
		$usr = $user;
	}


	if (!isset($usr['id'])) return false;

	if (!$in_trans) {
		$q = mysql_query('START TRANSACTION');
		if ($q === false) return false;

		// �������
		$q = mysql_query('SELECT * FROM users WHERE id = '.$usr['id'].' FOR UPDATE');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}
		$usr = mysql_fetch_assoc($q);
	}

	if ($usr['bpzay'] != -1) {
		switch($slot) {
			case 1: $slot1 = 'sergi'; break;
			case 2: $slot1 = 'kulon'; break;
			case 3: $slot1 = 'weap'; break;
			case 4: $slot1 = 'bron'; break;
			case 5: $slot1 = 'r1'; break;
			case 6: $slot1 = 'r2'; break;
			case 7: $slot1 = 'r3'; break;
			case 8: $slot1 = 'helm'; break;
			case 9: $slot1 = 'perchi'; break;
			case 10: $slot1 = 'shit'; break;
			case 11: $slot1 = 'boots'; break;
			case 12: $slot1 = 'm1'; break;
			case 13: $slot1 = 'm2'; break;
			case 14: $slot1 = 'm3'; break;
			case 15: $slot1 = 'm4'; break;
			case 16: $slot1 = 'm5'; break;
			case 17: $slot1 = 'm6'; break;
			case 18: $slot1 = 'm7'; break;
			case 19: $slot1 = 'm8'; break;
			case 20: $slot1 = 'm9'; break;
			case 21: $slot1 = 'm10'; break;
			case 22: $slot1 = 'm11'; break;
			case 23: $slot1 = 'm12'; break;
			case 24: $slot1 = 'm13'; break;
			case 25: $slot1 = 'm14'; break;
			case 26: $slot1 = 'm15'; break;
			case 27: $slot1 = 'nakidka'; break;
			case 28: $slot1 = 'rubashka'; break;
			case 31: $slot1 = 'runa1'; break;
			case 32: $slot1 = 'runa2'; break;
			case 33: $slot1 = 'runa3'; break;
			case 34: $slot1 = 'm16'; break;
			case 35: $slot1 = 'm17'; break;
			case 36: $slot1 = 'm18'; break;
			case 37: $slot1 = 'm19'; break;
			case 38: $slot1 = 'm20'; break;
		}


		$add_exp_bonus="";
		if (($slot1 == 'weap') OR ($slot1 == 'shit') )

		{
			$q = mysql_query("SELECT * FROM oldbk.`inventory` as i WHERE `id` = '{$usr[$slot1]}' AND `owner` = '{$usr['id']}' ");
			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}

			$item = mysql_fetch_array($q);

			if ($item['prototype']==55510351) {
				//��������� ������� ���� ���� -10%
				$add_exp_bonus=" u.expbonus=u.expbonus-'0.1', ";
			}
			if ($item['prototype']==55510352) {
				//��������� ������� ���� ���� -10%
				$add_exp_bonus=" u.expbonus=u.expbonus-'0.3',u.rep_bonus=u.rep_bonus-'0.2', ";
			}

			if ($item['prototype']==410027) {
				$add_exp_bonus=" u.expbonus=u.expbonus-'0.1',u.rep_bonus=u.rep_bonus-'0.1', ";
			}

			if ($item['prototype']==410028) {
				$add_exp_bonus=" u.expbonus=u.expbonus-'0.3',u.rep_bonus=u.rep_bonus-'0.2', ";
			}

		}





	 	if ($slot1 != '') {
			$q = mysql_query("UPDATE `users` as u, oldbk.`inventory` as i SET u.{$slot1} = 0, i.dressed = 0,
				u.sila = u.sila - i.gsila,
				u.lovk = u.lovk - i.glovk,
				u.inta = u.inta - i.ginta,
				u.intel = u.intel - i.gintel,
				u.mudra = u.mudra - i.gmp,
				u.maxmana = (u.maxmana-i.gmp*10),
				u.maxhp = u.maxhp - i.ghp,
				u.noj = u.noj - i.gnoj,
				u.topor = u.topor - i.gtopor,
				u.dubina = u.dubina - i.gdubina,
				u.mec = u.mec - i.gmech,
				u.mfire = u.mfire - i.gfire,
				u.mwater = u.mwater - i.gwater,
				u.mair = u.mair - i.gair,
				u.mearth = u.mearth - i.gearth,
				u.mlight = u.mlight - i.glight,
				u.mgray = u.mgray - i.ggray, ".$add_exp_bonus."
				u.mdark = u.mdark - i.gdark
				WHERE i.id = u.{$slot1} AND i.dressed = 1 AND i.owner = {$usr['id']} AND u.id = {$usr['id']};");

			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}

			// ������ ������
			for ($st = 1; $st < 21; $st++) {
				if ($slot1 == 'm'.$st) {
					$q = mysql_query('UPDATE users_complect_scrolls SET '.$slot1.' = "" WHERE owner = '.$usr['id']);

					if ($q === false) {
						if (!$in_trans) mysql_query('COMMIT');
						return false;
					}

					break;
				}
			}

			$q = mysql_query("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time()." WHERE  `hp` > `maxhp` AND `id` = '{$usr['id']}' LIMIT 1;");

			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}

           		$q = mysql_query("UPDATE `users` SET `mana` = `maxmana`, `fullmptime`=".time()." WHERE  `mana` > `maxmana` AND `id` = '{$usr['id']}' LIMIT 1;");

			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}
           	}


		// ��������� ��� �� ���
		if ($slot1 == 'bron') {
		    	$itemb = $usr['bron'];

			$q = mysql_query("select * from oldbk.`inventory` where id='".$itemb."';");

			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}

			$get_otdel = mysql_fetch_array($q);

			if (($get_otdel['otdel'] == 22 || $get_otdel['name'] == '�������') && $get_otdel['type'] == 4) {
		            	// ���������
		            	$q = mysql_query("update  oldbk.`inventory` set type=28  where id='".$itemb."' and type=4  ;");

				if ($q === false) {
					if (!$in_trans) mysql_query('COMMIT');
					return false;
				}
			}
		}

		if (!$in_trans) mysql_query('COMMIT');
		return 	true;
 	} else {
		err("�� ������ � ������� �� ���!");
		if (!$in_trans) mysql_query('COMMIT');
		return 	false;
	}

	if (!$in_trans) mysql_query('COMMIT');
	return 	false;
}

function make_seed() {
	list($usec, $sec) = explode(' ', microtime());
	return (float) $sec + ((float) $usec * 100000);
}


function put_into_pocket($in_out, $item) {
	if($in_out < 1 && $in_out > 2) return false;
	if($in_out == 2) { $in_out = 0; }
	global $user;

	return mysql_query("UPDATE oldbk.`inventory` SET `karman` = $in_out WHERE `id` = $item  and  owner={$user['id']} ;");
}




function dropitemnaem ($naem,$slot, $in_trans = false) {
	global $user;
	$usr = $user;

	if (!isset($naem['id'])) return false;
	if (!isset($usr['id'])) return false;

	if (!$in_trans) {
		$q = mysql_query('START TRANSACTION');
		if ($q === false) return false;

		// �������
		$q = mysql_query('SELECT * FROM users_clons WHERE id = '.$naem['id'].' FOR UPDATE');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}
		$naem = mysql_fetch_assoc($q);
	}

	if ($usr['bpzay'] != -1) {
		switch($slot) {
			case 1: $slot1 = 'sergi'; break;
			case 2: $slot1 = 'kulon'; break;
			case 3: $slot1 = 'weap'; break;
			case 4: $slot1 = 'bron'; break;
			case 5: $slot1 = 'r1'; break;
			case 6: $slot1 = 'r2'; break;
			case 7: $slot1 = 'r3'; break;
			case 8: $slot1 = 'helm'; break;
			case 9: $slot1 = 'perchi'; break;
			case 10: $slot1 = 'shit'; break;
			case 11: $slot1 = 'boots'; break;
			case 27: $slot1 = 'nakidka'; break;
			case 28: $slot1 = 'rubashka'; break;
		}

	 	if ($slot1 != '') {
			$q = mysql_query("UPDATE `users_clons` as u, oldbk.`inventory` as i SET u.{$slot1} = 0, i.dressed = 0,
				u.sila = u.sila - i.gsila,
				u.lovk = u.lovk - i.glovk,
				u.inta = u.inta - i.ginta,
				u.intel = u.intel - i.gintel,
				u.mudra = u.mudra - i.gmp,
				u.maxmana = (u.maxmana-i.gmp*10),
				u.maxhp = u.maxhp - i.ghp,
				u.noj = u.noj - i.gnoj,
				u.topor = u.topor - i.gtopor,
				u.dubina = u.dubina - i.gdubina,
				u.mec = u.mec - i.gmech,
				u.sum_minu = u.sum_minu - i.minu,
				u.sum_maxu = u.sum_maxu - i.maxu,
				u.sum_mfkrit = u.sum_mfkrit - i.mfkrit,
				u.sum_mfakrit = u.sum_mfakrit - i.mfakrit,
				u.sum_mfuvorot = u.sum_mfuvorot - i.mfuvorot,
				u.sum_mfauvorot = u.sum_mfauvorot - i.mfauvorot,
				u.sum_bron1 = u.sum_bron1 - i.bron1,
				u.sum_bron2 = u.sum_bron2 - i.bron2,
				u.sum_bron3 = u.sum_bron3 - i.bron3,
				u.sum_bron4 = u.sum_bron4 - i.bron4,
				u.hp = u.maxhp,
				u.mana = u.maxmana

				WHERE i.id = u.{$slot1} AND i.dressed = 2 AND i.owner = {$usr['id']} AND u.id = {$naem['id']};");

			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}

			$q = mysql_query("UPDATE `users_clons` SET `hp` = `maxhp`, `fullhptime` = ".time()." WHERE  `hp` > `maxhp` AND `id` = '{$naem['id']}' LIMIT 1;");

			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}

           		$q = mysql_query("UPDATE `users_clons` SET `mana` = `maxmana` WHERE  `mana` > `maxmana` AND `id` = '{$naem['id']}' LIMIT 1;");

			if ($q === false) {
				if (!$in_trans) mysql_query('COMMIT');
				return false;
			}
           	}

		if (!$in_trans) mysql_query('COMMIT');
		return 	true;
 	} else {
		err("�� ������ � ������� �� ���!");
		if (!$in_trans) mysql_query('COMMIT');
		return 	false;
	}

	if (!$in_trans) mysql_query('COMMIT');
	return 	false;
}


// ����� �������
function dressitemnaem ($naem,$id) {
	global $user,$nodress,$noclass_items_ok;
	if (!isset($naem['id'])) return false;

	$good = 1;
	$q = mysql_query('START TRANSACTION');
	if ($q === false) return false;

	// �������
	$q = mysql_query('SELECT * FROM users_clons WHERE id = '.$naem['id'].' FOR UPDATE');
	if ($q === false) {
		mysql_query('COMMIT');
		return false;
	}

	$naem = mysql_fetch_assoc($q);


	$item = mysql_query("SELECT * FROM oldbk.`inventory` as i WHERE  `duration` < `maxdur` AND `id` = '{$id}' AND `owner` = '{$user['id']}' AND `dressed` = 0 AND `bs_owner` = '".$user['in_tower']."' and setsale = 0 and naem = ".$naem['naem_id']);
	if ($item === false) {
		mysql_query('COMMIT');
		return false;
	}
	$item = mysql_fetch_assoc($item);
	if ($item === false) {
		mysql_query('COMMIT');
		return false;
	}

	if ($item['dategoden'] > 0 && $item['dategoden'] < time()) $good = 0;


   	if ($good == 1) {
		if ($user['bpzay'] != -1) {
        		if($item['sowner'] == $item['owner'] || $item['sowner']==0) {
				$slot1 = "";
				switch($item['type']) {
					case 1: $slot1 = 'sergi'; break;
					case 2: $slot1 = 'kulon'; break;
					case 3: $slot1 = 'weap'; break;
					case 4: $slot1 = 'bron'; break;
					case 5: $slot1 = 'r1'; break;
					case 6: $slot1 = 'r2'; break;
					case 7: $slot1 = 'r3'; break;
					case 8: $slot1 = 'helm'; break;
					case 9: $slot1 = 'perchi'; break;
					case 10: $slot1 = 'shit'; break;
					case 11: $slot1 = 'boots'; break;
					case 27: $slot1 = 'nakidka'; break;
					case 28: $slot1 = 'rubashka'; break;
				}

				if($item['type']==33) {
					if ($naem['weap'] > 0) {
						$slot1 = 'shit';
						if ($naem['shit'] > 0) {
					 		if(!dropitemnaem($naem,10,true)) {
								mysql_query('COMMIT');
								return false;
							}
					 	}
					} else {
						$slot1 = 'weap';
					}
				} elseif($item['type'] == 5) {
					if(!$naem['r1']) { $slot1 = 'r1';}
					elseif(!$naem['r2']) { $slot1 = 'r2';}
					elseif(!$naem['r3']) { $slot1 = 'r3';}
					else {
						$slot1 = 'r1';
						if ($naem[$slot1] > 0) {
							if (!dropitemnaem($naem,5,true)) {
								mysql_query('COMMIT');
								return false;
							}
						}
					}
				} else {
					if ($naem[$slot1] > 0) {
						if (!dropitemnaem($naem,$item['type'],true)) {
							mysql_query('COMMIT');
							return false;
						}
					}
				}

				if (strlen($slot1)) {
					$sql = "";
					if(($item['needident']==0 && $item['dressed']==0
						&& $naem['sila']>=$item['nsila']
						&& $naem['lovk']>=$item['nlovk']
						&& $naem['inta']>=$item['ninta']
						&& $naem['vinos']>=$item['nvinos']
						&& $naem['intel']>=$item['nintel']
						&& $naem['mudra']>=$item['nmudra']
						&& $naem['level']>=$item['nlevel']
						&& $naem['noj']>=$item['nnoj']
						&& $naem['topor']>=$item['ntopor']
						&& $naem['dubina']>=$item['ndubina']
						&& $naem['mec']>=$item['nmech']
						&& (($item['nclass']==$naem['uclass']) OR ($item['nclass']==4) OR ($item['nlevel']<=7) OR (in_array($item['type'],$noclass_items_ok)) )
						&& $item['setsale']==0
					) OR ($item['type']==33)) {
						if (strlen($slot1) && $id > 0) {
				    			$sql = "UPDATE `users_clons` as u, oldbk.`inventory` as i SET u.{$slot1} = {$id}, i.dressed = 2,
								u.sila = u.sila + i.gsila,
								u.lovk = u.lovk + i.glovk,
								u.inta = u.inta + i.ginta,
								u.intel = u.intel + i.gintel,
								u.mudra = u.mudra + i.gmp,
								u.maxmana = (u.maxmana+i.gmp*10),
								u.maxhp = u.maxhp + i.ghp,
								u.noj = u.noj + i.gnoj,
								u.topor = u.topor + i.gtopor,
								u.dubina = u.dubina + i.gdubina,
								u.mec = u.mec + i.gmech,
								u.sum_minu = u.sum_minu + i.minu,
								u.sum_maxu = u.sum_maxu + i.maxu,
								u.sum_mfkrit = u.sum_mfkrit + i.mfkrit,
								u.sum_mfakrit = u.sum_mfakrit + i.mfakrit,
								u.sum_mfuvorot = u.sum_mfuvorot + i.mfuvorot,
								u.sum_mfauvorot = u.sum_mfauvorot + i.mfauvorot,
								u.sum_bron1 = u.sum_bron1 + i.bron1,
								u.sum_bron2 = u.sum_bron2 + i.bron2,
								u.sum_bron3 = u.sum_bron3 + i.bron3,
								u.sum_bron4 = u.sum_bron4 + i.bron4,
								u.hp = u.maxhp,
								u.mana = u.maxmana,
								u.fullhptime=(UNIX_TIMESTAMP())
								WHERE
								i.id = {$id} AND
								i.owner = {$user['id']} AND
								u.id = {$naem['id']};";
						}
					}

					if ($sql != '') {
						if (mysql_query($sql)) {
							$naem[$slot1] = $item['id'];
							mysql_query('COMMIT');

							return true;
						} else {
							echo mysql_error();die();
							mysql_query('COMMIT');
				   			return false;
						}
			   		} else {
						mysql_query('COMMIT');
			   			return 	false;
			   		}
				}
			} else {
				echo '��� �� ���� ����...';
				mysql_query('COMMIT');
				return false;
			}
		} else {
	 		err("�� ������ � ������� �� ���!");
			mysql_query('COMMIT');
			return false;
	 	}
	} else {
		mysql_query('COMMIT');
		return 	false;
	}
	mysql_query('COMMIT');
	return false;
}


// ����� �������
function dressitem ($id) {
	global $user,$nodress,$noclass_items_ok;
	if (!isset($user['id'])) return false;

	$good = 1;
	$q = mysql_query('START TRANSACTION');
	if ($q === false) return false;

	// �������
	$q = mysql_query('SELECT * FROM users WHERE id = '.$user['id'].' FOR UPDATE');
	if ($q === false) {
		mysql_query('COMMIT');
		return false;
	}

	$user = mysql_fetch_assoc($q);

	$item = mysql_query("SELECT * FROM oldbk.`inventory` as i WHERE  `duration` < `maxdur` AND `id` = '{$id}' AND `owner` = '{$user['id']}' AND `dressed` = 0 AND `bs_owner` = '".$user['in_tower']."' and setsale = 0 and naem = 0");
	if ($item === false) {
		mysql_query('COMMIT');
		return false;
	}
	$item = mysql_fetch_assoc($item);
	if ($item === false) {
		mysql_query('COMMIT');
		return false;
	}


	if (in_array($item['prototype'],$nodress) || $item['otdel'] == 55) {
		err("���������� ������ ���� �������!");
		mysql_query('COMMIT');
		return false;
	}

	if (olditemdress($item,$user) == false) {
		$good = -3;
	}

	if ($item['type'] == 30 && $user['room'] == 240 && $user['id_grup'] > 0) {
		// �� ������� ���� ���� � ������ �� ��������
		$good = -2;
	}

	if (($item['art_param'] != '' || $item['ab_uron'] > 0 || $item['ab_mf'] || $item['ab_bron'] > 0) && $item['type'] != 30) {
		//���������  �� ����
		$dhram = 0;
		$dnewa = 0;

		$q = mysql_query('select * from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_ITEMS).') and type!=30 and (art_param != "" or ab_uron > 0 or ab_mf > 0 or ab_bron > 0)');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}
		while($art = mysql_fetch_assoc($q)) {
			if ($art['art_param'] == "") {
				// ���� ������� � ��� �� ���� ��� ��� ���� ���, �� �� �������
				if ($item['type'] != $art['type']) {
					$dhram++;
				}
			} else {
				// ���� ������� � ��� �� ���� ��� ��� ���� ���, �� �� �������
				if ($item['type'] != $art['type']) {
					$dnewa++;
				}
			}
		}

		if ($item['art_param'] == "") {
			$dhram++;
		} else {
			$dnewa++;
		}

		if ($dhram + $dnewa > 5) {
			$good = 0;
		} elseif ($dhram + $dnewa == 5) {
			if ($dnewa > 4) {
				$good = 0;
			}
		}
	}

	// ������� ������ 1 ������ �������
	if (($item['prototype']>=14001 && $item[prototype] <=14005) || $item['prototype'] ==14033)  {
		$q = mysql_query('select count(id) from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_MAGIC).') and prototype in (14001,14002,14003,14004,14005,14033)');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}

		$max_scroll_bot = mysql_fetch_array($q);
	 	if ($max_scroll_bot[0] >= 1) { $good=-1; }
	}

	// ������� ������ 1 ������ �������
	if ($item['prototype'] >= 15000 && $item['prototype'] <= 15005) {
		$q = mysql_query('select count(id) from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_MAGIC).') and prototype in (15001,15002,15003,15004,15005,15000)');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}

		$max_scroll_bot=mysql_fetch_array($q);
	 	if ($max_scroll_bot[0]>=1) { $good=-1; }
	}

	if ($item['prototype']>=100430 && $item['prototype'] <= 100432) {
		$q = mysql_query('select count(id) from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_MAGIC).') and prototype in (100430,100431,100432)');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}

		$max_scroll_bot=mysql_fetch_array($q);
	 	if ($max_scroll_bot[0]>=1) { $good=-1; }
	}

	// ������� ������ 1 ������  ������ �������������
	if ($item['prototype'] == 200441)  {
		$q = mysql_query('select count(id) from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_MAGIC).') and prototype =200441');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}

		$max_scroll_bot=mysql_fetch_array($q);
	 	if ($max_scroll_bot[0]>=1) { $good=-1; }
	}

	// ������� ������ 1 ������  ����� ����� ������
	if ($item['magic'] == 2020)  {
		$q = mysql_query('select count(id) from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_MAGIC).') and magic =2020');
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}

		$max_scroll_bot=mysql_fetch_array($q);
	 	if ($max_scroll_bot[0]>=1) { $good=-1; }
	}

	// ������� ������ 1  ������
	if ($item['prototype']==949 || $item['prototype']==950 || $item['prototype'] == 951) {
		$q = mysql_query('select count(id) from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_ITEMS).') and prototype in (949,950,951)');

		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}

		$max_scroll_bot=mysql_fetch_array($q);
	 	if ($max_scroll_bot[0]>=1) { $good=-5; }

	}

	if ($item['prototype'] >= 946 && $item['prototype'] <= 957) {
		//��� ���������� ��������
		$q = mysql_query('select count(id) from oldbk.inventory where id in ('.GetDressedItems($user,DRESSED_ITEMS).') and prototype in (946,947,948,952,953,954,955,956,957)');

		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}

		$max_scroll_bot=mysql_fetch_array($q);

	 	if ($max_scroll_bot[0]>=4) { $good=-4; }
	}


	if (($item['type']==10 or ($item['type']==34)) and ($user['weap']>0)) {
		// ������� ��� = ��������� �������� � ����� ������
		$q = mysql_query("select id, type from oldbk.inventory where id='{$user['weap']}'");
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}
		$testw=mysql_fetch_array($q);
		if ($testw['type'] == 35) {
			$good=-6;
		}
	}


	if ($item['dategoden'] > 0 && $item['dategoden'] < time()) $good = -7;

   	if ($good == 1) {
		if($user['zayavka'] > 0) {
			$q = mysql_query("select type, `start` from zayavka where id='".$user['zayavka']."';");

			if ($q === false) {
				mysql_query('COMMIT');
				return false;
			}

			$zfifa=mysql_fetch_array($q);
		}

		if ($zfifa['type'] == 5 && $zfifa['start'] <= (time()+3)) {
			//���� ������� � �� ������ �������� 3 ������� - �� ��������� ������� ������
			mysql_query('COMMIT');
			return 	false;
		}

		$mmemory = '';

		if ($user['bpzay'] != -1) {
        		if($item['sowner'] == $item['owner'] || $item['sowner']==0) {
				switch($item['type']) {
					case 1: $slot1 = 'sergi'; break;
					case 2: $slot1 = 'kulon'; break;
					case 3: $slot1 = 'weap'; break;
					case 4: $slot1 = 'bron'; break;
					case 5: $slot1 = 'r1'; break;
					case 6: $slot1 = 'r2'; break;
					case 7: $slot1 = 'r3'; break;
					case 8: $slot1 = 'helm'; break;
					case 9: $slot1 = 'perchi'; break;
					case 10: $slot1 = 'shit'; break;
					case 11: $slot1 = 'boots'; break;
					case 12: $slot1 = 'm1'; break;
					case 27: $slot1 = 'nakidka'; break;
					case 28: $slot1 = 'rubashka'; break;
					case 30: $slot1 = 'runa1'; break;
					case 34: $slot1 = 'shit'; break; //����� � ���� ���� ������
					case 35: $slot1 = 'weap'; break; //����� � ���� ����� ��������
				}

				if($item['type']==30) {
					if(!$user['runa1']) { $slot1 = 'runa1';}
					elseif(!$user['runa2']) { $slot1 = 'runa2';}
					elseif(!$user['runa3']) { $slot1 = 'runa3';}
					else {
						$slot1 = 'runa1';
						if (!dropitem(31,true)) {
							mysql_query('COMMIT');
							return false;
						}
					}
				} elseif($item['type']==33) {
					if ($user['weap'] > 0) {
						$slot1 = 'shit';
						if ($user['shit'] > 0) {
					 		if(!dropitem(10,true)) {
								mysql_query('COMMIT');
								return false;
							}
					 	}
					} else {
						$slot1 = 'weap';
					}
				} elseif($item['type']==34) {

						//���� ������� ����� � ���� ����
						if ($user['shit'] > 0) {
					 		if(!dropitem(10,true)) {
								mysql_query('COMMIT');
								return false;
							}
					 	}

				} elseif($item['type']==35)
				{

						//���� ������� ��������� ����� � ���� ��� = ��� ���������
						$out_false=false;

						if ($user['shit'] > 0) {
					 		if(!dropitem(10,true)) $out_false=true;
						}

						if ($user['weap'] > 0) {
					 		if(!dropitem(3,true)) $out_false=true;
						}

						if ($out_false==true)
							{
								mysql_query('COMMIT');
								return false;
							}

				}
				elseif($item['type'] == 5) {
					if(!$user['r1']) { $slot1 = 'r1';}
					elseif(!$user['r2']) { $slot1 = 'r2';}
					elseif(!$user['r3']) { $slot1 = 'r3';}
					else {
						$slot1 = 'r1';
						if ($user[$slot1] > 0) {
							if (!dropitem(5,true)) {
								mysql_query('COMMIT');
								return false;
							}
						}
					}
				} elseif($item['type'] == 12) {
					$user_slots_count = 10 + (int)$user['rep']/20000;

					$new_slots_count = 0;
					if ($user['prem'] > 0 && $user['in_tower'] == 0) {
						$new_slots_count = getAddSlot($user['prem']);
					}

					$mmemory = $item['id'].'|'.$item['prototype'];

					if(!$user['m1']) {
						$slot1 = 'm1';
					} elseif(!$user['m2']) {
						$slot1 = 'm2';
					} elseif(!$user['m3']) {
						$slot1 = 'm3';
					} elseif(!$user['m4']) {
						$slot1 = 'm4';
					} elseif(!$user['m5']) {
						$slot1 = 'm5';
					} elseif(!$user['m6']) {
						$slot1 = 'm6';
					} elseif(!$user['m7']) {
						$slot1 = 'm7';
					} elseif(!$user['m8']) {
						$slot1 = 'm8';
					} elseif(!$user['m9']) {
						$slot1 = 'm9';
					} elseif(!$user['m10']) {
						$slot1 = 'm10';
					} elseif($user_slots_count >= 11 AND !$user['m11']) {
						$slot1 = 'm11';
					} elseif($user_slots_count >= 12 AND !$user['m12']) {
						$slot1 = 'm12';
					} elseif($user_slots_count >= 13 AND !$user['m13']) {
						$slot1 = 'm13';
					} elseif($user_slots_count >= 14 AND !$user['m14']) {
						$slot1 = 'm14';
					} elseif($user_slots_count >= 15 AND !$user['m15']) {
						$slot1 = 'm15';
					} elseif ($user['prem'] > 0 && $user['in_tower'] == 0 && $new_slots_count >= 1 && !$user['m16']) {
						$slot1 = 'm16';
					} elseif ($user['prem'] > 0 && $user['in_tower'] == 0 && $new_slots_count >= 2 && !$user['m17']) {
						$slot1 = 'm17';
					} elseif ($user['prem'] > 0 && $user['in_tower'] == 0 && $new_slots_count >= 3 && !$user['m18']) {
						$slot1 = 'm18';
					} elseif ($user['prem'] > 0 && $user['in_tower'] == 0 && $new_slots_count >= 4 && !$user['m19']) {
						$slot1 = 'm19';
					} elseif ($user['prem'] > 0 && $user['in_tower'] == 0 && $new_slots_count >= 5 && !$user['m20']) {
						$slot1 = 'm20';
					} else {
						$slot1 = 'm1';
						if (!dropitem(12,true)) {
							mysql_query('COMMIT');
							return false;
						}
					}
				} else {
					if ($user[$slot1] > 0) {
						if (!dropitem($item['type'],true)) {
							mysql_query('COMMIT');
							return false;
						}
					}
				}

				if (!($item['type'] == 12 && $user['level'] < 4)) {
					$ch_al = $user['align'];
   					if($user['klan'] == 'pal') {
						$ch_al=6;
						$ch_al2=1;
					} else {
						$ch_al2=0;
					}


					if(($item['needident']==0 && $item['dressed']==0
						&& $user['sila']>=$item['nsila']
						&& $user['lovk']>=$item['nlovk']
						&& $user['inta']>=$item['ninta']
						&& $user['vinos']>=$item['nvinos']
						&& $user['intel']>=$item['nintel']
						&& $user['mudra']>=$item['nmudra']
						&& $user['level']>=$item['nlevel']
						&& ((int)$ch_al== $item['nalign'] || $item['nalign']==0 || $user['align']==5 || $ch_al2== $item['nalign'] )
						&& $user['noj']>=$item['nnoj']
						&& $user['topor']>=$item['ntopor']
						&& $user['dubina']>=$item['ndubina']
						&& $user['mec']>=$item['nmech']
						&& $user['mfire']>=$item['nfire']
						&& $user['mwater']>=$item['nwater']
						&& $user['mair']>=$item['nair']
						&& $user['mearth']>=$item['nearth']
						&& $user['mlight']>=$item['nlight']
						&& $user['mgray']>=$item['ngray']
						&& $user['mdark']>=$item['ndark']
						&& (($item['nclass']==$user['uclass']) OR ($item['nclass']==4) OR ($item['nlevel']<=7) OR (in_array($item['type'],$noclass_items_ok)) )
						&& $item['setsale']==0
					) OR ($item['type']==33)) {
						if ($slot1 !='' && $id > 0) {
							if ($item['prototype']==55510351) {
								//��������� ������� ���� ���� +10%
								$add_exp_bonus = " u.expbonus=u.expbonus+'0.1', ";
							} elseif ($item['prototype']==55510352) {
								//��������� ������� ���� ���� +30%
								$add_exp_bonus = " u.expbonus=u.expbonus+'0.3',u.rep_bonus=u.rep_bonus+'0.2', ";
							} elseif ($item['prototype']==410027) {
								//��������� ������� ���� ���� +30%
								$add_exp_bonus = " u.expbonus=u.expbonus+'0.1',u.rep_bonus=u.rep_bonus+'0.1', ";
							} elseif ($item['prototype']==410028) {
								//��������� ������� ���� ���� +30%
								$add_exp_bonus = " u.expbonus=u.expbonus+'0.3',u.rep_bonus=u.rep_bonus+'0.2', ";
							} else {
								$add_exp_bonus = "";
							}


				    			$sql="UPDATE `users` as u, oldbk.`inventory` as i SET u.{$slot1} = {$id}, i.dressed = 1,
								u.sila = u.sila + i.gsila,
								u.lovk = u.lovk + i.glovk,
								u.inta = u.inta + i.ginta,
								u.intel = u.intel + i.gintel,
								u.mudra = u.mudra + i.gmp,
								u.maxmana = (u.maxmana+i.gmp*10),
								u.maxhp = u.maxhp + i.ghp,
								u.noj = u.noj + i.gnoj,
								u.topor = u.topor + i.gtopor,
								u.dubina = u.dubina + i.gdubina,
								u.mec = u.mec + i.gmech,
								u.mfire = u.mfire + i.gfire,
								u.mwater = u.mwater + i.gwater,
								u.mair = u.mair + i.gair,
								u.mearth = u.mearth + i.gearth,
								u.mlight = u.mlight + i.glight,
								u.mgray = u.mgray + i.ggray,
								u.mdark = u.mdark + i.gdark, ".$add_exp_bonus."
								u.fullhptime=(UNIX_TIMESTAMP()),
								u.fullmptime=(UNIX_TIMESTAMP())
								WHERE
								i.id = {$id} AND
								i.owner = {$user['id']} AND
								u.id = {$user['id']};";
						}
                			}

					if ($sql != '') {
						if (mysql_query($sql)) {
							$user[$slot1] = $item['id'];

							if (strlen($mmemory)) {
								// ������ ������
								$q = mysql_query('UPDATE users_complect_scrolls SET '.$slot1.' = "'.mysql_real_escape_string($mmemory).'" WHERE owner = '.$user['id']);
								if ($q === false) {
									mysql_query('COMMIT');
									return false;
								}
							}

							mysql_query('COMMIT');

							return 	true;
						} else {
							mysql_query('COMMIT');
				   			return 	false;
						}
			   		} else {
						mysql_query('COMMIT');
			   			return 	false;
			   		}
				}
			} else {
				echo '��� �� ���� ����...';
				mysql_query('COMMIT');
				return false;
			}
		} else {
	 		err("�� ������ � ������� �� ���!");
			mysql_query('COMMIT');
			return false;
	 	}
	} else {
		if ($good ==  0) { err("�� ������ �������� �� ����� 5-�� ����������, �� ��� �� ����� 4-� ������."); }
		if ($good == -1) { err("���������� �������� ����� ������ ������!"); }
		if ($good == -2) { err("���������� ������ ����. �� � ������ �� ������!"); }
		if ($good == -3) { err("���������� ������ ���� �������!"); }
		if ($good == -4) { err("���������� �������� ����� ���� ������� ���������!"); }
		if ($good == -5) { err("���������� �������� ����� ���� ������� ��������� � ����� ������ ������!"); }
		if ($good == -6) { err("���������� ������ ���� �������, � ��� ��������� ������!"); }
		if ($good == -7) { err("���������� ������ ���� �������, ���������� ���� ��������!"); }
		mysql_query('COMMIT');
		return 	false;
	}
	mysql_query('COMMIT');
	return false;
}

function dressitemkomplekt ($user,$compl,$undressscrolls = false) {
	global $nodress;
	global $noclass_items_ok;

	$q = mysql_query('START TRANSACTION');
	if ($q === false) return false;

	// �������
	$q = mysql_query('SELECT * FROM users WHERE id = '.$user['id'].' FOR UPDATE');
	if ($q === false) {
		mysql_query('COMMIT');
		return false;
	}

	$user = mysql_fetch_assoc($q);
	if (!isset($user['id'])) {
		mysql_query('COMMIT');
		return false;
	}

	if ($undressscrolls) {
		// �������� ������ ������
		undressscrolls($user['id'],-1,true);
	}

	// ��������� ��� �� ��������� �� �����
	if ($undressscrolls || undressalltrz($user['id'],-1,true,true)) {

		// ��������������
		$q = mysql_query('SELECT * FROM users WHERE id = '.$user['id']);
		if ($q === false) {
			mysql_query('COMMIT');
			return false;
		}


		$user = mysql_fetch_assoc($q);
		if (!isset($user['id'])) {
			mysql_query('COMMIT');
			return false;
		}


		if($user['zayavka'] > 0) {
			$q = mysql_query("select type, `start` from zayavka where id='".$user['zayavka']."';");
			if ($q === false) {
				mysql_query('COMMIT');
				return false;
			}

			$zfifa = mysql_fetch_array($q);

			if ($zfifa !== false && $zfifa['type']==5 && $zfifa['start']<=(time()+3)) {
				// ������� � 3 ���� �� �������� - �� ��������� �������
				mysql_query('COMMIT');
				return false;
			}
		}

		if ($user['bpzay'] != -1) {
			// ������
			$list = []; // ������ ���� => [����, �����]
			$ilist = []; // ��������� ������ ���� ��� �������
			$dresslist = []; // ������ ����� ������� �������

			// ���������� ��� �������� ���� �� ���������
			unset($compl['id']);
			unset($compl['owner']);
			unset($compl['name']);
			unset($compl['type']);

			reset($compl);
			while(list($k,$v) = each($compl)) {
				if (strlen($v)) {
					$t = explode("|",$v);
					if (count($t) == 2) {
						$list[$k]['id'] = $t[0];
						$list[$k]['proto'] = $t[1];
						$ilist[$t[0]] = 1;
					}
				}
			}

			// ��������� ������� �� id ��� ������
			$items = mysql_query("SELECT * FROM oldbk.`inventory` WHERE  `duration` < `maxdur` AND `id` IN (".implode(",",array_keys($ilist)).") AND `owner` = '{$user['id']}' AND `dressed` = 0 AND `bs_owner` = '".$user['in_tower']."' and setsale = 0 and naem = 0 and (sowner = 0 or sowner = ".$user['id'].")");
			if ($items === false) {
				mysql_query('COMMIT');
				return false;
			}

			// ��������� ������ ���� ��� �����
			while($i = mysql_fetch_assoc($items)) {
				$dresslist[$i['id']] = $i;
			}

			if (mysql_num_rows($q) != count($ilist)) {
				// �� ����� ��� ������ �� id, ���� �������� ������� ����� ������ �� ����� ���� ������
				$pneed = []; // ������ ����������� �����

				$listcopy = $list;
				while(list($k,$v) = each($listcopy)) {
					if (!isset($dresslist[$v['id']])) {
						if (isset($pneed[$v['proto']])) {
							$pneed[$v['proto']]++;
						} else {
							$pneed[$v['proto']] = 1;
						}
					}
				}

				// ��������� �� ��� ����� �� �����, ���� ��� ����
				if (count($pneed)) {
					$max = max($pneed); // ������������ ���������� ����� ��� �������
					// ��������� ��� ������ �� ���� ����������� �����
					$notin = "";
					$notin2 = "";

					if (count($dresslist)) {
						$notin = ' AND id not IN ('.implode(",",array_keys($dresslist)).') ';
						$notin2 = ' AND i1.id not IN ('.implode(",",array_keys($dresslist)).') ';
					}

					//$m_test = microtime(true);

					$q = mysql_query('
						SELECT * FROM inventory i1 LEFT JOIN
	       					(
							SELECT if (@cproto=null,@cproto:=-1,0) , if (@a=null,@a:=1,0) ,  IF (@cproto=prototype, @a:=@a+1, (@cproto:=prototype) AND (@a:=1)) as k, id, name, prototype
	         					FROM inventory
	         					WHERE owner = '.$user['id'].' and prototype IN ('.implode(",",array_keys($pneed)).')
							and naem = 0 and `duration` < `maxdur`AND `dressed` = 0 AND `bs_owner` = '.$user['in_tower'].' and setsale = 0 and (sowner = 0 or sowner = '.$user['id'].') '.$notin.'
	         					order by `prototype`, `update` DESC
	       					) i2
	       					ON i1.id = i2.id
	       					WHERE owner = '.$user['id'].' and i1.prototype IN ('.implode(",",array_keys($pneed)).')
						AND naem = 0 AND `duration` < `maxdur`AND `dressed` = 0 AND `bs_owner` = '.$user['in_tower'].' and setsale = 0 and (sowner = 0 or sowner = '.$user['id'].') '.$notin2.'

	       					AND k <= '.$max.'

					');

					if ($q === false) {
						mysql_query('COMMIT');
						return false;
					}

					// �������� �� ��� ��������
					$tmplist = [];

					while($i = mysql_fetch_assoc($q)) {
						$tmplist[$i['prototype']][] = $i;
					}

					// ������ ��������� �� ���������� ����������� ���� � �������� �� �������
					reset($pneed);
					while(list($k,$v) = each($pneed)) {
						reset($tmplist[$k]);
						for ($i = 0; $i < $v; $i++) {
							list($ka,$va) = each($tmplist[$k]);
							if ($va === false) break; // ������ ����������, �.�. ������ ���-�� ����� �� ����� � ���������

							// ��������� ����� ������
							reset($list);
							while(list($kaa,$vaa) = each($list)) {
								// ���� ��� � ������ dresslist (�.�. �� ����� �� ID ������) � ����� ������ - �� ��������
								if (!isset($dresslist[$vaa['id']]) && $vaa['proto'] == $va['prototype']) {
									$list[$kaa]['id'] = $va['id'];
									break;
								}
							}

							$dresslist[$va['id']] = $va;
						}
					}

				} else {
					// ����� ����� �� ���?
				}
			} else {
				// ����� ��� ������ �� ����, ������ ������� ��������
			}

			// ������� �� ����� ������ ���� �� ����� �� �����
			reset($list);
			while(list($k,$v) = each($list)) {
				if (!isset($dresslist[$v['id']])) unset($list[$k]);
			}


			// �������� ��� ��� ����� ������ ����� ����������� ��� ���������� ������ ��� ������ ��� ������.
			// �� ��������� �� ��� � dressitem. �.�. ������������ ������ ��������� �������� �� ���� ����

			$user_slots_count = 10 + (int)$user['rep']/20000;

			$new_slots_count = 0;
			if ($user['prem'] > 0 && $user['in_tower'] == 0) {
				$new_slots_count = getAddSlot($user['prem']);
			}

			reset($list);
			while(list($k,$v) = each($list)) {
				$item = $dresslist[$v['id']];

				// �����
				if ($item['type'] == 12) {
					if ($user['level'] <= 3) {
						// ����� �� ������� ������
						unset($dresslist[$v['id']]);
						unset($list[$k]);
						continue;
					}

					$numslot = substr($k,1);
					if ($numslot >= 1 && $numslot <= 15) {
						// ������ �����
						if ($numslot > $user_slots_count) {
							unset($dresslist[$v['id']]);
							unset($list[$k]);
							continue;
						}
					} elseif ($numslot >= 16) {
						// ����� �����
						if ($numslot > $new_slots_count + 15) {
							unset($dresslist[$v['id']]);
							unset($list[$k]);
							continue;
						}
					}
				}

				if (!($item['nclass'] == $user['uclass'] || $item['nclass'] == 4 || $item['nlevel'] <= 7 || in_array($item['type'],$noclass_items_ok))) {
					// �������� �� �����
					unset($dresslist[$v['id']]);
					unset($list[$k]);
					continue;
				}

				// ������ ����
				if (in_array($item['prototype'],$nodress) || $item['otdel'] == 55) {
					// ������� ����� ������� ������ �����
					unset($dresslist[$v['id']]);
					unset($list[$k]);
					continue;
				}

				if (olditemdress($item,$user) == false) {
					// �������� ������ ����� ������� ����� ������
					unset($dresslist[$v['id']]);
					unset($list[$k]);
					continue;
				}

				if ($item['type'] == 30 && $user['room'] == 240 && $user['id_grup'] > 0) {
					// ���� � ��������
					unset($dresslist[$v['id']]);
					unset($list[$k]);
					continue;
				}

				// ��������� �����
				if ($item['needident'] > 0) {
					unset($dresslist[$v['id']]);
					unset($list[$k]);
					continue;
				}

				// ���������� ���� ��������
				if ($item['dategoden'] > 0 && $item['dategoden'] < time()) {
					unset($dresslist[$v['id']]);
					unset($list[$k]);
					continue;
				}
			}

			// �������� ��� �������� ����� �������� �� ��������
			reset($dresslist);
			$stats = [
				'gsila' => 0,
				'glovk' => 0,
				'ginta' => 0,
				'gintel' => 0,
				'ghp' => 0,
				'gmp' => 0,
				'gnoj' => 0,
				'gtopor' => 0,
				'gdubina' => 0,
				'gmech' => 0,
				'gfire' => 0,
				'gwater' => 0,
				'gair' => 0,
				'gearth' => 0,
				'glight' => 0,
				'ggray' => 0,
				'gdark' => 0,

			];
			while(list($k,$v) = each($dresslist)) {
				reset($stats);
				while(list($ka,$va) = each($stats)) {
					if ($v[$ka] != 0) { // != 0 �.� ����� ���� ������������� �����!
						$stats[$ka] += $v[$ka];
					}
				}
			}


			// ������� ��� ���� ����� - ��������� ����� �� ���� �� �������
			reset($list);
			while(list($k,$v) = each($list)) {
				$item = $dresslist[$v['id']];

				if (
					(($user['sila'] + $stats['gsila'] >= $item['nsila'] &&
					$user['lovk'] + $stats['glovk'] >= $item['nlovk'] &&
					$user['inta'] + $stats['ginta'] >= $item['ninta']) OR ($item['type']==33)) && // ��� �������� (33) �� ��������� �����������
					$user['vinos'] >= $item['nvinos'] &&
					$user['mudra'] + $stats['gmp'] >= $item['nmudra'] &&
					$user['level'] >= $item['nlevel'] &&
					$user['noj'] + $stats['gnoj'] >= $item['nnoj'] &&
					$user['topor'] + $stats['gtopor'] >= $item['ntopor'] &&
					$user['dubina'] + $stats['gdubina'] >= $item['ndubina'] &&
					$user['mec'] + $stats['gmech'] >= $item['nmech'] &&
					$user['mfire'] + $stats['gfire'] >= $item['nfire'] &&
					$user['mwater'] + $stats['gwater'] >= $item['nwater'] &&
					$user['mair'] + $stats['gair'] >= $item['nair'] &&
					$user['mearth'] + $stats['gearth'] >= $item['nearth'] &&
					$user['mlight'] + $stats['glight'] >= $item['nlight'] &&
					$user['mgray'] + $stats['ggray'] >= $item['ngray'] &&
					$user['mdark'] + $stats['gdark'] >= $item['ndark']
				) {
					// �� �� - ����� �����
				} else {
					// �� ����� �����, ���������� ������ �� ������,
					// �������� ��� �������� ����� ��� ���
					unset($dresslist[$v['id']]);
					unset($list[$k]);

					reset($stats);
					while(list($ka,$va) = each($stats)) {
						if ($item[$ka] != 0) $stats[$ka] -= $item[$ka];
					}
				}
			}

			if (!count($list) || !count($dresslist)) {
				mysql_query('COMMIT');
				return false;
			}


			$usql = "UPDATE users SET ";

			// ������ ������
			$mlist = [];
			for ($i = 1; $i <= 20; $i++) {
				$mlist['m'.$i] = 0;
			}
			reset($list);
			while(list($k,$v) = each($list)) {
				if (isset($mlist[$k])) {
					$mlist[$k] = $v;
				}
			}

			$msql = 'UPDATE users_complect_scrolls SET ';

			while(list($k,$v) = each($mlist)) {
				if (is_array($v)) {
					$msql .= $k.'= "'.mysql_real_escape_string(implode("|",$v)).'",';
				} else {
					$msql .= $k.'= "",';
				}
			}

			$msql = substr($msql,0,-1);
			$msql .= ' WHERE owner = '.$user['id'];

			$q = mysql_query($msql);
			if ($q === false) {
				mysql_query('COMMIT');
				return false;
			}


			// �� ���������, ����� ������� ����, �������� sql
			reset($list);
			$ilist = [];
			while(list($k,$v) = each($list)) {
				$usql .= $k.'='.$v['id'].',';
				$ilist[$v['id']] = 1;

				// ������� �� ����
				if ($dresslist[$v['id']]['prototype'] == 55510351) {
					$usql .= "expbonus = expbonus + '0.1',";
				}
				if ($dresslist[$v['id']]['prototype'] == 55510352) {
					$usql .= "expbonus = expbonus + '0.3',rep_bonus = rep_bonus + '0.2',";
				}
				if ($dresslist[$v['id']]['prototype'] == 410027) {
					$usql .= "expbonus = expbonus + '0.1',rep_bonus = rep_bonus + '0.1',";
				}
				if ($dresslist[$v['id']]['prototype'] == 410028) {
					$usql .= "expbonus = expbonus + '0.3',rep_bonus = rep_bonus + '0.2',";
				}

			}
			$isql = 'UPDATE inventory SET dressed = 1 WHERE id IN ('.implode(",",array_keys($ilist)).') LIMIT 50';

			if ($stats['gsila'] != 0) $usql .= 'sila = sila + '.$stats['gsila'].',';
			if ($stats['glovk'] != 0) $usql .= 'lovk = lovk + '.$stats['glovk'].',';
			if ($stats['ginta'] != 0) $usql .= 'inta = inta + '.$stats['ginta'].',';
			if ($stats['gintel'] != 0) $usql .= 'intel = intel + '.$stats['gintel'].',';
			if ($stats['gmp'] != 0) {
				$usql .= 'mudra = mudra + '.$stats['gmp'].',';
				$usql .= 'maxmana = ((mudra)*10),';
				$usql .= 'fullmptime=(UNIX_TIMESTAMP()),';
			}
			if ($stats['ghp'] != 0) {
				$usql .= 'maxhp = maxhp + '.$stats['ghp'].',';
				$usql .= 'fullhptime=(UNIX_TIMESTAMP()),';
			}

			if ($stats['gnoj'] != 0) $usql .= 'noj = noj + '.$stats['gnoj'].',';
			if ($stats['gtopor'] != 0) $usql .= 'topor = topor + '.$stats['gtopor'].',';
			if ($stats['gmech'] != 0) $usql .= 'mec = mec + '.$stats['gmech'].',';
			if ($stats['gdubina'] != 0) $usql .= 'dubina = dubina + '.$stats['gdubina'].',';

			if ($stats['gfire'] != 0) $usql .= 'mfire = mfire + '.$stats['gfire'].',';
			if ($stats['gwater'] != 0) $usql .= 'mwater = mwater + '.$stats['gwater'].',';
			if ($stats['gair'] != 0) $usql .= 'mair = mair + '.$stats['gair'].',';
			if ($stats['gearth'] != 0) $usql .= 'mearth = mearth + '.$stats['gearth'].',';

			if ($stats['glight'] != 0) $usql .= 'mlight = mlight + '.$stats['glight'].',';
			if ($stats['ggray'] != 0) $usql .= 'mgray = mgray + '.$stats['ggray'].',';
			if ($stats['gdark'] != 0) $usql .= 'mdark = mdark + '.$stats['gdark'].',';

			if ($user['mana'] > ($user['mudra']+$stats['gmp'])*10) {
				$usql .= ' mana = maxmana,';
			}

			$usql = substr($usql,0,-1);

			$usql .= ' WHERE id = '.$user['id'].' LIMIT 1';

			$q = mysql_query($usql);
			if ($q === false) {
				mysql_query('COMMIT');
				return false;
			}

			$q = mysql_query($isql);
			if ($q === false) {
				mysql_query('COMMIT');
				return false;
			}

			mysql_query('COMMIT');

			return true;
		} else {
	 		err("�� ������ � ������� �� ���!");
			mysql_query('COMMIT');
			return false;
		}
	}

	mysql_query('COMMIT');
	return false;
}

function ref_uclass ($id) {
	global $user, $mysql;
	/*
	 ���������, ��� ���������� � ������������ ���������� "��������"
	 ��������, ��� ���������� � ������������ ���������� "��������"
	 ����, ��� ���������� � ������������ ���������� "������������"
	 �� ��������, ��� ����������, �� ���������� �� � ���� �� ����������� �������
	*/

	$inparray[1]=$user['lovk'];
	$inparray[2]=$user['inta'];
	$inparray[3]=$user['vinos'];

	$uclass = array_keys($inparray, max($inparray));

	return $uclass[0];
}


// ����� ������
function ref_drop ($id) {
	global $user;

	$slot = array('sergi','kulon','weap','bron','r1','r2','r3','helm','perchi','shit','boots','m1','m2','m3','m4','m5','m6','m7','m8','m9','m10','m11','m12','m13','m14','m15','nakidka','rubashka','','','runa1','runa2','runa3','m16','m17','m18','m19','m20');

	for ($i=0;$i<=count($slot);$i++) {
		if ($slot[$i]!='') {
			if ($user[$slot[$i]] && !derj($user[$slot[$i]]))  {
				dropitem($i+1);
				$user[$slot[$i]] = null;
			}
		}
	}
}

//������ �������
function derj($id) {
	global $user;

	return derj_telo($id,$user);
}

// ������ ������� ���
function ref_dropnaem($telo) {
	$slot = array(1 => 'sergi', 2 => 'kulon',9 => 'perchi', 3 => 'weap', 4 => 'bron', 5 => 'r1', 6 => 'r2', 7 => 'r3', 8 => 'helm', 10 => 'shit', 11 => 'boots', 27 => 'nakidka', 28 => 'rubashka');
	$ids = [];

	foreach($slot as $k => $v) {
		if ($telo[$v] > 0) $ids[] = $telo[$v];
	}

	if (count($ids)) {
		// ��������� ��� id ����� ������� �� �����, ��� ������� ���� ��������� ����� �� �� �� �������
		$q = mysql_query('SELECT * FROM inventory WHERE owner = '.$telo['owner'].' and id IN ('.implode(",",$ids).') and dressed = 2');
		$items = [];

		while($i = mysql_fetch_assoc($q)) {
			$items[$i['id']] = $i;
		}

		// ��������� ��� ����, ���� �����-�� ���� ������, �� ������������ ���� � ��������� �� ������
		while(true) {
			$allok = true;
			foreach($items as $k => $v) {
				if (
					$v['duration'] >= $v['maxdur'] ||
					($v['dategoden'] > 0 && $v['dategoden'] < time()) ||
					$telo['sila'] < $v['nsila'] ||
					$telo['lovk'] < $v['nlovk'] ||
					$telo['inta'] < $v['ninta'] ||
					$telo['vinos'] < $v['nvinos'] ||
					$telo['intel'] < $v['nintel'] ||
					$telo['mudra'] < $v['nmudra'] ||
					$telo['level'] < $v['nlevel'] ||

					$telo['noj'] < $v['nnoj'] ||
					$telo['topor'] < $v['ntopor'] ||
					$telo['dubina'] < $v['ndubina'] ||
					$telo['mec'] < $v['nmech'] ||

					$telo['mfire'] < $v['nfire'] ||
					$telo['mwater'] < $v['nwater'] ||
					$telo['mair'] < $v['nair'] ||
					$telo['mearth'] < $v['nearth'] ||
					$telo['mlight'] < $v['nlight'] ||
					$telo['mgray'] < $v['ngray'] ||
					$telo['mdark'] < $v['ndark']

				)  {
					// ���� ����� ���������
					// ������� ����
					foreach($slot as $ka => $va) {
						if ($telo[$va] == $v['id']) {
							dropitemnaem($telo,$ka);

							// ������������ $telo
							$q = mysql_query('SELECT * FROM users_clons WHERE id = '.$telo['id']);
							$q = mysql_fetch_assoc($q);
							if ($q !== false) {
								$telo = $q;
							}

							// ������� �� ������� � ������������� �������
							unset($items[$v['id']]);
							$allok = false;
							break 2;
						}
					}
				}
			}
			if ($allok) break;
		}

	}
	return $telo;
}

function derj_telo($id,$telo) {
	$restal_roms=array(197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282);

	$ch_al = $telo['align'];
   	if($telo['klan']=='pal') {
		$ch_al=6;
		$ch_al2=1;
	} else {
		$ch_al2=0;
	}

	if (in_array($telo['room'],$restal_roms) && $telo['klan']=='pal') {
		$ch_al=6;
	}



	if ($dd = mysql_query("SELECT i.`id` FROM `users` as u, oldbk.`inventory` as i
		WHERE
    (i.nsex=0 OR i.nsex=u.sex+1 ) AND (i.dategoden=0 OR i.`dategoden`>".time().") AND
		i.needident = 0 AND
		i.id = {$id} AND
		i.duration < i.maxdur  AND
		i.owner = {$telo['id']} AND
		((u.sila >= i.nsila AND  u.lovk >= i.nlovk AND u.inta >= i.ninta ) OR (i.type=33)) AND
		u.vinos >= i.nvinos AND
		u.intel >= i.nintel AND
		u.mudra >= i.nmudra AND
		u.level >= i.nlevel AND
		((".(int)$ch_al." = i.nalign) or (i.nalign = 0) or (u.align=5) or (".$ch_al2." = i.nalign) ) AND
		u.noj >= i.nnoj AND
		u.topor >= i.ntopor AND
		u.dubina >= i.ndubina AND
		u.mec >= i.nmech AND
		u.mfire >= i.nfire AND
		u.mwater >= i.nwater AND
		u.mair >= i.nair AND
		u.mearth >= i.nearth AND
		u.mlight >= i.nlight AND
		u.mgray >= i.ngray AND
		u.mdark >= i.ndark AND
		((u.uclass=i.nclass) OR (i.nclass=4) OR i.type in (3,12,27,28,34) OR i.nlevel<=7 ) AND
		i.setsale = 0 AND
		i.type!=555 AND
		i.type!=556 AND
		u.id = {$telo['id']};"))
	{
		$dd = mysql_fetch_array($dd);
		if($dd[0] > 0) {

			return true;
		} else {

			return false;
		}
	}
}


function dropitemid_telo($slot,$telo) {
	return dropitem($slot,false,$telo);
}


function ref_drop_telo($telo) {
	$slot = array('sergi','kulon','weap','bron','r1','r2','r3','helm','perchi','shit','boots','m1','m2','m3','m4','m5','m6','m7','m8','m9','m10','m11','m12','m13','m14','m15','nakidka','rubashka','','','runa1','runa2','runa3','m16','m17','m18','m19','m20');

	for ($i=0;$i<=count($slot);$i++) {
		if ($slot[$i]!='') {
			if ($telo[$slot[$i]] && !derj_telo($telo[$slot[$i]],$telo))  {
				dropitemid_telo($i+1,$telo);
			}
		}
	}
}


// ����� �������
function destructitem($id, $forars = false) {
	global $user;

    	$sql1='INSERT INTO oldbk.`inventory_aftr_del`(`deltime`, ';

	if ($forars) {
		$sql = mysql_query("SELECT * FROM oldbk.`inventory` WHERE `id` = '{$id}' LIMIT 1;");
	} else {
		if (!isset($user['id'])) return false;
		$sql = mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$user['id']}' AND `id` = '{$id}' LIMIT 1;");
	}

	for($i=0;$i<mysql_num_fields($sql);$i++) {
		$fields[$i]=mysql_field_name($sql, $i);
		$sql1.='`' . mysql_field_name($sql, $i) . '`, ';
	}
 	$sql1=substr($sql1,0,-2). ') VALUES ("'.time().'", ';


	while($dress = mysql_fetch_array($sql)) {
		$ok1 = 0;
		if($dress['add_pick'] != '') {
		 	undress_img($dress);
         		$ok1=1;
   		} else {
			$ok1=1;
		}

		if($ok1==1) {
			switch($dress['type']) {
				case 1: $slot1 = 'sergi'; break;
				case 2: $slot1 = 'kulon'; break;
				case 3: $slot1 = 'weap'; break;
				case 4: $slot1 = 'bron'; break;
				case 5: $slot1 = 'r1'; break;
				case 6: $slot1 = 'r2'; break;
				case 7: $slot1 = 'r3'; break;
				case 8: $slot1 = 'helm'; break;
				case 9: $slot1 = 'perchi'; break;
				case 10: $slot1 = 'shit'; break;
				case 11: $slot1 = 'boots'; break;
				case 12: $slot1 = 'm1'; break;
				case 27: $slot1 = 'nakidka'; break;
				case 28: $slot1 = 'rubashka'; break;
				case 34: $slot1 = 'shit'; break;
				case 35: $slot1 = 'weap'; break;
			}

			if($dress['type']==30) {
				if($user['runa1']==$dress['id']) { $slot1 = 'runa1';}
				elseif($user['runa2']==$dress['id']) { $slot1 = 'runa2';}
				elseif($user['runa3']==$dress['id']) { $slot1 = 'runa3';}
			} elseif($dress['type']==5) {
				if($user['r1']==$dress['id']) { $slot1 = 'r1';}
				elseif($user['r2']==$dress['id']) { $slot1 = 'r2';}
				elseif($user['r3']==$dress['id']) { $slot1 = 'r3';}
			} elseif($dress['type']==12) {
				if($user['m1']==$dress['id']) { $slot1 = 'm1';}
				elseif($user['m2']==$dress['id']) { $slot1 = 'm2';}
				elseif($user['m3']==$dress['id']) { $slot1 = 'm3';}
				elseif($user['m4']==$dress['id']) { $slot1 = 'm4';}
				elseif($user['m5']==$dress['id']) { $slot1 = 'm5';}
				elseif($user['m6']==$dress['id']) { $slot1 = 'm6';}
				elseif($user['m7']==$dress['id']) { $slot1 = 'm7';}
				elseif($user['m8']==$dress['id']) { $slot1 = 'm8';}
				elseif($user['m9']==$dress['id']) { $slot1 = 'm9';}
				elseif($user['m10']==$dress['id']) { $slot1 = 'm10';}
				elseif($user['m11']==$dress['id']) { $slot1 = 'm11';}
				elseif($user['m12']==$dress['id']) { $slot1 = 'm12';}
				elseif($user['m13']==$dress['id']) { $slot1 = 'm13';}
				elseif($user['m14']==$dress['id']) { $slot1 = 'm14';}
				elseif($user['m15']==$dress['id']) { $slot1 = 'm15';}
				elseif($user['m16']==$dress['id']) { $slot1 = 'm16';}
				elseif($user['m17']==$dress['id']) { $slot1 = 'm17';}
				elseif($user['m18']==$dress['id']) { $slot1 = 'm18';}
				elseif($user['m19']==$dress['id']) { $slot1 = 'm19';}
				elseif($user['m20']==$dress['id']) { $slot1 = 'm20';}
			}

			if ($dress['owner'] == $user['id'] || $forars) {

				if ($dress['dressed'] == 1) {

					$add_exp_bonus="";

					if ($dress['prototype']==55510351) {
						//��������� ������� ���� ���� -10%
						$add_exp_bonus=" u.expbonus=u.expbonus-'0.1', ";
					}

					if ($dress['prototype']==55510352) {
						//��������� ������� ���� ���� -10%
						$add_exp_bonus=" u.expbonus=u.expbonus-'0.3',u.rep_bonus=u.rep_bonus-'0.2', ";
					}

					if ($dress['prototype']==410027) {
						$add_exp_bonus=" u.expbonus=u.expbonus-'0.1',u.rep_bonus=u.rep_bonus-'0.1', ";
					}

					if ($dress['prototype']==410028) {
						$add_exp_bonus=" u.expbonus=u.expbonus-'0.3',u.rep_bonus=u.rep_bonus-'0.2', ";
					}


					if (mysql_query("UPDATE `users` as u, oldbk.`inventory` as i SET u.{$slot1} = 0, i.dressed = 0,
						u.sila = u.sila - i.gsila,
						u.lovk = u.lovk - i.glovk,
						u.inta = u.inta - i.ginta,
						u.intel = u.intel - i.gintel,
						u.maxhp = u.maxhp - i.ghp,
						u.noj = u.noj - i.gnoj,
						u.topor = u.topor - i.gtopor,
						u.dubina = u.dubina - i.gdubina,
						u.mec = u.mec - i.gmech,
						u.mfire = u.mfire - i.gfire,
						u.mwater = u.mwater - i.gwater,
						u.mair = u.mair - i.gair,
						u.mearth = u.mearth - i.gearth,
						u.mlight = u.mlight - i.glight,
						u.mgray = u.mgray - i.ggray, ".$add_exp_bonus."
						u.mdark = u.mdark - i.gdark
						WHERE i.id = u.{$slot1} AND i.dressed = 1 AND i.owner = {$user['id']} AND u.id = {$user['id']};"))
					{
						mysql_query("UPDATE `users` SET `hp` = `maxhp`, `fullhptime` = ".time()." WHERE  `hp` > `maxhp` AND `id` = '{$user['id']}' LIMIT 1;");
					} else {
						// bad query
					}
				} else	{
					// not dressed
				}

		        	$shmot=array(1,2,3,4,5,8,9,10,11,22,27,28,30,34,35);
		        	if((in_array($dress['type'],$shmot) || $dress['prototype'] == 3003092 || $dress['prototype'] == 3003093) && $user['in_tower']==0 && $dress['labonly'] != 1)
              {
		        		for($iii=0;$iii<count($fields);$iii++)
                    {
						         $sql1.=" '".$dress[$iii]."', ";
					          }

	                		$sql1=substr($sql1,0,-2). ');';
					                 mysql_query($sql1);
		        	}

				if($dress['setsale'] > 0) {
					mysql_query("DELETE FROM oldbk.`comission_indexes` WHERE id_item = '".$id."' LIMIT 1");
				}

				if($dress['arsenal_klan']!='')  {
					mysql_query("DELETE FROM oldbk.`clans_arsenal` WHERE id_inventory = '".$id."' LIMIT 1");
				}

				mysql_query("DELETE FROM oldbk.`inventory` WHERE `id` = '{$id}' LIMIT 1;");

				//�������
				if ($dress['prototype']==5671)
					{
					mysql_query("DELETE FROM `oldbk`.`stol` WHERE `owner`='{$user['id']}' AND `stol`=5671 LIMIT 1;");
					}

				gift_from_item_break($user,$dress);

			}
		}
	}
}

// ������������ �����
function usemagic($id,$target) {
	global $user, $mysql, $fbattle,$boec_t1,$boec_t2,$data_battle,$STEP,$my_wearItems,$rooms,$magic_points,$plat_set_abils,$gold_set_abils,$exptable,$can_inc_magic;

	$rowm = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$id}' AND setsale=0 AND bs_owner='".$user[in_tower]."' LIMIT 1;"));

	if (($user['klan']=='pal') OR ($user['klan']=='radminion') OR ($user['klan']=='Adminion') )  { $addalign=6;} else { $addalign=0;}
	if ($rowm['sowner']>0)	{  if ($rowm['sowner']==$user['id'])  { $sown=true; } else  { $sown=false; } } 	else { 	$sown=true; }


	if (((		(($user['sila'] >= $rowm['nsila']) or ($rowm['nsila']==0) )  &&
			(($user['lovk'] >= $rowm['nlovk']) or  ($rowm['nlovk']==0) ) &&
			(($user['inta'] >= $rowm['ninta'])  or  ($rowm['ninta']==0) ) &&
			($user['vinos'] >= $rowm['nvinos'])   &&
			($user['intel'] >= $rowm['nintel']) &&
			($user['mudra'] >= $rowm['nmudra']) &&
			(($user['level'] >= $rowm['nlevel']) ) &&
			(((int)$user['align'] == (int)$rowm['nalign']) OR ($rowm['nalign'] == 0) OR ($user['align']==5) OR ($rowm['nalign'] == $addalign)  ) &&
			($user['noj'] >= $rowm['nnoj']) &&
			($user['topor'] >= $rowm['ntopor']) &&
			($user['dubina'] >= $rowm['ndubina']) &&
			($user['mec'] >= $rowm['nmech']) &&
			($rowm['type'] < 13 OR $rowm['type'] == 50 OR $rowm['type'] == 28 OR $rowm['type']==200 OR in_array($rowm['prototype'], [410027, 1006232, 1006233, 1006234])) &&
            ($user['mfire'] >= $rowm['nfire']) &&
			($user['mwater'] >= $rowm['nwater']) &&
			($user['mair'] >= $rowm['nair']) &&
			($user['mearth'] >= $rowm['nearth']) &&
			($user['mlight'] >= $rowm['nlight']) &&
			($user['mgray'] >= $rowm['ngray']) &&
			($user['mdark'] >= $rowm['ndark']) &&
			($rowm['needident'] == 0)
		) ||
		$rowm['magic'] == 48 ||
		$rowm['magic'] == 50 ||
		$rowm['magic'] == 100 ||   //������
		$rowm['magic'] == 101 ||   //������
		$rowm['magic'] == 102 ||  //������
		$rowm['magic'] == 793||
		$rowm['magic'] == 794 ||
		$rowm['magic'] == 795 ||
		$rowm['magic'] == 792 ||
		$rowm['magic'] == 791 ||
		$rowm['magic'] ==20007 ||   //�������� ���������
		$rowm['magic'] ==20008 || //�������� ���������
		$rowm['magic'] ==20009 || //�������� ���������
		$rowm['magic'] ==20010 || //�������� ���������
		$rowm['magic'] ==20011 || //�������� ���������
		$rowm['magic'] ==20012 || //�������� ���������
		$rowm['magic'] ==20013 || //�������� ���������
		$rowm['magic'] == 226 ||  // ����� ������ (�������)
		$rowm['magic'] == 1002 || // ����� �������.(�������)

		$rowm['magic'] ==111010 ||   //������� ��������� �1
		$rowm['magic'] ==112010 ||   //������� ��������� �2
		$rowm['magic'] ==113010 ||   //������� ��������� �3
		$rowm['magic'] ==114010 ||   //������� ��������� �4

		$rowm['magic'] == 1000 || //NY gift from administration
		$rowm['magic'] == 1001 || //NY snowball
		$rowm['magic'] == 1003 || //NY 1
		$rowm['magic'] == 1004 || //NY 2
		$rowm['magic'] == 1005 || //NY 3
          $rowm['magic'] == 1006 || //NY 3
          $rowm['magic'] == 1007 || //NY 3
          $rowm['magic'] == 1008 || //NY 3
          $rowm['magic'] == 1009 || //NY 3
          $rowm['magic'] == 1010 || //NY 3
          $rowm['magic'] == 1011 || //NY 3
          $rowm['magic'] == 1020 || //NY 3
          $rowm['magic'] == 1021 || //NY 3
          $rowm['magic'] == 171 ||
          $rowm['magic'] == 556 ||
          $rowm['magic'] == 4004000 || //����������� �������

          ( ($rowm['magic'] == 22222) and ($rowm[nlevel]<=$user[level]) and ($rown[ngray]<=$user[mgray])) || //�������-
		$rowm['magic'] == 1022 || //NY 3
		$rowm['magic'] == 2001 || //���������. �����
		$rowm['magic'] == 2000  //happy bithday
		//$rowm['includemagic'] == 19 ||
		//$rowm['includemagic'] == 20 ||
		//$rowm['includemagic'] == 21
		) and 	($sown==true) )
	{

		$magic = magicinf($rowm['magic']);
		if(!$rowm['magic']) {
			$incmagic = magicinf($rowm['includemagic']);
			$incmagic['name'] = $rowm['includemagicname'];
			$incmagic['cur'] = $rowm['includemagicdex'];
			$incmagic['max'] = $rowm['includemagicmax'];
			if($incmagic['cur'] <= 0) {
					return false;
			}
			$magic['targeted'] = $incmagic['targeted'];

            if($user['level']>=$incmagic['nlevel'])
            {
				$magicfile=$incmagic['file'];
            	$canuse=1;
            }

		}
		elseif($user['level']>=$magic['nlevel'])
		{
            $magicfile=$magic['file'];
            $canuse=1;
		}

/// if ($user['id']==7011) { echo " KU"; echo  $canuse ; }
		if ($magic['id']==155)
					{
				       $magicfile=$magic['file'];
				        $canuse=1;
				        } //TEMP

		if($canuse==1)
		{
			echo "<font color=red><b>";
			$sbet = 0;
			$bet = 0;
			$MAGIC_OK = 0;
			include("./magic/".$magicfile);
			echo "</b></font>";
		}
		else
		{
			echo '<font color=red><b>������� �������...</b></font>';
			return false;
		}

		if ($bet) {
			if (($rowm['maxdur'] <= ($rowm['duration']+1))and ($rowm['magic']) )
			{
				destructitem($rowm['id']);
				$ittt=$rowm['id'];
				unset($my_wearItems[$ittt]);
			}
			else
			{
				if(!$rowm['magic']) {
					mysql_query("UPDATE oldbk.`inventory` SET `includemagicdex` =`includemagicdex`-{$bet} WHERE `id` = {$rowm['id']} LIMIT 1;");
					$ittt=$rowm['id'];
				        $my_wearItems[$ittt][includemagicdex]-=1; // ��� ������

					$rowm['includemagicdex']--;

					// ��������� ��� � ���� �����������
					if($rowm['includemagic'] > 0 && $rowm['includemagicmax'] > 0 && $rowm['includemagicdex'] <= 0 && $rowm['includemagicuses'] <= 0) {
						$shop_base = mysql_fetch_array(mysql_query('SELECT * FROM oldbk.shop WHERE id = \''.$rowm['prototype'].'\' LIMIT 1;'));
						if (!($shop_base['id']>0)) {
							$shop_base = mysql_fetch_array(mysql_query('SELECT * FROM oldbk.eshop WHERE id = \''.$rowm['prototype'].'\' LIMIT 1;'));
						}

						$new_kr_cost = $rowm['cost'];

						if ($rowm['includeprototype'] > 0) {
							if ($rowm['includerechargetype'] == 1) {
								$proto = mysql_query_cache('SELECT * FROM oldbk.shop WHERE id = '.$rowm['includeprototype'],false,300);
							} elseif ($rowm['includerechargetype'] == 2) {
								$proto = mysql_query_cache('SELECT * FROM oldbk.eshop WHERE id = '.$rowm['includeprototype'],false,300);
							} elseif ($rowm['includerechargetype'] == 3) {
								$proto = mysql_query_cache('SELECT * FROM oldbk.cshop WHERE id = '.$rowm['includeprototype'],false,300);
							}

							if (count($proto)) {
								$proto = $proto[0];

								$new_kr_cost = $rowm['cost'] - $proto['cost'];
								if($new_kr_cost < 0) { $new_kr_cost = 1; }
							}
						} else {
							$new_kr_cost = $rowm['cost'] - $rowm['includemagiccost'] * 2;
							if($new_kr_cost < 0) { $new_kr_cost = 1; }
						}

						if (($shop_base['id']>0) and (!($rowm['prototype'] >= 55510301 && $rowm['prototype'] <= 55510401)) )  {
							if($shop_base['nlevel']<$rowm['up_level']) {
								$shop_base['nlevel']=$rowm['up_level'];
							}

							mysql_query(
								"UPDATE oldbk.`inventory` SET
								`includemagic` = '',
								`includemagicdex` = '',
								`includemagicmax` = '',
								`includemagicname` = '',
								`includemagicuses` = '',
								`includemagiccost` = '',
								`includemagicekrcost` = '',
								`nintel` = '{$shop_base['nintel']}',
								`nlevel` = '{$shop_base['nlevel']}',
								`nmudra` = '{$shop_base['nmudra']}',
								`ngray` = '{$shop_base['ngray']}',
								`ndark` = '{$shop_base['ndark']}',
								`nlight` = '{$shop_base['nlight']}',
								`cost` = '{$new_kr_cost}',
								`massa` = `massa` - 1,
								`includerechargetype` = 0,
								`includeprototype` = 0
								WHERE `id` = '{$rowm['id']}' LIMIT 1;");
						} else {
							mysql_query(
								"UPDATE oldbk.`inventory` SET
								`includemagic` = '',
								`includemagicdex` = '',
								`includemagicmax` = '',
								`includemagicname` = '',
								`includemagicuses` = '',
								`includemagiccost` = '',
								`includemagicekrcost` = '',
								`cost` = '{$new_kr_cost}',
								`includerechargetype` = 0,
								`includeprototype` = 0
								 WHERE `id` = '{$rowm['id']}' LIMIT 1;");
						}
						addchp ('<font color=red>��������!</font> ���������� ������ \"'.$rowm['includemagicname'].'\" �������� ��� ���� ������� � ��� ���������.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
					}
				} else {
					mysql_query("UPDATE oldbk.`inventory` SET `duration` =`duration`+{$bet} WHERE `id` = {$rowm['id']} LIMIT 1;");
					$ittt=$rowm['id'];
				        $my_wearItems[$ittt][duration]-=1; // ��� ������
				}
			}
		}
		echo " ";

		if ($user['in_tower'] == 0) {
			// ����� � ����
			$itemdescr = '"'.$rowm['name'].'" id:('.get_item_fid($rowm).') ['.$rowm['duration'].'/'.$rowm['maxdur'].'] ';
			if (strlen($rowm["includemagicname"])) {
				$itemdescr .= '�����: '.$rowm['includemagicname'].' ['.$rowm['includemagicdex'].'/'.$rowm['includemagicmax'].']';
			}

			$itemdescr = mysql_real_escape_string($itemdescr);

			$addtxt = "";
			if ($sbet)
			{
				$addtxt = "������";
				$rec['type']=32;

				//������� �� �����
				// � ���� � ��� = ����� ���� ��� �������� ���
				// � �� ����� ���� ������ ���� - ���� ����
				if (($user[battle]>1) and ($user[runa1]>0 or $user[runa2]>0 or $user[runa3]>0 ) )
				{

				 if (
				 		($data_battle[type]!=30) AND //�� ��� � �����
				 		($data_battle[type]!=311) AND
				 		($data_battle[type]!=312) AND
				 		($data_battle[type]!=314) AND
				 		( $data_battle[type]!=11) AND //�� �����
				 		( $data_battle[type]!=10)  AND //�� ��
				 		( $data_battle[type]!=12)  AND //�� �����
				 		( $data_battle[type]!=15) AND // �� ��� � �������� ������ ����� - ��������� ���
				 		(!($data_battle['type']>=240 AND $data_battle['type'] <=260)) // �� �������� ������ �����
				 	) //��� - ��� �� ��������

					{
					if ( ($magic_points[$rowm['magic']] >0 ) OR ($magic_points[$rowm['includemagic']] >0 ) )    // ��������� ������ �� ������ ������� -������� � �������
						{

						if (($data_battle[coment] =='��� � �������� �����') OR ($data_battle[coment] =='<b>��� � ����� �������</b>') OR ($data_battle[coment] =='<b>��� � ������� ��������</b>') )
						{
						$point=1; // ��� ����� ��� ������ 1 ����
						}
						else
						{
							if  ($magic_points[$rowm['magic']] >0 )
								{
								$point=$magic_points[$rowm['magic']];// ������ ������� - �� ������� ������ ���� runs_exp_table.php
								}
							else
							if ($magic_points[$rowm['includemagic']] >0 )
								{
								$point=$magic_points[$rowm['includemagic']];// ������ ������� - �� ������� ������ ���� runs_exp_table.php - ��� �������
								}

						}



						$runs=0; // ������� ���. ��� � ����� � ���
						if ($user[runa1]>0) $runs++;
						if ($user[runa2]>0) $runs++;
						if ($user[runa3]>0) $runs++;
						$point=round($point);

						if ($user['align']==4)
							{
							$point=round($point*0.5); // ��� ��������� 50%
							}

						//��� �� ������ ���� ���� ������
						$RKF_BONUS=0;


						if ($user['weap']>0)
							{
							//���� ������ - ������� ��� �� ������
							/*
							$ekr_elka=array(55510312,55510313,55510314,55510315,55510316,55510317,55510318,55510319,55510320,55510321,55510322,55510334,55510335,55510336,55510337,55510338,55510339);
							$art_elka=array(55510323,55510324,55510325,55510326,55510327,55510340,55510341,55510342,55510343,55510344);
							*/
							$ekr_elka = array(55510350);
							$art_elka = array(55510351);
							$sart_elka = array(55510352);

							$test_weap=mysql_fetch_array(mysql_query("select id, prototype from oldbk.inventory where id={$user['weap']}"));


							if (($test_weap['prototype'] >= 410021 AND $test_weap['prototype'] <= 410026) AND (time()>mktime(0,0,0,7,5,2017))  )
							{
								//������� ������ ������ ����� ������� �����
								$RKF_BONUS=10;
							}
							elseif (  (($test_weap['prototype'] >= 55510301) AND ($test_weap['prototype'] <= 55510311) ) || (($test_weap['prototype'] >= 55510328) AND ($test_weap['prototype'] <= 55510333))  )
								{
								//�������� ����
								$RKF_BONUS=1;
								}
							elseif ((in_array($test_weap['prototype'],$ekr_elka)) || ($test_weap['prototype'] >= 410021 AND $test_weap['prototype'] <= 410026) || ($test_weap['prototype'] >= 410130 AND $test_weap['prototype'] <= 410135) || ($test_weap['prototype'] >= 410001 AND $test_weap['prototype'] <= 410008) )
								{
								//������� ����
								$RKF_BONUS=2;
								}
							elseif (in_array($test_weap['prototype'],$art_elka))
								{
								//������� ����
								$RKF_BONUS=3;
								}
							elseif (in_array($test_weap['prototype'],$sart_elka))
								{
								$RKF_BONUS=10;
								}
							elseif ($test_weap['prototype'] == 410027)
								{
								$RKF_BONUS=5;
								}
							elseif ($test_weap['prototype'] == 410028)
								{
								$RKF_BONUS=10;
								}
							else
								{
								$RKF_BONUS=0;
								}

							}

							if ($user['shit']>0)
							{
							//���� ��� ���� ������� ������
							$test_shit=mysql_fetch_array(mysql_query("select id, prototype from oldbk.inventory where id={$user['shit']}"));
							if ($test_shit['prototype'] == 410027)
								{
								$RKF_BONUS+=5;
								}
							}




						///����� ������� ������
							$getloadbonus=mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and `type` in (908,9103,20007) ;");
						        while($get_load_bon = mysql_fetch_array($getloadbonus))
						        {
						        	if ($get_load_bon['type']==9103)
								{
								$RKF_BONUS+=(int)($get_load_bon['add_info']*100);
								}
								elseif ($get_load_bon['type']==20007)
								{
								//����� ���� �� ���c������ ������ �����
									$eff_tmp=explode(":",$get_load_bon['add_info']);
									$eff_bonus=$eff_tmp[0];
									if ($eff_bonus>0)
									{
									$RKF_BONUS+=(int)($eff_bonus*100);
									}
								}
								elseif ($get_load_bon['id']>0)
								{
								$RKF_BONUS+=(int)($get_load_bon['add_info']);
								}
							}
						////////////

							if ($cure_value>0)
							{
							//���� ������� �����
							$addsqlinsert=" , `usehill`=1, `cure_value_hp`='{$cure_value}' ";
							$addsqlupdate=" , `usehill`= `usehill` + 1 , `cure_value_hp`=`cure_value_hp`+'{$cure_value}' ";
							}



						mysql_query("INSERT INTO `oldbk`.`battle_runs_exp` SET `battle`='{$user[battle]}' ,`owner`='{$user['id']}',`point`='{$point}' , `runs`='{$runs}' , `rkf_bonus` ='{$RKF_BONUS}' ".$addsqlinsert." ON DUPLICATE KEY UPDATE `point`=`point`+'{$point}' ,  `runs`='{$runs}' ".$addsqlupdate."  , `rkf_bonus`=if(`rkf_bonus`<{$RKF_BONUS},'{$RKF_BONUS}',`rkf_bonus`) "); // ���� ������ � ������ ������
						}
					}
				}


			} else {
				if ($rowm['name']=='������������ �����')
					{
					$addtxt = "������";
					$rec['type']=32;
					}
					else
					{
					$addtxt = "��������";
					$rec['type']=33;
					}
			}

			//new_delo
  		    			$rec['owner']=$user['id'];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];

					// ����� ������������� ����� ���� �������������� ���������� ��� ���� $us ��� $jert - ����� � ����
					$t_id = 0;
					$t_login = "";

					if ($user['battle'] == 0) {
						if (isset($jert['id'])) {
							$t_id = $jert['id'];
							$t_login = $jert['login'];
						} elseif (isset($us['id'])) {
							$t_id = $us['id'];
							$t_login = $us['login'];
						}
					}

					$rec['target'] = $t_id;
					$rec['target_login'] = $t_login;

					$rec['sum_kr']=0;
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($rowm);
					$rec['item_name']=$rowm['name'];
					$rec['item_count']=1;
					$rec['item_type']=$rowm['type'];
					$rec['item_cost']=$rowm['cost'];
					$rec['item_dur']=$rowm['duration'];
					$rec['item_maxdur']=$rowm['maxdur'];
					$rec['item_ups']=$rowm['ups'];
					$rec['item_unic']=$rowm['unik'];
					$rec['item_incmagic']=$rowm['includemagicname'];
					$rec['item_incmagic_count']=$rowm['includemagicuses'];
					$rec['item_arsenal']='';
					$rec['battle']=$user['battle'];
					if (isset($magictoitem)) {
						$rec['aitem_id'] = get_item_fid($magictoitem);
						if (isset($magictoitem['add_info']) && !empty($magictoitem['add_info'])) {
							$rec['add_info'] = $magictoitem['add_info'];
						}
					}

					add_to_new_delo($rec); //�����
		}

}
else
	{
	echo "<font color=red><b>� ��� �� ������� ���������� ��� ������������� ���� �����";
	echo "</b></font>";
	}

if ($MAGIC_OK==1) return $MAGIC_OK;

if ($TELEPORT_GOOD=='to_angels')
		{
		$_SESSION['TELEPORT_GOOD']='angelscity.oldbk.com';
		echo "<script>".(!is_array($_SESSION['vk'])?"top.":"parent.")."window.location='/teleport_redir.php'</script>";
		die();
		}
if ($TELEPORT_GOOD=='to_avalon')
		{
		$_SESSION['TELEPORT_GOOD']='avaloncity.oldbk.com';
		echo "<script>".(!is_array($_SESSION['vk'])?"top.":"parent.")."window.location='/teleport_redir.php'</script>";
		die();
		}
if ($TELEPORT_GOOD=='to_capital')
		{
		$_SESSION['TELEPORT_GOOD']='capitalcity.oldbk.com';
		echo "<script>".(!is_array($_SESSION['vk'])?"top.":"parent.")."window.location='/teleport_redir.php'</script>";
		die();
		}


}
function addch2all($text,$city=-1) {


			$ci=$city+1; //��� � ��������� ������


/// ��������� � ���� ���
$txt_to_file=":[".time()."]:[!sys2all!!]:[<font color=\"#CB0000\">".($text)."</font>]:[1]";
mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='{$ci}';");
}

function addch2levels($text,$minlevel=0,$maxlevel=0,$city=-1) {
$ci=$city+1; //��� � ��������� ������
$txt_to_file=":[".time()."]:[!levels-".$minlevel."-".$maxlevel."-"."!]:[<font color=\"#CB0000\">".($text)."</font>]:[1]";
mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='{$ci}';");
}

function addch ($text,$room=0,$city=-1) {
			global $user;
			if ($room==0) {
				$room = $user['room'];
			}

			if ($user)
			{
			$ci=$user[id_city]+1;
			}
			else
			{

			   $ci=$city+1;

			}

$txt_to_file=":[".time()."]:[!sys!!]:[".($text)."]:[".$room."]";

$room=-1; // TEST only by Fred
$q = mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='".$ci."' , `room`='{$room}' ;");
if ($q === FALSE) return FALSE;
return TRUE;

}
function addch_group ($text,$ids) {

		if (is_array($ids))
		{
		$ids=implode(":|:", $ids);
		}
		$ci=CITY_ID+1;

		$txt_to_file=":[".time()."]:[!group!:|:".$ids."]:[".($text)."]:[]";
		$q = mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='{$ci}' ;");
		if ($q === FALSE) return FALSE;
		return TRUE;

}

function get_item_fid($row)
 {
 $c[0]='cap';
 $c[1]='ava';
 $c[2]='ang';
 $out=$c[$row['idcity']].$row[id];

 return $out;
 }


function addchp ($text,$who,$room=0,$city=-1) {
			global $user;
			if ($room==0) {
				$room = $user['room'];
			}


			$city=$city+1;


			$txt_to_file=":[".time()."]:[{$who}]:[".($text)."]:[".$room."]";
			$room=-1; // TEST only by Fred
			$q = mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='".($city)."', `room`={$room} ;");
			if ($q !== FALSE) return true;
			return false;

}

function err($t) {
	echo '<font color=red>',$t,'</font>';
}


//������ �� �������
function settravmazn($id) {
	$user = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`level` FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
	if ($user['id'] == $id) {
		$time=rand(180,300);
		$trv=14;
		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','',".(time()+$time).",14,'0','0','0','0');");
		return $trv;
	}
	else {
		return false;
	}
}

//������ ���� 259200 =3���
function settravmazol($id) {
	$user = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`level` FROM `users` WHERE `id` = '{$id}' LIMIT 1;"));
	if ($user['id'] == $id) {
		$time=259200;
		$trv=14;
		mysql_query("UPDATE `users` SET  `sila`=`sila`-'50' WHERE `id` = '".$id."' LIMIT 1;");
		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','',".(time()+$time).",14,'50','0','0','0');");
		return $trv;
	}
	else {
		return false;
	}
}



//Added 3.05.2010 Auth Weathered
function get_chance ($persent)
{
	$mm = 1000000;
	return (mt_rand($mm, 100 * $mm) <= $persent*$mm);
}

// ������ ������
function settravma($id,$type,$time=86400) {

	global $user;

	if(($user['level'] < 4))
	{
		return false;
	}

	else {
		$travmalist = array ("�������� ���","���������� ������ �������","����������� ���","����������� ����","������� ����������","���������� ����","���������� ����","�������� ����","����� ��� ������","������������ ����������","������� <����� �����>","����������� �������","������� ��� <��������>","����������");
		$travmalist2 = array ("������� �����","����� <�������� ��������>","���������� ������ �������","���������� ���","����� ����","���������� ���","������������ �����������","������� �����","������������ ������","������ ���������","������� �����","������� ���� �����","����� ����","��������� �������");
		$travmalist3 = array ("�������� �����","������ ���������","�������� ���������","�������� ������� ����","�������� ������� <�������� ��������>","����� ����������","����������, �� ������������� ������","������� ���������� ������������","������������� �������� �������","������� ���","�������� ���������","�������� ������� �������","������� ������������","����� ������������","���������� ������� �������");

		$owntravma = mysql_fetch_array(mysql_query("SELECT `type`,`id`,`sila`,`lovk`,`inta` FROM `effects` WHERE `owner` = ".$id." AND (`type`=11 OR `type`=12 OR `type`=13) ORDER by `type` DESC LIMIT 1 ;"));

        if($owntravma['type']==11)
        {
            $owntravma['type']=12;
        }
        else
        if($owntravma['type']==12)
        {
            $owntravma['type']=13;
        }
        else
        if($owntravma['type']==13)
        {
            $owntravma['type']=14;
        }
        else
        {
            $owntravma['type']=$type;
        }

		switch($owntravma['type']) {
			case 11:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($user['level'] + $st);  break;
					case 2: $l=($user['level'] + $st);  break;
					case 3: $i=($user['level'] + $st);  break;
				}
				$trv = $travmalist2[mt_rand(0,count($travmalist2)-1)];
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",11,'".$s."','".$l."','".$i."','0');");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
				return $trv;
			break;

			case 12:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($user['level'] + $st)*2; break;
					case 2: $l=($user['level'] + $st)*2; break;
					case 3: $i=($user['level'] + $st)*2; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",12,'".$s."','".$l."','".$i."','0');");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
				return $trv;
			break;

			case 13:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($user['level'] + $st)*3; break;
					case 2: $l=($user['level'] + $st)*3; break;
					case 3: $i=($user['level'] + $st)*3; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				//$time = 60*60*mt_rand(25,26);
				//mysql_query("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",13,'".$s."','".$l."','".$i."','0');");
				//mysql_query("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$id."' LIMIT 1;");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
				return $trv;
			break;

			case 14:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($user['level'] + $st)*3; break;
					case 2: $l=($user['level'] + $st)*3; break;
					case 3: $i=($user['level'] + $st)*3; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				$time = 60*60*mt_rand(25,26);
				//mysql_query("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$id."','".$trv."',".(time()+$time).",14,'".$s."','".$l."','".$i."','0');");
				//mysql_query("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$id."' LIMIT 1;");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$id."' LIMIT 1;");
				return $trv;
			break;
		}
	}
}


// ������ ������
function settravmabyinfo($u,$type,$time=86400) {
	if(($u['level'] < 4)) {
		return false;
	} else {

		$travmalist = array ("�������� ���","���������� ������ �������","����������� ���","����������� ����","������� ����������","���������� ����","���������� ����","�������� ����","����� ��� ������","������������ ����������","������� <����� �����>","����������� �������","������� ��� <��������>","����������");
		$travmalist2 = array ("������� �����","����� <�������� ��������>","���������� ������ �������","���������� ���","����� ����","���������� ���","������������ �����������","������� �����","������������ ������","������ ���������","������� �����","������� ���� �����","����� ����","��������� �������");
		$travmalist3 = array ("�������� �����","������ ���������","�������� ���������","�������� ������� ����","�������� ������� <�������� ��������>","����� ����������","����������, �� ������������� ������","������� ���������� ������������","������������� �������� �������","������� ���","�������� ���������","�������� ������� �������","������� ������������","����� ������������","���������� ������� �������");

		$owntravma = mysql_fetch_array(mysql_query("SELECT `type`,`id`,`sila`,`lovk`,`inta` FROM `effects` WHERE `owner` = ".$u['id']." AND (`type`=11 OR `type`=12 OR `type`=13) ORDER by `type` DESC LIMIT 1 ;"));

        	if($owntravma['type']==11) {
			$owntravma['type'] = 12;
		} elseif($owntravma['type'] == 12) {
            		$owntravma['type'] = 13;
        	} elseif($owntravma['type'] == 13) {
			$owntravma['type'] = 14;
		} else {
            		$owntravma['type'] = $type;
		}

		switch($owntravma['type']) {
			case 11:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st);  break;
					case 2: $l=($u['level'] + $st);  break;
					case 3: $i=($u['level'] + $st);  break;
				}
				$trv = $travmalist2[mt_rand(0,count($travmalist2)-1)];
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",11,'".$s."','".$l."','".$i."','0');");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				return $trv;
			break;
			case 12:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st)*2; break;
					case 2: $l=($u['level'] + $st)*2; break;
					case 3: $i=($u['level'] + $st)*2; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",12,'".$s."','".$l."','".$i."','0');");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				return $trv;
			break;
			case 13:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st)*3; break;
					case 2: $l=($u['level'] + $st)*3; break;
					case 3: $i=($u['level'] + $st)*3; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",13,'".$s."','".$l."','".$i."','0');");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				return $trv;
			break;
			case 14:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st)*3; break;
					case 2: $l=($u['level'] + $st)*3; break;
					case 3: $i=($u['level'] + $st)*3; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				$time = 60*60*mt_rand(25,26);
				mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",14,'".$s."','".$l."','".$i."','0');");
				mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				return $trv;
			break;
		}
	}
}

function settravmabyinfotrz($u,$type,$time=86400) {
	if(($u['level'] < 4)) {
		return true;
	} else {
		$travmalist = array ("�������� ���","���������� ������ �������","����������� ���","����������� ����","������� ����������","���������� ����","���������� ����","�������� ����","����� ��� ������","������������ ����������","������� <����� �����>","����������� �������","������� ��� <��������>","����������");
		$travmalist2 = array ("������� �����","����� <�������� ��������>","���������� ������ �������","���������� ���","����� ����","���������� ���","������������ �����������","������� �����","������������ ������","������ ���������","������� �����","������� ���� �����","����� ����","��������� �������");
		$travmalist3 = array ("�������� �����","������ ���������","�������� ���������","�������� ������� ����","�������� ������� <�������� ��������>","����� ����������","����������, �� ������������� ������","������� ���������� ������������","������������� �������� �������","������� ���","�������� ���������","�������� ������� �������","������� ������������","����� ������������","���������� ������� �������");

		$q = mysql_query("SELECT `type`,`id`,`sila`,`lovk`,`inta` FROM `effects` WHERE `owner` = ".$u['id']." AND (`type`=11 OR `type`=12 OR `type`=13) ORDER by `type` DESC LIMIT 1 ;");
		if ($q === FALSE) return false;
		$owntravma = mysql_fetch_array($q);

        	if($owntravma['type']==11) {
			$owntravma['type'] = 12;
		} elseif($owntravma['type'] == 12) {
            		$owntravma['type'] = 13;
        	} elseif($owntravma['type'] == 13) {
			$owntravma['type'] = 14;
		} else {
            		$owntravma['type'] = $type;
		}

		switch($owntravma['type']) {
			case 11:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st);  break;
					case 2: $l=($u['level'] + $st);  break;
					case 3: $i=($u['level'] + $st);  break;
				}
				$trv = $travmalist2[mt_rand(0,count($travmalist2)-1)];
				$q = mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",11,'".$s."','".$l."','".$i."','0');");
				if ($q === FALSE) return false;
				$q = mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				if ($q === FALSE) return false;
				return true;
			break;
			case 12:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st)*2; break;
					case 2: $l=($u['level'] + $st)*2; break;
					case 3: $i=($u['level'] + $st)*2; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				$q = mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",12,'".$s."','".$l."','".$i."','0');");
				if ($q === FALSE) return false;
				$q = mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				if ($q === FALSE) return false;
				return true;
			break;
			case 13:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st)*3; break;
					case 2: $l=($u['level'] + $st)*3; break;
					case 3: $i=($u['level'] + $st)*3; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				$q = mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",13,'".$s."','".$l."','".$i."','0');");
				if ($q === FALSE) return false;
				$q = mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				if ($q === FALSE) return false;
				return true;
			break;
			case 14:
				$st=mt_rand(0,2);
				$zz = mt_rand(1,3); $s=0;$l=0;$i=0;
				switch($zz){
					case 1: $s=($u['level'] + $st)*3; break;
					case 2: $l=($u['level'] + $st)*3; break;
					case 3: $i=($u['level'] + $st)*3; break;
				}
				$trv = $travmalist3[mt_rand(0,count($travmalist3)-1)];
				$time = 60*60*mt_rand(25,26);
				$q = mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$u['id']."','".$trv."',".(time()+$time).",14,'".$s."','".$l."','".$i."','0');");
				if ($q === FALSE) return false;
				$q = mysql_query("UPDATE `users` SET `sila`=`sila`-'".$s."', `lovk`=`lovk`-'".$l."', `inta`=`inta`-'".$i."' WHERE `id` = '".$u['id']."' LIMIT 1;");
				if ($q === FALSE) return false;
				return true;
			break;
		}
	}
}


// ������� ������
function deltravma($id) {
	$owntravmadb = mysql_query("SELECT `type`,`id`,`sila`,`lovk`,`inta`,`owner` FROM `effects` WHERE `id` = ".$id." AND (type=11 OR type=12 OR type=13 OR type=14);");
	while ($owntravma = mysql_fetch_array($owntravmadb)) {
		mysql_query("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
		mysql_query("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$owntravma['owner']."' LIMIT 1;");
	}
}
// ���������� ������
function showtrawma() {
}

// telegrafick
function telegraph($to,$text,$sp=0) {
 global $user;
 //$sp=1  - ������ ��� �������� �������� �� ����� .

 $ur = check_users_city_datal($to);
 //$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$ur['id']}' LIMIT 1;"));

 if($user['id']==3 || $user['id']==4 || $user['id']==6)
 {
  $txt='<font color=darkblue>���� ����� �� ������ <span oncontextmenu=OpenMenu()>'.$user['login'].'</span></font>: ';
 }
 else
 {
  if($sp==1){
   $txt='<b><font color=red>����-��������:</font></b> ';
  }
  $txt.='<font color=darkblue>��������� �� ��������� �� </font><span oncontextmenu=OpenMenu()>'.$user['login'].'</span>: ';}


  if(!$ur) {
     echo "<font color=red><b>�������� �� ������.</b></font>";
  }

  elseif($ur[odate] >= (time()-60)  ){
   if($sp==0){echo "<font color=red><b>�������� ������� ���� ���������</b></font>";}
   addchp (' ('.date("Y.m.d H:i").') '.$txt.$text.' ','{[]}'.$ur['login'].'{[]}',-1,$ur['id_city']);
  }
  else
  {
   // ���� � ���
  if($sp==0){echo "<font color=red><b>��������� ����� ����������, ��� ������ �������� ����� on-line.</b></font>";}
  $str="INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$ur['id']."','','".'['.date("d.m.Y H:i").'] '.$txt.$text.'  '."');";
  mysql_query($str);
  //echo 'HERE' . $str;
  }


}
// telegrafick

// telegrafick-NEW
function telegraph_new($telo,$text,$sp=0,$deltime = 0) {
 global $user;
 if ($deltime == 0) $deltime = time()+2678400;

 $text = str_replace(']:[','] : [',$text);
 //$sp=1  - ������ ��� �������� ��������  .
 if($user['id']==3 || $user['id']==4 || $user['id']==6)
 {
     $txt='<font color=darkblue>���� ����� �� ������ <span oncontextmenu=OpenMenu()>'.$user['login'].'</span></font>: ';
 }
 else
 {
	        if($sp==1)
     	        {
		     $txt='<b><font color=red>����-��������:</font></b> ';
	        }
		if($sp==1 || $sp==0)
		{
		     $txt.='<font color=darkblue>��������� �� ��������� �� </font><span oncontextmenu=OpenMenu()>'.($user['login']).'</span>: ';
		}
		if($sp==2)
		{
			$txt='<b><font color=red>�����:</font></b> ';
		}

 }

	 if ($telo[id_city]==2)
	 {
	 		$telo = mysql_fetch_array(mysql_query("SELECT * FROM angels.`users` WHERE `id` = '{$telo[id]}' LIMIT 1;"));
	 }
	else
	 if ($telo[id_city]==1)
	 {
	 		$telo = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE `id` = '{$telo[id]}' LIMIT 1;"));
	 }
	 else
	 {
	 		$telo = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '{$telo[id]}' LIMIT 1;"));
	 }


 if($telo[odate]>=(time()-60))
    {
    	if($sp==0){ echo "<font color=red><b>�������� ������� ���� ���������</b></font>";}
    	addchp (' ('.date("Y.m.d H:i").') '.$txt.$text.'  ','{[]}'.$telo[login].'{[]}',-1,-1);
    }
  else
  {
   // ���� � ���
  	if($sp==0){echo "<font color=red><b>��������� ����� ����������, ��� ������ �������� ����� on-line.</b></font>";}
  	$str="INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`,`deltime`) values ('".$telo['id']."','','".'['.date("d.m.Y H:i").'] '.$txt.$text.'  '."','".$deltime."')";
  	mysql_query($str);

  }


}
// telegrafick

function telepost($to,$text) {
	global $user;
	$ur = mysql_fetch_array(mysql_query("select * from `users` WHERE `login` = '{$to}' LIMIT 1;"));
	//$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$ur['id']}' LIMIT 1;"));
	if(!$ur) {
		echo "<font color=red><b>�������� �� ������.</b></font>";
	}
	elseif($ur[odate] >= (time()-60) ) {
		addchp (' ['.date("Y.m.d H:i").'] '.$text.'  ','{[]}'.$to.'{[]}',$ur[room],$ur[id_city]);
	} else {
		// ���� � ���
		mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$ur['id']."','','".'['.date("d.m.Y H:i").'] '.$text.'  '."');");
	}
}

function telepost_new($to_telo,$text) {
	global $user;

	if($to_telo[odate]>=(time()-60)){
		addchp ($text.'  ','{[]}'.$to_telo[login].'{[]}',$to_telo[room],$to_telo[id_city]);
	} else {
		// ���� � ���
		mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$to_telo['id']."','','".'['.date("d.m.Y H:i").'] '.$text.'  '."');");
	}


}

// telegrafick
function tele_check($to,$text) {
	global $user;
	$ur = mysql_fetch_array(mysql_query("select `id` from `users` WHERE `login` = '{$to}' LIMIT 1;"));
	//$us = mysql_fetch_array(mysql_query("select `id` from `online` WHERE `date` >= ".(time()-60)." AND `id` = '{$ur['id']}' LIMIT 1;"));
	if(!$ur) {
		echo "<font color=red><b>�������� �� ������.</b></font>";
	}
	elseif($ur[odate] >= (time()-60) ){
		addchp (' ('.date("Y.m.d H:i").') <font color=darkblue>��������� ���������� �� </font><span oncontextmenu=OpenMenu()>'.$user['login'].'</span>: '.$text.'  ','{[]}'.$to.'{[]}');
	} else {
		// ���� � ���
		mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$ur['id']."','','".'['.date("d.m.Y H:i").'] <font color=darkblue>��������� �� ��������� �� </font><span oncontextmenu=OpenMenu()>'.$user['login'].'</span>: '.$text.'  '."');");
	}
}

// telegrafick new
function tele_check_new($to_telo,$text) {
	global $user;

	if($to_telo[odate]>=(time()-60)){
		addchp (' ('.date("Y.m.d H:i").') <font color=darkblue>��������� ���������� �� </font><span oncontextmenu=OpenMenu()>'.$user['login'].'</span>: '.$text.'  ','{[]}'.$to_telo[login].'{[]}',$to_telo[room],$to_telo[id_city]);
	} else {
		// ���� � ���
		mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$to_telo['id']."','','".'['.date("d.m.Y H:i").'] <font color=darkblue>��������� �� ��������� �� </font><span oncontextmenu=OpenMenu()>'.$user['login'].'</span>: '.$text.'  '."');");
	}
}


function get_meshok(){
	global $user;
	$gsum=0;

	/*
	������ �� ����. ���.
	*/

	//��������� �������� ������ + � ������� �� �������-��������� � �������� ����� ������ � ����
	if (($user['in_tower']==0) and ($user['ruines']==0) )
		{
		$add_bonus[1]=50;
		$add_bonus[2]=250;
		$add_bonus[3]=500;
		$add=$add_bonus[$user['prem']];
		//����� �� �������� ������ ����� ���� ����

		$add+=getcheck_mymass($user);
		}
		else
		{
		$add=0;
		}

	$gsum+=$add;
	$q = mysql_query("SELECT IFNULL(sum(`gmeshok`),0) as gmeshok , setsale, bs_owner FROM oldbk.inventory WHERE `owner` = '{$user['id']}'   AND gmeshok>0 GROUP by setsale,bs_owner");
	while ($row = mysql_fetch_array($q))
			{
			if (($user['in_tower'] == $row['bs_owner']) AND   ($row['setsale'] ==0 ) )
				{
				$gsum+=$row['gmeshok'];
				}
			}
	return ($user['sila']*4+$gsum);
	//	return ('30000');
}
function get_meshok_to($to){
	global $user;
	$gsum=0;

				/* ������ ������  $d = mysql_fetch_array(mysql_query("SELECT sum(`gmeshok`) FROM oldbk.`inventory` WHERE `owner` = '{$to}' AND bs_owner=".$user['in_tower']." AND  `setsale` = 0 AND `gmeshok`>0 ; ")); */

	$q=mysql_query("SELECT IFNULL(sum(`gmeshok`),0) as gmeshok , setsale, bs_owner FROM oldbk.inventory WHERE `owner` = '{$to}'   AND gmeshok>0 GROUP by setsale,bs_owner");
	while ($row = mysql_fetch_array($q))
		{
		if (($user['in_tower'] == $row['bs_owner']) AND   ($row['setsale'] ==0 ) )
			{
			$gsum+=$row['gmeshok'];
			}
		}

	$s = mysql_fetch_array(mysql_query("SELECT sila FROM `users` WHERE `id` = '{$to}' LIMIT 1 ; "));
//	return('30000');
	return ($s['sila']*4+$gsum);
}

function addlog($id,$log) {
$log=trim($log);
if ($log!='')
{
$log=$log."\n";
///new/////////////////
/*
	mysql_query('
		INSERT INTO battle_temp_log (id,btext) VALUES ('.$id.',"'.mysql_real_escape_string($log).'")
		ON DUPLICATE KEY UPDATE
			`btext` = CONCAT(btext,"'.mysql_real_escape_string($log).'")
		');
*/

	 $logdir=(int)($id/1000);

	$logdir="/www/data/combat_logs/".$logdir."000";




	if (!is_dir($logdir) )
	{
	mkdir($logdir);
	}
	$fp = fopen ($logdir."/battle".$id.".txt","a"); //��������
	flock ($fp,LOCK_EX); //���������� �����
	fputs($fp , $log); //������ � ������
	fflush ($fp); //�������� ��������� ������ � ������ � ����
	flock ($fp,LOCK_UN); //������ ����������
	fclose ($fp); //��������
}
///////
}


//������� � ��������� � ����������� �� ������
function turnir_room($user,$r)
{
//210 240 270
if (($r>=210) and ($r<239))
	{
	$troom=210+$user[level];
	}
else if (($r>=240) and ($r<269))
	{
	$troom=240+$user[level];
	}
else if (($r>=270) and ($r<299))
	{
	$troom=270+$user[level];
	}
else
  {
   $troom=200;//���������
  }

return $troom;
}

function users_in_battle($battle)
{
 $count = mysql_fetch_array(mysql_query("select count(id) as kol , battle from users where battle='{$battle}' ;"));
 if ($count)
   {
   return $count[kol];
   }
   else
   {
   return false;
   }
}

function get_delay_time($t)
{
$ds=(int)($t/1440);
 if ($ds>0)
 	{
 	$out=$ds." ��.";
 	}
$t=$t-($ds*1440);

$ms=(int)($t);

 if ($ms>0)
 	{
 	$out.=$ms." ���.";
 	}

return $out;
}

function outtimeb($eff)
		{
	$tt=time();
	$time_still=$tt-$eff;

	$tmp = floor($time_still/2592000);
	$id=0; // ������� �������� ����������
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." ���. ";}
		$time_still = $time_still-$tmp*2592000;
	}
	$tmp = floor($time_still/604800);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." ���. ";}
		$time_still = $time_still-$tmp*604800;
	}
	$tmp = floor($time_still/86400);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." ��. ";}
		$time_still = $time_still-$tmp*86400;
	}
	$tmp = floor($time_still/3600);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." �. ";}
		$time_still = $time_still-$tmp*3600;
	}
	$tmp = floor($time_still/60);
	if ($tmp > 0) {
		$id++;
		if ($id<3) {$out .= $tmp." ���. ";}
	}
	if ($out=='')  {$out='������ ������';}
	return $out;
		}


function getmaxmf($arr_mf)
{
if (($arr_mf[krita]>=$arr_mf[akrita]) and ($arr_mf[krita]>=$arr_mf[uvorota]) and ($arr_mf[krita]>=$arr_mf[auvorota]))
{
return "krita";
}
else
if (($arr_mf[akrita]>=$arr_mf[krita]) and ($arr_mf[akrita]>=$arr_mf[uvorota]) and ($arr_mf[akrita]>=$arr_mf[auvorota]))
{
return "akrita";
}
else
if (($arr_mf[uvorota]>=$arr_mf[krita]) and ($arr_mf[uvorota]>=$arr_mf[akrita]) and ($arr_mf[uvorota]>=$arr_mf[auvorota]))
{
return "uvorota";
}
else
{
return "auvorota";
}
}

function load_perevopl($telo)
{
if (($telo['hidden'] > 0) and ($telo['hiddenlog']!=''))
				{
				  $fake=explode(",",$telo['hiddenlog']);
					$telo['id'] = $fake[0];
					$telo['login'] = $fake[1];
					$telo['level'] = $fake[2];
					$telo['align'] = $fake[3];
					$telo['sex'] = $fake[4];
					$telo['klan'] = $fake[5];
				}

return $telo;
}


function GetOpRs() {
	$fn = "./cron/cron_op_result";
	$fp = fopen ($fn,"r"); //��������
	flock ($fp,LOCK_EX);
	$contents = fread($fp, filesize($fn));
	flock ($fp,LOCK_UN);
	fclose ($fp);
	return intval($contents);
}

function getalleff ($id) {
$eff = array();
$id=(int)($id);
 if ($id>0)
{
	$alleff = mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$id);

	$trav_count=0;

	while($ae = mysql_fetch_array($alleff))
	{

		if ($ae['type'] == 11)
		{
			$trav_count++;
		} else if ($ae['type'] == 12 || $ae['type'] == 13 || $ae['type'] == 14) {
			$trav_count+=3;
		}
	$eff[$ae['type']] = $ae;
	}

	if ($trav_count > 2) {
		$eff['owntravma'] = 1;
	}
}

return $eff;
}


function BNewHist($user) {
$andmore='';

	if (strpos($user['login'],'��������� (����') !== FALSE)
	{
	$user['login'] = '<i>'.$user['login'].'</i>';
	$user['align'] = 0;
	$user['level'] = "??";
	$user['klan'] = "";
	}
	else
	if ($user['hidden'] > 0 ) {
		if ($user[hiddenlog] != '') {
			$user= load_perevopl($user);
		} else {
			$user['id'] = $user['hidden'];
			$user['login'] = '<i>���������</i>';
			$user['align'] = 0;
			$user['level'] = "??";
			$user['klan'] = "";
		}
	}
	return $user['id'].'|'.$user['level'].'|'.$user['align'].'|'.$user['klan'].'|'.$user['login'].'#';
}

function BNewRender($row,$maxp=0) {
	if (strpos($row,'#') !== FALSE)  {
		if (strpos($row,'|=|') !== FALSE) {
			$otr = explode("|=|",$row);
			$t = explode("#",$otr[1]);
			$ret ="<b>".$otr[0]."</b> ";
		} else {
			$t = explode("#",$row);
			$ret = "";
		}
    $pcnt=0;
		while(list($k,$v) = each($t)) {
			if (empty($v)) continue;
      $pcnt++;

			$v = explode("|",$v);
			$ret .= '<img src="http://i.oldbk.com/i/align_'.$v[2].'.gif">';
			if (!empty($v[3])) {
				$ret .= '<img title="'.$v[3].'" src="http://i.oldbk.com/i/klan/'.$v[3].'.gif">';
			}
			$ret .= '<B>'.$v[4].'</B> ['.$v[1].']<a href=inf.php?'.$v[0].' target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � '.$v[4].'"></a>, ';
      if (($pcnt>=$maxp) and ($maxp>0))
            {
            $andmore=' � �.�.';
            break;
            }
		}

		if (strlen($ret)) {
			$ret = substr($ret,0,strlen($ret)-2);
		}
    $ret.=$andmore;
		return $ret;
	} else {
		return $row;
	}
}

function BNewRender_one_rand($row) {
	if (strpos($row,'#') !== FALSE)
	{
		if (strpos($row,'|=|') !== FALSE)
		{
		$otr = explode("|=|",$row);
		$t = explode("#",$otr[1]);
		$ret ="<b>".$otr[0]."</b> ";
		}
		else
		{
		$t = explode("#",$row);
		$ret = "";
		}

		$rnd=(int)(mt_rand(1,count($t)));
		$i=0;
		while(list($k,$v) = each($t))
		{
			if (empty($v)) continue;
			if ($i==$rnd) continue;
			$v = explode("|",$v);
			$ret = '<img src="http://i.oldbk.com/i/align_'.$v[2].'.gif">';
			if (!empty($v[3])) {
				$ret .= '<img title="'.$v[3].'" src="http://i.oldbk.com/i/klan/'.$v[3].'.gif">';
			}
			$ret .= '<B>'.$v[4].'</B> ['.$v[1].']<a href=inf.php?'.$v[0].' target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT="���. � '.$v[4].'"></a>';

		$i++;
		}
		return $ret;
	}
return "";
}


function render_img_html($row)
{
$ehtml=str_replace('.gif','',$row['img_url']);
			        $razdel=array(1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors", 24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun", 61=>'eda', 62=>'res' , 27=>'cloack', 28=>'rubashka', 52=>'runs');
			        $row['otdel']==''?$xx=$row['razdel']:$xx=$row['otdel'];
			        if($razdel[$xx]=='')
			            {
			            	$vau4=array(100005,100015,100020,100025,100040,100100,100200,100300);
			            	 if (in_array($row['prototype'],$vau4))
            	 				{
				         	 	$razdel[$xx]='vaucher';
			            	 	}
            	 				else
			            	 	{
	            				$razdel[$xx]='predmeti/'.$ehtml;
				            	}
				    }
			            else
			            {
            				$razdel[$xx]=$razdel[$xx]."/".$ehtml;
		        	    }

				//����� �� ����
				if ($row[art_param]!='')
				{
					if ($row[arsenal_klan]!='')
					{
					//��������
					$razdel[$xx]='art_clan';
					}
					else if ($row[sowner]!=0)
					{
					//������
					$razdel[$xx]='art_pers';
					}

				}
				$ehtml=$razdel[$xx].'.html';
return $ehtml;
}

function give_count($teloid,$kol=1)
{
return true; // ��������� �������� ������ http://tickets.oldbk.com/issue/oldbk-415

	if (($teloid>0) and ($kol>0))
		{
		//������ ������� ���.������� - ��� ��� ���� � ������� ���� � � ������ ������ ��� ��� ������
		////��������� ���� ���� ���� ��� ������� ������
		mysql_query("INSERT INTO `oldbk`.`users_perevod` SET `owner`='{$teloid}',`val`='0', lday=CURDATE()  ON DUPLICATE KEY UPDATE val=IF (lday!=CURDATE(),0, val),  lday=IF(lday!=CURDATE(),CURDATE(),lday)  ");
		//������ ������ ������
		mysql_query("UPDATE `oldbk`.`users_perevod` SET val=val+'{$kol}' where `owner`='{$teloid}'  and (lim=-1 OR (val+'{$kol}'<=lim) )  limit 1; ");
		if(mysql_affected_rows()>0)
			{
			//���� ������ ������ - ������ ��� ����  � ����������� ���� ���������
			return true;
			}
		}
return false;
}

function  test_give_count($t1id,$t2id=0,$kol=1)
{
return false;	//// ��������� �������� ������ http://tickets.oldbk.com/issue/oldbk-415
//������ ������ ������ - ���� ����� ������������ ������ �� ������� � ������ �� ����, � ������ ����� ������
	if ( ($t1id>0) AND ($kol>0))
	{
	$own=" owner='{$t1id}'  ";

	////��������� ���� ���� ���� ��� ������� ������
	mysql_query("INSERT INTO `oldbk`.`users_perevod` SET `owner`='{$t1id}',`val`='0', lday=CURDATE()  ON DUPLICATE KEY UPDATE val=IF (lday!=CURDATE(),0, val),  lday=IF(lday!=CURDATE(),CURDATE(),lday)  ");

	if ($t2id>0)
			{
			$own.=" OR owner='{$t2id}'  ";
			////��������� ���� ���� ���� ��� ������� ������
			mysql_query("INSERT INTO `oldbk`.`users_perevod` SET `owner`='{$t2id}',`val`='0', lday=CURDATE()  ON DUPLICATE KEY UPDATE val=IF (lday!=CURDATE(),0, val),  lday=IF(lday!=CURDATE(),CURDATE(),lday)  ");
			}

	$own="(".$own.")";

	$list = mysql_query("select * from oldbk.users_perevod where ".$own." and lday=CURDATE() and lim>0 and val+'{$kol}'>lim");
	if (mysql_num_rows($list) >0)
		{
		$out=array();
		 while($row = mysql_fetch_array($list))
		 {
		 	$out[]=$row['owner'];
	  	 }
	  	return $out;
		}
	}
return false;
}

function test_lic_med($telo)
{
if (($telo['klan']=='radminion') OR ($telo['klan']=='Adminion') )
	{
	return true;
	}
//�������� �� �������� ������
$get_eff=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$telo['id']}' and type=40000;"));
if ($get_eff['id']>0)
	{
	return true;
	}
return false;
}

function test_lic_mag($telo)
{
//�������� �� �������� ������
$get_eff=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$telo['id']}' and type=50000;"));
if ($get_eff['id']>0)
	{
	return true;
	}
return false;
}

function olditemdress($item,$telo)
{
		$candress=true;
		if (($item['bs_owner']==0) and ($telo['ruines']==0) and ($item['labonly']==0) and ($item['prototype']!=55510000)  )
		{
		$ups_types=array(1,2,3,4,5,8,9,10,11);
		$ebarr=array(128,17,149,148);
		if ((strpos($item['name'], '[') == true) AND (in_array($item['prototype'],$ebarr) ) )
		{
		$candress=false;
		}
		else
		if ((strpos($item['name'], '[') == true) AND ($item['art_param']!='') )
		{//�� ����� ������:
		$candress=false;
		}
		elseif ((strpos($item['name'], '[') == true) AND (($item['type']==28) OR $item['prototype']==100028 OR $item['prototype']==100029 OR $item['prototype']==173173 OR $item['prototype']==2003 OR $item['prototype']==195195) )
		{
		//�� ����� ������� ���� �������:
		$candress=false;
		}
		elseif ( (strpos($item['name'], '[') == true) AND (in_array($item['type'],$ups_types)) AND $item['ab_mf']==0  AND $item['ab_bron']==0  AND $item['ab_uron']==0   ) // �� ���� ����
		{
		//�� �������
		$candress=false;
		}
		}
return $candress;
}


function cancel_exchange_all($owner)
{
//������� ����� � ����� ���� ���� ����  �� ������
$test=mysql_fetch_assoc(mysql_query("SELECT * from  oldbk.exchange where owner='{$owner}' limit 1"));
if ($test['id']>0)
	{
			mysql_query('START TRANSACTION') or die();
			$q=mysql_query("SELECT * from  oldbk.exchange where owner='{$owner}' FOR UPDATE");
			while($row = mysql_fetch_assoc($q)  )
			{
			//������� ����� � ����
			mysql_query("DELETE from oldbk.exchange where id='{$row['id']}' ");
			mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '{$row['summ']}' WHERE `id`= '{$row['bankid']}' and owner='{$owner}' ");
			//  ����� � ������� �����
			mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','����-������ �������  �� �����: <b>{$row['summ']} ���.</b>','{$row['bankid']}');");
			//����� � ��� ��������� �������
			mysql_query("UPDATE `oldbk`.`exchange_log` SET `sellekr`=`sellekr`-{$row['summ']}  WHERE `owner`={$owner} ");
			}
			mysql_query('COMMIT') or die();
	}
}


function DropBonusItem($proto,$telo,$pres,$info,$goden_days=0,$count=1,$getfrom=20,$sysm=false,$notsell=false,$delotype=699,$shop='shop',$goden_time=false,$battleid=false)
{


	$q = mysql_query("SELECT * FROM oldbk.{$shop} WHERE id = '{$proto}' ");
	$dress = mysql_fetch_assoc($q);
	if ($dress['id']>0)
	{


				//�������� �� ������� ��� ���������
				if ( ($dress['id']>=111001  and $dress['id']<=111009) OR ($dress['id']>=112001  and $dress['id']<=112007) OR ($dress['id']>=113001  and $dress['id']<=113008) OR ($dress['id']>=114001  and $dress['id']<=114008) )
				{
				//���� ������ ������ ����� , �� ��������� ������� �� � ��������
				//����� �������� �  addfunction.php->function drop_card($user)

						$test_count = mysql_fetch_assoc(mysql_query("SELECT count(id) as k FROM oldbk.`inventory`  WHERE owner='{$telo['id']}' and  prototype = '{$dress['id']}'  "));

					if ($test_count ['k']>=10)
						{
						return false;
						}

				}



	if ($pres=='') { $pres='�����'; }

	$dress['getfrom']=$getfrom;
	$dress['cost'] = 0;
	$dress['ecost'] = 0;
	 if ($goden_days>0) {$dress['goden']=$goden_days;}
	$dress['dategoden']=(($dress['goden'])?($dress['goden']*24*60*60+time()):"");

	 if ($goden_time>0) // ���� ����� �������� ����� ���������
	 	{
		$dress['dategoden'] = $goden_time;
		$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}
		}



	 if ($notsell==true) {$dress['notsell']=1;}



					for($i=1;$i<=$count;$i++)
						{
							if (mysql_query("INSERT INTO oldbk.`inventory`
							(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
								`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
								`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`letter`,`ekr_flag`,`img_big`,`rareitem`,`getfrom`,`notsell`
							)
							VALUES
							('{$dress['id']}','{$telo['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
							'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$pres}','0','0','{$dress['group']}','{$telo['id_city']}','{$dress['letter']}','{$dress['ekr_flag']}','{$dress['img_big']}','{$dress['rareitem']}','{$dress['getfrom']}','{$dress['notsell']}' ) ;") )
						     {
						     	$aitems[]="cap".mysql_insert_id();
						     }
						}


							if (count($aitems)>0)
							{
						     		//add to new delo
								$rec['owner']=$telo['id'];
								$rec['owner_login']=$telo['login'];
								$rec['owner_balans_do']=$telo['money'];
								$rec['owner_balans_posle']=$telo['money'];
								$rec['target']=0;

								$rec['type']=$delotype;//������� !!!699 default

								if ($getfrom==37)
									{
									$rec['target_login']='���������';
									}
									elseif ($rec['type']==60)
									{
									$rec['target_login']='���';
									}
									else
									{
									$rec['target_login']='������';
									}


								if (count($aitems)==1)
								{
									$rec['item_id']=$aitems[0];
								}
								else
								{
									$rec['aitem_id']=implode(",",$aitems);
								}
								$rec['item_name']=$dress['name'];
								$rec['item_count']=$count;
								$rec['item_type']=$dress['type'];
								$rec['item_cost']=$dress['cost'];
								$rec['item_ecost']=$dress['ecost'];
								$rec['item_dur']=$dress['duration'];
								$rec['item_maxdur']=$dress['maxdur'];
								if ($battleid>0)
									{
									$rec['battle']=$battleid;
									}
									else
									{
									$rec['battle']=$telo['battle'];
									}
								$rec['add_info']=$info;

								add_to_new_delo($rec);
							}

						if ($sysm==true)
							{
					   		addchp ('<font color=red>��������!</font> �� ��������: <b>'.$dress['name'].'</b> '.$count.'��. ','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);
					   		}

				  	   	return "<b>�".link_for_item($dress)."�</b> ".$count." ��.";
	}

return false;
}

//����������� �������������� �������
include "addfunction_umk.php";
include "questfunction.php";


function close_tags_new($content)
    {
        $position = 0;
        $open_tags = array();
        //���� ��� �������������
        $ignored_tags = array('br', 'hr', 'img');

        while (($position = strpos($content, '<', $position)) !== FALSE)
        {
            //�������� ��� ���� �� ��������
            if (preg_match("|^<(/?)([a-z\d]+)\b[^>]*>|i", substr($content, $position), $match))
            {
                $tag = strtolower($match[2]);
                //���������� ��� ��������� ����
                if (in_array($tag, $ignored_tags) == FALSE)
                {
                    //��� ������
                    if (isset($match[1]) AND $match[1] == '')
                    {
                        if (isset($open_tags[$tag]))
                            $open_tags[$tag]++;
                        else
                            $open_tags[$tag] = 1;

                    }
                    //��� ������
                    if (isset($match[1]) AND $match[1] == '/')
                    {

                        if ((isset($open_tags[$tag])) and ($open_tags[$tag]>0) )
                            $open_tags[$tag]--;

                    }
                }
                $position += strlen($match[0]);
            }
            else
                $position++;
        }
        //��������� ��� ����
        foreach ($open_tags as $tag => $count_not_closed)
        {
            $content .= str_repeat("</{$tag}>", $count_not_closed);
        }

        return $content;
    }




function addchsys ($text,$room=0,$city=-1) {
	$city=$city+1;

	$txt_to_file=":[".time()."]:[!sysjs!]:[".($text)."]:[".$room."]";
	$room = -1;
	$q = mysql_query("INSERT INTO `oldbk`.`chat` SET `text`='".mysql_real_escape_string($txt_to_file)."',`city`='".($city)."', `room`={$room} ;");
	if ($q !== FALSE) return true;
	return false;
}


function declOfNum($number, $titles)
	{
	    $cases = array (2, 0, 1, 1, 1, 2);
	    return "<b>".$number."</b> ".$titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
	}


function save_otime_to_file_2($text)
	{
	$fp = fopen ("/www/cache/locks/ltime.txt","a"); //��������
	flock ($fp,LOCK_EX); //���������� �����
	fputs($fp , $text."\n"); //������ � ������
	fflush ($fp); //�������� ��������� ������ � ������ � ����
	flock ($fp,LOCK_UN); //������ ����������
	fclose ($fp); //��������
	}

function save_gruppovuha()
{
global $user;

	$get_checked_setups=unserialize($user['gruppovuha']);
	$get_checked_setups[0]=(((int)$_POST['rzd0']>0)?"1":"0");
	$get_checked_setups[1]=(((int)$_POST['rzd1']>0)?"1":"0");
	$get_checked_setups[2]=(((int)$_POST['rzd2']>0)?"1":"0");
	$get_checked_setups[3]=(((int)$_POST['rzd3']>0)?"1":"0");
	$get_checked_setups[4]=(((int)$_POST['rzd4']>0)?"1":"0");
	$get_checked_setups[5]=(((int)$_POST['rzd5']>0)?"1":"0");

	//6-�������� ���� ��������� IP ����� � ���� ��������!
	//7-�������������� ���� IP �� ����� ����! (�������������)
	//8 ������� ���� ����������

	if (isset($_SESSION['gruppovuha'][8]))
			{
			$get_checked_setups[8]=$_SESSION['gruppovuha'][8];
			}

	$_SESSION['gruppovuha']=$get_checked_setups;
	$save_checked_setups=serialize($get_checked_setups);
//	$user['gruppovuha']=$save_checked_setups;
	mysql_query("UPDATE users SET gruppovuha ='{$save_checked_setups}' WHERE id='{$user['id']}' ");
}


function load_hidden_items($ib=2) //$ib 1- ����� �� ����� ������ , 0- ����� �� ����� ���������  + ����������� , ������(2) - ������� ��������� ; 3- ��������� �� ������� give.php
{
	global $user;

	$_GET['prototype'] = intval($_GET['prototype']);
	$_GET['id'] = intval($_GET['id']);
	$_GET['otdel'] = intval($_GET['otdel']);
	$isnaem = false;
	$naem = false;

	if ($ib==0) {
		//�� ����� ��������� � �������������

		if($_GET['otdel'] == 7 || $_GET['otdel'] == 71 || $_GET['otdel'] == 72 || $_GET['otdel'] == 73)  {
			$q = mysql_query('SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM inventory WHERE `owner` = "'.$user['id'].'"  AND  present != "�������� �����" and present != "��������� �����"  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `labonly`=0 AND (cost>0 OR ecost>0 OR repcost>0)   AND `setsale`=0 and dategoden=0 and arsenal_klan="" and (otdel IN (7,71,72,73)  OR prototype = '.$_GET['prototype'].' )   AND id != '.$_GET['id'].' AND dressed = 0  ORDER BY `dategoden2` ASC, `update` DESC');
		} else 	{
			$q = mysql_query('SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM inventory WHERE  `owner` = "'.$user['id'].'"  AND  present != "�������� �����" and present != "��������� �����"  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `labonly`=0 AND (cost>0 OR ecost>0 OR repcost>0)   AND `setsale`=0 and dategoden=0 and arsenal_klan="" and prototype = '.$_GET['prototype'].' AND id != '.$_GET['id'].' AND dressed = 0 ORDER BY `dategoden2` ASC, `update` DESC');
		}
	} elseif ($ib==1) {
		// �� ������� �����

		if($_GET['otdel'] == 7 || $_GET['otdel'] == 71 || $_GET['otdel'] == 72 || $_GET['otdel'] == 73) {
			$q = mysql_query('SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM inventory WHERE owner = "488"  AND arsenal_owner="'.$user[id].'" and (otdel IN (7,71,72,73)  OR prototype = '.$_GET['prototype'].' )  AND id != '.$_GET['id'].'  ORDER BY `dategoden2` ASC, `update` DESC');
		} else 	{
			$q = mysql_query('SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM inventory WHERE owner = "488"  AND arsenal_owner="'.$user[id].'" and prototype = '.$_GET['prototype'].' AND id != '.$_GET['id'].'  ORDER BY `dategoden2` ASC, `update` DESC');
		}

	} elseif ($ib==2) {
		$q = mysql_query('SELECT * FROM users_clons WHERE owner = '.$user['id'].' and naem_status = 1');

		if(mysql_num_rows($q)) {
			$naem = mysql_fetch_assoc($q);
			$isnaem = true;
		}


		if($_GET['otdel'] == 7 || $_GET['otdel'] == 71 || $_GET['otdel'] == 72 || $_GET['otdel'] == 73)  {
			$q = mysql_query('SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM inventory WHERE owner = '.$_SESSION['uid'].' and (otdel IN (7,71,72,73)  OR prototype = '.$_GET['prototype'].' )   AND bs_owner = '.$user['in_tower'].' AND id != '.$_GET['id'].' AND dressed = 0 AND `setsale` = 0 ORDER BY `dategoden2` ASC, `update` DESC');
		} else {
			if ($isnaem && isset($_SESSION['naeminv']) && $_SESSION['naeminv'] > 0) {
				$q = mysql_query('SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM inventory WHERE owner = '.$_SESSION['uid'].' and prototype = '.$_GET['prototype'].' AND bs_owner = '.$user['in_tower'].' AND id != '.$_GET['id'].' AND dressed = 0 AND naem = '.$naem['naem_id'].' AND `setsale` = 0 ORDER BY `dategoden2` ASC, `update` DESC');
			} else {
				$q = mysql_query('SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM inventory WHERE owner = '.$_SESSION['uid'].' and prototype = '.$_GET['prototype'].' AND bs_owner = '.$user['in_tower'].' AND id != '.$_GET['id'].' AND dressed = 0 AND `setsale` = 0 ORDER BY `dategoden2` ASC, `update` DESC');
			}
		}

	} elseif ($ib==3) {
		$q = mysql_query("SELECT * FROM oldbk.`inventory` USE INDEX(owner_4) WHERE `owner` = '{$_SESSION['uid']}' and prototype = ".(int)$_GET['prototype']." AND `dressed` = 0 AND `setsale` = 0  AND id != ".(int)$_GET['id']." AND `present` = '' AND `bs_owner` ='".$user['in_tower']."' ORDER by `update` DESC; ");
	}

	$ret = "";
	$userold = $user;

	if (mysql_num_rows($q) > 0) {
		$ret .= "<table border=2  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
		while($row = mysql_fetch_assoc($q)) {
			if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }


			if ($ib==0) {
				$row['chk_arsenal']=77;
			} elseif ($ib==1) {
				$row['chk_arsenal']=66;

			}
			//if ($isnaem)
			if ($isnaem && isset($_SESSION['naeminv']) && $_SESSION['naeminv'] > 0)
			{
				$user = $naem;
				$ret .= showitem($row,0,false,$color,'',0,0,1);
				$user = $userold;
			} else {
				$ret .= showitem($row,0,false,$color,'',0,0,1);
			}
		}
		$ret .= "</table>";
	} else {
		$ret = '�����';
	}
	echo $ret;
	die();
}



function GetUserProfLevels($telo) {

if ( ($telo['in_tower']==0) AND  ($telo['ruines']==0) )
{
	$id=$telo['id'];
	$q = mysql_query('SELECT * FROM oldbk.users_craft WHERE owner = '.$id);
	if ($q === false) return false;
	if (mysql_num_rows($q) > 0)
		{
		$prof = mysql_fetch_assoc($q);
		return $prof;
		}
}

return false;
}

function makeClickableLinks($s) {
	return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $s);
}


function getmymassa($user) {
	$my_massa=0;
	$q = mysql_query("SELECT IFNULL(sum(`massa`),0) as massa , setsale, bs_owner, dressed  FROM oldbk.inventory WHERE `owner` = '{$user['id']}'   GROUP by setsale,bs_owner,dressed ");
	while ($row = mysql_fetch_array($q)) {
		if (($user['in_tower'] == $row['bs_owner']) AND   ($row['setsale'] ==0 )  AND   ($row['dressed'] ==0)) {
			$my_massa+=$row['massa'];
		}
	}
	return $my_massa;
}



function chck_items_prem_classes ($full=false) {
//��� ������������ ���� �������
	global $user, $mysql;

	$ch_al=$user['align']; if(($user['align']>=1.3) AND ($user['align']<1.4)) { $ch_al=6; }
	if ($user['klan']=='pal') { $ch_al=6; }
	$isql="SELECT * FROM oldbk.inventory WHERE dressed=1 and owner='{$user[id]}' AND type!=12 AND
		(
		nsila > {$user[sila]} OR nlovk > {$user[lovk]} OR ninta > {$user[inta]} OR nvinos > {$user[vinos]} OR
		nintel > {$user[intel]} OR nmudra > {$user[mudra]} OR nlevel > {$user[level]} OR
		((nalign != '".((int)$ch_al)."' ) AND (nalign != 0)) OR nnoj > {$user[noj]} OR ntopor > {$user[topor]} OR
		ndubina > {$user[dubina]} OR nmech > {$user[mec]} OR nfire > {$user[mfire]} OR
		nwater > {$user[mwater]}  OR nair > {$user[mair]} OR nearth > {$user[mearth]} OR
		nlight > {$user[mlight]} OR ngray > {$user[mgray]} OR ndark > {$user[mdark]} OR (nclass != {$user[uclass]} and nclass>0)  ) GROUP BY prototype ;
	";
//echo $isql ;
 	$items= mysql_query($isql) or die();
	$kom_it=mysql_num_rows($items);
	if ($kom_it>0) {
		$SVIT='';
		 //���� ����� ���� ��� ��������
		while ($arrit= mysql_fetch_array($items)) {
			if ($arrit[nsila] >  $user[sila]) { if ($dsila<($arrit[nsila]-$user[sila])) { $dsila=($arrit[nsila]-$user[sila]); $N_sila='����:'.$dsila.','; } }
			if ($arrit[nlovk] >  $user[lovk]) { if ($dlovk<($arrit[nlovk]-$user[lovk])) { $dlovk=($arrit[nlovk]-$user[lovk]); $N_lovk=' ��������:'.$dlovk.',';} }
			if ($arrit[ninta] >  $user[inta]) { if ($dinta<($arrit[ninta]-$user[inta])) { $dinta=($arrit[ninta]-$user[inta]); $N_inta=' ��������:'.$dinta.',';} }
			if ($arrit[nvinos] >  $user[vinos]){ if ($dvinos<($arrit[nvinos]-$user[vinos])) { $dvinos=($arrit[nvinos]-$user[vinos]); $N_vinos=' ������������:'.$dvinos.',';} }
			if ($arrit[nintel] >  $user[intel]){ if ($dnintel<($arrit[nintel]-$user[intel])) { $dnintel=($arrit[nintel]-$user[intel]); $N_intel=' ���������:'.$dnintel.',';}  }
			if ($arrit[nmudra] >  $user[mudra]) {  if ($dmudra<($arrit[nmudra]-$user[mudra])) { $dmudra=($arrit[nmudra]-$user[mudra]);  $N_mudra=' ��������:'.$dmudra.',';} }
			if ($arrit[nlevel] >  $user[level]){  if ($dlevel<($arrit[nlevel]-$user[level])) { $dlevel=($arrit[nlevel]-$user[level]);  $N_level=' ������:'.$dlevel.',';} }
			if (($arrit[nalign] != (int)($ch_al) ) AND ($arrit[nalign] != 0)) {$SVIT=' ���������� �� ��';}
			if ($arrit[nnoj] >  $user[noj]) { if ($dnoj<($arrit[nnoj]-$user[noj])) { $dnoj=($arrit[nnoj]-$user[noj]);  $N_noj=' �������� ������ � ���������:'.$dnoj.', ';} }
			if ($arrit[ntopor] >  $user[topor]) { if ($dtopor<($arrit[ntopor]-$user[topor])) { $dtopor=($arrit[ntopor]-$user[topor]) ;    $N_dtopor=' �������� �������� � ��������:'.$dtopor.', ';} }
			if ($arrit[ndubina] >  $user[dubina]) { if ($ddubina<($arrit[ndubina]-$user[dubina])) { $ddubina=($arrit[ndubina]-$user[dubina]);  $N_dubina=' �������� ��������, ��������:'.$ddubina.', ';}}
			if ($arrit[nmech] >  $user[mec]) { if ($dmec<($arrit[nmec]-$user[mec])) { $dmec=($arrit[nmec]-$user[mec]);  $N_mec=' �������� ������:'.$dmec.', ';} }
			if ($arrit[nfire] >  $user[mfire]) { if ($dmfire<($arrit[nfire]-$user[mfire])) { $dmfire=($arrit[nfire]-$user[mfire]);   $N_mfire=' �������� ������ ����:'.$dmfire.', ';}}
			if ($arrit[nwater] >  $user[mwater]) { if ($dmwater<($arrit[nwater]-$user[mwater])) { $dmwater=($arrit[nwater]-$user[mwater]);   $N_mwater=' �������� ������ ����:'.$dmwater.', ';}}
			if ($arrit[nair] >  $user[mair]) { if ($dmair<($arrit[nair]-$user[mair])) { $dmair=($arrit[nair]-$user[mair]);   $N_mair=' �������� ������ �������:'.$dmair.', ';}}
			if ($arrit[nearth] >  $user[mearth]) { if ($dmearth<($arrit[nearth]-$user[mearth])) { $dmearth=($arrit[nearth]-$user[mearth]);  $N_mearth=' �������� ������ �����:'.$dmearth.', ';}}
			if ($arrit[nlight] >  $user[mlight]) { if ($dmlight<($arrit[nlight]-$user[mlight])) { $dmlight=($arrit[nlight]-$user[mlight]);  $N_mlight=' �������� ����� �����:'.$dmlight.', ';}}
			if ($arrit[ngray] >  $user[mgray]) { if ($dmgray<($arrit[ngray]-$user[mgray])) { $dmgray=($arrit[ngray]-$user[mgray]);  $N_mgray=' �������� ����� �����:'.$dmgray.', ';}}
			if ($arrit[ndark] >  $user[mdark]) { if ($dmdark<($arrit[ndark]-$user[mdark])) {  $dmdark=($arrit[ndark]-$user[mdark]);  $N_dmdark=' �������� ����� ����:'.$dmdark.', ';}}
			if (($arrit[nclass] != $user[uclass]) and ($arrit[nclass]>0))  { $N_dclass=' ����� ��������� �� ������������� ��������� , ';}
			}
		 	$SVIT=$N_sila.$N_lovk.$N_inta.$N_vinos.$N_intel.$N_mudra.$N_level.$N_noj.$N_dtopor.$N_dubina.$N_mec.$N_mfire.$N_mwater.$N_mair.$N_mearth.$N_mlight.$N_mgray.$N_dmdark.$N_dclass.$SVIT;
		 	echo "<font color=red><b>��������!<b> ����� �������� ������� ���� ��� �� �������:<br>".$SVIT."<br></font>";
		 	return false;
		 } 	 else
		 {
		 //��� ���� ������ ����
			 if (( ($user[sergi]==0) or ($user[kulon]==0) or ($user[perchi]==0) or ($user[weap]==0) or ($user[bron]==0) or ($user[r1]==0)  or ($user[r2]==0)   or ($user[r3]==0) or ($user[helm]==0) or ($user[shit]==0) or ($user[boots]==0) ) and ($full==false) )
			{
			 echo "<font color=red><b>��������!<b> ����� ��������� ������ ������ ��������!</b></font><br>";
			 return false;
	 		}
			else
			 {
			 return true;
			 }
		}

}


function get_rkm_bonus_by_magic ($idmag)
{
	$rkm=0;
	$rkms_conf=array();

	//�������
	$rkms_conf[135]=1;  //'����� ������ ���� �������';
	$rkms_conf[136]=5; //'����������� ������ ���� �������';
	$rkms_conf[137]=3; //'������� ������ ���� �������';
	$rkms_conf[138]=2; //'������� ������ ���� �������';

	//������ ������
	/*
	$rkms_conf[130]=1; //'��� ������� I';
	$rkms_conf[131]=2;//'��� ������� II';
	$rkms_conf[132]=3;//'��� ������� III';
	$rkms_conf[133]=1;//'��� ������� I';
	$rkms_conf[134]=2;//'��� ������� II';
	*/

	//������
	$rkms_conf[5007153]=1;	//��� �������
	$rkms_conf[5017153]=3;	//��� �������

	//����
	$rkms_conf[155]=1; //'����� ������ ����� �����';
	$rkms_conf[156]=5; //'����������� ������ ����� �����';
	$rkms_conf[157]=3; //'������� ������ ����� �����';
	$rkms_conf[158]=2; //'������� ������ ����� �����';

	/* //������
	$rkms_conf[150]=1; //'���� ����� I';
	$rkms_conf[151]=2; //'���� ����� II';
	$rkms_conf[152]=3; //'���� ����� III';
	$rkms_conf[153]=1; //'���� ����� I';
	$rkms_conf[154]=2; //'���� ����� II';
	*/

	//������
	$rkms_conf[5007152]=1; //'���� �����';
	$rkms_conf[5017152]=3; //'���� �����';


	//������

	$rkms_conf[925]=1; //'����� ������ ������ �������';
	$rkms_conf[926]=5; //'����������� ������ ������ �������';
	$rkms_conf[927]=3; //'������� ������ ������ �������';
	$rkms_conf[928]=2; //'������� ������ ������ �������';

	/* // ������
	$rkms_conf[920]=1; // '����� ������ I';
	$rkms_conf[921]=2; //'����� ������ II';
	$rkms_conf[922]=3; //'����� ������ III';
	$rkms_conf[923]=1; //'����� ������ I';
	$rkms_conf[924]=2; //'����� ������ II';
	*/

	//������
	$rkms_conf[5007154]=1; //'����� ������';
	$rkms_conf[5017154]=3; //'����� ������';

	//�����

	$rkms_conf[935]=1; //'����� ������ ����� ������';
	$rkms_conf[936]=5; //'����������� ������ ����� ������';
	$rkms_conf[937]=3; //'������� ������ ����� ������';
	$rkms_conf[938]=2; //'������� ������ ����� ������';

	/* //������
	$rkms_conf[930]=1; //'���� ����� I';
	$rkms_conf[931]=2; //'���� ����� II';
	$rkms_conf[932]=3; //'���� ����� III';
	$rkms_conf[933]=1; //'���� ����� I';
	$rkms_conf[934]=2; //'���� ����� II';
	*/

	//������
	$rkms_conf[5007155]=1; //'���� �����';
	$rkms_conf[5017155]=3; //'���� �����';

	if (isset($rkms_conf[$idmag]))
		{
		$rkm=$rkms_conf[$idmag];
		}

return $rkm;
}


function lvl_up_naem($telo,$naem)
{
global $exptable,$naem_parm, $neam_skill_tree, $neam_skill_templ;

$n_proto=0; // ������� ������ = ���� �� � ��� ������ 1
$mes='';
if ($naem['level']>=10) // ������������ �������
	{
	//������ �� ��������
	return false;
	}

//����� ��� �������� ��� ��� ������ �����
if($naem['exp'] >= $naem['nextup'])
		{

					//new_delo
					$rec=array();
  		    			$rec['owner']=$telo['id'];
					$rec['owner_login']=$telo[login];
					$rec['owner_balans_do']=$telo['money'];
					$rec['owner_balans_posle']=$telo['money'];
					$rec['target']=$naem['id'];
					$rec['target_login']=$naem['login'];

					if ($exptable[$naem['nextup']][4]>0)
						{
							$naem['level']++;
							$nlevel=$naem['level'];
							$dvinos=$naem_parm[$n_proto][$nlevel]['vinos']-$naem['vinos']; // ������� �������� ������
							$dhp=$dvinos*6; // ������� �������� ��

							$rec['type']=1011; //���� �������
							$rec['add_info']=$naem['level'];

							$add_new_skill=$neam_skill_tree[$n_proto][$nlevel];
							$active_skills=unserialize($naem['skills']);
							$passive_skills=unserialize($naem['passkills']);

						    foreach($add_new_skill as $skilltype => $skill_ids)
							    		{
							    			if ($skilltype=='active')
							    				{
								    				foreach($skill_ids as $skill_id)
								    					{
								    					$active_skills[$skill_id]['id']=$neam_skill_templ[$skill_id]['id'];
													$active_skills[$skill_id]['name']=$neam_skill_templ[$skill_id]['name'];
													$active_skills[$skill_id]['power']=$neam_skill_templ[$skill_id]['power'];
													$active_skills[$skill_id]['chance']=$neam_skill_templ[$skill_id]['chance'];
								    					}
							    				}
							    			elseif ($skilltype=='passive')
							    				{
								    				foreach($skill_ids as $skill_id)
								    					{
								    					$passive_skills[$skill_id]['id']=$neam_skill_templ[$skill_id]['id'];
													$passive_skills[$skill_id]['name']=$neam_skill_templ[$skill_id]['name'];
													$passive_skills[$skill_id]['bylevel']=$neam_skill_templ[$skill_id]['bylevel'];
													$passive_skills[$skill_id]['time']=$neam_skill_templ[$skill_id]['time'];

													$passive_skills[$skill_id]['by_point']=$neam_skill_templ[$skill_id]['by_point'];
													$passive_skills[$skill_id]['cooldown']=$neam_skill_templ[$skill_id]['cooldown'];
													$passive_skills[$skill_id]['procent']=$neam_skill_templ[$skill_id]['procent'];
													$passive_skills[$skill_id]['active']=$neam_skill_templ[$skill_id]['active'];
								    					}
							    				}
							    		}



							mysql_query("UPDATE `users_clons` SET `nextup` = ".$exptable[$naem['nextup']][5].",
							`sila` = '{$naem_parm[$n_proto][$nlevel]['sila']}',
							`lovk` = '{$naem_parm[$n_proto][$nlevel]['lovk']}',
							`inta` = '{$naem_parm[$n_proto][$nlevel]['inta']}',
							`mec` = '{$naem_parm[$n_proto][$nlevel]['mec']}',
							`skills_point` = `skills_point` + '{$naem_parm[$n_proto][$nlevel]['skills_points']}',
							`passkills_points` = `passkills_points` +  '{$naem_parm[$n_proto][$nlevel]['passkills_points']}',
							`vinos` = `vinos`+".$dvinos.",
							`maxhp`= `maxhp` + '{$dhp}',
							`hp`=`maxhp` ,
							`skills`='".serialize($active_skills)."' ,
							`passkills`='".serialize($passive_skills)."' ,
							`level` = `level`+".$exptable[$naem['nextup']][4]." WHERE `id` = '{$naem['id']}' limit 1;");




						}
						else
						{
						$rec['type']=1010; // ������� ���
						$rec['add_info']=$exptable[$naem['nextup']][5];
						//����������� ������ ���� ��
						mysql_query("UPDATE `users_clons` SET `nextup` = ".$exptable[$naem['nextup']][5]." WHERE `id` = '{$naem['id']}' limit 1;");
						}

						add_to_new_delo($rec);


						if ($exptable[$naem['nextup']][4]>0)
						{
						$mes="�����������! ��� ������� <b>{$naem['login']}</b> ������ ".$naem['level']." ������, � ������� ���� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1&naem=1\")>��������������</a>.";

						//������� ��� ������������ ��� �������� �� ��.
						unset($_SESSION['active_passkill_massa']);
						unset($_SESSION['active_passkill_goto']);
						}
						else
						{
						//$mes="�����������! ��� ������� <b>{$naem['login']}</b> ������ ���������� ��������� �� ����� ������, � ������� ����������� ��������� <a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1&naem=1\")>������������� ��������</a>.";
						//$mes="�����������! ��� ������� <b>{$naem['login']}</b> ������ ���������� ��������� �� ����� ������.";
						}

						if ($mes!='')
						{
						addchp("<font color=green><b>".$mes."</b></font>",'{[]}'.$telo['login'].'{[]}',$telo[room],$telo[id_city]);
						}



					return true;
		}

return false;
}

function js_goto_fbattle()
{
echo '  <script>
	location.href = "fbattle.php";
	</script>
	</body>
	</html>';
return true;
}

function get_users_gellery($telo)
{
$uimg=array();
if ($telo['in_tower']!=0)
  {
  //� ��������
  }
  else
  {
      //�������� ���������������� �������� �� �������
      //������ �������������� �����
      $columotdel_array[4]=1;
      $columotdel_array[41]=2;
      $columotdel_array[1]=3;
      $columotdel_array[11]=3;
      $columotdel_array[12]=3;
      $columotdel_array[13]=3;
      $columotdel_array[14]=3;
      $columotdel_array[14]=3;
      $columotdel_array[42]=5;
      $columotdel_array[24]=8;
      $columotdel_array[21]=9;
      $columotdel_array[3]=10;
      $columotdel_array[2]=11;
      $columotdel_array[22]=28;
      $columotdel_array[6]=27;
      $columotdel_array[23]=4;

      $user_gellery=mysql_query("select * from gellery where owner='{$telo['id']}' and dressed>0");
      while($usr_img = mysql_fetch_assoc($user_gellery))
          {
          //������������� �� ����
          $uimg[$columotdel_array[$usr_img['otdel']]][$usr_img['dressed']]=$usr_img['img'];
          }
  }
return $uimg;
}

?>
