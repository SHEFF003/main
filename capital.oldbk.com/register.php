<?php
session_start();
include "connect.php";
//$res = mysql_fetch_array(mysql_query("SELECT * FROM `invites` WHERE `whoreg` = 0 AND `unic` = '{$_GET['u']}'"));
//if ($res['id']==null && !$_GET['edit']) {
	//header("Location: index.php");
	//die();
//}

  if(!$_GET['edit'] || !$_SESSION[uid])
  {
  	die('�������� �� �������');
  }


	if($_SESSION[uid]==28453)
	{
		print_r($_POST);
		echo '<br>';
		print_r($_GET);
	}

	if ($_GET['edit'])
	{
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
		include "functions.php";
		if (!($_SESSION['uid'] >0)) header("Location: index.php");
	}
	if ($_POST['end'] != null) header("Location: main.php");

	if ($_POST['add'] && $_GET['edit']) {

		if ($_POST['name']==null) {
						$err .= "������� ���! ";
						$stop =1;
		}
		

		elseif ( ! ($_POST['ChatColor'] == "Black" || $_POST['ChatColor'] == "Blue" || $_POST['ChatColor'] == "#8700e4" ||  $_POST['ChatColor'] == "Fuchsia" || $_POST['ChatColor'] == "Gray" || $_POST['ChatColor'] == "Green" || $_POST['ChatColor'] == "Maroon" || $_POST['ChatColor'] == "Navy" || $_POST['ChatColor'] == "Olive" || $_POST['ChatColor'] == "Purple" || $_POST['ChatColor'] == "Teal" ||  $_POST['ChatColor'] == "Orange" ||  $_POST['ChatColor'] == "Chocolate" || $_POST['ChatColor'] == "DarkKhaki")) {
						$err .= "�������� ������������ ������ ����� ��������� � ���� ������ ! ";
						$_POST['ChatColor'] = "Black";
		}

		if($stop!=1) {

			setlocale(LC_ALL, 'ru_RU');
			$_POST['name'] = preg_replace('/[^a-z�-��-�\.\,\ ]/i', '', $_POST['name']);
			$_POST['city2'] = preg_replace('/[^a-z�-��-�\.\,\ \-]/i', '', $_POST['city2']);
			//$_POST['icq'] = preg_replace('/[^0-9]/i', '', $_POST['icq']);
			//$_POST['homepage'] = preg_replace('/[^a-z\d\:\/\.\-\~\#\%\?\&]/i', '', $_POST['homepage']);
			$_POST['about'] = preg_replace('/[^a-z�-��-�\.\,\!\-\~\s\d]/i', '', $_POST['about']);
			$_POST['hobby'] = preg_replace('/[^a-z�-��-�\.\,\!\-\~\s\d\#\%\?\&\:\/\=\(\)\+\@\_]/i', '', $_POST['hobby']);


			mysql_query("UPDATE `users` SET   `city` = '".($_POST['city2'])."',  `info` = '".($_POST['hobby'])."',  `lozung` = '".($_POST['about'])."',  `color` = '".($_POST['ChatColor'])."',  `realname` = '".($_POST['name'])."' WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;");
			$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
		}
	}

				?>
	<HTML><HEAD><TITLE>����� - ������ ���������� ����</TITLE>
	<META content="text/html; charset=windows-1251" http-equiv=Content-type>
	<link rel=stylesheet type="text/css" href="i/main.css">
    <link rel="stylesheet" href="/i/btn.css" type="text/css">
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>

	</HEAD>
	<BODY aLink=#000000 bgColor=#666666 leftMargin=0 link=#000000 topMargin=0
	vLink=#333333 marginheight="0" marginwidth="0">

<?php
	if($_GET['vk'] == "true") {
	        echo'
	   <script src="http://vkontakte.ru/js/api/xd_connection.js?2" type="text/javascript"></script>
	   <script>VK.init(function() {
	     VK.callMethod("resizeWindow", 800, 1250);
	   });
	   </script>';
	}
?>

