<?
//���������
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
	session_start();
	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die();}
	include "connect.php";
	include "functions.php";	
	$minimalka=50; // ����������� ����� ������
		
	$wmz=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_money`  WHERE `owner` = '{$user['id']}' LIMIT 1;"));
	if ($wmz['owner']>0)
	{
	$msg='��� WMZ-�������:'.$wmz['wmz'];
	}
	else
	{
		//�������� �����
		$get_scan=mysql_fetch_array(mysql_query("select * from oldbk.users_scans  WHERE `owner` = '{$user['id']}' and status=1 LIMIT 1;"));
		
		if ($get_scan['id']>0)
		{
		
			if (($_POST['savewmz']) AND ($_POST['mywmz']))
			{
			$twm=explode("Z",$_POST['mywmz']);
			$twmn=intval($twm[1]);
			if ((strlen($twmn)==12) AND ($_POST['mywmz'][0]=='Z') )
				{
			 	$mywmz='Z'.$twmn;
				mysql_query("INSERT INTO `oldbk`.`users_money` SET `owner`='{$user[id]}',`wmz`='{$mywmz}';");
					if (mysql_affected_rows()>0)
					{
					$msg='��� WMZ-�������:'.$mywmz.' ������ ��������!';
					}
				}
				else
				{
				$msg='������ ����� WMZ-��������, ������������ ������!<br>�������� � ��� �� ���������� WMZ-�������!';				
				$stop=1;
				}
			}
			else
			{
			$msg='�������� � ��� �� ���������� WMZ-�������!';
			$stop=1;
			}
		}
		else
		{
		$msg='�������� � ��� �� ���������� WMZ-�������! ��� ��������� �������� ��������� �������������� ���� ���������, �������������� ���� ��������!';
		$stop=2;
		}
	}
	
	
?>
<html>
<head>
<script type="text/javascript" src="/i/globaljs.js"></script>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<style>
	legend {
		padding: 0.2em 0.5em;
		color:#003388;
		FONT-WEIGHT: bold;
	}

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
		
	</style>
	
</head>
<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0>
			<div id="pl" style="z-index: 300; position: absolute; left: 155px; top: 120px;
				width: 750px; height:365px; background-color: #eeeeee; 
				border: 1px solid black; display: none;">
	
			</div>
<?
	if ($user[klan]=='radminion') {  echo "Admin-info:<!- GZipper_Stats -> <br>";  }	
?>
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
<center>
<table border=0 width="100%" >
<tr>
	<td width="10%"> &nbsp;</td>
	<td width="80%" align=center><h3>�������</h3>
		<table  border=0 width="100%" >
			<tr>
				<td width="50%" align=center><a href="?page=1">�������</a></td>
				<td width="50%" align=center><a href="?page=2">�������</a></td>				
			</tr>
			
			<tr>
				<td colspan=2 align=center>
			<?
				if ($_GET[page]==2)
				{
					if ($stop>0)
					{
					//��� �������� )
						echo "<b>".$msg."</b>";
							if ($stop==2)
							{
							$ii=0;
							$get_scan2=mysql_query("select * from oldbk.users_scans  WHERE `owner` = '{$user['id']}' ;");
							while($d = mysql_fetch_assoc($get_scan2)) 
							{
							$ii++;
							$f = explode('_',$d['filename']);
							$st = "";
							if ($d['status'] == 0) $st = "� ���������";
							if ($d['status'] == 1) $st = "����������";
							if ($d['status'] == 2) $st = "�������";							
							
								$inf_scan=" C��� ��������� ��:<b>".date("d/m/Y H:i:s",$f[1])."</b> ������: <b>".$st."</b>.<br>";
							}
							 if ($inf_scan) echo "<br>".$inf_scan;
							echo "<br><FORM METHOD=POST ACTION=\"main.php?edit=1\" name=f1><INPUT TYPE=\"submit\" name=\"changepsw\" value=\"������� �� �������� �������� ����������\" title=\"������� �� �������� �������� ����������\" style=\"FONT-WEIGHT: bold;\"></FORM>";
							}
							else
							{
							echo "<br>";
							echo "<div align=left>��� ������ ������� ���������� ������� ��� WMZ - �������. <br>
								&nbsp;&nbsp;&nbsp;<u>������� ����������:</u><br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. ������� �� <b>������ ��������� ����������� ���� ���</b>. �������� ��� ����� ������ ����� <a href='http://oldbk.com/commerce/index.php?' target=_blank>������������ ����� </a>, � ��������� ������ ������� ����� ������ WMZ-��������.<br>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. ����  �������� ���� ����� �������� <b>��� ���������� � ���� ������ ��� ������</b>. � ����� ������ ���� ����� ������ ���� ������� ���� ���������� ����� ����� �������� ������ <a href='http://oldbk.com/commerce/index.php?' target=_blank>������������� ������ </a> � ������������.</div>";
							echo "<FORM METHOD=POST>";	
							echo "������� ��� WMZ-������� <small>(� �������: Z123456789101)</small>:<input type=text size=16 MAXLENGTH=13 name=mywmz><input type=submit name=savewmz value='���������'>";
							echo "</FORM>";
								
							}
					}
					else
					{
					//���� ������
						echo "<b>".$msg."</b>";	
						
						
						$get_dollars=mysql_query("select * from oldbk.inventory where owner='{$user['id']}' and prototype in (5005,5010,5015,5020,5025) and setsale=0 ");
						if (mysql_num_rows($get_dollars)>0)
						{
						
							if ($_POST['mkout'])
							{
							
							
							}
							else
							{
								echo "<h3> ��������� �������� � ������:</h3>";
								$ff=0;
								$dsum=0;
								echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
								echo "<tr><td  width=450 > </td><td > </td></tr>";
								   while($row = mysql_fetch_array($get_dollars)) 
								   {
								   if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								   showitem($row,0,false,$color, "&nbsp;"); 
								   $dsum+=$row[ecost];
								   }
								 echo '</TABLE>';  
								echo "<br><b>����� �� �����:<font color=red>{$dsum}$</font>.";
							 if ($dsum>=$minimalka)	   
							 	{
							 	//�������� ������� ������ �� �����
							 	echo  "<br><br><form method=post>";
							 	echo  "<input type=submit name=mkout value='������ ������ �� �����'>";
							 	echo "</form>";
							 	}
							 	else
							 	{
							 	//�������� �� �����
							 	echo "����������� ����� ��� ����� �������� ������� <font color=red>{$minimalka}$</font> </b>";
							 	}
						   }
								   
						}
						else
						{
						echo "<h4>� ��� ���� ��� ��������� ������� � ������.</h4>";
						}
					}
				
				}
				else
				{
				
				}
			?>
				</td>
			</tr>
			
			
		</table>
	</td>
	<td width="10%" align=center valign=top><FORM ACTION="mypocket.php" METHOD=POST><INPUT TYPE=submit value="��������" >&nbsp;<INPUT TYPE=button value="���������" onClick="location.href='main.php?edit=0.467837356797105';"></FORM></td>
			
</tr>	
</table>
</center>
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
