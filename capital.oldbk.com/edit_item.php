<?
	session_start();
	if (!($_SESSION['uid'] >0))
	{
	 header("Location: index.php");
	 die();
	}
	include "connect.php";
	include "functions.php";
	
	if ($user['room']!=44) { die(); }

die();


function showitem_edit ($row, $orden = 0, $check_price = false,$color='',$act='',$rep_rate=0, $priv=0,$retdata = 0) {
	global $user, $klan_ars_back, $giftars, $IM_glava, $anlim_show, $anlim_items, 	$nodress  ;
	$vau4 = array(100005,100015,100020,100025,100040,100100,100200,100300);
	$unikrazdel = array(6,2,21,22,23,24,3,4,41,42);

	$ret = "";

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

	if ($row['prototype'] == 1236) {
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
		$ret .= "<TD align=center width=150 ";
		if ($ch > 0) {
			if (($row['maxdur']-2)<=$row['duration'] && $row['duration'] > 2) {
				$ret .= " style=\"background-image:url('http://i.oldbk.com/i/blink.gif');\" ";
			}
		}
		$ret .= " >";

		$dr=shincmag($row);

		if ($row['prototype']>=2013001 && $row['prototype']<=2013004) {
			$ret .= "<a href='http://oldbk.com/encicl/?/laretz.html' target=_blank><img ";
			if ($ch == 1) {
				$ret .= "style=\"background-image:url(http://i.oldbk.com/i/sh/vstr1.gif); background-repeat: no-repeat; background-position: 3px ".($dr['res_y']*$dr['koef'])."px;\"";
			}
			$ret .= " src='http://i.oldbk.com/i/sh/".$row['img']."'></a><BR>";
		} else {
			$ret .= "<img ";
			if ($ch == 1) {
				$ret .= "style=\"background-image:url(http://i.oldbk.com/i/sh/vstr1.gif); background-repeat: no-repeat; background-position: 3px ".($dr['res_y']*$dr['koef'])."px;\"";
			}
			$ret .= " src='http://i.oldbk.com/i/sh/".$row['img']."'><BR>";
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
						$ret .= "<a  onclick=\"";

						if($magic['id'] == 109 OR $magic['id'] == 43 OR $magic['id'] == 200 OR $magic['id'] == 500 OR $magic['id'] == 65 OR $magic['id'] == 95 OR $magic['id'] == 96) {
							$ret .= "showitemschoice('�������� ������������ ������', 'scrolls', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 110) {
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
						}
						elseif($magic['id'] == 5) {
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

						} elseif($magic['id'] == 100011) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 1', 'item_bonus_1', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100012) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 2', 'item_bonus_2', 'main.php?edit=1&use=".$row['id']."');";
						} elseif(($magic['id'] == 100013) and ($row['sowner']==0)) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 3', 'item_bonus_3e', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 100013) {
							$ret .= "showitemschoice('�������� ������� ��� ��������� 3', 'item_bonus_3', 'main.php?edit=1&use=".$row['id']."');";
						}
						elseif($magic['id'] == 90) {
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
						}
						 elseif($magic['id'] == 120) {
							$ret .= "showitemschoice('�������� ���������� ������� ��� ���������', 'upunik', 'main.php?edit=1&use=".$row['id']."');";
						}
						elseif(($magic['targeted'] == 0) AND ($magic['name'] == '���������') and ($user['in_tower']==0) )
				    		{
				    		  $ret .= "if(confirm('������������ ������?')) { window.location='main.php?edit=1&use=".$row['id']."';}";
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
						}
						elseif ($magic['id'] == 172) {
							$ret .= "<br><a onclick=\"okno('������� �����:', 'main.php?edit=1&usedays=".$row['id']."', 'daystext','',2);\" href='#'>������</a> ";
						}

					}

				}

				if($act == '') {
					if (($row['type'] != 50 && $orden == 0) AND ((($row['sowner']>0) AND ($user['id'] == $row['sowner'])) OR ($row['sowner'] == 0))) {

					if (!(in_array($row['prototype'],$nodress) ))
							{
 							$dress_yes=true;
								if ($row['gsila']<0)
									{
										if ($row['gsila']+$user['sila']<$row['nsila'])
											{
											$dress_yes=false;
											 }
									}
								elseif ($row['glovk']<0)
									{
											if  ($row['glovk']+$user['lovk']<$row['nlovk'])
											{
											$dress_yes=false;
											}
									}
								elseif ($row['ginta']<0)
									{
										 if  ($row['ginta']+$user['inta']<$row['ninta'])
										 	{
											$dress_yes=false;
										 	}
									}

								if ($dress_yes==true)
									{
									if ($user['align'] != 4) $ret .= "<BR><a href='?edit=1&dress=".$row['id']."'>������</a> ";
									}
							 }
					}

					$is_in_pocket = (int)$row['karman'];
					if($is_in_pocket == 0 && $orden==0 && $user['in_tower'] != 16) {
						$ret .= "<br><a href='?edit=1&pocket=1&item=".$row['id']."'>��������</a> ";
					} elseif($is_in_pocket != 0 && $orden == 0 && $user['in_tower'] != 16) {
						$ret .= "<br><a href='?edit=1&pocket=2&item=".$row['id']."'>�������</a> ";
					}
				 }
			} elseif ((($row['type']==50) OR ($row['type']==12) OR ($row['magic']) OR ($incmagic['cur'])) and ($row['type'] != 13)) {
				if($act == '') {
					if ($user['align'] != 4) {
						$ret .= "<a  onclick=\"";
						if($magic['id'] == 43 OR $magic['id'] == 200 OR $magic['id'] == 65) {
							$ret .= "showitemschoice('�������� ������������ ������', 'scrolls', 'main.php?edit=1&use=".$row['id']."');";
						} elseif($magic['id'] == 201) {
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
						}
						elseif($magic['id'] == 5) {
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
						}
						elseif($magic['id'] == 90) {
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
							$ret .= "showitemschoice('�������� �������� �����', 'usev2015', 'main.php?edit=1&use=".$row['id']."');";
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
							$ret .= "<img src=http://i.oldbk.com/i/clear.gif style=\"cursor: pointer;\" onclick=\"if (confirm('������� ".$row['name']." ����� ������, �� �������?')) window.location='main.php?edit=1&destruct=".$row['id']."'\"></TD>";
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
		} elseif($row['chk_arsenal']>=3003131 && $row['chk_arsenal']<= 3003135) {
			$ret .= '<A HREF="klan_arsenal.php?usebook='.$row['id'].'">������������</A>';
		} elseif($row['chk_arsenal'] == 7) {
			$ret .= '<A HREF="klan_arsenal.php?mybox=2&sid='.$user['sid'].'&item='.$row['id'].'">�������� � ������</A>';
		}

	    	$ret .= "<td valign=top>";
	}

	if ($row['nalign']==1) {
		$row['nalign']='1.5';
	}


	$ehtml = str_replace('.gif','',$row['img']);

	$razdel=array(
		1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
		24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun", 61=>'eda' , 72 =>''
	);

	$row['otdel'] == '' ? $xx = $row['razdel'] : $xx = $row['otdel'];

	if ($row['type']==30)
		{
		$razdel[$xx]="runs/".$ehtml;
		}
	else
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

	if ($row['otdel']==72)
	{
	$ret .= "<a href=https://oldbk.com/commerce/index.php?act=perspres target=_blank>".$row['name']."</a>";
	}
	else
	if ($razdel[$xx]=='mag1/036')
	{
	$ret .= "<a href=https://oldbk.com/encicl/prem.html  target=_blank>".$row['name']."</a>";
	}
	elseif ($razdel[$xx]=='mag1/037')
	{
	$ret .= "<a href=https://oldbk.com/encicl/prem.html  target=_blank>".$row['name']."</a>";
	}
	elseif ($razdel[$xx]=='mag1/137')
	{
	$ret .= "<a href=https://oldbk.com/encicl/prem.html  target=_blank>".$row['name']."</a>";
	}
	else
	{
	$ret .= "<a href=https://oldbk.com/encicl/".$razdel[$xx].".html target=_blank>".$row['name']."</a>";
	}



	$eshopadd = "";

	if ((isset($_GET['otdel']) && (in_array($_GET['otdel'],$unikrazdel) ) && ($_SERVER['PHP_SELF'] == "/_eshop.php" || $_SERVER['PHP_SELF'] == "/eshop.php")  ) or ($row['ekr_flag']>0) ) { 

		$addimg = '<img src="http://i.oldbk.com/i/berezka06.gif" title="������� �� �������" alt="������� �� �������"> ';
	} else {
		$addimg = "";
	}


	if ($row['present']) {
	$ret .= "<img src=http://i.oldbk.com/i/align_".$row['nalign'].".gif> (�����: ".$row['massa'].") ".$artinfo.$anlim_txt.'  '.$addimg.' <IMG SRC="http://i.oldbk.com/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="���� ������� ��� ������� '.$txt.'. �� �� ������� �������� ���� ������� ����-���� ���." ALT="���� ������� ��� ������� '.$txt.'. �� �� ������� �������� ���� ������� ����-���� ���."><BR>';
	} else {
		$ret .= "<img src=http://i.oldbk.com/i/align_".$row['nalign'].".gif> (�����: ".$row['massa'].") ".$addimg." ".$artinfo.$anlim_txt.' <BR>';
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
		} elseif (($row['prototype'] >=56661 ) and  ($row['prototype'] <=56663 )) {
			$ret .= '<font color=red>����� ������������� �� �������, �� ������ �������� � ��������� '.$sowner.'</font><br>';
		}
		else {
        		$ret .= '<font color=red>������ ���� ����� ������ ������</font> '.$sowner.'<br>';
		}
	}

	if ($row['no'] == 1) {
		// nothing
	} elseif ( (($row['repcost'] > 0) and ($row['ecost'] ==0)) or ($_SERVER['PHP_SELF'] == '/cshop.php') ) {
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
		if ($_SERVER['PHP_SELF'] == '/eshop.php' || $_SERVER['PHP_SELF'] == '/_eshop.php') {
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

		if($user['prem']>0 && ($_SERVER['PHP_SELF'] == '/shop.php') && strpos($_SERVER['QUERY_STRING'],'newsale') === false) {
			$akkname[1]='Silver';
			$akkname[2]='Gold';
			$akkname[3]='Platinum';

			$cost=sprintf("%01.2f", ($row['cost']*0.9));
			$ret .= "<br><b>����: ".$cost." ��.</b> (��� ".$akkname[$user[prem]]." account)";
		}
	}

	if ((($row['is_owner']==1) and ($row['id']>=56661 ) and ($row['id']<=56663 ) ) and ($check_price && $priv) )
	{
		$ret .= '<br><small><font color=red>����� ������������� �� �������, �� ������ �������� � ���������!</font></small>';
	}
	elseif($check_price && $priv) {
		$ret .= '<br><small><font color=red>����� ������� ���� ����� ��������� � ���������.</font></small>';
	}  elseif ($row['is_owner']==1) {
		$ret .= '<br><small><font color=red>����� ������� ���� ����� ��������� � ���������.</font></small>';
	} elseif (($_SERVER['PHP_SELF'] == '/cshop.php') AND ($row['id'] == 1000001 || $row['id'] == 1000002 || $row['id'] == 1000003)) {
		$ret .= '<br><small><font color=red>����� ������� ������� ����� ���������� ��������.</font></small>';
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

	$ret .= "<BR>�������������: ".$row['duration']."/".$row['maxdur']."<BR>";

	if (!$row['needident']) {
		// ���������� ������ � ��� �����������
		$art_param = explode(',',$row['art_param']);

		if ($row['type'] != 30) {
			 // ���� ups - ��� ��� ������������ ��� �������� ����� ���� ��� �������� �� �������
			if ($row['ups'] > 0) {
				$ret .= "���������: <b>".$row['ups']." ���</b><BR>";
			}
		}

		if ($row['stbonus'] > 0) {
			$ret .= "��������� ����������: <b>".$row['stbonus']."</b><BR>";
		}
		if ($row['mfbonus'] > 0) {
			$ret .= "��������� ���������� ��: <b>".$row['mfbonus']."</b><BR>";
		}

		if ($magic['chanse']) {
			$ret .= "����������� ������������: ".$magic['chanse']."%<BR>";
		}
		if ($magic['time']) {
			$ret .= "����������������� �������� �����: ".get_delay_time($magic['time'])." <BR>";
		}
		if ($row['goden']) {
			$ret .= "���� ��������: {$row['goden']} ��. ";
			if (!$row[GetShopCount()] or $_SERVER['PHP_SELF'] == '/comission.php' or $_SERVER['PHP_SELF'] == '/main.php') {
				$ret .= "(�� ".date("d.m.Y H:i",$row['dategoden']).")";
			}
			$ret .= "<BR>";
		}
		if ($row['nsex'] == 1) {
			$ret .= "� ���: <b>�������</b><br>";
		}

		if ($row['nsex'] == 2) {
			$ret .= "� ���: <b>�������</b><br>";
		}

		$ret .= "<b>��������� �����������:</b><BR>";

				$ret .= "�������: <input type=text size=5 name=nlevel value='".(int)($row['nlevel'])."'><br>";
		
				$ret .= "<b>���������� � ������:</b><BR>";
				$ret .= "����: <input type=text size=5 name=nsila value='".(int)($row['nsila'])."'><br>";
				$ret .= "��������: <input type=text size=5 name=nlovk value='".(int)($row['nlovk'])."'><br>";
				$ret .= "��������: <input type=text size=5 name=ninta value='".(int)($row['ninta'])."'><br>";
				$ret .= "������������: <input type=text size=5 name=nvinos value='".(int)($row['nvinos'])."'><br>";
				$ret .= "���������: <input type=text size=5 name=nintel value='".(int)($row['nintel'])."'><br>";
				$ret .= "��������: <input type=text size=5 name=nmudra value='".(int)($row['nmudra'])."'><br>";
		
	
				$ret .= "<b>���������� � ������:</b><BR>";
				$ret .= "���������� �������� ������ � ���������: <input type=text size=5 name=nnoj value='".(int)($row['nnoj'])."'><br>";
				$ret .= "���������� �������� �������� � ��������: <input type=text size=5 name=ntopor value='".(int)($row['ntopor'])."'><br>";
				$ret .= "���������� �������� �������� � ��������: <input type=text size=5 name=ndubina value='".(int)($row['ndubina'])."'><br>";
				$ret .= "���������� �������� ������: <input type=text size=5 name=nmech value='".(int)($row['nmech'])."'><br>";
			

				$ret .= "<b>���������� � �����:</b><BR>";
				$ret .= "���������� �������� ������� ����: <input type=text size=5 name=nfire value='".(int)($row['nfire'])."'><br>";
				$ret .= "���������� �������� ������� ����: <input type=text size=5 name=nwater value='".(int)($row['nwater'])."'><br>";
				$ret .= "���������� �������� ������� �������: <input type=text size=5 name=nair value='".(int)($row['nair'])."'><br>";
				$ret .= "���������� �������� ������� �����: <input type=text size=5 name=nearth value='".(int)($row['nearth'])."'><br>";
				$ret .= "���������� �������� ������ �����: <input type=text size=5 name=nlight value='".(int)($row['nlight'])."'><br>";
				$ret .= "���������� �������� ����� ������: <input type=text size=5 name=ngray value='".(int)($row['ngray'])."'><br>";
				$ret .= "���������� �������� ������ ����: <input type=text size=5 name=ndark value='".(int)($row['ndark'])."'><br>";



		$ret .= "<b>��������� ��:</b><hr>";
		
		if ($row['type']==3)
		{
		$ret .= "<b>�����������.:</b><BR>";
		$ret .= "� ����������� ��������� �����������: <input type=text size=5 name=minu value='".(int)($row['minu'])."'><br>";
		$ret .= "� ������������ ��������� �����������: <input type=text size=5 name=maxu value='".(int)($row['maxu'])."'><br>";
		}
		
		$ret .= "<b>����� � �����.:</b><BR>";
		$ret .= "� ����: +<input type=text size=5 name=gsila value='".(int)($row['gsila'])."'><br>";
		$ret .= "� ��������: +<input type=text size=5 name=glovk value='".(int)($row['glovk'])."'><br>";
		$ret .= "� ��������: +<input type=text size=5 name=ginta value='".(int)($row['ginta'])."'><br>";			
		$ret .= "� ���������: +<input type=text size=5 name=gintel value='".(int)($row['gintel'])."'><br>";			
		$ret .= "� ��������: +<input type=text size=5 name=gmp value='".(int)($row['gmp'])."'><br>";						
		$ret .= "� ������� �����: +<input type=text size=5 name=ghp value='".(int)($row['ghp'])."'><br>";												

		$ret .= "<b>��.:</b><BR>";
		$ret .= "� ��. ����������� ������: <input type=text size=5 name=mfkrit value='".(int)($row['mfkrit'])."'><br>";
		$ret .= "� ��. ������ ����. ������: <input type=text size=5 name=mfakrit value='".(int)($row['mfakrit'])."'><br>";			
		$ret .= "� ��. ������������: <input type=text size=5 name=mfuvorot value='".(int)($row['mfuvorot'])."'><br>";			
		$ret .= "� ��. ������ ��������.: <input type=text size=5 name=mfauvorot value='".(int)($row['mfauvorot'])."'><br>";									
			
		$ret .= "<b>����������:</b><BR>";
		$ret .= "� ���������� �������� ������ � ���������: +<input type=text size=5 name=gnoj value='".(int)($row['gnoj'])."'><br>";
		$ret .= "� ���������� �������� �������� � ��������: +<input type=text size=5 name=gtopor value='".(int)($row['gtopor'])."'><br>";
		$ret .= "� ���������� �������� �������� � ��������: +<input type=text size=5 name=gdubina value='".(int)($row['gdubina'])."'><br>";
		$ret .= "� ���������� �������� ������: +<input type=text size=5 name=gmech value='".(int)($row['gmech'])."'><br>";
		$ret .= "� ���������� �������� ������� ����: +<input type=text size=5 name=gfire value='".(int)($row['gfire'])."'><br>";
		$ret .= "� ���������� �������� ������� ����: +<input type=text size=5 name=gwater value='".(int)($row['gwater'])."'><br>";
		$ret .= "� ���������� �������� ������� �������: +<input type=text size=5 name=gair value='".(int)($row['gair'])."'><br>";
		$ret .= "� ���������� �������� ������� �����: +<input type=text size=5 name=gearth value='".(int)($row['gearth'])."'><br>";
		$ret .= "� ���������� �������� ������ �����: +<input type=text size=5 name=glight value='".(int)($row['glight'])."'><br>";
		$ret .= "� ���������� �������� ����� ������: +<input type=text size=5 name=ggray value='".(int)($row['ggray'])."'><br>";
		$ret .= "� ���������� �������� ������ ����: +<input type=text size=5 name=gdark value='".(int)($row['gdark'])."'><br>";
		$ret .= "<b>�����:</b><BR>";
		$ret .= "� ����� ������: <input type=text size=5 name=bron1 value='".(int)($row['bron1'])."'><br>";
		$ret .= "� ����� �������: <input type=text size=5 name=bron2 value='".(int)($row['bron2'])."'><br>";
		$ret .= "� ����� �����: <input type=text size=5 name=bron3 value='".(int)($row['bron3'])."'><br>";
		$ret .= "� ����� ���: <input type=text size=5 name=bron4 value='".(int)($row['bron4'])."'><br>";


		$ret .= "<b>�������� (������):</b><br>";
		$ret .= "� ������������� ��.:<input type=text size=5 name=ab_mf value='".$row['ab_mf']."'><br>";
		$ret .= "� �����:+<input type=text size=5 name=ab_bron value='".$row['ab_bron']."'><br>";
		$ret .= "� �����:+<input type=text size=5 name=ab_uron value='".$row['ab_uron']."'><br>";

		
		if($row['present'] != '') 
		{
			$prez = explode(':|:',$row['present']);
		}
		
		if($row['gmeshok']) $ret .= "� ����������� ������: +".$row['gmeshok']."<BR>";
		
		if($row['letter'] && $user['in_tower'] != 16 && $row['prototype'] != 3006000) $ret .= "���������� ��������: ".strlen($row['letter'])."<BR>";
		if($row['present']) $ret .= "������� ��: <b>".$prez[0]."</b><br>";
		if($row['letter'] && $user['in_tower'] != 16 && $row['prototype'] != 3006000) $ret .= "�� ������ ������� �����:<div style='background-color:FAF0E6;'> ".$row['letter']."</div>";
		if($row['prokat_idp']>0) $ret .= "��������:".floor(($row['prokat_do']-time())/60/60)." �. ".round((($row['prokat_do']-time())/60)-(floor(($row['prokat_do']-time())/3600)*60))." ���.<br>";
		if($magic['name'] && $row['type'] != 50) $ret .= "<font color=maroon>�������� ��������:</font> ".$magic['name']."<BR>";
		if($magic['img'] && $row['type'] == 12 && $row['labonly']==0 && $row['dategoden'] == 0) $ret .= "<font color=maroon>��������:</font> ����� ������������ � ����</font> <BR>";
		if((!$magic['img'] || $row['labonly']==1 || $row['dategoden'] > 0) && $row['type'] == 12 ) $ret .= "<font color=maroon>��������:</font> �� ����� ������������ � ����</font> <BR>";
		
		if ($row['magic'] == 8888) {
			$ret .=  "<font color=maroon>��������:</font> ����� ���� ����������� ������ �� ���� �������<br>";
		}
		
		if (($row['id'] == 30012) OR ($row['prototype'] == 30012)) {
			$ret .=  "<font color=maroon>��������:</font>� ��� ���� ����������� ���� �������� ������<br>";
		}
		
		if (($row['id'] == 501) OR ($row['prototype'] == 501) OR ($row['id'] == 502) OR ($row['prototype'] == 502) ) {
			$ret .=  "<font color=maroon>��������:</font>��� ������������ �����<br>";
		}		
		
		
		if ($magic['name'] && $row['type'] == 50) {
			$ret .= "<font color=maroon>��������:</font> ".$magic['name']."<BR>";
		}
		if ($row['text'] && $row[type]==3) {
			$ret .= "�� ����� ������������� �������:<center>".$row['text']."</center><BR>";
		}
		if ($row['text'] && $row[type]==5) {
			$ret .= "�� ������ ������������� �������:<center>".$row['text']."</center><BR>";
		}
		if ($row['present_text']) {
			$ret .= "�� ������� ������� �����:<br />".$row['present_text']."<BR>";
		}
		if ($incmagic['max']) {
			$ret .= "�������� �������� <img src=\"http://i.oldbk.com/i/magic/".$incmagic['img']."\" title=\"".$incmagic['name']."\"> ".$incmagic['cur']."/".$incmagic['max']." ��.<BR> ";
			if ($incmagic['nlevel'] > $user['level']) {
				$ret .= "<font color=red>��������� �������: ".$incmagic['nlevel']."</font>";
			} else {
				$ret .= "��������� �������: ".$incmagic['nlevel'];
			}
			$ret .= "<br>";
		}
		if($incmagic['max']) {
			$ret .= "�-�� �����������: ".$incmagic['uses']."<br>";
		}
		if ($row['labonly']==1) {
			$ret .= "<small><font color=maroon>������� �������� ����� ������ �� ���������</font></small><BR>";
		}
		if(!$row['isrep']) {
			$ret .= "<small><font color=maroon>������� �� �������� �������</font></small><BR>";
		}
	} else { 
		$ret .= "<font color=maroon><B>�������� �������� �� ����������������</B></font><BR>";
	}

	if ($row['type'] == 27)	{
		$ret .= "�����������:<br>� ����� ��������� �� �����<br>";
	} elseif ($row['type'] == 28) {
		$ret .= "�����������:<br>� ����� ��������� ��� �����<br>";
	}


	if  (($row['ab_mf'] > 0) or ($row['ab_bron'] > 0) or ($row['ab_uron']>0) || ($row['prototype'] >= 55510301 && $row['prototype'] <= 55510401)) {
		
/*
		$ekr_elka = array(55510312,55510313,55510314,55510315,55510316,55510317,55510318,55510319,55510320,55510321,55510322,55510334,55510335,55510336,55510337,55510338,55510339);
		$art_elka = array(55510323,55510324,55510325,55510326,55510327,55510340,55510341,55510342,55510343,55510344);
*/

		$ekr_elka = array(55510350);
		$art_elka = array(55510351);

	
		$elkabonus = 0;						
		if ((($row['prototype'] >= 55510301) AND ($row['prototype'] <= 55510311)) || (($row['prototype'] >= 55510328) AND ($row['prototype'] <= 55510333))) {
			//�������� ����
			$elkabonus = 1;
		} elseif (in_array($row['prototype'],$ekr_elka)) {
			//������� ����
			$elkabonus = 2;
		} elseif (in_array($row['prototype'],$art_elka)) {
			//������� ����
			$elkabonus = 3;
		}
		if ($elkabonus > 0) {
			$ret .= "� ������� �����:+".$elkabonus."%<br>";
		}

		if ($row['prototype'] == 55510351)
		{
			$ret .= "� �����:+10%<br>";
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
									$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
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
										$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
										}
									}
						}
					$ret .= "</b></small></div>";						
				}			
			}
			

				
	}


	if (isset($_GET['otdel']) && in_array($_GET['otdel'],$unikrazdel) && ($_SERVER['PHP_SELF'] == "/_eshop.php" || $_SERVER['PHP_SELF'] == "/eshop.php")) {
		$ret .= "<small><b><a onclick=\"showhide('unik_{$row['id']}');return false;\" href=\"#\">�����������:</a></small><BR>";
		$ret .= "<div id=unik_{$row['id']} style=\"display:none;\"><small><b>";


		if ($row['gsila'] > 0 || $row['glovk'] > 0 || $row['ginta'] > 0 || $row['gintel'] > 0 || $row['gmudra'] > 0) {
			$ret .= "� �����: +3<br>";
		}
		if ($row['ghp'] > 0) $ret .= "� ������� �����: +20<br>";
		if ($row['bron1'] > 0 || $row['bron2'] || $row['bron3'] || $row['bron4']) $ret .= "� �����: +3<br>";

		$ret .= "</b></small></div>";
	}

	if (($row['idcity']==1) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'avaloncity.oldbk.com'))) {
		$ret .= "<small>������� � AvalonCity</small>";
	} elseif (($row['idcity']==2) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'angelscity.oldbk.com'))) {
		$ret .= "<small>������� � AngelsCity</small>";
	} elseif (($row['idcity'] == 0) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'capitalcity.oldbk.com'))) {
		$ret .= "<small>������� � CapitalCity</small>";
	}
			
	if($row['unik']==1) {
		$ret .= "<br><font color=red><small><b>���� � ���������� ������������.</b></small></font>";
	}
	elseif(($row['unik']==2) and ($row['type']!=200) )  {
		$ret .= "<br><font color=#990099><small><b>���� � ���������� ���������� ������������.</b></small></font>";
	}
	
	if($row['type'] == 555) {
		$ret .= "<br><small><font color=red>������ ������ �������� �� ����������� � �������. �������� ������ �� ����� ����� � ��������� ����������. ������� ������ ����� ��������� �� ������ � ���� ���� - <a target=_blank href=http://oldbk.com/forum.php?topic=228962139>http://oldbk.com/forum.php?topic=228962139</a>. ������������� �����</red></small>"; 
	}
	
	

		if (($row['bs_owner']==0) and ($user['ruines']==0) and ($row['labonly']==0) and ($row['prototype']!=55510000)  )
		{
		$ups_types=array(1,2,3,4,5,8,9,10,11);
		$ebarr=array(128,17,149,148);
		
		
		if ((strpos($row['name'], '[') == true) AND (in_array($row['prototype'],$ebarr) ) )
		{
		$ret .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ ���� ����� � ��������� ����������, ����� ���  ���������� ���������� ����� 00:00 27.09.14.</red></small>";
		}
		else
		if ((strpos($row['name'], '[') == true) AND ($row['art_param']!='') )
		{//�� ����� ������:
		$ret .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ � ������������ ������, ����� ���  ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 		
		}
		elseif ((strpos($row['name'], '[') == true) AND (($row['type']==28) OR $row['prototype']==100028 OR $row['prototype']==100029 OR $row['prototype']==173173 OR $row['prototype']==2003 OR $row['prototype']==195195) )
		{
		//�� ����� ������� ���� �������:
		$ret .= "<br><small><font color=red>��������! ��� ���� ���������� ��������� �������� � ��������� ����������, ����� ��� ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 			
		}
		elseif ( (strpos($row['name'], '[') == true) AND (in_array($row['type'],$ups_types)) AND $row['ab_mf']==0  AND $row['ab_bron']==0  AND $row['ab_uron']==0   ) // �� ���� ���� 
		{
		//�� �������	
		$ret .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ � ��������� ����������, ����� ��� ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 
		}		
		}
	
	if($row['type']==556) {
		$ret .= "<br><small><font color=red>������ ������� ������� �� ����������� � �������. ������������� �����</red></small>"; 
	}		
	$ret .= "</td></TR>";
	if ($retdata > 0) {
		return $ret;
	} else {
		echo $ret;
	}
}

	
	
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='i/commoninf.js'></SCRIPT>
<script type="text/javascript" src="/i/globaljs.js"></script>
<SCRIPT>

