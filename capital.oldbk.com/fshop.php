<?php
function RedirectF($path = "?") {
	header("Location: ".$path);
	die();
}

function SetMsgF($msg,$typet = "s") {
	$_SESSION['fshopmsg'] = $msg;
	$_SESSION['fshopmsgtype'] = $typet;
}

$viewperpage = 20;


function renderfshopitem($row,$user,$rese,&$i) {
	$out = "";
	$maxres = 0;
	$isreqok = true;

	$row[GetShopCount()] = 1;
	if ($i == 0) { $i = 1; $class = 'even2';} else { $i = 0; $class = 'odd2'; }

	if (!empty($row['img_big'])) {
		$row['img'] = $row['img_big'];
	}


	$out .= '<tr class="'.$class.'">
			<td class="center vamiddle">
				<ul class="dress-item">
					<li>
						<div style="width:100;text-align:center;">
						<div style="float:none;margin:0 auto;" class="gift-block"><a target="_blank" href="http://oldbk.com/encicl/'.link_for_item($row,true).'.html"><img class="gift-image" title="'.$row['name'].'" alt="'.$row['name'].'" src="http://i.oldbk.com/i/sh/'.$row['img'].'"></a>

						</div>
						</div>
					</li>
	';

	if ($row['craftnotsell']) {
		$row['notsell'] = $row['craftnotsell'];
	}
	if ($row['craftsowner']) {
		$row['sowner'] = $user['id'];
	}
	if ($row['craftunik']) {
		$row['unik'] = $row['craftunik'];
	}
	if ($row['craftis_present'] && strlen($row['craftpresent'])) {
		$row['present'] = $row['craftpresent'];
	}
	if ($row['craftgoden']) {
		$row['goden'] = $row['craftgoden'];
		$row['dategoden'] = time()+($row['craftgoden']*3600*24);
	}

	if ($row['id'] >= 946 && $row['id'] <=957) {
		$row['isrep'] = 1;
	}

	$row['count'] = $row['craftprotocount'];

	$out .= '<li>%ACT%</li>';

	$out .= '</ul></td><td style="vertical-align:top;">';
	$item = showitem($row,0,false,'','',0,0,true);
	// ������ ��� �� �������� </tr>
	$item = substr($item,0,strlen($item)-5);
	$out .= $item;
	$out .= '</td><td style="vertical-align:top;">';

	if (ADMIN && $row['is_enabled'] == 0) {
		$out .= '<font color="red">��������!</font><BR>';
	}

	$out .= '<b>������� � ���������: </b><br>';
	if (strlen($row['craftnres'])) {
		$resarr = array();

		// �������� ������ ����� ��� ������ �������
		$pr = unserialize($row['craftnres']);
		if ($pr !== false) {
			while(list($k,$v) = each($pr)) {
				$resarr[$k] = $v;
			}
		}

		// �������� ��������� �� ���� �� ������ ����
		$eshopproto = array();

		$reslist = mysql_query_cache('SELECT * FROM shop WHERE id IN ('.implode(",",array_keys($resarr)).')',false,10*60);
		$resproto = array();
		if (count($reslist)) {
			while(list($k,$v) = each($reslist)) {
				$resproto[$v['id']] = $v;
				$resarr[$v['id']] = array('cost' => $v['cost'], 'count' => $resarr[$v['id']]);
			}
		}
		reset($resarr);
		// ���� ����� ������� �� ����� � shop
		while(list($k,$v) = each($resarr)) {
			if (!isset($resproto[$k])) $eshopproto[$k] = 1;
		}


		$reslist = mysql_query_cache('SELECT * FROM eshop WHERE id IN ('.implode(",",array_keys($eshopproto)).')',false,10*60);
		if (count($reslist)) {
			while(list($k,$v) = each($reslist)) {
				$resproto[$v['id']] = $v;
				$resarr[$v['id']] = array('cost' => $v['cost'], 'count' => $resarr[$v['id']]);
			}
		}


		uasort($resarr, 'cmpres');

		// �������
		reset($resarr);
		while(list($k,$v) = each($resarr)) {
			if ($rese[$k] < $v['count']) $isreqok = false;
			if (!isset($rese[$k])) $rese[$k] = 0;
			$out .= '<div class="gift-block"><a target="_blank" href="http://oldbk.com/encicl/'.link_for_item($resproto[$k],true).'.html"><img class="gift-image" title="'.$resproto[$k]['name'].' '.$rese[$k].'/'.$v['count'].'" alt="'.$resproto[$k]['name'].' '.$rese[$k].'/'.$v['count'].'" src="http://i.oldbk.com/i/sh/'.$resproto[$k]['img'].'"></a>';
			$out .= '<span class="invgroupcount'.($rese[$k] < $v['count'] ? "2" : "").'">'.$v['count'].'</span>';
			$out .= '</div>';
			if ($rese[$k] > 0 && $rese[$k] >= $v['count']) {
				// ������� ���������� ������������ ����� ������� ����� �������
				if ($maxres != 0) {
					$t = floor($rese[$k] / $v['count']);
					if ($maxres > $t) $maxres = $t;
				} else {
					$maxres = floor($rese[$k] / $v['count']);
				}
			}
		}
	}


	$out .= '</ul>';
	$out .= '</div></td></tr>';

	if ($isreqok) {
		$act = '����������: <b>'.$row['count'].'</b><br>';
		$act .= '<a href="?make=1&rid='.intval($_REQUEST['rid']).'&cid='.$row['craftid'].'">�������</a>';
		if ($row['is_vaza'] && isset($rese[30012])) $act .= '<br><br><a href="?make=1&rid='.intval($_REQUEST['rid']).'&cid='.$row['craftid'].'&vaza=1">������� � �����</a>';
		return str_replace('%ACT%',$act,$out);
	} else {
		$act = '����������: <b>'.$row['count'].'</b><br>';
		return str_replace('%ACT%',$act,$out);
	}
}

function MakeLimitF($rzname) {
	global $viewperpage;

	if ($_SESSION['fshoppage'.$rzname] === "all") return "";

	return ' LIMIT '.($viewperpage*$_SESSION['fshoppage'.$rzname]).','.$viewperpage;
}


function MakePagesF($rzname,$allcount = 0) {
	global $msg,$typet;
	global $viewperpage;
	$view = $viewperpage;

	if (!$allcount) {
		$q2 = mysql_query('SELECT FOUND_ROWS() AS `allcount`') or die();
		$allcount = mysql_fetch_assoc($q2);
		$allcount = $allcount['allcount'];
	}

	$cpages = ceil($allcount/$view);

	$page = $_SESSION['fshoppage'.$rzname];

	if ($page >= $cpages && $page > 0 && $page !== "all") {
		$_SESSION['fshoppage'.$rzname] = intval($cpages-1);
		if ($_SESSION['fshoppage'.$rzname] < 0) $_SESSION['fshoppage'.$rzname] = 0;
		SetMsg($msg,$typet);
		RedirectF();
	}

	if ($cpages <= 1) return false;

	$pages = '��������: ';
	for ($i = 0; $i < $cpages; $i++) {
		if ($page === $i) {
			$pages .= '<b> '.($i+1).'</b> ';
		} else {
			$pages .= '<a href="?make=1&rid='.$rzname.'&page='.$i.'">'.($i+1).'</a> ';
		}
	}

	if ($page === "all") {
		$pages .= '<b>[��]</b> ';
	} else {
		$pages .= '[<a href="?make=1&rid='.$rzname.'&page=all">��</a>] ';
	}

	return $pages;
}

if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {
	$miniBB_gzipper_encoding = 'x-gzip';
}
if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
	$miniBB_gzipper_encoding = 'gzip';
}
if (isset($miniBB_gzipper_encoding)) {
	ob_start();
}

// ������� � sowner � present != ""
$exgifts = array(910,12800,12802,12803);
$exgifts2 = array(410130,410131,410132,410133,410134,410135);

session_start();
if (!($_SESSION['uid'] >0)) RedirectF("index.php");

require_once "connect.php";
require_once "functions.php";
require_once 'config_ko.php';


if(!ADMIN) {
	if ($user['room'] != 34)  {
		RedirectF("main.php");
	}
}

if (isset($_POST['fall'])) {
	$_SESSION['fall']=(int)$_POST['fall'];
} else {
	$_POST['fall']=(int)$_SESSION['fall'];
}


if ($user['battle'] != 0) {
	RedirectF("fbattle.php");
}

if (!isset($_SESSION['fshop_view'])) $_SESSION['fshop_view'] = "kr";
$otdel = isset($_GET['otdel']) ? intval($_GET['otdel']) : "12";

$g_otdel = array(12,14,7,71,73,74,72,75,76,77,78,79,60);
if (in_array($otdel,$g_otdel) === FALSE) die();


$self = basename($_SERVER['PHP_SELF']);

// ��� ���������� ��������
$ugiftsql = "";
$ugift = array();

if($otdel == 72) {
	$klan=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.clans WHERE short = '".$user['klan']."'"));
	$vozm=unserialize($klan['vozm']);
	if($user['prem']>0) {
	    	$ugift[] = " owner= '".($user['sex']==1?90:91)."'";
	}

       	$ugift[] = " owner = '".$user['id']."'";

	if($vozm[$user['id']][6]==1 || $user['id']==$klan['glava']) {
		$ugift[] = " klan = '".$user[klan]."'";
	}

	$ugiftsql = " AND (";
    	for($i=0;$i<count($ugift);$i++) {
           	$ugiftsql .= $i<count($ugift)-1 ? $ugift[$i]." or " : $ugift[$i]." ";
    	}


	$user_group = \components\models\GroupUniqueGift::getUserGroup($user);
	if($group_gift_ids = \components\models\GroupUniqueGift::getGroupGiftIds($user_group)) {
		$ugiftsql = sprintf('%s or id in (%s)', rtrim($ugiftsql), implode(',', $group_gift_ids));
	}

	$ugiftsql .= " )";
}

$asex[0]='a';
$asex[1]='';



