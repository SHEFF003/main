<?
//��������� ��� ����
///////////////////////////

    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {
    $miniBB_gzipper_encoding = 'x-gzip';
    }
    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    $miniBB_gzipper_encoding = 'gzip';
    }
    if (isset($miniBB_gzipper_encoding)) {
    ob_start();
    }
    function percent($a, $b) {
    $c = $b/$a*100;
    return $c;
    }
//////////////////////////////


$gerb_cost[6]=2.5;
$gerb_cost[7]=5;
$gerb_cost[8]=10;
$gerb_cost[9]=15;
$gerb_cost[10]=20;
$gerb_cost[11]=25;
$gerb_cost[12]=30;
$gerb_cost[13]=35;
$gerb_cost[14]=60;
$gerb_cost[21]=60;


$gerb2_cost[6]=10;
$gerb2_cost[7]=15;
$gerb2_cost[8]=25;
$gerb2_cost[9]=35;
$gerb2_cost[10]=50;
$gerb2_cost[11]=65;
$gerb2_cost[12]=80;
$gerb2_cost[13]=95;
$gerb2_cost[14]=130;
$gerb2_cost[21]=130;


/*
 ��������� ������ ������ ����� ��� 7-10 ������� = 0,5���
 ��������� ������ ����� ��� 11+ ������� = 1 ���.
*/
$place_cost[6]=0.5;
$place_cost[7]=0.5;
$place_cost[8]=0.5;
$place_cost[9]=0.5;
$place_cost[10]=0.5;
$place_cost[11]=1;
$place_cost[12]=1;
$place_cost[13]=1;
$place_cost[14]=2;

function have_test_gerb($telo)
{
//��������� ����� ����� ����
$out=array();
$gerbs=mysql_query("select prototype, count(id) as kol from oldbk.inventory where owner='{$telo['id']}' and prototype in (5000,5100) and setsale=0 group by prototype ;");
	while($row = mysql_fetch_array($gerbs)) 
	{
	$out[$row['prototype']]=$row['kol'];
	}
return $out;
}


function my_gerb_select($telo)
{
$out=array();
	if ($telo['id_grup']>0)
	{
	$get_zay=mysql_fetch_array(mysql_query("select * from tur_stat where id='{$telo['id_grup']}' and  start=0 ; "));	
		if ($get_zay['id']>0)
			{
				if ($get_zay['u1']==$telo['id']) 
					{ 
					$out['poz']=1;
					$out['gerb_sele']=$get_zay['use_gerb1'];
					return $out;
					}
				if ($get_zay['u2']==$telo['id'])
					{ 
					$out['poz']=2;
					$out['gerb_sele']=$get_zay['use_gerb2'];
					return $out;
					}
				if ($get_zay['u3']==$telo['id'])
					{ 
					$out['poz']=3;
					$out['gerb_sele']=$get_zay['use_gerb3'];
					return $out;
					}
			}
	}
	
return false;
}


function del_gerb($zay,$u)
{
$uu='u'.$u;
$uid=$zay[$uu]; 

$gerb='use_gerb'.$u;

$telo=mysql_fetch_assoc(mysql_query("select * from  users where id='{$uid}' ;"));

if ($telo[id]>0)
	{
	//$ger_select=my_gerb_select($telo); //����� ���� ������
	//������ ����� ���� ������������ ������
	if ($zay[$gerb]==1)
			{
			$dress=mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where owner='{$telo[id]}' and prototype=5000 and setsale=0 limit 1;")); // �������
			}
			
	if (($zay[$gerb]==2) OR (!($dress[id]>0)) )
			{
			$dress=mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where owner='{$telo[id]}' and prototype in (5100,5000) and setsale=0 order by prototype DESC limit 1;")); // �2
			}

	if ($dress[id]>0)
		{
		mysql_query("delete from oldbk.inventory where id='{$dress[id]}' ;");
		if (mysql_affected_rows() >0)	
			{
					$rec['owner']=$telo[id]; 
					$rec['owner_login']=$telo[login];
					$rec['owner_balans_do']=$telo[money];
					$rec['owner_balans_posle']=$telo[money];					
					$rec['target']=0;
					$rec['target_login']='���������';
					$rec['type']=256;
					$rec['sum_kr']=$dress[cost];
					$rec['sum_ekr']=0;
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
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					add_to_new_delo($rec);
				if ($dress['prototype']==5100)
				{
				//������� + ���� ������  �� 1 ���
				mysql_query("UPDATE users set expbonus=expbonus+'1' where id='{$telo[id]}' ; ");		
				mysql_query("INSERT INTO `effects` SET `type`='5100',`name`='��������� ���� (x2)', add_info='1'  ,`time`='1999999999', `owner`='{$telo[id]}' ");
				}
					
			}
		}
	}
}



		session_start();
		if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die();}
		include ("connect.php");		
		include "functions.php";
		if (($user['battle']>0) OR ($user['battle_fin'] >0) OR  ($user[room]!=240) ) { header("Location: fbattle.php"); die(); }
		
		$llevl=(int)($_GET[lvl]);
		if (!(($llevl > 6 ) and ($llevl < 14 )))
		  { 
		  $llevl=$user[level];
		  }   
		  
		  
		 $place_cost=$place_cost[$user['level']];
		 if ($place_cost<=0) { $place_cost=1; }
		  
	 	if (($_GET['exit']) and  ($user[battle]==0) and ($user[room]==240))
		{
		
		if ($user['id_grup'] >0 )
			{
				
			$test_tur = mysql_fetch_array(mysql_query("SELECT * FROM `tur_stat` WHERE `id` = '".$user['id_grup']."' ;"));
				if ($test_tur['id']>0)
					{
					$errm='<font color=red>�� � ������ �� ������! �� �� ������ �������� �������!</font>';
					}
					else
					{
					mysql_query("UPDATE `users` SET  `room` = '200' , `id_grup`=0  WHERE  `users`.`id`  = '{$user[id]}' ;");
					header('location: city.php?strah=1&tmp=0.984564546654433177');
					die();	
					}
			}
			else
			{
			mysql_query("UPDATE `users` SET `users`.`room` = '200' WHERE  `users`.`id`  = '{$user[id]}' ;");
			header('location: city.php?strah=1&tmp=0.984564546654433177');
			die();
			}
		}
		  
