<?php
include "/www/capitalcity.oldbk.com/cron/init.php";
include "/www/capitalcity.oldbk.com/bank_functions.php";

function EchoLog($txt) {
	echo date("[d/m/Y H:i:s]: ").$txt."\r\n";
}


function mk_my_item($telo,$proto,$addinfo,&$img) {
	$telo = mysql_fetch_assoc(mysql_query('SELECT * FROM users WHERE id = '.$telo));
	$count = 1;

	if (($pos = strpos($proto,'_')) !== false) {
		$proto = substr($proto,0,$pos);
		EchoLog("New proto: ".$proto);
	} elseif ($proto === 'zodiak') {
		$t = get_mag_stih($telo);
		// $t[0] - �� 1 �� 4, 1 - �����, 2 - �����, 3 - ������, 4 - ����
		if (!isset($t[0]) || empty($t[0])) $t[0] = mt_rand(1,4);
		if ($t[0] == 1) $proto = 150157;
		if ($t[0] == 2) $proto = 920927;
		if ($t[0] == 3) $proto = 130137;
		if ($t[0] == 4) $proto = 930937;
	} elseif (($pos = strpos($proto,'i')) === 0) {
		$name = substr($proto,1);
		EchoLog("i copy: ".$name);

		// ��������
		$q = mysql_query('SELECT * FROM oldbk.inventory WHERE owner = 477 and battle = 0 and name = "'.$name.'"');
		$flds = array();
		for ($i = 0;;$i++) {
			$n = mysql_field_name($q,$i);
			if (!$n || $n == "") break;
			$flds[] = $n;
		}
		unset($flds[0]);

		$qs = 'INSERT INTO oldbk.inventory (';
		$fl = "";
		$pos = 0;
		while(list($k,$v) = each($flds)) {
			$fl .= "`".$v."`,";
			if ($v == "art_param") $pos = $k;
		}
		$fl = substr($fl,0,strlen($fl)-1);
		$qs .= $fl;
		$qs .= ') VALUES (';

		$qq = "";
		$dress = mysql_fetch_assoc($q);
		$dress['owner'] = $telo['id'];
		$dress['present'] = "�����";
		$dress['update'] = date('Y-m-d H:i:s');

		$i2 = 0;
		$qq = $qs;
		while(list($k,$v) = each($dress)) {
			$i2++;
			if ($i2 < 2) continue;
			if ($pos > 0 && $pos == $i2-1) {
				if (strlen($v)) {
					$qq .= '"'.mysql_real_escape_string($v).'",';
				} else {
					$qq .= 'NULL,';
				}
			} else {
				$qq .= '"'.mysql_real_escape_string($v).'",';
			}
		}
		$qq = substr($qq,0,strlen($qq)-1);
		$qq .= ')';
		mysql_query($qq);

		$rec['owner']=$telo['id'];
		$rec['owner_login']=$telo['login'];
		$rec['target']=0;
		$rec['target_login']='������� ����������';
		$rec['owner_balans_do']=$telo['money'];
		$rec['owner_balans_posle']=$telo['money'];
		$rec['type']=393;//   ������� �� �����
		$rec['sum_kr']=0;
		$rec['sum_ekr']=$dress['ecost'];
		$rec['sum_kom']=0;
		$dress['id'] = mysql_insert_id();
		$rec['item_id']=get_item_fid($dress);
		$rec['item_name']=$dress['name'];
		$rec['item_count']=1;
		$rec['item_type']=$dress['type'];
		$rec['item_cost']=$dress['cost'];
		$rec['item_dur']=$dress['duration'];
		$rec['item_maxdur']=$dress['maxdur'];
		$rec['item_ups']=0;
		$rec['item_unic']=1;
		$rec['item_incmagic']=$dress['includemagic'];
		$rec['item_incmagic_count']=$dress['includemagicdex'];
		$rec['item_arsenal']='';
		add_to_new_delo($rec);

		$img = $dress['img'];

		return $name;
	} elseif (strpos($proto,'repmoney') === 0) {
		$repmoney = substr($proto,8);
		EchoLog('repmoney: '.$repmoney);
		mysql_query('UPDATE users SET repmoney = repmoney + '.$repmoney.' WHERE id = '.$telo['id']);

		$rec['owner']=$telo[id];
		$rec['owner_login']=$telo[login];
		$rec['owner_balans_do']=$telo['money'];
		$rec['owner_balans_posle']=$telo['money'];
		$rec['owner_rep_do']=$telo['repmoney'];
		$rec['owner_rep_posle']=$telo['repmoney']+$repmoney;
		$rec['target']=0;
		$rec['target_login']='������� ����������';
		$rec['type']=371;
		$rec['sum_rep']=$repmoney;
		add_to_new_delo($rec);

		$img = "batt_repa.gif";

		return $repmoney." ���������";
	} elseif (strpos($proto,'winstbat') === 0) {
		$winstbat = substr($proto,8);
		EchoLog('Winstbat: '.$winstbat);
		mysql_query('UPDATE users SET winstbat = winstbat + '.$winstbat.' WHERE id = '.$telo['id']);

		$rec['owner']=$telo['id'];
		$rec['owner_login']=$telo['login'];
		$rec['owner_balans_do']=$telo['money'];
		$rec['owner_balans_posle']=$telo['money'];
		$rec['target']=0;
		$rec['target_login']='������� ����������';
		$rec['type']=392;
		$rec['add_info']=$winstbat;
		add_to_new_delo($rec);

		$img = "fighttype3.gif";

		return $winstbat." ������� �����";
	} else {
		EchoLog('Standart proto: '.$proto);
	}

	if ($addinfo['shop'] == 0) {
		$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$proto}' ;"));
	} elseif ($addinfo['shop'] == 1) {
		$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$proto}' ;"));
	} elseif ($addinfo['shop'] == 2) {
		$dress=mysql_fetch_array(mysql_query("select * from oldbk.cshop where id='{$proto}' ;"));
	}

	$dress['present'] = "�����";
	if (isset($addinfo['maxdur'])) $dress['maxdur'] = $addinfo['maxdur'];
	if (isset($addinfo['count'])) $count = $addinfo['count'];

	if ($dress['magic'] > 0) {
		// 1) �������� ��� ������
		// 2) ���� �������� 7 ����
		$dress['present'] = '�����';
		$dress['goden'] = 7;
	}

	$dress['is_owner'] = 0;

	if ($proto == 9597 || $proto == 9598 || $proto == 190199 || $proto == 190191 || $proto == 190192) {
		$dress['goden'] = 0;
		$dress['is_owner'] = $telo['id'];
	}


	if ($dress['id'] > 0) {
		for ($i = 0; $i < $count; $i++) {
                        $dress['id'] = $proto;
			if(mysql_query("INSERT INTO oldbk.`inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,`letter`,
				`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
				`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
				`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`nsex`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`arsenal_klan` , `arsenal_owner`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`,`includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`,`present`,`sowner`
				)
				VALUES
					('{$dress['id']}','{$telo[id]}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['letter']}','{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress[nsex]}',
					'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."',
					'{$dress['goden']}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','','','{$telo[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}', '{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}' , '{$dress['present']}', '{$dress['is_owner']}'
					) ;"))
				{

				$good = 1;
				$insert_item_id=mysql_insert_id();
				$dress['idcity']=$telo['id_city'];
				$dress['id']=$insert_item_id;
	        	} else {
				$good = 0;
			}


			if ($good) {
				$rec['owner']=$telo[id];
				$rec['owner_login']=$telo[login];
				$rec['target']=0;
				$rec['target_login']='������� ����������';
				$rec['owner_balans_do']=$telo[money];
				$rec['owner_balans_posle']=$telo[money];
				$rec['type']=393;//   ������� �� �����
				$rec['sum_kr']=0;
				$rec['sum_ekr']=$dress['ecost'];
				$rec['sum_kom']=0;
				$rec['item_id']=get_item_fid($dress);
				$rec['item_name']=$dress['name'];
				$rec['item_count']=1;
				$rec['item_type']=$dress['type'];
				$rec['item_cost']=$dress['cost'];
				$rec['item_dur']=$dress['duration'];
				$rec['item_maxdur']=$dress['maxdur'];
				$rec['item_ups']=0;
				$rec['item_unic']=1;
				$rec['item_incmagic']=$dress['includemagic'];
				$rec['item_incmagic_count']=$dress['includemagicdex'];
				$rec['item_arsenal']='';
				add_to_new_delo($rec);
			} else {
				EchoLog("false");
			}
		}
		$addtxt = "";
		if ($count > 1) $addtxt = ' (x'.$count.')';
		$img = $dress['img'];
		return $dress['name'].$addtxt;
	} else {
		EchoLog("false:".$proto);
		return false;
	}
}

