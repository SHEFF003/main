<?

function getcheck_auto_get($telo)
{
 	if (!(isset($_SESSION['active_passkill_lab'])))
 	{
 	//�� ������������ ���������� ��������� ������ ��
	$_SESSION['active_passkill_lab']=0;

 	$naems=mysql_query("select * from users_clons where owner='{$telo['id']}' ");

		   	while ($naem = mysql_fetch_array($naems))
		   	{

					if ($naem['passkills']!='')
									{
										$paskill=unserialize($naem['passkills']);
										if ($paskill[20003]['active']==1)
											{
											$_SESSION['active_passkill_lab']=1;
											break;
											}
									}
		   	}
 	}

return $_SESSION['active_passkill_lab'];
}



function getcheck_auto_get_zag($telo)
{
 	if (!(isset($_SESSION['active_passkill_zag'])))
 	{
 	//�� ������������ ���������� ��������� ������ ��
	$_SESSION['active_passkill_zag']=0;

 	$naems=mysql_query("select * from users_clons where owner='{$telo['id']}' ");

		   	while ($naem = mysql_fetch_array($naems))
		   	{

					if ($naem['passkills']!='')
									{
										$paskill=unserialize($naem['passkills']);
										if ($paskill[20004]['active']==1)
											{
											$_SESSION['active_passkill_zag']=1;
											break;
											}
									}
		   	}
 	}

return $_SESSION['active_passkill_zag'];
}


function getcheck_mymass($telo)
{
 	if (!(isset($_SESSION['active_passkill_massa'])))
 	{
 	//�� ������������ ���������� ��������� ������ ��
 	$_SESSION['active_passkill_massa']=0;
 		$naems=mysql_query("select * from users_clons where owner='{$telo['id']}' ");

		   	while ($naem = mysql_fetch_array($naems))
		   	{

					if ($naem['passkills']!='')
									{
										$paskill=unserialize($naem['passkills']);
										if ($paskill[20002]['active']==1)
											{
											$_SESSION['active_passkill_massa']=round($paskill[20002]['procent']);
											//break;
											}
									}
		   	}
 	}

return $_SESSION['active_passkill_massa'];
}

function getcheck_mygoto($telo)
{
 	if (!(isset($_SESSION['active_passkill_goto'])))
 	{
 	//�� ������������ ���������� ��������� ������ ��
 	$_SESSION['active_passkill_goto']=0;
 		$naems=mysql_query("select * from users_clons where owner='{$telo['id']}' ");

		   	while ($naem = mysql_fetch_array($naems))
		   	{

					if ($naem['passkills']!='')
									{
										$paskill=unserialize($naem['passkills']);
										if ($paskill[20001]['active']==1)
											{
											$_SESSION['active_passkill_goto']=round($naem['level']);
											break;
											}
									}
		   	}
 	}

return $_SESSION['active_passkill_goto'];
}

function uubon($uu)
{
$arr=array();
		if ($uu>=13) { $arr['txt']='��������  ��� ��.+8%';  $arr[0]='8'; $arr['img']='http://i.oldbk.com/i/sunic_bonus3.gif'; $arr['name']='����������� ���������� �����: ('.$uu.'/13 ����. �����)'; $arr['url']='http://oldbk.com/encicl/?/legendkv.html';  $arr['u']=24; }
	elseif ($uu>=12) { $arr['txt']='��������  ��� ��.+6%';  $arr[0]='6'; $arr['img']='http://i.oldbk.com/i/sunic_bonus2.gif'; $arr['name']='����������� ������� �����: ('.$uu.'/12 ����. �����)'; $arr['url']='http://oldbk.com/encicl/?/legendkv.html'; $arr['u']=23; }
	elseif ($uu>=9) { $arr['txt']='��������  ��� ��.+4%';  $arr[0]='4'; $arr['img']='http://i.oldbk.com/i/sunic_bonus1.gif'; $arr['name']='����������� ����������� �����: ('.$uu.'/9 ����. �����)'; $arr['url']='http://oldbk.com/encicl/?/legendkv.html'; $arr['u']=22; }
	elseif ($uu>=6) { $arr['txt']='��������  ��� ��.+2%';  $arr[0]='2'; $arr['img']='http://i.oldbk.com/i/sunic_bonus0.gif'; $arr['name']='����������� ��������� �����: ('.$uu.'/6 ����. �����)'; $arr['url']='http://oldbk.com/encicl/?/legendkv.html'; $arr['u']=21; }
return $arr;
}

function ubon($u)
{
$arr=array();
	if ($u>=13) { $arr['txt']='��������  ��� ��.+4%';  $arr[0]='4'; $arr['img']='http://i.oldbk.com/i/unic_bonus4.gif'; $arr['name']='���������� �����: ('.$u.'/13 ����. �����)'; $arr['url']='http://oldbk.com/encicl/?/geroickv.html'; $arr['u']=4; }
	elseif ($u>=12) { $arr['txt']='��������  ��� ��.+3%';  $arr[0]='3'; $arr['img']='http://i.oldbk.com/i/unic_bonus3.gif'; $arr['name']='������� �����: ('.$u.'/12 ����. �����)'; $arr['url']='http://oldbk.com/encicl/?/geroickv.html'; $arr['u']=3; }
	elseif ($u>=9) { $arr['txt']='��������  ��� ��.+2%';  $arr[0]='2'; $arr['img']='http://i.oldbk.com/i/unic_bonus2.gif'; $arr['name']='����������� �����: ('.$u.'/9 ����. �����)';$arr['url']='http://oldbk.com/encicl/?/geroickv.html'; $arr['u']=2; }
	elseif ($u>=6) { $arr['txt']='��������  ��� ��.+1%';  $arr[0]='1'; $arr['img']='http://i.oldbk.com/i/unic_bonus1.gif'; $arr['name']='��������� �����: ('.$u.'/6 ����. �����)'; $arr['url']='http://oldbk.com/encicl/?/geroickv.html'; $arr['u']=1;  }
return $arr;
}

function get_unik_bonus_data($u,$uu)
{
//���������� ����� ����� ���� ��� ����� ����
	if (($u+$uu)>=6 )
	{
		if ($uu>$u)
			{
				if ($u<=6) {$ux=$u+$uu; } else { $ux=$u;}
				$uub=uubon($uu);
				$ub=ubon($ux);

				if ($uub[0]>=$ub[0])
					{
						return $uub;
					}
				else
					{
						return $ub;
					}
			}
			else
					{
						$ub=ubon($u+$uu);
						return $ub;
					}
	}
return false;
}

function look_uubonus_table()
{
//����� ��� ���������� ������� ������� ��� �������
	echo "<table border=1>";
	for($u=0;$u<=13;$u++)
		{
		echo "<tr>";
			for($uu=0;$uu<=13;$uu++)
				{
					if ( (($u+$uu)>=6 ) and ( ($u+$uu)<= 13 ) )
						{
								if ($uu>$u)
								{
									if ($u<=6) {$ux=$u+$uu; } else { $ux=$u;}
									$uub=uubon($uu);
									$ub=ubon($ux);
									echo "<td>";
										if ($uub[0]>=$ub[0])
										{
										echo "$u | $uu = {$uub['txt']}  ";
										}
										else
										{
										echo "$u | $uu = {$ub['txt']} ";
										}
									echo "</td>";
								}
								else
								{
									$ub=ubon($u+$uu);
									echo "<td>";
									echo "$u | $uu = {$ub['txt']}  ";
									echo "</td>";
								}
						}
					else
						{
						echo "<td>$u | $uu ----</td> ";
						}
				}
		echo "</tr>\n";
		}
	echo "</table>";
}

function link_for_magic($gif,$name)
{
$out='<a href="http://oldbk.com/encicl/?/mag1/'.str_replace('.gif','.html',$gif).'" target=_blank>'.$name.'</a>';
return $out;
}

function link_for_item($row,$retpath = false)
{

$ehtml = str_replace('.gif','',$row['img']);

	$razdel=array(
		1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
		24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun", 61=>'eda' , 72 =>''
	);

	$row['otdel'] == '' ? $xx = $row['razdel'] : $xx = $row['otdel'];

	if ($row['type']==30)
	{
		$razdel[$xx]="runs/".$ehtml;
	} elseif($razdel[$xx] == '')
	{
            	$dola = array(5001,5002,5003,5005,5010,5015,5020,5025);
		if (in_array($row['prototype'],$vau4))
		{
			$razdel[$xx]='vaucher';
		} elseif (in_array($row['prototype'],$dola))
		{
			$razdel[$xx]='earning';
		} else
		{
			$oskol=array(15551,15552,15553,15554,15555,15556,15557,15558,15561,15562,15568,15563,15564,15565,15566,15567);
			if (in_array($row['prototype'],$oskol)) {
				$razdel[$xx]="amun/".$ehtml;
			} else {
				$razdel[$xx]='predmeti/'.$ehtml;
			}
		}
	} else
	{
		$razdel[$xx]=$razdel[$xx]."/".$ehtml;

	}

	if (($row['art_param'] != '') and ($row['type']!=30))
	{
		if ($row['arsenal_klan'] != '')
		{
			// ��������
			$razdel[$xx]='art_clan';
		} elseif ($row['sowner'] != 0) {
				//������
			$razdel[$xx]='art_pers';
		}
	}

	if ($retpath) return $razdel[$xx];

	$out= "<a href=http://oldbk.com/encicl/".$razdel[$xx].".html target=_blank>".$row['name']."</a>";
	return $out;
}

function  link_for_user($telo)
{
	$out = "<a onclick=\"top.AddTo(document.getElementById(String.fromCharCode(99)+{$telo['id']}).innerHTML, event);\"><span id=\"c{$telo['id']}\" oncontextmenu=\"return OpenMenu(event, ".$telo['level'].")\">".$telo['login']."</span></a>";
//$out="<a onclick=\"top.AddTo(\'{$telo[login]}\',event);\"><span oncontextmenu=\'return OpenMenu(event,".$telo['level'].")\'>{$telo['login']}</span></a>";
return $out;
}

function search_arr_in_arr($s_arr,$in_arr)
{
//����� ��������� ������ � ������
	foreach($s_arr as $k=>$v)
		{
			if(in_array($v, $in_arr)) return true;
		}
return false;
}

function return_lot_from_exchange($lotid)
{
$err=0;
//������� ���� � �����
				$cancel_id=(int)$lotid;
				if ($cancel_id>0)
						{
						mysql_query('START TRANSACTION') or die();
						$q=mysql_query("SELECT * from  oldbk.exchange where id='{$cancel_id}' FOR UPDATE") or die();
						$lookid=mysql_fetch_assoc($q);
						if ($lookid['id']==$cancel_id)
							{
							$telo=mysql_fetch_assoc(mysql_query("select * from users where id='{$lookid['owner']}' "));
							$bank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = ".$lookid['bankid']."  and owner='".$telo['id']."' "));
							//������� ����� � ����
							mysql_query("DELETE from oldbk.exchange where id='{$cancel_id}' and owner='{$telo['id']}' ");
							mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '{$lookid['summ']}' WHERE `id`= '{$lookid['bankid']}' and owner='{$telo['id']}' ");
							//  ����� � ������� �����
							mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','������� ���� � ����� <b>{$lookid['summ']} ���.</b>, �������� <b>0 ��.</b> <i>(�����: ".($bank['cr'])." ��., ".($bank['ekr']+$lookid['summ'])." ���.)</i>','{$bank['id']}');");
							//����� � ��� ��������� �������
							mysql_query("UPDATE `oldbk`.`exchange_log` SET `sellekr`=`sellekr`-{$lookid['summ']}  WHERE `owner`={$telo['id']} ");
							//$center .='<font color=red>������ ������ ��������!</font><br>';
							telepost_new($telo,'<font color=red>��������!</font> ���������� �������������� ������� ���� � ����� <b>'.$lookid['summ'].' ���.</b>. �� ���� �'.$lookid['bankid'].'.');
							}
							else
							{
							$err=1;
							}
						mysql_query('COMMIT') or die();
						}

if ($err==0) return true;

return false;
}

