<?php
	session_start();
	include "connect.php";

	if((isset($_COOKIE["link_from_com"])) and ($_COOKIE["link_from_com"]!=''))
		{
		header("Location: ".$_COOKIE["link_from_com"]);
		setcookie ("link_from_com", '',time()-86400,'/','.oldbk.com', false);//������� ����
		die();
		}
	$array_auto_dil=array(9085,125544,266543,188); //7912
	$gcost=0.05; //1 ������� = 0,05 $ 	     100 ����� = 5$
	include "config_ko.php";
	include "ny_events.php";
	if ( (isset($_SESSION['dill_protect'])) and $_SESSION['dill_protect']>=(time()-1) )
		{
		die('������ �� ���������� �������!');
		}

	$_SESSION['dill_protect']=time();



function get_all_logins($us)
{
$getlog=mysql_fetch_array(mysql_query("select * from users where login='{$us}'"));

	if ($getlog['id']>0)
		{
		$logarr[]="'".$us."'";
		$getall_login=mysql_query("select * from oldbk.users_nick_hist where uid='{$getlog['id']}' ");
		while($data=mysql_fetch_array($getall_login))
					        {
						$logarr[]="'".$data['old_login']."'";
					        }

		return $logarr;
		}
return false;
}

function jail_goway($teloid,$sum,$SC)
{
$course_ekr_kr=10; //����

$cit[0]='oldbk.';
$cit[1]='avalon.';
$cit[2]='angels.';

	 $tonick =check_users_city_data($teloid);
 	 $dbc=$cit[$tonick[id_city]];

	$balamount = $sum;

				//1 ���� �����
				$get_eff=mysql_fetch_array(mysql_query("select * from {$dbc}effects where owner='{$teloid}' and type=4 and lastup > 0 "));
				if ($get_eff[id]>0)
				{
				$DOLG_EKR=0;
				$vikup=unserialize($get_eff['add_info']);
				if ($vikup[kr]>0) { $DOLG_EKR+=round(($vikup[kr]/$course_ekr_kr),2); }
				if ($vikup[ekr]>0) { $DOLG_EKR+=$vikup[ekr]; }

				if  ($sum>=$DOLG_EKR)
					{
					///���� ��� ����
					$mess = "�������� ������� �� �����, ���� ������� ����� ��. {ee}DEALER{ee}.";
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','".$mess."','".time()."');");

					mysql_query("update {$dbc}users set palcom = '', align=0 where id='".$tonick[id]."' ");
					mysql_query("DELETE from {$dbc}effects where type=4 AND owner='".$tonick[id]."' and lastup > 0");
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
											$rec['add_info']='���� �SC'.$SC;
											add_to_new_delo($rec); //�����
					}
					else
					{
					//���� �� ������ ������
						if ($vikup[kr]>0)
						{
						$vikup[kr]-=round(($sum*$course_ekr_kr),2); // ����� �������� ����

						if ($vikup[kr]<0)
							{
							//���� ���������� ������ ��� ���� - ������ �����
							$sum=-(round(($vikup[kr]/$course_ekr_kr),2));
							$vikup[kr]=0;
							}
						}

						if ($vikup[ekr]>0)
						{
						$vikup[ekr]-=$sum;
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
											$rec['add_info']='���� �SC'.$SC.'  (��������� ���������) ';
											add_to_new_delo($rec); //�����

					}
				}
				else
				{
	 			addchp ('<font color=red>��������!</font>������ ������ �� ��� �� � ����� id:'.$qiwi[owner_id],'{[]}Bred{[]}',-1,-1);
				}

}

	if ($_GET[xml])
	{
	header ("content-type: text/xml");
	echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
	echo "<message refresh=\"".time()."\">";

	$XML_OUT=true;
	$USER_ID=(int)($_GET[user_id]);
		if (in_array($USER_ID,$array_auto_dil))
		{
		$ORDER_ID=(int)($_GET[order_id]);
		if ($ORDER_ID>0)
			{
			$test_auto_login = mysql_fetch_array(mysql_query("SELECT id,login,pass FROM oldbk.`users` WHERE `id` = '{$USER_ID}' LIMIT 1;"));
			if (($test_auto_login[id]>0) and ($USER_ID==$test_auto_login[id]))
				{
				 include "alg.php";
				 $SIGN=md5($test_auto_login[id].out_smdp_new($test_auto_login[pass]));
					if ($SIGN==$_GET[sign])
					{
					mysql_query("INSERT INTO `oldbk`.`dealers_tranz` SET `tranz`='{$ORDER_ID}',`dilid`='{$USER_ID}';");
					  if (mysql_affected_rows()>0)
						{
					     	$_SESSION['sid'] = session_id();
					    	$_SESSION['uid']=$test_auto_login[id];
						$_SESSION['ip']=$_SERVER['REMOTE_ADDR'];
				        	mysql_query("UPDATE `users` SET `ldate`=0, `sid` = '".session_id()."' WHERE `id` = {$USER_ID};");
				        	}
				        	else
				        	{
				        	echo "<answer code='18'>������! ORDER_ID ��� ��� �����������!</answer>";
						unset($_SESSION);
						session_destroy();
						die("</message>");
				        	}
					}
					else
					{
					echo "<answer code='13'>������ �����������!</answer>";
					unset($_SESSION);
					session_destroy();
					die("</message>");
					}
				}
				else
				{
				echo "<answer code='12'>������ �����������!</answer>";
				unset($_SESSION);
				session_destroy();
				die("</message>");
				}
			}
			else
				{
				echo "<answer code='17'>������ ORDER_ID!</answer>";
				unset($_SESSION);
				session_destroy();
				die("</message>");
				}
		}
		else
		{
		echo "<answer code='11'>������ �����������!</answer>";
		unset($_SESSION);
		session_destroy();
		die("</message>");
		}
	}

	if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com')
	{
	//�������� �� ������������ ������ - � ��� ���������� ���� ��������� ������
	if ((!($_SESSION['uid'] >0)) )   { header("Location: http://avaloncity.oldbk.com/dealer.php"); die();}
	}

	if ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com')
	{
	//�������� �� �����
	if ((!($_SESSION['uid'] >0)) )   { header("Location: http://angelscity.oldbk.com/dealer.php"); die();}
	}

	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }


	include "functions.php";
	include "clan_kazna.php";
	include "bank_functions.php";

/*
if ($user['id'] == 102904) {
	$ny_events['elkadropstart'] = time()-14400;
	$ny_events['elkadropend'] = time()+14400;
}

if ($user['klan'] == 'radminion')
	{
	print_r($_POST);
	}
*/
///////////////////////////////////////////////////////////////////////
// ��������� �������� ��� ���������� ����

//if ( isset($_POST[qiwimkbill]) and  isset($_POST[amount_rub]) and  isset($_POST[to]) and ($_POST[amount_rub] >0)   )
if (1==2)
{
$am_rub=(int)($_POST[amount_rub]);
$qiwi_to=(int)($_POST[to]);

		//������� ���
		$RUR_CUR=get_rur_curs_bank();
		$qiwi_ekr=round(($am_rub*$RUR_CUR),2);
		if ($qiwi_ekr > 0)
		{
		//��������� �������� �������
		 if ($user['id']==7108)
		 {
		$qiwi_ekr = round((($qiwi_ekr*0.08)+$qiwi_ekr),2);
		 }
		 else
		 {
		$qiwi_ekr = round((($qiwi_ekr*0.10)+$qiwi_ekr),2);
		}
		$RUR=get_rur_curs();

		//������� ���� � ���� ��� ����
		mysql_query("INSERT INTO `oldbk`.`trader_balance_qiwi` SET `owner`='{$user[login]}',`owner_id`='{$user[id]}',`param`='555',`sum_ekr`='{$qiwi_ekr}',`sum_rub`='{$am_rub}',`qiwi`='{$qiwi_to}' , kurs='{$RUR}' ;");
			 if (mysql_affected_rows()>0)
			{
			 $txn_id=mysql_insert_id();
			$linkqiwi="http://w.qiwi.ru/setInetBill_utf.do?frm=1&from=6920&lifetime=0.0&check_agt=false&com=".urlencode(iconv("CP1251","UTF-8","���������� � ������� oldbk.com �� {$qiwi_ekr} ���."))."&to={$qiwi_to}&txn_id={$txn_id}&amount_rub={$am_rub}";
			//echo $linkqiwi;
			$f=@fopen($linkqiwi,"r");
				if($f)
				{
				fclose($f);
				$qiwi_mes='<font color=red>���� ������ ���������!</font>';
				}
				else
				{
				$qiwi_mes='<font color=red>���� �� ���������, ��������� �����!</font>';
				}
			}
		}
}


////////////////////////////////////////////////////////////////////
$POD=0; // �������� �� ������� ���������� ������������
//$POD=1; // �������� �� ������� ���������� ������������

if ($user['id']==14897 || $user['id']==102904)
{
$POD=1;
}

//������ ������� ���������� [22:07:53] ������: � 00 13�� �� 23:59 15��
if ( (time()>=1392235200) AND (time()<=1392494399) )  {$VALENT=1;}
if ((time()>=mktime(0, 0, 0, 2, 11, 2016)) AND (time()<=mktime(23, 59, 59, 2, 20, 2016)) )  {$VALENT_2015=1;}
if ($user[id]==14897)
{
$KO_start_time28=time()-1;
}


$valentinka=array(

				"C����-���������� � ��������� (�����)"=>900,
				"C����-���������� � ��������� (���������)"=>901,
				"C����-���������� � ��������� (�������)"=>902,
				"C����-���������� � ��������� (������)"=>903,
				"C����-���������� � ������� (�������)"=>904,
				"C����-���������� � ������� (�������)"=>905,
				"C����-���������� � ������� (�����)"=>906,
				"C����-���������� � ��������� (�������)"=>907,
				"C����-���������� � ��������� (�������)"=>908);

$valentinka_prise=array(
				900=>1,
				901=>1,
				902=>1,
				903=>1,
				904=>1,
				905=>1,
				906=>1,
				907=>1,
				908=>1);

$podar =array(
			"���������� ���������� - 1 ���" =>200001,
			"���������� ���������� - 2 ���" =>200002,
			"���������� ���������� - 5 ���" =>200005,
			"���������� ���������� - 10 ���" =>200010,
			"���������� ���������� - 25 ���" =>200025,
			"���������� ���������� - 50 ���" =>200050,
			"���������� ���������� - 100 ���" =>200100,
			"���������� ���������� - 250 ���" =>200250,
			"���������� ���������� - 500 ���" =>200500);

$podarvl =array(
			"���������� ���������� - ���������� - 1 ���" =>200001,
			"���������� ���������� - ���������� - 2 ���" =>200002,
			"���������� ���������� - ���������� - 5 ���" =>200005,
			"���������� ���������� - ���������� - 10 ���" =>200010,
			"���������� ���������� - ���������� - 25 ���" =>200025,
			"���������� ���������� - ���������� - 50 ���" =>200050,
			"���������� ���������� - ���������� - 100 ���" =>200100,
			"���������� ���������� - ���������� - 250 ���" =>200250,
			"���������� ���������� - ���������� - 500 ���" =>200500);

$podar23 =array(
			"���������� ���������� - 23 ������� - 1 ���" =>200001,
			"���������� ���������� - 23 ������� - 2 ���" =>200002,
			"���������� ���������� - 23 ������� - 5 ���" =>200005,
			"���������� ���������� - 23 ������� - 10 ���" =>200010,
			"���������� ���������� - 23 ������� - 25 ���" =>200025,
			"���������� ���������� - 23 ������� - 50 ���" =>200050,
			"���������� ���������� - 23 ������� - 100 ���" =>200100,
			"���������� ���������� - 23 ������� - 250 ���" =>200250,
			"���������� ���������� - 23 ������� - 500 ���" =>200500);


$podar8 =array(
			"���������� ���������� - 8 ����� - 1 ���" =>200001,
			"���������� ���������� - 8 ����� - 2 ���" =>200002,
			"���������� ���������� - 8 ����� - 5 ���" =>200005,
			"���������� ���������� - 8 ����� - 10 ���" =>200010,
			"���������� ���������� - 8 ����� - 25 ���" =>200025,
			"���������� ���������� - 8 ����� - 50 ���" =>200050,
			"���������� ���������� - 8 ����� - 100 ���" =>200100,
			"���������� ���������� - 8 ����� - 250 ���" =>200250,
			"���������� ���������� - 8 ����� - 500 ���" =>200500);




$podarny_img = array(
	200001 => "GiftCard1_1.gif",
	200002 => "GiftCard2_1.gif",
	200005 => "GiftCard5_1.gif",
	200010 => "GiftCard10.gif",
	200025 => "GiftCard25.gif",
	200050 => "GiftCard50.gif",
	200100 => "GiftCard100.gif",
	200250 => "GiftCard250.gif",
	200500 => "GiftCard500.gif",
);

$podarvl_img = array(
	200001 => "val_GiftCard_1.gif",
	200002 => "val_GiftCard_2.gif",
	200005 => "val_GiftCard_5.gif",
	200010 => "val_GiftCard_10.gif",
	200025 => "val_GiftCard_25.gif",
	200050 => "val_GiftCard_50.gif",
	200100 => "val_GiftCard_100.gif",
	200250 => "val_GiftCard_250.gif",
	200500 => "val_GiftCard_500.gif",
);

$podar23_img = array(
	200001 => "23f_GiftCard_1.gif",
	200002 => "23f_GiftCard_2.gif",
	200005 => "23f_GiftCard_5.gif",
	200010 => "23f_GiftCard_10.gif",
	200025 => "23f_GiftCard_25.gif",
	200050 => "23f_GiftCard_50.gif",
	200100 => "23f_GiftCard_100.gif",
	200250 => "23f_GiftCard_250.gif",
	200500 => "23f_GiftCard_500.gif",
);

$podar8_img = array(
	200001 => "8m_GiftCard_1.gif",
	200002 => "8m_GiftCard_2.gif",
	200005 => "8m_GiftCard_5.gif",
	200010 => "8m_GiftCard_10.gif",
	200025 => "8m_GiftCard_25.gif",
	200050 => "8m_GiftCard_50.gif",
	200100 => "8m_GiftCard_100.gif",
	200250 => "8m_GiftCard_250.gif",
	200500 => "8m_GiftCard_500.gif",
);



$podar_prise = array (
			"200001" =>1,
			"200002" =>2,
			"200005" =>5,
			"200010" =>10,
			"200025" =>25,
			"200050" =>50,
			"200100" =>100,
			"200250" =>250,
			"200500" =>500);

$podar_ekr = array (
			"200001" =>"0.01",
			"200002" =>"0.01",
			"200005" =>"0.01",
			"200010" =>"0.02",
			"200025" =>"0.03",
			"200050" =>"0.04",
			"200100" =>"0.05",
			"200250" =>"0.06",
			"200500" =>"0.07");
////////////////////////////////////////////////////////////////////

$VAU=0;//�������� ������� ��������
$vaucher = array (
			"������ 5 ���" =>100005,
			"������ 15 ���" =>100015,
			"������ 20 ���" =>100020,
			"������ 25 ���" =>100025,
			"������ 40 ���" =>100040,
			"������ 100 ���" =>100100,
			"������ 200 ���" =>100200,
			"������ 300 ���" =>100300);

$vaucher_prise = array (
			"100005" =>5,
			"100015" =>15,
			"100020" =>20,
			"100025" =>25,
			"100040" =>40,
			"100100" =>100,
			"100200" =>200,
			"100300" =>300);
/////////////////////////////////////////////////////////////////////
//	"������ ��������"=>2003,
$artifakts = array (
			"������ ���������� �����" =>2000,
			"��� �������� �����" =>2001,
			"����� ������ �������"=>2002,
			"������ ���������� �����"=>260,
			"���� �������� �����"=>262,
			"������� ����� ��������"=>284,
			"������� ������ ��������"=>283,
			"������ ������ ������"=>18210,
			"������ �������� ������"=>18229,
			"��� ����������"=>18247,
			"������� ��� ����"=>18527);


if ((time()>$KO_start_time26) and (time()<$KO_fin_time26))
	{
	$ART_ACTION=true;
	$artifakts_prise = array (
			"2000" =>140,
			"2001" =>140,
			"2002"=>140,
			"260"=>140,
			"262"=>140,
			"284"=>140,
			"283"=>140,
			"18210"=>140,
			"18229"=>140,
			"18247"=>140,
			"18527"=>140,
			"100029"=>55, //�������� ��������
			"7002"=>55, //���� �����
						);

	$artifakts["�������� �������� (��)"]="100029";
	$artifakts["���� ����� (��)"]="7002";
	}
	else
	{
	$artifakts_prise = array (
			"2000" =>275,
			"2001" =>275,
			"2002"=>275,
			"260"=>275,
			"262"=>275,
			"284"=>275,
			"283"=>275,
			"18210"=>275,
			"18229"=>275,
			"18247"=>275,
			"18527"=>275);
	}
////////////////////////////////////////////////////////////////////
	$bukets = array (
/*
			"���������� ���� 1 (���)" =>55510312,
			"���������� ���� 2 (���)" =>55510313,
			"���������� ���� 3 (���)"=>55510314,
			"���������� ���� 4 (���)"=>55510315,
			"���������� ���� 5 (���)"=>55510316,
			"���������� ���� 6 (���)"=>55510317,
			"���������� ���� 7 (���)"=>55510318,
			"���������� ���� 8 (���)"=>55510319,
			"���������� ���� 9 (���)"=>55510320,
			"���������� ���� 10 (���)"=>55510321,
			"���������� ���� 11 (���)"=>55510322,
			"���������� ���� 12 (���)"=>55510334,
			"���������� ���� 13 (���)"=>55510335,
			"���������� ���� 14 (���)"=>55510336,
			"���������� ���� 15 (���)"=>55510337,
			"���������� ���� 16 (���)"=>55510338,
			"���������� ���� 17 (���)"=>55510339,
			"���������� ���� 1 (���)"=>55510323,
			"���������� ���� 2 (���)"=>55510324,
			"���������� ���� 3 (���)"=>55510325,
			"���������� ���� 4 (���)"=>55510326,
			"���������� ���� 5 (���)"=>55510327,
			"���������� ���� 6 (���)"=>55510340,
			"���������� ���� 7 (���)"=>55510341,
			"���������� ���� 8 (���)"=>55510342,
			"���������� ���� 9 (���)"=>55510343,
			"���������� ���� 10 (���)"=>55510344
*/
			"���������� ���� 2017"=>55510350,
			"���������� ���� 2017 (���)"=>55510351,
			);
$bukets_prise= array (
/*
			55510312=>15,
			55510313=>15,
			55510314=>15,
			55510315=>15,
			55510316=>15,
			55510317=>20,
			55510318=>20,
			55510319=>20,
			55510320=>20,
			55510321=>20,
			55510322=>20,
			55510334=>25,
			55510335=>25,
			55510336=>25,
			55510337=>25,
			55510338=>25,
			55510339=>25,
			55510323=>200,
			55510324=>200,
			55510325=>200,
			55510326=>200,
			55510327=>200,
			55510340=>250,
			55510341=>250,
			55510342=>250,
			55510343=>250,
			55510344=>250
*/
                        55510350 => 5,
                        55510351 => 15,
			);

$elka_gold =array (
                        55510350 => 100,
                        55510351 => 300,
			);
///////////////////////////////////////////////////////


$leto_bukets = array (
			"����� ������ ������ (6)"=>410021,
			"����� ����������� ������ (9)"=>410022,
			"����� ������������� ����� (12)"=>410023,
			"����� ���������� �������� (10)"=>410024,
			"����� �������� ����� (11)"=>410025,
			"����� �������� ����� (13)"=>410026

			);
$leto_bukets_prise= array (
                        410021 => 10,
                        410022 => 10,
                        410023 => 10,
                        410024 => 10,
                        410025 => 10,
                        410026 => 10,
			);
///////////////////////////////////////////////////////


$lar_box = array (
		"��������� �����" => 2014001,
		//"��������� �����" => 2014002,
		//"����������� �����" => 2014003,
		"������� �����" => 2014004);

$lar_box_prise = array (
		2014001=>5,
		//2014002=>30,
		//2014003=>40,
		2014004=>25);


$egg_box = array (
		"���������� ���� �������" => 2016001  );

$egg_box_prise = array (
		2016001=>5);


//////////////////////////////////////////////////////

		if (($XML_OUT) AND ($_POST[get_vauch]))
		{
		echo "<answer code='0' type='13' login='{$user[login]}' >�������!";
				foreach ($vaucher as $k=>$v)
				{
				echo "<item id='{$v}'>{$k}</item>";
				}
				echo "</answer>";
				unset($_SESSION);
				session_destroy();
				die("</message>");
		}



	if ($user[id]==76009) { die(); }
	if ($user[id]==6745) { die(); }


	$bot_login=$user['login'];
	$bot_id=$user['id'];

	$al = mysql_fetch_assoc(mysql_query("SELECT * FROM `aligns` WHERE `align` = '{$user['align']}' LIMIT 1;"));
	if  (stripos($user['login'],"auto-") !== false )
	{

				$botfull=$user['login'];
				$botlogin=substr($user['login'], 5); // �������� ����� auto-
				//list($bot, $botlogin) = explode("-", $user['login']); //�� ����� ���� ��� � ���������
			if ($botlogin)
			{
			$bot=true;
				$botnick = mysql_fetch_array(mysql_query("SELECT login,id FROM `users` WHERE `login` = '{$botlogin}' LIMIT 1;"));
				$user['login']=$botnick['login'];
				$user['id']=$botnick['id'];
			}
			else
			{
			die();
			}

	}

        $dealer = $balans = mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.`dealers` WHERE `owner` = '{$user['id']}' LIMIT 1;"));


		if (($XML_OUT) AND ($_POST[get_dil_balans]))
		{
		echo "<answer code='0' type='12' ekr='{$balans[sumekr]}' login='{$user[login]}' >�������!</answer>";
				unset($_SESSION);
				session_destroy();
				die("</message>");
		}



	if (($user['deal'] == 0) AND ($user[room]==29))
		{
		  header('location: bank.php?ok=1');die();
		}


if ($XML_OUT)
{


}
else
{
header("Cache-Control: no-cache");
echo '<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script type="text/javascript" src="/i/globaljs.js"></script>
<style>
	.row {
		cursor:pointer;
	}
</style>
<script type="text/javascript">

function callcekr(rub,kurs)
{
document.getElementById("qekr").value=((rub/kurs)*1.1).toFixed(2);
}

function callcrub(ekr,kurs)
{
document.getElementById("qrub").value=(((ekr*kurs)*100)/110).toFixed(2);
}

function callcekrwmr(rub,kurs)
{
document.getElementById("wmrekr").value=((rub/kurs)*1.1).toFixed(2);
}

function callcrubwmr(ekr,kurs)
{
document.getElementById("wmrrub").value=(((ekr*kurs)*100)/110).toFixed(2);
}

  function show(ele) {
      var srcElement = document.getElementById(ele);
      if(srcElement != null) {
          if(srcElement.style.display == "block") {
            srcElement.style.display= "none";
          }
          else {
            srcElement.style.display="block";
          }
      }
  }


</script>

</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
<table align=right><tr><td><INPUT TYPE="button" onclick="location.href=\'main.php\';" value="���������" title="���������"></table>';
}

	if ($user['deal'] == 1 || $user['id'] == 326 || $user['id'] == 8540 || $user['id'] == 28453 || $user['id'] == 14897 || $user['id'] == 102904 || $user['id'] == 6745 || $user['id'] == 546433)
	{

		if (!($XML_OUT))
		{
			if ($user['sex'] == 1)
			{
			echo "<h3>������� �����, ���� {$user['login']}!</h3>";
			}
			else
			{
			echo "<h3>������� �����, ������ {$user['login']}!</h3>";
			}
		}


if (!($XML_OUT))
	{
	///�������� - ��������� ������ �� �����!!!
	if($_POST['grn'] && $_POST['gr'])
	{

		$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['grn']}' LIMIT 1;"));
		if ($tonick[id] >0 )
		{
			$tonick=check_users_city_data($tonick[id]);
			echo telegraph_new($tonick,$_POST['gr']) ;
		}
		else
		{
			echo "�������� �� ������!";
		}
	}


	echo '<h4>��������</h4>�� ������ ��������� �������� ��������� ������ ���������, ���� ���� �� ��������� � offline ��� ������ ������.
<form method=post style="margin:5px;">�����: <input type=text size=20 name="grn"> ����� ���������: <input type=text size=80 name="gr" maxLength="150"> <input type=submit value="���������"></form>';
	echo "<HR>";
	}


	if (($_POST['putekr'] && $balans['sumekr'] >= round($_POST['ekr'],2)) and (round($_POST['ekr'],2)>0))
	{
		$_POST['bank']=(int)($_POST['bank']);

		if (($_POST['ekr']) && ($_POST['tonick'])) {

			$tonick = check_users_city_datal($_POST['tonick']);

				if ($_POST['bank']>0)
					{
					$bank = mysql_fetch_array(mysql_query("SELECT owner,id FROM oldbk.`bank` WHERE `id` = '{$_POST['bank']}' LIMIT 1;"));
					}
				else
					{
					$bank = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' order by def desc,id limit 1"));
					}


			if ($bank['owner'] && $tonick['id'] && $bank['owner'] == $tonick['id']) {
				$_POST['ekr'] = round($_POST['ekr'],2);


				//������� �����
				/*
					if (BONUS_REAL_PREM)
					{
	  				$pbm[0]=1;
					$pbm[1]=1.01;
					$pbm[2]=1.02;
					$pbm[3]=1.05;
					$pbm=$pbm[$tonick['prem']];
					}
				else
				*/
					{
					$pbm=1;// ��������� ������
					}



				if ((time()>$KO_start_time40) and (time()<$KO_fin_time40))
				{
					$add_ekr_to_kazna=round($_POST['ekr']*0.5,2);

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
					$add_ekr_to_user=round(($_POST['ekr']*($pbm+$KO_A_BONUS)) ,2);
					$ko_bonus=$add_ekr_to_user-$_POST['ekr']; // ��� ������ � ������
				}
				elseif ((time()>$KO_start_time38) and (time()<$KO_fin_time38))
				{
					$kb=act_x2bonus_limit($tonick,1,$_POST['ekr']);
					if ($kb>0)
						{
						$ko_bonus=$kb;
						$add_ekr_to_user=round($_POST['ekr']+$ko_bonus,2);
						}
						else
						{
						$add_ekr_to_user=round($_POST['ekr'],2);
						$ko_bonus=0;
						}
				}
				else
				{
						$add_ekr_to_user=round(($_POST['ekr']*$pbm) ,2); //+2%
						$ko_bonus=$add_ekr_to_user-$_POST['ekr']; // ��� ������ � ������
				}

				$real_flag=1;
				if (($user['klan']=='radminion') OR ($user['klan']=='Adminion') )
					{
						if ($_POST['real']!='yes')
						{
						$real_flag=0;
						}
					}



				if (mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$add_ekr_to_user}' WHERE `id` = '{$bank['id']}' LIMIT 1;") ) {
					if ($bot && $botlogin) {
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,b) values ('{$_SESSION['uid']}','{$botfull}','{$bank['id']}','{$_POST['tonick']}','{$_POST['ekr']}','{$real_flag}' );");
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,b) values ('{$user['id']}','{$user['login']}','{$bank['id']}','{$_POST['tonick']}','{$_POST['ekr']}','{$real_flag}' );");
					}
					else {
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,b) values ('{$user['id']}','{$user['login']}','{$bank['id']}','{$_POST['tonick']}','{$_POST['ekr']}','{$real_flag}');");
					}

					if ($ko_bonus > 0)
						{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,b) values (450,'KO','{$bank['id']}','{$_POST['tonick']}','{$ko_bonus}','{$real_flag}' );");
						}

					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$_POST['ekr']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

				      // ���������
					CheckRealPartners($tonick['id'],$_POST['ekr'],$_SESSION['uid']);
				     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				     if ($p_user['partner']!='' and $p_user['fraud']!=1)
				      {
				       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$_POST['ekr']}','{$bank['id']}','".time()."');");
				       $id_ins_part_del=mysql_insert_id();
				       $bonus=round(($_POST['ekr']/100*$partner['percent']),2);
				       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$_POST['ekr']}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");

				      }

				      	//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=51;//������� �� �������
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$add_ekr_to_user;
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
					$rec['bank_id']=$bank['id'];

					add_to_new_delo($rec); //�����

					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�������� <b>".$add_ekr_to_user." ���.</b>, �� ������ ".$user['login'].". (<i>�����: {$bank[cr]} ��., ".($bank['ekr']+$add_ekr_to_user)." ���. </i>)','{$bank[id]}');");

					telepost_new($tonick,'<font color=red>��������!</font> �� ��� ���� �'.$bank['id'].' ���������� '.$_POST['ekr'].' ���. �� ������ '.$user['login'].'. ������� ����!');

						if ($ko_bonus > 0)
						{
							if ((time()>$KO_start_time) and (time()<$KO_fin_time))
							{
							telepost_new($tonick,'<font color=red>��������!</font> �� ��� ���� �'.$bank['id'].' ���������� '.$ko_bonus.' ���. ��  ������������� ������, � ������ <a href="http://oldbk.com/encicl/?/act_ekr.html" target="_blank">�����</a>.');
							}
							elseif ((time()>$KO_start_time38) and (time()<$KO_fin_time38))
							{
							telepost_new($tonick,'<font color=red>��������!</font> �� ��� ���� �'.$bank['id'].' ���������� '.$ko_bonus.' ���. ��  ������������� ������, � ������ ����� <a href="http://oldbk.com/encicl/?/act_x2bonus.html" target="_blank">�������� ������</a>. ����� �������� �������� � �� ���������������� �� ����������� ������� ���� ������.');
							}
							else
							{

							$yyy[1]='Silver';
							$yyy[2]='Gold';
							$yyy[3]='Platinum';

							telepost_new($tonick,'<font color=red>��������!</font> �� ��� ���� �'.$bank['id'].' ���������� '.$ko_bonus.' ���. ��  ������������� ������, �� ������� "'.$yyy[$tonick[prem]].'  account".');
							}
						}

					///����� � ������� �����
					if ($real_flag==1)
					{
					mysql_query("INSERT INTO `oldbk`.`exchange_log` SET `owner`='{$tonick['id']}' , `dilekr`='{$add_ekr_to_user}'  ON DUPLICATE KEY UPDATE dilekr=dilekr+'{$add_ekr_to_user}' ");
					}

					if($dealer['discount']) {
						//discount for gold
						if(make_discount_bonus($tonick, $_POST['ekr'], 2) == false) {
							\components\Helper\FileHelper::writeArray([
								'message' => 'error with discount ekr',
								'dealer' => $user['login'],
								'to_user' => $tonick['login'],
								'cost' => $_POST['ekr'],
							], 'dealer', 'log');
						}
					}

					$balans['sumekr']=$balans['sumekr']-$_POST['ekr'];

				//	make_ekr_add_bonus($tonick,$bank,$_POST['ekr'],$user);


						if ($XML_OUT)
						{
						echo "<answer code='0' type='1' ekr='{$_POST['ekr']}' bank='{$bank[id]}' login='{$tonick[login]}'>������� ���������!</answer>";
						}
						else
						{
						print "<b><font color=red>������� ��������� {$_POST['ekr']} ���. �� ���� {$bank[id]} ��������� {$tonick[login]}!</font></b>";

							if ($ko_bonus > 0)
							{
							print "<br><b><font color=red>������� ��������� {$ko_bonus} ���. �� ���� {$bank['id']} ��������� {$tonick[login]} �� ������������� ������ !</font></b>";
							}
						}
				}
				else {

				if ($XML_OUT)
					{
					echo "<answer code='9'>��������� ������!</answer>";
					}
					else
					{
					err("��������� ������!");
					}
				}
			}
			else {
					if ($XML_OUT)
					{
					echo "<answer code='8'>���� ����� {$bank[id]} �� ����������� ��������� {$tonick['login']}!</answer>";
					}
					else
					{
					 err("���� ����� {$bank[id]} �� ����������� ��������� {$tonick['login']}!");
					}
			}
		}
		else {
			if ($XML_OUT)
			{
			echo "<answer code='7'>��� ������ ��� ��������!</answer>";
			}
			else
			{
			err("������� �����, ����� ����� � ��� ���������!");
			}
		}
	}
	elseif ($_POST['putekr']) {

			if ($XML_OUT)
			{
				if (round($_POST['ekr'],2)<=0)
				{
				echo "<answer code='6'>������ �����!</answer>";
				}
				else
				{
				echo "<answer code='5'>������������ ������ �� �������!</answer>";
				}
			}
			else
			{
			err("������������ �����. ��������� ���� ������!");
			}
	}
