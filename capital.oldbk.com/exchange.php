<?php

// ������ ������� ��� ������� ���:
$lvllim[0]=0;
$lvllim[1]=0;
$lvllim[2]=0;
$lvllim[3]=0;
$lvllim[4]=80;
$lvllim[5]=75;
$lvllim[6]=70;
$lvllim[7]=65;
$lvllim[8]=60;
$lvllim[9]=55;
$lvllim[10]=50;
$lvllim[11]=45;
$lvllim[12]=40;
$lvllim[13]=35;
$lvllim[14]=35;


$dprem[0]=7;//����
$dprem[1]=7;//����
$dprem[2]=14;//����
$dprem[3]=21;//����
/*
���� "�������" ���� - 1 ������, 
��� ���� �������� - 2 ������, 
��� ������� - 3 ������ 
(��� �������� ���� ������ ��� (����� ������� ���) ����������� �� ����� ��������) - 
��� �������� ���� �� ����� �������� ���������, ��� ��� ��� ���� � ���� ���������� �� ���� � (���������� � �������� �������)
*/

$head = <<<HEADHEAD
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<HTML><HEAD>
	<link rel=stylesheet type="text/css" href="i/main3.css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<script type="text/javascript" src="/i/globaljs.js"></script>
	<script type="text/javascript" src="/i/bank9.js"></script>	
	<!-- Asynchronous Tracking GA top piece counter -->
<script type="text/javascript">

var _gaq = _gaq || [];

var rsrc = /mgd_src=(\d+)/ig.exec(document.URL);
    if(rsrc != null) {
        _gaq.push(['_setCustomVar', 1, 'mgd_src', rsrc[1], 2]);
    }

_gaq.push(['_setAccount', 'UA-17715832-1']);
_gaq.push(['_addOrganic', 'm.yandex.ru', 'text', true]);
_gaq.push(['_addOrganic', 'images.yandex.ru', 'text', true]);
_gaq.push(['_addOrganic', 'blogs.yandex.ru', 'text', true]);
_gaq.push(['_addOrganic', 'video.yandex.ru', 'text', true]);
_gaq.push(['_addOrganic', 'go.mail.ru', 'q']);
_gaq.push(['_addOrganic', 'm.go.mail.ru', 'q', true]);
_gaq.push(['_addOrganic', 'mail.ru', 'q']);
_gaq.push(['_addOrganic', 'google.com.ua', 'q']);
_gaq.push(['_addOrganic', 'images.google.ru', 'q', true]);
_gaq.push(['_addOrganic', 'maps.google.ru', 'q', true]);
_gaq.push(['_addOrganic', 'nova.rambler.ru', 'query']);
_gaq.push(['_addOrganic', 'm.rambler.ru', 'query', true]);
_gaq.push(['_addOrganic', 'gogo.ru', 'q']);
_gaq.push(['_addOrganic', 'nigma.ru', 's']);
_gaq.push(['_addOrganic', 'search.qip.ru', 'query']);
_gaq.push(['_addOrganic', 'webalta.ru', 'q']);
_gaq.push(['_addOrganic', 'sm.aport.ru', 'r']);
_gaq.push(['_addOrganic', 'akavita.by', 'z']);
_gaq.push(['_addOrganic', 'meta.ua', 'q']);
_gaq.push(['_addOrganic', 'search.bigmir.net', 'z']);
_gaq.push(['_addOrganic', 'search.tut.by', 'query']);
_gaq.push(['_addOrganic', 'all.by', 'query']);
_gaq.push(['_addOrganic', 'search.i.ua', 'q']);
_gaq.push(['_addOrganic', 'index.online.ua', 'q']);
_gaq.push(['_addOrganic', 'web20.a.ua', 'query']);
_gaq.push(['_addOrganic', 'search.ukr.net', 'search_query']);
_gaq.push(['_addOrganic', 'search.com.ua', 'q']);
_gaq.push(['_addOrganic', 'search.ua', 'q']);
_gaq.push(['_addOrganic', 'poisk.ru', 'text']);
_gaq.push(['_addOrganic', 'go.km.ru', 'sq']);
_gaq.push(['_addOrganic', 'liveinternet.ru', 'ask']);
_gaq.push(['_addOrganic', 'gde.ru', 'keywords']);
_gaq.push(['_addOrganic', 'affiliates.quintura.com', 'request']);
_gaq.push(['_trackPageview']);
_gaq.push(['_trackPageLoadTime']);
</script>
<!-- Asynchronous Tracking GA top piece end -->
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/steel/steel.css" />
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/jscal2.js"></script>
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/lang/ru2.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
<script src="i/jquery.drag.js" type="text/javascript"></script>	 
<script>	

			function getformdata(id,param,event)
			{

				if (window.event) 
				{
					event = window.event;
				}
				if (event ) 
				{

				       $.get('payform.php?id='+id+'&param='+param+'', function(data) {
					  $('#pl').html(data);
					  $('#pl').show(200, function() {
						});
					});
				
				 $('#pl').css({ position:'absolute',left: (($(window).width()-$('#pl').outerWidth())/2)+200, top: '200px'  });	


				}
				
			}

			function getformdataold(id,param,event)
			{
				if (window.event) 
				{
					event = window.event;
				}
				if (event ) 
				{

				
				       $.get('exchange.php?view='+param+'&id='+id+'', function(data) {
					  $('#pl').html(data);
					  $('#pl').show(200, function() {
						});
					});
					
				 $('#pl').css({ position:'fixed',left: ($(window).width()-$('#pl').outerWidth())/2, top: '120px'  });	

				}
				
			}
			
			function closeinfo()
			{
			  	$('#pl').hide(200);
			}
			
$(window).resize(function() {
 $('#pl').css({ position:'fixed',left: ($(window).width()-$('#pl').outerWidth())/2, top: '120px'  });
});			
	
