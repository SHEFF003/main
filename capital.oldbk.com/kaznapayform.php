<?
	session_start();
	include "connect.php";	
	include "functions.php";	
	include "bank_functions.php";		

	
	if ($user[klan]=='') { 	die('���� �� ��������');}
	
	
	$menu=(int)($_GET[id]);
	$param=(int)($_GET[param]);
	$bonekr=get_ekr_addbonus();	

?>



<table border=0 width=750 height=330 >
<tr><td  valign=top align="center"  colspan="2"><center><font style="COLOR:#8f0000;FONT-SIZE:12pt">
<?
 if (( (($menu>=40) AND  ($menu<=54) ) OR ($menu==2) OR ($menu==4) OR ($menu==5) OR ($menu==6) OR ($menu==7) OR ($menu==8) OR ($menu==10) OR ($menu==11) OR ($menu==23) OR ($menu==20) )   AND ($param==0) )
 	{
 	echo "<B>���������� �������� �����:</B>";
 	}
else  if ( (($menu>=131) AND  ($menu<=132) )  AND ($param==0) )
	{
 	echo "<B>�������� �����:</B>";
	} 	
else  if ( (($menu>=141) AND  ($menu<=142) )  AND ($param==0) )
	{
 	echo "<B>������������:</B>";
	}	
else  if ( (($menu>=151) AND  ($menu<=152) )  AND ($param==0) )
	{
 	echo "<B>������� �����:</B>";
	}	
/*else  if ( (($menu>=61) AND  ($menu<=63) )  AND ($param==0) )
	{
 	echo "<B>���������� � ��� �����:</B>";
	}*/	