////////////////////////////////////////////////////////////////////////
	else if (($_POST['putrep'] && $balans['sumekr'] >= round($_POST['repsum'],2)) and (round($_POST['repsum'],2)>0))
	{
		if (($_POST['repsum']) && ($_POST['reptonick']))
		{
		$bankid=(int)($_POST['repbankid']);

			$tonick = check_users_city_datal($_POST['reptonick']);

			if ($tonick['id'])
			{

			if ($bankid>0)
					{
					$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' and id='{$bankid}' "));
					}
				else
					{
					$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' order by def desc,id limit 1 "));
					}

			if  ($get_bankid['id']>0)
				{
				$_POST['repsum'] = round($_POST['repsum'],2);
				$add_rep=$_POST['repsum'] * 600;
				$cit[0]='oldbk.';
				$cit[1]='avalon.';
				$cit[2]='angels.';

				if ((time()>$KO_start_time7) and (time()<$KO_fin_time7))
				{
					$ko_bonus_rep=$add_rep; // ��� ������ � ������
					$add_rep=round(($add_rep*(1+$KO_A_BONUS7)) ,2); //+%
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


				//������ ��� ������� ��� ���� ��� � �� �������� ������� � ������� ����� � �� ���� ����� �� ������

				if ( mysql_query("UPDATE ".$cit[$tonick[id_city]]."`users` SET  `repmoney` = `repmoney` + '$add_rep' WHERE `id`= '".$tonick['id']."' LIMIT 1;")
				&& mysql_query("UPDATE ".$cit[$tonick[id_city]]."`users` SET  `rep`=`rep`+'$add_rep'   WHERE `id`= '".$tonick['id']."' LIMIT 1;" ))
				{

						if ($bot && $botlogin)
						{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,addition,owner,ekr) values ('{$_SESSION['uid']}','{$botfull}','300','{$_POST['reptonick']}','{$_POST['repsum']}');");
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,addition,owner,ekr) values ('{$user['id']}','{$user['login']}','300','{$_POST['reptonick']}','{$_POST['repsum']}');");
						}
						else
						{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,addition,owner,ekr) values ('{$user['id']}','{$user['login']}','300','{$_POST['reptonick']}','{$_POST['repsum']}');");
						}
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$_POST['repsum']}' WHERE `owner` = '{$user['id']}' LIMIT 1;") ;
					      // ���������
					CheckRealPartners($tonick['id'],$_POST['repsum'],$_SESSION['uid']);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$_POST['repsum']}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($_POST['repsum']/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$_POST['repsum']}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }

				      	//new_delo - ���������� � ����� ���
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=2828;//������� �� ������� ����
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$_POST['repsum'];
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
					$rec['bank_id']=$get_bankid['id'];
					$rec['add_info']='������ ��� �� '.$tonick[repmoney]. ' ����� ' .($tonick[repmoney]+$add_rep).$add_bonus_str;
					add_to_new_delo($rec); //�����

					if($dealer['discount']) {
						//discount for gold
						if(make_discount_bonus($tonick, $_POST['repsum'], 3) == false) {
							\components\Helper\FileHelper::writeArray([
								'message' => 'error with discount rep',
								'dealer' => $user['login'],
								'to_user' => $tonick['login'],
								'cost' => $_POST['repsum'],
							], 'dealer', 'log');
						}
					}

					telepost_new($tonick,'<font color=red>��������!</font> ��� ���������� '.$add_rep.' ��������� �� ������ '.$user['login'].'. ������� ����!');

					if ($add_bonus_str_chat!='')
						{
						telepost_new($tonick,$add_bonus_str_chat);
						}

					$balans['sumekr']=$balans['sumekr']-$_POST['repsum'];

						if ($XML_OUT)
						{
						echo "<answer code='0' type='1' ekr='{$_POST['repsum']}' rep='{$add_rep}' login='{$tonick[login]}'>������� ���������!</answer>";
						}
						else
						{
						print "<b><font color=red>������� ��������� {$add_rep} ���������  �� {$_POST['repsum']} ���. ��������� {$tonick[login]}! ".$add_bonus_str."</font></b>";
						}

					//�����
				//make_ekr_add_bonus($tonick,$get_bankid,$_POST['repsum'],$user);


				}
				else {

				if ($XML_OUT)
					{
					echo "<answer code='9'>��������� ������!</answer>";
					}
					else
					{
					err("��������� ������!");
					}
				}

				}
				else
				{
				if ($XML_OUT)
				{
				echo "<answer code='34'>�� ������ ���������� ���� ��� ���� �� ����������� ����� ���������!</answer>";
				}
				else
				{
				err("�� ������ ���������� ���� ��� ���� �� ����������� ����� ���������!");
				}
				}

			}
			else {
					if ($XML_OUT)
					{
					echo "<answer code='98'>�������� �� ������!</answer>";
					}
					else
					{
					 err("�������� �� ������!");
					}
			}
		}
		else {
			if ($XML_OUT)
			{
			echo "<answer code='7'>��� ������ ��� ��������!</answer>";
			}
			else
			{
			err("������� �����,  � ��� ���������!");
			}
		}
	}
	elseif ($_POST['putrep']) {

			if ($XML_OUT)
			{
				if (round($_POST['repsum'],2)<=0)
				{
				echo "<answer code='6'>������ �����!</answer>";
				}
				else
				{
				echo "<answer code='5'>������������ ������ �� �������!</answer>";
				}
			}
			else
			{
			err("������������ �����. ��������� ���� ������!");
			}
	}

	$vkol=$_POST['vkol'];
/////////////////////////////////////////////////////////////////////////////////////////
	if (($_POST['valprod'] && ($balans['sumekr'] >= $valentinka_prise[$_POST['valprice']]*$vkol) && $vkol>0 && $_POST['valprice']>0) AND ($VALENT==1))
		{

		$prise=$valentinka_prise[$_POST['valprice']];
		$_POST['valprice']=(int)($_POST['valprice']);
		if ($_POST['vallog'] && $prise>0)
		{
			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['vallog']}' LIMIT 1;"));
			$tonick = check_users_city_data($tonick[id]);
			if ( $tonick['id']>0)
			{
		for ($kkk=1;$kkk<=$vkol;$kkk++)
		{
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$_POST['valprice']}' ;"));
			if ($dress[id]>0)
			  {

				if(mysql_query("INSERT INTO oldbk.`inventory`
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
					) ;"))
					{
						$good = 1;
						$dress['prototype']=$dress[id];
						$new_vid=mysql_insert_id();
						$dress[id]=$new_vid;
						$dress['idcity']=0;
					}
					else {
						$good = 0;
					}

			    if ($good==1)
			        {
				if ($bot && $botlogin) {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['vallog']}','{$prise}','555');");
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['vallog']}','{$prise}','555');");
				}
				else {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['vallog']}','{$prise}','555');");
				}

				      // ���������
					CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
				     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				     if ($p_user['partner']!='' and $p_user['fraud']!=1)
				      {
				       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','0','".time()."');");
				       $id_ins_part_del=mysql_insert_id();
				       $bonus=round(($prise/100*$partner['percent']),2);
				       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				      }


				//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=54;//�������
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
					$rec['item_proto']=$dress['prototype'];
					$rec['item_sowner']=($dress['sowner']>0?1:0);
					$rec['item_incmagic_id']=$dress['includemagic'];
					add_to_new_delo($rec); //�����


				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
				$balans['sumekr']=$balans['sumekr']-$prise;

				if ($XML_OUT)
				{
				echo "<answer code='0' type='2' ekr='{$prise}'  login='{$tonick[login]}' nom='{$kkk}'>������� ������� �����-����������!</answer>";
				}
				else
				{
				err("������� �����-���������� ��� ��������� {$_POST['vallog']}! ");
				}

					if ( $tonick['odate'] > (time()-60)  )
					{
						addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress['name'].'</b>  �� ������ '.$user['login'].'  ','{[]}'.$_POST['vallog'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress['name'].'</b>  �� ������ '.$user['login'].'  '."');");
					}
				}
			  }

			 }

			}
			else {
				if ($XML_OUT)
				{
				echo "<answer code='21'>����� �������� �� ���������� !</answer>";
				}
				else
				{
				err("����� �������� �� ����������!");
				}
			}
		}

	}
	elseif (($_POST['valprod']) and ($VALENT==1))
	{
		if ($XML_OUT)
		{
		echo "<answer code='5'>������������ ������ �� �������!</answer>";
		}
		else
		{
		err("������������ �����. ��������� ���� ������!");
		}
	}
	elseif (($_POST['valprod']) and ($VALENT==0))
	{
		if ($XML_OUT)
		{
		echo "<answer code='22'>������ ��������!</answer>";
		}
		else
		{
		err("������ ��������!");
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////
	$vkol=$_POST['vkol'];
	$Vprise=1;
	if (($_POST['valprod2015'] && ($balans['sumekr'] >= $Vprise*$vkol) && $vkol>0) AND ($VALENT_2015==1))
		{
		if ($_POST['vallog'])
		{
			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['vallog']}' LIMIT 1;"));
			$tonick = check_users_city_data($tonick[id]);
			if ( $tonick['id']>0)
			{
		for ($kkk=1;$kkk<=$vkol;$kkk++)
		{
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='910' ;"));
			if ($dress[id]>0)
			  {

				if(mysql_query("INSERT INTO oldbk.`inventory`
					(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
						`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str." , `ab_mf`,`ab_bron`,`ab_uron`,`sowner`,`unik`,`ekr_flag`
					)
					VALUES
					(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
					'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
					,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}' ".$sql." ,'{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','0',2,{$dress['ekr_flag']}
					) ;"))
					{
						$good = 1;
						$dress['prototype']=$dress[id];
						$new_vid=mysql_insert_id();
						$dress[id]=$new_vid;
						$dress['idcity']=0;
					}
					else {
						$good = 0;
					}

			    if ($good==1)
			        {
				if ($bot && $botlogin) {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['vallog']}','{$Vprise}','555');");
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['vallog']}','{$Vprise}','555');");
				}
				else {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['vallog']}','{$Vprise}','555');");
				}

				      // ���������
					CheckRealPartners($tonick['id'],$Vprise,$_SESSION['uid']);
				     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				     if ($p_user['partner']!='' and $p_user['fraud']!=1)
				      {
				       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$Vprise}','0','".time()."');");
				       $id_ins_part_del=mysql_insert_id();
				       $bonus=round(($Vprise/100*$partner['percent']),2);
				       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$Vprise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				      }


				//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=54;//�������
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$Vprise;
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
					$rec['item_proto']=$dress['prototype'];
					$rec['item_sowner']=($dress['sowner']>0?1:0);
					$rec['item_incmagic_id']=$dress['includemagic'];
					add_to_new_delo($rec); //�����


				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$Vprise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
				$balans['sumekr']=$balans['sumekr']-$Vprise;

				if ($XML_OUT)
				{
				echo "<answer code='0' type='2' ekr='{$Vprise}'  login='{$tonick[login]}' nom='{$kkk}'>������� ������� ����-����������!</answer>";
				}
				else
				{
				err("������� ����-���������� ��� ��������� {$_POST['vallog']}! <br> ");
				}

					if ( $tonick['odate'] > (time()-60)  )
					{
						addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress['name'].'</b>  �� ������ '.$user['login'].'. ������� ����!  ','{[]}'.$_POST['vallog'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress['name'].'</b>  �� ������ '.$user['login'].'. ������� ����!'."');");
					}
				}
			  }

			 }

			}
			else {
				if ($XML_OUT)
				{
				echo "<answer code='21'>����� �������� �� ���������� !</answer>";
				}
				else
				{
				err("����� �������� �� ����������!");
				}
			}
		}

	}
	elseif (($_POST['valprod2015']) and ($VALENT_2015==1))
	{
		if ($XML_OUT)
		{
		echo "<answer code='5'>������������ ������ �� �������!</answer>";
		}
		else
		{
		err("������������ �����. ��������� ���� ������!");
		}
	}
	elseif (($_POST['valprod2015']) and ($VALENT_2015==0))
	{
		if ($XML_OUT)
		{
		echo "<answer code='22'>������ ��������!</answer>";
		}
		else
		{
		err("������ ��������!");
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

	$pkol=(int)($_POST['podkol']);
	if (($_POST['podotdel'] && $balans['sumekr'] >= ($podar_prise[$_POST['podprice']]*$pkol) && $pkol>0 && $_POST['podprice']>0)  AND ($POD==1))
		{
		$total_summ=0;
		for ($kkk=1;$kkk<=$pkol;$kkk++)
		{
		$prise=$podar_prise[$_POST['podprice']];
		$bankid=(int)($_POST['podbank']);
		$_POST['podprice']=(int)($_POST['podprice']);
		if ($_POST['podlog'] && $prise>0)
		{

			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['podlog']}' LIMIT 1;"));
			$tonick = check_users_city_data($tonick[id]);

			if ($bankid>0)
					{
					$tobank	=mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' and id='{$bankid}' "));
					}
				else
					{
					$tobank	=mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' order by def desc,id limit 1 "));
					$bankid=$tobank['id'];
					}

			if ( ($tonick['login']) AND ($tobank[owner]==$tonick['id']))
			{

			$ekr_bonus=round(($prise*$podar_ekr[$_POST['podprice']]),2);
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$_POST['podprice']}' ;"));
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


				/*
			        if (time() >= mktime(0,0,0,3,5,$ny_events_cur_y) && time() <= mktime(23,59,59,3,20,$ny_events_cur_y)) {
					$dress['img'] = $podar8_img[$dress['id']];
					reset($podar8);
					while(list($ka,$va) = each($podar8)) {
						if ($dress['id'] == $va) {
							$dress['name'] = $ka;
						}
					}
				}
				*/

				if(mysql_query("INSERT INTO oldbk.`inventory`
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
					) ;"))
					{
						$good = 1;
						$dress['prototype']=$dress[id];
						$new_vid=mysql_insert_id();
						$dress[id]=$new_vid;
						$dress['idcity']=0;
					}
					else {
						$good = 0;
					}

			    if ($good==1)
			        {
				if ($bot && $botlogin) {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['podlog']}','{$prise}','55');");
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['podlog']}','{$prise}','55');");
				}
				else {

					$real_flag=1;
					if (($user['klan']=='radminion') OR ($user['klan']=='Adminion') )
					{
						if ($_POST['real']!='yes')
						{
						$real_flag=0;
						}
					}

					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition,b) values ('{$user['id']}','{$user['login']}','0','{$_POST['podlog']}','{$prise}','55','{$real_flag}');");
				}

								      // ���������
					CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
				     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				     if ($p_user['partner']!='' and $p_user['fraud']!=1)
				      {
				       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
				       $id_ins_part_del=mysql_insert_id();
				       $bonus=round(($prise/100*$partner['percent']),2);
				       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				      }



				//new_delo
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
				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
				$balans['sumekr']=$balans['sumekr']-$prise;
				$total_summ+=$prise;
				if ($XML_OUT)
				{
				echo "<answer code='0' type='2' ekr='{$prise}' bank='{$tobank[id]}' login='{$tonick[login]}' nom='{$kkk}'>������� ������ ���������� ����������!</answer>";
				}
				else
				{
				err("������ ���������� ����������  ��������� {$prise} ���. ��� ��������� {$_POST['podlog']} ���������� ���� �{$bankid} !");
				}

					if ( $tonick['odate'] > (time()-60)  )
					{
						addchp('<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b> � '.$ekr_bonus.'��� �� ���� �'.$bankid.'  �� ������ '.$user['login'].'  ','{[]}'.$_POST['podlog'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b> � '.$ekr_bonus.'��� �� ���� �'.$bankid.'   �� ������ '.$user['login'].'  '."');");
					}

					$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' and id='{$bankid}' "));


				}
			  }
			}
			else {
				if ($XML_OUT)
				{
				echo "<answer code='21'>����� �������� �� ���������� ��� ���� �� ������������ ���������!</answer>";
				}
				else
				{
				err("����� �������� �� ���������� ��� ���� �� ������������ ���������!");
				}
			}
		}

	   }

	   //�����
		if  ($get_bankid['id']>0)
		{
		//make_ekr_add_bonus($tonick,$get_bankid,	$total_summ,$user);
		}

	}
	elseif (($_POST['podotdel']) and ($POD==1))
	{
		if ($XML_OUT)
		{
		echo "<answer code='5'>������������ ������ �� �������!</answer>";
		}
		else
		{
		err("������������ �����. ��������� ���� ������!");
		}
	}
	elseif (($_POST['podotdel']) and ($POD==0))
	{
		if ($XML_OUT)
		{
		echo "<answer code='22'>������ ��������!</answer>";
		}
		else
		{
		err("������ ��������!");
		}
	}
///////////////////////////////////////////////////////////////////////////////////////////////
		$kolv=(int)($_POST['kolv']);
	if (($_POST['komotdel'] && $balans['sumekr'] >= ($vaucher_prise[$_POST['price']]*$kolv)  && $_POST['price']>0) AND ($VAU==1) AND ($kolv>0) )
		{
		$prise=$vaucher_prise[$_POST['price']];
		$_POST['price']=(int)($_POST['price']);
		$bankid=(int)($_POST['kombankid']);

		if (($_POST['komlog'] && $prise) AND ($kolv>0) )
		 {
		 $total_summ=0;

		 	/*
		 	��� ������� �������� 100  - �������� ����� 5+5 ���������
			��� ������� �������� 200  - �������� ����� 20 ���������
			��� ������� �������� 300  - �������� ����� 15+15+5 ���������
		 	*/
			if ((time()>$KO_start_time8-14400) and (time()<$KO_fin_time8-14400))
			{
			$vau_bonus=true;
		 	$AKC[100100]=array(100005,100005);
		 	$AKC[100200]=array(100020);
		 	$AKC[100300]=array(100015,100015,100005);
		 	}
		 	else
		 	{
		 	//echo "no bonus1";
		 	}




			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['komlog']}' LIMIT 1;"));
			$tonick = check_users_city_data($tonick[id]);

			if ($tonick['login']) {

			$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' and id='{$bankid}' "));
			if  ($get_bankid['id']>0)
			{
			for ($kkk=1;$kkk<=$kolv;$kkk++)
			  {
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$_POST['price']}' ;"));
			if ($dress['id']>0)
			  {




				if(mysql_query("INSERT INTO oldbk.`inventory`
					(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
						`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str." , `ab_mf`,`ab_bron`,`ab_uron`
					)
					VALUES
					(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
					'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
					,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}' ".$sql." ,'{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}'
					) ;"))
					{
						$good = 1;
						$new_vid=mysql_insert_id();
						$dress[id]=$new_vid;
					}
					else {
						$good = 0;
						//echo mysql_error();
					}


			    if ($good==1)
			        {
				if ($bot && $botlogin) {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['komlog']}','{$prise}','5');");
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['komlog']}','{$prise}','5');");
				}
				else {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['komlog']}','{$prise}','5');");
				}

				//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=52;//������� ������ �� �������
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
					$rec['bank_id']=$get_bankid['id'];
					$rec['item_proto']=$dress['prototype'];
					$rec['item_sowner']=($dress['sowner']>0?1:0);
					$rec['item_incmagic_id']=$dress['includemagic'];
					add_to_new_delo($rec); //�����

				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
				$balans['sumekr']=$balans['sumekr']-$prise;
				$total_summ+=$prise;
				//������ ����� ���� -�� ��� � ������� ��������
				$bonus_txt='';

					if ( ($AKC[$_POST['price']] >0)  AND ($vau_bonus==true) )
			 		{
			 			$bonus_arra=$AKC[$_POST['price']];

			 			foreach ($bonus_arra as $v)
		 				{
						$bonusdress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$v}' ;"));
						mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`, `gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`, `mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str." , `ab_mf`,`ab_bron`,`ab_uron` ) VALUES
						(30,'{$bonusdress['id']}','{$tonick['id']}','{$bonusdress['name']}','{$bonusdress['type']}',{$bonusdress['massa']},{$bonusdress['cost']},{$bonusdress['ecost']},'{$bonusdress['img']}',{$bonusdress['maxdur']},{$bonusdress['isrep']},'{$bonusdress['gsila']}','{$bonusdress['glovk']}','{$bonusdress['ginta']}','{$bonusdress['gintel']}','{$bonusdress['ghp']}','{$bonusdress['gnoj']}','{$bonusdress['gtopor']}','{$bonusdress['gdubina']}','{$bonusdress['gmech']}','{$bonusdress['gfire']}','{$bonusdress['gwater']}','{$bonusdress['gair']}','{$bonusdress['gearth']}','{$bonusdress['glight']}','{$bonusdress['ggray']}','{$bonusdress['gdark']}','{$bonusdress['needident']}','{$bonusdress['nsila']}','{$bonusdress['nlovk']}','{$bonusdress['ninta']}','{$bonusdress['nintel']}','{$bonusdress['nmudra']}','{$bonusdress['nvinos']}','{$bonusdress['nnoj']}','{$bonusdress['ntopor']}','{$bonusdress['ndubina']}','{$bonusdress['nmech']}','{$bonusdress['nfire']}','{$bonusdress['nwater']}','{$bonusdress['nair']}','{$bonusdress['nearth']}','{$bonusdress['nlight']}','{$bonusdress['ngray']}','{$bonusdress['ndark']}','{$bonusdress['mfkrit']}','{$bonusdress['mfakrit']}','{$bonusdress['mfuvorot']}','{$bonusdress['mfauvorot']}','{$bonusdress['bron1']}','{$bonusdress['bron2']}','{$bonusdress['bron3']}','{$bonusdress['bron4']}','{$bonusdress['maxu']}','{$bonusdress['minu']}','{$bonusdress['magic']}','{$bonusdress['nlevel']}','{$bonusdress['nalign']}','".(($bonusdress['goden'])?($bonusdress['goden']*24*60*60+time()):"")."','{$bonusdress['goden']}','{$bonusdress['razdel']}','{$bonusdress['gmp']}','{$bonusdress['gmeshok']}','{$bonusdress['group']}','{$bonusdress['letter']}' ".$sql." ,'{$bonusdress['ab_mf']}','{$bonusdress['ab_bron']}','{$bonusdress['ab_uron']}') ;");


						$bonus_vid='cap'.mysql_insert_id();
						$bonus_txt.=$bonusdress['name'].", ";

						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values (450,'KO','0','{$_POST['komlog']}','{$bonusdress['ecost']}','5');");

	  		    			$rec['owner']=$tonick['id'];
						$rec['owner_login']=$tonick['login'];
						$rec['owner_balans_do']=$tonick['money'];
						$rec['owner_balans_posle']=$tonick['money'];
						$rec['target']=450;
						$rec['target_login']='KO';
						$rec['type']=52;//������� ������ �� �������
						$rec['sum_kr']=0;
						$rec['sum_ekr']=$bonusdress['ecost'];
						$rec['sum_kom']=0;
						$rec['item_id']=$bonus_vid;
						$rec['item_name']=$bonusdress['name'];
						$rec['item_count']=1;
						$rec['item_type']=$bonusdress['type'];
						$rec['item_cost']=$bonusdress['cost'];
						$rec['item_dur']=$bonusdress['duration'];
						$rec['item_maxdur']=$bonusdress['maxdur'];
						$rec['item_ups']=$bonusdress['ups'];
						$rec['item_unic']=$bonusdress['unic'];
						$rec['item_incmagic']=$bonusdress['includemagicname'];
						$rec['item_incmagic_count']=$bonusdress['includemagicuses'];
						$rec['item_arsenal']='';
						$rec['bank_id']='';
						$rec['item_proto']=$bonusdress['prototype'];
						$rec['item_sowner']=($bonusdress['sowner']>0?1:0);
						$rec['item_incmagic_id']=$bonusdress['includemagic'];
						$rec['add_info']='�����';
						add_to_new_delo($rec); //�����
	 					}
			 		}
			 		else
			 		{
 				 	//echo "no bonus2";
			 		}



				if ($XML_OUT)
				{
				echo "<answer code='0' type='3' ekr='{$prise}' login='{$tonick[login]}' >������� ������ ������ ���������!</answer>";
				}
				else
				{
				err("������ ������ ��������� {$prise} ���. ��� ��������� {$_POST['komlog']}!<br>");
				}

				      // ���������
					CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
				     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				     if ($p_user['partner']!='' and $p_user['fraud']!=1)
				      {
				       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
				       $id_ins_part_del=mysql_insert_id();
				       $bonus=round(($prise/100*$partner['percent']),2);
				       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				      }


				//������ �� �������  ��������

					if (  ((time()>1336003201-14400) and (time()<1336089599-14400))   )
						{
						// �����
						$add_bonuss_art=round(($prise*0.1),2);
						$tobank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = '{$tonick[id]}' LIMIT 1;"));
							if ($tobank[id]>0)
								{
								mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$add_bonuss_art}' WHERE `id` = '{$tobank[id]}' LIMIT 1;");
								mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr) values (450,'KO','{$tobank[id]}','{$tonick[login]}','{$add_bonuss_art}');");

								//new_delo
			  		    			$rec['owner']=$tonick[id];
								$rec['owner_login']=$tonick[login];
								$rec['owner_balans_do']=$tonick['money'];
								$rec['owner_balans_posle']=$tonick['money'];
								$rec['target']=$user[id];
								$rec['target_login']=$user[login];
								$rec['type']=355;//�����
								$rec['sum_kr']=0;
								$rec['sum_ekr']=$add_bonuss_art;
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
								$rec['bank_id']=$tobank[id];

								add_to_new_delo($rec); //�����
								$bon_ok=1;
								}
								else
								{
									if ($XML_OUT)
									{
									echo "<answer code='32'>����� �� ������� �� �������� �� ������� �� ������ ����������� �����!</answer>";
									}
									else
									{
									err("����� �� ������� �� �������� �� ������� �� ������ ����������� �����!");
									}
								}
						}
					/////////////////////////////






					if ( $tonick['odate'] > (time()-60)  )
					{
						addchp('<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b> �� ������ '.$user['login'].'  ','{[]}'.$_POST['komlog'].'{[]}',$tonick['room'],$tonick['id_city']);

						if ($bon_ok==1)
							{
						addchp('<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_bonuss_art.' ���. ����� �� ���.������ ','{[]}'.$_POST['komlog'].'{[]}',$tonick['room'],$tonick['id_city']);
							}

						if ($bonus_txt!='')
							{
						$bonus_txt=substr($bonus_txt,0,-2);
						addchp('<font color=red>��������!</font> ��� ������� ����� �� ���.������ <b>'.$bonus_txt.'</b> ','{[]}'.$_POST['komlog'].'{[]}',$tonick['room'],$tonick['id_city']);
							}


					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b> �� ������ '.$user['login'].'  '."');");

						if ($bon_ok==1)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_bonuss_art.' ���. ����� �� ���.������  '."');");
						}

						if ($bonus_txt!='')
						{
						$bonus_txt=substr($bonus_txt,0,-2);
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ����� �� ���.������ <b>'.$bonus_txt.'</b>'."');");
						}

					}




				}


			  	}
			  	}//for
				//	make_ekr_add_bonus($tonick,$get_bankid,$total_summ,$user);
				}
				else
				{
				if ($XML_OUT)
				{
				echo "<answer code='34'>�� ������ ���������� ���� ��� ���� �� ����������� ����� ���������!</answer>";
				}
				else
				{
				err("�� ������ ���������� ���� ��� ���� �� ����������� ����� ���������!");
				}
				}
			}
			else {
				if ($XML_OUT)
				{
				echo "<answer code='31'>����� �������� �� ����������!</answer>";
				}
				else
				{
				err("����� �������� �� ����������!");
				}
			}

		}
	}
	elseif (($_POST['komotdel']) and ($VAU==1))
	{
		if ($XML_OUT)
		{
		echo "<answer code='5'>������������ ������ �� �������!</answer>";
		}
		else
		{
		err("������������ �����. ��������� ���� ������!");
		}
	}
	elseif (($_POST['komotdel']) and ($VAU==0))
	{
		if ($XML_OUT)
		{
		echo "<answer code='33'>������ ��������!</answer>";
		}
		else
		{
		err("������ ��������!");
		}
	}
	/*
	if ($_POST['obraz'] && $balans['sumekr'] >= 100) {
		if ($_POST['obrazlog']) {
			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['obrazlog']}' LIMIT 1;"));

			if ($tonick['login']) {
				if ($bot && $botlogin) {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['obrazlog']}','100','66');");
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['obrazlog']}','100','66');");
				}
				else {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['obrazlog']}','100','66');");
				}
				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'100' WHERE `owner` = '{$user['id']}' LIMIT 1;");

				//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=53;//����� �� �������
					$rec['sum_kr']=0;
					$rec['sum_ekr']=100;
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

					add_to_new_delo($rec); //�����
				if (olddelo==1)
				{
				mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['obrazlog']."&quot; ������� ������ ����� ����� ������ ".$user['login']."',9,'".time()."');");
				}

				mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','&quot;".$_POST['obrazlog']."&quot; ������� ������ ����� ����� ������ &quot;".$user['login']."&quot;  ','".time()."');");
				$balans['sumekr']=$balans['sumekr']-100;
				print "<b><font color=red>������ ������� ������ ��� ��������� {$_POST['obrazlog']} ����������� �������!</font></b>";
			}
			else {
				print "<b><font color=red>����� �������� �� ����������!</font></b>";
			}
		}
	}
	elseif ($_POST['obraz']) {
		print "<b><font color=red>������������ �����. ��������� ���� ������!</font></b>";
	}
	*/