function render_item_row($row,$online,$short=false,$dilinf=false)
{

	global $city_name,$rooms;

	$kl_status='';

	if ($short!=true)
		{
				if ($row['klan']!='')
				{
					$kl_status=strip_tags($row['status']);
				}
		}

	if ($online==1)
	{

		$outstring='<tr class="item-row">
	                    <td class="row-left">';

		$outstring.='<i class="icon private"><A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress); return false;"><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A></i>';
		$outstring.=nick_hist($row,$dilinf).'&nbsp;';
		$outstring.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
		$outstring.=($row['battle']>0?'<a target=_blank href=http://'.($city_name[$row[id_city]]).'.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
		$outstring.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'');

		if ($short!=true)
		{
		if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
		elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
		elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }
		elseif ($row['ruines'] > 0) { $rrm = '�����'; }
		elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
		elseif ($row['room'] >= 61001 && $row['room'] <= 62000) { $rrm =  '������'; }
		elseif ($row['room'] >= 49998 && $row['room'] <= 60000) {
			include "map_config.php";
			reset($map_locations);
			$bfound = false;
			while(list($k,$v) = each($map_locations)) {
				if ($row['room'] == $v['room']) {
					$rrm = $v['name'];
					$bfound = true;
				}
			}
			if (!$bfound) $rrm = '�������';
		}

		else { $rrm = $rooms[$row['room']]; }
		}

		$outstring.='
	   <div class="separate"></div>
                    </td>
                    <td class="row-center">
                        <em>';
		if ($kl_status!='') { $outstring.=$kl_status; }

		if ($row['comment']!='')
		{
			if ($kl_status!='') $outstring.= ' - ' ;
			$outstring.=$row['comment'];
		}

		$outstring.='</em>
                        <a class="icon edit"  href=\'friends.php?pals='.$_GET['pals'].'&editusr='.$row['id'].'\'></a>
                        <div class="separate"></div>
                    </td>
                    <td class="row-right">
                        <div class="row-location"><i>'.$rrm.'</i></div>';
		if (($_GET['pals']=="1") OR ($_GET['pals']=="11") )
		{
			$outstring.='<a class="icon remove" OnClick="if (!confirm(\'������� �������� �� ����� ������?\')) { return false; } " href=\'friends.php?pals='.$_GET['pals'].'&delusr='.$row[friend].'\'></a>';
		}
		$outstring.='
                        <div class="separate"></div>
                    </td>
                </tr>';
	}
	else
	{
		$outstring='
		                <tr class="item-row">
		                    <td class="row-left">
		                       <i class="icon private"><img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15></i>';
		if ($row[hidden]>0)
		{
			$row[hidden]=0;
			$outstring.=nick_hist($row).'&nbsp;';
		}
		else
		{
			$outstring.=nick_hist($row,$dilinf).'&nbsp;';
			$outstring.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
			$outstring.=($row['battle']>0?'<a target=_blank href=http://'.($city_name[$row[id_city]]).'.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
		}


		$outstring.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'');
		$outstring.='<div class="separate"></div>
		                    </td>
		                    <td class="row-center">
		                        <em>';
		if ($kl_status!='') { $outstring.=$kl_status; }

		if ($row['comment']!='')
		{
			if ($kl_status!='') $outstring.= ' - ' ;
			$outstring.=$row['comment'];
		}

		$outstring.='</em>
		                        <a class="icon edit"  href=\'friends.php?pals='.$_GET['pals'].'&editusr='.$row[friend].'\'></a>
		                        <div class="separate"></div>
		                    </td>
		                    <td class="row-right">
		                        <div class="row-location empty">�������� �� � �����</div>';
		if (($_GET['pals']=="1") OR ($_GET['pals']=="11") )
		{
			$outstring.='<a class="icon remove" OnClick="if (!confirm(\'������� �������� �� ����� ������?\')) { return false; } " href=\'friends.php?pals='.$_GET['pals'].'&delusr='.$row[friend].'\'></a>';
		}
		$outstring.='
		                        <div class="separate"></div>
		                        <div class="separate"></div>
		                    </td>
		                </tr>';
	}

	return $outstring;
}




function get_mag_stih($telo,$effect=null)
{
 					if ($telo['smagic']==0)
					{
						 if ($telo['borndate']!='')
							{
								$dt=$telo['borndate'];

								$out_array=array();
								$month=substr($dt,3,2);
								$day=substr($dt,0,2);

								$month=(int)$month;
								$day=(int)$day;

								  if ($month == 1) {
							         if ($day >= 21) {$zodik=11;} else {$zodik=10;}}
							      else if ($month == 2) {
							         if ($day >= 21) {$zodik=12;} else {$zodik=11;} }
							       else if ($month == 3) {
							         if ($day >= 21) {$zodik=1;} else {$zodik=12;} }
							       else if ($month == 4) {
							         if ($day >= 21) {$zodik=2;} else {$zodik=1;} }
							       else if ($month == 5) {
							         if ($day >= 21) {$zodik=3;} else {$zodik=2;} }
							       else if ($month == 6) {
							         if ($day >= 22) {$zodik=4;} else {$zodik=3;} }
							       else if ($month == 7) {
							         if ($day >= 23) {$zodik=5;} else {$zodik=4;} }
							       else if ($month == 8) {
							         if ($day >= 24) {$zodik=6;} else {$zodik=5;} }
							       else if ($month == 9) {
							         if ($day >= 24) {$zodik=7;} else {$zodik=6;} }
							       else if ($month == 10) {
							         if ($day >= 24) {$zodik=8;} else {$zodik=7;} }
							       else if ($month == 11) {
							         if ($day >= 23) {$zodik=9;} else {$zodik=8;} }
							       else if ($month == 12) {
							         if ($day >= 22) {$zodik=10;} else {$zodik=9;}}


							         if (($zodik==1) OR ($zodik==5) OR ($zodik==9) )
							         {
							         $out_array[]=1; // ����� (����, ���, �������)
							         }
							         else if (($zodik==2) OR ($zodik==6) OR ($zodik==10))
							         {
							         $out_array[]=2; // ����� (�������. �����, ����)
							         }
							         else if (($zodik==3) OR ($zodik==7) OR ($zodik==11))
							         {
							         $out_array[]=3; //������ (����, �������, ��������)
							         }
							         else if (($zodik==4) OR ($zodik==8) OR ($zodik==12) )
							         {
							         $out_array[]=4; //���� (���, ��������, ����)
							         }
							}
							else
							{
							$out_array[]=1; // ����� ��� ��� � ���� ��� ���� ��
							}
				        }
				        else
				        {
					$out_array[]=$telo['smagic']; //������ ����� �������� �� ���� � �� ����������� �� ���� �������� ��� ���� �� 20/02/2016
				        }


        //��������������
         if (is_array($effect[10901]))
         	{
	         $out_array[]=1; // ����� (����, ���, �������)
         	}
	elseif (is_array($effect[10902]))
         	{
	         $out_array[]=2; // ����� (�������. �����, ����)
         	}
	elseif (is_array($effect[10903]))
         	{
         	$out_array[]=3; //������ (����, �������, ��������)
         	}
	elseif (is_array($effect[10904]))
         	{
	         $out_array[]=4; //���� (���, ��������, ����)
         	}

 return $out_array;
}

function CheckOpDay() {
	$q = mysql_query('SELECT * FROM oldbk.variables WHERE var = "opposition_today"');
	if (mysql_num_rows($q) > 0) {
		$v = mysql_fetch_assoc($q);
		if ($v !== FALSE) {
			if (date("d/m/Y",time()+(24*3600*4)) == $v['value']) {
				if (date("H") >= 6) {
					return true;
				}
			}
		}
	}
	return false;
}

function CheckOpNextDay() {
	$q = mysql_query('SELECT * FROM oldbk.variables WHERE var = "opposition_today"');
	if (mysql_num_rows($q) > 0) {
		$v = mysql_fetch_assoc($q);
		if ($v !== FALSE) {
			if (date("d/m/Y",time()+(24*3600*4)) == $v['value']) {
				if (date("H") >= 6) {
					return true;
				} else {
					return "������� � 06:00";
				}
			} else {
				return $v['value']." 06:00";
			}
		}
	}
	return false;
}

function log_bag_deb($text)
{

	$fp = fopen ("/www/other/can_i_go_battle.txt","a"); //��������
	flock ($fp,LOCK_EX); //���������� �����
	fputs($fp , $text."\n"); //������ � ������
	fflush ($fp); //�������� ��������� ������ � ������ � ����
	flock ($fp,LOCK_UN); //������ ����������
	fclose ($fp); //��������
}

function start_line_battle($battle_id,$telo,$enemy)
{
//global $wpers,$wteam;

$wpers = array( 0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0,7=>1, 8=>3, 9=>9,10=>27,11=>81,12=>243,13=>729,14=>2187);
$wteam=array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>3,8=>3,9=>10,10=>29,11=>83,12=>263,13=>790,14=>2307);

//������� ������ � ������ ���
//���������� ��� ������� � ����������  ���� �������
$telo_t="t".$telo['battle_t'];
$enemy_t="t".($telo['battle_t']==1?2:1);
$max_level=($telo['level']>$enemy['level']?$telo['level']:$enemy['level']);
$max_wp=$wteam[$max_level];
$telo_ves=$wpers[$telo['level']];
$enemy_ves=$wpers[$enemy['level']];
$wmax=($telo_ves>$enemy_ves?($enemy_ves+$max_wp):($telo_ves+$max_wp));
$text='start_line_battle:'.$battle_id.':TELOid'.$telo['id'].':EnID'.$enemy['id'];
log_bag_deb($text);
mysql_query("INSERT INTO `battle_war` SET `battle`='{$battle_id}',`{$telo_t}`='{$telo_ves}' ,`{$enemy_t}`='{$enemy_ves}',  `wmax`='{$wmax}' ,  maxlevel='{$max_level}' ;");
if (mysql_affected_rows()>0)
	{
	return true;
	}
return false;
}


function sum_line_battle($battle,$telo)
{
//global $wpers,$wteam;
//������ ������������ � ���������� ������������� ������
//���������� ���� ������� �� ��������
$wpers = array( 0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0,7=>1, 8=>3, 9=>9,10=>27,11=>81,12=>243,13=>729,14=>2187);
$wteam=array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>3,8=>3,9=>10,10=>29,11=>83,12=>263,13=>790,14=>2307);

$battle_id=$battle['id'];
$telo_t="t".$telo['battle_t'];
$telo_c="count".$telo['battle_t'];
$telo_ves=$wpers[$telo['level']];
mysql_query("UPDATE `battle_war` SET {$telo_t}={$telo_t}+'{$telo_ves}' , {$telo_c}={$telo_c}+1 , maxlevel=(if (maxlevel<'{$telo['level']}','{$telo['level']}',maxlevel)) where battle='{$battle_id}' " );
$text='sum_line_battle:'.$battle_id.':TeloID:'.$telo['id'];
log_bag_deb($text);
}


function can_i_go_battle($telo,$battle,$team,$cp=false) // ������� ��������� ����� �����
{
///global $wpers,$wteam;

$wpers = array( 0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0,7=>1, 8=>3, 9=>9,10=>27,11=>81,12=>243,13=>729,14=>2187);
$wteam=array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>3,8=>3,9=>10,10=>29,11=>83,12=>263,13=>790,14=>2307);
$battle_id=$battle['id'];

//��� � ��������� ���
$bd=mysql_fetch_array(mysql_query("SELECT * from `battle` where id='{$battle_id}' "));
if (($bd['teams']!='') and ($bd['teams']!='��� �����') and ($bd['teams']!='����') )
    {
     $h=explode(":||:",$bd['teams']);
      if ($h[0]==20000)
      	{
		echo "��� ����������...";
      	}
      	else
      	{
	echo "��� ������ �� �������������...".$bd['teams'];
	}
    return false;
    }
//////////////////

$get_line=mysql_fetch_array(mysql_query("SELECT * from `battle_war` where battle='{$battle_id}' "));

$telo_c="count".$team;
$telo_t="t".$team;
$enemy_t="t".($team==1?2:1);
$telo['battle_t']=$team;