if( !lockCreate("cron_mshow") ) {
    exit("Script already running.");
}

$maxpp = 2;

// ������ ���� �� 0.1 ���
$q = mysql_query('SELECT users.*,inventory.owner,count(*) as ccount FROM inventory LEFT JOIN users ON users.id = inventory.owner WHERE prototype = 3006000 GROUP BY owner');

if (mysql_num_rows($q) == 0) {
	// �������� ���, ��������
	EchoLog("No items");
	lockDestroy("cron_mshow");
	die();
}



// ���� ������ 20 ���������� ��� �� ����������, �� ����� �������� 20 � ����
if (mysql_num_rows($q) <= 20) $maxpp = 20;

while($c = mysql_fetch_assoc($q)) {
	$bankid = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner=".$c['owner']." order by def desc,id limit 1"));

	EchoLog("bank: ".$bankid['id'].":".$c['owner'].":".$c['login'].":".($c['ccount']*0.1));

	make_ekr_add_bonus($c,$bankid,null,($c['ccount']*0.1),1);

	$txt = '<font color=red>��������!</font> �� �������� '.($c['ccount']*0.1).' ��� �� ���� �'.$bankid['id'].' �� ����� &quot;������� ����������&quot;.';
	if($c['odate'] > (time()-60)) {
		addchp($txt,'{[]}'.$c['login'].'{[]}',-1,-1);
	} else {
		mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$c['owner']."','','".$txt."')");
	}

}

