<?
	require_once('./mailer/send-email.php');

//print_r($_POST);

function normJsonStr($str){
    $str = preg_replace_callback('/\\\u([a-f0-9]{4})/i', create_function('$m', 'return chr(hexdec($m[1])-1072+224);'), $str);
    return iconv('cp1251', 'utf-8', $str);
}

function render_my_money($disp_kazna=false)
{
global $user,$bank, $get_klan;
global $IM_GLAVA;
	if ($bank['def']>0) {$deff="<font color=red><b>�������� ����</b></font><br>"; }

echo "<table border=0 width=\"100%\" >";
echo "<tr><td>{$deff}";
echo"<small><b>�� ����� ����� � {$bank['id']} : <font color=#003388>{$bank['cr']}</font> ��. � <font color=#003388>{$bank['ekr']}</font> ���.<br>
	�� ����� ��������� : <font color=#003388>{$user['money']}</font> ��. , <font color=#003388>{$user['repmoney']}</font> ���.</b></small>, <small><b><font color=#003388>{$user['gold']}</font> <img src=\"http://i.oldbk.com/i/icon/coin_icon.png\" alt=\"������\" title=\"������\" style=\"margin-bottom: -2px;\"></b></small>";



echo "</td><td><small><b>���� �����:</b></small></td> <td> ";

$query_curs=mysql_query_cache("select * from oldbk.variables where var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'  or  var='grivna_wmu' ",false,6);
	while(list($k,$row) = each($query_curs))
	{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		elseif($row['var'] =='euro')  { $euro = $row[value];}
		elseif($row['var'] =='grivna') { $grivna = $row[value];}
 		elseif($row['var'] =='ekrkof') { $ekrkof = $row[value];}
 		elseif($row['var'] =='ekrbonus') { $ekrbonus = $row[value];}
 		elseif($row['var'] =='grivna_wmu') { $grivna_wmu = $row[value];}
	}
			$EU=$euro;
			echo "<small><B>1 </B> ECR = <B>".(ceil($EU/0.01) * 0.01)."</B> EUR<BR>";
			$RUR=round($dollar,3);
			echo "<B>1 </B> ECR = <B>".(ceil($RUR/0.01) * 0.01)."</B> RUR<br>";
			//echo "<B>1 </B> ECR = <B>".$grivna_wmu."</B> UAH<BR>"; //10.765
			echo "<B>1 </B> ECR = <B>".$ekrkof."</B> USD<BR></small>";

echo " </td> <td><small><B>1</B> ECR = <B>".EKR_TO_KR."</B> ��.</small></td>  <td>";

 if ($user['room'] == 29)
 	{
	echo "<div class='btn-control'><input class='button-mid btn' type=button value='���������' onClick=\"returned2('strah=1&');\"></div></td></tr>";
	}
	else
	{
	echo "<div class='btn-control'><input class='button-mid btn' type=button value='���������' onClick=\"location.href='main.php';\"></div></td></tr>";
	}

echo "<tr><td width=\"49%\">";

if ($disp_kazna) {
 echo "<br><small>";
 display_kazna($get_klan[id]);
 echo "</small>";
 }

echo "<td  align=left> </td>";
echo "<td  align=left>";




echo "</td><td  align=left>";









echo "</td><td width=\"10%\" align=right ></td></tr></table>  ";
}


function count_kr($current_exp,$exptable) {

    $cl = 0; $money = 0; $stats = 3; $vinos = 3; $master = 1;
    while($exptable) {
      if($current_exp >= $exptable[$cl][5]) {
        /* 0stat  1umen  2vinos 3kred, 4level, 5up*/
        $cl = $exptable[$cl][5];
        $stats = $stats+$exptable[$cl][0];
        $master = $master+$exptable[$cl][1];
        $vinos = $vinos+$exptable[$cl][2];
      } else { $arr = array('stats'=>$stats,'master'=>$master,'vinos'=>$vinos,'cl'=>$exptable[$cl][5]); return $arr; }
    }
  }


function clac_mybox()
	{
	 global $user;
	$re[massa]=0;
	$d = mysql_query("SELECT sum(massa) as massa FROM oldbk.`inventory` WHERE `owner` = 488 AND arsenal_owner='{$user[id]}'; ");
	while ($summesh = mysql_fetch_array($d))
	  {
	  $re[massa]+=$summesh[massa];
	  }
	$re[gsum]=0;

	$uboxs=mysql_fetch_array(mysql_query("select * from users_boxsize where owner='{$user['id']}' "));
	$re['box_level']=(int)$uboxs['boxlvl'];
	$re['gsum']+=(int)$uboxs['boxsize'];

	$re['gsum']+=100; // ����������
	return $re;
	}


function load_next_box_size($boxlvl,$bank)
{
$out=array();
$out['ok']=true;
		$aboxs[0]['size']=100; $aboxs[0]['cost']=100;
		$aboxs[1]['size']=200; $aboxs[1]['cost']=200;
		$aboxs[2]['size']=500; $aboxs[2]['cost']=500;
		$aboxs[3]['size']=1000; $aboxs[3]['ecost']=10;

			/*
				// ��� ����� ��������� "�� 100 �� 100 ��."
				��������� �� ��� ����� ����� ���� ��������, ����� ���� ��������� ����������:
				     �� 200 �� 200 ��.
				     �� 500 �� 500 ��.
				     �� 1000 �� 10 ���.  (���������, ����� ���������� �����������)
				// ���������� ��������� ��� ������ ����� ����, ��� ������ ����������
				// ����� ������� ����������� ����� ������� �� ���������
				7) ���� ��/����� �� ����� ����������, �� ��� ������ ���������� ���� ������ [��] [���], ��/���� ��������� � "�������������" �����
				8) ���� ��/����� ������������, �� ���������� ����� ������� � ���� ������ "������������ ������� �� �����!", �� ���������� ������ [��] [���]
			*/
		if ($boxlvl>3)
			 		{
			 		$out['size']=($boxlvl-2)*$aboxs[3]['size'];
			 		$out['ekrcost']=($boxlvl-2)*$aboxs[3]['ecost'];

 					if ($bank['ekr']<$out['ekrcost'])
	 						{
							$out['ok']=false;
	 						}


			 		}
			 	else
			 	{
			 	$out['size']=$aboxs[$boxlvl]['size'];
		 		if ($aboxs[$boxlvl]['cost'])
			 		{
			 		$out['krcost']=$aboxs[$boxlvl]['cost'];
	 					if ($bank['cr']<$out['krcost'])
	 						{
					 		$out['ok']=false;
	 						}
				 	}
				 	else
				 	{
			 		$out['ekrcost']=$aboxs[$boxlvl]['ecost'];
	 					if ($bank['ekr']<$out['ekrcost'])
	 						{
							$out['ok']=false;
	 						}
				 	}
				}

return $out;
}