//	========

//������� ����
if ($user['id'] == 326 || $user['id'] == 8540 || $user['id'] == 28453 || $user['id'] == 14897 || $user['id'] == 102904 )
	 {$OK=1; } else { $OK=0; }

//������ ������
 $BUKET_start=$KO_start_time22;
 $BUKET_end=$KO_fin_time22;

if( ((time() > $BUKET_start && time() < $BUKET_end))   )
	{
	$BUKET=1;
	}


if ($user['id']==14897)
	{
	$BUKET=1;
	}

$BUKET=0;

//��������� - ����� / ���� ��� �������
if (((time()>$ny_events['larcistart']) and (time()<$ny_events['larciend'])))
{
$NY_BOXS=1;
}
else
{
$NY_BOXS=0;
}

//��������� - ���������� ����
if ((time()>mktime(0,0,0,6,16,2014)) and (time()<mktime(23,59,59,7,14,2014)))
{
$F_BOXS=1;
}
else
{
$F_BOXS=0;
}


	$tboxstart = mktime(0,0,0,10,9,2015);

	if (time() > $tboxstart && time() < mktime(23,59,59,11,6,2015) ) {
		$T_BOXS=1;
	} else {
		$T_BOXS=0;
	}

//	if ((time() >= $KO_start_time30) && (time() < $KO_fin_time30 ))
	{
	$LORD_BOX=0;
	}

	if ((time() >= $KO_start_time25) && (time() < $KO_fin_time25 ))
	{
	$SMAGIC=1;
	}

	if ((time() >= $KO_start_time27) && (time() < $KO_fin_time27 ))
	{
	$CAT=1;
	}


	if (time() > $KO_start_time31  && time() < $KO_fin_time31 )
	{
	$EURO2016=1;
	}

	if (time() > $KO_start_time33  && time() < $KO_fin_time33 )
	{
	$EXPRUNS=1;
	}

	if (time() > $KO_start_time34  && time() < $KO_fin_time34 )
	{
	$GVICT=1;
	}

// ��������� ������
if ((time() >= mktime(0,0,0,12,1,2015) && time() < mktime(23,59,59,2,29,2016))) {
	$SV_BOXS = 1;
} else {
	$SV_BOXS = 0;
}

$LORD=0;


if ((time()>$KO_start_time36) and (time()<$KO_fin_time36))
	{
	$FALIGN=1;
	}
	else
	{
	$FALIGN=0;
	}

if ((time()>$KO_start_time37) and (time()<$KO_fin_time37))
	{
	$IMPR=1;
	}
	else
	{
	$IMPR=0;
	}

if ($user['id'] == 14897) {
	$SV_BOXS = 1;
	$LORD=1;
	$CAT=1;
	$APRIL_BOXS=1;
	$LORD_BOX=1;
	$BUKET=1;
	$EURO2016=1;
	$EXPRUNS=1;
	$GVICT=1;
	$FALIGN=1;
	$IMPR=1;
	$POD=1;
}

if ($user['id'] == 8540) {
	$LORD=1;
}

$YARM=1;	// ������� �����


$EGG_start=mktime(0,0,0,4,25,2016);
$EGG_end=mktime(23,59,0,5,2,2016);
//��������� - ����� / ���� ��� �������
if (((time()>$EGG_start) and (time()<$EGG_end)))
{
$APRIL_BOXS=1;
}



 $ART_BILL=1;
 //if ($user[id]==326) {  $ART_BILL=0;  }

$ARTOK=0; // CLOSE  FOR ALL
//if ($user['deal'] == 1 || $user['id'] == 326 || $user['id'] == 8540 || $user['id'] == 28453 || $user['id'] == 14897 || $user['id'] == 102904)
//	 {$ARTOK=1; } else { $ARTOK=0; }