EchoLog("Maxpp: ".$maxpp);

// ������, 0 - shop, 1 - eshop
$ilist = array(
	200021 => array('shop' => 0), // ������� ������ ������ ������
	200022 => array('shop' => 0), // ������� ������ ������ ������
	571 => array('shop' => 0), // ������ ����
	572 => array('shop' => 0), // ������ ����
	573 => array('shop' => 0), // ������ ����
	574 => array('shop' => 0), // ������ ����
	575 => array('shop' => 0), // ������ ����
	576 => array('shop' => 0), // ������ ����
	577 => array('shop' => 0), // ������ ����
	578 => array('shop' => 0), // ������ ����
	579 => array('shop' => 0), // ������ ����
	580 => array('shop' => 0), // ������ ����
	"repmoney300" => array(), // ����
	"repmoney600" => array(),
	"repmoney1000" => array(),
	"repmoney1500" => array(),
	"repmoney2000" => array(),
	3203 => array('shop' => 1), // ��� 20
	3204 => array('shop' => 1), // ��� 50
	3205 => array('shop' => 1), // ��� 100
	15561 => array('shop' => 0), // ������� ������
	15562 => array('shop' => 0),
	15563 => array('shop' => 0),
	15564 => array('shop' => 0),
	15565 => array('shop' => 0),
	15566 => array('shop' => 0),
	15567 => array('shop' => 0),
	15568 => array('shop' => 0),
	103 => array('shop' => 0), // ����� 30 ���
	156 => array('shop' => 1), // ����
	157 => array('shop' => 1), // ���� ����
        "zodiak" => array('shop' => 0), // ������������
	55556 => array('shop' => 0), // ������ �� ����� 0/10 �� ���
	55560 => array('shop' => 0), // ����� ������ ������� �� �����
	55557 => array('shop' => 1), // ������� ������ ������� �� �����
	55558 => array('shop' => 1),  // ������� ������ ������� �� �����
	3001002 => array('shop' => 1), // ���� ����� 150%
	3001003 => array('shop' => 1), // ���� ������� 170%
	3001004 => array('shop' => 1), // ���� ������ 100%
	9597 => array('shop' => 0), // ��������
	9598 => array('shop' => 1), // ��������
	4005 => array('shop' => 0), // ���� �� ����
	4017 => array('shop' => 0), // ���� �� ����
        2206 => array('shop' => 1), // ����� �� ���
        353 => array('shop' => 1), // ������
	14005 => array('shop' => 0), // ������ III
        14004 => array('shop' => 1),  //8 ������
        121121121 => array('shop' => 1), // ����
        301 => array('shop' => 1), // �����
        40000000 => array('shop' => 0), // �������
        3333 => array('shop' => 1), // ���� 666
        4002 => array('shop' => 1), // ������� 0/10
        15003 => array('shop' => 0), // ������ iii
        15004 => array('shop' => 1), // ������ iii
        119119 => array('shop' => 0), // ���� 0/2
        119119119 => array('shop' => 1), // ���� 0/3
        2525 => array('shop' => 1), // ��������
	5100 => array('shop' => 0), // ��������� ���� �������
        315 => array('shop' => 0), // ������� ������ ��������������� �����
        318 => array('shop' => 1), // ����
	271271 => array('shop' => 0), // ����� ������ ��������������� 360HP�
    	200273 => array('shop' => 1), // ������� ������ ��������������� 360HP�
        145145 => array('shop' => 1), // ��������� 0/5
	125125 => array('shop' => 0, 'maxdur' => 5), // ������� �����
	19102  => array('shop' => 1), // ���� +20%
);