function print_inv_items($inbox=0)
{
// ����� ��������� 0- �� ��������� 1- �� �������
global $user;

echo '<FORM METHOD=POST ACTION="?p=6&showinbox='.$inbox.'" name=f1>
				<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">';
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

			$part2 = '
							<TABLE border=0 width=100% cellspacing="0" cellpadding="0" bgcolor="#A5A5A5">
							<TR>
								<TD>
								<TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
									<TD align=center bgcolor="'.(($_SESSION['razdel'] === 0) ? "#A5A5A5":"#C7C7C7").'"><input name="ssave" type="hidden" value=1>
									<input type="hidden" id="rzd0" name="rzd0" value="'.($gruppovuha[0]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[0]=='1'?'1':'0').'.gif" onClick="save1(0);" style="cursor: pointer;"><A HREF="?p=6&showinbox='.$inbox.'&razdel=0">&nbsp;��������������</A></TD>
									<TD align=center bgcolor="'.(($_SESSION['razdel'] === 1) ? "#A5A5A5":"#C7C7C7").'"><input type="hidden" id="rzd1" name="rzd1" value="'.($gruppovuha[1]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[1]=='1'?'1':'0').'.gif" onClick="save1(1);" style="cursor: pointer;"><A HREF="?p=6&showinbox='.$inbox.'&razdel=1">&nbsp;��������</A></TD>
									<TD align=center bgcolor="'.(($_SESSION['razdel'] === 2) ? "#A5A5A5":"#C7C7C7").'"><input type="hidden" id="rzd2" name="rzd2" value="'.($gruppovuha[2]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[2]=='1'?'1':'0').'.gif" onClick="save1(2);" style="cursor: pointer;"><A HREF="?p=6&showinbox='.$inbox.'&razdel=2">&nbsp;������</A></TD>
									<TD align=center bgcolor="'.(($_SESSION['razdel'] === 4) ? "#A5A5A5":"#C7C7C7").'"><input type="hidden" id="rzd4" name="rzd4" value="'.($gruppovuha[4]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[4]=='1'?'1':'0').'.gif" onClick="save1(4);" style="cursor: pointer;"><A HREF="?p=6&showinbox='.$inbox.'&razdel=4">&nbsp;�������</A></TD>
									<TD align=center bgcolor="'.(($_SESSION['razdel'] === 5) ? "#A5A5A5":"#C7C7C7").'"><input type="hidden" id="rzd5" name="rzd5" value="'.($gruppovuha[5]=='1'?'1':'0').'" ><img src="http://i.oldbk.com/i/g'.($gruppovuha[5]=='1'?'1':'0').'.gif" onClick="save1(5);" style="cursor: pointer;"><A HREF="?p=6&showinbox='.$inbox.'&razdel=5">&nbsp;�������</A></TD>


									</TR>
								</TABLE>
								</TD>
							</TR>
							<TR>
							<TD align=center><B>';

					// �����
					echo $part2;
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




					if (($_SESSION['need_clear_curp']!=true) and ($user['in_tower']>0))
					{
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
					}
					elseif (($_SESSION['need_clear_curp']==true) and ($user['in_tower']==0))
					{
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


					$_SESSION['razdel'] = intval($_SESSION['razdel']);

					switch($_SESSION['razdel'])
					{
						case 1: //zakljatija
							$where = "AND `type` = 12 ";
							$grrr=$gruppovuha[1]=='1'?'1':'0';
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp1']; } else {$_SESSION['curp1']=$_GET['page'];}
						break;

						case 2: //pro4ee

								$filts="";
								if ($inbox==0)
									{
									$filts="  and (`prototype` < 15551 or `prototype` > 15568) ";
									}

							$where = "AND `type` > 12 AND `type` NOT IN (99,200,555,556,27,28,30,33,77)  AND `otdel` != 62  AND ( (`prototype` < 3001 or `prototype` > 3030) and (`prototype` < 103001 or `prototype` > 103030) ".$filts." ) ";
							$where .= 'AND NOT ((`prototype` > 3003000 and `prototype` < 3003100) or (`prototype` > 3003200 and `prototype` < 3003400) or (`prototype` > 3000 and `prototype` < 3030) or (`prototype` > 103000 and `prototype` < 103030) or (prototype >=1010000 and prototype <=1020000))';
							$grrr=$gruppovuha[2]=='1'?'1':'0';
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp2']; } else {$_SESSION['curp2']=$_GET['page'];}
						break;

						case 4: //podarki

							$where = "AND `type` IN (200) ";
							$grrr=($gruppovuha[4]=='1'?'1':'0');
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp4']; } else {$_SESSION['curp4']=$_GET['page'];}
						break;

						case 5: //�������
							$where = "AND ( (`prototype` > 3000 and `prototype` < 3030) or (`prototype` > 103000 and `prototype` < 103030) or otdel = 62)";
							$grrr= ($gruppovuha[5]=='1'?'1':'0');
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp5']; } else {$_SESSION['curp5']=$_GET['page'];}
						break;
				/*		case 6: //����� �����
							$where = "AND ((`prototype` > 3003000 and `prototype` < 3003100) or (`prototype` > 3003200 and `prototype` < 3003400))";
							$grrr= ($gruppovuha[6]=='1'?'1':'0');
							if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp6']; } else {$_SESSION['curp6']=$_GET['page'];}
						break;
						*/
						default: //abmundir
							if ($filt==4)
							{
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

					if ($inbox==0)
						{
						$addsql="`owner` = '{$user['id']}'  AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `can_drop` = 1 AND `labonly`=0 AND (cost>0 OR ecost>0 OR repcost>0 )   AND `setsale`=0 and dategoden=0 and arsenal_klan='' ";
						}
						else
						{
						//488 -- ��������� �� ��� �������� ������ ���� ������
						$addsql="`owner` = '488'  AND arsenal_owner='{$user[id]}'  ";
						}

					if($grrr == 1)
					{
						$sql = "SELECT *, count(*) as `itemscount` FROM (SELECT *, IF (dategoden = 0, 2052691200, dategoden) as dategoden2 FROM oldbk.`inventory` WHERE ".$addsql."  ".$where." AND id NOT IN (".GetDressedItems($user).")  ORDER by `dategoden2` ASC,`update` DESC) as `inv` GROUP BY `prototype` ORDER BY `update` DESC";
					} else {
						$sql = "SELECT * FROM oldbk.`inventory` WHERE ".$addsql." ".$where." AND id NOT IN (".GetDressedItems($user).") ORDER by `update` DESC";
					}
//echo $sql;
						$query = mysql_query($sql);
						$m_selectime = microtime(true) - $t1;
						echo '
						</TD>
						</TR>
						<TR><TD align=center><!--������-->
						<TABLE BORDER=0 WIDTH=100% CELLSPACING="0" CELLPADDING="1" BGCOLOR="#A5A5A5">';

							echo "<TR><TD colspan=2 align=center>";
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
									if($row['otdel']==7 || $row['otdel']==71 || $row['otdel']==72|| $row['otdel']==73)
									{
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

							if($grrr == 1)
							{
								$ret = "</TD></TR><TR><TD>";
								reset($inv_shmot);

								foreach ($inv_shmot as $key => $row)
								{
									if ((($_SESSION['allp'] != 1) and ($displc >= $_GET['page']*$_SESSION['lim']) AND ($displc < $_GET['page']*$_SESSION['lim']+$_SESSION['lim'])) || $_SESSION['allp'] == 1) {
										if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }

									if(!($row['otdel']==7 || $row['otdel']==71 || $row['otdel']==72|| $row['otdel']==73) )
									{
											if ($inbox==0)
											{
											$row[chk_arsenal]=77;
											$row[chk_arsenal_count]=$row['itemscount'];
											}
											else
											{
											$row[chk_arsenal]=66;
											$row[chk_arsenal_count]=$row['itemscount'];
											}
									}

										if ($row['itemscount'] == 1)
										{
											$ret .= "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";

											if ($row['art_param']!='')
											{

												if (is_array($art_bonus_array[$row['id']]))
												{
													$row['bonus_info']=$art_bonus_array[$row['id']]['info'];
												}
											}

											$ret .= showitem($row,0,false,$color,'',0,0,1);
											$ret .= "</table>";
										} else
										{
											$ret .= "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";



											$ret .= showitem($row,0,false,$color,'',0,0,1);
											$ret .= "<tr BGCOLOR='".$color."' ><td colspan=2>";
											$ret .= '<div  id=txt_'.$row['prototype'].' style="display: block;">';
											if ($row['otdel'] == "") $row['otdel'] = 0;
											$ret .= "<a href=\"#".$row['prototype']."\" Onclick=\"showhiddeninv(".$row['prototype'].",".$row['id'].",".$row['otdel'].");\"> �������� ��� ".($row['itemscount']-1)."��.</a>";

											 if ($inbox==0)
												{
												$ret.="<br><a href=?p=6&showinbox=0&grp=".$row['prototype']."> [�������� ���]</a></div>";
												}
												else
												{
												$ret.="<br><a href=?p=6&showinbox=1&grp=".$row['prototype']."> [������� ���]</a></div>";
												}


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

									if ($inbox==0)
									{
									$row[chk_arsenal]=77;
									}
									else
									{
									$row[chk_arsenal]=66;
									}

									if ((($_SESSION['allp'] != 1) and ($displcno >= $_GET['page']*$_SESSION['lim']) AND ($displcno < $_GET['page']*$_SESSION['lim']+$_SESSION['lim'])) || $_SESSION['allp'] == 1) {

										if ($row['art_param']!='')
										{

											if (is_array($art_bonus_array[$row['id']]))
											{
												$row['bonus_info']=$art_bonus_array[$row['id']]['info'];
											}
										}
										$ret .= showitem($row,0,false,$color,'',0,0,1);
									}

									$displcno++;
								}
								$displc = $count_all;
							}

							if ($_SESSION['allp']==1)
							{
								echo "[<a href='?p=6&showinbox=".$inbox."&razdel=".$razdel."&all=0'>��������</a>]";
							} else {
								$pgs[0]=$displc;

								$_GET['page']=(int)$_GET['page'];
								if (($_GET['page']*$_SESSION['lim']) >= $pgs[0]) {
									$_GET['page']=0;
									$_SESSION['curp'.$_SESSION['razdel']]=0;
									if ($pgs[0]>0)
										{
										echo "<script> location.reload();  </script>";
										}
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
											$pages_str.=($i==$page ? "&nbsp;<b>".($i+1)."</b>&nbsp;":"&nbsp;<a href='?p=6&showinbox=".$inbox."&razdel=".$razdel."&page=".($i)."'>".($i+1)."</a>&nbsp;");
									$pages_str.=($page<$pgs-5 ? "...":"");
									$pages_str=($page>4 ? "<a href='?p=6&showinbox=".$inbox."&razdel=".$razdel."&page=".($page-1)."'> < </a> ... ":"").$pages_str.(($page<($pgs-1) ? "<a href='?p=6&showinbox=".$inbox."&razdel=".$razdel."&page=".($page+1)."' > ></a> ":""));
								}

								$FirstPage=(ceil($pgs)>4 ? $_GET['page']>0 ? "<a href='?p=6&showinbox=".$inbox."&razdel=".$razdel."&page=0'>   << </a>":"":"");
								$LastPage=(ceil($pgs)>4 ? (ceil($pgs)-1)!=$_GET['page'] ? "<a href='?p=6&showinbox=".$inbox."&razdel=".$razdel."&page=".(ceil($pgs)-1)."'>   >> </a>":"":"");
								$pages_str=$FirstPage.$pages_str.$LastPage;
								echo $pages_str; echo " [<a href='?p=6&showinbox=".$inbox."&razdel=".$razdel."&all=1'>���</a>]";
							}


							if ($count === 0)
							{
								echo "<tr><td align=center bgcolor=#C7C7C7>�����</td></tr>";
							} else
							{
								echo $ret;
							}

							if ($pgs>1) {
								echo "<TR><TD colspan=2 align=center>";
								echo "��������: ";
								echo $pages_str;
								echo "</TD></TR>";
							}

						echo '
					</TABLE>
					</td></tr>
					</TABLE>
				</FORM>';
}

ob_start("ob_gzhandler");
//=========================================================
//  class
//=========================================================

	session_start();

include "connect.php";
include "functions.php";
include "bank_functions.php";

include "config_ko.php";

if ($_SESSION['bankid']>0)
	{
	//�������� �� ������������� �����
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' and owner='{$user['id']}' ;"));
	if (!($bank['id']>0))
		{
		//��� ����� = �����
		$_SESSION['bankid'] = null;
		unset($_SESSION['bankid']);
		}
	}

$KURS=40;
$prise_gold[777771]=1;
$prise_gold[777772]=10;
$prise_gold[777773]=20;

$dolla=array(5001,5002,5003,5005,5010,5015,5020,5025);

$podar_prise = array (
	"200001" =>1,
	"200002" =>2,
	"200005" =>5,
	"200010" =>10,
	"200025" =>25,
	"200050" =>50,
	"200100" =>100,
	"200250" =>250,
	"200500" =>500);


//������ ����� �����
$SMAGIC_start=mktime(0,0,0,3,22,date("Y"));
$SMAGIC_end=mktime(23,59,59,3,25,date("Y"));


//������ ����� ����������
$SVALENT_start=mktime(0,0,0,2,11,date("Y"));
$SVALENT_end=mktime(23,59,59,2,20,date("Y"));

//��������
$SSNOW_start=mktime(0,0,0,12,1,2015);
$SSNOW_end=mktime(23,59,59,2,29,2016);

//�����
$STBOX_start=mktime(0,0,0,10,9,2015);
$STBOX_end=mktime(23,59,59,11,6,2015);

//���������� ����
$EGG_start=mktime(0,0,0,4,25,2016);
$EGG_end=mktime(23,59,0,5,2,2016);

//������ ������

$BUKET_start=0;//$KO_start_time22;
$BUKET_end=0;//$KO_fin_time22;

//������ ����� �����
$SMAGIC_start=$KO_start_time25;
$SMAGIC_end=$KO_fin_time25;


$LORDBOX_start=$KO_start_time30;
$LORDBOX_end=$KO_fin_time30;

$EURO_start=$KO_start_time31;
$EURO_end=$KO_fin_time31;

$EXPRUN_start=$KO_start_time33;
$EXPRUN_end=$KO_fin_time33;

$GVIC_start=$KO_start_time34;
$GVIC_end=$KO_fin_time34;

$FALIGN_start=$KO_start_time36;
$FALIGN_end=$KO_fin_time36;

$IMPR_start=$KO_start_time37;
$IMPR_end=$KO_fin_time37;


$YARM_start =$KO_start_time28;
$YARM_end =$KO_fin_time28;

		if((isset($_COOKIE["link_from_com"])) and ($_COOKIE["link_from_com"]!=''))
		{
		header("Location: ".$_COOKIE["link_from_com"]);
		setcookie ("link_from_com", '',time()-86400,'/','.oldbk.com', false);//������� ����
		die();
		}


	if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com')
	{
	//�������� �� ������������ ���� ���� ���� ���������� �� �����
	if ((!($_SESSION['uid'] >0)) and (isset($_GET['ok'])))   { header("Location: http://avaloncity.oldbk.com/bank.php?ok=1"); die();}
	if ((!($_SESSION['uid'] >0)) and (isset($_GET['qiwi_ok'])))   { header("Location: http://avaloncity.oldbk.com/bank.php?qiwi_ok=1"); die();}
	if ((!($_SESSION['uid'] >0)) and (isset($_GET['err'])))  { header("Location: http://avaloncity.oldbk.com/bank.php?err=1"); die(); }
	}

	if ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com')
	{
	//�������� �� ������������ ���� ���� ���� ���������� �� �����
	if ((!($_SESSION['uid'] >0)) and (isset($_GET['ok'])))   { header("Location: http://angelscity.oldbk.com/bank.php?ok=1"); die();}
	if ((!($_SESSION['uid'] >0)) and (isset($_GET['qiwi_ok'])))   { header("Location: http://angelscity.oldbk.com/bank.php?qiwi_ok=1"); die();}
	if ((!($_SESSION['uid'] >0)) and (isset($_GET['err'])))  { header("Location: http://angelscity.oldbk.com/bank.php?err=1"); die(); }
	}

	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die();}

	if (isset($_GET['invload2']) && $user['battle'] == 0 && $user['battle_fin'] == 0 && ($_GET['p']==6) && isset($_GET['prototype'],$_GET['showinbox'],$_GET['id'],$_GET['otdel']))
	{
		$ib=(int)$_GET['showinbox'];
		if ($ib>1) $ib=1;
		if ($ib<0) $ib=0;
		load_hidden_items($ib);
	}

	 if ($user['klan']=='radminion')
	 {
	 //$EURO_start=time()-1;
	 //$SMAGIC_start=time()-1;
	 //$EXPRUN_start=time()-1;
	//$FALIGN_start=time()-1;
	 //$YARM_start=time()-1;
	 //$BUKET_start=time()-1;
	 //$BUKET_end=time()+1;
	 }



	if (isset($_GET['bn'])) {
		$q = mysql_query('SELECT login FROM users WHERE id = (SELECT owner FROM bank WHERE id = '.intval($_GET['bn']).') ');
		$bn = mysql_fetch_assoc($q);
		if (isset($bn['login'])) {
			echo htmlspecialchars($bn['login'],ENT_QUOTES);
			die();
		}
	}

	/*if ($user[klan]!='')
		{
		$get_klan=mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`clans` WHERE short='{$user['klan']}'"));
		if ($get_klan[id]>0)
			{
			include "clan_kazna.php";
			$IM_GLAVA=true;
			}
		}

	if ($IM_GLAVA) {$maxpages=6; $ph=16; $prp=6; } else {$maxpages=5;$ph=20; $prp=5; }
	*/

	$maxpages=6; $ph=16; $prp=6;

/*
	//���������� � ��������� ���������
 if ((($_POST['robo_type']) and ($_SESSION['bankid']>0) ) OR ($_POST['robo_type']==666)  )
 	{
			echo "<html>";
			echo "<body>";

			$RUR=get_rur_curs();
			$robo_amount=round(floatval($_POST['robo_amount']),2);

				 if ( ($_POST['robo_type']==1) and ($_POST['robo_param']==0) and $robo_amount>0 )
				 	{
				 	$MIN_ROBO=10; // ���.

						if ($robo_amount>=$MIN_ROBO )
				 		{
					 	// ������� �����
						//$robo_amount;	//�����
						$robo_amount_ekr=round($robo_amount/$RUR,2); // ����
						$robo_description='���������� �'.($_SESSION['bankid']).' ��� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_robo` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$robo_amount_ekr}',  `sum_rub`='{$robo_amount}' ,  `param`='0' , `description`='{$robo_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$robo_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ���������� '.$MIN_ROBO.' ���.');
							}
					}
					elseif ( ($_POST['robo_type']==666) and ($_POST['robo_param']==666) and $robo_amount>0 )
				 	{
				 	$MIN_ROBO=10; // ���.

						if ($robo_amount>=$MIN_ROBO )
				 		{
					 	// ������� ����� � �����
						//$robo_amount;	//�����
						$robo_amount_ekr=round($robo_amount/$RUR,2); // ����
						$robo_description='���������� ����� ����� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_robo` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$robo_amount_ekr}',  `sum_rub`='{$robo_amount}' ,  `param`='666' , `description`='{$robo_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$robo_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ���������� '.$MIN_ROBO.' ���.');
							}
					}
					elseif ( ($_POST['robo_type']==3) and ($_POST['robo_param']==300) and $robo_amount>0 )
					{
						// ������� ����
						//$robo_amount;	//�����
						$robo_amount_ekr=round($robo_amount/$RUR,2); // ����
						$kol=$robo_amount_ekr*600; //  ���� 1 ��� = 600 ����
						$robo_description='������� '.$kol.' ��������� ��� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_robo` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$robo_amount_ekr}',  `sum_rub`='{$robo_amount}' ,  `param`='300' , `description`='{$robo_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$robo_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
						 	}

					}
					elseif ( ($_POST['robo_type']==87) and ($_POST['robo_param']==88000) and $robo_amount>0 )
					{
						// ������� ����
						//$robo_amount;	//�����
						$robo_amount_ekr=round($robo_amount/$RUR,2); // ����

						$kol=$robo_amount_ekr*20; //  ���� 1 ��� =20 �����

						$robo_description='������� '.$kol.' ����� �� '.$robo_amount.'���., ��� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_robo` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$robo_amount_ekr}',  `sum_rub`='{$robo_amount}' ,  `param`='88000' , `description`='{$robo_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$robo_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
						 	}

					}


				 	if ($robo_order_id>0)
				 	{

					// your registration data
					$mrh_login = "OldBK";      // your login here
					$mrh_pass1 = "G8X5uAtwW9CZytz76nZE";   // merchant pass1 here

					// build CRC value
					$crc  = md5($mrh_login.":".$robo_amount.":".$robo_order_id.":".$mrh_pass1);

					$IncCurrLabel_str='';
					if ($_POST['robo_subtype']==25)
						{
						$IncCurrLabel='WMRRM';
						}
					else
					if ($_POST['robo_subtype']==26)
						{
						$IncCurrLabel='Qiwi50RIBRM';
						}
					else
					if ($_POST['robo_subtype']==27)
						{
						$IncCurrLabel='ElecsnetWalletRIBR'; //������� ��������
						}
					else
					if ($_POST['robo_subtype']==28)
						{
						$IncCurrLabel='AlfaBankRIBR'; // �����-����
						}
					else
					if ($_POST['robo_subtype']==29)
						{
						$IncCurrLabel='RussianStandardBankRIBR'; // "���� ������� ��������"
						}
					else
					if ($_POST['robo_subtype']==30)
						{
						$IncCurrLabel='BANKOCEAN3R'; //  ����� ���������� �����
						}
					else
					if ($_POST['robo_subtype']==31)
						{
						$IncCurrLabel='MixplatMTSRIBR'; //  ���
						}
					else
					if ($_POST['robo_subtype']==32)
						{
						$IncCurrLabel='PhoneTele2'; //  Tele2
						}
					else
					if ($_POST['robo_subtype']==33)
						{
						$IncCurrLabel='MixplatBeelineRIBR'; //  PhoneBeeline
						}
					else
					if ($_POST['robo_subtype']==34)
						{
						$IncCurrLabel='RapidaRIBEurosetR'; //  ��������
						}
					else
					if ($_POST['robo_subtype']==35)
						{
						$IncCurrLabel='RapidaRIBSvyaznoyR'; //  �������
						}
					else
					if ($_POST['robo_subtype']==36)
						{
						$IncCurrLabel='YandexMerchantRIBR'; //  ������
						}


					if ($IncCurrLabel!='') $IncCurrLabel_str="&IncCurrLabel=".$IncCurrLabel;

					// build URL
					$url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login".$IncCurrLabel_str."&OutSum=$robo_amount&InvId={$robo_order_id}&Desc={$robo_description}&SignatureValue=$crc";

					echo '<script language="JavaScript">
						location.href="'.$url.'";
						</script>';
					}



	}
else	*/
	//���������� � ��������� OKpay
 if ((($_POST['okpay_type']) and ($_SESSION['bankid']>0) ) OR ($_POST['okpay_type']==666)  )
 	{
					$RUR=get_rur_curs();
 					$IncCurrLabel_str='';
					$ok_currency='USD';
					$srow='sum_usd';

					if ($_POST['okpay_subtype']==41)
						{
						$IncCurrLabel='MTS';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==42)
						{
						$IncCurrLabel='TL2';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==43)
						{
						$IncCurrLabel='BLN';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==44)
						{
						$IncCurrLabel='MGF';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==45)
						{
						$IncCurrLabel='YMO';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==46)
						{
						$IncCurrLabel='QIW';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==47)
						{
						$IncCurrLabel='ALF';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==48)
						{
						$IncCurrLabel='SBR';
						$ok_currency='RUB';
						$srow='sum_rub';
						}
					else
					if ($_POST['okpay_subtype']==49)
						{
						$IncCurrLabel='VMF';
						}
					else
					if ($_POST['okpay_subtype']==50)
						{
						$IncCurrLabel='WMT';
						}
					else
					if ($_POST['okpay_subtype']==51)
						{
						$IncCurrLabel='BTC';
						}
					else
					if ($_POST['okpay_subtype']==52)
						{
						$IncCurrLabel='MFS';
						}
					else
					if ($_POST['okpay_subtype']==53)
						{
						$IncCurrLabel='WON';
						}
					else
					if ($_POST['okpay_subtype']==54)
						{
						$IncCurrLabel='PSB';
						}



			echo "<html>";
			echo "<body>";

			$okpay_amount=round(floatval($_POST['okpay_amount']),2);

				 if ( ($_POST['okpay_type']==1) and ($_POST['okpay_param']==0) and $okpay_amount>0 )
				 	{

				 	$MIN_OKPAY=1; // usd

					if ($_POST['okpay_subtype']==45)
						{
						$MIN_OKPAY=15; // usd
						}

					if ($ok_currency=='RUB')
							{
							$MIN_OKPAY=$MIN_OKPAY*$RUR; //  ���
							}


						if (round($okpay_amount,2) >= round($MIN_OKPAY,2) )
				 		{
					 	// ������� �����

					 			if ($ok_currency=='USD')
					 			{
								$okpay_amount_ekr=$okpay_amount; // ����
					 			}
					 			else
					 			{

					 			$okpay_amount_ekr=round($okpay_amount/$RUR,2); // ����
					 			}

						$okpay_description='���������� �'.($_SESSION['bankid']).' ��� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_okpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$okpay_amount_ekr}',  `{$srow}`='{$okpay_amount}', `currency`='{$ok_currency}' ,  `param`='0' , `description`='{$okpay_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$okpay_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ���������� '.$MIN_OKPAY.' '.$ok_currency.'.');
							}
					}
					elseif ( ($_POST['okpay_type']==666) and ($_POST['okpay_param']==666) and $okpay_amount>0 )
				 	{
				 	$MIN_OKPAY=1; // usd
					if ($_POST['okpay_subtype']==45)
						{
						$MIN_OKPAY=15; // usd
						}

							if ($ok_currency=='RUB')
							{
							$MIN_OKPAY=$MIN_OKPAY*$RUR; //  ���
							}


						if (round($okpay_amount,2) >= round($MIN_OKPAY,2) )
						{
					 	// ������� ����� � �����

							if ($ok_currency=='USD')
					 			{
								$okpay_amount_ekr=$okpay_amount; // ����
					 			}
					 			else
					 			{
					 			$okpay_amount_ekr=round($okpay_amount/$RUR,2); // ����
					 			}


						$okpay_description='���������� ����� ����� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_okpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$okpay_amount_ekr}',  `{$srow}`='{$okpay_amount}', `currency`='{$ok_currency}'  ,  `param`='666' , `description`='{$okpay_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$okpay_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ���������� '.$MIN_OKPAY.' '.$ok_currency.'.');
							}
					}
					elseif ( ($_POST['okpay_type']==3) and ($_POST['okpay_param']==300) and $okpay_amount>0 )
					{
					$MIN_OKPAY=1; // usd
					if ($_POST['okpay_subtype']==45)
						{
						$MIN_OKPAY=15; // usd
						}

						if ($ok_currency=='RUB')
							{
							$MIN_OKPAY=$MIN_OKPAY*$RUR; //  ���
							}


						if (round($okpay_amount,2) >= round($MIN_OKPAY,2) )
						{


							if ($ok_currency=='USD')
					 			{
								$okpay_amount_ekr=$okpay_amount; // ����
					 			}
					 			else
					 			{
					 			$okpay_amount_ekr=round($okpay_amount/$RUR,2); // ����
					 			}


						$kol=$okpay_amount_ekr*600; //  ���� 1 ��� = 600 ����

						$okpay_description='������� '.$kol.' ��������� ��� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_okpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$okpay_amount_ekr}',  `{$srow}`='{$okpay_amount}', `currency`='{$ok_currency}'  ,  `param`='300' , `description`='{$okpay_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$okpay_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ���������� '.$MIN_OKPAY.' '.$ok_currency.'.');
							}
					}
					elseif ( ($_POST['okpay_type']==87) and ($_POST['okpay_param']==88000) and $okpay_amount>0 )
					{
						// ������� �����
					$MIN_OKPAY=1; // usd
					if ($_POST['okpay_subtype']==45)
						{
						$MIN_OKPAY=15; // usd
						}

						if ($ok_currency=='RUB')
							{
							$MIN_OKPAY=$MIN_OKPAY*$RUR; //  ���
							}


						if (round($okpay_amount,2) >= round($MIN_OKPAY,2) )
						{
								if ($ok_currency=='USD')
					 			{
								$okpay_amount_ekr=$okpay_amount; // ����
					 			}
					 			else
					 			{
					 			$okpay_amount_ekr=round($okpay_amount/$RUR,2); // ����
					 			}

							$kol=floor($okpay_amount_ekr*20); //  ���� 1 ��� =20 �����

							$okpay_description='������� '.$kol.' ����� �� '.$okpay_amount.''.$ok_currency.', ��� ���������: '.$user['login'];

							mysql_query("INSERT INTO `oldbk`.`trader_balance_okpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$okpay_amount_ekr}',  `{$srow}`='{$okpay_amount}', `currency`='{$ok_currency}'  ,  `param`='88000' , `description`='{$okpay_description}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$okpay_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
							 	}
						 }
						 else
							{
							err('����������� ����� ������ ���������� '.$MIN_OKPAY.' '.$ok_currency.'.');
							}

					}
					elseif ( ($_POST['okpay_type']==88) and ($_POST['okpay_param']==88100||$_POST['okpay_param']==88500||$_POST['okpay_param']==881000  ) and ($_POST['amount_bil']==100||$_POST['amount_bil']==500||$_POST['amount_bil']==1000)  )
					{
						// ������� ����� - �����
					 	$gold_prise[100]=5;
					 	$gold_prise[500]=22.5;
					 	$gold_prise[1000]=35;
						$kol=(int)$_POST['amount_bil'];
						$param=(int)$_POST['okpay_param'];

						$okpay_amount_ekr=$gold_prise[$kol]; // ����

						if ($okpay_amount_ekr>0)
						{
						if ($ok_currency=='USD')
					 			{
								$okpay_amount=$okpay_amount_ekr;
					 			}
					 			else
					 			{
					 			$okpay_amount=ceil($okpay_amount_ekr * $RUR); //  �����
					 			}


							$okpay_description='������� '.$kol.' ����� �� '.$okpay_amount.''.$ok_currency.', ��� ���������: '.$user['login'];

							mysql_query("INSERT INTO `oldbk`.`trader_balance_okpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$okpay_amount_ekr}',  `{$srow}`='{$okpay_amount}', `currency`='{$ok_currency}'  ,  `param`='{$param}' , `description`='{$okpay_description}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$okpay_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
							 	}
						}
						else
						{
						echo "error!";
						}
					}
					elseif ( ($_POST['okpay_type']==18) and ((in_array($_POST['okpay_param'],$leto_bukets)))  and ($okpay_amount>0) )
			 		{
					if( ((time() > $BUKET_start && time() < $BUKET_end))   )
					 	{
					 		//�������  �������
					 		$param=(int)$_POST['okpay_param'];
					 		if ($leto_bukets_prise[$param]>0)
						 	{

								$okpay_amount_ekr=$leto_bukets_prise[$param]; // ���� ������� ���
								if ($ok_currency=='USD')
					 			{
								$okpay_amount=$okpay_amount_ekr;
					 			}
					 			else
					 			{
					 			$okpay_amount=$okpay_amount_ekr * ceil($RUR); //  �����
					 			}
								$okpay_description='������� �'.array_search($param, $leto_bukets).'� 1��.  ��� ���������: '.$user['login'];

								mysql_query("INSERT INTO `oldbk`.`trader_balance_okpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$okpay_amount_ekr}',  `{$srow}`='{$okpay_amount}', `currency`='{$ok_currency}'  ,  `param`='{$param}' , `description`='{$okpay_description}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$okpay_order_id=mysql_insert_id(); //���������� ID ������� � ����� ��������.
								 	}

					 		}
						}
		 			}





					else
					{
					echo "error";
					print_r($_POST);
					}


				 	if ($okpay_order_id>0)
				 	{

					//  ��� ����� ������ ����� ������������ �� ������
					// https://dev.okpay.com/manual/references/payment-methods.html
					//ok_payment_methods
					//ok_direct_payment




					if ($IncCurrLabel!='') $IncCurrLabel_str="&ok_direct_payment=".$IncCurrLabel;


					// build URL

					$okpay_description=iconv('windows-1251','UTF-8', $okpay_description);

					$url = "https://checkout.okpay.com?ok_receiver=admin@oldbk.com&ok_currency=".$ok_currency.$IncCurrLabel_str."&ok_item_1_type=service&ok_item_1_price={$okpay_amount}&ok_item_1_name={$okpay_description}&ok_item_1_article={$okpay_order_id}";



					echo '<script language="JavaScript">
						location.href="'.$url.'";
						</script>';
					}



	}
else
//���������� � ��������� ����� Paypal
 if (($_POST['paypal_type']) and ($_SESSION['bankid']>0) OR ($_POST['paypal_type']==666) )
		 	{
			echo "<html>";
			echo "<body>";

			$paypal_amount=round(floatval($_POST['paypal_amount']),2);


				 if ( ($_POST['paypal_type']==88) and ($_POST['paypal_param']==88200||$_POST['paypal_param']==88500||$_POST['paypal_param']==881000) and ($_POST['amount_bil']==200||$_POST['amount_bil']==500||$_POST['amount_bil']==1000) )
				 	{
				 	if ($paypal_amount>=10 )
				 		{
					 	// ������� �������
					 	$gold_prise[200]=10;
					 	$gold_prise[500]=22.5;
					 	$gold_prise[1000]=35;

					 	$paypal_amount_ekr=$gold_prise[$_POST['amount_bil']];

						$paypal_amount=round($paypal_amount_ekr*1.06);



						$paypal_array['currency']='USD';
						$paypal_array['description']='������� '.$_POST['amount_bil'].' ����� �� '.$paypal_amount.'$, ��� ���������: '.$user['login'];


						mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}',  `sum_real`='{$paypal_amount}' ,  `param`='{$_POST['paypal_param']}' , `description`='{$paypal_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 10$');
							}
				 	}
				 else
				 if ( ($_POST['paypal_type']==87) and ($_POST['paypal_param']==88000)  )
				 	{

						if ($_POST['amount_bil']>=200)
				 		{
				 		$kol=(int)($_POST['amount_bil']);
					 	// ������� �������
					 	$paypal_amount=round(($kol*1.06)/20,2);
						$paypal_amount_ekr=round(($kol)/20,2);

						$paypal_array['currency']='USD';
						$paypal_array['description']='������� '.$kol.' ����� �� '.$paypal_amount.'$, ��� ���������: '.$user['login'];


						mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}',  `sum_real`='{$paypal_amount}' ,  `param`='{$_POST['paypal_param']}' , `description`='{$paypal_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 200 �����');
							}
				 	}
				 else
				  if ( ($_POST['paypal_type']==666) and ($_POST['paypal_param']==666)  )
				 	{

						if ($paypal_amount>=10 )
				 		{
					 	// ������� �������
						$paypal_array['amount']=$paypal_amount;
						$paypal_amount_ekr=round($paypal_amount*0.94,2); //100% �����


						$paypal_array['currency']='USD';
						$paypal_array['description']='���������� ����� ����� �� '.$paypal_amount_ekr.' ���., ��� ���������: '.$user['login'];


						mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}',  `sum_real`='{$paypal_amount}' ,  `param`='666' , `description`='{$paypal_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 10$');
							}
				 	}
				 else
				 if ( ($_POST['paypal_type']==1) and ($_POST['paypal_param']==0) and $paypal_amount>0 )
				 	{
				 	if ($paypal_amount>=10 )
				 		{
					 	// ������� �����
						$paypal_array['amount']=$paypal_amount;
						$paypal_amount_ekr=round($paypal_amount*0.9433962264150943,2); //100% �����


						$paypal_array['currency']='USD';
						$paypal_array['description']='���������� �'.($_SESSION['bankid']).' ��� ���������: '.$user['login'];


						mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}',  `sum_real`='{$paypal_amount}' ,  `param`='0' , `description`='{$paypal_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						}
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 10$');
							}
				 	}
				 	/*
				 	elseif ( ($_POST['paypal_type']==5) and ($_POST['paypal_param']!='') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
					if ($paypal_amount>=10 )
					{
						 	// ������� ������� ���������� ������������
							$kol_bil=(int)$_POST['amount_bil']; // ���. �������
							$param=explode(':',$_POST['paypal_param']) ;
							$param=$param[2]; // ��� �����������

							$paypal_amount_ekr=$podar_prise[$param]*$kol_bil; // ���� �������
							$paypal_array['amount']=$podar_prise[$param]*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ����������� ����������� ���������� '.$podar_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";

								 }
					     }
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 10$');
							}
				 	} */
					elseif ( ($_POST['paypal_type']==79) and ($_POST['paypal_param']!='') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
			 		if (((time() >= $EXPRUN_start) && time() < $EXPRUN_end))
			 		 {
						if ($paypal_amount>=10 )
					   	{
							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;
							$param=$param[2]; // ���

						if (in_array($param,$exprun_param))
						 {
							$paypal_amount_ekr=$exprun_prise[$param]*$kol_bil; // ���� �������
							$paypal_array['amount']=ceil($exprun_prise[$param]*$kol_bil*1.06); // ���� �������

							$paypal_amount=$paypal_array['amount'];

							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ������ ������� ����� '.$exprun_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								/* echo $paypal_array['amount'] ;
								 echo "/";
								 echo $paypal_amount ;
								 */
								 }
						 }
					     }
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 10$');
							}
					   }
				 	}
					elseif ( ($_POST['paypal_type']==61) and ($_POST['paypal_param']!='') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
						if( ((time() > $IMPR_start && time() < $IMPR_end))   )
			 		 {
						if ($paypal_amount>=10 )
					   	{
							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;
							$param=$param[2]; // ���

						if (in_array($param,$artup_param))
						 {
							$paypal_amount_ekr=$artup_prise[$param]*$kol_bil; // ���� �������
							$paypal_array['amount']=ceil($artup_prise[$param]*$kol_bil*1.06); // ���� �������

							$paypal_amount=$paypal_array['amount'];

							$paypal_array['currency']='USD';
							$paypal_array['description']='������� '.$artup_name[$param].' ���������� '.$artup_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								/* echo $paypal_array['amount'] ;
								 echo "/";
								 echo $paypal_amount ;
								 */
								 }
						 }
					     }
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 10$');
							}
					   }
				 	}
					/*elseif ( ($_POST['paypal_type']==11) and ($_POST['paypal_param']=='90') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $KO_start_time23) && time() < $KO_fin_time23))
				 		{
					 	if ((int)$_POST['amount_bil']>=4)
				 		{
							$kol_bil=(int)$_POST['amount_bil']; // ���.

				 			if ($kol_bil>=25)
				 						{
										$paypal_amount_ekr=2*$kol_bil; // ���� �������	2 ���
										$pp=2;
			 							$param=89;
										$paypal_array['amount']=2*$kol_bil*1.06; // ���� �������
				 						}
				 						else
				 						{
				 						$param=90;
										$pp=3;
										$paypal_amount_ekr=3*$kol_bil; // ���� �������	3 ���
										$paypal_array['amount']=3*$kol_bil*1.06; // ���� �������
				 						}

							$paypal_amount=$paypal_array['amount'];
							$paypal_array['currency']='USD';
							$paypal_array['description']='������� �������� � ����� ����������� ���������� '.$pp.' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ���������� ��� ������ ����� Paypal 4 ��.');
						 	}
						 }
				 	}*/
					elseif ( ($_POST['paypal_type']==10) and ($_POST['paypal_param']=='91') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $SMAGIC_start) && time() < $SMAGIC_end))
				 		{
					 	if ((int)$_POST['amount_bil']>=2)
				 		{

							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;

							$param=91;

							$paypal_amount_ekr=5*$kol_bil; // ���� �������
							$paypal_array['amount']=5*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='������� �������� ������ ������ ����� ������ ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ���������� ��� ������ ����� Paypal 2 ��.');
						 	}
						 }
				 	}
					elseif ( ($_POST['paypal_type']==51) and ($_POST['paypal_param']=='51') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $EURO_start) && time() < $EURO_end))
				 		{
					 	if ((int)$_POST['amount_bil']>=2)
				 		{

							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;

							$param=51;

							$paypal_amount_ekr=5*$kol_bil; // ���� �������
							$paypal_array['amount']=5*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ���� �����-2016� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ���������� ��� ������ ����� Paypal 2 ��.');
						 	}
						 }
				 	}
					elseif ( ($_POST['paypal_type']==52) and ($_POST['paypal_param']=='52') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $EURO_start) && time() < $EURO_end))
				 		{
					 	if ((int)$_POST['amount_bil']>=5)
				 		{

							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;

							$param=52;

							$paypal_amount_ekr=2*$kol_bil; // ���� �������
							$paypal_array['amount']=2*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='�������  ����� �����-2016�  ���������� 2 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ���������� ��� ������ ����� Paypal 5 ��.');
						 	}
						 }
				 	}
					elseif ( ($_POST['paypal_type']==53) and ($_POST['paypal_param']=='53') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $GVIC_start) && time() < $GVIC_end))
				 		{

							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;

							$param=53;

							$paypal_amount_ekr=50*$kol_bil; // ���� �������
							$paypal_array['amount']=50*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ������ ������� �����  ���������� 50 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }

						 }
				 	}
					elseif ( ($_POST['paypal_type']==81) and ($_POST['paypal_param']=='81') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $LORDBOX_start) && time() < $LORDBOX_end))
				 		{
					 	if ((int)$_POST['amount_bil']>=2)
				 		{

							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;

							$param=81;

							$paypal_amount_ekr=5*$kol_bil; // ���� �������
							$paypal_array['amount']=5*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ������� ����� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ���������� ��� ������ ����� Paypal 2 ��.');
						 	}
						 }
				 	}
					elseif ( ($_POST['paypal_type']==84) and ($_POST['paypal_param']=='84') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if ((time() >= $EGG_start) && (time() < $EGG_end))
						{
					 	if ((int)$_POST['amount_bil']>=2)
				 		{

							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;

							$param=84;

							$paypal_amount_ekr=5*$kol_bil; // ���� �������
							$paypal_array['amount']=5*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ���� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ���������� ��� ������ ����� Paypal 2 ��.');
						 	}
						 }
				 	}
					elseif ( ($_POST['paypal_type']==236) and ( $_POST['paypal_param']=='2'||$_POST['paypal_param']=='3'||$_POST['paypal_param']=='6')  and ($paypal_amount>0)  )
				 	{
						if( ((time() > $FALIGN_start && time() < $FALIGN_end))   )
						{

							$param=(int)$_POST['paypal_param'];

							$paypal_amount_ekr=15; // ���� �������
							$paypal_array['amount']=15*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];
							$sklonka_array_name=array(2=>"����������� ����������", 3=>"������ ����������", 6=>"������� ����������");
							$paypal_array['currency']='USD';
							$paypal_array['description']='������� '.$sklonka_array_name[$param].' ���������� 15 ��� ��� ���������: '.$user['login'];

							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								$param=600+$param;
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id();
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
				 	}
					elseif ( ($_POST['paypal_type']==60) and $_POST['paypal_param']=='60'  and ($paypal_amount>0)  )
				 	{
						if( ((time() > $IMPR_start && time() < $IMPR_end))   )
						{
					 	if ($paypal_amount>10)
				 		{
							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=60;

							$paypal_amount_ekr=15*$kol_bil; // ���� �������
							$paypal_array['amount']=ceil(15*$kol_bil*1.06); // ���� �������
							$paypal_amount=$paypal_array['amount'];

							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ������ �������� ��������� III� ���������� 15 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ����� ��� ������ ����� Paypal 10$');
						 	}
						 }
				 	}
					elseif ( ($_POST['paypal_type']==7) and ($_POST['paypal_param']=='95') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if ((time() >= $SSNOW_start) && (time() < $SSNOW_end))
						{
					 	if ((int)$_POST['amount_bil']>=10)
				 		{

							$kol_bil=(int)$_POST['amount_bil']; // ���.
							$param=explode(':',$_POST['paypal_param']) ;

							$param=95;

							$paypal_amount_ekr=1*$kol_bil; // ���� �������
							$paypal_array['amount']=1*$kol_bil*1.06; // ���� �������
							$paypal_amount=$paypal_array['amount'];


							$paypal_array['currency']='USD';
							$paypal_array['description']='������� �������� ���������� 1 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($paypal_array['amount']==$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
						 }
						 else
						 	{
						 	err('����������� ���������� ��� ������ ����� Paypal 10 ��.');
						 	}
						 }
				 	}
					elseif ( ($_POST['paypal_type']==9) and ($_POST['paypal_param']=='92') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
						 	if ((time() >= $SVALENT_start) && (time() < $SVALENT_end))
					 		{
						 	if ((int)$_POST['amount_bil']>=10)
						 		{

									$kol_bil=(int)$_POST['amount_bil']; // ���.
									$param=explode(':',$_POST['paypal_param']) ;

									$param=92; // ���

									$paypal_amount_ekr=1*$kol_bil; // ���� �������
									$paypal_array['amount']=1*$kol_bil*1.06; // ���� �������
									$paypal_amount=$paypal_array['amount'];


									$paypal_array['currency']='USD';
									$paypal_array['description']='������� �����-���������� ���������� 1 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
									if ($paypal_array['amount']==$paypal_amount) // �������� ���
										{
										mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
										 if (mysql_affected_rows()>0)
										 	{
											$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
										 	}
										 }
										 else
										 {
										 echo "Error";
										 }
								 }
								 else
								 	{
								 	err('����������� ���������� ��� ������ ����� Paypal 10 ��.');
								 	}
								 }
				 	}
				 	elseif ( ($_POST['paypal_type']==6) and ($_POST['paypal_param']!='') and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
			 		if ($paypal_amount>=10 )
			 			{
					 	if ((time() >= $STBOX_start) && (time() < $STBOX_end))
				 		{
					 	// �������  ����
						$kol_bil=1; // ���. ����
						$paypal_array['amount']=5*1.06; // ���� �������

						$paypal_amount=$paypal_array['amount'];
						$paypal_amount_ekr=5;

						$paypal_array['currency']='USD';
						$param=94;// ������� �����
						$paypal_array['description']='������� ����� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
						 if (mysql_affected_rows()>0)
							 	{
								$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
						}
						}
						else
							{
							err('����������� ����� ������ ����� Paypal ���������� 10$');
							}
				 	}
				 	elseif ( ($_POST['paypal_type']==3) and ($_POST['paypal_param']==300) and ($paypal_amount>0) )
				 	{
				 	if ($paypal_amount>=10 )
			 			{
					 	// �������  ���������
						$param=300; // ��� ��������
						$paypal_array['amount']=$paypal_amount; // ���� �������

						$paypal_amount_ekr=round($paypal_amount*0.95238,2); //100% �����

						$paypal_array['currency']='USD';
						$paypal_array['description']='������� ��������� ��� ���������: '.$user['login'];

							mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
						 }
						 else
						 {
						 err('����������� ����� ������ ����� Paypal ���������� 10$');
						 }

				 	}
					elseif ( ($_POST['paypal_type']==4) and ($_POST['paypal_param']==33333) and ($paypal_amount>0) and ((int)$_POST['amount_bil']>0)  )
				 	{
				 	if ($paypal_amount>=10 )
			 			{

						 	// ������� ������� ���������� �������
							$kol_bil=intval($_POST['amount_bil']); // ���. �������
							$param=33333; // ���  ������

							$bil_cost=2;
							$paypal_array['amount']=$bil_cost*$kol_bil*1.06; // ���� �������

							$paypal_amount_ekr=$bil_cost*$kol_bil; // ���� �������

							$paypal_array['currency']='USD';
							$paypal_array['description']='������� ������� '.$bil_cost.' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_amount_ekr}' ,  `sum_real`='{$paypal_array['amount']}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}


					        }
					        else
					        	{
       							 err('����������� ����� ������ ����� Paypal ���������� 10$');
					        	}
				 	}
				 	/*
					elseif ( ($_POST['paypal_type']==2)  and ($paypal_amount>0) )
				 	{
				 	// �������  ����.����
					$param=explode(":",$_POST['paypal_param']);
					$akk_type=$param[0]; 	 // ��� �������� 1 - Silver 2-gold 3-platina
					$sub_type=$param[1]; 	 // ������
//					$ekr_cost=$param[2]; 	 // ���� �� ������

					$paypal_array['amount']=$new_akks_prise[$akk_type][$sub_type]; // ���� �������

					$paypal_amount=round(($paypal_array['amount']*1.06),2); // �����

					$paypal_array['currency']='USD';
					$paypal_array['description']='������� '.$prem_akk_name[$akk_type].' ��� ���������: '.$user['login'];

					if ($paypal_amount>=10 )
						{
						$p=($akk_type*100)+$sub_type;

						mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_array['amount']}' ,  `sum_real`='{$paypal_amount}' , `param`='{$p}' , `description`='{$paypal_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						 }
						else
					        	{
       							 err('����������� ����� ������ ����� Paypal ���������� 10$');
					        	}
				 	}*/
					elseif ( ($_POST['paypal_type']==8) and ((in_array($_POST['paypal_param'],$larec_param)))  and ($paypal_amount>0) )
			 		{
					if (((time()>$ny_events['larcistart']) and (time()<$ny_events['larciend']))  )
						{
					 	if (test_larec($larec_type[$_POST['paypal_param']],$user))
				 		{
				 		//������� ������
				 		$param=$_POST['paypal_param'];
				 		if ($larec_prise[$param]>0)
					 	{

 							$param=(int)($_POST['paypal_param']);
							$paypal_array['amount']=$larec_prise[$param]; // ���� �������
							$paypal_array['currency']='USD';
							$paypal_array['description']='������� �'.$larec_name[$param].'� 1��.  ��� ���������: '.$user['login'];

							if ($paypal_array['amount']<$paypal_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_array['amount']}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }
				 		}
		 				}
		 				else
				 		{
					 	 err('<p><b><font color="red">������! ������ ������� ���� ��� ��� � ������� ���� � ��� �� ������ �������� ����� ������� 50 ��. � �����!</font></b></p>');
		 				}
		 				}
		 			}
					elseif ( ($_POST['paypal_type']==8) and ((in_array($_POST['paypal_param'],$bukets)))  and ($paypal_amount>0) )
			 		{
					if( ((time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']))   )
					 	{
					 		//������� ����
					 		$param=$_POST['paypal_param'];
					 		if ($bukets_prise[$param]>0)
						 	{

	 							$param=(int)($_POST['paypal_param']);
								$paypal_array['amount']=$bukets_prise[$param]; // ���� �������
								$paypal_array['currency']='USD';
								$paypal_array['description']='������� �'.array_search($param, $bukets).'� 1��.  ��� ���������: '.$user['login'];
								if ($paypal_array['amount']<$paypal_amount) // �������� ���
									{
									mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_array['amount']}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
									 if (mysql_affected_rows()>0)
									 	{
										$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
									 	}
									 }
									 else
									 {
									 echo "Error";
									 }
					 		}
						}
		 			}
					elseif ( ($_POST['paypal_type']==18) and ((in_array($_POST['paypal_param'],$leto_bukets)))  and ($paypal_amount>0) )
			 		{
					if( ((time() > $BUKET_start && time() < $BUKET_end))   )
					 	{
					 		//�������  �������
					 		$param=$_POST['paypal_param'];
					 		if ($leto_bukets_prise[$param]>0)
						 	{

	 							$param=(int)($_POST['paypal_param']);
								$paypal_array['amount']=$leto_bukets_prise[$param]; // ���� �������
								$paypal_array['currency']='USD';
								$paypal_array['description']='������� �'.array_search($param, $leto_bukets).'� 1��.  ��� ���������: '.$user['login'];
								if ($paypal_array['amount']<$paypal_amount) // �������� ���
									{
									mysql_query("INSERT INTO `oldbk`.`trader_balance_paypal` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$paypal_array['amount']}' ,  `sum_real`='{$paypal_amount}' , `param`='{$param}' , `description`='{$paypal_array['description']}' ;");
									 if (mysql_affected_rows()>0)
									 	{
										$paypal_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
									 	}
									 }
									 else
									 {
									 echo "Error";
									 }
					 		}
						}
		 			}

				 	/*
				 	else
				 	{
				 	print_r($_POST);
				 	}
				 	*/


				 	if ($paypal_array['order_id']>0)
				 	{
					$paypal_array['description']=iconv('windows-1251','UTF-8', $paypal_array['description']);
					///admin@oldbk.com

						echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post"  name="frm" >
							<input name="cmd" type="hidden" value="_xclick" />
							<input name="business" type="hidden" value="darlibank@gmail.com" />
							<input name="item_name" type="hidden" value="'.$paypal_array['description'].'" />
							<input name="item_number" type="hidden" value="'.$paypal_array['order_id'].'" />
							<input name="amount" type="hidden" value="'.$paypal_amount.'" />
							<input name="no_shipping" type="hidden" value="1" />
							<input name="rm" type="hidden" value="2" />
							<input name="lc" type="hidden" value="en_US" />
							<input name="return" type="hidden" value="http://capitalcity.oldbk.com/bank.php?paypal=ok" />
							<input name="cancel_return" type="hidden" value="http://capitalcity.oldbk.com/bank.php?paypal=false" />
							<input name="currency_code" type="hidden" value="'.$paypal_array['currency'].'" />
							<input type="submit" value="�������� ����� PayPal" />
							</form>';
							//<input name="notify_url" type="hidden" value="http://site.ru/order/paypallistener/" />

						echo '<script language="JavaScript">
						document.frm.submit();
						</script>';
					}
			echo "</body>";
		 	echo "</html>";
		 	die();
		 	}
	else
	//���������� � ��������� liqpay
		 if (($_POST['liqpay_type']) and ($_SESSION['bankid']>0) OR ($_POST['liqpay_type']==666) )
		 	{
			echo "<html>";
			echo "<body>";
//print_r($_POST);
			//$private_key='D7PO0DyXKDEJRYj5yLAGCaW8KCkv8dAm9neWU9KV'; //  �������
			$private_key='P7ROKlOYV2ARpeBeADF7aQ25b0PTNi0IGrCKhNyN';


			$liqpay_array['version']=3;
//			$liqpay_array['public_key']='i54722317627';	// ������� �� ������ ��������� ���� - ������������� ��������. �������� ���� ����� � ���������� ��������
			$liqpay_array['public_key']='i85877192887';

			$liqpay_array['recurringbytoken']=0;		//default 0 ���� �������� ��������� ������������ card_token �����������, ������� �� �������� � callback ������� �� server_url. card_token ��������� ��������� ������� � offline ��������� ����� payment/paytoken. ������ ������������ ����� ��������� LiqPay. ��������� ��������: 1
			$liqpay_array['type']='buy';
			$liqpay_array['server_url']='http://capitalcity.oldbk.com/bank_result_liqpay.php'; //����������
			$liqpay_array['result_url']='http://capitalcity.oldbk.com/bank.php?liqpayok=true'; //��������� ����� ������

			$liqpay_array['sandbox']=0; //�������� �������� ����� ��� �������������. ������ �� ����� �� �����������. ����� �������� �������� �����, ���������� �������� �������� 1. ��� �������� ������� ����� ����� ������ sandbox - �������� �������� ������.

			 if ($_POST['liqpay_privat'])
			{
			 $liqpay_array['paytypes'] = 'privat24';
			}

			$liqpay_amount=round(floatval($_POST['liqpay_amount']),2);

				 if ( ($_POST['liqpay_type']==1) and ($_POST['liqpay_param']==0) and $liqpay_amount>0 )
				 	{
				 	// ������� �����
					$liqpay_array['amount']=$liqpay_amount;
					$liqpay_array['currency']='USD';
					$liqpay_array['description']='���������� �'.($_SESSION['bankid']).' ��� ���������: '.$user['login'];
					mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='0' , `description`='{$liqpay_array['description']}' ;");
					 if (mysql_affected_rows()>0)
					 	{
						$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
					 	}

				 	}
				 	elseif ( ($_POST['liqpay_type']==88) and ($_POST['liqpay_param']==88100||$_POST['liqpay_param']==88500||$_POST['liqpay_param']==881000) and ($_POST['amount_bil']==100||$_POST['amount_bil']==500||$_POST['amount_bil']==1000) )
				 	{
						// ������� �������
					 	$gold_prise[100]=5;
					 	$gold_prise[500]=22.5;
					 	$gold_prise[1000]=35;


					$liqpay_amount=$gold_prise[$_POST['amount_bil']];
					$liqpay_array['amount']=$liqpay_amount;


					$liqpay_array['currency']='USD';
					$liqpay_array['description']='������� '.$_POST['amount_bil'].' ����� �� '.$liqpay_amount.'USD, ��� ���������: '.$user['login'];



					mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$_POST['liqpay_param']}' , `description`='{$liqpay_array['description']}' ;");
					 if (mysql_affected_rows()>0)
					 	{
						$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
					 	}

				 	}
				 	elseif ( ($_POST['liqpay_type']==666) and ($_POST['liqpay_param']==666) and $liqpay_amount>0 )
				 	{
				 	// ������� �����
					$liqpay_array['amount']=$liqpay_amount;
					$liqpay_array['currency']='USD';
					$liqpay_array['description']='���������� �������� ����� �� '.$liqpay_amount.' ���.,  ��� ���������: '.$user['login'];
					mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='666' , `description`='{$liqpay_array['description']}' ;");
					 if (mysql_affected_rows()>0)
					 	{
						$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
					 	}

				 	}
				 	elseif ( ($_POST['liqpay_type']==87) and ($_POST['liqpay_param']==88000)  )
				 	{
				 		if ($_POST['amount_bil']>=20)
				 			{
							 	$kol=(int)$_POST['amount_bil'];
								$liqpay_array['amount']=round($kol*0.05,2);
								$liqpay_amount=$liqpay_array['amount'];
								$liqpay_array['currency']='USD';
								$liqpay_array['description']='������� '.$_POST['amount_bil'].' ����� �� '.$liqpay_amount.'USD, ��� ���������: '.$user['login'];



								mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$_POST['liqpay_param']}' , `description`='{$liqpay_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
							}
							else
							{
							err('����������� ����� ������ ���������� 20 �����');
							}
				 	}
				 	/*
				 	elseif ( ($_POST['liqpay_type']==5) and ($_POST['liqpay_param']!='') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// ������� ������� ���������� ������������
					$kol_bil=(int)$_POST['amount_bil']; // ���. �������
					$param=explode(':',$_POST['liqpay_param']) ;
					$param=$param[2]; // ��� �����������
					$liqpay_array['amount']=$podar_prise[$param]*$kol_bil; // ���� �������
					$liqpay_array['currency']='USD';
					$liqpay_array['description']='������� ����������� ����������� ���������� '.$podar_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
					if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						 }
						 else
						 {
						 echo "Error";

						 }
				 	} */
				 	elseif ( ($_POST['liqpay_type']==79) and ($_POST['liqpay_param']!='') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// �������
			 		if (((time() >= $EXPRUN_start) && time() < $EXPRUN_end))
				 	   {
						$kol_bil=(int)$_POST['amount_bil']; // ���. �������
						$param=explode(':',$_POST['liqpay_param']) ;
						$param=$param[2]; // ���

						if (in_array($param,$exprun_param))
						{
							$liqpay_array['amount']=$exprun_prise[$param]*$kol_bil; // ���� �������
							$liqpay_array['currency']='USD';
							$liqpay_array['description']='������� ������ ������� ����� ���������� '.$exprun_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								/* echo $liqpay_array['amount'] ;
								 echo "/";
								 echo $liqpay_amount ;
								 */
								 }
						}
					   }
				 	}
					elseif ( ($_POST['liqpay_type']==61) and ($_POST['liqpay_param']!='') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{

				 	// �������
						if( ((time() > $IMPR_start && time() < $IMPR_end))   )
				 	   {

						$kol_bil=(int)$_POST['amount_bil']; // ���. �������
						$param=explode(':',$_POST['liqpay_param']) ;
						$param=$param[2]; // ���

						if (in_array($param,$artup_param))
						{

							$liqpay_array['amount']=$artup_prise[$param]*$kol_bil; // ���� �������
							$liqpay_array['currency']='USD';
							$liqpay_array['description']='������� '.$artup_name[$param].' ���������� '.$artup_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								/* echo "Error";
								 echo $liqpay_array['amount'] ;
								 echo "/";
								 echo $liqpay_amount ;
								*/
								 }
						}
						else
						{
						//echo "err";
						}
					   }
				 	}
					/*
					elseif ( ($_POST['liqpay_type']==11) and ($_POST['liqpay_param']=='90') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $KO_start_time23) && time() < $KO_fin_time23))
				 		{
						$kol_bil=(int)$_POST['amount_bil']; // ���.

								if ($kol_bil>=25)
										{
										$param=89;
										$pp=2;
										$liqpay_array['amount']=2*$kol_bil; // ���� �������
										}
										else
										{
										$param=90;
										$pp=3;
										$liqpay_array['amount']=3*$kol_bil; // ���� �������
										}


						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� �������� � ����� ����������� ���������� '.$pp.' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";

							 }
						}
				 	}	*/
					elseif ( ($_POST['liqpay_type']==10) and ($_POST['liqpay_param']=='91') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
					if (((time() >= $SMAGIC_start) && time() < $SMAGIC_end))
				 		{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=91;
						$liqpay_array['amount']=5*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� �������� ������ ������ ����� ������ ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==51) and ($_POST['liqpay_param']=='51') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
					if (((time() >= $EURO_start) && time() < $EURO_end))
				 		{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=51;
						$liqpay_array['amount']=5*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� ���� �����-2016� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==52) and ($_POST['liqpay_param']=='52') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
					if (((time() >= $EURO_start) && time() < $EURO_end))
				 		{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=52;
						$liqpay_array['amount']=2*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� ����� �����-2016� ���������� 2 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==53) and ($_POST['liqpay_param']=='53') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	if (((time() >= $GVIC_start) && time() < $GVIC_end))
				 		{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=53;
						$liqpay_array['amount']=50*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� ������ ������� �����  ���������� 50 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==81) and ($_POST['liqpay_param']=='81') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
					if (((time() >= $LORDBOX_start) && time() < $LORDBOX_end))
				 		{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=81;
						$liqpay_array['amount']=5*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� ������� ����� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==84) and ($_POST['liqpay_param']=='84') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{

				 	if ((time() >= $EGG_start) && (time() < $EGG_end))
						{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=84;
						$liqpay_array['amount']=5*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� ���� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==60) and ($_POST['liqpay_param']=='60') and ((int)$_POST['amount_bil']>0) )
				 	{
						if( ((time() > $IMPR_start && time() < $IMPR_end))   )
						{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=60;

						$liqpay_array['amount']=15*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� ������ �������� ��������� III� ���������� 15 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==236) and ( $_POST['liqpay_param']=='2'||$_POST['liqpay_param']=='3'||$_POST['liqpay_param']=='6')  and ($liqpay_amount>0)  )
				 	{
						if( ((time() > $FALIGN_start && time() < $FALIGN_end))   )
						{

							$param=(int)$_POST['liqpay_param'];
							$liqpay_array['amount']=15; // ���� �������
							$liqpay_array['currency']='USD';
							$sklonka_array_name=array(2=>"����������� ����������", 3=>"������ ����������", 6=>"������� ����������");
							$liqpay_array['description']='������� '.$sklonka_array_name[$param].' ���������� 15 ��� ��� ���������: '.$user['login'];

							if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
								{
								$param=600+$param;
								mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error cost";
								/* echo $liqpay_array['amount'] ;
								 echo "/";
								 echo $liqpay_amount ;
								*/
								 }
						 }
				 	}

				 	elseif ( ($_POST['liqpay_type']==7) and ($_POST['liqpay_param']=='95') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// ������� ��������
				 	if ((time() >= $SSNOW_start) && (time() < $SSNOW_end))
						{
						$kol_bil=(int)$_POST['amount_bil']; // ���.
						$param=95;
						$liqpay_array['amount']=1*$kol_bil; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='������� �������� ���������� 1 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
						if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
							{
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
							 }
							 else
							 {
							 echo "Error";
							/* echo $liqpay_array['amount'] ;
							 echo "/";
							 echo $liqpay_amount ;
							 */
							 }
						}
				 	}
					elseif ( ($_POST['liqpay_type']==9) and ($_POST['liqpay_param']=='92') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// �������  ����������
					 	if ((time() >= $SVALENT_start) && (time() < $SVALENT_end))
			 			{
								$kol_bil=(int)$_POST['amount_bil']; // ���.
								$param=92;
								$liqpay_array['amount']=1*$kol_bil; // ���� �������
								$liqpay_array['currency']='USD';
								$liqpay_array['description']='������� �����-���������� ���������� 1 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
								if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
									{
									mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
									 if (mysql_affected_rows()>0)
									 	{
										$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
									 	}
									 }
									 else
									 {
									 echo "Error";
									/* echo $liqpay_array['amount'] ;
									 echo "/";
									 echo $liqpay_amount ;
									 */
									 }
						}
				 	}
				 	elseif ( ($_POST['liqpay_type']==6) and ($_POST['liqpay_param']!='') and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// �������  ����
				 	if ((time() >= $STBOX_start) && (time() < $STBOX_end))
				 		{
							$kol_bil=1; // ���. ����
							$liqpay_array['amount']=5; // ���� �������
							$liqpay_array['currency']='USD';
							$param=94;// ������� �����
							$liqpay_array['description']='������� ����� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_array['amount']}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
								 	{
									$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
						}
				 	}

				 	elseif ( ($_POST['liqpay_type']==3) and ($_POST['liqpay_param']==300) and ($liqpay_amount>0) )
				 	{
				 	// �������  ���������
					$param=300; // ��� ��������
					$liqpay_array['amount']=$liqpay_amount; // ���� �������
					$liqpay_array['currency']='USD';
					$liqpay_array['description']='������� ��������� ��� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
				 	}
				 	elseif(  (($_POST['liqpay_type']==2018) and ($_POST['liqpay_param']==2018) and ($liqpay_amount==65)) OR (($_POST['liqpay_type']>=1 AND $_POST['liqpay_type']<=5) and ($_POST['liqpay_param']==2118) and ($liqpay_amount==70))  )
				 	{
						$maqxb=70;
                		        	$last_bil_id=mysql_fetch_array(mysql_query("select id from bilet ORDER by id desc limit 1;"));
              		        		if (($last_bil_id[id]<$maqxb) and ( (time() > mktime(0,0,0,12,1,2017) && time() < mktime(23,59,59,12,29,2017)) OR $user['klan']=='radminion' ) )
              		        		{
              		        			if ($_POST['liqpay_param']==2118)
              		        			{
              		        			$size=(int)$_POST['liqpay_type'];
              		        			$param="2".$size."18"; // ���� ��� ���� 2118,2218,2318,2418,2518 ;
              		        			}
              		        			else
              		        			{
							$param=$_POST['liqpay_param']; // 2018 - ��� �����
							}

						$liqpay_array['amount']=$liqpay_amount; // ���� �������
						$liqpay_array['currency']='USD';
						$liqpay_array['description']='����� �� 8-����� ����� ��� ���������: '.$user['login'];

							mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
							 if (mysql_affected_rows()>0)
							 	{
								$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
							 	}
						}
				 	}
					elseif ( ($_POST['liqpay_type']==4) and ($_POST['liqpay_param']==33333) and ($liqpay_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// ������� ������� ���������� �������
					$kol_bil=(int)$_POST['amount_bil']; // ���. �������
					$param=33333; // ���  ������
					$bil_cost=2;
					$liqpay_array['amount']=$bil_cost*$kol_bil; // ���� �������
					$liqpay_array['currency']='USD';
					$liqpay_array['description']='������� ������� '.$bil_cost.' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];
					if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						 }
						 else
						 {
						 echo "Error";
						 }
				 	}
				 	/*
					elseif ( ($_POST['liqpay_type']==2)   and ($liqpay_amount>0) )
				 	{
				 	// �������  ����.����
					$param=explode(":",$_POST['liqpay_param']);
					$akk_type=$param[0]; 	 // ��� �������� 1 - Silver 2-gold 3-platina
					$sub_type=$param[1]; 	 // ������
//					$ekr_cost=$param[2]; 	 // ���� �� ������

					$liqpay_array['amount']=$new_akks_prise[$akk_type][$sub_type]; // ���� �������
					$liqpay_amount=$liqpay_array['amount']; // �����

					$liqpay_array['currency']='USD';
					$liqpay_array['description']='������� '.$prem_akk_name[$akk_type].' ��� ���������: '.$user['login'];

					if ($liqpay_amount>0)
						{
						$p=($akk_type*100)+$sub_type;
						mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$p}' , `description`='{$liqpay_array['description']}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
						 	}
						 }
						 else
						 {
						 echo "Error!";
						 }
				 	} */
					elseif ( ($_POST['liqpay_type']==8) and ((in_array($_POST['liqpay_param'],$larec_param)))  and ($liqpay_amount>0) )
			 		{
					if (((time()>$ny_events['larcistart']) and (time()<$ny_events['larciend']))  )
						{
					 	if (test_larec($larec_type[$_POST['liqpay_param']],$user))
				 		{
				 		//������� ������
				 		$param=$_POST['liqpay_param'];
				 		if ($larec_prise[$param]>0)
							 	{

								$liqpay_array['amount']=$larec_prise[$param]; // ���� �������
								$liqpay_array['currency']='USD';
								$liqpay_array['description']='������� �'.$larec_name[$param].'� 1��.  ��� ���������: '.$user['login'];


							if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
								{
								mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
								 if (mysql_affected_rows()>0)
								 	{
									$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
								 	}
								 }
								 else
								 {
								 echo "Error";
								 }

				 		}
		 				}
		 				else
				 		{
					 	 err('<p><b><font color="red">������! ������ ������� ���� ��� ��� � ������� ���� � ��� �� ������ �������� ����� ������� 50 ��. � �����!</font></b></p>');
		 				}
		 				}
		 			}
					elseif ( ($_POST['liqpay_type']==8) and ((in_array($_POST['liqpay_param'],$bukets)))  and ($liqpay_amount>0) )
			 		{
					if( ((time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']))   )
						{
					 		$param=$_POST['liqpay_param'];
					 		if ($bukets_prise[$param]>0)
								 	{

									$liqpay_array['amount']=$bukets_prise[$param]; // ���� �������
									$liqpay_array['currency']='USD';
									$liqpay_array['description']='������� �'.array_search($param, $bukets).'� 1��.  ��� ���������: '.$user['login'];


								if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
									{
									mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
									 if (mysql_affected_rows()>0)
									 	{
										$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
									 	}
									 }
									 else
									 {
									 echo "Error";
									 }

					 		}
		 				}
		 			}
					elseif ( ($_POST['liqpay_type']==18) and ((in_array($_POST['liqpay_param'],$leto_bukets)))  and ($liqpay_amount>0) )
			 		{
					if( ((time() > $BUKET_start && time() < $BUKET_end))   )
						{
					 		$param=$_POST['liqpay_param'];
					 		if ($leto_bukets_prise[$param]>0)
								 	{

									$liqpay_array['amount']=$leto_bukets_prise[$param]; // ���� �������
									$liqpay_array['currency']='USD';
									$liqpay_array['description']='������� �'.array_search($param, $leto_bukets).'� 1��.  ��� ���������: '.$user['login'];


								if ($liqpay_array['amount']==$liqpay_amount) // �������� ���
									{
									mysql_query("INSERT INTO `oldbk`.`trader_balance_liqpay` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$liqpay_amount}', `param`='{$param}' , `description`='{$liqpay_array['description']}' ;");
									 if (mysql_affected_rows()>0)
									 	{
										$liqpay_array['order_id']=mysql_insert_id(); //���������� ID ������� � ����� ��������. ������������ ����� 255 ��������.
									 	}
									 }
									 else
									 {
									 echo "Error";
									 }

					 		}
		 				}
		 			}
				 	/*
				 	else
				 	{
				 	print_r($_POST);
				 	}
				 	*/

				 	if ($liqpay_array['order_id']>0)
				 	{
					$liqpay_array['description']=normJsonStr($liqpay_array['description']);

						$json_string=json_encode($liqpay_array);
						$data=base64_encode($json_string);
						$signature = base64_encode(sha1($private_key.$data.$private_key, 1));
						echo '<form method="POST" action="https://www.liqpay.ua/api/checkout" accept-charset="utf-8" name="frm">';
						echo '
						<input type="hidden" name="data" value="'.$data.'"/>
						<input type="hidden" name="signature" value="'.$signature.'"/></form>';
						echo '<script language="JavaScript">
						document.frm.submit();
						</script>';
					}
			echo "</body>";
		 	echo "</html>";
		 	die();
		 	}
	//���������� � ��������� ������ ������
		 if (($_POST['don_type']) and ($_SESSION['bankid']>0) )
		 	{
			echo "<html>";
			echo "<body>";

			$don_shop = '9736';
			$m_curr = 'USD';


			$don_amount=round(floatval($_POST['don_amount']),2);

				 if ( ($_POST['don_type']==1) and ($_POST['don_param']==0) and $don_amount>0 )
				 	{
				 	// ������� �����
					$don_description='���������� ����������� ����� �'.($_SESSION['bankid']).' ��� ���������: '.$user['login'];
					mysql_query("INSERT INTO `oldbk`.`trader_balance_don` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$don_amount}', `param`='0' , `description`='{$don_description}' ;");
					 if (mysql_affected_rows()>0)
					 	{
						$don_order_id=mysql_insert_id();
					 	}
				 	}
					elseif ( ($_POST['don_type']==88) and ($_POST['don_param']==88100||$_POST['don_param']==88500||$_POST['don_param']==881000) and ($_POST['amount_bil']==100||$_POST['amount_bil']==500||$_POST['amount_bil']==1000) )
					{
					// �������  �������
					 	$gold_prise[100]=5;
					 	$gold_prise[500]=22.5;
					 	$gold_prise[1000]=35;
					$don_amount=$gold_prise[$_POST['amount_bil']];
					$param=$_POST['don_param'];
					$don_description='������� '.$_POST['amount_bil'].' ����� �� '.$don_amount.'USD, ��� ���������: '.$user['login'];
					if ($don_amount>0)
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_don` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$don_amount}', `param`='{$param}' , `description`='{$don_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$don_order_id=mysql_insert_id();
						 	}
						 }
					}
					/*
				 	elseif ( ($_POST['don_type']==5) and ($_POST['don_param']!='') and ($don_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// ������� ������� ���������� ������������
					$kol_bil=(int)$_POST['amount_bil']; // ���.
					$param=explode(':',$_POST['don_param']) ;
					$param=$param[2]; // ��� �����������
					$don_description='������� ����������� ����������� ���������� '.$podar_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

					if ($don_amount==($podar_prise[$param]*$kol_bil)) // �������� ���
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_don` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$don_amount}', `param`='{$param}' , `description`='{$don_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$don_order_id=mysql_insert_id();
						 	}
						 }
				 	}*/
				 	elseif ( ($_POST['don_type']==3) and ($_POST['don_param']==300) and ($don_amount>0) )
				 	{
				 	// �������  ���������
					$param=300; // ��� ��������
					$don_description='������� ��������� ��� ���������: '.$user['login'];

						mysql_query("INSERT INTO `oldbk`.`trader_balance_don` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$don_amount}', `param`='{$param}' , `description`='{$don_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$don_order_id=mysql_insert_id();
						 	}
				 	}
					elseif ( ($_POST['don_type']==4) and ($_POST['don_param']==33333) and ($don_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// ������� ������� ���������� �������
					$kol_bil=(int)$_POST['amount_bil']; // ���. �������
					$param=33333; // ���  ������
					$bil_cost=2;
					$don_description='������� ������� '.$bil_cost.' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

					if ($don_amount==($bil_cost*$kol_bil)) // �������� ���
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_don` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$don_amount}', `param`='{$param}' , `description`='{$don_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$don_order_id=mysql_insert_id();
						 	}
						 }
				 	}
				 	/*
					elseif ( ($_POST['don_type']==2) and (($_POST['don_param']==1)OR($_POST['don_param']==2)OR($_POST['don_param']==3))  and ($don_amount>0) )
				 	{
				 	// �������  ����.����
					$param=(int)($_POST['don_param']); // ��� �������� 1 - Silver 2-gold 3-platina
					$don_description='������� '.$prem_akk_name[$param].' ��� ���������: '.$user['login'];

					if ($don_amount==($prem_akk_prise[$param])) // �������� ���
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_don` SET `owner`='{$user['login']}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$don_amount}', `param`='{$param}' , `description`='{$don_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$don_order_id=mysql_insert_id();
						 	}
						 }
				 	}
				 	*/


				 	if ($don_order_id>0)
				 	{




						echo '<form action="https://paymentgateway.ru/pgw/" method="GET" name="frm">';
						echo '<input id="project" name="project" type="hidden" value="9736">'; //<!-- ������������� �������, �������� ��� ���������� -->
						echo '<input id="nickname" name="nickname" type="hidden" value="'.urlencode($user['login']).'">';
						echo '<input id="nick_extra" name="nick_extra" type="hidden" value="'.urlencode($user['id']).'">';

						echo '<input id="amount" name="amount" type="hidden" value="'.$don_amount.'" >'; //�����
						echo '<input id="paymentCurrency" name="paymentCurrency" type="hidden" value="USD" >'; //������

						echo '<input id="order_id" name="order_id" type="hidden" value="'.$don_order_id.'" >'; //�� ������
						echo '<input id="comment" name="comment" type="hidden" value="'.urlencode($don_description).'" >'; //��������
						echo '<input  type="submit" value="��������" >';


						echo '</form>';
						echo '<script language="JavaScript">
						document.frm.submit();
						</script>';
					}
			echo "</body>";
		 	echo "</html>";
		 	die();
		 	}
		 	else if (($_POST['yandexmkbill']) and ($_SESSION['bankid']>0) )
		 	{
 			echo "<html>";
			echo "<body>";

 				$ya_amount=round(floatval($_POST['amount_rub']),2);
				$RUR=get_rur_curs();
				$RUR=round($RUR*1.05,2);
				 if (($_POST['amount_ekr']) and ($ya_amount>0) and ($_POST['param']==0) )
				 	{

				 	// ������� �����
				 	$yandex_ekr_amount=round($ya_amount/$RUR,2);
					$yandex_description='���������� ����������� ����� �'.($_SESSION['bankid']).' ��� ���������: '.$user['login'];
					mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."', `sum_rub`='{$ya_amount}' ,`sum_ekr`='{$yandex_ekr_amount}', `param`='0' , `description`='{$yandex_description}' ;");
					 if (mysql_affected_rows()>0)
					 	{
						$yandex_order_id=mysql_insert_id();
					 	}

				 	}
				 	elseif (($_POST['param']==88100||$_POST['param']==88500||$_POST['param']==881000) and ($_POST['amount_bil']==100||$_POST['amount_bil']==500||$_POST['amount_bil']==1000) )
				 	{

						// ������� �������
					 	$gold_prise[100]=5;
					 	$gold_prise[500]=22.5;
					 	$gold_prise[1000]=35;

					$yandex_ekr_amount=$gold_prise[$_POST['amount_bil']];
					$ya_amount=ceil($RUR*$yandex_ekr_amount);



					$yandex_description='������� '.$_POST['amount_bil'].' ����� �� '.$ya_amount.' ���., ��� ���������: '.$user['login'];

					mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."', `sum_rub`='{$ya_amount}' ,`sum_ekr`='{$yandex_ekr_amount}', `param`='{$_POST['param']}' , `description`='{$yandex_description}' ;");
					 if (mysql_affected_rows()>0)
					 	{
						$yandex_order_id=mysql_insert_id();
					 	}

				 	}
				 	/*
				 	elseif ( (in_array($_POST['param'],$podar)) and ($ya_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{
				 	// ������� ������� ���������� ������������
					$kol_bil=(int)$_POST['amount_bil']; // ���. �������
					$param=$_POST['param'];
					$yandex_description='������� ����������� ����������� ���������� '.$podar_prise[$param].' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

				 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

					if ($yandex_ekr_amount>=($podar_prise[$param]*$kol_bil)) // �������� ���
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."' , `sum_rub`='{$ya_amount}'  ,`sum_ekr`='{$yandex_ekr_amount}', `param`='{$param}' , `description`='{$yandex_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$yandex_order_id=mysql_insert_id();
						 	}
						 }
						 else
						 {
						 echo "Error";
						 }
				 	} */
				 	elseif ( ($_POST['param']==300) and ($ya_amount>0) )
				 	{
				 	// �������  ���������
					$param=300; // ��� ��������
					$yandex_description='������� ��������� ��� ���������: '.$user['login'];
				 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

						mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$yandex_order_id=mysql_insert_id();
						 	}
						 else
						 {
						 echo "Error";
						 }
				 	}
					elseif ( ($_POST['param']==33333) and ($ya_amount>0) and ((int)$_POST['amount_bil']>0) )
				 	{

				 	// ������� ������� ���������� �������
					$kol_bil=(int)$_POST['amount_bil']; // ���. �������
					$param=33333; // ���  ������
					$bil_cost=2;
				 	$yandex_ekr_amount=round($ya_amount/$RUR,2);
					$yandex_description='������� ������� '.$bil_cost.' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

					if ($yandex_ekr_amount>=($bil_cost*$kol_bil)) // �������� ���
						{
						mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
						 if (mysql_affected_rows()>0)
						 	{
							$yandex_order_id=mysql_insert_id();
						 	}
							 else
							 {
							 echo "Error";
							 }
						 }
						 else
						 {
						 echo "Error sum";
						 }
				 	}
				 	/*
					elseif ( (($_POST['param']==1)OR($_POST['param']==2)OR($_POST['param']==3))  )
				 	{
				 	// �������  ����.����
					$param=(int)($_POST['param']); // ��� �������� 1 - Silver 2-gold 3-platina
					$yandex_description='������� '.$prem_akk_name[$param].' ��� ���������: '.$user['login'];
				 	$yandex_ekr_amount=$prem_akk_prise[$param];
				 	$ya_amount=round(($RUR*$yandex_ekr_amount),2);


						mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
						  if (mysql_affected_rows()>0)
						 	{
							$yandex_order_id=mysql_insert_id();
						 	}
							 else
							 {
							 echo "Error";
							 }

				 	}*/
					elseif ((in_array($_POST['param'],$larec_param)))
				 	{
					if (((time()>$ny_events['larcistart']) and (time()<$ny_events['larciend']))  )
						{
						$param=(int)($_POST['param']); // ��� ��������
							if (test_larec($larec_type[$param],$user))
					 		{
					 		//������� ������
					 		if ($larec_prise[$param]>0)
							{
									$yandex_description='������� �'.$larec_name[$param].'� 1��.  ��� ���������: '.$user['login'];
								 	$yandex_ekr_amount=$larec_prise[$param];
								 	$ya_amount=round(($RUR*$yandex_ekr_amount),2);

								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
					 		}
			 				}
			 				else
					 		{
						 	 err('<p><b><font color="red">������! ������ ������� ���� ��� ��� � ������� ���� � ��� �� ������ �������� ����� ������� 50 ��. � �����!</font></b></p>');
			 				}
		 				  }
				 	}
					elseif ((in_array($_POST['param'],$bukets)))
				 	{
					if( ((time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']))   )
						{
						$param=(int)($_POST['param']); // ��� ��������

					 		if ($bukets_prise[$param]>0)
							{
									$yandex_description='������� �'.array_search($param, $bukets).'� 1��.  ��� ���������: '.$user['login'];
								 	$yandex_ekr_amount=$bukets_prise[$param];
								 	$ya_amount=ceil(($RUR*$yandex_ekr_amount));

								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
					 		}
		 				}
				 	}
					elseif ((in_array($_POST['param'],$leto_bukets)))
				 	{
					if( ((time() > $BUKET_start && time() < $BUKET_end))   )
						{
						$param=(int)($_POST['param']); // ��� ��������

					 		if ($leto_bukets_prise[$param]>0)
							{
									$yandex_description='������� �'.array_search($param, $leto_bukets).'� 1��.  ��� ���������: '.$user['login'];
								 	$yandex_ekr_amount=$leto_bukets_prise[$param];
								 	$ya_amount=ceil(($RUR*$yandex_ekr_amount));

								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
					 		}
		 				}
				 	}
					elseif ($_POST['param']==94)
				 	{
				 	// �������  �����
				 	if ((time() >= $STBOX_start) && (time() < $STBOX_end))
				 		{
						$param=(int)($_POST['param']); // ��� ��������
						$yandex_description='������� ����� ��� ���������: '.$user['login'];
					 	$yandex_ekr_amount=5;
					 	$ya_amount=round(($RUR*$yandex_ekr_amount),2);


							mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
							  if (mysql_affected_rows()>0)
							 	{
								$yandex_order_id=mysql_insert_id();
							 	}
								 else
								 {
								 echo "Error";
								 }
						}
				 	}
					elseif ($_POST['param']==84)
				 	{

				 	if ((time() >= $EGG_start) && (time() < $EGG_end))
				 		{
							$param=(int)($_POST['param']); // ��� ��������
							$kol_bil=(int)$_POST['amount_bil']; // ���.

						 	//$yandex_ekr_amount=1*$kol_bil;
						 	//$ya_amount=round(($RUR*$yandex_ekr_amount),2);

							$yandex_description='������� ���� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

						 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

							if ($yandex_ekr_amount>=(5*$kol_bil)) // �������� ���
								{


								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
								}
						}
				 	}
					elseif ($_POST['param']==95)
				 	{
				 	// �������  ��������
				 	if ((time() >= $SSNOW_start) && (time() < $SSNOW_end))
				 		{
							$param=(int)($_POST['param']); // ��� ��������
							$kol_bil=(int)$_POST['amount_bil']; // ���.

						 	//$yandex_ekr_amount=1*$kol_bil;
						 	//$ya_amount=round(($RUR*$yandex_ekr_amount),2);

							$yandex_description='������� �������� ���������� 1 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

						 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

							if ($yandex_ekr_amount>=(1*$kol_bil)) // �������� ���
								{


								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
								}
						}
				 	}
					elseif ($_POST['param']==51)
				 	{
				 		if (((time() >= $EURO_start) && time() < $EURO_end))
				 		{
							$param=(int)($_POST['param']); // ��� ��������
							$kol_bil=(int)$_POST['amount_bil']; // ���.


							$yandex_description='������� ���� �����-2016� ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

						 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

							if ($yandex_ekr_amount>=(5*$kol_bil)) // �������� ���
								{


								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
								}
						}
				 	}
					elseif ($_POST['param']==52)
				 	{
				 		if (((time() >= $EURO_start) && time() < $EURO_end))
				 		{
							$param=(int)($_POST['param']); // ��� ��������
							$kol_bil=(int)$_POST['amount_bil']; // ���.


							$yandex_description='������� ����� �����-2016� ���������� 2 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

						 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

							if ($yandex_ekr_amount>=(2*$kol_bil)) // �������� ���
								{


								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
								}
						}
				 	}
					elseif ($_POST['param']==53)
				 	{
					 	if (((time() >= $GVIC_start) && time() < $GVIC_end))
				 		{
							$param=(int)($_POST['param']); // ��� ��������
							$kol_bil=(int)$_POST['amount_bil']; // ���.


							$yandex_description='������� ������ ������� �����  ���������� 50 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

						 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

							if ($yandex_ekr_amount>=(50*$kol_bil)) // �������� ���
								{


								mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
								  if (mysql_affected_rows()>0)
								 	{
									$yandex_order_id=mysql_insert_id();
								 	}
									 else
									 {
									 echo "Error";
									 }
								}
						}
				 	}
				/*	elseif ($_POST['param']==90)
				 	{
				 	if (((time() >= $KO_start_time23) && time() < $KO_fin_time23))
						{

						$kol_bil=(int)$_POST['amount_bil']; // ���.

								if ($kol_bil>=25)
									{
									$param=89; // ��� ��������
									$pp=2;
									}
									else
									{
									$pp=3;
									$param=90; // ��� ��������
									}



						$yandex_description='������� �������� � ����� ����������� ���������� '.$pp.' ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

					 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

						if ($yandex_ekr_amount>=($pp*$kol_bil)) // �������� ���
							{


							mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
							  if (mysql_affected_rows()>0)
							 	{
								$yandex_order_id=mysql_insert_id();
							 	}
								 else
								 {
								 echo "Error";
								 }
							}
						}
				 	}	*/
					elseif ($_POST['param']==91)
				 	{
					if (((time() >= $SMAGIC_start) && time() < $SMAGIC_end))
						{
						$param=(int)($_POST['param']); // ��� ��������
						$kol_bil=(int)$_POST['amount_bil']; // ���.

					 	//$yandex_ekr_amount=1*$kol_bil;
					 	//$ya_amount=round(($RUR*$yandex_ekr_amount),2);

						$yandex_description='������� �������� ������ ������ ����� ������ ���������� 5 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

					 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

						if ($yandex_ekr_amount>=(5*$kol_bil)) // �������� ���
							{


							mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
							  if (mysql_affected_rows()>0)
							 	{
								$yandex_order_id=mysql_insert_id();
							 	}
								 else
								 {
								 echo "Error";
								 }
							}
						}
				 	}
					elseif ($_POST['param']==92)
				 	{
				 	// �������  ����������
	 				 	if ((time() >= $SVALENT_start) && (time() < $SVALENT_end))
 				 		{
								$param=(int)($_POST['param']); // ��� ��������
								$kol_bil=(int)$_POST['amount_bil']; // ���.

							 	//$yandex_ekr_amount=1*$kol_bil;
							 	//$ya_amount=round(($RUR*$yandex_ekr_amount),2);

								$yandex_description='������� �����-���������� ���������� 1 ��� x '.$kol_bil.'��.  ��� ���������: '.$user['login'];

							 	$yandex_ekr_amount=round($ya_amount/$RUR,2);

								if ($yandex_ekr_amount>=(1*$kol_bil)) // �������� ���
									{


									mysql_query("INSERT INTO `oldbk`.`trader_balance_yandex` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_rub`='{$ya_amount}', `sum_ekr`='{$yandex_ekr_amount}',  `param`='{$param}' , `description`='{$yandex_description}' ;");
									  if (mysql_affected_rows()>0)
									 	{
										$yandex_order_id=mysql_insert_id();
									 	}
										 else
										 {
										 echo "Error";
										 }
									}
						}
				 	}




 		/*	print_r($_POST);
 			echo $ya_amount ;*/


 			if ($yandex_order_id>0)
				 	{
//				 	echo '<form action="https://money.yandex.ru/eshop.xml" method="post" name="frm" target="_blank">';
				 	echo '<form action="https://demomoney.yandex.ru/eshop.xml" method="post" name="frm">';



					//<!-- ������������ ���� -->
					echo '
					<input name="shopId" value="63333" type="hidden"/>
					<input name="scid" value="537711" type="hidden"/>
					<input name="sum" value="'.$ya_amount.'" type="hidden">
					<input name="customerNumber" value="Y'.$yandex_order_id.'" type="hidden"/>';
					//<!-- �������������� ���� -->
					echo '
					<input name="orderNumber" value="'.$yandex_order_id.'" type="hidden"/>
					<input name="shopSuccessURL" value="http://capitalcity.oldbk.com/bank.php?yandex=ok" type="hidden"/>
					<input name="shopFailURL" value="http://capitalcity.oldbk.com/bank.php?yandex=error" type="hidden"/>
					<input name="orderDetails" value="'.$yandex_description.'" type="hidden"/>
					<input type="submit" value="���������"/>';
					echo '</form>';

					echo '<script language="JavaScript">
						document.frm.submit();
						</script>';

				 	}
			echo "</body>";
		 	echo "</html>";
		 	die();
		 	}



	/////////////////////////////
	$chlogin='none';


	if($_GET['exit'])
	{
	$_SESSION['bankid'] = null;
	unset($_SESSION['bankid']);
	}
	/*
	elseif ( (isset($_POST['delbank'])) and ($_SESSION['bankid']>0) )
	{

		//�������� � ���������
		$test_ref = mysql_fetch_array(mysql_query("select * from users_referals where ref='".$_SESSION['bankid']."'  Limit 1;"));
		if  ($test_ref['id']>0) {
			err('� ����� ����� ��������� �������, �������� ����������!');
		} else {
			//������� ���������� ����
			//����� � �������
			$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' and owner='{$user['id']}' ;"));
			if ($bank['id']>0) {
				if ($bank['cr'] > 0 || $bank['ekr'] > 0) {
					err('������ ������� ���� �� ������� ���� ������');
				} else {
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."',' �������� <b>{$user['login']}</b>, ������ ���� ����!  <i>(����� �������: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
					mysql_query("DELETE FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' and owner='{$user['id']}' ;");
					echo "<br><font color=red><b>������� �� ����������� ����� � �������...</b></font>";
				 	$_SESSION['bankid'] = null;
					unset($_SESSION['bankid']);
					unset($bank);
					echo "<script>
					window.location.href='bank.php?exit=1&tmp=".(mt_rand(111111,999999))."';
					</script>";
				}
			}
		}

	}
	*/



  //  if ($user['room'] != 29)  { header("Location: main.php"); die() ; }
    if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }

	// Weathered SMS pyments errors
	if(isset($_GET['sms_err']))
	{
		err($_GET['sms_err']);
	}
	else
	if (isset($_GET['qiwi_ok']))
	{
	//echo'<html>     <body> 	     <br> 	     <br>	     <div align=center>	     <H3>������ ������� ��������!</H3>	     <br>	     <br>	     	     <a href="javascript:self.close()">������� ����</a>	     </div>	     </body>   	     <html>	';	die();
		err('������ ������� ��������!');
	}
	else
	if (isset($_GET['qiwi_err']))
	{
	//echo'<html>     <body> 	     <br> 	     <br> 	     <div align=center>	     <H3>������ �������, ��������� �������!</H3>      <br>	     <br>	     	     <a href="javascript:self.close()">������� ����</a> 	     </div>	     </body>   	     <html>	';	die();
		err('������ ������� ��������!');
	}
	else
	if( (isset($_GET['ok'])) OR (isset($_GET['liqpayok'])) or ($_GET['yandex']=='ok') )
	{
		err('������ ������� ��������!');
	}
	else
	if(isset($_GET['err']))
	{
		err('������ ����������!');
	}

	// </>


			function inschet($userid){
				$banks = mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `owner` = '".$userid."' ;");
				echo "<select style='width:150px' name=id>";
				while ($rah = mysql_fetch_array($banks)) {
					echo "<option>",$rah['id'],"</option>";
				}
				echo "</select>";
			}

if($_SESSION['bankid']>0)
{
$bank_owner = mysql_query("SELECT owner FROM `oldbk`.`bank` WHERE id='{$_SESSION['bankid']}'");
$bank_owner = mysql_fetch_array($bank_owner);
}



?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=0.8">
<script type="text/javascript" src="/i/globaljs.js"></script>
<script type="text/javascript" src="/i/bank20.js"></script>
<script type='text/javascript' src='http://i.oldbk.com/i/js/recoverscroll.js'></script>
<SCRIPT LANGUAGE="JavaScript">
// ��������� ����
function closehint3() {
document.getElementById("hint3").style.visibility="hidden";
}

function AddCount(event,name, txt, sale, href, maxlen) {
	var el = document.getElementById("hint3");
	if(sale==0) {
		var sale_txt= '�������� ��������� ����';
		var a_href='';
		var a_href='';

		el.innerHTML = '<form '+a_href+' method="post" style="margin:0px; padding:0px;"><table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B style="font-size:11p�;">'+sale_txt+'</td><td width=20 align=right valign=top style="cursor: pointer; z-index: 1;" onclick="closehint3();return false;"><B style="font-size:11p�;">x</B></TD></tr><tr><td colspan=2>'+
		'<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="showinbox" value="'+sale+'"><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B style="font-size:11p�;"><I>'+txt+'</td></tr><tr><td width=80% align=right style="font-size:11p�;">'+
		'���-�� (���� '+maxlen+' ��.) <INPUT id="itemcount" TYPE="text" NAME="count" size=4 ></td><td width=20%>&nbsp;<INPUT TYPE="submit" style="height:16px;margin-top:2px;" value=" �� ">'+
		'</TD></TR></TABLE></td></tr></table></form>';
	} else {
		var sale=1;
		var sale_txt= '������� ��������� ����';
		var a_href='';

		el.innerHTML = '<form '+a_href+' method="post" style="margin:0px; padding:0px;"><table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B style="font-size:11p�;">'+sale_txt+'</td><td width=20 align=right valign=top style="cursor: pointer; z-index: 1;" onclick="closehint3();return false;"><B style="font-size:11p�;">x</B></TD></tr><tr><td colspan=2>'+
		'<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="showinbox" value="'+sale+'"><INPUT TYPE="hidden" name="set" value="'+name+'"><td colspan=2 align=center><B style="font-size:11p�;"><I>'+txt+'</td></tr><tr><td width=80% align=right style="font-size:11p�;">'+
		'���-�� (���� '+maxlen+' ��.) <INPUT id="itemcount" TYPE="text" NAME="count" size=4 ></td><td width=20%>&nbsp;<INPUT TYPE="submit" style="height:16px;margin-top:2px;" value=" �� ">'+
		'</TD></TR></TABLE></td></tr></table></form>';

	}

	el.style.visibility = "visible";
	el.style.left = (event.pageX) + 'px';
	y = event.pageY;
	el.style.top = (y -120) + 'px';
	document.getElementById("itemcount").focus();
}
</SCRIPT>
<link rel=stylesheet type="text/css" href="i/main.css">
<link rel=stylesheet type="text/css" href="i/btn.css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<style>
	legend {
		padding: 0.2em 0.5em;
		color:#003388;
		FONT-WEIGHT: bold;
	}
	fieldset { border: 2px groove threedface;}

		body {
		background-color: #e2e0e0;
		}

		mnorm { font:10pt/12pt  Verdana;  }
		mact { font:10pt/12pt  Verdana;  }

		a.mnorm:link	{ color:#000000 }
		a.mnorm:visited	{ color:#000000 }
		a.mnorm:active	{ color:#000000 }
		a.mnorm:hover	{ color:#000FFF }

		a.mact:link	{ color:#FFFFFF }
		a.mact:visited	{ color:#FFFFFF }
		a.mact:active	{ color:#FFFFFF }
		a.mact:hover	{ color:#FFFFFF }

	.discount_cost { position: relative;left: -101px;top: -84px;font-size: 16px;font-family: Arial;font-weight: bold; }

        .btn-control .btn {
            color: black;
        }

	</style>

</head>
<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0>
<script type='text/javascript'>
RecoverScroll.start();
</script>
			<div id="pl" style="z-index: 1; position: absolute; left: 155px; top: 120px;
				width: 820px; height:390px; background-color: #eeeeee;
				border: 1px solid black; display: none;">

			</div>
		        <div id=hint3 class=ahint style="z-index: 1;"></div>
	<?
	make_quest_div();
//print_r($_POST);
	?>
<script src="i/jquery.drag.js" type="text/javascript"></script>
<script type="text/javascript" src="i/showthing.js"></script>
<script>

			function getformdata(id,param,event)
			{

				if (window.event)
				{
					event = window.event;
				}
				if (event )
				{

				       $.get('payform.php?tmp=<?=mt_rand(1111,9999);?>&id='+id+'&param='+param+'', function(data) {
					  $('#pl').html(data);
					  $('#pl').show(200, function() {
						});
					});

				 $('#pl').css({ position:'absolute',left: ($(window).width()-$('#pl').outerWidth())/2, top: '120px'  });


				}

			}

			function closeinfo()
			{
			  	$('#pl').hide(200);
			}

$(window).resize(function() {
 $('#pl').css({ position:'absolute',left: ($(window).width()-$('#pl').outerWidth())/2, top: '120px'  });
});

</script>


	<?


		if($_POST['enter'] && $_POST['pass'])
	{
				$data = mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `owner` = '".$user['id']."' AND `id`= '".(int)$_POST['id']."' AND `pass` = '".md5($_POST['pass'])."';");
				$data = mysql_fetch_array($data);
				if($data)
					{
						$_SESSION['bankid'] = $_POST['id'];
						//$my_err='������� ����.';
						session_write_close();
					}
					else
					{
						$my_err='������ �����.';
					}

	}
	//if($user['align'] == '2.4'){ echo "RadminionInfo:: Current-UID: {$user['id']} Owner: {$bank_owner['owner']} Session: {$_SESSION['bankid']}<br/><br/>"; }






	if($_SESSION['bankid'])
	{
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
	//������� ��� ������ �����

	$page=(int)($_GET[p]);
	if ($page<=0) {$page=1;}
	if ($page>=$maxpages) {$page=$maxpages;}

	$psize[1]=1130;
	$psize[2]=1130;
	$psize[3]=1130;
	$psize[4]=1130;
	$psize[5]=1130;
	$psize[6]=1130;

	$lsize[1]=595;
	$lsize[2]=617;
	$lsize[3]=595;
	$lsize[4]=595;
	$lsize[5]=595;
	$lsize[6]=595;

	?>
	<table width="<?=$psize[$page];?>" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	    <td id=lsize width="80" height="<?=$lsize[$page];?>" valign="top" background="http://i.oldbk.com/i/bank/left_bg.jpg">
	    		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
			<tr valign="top">
				<td>
				<img src="http://i.oldbk.com/i/bank/left_top.jpg" width="80" height="51">
				</td>
			</tr>
			<tr valign="bottom">
				<td>
				<img src="http://i.oldbk.com/i/bank/left_down.jpg" alt="" width="80" height="157">
				</td>
			</tr>
			</table>
	   </td>
    	   <td valign="top" bgcolor="#eae8e8">
    	   		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			<td height="26" background="http://i.oldbk.com/i/bank/frame_up.jpg">&nbsp;</td>
			</tr>
	<tr>
	<td height="37"   valign="top"  align="center" background="http://i.oldbk.com/i/bank/frame_menu_bg_norm.jpg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width=<?=$ph?>% align="center" valign=top style="padding-top: 7px;" background="<? if ($page==1) {echo "http://i.oldbk.com/i/bank/frame_menu_bg_active.jpg\" ><a class=mact href=#>";}else{echo "http://i.oldbk.com/i/bank/frame_menu_bg_norm.jpg\" ><a class=mnorm href=?p=1>";} ?>�������</a></td>
		<td><? if ($page==1)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_r3.png" width="16" height="37">'; }
				elseif ($page==2)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_l3.png" width="16" height="37">'; }
					else {echo '<img src="http://i.oldbk.com/i/bank/razdelitel.png" width="16" height="37">'; } ?>
		</td>
		<td width=<?=$ph?>% align="center" valign=top style="padding-top: 7px;"  background="<? if ($page==2) {echo "http://i.oldbk.com/i/bank/frame_menu_bg_active.jpg\" ><a class=mact href=#>";}else{echo "http://i.oldbk.com/i/bank/frame_menu_bg_norm.jpg\" ><a class=mnorm href=?p=2>";} ?>��������</a></td>
		<td>
		<? if ($page==2)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_r3.png" width="16" height="37">'; }
				elseif ($page==3)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_l3.png" width="16" height="37">'; }
					else {echo '<img src="http://i.oldbk.com/i/bank/razdelitel.png" width="16" height="37">'; } ?>
		</td>
		<td width=<?=$ph?>% align="center" valign=top style="padding-top: 7px;"  background="<? if ($page==3) {echo "http://i.oldbk.com/i/bank/frame_menu_bg_active.jpg\" ><a class=mact href=#>";}else{echo "http://i.oldbk.com/i/bank/frame_menu_bg_norm.jpg\" ><a class=mnorm href=?p=3>";} ?>������</a></td>
		<td>
				<? if ($page==3)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_r3.png" width="16" height="37">'; }
				elseif ($page==$prp)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_l3.png" width="16" height="37">'; }
					else {echo '<img src="http://i.oldbk.com/i/bank/razdelitel.png" width="16" height="37">'; } ?>

		</td>
		<?
		//if ($IM_GLAVA)
		{
		?>
		<td width=<?=$ph?>% align="center" valign=top style="padding-top: 7px;"  background="<? if ($page==6) {echo "http://i.oldbk.com/i/bank/frame_menu_bg_active.jpg\" ><a class=mact href=#>";}else{echo "http://i.oldbk.com/i/bank/frame_menu_bg_norm.jpg\" ><a class=mnorm href=?p=6>";} ?>������</a></td>
		<td>
				<? if ($page==6)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_r3.png" width="16" height="37">'; }
				elseif ($page==4)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_l3.png" width="16" height="37">'; }
					else {echo '<img src="http://i.oldbk.com/i/bank/razdelitel.png" width="16" height="37">'; } ?>

		</td>
		<?
		}
		?>
		<td width=<?=$ph?>% align="center" valign=top style="padding-top: 7px;"  background="<? if ($page==4) {echo "http://i.oldbk.com/i/bank/frame_menu_bg_active.jpg\" ><a class=mact href=#>";}else{echo "http://i.oldbk.com/i/bank/frame_menu_bg_norm.jpg\" ><a class=mnorm href=?p=4>";} ?>������������</a></td>
		<td>
				<? if ($page==4)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_r3.png" width="16" height="37">'; }
				elseif ($page==6)
						{ echo '<img src="http://i.oldbk.com/i/bank/razdelitel_l3.png" width="16" height="37">'; }
					else {echo '<img src="http://i.oldbk.com/i/bank/razdelitel.png" width="16" height="37">'; } ?>

		</td>



		<td width=<?=$ph?>% align="center" valign=top style="padding-top: 7px;"  background="<? if ($page==5) {echo "http://i.oldbk.com/i/bank/frame_menu_bg_active.jpg\" ><a class=mact href=#>";}else{echo "http://i.oldbk.com/i/bank/frame_menu_bg_norm.jpg\" ><a class=mnorm href=?p=5>";} ?>�����</a></td>


		</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td height="504" align="right" valign="top">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td  valign="top" style="background-image:url('http://i.oldbk.com/i/bank/decor_bg2.jpg');background-repeat:no-repeat;background-position:right top;height:485px;" >

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

		<td  width=2% >&nbsp;</td>
		<td width="96%" height="485px"  valign=top>
	<?
		if($my_err) { echo "<font color=red><b>".$my_err."</b></font>"; }

		     if(!$_SESSION['beginer_quest'][none])
	     {
	      $last_q=check_last_quest(6);
	      if($last_q)
	      {
	         quest_check_type_6($last_q);
	      }
	     }

   if($bank_owner['owner'] > 0 && ($bank_owner['owner'] != $user['id'])) {  err('������� ����...'); $_SESSION['bankid'] = null; }


	if($_GET['fail']) {
		err('������ ���������� �������.');
		die();
	}
	else
	if($_GET['suk']) {
		err('������ ������ ��������.');
		die();
	}
///////////mob_amount
	/*
	if ((isset($_POST[mob_amount])) and ((int)($_SESSION['bankid'])>0))
	{
	require_once 'ubillbiz.php';

	$projectId = 1019;

	//http://capitalcity.oldbk.com/bank_result_mobile.php
	$secretKey = 'Pr3iveFDtfmd3obdko3m7mef7rc';

	$am_rub = round(floatval($_POST['mob_amount']),2);
	$mob_phone=(int)($_POST[mob_phone]);
	$param=(int)($_POST[param]);
	$mob_ok=false;

	$amount_bil=(int)($_POST['amount_bil']);

		if (($am_rub>0) and ($mob_phone>0) and ($param==0))
		{
		$am_rub_100=round(($am_rub*100)/126,2); // ����� ��� ����� 26% ��� ������� ������� �����
		//������� ���
		$RUR_CUR=get_rur_curs_bank();
		$mob_ekr=round(($am_rub_100*$RUR_CUR),2);
		$message="���������� ����������� ����� �{$_SESSION['bankid']}, ��������� {$user['login']} �� {$mob_ekr} ���.";

		mysql_query("INSERT INTO `oldbk`.`trader_balance_ubill` SET `owner`='{$user['login']}',`owner_id`={$user['id']},`bank_id`='{$_SESSION['bankid']}',`sum_rub`='{$am_rub}' ,`sum_ekr`='{$mob_ekr}',`param`=0,`sender_phone`='{$mob_phone}',`status`=0,`description`='{$message}';");
		if (mysql_affected_rows()>0)
			{
			$tid=mysql_insert_id();
			$txn_id=urlencode(iconv("CP1251","UTF-8",'������ �� ������ #'.$tid));
			$params = array(
			    'project_id' => $projectId,
			    'price' => $am_rub, // ����� ����������
			    'phone' => $mob_phone, // ����� ��������
			    'description' => $txn_id , // �������� ������
			);

			$mob_ok=true;

			}
		}
		elseif (($am_rub>0) and ($mob_phone>0) and ($param==300))
		{
		//�������  ����
		$am_rub_100=round(($am_rub*100)/126,2); // ����� ��� ����� 26% ��� ������� ������� �����

		$RUR_CUR=get_rur_curs_bank();
		$mob_ekr=round(($am_rub_100*$RUR_CUR),2);

		$message='������� ��������� ��� ���������: '.$user['login'].' �� �����: '.$mob_ekr.' ���';

		mysql_query("INSERT INTO `oldbk`.`trader_balance_ubill` SET `owner`='{$user['login']}',`owner_id`={$user['id']},`bank_id`='{$_SESSION['bankid']}',`sum_rub`='{$am_rub}' ,`sum_ekr`='{$mob_ekr}',`param`=300,`sender_phone`='{$mob_phone}',`status`=0,`description`='{$message}';");
		if (mysql_affected_rows()>0)
			{
			$tid=mysql_insert_id();
			$txn_id=urlencode(iconv("CP1251","UTF-8",'������ �� ������ #'.$tid));
			$params = array(
			    'project_id' => $projectId,
			    'price' => $am_rub, // ����� ����������
			    'phone' => $mob_phone, // ����� ��������
			    'description' => $txn_id , // �������� ������
			);

			$mob_ok=true;

			}
		}
		elseif (($am_rub>0) and ($mob_phone>0) and (($param==1)OR($param==2) OR ($param==3) ) )
		{
		//�������  ������� �����
		$RUR_CUR=get_ekr_to_rur_curs();
		$RUR_CUR+=round($RUR_CUR*0.26,2);//+26%

		$mob_ekr=$prem_akk_prise[$param];//����� ���������
		$am_rub=round(($mob_ekr*$RUR_CUR)) ;// ����� � ������


		$message='������� '.$prem_akk_name[$param].' ��� ���������: '.$user['login'].' �� �����: '.$mob_ekr.' ���';

		mysql_query("INSERT INTO `oldbk`.`trader_balance_ubill` SET `owner`='{$user['login']}',`owner_id`={$user['id']},`bank_id`='{$_SESSION['bankid']}',`sum_rub`='{$am_rub}' ,`sum_ekr`='{$mob_ekr}',`param`='{$param}',`sender_phone`='{$mob_phone}',`status`=0,`description`='{$message}';");
		if (mysql_affected_rows()>0)
			{
			$tid=mysql_insert_id();
			$txn_id=urlencode(iconv("CP1251","UTF-8",'������ �� ������ #'.$tid));
			$params = array(
			    'project_id' => $projectId,
			    'price' => $am_rub, // ����� ����������
			    'phone' => $mob_phone, // ����� ��������
			    'description' => $txn_id , // �������� ������
			);

			$mob_ok=true;

			}
		}
		elseif (($am_rub>0) and ($mob_phone>0) and ($param==33333) and ($amount_bil >0) )
		{
		//�������  ����
		$bil_cost=2; // 2 ���� ���� 1 ������
		$RUR_CUR=get_ekr_to_rur_curs();
		$RUR_CUR+=round($RUR_CUR*0.26,2);//+26%

		$mob_ekr=$amount_bil*$bil_cost; // ����� � �����
		$am_rub=round(($mob_ekr*$RUR_CUR)) ;// ����� � ������

		$message='������� ������� '.$bil_cost.' ��� x '.$amount_bil.'��.  ��� ���������: '.$user['login'].' �� �����: '.$mob_ekr.' ���';

		mysql_query("INSERT INTO `oldbk`.`trader_balance_ubill` SET `owner`='{$user['login']}',`owner_id`={$user['id']},`bank_id`='{$_SESSION['bankid']}',`sum_rub`='{$am_rub}' ,`sum_ekr`='{$mob_ekr}',`param`='{$param}',`sender_phone`='{$mob_phone}',`status`=0,`description`='{$message}';");
		if (mysql_affected_rows()>0)
			{
			$tid=mysql_insert_id();
			$txn_id=urlencode(iconv("CP1251","UTF-8",'������ �� ������ #'.$tid));
			$params = array(
			    'project_id' => $projectId,
			    'price' => $am_rub, // ����� ����������
			    'phone' => $mob_phone, // ����� ��������
			    'description' => $txn_id , // �������� ������
			);

			$mob_ok=true;

			}
		}




			if ($mob_ok==true)
			{

					// ���������� ������� �������
					$params['success_message'] = urlencode(iconv("CP1251","UTF-8",'������� �� �������'));  // ���������, ������������ ��������, � ������ ��������� ���������� ������
					$params['signature'] = generateSignature($params, $secretKey);

					$result = sendRequest(API_HOST . '/commerce/request', $params);
					if (is_string($result)) {
					    // ��������� ������
					    err("������:  " . iconv("UTF-8","CP1251",$result));
					} else {
					    // ID ��������� ����������
					    $transactionId = $result['transaction_id'];

					    //��������� �� ������ � �� �������
					   mysql_query("UPDATE `oldbk`.`trader_balance_ubill` SET `transaction_id`='{$transactionId}' WHERE `id`='{$tid}' ");

					   err('���� ������ ���������!  ����� ������� '.$am_rub.'�. ');
					   err('<br> ID ����������:'.$transactionId);
					}

			}
			else
			{
				err("������ ����������� ����� �� ������, ��������� ����!");
			}

	}
	else
	*/
/////////QIWI
	if ((isset($_POST[qiwimkbill])) and ((int)($_SESSION['bankid'])>0))
	{
	$am_rub=(int)($_POST[amount_rub]);
	$am_rep=(int)($_POST[amount_rep]);
	$am_gold=(int)($_POST[amount_bil]);
	$qiwi_to=(int)($_POST[to]);
	$param=(int)($_POST[param]);


//print_r($_POST);
	if (($am_rub>0) and ($qiwi_to>0) and ($am_rep==0) and ($param==0))
		{
		//������� ���
		$RUR_CUR=get_rur_curs_bank();
		$qiwi_ekr=round(($am_rub*$RUR_CUR),2);
				if ($qiwi_ekr > 0)
				{
				//������� ���� � ���� ��� ����
				mysql_query("INSERT INTO `oldbk`.`trader_balance_qiwi` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$qiwi_ekr}',`sum_rub`='{$am_rub}',`qiwi`='{$qiwi_to}';");
					 if (mysql_affected_rows()>0)
					{
					 $txn_id=mysql_insert_id();
					 //from=6920 - ���
					 //����� = 299509

					$linkqiwi="http://w.qiwi.ru/setInetBill_utf.do?frm=1&from=299509&lifetime=60&check_agt=false&com=".urlencode(iconv("CP1251","UTF-8","���������� ����������� ����� �{$_SESSION['bankid']}, ��������� {$user['login']} �� {$qiwi_ekr} ���."))."&to={$qiwi_to}&txn_id={$txn_id}&amount_rub={$am_rub}";
						$f=@fopen($linkqiwi,"r");
							if($f)
							{
							fclose($f);
							err('<a target=_blank href = "https://qiwi.com/order/external/main.action?shop=299509&transaction='.$txn_id.'">���� ������ ���������!  ����� ������� '.$am_rub.'�.  ��������!</a>');
							echo '<script>
							window.open("https://qiwi.com/order/external/main.action?shop=299509&transaction='.$txn_id.'");
							</script>';
							//echo $linkqiwi ;
							}
							else
							{
							err('���� �� ���������, ��������� �����!');
							}
					}
				}
		}
		else if (($qiwi_to>0) and ($param>0))
		{


			if ( $param==88000 and $am_gold>=20)
				{
				$coins_kurs=20;

	 					$RUR_CUR=get_rur_curs_bank();

						$qiwi_ekr=round(($am_rub*$RUR_CUR),2);

						$cgold=round($qiwi_ekr*$coins_kurs);

				 			if (($am_rub > 0) and ($cgold>=$am_gold))
							{
							//������� ���� � ���� ��� ����
							mysql_query("INSERT INTO `oldbk`.`trader_balance_qiwi` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$qiwi_ekr}',`sum_rub`='{$am_rub}',`qiwi`='{$qiwi_to}', `param`='{$param}' ;");
							 if (mysql_affected_rows()>0)
							{
								$txn_id=mysql_insert_id();
					 			$linkqiwi="http://w.qiwi.ru/setInetBill_utf.do?frm=1&from=299509&lifetime=60&check_agt=false&com=".urlencode(iconv("CP1251","UTF-8","�������  {$cgold} �����  ��� ��������� {$user['login']}."))."&to={$qiwi_to}&txn_id={$txn_id}&amount_rub={$am_rub}";
								$f=@fopen($linkqiwi,"r");
								if($f)
								{
								fclose($f);
								err('<a target=_blank href = "https://qiwi.com/order/external/main.action?shop=299509&transaction='.$txn_id.'">���� ������ ���������!  ����� ������� '.$am_rub.'�. ��������!</a>');
								echo '<script>
								window.open("https://qiwi.com/order/external/main.action?shop=299509&transaction='.$txn_id.'");
								</script>';
								}
								else
								{
								err('���� �� ���������, ��������� �����!');
								}
							}
							}
							else
							{
							echo "error";

							}


				}
			else if (($param==300) and ($am_rep>=600) )
				{
				//������� ����

				 	{
					$RUR_CUR=get_rur_curs_bank();
					$qiwi_ekr=round(($am_rub*$RUR_CUR),2)+1;

				 			if ($am_rub > 0)
							{
							//������� ���� � ���� ��� ����
							mysql_query("INSERT INTO `oldbk`.`trader_balance_qiwi` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`bank_id`='".(int)($_SESSION['bankid'])."',`sum_ekr`='{$qiwi_ekr}',`sum_rub`='{$am_rub}',`qiwi`='{$qiwi_to}', `param`='{$param}' ;");
							 if (mysql_affected_rows()>0)
							{
							 $txn_id=mysql_insert_id();
							 $linkqiwi="http://w.qiwi.ru/setInetBill_utf.do?frm=1&from=299509&lifetime=60&check_agt=false&com=".urlencode(iconv("CP1251","UTF-8","������� ".($qiwi_ekr*600)."  ��������� ��� ��������� {$user['login']}."))."&to={$qiwi_to}&txn_id={$txn_id}&amount_rub={$am_rub}";
								$f=@fopen($linkqiwi,"r");
								if($f)
								{
								fclose($f);
								err('<a target=_blank href = "https://qiwi.com/order/external/main.action?shop=299509&transaction='.$txn_id.'">���� ������ ���������!  ����� ������� '.$am_rub.'�. ��������!</a>');
								echo '<script>
									window.open("https://qiwi.com/order/external/main.action?shop=299509&transaction='.$txn_id.'");
								</script>';
								}
								else
								{
								err('���� �� ���������, ��������� �����!');
								}
							}
							}
				 	}

				}

		}
		else
		{
		echo "������ �����";
		}
	}
/////////////////


	if ($page==100)
	{
	///��������� ����


		////////////////////////////����� ������� ������� + �����
		render_my_money();

		if ($mywarn) { echo "<br><font color=red><b>".$mywarn."</b></font>"; } else { echo ""; }

		echo "<center><table border=0 align=center> ";
		echo "<tr><td valign=top align=center>";

		echo "<fieldset style=\"text-align:justify; width:300px; min-height:140px;\"><legend>������</legend>";
		echo "<div align=center style=\"margin-top:20px;\">";
		echo "<a href=\"#\" onClick=\"getformdata(99,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_ekr.gif title='������ ���' ></a>&nbsp;";

		if ((time() >= $YARM_start) && (time() < $YARM_end))
		{
		echo "<a href=\"#\" onClick=\"getformdata(88,0,event);\"><img src=http://i.oldbk.com/i/knopka_coin3.gif title='������ ������' ></a><br>";
		}
		else
		{
		echo "<a href=\"#\" onClick=\"getformdata(87,0,event);\"><img src=http://i.oldbk.com/i/knopka_coin3.gif title='������ ������' ></a><br>";
		}
		echo "<a href=\"#\" onClick=\"getformdata(9,300,event);\"><img src=http://i.oldbk.com/i/bank/knopka_repa.gif title='������ ���������' ></a>&nbsp;";



		echo "</div>";

		echo "</fieldset>";

		echo "</td>";

		echo "<td>&nbsp;&nbsp;</td>";

		echo "<td valign=top align=center>";
		echo "<fieldset style=\"text-align:justify; width:300px; height:140px;\"><legend>������</legend>";

		echo "<center><table border=0 align=center>";
		echo "<tr><td><br>";

		//echo "<a href=\"#\" onClick=\"getformdata(97,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_giftsert.gif title='������ ���������� ����������' ></a>";
		//echo "<a href=\"#\" onClick=\"getformdata(98,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_cuplord.gif title='������ ���� �������' ></a><br>";

		if( ((time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']))   )
		{
		echo "<a href=\"#\" onClick=\"getformdata(96,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_elki_2016.gif title='������ ����' ></a>&nbsp;";
		}

		/*
	 	if ((time() >= $STBOX_start) && (time() < $STBOX_end))
		{
			$T_BOXS=1;
			echo "<a href=\"#\" onClick=\"getformdata(94,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_tykva.gif title='������ ������������ �����' ></a>";
		}

	 	if ((time() >= $EGG_start) && (time() < $EGG_end))
		{
			echo "<a href=\"#\" onClick=\"getformdata(84,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_egg.gif title='������ ���������� ����' ></a>";
		}


		if  ( (((time()>$KO_start_time23) and (time()<$KO_fin_time23)) )  )
		{
			echo "<a href=\"#\" onClick=\"getformdata(90,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_keylord.gif title='������ ������� � ����� �����������' ></a>";
		}

		// ����� ����������
	 	if ((time() >= $SVALENT_start) && (time() < $SVALENT_end))
		{
		echo "<a href=\"#\" onClick=\"getformdata(92,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_valentin.gif title='������ �����-����������' ></a>&nbsp;";
		}


		if ((((time() >= $LORDBOX_start) && time() < $LORDBOX_end)) )
		{
		echo "&nbsp;<a href=\"#\" onClick=\"getformdata(81,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_boxrunes.gif title='������ ������� �����' ></a>";
		}

		if (((time()>$ny_events['larcistart']) and (time()<$ny_events['larciend']))  )
		{
			echo "<a href=\"#\" onClick=\"getformdata(11,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_larcy.gif title='������ ������' ></a><br>";
		}


		// ��������� ������
	 	if ((time() >= $SSNOW_start) && (time() < $SSNOW_end))
		{
		echo "<a href=\"#\" onClick=\"getformdata(95,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_magicsnow.gif title='������ ��������� ��������' ></a>&nbsp;";
		}
		if ($_GET['bytik']==1)
			{
			echo "<script> getformdata(10,33333,'onClick'); </script>";
			}

		//echo "&nbsp;<a href=\"#\" onClick=\"getformdata(10,33333,event);\"><img src=http://i.oldbk.com/i/bank/knopka_loto.gif title='������ ���������� �����' ></a>";

		if (((time() >= $SMAGIC_start) && time() < $SMAGIC_end))
		{
		echo "&nbsp;<a href=\"#\" onClick=\"getformdata(91,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_smenamagic.gif title='������ ������� ������ ������ ����� ������' ></a>";
		}

		if (((time() >= $EXPRUN_start) && time() < $EXPRUN_end))
		{
		echo "&nbsp;<a href=\"#\" onClick=\"getformdata(79,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_exprune.gif title='������ ������ ������� �����' ></a>";
		}

		if (((time() >= $GVIC_start) && time() < $GVIC_end))
		{
		echo "&nbsp;<a href=\"#\" onClick=\"getformdata(53,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_great_victory.gif title='������ ������ ������� �����' ></a>";
		}


		echo "<br>";
		*/

		if( ((time() > $BUKET_start && time() < $BUKET_end))   )
		{
		echo "<a href=\"#\" onClick=\"getformdata(69,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_flowers.gif title='������ �����' ></a>&nbsp;";
		}


/*
		if( ((time() > $FALIGN_start && time() < $FALIGN_end))   )
		{
		 echo "<a href=\"#\" onClick=\"getformdata(236,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_align.gif title='������ ����������' ></a>&nbsp;";
		}

		if( ((time() > $IMPR_start && time() < $IMPR_end))   )
		{
		 echo "<a href=\"#\" onClick=\"getformdata(60,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_charka.gif title='������ ������� ���������' ></a>&nbsp;";
		 echo "<a href=\"#\" onClick=\"getformdata(61,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_up_art.gif title='������ ������� ���������' ></a>&nbsp;";
		}


		if( ((time() > $EURO_start && time() < $EURO_end))   )
		{
		echo "<a href=\"#\" onClick=\"getformdata(51,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_euroball2016.gif title='������ ��� �����-2016�' ></a>&nbsp;";
		echo "<a href=\"#\" onClick=\"getformdata(52,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_euroflag2016_2.gif title='������ ���� �����-2016�' ></a>&nbsp;";
		}
	*/

		echo "</td></tr></table></center>";


		echo "</fieldset>";

		echo "</td>";


		echo "</tr>";
		echo "<tr>";

		echo "<td valign=top>";
		echo "<div align=center>";

		/*
		echo "<fieldset style=\"text-align:justify; width:300px; height:155px;\"><legend>�������</legend>";
		echo "<center><table border=0 align=center>";
		echo "<tr><td><small><b>��������� � �������� <a href=http://oldbk.com/encicl/vaucher.html target=_blank>&gt;&gt;&gt;</a></b></small><br><br>";


		$get_vau=mysql_query("SELECT * from oldbk.eshop where id in (".implode(",",$vaucher).")");

		$kk=0;
		 while($rvau=mysql_fetch_array($get_vau))
			{
			$kk++;
			echo "<a href=\"#\" onClick=\"getformdata(5,{$rvau[id]},event);\"><img src=http://i.oldbk.com/i/sh/{$rvau[img]}  title='������ {$rvau[name]}' ></a>";
			if  ((int)($kk/4)==($kk/4)) { echo "<br><br>"; } else { echo "&nbsp;&nbsp;"; }
			}

		echo "</td></tr></table></center>";
		echo "</fieldset>";
		*/
		echo "</td>";

		echo "<td>&nbsp;&nbsp;</td>";

		/*
		echo "<td valign=top align=center>";
		echo "<a name=\"akk\"></a><fieldset style=\"text-align:justify; width:300px; height:150px;\"><legend>��������</legend>";

		echo "<center><table border=0 align=center>";
			echo "<tr><td>";
			echo "<a href=\"#\" onClick=\"getformdata(6,1,event);\"><img src=http://i.oldbk.com/i/036.gif title='������ Silver ������' ></a> - ��������� <b>5 ���</b> <a href=https://oldbk.com/encicl/prem.html target=_blank><img src=http://i.oldbk.com/i/bank/spravka.gif title='���������'></a>&nbsp;<br>";
			echo "<a href=\"#\" onClick=\"getformdata(6,2,event);\"><img src=http://i.oldbk.com/i/037.gif title='������ Gold �������' ></a> - ��������� <b>20 ���</b> <a href=https://oldbk.com/encicl/prem.html target=_blank><img src=http://i.oldbk.com/i/bank/spravka.gif title='���������'></a>&nbsp;<br>";
			echo "<a href=\"#\" onClick=\"getformdata(6,3,event);\"><img src=http://i.oldbk.com/i/137.gif title='������ Platinum �������' ></a> - ��������� <b>35 ���</b> <a href=https://oldbk.com/encicl/prem.html target=_blank><img src=http://i.oldbk.com/i/bank/spravka.gif title='���������'></a>&nbsp;";
			echo "</td></tr></table></center>";
			echo "</fieldset>";

		echo "</td>";
			*/




		echo "</tr>";

		echo "</table><br>
		<table><tr><td><small>
		<font color=#003388><b>�������������� ����������:</b></font><br>
����������� <img src='http://i.oldbk.com/i/deal.gif'><b>������ �����</b> ������������� �����������<br> ����������� ������ ����� � ������������� ������� ������.</b></small></td><tr></table>
		</center>



		";

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	elseif  ($page=='1') // �������� 1 ����
	{
	///��������� ����

		$subpage=(int)$_GET['s'];

		if (!(($subpage>=1)AND($subpage<=4))) $subpage=1;

		////////////////////////////����� ������� ������� + �����
		render_my_money();

		if ($mywarn) { echo "<br><font color=red><b>".$mywarn."</b></font>"; } else { echo ""; }

		echo "<center><table border=0 align=center> ";
		echo "<tr><td valign=top align=center>";

		//������
?>
            <!--<div class="btn-control">
                <a class="button-mid btn<?= $subpage==1?' active':''; ?>" href="<?=$subpage==1?'javascript:void(0)':'?p=1&s=1' ?>">������</a>
                <a class="button-big btn<?= $subpage==2?' active':''; ?>" href="<?=$subpage==2?'javascript:void(0)':'?p=1&s=2' ?>">�����������</a>
                <a class="button-big btn<?= $subpage==3?' active':''; ?>" href="<?=$subpage==3?'javascript:void(0)':'?p=1&s=3' ?>">���������</a>
                <a class="button-mid btn<?= $subpage==4?' active':''; ?>" href="<?=$subpage==4?'javascript:void(0)':'?p=1&s=4' ?>">������</a>
            </div>-->
		<?
		echo "</tr>";
		echo "</table><br>
		</center>";	 ?>

        <?php
            $discount_images = [
                1 => 'http://i.oldbk.com/i/bank/nteaser_discount_gold_%d.gif',
                2 => 'http://i.oldbk.com/i/bank/nteaser_discount_ekr_%d.gif',
                3 => 'http://i.oldbk.com/i/bank/nteaser_discount_rep_%d.gif',
            ];
            $discount_items = [];
            $discount_cost_list = [];
            switch($subpage) {
                case 1:
					$discount_cost_list = $GOLD_DIS_COST;
                    break;
				case 2:
					$discount_cost_list = $EKR_DIS_COST;
					break;
				case 3:
					$discount_cost_list = $REP_DIS_COST;
					break;
            }
		    $discount_items = array_keys($discount_cost_list);
		    asort($discount_items);
        ?>
        <style>
            .sub-menu {
                width: 180px;
                float: left;
            }
            .sub-menu ul li {
                margin-bottom: 5px;
            }
            .discount-content {
                float: left;
                width: 730px;
                margin-left: 20px;
                text-align: center;
            }
            .sub-menu ul, ul.discount-list {
                margin: 0;
                padding: 0;
                list-style: none;
            }
            ul.discount-list li {
                position: relative;
                cursor: pointer;
                float: left;
                margin-right: 4px;
                margin-bottom: 4px;
                max-height: 107px;
            }
            ul.discount-list li img.discount {
                width: 215px;
            }
            ul.discount-list li .discount-price {
                position: absolute;
                top: 49px;
                left: 44px;
                font-weight: bold;
                font-size: 20px;
                color: #496d9d;
            }
        </style>
        <div class="sub-menu btn-control">
            <ul>
                <li>
                    <a class="button-big btn<?= $subpage==1?' active':''; ?>" href="<?=$subpage==1?'javascript:void(0)':'?p=1&s=1' ?>">������</a>
                </li>
                <li>
                    <a class="button-big btn<?= $subpage==2?' active':''; ?>" href="<?=$subpage==2?'javascript:void(0)':'?p=1&s=2' ?>">�����������</a>
                </li>
                <li>
                    <a class="button-big btn<?= $subpage==3?' active':''; ?>" href="<?=$subpage==3?'javascript:void(0)':'?p=1&s=3' ?>">���������</a>
                </li>
                <li>
                    <a class="button-big btn<?= $subpage==4?' active':''; ?>" href="<?=$subpage==4?'javascript:void(0)':'?p=1&s=4' ?>">������</a>
                </li>
            </ul>
        </div>
        <div class="discount-content">
            <?php if($subpage < 4): ?>
                <ul class="discount-list">
                    <?php
                    $discount_i = 1;
                    foreach($discount_items as $count => $_item): ?>
                        <li class="discount-item" onclick="getformdata(0, '<?= sprintf('%d:%d', $subpage, $_item) ?>', event);">
                            <img class="discount" src="<?= sprintf($discount_images[$subpage], $discount_i) ?>">
                            <div class="discount-price"><?= $discount_cost_list[$_item] ?>$</div>
                        </li>
                    <?php $discount_i++; endforeach; ?>
                </ul>
                <div style="clear: both;">
                    <?php if($subpage == 1): ?>
                        <b>��� ������� ������ ���������� ��� ������� <input type="text" size="7" id="kol"  name="kol" value=""></b> <img src='http://i.oldbk.com/i/icon/coin_icon.png' alt='������' title='������'><input class="button-mid btn" type=button name=opl value="��������" onClick="getformdata(0,'1:'+document.getElementById('kol').value,event);">
                    <?php elseif($subpage == 2): ?>
                        <b>��� ������� ������ ���������� ��� ������� <input type="text" size="7" id="kol" name="kol" value=""> ���.</b> <input class="button-mid btn" type=button name=opl value="��������" onClick="getformdata(0,'2:'+document.getElementById('kol').value,event);">
					<?php elseif($subpage == 3): ?>
                        <b>��� ������� ������ ���������� ��� ������� <input type="text" size="7" id="kol"  name="kol" value=""> ���.</b> <input class="button-mid btn" type=button name=opl value="��������" onClick="getformdata(0,'3:'+document.getElementById('kol').value,event);">
                    <?php endif; ?>
                </div>
            <?php elseif((time() > $BUKET_start && time() < $BUKET_end) || (time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']) || ( (time() > mktime(0,0,0,12,1,2017) && time() < mktime(0,0,0,12,31,2017)) OR $user['klan']=='radminion' ) ): ?>
                <ul class="discount-list">
					<?php if(time() > $BUKET_start && time() < $BUKET_end): ?>
		                        <li class="discount-item" onclick="getformdata(69,0,event);">
                		            <img src="http://i.oldbk.com/i/bank/knopka_flowers.gif" title="������ �����">
		                        </li>
					<?php endif; ?>

					<?php if(time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']): ?>
		                        <li class="discount-item" onclick="getformdata(96,0,event);">
                		        <img src="http://i.oldbk.com/i/bank/knopka_elki_2016.gif" title="������ ����">
		                        </li>
					<?php endif; ?>

					<?php
					/*
						$maqxb=70;
                		        	$last_bil_id=mysql_fetch_array(mysql_query("select id from bilet ORDER by id desc limit 1;"));
              		        		if ($last_bil_id[id]<$maqxb)
              		        		{
						if ( (time() > mktime(0,0,0,12,1,2017) && time() < mktime(23,59,59,12,29,2017)) OR $user['klan']=='radminion' ): ?>
			                        <li class="discount-item" onclick="getformdata(2018,0,event);">
	                		        <img src="http://i.oldbk.com/i/sh/8_year.gif" title="������ ����� �� 8-����� �����"> <br> <small>��������� 65 USD</small> <br>
	                		        <small>�������� �������: <strong><?=($maqxb-$last_bil_id[id]);?>/<?=$maqxb;?></strong></small>
		                        	</li>

			                        <li class="discount-item" onclick="getformdata(2118,0,event);">
	                		        <img src="http://i.oldbk.com/i/sh/8_year.gif" title="������ ����� �� 8-����� �����"> <br> <small>��������� 70 USD (� ���������)</small><br>
	                		        <small>�������� �������: <strong><?=($maqxb-$last_bil_id[id]);?>/<?=$maqxb;?></strong></small>
		                        	</li>

						<?php endif;
						}
					*/
						?>

                </ul>
            <?php endif; ?>
        </div>
        <?php


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	else
	if ($page==2)
	{

	///��������� ����
		if($_POST['in'] && $_POST['ik']) {
		$_POST['ik'] = round($_POST['ik'],2);
		if (is_numeric($_POST['ik']) && ($_POST['ik']>0) && ($_POST['ik'] <= $user['money'])) {

			if (mysql_query("UPDATE `users` SET `money` = `money` - '".$_POST['ik']."' WHERE `id`= '".$user['id']."' LIMIT 1;")) {
				$mywarn_putinput="������ ������ �������� �� ����";
				$putkr=$bank['cr']+$_POST['ik'];
				mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` + '".$_POST['ik']."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$user['money'] -= $_POST['ik'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=25;//�������� ����
					$rec['sum_kr']=$_POST['ik'];
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
					$rec['bank_id']=$_SESSION['bankid'];
					add_to_new_delo($rec); //�����

				if (olddelo==1)
				{
				mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� �� ���� ���� �".$_SESSION['bankid']." ".$_POST['ik']." ��. ',1,'".time()."');");
				}

				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�� �������� �� ���� <b>{$_POST['ik']} ��.</b>, �������� <b>0 ��.</b> <i>(�����: {$putkr} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
			}
			else {
				$mywarn_putinput="��������� ������!";
			}
		}
		else {
			$mywarn_putinput="� ��� ������������ ����� ��� ���������� ��������";
		}
		$_POST['in']=0;
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."';"));
	}
	elseif($_POST['out'] && $_POST['ok']) {
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['cr'])) {

			if (mysql_query("UPDATE `users` SET `money` = `money` + '".$_POST['ok']."' WHERE `id`= '".$user['id']."' LIMIT 1;")) {
				$mywarn_putinput="������ ������ ����� �� �����";
				mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` - '".$_POST['ok']."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$user['money'] += $_POST['ok'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=26;//���� �� �����
					$rec['sum_kr']=$_POST['ok'];
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
					$rec['bank_id']=$_SESSION['bankid'];
					add_to_new_delo($rec); //�����

				if (olddelo==1)
				{
				mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ���� �� ������ ����� �".$_SESSION['bankid']." ".$_POST['ok']." ��.',1,'".time()."');");
				}

				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� ����� �� ����� <b>{$_POST['ok']} ��.</b>, �������� <b>0 ��.</b> <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");

			}
			else {
				$mywarn_putinput="��������� ������!";
			}
		}
		else {
			$mywarn_putinput="������������ ����� ��� ���������� ��������";
		}
		$_POST['out']=0;
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
	}
	elseif($_POST['change'] && $_POST['ok']) {
		$mywarn_exch="&nbsp;";
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['ekr'])) {
			$bank['cr'] += $_POST['ok'] * EKR_TO_KR;
			$bank['ekr'] -= $_POST['ok'];
			$add_money=$_POST['ok'] * EKR_TO_KR;

			if (mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` + '$add_money' WHERE `id`= '".$bank['id']."' LIMIT 1;")) {
				$mywarn_exch="����� ���������� �������";
				$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '".$_POST['ok']."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=27;//������� ���->kr
					$rec['sum_kr']=$add_money;
					$rec['sum_ekr']=$_POST['ok'];
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����


				if (olddelo==1)
				{
				mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� ".$_POST['ok']." ���. �� ".$add_money." ��. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
				}

				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� <b>{$_POST['ok']}</b> ���. �� <b>".$add_money."</b> ��., �������� <b>0 ��.</b> <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
			}
			else {
				$mywarn_exch="��������� ������!";
			}
		}
		else {
			$mywarn_exch="������������ ����� �� ����� ��� ���������� ��������";
		}
		$_POST['change']=0;
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
	}
	elseif($_POST['goldchange'] && $_POST['goldok']) {

		$mywarn_goldexch="&nbsp;";
		$_POST['goldok'] = (int)($_POST['goldok']);
		if (is_numeric($_POST['goldok']) && ($_POST['goldok']>0) && ($_POST['goldok'] <= $user['gold'])) {


			$add_money=$_POST['goldok'] * 10;

			if (mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` + '$add_money' WHERE `id`= '".$bank['id']."' LIMIT 1;")) {
				$mywarn_goldexch="����� ���������� �������";

				mysql_query('UPDATE users SET gold = gold - '.($_POST['goldok']).' WHERE id = '.$user['id'].' LIMIT 1');
				$user['gold']-=$_POST['goldok'];
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$bank['id']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=599;//������� gold->kr
					$rec['sum_kr']=$add_money;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info'] = $_POST['goldok']."/".$user['gold'];
					add_to_new_delo($rec); //�����



				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� <b>{$_POST['goldok']}</b> ����� �� <b>".$add_money."</b> ��., <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
			}
			else {
				$mywarn_goldexch="��������� ������!";
			}
		}
		else {
			$mywarn_goldexch="������������ ����� ��� ���������� ��������";
		}
		$_POST['goldchange']=0;

	}
	/*
	elseif($_POST['changerep'] && $_POST['ok']) {
		$_POST['ok'] = round($_POST['ok'],2);
		if (is_numeric($_POST['ok']) && ($_POST['ok']>0) && ($_POST['ok'] <= $bank['ekr'])) {
			$user['repmoney'] += $_POST['ok'] * 300;
			$bank['ekr'] -= $_POST['ok'];
			$add_money=$_POST['ok'] * 300;
			if (mysql_query("UPDATE `users` SET  `rep`=`rep`+'$add_money' , `repmoney` = `repmoney` + '$add_money' WHERE `id`= '".$user['id']."' LIMIT 1;")) {
				$mywarn="����� ���������� �������";
				$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '".$_POST['ok']."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=28;//������� ���->rep
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$_POST['ok'];
					$rec['sum_rep']=$add_money;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����

				if (olddelo==1)
				{
				mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� ".$_POST['ok']." ���. �� ".$add_money." ����. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
				}

				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� <b>{$_POST['ok']}</b> ���. �� <b>".$add_money."</b> ����., �������� <b>0 ��.</b>','{$_SESSION['bankid']}');");
			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
		}
		$_POST['change']=0;
	}*/
	elseif($_POST['changeback'] && $_POST['krtoekr']) {
	//0,000625 ���� 1600 �� = 1 ���
        $_POST['krtoekr']=(int)$_POST['krtoekr'];
        $add_ekr=floor(($_POST['krtoekr']*0.000625)*100);
        $add_ekr=round($add_ekr/100,2);
        $_POST['krtoekr'] = floor($add_ekr/0.000625);
//ECHO         $_POST['krtoekr'];
	if ($_POST['krtoekr']>=16)
	{

        if (is_numeric($_POST['krtoekr']) && ($_POST['krtoekr']>0) && ($_POST['krtoekr'] <= $bank['cr']) && is_numeric($add_ekr) && ($add_ekr >0)) {
            $bank['cr'] -= $_POST['krtoekr'];
            $bank['ekr'] += $add_ekr;
            if (mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` - '".$_POST['krtoekr']."' WHERE `id`= '".$bank['id']."' LIMIT 1;")) {
                $mywarn_putinput="������ �������� {$_POST['krtoekr']} ��. �� {$add_ekr} ���.";
                $bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
                mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '$add_ekr' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
                $bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."';"));
                //new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=29;//������� ��->���
					$rec['sum_kr']=$_POST['krtoekr'];
					$rec['sum_ekr']=$add_ekr;
					$rec['sum_rep']=0;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����
                if (olddelo==1)
                {
                mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� ".$_POST['krtoekr']." ��. �� ".$add_ekr." ���. �� ����� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
                }
				mysql_query("INSERT INTO `oldbk`.`bank_ekr_log`(`id` , `owner` ,`kr`, `ekr`, `date`) VALUES ('','{$_SESSION['uid']}','{$_POST['krtoekr']}','{$add_ekr}','".time()."');");
				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� <b>{$_POST['krtoekr']}</b> ��. �� <b>".$add_ekr."</b> e��., �������� <b>0 ��.</b> <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
            }
            else {
                $mywarn_putinput="��������� ������!";
            }
        }
	        else {
	            $mywarn_putinput="������������ �������� �� �����";
	        }
        }
        	else
        	{
        	    $mywarn_putinput="���������� ����� �������� 16 ��.";
        	}

        $_POST['changeback']=0;
    }
    elseif($_POST['wu'] && $_POST['sum'] && $_POST['number'])
		{
		$_POST['number']=(int)$_POST['number'];
		if ($user['align'] == 4 && $user['id'] != '188') {
			$mywarn_trans="��������� �������� ���������!";
		}
		else {
			$bank2 = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '{$_POST['number']}' ;"));
			//$to = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$bank2['owner']}' ;"));
			$to = check_users_city_data($bank2['owner']);

			if ( ($to[level]>=4) and ($user[level]>=4))
			{
			if($bank2[0]){
				$_POST['sum'] = round($_POST['sum'],2);
				if (is_numeric($_POST['sum']) && ($_POST['sum']>0))
				{
					$nalog=round($_POST['sum']*0.03);
					if ($nalog < 1) {$nalog=1; }
					$new_sum=$_POST['sum']+$nalog;
					if ($new_sum <= $bank['cr']) {
						if (mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` - '".$new_sum."' WHERE `id`= '{$_SESSION['bankid']}' LIMIT 1;")) {
							mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` + '".$_POST['sum']."' WHERE `id`= '{$_POST['number']}' LIMIT 1;");
							$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '{$_SESSION['bankid']}' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=$to[id];
					$rec['target_login']=$to['login'];
					$rec['type']=49;//������� - ������� � �����
					$rec['sum_kr']=$_POST['sum'];
					$rec['sum_ekr']=0;
					$rec['sum_rep']=0;
					$rec['sum_kom']=$nalog;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']=$_POST['number'];
					add_to_new_delo($rec); //�����
					$rec['owner']=$to[id];
					$rec['owner_login']=$to[login];
					$rec['owner_balans_do']=$to['money'];
					$rec['owner_balans_posle']=$to['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user['login'];
					$rec['type']=50;// ������� - ������� � �����
					$rec['bank_id']=$_POST['number'];
					$rec['add_info']=$_SESSION['bankid'];
					add_to_new_delo($rec); //����������

						if (olddelo==1)
						{
							mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� �� ������ ����������� ����� �".$_SESSION['bankid']." �� ���� �".$_POST['number']." � ��������� ".$to['login']." ".$_POST['sum']." ��. ������������� ����� ".$nalog." ��. �� ������ ����� ',1,'".time()."');");
							mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$bank2['owner']}','�������� \"".$user['login']."\" ������� �� ������ ����������� ����� �".$_SESSION['bankid']." �� ���� �".$_POST['number']." � ��������� ".$to['login']." ".$_POST['sum']." ��. ������������� ����� ".$nalog." ��. �� ������ ����� ',1,'".time()."');");
						}
							$sum=$_POST['sum'];
							$schet=$_POST['number'];
							$mywarn_trans="$sum ��. ������� ���������� �� ���� � $schet";
							mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� <b>".$sum."</b> ��. �� ���� � ".$schet."<i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");

							$ttxt="�������� ".s_nick($user['id'],$user['align'],$user['klan'],$user['login'],$user['level'])." ������� <b>".$sum."</b>  ��. �� ������ ����������� ����� �".$_SESSION['bankid']." �� ��� ���� �".$_POST['number'].". ";
							telepost_new($to,'<font color=red>��������!</font> '.$ttxt);
						}
						else
						{
							$mywarn_trans="��������� ������!";
						}
					}
					else {
						$mywarn_trans="� ��� ������������ ����� �� ����� ��� ���������� ��������";
					}
				}
				else {
					$mywarn_trans="� ��� ������������ ����� �� ����� ��� ���������� ��������";
				}
			}
			else {
				$mywarn_trans="������ � ����� ���������� �� �������.";
			}
		    }
		    else
		    {
		    	$mywarn_trans="�������� �������� ���������� � 4-�� ������!";
		    }
		}
		$_POST['wu']=0;
	}
	elseif (($_POST['sendekrs']) and ($_POST['pass']) and ((int)($_POST['toid'])>0) and ($_POST['sumekr']) )
				{
				$summekr=round(floatval($_POST['sumekr']),2);
					 if (($summekr>0) and ($summekr<$bank['ekr'] ) )
					 	{
						$toid=(int)($_POST['toid']);

							if ($toid!=$bank['id'])
								{
								//�������� ����� �� �������������� � ������
								$get_test_tobank=mysql_fetch_array(mysql_query("select * from oldbk.bank  where owner='{$user['id']}' and id='{$toid}'  "));
									if ($get_test_tobank['id']>0)
										{
										$inppass=md5($_POST['pass']);
											if ($get_test_tobank['pass']==$inppass)
												{
													mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '".$summekr."' WHERE `id`= '{$_SESSION['bankid']}' and owner='{$user['id']}' and ekr>='{$summekr}'  LIMIT 1;");
													 if (mysql_affected_rows()>0)
													{
													//����� � ���� � ������ � �������� �����
													$bank['ekr_do']=$bank['ekr'];
													$bank['ekr']-=$summekr;
													mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�� �������� �� ����� <b>{$bank['id']}</b> �� ���� <b>{$toid}</b> , ����� <b>{$summekr} ���.</b> <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");

													$komis=round($summekr*0.02,2);
													if ($komis<0.1) $komis=0.1;
													$summekrto=$summekr-$komis;

														mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$summekrto."' WHERE `id`= '{$toid}' LIMIT 1;");
														 if (mysql_affected_rows()>0)
														 		{
														 		//������� �������
																				//new_delo
															  		    			$rec['owner']=$user['id'];
																				$rec['owner_login']=$user['login'];
																				$rec['owner_balans_do']=$user['money'];
																				$rec['owner_balans_posle']=$user['money'];
																				$rec['target']=0;
																				$rec['target_login']='����';
																				$rec['type']=2221;
																				$rec['sum_kr']=0;
																				$rec['sum_ekr']=$summekr;
																				$rec['sum_kom']=$komis;
																				$rec['bank_id']=$_SESSION['bankid'];
																				$rec['add_info']='������ �� '.$bank['ekr_do']. ' ����� ' .$bank['ekr'].' (������� �� ����: '.$toid.' ) ';
																				add_to_new_delo($rec); //�����
														 		//����� � �������
														 		$get_test_tobank['ekr']+=$summekrto;
	 															mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�������  �� ����� <b>{$bank['id']}</b> �� ���� <b>{$toid}</b> , ����� <b>{$summekrto} ���.</b>, �������� <b>{$komis} ���.</b>  <i>(�����: {$get_test_tobank['cr']} ��., {$get_test_tobank['ekr']} ���.)</i>','{$toid}');");
 																$message="<small>������ ���������� �� ����� <b>{$bank['id']}</b> �� ���� <b>{$toid}</b><br>C���� <b>{$summekrto} ���.</b>, �������� <b>{$komis} ���.</b></small>";
														 		}

													}
												}
												else
												{
												$message='<small>������ ������ �� ����� ����������!</small>';
												}
										}
										else
										{
										$message='<small>� ��� ����� ���� �� ������!</small>';
										}
								}
								else
								{
								$message='<small>�����?!</small>';
								}
						}
						else
						{
						$message='<small>�� ����� ����� ��� ����� �����!</small>';
						}
				}


	//����

			$kobank[8325]=474;   $logko[8325]='���������� �����';
			$kobank[2]=9;   $logko[2]='�����';

			$toidko=(int)($_POST['krko']);
			$sumko=round($_POST['sumko'],2);

			if ( (isset($_POST['sendko'])) OR  (isset($_POST['sendko2'])) )
			{

			if ($kobank[$toidko] > 0)
				{

				if ($sumko>0)
				{

				  if ($sumko<=$bank['cr'])
				  	{

						if ( strlen($_POST['primko']) >101 )
						{
						$mywarn_ko="���������� �� ����� 100 ��������!";
						}
						elseif ($_POST['primko']!='')
						{

						// ������ ������� ���
							mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` - '".$sumko."' WHERE `id`= '{$_SESSION['bankid']}' and cr>={$sumko}  LIMIT 1;");
							 if (mysql_affected_rows()>0)
									{
									mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` + '".$sumko."' WHERE `id`= '{$kobank[$toidko]}' LIMIT 1;");
									$bank['cr']-=$sumko;
									mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� <b>".$sumko."</b> ��. �� ���� ��������� ".$logko[$toidko]." <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
									mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','������� �� �����:<b>".$sumko."</b> ��. �� ��������� ".$user['login']." ���� �".$bank['id']."  <i>(����:".mysql_real_escape_string(htmlspecialchars($_POST['primko'])).")</i>','{$kobank[$toidko]}');");
									$kotext='<font color=red>��������!</font> ����������: <b>'.$sumko.' </b> ��  �� ��������� <b>'.$user['login'].'</b>, �� ����� �'.$bank['id'].' <i>(����:'.mysql_real_escape_string(htmlspecialchars($_POST['primko'])).')</i> ';
									telepost($logko[$toidko],$kotext) ;
									$mywarn_ko="$sumko ��. ���������� ��������� $logko[$toidko] ";

									$rec=array();																		//new_delo
				  		    			$rec['owner']=$user[id];
									$rec['owner_login']=$user[login];
									$rec['owner_balans_do']=$user['money'];
									$rec['owner_balans_posle']=$user['money'];
									$rec['target']=$toidko;
									$rec['target_login']=$logko[$toidko];
									$rec['type']=3368;
									$rec['sum_kr']=$sumko;
									$rec['bank_id']=$bank['id'];
									add_to_new_delo($rec); //�����
									//new_delo
									$rec=array();
				  		    			$rec['owner']=$toidko;
									$rec['owner_login']=$logko[$toidko];
									$rec['target']=$user[id];
									$rec['target_login']=$user[login];
									$rec['type']=3373;
									$rec['sum_kr']=$sumko;
									$rec['bank_id']=$bank['id'];
									add_to_new_delo($rec); //�����

									}
						}
						else
						{
						 $mywarn_ko="������� ���������� ��������!";
						}
					}
					else
					{
					 $mywarn_ko="�� ����� ������������ �� ��� ��������!";
					}
				 }
				 else
				 {
				 $mywarn_ko="������� ����� ��������!";
				 }
				}
				 else
				 {
				 $mywarn_ko="������� ���������� ��������!";
				 }
			}

			//��� ������ ������ �����
			if ((isset($_POST['sendko2'])) and ($mywarn_ko!='') )
				{
				$mywarn_ko2=$mywarn_ko;
				unset($mywarn_ko);
				}

////////////////////////////����� ������� ������� + �����
	render_my_money();

		if ($mywarn) { echo "<br><font color=red><b>".$mywarn."</b></font>"; } else { echo ""; }
		echo "<center><table border=0 align=center> ";
		echo "<tr><td valign=top align=center>";

		echo "<fieldset style=\"text-align:justify; width:330px; height:105px; padding-bottom: 15px;\"><legend>����/����� ��������</legend>";

		echo "<center><table border=0 align=center  width=100% cellspacing=\"0\" cellpadding=\"0\" >";
		echo "<tr><td>";
		echo "<form method=\"post\" >
				<table border=0 align=center  width=100% cellspacing=\"0\" cellpadding=\"0\" >
				<TR><TD><small>�������� ������� �� ����</small></td><TD><input type=text size=6 name=ik onkeyup=\"this.value=this.value.replace(/[^\d.]/g, '');\" ></td><TD><div class='btn-control' style='display: inline-block'><input class='button-mid btn' type=submit name=in value=\"��������\"></div></td></tr>
				<TR><TD><small>����� ������� �� �����</small></td><TD><input type=text size=6 name=ok onkeyup=\"this.value=this.value.replace(/[^\d.]/g, '');\" ></td><TD><div class='btn-control' style='display: inline-block'><input class='button-mid btn' type=submit name=out value=\"�����\"></div></td></tR>
				<TR><TD><small>�������� ������� �� ��� <br> <font color=red><b>1600</b></font> ��. = 1 ���.</small></td><TD><input type=text size=6 name=krtoekr onkeyup=\"this.value=this.value.replace(/[^\d.]/g, '');\" ></td><TD><div class='btn-control' style='display: inline-block'><input class='button-mid btn' type=submit name=changeback value=\"��������\"></div></td></tR>
				</table>

			</form></td></tr>";

		echo "<tr height=14px><td><small><font color=red><b>".$mywarn_putinput."</b></font></small>";

		echo "</td></tr></table></center></fieldset>";

		echo "</td>";
		echo "<td>";


		echo "<fieldset style=\"text-align:justify; width:330px; height:105px; padding-bottom: 15px;\"><legend>��������� ������ �� ����</legend>";
		echo "<center><table border=0 align=center  width=100% cellspacing=\"0\" cellpadding=\"0\" >";
		echo "<tr><td>";
		echo '<script>
			function CheckBankInfo() {

				var bnum = parseInt($("#banknumber").val());
				var bsum = parseFloat($("#banksum").val());

				if (bnum > 0 && bsum > 0) {
				        $.get("bank.php?bn="+bnum, function(data) {
						html = "<small>";
						html += "<font color=red><b>�� �������, ��� ������ ��������� "+bsum+" �� �� ���� �"+bnum+", ������������� ��������� "+data+"?</b></font>";
						html += "</small><br><center>";
						html += "<div class=\"btn-control\" style=\"display: inline-block;\">";
						html += "<input class=\"button-mid btn\" type=submit name=wu value=\"��\"></div></center>";

						$("#addtransferinfo").html(html);
					});
				}


			}
			</script>';

		echo "<form method=\"post\" >
				<table>
				<TR><TD><small>�����</small></td><TD><input type=text id=\"banksum\" size=12 name=sum onkeyup=\"this.value=this.value.replace(/[^\d.]/g, '');\"  ></td>
				<TD rowspan=2 align=center valign=middle>
				    <div class='btn-control' style='display:inline-block;'>
				        <input class='button-mid btn' type=button OnClick=\"CheckBankInfo()\" value=\"���������\">
                    </div>
				</td></tr>
				<TR><TD><small>����� �����</small></td><td><input id=\"banknumber\" type=text size=12 name=number onkeyup=\"this.value=this.value.replace(/[^\d]/,'');\" ></td></tr>
				</table>";
				if ($mywarn_trans!='')
					{
					echo "<span id='addtransferinfo'><small><font color=red><b>".$mywarn_trans."</b></font></small></span>";
					}
					else
					{
					echo "<span id='addtransferinfo'><small>�������� �������� 3% �� ����������� �����,<br> �� �� ����� 1 ������� </small></span>";
					}
				echo "</form>";
		echo "</td></tr></table></center></fieldset>";

		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";

		echo "<fieldset style=\"text-align:justify; width:330px; height:165px;\"><legend>�������� �� ������� </legend>";

		echo "<center><table border=0 align=center  width=100% cellspacing=\"0\" cellpadding=\"0\" >";
		echo "<tr><td>";
		echo "<form method=\"post\" >
				<small>����� ������������ ��� ������</small><br>
				<input type=text name=ok onkeyup=\"this.value=this.value.replace(/[^\d.]/g, '');\"  > <div class='btn-control' style='display: inline-block'><input class='button-mid btn' type=submit name=change value=\"��������\"></div><br>
				<small> ���� ������: 1 ���������� = ".EKR_TO_KR." �������� </small>
				</form></td></tr>";
		echo "<tr height=14px><td><small><font color=red><b>".$mywarn_exch."</b></font></small></td></tr>";



		echo "<tr><td><form method=\"post\" >
				<small>����� ����� ��� ������</small><br>
				<input type=text name=goldok onkeyup=\"this.value=this.value.replace(/[^\d]/g, '');\"  > <div class='btn-control' style='display: inline-block'><input class='button-mid btn' type=submit name=goldchange value=\"��������\"></div><br>
				<small> ���� ������: 1 ������ = 10 �������� </small>
				</form></td></tr>";


		echo "<tr><td><small><font color=red><b>".$mywarn_goldexch."</b></font></small>";
		echo "</td></tr></table></center></fieldset>";

		echo "</td>";
		echo "<td>";
		/*
		echo "<fieldset style=\"text-align:justify; width:330px; height:110px;\"><legend>�������� ����������� �� ���������</legend>";

		echo "<center><table border=0 align=center>";
		echo "<tr><td><br>";

			echo "<form method=\"post\" >

				<small>����� ������������ ��� ������</small><br>

				<input type=text name=ok> <input type=submit name=changerep style=\"width:60px;\" value=\"��������\"><br>
				<small> ���� ������: 1 ���������� = 300 ��������� </small>
				</form>";
		echo "</td></tr></table></center></fieldset>";
		*/

	/*	echo "<fieldset style=\"text-align:justify; width:330px; height:110px;\"><legend>�������� ������� �� �����������</legend>";

		echo "<center><table border=0 align=center>";
		echo "<tr><td><br>";

			echo "<form method=\"post\" >
				<small>����� �������� ��� ������</small><br>
				<input type=text name=ok> <input type=submit name=changeback style=\"width:60px;\" value=\"��������\"></br>
				<small> ���� ������: 18 �������� = 1 ���������� </small>
				</form>";

		echo "</td></tr></table></center></fieldset>";
	*/

		if (($_SESSION['bankid']==2221) OR ($_SESSION['bankid']==2222)  )
			{

			echo "<fieldset style=\"text-align:justify; width:330px; height:110px;\"><legend>������������ �����</legend>";
			echo "<center><table border=0 align=center>";
			echo "<tr><td>";
			// �� �����

			$toidko=(int)($_POST['ekrto']);
			 if ($toidko>0)
				{
				$sumko=round($_POST['sumko'],2);
				$totelo=mysql_fetch_array(mysql_query("select * from users where id=(select owner from oldbk.bank where id='{$toidko}') "));
				}

			if (($_POST['sendko']) OR ($_POST['okyes']) )
			{
			if ($totelo['id'] > 0)
				{
				if ($sumko>0)
				{
				  if ($sumko<=$bank['ekr'])
				  	{
						if ( strlen($_POST['primko']) >101 )
						{
							 err("���������� �� ����� 100 ��������!");
						}
						elseif ($_POST['primko']!='')
						{
							if ($_POST['okyes'])
							{
							// ������ ������� ���
								mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '".$sumko."' WHERE `id`= '{$_SESSION['bankid']}' and ekr>={$sumko}  LIMIT 1;");
								 if (mysql_affected_rows()>0)
									{
									mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$sumko."' WHERE `id`= '{$toidko}' LIMIT 1;");
									$bank['ekr']-=$sumko;
									mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� <b>".$sumko."</b> ���. �� ���� �".$toidko." ��������� ".$totelo['login']." <i>(����:".mysql_real_escape_string(htmlspecialchars($_POST['primko'])).")</i>','{$_SESSION['bankid']}');");
									mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','������� �� �����:<b>".$sumko."</b> ���. �� ��������� ".$user['login']." <i>(����:".mysql_real_escape_string(htmlspecialchars($_POST['primko'])).")</i>','{$toidko}');");
									$kotext='<font color=red>��������!</font>�� ��� ����  �'.$toidko.' ���������� <b>'.$sumko.'</b> ���  �� ��������� <b>'.$user['login'].'</b>. <i>(����:'.mysql_real_escape_string(htmlspecialchars($_POST['primko'])).')</i> ';
									telepost($totelo['login'],$kotext) ;
									err("{$sumko} ���. ���������� � {$totelo['login']} �� ���� �{$toidko}");

									//new_delo
									$rec=array();
				  		    			$rec['owner']=$user[id];
									$rec['owner_login']=$user[login];
									$rec['owner_balans_do']=$user['money'];
									$rec['owner_balans_posle']=$user['money'];
									$rec['target']=$totelo['id'];
									$rec['target_login']=$totelo['login'];
									$rec['type']=3371;
									$rec['sum_ekr']=$sumko;
									$rec['bank_id']=$toidko;
									add_to_new_delo($rec); //�����
									//new_delo
									$rec=array();
				  		    			$rec['owner']=$totelo['id'];
									$rec['owner_login']=$totelo['login'];
									$rec['owner_balans_do']=$totelo['money'];
									$rec['owner_balans_posle']=$totelo['money'];
									$rec['target']=$user[id];
									$rec['target_login']=$user[login];
									$rec['type']=3372;
									$rec['sum_ekr']=$sumko;
									$rec['bank_id']=$toidko;
									add_to_new_delo($rec); //�����
									}
							unset($_POST['sumko']);
							unset($_POST['ekrto']);
							unset($_POST['primko']);
							}
						}
						else
						{
						 err("������� ���������� ��������!");
						}
					}
					else
					{
					 err("�� ����� ������������ ��� ��� ��������!");
					}
				 }
				 else
				 {
				 err("������� ����� ��������!");
				 }
				}
				 else
				 {
				 err("���������� �� ������!");
				 }
			}


			echo "<form method=\"post\" >
				��������� �� ����:<input type=\"text\" name=\"ekrto\" value=\"".$_POST['ekrto']."\" size=12>";
				if (($totelo['login']!='') and (!($_POST['okyes'])) )  { echo "�����:".$totelo['login']; }
			echo "<Br>
				<small>����� ���.&nbsp;</small><input type=text name=sumko size=12 value='".$_POST['sumko']."' ><br>
				<small>����������</small><input type=text name=primko size=25 value='".$_POST['primko']."'>";

				if ($_POST[sendko]): ?>
				    <div class="btn-control" style="display: inline-block">
                        <input class="button-mid btn" type=submit name=okyes style="width:60px;" value="�����������">
                        <input class="button-mid btn" type=submit name=okno style="width:60px;" value="������">
                    </div>
				<?php else: ?>
                    <div class="btn-control" style="display: inline-block">
				        <input class="button-mid btn" type=submit name=sendko style="width:60px;" value="���������">
                    </div>
				<?php endif;

				echo "</br></form>";
			echo "</td></tr></table></center></fieldset>";

			}
			else
			{

			echo "<fieldset style=\"text-align:justify; width:330px; height:165px;\"><legend>������ �������� � ������ ��������</legend>";
			echo "<center><table border=0 align=center>";
			echo "<tr><td><br>";

			echo "<form method=\"post\" >
				<input type=\"radio\" name=\"krko\" value=\"8325\">���������� �����<Br>

				<small>����� ��.&nbsp;</small><input type=text name=sumko size=12><br>
				<small>����������</small><input type=text name=primko ize=25>
				<div class='btn-control' style='display: inline-block;'>
				    <input class='button-mid btn' type=submit name=sendko value=\"���������\">
                </div>
				</br>
				</form></td></tr>";

			echo "<tr height=14px><td><small><font color=red><b>".$mywarn_ko."</b></font></small>";
			echo "</td></tr></table></center></fieldset>";

			}

		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";

echo "<fieldset style=\"text-align:justify; width:330px; height:120px;\"><legend>��������� ���. �� ���� ������ ����</legend>";

		echo "<center><table border=0 align=center >";
		echo "<tr><td align=center>";

			echo "<form method=\"post\" >";
			echo "<table border=0  cellspacing='0' cellpadding='0' align=center> <tr><td>";
			echo "<small>�����:</small></td><td><input type=text name=sumekr size=12></td><TD rowspan=3 align=center valign=middle><div class='btn-control' style='display: inline-block'><input class='button-mid btn' type=submit name=sendekrs value=\"���������\"></div></td></td></tr>
				<tr><td><small>����� �����:</small></td><td>";
				$banks = mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `owner` = '".$user['id']."' and id!='{$bank['id']}'  ;");

				echo "<select style='width:100px' name=toid>";
				while ($rah = mysql_fetch_array($banks))
				{
					echo "<option>",$rah['id'],"</option>";
				}
				echo "</select></td></tr>";
			echo "<tr><td><small>������:</small></td><td><input type=password name='pass' style='width:100px'></td></tr>";


		 	echo "<tr><td colspan='3'><small>�������� �������� 2% �� ����������� �����, �� �� ����� 0.1 ���.</small></td></tr>";

			 if ($message!='')
			 	{
			 	echo "<tr><td colspan='3'><font color=red>";
				echo "$message";
				echo "</font></td></tr>";
				}
		echo "</table></form>";


		echo "</td>";
		echo "</tr></table></center></fieldset>";

		echo "</td>";


		echo "<td>";

			echo "<fieldset style=\"text-align:justify; width:330px; height:120px;\"><legend>���������� ������</legend>";
			echo "<center><table border=0 align=center>";
			echo "<tr><td>";
			echo "<form method=\"post\" >
				<input type=\"radio\" name=\"krko\" value=\"2\">�����<Br>
				<small>����� ��.&nbsp;</small><input type=text name=sumko size=12><br>
				<small>����������</small><input type=text name=primko ize=25>
				<div class='btn-control' style='display: inline-block'>
				    <input class='button-mid btn' type=submit name=sendko2 value=\"���������\">
				</div>
				</br>
				</form></td></tr>";
			echo "<tr height=14px><td><small><font color=red><b>".$mywarn_ko2."</b></font></small>";
			echo "</td></tr></table></center></fieldset>";

		echo "</td>";

		echo "</tr>";
		echo "</table>";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	else
	if ($page==3)
	{

	//��������� ����

	$cheff=mysql_fetch_array(mysql_query("SELECT * from  `effects` WHERE type = '".$eff_align_type."' AND owner = '".$user['id']."' LIMIT 1;"));


	if ($_GET['dropsk']) {
		if ($user['klan'] == "" && ($user['align'] == 2 || $user['align'] == 3  || $user['align'] == 6 || $user['align'] == 2.4)) {
			mysql_query('UPDATE `users` SET `align` = 0 WHERE `id` = '.$user['id']);

			undressall($user['id'],$user['id_city']);

			mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`)
			VALUES ('','".$user['id']."','��������� �� ���������� ����� ����','".time()."');");

			echo '�� ������� ����� ����������...';
		}
	}

	elseif($_GET['setskltemn']) {
	if ($user['klan'] == '' && $user['align'] == 0)
	{
	   if($cheff['time']>time() && $cheff['add_info']!=3)
		{
			$mywarn= '�� �� ������ ���������� ���������� ��� '.prettyTime(null,$cheff['time']).'. ����� ����� ����������� �������������� ������� <a href="http://oldbk.com/encicl/?/predmeti/nulled_timeout.html" target=_blank>������ ������ ����������</a>.';
		}
		else
		{
			if (15 <= $bank['ekr'])
			{
				if (mysql_query("UPDATE `users` SET `align` = '3' WHERE `id`= '".$user['id']."' LIMIT 1;"))
				{
					$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
					mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '15' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = ".$_SESSION['bankid'].";"));
					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=47;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=15;
					$rec['sum_rep']=0;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����

					$mywarn="���������� ������� ���������.";
	      				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� ��������� ���������� �� <b>15</b> ���.<i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");


					$la=0;

					$last_aligh=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_last_align` WHERE `owner` = '".$user['id']."' LIMIT 1;"));   //��� ����� ������� �� ��������� ������
					if($last_aligh[id]>0)
					{
						$la=$last_aligh[align];
					}
					if($cheff['add_info']==3) //��� ������ ��� ����, �� �� ��������� ���.
					{
						$la=0;
					}

					if($la!=3 && !$cheff[id])
					{
						$sql="INSERT INTO oldbk.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','3');";
						//echo $sql;
						mysql_query($sql);
						$sql="INSERT INTO avalon.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','3');";
						mysql_query($sql);

						$sql="INSERT INTO angels.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','3');";
						mysql_query($sql);
						//������ ���, ���������.
					}






				}
				else
				{
					$mywarn="��������� ������!";
				}
			}
			else {
				$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
			}
        	}
		$_GET['setskltemn']=0;
	    }
	    else
		{
		$mywarn="� ��� ��� ���� ���� ��� ����������!";
		}
	}
	else
	if($_GET['setsklneytr']) {
	if ($user['klan'] == '' && $user['align'] == 0)
	     {
		if($cheff['time']>time() && $cheff['add_info']!=2)
		{
					$mywarn= '�� �� ������ ���������� ���������� ��� '.prettyTime(null,$cheff['time']).'. ����� ����� ����������� �������������� ������� <a href="http://oldbk.com/encicl/?/predmeti/nulled_timeout.html" target=_blank>������ ������ ����������</a>.';
		}
		else
		{
			if (15 <= $bank['ekr']) {
				if (mysql_query("UPDATE `users` SET `align` = '2' WHERE `id`= '".$user['id']."' LIMIT 1;"))
				{
					$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
					mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '15' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=48;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=15;
					$rec['sum_rep']=0;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����



					$mywarn="���������� ������� ���������.";
	       					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� ��������� ���������� �� <b>15</b> ���.<i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");

                    			$la=0;

					$last_aligh=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_last_align` WHERE `owner` = '".$user['id']."' LIMIT 1;"));   //��� ����� ������� �� ��������� ������
					if($last_aligh[id]>0)
					{
						$la=$last_aligh[align];
					}
					if($cheff['add_info']==3) //��� ������ ��� ����, �� �� ��������� ���.
					{
						$la=0;
					}

					if($la!=2 && !$cheff[id])
					{
						$sql="INSERT INTO oldbk.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','2');";
						//echo $sql;
						mysql_query($sql);
						$sql="INSERT INTO avalon.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','2');";
						mysql_query($sql);
						$sql="INSERT INTO angels.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','2');";
						mysql_query($sql);
						//������ ���, ���������.
					}
				}
				else
				{
					$mywarn="��������� ������!";
				}
			}
			else {
				$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
			}
		 }
		 $_GET['setsklneytr']=0;
		}
		else
		{
		$mywarn="� ��� ��� ���� ���� ��� ����������!";
		}
	}
	else
	if($_GET['setsklsvet']) {
	if ($user['klan'] == '' && $user['align'] == 0)
	 {
		if($cheff['time']>time() && $cheff['add_info']!=6)
		{
				$mywarn= '�� �� ������ ���������� ���������� ��� '.prettyTime(null,$cheff['time']).'. ����� ����� ����������� �������������� ������� <a href="http://oldbk.com/encicl/?/predmeti/nulled_timeout.html" target=_blank>������ ������ ����������</a>.';
		}
		else
		{
			if (15 <= $bank['ekr'])
			{
				if (mysql_query("UPDATE `users` SET `align` = '6' WHERE `id`= '".$user['id']."' LIMIT 1;")) {
					$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
					mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '15' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=96;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=15;
					$rec['sum_rep']=0;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����

					$mywarn="���������� ������� ���������.";
	       				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� ��������� ���������� �� <b>15</b> ���.<i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");

                   			$la=0;

					$last_aligh=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_last_align` WHERE `owner` = '".$user['id']."' LIMIT 1;"));   //��� ����� ������� �� ��������� ������
					if($last_aligh[id]>0)
					{
						$la=$last_aligh[align];
					}
					if($cheff['add_info']==3) //��� ������ ��� ����, �� �� ��������� ���.
					{
						$la=0;
					}

					if($la!=6 && !$cheff[id])
					{
						$sql="INSERT INTO oldbk.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','6');";
						//echo $sql;
						mysql_query($sql);
						$sql="INSERT INTO avalon.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','6');";
						mysql_query($sql);
						$sql="INSERT INTO angels.`effects`
						(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
						('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','6');";
						mysql_query($sql);
						//������ ���, ���������.
					}
				}
				else
				{
					$mywarn="��������� ������!";
				}
			}
			else {
				$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
			}
		 }
		 $_GET['setsklsvet']=0;
		}
		else
		{
		$mywarn="� ��� ��� ���� ���� ��� ����������!";
		}
	}

	elseif ($_POST[chlog])
	{
	 $chlogin='block';
	  if (isset($_POST[ch_newlog]))
	  	{
	  	$res = mysql_fetch_array(mysql_query("SELECT `id` FROM oldbk.`users` WHERE `login` = '".mysql_real_escape_string($_POST[ch_newlog])."'"));
	  	}
	 				if ($_POST[ch_newlog]==null) {
						$err.= "������� ��� ���������! ";
						$stop =1;
					}
					elseif ($res['id']!= null) {
						$err.= "� ��������� �������� � ����� ��� ���������������.";
						$stop =1;
					}
					elseif ( (strpos(strtoupper($_POST[ch_newlog]),strtoupper('klan'))  !== FALSE)  or(strpos(strtoupper($_POST[ch_newlog]),strtoupper("mklan")) !== FALSE))
					{
								$err.= "����������� ��������� � ����� ����� ���������! ";
								$stop =1;
					}

					elseif (strtoupper($_POST[ch_newlog])==strtoupper("���������") ||  strtoupper($_POST[ch_newlog])==strtoupper("��������") || strtoupper($_POST[ch_newlog])==strtoupper("�����������") || strtoupper($_POST[ch_newlog])==strtoupper("����������") || strtoupper($_POST[ch_newlog])==strtoupper("���������") || strtoupper($_POST[ch_newlog])==strtoupper("Merlin") || strtoupper($_POST[ch_newlog])==strtoupper("����������")) {
						$err.= "����������� ��������� � ����� ����� ���������! ";
						$stop =1;
					}
					elseif (strlen($_POST[ch_newlog])<4 || strlen($_POST[ch_newlog])>20 || !preg_match('~^[a-zA-Z�-��-�0-9-][a-zA-Z�-��-�0-9_ -]+[a-zA-Z�-��-�0-9-]$~i',$_POST[ch_newlog]) || preg_match("/__/",$_POST[ch_newlog]) || preg_match("/--/",$_POST[ch_newlog]) || preg_match("/  /",$_POST[ch_newlog]) || preg_match("/(.)\\1\\1\\1/",$_POST[ch_newlog]))
						{
						$err.= "<small>����� ����� ��������� �� 4 �� 20 ��������, � �������� ������ �� ���� �������� ��� ����������� ��������, ����, �������� '_',  '-' � �������. <br>����� �� ����� ���������� ��� ������������� �������� ��� �������� '_'.<br>����� � ������ �� ������ �������������� ������ ����� 1 ������� '_' ��� '-' � ����� 1 �������, � ����� ����� 3-� ������ ���������� ��������.!</small>";
						$stop =1;
					}
					elseif (preg_match('~[a-zA-Z]~i',$_POST[ch_newlog]) && preg_match('~[�-��-�]~i',$_POST[ch_newlog])) {
						$err.= "����� �� ����� ��������� ������������ ����� �������� � ���������� ���������!";
						$stop =1;
					}
	   if ($stop!=1)
	   	{
	   	///c ������� ���� ��� ����
	   	if (20 <= $bank['ekr']) {
				if (mysql_query("UPDATE oldbk.`users` SET `login` = '".mysql_real_escape_string($_POST[ch_newlog])."' WHERE `id`= '".$user['id']."' LIMIT 1;")) {

					$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
					mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '20' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
					//� ������ � ������� ��� ����
					mysql_query("UPDATE avalon.`users` SET `login` = '".mysql_real_escape_string($_POST[ch_newlog])."' WHERE `id`= '".$user['id']."' LIMIT 1;");
					mysql_query("UPDATE angels.`users` SET `login` = '".mysql_real_escape_string($_POST[ch_newlog])."' WHERE `id`= '".$user['id']."' LIMIT 1;");

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=97;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=20;
					$rec['sum_rep']=0;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']="\"".mysql_real_escape_string($_POST[ch_newlog])."\"" . "������ �� ".$bank_was[ekr]. " ����� " .$bank[ekr];

					add_to_new_delo($rec); //�����

					mysql_query("INSERT INTO oldbk.users_nick_hist SET uid='".$user[id]."' , old_login='".$user['login']."';");

					$mess=$user['login'].": ������ ���� ��� �� \"".mysql_real_escape_string($_POST[ch_newlog])."\" ����� ����.";
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$user['id']."','$mess','".time()."');");
					$mywarn="�������� ���������� �������!";
		       			mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� ������� ���� ��� �� \"".mysql_real_escape_string($_POST[ch_newlog])."\", �� <b>20</b> ���.<i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
				}
				else {
					$mywarn="��������� ������!";
				}
			}
			else {
				$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
			}
	   	}
	   	else
	   	{
	   	$mywarn=$err;
	   	}
	}
	elseif($_GET['dropsh']) {
		if (1 <= $bank['ekr']) {
			if (mysql_query("UPDATE `users` SET `shadow` = '0.gif' WHERE `id`= '".$user['id']."' LIMIT 1;"))
			{
				$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '1' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
				$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

												//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=44;//������ �����,
					$rec['sum_kr']=0;
					$rec['sum_ekr']=1;
					$rec['sum_rep']=0;
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
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����

				$mywarn="��� ������ ������. �� ������ ������� ����� ����� ���������.";
      				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� ������� ����� �� <b>1</b> ���.<i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");

			}
			else {
				$mywarn="��������� ������!";
			}
		}
		else {
			$mywarn="� ��� ������������ ����� �� �������� ����� ��� ���������� ��������";
		}
		$_GET['dropsh']=0;
	}
	/*
	elseif ($_GET[sellbill])
		{
	mysql_query("delete from oldbk.inventory where owner='{$user[id]}' and prototype=33333 and upfree!=(select id from oldbk.item_loto_ras where `status`=1)");
			$dkol=mysql_affected_rows();
			  if ($dkol>0)
			  {
					  //
					$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
 	 				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$dkol."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=45;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$dkol;
					$rec['sum_rep']=0;
					$rec['sum_kom']=0;
					$rec['item_id']='';
					$rec['item_name']='���������� �����';
					$rec['item_count']=$dkol;
					$rec['item_type']=0;
					$rec['item_cost']=2;
					$rec['item_dur']=0;
					$rec['item_maxdur']=0;
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����

					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� ����� ���������� ������ �� ����� <b>{$dkol}</b> ���. <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
					$mywarn="�� ����� ���������� ������ �� ����� <b>".$dkol." ���.</b> ";
			}
		}*/
	elseif ($_GET[tgold777771])
		{
	mysql_query("delete from oldbk.inventory where owner='{$user[id]}' and prototype=777771 and setsale=0 ");
					$dkol=mysql_affected_rows();
					  if ($dkol>0)
					  {
					$add_ekr_gold=$prise_gold[777771]*$dkol;
					$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
 	 				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$add_ekr_gold."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));


					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=46;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$add_ekr_gold;
					$rec['sum_rep']=0;
					$rec['sum_kom']=0;
					$rec['item_id']='';
					$rec['item_name']='������� ������ 1 ���';
					$rec['item_count']=$dkol;
					$rec['item_type']=50;
					$rec['item_cost']=1;
					$rec['item_dur']=0;
					$rec['item_maxdur']=0;
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����

					if (olddelo==1)
					{
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� \"������� ������ 1 ���\" (x".$dkol.")  �� ����� ".$add_ekr_gold." ���. ���� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
					}
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� \"������� ������ 1 ���\" (x".$dkol.") �� ����� <b>{$add_ekr_gold}</b> ���. <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
					$mywarn="�� �������� \"������� ������ 1 ���\" (x".$dkol.") �� ����� <b>".$add_ekr_gold." ���.</b> ";
					  }
		}
		elseif ($_GET[tgold777772])
		{
	mysql_query("delete from oldbk.inventory where owner='{$user[id]}' and prototype=777772 and setsale=0 ");
					$dkol=mysql_affected_rows();
					  if ($dkol>0)
					  {
					$add_ekr_gold=$prise_gold[777772]*$dkol;
 	 				$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
 	 				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$add_ekr_gold."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=46;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$add_ekr_gold;
					$rec['sum_rep']=0;
					$rec['sum_kom']=0;
					$rec['item_id']='';
					$rec['item_name']='������� ������ 10 ���';
					$rec['item_count']=$dkol;
					$rec['item_type']=50;
					$rec['item_cost']=1;
					$rec['item_dur']=0;
					$rec['item_maxdur']=0;
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����
					if (olddelo==1)
					{
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� \"������� ������ 10 ���\" (x".$dkol.")  �� ����� ".$add_ekr_gold." ���. ���� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
					}
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� \"������� ������ 10 ���\" (x".$dkol.") �� ����� <b>{$add_ekr_gold}</b> ���. <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
					$mywarn= "�� �������� \"������� ������ 10 ���\" (x".$dkol.") �� ����� <b>".$add_ekr_gold." ���.</b> ";
					  }
		}
	elseif ($_GET[tgold777773])
		{
	mysql_query("delete from oldbk.inventory where owner='{$user[id]}' and prototype=777773 and setsale=0 ");
					$dkol=mysql_affected_rows();
					  if ($dkol>0)
					  {
					$add_ekr_gold=$prise_gold[777773]*$dkol;
 	 				$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
 	 				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$add_ekr_gold."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=46;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$add_ekr_gold;
					$rec['sum_rep']=0;
					$rec['sum_kom']=0;
					$rec['item_id']='';
					$rec['item_name']='������� ������ 20 ���';
					$rec['item_count']=$dkol;
					$rec['item_type']=50;
					$rec['item_cost']=1;
					$rec['item_dur']=0;
					$rec['item_maxdur']=0;
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����
					if (olddelo==1)
					{
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� \"������� ������ 20 ���\" (x".$dkol.")  �� ����� ".$add_ekr_gold." ���. ���� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
					}
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� \"������� ������ 20 ���\" (x".$dkol.") �� ����� <b>{$add_ekr_gold}</b> ���. <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
					$mywarn= "�� �������� \"������� ������ 20 ���\" (x".$dkol.") �� ����� <b>".$add_ekr_gold." ���.</b> ";
					  }
		}
		elseif ($_GET[sertid])
		{
		$sertid=(int)($_GET[sertid]);
		if ($podar_prise[$sertid] > 0)
		  		{
					mysql_query("UPDATE oldbk.inventory SET unik=0 where owner='{$user[id]}' and prototype='{$sertid}' and  present!='' and unik=2 and setsale=0");
					$dkol=mysql_affected_rows();
					  if ($dkol>0)
					  {
					$add_ekr_pod=($podar_prise[$sertid]*$dkol);
 	 				$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
 	 				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$add_ekr_pod."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=46;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$add_ekr_pod;
					$rec['sum_rep']=0;
					$rec['sum_kom']=0;
					$rec['item_id']='';
					$rec['item_name']='���������� ���������� '.$podar_prise[$sertid].' ���';
					$rec['item_count']=$dkol;
					$rec['item_type']=200;
					$rec['item_cost']=$podar_prise[$sertid];
					$rec['item_dur']=0;
					$rec['item_maxdur']=0;
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����
					if (olddelo==1)
					{
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','�������� \"".$user['login']."\" ������� \"���������� ���������� {$podar_prise[$sertid]} ���\" (x".$dkol.")  �� ����� ".$add_ekr_pod." ���. ���� �".$_SESSION['bankid']." � �����. ',1,'".time()."');");
					}
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� \"���������� ���������� {$podar_prise[$sertid]} ���\" (x".$dkol.") �� ����� <b>{$add_ekr_pod}</b> ���. <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
					$mywarn="�� �������� \"���������� ���������� {$podar_prise[$sertid]} ���\" (x".$dkol.") �� ����� <b>".$add_ekr_pod." ���.</b> ";
					  }
			}
		}
		/*
		elseif (  ($_GET[kotid]) OR (($_GET['use']) and ($_GET[u]==1))   )
		{
				if (($_GET['use']) and ($_GET[u]==1))
				{
				$kotid=(int)($_GET['use']);
				}
				else
				{
				$kotid=(int)($_GET['kotid']);
				}

				if ($kotid > 0)
		  		{
		  		$sale_array=array_merge($vaucher, $dolla);
				$sertif=mysql_fetch_array(mysql_query("select * from oldbk.inventory where id='{$kotid}' and owner='{$user[id]}' and setsale=0 and (prototype in (".implode(",",$sale_array).") )   "));
				if ($sertif[id]>0)
				{
				mysql_query("DELETE from oldbk.inventory where id='{$sertif[id]}' ; ");
				if (mysql_affected_rows() >0)
				{
			 	 $kom=0;
			 	 $addtekr=round(($sertif[ecost]*((100-$kom)/100)),2);

 	 				$bank_was = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));
 	 				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".$addtekr."' WHERE `id`= ".$_SESSION['bankid']." LIMIT 1;");
					$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' ;"));

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=46;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$addtekr;
					$rec['sum_rep']=0;
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($sertif);
					$rec['item_name']=$sertif[name];
					$rec['item_count']=1;
					$rec['item_type']=$sertif[type];
					$rec['item_cost']=$sertif[cost];
					$rec['item_dur']=$sertif[duration];
					$rec['item_maxdur']=$sertif[maxdur];
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=$_SESSION['bankid'];
					$rec['add_info']='������ �� '.$bank_was[ekr]. ' ����� ' .$bank[ekr];
					add_to_new_delo($rec); //�����

					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','�� �������� \"{$sertif[name]}\" (x1) �� ����� <b>{$addtekr}</b> ���. <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
					$mywarn= "�� �������� \"{$sertif[name]}\" (x1) �� ����� <b>".$addtekr." ���.</b> ";
				}
				}
				}
		}
		elseif (($_GET['use']) and ($_GET[u]==2))
		{
			$kotid=(int)($_GET['use']);


				if ($kotid > 0)
		  		{

				$sertif=mysql_fetch_array(mysql_query("select * from oldbk.inventory where id='{$kotid}' and owner='{$user[id]}' and setsale=0 and (prototype in (".implode(",",$dolla).") )   "));
				if ($sertif[id]>0)
				{
				mysql_query("DELETE from oldbk.inventory where id='{$sertif[id]}' ; ");
				if (mysql_affected_rows() >0)
				{
			 	 $addrep=$sertif[ecost]*3000;

 	 				//��������� ����
					mysql_query("UPDATE `users` SET  `rep`=`rep`+'$addrep' , `repmoney` = `repmoney` + '$addrep' WHERE `id`= '".$user['id']."' LIMIT 1;");
					 if (mysql_affected_rows()>0)
					{
					//new_delo
					$rec=array();
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['owner_rep_do']=$user['repmoney'];
					$rec['owner_rep_posle']=($user['repmoney']+$addrep);
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=2260;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=0;
					$rec['sum_rep']=$addrep;
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($sertif);
					$rec['item_name']=$sertif[name];
					$rec['item_count']=1;
					$rec['item_type']=$sertif[type];
					$rec['item_cost']=$sertif[cost];
					$rec['item_dur']=$sertif[duration];
					$rec['item_maxdur']=$sertif[maxdur];
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']=$_SESSION['bankid'];
					add_to_new_delo($rec); //�����
					$mywarn= "�� �������� \"{$sertif[name]}\" (x1) ��  <b>".$addrep." ���������.</b> ";
					$user['repmoney']+=$addrep;
					}
				}
				}
				}
		}
	*/
	////////////////////////////����� ������� ������ + �����
	render_my_money();


		if ($mywarn) { echo "<br><font color=red><b>".$mywarn."</b></font>"; } else { echo ""; }
		echo "<center><table border=0 align=center> ";
		echo "<tr><td valign=top align=center>";

		echo "<fieldset style=\"text-align:justify; width:330px; height:100px;\"><legend>������� ������� ������</legend>";

				$gold_koll=mysql_query("select prototype, name, img , count(id) as kol  from oldbk.inventory  where owner='{$user[id]}' and setsale=0 and (prototype=777771 or prototype=777772 or prototype=777773) group by prototype");
				if (mysql_num_rows($gold_koll) == 0)
				{
				  echo '<small>� ��� ��� ������� ��� �������.</small>';
				}
				else
				{
				while ($gold_is = mysql_fetch_array($gold_koll))
					{

					  echo '<a href=?p=3&tgold'.$gold_is[prototype].'=yes><img src=http://i.oldbk.com/i/sh/'.$gold_is[img].' title="�������� '.$gold_is[kol].' ��. �� ����� '.($gold_is[kol]*$prise_gold[$gold_is[prototype]]).'  ���. " >';

					}
				}
			echo "</fieldset>";

		echo "</td>";
		echo "<td>";

		/*echo "<fieldset style=\"text-align:justify; width:330px; height:100px;\"><legend>������� ���������� ������</legend>";

				//����������� ���������� ������� ������� �������� ��� �������
				// ������ ����� ������� �������� � upfree � �� �� ����� �������� ��������
				$koll=mysql_fetch_array(mysql_query("select count(id) as kol, img from oldbk.inventory where owner='{$user[id]}' and prototype=33333 and upfree!=(select id from oldbk.item_loto_ras where `status`=1)"));
				if ($koll[0]>0)
						{
						  echo '<a href=?p=3&sellbill=yes><img src=http://i.oldbk.com/i/sh/'.$koll[img].' title="����� '.$koll[0].' �������  ��  '.$koll[0].' ���. " ></a>';
						}
						else
						{
						echo '<small>� ��� ��� ���������� ������� ��� �������.</small>';
						}
		echo "<br><small>����������� ������ �������� ������� ��� ���������.</small>
			</fieldset>";
	*/
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";

		echo "<fieldset style=\"text-align:justify; width:330px; min-height:110px;\"><legend>���������� ���������� �����������</legend>";

				$sertif_koll=mysql_query("select prototype, name, img , count(id) as kol  from oldbk.inventory where owner='{$user[id]}' and setsale=0 and (prototype in (200001,200002,200005,200010,200025,200050,200100,200250,200500) ) and present!='' and unik=2 group by prototype");
				if (mysql_num_rows($sertif_koll) == 0)
				{
				  echo '<small>� ��� ��� ���������� ������������.</small>';
				}
				else
				{
				while ($sertif_is = mysql_fetch_array($sertif_koll))
					{
					 echo '<a href=?p=3&sertid='.$sertif_is[prototype].'><img src=http://i.oldbk.com/i/sh/'.$sertif_is[img].'  title="���������� '.$sertif_is[kol].' ��. �� ����� '.($sertif_is[kol]*$podar_prise[$sertif_is[prototype]]).'  ���. " >';
					}
				}
		echo "</fieldset>";

		echo "</td>";
		echo "<td>";
/*
		echo "<fieldset style=\"text-align:justify; width:330px; min-height:110px;\"><legend>������� �������</legend>";


				$sertif_koll=mysql_query("select * from oldbk.inventory where owner='{$user[id]}' and setsale=0 and (prototype in (".implode(",",$vaucher ).") ) order by ecost  ");
				if (mysql_num_rows($sertif_koll) == 0)
				{
				  echo '<small>� ��� ��� �������� ��.</small>';
				}
				else
				{
			 	$kom=0;
				while ($sertif_is = mysql_fetch_array($sertif_koll))
					{
				 	 $print_cost=round(($sertif_is[ecost]*((100-$kom)/100)),2);
					 echo '<a href=?p=3&kotid='.$sertif_is[id].' ><img src=http://i.oldbk.com/i/sh/'.$sertif_is[img].' title="���������� ����� '.$print_cost.'  ���. "></a>';
					}
				}
		echo '<br>';
		echo "</fieldset>";
*/
		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>";


		echo "<fieldset style=\"text-align:justify; width:330px; height:110px;\"><legend>�������������� ������</legend><small>";
			echo "� <a href=\"#\" onclick=\"javascript:if (confirm('������������ ������?')){ location.href='bank.php?dropsh=1&p=3';}\">�������� ����� ��������� �� 1 ���.</a><BR>";


			/*
			if ($user['klan'] == '' && $user['align'] == 0)
			{
			if($cheff['time']>time() && $cheff['add_info']!=2) 	{ $ss1="<s>";$sse1="</s>"; }
			echo $ss1."� <a href=\"#\" onclick=\"javascript:if (confirm('������������ ������?')){ location.href='bank.php?setsklneytr=1&p=3';}\">�������� ����������� ���������� �� 15 ���.</a><BR>".$sse1;

			if($cheff['time']>time() && $cheff['add_info']!=3) 	{ $ss2="<s>";$sse2="</s>"; }
			echo $ss2."� <a href=\"#\" onclick=\"javascript:if (confirm('������������ ������?')){ location.href='bank.php?setskltemn=1&p=3';}\">�������� ������ ���������� �� 15 ���.</a><BR>".$sse2;

			if($cheff['time']>time() && $cheff['add_info']!=6) 	{ $ss3="<s>";$sse3="</s>"; }
			echo $ss3."� <a href=\"#\" onclick=\"javascript:if (confirm('������������ ������?')){ location.href='bank.php?setsklsvet=1&p=3';}\">�������� ������� ���������� �� 15 ���.</a><BR>".$sse3;
			}
			else
			{
			echo "<s>� <a href=\"#\">�������� ����������� ���������� �� 15 ���.</a><BR></s>";
			echo "<s>� <a href=\"#\">�������� ������ ���������� �� 15 ���.</a><BR></s>";
			echo "<s>� <a href=\"#\">�������� ������� ���������� �� 15 ���.</a><BR></s>";
			}
			*/

			if ($user['klan'] == '' && ($user['align'] == 2 || $user['align'] == 3  || $user['align'] == 6 || $user['align'] == 2.4))
			{
			echo "� <a href=\"#\" onclick=\"javascript:if (confirm('������������ ������?')){ location.href='bank.php?dropsk=1&p=3';}\">�������� ���������� �� 0 ���.</a><BR>";
			}
			 echo "<form method=post>";
			 echo "� <a href=\"#\" onclick=\"show('chlogin'); return(false);\"> ������� ��� �� 20 ���</a>";
			 echo "<div style=\"display: ".$chlogin.";\" id=\"chlogin\">";
			 echo "����� �����: <input type=text name=ch_newlog value='' size=20 maxlength=20 ><br>";
			 echo " <input type=submit name=chlog value='�������'><br><br>";
			 echo "</div></form>";
		echo "</fieldset></small>";

		echo "</td>";
		echo "<td>";

		/*
		echo "<fieldset style=\"text-align:justify; width:330px; height:110px;\"><legend>������������ �����</legend>";
		echo "<center>";
		echo "<small>������������ ����� ������������� ������ �� ��������� �������, ������ ��������, ���������� ��������, � �����, �������� ����������, �������������� �������, email � ��������� ������ ������������ ������.</small>";
		echo "<br><a href=http://oldbk.com/commerce/index.php?uid={$_SESSION['uid']}&alog={$_SESSION['sid']} target=_blank><img src=http://i.oldbk.com/i/bank/komm_butt.png title='������� � ������������ �����'></a>";
		echo "</center>";
		echo "</fieldset>";
		*/

/*
				echo "<fieldset style=\"text-align:justify; width:330px; min-height:110px;\"><legend>����� �������</legend>";

				$dolla=array(5001,5002,5003,5005,5010,5015,5020,5025);

				$sertif_koll=mysql_query("select * from oldbk.inventory where owner='{$user[id]}' and setsale=0 and (prototype in (".implode(",",$dolla ).") ) order by ecost  ");
				if (mysql_num_rows($sertif_koll) == 0)
				{
				  echo '<small>� ��� ��� ��������.</small>';
				}
				else
				{
			 	$kom=0;
				while ($sertif_is = mysql_fetch_array($sertif_koll))
					{
				 	 $print_cost=round(($sertif_is[ecost]*((100-$kom)/100)),2);
//					 echo '<a href=?p=3&kotid='.$sertif_is[id].' ><img src=http://i.oldbk.com/i/sh/'.$sertif_is[img].' title="����������"></a>';
					 echo  "<a href='#' onclick=\"";
					 echo "showitemschoice('�������� �� ��� ������ ��������:', 'dollars', 'bank.php?p=3&use=".$sertif_is['id']."');";
 					 echo '"><img src=http://i.oldbk.com/i/sh/'.$sertif_is[img].' title="����������"></a>';
					}
				}
		echo '<br>';
		echo "</fieldset>";
*/

		echo "</td>";
		echo "</tr>";
		echo "</table>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	else
	if ($page==4)
	{
	//��������� ����

	if (($_POST['changepsw']) and ($_SESSION['bankid']))
	{
		if ($_POST['oldpass'] && $_POST['npass'] && $_POST['npass2'])
		{
		$ops = mysql_fetch_array(mysql_query("SELECT `pass` FROM `oldbk`.`bank` WHERE  `owner` = '".$user['id']."' AND `id`= '".(int)($_SESSION['bankid'])."'"));
		if ($ops[0] == md5($_POST['oldpass']))
		{
			if($_POST['npass'] == $_POST['npass2'])
			{
				if(mysql_query("UPDATE `oldbk`.`bank` SET `pass` = '".md5($_POST['npass'])."' WHERE `owner` = '".$user['id']."' AND `id`= '".(int)($_SESSION['bankid'])."' LIMIT 1;"))
				{
					$mywarn= "������ ������ ������.";
				}
			}
			else
			{
			$mywarn="�� ��������� ����� ������.";
			}
		}
		else
		{
		$mywarn="�������� ������ ������."; }
		}
	}

	////////////////////////////����� ������� ������������ + �����
		/*
		if ($_POST['savedef'])
			{

				if (($_POST['setdef']) and ($bank['def']==0) )
					{
					//������ ��������
						//1. �������  �� ���� ������ �����
						mysql_query("UPDATE `oldbk`.`bank` SET `def`=0 WHERE `owner`='{$user['id']}' ");
						//2. ������ ���. �� �������
						mysql_query("UPDATE `oldbk`.`bank` SET `def`=1 WHERE `owner`='{$user['id']}' and id='{$bank['id']}' ");
						 if (mysql_affected_rows()>0)
						 	{
						 		$mesaga='<small>������� ���� ���������� ��� ��������!</small>';
						 		$bank['def']=1;
						 	}
					}
					elseif (($bank['def']>0) and (!($_POST['setdef'])) )
					{
					//������ ����� ���� ��� ���� ���� ��������
					mysql_query("UPDATE `oldbk`.`bank` SET `def`=0 WHERE `owner`='{$user['id']}' and id='{$bank['id']}' ");
					 if (mysql_affected_rows()>0)
						 	{
						 		$mesaga='<small>������� ���� �������� ���� ��������!</small>';
						 		$bank['def']=0;
						 	}
					}
			}
			*/

	render_my_money();

		if ($mywarn) { echo "<br><font color=red><b>".$mywarn."</b></font>"; } else { echo ""; }
		echo "<center><table border=0 align=center> ";
		echo "<tr><td valign=top align=center>";

	echo "<table border=0>";
	echo "<tr><td>";


	/*
	echo "<div align=left><form method=\"post\" >";
	if ($bank['def']>0) { $chk=" checked=\"checked\" "; }
	echo "<input type=\"checkbox\" name=\"setdef\" {$chk} /> ���������� ���� ����� <b>{$bank['id']}</b> �������� ";
	echo "<div class='btn-control' style='display:inline-block;'><input class='button-mid btn' type=\"submit\" name=savedef  value=\"�����������\" ></div>";
	*/

	echo $mesaga;
	echo "</form>";
	echo "</div>";

	echo "</td><td>";


		/*echo "<div align=left><form method=\"post\" name=delbankform>";
		echo "<input type=\"checkbox\" name=\"delbank\" id=\"delbank\" /> ������� ������� ���� ����� <b>{$bank['id']}</b>";
		echo " <div class='btn-control' style='display:inline-block;'><input class='button-mid btn' type=\"button\" name=savedel  value=\"�����������\" onclick=\"DelBanks()\" ></div>";
		echo "</form>";
		echo "</div>";
		*/

		/*
		echo "
		<script>
		function DelBanks()
		{
		 var x = document.getElementById(\"delbank\").checked;
		if (x)
		    	{
			if (confirm('�� ����� ������ ������� ������� ���� �{$bank['id']}?'))
		    	 	{
			    	document.delbankform.submit();
			    	}
		    	}
		    	else
		    	{
		    	alert('��� �������� ����� ���������� �������������!');
		    	}
		}
		</script>";
		*/

	echo "</td></tr>";


		echo "</table>";

		echo "<fieldset style=\"text-align:justify; width:750px; height:200px;max-height:200px;\"><legend>��������� ��������</legend>";

		echo "<center><table border=0 align=center>";
		echo "<tr><td>";

			$history = mysql_query("SELECT `date`,`text` FROM `oldbk`.`bankhistory` WHERE `bankid` = '{$_SESSION['bankid']}' ORDER BY date DESC ,id DESC LIMIT 10;");
			echo "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\">";
			while ($hist = mysql_fetch_array($history))
				{
				echo "<TR><TD><small><font class=date>".date('d-m-Y',$hist[date])."</font><font style=\"font-size: 7pt;\"> ".$hist[text]."</font></small></TD></TR>";
				}
		 echo "</TABLE>";
		echo "</td></tr></table></center><br>";
		 echo "</fieldset><br>";


 		echo "<fieldset style=\"text-align:justify; width:750px; height:110px;max-height:110px;\"><legend>������� ������ � ����� � <B>{$bank['id']}</legend>";
		 echo "<center>
				<form method=\"post\" >
				<table>
					<tr>
						<td align=right>������ ������:</td><td><input type=password name=\"oldpass\"></td>
					</tr>
					<tr>
						<td align=right>����� ������:</td><td><input type=password name=\"npass\"></td>
					</tr>
					<tr>
						<td align=right>����� ������ (��� ���):</td><td><input type=password name=\"npass2\"></td>
					</tr>
					<tr>
						<td align=right>
						    <div class='btn-control'>
						        <input class='button-mid btn' type=submit value=\"������� ������\" name=\"changepsw\">
                            </div>
                        </td><td></td>
					</tr>
				</table></form>
				<center>";
		 echo "</fieldset>";


		echo "</td>";
		echo "</tr>";
		echo "</table>";

		}

		else if ($page==5)
		{
		render_my_money();

		echo "<br><font color=red><b>������� �� ����������� �����...</b></font>";

		echo "<script>
			window.location.href='bank.php?exit=1&tmp=".(mt_rand(111111,999999))."';
			</script>";

		}
	else
	if (($page==6) )
	{
		if ($_SESSION['showinbox'] != $_GET['showinbox'])
			{
						$_SESSION['curp0']=0;
						$_SESSION['curp1']=0;
						$_SESSION['curp2']=0;
						$_SESSION['curp3']=0;
						$_SESSION['curp4']=0;
						$_SESSION['curp5']=0;
						$_SESSION['curp6']=0;
						$_SESSION['curp7']=0;
						$_SESSION['need_clear_curp']=true;
			}

		if (!isset($_SESSION['showinbox'])) $_SESSION['showinbox'] = 1;
		if (isset($_GET['showinbox'])) $_GET['showinbox'] = intval($_GET['showinbox']);
		if (isset($_GET['showinbox']) && $_GET['showinbox'] >= 0 && $_GET['showinbox'] <= 1) $_SESSION['showinbox'] = $_GET['showinbox'];

		$boxsize=clac_mybox();

		$boxlvl=$boxsize['box_level'];
		$next=array();
	 	$next=load_next_box_size($boxlvl,$bank);

		if (($_POST['getsize']==1) and ($next['ok']==true) )
			{
//			echo "������� ����� start";

				if ($next['krcost']>0)
					{
					if ($bank['cr']>=$next['krcost'])
					{
					//������� �� �����
						mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` - '".$next['krcost']."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
						if (mysql_affected_rows()>0)
							{
							$boxlvl++;
							mysql_query("INSERT INTO `oldbk`.`users_boxsize` SET `owner`='{$user['id']}',`boxlvl`='{$boxlvl}', `boxsize`='{$next['size']}'  ON DUPLICATE KEY UPDATE  `boxlvl`='{$boxlvl}', `boxsize`=`boxsize`+'{$next['size']}'; ");
							//new_delo
		  		    			$rec['owner']=$user['id'];
							$rec['owner_login']=$user['login'];
							$rec['owner_balans_do']=$user['money'];
							$rec['owner_balans_posle']=$user['money'];
							$rec['target']=0;
							$rec['target_login']='����';
							$rec['type']=2510;
							$rec['sum_kr']=$next['krcost'];
							$rec['sum_ekr']=0;
							$rec['bank_id']=$_SESSION['bankid'];
							$rec['add_info']='������ �� '.$bank['cr']. ' ��. ����� ' .($bank['cr']-$next['krcost']).' ��. ';
							$bank['cr']-=$next['krcost'];
							$boxsize['gsum']+=$next['size'];
							add_to_new_delo($rec); //�����
							mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','������� {$next['size']} ��. ����� ������� �� <b>{$next['krcost']} ��.</b>, �������� <b>0 ��.</b> <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
							$next=load_next_box_size($boxlvl,$bank);
							}
					}
					 else
						 {
					 	err('������������ ������� �� ���� �����! ����������, ��������� ������� ��� ������� � ������ ���������� ����, �� ������� ���� ���������� ������� ��� ������!');
						 }
					}
				else
					if ($next['ekrcost']>0)
					{
					//������� �� ���
					if ($bank['ekr']>=$next['ekrcost'])
						{
						mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '".$next['ekrcost']."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
						if (mysql_affected_rows()>0)
							{
							$boxlvl++;
							mysql_query("INSERT INTO `oldbk`.`users_boxsize` SET `owner`='{$user['id']}',`boxlvl`='{$boxlvl}', `boxsize`='{$next['size']}'  ON DUPLICATE KEY UPDATE  `boxlvl`='{$boxlvl}', `boxsize`=`boxsize`+'{$next['size']}'; ");
							//new_delo
		  		    			$rec['owner']=$user['id'];
							$rec['owner_login']=$user['login'];
							$rec['owner_balans_do']=$user['money'];
							$rec['owner_balans_posle']=$user['money'];
							$rec['target']=0;
							$rec['target_login']='����';
							$rec['type']=2520;//�������� ����
							$rec['sum_ekr']=$next['ekrcost'];
							$rec['sum_kr']=0;
							$rec['bank_id']=$_SESSION['bankid'];
							$rec['add_info']='������ �� '.$bank['ekr']. ' ���. ����� ' .($bank['ekr']-$next['ekrcost']).' ���. ';
							$bank['ekr']-=$next['ekrcost'];
							$boxsize['gsum']+=$next['size'];
							add_to_new_delo($rec); //�����
							mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','������� {$next['size']} ��. ����� ������� �� <b>{$next['ekrcost']} ���.</b>, �������� <b>0 ��.</b> <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");
							$next=load_next_box_size($boxlvl,$bank);
							}
						 }
						 else
						 {
					 	err('������������ ������� �� ���� �����! ����������, ��������� ������� ��� ������� � ������ ���������� ����, �� ������� ���� ���������� ������� ��� ������!');
						 }

					}


			}

	?>
	<script>
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
					url: "bank.php?p=6&showinbox=<?=$_SESSION['showinbox'];?>&invload2=1&prototype="+proto+"&id="+id+"&otdel="+otdel,
					cache: false,
					async: true,
					success: function(data){
						$("#id_"+proto).html(data);
					}
				});
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

			function showhide(id)
			{
				if (document.getElementById(id).style.display=="none")
				{document.getElementById(id).style.display="block";}
				else
				{document.getElementById(id).style.display="none";}
			}

		</script>

		<?
		//��������� ����
		if($_POST['ssave']==1)
			{
			 save_gruppovuha();
			}




		render_my_money();
		if ($mywarn) { echo "<br><font color=red><b>".$mywarn."</b></font>"; } else { echo ""; }
		echo "<center><table border=0 align=center width=\"100%\" > ";
		echo '<tr><td valign=top align=center style="background-color:#C7C7C7;" >
		<a '.($_SESSION['showinbox'] == 1 ? '' : 'style="font-weight:normal;"').' href="?p=6&showinbox=1"> �������� � ������� </a> | <a '.($_SESSION['showinbox'] == 0 ? '' : 'style="font-weight:normal;"').' href="?p=6&showinbox=0"> �������� � ��������� </a>
		</td>';
		echo "</tr>";
		echo "</table>";

			echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" id="sndbox">
				<tr>
				<td width="82%" valign=top>';

			if ($_SESSION['showinbox'] == 1)
			{
			///��� � �������
					if ((int)$_GET[item]>0)
				 	{
				 	$itm_id=(int)$_GET[item];
				 	//�������� �� �������
			 		$getitem = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory WHERE owner=488 AND arsenal_owner='{$user[id]}' and id='".$itm_id."'"));
			 		if ($getitem[id]>0)
				 			{
				 			//�������� �� �����
				 			mysql_query("UPDATE oldbk.inventory  SET owner='{$user[id]}', arsenal_owner=0  WHERE owner=488 AND arsenal_owner='{$user[id]}' and id='".$itm_id."'");
							$boxsize['massa']-=$getitem['massa'];
				 			}
				 	}
					elseif ((int)$_GET[grp]>0)
					{
					$grp_id=(int)$_GET[grp];
				 	//�������� �� ������� - ������
				 		//���� �������� �� ����� � �����
				 		$getitem = mysql_fetch_array(mysql_query("SELECT count(id) as kol, sum(massa) as massa   FROM oldbk.inventory WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."'"));
				 		 if ($getitem[kol]>0)
				 		 	{
				 			mysql_query("UPDATE oldbk.inventory  SET owner='{$user[id]}', arsenal_owner=0  WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."'");
				 			$boxsize['massa']-=$getitem['massa'];
				 		 	}
					}
					elseif (((int)$_POST['set']>0) and ((int)$_POST['count']>0))
					{
					$grp_id=(int)$_POST['set'];
					$put_kol=(int)$_POST['count'];
				 	//�������� �� ������� - ������  �������������
				 		//���� �������� �� ����� � �����
				 		$getitem = mysql_fetch_array(mysql_query("SELECT count(*) as kol,sum(massa) as massa  FROM ( SELECT massa  FROM  oldbk.inventory WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."' limit ".$put_kol." ) AS subquery;"));
//echo "SELECT count(*) as kol,sum(massa) as massa  FROM ( SELECT massa  FROM  oldbk.inventory WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."' limit ".$put_kol." ) AS subquery;";
//echo "<br>";
				 		 if ($getitem[kol]==$put_kol)
				 		 	{
//echo "UPDATE oldbk.inventory SET owner='{$user[id]}', arsenal_owner=0  WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."' LIMIT ".$put_kol ;
				 			mysql_query("UPDATE oldbk.inventory  SET owner='{$user[id]}', arsenal_owner=0  WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."' LIMIT ".$put_kol);
				 			$boxsize['massa']-=$getitem['massa'];
				 		 	}
				 		 	else
				 		 	{
				 		 	err('<b>� ��� ��� ������ ����������!</b><br>');
				 		 	}
					}
				//�����
				print_inv_items(1);
			}
			else
				{
				/// �������� � ���������
						if (((int)$_GET[item])>0)
						{
					 	$itm_id=(int)$_GET[item];
						//������ � �������
						//$boxsize=clac_mybox();
						 if ($boxsize['massa']<$boxsize['gsum'])
						 	{
					 		//���� �������
					 		$getitem = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND type not in (99,555,556,77) and present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0 AND (`prototype` < 15551 or `prototype` > 15568)  AND `labflag` = 0 AND `can_drop` = 1 AND `labonly`=0 AND (cost>0 OR ecost>0 OR repcost>0  )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and id='".$itm_id."'"));
					 		if ($getitem[id]>0)
					 			{
					 				if($getitem[add_pick]!='')
					 				{
									undress_img($getitem);
									}

					 			mysql_query("UPDATE oldbk.inventory SET owner=488, arsenal_owner='{$user[id]}'  WHERE owner='{$user[id]}' and id='".$itm_id."'");
					 			$boxsize['massa']+=$getitem['massa'];
					 			}


					 		}
					 		else
					 		{
					 		err('<b>������ ��������� �����!</b><br>');
					 		}

						}
						elseif (((int)$_GET[grp])>0)
						{
					 	$grp_id=(int)$_GET[grp];
							//������ � ������� ������
							//���� ��������
				 			$getitem = mysql_fetch_array(mysql_query("SELECT count(id) as kol, sum(massa) as massa  FROM oldbk.`inventory` WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND type not in (99,555,556,77)  AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND (`prototype` < 15551 or `prototype` > 15568) AND `labflag` = 0 AND `can_drop` = 1 AND `labonly`=0 AND  (cost>0 OR ecost>0 OR repcost>0 )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and prototype='".$grp_id."'"));
						 		if ($getitem[kol]>0)
								 		{
										 if (($boxsize['massa']+$getitem['massa']) <$boxsize[gsum])
										 	{
								 			mysql_query("UPDATE `oldbk`.`inventory` SET owner=488, arsenal_owner='{$user[id]}'  WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `can_drop` = 1 AND `labonly`=0 AND  (cost>0 OR ecost>0 OR repcost>0  )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and prototype='".$grp_id."'");
									 		$boxsize['massa']+=$getitem['massa'];
									 		}
									 		else
									 		{
									 		err('<b>��� �������� �� ���������� � ������!</b><br>');
									 		}
									 	}

						}
						elseif (((int)$_POST['set']>0) and ((int)$_POST['count']>0))
						{
						$grp_id=(int)$_POST['set'];
						$put_kol=(int)$_POST['count'];
							//������ � ������� ������
							//���� ��������
				 			$getitem = mysql_fetch_array(mysql_query("SELECT count(*) as kol,sum(massa) as massa  FROM ( SELECT massa  FROM oldbk.`inventory` WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND type not in (99,555,556,77)  AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND (`prototype` < 15551 or `prototype` > 15568) AND `labflag` = 0 AND `can_drop` = 1 AND `labonly`=0 AND  (cost>0 OR ecost>0 OR repcost>0 )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and prototype='".$grp_id."' limit ".$put_kol." ) AS subquery;"));

						 		if ($getitem[kol]==$put_kol)
								 		{
										 if (($boxsize['massa']+$getitem['massa']) < $boxsize[gsum])
										 	{

								 			mysql_query("UPDATE oldbk.inventory SET owner=488, arsenal_owner='{$user[id]}'  WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `can_drop` = 1 AND `labonly`=0 AND  (cost>0 OR ecost>0 OR repcost>0  )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and prototype='".$grp_id."' LIMIT ".$put_kol);

									 		$boxsize['massa']+=$getitem['massa'];
									 		}
									 		else
									 		{
									 		err('<b>��� �������� �� ���������� � ������!</b><br>');
									 		}
									 	}
									 	else
								 		 	{
								 		 	err('<b>� ��� ��� ������ ����������!</b><br>');
								 		 	}

						}
					//�����
					print_inv_items($inbox=0);
				}



			$my_massa=0;
			$q = mysql_query("SELECT IFNULL(sum(`massa`),0) as massa , setsale, bs_owner, dressed  FROM oldbk.inventory WHERE `owner` = '{$user['id']}'   GROUP by setsale,bs_owner,dressed ");
			while ($row = mysql_fetch_array($q))
					{
						if (($user['in_tower'] == $row['bs_owner']) AND   ($row['setsale'] ==0 )  AND   ($row['dressed'] ==0))
						{
							$my_massa+=$row['massa'];
						}
					}

			echo '	</td>
			<td width=18%" valign=top style="padding-left:10px;font-family: Tahoma;font-size: 13px; background-color:#C7C7C7;" >
			<strong>��� ���������:</strong><br>';
			echo " ������: ".$my_massa."/".get_meshok()."<br>";
			echo " ������: {$boxsize['massa']}/{$boxsize['gsum']} <br><br>";
			echo "<form method=POST name=fgetsize action=\"?p=6&showinbox={$_SESSION['showinbox']}\" '>";
			echo "<input type=hidden name=getsize value=1>";
			echo "<strong>��������� ����������� �������:</strong><br><a href=# ";
				if ($next['ok'])
				{
				echo "onclick=\"if(confirm('��������� ����������� ������� �� {$next['size']} ��.  �� ".(isset($next['krcost'])?$next['krcost']."��.":"").(isset($next['ekrcost'])?$next['ekrcost']."e��.":"")."? ')) { document.fgetsize.submit(); 	;}\"";
				}
				else
				{
				echo " onclick=\"alert('������������ ������� �� ���� �����! ����������, ��������� ������� ��� ������� � ������ ���������� ����, �� ������� ���� ���������� ������� ��� ������!')\" ";
				}

			echo ">  {$next['size']} ��.  �� ".(isset($next['krcost'])?$next['krcost']."��.":"").(isset($next['ekrcost'])?$next['ekrcost']."e��.":"")."</a>" ;

				if ($next['ok']==false)
				{
				echo "<br><font color=red><small>������������ ������� �� ���� �����.</small></font>";
				}
			echo "</form>";
			echo '</td>
			</tr>
			</table>';

		}





			?>

				</td>
				<td  width=2% >&nbsp;</td>

				</tr>
				</table>


	</td>
	</tr>
	</table>

</td>
</tr>
	<tr>
	<td height="28"  background="http://i.oldbk.com/i/bank/frame_down.jpg">&nbsp;</td>
	</tr>
</table>

</td>
    <td width="80" height="<?=$lsize[$page];?>" id=lsize2 valign="top" background="http://i.oldbk.com/i/bank/right_bg.jpg">

	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr valign=top>
		<td>
		<img src="http://i.oldbk.com/i/bank/right_top.jpg" alt="" width="80" height="51">

		</td>
	</tr>
	<tr valign=bottom>
		<td>

		<img src="http://i.oldbk.com/i/bank/right_down.jpg" width="80" height="157">
		</td>
	</tr>
	</table>

</td>
  </tr>
</table>
</center>

	<?
	if ($page==6)
		{
		echo "
		<script>
		var hh = $('#lsize').css('height');
		document.getElementById(\"lsize\").style.height=hh;
		document.getElementById(\"lsize2\").style.height=hh;
		</script>";
		}
	}
	else
	{
	//������� ����� � ����
	?>
	<center>
	<table width="1130" border="0" cellspacing="0" cellpadding="0" align="center"  style="background-image:url('http://i.oldbk.com/i/bank/bank_enter_bg.jpg');background-repeat:no-repeat;" >
	<tr>
		<td colspan=3 height="30" >
		</td>
	</tr>
	<tr>
	<td width="200" >&nbsp;</td>
	<td height="523"  valign=top >
	<?
	if($my_err) { echo "<font color=red><b>".$my_err."</b></font>"; }


//�� �������������
	if ($_POST['resendmail'])
	{
	$newpass=md5(md5(math.rand(-2000000,2000000).$user['login']));
	$newpass=substr($newpass,0,10);
	$lasttime=mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
	$ipclient= $_SERVER['REMOTE_ADDR'];
	$testid=mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `owner` = '".$user['id']."' AND `id`= '".$_POST['id']."' "));

	if ($user['email']=='')
	{
	echo "<font color='red'><b>������! � ��� �� ���������� email!</b></font>";
	}
	else
	if ($testid[0]==(int)($_POST['id']))
		{
		if (mysql_query("insert into `oldbk`.confirmpasswd_bank(login,owner,bank,passwd,date,ip,active) values('".$user['login']."','".$user['id']."','".(int)($_POST['id'])."','".$newpass."','".$lasttime."','".$ipclient."',1)"))
			{
			$aa='<html>
				<head>
					<title>�������������� ������</title>
				</head>
				<body>
					������ ���� '.$user['realname'].'.<br>
					���� ���� ��������� �������������� ������ ��� ����� '.$_POST['id'].' c IP ������ - '.$ipclient.', ���� ��� ���� �� ��, ������ ������� ��� ������.<br>
					<br>
					<br>
					<h3>��� ������������� ������ ������ �������� �� ������ ����.</h3><br>
					<a href="http://capitalcity.oldbk.com/confpassbank.php?newpass='.$newpass.'&id='.$user['id'].'&flag=1&timev='.$lasttime.'">�������������� ������</a>
					<br>
					------------------------------------------------------------------<br>
					��� � �����  | '.(int)($_POST['id']).'<br>
					����� ������ | '.$newpass.'<br>
					------------------------------------------------------------------<br>
					<br>
					<font color="blue">���� �� �� ������������ ������ �� <b>'.date("d-M-Y", $lasttime) .' 00:00</b>, ������ ����� ����������.</font>
					<br>
					�������� �� ������ ������ �� �����.
				</body>
			</html>';
			mailnew($user['email'],"�������������� ����������� ����� �� oldbk.com, ��� ������������ - ".$user['login'],$aa,true);

			$parts=explode('@',$user['email']);
			$ppp='�';
			 if (strlen($parts[0])>4) {  for ($i=4;$i<=strlen($parts[0]);$i++) { $ppp.='�'; } }
			$hidden_mail=$parts[0][0].$parts[0][1].$parts[0][2].$ppp."@".$parts[1];

			echo "<font color='red' ><b>�� ����� {$hidden_mail} ���������� ������, ���������� ������ ��� ������������� ������.</b></font>";
			//die();
			}
		else
			{
			echo "<font color='red'><b>������� ������ ��� ���������. <br>��������� �����</b></font>";
			//die();
			}
		}
		else
		{
		echo "<font color='red' ><b><h3>� ��� ��� ������ �����. <br> :(</b></font>";
		//die();
		}
	}
	else
	if($_POST['reg'] && $_POST['rpass'] && $_POST['rpass2'])
	{

		$test_banks = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `owner` = '".$user['id']."' limit 1;"));
		if ($test_banks['id']>0)
		{
			$mywarn='� ��� ��� ���� ���������� ����!';
		}
		else
		if ($_POST['rpass'] == $_POST['rpass2']) {
			if ($user['money'] >= 0.5) {
				$anddfs=0;
				$banks = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE owner='{$user['id']}' and def=1 limit 1;"));
				if (!($banks['id']>0))
					{
					$anddfs=1;
					}
				if(mysql_query("INSERT INTO `oldbk`.`bank` (`pass`,`owner` , `def`  ) values ('".md5($_POST['rpass2'])."','".$user['id']."', '".$anddfs."' );")) {
					$sh_num=mysql_insert_id();
					err('��� ����� �����: '.mysql_insert_id().', ��������.');
					mysql_query("UPDATE users SET money = money-0.5 WHERE id = '".$user['id']."' LIMIT 1;");

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money']-0.5;
					$rec['target']=0;
					$rec['target_login']='����';
					$rec['type']=24;//������ ����
					$rec['sum_kr']=0.5;
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
					$rec['bank_id']=$sh_num;
					add_to_new_delo($rec); //�����

					if (olddelo==1)
					{
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" ������ ���� �".$sh_num." � �����. ',1,'".time()."');");
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','\"".$user['login']."\" �������� �� �������� ����� � �����  0.5 ��. ',1,'".time()."');");
					}
				}
				else {
					$mywarn='����������� ������';
				}
			} else {
				$mywarn='������������ �����';
			}
		} else {
			$mywarn='�� ��������� ������';
		}
	}

	echo '<table width=100% border=0>	';

		$test_banks = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `owner` = '".$user['id']."' limit 1;"));
		if ($test_banks['id']>0)
		{

		}
		else
		{

?>
	<tr valign=top align=left>
		<td ><br>
		<form method=post >
		<h2>������� ����� ����</h2>
			<table border=0>
				<tr>
					<td colspan=2>��������� <b>0.5</b> ��.</td>
				</tr>
				<tr>
					<td>������</td>
					<td><input type=password name=rpass></td>
				</tr>
				<tr>
					<td>��� ���</td>
					<td><input type=password name=rpass2></td>
				</tr>
				<tr>
					<td colspan=2>
                        <div class="btn-control">
                            <input class="button-mid btn" type=submit name='reg' value='������� ����'>
                        </div>
                    </td>
				</tr>
		</table>
		</form>
	</td>
	</tr>
	<?
	}
	?>

	<tr valign=top align=left>
	<td >
		<form method=post action='bank.php'>
			<h2>����� � ���� </h2>
			<table border=0>
				<tr>
					<td>
					�<? inschet($user['id']); ?>
					<BR>������ <input type=password name=pass size=21>
					<BR>
					<input type=hidden name='enter' value='1'>
					</td>
				</tr>
				<tr>
					<td align=center>
                        <div class="btn-control">
                            <input class="button-mid btn" type=submit name='enter' value='�����'>
                        </div>
					</td>
				</tr>

			</table>
			</form>
	</td>
	</tr>

	<tr valign=top align=left>
	<td >
			<form method="post" >
			<h2>������������ ������</H2>
			<table border=0>
			<tr>
					<td>
					�������� ����:<br>
					<?php inschet($user['id']); ?><br>
					</td>
			</tr>
			<tr>
					<td align=center>
                        <div class="btn-control">
                            <input class="button-mid btn" type="submit" name="resendmail" value="������������">
                        </div>
					</td>
			</tr>
					<td>
					<small>��� ����� ������� ������ �� email, <br>��������� ��� �����������, <br>� ����� �������.</small></form>
					</td>
			</tr>
			</table>
			</form>
	</td>
	</tr>
	</table>
</td>
	<?
	 if ($user['room'] == 29)  { echo "<td width=\"230\"  valign=top><br><div class='btn-control'><input class='button-mid btn' type=button value='���������' onClick=\"returned2('strah=1&');\"></div></td>"; }
	 else
	 	{
	 	echo "<td width=\"230\"  valign=top><br><div class='btn-control'><input class='button-mid btn' type=button value='���������' onClick=\"location.href='main.php';\"></div></td>";
	 	}
	?>

</tr>
</table>
<?
}







session_write_close();
?>


<br><div align=left>
			<!--LiveInternet counter--><script type="text/javascript"><!--
			document.write("<a href='http://www.liveinternet.ru/click' "+
			"target=_blank><img style='float:left; ' src='http://counter.yadro.ru/hit?t54.2;r"+
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
d.write('<a href="http://top.mail.ru/jump?from=1765367" target="_top">'+
'<img src="http://df.ce.ba.a1.top.mail.ru/counter?id=1765367;t=49;js='+js+
a+';rand='+Math.random()+'" alt="�������@Mail.ru" border="0" '+
'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_top" href="http://top.mail.ru/jump?from=1765367">
<img src="http://df.ce.ba.a1.top.mail.ru/counter?js=na;id=1765367;t=49"
height="31" width="88" border="0" alt="�������@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script><div>
</body>
</html>
