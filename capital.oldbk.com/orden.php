<?php
/*
//��������� 
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
*/
	session_start();
//��������� ��� ����������� ����� - ��������� � �����
$haos_vamp1[price]=0;
$haos_vamp2[price]=50;
$haos_attak[price]=0.25;
$haos_attakb[price]=0.5;
$haos_travm[price]=1;
$haos_bexit[price]=10;
$haos_hill180[price]=0.5;
$haos_hill180[kol]=30;
$haos_sleep[price]=0.36;
$haos_unclone[price]=0.9;
$haos_unclone[kol]=10;


	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

	include "connect.php";
	include "functions.php";
	if($user['klan'] == 'radminion' || $user['id'] == 326) 
	{
	//echo "Admin-info:<!- GZipper_Stats -> <br>";
	}

	if(($user[align]>1&&$user[align]<2)||($user[align]>2&&$user[align]<3) || $user[align]==5 || $user[align]==7)
	{
		$access=check_rights($user);
		//print_r($access);
	}
	
	if(($user['id'] == 697032) OR ($user['id'] == 5))
	{
		$access=check_rights($user);
	} 
	
	
	$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
	header("Cache-Control: no-cache");
	if ($user[id]==76009) { die(); }
	

	if ($access[klans_kazna_view])
        {
        	$log_kazna_klana=true;   //��������� �������� ����� ������
        }

        if ($access[klans_kazna_logs])
        {
        	$ban_klans_kazna=true;   //��������� �������� ���� ����� ������
        }

          if ($access[klans_ars_logs])
        {
        	$log_ars_klana=true;   //��������� �������� ���� �������� ������
        }

          if ($access[klans_ars_put])
        {
        	$put_ars_klans=true;   //������� ���� �� �������� (����������� � ����) � ����� ����������� ����������� ���� � ��������.
        }


   

if($_GET[sh_bl_u])
{
     if($user[align]==2.12)
     {
     	$allow_align=('1, 1.1, 1.2, 1.3, 1.5, 1.7, 1.75, 1.9, 1.91, 1.93, 1.99, 6');
     	$side='1';
     }
	if($user[align]==2.2)
	{
		$allow_align='3';
		$side='2';
	}
    if($user[align]==2.8)
    {
    	$allow_align='2';
    	$side='1,2';
    }
    if($user[align]==2.4 || $user[align]==2.7)
    {
    	$allow_align='1, 1.1, 1.2, 1.3, 1.5, 1.7, 1.75, 1.9, 1.91, 1.93, 1.99, 6, 3, 2';
    	$side='1,2';
    }

	if($access[i_angel])
	{
		$zdata=mysql_fetch_array(mysql_query('select * from place_zay WHERE id='.$_GET[sh_bl_u].';'));
		
		$sql='select e.*, u.login, u.align, u.level, u.klan from effects e
		left join users u
		on u.id = e.owner
		where e.type = 5000 AND e.add_info in ('.$side.')
		AND  u.level='.$zdata[t1min].' AND u.align in ('.$allow_align.');';
		$teams=array();
		$data=mysql_query($sql);
		while($row=mysql_fetch_array($data))
		{
			$teams[$row[add_info]][]=nick_align_klan($row);
			//echo $row[add_info].$row[login].$row[align].'<br>';
		}
		//echo 'qwe';
		echo '<table border=1><tr><td> ����  </td><td> ���� </td></tr><tr>';
		
		for($i=1;$i<=2;$i++)
		{
			echo '<td valign=top align=left>&nbsp;';
			for($j=0;$j<count($teams[$i]);$j++)
			{
				echo $teams[$i][$j].'<br>';
			}
			echo '</td>';
		}
		echo '</tr></table>';
	
	
	}
/*
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
	*/	
	die;
}
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/steel/steel.css" />
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/jscal2.js"></script>
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/lang/ru2.js"></script>
<script type="text/javascript" src="/i/globaljs.js"></script>
<style>
	.row {
		cursor:pointer;
	}
</style>

<SCRIPT>

function showhide(id) {
	if (document.getElementById(id).style.display=="none")
	{document.getElementById(id).style.display="block";}
	else
	{document.getElementById(id).style.display="none";}
}