function ashuffle (&$arr) {
     uasort($arr, function ($a, $b) {
         return rand(-1, 1);
     });
}

ashuffle($ilist);

$ilist2 = array(
//	3005000 => array('shop' => 0, 'need' => 2500), // �������
	2018160 => array('shop' => 0, 'need' => 300), // ����� ������ ������� ����������
	2018161 => array('shop' => 0, 'need' => 500), // ������� ������ ������� ����������
	2018162 => array('shop' => 0, 'need' => 1000), // ������� ������ ������� ����������
	2018163 => array('shop' => 0, 'need' => 1300), // ����������� ������ ������� ����������
	190199 => array('shop' => 2, 'need' => 300), // ����� +7
	190191 => array('shop' => 1, 'need' => 1300), // ����� +8
	190192 => array('shop' => 1, 'need' => 1500), // ����� +9
	542 => array('shop' => 0, 'need' => 500), // ���������� �� ������ �����
	535 => array('shop' => 0, 'need' => 400), // ���������� �� ���������� �������
	543 => array('shop' => 0, 'need' => 125), // ���������� �� ������ ��������
	533 => array('shop' => 0, 'need' => 500), // ���������� �� ������ �����
	538 => array('shop' => 0, 'need' => 50), // ���������� �� ������� ����
	539 => array('shop' => 0, 'need' => 250), // ���������� �� ������� ����
	"i����������� �������� �������� (��)" => array('prototype' => 100031, 'need' => 1300),
	"i���� ������������ ����� (��)" => array('prototype' => 7006, 'need' => 1300),
	1200001 => array('shop' => 0, 'need' => 50), // ������� ��������� ������� ��������� I
	1200002 => array('shop' => 0, 'need' => 100), // ������� ��������� ������� ��������� II
	1200003 => array('shop' => 0, 'need' => 150), // ������� ��������� ������� ��������� III
	1200004 => array('shop' => 0, 'need' => 200), // ������� ��������� ������� ��������� IV
	1200005 => array('shop' => 0, 'need' => 300), // ������� ��������� ������� ��������� V
	1200006 => array('shop' => 0, 'need' => 500), // ������� ��������� ������� ��������� VI
	56666 => array('shop' => 0, 'need' => 300), // ������� ��������� III
	540 => array('shop' => 0, 'need' => 200), //���������� �� ���������� ����� ���������� ���� � ��
	541 => array('shop' => 0, 'need' => 200),   //���������� �� ���������� ����� ��������� � ��
);