function showhide(id)
	{
	 if (document.getElementById(id).style.display=="none")
	 	{document.getElementById(id).style.display="block";}
	 else
	 	{document.getElementById(id).style.display="none";}
	}
</SCRIPT>

</HEAD>
<body bgcolor=e2e0e0><div id=hint3 class=ahint></div><div id=hint4 class=ahint></div>
<H3>�������� ���������</H3>
	
	<?
	          echo '<form name="" action="" method="post"><input name="new_it" type="hidden" value="'.$_POST[new_it].'">';
	          echo "������������� ���� (���� ������ ���� � ���������):";
		  echo '<select size="1" name="new_it">';
	    	    $data=mysql_query(' select * from oldbk.inventory where owner='.$user[id].' AND (type <12 OR type=28 OR type=27) order by name, id;');
	            while($new_it=mysql_fetch_assoc($data))
	            {
	                echo '<option '.($new_it[id]==$_POST[new_it]?'selected':'').' value="'.$new_it[id].'">'.$new_it[name].'['.$new_it[unik].']['.$new_it[id].']</option>';
	            }
	            echo '</select>';
	           echo "&nbsp;<input type=submit value=�������������></form>";

		if ($_POST[new_it])
		{
		$ret = "";
		$itm=(int)$_POST[new_it];
			
				if ($_POST[save])
					{
					unset($_POST[save]);
					unset($_POST[new_it]);					

						foreach($_POST as $k => $v) 
							{
							$sqlstr.=mysql_real_escape_string($k)."='".$v."' , ";
							}

						mysql_query('update  oldbk.inventory  set '.$sqlstr.' battle=0, present="Admin-Editor" where owner='.$user[id].' AND (type <12 OR type=28 OR type=27) and id='.$itm.' limit 1;');
						if (mysql_affected_rows()>0) 
							{
							 echo "<b><font color=red>��� ��������� ������� ���������!</font></b>";	
							}
					}
					elseif($_POST[savecopy])
					{
					echo "TEst 1";
					unset($_POST[save]);
					unset($_POST[savecopy]);					
					unset($_POST[new_it]);		
						
						//������ ��������
						$citem=mysql_fetch_assoc(mysql_query(' select * from oldbk.inventory where owner='.$user[id].' AND (type <12 OR type=28 OR type=27) and id='.$itm.' '));			

						//����������� ���������
						foreach($_POST as $k => $v) 
							{
							$citem[$k]=$v;
							}
						//������� ����� 
						
						$citem['present']='Admin-Editor';
						unset($citem['battle']);						
						unset($citem['id']);												
						
						foreach($citem as $k => $v) 
							{
							$sqlstr.="`".mysql_real_escape_string($k)."`='".$v."' , ";
							}

						mysql_query('insert into  oldbk.inventory  set '.$sqlstr.' battle=0  ');
						if (mysql_affected_rows()>0) 
							{
							 echo "<b><font color=red>��� ��������� ������� ���������! ������ ����� ������� {$citem['name']} ['".mysql_insert_id()."'] </font></b>";	
							}
							else
							{
							 echo "<b><font color=red>������!</font></b>";	
							}
					}
		
		
			
			$q=mysql_query(' select * from oldbk.inventory where owner='.$user[id].' AND (type <12 OR type=28 OR type=27) and id='.$itm.' ');

			if (mysql_num_rows($q) > 0) 
			{
				$ret .= "<table border=2  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
				while($row = mysql_fetch_assoc($q)) {
					if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
		
					$ret .= showitem_edit($row,0,false,$color,'',0,0,1);
				}
				$ret .= "</table>";
			
			echo "<form method=post>";
			echo "<input name=new_it type=hidden value=".$itm.">";
			echo $ret;
			echo "<input type=submit name=save value='���������'> <br>
			<input type=submit name=savecopy value='��������� �����'></form>";
			} 
		}
		
	
	?>




</BODY>
</HTML>

