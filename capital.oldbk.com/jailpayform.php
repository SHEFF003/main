<?
	session_start();
	include "connect.php";	
	include "functions.php";	
	include "bank_functions.php";		

	$course_ekr_kr=10;	
	
	if ( (!($_SESSION[jail_kr]>0)) AND (!($_SESSION[jail_ekr]>0)))  { header("Location: ../jail.php?err=����������� ������"); 		die();}
	if ($user[room]!=600) { 	die('���� �� ��������');}
	
	
	$menu=(int)($_GET[id]);
	$param=(int)($_GET[param]);
	

$EKR_DOLG=0;
	
	if ($_SESSION[jail_kr]>0)
	{
	$EKR_DOLG+=round(($_SESSION[jail_kr]/$course_ekr_kr),2);
	}

	if ($_SESSION[jail_ekr]>0)
	{
	$EKR_DOLG+=$_SESSION[jail_ekr];
	}


?>



<table border=0 width=750 height=365 >
<tr><td  valign=top align="center"  colspan="2"><center><font style="COLOR:#8f0000;FONT-SIZE:12pt">
<?
 if ( (($menu>=11) AND  ($menu<=16) )  AND ($param==0) )
 	{
 	echo "<B>��������� �����:".($_SESSION[jail_kr]>0?'<span id="vik_kr">'.$_SESSION[jail_kr].'</span>�� ( '.$EKR_DOLG.' ���.) .':'').($_SESSION[jail_ekr]>0?'<span id="vik_ekr">'.$_SESSION[jail_ekr].'</span>���. ':'')."</B>";
 	}
 	else
 	{
 	die("������!");
 	}	
?>
</font></center></td>
<td  valign=top align="right"><a href=# onClick="closeinfo();" title="�������"><img src='http://i.oldbk.com/i/bank/bclose.png' style="position:relative;top:-20px;right:-20px;" border=0 title='�������'></a></td>
 </tr>
<tr>
<td width=25>&nbsp;</td>
<td width=900 height=250 valign="top" >

<?




 if ($menu==11)
	{
	
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
			echo '<p><b><font color="red">�������� � ������� QIWI: </font></b></p>';

			
			echo '<table>
					<tr>
						<td align="right"></td>
						<td>';
		
		
			echo '<form method="post" accept-charset="windows-1251"  onSubmit="return checkSubmit();">
			<input type="hidden" name="from" value="6920"/>
			<input type="hidden" name="lifetime" value="0.0"/>
			<input type="hidden" name="check_agt" value="false"/>
			<input type="hidden" name="com" value="��������� ����� � �������: '.$EKR_DOLG.' ���. ���������: '.$user['login'].'"/>';
    		
    		
    		
    		$RUR=get_rur_curs();
    		
		?>    	
		<table style="border-collapse:collapse;">
			<tr >
				<td style="width:55%; text-align:center; padding:20px 0px;">��������� �������: +7</td>
				<td style="padding:10px">
					<input type="text" name="to" id="idto" style="width:130px; border: 1px inset #555;"></input>
					<span id="div_idto"></span>
					
    			</td>
			</tr>

			<tr>
				<td style="padding:10px 0px; width:45%; text-align:right;">����� : </td>
				<td style="padding:10px"><input type="hidden" name="amount_rub" id="qrub" value="<? $RUR_DOLG=((int)($RUR*$EKR_DOLG)+1); echo $RUR_DOLG; ?>" maxlength="5"><b> <?=$RUR_DOLG;?> ���. </b>
					
				</td>
			</tr>
			<tr>
				<td style="padding:10px 0px; width:45%; text-align:right;"> <small>����:</small></td>
				<td style="padding:10px"><input type="hidden" name="amount_ekr" id="qekr" value="<?=$EKR_DOLG;?>" ><small><b><?=$RUR;?> ���.= 1���.</b></small> 
					
				</td>
			</tr>
			
		</table>
		<div align=center><input type="submit" name="qiwimkbill" value="��������� ���� �� ������" /></div>
	</form> 			
 			

						</td>
						<td align="right">
						</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>
			<?
	}