$listtodo = array();

ashuffle($ilist2);

// ����������� ��� � ��� � ������� �������
$varneed = mysql_fetch_assoc(mysql_query('SELECT * FROM variables_int WHERE var = "snowsell"'));
EchoLog(serialize($varneed));

$q = mysql_query('SELECT * FROM variables WHERE var = "snowsell2"');
$var = mysql_fetch_assoc($q);
if (empty($var['value'])) {
	EchoLog("New item2 circle");
	// ������ �����
	list($k,$v) = each($ilist2);
	unset($ilist2[$k]);
	$arr = array();
	$arr['current'] = array('k' => $k, 'v' => $v);
	$arr['ilist2'] = $ilist2;
	EchoLog("Set new item2: ".$k.":".serialize($v));
	mysql_query('UPDATE variables SET value = "'.mysql_real_escape_string(serialize($arr)).'" WHERE var = "snowsell2"');
	$var['value'] = $arr;
} else {
	$var['value'] = unserialize($var['value']);
}

EchoLog("Status: ".serialize($var['value']));


if ($varneed['value'] >= $var['value']['current']['v']['need']) {
	EchoLog("Adding item2 to loto: ".serialize($var['value']['current']));
	$listtodo[$var['value']['current']['k']] = $var['value']['current']['v'];

	// �������� �������
	mysql_query('UPDATE variables_int SET value = 0 WHERE var = "snowsell"');

	if (count($var['value']['ilist2'])) {
		EchoLog('Setting next item2');
		list($k,$v) = each($var['value']['ilist2']);
		unset($var['value']['ilist2'][$k]);

		$arr['current'] = array('k' => $k, 'v' => $v);
		$arr['ilist2'] = $var['value']['ilist2'];
		EchoLog("Set new item2: ".$k.":".serialize($v));
		mysql_query('UPDATE variables SET value = "'.mysql_real_escape_string(serialize($arr)).'" WHERE var = "snowsell2"');
	} else {
		EchoLog("Reseting ilist2 circle");
		mysql_query('UPDATE variables SET value = "" WHERE var = "snowsell2"');
	}
} else {
	EchoLog("Checked: ".$varneed['value'].":".$var['value']['current']['v']['need']);
}

if (count($listtodo) && $maxpp == 20) $maxpp++;


// ������
$i = 0;
while(list($k,$v) = each($ilist)) {
	if ($i >= 20) break;
	$listtodo[$k] = $v;
	$i++;
}

//$listtodo = array_reverse($listtodo,true);

$clist = array();
reset($listtodo);
$tosend = array();

$q = mysql_query('SELECT owner,login,odate,level FROM inventory LEFT JOIN users ON users.id = inventory.owner WHERE prototype = 3006000 ORDER BY RAND()');
//$q = mysql_query('SELECT owner,login,odate,level FROM inventory LEFT JOIN users ON users.id = inventory.owner WHERE level > 10 GROUP BY owner ORDER BY rand() LIMIT 100');

$firstitem = false;