function blank(f){
 if(f.newwin.checked){
 	f.target ='_blank';
 	}
 	else
 	{
 	f.target ='_self';
 	}
}
<?
include("jsfunction.php");
?>
</SCRIPT>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
<table align=right><tr><td><INPUT TYPE="button" onClick="location.href='main.php';" value="���������" title="���������"></table>
<?php

	if (($log_kazna_klana) and ($_POST['newwinkazna']))
	 {
	 print_klans_kazna();
/*			 
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
*/
	 die("</body></html>");
	 }
	if (($log_kazna_klana) and ($_POST['newwinars']))
	 {
	 print_klans_ars();
/*
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
*/	 
	 die("</body></html>");
	 }





	if ($user['align'] == '5') 
	{
			echo "<h3>���������� ����</h3>";
			$get_bank=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner`='". $user['id']."' and haos=1 LIMIT 1;"));
	}
	else
	if ($user['align'] == '3') 
	{
		if ($user['sex'] == 1) 
		{
			echo "<h3>�������� � ����, ������ {$user['login']}!</h3>
			";
		}
		else 
		{
			echo "<h3>�������� � ����, ������ {$user['login']}!</h3>
			";
		}
		//$access[abils]=serialize(array('vampir' => 1, 'brat'=> 1));
	}
	elseif (($user['align'] > '1' && $user['align'] < '2') || ($user['align'] > '2' && $user['align'] < '3')) 
	{
		if ($user['sex'] == 1) 
		{
			echo "<h3>�� �������� � ����� ����, ���� {$user['login']}!</h3>
			";
		}
		else 
		{
			echo "<h3>�� �������� � ����� ����, ������ {$user['login']}!</h3>
			";
		}
	}

	

 if($access[i_angel] || $user['id']==2 || $user['id']==697032 || $user['id']==3 || $user['id']==4 || $user['id']==5 )
 {
	if($_GET[online]==2)
	{
		$_SESSION['adm_view']=2;
		mysql_query("UPDATE `users` SET `odate` = ".time()." WHERE `id` = {$user['id']};");	
	}
	elseif($_GET[online]==1 || $user['id']==2 || $user['id']==697032 || $user['id']==3 || $user['id']==4)
	{
		$_SESSION['adm_view']=1;
		mysql_query("UPDATE `users` SET `odate` = ".(time()-120)." WHERE `id` = {$user['id']};");
	}
	
	
	if($_SESSION['adm_view']==1)
	{
		echo '<a href=?online=2>����� �� �������</a><br>';
	}
	elseif($_SESSION['adm_view']==2 || $user['id']==697032 || $user['id']==3 || $user['id']==4 || $user['id']==5 )
	{
		echo '<a href=?online=1>���� � ������</a><br>';
	}
 }

function print_klans_kazna()
{
 	global $user, $ban_klans_kazna ;

	if (isset($_POST[look_log]))
	{
		if (isset($_POST[looklog_date]))
		{
		//29.09.11
			$log_date_all=explode(".",$_POST[looklog_date]);
			$log_date = sprintf("%02d.%02d.%04d", (int)($log_date_all[0]), (int)($log_date_all[1]), (int)($log_date_all[2]));
		}
		else
		{
			$log_date = date("d.m.Y");
		}
		if (isset($_POST[looklog_fdate]))
		{
		//29.09.11
			$log_fdate_all=explode(".",$_POST[looklog_fdate]);
			$log_fdate = sprintf("%02d.%02d.%04d", (int)($log_fdate_all[0]), (int)($log_fdate_all[1]), (int)($log_fdate_all[2]));
		}
		else
		{
			$log_fdate = date("d.m.Y");
		}
	} 
	else 
	{ 
		$log_date = date("d.m.Y"); $log_fdate = date("d.m.Y");   
	}

	echo "<td valign=top><form method=post target=\"_blank\"><b>����������� ���� ���� �����</b><br>";
	echo "<select size='1' name='klan_kazna'>
        <option value=0>�������� ����</option>";
        $sql_klan=mysql_query("SELECT cl.id, cl.short FROM oldbk.clans cl LEFT JOIN oldbk.clans_kazna ka ON cl.id=ka.clan_id where ka.clan_id>0 order by cl.short;");
        while($kl=mysql_fetch_array($sql_klan))
        {
        echo "<option value=".$kl[id]." ".($kl[id]== $_POST[klan_kazna] ? "selected" : "")."  >".$kl[short]."</option>";
        }
	echo "</select>";
	echo " c: <input type=text name='looklog_date' value='{$log_date}' id=\"calendar-inputField1\" readonly=\"true\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"calendar-trigger1\" value='...'>";
	echo "
			<script>
			Calendar.setup({
		        trigger    : \"calendar-trigger1\",
		        inputField : \"calendar-inputField1\",
			dateFormat : \"%d.%m.%Y\",
			onSelect   : function() { this.hide() }
		    			});
			document.getElementById('calendar-trigger1').setAttribute(\"type\",\"BUTTON\");
			</script>";
	echo " ��: <input type=text name='looklog_fdate' value='{$log_fdate}' id=\"calendar-inputField2\" readonly=\"true\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"calendar-trigger2\" value='...'>";
	echo "
			<script>
			Calendar.setup({
		        trigger    : \"calendar-trigger2\",
		        inputField : \"calendar-inputField2\",
			dateFormat : \"%d.%m.%Y\",
			onSelect   : function() { this.hide() }
		    			});
			document.getElementById('calendar-trigger2').setAttribute(\"type\",\"BUTTON\");
			</script>";

	echo "<input type=submit name=look_log value='��������'><br>";
	echo "</form>";
	$_POST[klan_kazna]=(int)($_POST[klan_kazna]);
	
	if ( (($_POST[klan_kazna]==34) or ($_POST[klan_kazna]==78) )  and ($user['klan'] != 'Adminion') and ($user['klan'] != 'radminion') )
	{
		$_POST[klan_kazna]=0;
	}
			
	if ((($_POST[klan_kazna] > 0)  and (isset($_POST[ban_text])) and (isset($_POST[bo_ban]))) and ($ban_klans_kazna))
	{
		if (isset($_POST[ban_kazna]))
		{
			mysql_query("update oldbk.clans_kazna set ban=1 , ban_txt='�������� \"{$user[login]}\" ��������� ����� � ��������:".mysql_real_escape_string($_POST[ban_text])."'  where clan_id='{$_POST[klan_kazna]}' and ban=0;");
			if (mysql_affected_rows()>0) 
			{
				err("����� ����� ����������!");
				mysql_query("INSERT INTO oldbk.`clans_kazna_log` (`method` ,`ktype`, `clan_id`, `owner`, `target`, `kdate`)   VALUES  ('0','3','{$_POST[klan_kazna]}','{$user[id]}','�������� \"{$user[login]}\" ��������� ����� � ��������:".mysql_real_escape_string($_POST[ban_text])."','".time()."');");
			}
		}
		else
		{
			mysql_query("update oldbk.clans_kazna set ban=0, ban_txt='' where clan_id='{$_POST[klan_kazna]}' and ban=1;");
			if (mysql_affected_rows()>0) 
			{ 
				err("����� ����� �����������!"); 
				mysql_query("INSERT INTO oldbk.`clans_kazna_log` (`method` ,`ktype`, `clan_id`, `owner`, `target`, `kdate`)   VALUES  ('0','3','{$_POST[klan_kazna]}','{$user[id]}','�������� \"{$user[login]}\" ���������� �����.','".time()."');");	 
			}
		}
	}


	if (($_POST[klan_kazna] > 0) and (isset($_POST[look_log])) and (isset($log_date_all)) and (isset($log_fdate_all)) )
	{
	
		$get_balans_kazna=mysql_fetch_array(mysql_query("select * from oldbk.clans_kazna where clan_id='{$_POST[klan_kazna]}'"));
		if ($get_balans_kazna)
		{
			echo "������� ���������:".$get_balans_kazna[kr]." ��. � ".$get_balans_kazna[ekr]." ���. <br>";
			if ($ban_klans_kazna)
			{
				echo "<form method=post>";
				echo "<input type=hidden name=klan_kazna value='".$_POST[klan_kazna]."'>";
				echo "���������� �����:<input type=checkbox name=ban_kazna ".(($get_balans_kazna[ban]>0)?"checked":"")." > �������:<input type=text name=ban_text size=90 ".(($get_balans_kazna[ban_txt]!='')?" value='".$get_balans_kazna[ban_txt]."' ":"")." >";
				echo "<input type=submit name=bo_ban value='���������'><br> ";
				echo "</form>";
			}
		}
		echo "<hr>";
		$stamp_start=mktime(0, 0, 0, (int)($log_date_all[1]), (int)($log_date_all[0]), (int)($log_date_all[2]));
		$stamp_fin=mktime(23, 59, 59,(int)($log_fdate_all[1]), (int)($log_fdate_all[0]), (int)($log_fdate_all[2]));
		
		$get_log_kazna=mysql_query("select * from oldbk.clans_kazna_log where clan_id='{$_POST[klan_kazna]}' and kdate>='{$stamp_start}' and kdate<='{$stamp_fin}'  ");
		if (mysql_num_rows($get_log_kazna) >0)
		{
			while($row_log=mysql_fetch_array($get_log_kazna))
			{
				echo "<small>";
				if ($row_log[method]==1)
				{ echo "<b>-></b>" ; }
				else if ($row_log[method]==2)
				{
					echo "<b><-</b>";
				}
				else
				{
					echo "<b>(!)</b>";
				}
				echo " <font class=date>".date("d.m.Y H:i",$row_log[kdate])."</font>"." ".$row_log[target];
				echo "</small><br>";
			}
		}
		else
		{
			err("�� ��� ���� ��� ������!");
		}
	}

}

function print_klans_ars()
{
	global $users;
	if (isset($_POST[arslook_log]))
	{
		if (isset($_POST[arslooklog_date]))
		{
		//29.09.11
			$arslog_date_all=explode(".",$_POST[arslooklog_date]);
			$arslog_date = sprintf("%02d.%02d.%04d", (int)($arslog_date_all[0]), (int)($arslog_date_all[1]), (int)($arslog_date_all[2]));
		}
		else
		{
			$arslog_date = date("d.m.Y");
		}
		if (isset($_POST[arslooklog_fdate]))
		{
		//29.09.11
			$arslog_fdate_all=explode(".",$_POST[arslooklog_fdate]);
			$arslog_fdate = sprintf("%02d.%02d.%04d", (int)($arslog_fdate_all[0]), (int)($arslog_fdate_all[1]), (int)($arslog_fdate_all[2]));
		}
		else
		{
			$arslog_fdate = date("d.m.Y");
		}
	} 
	else 
	{ 
		$arslog_date = date("d.m.Y"); $arslog_fdate = date("d.m.Y");   
	}




	echo "<td valign=top><form target=\"_blank\" method=post><b>����������� ���� ������� �����</b><br>";
	echo "<select size='1' name='klan_ars'>
	<option value=0>�������� ����</option>";
	$sql_klan=mysql_query("SELECT * FROM oldbk.clans  order by short;");
	while($kl=mysql_fetch_array($sql_klan))
	{
		echo "<option value=".$kl[id]." ".($kl[id]== $_POST[klan_ars] ? "selected" : "")."  >".$kl[short]."</option>";
	}
	echo "</select>";
	echo " c: <input type=text name='arslooklog_date' value='{$arslog_date}' id=\"calendar-inputField3\" readonly=\"true\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"calendar-trigger3\" value='...'>";
	echo "
	<script>
	Calendar.setup({
	trigger    : \"calendar-trigger3\",
	inputField : \"calendar-inputField3\",
	dateFormat : \"%d.%m.%Y\",
	onSelect   : function() { this.hide() }
	});
	document.getElementById('calendar-trigger3').setAttribute(\"type\",\"BUTTON\");
	</script>";
	echo " ��: <input type=text name='arslooklog_fdate' value='{$arslog_fdate}' id=\"calendar-inputField4\" readonly=\"true\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"calendar-trigger4\" value='...'>";
	echo "
	<script>
	Calendar.setup({
	trigger    : \"calendar-trigger4\",
	inputField : \"calendar-inputField4\",
	dateFormat : \"%d.%m.%Y\",
	onSelect   : function() { this.hide() }
	});
	document.getElementById('calendar-trigger4').setAttribute(\"type\",\"BUTTON\");
	</script>";
	
	echo "<input type=submit name=arslook_log value='��������'><br>";

	$_POST[klan_ars]=(int)($_POST[klan_ars]);

	if ( (($_POST[klan_ars]==34) or ($_POST[klan_ars]==78) )  and ($user['klan'] != 'Adminion') and ($user['klan'] != 'radminion') )
	{
		$_POST[klan_kazna]=0;
	}

	if (($_POST[klan_ars] > 0) and (isset($_POST[arslook_log])) and (isset($arslog_date_all)) and (isset($arslog_fdate_all)) )
	{
	
		$arsstamp_start=mktime(0, 0, 0, (int)($arslog_date_all[1]), (int)($arslog_date_all[0]), (int)($arslog_date_all[2]));
		$arsstamp_fin=mktime(23, 59, 59,(int)($arslog_fdate_all[1]), (int)($arslog_fdate_all[0]), (int)($arslog_fdate_all[2]));
		
		
		$get_log_ars=mysql_query("select * from oldbk.clans_arsenal_log where klan=(select short from oldbk.clans where id='{$_POST[klan_ars]}') and `date`>='{$arsstamp_start}' and `date`<='{$arsstamp_fin}' ; ");
		if (mysql_num_rows($get_log_ars) >0)
		{
			while($row_log=mysql_fetch_array($get_log_ars))
			{
				if ((date("d",$row_log['date'])!=($split)) and ($split))   { echo "<HR>";  } else { echo "<br>"; }
				echo "<small>";
				echo " <font class=date>".date("d.m.Y H:i",$row_log['date'])."</font>"." ".$row_log[text];
				echo "</small>";
				$split=date("d",$row_log['date']);
			}
		}
		else
		{
			err("�� ��� ���� ��� ������!");
		}
	}

echo "</form></td><HR>";
}




	function expa ($str) 
	{
		$array = explode(";",$str);
		for ($i = 0; $i<=count($array)-2;$i=$i+2) 
		{
			$rarray[$array[$i]] = $array[$i+1];
		}
		return $rarray;
	}

	echo "<div align=center id=hint3></div>";

	if(!$_POST['newwin'])
 	{

 	if ( ($user[id]==14897) or ($user[id]==326) or ($user[id]==8540) )
	{
		if ($_POST[frsend])
		{
			$colo=mysql_fetch_array(mysql_query("select color from users where login='{$_POST[frlo]}' ; "));
			if ($_POST[frroom])
			{
				$rroomm=$user[room];
			}
			else
			{
				$rroomm='';
			}
			addchp("<font color=".$colo[color].">".$_POST[frtex]."</font>",$_POST[frlo],$rroomm);
		}
		echo "���������:)";
		echo "<form method=post>";
		echo "<input type=text name=frlo value='".$_POST[frlo]."'>";
		echo "<input type=text name=frtex>";
		echo "<input type=checkbox name=frroom> �������";
		echo "<input type=submit name=frsend value='send'>";
		echo "</form>";
	}


		$moj = unserialize($access[abils]);

		if($moj[$_POST['use']]==1) 
		{
			//echo $_POST['use'];
			//�������� �������� ������������� ����� � ���������� �� ����.
				switch($_POST['use']) {
				case "sleep":
					include("./magic/sleep.php");
				break;
				case "sleepf":
					include("./magic/sleepf.php");
				break;
				case "sleep_off":
					include("./magic/sleep_off.php");
				break;
				case "sleepf_off":
					include("./magic/sleepf_off.php");
				break;
				case "haosn":
					include("./magic/haosn.php");
				break;
				case "haosn_off":
					include("./magic/haosn_off.php");
				break;
				case "obezl":
					include("./magic/obezl.php");
				break;
				case "obezl_off":
					include("./magic/obezl_off.php");
				break;
				case "death":
					include("./magic/death.php");
				break;
				case "death0":
					include("./magic/death0.php");
				break;
				case "death_off":
					include("./magic/death_off.php");
				break;
				case "ldadd":
					include("./magic/ldadd.php");
				break;
				case "attack":
					include("./magic/eattack.php");
				break;
				case "battack":
					include("./magic/ebattack.php");
				break;
				case "pal_off":
					include("./magic/pal_off.php");
				break;
				case "marry":
					include("./magic/marry.php");
				break;
				case "unmarry":
					include("./magic/unmarry.php");
				break;
				case "ct_all":
					include("./magic/ct_all.php");
				break;
				case "check":

					include("./magic/check.php");
				break;
				case "vampir":
					include("./magic/vampir.php");
				break;
				case "bexit":
					include("./magic/bexit.php");
					$_SESSION['use_in_late_stage_fbattle'] = 1;
				break;
				case "ch_nick":
					include("./magic/ch_nick.php");
				break;
				case "ch_date":
					include("./magic/ch_date.php");
				break;
				case "ch_pass":
					include("./magic/ch_pass.php");
				break;
				case "ch_pol":
					include("./magic/ch_pol.php");
				break;
				case "lookmap":
					include("./magic/lookmap.php");
				break;
				break;
				case "lookpass":
					include("./magic/lookpass.php");
				break;

				case "bclose":
					include("./magic/bclose.php");
				break;

				case "adm_formul":
					include("./magic/adm_formul.php");
				break;
				
				case "adm_formulb":
					include("./magic/adm_formulb.php");
				break;
				
				case "ban_money":
					include("./magic/ban_money.php");
				break;				

				case "unban_money":
					include("./magic/unban_money.php");
				break;					

				case "teleportadmin":
					include("./magic/teleportadmin.php");
				break;
 				case "blago_l":
					include("./magic/blago_l.php");
				break;
				case "blago_d":
					include("./magic/blago_d.php");
				break;
				case "blagodel":
					include("./magic/blagodel.php");
				break;
				
				case "my_city_teleport":
					$ABIL=1;
					include("./magic/city_teleport.php");					
				break;	
							
				
				case "haos_vamp1":
					 if ($get_bank[ekr]>=$haos_vamp1[price])
					 	{
					 	$CHAOS=1;
						include("./magic/haos_vamp.php");
						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;

				case "haos_vamp2":
				      if ($get_bank[ekr]>=$haos_vamp2[price])
				      		{
				      		$CHAOS=2;
						include("./magic/haos_vamp.php");
							if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_vamp2[price]." where id=".$get_bank[id]." ; ");
								$get_bank[ekr]-=$haos_vamp2[price];
								///

				//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=70;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_vamp2[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					add_to_new_delo($rec); //�����

				 if (olddelo==1)
				 {
				 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES 	 ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_vamp2[price]." ���. (\"��������� ����������\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				 }

								}
						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;

			        case "haos_attak":
			        	 if ($get_bank[ekr]>=$haos_attak[price])
				      		{
				        	//��������� � ������� ��� �������

					        	$CHAOS_ATTACK=true;
							include("./magic/attack.php");
							if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_attak[price]." where id=".$get_bank[id]." ; ");
								$get_bank[ekr]-=$haos_attak[price];

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=71;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_attak[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					add_to_new_delo($rec); //�����
				 if (olddelo==1)
				 {
				 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES  ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_attak[price]." ���. (\"���������\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				 }


								header("Location: fbattle.php");
								die("<script>location.href='fbattle.php';</script>");
								}

						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;

			        case "haos_attakb":
			        	if ($get_bank[ekr]>=$haos_attakb[price])
				      		{
				      		$CHAOS_ATTACK=true;
						include("./magic/battack.php");
								if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_attakb[price]." where id=".$get_bank[id]." ; ");
								$get_bank[ekr]-=$haos_attakb[price];

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=72;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_attakb[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					add_to_new_delo($rec); //�����
				 if (olddelo==1)
				 {
				 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES  ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_attakb[price]." ���. (\"�������� ���������\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				 }

								header("Location: fbattle.php");
								die("<script>location.href='fbattle.php';</script>");
								}
						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}

				break;

			        case "haos_travm":
						if ($get_bank[ekr]>=$haos_travm[price])
				      		{

						include("./magic/ct_all.php");
						 		if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_travm[price]." where id=".$get_bank[id]." ; ");
								$get_bank[ekr]-=$haos_travm[price];
					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=73;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_travm[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					add_to_new_delo($rec); //�����
				 if (olddelo==1)
				 {
				 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_travm[price]." ���. (\"������� �����\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				 }

								//+ ������ ������ � ����� � ���������� ��� ������� ������

								}
						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;

				case "haos_sleep":
						if ($get_bank[ekr]>=$haos_sleep[price])
				      		{
						$CHAOS=1;
						include("./magic/sleep30.php");
						 		if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_sleep[price]." where id=".$get_bank[id]." ; ");
								$get_bank[ekr]-=$haos_sleep[price];
					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=74;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_sleep[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					add_to_new_delo($rec); //�����
				 if (olddelo==1)
				 {
				 	mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES  ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_sleep[price]." ���. (\"�������� 30 ���.\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				 }

								//+ ������ ������ � ����� � ���������� ��� ������� ������

								}
						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;

				case "haos_unclone":
						if ($get_bank[ekr]>=$haos_unclone[price])
				      		{
						$CHAOS=1;
						include("./magic/unclone.php");
						 		if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_unclone[price]." where id=".$get_bank[id]." ; ");
								$get_bank[ekr]-=$haos_unclone[price];
					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=75;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_unclone[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					$rec['battle']=$user[battle];
					add_to_new_delo($rec); //�����
				 if (olddelo==1)
				 {
				 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES	 ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_unclone[price]." ���. (\"���������� �����\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				 }

								//+ ������ ������ � ����� � ���������� ��� ������� ������

								header("Location: fbattle.php");
								die("<script>location.href='fbattle.php';</script>");
								}
						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;


				case "haos_bexit":
						if ($get_bank[ekr]>=$haos_bexit[price])
				      		{
				      		$CHAOS=true;
						include("./magic/bexit.php");
								if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_bexit[price]." where id=".$get_bank[id]." ; ");
								$get_bank[ekr]-=$haos_bexit[price];
					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=76;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_bexit[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					$rec['battle']=$user[battle];
					add_to_new_delo($rec); //�����
				 if (olddelo==1)
				 {
				 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES 	 ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_bexit[price]." ���. (\"����� �� ���\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				 }

								header("Location: fbattle.php");
								die("<script>location.href='fbattle.php';</script>");
								}
						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;

				case "haos_hill180":
						if ($get_bank[ekr]>=$haos_hill180[price])
				      		{
						//�������������� ���������
						// ����������
						if ($user[battle]>0)
						 		{
						 		//� ����
						 		///�����������
						 		$get_hill=mysql_fetch_array(mysql_query("SELECT * from battle_vars where battle='{$user[battle]}' ;"));
						 		 if  ($get_hill[istok_use] < $haos_hill180[kol])
						 		 	{
						 		 	//������� +1
				 		 			mysql_query("INSERT battle_vars (`battle`, `owner`, istok_use) values ('{$user[battle]}', '{$user[id]}', 1 ) ON DUPLICATE KEY UPDATE `istok_use`=`istok_use`+1 ; ");
						 		 	$CHAOS=true;
						 		 	$cure_value = 180;
									$self_only = true;
									$_POST['target']=$user[login];
									include("./magic/cure_base.php");
						 		 	}
						 		 	else
						 		 	{
						 		 	echo "��������� ����� ������������� � ���� ���";
						 		 	}
						 		}
						 		else
						 		{
						 		//�� � ���
								$CHAOS=true;
								$cure_value = 180;
								$self_only = true;
								$_POST['target']=$user[login];
								include("./magic/cure_base.php");
						 		}

								if ($bet==1)
								{
								mysql_query("UPDATE oldbk.bank set ekr=ekr-".$haos_hill180[price]." where id=".$get_bank[id]." ; ");
									$get_bank[ekr]-=$haos_hill180[price];

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=77;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$haos_hill180[price];
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
					$rec['bank_id']=$get_bank[id];
					$rec['add_info']=$get_bank[ekr];
					$rec['battle']=$user[battle];
					add_to_new_delo($rec); //�����
				if (olddelo==1)
				{
				 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES  ('','0','{$user[id]}','C� ����� �".$get_bank[id]." ��������� ".$haos_hill180[price]." ���. (\"�������������� ������� +180\") ������� ".$get_bank[ekr]." ',44,'".time()."');");
				}


								  if ($user[battle]>0)
								  	{
								  	header("Location: fbattle.php");
									die("<script>location.href='fbattle.php';</script>");
									}
								}


						}
						else
						{
						echo "<font color=red>������������ ������� �� ����� �����!</font>";
						}
				break;

			}
		}
		echo "<table>";
		echo "<tr><td><br><br>";

		if ($user[align]==5)
		{
			if ($get_bank[id]>0)
			{
				echo "� ���������� ��������� ���������� ���� �".$get_bank[id]." �� �������: <b>".$get_bank[ekr]." ���.</b> <br> ";
			}
		}

		$brc=0;
		foreach($moj as $k => $v) {
		$brc++;			
		if ($brc>30) { echo "<br>";$brc=0; }
			//�������� �������� ������������� ����� � ���������� �� ����.
			if($v==1)
			{
				switch($k) 
				{
					case "sleep": $script_name=""; $magic_name="�������� �������� ��������"; break;
					case "sleepf":
					if ((($user['align'] > '2' && $user['align'] < '3') || $user['align'] == '1.99') && $user['id'] != 326) 
					{
						$script_name="f"; $magic_name="�������� �������� ��������� ��������";
					}
					elseif ($user['id'] == '326') 
					{
						$script_name="ff"; $magic_name="�������� �������� ��������� ��������";
					}
					else 
					{
						$script_name=""; $magic_name="�������� �������� ��������� ��������";
					}
					break;
					case "sleep_off": $script_name="1"; $magic_name="����� �������� ��������"; break;
					case "sleepf_off": $script_name="1"; $magic_name="����� �������� ��������� ��������"; break;
					case "haosn": $script_name="144"; $magic_name="�������� �������� �����"; break;
					case "haosn_off": $script_name="1"; $magic_name="����� �������� �����"; break;
					case "death": $script_name="1"; $magic_name="�������� �������� ������"; break;
					case "death0": $script_name="1"; $magic_name="�������� �������� ������"; break;
					case "death_off": $script_name="1"; $magic_name="����� �������� ������"; break;
					case "obezl": $script_name="2"; $magic_name="�������� �������� �������������"; break;
					case "obezl_off": $script_name="1"; $magic_name="����� �������� �������������"; break;
					case "pal_off": $script_name="1"; $magic_name="������ ������ �������"; break;
					case "attack": $script_name="1"; $magic_name="���������"; break;
					case "battack": $script_name="1"; $magic_name="�������� ���������"; break;
					case "marry": $script_name="4"; $magic_name="���������������� ����"; break;
					case "unmarry": $script_name="4"; $magic_name="����������� ����"; break;
					case "hidden": $script_name="1"; $magic_name="�������� �����������"; break;
					case "teleportadmin": $script_name="1"; $magic_name="������������ � ����"; break;
					case "check": $script_name="1"; $magic_name="��������� ��������"; break;
					case "ct_all": $script_name="1"; $magic_name="�������� �� �����"; break;
					case "pal_buttons": $script_name=""; $magic_name="�������� � ����������� ��������"; break;
					case "vampir": $script_name="1"; $magic_name="��������� (������ ������� ������� ������)"; break;
					case "ch_nick": $script_name="5"; $magic_name="������� ��� ���������"; break;
					case "ch_date": $script_name="6"; $magic_name="������� ���� ���������"; break;
					case "ch_pass": $script_name="1"; $magic_name="������� ������ ��������� �� 123321"; break;
					case "ch_pol": $script_name="1"; $magic_name="������� ��� ���������"; break;
					case "lookmap": $script_name="11"; $magic_name="�������� ����� ��������� �� ������"; break;
					case "lookpass": $script_name="1"; $magic_name="�������� ������ ���������"; break;
					case "bclose": $script_name="12"; $magic_name="������� ��� �� ������������� -�����"; break;
					case "adm_formul": $script_name="12"; $magic_name="�������� ���� ������ -�����"; break;
					case "adm_formulb": $script_name="12"; $magic_name="�������� ���� ������+����� -�����"; break;	
					//case "brat": $script_name="runmagic1"; $magic_name="������ ������� ������� (��������� � ��������)"; break;
					case "dneit": $script_name=""; $magic_name="��������� ���������� (����������� ��������)"; break;
					case "dpal": $script_name=""; $magic_name="��������� ���������� (����� ��������)"; break;
					case "ddark": $script_name=""; $magic_name="��������� ���������� (������ ��������)"; break;
					case "note": $script_name=""; $magic_name="������������� ������ ����"; break;
					case "sys": $script_name=""; $magic_name="��������� � ��� ��������� ���������"; break;
					case "scanner": $script_name=""; $magic_name="�������� ��� �������� ����������"; break;
					case "rep": $script_name=""; $magic_name="����� � ���������"; break;
					case "rost": $script_name=""; $magic_name="��������� ������"; break;
					case "ldadd": unset($script_name); $magic_name=""; break;
					case "bexit": $script_name="1"; $magic_name="����� �� ���"; break;
	
					case "blago_l": $script_name="1"; $magic_name="������� ��������������"; break;
					case "blago_d": $script_name="1"; $magic_name="������ ��������������"; break;
	
					case "haos_vamp1": $script_name="1"; $magic_name="��������� ����� (��������� ������)"; break;
					case "haos_vamp2": $script_name="1"; $magic_name="��������� ����� (���������� ������ ".$haos_vamp2[price]." ���.)"; break;
					case "haos_attak": $script_name="1"; $magic_name="��������� (".$haos_attak[price]." ���) "; break;
					case "haos_attakb": $script_name="1"; $magic_name="�������� ��������� (".$haos_attakb[price]." ���) "; break;
					case "haos_travm": $script_name="1"; $magic_name="�������� �� ����� (".$haos_travm[price]." ���)"; break;
					case "haos_sleep": $script_name="1"; $magic_name="�������� 30 ���. (".$haos_sleep[price]." ���)"; break;
					case "haos_unclone": $script_name="1"; $magic_name="���������� �����. (".$haos_unclone[price]." ���)"; break;
					case "haos_bexit": $script_name="7"; $magic_name="����� �� ��� (".$haos_bexit[price]." ���)"; break;
					case "haos_hill180":$script_name="7"; $magic_name="�������������� ������� 180HP (".$haos_hill180[price]." ���)"; break;
					
					case "my_city_teleport": $script_name="10";  $magic_name="�����������������"; break;
					
					case "blagodel": $script_name="1"; $magic_name="������� �������������� (����� ��� ���� � �����!)"; break;
					
					case "ban_money": $script_name="155"; $magic_name="������ �� ����� �����"; break;
					case "unban_money": $script_name="1"; $magic_name="����� ������ �� ����� �����"; break;					
				}
			
				
				if (isset($script_name)) {
					print "<a onclick=\"javascript:new_runmagic('$magic_name','$k','target','target1','$script_name'); \" href='#'><img src='http://i.oldbk.com/i/magic/".$k.".gif' title='".$magic_name."'></a>&nbsp;";
				}
			}
		}
		echo "</td>";
		echo "</tr></table>";

		if (($user['align'] > '1.2' && $user['align'] < '2') || ($user['align'] > '2' && $user['align'] < '3') || ($user['align'] == '7') || ($user['id'] == 5) )
		{
			echo "<form method=post action=\"?\">�������� � \"����\" ������ ������� � ��������� ������, ��������� � ��. <br>
					<table><tr><td>������� ����� </td><td><input type='text' name='ldnick' value='$ldtarget'></td><td> ��������� <input type='text' size='50' maxlength='400' name='ldtext' value=''></td><td><input type='hidden' name='use' value='ldadd'><input type=hidden name=dec value=\"off\"><input type=submit value='��������'></td></tr>";
			if (($user['align'] > '1.4' && $user['align'] < '2') || ($user['align'] > '2' && $user['align'] < '3')) {
				if ($ldblock) {
					echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' checked> ��������, ��� ������� �������� � ����/����������</td></tr>";
				}
				else {
					echo "<tr><td colspan=4><input type='checkbox' name='red' class='input' > ��������, ��� ������� �������� � ����/����������</td></tr>";
				}
			}
			echo "</table></form>";
		}
		
            if($user[id]=='14897' || $user[id]=='8540')
            {
		 if (($_POST[hlam]) AND ($_POST[hlam_login]) AND ($_POST[hlam_item]) )
		 {
		 	//���� ����
		 	$get_telo=mysql_fetch_assoc(mysql_query("select * from oldbk.users where login='".htmlspecialchars(mysql_real_escape_string($_POST[hlam_login]))."' LIMIT 1;"));
		 	if ($get_telo[id]>0)
		 	{
		 	//err("��� ������");
		 			 mysql_query("DELETE from oldbk.inventory where owner='{$get_telo[id]}' and name='".htmlspecialchars(mysql_real_escape_string($_POST[hlam_item]))."' and dressed=0 and setsale=0 and arsenal_klan='' and arsenal_owner=0 ;")	;
		 			 $del_kol=mysql_affected_rows();
		 			 err("������� $del_kol ���������!");
		 	}
		 	else
		 	{
		 	err("����� ��� �� ������!");
		 	}
		 	
		 }
           
                echo "<br><h4>��������� ����. </h4>";
		echo '<form method="post">����� � ���� ���������:<input type=text name="hlam_login"><br><b>�������� ��������:</b><input type=text name="hlam_item" value="������"><br><input type=submit name="hlam" value="������� ��� �������� � ���� ���������!"></form> ';
            }


		if (ADMIN || $user['id'] == 8325)
		{
		  echo "<br><br><h4>�������� �����. </h4>";
	          echo '<form name="" action="" method="post">';
	          echo "��������� ���� (���� ������ ���� � ���������):";
		  echo '<select size="1" name="priv_it">';
	    	    $data=mysql_query('select * from oldbk.inventory where owner='.$user[id].' AND (type <12 OR type=28);');
	            while($new_it=mysql_fetch_assoc($data))
	            {
	            echo '<option '.($new_it[id]==$_POST[priv_it]?'selected':'').' value="'.$new_it[id].'">'.$new_it[name].'['.$new_it[unik].']['.$new_it[id].']</option>';
	            }
	            echo '</select>';
	            echo '�� ����:  <input type=text name=priv_id>';
	           echo "&nbsp;<input type=submit value=���������></form>";

			if ($_POST[priv_id] && $_POST[priv_it])
				{
				$priv_it=(int)($_POST[priv_it]);
				$priv_id=(int)($_POST[priv_id]);
				mysql_query("UPDATE oldbk.`inventory` SET `sowner`='{$priv_id}' WHERE `id`='{$priv_it}' and owner='{$user[id]}';");
				echo "������� ��������...<br>";
				}


		}



       if($access[i_angel])
       {
		/*
            if($user[klan]=='radminion' || ($user[id]=='326' || $user[id]=='182783'))
	       {

		
	          echo "<br><br><h4>��������� �����. </h4>";
	          echo '<form name="" action="" method="post"><input name="new_it" type="hidden" value="'.$_POST[new_it].'">';
	          echo "������������� ���� (���� ������ ���� � ���������):";
			  echo '<select size="1" name="new_it">';
	    		$data=mysql_query(' select * from oldbk.inventory where owner='.$user[id].' AND (type <12 OR type=28);');
	            while($new_it=mysql_fetch_assoc($data))
	            {
	                echo '<option '.($new_it[id]==$_POST[new_it]?'selected':'').' value="'.$new_it[id].'">'.$new_it[name].'['.$new_it[unik].']['.$new_it[id].']</option>';
	            }
	            echo '</select>';
	           echo "&nbsp;<input type=submit value=�������������></form>
	           <form name= action='' method=post><input name=new_it type=hidden value=".$_POST[new_it].">
	           ";


	          if((int)$_POST[new_it])
	          {
	             $data=mysql_fetch_assoc(mysql_query('select * from oldbk.inventory where owner='.$user[id].' AND (type <12 OR type=28) AND id='.$_POST[new_it].' ;'));
	             $up=0;
	             $sql='';
	             $txt='';
	            // print_r($_POST);
	             if($_POST[unik])
	             {
	             	$sql.='unik=1, type3_updated =1,';
	             	$txt.='(����)';
	             	$up=1;
	             }
	             if((int)$_POST['stat'])
	             {
	                $sql.='stbonus=stbonus+'.$_POST['stat'].',';
	                $up=1;
	                $txt.=' ���� '.($_POST['stat']>0?'+':'-').$_POST['stat'];
	             }
	             if((int)$_POST['ghp'])
	             {
	             	$sql.='ghp=ghp+'.$_POST['ghp'].',';
	             	$up=1;
	                $txt.=' ����� '.($_POST['ghp']>0?'+':'-').$_POST['ghp'];
	             }
	             if((int)$_POST['bron'])
	             {
	             	$sql.='bron1=IF(bron1>0,(bron1+'.$_POST['bron'].'),0), bron2=IF(bron2>0,(bron2+'.$_POST['bron'].'),0), bron3=IF(bron3>0,(bron3+'.$_POST['bron'].'),0), bron4=IF(bron4>0,(bron4+'.$_POST['bron'].'),0),';
	             	$up=1;
	             	$txt.=' ����� '.($_POST['bron']>0?'+':'-').$_POST['bron'];
	             }
	             if((int)$_POST['includemagicuses']>0)
	             {
	             	$sql.='includemagicuses=includemagicuses+'.$_POST['includemagicuses'].',';
	             	$up=1;
	             	$txt.=' .���� '.($_POST['includemagicuses']>0?'+':'-').$_POST['includemagicuses'];
	             }
	             if($up)
	             { 	                $sql=substr($sql,0,-1);

	             	$sql='update oldbk.inventory set '.$sql.' where owner='.$user[id].' AND (type <12 OR type=28) AND id='.$_POST[new_it].' ;';
                    //echo $sql;
	             	mysql_query($sql);

	                $sql='insert into unic_log
								(`item_id`,`time`,`creater`,`where_cr`,`what_add`)
								values
								('.$_POST[new_it].','.time().','.$user[id].',1,"'.$txt.'");';
							//	echo $sql;
	                mysql_query($sql);

					//new_delo
  		    			$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=0;
					$rec['owner_balans_posle']=0;
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=10001;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($data);
					$rec['item_name']=$data['name'];
					$rec['item_count']=1;
					$rec['item_type']=$data['type'];
					$rec['item_cost']=$data['cost'];
					$rec['item_dur']=$data['duration'];
					$rec['item_maxdur']=$data['maxdur'];
					$rec['item_ups']=$data['ups'];
					$rec['item_unic']=$data['unic'];
					$rec['item_incmagic']=$data['includemagicname'];
					$rec['item_incmagic_count']=$data['includemagicuses'];
					$rec['item_arsenal']='';
					$rec['add_info']=$txt;
					add_to_new_delo($rec); //�����
			if (olddelo==1)
			{
	                mysql_query("INSERT INTO oldbk.`delo` (`id` , `author` ,`pers`, `text`, `type`, `date`)
					VALUES ('','0','{$_SESSION['uid']}','�������� ���� \"".$data['name']."\"
					id:(".get_item_fid($data).") ".$txt." ������� \"".$user['login']."\" ', 33,'".time()."');");
			}

	             }




                $data=mysql_fetch_assoc(mysql_query('select * from oldbk.inventory where owner='.$user[id].' AND (type <12 OR type=28) AND id='.$_POST[new_it].' ;'));
	             echo '<br>';

	             echo '

	             <table>
	             	<tr>
	             		<td valign=top align=left>
	             		   <table>
	             		   <tr><td colspan=2>
		             		   ���� �����:
		             	   </td></tr>
		             	    <tr><td>
		             		   ����: </td><td>'.$data[gsila].'
		             		</td></tr>
		             	    <tr><td>
							   ��������: </td><td>'.$data[glovk].'
							</td></tr>
		             	    <tr><td>
							   ��������: </td><td>'.$data[ginta].'
							</td></tr>
		             	    <tr><td>
							   ��������: </td><td>'.$data[gintel].'
							 </td></tr>
		             	    <tr><td>
		                       ���������: </td><td>'.$data[stbonus].'
		                    </td></tr>
		                    <tr><td>
		                       ������� ����<td></td><td><input name="stat" type="text" value="0">
		                    </td></tr>
		                    <tr><td>
		                    �������� ��� ����</td><td><input name="unik" type="checkbox" '.($data[unik]==1?'checked':'').' value="1">
		                    </td></tr>
		             	    </table>
		             	    <br>
	             		</td></tr>
	             		<tr>
	             		<td valign=top align=left>
	             			���� �����: '.$data[ghp].'<br>

		                    ������� ����� (���-��): <input name="ghp" type="text" value="0">
	                         <br>
	             		</td></tr>
	             		<tr>
	                    <td valign=top align=left>
	                     <table>
	             		   <tr><td colspan=2>
		             		   ���� �����:
		             	   </td></tr>
		             	    <tr><td>
		             		   �����1: </td><td>'.$data[bron1].'
		             		</td></tr>
		             	    <tr><td>
							   �����2: </td><td>'.$data[bron2].'
							</td></tr>
		             	    <tr><td>
							   �����3: </td><td>'.$data[bron3].'
							</td></tr>
		             	    <tr><td>
							   �����4: </td><td>'.$data[bron4].'
							 </td></tr>
							 <tr><td>
		                     ������� ����� </td><td> <input name="bron" type="text" value="0">
		                     </td></tr>
	                      </table> <br>';
                      if($data['includemagic']>0)
                      {

                         echo
                         	'<table>
                         		<tr>
                         			<td>
                         				�������� �����: <b>' .$data['includemagicname'].'</b><br>
                         			</td>
                         		</tr>
                         		<tr>
                         			<td>
                         				���-�� ����: '.$data['includemagicuses'].' ��������: <input name="includemagicuses" type="text" value="0">
                         			</td>';

                         echo '
                         		<tr>
                         	</table>';
                      }


	               echo '<input type="submit" value="��������">
	                    </td>

	             	</tr>
	             </table>
	             ';
	       	     echo '</form>';

	            // print_r($data);
	          }
           }*/

	echo "<td><form method=post><h4>������� � ���� �����</h4><br>";
		if (($_POST[get_kazna]) and ($_POST[klan_kazna]) and ($_POST[klan_kazna_ekr]))
		{
		//���������
		$get_ekr=round($_POST[klan_kazna_ekr],2);
		$kazna_id=(int)($_POST[klan_kazna]);
		 if (($get_ekr > 0 ) and ($kazna_id>0))
		 {
		 require_once("clan_kazna.php");
		   $kazna_id=clan_kazna_have($kazna_id);
		    if ($kazna_id)
		    {
		    $coment='������� ��������������';
		     if (pay_from_kazna($kazna_id[clan_id],2,$get_ekr,$coment))
		     	{
		     	 err("������� �������!<br>");
		     	}
		     	else
		     	{
		     	err("� ����� �����:".$kazna_id[ekr]."���.<br>");
		     	}
		    }
		 }
		}
	
	echo "<select size='1' name='klan_kazna'>
 	      <option value=0>�������� ����</option>";
                $sql_klan=mysql_query("SELECT cl.id, cl.short FROM oldbk.clans cl LEFT JOIN oldbk.clans_kazna ka ON cl.id=ka.clan_id where ka.clan_id>0 order by cl.short;");
                while($kl=mysql_fetch_array($sql_klan))
                {
                echo "<option value=".$kl[id]." ".($kl[id]== $_POST[klan_kazna] ? "selected" : "")."  >".$kl[short]."</option>";
                }
	echo "</select>";
	echo " ������� �����:<input type='text' name='klan_kazna_ekr' value='' >";
	echo " <input type=submit name=get_kazna value='�������'></td>";

          // print_r($_POST);
          echo "<br><br><form method=post action=\"?\"><h4>������� ��� �� �����. </h4>";
          echo '<form method="post">';
          if((!$_POST[bank_num]&&!$_POST[edit]))
          {
          	 echo '������� � ����� <input name="bank_num" type="text" value="">&nbsp;<input type="submit" value="��������">';
          }
          elseif(((int)$_POST[bank_num]>0 && !$_POST[dis_ekr] && !$_POST[edit]) || ((int)$_POST[bank_num]>0 && ((int)$_POST[dis_ekr]>(int)$_POST[ekr] || $_POST[edit]=='������� ����')))
          {
             if($_POST[dis_ekr]>0 && $_POST[edit]!='������� ����')
             {
             	echo '<font color=red><b>�� ���������� ����� �� �����</b></font><br>';
             }
             $bank_sh=mysql_fetch_assoc(mysql_query('select * from oldbk.bank where id = '.$_POST[bank_num].';'));
             echo '� �����&nbsp;&nbsp;<input name="bank_num" type="text" value="'.$bank_sh[id].'">&nbsp;&nbsp;
             	   <input name="edit" type="submit" value="������� ����"><br>
             	   ��������&nbsp;<input name="owner" type="text" disabled value="'.$bank_sh[owner].'"><br>
                   ��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="cr" type="text"  disabled value="'.$bank_sh[cr].'"><br>
                   ����&nbsp;&nbsp;&nbsp;<input name="ekr" type="hidden" value="'.$bank_sh[ekr].'"><input name="ekr" type="text" disabled value="'.$bank_sh[ekr].'"><br>
                   ������� ��� <input name="dis_ekr" type="text" value="0"><br>
                   <input type="submit" value="������� ����" name="edit">';
          }
          elseif((int)$_POST[dis_ekr]<=(int)$_POST[ekr] && $_POST[edit]=='������� ����')
          {
              mysql_query('update oldbk.bank set ekr=ekr-'.$_POST[dis_ekr].' WHERE id='.$_POST[bank_num].';');
              $from_telo=mysql_fetch_assoc(mysql_query("select * from oldbk.users where id=(select owner from oldbk.bank where id='{$_POST[bank_num]}')"));
              if ($from_telo[id_city]==1)
              			{
              $from_telo=mysql_fetch_assoc(mysql_query("select * from avalon.users where id='{$from_telo[id]}'"));              			
              			}
              
              echo '<font color=red><b>������� '.$_POST[dis_ekr].'��� �� ����� '.$_POST[bank_num].'</b></font><br>';
              					//new_delo
  		    			$rec['owner']=$from_telo[id];
					$rec['owner_login']=$from_telo[login];
					$rec['owner_balans_do']=$from_telo['money'];
					$rec['owner_balans_posle']=$from_telo['money'];
					$rec['target']=0;
					$rec['target_login']='orden';
					$rec['type']=10007;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$_POST[dis_ekr];
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
					$rec['bank_id']=$_POST[bank_num];
					$rec['add_info']='';
					add_to_new_delo($rec); //�����
              
              
          	  echo '������� ������<input name="bank_num" type="text" value="'.$_POST[bank_num].'">&nbsp;<input type="submit" value="��������">';
          }
          echo '
		  </form>';


       		echo '<br>';echo '<br>';
			$data=mysql_query('select * from place_zay WHERE type !=61 order by start limit 4');
			while($row=mysql_fetch_array($data))
			{
				echo '<a target=_blank href=?sh_bl_u='.$row[id].'>'.$row[coment].'  �.'.$row[z_curent1].'('.$row[t1c].')  VS  �.'.$row[z_curent2].'('.$row[t2c].')</a><br>';
			}
			echo '<br>';echo '<br>';
		}

 // �������� �������
       if($access[i_angel])
       {
         // print_r($_POST);
          echo "<br><br><form method=post action=\"?\"><h4>�������� �������. </h4>";
          echo '<form method="post">';
          echo '������� ���: <input name="postnick" type="text" value="">&nbsp; �����:<input name="postkr" type="text" size=5 value="">&nbsp;<input type="submit" value="���������">';
		  if ($_POST['postnick']!='' and $_POST['postkr']!='' and is_numeric($_POST['postkr']))
			{
			 $komu=mysql_fetch_array(mysql_query("select * from oldbk.users where login = '".$_POST['postnick']."' LIMIT 1;"));
			 $city_pref='oldbk.';
			 if ($komu[id_city]==1)
			 	{
				 $komu=mysql_fetch_array(mysql_query("select * from avalon.users where login = '".$_POST['postnick']."' LIMIT 1;"))	;
				 $city_pref='avalon.';
			 	}
//echo $_POST['postnick']."|".$_POST['postkr']."<br>";
//print_r($komu);
			 $_POST['postkr']=round($_POST['postkr'],2);
			 if ($_POST['postkr']<= $user['money'])
			 	{
				if ($user[id_city]==1) {  $city_pref_my='avalon.'; } else {  $city_pref_my='oldbk.'; }


				 if (mysql_query("UPDATE ".$city_pref_my."`users` set `money`=money-'".strval($_POST['postkr'])."' where id='".$user['id']."'") && mysql_query("UPDATE ".$city_pref."`users` set `money`=money+'".strval($_POST['postkr'])."' where id='".$komu['id']."'"))
				 	{
					 $mess='������ �������� '.strval($_POST['postkr']).' �� � ��������� '.$komu['login'];

					 					//new_delo
  		    		$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=($user['money']-strval($_POST['postkr']));
					$rec['target']=$komu['id'];
					$rec['target_login']=$komu['login'];
					$rec['type']=166;//�������� ��������
					$rec['sum_kr']=strval($_POST['postkr']);
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
					$rec['type']=167;//��������� ��������
  		    			$rec['owner']=$komu[id];
					$rec['owner_login']=$komu[login];
					$rec['owner_balans_do']=$komu['money'];
					$rec['owner_balans_posle']=($komu['money']+strval($_POST['postkr']));
					$rec['target']=$user['id'];
					$rec['target_login']=$user['login'];
					$rec['add_info']='����������� �������';
					add_to_new_delo($rec); //����
					 if (olddelo==1)
					 {
					 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$_SESSION['uid']}','������ �������� ".strval($_POST['postkr'])." ��. �� \"".$user['login']."\" � \"".$komu['login']."\" ',1,'".time()."');");
					 mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$komu['id']}','������ �������� ".strval($_POST['postkr'])." ��. �� \"".$user['login']."\" � \"".$komu['login']."\" ',1,'".time()."');");
					 }

					 $user['money']-=($_POST['postkr']);

					 $message="<font color=red>��������!</font> ��� ������ �������� ������� ".strval($_POST['postkr'])." ��. �� <span oncontextmenu=OpenMenu()>".$user['login']."</span>   ";
					 //echo telepost($komu['login'],$message);
					 echo telepost_new($komu,$message);
					}
				else
					{
					 $mess="��������� ������";
					}
				echo "<br>".$mess;
				}
			 else
			 	{echo "<font color=red>�� ������� �����!</font>";}
			}
          echo '
		  </form>';
       }




		if ($access[pal_tel]==1)
		{
			if($_POST['grn'] && $_POST['gr'] && (!$_POST['mass_pal'] || !$_POST['mass_light'] || !$_POST['mass_dark'] || !$_POST['mass_neitr'])) {
			$rec=trim($_POST['grn']);
			$rec=explode(',',$rec);
			
				for($i=0;$i<count($rec);$i++)
				{
					if ($_POST['dec']=='on')
					{
						$logrn=$rec[$i];
						$logr=iconv('utf-8', 'cp1251', $_POST['gr']);
						echo telegraph($logrn,$logr).' <br>';
					}
					else
					{
						echo telegraph($rec[$i],$_POST['gr']).' <br>';
					}
				}
			
			}
			//����� �� ������ ����� �������� ���� �������� �� ����� /����� ��� ���� ������
			elseif(
					$_POST['gr'] && (
										($_POST['mass_pal']||$_POST['mass_inc']||$_POST['mass_light']||$_POST['mass_dark']||$_POST['mass_neitr'])
										&&
											(
												($user['align']>'1.9'&&$user['align']<'2')
													||
												($user['align']>'2'&&$user['align']<'3')

											)
									)
					)
			{
				
				if($_POST['mass_inc']){$i[]="align =  '1.2'";}
				if($_POST['mass_pal']){$i[]="align >  '1.2' AND align < '2' ";}
				
				if($_POST['mass_light']){$i[]="(align >= '1' AND align < '2') or align = 6 or (klan = 'Adminion' or klan='radminion') or id='3'";}
				
				if($_POST['mass_dark']){$i[]="align = 3 or (klan = 'Adminion' or klan='radminion') or id='4'";}
				
				if($_POST['mass_neitr']){$i[]="align = 2 or (klan = 'Adminion' or klan='radminion') or id='6'";}
				
				if ((ADMIN) and ($_POST['mass_deal'])) {$i[]="deal=1";}

				$filtr='';
				for($g=0;$g<count($i);$g++)
				{
					$filtr.='('.$i[$g] . ') or ';
				}
				$filtr = substr($filtr, 0, -4);
				//echo $filtr;
				
				
				
				$querry="SELECT * FROM oldbk.`users` WHERE ".$filtr.";";
				$rez=mysql_query($querry);
				while ($pals = mysql_fetch_assoc($rez)) {
					//telegraph($pals['login'],$_POST['gr'],'1');
					telegraph_new($pals,$_POST['gr'],'1');
				}
				echo '<b><font color=red>��� ���������</font></b><br>';
			}


           // print_r($_POST);
           echo '<span><a href="#" onclick="obj=this.parentNode.childNodes[1].style;tmp=(obj.display!=\'block\') ? \'block\' : \'none\';obj.display=tmp;return false;"><h4>��������</h4>�� ������ ��������� �������� ��������� ������ ���������, ���� ���� �� ��������� � offline ��� ������ ������.</a>';
			echo '<div class="subblock" style="display: none;"><p>�������� ��������!';

			echo '
					<form method=post style="margin:5px;">
						�����/������:<br><input type=text size=100 name="grn">*����� ������� ��� �������� (����,����,����)<br>
						����� ���������:<br><input type=text size=100 name="gr" maxLength="500">*500 ��������<br>';

					if (($user['align'] > '1.9' && $user['align'] < '2') || $user['align'] == '2.4' || $user['align'] == '2.7')
					{
						echo '����-�������� <b>��������</b>: <input type="checkbox" name="mass_pal"><br>';
					}
     					if ($user['id'] == 3 || ADMIN)
					{
						echo '����-�������� <b>�����������</b>: <input type="checkbox" name="mass_inc"><br>';
						echo '����-�������� <b>�������</b>: <input type="checkbox" name="mass_light"><br>';
					}
					    if ($user['id'] == 4 || $user['align'] == '2.4' || $user['align'] == '2.7')
					{
						echo '����-�������� <b>������</b>: <input type="checkbox" name="mass_dark"><br>';
					}
					    if ($user['id'] == 6 || $user['align'] == '2.4' || $user['align'] == '2.7')
					{
						echo '����-�������� <b>���������</b>: <input type="checkbox" name="mass_neitr"><br>';
					}
					 if ( (ADMIN) )
					 {
					 	echo '����-�������� <b>������</b>: <input type="checkbox" name="mass_deal"><br>';
					 }
					

			echo' <input type=hidden name=dec value="off">
						<input type=submit value="���������">
					</form>';
			echo  '
				   </p>
				   </div>
				</span>';
		}

////����
	if (($user['id']==648) OR ($user['id']==14897) OR ($user['id']==7937) OR ($user['id']==182783) OR ($user['id']==102904 ))
	{
	
	echo '<hr>';
	// print_r($_POST);	
	echo "<form method=post action=\"?\"><h4>�������� ������� �����: </h4> �����:<input type='text' name='looklog' value='{$_POST['looklog']}'>";
	echo " c: <input type=text value=\"24.04.2015\" name='lookekr_date' value='{$_POST['lookekr_date']}' id=\"calendar-inputFieldekr1\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"calendar-triggerekr1\" value='...'>";
	echo "
			<script>
			Calendar.setup({
		        trigger    : \"calendar-triggerekr1\",
		        inputField : \"calendar-inputFieldekr1\",
			dateFormat : \"%d.%m.%Y\",
			onSelect   : function() { this.hide() }
		    			});
			document.getElementById('calendar-triggerekr1').setAttribute(\"type\",\"BUTTON\");
			</script>";
	echo " ��: <input type=text value=\"".date("d.m.Y")."\" name='lookekr_fdate' value='{$_POST['lookekr_fdate']}' id=\"calendar-inputFieldekr2\"  style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"calendar-triggerekr2\" value='...'>";
	echo "
			<script>
			Calendar.setup({
		        trigger    : \"calendar-triggerekr2\",
		        inputField : \"calendar-inputFieldekr2\",
			dateFormat : \"%d.%m.%Y\",
			onSelect   : function() { this.hide() }
		    			});
			document.getElementById('calendar-triggerekr2').setAttribute(\"type\",\"BUTTON\");
			</script>";		
		
	echo "<input type=submit value='����������'></form>";
	if ($_POST['looklog']!='')
	{
	$getlog=mysql_fetch_array(mysql_query("select * from oldbk.users where login='".mysql_real_escape_string($_POST['looklog'])."'"));
	
		if (($getlog['login']!='') AND ($_POST['lookekr_date']=='') and  ($_POST['lookekr_fdate']=='') )
		{
		//���� �� ������� = ��� �������
		$get_data=mysql_query("select * from dilerdelo where owner='{$getlog['login']}' and addition=0 and dilername not like 'auto-%' order by id ");
		}
		elseif (($getlog['login']!='') AND ($_POST['lookekr_date']!='') and  ($_POST['lookekr_fdate']!='') )
		{
		//�������� ��� ��� ������
		// [lookekr_date] => 09.08.2014 [lookekr_fdate] => 09.08.2014 ) 
		$sld=explode(".",$_POST['lookekr_date']);
		$sldf=explode(".",$_POST['lookekr_fdate']);		
		$get_data=mysql_query("select * from dilerdelo where  owner='{$getlog['login']}'  and addition=0 and `date`>='".(int)($sld[2])."-".(int)($sld[1])."-".(int)($sld[0])."'  and `date`<='".(int)($sldf[2])."-".(int)($sldf[1])."-".(int)($sldf[0])."' and dilername not like 'auto-%' order by id");
		}
		elseif (($getlog['login']!='') AND ($_POST['lookekr_date']!='')  )
		{
		//���� � �� �����
		$sld=explode(".",$_POST['lookekr_date']);
		$get_data=mysql_query("select * from dilerdelo where  owner='{$getlog['login']}'  and addition=0 and `date`>='".(int)($sld[2])."-".(int)($sld[1])."-".(int)($sld[0])."'  and dilername not like 'auto-%' order by id");		
		}
		elseif (($getlog['login']!='') AND ($_POST['lookekr_date']=='') and  ($_POST['lookekr_fdate']!='') )
		{
		echo "������ ���� ������";		
		}		
		else
		{
		echo "�����  �������� �� ������ ";
		}
		
		if (mysql_num_rows($get_data) >0) 
		{
		$totekr=0;
			while($row=mysql_fetch_array($get_data))
			{
			echo "<span class=date>{$row['date']}</span> ������� �� ������ ".$row['dilername']." �����:<b>".$row['ekr']." ���.</b> �� ���� �:".$row['bank']."<br>";
			$totekr+=$row['ekr'];
			}
		echo "<hr> �����:<b>".$totekr."</b>";
		}
		
	}	
	
	//echo '<hr>';
		}

		
		///// �����������
  		if (ADMIN || ($user['align'] == "1.5" || $user['align'] == "1.7" || $user['align']  == "1.9" || $user['align'] == '1.91' || $user['align'] == '1.99') || $access['perevodi']>=5) {
			echo '<hr>';
			echo '<table><tr><td><h4>�����������:</h4></td><td><h4>��������:</h4></td></tr>';
			
			echo '<tr><td valign="top">';
			$i = 1;
			/*
			if (ADMIN || $user['align'] == '1.91' || $user['align'] == '1.99') {
				echo $i.'. <a target="_blank" href="usersscans.php">�������� ������������� ������</a><br>';
				$i++;
			}
			*/
			
			/*if (ADMIN || ($user['align'] == "1.5" || $user['align'] == "1.7" || $user['align']  == "1.9" || $user['align'] == '1.91' || $user['align'] == '1.99')) {
				echo $i.'. <a target="_blank" href="palrscans.php">������ ������</a><br>';
				$i++;
			}
			*/
			if($user[klan]=='Adminion' || $user[klan]=='radminion' || ($user[align]>=1.75 && $user[align]<2))
	        	{
	        		echo $i.'. <a target=_blank href=pal_logs.php>�������� �������� � �������</a><br>';
				$i++;
	        	}
	        	
	        	if($user[klan]=='Adminion' || $user[klan]=='radminion' || ($access[item_hist]==1))
	        	{
	        		echo $i.'. <a target=_blank href=haoslook.php>�������� ���������</a><br>';
				$i++;
	        	}

	         	if($user[klan]=='Adminion' || $user[klan]=='radminion' || ($access[zhhistory]==1))
	        	{
	        		echo $i.'. <a target=_blank href=zhhistory.php>������� �����</a><br>';
				$i++;
	        	}


			echo '</td><td valign=top>';
			$i = 1;


			if ($access['perevodi']>=5) {
				if (!$_POST['llogs'] || !$_POST['mlogs']) {$_POST['llogs']=date("d.m.y");$_POST['mlogs']=date("d.m.y");}
				echo $i.'. <a href="http://capitalcity.oldbk.com/perevod/perevod.php" target=_blank>������� ���������</a><br>';
				$i++;
			}				

			if($user['align']=='1.99' || $user['align']=='1.93' || $user['klan'] == 'radminion')
			{	
				echo $i.'. <a target=_blank href="http://capitalcity.oldbk.com/perevod/perevod.php?sh=3">������� �����</a><br>';
				$i++;
			}

			echo '</td></tr></table>';
		}



  		if (($user['align'] > '1.2' && $user['align'] < '2') || ($user['align'] > '2' && $user['align'] < '3'))
  		{
  		echo '<hr>';
  		
  		echo "<table border=0>
  		<tr valign=top><td>";
  		
		echo "<form method=post action=\"?\"><h4>�������� ������� �����. </h4>
					<table><tr><td>�������� ���� </td><td>

     				<select size='1' name='showklan'>
     				<option value=0>����</option>";

                   $sql=mysql_query_cache("SELECT * FROM oldbk.clans WHERE (time_to_del=0 OR (time_to_del>0 AND time_to_del>".time()."))order by short;",false,60*60*6);
              //  echo mysql_error();
                   while(list($k,$kl) = each($sql)) 
                   {
  					echo "<option value=".$kl[short]." ".($kl[short]== $_POST[showklan] ? "selected" : "")."  >".$kl[short]."</option>";


                   }
			echo "</select>
                    </td><td>
		<input type='hidden' name='use' value='klan'>
		<input type=submit value='����������'>
		</td></tr>";
		echo "</table></form>";




			if(strip_tags($_POST[showklan]) && strip_tags($_POST['use']))
			{
				$data=mysql_query(
				"SELECT u.id, u.login, u.room,
				u.status, u.klan, u.lab, u.in_tower, u.ldate, u.id_city
				FROM oldbk.users u
				WHERE u.klan='".$_POST[showklan]."'
				order by  u.ldate desc,
				u.login asc;"
				);
				
				while($row=mysql_fetch_array($data))
				{
					if($row[id_city]==1)
					{
						$row=mysql_fetch_assoc(mysql_query("SELECT u.id, u.login, u.room,
										u.status, u.klan, u.lab, u.in_tower, u.ldate
										FROM avalon.users u
										WHERE u.id='".$row[id]."';"));
					}
					if ($row['ldate'] >= (time()-60))
					{
					
						echo '<A HREF="javascript:top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="i/lock.gif" width=20 height=15></A>';
						echo nick33($row['id']);
						if($row['room'] > 500 && $row['room'] < 561) {
							$rrm = '����� ������, ��������� � �������';
						}
						else if ($row['lab'] > 0)
						{
							$rrm = '�������� �����';
						}
						else
						{
							$rrm = $rooms[$row['room']];
						}
						echo " - <b>".$row['status']."</b> - <i>".$rrm."</i><BR>";
					}
					
					elseif ($row['online']<1 || nick7($row[friend])=="<i>���������</i>") {
					echo '<img src="i/lock1.gif" width=20 height=15>';
					echo nick33($row[id]);
					echo " - <b>".$row['status']."</b> - <i><small><font color=gray>�������� �� � �����</font></small></i><BR>";
					}
					
					
					//echo mysql_error(). $_POST[showklan];
				}
			}
		
  		if ($user['align'] =='1.91' || $user['align'] == '1.99' || $user['klan']=='radminion' || $user['klan']=='Adminion')
		{
		echo "</td><td width=100> ";
		echo "</td><td>";		
		
		echo "<form method=post ><h4>�������� ������� ��������: </h4> �����:<input type='text' name='lookst' value='{$_POST['lookst']}'`>";
		echo "<input type=submit name=look value='����������'> ";				
		echo "<input type=submit name=del value='�������'></form>";		
		echo "</td><td width=40>";
		echo "</td><td>";		
			
					if (($_POST['lookst']) and ($_POST['look']))
						{
						$histdata=mysql_query("select l.who, l.text, l.sdate, u.id , u.login,u.align,u.klan, u.level from clan_status_log l LEFT JOIN users u on l.who=u.id where owner=(select id from users where login='".mysql_real_escape_string($_POST['lookst'])."'  )" );
						if (mysql_affected_rows()>0) 
							{
							echo "<small>";
							while($row=mysql_fetch_assoc($histdata))
							 			{
										echo " <font class=date>".$row[sdate]."</font>: ".s_nick($row['id'],$row['align'],$row['klan'],$row['login'],$row['level'])." ��������� ������:". $row['text']."<br>";
							 			}
							echo "</small>";							 			
							}
							else
							{
							echo "��� �������";
							}
						}
						elseif (($_POST['lookst']) and ($_POST['del']))
						{
						$sok=mysql_fetch_assoc(mysql_query("select id from users where login='".mysql_real_escape_string($_POST['lookst'])."'"));
						if ($sok['id']>0)
							{
							$soklan_id=$sok['id'];
						
							if(mysql_query('UPDATE `users` SET status = "����" WHERE id = "'.$soklan_id.'" ;'))
								{
									//�����������
									mysql_query("INSERT INTO `oldbk`.`clan_status_log` SET `who`='".$user['id']."',`owner`='".$soklan_id."' ,`text`='����' ");
									echo '������ �������.';
								}
							}
							else
							{
							echo "�������� �� ������";
							}
						}
				
		echo "</td>";
		}
		
		echo "</tr></table>";
		}
        
	        if ($access['perevodi']>=5 && ($log_kazna_klana || $log_ars_klana)) {		
			echo '<table><tr>';
			if ($log_kazna_klana) {
				print_klans_kazna();
			}

			if ($log_ars_klana) {
				print_klans_ars();
			}
			echo '</tr></table>';
			echo '<hr>';
		}


        	

		if (ADMIN || $user['id'] == 7937 || $user['id'] == 7937) {

			if (isset($_POST['givehelpera'],$_POST['givehelperact'],$_POST['givehelper']) && !empty($_POST['givehelper'])) {
				echo '<font color=red>';
				$tonick = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['givehelper']}' LIMIT 1;"));
				if ($tonick !== FALSE) {
					if ($_POST['givehelperact'] == 1) {
						if ($tonick['deal'] != -1) {
							echo "�������� �� �������� ����������.";
						} else {
							mysql_query("UPDATE `users` set `deal` = '0' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
							echo "������� ���� ������ ���������.";
						}
					} elseif ($_POST['givehelperact'] == 2) {
						if ($tonick['deal'] == -1) {
							echo "�������� ��� �������� ����������.";
						} else {
							mysql_query("UPDATE `users` set `deal` = '-1' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
							echo "������� �������� ������ ���������.";
						}
					}
				} else {
					echo '�������� �� ������.';
				}
				echo '</font>';
			}
		
			echo "<form method=post action=\"\"><b>���������/����� ������ ���������</b>
					<table><tr><td>����� </td><td><input type='text' name='givehelper' value=''></td><td>���������
					<select name='givehelperact'>
						<option value='1'>����� ������ ���������</option>
						<option value='2'>��������� ������ ���������</option>
					</select><td>
					<input type=submit name=givehelpera value='���������/�����'></td></tr></table>
				<hr>";
		}

		if (ADMIN || ($user['align'] >= 1.7 && $user['align'] <= 1.99))
		{
			if (isset($_POST['givebota'],$_POST['givebotact'],$_POST['givebot']) && !empty($_POST['givebot'])) {
				echo '<font color=red>';
				$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['givebot']}' LIMIT 1;"));
				if ($tonick === FALSE) mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE `login` = '{$_POST['givebot']}' LIMIT 1;"));

				if ($tonick !== FALSE) {
					if ($_POST['givebotact'] == 1) {
						mysql_query("UPDATE oldbk.`users` set `palcom` = '' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
						mysql_query("UPDATE avalon.`users` set `palcom` = '' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
						echo "������� ���� ������ ��������� ����.";
					} elseif ($_POST['givebotact'] == 2) {
						mysql_query("UPDATE oldbk.`users` set `palcom` = '�������� ���' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
						mysql_query("UPDATE avalon.`users` set `palcom` = '�������� ���' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
						echo "������� �������� ������ ��������� ����.";
					}
				} else {
					echo '�������� �� ������.';
				}
				echo '</font>';
			}
		
			echo "<form method=post action=\"\"><b>���������/����� ������ ��������� ����</b>
					<table><tr><td>����� </td><td><input type='text' name='givebot' value=''></td><td>�������� ����
					<select name='givebotact'>
						<option value='2'>��������� ������ ��������� ����</option>
						<option value='1'>����� ������ ��������� ����</option>
					</select><td>
					<input type=submit name=givebota value='���������/�����'></td></tr></table>
				<hr>";
		}

        	
        	$itemid=isset($_REQUEST['itemid'])?(int)$_REQUEST['itemid']:'';	
		if ($user['id']==3  || $user['id']==4 || $user['id']==6 || ($user['klan'] == 'Adminion' && $user['id'] != '19573') || $user['klan'] == 'radminion')
		{

			if ($_POST['givesklonka1']) 
			{
				if ($_POST['sklonkalog1'] && $_POST['sklonka1']) 
				{
					$tonick = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['sklonkalog1']}' LIMIT 1;"));
					if ($tonick['login']) 
					{
						$cheff=mysql_fetch_array(mysql_query("SELECT * from  `effects` WHERE type = '".$eff_align_type."' AND owner = '".$tonick['id']."' LIMIT 1;"));
						if ($_POST['sklonka1'] == 2 || $_POST['sklonka1'] == 3 || $_POST['sklonka1'] == 6)
						{
							if ($tonick['align'] || $tonick['klan']) 
							{
								print "<b><font color=red>�������� ��� ����� ���������� ���� ������� � �����!</font></b>";
							}
							elseif($cheff['time']>time() && $cheff['add_info']!=$_POST['sklonka1'])
							{
								echo '� ������� ��������� ��� �� ����� ����� �� ����� ����������';
							}
							elseif (mysql_query("UPDATE `users` set `align` = '{$_POST['sklonka1']}' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) 
							{
							//undressall($tonick['id'],$tonick['id_city']); 
								$qlist=array();
							        $i=0;
							        $data=mysql_query("SELECT * FROM oldbk.beginers_quest_list WHERE  aganist like '%".$_POST['sklonka1']."%';");
							        while($q_data=mysql_fetch_array($data))
							        {
							     		$qlist[$i]=$q_data[id];
							     		$i++;
							        }
							        mysql_query("UPDATE oldbk.beginers_quests_step set status =1 WHERE owner='".$tonick['id']."' AND quest_id in (".(implode(",",$qlist)).")");
							
								if ($_POST['sklonka1'] == 6) {$skl="�������"; $skl2="�������";}
								elseif ($_POST['sklonka1'] == 2) {$skl="�����������"; $skl2="�����������";}
								else {$skl="������"; $skl2="������";}
								
								mysql_query("INSERT INTO `effects`
								(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
								('".$eff_align_type."','����� �������','".$tonick['id']."','".$eff_align_time."','".$_POST['sklonka1']."');");
								
								//new_delo
								$rec['owner']=$tonick[id];
								$rec['owner_login']=$tonick[login];
								$rec['owner_balans_do']=$tonick['money'];
								$rec['owner_balans_posle']=$tonick['money'];
								$rec['target']=$user['id'];
								$rec['target_login']=$user['login'];
								$rec['type']=10002;
								$rec['sum_kr']=0;
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
								$rec['add_info']=$skl;
								add_to_new_delo($rec); //�����
								
								if ($user['sex'] == 1) {$action="��������";}
								else {$action="���������";}
								mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','����� &quot;".$user['login']."&quot; ".$action." &quot;".$_POST['sklonkalog1']."&quot; ".$skl2." ����������','".time()."');");
								print "<b><font color=red>������� ���������  {$skl} ���������� ��������� {$_POST['sklonkalog1']}!</font></b>";
							}
							else 
							{
									print "<b><font color=red>��������� ������!</font></b>";
							}
						}
						elseif ($_POST['sklonka1'] == 1)
						{
							if (!$tonick['align']) 
							{
								print "<b><font color=red>�������� �� ����� ���������� ���� ������� � �����!</font></b>";
							}
							elseif (mysql_query("UPDATE `users` set `align` = '0' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) 
							{
								undressall($tonick['id'],$tonick['id_city']); 
						 //new_delo
				  		    		$rec['owner']=$tonick[id];
								$rec['owner_login']=$tonick[login];
								$rec['owner_balans_do']=$tonick['money'];
								$rec['owner_balans_posle']=$tonick['money'];
								$rec['target']=$user['id'];
								$rec['target_login']=$user['login'];
								$rec['type']=10003;
								$rec['sum_kr']=0;
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
								$rec['add_info']=$tonick['align'];
								add_to_new_delo($rec); //�����
								if (olddelo==1)
								{
									mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`)
									VALUES ('','0','{$tonick['id']}','����� ���������� ������� ".$user['login']." ',1,'".time()."');");
								}

								if ($user['sex'] == 1)
								{$action="�����";}
								else
								{$action="������";}

								mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`)
								VALUES ('','".$tonick['id']."','����� &quot;".$user['login']."&quot; ".$action." &quot;".$_POST['sklonkalog1']."&quot; ����������','".time()."');");
								print "<b><font color=red>������� ����� ���������� � ��������� {$_POST['sklonkalog1']}!</font></b>";
	
							}
							else 
							{
								print "<b><font color=red>��������� ������!</font></b>";
							}
						}
					}
					else 
					{
						print "<b><font color=red>����� �������� �� ����������!</font></b>";
					}
				}
			}
		echo "<form method=post action=\"?\"><b>���������/����� ����������</b>
				<table><tr><td>����� </td><td><input type='text' name='sklonkalog1' value=''></td><td>����������
				<select name='sklonka1'>
					<option value='1'>����� ����������</option>
					<option value='6'>�������</option>
					<option value='2'>�����������</option>
					<option value='3'>������</option>
				</select><td>
				<input type=submit name=givesklonka1 value='���������/�����'></td></tr></table>";
		 if($user['id']==326 || $user['id']== 8540 ||  $user['id']== 14897)
		 	{
		 	if ( ($_POST[haosgivesklon])&&($_POST[haosklonlog])&&($_POST[haosklonbank]) && ($_POST[haosklon]) )
		 	{
		 	echo "<font color=red>";
		 		//1. ��������� �����
		 		 $targ=mysql_fetch_array(mysql_query("select * from users where login='{$_POST[haosklonlog]}' ;"));
		 	       if (($targ[id]>0)and($_POST[haosklon]==1))
		 	          {
		 	          //���������
		 	          //���������� ����. �������� ������ 10 � ���� ������.
		 		  if ($targ[level] >= 10)
		 		  	{
		 		  	//2 ��������� ����
		 		  	$hbankid=(int)($_POST[haosklonbank]);
		 		  	$hbank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$hbankid}' and owner='{$targ[id]}' ; "));
		 		  	     if ($hbank[id]>0)
		 		  	     	{
		 		  	     	 if ($hbank[haos]==0)
		 		  	     	 	{
		 		  	     	 	//echo "��� ��.";
		 		  	     	 	//������ ���� ��������
		 		  	     	 	mysql_query("update oldbk.bank set haos=1 where id='{$hbankid}' and owner='{$targ[id]}' ; ");
		 		  	     	 	//������ ������
		 		  	     	 	///���� �� ������ �������� � ��� ���� (300%) ������ ���� ��� ������ ���� ���������
		 		  	     	 	mysql_query("update users set align=5, expbonus=expbonus+3 where id='{$targ[id]}' ; ");
		 		  	     	 	//����� ����
							if ($user['sex'] == 1) {$action="��������";}
							else {$action="���������";}

					 //new_delo
	  		    		$rec['owner']=$targ[id];
					$rec['owner_login']=$targ[login];
					$rec['owner_balans_do']=$targ['money'];
					$rec['owner_balans_posle']=$targ['money'];
					$rec['target']=$user['id'];
					$rec['target_login']=$user['login'];
					$rec['type']=10002;
					$rec['sum_kr']=0;
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
					$rec['add_info']='���������� ����';
					add_to_new_delo($rec); //�����
							if (olddelo==1)
							{
		 		  	     	 	mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$targ['id']}','��������� ���������� ���������� ���� ������� ".$user['login']." ',1,'".time()."');");
		 		  	     	 	}

							mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$targ['id']."','����� &quot;".$user['login']."&quot; ".$action." &quot;".$targ['login']."&quot; ���������� ���������� ����','".time()."');");
							print "<b>������� ��������� ���������� &quot���������� ����&quot  ��������� {$_POST['sklonkalog1']}!</b>";
		 		  	     	 	}
		 		  	     	 	else
		 		  	     	 	{
		 		  	     	 	echo "� ����� ����� ��� ��������� ���������� ����.<br>";
		 		  	     	 	}
		 		  	     	}
		 		  	     	else
		 		  	     	{
		 		  	     	echo "������ ���� �� ����������� ���� ".$targ[login]."<br>";
		 		  	     	}
		 		  	}
		 		  	else
		 		  	{
		 		  	echo "�������� ������ � 10 ������ � ����. <br>";
		 		  	}
		 		  }
		 		  elseif (($targ[id]>0)and($_POST[haosklon]==2))
		 		  	{
		 		  	//�����
		 		  	//������� ���� ��������
		 		  	 mysql_query("update oldbk.bank set haos=0 where owner='{$targ[id]}' ; ");
		 		  	//
		  	     	 	//������ ������ 0 � �������� ����
					mysql_query("update users set align=0, expbonus=expbonus-3 where id='{$targ[id]}' ; ");

		 		  	//����
		 		  	if ($user['sex'] == 1) {$action="�����";}  else {$action="������";}

		 		  	//new_delo
	  		    		$rec['owner']=$targ[id];
					$rec['owner_login']=$targ[login];
					$rec['owner_balans_do']=$targ['money'];
					$rec['owner_balans_posle']=$targ['money'];
					$rec['target']=$user['id'];
					$rec['target_login']=$user['login'];
					$rec['type']=10003;
					$rec['sum_kr']=0;
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
					$rec['add_info']='���������� ����';
					add_to_new_delo($rec); //�����

		 		  	if (olddelo==1)
		 		  	{
		 		  	mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$targ['id']}','����� ���������� ���������� ���� ������� ".$user['login']." ',1,'".time()."');");
		 		  	}

					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$targ['id']."','����� &quot;".$user['login']."&quot; ".$action." &quot;".$targ['login']."&quot; ���������� ���������� ����','".time()."');");
					print "<b>������� ����� ���������� &quot���������� ����&quot  ��������� {$_POST['sklonkalog1']}!</b>";

		 		  	}
		 		  else
		 		  {
		 		   echo "����� �� ������! <br>";
		 		  }
		 	echo "</font>";
		 	}
		 	//����� ��� ��������
		 	echo "<br><form method=post action=\"?\"><b>���������/����� ���������� ���� </b>
		 	<table><tr><td>����� </td><td><input type='text' name='haosklonlog' value=''></td>
		 		   <td>���� </td><td><input type='text' name='haosklonbank' value=''></td>
		 	<td>����������
				<select name='haosklon'>
					<option value='1'>���������</option>
					<option value='2'>����� ����������</option>
				</select><td>
				<input type=submit name=haosgivesklon value='���������/�����'></td></tr></table>";
		 	}



		}


		if (ADMIN || $access['loginip'] )
		{
			echo "<form method=post><fieldset><legend>IP</legend>
					<table><tr><td>�����</td><td><input type='text' name='ip' value='",$_POST['ip'],"'></td><td><input type=submit value='���������� IP'></td></tr>
					<tr><td>IP</td><td><input type='text' name='ipfull' value='",$_POST['ipfull'],"'></td><td><input type=submit value='���������� ����'></td></tr></table>";
			if (strlen($_POST['ip'])) {
				$dd = mysql_fetch_array(mysql_query("SELECT `ip`, `login`, `id`, `align` FROM `users` WHERE `login` = '".$_POST['ip']."';"));
				if ($dd['id']==76009 || ($dd['align']>2 && $dd['align']<3)) {$dd['ip']='0.0.0.0'; }
				echo "<font color=red>",nick33($dd['id'])," - ",$dd['ip'],"</font><BR>";
			} elseif(strlen($_POST['ipfull'])) {
                                if (strpos($_POST['ipfull'],'X') !== false) {
					$data = mysql_query("SELECT * FROM `iplog` WHERE `ip` LIKE '".str_replace("X","%",$_POST['ipfull'])."';");
				} else {
					$data = mysql_query("SELECT * FROM `iplog` WHERE `ip` = '".$_POST['ipfull']."';");
				}
				$ulist = array();
				while($dd=mysql_fetch_array($data)) {
					$ulist[$dd['owner']] = $dd;
                                }

				if (count($ulist)) {
					$q = mysql_query('SELECT * FROM users WHERE id IN ('.implode(",",array_keys($ulist)).')');
					while($dd=mysql_fetch_array($q)) {
						if ($dd['id']==76009 || ($dd['align']>2 && $dd['align']<3)) {$ulist[$dd['id']]['ip'] = '0.0.0.0';}

						$nicklist .= nick_hist($dd)." - ".$ulist[$dd['id']]['ip']."<br>";
					}
				 	echo $nicklist;
				}

			}
			echo "</fieldset></form>";
		}


		if ($user['align'] == '1.99' || $user['klan'] == 'radminion') 
		{
				echo "<form method=post><fieldset><legend>������� � ����� / �������� �����</legend>
					<table><tr><td>�����</td><td>
					<input type='text' name='login' value='",$_POST['login'],"'></td></tr>
					<tr><td>�����</td><td>
					<select name='krest'>
					<option value='1.3'>������� ����������</option>
					<option value='1.2'>����������</option>
					<option value='1.4'>���������� �������</option>
					<option value='1.5'>������� ��������� ������</option>
					<option value='1.7'>������� �������� ����</option>
					<option value='1.75'>��������� ������</option>
					<option value='1.9'>������� ����</option>
					<option value='1.91'>������� ������� ����</option>
					<option value='1.92'>������� ������</option>";
				if ($user['align'] == '2.7') 
				{
					echo "<option value='1.99'>��������� �������</option>";
				}

				echo "</select></td></tr>
					<tr><td><input type=submit value='������� / ��������'></td></tr></table>";
				echo "</fieldset></form>";

				if ($_POST['login'] && $_POST['krest']) 
				{
					switch($_POST['krest'])
					{
						case 1.3:
							$rang = '������� ����������';
							$exp='0';
						break;
						case 1.2:
							$rang = '����������';
							$exp='0';
						break;
						case 1.4:
							$rang = '���������� �������';
							$exp='0';
						break;
						case 1.5:
							$rang = '������� ��������� ������';
							$exp='0.1';
						break;
						case 1.7:
							$rang = '������� �������� ����';
							$exp='0.2';
						break;
						case 1.75:
							$rang = '��������� ������';
							$exp='0';
						break;
						case 1.9:
							$rang = '������� ����';
							$exp='0.3';
						break;
						case 1.91:
							$rang = '������� �������� ����';
							$exp='0.4';
						break;
						case 1.92:
							$rang = '������� ������';
							$exp='0';
						break;
						case 1.99:
							$rang = '��������� �������';
							$exp='0.5';
						break;
					}
					$dd = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '".$_POST['login']."';"));
					$dd=check_users_city_data($dd[id]);
					Test_Arsenal_Items($dd);
					if ($user['sex'] == 1)
					{$action="��������";}
						else
					{$action="���������";}
						if ($user['align'] > '2' && $user['align'] < '3')  {
							$angel="�����";
						}
						elseif ($user['align'] > '1' && $user['align'] < '2') {
							$angel="�������";
						}

				if($dd) {
			                        $exp=($dd[align]==1.5?($exp-0.1):$exp);
			                        $exp=($dd[align]==1.7?($exp-0.2):$exp);
			                        $exp=($dd[align]==1.75?($exp-0.3):$exp);
			                        $exp=($dd[align]==1.9?($exp-0.3):$exp);
			                        $exp=($dd[align]==1.91?($exp-0.4):$exp);
			                        $exp=($dd[align]==1.99?($exp-0.5):$exp);

                        			$exp=str_replace(',','.',$exp);
                        			
                        			mysql_query("UPDATE oldbk.`users` SET `align` = '".$_POST['krest']."', `klan`='pal' ,`status` = '$rang',
						`expbonus`=`expbonus`+".$exp."
						 WHERE `login` = '".$_POST['login']."';");
						
						mysql_query("UPDATE avalon.`users` SET `align` = '".$_POST['krest']."', `klan`='pal' ,`status` = '$rang',
						`expbonus`=`expbonus`+".$exp."
						 WHERE `login` = '".$_POST['login']."';");

						$target=$_POST['login'];
						$mess="$angel &quot;{$user['login']}&quot; $action &quot;$target&quot; ������ $rang";
						mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$dd['id']."','$mess','".time()."');");
						mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."');");


					}
				}
		}




      /*
		if ($user['align'] == '1.99' || $user['align'] == '2.7' || $user['align'] == '2.4') {
		 	if($_POST['v'] || $_POST['s'])
		    {
				$sok1 = mysql_fetch_array(mysql_query('SELECT * FROM `users` WHERE  ((`align` > 1  AND `align` < 2)
								OR (`align` > 2  AND `align` < 3)) AND `login` = \''.$_POST['grn11'].'\' LIMIT 1;'));

				if($_POST['s']) {
				 mysql_query('INSERT `chanels` (`klan`,`name`,`user`)values(\'pal\',\''.$_POST['chan'].'\','.$sok1['id'].')
				 				ON DUPLICATE KEY UPDATE `name` =\''.$_POST['chan'].'\';');
                }
				$chan = mysql_fetch_array(mysql_query("SELECT * FROM `chanels` WHERE `klan`='pal' AND `user` = '".$sok1['id']."';"));
			}
			echo "<h4>������ ���-����</h4>";
		*/




	

	if (($user['klan'] == 'Adminion' && $user['id'] != '19573') || $user['klan'] == 'radminion'){
		echo "<form method=post action=\"?\">��������� ������ �����: <br>
		<table><tr><td>������� ����� </td><td><input type='text' name='obrnick' value=''></td>
		<td> �������� ����� <b>(��� .GIF) �� ������ trinity</b></td><td><input type='text' name='obrgif' value=''></td>
		<td><input type=submit value='���������'></td></tr>";
		echo "</table></form>";

		if ($_POST['obrnick'] && $_POST['obrgif']) {
			$tar = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['obrnick']}' LIMIT 1;"));
			if ($tar['id']) { 				mysql_query("INSERT INTO oldbk.users_shadows SET `name` = '{$_POST['obrgif']}', sex=".$tar[sex].", owner=".$tar[id].", type=2;");

				print "<font color=red> ����� ��������!</font>";
			}
			else
			{
				print "<font color=red> �������� � ����� ����� �� ����������!</font>";
			}
		}
		echo "<form method=post action=\"?\">��������� �������� �����: <br>
		<table><tr><td>������� ���� </td><td><input type='text' name='obrklan' value=''></td>
		<td> �������� ����� <b>(��� ������� �������������� � .GIF) �� ������ pal </b> � <br>�������� ������� ��� ����� =>
		���������� ��� mpal ��� gpal</td>
		<td><input type='text' name='obrgif' value=''></td> <td>
		<input type='checkbox' name='m' value='1' > �������</td>
		<td><input type='checkbox' name='g' value='1'> �������</td><td><input type=submit value='���������'></td></tr>";
		echo "</table></form>";

		if ($_POST['obrklan'] && $_POST['obrgif']) {
			$tar = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$_POST['obrklan']}' LIMIT 1;"));
			if ($tar['id']) {
				$sex=($_POST['sex']==1?'1':'0');
				if($_POST[m])
				{
					mysql_query("INSERT INTO oldbk.users_shadows SET `name` = '".$_POST['obrgif']."', sex=1, klan=".$tar[id].", type=1;");
				}
				if($_POST[g])
				{
					mysql_query("INSERT INTO oldbk.users_shadows SET `name` = '".$_POST['obrgif']."', sex=0, klan=".$tar[id].", type=1;");
				}
				print "<font color=red> ����� ����������!</font>";
			}
			else
			{
				print_r($_POST);
				print "<font color=red> ���� � ����� ��������� �� ����������!</font>";
			}
		}

	}
       echo '<br>';
	

	$out_array_links=array();
	
	if ((ADMIN) || $user['id'] == 8325) 
	{
	$out_array_links[1][1]=array('link'=>'pers_move_item.php','name' =>'������� ���� �� ���� � ��������� �� ���������� �����' );
	}
	if (ADMIN)
	{
		$out_array_links[1][2]=array('link'=>'pers_null_stats_new.php','name' => '�������� � ��������� ������ � ������');
		$out_array_links[1][3]=array('link'=>'retitems.php', 'name'=>'������� ��������� ����');		
	}
	if ($user['id'] == "7937" || (ADMIN) )
	{
		$out_array_links[1][4]=array('link'=>'rental_check.php','name' => '�������� �������� �����');		
	}
if (ADMIN)
	{
		$out_array_links[1][5]=array('link'=>'zavoz_div.php', 'name'=>'�����');		
		$out_array_links[1][6]=array('link'=>'obmen_run.php', 'name'=>'����� ���');		
		$out_array_links[1][7]=array('link'=>'admin_level.php', 'name'=>'������� ����� ��� Radminion');				
		$out_array_links[1][8]=array('link'=>'admin_proto.php', 'name'=>'����� �� �������� ��� ���������');				

		$out_array_links[1][9]=array('link'=>'admin_medal.php', 'name'=>'�������� �������');	
		
	        if ($access[klans_ars_put]) { $out_array_links[1][10]=array('link'=>'admin_arsenal.php', 'name'=>'�����������/������/��������/��������/��������� �� ���� ��������'); }
	        
		$out_array_links[1][11]=array('link'=>'vozvrat.php', 'name'=>'�������������� �����');	

		$out_array_links[2][1]=array('link'=>'/tools/reset2pwd.php', 'name'=>'����� 2�� ������');			
		$out_array_links[2][2]=array('link'=>'timeout.php', 'name'=>'��������� ��������');			
		$out_array_links[2][3]=array('link'=>'admin_finbattle.php', 'name'=>'�������� ���');		
		$out_array_links[2][4]=array('link'=>'admin.php', 'name'=>'����� ��������');				
		$out_array_links[2][5]=array('link'=>'adminch.php', 'name'=>'���');						
		$out_array_links[2][6]=array('link'=>'admin_sysmessage.php', 'name'=>'��������� ��������� Radminion');							
		$out_array_links[2][7]=array('link'=>'presents_creator.php', 'name'=>'��������, �������');							
		$out_array_links[2][8]=array('link'=>'pers_klan_weap_img.php', 'name'=>'�������� ������');							
		$out_array_links[2][9]=array('link'=>'ptest.php', 'name'=>'�������� ���� ����� �� ����� �����');							
		$out_array_links[2][10]=array('link'=>'fshop.php?present=1', 'name'=>'������� ������� �����');							
		$out_array_links[2][11]=array('link'=>'getitem.php', 'name'=>'������� � ����� ���');
		$out_array_links[2][12]=array('link'=>'getitem2.php', 'name'=>'������� � ����� ����');
		$out_array_links[2][13]=array('link'=>'admin_shop.php', 'name'=>'��������� �������');
		$out_array_links[2][14]=array('link'=>'klan_admin.php', 'name'=>'������ � �������');
		$out_array_links[2][15]=array('link'=>'/cloud/cloud.php', 'name'=>'�����');
		$out_array_links[2][16]=array('link'=>'/action/tools/index', 'name'=>'������� (CF)');

		$out_array_links[3][1]=array('link'=>'pers_null.php', 'name'=>'��������� ����� (�� �������)');			
//		$out_array_links[3][2]=array('link'=>'loto_adm.php', 'name'=>'������� ������� ');					

	}

	if (ADMIN) {
		$out_array_links[4][1]=array('link'=>'shopstats.php', 'name'=>'���������� �� ���������');
	}


if (count($out_array_links)>0)
{
	echo "<hr>
	<table  border=0>
	<tr>
		<td><h4>������� �����������</h4></td>
		<td><h4>�����������������</h4></td>
		<td><h4>����������</h4></td>
		<td><h4>����������</h4></td>
	</tr>";

	echo "<tr valign=top>";	
	for ($i=1;$i<=4;$i++)
	{
	$nu=0;
		echo "<td>";
		foreach($out_array_links[$i] as $k=>$data) 
			{
			$nu++;
			echo $nu.". <a href='{$data['link']}' target=_blank>{$data['name']}</a><br>";
			}
		echo "</td>";
	}
	echo "</tr>";
	echo "</table>";
}
	








	


	
	
	
 }
 else
 {
            if ($_POST['filter']) {
       //     perevodi($user['align'], $user['id'], '', $_POST['resoff'],$_POST['flowersoff'],$_POST['dropoff']);
            }
 }
?>
</body>
</html>
<?
/////////////////////////////////////////////////////
/*
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
*/
?>