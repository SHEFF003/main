<?php
//����� ������� ������ � ����
$head = <<<HEADHEAD
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<title>Old BK - �������� �����</title>
	<link rel="StyleSheet" href="newstyle_loc4.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="/i/globaljs.js"></script>
	<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/jscal2.css" />
	<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/border-radius.css" />
	<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/steel/steel.css" />
	<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/jscal2-1.9.js"></script>
	<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/lang/ru2.js"></script>
	<style>
	#page-wrapper table td {
		vertical-align:middle;
	}
	#page-wrapper ul li {
		padding: 0px;
	}
	</style>	
	<script type="text/javascript">
	
	function showhide(id)
	{
	 if (document.getElementById(id).style.display=="none")
	 	{document.getElementById(id).style.display="block";}
	 else
	 	{document.getElementById(id).style.display="none";}
	}
	
		function mkfilt(id) {
		document.getElementById('itype').value=id;
		document.getElementById('apply').value='Yes';
		document.filter.submit();		
		}
	</script>
	
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

</head>
<body id="arenda-body">
<div id="page-wrapper">
    <div class="title">
        <div class="h3">
            �������� �����
        </div>
        <div id="buttons">
            <a class="button-dark-mid btn" href="javascript:void(0);" title="���������" onclick="window.open('help/rentalshop.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes');">���������</a>            
             <a class="button-mid btn" href="javascript:void(0);" title="��������" onclick="location.href='rentalshop.php?refresh='+Math.random();" >��������</a>        
            <a class="button-mid btn" href="javascript:void(0);" title="���������" onclick="location.href='rentalshop.php?exit=1';">���������</a>
        </div>
    </div>
    <div id="arenda">
        <table cellspacing="0" cellpadding="0">
            <colgroup>
                <col>
                <col width="350px">
            </colgroup>
            <tbody>
            <tr>
                <td style="vertical-align:top;">
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr class="head-line">
                            <th>
                                <div class="head-left"></div>
                                <div class="head-title p">
                                    <a %main% href="?view=main">�������� �����</a>
                                </div>
                                <div class="head-separate"></div>
                            </th>
                            <th>
                                <div class="head-title p">
                                    <a %rent% href="?view=rent">����� � ������</a>
                                </div>
                                <div class="head-separate"></div>
                            </th>
                            <th>
                                <div class="head-title p">
                                    <a %myrent% href="?view=myrent">����� � ������</a>
                                </div>
                                <div class="head-separate"></div>
                            </th>
                            <th>
                                <div class="head-title p">
                                    <a %myitems% href="?view=myitems">��� ����</a>
                                </div>
                                <div class="head-separate"></div>
                            </th>
                            <th>
                                <div class="head-title p">
                                    <a %returnitems% href="?view=returnitems">������� ����</a>
                                </div>
                                <div class="head-separate"></div>
                            </th>
                            <th>
                                <div class="head-title p">
                                    <a %addrent% href="?view=addrent">�������� ������</a>
                                </div>
                                <div class="head-right"></div>
                            </th>
                        </tr>
                        </thead>
                        %PAGES%
                    </table>

HEADHEAD;

$mailrucounter = <<<MAILRUCOUNTER
	<div align=left>
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
                </td>
                <td style="vertical-align:top;">
                <form method="POST" name="filter" action="?view=rent" OnSubmit="if (document.getElementById('apply').value != 'Yes' && document.getElementById('reset').value != 'Yes') document.getElementById('apply').value = 'Yes'; return true;">
                    <table id="filter" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td align="left">
                                � ��� � �������: <span class="money"><strong>%MONEY%</strong></span><strong> ��.</strong>
                            </td>
                        </tr>
			%FILTER%
                        <tr>
                            <td style="text-align: right;">
                                <img src="http://i.oldbk.com/i/images/arenda/arenda_illustration.jpg">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
	%MAILRU%
<!-- Asynchronous Tracking GA bottom piece counter-->
<script type="text/javascript">
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ga);
})();
</script>
 
<!-- Asynchronous Tracking GA bottom piece end -->
</body>
</html>
FOOTFOOT;

$newrental = <<<NEWRENTAL
	<tr bgcolor=#A5A5A5><td colspan=2>
		<form method="POST" name="downitm">
			������������ ���� ��������: <input id="calendar-inputField1" size=9 readonly=true type="text" value="%MAXENDTIME%" name="maxendtime">

			<a class="button-mid" href="javascript:void(0);" title="..."  id="calendar-trigger1"> ... </a>
			<br>
			<font color=red>(�� ����� 30 ����)</font><br>
			���� ������ � �����: <input size=4 type="text" name="price"> ��. (�� %MINKR% �� %MAXKR% ��)<br>
			����� �� ����������� ������: <b>%RSTAX%</b> ��.<br>
			����� �� ���������� � ������ ������: <b>%RSGOTAX%</b>%<br><br>
	            	<a class="button-mid btn" href="javascript:void(0);" title="����� ����" onclick="document.downitm.submit();">����� ����</a>
		</form>
		<script>
		var cal = Calendar.setup({
			onSelect   : function() { this.hide() }
		});
		cal.manageFields("calendar-trigger1", "calendar-inputField1", "%d-%m-%Y");
		</script>
	</td></tr>
NEWRENTAL;

$itemsfilter = <<<ITEMSFILTER
                        <tr>
                            <td class="hint-block center">
                                �������������� ��������� ��� ������ ������ ��� �����.
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input placeholder="�������� ��������..." style="width: 205px;" name="iname" value="%INAME%"> 
                                <a href="javascript:void(0);" class="button-mid btn" title="������" onClick="document.getElementById('apply').value='Yes';document.filter.submit();" >������</a>
                                <a href="javascript:void(0);" class="button-mid btn" title="��������" onClick="document.getElementById('reset').value='Yes';document.filter.submit();" >��������</a><br>

				<input type="checkbox" %IUNIK% name="iunik"> ���������� �������<br>
				<input type="checkbox" %IUNIK2% name="iunik2"> ���������� ���������� �������<br>
				<input type="checkbox" %IPODGON% name="ipodgon"> 5 ��������<br>
				<input type="checkbox" %ISHARP% name="isharp"> ������� �������<br>
				<input type="checkbox" %ICHARKA% name="icharka"> ������� ���������<br>

                                <input type="hidden" name="apply" id="apply" value="">
				<input type="hidden" name="reset" id="reset" value="">
				<input type="hidden" name="itype" id="itype" value="%TYPE%">
                            </td>
                        </tr>
                        <tr>
                        <td>����������� ��: <select name="isort">
			<option %ISORT0% value="0">�� ���� ������</option>
			<option %ISORT1% value="1">�� ���� ����</option>
			<option %ISORT2% value="2">�� ���� ���������</option>
			<option %ISORT3% value="3">�� ��������</option>
			</select>
			</td>
                        </tr>
                        <tr>
				<td>������� �� 
                                <select name="ilevellow" >
				%ILEVELLOW%
                                </select> ��
                                <select name="ilevelmax">
				%ILEVELMAX%
                                </select>
                            </td>
                        </tr>
                        <tr>
	                        <td>�������� ��: <select name="iview"><option %VIEW10% value="10">10</option><option %VIEW20% value="20">20</option><option %VIEW50% value="50">50</option></select></td>
			</tr>	                        
                        <tr>
                            <td class="filter-title">������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(1);" >�������, ����</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(11);" >������</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(12);" >������, ������</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(13);" >����</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="filter-title">��������������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(2);" >������</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(21);" >��������</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(22);" >������ �����</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(23);" >������� �����</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(24);">�����</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(3);">����</a>
                                    </li>
				     <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(4);" >������</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(41);">��������</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(42);" >������</a>
                                    </li>
                                
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="filter-title">������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);" onClick="mkfilt(6);" >��������</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
ITEMSFILTER;

