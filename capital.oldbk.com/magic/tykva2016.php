 <?php

if (!($_SESSION['uid'] >0)) {
	header("Location: index.php");
	die();
}

// 0 shop
// 1 eshop
$l1 = array(
3001003 => 1, //���� ������� ���� 10%
249249 =>0, //������� ������ ��������������� 180HP�.���� 15%
271271 => 0, //������� ������ ��������������� 360HP����� 10%
200273 => 1, //������� ������ ��������������� 360HP����� 10%
5205 => 1, // ������� ������ ��������������� 180HP����� 15%
180011 => 0, //������ 80%���� 8%
180012 => 0, //������ 85%���� 6%
180013 => 0, //������ 90%���� 4%
180014 => 0, //������ 95%���� 3%
180015 => 0, //������ 100% ���� 2%
56662=>0, //C����� ��������� II ���� 15%
190191 => 0, //������� ������ +8 2��, ���� 1%
190192 => 0, //������� ������ +9 2��, ���� 1%

);
$l2 = array(
55557 => 0, //������� ������ ������� �� ��������� 8%
4201 => 0, //������� ������ ����������� ���������� 10%
14005=> 0, //������� ������ ����������� 15%
15003 => 0, //������� ������ ����������� 15%
119119 => 0, //������� ������ ����������������� 15%
120120 => 0, //������� ������ ������������������ 15%
190191 => 0, //������� ������ +8 2��, ���� 1%
190192 => 0, //������� ������ +9 2��, ���� 1%
56663 => 1, //C����� ��������� III ���� 10%
);


$addmag[1]=150158; ////������� ������ ����� ��������� 10% ���� ��������� � �������� ������� �����
$addmag[2]=920928; // ������� ������ ������ ����������� 10% ���� ��������� � �������� ������� �����
$addmag[3]=130138; //������� ������ ���� ����������� 10% ���� ��������� � �������� ������� �����
$addmag[4]=930938;  //������� ������ ����� ������ ���� 10% ���� ��������� � �������� ������� �����
$need_astih=get_mag_stih($user); // �������� �� ������
$need_astih=$need_astih[0]; //�� 0� ����� ������ ������
$need_astih=$addmag[$need_astih]; //������ ������
//������� ��� ������ ������
$l2[$need_astih]=0;  //�� ����

$l3 = array(4016 => 0); //������� � �����

//����� ������ ��� ������ 1
$rnd1=array(
3001003 => 10,
249249 => 15,
271271 => 10,
200273 => 10,
5205 => 15,
180011 =>8,
180012 =>6,
180013 =>4,
180014 =>3,
180015 =>2,
56662=>15,
190191 =>1,
190192 =>1);

//����� ������ ��� ������ 2
$rnd2=array(
55557 => 8,
4201 => 10,
14005=>15,
15003 =>15,
119119 =>15,
120120 =>15,
190191 => 1,
190192 => 1,
56663 => 10);
//������� ��� ������ ������
$rnd2[$need_astih]=10;  //10% ��� ����� ������

//����� ������ ��� ������ 3
$rnd3=array(4016=>100); //100%


function get_rand_item($arr)
{
global $per;

$tmp=array();
	//��������� ������� �������� ������
	foreach($arr as $itm=>$ch) 
		{
			for ($i=1;$i<=$ch;$i++)
			{
			$tmp[]=$itm;
			}
		}
	$t = array_rand($tmp,1);

		if (($per==1) or ($per==3))
			{
			$stcount='count1';
			}
			else
			{
			$stcount='count2';
			}
	
		mysql_query("UPDATE `oldbk`.`t_use_tykva` SET `{$stcount}`=`{$stcount}`-1 WHERE `proto`='{$tmp[$t]}' ");
		
	
return $tmp[$t];
}

$ilist = array();

$per = 0;

$tboxstart = mktime(0,0,0,10,17,2016);
$p1 = $tboxstart+(24*3600*7);
$p2 = $p1+(24*3600*7);
$p3 = $p2+(24*3600*7);
$p4 = $p3+(24*3600*7)+3600;

if(time() >= $tboxstart && time() <= $p1) {
	$per = 1;
} elseif (time() >= $p1 && time() <= $p2) {
	$per = 2;
} else if (time() >= $p2 && time() <= $p3) {
	$per = 3;
} else if (time() >= $p3 && time() <= $p4) {
	$per = 4;
} else if (time() <=  mktime(23,59,59,11,13,2016) ) 
{
 	$per = 4;
 }