<TABLE border=0 cellPadding=0 cellSpacing=0 height="100%" width="100%">
  <TBODY>
  <TR>
    <TD vAlign=top width="15%">
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD height=36 width="100%"></TD></TR>
        <TR>
          <TD bgColor=#000000 height=83 width="100%"></TD></TR></TBODY></TABLE></TD>
    <TD vAlign=top width="70%">
      <DIV align=center><IMG border=0 height=21
      src="i/deviz.gif" width=459></DIV>
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD height=15 width="50%"></TD>
          <TD height=15 width=269><IMG border=0 height=15
            src="i/top.gif" width=269></TD>
          <TD height=15 width="50%"></TD></TR>
        <TR>
          <TD bgColor=#000000 height=83 width="50%"></TD>
          <TD bgColor=#000000 height=83 width=269><A
            href="index.php"><IMG border=0 height=83
            src="i/logo2.jpg" width=269></A></TD>
          <TD bgColor=#000000 height=83 width="50%"></TD></TR>
        <TR>
          <TD bgColor=#f2e5b1 height=24 width="50%"></TD>
          <TD height=24 width=269><IMG border=0 height=24
            src="i/bottom.gif" width=269></TD>
          <TD bgColor=#f2e5b1 height=24 width="50%"></TD></TR></TBODY></TABLE>
      <TABLE bgColor=#f2e5b1 border=0 cellPadding=0 cellSpacing=0
        width="100%"><TBODY>
        <TR>
          <TD colSpan=3 width="100%"><BR></TD></TR>
        <TR>
          <TD colSpan=2 width="85%">&nbsp; &nbsp;&nbsp; &nbsp;<IMG border=0
            height=53 src="i/title_anketa.gif"