//if (($_POST['giveelka']) AND ((int)$_POST['buketid']>0) && ((time() >= $ny_events['elkadropstart'] && time() <= $ny_events['elkadropend'])))
if (false)
{
	$elkaid=(int)$_POST['buketid'];
	$prise=$bukets_prise[$elkaid];

	$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$elkaid}' ;"));

	if (($dress[id]>0) and ($prise>0) and ( $balans['sumekr'] >= $prise )) {
		$bukname=$dress[name];
		$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['elkalog']}' LIMIT 1;"));

		if ($tonick['login']) {
			$bankid = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' order by def desc,id limit 1"));
			if ($bankid['id'] > 0) {
				$city_dbase[0]='oldbk.';
				$city_dbase[1]='avalon.';
				$prefix=$city_dbase[$tonick['id_city']];

				$elkagoden = $ny_events_cur_m == 12 ? mktime(23,59,59,2,29,$ny_events_cur_y+1) : mktime(23,59,59,2,29,$ny_events_cur_y);
				$elkatime = time()+($dress['goden']*3600*24);
				if ($elkatime > $elkagoden) {
					$elkatime = $elkagoden;
				}

				$dress['gold']=$elka_gold[$dress['id']];
				$dress['present']='������������� �����';
				$dress['notsell']=1;
				$dress['sowner']=$tonick['id'];
				$dress['unik'] = 2;


				if(mysql_query("INSERT INTO oldbk.`inventory`
					(`getfrom`,`prototype`,`owner`,`sowner`,`notsell`,`present`,`gold`,`unik`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
							`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
						`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`,`ekr_flag`,`stbonus`
					)
					VALUES
					(30,'{$dress['id']}','{$tonick['id']}','{$tonick['id']}','{$dress['notsell']}', '{$dress['present']}', '{$dress['gold']}' , '{$dress['unik']}',  '{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
					'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$elkatime."',
					'{$dress['goden']}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}','{$dress['ekr_flag']}','{$dress['stbonus']}'
					) ;"))
				{
					$buket_id=mysql_insert_id();
					$good = 1;
					$dress[id]=$buket_id;
				} else {
					$good = 0;
					echo mysql_error();
				}

				if ($good) {
					if ($bot && $botlogin) {
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['elkalog']}','{$prise}','2011');");
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['elkalog']}','{$prise}','2011');");
					} else {
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['elkalog']}','{$prise}','2011');");
					}
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");



					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
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

					if($tonick['odate'] > (time()-60)) {
						addchp('<font color=red>��������!</font> ��� �������� <b>'.$bukname.'</b> �� ������ '.$user['login'].'. ������� ����!.','{[]}'.$_POST['elkalog'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� �������� <b>'.$bukname.'</b> �� ������ '.$user['login'].'. ������� ����!'."');");
					}


					//make_ekr_add_bonus($tonick,$bankid,$prise,$user);


					//������ �� �����
				/*
					$dr=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id=55555"));
					$dr['ecost'] = 1;
					$dr['prototype'] = 55555;
					$dr['sowner']=$tonick['id'];
					$dr['present'] ='�����';
					by_item_bank_dil($tonick,$dr,null);
				*/

					$balans['sumekr']=$balans['sumekr']-$prise;
					print "<b><font color=red>������� {$bukname} ��� ��������� {$_POST['elkalog']} ����������� �������!</font></b>";
											  // ���������
					CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
				    	$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     	$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	if ($p_user['partner']!='' and $p_user['fraud']!=1) {
				       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
				      	 	$bonus=round(($prise/100*$partner['percent']),2);
				      	 	mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					}

				}
			} else {
				print "<b><font color=red>���������� ���� �� ������ ��� �� ����������� ����� ���������!</font></b><br>";
			}
		} else {
			print "<b><font color=red>����� �������� �� ����������!</font></b>";
		}
	} elseif ($_POST['giveelka']) {
		print "<b><font color=red>������������ �����. ��������� ���� ������!</font></b>";
	}
} elseif ($_POST['giveelka']) {
	print "<b><font color=red>����� ������� ���� ��������!</font></b>";
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (($_POST['givelar'])AND($NY_BOXS==1)AND ((int)$_POST['lartid']>0)) {

	$lartid=(int)$_POST['lartid'];
	$larkol=(int)$_POST['larkol'];
	if ($larkol<=0) { $larkol=1; }

	$boxs_type[2014001]=1;
	//$boxs_type[2014002]=2;
	//$boxs_type[2014003]=3;
	$boxs_type[2014004]=4;

	$prise=$lar_box_prise[$lartid];
	$goden_do = mktime(23,59,59,1,31,date("Y")+1);
	$goden = round(($goden_do-time())/60/60/24); if ($goden<1) {$goden=1;}

	$tonick = check_users_city_datal($_POST['larlog']);
	if ($tonick['login']) {
		$q = mysql_query('SELECT * FROM oldbk.boxs_history WHERE owner = '.$tonick['id'].' and selldate = "'.date("d/m/Y").'" and box_type = '.$boxs_type[$lartid]);

		if (mysql_num_rows($q) + $larkol <= 50) {

			for ($k=1;$k<=$larkol;$k++) {
				//���� �� ������� � ������� �������+����������
				$get_my_box=mysql_fetch_array(mysql_query("select * from oldbk.boxs where box_type='{$boxs_type[$lartid]}' and item_id=0 ORDER BY id  LIMIT 1"));
				if ($get_my_box[id] > 0) {
					$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$lartid}' ;"));
					if (($dress[id]>0) and ($prise>0) and ($balans['sumekr'] >= $prise )) {
						mysql_query("update oldbk.boxs set item_id=1 where id='{$get_my_box[id]}' ;");
						if (mysql_affected_rows() > 0) {
							$tonick = check_users_city_datal($_POST['larlog']);
							if ($tonick['login'])  {
								$city_dbase[0]='oldbk.';
								$city_dbase[1]='avalon.';
								$city_dbase[2]='angels.';
								$prefix=$city_dbase[$tonick['id_city']];

								$dress['type'] = 50;
								//$dress['sowner'] = $tonick['id'];


								if(mysql_query("INSERT INTO oldbk.`inventory`
									(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
									`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
									`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
									`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`, `sowner`, `ekr_flag`
									)
									VALUES
									(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
									'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
									'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
									'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '', '{$dress['sowner']}', 1
									) ;"))
								{
									$larbox_id=mysql_insert_id();
									mysql_query("update oldbk.boxs set item_id='{$larbox_id}' where id='{$get_my_box[id]}' ;");
									$good = 1;
									$dress[id]=$larbox_id;
								} else {
									$good = 0;
									echo mysql_error();
								}

								if ($good) {
									if ($bot && $botlogin) {
										mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['larlog']}','{$dress['ecost']}','2013');");
										mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['larlog']}','{$dress['ecost']}','2013');");
									} else {
										mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['larlog']}','{$dress['ecost']}','2013');");
									}

									mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

									//new_delo
				  		    			$rec['owner']=$tonick[id];
									$rec['owner_login']=$tonick[login];
									$rec['owner_balans_do']=$tonick['money'];
									$rec['owner_balans_posle']=$tonick['money'];
									$rec['target']=$user[id];
									$rec['target_login']=$user[login];
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

									if($tonick['odate'] > (time()-60)) {
										addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'. ������� ����!','{[]}'.$_POST['larlog'].'{[]}',$tonick['room'],$tonick['id_city']);
									} else {
										mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'. ������� ����!'."');");
									}

									$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
									print "<b>{$k} - <font color=red>������� {$dress[name]} ��� ��������� {$_POST['larlog']} ����������� �������!</font></b><br>";

									mysql_query('INSERT INTO oldbk.boxs_history (`owner`,`box_type`,`selldate`) VALUES("'.$tonick['id'].'","'.$boxs_type[$lartid].'","'.date("d/m/Y").'")');

									 // ���������
									CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
					    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
									$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
									       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
									      	 $bonus=round(($prise/100*$partner['percent']),2);
					      	 				mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					     	 			}
								}
							} else {
								print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
							}
						} else {
							print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
						}
		   			} else {
						print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
		   			}
				}
			} // end for
		} else {
			print "<b>{$k} - <font color=red>���������� ������ �� ����� ��������� 50 � �����!</font></b><br>";
		}
	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
elseif (($_POST['givef'])AND($F_BOXS==1)) {

	$fid = 2014100;

	$tonick = check_users_city_datal($_POST['flog']);
	if ($tonick['login']) {
		$q = mysql_query('SELECT * FROM oldbk.inventory WHERE owner = '.$tonick['id'].' and prototype = '.$fid);

		if (mysql_num_rows($q) == 0) {
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost'])) {
			$k=1;
			$prise=$dress['ecost'];
			$goden_do = 0;
			$goden = 0;

				if(mysql_query("INSERT INTO oldbk.`inventory`
						(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
						`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`, `add_time`
						)
						VALUES
						(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
						'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
						'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '�����',".time()."
						) ;"))
					{
						$good = 1;
						$dress[id]=mysql_insert_id();
					} else {
						$good = 0;
						echo mysql_error();
					}

					if ($good) {
						if ($bot && $botlogin) {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['flog']}','{$dress['ecost']}','2014100');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['flog']}','{$dress['ecost']}','2014100');");
						} else {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['flog']}','{$dress['ecost']}','2014100');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

						//new_delo
	  		    			$rec['owner']=$tonick[id];
						$rec['owner_login']=$tonick[login];
						$rec['owner_balans_do']=$tonick['money'];
						$rec['owner_balans_posle']=$tonick['money'];
						$rec['target']=$user[id];
						$rec['target_login']=$user[login];
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

						if($tonick['odate'] > (time()-60)) {
							addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  ','{[]}'.$_POST['flog'].'{[]}',$tonick['room'],$tonick['id_city']);
						} else {
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  '."');");
						}

						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						print "<b>{$k} - <font color=red>������� {$dress[name]} ��� ��������� {$_POST['flog']} ����������� �������!</font></b><br>";

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
					}
   			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}
		} else {
			print "<b>{$k} - <font color=red>���������� ��� 2014 ��� ���� � ����� ���������!</font></b><br>";
		}
	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (($_POST['giveflag'])AND($F_BOXS==1)) {

	$kall=count($_POST['flagid']);
	$tonick = check_users_city_datal($_POST['flog']);
	if ($tonick['login'])
{

if ($kall>0)
	{
	 $k=0;
	foreach ($_POST['flagid'] as $n => $id)
	 {
	 $k++;
	$fid=(int)($id);
	if ($fid>0)
	{
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' and (id>=171171 and id<=171202) ;"));
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']))
			{

			$prise=$dress['ecost'];
			$goden_do = mktime(23,59,59,7,14,2014);
			$goden = round(($goden_do-time())/60/60/24); if ($goden<1) {$goden=1;}

				if(mysql_query("INSERT INTO oldbk.`inventory`
						(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
						`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`, `add_time`
						)
						VALUES
						(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
						'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
						'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '�����',".time()."
						) ;"))
					{
						$good = 1;
						$dress[id]=mysql_insert_id();
					} else {
						$good = 0;
						echo mysql_error();
					}

					if ($good) {
						if ($bot && $botlogin) {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['flog']}','{$dress['ecost']}','2014101');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['flog']}','{$dress['ecost']}','2014101');");
						} else {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['flog']}','{$dress['ecost']}','2014101');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

						//new_delo
	  		    			$rec['owner']=$tonick[id];
						$rec['owner_login']=$tonick[login];
						$rec['owner_balans_do']=$tonick['money'];
						$rec['owner_balans_posle']=$tonick['money'];
						$rec['target']=$user[id];
						$rec['target_login']=$user[login];
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

						if($tonick['odate'] > (time()-60)) {
							addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  ','{[]}'.$_POST['flog'].'{[]}',$tonick['room'],$tonick['id_city']);
						} else {
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  '."');");
						}

						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						print "<b>{$k} - <font color=red>������� {$dress[name]} ��� ��������� {$_POST['flog']} ����������� �������!</font></b><br>";

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
					}
   			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

		}
		}
		}
	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
elseif (($_POST['giveday'])AND($T_BOXS==1)) {

	$kall=count($_POST['tdayid']);
	$tonick = check_users_city_datal($_POST['tlog']);
	if ($tonick['login'])
{

if ($kall>0)
	{
	 $k=0;
	foreach ($_POST['tdayid'] as $n => $id)
	 {
	 $k++;
	$fid=(int)($id);
	if ($fid>0)
	{
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' and (id>=180001 and id<=180007) ;"));
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']))
			{

			$prise=$dress['ecost'];
			$goden_do = ($tboxstart+(24*3600*29));
			$goden = round(($goden_do-time())/60/60/24); if ($goden<1) {$goden=1;}

				if(mysql_query("INSERT INTO oldbk.`inventory`
						(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
						`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`, `add_time`
						)
						VALUES
						(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
						'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
						'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '�����',".time()."
						) ;"))
					{
						$good = 1;
						$dress[id]=mysql_insert_id();
					} else {
						$good = 0;
						echo mysql_error();
					}

					if ($good) {
						if ($bot && $botlogin) {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','2014102');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','2014102');");
						} else {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','2014102');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

						//new_delo
	  		    			$rec['owner']=$tonick[id];
						$rec['owner_login']=$tonick[login];
						$rec['owner_balans_do']=$tonick['money'];
						$rec['owner_balans_posle']=$tonick['money'];
						$rec['target']=$user[id];
						$rec['target_login']=$user[login];
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

						if($tonick['odate'] > (time()-60)) {
							addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  ','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
						} else {
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  '."');");
						}

						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						print "<b>{$k} - <font color=red>������� {$dress[name]} ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
					}
   			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

		}
		}
		}
	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
elseif (($_POST['givet'])AND($T_BOXS==1)) {

	$fid = 2014103;

	$tonick = check_users_city_datal($_POST['tlog']);
	if ($tonick['login']) {
//		$q = mysql_query('SELECT * FROM oldbk.inventory WHERE (owner = '.$tonick['id'].' or (owner=488 and arsenal_owner='.$tonick['id'].'))  and prototype = '.$fid);
		//if (mysql_num_rows($q) == 0)
		{

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost'])) {
			$k=1;
			$prise=$dress['ecost'];
			$goden_do = 0;
			$goden = 0;

				if(mysql_query("INSERT INTO oldbk.`inventory`
						(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
						`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`, `add_time`
						)
						VALUES
						(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
						'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
						'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '�����',".time()."
						) ;"))
					{
						$good = 1;
						$dress[id]=mysql_insert_id();
					} else {
						$good = 0;
						echo mysql_error();
					}

					if ($good) {
						if ($bot && $botlogin) {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','2014103');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','2014103');");
						} else {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','2014103');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

						//new_delo
	  		    			$rec['owner']=$tonick[id];
						$rec['owner_login']=$tonick[login];
						$rec['owner_balans_do']=$tonick['money'];
						$rec['owner_balans_posle']=$tonick['money'];
						$rec['target']=$user[id];
						$rec['target_login']=$user[login];
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

						if($tonick['odate'] > (time()-60)) {
							addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  ','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
						} else {
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  '."');");
						}

						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						print "<b>{$k} - <font color=red>������� {$dress[name]} ��� ��������� {$_POST['tlog']} ����������� �������!</font></b><br>";

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
					}
   			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}
		}
		/*
		else {
			print "<b>{$k} - <font color=red>������������ ����� ��� ���� � ����� ���������!</font></b><br>";
		}
		*/
	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}


if (isset($_POST['givect']))
{
print "<b><font color=red>������ ��������!</font></b><br>";
	/*
	$fid = 3001003;
	$_POST['ctcount'] = intval($_POST['ctcount']);
	$tonick = check_users_city_datal($_POST['ctlog']);
	if ($tonick['login'] && $_POST['ctcount'] > 0)
	{
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
			$dress['ecost'] = 1;
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']*$_POST['ctcount']))
			{
				$k=1;
				$prise=$dress['ecost'];
				$goden_do = 0;
				$goden = 0;
				$dress['prototype'] = $fid;
				$dress['sowner']=$tonick['id'];
				for ($i=0;$i<$_POST['ctcount'];$i++)
				{
						if (by_item_bank_dil($tonick,$dress,$user))
						{
							if ($bot && $botlogin)
							{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','3001003');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','3001003');");
							}
							else
							{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','3001003');");
							}
							mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
							$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
							print "<b>{$k} - <font color=red>������� {$dress[name]} ��� ��������� {$_POST['tlog']} ����������� �������!</font></b><br>";
							 // ���������
							CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
			    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
							$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
			   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
						       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
						      	 	$bonus=round(($prise/100*$partner['percent']),2);
		     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
			     	 			}
					   }
				}
   			} else
   			{
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}
	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
	*/
}


if (isset($_POST['givelordbox']) && $LORD_BOX == 1) {
	$fid = 3001005;
	$_POST['lbxcount'] = intval($_POST['lbxcount']);
	$tonick = check_users_city_datal($_POST['lbxlog']);
	if ($tonick['login'] && $_POST['lbxcount'] > 0)
			{

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']*$_POST['lbxcount']))
			{
				$k=0;
				$prise=$dress['ecost'];
				$goden_do = time()+($dress['goden']*24*3600);
				$goden = $dress['goden'];
				$dress['prototype'] = $fid;

				for ($i=0;$i<$_POST['lbxcount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
					if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						}
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$_POST['lbxlog']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['lbxcount'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['giveartup']) && $IMPR == 1 && (in_array($_POST['artupid'],$artup_param) ) ) {

	$fid = $_POST['artupid'];
	$count = intval($_POST['artupkol']);
	$tonick = check_users_city_datal($_POST['artuplog']);


	if ($tonick['login'] && $count > 0)
			{

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
			$dress['ecost']=$artup_prise[$_POST['artupid']];
			$dress['ekr_flag']=1;

			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']*$count))
			{
				$k=0;
				$prise=$dress['ecost'];
				$dress['prototype'] = $fid;

				for ($i=0;$i<$count;$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
					if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						}
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$count.') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['giveruexp']) && $EXPRUNS == 1 && (in_array($_POST['ruexpid'],$exprun_param) ) ) {

	$fid = $_POST['ruexpid'];
	$_POST['ruexpkol'] = intval($_POST['ruexpkol']);
	$tonick = check_users_city_datal($_POST['ruexplog']);

	if ($tonick['login'] && $_POST['ruexpkol'] > 0)
			{

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

			$dress['ecost']=$exprun_prise[$_POST['ruexpid']];
			$dress['ekr_flag']=1;
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']*$_POST['ruexpkol']))
			{
				$k=0;
				$prise=$dress['ecost'];
				$goden_do = time()+($dress['goden']*24*3600);
				$goden = $dress['goden'];
				$dress['prototype'] = $fid;

				for ($i=0;$i<$_POST['ruexpkol'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
					if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						}
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['ruexpkol'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if ( isset($_POST['givebuke']) && $BUKET == 1 && in_array($_POST['bukeid'],$leto_bukets) ) {
	$tonick = check_users_city_datal($_POST['bukelog']);
	if ($tonick['login'] )
			{

			$fid=(int)($_POST['bukeid']);

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']))
			{
				$k=0;
				$prise=$dress['ecost'];
				$goden_do = time()+($dress['goden']*24*3600);
				$goden = $dress['goden'];
				$dress['prototype'] = $fid;
				$dress['unik'] = 2;


					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
					if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','{$fid}');");
						}
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }


				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['givesmagic']) && $SMAGIC == 1) {
	$fid = 100199;

	$_POST['svcount'] = intval($_POST['svcount']);

	$tonick = check_users_city_datal($_POST['svlog']);
	if ($tonick['login'] && $_POST['svcount'] > 0)
			{

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
			$dress['ecost'] = 5;
			//$dress['present'] = '�����';

			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']*$_POST['svcount'])) {
				$k=0;
				$prise=$dress['ecost'];
				$goden_do = time()+($dress['goden']*24*3600);
				$goden = $dress['goden'];
				$dress['prototype'] = $fid;

				for ($i=0;$i<$_POST['svcount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
					if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','100199');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','100199');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','100199');");
						}
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$_POST['svlog']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['svcount'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['giveeuro']) && $EURO2016 == 1) {
	$fid = 2016614;
	$_POST['eurocount'] = intval($_POST['eurocount']);
	$tonick = check_users_city_datal($_POST['eurolog']);

	if ($tonick['login'] && $_POST['eurocount'] > 0) {

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

			$dress['ecost'] = 5;
			$dress['ekr_flag']=1;
			$dress['prototype'] = $fid;
			$prise=5;

			if (($dress[id]>0) and ($balans['sumekr'] >= $prise*$_POST['eurocount']))
			{
				$k=0;

				$dress['dategoden']=mktime(23,59,59,7,11,2016);
				$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}

				for ($i=0;$i<$_POST['eurocount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
						if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$prise;

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
		   	 			{
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['eurocount'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['giveeuroflag']) && $EURO2016 == 1) {
	$fid = 2016615;
	$_POST['eurocount'] = intval($_POST['eurocount']);
	$tonick = check_users_city_datal($_POST['eurolog']);

	if ($tonick['login'] && $_POST['eurocount'] > 0) {

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

			$dress['ecost'] = 2;
			$dress['ekr_flag']=1;
			$dress['prototype'] = $fid;
			$prise=2;

			if (($dress[id]>0) and ($balans['sumekr'] >= $prise*$_POST['eurocount']))
			{
				$k=0;

				$dress['dategoden']=mktime(23,59,59,7,11,2016);
				$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}

				for ($i=0;$i<$_POST['eurocount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
						if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$prise;

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
		   	 			{
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['eurocount'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['givevic']) && $GVICT == 1) {
	$fid = 14200;
	$_POST['viccount'] = intval($_POST['viccount']);
	$tonick = check_users_city_datal($_POST['viclog']);

	if ($tonick['login'] && $_POST['viccount'] > 0) {

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

			$dress['ecost'] = 50;
			$dress['ekr_flag']=1;
			$dress['prototype'] = $fid;
			$prise=50;

			if (($dress[id]>0) and ($balans['sumekr'] >= $prise*$_POST['viccount']))
			{
				$k=0;
				for ($i=0;$i<$_POST['viccount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
						if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$prise;

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
		   	 			{
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['viccount'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['givecat']) && $CAT == 1) {
	$fid = 2016401;

	$_POST['catcount'] = intval($_POST['catcount']);
	$tonick = check_users_city_datal($_POST['catlog']);

	if ($tonick['login'] && $_POST['catcount'] > 0) {

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

			$dress['ecost'] = 5;
			$dress['goden']=3;
			$dress['ekr_flag']=1;
			$prise=5;


			if (($dress[id]>0) and ($balans['sumekr'] >= $prise*$_POST['catcount']))
			{
				$k=0;

				//$goden_do = time()+($dress['goden']*24*3600);
				//$goden = $dress['goden'];

				$dress['dategoden']=$KO_fin_time27;
				$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}


				$dress['prototype'] = $fid;

				for ($i=0;$i<$_POST['catcount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;

						if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$prise;

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
		   	 			{
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";

					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['catcount'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
elseif (isset($_POST['travmlog']) && isset($_POST['travmok']) )
{
		$fid =1001; //  �������
		$tonick = check_users_city_datal($_POST['travmlog']);
		$prise=1;
		if ($tonick['login'])
		{
			if ($balans['sumekr'] >= $prise)
				{
					$owntravma=mysql_fetch_array(mysql_query("select * from effects where type=14 and owner='{$tonick['id']}' LIMIT 1"));
					if ($owntravma['id']>0)
						{
							mysql_query("DELETE FROM `effects` WHERE `id` = '".$owntravma['id']."' LIMIT 1;");
							mysql_query("UPDATE `users` SET `sila`=`sila`+'".$owntravma['sila']."', `lovk`=`lovk`+'".$owntravma['lovk']."', `inta`=`inta`+'".$owntravma['inta']."' WHERE `id` = '".$owntravma['owner']."' LIMIT 1;");
							mysql_query("UPDATE `oldbk`.`plugin_user_warning` SET `count`=0 WHERE `user_id`='{$tonick['id']}' "); // ������ �����

							if ($bot && $botlogin)
								{
									mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
									mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
								} else
								{
									mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
								}

									mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
									$balans['sumekr']=$balans['sumekr']-$prise;

								 // ���������
								CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
				    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
								$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
				   	 			{
							       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
							      	 	$bonus=round(($prise/100*$partner['percent']),2);
			     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				     	 			}

													//������ � ����!
													$rec['owner']=$tonick[id];
													$rec['owner_login']=$tonick[login];
													$rec['owner_balans_do']=$tonick['money'];
													$rec['owner_balans_posle']=$tonick['money'];
													$rec['target']=$user['id'];
													$rec['target_login']=$user['login'];
													$rec['type']=578;
													$rec['sum_kr']=0;
													$rec['sum_ekr']=0;
													$rec['sum_kom']=0;
													$rec['add_info'] = '������ ������� ������ ������� '.$prise;
													add_to_new_delo($rec);


							telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� ������� �� �����. ������� ����!'));
							print "<b>{$k} - <font color=red>������� ��������� {$tonick['login']} �������!</font></b><br>";

						}
						else
						{
						print "<b>{$k} - <font color=red>� ����� ��������� ��� ����������� ������!</font></b><br>";
						}
				}
				else
				{
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
				}

		}
		else
		{
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
		}


}
else
if (isset($_POST['giveyarm']) && $YARM == 1) {

	$fid = 3003060; // �������  ������� ������� ����� �������
	$dis=0; // ��� ������
	$_POST['yarmcount'] = intval($_POST['yarmcount']);

	$kandidat=array();
	
	if (($user['id']==14897) and isset($_POST['yarmlogins']) and ($_POST['yarmlogins']!='') )
		{
		$kandidat=explode(";",$_POST['yarmlogins']);
		}
		else
		{
		$kandidat[]=$_POST['yarmlog'];
		}

	foreach($kandidat  as $n => $yarmlog)
	{
	$tonick = check_users_city_datal($yarmlog);
	$ycheck=false;
					if ((time()>$KO_start_time28) and (time()<$KO_fin_time28))
						{
						/* �� ������� */
							if ($tonick['login'] && ($_POST['yarmcount']==100||$_POST['yarmcount']==500||$_POST['yarmcount']==1000) )
							{
							$ycheck=true;
							}
						if ($_POST['actionon']!='true')
							{
								$ycheck=false;
							}

						}
						else
						{
							if ($tonick['login'] && ($_POST['yarmcount']>=20) )
							{
							$ycheck=true;
							}

							if ($tonick['login'] && ($user['klan']=='radminion') )
							{
							$ycheck=true;
							}

							if ($_POST['actionon']!='false')
							{
								$ycheck=false;
							}

						}

	if ($ycheck==true)
			{

					if ((time()>$KO_start_time28) and (time()<$KO_fin_time28))
						{
							if ($_POST['yarmcount'] >=1000) { $dis=0.3; } //1000 ����� (-30% ������) = 35$
							elseif ($_POST['yarmcount'] >=500) { $dis=0.1; } //   500 ����� (-10% ������) = 22,5$
							$prise=($_POST['yarmcount']*$gcost);
							$prise-=$prise*$dis; // ����� ������
						}
						else
						{
							$prise=($_POST['yarmcount']*$gcost);
						}

			if ($balans['sumekr'] >= $prise)
			{
			$k=$_POST['yarmcount'];

				if ((time()>$KO_start_time38) and (time()<$KO_fin_time38))
				{
					$kb=act_x2bonus_limit($tonick,3,$k);
					if ($kb>0)
						{
						$ko_bonus_gold=$kb;
						$k+=$ko_bonus_gold;
						$ko_bonus_gold_str='. ��������� '.$ko_bonus_gold.' ����� �� ����� �������� ������.';
						$ko_bonus_gold_chat='<font color=red>��������!</font> ��� ��������� '.$ko_bonus_gold.' ����� �� ����� <a href="http://oldbk.com/encicl/?/act_x2bonus.html" target="_blank">�������� ������</a>. ����� �������� �������� � �� ���������������� �� ����������� ������� ���� ������.';
						}
				}

					mysql_query("UPDATE oldbk.`users` set `gold` = `gold`+'{$k}' WHERE `id` = '{$tonick['id']}' LIMIT 1;");
					 if (mysql_affected_rows()>0)
							{
								if ($bot && $botlogin)
								{
									mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
									mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
								} else
								{
									mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
								}

								mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
								$balans['sumekr']=$balans['sumekr']-$prise;

								 // ���������
								CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
				    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
								$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
				   	 			{
							       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
							      	 	$bonus=round(($prise/100*$partner['percent']),2);
			     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				     	 			}


											//������ � ����!
											$rec=array();
											$rec['owner']=$tonick[id];
											$rec['owner_login']=$tonick[login];
											$rec['owner_balans_do']=$tonick['money'];
											$rec['owner_balans_posle']=$tonick['money'];
											$rec['target']=$user['id'];
											$rec['target_login']=$user['login'];
											$rec['type']=3001;
											$rec['sum_kr']=0;
											$rec['sum_ekr']=$prise;
											$rec['sum_kom']=0;
											$rec['item_id']='';
											$rec['item_name']='������';
											$rec['item_count']=$k;
											$rec['item_type']=50;
											$rec['add_info'] = $k."/".($tonick['gold']+$k).$ko_bonus_gold_str;
											add_to_new_delo($rec);

								    if($dealer['discount']) {
								        //discount for gold
								        if(make_discount_bonus($tonick, $prise, 1) == false) {
								            \components\Helper\FileHelper::writeArray([
                                                'message' => 'error with discount gold',
                                                'dealer' => $user['login'],
                                                'to_user' => $tonick['login'],
                                                'cost' => $prise,
                                            ], 'dealer', 'log');
                                        }
                                    }

									print "<b>{$k} - <font color=red>������� ����� (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b>".$ko_bonus_gold_str."<br>";
									telepost_new($tonick,'<font color=red>��������!</font> ��� ��������  <b>'.$k.'</b> �����, �� ������ '.$user['login'].'. ������� ����!');
									if ($ko_bonus_gold_chat!='')
									{
									telepost_new($tonick,$ko_bonus_gold_chat);
									}
						}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}
		} else {
			print "<b>{$k} - <font color=red>����� �������� �� ���������� ��� ������ ����������!</font></b><br>";
		}
	}
}
else
if (isset($_POST['givebigch']) && $IMPR == 1) {

	$fid = 56664;
	$count=intval($_POST['bigchcount']);
	$tonick = check_users_city_datal($_POST['bigchlog']);

	if ($tonick['login'] && $count > 0)
	{

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

			$dress['ecost'] = 15;
			$dress['ekr_flag']=1;
			$prise=15;

			if (($dress[id]>0) and ($balans['sumekr'] >= $prise*$count))
			{
				$k=0;
				$dress['prototype'] = $fid;

				for ($i=0;$i<$count;$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;

						if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$prise;

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
		   	 			{
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";

					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$count.') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['givelord']) && $LORD == 1) {
	$fid = 4016;

	$_POST['lordcount'] = intval($_POST['lordcount']);
	$tonick = check_users_city_datal($_POST['lordlog']);

	if ($tonick['login'] && $_POST['lordcount'] > 0) {

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

			$dress['ecost'] = 3;
			$dress['goden']=90;
			$dress['ekr_flag']=1;
			$prise=3;

			if ($_POST['lordcount'] >=25) { $prise=2; }

			if (($dress[id]>0) and ($balans['sumekr'] >= $prise*$_POST['lordcount']))
			{
				$k=0;

				$goden_do = time()+($dress['goden']*24*3600);
				$goden = $dress['goden'];
				$dress['prototype'] = $fid;

				for ($i=0;$i<$_POST['lordcount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;

						if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$prise}','{$fid}');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$prise}','{$fid}');");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						$balans['sumekr']=$balans['sumekr']-$prise;

						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1)
		   	 			{
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$tonick['login']} ����������� �������!</font></b><br>";

					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['lordcount'].') �� ������ '.$user['login'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}
else
if (isset($_POST['givesv']) && $SV_BOXS == 1) {
	$fid = 3006000;

	$_POST['svcount'] = intval($_POST['svcount']);

	$tonick = check_users_city_datal($_POST['svlog']);
	if ($tonick['login'] && $_POST['svcount'] > 0) {
		$bankid = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' order by def desc,id limit 1"));

		if ($bankid['id'] > 0) {
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
			$dress['ecost'] = 1;

			if (($dress[id]>0) and ($balans['sumekr'] >= $dress['ecost']*$_POST['svcount'])) {
				$k=0;
				$prise=$dress['ecost'];
				$goden_do = time()+($dress['goden']*24*3600);
				$goden = $dress['goden'];
				$dress['prototype'] = $fid;

				for ($i=0;$i<$_POST['svcount'];$i++)
				{

					if (by_item_bank_dil($tonick,$dress,$user,1))
					{
					$k++;
					if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$tonick['login']}','{$dress['ecost']}','3006000');");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','3006000');");
						} else
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$tonick['login']}','{$dress['ecost']}','3006000');");
						}
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");
						//mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+1 WHERE `id` = '{$bankid['id']}' LIMIT 1;");
						make_ekr_add_bonus($tonick,$bankid,$user,1,1);
						$bankid['ekr']+=1;
						$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
						 // ���������
						CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
		    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
						$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
		   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
					       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
					      	 	$bonus=round(($prise/100*$partner['percent']),2);
	     	 					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
		     	 			}
				      }
				}

				if ($k>0)
				{
					print "<b>{$k} - <font color=red>������� {$dress[name]} (x".$k.") ��� ��������� {$_POST['svlog']} ����������� �������!</font></b><br>";
					mysql_query('UPDATE oldbk.variables_int SET value = value + '.$k.' WHERE var = "snowsell"');
					telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> (x'.$_POST['svcount'].') �� ������ '.$user['login'].' � ��������� '.($_POST['svcount']*1).' ��� �� ���������� ���� �'.$bankid['id'].'. ������� ����!');
				}

			} else {
				print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
			}
		} else {
			print "<b>{$k} - <font color=red>���������� ���� �� ������ ��� �� ����������� ����� ���������!</font></b><br>";
		}
	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}



if (($_POST['giveegg'])AND($APRIL_BOXS==1)AND ((int)$_POST['eggid']>0)) {

	$eggid=(int)$_POST['eggid'];
	$eggkol=(int)$_POST['eggkol'];
	if ($eggkol<=0) { $leggkol=1; }

	$prise = $egg_box_prise[$eggid];

	$goden_do = mktime(23,59,59,5,2); //���� �������� ��� �� 23:59 2 ���.
	$goden = round(($goden_do-time())/60/60/24); if ($goden<1) {$goden=1;}

	$tonick = check_users_city_datal($_POST['egglog']);
	if ($tonick['login']) {

			for ($k=1;$k<=$eggkol;$k++)
			{

				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$eggid}' ;"));

					if (($dress[id]>0) and ($prise>0) and ($balans['sumekr'] >= $prise ))
					{


								if(mysql_query("INSERT INTO oldbk.`inventory`
									(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
									`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
									`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
									`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`, `sowner`,`ekr_flag`
									)
									VALUES
									(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
									'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
									'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
									'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['gmp']}','{$user[id_city]}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '', '{$dress['sowner']}',{$dress['ekr_flag']}
									) ;"))
								{

									$good = 1;
									$dress[id]=mysql_insert_id();
								} else {
									$good = 0;
									echo mysql_error();
								}

								if ($good) {
									if ($bot && $botlogin) {
										mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['egglog']}','{$dress['ecost']}','2016001');");
										mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['egglog']}','{$dress['ecost']}','2016001');");
									} else {
										mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['egglog']}','{$dress['ecost']}','2016001');");
									}

									mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

									//new_delo
				  		    			$rec['owner']=$tonick[id];
									$rec['owner_login']=$tonick[login];
									$rec['owner_balans_do']=$tonick['money'];
									$rec['owner_balans_posle']=$tonick['money'];
									$rec['target']=$user[id];
									$rec['target_login']=$user[login];
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

									if($tonick['odate'] > (time()-60)) {
										addchp('<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  ','{[]}'.$_POST['egglog'].'{[]}',$tonick['room'],$tonick['id_city']);
									} else {
										mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> �� ������ '.$user['login'].'  '."');");
									}

									$balans['sumekr']=$balans['sumekr']-$dress['ecost'];
									print "<b>{$k} - <font color=red>������� {$dress[name]} ��� ��������� {$_POST['egglog']} ����������� �������!</font></b><br>";

									 // ���������
									CheckRealPartners($tonick['id'],$prise,$_SESSION['uid']);
					    	 			$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
									$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					   	 			if ($p_user['partner']!='' and $p_user['fraud'] != 1) {
									       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$prise}','{$bank['id']}','".time()."');");
									      	 $bonus=round(($prise/100*$partner['percent']),2);
					      	 				mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$prise}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					     	 			}
								}


		   			} else {
						print "<b>{$k} - <font color=red>������������ �����. ��������� ���� ������!</font></b><br>";
		   			}

			} // end for

	} else {
		print "<b>{$k} - <font color=red>����� �������� �� ����������!</font></b><br>";
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (($_POST['givearts'])AND($ARTOK==1)) {

		$artid=(int)$_POST[artid];
		$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$artid}' ;"));
		if ( ( ($artid==2000) OR ($artid==2001) OR ($artid==2002)  or ($artid==260) or ($artid==262) or ($artid==283) or ($artid==284) or ($artid==18210) or ($artid==18229) or ($artid==100029) or ($artid==7002)  or ($artid==18247) or ($artid==18527)   ) AND ($dress[id]==$artid))
		 {

			if ( ( $balans['sumekr'] >= $artifakts_prise[$artid] ) )
			{

			$tonick = check_users_city_datal($_POST['artlog']);
			if ($tonick['login']) {

				$city_dbase[0]='oldbk.';
				$city_dbase[1]='avalon.';
				$city_dbase[2]='angels.';
				$prefix=$city_dbase[$tonick['id_city']];

					$str=''; $sql='';
					if($dress[nlevel]>6)  { $str=",`up_level` "; 	$sql=",'".$dress[nlevel]."' "; 	}
					if($dress[id]==2003)  { $dress['razdel']=42; }

					if ($ART_ACTION=='true')
						{
						$dress['sowner']=$tonick['id'];
						}
						else
						{
						$dress['sowner']=0;
						}

			if (($dress['id']==7002) or ($dress['id']==100029))
				{
				$dress['sowner']=0;
				$dress['ekr_flag'] = 2;

				// ���� ��
				$mfinfo = array();
				if ($dress['gsila'] > 0 || $dress['glovk'] || $dress['ginta'] || $dress['gintel'] || $dress['gmudra']) {
					$dress['stbonus'] += 3;
					$mfinfo['stats'] = 3;
				} else {
					$mfinfo['stats'] = 0;
				}
				if ($dress['ghp'] > 0) {
					$dress['ghp'] += 20;
					$mfinfo['hp'] = 20;
				} else {
					$mfinfo['hp'] = 0;
				}

				if ($dress['bron1'] > 0) $dress['bron1'] += 3;
				if ($dress['bron2'] > 0) $dress['bron2'] += 3;
				if ($dress['bron3'] > 0) $dress['bron3'] += 3;
				if ($dress['bron4'] > 0) $dress['bron4'] += 3;

				if ($dress['bron1'] > 0 || $dress['bron2'] > 0 || $dress['bron3'] > 0 || $dress['bron4'] > 0) {
					$mfinfo['bron'] = 3;
				} else {
					$mfinfo['bron'] = 0;
				}

				$dress['unik'] = 1;
				$dress['name'].= ' (��)';

				$mfinfo = mysql_real_escape_string(serialize($mfinfo));

				}



			if(mysql_query("INSERT INTO oldbk.`inventory`
					(`getfrom`,`prototype`,`owner`,`sowner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
						`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str." , `ab_mf`,`ab_bron`,`ab_uron`, `ekr_flag`,`unik`,`stbonus`,`mfinfo`
					)
					VALUES
					(30,'{$dress['id']}','{$tonick['id']}','{$dress['sowner']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},".$dress['ecost'].",'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
					'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
					,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}' ".$sql." ,'{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['ekr_flag']}','{$dress['unik']}','{$dress['stbonus']}','{$mfinfo}'
					) ;"))
					{
						$good = 1;
						$artins_id=mysql_insert_id();
						$dress['id']=$artins_id;
					}
					else {
						$good = 0;
						echo mysql_error();
					}

				if ($good) {
					if ($bot && $botlogin) {
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['artlog']}','{$artifakts_prise[$artid]}','{$artid}');");
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['artlog']}','{$artifakts_prise[$artid]}','{$artid}');");
					}
					else {
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['artlog']}','$artifakts_prise[$artid]','{$artid}');");
					}
					$id_ins_part_del=mysql_insert_id();
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$artifakts_prise[$artid]}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=54;//������� ������� �� �������
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$artifakts_prise[$artid];
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

					if (olddelo==1)
					{
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','&quot;".$_POST['artlog']."&quot; ����� {$dress['name']} ({$artifakts_prise[$artid]}���.) ����� ������ ".$user['login']."',9,'".time()."');");
					}


					//������ �� ������� �����
					//��������� ���� 500
					if ((time()>1336003201-14400) and (time()<1336089599-14400))
						{
						// �����
						$add_bonuss_art=round(($artifakts_prise[$artid]*0.15),2);
						$tobank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = '{$tonick[id]}' LIMIT 1;"));
							if ($tobank[id]>0)
								{
								mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$add_bonuss_art}' WHERE `id` = '{$tobank[id]}' LIMIT 1;");
								mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr) values (450,'KO','{$tobank[id]}','{$tonick[login]}','{$add_bonuss_art}');");


								//new_delo
			  		    			$rec['owner']=$tonick[id];
								$rec['owner_login']=$tonick[login];
								$rec['owner_balans_do']=$tonick['money'];
								$rec['owner_balans_posle']=$tonick['money'];
								$rec['target']=$user[id];
								$rec['target_login']=$user[login];
								$rec['type']=55;//����� �� ���� �� �������
								$rec['sum_kr']=0;
								$rec['sum_ekr']=$add_bonuss_art;
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
								$rec['bank_id']=$tobank[id];

								add_to_new_delo($rec); //�����
								if (olddelo==1)
								{
								mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','�������� ".$add_bonuss_art." ��� �� ���� �".$tobank[id]." ����� �� ���.������',9,'".time()."');");
								}
								$bon_ok=1;
								}
								else
								{
									if ($XML_OUT)
									{
									echo "<answer code='45'>����� �� ������� �� �������� �� ������� �� ������ ����������� �����!</answer>";
									}
									else
									{
									err("����� �� ������� �� �������� �� ������� �� ������ ����������� �����!");
									}
								}
						}
					/////////////////////////////

					if ( $tonick['odate'] > (time()-60)  )
					{
						addchp('<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b> �� ������ '.$user['login'].'  ','{[]}'.$_POST['artlog'].'{[]}',$tonick['room'],$tonick['id_city']);
						if ($bon_ok==1)
							{
						addchp('<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_bonuss_art.' ���. ����� �� ���.������ ','{[]}'.$_POST['artlog'].'{[]}',$tonick['room'],$tonick['id_city']);
							}
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b> �� ������ '.$user['login'].'  '."');");
						if ($bon_ok==1)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_bonuss_art.' ���. ����� �� ���.������  '."');");
						}
					}

					  // ���������
					 CheckRealPartners($tonick['id'],$artifakts_prise[$artid],$_SESSION['uid']);
				    	 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	  if ($p_user['partner']!='' and $p_user['fraud']!=1)
				      	 {
				       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$artifakts_prise[$artid]}','{$bank['id']}','".time()."');");
				      	 $bonus=round(($artifakts_prise[$artid]/100*$partner['percent']),2);
				      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$artifakts_prise[$artid]}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");

				     	 }
				         //


					$balans['sumekr']=$balans['sumekr']-$artifakts_prise[$artid];
					if ($XML_OUT)
					{
					echo "<answer code='0' type='4' ekr='{$artifakts_prise[$artid]}' item='{$dress['name']}' login='{$tonick[login]}' >������� ������ �������!</answer>";
					}
					else
					{
					err("������� {$dress['name']} ��� ��������� {$_POST['artlog']} ����������� �������!");
					}
				}
			}
			else {
				if ($XML_OUT)
				{
				echo "<answer code='41'>����� �������� �� ����������!</answer>";
				}
				else
				{
				err("����� �������� �� ����������!");
				}

			}
		}
		elseif ($_POST['givearts']) {
							if ($XML_OUT)
							{
							echo "<answer code='42'>������������ ������ �� �������!</answer>";
							}
							else
							{
							err("������������ �����. ��������� ���� ������!");
							}
		}
            }
            else
            {
			if ($XML_OUT)
			{
			echo "<answer code='43'>������ �� ��������!</answer>";
			}
			else
			{
			err("������ �� ��������!");
			}
            }
	}
	elseif ($_POST['givearts'])
	{
			if ($XML_OUT)
			{
			echo "<answer code='44'>������ ��������!</answer>";
			}
			else
			{
			err("������ ��������!");
			}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  if    (($ART_BILL==1)and($_POST[art_bill_pay])and($_POST[art_bill_sum]))
  	{
  	  if ($balans['sumekr'] >= $_POST[art_bill_sum] )
  	  	{
  	  		if (strpos($_POST[art_bill_nom],"SC" ) !== FALSE)
  	  			{
  	  			//��������� ������ ��
  	  			$bil_id=substr($_POST[art_bill_nom], 2);
  		  		$get_bill_id=mysql_fetch_array(mysql_query("select * from oldbk.com_service where id='".mysql_real_escape_string($bil_id)."'"));
				 if ($get_bill_id[id]>0)
	  	  	 		{
	  	  	 		//���� ����
	  	  	 		 if ($get_bill_id[stat]==0)
	  	  	 		 	{
	 		  		  	    //� ������� �� �������
							if (($get_bill_id[cost]==$_POST[art_bill_sum]) and ($get_bill_id[cost]>0))
								{
								 //��� ��� ����� ���������
								  // ����� �������� ����� ����� � ������� , �������� �� ��������� � �������� � �������� �������

								  if ($get_bill_id[type]==444)
								  {
								  //������ ������ � ����� ������ 2
								 mysql_query("UPDATE `oldbk`.`com_service` SET `stat`=2, dil='{$user[id]}'  WHERE `id`='{$bil_id}' and stat=0;");
								 jail_goway($get_bill_id[owner],$get_bill_id[cost],$get_bill_id[id]);
								  }
								  else
								  {
								 mysql_query("UPDATE `oldbk`.`com_service` SET `stat`=1, dil='{$user[id]}'  WHERE `id`='{$bil_id}' and stat=0;");
								 }



								  if (mysql_affected_rows()>0)
										{
										$atelo=check_users_city_data($get_bill_id[owner]);



										if ($bot && $botlogin) {	mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$atelo['login']}','{$get_bill_id[cost]}','777');");}
										if ($user[deal]==0)    {	mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('83','������','0','{$atelo['login']}','{$get_bill_id[cost]}','777');"); }
										mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$atelo['login']}','{$get_bill_id[cost]}','777');");
										//���������� ��������� ��������� ��� ����� �����
										if ($atelo['odate'] > (time()-60) )
										{
										addchp('<font color=red>��������!</font> ��� ������� ���� � ������������ ����� �SC'.$bil_id.'  ������� '.$user['login'].'  ','{[]}'.$atelo['login'].'{[]}',$atelo['room'],$atelo['id_city']);
										} else {
										// ���� � ���
										mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$atelo['id']."','','".'<font color=red>��������!</font> ��� ������� ���� � ������������ ����� �SC'.$bil_id.' ������� '.$user['login'].'  '."');");
										}

									  	//�������� ����� �������
										mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$get_bill_id[cost]}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

									  	//����� ����� ���� � �������� �������
									  	include ('price.php');
									  	$str_type=$PRICE[$get_bill_id[type]][desc];
										mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`,`present`) VALUES(30,'{$atelo['id']}','���� �� ������ �����','50',0,0,'paper100.gif','���� �� ������ ������:<b>{$str_type}</b>.<br>\n �����:{$get_bill_id[cost]} ��� <br>\n ����� �����:<b>SC{$get_bill_id[id]}</b>  - <b>��������</b>',1,0,'������������ �����') ;");

							     		  		if ($XML_OUT)
											{
											echo "<answer code='0' type='5' ekr='{$get_bill_id[cost]}' login='{$atelo['login']}' >������� ������� ����!</answer>";
											}
											else
											{
				     	  						err("���� � ������������ ����� ������ �������!");
											}

										}
										else
										{
											if ($XML_OUT)
											{
											echo "<answer code='50'>������ ������ ����� � ������������ �����!</answer>";
											}
											else
											{
							     	  		  	 err("������ ������ ����� � ������������ �����!");
							     	  		  	}
										}

								}
								else
								{
				  	  	 		 	if ($XML_OUT)
									{
									echo "<answer code='51'>������. ���� ���� � ������������ ����� �� �� ����� {$_POST[art_bill_sum]}. �������� � ��������� ����� �����!</answer>";
									}
									else
									{
			 	    	  		   		err("������. ���� ���� � ������������ ����� �� �� ����� {$_POST[art_bill_sum]}. �������� � ��������� ����� �����!");
			 	    	  		   		}
								}
	  	  	 		 	}
	  	  	 		 	else
	  	  	 		 	{
		  	  	 		 	if ($XML_OUT)
							{
							echo "<answer code='52'>������. ���� ���� � ������������ ����� ��� �������!</answer>";
							}
							else
							{
	 	     	  		   		err("������. ���� ���� � ������������ ����� ��� �������!");
	 	     	  		   		}

	  	  	 		 	}

	  	  	 		}
	  	  	 		else
	  	  	 		{
	  	  	 			if ($XML_OUT)
						{
						echo "<answer code='53'>������. ����� ���� � ������������ ����� �� ������!</answer>";
						}
						else
						{
			  			err("������. ����� ���� � ������������ ����� �� ������!");
			  			}
	  	  	 		}

  	  			}
  	  			 else
  	  			{
	  	  		//���� ���� �� ����
  		  		$get_bill_id=mysql_fetch_array(mysql_query("select * from oldbk.art_prototype where id='".mysql_real_escape_string($_POST[art_bill_nom])."'"));
  	  			 if ($get_bill_id[id]>0)
	  	  	 	{
  		  	 	//���� ����� ����
		  	  	 if ($get_bill_id[art_status]==0)
		  	  	    {
	  		  	    //� ������� �� �������
					if (($get_bill_id[ecost]==$_POST[art_bill_sum]) and ($get_bill_id[ecost]>0))
					 {
					 //��� ��� ����� ���������
					  // ����� �������� ����� ����� � ������� , �������� �� ��������� � �������� � �������� �������
					  mysql_query("UPDATE `oldbk`.`art_prototype` SET `art_status`=1, dil='{$user[id]}'  WHERE `id`='{$get_bill_id[id]}' and art_status=0;");
					  if (mysql_affected_rows()>0)
						{
					if ($get_bill_id[owner]==22125)
				  	{
				  	$art_telo=mysql_fetch_assoc(mysql_query("select * from oldbk.users where id=(select glava from oldbk.clans where short='{$get_bill_id[arsenal_klan]}');"));
				  	$str_type=' ��������� ��������� ��� ����� \"'.$get_bill_id[arsenal_klan].'\" ';
				  	$str_pay=$get_bill_id[ecost].' ���. - <b>��������.</b>';
				  	}
				  	else
				  	{
				  	$art_telo=check_users_city_data($get_bill_id[owner]);
					$str_type=' ������� ��������� ��� ��������� \"'.$art_telo[login].'\"';
				  	$str_pay=$get_bill_id[ecost].' ���. - <b>��������.</b>';
				  	}

						if ($bot && $botlogin) {	mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$art_telo['login']}','{$get_bill_id[ecost]}','77');");}
						if ($user[deal]==0)    {	mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('83','������','0','{$art_telo['login']}','{$get_bill_id[ecost]}','77');"); }
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$art_telo['login']}','{$get_bill_id[ecost]}','77');");

						//�������� ����� �������
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$get_bill_id[ecost]}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

						//���������� ��������� ��������� ��� ����� �����

						if ($art_telo['odate'] > (time()-60) )
						{
						addchp('<font color=red>��������!</font> ��� ������� ���� �� ������� ��������� ������� '.$user['login'].'  ','{[]}'.$art_telo['login'].'{[]}',$art_telo['room'],$art_telo['id_city']);
						} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$art_telo['id']."','','".'<font color=red>��������!</font> ��� ������� ���� �� ������� ��������� ������� '.$user['login'].'  '."');");
						}

						//����� ����� ���� � �������� �������
						mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`)
						VALUES(30,'{$art_telo[id]}','���� �� ������ ���������','50',0,0,'paper100.gif','���� �� ������ {$str_type}:<br>\n �����:{$str_pay} <br>\n ����� �����:<b>{$get_bill_id[id]}</b> ',1,0) ;");

							if ($XML_OUT)
							{
							echo "<answer code='0' type='6' ekr='{$get_bill_id[ecost]}' login='{$art_telo['login']}' >������� ������� ����!</answer>";
							}
							else
							{
				     	  		err("���� ������ �������!");
							}
						}
						else
						{
					  		if ($XML_OUT)
							{
							echo "<answer code='54'>������ ������ �����!</answer>";
							}
							else
							{
			     	  		  	 err("������ ������ �����!");
			     	  		  	}
						}
				 	}
				 	else
				 	{
			  		if ($XML_OUT)
						{
						echo "<answer code='58'>������. ���� ���� �� �� ����� {$_POST[art_bill_sum]}. �������� � ��������� ����� �����!</answer>";
						}
						else
						{
	 	    	  		   	err("������. ���� ���� �� �� ����� {$_POST[art_bill_sum]}. �������� � ��������� ����� �����!");
	 	    	  		   	}
				 	}
  	  	 	   	}
  	  	 	   	else
  	  	 	   	{
		  		if ($XML_OUT)
					{
					echo "<answer code='57'>������. ���� ���� ��� �������!</answer>";
					}
					else
					{
	     	  		   	err("������. ���� ���� ��� �������!");
	     	  		   	}
  	  	 	  	}
  	  	 	    }
  	  		    else
  	  		    	{
			  		if ($XML_OUT)
					{
					echo "<answer code='56'>������. ����� ���� �� ������!</answer>";
					}
					else
					{
		  			err("������. ����� ���� �� ������!");
		  			}
  	  		    	}
  		  	}
  	  	}
  	  	else
  	  	{
	  		if ($XML_OUT)
			{
			echo "<answer code='55'>������������ ������ �� �������!</answer>";
			}
			else
			{
			err("������������ �����. ��������� ���� ������!");
			}
  	  	}


  	}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ((($_POST['billogin']!='')AND($_POST['givebil'])AND( (int)($_POST['bilkol'])>0 ) ) and ($user['klan']=='radminion') )
{
$bilprice=2;
$kol=(int)($_POST['bilkol']);
$ok_bill_c=0;

   for ($kkk=1;$kkk<=$kol;$kkk++)
    {
  //  echo "$kkk <br>";
			if ( ( $balans['sumekr'] >= $bilprice ) )
			{
			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['billogin']}' LIMIT 1;"));
			if ($tonick['login'])
			{
			$get_lot=mysql_fetch_array(mysql_query("select * from oldbk.item_loto_ras where status=1 LIMIT 1;"));
			if ($get_lot[id] >0)
			     {

				if (($get_lot[lotodate]-300) >=time() )
				{

				if(mysql_query("INSERT INTO oldbk.`item_loto` SET `loto`={$get_lot[id]},`owner`={$tonick[id]},`dil`={$user[id]},`lotodate`='".date("Y-m-d H:i:s",$get_lot[lotodate])."';"))
					{
					$good = 1;
					$city_dbase[0]='oldbk.';
					$city_dbase[1]='avalon.';
					$city_dbase[2]='angels.';
					$prefix=$city_dbase[$tonick['id_city']];
					$tonick = mysql_fetch_array(mysql_query("SELECT * FROM {$prefix}`users` WHERE `id` = '{$tonick[id]}' LIMIT 1;"));
					$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='33333' ;"));
									$new_bil_id=mysql_insert_id();
									$dress['letter']="��������� ����� ������� �� ������� ��������� ".date("Y-m-d H:i:s",$get_lot['lotodate']);
									$dress['upfree']=$get_lot[id];
									$dress['mffree']=$new_bil_id;
									$dress['present'] = "�����";

						mysql_query("INSERT INTO oldbk.`inventory`
						(`prototype`,`sowner`,`present`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
							`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
							`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`idcity`, `includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`, `ab_mf`,  `ab_bron` ,  `ab_uron`, `img_big`,
							`otdel`,`gmp`,`gmeshok`, `group`,`letter`,`getfrom`,`rareitem`,`stbonus`,`mfbonus`,`unik`,`notsell`,`craftspeedup`,`craftbonus`,`gold` ".$str."
						)
						VALUES
						('{$dress['id']}','{$tonick['id']}','{$dress['present']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
						'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
						'{$dress['nalign']}','{$dress['dategoden']}','{$dress['goden']}','{$user['id_city']}' , '{$dress[includemagic]}','{$dress[includemagicdex]}','{$dress[includemagicmax]}','{$dress[includemagicname]}','{$dress[includemagicuses]}','{$dress[includemagiccost]}','{$dress[includemagicekrcost]}', '{$dress['ab_mf']}',  '{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['img_big']}'
						,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','1','{$dress['rareitem']}','{$dress['stbonus']}','{$dress['mfbonus']}','{$dress['unik']}','{$dress['notsell']}','{$dress['craftspeedup']}','{$dress['craftbonus']}','{$dress['fairprice']}' ".$sql."
						) ;");

					$dress[id]=mysql_insert_id();
					$dress[idcity]=$user[id_city];
					}
					else {
						$good = 0;

					}

				if ($good) {
					if ($bot && $botlogin) {
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['billogin']}','{$bilprice}','33333');");
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['billogin']}','{$bilprice}','33333');");
					}
					else {

					$real_flag=1;
					if (($user['klan']=='radminion') OR ($user['klan']=='Adminion') )
					{
						if ($_POST['real']!='yes')
						{
						$real_flag=0;
						}
					}


						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition,b) values ('{$user['id']}','{$user['login']}','0','{$_POST['billogin']}','$bilprice','33333','{$real_flag}');");
					}
					$id_ins_part_del=mysql_insert_id();
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$bilprice}' WHERE `owner` = '{$user['id']}' LIMIT 1;");


					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
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


					if ($tonick['odate'] > (time()-60) )
					{
						addchp('<font color=red>��������!</font> ��� ������� <b>����� ����� (���</b>','{[]}'.$_POST['billogin'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� <b>���������� ����� �����</b> �� ������ '.$user['login'].'  '."');");
					}

					  // ���������
					 CheckRealPartners($tonick['id'],$bilprice,$_SESSION['uid']);
				    	 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	  if ($p_user['partner']!='' and $p_user['fraud']!=1)
				      	 {
				       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('{$_SESSION['uid']}','{$partner['id']}','{$tonick['id']}','{$bilprice}','{$bank['id']}','".time()."');");
				      	 $bonus=round(($bilprice/100*$partner['percent']),2);
				      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$bilprice}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");

				     	 }
				         //
					$balans['sumekr']=$balans['sumekr']-$bilprice;

						if ($XML_OUT)
						{
						echo "<answer code='0' type='7' ekr='{$bilprice}' login='{$tonick[login]}' nom='{$kkk}' >������� ������ ���������� ����� �����!</answer>";
						}
						else
						{
							$ok_bill_c++;
						}

				  }
				$bonus_begin=mktime(19,0,0,11,24,2011);
				$bonus_end=mktime(21,0,0,11,24,2011);
				  if ((time()>$bonus_begin) AND (time()<$bonus_end)) {$BONUS_BIL=1; } else { $BONUS_BIL=0; }
				  if ($BONUS_BIL==1)
				  {
				  if(mysql_query("INSERT INTO oldbk.`item_loto` SET `loto`={$get_lot[id]},`owner`={$tonick[id]},`dil`={$user[id]},`lotodate`='".date("Y-m-d H:i:s",$get_lot[lotodate])."';"))
					{
					$new_bil_id=mysql_insert_id();
					mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`name`,`duration`,`maxdur`,`cost`,`owner`,`nlevel`,`nsila`,`nlovk`,`ninta`,`nvinos`,`nintel`,`nmudra`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nalign`,`minu`,`maxu`,`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`img`,`text`,`dressed`,`bron1`,`bron2`,`bron3`,`bron4`,`dategoden`,`magic`,`type`,`present`,`sharped`,`massa`,`goden`,`needident`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`letter`,`isrep`,`update`,`setsale`,`prototype`,`otdel`,`bs`,`gmp`,`includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`,`gmeshok`,`tradesale`,`karman`,`stbonus`,`upfree`,`ups`,`mfbonus`,`mffree`,`type3_updated`,`bs_owner`,`nsex`,`present_text`,`add_time`,`labonly`,`labflag`,`prokat_idp`,`prokat_do`,`arsenal_klan`,`repcost`,`up_level`,`ecost`,`group`,`ekr_up`,`unik`,`add_pick`,`pick_time`,`sowner`,`idcity`,`ekr_flag`)
					VALUES (30,'���������� ����� �����',0,1,0,{$tonick[id]},0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'oldbkloto.gif','',0,0,0,0,0,0,0,210,'������� �����',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'"."����� �".$new_bil_id."<br>����� �".$get_lot[id]."<br>C�������� ".date("Y-m-d H:i:s",$get_lot[lotodate])."',1,'".date("Y-m-d H:i:s")."',0,33333,'6',0,0,0,0,0,'',0,0,0,0,0,0,0,{$get_lot[id]},0,0,{$new_bil_id},0,0,0,NULL,0,0,0,0,NULL,'',0,0,2,0,NULL,0,NULL,NULL,0,'{$user[id_city]}','1');");
					$dress[id]=mysql_insert_id();
					$dress[idcity]=$user[id_city];


					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('450','KO','0','{$_POST['billogin']}','$bilprice','33333');");
					$id_ins_part_del=mysql_insert_id();

					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=56;//������� ������� �� ������� � �����
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

					if ($tonick['odate'] > (time()-60) )
					{
						addchp('<font color=red>��������!</font> ��� ������� � ����� <b>���������� ����� �����</b> �� ������ '.$user['login'].'  ','{[]}'.$_POST['billogin'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� � ����� <b>���������� ����� �����</b> �� ������ '.$user['login'].'  '."');");
						}

						//�����
						if ($XML_OUT)
						{
						echo "<answer code='0' type='7' ekr='0' login='{$tonick[login]}' nom='{$kkk}' addinf='bonus' >������� ������� ���������� ����� �����!</answer>";
						}
					}
			        } //BONUS



			        }
			         else
			         {

			    		 if ($XML_OUT)
						{
						echo "<answer code='74'>������� �������� ����� 5 ����� ��� ��� ��������! ����� �������� ���������� ���������!</answer>";
						}
						else
						{
						err("������� �������� ����� 5 ����� ��� ��� ��������! ����� �������� ���������� ���������!");
						}
					break;
			         }
			    }
			    else
			    {
					    if ($XML_OUT)
						{
						echo "<answer code='75'>���� ��� ������ �� ���������� ��������� �������!</answer>";
						}
						else
						{
						err("���� ��� ������ �� ���������� ��������� �������!");
						}
				break;
			    }
			}
			else {
				if ($XML_OUT)
				{
				echo "<answer code='76'>����� �������� �� ����������!</answer>";
				}
				else
				{
				err("����� �������� �� ����������!");
				}
				break;
			}
		}
		else  {
				if ($XML_OUT)
							{
							echo "<answer code='77'>������������ ������ �� �������!</answer>";
							}
							else
							{
							err("������������ �����. ��������� ���� ������!");
							}
			break;
		}
            } //for

		if ($ok_bill_c > 0)
			{
			err("������� ������� ".$ok_bill_c." ��. ���������� ������� ����� ��� ��������� {$_POST['billogin']} !");
			}

	}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//	========
	if ($_POST['openbank_temp_offfffff']) {
		if ($_POST['charlog']) {
			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['charlog']}' LIMIT 1;"));
			if ($tonick['login']) {
				if (mysql_query("UPDATE `users` set `money` = `money`+'0.5' WHERE `id` = '{$tonick['id']}' LIMIT 1;")) {


					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money']+0.5;
					$rec['target']=$user[id];
					$rec['target_login']=$user[login];
					$rec['type']=57;//������� 0,5 �� �� �������
					$rec['sum_kr']=0.5;
					$rec['sum_ekr']=0;
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

					add_to_new_delo($rec); //�����
					if (olddel==1)
					{
					mysql_query("INSERT INTO oldbk.`delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$tonick['id']}','�������� 0.5 ��. �� �������� ����� � ����� �� ������ ".$user['login']."',9,'".time()."');");
					}

					print "<b><font color=red>������� ���������� 0.5 �� ��������� {$_POST['charlog']}!</font></b>";
				}
				else {
					print "<b><font color=red>��������� ������!</font></b>";
				}
			}
			else {
				print "<b><font color=red>����� �������� �� ����������!</font></b>";
			}
		}
	}