if (($per==1) or ($per==3))
	{
	$stcount='count1';
	}
	else
	{
	$stcount='count2';
	}


	$get_stop_item=mysql_query("select * from t_use_tykva;");
	while ($rw = mysql_fetch_assoc($get_stop_item))	
		{
			if ($rw[$stcount]==0)
			{
				//��� ��� ������� ��� ����� ���������
				if ($stcount=='count1')
					{
					$rnd1[180015]=$rnd1[180015]+$rnd1[$rw['proto']]; //���� ������� ������ ������
					$rnd1[$rw['proto']]=0;
					}
					else
					{
					$rnd2[119119]=$rnd2[119119]+$rnd2[$rw['proto']]; //���� ������� ������ //������� ������ ����������������� 15%
					$rnd2[$rw['proto']]=0;
					}
			}
		}
	
	

if ((date("n") == 10 && date("j") == 31) || (date("n") == 11 && date("j") == 1)) 
{
if ($user['id']==14897) echo "A1";
	$t = get_rand_item($rnd1);
	$ilist[$t] = $l1[$t];
	$t = get_rand_item($rnd2);
	$ilist[$t] = $l2[$t];
	$t = get_rand_item($rnd3);
	$ilist[$t] = $l3[$t];
} elseif($per == 1 || $per == 3) {
if ($user['id']==14897) echo "A2";
	$t = get_rand_item($rnd1);
	$ilist[$t] = $l1[$t];
} elseif ($per == 2 || $per == 4) {
if ($user['id']==14897) echo "A3";
	$t = get_rand_item($rnd2);
	$ilist[$t] = $l2[$t];
}



function mk_my_item($telo, $proto,$shop,$finfo) {
	if ($shop == 0) {
		$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$proto}' ;"));
	} else {
		$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$proto}' ;"));
	}

	$dress['present'] = "�����"; // ��� ��������
	$dress['goden']=90;
	$dress['sowner']=$telo['id'];
	

	if ($dress[id]>0) {
	
	
		if(mysql_query("INSERT INTO oldbk.`inventory`
			(`getfrom`,`prototype`,`owner`,`sowner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`img_big`,`rareitem`,`ekr_flag`,`notsell`,`maxdur`,`isrep`,`letter`,
			`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
			`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
			`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`nsex`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`arsenal_klan` , `arsenal_owner`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`,`includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`,`present`
			)
			VALUES
				(35,'{$dress['id']}','{$telo[id]}','{$dress['sowner']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}', '{$dress['img_big']}', '{$dress['rareitem']}','{$dress['ekr_flag']}','{$dress['notsell']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['letter']}','{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress[nsex]}',
				'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."',
				'{$dress['goden']}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','','','{$telo[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}', '{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}' , '{$dress['present']}'
				) ;"))
			{
				$good = 1;
				$insert_item_id=mysql_insert_id();
				$dress['idcity']=$telo[id_city];
				$dress['id']=$insert_item_id;
	        	} else {
				$good = 0;
			}		
			

			if ($good) {
				$rec['owner']=$telo[id];
				$rec['owner_login']=$telo[login];
				$rec['target']=0;
				$rec['target_login']='��������';
				$rec['owner_balans_do']=$telo[money];
				$rec['owner_balans_posle']=$telo[money];
				$rec['type']=421;//   ������� ����������� ����
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
				$rec['item_unic']=0;
				$rec['item_incmagic']=$dress['includemagic'];
				$rec['item_incmagic_count']=$dress['includemagicdex'];
				$rec['item_arsenal']='';
				$rec['add_info']=$finfo;
				add_to_new_delo($rec);
				
				return link_for_item($dress)." ".$good." ��., ";				
			} else {
				return false;
			}
	} else {
		return false;
	}
}


if (count($ilist)) {
	$q = mysql_query('SELECT * FROM t_use WHERE owner = '.$user['id'].' and `date` = "'.date("d/m/Y").'"') or die(mysql_error());
	if (mysql_num_rows($q) == 0) 
	{
	
		if (($user['id']==14897) OR ($user['id']==8540) OR ($user['id']==6745) OR ($user['id']==182783))
		{
		//������
		}
		else
		{
		mysql_query('INSERT INTO t_use (`owner`,`date`) VALUES ("'.$user['id'].'","'.date("d/m/Y").'")') or die(mysql_error());
		}

		$finf = '"'.$rowm[name].'" ('.get_item_fid($rowm).')';
		while(list($k,$v) = each($ilist)) 
		{
			// ������ ��������
			$out_text.=mk_my_item($user,$k,$v,$finf);
		}
			
			if ($out_text!='')	
			{
			$echo_out="�� ������� <b>{$rowm[name]}</b>, � ��������:";
				
				$out_text=substr($out_text,0,-2);
				echo $echo_out."<br>".$out_text;
				addchp ('<font color=red>��������!</font> '.$echo_out." ".$out_text,'{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
			}
	} else {
		echo "������� ��� ������������...";
	}
} else {
	echo "�������� �������...";
}
?>