width=373></TD>
          <TD rowSpan=2 vAlign=top width="15%"><BR><BR>
            <DIV align=right>
            <TABLE border=0 cellPadding=0 cellSpacing=0 height="100%">
              <TBODY>
              <TR>
                </TR></TBODY></TABLE></DIV></TD></TR>
        <TR>
          <TD vAlign=top width="10%"><IMG border=0 height=243
            src="i/pict_anketa.jpg" width=126></TD>
          <TD vAlign=top width="75%"><FONT color=red><B></B></FONT>
            <BR><!-- Begin of text -->
            <TABLE border=0 cellPadding=2 cellSpacing=0 name="F1">
              <FORM action="register.php?u=<?=$_GET['u']?>&b=<?php echo $_REQUEST['b']."&pid=".$_REQUEST['pid']."&ref=".$_REQUEST['ref']?><?=($_GET['edit'])?"&edit=1":""?>" method=post>
              <TBODY>
              <TR>
                <TD colSpan=2><FONT color=red><B><?=$err?><!--error--></FONT></B></TD></TR>

              <TR>
                <TD vAlign=top><FONT color=red></FONT></TD>
                <TD><BR>���� �������� ���: <INPUT maxLength=90 name=name
                size=50 value="<?=($_GET['edit'])?"{$user['realname']}":"{$_POST['name']}"?>"></TD></TR>

              <TR>
                <TD>&nbsp;</TD>
                <TD><BR>�����: <SELECT name=city id=city OnChange="document.getElementById('city2').value=document.getElementById('city').value;"> <OPTION
                    selected><OPTION>������<OPTION>�����-���������<OPTION>������
                    (�������)<OPTION>����<OPTION>����� (����������
                    ���.)<OPTION>������<OPTION>�����������<OPTION>������<OPTION>�������<OPTION>�����<OPTION>�������
                    (���������
                    ���.)<OPTION>�������<OPTION>�������<OPTION>�����������<OPTION>������<OPTION>���������<OPTION>��������<OPTION>�������<OPTION>��������<OPTION>���������
                    (�������)<OPTION>��������� (��������
                    ���.)<OPTION>�����<OPTION>����������<OPTION>������������<OPTION>�������
                    ������<OPTION>������������<OPTION>������<OPTION>��������<OPTION>������<OPTION>������<OPTION>�������
                    ����<OPTION>������� �����<OPTION>�������
                    �����<OPTION>�����������<OPTION>�����������<OPTION>��������<OPTION>���������<OPTION>����������<OPTION>������<OPTION>�������<OPTION>������
                    (�.������
                    ���.)<OPTION>�������<OPTION>�����������<OPTION>��������<OPTION>������<OPTION>������
                    (���������� ���.)<OPTION>�������
                    ������<OPTION>��������-��<OPTION>���������<OPTION>����������<OPTION>��������
                    (����������
                    ���.)<OPTION>������<OPTION>����-�����������<OPTION>���������
                    (��������
                    ���.)<OPTION>������������<OPTION>������������<OPTION>�����<OPTION>�������
                    (���������
                    ��)<OPTION>����<OPTION>������������<OPTION>�������
                    (���������)<OPTION>���� (��������
                    ���.)<OPTION>�������<OPTION>������������<OPTION>�����
                    (���������
                    ���.)<OPTION>���������<OPTION>��������<OPTION>����������<OPTION>�����������<OPTION>����������<OPTION>������������<OPTION>��������<OPTION>�������<OPTION>����������
                    (������
                    ���.)<OPTION>������<OPTION>�������<OPTION>����<OPTION>������-���<OPTION>������<OPTION>�����������<OPTION>������<OPTION>�������-���������<OPTION>�������<OPTION>��������<OPTION>�������
                    (���������� ���.)<OPTION>������ ( �.������
                    ���.)<OPTION>�����<OPTION>������-������<OPTION>����������<OPTION>������<OPTION>�������<OPTION>�������<OPTION>�����������-��-�����<OPTION>�������<OPTION>����������<OPTION>��������<OPTION>�����������<OPTION>���������<OPTION>����������<OPTION>���������<OPTION>���������<OPTION>��������
                    (������������)<OPTION>������<OPTION>�����<OPTION>��������<OPTION>�����<OPTION>������<OPTION>���������
                    (����������
                    ���.)<OPTION>�������<OPTION>�������<OPTION>������������<OPTION>������<OPTION>�������������<OPTION>���������<OPTION>�������������<OPTION>������������
                    (������
                    ���.)<OPTION>�����������<OPTION>�����<OPTION>���������
                    (���������� ���.)<OPTION>����������� ����<OPTION>���������
                    (����������
                    ���.)<OPTION>��������<OPTION>�����<OPTION>������<OPTION>����������
                    �����<OPTION>�����<OPTION>�������<OPTION>�������<OPTION>������������<OPTION>����������<OPTION>�����������<OPTION>������������<OPTION>����������<OPTION>������
                    ��������<OPTION>������
                    �����<OPTION>����������-��-�����<OPTION>����������<OPTION>��������<OPTION>�����������<OPTION>������������<OPTION>������������<OPTION>�����������<OPTION>�����������<OPTION>������������<OPTION>�����
                    �������<OPTION>��������<OPTION>��������<OPTION>������<OPTION>�������<OPTION>��������<OPTION>����<OPTION>�����<OPTION>����<OPTION>��������<OPTION>����<OPTION>�����<OPTION>������������<OPTION>����������-���������<OPTION>�����<OPTION>������������<OPTION>�������������-����.<OPTION>�������
                    (����������
                    ����)<OPTION>��������<OPTION>���������<OPTION>��������
                    ����<OPTION>��������<OPTION>�����<OPTION>������<OPTION>���������<OPTION>��������
                    (���������
                    ���.)<OPTION>�����<OPTION>����<OPTION>������-��-����<OPTION>������-�����������<OPTION>��������<OPTION>������<OPTION>��������<OPTION>������<OPTION>�������<OPTION>�������<OPTION>�����<OPTION>������<OPTION>�����
                    (��������� ���.)<OPTION>������������<OPTION>������� (�������
                    ���.)<OPTION>������<OPTION>�������������<OPTION>�������
                    �����<OPTION>�����<OPTION>��������<OPTION>����������
                    (�.������
                    ���.)<OPTION>��������<OPTION>��������<OPTION>���������
                    ������<OPTION>��������� (���������
                    ���.)<OPTION>�������������<OPTION>��������
                    ���<OPTION>�������� ��� (�.������
                    ���.)<OPTION>����<OPTION>����������<OPTION>������
                    �����<OPTION>������ �����<OPTION>�����������
                    (������������)<OPTION>��������� (�������
                    ���.)<OPTION>��������<OPTION>������<OPTION>�������<OPTION>���������<OPTION>��������<OPTION>������<OPTION>������<OPTION>�����<OPTION>��������<OPTION>�����<OPTION>����������<OPTION>������<OPTION>������<OPTION>����<OPTION>������<OPTION>������
                    (��������
                    ���.)<OPTION>����-���<OPTION>���������<OPTION>���������<OPTION>����-�������
                    (���������
                    ����)<OPTION>���<OPTION>����<OPTION>�������<OPTION>���������<OPTION>�����-��������<OPTION>�����<OPTION>������<OPTION>���������<OPTION>���������<OPTION>���������<OPTION>���������<OPTION>��������<OPTION>������������<OPTION>��������
                    (�������� ���.)<OPTION>���������� (���������
                    ���.)<OPTION>����<OPTION>�������� (����������
                    ���.)<OPTION>������<OPTION>�����<OPTION>������� (����������
                    ���.)<OPTION>������������<OPTION>������<OPTION>�������<OPTION>����-���������<OPTION>�����������<OPTION>����<OPTION>������<OPTION>���������<OPTION>�����������<OPTION>�������<OPTION>��������<OPTION>������<OPTION>���������<OPTION>����������<OPTION>������<OPTION>�����<OPTION>�����������<OPTION>������������<OPTION>����������<OPTION>�������<OPTION>�������<OPTION>��������/Germany<OPTION>�������/Israel<OPTION>������/Canada<OPTION>���/USA</OPTION></SELECT>
                  ������ <INPUT maxLength=40 name=city2 id=city2 value="<?=($_GET['edit'])?"{$user['city']}":"{$_POST['city2']}"?>"></TD></TR>

              
              <TR>
	
		<?
	          /*    <TR>
                <TD>&nbsp;</TD>
                <TD><BR>E-mail: <INPUT maxLength=60 name=email value="<?=($_GET['edit'])?"{$user['email']}":"{$_POST['email']}"?>"
                  size=35></TD></TR>
                 */
                  ?>
              <TR>
                <TD>&nbsp;</TD>
                <TD><BR>��������� / ����� <SMALL>(�� ����� 60 ����)</SMALL><BR><TEXTAREA style="width: 414px; height: 135px;" cols=60 name=hobby rows=7 ><?=($_GET['edit'])?"{$user['info']}":"{$_POST['nobby']}"?></TEXTAREA></TD></TR>
              <TR>
                <TD>&nbsp;</TD>
                <TD><BR>�����: <INPUT maxLength=160 name=about size=70 value="<?=($_GET['edit'])?"{$user['lozung']}":"{$_POST['about']}"?>"></TD></TR>
              <TR>
                <TD>&nbsp;</TD>
                <TD><BR>���� ��������� � ����: <SELECT name=ChatColor> <OPTION
                    selected style="BACKGROUND: #f2f0f0; COLOR: black"
                    value=Black>������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: blue"
                    value=Blue>�����<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: fuchsia"
                    value=Fuchsia>�������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: gray"
                    value=Gray>�����<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: green"
                    value=Green>�������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: maroon"
                    value=Maroon>������������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: navy"
                    value=Navy>����������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: olive"
                    value=Olive>���������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: purple"
                    value=Purple>����������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: teal"
					value=Teal>������� �����<OPTION
					style="BACKGROUND: #f2f0f0; COLOR: orange"
                    value=Orange>���������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: chocolate"
                    value=Chocolate>����������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: darkkhaki"
                    value=DarkKhaki>������ ����<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: sandybrown"
                    value=SandyBrown>�������������<OPTION
                    style="BACKGROUND: #f2f0f0; COLOR: #8700e4"
                    value="#8700e4">���������</OPTION></SELECT>


					<?
