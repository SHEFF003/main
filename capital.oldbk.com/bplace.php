<?
// ����� ����� - �� ��� �������!!! V.6.0
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
$maxp=30;



function get_life_in_t($t,$b)
{
$cc=mysql_fetch_array(mysql_query("select count(*) from users  WHERE  hp >0 and battle={$b} and battle_t={$t};"));
return $cc[0];
}

function get_life_in_t_clons($t,$b)
{
$cc=mysql_fetch_array(mysql_query("select count(*) from users_clons  WHERE  hp >0 and battle={$b} and battle_t={$t};"));
return $cc[0];
}

function get_all_in_t($t,$b)
{
$cc=mysql_fetch_array(mysql_query("select count(*) from users  WHERE  battle={$b} and battle_t={$t};"));
return $cc[0];
}

function get_maxusers()
{
$cc=mysql_fetch_array(mysql_query("select * from place_battle where var='maxusers'"));
return $cc['val'];
}


function go_to_battle($telo,$za,$testbtl,$tlife)
{

global $maxp;

$real_align=$telo[align];

$telo[align]=(int)($telo[align]);
if ($telo[align]==1) { $telo[align]=6; }

$neAlign[1]= array (3); //  ,2  �� ���� �� ����� ������ � ��������
$neAlign[2]= array (6); // ,2 �� ���� �� ����� ���� � ��������
//$neAlign[3]= array (6,3); //�� ��������� �� ����� ���� � ����

$neStor[1]=array(2);
$neStor[2]=array(1);
//$neStor[3]=array(1,2);

$estr[1]='�� ����, �� �����������...';
$estr[2]='�������� � ���� ������...';
//$estr[3]='���� ���� ������...';

 if ($telo[weap]>0 and $telo[kulon]>0 and $telo[sergi]>0 and $telo[perchi]>0 and $telo[bron]>0 and $telo[rubashka]>0 and $telo[helm]>0 and $telo[shit]>0 and $telo[boots]>0 and $telo[r1]>0 and $telo[r2]>0 and $telo[r3]>0) 
 		{

			$min_level=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='min_level' ;"));
			$max_level=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='max_level' ;"));	   
	   
		   if 	(($telo['level'] < $min_level['val']) OR ($telo['level'] > $max_level['val']))
	   		{
			   echo "<font color=red>� ��� ������� �� ��� ..</font>";
			}
			else
			{
			   $bex=mysql_fetch_array(mysql_query("SELECT max(bexit_count) as ex  from  battle_vars where owner='{$telo[id]}' and battle='{$testbtl[id]}';"));
				if (in_array($telo[align],$neAlign[$za]))
				{
				echo "<font color=red>�� �� ������ ����� � ��� ������...</font>";
				}
				elseif ( (in_array($telo[bpstor],$neStor[$za])) or (in_array($telo[bpalign],$neStor[$za]))  )    // ��������� �������
				{
				//���� ���� ��� �����������
				echo "<font color=red>�� �� ������ ����� � ��� ������...</font>";
				}
				elseif ($bex[0] > 1)
				{
				echo "<font color=red>�� �� ������ ����� � ��� ������...����� ����� � ���...</font>";
				}
			else
			{
			echo $estr[$za];
			
			if (($testbtl[win]==3) AND ($testbtl[status]==0) and  ($tlife>0) )
			{
					if (($telo[klan]!='')and($telo[bpstor]==0))
						{
						mysql_query("UPDATE `users` SET `bpstor`='{$za}' where `klan`='".$telo[klan]."'");
						}
						
					$ww=mysql_fetch_array(mysql_query("SELECT count(*) from `place_turn` where t='{$za}';"));

				   if (($tlife < $maxp )and((int)($ww[0])==0))
	   			   {
					/// �������������
					$ttt = $za; //���� �� ������� �������
					if ($telo[hp]==0) { $addhp=' `hp`=`hp`+2, '; }

					$time = time();
					mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', to3='.$time.',  `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$telo['id'].'\') , `t'.$ttt.'hist`=CONCAT(`t'.$ttt.'hist`,\''.BNewHist($telo).'\')   WHERE  `win`=3 and `status`=0 and `id` = '.$testbtl[id].' ;');
			//echo mysql_error();
					if(mysql_affected_rows()>0)
					{
					if (($testbtl[status]==0) AND ($testbtl[win]==3) )
					        {
					        $telo[battle]=$testbtl[id];
						if ($telo[sex]==1) { $act='��������' ;  } else { $act='���������' ;  }					        
						$telo[align]=$real_align;
						addch ("<b>".$telo['login']."</b> ".$act." � <a href=logs.php?log=".$testbtl[id]." target=_blank>�������� ��</a>.  ",$telo['room']);
//						addlog($testbtl[id],'<span class=date>'.date("H:i").'</span> '.nick_in_battle_hist($telo,$za).' '.$act.' � ��������!<BR>');
							$telo[battle_t]=$za;
							$ac=($telo[sex]*100)+mt_rand(1,2);
	//						addlog($testbtl[id],"!:V:".time().":".nick_new_in_battle($telo).":".$ac."\n");
							addlog($testbtl[id],"!:W:".time().":".BNewHist($telo).":".$telo[battle_t].":".$ac."\n");		

						
						mysql_query("UPDATE users SET `battle` ={$testbtl[id]}, `battle_t`={$ttt} ,  `bpalign`={$za}, ".$addhp." `bpstor`={$ttt}, `bpzay`=0  WHERE `id`= ".$telo['id']);
						mysql_query("INSERT `battle_vars` (battle,owner,update_time,type)  VALUES ('{$testbtl[id]}','{$telo['id']}','{$time}','1') ON DUPLICATE KEY UPDATE `update_time` = '{$time}' ;");
						return true;
			      			}
			 		}
				}
				else
				{
					if ($telo[bpzay]==-1)
		 			{
		 			
					}
					 else
			 		{

									// ����� � �������
									echo "<br>�� ����� � ������� �� ���� � ���!...";
									// ������ � bpzay -1 - ������������ ������� - �������� ����� �����
									$nn=mysql_fetch_array(mysql_query("SELECT max(poz) from `place_turn` where t='{$za}';"));
									$mmm=(int)($nn[0])+1;
									mysql_query("UPDATE users set bpzay='-1' where id={$telo[id]} and battle=0 LIMIT 1;");
									$rf=mysql_affected_rows();
									if ( $rf > 0)
									{
										$telo[align]=$real_align;
										mysql_query("INSERT INTO `place_turn` SET `owner`={$telo[id]},`poz`={$mmm},`owner_data`='".nick_align_klan($telo)."',`t`='{$za}';");
							 		}
						
						

		 			}
				}
			}
			else
			    {
			    echo "<font color=red>��� ��� ������� �� ��������...</font>";
			    }
			
			}
	       }
	    }
	    else
		{
			echo "<br>������ � ������� �������� ������ ��� ������� 13 �����, �� ������� ����!";
		}
	    
	    

}


