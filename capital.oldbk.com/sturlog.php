	<?php
	session_start();
	//if ($_SESSION['uid'] == null) header("Location: index.php");
	include "connect.php";	
	include "functions.php";
	
	if (($user[klan]=='radminion') OR ($user[klan]=='pal') OR ($user[klan]=='Adminion') )
				{

					if  ( ($_GET['delname']) AND ($trd['nazva']!='�������') )
						{
						$trrid=(int)$_GET['delname'];
						mysql_query("UPDATE `ntur_users` SET `nazva`='�������' WHERE `id`={$trrid} ;");
						if (mysql_affected_rows() >0)
							{
							err('�������� �������!');
							}
						}
						elseif ( ($_GET['delkom']) AND ($trd['koment']!='�������') )
						{
						$trrid=(int)$_GET['delkom'];		
						mysql_query("UPDATE `ntur_users` SET `koment`='�������' WHERE `id`={$trrid} ;");
						if (mysql_affected_rows() >0)
							{
							err('�������� �������!');
							}						
						}
						else
						{
							$trrid=(int)$_GET['id'];
						}

				}
				else
				{
							$trrid=(int)$_GET['id'];
				}
		
	$tr = mysql_fetch_array(mysql_query("SELECT * FROM `stur_logs` WHERE `id` = '".$trrid."'"));
	?>
<HTML>
	<HEAD>
		<link rel=stylesheet type="text/css" href="i/main.css">
		<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
		<META Http-Equiv=Cache-Control Content=no-cache>
		<meta http-equiv=PRAGMA content=NO-CACHE>
		<META Http-Equiv=Expires Content=0>
		<script type="text/javascript" src="/i/globaljs.js"></script>
	</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>
<?
		if ($tr['id'] > 0)
		{
		
		  $nazv[304]='(��������)';
		  $nazv[308]='(�����)';
		  
		$type=$nazv[$tr[type]];
		$winer=$tr[winer];
		
		echo "<H3>����� � �������: �6 ��� ����ʻ</H3>";
		
		if ($trd['nazva']!='')
		{
		echo "�������� �������:<b>{$trd['nazva']}</b>";
				if (($user[klan]=='radminion') OR ($user[klan]=='pal') OR ($user[klan]=='Adminion') )
				{
				if ($trd['nazva']!='�������') { echo " <a href=?delname={$trd['id']}><img src='http://i.oldbk.com/i/clear.gif' alt='������� ��������' title='������� ��������'></a> "; }
				}
		echo "<br>";
		}
		
		if ($trd['koment']!='') 
		{
		echo "�����������: <b>{$trd['koment']}</b> ";

 				if (($user[klan]=='radminion') OR ($user[klan]=='pal') OR ($user[klan]=='Adminion') )
				{
				if ($trd['koment']!='�������') { echo " <a href=?delkom={$trd['id']}><img src='http://i.oldbk.com/i/clear.gif' alt='������� �����������' title='������� �����������'></a> ";	}
				}
		echo "<br>";
		}


		
		
		$log_txt=str_replace("<BR>","<BR><HR>",$tr[logs]);
		$log_txt=str_replace("����������","���������",$log_txt);
		echo $log_txt; 
		echo "<br>\n";
		}
		else
		{
		echo "<font color=red><b>������ �� ������!</b></font>";		
		}
?>			
		
</BODY>
</HTML>