//					echo "<input type='hidden' name='b' value='".$_REQUEST['b']."'>

//					<input type='hidden' name='pid' value='".$_REQUEST['pid']."'>";

					if($_GET['edit']) {
						echo '<script>document.all[\'ChatColor\'].value = \'',$user['color'],'\';</script>';
					}
					?></TD></TR>

              <TR>

                <TD align=middle colSpan=2><br>
				<? if($_GET['edit']) {
				echo "<div class=\"btn-control\"><INPUT class='button-mid btn' name=add type=submit value=���������></div>";
				} else {
				echo "<INPUT name=add type=submit value=����������������>";
				}
				?>
				<BR><BR><!--return--><center><BR>����� - ������ ���������� ���� - OldBK &copy; 2010�<?=date("Y");?> ����������� ���� ����ʻ<BR><BR><BR></center>
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
d.write('<a href="http://top.mail.ru/jump?from=1765367" target="_blank">'+
'<img src="http://df.ce.ba.a1.top.mail.ru/counter?id=1765367;t=49;js='+js+
a+';rand='+Math.random()+'" alt="�������@Mail.ru" border="0" '+
'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_blank" href="http://top.mail.ru/jump?from=1765367">
<img src="http://df.ce.ba.a1.top.mail.ru/counter?js=na;id=1765367;t=49"
height="31" width="88" border="0" alt="�������@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script>
<!--// Rating@Mail.ru counter--></div>
			<!--Google Analytics counter-->
			<script type="text/javascript">
			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-17715832-1']);
			  
var rsrc = /mgd_src=(\d+)/ig.exec(document.URL);
    if(rsrc != null) {
        _gaq.push(['_setCustomVar', 1, 'mgd_src', rsrc[1], 2]);
    }
			  
			  _gaq.push(['_trackPageview']);

			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();

			</script>
			<!--Google Analytics counter-->
            <!-- Yandex.Metrika -->
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript"></script>
<div style="display:none;"><script type="text/javascript">
try { var yaCounter1256934 = new Ya.Metrika(1256934); } catch(e){}
</script></div>
<noscript><div style="position:absolute"><img src="//mc.yandex.ru/watch/1256934" alt="" /></div></noscript>
<!-- /Yandex.Metrika -->

            </TD></FORM></TR></TBODY></TABLE><!-- End of text --><BR><BR></TD><!--td width=15% valign=top><img src="encicl/images/new_ico.gif" width=86 height=89 border=0></td--></TR>
        <TR>
          <TD bgColor=#000000 colSpan=3 height=10
      width="100%"></TD></TR></TBODY></TABLE><BR><BR><BR></TD>
    <TD vAlign=top width="15%">
      <TABLE border=0 cellPadding=0 cellSpacing=0 width="100%">
        <TBODY>
        <TR>
          <TD height=36 width="100%"></TD></TR>
        <TR>
          <TD bgColor=#000000 height=83
  width="100%"></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></BODY></HTML>