if (isset($_GET['set']) || isset($_POST['set'])) {
	if ($_GET['set']) { $set = intval($_GET['set']); }
	if ($_POST['set']) { $set = intval($_POST['set']); }
	$_POST['count'] = intval($_POST['count']);
	if ($_POST['count'] < 1) { $_POST['count'] = 1;}

	if ($otdel==60) {
		//������ ������
		$q = mysql_query('SELECT *  FROM oldbk.`shop` WHERE id>=410001 and id<=410008 AND `id` = '.$set.' '.$ugiftsql) or die();
	} else {
		$q = mysql_query('SELECT * FROM oldbk.`eshop` WHERE glava = 0 AND `razdel` = '.$otdel.' AND `id` = '.$set.' '.$ugiftsql) or die();
	}

	if (mysql_num_rows($q) != 1) {
		SetMsgF("����� �� ������.","e");
		RedirectF("?otdel=".$otdel);
	}

	$dress = mysql_fetch_array($q);
	$d[0] = getmymassa($user);
	if ($dress !== FALSE && ($dress['massa']*$_POST['count']+$d[0]) > (get_meshok())) {
		SetMsgF("������������ ����� � �������.","e");
		RedirectF("?otdel=".$otdel);
	}

	if ( (!((time()>$KO_start_time22) and (time()<$KO_fin_time22))) and ($otdel==60)) {
		SetMsgF("����� �� ������.","e");
		RedirectF("?otdel=".$otdel);
	}

	if (($dress[GetShopCount()] < $_POST['count']) and ($otdel!=60)) {
		SetMsgF("������������ ������ � ��������.","e");
		RedirectF("?otdel=".$otdel);
	}

	if ($user['money'] < ($dress['cost']*$_POST['count'])) {
		SetMsgF("� ��� ������������ ��.","e");
		RedirectF("?otdel=".$otdel);
	}

	// �� �� - ��������

	// ������ ����� ����� ����� ����� ������� ����� ����� � ������ � ����, �.�. � ��������� �� ��������� �� ������ �����
	$dress['cost_copy'] = $dress['cost'];

	if($dress['razdel'] == 14) {
		// �� ������� ������ ���� 1��
		$dress['cost'] = 1;
		$dress['ecost'] = 0;
	}

	$razdel = 0;
	if ($otdel == 12 || $otdel == 14) {
		$razdel = 6;
	} else {
		$razdel = $dress['razdel'];
	}

	if ($razdel == 0) die();


	mysql_query('START TRANSACTION');

	if ($otdel == 60) {
		// ������� �� ������ ������
		$dress['unik'] = 2;
		$dress['present'] = '�����������';
	} else {
		mysql_query("UPDATE oldbk.`eshop` SET `".GetShopCount()."`=`".GetShopCount()."`-{$_POST['count']} WHERE `id` = '{$set}' AND `".GetShopCount()."` >= {$_POST['count']} LIMIT 1;");

		if (mysql_affected_rows() < 1) {
			SetMsgF("������������ ������ � ��������.","e");
			RedirectF("?otdel=".$otdel);
		}
	}

	$statsrazdel = array(6,7,71,72,75);

	if (in_array($razdel,$statsrazdel)) {
		mysql_query('INSERT INTO shop_stats (owner,shoptype,shopprototype,shopcount,lastupdate)
				VALUES ('.$user['id'].',3,'.$set.','.$_POST['count'].','.time().')
				ON DUPLICATE KEY UPDATE
					`shopcount` = `shopcount` + '.$_POST['count'].', lastupdate = '.time()
		) or die();
	}


	$bids = "";
	for($k=1; $k <= $_POST['count']; $k++) {

		if ($dress['dategoden']>0) {
			$goden_do=$dress['dategoden'];
		} elseif($dress[id]>=300400 AND $dress[id]<=300413) {
			$goden_do = mktime(23,59,59,4,7);
		} else {
			$goden_do=(($dress['goden']) ? ($dress['goden']*24*60*60+time()) : "");
		}


		if (($razdel == 76)) { $razdel = 73; }
		if (($razdel == 77)) { $razdel = 72; }

		// ������� �� ����2016
		if (($razdel == 73 && strpos($dress['img'],'gift_euro0') !== false)) { $razdel = 72; }

		// ������� ��  ��2018
		if (($razdel == 73 && strpos($dress['img'],'gift_wc2018') !== false)) { $razdel = 72; }




		if ($dress['id']==2016002)
			{
			$dress['present']='�����������';
			$goden_do= mktime(23,59,59,4,15);
			$dress['goden'] = round(($goden_do-time())/60/60/24); if ($dress[goden]<1) {$dress[goden]=1;}
			}

		mysql_query("
			INSERT INTO oldbk.`inventory`
			(
				`prototype`,`otdel`,`owner`,`sowner`,`name`,`type`,`nclass`,`notsell`,
				`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
				`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,
				`gnoj`,	`gtopor`,`gdubina`,`gmech`,`gfire`,
				`gwater`,`gair`,`gearth`,`glight`,`ggray`,
				`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,
				`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,
				`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,
				`nearth`,`nlight`,`ngray`,`ndark`,`mfkrit`,
				`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,
				`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,
				`includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,
				`idcity`,`nalign`,`dategoden`,`goden`,`gmeshok`,`letter`,`ab_mf`,  `ab_bron` ,  `ab_uron`,`getfrom`, `img_big` , `mfbonus` , `stbonus` , `unik`, `present`
			)
			VALUES
			(
				'{$dress['id']}','{$razdel}','{$user['id']}', '".($dress['is_owner']==1?$user[id]:0)."' ,'{$dress['name']}','{$dress['type']}','{$dress['nclass']}','{$dress['notsell']}',
				{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},
				'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}',
				'{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}',
				'{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}',
				'{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}',
				'{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}',
				'{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}',
				'{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}','{$dress['mfkrit']}',
				'{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}',
				'{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
				'{$dress['includemagic']}','{$dress['includemagicdex']}','{$dress['includemagicmax']}','{$dress['includemagicname']}','{$dress['includemagicuses']}','{$dress['includemagiccost']}',
				'{$user['id_city']}','{$dress['nalign']}','{$goden_do}','{$dress['goden']}','{$dress['gmeshok']}','{$dress['letter']}' , '{$dress['ab_mf']}',  '{$dress['ab_bron']}' ,  '{$dress['ab_uron']}',  '31' ,  '{$dress['img_big']}' ,  '{$dress['mfbonus']}' ,  '{$dress['stbonus']}' ,  '{$dress['unik']}', '{$dress['present']}'
				)
		") or die();

		$bids .= mysql_insert_id().",";
	}

	$bids = substr($bids,0,strlen($bids)-1);

	$limit = $_POST['count'];
	$invdb = mysql_query("SELECT * FROM oldbk.`inventory` WHERE `id` IN (".$bids.") ") or die();
	if ($limit == 1) {
		$dressinv = mysql_fetch_array($invdb);
		$dressid = get_item_fid($dressinv);
		$dresscount=" ";
	} else {
		$dressid="";
		while ($dressinv = mysql_fetch_array($invdb))  {
			$dressid .= get_item_fid($dressinv).",";
		}

		$dresscount="(x".$_POST['count'].") ";
		$dressid = substr($dressid,0,strlen($dressid)-1);
	}


	$allcost = $_POST['count']*$dress['cost_copy'];

	mysql_query("UPDATE `users` set `money` = `money`- '".($allcost)."' WHERE id = {$_SESSION['uid']} LIMIT 1") or die();

        //new_delo
	$rec = array();
	$rec['owner']=$user['id'];
	$rec['owner_login']=$user['login'];
	$rec['owner_balans_do']=$user['money'];
	$rec['owner_balans_posle']=$user['money']-$allcost;
	$rec['type']=401;
	$rec['target']=0;
	$rec['target_login']="��������� ���.";
	$rec['sum_kr']=$allcost;
	$rec['item_id']=$dressid;
	$rec['item_name']=$dress['name'];
	$rec['item_count']=$_POST['count'];
	$rec['item_type']=$dress['type'];
	$rec['item_cost']=$dress['cost'];
	$rec['item_dur']=$dress['duration'];
	$rec['item_maxdur']=$dress['maxdur'];
	$rec['item_ups']=$dress['ups'];
	$rec['item_incmagic']=$dress['includemagicname'];
	$rec['item_incmagic_count']=$dress['includemagicuses'];
	$rec['item_arsenal']='';
	add_to_new_delo($rec) or die();

	mysql_query('COMMIT') or die();

	SetMsgF("�� ������ {$_POST['count']} ��. \"{$dress['name']}\".");

	//check buy item for quest
	try {
		$User = new \components\models\User($user);
		$Quest = $app->quest
			->setUser($User)
			->get();
		$Checker = new \components\Component\Quests\check\CheckerItem();
		$Checker->item_id = $dress['id'];
		$Checker->shop_id = \components\Helper\ShopHelper::TYPE_FSHOP;
		$Checker->category_id = $otdel;

		if(($Item = $Quest->isNeed($Checker)) !== false) {
			$Quest->taskUp($Item);
		}
	} catch (Exception $ex) {

	}
	RedirectF("?otdel=".$otdel);
}


// �������
if (isset($_SESSION['fshopmsg'])) {
	$msg = $_SESSION['fshopmsg'];
	$typet = $_SESSION['fshopmsgtype'];
	unset($_SESSION['fshopmsg']);
	unset($_SESSION['fshopmsgtype']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="windows-1251">
<title></title>
<link rel="stylesheet" href="newstyle_loc4.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/steel/steel.css" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="i/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="i/js/noty/packaged/custom.js"></script>
<script type="text/javascript" src="/i/globaljs.js"></script>
<script type='text/javascript' src='http://i.oldbk.com/i/js/recoverscroll.js'></script>
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/jscal2.js"></script>
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/lang/ru2.js"></script>
<style>
#page-wrapper table td.vamiddle {
	vertical-align: middle;
}
.vamiddle {
	vertical-align: middle;
}

#page-wrapper table.nopadding td {
	padding: 0px;
}

#hint3 table td {
	padding: 0px;
}


