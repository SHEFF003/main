<?
	session_start();
	include "/www/oldbk.com/connect.php";
	include ('price.php');
	setcookie ("link_from_com", 'https://oldbk.com/commerce/index.php?act=other&wm=1',time()+3600,'/','.oldbk.com', false);
	$menu=(int)($_GET[id]);
	$param=(int)($_GET[param]);
	$oper_prise=25; //��������� �����
	
	//������� � ������������ ������ 222
	
	if (!($_SESSION['uid']>0)) { header("Location: https://oldbk.com/commerce/"); 		die();}


function get_rur_curs()
{
$query_curs=mysql_query("select * from oldbk.variables where var='dollar' or var='euro' or var='grivna'");

	 while($row=mysql_fetch_array($query_curs))	
	{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		 else
		 	if($row['var'] =='euro')  { $euro = $row[value];} 
		 		else
		 			if($row['var'] =='grivna') { $grivna = $row[value];}
	}
	$RUR=(round($dollar,3)+round($dollar*0.0693,3));

	if ($RUR>0)
		{
		 return	$RUR;
		}
		else return false;
		
}	

?>



<table border=0 width=750 height=365 >
<tr><td  valign=top align="center"  colspan="2"><center><font style="COLOR:#8f0000;FONT-SIZE:12pt">
<?
 if (($menu>=1) AND  ($menu<=4))
  	{
 	echo "<B>������ ����� WMZ �������� ��� ������ �������� �������:</B>";
 	}
	else if ( ($menu>=37) and ($menu<=54))
	{
	echo "<B>������� ����������� ������:</B>";
	}
 	else
 	{
 	echo "$menu";
 	echo "///";
 	echo "$param"; 	 	
 	die("Error");
 	}	
?>
</font></center></td>
<td  valign=top align="right"><a href=# onClick="closeinfo();" title="�������"><img src='https://i.oldbk.com/i/bank/bclose.png' style="position:relative;top:-20px;right:-20px;" border=0 title='�������'></a></td>
 </tr>
<tr>
<td width=25>&nbsp;</td>
<td width=900 height=250 valign="top" >