</script>	


	</HEAD>

	<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#e0e0e0>
	<h3 style="text-align:center;">����� ������������</h3>

	<div id="pl" style="z-index: 300; position: fixed; left: 730px; top: 200px;
				%WINSIZE% background-color: #eeeeee; 
				border: 1px solid black; display: none;">
	
			</div>
	<TABLE border=0 width=100% cellspacing="0" cellpadding="0"><tr><td> </td>
	<td align=right>
	<FORM action="exchange.php?exit=1" method=GET>
		
		<INPUT TYPE="submit" onclick="location.href='exchange.php?exit=1';" value="���������" name="exit">
	</table>
	</form>

	<table width="100%" CELLSPACING="0" CELLPADDING="0" BGCOLOR="#D5D5D5" border=0>
	<tr><td width=64% align=right>
		<table CELLSPACING="0" CELLPADDING="7" border=0><tr>
		<td %byekr%><a href="?view=byekr">������ �����������</a></td>
		<td width="30"></td>
		<td %sellekr%><a href="?view=sellekr">������� �����������</a></td>
		<td width="30"></td>
		<td nowrap %myekr%><a href="?view=myekr">��� �������</td></tr></table>
		
	</td><td width="36%" nowrap align="right"><table align=right><tr><td align=left>� ��� � ������� <font color=green>%MONEY% </font>��. %BANK% <br> %KOMIS%
	</td></tr></table></td></tr>
	</table><br>
HEADHEAD;

$mailrucounter = <<<MAILRUCOUNTER
	<div align=right>
	<script type="text/javascript">
		document.write("<a href='http://www.liveinternet.ru/click' "+
		"target=_blank><img src='http://counter.yadro.ru/hit?t54.2;r"+
		escape(document.referrer)+((typeof(screen)=="undefined")?"":
		";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
		screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
		";"+Math.random()+
		"' alt='' title='LiveInternet: �������� ����� ���������� �"+
		" ����������� �� 24 ����' "+
		"border='0' ><\/a>");
		</script>
	
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
	if(11<js)d.write('--'+'>');//--></script>
	<!--// Rating@Mail.ru counter-->
	</div>
MAILRUCOUNTER;

$foot = <<<FOOTFOOT
	<br><br>
	%MAILRU%
	<br>
	<!-- Asynchronous Tracking GA bottom piece counter-->
<script type="text/javascript">
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
})();
</script>

<!-- Asynchronous Tracking GA bottom piece end -->


	</BODY>
	</HTML>
