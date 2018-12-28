<?php

/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/

include "connect.php";
include "functions.php";
include "bank_functions.php";
include "clan_kazna.php";

$course_ekr_kr=10; //���� ����� � ������� ��� ������ �������






$wm  = new wmMerchantOldbk;
$wm->sendlog();
$wm->checkpost();



class wmMerchantOldbk{
	var $course = array('WMR'=>0.0310597);
	var $comission = array('WMR'=>10);
	var $myPurses = array('WMR'=>'R418522840749');
	private $merchantkey = 'DAsg3dfgkW4ERsdf4kj78678sadfD';

	function checkpost(){
		header("Content-type: text/plain; charset=windows-1251");

		$traderid = $this->_post('traderid');

		addchp ('<font color=red>��������!</font>Debug1 rub: '.$traderid,'{[]}Bred{[]}');
		$amount = (float)$this->_post('LMI_PAYMENT_AMOUNT');
		$hash  = $this->_post('LMI_HASH');
		$requestCheck = $this->_post('LMI_PREREQUEST');
		$purse = $this->_post('LMI_PAYEE_PURSE');
		$wmid = $this->_post('LMI_PAYER_WM');
		$cpurse = $this->_post('LMI_PAYER_PURSE');

		$dealerInfo = $this->getDealerInfo($traderid);
		if(!$dealerInfo)die("���� ��������");
		if(!in_array($purse,$this->myPurses))die("��� �� ��� �������. ��������� ������");
		if($amount<0.01)die('����� ������� ���������');

		if($requestCheck){
					die("YES");
		}

		if(!empty($hash)){
			$currency = 'WM'.strtoupper(substr($purse,0,1));
			//$hashGen = $hash = strtoupper(md5(strtoupper($this->_post('LMI_PAYEE_PURSE').$this->_post('LMI_PAYMENT_AMOUNT').$this->_post('LMI_PAYMENT_NO').$this->_post('LMI_MODE').$this->_post('LMI_SYS_INVS_NO').$this->_post['LMI_SYS_TRANS_NO'].$this->_post('LMI_SYS_TRANS_DATE')).$this->merchantkey.strtoupper($this->_post('LMI_PAYER_PURSE').$this->_post('LMI_PAYER_WM'))));
			$hashGen = $hash = strtoupper(hash("sha256",strtoupper($this->_post('LMI_PAYEE_PURSE').$this->_post('LMI_PAYMENT_AMOUNT').$this->_post('LMI_PAYMENT_NO').$this->_post('LMI_MODE').$this->_post('LMI_SYS_INVS_NO').$this->_post['LMI_SYS_TRANS_NO'].$this->_post('LMI_SYS_TRANS_DATE')).$this->merchantkey.strtoupper($this->_post('LMI_PAYER_PURSE').$this->_post('LMI_PAYER_WM'))));
			if($hashGen!=$hash){
					die('HashError');
			}
			$pid = $this->_post('LMI_SYS_INVS_NO').$this->_post('LMI_SYS_TRANS_NO').$this->_post('LMI_PAYMENT_NO');
			$this->addBalance($pid,$traderid,$amount,$currency,'wm',"wm-$amount-$currency-$wmid-$cpurse-$pid");
			die();
		}

		die("System_error");


	}

	function _post($var){
		if(isset($_POST[$var]))return mysql_escape_string(htmlspecialchars($_POST[$var]));
	 return false;
	}