<?
 if ($menu==1)
	{
	$okg=true;
	if ($okg)
	{
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			echo '<p><b><font color="red">������ � ������� QIWI: </font></b></p>';
			echo '<table>
					<tr>
						<td align="right"></td>
						<td>';
			echo '<form method="post" accept-charset="windows-1251"  onSubmit="return checkSubmit();">
			<input type="hidden" name="from" value="6920"/>
			<input type="hidden" name="lifetime" value="0.0"/>
			<input type="hidden" name="check_agt" value="false"/>
			<input type="hidden" name="services" value="����� WMZ �������� ��� ������ �������� �������"/>
			<input type="hidden" name="com" value="������ ����� WMZ ��������"/>';
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
			<?
			if ($param==0)
			 {
			 $stoim=round($oper_prise*$RUR);
			?>
			<tr>
				<td colspan="2" style="padding:10px 0px; width:45%; text-align:center;">�����  <?=$oper_prise;?> ��� = <?=$stoim;?> ���. <br> <small><b>����   1���. =<?=$RUR;?> ���.</b></small>  </td>
				<input type="hidden" name="amount_rub" id="qrub" value="<?=$stoim;?>">
				<input type="hidden" name="amount_ekr" id="qekr" value="<?=$oper_prise;?>">
			</tr>
			<?
			 }
			?>
			
		</table>
		<div align=center><input type="submit" name="qiwimkbill" value="��������� ���� �� �������" /></div>
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
	}
else	
if ($menu==2)
	{
$okg=true;
	if ($okg)
	{


			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			echo '<p><b><font color="red">�������� � ������� Webmoney WMZ: </font></b></p>' ; 
			echo '
				<table>
					<tr>
					<td>';

		
 		echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp">';
 		
 		
 		if ($param==0)
 		{
		echo '<input type="hidden" name="traderid" value="0:0:222:'.$_SESSION['uid'].'">';
		echo '&nbsp;&nbsp;�����: <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$oper_prise.'" > '.$oper_prise.' WMZ <input type="hidden" value="Z132092281531" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		echo '<br><small><b> ����  1���.= 1 WMZ </b></small><br><br><br>';
		}
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">
		<div align=center><input type="submit" value="��������"></center><br><br>
		</form>
		

						</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';
		}

	}
else if ($menu==3)
		{
$okg=true;
		if ($okg)
		{
		
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			echo '<p><b><font color="red">�������� � ������� Webmoney WMR: </font></b></p>'; 
			echo '
				<table>
					<tr>
						<td align="center">';

		$RUR=get_rur_curs();
		
		echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp">';
		
		if ($param==0)
		{
		$stoim=round($oper_prise*$RUR);
		echo '<input type="hidden" name="traderid" value="0:0:222:'.$_SESSION['uid'].'">';
		echo '&nbsp;&nbsp;�����: '.$oper_prise.'���. = <input  type=hidden name="LMI_PAYMENT_AMOUNT" value="'.$stoim.'"> '.$stoim.' WMR ';
		echo '<input type="hidden" value="R266367733537" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br><br>
		<small><b> ����   1���. = '.$RUR.' WMR</b></small><br><br>';
		}
		echo '<br><br><br>
		<input type="submit" value="��������"><br>
		</form>';

				echo '</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';
			}
		}
else if ($menu==4)
	{
 	$okg=true;
	if ($okg)
	{
	
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			echo '<p><b><font color="red">�������� � ������� ��������-���� "�����-����" : </font></b></p>'; 
			echo '
				<table>
					<tr>
						<td align="center">';

		$RUR=get_rur_curs();
		
		echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp?at=authtype_18">';
		
		if ($param==0)
		{
		$stoim=round($oper_prise*$RUR);
		echo '<input type="hidden" name="traderid" value="0:0:222:'.$_SESSION['uid'].'">';
		echo '&nbsp;&nbsp;�����: '.$oper_prise.'���. = <input  type=hidden name="LMI_PAYMENT_AMOUNT" value="'.$stoim.'"> '.$stoim.' WMR ';
		echo '<input type="hidden" value="R266367733537" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" value="3" name="LMI_ALLOW_SDP">';		
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br><br>
		<small><b> ����   1���. = '.$RUR.' WMR</b></small><br><br>';
		}
		
		echo '<br><br><br>
		<input type="submit" value="��������"><br>
		</form>';

				echo '</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';
			}
		}
	else if ($menu==37)
	{
		$add_js=" onClick=\"closeinfo();\" ";	//����������	
		$start_usd=$PRICE[228][cost];
		$RUR=get_rur_curs();			
		$STRNAME="Web-money WMR";
		//����
			echo '<center>';		
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ; 	
			echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank>';		
			echo '<input type="hidden" name="traderid" value="0:0:1001:'.$_SESSION['uid'].'">';
			echo '&nbsp;&nbsp;<strong>�����: <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.round($start_usd*$RUR,2).'" size="8" id=ekwmz readonly>'.round($start_usd*$RUR,2).' WMR </strong>';
			echo '<input type="hidden" value="R266367733537" name="LMI_PAYEE_PURSE">';			
			echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
			
			if ($nobutton!=true)		
			{
			echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">
			<div align=center>
			<br><br>
			<input type="submit" value="��������" '.$add_js.'></center><br><br>
			</form>';
			}		
			echo '</center>';			
	}	
	else if ($menu==38)
	{
		$add_js=" onClick=\"closeinfo();\" ";	//����������	
		$start_usd=$PRICE[228][cost];
		$STRNAME="Web-money WMZ";
		//����
			echo '<center>';		
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ; 			
			echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank>';			
			echo '<input type="hidden" name="traderid" value="0:0:1001:'.$_SESSION['uid'].'">';
			echo '&nbsp;&nbsp;<strong>�����: <input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$start_usd.'" size="8" id=ekwmz readonly>'.$start_usd.' WMZ </strong><input type="hidden" value="Z132092281531" name="LMI_PAYEE_PURSE">';
			echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
			
			if ($nobutton!=true)		
			{
			echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">
			<div align=center>
			<br><br>
			<input type="submit" value="��������" '.$add_js.'></center><br><br>
			</form>';
			}		
			echo '</center>';			
	}
	else if ($menu==39)
	{
		$add_js=" onClick=\"closeinfo();\" ";	//����������	
		$start_usd=$PRICE[228][cost];
		$STRNAME="LiqPay";
			echo '<center>';		
			echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ; 			
			echo '<form method="post" action="index.php" target= _blank >';	
	 		echo '<input type="hidden" name="liqpay_type" value="1001">'; 
	 		echo '<input type="hidden" name="liqpay_param" value="0">'; // ������������
			echo '&nbsp;&nbsp;<strong>�����: <strong><input type="hidden" name="liqpay_amount" value="'.$start_usd.'" > '.$start_usd.' USD </strong>';

			if ($nobutton!=true)
			{
			echo '<br><br><br><div align=center><input type="submit" value="��������" '.$add_js.'></center><br><br>
			</form>';
			}
	}	
	else if ( ($menu>=40) and ($menu<=54))
	{
	$add_js=" onClick=\"closeinfo();\" ";	//����������						
	//�������  okpay
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
						<td align="right"></td>
						<td>';
 	


			echo '<form method="post" action="index.php" target=_blank>';						
	 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
		
						
			 		if ($param==1001)
				 		{

						$start_usd=$PRICE[228][cost];
						$start_rub=round($start_usd*$RUR,2);						

				 			
				 				if ($CTYPE=='USD')
				 					{
							 		echo '<input type="hidden" name="okpay_type" value="1001">'; // ��� 
							 		echo '<input type="hidden" name="okpay_param" value="0">'; // ������������
									echo '&nbsp;&nbsp;<strong>�����: <input type="hidden" name="okpay_amount" id="okpay_amount"  value="'.$start_usd.'" size="8" >'.$start_usd.' USD </strong>';
									}
									elseif ($CTYPE=='RUB')
									{
							 		echo '<input type="hidden" name="okpay_type" value="1001">'; // ��� 
							 		echo '<input type="hidden" name="okpay_param" value="0">'; // ������������
									echo '&nbsp;&nbsp;<strong>�����: <input type="hidden" name="okpay_amount" id="wmrrub"  value="'.$start_rub.'">'.$start_rub.' ���. </strong>';									
									}
									
						}
						
			
				if ($nobutton!=true)
				{
				echo '<br><br><br><div align=center><input type="submit" value="��������" '.$add_js.'></center><br><br></form>';
				}
			

		echo '			</td>
						<td align="right">
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