.invgroupcount {
	position: absolute;
	bottom: 4px;
	right: 5px;
	font-weight:bold;
	background-color:#717070;
	width:30px;
	color:white;
	filter:alpha(opacity=90);
	-moz-opacity: 0.9;
	opacity: 0.9;
	text-align:center;
}

.invgroupcount3 {
	position: absolute;
	bottom: 4px;
	right: 3px;
	font-weight:bold;
	background-color:#717070;
	width:30px;
	color:white;
	filter:alpha(opacity=90);
	-moz-opacity: 0.9;
	opacity: 0.9;
	text-align:center;
}

.invgroupcount2 {
	position: absolute;
	bottom: 4px;
	right: 5px;
	font-weight:bold;
	background-color:#F25858;
	width:30px;
	color:white;
	filter:alpha(opacity=90);
	-moz-opacity: 0.9;
	opacity: 0.9;
	text-align:center;
}

.gift-block {
	margin-top:5px;
	width: 64px;
	float:left;
	position:relative;
}
.gift-block .gift-image {
	opacity: 1;
}

table#questdiag {
	width: 500px;
}
table#questdiag td img {
    display: block;
}

#page-wrapper #questdiag {
	table-layout: auto;
}

#hint3 a {
	color: #003585;
	font-weight:bold;
	text-decoration:none;
}

#hint3 {
    font-family: Tahoma;
    font-size: 13px;
}

#page-wrapper #questdiag td {
	padding: 0px;
}

#page-wrapper ul.listreq li {
    padding: 0px;
}

#page-wrapper .tnop td {
    padding: 0px;
}

button:focus {
    outline: 0;
}

input:focus {
    outline: 0;
}

SELECT {
	BORDER-RIGHT: #b0b0b0 1pt solid; BORDER-TOP: #b0b0b0 1pt solid; MARGIN-TOP: 1px; FONT-SIZE: 10px; MARGIN-BOTTOM: 2px; BORDER-LEFT: #b0b0b0 1pt solid; COLOR: #191970; BORDER-BOTTOM: #b0b0b0 1pt solid; FONT-FAMILY: MS Sans Serif
}
TEXTAREA {
	BORDER-RIGHT: #b0b0b0 1pt solid; BORDER-TOP: #b0b0b0 1pt solid; MARGIN-TOP: 1px; FONT-SIZE: 10px; MARGIN-BOTTOM: 2px; BORDER-LEFT: #b0b0b0 1pt solid; COLOR: #191970; BORDER-BOTTOM: #b0b0b0 1pt solid; FONT-FAMILY: MS Sans Serif
}
INPUT {
	BORDER-RIGHT: #b0b0b0 1pt solid; BORDER-TOP: #b0b0b0 1pt solid; MARGIN-TOP: 1px; FONT-SIZE: 10px; MARGIN-BOTTOM: 2px; BORDER-LEFT: #b0b0b0 1pt solid; COLOR: #191970; BORDER-BOTTOM: #b0b0b0 1pt solid; FONT-FAMILY: MS Sans Serif
}

.sell-dialog-class .ui-dialog-title {
	FONT-FAMILY: Tahoma;
	FONT-SIZE: 13px;
}

.noty_message { padding: 5px !important;}

#page-wrapper table td {
	vertical-align:middle;
}

</style>
<SCRIPT LANGUAGE="JavaScript">

function showhide(id) {
	if (document.getElementById(id).style.display=="none")
	{document.getElementById(id).style.display="block";}
	else
	{document.getElementById(id).style.display="none";}
}


function AddCount(event,name, txt, href) {
    var el = document.getElementById("hint3");
	var sale=0;
	var sale_txt= '������ ��������� ����';
	var a_href = "";
	if (href.length) a_href=' action = "'+href+'"';

	el.innerHTML = '<form '+a_href+' method="post" style="margin:0px; padding:0px;"><table class="nopadding" border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B style="font-size:11pt;">'+sale_txt+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();return false;"><B style="font-size:11pt;">x</B></TD></tr><tr><td colspan=2>'+
	'<table class="nopadding" border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="is_newsale" value="'+sale+'"><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B style="font-size:11pt;"><I>'+txt+'</td></tr><tr><td width=80% align=center colspan=2 style="font-size:11pt;">'+
	'���-�� <INPUT id="itemcount" TYPE="text" NAME="count" size=4 > <INPUT TYPE="submit" style="height:16px;margin-top:2px;" value=" �� ">'+
	'</TD></TR></TABLE></td></tr></table></form>';

	el.style.visibility = "visible";
	el.style.display = "";
	el.style.left = (document.body.scrollLeft - 20) + 350 + 'px';
	y = event.pageY;
	el.style.top = (y -120) + 'px';
	document.getElementById("itemcount").focus();
}


function closehint3() {
	document.getElementById("hint3").style.visibility="hidden";
	document.getElementById("hint3").style.display="none";
}


</SCRIPT>
</HEAD>
<body id="fshop-body">
<script type='text/javascript'>
RecoverScroll.start();
</script>



<?php
if(!$_SESSION['beginer_quest']['none']) {
	$last_q=check_last_quest(5);
	if($last_q) {
		quest_check_type_5($last_q);
		//��������� ������ �� ���-�
	}

	$last_q=check_last_quest(2);
	if($last_q) {
		quest_check_type_2($last_q);
		//��������� ������ �� ���-�
	}
}

?>

<div id="page-wrapper">
    <div class="title">
        <div class="h3">��������� �������</div>
        <div id="buttons">
            <a class="button-dark-mid btn" onclick="window.open('help/fshop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes'); return false;" title="���������">���������</a>
            <a class="button-mid btn" OnClick="location.href='?tmp='+Math.random(); return false;" title="��������">��������</a>
            <a class="button-mid btn" OnClick="document.getElementById('cityform').submit(); return false;" title="���������">���������</a>
	    <FORM action="city.php" style="margin:0px;padding:0px;display:block;" id="cityform" method="GET"><INPUT TYPE="hidden" value="strah" name="strah"></form>
        </div>
    </div>
    <div id="shop">
		<table cellspacing="0" cellpadding="0" style="min-width:1000px;">
			<colgroup>
				<col width="280px">
				<col>
				<col width="250px">
			</colgroup>
			<tbody>
			<tr>
			<td align="center" style="vertical-align:top;background: url(http://i.oldbk.com/i/map/npc_flowers_fon3.png) no-repeat;">
				<a href="?quest=1"><img  src="http://i.oldbk.com/i/map/npc_flowers2.png" alt="����������" title="����������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/npc_flowers_hover4.png'" onmouseout="this.src='http://i.oldbk.com/i/map/npc_flowers2.png'"/></a>
				<?php

				$mldiag = array();
				$mlquest = "30/30";
				if(isset($_GET['qaction']) && isset($_GET['d'])) {
					$BotDialog = new \components\Component\Quests\QuestDialogNew(\components\Helper\BotHelper::BOT_FLOWER);
					//����� � ������ �������
					$dialog_id = isset($_GET['d']) ? (int)$_GET['d'] : null;
					$action_id = isset($_GET['a']) ? (int)$_GET['a'] : null;
					$dialog = $BotDialog->dialog($dialog_id, $action_id);
					if($dialog !== false) {
						$mldiag[0] = $dialog['message'];
						foreach ($dialog['actions'] as $action) {
							$key = '&a='.$action['action'];
							if(isset($action['dialog'])) {
								$key .= '&d='.$action['dialog'];
							}
							$mldiag[$key] = $action['message'];
						}
					}
				}

				if (isset($_GET['quest']) && empty($mldiag)) {
					$BotDialog = new \components\Component\Quests\QuestDialogNew(\components\Helper\BotHelper::BOT_FLOWER);

					$mldiag[0] = '- ���� ������, '.($user['sex'] == 1 ? "������� ����" : "������� �����������").'! �������, ������� ��� ��������. � ���� ����������� ������� - ��������, ��� �������, ��� � ������ �������, ������� �� ����� ������, �������� �� �������� ��������!';

					foreach ($BotDialog->getMainDialog() as $dialog) {
						$key = '&d='.$dialog['dialog'];
						$mldiag[$key] = $dialog['title'];
					}

					$mldiag[4] = '- �������, � ���������.';

				}
				if(!empty($mldiag)) {
					require_once('mlquest.php');
				}

?>
				</div>
			</td>
			<td style="vertical-align:top;">
					    <?php
						$lasttime = 30*24*3600; // �� ��������� �����
						$q = mysql_query('SELECT eshop.* FROM shop_stats LEFT JOIN eshop ON shopprototype = eshop.id WHERE shop_stats.owner = '.$user['id'].' and shoptype = 3 and lastupdate > '.(time()-$lasttime).' ORDER BY shopcount DESC, lastupdate DESC LIMIT 12');
						if (mysql_num_rows($q) > 0) {
					    ?>

			                    <table class="table border" style="margin-bottom: 0;" cellspacing="0" cellpadding="0">
			                        <thead>
			                        <tr class="head-line">
			                            <th>
			                                <div class="head-left"></div>
			                                <div class="head-title">��� ���������� �������</div>
							<div class="head-right"></div>
						    </th>
						</tr>
						<tr class="even2">
						<td>
						<ul id="favorite">
							<?php while($row = mysqL_fetch_assoc($q)) {
								if(!isset($row['id'])) {
									continue;
								}
								if (!empty($row['img_big'])) {
									$row['img'] = $row['img_big'];
								} ?>
								<li style="display:inline-block;margin:3px;">
									<div style="text-align:center;">
										<img alt="<?=$row['name']?>" title="<?=$row['name']?>" src="http://i.oldbk.com/i/sh/<?= $row['img']; ?>">
									</div>
									<div style="text-align:center;margin-top:2px;">
										<a style="font-weight:normal;" href="?otdel=<?=$row['razdel']; ?>&set=<?= $row['id'] ?>">������</a>
										<img src="http://i.oldbk.com/i/up.gif" width="11" height="11" border="0" a="������ ��������� ����" style="cursor: pointer" onclick="AddCount(event,'<?= $row['id']?>', '<?= $row['name']?>','?otdel=<?=$row['razdel']?>'); return false;">
									</div>
								</li>
							<?php } ?>
						</ul>
						</td></tr>
				    	</table>

			    <br>
	                    <?php } ?>
	                    <table class="table border" style="margin-bottom: 0;" cellspacing="0" cellpadding="0">
	                        <colgroup>
	                            <col>
	                            <col>
	                        </colgroup>
	                        <thead>
	                        <tr class="head-line">
	                            <th>
	                                <div class="head-left"></div>
	                                <div class="head-title">����� &quot;<?php
				if (isset($_REQUEST['present'])) {
					echo '������� �������';
				} elseif(isset($_REQUEST['make'])) {
					echo '���� ��������';
				} else {
					switch($otdel) {
						case 7:
							echo '��������';
						break;
						case 12:
							echo '����������� ��� ������� � ����';
						break;
						case 14:
							echo '������� ������';
						break;
						case 71:
							echo '�������';
						break;
						case 60:
							echo '������ ������';
						break;
						case 73:
							//echo '���������� �������';
							//echo '1 ��������';
							//echo '������� �� Halloween';
							//echo '���� ������� ���������';
							//echo '���������';
							echo '��������';
							//echo '23 �������';
							//echo '����������� �������';
							//echo '���� ������ �����';
							//echo '��-2018';
							//echo '����-2016';
							//echo '8 �����';
							//echo '1 ���';
						break;
						case 74:
							//echo '���������� �������';
							//echo '���������� �������';
							echo '��������������� �������';
							//echo '���������';
						break;
						case 72:
							echo '���������� �������';
						break;
						case 75:
							echo '��������� ����������';
						break;
						case 76:
							echo '������ �������';
						//	echo '�������� �������';
						//      echo '������ �������';
							//echo '������� �������';
						break;
						case 77:
							echo '9 ���';
							//echo '���������� �������';
						break;
						case 78:
							echo '�����';
						break;
						case 79:
							echo '���������';
						break;

					}
				}
