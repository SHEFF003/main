<?
	session_start();
	include "connect.php";
	include "functions.php";
	include "bank_functions.php";
	include "ny_events.php";
	$OK_PAY_OFF=true;

	if (!($_SESSION['bankid']>0)) { header("Location: ../bank.php?sms_err=����������� ������"); 		die();}

	$menu=(int)($_GET[id]);


	$dopparam=explode(":",$_GET[param]);

	if ($dopparam[1]>0)
		{
		$dopp=(int)$dopparam[0];
		$param=(int)$dopparam[1];
		}
		else
		{
		$param=(int)($_GET[param]);
		}

	$usd_kurs=get_ekr_usd();
	$bonekr=get_ekr_addbonus();

	$coins_kurs=20; // 1 ���� 20 �����
unset($vaucher);

function buket_my_level_select($telo)
{
 if ($telo['level']<=8) return 	410021; //"����� ������ ������ (6)
elseif ($telo['level']==9) return 	410022; // 			"����� ����������� ������ (9)"=>410022,
elseif ($telo['level']==10) return 	410024; // 			"����� ���������� �������� (10)"=>410024,
elseif ($telo['level']==11) return 	410025; // 			"����� �������� ����� (11)"=>410025,
elseif ($telo['level']==12) return 	410023; // 						"����� ������������� ����� (12)"=>410023,
elseif ($telo['level']>=13) return 	410026; // 				"����� �������� ����� (13)"=>410026

return 410021;
}

function show_elka($leto=false,$proto=false)
{
	global $bukets, $leto_bukets;
	$dress=array();

	$ekr_elka = array(55510350);
	$art_elka = array(55510351);

	$start_id=55510350;

	if ($leto==true)
	{
	$bukets=$leto_bukets;
	$start_id=410021;
	}

	if ($proto)
		{
		$els=mysql_query("SELECT * from oldbk.shop where id='{$proto}' ");
		$start_id=$proto;
		}
		else
		{
		$els=mysql_query("SELECT * from oldbk.shop where id in (".implode(",",$bukets).") ");
		}

	while($row=mysql_fetch_array($els))
		{
		$dress[$row['id']]=$row;
		}

	foreach ($dress as $i=>$dat)
		{

		$out.='<div align=center id="'.$i.'" style="display: '.(($i==$start_id)?"block":"none").';" >';


		$out.='<img src="http://i.oldbk.com/i/sh/'.$dress[$i]['img'].'" onMouseOut="HideThing(this)"  onMouseOver="ShowThing(this,55,75,\'<table border=0 cellspacing=5 cellpadding=0><tr valign=top><td><span  style=font-size:9px><br><b>'.$dress[$i]['name']."</b><br>������������� ".$dress[$i]['duration']."/".$dress[$i]['maxdur']."<br>";
		if ($dress[$i]['stbonus'] > 0) $out.="��������� ����������: <b>".$dress[$i]['stbonus']."</b><BR>";
		if ($dress[$i]['mfbonus'] > 0)  $out.="��������� ���������� ��: <b>".$dress[$i]['mfbonus']."</b><BR>";

		$out.="���� ��������: <b>14 ��.</b><BR>";
		$out.="<br>��������� ��: ";

		if ($dress[$i]['minu']) {
			$out.= "<BR>� ����������� ��������� �����������: ".$dress[$i]['minu'];
		}
		if ($dress[$i]['maxu']) {
			$out.= "<BR>� ������������ ��������� �����������: ".$dress[$i]['maxu'];
		}

		$out.=(($dress[$i]['gsila']!=0)?"<br>� ����:{$dress[$i]['gsila']}":"")." ".(($dress[$i]['glovk']!=0)?"<br>� ��������:{$dress[$i]['glovk']}":"")." ".(($dress[$i]['ginta']!=0)?"<br>� ��������:{$dress[$i]['ginta']}":"")." ".(($dress[$i]['gintel']!=0)?"<br>� ���������:{$dress[$i]['gintel']}":"").' '.(($dress[$i]['ghp']>0)?"<br>� ������� ����� +{$dress[$i]['ghp']}":"")." ".(($dress[$i]['mfkrit']!=0)?"<br>� ��. ����������� ������:{$dress[$i]['mfkrit']}%":"")." ".(($dress[$i]['mfakrit']!=0)?"<br>� ��. ������ ����. ������:{$dress[$i]['mfakrit']}%":"")." ".(($dress[$i]['mfuvorot']!=0)?"<br>� ��. ������������:{$dress[$i]['mfuvorot']}%":"")." ".(($dress[$i]['mfauvorot']!=0)?"<br>� ��. ������ ��������.:{$dress[$i]['mfauvorot']}%":"")." ".(($dress[$i]['gnoj']!=0)?"<br>� �������� ������ � ���������:+{$dress[$i]['gnoj']}":"")." ".(($dress[$i]['gtopor']!=0)?"<br>� �������� �������� � ��������+{$dress[$i]['gtopor']}":"")." ".(($dress[$i]['gdubina']!=0)?"<br>� �������� ��������, ��������:+{$dress[$i]['gdubina']}":"")." ".(($dress[$i]['gmech']!=0)?"<br>� �������� ������:+{$dress[$i]['gmech']}":"")." ".(($dress[$i]['gfire']!=0)?"<br>� �������� ������ ����:+{$dress[$i]['gfire']}":"")." ".(($dress[$i]['gwater']!=0)?"<br>� �������� ������ ����:+{$dress[$i]['gwater']}":"")." ".(($dress[$i]['gair']!=0)?"<br>� �������� ������ �������:+{$dress[$i]['gair']}":"")." ".(($dress[$i]['gearth']!=0)?"<br>� �������� ������ �����:+{$dress[$i]['gearth']}":"")." ".(($dress[$i]['glight']!=0)?"<br>� �������� ����� �����:+{$dress[$i]['glight']}":"")." ".(($dress[$i]['ggray']!=0)?"<br>� �������� ����� �����:+{$dress[$i]['ggray']}":"")." ".(($dress[$i]['gdark']!=0)?"<br>� �������� ����� ����:+{$dress[$i]['gdark']}":"")." ".(($dress[$i]['bron1']!=0)?"<br>� ����� ������:{$dress[$i]['bron1']}":"")." ".(($dress[$i]['bron2']!=0)?"<br>� ����� �������:{$dress[$i]['bron2']}":"")." ".(($dress[$i]['bron3']!=0)?"<br>� ����� �����:{$dress[$i]['bron3']}":"")." ".(($dress[$i]['bron4']!=0)?"<br>� ����� ���:{$dress[$i]['bron4']}":"")." ".(($dress[$i]['text']!=null)?"<br>  �� ������ ������: {$dress[$i]['text']}":"").''.(($dress[$i]['includemagic'])?'<br><br><b>�������� �����: '.$dress[$i]['includemagicname'].' ('.$dress[$i]['includemagicdex'].'/'.$dress[$i]['includemagicmax'].' ��.)</b>':'');

		$out .= "<br>��������:<br>";
		if ($dress[$i]['ab_mf'] > 0) $out .= "� ������������� ��.:+".$dress[$i]['ab_mf']."%<br>";
		if ($dress[$i]['ab_bron'] > 0) $out .= "� �����:+".$dress[$i]['ab_bron']."%<br>";
		if ($dress[$i]['ab_uron'] > 0) $out .= "� �����:+".$dress[$i]['ab_uron']."%<br>";


		$elkabonus = 0;
		if ((in_array($dress[$i]['id'],$leto_bukets)) AND (time()>mktime(0,0,0,7,5,2017))  )
		{
			//������
			$elkabonus = 10;
		}
		elseif (in_array($dress[$i]['id'],$leto_bukets))
		{
			//������
			$elkabonus = 2;
		}
		elseif (in_array($dress[$i]['id'],$ekr_elka))
		{
			//������� ����
			$elkabonus = 2;
		} elseif (in_array($dress[$i]['id'],$art_elka)) {
			//������� ����
			$elkabonus = 3;
		}

		if ($elkabonus > 0)
		{
			$out .= "� ������� �����:+".$elkabonus."%<br>";
		}

		if ($dress[$i]['id'] == 55510351)
		{
			$out .= "� �����:+10%<br>";
		}

		$out.='</span></td></tr></table>\')" >';
		$out.='</div>';
		}
$out.='<br>';
if ($leto==true) { $out.='<div align=center><font color=red>* <small><b>������ ����� ���� �������� 14 ���� � �������� �������.</b></small></font></div><br>'; }

return $out;
}

if ($user['id']==14897)
	{
//	print_r($leto_bukets);
	}

?>

<script type="text/javascript" src="/i/bank20.js"></script>