$rentaldescription = <<<RDESCR
                    <div class="content-block a_strong">
                        <div class="title">
                            ����� �� ������ ���������� ���� ���� � ������ ������ �������, ���� ����� ���� ������ �������
                            �� ��������� ����������� �� �����
                        </div>
                        <div class="desc-item">
                            ����� � ������ ����� �������������� ���������� ����� (������ ������ ��� ��������������), ������ ������������ ���� �������� ���� � ���� ������ � ����� (�� ����� 2 �����). ���� �������� ������ �� ����� ���� ����� 1% ��� ����� 10% �� ��������� ����. �� ����� ���� � �������� ����� � ������� ���� ��������� 1 ��. ����� ���� � ������ ����� �� ����� ��� �� 30 ����.
                        </div>
                        <div class="desc-item">
                            ����� � ������ ����� ����������� 4 ����. ��������� ����� ����� ���� �� ����� ���� (�� ����� 1 ���), �� �� ������, ��� ������������ ���� �������� ����, ������������� ��������. �������� ������� ������������ ���� ������.
                        </div>
                    </div>
RDESCR;

	function Redirect($path) {
		header("Location: ".$path);
		die();
	}


	function get_itemfilt()	{
		global $itemsfilter;
		$name = isset($_SESSION['rsf_iname']) ? $_SESSION['rsf_iname'] : "";
		$levellow = isset($_SESSION['rsf_ilevellow']) ? $_SESSION['rsf_ilevellow'] : "";
		$levelmax = isset($_SESSION['rsf_ilevellow']) ? $_SESSION['rsf_ilevelmax'] : "";
		$type = isset($_SESSION['rsf_itype']) ? $_SESSION['rsf_itype'] : "";
		$view = isset($_SESSION['rsf_iview']) ? $_SESSION['rsf_iview'] : 10;
		$sort = isset($_SESSION['rsf_isort']) ? $_SESSION['rsf_isort'] : 0;

		$unik = isset($_SESSION['rsf_iunik']) ? $_SESSION['rsf_iunik'] : 0;
		$unik2 = isset($_SESSION['rsf_iunik2']) ? $_SESSION['rsf_iunik2'] : 0;
		$charka = isset($_SESSION['rsf_icharka']) ? $_SESSION['rsf_icharka'] : 0;
		$sharp = isset($_SESSION['rsf_isharp']) ? $_SESSION['rsf_isharp'] : 0;
		$podgon = isset($_SESSION['rsf_ipodgon']) ? $_SESSION['rsf_ipodgon'] : 0;

		$opt='';				
		for ($k=0;$k<=14;$k++) {
			$opt.='<option value="'.$k.'"';
			if ($k==$levellow ) $opt.=' selected ';
			$opt.='>'.$k.'</option>';
		}

		$itemsfilter = str_replace("%ILEVELLOW%",$opt,$itemsfilter);
					
		$opt='';				
		for ($k=14;$k>=1;$k--) {
			$opt.='<option value="'.$k.'"';
			if ($k==$levelmax ) $opt.=' selected ';
			$opt.='>'.$k.'</option>';
		}

		$itemsfilter = str_replace("%ILEVELMAX%",$opt,$itemsfilter);					
		$itemsfilter = str_replace("%TYPE%",$type,$itemsfilter);									
					
		$itemsfilter = str_replace("%INAME%",htmlspecialchars($name,ENT_QUOTES),$itemsfilter);
		$itemsfilter = str_replace("%VIEW".$view."%","selected",$itemsfilter);
		$itemsfilter = str_replace("%ISORT".$sort."%","selected",$itemsfilter);

		$itemsfilter = str_replace("%IUNIK%",($unik > 0 ? "checked" : ""),$itemsfilter);
		$itemsfilter = str_replace("%IUNIK2%",($unik2 > 0 ? "checked" : ""),$itemsfilter);
		$itemsfilter = str_replace("%ICHARKA%",($charka > 0 ? "checked" : ""),$itemsfilter);
		$itemsfilter = str_replace("%ISHARP%",($sharp > 0 ? "checked" : ""),$itemsfilter);
		$itemsfilter = str_replace("%IPODGON%",($podgon > 0 ? "checked" : ""),$itemsfilter);

		$arr=array($itemsfilter,$name,$levellow,$levelmax,$type,$view,$sort,$unik,$unik2,$podgon,$sharp,$charka);
		return ($arr);
	}

	session_start();

	if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) Redirect("index.php");

	require_once('connect.php');
	require_once('functions.php');
	
	
	// �������� ���� �����
	$q = mysql_query('SELECT * FROM `users` WHERE `id` = '.$_SESSION["uid"]) or die();
	$user = mysql_fetch_assoc($q) or die();


	if(!$_SESSION['beginer_quest'][none]) {
		$last_q=check_last_quest(5);
		if($last_q) {
			quest_check_type_5($last_q);
		}
	}

	$rentalshopid = 449;
	$rentmin = 1; // 1% ������� ������ �� ��������� ����
	$rentmax = 10; // 10% �������� ������ �� ��������� ���� � ����
	$rstax = 1; // 1 ��. - ����� �� ����������� ������
	$rsgotax = 10; // 10% - ������� ������ ����������� �� ����������� �������� �����
	$maxrsitems = 4; // ������������ ���������� ����� ������� ����� ���������� ����

	if ($user['room'] != 47) Redirect("main.php");
	if ($user['battle'] != 0 || $user['battle_fin'] != 0) { Redirect("fbattle.php"); }

	if (isset($_GET['exit'])) {
		mysql_query('UPDATE `users` SET `users`.`room` = "66" WHERE `users`.`id` = '.$_SESSION['uid']) or die();
		Redirect('city.php');
	}

	$view = isset($_GET['view']) ? $_GET['view'] : "main";

	// �������� �� �������
	if ($user['level'] < 4 || $user['align'] == 4) $view = "main";

	$center = "";
	switch($view) {
		default:
			$view = "main";
		case "main":
			$center = '<center>';
			if ($user['level'] < 4) {
				$center .= '<font color=red>���� � �������� ����� ������ � 4�� ������.</font></center>';
				break;
			}
			if ($user['align'] == 4) {
				$center .= '<font color=red>���� � ������ ��������.</font></center>';
				break;
			}
			$center .= $rentaldescription;
			$center .= '</center>';
		break;
		case "myrent":
			if ($_SERVER['REQUEST_METHOD'] == "POST") 
			{
				if (isset($_GET['id']) && isset($_POST['price'],$_POST['maxendtime'])) {
					$id = intval($_GET['id']);
					$price = round(floatval($_POST['price']),2);

					if ($user['money'] < 1) Redirect('rentalshop.php?view=myrent&id='.$id.'&error=2');

					// ��������� ������
					$maxendtime = explode("-",$_POST['maxendtime']);
					if (count($maxendtime) != 3) Redirect('rentalshop.php?view=myrent');
					$maxendtime = mktime(0,0,0,$maxendtime[1],$maxendtime[0],$maxendtime[2]);
					$nowtime = mktime(0,0,0,date("m"),date("d"),date("y"));
					$diffdays = ($maxendtime - $nowtime) / (60*60*24);
					if ($diffdays < 2) Redirect('rentalshop.php?view=myrent&id='.$id.'&error=3');
					if ($diffdays > 30) Redirect('rentalshop.php?view=myrent&id='.$id.'&error=4');

					// ���� ������
					// ������ ����. ���� 17/07/11 Umk

					$q = mysql_query('SELECT * FROM oldbk.`inventory` WHERE `id` = '.$id.' AND `setsale` = 0 AND `owner` = '.$user['id'].' AND `dressed` = 0 AND
					`sowner` = 0 AND dategoden=0 AND prokat_idp=0 AND `present` = "" AND prototype not in (2000,2001,2002,2003,260,262,272,5277,5278,121121122,121121123,121121124,18210,18229,18247,18527)
					AND cost > 0 AND ((`type` > 0 AND `type` < 12) OR `type` = 27 OR `type` = 28) AND duration <> maxdur and otdel not in (62,63) and (nlevel < 8 or nclass > 0 or type IN ('.implode(",",$noclass_items_ok).'))') or die();
					
					$item = mysql_fetch_assoc($q) or die();
					
						$ups_types=array(1,2,3,4,5,8,9,10,11);
						$ebarr=array(128,17,149,148);
	
						if ((strpos($item['name'], '[') == true) AND (in_array($item['prototype'],$ebarr) ) )
						{
						Redirect('rentalshop.php?view=myrent&id='.$id.'&error=0');
						}
						else
						if ((strpos($item['name'], '[') == true) AND ($item['art_param']!='') )
						{
						//�� ����� ������:
						Redirect('rentalshop.php?view=myrent&id='.$id.'&error=0');
						}
						elseif ((strpos($item['name'], '[') == true) AND (($item['type']==28) OR $item['prototype']==100028 OR $item['prototype']==100029 OR $item['prototype']==173173 OR $item['prototype']==2003 OR $item['prototype']==195195) )
						{
						//�� ����� ������� ���� �������:
						Redirect('rentalshop.php?view=myrent&id='.$id.'&error=0');
						}
						elseif ( (strpos($item['name'], '[') == true) AND (in_array($item['type'],$ups_types)) AND $item['ab_mf']==0  AND $item['ab_bron']==0  AND $item['ab_uron']==0   ) // �� ���� ���� 
						{
						//�� �������	
						Redirect('rentalshop.php?view=myrent&id='.$id.'&error=0');
						}	
					
					if($item['add_pick']!='') {
	    					undress_img($item);
					}
					if ($price < round($item['cost']*$rentmin/100,2)) Redirect('rentalshop.php?view=myrent&id='.$id.'&error=0');
					if ($price > round($item['cost']*$rentmax/100,2)) Redirect('rentalshop.php?view=myrent&id='.$id.'&error=1');

					if (give_count($user['id'],1) )
					{
					// �� �� - ���� � �����
					mysql_query('START TRANSACTION') or die();

				        //new_delo
					$rec = array();
  		    			$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'] - $rstax;
					$rec['target']=$rentalshopid;
					$rec['target_login']="�������� �����";
					$rec['type']=212; //���� � �����
					$rec['sum_kr']=$rstax;
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
					$rec['item_mfinfo']=$item['mfinfo'];
					$rec['item_level']=$item['nlevel'];
					$rec['add_info'] = $diffdays.'/'.$price;
					$rec['item_incmagic_id']=$item['includemagic'];
					$rec['item_proto']=$item['prototype'];
					$rec['item_sowner']=($item['sowner']>0?1:0);
					add_to_new_delo($rec); //�����

					// ������� ����� �� ��������
					mysql_query('UPDATE `users` SET `money` = `money` - "'.$rstax.'" WHERE id = '.$user['id']) or die();

					// ��������� ���� � �������� �����
					mysql_query('
						INSERT INTO oldbk.`rentalshop` (`itemid` ,`owner`, `maxendtime`, `price`)
						VALUES
						(
							"'.$_GET['id'].'",
							"'.$user['id'].'",
							"'.(($diffdays*24*60*60)+time()).'",
							"'.$price.'"
						)
					') or die();

					// �������� ���� � �������� �����
					mysql_query('UPDATE oldbk.`inventory` SET owner = "'.$rentalshopid.'", dressed = 0 WHERE id = '.$_GET['id']) or die();

					mysql_query('COMMIT') or die();

					// ������� ��� �� ��
					Redirect('rentalshop.php?view=myrent&ok');
					}
					else
					{
					Redirect('rentalshop.php?view=myrent&id='.$id.'&error=5');
					}

				}
				Redirect('rentalshop.php?view=myrent');
			}

			// ������ ����. ���� 17/07/11 Umk
			// �������� ���� ��� ����� � ������
			$q = mysql_query('SELECT * FROM oldbk.`inventory` WHERE `setsale` = 0 AND `owner` = '.$user['id'].' AND `dressed` = 0 AND `sowner` = 0 AND dategoden=0 AND
			prokat_idp=0 AND `present` = "" AND prototype not in (2000,2001,2002,2003,260,262,272,5277,5278,121121122,121121123,121121124,18210,18229,18247,18527)
			AND cost > 0 AND ((`type` > 0 AND `type` < 12) OR `type` = 27 OR `type` = 28 ) AND duration <> maxdur and otdel not in (62,63) and (nlevel < 8 or nclass > 0 or type IN ('.implode(",",$noclass_items_ok).')) ORDER by `update` DESC') or die();
			$center = '<center>';
			if (isset($_GET['ok'])) $center .= '<font color=red>���� ������ ����� � �������� �����.</font><br><br>';
			if (mysql_num_rows($q) == 0 && !isset($_GET['ok'])) {
				$center .= '<font color=red>� ��� ��� ���������� ����� ����� ����� � ������.</font><br><br>';
			}
			$center .= '<TABLE class="a_strong" width=80% BORDER=0 CELLSPACING="1" CELLPADDING="2"><TR><TD style="vertical-align:top;">';
			$center .= '<TABLE BORDER=0 CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
			$i = 0;

			// output buffering ��� ���� ����� ����������� ����� showitem()
			ob_start();
			while($item = mysql_fetch_assoc($q)) {
				$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
				$action = '<a href="?view=myrent&id='.$item['id'].'">����� � �������� �����</a>';
				showitem($item,0,false,$color,$action);
				$center .= ob_get_contents();
				ob_clean ();
				$i++;
			}
			ob_end_clean();
			$center .= '</table>';

			$center .= '</TD><TD style="vertical-align:top;">';
			if (isset($_GET['id'])) {
				if (isset($_GET['error'])) {
					switch($_GET['error']) {
						case 0:
							$error = '��������� ������ � ����� �� ������ ���� ������ '.$rentmin.'% ��������� ����.';
						break;
						case 1:
							$error = '��������� ������ � ����� �� ������ ���� ������ '.$rentmax.'% ��������� ����.';
						break;
						case 2:
							$error = '� ��� ������������ ����� ��� ����������� ����.';
						break;
						case 3:
							$error = '����������� ���� ������ - 2 ���.';
						break;
						case 4:
							$error = '������������ ���� ������ - 30 ����.';
						break;
						case 4:
							$error = '� ��� ������������ ������ �������!';
						break;						
					}
					$center .= '<font color=red>'.$error.'</font><br><br>';
				}
				//$center .= '<table BORDER=0 CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5"><tr bgcolor=#A5A5A5><td colspan=2 align=center>�� ������ ����� ���� � �������� �����</td></tr>';
				$id = intval($_GET['id']);
				$q = mysql_query('SELECT * FROM oldbk.`inventory` WHERE `id` = '.$id.' AND `setsale` = 0 AND `owner` = '.$user['id'].' AND `dressed` = 0 AND `sowner` = 0 AND dategoden=0 AND prokat_idp=0 AND `present` = "" AND cost > 0 AND ((`type` > 0 AND `type` < 12) OR `type` = 27 OR `type` = 28  )') or die();
				$item = mysql_fetch_assoc($q) or die();

				// output buffering ��� ���� ����� ����������� ����� showitem()
		
				$ups_types=array(1,2,3,4,5,8,9,10,11);
				$ebarr=array(128,17,149,148);
	
				if ((strpos($item['name'], '[') == true) AND (in_array($item['prototype'],$ebarr) ) )
				{
				$center .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ ���� ����� � ��������� ����������, ����� ���  ���������� ���������� ����� 00:00 27.09.14.</red></small>";		
				}
				else
				if ((strpos($item['name'], '[') == true) AND ($item['art_param']!='') )
				{
				//�� ����� ������:
				$center .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ � ������������ ������, ����� ���  ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 						
				}
				elseif ((strpos($item['name'], '[') == true) AND (($item['type']==28) OR $item['prototype']==100028 OR $item['prototype']==100029 OR $item['prototype']==173173 OR $item['prototype']==2003 OR $item['prototype']==195195) )
				{
				//�� ����� ������� ���� �������:
				$center .= "<br><small><font color=red>��������! ��� ���� ���������� ��������� �������� � ��������� ����������, ����� ��� ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 							
				}
				elseif ( (strpos($item['name'], '[') == true) AND (in_array($item['type'],$ups_types)) AND $item['ab_mf']==0  AND $item['ab_bron']==0  AND $item['ab_uron']==0   ) // �� ���� ���� 
				{
				//�� �������	
				$center .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ � ��������� ����������, ����� ��� ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 				
				}	
				else
				{
				$center .= '<table BORDER=0 CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5"><tr bgcolor=#A5A5A5><td colspan=2 align=center>�� ������ ����� ���� � �������� �����</td></tr>';				
				ob_start();				
				showitem($item,0,false,'#C7C7C7','&nbsp;');
				$center .= ob_get_contents();
				ob_end_clean();
				$newrental = str_replace('%MAXENDTIME%',date("d-m-Y",time()+60*60*24*7),$newrental);
				$newrental = str_replace('%RSTAX%',$rstax,$newrental);
				$newrental = str_replace('%RSGOTAX%',$rsgotax,$newrental);
				$newrental = str_replace('%MINKR%',round($item['cost']*$rentmin/100,2),$newrental);
				$newrental = str_replace('%MAXKR%',round($item['cost']*$rentmax/100,2),$newrental);
				$center .= $newrental;
				$center .= '</table>';
				}

			}
			$center .= '</TD></TR></table></center>';
		break;
		case "myitems":
			if (isset($_GET['returnitem'])) {
				$id = intval($_GET['returnitem']);
				// ������ ���� �� �����
				// �������� �� ID
				
				if (give_count($user['id'],1) )
				{
				mysql_query('START TRANSACTION') or die();
				$q = mysql_query('
					SELECT rs.id AS rsid, rs.itemid AS rsitemid, rs.owner AS rsowner, rs.endtime AS rsendtime, rs.maxendtime AS rsmaxendtime, rs.tempowner AS rstempowner, rs.price AS rsprice, inv.* FROM oldbk.`rentalshop` AS `rs`
					LEFT JOIN oldbk.`inventory` AS inv
					ON rs.itemid = inv.id
					WHERE rs.owner = '.$user['id'].' AND rs.tempowner = 0 AND rs.maxendtime > '.time().' AND rs.id = '.$id.' FOR UPDATE
				') or die();

				if (mysql_num_rows($q) > 0) {
					$item = mysql_fetch_assoc($q) or die();

					// ����� � ����

				        //new_delo
					$rec = array();
  		    			$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=$rentalshopid;
					$rec['target_login']="�������� �����";
					$rec['type']=213; // ������� �� �����
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
					$rec['item_incmagic']=$item['includemagicname'];
					$rec['item_incmagic_count']=$item['includemagicuses'];
					$rec['item_arsenal']='';
					$rec['add_info'] = '';
					$rec['item_incmagic_id']=$item['includemagic'];
					$rec['item_proto']=$item['prototype'];
					$rec['item_sowner']=($item['sowner']>0?1:0);
					$rec['item_mfinfo']=$item['mfinfo'];
					$rec['item_level']=$item['nlevel'];
					add_to_new_delo($rec); //�����

					// ���������� ���� ���������
					mysql_query('UPDATE oldbk.`inventory` SET owner = '.$user['id'].', dressed = 0 WHERE id = '.$item['rsitemid']) or die();

					// ������� ������ � �����
					mysql_query('DELETE FROM oldbk.`rentalshop` WHERE id = '.$id);

					mysql_query('COMMIT') or die();
					Redirect('rentalshop.php?view=myitems&return');
				}

				mysql_query('COMMIT') or die();
				Redirect('rentalshop.php?view=myitems');
				}
				else
				{
				$center = '<font color=red>�� �� ������ ������� ����, � ��� ������������ ������ ������� �� �������!</font><br><br>';
				}
				
			}
	
			// �������� ���� ���� �� �������� �����
			$q = mysql_query('
					SELECT rs.id AS rsid, rs.itemid AS rsitemid, rs.owner AS rsowner, rs.endtime AS rsendtime, rs.maxendtime AS rsmaxendtime, rs.tempowner AS rstempowner, rs.price AS rsprice, inv.* FROM oldbk.`rentalshop` AS `rs`
					LEFT JOIN oldbk.`inventory` AS inv
					ON rs.itemid = inv.id
					WHERE rs.owner = '.$user['id'].' AND rs.maxendtime > '.time().'
			') or die(mysql_error());

			$center .= '<center>';
			//$center .= '<font color=red>���� �� ������� � ������ ������, ���������� �� ���� (<a href="http://capitalcity.oldbk.com/news.php?topic=4720" target="_blank">http://capitalcity.oldbk.com/news.php?topic=4720</a>)<br> � �� ������ �� � ���� �������, �� �� ����������, ������ ������ �� �������.<br> ��� ������ ���������� ���� ������ � �����, � ������� ��� �� �����, - ������ �������� � ��� � ���������.</font><br><br>';

			if (isset($_GET['return'])) $center .= '<font color=red>�� ������� ���� ���� �� �������� �����.</font><br><br>';
			if (mysql_num_rows($q) == 0 && !isset($_GET['return'])) {
				$center .= '<font color=red>�� �� ����� �� ����� ����.</font><br><br>';
			}
			$center .= '<TABLE class="a_strong" BORDER=0 CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
			$i = 0;

			// output buffering ��� ���� ����� ����������� ����� showitem()
			ob_start();
			while($item = mysql_fetch_assoc($q)) {
				$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
				$action = '���� ������: <b>'.$item['rsprice'].'</b>&nbsp;��.&nbsp;�&nbsp;����<br>������������&nbsp;������&nbsp;��: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsmaxendtime']).'</b><br>';
				$action .= $item['rstempowner'] == 0 ? '<br><a href="?view=myitems&returnitem='.$item['rsid'].'">������� ����</a>': '���� ���������� ��: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsendtime']).'</b>';
				showitem($item,0,false,$color,$action);
				$center .= ob_get_contents();
				ob_clean ();
				$i++;
			}
			ob_end_clean();
			$center .= '</table></center>';
		break;

		case "rent";
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				if (isset($_GET['id']) && isset($_POST['days'])) {
					$id = intval($_GET['id']);
					$days = intval($_POST['days']);
					if ($days < 1) {
						Redirect('rentalshop.php?view=rent&id='.$id.'&error=0');
					}

					// �������� ���� � ������

					// ��������� ����� ������ ������ n ������ ��� ����������
					$q = mysql_query('SELECT NULL FROM oldbk.`rentalshop` WHERE tempowner = '.$user['id']) or die();
					if (mysql_num_rows($q) >= $maxrsitems) {
						Redirect('rentalshop.php?view=rent&id='.$id.'&error=4');
					}

					mysql_query('START TRANSACTION') or die();
					// ��������, ��������� ����� ���� ���� �� ��� � � ����� ������ �� ����
					$q = mysql_query('SELECT * FROM oldbk.`rentalshop` WHERE owner <> '.$user['id'].' AND tempowner = 0 AND `id` = '.$id.' FOR UPDATE') or die();

					if (mysql_num_rows($q) > 0) {
						$item = mysql_fetch_assoc($q) or die();
						$endtime = (time()+($days*24*60*60));
						// ��������� �����. ������� ����� ������ - �����
						if ($item['maxendtime'] < $endtime) {
							mysql_query('COMMIT') or die();
							Redirect('rentalshop.php?view=rent&id='.$id.'&error=1');
						}

						$price = round($item['price']*$days,2);

						// ��������� ������ �� ����� �� ������
						if ($user['money'] < $price) {
							mysql_query('COMMIT') or die();
							Redirect('rentalshop.php?view=rent&id='.$id.'&error=2');
						}

						// �� �� - ������ ������ � ����� ������� + � ���� �����


						// ������� ������� ����
						$owner = check_users_city_data($item['owner']);

						// ������� ������
						mysql_query('UPDATE `users` SET money = money - '.$price.' WHERE id = '.$user['id']) or die();

						$q = mysql_query('SELECT * FROM oldbk.`inventory` WHERE id = '.$item['itemid']) or die();
						$itemd = mysql_fetch_assoc($q) or die();
						$itemdescr = mysql_real_escape_string('"'.$itemd['name'].'" id:(cap'.$itemd['id'].') 1 ��. ['.$itemd['duration'].'/'.$itemd['maxdur'].'] [ups:'.$itemd['ups'].'/unik:'.$itemd['unik'].'/inc:'.$itemd['includemagicname'].']');

					        //new_delo
						$rec = array();
	  		    			$rec['owner']=$user[id]; 
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money']-$price;
						$rec['target']=$rentalshopid;
						$rec['target_login']="�������� �����";
						$rec['type']=214; // �������� �� ������
						$rec['sum_kr']=$price;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=get_item_fid($itemd);
						$rec['item_name']=$itemd['name'];
						$rec['item_count']=1;
						$rec['item_type']=$itemd['type'];
						$rec['item_cost']=$itemd['cost'];
						$rec['item_dur']=$itemd['duration'];
						$rec['item_maxdur']=$itemd['maxdur'];
						$rec['item_ups']=$itemd['ups'];
						$rec['item_unic']=$itemd['unik'];
						$rec['item_incmagic']=$itemd['includemagicname'];
						$rec['item_incmagic_count']=$itemd['includemagicuses'];
						$rec['item_arsenal']='';
						$rec['add_info'] = $days.'/'.$owner['login'].'/'.$owner['id'];
						$rec['item_incmagic_id']=$itemd['includemagic'];
						$rec['item_proto']=$itemd['prototype'];
						$rec['item_sowner']=($itemd['sowner']>0?1:0);
						$rec['item_mfinfo']=$itemd['mfinfo'];
						$rec['item_level']=$itemd['nlevel'];

						add_to_new_delo($rec); //�����


						// ���������� ����

						// ���������� ���������� ��������� � ������� � ���� ��������� ������
						mysql_query('UPDATE oldbk.`rentalshop` SET tempowner = '.$user['id'].', endtime = '.$endtime.' WHERE id = '.$id) or die();

						// ������� ����
						mysql_query('UPDATE oldbk.`inventory` SET owner = '.$user['id'].', dressed = 0, present = "�������� �����", letter = "������ �������������: '.date("d/m/Y H:i",$endtime).'" WHERE id = '.$item['itemid']) or die();

						// ����� ������ � ���������
						$text = '�� ����� � ������ '.$itemdescr.'.<br> ������ ������������� '.date("d/m/Y H:i",$endtime);
						mysql_query('
							INSERT INTO oldbk.`inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`,`gmp`, `includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`gmeshok`,`tradesale`)
							VALUES(
								"'.$user['id'].'",
								"������",
								"50",
								1,
								0,
								"paper100.gif",
								"'.$text.'",
								1,
								0,0,0,0,0,"",0,0,0
							)
						') or die();

						// ������ ��������� � �������������

						// ���������� ��� ����� �� ������� �����
						$toowner = round($price - ($price * $rsgotax / 100),2);

						if ($owner['id_city'] == 1) {
							mysql_query('UPDATE avalon.`users` SET money = money + '.$toowner.' WHERE id = '.$owner['id']) or die();
						} else {
							mysql_query('UPDATE oldbk.`users` SET money = money + '.$toowner.' WHERE id = '.$owner['id']) or die();
						}

						// ����� ��� � ����

					        //new_delo
						$rec = array();
	  		    			$rec['owner']=$owner[id]; 
						$rec['owner_login']=$owner[login];
						$rec['owner_balans_do']=$owner['money'];
						$rec['owner_balans_posle']=$owner['money']+$toowner;
						$rec['target']=$rentalshopid;
						$rec['target_login']="�������� �����";
						$rec['type']=215; // ������� �� �� ������
						$rec['sum_kr']=$toowner;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=round($price-$toowner,2);
						$rec['item_id']=get_item_fid($itemd);
						$rec['item_name']=$itemd['name'];
						$rec['item_count']=1;
						$rec['item_type']=$itemd['type'];
						$rec['item_cost']=$itemd['cost'];
						$rec['item_dur']=$itemd['duration'];
						$rec['item_maxdur']=$itemd['maxdur'];
						$rec['item_ups']=$itemd['ups'];
						$rec['item_unic']=$itemd['unik'];
						$rec['item_incmagic']=$itemd['includemagicname'];
						$rec['item_incmagic_count']=$itemd['includemagicuses'];
						$rec['item_arsenal']='';
						$rec['add_info'] = $days.'/'.$user['login'].'/'.$user['id'];
						$rec['item_incmagic_id']=$itemd['includemagic'];
						$rec['item_proto']=$itemd['prototype'];
						$rec['item_sowner']=($itemd['sowner']>0?1:0);
						$rec['item_mfinfo']=$itemd['mfinfo'];
						$rec['item_level']=$itemd['nlevel'];
						add_to_new_delo($rec); //�����

						// �������� �������
						telepost($owner['login'],'<font color=red>��������!</font> ���� ���� ���� ����������: "'.htmlspecialchars($itemd['name'],ENT_QUOTES).'" �� '.$days.' ��., ��� ����������� '.$toowner.' ��. �������� �������� ����� ���������: '.round($price-$toowner,2).' ��.');

						mysql_query('COMMIT') or die();
						Redirect('rentalshop.php?view=rent&id='.$id.'&error=3');
					}

					mysql_query('COMMIT') or die();
					Redirect('rentalshop.php?view=rent');
				}
				
				
				if (($_POST['apply']!='') && isset($_POST['iname'],$_POST['itype'],$_POST['ilevellow'],$_POST['ilevelmax'],$_POST['iview'],$_POST['isort'])) {

					$_SESSION['rsf_iname'] = stripslashes($_POST['iname']);
					$_SESSION['rsf_ilevellow'] = $_POST['ilevellow'] === "" ? "": intval($_POST['ilevellow']);
					$_SESSION['rsf_ilevelmax'] = $_POST['ilevelmax'] === "" ? "": intval($_POST['ilevelmax']);
					$_SESSION['rsf_itype'] = $_POST['itype'] === "" ? "" : intval($_POST['itype']);
					$_SESSION['rsf_iview'] = intval($_POST['iview']);
					$_SESSION['rsf_isort'] = intval($_POST['isort']);

					$_SESSION['rsf_iunik'] = (isset($_POST['iunik']) ? 1 : 0);
					$_SESSION['rsf_iunik2'] = (isset($_POST['iunik2']) ? 1 : 0);
					$_SESSION['rsf_icharka'] = (isset($_POST['icharka']) ? 1 : 0);
					$_SESSION['rsf_ipodgon'] = (isset($_POST['ipodgon']) ? 1 : 0);
					$_SESSION['rsf_isharp'] = (isset($_POST['isharp']) ? 1 : 0);
				}
				else
				if ($_POST['reset']!='') {
					$_SESSION['rsf_iname'] = "";
					$_SESSION['rsf_ilevellow'] = "";
					$_SESSION['rsf_ilevelmax'] = "";
					$_SESSION['rsf_itype'] = "";
					$_SESSION['rsf_iview'] = 10;
					$_SESSION['rsf_isort'] = 0;
					$_SESSION['rsf_iunik'] = 0;
					$_SESSION['rsf_iunik2'] = 0;
					$_SESSION['rsf_icharka'] = 0;
					$_SESSION['rsf_ipodgon'] = 0;
					$_SESSION['rsf_isharp'] = 0;


				}
				Redirect("rentalshop.php?view=rent");
			}

			$center = '';
			$goid = "";
			$addsql = "";
			$limit = "";
			if (isset($_GET['id'])) 
			{
				$id = intval($_GET['id']);
				$goid = 'AND rs.id = '.$id;
			} 
			else
			{
			//filter
					
							
	
				$ar = get_itemfilt();
				$tpl=$ar[0];
				$name=$ar[1];
				$levellow=$ar[2];
				$levelmax=$ar[3];
				$type=$ar[4];
				$view=$ar[5];
				$sort=$ar[6];

				$unik=$ar[7];
				$unik2=$ar[8];
				$podgon=$ar[9];
				$sharp=$ar[10];
				$charka=$ar[11];

				
				if ($type !== "") {
					$addsql .= ' AND otdel = '.$type;
				}
				if ($levellow !== "") {
					$addsql .= ' AND nlevel >= '.$levellow;
				}
				if ($levelmax !== "") {
					$addsql .= ' AND nlevel <= '.$levelmax;
				}
				if ($name !== "") {
					$addsql .= ' AND name LIKE "%'.addcslashes(mysql_real_escape_string(str_replace('\\','\\\\',$name)),"%_").'%" ';
				}

				if ($unik > 0) $addsql .= ' AND unik = 1';
				if ($unik2 > 0) $addsql .= ' AND unik = 2';
				if ($podgon > 0) $addsql .= ' AND ups = 5';
				if ($charka > 0) $addsql .= ' AND LENGTH(charka) > 1';
				if ($sharp > 0) $addsql .= ' AND name LIKE "%+%"';


				if (isset($_GET['page'])) {
					$page = intval($_GET['page']);
					$limit .= ' LIMIT '.($page*$view).','.$view.' ';
				} else {
					$page = 0;
					$limit .= ' LIMIT '.$view.' ';
				}
			}
					


			$sortsql = "";
			switch($sort) {
				default: case 0:
					$sortsql = "rs.price";
				break;
				case 1:
					$sortsql = "inv.cost";
				break;
				case 2:
					$sortsql = "rs.maxendtime";
				break;
				case 3:
					$sortsql = "inv.name";
				break;
			}
			// �������� ���� �� �������� ����� � ������� � �� ������ � ���� ���� ��� ��������
			$q = mysql_query('
					SELECT SQL_CALC_FOUND_ROWS rs.id AS rsid, rs.itemid AS rsitemid, rs.owner AS rsowner, rs.endtime AS rsendtime, rs.maxendtime AS rsmaxendtime, rs.tempowner AS rstempowner, rs.price AS rsprice, inv.* FROM oldbk.`rentalshop` AS `rs`
					LEFT JOIN oldbk.`inventory` AS inv
					ON rs.itemid = inv.id
					WHERE inv.owner = "'.$rentalshopid.'" '.$goid.' AND rs.owner <> '.$user['id'].' AND rs.maxendtime > '.(time()+(60*60*24)+(3*60)).' AND inv.duration <> inv.maxdur '.$addsql.' ORDER BY '.$sortsql.' ASC '.$limit
			) or die(mysql_error());



			if (!isset($_GET['id'])) {
				$q2 = mysql_query('SELECT FOUND_ROWS() AS `allcount`') or die();
				$allcount = mysql_fetch_assoc($q2);
				$allcount = $allcount['allcount'];

				$pages = '
				          <tbody>
		                        <tr class="odd">
		                            <td colspan="6">';
		                            if (ceil($allcount/$view)>0) $pages.='��������: ';
		                            $pages.='<ul class="pagination">';
				for ($i = 0; $i < ceil($allcount/$view); $i++) {
					if ($page == $i) {
						$pages .= '<li> '.($i+1).'</li> ';
	                                } else {
						$pages .= '<li><a href="?view=rent&page='.$i.'">'.($i+1).'</a></li>';
					}
				}
	                     $pages .='</ul>
		                            </td>
		                        </tr>
		                        </tbody>';
				$head = str_replace("%PAGES%",$pages,$head );
			}
			


			if (isset($_GET['error'])) {
				switch($_GET['error']) {
					case 0:
						$error = '����������� ���� ������ 1 ����.';
					break;
					case 1:
						$error = '�� �� ������ ���������� ���� �� ����� ����, ������������ ���� � ������ ������������� ������.';
					break;
					case 2:
						$error = '� ��� ������������ ����� ����� ��������� ������.';
					break;
					case 3:
						$error = '�� ������ ���������� ����.';
					break;
					case 4:
						$error = '�� ��������� ������������ ���������� ������������ �����.';
					break;
				}
				$error = '<font color=red>'.$error.'</font><br>';
			}


			$center .= '<div class="content-block a_strong">
				<table class="table border" cellspacing="0" cellpadding="0" >
				<colgroup>
				<col width="200px">
				</colgroup>
				<tbody>
				<tr class="even2">
				<td class="center" style="vertical-align: middle;text-align:left;">'.$error.'
				<TABLE  CELLSPACING="0" CELLPADDING="0"  class="table border a_strong" >';
			$i = 0;
			if (mysql_num_rows($q) == 0 && !isset($_GET['error'])) {
			
				if (isset($_GET['id'])) {
					$center .= '<tr><td bgcolor=white>�� �� ������ ���������� ��� ����.</td></tr>';
				} else {
					$center .= '<tr><td bgcolor=white>� ���� ������ ���� �� �������, ���������� �������� ������.</td></tr>';
				}
			}


			// output buffering ��� ���� ����� ����������� ����� showitem()
			ob_start();
			while($item = mysql_fetch_assoc($q)) {
				$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
				if (isset($_GET['id'])) {
					$dalert = "";
					if ($item['duration'] == $item['maxdur']) {
					$dalert = ' onClick=" if (confirm(\'���� ��������� ��������. �� ������������� ������ �� ����������?\')) { document.take.submit();} ;" ';
					}
					else
					{
					$dalert = ' onClick="document.take.submit();" ';
					}
					
					$action = '���� ������: <b>'.$item['rsprice'].'</b>&nbsp;��.&nbsp;�&nbsp;����<br> ������������ ������ ��: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsmaxendtime']).'</b><br><br><form method="POST" name="take">����������&nbsp;��:&nbsp;<input type="text" size=4 name="days" value="1">&nbsp;�����<br><a class="button-mid btn" href="javascript:void(0);" title="����������" '.$dalert.'>����������</a></form><br><br>';
				} else {
					$action = '���� ������: <b>'.$item['rsprice'].'</b>&nbsp;��.&nbsp;�&nbsp;����<br> ������������&nbsp;������&nbsp;��: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsmaxendtime']).'</b><br><br><a href="?view=rent&id='.$item['rsid'].'">����������</a>';
				}
				showitem($item,0,false,$color,$action);
				$center .= ob_get_contents();
				ob_clean ();
				$i++;
			}
			ob_end_clean();
			$center .= '</table><table bgcolor=#A5A5A5>'.$pages.'</table></td>
</tr>
</tbody>
</table>
</div>';
		break;

		case "addrent":
			$addid = "";
			if (isset($_GET['id'])) {
				$id = intval($_GET['id']);
				$addid = ' AND rs.id = '.$id;

				if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['days'])) {
					$days = intval($_POST['days']);
					if ($days < 1) {
						Redirect('rentalshop.php?view=addrent&id='.$id.'&error=0');
					}

					mysql_query('START TRANSACTION') or die();
					$t = time();
					$q = mysql_query('
						SELECT rs.id AS rsid, rs.itemid AS rsitemid, rs.owner AS rsowner, rs.endtime AS rsendtime, rs.maxendtime AS rsmaxendtime, rs.tempowner AS rstempowner, rs.price AS rsprice, inv.* FROM oldbk.`rentalshop` AS `rs`
						LEFT JOIN oldbk.`inventory` AS inv
						ON rs.itemid = inv.id
						WHERE inv.owner = '.$user['id'].' AND rs.maxendtime > '.$t.' AND rs.endtime > '.$t.' AND rs.id = '.$id.' AND rs.tempowner = '.$user['id'].' FOR UPDATE
					') or die();

					if (mysql_num_rows($q) > 0) {
						$item = mysql_fetch_assoc($q) or die();

						// ��������� �� ������� ���� �������� �� ����� ��������
						$maxdays = floor((($item['rsmaxendtime'] - $item['rsendtime'])/(60*60*24)));

						// ��������� �����. ������� ����� ������ - �����
						if ($days > $maxdays) {
							mysql_query('COMMIT') or die();
							Redirect('rentalshop.php?view=addrent&id='.$id.'&error=1');
						}

						$price = round($item['rsprice']*$days,2);

						// ��������� ������ �� ����� �� ������
						if ($user['money'] < $price) {
							mysql_query('COMMIT') or die();
							Redirect('rentalshop.php?view=addrent&id='.$id.'&error=2');
						}

						// �� �� - ���������� ������
						// ������� ������� ����
						$owner = check_users_city_data($item['rsowner']) or die();

						// ������� ������
						mysql_query('UPDATE `users` SET money = money - '.$price.' WHERE id = '.$user['id']) or die();

						// ����� � ���� ��� � ����� ����� ����� �� ������, �������� ������ � ��� ��������

					        //new_delo
						$rec = array();
	  		    			$rec['owner']=$user[id]; 
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user['money'];
						$rec['owner_balans_posle']=$user['money']-$price;
						$rec['target']=$rentalshopid;
						$rec['target_login']="�������� �����";
						$rec['type']=216; // �������� �� ��������� ������
						$rec['sum_kr']=$price;
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
						$rec['add_info'] = $days.'/'.$owner['login'].'/'.$owner['id'];
						$rec['item_incmagic_id']=$item['includemagic'];
						$rec['item_proto']=$item['prototype'];
						$rec['item_sowner']=($item['sowner']>0?1:0);
						$rec['item_mfinfo']=$item['mfinfo'];
						$rec['item_level']=$item['nlevel'];

						add_to_new_delo($rec); //�����


						$addrent = $days*60*60*24;

						// ���������� ����������� ���� ������
						mysql_query('UPDATE oldbk.`rentalshop` SET endtime = endtime + '.$addrent.' WHERE id = '.$id) or die();

						// ��������� letter
						mysql_query('UPDATE oldbk.`inventory` SET letter = "������ �������������: '.date("d/m/Y H:i",$item['rsendtime']+$addrent).'" WHERE id = '.$item['rsitemid']) or die();

						// ����� ������ � ���������
						$q = mysql_query('SELECT * FROM oldbk.`inventory` WHERE id = '.$item['rsitemid']) or die();
						$itemd = mysql_fetch_assoc($q) or die();
						$itemdescr = mysql_real_escape_string('"'.$itemd['name'].'" id:(cap'.$itemd['id'].') 1 ��. ['.$itemd['duration'].'/'.$itemd['maxdur'].'] [ups:'.$itemd['ups'].'/unik:'.$itemd['unik'].'/inc:'.$itemd['includemagicname'].']');

						$text = '�� �������� ������ �� '.$itemdescr.'.<br> ������ ������������� '.date("d/m/Y H:i",$item['rsendtime']+$addrent);
						mysql_query('
							INSERT INTO oldbk.`inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`,`gmp`, `includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`gmeshok`,`tradesale`)
							VALUES(
								"'.$user['id'].'",
								"������",
								"50",
								1,
								0,
								"paper100.gif",
								"'.$text.'",
								1,
								0,0,0,0,0,"",0,0,0
							)
						') or die();

						// ������ ��������� � �������������

						// ���������� ��� ����� �� ������� �����
						$toowner = round($price - ($price * $rsgotax / 100),2);
						if ($owner['id_city'] == 1) {
							mysql_query('UPDATE avalon.`users` SET money = money + '.$toowner.' WHERE id = '.$owner['id']) or die();
						} else {
							mysql_query('UPDATE oldbk.`users` SET money = money + '.$toowner.' WHERE id = '.$owner['id']) or die();
						}


						// ����� ��� � ����
					        //new_delo
						$rec = array();
	  		    			$rec['owner']=$owner[id]; 
						$rec['owner_login']=$owner[login];
						$rec['owner_balans_do']=$owner['money'];
						$rec['owner_balans_posle']=$owner['money']+$toowner;
						$rec['target']=$rentalshopid;
						$rec['target_login']="�������� �����";
						$rec['type']=217; // ������� �� �� ��������� ������
						$rec['sum_kr']=$toowner;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=round($price-$toowner,2);
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
						$rec['add_info'] = $days.'/'.$user['login'].'/'.$user['id'];
						$rec['item_incmagic_id']=$item['includemagic'];
						$rec['item_proto']=$item['prototype'];
						$rec['item_sowner']=($item['sowner']>0?1:0);
						$rec['item_mfinfo']=$item['mfinfo'];
						$rec['item_level']=$item['nlevel'];

						add_to_new_delo($rec); //�����

						// �������� �������
						telepost($owner['login'],'<font color=red>��������!</font> �� ���� ���� ���� �������� ������: "'.htmlspecialchars($item['name'],ENT_QUOTES).'" �� '.$days.' ��., ��� ����������� '.$toowner.' ��. �������� �������� ����� ���������: '.round($price-$toowner,2).' ��.');

						mysql_query('COMMIT') or die();
						Redirect('rentalshop.php?view=addrent&id='.$id.'&error=3');
					}

					mysql_query('COMMIT') or die();
					Redirect('rentalshop.php?view=addrent');
				}


			}
			$q = mysql_query('
					SELECT rs.id AS rsid, rs.itemid AS rsitemid, rs.owner AS rsowner, rs.endtime AS rsendtime, rs.maxendtime AS rsmaxendtime, rs.tempowner AS rstempowner, rs.price AS rsprice, inv.* FROM oldbk.`rentalshop` AS `rs`
					LEFT JOIN oldbk.`inventory` AS inv
					ON rs.itemid = inv.id
					WHERE inv.owner = '.$user['id'].' AND rs.maxendtime > '.time().' '.$addid.' AND rs.tempowner = '.$user['id']
			) or die();

			$center = '';
			if (isset($_GET['ok'])) {
				$center .= '<font color=red>�� ������ �������� ������.</font><br><br>';
			}

			$i = 0;
			if (mysql_num_rows($q) == 0 && !isset($_GET['ok'])) {
				$center .= '<font color=red>�� �� ����� � ������ �����.</font><br><br>';
			}

			if (isset($_GET['id'])) {
				if (isset($_GET['error'])) {
					switch($_GET['error']) {
						case 0:
							$error = '����������� ���� ��������� ������ 1 ����.';
						break;
						case 1:
							$error = '�� �� ������ �������� ������ �� ����� ����, ������������ ���� � ������ ������������� ������.';
						break;
						case 2:
							$error = '� ��� ������������ ����� ����� ��������� �� ��������� ������.';
						break;
						case 3:
							$error = '�� ������ �������� ������.';
						break;
					}
					$center .= '<font color=red>'.$error.'</font><br><br>';
			}

			}

			$center .= '
			<table class="table border a_strong" cellspacing="0" cellpadding="0" >
			<colgroup>
			<col width="300px">
			</colgroup>
			<tbody>
			<tr class="even2">
			<td class="center" style="vertical-align: middle;text-align:left;">
			<TABLE BORDER=0 CELLSPACING="0" CELLPADDING="0" class="table border">';

			// output buffering ��� ���� ����� ����������� ����� showitem()
			ob_start();
			while($item = mysql_fetch_assoc($q)) {
				$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
				if (isset($_GET['id'])) {
					$action = '<small>����&nbsp;������:&nbsp;<b>'.$item['rsprice'].'</b>&nbsp;��.&nbsp;�&nbsp;����</small><br> ������������&nbsp;������&nbsp;��: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsmaxendtime']).'</b><br><small>����&nbsp;������&nbsp;�������������:</small> <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsendtime']).'</b><br><br><form method="POST" name="cont">��������&nbsp;��:&nbsp;<input type="text" size=4 name="days" value="1">&nbsp;�����<br><a class="button-mid btn" href="javascript:void(0);" title="��������" onclick="document.cont.submit();">��������</a></form><br><br>';
				} else {
					$action = '<small>����&nbsp;������:&nbsp;<b>'.$item['rsprice'].'</b>&nbsp;��.&nbsp;�&nbsp;����</small><br> ������������ ������ ��: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsmaxendtime']).'</b><br><small>����&nbsp;������&nbsp;�������������:</small> <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsendtime']).'</b><br><br><a href="rentalshop.php?view=addrent&id='.$item['rsid'].'">��������</a>';
				}
				showitem($item,0,false,$color,$action);
				$center .= ob_get_contents();
				ob_clean ();
				$i++;
			}
			ob_end_clean();
			$center .= '</table></tr>
			</tbody>
			</table>
			</div>';
		break;
		case "returnitems":
			if (isset($_GET['id'])) {
				$id = intval($_GET['id']);
				mysql_query('START TRANSACTION') or die();
				$t = time();
				$q = mysql_query('SELECT * FROM oldbk.`rentalshop` WHERE itemid = '.$id.' AND tempowner = '.$user['id'].' AND endtime > '.$t.' AND maxendtime > '.$t.' FOR UPDATE') or die();
				if (mysql_num_rows($q) > 0) {
					// ����� ���� ������� ����� ������� ��������
					$item = mysql_fetch_assoc($q) or die();

					// �������� �������� ����
					$q = mysql_query('SELECT * FROM oldbk.`inventory` WHERE id = '.$item['itemid'].' AND prototype IN (272,5277,5278,121121122,121121123,121121124)') or die();
					$itemd = mysql_fetch_assoc($q) or die();

					// ������� ����� ��������
					$price = round(($item['endtime'] - time()) / (24*3600) * $item['price']);
					$q = mysql_query('UPDATE users SET money = money + '.$price.' WHERE id = '.$user['id']) or die();

					// �������� ��� ���� �� �����
					if ($itemd['dressed'] == 1) die();
					$itemdescr = mysql_real_escape_string('"'.$itemd['name'].'" id:('.get_item_fid($itemd).') 1 ��. ['.$itemd['duration'].'/'.$itemd['maxdur'].'] [ups:'.$itemd['ups'].'/unik:'.$itemd['unik'].'/inc:'.$itemd['includemagicname'].']');


					// ������� ������� ����
					$q = mysql_query('SELECT * FROM `users` WHERE id = '.$item['owner']) or die();
					$owner = mysql_fetch_assoc($q) or die();

					// ���������� ���� � �����
					mysql_query('UPDATE oldbk.`inventory` SET owner = '.$rentalshopid.', present = "", letter = "", dressed = 0 WHERE id = '.$item['itemid']);

					// �������� ����� � ���������� ���������
					mysql_query('UPDATE oldbk.`rentalshop` SET tempowner = 0, endtime = 0, maxendtime = 1 WHERE id = '.$item['id']);

					// ���������� �������� ������� ����
					telepost($owner['login'],'<font color=red>��������!</font> ���� ���� ���� ���������� � �������� �����: "'.htmlspecialchars($itemd['name'],ENT_QUOTES).' ['.$itemd['duration'].'/'.$itemd['maxdur'].']"');

					mysql_query('COMMIT') or die();
					Redirect('rentalshop.php?view=returnitems&ok');
				}
				mysql_query('COMMIT') or die();
				Redirect('rentalshop.php?view=returnitems');
			}

			$q = mysql_query('
					SELECT rs.id AS rsid, rs.itemid AS rsitemid, rs.owner AS rsowner, rs.endtime AS rsendtime, rs.maxendtime AS rsmaxendtime, rs.tempowner AS rstempowner, rs.price AS rsprice, inv.* FROM oldbk.`rentalshop` AS `rs`
					LEFT JOIN oldbk.`inventory` AS inv
					ON rs.itemid = inv.id
					WHERE inv.owner = '.$user['id'].' AND inv.dressed = 0 AND inv.prototype IN (272,5277,5278,121121122,121121123,121121124) AND rs.maxendtime > '.time().' AND rs.tempowner = '.$user['id']
			) or die();

			$center = '<center>';
			if (isset($_GET['ok'])) {
				$center .= '<font color=red>�� ������ ������� ���� � �������� �����.</font><br><br>';
			}

			$i = 0;
			if (mysql_num_rows($q) == 0 && !isset($_GET['ok'])) {
				$center .= '<font color=red>�� �� ����� � ������ �����, ������� �������� ��� ��������.</font><br><br>';
			}

			$center .= '<TABLE class="a_strong" BORDER=0 CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';

			// output buffering ��� ���� ����� ����������� ����� showitem()
			ob_start();
			while($item = mysql_fetch_assoc($q)) {
				$color = $i % 2 == 0 ? '#C7C7C7' : '#D5D5D5';
				$pricet = round(($item['rsendtime'] - time()) / (24*3600) * $item['rsprice']);
				$action = '����&nbsp;������:&nbsp;<b>'.$item['rsprice'].'</b>&nbsp;��.&nbsp;�&nbsp;����<br> ������������ ������ ��: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsmaxendtime']).'</b><br>����&nbsp;������&nbsp;�������������: <b>'.date("d/m/Y\&\\n\b\s\p\;H:i",$item['rsendtime']).'</b><br>����� �����������: '.$pricet.' <b>��.</b><br><br><a class="button-mid btn" href="#" OnClick="if (confirm(\'�� �������?\')) {location.href=\'rentalshop.php?view=returnitems&id='.$item['id'].'\';}; return false;">������� ����</a>';
				showitem($item,0,false,$color,$action);
				$center .= ob_get_contents();
				ob_clean ();
				$i++;
			}
			ob_end_clean();
			$center .= '</table></center>';
		break;
	}

	if ($tpl != '') {
		$foot  = str_replace('%FILTER%',$tpl,$foot);
	} else {
		$ar = get_itemfilt();			
		$foot  = str_replace('%FILTER%',$itemsfilter,$foot);			
	}
	
	$foot  = str_replace('%MONEY%',$user['money'],$foot);
	
	if ($pages == '') {
		$head = str_replace("%PAGES%",'',$head );
	}
	
	$head = str_replace('%'.$view.'%','class="active" ',$head);
	echo $head;
	make_quest_div('false');
	echo $center;
	if(isset($_SESSION['vk']) && is_array($_SESSION["vk"])) {
		echo str_replace("%MAILRU%","",$foot);
	} else {
		echo str_replace("%MAILRU%",$mailrucounter,$foot);
	}

	include "end_files.php";
?>