function money_back($telo,$price,$kol)
{

$place_summ=$price*$kol;
								if ($_SESSION['bankid']>0)
								{
									$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' and owner='{$telo['id']}' ;"));
								}
								else
								{
									//�� ���� �� ���������
									$bank = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$telo['id']}' order by def desc,id limit 1"));
								}
								if ($bank['id']>0) 
									{
											mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` +  '".$place_summ."' WHERE `id`= '".$bank['id']."' LIMIT 1;");
											if (mysql_affected_rows() >0)	
											{										
											
												//new_delo
										  		    			$rec['owner']=$telo[id]; 
															$rec['owner_login']=$telo[login];
															$rec['owner_balans_do']=$telo['money'];
															$rec['owner_balans_posle']=$telo['money'];
															$rec['target']=0;
															$rec['target_login']='���������';
															$rec['type']=1324;
															$rec['sum_ekr']=$place_summ;
															$rec['bank_id']=$bank['id'];
															add_to_new_delo($rec); //�����
															$bank['ekr']+=$place_summ;
															mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','������� ������ ���. ���� � ��������� <b>{$place_cost} ���.</b> <i>(�����: {$bank['�r']} ��., {$bank['ekr']} ���.)</i>','{$bank['id']}');");														
															err('������ ��������� '.$place_summ.' ���. �� ���� �'.$bank['id'].' ');
											}
									}
									else
									{
									err('���� ��� ������� �� ������!');
									}
								
								

}

		  
function del_telo_from_zay($telo,$poz,$up=true)
{
	if ($up)
	{
		if ($poz==1)
			{
			//���� ������� ������ �� ������ ��� ���� ���������� �����
			mysql_query("UPDATE `tur_stat` SET u2=0 , `group`=replace (`group`,' <font color=green>����� ��������</font>, ','')   WHERE `id`='{$telo[id_grup]}' and  start=0 and u2=1 ");				
			mysql_query("UPDATE `tur_stat` SET u3=0 , `group`=replace (`group`,' <font color=green>����� ��������</font> ','')   WHERE `id`='{$telo[id_grup]}' and  start=0 and u3=1 ");							
			}
	
		mysql_query("UPDATE `tur_stat` SET u{$poz}=0, use_gerb{$poz}=1 , `group`=replace (`group`,' ".nick_hist($telo).",','')   WHERE `id`='{$telo[id_grup]}' and  start=0 ");	
	
	
	}
	else
	{
	mysql_query("DELETE from `tur_stat` WHERE `id`='{$telo[id_grup]}' and  start=0 ");	
	}
	
	if (mysql_affected_rows() >0)	
	{
	mysql_query("UPDATE users set  id_grup=0 where id='{$telo[id]}' ;");
	return true;
	}
	else
	{
	return false;
	}
}
		  


function load_mass_items_by_id_c($telo)
{

//��������� ������ ��� ����� ����� � �������� � ������ ����� ���� ��������
// ����������� ����� ���� ����� ��� �������� � �����������
$query_telo_dess =mysql_query_cache("SELECT * FROM oldbk.inventory WHERE dressed = 1 AND `type`!=12 AND owner ={$telo[id]} ",false,24*3600);

	$telo_magicIds   = array();
	$telo_magicIds[] = 0;
	$telo_wearItems  = array();

////////////////////////////////
	$totsumm=0;
$telo_wearItems[krit_mf]=0;
$telo_wearItems[akrit_mf]=0;
$telo_wearItems[uvor_mf]=0;
$telo_wearItems[auvor_mf]=0;
$telo_wearItems[bron1]=0;
$telo_wearItems[bron2]=0;
$telo_wearItems[bron3]=0;
$telo_wearItems[bron4]=0;
$telo_wearItems[min_u]=0;
$telo_wearItems[max_u]=0;
$telo_wearItems[allsumm]=0;
$telo_wearItems[ups]=0;
$telo_wep[mast]=0;
$telo_wearItems[�hem]='';

//// ��� ����� ����� ��������� ��� ���� ��� ����
/// � ���� ����� ������� ���� ���������� ��� ����������� ������
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//while($row = mysql_fetch_assoc($query_telo_dess)) {
	while(list($k,$row) = each($query_telo_dess)) {	
	    $telo_wearItems[$row['id']] = $row;
	        $totsumm+=$row['cost'];
	$telo_wearItems[krit_mf]+=$row[mfkrit];
	$telo_wearItems[akrit_mf]+=$row[mfakrit];
	$telo_wearItems[uvor_mf]+=$row[mfuvorot];
	$telo_wearItems[auvor_mf]+=$row[mfauvorot];
		$telo_wearItems[bron1]+=$row[bron1];
		$telo_wearItems[bron2]+=$row[bron2];
		$telo_wearItems[bron3]+=$row[bron3];
		$telo_wearItems[bron4]+=$row[bron4];
	$telo_wearItems[min_u]+=$row[minu];
	$telo_wearItems[max_u]+=$row[maxu];
		$telo_wearItems[ups]+=$row[ups];

		if($row['includemagic'] > 0) {
	        $telo_magicIds[] = $row['includemagic'];
		}
		// �� �� �����
		if ($row[id]==$telo[weap])
		 	{
			$telo_wep=load_wep($row,$telo);
		 	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	} // end of while
//////////////////////////////////////////////////////////////////////////////////////////////////////
	$telo_wearItems[allsumm]=$totsumm; // �������� ����� ��������� ����� ������
	//fix ���� ����� � ������ �� ���� ����������
		if (($telo[weap]==0) and (!$telo_wep))
		 	{
		 	$kulak[otdel]=0;
		 	$telo_wep=load_wep($kulak,$telo);
		 	}
//////////////////////////////////////////////////////////////////////////////////////////////////////
	// ������� ���������� ��� - ���� ���� ��� ����
	$telo_wearItems[min_u] = round((floor($telo['sila']/3) + 1) + $telo['level'] + $telo_wearItems[min_u] * (1 + 0.07 * $telo_wep[mast]));
	$telo_wearItems[max_u] = round((floor($telo['sila']/3) + 4) + $telo['level'] + $telo_wearItems[max_u] * (1 + 0.07 * $telo_wep[mast]));
//////////////////////////////////////////////////////////////////////////////////////////////////////
// ��������� ��������� �� ������
 	$telo_wearItems[�hem]=$telo_wep[chem];
 	$telo_wearItems[mast]=$telo_wep[mast];
///  fix �� ������ ������ ��� ������� ������� �� ����� //////////////////////////////////
	if($telo_wearItems[�hem] == 'kulak' && (int)$telo['level'] < 4)
				{
					$telo_wearItems[min_u] += 3;
					$telo_wearItems[max_u] += 6;
				}
////////// ����� � ������� ��������� ���������� + ���� �������	////////////////////////
	if($telo_wearItems[�hem] == 'kulak' && (int)$telo['align'] ==2)
				{
					$telo_wearItems[min_u] += $telo[level];
					$telo_wearItems[max_u] += $telo[level];
				}
///////////////////////////////////////////////////////////////////////////////////
///�������� �������� ��� ����� ���������
//	$query_telo_mag = mysql_query("SELECT * FROM magic WHERE id IN (" . implode(", ", $telo_magicIds) . ")");
//	while($row = mysql_fetch_assoc($query_telo_mag)) {
//	    $telo_magicItems[$row['id']] = $row;
//	}
//////////////////////////////////////////////////////////////////////////////////
	$telo_wearItems[incmagic]=$telo_magicItems;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return $telo_wearItems;
}
		  
// ������ ������ + ��������������� ����������
function load_wep($r_wep,$telo)
{
$tout= array();
// ���� ������� ����� . �� �� �����
switch($r_wep['otdel'])
			 	{
			 	case 0:
			 		{
			 	//�����
				$tout[chem]='kulak';
				$tout[mast]=0;
			 		}
				break;
				########

			 	case 1:
			 		{
			 	//���� �������
				$tout[chem]='noj';
				$tout[mast]=$telo[noj];
			 		}
				break;
				########
		 		case 6:
			 		{
			 		if ( ($r_wep[type]==3) and   ($r_wep[prototype]>=55510301) and ($r_wep[prototype]<=55510401))
			 			{
						$tout[chem]='elka';
						$tout[mast]=$telo[noj];
						   if ($tout[mast]<$telo[topor]) { $tout[mast]=$telo[topor];}
						   if ($tout[mast]<$telo[dubina]) { $tout[mast]=$telo[dubina];}
						   if ($tout[mast]<$telo[mec]) { $tout[mast]=$telo[mec];}
			 			}
					else
					if ( ($r_wep[type]==3) and (($r_wep[prototype]==169) OR ($r_wep[prototype]==170) or ($r_wep[prototype]==600) or ($r_wep[prototype]==601)))
				 		{
						$tout[chem]='meshok';
						$tout[mast]=0;
						}
			 		else
				 		{
						$tout[chem]='buket';
						$tout[mast]=0;
				 		}
			 		}
				break;
				########
		 		case 11:
			 		{
			 	//������
				$tout[chem]='topor';
				$tout[mast]=$telo[topor];
			 		}
				break;
				########
		 		case 12:
			 		{
			 	//������
				$tout[chem]='dubina';
				$tout[mast]=$telo[dubina];

			 		}
				break;
				########
		 		case 13:
			 		{
			 	//����
				$tout[chem]='mec';
				$tout[mast]=$telo[mec];

			 		}
				break;
		 		case 14:
			 		{
			 	//���
				$tout[chem]='luk';
				$tout[mast]=0; // ���

			 		}
				break;


			 	}

	if($telo[id_user]==88)
	{
	//������
	$tout[chem]='loshad';
	$tout[mast]=0;
	}

return $tout;
}


//if ($user[klan]=='radminion') { echo "Admin-info:<!- GZipper_Stats -> <br>";  }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="windows-1251">
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
    <title>Old BK - �������: ��������� ��������.</title>
    <link rel="StyleSheet" href="newstyle_loc4.css" type="text/css">
    <script type="text/javascript" src="/i/globaljs.js"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


	<SCRIPT LANGUAGE="JavaScript">
	function refreshPeriodic()
				{
				location.href='restal240.php?onlvl=<?=$onlvl;?>';//reload();
				timerID=setTimeout("refreshPeriodic()",30000);
				}
				timerID=setTimeout("refreshPeriodic()",30000);
	</SCRIPT>
    
</head>
<body>
<?
make_quest_div(true);
?>

<div id="page-wrapper">
    <div class="title">
        <div class="h3">
            �������: ��������� ��������.
        </div>
        <div id="buttons">
            <a class="button-dark-mid btn" href="javascript:void(0);" title="���������" onclick="window.open('help/r240.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes');">���������</a>
            <a class="button-mid btn" href="javascript:void(0);" title="��������" onclick="location.href='restal240.php?refresh=<?echo mt_rand(1111,9999);?>';" >��������</a>
            <a class="button-mid btn" href="javascript:void(0);" title="���������" onclick="location.href='restal240.php?exit=true';" >���������</a>            
        </div>
    </div>
    <div id="ristal"><br>
        <table cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="60%">
                <col width="40%">
            </colgroup>
            <tbody>
            <tr>
                <td>
                    <div>
                        <strong>� ���� ���� ������� ����������� ������������ ������ "�������������� �������" ��������� �� ����� 180HP !!!</strong>
                    </div>
                    <div class="top-info">
	<?
	if (($_POST['getgerb']) and ($user[align]!=4) )
		{
		 get_gerb();
		}
	elseif (($_POST['getgerb2']) and ($user[align]!=4) )
		{
		 get_gerb(2);
		$_GET['sgerb']=2; //����� ������ ���
		}
	
	

	$load_have=have_test_gerb($user);//����� ���� �����
	$ger_sele=my_gerb_select($user); // ����� ������

	if (!(isset($_SESSION['use_gerb'])))
	{
		if (isset($ger_sele['gerb_sele']))
			{
			$_SESSION['use_gerb']=$ger_sele['gerb_sele'];
			}
			else
			{
			$_SESSION['use_gerb']=1;
			}
	}	


					
			 			if ((isset($_GET['sgerb'])) and (($load_have[5000]>0) or ($load_have[5100]>0))  )
			 				{
			 				$setgerb=(int)$_GET['sgerb'];
			 				if (($setgerb==1) or ($setgerb==2))
			 					{
			 						if (($ger_sele['poz']>=1) and ($ger_sele['poz']<=3) )
			 						{
					 				mysql_query("UPDATE  tur_stat  set use_gerb{$ger_sele['poz']}={$setgerb}  where id='{$user['id_grup']}' and  start=0 and u{$ger_sele['poz']}='{$user['id']}' and use_gerb{$ger_sele['poz']}!={$setgerb} ;");
			 						if (mysql_affected_rows() >0)	
	 									{
	 									$ger_sele['gerb_sele']=$setgerb;
	 									}
	 								}
								$_SESSION['use_gerb']=$setgerb;
	 							}
			 				}


	if ($gerb_cost[$user[level]] > 0)
	 {
	 echo '                        <img src="http://i.oldbk.com/i/sh/fg1.gif">';
	 
	 
	 
	 	if ($load_have[5000]>0)
	 	{
	 	//���� ���� � �������

			
				if ($_SESSION['use_gerb']==1)
	 			{
	 			//������ ��� �������������
	 			echo "<span style=\"padding:6px;padding-top:6px;position:relative;top:-6px;\">������ <b>��������� ���� </b></span>";
	 			}	
	 			else
	 			{
	 			//�� ������
			 	echo ' <a href="javascript:void(0);" class="button-sbig btn" title="������� ��������� ����" onClick="location.href=\'restal240.php?sgerb=1\';" >������� ��������� ����</a>';	 	
			 	}
	 	}
	 	else
	 	{
	 	echo '                        
	 	<form method=post name=fby style="position: absolute;"><input type=hidden name="getgerb" value="true"></form><a href="javascript:void(0);" class="button-sbig btn" title="������ ��������� ���� '.$gerb_cost[$user[level]].'��" onClick="document.fby.submit();"  >������ ��������� ���� '.$gerb_cost[$user[level]].'��</a>
	 	';
	 	}
	 }
	 
	if ($gerb2_cost[$user[level]] > 0)
	 {
	 echo '                        <img src="http://i.oldbk.com/i/sh/fg2.gif">';
	 
	 	if ($load_have[5100]>0)
	 	{
				if ($_SESSION['use_gerb']==2)
			 			{
			 			//������ ��� �������������
			 			echo "<span style=\"padding:6px;padding-top:6px;position:relative;top:-6px;\">������ <b>��������� ���� (x2)</b></span>";
			 			}	
			 			else
			 			{
			 			//�� ������
					 	echo ' <a href="javascript:void(0);" class="button-sbig btn" title="������� ��������� ���� (x2)" onClick="location.href=\'restal240.php?sgerb=2\';" >������� ��������� ���� (x2)</a>';	 	
					 	}	 	
	 	}
	 	else
	 	{
		 echo ' <form method=post name=fby2 style="position: absolute;"><input type=hidden name="getgerb2" value="true"></form> <a href="javascript:void(0);" class="button-sbig btn" title="������ ��������� ���� (x2) '.$gerb2_cost[$user[level]].'��" onClick="document.fby2.submit();"  >������ ��������� ���� (x2) '.$gerb2_cost[$user[level]].'��</a>';
		 }
	 }	

	echo '</div>';


		
	//echo "<div align=left><P>&nbsp;<H4>������� ������� � �������:</H4></div>";
	echo $errm;
	
	$need_bat=10;
	$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND type=9105 ;")); // �������� ������?
	if ($eff[id]>0)
	 {
	  $need_bat=(int)($need_bat-($need_bat*$eff[add_info]));
	  }
	  
	  
	 $testrist=mysql_fetch_array(mysql_query("select * from oldbk.ristalka where owner={$user['id']}"));
	 if ($testrist['chaos']<$need_bat)
	 {
	  echo "<font color=red>�� ������ �������� \"��������� ��������.\"  ����� ".($need_bat-$testrist['chaos'])." ����������� ����!</font>";
	 }
	elseif ($user[hidden]>0)
	{
		echo "<font color=red><b>��������� �� ����� ��������� �������...</b></font>";		
	}
	elseif ($user[align]==4)
	{
	echo "<font color=red><b>���� �� ����� ��������� �������...</b></font>";
	}
	else if (($user[level] >= 7 ) and ($user[level] <= 13 )) 
	{
	//���� ��� ����
		
		//��������� �������� ������
		 if (($_POST[mknew]) and ($user[id_grup]==0) )
		 	{
		 	//�������
			if ($_POST[nazv])
				{
				
			$_POST[naz]=str_replace('|=|','| = |',$_POST[naz]);
			$_POST[naz]=str_replace(':',' ; ',$_POST[naz]);
			$_POST[naz]=str_replace('�','',$_POST[naz]);
			$_POST[naz]=str_replace('�','',$_POST[naz]);
				
				$nazv="����� �".htmlspecialchars($_POST[nazv])."� ".nick_hist($user).",";
				$mkpas=htmlspecialchars($_POST[mkpas]);
				$mkcom=htmlspecialchars($_POST[mkcom]);
				
				if (isset($_SESSION['use_gerb']))
					{
					$ugr=(int)$_SESSION['use_gerb'];
					}
					else
					{
					$ugr=1;
					}
				
				mysql_query("INSERT INTO `tur_stat` SET `group`='".mysql_real_escape_string($nazv)."',`u1`={$user[id]} , use_gerb1={$ugr} ,`lvl`={$user[level]},`pas`='".mysql_real_escape_string($mkpas)."',`com`='".mysql_real_escape_string($mkcom)."';");
				if ($user[id]==188)
					{
					echo mysql_error();
					}
				if (mysql_affected_rows() >0)
					{
					$newid_grup=mysql_insert_id();
					mysql_query("UPDATE users set  id_grup='{$newid_grup}' where id='{$user[id]}' ;");					
					echo "<font color=red><b>������ �������!</b></font><br>";										
					$user[id_grup]=$newid_grup;
					}
					else
					{
					echo "<font color=red><b>������ �������� ����� ������!</b></font><br>";					
					}
				}
				else
				{
				echo "<font color=red><b>������� �������� ����� ������!</b></font><br>";
				}
		 	}
		 	else if (($_POST[exzay]) and ($user[id_grup]>0))
		 	{
		 		//���� ������
		 		$get_zay=mysql_fetch_array(mysql_query("select * from tur_stat where id='{$user[id_grup]}' and  start=0 ; "));
		 		if ($get_zay[id]>0)
		 			{
		 			// ���� ������
		 			      if ( ($get_zay[u2]==$user[id]) AND ( ($get_zay[u1]>0) OR ($get_zay[u3]>0)) )
		 				{
		 				 if (del_telo_from_zay($user,2,true)) { $user[id_grup]=0; }
		 				}
		 			elseif ( ($get_zay[u3]==$user[id]) AND ( ($get_zay[u1]>0) OR ($get_zay[u2]>0)) )
		 				{
		 				 if ( del_telo_from_zay($user,3,true) ) { $user[id_grup]=0; }
		 				}
		 			elseif ( ($get_zay[u1]==$user[id]) AND ( ($get_zay[u2]>1) OR ($get_zay[u3]>1)) )
		 				{
//echo "55";		 				
		 					if ( del_telo_from_zay($user,1,true) ) 
		 							{
		 							$user[id_grup]=0; 
		 							
		 							//������� �����
				 				 	$bck_kol=0;
				 				 	if ($get_zay[u2]==1) $bck_kol++;
				 				 	if ($get_zay[u3]==1) $bck_kol++;
					 				money_back($user,$place_cost,$bck_kol);		 				 		
		 							
		 							}
		 				}
		 			elseif ( ($get_zay[u1]==$user[id]) AND ($get_zay[u2]<=1) AND ($get_zay[u3]<=1) )
		 				{
		 				 if ( del_telo_from_zay($user,1,false) ) 
		 				 		{ 
		 				 		$user[id_grup]=0; 

									//������� �����
				 				 	$bck_kol=0;
				 				 	if ($get_zay[u2]==1) $bck_kol++;
				 				 	if ($get_zay[u3]==1) $bck_kol++;
					 				money_back($user,$place_cost,$bck_kol);		 				 		
		 				 		}
		 				 

		 				}		 				
		 			elseif ( ($get_zay[u2]==$user[id]) AND ($get_zay[u1]<=1) AND ($get_zay[u3]<=1) )
		 				{
		 				 if ( del_telo_from_zay($user,2,false) ) { $user[id_grup]=0; }
		 				}		 				
		 			elseif ( ($get_zay[u3]==$user[id]) AND ($get_zay[u1]<=1) AND ($get_zay[u2]<=1) )
		 				{
		 				 if ( del_telo_from_zay($user,3,false) ) { $user[id_grup]=0; }
		 				}		 				
		 			}
		 	}
		 	elseif ( ($_POST[gogr]) AND ($user[id_grup]==0) AND ((int)($_POST[grz])>0  ) )
		 	{
		 		$grz=(int)($_POST[grz]);
//print_r($_POST);
		 		if ($_POST[turpass]) { $turpass=htmlspecialchars($_POST[turpass]); } else {$turpass='';}
		 		$get_test=mysql_fetch_array(mysql_query("select * from tur_stat where id='{$grz}' and  start=0 and (u1=0 or u2=0 or u3=0) and lvl={$user[level]} ; "));
		 		 if (($get_test[id]>0) and ($get_test[pas]==mysql_real_escape_string($turpass)) )
		 		 	{
		 		 		if ($get_test[u1]==0)
		 		 		{
		 		 		mysql_query("UPDATE `tur_stat` SET `u1`='{$user[id]}' , use_gerb1='{$_SESSION['use_gerb']}' , `group`=CONCAT(`group`,' ".nick_hist($user).",')  WHERE id='{$grz}' and u1=0;");
		 		 		}
		 		 		elseif ($get_test[u2]==0)
		 		 		{
		 		 		mysql_query("UPDATE `tur_stat` SET `u2`='{$user[id]}' , use_gerb2='{$_SESSION['use_gerb']}' ,  `group`=CONCAT(`group`,' ".nick_hist($user).",')  WHERE id='{$grz}' and u2=0;");		 		 		
		 		 		}
		 		 		elseif ($get_test[u3]==0)
		 		 		{
		 		 		mysql_query("UPDATE `tur_stat` SET `u3`='{$user[id]}' , use_gerb3='{$_SESSION['use_gerb']}' , `group`=CONCAT(`group`,' ".nick_hist($user).",')  WHERE id='{$grz}' and u3=0;");
		 		 		}
		 		 		
		 		 		echo mysql_error();
		 		 		
		 		 		if (mysql_affected_rows() >0)
		 		 			{
		 		 			mysql_query("UPDATE users set  id_grup='{$grz}' where id='{$user[id]}' ;");					
							echo "<font color=red><b>�� ����� � ������!</b></font><br>";										
							$user[id_grup]=$grz;
		 		 			}
		 		 	}
		 		 	else
		 		 	{
					echo "<font color=red><b>�������� ������!</b></font><br>";												 		 	
		 		 	}
		 	}
		 	elseif (($_POST[startr]) and ($user[id_grup]>0) and ($user[battle]==0) )
		 	{
		 	//����� ������!!!
		 		$get_test=mysql_fetch_array(mysql_query("select * from tur_stat where id='{$user[id_grup]}' and  start=0 and u1='{$user[id]}' and u2>0 and u3>0  and lvl={$user[level]} ; "));
		 		if ($get_test[id]>0)
		 		{

		 		///�������� � ���� �� ���� ����
		 		//����������� ����� ��� �����
		 		//$chiters=mysql_query("select * from users u where id in ({$get_test[u1]},{$get_test[u2]},{$get_test[u3]}) and 5000 not in (select prototype from oldbk.inventory where owner=u.id and setsale=0) ");
		 		$chiters=mysql_query("select * from users u where id in ({$get_test[u1]},{$get_test[u2]},{$get_test[u3]}) and id not in (select owner from inventory where prototype in (5000,5100) and owner=u.id and setsale=0)");		 		
		 		
		 		if (mysql_num_rows($chiters)>0)
				{

				//���� ����� ������
					while($gorow=mysql_fetch_array($chiters))
						{
			        		addchp ('<font color=red>��������!</font><b> ������ �� ����� ��������! � ��� ��� ���������� �����!</b>','{[]}'.$gorow['login'].'{[]}',$gorow[room],$gorow[id_city]);
			        		echo "<font color=red>������ �� ����� ��������! � <b>{$gorow['login']}</b>, ��� ���������� �����!</font><br> ";
						}
				}
				else
				{

		 		//���� ��� �� - ����� � ������� �������
			 		mysql_query("UPDATE tur_stat  SET start=-1 where  id='{$user[id_grup]}' and  start=0 and u1='{$user[id]}' and u2>0 and u3>0    ");
		 			if (mysql_affected_rows() >0)
		 			{
		 			
		 			//������� �� 1 �� �����
		 			if ($get_test[u1]>0) {	del_gerb($get_test,1); }
		 			if ($get_test[u2]>0) {	del_gerb($get_test,2); }
		 			if ($get_test[u3]>0) {	del_gerb($get_test,3); }
		 			
		 			if ($get_test[u1]==370710) 
		 				{
		 				//setup test config for start
		 				$TEST_CONF=true;
		 				//set up testflag
		 				mysql_query("UPDATE `tur_stat` SET `testflag`=1 WHERE `id`='{$get_test[id]}' ");
		 				}
		 			
		 			
		 			//������� ���
		 			$tima1="";
		 			$tempm=explode("�",$get_test[group]);
		 			$tima1_data=$tempm[0]."� |=|";
		 			$tima1_html=$tempm[0]."� ";
		 			
		 			$get_team_1=mysql_query("select * from users where id in ({$get_test[u1]},{$get_test[u2]},{$get_test[u3]}) ");
					while($telo_t1=mysql_fetch_array($get_team_1))
					{
					$tima1.=$telo_t1[id].";";
					$tima1_data .= BNewHist($telo_t1);
					$tima1_html .=nick_align_klan($telo_t1).", ";
					
						//������ ��� � ������ ���� ����
						if ( ($telo_t1[runa1]>0) OR  ($telo_t1[runa2]>0) OR  ($telo_t1[runa3]>0) )
							{
							//���� ���� ���� ���� ���� �� �����
							 if ($telo_t1[runa1]>0)
							 	{
							 	  if (dropitemid_telo(31,$telo_t1)) {$telo_t1[runa1]=0; }
							 	}
							 if ($telo_t1[runa2]>0)
							 	{
							 	if (dropitemid_telo(32,$telo_t1)) {$telo_t1[runa2]=0; }
							 	}
							 if ($telo_t1[runa3]>0)
							 	{
							 	if (dropitemid_telo(33,$telo_t1)) {$telo_t1[runa3]=0; }
							 	}
							 ref_drop_telo($telo_t1) ;								 								
							}
					
					}
				        $tima1 = substr($tima1, 0, -1); 
				        $tima2_hmtl= substr($tima2_html, 0, -2);	
		 			
		 			$c=0;
					$id_bot=array();
					$bot_team_sql=''; 
					$bots_names=''; 
					$bots_names_chat='';
					$bot_team='';
					
					if ($TEST_CONF==true)
					{
					include "config240_test.php";					
					}
					else
					{
					include "config240.php";
					}
					
					$mobot=240+$get_test[lvl];
					$moboa=$monstro[$mobot][1];
			foreach ($moboa as $k=>$v)
			{
			for ($l=0;$l<$v;$l++)
				{
				$c++;
				$BOT=mysql_query_cache("SELECT * from `users` where `id`='".$k."' ;",false,24*3600);
				$BOT = $BOT[0];					
				$BOT['login'].=" (k�o� ".$c.")";
				$BNAME=BNewHist($BOT);
				$BNAME_chat=nick_hist($BOT);
				$BOT_items=load_mass_items_by_id_c($BOT);
				
				mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
					`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
					`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
					`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
					`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
					`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
					`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
					`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`=1,`bot`=1,
					`id_user`='{$BOT['id']}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
					`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
					`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
					`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
					`injury_possible`=0, `battle_t`=2;");
				$id_bot[$c]=mysql_insert_id();
				
				if ($bot_team!='') 
							{
							$bots_names.=$BNAME;
							$bots_names_chat.=", ".$BNAME_chat;
							$bot_team.=";".$id_bot[$c];
							$bot_team_sql.=",".$id_bot[$c];
							}
							else
							{
							$bots_names=$BNAME;
							$bots_names_chat=$BNAME_chat;							
							$bot_team=$id_bot[$c];
							$bot_team_sql=$id_bot[$c];
							}			
				}
			
			}//����
					
					//������� ��� � ����������� status=1
					mysql_query("INSERT INTO `battle` (`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`win`,`t1hist`,`t2hist`)
						VALUES
						(NULL,'��������� ������','','3','{$mobot}','1','{$tima1}','".$bot_team."','".time()."','".time()."',3,'".$tima1_data."','{$bots_names}')");
					$id_battl=mysql_insert_id();					
					
					// �������� �����
					mysql_query("UPDATE `users_clons` SET `battle` = {$id_battl} WHERE `id` in (".$bot_team_sql.") ");				
					// ������� ���
					$rr = "<b>".$tima1_html."</b> � <b>".$bots_names_chat."</b>";
					addch ("<a href=logs.php?log=".$id_battl." target=_blank>���</a> ����� <B><b>".$tima1_html."</b> � <b>".$bots_names_chat."</b> �������.  ",$mobot,$user[id_city]);
					
					//������� � ������ ������� - ������ � ���������� \n
					//addlog($id_battl,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����.\n");
					addlog($id_battl,"!:S:".time().":".$tima1_data.":".$bots_names."\n");
					
					//��������� ����� ��� 
					mysql_query("UPDATE users SET `battle` ={$id_battl},`zayavka`=0, `battle_t`=1, room='{$mobot}'  WHERE  id in ({$get_test[u1]},{$get_test[u2]},{$get_test[u3]}) and  id_grup={$get_test[id]} ");
					
					//��������� ����� ��� +fix hp
					mysql_query("UPDATE users SET `hp` =10 WHERE  id in ({$get_test[u1]},{$get_test[u2]},{$get_test[u3]}) and  hp=0 ");
					
					//�������� ������ ������ �� �������� � ����� 1 � ������� ������ � ������
					mysql_query("UPDATE tur_stat  SET `battle` ={$id_battl},`volna`=1 , `c`={$c} , start=1  WHERE `id`= '{$get_test[id]}';");				
					
					//����������� ���
					mysql_query("UPDATE battle SET  `status`=0 where id={$id_battl} ");
					
					//���������� ��������� ��������
					$mesgrp=array($get_test[u1],$get_test[u2],$get_test[u3] );
					addch_group('<font color=red>��������!</font> ��� ��� �������! <BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ', $mesgrp);
					
					header('location: fbattle.php'); 
					
		 			}
		 		   }	
		 		}
		 		else
		 		{
				echo "<font color=red><b>������ ������ �� �������!</b></font><br>";												 		 			 		
		 		}
		 	}
		 	
	?>

                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr class="head-line">
                            <th>
                                <div class="head-left"></div>
                                <div class="head-title">������� ������� � �������</div>
                                <div class="head-right"></div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="even">
	<?
		if (isset($_POST['place']))
			{
				if (true)//($user['prem']==3)
					{
					if (($_POST['place']==2) or ($_POST['place']==3) )
						{
							if ($_SESSION['bankid']>0)
								{
								//���� ���� - ������
									$bank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id` = '".$_SESSION['bankid']."' and owner='{$user['id']}' ;"));
										if ($bank['id']>0) 
										{

											if ( $bank['ekr'] >=$place_cost)
												{
										 		$get_test=mysql_fetch_array(mysql_query("select * from tur_stat where id='{$user[id_grup]}' and  start=0; "));
										 			
									 			if (($get_test['id']>0) and ($get_test['u2']==0) and ($_POST['place']==3) ) { $_POST['place']=2; } //���� �� ��������� 2-� � ������ �� 3-�
										 		
												
												
												if ($_POST['place']==2)
													{
													mysql_query("UPDATE `oldbk`.`tur_stat` SET `u2`  =1, `group`=CONCAT(`group`,' <font color=green>����� ��������</font>, ')   WHERE id='{$user['id_grup']}' and `u2` =0  and u1='{$user['id']}' and start=0 ");
													}
													else
													{
													mysql_query("UPDATE `oldbk`.`tur_stat` SET `u3`  =1, `group`=CONCAT(`group`,' <font color=green>����� ��������</font> ')   WHERE id='{$user['id_grup']}' and `u3` =0  and u1='{$user['id']}' and start=0 ");
													}

												if (mysql_affected_rows() >0)	
												{
												mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` -  '".$place_cost."' WHERE `id`= '".$_SESSION['bankid']."' LIMIT 1;");
													if (mysql_affected_rows() >0)	
														{
															//new_delo
										  		    			$rec['owner']=$user[id]; 
															$rec['owner_login']=$user[login];
															$rec['owner_balans_do']=$user['money'];
															$rec['owner_balans_posle']=$user['money'];
															$rec['target']=0;
															$rec['target_login']='���������';
															$rec['type']=1323;
															$rec['sum_ekr']=$place_cost;
															$rec['bank_id']=$_SESSION['bankid'];
															add_to_new_delo($rec); //�����
															$bank['ekr']-=$place_cost;
															mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','������ ������ ����� � ��������� <b>{$place_cost} ���.</b> <i>(�����: {$bank['�r']} ��., {$bank['ekr']} ���.)</i>','{$_SESSION['bankid']}');");														

															err('������ ��������� ���� �����!');
														}
												}
												
												}
												else
												{
												err("� ��� �� ����� ������������ �������!");
												}
										}
								}
								else
								{
								//�������� � ����
								err("<b>�������������� � ���� ��� �����������...</b>");
								echo "<script>window.location.href='bank.php?exit=1&tmp=".(mt_rand(111111,999999))."';</script>";
								}
						}
					}
					else
					{
					err('<b>�������� ����� ����� ������ ��� ������� <a href="http://oldbk.com/encicl/?/prem.html" target="_blank">Platinum-��������.</a></b>');
					}	
						
			}


		//���������
		if ($user[id_grup]>0)
			{
			//��� � ������
			//��. �����	
			echo '
			<td>			
			<form method=post action="restal240.php" name="zdel">
			<input type=hidden name=exzay value="yes">
			<a href="javascript:void(0);" class="button-big btn" title="����� �� ������" onClick="document.zdel.submit();"  >����� �� ������</a></form>
			</td>';
			}
			else
			{
			//��� ���
			//��. �������
			?>
			    <td>
			    <form method=post action="restal240.php" name="znew">
                                ��������: <input type="text" name="nazv" size="20"> �����������: <input type="text" name="mkcom" size="15"> ������: <input type="text" name="mkpas" size="10"> 
                                <input type="hidden" name="mknew" value="new">
                                <a href="javascript:void(0);" class="button-big btn" title="������� ������" onClick="document.znew.submit();"  >������� ������</a>
                                </form>
                            </td>
			<?
			}
		echo '</tr>
		 <tr class="odd">
                            <td>
                                <ul>';
		/////////////
		//��������� ������ ������ �� �������
		{ $lvlf="and lvl='{$user[level]}'"; }
		
		$get_all_zay=mysql_query("select * from tur_stat where start=0 {$lvlf} ORDER BY id DESC  ;");
		   if (mysql_num_rows($get_all_zay)  > 0)
		   {
		   while($grow=mysql_fetch_array($get_all_zay))
			{
			echo '<li>';
			$grow[group]= substr($grow[group], 0, -1); 
			
			if ($user[id_grup]>0) { $print_btn=false; } else {$print_btn=true;}
			if (($grow[u1]>0) AND ($grow[u2]>0) AND ($grow[u3]>0) ) { $print_btn=false; $group_ok=true; } else { $group_ok=false; }
				
				if  ($print_btn)
				{
				echo "<form method=post action='restal240.php' name='lin{$grow['id']}'>";
				echo "<input type=hidden name=grz value='$grow[id]'>";
				echo "<img src='http://i.oldbk.com/i/fighttype250.gif'> ";
				echo "<b>".$grow[group]."</b> ";
				 if ($grow[com]!='') { echo $grow[com]; }
				if ($grow[pas]!='') { echo " <input type=text name=turpass size=10;>"; }
				echo ' <input type=hidden name=gogr value="yes">
			            <a class="button-mid btn" href="javascript:void(0);" title="�����" onClick="document.lin'.$grow['id'].'.submit();"  >�����</a>            
					</form>';
				}
				else
				{
					 if (($grow[id]==$user[id_grup]) and ($group_ok) and ($grow[u1]==$user[id]) ) 
					 	{
					 	 echo "<form method=post action='restal240.php' name=\"tbstart\" id=\"tbstart\">"; 
					 	}
 					elseif (($grow[id]==$user[id_grup]) and ($grow[u1]==$user[id]) and ($grow[u2]==0||$grow[u3]==0) )
 						{
 							 echo "<form method=post action='restal240.php' name=\"bynp\" id=\"bynp\">"; 
 						}	
					 	
				
				echo "<img src='http://i.oldbk.com/i/fighttype250.gif'> ";
				echo "<b>".$grow[group]."</b> ";
				 if ($grow[com]!='') { echo $grow[com]; }				
				 
				 if (($grow[id]==$user[id_grup]) and ($group_ok) and ($grow[u1]==$user[id]) ) 
				 	{
				 	echo ' <input type=hidden name=startr value="yes"> <a class="button-mid btn" href="javascript:void(0);" title="������" onClick="document.tbstart.submit();"  >������</a>'; 
					echo "</form>"; 	 	 			            
				 	}
				 	elseif (($grow[id]==$user[id_grup]) and ($grow[u1]==$user[id]) and ($grow[u2]==0||$grow[u3]==0) )
 						{
						echo ' <input type=hidden name=place id=place value=""> ';
 							if ($grow[u2]==0) 
 								{
 								echo ' <div class="button-sbig btn" href="javascript:void(0);" title="�������� ����� �� '. $place_cost.' ���" onClick="document.getElementById('."'place'".').value=2;document.bynp.submit();"  >�������� ����� �� '. $place_cost.' ���</div>'; 
 								}

 							if ($grow[u3]==0) 
 								{
								echo' <div class="button-sbig btn" href="javascript:void(0);" title="�������� ����� �� '. $place_cost.' ���" onClick="document.getElementById('."'place'".').value=3;document.bynp.submit();"  >�������� ����� �� '. $place_cost.' ���</div>'; 
 								} 								
 						echo "</form>";
 						}	
				 	elseif  ($group_ok) { echo " <i>(������ �������)</i>"; }
				 	

				 	
				}
			echo "</li>";
			}
		   }
		   else
		   {
		   echo '
		    <li>
                                        <strong>��� ��� ��� ��������� ������</strong>
                    </li>';
		   }
		   echo '</ul>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <em>��� �� ������� ������� � ��������, ��� ����� ��������� ����, �� ��������� ���� (�2) �� ��������� � 2 ���� ������ �����!</em>
                            </td>
                        </tr>
                        </tbody>
                    </table>
		   ';
	}
	else
	{
	echo "<font color=red><b>��� �� ��������  \"��������� ��������\". </b></font> ";
	}
	
	echo '   <div class="info" style="color: red;" >
                        ��������! ��� ������ ���������� ������� ���� ������������� ����� ����� � ���������.<br>
                        ���������, ��� ���� ���� ����� ������ ��� �� ������, � �� �������� ������ ���� ����� ������ �� �������!
                    </div>';
		