log_bag_deb('can_i_go_battle:'.$battle_id.'|teloid:'.$telo['id'].'|TeloT:'.$telo['battle_t'].'|CP:'.$cp.'|Co1:'.$get_line['count1'].'|Co2:'.$get_line['count2'].'|act:'.$get_line['active']);

$get_line[$telo_c]++; // ��������� ��������� � ��� � ������ ����


	/*
	if ( ((($get_line['count1']>=5) and ($get_line['count2']>=5)) and $battle['type']!=40 and $battle['type']!=41) // ��� ���� ����� ��
	 OR ((($get_line['count1']>=3) OR ($get_line['count2']>=3)) and  ($battle['type']==40 OR $battle['type']==41) )  //���� � ��
	 OR ((($get_line['count1']>=5) OR ($get_line['count2']>=5)) and  ($cp==true) ) ) // ��� �� ��
	 */
		if (true)
		{
		//������ 5 � ������ ������� - ����
				if ($get_line['active']==0)
				{
				//��� �� ������� ������ ���� :
				//�������� ��� ���������
				$get_line[$telo_t]+=$wpers[$telo['level']];
				$get_line['maxlevel']=($get_line['maxlevel']<$telo['level']?$telo['level']:$get_line['maxlevel']); // ���� ������� ��� ������ ��� ���� �� ������ � ����.�������
				// ����������� ������ � ����
				$max_wp=$wteam[$get_line['maxlevel']];
				$wmax=($get_line['t1']>$get_line['t2']?($get_line['t2']+$max_wp):($get_line['t1']+$max_wp));
				//� ������������ �������
				mysql_query("UPDATE `battle_war` SET  t1='{$get_line['t1']}' , t2='{$get_line['t2']}', count1='{$get_line['count1']}' , count2='{$get_line['count2']}', maxlevel='{$get_line['maxlevel']}' , wmax='{$wmax}' , active='1' where battle='{$battle_id}' ");
				// �� � ������� ����

					//���� ��
					if ( ($cp==true) and ($battle['coment']!='<b>����-����</b>') )
						{
						//���������� ���� - ���� ���������� ��� ��� �� ��������
						mysql_query('UPDATE `battle`  SET blood=1  WHERE `id` = '.$battle_id.' ;');
						}
				//����� � ��� ��������
				addlog($battle_id,"!:#:".time().":1\n");
				return true;
				}
				else
				{
				//��� ��������
				 //�������
				  if (($get_line[$telo_t] < $get_line['wmax'])  and ($get_line[$enemy_t] < $get_line['wmax']) )
				  	{
					//����� �������
					$get_line[$telo_t]+=$wpers[$telo['level']];

					  if ( ($get_line[$telo_t]  >=  $get_line[$enemy_t])  AND ($get_line[$telo_t]>=$get_line['wmax']) AND ($get_line[$enemy_t]>=$get_line['wmax']) )
					  		{
				  			//���� ���������� ��� ������� ���������������
				  			//�� ��������������� ���� ������
							$get_line['maxlevel']=($get_line['maxlevel']<$telo['level']?$telo['level']:$get_line['maxlevel']); // ���� ������� ��� ������ ��� ���� �� ������ � ����.�������
  							$max_wp=$wteam[$get_line['maxlevel']];
							$wmax=($get_line['t1']>$get_line['t2']?($get_line['t2']+$max_wp):($get_line['t1']+$max_wp));
							mysql_query("UPDATE `battle_war` SET  t1='{$get_line['t1']}' , t2='{$get_line['t2']}', count1='{$get_line['count1']}' , count2='{$get_line['count2']}', maxlevel='{$get_line['maxlevel']}' , wmax='{$wmax}' , active='1' where battle='{$battle_id}' ");
				  			//� ����� �������
		  					return true;
					  		}
					  		else
				  			/// �����  ��������� ��� ��������������� ������� c ����� ���� ���� + ��� ���
				  			{
				  			// ���� �� �������� ��� ���+��� ���� ���� ���� ��������������� �������
				  			//���� ��� ��
				  			//������� � ��������� ��� ��� � �������
							sum_line_battle($battle,$telo);
		  					return true;
				  			}
				  	}
				  else	if ( ($get_line[$enemy_t] >= $get_line['wmax']) AND ($get_line[$telo_t] < $get_line[$enemy_t]) )
				  	{
					//����� �������
					$get_line[$telo_t]+=$wpers[$telo['level']];

					  if ( ($get_line[$telo_t]  >=  $get_line[$enemy_t])  AND ($get_line[$telo_t]>=$get_line['wmax']) AND ($get_line[$enemy_t]>=$get_line['wmax']) )
					  		{
				  			//���� ���������� ��� ������� ���������������
				  			//�� ��������������� ���� ������
							$get_line['maxlevel']=($get_line['maxlevel']<$telo['level']?$telo['level']:$get_line['maxlevel']); // ���� ������� ��� ������ ��� ���� �� ������ � ����.�������
  							$max_wp=$wteam[$get_line['maxlevel']];
							$wmax=($get_line['t1']>$get_line['t2']?($get_line['t2']+$max_wp):($get_line['t1']+$max_wp));
							mysql_query("UPDATE `battle_war` SET  t1='{$get_line['t1']}' , t2='{$get_line['t2']}', count1='{$get_line['count1']}' , count2='{$get_line['count2']}', maxlevel='{$get_line['maxlevel']}' , wmax='{$wmax}' , active='1' where battle='{$battle_id}' ");
				  			//� ����� �������
		  					return true;
					  		}
					  		else
				  			/// �����  ��������� ��� ��������������� ������� c ����� ���� ���� + ��� ���
				  			{
				  			// ���� �� �������� ��� ���+��� ���� ���� ���� ��������������� �������
				  			//���� ��� ��
				  			//������� � ��������� ��� ��� � �������
							sum_line_battle($battle,$telo);
		  					return true;
				  			}
				  	}
				  else
				  	{
				  	//��� ������� ������ ������
				  	//����� ������
  					return false;
				  	}


				}
		}
		else
		{
		//��� ��� ������� ���. ����� ������ ��������� ��� �����  � ����.������� ���� �� ������
		sum_line_battle($battle,$telo);
		return true; // �� ����� �������
		}
}

////////////

function deny_money_out($telo,$mesg)
{
	$test_money=mysql_query("select * from oldbk.com_money where (stat=0 or stat=-1) and owner='{$telo['id']}' ");

	if (mysql_num_rows($test_money) > 0)
		{
			while($row=mysql_fetch_array($test_money))
				{
				//���� ������ ��������
				real_zak_cancel($telo,$row,$mesg);
				}
		}
		else
		{
		return false;
		}
}

function real_zak_cancel($us,$get_zak,$mesg)
{
//����� �� ��������  ����� ��� ������
	mysql_query("UPDATE oldbk.com_money SET  stat=3, paydate=NOW(), prim='".mysql_real_escape_string($mesg)."'   where id='{$get_zak['id']}' ;");
	if (mysql_affected_rows()>0)
		{
			//����� � ���� � ������ � ��������
				$rec = array();
	    			$rec['owner']=$us['id'];
				$rec['owner_login']=$us['login'];
				$rec['owner_balans_do']=$us['money'];
				$rec['owner_balans_posle']=$us['money'];
				$rec['target_login'] = "��";
				$rec['item_id']=$get_zak['logids'];
				$rec['type'] = 415; //��� - ����� �� ����� ������� msum
				$rec['sum_ekr'] =$get_zak['msum'];
				$rec['add_info']='������ �WM'.$get_zak['id'].' , �� WMZ:'.$get_zak['outwmz'];
				if (add_to_new_delo($rec) === FALSE) die();
			//���������� �������� c ���������� 453
			mysql_query('UPDATE oldbk.inventory  set owner='.$get_zak['owner'].', battle=0  WHERE owner=453 and battle='.$get_zak['id']) or die();
			// ����� ���������
			systemtotelom($us,"��� �������� � ������ ������� �� ���� �� �������:\"".mysql_real_escape_string($mesg)."\". ��� ������ ���������� ��� � ���������");
			return true;
		}
return false;
}

function systemtotelom($art_telo,$text) {
	if ($art_telo['odate'] > (time()-60)) {
		addchp('<font color=red>��������!</font> '.mysql_real_escape_string($text).'.','{[]}'.$art_telo['login'].'{[]}',$art_telo['room'],$art_telo['id_city']);
	} else {
		mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$art_telo['id']."','','<font color=red>��������!</font> ".mysql_real_escape_string($text).".');");
	}

}


///////////

function smart_fid($row,$from_city)
{
if (($row['idcity']==0)and($from_city==0))
 	{
 	$out='cap'.$row[id];
 	return $out;
 	}
 else if (($row['idcity']==1)and($from_city==0))
 	{
 	$out='ava'.$row[t_id];
 	return $out;
 	}
 else if (($row['idcity']==0)and($from_city==1))
 	{
 	$out='cap'.$row[t_id];
 	return $out;
 	}
 else if (($row['idcity']==1)and($from_city==1))
 	{
 	$out='ava'.$row[id];
 	return $out;
 	}
 else  {
 	$out='none'.$row[id];
 	return $out;
 	}

}

function check_users_city_data($id)
{
    $user_city=mysql_fetch_array(mysql_query('SELECT * from oldbk.`users` where id="'.$id.'";'));
	if(!$user_city)
	{
		$user_city=FALSE;
	}
	else
    if($user_city['id_city']==1)
	{
		$user_city=mysql_fetch_array(mysql_query('SELECT * from avalon.`users` where id="'.$id.'";'));
	}
   else
    if($user_city['id_city']==2)
	{
		$user_city=mysql_fetch_array(mysql_query('SELECT * from angels.`users` where id="'.$id.'";'));
	}
    return  $user_city;
}

function check_users_city_datal($login)
{
    $user_city=mysql_fetch_array(mysql_query('SELECT * from oldbk.`users` where login="'.mysql_real_escape_string($login).'";'));
	if(!$user_city)
	{
		$user_city=FALSE;
	}
	else
    if($user_city['id_city']==1)
	{
		$user_city=mysql_fetch_array(mysql_query('SELECT * from avalon.`users` where login="'.mysql_real_escape_string($login).'";'));
	}
	else
    if($user_city['id_city']==2)
	{
		$user_city=mysql_fetch_array(mysql_query('SELECT * from angels.`users` where login="'.mysql_real_escape_string($login).'";'));
	}
    return  $user_city;
}