else	
if ($menu==12)
	{

			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
			 echo '<p><b><font color="red">�������� � ������� Webmoney WMZ: </font></b></p>' ; 
			 
			echo '
				<table border=0>
					<tr>	<td align="right"><br>�����:</td>
						<td><br><b>'.$EKR_DOLG.'WMZ</b></td>
					</tr>';
			echo '<tr>	<td align="right"><br><small>����:</small></td>
						<td><br><small><b> 1 WMZ= 1���. </b></small></td>
					</tr>';					

			echo '<tr>
				<td  colspan="2" align=center><br><br>';
 		echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp">';
 		echo '<input type="hidden" name="traderid" value="0:0:444:'.$user['id'].'">';
		echo '<input type=hidden name="LMI_PAYMENT_AMOUNT" value="'.$EKR_DOLG.'" >';
		echo '<input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC"  value="��������� ����� � �������: '.$EKR_DOLG.' ���. ���������: '.$user['login'].'"/>';
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
		echo '<div align=center><input type="submit" value="��������"></center><br><br></form>';
		
						
		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}
else
if (($menu==13) OR ($menu==14) OR ($menu==15)  )
		{
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
	if ($menu==13) { echo '<p><b><font color="red">�������� � ������� Webmoney WMR: </font></b></p>'; }
elseif ($menu==14) { echo '<p><b><font color="red">�������� � ������� ��������-���� "�����-����" : </font></b></p>';}
elseif ($menu==15) { echo '<p><b><font color="red">�������� � ������� ��������-���� "������� ��������" : </font></b></p>'; }
			
			$RUR=get_rur_curs();
			$RUR_DOLG=((int)($RUR*$EKR_DOLG)+1);
			
		echo '
				<table border=0>
					<tr>	<td align="right"><br>�����:</td>
						<td><br><b>'.$RUR_DOLG.'WMR</b></td>
					</tr>';
			echo '<tr>	<td align="right"><br><small>����:</small></td>
						<td><br><small><b> '.$RUR.' WMR= 1���. </b></small></td>
					</tr>';					

		echo '<tr>
				<td  colspan="2" align=center><br><br>';			
		
		if (($menu==14) OR ($menu==15)) {$add_bnk="?at=authtype_18";}
		
		echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp'.$add_bnk.'">';
		
		echo '<input type="hidden" name="traderid" value="0:0:444:'.$user['id'].'">';
		
		echo '&nbsp;&nbsp;�����: <input type=hidden name="LMI_PAYMENT_AMOUNT" value="'.$RUR_DOLG.'" size="8" id=wmrrub>';

		echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
		
		if ($menu==14) { echo '<input type="hidden" value="3" name="LMI_ALLOW_SDP">';}
		elseif ($menu==15) { echo '<input type="hidden" value="5" name="LMI_ALLOW_SDP">';}
		
		echo '<input type="hidden" name="LMI_PAYMENT_DESC"  value="��������� ����� � �������: '.$EKR_DOLG.' ���. ���������: '.$user['login'].'"/>';		

		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
		echo '<div align=center><input type="submit" value="��������"></center><br><br></form>';

		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

		}
else	
if ($menu==16)
	{

			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
			 echo '<p><b><font color="red">�������� ���� �� ������ � ������: </font></b></p>' ; 
			 
			echo '
				<table border=0>
					<tr>	<td align="right"><br>�����:</td>
						<td><br><b>'.$EKR_DOLG.' ���</b></td>
					</tr>';

			echo '<tr>
				<td  colspan="2" align=center><br><br>';
 		echo '<form method="post" >';
		echo '<input type=hidden name="mk_bill_cost" value="'.$EKR_DOLG.'" >';
		echo '<div align=center><input type="submit" value="�������� ���� �� ������"></center><br><br></form>';
						
		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}		
	
		
		
		
		 		
?>


</td>
<td width=25>&nbsp;</td>
</tr>
<tr><td align="center"  colspan="3">

</td></tr>

</table>