///////////////////////////////////////////////////////////////////////////////
	$sklonka_array=array(2,3,6);
	$eff_align_type=5001;
	$ali_cos=15;
	if ($FALIGN==1)
	{
	if ($_POST['givesklonka'] && $balans['sumekr'] >= $ali_cos)
	{

		if ($_POST['sklonkalog'] && in_array($_POST['sklonka'],$sklonka_array) )
		{
			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['sklonkalog']}' LIMIT 1;"));
			$tonick = check_users_city_data($tonick[id]);
            		$cheff=mysql_fetch_array(mysql_query("SELECT * from  ".$db_city[$tonick[id_city]]."effects WHERE type = '".$eff_align_type."' AND owner = '".$tonick['id']."' LIMIT 1;"));
			if ($cheff['id']>0)
				{
				//������� �� ��� ����!
				mysql_query("DELETE from  ".$db_city[$tonick[id_city]]."effects WHERE id='{$cheff['id']}' LIMIT 1; ");
				}
			/*
			if($tonick['login'] && $cheff['time']>time() && $cheff['add_info']!=$_POST[sklonka])
			{
					if ($XML_OUT)
						{
						echo "<answer code='105'>� ������� ��������� ��� �� ����� ����� �� ����� ����������!</answer>";
						}
						else
						{
						err("� ������� ��������� ��� �� ����� ����� �� ����� ����������");
						}
			}
			*/

			if ($tonick['login'])
			{
				if ($tonick['align'] || $tonick['klan'])
				{
					if ($XML_OUT)
						{
						echo "<answer code='104'>�������� ��� ����� ���������� ���� ������� � �����!</answer>";
						}
						else
						{
						err("�������� ��� ����� ���������� ���� ������� � �����!");
						}
				}
				else
				{


					if (mysql_query("UPDATE oldbk.`users` set `align` = '{$_POST['sklonka']}' WHERE `id` = '{$tonick['id']}' LIMIT 1;"))

					 {
						if ($_POST['sklonka'] == 2) {$skl="�����������"; $skl2="�����������";}
						if ($_POST['sklonka'] == 3) {$skl="������"; $skl2="������";}
						if ($_POST['sklonka'] == 6) {$skl="�������"; $skl2="�������";}

						$qlist=array();
					        $i=0;
					        $data=mysql_query("SELECT * FROM oldbk.beginers_quest_list WHERE  aganist like '%".$_POST['sklonka']."%';");
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

						if($la!=$_POST['sklonka'] )
						{
							$sql="INSERT INTO ".$db_city[$tonick[id_city]]."effects
							(`type`, `name`, `owner`, `time`, `add_info`)  VALUES
							('".$eff_align_type."','����� �������','".$tonick['id']."','".$eff_align_time."','".$_POST['sklonka']."');";

							mysql_query($sql);
							//������ ���, ���������.
						}

						//������ ������
						mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=4848,`allcount`='1' ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'1' ;");


						if ($bot && $botlogin)
						{
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$_SESSION['uid']}','{$botfull}','0','{$_POST['sklonkalog']}','{$ali_cos}',{$_POST['sklonka']});");
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['sklonkalog']}','{$ali_cos}',{$_POST['sklonka']});");
						}
						else {
							mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('{$user['id']}','{$user['login']}','0','{$_POST['sklonkalog']}','{$ali_cos}',{$_POST['sklonka']});");
						}

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$ali_cos}' WHERE `owner` = '{$user['id']}' LIMIT 1;");

						//new_delo
	  		    			$rec['owner']=$tonick[id];
						$rec['owner_login']=$tonick[login];
						$rec['owner_balans_do']=$tonick['money'];
						$rec['owner_balans_posle']=$tonick['money'];
						$rec['target']=$user[id];
						$rec['target_login']=$user[login];
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



						if ($user['sex'] == 1) {$action="��������";}
						else {$action="���������";}

						mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','����� &quot;".$user['login']."&quot; ".$action." &quot;".$_POST['sklonkalog']."&quot; ".$skl2." ����������','".time()."');");

						telepost_new($tonick,'<font color=red>��������!</font> ������� ������ ���������� �1 ��������� � <a href="javascript:void(0)" onclick='.(!is_array($_SESSION['vk'])?"top.":"parent.").'cht("http://capitalcity.oldbk.com/myabil.php#my")>������ ����� ������ ��������</a>.');

						present_bonus_sert($tonick,$user);

						$balans['sumekr']=$balans['sumekr']-$ali_cos;
						if ($XML_OUT)
						{
						echo "<answer code='0' type='10' ekr='{$ali_cos}' login='{$tonick[login]}' addinf='{$skl}' >������� ��������� ����������!</answer>";
						}
						else
						{
						err("<b><font color=red>������� ���������  {$skl} ���������� ��������� {$_POST['sklonkalog']}!");
						}
					}
					else
					{
						if ($XML_OUT)
						{
						echo "<answer code='103'>��������� ������!</answer>";
						}
						else
						{
						err("��������� ������!");
						}

					}
				}
			}
			else
			{
				if ($XML_OUT)
				{
				echo "<answer code='102'>����� �������� �� ����������!</answer>";
				}
				else
				{
				err("����� �������� �� ����������!");
				}
			}
		}
		else
		{
				if ($XML_OUT)
				{
				echo "<answer code='107'>������ ����������!</answer>";
				}
				else
				{
				err("������ ����������!");
				}

		}



	        				/*if ($XML_OUT)
						{
						echo "<answer code='199'>������ ��������!</answer>";
						}
						else
						{
						err("������ ��������!");
						}
						*/

	}
	elseif ($_POST['givesklonka']) {

			if ($XML_OUT)
							{
							echo "<answer code='101'>������������ ������ �� �������!</answer>";
							}
							else
							{
							err("������������ �����. ��������� ���� ������!");
							}
	}
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	if($_POST[prem_ak]  && (int)$_POST[acctype]<=3 && (int)$_POST[acctype]>0 && $_POST['login'] )
	{
	if ($user['id']==14897)
	{
	$acctype=(int)$_POST[acctype];
	$sub_type=explode(":",$_POST[akk_param][$acctype]);
	$sub_type=$sub_type[0]; // ��� ����� ���
  	$akkcost=$new_akks_prise[$acctype][$sub_type];

  	if ($balans['sumekr'] >= $akkcost && $akkcost > 0)
  		{

		$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['login']}' LIMIT 1;"));
		$tonick = check_users_city_data($tonick[id]);
		$bank = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' order by def desc,id limit 1"));

		if($tonick[id]>0 )
		{
		    if 	(($tonick[prem]==$acctype) or ($tonick[prem]==0) )
		    	{

		    	////������ ���////
		    	//echo "KD1:$sub_type";
			$exp=main_prem_akk($tonick,$acctype,$user,$sub_type);


			if ($exp>0)
			{

			$dilindx[1]=7;
			$dilindx[2]=17;
			$dilindx[3]=117;

				if ($bot && $botlogin) {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values
					('{$_SESSION['uid']}','{$botfull}','{$bank['id']}','{$_POST['login']}','{$akkcost}','{$dilindx[$acctype]}');");

					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values
					('{$user['id']}','{$user['login']}','{$bank['id']}','{$_POST['login']}','{$akkcost}','{$dilindx[$acctype]}');");
					}
				else {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values
					('{$user['id']}','{$user['login']}','{$bank['id']}','{$_POST['login']}','{$akkcost}','{$dilindx[$acctype]}');");
				}
				$id_ins_part_del=mysql_insert_id();

				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'".$akkcost."' WHERE `owner` = '{$user['id']}' LIMIT 1;");

				//new_delo
	    			$rec['owner']=$tonick[id];
				$rec['owner_login']=$tonick[login];
				$rec['owner_balans_do']=$tonick['money'];
				$rec['owner_balans_posle']=$tonick['money'];
				$rec['target']=$user[id];
				$rec['target_login']=$user[login];
					$actty[1]=59;
					$actty[2]=359;
					$actty[3]=358;
				$rec['type']=$actty[$acctype] ;//������� silvera/gold/platinum �� �������
				$rec['sum_kr']=0;
				$rec['sum_ekr']=$akkcost;
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
				$rec['bank_id']=$bank['id'];
				$rec['add_info']=(date('d-m-Y',$exp));

				add_to_new_delo($rec); //�����

				if ($user['sex'] == 1) {$action="��������/�������";}
				else {$action="���������/��������";}
				$balans['sumekr']=$balans['sumekr']-$akkcost;

				addchp('<font color=red>��������!</font> ��� �������� '.$strtype[$acctype].' account ������� '.$user['login'].'.  ','{[]}'.$_POST['login'].'{[]}',$tonick['room'],$tonick['id_city']);

				if ($XML_OUT)
				{
				echo "<answer code='0' type='11' ekr='{$akkcost}' login='{$tonick[login]}' addinf='{$strtype[$acctype]}'>������� �������� ������� �������!</answer>";
				}
				else
				{
				print "<b><font color=red>������� �������� ".$strtype[$acctype]." account ��������� {$_POST['login']}!</font></b>";
				}



			}
			else
			{
						if ($XML_OUT)
						{
						echo "<answer code='115'>��������� ������!</answer>";
						}
						else
						{
						err("��������� ������!");
						}
			}

		}
		else
			{
				if ($XML_OUT)
						{
						echo "<answer code='114'>���������� ���������� ������� {$strtype[$acctype]}! � ��������� ��� ����� {$strtype[$tonick[prem]]}!</answer>";
						}
						else
						{
						err("���������� ���������� ������� �� <b>{$strtype[$acctype]}</b> ! � ��������� ��� ����� <b>{$strtype[$tonick[prem]]}</b> !");
						}
			}

		}
	        else
	        {

	        	if ($tonick[id]>0)
	        		{
	        			if ($XML_OUT)
						{
						echo "<answer code='113'>����� ����� �� ������������� ���������!</answer>";
						}
						else
						{
						err("����� ����� �� ������������� ���������");
						}
	        		}
	        		else
	        		{
	        			if ($XML_OUT)
						{
						echo "<answer code='112'>����� �������� �� ����������!</answer>";
						}
						else
						{
						err("����� �������� �� ����������!");
						}
	        		}
	        }

	        }
	        else
	        	{
				if ($XML_OUT)
							{
							echo "<answer code='111'>������������ ������ �� �������!</answer>";
							}
							else
							{
							err("������������ �����. ��������� ���� ������!");
							}
			}
	        }
	        else
	        {
	        				if ($XML_OUT)
						{
						echo "<answer code='199'>������ ��������!</answer>";
						}
						else
						{
						err("������ ��������!");
						}
		}

	}