function Test_Arsenal_Items($user,$ttype=0,$del_pers=0,$haos_block=0)
 {
 	global $db_city;

if ($user[id] >0)
{
//haos_block ��������� ��� ����� � �����, �������� ������ � �����



if ($user[klan]!='')
{
if ($user[battle] >0 )
     		{
     		$all_to_back=1;
     		}
     		else
     	{

     	if    (!( (($user[room]>=197) and ($user[room]<=199))
		     OR (($user[room]>=211) and ($user[room]<240))
		     OR (($user[room]>240) and ($user[room]<270))
		     OR (($user[room]>270) and ($user[room]<290)) ))
		     {
			undressall($user['id'],$user[id_city]);
		     }
		     else
		     {
		     	$all_to_back=1;
		     }
     	}
////////////////////////////
	//1. ��������� ���� �� �� ���� ���� �� �������� - return 1
    if($ttype==0 || $ttype==2)
    {

	check_img($user); //�������� �������� �������

	$myars= mysql_query("SELECT * FROM oldbk.`inventory`  WHERE owner='{$user[id]}' and arsenal_owner>0 and arsenal_klan='{$user[klan]}' and arsenal_owner!='{$user[id]}'; ");
	   while($row = mysql_fetch_array($myars))
	   {
		$it_fid='';$sql_me='';

		if  ($all_to_back==1)
		    {
		    //������� ��� � ��� - ��������� ���� � ������� ��� ����������
	             	mysql_query("INSERT INTO oldbk.clans_arsenal_back (item_id,owner_current,owner_original)
	             	            VALUES ('{$row[id]}','{$row[owner]}','".($del_pers>0?$del_pers:$row[owner])."')");
		    }
		    else
		    {
		    // �� � ���
    				$it_fid=get_item_fid($row);

    				if($row['add_pick']!='')
				{
    					undress_img($row);
				}
	    	      		// ������ � owner 22125
				mysql_query("update oldbk.inventory set owner='22125', dressed=0, present='' ,  `letter`='' , `prokat_do`=''  where id='{$row[id]}' and owner='{$user['id']}'");
					if (mysql_affected_rows()>0)
				     		{
							// ���������� ����
							$log_text = '"'.$user[login].'" ������ � ������� ��� ������ �� ����� ���������� "'.$user[klan].'" :"'.$row[name].'" ['.$row[duration].'/'.$row[maxdur].']';
							$delo_text = '"'.$user[login].'" ������ � ������� ��� ������ �� ����� ���������� "'.$user[klan].'" : "'.$row[name].'" ['.$row[duration].'/'.$row[maxdur].'] id:('.$it_fid.') [ups:'.$row[ups].'/free:'.$row[upfree].'/inc:'.$row[includemagicname].']';
							mysql_query("UPDATE oldbk.clans_arsenal set owner_current=0 WHERE id_inventory='{$row[id]}'");

							//new_delo
		  		    			$rec['owner']=$user[id];
							$rec['owner_login']=$user[login];
							$rec['owner_balans_do']=$user['money'];
							$rec['owner_balans_posle']=$user['money'];
							$rec['target']=0;
							$rec['target_login']=0;
							$rec['type']=20;
							$rec['sum_kr']=0;
							$rec['sum_ekr']=0;
							$rec['sum_kom']=0;
							$rec['item_id']=$it_fid;
							$rec['item_name']=$row['name'];
							$rec['item_count']=1;
							$rec['item_type']=$row['type'];
							$rec['item_cost']=$row['cost'];
							$rec['item_dur']=$row['duration'];
							$rec['item_maxdur']=$row['maxdur'];
							$rec['item_ups']=$row['ups'];
							$rec['item_unic']=$row['unic'];
							$rec['item_incmagic']=$row['includemagicname'];
							$rec['item_incmagic_count']=$row['includemagicuses'];
							$rec['item_arsenal']=$user[klan];
							add_to_new_delo($rec); //�����


							mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
							addchp ('<font color=red>��������!</font> � ��� ����� ������� '.$row[name].' � ������� � �������� �������  ','{[]}'.$user[login].'{[]}',0,$user['id_city']);
						}

		    }


		}
    }

//2. ��������� ���� � �������� ���� ������ ����+
        if($ttype==0 || $ttype==1)
		{
		check_img($user);
		//������ ��� ���� �� ������� �.�. ���� ����� ���� ��� ������
		//�������� ��� ��� ���� ��� � ������ � ���
			$inars = mysql_query("SELECT * FROM oldbk.`inventory`  WHERE arsenal_owner='{$user[id]}' and owner not in (442,444,445,446,447,448,449,450) and arsenal_klan!='' ");

			while($row = mysql_fetch_array($inars))
			{

			if ($row['owner']==22125)
			      {
			      //echo " ������ ������ ����� � �������� �� ����� <br>";
			      	mysql_query("update oldbk.inventory set owner='{$user['id']}', arsenal_klan='', present='', `letter`='' , `prokat_do`='', arsenal_owner=0  where id='{$row['id']}' and owner='22125'");
					if (mysql_affected_rows()>0)
				     	{
						$it_fid=get_item_fid($row);
		    				    if($row['add_pick']!='')
							{
    							undress_img($row);
							}

						$log_text = '"'.$user[login].'" ������ �� �������� ��� ������ �� ����� "'.$user[klan].'" :"'.$row[name].'" ['.$row[duration].'/'.$row[maxdur].']';
						$delo_text = '"'.$user[login].'" ������ �� �������� ��� ������ �� ����� "'.$user[klan].'" : "'.$row[name].'" ['.$row[duration].'/'.$row[maxdur].'] id:('.$it_fid.') [ups:'.$row[ups].'/free:'.$row[upfree].'/inc:'.$row[includemagicname].']';
						mysql_query("DELETE FROM oldbk.clans_arsenal WHERE id_inventory='{$row[id]}'");
						mysql_query("DELETE FROM oldbk.clans_arsenal_access WHERE item='{$row[id]}'");

						//new_delo
	  		    			$rec['owner']=$user[id];
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money'];
						$rec['target']=0;
						$rec['target_login']=0;
						$rec['type']=21;
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
						$rec['item_unic']=$row['unic'];
						$rec['item_incmagic']=$row['includemagicname'];
						$rec['item_incmagic_count']=$row['includemagicuses'];
						$rec['item_arsenal']=$user[klan];
						add_to_new_delo($rec); //�����
						mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
					}
			      }
///////////////////////////////////////////////////////////////////
			      else
			      {
			    //  echo " ������ �� ����� <br>";
			      //�������� � ����� ������ ��
			      $telo=check_users_city_data($row[owner]);

			       if ($telo[battle] > 0 )
			             {
			             // ���� ���� � ���
			             // �� ������ ������� � �������� ��� ���� ���������� ��� ���� � ����� ������� ������
			             mysql_query("INSERT INTO oldbk.clans_arsenal_back (item_id,owner_current,owner_original)
			             VALUES ('{$row[id]}','{$row[owner]}','".($del_pers>0?$del_pers:$row[owner])."')");
			             }
			             else
			             {
			             // ���� ���� �� � ���
			             /// �� ��������� ��� � �������� ������
							// ��������� ���� ��������
				      		    undressall($telo['id'],$telo[id_city]);
				 		   $it_fid=get_item_fid($row);
		    				    if($row['add_pick']!='')
							{
    							undress_img($row);
							}
				          	 mysql_query("update oldbk.inventory set owner='{$user['id']}', dressed=0,arsenal_klan='', arsenal_owner=0 , present='' ,  `letter`='' , `prokat_do`=''  where id='{$row['id']}' and owner='{$telo['id']}'");
				          	 if (mysql_affected_rows()>0)
					     		{
								// ���������� ����
									$log_text = '"'.$user[login].'" ������ ����� ������� ��� ������ �� ����� "'.$user[klan].'" :"'.$row[name].'" ['.$row[duration].'/'.$row[maxdur].']';
									$delo_text = '"'.$user[login].'" ������ ����� ������� ��� ������ �� ����� "'.$user[klan].'" : "'.$row[name].'" ['.$row[duration].'/'.$row[maxdur].'] id:('.$it_fid.') [ups:'.$row[ups].'/free:'.$row[upfree].'/inc:'.$row[includemagicname].']';
									mysql_query("DELETE FROM oldbk.clans_arsenal WHERE id_inventory ='{$row[id]}'");
									mysql_query("DELETE FROM oldbk.clans_arsenal_access WHERE item='{$row[id]}'");
									//new_delo
									$rec['owner']=$user[id];
									$rec['owner_login']=$user[login];
									$rec['owner_balans_do']=$user['money'];
									$rec['owner_balans_posle']=$user['money'];
									$rec['target']=$telo[id];
									$rec['target_login']=$telo[login];
									$rec['type']=22;
									$rec['sum_kr']=0;
									$rec['sum_ekr']=0;
									$rec['sum_kom']=0;
									$rec['item_id']=$it_fid;
									$rec['item_name']=$row['name'];
									$rec['item_count']=1;
									$rec['item_type']=$row['type'];
									$rec['item_cost']=$row['cost'];
									$rec['item_dur']=$row['duration'];
									$rec['item_maxdur']=$row['maxdur'];
									$rec['item_ups']=$row['ups'];
									$rec['item_unic']=$row['unic'];
									$rec['item_incmagic']=$row['includemagicname'];
									$rec['item_incmagic_count']=$row['includemagicuses'];
									$rec['item_arsenal']=$user[klan];
									add_to_new_delo($rec); //�����
									$rec['owner']=$telo[id];
									$rec['owner_login']=$telo[login];
									$rec['owner_balans_do']=$telo['money'];
									$rec['owner_balans_posle']=$telo['money'];
									$rec['target']=$user[id];
									$rec['target_login']=$user[login];
									$rec['type']=23;
									add_to_new_delo($rec); //����

									mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
									addchp ('<font color=red>��������!</font> � ��� ����� ������� '.$row[name].' ������������� '.$user[login].'  ','{[]}'.$telo[login].'{[]}',0,$telo['id_city']);
								}
			                }
			      }
			} //����
		} // ����� ����


	  if($ttype==0)
	  {
		    check_img($user);//��� ��������� ���������� ����������� ������, ��� ������ ��������� �������� �������� �� ����������� �������


		//��������� ������
		    $data=mysql_query("SELECT us.* FROM oldbk.users_shadows us
		    inner join oldbk.clans c
		    on c.id=us.klan
		    WHERE c.short='".$user[klan]."';");
	            while($klan_sh=mysql_fetch_array($data))
	            {
	               $ss=($klan_sh[sex]==1?'m':'g').$klan_sh[name].'.gif';


	               if($ss==$user[shadow])
	               {
	               		foreach($db_city as $k=>$v)
				 {
	               		       mysql_query('UPDATE '.$v.'users SET shadow="0.gif" WHERE id='.$user[id].';');
	               		 }
	               }
	            }

		     $new_room=($user[room]==18?17:$user[room]);
		     $new_room=($user[room]==56?36:$user[room]);
		     $new_room=($user[room]==55?54:$user[room]);

	  	  if($user[room]== 17 || $user[room]== 18 || $user[room]== 36 || $user[room]== 56 || $user[room]== 54 || $user[room]== 55)
	  	  {
	  	  	mysql_query('update '.$db_city[$user['id_city']].'users  set room=1  where  id='.$user[id].';');
	  	  }
  	  }
  }

  if($haos_block==1)
  {
  	$data=mysql_query("select * from oldbk.inventory where owner=".$user[id]." AND setsale>0 ");
  	if(mysql_num_rows($data)>0)
  	{
  		$id_s=array();
  		while($row=mysql_fetch_assoc($data))
  		{
  			$id_s[$row[id]]=$row[id];

  			$rec['owner']=$user['id'];
			$rec['owner_login']=$user['login'];
			$rec['owner_balans_do']=$user['money'];
			$rec['owner_balans_posle']=$user['money'];
			$rec['target']=0;
			$rec['target_login']='�����';
			$rec['type']=121;//������ �� ����
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
			$rec['item_incmagic_id']=$row['includemagic'];
			$rec['item_ecost']=$row['ecost'];
			$rec['item_proto']=$row['prototype'];
			$rec['item_sowner']=($row['sowner']>0?1:0);
			$rec['item_incmagic']=$row['includemagicname'];
			$rec['item_incmagic_count']=$row['includemagicuses'];
			$rec['item_arsenal']='';
			add_to_new_delo($rec); //�����
  		}
  		mysql_query("UPDATE oldbk.inventory SET setsale=0 WHERE id in (".(implode(',',$id_s)).") AND owner=".$user[id].";");
  		mysql_query("DELETE from oldbk.comission_indexes WHERE id_item in (".(implode(',',$id_s)).") AND owner=".$user[id].";");
  	}

  }

  ///���������� ��� ���� �� ������� ������� ��� ����
  // ��������� �.�. ������ ��� ������
 // mysql_query("UPDATE oldbk.inventory SET owner='{$user[id]}', arsenal_owner=0  WHERE owner=488 AND arsenal_owner='{$user[id]}'");

  }

 }


 function check_hp($id,$dr=0,$id_city=-1){
 //��� �������� ���� ������
$db_city[0]='oldbk.';
$db_city[1]='avalon.';
$db_city[1]='angels.';
if ($db_city[$id_city]=='') { $db_prexif=''; } else {$db_prexif=$db_city[$id_city]; }

 	  if($dr==1)
 	  {
 	  	$sql='+ (IFNULL((SELECT SUM(`ghp`) FROM oldbk.`inventory` WHERE dressed=1 AND owner = u.id),0)) ';
 	  }
 	  else
 	  {
 	  	$sql='';
 	  }
	   //��� ����������, ��������� ������ � ��.
	  $q = mysql_query('UPDATE '.$db_prexif.'users u SET `maxhp` =  ((vinos*6) + (bpbonushp) + (ifnull((select maxhp from users_bonus where owner = u.id),0)) '.$sql.'  ),
		`hp` =  IF(((vinos*6) + (bpbonushp) + (ifnull((select maxhp from users_bonus where owner = u.id),0)) '.$sql.' )<hp,((vinos*6) + (bpbonushp) + (ifnull((select maxhp from users_bonus where owner = u.id),0)) '.$sql.'),hp),
		`maxmana` = (mudra*10)
		WHERE id = '.$id.';');
	if ($q === FALSE) return FALSE;
	return true;
 }


 function check_hollydays($piccha,$hollyday=0)
{
    $otdel_bron=array(22,23,6,52);
    $otdel_puha=array(1,11,12,13,14);

    //�������� ���� �������� ������ �� ����������� � ������� ���������...
        if(in_array($piccha['otdel'], $otdel_bron) && $hollyday==1)
        {
          $sql="`otdel` in (22,23,6,52) AND type in (4,27)";
        }
        elseif(in_array($piccha['otdel'], $otdel_puha) && $hollyday==1)
        {
          $sql="`otdel` in (1,11,12,13,14) AND type in (3)";
        }
        else
        {
          $sql="`otdel` in (".(int)($piccha['otdel']).") AND type in (1,2,3,4,5,8,9,10,11,27,28) AND name not like '%�����%' AND name not like '%�����%' and name not like '%�����%' AND name not like '%����%' and name not like '%������%'";
        }
        return $sql;
}

 function undress_img($item)
{   //������� �������� �� ������ (�����)
        if(mysql_query('update oldbk.inventory as i
				   set i.add_pick="", i.pick_time=""
				WHERE i.id='.$item[id].' AND i.owner = '.$item[owner].';'))
	{
		if(mysql_query('update oldbk.gellery set dressed=0 where owner='.$item[owner].' AND img="'.$item[add_pick].'" AND otdel='.$item[otdel].' AND dressed >0 LIMIT 1;'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

function check_img($user)
{   //��� ������ �� ����� ������� �������� ��������

 	$sql=mysql_query("SELECT * FROM oldbk.`gellery_prot` WHERE `klan_owner` = (SELECT id FROM oldbk.clans WHERE short='".$user['klan']."');");
	$klan_img='';
	$fg=0;
	while($data=mysql_fetch_array($sql))
	{
		if(!in_array($data[img],$my_klan_img))
		{
			$klan_img.=' "'.$data[img].'", ';
			$fg++;
		}
	}
        //���� ���� � ����� ��������...
	if($fg>0)
	{
		$klan_img=substr($klan_img,0,-2);
		mysql_query('update oldbk.inventory set add_pick="", pick_time="" WHERE add_pick in ('.$klan_img.') AND owner = '.$user[id].';');
		mysql_query('DELETE FROM oldbk.gellery WHERE img in ('.$klan_img.') AND owner = '.$user[id].';');
	}
}

// ����� ������

function nick_hist ($telo,$dilinf=false) {

	if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com')  {
		$domen='http://capitalcity.oldbk.com/';
	} else if ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com')  {
		$domen='http://avaloncity.oldbk.com/';
	} else if ($_SERVER["SERVER_NAME"]=='angelscity.oldbk.com')  {
		$domen='http://angelscity.oldbk.com/';
	}
	else {
		$domen='http://capitalcity.oldbk.com/';
	}

	if ( ($telo[hidden]>0) and ($telo[hiddenlog] =='' ) )   {
		$mm = "<B><i>���������</i></B> [??]<a href=".$domen."inf.php?{$telo['hidden']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � ���������\"></a>";
	} else {
		if ($dilinf==true)
		{
			if ($telo['deal']==1) $mm .= "<img src=\"http://i.oldbk.com/i/alchemy1.gif\">";
			elseif ($telo['deal']==2) $mm .= "<img src=\"http://i.oldbk.com/i/alchemy2.gif\">";
			$mm .= "<B>{$telo['login']}</B> [{$telo['level']}]<a href=".$domen."inf.php?{$telo['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$telo['login']}\"></a>";
		}
		else
		{
		$mm .= "<img src=\"http://i.oldbk.com/i/align_".($telo['align']>0 ? $telo['align']:"0").".gif\">";
		if ($telo['klan'] <> '') {
			$mm .= '<img title="'.$telo['klan'].'" src="http://i.oldbk.com/i/klan/'.$telo['klan'].'.gif">'; }
			$mm .= "<B>{$telo['login']}</B> [{$telo['level']}]<a href=".$domen."inf.php?{$telo['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$telo['login']}\"></a>";
		}
	}
	return $mm;
}

function nick_hist_horse ($telo) {
	if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com')  {
		$domen='http://capitalcity.oldbk.com/';
	} else if ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com')  {
		$domen='http://avaloncity.oldbk.com/';
	} else if ($_SERVER["SERVER_NAME"]=='angelscity.oldbk.com')  {
		$domen='http://angelscity.oldbk.com/';
	}
	else {
		$domen='http://capitalcity.oldbk.com/';
	}

	if ($telo[hidden]>0) {
		$mm = "<B><i>���������</i></B> [??]<a href=".$domen."inf.php?{$telo['hidden']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � ���������\"></a>";
	} else {
		$mm = "";
		if ($telo['podarokAD'] == 1) {
			$mm .= '<img src="http://i.oldbk.com/i/map/horse_chat.gif" border=0 width=15 height=15>';
		}
		$mm .= "<img src=\"http://i.oldbk.com/i/align_".($telo['align']>0 ? $telo['align']:"0").".gif\">";
		if ($telo['klan'] <> '') {
			$mm .= '<img title="'.$telo['klan'].'" src="http://i.oldbk.com/i/klan/'.$telo['klan'].'.gif">'; }
			$mm .= "<B>{$telo['login']}</B> [{$telo['level']}]<a href=".$domen."inf.php?{$telo['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$telo['login']}\"></a>";
	}
	return $mm;
}


function nick_in_battle_hist ($telo,$kom) {

if ( ($telo[hidden]>0) and ($telo[hiddenlog] =='') )
	{
	$mm = "<B><i>���������</i></B> [??]<a href=inf.php?{$telo['hidden']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � ���������\"></a>";
	}
else
{
$telo=load_perevopl($telo);
$mm .= "<img src=\"http://i.oldbk.com/i/align_".($telo['align']>0 ? $telo['align']:"0").".gif\">";
if ($telo['klan'] <> '') {
			$mm .= '<img title="'.$telo['klan'].'" src="http://i.oldbk.com/i/klan/'.$telo['klan'].'.gif">'; }
			$mm .= "<B>{$telo['login']}</B> [{$telo['level']}]<a href=inf.php?{$telo['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$telo['login']}\"></a>";
}


	$test_battle=mysql_query_cache("select `type` from battle where id='{$telo[battle]}'",false,7200);
	$test_battle=$test_battle[0];

	//����� 3-� ��������� ��� ������ ������ B11 , b12 ,b13
	 if ($test_battle['type']==61 || $test_battle['type']==40 || $test_battle['type']==41)
	 	{
		$kom=10+$kom;
		}



return "<span class=B{$kom}>".$mm."</span>";

}


function nick_in_battle($telo,$kom)
{
	if ( ($telo[hidden]>0) and ($telo[hiddenlog] =='') )
	{
	$login_name='<i>���������</i>';
	}
	else
	if ((strpos($telo[login],"��������� (����" ) !== FALSE ) and ($telo[hiddenlog] =='') )
	 {
	$login_name='<i>'.$telo['login'].'</i>';
	 }
	else
	{
	$telo=load_perevopl($telo);
	$login_name=$telo['login'];
	}


	$test_battle=mysql_query_cache("select `type` from battle where id='{$telo[battle]}'",false,7200);
	$test_battle=$test_battle[0];
	//����� 3-� ��������� ��� ������ ������ B11 , b12 ,b13
	 if (($test_battle['type']==61) OR ($test_battle['type']==40) OR ($test_battle['type']==41) )
	 	{
		$kom=10+$kom;
		}



return "<span class=B{$kom}>".$login_name."</span>";
}

function nick_new_in_battle($telo) //for NEW_LOG
{
$kom=$telo[battle_t];
$K_hnik='';

	if ( ($telo[hidden]>0) and ($telo[hiddenlog] =='') )
	{
	 $telo[sex]=1; $K_hnik='���������';
	}
	elseif ( ($telo[hidden]>0) and ($telo[hiddenlog] !='') )
	{
		$kfake=explode(",",$telo['hiddenlog']);
		$telo['sex'] = $kfake[4];
		$K_hnik=$kfake[1];
	}

	$test_battle=mysql_query_cache("select `type` from battle where id='{$telo[battle]}'",false,7200);
	$test_battle=$test_battle[0];
	//����� 3-� ��������� ��� ������ ������ B11 , b12 ,b13
	 if (($test_battle['type']==61) OR ($test_battle['type']==40) OR ($test_battle['type']==41) )
	 	{
		$kom=10+$kom;
		}

$out=$telo[login]."|".$kom."|".$K_hnik;
return $out;
}

function get_new_dead($telo)
{
if (($telo[hidden]>0) and ($telo[hiddenlog]=='') )
	{
	$telo[sex]=1;
	}
elseif (($telo[hidden]>0) and ($telo[hiddenlog]!='') )
	{
	$ftelo=load_perevopl($telo);
	$telo[sex]=$ftelo[sex];
	}

$xxx=$telo[sex]*100;
$txt=$xxx+mt_rand(1,4);
return $txt;
}

function ToHiddenHTML($telo) {
	if ((($telo['hidden'] > 0) and ($telo['hiddenlog']==''))   || strpos($telo[login],"��������� (����" ) !== FALSE) {
		return "<b><i>".$telo['login']."</i></b>";
	} else {
		return $telo['login'];
	}
}


//////////fnick battle render
function bat_nick_team($telo,$st)
{
global $user;

//���������� ��� ������ - ����� ������ � ��� ��� ����� ����������
if ((($st=='B1') and ($user[battle_t]==1) ) or (($st=='B2') and ($user[battle_t]==2)) or (($st=='B3') and ($user[battle_t]==3))  )
   {
   $out_t=1; //��������� ��� ������� ������ �����
   }
   else
   {
   $out_t=2; //��������� ������� ���������� �� ����� ����� ���� � ���
   }


   if ( ($telo[hidden]>0) and ($telo[hiddenlog] =='') )
   {
	$telo['login']='���������';
	$telo['hp']='??';
	$telo['maxhp']='??';
	$telo['level']='?';
   }
   else
	if (strpos($telo[login],"��������� (����" ) !== FALSE )
		{
		$telo['login']=$telo['login'];
		$telo['hp']='??';
		$telo['maxhp']='??';
		$telo['level']='?';
		}
$telo=load_perevopl($telo);
//if ($telo[razm]==1)
//{
//$telo['login']="<u>".$telo['login']."</u>";
//}
if($telo[lid]==1)
{
$lid="<img src='http://i.oldbk.com/i/leader.gif' width=16 height=19 style='cursor:pointer' title='�����' alt='�����'>";
}
else {$lid='';}



	//����� 3-� ��������� ��� ������ ������ B11 , b12 ,b13
	$test_battle=mysql_query_cache("select `type` from battle where id='{$telo[battle]}'",false,7200);
	$test_battle=$test_battle[0];
	 if ($test_battle['type']==61)
	 	{
		 if ($st=='B1') $st='B11';
		 if ($st=='B2') $st='B12';
		 if ($st=='B3') $st='B13';
		 }



//������ ����� ���� ������ ���� ��������� � ���� 60 61
if ($telo[blow]==1)
  {
  $st='B3';
  }

//$outstring=$lid.(($telo[razm]==1)?"<u>":"")."<span id='".($telo['hidden']>0?$telo['hidden']:$telo['id'])."' ".($out_t==2?"onclick=\"ChangeEnemy('".$telo['login']."');\"":"onclick=\"selectFrend('".$telo['login']."')\"")." oncontextmenu=\"return OpenMenu(event,".$telo['level'].")\" class={$st}>".ToHiddenHTML($telo)."</span>".(($telo[razm]==1)?"</u>":"")." [".$telo['hp']."/".$telo['maxhp']."]";
$outstring=$lid.(($telo[razm]==1)?"<u>":"")."<span id='".($telo['hidden']>0?$telo['hidden']:$telo['id'])."' ".($out_t==2?"onclick=\"ChangeEnemy('".$telo['login']."');\"":"onclick=\"selectFrend('".$telo['login']."')\"")." apidata=\"".($telo['hidden']>0?$telo['hidden']:$telo['id'])."|{$telo['level']}|{$telo['login']}\" oncontextmenu=\"return ".($telo['id']> _BOTSEPARATOR_? "window.open('http://capitalcity.oldbk.com/inf.php?{$telo['id']}','_blank'); ":"OpenMenu(event,".$telo['level'].")")." \" class={$st}>".ToHiddenHTML($telo)."</span>".(($telo[razm]==1)?"</u>":"")." [".$telo['hp']."/".$telo['maxhp']."]";


return $outstring;
}


function mysql_query_100($input)
{
 $counter=0;

 while($counter<100) {
  $q = mysql_query($input);
  if($q) {
   return $q;
  } else {
       $err = mysql_error();
   //addchp('<font color=red>��������!</font> ������ '.$input.'/'.$err,'{[]}Bred{[]}');
   //addchp('<font color=red>��������!</font> ������ '.$input.'/'.$err,'{[]}�������{[]}');
   $counter++;
  }
  }
 if ($counter == 100) return false;
}

function make_record($uid,$pid,$type,$val)
{
$t=time();
$squl="INSERT INTO oldbk.`xml_data` SET `user_id`='{$uid}',`added_at`='".date('Y-m-d', $t)."',`param_id`='{$type}',`value`='{$val}',`pid`='{$pid}',`stamp`='{$t}' ON DUPLICATE KEY UPDATE `value`=`value`+1 ;";
if (mysql_query($squl))
	{
	return true;
	}
	else
	{
	return true;
	}
}

function get_pid($telo)



{
$id=$telo[id];
$squl="select * from oldbk.partners_users where id='{$id}' LIMIT 1;";
$getpaid=mysql_query($squl);
if ( mysql_affected_rows() > 0)
	{
	$array_pidd=mysql_fetch_array($getpaid);
	return $array_pidd;
	}
	else
	{
	return false;
	}
}

function global_nick($id)
 	{
 	$telo = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '{$id}' LIMIT 1;"));
		if ($telo[id]>0)
		{
		return $telo['login'];
		}
		else
		{
		return '';
		}
 	}

//������� �������� �� ��������
function move_to_trup($new_room)
{
	global $user, $rooms;
	$trap = mysql_fetch_array(mysql_query("select * from city_trap where room='{$new_room}' AND target='{$user['id']}' order by id limit 1"));

	if($trap['id']>0)
	{
		// � ������� �������
		// ������� ������ ���� �� 2 ������

		$nomove=2;
		$nomovetime = time()+60*$nomove;
		$trap_owner=check_users_city_data($trap[owner]);

		//mysql_query("update users set hp='{$newhp}', `fullhptime` = ".time()." where id='{$userid}'");
		//$_SESSION['trap_message'] = "<b>�� ������ � �������... �� ������ ��������� {$nomove} �����...</b><br/>";

		telepost_new($user,'<font color=red>��������!</font> �� ������� � ������� ������������ ���������� <B>'.$trap_owner[login].'</b>. �� ������������ �� '.$nomove.' ������...  ');
		telepost_new($trap_owner,'<font color=red>��������!</font> <B>'.((($user['hidden']>0)and($user['hiddenlog']==''))?'<i>���������</i>':$user['login']).'</B> ����� � ���� ������� � ������� '.$rooms[$new_room].'. ����������� �� '.$nomove.' ������...  ');

		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','����','$nomovetime',10);");

		//������������� ����� ��������� ��� - � ������ � ����� ���
		mysql_query("UPDATE users set odate='{$nomovetime}', ldate='{$nomovetime}' where id='{$user['id']}'  LIMIT 1;");

		mysql_query("DELETE from city_trap where id='".$trap[id]."' ;");
	}
	$user['room'] = $new_room;
}

function MoveToLoc($script,$locname,$room,$room_enter = false)
	{
	global $user,$ihave_kost,$array_kost,$array_trv,$perehod,$msg,$typet;

    $perehod = ($room_enter === false) ? 5 : -1; // default 5 ���
//////////////////////
	$count_kost=array_count_values($array_kost);
	if ( $room_enter === false && ($count_kost[501]>0) AND ( in_array(13,$array_trv) OR  in_array(14,$array_trv) ) )
	{
	//��� ������� ������ ������ 1 ������� �������
	$perehod=1440; //24 ���

		if (($count_kost[502]>0) OR ($count_kost[501]>1) )
		{
		// ���� ���� 2-� ������� ������ ��� ��� �������
		$perehod=720; //12 ���
		}
	}
	elseif ( $room_enter === false && ($count_kost[502]>0) AND ( in_array(13,$array_trv) OR  in_array(14,$array_trv) ) )
	{
	//��� ������� ������ + ���� 1 ����������
	$perehod=1080;//18 ���
		if ($count_kost[502]>1)
		{
		//��� ������
		$perehod=540;	//9 ���
		}
	}
	elseif ( $room_enter === false && ($count_kost[501]>0) AND in_array(12,$array_trv) )
	{
	//��� ������� ������ ������ 1 ������� �������
	$perehod=960;//16 ���
		if (($count_kost[502]>0) OR ($count_kost[501]>1) )
		{
		$perehod=480;//8 ���
		}
	}
	elseif ( $room_enter === false && ($count_kost[502]>0) AND in_array(12,$array_trv) )
	{
	//��� ������� ������ + ���� 1 ����������
	$perehod=720;//12 ���
		if ($count_kost[502]>1)
		{
		$perehod=360;//6 ���
		}
	}
	elseif ($room_enter === false && ($count_kost[501]>0) AND in_array(11,$array_trv) )
	{
	//��� ������ ������ ������ 1 ������� �������
	$perehod=480;//8 ���
		if (($count_kost[502]>0) OR ($count_kost[501]>1))
		{
		$perehod=240;//4 ���
		}
	}
	elseif ($room_enter === false && ($count_kost[502]>0) AND in_array(11,$array_trv) )
	{
	//��� ������ ������ + ���� 1 ����������
	$perehod=360; //6 ���
		if ($count_kost[502]>1)
		{
		$perehod=180;//3 ���
		}
	}

 $perehod_bonus=getcheck_mygoto($user);
 $perehod-=($perehod*($perehod_bonus*0.01));

/*if ($user['id']==188)
{
echo "�������:".$perehod;
}
*/

/////////////////////////////////////
	if  ($_SESSION[gotoloc]==0)
		{
		$_SESSION[gotoloc]=time()-($perehod+1); // ������ ������ ��� ��� ����� � ����
		}

	if (($user[id]==3) OR ($user[id]==4))
	{
	//������
	}
	else
	if (($user[klan]!='radminion') AND ($user[klan]!='Adminion') AND ($user[klan]!='testTest'))
		{
			if ((time()-$_SESSION[gotoloc])<=$perehod)
			{
			//err("�� ��� ������!");
			$msg = "�� ��� ������!";
			$typet = "e";
			return false;
			}
		$_SESSION[gotoloc]=time();
		//���������� � ����� ����� - ��� ������ ���� ����� �������� ������ 5 ���

			if ($perehod>5)
			{
			/*
			$fp = fopen ("/www/cache/usertimes/k".$user['id'],"w"); //��������
			flock ($fp,LOCK_EX); //���������� �����
			fputs($fp , $_SESSION[gotoloc]); //������ � ������
			fflush ($fp); //�������� ��������� ������ � ������ � ����
			flock ($fp,LOCK_UN); //������ ����������
			fclose ($fp); //��������
			*/
			}
		}


	//�������� �����������
	if ($room_enter === false && $room==20)
		{
		//� 20-� ����� ������� �� �����
		if (CITY_ID==0) { $away_rooms=array(0,1,2,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18,19,26,25,22,23,35,36,27,42,21,54,55,56,57,66);}
		if (CITY_ID==1) { $away_rooms=array(0,1,2,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18,19,26,25,22,23,35,36,27,21,54,55,56,57);}
		if (CITY_ID==2) { $away_rooms=array(0,1,2,3,4,5,6,7,8,9,10,12,13,14,15,16,17,18,19,26,25,22,23,35,36,27,21,54,55,56,57,66,42);}
		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}
	else
	if ($room_enter === false && $room==21)
	{
		//� 21-� ����� ������� �� �����
		if (CITY_ID==0) { $away_rooms=array(28,31,29,34,200,20); }
		if (CITY_ID==1) { $away_rooms=array(28,31,29,34,200,20,51); }
		if (CITY_ID==2) { $away_rooms=array(28,31,29,34,200,20,51,52,53); }

		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}
	else
	if ($room_enter === false && $room==26)
	{
		//� 26-� ����� ������� �� ����� (��������)
		if (CITY_ID==0) { $away_rooms=array(20,52,53,43,51,50,72,191);}
		if (CITY_ID==1) { $away_rooms=array(20,53,43,42,50,66);}
		if (CITY_ID==2) { $away_rooms=array(20,43,50);}

		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}
	if ($room_enter === false && $room==191)
	{
		//� 191-� ����� ������� �� ����� (����� ��������)
		if (CITY_ID==0) { $away_rooms=array(26);}

		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}
	else
	if ($room_enter === false && $room==50)
	{
		//� 50-� ����� ������� �� �����
		if (CITY_ID==0) { $away_rooms=array(26,48,49,45,999,60); }
		if (CITY_ID==1) { $away_rooms=array(26,48,49,45,999,60,52); }
		if (CITY_ID==2) { $away_rooms=array(26,48,49,45,999,60); }

		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}
	else
	if ($room_enter === false && $room==60)
	{
		//� 66-� ����� ������� �� �����
		$away_rooms=array(50);
		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}
	else
	if ($room_enter === false && $room==66)
	{
	//� 66-� ����� ������� �� �����
		if (CITY_ID==0) { $away_rooms=array(20,47,71,46,70);}
		if (CITY_ID==1) { $away_rooms=array(26,47,71,46,70);}
		if (CITY_ID==2) { $away_rooms=array(20,47,71,46,70);}

		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}
	else
	if ($room_enter === false && $room==200)
	{
		//� 200-� ����� ������� �� �����
		$away_rooms=array(21);
		if (!(in_array($user[room],$away_rooms)))
		{
			//err("��� ������ ��������!");
			$msg = "��� ������ ��������!";
			$typet = "e";
			return false;
		}
	}

	move_to_trup($room);

	mysql_query("UPDATE `users`  SET `users`.`room` = '{$room}' WHERE `users`.`id` = '{$user['id']}' and battle=0 ;");
    if (mysql_affected_rows()>0) {
        if($room_enter === false) {
            echo '<HTML><HEAD><link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css"><meta content="text/html; charset=windows-1251" http-equiv=Content-type><META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store"><meta http-equiv=PRAGMA content=NO-CACHE><META Http-Equiv=Expires Content=0>
		</HEAD><body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0>';

            	if (true)//($user['id']==188)
            		{
            		//������� �����
            		echo "<script>
				location.href='{$script}?p=".$perehod."';
				</script>
			<center><BR><BR><BR><i>{$locname}...</i>";
            		}
            		else
            		{
            		echo "<script>
				function cityg(){
					location.href='{$script}';
				}
				setTimeout('cityg()', ".($user[klan]=='Adminion'||$user[klan]=='radminion'||$user[klan]=='testTest'||$user[id]==3||$user[id]==4?'1':($perehod*1000)).");
			</script>
			<center><BR><BR><BR>
			<i>{$locname}...</i>";
			}

            /*
            if ($user['id']==14897)
            {
                echo "<br> ����� ��������: ".$perehod;
                echo "<br>".$ihave_kost;
                echo "<br> TRV:";
                print_r($array_trv);
                echo "<br>";
                print_r($array_kost);
            }
            */

            echo "</center>
			</body>
			</html>";
        } else {
            global $app;
            try {
                $User = new \components\models\User($user);
                $Quest = $app->quest->setUser($User)->get();
                $Checker = new \components\Component\Quests\check\CheckerEvent();
                $Checker->event_type = \components\Component\Quests\pocket\questTask\EventTask::EVENT_LOCATION_ENTER;

                if(($Item = $Quest->isNeed($Checker)) !== false) {
                    $Quest->taskUp($Item);
                }

            } catch (Exception $ex) {

            }

            header('location: '.$script);
        }

        die();
    } else {
        return false;
    }

}


function progress_bar_city($TTTJ)
	{
	global $perehod;
		if ( (!(isset($perehod))) and (isset($_GET['p'])) )
			{
			$perehod=(int)($_GET['p']);
			}


			if (((time()-$_SESSION[gotoloc])<=$perehod) and $perehod>0)
			{
			$TTTJ=(int)(((time()-$_SESSION[gotoloc])/$perehod)*40);
			//��������� �������
			if ($TTTJ<1) $TTTJ=1;
			}
			else
			{
			//ok
			$TTTJ=40;
			}
			//echo "�������: $perehod <br> ";

			echo '<table align="center" height="27" border=0   cellpadding="0" cellspacing="0" style="background:url(http://i.oldbk.com/i/laba/ramka_s2.gif); background-repeat:no-repeat; background-position:center;width: 135px;">
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
				<div id="showbar" style="font-size:3px;padding:2px;border:solid black 0px;visibility:hidden;width:130px;position: relative; left: 2px; height: 4px;top: -2px;">
				<div style="height:8px;width: 134px;background-color:red;padding:0px;margin:0px;border:solid black 0px;font-size:1px; text-align:left" id="prcont">';
				echo "<span id=\"progress\" style=\"width:0%;height:100%;padding:0px;margin:0px;background-color:green;position: absolute;\" >&nbsp;&nbsp;</span></div>\n";


			echo '</div></td><td>&nbsp;&nbsp;</td></tr></table>
			<script language="javascript">';
			echo "var progressEnd = 100;";
			echo "var progressColor = 'green'; "; // set to progress bar color




			//$tik=100; //1 ���
			//echo ((time()-$_SESSION[gotoloc]));
			$tik=(int)(($perehod/100)*1000); // ����� ���������� ������� �� ������� ��������


			echo "var progressInterval = ".$tik.";";

			echo "var progressAt = ".$TTTJ.";";
			echo "var progressTimer;";

			echo "
			function progress_set(st) {
			document.getElementById('progress').style.width = st ? st + '%' : '1';
			}





			function progress_update() {
			document.getElementById('showbar').style.visibility = 'visible';
			progressAt++;
					if (progressAt > progressEnd)
						{
						clearTimeout(progressTimer);
						return;
						}
					else progress_set(progressAt);
			progressTimer = setTimeout('progress_update()',progressInterval);
			}


			";



			echo "progress_set(".$TTTJ."); \n";
			echo "progress_update(); \n";
			echo "</script>";

	}

//������� ����������� / ������������� ���� ����� � ���� � to_pal.php

	function GetSalt(&$salt,$len) {
		$ret = substr($salt,0,$len);
		$salt = substr($salt,$len);
		return $ret;
	}

	function codein($input) {
		$input = strval($input);
		$salt = "b42q9y";
		$salt = sha1($input.$salt).sha1($input.$input.$salt).sha1($input.$salt.sha1($input));
		$salt = preg_replace('~[a-z]~iU','',$salt);

		$kol=strlen($input);
		$input=strrev($input);
		$to_out = "";
		$c=0;
		for ($x=0; $x<$kol; $x++) {
 			$c++;
			if ($c==1)  { $to_out.=GetSalt($salt,1).$input[$x]; }
			else  if ($c==2)  { $to_out.=GetSalt($salt,2).$input[$x]; }
			else  if ($c==3)  { $to_out.=GetSalt($salt,3).$input[$x]; $c=0;}
		}
		return $to_out;
	}

	function decodein($input) {
		$kol=strlen($input);
		$to_out = "";
		$c=0;
		for ($x=0; $x<$kol; $x++) {
 			$c++;
			if ($c==1)  { $x++; $to_out .= $input[$x];}
			else  if ($c==2)  { $x+= 2; $to_out .= $input[$x];}
			else  if ($c==3)  { $x+= 3; $to_out .= $input[$x]; $c=0;}
		}
		return strrev($to_out);
	}

	function xorit($input) {
		for ($i = 0; $i < strlen($input); $i++) {
			$input[$i] = chr(ord($input[$i]) ^ 0xAF);
		}
		return base64_encode($input);
	}

	function dexorit($input) {
		$input = base64_decode($input);
		for ($i = 0; $i < strlen($input); $i++) {
			$input[$i] = chr(ord($input[$i]) ^ 0xAF);
		}
		return $input;
	}

	function can_hill($telo) {

	if ($telo[battle]>0)
				{
				$addsql="and battle='{$telo[battle]}' ";
				$get_baff_714=mysql_fetch_array(mysql_query("select * from effects where owner='{$telo[id]}' ".$addsql." and type='714' ; "));
				 if ($get_baff_714[id] > 0)
				 	{
				 	return true;
				 	}
				 	else
				 	{
				 	return false;
				 	}
				}
				else
				{
			 	return false;
			 	}
	}

	function drop_card($user)
	{
	//////���������� ���������
	include("cards_config.php");
	include("fdroplist_113010.php");
	 if ((time()>$coll3_start) and (time()<$coll3_end))
		{
     	  		$ke=mt_rand(0,7);
			$param=$carditems[$ke];
			if ($param['shop']=='') { $param['shop']='shop'; }

		     	$dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`{$param['shop']}` WHERE `id` = '{$param['id']}' LIMIT 1;"));
			if ($dress['id']>0)
			{

			//�������� �� ������� ��� ���������
				if ( ($dress['id']>=111001  and $dress['id']<=111009) OR ($dress['id']>=112001  and $dress['id']<=112007) OR ($dress['id']>=113001  and $dress['id']<=113008) OR ($dress['id']>=114001  and $dress['id']<=114008) )
				{
				//���� ������ ������ ����� , �� ��������� ������� �� � ��������

						$test_count = mysql_fetch_assoc(mysql_query("SELECT count(id) as k FROM oldbk.`inventory`  WHERE owner='{$user['id']}' and  prototype = '{$dress['id']}'  "));

					if ($test_count ['k']>=10)
						{
						return false;
						}

				}


			$dress['dategoden'] = $coll3_end;
			$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}



											if (mysql_query("INSERT INTO oldbk.`inventory`
											(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
												`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
												`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`letter`
											)
											VALUES
											('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$param['cost']},'{$dress['img']}',{$param['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
											'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$param['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$param['present']}','{$param['labonly']}','0','{$dress['group']}','{$user['id_city']}','{$dress['letter']}'
											) ;") )
										     {
										     		$dress['id']=mysql_insert_id();
										     		$dress['idcity']=$user['id_city'];
										     		//new delo
												$rec['owner']=$user['id']; $rec['owner_login']=$user['login'];
												$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];

												if ($user['battle']>0)
												{
												$rec['target']=0;$rec['target_login']='���';
												$rec['type']=60;//������� � ���
												$at=' � ��� ';
												}
												else
												{
												$rec['target']=0;$rec['target_login']='���������';
												$rec['type']=6660;//������� � ���
												$at='';
												}

												$rec['sum_kr']=0; $rec['sum_ekr']=0;
												$rec['sum_kom']=0; $rec['item_id']=get_item_fid($dress);
												$rec['item_name']=$dress['name'];
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
												$rec['battle']=$user['battle'];
												add_to_new_delo($rec);
										   		addchp ('<font color=red>��������!</font> �� ��������'.$at.' <b>'.$dress['name'].'</b> ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
											     }
										}



		     	 }
			/////////////////

	}



function get_rabota_boni_lvls($telo)
{

$get_lvl=$telo['level'];

if ($get_lvl<7) $get_lvl=7;
if ($get_lvl>14) $get_lvl=14;

//��� 1-7 �������,
$bron_kof[7]=array(
          25=>30,
          30=>35,
          35=>40,
          40=>50,
          45=>60,
          50=>70,
          55=>80,
	);

//2. ��� ���������� 8-�� ������ (�������� 75 ������������),
$bron_kof[8]=array(
          25=>30,
          30=>30,
          35=>35,
          40=>40,
          45=>45,
          50=>50,
          55=>55,
          60=>60,
          65=>65,
          70=>70,
          75=>75,
          80=>80);

//3. ��� ���������� 9-�� ������,
$bron_kof[9]=array(
          25=>30,
          30=>30,
          35=>35,
          40=>40,
          45=>45,
          50=>50,
          60=>55,
          70=>60,
          80=>65,
          90=>70,
          100=>75,
          125=>80,
	);

//4. ��� ���������� 10-�� ������,
$bron_kof[10]=array(
          25=>30,
          30=>30,
          40=>35,
          50=>40,
          60=>45,
          70=>50,
          80=>55,
          95=>60,
          105=>65,
          115=>70,
          125=>75,
          150=>80);


//5. ��� ���������� 11-�� ������,
$bron_kof[11]=array(
          25=>30,
          30=>30,
          40=>35,
          50=>40,
          60=>45,
          70=>50,
          80=>55,
          90=>60,
          110=>65,
          130=>70,
          150=>75,
          175=>80,
	);


//6. ��� ���������� 12-�� ������,
$bron_kof[12]=array(
          25=>30,
          30=>30,
          40=>35,
          60=>40,
          80=>45,
          100=>50,
          120=>55,
          130=>60,
          145=>65,
          160=>70,
          175=>75,
          200=>80,
	);

//7. ��� ���������� 13 �������,
$bron_kof[13]=array(
          25=>30,
          30=>30,
          40=>35,
          60=>40,
          80=>45,
          100=>50,
          120=>55,
          140=>60,
          160=>65,
          180=>70,
          200=>75,
          225=>80,
	);


//8. ��� ���������� 14 �������,
$bron_kof[14]=array(
          25=>30,
          30=>30,
          50=>35,
          75=>40,
          100=>45,
          125=>50,
          150=>55,
          175=>60,
          200=>65,
          225=>70,
          250=>75,
          275=>80,
	);



$bron_kof=$bron_kof[$get_lvl];
krsort($bron_kof);


foreach($bron_kof as $vinos=>$kof)
		{
			if ($telo['vinos']>=$vinos) {

				/*if ($telo['uclass'] != 3 && $telo['in_tower'] == 0 && $telo['lab'] == 0) {
					$kof = $kof / 1.15;
				}*/

				$outk=round($kof/100,2);
				return  $outk;
			}
		}

return 0.3; //��������
}

function get_rabota_boni($telo)
{
$bron_kof=array(
						25=>30,
						50=>35,
						75=>40,
						80=>41,
						85=>42,
						90=>43,
						95=>44,
						100=>55,
						105=>56,
						110=>57,
						115=>58,
						120=>59,
						125=>60,
						150=>65,
						155=>66,
						160=>67,
						165=>68,
						170=>69,
						175=>70,
						200=>80,
						225=>85,
						250=>90,
						275=>95,
						300=>100);

krsort($bron_kof);

/*if ($telo['room']==44)
					{
					echo $telo['login']."/vinos/".$telo['vinos']."/<br>";
					}
*/
foreach($bron_kof as $vinos=>$kof)
		{
			if ($telo['vinos']>=$vinos)
				{
				$outk=round($kof/100,2);
				/*
				if ($telo['room']==44)
					{
					echo "RKF=".$outk."<br>";
					}
				*/
				return  $outk;
				}
		}
/*
if ($telo['room']==44)
	{
	echo "!RKF=0.3<br>";
	}
*/
return 0.3; //��������
}

function find_items_timeout($telo)
{
//���� ����� ������� ������ ����� ��������
$query = mysql_query("SELECT *, count(id) as kol FROM oldbk.`inventory` WHERE owner='{$telo['id']}' and `dategoden` > 0 and `dategoden` <= UNIX_TIMESTAMP()+(24*60*60) group by prototype ");
$mtext=array();
while($it = mysql_fetch_assoc($query))
	{
	$kol_string='';

			if ($it['kol']>1)
			{
			$kol_string='('.$it['kol'].'��.) ';
			}

	$mtext[]=' �'.link_for_item($it).'� '.$kol_string.'- ������� �������� ����� <b>'.prettyTime(null,$it['dategoden']).'</b>';
	}

	if (count($mtext)>0)
		{
		telepost_new($telo,'<font color=red>��������!</font> ������������� ���� �������� ���������:'.implode(",",$mtext));
		return true;
		}
return false;
}


function do_present_items($telo)
{
if ($telo['level']<=7)
	{
		if (time()-$telo['ldate']>=(30*24*60*60))
		{
		//30 ����
		$getitems='';

		$getitems1=DropBonusItem(105103,$telo,'�����','����� �� �����������',0,1,20,false,true);	 //		     ������ ������� 1 ��.
		if ($getitems1!='') { $getitems=$getitems1;}

		$getitems2=DropBonusItem(4005,$telo,'�����','����� �� �����������',3,1,20,false,true);	 //		     ����� ������ �������� � �������� 1 ��. (���� �������� 3 ���)
		if ($getitems2!='') {$getitems.=" � ".$getitems2; }

		if ($getitems!='')
			{
			telepost_new($telo,'<font color=red>� ������������!</font> �� �������� � ������� '.$getitems.', �������� ��������� � ��� � ���������. ������� ����!');
			return true;
			}
		}
	}
return false;
}


function get_gerb($t=0)
{
global $user, $gerb_cost , $gerb2_cost;

if ($t==2)
	{
	$gcost=$gerb2_cost;
	$gtype=5100;
	}
	else
	{
	$gcost=$gerb_cost;
	$gtype=5000;
	}

if ($gcost[$user[level]] > 0 )
 {

 $dress=mysql_fetch_assoc(mysql_query("select * from oldbk.shop where id={$gtype} "));
  $dress[cost]=$gcost[$user[level]];
if ( ($user[money]>=$dress[cost]) AND ($dress[id]>0))
   {


   if(mysql_query("INSERT INTO oldbk.`inventory`
					(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,`idcity`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`present`,
						`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str."
					)
					VALUES
					('{$dress['id']}','{$_SESSION['uid']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}','{$user[id_city]}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
					'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','���������'
					,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}' ".$sql."
					) ;"))
					{
					if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com')  { $cnis='cap'; }   else if ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com')  { $cnis='ava'; }
					$dressid .= $cnis."".mysql_insert_id().",";
					$dresscount="(x1) ";
					echo "<font color=red><b>�� ������ 1 ��. \"{$dress['name']}\".</b></font>";
					mysql_query("UPDATE `users` set `money` = `money`- '".($dress['cost'])."' WHERE id = {$user['id']} ;");

					//new delo
					$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user[money];
					$user['money'] -= $dress['cost'];
					$rec['owner_balans_posle']=$user[money];
					$rec['target']=0;
					$rec['target_login']='���������';
					$rec['type']=1;//�������
					$rec['sum_kr']=$dress[cost];
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;
					$rec['item_id']=$dressid;
					$rec['item_name']=$dress['name'];
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
					add_to_new_delo($rec);


					}
					else {
					//echo mysql_error();
						$good = 0;
					}







   }
   else
   {
   echo "<font color=red>� ��� �� ������� �������� �� ������� ���������� �����</font>";
   }
  }
  else
  {
  echo "<font color=red>��� ��� ��� ���������� �����!</font>";
  }
echo "<br><br>";
return ;
}

function gift_from_item_break($telo,$row)
{
	//������ ���������
	if ( ($row['prototype']>=410130) AND ($row['prototype']<=410135) )
		{
		/*
			���� �������� ��� ����������
		     ����������� ������ ��������������� 90 ����� PROTO_ID:319
		     ����������� ������ ��������������� 180 ����� PROTO_ID:320
		     ����������� ������ ��������������� 360 ����� PROTO_ID:321
		     ����������� ������ ������������� PROTO_ID:119119120
		     ����������� ������ �������������� PROTO_ID:120120121
		     ����������� ������ ��������������� 180HP� PROTO_ID:200279
		     ������� ������ ��������� ���� PROTO_ID:100420
		     ������� ������ ���� ������ PROTO_ID:100430
		*/
			$gift_conf=array(319,320,321,119119120,120120121,200279,100420,100430);
			shuffle($gift_conf);
			$gift=$gift_conf[0];

			$info="��� �����: {$row['id']}/{$row['name']}";
			//��� ������� �� ������ �������� 7 ����, �������� �� ����������, ������ ����� � ���
			$txt=DropBonusItem($gift,$telo,'����������',$info,7,1,20,false,true,699,'shop',false,false);
			if ($txt!=false)
				{
				addchp("<font color=red>��������!</font> ��� <b>�".link_for_item($row)."�</b> ���������� � � ������� �������� ��������� �� �������� ���������� �� {$txt}.",'{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);
				return true;
				}
		}
return false;
}

function put_bonus_item($id,$telo,$pres,$delo_base = array(),$dressover = array())
{
	$mgs=0; //default sys-message
	$retid=0;
	$need_fix_nlevel=0;
	$dress['getfrom']=57; //		57 => '������� ������� � ���' ,

	if ((is_array($pres)) and ($pres['name_bot']!='') )
	{
		$mgs=3;
		$scroll_bot_name=$pres['name_bot']; // ���������� �������� ���� ��� ��������

		$config_scrols[122121]=133131;
		$config_scrols[122122]=133132;
		$config_scrols[122123]=133133;
		$config_scrols[122124]=133134;

		$id=$config_scrols[$pres['used_proto']]; // ���������� �� ������ ��� �����

		$need_fix_nlevel=$pres['level_bot']-1;

		unset($pres); // ������ ������ �� ��������
	}

	$q = mysql_query("SELECT * FROM oldbk.shop WHERE id = '{$id}' ");
	$dress = mysql_fetch_assoc($q);
	if ($dress['id']>0)
	{

		if ($mgs==3)
		{
			$pres = '';
		}
		elseif($pres === false)
		{
			$pres = '';
		} elseif($pres == '')
		{
			$pres = '�����';
		}

		if ($dress['id']==4016)
		{
			$dress['goden']=7;
		}



		if ( ($pres=='�������') and ($id==12001) )
		{
			$dletter=array('� �������!!! �������� ���� � ���� ������� � ����������� �����������',
				'� "������" - ������ ������ ��������. (�����)',
				'� �������� ���������� - �������!',
				'� ��� � ������� ������� � ��� �������� � ���������!',
				'� ����� ����? �, ���� �����?',
				'� ���! �������-�� �������������������������!',
				'� ����������� �������� - �������!!!',
				'� � ������� ���� ����� ������� ������. � ����������� ���� ����� ������� �������.',
				'� ���� ������� ������������ ��� ����������!',
				'� � ������� ���� �� ������ ������ ���� �������, ����� ������� �� ����� �� ���������!',
				'� ��� ��� � �����: �� ������� �� �������....',
				'� ���� � ����������� ����� �������, � ������ � ����� � ������ - ������������.',
				'� ��� ����� �������� � ������! ���� ����� � ������� ����� �� ���� ������� � ������� � ��� ��� ��������!',
				'� ������� ������ �� �����.',
				'� ��������� ������� �������� "�������"....����������� 3 ���.',
				'� ������� ������������ ���� ������. ������ �� ���� ��� ���������� �� ������������!!!',
				'� ������ � ������� ����� ����� ��������: � �������� - ���� �����.',
				'� ����� �������: ��� ����� �������!',
				'� ���� ������������ ��������, ��� ������, ���������� � ����� ������ �������.',
				'� ��� �� �������� �� ������ ��������� ����� � ���� �������!',
				'� ���� ����� ���, ��� ����� ������ ���� �������.');

			shuffle($dletter);
			$dress['letter']=$dletter[0];
			$dress['goden']=180;
			$dress['add_time']=time();
			$mgs=1;
		}
		elseif ( ($pres=='�������') and ($id==33008) )
		{
			$mgs=2;
		}

		$dress['dategoden']=(($dress['goden'])?($dress['goden']*24*60*60+time()):"");

		if (count($dressover)) {
			reset($dressover);
			while(list($k,$v) = each($dressover)) {
				$dress[$k] = $v;
			}
		}

		if ($need_fix_nlevel>0)
		{
			$dress['nlevel']=$need_fix_nlevel;
		}

		if (mysql_query("INSERT INTO oldbk.`inventory`
							(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`img_big`,`maxdur`,`isrep`,`letter`,`add_time`,`notsell`,
								`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
								`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`rareitem`,`getfrom`
							)
							VALUES
							('{$dress['id']}','{$telo['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}','{$dress['img_big']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['letter']}','{$dress['add_time']}', '{$dress['notsell']}', '{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
							'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$pres}','0','0','{$dress['group']}','{$telo['id_city']}','{$dress['rareitem']}', '{$dress['getfrom']}'
							) ;") )
		{

			$dress['id']=mysql_insert_id();
			$retid=$dress['id'];
			$dress['idcity']=$telo['id_city'];
			//new delo
			$rec = array();
			$rec['owner']=$telo['id']; $rec['owner_login']=$telo['login'];
			$rec['owner_balans_do']=$telo['money'];$rec['owner_balans_posle']=$telo['money'];
			$rec['target']=0;$rec['target_login']='���';
			$rec['type']=60;//������� � ���
			$rec['sum_kr']=0; $rec['sum_ekr']=0;
			$rec['sum_kom']=0; $rec['item_id']=get_item_fid($dress);
			$rec['item_name']=$dress['name'];
			$rec['item_count']=1;
			$rec['item_type']=$dress['type'];
			$rec['item_proto']=$dress['prototype'];
			$rec['item_cost']=$dress['cost'];
			$rec['item_ecost']=$dress['ecost'];
			$rec['item_dur']=$dress['duration'];
			$rec['item_maxdur']=$dress['maxdur'];
			$rec['item_ups']=0;
			$rec['item_unic']=0;
			$rec['item_incmagic']='';
			$rec['item_incmagic_count']='';
			$rec['item_arsenal']='';
			$rec['battle']=$telo['last_battle'];
			if ($pres!='�����' && $pres != '')
			{
				$rec['add_info']='������ '.$pres;
			}
			if($delo_base) {
				$rec = array_merge($rec, $delo_base);
			}

			add_to_new_delo($rec);
			if ($mgs==1)
			{
				addchp ('� ����� ��������� ������ � ������� �� ������ ������, �� ������� ������������ ��������. �������� ���� � ����, �� ������� ���������� �������! ��������: �'.link_for_item($dress).'� 1 ��.','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);
			}
			elseif ($mgs==2)
			{
				addchp ('� ������� ���!� - ����������� �������, � ��������� �� ������ ������ ������ ����� � ��� � ����! ��������: �'.link_for_item($dress).'� 1 ��.','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);
			}
			elseif ($mgs==3)
			{
				addchp ('�����������! �� ������� ������� <b>'.$scroll_bot_name.'</b>, ������ �'.link_for_item($dress).'� �������� � ��� ���������.','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);
			}
			else
			{
				addchp ('<font color=red>��������!</font> �� �������� � ��� �'.link_for_item($dress).'� ','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);
			}
		}
	}

	return $retid;
}

function log_cancel_delo($telo,$eff)
{
//������� ������ ��������� �������� (������� 29 �����)
//new delo
$rec = array();
$rec['owner']=$telo['id']; $rec['owner_login']=$telo['login'];
$rec['owner_balans_do']=$telo['money'];$rec['owner_balans_posle']=$telo['money'];
$rec['target']=0;$rec['target_login']='������';
$rec['type']=7777; // ������
$rec['add_info']=$eff['name'].'/'.($eff['time']-time());
add_to_new_delo($rec);
}

?>