while($i = mysql_fetch_assoc($q)) {
	if (!count($listtodo)) {
		// �� �������
		break;
	}

	EchoLog(serialize($i));
	if ($clist[$i['owner']] >= $maxpp) continue;


	reset($listtodo);
	list($k,$v) = each($listtodo);

	if ($firstitem == false) {
		// ������� ��� ��������
		$firstitem = true;
		/*
		$qtmp = mysql_query('SELECT owner,login,odate,level FROM inventory LEFT JOIN users ON users.id = inventory.owner WHERE users.id = 676084 LIMIT 1');
		$i = mysql_fetch_assoc($qtmp);
		*/
	}

	if (($k >= 571 && $k <= 580) || strpos($k,'repmoney') !== false) {
		// ������� ����������� ���������
		if ($i['level'] <= 6) {
			$min = 100;
		} else {
			$min = 100 - (($i['level'] - 6) * 10);
		}
		EchoLog("Min: ".$min);
		if (!(mt_rand(0,100) <= $min)) continue;
	}

	if ($k == 3005000 && $i['level'] > 10) continue;
	if (($k == 1000001 || $k == 1000002 || $k == 1000003) && $i['level'] < 10) continue;

	$clist[$i['owner']]++;

	if (isset($ilist2[$k]) && $maxpp != 20) {
		// ���� ������� �� ������� ������ �� ������ �� �������
		$clist[$i['owner']] = $maxpp;
	}

	unset($listtodo[$k]);

	EchoLog("Item ".$k." to ".$i['owner'].":".$i['login'].":".$i['level']);

	$img = "";
	$txtitem = mk_my_item($i['owner'],$k,$v,$img);
	if (strlen($txtitem)) {
		$txt = '<font color=red>��������!</font> �� �������� &quot;'.$txtitem.'&quot; �� ����� &quot;������� ����������&quot;';
		if($i['odate'] > (time()-60)) {
			addchp($txt,'{[]}'.$i['login'].'{[]}',-1,-1);
		} else {
			mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$i['owner']."','','".$txt."')");
		}
	}
	$tosend[] = array('uid' => $i['owner'], 'item' => $txtitem, 'img' => $img);
}

EchoLog(serialize($tosend));
for ($i = 0; $i < 5; $i++) {
	if (SendToBlog($tosend)) break;
	EchoLog("Send to blog false");
}

addch2all('��������! ������-��� ������ ��������� ���������� �������� ������ � ������ �������������� �������� �� ����� - <b>"������� ����������!"</b>. ��� ��������� ��������, ��������� � ���� ����������� � ���������, � ������ �� ��� �������� ������ ����������<b> 0.1 ���</b>. <b>������ ������ ����������� ������ ������</b> � ���� ������������� ����� ���������� � ����� ����� �� <b>�����</b> �� <a href="http://capitalcity.oldbk.com/blog_auth.php" target=_blank><img src="http://i.oldbk.com/i/newd/chn/up_butt2_chat.jpg"> <b>������ �����</b></a>');

function SendToBlog($arr) {
	EchoLog("Sending to blog");
	$content = http_build_query(array('Loto' => $arr, 'oldbk_key' => '7XttXsFvpOmUQebCbgMGOpUXG0QI'));

	$fp = fsockopen('tls://blog.oldbk.com', 443);
	if ($fp) {
		fwrite($fp, "POST /api/loto.html HTTP/1.0\r\n");
		fwrite($fp, "Host: blog.oldbk.com\r\n");
		fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
		fwrite($fp, "Content-Length: ".strlen($content)."\r\n");
		fwrite($fp, "Connection: close\r\n");
		fwrite($fp, "\r\n");

		fwrite($fp, $content);

		$str = "";
		while(!feof($fp)) $str .= fgets($fp, 128);
		fclose($fp);

		if (strpos($str,'truesozdalsya') !== false) {
			EchoLog("Sending to blog ok");
			return true;
		}

	}
	return false;
}


//mysql_query('UPDATE oldbk.inventory SET ecost = 0 WHERE prototype = 3006000');

lockDestroy("cron_mshow");

?>