//////////////////////////////////////////////////////////////////////////////////////////////////////
if  (!($XML_OUT))
{

		echo "<table border=0>
		<tr valign=top><td >";

		$koshel='Z755383101103';	// ��� ����
	//	$koshel='Z206515604818';	// ��� ���� 2


		echo "<fieldset style=\"text-align:justify; width:250px; height:52px;\">";
 		echo '<legend><b>���������� ������� WMZ</b></legend>
 		<br><center>
 		<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp" target= _blank>
			<input type="hidden" name="traderid" value="'.$user['id'].'">
		�����: <input name="LMI_PAYMENT_AMOUNT" value="0" size="4"> WMZ <input type="hidden" value="'.$koshel.'" name="LMI_PAYEE_PURSE">
		<input type="hidden" name="LMI_PAYMENT_DESC" value="���������� ������� '.$user['login'].'">
		<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'">
		<input type="submit" value="��������">
		</form>';
		echo "</center></fieldset>";
		echo "<br>";

		//echo "</td><td >";
		/*
		echo "<fieldset style=\"text-align:justify; width:250px; height:140px;\">";
 		echo '<legend><b>���������� ������� WMR</b></legend>
 		<br><center>';
		$RUR=get_rur_curs();
		echo '<form method="post" action="https://merchant.webmoney.ru/lmi/payment.asp">';
		echo '<input type="hidden" name="traderid" value="'.$user['id'].'">';
		echo '&nbsp;&nbsp;�����: <input name="LMI_PAYMENT_AMOUNT" value="0" size="8" id=wmrrub onChange=\'javascript: callcekrwmr(this.value,\''.$RUR.'\')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcekrwmr(this.value,\''.$RUR.'\')"> WMR ';
		echo '<input type="hidden" value="R418522840749" name="LMI_PAYEE_PURSE">';
		echo '<input type="hidden" name="LMI_PAYMENT_DESC" value="���������� �������  '.$user['login'].'">';
		echo '<input type="hidden" name="LMI_PAYMENT_NO" value="'.time().'"><br>
		<br>
		�� ������: <input type=text id=wmrekr size="8" onChange=\'javascript: callcrubwmr(this.value,\''.$RUR.'\')\';  onkeyup="this.value=this.value.replace(/[^\d]/,\'\'); callcrubwmr(this.value,\''.$RUR.'\')"> ���. <br> <small> (� ������ 10%)</small> ';
		echo '<br><br><input type="submit" value="��������"><br></form>';
		echo "<br>";
		echo "</center></fieldset>";
		echo "<br>";
		*/

		echo "</td><td >";

		echo '<fieldset ><legend>���� ����� ����� �����</legend>';
		$query_curs=mysql_query_cache("select * from oldbk.variables where var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'  or  var='grivna_wmu' ",false,360);
		while(list($k,$row) = each($query_curs))
		{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		 else
		 	if($row['var'] =='euro')  { $euro = $row[value];}
		 		else
		 			if($row['var'] =='grivna') { $grivna = $row[value];}
 					 elseif($row['var'] =='ekrkof') { $ekrkof = $row[value];}
			 		elseif($row['var'] =='ekrbonus') { $ekrbonus = $row[value];}
			 		elseif($row['var'] =='grivna_wmu') { $grivna_wmu = $row[value];}
		}
		$EU=$euro;
		echo "<B>1 </B> ECR = <B>".(ceil($EU/0.01) * 0.01)."</B> EUR<BR>";
		$RUR=round($dollar,3);
		echo "<B>1 </B> ECR = <B>".(ceil($RUR/0.01) * 0.01)."</B> RUR<BR>";
		//echo "<B>1 </B> ECR = <B>".$grivna_wmu."</B> UAH<BR>";
		echo "<B>1 </B> ECR = <B>".$ekrkof."</B> USD<BR>";
		echo "<B>1</B> ECR = <B>200</B> ��.<BR>";
		echo '	</fieldset> ';

		echo "</td>";

		// if (($user['id']==7108) OR ($user['id']==14897) )
		if (1==2)
		{
		echo "<td>";
		$RUR=get_rur_curs();
		echo "<fieldset style=\"text-align:justify; width:450px; height:180px;\">";
 		echo '<legend><b>���������� ������� QIWI</b></legend>';
 		echo $qiwi_mes;
		echo '<form method="post"  >';
 		/* <br> <small><b><?=$RUR;?> ���.= 1���.</b></small> */
		?>
		<table border=0 width="450" >

			<tr>
				<td style="padding:10px 0px; width:55%; text-align:right;">��������� �������: +7</td>
				<td style="padding:10px">
					<input type="text" name="to" id="idto" style="width:130px; border: 1px inset #555;">
				</td>
			</tr>


			<tr>
				<td style="padding:10px 0px; width:55%; text-align:center;">�����</td>
				<td style="padding:10px">
					<input type="text" name="amount_rub" id="qrub" value="0" maxlength="5" style="width:50px; text-align:right;  border: 1px inset #555;" onChange='javascript: callcekr(this.value,"<?=$RUR;?>")';  onkeyup="this.value=this.value.replace(/[^\d]/,''); callcekr(this.value,"<?=$RUR;?>")"> ���.

				</td>
			</tr>
			<tr>
				<td style="padding:10px 0px; width:55%; text-align:center;">�� ���� </td>
				<td style="padding:10px">
					<input type="text" name="amount_ekr" id="qekr" value="0" maxlength="5" style="width:50px; text-align:right;  border: 1px inset #555;" onChange='javascript: callcrub(this.value,"<?=$RUR;?>")';  onkeyup="this.value=this.value.replace(/[^\d]/,''); callcrub(this.value,"<?=$RUR;?>")'"> ��� <small> (� ������ 10%)</small>

				</td>
			</tr>
			<tr>
			<td colspan="2" align=center>
			<input type="submit" name="qiwimkbill" value="��������� ����" />
			<td >
			</td>
			</tr>
		</table>
		<?

		echo '</form>';
		echo "</fieldset>";
		}

		echo "</td></tr></table>";

	if ( ($user[id]==8540) or ($user[id]==14897) or ($user[id]==326) or ($user[id]==102904) || ($user['id'] == 546433))
		{

	echo "<h4>�������� ������ ���</h4>";
	echo "<form method=\"POST\" enctype=\"multipart/form-data\">";
	echo "������ ��� �������� ���.(*.csv, ����������� \";\"):<input type=\"file\" name=\"fileToUpload\">";
	echo "<input type=submit name=\"sendfile\" value=\"���������\">";
	echo "</form>";

	if ($_POST[sendfile])
		{
	        $ext = substr($_FILES['fileToUpload']['name'], 1 + strrpos($_FILES['fileToUpload']['name'], "."));

			if(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
				{
				echo '���� �� ��������!';
				}
			elseif ($ext!='csv')
				{
				echo "��� �� csv-file";
				}
			elseif(is_uploaded_file($_FILES['fileToUpload']["tmp_name"]))
				   {
				     // ���� ���� �������� �������, ���������� ���
				     // �� ��������� ���������� � ��������
				     //+ ���� ����� ���
				     $new_file_name=time().".csv";
				     move_uploaded_file($_FILES['fileToUpload']["tmp_name"], "/www/tmp/".$new_file_name);

				     $file_info= file ('/www/tmp/'.$new_file_name);
				     echo "<table border=1>";
				     echo "<tr>";
				     echo "<td>id</td><td>���</td><td>Bank No.</td><td>Ekr.</td><td>���</td>";
				     echo "</tr>";
					foreach ($file_info as $line_num => $line)
					   {
						 $par=explode(";",$line);

						 if (($par[0]!='') and ($par[1]!='') and ($par[3]!='') )
							{
						     echo "<tr>";
						     if (trim($par[4])=='R')
						     	{
						     	$lr=round($par[3]*600);
						     	}
						     	else
						     	{
						     	$lr='';
						     	}
							$tn = check_users_city_data((int)($par[0]));
						     echo "<td>".(int)($par[0])."</td><td>".$tn['login']."</td><td>".$par[2]."</td><td>".$par[3]."</td><td>".$lr."</td>";
						     echo "</tr>";
						 	}
					    }
					echo "</table>";
					echo "<form method=\"POST\" >";
					echo "<input type=hidden name=filepay value=\"$new_file_name\">";
					echo "<input type=submit name=\"payall\" value=\"��������� ����\">";
					echo "</form>";
		   		}
		}
		else if (($_POST[payall]) AND ($_POST[filepay]))
			{
			//echo "TEST";
			//������ �� �����
			$new_file_name=str_replace("/", "", $_POST[filepay]);
			$new_file_name=str_replace("\\", "", $new_file_name);
			$new_file_name=str_replace("..", "", $new_file_name);
			$file_info= file ('/www/tmp/'.$new_file_name);
			foreach ($file_info as $line_num => $line)
			{
						 $par=explode(";",$line);
						 if (($par[0]!='') and ($par[1]!='') and ($par[3]!='') )
							{

						     	$tonick = check_users_city_data((int)($par[0]));
						     	if ($tonick[id]>0)
						     	   {
							echo "������ ��� ".$tonick['login'];
     							     if (trim($par[4])!='R')
							     	{
								//���������� ���
									if ((int)($par[2])>0)
										{
										$tobank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE  `id` = '".(int)($par[2])."' LIMIT 1;"));
										}
										else
										{
										$tobank = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$tonick['id']}' order by def desc,id limit 1"));
										}

								if ($tobank['owner'] && $tonick['id'] && $tobank['owner'] == $tonick['id'])
								{
								$add_ekr_to_user=floatval($par[3]);
								if ($add_ekr_to_user>0)
								{
									mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$add_ekr_to_user}' WHERE `id` = '{$tobank[id]}' LIMIT 1;") ;
									$pok=true;
								if ((mysql_affected_rows()>0) and ($pok))
							  	{
								mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr) values (450,'KO','{$tobank[id]}','{$tonick[login]}','{$add_ekr_to_user}');");

							      	//new_delo
							      	$rec=array();
			  		    			$rec['owner']=$tonick[id];
								$rec['owner_login']=$tonick[login];
								$rec['owner_balans_do']=$tonick['money'];
								$rec['owner_balans_posle']=$tonick['money'];
								$rec['target']=450;
								$rec['target_login']='KO';
								$rec['type']=51;//������� �� �������
								$rec['sum_kr']=0;
								$rec['sum_ekr']=$add_ekr_to_user;
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
								$rec['bank_id']=$tobank[id];
								add_to_new_delo($rec); //�����

								mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�������� <b>".$add_ekr_to_user." ���.</b> (<i>�����:".($tobank[ekr]+$add_ekr_to_user)." ���. </i>)','{$tobank[id]}');");

								if ($tonick['odate'] > (time()-60))
								{
								addchp('<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_ekr_to_user.' ���. ','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
								} else
								{
								// ���� � ���
								mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_ekr_to_user.' ���. '."');");
								}

								echo "- ���������� ".$add_ekr_to_user." ���.";
							    	}
								else
									{
									echo " - ������ ";
									}
								}
								}
								else
								{
								echo "<b><font color=red>���� ����� {$par[2]} �� ����������� ����� ��������� !</font></b>";
								}
						     	  	}
							     	else
							     	{
							     	//���������� ����
							     	$cit[0]='oldbk.';
								$cit[1]='avalon.';
								$cit[2]='angels.';

								$add_rep=round(floatval($par[3])*600);
								if ($add_rep>0)
									{
									mysql_query("UPDATE ".$cit[$tonick[id_city]]."`users` SET  `rep`=`rep`+'$add_rep' , `repmoney` = `repmoney` + '$add_rep' WHERE `id`= '".$tonick['id']."' LIMIT 1;");

											if (mysql_affected_rows()>0)
											{
											//new_delo
										      	$rec=array();
						  		    			$rec['owner']=$tonick[id];
											$rec['owner_login']=$tonick[login];
											$rec['owner_balans_do']=$tonick['money'];
											$rec['owner_balans_posle']=$tonick['money'];
											$rec['target']=450;
											$rec['target_login']='KO';
											$rec['type']=382;//������� �� �������
											$rec['sum_kr']=0;
											$rec['sum_ekr']=0;
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
											$rec['add_info']='�������';
											add_to_new_delo($rec); //�����
											echo "- ���������� ".$add_rep." ���.";

								if ($tonick['odate'] > (time()-60))
								{
								addchp('<font color=red>��������!</font> ��� ��������� '.$add_rep.' ���. ','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
								} else
								{
								// ���� � ���
								mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ��������� '.$add_rep.' ���. '."');");
								}


											}
									}
									else
									{
									echo "<b><font color=red>������ ���������� ��������� ��� {$tonick['login']}</font></b>";
									}


							     	 }
						     	  }
						     	  else
						     	  {
						     	  echo " Id �� ������";
						     	  }




						     	echo "<br>";
						 	}
			}
				//������� ����
				unlink('/www/tmp/'.$new_file_name);
			}

	echo "<hr>";
	}
////////////////////////////////
}