FOOTFOOT;


	function Redirect($path) {
		header("Location: ".$path);
		die();
	}

	function RoundTime($time) {
		// �������� ����� �� ������
		$seconds = date("s",$time);
		return ($time - $seconds);
	}


	
	function ekr_tobayer_kr_toseller($bayer,$bayer_bankid,$summekr,$seller,$seller_bankid,$summkr,$komis,$kurs)
	{
			$BYtelo=check_users_city_data($bayer); //��� ��� �������� ���� ������ ��
			$SELtelo=check_users_city_data($seller); //��� ��� ������� ���� = �������� ��
	
			$Sbank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = '{$seller_bankid}'  and owner='{$SELtelo['id']}'  "));
			
			//������ ������ ����� ����� ��� ������
			$kr_komis=round($summkr*$komis,2);
			$total_kr_summ=$summkr-$kr_komis;
			
			mysql_query("UPDATE `oldbk`.`bank` SET `cr` = `cr` + '{$total_kr_summ}' WHERE `id`= '{$seller_bankid}' and owner='{$SELtelo['id']}'  ");
			if(mysql_affected_rows()>0)
				{	
				//  ����� � ������� �����
				mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�������� � ����� <b>{$total_kr_summ} ��.</b>, �������� <b>{$kr_komis} ��.</b> <i>(�����: ".($Sbank['cr']+$total_kr_summ)." ��., {$Sbank['ekr']} ���.)</i>','{$seller_bankid}');");					
						$rec = array();
			    			$rec['owner']=$SELtelo['id'];
						$rec['owner_login']=$SELtelo['login'];
						$rec['owner_balans_do']=$SELtelo['money'];
						$rec['owner_balans_posle']=$SELtelo['money'];
						$rec['target']=$BYtelo['id'];
						$rec['target_login']=$BYtelo['login'];
						$rec['type']=511; // ������� �� � ������� �� �����
						$rec['sum_kr']=$total_kr_summ;
						$rec['sum_rep']=0;								
						$rec['sum_ekr']=$summekr;
						$rec['sum_kom']=$kr_komis;
						$rec['bank_id'] = $seller_bankid;
						$rec['add_info']='�����. ������ �� '.$Sbank['cr']. '��. ����� ' .($Sbank['cr']+$total_kr_summ).'��. ';
						add_to_new_delo($rec); //�����
						
						//����� ��������  ���� ��� �������� ����� � �������
						$wlmess='<font color=red>��������!</font> �� ����� �������: <b>'.$summekr.' ���.</b>, �� ��� ���� �'.$seller_bankid.'  ���������� c ������� ��������� ��������: <b>'.$total_kr_summ.' ��. </b> ';
						telepost_new($SELtelo,$wlmess);	

						//����� � ��� ���� ��� �� ������ ��� ������
						mysql_query("INSERT INTO `oldbk`.`exchange_log_data` SET `owner`='{$SELtelo['id']}', `owner_bank`='{$seller_bankid}' ,`etype`=0,`summ`='{$summekr}',`kurs`='{$kurs}',`komis`='{$komis}', `to_owner`='{$BYtelo['id']}', `to_owner_bank`='{$bayer_bankid}' ;");
						
						
						$Bbank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id`= '{$bayer_bankid}' and owner='{$BYtelo['id']}'  "));
						//����� � ����
						mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '{$summekr}' , cr=cr-'{$summkr}'   WHERE `id`= '{$bayer_bankid}' and owner='{$BYtelo['id']}'  ");
						if(mysql_affected_rows()>0)
						{						
						//  ����� � ������� �����
						mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�������� �� ����� <b>{$summekr} ���.</b> �� <b>{$summkr}</b> �� , �������� <b>0 ��.</b> <i>(�����: ".($Bbank['cr']-$summkr)." ��., ".($Bbank['ekr']+$summekr)." ���.)</i>','{$bayer_bankid}');");					
						
						
						//����� � ��� ��������� ��� ����� ���� �� ����� �����
						mysql_query("INSERT INTO `oldbk`.`exchange_log` SET `owner`='{$BYtelo['id']}' , `byekr`='{$summekr}'  ON DUPLICATE KEY UPDATE byekr=byekr+'{$summekr}' ");
						//����� � ��� �������
						mysql_query("INSERT INTO `oldbk`.`exchange_byekrs` SET `owner`='{$BYtelo['id']}'  ,`sdate`=NOW(),`ekr`='{$summekr}'  on duplicate key UPDATE `ekr`=ekr+'{$summekr}' ");
						
						$rec = array();
			    			$rec['owner']=$BYtelo['id'];
						$rec['owner_login']=$BYtelo['login'];
						$rec['owner_balans_do']=$BYtelo['money'];
						$rec['owner_balans_posle']=$BYtelo['money'];
						$rec['target']=$SELtelo['id'];
						$rec['target_login']=$SELtelo['login'];
						$rec['type']=510; // �������� �� ������� ����
						$rec['sum_kr']=$summkr;
						$rec['sum_rep']=0;								
						$rec['sum_ekr']=$summekr;
						$rec['sum_kom']=0;
						$rec['bank_id'] = $bayer_bankid;
						$rec['add_info']='�����. ������ �� '.$Sbank['cr']. '��. ����� ' .($Sbank['cr']-$summkr).'��., ������ �� '.$Bbank['ekr'].'���. ����� '.($Bbank['ekr']+$summekr).' ���. ';
						add_to_new_delo($rec); //�����	
					
						//����� ��������  ���� ��� �������� ����� � �������
						$wlmess='<font color=red>��������!</font> �� ����� ������� <b>'.$summekr.' ���.</b>, �� ��� ���� �'.$bayer_bankid.'  ��������: <b>'.$summkr.' ��. </b> ';
						telepost_new($BYtelo,$wlmess);	
						}
						
						return true;
					}

	return false;		
	}	


	function by_from_exchange($kur,$summ,$usrid,$usrbankid)
	{
	mysql_query('START TRANSACTION') or die();
	
		$q = mysql_query('SELECT * FROM oldbk.`exchange` WHERE kurs = '.$kur.' order by kurs , mkdate  FOR UPDATE') or die();
		if (mysql_num_rows($q) > 0) 
		{
			while($row = mysql_fetch_assoc($q)  )
			{ 
				
					if (($row['summ']>$summ) and ($summ>0))
					{
					//���� ������ ��� ���� ������ ������
					mysql_query("UPDATE oldbk.`exchange` set  summ=summ-{$summ} WHERE id={$row['id']} ") or die();

					ekr_tobayer_kr_toseller($usrid,$usrbankid,$summ,$row['owner'],$row['bankid'],($summ*$row['kurs']),$row['komis'],$row['kurs'] ); // ���������� ���� ����������  - ���������� ����� �������� - ������ ����� �.�. ��������� �� ���
					$summ-=$row['summ']; // ����������  ��� ��������� ��������					
					}
					elseif ($summ>0)
					{
					//���� ������ ��� ����� ������� ���� ������ �����
//echo $summ;
//echo "D DEL<br>";										
					mysql_query("DELETE FROM oldbk.`exchange` WHERE id={$row['id']}") or die();
					ekr_tobayer_kr_toseller($usrid,$usrbankid,$row['summ'],$row['owner'],$row['bankid'],($row['summ']*$row['kurs']),$row['komis'],$row['kurs']); // ���������� ���� ���������� c ������� ����  - ���������� ����� ��������  � ������ ������� � ����
					$summ-=$row['summ']; 
					}
			}
			mysql_query('COMMIT') or die();		
			return true;			
			
		}
		
	mysql_query('COMMIT') or die();		
	return false;
	}


	session_start();

	if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) Redirect("index.php");
	if ($_SESSION['boxisopen']!='open') Redirect("index.php");

	include('connect.php');
	include('functions.php');

	if (isset($_GET['exit'])) 
	{
	Redirect('main.php');
	}

	if ($user['align'] == 4) 
	{
	$ekr_chaos=false;
		$effects=mysql_fetch_assoc(mysql_query("SELECT * FROM effects WHERE owner='".$user[id]."' AND type=4 and lastup > 0"));
		$vikup=unserialize($effects['add_info']);
		if ($vikup['ekr']>0) { $ekr_chaos=true; echo "EKR"; }
	}

	$my_cur_byekr=mysql_fetch_assoc(mysql_query("select owner, sum(ekr) as byekrs from oldbk.exchange_byekrs where owner='{$user['id']}' and sdate>='".date("Y-m-01")."' and sdate<='".date("Y-m-d")."' "));

	$my_max_lim_byekr=$lvllim[$user['level']];
	if  ($my_cur_byekr['byekrs']>0) { $my_cur_limit=$my_max_lim_byekr-$my_cur_byekr['byekrs'];  } else { $my_cur_limit=$my_max_lim_byekr ; }


$userborntime=date_create_from_format('Y-m-d H:i:s', $user['borntime']); //������ � ���� ���� ���� �����
$userborntimet=mktime(date_format($userborntime, 'H'),date_format($userborntime, 'i'),date_format($userborntime, 's'),date_format($userborntime, 'm'),date_format($userborntime, 'd'),date_format($userborntime, 'Y')  );
//echo $userborntimet ;

	if ($userborntimet>mktime(14, 0, 0, 3, 24, 2015)) // ���� ����� �����
		{
		$def_start=0; // ��� ��� ����� ����� ����� 0
//echo "NO";		
		}
		else
		{
		$def_start=100; // ���. �������� ������� �� ������ ����
//echo "YEs";				
		}


	if ($_SESSION['bankid']>0)
		{
		$bank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = ".$_SESSION['bankid']."  and owner='".$user['id']."' "));
		}
		else
		{
			if ($_POST['byekryes']) { unset($_POST['byekryes']); }
		}

	$view = isset($_GET['view']) ? $_GET['view'] : "byekr";


	// �������� �� �������
	if ( ($user['level'] < 4) || ( ($user['align'] == 4) AND ($ekr_chaos==false) ) ) $view = "sellekr";

	
	//
	$komiss=0.02; //��������� 2% 
	
	if ($user['prem']==1)
		{
		$komiss-=0.001;
		}
	elseif ($user['prem']==2)
		{
		$komiss-=0.003;
		}		
	elseif ($user['prem']==3)
		{
		$komiss-=0.008;
		}	
	
	$torg_lic=mysql_fetch_array(mysql_query("select * from effects where type=30000 and owner='{$user['id']}'"));
	if ($torg_lic['id']>0)
		{
		$komiss-=0.003;//������������� �������� �������� 0.3%
		}	
	


	$center = "";
	switch($view) {
		default:
		$view = "sellekr";
		case "sellekr":
		
			$center = '<center><table border=0 width="100%"><tr valign=top><td align=center width="33%">&nbsp;</td><td align=center width="33%">';
			if ($user['level'] < 4) {
				$center .= '<center><font color=red>���� �� ����� ������ � 4�� ������.</font></center>';
				break;
			}
			if ( ($user['align'] == 4) AND ($ekr_chaos==false) ) {
				$center .= '<center><font color=red>���� �� ����� �� ����������� ����� ��������.</font></center>';
				break;
			}

			if (((time()>mktime(17,0,0,4,3,2017)) and (time()<mktime(23,59,59,4,10,2017)))  )
			{
				$center .= '<center><font color=red>����� ������� �� ������������� �� 10/04/2017 23:59:59</font></center>';
				break;
			}

			if(!($_SESSION['bankid']>0) )
				{
				Redirect("exchange.php?view=bankenter");				
				}
			else
			{
			
			if (($user['klan']=='radminion')	or ($user['klan']=='Adminion') )
				{
				$total_can=9999999;
				}
				else
				{
				$get_can_sell=mysql_fetch_array(mysql_query("select * from oldbk.exchange_log where owner='{$user['id']}' "));
				$total_can=$get_can_sell['dilekr']+$def_start-$get_can_sell['sellekr'];  
				}
			
			if ($total_can<0)	{$total_can=0;}
				
			$kurs=(int)$_POST['ekrkurs'];
			$ekrsumm=(int)$_POST['ekrsum'];
			
			$center .='<div style="text-align:center;"> <font color=green><b>������������� ���� ������� 1 ��� = 200 ��.</b></font> <h3>������� �����������:</h3>';
			$center .='<table align=center><tr><td align=left>';
			$center .='%BANK%<br>';
			$center .='��� ����� ��� ������ ���.: <font color=green>'.$total_can.'</font> ���. <br><br>';			
			$center .='<form method=POST>';
			$center .='����� ���. �� ������� : <input type=text name=ekrsum value="'.$ekrsumm.'" onkeyup="this.value=this.value.replace(/[^\d]/,\'\');"><br>';
			$center .='���� �������� �� 1 ���.: &nbsp;&nbsp;&nbsp;&nbsp;<input type=text name=ekrkurs value="'.$kurs.'" onkeyup="this.value=this.value.replace(/[^\d]/,\'\');"><br><br>';
			$center .='<div style="text-align:center;"><input type=submit name=mkekr value="��������� �� �������" ></div></td></tr></table>';
			
			
			$MAX_LIMIT=205; //  ��� ���� ���������� ���������� ������� ������ ����� ��� �� ����� = 200��.
			if ($user['prem']==2)
				{
				$MAX_LIMIT=round($MAX_LIMIT*1.1,2);//��� ���������� � ���� ��������� ������� ������ ����� 200��+10%=220��
				}
			else
			if ($user['prem']==3)
				{
				$MAX_LIMIT=round($MAX_LIMIT*1.25,2);// ��� ���������� � �������� ������� ������ ����� 200��+25%=250��
				}
			
			if (($kurs<=EKR_TO_KR) and ($_POST['ekrkurs']))
			{
			$center .='<hr> � ���������, �� �� ������ ���������� ���� ������ <b>'.EKR_TO_KR.' ��. �� 1 ���. </b>' ;
			}
			elseif (($kurs>$MAX_LIMIT) and ($_POST['ekrkurs']))
			{
			$center .='<hr> ������� ������� ����. ���������� ������� ��������� ����.' ;
			}			
			elseif ($total_can==0) 
				{
				$center .='<hr> � ���������, �� �� ������ ������� ������ ������������, ���� �� ��������� ���� ������ ����� ������!' ;
				}
			else
			if ($ekrsumm>$total_can) 
				{
				$center .='<hr> � ���������, �� �� ������ ������� ������ ��� <b>'.$total_can.' ���. </b>' ;
				}
			elseif ($ekrsumm>$bank['ekr']) 
				{
				$center .='<hr> � ���������, � ��� ��� � ������� <b>'.$ekrsumm.' ���. </b>' ;
				}
			else if (($_POST['mkekr']) AND ($ekrsumm>0) and ($kurs>0) )
				{
				$total_summ=($kurs*$ekrsumm);
				$total_kom=round($total_summ*$komiss,2);
				$total_summ_my=$total_summ-$total_kom;
				
				$center .='<hr> �� ����������� �� �������:  <b>'.$ekrsumm.' ���.</b> �� �����  <b>'.$kurs.' ��. </b>  �� 1 ���. <br>%KOMIS% = <b>'.$total_kom.' ��.</b> <br> 
				<br>����� �����: <b>'.$total_summ.' ��. </b> <br>
				�� ��������: <b>'.$total_summ_my.' ��. </b> <br><br>				
				' ;
				$center .='<input type=submit name=mkekryes value="����������� �������" > ';
				$center .=' &nbsp;<input type=submit name=mkekrno value="��������" >';							
				}
			else if (($_POST['mkekryes']) AND ($ekrsumm>0) and ($kurs>0) and ($ekrsumm<=$total_can) and ($ekrsumm<=$bank['ekr'])   )
				{
				//���������� �� �������
				//������ ������ ����� ����� ��� ������
				mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` - '{$ekrsumm}' WHERE `id`= '{$bank['id']}' and owner='{$user['id']}' and  ekr>='{$ekrsumm}' ");
				if(mysql_affected_rows()>0)
					{	
					//  ����� � ������� ����� -- ��� �������� ������� ����
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','���������� �� ����� <b>{$ekrsumm} ���.</b>, �������� <b>0 ��.</b> <i>(�����: ".($bank['cr'])." ��., ".($bank['ekr']-$ekrsumm)." ���.)</i>','{$bank['id']}');");						
					
					$bank['ekr_do']=$bank['ekr'];
					$bank['ekr']-=$ekrsumm;

						$rec = array();
			    			$rec['owner']=$user['id'];
						$rec['owner_login']=$user['login'];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money'];
						$rec['target']=0;
						$rec['target_login']='�����';
						$rec['type']=513;
						$rec['sum_kr']=0;
						$rec['sum_ekr']=$ekrsumm;
						$rec['sum_kom']=0;
						$rec['bank_id'] = $bank['id'];
						$rec['add_info']='�����. ������ �� '.$bank['cr']. '��. ����� ' .$bank['cr'].'��., ������ �� '.$bank['ekr_do'].'���. ����� '.$bank['ekr'].' ���. ';
						add_to_new_delo($rec); //�����	
					
				
					//������ ������ � �������
					$koldays=$dprem[$user['prem']];
					mysql_query("INSERT INTO `oldbk`.`exchange` SET `owner`='{$user['id']}',`etype`=0,`summ`='{$ekrsumm}',`kurs`='{$kurs}' ,`bankid`='{$bank['id']}', `komis`='{$komiss}' , `fintime`=NOW()+INTERVAL {$koldays} DAY   ");
					
					//����� � ��� ���������
					mysql_query("INSERT INTO `oldbk`.`exchange_log` SET `owner`='{$user['id']}' , `sellekr`='{$ekrsumm}'  ON DUPLICATE KEY UPDATE sellekr=sellekr+'{$ekrsumm}' ");
					
					//����� � ���� 
					$center .='<hr><br>������� ���������� �� ������� <b>'.$ekrsumm.'</b> ���. ';							
					}
				
				}

			
			
			}
			
			$center .= '</form></div></td><td align=center width="33%">&nbsp;</td></tr></table></center>';
			

			

			
			
			
		break;
		case "byekr":
		
			$center = '<center><table border=0 width="100%"><tr valign=top><td align=center width="10%">&nbsp;</td><td align=center width="60%">';
			if ($user['level'] < 4) {
				$center .= '<center><font color=red>���� �� ����� ������ � 4�� ������.</font></center>';
				break;
			}
			if ( ($user['align'] == 4) AND ($ekr_chaos==false) ) {
				$center .= '<center><font color=red>���� �� ����� �� ����������� ����� ��������.</font></center>';
				break;
			}

			$center .='<div style="text-align:center;"><h3>������ �����������:</h3>';
			//$center .='<br>';
			$center .='<table border=0 width="100%"> <tr valign=top><td align=center> ';
			$center .='<h4>������� ������:</h4>';
			$get_all_zay=mysql_query("select sum(summ) as total_summ , kurs  from oldbk.exchange where etype=0  group by kurs order by kurs , mkdate ; "); // ��� ������ �� ������� ���
			if (mysql_num_rows($get_all_zay)> 0)
				{
				$dataarry=array();
						$center .='<table>';
						$center .='<tr bgcolor=#D5D5D5>';
						$center .='<td height=30 align=center> &nbsp;&nbsp;<b>����� ���.</b>&nbsp;&nbsp; </td><td align=center> &nbsp;&nbsp;<b>����</b>&nbsp;&nbsp; </td><td align=center> &nbsp;&nbsp;<b>����� ��.</b>&nbsp;&nbsp; </td> ';
						$center .='</tr>';										
						while($row = mysql_fetch_assoc($get_all_zay)) 
						{
						$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
						$center .='<tr bgcolor='.$color.'>';
						$center .='<td height=30 valign=center> &nbsp;&nbsp;'.$row['total_summ'].' ���. &nbsp;&nbsp;</td><td>&nbsp;&nbsp; 1 ���.='.$row['kurs'].' ��. &nbsp;&nbsp;</td><td> &nbsp;&nbsp;'. ($row['total_summ']*$row['kurs']) .' ��. &nbsp;&nbsp;</td> ';
						$dataarry[$row['kurs']]=$row['total_summ'];
						$center .='</tr>';						
						$i++;
						}
				$center .='</table>';						
				}
				else
				{
				$center .=' � ���������, � ������ ������ �� ����� ��� ������ �� ������� ������������! ';	
				$br=true;			
				}
			
			if ($br!=true)
				{
				$center .='</td><td align=left>';			
				$center .='<center><h4>������ ������� ������������:</h4></center>';
				
				$center .='�� ������ ������ ��� <b>%MY_LIM% ���</b> <img src="http://i.oldbk.com/i/bank/spravka.gif" alt="�� ������ ������ �� ����� N ��� � �����, ����� ���������� 1 ����� ������� ������." title="�� ������ ������ �� ����� '.$my_max_lim_byekr.' ��� � �����, ����� ���������� 1 ����� ������� ������.">';
				$center .='%BANK%';
				
				/*
				if ($_SESSION['bankid']>0)
				{
				$center .='�<b>'.$_SESSION['bankid'].'</b><br>';				
				$center .='��������:<b>'.$bank['cr'].'</b> ��.<br>';								
				}
				else
				{
				$center .='<a href="?view=bankenter">�����</a>';
				}
				*/
				
				$sumbyekr=(int)($_POST['sumbyekr']);
				$center .='<form method=POST>';
				$center .='<br>����� ��� ��� �������: <input type=text size=10 name=sumbyekr value="'.$sumbyekr.'" onkeyup="this.value=this.value.replace(/[^\d]/,\'\');">';
				$center .=' <input type=submit name=byekr value="����������" ><br>';
				
				if (($_POST['byekr'] || $_POST['byekryes'])  and ($sumbyekr>0) )
					{
					
					$center .='<br>������ ������� �� ����� <b>'.$sumbyekr.'</b> ���. :<br>';
					
						$total_summ_ekr=0;
						$total_summ_kr=0;
						$need_ekr=$sumbyekr;
						
						$need=array();


						
						foreach($dataarry as $kur => $summ )
							{

							$total_summ_ekr+=$summ;

								if ($need_ekr >= $summ )
									{
									$need[$kur]=$summ;
									$total_summ_kr+=$kur*$summ;							
									$need_ekr-=$summ;
									}
									else if ($need_ekr>0)
									{
									$need[$kur]=$need_ekr;
									$total_summ_kr+=$kur*$need_ekr;							
									$need_ekr-=$need_ekr;
									}
							}
							
								if (((time()>mktime(17,0,0,4,3,2017)) and (time()<mktime(23,59,59,4,10,2017)))  )
								{
									$center .= '<center><font color=red>����� ������� �� ������������� �� 10/04/2017 23:59:59</font></center>';
								
								}							
								elseif  ($sumbyekr>$my_cur_limit)	
								{
								$center .='<br><font color=red>� ���������, �������� ����� ��� ��� �������!</font>';								
								}
								elseif  ($sumbyekr>$total_summ_ekr)
								{
								//���������� ������� ������ , ������� ��� �� �����
								$center .='<br><font color=red>� ���������, ����� ����� � ������ ������ ��� �� �����! <br> ������������ ����� <b>'.$total_summ_ekr.'</b> ���.</font>';
								}
								else
								{
								$k=0;
									$get_all_zay=mysql_query("select * from oldbk.exchange where owner='{$user['id']}' and etype=0 "); // ��� ������ �� ������� ��� �� ������� ������
									if (mysql_num_rows($get_all_zay)> 0)
										{
										$user_cant_bay=true;
										}
								
								if ($_POST['byekr'])
									{
									$_SESSION['arr_need']=$need; // ���������� ����� ����������� �������
									unset($_POST['byekryes']);
									unset($_POST['byekrno']);									
																
									foreach($need as $kur => $summ )
									{
									$k++;
									$center .='  '.$summ.' ���. �� '.$kur.' ��. = '.($kur*$summ).' ��. <br>';
									}
									
									$center .='<hr> ����� ����������: <b>'.$total_summ_kr.'</b>  ��.  ';
									
									
									
									
									if (($_SESSION['bankid']>0) and ($user_cant_bay!=true))
										{
										unset($_SESSION['EsecurityCode']);
										$center .='<br><br><img src="exsec.php?tm='.mt_rand(1111,9999).'" border="1">';
										$center .='<br>������� ���:<input type=text size=8 name=EsecurityCode> ';
										$center .='<br><br><input type=submit name=byekryes value="����������� �������" >';
										$center .=' &nbsp;&nbsp;<input type=submit name=byekrno value="��������" >';
										}
										elseif ($user_cant_bay==true)
										{
										$center .='<br><font color=red>�� �� ������ ������ ����������� ��������� ���� �� ��������!</font>';
										}
									
									}
									else 
									 if (($_POST['byekryes']) and ($user_cant_bay!=true) and ($_SESSION['bankid']>0) )
									 {
									 //������� ������
									 	if (!isset($_POST['EsecurityCode']) || !isset($_SESSION['EsecurityCode'])) 
									 	{
										$center .='<font color=red>�� �� ����� �������� ��� ! <br>��������� ������!</font>';
										}
										else
									 	if (strtolower($_POST['EsecurityCode']) == strtolower($_SESSION['EsecurityCode'])) 
									 	{
										unset($_SESSION['EsecurityCode']);
												   if ($_SESSION['arr_need']==$need)
												   	{
												   	
												   	 if ($total_summ_kr>$bank['cr'])
												   	 	{
				   										$center .='<font color=red>� ���������, � ��� �� ���������� <br>�������� �� ������� ���������� �����!</font>';									   	 	
												   	 	}
												   	 	else
												   	 	{
													   	$center .='<hr>';
													   	foreach($need as $kur => $summ )
																{
																
																	if (by_from_exchange($kur,$summ,$user['id'],$bank['id']))
																	{
																   	$center .='������ ��������: <b>'.$summ.' ���.</b> <br> ';	
																   	$bank['cr']-=($summ*$kur);
																   	$bank['ekr']+=$summ;
																   	$my_cur_limit-=$summ; //��������
																   	//����� � ������� ����� ����������
																   	// ���������� ��������  � ������� ������ ����� ����������
															   	
																	}
																	else
																	{
																   	$center .='������ �������!';																												
																	}
														
																}
													   	}
													   	
												   	}
												   	else
												   	{
			   										$center .='<font color=red>� ���������, ������� ������ <br>�� ������� ������������ ����������. <br>��������� ������!</font>';
												   	}
										}
										else
											{
											$center .='<font color=red>�������� �������� ���! <br>��������� ������!</font>';
											}
									   	
									   	
									 }
									 else if ($_POST['byekrno']) 
									 {
									 	unset($_SESSION['arr_need']);
									 }
								
								}
					
					}

					
					$center .='</form>';
					
				}
				


			
			//$center .='</td><td  width="5%">&nbsp;';
			$center .='</td><td align=left>';			
			$center .='<center><h4>������� ������������ � �������</h4></center><center>';
			
			$nw=time()-61;
			$data=mysql_query(
			"SELECT u.*, b.blood, b.type as btype, (select `type` from `effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
							FROM `users` u
							left join `battle` b
							on u.battle= b.id
						WHERE u.deal>0 AND u.hidden=0 AND u.odate>".(int)$nw."  AND u.id_city={$user[id_city]} ORDER BY u.login asc ;");
				$to_print_online1='';
				$to_print_online2='';
				while ($row = mysql_fetch_array($data))
				{
					if (!(strpos($row['login'], 'auto') !== false) )
					{
						// �������� ����� ��� ��� 1
						if  ($row['deal']==1)
						{
							$to_print_online1.=render_item_row($row,1,true);
						}
						else
						{
							$to_print_online2.=render_item_row($row,1,true);
						}
					}
				}
			
			if (($to_print_online1!='') or ($to_print_online2!=''))
				{
				$center.="<table border=0>";				
				$center.=$to_print_online1;
				$center.=$to_print_online2;				
				$center.="</table>";								
				}

			$center .='<div align=center>';

			if ($_SESSION['bankid']>0)
				{
				$center .='<br><a onclick="getformdata(99,0,event);" href="#"><img src="http://i.oldbk.com/i/bank/knopka_ekr.gif"  alt="������ ����������� ����� ����" alt="������ ����������� ����� ����"></a>';
				}
				else
				{
				$center .='<br> <a href="?view=bankenter"><img src="http://i.oldbk.com/i/bank/knopka_ekr.gif"  alt="������ ����������� ����� ����" alt="������ ����������� ����� ����"></a>';
				}

			$center .='</div></td></tr></table>';
			$center .= '</div>';

			
			$center .='</center></td><td align=center width="10%">&nbsp;</td></tr></table></center>';
		break;	
		case "myekr":
		
			$center = '<center><table border=0 width="100%"><tr valign=top><td align=center width="25%">&nbsp;</td><td align=center width="50%">';
			if ($user['level'] < 4) {
				$center .= '<center><font color=red>���� �� ����� ������ � 4�� ������.</font></center>';
				break;
			}
			if ( ($user['align'] == 4) AND ($ekr_chaos==false) ) {
				$center .= '<center><font color=red>���� �� ����� �� ����������� ����� ��������.</font></center>';
				break;
			}

			$center .='<div style="text-align:center;"><h3>��� ������ �� ������� ������������:</h3>';
			$center .='<br>';

			if ($_GET['cancel'])
				{
				$cancel_id=(int)($_GET['cancel']);
				
					if ($cancel_id>0)
						{
						mysql_query('START TRANSACTION') or die();
						$q=mysql_query("SELECT * from  oldbk.exchange where id='{$cancel_id}' and owner='{$user['id']}' FOR UPDATE") or die();
						$lookid=mysql_fetch_assoc($q);
						if ($lookid['id']==$cancel_id)
							{
							//������� ����� � ���� 							
							mysql_query("DELETE from oldbk.exchange where id='{$cancel_id}' and owner='{$user['id']}' "); 
							mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '{$lookid['summ']}' WHERE `id`= '{$lookid['bankid']}' and owner='{$user['id']}' ");
							//  ����� � ������� ����� 
							mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','������ �������  �� ����� <b>{$lookid['summ']} ���.</b>, �������� <b>0 ��.</b> <i>(�����: ".($bank['cr'])." ��., ".($bank['ekr']+$lookid['summ'])." ���.)</i>','{$bank['id']}');");													

							$bank['ekr_do']=$bank['ekr'];
							$bank['ekr']+=$lookid['summ'];
							
							$rec = array();
				    			$rec['owner']=$user['id'];
							$rec['owner_login']=$user['login'];
							$rec['owner_balans_do']=$user['money'];
							$rec['owner_balans_posle']=$user['money'];
							$rec['target']=0;
							$rec['target_login']='�����';
							$rec['type']=514;
							$rec['sum_kr']=0;
							$rec['sum_ekr']=$lookid['summ'];
							$rec['sum_kom']=0;
							$rec['bank_id'] = $bank['id'];
							$rec['add_info']='�����. ������ �� '.$bank['cr']. '��. ����� ' .$bank['cr'].'��., ������ �� '.$bank['ekr_do'].'���. ����� '.$bank['ekr'].' ���. ';
							add_to_new_delo($rec); //�����	
							
							//����� � ��� ��������� �������
							mysql_query("UPDATE `oldbk`.`exchange_log` SET `sellekr`=`sellekr`-{$lookid['summ']}  WHERE `owner`={$user['id']} ");
							$center .='<font color=red>������ ������ ��������!</font><br>';
							}
							else
							{
							$center .='<font color=red>����� ������ �� �������!</font><br>';
							}
						mysql_query('COMMIT') or die();								
						}
				}
			

			$get_all_zay=mysql_query("select * from oldbk.exchange where owner='{$user['id']}' and etype=0 order by mkdate desc "); // ��� ������ �� ������� ��� �� ������� ������
			if (mysql_num_rows($get_all_zay)> 0)
				{
						$center .='<table width="100%">';
						$center .='<tr bgcolor=#C7C7C7>';
						$center .='<td height=20> <b>��.�.</b> </td><td><b>����� �����</b></td><td><b>����� ���</b></td><td><b>���� �� 1 ���.</b></td><td><b>��������</b></td><td><b>���� ������</b></td><td><b>��������</b></td><td> </td>';
						$center .='</tr>';
						$i=1;										
						while($row = mysql_fetch_assoc($get_all_zay)) 
						{
						$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
						$center .='<tr bgcolor='.$color.'>';
						$center .= '<td height=20>'.$i.'</td><td>�'.$row['bankid'].'</td><td>'.$row['summ'].' ���. </td><td>'.$row['kurs'].' ��.</td><td>'.($row['komis']*100).'%</td><td>'.$row['mkdate'].'</td><td>'.$row['fintime'].'</td>';
						$center .= '<td><a href="?view=myekr&cancel='.$row['id'].'"><i class="del" id="del" title="��������"></i></a></td>';
						$center .='</tr>';						
						$i++;
						}
				$center .='</table>';						
				}
				else
				{
				$center .=' � ��� ��� ������ �� ������� ������������! ';	
				}
			
			
			/////////////////////////
			$view = 20; // ���. �� ��������
			$limit = "";
			if (isset($_GET['page'])) 
			{
				$page = intval($_GET['page']);
				$limit .= ' LIMIT '.($page*$view).','.$view.' ';
			} else {
			$page = 0;
			$limit .= ' LIMIT '.$view.' ';
			}
			
			
			$get_all_log=mysql_query("SELECT SQL_CALC_FOUND_ROWS * from oldbk.exchange_log_data where owner='{$user['id']}' order by mkdate desc ".$limit); // ��� ������ �� ������� ��� �� ������� ������
			
			$qall = mysql_query('SELECT FOUND_ROWS() AS `allcount`');
			$allcount = mysql_fetch_assoc($qall);
			$allcount = $allcount['allcount'];			
			$pages="";
			if ($allcount>$view) {
				 $pages = " ��������:"; 
					for ($i = 0; $i < ceil($allcount/$view); $i++) {
						if ($page == $i) {
							$pages .= '<b> '.($i+1).'</b> ';
		                                } else {
							$pages .= ' <a href="?view=myekr&page='.$i.'">'.($i+1).'</a>';
						}
					}
				}
			
			
			
			if (mysql_num_rows($get_all_log)> 0)
				{
				$center .='<br>';
				$center .='<div style="text-align:left;"><h3>������� ������:</h3>';
				
				
						$center .='<table width="100%">';
						$center .='<tr bgcolor=#C7C7C7>';
						$center .='<td height=20> <b>��.�.</b> </td><td><b>����� �����</b></td><td><b>����� ���</b></td><td><b>���� �� 1 ���.</b></td><td><b>��������</b></td><td><b>���� ������</b></td><td><b>��������</b></td>';
						$center .='</tr>';
						$i=1;										
						while($row = mysql_fetch_assoc($get_all_log)) 
						{
						$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
						$center .='<tr bgcolor='.$color.'>';
						$center .= '<td height=20>'.$i.'</td><td>�'.$row['owner_bank'].'</td><td>'.$row['summ'].' ���. </td><td>'.$row['kurs'].' ��.</td><td>'.($row['komis']*100).'%</td><td>'.$row['mkdate'].'</td>';
						$total_kr=$row['summ']*$row['kurs'];
						$total_kr_komis=round($total_kr*$row['komis'],2);
						$total_me_kr=$total_kr-$total_kr_komis;
						$center .= '<td>'.$total_me_kr.'  ��.</td>';
						$center .='</tr>';						
						$i++;
						}
						$center .='</table>';	
						$center .="<br><center>".$pages."</center><br>";
				
				}
			
			
			
			
			$center .= '</div></td><td align=center width="25%">&nbsp;</td></tr></table></center>';
		break;		

		case "chbank":
			if($_SESSION['bankid']>0) 
				{
				unset($_SESSION['bankid']);
				}
			Redirect("exchange.php?view=bankenter");
		break;	
		
		case "bankenter":
		
			$center = '<center><table border=0 width="100%"><tr valign=top><td align=center>';
			if ($user['level'] < 4) {
				$center .= '<center><font color=red>���� �� ����� ������ � 4�� ������.</font></center>';
				break;
			}
			if ( ($user['align'] == 4) AND ($ekr_chaos==false) ) {
				$center .= '<center><font color=red>���� �� ����� �� ����������� ����� ��������.</font></center>';
				break;
			}
			
			if($_POST['enter'] && $_POST['pass']) 
			{

					$data = mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = '".$user['id']."' AND `id`= '".(int)$_POST['id']."' AND `pass` = '".md5($_POST['pass'])."';");
					$data = mysql_fetch_array($data);
					if($data) {
						$_SESSION['bankid'] = $data['id'];
						Redirect("exchange.php?view=byekr");
					}
					else
					{
						$center .='<font color=red><b>������ �����.</b></font>';
					}

			}
			
			
			if(!$_SESSION['bankid']) 
			{
			$center .='<table cellspasing=3 cellpadding=2><tr>
			<td><form method=post>
			<fieldset style="width:200px; height:130px;">
			<legend>����� � ����</legend><BR> &nbsp; �';
		
			$banks = mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = ".$user['id'].";");
			$center .='<select style="width:150px" name=id>';
			while ($rah = mysql_fetch_array($banks)) 
			{
			$center .='<option>'.$rah['id'].'</option>';
			}
			$center .='</select>';
			$center .='<BR> &nbsp; ������ <input type=password name=pass size=21>
			<BR><BR>
			<center><input type=submit name="enter" value="�����">
			</form>
			</fieldset>
			</td></tr></table>';
			}
			
			$center .= '</td></tr></table></center>';
		break;		
		
			
	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////	

	
	$head = str_replace('%MONEY%',$user['money'],$head);
	$head = str_replace('%WINSIZE%',"width: 750px; ",$head);
	$head = str_replace('%KAZNA%','',$head);
	
	if ($_SESSION['bankid']>0)
		{
		//$bank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = ".$_SESSION['bankid']."  and owner='".$user['id']."' "));
		$head = str_replace('%BANK%','<br> ���������� ����: �<a href=?view=chbank>'.$bank[id].'</a> <font color=green>'.$bank['cr'].'</font> ��.,<font color=green>'.$bank['ekr'].'</font> ���.' ,$head);
		$center = str_replace('%BANK%','<br> ���������� ����: �<a href=?view=chbank>'.$bank[id].'</a> <font color=green>'.$bank['cr'].'</font> ��.,<font color=green>'.$bank['ekr'].'</font> ���.' ,$center);
		}
		else
		{
		$head = str_replace('%BANK%','<br> ���������� ����:<a href="?view=bankenter">�����</a>',$head);
		$center = str_replace('%BANK%','<br> ���������� ����:<a href="?view=bankenter">�����</a>',$center);		
		}
	$head = str_replace('%'.$view.'%','BGCOLOR="#A5A5A5"',$head);

	$komisspr="���� �������� ��� ������� ���.: ".($komiss*100)."%";
	$head = str_replace('%KOMIS%',$komisspr,$head);
	$center = str_replace('%KOMIS%',$komisspr,$center);
	
	$center = str_replace('%MY_LIM%',$my_cur_limit,$center);
	
	
	echo $head;
	echo $center;
	
	if(isset($_SESSION['vk']) && is_array($_SESSION["vk"])) {
		echo str_replace("%MAILRU%","",$foot);
	} else {
		echo str_replace("%MAILRU%",$mailrucounter,$foot);
	}
	

?>