<table border=0 width=820 height=390 >
<tr><td  valign=top align="center"  colspan="2"><center><font style="COLOR:#8f0000;FONT-SIZE:12pt">
<?

	if ( (  ($menu==2) OR ($menu==4||$menu==5||$menu==6||$menu==7||$menu==8||$menu==10||$menu==11||$menu==14||$menu==15) OR  ($menu==20) OR  ($menu==21) OR  ($menu==22) OR ($menu==23) OR ($menu>=40 && $menu<=54)  )   AND ($param==0) )
 	{
 	echo "<B>���������� ����� �{$_SESSION['bankid']}</B>";
 	}
 	else  if  ( ($menu==9 OR $menu==2 OR $menu==4 OR $menu==5 OR $menu==6 OR $menu==7 OR $menu==8 OR $menu==10 OR $menu==11 OR $menu==14 OR $menu==15 or $menu==20  or $menu==21 OR  ($menu==22) or $menu==23 or ($menu>=40 && $menu<=54)  )  AND $param==300 ) //9 - �������
 	{
 	echo "<B>������� ���������</B> <br><small>��� ������ ������� ��������� ���������� � ������ <a target='_blank' href='http://capitalcity.oldbk.com/friends.php?pals=3'>������ ����</a></small>";
 	}
 	else  if( ( $menu==87 ) OR ( ($menu==2||$menu==4||$menu==5||$menu==6||$menu==7||$menu==8||$menu==10||$menu==11||$menu==14||$menu==15||$menu==20 || $menu==21 || $menu==22 ||$menu==23||($menu>=40 && $menu<=54) ) AND ( $param==87) )   )
 	{
 	echo "<B>�������  �����</B>";
 	}
	else  if( ( $menu==88 ) OR ( ($menu==2||$menu==4||$menu==5||$menu==6||$menu==7||$menu==8||$menu==10||$menu==11||$menu==14||$menu==15||$menu==20|| $menu==21|| $menu==22||$menu==23||($menu>=40 && $menu<=54) )AND ( $param==88) )   )
 	{
 	echo "<B>�������  �����. �����!</B>";
 	}
	else  if( ( $menu==69 ) OR ( ($menu==2||$menu==4||$menu==5||$menu==6||$menu==7||$menu==8||$menu==10||$menu==11||$menu==14||$menu==15||$menu==20||$menu==21|| $menu==22||$menu==23||($menu>=40 && $menu<=54) )AND ( $param==69) )   )
 	{
 	echo "<B>������� �������</B>";
 	}
 	else  if ( $menu==99 )
 	{
 	echo "<B>������� ������������</B> <br><small>��� ������ ������� ��������� ���������� � ������ <a href='http://capitalcity.oldbk.com/friends.php?pals=3'>������ ����</a></small>";
 	}
 	else  if ( ($menu==2018||$menu==2118) OR ( (in_array($menu,array (2,4,5,6,7,8,20,14,15,10,11))) AND ( $param==2018||$param==2118) )   )
 	{
 	echo "<B>������ ����� �� 8-����� �����</B> <br>";
 	}
	else  if ( $menu==0)
 	{
 	echo "������� ������:";
 	}
 	else if (($menu==2||$menu==4||$menu==5||$menu==6||$menu==7||$menu==8||$menu==10||$menu==11||$menu==14||$menu==15||$menu==20||$menu==21||$menu==23)AND ( $dopp>=1 AND $dopp<=3) )
 	{
 		echo "���������������...";

	if ($user['id']==14897)
		{
	 	echo "<br>";
	 	echo $menu;
		echo "<br>";
		echo $param;
		echo "<br>";
		echo $dopp;
 		}
 	} elseif ($menu==22)
 	{
	//����
 	}
 	else
 	{
 	//print_r($dopparam);
 	/*echo "<br>";
 	echo $menu;
	echo "<br>";
	echo $param;
	echo "<br>";
	echo $dopp;
	*/
 	die("Error");
 	}

 	if ($menu>=40 && $menu<=54)
 	{
 	echo "<br><font color=red><small>����������� � ������� �������� OKpay �� ���������!</small></font>";
 	}

?>
</font></center></td>
<td  valign=top align="right"><a href=# onClick="closeinfo();" title="�������"><img src='http://i.oldbk.com/i/bank/bclose.png' style="position:relative;top:-20px;right:-20px;" border=0 title='�������'></a></td>
 </tr>
<tr>
<td width=25>&nbsp;</td>
<td width=900 height=290 valign="top" >