	function getDealerInfo($id){

	global $vaucher,$akks_types,$new_akks_prise, $larec_param,$larec_prise, $artup_param , $artup_prise, $artup_name, $exprun_param,$exprun_prise,$exprun_name,$larec_type,$larec_name, $podar , $podarvl,$podar23, $podar8,$podarny_img,$podarvl_img,$podar23_img,$podar8_img,$podar_prise,$podar_ekr,$bukets,$bukets_prise,$leto_bukets,$leto_bukets_prise;

	$indata=explode(":",$id);

	$id=(int)($indata[0]);
	$bankid=(int)($indata[1]);
	$param=(int)($indata[2]);
	$owner=(int)($indata[3]);
	$sub_trx=(int)($indata[4]);


		if ($id >0 )
		{
		$q = $this->query("SELECT * FROM `users` WHERE `id` = '$id' LIMIT 1;");
		if($s = mysql_fetch_array($q)){
			return $s;
			}
		}
		else if (($owner>0) and ($param=444))
		{

		$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
		if($s = mysql_fetch_array($q)){
			return $s;
			}

		}
		else if (($owner>0) and ($param=666))
		{

		$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
		if($s = mysql_fetch_array($q))
			{
			$q = $this->query("select * from oldbk.clans_kazna where clan_id=(select id from oldbk.clans where short='$s[klan]') LIMIT 1;");
					if($kk = mysql_fetch_array($q))
					{
					return $kk;
					}
			}

		}
		else if (($owner>0) and ($param==300))
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==2018||$param==2118))
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==222))
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==33333))
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
				$get_lot=mysql_fetch_array(mysql_query("select * from oldbk.item_loto_ras where status=1 LIMIT 1;"));
				if ($get_lot[id] >0)
				     {
					if (($get_lot[lotodate]-300) >=time() )
					{
					return $s;
					}
				    }
			}

		}
		else if (($owner>0) and (in_array($param,$exprun_param)))
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
				return $s;
			}

		}
		else if (($owner>0) and (in_array($param,$artup_param)))
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
				return $s;
			}

		}
		else if (($owner>0) and (in_array($param,$larec_param)))
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{

				if (test_larec($larec_type[$param],$s))
			 		{
						return $s;
					}
			}

		}
		else if (($owner>0) and ($param==98) or ($param==60) ) //������� ���� �������
		{

			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==95) and ($bankid >0)) //������� ��������
		{
			$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' and `owner` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==90||$param==89||$param==2||$param==3||$param==6) and ($bankid >0)) //�������  ���������
		{
			$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' and `owner` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==81 or $param==87) and ($bankid >0)) //������� ��������
		{
			$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' and `owner` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==91 or $param==51 or $param==52 or $param==53 ) and ($bankid >0)) //�������
		{
			$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' and `owner` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==92) and ($bankid >0)) //������� ����������
		{
			$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' and `owner` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==1001) ) // �������
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==10000) and ($sub_trx>0) ) // �������� �����
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==94) and ($bankid >0)) //������� ����
		{
			$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' and `owner` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if (($owner>0) and ($param==88000||$param==88100||$param==88500||$param==881000) and ($bankid >0))
		{
			$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' and `owner` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		 else if (($owner>0) and (in_array($param,$leto_bukets)) and ($bankid>0) )
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		 else if (($owner>0) and (in_array($param,$bukets)) and ($bankid>0) )
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		 else if (($owner>0) and (in_array($param,$podar)) and ($bankid>0) )
		{
			$q = $this->query("SELECT * FROM oldbk.`users` WHERE `id` = '$owner' LIMIT 1;");
			if($s = mysql_fetch_array($q))
			{
			return $s;
			}
		}
		else if ($bankid >0)
		{
		$q = $this->query("SELECT * FROM oldbk.`bank` WHERE `id` = '$bankid' LIMIT 1;");
		if($s = mysql_fetch_array($q)){
			return $s;
			}
		}


	return false;

	}

	function give_bonus_meshok($tonick,$summ)
	{
	/* http://tickets.oldbk.com/issue/oldbk-2069#tab=Comments
	if (($tonick['id']>0) and ($summ>=500))
				{

				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='636' ;"));
				$dress['present']=iconv("CP1251","CP1251",'�����������');
				if (by_item_bank_dil($tonick,$dress,null,1))
					{
					telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> �� �������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",')  �� ������� ������� ������� ������.'));
					return true;
					}

				}
	*/
	return false;
	}


	function addBalance($pid,$traderid,$amount,$currency,$method,$desc){

	global $vaucher,$akks_types,$new_akks_prise, $larec_param,$larec_prise,$artup_param , $artup_prise, $artup_name, $exprun_param,$exprun_prise,$exprun_name,$larec_type,$larec_name, $podar , $podarvl,$podar23, $podar8,$podarny_img,$podarvl_img,$podar23_img,$podar8_img,$podar_prise,$podar_ekr,$bukets,$bukets_prise,$leto_bukets,$leto_bukets_prise;
	include "ny_events.php";

		$indata=explode(":",$traderid);
		$traderid=(int)($indata[0]);
		$bankid=(int)($indata[1]);
		$param=(int)($indata[2]);
		$owner=(int)($indata[3]);
		//$pid = (int)$pid;


		if ($traderid > 0 )
		{
		$RUR_CUR=get_rur_curs_bank();
		$amountUsd = isset($RUR_CUR)?$amount*$RUR_CUR:0;
		$comis = isset($this->comission[$currency])?$this->comission[$currency]:0;
		$balamount = $amountUsd; //�������� �����
		addchp ('<font color=red>��������!</font>Debug2: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');

		/*
			if ( (time()<1381694400) AND ($traderid==3154) )
			{
			$balamount = ($balamount*0.05)+$balamount;	   //����� ���� ���������� � �������, ���� ��� ���������� ��� ���� 3154 ����������� �� 10%, � 5% � ������� ������ � ����, ��� ��� �� 14.10.13
			}
			else
		*/
			{
			$balamount = ($balamount*0.10)+$balamount;	   //����� / 90 * 10 + ����� = ����� /90*100
			}
		}
		else
		 {
		 // ��� ���������� ������ �����- ����������
		$RUR_CUR=get_rur_curs_bank();
		$amountUsd = isset($RUR_CUR)?$amount*$RUR_CUR:0;
		$comis = isset($this->comission[$currency])?$this->comission[$currency]:0;
		$balamount = $amountUsd; //�������� �����
		 }

		addchp ('<font color=red>��������!</font>Debug0000: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');

		if ($traderid > 0)
				{
				addchp ('<font color=red>��������!</font>Debug0010: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$traderid =(int)$traderid;
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				//mail('admin@oldbk.com','cc',"$amount $currency $balamount $balamount-($balamount/100*$comis)");
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid = $traderid AND method='$method'");
				if(mysql_num_rows($q) == 0){
				$this->query("INSERT INTO oldbk.trader_balance SET
				pid = '$pid',traderid='$traderid',method='$method',amount='$amount',currency='$currency',
				balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'
				");
				$ins_id=mysql_insert_id();
				$balans = mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.`dealers` WHERE `owner` = '{$traderid}' LIMIT 1;"));
				$prevbalans=$balans['sumekr'];
				$this->query("UPDATE oldbk.`dealers` set `sumekr` = sumekr+'$balamount' WHERE `owner` = '$traderid' LIMIT 1");
				$postbalans=$prevbalans+$balamount;
				$get_deal=check_users_city_data($traderid);
				if ($get_deal['email']!='')
				{
				require_once('./mailer/send-email.php');
				$aa='<html>
				<head>
					<title>���������� ������� ������</title>
				</head>
				<body>
					 ������������, '.$get_deal['login'].'.<br>
					��� ��� �������� ��������� ������ �� ����� '.$balamount.' ���.<br>
					<br>
					����� � ��� �� �����, ����: '.$prevbalans.' ���.  �����: '.$postbalans.' ���.
					------------------------------------------------------------------<br>
					������������� www.oldbk.com.
					<br>
				</body>
				</html>';
				mailnew($get_deal['email'],"���������� ������� ������ - ".$get_deal['login'],$aa,true);
				}

					if ($get_deal['odate'] > (time()-60))
					{
						addchp('<font color=red>��������!</font> ��� ��� �������� ��������� ������ �� ����� '.$balamount.' ���. , ����� � ��� �� �����: '.$postbalans.' ���.  ','{[]}'.$get_deal[login].'{[]}',$get_deal['room'],$get_deal['id_city']);
					}
					else
					{
					mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$get_deal['id']."','','<font color=red>��������!</font> ��� ��� �������� ��������� ������ �� �����  ".$balamount." ���. , ����� � ��� �� �����: ".$postbalans." ���.');");
					}


				return array('status'=>1,'id'=>mysql_insert_id(),'desc'=>'������ ������� ��������');
				   }

				}
				else if ( ($bankid>0) and ($param==0))
				{
addchp ('<font color=red>��������!</font>Debug0011: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				//��������� �����
				$bankid =(int)$bankid;
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');

				 //mail('admin@oldbk.com','cc',"$amount $currency $balamount $balamount-($balamount/100*$comis)");

				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = $bankid AND method='$method'");
				if(mysql_num_rows($q) == 0){
				$this->query("INSERT INTO oldbk.trader_balance SET
				pid = '$pid',traderid=0,bankid='$bankid',method='$method',amount='$amount',currency='$currency',
				balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'
				");
				$ins_id=mysql_insert_id();
					//echo "��������� �� $amount $currency $balamount";

					 $tonick = mysql_fetch_array(mysql_query("select * from oldbk.users where id=(select owner from oldbk.bank where id='{$bankid}')  LIMIT 1;"));
					 if ($tonick[id_city]==1)
					 {
					  $tonick = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE id='{$tonick[id]}' LIMIT 1;"));
					 }

					//����� �� ������� �����
					include "config_ko.php";


			/*	  if (BONUS_REAL_PREM)
					{
	  				$pbm[0]=0;
					$pbm[1]=0.01;
					$pbm[2]=0.02;
					$pbm[3]=0.05;
					$pbm=$pbm[$tonick['prem']];
					}
					else
			*/
					{
					$pbm=0;// ��������� ������
					}

				if ((time()>$KO_start_time40) and (time()<$KO_fin_time40))
				{
					$add_ekr_to_kazna=round($balamount*0.5,2);

						if ($tonick['klan']!='')
						{
							$klan_name=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$tonick['klan']}' LIMIT 1;"));
				      			$kkazna=clan_kazna_have($klan_name['id']);
							if ($kkazna)
							        {
									 if (put_to_kazna($klan_name['id'],2,$add_ekr_to_kazna,$klan_name['short'],false,"���������� �� ����� ��������� �����, ��������� ".$tonick['login']."!"))
											      {
												$fc_nom=100000000+$klan_name['id'];
												$fc_name='����-�����:�'.$klan_name[short].'�';
												mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values	('450','KO','{$fc_nom}','{$fc_name}','{$add_ekr_to_kazna}','0');");
												telepost_new($tonick,'<font color=red>��������!</font> ��������� '.$tonick['login'].' � ����� ��������� '.$add_ekr_to_kazna.' ���. �� ����� <a href=http://oldbk.com/encicl/?/act_clantreasury.html target=_blank>��������� �����</a>.');
												}

								}
						}
				}

			if ((time()>$KO_start_time) and (time()<$KO_fin_time))
				{
					$ko_bonus=round(($balamount*($pbm+$KO_A_BONUS)) ,2);
				}
				elseif ((time()>$KO_start_time38) and (time()<$KO_fin_time38))
				{
					$kb=act_x2bonus_limit($tonick,1,$balamount);
					if ($kb>0)
						{
						$ko_bonus=$kb;
						}
						else
						{
						$ko_bonus=0;
						}
				}
				else
				{
					$ko_bonus=round(($balamount*$pbm) ,2);
				}




				$this->query("UPDATE oldbk.`bank` set `ekr` = ekr+'".($balamount+$ko_bonus)."' WHERE `id` = '$bankid' LIMIT 1");

			//����� � �������
			//$tonick = mysql_fetch_array(mysql_query("select * from oldbk.users where id=(select owner from oldbk.bank where id='{$bankid}')  LIMIT 1;"));


			mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('wmr','8383','������','$bankid','{$tonick['login']}','{$balamount}');");

			mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

			telepost_new($tonick,'<font color=red>��������!</font> ��� ����������:'.($balamount).' ���. ������� �� �������!');

			//������ ��� ������
			if ($ko_bonus > 0)
						{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('',450,'KO','{$bankid}','{$tonick['login']}','{$ko_bonus}');");
							if ((time()>$KO_start_time) and (time()<$KO_fin_time))
							{
							telepost_new($tonick,'<font color=red>��������!</font> ��� ��������� �����: '.($ko_bonus).' ���. � ������ <a href="http://oldbk.com/encicl/?/act_ekr.html" target="_blank">�����.</a> ');
							}
							elseif ((time()>$KO_start_time38) and (time()<$KO_fin_time38))
							{
							telepost_new($tonick,'<font color=red>��������!</font> �� ��� ���� �'.$bankid.' ���������� '.$ko_bonus.' ���. ��  ������������� ������, � ������ ����� <a href="http://oldbk.com/encicl/?/act_x2bonus.html" target="_blank">�������� ������</a>. ����� �������� �������� � �� ���������������� �� ����������� ������� ���� ������.');
							}
							else
							{
							$yyy[1]='Silver';
							$yyy[2]='Gold';
							$yyy[3]='Platinum';
							telepost_new($tonick,'<font color=red>��������!</font> ��� ��������� �����: '.($ko_bonus).' ���. �� ������� "'.$yyy[$tonick[prem]].'  account". ');
							//telepost_new($tonick,'<font color=red>��������!</font> ��� ��������� �����:'.($ko_bonus).' ���. � ������ <a href="http://oldbk.com/encicl/?/act_ekr.html" target="_blank">�����.</a> ');
							}
						}


					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=8383;
					$rec['target_login']='������';
					$rec['type']=68;//
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$balamount+$ko_bonus;
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
					$rec['bank_id']=$bankid;
					add_to_new_delo($rec); //�����

					///����� � ������� �����
					mysql_query("INSERT INTO `oldbk`.`exchange_log` SET `owner`='{$tonick['id']}' , `dilekr`='".($balamount+$ko_bonus)."'  ON DUPLICATE KEY UPDATE dilekr=dilekr+'".($balamount+$ko_bonus)."' ");

			if (olddelo==1)
			{
			mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['owner']}','&quot;".$tonick['login']."&quot; �������� ({$balamount}���.) ����� ������ ������',9,'".time()."');");
			}
			mysql_query("INSERT INTO oldbk.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�� ������ <b>{$balamount} ���.</b> �� WMR','{$bankid}');");
			//������ ��� ������
			if ($ko_bonus > 0)
			{
			mysql_query("INSERT INTO oldbk.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','����� �� ������� ������������ <b>{$ko_bonus} ���.</b> ','{$bankid}');");
			}
					 // ���������
					CheckRealPartners($tonick['id'],$balamount,$_SESSION['uid']);
					 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	 if ($p_user['partner']!='' and $p_user['fraud']!=1)
				       {
				       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$_POST['ekr']}','{$bank['id']}','".time()."');");
				      	 $bonus=round(($balamount/100*$partner['percent']),2);
				      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");

				       //69
				       /*
				        if ($p_user['partner']==69 and $p_user['fraud']!=1)
				         {
				         //echo '<img src="http://n.actionpay.ru/ok/461.png?apid='.$id_ins_part_del.'" width="1" height="1" />';
				         $sid=(int)($p_user['banner']);
					 $rtime=explode(" ",microtime());
					 $tm_micro=($rtime[0]*1000000);
					 $tm_time=$rtime[1];
					 mysql_query("INSERT INTO oldbk.`xml_data_69` (`lbid`, `sid`, `stamp` , `micro` ,`price`, `trid` )
					          VALUES
					          ('461', '".$sid."', '".$tm_time."', '".$tm_micro."', '{$balamount}' ,'{$id_ins_part_del}' );");
				         }
				         */

				      }

				 //�����
				$dil['id']=8383;
				$dil['login']='������';
				$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' "));
				if ($get_bankid['id']>0)
					{
					//make_ekr_add_bonus($tonick,$get_bankid,$balamount,$dil);
					}
				make_discount_bonus($tonick,$balamount,2);
				return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				      }
				}
				/*
				else if ( (in_array($param,$vaucher)) and ($bankid>0) )
				{
				///������ ������� �� �����, �������� ��
				$bankid =(int)$bankid;
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));


				/// ��������� ����������� ��������� ������� ������������ �� �������� � ��������� �������� �� ����� � ������
				/// ���� ��� �� �� ���������� - ���� ��� �� ����� ��� ���������
				$get_test_vau=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$param}' ;"));
				$RUR=get_rur_curs();
				$rur_cost=round($get_test_vau[ecost]*$RUR);
				$amount_test=round($amount);
				if ($amount_test==$rur_cost)
				   {
					$balamount = number_format($get_test_vau[ecost],2,'.','');
					$amount = number_format($amount,2,'.','');


					$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = $bankid AND method='$method'");
					if(mysql_num_rows($q) == 0)
					{
					$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid=0,bankid='$bankid',method='$method',amount='$amount',currency='$currency', balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'");
					$ins_id=mysql_insert_id();
					$get_bankid = mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' ;"));

						if (by_item_ko($get_bankid[owner],$param,$bankid))
		 				{
						$dil['id']=8383;
						$dil['login']='������';
						$tonick=mysql_fetch_array(mysql_query("select * from oldbk.users where id='{$get_bankid['owner']}'  "));
						//make_ekr_add_bonus($tonick,$get_bankid,$balamount,$dil);

						return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
	 					}
					}

				   }
				   else
				   {
					mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR ��������� �������� != ��������� ������: �������� {$amount} / ������ {$rur_cost}, Param {$param} , UserID {$get_bankid[owner]} ');");
				   }

			  	}
			  	else if  (  (in_array($param,$akks_types))  and ($bankid>0) )
			  	{
				///������ ������� �� �����, ������� �����
				$bankid =(int)$bankid;
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$RUR=get_rur_curs();

						if ($param>300)
						{
						//�������
						$sub_type=$param-300;
						$param=3;
						}
						elseif ($param>200)
						{
						//����
						$sub_type=$param-200;
						$param=2;
						}
						else
						{
						//�������
						$sub_type=$param-100;
						$param=1;
						}

				$rur_cost=round($new_akks_prise[$param][$sub_type]*$RUR);
				$amount_test=round($amount);
				if ($amount_test>=$rur_cost)
					{
						//��� ��
					$balamount = number_format($new_akks_prise[$param][$sub_type],2,'.','');
					$amount = number_format($amount,2,'.','');


					$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = $bankid AND method='$method'");
					if(mysql_num_rows($q) == 0)
					{
					$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid=0,bankid='$bankid',method='$method',amount='$amount',currency='$currency', balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'");
					$ins_id=mysql_insert_id();

						$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}'  LIMIT 1;"));
						$tonick = mysql_fetch_array(mysql_query("select * from oldbk.users where id='{$bank[owner]}'  LIMIT 1;"));
						 if ($tonick[id_city]==1)
						 {
						  $tonick = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE id='{$tonick[id]}' LIMIT 1;"));
						 }
						if 	( (($tonick[prem]==$param) or ($tonick[prem]==0) ) and ($tonick[id]>0))
					    	{
					    	$dill[id_city]=0;
					    	$dill[id]=8383;
					    	$dill[login]='������';
						$dill[paysys]='wmr';

			    			$exp=main_prem_akk($tonick,$param,$dill,$sub_type);
						addchp ('<font color=red>��������!</font>Debug2 rub: PREM EXP:'.$exp,'{[]}Bred{[]}');
							if ($exp>0)
							{
							$REZ=by_prem_from_bank($tonick,$param,$bank,$exp,$dill,$sub_type);
							addchp ('<font color=red>��������!</font>Debug2 rub: PREM REZ:'.$REZ,'{[]}Bred{[]}');

							mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

							return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
							}
					 		else
					 		{
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ ��������� ������� ���(2). ');");
				 			}
		    				}
			    			else
		    				{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ ��������� ������� ���(1). ');");
		    				}
		    			  }
					}
					else
					{
					mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR ��������� �������� != ��������� ������: �������� {$amount} / ������ {$rur_cost}, Param {$param} , UserID {$tonick[id]} ');");
					}
			  	}
			  	else if   ( ($param==444) and ($owner>0) )
			  	{
			  	//��������� �������� �� �������
		  	  	$balamount=round($balamount,2);
		  	  	$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$amount = number_format($amount,2,'.','');

			  	$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid = $owner AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency', balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'");
				$ins_id=mysql_insert_id();


				  	 $tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE id='{$owner}'  LIMIT 1;"));
				 	  $dbc='oldbk.';

	 	  			  if ($tonick[id_city]==1)
					  {
					  $tonick = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE id='{$owner}' LIMIT 1;"));
				 	  $dbc='avalon.';
					  }

				mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('wmr','8383','������','0','{$tonick['login']}','{$balamount}');");

				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

				$get_eff=mysql_fetch_array(mysql_query("select * from {$dbc}effects where owner='{$owner}' and type=4 and lastup > 0 "));
				if ($get_eff[id]>0)
				{
				$sum_ekr=$balamount;
				$DOLG_EKR=0;
				$vikup=unserialize($get_eff['add_info']);
				if ($vikup[kr]>0) { $DOLG_EKR+=round(($vikup[kr]/$course_ekr_kr),2); }
				if ($vikup[ekr]>0) { $DOLG_EKR+=$vikup[ekr]; }

				if  ($sum_ekr>=$DOLG_EKR)
					{
					///���� ��� ����
					$mess = "�������� ������� �� �����, ���� ������� ����� ��. {ee}WMR{ee}.";
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','".$mess."','".time()."');");

					mysql_query("update {$dbc}users set palcom = '', align = 0 where id='".$tonick[id]."' ");
					mysql_query("DELETE from {$dbc}effects where type=4 AND owner='".$tonick[id]."' and lastup > 0 ");
					telepost_new($tonick,'<font color=red>��������!</font> ������ ������� ���� ����� �� '.($balamount).' ���. �� �������� �� �����! ');

								//������ � ����!
											$rec['owner']=$tonick[id];
											$rec['owner_login']=$tonick[login];
											$rec['owner_balans_do']=$tonick['money'];
											$rec['owner_balans_posle']=$tonick['money'];
											$rec['target']=0;
											$rec['target_login']='��������� �����';
											$rec['type']=5020;
											$rec['sum_kr']=0;
											$rec['sum_ekr']=$balamount;
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
											$rec['bank_id']=0;
											$rec['add_info']='WMR';
											add_to_new_delo($rec); //�����
					}
					else
					{
					//���� �� ������ ������
						if ($vikup[kr]>0)
						{
						$vikup[kr]-=round(($sum_ekr*$course_ekr_kr),2); // ����� �������� ����

						if ($vikup[kr]<0)
							{
							//���� ���������� ������ ��� ���� - ������ �����
							$sum_ekr=-(round(($vikup[kr]/$course_ekr_kr),2));
							$vikup[kr]=0;
							}
						}

						if ($vikup[ekr]>0)
						{
						$vikup[ekr]-=$sum_ekr;
						if ($vikup[ekr]<0)
							{
							$vikup[ekr]=0;
							}
						}
					$get_eff['add_info']=serialize($vikup);
					mysql_query("UPDATE {$dbc}effects set add_info='".($get_eff['add_info'])."' WHERE id='{$get_eff[id]}' ");
					telepost_new($tonick,'<font color=red>��������!</font> �������� ������� ���� ����� �� '.($balamount).' ���. ');
					//������ � ����
											//������ � ����!
											$rec['owner']=$tonick[id];
											$rec['owner_login']=$tonick[login];
											$rec['owner_balans_do']=$tonick['money'];
											$rec['owner_balans_posle']=$tonick['money'];
											$rec['target']=0;
											$rec['target_login']='��������� �����';
											$rec['type']=5020;
											$rec['sum_kr']=0;
											$rec['sum_ekr']=$balamount;
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
											$rec['bank_id']=0;
											$rec['add_info']='WMR (��������� ���������) ';
											add_to_new_delo($rec); //�����

					}
				}
				else
				{
	 			addchp ('<font color=red>��������!</font>������ ������ �� ��� �� � ����� id:'.$owner,'{[]}Bred{[]}',-1,-1);
				}

				 return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}

			  	}*/
			  	else if   ( ($param==666) and ($owner>0) )
			  	{
addchp ('<font color=red>��������!</font>Debug0012: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
  				include "config_ko.php";
			  	//��������� �������� ���������� ����� �����
		  	  	$balamount=round($balamount,2);
		  	  	$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$amount = number_format($amount,2,'.','');

			  	$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid = $owner AND method='$method'");
				if(mysql_num_rows($q) == 0)
				  {
				  $this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency', balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'");
				  $ins_id=mysql_insert_id();

				  	 $tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE id='{$owner}'  LIMIT 1;"));
				 	  $dbc='oldbk.';
	 	  			  if ($tonick[id_city]==1)
					  {
					  $tonick = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE id='{$owner}' LIMIT 1;"));
				 	  $dbc='avalon.';
					  }

	  			$klan_name=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$tonick[klan]}' LIMIT 1;"));
				$kkazna=clan_kazna_have($klan_name[id]);
				if ($kkazna)
				{
					$klan_kazna_ekr=$balamount;

					$bonekr=get_ekr_addbonus();
					if ($bonekr>0)
					{
					$addbonekr=round(($balamount*$bonekr),2);
					}

					if ((time()>$KO_start_time) and (time()<$KO_fin_time))
					{
					$add_klan_kazna_ekr=round(($klan_kazna_ekr*1.5) ,2); //+10%
					$ko_bonus=$add_klan_kazna_ekr-$klan_kazna_ekr; // ��� ������ � ������
					}
					else
					{
					$add_klan_kazna_ekr=$klan_kazna_ekr;
					}

				$add_klan_kazna_ekr+=$addbonekr;


				if (put_to_kazna($klan_name[id],2,$add_klan_kazna_ekr,$klan_name[short],$tonick,$coment='���������� ����� WMR, �� ��������� '.$tonick[login]))
			   	{
				$fc_nom=100000000+$klan_name[id];
				$fc_name='����-�����:�'.$klan_name[short].'�';
				mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('wmr','8383','������','{$fc_nom}','".$fc_name."','{$balamount}');");
				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

				if ($ko_bonus > 0)  {  mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('',450,'KO','{$fc_nom}','{$fc_name}','{$ko_bonus}');"); }
				if ($addbonekr>0) {  mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('',450,'KO','{$fc_nom}','{$fc_name}','{$addbonekr}');"); }

				telepost_new($tonick,'<font color=red>��������!</font> �������� ������ �������� ����� �� '.($add_klan_kazna_ekr).' ���. ');
		   		}
		   			else
		   			{
					addchp ('<font color=red>��������!</font>���������� �����, ������ ������ WMR, �� ������ ���������, teloid:'.$tonick[id],'{[]}Bred{[]}',-1,-1);
		   			}
				}
			else
				{
				addchp ('<font color=red>��������!</font>���������� �����, ������ ������ WMR, �� ��� �� ������/���������� �����, teloid:'.$tonick[id],'{[]}Bred{[]}',-1,-1);
				}

				//give_bonus_meshok($tonick,$balamount);

		  	    return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
			    }
			  }
			  else if (($owner>0) and ($param==300))
			  {
			addchp ('<font color=red>��������!</font>Debug0013: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
			include "config_ko.php";
			  //������� ���������
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

				$add_rep=round($balamount * 600);
				$cit[0]='oldbk.';
				$cit[1]='avalon.';
				$cit[2]='angels.';

				if ((time()>$KO_start_time7) and (time()<$KO_fin_time7))
				{
					$ko_bonus_rep=$add_rep; // ��� ������ � ������
					$add_rep=round(($add_rep*(1+$KO_A_BONUS7)) ,2); //+50%
					$ko_bonus_rep=$add_rep-$ko_bonus_rep; // ��� ������ � ������
					$add_bonus_str=' ��������� �� ����� +'.($KO_A_BONUS7*100).'% ('.$ko_bonus_rep.'���) ';

				}
				elseif ((time()>$KO_start_time38) and (time()<$KO_fin_time38))
				{
					$kb=act_x2bonus_limit($tonick,2,$add_rep);
					if ($kb>0)
						{
						$ko_bonus_rep=$kb; // ��� ������ � ������
						$add_rep=round($add_rep+$ko_bonus_rep,2);
						$add_bonus_str='. ��������� '.$ko_bonus_rep.' ��������� �� ����� �������� ������.';
						$add_bonus_str_chat='<font color=red>��������!</font> ��� ��������� '.$ko_bonus_rep.' ��������� �� ����� <a href="http://oldbk.com/encicl/?/act_x2bonus.html" target="_blank">�������� ������</a>. ����� �������� �������� � �� ���������������� �� ����������� ������� ���� ������.';
						}
						else
						{
						$add_bonus_str='';
						}
				}
				else
				{
					$add_bonus_str='';
				}

				mysql_query("UPDATE ".$cit[$tonick[id_city]]."`users` SET  `rep`=`rep`+'$add_rep' WHERE `id`= '".$tonick['id']."' LIMIT 1;");
				mysql_query("UPDATE ".$cit[$tonick[id_city]]."`users` SET   `repmoney` = `repmoney` + '$add_rep' WHERE `id`= '".$tonick['id']."' LIMIT 1;");
				if (mysql_affected_rows()>0)
				{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr) values ('wmr','8383','������','300','{$tonick[login]}','{$balamount}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }

				      	//new_delo - ���������� � ����� ���
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['owner_rep_do']=$tonick[repmoney];
					$rec['owner_rep_posle']=($tonick[repmoney]+$add_rep);
					$rec['target']=8383;
					$rec['target_login']='������';
					$rec['type']=2828;//������� �� ������� ����
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$balamount;
					$rec['sum_rep']=$add_rep;
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
					$rec['bank_id']=0;
					$rec['add_info']='������ ��� �� '.$tonick[repmoney]. ' ����� ' .($tonick[repmoney]+$add_rep).$add_bonus_str;
					$tonick[repmoney]+=$add_rep;
					add_to_new_delo($rec); //�����

					telepost_new($tonick,'<font color=red>��������!</font> ��� ��������� '.$add_rep.' ���������. ������� ����!');

					if ($add_bonus_str_chat!='')
						{
						telepost_new($tonick,$add_bonus_str_chat);
						}

					$dil['id']=8383;
					$dil['login']='������';
					$bankid =(int)$bankid;
					$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$tonick[id]}'; "));
					if ($get_bankid['id']>0)
						{
						//make_ekr_add_bonus($tonick,$get_bankid,$balamount,$dil);
						}
					make_discount_bonus($tonick,$balamount,3);
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}

				}
				}


			  }
			  else if ( ($owner>0) and ($param==2018||($param==2118 and ($sub_trx>=1 and $sub_trx<=5))) )
			  {
			  //�������  �������
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ( ($tonick['id']>0)  AND  ( ($param==2018 AND $balamount>=65) OR ($param==2118 AND $balamount>=70)) )
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();


					if (mysql_affected_rows()>0)
					{
						if ($param==2118)
						{
						$ss=array(1=>"S",2=>"M",3=>"L",4=>"XL",5=>"XXL");
						$fsize=$ss[$sub_trx];
						}
						else
						{
						$fsize='';
						}

						if (get_buy_bilet($tonick,$fsize,$balamount,'������'))
						{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr) values ('wmr','8383','������','{$param}','{$tonick[login]}','{$balamount}');");
						return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
						}
					}

				}
				}
			  }
  				 else if ( ($owner>0) and ($param==10000) and ($sub_trx>0) )
				{
				//��������� �������� �����
					$RUR=get_rur_curs();
					$tonick = check_users_city_data($owner);
					$currency = mysql_escape_string($currency);
					$desc = mysql_escape_string(htmlspecialchars($desc));
					$balamount = number_format($balamount,2,'.',''); // ����
					$amount = number_format($amount,2,'.','');

					$PaymentMethod='WMR';

					if ($tonick['id']>0)
					{
							$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
							if(mysql_num_rows($q) == 0)
							{
							$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
							$ins_id=mysql_insert_id();

							$fid = $param; // param

							$get_sub_trx=mysql_fetch_array(mysql_query("select * from `oldbk`.`trader_partn_trans` where id='{$sub_trx}' limit 1; "));

							if (($get_sub_trx['id']>0) and ( $get_sub_trx['ekr']>=$balamount) )
							{
										mysql_query("UPDATE `oldbk`.`trader_partn_trans` SET `status`=1,`pay_syst`='{$PaymentMethod}' WHERE `id`='{$get_sub_trx['id']}' and  `status`=0  LIMIT 1;");
										if (mysql_affected_rows()>0)
										{

										$ger_par_info=mysql_fetch_array(mysql_query("select * from trader_partners where par_id='{$get_sub_trx['par_id']}' and par_serv='{$get_sub_trx['par_serv']}' limit 1;"));

										if ($ger_par_info['id']>0)
													{

														//���������� �������� �� ��� ���������
														$pay_ekr=round($balamount*$ger_par_info['par_rate']*0.01,2);
														mysql_query("UPDATE `oldbk`.`trader_partners` SET `sum_ekr`=`sum_ekr`+'{$pay_ekr}'  WHERE `id`='{$ger_par_info['id']}' limit 1;");
													//�����������
													mysql_query("INSERT INTO oldbk.`dilerdelo` (sub_trx,paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('{$get_sub_trx['id']}','{$PaymentMethod}','8383','".iconv("CP1251","CP1251",'������')."','{$fid}','{$tonick[login]}','{$balamount}','{$bankid}' );");
													mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

												      	// ���������
													CheckRealPartners($tonick['id'],$balamount,0);
													     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
													     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
													     if ($p_user['partner']!='' and $p_user['fraud']!=1)
													      {
													       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
													       $id_ins_part_del=mysql_insert_id();
													       $bonus=round(($balamount/100*$partner['percent']),2);
													       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
													      }

																			//������ � ����!
																			$rec['owner']=$tonick[id];
																			$rec['owner_login']=$tonick[login];
																			$rec['owner_balans_do']=$tonick['money'];
																			$rec['owner_balans_posle']=$tonick['money'];
																			$rec['target']=8383;
																			$rec['target_login']=iconv("CP1251","CP1251",'������');
																			$rec['type']=5858;
																			$rec['sum_kr']=0;
																			$rec['sum_ekr']=$balamount;
																			$rec['sum_kom']=0;
																			$rec['item_id']='';
																			$rec['add_info'] = iconv("CP1251","CP1251",'������ ����� �'.$get_sub_trx['id'].' - '.$ger_par_info['par_serv_desc'].',  ����� WMR '.$balamount);
																			add_to_new_delo($rec);

													telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ������ ������� ���� �'.$get_sub_trx['id'].' - '.$ger_par_info['par_serv_desc'].'. ������� ����!'));
													//give_bonus_meshok($tonick,$balamount);
													return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
													}
													else
													{
													$resultCode=803;
													}
										}
										else
										{
										$resultCode=802;
										}

							}
							else
								{
								$resultCode=801;
								}
							}

						}
						else
						{
						$resultCode=800;
						}
			}
			 else if ( ($owner>0) and ($param==1001) )
				{
				addchp ('<font color=red>��������!</font>'.$param.': (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
					$RUR=get_rur_curs();
					$tonick = check_users_city_data($owner);
					$currency = mysql_escape_string($currency);
					$desc = mysql_escape_string(htmlspecialchars($desc));
					$balamount = number_format($balamount,2,'.','');
					$amount = number_format($amount,2,'.','');

						if ($tonick['id']>0)
							{
							$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
							if(mysql_num_rows($q) == 0)
							{
							$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
							$ins_id=mysql_insert_id();

							$fid = 1001; //  ������� �������

							$owntravma=mysql_fetch_array(mysql_query("select * from effects where type=14 and owner='{$tonick['id']}' LIMIT 1"));

							if ($owntravma['id']>0)
							{

							mysql_query("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");

							mysql_query("UPDATE users SET `sila`=`sila`+'{$owntravma['sila']}', `lovk`=`lovk`+'{$owntravma['lovk']}', `inta`=`inta`+'{$owntravma['inta']}' WHERE `id` = '{$tonick['id']}'  LIMIT 1;");

								if (!(mysql_affected_rows()>0))
									{
									addchp ('<font color=red>Error update travm 14 </font>','{[]}Bred{[]}');
									}


							mysql_query("UPDATE `oldbk`.`plugin_user_warning` SET `count`=0 WHERE `user_id`='{$tonick['id']}' "); // ������ �����

							mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','".iconv("CP1251","CP1251",'������')."','{$fid}','{$tonick[login]}','{$balamount}','{$bankid}' );");
							mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

						      // ���������
							CheckRealPartners($tonick['id'],$balamount,0);
							     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
							     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
							     if ($p_user['partner']!='' and $p_user['fraud']!=1)
							      {
							       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
							       $id_ins_part_del=mysql_insert_id();
							       $bonus=round(($balamount/100*$partner['percent']),2);
							       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
							      }

													//������ � ����!
													$rec['owner']=$tonick[id];
													$rec['owner_login']=$tonick[login];
													$rec['owner_balans_do']=$tonick['money'];
													$rec['owner_balans_posle']=$tonick['money'];
													$rec['target']=8383;
													$rec['target_login']=iconv("CP1251","CP1251",'������');
													$rec['type']=578;
													$rec['sum_kr']=0;
													$rec['sum_ekr']=0;
													$rec['sum_kom']=0;
													$rec['item_id']='';
													$rec['add_info'] = '������ ������� ������ WMR '.$balamount;
													add_to_new_delo($rec);

							telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� ������� �� �����. ������� ����!'));

							//give_bonus_meshok($tonick,$balamount);
							return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
							}
							else
								{
								mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> wmr: wmr:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");
								}

							}
						}
						else
						{
						addchp ('<font color=red>��������!</font>1001: (WMR= error)'.$balamount,'{[]}Bred{[]}');
						}
			}
			  else if ( ($owner>0) and ($param==88000||$param==88100||$param==88500||$param==881000) )
				{
				addchp ('<font color=red>��������!</font>'.$param.': (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
		  			include "config_ko.php";
					$RUR=get_rur_curs();
					$tonick = check_users_city_data($owner);
					$currency = mysql_escape_string($currency);
					$desc = mysql_escape_string(htmlspecialchars($desc));
					$balamount = number_format($balamount,2,'.','');
					$amount = number_format($amount,2,'.','');
					$bankid =(int)$bankid;

				  			if ($param==88000)
				  			{
					  		$kol=round($balamount*20);
				  			$eprice=$balamount;
				  			}
							elseif ($param==88100) { $kol=100; $eprice=5; }
							elseif ($param==88500) { $kol=500; $eprice=22.5;  }
							elseif ($param==881000) { $kol=1000; $eprice=35;  }



						if (($tonick['id']>0) and  (round($balamount,2)>=round($eprice,2) ) and  ($kol>0) )
							{
							$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
							if(mysql_num_rows($q) == 0)
							{
							$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
							$ins_id=mysql_insert_id();

							$fid = 3003060; // �������  ������� ������� ����� �������

							if ((time()>$KO_start_time38) and (time()<$KO_fin_time38))
							{
								$kb=act_x2bonus_limit($tonick,3,$kol);
								if ($kb>0)
									{
									$ko_bonus_gold=$kb;
									$kol+=$ko_bonus_gold;
									$ko_bonus_gold_str='. ��������� '.$ko_bonus_gold.' ����� �� ����� �������� ������.';
									$ko_bonus_gold_chat='<font color=red>��������!</font> ��� ��������� '.$ko_bonus_gold.' ����� �� ����� <a href="http://oldbk.com/encicl/?/act_x2bonus.html" target="_blank">�������� ������</a>. ����� �������� �������� � �� ���������������� �� ����������� ������� ���� ������.';
									}
							}


							mysql_query("UPDATE oldbk.`users` set `gold` = `gold`+'{$kol}' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
							if (mysql_affected_rows()>0)
							{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','".iconv("CP1251","CP1251",'������')."','{$fid}','{$tonick[login]}','{$balamount}','{$bankid}' );");
							mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������


						      // ���������
							CheckRealPartners($tonick['id'],$balamount,0);
							     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
							     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
							     if ($p_user['partner']!='' and $p_user['fraud']!=1)
							      {
							       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
							       $id_ins_part_del=mysql_insert_id();
							       $bonus=round(($balamount/100*$partner['percent']),2);
							       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
							      }

													//������ � ����!
													$rec['owner']=$tonick[id];
													$rec['owner_login']=$tonick[login];
													$rec['owner_balans_do']=$tonick['money'];
													$rec['owner_balans_posle']=$tonick['money'];
													$rec['target']=8383;
													$rec['target_login']=iconv("CP1251","CP1251",'������');
													$rec['type']=3001;
													$rec['sum_kr']=0;
													$rec['sum_ekr']=$balamount;
													$rec['sum_kom']=0;
													$rec['item_id']='';
													$rec['item_name']='������';
													$rec['item_count']=$kol;
													$rec['item_type']=50;
													$tonick['gold']+=$kol;
													$rec['add_info'] = $kol."/".($tonick['gold']).$ko_bonus_gold_str;
													add_to_new_delo($rec);

							telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� <b>'.$kol.'</b> �����. ������� ����!'));
							if ($ko_bonus_gold_chat!='')
									{
									telepost_new($tonick,$ko_bonus_gold_chat);
									}
							make_discount_bonus($tonick,$balamount,1);
							return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
							}
							else
								{
								mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> wmr: wmr:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");
								}

							}
						}
						else
						{
					addchp ('<font color=red>��������!</font>88000: (WMR= error)kol:'.$kol.':balamount'.$balamount,'{[]}Bred{[]}');
						}
			}
			else if (($owner>0) and ($param==2||$param==3||$param==6) )
			{
addchp ('<font color=red>��������!</font>Debug0014: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				$bankid =(int)$bankid;
				$ali_cos=15;

				$RUR=get_rur_curs();

				mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> WMR: Pay:{$amount} Param {$param} , UserID {$tonick[id]}, new-align start ');");

				if (($tonick['id']>0) and  ($amount>=$RUR*$ali_cos)  )
					{
					$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
					if(mysql_num_rows($q) == 0)
					{
					$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
					$ins_id=mysql_insert_id();

							$sklonka = $param;
							$sklonka_array=array(2,3,6);
							$eff_align_type=5001;
							$eff_align_time=time()+60*60*24*30*2;

							if ($sklonka == 2) {$skl=iconv("CP1251","CP1251","�����������"); $skl2=iconv("CP1251","CP1251","�����������");}
								elseif ($sklonka == 3) {$skl=iconv("CP1251","CP1251","������"); $skl2=iconv("CP1251","CP1251","������");}
									 elseif ($sklonka == 6) {$skl=iconv("CP1251","CP1251","�������"); $skl2=iconv("CP1251","CP1251","�������");}

									$cheff=mysql_fetch_array(mysql_query("SELECT * from  effects WHERE type = '".$eff_align_type."' AND owner = '".$tonick['id']."' LIMIT 1;"));
									if ($cheff['id']>0)
									{
									//������� �� ��� ����!
									mysql_query("DELETE from  effects WHERE id='{$cheff['id']}' LIMIT 1; ");
									}

									//�������
									mysql_query("UPDATE oldbk.`users` set `align` = '{$sklonka}' WHERE `id` = '{$tonick['id']}' LIMIT 1;") ;
							if (mysql_affected_rows()>0)
								{
									//���
									mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','".iconv("CP1251","CP1251",'������')."','{$sklonka}','{$tonick[login]}','{$ali_cos}','{$bankid}' );");
									//������
									mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$ali_cos}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������


									//������
									$qlist=array();
								        $i=0;
								        $data=mysql_query("SELECT * FROM oldbk.beginers_quest_list WHERE  aganist like '%".$sklonka."%';");
								        while($q_data=mysql_fetch_array($data))
								        {
								     		$qlist[$i]=$q_data[id];
								     		$i++;
								        }

								        mysql_query("UPDATE oldbk.beginers_quests_step set status =1 WHERE owner='".$tonick['id']."' AND quest_id in (".(implode(",",$qlist)).")");

									$la=0;
									$last_aligh=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_last_align` WHERE `owner` = '".$tonick['id']."' LIMIT 1;"));   //��� ����� ������� �� ��������� ������
									if($last_aligh[id]>0)
									{
										$la=$last_aligh[align];
									}

									//����� ����� �������
									if($la!=$sklonka)
									{
										$sql="INSERT INTO effects (`type`, `name`, `owner`, `time`, `add_info`)  VALUES  ('".$eff_align_type."','".iconv("CP1251","CP1251","����� �������")."','".$tonick['id']."','".$eff_align_time."','".$sklonka."');";
										mysql_query($sql);
										//������ ���, ���������.
									}

									// + ������ ������
									mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=4848,`allcount`='1' ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'1' ;");

									//new_delo
				  		    			$rec['owner']=$tonick[id];
									$rec['owner_login']=$tonick[login];
									$rec['owner_balans_do']=$tonick['money'];
									$rec['owner_balans_posle']=$tonick['money'];
									$rec['target']=8383;
									$rec['target_login']=iconv("CP1251","CP1251",'������');
									$rec['type']=58;//������� ������� �� �������
									$rec['sum_kr']=0;
									$rec['sum_ekr']=$ali_cos;
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
									$rec['bank_id']=0;
									$rec['add_info']=$skl;

									add_to_new_delo($rec); //�����

									//� �����
									mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','".iconv("CP1251","CP1251","����� &quot;������&quot; �������� &quot;").$tonick['login']."&quot; ".$skl2." ".iconv("CP1251","CP1251","����������")."','".time()."');");
									//� ���
									telepost_new($tonick,'<font color=red>'.iconv("CP1251","CP1251","��������! ").'</font> '.iconv("CP1251","CP1251","������� ������ ���������� �1 ��������� � ").'<a href="javascript:void(0)" onclick='.(!is_array($_SESSION['vk'])?"top.":"parent.").'cht("http://capitalcity.oldbk.com/myabil.php#my")>'.iconv("CP1251","CP1251","������ ����� ������ ��������").'</a>.');

									//�������� �����
									$dil['id']=8383;
									$dil['login']='������';
									present_bonus_sert($tonick,$dil);
									//give_bonus_meshok($tonick,$balamount);
									return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
								}
							else
								{
									mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> WMR: Pay:{$amount} Param {$param} , UserID {$tonick[id]}, new-align error . ');");
								}
			 		}
			 		}
			}
			/*
			 else if (($owner>0) and ($param==33333))
			    {
			    //������� ����
			    $tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				$bilprice=2; //2 ��� - �����
				$kol=round($balamount/$bilprice);

				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

				$cit[0]='oldbk.';
				$cit[1]='avalon.';
				$cit[2]='angels.';

				$get_lot=mysql_fetch_array(mysql_query("select * from oldbk.item_loto_ras where status=1 LIMIT 1;"));
				if ($get_lot[id] >0)
				    {
					for ($kkk=1;$kkk<=$kol;$kkk++)
					{
					if(mysql_query("INSERT INTO oldbk.`item_loto` SET `loto`={$get_lot[id]},`owner`={$tonick[id]},`dil`=8383,`lotodate`='".date("Y-m-d H:i:s",$get_lot[lotodate])."';"))
					{
					$good = 1;
					$new_bil_id=mysql_insert_id();
					mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`name`,`duration`,`maxdur`,`cost`,`owner`,`nlevel`,`nsila`,`nlovk`,`ninta`,`nvinos`,`nintel`,`nmudra`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nalign`,`minu`,`maxu`,`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`img`,`text`,`dressed`,`bron1`,`bron2`,`bron3`,`bron4`,`dategoden`,`magic`,`type`,`present`,`sharped`,`massa`,`goden`,`needident`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`letter`,`isrep`,`update`,`setsale`,`prototype`,`otdel`,`bs`,`gmp`,`includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`,`gmeshok`,`tradesale`,`karman`,`stbonus`,`upfree`,`ups`,`mfbonus`,`mffree`,`type3_updated`,`bs_owner`,`nsex`,`present_text`,`add_time`,`labonly`,`labflag`,`prokat_idp`,`prokat_do`,`arsenal_klan`,`repcost`,`up_level`,`ecost`,`group`,`ekr_up`,`unik`,`add_pick`,`pick_time`,`sowner`,`idcity`,`ekr_flag`)
					VALUES (30,'���������� ����� �����',0,1,0,{$tonick[id]},0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'oldbkloto.gif','',0,0,0,0,0,0,0,210,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'"."����� �".$new_bil_id."<br>����� �".$get_lot[id]."<br>C�������� ".date("Y-m-d H:i:s",$get_lot[lotodate])."',1,'".date("Y-m-d H:i:s")."',0,33333,'6',0,0,0,0,0,'',0,0,0,0,0,0,0,{$get_lot[id]},0,0,{$new_bil_id},0,0,0,NULL,0,0,0,0,NULL,'',0,0,2,0,NULL,0,NULL,NULL,0,'{$tonick[id_city]}','1');");
					$dress[id]=mysql_insert_id();
					$dress[idcity]=$tonick[id_city];
					}
					else
					{
						$good = 0;
					}

				if ($good)
					{
					mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr,addition) values ('wmr','8383','������','0','{$tonick['login']}','$bilprice','33333');");
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$bilprice}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					$id_ins_part_del=mysql_insert_id();
					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=8383;
					$rec['target_login']='������';
					$rec['type']=54;//������� ������� �� �������
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$bilprice;
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($dress);
					$rec['item_name']='���������� ����� �����';
					$rec['item_count']=1;
					$rec['item_type']=210;
					$rec['item_cost']=0;
					$rec['item_dur']=0;
					$rec['item_maxdur']=1;
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					$rec['bank_id']='';
					add_to_new_delo($rec); //�����

					  // ���������
					CheckRealPartners($tonick['id'],$bilprice,0);
				    	 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	  if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      	 {
				       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$bilprice}','0','".time()."');");
					      	 $bonus=round(($bilprice/100*$partner['percent']),2);
					      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$bilprice}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					     	 }
					}
					}

					if ($good)
					{

					if ($tonick['odate'] > (time()-60) )
					{
						addchp('<font color=red>��������!</font> ��� ������� <b>���������� ����� ����� x'.$kol.'</b>.','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� <b>���������� ����� ����� x'.$kol.'</b>.'."');");
					}


					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
					}

				    }

				}
				}


			    }
			    else if (($owner>0) and (in_array($param,$larec_param)))
			    {
			    		//addchp ('<font color=red>��������!</font>Debug0001 rub: '.$traderid,'{[]}Bred{[]}');
 	   			$tonick = check_users_city_data($owner);
  				$bankid =(int)$bankid;
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$RUR=get_rur_curs();
				$rur_cost=round($larec_prise[$param]*$RUR);
				$amount_test=round($amount);
				if ($amount_test==$rur_cost)
				{
				    		//addchp ('<font color=red>��������!</font>Debug0002 rub: '.$traderid,'{[]}Bred{[]}');
				//��� ��
				$balamount = number_format($larec_prise[$param],2,'.','');
				$amount = number_format($amount,2,'.','');
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = $bankid AND method='$method'");

				if(mysql_num_rows($q) == 0)
				{
			    		//addchp ('<font color=red>��������!</font>Debug0003 rub: '.$traderid,'{[]}Bred{[]}');
					$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid=0,bankid='$bankid',method='$method',amount='$amount',currency='$currency', balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'");
					$ins_id=mysql_insert_id();

	    			  if ($tonick['id'])
    				  {
			    		//addchp ('<font color=red>��������!</font>Debug0004 rub: '.$traderid,'{[]}Bred{[]}');
			    //��������� �����
			   	$lartid=$param;
				$get_my_box=mysql_fetch_array(mysql_query("select * from oldbk.boxs where box_type='{$larec_type[$param]}' and item_id=0 ORDER BY id  LIMIT 1"));
				if ($get_my_box[id] > 0) {
							    		//addchp ('<font color=red>��������!</font>Debug0005 rub: '.$traderid,'{[]}Bred{[]}');
					$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$lartid}' ;"));
					if ($dress[id]>0)  {
						mysql_query("update oldbk.boxs set item_id=1 where id='{$get_my_box[id]}' ;");
						if (mysql_affected_rows() > 0) {
									    		//addchp ('<font color=red>��������!</font>Debug0006 rub: '.$traderid,'{[]}Bred{[]}');
							$goden_do = mktime(23,59,59,1,31,date("Y")+1);
							$goden = round(($goden_do-time())/60/60/24); if ($goden<1) {$goden=1;}

								if(mysql_query("INSERT INTO oldbk.`inventory`
									(`getfrom`,`prototype`,`owner`,`sowner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
									`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
									`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
									`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`,`ekr_flag`
									)
									VALUES
									(30,'{$dress['id']}','{$tonick['id']}','0','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
									'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
									'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
									'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$tonick[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '','{$dress['ekr_flag']}'
									) ;"))
								{
									$larbox_id=mysql_insert_id();
									mysql_query("update oldbk.boxs set item_id='{$larbox_id}' where id='{$get_my_box[id]}' ;");
									$good = 1;
									$dress[id]=$larbox_id;
								} else
								{
									$good = 0;
								}

								if ($good)
								{
							    		//addchp ('<font color=red>��������!</font>Debug0007 rub: '.$traderid,'{[]}Bred{[]}');
								$laprice=$larec_prise[$param];

									mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr,addition) values ('wmr','8383','������','0','{$tonick['login']}','$laprice','2013');");
									mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$laprice}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������


									//new_delo
				  		    			$rec['owner']=$tonick['id'];
									$rec['owner_login']=$tonick['login'];
									$rec['owner_balans_do']=$tonick['money'];
									$rec['owner_balans_posle']=$tonick['money'];
									$rec['target']=8383;
									$rec['target_login']='������';
									$rec['type']=54;//������� ������� �� �������
									$rec['sum_kr']=0;
									$rec['sum_ekr']=$dress['ecost'];
									$rec['sum_kom']=0;
									$rec['item_id']=get_item_fid($dress);
									$rec['item_name']=$dress[name];
									$rec['item_count']=1;
									$rec['item_type']=$dress['type'];
									$rec['item_cost']=$dress['cost'];
									$rec['item_dur']=$dress['duration'];
									$rec['item_maxdur']=$dress['maxdur'];
									$rec['item_ups']=$dress['ups'];
									$rec['item_unic']=$dress['unic'];
									$rec['item_incmagic']=$dress['includemagicname'];
									$rec['item_incmagic_count']=$dress['includemagicuses'];
									$rec['item_arsenal']='';
									$rec['bank_id']='';
									$rec['item_proto']=$dress['prototype'];
									$rec['item_sowner']=($dress['sowner']>0?1:0);
									$rec['item_incmagic_id']=$dress['includemagic'];
									add_to_new_delo($rec); //�����

									mysql_query('INSERT INTO oldbk.boxs_history (`owner`,`box_type`,`selldate`) VALUES("'.$tonick['id'].'","'.$larec_type[$param].'","'.date("d/m/Y").'")');

									 // ���������
									CheckRealPartners($tonick['id'],$laprice,0);
									 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
								     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
								   	 if ($p_user['partner']!='' and $p_user['fraud']!=1)
									      {
									       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$laprice}','0','".time()."');");
									      	 $bonus=round(($laprice/100*$partner['percent']),2);
									      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$laprice}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
									      }

									telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress['name'].'</b> 1 ��. ������� �� �������!');

									return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
								}
								else
									{
									telepost_new($tonick,'<font color=red>��������!</font> ������! ���������� �������� ����� - �������� �������������!. ');
		       							return array('status'=>-1,'desc'=>'������! �������� ������!');
									}
						}
						else
						{
						// ����� ���� ��� ������ ���� �������� �������������
						telepost_new($tonick,'<font color=red>��������!</font> ������! ���������� �������� ����� - �������� �������������!. ');
		       				return array('status'=>-1,'desc'=>'������! ���������� ������!');
						}

		   			}
				}
				else
				{
				// ����� ���� ��� ������ ���� �������� �������������
				telepost_new($tonick,'<font color=red>��������!</font> ������! ���������� �������� ����� - �������� �������������!. ');
		       		return array('status'=>-1,'desc'=>'������! ��� ������!');
				}

			     }
				else
				{
				// ����� ���� ��� ������ ���� �������� �������������
		       		return array('status'=>-1,'desc'=>'������! �������� �� ������!');
				}


			     }
			     }
			     	else
				{
				// ����� ���� ��� ������ ���� �������� �������������
		       		return array('status'=>-1,'desc'=>'������! ���������� ���� �����!');
				}

			    }
			    else if (($owner>0) and ($param==222))
			  {
			  // ������ ������ ���
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

				//��� ������ ���� ��� ��������
				$get_com_wm=mysql_fetch_array(mysql_query("select * from com_requests where charid='{$tonick['id']}' and `type`='����� WMZ �������� ��� ������ �������� �������' and `status`='��������� ������' order by id desc limit 1"));
				if ($get_com_wm['Id']>0)
					{
					$now=date("d.m.y H:i",time());
					mysql_query("UPDATE `oldbk`.`com_requests` SET `status`=NULL , `paid`='�������� ".$now."'  WHERE `Id`='{$get_com_wm['Id']}' ");
					}

				if (mysql_affected_rows()>0)
				{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr) values ('wmr','8383','������','300','{$tonick[login]}','{$balamount}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������


					      // ���������
						CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }

					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}

				}
				}

			  }
			  */
 			 else if (($owner>0) and (in_array($param,$leto_bukets)) and ($bankid>0) )   //������
			  {
addchp ('<font color=red>��������!</font>Debug0015: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.',''); // ����
				$amount = number_format($amount,2,'.','');

				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

				$fid = $param;

				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['prototype'] = $fid;
				$dress['unik'] = 2;


				$k=0;
				$werrcount=0;

					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}

						else
						{
						$werrcount++;
						}

				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ ������� ������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and ($param==98)) //������� ���� �������
			  {
addchp ('<font color=red>��������!</font>Debug0016: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.',''); // ����
				$amount = number_format($amount,2,'.','');

				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='0',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 3001003;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
				$dress['ecost'] = 1;
				$dress['prototype'] = $fid;
				$dress['sowner']=$tonick['id'];

				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null))
					{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}

						else
						{
						$werrcount++;
						}

					}

					      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ ������� ��� werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and ($param==60))
			  {
addchp ('<font color=red>��������!</font>Debug0017: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.',''); // ����
				$amount = number_format($amount,2,'.','');

				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 56664;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 15;
				$dress['prototype'] = $fid;


				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null))
					{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}

						else
						{
						$werrcount++;
						}

					}

					      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ ������� ��� werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and ($param==94) and ($bankid>0) )//�������
			  {
addchp ('<font color=red>��������!</font>Debug0018: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 2014103;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
				$dress['ecost'] = 5;

				$dress['prototype'] = $fid;
				$dress['present'] = "�����";
				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=1;
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						//make_ekr_add_bonus($tonick,$bank,1,null,1,1);
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}
						else
						{
						$werrcount++;
						}

					}
				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			else if (($owner>0) and ($param==90||$param==89) and ($bankid>0) )//������� �������
			  {
addchp ('<font color=red>��������!</font>Debug0019: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 4016;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 3;
				$dress['goden']=90;
				$dress['ekr_flag']=1;
				$dress['prototype'] = $fid;

				if ($param==89)
						{
						$prise=2;
						}
						else
						{
						$prise=3;
						}

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$prise);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$prise}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������
					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			 else if (($owner>0) and ($param==81) and ($bankid>0) )
			  {
addchp ('<font color=red>��������!</font>Debug0020: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 3001005;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['prototype'] = $fid;

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and ($param==91) and ($bankid>0) )//������� �������
			  {
addchp ('<font color=red>��������!</font>Debug0021: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 100199;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 5;
				//$dress['present'] ='����';
				$dress['prototype'] = $fid;

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and (in_array($param,$exprun_param)) and ($bankid>0) )//������� ������� ����� ���
			  {
addchp ('<font color=red>��������!</font>Debug0022: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

				$fid = $param;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

				$dress['ecost']=$exprun_prise[$fid];
				$dress['prototype'] = $fid;
				$dress['ekr_flag']=1;

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and (in_array($param,$artup_param)) and ($bankid>0) )//�������
			  {
addchp ('<font color=red>��������!</font>Debug0023: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

				$fid = $param;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

				$dress['ecost']=$exprun_prise[$fid];
				$dress['prototype'] = $fid;

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and ($param==51 or  $param==52 or  $param==53 ) and ($bankid>0) )//������� �������
			  {
addchp ('<font color=red>��������!</font>Debug0024: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

					if ($param==53)
						{
						$fid = 14200;
						}
					elseif ($param==51)
						{
						$fid = 2016614;
						}
						else
						{
						$fid = 2016615;
						}

				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));


						if ($param==53)
						{
						$dress['ecost'] = 50;
						}
						elseif ($param==51)
						{
						$dress['ecost'] = 5;
						}
						else
						{
						$dress['ecost'] = 2;
						}

				$dress['prototype'] = $fid;
				$dress['ekr_flag']=1;

						if (($param==51) or ($param==52))
						{
						$dress['dategoden']=mktime(23,59,59,7,11,2016);
						$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}
						}

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
			  else if (($owner>0) and ($param==92) and ($bankid>0) )//������� ����������
			  {
addchp ('<font color=red>��������!</font>Debug0025: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 910;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
				$dress['ecost'] = 1;
				$dress['prototype'] = $fid;

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','555','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������
					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ �������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }

			  else if (($owner>0) and ($param==84) and ($bankid>0) )//������� ���
			  {
addchp ('<font color=red>��������!</font>Debug0026: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();

				$fid = 2016001;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
				$dress['ecost'] = 5;
				$dress['prototype'] = $fid;

				$dress['dategoden'] = mktime(23,59,59,5,2); //���� �������� ��� �� 23:59 2 ���.
				$dress['goden'] = round(($dress['dategoden']-time())/60/60/24);
				if ($dress['goden']<1) {$dress['goden']=1;}

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					}
						else
						{
						$werrcount++;
						}

					}

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.'). ������� ����!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ ������� ��������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }

			  else if (($owner>0) and ($param==95) and ($bankid>0) )//������� ��������
			  {
addchp ('<font color=red>��������!</font>Debug0027: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
				$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$fid = 3006000;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 1;
				$dress['prototype'] = $fid;

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$bankid}' and owner='{$owner}'  LIMIT 1;"));

				$kol=round($balamount/$dress['ecost']);
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++)
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$bankid}');");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������
						make_ekr_add_bonus($tonick,$bank,null,1,1);
						$bank['ekr']+=1;

					}
						else
						{
						$werrcount++;
						}

					}
				     mysql_query('UPDATE oldbk.variables_int SET value = value + '.$k.' WHERE var = "snowsell"');
				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }


				if ($k>0)
				{
				telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$k.') � ��������� '.($k).' ��� �� ���������� ���� �'.$bankid.'. ������� �� �������!');
				}

					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>��������!</font> WMR �������� {$amount} Param {$param} , UserID {$tonick[id]}, ������ ������� ��������  werrcount:{$werrcount} . ');");
						}
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
				}
				}
			  }
  			    else if (($owner>0) and (in_array($param,$podar)) and ($bankid>0) )
  			    {
addchp ('<font color=red>��������!</font>Debug0028: (WMR) add ekr:'.$balamount,'{[]}Bred{[]}');
  			    //������� ���������� ������������
  			    $tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$tobank	= mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = '{$bankid}' LIMIT 1;"));
				$total_summ=0;
				$prise=$podar_prise[$param];
				$kol=round($balamount/$prise);
										for ($kkk=1;$kkk<=$kol;$kkk++)
										{
										$ekr_bonus=round(($prise*$podar_ekr[$param]),2);
										$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$param}' ;"));
											if ($dress[id]>0)
											  {

											        if (time() >= $ny_events['sertstart'] && time() <= $ny_events['sertend']) {
													$dress['img'] = $podarny_img[$dress['id']];
												}

											        if (time() >= mktime(0,0,0,2,13,$ny_events_cur_y) && time() <= mktime(23,59,59,2,20,$ny_events_cur_y)) {
													$dress['img'] = $podarvl_img[$dress['id']];
													reset($podarvl);
													while(list($ka,$va) = each($podarvl)) {
														if ($dress['id'] == $va) {
															$dress['name'] = $ka;
														}
													}
												}


											        if (time() >= mktime(0,0,0,2,21,$ny_events_cur_y) && time() <= mktime(23,59,59,3,4,$ny_events_cur_y)) {
													$dress['img'] = $podar23_img[$dress['id']];
													reset($podar23);
													while(list($ka,$va) = each($podar23)) {
														if ($dress['id'] == $va) {
															$dress['name'] = $ka;
														}
													}
												}



											        if (time() >= mktime(0,0,0,3,5,$ny_events_cur_y) && time() <= mktime(23,59,59,3,31,$ny_events_cur_y)) {
													$dress['img'] = $podar8_img[$dress['id']];
													reset($podar8);
													while(list($ka,$va) = each($podar8)) {
														if ($dress['id'] == $va) {
															$dress['name'] = $ka;
														}
													}
												}


												mysql_query("INSERT INTO oldbk.`inventory`
													(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
														`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
														`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
														`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str." , `ab_mf`,`ab_bron`,`ab_uron`,`sowner`,`unik`
													)
													VALUES
													(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
													'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
													'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
													,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}' ".$sql." ,'{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$tonick['id']}',2
													) ;");
											if (mysql_affected_rows()>0)
													{
														$good = 1;
														$dress['prototype']=$dress[id];
														$new_vid=mysql_insert_id();
														$dress[id]=$new_vid;
														$dress['idcity']=0;

												mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','55','{$tonick[login]}','{$prise}','{$bankid}');");

												mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

												//new_delo
													$rec=array();
								  		    			$rec['owner']=$tonick[id];
													$rec['owner_login']=$tonick[login];
													$rec['owner_balans_do']=$tonick['money'];
													$rec['owner_balans_posle']=$tonick['money'];
													$rec['target']=$user[id];
													$rec['target_login']=$user[login];
													$rec['type']=82;//������� ���������� ���������� �� �������
													$rec['sum_kr']=0;
													$rec['sum_ekr']=$prise;
													$rec['sum_kom']=0;
													$rec['item_id']=get_item_fid($dress);
													$rec['item_name']=$dress[name];
													$rec['item_count']=1;
													$rec['item_type']=$dress['type'];
													$rec['item_cost']=$dress['cost'];
													$rec['item_dur']=$dress['duration'];
													$rec['item_maxdur']=$dress['maxdur'];
													$rec['item_ups']=$dress['ups'];
													$rec['item_unic']=$dress['unic'];
													$rec['item_incmagic']=$dress['includemagicname'];
													$rec['item_incmagic_count']=$dress['includemagicuses'];
													$rec['item_arsenal']='';
													$rec['add_info']=$ekr_bonus;
													$rec['bank_id']=$bankid;
													$rec['item_proto']=$dress['prototype'];
													$rec['item_sowner']=($dress['sowner']>0?1:0);
													$rec['item_incmagic_id']=$dress['includemagic'];
													add_to_new_delo($rec); //�����

												mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$ekr_bonus}' WHERE `id` = '{$bankid}' LIMIT 1;");
												$tobank['ekr']+=$ekr_bonus;
												mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','����� �� ������� ����������� �����������<b> {$ekr_bonus} ���.</b>,<i>(�����: {$tobank[cr]} ��., {$tobank['ekr']} ���.)</i>','{$bankid}');");
												$total_summ+=$prise;
												telepost_new($tonick,'<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b> � '.$ekr_bonus.'��� �� ���� �'.$bankid.'. ������� �� �������!');
													}
												}
											  } //for

												      // ��������� �� ��� �����
												CheckRealPartners($tonick['id'],$balamount,0);
												     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
												     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
												     if ($p_user['partner']!='' and $p_user['fraud']!=1)
												      {
												       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
												       $id_ins_part_del=mysql_insert_id();
												       $bonus=round(($balamount/100*$partner['percent']),2);
												       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
												      }

									//�����
									//make_ekr_add_bonus($tonick,$tobank,$total_summ,null);
									//give_bonus_meshok($tonick,$balamount);
									return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');
  			    		}
	  			        }
  			    }
 			 else if (($owner>0) and (in_array($param,$bukets)) and ($bankid>0) )
 			 {
 			 //������� ����
		addchp ('<font color=red>��������!</font>������� ����: '.$traderid,'{[]}Bred{[]}');
	  			$tonick = check_users_city_data($owner);
				$currency = mysql_escape_string($currency);
				$desc = mysql_escape_string(htmlspecialchars($desc));
				$balamount = number_format($balamount,2,'.','');
				$amount = number_format($amount,2,'.','');
				if ($tonick['id'])
				{
				$q = $this->query("select id from oldbk.trader_balance WHERE pid= '$pid' AND bankid = '$bankid'  AND traderid='$owner'  AND method='$method'");
				if(mysql_num_rows($q) == 0)
				{
				$this->query("INSERT INTO oldbk.trader_balance SET pid = '$pid',traderid='$owner',bankid='$bankid',method='$method',amount='$amount',currency='$currency',balanceamount='$balamount',timestamp=UNIX_TIMESTAMP(),`desc`='$desc'	");
				$ins_id=mysql_insert_id();
				$tobank	= mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = '{$bankid}' LIMIT 1;"));
				$elkaid=(int)$param;
				$prise=$bukets_prise[$elkaid];
				//$prise=round(($prise/2),2);
				$balamount=round($balamount,2);
				if ($balamount>=$prise)
				{
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$elkaid}' ;"));
				$bukname=$dress[name];

				$elkagoden = $ny_events_cur_m == 12 ? mktime(23,59,59,2,29,$ny_events_cur_y+1) : mktime(23,59,59,2,29,$ny_events_cur_y);
				$elkatime = time()+($dress['goden']*3600*24);
				if ($elkatime > $elkagoden) { 		$elkatime = $elkagoden; 		}

				mysql_query("INSERT INTO oldbk.`inventory`
					(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
							`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
						`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`,`ekr_flag`,`stbonus`
					)
					VALUES
					(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
					'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$elkatime."',
					'{$dress['goden']}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}','{$dress['ekr_flag']}','{$dress['stbonus']}'
					) ;");

			if (mysql_affected_rows()>0)
				{
					$buket_id=mysql_insert_id();
					$good = 1;
					$dress[id]=$buket_id;

					mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('wmr','8383','������','2011','{$tonick[login]}','{$prise}','{$bankid}');");
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '8383' LIMIT 1;"); //  �������  �� �������  �������

					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=8383;
					$rec['target_login']='������';
					$rec['type']=54;//������� ������� �� �������
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$dress['ecost'];
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($dress);
					$rec['item_name']=$dress[name];
					$rec['item_count']=1;
					$rec['item_type']=$dress['type'];
					$rec['item_cost']=$dress['cost'];
					$rec['item_dur']=$dress['duration'];
					$rec['item_maxdur']=$dress['maxdur'];
					$rec['item_ups']=$dress['ups'];
					$rec['item_unic']=$dress['unic'];
					$rec['item_incmagic']=$dress['includemagicname'];
					$rec['item_incmagic_count']=$dress['includemagicuses'];
					$rec['item_arsenal']='';
					$rec['bank_id']=$bankid;
					$rec['item_proto']=$dress['prototype'];
					$rec['item_sowner']=($dress['sowner']>0?1:0);
					$rec['item_incmagic_id']=$dress['includemagic'];
					add_to_new_delo($rec); //�����


												      // ���������
												     CheckRealPartners($tonick['id'],$balamount,0);
												     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
												     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
												     if ($p_user['partner']!='' and $p_user['fraud']!=1)
												      {
												       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('8383','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
												       $id_ins_part_del=mysql_insert_id();
												       $bonus=round(($balamount/100*$partner['percent']),2);
												       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
												      }
					telepost_new($tonick,'<font color=red>��������!</font> ��� �������� <b>'.$bukname.'</b>. ������� ����!');
					//make_ekr_add_bonus($tonick,$tobank,$prise,null);

					/*
					//������ �� �����
					$dr=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id=55555"));
					$dr['ecost'] = 1;
					$dr['prototype'] = 55555;
					$dr['sowner']=$tonick['id'];
					$dr['present'] ='�����';
					by_item_bank_dil($tonick,$dr,null);
					*/
					//give_bonus_meshok($tonick,$balamount);
					return array('status'=>1,'id'=>$ins_id,'desc'=>'������ ������� ��������');

				}
			}
			}
			}

  		}
  		else
  		{
		addchp ('<font color=red>��������!</font>Debug9999: (WMR error) add ekr:'.$balamount,'{[]}Bred{[]}');
  		}

	return array('status'=>-1,'desc'=>'������ - ������ ���� �� ���������������');
	}

	function query($query){

		$q = mysql_query($query);
	   //mail('admin@oldbk.com','mysqlEr',"$query $mErr");
		return $q;
	}

	function sendlog(){
		$a = array();
		foreach($_POST as $k =>$v)$a[] = "$k => $v";
		//mail('admin@oldbk.com','wmReqs',implode("\n",$a));
	}




}
?>