if (!($XML_OUT))
{
	echo "<h4>��������� ������</h4>
	<h4>�� ������ ������ ��� ������ ���������� {$balans['sumekr']} ���.</h4>
	<table border=1 cellpadding=5 cellspacing=5>
	<tr>
	<td colspan=2>
	<form method=post action=\"dealer.php\"><b>��������� ����������� �� ���� </b><br>
		������� �����:<input type='text' name='ekr' value=''><br>
		��� ���������:<input type='text' name='tonick' value=''><br>
		����� ����� :<input type='text' name='bank' value=''>
		<small>(����� - ��� ����� �� ��������� ��� �������)</small><br>";

	if (($user['klan']=='radminion') OR ($user['klan']=='Adminion') )
		{
		echo ' <input type="checkbox" name="real" value="yes" >�������� ';
		}

	echo "<input type=submit name=putekr value='���������'></form>
		</td></tr>";

	echo 	"<tr>
	<td colspan=2>
	<form method=post action=\"dealer.php\"><b>��������� ��������� : 1��� = 600 ���.</b><br>
		�����:<input type='text' name='reptonick' value=''> ������� ����� ���:<input type='text' name='repsum' value=''>  <input type=submit name=putrep value='���������'>
		<br>
		���������� ����:<input type='text' name='repbankid' value='' size='11'><small>(����� - ��� ����� �� ��������� ��� �������)</small>";

	echo "</form>
		</td></tr>";

	if ($user[id]!=8540)
	{
	echo "<tr><td><form method=post action=\"dealer.php\"><b>��������� ����� / ����� ����� </b><br>	�����: <input type='text' name='charlogin' value=''> ����� �����:<input type='text' name='charbank' value=''> <input type=submit name=checkbank value='���������'></form></td>";
	}

//	echo "<td><form method=post action=\"dealer.php\"><b>�������� ������ �� �������� �����</b><br>�����: <input type='text' name='charlog' value=''> <input type=submit name=openbank value='��������'></td></tr>";
	echo "</tr>";

	if ($FALIGN==1)
	{
	echo "<tr><td><form method=post action=\"dealer.php\"><b>��������� ����������</b><br>
		�����: <input type='text' name='sklonkalog' value=''> ����������:<select name='sklonka'>
					<option value='0'></option>
					<option value='2'>�����������</option>
					<option value='3'>������</option>
					<option value='6'>�������</option></select> <input type=submit name=givesklonka value='���������'></form></td>";
	}

	if ($VAU==1)
     {
	echo "<td><form method=post action=\"\"><b>�������� � ���.�����</b><br>
		�����: <input type='text' name='komlog' value=''> ";
	echo "<select name=price>";
		$ii=0;
		foreach ($vaucher as $k=>$v)
			{
			$ii++;
			echo "<option value=\"$v\" >$k</option>";
			}
		echo "  </select> <input type='text' name='kolv' value='1' size='3'> <input type=submit name=komotdel value='�������'>
		<br>
		���������� ����:<input type='text' name='kombankid' value='' size='11'>
		</form></td>";
    }

	echo "<tr>";
//	echo "<td><form method=post action=\"dealer.php\"><b>�������� ������ �����</b><br>�����: <input type='text' name='obrazlog' value=''> <input type=submit name=obraz value='��������'></td>";


	if ($user['id']==14897)
	{
	echo "<td><form method=post action=\"dealer.php\"><b>���������� Silver/Gold/Platinum account</b><br>
		�����: <input type='text' name='login' value=''>&nbsp;";

	echo "<script>
		function showatime(t)
		{

		    for (var i = 1; i <= 3; i++)
			{
				if (t==i)
				{
				document.getElementById(\"pakk\"+i).style.display= \"block\";
				}
				else
				{
				document.getElementById(\"pakk\"+i).style.display= \"none\";
				}
			}
		}
		</script>";

		echo "Account: <select name=acctype onChange=\"javascript: showatime(this.value) ;\">
			<option value=\"0\">-------</option>
			<option value=\"1\">Silver</option>
			<option value=\"2\">Gold</option>
			<option value=\"3\">Platinum</option>
			</select>&nbsp;	";


		for ($ak=1;$ak<=3;$ak++)
		{
		echo "<span id=pakk{$ak} style=\"display:none\";> ����: <select name=\"akk_param[$ak]\" >";
		foreach ($new_akks_prise[$ak] as $k=>$v)
									{
										$ii++;
										echo '<option '.($k==30?"selected":"").' value="'.$k.':'.$v.'" ';
										echo " >�� {$k} ����, {$v} ���.</option>";
									}
		echo "  </select>";
		echo "</span>";
		}



		echo "<input type=submit name='prem_ak' value='��������'></form></td>";
	}

if ($user['klan']=='radminion')
     {
	echo "<td><form method=post ><b>������� ���������� �����</b><br>
		�����: <input type='text' name='billogin' value=''> ";
	echo " ���.<input type='text' name='bilkol' value='1' size=3 >";
	echo " <input type=submit name=givebil value='�������'>";

		if (($user['klan']=='radminion') OR ($user['klan']=='Adminion') )
		{
		echo '<br> <input type="checkbox" name="real" value="yes" >�������� ';
		}

	echo "</td>";
    }


	echo "</tr>";
	echo "<tr>";

//if ((time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']))
if (false)
{
	echo "<td><form method=post action=\"dealer.php\"><b>������� ����</b><br>
		�����: <input type='text' name='elkalog' value=''> ";
	echo "<select name=buketid>";
		$ii=0;
		foreach ($bukets as $k=>$v)
			{
			/*
			$ii++;

			 if ($bukets_prise[$v]==15) { $elev=6; }
			 elseif ($bukets_prise[$v]==20 || $bukets_prise[$v]==200) { $elev=8; }
			 elseif ($bukets_prise[$v]==25 || $bukets_prise[$v]==250) { $elev=10; }

			 if ($ii>17) { $kcolor="style=\"background-color:#F0E87D; color:#FF0000;\""; }
			$bukets_prise[$v]=round(($bukets_prise[$v]/2),2);
			*/

			echo "<option value=\"$v\" ".$kcolor." >$k ( $bukets_prise[$v] ���.) - ����� �������</option>";
			}
		echo "  </select> <input type=submit name=giveelka value='�������'></td>";
}

if ($NY_BOXS==1)
     {
	echo "<td><form method=post action=\"dealer.php\"><b>������� �����</b><br>�����: <input type='text' name='larlog' value=''> ";

	//������� ����� ������� ��������
	$get_all_boxes=mysql_query("select box_type , count(id) as kol from oldbk.boxs where item_id=0 group by box_type");
	 while($bbo=mysql_fetch_array($get_all_boxes))
                {
	                 if ($bbo[box_type]==1)
	                 	{
	                 	$lar_box_kol[2014001]=$bbo[kol];
	                 	}
	                 elseif ($bbo[box_type]==2)
	                 	{
	                 	$lar_box_kol[2014002]=$bbo[kol];
	                 	}
	                 elseif ($bbo[box_type]==3)
	                 	{
	                 	$lar_box_kol[2014003]=$bbo[kol];
	                 	}
	                 elseif ($bbo[box_type]==4)
	                 	{
	                 	$lar_box_kol[2014004]=$bbo[kol];
	                 	}
               }


	echo "<select name=lartid>";
		$ii=0;
		foreach ($lar_box as $k=>$v)
			{
			$ii++;
			if ($lar_box_kol[$v]>0) { echo "<option value=\"$v\" >$k ( $lar_box_prise[$v] ���.) ��������: $lar_box_kol[$v]</option>"; }
			}
		echo "  </select> ";
		echo " ���. <input type='text' name='larkol' value='1' size=6> ";

		echo "<input type=submit name=givelar value='�������'></td>";
    }


	echo "</tr><tr>";

if ($F_BOXS==1)
     {
	echo "<td><form method=post action=\"\"><b>������� ���������� ��� 2014</b><br>�����: <input type='text' name='flog' value=''> ";
	echo "<input type=submit name=givef value='������� �� 5 ���.'></td></form>";

	echo "<td><form method=post action=\"\"><b>������� ���� ������</b><br>�����: <input type='text' name='flog' value=''> ";
	echo "<input type=submit name=giveflag value='������� �� 1 ���. ������ ����'><br>";
	echo "<table>";
	echo "<tr><td>";
	$iii=0;
	$load_flags= mysql_query("select id, name from eshop where id>=171171 and id<=171202 order by NAME");
	while($ff=mysql_fetch_array($load_flags))
			{
			$iii++;
			echo  "<input type=\"checkbox\" name=\"flagid[]\" value=\"".$ff['id']."\" >".$ff['name']."<br>";
			if ($iii==16)
				{
				echo "</td><td>";
				}
			}
		echo " </td></tr> </table> ";

	echo "</td>";
    }
if ($T_BOXS==1)
     {
	echo "<td><form method=post action=\"\"><b>������� ������������ �����</b><br>�����: <input type='text' name='tlog' value=''> ";
	echo "<input type=submit name=givet value='������� �� 5 ���.'></td></form>";
	echo "</td>";

	echo "<td><form method=post action=\"\"><b>������� ������������ ����-������</b><br>�����: <input type='text' name='tlog' value=''> ";
	echo "<input type=submit name=giveday value='������� �� 1 ���. ������ '><br>";
	echo "<table>";
	echo "<tr><td>";
	$iii=0;
	$load_flags= mysql_query("select id, name from eshop where id>=180001 and id<=180007 order by id");
	while($ff=mysql_fetch_array($load_flags))
			{
			$iii++;
			echo  "<input type=\"checkbox\" name=\"tdayid[]\" value=\"".$ff['id']."\" >".$ff['name']."<br>";
			if ($iii==16)
				{
				echo "</td><td>";
				}
			}
		echo " </td></tr> </table> ";

	echo "</td>";
    }

	/*
	echo "<td><form method=post action=\"\"><b>������� ���� �������</b><br>�����: <input type='text' name='ctlog' value=''> ���-�� <input type='text' name='ctcount' value='1'>";
	echo "<input type=submit name=givect value='������� �� 1 ���.'></td></form>";
	echo "</td>";
	*/

     echo "</tr><tr>";

if ($SV_BOXS == 1) {
	echo "<td><form method=post action=\"\"><b>������� ��������� ��������</b><br>�����: <input type='text' name='svlog' value=''> ���-�� <input type='text' name='svcount' value='1'>";
	echo "<input type=submit name=givesv value='������� �� 1$.'></td></form>";
	echo "</td>";

     	echo "</tr><tr>";
}

if ($CAT == 1) {
	echo "<td>
	<form method=post action=\"\"><b>���� � ����� <small>�� 5��� </small></b><br>�����: <input type='text' name='catlog' value=''> ���-�� <input type='text' name='catcount' value='1' size=7>";
	echo "<input type=submit name=givecat value='�������'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";
}

if ($IMPR==1)
	{
	echo "<td>
	<form method=post action=\"\"><b>C����� ��������� ��������� III� <small>�� 15��� </small></b><br>�����: <input type='text' name='bigchlog' value=''> ���-�� <input type='text' name='bigchcount' value='1' size=7>";
	echo "<input type=submit name=givebigch value='�������'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";

	echo "<td><form method=post action=\"\"><b>������� ������� ���������</b><br>�����: <input type='text' name='artuplog' value=''> ";
	echo "<select name=artupid>";
		foreach ($artup_name as $k=>$v)
			{
			 echo "<option value=\"$k\" >$v ( $artup_prise[$k] ���.)</option>";
			}
		echo "  </select> ";
		echo "<input type='text' name='artupkol' value='1'> ";
		echo "<input type=submit name=giveartup value='�������'></td>";
     	echo "</tr><tr>";
	}


if ($EURO2016 == 1) {
	echo "<td>
	<form method=post action=\"\"><b>���� �����-2016� <small>�� 5��� </small></b><br>�����: <input type='text' name='eurolog' value=''> ���-�� <input type='text' name='eurocount' value='1' size=7>";
	echo "<input type=submit name=giveeuro value='�������'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";

	echo "<td>
	<form method=post action=\"\"><b>����� �����-2016� <small>�� 2��� </small></b><br>�����: <input type='text' name='eurolog' value=''> ���-�� <input type='text' name='eurocount' value='1' size=7>";
	echo "<input type=submit name=giveeuroflag value='�������'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";
}

if ($GVICT==1) {
	echo "<td>
	<form method=post action=\"\"><b>������ ������� ����� <small>�� 50��� </small></b><br>�����: <input type='text' name='viclog' value=''> ���-�� <input type='text' name='viccount' value='1' size=7>";
	echo "<input type=submit name=givevic value='�������'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";
}

if ($LORD == 1) {
	echo "<td>
	<script>
	function callclord(kol)
	{
		if (kol<25)
			{
			document.getElementById('lordcost').value=(3*kol);
			}
			else
			{
			document.getElementById('lordcost').value=(2*kol);
			}
	}
	</script>
	<form method=post action=\"\"><b>������� � ����� ����������� <small>�� 3���, �� 25 ��. �� 2���</small></b><br>�����: <input type='text' name='lordlog' value=''> ���-�� <input type='text' name='lordcount' value='1' size=7 onChange='javascript: callclord(this.value)';  onkeyup=\"this.value=this.value.replace(/[^\d]/,''); callclord(this.value);\"> ��������� <input type='text' id='lordcost' name='lordcost' value='3' readonly=\"readonly\" size=7>";
	echo "<input type=submit name=givelord value='�������'></td></form>";
	echo "</td>";

     	echo "</tr><tr>";
}

if ($LORD_BOX == 1) {
	echo "<td><form method=post action=\"\"><b>�������  ������ �����</b><br>�����: <input type='text' name='lbxlog' value=''> ���-�� <input type='text' name='lbxcount' value='1'>";
	echo "<input type=submit name=givelordbox value='������� �� 5$.'></td></form>";
	echo "</td>";

     	echo "</tr><tr>";

}


if ($EXPRUNS==1)
	{
	echo "<td><form method=post action=\"dealer.php\"><b>������� ������ ����</b><br>�����: <input type='text' name='ruexplog' value=''> ";
	echo "<select name=ruexpid>";
		foreach ($exprun_name as $k=>$v)
			{
			 echo "<option value=\"$k\" >$v ( $exprun_prise[$k] ���.)</option>";
			}
		echo "  </select> ";
		echo "<input type='text' name='ruexpkol' value='1'> ";
		echo "<input type=submit name=giveruexp value='�������'></td>";

     	echo "</tr><tr>";
	}


if ($YARM == 1) {

	if ((time()>$KO_start_time28) and (time()<$KO_fin_time28))
	{
	/* �� ������� */
	echo "<td>
	<form method=post action=\"\"><b>������� ������� </b><br>�����: <input type='text' name='yarmlog' value=''> ���-��
	<select name='yarmcount'>
					<option value='100'>100 ����� = 5$</option>
					<option value='500'>500 ����� (-10% ������) = 22,5$</option>
					<option value='1000'>1000 ����� (-30% ������) = 35$</option>
	</select>";
	echo "<input type=submit name=giveyarm value='�������'>";
	echo "<input type=hidden name=actionon value='true'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";
	}
     	else
     	{
	echo "<td>";
	echo "<form method=post action=\"\"><b>������� ������� </b><br>";
	echo "�����: <input type='text' name='yarmlog' value=''> ";
	 if ($user['id']==14897)
	 	{
		echo "<br>����.�������� �� login(login1;login2;login3): <br><textarea rows=10 cols=45 name='yarmlogins' ></textarea><br>";
		}
	echo "���-�� <input type='text' name='yarmcount' id='yarmcount'  value='20' onkeyup=\"document.getElementById('yarmcost').value=(this.value*0.05).toFixed(2);\">  �����:<input type='text' name='yarmcost' id='yarmcost' value='1' size=10 onkeyup=\"document.getElementById('yarmcount').value=Math.floor(this.value/0.05);\"> ���. <br> ���. 20 ��.";
	echo "<input type=submit name=giveyarm value='�������'>";
	echo "<input type=hidden name=actionon value='false'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";
     	}
}

	echo "<td>
	<form method=post action=\"\"><b>������� ����������� ������</b><br>�����: <input type='text' name='travmlog' value=''>   �����:1 ���.";
	echo "<input type=submit name=travmok value='��������'></td></form>";
	echo "</td>";
     	echo "</tr><tr>";

if ($SMAGIC == 1) {
	echo "<td><form method=post action=\"\"><b>������� ������ ������</b><br>�����: <input type='text' name='svlog' value=''> ���-�� <input type='text' name='svcount' value='1'>";
	echo "<input type=submit name=givesmagic value='������� �� 5$.'></td></form>";
	echo "</td>";

     	echo "</tr><tr>";

}

if ($APRIL_BOXS==1)
     {
	echo "<td><form method=post action=\"dealer.php\"><b>������� ����</b><br>�����: <input type='text' name='egglog' value=''> ";

	echo "<select name=eggid>";
		$ii=0;
		foreach ($egg_box as $k=>$v)
			{
			 echo "<option value=\"$v\" >$k ( $egg_box_prise[$v] ���.)</option>";
			}
		echo "  </select> ";
		echo " ���. <input type='text' name='eggkol' value='1' size=6> ";
		echo "<input type=submit name=giveegg value='�������'></td>";
    }

if ($BUKET==1)
     {
	echo "<td><form method=post action=\"dealer.php\"><b>������� �����</b><br>�����: <input type='text' name='bukelog' value=''> ";

	echo "<select name=bukeid>";
		$ii=0;
		foreach ($leto_bukets as $k=>$v)
			{
			 echo "<option value=\"$v\" >$k ( $leto_bukets_prise[$v] ���.)</option>";
			}
		echo "  </select> ";
		echo "<input type=submit name=givebuke value='�������'></td>";
    }


	echo "</tr><tr>";
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//if ($user['id'] == 8540)
{
   if  (  ( ((int)($_POST['klan_kazna']) > 0)  AND ((int)($_POST['klan_kazna_ekr'])>0)  ) OR
   	 ( ($_POST['klan_kazna']) AND ($XML_OUT)  AND ((int)($_POST['klan_kazna_ekr'])>0) ) )
         {
         	if ($XML_OUT)
         		{
		          $test_klan_name=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '".mysql_real_escape_string($_POST['klan_kazna'])."' LIMIT 1;"));
         			if ($test_klan_name[id]>0)
         			{
         			$_POST['klan_kazna']=$test_klan_name[id];
         			}
         			else
         			{
         			echo "<answer code='81'>����� ���� �� ����������!</answer>";
				unset($_SESSION);
				session_destroy();
         			die("</message>");
         			}
         		}

	    $klan_kazna_ekr=round((floatval($_POST[klan_kazna_ekr])),2);
	    $klan_kazna=(int)($_POST['klan_kazna']);
	    if ($balans['sumekr'] >= $klan_kazna_ekr)
	     {
	     if ($XML_OUT) { echo "<msgclankazna>" ; }
	      $kkazna=clan_kazna_have($klan_kazna);
	       if ($kkazna)
	         {
		  if ($XML_OUT) { echo "YES</msgclankazna>" ; }
	          $klan_name=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `id` = '{$klan_kazna}' LIMIT 1;"));
	          //������ �� ���������� ���� �����
				if ((time()>$KO_start_time) and (time()<$KO_fin_time))
				{
				$add_klan_kazna_ekr=round(($klan_kazna_ekr*(1+$KO_A_BONUS)) ,2); //+10%
				$ko_bonus=$add_klan_kazna_ekr-$klan_kazna_ekr; // ��� ������ � ������
				}
				else
				{
				$add_klan_kazna_ekr=$klan_kazna_ekr;
				}
		   if ($XML_OUT) { echo "<msgclankaznaput>" ; }
		   if (put_to_kazna($klan_kazna,2,$add_klan_kazna_ekr,$klan_name[short]))
		      {
			if ($XML_OUT) { echo "YES</msgclankaznaput>" ; }

		      $fc_nom=100000000+$klan_kazna;
		      $fc_name='����-�����:�'.$klan_name[short].'�';
		      		if ($bot && $botlogin) {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values
					('{$_SESSION['uid']}','{$botfull}','{$fc_nom}','{$fc_name}','{$klan_kazna_ekr}','0');");

					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values
					('{$user['id']}','{$user['login']}','{$fc_nom}','{$fc_name}','{$klan_kazna_ekr}','0');");
				}
				else {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values
					('{$user['id']}','{$user['login']}','{$fc_nom}','{$fc_name}','{$klan_kazna_ekr}','0');");
				}

      		      //��� ������ ���� ����������� ������ ��� �������� ��������
		      mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'".$klan_kazna_ekr."' WHERE `owner` = '{$user['id']}' LIMIT 1;");


			if ($XML_OUT)
					{
					echo "<answer code='0' type='8' ekr='{$klan_kazna_ekr}'  target='{$fc_name}' >������� ��������� ����� �����!</answer>";
					}
					else
					{
					//err($fc_name." ������� ���������");
					}

			if ($ko_bonus > 0)
				{
				mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr) values (450,'KO','{$fc_nom}','{$fc_name}','{$ko_bonus}');");
							if ($XML_OUT)
							{
							echo "<answer code='0' type='8' ekr='{$ko_bonus}'  target='{$fc_name}' addinf='bonus' >������� �������� �����!</answer>";
							}
							else
							{
							err("+ �������� �����!");
							}

				}




		      }
		      	else
		      	{

		      		if ($XML_OUT)
		      			{
		      			echo "</msgclankaznaput>" ;
			      		echo "<answer code='86'>������. ���������� ���� �����!</answer>";
			      		}

		      	}
	         }
	         else
	         {

	         	     			if ($XML_OUT)
							{
							echo "</msgclankazna>" ;
							echo "<answer code='87'>� ����� ����� ���� ��� �������� �����!</answer>";
							}
							else
							{
							err("� ����� ����� ���� ��� �������� �����!");
							}
	         }
	     }
	     else
	     {
	     			if ($XML_OUT)
							{
							echo "<answer code='88'>������������ ������ �� �������!</answer>";
							}
							else
							{
							err("������������ �����. ��������� ���� ������!");
							}
	     }

         }
}

if (!($XML_OUT))
{
	//if ($user['id'] == 8540)
	{
	echo "<td><form method=post><b>��������� ���� �����</b><br>";
	echo "<select size='1' name='klan_kazna'>
 	      <option value=0>�������� ����</option>";
                $sql_klan=mysql_query("SELECT cl.id, cl.short FROM oldbk.clans cl LEFT JOIN oldbk.clans_kazna ka ON cl.id=ka.clan_id where ka.clan_id>0 order by cl.short;");
                while($kl=mysql_fetch_array($sql_klan))
                {
                echo "<option value=".$kl[id]." ".($kl[id]== $_POST[klan_kazna] ? "selected" : "")."  >".$kl[short]."</option>";
                }
	echo "</select>";
	echo " ������� �����:<input type='text' name='klan_kazna_ekr' value='' >";
	echo " <input type=submit name=add_kazna value='���������'></td>";
	}


if ($ARTOK==1)
     {
	echo "<td><form method=post action=\"dealer.php\"><b>������� ����</b><br>
		�����: <input type='text' name='artlog' value=''> ";
	echo "<select name=artid>";
		$ii=0;
		foreach ($artifakts as $k=>$v)
			{
			$ii++;
			echo "<option value=\"$v\" >$k ( $artifakts_prise[$v] ���.)</option>";
			}
		echo "  </select> <input type=submit name=givearts value='�������'></td>";
    }



	if ($VALENT==1)
	     {
		echo "<td><form method=post action=\"dealer.php\"><b>������� ����� ����������</b><br>
		�����: <input type='text' name='vallog' value=''> ���.<input type=text name=vkol size=5 value=1> <br>";
		echo "<select name=valprice >";
		$ii=0;
		foreach ($valentinka as $k=>$v)
			{
			$ii++;
			echo "<option value=\"$v\" >$k (1 ���.)</option>";
			}
		echo "  </select> <input type=submit name=valprod value='�������'></td>";
	    }

	if ($VALENT_2015==1)
	     {
		echo "<td><form method=post><b>������� ����-����������</b><br>
		�����: <input type='text' name='vallog' value=''> ���.<input type=text name=vkol size=5 value=1> <br>";
		echo "  <input type=submit name=valprod2015 value='�������'></td>";
	    }


	if ($ART_BILL==1)
     	{
	echo "</tr>
		<tr><td><form method=post action=\"dealer.php\"><b>�������� ���� �� ������� ����� ��� ����� � ������������ ����� (������:�SC10000000)</b><br>
		����� �����: <input type='text' name='art_bill_nom' value=''>
		�����: <input type='text' name='art_bill_sum' value=''> ";
	echo "  </select> <input type=submit name=art_bill_pay value='��������'></td>";
    	}

	if ($POD==1)
	     {
		echo "<td><form method=post action=\"dealer.php\"><b>������� ���������� ����������</b><br>
		�����: <input type='text' name='podlog' value=''> &nbsp;����: <input type='text' name='podbank' value=''><small>(����� - ��� ����� �� ��������� ��� �������)</small><br>";
		echo "<select name=podprice >";
		$ii=0;

	        if (time() >= mktime(0,0,0,2,13,$ny_events_cur_y) && time() <= mktime(23,59,59,2,20,$ny_events_cur_y)) {
			$podar = $podarvl;
		}

	        if (time() >= mktime(0,0,0,2,21,$ny_events_cur_y) && time() <= mktime(23,59,59,3,4,$ny_events_cur_y)) {
			$podar = $podar23;
		}

		/*
	        if (time() >= mktime(0,0,0,3,5,$ny_events_cur_y) && time() <= mktime(23,59,59,3,20,$ny_events_cur_y)) {
			$podar = $podar8;
		}
		*/

		foreach ($podar as $k=>$v)
			{
			$ii++;
			echo "<option value=\"$v\" >$k</option>";
			}
		echo "  </select> <input type=text name=podkol size=5 value=1> <input type=submit name=podotdel value='�������'>";

		if (($user['klan']=='radminion') OR ($user['klan']=='Adminion') )
		{
		echo '<br> <input type="checkbox" checked name="real" value="yes" >�������� ';
		}

		echo "</td>";
	    }



    		echo "</tr></table>";
}

	if ($_POST['checkbank']) {
		if ($_POST['charlogin'])
		{
			$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['charlogin']}' LIMIT 1;"));
			$bankdb = mysql_query("SELECT owner,id FROM oldbk.`bank` WHERE `owner` = '{$tonick['id']}'");

			if (mysql_num_rows($bankdb)>0)
			{
					if ($XML_OUT)
					{
					echo "<answer code='0' type='9'  login='{$tonick[login]}'>��������� ����������� �����!";
					}
					else
					{
					print "��������� {$_POST['charlogin']} ����������� �����: <br>";
					}
				while ($bank=mysql_fetch_array($bankdb))
				{
					if ($XML_OUT)
					{
					echo "<bank id='{$bank['id']}'></bank>";
					}
					else
					{
					print "� {$bank['id']} <br>";
					}
				}
			 }
			 else
			 {
				echo "<answer code='99'>� ��������� ��� ������!";
			 }
			if ($XML_OUT)
				{
				echo "</answer>";
				}
		}
		else if ($_POST['charbank'])
		{
			$id_bank=(int)($_POST['charbank']);
			if ($id_bank>0)
				{
				$bankdb = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = '{$id_bank}'"));
					if ($bankdb[id]>0)
						{
							$get_login= mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '{$bankdb[owner]}'"));
							 if ($get_login[id]>0)
							 {
							  if ($XML_OUT) {  echo "<answer code='0' type='14' bank='{$id_bank}'  login='{$get_login[login]}'>�������!</answer>"; }
							  	else	{ err("����:".$id_bank." -  �����������:<b>".$get_login[login]."</b>"); }
							 }
							 else
							 {
							 if ($XML_OUT) {	echo "<answer code='133'>������ ����� ����� ������ �� �����������!"; }
							 			else
							 			{
							 			err("������ ����� ����� ������ �� �����������!");
							 			}
							 }
						}
						else
						{
						if ($XML_OUT) {	echo "<answer code='132'>������ ����� ����� �� ������!"; }
									else
									{
									err("������ ����� ����� �� ������!");
									}
						}
				}
				else
				{
					if ($XML_OUT) {	echo "<answer code='131'>������ ������ �����!"; }
					else
					{
					err("������ ������ �����!");
					}
				}



		}

	}


if (!($XML_OUT))
{
//echo "<hr>";
/*
   if (($user[id]==124836) or ($user[id]==14897)  ) // ������ �������
   {
   $price=1100; // ���
   echo '<hr><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="5%" rowspan="2">&nbsp;</td><td width="95%">';
   if (($_POST['bil_send_ukr']) and ($_POST[bil_nick]) and ($_POST[bil_fio]) )
     	{
     	$nick=mysql_real_escape_string($_POST[bil_nick]);
     	$fio=mysql_real_escape_string($_POST[bil_fio]);

	if ( ($user[id]==14897) OR ($user[id]==8540) )
	{
     	if ($_POST[bil_vip]) {$vip=1; } else {$vip=0;}
     	}
     	else {$vip=0;}


	//���� ���.�������
	$last_bil_id=mysql_fetch_array(mysql_query("select id from bilet_ukr ORDER by id desc limit 1;"));

	if ($last_bil_id[id]<=100)
	{
     	$targ=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$nick}' LIMIT 1;"));
     	if ($targ[id_city]==1)
				{
				$tonick = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE `login` = '{$_POST['tonick']}' LIMIT 1;"));
				}
     	 if (($targ[id] > 0) and ($targ[align] !=4) and ($targ[block] ==0) )
     	  {
     	  $ttdate=date("Y-m-d H:i:s",time());

 	    	if ($new_ins_id)
 	    	{
	    	mysql_query("INSERT INTO `oldbk`.`bilet_ukr` SET id='{$new_ins_id}'  , `selname`='{$user[login]}',`owner_nick`='{$targ[login]}',`owner`='{$targ[id]}',`fio`='{$fio}',`vip`='{$vip}',`price`='{$price}',`sdate`='{$ttdate}';");
 	    	}
 	    	else
 	    	{
 	    	mysql_query("INSERT INTO `oldbk`.`bilet_ukr` SET `selname`='{$user[login]}',`owner_nick`='{$targ[login]}',`owner`='{$targ[id]}',`fio`='{$fio}',`vip`='{$vip}',`price`='{$price}',`sdate`='{$ttdate}';");
 	    	}


	 	if (mysql_affected_rows()>0)
 	    	 {
 	    	 $bil_id=mysql_insert_id();
 	    	 echo "<b>����� ����� �$bil_id ".(($vip>0)?"VIP":"")."  (�������) </b><br>";
 	    	 echo " ����� �����:$nick <br>";
 	    	 echo " �� ���:$fio <br>";
 	    	 echo " ��������� ������:$price";


		$bil_name="".(($vip>0)?"VIP":"")." ����� �$bil_id �� 6-����� �����!  (�������)";

	        $bil_text="<b>".$bil_name."</b><br><b>23.01.2016</b>  � <b>18:00</b>,<br> �������� <b>\"����� �������\"</b> (����, ��.������ �������, �.3). ������� ����� \"�������\"...<br>������ ������� {$user[login]} ��������� {$targ[login]} �� ��� {$fio} �� ���� {$price} ������.<br><i>� ���������, ������������� �����</i>";
		 mysql_query("INSERT INTO oldbk.`inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`,`present`,  `prototype`)VALUES('{$targ[id]}','{$bil_name}','50',0,0,'6year_ukr.gif','{$bil_text}',1,0,'������������� �����', 1236) ;");

 	    	 //��������
 	    	 if ($targ['odate'] > (time()-60))
					{
						addchp('<font color=red>��������!</font> ��� ������� <b>��������������� ����� �� 6-����� ����� (�������)</b> �� ������ '.$user['login'].'  ','{[]}'.$targ['login'].'{[]}',$targ['room'],$targ['id_city']);
					} else
					{
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$targ['id']."','','".'<font color=red>��������!</font> ��� ������� <b>��������������� ����� �� 6-� ����� ����� (�������)</b> �� ������ '.$user['login'].'  '."');");
					}
 	    	 }

 	  }
 	  else
 	  {
 	  err("����� �������� �� ������ ��� � �����/�����!");
 	  }
	}
	else
 	  {
 	  err("������� ������ ��� :( ");
 	  }

     	}

     	echo "</td></tr><tr><td>";
    	echo "<h4>������� ������� �� 6-����� ����� (�������)</h4>";
    	echo "<form method='post' >";
    	echo "��� ���������:<input type=text name=bil_nick> <br>";
    	echo "���:<input type=text name=bil_fio size=35> <br>";

    	 if ( ($user[id]==14897) OR ($user[id]==8540) )
    	{
    	//echo "Vip-Admin ����� <input type=checkbox name=bil_vip> <br>";
    	}
//    	echo "��������� ������:<input type=text name=bil_price size=16> <br>";
  	echo "��������� ������:".$price." ���. <br>";
    	echo "<input type=submit name=bil_send_ukr value='���������'>";
    	echo "</form>";
     	echo '</td> </tr></table>';
	echo "<hr>";
}
*/
/////////////////////////////////////////////////////////////

  if (($user[id]==14897) OR ($user[id]==8540) )
    {

   echo '<hr><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="5%" rowspan="2">&nbsp;</td><td width="95%">';
   if (($_POST[bil_send]) and ($_POST[bil_nick])  )
     	{
     	$nick=mysql_real_escape_string($_POST[bil_nick]);
     	//$fio=mysql_real_escape_string($_POST[bil_fio]);
     	$fio='';
     	$vip=0;
     	$_POST[bil_fsize]=(int)($_POST[bil_fsize]);

	if ($_POST['bil_fsize']==0)
		{
		   $price=65;
		   $fsize="";
		}
	else	{
		   $price=70;
		   $ss=array(1=>"S",2=>"M",3=>"L",4=>"XL",5=>"XXL");
		   $fsize=$ss[$_POST['bil_fsize']];
		}

	//���� ���.�������
	$last_bil_id=mysql_fetch_array(mysql_query("select id from bilet ORDER by id desc limit 1;"));

	if ($last_bil_id[id]<70)
	{
     	$targ=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$nick}' LIMIT 1;"));

     	 if (($targ[id] > 0) and ($targ[align] !=4) and ($targ[block] ==0) )
     	  {
		echo get_buy_bilet($targ,$fsize,$price,$user['login']);
 	  }
 	  else
 	  {
 	  err("����� �������� �� ������ ��� � �����/�����!");
 	  }
	}
	else
 	  {
 	  err("������� ������ ��� :( ");
 	  }

     	}

     	echo "</td></tr><tr><td>";
    	echo "<h4>������� ������� �� 8-����� �����</h4>";
    	echo "<form method='post' >";
    	echo "��� ���������:<input type=text name=bil_nick> <br>";
    	//echo "���:<input type=text name=bil_fio size=35> <br>";

	echo '�������� ������ ��������: <select name="bil_fsize">';
	echo '<option value="0" selected> ��� �������� (65$) </option>';
	echo '<option value="1" selected> S (70$)</option>';
	echo '<option value="2"> M (70$)</option>';
	echo '<option value="3"> L (70$)</option>';
	echo '<option value="4"> XL (70$)</option>';
	echo '<option value="5"> XXL (70$)</option>';
	echo "</select> <br>";

  	//echo "��������� ������:".$price." $. <br>";
    	echo "<input type=submit name=bil_send value='���������'>";
    	echo "</form>";
     	echo '</td> </tr></table>';
	echo "<hr>";
}


    }