?>&quot;
				</div>
                            </th>
                            <th class="filter">
                                <div class="head-title" style="right:272px;">
                                </div>
                                <? if (isset($_REQUEST['make']) && $_REQUEST['rid'] == 1) { ?>
			    	<form method="POST" action="?make=1&rid=<? echo intval($_REQUEST['rid']); ?>" id="fall" style="margin:0px;padding:0px;display:block;">

                                <div class="head-title" style="right:5px;top:-1px;">
                                    <select name="fall" style="width:270px;height:14px;margin:0px;top:0px;" OnChange="document.getElementById('fall').submit();">
					<option value = "0" <? if ((int)($_POST['fall'])==0) { echo ' selected ' ; $viewb=0; } ?>>���������� ��� ������</option>
					<option value = "1" <? if ($_POST['fall'] == 1) { echo ' selected ' ; $viewb=1; } ?>>���������� ������ �� ������ �������� 7 ����</option>
					<option value = "2" <? if ($_POST['fall'] == 2) { echo ' selected ' ; $viewb=2; } ?>>���������� ������ �� ������ �������� 10 ����</option>
					<option value = "3" <? if ($_POST['fall'] == 3) { echo ' selected ' ; $viewb=3; } ?>>���������� ������ �� ������ �������� 20 ����</option>
					<option value = "4" <? if ($_POST['fall'] == 4) { echo ' selected ' ; $viewb=4; } ?>>���������� ������ ��������� ��� �����</option>
                                    </select>
                                </div>
				</form>
				<? } ?>
                                <div class="head-right"></div>
                            </th>
                        </tr>
                        </thead>
                    </table>
<?

if (isset($msg) && strlen($msg)) {
	echo '
		<script>
			var n = noty({
				text: "'.addslashes($msg).'",
			        layout: "topLeft2",
			        theme: "relax2",
				type: "'.($typet == "e" ? "error" : "success").'",
			});
		</script>
	';
}