//����������
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*

	echo "<div align=right><form method=POST action='restal240.php'> 
	<INPUT TYPE=\"button\" value=\"���������\" style=\"background-color:#A9AFC0\" onclick=\"window.open('help/r240.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')\">
	<input type=button value='��������' onClick=\"returned2('refresh=3.14&');\">&nbsp;<INPUT TYPE=submit value=\"���������\" name=exit></form></div>";
	
	if ($gerb_cost[$user[level]] > 0)
	 {
	 echo "<form method=GET action='restal240.php'><INPUT TYPE=button value=\"������ ���������� ���� ".$gerb_cost[$user[level]]." ��.\" style=\"background-color:#A9AFC0 \" onClick=\"returned2('getgerb=true&');\"></form>";
	 }
	if ($gerb2_cost[$user[level]] > 0)
	 {
	 echo "<form method=GET action='restal240.php'><INPUT TYPE=button value=\"������ ���������� ���� (�2)� ".$gerb2_cost[$user[level]]." ��.\" style=\"background-color:#A9AFC0 \" onClick=\"returned2('getgerb2=true&');\"></form>";
	 }	 
	*/
		if (($llevl > 6 ) and ($llevl < 14 )) 
		{
		  $nazv=$llevl.'-� ������ '; $skl=' type = '.(240+$llevl).'  '; 
		  } 
		  else 
		  { 
		  $ob=1; $nazv='����� �����'; $skl=' type >240 and type <269 '; 
		  }
	
	
	?>
                </td>
                <td align='center'><img src='http://i.oldbk.com/i/images/ristal/bg_groups80.jpg' alt='' title='' style="height:250px; width:325px"></td>
           </tr>
           <tr>
           <td colspan="2">
                    <table class="table" cellspacing="0" cellpadding="0">
                        <colgroup>
                            <col>
                            <col width="32px">
                            <col width="32px">
                            <col width="32px">
                            <col width="40px">
                            <col width="40px">
                            <col width="40px">
                            <col width="35px">
                        </colgroup>
                        <thead>
                        <tr class="head-line">
                            <th>
                                <div class="head-left"></div>
                                <div class="head-title">���������� 10-�� ���������� ��������: <span id="top10-title"><?=$nazv;?></span></div>
                                <div class="head-separate"></div>
                            </th>
                            <?
				for ($il=7;$il<=13;$il++) 
				{
				echo '<th>
                        		        <div style="padding-left: 0;" class="head-title">
                        	        	    <a class="top10-tab ';
				if ($llevl==$il)  echo 'active';
                        	        	echo '" data-for="top10-'.$il.'" title="'.$il.'" href="?lvl='.$il.'">['.$il.']</a>
                	        	        </div>
        	                        <div class="head-';
        	                        if ($il==13) {echo 'right';} else { echo 'separate';}
        	                        echo '"></div>
	                            </th>';					  
				  } 
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="even">
                            <td colspan="8">
                                <ul class="top10 active" id="top10-7">
                                    
                                    <?
	
					if (($user[klan]=='radminion') OR ($user[klan]=='pal'))
					{
					$lim='LIMIT 50';
					}
					else {	$lim='LIMIT 10';}
					
					//��� �� ����� ���� ������ �����
					$filt[0]=37224;
					$filt[1]=24934;	
					
					$tr = mysql_query("SELECT * FROM `tur_logs` WHERE  ".$skl." and active=0 and id>'{$filt[$user[id_city]]}'  ORDER BY end_time DESC ".$lim.";");
					if (mysql_num_rows($tr) > 0)
					{
					$kk=1;
					while ($trow = mysql_fetch_array($tr)) 
							{
							if ($trow['winer']=='') {$trow['winer']='<i>��� ����������</i>';} else 
							{
							$trow['winer']= substr($trow['winer'], 0, -1); 
							}
							if ($ob==1) { $dop=$trow['type']-240; $dop='['.$dop.']'; }
							
							
			                                echo '<li>
			                                        <div class="num"><small>'.$kk++.'.</small></div> <div class="date">'.date("d.m.y H:i",$trow['gotime']).'</div><div><small>'.$dop.''.$trow['winer'].'. ������: <div class="date">'.date("d.m.y H:i",$trow['start_time']).'</div>
			                                            �����: <div class="date">'.floor(($trow['end_time']-$trow['start_time'])/60/60).' �. '.floor(($trow['end_time']-$trow['start_time'])/60-floor(($trow['end_time']-$trow['start_time'])/60/60)*60).' ���.</div>
			                                            <a href="/turlog.php?id='.$trow['id'].'" target="_blank"><strong>>>></strong></a></small>
			                                        </div>
			                                    </li>';
							
//							echo "<LI><FONT class=date>".date("d.m.y H:i",$trow['gotime'])."</FONT> - ���������� ".$dop.":".$trow['winer']." ������ ������� <FONT class=date>".date("d.m.y H:i",$trow['start_time'])."</FONT> ����������������� <FONT class=date>".floor(($trow['end_time']-$trow['start_time'])/60/60)." �. ".floor(($trow['end_time']-$trow['start_time'])/60-floor(($trow['end_time']-$trow['start_time'])/60/60)*60)." ���.</FONT> <A HREF=\"/turlog.php?id=".$trow['id']."\" target=_blank>������� ������� ��</A><BR></LI>";
							}
					}
					else
					{
					echo "<li>���� ������� ���...</li>";
					}
                                    ?>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
</div>

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
?>