if (!($XML_OUT))
{
//������� ��� -����������

	if (!$_POST['dlogs']) {$_POST['dlogs']=date("d.m.y");}
	if (!$_POST['dlogs1']) {$_POST['dlogs1']=date("d.m.y");}
	if ($user['id'] == '326' || $user['id'] == 8540 || $user['id'] == 14897 || $user[id]==28453 || $user[id]==102904) {
		echo '<TABLE><TR><TD><FORM METHOD=POST ACTION="">
			����������� ��������� �������� ���������: <INPUT TYPE=text NAME=dfilter value="'.$_POST['dfilter'].'"> � <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> �� <INPUT TYPE=text NAME=dlogs1 size=12 value="'.$_POST['dlogs1'].'"> <input type=checkbox name=sumall class=input> ����� �� ���� ������� <INPUT TYPE=submit value="�����������!"> </form></TD>
			</tr><tr>
			<TD valign=top align=center>��������� �������� ��������� <b>"'.$_POST['dfilter'].'"</b> � <b>'.$_POST['dlogs'].'</b> �� <b>'.$_POST['dlogs1'].'</b></TD>
			</TR></TABLE></form>';
	}
	elseif ($user['deal']==1) {
		if ($bot) {
		$user['login']=$bot_login;
		$user['id']=$bot_id;
		}
		echo '<TABLE><TR><TD><FORM METHOD=POST ACTION="">
			����������� ��������� �������� <INPUT TYPE=hidden NAME=dfilter value="'.$user['login'].'">� <INPUT TYPE=text NAME=dlogs size=12 value="'.$_POST['dlogs'].'"> �� <INPUT TYPE=text NAME=dlogs1 size=12 value="'.$_POST['dlogs1'].'"> <INPUT TYPE=submit value="�����������!"></form></TD>
			</tr><tr>
			<TD valign=top align=center>��������� �������� ��������� <b>"'.$_POST['dfilter'].'"</b> � <b>'.$_POST['dlogs'].'</b> �� <b>'.$_POST['dlogs1'].'</b> </TD>
			</TR></TABLE></form>';
	}


	if (($_POST['dfilter'] && !$_POST['sumall']) )  {

	 if (($user['id'] != '326' AND $user['id'] != 8540 AND $user['id'] != 14897 AND $user[id]!=28453)) { $_POST['dfilter']=$user[login] ; }
	// if ($_POST['dfilter'] == '������') {$_POST['dfilter']='����������';}

		$perevod1 = mysql_fetch_array(mysql_query("SELECT `login`,`id`,`align` FROM oldbk.`users` WHERE `login` = '{$_POST['dfilter']}' LIMIT 1;"));
		$aa=$perevod1['id'];

		$logsat=$_POST['dlogs'];
		$ddate33="20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."";
		$ddate44="20".substr($_POST['dlogs1'],6,2)."-".substr($_POST['dlogs1'],3,2)."-".substr($_POST['dlogs1'],0,2)."";
		$startdlogs = mysql_fetch_array(mysql_query("SELECT id FROM oldbk.`dilerdelo` WHERE `date` like '$ddate33%' ORDER by `id` ASC LIMIT 1;"));
		$enddlogs = mysql_fetch_array(mysql_query("SELECT id FROM oldbk.`dilerdelo` WHERE `date` like '$ddate44%' ORDER by `id` DESC LIMIT 1;"));

		echo "start id:".$startdlogs['id']." end id:".$enddlogs['id']."<br>" ;

		$dlogs = mysql_query("SELECT * FROM oldbk.`dilerdelo` WHERE `dilerid` = '{$perevod1['id']}' AND `id` >= '{$startdlogs['id']}' AND `id` <= '{$enddlogs['id']}' ORDER by `id` ASC;");
		$ekrsum=0;
		while($row = @mysql_fetch_array($dlogs)) {

		$row['date']= date("d-m-Y H:i:s",strtotime($row['date']));

			switch($row['addition']) {
				case "2":
					$sklo="�����������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3":
					$sklo="������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "6":
					$sklo="�������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "5":
					echo "<span class=date>{$row['date']}</span> ������ ������ {$row['ekr']} ���. ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "55":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ���������� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "555":
					echo "<span class=date>{$row['date']}</span> ������� �����-���������� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "100199":
					echo "<span class=date>{$row['date']}</span> ������ ������ ������ �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;


				case "2018":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� (��� �����)  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2118":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2218":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2318":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2418":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;


				case "1200001":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� I�  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200002":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� II� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200003":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� III� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200004":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� IV� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200005":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� V� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200006":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� VI� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "1001":
					echo "<span class=date>{$row['date']}</span> ������� ����������� ������  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "56664":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� III�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016614":
					echo "<span class=date>{$row['date']}</span> ������  ��� �����-2016�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016615":
					echo "<span class=date>{$row['date']}</span> ������  ���� �����-2016�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "14200":
					echo "<span class=date>{$row['date']}</span> ������  ������ ������� �����  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "3001005":
					echo "<span class=date>{$row['date']}</span> ������ ������ ����� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410021":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������ ������ (6) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410022":
					echo "<span class=date>{$row['date']}</span> ������ ����� ����������� ������ (9) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410023":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������������� ����� (12) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410024":
					echo "<span class=date>{$row['date']}</span> ������ ����� ���������� �������� (10) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410025":
					echo "<span class=date>{$row['date']}</span> ������ ����� �������� ����� (11) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410026":
					echo "<span class=date>{$row['date']}</span> ������ ����� �������� ����� (13) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "66":
					echo "<span class=date>{$row['date']}</span> ������� ������ ����� ��� ��������� {$row['owner']} (100 ���.) , ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+100;
					break;
				case "2011":
					echo "<span class=date>{$row['date']}</span> ������� ���������� ���� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2013":
					echo "<span class=date>{$row['date']}</span> ������ ����� ��������� {$row['owner']} �� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014":
					echo "<span class=date>{$row['date']}</span> ������� ���� ��������� {$row['owner']} �� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2000":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���������� �����  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "300":
					echo "<span class=date>{$row['date']}</span> ������� ��������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "283":
					echo "<span class=date>{$row['date']}</span> ������� ������� ������ �������� ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "284":
					echo "<span class=date>{$row['date']}</span> ������ ������� ����� �������� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "33333":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ����� �����  ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "260":
					echo "<span class=date>{$row['date']}</span>������  ������ ���������� �����  ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "262":
					echo "<span class=date>{$row['date']}</span>������� ���� �������� ����� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "18210":
					echo "<span class=date>{$row['date']}</span>������� ������ ������ ������ ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18229":
					echo "<span class=date>{$row['date']}</span>������� ������ �������� ������ ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18247":
					echo "<span class=date>{$row['date']}</span>������� ��� ���������� ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18527":
					echo "<span class=date>{$row['date']}</span>������� ������� ��� ���� ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "2001":
					echo "<span class=date>{$row['date']}</span> ������ ��� �������� �����  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "100029":
					echo "<span class=date>{$row['date']}</span> ������ �������� �������� (��)  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "7002":
					echo "<span class=date>{$row['date']}</span> ������ ���� ����� (��)  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2002":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������ �������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2003":
					echo "<span class=date>{$row['date']}</span> ������ ������ ��������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "0":
					if ($row['bank']>100000000)
					{
					echo "<span class=date>{$row['date']}</span> ���������� {$row['ekr']} ���. {$row['owner']} (���� �{$row['bank']}) , ������� {$row['dilername']}<br>";
					}
					else
					{
					echo "<span class=date>{$row['date']}</span> ���������� {$row['ekr']} ���. ���������  {$row['owner']} (���� �{$row['bank']}) , ������� {$row['dilername']}<br>";
					}

					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "7":
					echo "<span class=date>{$row['date']}</span> ������ Silver account ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "17":
					echo "<span class=date>{$row['date']}</span> ������ Gold account ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "117":
					echo "<span class=date>{$row['date']}</span> ������ Platinum account ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "77":
					echo "<span class=date>{$row['date']}</span> ������� ���� �� ������� ���������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "777":
					echo "<span class=date>{$row['date']}</span> ������� ���� � ������������ ����� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "584":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 5000 {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "585":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 10000 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "586":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 15000 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2014100":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ��� 2014 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014101":
					echo "<span class=date>{$row['date']}</span> ������ ���� ������ 2014 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014102":
					echo "<span class=date>{$row['date']}</span> ������ ������������ ����-������ ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014103":
					echo "<span class=date>{$row['date']}</span> ������� ������������ ����� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3001003":
					echo "<span class=date>{$row['date']}</span> ������� ���� ������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3006000":
					echo "<span class=date>{$row['date']}</span> ������� �������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "4016":
					echo "<span class=date>{$row['date']}</span> ������ ������� � ����� ����������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2016401":
					echo "<span class=date>{$row['date']}</span> ������ ��� � ����� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016001":
					echo "<span class=date>{$row['date']}</span> ������� ����, ���������  {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;


				case "3003060":
					echo "<span class=date>{$row['date']}</span> ������� ".round($row['ekr']/$gcost)." ������� ����� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
			}
				if ( ($row['dilerid']==8383) and ($row['paysyst']!=''))
				{
					$syst=$row['paysyst'];
					$sum_by_merch[$syst]+=$row['ekr'];
				}
				elseif ( $row['dilerid']==8383)
				{
				$sum_by_merch['other']+=$row['ekr'];
				}
		}
		echo "============================================================";
		$ekrsum=round($ekrsum,2);
		echo "<br>����� �� �����: <b>$ekrsum</b> ���. wmz:".$sum_by_merch['wmz']."/wmr:".$sum_by_merch['wmr']."/paypal:".$sum_by_merch['paypal']."/liqpay:".$sum_by_merch['liqpay']."/other:".$sum_by_merch['other'];

		//print_r($sum_by_merch);
	}
	elseif ((!$_POST['dfilter'] && $_POST['sumall']) and ($user['id'] == '326' || $user['id'] == 8540 || $user['id'] == 14897 || $user[id]==28453 || $user[id]==102904))   {
		$rr = mysql_query("SELECT `login`,`id`,`align` FROM oldbk.`users` WHERE (`deal` = '1' and `login` NOT LIKE 'auto%' and `id` != '7363') OR `id` = '83' OR id=3154 OR id=8540;");
		$allekrsum=0;
		while ($perevod1=mysql_fetch_array($rr)) {

			$logsat=$_POST['dlogs'];
			$ddate33="20".substr($_POST['dlogs'],6,2)."-".substr($_POST['dlogs'],3,2)."-".substr($_POST['dlogs'],0,2)."";
			$ddate44="20".substr($_POST['dlogs1'],6,2)."-".substr($_POST['dlogs1'],3,2)."-".substr($_POST['dlogs1'],0,2)."";
			$startdlogs = mysql_fetch_array(mysql_query("SELECT id FROM oldbk.`dilerdelo` WHERE `date` like '$ddate33%' ORDER by `id` ASC LIMIT 1;"));
			$enddlogs = mysql_fetch_array(mysql_query("SELECT id FROM oldbk.`dilerdelo` WHERE `date` like '$ddate44%' ORDER by `id` DESC LIMIT 1;"));

			if ($perevod1['id']==8540)
				{
				$dlogs = mysql_query("SELECT * FROM oldbk.`dilerdelo` WHERE `dilerid` = '{$perevod1['id']}' AND `id` >= '{$startdlogs['id']}' AND `id` <= '{$enddlogs['id']}' and b=1 ORDER by `id` ASC;");
				}
				else
				{
				$dlogs = mysql_query("SELECT * FROM oldbk.`dilerdelo` WHERE `dilerid` = '{$perevod1['id']}' AND `id` >= '{$startdlogs['id']}' AND `id` <= '{$enddlogs['id']}' ORDER by `id` ASC;");
				}

			$ekrsum=0;

			while($row = @mysql_fetch_array($dlogs)) {

			if ((($row['klan']=='Adminion') OR ($row['klan']=='radminion'))  and ($perevod1['login']=='����������'))
				{
				continue;
				}

				switch($row['addition']) {
					case "2":
						$ekrsum=$ekrsum+$row['ekr'];;
						break;
					case "3":
						$ekrsum=$ekrsum+$row['ekr'];;
						break;
					case "5":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "55":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "555":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "100199":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "56664":
						$ekrsum=$ekrsum+$row['ekr'];
						break;


					case "2018":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2118":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2218":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2318":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2418":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "1200001":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "1200002":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "1200003":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "1200004":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "1200005":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "1200006":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "1001":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2016614":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2016615":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "14200":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "3001005":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "410021":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "410022":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "410023":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "410024":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "410025":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "410026":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "6":
						$ekrsum=$ekrsum+$row['ekr'];;
						break;
					case "66":
						$ekrsum=$ekrsum+100;
						break;
					case "2011":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2013":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2014":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2000":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "300":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "283":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "284":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "33333":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "260":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "262":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "18210":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "18229":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "18247":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "18527":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2001":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "100029":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "7002":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2002":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2003":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "0":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "7":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "17":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "117":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "77":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "777":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2014100":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "584":
						$ekrsum=$ekrsum+$row['ekr'];
						break;

					case "585":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "586":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2014101":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2014102":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2014103":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "3001003":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "3006000":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
				 	case "4016":
						$ekrsum=$ekrsum+$row['ekr'];
						break;
					case "2016401":
						$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "2016001":
					$ekrsum=$ekrsum+$row['ekr'];
					break;

					case "3003060":
						$ekrsum=$ekrsum+$row['ekr'];
					break;
				}
			}

			//����������� �� � �����
			if ($perevod1['login'] != 'KO')
				{
				$allekrsum=$allekrsum+$ekrsum;
				}

			if ($perevod1['login'] == '����������') {$perevod1['login']='������';}
			if ($perevod1['login']!='����')
			{
			$ekrsum=round($ekrsum,2);

				 if (($perevod1['login']=='������')  OR ($perevod1['login']=='KO') )
				 {
				 $tenka=$ekrsum;
				 }
				 else if($perevod1['login']=='����������')
				 {
				 $tenka=round($ekrsum*0.92);
				 }
				 else
				 {
				$tenka=round($ekrsum*0.9);
				}

				if ($perevod1['login'] != 'KO')
				{
				$allekrtenka=$allekrtenka+$tenka;
				}


			if ($perevod1['login']=='����������')
				{
				echo "<br>����� <b>{$perevod1['login']}</b> - ����� �� ����� <b>$ekrsum</b> ���. <small>(����� -8% <b>$tenka</b> ���.)</small> ";
				}
				else
				{
				echo "<br>����� <b>{$perevod1['login']}</b> - ����� �� ����� <b>$ekrsum</b> ���. <small>(����� -10% <b>$tenka</b> ���.)</small> ";
				}




			}
		}
		echo "<br>============================================================";
		echo "<br>����� �� ����� <b>$allekrsum</b> ���. (��� ��)<br>";
		echo "<br>����� �� ����� � ������ % ��������� <b>$allekrtenka</b> ���. (��� ��)";
	}

	echo "<hr>";

	if (!$_POST['dlogs2']) {$_POST['dlogs2']=date("d.m.y");}
	if (!$_POST['dlogs3']) {$_POST['dlogs3']=date("d.m.y");}

	echo '<TABLE><TR><TD><FORM METHOD=POST ACTION="">
		����������� ������� ����: <INPUT TYPE=text NAME=pfilter value="'.$_POST['pfilter'].'"> � <INPUT TYPE=text NAME=dlogs2 size=12 value="'.$_POST['dlogs2'].'"> �� <INPUT TYPE=text NAME=dlogs3 size=12 value="'.$_POST['dlogs3'].'"> <INPUT TYPE=submit value="�����������!"> </form></TD>
		</tr><tr>
		<TD valign=top align=center>������� ���� <b>"'.$_POST['pfilter'].'"</b> � <b>'.$_POST['dlogs2'].'</b> �� <b>'.$_POST['dlogs3'].'</b></TD>
		</TR></TABLE></form>';

	if ($_POST['pfilter']) {
		$ddate33="20".substr($_POST['dlogs2'],6,2)."-".substr($_POST['dlogs2'],3,2)."-".substr($_POST['dlogs2'],0,2)."";
		$ddate44="20".substr($_POST['dlogs3'],6,2)."-".substr($_POST['dlogs3'],3,2)."-".substr($_POST['dlogs3'],0,2)."";
		$startdlogs = mysql_fetch_array(mysql_query("SELECT id FROM oldbk.`dilerdelo` WHERE `date` like '$ddate33%' ORDER by `id` ASC LIMIT 1;"));
		$enddlogs = mysql_fetch_array(mysql_query("SELECT id FROM oldbk.`dilerdelo` WHERE `date` like '$ddate44%' ORDER by `id` DESC LIMIT 1;"));

		if (($user[id]==14897) OR ($user[id]==8540) OR ($user[id]==326))
		{
		$admsqll='';
		}
		else
		{
		$admsqll=" `dilerid` = '{$user['id']}' AND ";
		}

		$all_niks=get_all_logins($_POST['pfilter']);
		$ekrsum=0;

		if (count($all_niks)>0)
		{
		$dlogs = mysql_query("SELECT * FROM oldbk.`dilerdelo` WHERE {$admsqll} `owner`  in (".implode(",",$all_niks).")  AND `id` >= '{$startdlogs['id']}' AND `id` <= '{$enddlogs['id']}' ORDER by `id` ASC;");

		while($row = @mysql_fetch_array($dlogs)) {
		$row['date']= date("d-m-Y H:i:s",strtotime($row['date']));
			switch($row['addition']) {
				case "2":
					$sklo="�����������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3":
					$sklo="������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "6":
					$sklo="�������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "5":
					echo "<span class=date>{$row['date']}</span> ������ ������ ������������� ������ ��������� {$row['ekr']} ���.  ��� ��������� {$row['owner']}, ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "55":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ���������� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']}  <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "555":
					echo "<span class=date>{$row['date']}</span> ������� �����-���������� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']}  <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "100199":
					echo "<span class=date>{$row['date']}</span> ������ ������ ������ �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "56664":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� III�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2018":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� (��� �����)  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2118":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2218":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2318":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2418":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "1200001":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� I�  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200002":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� II� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200003":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� III� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200004":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� IV� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200005":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� V� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200006":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� VI� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "1001":
					echo "<span class=date>{$row['date']}</span> ������� ����������� ������  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016614":
					echo "<span class=date>{$row['date']}</span> ������  ��� �����-2016�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016615":
					echo "<span class=date>{$row['date']}</span> ������  ���� �����-2016�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "14200":
					echo "<span class=date>{$row['date']}</span> ������  ������ ������� �����  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "3001005":
					echo "<span class=date>{$row['date']}</span> ������ ������ ����� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410021":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������ ������ (6) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410022":
					echo "<span class=date>{$row['date']}</span> ������ ����� ����������� ������ (9) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410023":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������������� ����� (12) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410024":
					echo "<span class=date>{$row['date']}</span> ������ ����� ���������� �������� (10) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410025":
					echo "<span class=date>{$row['date']}</span> ������ ����� �������� ����� (11) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410026":
					echo "<span class=date>{$row['date']}</span> ������ ����� �������� ����� (13) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "7":
					echo "<span class=date>{$row['date']}</span> ������ Silver account ��������� {$row['owner']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "17":
					echo "<span class=date>{$row['date']}</span> ������ Gold account ��������� {$row['owner']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "117":
					echo "<span class=date>{$row['date']}</span> ������ Platinum account ��������� {$row['owner']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "77":
					echo "<span class=date>{$row['date']}</span> ������� ���� �� ������� ���������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "777":
					echo "<span class=date>{$row['date']}</span> ������� ���� � ������������ ����� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "66":
					echo "<span class=date>{$row['date']}</span> ������� ������ ����� ��� ��������� {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+100;
					break;
				case "2011":
					echo "<span class=date>{$row['date']}</span> ������� ���������� ���� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2013":
					echo "<span class=date>{$row['date']}</span> ������ ����� ��������� {$row['owner']} �� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014":
					echo "<span class=date>{$row['date']}</span> ������� ���� ��������� {$row['owner']} �� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2000":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���������� ����� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "300":
					echo "<span class=date>{$row['date']}</span> ������� ��������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "283":
					echo "<span class=date>{$row['date']}</span> ������� ������� ������ ��������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "284":
					echo "<span class=date>{$row['date']}</span> ������ ������� ����� ��������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;


				case "33333":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ����� �����, ��������� {$row['owner']}, ������� {$row['dilername']}, ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "260":
					echo "<span class=date>{$row['date']}</span> ������ ���������� �����  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "262":
					echo "<span class=date>{$row['date']}</span> ���� �������� �����  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "18210":
					echo "<span class=date>{$row['date']}</span>������� ������ ������ ������ ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18229":
					echo "<span class=date>{$row['date']}</span>������� ������ �������� ������ ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18247":
					echo "<span class=date>{$row['date']}</span>������� ��� ���������� ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18527":
					echo "<span class=date>{$row['date']}</span>������� ������� ��� ���� ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "2001":
					echo "<span class=date>{$row['date']}</span> ������ ��� �������� ����� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "100029":
					echo "<span class=date>{$row['date']}</span> ������ �������� �������� (��)  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "7002":
					echo "<span class=date>{$row['date']}</span> ������ ���� ����� (��)  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;


				case "2002":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������ ������� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2003":
					echo "<span class=date>{$row['date']}</span> ������ ������ �������� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "0":
					echo "<span class=date>{$row['date']}</span> ���������� {$row['ekr']} ���. ���������  {$row['owner']} (���� �{$row['bank']}) , ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "7":
					echo "<span class=date>{$row['date']}</span> ������ Silver account ��������� {$row['owner']} ������� {$row['dilername']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "17":
					echo "<span class=date>{$row['date']}</span> ������ Gold account ��������� {$row['owner']} ������� {$row['dilername']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "117":
					echo "<span class=date>{$row['date']}</span> ������ Platinum account ��������� {$row['owner']} ������� {$row['dilername']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "77":
					echo "<span class=date>{$row['date']}</span> ������� ���� �� ������� ���������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "777":
					echo "<span class=date>{$row['date']}</span> ������� ���� � ������������ ����� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "584":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 5000 {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "585":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 10000 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "586":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 15000 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2014100":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ��� 2014 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014101":
					echo "<span class=date>{$row['date']}</span> ������ ���� ������ 2014 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014102":
					echo "<span class=date>{$row['date']}</span> ������ ������������ ����-������ ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014103":
					echo "<span class=date>{$row['date']}</span> ������� ������������ ����� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3001003":
					echo "<span class=date>{$row['date']}</span> ������� ���� ������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3006000":
					echo "<span class=date>{$row['date']}</span> ������� �������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "4016":
					echo "<span class=date>{$row['date']}</span> ������ ������� � ����� ����������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2016401":
					echo "<span class=date>{$row['date']}</span> ������ ��� � ����� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2016001":
					echo "<span class=date>{$row['date']}</span> ������� ����, ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3003060":
					echo "<span class=date>{$row['date']}</span> ������� ".round($row['ekr']/$gcost)." ������� ����� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
			}
		}
		}
		echo "============================================================";
		echo "<br>����� �� ����� <b>$ekrsum</b> ���.";
	}


	echo "<hr>";


	if ($user['id'] == '326' || $user['id'] == 8540 || $user['id'] == 14897 || $user[id]==28453 || $user[id]==102904)
	{
	//�������� ���������

		echo '<TABLE><TR><TD><FORM METHOD=POST ACTION=dealer.php>
		����������� ������� ���� + SMS: <INPUT TYPE=text NAME=pfilter1 value="'.$_POST['pfilter1'].'">  <INPUT TYPE=submit value="�����������!"> </form></TD>
		</tr><tr>
		<TD valign=top align=center>������� ���� <b>"'.$_POST['pfilter1'].'"</b> </TD>
		</TR></TABLE></form>';

	if ($_POST['pfilter1']) {

		$all_niks=get_all_logins($_POST['pfilter1']);

		$dlogs = mysql_query("SELECT * FROM oldbk.`dilerdelo` WHERE `owner`  in (".implode(",",$all_niks).")   and dilername NOT LIKE 'auto%' ORDER by `id` ASC;");
		$ekrsum=0;
		while($row = @mysql_fetch_array($dlogs)) {
		$row['date']= date("d-m-Y H:i:s",strtotime($row['date']));
			switch($row['addition']) {
				case "2":
					$sklo="�����������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3":
					$sklo="������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "6":
					$sklo="�������";
					echo "<span class=date>{$row['date']}</span> ������� {$sklo} ���������� ���������  {$row['owner']} ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "5":
					echo "<span class=date>{$row['date']}</span> ������ ������ ������������� ������ ���������  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "55":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ���������� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "555":
					echo "<span class=date>{$row['date']}</span> ������� �����-���������� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "100199":
					echo "<span class=date>{$row['date']}</span> ������ ������ ������ �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "56664":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� III�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2018":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� (��� �����)  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2118":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2218":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2318":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2418":
					echo "<span class=date>{$row['date']}</span> ������ ����� �� 8� ����� +�����  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "1200001":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� I�  {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200002":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� II� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200003":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� III� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200004":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� IV� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200005":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� V� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "1200006":
					echo "<span class=date>{$row['date']}</span> ������ ������  �������� ��������� ������� ��������� VI� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "1001":
					echo "<span class=date>{$row['date']}</span> ������� ����������� ������  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016614":
					echo "<span class=date>{$row['date']}</span> ������  ��� �����-2016�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016615":
					echo "<span class=date>{$row['date']}</span> ������  ���� �����-2016�  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "14200":
					echo "<span class=date>{$row['date']}</span> ������  ������ ������� �����  �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "3001005":
					echo "<span class=date>{$row['date']}</span> ������ ������ ����� �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410021":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������ ������ (6) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410022":
					echo "<span class=date>{$row['date']}</span> ������ ����� ����������� ������ (9) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410023":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������������� ����� (12) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410024":
					echo "<span class=date>{$row['date']}</span> ������ ����� ���������� �������� (10) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410025":
					echo "<span class=date>{$row['date']}</span> ������ ����� �������� ����� (11) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "410026":
					echo "<span class=date>{$row['date']}</span> ������ ����� �������� ����� (13) �� {$row['ekr']} ���. ��� ��������� {$row['owner']}, ������� {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "66":
					echo "<span class=date>{$row['date']}</span> ������� ������ ����� ��� ��������� {$row['owner']} (100 ���.)<br>";
					$ekrsum=$ekrsum+100;
					break;
				case "2011":
					echo "<span class=date>{$row['date']}</span> ������� ���������� ���� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2013":
					echo "<span class=date>{$row['date']}</span> ������ ����� ��������� {$row['owner']} �� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014":
					echo "<span class=date>{$row['date']}</span> ������� ���� ��������� {$row['owner']} �� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2000":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���������� ����� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "300":
					echo "<span class=date>{$row['date']}</span> ������� ��������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "283":
					echo "<span class=date>{$row['date']}</span> ������� ������� ������ ��������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "284":
					echo "<span class=date>{$row['date']}</span> ������ ������� ����� ��������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "33333":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ����� �����, ��������� {$row['owner']}, ������� {$row['dilername']}, ({$row['ekr']} ���.)<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "260":
					echo "<span class=date>{$row['date']}</span> ������ ���������� �����  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "262":
					echo "<span class=date>{$row['date']}</span> ���� �������� �����  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "18210":
					echo "<span class=date>{$row['date']}</span>������� ������ ������ ������ ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18229":
					echo "<span class=date>{$row['date']}</span>������� ������ �������� ������ ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18247":
					echo "<span class=date>{$row['date']}</span>������� ��� ���������� ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "18527":
					echo "<span class=date>{$row['date']}</span>������� ������� ��� ���� ���������  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
				break;

				case "2001":
					echo "<span class=date>{$row['date']}</span> ������ ��� �������� ����� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "100029":
					echo "<span class=date>{$row['date']}</span> ������ �������� �������� (��)  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "7002":
					echo "<span class=date>{$row['date']}</span> ������ ���� ����� (��)  {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;


				case "2002":
					echo "<span class=date>{$row['date']}</span> ������ ����� ������ ������� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2003":
					echo "<span class=date>{$row['date']}</span> ������ ������ �������� ��������� {$row['owner']} ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "0":
					echo "<span class=date>{$row['date']}</span> ���������� {$row['ekr']} ���. ���������  {$row['owner']} (���� �{$row['bank']}) �� ������ {$row['dilername']} <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "7":
					echo "<span class=date>{$row['date']}</span> ������ Silver account ��������� {$row['owner']} ������� {$row['dilername']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "17":
					echo "<span class=date>{$row['date']}</span> ������ Gold account ��������� {$row['owner']} ������� {$row['dilername']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "117":
					echo "<span class=date>{$row['date']}</span> ������ Platinum account ��������� {$row['owner']} ������� {$row['dilername']} ({$row['ekr']} ���.) <br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "77":
					echo "<span class=date>{$row['date']}</span> ������� ���� �� ������� ���������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "777":
					echo "<span class=date>{$row['date']}</span> ������� ���� � ������������ ����� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "584":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 5000 {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "585":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 10000 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "586":
					echo "<span class=date>{$row['date']}</span> ������ ������ ���� 15000 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2014100":
					echo "<span class=date>{$row['date']}</span> ������ ���������� ��� 2014 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014101":
					echo "<span class=date>{$row['date']}</span> ������ ���� ������ 2014 ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014102":
					echo "<span class=date>{$row['date']}</span> ������ ������������ ����-������ ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2014103":
					echo "<span class=date>{$row['date']}</span> ������� ������������ ����� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3001003":
					echo "<span class=date>{$row['date']}</span> ������� ���� ������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3006000":
					echo "<span class=date>{$row['date']}</span> ������� �������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "4016":
					echo "<span class=date>{$row['date']}</span> ������ ������� � ����� ����������� ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;

				case "2016401":
					echo "<span class=date>{$row['date']}</span> ������ ��� � ����� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "2016001":
					echo "<span class=date>{$row['date']}</span> ������� ����, ��������� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
				case "3003060":
					echo "<span class=date>{$row['date']}</span> ������� ".round($row['ekr']/$gcost)." ������� ����� {$row['owner']} �� ����� ({$row['ekr']} ���.) , ������� {$row['dilername']}<br>";
					$ekrsum=$ekrsum+$row['ekr'];
					break;
			}
		}
		echo "============================================================";
		echo "<br>����� �� ����� (��� SMS)<b>$ekrsum</b> ���.";
		$telos= mysql_fetch_array(mysql_query("select id from oldbk.users where login='{$_POST['pfilter1']}' "));
		$sms_pays = mysql_fetch_array(mysql_query("select sum(ekr) from sms_payments where  `user_id`='{$telos[id]}'  and status=1"));
		if ($sms_pays[0]>0)
			{
			echo "<br>����� SMS �� ����� <b>$sms_pays[0]</b> ���.";
			echo "<br>�����: <b>".($ekrsum+$sms_pays[0])."</b> ���.";
			}


	}
	if (($user['id']==8540) OR ($user['id']==14897))
	{
		echo '<hr><TABLE><TR><TD><FORM METHOD=POST ACTION=dealer.php>
		��������� ������ ������(-1 ��������): <INPUT TYPE=text NAME=dealfilter1 value=""> �����: <INPUT TYPE=text NAME=dealbalans value=""> <INPUT TYPE=submit value="���������!"> </form></TD>
		</tr></TABLE></form>';


	if ($_POST['dealfilter1'] && $_POST['dealbalans']) {
		$perevod1 = mysql_fetch_array(mysql_query("SELECT `login`,`id`,`align` FROM oldbk.`users` WHERE `login` = '{$_POST['dealfilter1']}' and `deal`=1 LIMIT 1;"));
		$dealid=$perevod1['id'];
		$balans = mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.`dealers` WHERE `owner` = '{$dealid}' LIMIT 1;"));
		if ($balans['owner']) {
			$prevbalans=$balans['sumekr'];

			if ($_POST['dealbalans']==-1)
			  {
			  $kk="`sumekr` = 0 ";
			  }
			  else
			  {
			  $kk="`sumekr` = `sumekr`+'{$_POST['dealbalans']}' ";
			  }

			if (mysql_query("UPDATE oldbk.`dealers` set ".$kk." WHERE `owner` = '{$dealid}' LIMIT 1;")) {
				$balans1 = mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.`dealers` WHERE `owner` = '{$dealid}' LIMIT 1;"));
				$postbalans=$balans1['sumekr'];
				echo "�������� ������ ������ {$_POST['dealfilter1']} �� ����� {$_POST['dealbalans']} ���. ���� {$prevbalans} ���. ����� {$postbalans} ���.";

				$get_deal=check_users_city_data($dealid);

				if ($get_deal['email']!='')
				{
				require_once('./mailer/send-email.php');
				$aa='<html>
				<head>
					<title>���������� ������� ������</title>
				</head>
				<body>
					 ������������, '.$get_deal['login'].'.<br>
					��� ��� �������� ��������� ������ �� ����� '.$_POST['dealbalans'].' ���.<br>
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
						addchp('<font color=red>��������!</font> ��� ��� �������� ��������� ������ �� ����� '.$_POST['dealbalans'].' ���. , ����� � ��� �� �����: '.$postbalans.' ���.  ','{[]}'.$get_deal[login].'{[]}',$get_deal['room'],$get_deal['id_city']);
					}
					else
					{
					mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$get_deal['id']."','','<font color=red>��������!</font> ��� ��� �������� ��������� ������ �� �����  ".$_POST['dealbalans']." ���. , ����� � ��� �� �����: ".$postbalans." ���.');");
					}






			}
			else {
				echo "��������� ������";
			}
		}
		else {
			echo "����� � ����� {$_POST['dealfilter1']} �� ������.";
		}
	   }
	   }
	}

   } //XML


} // ������� ��������

if (!($XML_OUT))
{
echo "</body></html>";
}
else
{
echo "</message>";
unset($_SESSION);
session_destroy();
}

?>