////////////////////////////////////////////////
		session_start();
		if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
		include "connect.php";
		include "functions.php";
		if ($user[klan]=='radminion') {  echo "Admin-info:<!- GZipper_Stats -> <br>";  }		

		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
		$zayava=mysql_fetch_array(mysql_query("SELECT * FROM `place_zay` WHERE  `level`=6 and `active`=1 LIMIT 1;"));

			$kt1=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='t1_count' ;"));
			$kt2=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='t2_count' ;"));
			//$kt3=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='t3_count' ;"));
			
			$nbType=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='type' ;"));


		if (($user['battle']>0) OR ($user['battle_fin'] >0))  { header("Location: fbattle.php"); die(); }
		if ($user['room']!=60) { header("Location: main.php"); die(); }



		if (($_GET['got'] && $_GET['level62'])  and ($user[battle]==0) )
		{
			//header('location: repair.php');
		}
		else
		if (($_GET['got'] && $_GET['level333']) and  ($user[battle]==0))
		{
		 if ($user[bpzay]==-1)
		 {
		 $get_nom=mysql_query("select * from place_turn where t=(SELECT t FROM `place_turn` WHERE  `owner`='{$user[id]}' ) ORDER BY poz;");
		 while($rowc = mysql_fetch_array($get_nom))
		 {
		 $poz++;
		 if ($rowc[owner]==$user[id])
		 	{
		 	break;
		 	}
		 }
		 echo "<font color=red>�� ������ � ������� �� ��� ��� �������:".$poz."...</font><br>";
		 }
		 else   {
		 	MoveToLoc('city.php','������ �� �������� �������',50);
			}
		}