if(isset($_REQUEST['present'])) {
	if(isset($_POST['to_login'],$_POST['itemid']) && !empty($_POST['to_login']) && !empty($_POST['itemid'])) {
		$to =check_users_city_datal($_POST['to_login']);

		if ((($to['klan']=='radminion') or ($to['klan']=='Adminion') ) and ($user['level']<7)) {
			SetMsgF("��� ������� �� ��������� ������� ������� ����� ���������!","e");
			RedirectF("?present=1");
		} elseif ($to['login'] == $user['login']) {
			SetMsgF("������� ������ ���-�� ������ ���� ;)","e");
			RedirectF("?present=1");
		} elseif ($to === FALSE) {
			SetMsgF("��������� �� ����������.","e");
			RedirectF("?present=1");
		} elseif ($to['in_tower'] == 1) {
			SetMsgF("�������� � ������ ������ ��������� � ������� � ����� ������. ���������� �����.","e");
			RedirectF("?present=1");
		} elseif ($to['in_tower'] == 2) {
			SetMsgF("<font color=red>�������� � ������ ������ ��������� � ������� � ������. ���������� �����.","e");
			RedirectF("?present=1");
		} else {
			$_POST['itemid'] = intval($_POST['itemid']);

			$item = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` USE INDEX (owner_4) WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND ((`prototype` >= 55510000 AND `prototype` <= 55520000) OR `prototype` = 20000 OR type = 200 or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts2).")))  AND `setsale` = 0 AND (`present` = '' or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts).")) or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts2)."))) and ekr_flag = 0 AND id = ".$_POST['itemid']));


			if ($item['prototype'] == 16022) {
				include "random_box.php";
				$_POST['podarok2'] = $rnd_mess[mt_rand(0,count($rnd_mess)-1)];
			}


			if((int)$_POST['from']==1) {
				$from = '������';
			} elseif((int)$_POST['from'] == 2 && $user['klan']) {
				if($item['otdel'] == 72) {
					$kl=mysql_fetch_assoc(mysql_query("select * from oldbk.clans where short='".$user['klan']."' limit 1"));
				}
				$from = ' ���� '.$user['klan'].($item['otdel']==72?':|:'.$kl['id']:'');
			} elseif((int)$_POST['from'] == 0 && $_POST['from_admin'] && $user['align']>2 && $user['align']<3) {
				$from = $_POST['from_admin'];
			} else {
				$from = $user['login'].($item['otdel']==72?':|:'.$user['id']:'');
			}

			if ($item['type'] == 200) {
				$testitem = mysql_fetch_array(mysql_query("
					SELECT i.*, e.klan as eklan, e.owner as eowner
					FROM oldbk.inventory as i, oldbk.eshop as e
					WHERE  i.id = '".(int)$_POST['itemid']."'
					AND i.owner = '{$_SESSION['uid']}' AND i.dressed = 0 AND i.type = 200 AND i.setsale=0 AND (i.present = '' or (i.present != '' and i.sowner = ".$user['id']." and i.prototype IN (".implode(",",$exgifts)."))) and i.ekr_flag = 0
					AND i.prototype = e.id
				"));

				if (!$testitem) {
					SetMsgF("���� ������� �� �� ������ ��������...","e");
					RedirectF("?present=1");
				} else {
		            		$otdel = $testitem['otdel'];
	                  		//��� ��������� ������ 71/72.  ���� 72 - �� ��� ������ ������������. (�� ���� - ����/������)
	                    		if($otdel==72 && $testitem['eowner']>0 && $_POST['from']!=0) {
	                    			SetMsgF("� ������ �������� ������ ������� ������ �� ������ �����.","e");
						RedirectF("?present=1");
	                    		} elseif($otdel==72 && $testitem['eklan']!='' && $_POST['from']!=2) {
						SetMsgF("�� ������ �������� �������� ������� ������ �� ����� �����","e");
						RedirectF("?present=1");
					}
				}

				//���������� ��������
				if (($item['prototype'] == 2123456804 || $item['prototype'] == 40000001) && $_POST['from']!=0) {
					SetMsgF("�� ������ �������� ����������� ������� ������ �� ������ �����.","e");
					RedirectF("?present=1");
				}

				if  ((($item['prototype']>='900' ) AND ($item['prototype']<='908' )) AND ($item['sowner']!=$user['id'])) {
					SetMsgF("���� ������� �� ���, �� �� ������ ��� ��������!","e");
					RedirectF("?present=1");
				}

				if  ((($item['prototype']>='900' ) AND ($item['prototype']<='908' )) AND ($user['sex']==$to['sex'])) {
					SetMsgF("���� ������� ����� ������ ������ ���������������� ����!","e");
					RedirectF("?present=1");
				}

				if  ((($item['prototype']>='304013' ) AND ($item['prototype']<='304019'))) {
					SetMsgF("���� ������� ����� ������ ������ ������ ��� �����!","e");
					RedirectF("?present=1");
				}
			}


		   	if($item !== FALSE) {
		   		$two_balance=true; //����� � ���� ����� ( ����� ����������� ��������)
				//������ �������.

				// �����
				if(!$_SESSION['beginer_quest']['none']) {
					//�������� �����
					if($to['id']==3  || $to['id']==4 || $to['id']==6) { //���, �����, ����
						$last_q=check_last_quest(9);
						if($last_q) {
							quest_check_type_9($last_q);
						}
					}
					$last_q=check_last_quest(30);
					if($last_q) {
						quest_check_type_30($last_q,$user['id'],1,1);
					}
				}


				$sql='';
				if($item['type']=='200' && ($item['otdel']=='7' || $item['otdel']=='77') && $item['dategoden']==0) {
					$sql=' `goden`="90", `dategoden`="'.(time()+60*60*24*30*3).'", ';
				}
				if($item['type']=='200' && ($item['otdel']=='71' || $item['otdel']=='73') && $item['dategoden']==0) {
	                               	$sql=' `goden`="180", `dategoden`="'.(time()+60*60*24*30*6).'", ';
				}

				//����� �������� ��� ���������� ������������ � ������ ���������
				//� ����� ����������
				if  (($item['prototype']>='900' ) AND ($item['prototype']<='908')) {
	                               	$sql=' `goden`="1", `dategoden`="'.(time()+60*60*24*1).'", ';
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200001' && $item['dategoden']==0) {
	                               	$sql=' `goden`="30", `dategoden`="'.(time()+60*60*24*30).'", ';
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200002' && $item['dategoden']==0) {
	                               	$sql=' `goden`="30", `dategoden`="'.(time()+60*60*24*30).'", ';
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200005' && $item['dategoden']==0) {
	                               	$sql=' `goden`="30", `dategoden`="'.(time()+60*60*24*30).'", ';
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200010' && $item['dategoden']==0) {
	                               	$sql=' `goden`="60", `dategoden`="'.(time()+60*60*24*30*2).'", ';
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200025' && $item['dategoden']==0) {
	                               	$sql=' `goden`="90", `dategoden`="'.(time()+60*60*24*30*3).'", ';
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200050' && $item['dategoden']==0) {
	                               	$sql=' `goden`="120", `dategoden`="'.(time()+60*60*24*30*4).'", ';
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200100' && $item['dategoden']==0) {
	                               	$sqlsow='  sowner=0, ';
				} elseif($item['prototype']=='200250' && $item['dategoden']==0) {
	                               	$sqlswo=' sowner=0, ';
				} elseif($item['prototype']=='200500' && $item['dategoden']==0) {
	                               	$sqlsow=' sowner=0, ';
				} elseif($item['prototype']=='2123456804' || $item['prototype']=='40000001') {
					$two_balance=false;
					$present=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.paket WHERE pid='".$item['id']."' LIMIT 1"));
					$item_in_box=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.inventory WHERE owner='499' AND id='".$present['iid']."' limit 1"));
				}

				if (in_array($item['prototype'],$exgifts)) {
	                               	$sqlsow=' sowner=0, ';
				}

				if (in_array($item['prototype'],$exgifts2)) {
	                               	$sqlsow=' sowner=0, ';
				}

				$f_date=$_POST[f_date];
				$f_date=explode(".",$f_date);
				$f_d=(int)$f_date[0];
				$f_m=(int)$f_date[1];
				$f_y=(int)$f_date[2];
				$error = 0;
				$sposob = 0;
				$present_time = mktime(11,59,0,$f_m,$f_d,$f_y);

			        if ($present_time <= mktime (11,59,0,date("m"),date("d"),date("y"))) {
					$sposob=0;
					$delmag="";
					if ($item['magic']==103) {
						$delmag=" `magic`=0 , ";
					}

					if (in_array($item['prototype'],$exgifts2)) {
						$run_sql = "UPDATE oldbk.`inventory` SET `present_text` = '".mysql_escape_string(htmlspecialchars($_POST['txt']))."', `owner` = '".$to['id']."', ".$sqlsow." `present` = '".$from."', ".$sql." `letter` = '".addslashes(htmlspecialchars($_POST['podarok2']))."' WHERE  (`present` = '' or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts).")) or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts2)."))) and ekr_flag = 0 AND `id` = ".$_POST['itemid']." LIMIT 1";
					} else {
						$run_sql = "UPDATE oldbk.`inventory` SET `add_time` = ".time().", {$delmag}  `present_text` = '".mysql_escape_string(htmlspecialchars($_POST['txt']))."', `owner` = '".$to['id']."', ".$sqlsow." `present` = '".$from."', ".$sql." `letter` = '".addslashes(htmlspecialchars($_POST['podarok2']))."' WHERE  (`present` = '' or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts).")) or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts2)."))) and ekr_flag = 0 AND `id` = ".$_POST['itemid']." LIMIT 1";
					}
					mysql_query($run_sql);

					$item_name=$item['name'];

				        //new_delo
					$rec = array();
					if($two_balance == true) {
						$rec['owner']=$user['id'];
						$rec['owner_login']=$user['login'];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money'];
						$rec['target']=$to['id'];
						$rec['target_login']=$to['login'];
						$rec['type']=208;//���� �������
						$rec['sum_kr']=0;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=get_item_fid($item);
						$rec['item_name']=$item['name'];
						$rec['item_count']=1;
						$rec['item_type']=$item['type'];
						$rec['item_cost']=$item['cost'];
						$rec['item_dur']=$item['duration'];
						$rec['item_maxdur']=$item['maxdur'];
						$rec['item_ups']=$item['ups'];
						$rec['item_unic']=$item['unik'];
						$rec['item_proto']=$item['prototype'];
						$rec['item_incmagic']=$item['includemagicname'];
						$rec['item_incmagic_count']=$item['includemagicuses'];
						$rec['item_arsenal']='';
						$rec['add_info']=$user['login'];

						add_to_new_delo($rec); //�����
						$from=explode(':|:',$from);
						$from=$from[0];
						$rec['owner']=$to['id'];
						$rec['owner_login']=$to['login'];
						$rec['owner_balans_do']=$to['money'];
						$rec['owner_balans_posle']=$to['money'];
						$rec['target']=$user['id'];
						$rec['target_login']=$from;
						$rec['type']=209;//������� � ������� �������
					        add_to_new_delo($rec); //����
					} else	{
						//� ������� �������� ����� ������ � �������,
						//� ������� ���������� - �������. (� ���� ��������� ��� ��������)
						//$item_in_box
				    		$rec['owner']=$user['id'];
						$rec['owner_login']=$user['login'];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money'];
						$rec['target']=$to['id'];
						$rec['target_login']=$to['login'];
						$rec['type']=405;//���� ����������� �������
						$rec['sum_kr']=0;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=get_item_fid($item_in_box);
						$rec['item_name']=$item_in_box['name'];
						$rec['item_count']=1;
						$rec['item_type']=$item_in_box['type'];
						$rec['item_cost']=$item_in_box['cost'];
						$rec['item_dur']=$item_in_box['duration'];
						$rec['item_maxdur']=$item_in_box['maxdur'];
						$rec['item_ups']=$item_in_box['ups'];
						$rec['item_unic']=$item_in_box['unik'];
						$rec['item_proto']=$item_in_box['prototype'];
						$rec['item_incmagic']=$item_in_box['includemagicname'];
						$rec['item_incmagic_count']=$item_in_box['includemagicuses'];
						$rec['item_arsenal']='';
						$rec['add_info']=$user[login];
						add_to_new_delo($rec); //�����

						$from=explode(':|:',$from);
						$from=$from[0];
						$rec['owner']=$to['id'];
						$rec['owner_login']=$to['login'];
						$rec['owner_balans_do']=$to['money'];
						$rec['owner_balans_posle']=$to['money'];
						$rec['target']=$user['id'];
						$rec['target_login']=$from;

						$rec['type']=410;//������� � ������� �������
					        add_to_new_delo($rec); //����
					}


					if(($_POST['from']==1) || ($_POST['from']==2) || ((int)$_POST['from'] == 0 && $_POST['from_admin'] && $user['align']>2 && $user['align']<3)) {
						$action="�������";
					} else {
						if ($user['sex'] == 0) {
							$action="��������";
						} else {
							$action="�������";
						}
					}

					if($to['odate'] >=(time()-60)){
						addchp ('<font color=red>��������!</font> <span oncontextmenu="return OpenMenu();">'.$from.'</span> '.$action.' ��� <B>'.$item_name.'</B>.   ','{[]}'.$to['login'].'{[]}',$to['room'],$to['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$to['id']."','','".'<font color=red>��������!</font> <span oncontextmenu="return OpenMenu();">'.$from.'</span> '.$action.' ��� <B>'.$item_name.'</B>.   '."');");
					}
					SetMsgF("������� ������ ��������� � \"".$_POST['to_login']."\". ������� ����� ��������� � ������� ������.");

					if (mt_rand(0,100)<1) {
						DropBonusItem(112001,$user,"�����","��������� �2: ���������� �������",0,1,20,true); //����� ���� ������ - ������� ��������, ���� 1%
					}

						$rate_start = new DateTime('2018-03-07 00:00:00');
						$rate_end = new DateTime('2018-03-16 23:59:59');
						if((time() >= $rate_start->getTimestamp() && time() <= $rate_end->getTimestamp()) || ADMIN) {
							$flowers_rate = array(55600495, 55600498, 12801, 55600830, 55600831, 55600843, 55510000, 19677);
							$flowers_rate = array_merge($flowers_rate, range(55510151, 55510160));
							$flowers_rate = array_merge($flowers_rate, range(410130, 410135));
							$flowers_rate = array_merge($flowers_rate, range(410001, 410008));
							$flowers_rate = array_merge($flowers_rate, range(55510001, 55510095));
							if(in_array($item['prototype'], $flowers_rate)) {
								$_sql = sprintf('select cost from eshop e where name = "%s"', $item['name']);
								$prototype_item =  mysql_fetch_assoc(mysql_query($_sql));

								$log_rate_user_before = 0;
								$log_rate_user_after = 0;
								$log_rate_target_user_before = 0;
								$log_rate_target_user_after = 0;
								$log_cost = 0;
								$log_rate = 0;
								$log_item_proto = 0;
								$log_item_name = null;
								$log_success = true;
								try {
									$_time_ = time();

									$log_cost = $prototype_item['cost'];
									$log_rate = $prototype_item['cost'] * 2;
									$log_item_proto = $item['prototype'];
									$log_item_name = $item['name'];

									$rate_value = $prototype_item['cost'] * 2;
									$user_id_from = $user['id'];
									$user_id_to = $to['id'];
									$_sql_template = 'select count(tr.user_id) as cnt, tr.value
										from top_rate tr
										where action_type = "march82018" and rate_type = %d and user_id = %d';
									//rate from
									$_sql = sprintf($_sql_template, 1, $user_id_from);
									$rate_from = mysql_fetch_assoc(mysql_query($_sql));
									if($rate_from['cnt'] > 0) {
										$log_rate_user_before = $rate_from['value'];
										$log_rate_user_after = $rate_from['value'] + $rate_value;
										$_sql = sprintf('update top_rate tr set tr.value = tr.value + %d, tr.updated_at = %d
											where tr.user_id = %d and tr.action_type = "%s" and tr.rate_type = %d',
											$rate_value, $_time_, $user_id_from, 'march82018', 1);
										if(!mysql_query($_sql)) {
											$log_success = false;
										}
									} else {
										$log_rate_user_before = 0;
										$log_rate_user_after = $rate_value;
										$_sql = sprintf('insert into top_rate (user_id,action_type,rate_type,value,created_at,updated_at)
											values (%d,"%s",%d,%d,%d,%d)',
											$user_id_from, 'march82018', 1, $rate_value, $_time_,$_time_);
										if(!mysql_query($_sql)) {
											$log_success = false;
										}
									}

									//� ��� ����������������� ������ �������
									$_sql = sprintf($_sql_template, 2, $user_id_to);
									$rate_to = mysql_fetch_assoc(mysql_query($_sql));
									if($rate_to['cnt'] > 0) {
										$log_rate_target_user_before = $rate_to['value'];
										$log_rate_target_user_after = $rate_to['value'] + $rate_value;

										$_sql = sprintf('update top_rate tr set tr.value = tr.value + %d, tr.updated_at = %d
												where tr.user_id = %d and tr.action_type = "%s" and tr.rate_type = %d',
											$rate_value, $_time_, $user_id_to, 'march82018', 2);
										if(!mysql_query($_sql)) {
											$log_success = false;
										}
									} else {
										$log_rate_target_user_before = 0;
										$log_rate_target_user_after = $rate_value;
										$_sql = sprintf('insert into top_rate (user_id,action_type,rate_type,value,created_at,updated_at)
												values (%d,"%s",%d,%d,%d,%d)',
											$user_id_to, 'march82018', 2, $rate_value, $_time_,$_time_);
										if(!mysql_query($_sql)) {
											$log_success = false;
										}
									}
								} catch (Exception $ex) {
									$log_success = false;
									\components\Helper\FileHelper::writeArray(array(
										'message' => $ex->getMessage(),
										'from_id' => $user['id'],
										'to_id' => $to['id'],
										'item_id' => $item['prototype']
									), '8quest');
								}

								$_sql = sprintf('insert into quest8_log (user_id,target_user_id,rate_user_before,rate_user_after,
									rate_target_before,rate_target_after,cost,rate,created_at,item_proto,item_name,success,action_type) values (%d,%d,%d,%d,%d,%d,"%s",%d,%d,%d,"%s",%d,"%s")',
									$user['id'],$to['id'],$log_rate_user_before,$log_rate_user_after,
									$log_rate_target_user_before,$log_rate_target_user_after,$log_cost,$log_rate,time(),
									$log_item_proto,$log_item_name,$log_success?1:0,'march82018');
								mysql_query($_sql);
							}
						}

					try {
						global $app;

						$UserObj = new \components\models\User($user);
						$Quest = $app->quest->setUser($UserObj)->get();

						$Checker = new \components\Component\Quests\check\CheckerGift();
						$Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
						$Checker->item_id = $item['prototype'];
						$Checker->user_to = new \components\models\User($to);
						$Checker->operation_type = \components\Component\Quests\pocket\questTask\GiftTask::OPERATION_TYPE_FSHOP;
						if (($Item = $Quest->isNeed($Checker)) !== false) {
							$Quest->taskUp($Item);
						}

						unset($UserObj);
						unset($Quest);
					} catch (Exception $ex) {
						\components\Helper\FileHelper::writeException($ex, 'fshop');
					}
					RedirectF("?present=1");
				} else {
					if ($user['money'] >= 3) {
						$sposob=1;

						$item_name=$item['name'];
						if(($_POST['from']==1) || ($_POST['from']==2)) {
							$us_sex=1;
						} else {
							$us_sex=$user['sex'];
						}

				                //�������� !!!  `present` = '".$from.":".$user['id']."', - �������� � ����� ��� ���������!
			                        //`karman`=".$us_sex.", - ��� �������� ���� ��������
						// BY ����
						if ($from=='������') {
							$from.=($item['otdel']==72?':|:'.$user['id']:'');
						}

						mysql_query("UPDATE oldbk.`inventory` SET
						 ".$sql." `add_time` = ".$present_time.",
						 `present_text` = '".mysql_escape_string(htmlspecialchars($_POST['txt']))."',
						 `owner`= 448,
						 `karman`=".$us_sex.",
						 `sowner` = '".$to['id']."',
						 `present` = '".$from.":".$user['id']."',
						 `letter` = '".addslashes(htmlspecialchars($_POST['podarok2']))."'
						  WHERE `id` = ".$_POST['itemid']." LIMIT 1");

			                     	// `present` = '".$from.":".$user['id']."', - �������� � ����� ��� ���������!

					        //new_delo
						$rec = array();
				    		$rec['owner']=$user['id'];
						$rec['owner_login']=$user['login'];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money']-3;
						$rec['target']=448;
						$rec['target_login']="�������� �������";
						$rec['type']=207;//���� ������� � ���������
						$rec['sum_kr']=3;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=get_item_fid($item);
						$rec['item_name']=$item['name'];
						$rec['item_count']=1;
						$rec['item_type']=$item['type'];
						$rec['item_cost']=$item['cost'];
						$rec['item_dur']=$item['duration'];
						$rec['item_maxdur']=$item['maxdur'];
						$rec['item_ups']=$item['ups'];
						$rec['item_unic']=$item['unik'];
						$rec['item_incmagic']=$item['includemagicname'];
						$rec['item_incmagic_count']=$item['includemagicuses'];
						$rec['item_arsenal']='';
						$rec['add_info']=$to['login'];
						add_to_new_delo($rec); //�����

						mysql_query("UPDATE users set money=money-3 where id='{$user[id]}' LIMIT 1");
						$user[money]-=3;

						SetMsgF("������� ����� ��������� � &quot;".$_POST['to_login']."&quot; ".date("d.m.Y",$present_time)." � �������");
						RedirectF("?present=1");
					} else {
						SetMsgF("� ��� ������������ ����� �� ���������� ��������...","e");
						RedirectF("?present=1");
					}
				}
			}
		}
	} else {
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			SetMsgF("������� ����� ��������� ��� �������","e");
			RedirectF("?present=1");
		}
	}

?>

<form method="post" id = "presentform">
<TABLE cellspacing=0 cellpadding=0 width=100% bgcolor=#e0e0e2><TR><TD>
<INPUT TYPE=hidden name=present value=1>
<INPUT TYPE=hidden id="itemid" name="itemid" value=1>
�� ������ �������� ����� ��� �������� �������� ��������. ��� ������� ����� ������������ � ���������� � ���������.
<OL>
<LI>������� ����� ���������, �������� ������ ��������<BR>
<INPUT TYPE=text NAME=to_login value="">

<LI>���� �������. ����� ������������ � ���������� � ��������� (�� ����� 60 ��������)<BR>
<INPUT TYPE=text NAME=podarok2 value="" maxlength=60 size=50>
<LI>�������� ����� ���������������� ������� (� ���������� � ��������� �� ������������)<BR>
<TEXTAREA NAME=txt ROWS=6 COLS=80></TEXTAREA>
<LI>��������, �� ����� ����� �������:<BR>
<INPUT TYPE=radio NAME=from value=0 checked> <?php echo nick_hist($user);?><BR>
<? if (ADMIN) {?>
<INPUT TYPE=radio NAME=from value=0 > �� ������ �����<BR>
<?}?>
<INPUT TYPE=radio NAME=from value=1 > ��������<BR>
<INPUT TYPE=radio NAME=from <?php if ($user['klan'] == "") echo "disabled"; ?> value=2 > �� ����� �����<BR>
<? if (ADMIN) {?>
<LI>������� ����� ���������, �� ����� �������� ������ �������� ������� (����� �������� ������)<BR>
<INPUT TYPE=text NAME=from_admin value="">
<?}?>
<LI> �������� ������� ��� ������ (������ ������� <b>3 ��</b>)
<input type='text' readonly="true"  name='f_date' class='enter1'  value='<?php echo date("d.m.Y",time())?>' style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' id="calendar-inputField1">
<input type=button id="calendar-trigger1" style="width:20px;height:20px;" value='...'>
	<script>
	Calendar.setup({
        trigger    : "calendar-trigger1",
        inputField : "calendar-inputField1",
		dateFormat : "%d.%m.%Y",
		onSelect   : function() { this.hide() }
    			});
	document.getElementById('calendar-trigger1').setAttribute("type","BUTTON");
	</script>
<br>
<small>�� ������ ������� ���� ��������. ������� ����� ��������� � ������� ���������� �����!
������������� ������ ��� �������� ����, ������� �� ���������� ��� � �������.
��� ����������� ����������� ���� ��� �����, ������� ����� ��������� ���������� � ��� ���. �����.</small>

<LI>������� ������ <B>��������</B> ����� � ���������, ������� ������ ����������� � �������:<BR>
</OL>

<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?php
$data = mysql_query("SELECT * FROM oldbk.`inventory` USE INDEX (owner_4) WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND ((`prototype` >= 55510000 AND `prototype` <= 55520000) OR `prototype` = 20000 OR type = 200 or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts2).")))  AND `setsale` = 0 AND (`present` = '' or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts).")) or (present != '' and sowner = ".$user['id']." and prototype IN (".implode(",",$exgifts2)."))) and ekr_flag = 0 ORDER by `update` DESC; ");
while($row = mysql_fetch_array($data)) {
	if(!in_array($row['id'],array_keys($_SESSION['flowers']))) {
		$row['count'] = 0;
		$row['avacount'] = 0;
		$row[GetShopCount()] = 1;
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"http://i.oldbk.com/i/sh/{$row['img']}\" BORDER=0>";
		?>

		<BR><div class="button-mid btn" onclick="$('#itemid').val('<?=$row['id']?>');$('#presentform').submit();">��������</div>
		</TD>

		<?php
		echo "<TD valign=top>";
		showitem ($row);
		echo "</TD></TR>";
	}
}
?>
</table>
</td></tr></table>
</form>
<?php
} elseif (isset($_REQUEST['make'],$_REQUEST['rid'])) {
	?>
        <table cellspacing="0" cellpadding="0" class="table border">
            <colgroup>
                <col width="150px">
                <col>
                <col>
            </colgroup>
            <tbody>
	<?php

	$head = '
	<tr class="title">
		<td colspan="3" class="center">
			%TEXT%
		</td>
	</tr>
	';


	// 0 ����
	// 1 ������
	// 2 �����
	$goodids = array(0,1);
	//$goodids = array(0,1);
	if (!in_array($_REQUEST['rid'],$goodids)) die();

	require_once("craft_config.php");
	require_once("craft_functions.php");

	$id = intval($_REQUEST['rid']);

	if (isset($_GET['cid'])) {
		$cid = intval($_GET['cid']);

		$q = mysql_query('START TRANSACTION') or RedirectF();


		if (!ADMIN) {
			$defsql = ' AND is_enabled = 1';
		} else {
			$defsql = "";

		}

		$q = mysql_query('SELECT * FROM craft_formula WHERE craftloc = 34 and craftrazdel = '.$id.' and craftid = '.$cid.$defsql) or RedirectF();
		$rc = mysql_fetch_assoc($q) or RedirectF();

		// �������� ��� ����� �� �������
		$resproto = array();
		if (strlen($rc['craftnres'])) {
			// �������� ��� �����
			$pr = unserialize($rc['craftnres']);
			if ($pr !== false) {
				while(list($k,$v) = each($pr)) {
					$resproto[$k] = $v;
				}
			}
		}

		$res = array();

		// �������� � �������
		if ($id == 1 && isset($_GET['vaza'])) {
			// ��� ����
			$resproto[30012] = 1;
		}

		$qr = mysql_query('SELECT prototype, COUNT(*) as cc FROM inventory WHERE owner = '.$user['id'].' and prototype IN ('.implode(",",array_keys($resproto)).') and dressed = 0 and setsale = 0 GROUP BY prototype') or RedirectF();
		while($row = mysql_fetch_assoc($qr)) {
			$res[$row['prototype']] = $row['cc'];
		}

		// ��������� �������
		$pr = unserialize($rc['craftnres']);
		if ($id == 1 && isset($_GET['vaza'])) {
			$pr[30012] = 1;
		}

		if ($pr !== false) {
			while(list($k,$v) = each($pr)) {
				// $k - �����, $v - �����
				if ($res[$k] < $v) {
					SetMsgF("������������ �������� ����� ������� �������","e");
					RedirectF("?make=1&rid=".$id);
				}
			}
		}


		// ������� ��������� �������� ��� ������
		$ids = array();
		reset($pr);
		while(list($k,$v) = each($pr)) {
			$q = mysql_query('SELECT * FROM inventory WHERE owner = '.$user['id'].' and prototype = '.$k.' and setsale = 0 and dressed = 0 LIMIT '.($v)) or RedirectF();
			if (mysql_num_rows($q) != $v) {
				SetMsg("������������ �������� ����� ������� �������","e");
				RedirectF("?make=1&rid=".$id);
			}
			while($row = mysql_fetch_assoc($q)) {
				$ids[] = $row['id'];
			}
		}


		$q = mysql_query('SELECT * FROM inventory WHERE id IN ('.implode(",",$ids).') and owner = '.$user['id'].' and setsale = 0 and dressed = 0 LIMIT '.count($ids)) or RedirectF();
		$aids = [];

		while($row = mysql_fetch_assoc($q)) {
			$aids[] = get_item_fid($row)."/".$row['name'];
		}

		mysql_query('DELETE FROM inventory WHERE id IN ('.implode(",",$ids).') and owner = '.$user['id'].' and setsale = 0 and dressed = 0 LIMIT '.count($ids)) or RedirectF();

		$dress = CraftGetItem($rc['craftprotoid'],$rc['craftprototype']);
		if (!$dress) die();

		$count = $rc['craftprotocount'];

		// ����� ������ �� �����
		$str = "";
		$sql = "";

		if($dress['nlevel'] > 6) {
			$str = ",`up_level` ";
			$sql = ",'".$dress['nlevel']."' ";
		}

		$dress['sebescost'] = 0;

		if ($id == 1 && isset($_GET['vaza'])) {
			// ����
			if ($dress['goden']) $dress['goden'] *= 3;
		}

		if(isset($dress['goden']) && $dress['goden'] > 0) {
            		$DateTime = new \DateTime();
            		$DateTime->modify(sprintf('+%d days', $dress['goden']));
           		$dress['dategoden'] = $DateTime->getTimestamp();
		}

		if ($rc['craftgoden'] > 0) {
			$dress['goden'] = $rc['craftgoden'];
            		$DateTime = new \DateTime();
            		$DateTime->modify(sprintf('+%d days', $dress['goden']));
           		$dress['dategoden'] = $DateTime->getTimestamp();
		}

		if ($rc['craftis_present'] > 0 && strlen($rc['craftpresent'])) {
			$dress['present'] = $rc['craftpresent'];
		}

		if ($rc['craftnotsell'] > 0) {
			$dress['notsell'] = $rc['craftnotsell'];
		}

		if ($rc['craftsowner'] > 0) {
			$dress['sowner'] = $user['id'];
		}

		if ($rc['craftunik'] > 0) {
			$dress['unik'] = $rc['craftunik'];
		}

		if ($dress['id'] >= 946 && $dress['id'] <=957) {
			$dress['isrep'] = 1;
		}


		$allids = array();

		for ($i = 0; $i < $count; $i++) {
			$q = mysql_query("INSERT INTO oldbk.`inventory`
					(`prototype`,`sowner`,`present`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`idcity`, `includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`, `ab_mf`,  `ab_bron` ,  `ab_uron`, `img_big`,
						`nclass`,`otdel`,`gmp`,`gmeshok`, `group`,`letter`,`rareitem`,`stbonus`,`mfbonus`,`unik`,`notsell`,`craftspeedup`,`craftbonus`,`craftedby`,`getfrom`,`sebescost` ".$str."
						)
						VALUES
						('{$dress['id']}','{$dress['sowner']}','{$dress['present']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
						'{$dress['nalign']}','{$dress['dategoden']}','{$dress['goden']}','{$user['id_city']}' , '{$dress['includemagic']}','{$dress['includemagicdex']}','{$dress[includemagicmax]}','{$dress['includemagicname']}','{$dress['includemagicuses']}','{$dress['includemagiccost']}','{$dress['includemagicekrcost']}', '{$dress['ab_mf']}',  '{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['img_big']}'
						,'{$dress['nclass']}','{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['rareitem']}','{$dress['stbonus']}','{$dress['mfbonus']}','{$dress['unik']}','{$dress['notsell']}','{$dress['craftspeedup']}','{$dress['craftbonus']}','','31','{$dress['sebescost']}' ".$sql.")
			") or RedirectF();

			$allids[] = "cap".mysql_insert_id();
		}


		$allidsc = count($allids);
		$allids = implode(",",$allids);

		$rec['owner']=$user['id'];
		$rec['owner_login']=$user['login'];
		$rec['owner_balans_do']=$user['money'];
		$rec['owner_balans_posle']=$user['money'];
		$rec['target']=0;
		$rec['target_login']="��������� ���.";
		$rec['type'] = 1305;
		$rec['sum_kr'] = 0;
		$rec['sum_ekr'] = 0;
		$rec['sum_kom'] = 0;
		$rec['item_id']=$allids;
		$rec['item_name']=$dress['name'];
		$rec['item_count']=$allidsc;
		$rec['item_type']=$dress['type'];
		$rec['item_cost']=$dress['cost'];
		$rec['item_dur']=$dress['duration'];
		$rec['item_maxdur']=$dress['maxdur'];
		$rec['aitem_id']=implode(",",$aids);
		$rec['item_ups']=0;
		$rec['item_unic']=0;
		add_to_new_delo($rec) or RedirectF();

		$q = mysql_query('COMMIT') or RedirectF();

		$txt = '������� ������ ������� �<a target="_blank" href="http://oldbk.com/encicl/'.link_for_item($dress,true).'.html"><b>'.$dress['name'].'</b></a>� � ���������� '.($count).' ��.';
		SetMsgF(strip_tags($txt,'<b>'),"s");
		//addchp ('<font color=red>��������!</font> '.$txt,'{[]}'.$user['login'].'{[]}',-1,$user['id_city']) or RedirectF();


		//QUEST EVENT make_flower
		try {
			$User = new \components\models\User($user);
			$Quest = $app->quest
				->setUser($User)
				->get();
			$Checker = new \components\Component\Quests\check\CheckerEvent();
			$Checker->event_type = \components\Component\Quests\pocket\questTask\EventTask::EVENT_MAKE_FLOWER;

			if(($Item = $Quest->isNeed($Checker)) !== false) {
				$Quest->taskUp($Item);
			}

		} catch (Exception $ex) {

		}

		RedirectF("?make=1&rid=".$id);
	}


	if (!isset($_SESSION['fshoppage'.$id])) $_SESSION['fshoppage'.$id] = 0;
	if (isset($_GET['page'])) {
		if ($_GET['page'] !== "all") {
			$_GET['page'] = intval($_GET['page']);
		}
		$_SESSION['fshoppage'.$id] = $_GET['page'];
	}


	$defsql = " and is_enabled = 1 ";
	if (ADMIN) $defsql = "";

	$query = '
		SELECT %COUNT% FROM (
			(SELECT  * FROM craft_formula
				LEFT JOIN shop ON craft_formula.craftprotoid = shop.id
				WHERE craft_formula.craftprototype = 1 and is_deleted = 0 '.$defsql.' and craftloc = 34 AND craftrazdel = '.$id.' '.$addsql.'
			)
			UNION
			(SELECT  * FROM craft_formula
				LEFT JOIN eshop ON craft_formula.craftprotoid = eshop.id
				WHERE craft_formula.craftprototype = 2 and is_deleted = 0 '.$defsql.' and craftloc = 34 AND craftrazdel = '.$id.' '.$addsql.'
			)
			UNION
			(SELECT  * FROM craft_formula
				LEFT JOIN cshop ON craft_formula.craftprotoid = cshop.id
				WHERE craft_formula.craftprototype = 3 and is_deleted = 0 '.$defsql.' and craftloc = 34 AND craftrazdel = '.$id.' '.$addsql.'
			)
		) as allitems %VIEWB% ORDER BY allitems.craftcomplexity ASC,allitems.cost ASC
	';

	if (isset($viewb) && $viewb > 0 && $id == 1) {
		$tmp = "";
		if ($viewb == 1) $tmp = " wHERE allitems.goden = 7";
		if ($viewb == 2) $tmp = " WHERE allitems.goden = 10";
		if ($viewb == 3) $tmp = " WHERE allitems.goden = 20";

		$query = str_replace('%VIEWB%',$tmp,$query);
	} else {
		$query = str_replace('%VIEWB%','',$query);
	}


	// ������� �����
	$count = mysql_query_cache(str_replace("%COUNT%","count(*) as cc",$query),false,5*60);

	// ���� �������
	$q = mysql_query_cache(str_replace("%COUNT%","*",$query.MakeLimitF($id)),false,5*60);

	$p = MakePagesF($id,$count[0]['cc']);
	if ($p) {
		if (isset($viewb) && $viewb == 4 && $id == 1) {
			// �� ���������� ��������
		} else {
			echo str_replace("%TEXT%",$p,$head);
		}
	}

	$res = array();

	// �������� ��� ����� �� �������
	$resproto = array();
	while(list($k,$row) = each($q)) {
		if (strlen($row['craftnres'])) {
			// �������� ��� �����
			$pr = unserialize($row['craftnres']);
			if ($pr !== false) {
				while(list($k,$v) = each($pr)) {
					$resproto[$k] = $v;
				}
			}
		}

	}

	// ��������� ����
	if ($id == 1) {
		$resproto[30012] = 1;
	}

	// �������� � �������
	$qr = mysql_query('SELECT prototype, COUNT(*) as cc FROM inventory WHERE owner = '.$user['id'].' and prototype IN ('.implode(",",array_keys($resproto)).') and dressed = 0 and setsale = 0 GROUP BY prototype');
	while($row = mysql_fetch_assoc($qr)) {
		$res[$row['prototype']] = $row['cc'];
	}

	$out = "";
	$i = 0;

	reset($q);
	while(list($k,$row) = each($q)) {
		if (isset($viewb) && $viewb == 4 && $id == 1) {
			$pr = unserialize($row['craftnres']);
			if ($pr !== false) {
				while(list($k,$v) = each($pr)) {
					// $k - �����, $v - �����
					if ($res[$k] < $v) {
						continue 2;
					}
				}
			}

		}
		$out .= renderfshopitem($row,$user,$res,$i);
	}

	echo $out;
	echo '</table>';
} else {
	?>
	<table class="table border a_strong" cellspacing="0" cellpadding="0">
		<colgroup>
			<col width="100px">
			<col>
		</colgroup>
		<tbody>
		<tr class="even2">

	<?php
	if (((time()>$KO_start_time22) and (time()<$KO_fin_time22)) and ($otdel==60) ) {
		//������ ������
		$data = mysql_query('select * from shop where id>=410001 and id<=410008 order by cost ASC') or die();
	} else {
		// ��������� ������ � ��������
		$data = mysql_query('SELECT * FROM oldbk.`eshop` WHERE `'.GetShopCount().'` > 0 AND glava = 0 AND `razdel` = '.$otdel.' and cost > 0 '.$ugiftsql.' ORDER by cost ASC') or die();
	}

	while($row = mysql_fetch_array($data)) {
		if ( (!((time()>$KO_start_time22) and (time()<$KO_fin_time22))) and ($otdel==60) ) {
			continue;
		} elseif($otdel==60) {
			$row['count']=9999;
			$row['present']='�����';
		}


		if ($row['id']==2016002)
			{
			$row['present']='�����������';
			$row['goden_do'] = mktime(23,59,59,4,15);
			$row['goden'] = round(($row['goden_do'] -time())/60/60/24); if ($row[goden]<1) {$row[goden]=1;}
			}

		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"http://i.oldbk.com/i/sh/{$row['img']}\" BORDER=0>";
		echo '<BR><a HREF="?otdel='.$otdel.'&set='.$row['id'].'&sid=">������</a>';
		echo " <IMG SRC=\"http://i.oldbk.com/i/up.gif\" WIDTH=11 HEIGHT=11 BORDER=0 ALT=\"������ ��������� ����\" style=\"cursor: pointer\" onclick=\"AddCount(event,'{$row['id']}', '{$row['name']}','')\">";
		echo "<TD valign=top>";

		showitem ($row);
		echo "</TD></TR>";
	}
	?> </table>
<?php } ?>
	</td><td style="vertical-align:top;">
                    <table id="filter" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td align="left">
                                <strong>��� ���� ����� �����
				<?php
					$d[0] = getmymassa($user);
					echo $d[0];?>/<?=get_meshok()?>
				</strong><br>
                                � ��� � �������: <span class="money"><strong><?=$user['money']?></strong></span><strong> ��.</strong><br>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="filter-title">�����</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
					<A HREF="?otdel=12&tmp=<?echo mt_rand(1111111,9999999);?>">����������� ��� ������� � ����</A>
                                    </li>
                                    <li>
					<A HREF="?otdel=14&tmp=<?echo mt_rand(1111111,9999999);?>">������� ������</A>
                                    </li>
				    <?php
				    if ( ((time() >= $KO_start_time22) && (time() < $KO_fin_time22 )) ) { ?>
                                    <li>
					<A HREF="?otdel=60&tmp=<?echo mt_rand(1111111,9999999);?>">������ ������</A>
                                    </li>

				    <?php } ?>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <td class="filter-title">��������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
					<A HREF="?otdel=7&tmp=<?echo mt_rand(1111111,9999999);?>">��������</A>
                                    </li>

                                    <li>
					<A HREF="?otdel=71&tmp=<?echo mt_rand(1111111,9999999);?>">�������</A>
                                    </li>
                                    <!--
                                    <li>
					<A HREF="?otdel=76&tmp=<?echo mt_rand(1111111,9999999);?>">������� �������</A>
                                    </li>

                                    <li>
					<A HREF="?otdel=73&tmp=<?echo mt_rand(1111111,9999999);?>">��-2018</A>
                                    </li>


                                    <li>
					<A HREF="?otdel=73&tmp=<?echo mt_rand(1111111,9999999);?>">1 ���</A>
                                    </li>

                                    <li>
					<A HREF="?otdel=73&tmp=<?echo mt_rand(1111111,9999999);?>">8 �����</A>
                                    </li>
					-->
					
                                    <li>
					<A HREF="?otdel=76&tmp=<?echo mt_rand(1111111,9999999);?>">������ �������</A>
                                    </li>
<!--					
                                    <li>
					<A HREF="?otdel=79&tmp=<?echo mt_rand(1111111,9999999);?>">���������</A>
                                    </li>

					
                                    <li>
					<A HREF="?otdel=73&tmp=<?echo mt_rand(1111111,9999999);?>">23 ������� </A>
                                    </li>
					-->
					<!--
                                    <li>
					<A HREF="?otdel=73&tmp=<?echo mt_rand(1111111,9999999);?>">���������� �������</A>
                                    </li>
                                    <li>
					<A HREF="?otdel=74&tmp=<?echo mt_rand(1111111,9999999);?>">���������� �������</A>
                                    </li>
                                    <li>
					<A HREF="?otdel=73&tmp=<?echo mt_rand(1111111,9999999);?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1 ��������</A>
                                    </li>

                                    <li>
					<A HREF="?otdel=77&tmp=<?echo mt_rand(1111111,9999999);?>">���������� �������</A>
                                    </li>

                                    <li>
					<A HREF="?otdel=78&tmp=<?echo mt_rand(1111111,9999999);?>">�����</A>
                                    </li>

                                    <li>
					<A HREF="?otdel=77&tmp=<?echo mt_rand(1111111,9999999);?>">9 ���</A>
                                    </li>

					<A HREF="?otdel=73&tmp=<?echo mt_rand(1111111,9999999);?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��������</A>
					-->
                                    <li>
					<A HREF="?otdel=72&tmp=<?echo mt_rand(1111111,9999999);?>">���������� �������</A>
                                    </li>

                                    <li>
					<A HREF="?otdel=75&tmp=<?echo mt_rand(1111111,9999999);?>">��������� ����������</A>
                                    </li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <td class="filter-title">��������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
					<A HREF="?make=1&rid=1">������� �����</A>
                                    </li>
                                    <li>
					<A HREF="?make=1&rid=0">������� ����</A>
                                    </li>
					<!--
                                    <li>
                                        <A HREF="?make=1&rid=2">������� �� ����</A>
                                    </li>
					-->

                                    <li>
                                        <a HREF="?present=1&tmp=<?=mt_rand(1111,9999);?>">������� �������</a>
                                    </li>
                                    <li>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
        </td>
        </tr>
        </tbody>
        </table>
<?php
	make_quest_div();
	include "end_files.php";

?>
<!--Rating@Mail.ru counter-->
<div align=left><script language="javascript" type="text/javascript"><!--
d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
<script language="javascript1.1" type="text/javascript"><!--
a+=';j='+navigator.javaEnabled();js=11;//--></script>
<script language="javascript1.2" type="text/javascript"><!--
s=screen;a+=';s='+s.width+'*'+s.height;
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
<script language="javascript1.3" type="text/javascript"><!--
js=13;//--></script><script language="javascript" type="text/javascript"><!--
d.write('<a href="http://top.mail.ru/jump?from=1765367" target="_top">'+
'<img src="http://df.ce.ba.a1.top.mail.ru/counter?id=1765367;t=49;js='+js+
a+';rand='+Math.random()+'" alt="�������@Mail.ru" border="0" '+
'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_top" href="http://top.mail.ru/jump?from=1765367">
<img src="http://df.ce.ba.a1.top.mail.ru/counter?js=na;id=1765367;t=49"
height="31" width="88" border="0" alt="�������@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script></div>
<!--// Rating@Mail.ru counter-->
</div>

<div style="width:300px;display:none;" id="hint3" class="ahint"></div>
</BODY>
</HTML>
<?

if (isset($miniBB_gzipper_encoding)) {
	$miniBB_gzipper_in = ob_get_contents();
	$miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
	ob_clean();
	header('Content-Encoding: '.$miniBB_gzipper_encoding);
	echo $miniBB_gzipper_out;
}
?>