<?
	if ($menu==2018||$menu==2118)
	{
		echo "<center><br><table border=0 cellspacing=5 cellpadding=0> <tr>";
		echo "<td>";
			if ($menu==2018)
			{
			$dopp=4;
			$param=2018;
			}
			else
			{
			$dopp=5;
			$param=2118;
			}
		echo "<a href=\"#\" onClick=\"getformdata(5,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' >"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(21,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_privat24.gif title='�������� � ������� \"������ 24\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(7,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(8,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
		echo "</td><td>";

		echo "<a href=\"#\" onClick=\"getformdata(10,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_vtb24.gif title='�������� � ������� \"���24\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(20,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(14,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"��������� ��������� ���\"' ></a>"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(15,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"��������� ��������� ������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(11,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_pochtarf.gif title='�������� � ������� \"����� ��\"' ></a>";
		echo "</td></tr><tr><td>";





		echo "</td></tr></table></center>";
	}
	else
	if ($menu==0)
	{
		echo "<center><br><table border=0 cellspacing=5 cellpadding=0> <tr>";
		echo "<td>";
		//�� ��� ��������
		echo "<a href=\"#\" onClick=\"getformdata(5,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' >"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(21,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_privat24.gif title='�������� � ������� \"������ 24\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(22,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_qiwi.gif title='�������� � ������� \"QIWI - �������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(8,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
		echo "</td><td>";

		if ( ($dopp==1 AND $param<200) OR ($dopp==2 AND $param<10) OR ($dopp==3 AND $param<6000) )
		{
		//echo "<a href=\"#\" onClick=\"alert('����������� ����� ������ ����� Paypal ���������� 10$');\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";												
		}
		else
		{
		//echo "<a href=\"#\" onClick=\"getformdata(23,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
		}

		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(20,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";


		echo "<a href=\"#\" onClick=\"getformdata(14,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"��������� ��������� ���\"' ></a>"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(15,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"��������� ��������� ������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(10,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_vtb24.gif title='�������� � ������� \"���24\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(11,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_pochtarf.gif title='�������� � ������� \"����� ��\"' ></a>";
		echo "</td></tr><tr><td>";
		echo " ";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(6,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_brs2.gif title='�������� � ������� \"������� ��������\"' ></a>";
		echo "</td><td>";
		echo " ";

		echo "<a href=\"#\" onClick=\"getformdata(7,'".$dopp.":".$param."',event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";

		echo "</td><td>";
		echo " ";



		echo "</td></tr></table></center>";
	}
	else
	if ($menu==2)
	{
		$gold_val=20;
		$ekr_val=1;
		$rep_val=1000;
		$hide_input=false;

		if ($dopp==1) { $gold_val=$param; $param=87; $hide_input=true; }
			elseif ($dopp==2) { $ekr_val=$param; $param=0; $hide_input=true; }
			elseif ($dopp==3) { $rep_val=$param; $param=300;  $hide_input=true; }
			elseif ($dopp==4) { $b_val=65; $param=2018;  $hide_input=true; }
			elseif ($dopp==5) { $b_val=70; $param=2118;  $hide_input=false; }



 	$okg=true;
	if ($okg)
	{


			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';

			if ($hide_input) { echo "<div style=\"display:none;\">";}

			if ($param==0)	{ echo '<p><b><font color="red">������ ��� � ������� Webmoney WMZ: </font></b></p>' ; }
			else { echo '<p><b><font color="red">�������� � ������� Webmoney WMZ: </font></b></p>' ; }
			echo '
				<table>
					<tr>
						<td align="right"></td>
						<td>';


 		if ($param!=88)    echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank name="wfrm">';


 		if ($param==0)
 		{

 		if ($usd_kurs)
 			{
 		echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].'">';
		echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="'.round($ekr_val*$usd_kurs,2).'" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> WMZ <input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';


//		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="���������� ����������� ����� �'.$_SESSION['bankid'].' ��� ��������� '.$user['login'].'">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		echo '<br><small><b> 1  ���. = '.$usd_kurs.'WMZ </b></small><br><br><br>';
		echo '�� ����: <input type=text id=ekwmz value='.round($ekr_val,2).' size="8" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';
			}
		}
 		if ($param==87)
 		{

			echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':88000:'.$user['id'].'">';
			echo '����������: <input type=text id=awmz value='.round($gold_val,2).' size="8" onChange=\'javascript: callcwmz(this.value,'.$coins_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$coins_kurs.');"> �����. ';
			echo '<br><small><b> 20 ����� =1 WMZ </b></small><br><br><br>';
			echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="'.round($gold_val/$coins_kurs,2).'" size="8" id=ekwmz onChange=\'javascript: callcgold(this.value,'.$coins_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcgold(this.value,'.$coins_kurs.');"> WMZ <input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
			echo "<br><small><b>* ���������� 20 �����.</b></small>";
			echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
			$add_js=" onClick=\"if (document.getElementById('awmz').value<20) { alert('���������� ��� ������� 20 �����!'); return false; } else { return true;  } \" ";


		}
		else if ($param==300)
		{
		echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].'">';
		echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="'.round($rep_val/600,2).'" size="8"> WMZ <input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
		//echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� ���������  ��� ��������� '.$user['login'].'">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';

		echo '<br><small><b> '.$usd_kurs.' WMZ= 600 ���. </b> </small><br><br><br>';
		}
		else if ($param==2018)
		{
		echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].'">';
		echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$b_val.'" size="8"><input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		}
		else if ($param==2118)
		{
		echo '�������� ������ ��������: <select name="traderid">';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':1" selected> S </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':2"> M </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':3"> L </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':4"> XL </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':5"> XXL </option>';
		echo "  </select> <br>";
		echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.$b_val.'" size="8"><input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		}
		elseif ($param==88)
			{
			//������� ����� �� WMZ - ���������
				echo "<table border=0 >";
					echo "<tr height='90'><td style='background-image: url(\"http://i.oldbk.com/i/bank/fon.gif\"); background-repeat: no-repeat; background-position: center;'  valign='bottom' width='115' height='90' ><img src='http://i.oldbk.com/i/bank/coin_fon.gif' alt='100 �����' title='100 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>100 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_10.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/purse_fon.gif' alt='500 �����' title='500 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>500 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_30.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/chiest_fon.gif' alt='1000 �����' title='1000 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 15px; top: -15px;'>1000 �����</span>";
					echo "</td>";
					echo "</tr>";
					echo "<tr><td align=center>";

					echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank>';
					echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':88100:'.$user['id'].'">';
					echo '<input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
					echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
					echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
					echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="5" >'; //					 100 ����� = 5$
					echo '<input type="submit" value="������ �� 5 WMZ" >';
					echo '</form>';

					echo "</td>";
					echo "<td align=center>";
					echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank>';
					echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':88500:'.$user['id'].'">';
					echo '<input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
					echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
					echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
					echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="22.5" >';  // 500 ����� (-10% ������) = 22,5$
					echo '<input type="submit" value="������ �� 22.5 WMZ" >';
					echo '</form>';

					echo "</td>";
					echo "<td align=center>";
					echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank>';
					echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':881000:'.$user['id'].'">';
					echo '<input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
					echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
					echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
					echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="35" >'; // 1000 ����� (-30% ������) = 35$
					echo '<input type="submit" value="������ �� 35 WMZ" >';
					echo '</form>';
					echo "</td>";
					echo "</tr>";
				echo "</td>";
				echo "</tr></table><br></form>";
				$nobutton=true;
			}
		elseif ($param==69)
		{
				echo "<table border=0>";
				echo "<tr><td>";
				echo "</td>";
				echo "<td>";
				echo "<input type=\"hidden\" name=\"amount_bil\" id=\"qbil\" value=\"1\" >";
				echo "</td>";
				echo "</tr><tr>";


				echo "<td valign=bottom align=right>";
				echo '';
				echo "</td>";
				echo "<td valign=bottom >";

				echo show_elka(true);
				echo "�����:<select name=\"traderid\" id=\"buketid\"  onChange='javascript: callbuket(1,1);'  >";


							foreach ($leto_bukets as $k=>$v)
									{
									$ii++;
									echo '<option value="0:'.$_SESSION['bankid'].':'.$v.':'.$user['id'].'" ';
									if (buket_my_level_select($user)==$v) echo " selected ";
									echo $kcolor." >$k </option>";
									}

						echo "  </select> <br>";

	if (buket_my_level_select($user)!=410021)
							{
							 echo "<script>
							 		document.getElementById(410021).style.display='none';
							 		document.getElementById(".buket_my_level_select($user).").style.display='block';
								</script>";
							 }






				echo '�����:<input name="LMI_PAYMENT_AMOUNT" value="10" size="8" id="qrub" readonly="readonly" > WMZ <input type="hidden" value="Z755383101103" name="LMI_PAYEE_PURSE">';
				echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
				echo "</td>";
				echo "</tr></table><br><br>";
		}


		if ($nobutton!=true)
		{
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">
		<div align=center><input type="submit" value="��������" '.$add_js.'></center><br><br>
		</form>';
		}

		if ($hide_input) {
				 echo "</div>
				 <script>
				 document.wfrm.submit();
				 setTimeout('location.reload()',1000);
				 </script>
				 ";}


		echo'				</td>
						<td align="right">
						</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';
		}

	}
else if (($menu==4) OR ($menu==5) OR ($menu==6) OR ($menu==7) OR ($menu==8) OR ($menu==10) OR ($menu==11) OR ($menu==14) OR ($menu==15)  )
		{
		$gold_val=20;
		$ekr_val=1;
		$rep_val=1000;
		$hide_input=false;

		if ($dopp==1) { $gold_val=$param; $param=87; $hide_input=true; }
			elseif ($dopp==2) { $ekr_val=$param; $param=0; $hide_input=true; }
			elseif ($dopp==3) { $rep_val=$param; $param=300;  $hide_input=true; }
			elseif ($dopp==4) { $b_val=65; $param=2018;  $hide_input=true; }
			elseif ($dopp==5) { $b_val=70; $param=2118;  $hide_input=false; }

		$LMI_SDP_TYPE[5]=3; // ��������-���� "�����-����"
		$LMI_SDP_TYPE[6]=5; // ��������-���� "������� ��������"
		$LMI_SDP_TYPE[10]=6; // ��������-���� "���24"
		$LMI_SDP_TYPE[7]=9; //��������-���� "�������������"
	   	$LMI_SDP_TYPE[8]=14; // ��������-���� "�������� ������"
	   	$LMI_SDP_TYPE[11]=11; // ����� ��

	   	$LMI_SDP_TYPE[14]=11; // ��������� ��������� ���
	   	$LMI_SDP_TYPE[15]=12; //��������� ��������� ������

	   	$LMI_SDP_TYPE[12]=20; //  �����


		$sinf[5]='��������-���� "�����-����"';
		$sinf[6]='��������-���� "������� ��������"';
		$sinf[10]='��������-���� "���24"';
		$sinf[7]='��������-���� "�������������"';
	   	$sinf[8]='��������-���� "�������� ������"';
	   	$sinf[11]='����� ��';
	   	$sinf[12]='Bitcoin';

	   	$sinf[14]='��������� ��������� ���';
	   	$sinf[15]='��������� ��������� ������';


		$string_inf='Webmoney WMR';
		if ($sinf[$menu]!='') $string_inf=$sinf[$menu];



	   	$online_bank='';

	   	if ($LMI_SDP_TYPE[$menu]>0) { $online_bank="?at=authtype_18"; }

	   	if ($LMI_SDP_TYPE[$menu]==14) { $online_bank="?at=authtype_21"; }
	   	if ($LMI_SDP_TYPE[$menu]==11) { $online_bank="?at=authtype_11"; }
	   	if ($LMI_SDP_TYPE[$menu]==16) { $online_bank="?at=authtype_16"; }
	   	if ($LMI_SDP_TYPE[$menu]==20) { $online_bank="?at=authtype_20"; }

	   	if (($menu==14) OR ($menu==15)) { $online_bank="?at=authtype_19"; }



		//�������� �� ��� � ����������� ������� ������
		$okg=true;

		if ($okg)
		{

			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';

			if ($hide_input) { echo "<div style=\"display:none;\">";}

			if ($param==0)	{ echo '<p><b><font color="red">������ ��� � ������� '.$string_inf.': </font></b></p>'; }
			else { echo '<p><b><font color="red">�������� � ������� '.$string_inf.': </font></b></p>'; }
			echo '
				<table>
					<tr>
						<td align="center">';

		$RUR=get_rur_curs();

		if ($param!=88)	 echo '<form name=frmw method="post" action="https://merchant.webmoney.ru/lmi/payment.asp'.$online_bank.'" target= _blank>';



		if ($param==0)
		{
		echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].'">';
		echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="'.round($ekr_val*$RUR,2).'" size="8" id=wmrrub onChange=\'javascript: callcekrwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcekrwmr(this.value,'.$RUR.');"> WMR ';
		echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
//		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="���������� ����������� ����� �'.$_SESSION['bankid'].' ��� ��������� '.$user['login'].'">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';

		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br><br>
		<small><b> 1  ���. = '.$RUR.' WMR </b></small><br><br>
		�� ����: <input type=text id=wmrekr value="'.$ekr_val.'" size="8" onChange=\'javascript: callcrubwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcrubwmr(this.value,'.$RUR.');"> ���. ';
		}
		else if ($param==300)
		{
		echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].'">';
		echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="'.round($rep_val/600*$RUR,2).'" size="8" id=qrub onChange=\'javascript: callcrep(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcrep(this.value,'.$RUR.');"> WMR ';
		echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
//		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� ���������  ��� ��������� '.$user['login'].'">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br><br>
		<small><b> '.$RUR.' WMR= 600 ���. </b>  </small><br><br>
		��������: <input type=text value='.$rep_val.' id=qrep size="8" onChange=\'javascript: callcrubrep(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcrubrep(this.value,\''.$RUR.'\')"  readonly="readonly"  > ���. ';
		}
		else if ($param==2018)
		{
		echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].'">';
		echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.ceil($b_val*$RUR).'" size="8">';
		echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br>';
		}
		else if ($param==2118)
		{
		echo '�������� ������ ��������: <select name="traderid">';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':1" selected> S </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':2"> M </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':3"> L </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':4"> XL </option>';
		echo '<option value="0:'.$_SESSION['bankid'].':'.$param.':'.$user[id].':5"> XXL </option>';
		echo "  </select> <br>";

		echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.ceil($b_val*$RUR).'" size="8">';
		echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br>';
		}
		elseif ($param==87)
		{
			echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':88000:'.$user['id'].'">';
			echo '����������: <input type=text id=awmz value='.$gold_val.' size="8" onChange=\'javascript: callcwmz(this.value,'.($coins_kurs/$RUR).')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.($coins_kurs/$RUR).');"> �����. ';
			echo '<br><small><b> 20 ����� ='.$RUR.' WMR </b></small><br><br><br>';
			echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="'.round($gold_val/($coins_kurs/$RUR),2).'" size="8" id=ekwmz onChange=\'javascript: callcgold(this.value,'.($coins_kurs/$RUR).')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcgold(this.value,'.($coins_kurs/$RUR).');"> WMR';
			echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
			echo "<br><small><b>* ���������� 20 �����.</b></small>";
			echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com">';
			echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br><br>';
			$add_js=" onClick=\"if (document.getElementById('awmz').value<20) { alert('���������� ��� ������� 20 �����!'); return false; } else { return true;  } \" ";
		}
		elseif ($param==88)
		{
			//������� ����� �� WMR
				echo "<table border=0 >";
					echo "<tr height='90'><td style='background-image: url(\"http://i.oldbk.com/i/bank/fon.gif\"); background-repeat: no-repeat; background-position: center;'  valign='bottom' width='115' height='90' ><img src='http://i.oldbk.com/i/bank/coin_fon.gif' alt='100 �����' title='100 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>100 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_10.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/purse_fon.gif' alt='500 �����' title='500 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>500 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_30.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/chiest_fon.gif' alt='1000 �����' title='1000 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 15px; top: -15px;'>1000 �����</span>";
					echo "</td>";
					echo "</tr>";
					echo "<tr><td align=center>";

					echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp'.$online_bank.'" target= _blank>';
					echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':88100:'.$user['id'].'">';
					echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
					echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
					echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
					echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.(ceil($RUR*5)).'" >'; //					 100 ����� = 5$
					echo '<input type="submit" value="������ �� '.(ceil($RUR*5)).'���." >';
		   		   	if ($LMI_SDP_TYPE[$menu]==3 || $LMI_SDP_TYPE[$menu]==5 || $LMI_SDP_TYPE[$menu]==6 || $LMI_SDP_TYPE[$menu]==9 || $menu==14 || $menu==15)
		   		   	{
				   	echo '<input type="hidden" name="LMI_SDP_TYPE" value="'.$LMI_SDP_TYPE[$menu].'">';
			 	   	echo '<input type="hidden" name="LMI_ALLOW_SDP" value="'.$LMI_SDP_TYPE[$menu].'">';
				   	}
					echo '</form>';

					echo "</td>";
					echo "<td align=center>";
					echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp'.$online_bank.'" target= _blank>';
					echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':88500:'.$user['id'].'">';
					echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
					echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
					echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
					echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.(ceil($RUR*22.5)).'" >';  // 500 ����� (-10% ������) = 22,5$
					echo '<input type="submit" value="������ �� '.(ceil($RUR*22.5)).'���." >';
		   		   	if ($LMI_SDP_TYPE[$menu]==3 || $LMI_SDP_TYPE[$menu]==5 || $LMI_SDP_TYPE[$menu]==6 || $LMI_SDP_TYPE[$menu]==9 || $menu==14 || $menu==15)
		   		   	{
				   	echo '<input type="hidden" name="LMI_SDP_TYPE" value="'.$LMI_SDP_TYPE[$menu].'">';
			 	   	echo '<input type="hidden" name="LMI_ALLOW_SDP" value="'.$LMI_SDP_TYPE[$menu].'">';
				   	}
					echo '</form>';

					echo "</td>";
					echo "<td align=center>";
					echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp'.$online_bank.'" target= _blank>';
					echo '<input type="hidden" name="traderid" value="0:'.$_SESSION['bankid'].':881000:'.$user['id'].'">';
					echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
					echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
					echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
					echo '<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="'.(ceil($RUR*35)).'" >'; // 1000 ����� (-30% ������) = 35$
					echo '<input type="submit" value="������ �� '.(ceil($RUR*35)).'���." >';
		   		   	if ($LMI_SDP_TYPE[$menu]==3 || $LMI_SDP_TYPE[$menu]==5 || $LMI_SDP_TYPE[$menu]==6 || $LMI_SDP_TYPE[$menu]==9 || $menu==14 || $menu==15)
		   		   	{
				   	echo '<input type="hidden" name="LMI_SDP_TYPE" value="'.$LMI_SDP_TYPE[$menu].'">';
			 	   	echo '<input type="hidden" name="LMI_ALLOW_SDP" value="'.$LMI_SDP_TYPE[$menu].'">';
				   	}

					echo '</form>';
					echo "</td>";
					echo "</tr>";
				echo "</td>";
				echo "</tr></table><br></form>";
				$nobutton=true;
		}
			elseif ($param==69)
			{
				echo "<table border=0>";
				echo "<tr><td>";
				echo "</td>";
				echo "<td>";
				echo "<input type=\"hidden\" name=\"amount_bil\" id=\"qbil\" value=\"1\" >";
				echo "</td>";
				echo "</tr><tr>";
				echo "<td align=right>";
				echo "</td>";
				echo "<td>";
				echo show_elka(true);
				echo "�����: <select name=\"traderid\" id=\"buketid\"  onChange='javascript: callbuket(".ceil($RUR).",1);  '  >";
							foreach ($leto_bukets as $k=>$v)
									{
									$ii++;
									echo '<option value="0:'.$_SESSION['bankid'].':'.$v.':'.$user['id'].'" ';
									if (buket_my_level_select($user)==$v) echo " selected ";
									echo $kcolor." >$k ( $bukets_prise[$v] ���.)</option>";
									}

						echo "  </select> <br>";

	if (buket_my_level_select($user)!=410021)
							{
							 echo "<script>
							 		document.getElementById(410021).style.display='none';
							 		document.getElementById(".buket_my_level_select($user).").style.display='block';
								</script>";
							 }



				echo '�����: <input name="LMI_PAYMENT_AMOUNT" value="'.(ceil($RUR)*10).'" size="8" id="qrub" readonly="readonly" > WMR ';
				echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
				echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">';
				echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="������� � ������� oldbk.com"  >';
				echo "</td>";
				echo "</tr></table><br><br>";
			}

	if ($nobutton!=true)
		{
		echo '<br><br><br>';

	   	if ($LMI_SDP_TYPE[$menu]==3 || $LMI_SDP_TYPE[$menu]==5 || $LMI_SDP_TYPE[$menu]==6 || $LMI_SDP_TYPE[$menu]==9 || $menu==14 || $menu==15) {
	   	 echo '<input type="hidden" name="LMI_SDP_TYPE" value="'.$LMI_SDP_TYPE[$menu].'">';
 	   	 echo '<input type="hidden" name="LMI_ALLOW_SDP" value="'.$LMI_SDP_TYPE[$menu].'">';
	   	 }

		echo '<input type="submit" value="��������" '.$add_js.' ><br>
		</form>';
//				 document.getElementById('pl').style.display = 'none';

		if ($hide_input) {
				 echo "</div>
				 <script>
				 document.frmw.submit();
				 setTimeout('location.reload()',1000);
				 </script>
				 ";}



		}

				echo '</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';
			}
		}
	else if ($menu==9) 		//���� - ������� ��� ����
	{
		echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';

		echo '<p><b><font color="red">�������� ������ ������: </font></b></p>';
		echo "<fieldset style=\"text-align:justify; width:500px; height:180px;\">";
		echo "<div align=center>";


		/* ������ ���� ������
		echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
		echo "<td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>";
		echo "</td></tr><tr><td>";
		echo "<a href=\"#\" onClick=\"getformdata(20,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(23,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
		echo "</td></tr></table>";
		*/

		// �� ���

		//echo "<a href=\"#\" onClick=\"getformdata(20,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa_k.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay

		echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
		echo "<td>";

		if ($OK_PAY_OFF!=true)
		{
		echo "<a href=\"#\" onClick=\"getformdata(45,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_yandex.gif title='�������� � ������� ������� \"Yandex ������\"' >";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(46,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_qiwi.gif title='�������� � ������� \"QIWI - �������\"' ></a>";
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(41,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"���\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(42,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_tele2.gif title='�������� � ������� \"Tele2\"'></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(43,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"Beeline\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(44,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_megafon.gif title='�������� � ������� \"�������\"' ></a>";
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(47,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(48,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
		echo "</td><td>";
		//echo "<a href=\"#\" onClick=\"getformdata(49,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"Visa & MasterCard\"' ></a>";
		//echo "<a href=\"#\" onClick=\"getformdata(23,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(20,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa_k.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(51,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_bitcoin.gif title='�������� � ������� \"Bitcoin\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(52,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_moneypolo.gif title='�������� � ������� ������� \"Money Polo\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(53,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_w1.gif title='�������� � ������� \"W1\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(54,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";
		echo "</td></tr></table>";
		}
		else
		{
		//�� ��� ��������
		echo "<a href=\"#\" onClick=\"getformdata(5,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' >"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(6,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_brs2.gif title='�������� � ������� \"������� ��������\"' ></a>";
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(7,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(8,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
		echo "</td><td>";
		//echo "<a href=\"#\" onClick=\"getformdata(23,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(20,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(14,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"��������� ��������� ���\"' ></a>"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(15,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"��������� ��������� ������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(10,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_vtb24.gif title='�������� � ������� \"���24\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(11,{$param},event);\"><img src=http://i.oldbk.com/i/bank/knopka_pochtarf.gif title='�������� � ������� \"����� ��\"' ></a>";
		echo "</td></tr></table>";

		}



		echo "</div>";
		echo "</fieldset>";


		echo '</td>
		</tr></table>
		</center>';
	}
	else if ($menu==99)  //������� �����
	{
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';

			echo '<p><b><font color="red">�������� ������ ������: </font></b></p>';
			echo "<fieldset style=\"text-align:justify; width:500px; height:180;\">";
			echo "<div align=center>";

			/* ������ ����
			echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
			echo "<td>";
			echo "<a href=\"#\" onClick=\"getformdata(4,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(2,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>";
			echo "</td></tr><tr><td>";
			echo "<a href=\"#\" onClick=\"getformdata(20,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(23,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
			echo "</td></tr></table>";
			*/

		// �� ���

		echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
		echo "<td>";

		if ($OK_PAY_OFF!=true)
		{
		echo "<a href=\"#\" onClick=\"getformdata(45,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_yandex.gif title='�������� � ������� ������� \"Yandex ������\"' >";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(46,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_qiwi.gif title='�������� � ������� \"QIWI - �������\"' ></a>";
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(41,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"���\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(42,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_tele2.gif title='�������� � ������� \"Tele2\"'></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(43,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"Beeline\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(44,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_megafon.gif title='�������� � ������� \"�������\"' ></a>";
		echo "</td></tr><tr><td>";


		echo "<a href=\"#\" onClick=\"getformdata(47,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(48,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
		echo "</td><td>";
		//echo "<a href=\"#\" onClick=\"getformdata(49,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"Visa & MasterCard\"' ></a>";
		//echo "<a href=\"#\" onClick=\"getformdata(23,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(20,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa_k.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(51,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_bitcoin.gif title='�������� � ������� \"Bitcoin\"' ></a>";
		echo "</td><td>";
		if ($OK_PAY_OFF!=true)	echo "<a href=\"#\" onClick=\"getformdata(52,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_moneypolo.gif title='�������� � ������� ������� \"Money Polo\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(53,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_w1.gif title='�������� � ������� \"W1\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(54,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";
		echo "</td></tr></table>";

		}
		else
		{
		//�� ��� ��������
		echo "<a href=\"#\" onClick=\"getformdata(5,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' >"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(6,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_brs2.gif title='�������� � ������� \"������� ��������\"' ></a>";
		echo "</td></tr><tr><td>";

		echo "<a href=\"#\" onClick=\"getformdata(7,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(8,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
		echo "</td><td>";
		//echo "<a href=\"#\" onClick=\"getformdata(23,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(20,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";


		echo "<a href=\"#\" onClick=\"getformdata(14,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"��������� ��������� ���\"' ></a>"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(15,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"��������� ��������� ������\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(10,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_vtb24.gif title='�������� � ������� \"���24\"' ></a>";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(11,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_pochtarf.gif title='�������� � ������� \"����� ��\"' ></a>";
		echo "</td></tr></table>";

		}



			echo "</div>";
			echo "</fieldset>";

			echo '</td>
			</tr></table>
			</center>';
		}
		else if ( ( $menu==87 || $menu==88 || $menu==69 ) AND ($param==0)  ) // ������� ����� - ���������
		{
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';

			echo '<p><b><font color="red">�������� ������ ������: </font></b></p>';
			echo "<fieldset style=\"text-align:justify; width:500px; height:180;\">";
			echo "<div align=center>";

			/* ������ ����

			echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
			echo "<td>";
			echo "<a href=\"#\" onClick=\"getformdata(4,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(2,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>";
			echo "</td></tr><tr><td>";
			echo "<a href=\"#\" onClick=\"getformdata(20,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(23,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
			echo "</td></tr></table>";
			*/

			// �� ���

			echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
			echo "<td>";

			if ($OK_PAY_OFF!=true)
			{
			echo "<a href=\"#\" onClick=\"getformdata(45,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_yandex.gif title='�������� � ������� ������� \"Yandex ������\"' >";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(4,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(2,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(46,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_qiwi.gif title='�������� � ������� \"QIWI - �������\"' ></a>";
			echo "</td></tr><tr><td>";

			echo "<a href=\"#\" onClick=\"getformdata(41,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"���\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(42,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_tele2.gif title='�������� � ������� \"Tele2\"'></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(43,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"Beeline\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(44,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_megafon.gif title='�������� � ������� \"�������\"' ></a>";
			echo "</td></tr><tr><td>";


			echo "<a href=\"#\" onClick=\"getformdata(47,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(48,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
			echo "</td><td>";
			//echo "<a href=\"#\" onClick=\"getformdata(49,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"Visa & MasterCard\"' ></a>";
			//echo "<a href=\"#\" onClick=\"getformdata(23,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(20,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa_k.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
			echo "</td></tr><tr><td>";

			echo "<a href=\"#\" onClick=\"getformdata(51,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_bitcoin.gif title='�������� � ������� \"Bitcoin\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(52,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_moneypolo.gif title='�������� � ������� ������� \"Money Polo\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(53,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_w1.gif title='�������� � ������� \"W1\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(54,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";
			echo "</td></tr></table>";
			}
			else
			{
			//�� ��� ��������
			echo "<a href=\"#\" onClick=\"getformdata(5,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' >"; //wmr
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(4,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(2,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(6,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_brs2.gif title='�������� � ������� \"������� ��������\"' ></a>";
			echo "</td></tr><tr><td>";

			echo "<a href=\"#\" onClick=\"getformdata(7,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(8,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";
			echo "</td><td>";
			//echo "<a href=\"#\" onClick=\"getformdata(23,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(20,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
			echo "</td></tr><tr><td>";


			echo "<a href=\"#\" onClick=\"getformdata(14,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"��������� ��������� ���\"' ></a>"; //wmr
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(15,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"��������� ��������� ������\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(10,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_vtb24.gif title='�������� � ������� \"���24\"' ></a>";
			echo "</td><td>";
			echo "<a href=\"#\" onClick=\"getformdata(11,{$menu},event);\"><img src=http://i.oldbk.com/i/bank/knopka_pochtarf.gif title='�������� � ������� \"����� ��\"' ></a>";
			echo "</td><td>";
			echo "</td></tr></table>";

			}


			echo "</div>";
			echo "</fieldset>";

			echo '</td>
			</tr></table>
			</center>';
		}
////////////////////
else if ($menu==23)
		{
		$gold_val=200;
		$ekr_val=10;
		$rep_val=6000;
		$hide_input=false;

		if ($dopp==1) { $gold_val=$param; $param=87; $hide_input=true; }
			elseif ($dopp==2) { $ekr_val=$param; $param=0; $hide_input=true; }
			elseif ($dopp==3) { $rep_val=$param; $param=300;  $hide_input=true; }




			$usd_kurs+=0.06;
			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';

			if ($hide_input) { echo "<div style=\"display:none;\">";}

			if ($param==0)	{ echo '<p><b><font color="red">������ ��� � ������� PayPal: </font></b><br><small>(����������� ����� ������ ����� Paypal ���������� 10$)</small></p>' ; }
			else { echo '<p><b><font color="red">�������� � ������� PayPal: </font><br><small>(����������� ����� ������ ����� Paypal ���������� 10$)</small></b></p>' ; }
			echo '
				<table>
					<tr>
						<td align="right"></td>
						<td>';



		if ($param!=88) echo '<form name=frmp method="post" action="bank.php"  target=_blank>';

 		if ($param==0)
 		{
 		if ($usd_kurs)
 			{
	 		echo '<input type="hidden" name="paypal_type" value="1">'; // ��� 1 ���������� �����
	 		echo '<input type="hidden" name="paypal_param" value="0">'; // ������������
			echo '&nbsp;&nbsp;�����: <input name="paypal_amount" value="'.round($ekr_val*$usd_kurs,2).'" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> USD ';
			echo '<br><small><b> 1  ���. = '.$usd_kurs.'USD </b></small><br><br><br>';
			echo '�� ����: <input type=text id=ekwmz size="8" value="'.$ekr_val.'" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';
			}
		}
		else if ($param==300)
		{
	 		echo '<input type="hidden" name="paypal_type" value="3">'; // ���  3 ������� ���������
	 		echo '<input type="hidden" name="paypal_param" value="'.$param.'">'; // ��� ���������
			echo '&nbsp;&nbsp;�����: <input name="paypal_amount" value="'.round(($rep_val/600)*$usd_kurs,2).'" size="8"> USD';
			echo '<br><small><b> '.$usd_kurs.' USD = 600 ���. </b> </small><br><br><br>';
		}
		elseif ($param==87)
		{

	 		echo '<input type="hidden" name="paypal_type" value="87">';
	 		echo '<input type="hidden" name="paypal_param" value="88000">';
			echo '����������: <input type=text name="amount_bil" id=awmz value="'.$gold_val.'" size="8" onChange=\'javascript: callcwmz(this.value,'.$coins_kurs/$usd_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$coins_kurs/$usd_kurs.');"> �����. <br>';
			echo '<br><small><b> 20 ����� ='.$usd_kurs.' USD </b></small><br><br><br>';
			echo '&nbsp;&nbsp;�����: <input type=text name="paypal_amount" value="'.round(($gold_val*$usd_kurs)/$coins_kurs,2).'" id=ekwmz onChange=\'javascript: callcgold(this.value,'.$coins_kurs/$usd_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcgold(this.value,'.$coins_kurs/$usd_kurs.');">';
			echo "<br><small><b>* ���������� 200 �����.</b></small>";
			$add_js=" onClick=\"if (document.getElementById('awmz').value<200) { alert('���������� ��� ������� 200 �����!'); return false; } else { return true;  } \" ";
		}
		elseif ($param==88)
		{
			//������� ����� �� paypal
				echo "<table border=0 >";
					echo "<tr height='90'><td style='background-image: url(\"http://i.oldbk.com/i/bank/fon.gif\"); background-repeat: no-repeat; background-position: center;'  valign='bottom' width='115' height='90' ><img src='http://i.oldbk.com/i/bank/coin_fon.gif' alt='200 �����' title='200 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>200 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_10.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/purse_fon.gif' alt='500 �����' title='500 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>500 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_30.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/chiest_fon.gif' alt='1000 �����' title='1000 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 15px; top: -15px;'>1000 �����</span>";
					echo "</td>";
					echo "</tr>";
					echo "<tr><td align=center>";

					echo '<form method="post" action="bank.php"  target=_blank>';
			 		echo '<input type="hidden" name="paypal_type" value="88">'; // ���  88 �������
			 		echo '<input type="hidden" name="paypal_param" value="88200">'; // ��� ���������
					echo '<input type="hidden" name="amount_bil" id="qbil" value="200">';
					echo '<input type=hidden name="paypal_amount" value="'.round(10*$usd_kurs).'">'; //					 200 ����� = 10$
					echo '<input type="submit" value="������ �� '.round(10*$usd_kurs).' USD" >';
					echo '</form>';

					echo "</td>";
					echo "<td align=center>";

					echo '<form method="post" action="bank.php"  target=_blank>';
			 		echo '<input type="hidden" name="paypal_type" value="88">'; // ���  88 �������
			 		echo '<input type="hidden" name="paypal_param" value="88500">'; // ��� ���������
					echo '<input type="hidden" name="amount_bil" id="qbil" value="500">';
					echo '<input type=hidden name="paypal_amount" value="'.round(22.5*$usd_kurs).'">';  // 500 ����� (-10% ������) = 22,5$
					echo '<input type="submit" value="������ �� '.round(22.5*$usd_kurs).' USD" >';
					echo '</form>';


					echo "</td>";
					echo "<td align=center>";

					echo '<form method="post" action="bank.php"  target=_blank>';
			 		echo '<input type="hidden" name="paypal_type" value="88">'; // ���  88 �������
			 		echo '<input type="hidden" name="paypal_param" value="881000">'; // ��� ���������
					echo '<input type="hidden" name="amount_bil" id="qbil" value="1000">';
					echo '<input type=hidden name="paypal_amount" value="'.round(35*$usd_kurs).'">';   // 1000 ����� (-30% ������) = 35$
					echo '<input type="submit" value="������ �� '.round(35*$usd_kurs).' USD" >';
					echo '</form>';

					echo "</td>";
					echo "</tr>";
				echo "</td>";
				echo "</tr></table><br></form>";
				$nobutton=true;
		}
		elseif ($param==69)
			{
				echo "<table border=0>";
				echo "<tr><td>";
				echo "</td>";
				echo "<td>";
				echo "<input type=\"hidden\" name=\"amount_bil\" id=\"qbil\" value=\"1\" >";
				echo "</td>";
				echo "</tr><tr>";


				echo "<td align=right>";

				echo "</td>";
				echo "<td>";

		 		echo '<input type="hidden" name="paypal_type" value="18">'; // ���  ������

				echo show_elka(true);
				echo "�����: <select name=\"paypal_param\" id=\"buketid\"  onChange='javascript: callbuket({$usd_kurs},0)'  >";


							foreach ($leto_bukets as $k=>$v)
									{
									$ii++;
									echo '<option value="'.$v.'" ';
									if (buket_my_level_select($user)==$v) echo " selected ";
									echo $kcolor." >$k </option>";
									}

						echo "  </select> <br>";

	if (buket_my_level_select($user)!=410021)
							{
							 echo "<script>
							 		document.getElementById(410021).style.display='none';
							 		document.getElementById(".buket_my_level_select($user).").style.display='block';
								</script>";
							 }


				echo '�����: <input name="paypal_amount" value="11" size="8" id="qrub" readonly="readonly" > USD ';
				echo "</td>";
				echo "</tr></table><br><br>";
			}



		if ($nobutton!=true)
		{
			echo '<div align=center><input type="submit" value="��������" '.$add_js.'></center><br><br></form>';


		if ($hide_input) {
				 echo "</div>
				 <script>
				 document.frmp.submit();
				 setTimeout('location.reload()',1000);
				 </script>
				 ";}

		}

		echo '

						</td>
						<td align="right">
						</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';
	}
	else if (($menu==20) OR ($menu==21))
		{
		$gold_val=20;
		$ekr_val=1;
		$rep_val=1000;
		$hide_input=false;

		if ($dopp==1) { $gold_val=$param; $param=87; $hide_input=true; }
			elseif ($dopp==2) { $ekr_val=$param; $param=0; $hide_input=true; }
			elseif ($dopp==3) { $rep_val=$param; $param=300;  $hide_input=true; }
			elseif ($dopp==4) { $b_val=65; $param=2018;  $hide_input=true; }
			elseif ($dopp==5) { $b_val=70; $param=2118;  $hide_input=false; }

			echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';

			if ($hide_input) { echo "<div style=\"display:none;\">";}

			if ($param==0)	{ echo '<p><b><font color="red">������ ��� � ������� LiqPay: </font></b></p>' ; }
			else { echo '<p><b><font color="red">�������� � ������� LiqPay: </font></b></p>' ; }
			echo '
				<table>
					<tr>
						<td align="right"></td>
						<td>';

		 if ($param!=88) echo '<form method="post" name=frml action="bank.php" target= _blank >';

 		if ($menu==21)  echo '<input type="hidden" name="liqpay_privat" value="1">';

 		if ($param==0)
 		{

 		if ($usd_kurs)
 			{
	 		echo '<input type="hidden" name="liqpay_type" value="1">'; // ��� 1 ���������� �����
	 		echo '<input type="hidden" name="liqpay_param" value="0">'; // ������������
			echo '&nbsp;&nbsp;�����: <input name="liqpay_amount" value="'.round($ekr_val*$usd_kurs,2).'" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> USD ';
			echo '<br><small><b> 1  ���. = '.$usd_kurs.'USD </b></small><br><br><br>';
			echo '�� ����: <input type=text id=ekwmz size="8" value="'.$ekr_val.'" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';
			}
		}
		else if ($param==300)
		{
	 		echo '<input type="hidden" name="liqpay_type" value="3">'; // ���  3 ������� ���������
	 		echo '<input type="hidden" name="liqpay_param" value="'.$param.'">'; // ��� ���������
			echo '&nbsp;&nbsp;�����: <input name="liqpay_amount" value="'.round($rep_val/600*$usd_kurs,2).'" size="8"> USD';
			echo '<br><small><b> '.$usd_kurs.' USD = 600 ���. </b> </small><br><br><br>';
		}
		else if ($param==2018)
		{
	 		echo '<input type="hidden" name="liqpay_type" value="2018">';
	 		echo '<input type="hidden" name="liqpay_param" value="'.$param.'">'; // ��� ���������
			echo '<input type="hidden" name="liqpay_amount" value="'.ceil($b_val*$usd_kurs).'" size="8">';

		}
		else if ($param==2118)
		{
	 		echo '<input type="hidden" name="liqpay_type" value="2018">'; // ���  3 ������� ���������

			echo '�������� ������ ��������: <select name="liqpay_type">';
			echo '<option value="1" selected> S </option>';
			echo '<option value="2"> M </option>';
			echo '<option value="3"> L </option>';
			echo '<option value="4"> XL </option>';
			echo '<option value="5"> XXL </option>';
			echo "  </select> <br>";

	 		echo '<input type="hidden" name="liqpay_param" value="'.$param.'">'; // ��� ���������
			echo '<input type="hidden" name="liqpay_amount" value="'.ceil($b_val*$usd_kurs).'" size="8">';

		}
		elseif ($param==87)
		{
	 		echo '<input type="hidden" name="liqpay_type" value="87">';
	 		echo '<input type="hidden" name="liqpay_param" value="88000">';
			echo '����������: <input type=text name="amount_bil" id=awmz value="'.$gold_val.'" size="8" onChange=\'javascript: callcwmz(this.value,'.$coins_kurs/$usd_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$coins_kurs/$usd_kurs.');"> �����. <br>';
			echo '<br><small><b> 20 ����� ='.$usd_kurs.' USD </b></small><br><br><br>';
			echo '&nbsp;&nbsp;�����: <input type=text name="liqpay_amount" value="'.round(($gold_val*$usd_kurs)/$coins_kurs,2).'" id=ekwmz onChange=\'javascript: callcgold(this.value,'.$coins_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcgold(this.value,'.$coins_kurs.');">';
			echo "<br><small><b>* ���������� 20 �����.</b></small>";
			$add_js=" onClick=\"if (document.getElementById('awmz').value<20) { alert('���������� ��� ������� 20 �����!'); return false; } else { return true;  } \" ";
		}
		elseif ($param==88)
		{
			//������� ����� �� liqpay
				echo "<table border=0 >";
					echo "<tr height='90'><td style='background-image: url(\"http://i.oldbk.com/i/bank/fon.gif\"); background-repeat: no-repeat; background-position: center;'  valign='bottom' width='115' height='90' ><img src='http://i.oldbk.com/i/bank/coin_fon.gif' alt='100 �����' title='100 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>100 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_10.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/purse_fon.gif' alt='500 �����' title='500 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>500 �����</span>";
					echo "</td>";
					echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_30.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/chiest_fon.gif' alt='1000 �����' title='1000 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 15px; top: -15px;'>1000 �����</span>";
					echo "</td>";
					echo "</tr>";
					echo "<tr><td align=center>";

					echo '<form method="post" action="bank.php"  target=_blank>';
			 		echo '<input type="hidden" name="liqpay_type" value="88">'; // ���  88 �������
			 		echo '<input type="hidden" name="liqpay_param" value="88100">'; // ��� ���������
					echo '<input type="hidden" name="amount_bil" id="qbil" value="100">';
					echo '<input type=hidden name="liqpay_amount" value="'.round(5*$usd_kurs).'">'; //					 100 ����� = 5$
					echo '<input type="submit" value="������ �� '.round(5*$usd_kurs).' USD" >';
					echo '</form>';

					echo "</td>";
					echo "<td align=center>";

					echo '<form method="post" action="bank.php"  target=_blank>';
			 		echo '<input type="hidden" name="liqpay_type" value="88">'; // ���  88 �������
			 		echo '<input type="hidden" name="liqpay_param" value="88500">'; // ��� ���������
					echo '<input type="hidden" name="amount_bil" id="qbil" value="500">';
					echo '<input type=hidden name="liqpay_amount" value="'.round(22.5*$usd_kurs).'">';  // 500 ����� (-10% ������) = 22,5$
					echo '<input type="submit" value="������ �� '.round(22.5*$usd_kurs).' USD" >';
					echo '</form>';


					echo "</td>";
					echo "<td align=center>";

					echo '<form method="post" action="bank.php"  target=_blank>';
			 		echo '<input type="hidden" name="liqpay_type" value="88">'; // ���  88 �������
			 		echo '<input type="hidden" name="liqpay_param" value="881000">'; // ��� ���������
					echo '<input type="hidden" name="amount_bil" id="qbil" value="1000">';
					echo '<input type=hidden name="liqpay_amount" value="'.round(35*$usd_kurs).'">';   // 1000 ����� (-30% ������) = 35$
					echo '<input type="submit" value="������ �� '.round(35*$usd_kurs).' USD" >';
					echo '</form>';

					echo "</td>";
					echo "</tr>";
				echo "</td>";
				echo "</tr></table><br></form>";
				$nobutton=true;
		}
		elseif ($param==69)
			{
				echo "<table border=0>";
				echo "<tr><td>";
				echo "</td>";
				echo "<td>";
				echo "<input type=\"hidden\" name=\"amount_bil\" id=\"qbil\" value=\"1\" >";
				echo "</td>";
				echo "</tr><tr>";


				echo "<td align=right>";
				echo "</td>";
				echo "<td>";

		 		echo '<input type="hidden" name="liqpay_type" value="18">'; // ���  ������� ����

				echo show_elka(true);
				echo "�����: <select name=\"liqpay_param\" id=\"buketid\"  onChange='javascript: callbuket(1,0)'  >";


							foreach ($leto_bukets as $k=>$v)
									{
									$ii++;
									echo '<option value="'.$v.'" ';
									if (buket_my_level_select($user)==$v) echo " selected ";
									echo $kcolor." >$k </option>";

									}

						echo "  </select> <br>";

	if (buket_my_level_select($user)!=410021)
							{
							 echo "<script>
							 		document.getElementById(410021).style.display='none';
							 		document.getElementById(".buket_my_level_select($user).").style.display='block';
								</script>";
							 }




				echo '�����: <input name="liqpay_amount" value="10" size="8" id="qrub" readonly="readonly" > USD ';
				echo "</td>";
				echo "</tr></table><br><br>";
			}


		if ($nobutton!=true)
		{
		echo '<div align=center><input type="submit" value="��������" '.$add_js.'></center><br><br>
		</form>';

		if ($hide_input) {
				 echo "</div>
				 <script>
				 document.frml.submit();
				 setTimeout('location.reload()',1000);
				 </script>
				 ";}

		}

		echo '

						</td>
						<td align="right">
						</td>
					</tr>
				</table>
		</td>
		</tr></table>
		</center>';
	}
	else if ($menu==22)
	{
	//qiwi - new
		$gold_val=20;
		$ekr_val=1;
		$rep_val=1000;
		$hide_input=false;

		if ($dopp==1) { $gold_val=$param; $param=87; }
			elseif ($dopp==2) { $ekr_val=$param; $param=0; }
			elseif ($dopp==3) { $rep_val=(int)$param; $param=300; }

				echo '<center>
			<table border=0 bgcolor=#eeeeee width="100%" height="100%" align="center">
			<tr valign="top"  align="center" >
			<td align="center">';
			if ($param==0)	{ echo '<p><b><font color="red">������ ��� � ������� QIWI: </font></b><br><small>*���� ������������ ������������� ����� 60 �����</small></p>'; }
			else { echo '<p><b><font color="red">������ � ������� QIWI: </font><br><small>*���� ������������ ������������� ����� 60 �����</small></b></p>'; }
			echo '<table>
					<tr>
						<td align="right"></td>
						<td>';


			echo '<form  action="bank.php" method="post" accept-charset="windows-1251" name="fqiw" onSubmit="return checkSubmit();">
			<input type="hidden" name="from" value="299509"/>
			<input type="hidden" name="lifetime" value="0.0"/>
			<input type="hidden" name="check_agt" value="false"/>
			<input type="hidden" name="com" value="�������  ��� ��������� '.$user['login'].'"/>';


    		$RUR=get_rur_curs();

		echo '
		<table style="border-collapse:collapse;">
			<tr >
				<td style="width:55%; text-align:center; padding:20px 0px;">��������� �������: +7</td>
				<td style="padding:10px">
					<input type="text" name="to" id="idto" style="width:130px; border: 1px inset #555;" onkeyup="this.value=this.value.replace(/[^\d]/,\'\');" maxlength=10 ></input>
					<span id="div_idto"></span>

    			</td>
			</tr>';

			if ($param==0)
			 {
			echo '
			<tr>
				<td style="padding:10px">
					<input type="hidden" name="amount_ekr" id="qekr" value="'.$ekr_val.'" maxlength="5" style="width:50px; text-align:right;  border: 1px inset #555;" >�� ����: <b>'.$ekr_val.' ���.</b>
				</td>
			</tr>';
			echo '
			<tr>
				<td style="padding:10px">
					<input type="hidden" name="amount_rub" id="qrub" value="'.(round($ekr_val*$RUR)).'" maxlength="5" style="width:50px; text-align:right;  border: 1px inset #555;"> � ������: <b>'.(round($ekr_val*$RUR)).' ���. </b>
				</td>
			</tr>';

			 }
			else if (($param==300) )
			{
			//��������� �� ����

			echo '
			<tr>
				<td style="padding:10px">
					<input type="hidden" name="amount_rep" value="'.$rep_val.'">
					<input type="hidden" name="param" value="'.$param.'">
					�� ����: <b>'.$rep_val.' ���.</b>
				</td>
			</tr>';

	 		echo '
			<tr>
				<td style="padding:10px">
					<input type="hidden" name="amount_rub" id="qrub" value="'.(round(($rep_val/600)*$RUR)+1).'" maxlength="5" style="width:50px; text-align:right;  border: 1px inset #555;"> � ������: <b>'.(round(($rep_val/600)*$RUR)+1).' ���. </b>
				</td>
			</tr>';

			echo "<br><small><b>* ���������� 600 ���������.</b></small>";
			$add_js=" onClick=\"if (document.getElementById('awmz').value<600) { alert('���������� ��� ������� 600 ���������!'); return false; } else { return true;  } \" ";

			}
			else if ($param==87)
			{
			//������� ����� �� ����
			echo '
			<tr>
				<td style="padding:10px">
					<input type="hidden" name="amount_rep" value="'.$rep_val.'">
					<input type="hidden" name="param" value="88000">
					<input type="hidden" name="amount_bil" id=awmz value="'.$gold_val.'" >
					�� ����: <b>'.$gold_val.' �����.</b>
				</td>
			</tr>';

	 		echo '
			<tr>
				<td style="padding:10px">
					<input type="hidden" name="amount_rub" id="qrub" value="'.(round(($gold_val/$coins_kurs)*$RUR)+1).'" maxlength="5" style="width:50px; text-align:right;  border: 1px inset #555;"> � ������: <b>'.(round(($gold_val/$coins_kurs)*$RUR)+1).' ���. </b>
				</td>
			</tr>';
			echo "<br><small><b>* ���������� 20 �����.</b></small>";
			$add_js=" onClick=\"if (document.getElementById('awmz').value<20) { alert('���������� ��� ������� 20 �����!'); return false; } else { return true;  } \" ";
			 }
			 else
			 {
			 $nobutton=true;

			 echo '
			<tr>
				<td style="padding:10px">
					<b>������! </b>
				</td>
			</tr>';

			 }




			echo '</table>';

			if ($nobutton!=true)
			{
			echo '<div align=center><input type="submit" name="qiwimkbill" value="��������� ���� �� �������" '.$add_js.' /></div>';
			}
			echo '</form>';




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


			if ($param==0)	{ echo '<p><b><font color="red">������ ��� � ������� '.$STRNAME.': </font></b></p>' ; }
			else { echo '<p><b><font color="red">�������� � ������� '.$STRNAME.': </font></b></p>' ; }


			echo '
				<table>
					<tr>
						<td align="right"></td>
						<td>';
 		if ($usd_kurs)
 			{

			if ($param!=88)
 			{
			echo '<form method="post" action="bank.php" target=_blank>';
	 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
	 		}




			 		if ($param==0)
				 		{

						$start_usd=1;
						$start_rub=$start_usd*$RUR;

							 if ($menu==45)
							 	{
	 							$start_usd=15;
								$start_rub=$start_usd*$RUR;
							 	}


				 				if ($CTYPE=='USD')
				 					{
							 		echo '<input type="hidden" name="okpay_type" value="1">'; // ��� 1 ���������� �����
							 		echo '<input type="hidden" name="okpay_param" value="0">'; // ������������
									echo '&nbsp;&nbsp;�����: <input name="okpay_amount" id="okpay_amount"  value="'.$start_usd.'" size="8" id=awmz onChange=\'javascript: callcwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$usd_kurs.');"> USD ';
									echo '<br><small><b> 1  ���. = '.$usd_kurs.'USD </b></small><br><br><br>';
									echo '�� ����: <input type=text id=ekwmz value="'.$start_usd.'" size="8" onChange=\'javascript: callcekrwmz(this.value,\''.$usd_kurs.'\')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcekrwmz(this.value,'.$usd_kurs.');"> ���. ';

									$add_js=" onClick=\"if (document.getElementById('okpay_amount').value<{$start_usd}) { alert('����������� ����� ������� {$start_usd} usd.!'); return false; } else { closeinfo();return true;  } \" ";
									}
									elseif ($CTYPE=='RUB')
									{
							 		echo '<input type="hidden" name="okpay_type" value="1">'; // ��� 1 ���������� �����
							 		echo '<input type="hidden" name="okpay_param" value="0">'; // ������������
									echo '&nbsp;&nbsp;�����: <input name="okpay_amount" id="wmrrub"  value="'.$start_rub.'" size="8" onChange=\'javascript: callcekrwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcekrwmr(this.value,'.$RUR.');"> ���. ';
									echo '<br><small><b> 1  ���. = '.$RUR.'���. </b></small><br><br><br>';
									echo '�� ����: <input type=text id=wmrekr value="'.$start_usd.'" size="8" onChange=\'javascript: callcrubwmr(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcrubwmr(this.value,'.$RUR.');"> ���. ';
									$add_js=" onClick=\"if (document.getElementById('wmrrub').value<{$start_rub}) { alert('����������� ����� ������� {$start_rub} ���.!'); return false; } else { closeinfo();return true;  } \" ";
									}

						}
						else if ($param==300)
						{

						$start=600;
						$start_usd=1;
						$start_rub=$start_usd*$RUR;
							 if ($menu==45)
							 	{
	 							$start=9000;
	 							$start_usd=15;
								$start_rub=$start_usd*$RUR;
							 	}

									if ($CTYPE=='USD')
				 					{
							 		echo '<input type="hidden" name="okpay_type" value="3">'; // ���  3 ������� ���������
							 		echo '<input type="hidden" name="okpay_param" value="'.$param.'">'; // ��� ���������
									echo '&nbsp;&nbsp;�����: <input name="okpay_amount"   value="'.$start_usd.'" size="8" id=qrub onChange=\'javascript: callcrep(this.value,'.$usd_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcrep(this.value,'.$usd_kurs.');"> USD. ';
									echo '<br><small><b> '.$usd_kurs.' USD = 600 ���. </b> </small><br><br>';
									echo '��������: <input type=text id=qrep value="'.$start.'" size="8" onChange=\'javascript: callcrubrep(this.value,'.$usd_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcrubrep(this.value,\''.$usd_kurs.'\')"  > ���. ';
									$add_js=" onClick=\"if (document.getElementById('okpay_amount').value<{$start_usd}) { alert('����������� ����� ������� {$start_usd} usd.!'); return false; } else { closeinfo();return true;  } \" ";
									}
									elseif ($CTYPE=='RUB')
									{
							 		echo '<input type="hidden" name="okpay_type" value="3">'; // ���  3 ������� ���������
							 		echo '<input type="hidden" name="okpay_param" value="'.$param.'">'; // ��� ���������
									echo '&nbsp;&nbsp;�����: <input name="okpay_amount" id="qrub"  value="'.$start_rub.'" size="8" id=qrub onChange=\'javascript: callcrep(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcrep(this.value,'.$RUR.');"> ���. ';
									echo '<br><small><b> '.$RUR.' ���. = 600 ���. </b> </small><br><br>';
									echo '��������: <input type=text id=qrep value="'.$start.'" size="8" onChange=\'javascript: callcrubrep(this.value,'.$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcrubrep(this.value,\''.$RUR.'\')"   > ���. ';
									$add_js=" onClick=\"if (document.getElementById('qrub').value<{$start_rub}) { alert('����������� ����� ������� {$start_rub} ���.!'); return false; } else { closeinfo();return true;  } \" ";
									}
						}
						elseif ($param==87)
						{
						$start=20;
						$start_usd=1;
						$start_rub=$start_usd*$RUR;
							 if ($menu==45)
							 	{
							 	$start=300;
	 							$start_usd=15;
 								$start_rub=$start_usd*$RUR;
							 	}


				 		echo '<input type="hidden" name="okpay_type" value="87">';
				 		echo '<input type="hidden" name="okpay_param" value="88000">';

								if ($CTYPE=='USD')
				 					{
									echo '����������: <input type=text name="amount_bil" id=awmz value="'.$start.'" size="8" onChange=\'javascript: callcwmz(this.value,'.$coins_kurs/$usd_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$coins_kurs/$usd_kurs.');"> �����. <br>';
									echo '<br><small><b> 20 ����� ='.$usd_kurs.' USD. </b></small><br><br><br>';
									echo '&nbsp;&nbsp;�����: <input name="okpay_amount"  value="'.($usd_kurs*$start_usd).'" size="8" id=ekwmz onChange=\'javascript: callcgold(this.value,'.$coins_kurs.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcgold(this.value,'.$coins_kurs.');"> USD.';
									}
									elseif ($CTYPE=='RUB')
									{
									echo '����������: <input type=text name="amount_bil" id=awmz value="'.$start.'" size="8" onChange=\'javascript: callcwmz(this.value,'.$coins_kurs/$RUR.')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcwmz(this.value,'.$coins_kurs/$RUR.');"> �����. <br>';
									echo '<br><small><b> 20 ����� ='.$RUR.' ���. </b></small><br><br><br>';
									echo '&nbsp;&nbsp;�����: <input name="okpay_amount"  value="'.($usd_kurs*$start_rub).'" size="8" id=ekwmz onChange=\'javascript: callcgold(this.value,'.($coins_kurs/$RUR).')\';  onkeyup="this.value=this.value.replace(/[^\d\.]/,\'\'); callcgold(this.value,'.($coins_kurs/$RUR).');"> ���.';
									}


						 if ($menu==45)
						 		{
	 								echo "<br><small><b>* ���������� 300 �����.</b></small>";
						 			$add_js=" onClick=\"if (document.getElementById('awmz').value<300) { alert('���������� ��� ������� 300 �����!'); return false; } else { closeinfo();return true;  } \" ";
						 		}
						 		else
						 		{
 								echo "<br><small><b>* ���������� 20 �����.</b></small>";
								$add_js=" onClick=\"if (document.getElementById('awmz').value<20) { alert('���������� ��� ������� 20 �����!'); return false; } else { closeinfo();return true;  } \" ";
						 		}
						}
						elseif ($param==88)
						{
						//������ �����
								if ($CTYPE=='USD')
								{
								//������� ����� �� ����� - �����
									echo "<table border=0 >";
										echo "<tr height='90'><td style='background-image: url(\"http://i.oldbk.com/i/bank/fon.gif\"); background-repeat: no-repeat; background-position: center;'  valign='bottom' width='115' height='90' ><img src='http://i.oldbk.com/i/bank/coin_fon.gif' alt='100 �����' title='100 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>100 �����</span>";
										echo "</td>";
										echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_10.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/purse_fon.gif' alt='500 �����' title='500 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>500 �����</span>";
										echo "</td>";
										echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_30.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/chiest_fon.gif' alt='1000 �����' title='1000 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 15px; top: -15px;'>1000 �����</span>";
										echo "</td>";
										echo "</tr>";
										echo "<tr><td align=center>";

										echo '<form method="post" action="bank.php" target=_blank>';
								 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
								 		echo '<input type="hidden" name="okpay_type" value="88">';
								 		echo '<input type="hidden" name="okpay_param" value="88100">';
										echo '<input type="hidden" name="amount_bil" id="qbil" value="100">';
										echo '<input type="hidden" name="okpay_amount" value="'.round(5*$usd_kurs).'">'; //	 100 ����� = 5$
										echo '<input type="submit" value="������ �� '.round(5*$usd_kurs).' USD" >';
										echo '</form>';

										echo "</td>";
										echo "<td align=center>";

										echo '<form method="post" action="bank.php" target=_blank>';
								 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
								 		echo '<input type="hidden" name="okpay_type" value="88">';
								 		echo '<input type="hidden" name="okpay_param" value="88500">';
										echo '<input type="hidden" name="amount_bil" id="qbil" value="500">';
										echo '<input type="hidden" name="okpay_amount" value="'.round(22.5*$usd_kurs).'">';  // 500 ����� (-10% ������) = 22,5$
										echo '<input type="submit" value="������ �� '.round(22.5*$usd_kurs).' USD" >';
										echo '</form>';


										echo "</td>";
										echo "<td align=center>";

										echo '<form method="post" action="bank.php" target=_blank>';
								 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
								 		echo '<input type="hidden" name="okpay_type" value="88">';
								 		echo '<input type="hidden" name="okpay_param" value="881000">';
								 		echo '<input type="hidden" name="amount_bil" id="qbil" value="1000">';
										echo '<input type="hidden" name="okpay_amount" value="'.round(35*$usd_kurs).'">';   // 1000 ����� (-30% ������) = 35$
										echo '<input type="submit" value="������ �� '.round(35*$usd_kurs).' USD" >';
										echo '</form>';

										echo "</td>";
										echo "</tr>";
									echo "</td>";
									echo "</tr></table><br></form>";
									$nobutton=true;
								}
								elseif ($CTYPE=='RUB')
								{
									//������� ����� �� ����� - �����
										echo "<table border=0 >";
											echo "<tr height='90'><td style='background-image: url(\"http://i.oldbk.com/i/bank/fon.gif\"); background-repeat: no-repeat; background-position: center;'  valign='bottom' width='115' height='90' ><img src='http://i.oldbk.com/i/bank/coin_fon.gif' alt='100 �����' title='100 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>100 �����</span>";
											echo "</td>";
											echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_10.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/purse_fon.gif' alt='500 �����' title='500 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 20px; top: -15px;'>500 �����</span>";
											echo "</td>";
											echo "<td style='background-image: url(\"http://i.oldbk.com/i/bank/fon_30.gif\"); background-repeat: no-repeat; background-position: center;' valign='bottom'  width='115' height='90'><img src='http://i.oldbk.com/i/bank/chiest_fon.gif' alt='1000 �����' title='1000 �����'><span style='color: red; font-size: 13px; font-weight:bold; position: relative; left: 15px; top: -15px;'>1000 �����</span>";
											echo "</td>";
											echo "</tr>";
											echo "<tr><td align=center>";

											echo '<form method="post" action="bank.php" target=_blank>';
									 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
									 		echo '<input type="hidden" name="okpay_type" value="88">';
									 		echo '<input type="hidden" name="okpay_param" value="88100">';
											echo '<input type="hidden" name="amount_bil" id="qbil" value="100">';
											echo '<input type="hidden" name="okpay_amount" value="'.(ceil($RUR*5)).'" >'; //			 100 ����� = 5$
											echo '<input type="submit" value="������ �� '.(ceil($RUR*5)).'���." >';
											echo '</form>';

											echo "</td>";
											echo "<td align=center>";
											echo '<form method="post" action="bank.php" target=_blank>';
									 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
									 		echo '<input type="hidden" name="okpay_type" value="88">';
									 		echo '<input type="hidden" name="okpay_param" value="88500">';
											echo '<input type="hidden" name="amount_bil" id="qbil" value="500">';
											echo '<input type="hidden" name="okpay_amount" value="'.(ceil($RUR*22.5)).'" >';  // 500 ����� (-10% ������) = 22,5$
											echo '<input type="submit" value="������ �� '.(ceil($RUR*22.5)).'���." >';
											echo '</form>';

											echo "</td>";
											echo "<td align=center>";
											echo '<form method="post" action="bank.php" target=_blank>';
									 		echo '<input type="hidden" name="okpay_subtype" value="'.$menu.'">';
									 		echo '<input type="hidden" name="okpay_type" value="88">';
									 		echo '<input type="hidden" name="okpay_param" value="881000">';
											echo '<input type="hidden" name="amount_bil" id="qbil" value="1000">';
											echo '<input type="hidden" name="okpay_amount" value="'.(ceil($RUR*35)).'" >'; // 1000 ����� (-30% ������) = 35$
											echo '<input type="submit" value="������ �� '.(ceil($RUR*35)).'���." >';
											echo '</form>';
											echo "</td>";
											echo "</tr>";
										echo "</td>";
										echo "</tr></table><br></form>";
										$nobutton=true;
								}


						}
						elseif ($param==69)
						{


												echo "<table border=0>";
												echo "<tr><td>";
												echo "</td>";
												echo "<td>";
												echo "<input type=\"hidden\" name=\"amount_bil\" id=\"qbil\" value=\"1\" >";
												echo "</td>";
												echo "</tr><tr>";


												echo "<td align=right>";
												echo "</td>";
												echo "<td>";

										 		echo '<input type="hidden" name="okpay_type" value="18">'; // ���  ������� ����

												echo show_elka(true);

												if ($CTYPE=='USD')
												{
												echo "�����: <select name=\"okpay_param\" id=\"buketid\"  onChange='javascript: callbuket(1,0)'  >";
												}
												elseif ($CTYPE=='RUB')
												{
												echo "�����: <select name=\"okpay_param\" id=\"buketid\"  onChange='javascript: callbuket(\"".ceil($RUR)."\",0);  '  >";
												}


															foreach ($leto_bukets as $k=>$v)
																	{
																	$ii++;
																	echo '<option value="'.$v.'" ';
																	if (buket_my_level_select($user)==$v) echo " selected ";
																	echo $kcolor." >$k </option>";

																	}

														echo "  </select> <br>";

	if (buket_my_level_select($user)!=410021)
							{
							 echo "<script>
							 		document.getElementById(410021).style.display='none';
							 		document.getElementById(".buket_my_level_select($user).").style.display='block';
								</script>";
							 }


											if ($CTYPE=='USD')
											{
											echo '�����: <input name="okpay_amount" value="10" size="8" id="qrub" readonly="readonly" > USD ';
											}
											elseif ($CTYPE=='RUB')
											{
											echo '�����: <input name="okpay_amount" value="'.(ceil($RUR)*10).'" size="8" id="qrub" readonly="readonly" > ���. ';
											}

												echo "</td>";
												echo "</tr></table><br><br>";


						}



				if ($nobutton!=true)
				{
				echo '<div align=center><input type="" value="��������" '.$add_js.'></center><br><br></form>';
				}
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
///////////////////
?>


</td>
<td width=25>&nbsp;</td>
</tr>
<tr><td align="center"  colspan="3">

</td></tr>

</table>