function outtime($eff)
		{
	$tt=time();
	$time_still=$eff-$tt;
	$tmp = floor($time_still/2592000);
	$id=-1; // ������� �������� ����������
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

function gotime($eff)
		{
	$tt=time();
	$time_still=$tt-$eff;
	$tmp = floor($time_still/2592000);
	$id=-1; // ������� �������� ����������
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

	return $out;
		}

?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
<link rel="stylesheet" href="/i/btn.css" type="text/css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="i/js/noty/packaged/jquery.noty.packaged.min.js"></script>
<script type="text/javascript" src="i/js/noty/packaged/custom.js"></script>
<script type="text/javascript" src="/i/globaljs.js"></script>
<style>
    IMG.aFilter { filter:Glow(Color=d7d7d7,Strength=9,Enabled=0); cursor:hand }
    .noty_message { padding: 5px !important;}    
</style>
<style type="text/css">
img, div { behavior: url(/i/city/ie/iepngfix.htc) }
</style>
<SCRIPT LANGUAGE="JavaScript">
function solo(n)
{
	//if (<?php if(!is_array($_SESSION['vk'])) echo'top.'; else echo'parent.'; ?>CtrlPress) {
	//	window.open('/ch.pl?online=1&n='+n,'onlines','width=400,height=500,toolbar=no,location=no,scrollbars=yes,resizable=yes');
	//} else {
		<?php if(!is_array($_SESSION['vk'])) echo'top.'; else echo'parent.'; ?>changeroom=n;
		window.location.href='bplace.php?got=1&level'+n+'=1';
	//}
}

function imover(im)
{
	im.filters.Glow.Enabled=true;
//	im.style.visibility="hidden";
}

function imout(im)
{
	im.filters.Glow.Enabled=false;
//	im.style.visibility="visible";
}

		function returned2(s){
			location.href='bplace.php?'+s+'tmp='+Math.random();
		}


function Down() {<?php if(!is_array($_SESSION['vk'])) echo'top.'; else echo'parent.'; ?>CtrlPress = window.event.ctrlKey}

	document.onmousedown = Down;



<?
		if (($_GET['got'] && $_GET['level61']) and ($user[battle]==0))
		{
?>
function refreshPeriodic()
			{
			location.href='bplace.php?got=1&level61=1';//reload();
			timerID=setTimeout("refreshPeriodic()",30000);
			}
			timerID=setTimeout("refreshPeriodic()",30000);

</SCRIPT>
</HEAD>

<style>
	body {
			background-image: url('http://capitalcity.oldbk.com/i/city/arena_bg.jpg');
			background-repeat: no-repeat;
			background-position: top right;
	   }
</style>
<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 onload="top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>)">
<?
		// ����� ������
	nick($user);
	echo "<div align=right> 
            <form method=GET action='bplace.php'> 
            <div class='btn-control'>
                <input class='button-mid btn' type=button value='��������' onClick=\"returned2('got=1&level61=1&');\"> 
                <INPUT class='button-mid btn' TYPE=button value=\"���������\" onClick=\"returned2('bpl=1&');\"> &nbsp;&nbsp;&nbsp;
                </div>
            </form>
            </div>";
	if ($user[bpzay]>0)
	{
	$te[1]='�����';
	$te[2]='����';
	//$te[3]='���������';
	echo "<b>�� ��� ������ ������ �� ������� ".$te[$user[bpstor]]."!</b>";
	}
/////////////////////////////
$get_closetime=mysql_fetch_array(mysql_query("select val from place_battle where var='close';"));
$get_closetime=mysql_fetch_array(mysql_query("select val from place_battle where var='close';"));
$nbType=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='type' ;"));
$bbat=mysql_fetch_array(mysql_query("select win from battle where id=(select val from place_battle where var='battle') ;"));

$get_eff=mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' AND type=5000;"));
$user_blago=(int)$get_eff[id];
//echo "$get_closetime[val]";
  if (  (( time() >= $get_closetime[val]) and ($get_closetime[val]!=0))
  	OR
  	(($nbType[val]==62) AND ($user_blago==0)  )  // ������ ����� �������� ������ ������
  	)
  
  {
  if (($_GET[confirm2]) OR ($_GET[confirm1]) OR ($_GET[confirm3]) ) {echo "<font color=red><b>��� ������...</b></font>";}

  unset($_GET[confirm3]);
  unset($_GET[confirm2]);
  unset($_GET[confirm1]);
  }
///
if (($get_closetime[val]>time()) and ($bbat[win]==3))
{
echo "<font color=red><b>��� ��������� �����:".floor(($get_closetime[val]-time())/60/60)." �. ".round((($get_closetime[val]-time())/60)-(floor(($get_closetime[val]-time())/3600)*60))." ���.</b></font>";
}  
///////////////////////////
$min_level=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='min_level' ;"));
$max_level=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  `var`='max_level' ;"));	   

 if (($user['level'] < $min_level['val']) OR ($user['level'] > $max_level['val']))
// if ($user['level']!=8)
	   {
	   echo "<font color=red>� ��� ������� �� ��� </font>";
	  unset($_GET[confirm3]);
	  unset($_GET[confirm2]);
	  unset($_GET[confirm1]);
	}

 if ($user[bpzay]==-1)
  	{
	  unset($_GET[confirm3]);  	
	   unset($_GET[confirm2]);
	   unset($_GET[confirm1]);
  	}


  if ( (($_GET[confirm1]) OR ($_GET[confirm2])) AND ($user[align]==0) )
  {
	  unset($_GET[confirm3]);  	
	   unset($_GET[confirm2]);
	   unset($_GET[confirm1]);
	   echo "<font color=red>�� �� ������ ����� �� ��� �������...</font>";    		   

  }
  else if (($_GET[confirm1]) and ($nbType[val]==3))
  {
    if ( ($user[align]==6) OR  ((int)($user[align])==1)   ) //  OR ($user[align]==0)
    	{
    	//good - ���� � ���� + �����
    	}
    	else
    	{
	   unset($_GET[confirm1]);
	   echo "<font color=red>�� �� ������ ����� �� ��� �������...</font>";    		   
    	}
  } 
 else 
  if (($_GET[confirm2]) and ($nbType[val]==3))
  {
    if (  ($user[align]==3) ) // ($user[align]==0) OR 
    	{
    	//good - ����� + ������
    	}
    	else
    	{
	   unset($_GET[confirm2]);
	   echo "<font color=red>�� �� ������ ����� �� ��� �������...</font>";    		   
    	}
  }
  /*
  else 
  if (($_GET[confirm3]) and ($nbType[val]==3))
  {
    if ( ($user[align]==0) OR  ((int)($user[align])==2) )
    	{
    	//good - ����� + ��������
    	}
    	else
    	{
	   unset($_GET[confirm2]);
	   echo "<font color=red>�� �� ������ ����� �� ��� �������...</font>";    		   
    	}
  } 
*/

if ($zayava>0)
	{
	/////////////������ ���� �� ���� ��� //////////
			if (($user[bpzay]==0)  and ($user[battle]==0) ) // �� � ������
			{
				if (($_GET[confirm1]) and ($user[battle]==0) ) // �� ����
				{
				    if ($zayava[t1c]>$kt1['val'])
					{
					if ($user['level'] > 0  &&!($zayava['t1min'] <= $user['level'] && $zayava['t1max'] >= $user['level']))
						{
						  echo "<font color=red>��� ������ �� ����� ���� ������� ����.</font>";
						}
						else
						if (($user[align]==3)) //OR ((int)($user[align])==2))//��������� ������� ���� ������ ��� �������� = ������
						{
						echo "<font color=red>�� �� ������ ����� � ��� ������...3</font>";
						}
						else
						if (($user[bpstor]==2))// OR ($user[bpstor]==3)) // ��������� ������� ���� ������� ��� ����������
						{
						//���� ���� ��� �����������
						echo "<font color=red>�� �� ������ ����� � ��� ������...4</font>";
						}
						else
						{
						   echo "�� ����, �� �����������...";
							// ��� � ����� ������ ����� ����� bpstor=1
							if ($user[klan]!='')
							{
							mysql_query("UPDATE `users` SET `bpstor`=1 where `klan`='".$user[klan]."'");
							}
						//
						   if (mysql_query("UPDATE `users`, `place_zay` SET
							`users`.bpzay = {$zayava[id]},
							`users`.bpstor = 1,
							`place_zay`.team1 = CONCAT(`team1`,';{$user[id]}'),
							`place_zay`.t1data = CONCAT(`t1data`,' ".nick3($user[id])."')
						  WHERE
							`users`.id = {$user[id]} AND
							`users`.bpzay = 0 AND
							(`users`.bpstor = 1 OR `users`.bpstor = 0 )   AND
							`place_zay`.active=1 AND
							`place_zay`.id = {$zayava[id]};"))
				    		   {
						    echo "�� ������� ������ �� ���, �� ������� �����.";
						    mysql_query("UPDATE `place_battle` set `val`=`val`+1 where `var`='t1_count';");
						    $kt1['val']++;
						    $user[bpzay]=$zayava[id];
						  $zayava=mysql_fetch_array(mysql_query("SELECT * FROM `place_zay` WHERE  `level`=6 and `active`=1 LIMIT 1;"));
						
				    		   }
						}
			 		}
			 		else
			 		{
					  echo "<font color=red> ������ ��������...�������� ������ ���! </font>";
			 		}

			}
			else
			  if (($_GET[confirm2])  and ($user[battle]==0) ) // �� ����
			{
				if ($zayava[t2c]>$kt2['val'])
		    		{
				   if ($user['level'] > 0  &&!($zayava['t2min'] <= $user['level'] && $zayava['t2max'] >= $user['level']))
				    {
				     echo "<font color=red>��� ������ �� ����� ���� ������� ����.</font>";
				    }
				    else
				    if (($user[align]==6)or($user[align] >= 1 and $user[align] < 2) ) //or ((int)($user[align])==2) ) //��������� ������� ���� ���� ��� ����  ��� ��������
				    {
				    echo "<font color=red>�� �� ������ ����� � ��� ������...</font>";
				    }
				    elseif (($user[bpstor]==1) ) //OR ($user[bpstor]==3)) // ��������� ������� ���� ��� ���������� �� ���� � �� ��������
				   {
				    //���� ���� ��� �����������
				    echo "<font color=red>�� �� ������ ����� � ��� ������...</font>";
				   }
				else
				   {
				   echo "�������� � ���� ������! ";
				   //uodate $zayava[id]
				   // ��� � ����� ������ ����� ����� bpstor=2
				   if ($user[klan]!='')
				   {
				   mysql_query("UPDATE `users` SET `bpstor`=2 where `klan`='".$user[klan]."'");
				   }
				   //
				   if (mysql_query("UPDATE `users`, `place_zay` SET
							`users`.bpzay = {$zayava[id]},
							`users`.bpstor = 2,
							`place_zay`.team2 = CONCAT(`team2`,';{$user[id]}'),
 							`place_zay`.t2data = CONCAT(`t2data`,' ".nick3($user[id])."')
						WHERE
							`users`.id = {$user[id]} AND
							`users`.bpzay = 0 AND
							(`users`.bpstor = 2 OR `users`.bpstor = 0 )   AND
							`place_zay`.active=1 AND
							`place_zay`.id = {$zayava[id]};
						"))
				   {
				   echo "�� ������� ������ �� ���, �� ������� ����!";
    				    mysql_query("UPDATE `place_battle` set `val`=`val`+1 where `var`='t2_count';");
    				    $kt2['val']++;
    				    $user[bpzay]=$zayava[id];
				 $zayava=mysql_fetch_array(mysql_query("SELECT * FROM `place_zay` WHERE  `level`=6 and `active`=1 LIMIT 1;"));
				   }
				}
			  }
			  else
			  {
  			  echo "<font color=red> ������ ��������...�������� ������ ���! </font>";
			  }
			}
		/*	else
			  if (($_GET[confirm3])  and ($user[battle]==0) ) // �� ���������
			{
				if ($zayava[t3c]>$kt3['val'])
		    		{
				   if ($user['level'] > 0  &&!($zayava['t3min'] <= $user['level'] && $zayava['t3max'] >= $user['level']))
				    {
				     echo "<font color=red>��� ������ �� ����� ���� ������� ����.</font>";
				    }
				    else
				    if ( ((int)($user[align]) !=2) and ($user[align] !=0))   //��������� �������
				    {
				    echo "<font color=red>�� �� ������ ����� � ��� ������...7</font>";
				    }
				    elseif ( ($user[bpstor]==1) OR ($user[bpstor]==2)) // ��������� ������� �� ���� � , �� ����
				   {
				    //���� ���� ��� �����������
				    echo "<font color=red>�� �� ������ ����� � ��� ������...8</font>";
				   }
				else
				   {
				   //uodate $zayava[id]
				   // ��� � ����� ������ ����� ����� bpstor=3
				   if ($user[klan]!='')
				   {
				   mysql_query("UPDATE `users` SET `bpstor`=3 where `klan`='".$user[klan]."'");
				   }

				   if (mysql_query("UPDATE `users`, `place_zay` SET
							`users`.bpzay = {$zayava[id]},
							`users`.bpstor = 3,
							`place_zay`.team3 = CONCAT(`team3`,';{$user[id]}'),
 							`place_zay`.t3data = CONCAT(`t3data`,' ".nick3($user[id])."')
						WHERE
							`users`.id = {$user[id]} AND
							`users`.bpzay = 0 AND
							(`users`.bpstor = 3 OR `users`.bpstor = 0 )   AND
							`place_zay`.active=1 AND							
							`place_zay`.id = {$zayava[id]};
						"))
				   {
				   echo "�� ������� ������ �� ���, �� ������� ���������!";
    				    mysql_query("UPDATE `place_battle` set `val`=`val`+1 where `var`='t3_count';");
    				    $kt3['val']++;
    				    $user[bpzay]=$zayava[id];
				    $zayava=mysql_fetch_array(mysql_query("SELECT * FROM `place_zay` WHERE  `level`=6 and `active`=1 LIMIT 1;"));
				   }
				}
			  }
			  else
			  {
  			  echo "<font color=red> ������ ��������...�������� ������ ���! </font>";
			  }
			}	
			*/
			
			
		}
		/////bgcolor=99CCCC


		echo "<FORM METHOD=GET name='zay' id='zay' name=F1>";
		echo '<TABLE width=100% ><TR><TD>';
		echo "��� �������� �����: ".outtime($zayava['start']);
		echo '</TD></TR></TABLE><H3>�� ���� ������� ������ ���������?</H3>
				<TABLE width=80% align=center cellspacing=0 cellpadding=0 border=1>
				<TR>
				<TD ><B>����:</B><BR>
				������������ ���-��: '.$zayava['t1c'].'<BR>
				��������: '.($zayava['t1c']-$kt1['val']).'<BR>
				����������� �� ������: '.$zayava['t1min'].' - '.$zayava['t1max'].'
				</TD>
				<TD ><B>����:</B><BR>
				������������ ���-��: '.$zayava['t2c'].'<BR>
				��������: '.($zayava['t2c']-$kt2['val']).'<BR>
				����������� �� ������: '.$zayava['t2min'].' - '.$zayava['t2max'].'
				</TD>';
				
				/*
				echo '<TD ><B>��������:</B><BR>
				������������ ���-��: '.$zayava['t3c'].'<BR>
				��������: '.($zayava['t3c']-$kt3['val']).'<BR>
				����������� �� ������: '.$zayava['t3min'].' - '.$zayava['t3max'].'
				</TD>';
				*/
		echo'	</TR>
				<TR>
				<TD align=center width=30%>';
		if ($zayava['team1']=='')
		 {echo "<i>������ �� �������</i>"; }
		 else
		  { echo $zayava['t1data']; }
		echo '</TD><TD align=center width=30%>';
		if ($zayava['team2']=='')
		 {echo "<i>������ �� �������</i>"; }
		  else { echo $zayava['t2data']; }
		echo '</TD>';
		/*
		echo '<TD align=center width=30%>';
		if ($zayava['team3']=='')
		 {echo "<i>������ �� �������</i>"; }
		  else { echo $zayava['t3data']; }
		echo '</TD>';
		*/
		echo'</TR>';


		if ($user[bpzay]==0)
		{
		/// ��� ��� �� � ������
		echo '<TR><TD align=center><INPUT TYPE=submit name=confirm1 value="� �� ����!"></TD>
		<TD align=center><INPUT TYPE=submit name=confirm2 value="� �� ����!"></TD>';
//		echo '<TD align=center><INPUT TYPE=submit name=confirm3 value="� �� ����!"></TD>';
		echo '</TR>
		</TABLE>
		<INPUT TYPE=hidden name=gocombat value="'.$zayava[id].'">
		<INPUT TYPE=hidden name=got value=1>
		<INPUT TYPE=hidden name=level61 value=1></form>';
		}
		else
		{
		// ��� ��� � ������ �� ���
		echo '</TABLE>';
		}
	}
	else
	{
	// ��� ������ �� ���� ���
	// �.�. ��� ��� ����!
	// ��������� ������� ���

	$getbat=mysql_fetch_array(mysql_query("select * from place_logs where active=1 LIMIT 1;"));
	if ($getbat[id]>0)
	   {
		$testbtl=mysql_fetch_array(mysql_query("select * from battle where id='".$getbat[battle]."'"));
		$t1life=get_life_in_t('1',$testbtl[id]);
		$t2life=get_life_in_t('2',$testbtl[id]);
//		$t3life=get_life_in_t('3',$testbtl[id]);		
	
	/*	
		$t1life_clons=get_life_in_t_clons('1',$testbtl[id]);
		$t2life_clons=get_life_in_t_clons('2',$testbtl[id]);
		$t3life_clons=get_life_in_t_clons('3',$testbtl[id]);		
	*/	
		

	   // ������ ������
	   
	$MAX_USERS_LIM=get_maxusers();//����������� ��������� � ���.
	
	$ALL_IN_T1=get_all_in_t(1,$testbtl[id]);
	$ALL_IN_T2=get_all_in_t(2,$testbtl[id]);
//	$ALL_IN_T3=get_all_in_t(3,$testbtl[id]);			   
	   
	   
	   if (($_GET[confirm1]) AND ($testbtl[win]==3) AND ($testbtl[status]==0) and ($t1life >0) )
	   {
		   if ($ALL_IN_T1>=$MAX_USERS_LIM)
		   {
	   	   echo "<b><font color=red>� ���� ������� ��������� ����� ����������...</font><br>";
		   }
		   else
		   {
			if (go_to_battle($user,1,$testbtl,$t1life))
				{
				$ALL_IN_T1++;
				die("<script>location.href='fbattle.php';</script>");
				}
		   }
	   }
	   else   if (($_GET[confirm1]) AND ($testbtl[win]==3) AND ($testbtl[status]==0) and ($t1life==0) )
	   {
	   echo "<b><font color=red>� ���� ������� ��� ��� ����� �����...</font><br>";
	   }
	   else
	   if (($_GET[confirm2]) AND ($testbtl[win]==3) AND ($testbtl[status]==0) and ($t2life>0) )
	   {
		   if ($ALL_IN_T2>=$MAX_USERS_LIM)
		   {
	   	   echo "<b><font color=red>� ���� ������� ��������� ����� ����������...</font><br>";
		   }
		   else
		   {	   
	     		if (go_to_battle($user,2,$testbtl,$t2life))
	     			{
				$ALL_IN_T2++;
				die("<script>location.href='fbattle.php';</script>");	     			
	     			}
	     	   }
	   }
	   else if (($_GET[confirm2]) AND ($testbtl[win]==3) AND ($testbtl[status]==0) and ($t2life==0) )
	   {
	   echo "<b><font color=red>� ���� ������� ��� ��� ����� �����...</font><br>";
	   }
/*	else
	   if (($_GET[confirm3]) AND ($testbtl[win]==3) AND ($testbtl[status]==0) and ($t3life>0) )
	   {
	   if ($ALL_IN_T3>=$MAX_USERS_LIM)
		   {
	   	   echo "<b><font color=red>� ���� ������� ��������� ����� ����������...</font><br>";
		   }
		   else
		   {	   	   
	   		if (go_to_battle($user,3,$testbtl,$t3life))
	   		{
				$ALL_IN_T3++;
				die("<script>location.href='fbattle.php';</script>");
	   		}
	   	  }
	   } */
	   
	else if (($_GET[confirm3]) AND ($testbtl[win]==3) AND ($testbtl[status]==0) and ($t3life==0) )
	{
	   echo "<br><font color=red>� ���� ������� ��� ��� ����� �����...</font><br>";	
	}


	   {
	   /////////////////////////
	   	echo "<FORM METHOD=GET name='gob' id='gob' name=F2>";
		echo '<TABLE width=100% ><TR><TD>';
		$dltime=mysql_fetch_array(mysql_query("select val from place_battle where `var`='starttime'; "));

		if ($user[bpzay]==-1)
		 {
		 $get_nom=mysql_query("select * from place_turn where t=(SELECT t FROM `place_turn` WHERE  `owner`='{$user[id]}' ) ORDER BY poz;");
		 while($rowc = mysql_fetch_array($get_nom))
		 {
		 $poz++;
		 if ($rowc[owner]==$user[id])
		 	{
		 	break;
		 	}
		 }
		 echo "<font color=red>�� ������ � ������� �� ��� ��� �������:".$poz."...</font><br>";
		 }

		echo "��� ����: ".gotime($dltime[0]);
		echo " <A HREF='/logs.php?log=".$testbtl[id]."' target=_blank>��� ����� ��</A><BR>";



	//*************************************		
		if ($testbtl[id]>0)
			{
			$get_s_hp=mysql_fetch_array(mysql_query("select sum(hp) as hp, sum(maxhp) as maxhp, battle_t from users where battle='{$testbtl[id]}' and battle_t=1 ;"));
			 if ($get_s_hp) { $out_s_hp=setHP($get_s_hp[hp],$get_s_hp[maxhp]);}
			}

			echo '</TD></TR></TABLE><H3>�� ���� ������� ������ ���������?</H3>
				<TABLE width=80% align=center cellspacing=0 cellpadding=0 border=1>
				<TR><TD >
				<B>����:</B>'.$out_s_hp.'<BR>';
			echo '		<B>����� � ���:</B>'.$ALL_IN_T1;				
			echo '<br>	<B>�����:</B>'.$t1life;
			echo '<br>	<B>�������� ����������:</B>'.$MAX_USERS_LIM;
	
			if  ($ALL_IN_T1>=$MAX_USERS_LIM) { $LOGIN_B_T1=false; }else{ $LOGIN_B_T1=true; }
	
			if ($LOGIN_B_T1==true)
			 
	 		{
				$sv1=($maxp-$t1life);
				if ($sv1<=0)
				{
				$sv1=0;
				}

			$ww=mysql_fetch_array(mysql_query("SELECT count(*) from `place_turn` where t=1;"));

			if ($ww[0]>0)
				{
				echo '		<br><B>������� �����:</B>'.$ww[0];
				}
				else 
				{
					if ($testbtl[type]==62) 
					{
					echo "<br><b>��� ������</b><br>";
					}
					else
					{
					echo '		<br><B>��������:</B>'.$sv1; 
					}
				}
			}
	//*************************************
		if ($testbtl[id]>0)
			{
			$get_t_hp=mysql_fetch_array(mysql_query("select sum(hp) as hp, sum(maxhp) as maxhp, battle_t from users where battle='{$testbtl[id]}' and battle_t=2 ;"));
			 if ($get_t_hp) { $out_t_hp=setHP($get_t_hp[hp],$get_t_hp[maxhp]);}
			}

		echo '		</TD><TD><B>����:</B>'.$out_t_hp.'<BR>';
		echo '		<B>����� � ���:</B>'.$ALL_IN_T2;
		echo '<br>	<B>�����:</B>'.$t2life;
		echo '<br>	<B>�������� ����������:</B>'.$MAX_USERS_LIM;	
		
		if  ($ALL_IN_T2>=$MAX_USERS_LIM) { $LOGIN_B_T2=false; }else{ $LOGIN_B_T2=true; }
		
		if ($LOGIN_B_T2==true)		
		{
		$sv2=($maxp-$t2life);
			if ($sv2<=0)
				{
				$sv2=0;
				}

			
			$ww=mysql_fetch_array(mysql_query("SELECT count(*) from `place_turn` where t=2;"));
			if ($ww[0]>0)
			{
			echo '		<br><B>������� �����:</B>'.$ww[0];
			}
			else 
			{	
					if ($testbtl[type]==62) 
					{
					echo "<br><b>��� ������</b><br>";
					}
					else
					{
					echo '		<br><B>��������:</B>'.$sv2; 
					}
				
			}
		}
	//*************************************
	/*
		if ($testbtl[id]>0)
			{
			$get_n_hp=mysql_fetch_array(mysql_query("select sum(hp) as hp, sum(maxhp) as maxhp, battle_t from users where battle='{$testbtl[id]}' and battle_t=3 ;"));
			 if ($get_n_hp) { $out_n_hp=setHP($get_n_hp[hp],$get_n_hp[maxhp]);}
			}

		echo '		</TD><TD><B>��������:</B>'.$out_n_hp.'<BR>';
		echo '		<B>����� � ���:</B>'.$ALL_IN_T3;
		echo '<br>	<B>�����:</B>'.$t3life;
		echo '<br>	<B>�������� ����������:</B>'.$MAX_USERS_LIM;	
		
		if  ($ALL_IN_T3>=$MAX_USERS_LIM) { $LOGIN_B_T3=false; }else{ $LOGIN_B_T3=true; }
		
		if ($LOGIN_B_T3==true)			
		{
		$sv3=($maxp-$t3life);
			if ($sv3<=0)
				{
				$sv3=0;
				}

			$ww=mysql_fetch_array(mysql_query("SELECT count(*) from `place_turn` where t=3;"));
			if ($ww[0]>0)
			{
			echo '		<br><B>������� �����:</B>'.$ww[0];
			}
			else {	
					if ($testbtl[type]==62) 
					{
					echo "<br><b>��� ������</b><br>";
					}
					else
					{
					echo '		<br><B>��������:</B>'.$sv3; 
					}
				
				}
		}
	//*************************************
	*/

		echo '		</TD></TR>';
		if ($user[battle]==0)
		{
		/// ��� ��� �� � ���
		if ($testbtl[type]!=62) 
					{
		echo '<TR>';
		echo '		<TD align=center>';
		if ($LOGIN_B_T1==true) { echo '<INPUT TYPE=submit name=confirm1 value="� �� ����!">'; }
		echo '</TD>';
		echo '		<TD align=center>';
		if  ($LOGIN_B_T2==true) { echo '<INPUT TYPE=submit name=confirm2 value="� �� ����!">'; }
		echo '</TD>';
		
/*		echo '		<TD align=center>';
		if  ($LOGIN_B_T3==true) { echo '<INPUT TYPE=submit name=confirm3 value="� �� ����!">'; }
		echo '</TD>';
*/		
		echo '		</TR>';
					}
		echo '</TABLE>';
					
		echo '					
		<INPUT TYPE=hidden name=got value=1>
		<INPUT TYPE=hidden name=level61 value=1></form>';

		}
		else
		{
		die();
		}
	   ////////////////////////
	   }

	   // ��� ����� ����� ����������� ����� -
	   // ���� ����� �� �����
	   // ����������� ����� ����� ���� ��� �������� � ���
	   // ��������� ����������� ����� �� ������� � �� �������
	   // ������ ��� ����� + ������ ����� � ���� ��������� + ������ ��� � ���� ������ �������� + ������ � ���� ������
	   }
	   else
	   {
	   // ��� ����
	   // ������� ���� ��� ����� ����� ��� ������

	   }
	 // � ���� �� ���� �� ���� ������ ���������

	}





echo '<P>&nbsp;<H4> 10 ��������� ����</H4>';
 if ($user['klan']=='radminion')  	{  	echo "<a href=/make_arena_cap_only_12lvl.php>�������� � ���������� ���...</a>";  	}
echo '<OL>';
echo '<table border="0" cellspacing="0" cellpadding="0">';
if ($user['klan']=='radminion') {$lim=''; } else {$lim=' LIMIT 10 ';}
	$rasp = mysql_query("SELECT * FROM `place_zay` WHERE `active` =0  ORDER by `start` ".$lim.";");
	$aa=0;
	while($data = mysql_fetch_array($rasp))
		{
		$aa++;
	 	echo '<tr><td>';
	 	if ($user[id]==14897) { echo $data['id']; }
         	echo " ".$aa.".<b> ".$data['coment']."</b></td>";
		echo '<td>';
		if ($data[t1c]==10) { echo "(10x10)"; }  else { echo '&nbsp;'; }
		echo '</td>';
		echo ' <td>';
		echo "&nbsp;&nbsp;������ ����� <b><FONT class=date>".date("d.m.Y H:i",$data['start'])."</FONT></td>";	    
		echo '<td>&nbsp;��&nbsp;</b></td>';
		echo "<td> �������� ������:<b><FONT class=date>".date("d.m.Y H:i",$data['start']-3600)."</FONT></b><BR></td>";			
		echo '</tr>';
		}
	echo '</table>	';
	echo '</OL>';	





echo '<H4> 10 ���������� ����</H4><OL>';
	//////////////////////////
		$row = mysql_query("SELECT * FROM `place_logs` WHERE `active` =0 ORDER by `id` DESC LIMIT 10;");

		while($data = mysql_fetch_array($row))
		{
		$wt[0]='<b>�����</b>'; $wt[1]='<b>������� ����</b>'; $wt[2]='<b>�������� ����</b>';$wt[3]='<b>�������� ��������</b>';
		echo "<LI> ����������: ".$wt[$data['win']]." ������ ����� <FONT class=date>".$data['startdate']."</FONT> <A HREF='/logs.php?log=".$data['battle']."' target=_blank>��� ����� ��</A><BR></LI>";
		}
	echo '</OL>';


		}
///////////////���� ����
		else
		{
?>
function refreshPeriodic()
			{
			location.href='bplace.php';//reload();
			timerID=setTimeout("refreshPeriodic()",30000);
			}
			timerID=setTimeout("refreshPeriodic()",30000);

</SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#d7d7d7">
<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0">
<TR>
	<TD align=center></TD>
	<TD align=right>
	    <div class="btn-control">
	        <INPUT class="button-dark-mid btn" TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/city1.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
        </div>
    </TD>
</TR>
	<TR><TD align=center valign=top colspan=2>
<?
	function buildset($id,$img,$top,$left,$des) {
		$imga = ImageCreateFromGif("i/city/sub/".$img.".gif");
		#Get image width / height
		$x = ImageSX($imga);
		$y = ImageSY($imga);
		unset($imga);
		echo "<div style=\"position:absolute; left:{$left}px; top:{$top}px; width:{$x}; height:${y}; z-index:90; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);\"
	 ><img src=\"http://i.oldbk.com/i/city/sub/{$img}.gif\" width=\"${x}\" height=\"${y}\" alt=\"{$des}\" title=\"{$des}\" class=\"aFilter\" onmouseover=\"imover(this)\" onmouseout=\"imout(this);\"
	 id=\"{$id}\" onclick=\"solo({$id})\" /></div>";
	 }

	function buildsetPNG($id,$img,$top,$left,$des) {
		$imga = ImageCreateFromPNG("i/city/sub/".$img.".png");
		#Get image width / height
		$x = ImageSX($imga);
		$y = ImageSY($imga);
		unset($imga);

		if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6.0"))
	 {
	 echo "<div style=\"";
	 if ($id!=102) {  echo "cursor: pointer; ";  }
	 echo "position:absolute;  left:{$left}px; top:{$top}px; width:{$x}; height:${y}; z-index:90; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);\"
	 ><img src=\"http://i.oldbk.com/i/city/sub/{$img}.png\" width=\"${x}\" height=\"${y}\" alt=\"{$des}\" title=\"{$des}\" class=\"aFilter\" onmouseover=\"this.src='http://i.oldbk.com/i/city/sub/{$img}2.png'\" onmouseout=\"this.src='http://i.oldbk.com/i/city/sub/{$img}.png'\"
	 id=\"{$id}\" ";
	  if ($id!=102) {  echo " onclick=\"solo({$id})\""; }
	 echo " /></div>";
	 }
	 else
	 {
	 echo "<div style=\"";
	 if ($id!=102) {  echo "cursor: pointer; ";  }	 
	 echo "position:absolute; left:{$left}px; top:{$top}px; width:{$x}; height:${y}; z-index:90; \"
	 ><img src=\"http://i.oldbk.com/i/city/sub/{$img}.png\" width=\"${x}\" height=\"${y}\" alt=\"{$des}\" title=\"{$des}\" class=\"aFilter2\" onmouseover=\"this.src='http://i.oldbk.com/i/city/sub/{$img}2.png'\" onmouseout=\"this.src='http://i.oldbk.com/i/city/sub/{$img}.png'\"
	 id=\"{$id}\"";
  	 if ($id!=102) {  echo " onclick=\"solo({$id})\""; }
	 
	 echo " /></div>";
	 }



	 }


	if (CITY_ID==0)
	{
	// ����� �������
	//��� �������
	$get_mast=mysql_fetch_array(mysql_query("select val from place_battle where var='master';"));
	if ($get_mast[val]==3)
		{
		// ����� 3 = ������
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'ar_e_d'; } else { $fon = 'ar_e_n';}
		$restal='altr_g';
		}
	elseif ($get_mast[val]==6)
		{
		// ����� 6 = ����
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'ar_g_d'; } else { $fon = 'ar_g_n';} // ���������� ��������
		$restal='altr_g';
		}
	elseif ($get_mast[val]==2)
		{
		// �������� ����� 2
	if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'cap_n_day'; } else { $fon = 'cap_n_night';} 
		$restal='altr_N';
		}		
	else {
	// �����
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'ar_n_d2'; } else { $fon = 'ar_n_n2';} // ���������� ��������
		$restal='altr_g';
	    }
	//echo "<table width=1><tr><td><div style=\"position:relative; cursor: pointer;\" id=\"ione\"><img src=\"http://i.oldbk.com/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
	echo "<table width=1><tr><td>";
	
	echo "<div style=\"position:relative;left: 0px;top: 0px;\" id=\"bar_box\" name=\"bar_box\">";
	progress_bar_city(1);
	echo "</div>";
	
	echo "<div style=\"position:relative; \" id=\"ione\"><img src=\"http://i.oldbk.com/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
	buildsetPNG(102,"stop_png",260,35,"������ ������");
	buildsetPNG(61,$restal,240,340,"�������� ������");	
	buildsetPNG(333,"arr_right_png",260,715,"�������� �������");
	//	buildset(62,bplacekuz,67,226,"������� �����");
	echo "</td></tr></table>";
	}
	else if (CITY_ID==1)
	{
	// ����� �������
	//��� �������
	$get_mast=mysql_fetch_array(mysql_query("select val from place_battle where var='master';"));
	if ($get_mast[val]==3)
		{
		// ����� 3 = ������
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'av_arena_bg1_day2'; } else { $fon = 'av_arena_bg1_night2';}
		$restal='shar_dark';
		}
	elseif ($get_mast[val]==6)
		{
		// ����� 6 = ����
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'av_arena_bg2_day'; } else { $fon = 'av_arena_bg2_night';} // ���������� ��������
		$restal='shar_light';
		}
	elseif ($get_mast[val]==2)
		{
		// ����� 2 ��������
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'av_arena_bg3_day'; } else { $fon = 'av_arena_bg3_night';} 
		$restal='shar_neutral';
		}		
	else {
	// �����
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'av_arena_bg0_day'; } else { $fon = 'av_arena_bg0_night';} // ���������� ��������
		$restal='shar_nowinner';
	    }

	echo "<table width=1><tr><td>";
	
	echo "<div style=\"position:relative;left: 0px;top: 0px;\" id=\"bar_box\" name=\"bar_box\">";
	progress_bar_city(1);
	echo "</div>";
	
	echo "<div style=\"position:relative; \" id=\"ione\"><img src=\"http://i.oldbk.com/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
	buildsetPNG(61,$restal,230,355,"�������� ������");	
	buildsetPNG(333,"ava_st_right",230,720,"�������� �������");
	echo "</td></tr></table>";
	}
	else if (CITY_ID==2)
	{
	// ����� �������
	//��� �������
	$get_mast=mysql_fetch_array(mysql_query("select val from place_battle where var='master';"));
	if ($get_mast[val]==3)
		{
		// ����� 3 = ������
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'ang_arena_dark_bg_d'; } else { $fon = 'ang_arena_dark_bg_n';}
		$restal='ang_orb_dark';
		}
	elseif ($get_mast[val]==6)
		{
		// ����� 6 = ����
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'ang_arena_light_bg_d'; } else { $fon = 'ang_arena_light_bg_n';} // ���������� ��������
		$restal='ang_orb_light';
		}
	elseif ($get_mast[val]==2)
		{
		// ����� 2 ��������
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'ang_arena_neutral_bg_d'; } else { $fon = 'ang_arena_neutral_bg_n';} 
		$restal='ang_orb_neutral';
		}		
	else {
	// �����
		if((int)date("H") > 5 && (int)date("H") < 22)
		{ $fon = 'ang_arena_norm_bg_d'; } else { $fon = 'ang_arena_norm_bg_n';} // ���������� ��������
		$restal='ang_orb_normal';
	    }

	echo "<table width=1><tr><td><div style=\"position:relative; \" id=\"ione\"><img src=\"http://i.oldbk.com/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
	buildsetPNG(61,$restal,105,340,"��� ������");	
	
	buildsetPNG(333,"angel_right",250,690,"�������� �������");
	echo "</td></tr></table>";
	}	
	}
	
	
	if (strlen($msg)) {
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
	
?>
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