else  if ( ($menu=171)  AND ($param==0) )
	{
 	echo "<B>������ �� ����� ��������:</B>";
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


if ($menu==2)
{
//��� ���
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			$usd_kurs=get_ekr_usd();
			$STRNAME="WMZ";
			
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ;
		
			echo '
				<table>
					<tr>
						<td align="center">';				
				echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank>';				
				echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':666:'.$user['id'].'">';		
				echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="0" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> WMZ 
				<input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
				echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';				
				echo '<br><small><b> 1  ���. = '.$usd_kurs.'WMZ </b></small><br><br><br>';
				echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br><br>';
				echo '� �����: <input type=text id=ekwmz size="8" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';						
				echo '<br><br><br><input type="submit" value="��������" onClick="closeinfo();" ><br></form>';


				echo '</td>
							</tr>
						</table>
				</td>
				</tr></table>
				</center>';

}
elseif ($menu==4 OR ($menu==5) OR ($menu==6) OR ($menu==7) OR ($menu==8) OR ($menu==10) OR ($menu==11) )
{
//��� ���
		$LMI_SDP_TYPE[5]=3; // ��������-���� "�����-����"
		$LMI_SDP_TYPE[6]=5; // ��������-���� "������� ��������"
		$LMI_SDP_TYPE[10]=6; // ��������-���� "���24"
		$LMI_SDP_TYPE[7]=9; //��������-���� "�������������"
	   	$LMI_SDP_TYPE[8]=14; // ��������-���� "�������� ������"		
	   	$LMI_SDP_TYPE[11]=11; // ����� ��

	   	$LMI_SDP_TYPE[12]=20; //  �����
	   	//authtype_16
	   	
	   	$online_bank='';

	   	if ($LMI_SDP_TYPE[$menu]>0) { $online_bank="?at=authtype_18"; }

	   	if ($LMI_SDP_TYPE[$menu]==14) { $online_bank="?at=authtype_21"; }
	   	if ($LMI_SDP_TYPE[$menu]==11) { $online_bank="?at=authtype_11"; }	   	
	   	if ($LMI_SDP_TYPE[$menu]==16) { $online_bank="?at=authtype_16"; }	   		   	
	   	if ($LMI_SDP_TYPE[$menu]==20) { $online_bank="?at=authtype_20"; }
	   	
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
			$RUR=get_rur_curs();
			$STRNAME="WMR";
			
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ;
		
			echo '
				<table>
					<tr>
						<td align="center">';				
				echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp'.$online_bank.'" target= _blank>';				
				echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':666:'.$user['id'].'">';		
				echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="0" size="8" id=wmrrub onChange=\'javascript: callcekrwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcekrwmr(this.value,'.$RUR.');"> WMR ';
				echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
				echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
				echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br><br>
				<small><b> 1  ���. = '.$RUR.' WMR </b></small><br><br>
				� �����: <input type=text id=wmrekr size="8" onChange=\'javascript: callcrubwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcrubwmr(this.value,'.$RUR.');"> ���. ';
				echo '<br><br><br>';
				
				if ($LMI_SDP_TYPE[$menu]==3 || $LMI_SDP_TYPE[$menu]==5 || $LMI_SDP_TYPE[$menu]==6 || $LMI_SDP_TYPE[$menu]==9) {
			   	 echo '<input type="hidden" name="LMI_SDP_TYPE" value="'.$LMI_SDP_TYPE[$menu].'">'; 
		 	   	 echo '<input type="hidden" name="LMI_ALLOW_SDP" value="'.$LMI_SDP_TYPE[$menu].'">'; 
			   	 }
				
				echo '<input type="submit" value="��������" onClick="closeinfo();" ><br></form>';


				echo '</td>
							</tr>
						</table>
				</td>
				</tr></table>
				</center>';

}
elseif ($menu==23)
{
//��� ������

			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			$usd_kurs=get_ekr_usd();
			$usd_kurs+=0.05;		
			$STRNAME="PayPal";
			
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ;
		
			echo '
				<table>
					<tr>
						<td align="center">';				
				echo '<form method="post" action="bank.php"  target=_blank>';
		 		echo '<input type="hidden" name="paypal_type" value="666">'; // ��� 1 ���������� �����
		 		echo '<input type="hidden" name="paypal_param" value="666">'; // ������������
				
				echo '&nbsp;&nbsp;�����: <input name="paypal_amount" value="0" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> USD ';
				echo '<br><small><b> 1  ���. = '.$usd_kurs.'USD </b></small><br><br><br>';
				echo '� �����: <input type=text id=ekwmz size="8" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';		

				echo '<br><br><br><input type="submit" value="��������" onClick="closeinfo();" ><br></form>';


				echo '</td>
							</tr>
						</table>
				</td>
				</tr></table>
				</center>';

}
elseif ($menu==20)
{
//��� ������

			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			$usd_kurs=get_ekr_usd();
			
			$STRNAME="Liqpay";
			
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ;
		
			echo '
				<table>
					<tr>
						<td align="center">';				
				echo '<form method="post" action="bank.php"  target=_blank>';
		 		echo '<input type="hidden" name="liqpay_type" value="666">'; // ��� 1 ���������� �����
		 		echo '<input type="hidden" name="liqpay_param" value="666">'; // ������������
				
				echo '&nbsp;&nbsp;�����: <input name="liqpay_amount" value="0" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> USD ';
				echo '<br><small><b> 1  ���. = '.$usd_kurs.'USD </b></small><br><br><br>';
				echo '� �����: <input type=text id=ekwmz size="8" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';		

				echo '<br><br><br><input type="submit" value="��������" onClick="closeinfo();" ><br></form>';


				echo '</td>
							</tr>
						</table>
				</td>
				</tr></table>
				</center>';

}
else
if (($menu>=40) and ($menu<=48))
	{
			$usd_kurs=get_ekr_usd();
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
			
				$STRNAME='OKPAY ';
				$CTYPE='USD';
				$RUR=get_rur_curs();				

				if ($menu==41) {
									$STRNAME='���';	// 	Mts 	MTS 	 ���
		 							$CTYPE='RUB'; 
 							}
				elseif ($menu==42)	{
									$STRNAME='Tele2'; //  	Tele2 	TL2  ���
									$CTYPE='RUB';
								  }

				elseif ($menu==43)	{
									$STRNAME='Beeline'; // 	Beeline 	BLN ���
									$CTYPE='RUB';
								  }
				elseif ($menu==44)	{
									$STRNAME='�������'; // 	MegaFon 	MGF 	���			
									$CTYPE='RUB';
								  }
				elseif ($menu==45)	{
									$STRNAME='Yandex ������'; //Yandex Money 	YMO    ���
									$CTYPE='RUB';
								  }
				elseif ($menu==46)	{
									$STRNAME='QIWI - �������'; // 	QIW  ���
									$CTYPE='RUB';
								  }
									
				elseif ($menu==47)	{
									$STRNAME='�����-����'; //Alfa Click 	ALF 
									$CTYPE='RUB';									
								  }
				elseif ($menu==48)	{
									$STRNAME='"��������"'; // Sberbank 	SBR  ���
									$CTYPE='RUB';
								  }
				elseif ($menu==49)	{
									$STRNAME='Visa & MasterCard'; //  	Visa & MasterCard 	VMF 
									}
				elseif ($menu==50)	{
									$STRNAME='WebMoney'; //  WebMoney 	WMT 
									}
				elseif ($menu==51)	{
									$STRNAME='Bitcoin'; //  bitcoin 	BTC 
									}																		
				elseif ($menu==52)	{
									$STRNAME='Money Polo'; //  Money Polo 	MFS 
									}																				
				elseif ($menu==53)	{
									$STRNAME='W1'; //  W1 	WON 
									}				
				elseif ($menu==54)	{
									$STRNAME='�������������'; //  PromSvyazBank 	PSB 
									$CTYPE='RUB';									
									}	

			
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ;
		
			

			echo '
				<table>
					<tr>
						<td align="center">';


		echo '<form method="post" action="bank.php" target="_blank">';
		
 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
 		echo '<input type="hidden" name="okpay_type" value="666">'; 
 		echo '<input type="hidden" name="okpay_param" value="666">'; 

					
				if ($CTYPE=='USD')
					{
					echo '&nbsp;&nbsp;�����: <input name="okpay_amount" value="1" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> USD ';
					echo '<br><small><b> 1  ���. = '.$usd_kurs.'USD </b></small><br><br><br>';
					echo '� �����: <input type=text value="1" id=ekwmz size="8" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';		
					}
					else
					{
					echo '&nbsp;&nbsp;�����: <input name="okpay_amount" value="'.$RUR.'" size="8" id=wmrrub onChange=\'javascript: callcekrwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcekrwmr(this.value,'.$RUR.');"> ���. ';					
					echo '<br><small><b> 1  ���. = '.$RUR.'���. </b></small><br><br><br>';
					echo '� �����: <input type=text value="1" id=wmrekr size="8" onChange=\'javascript: callcrubwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcrubwmr(this.value,'.$RUR.');"> ���. ';					
					}


		echo '<br><br><br>
		<input type="submit" value="��������" onClick="closeinfo();"><br>
		</form>';

		echo '</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';

		}
else		
if ($menu==131)
	{

		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
		echo '<p><b><font color="red">��������� �������� �����: </font></b></p>' ; 

			 echo "<form method=post>";			
			 echo "� ��� � �������: <b>".$user[money]." ��.</b><br>";
				echo "<table>";
				echo "<tr>";
				echo "<td align=right>�����:</td>";
				echo "<td><input type=text name=add_kr size=5 maxlength=5></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td align=right>����������:</td>";
				echo "<td><input type=text name=add_kr_txt value='' size=50 maxlength=150></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=2 align=center><br><input type=submit name=add value='���������'></td>";
				echo "</tr></table>";					 
			echo "</form>";
						
		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}		
else		
if ($menu==132)
	{

		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
		echo '<p><b><font color="red">������ �� ����� �������: </font></b></p>' ; 

			 echo "<form method=post>";			
				echo "<table>";
				echo "<tr>";
				echo "<td align=right>�����:</td>";
				echo "<td><input type=text name=give_kr value='' size=5 maxlength=5></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td align=right>����� ����������:</td>";
				echo "<td><input type=text name=give_kr_login value='' size=15></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td align=right>������ �������� �����:</td>";
				echo "<td><input type=text name=give_kr_pass size=12 maxlength=12></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td align=right>����������:</td>";
				echo "<td><input type=text name=give_kr_txt value='' size=50 maxlength=150></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=2 align=center><br><input type=submit name=give value='������'></td>";
				echo "</tr></table>";					 
			echo "</form>";
						
		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}
else		
if ($menu==141)
	{

		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
		echo '<p><b><font color="red">������������� �������� �����: </font></b></p>' ; 

			 echo "<form method=post>";			
				echo "<table>";
				echo "<tr>";
				echo "<td colspan=2 align=center>�������� ����:</td></tr><tr>";
				echo "<td align=right>�:</td>";
				echo "<td>";
				
				 echo "<input type=text name='looklog_date' value='". date("d.m.Y")."' id=\"calendar-inputField1\" readonly=\"true\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
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
				
				echo "</td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td align=right>��:</td>";
				echo "<td>";
				
				 echo "<input type=text name='looklog_date_f' value='". date("d.m.Y")."' id=\"calendar-inputField2\" readonly=\"true\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
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
				
				
				echo "</td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=2 align=center><br><input type=submit name=look_log value='��������'></td>";
				echo "</tr></table>";	
			echo "</form>";					


						
		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}	
else		
if ($menu==142)
	{

		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
		echo '<p><b><font color="red">������� ������ � �����: </font></b></p>' ; 

			 echo "<form method=post>";			
				echo "<table>";
				
				echo "<tr><td colspan=2 align=center><b>��� ���������� �����:</b></td></tr>";

				echo "<tr>";
				echo "<td align=right>������ ������:</td>";
				echo "<td><input type=text name='old_kr_pass' size=12 maxlength=12></td>";					 
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align=right>����� ������:</td>";
				echo "<td><input type=text name='new_kr_pass' size=12 maxlength=12></td>";					 
				echo "</tr>";
				
				echo "<tr><td colspan=2 align=center><br><input type=submit name=chpkrass value='������� ������'></td></tr>";				
				
				echo "<tr><td colspan=2 align=center><br><b>��� ��������� �����:</b></td></tr>";

				echo "<tr>";
				echo "<td align=right>������ ������:</td>";
				echo "<td><input type=text name='old_ekr_pass' size=12 maxlength=12></td>";					 
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align=right>����� ������:</td>";
				echo "<td><input type=text name='new_ekr_pass' size=12 maxlength=12></td>";					 
				echo "</tr>";
				
				echo "<tr><td colspan=2 align=center><br><input type=submit name=chpekrass value='������� ������'></td></tr>";								

				
				
				echo "</tr></table>";					 
			echo "</form>";
			

			
						
		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}
else		
if ($menu==151)
	{
/*
		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
		echo '<p><b><font color="red">��������� ����������� �� ����: </font></b></p>' ; 

			 echo "<form method=post>";			
				echo "<table>";
				echo "<tr>";
				echo "<td align=right>�����:</td>";
				echo "<td><input type=text name=give_ekr value='' size=5 maxlength=5></td>";					 
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align=right>����� ����������:</td>";
				echo "<td><input type=text name=give_ekr_login value='' size=15></td>";					 
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align=right>� �����:</td>";
				echo "<td><input type=text name=give_bank size=9 value='' ></td>";					 
				echo "</tr>";				
				
				echo "<tr>";
				echo "<td align=right>������ ������� �����:</td>";
				echo "<td><input type=text name=give_ekr_pass size=12 maxlength=12></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td align=right>����������:</td>";
				echo "<td><input type=text name=give_ekr_txt value='' size=50 maxlength=150></td>";					 
				echo "</tr>";
				echo "<tr>";
				echo "<td colspan=2 align=center><br><input type=submit name=giveb value='���������'></td>";
				echo "</tr></table>";					 
			echo "</form>";
						
		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';
*/
	}	
else		
if ($menu==152)
	{

		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
		echo '<p><b><font color="red">�������� ���. �� �������: </font></b></p>' ; 

			 echo "<form method=post>";			
				echo "<table>";
				echo "<tr>";
				echo "<td align=right>�����:</td>";
				echo "<td><input type=text name=�hange_ekr value='' size=5 maxlength=5></td>";					 
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align=right>������ ������� �����:</td>";
				echo "<td><input type=text name=�hange_ekr_pass size=12 maxlength=12></td>";					 
				echo "</tr>";

				echo "<tr>";
				echo "<td colspan=2 align=center><br><input type=submit name=�hange value='��������'></td>";
				echo "</tr></table>";					 
			echo "</form>";

		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}		 		
/*	
else		
if (($menu==61) OR ($menu==62) OR ($menu==63) )
	{

$arr_txt[61]='Silver'; $arr_m[61]=1; $arr_p[61]="15 ���";
$arr_txt[62]='Gold'; $arr_m[62]=2; $arr_p[62]="40 ���";
$arr_txt[63]='Platinum'; $arr_m[63]=3; $arr_p[63]="100 ���";

		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			
		echo '<p><b><font color="red">����������/�������� '.$arr_txt[$menu].' account ��������� '.$arr_p[$menu].' :</font></b></p>' ; 

			 echo "<form method=post>";	
			 echo "<input type=hidden name=acctype value={$arr_m[$menu]}>";		
				echo "<table>";
				echo "<tr>";
				echo "<td align=right>����� ����������:</td>";
				echo "<td><input type=text name=silver_login value='' size=15 ></td>";					 
				echo "</tr>";
				
				echo "<tr>";
				echo "<td align=right>� ����� :</td>";
				echo "<td><input type=text name=silver_bank value='' size=9 ></td>";					 
				echo "</tr>";
			
				
				echo "<tr>";
				echo "<td align=right>������ ������� �����:</td>";
				echo "<td><input type=text name=silver_pass size=12 maxlength=12></td>";					 
				echo "</tr>";

				echo "<tr>";
				echo "<td colspan=2 align=center><br><input type=submit name=silver value='���������'></td>";
				echo "</tr></table>";					 
			echo "</form>";


		echo '	
			</td>
			</tr>
			</table>
		</td>
		</tr></table>
		</center>';

	}*/
else		
if ($menu==171)
	{
/*	 $KURS=40;
	$klan = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
   	$polno = array();
	$polno = unserialize($klan['vozm']);
	if (($klan['glava']==$user['id'] OR $polno[$user['id']][4] == 1) )
			{
				$get_all_vau=mysql_query("SELECT * FROM `oldbk`.`clans_preset` where klanid='{$klan[id]}' ORDER BY `pdate` ;");
				if(mysql_num_rows($get_all_vau)>0)
								{
								while($row=mysql_fetch_array($get_all_vau))
									{
									$vau_mes_list.=  "<form method=post><font class=date>".date("d.m.Y H:i",$row[pdate])."</font>: <b>".$row[owner_login]."</b> <a title=\"���. � ".$row[owner_login]."\" target=\"_blank\" href=\"inf.php?".$row[owner]."\"><img width=\"12\" border=\"0\" height=\"11\" alt=\"���. � ".$row[owner_login]."\"  src=\"http://i.oldbk.com/i/inf.gif\"></img></a> ������� ������ �� <b>".$row[ecost]." ���</b> �� <b>".($row[ecost]*$KURS)." ��.</b>";
									$vau_mes_list.= " <input type=hidden name=vauid value='{$row[itemid]}'>";
									$vau_mes_list.= "<small> ������</small>:<input type=text  name=vaupass size=8 maxlength=12>";									
									$vau_mes_list.= "<input type=submit name=yesvau value='�����������'>"; 
									$vau_mes_list.= "<input type=submit name=novau value='��������'>"; 								
									$vau_mes_list.= "</form><br>";
									}
								}
								else
								{
								 $vau_mes_list.= "<b>���� ������ �� ���������!</b>";							
								
								}
				echo "<table>";
				echo "<tr>";
				echo "<td align=left>{$vau_mes_list}</td>";
				echo "</tr></table>";	
								
			}
			else
			{
			echo "������ �������!";
			}
	*/
	}
		
	
?>


</td>
<td width=25>&nbsp;</td>
</tr>
<tr><td align="center"  colspan="3">

</td></tr>

</table>




