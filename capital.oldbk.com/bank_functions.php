<?

	$vaucher = array (100005,100015,100020,100025,100040,100100,100200,100300);
	$prem_akk_prise=array ("1"=>5,"2"=>20,"3"=>35);
	$prem_akk_name=array ("1"=>'Silver ��������',"2"=>'Gold ��������',"3"=>'Platinum ��������');


	$larec_param=array(2014001,2014002,2014003,2014004);
	$larec_prise=array(2014001=>5,2014002=>30,2014003=>40,2014004=>25);
	$larec_type=array(2014001=>1,2014002=>2,2014003=>3,2014004=>4);	
	$larec_name=array(2014001=>"��������� �����",2014002=>"��������� �����",2014003=>"����������� �����",2014004=>"������� �����");		

	$artup_param=array(1200001,1200002,1200003,1200004,1200005,1200006);
	$artup_prise=array(1200001=>5,1200002=>7.5,1200003=>10,1200004=>20,1200005=>50,1200006=>100);
	$artup_name=array(	1200001=>"������� ��������� ������� ��������� I",
						1200002=>"������� ��������� ������� ��������� II",
						1200003=>"������� ��������� ������� ��������� III",
						1200004=>"������� ��������� ������� ��������� IV",
						1200005=>"������� ��������� ������� ��������� V",
						1200006=>"������� ��������� ������� ��������� VI");	

	$exprun_param=array(584,585,586);
	$exprun_prise=array(584=>5,585=>10,586=>15);
	$exprun_name=array(584=>"������ ���� 5000",585=>"������ ���� 10000",586=>"������ ���� 15000");	
	

// ��������� ����������

	$GOLD_DIS_COST[10000]=500;		$GOLD_DIS_BONUS[10000]=5000;		$GOLD_DIS_ITEMS[10000]=array(56999);
	$GOLD_DIS_COST[2000]=100;		$GOLD_DIS_BONUS[2000]=800;		$GOLD_DIS_ITEMS[2000]=array(56914);	
	$GOLD_DIS_COST[1000]=50;		$GOLD_DIS_BONUS[1000]=300;		$GOLD_DIS_ITEMS[1000]=array(56907);
	$GOLD_DIS_COST[400]=20;			$GOLD_DIS_BONUS[400]=140;		$GOLD_DIS_ITEMS[400]=array();
	$GOLD_DIS_COST[200]=10;			$GOLD_DIS_BONUS[200]=60;		$GOLD_DIS_ITEMS[200]=array();
	$GOLD_DIS_COST[100]=5;			$GOLD_DIS_BONUS[100]=20;		$GOLD_DIS_ITEMS[100]=array();
	
	
	

	$EKR_DIS_COST[500]=500;			$EKR_DIS_BONUS[500]=250;		    $EKR_DIS_ITEMS[500]=array(56999);
	$EKR_DIS_COST[100]=100;			$EKR_DIS_BONUS[100]=40;			     $EKR_DIS_ITEMS[100]=array(56914);
	$EKR_DIS_COST[50]=50;			  $EKR_DIS_BONUS[50]=15;			$EKR_DIS_ITEMS[50]=array(56907);
	$EKR_DIS_COST[20]=20;			  $EKR_DIS_BONUS[20]=7;				 $EKR_DIS_ITEMS[20]=array();
	$EKR_DIS_COST[10]=10;			  $EKR_DIS_BONUS[10]=3;				 $EKR_DIS_ITEMS[10]=array();
	$EKR_DIS_COST[5]=5;			    $EKR_DIS_BONUS[5]=1;			    $EKR_DIS_ITEMS[5]=array();
	
	
	
	$REP_DIS_COST[300000]=500;		$REP_DIS_BONUS[300000]=150000;		     $REP_DIS_ITEMS[300000]=array(56999);
	$REP_DIS_COST[60000]=100;		 $REP_DIS_BONUS[60000]=24000;			$REP_DIS_ITEMS[60000]=array(56914);
	$REP_DIS_COST[30000]=50;		  $REP_DIS_BONUS[30000]=9000;			  $REP_DIS_ITEMS[30000]=array(56907);
	$REP_DIS_COST[12000]=20;		  $REP_DIS_BONUS[12000]=4200;			  $REP_DIS_ITEMS[12000]=array();
	$REP_DIS_COST[6000]=10;			   $REP_DIS_BONUS[6000]=1800;			    $REP_DIS_ITEMS[6000]=array();
	$REP_DIS_COST[3000]=5;			    $REP_DIS_BONUS[3000]=600;			      $REP_DIS_ITEMS[3000]=array();

	



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
			"���������� ���� 2016 (���)"=>55510350,
			"���������� ���� 2016 (���)"=>55510351,
			
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
                        55510350 => 10,
                        55510351 => 50,			
			);
///////////////////////////////////////////////////////

$leto_bukets = array (
			"����� ������ ������ (6)"=>410021,
			"����� ����������� ������ (9)"=>410022,
			"����� ���������� �������� (10)"=>410024,			
			"����� �������� ����� (11)"=>410025,							
			"����� ������������� ����� (12)"=>410023,			
			"����� �������� ����� (13)"=>410026
			
			);
$leto_bukets_prise= array (
                        410021 => 10,
                        410022 => 10,			
                        410024 => 10,	
                        410025 => 10,	                        
                        410023 => 10,			
                        410026 => 10,	                                                                        
			);
///////////////////////////////////////////////////////
/*
 �������-������� ������ 1 ����, ��������� 0,5 ���
2. �������-������� ������ 7 ����, ��������� 2 ���
3. �������-������� ������ 14 ����, ��������� 3 ���
"1"=>0.5,
*/					
$new_akks_prise[1] =array(  	"7" => 2,  "14" =>3,  "30"=>5 );
/*
1. ����-������� ������ 1 ����, ��������� 2 ���
2. ����-������� ������ 7 ����, ��������� 8 ���
3. ����-������� ������ 14 ����, ��������� 12 ���
	 "1"=>2, 
*/
$new_akks_prise[2] =array(	"7" => 8,  "14" =>12,  "30"=>20 );
/*
1. ��������-������� ������ 1 ����, ��������� 3$
2. ��������-������� ������ 7 ����, ��������� 12$
3. ��������-������� ������ 14 ����, ��������� 21$
 "1"=>3, 
*/
$new_akks_prise[3] =array(	"7" => 12,  "14" =>21,  "30"=>35 );								
	

function make_discount_bonus($telo,$sum,$t)	
{
global  $GOLD_DIS_COST, $GOLD_DIS_BONUS , $GOLD_DIS_ITEMS , $EKR_DIS_COST , $EKR_DIS_BONUS , $EKR_DIS_ITEMS , $REP_DIS_COST ,  $REP_DIS_BONUS ,  $REP_DIS_ITEMS ;
//���������� ����������
//���������� �� ��������
//return false;
$sum=round($sum); //l��� ���� ����  4,99 = 5
	
			if ($t==1)
			{
			//������
			arsort($GOLD_DIS_COST);
			reset($GOLD_DIS_COST);
	 		foreach ($GOLD_DIS_COST as $k => $cost) 
	 			{
	 				if ($sum>=$cost)
	 					{
	 					//������ �����

	 							//���������� ����� �� ������
	 							if ($GOLD_DIS_BONUS[$k]>0)
	 							{

	 							$add_gold=$GOLD_DIS_BONUS[$k];
	 							
	 												mysql_query("UPDATE oldbk.`users` set `gold` = `gold`+'{$add_gold}' WHERE `id` = '{$telo['id']}' LIMIT 1;");
													if (mysql_affected_rows()>0)	
													{
													$rec['owner']=$telo['id'];
													$rec['owner_login']=$telo['login'];
													$rec['owner_balans_do']=$telo['money'];
													$rec['owner_balans_posle']=$telo['money'];
													$rec['target']=8383;
													$rec['target_login']=iconv("CP1251","CP1251",'������');
													$rec['type']=3011;
													$rec['sum_kr']=0;
													$rec['sum_ekr']=0;
													$rec['sum_kom']=0;
													$rec['item_id']='';
													$rec['item_name']='������';
													$rec['item_count']=$add_gold;
													$rec['item_type']=50;
													$ko_bonus_gold_str='. ��������� '.$add_gold.' ����� �� �������� �����:'.$k;	
													$rec['add_info'] = $add_gold."/".($telo['gold']+$add_gold).$ko_bonus_gold_str;
													add_to_new_delo($rec);
													telepost_new($telo,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� � ������� <b>'.$add_gold.'</b> �����.')); 
													}
	 							}

								
								//������ �������� ��������� ���� ����
								if (count($GOLD_DIS_ITEMS[$k]>0))
								{
								$bonus_items=$GOLD_DIS_ITEMS[$k];
							 		foreach ($bonus_items as $n => $itmid) 
							 		{
									$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$itmid}' ;"));
									if ($dress['id']>0)
										{
										$dress['present']='�����';
										by_item_bank_dil($telo,$dress,null,0);
										}
									}
								}
	 					return true;
	 					}

	 			}
			}
			elseif ($t==2)
			{
			//����
			arsort($EKR_DIS_COST);
			reset($EKR_DIS_COST);
	 		foreach ($EKR_DIS_COST as $k => $cost) 
	 			{
	 				if ($sum>=$cost)
	 					{
	 					//������ �����
	 							
	 							//���������� ��� �� ������
	 							if ($EKR_DIS_BONUS[$k]>0)
	 							{
	 							$add_ekr=$EKR_DIS_BONUS[$k];
									$bank = mysql_fetch_array(mysql_query("select * from oldbk.bank where owner='{$telo['id']}' order by def desc,id limit 1"));
							
									if ($bank['id']>0)							
										{
			 								  mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".($add_ekr)."' WHERE `id`= '{$bank['id']}' LIMIT 1;");
											if (mysql_affected_rows()>0)	
													{
													mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('','450','".iconv("CP1251","CP1251",'KO')."','{$bank['id']}','".$telo['login']."','{$add_ekr}');");					
													mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','".iconv("CP1251","CP1251","����� �� ������� ������������ <b>{$add_ekr}</b> ���. (<i>�����: {$bank[cr]} ��., ".($bank['ekr']+$add_ekr)." ���. </i>)")."','{$bank['id']}');");		
				
								  		    			$rec['owner']=$telo[id]; 
													$rec['owner_login']=$telo['login'];
													$rec['owner_balans_do']=$telo['money'];
													$rec['owner_balans_posle']=$telo['money'];
													$rec['target']=8383;
													$rec['target_login']=iconv("CP1251","CP1251",'������');
													$rec['type']=355;
													$rec['sum_ekr']=$add_ekr;
													$rec['bank_id']=$bank[id];
													$rec['add_info']=iconv("CP1251","CP1251",'�������� �����:'.$k);
													add_to_new_delo($rec);
													telepost_new($telo,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� � ������� <b>'.$add_ekr.'</b> ���. �� ���� �'.$bank['id'].'. ')); 
													}
										}
	 							}
								
								//������ �������� ��������� ���� ����
								if (count($EKR_DIS_ITEMS[$k]>0))
								{
								$bonus_items=$EKR_DIS_ITEMS[$k];
							 		foreach ($bonus_items as $n => $itmid) 
							 		{
									$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$itmid}' ;"));
									if ($dress['id']>0)
										{
										$dress['present']='�����';
										by_item_bank_dil($telo,$dress,null,0);
										}
									}
								}
	 					return true;
	 					}
	 			
	 			}
			}
			elseif ($t==3)
			{
			//����
			arsort($REP_DIS_COST);
			reset($REP_DIS_COST);
	 		foreach ($REP_DIS_COST as $k => $cost) 
	 			{
	 				if ($sum>=$cost)
	 					{
	 					//������ �����
	 							
	 							//���������� ��� �� ������
	 							if ($REP_DIS_BONUS[$k]>0)
	 							{
	 							$add_rep=$REP_DIS_BONUS[$k];
	 							
	 											mysql_query("UPDATE `users` SET  `rep`=`rep`+'$add_rep' WHERE `id`= '".$telo['id']."' LIMIT 1;"); 
												mysql_query("UPDATE `users` SET   `repmoney` = `repmoney` + '$add_rep' WHERE `id`= '".$telo['id']."' LIMIT 1;"); 
													if (mysql_affected_rows()>0)	
													{
													$rec['owner']=$telo[id];
													$rec['owner_login']=$telo[login];
													$rec['owner_balans_do']=$telo['money'];
													$rec['owner_balans_posle']=$telo['money'];
													$rec['owner_rep_do']=$telo[repmoney];
													$rec['owner_rep_posle']=($telo[repmoney]+$add_rep);
													$rec['target']=8383;
													$rec['target_login']='������';
													$rec['type']=2829;
													$rec['sum_rep']=$add_rep;					
													$add_bonus_str='. ��������� '.$add_rep.' ��������� �� �������� �����:'.$k;	
													$rec['add_info']='������ ��� �� '.$telo[repmoney]. ' ����� ' .($telo[repmoney]+$add_rep).$add_bonus_str;
													add_to_new_delo($rec);
													telepost_new($telo,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� � ������� <b>'.$add_rep.'</b> ���������.')); 
													}
	 							}
								
								//������ �������� ��������� ���� ����
								if (count($REP_DIS_ITEMS[$k]>0))
								{
								$bonus_items=$REP_DIS_ITEMS[$k];
							 		foreach ($bonus_items as $n => $itmid) 
							 		{
									$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$itmid}' ;"));
									if ($dress['id']>0)
										{
										$dress['present']='�����';
										by_item_bank_dil($telo,$dress,null,0);
										}
									}
								}
	 					return true;
	 					}
	 			
	 			}
			}			

return false;
}
	
	
	
function make_ekr_add_bonus($tonick,$get_bankid,$user,$addbonekr,$msg_off=0)
{
if (is_array($user))
	{
	$str1='�� ������ '.$user['login'];
	}
	else
	{
	$str1='';
	$user['id']=450;
	$user['login']='��';	
	}


					if ($addbonekr>0)
				  	{
				  	//��������� �����  � �����
				  	
					mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$addbonekr}' WHERE `id` = '{$get_bankid['id']}' LIMIT 1;");

					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','������� ����� <b> {$addbonekr} ���.</b>,<i>(�����: {$get_bankid[cr]} ��., ".($get_bankid['ekr']+$addbonekr)." ���.)</i>','{$get_bankid['id']}');");					
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr) values (450,'KO','{$get_bankid['id']}','{$tonick[login]}','{$addbonekr}');");
								//new_delo
			  		    			$rec['owner']=$tonick[id];
								$rec['owner_login']=$tonick[login];
								$rec['owner_balans_do']=$tonick['money'];
								$rec['owner_balans_posle']=$tonick['money'];
								$rec['target']=$user[id];
								$rec['target_login']=$user[login];
								$rec['type']=355;//����� 
								$rec['sum_kr']=0;
								$rec['sum_ekr']=$addbonekr;
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
								$rec['add_info']='������ ��:'.$get_bankid['ekr'].'���. ';
								$get_bankid['ekr']+=$addbonekr;
								$rec['add_info'].='/ �����:'.$get_bankid['ekr'].'���. ';
								
								add_to_new_delo($rec); //�����

					if ($msg_off==0) { telepost_new($tonick,'<font color=red>��������!</font> �� ��� ���� �'.$get_bankid['id'].' ���������� '.$addbonekr.' ���. ��  ������������� ������. ������� �� �������!'); }
					return true;
				  	}
return false;
}


function get_ekr_addbonus()
{
		$query_curs=mysql_query_cache("select * from  oldbk.variables where  var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'   ",false,6);

	while(list($k,$row) = each($query_curs)) 
	{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		 else
		 	if($row['var'] =='euro')  { $euro = $row[value];} 
		 		else
		 			if($row['var'] =='grivna') { $grivna = $row[value];}
 					 elseif($row['var'] =='ekrkof') { $ekrkof = $row[value];}		 
			 		elseif($row['var'] =='ekrbonus') { $ekrbonus = $row[value];} 		 					  					 			
	}

	if ($ekrbonus>0)
		{
		 return	$ekrbonus;
		}
		else return false;
}

function get_rur_curs()
{
		$query_curs=mysql_query_cache("select * from  oldbk.variables where  var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'   ",false,6);

	while(list($k,$row) = each($query_curs)) 
	{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		 else
		 	if($row['var'] =='euro')  { $euro = $row[value];} 
		 		else
		 			if($row['var'] =='grivna') { $grivna = $row[value];}
 					 elseif($row['var'] =='ekrkof') { $ekrkof = $row[value];}		 			
			 		elseif($row['var'] =='ekrbonus') { $ekrbonus = $row[value];} 		 					  					 
	}
	$RUR=round($dollar,3);
	$RUR=(ceil($RUR/0.01) * 0.01);
	if ($RUR>0)
		{
		 return	$RUR;
		}
		else return false;
		
}	

function get_ekr_usd()
{
		$query_curs=mysql_query_cache("select * from  oldbk.variables where  var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'   ",false,6);

	while(list($k,$row) = each($query_curs)) 
	{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		 else
		 	if($row['var'] =='euro')  { $euro = $row[value];} 
		 		else
		 			if($row['var'] =='grivna') { $grivna = $row[value];}
 					 elseif($row['var'] =='ekrkof') { $ekrkof = $row[value];}		 
			 		elseif($row['var'] =='ekrbonus') { $ekrbonus = $row[value];} 		 					  					 			
	}

	if ($ekrkof>0)
		{
		 return	$ekrkof;
		}
		else return false;
}

function get_rur_curs_bank()
{
		$query_curs=mysql_query_cache("select * from  oldbk.variables where  var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'   ",false,6);

	while(list($k,$row) = each($query_curs)) 
	{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		 else
		 	if($row['var'] =='euro')  { $euro = $row[value];} 
		 		else
		 			if($row['var'] =='grivna') { $grivna = $row[value];}
 					 elseif($row['var'] =='ekrkof') { $ekrkof = $row[value];}		
			 		elseif($row['var'] =='ekrbonus') { $ekrbonus = $row[value];} 		 					  					  			
	}
	
	$RUR=round($dollar,3);
	$RUR=(ceil($RUR/0.01) * 0.01);

	if ($RUR>0)
		{
		 $RURC=round(1/$RUR,7);
		 return	$RURC;
		}
		else return false;
		
}

function get_ekr_to_rur_curs()
{

		$query_curs=mysql_query_cache("select * from  oldbk.variables where  var='dollar' or var='euro' or var='grivna' or var='ekrkof' or var='ekrbonus'   ",false,6);

	while(list($k,$row) = each($query_curs)) 
	{
		if($row['var'] =='dollar') { $dollar = $row[value];}
		 else
		 	if($row['var'] =='euro')  { $euro = $row[value];} 
		 		else
		 			if($row['var'] =='grivna') { $grivna = $row[value];}
 					 elseif($row['var'] =='ekrkof') { $ekrkof = $row[value];}		 
			 		elseif($row['var'] =='ekrbonus') { $ekrbonus = $row[value];} 		 					  					 					 			
	}
	
	
	$RUR=round($dollar,3);
	$RUR=(ceil($RUR/0.01) * 0.01);
	if ($RUR>0)
		{
		 return	$RUR;
		}
		else return false;
		
}


////������� �������� �� �� �����
	function by_item_ko($telo_id,$item_id,$bank_id)
	{
	  //��������� �������� ��
	  
	  $tonick = check_users_city_data($telo_id);
	if ($tonick['login']) {
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$item_id}' ;"));
			if ($dress[id]>0)
			  {
 			
				if(mysql_query("INSERT INTO oldbk.`inventory`
					(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
						`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
						`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
						`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str." , `ab_mf`,`ab_bron`,`ab_uron`,`sowner`
					)
					VALUES
					(30,'{$dress['id']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
					'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
					'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
					,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}' ".$sql." ,'{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','0'
					) ;"))
					{
						$good = 1;
						$new_vid=mysql_insert_id();
						$dress[id]=$new_vid;
					}
					else {
						$good = 0;
					       	$resultCode=300;
					}

			    if ($good==1)
			        {
					mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values ('83','������','0','{$tonick['login']}','{$dress[ecost]}','5');");
					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=83;
					$rec['target_login']='������������ �����';
					$rec['type']=52;//������� ������ 
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$dress[ecost];
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
					
					//����� - �����
					require_once "config_ko.php";
					if ((time()>$KO_start_time8-14400) and (time()<$KO_fin_time8-14400)) 
					{
					$vau_bonus=true;
				 	$AKC[100100]=array(100005,100005);
				 	$AKC[100200]=array(100020);
				 	$AKC[100300]=array(100015,100015,100005);
				 	
 					if ( ($AKC[$item_id] >0) )
 					{
				 	$bonus_arra=$AKC[$item_id];
				 		foreach ($bonus_arra as $v)
		 				{
						$bonusdress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$v}' ;"));
						mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`, `gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`, `mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`gmp`,`gmeshok`, `group`,`letter` ".$str." , `ab_mf`,`ab_bron`,`ab_uron` ) VALUES
						(30,'{$bonusdress['id']}','{$tonick['id']}','{$bonusdress['name']}','{$bonusdress['type']}',{$bonusdress['massa']},{$bonusdress['cost']},{$bonusdress['ecost']},'{$bonusdress['img']}',{$bonusdress['maxdur']},{$bonusdress['isrep']},'{$bonusdress['gsila']}','{$bonusdress['glovk']}','{$bonusdress['ginta']}','{$bonusdress['gintel']}','{$bonusdress['ghp']}','{$bonusdress['gnoj']}','{$bonusdress['gtopor']}','{$bonusdress['gdubina']}','{$bonusdress['gmech']}','{$bonusdress['gfire']}','{$bonusdress['gwater']}','{$bonusdress['gair']}','{$bonusdress['gearth']}','{$bonusdress['glight']}','{$bonusdress['ggray']}','{$bonusdress['gdark']}','{$bonusdress['needident']}','{$bonusdress['nsila']}','{$bonusdress['nlovk']}','{$bonusdress['ninta']}','{$bonusdress['nintel']}','{$bonusdress['nmudra']}','{$bonusdress['nvinos']}','{$bonusdress['nnoj']}','{$bonusdress['ntopor']}','{$bonusdress['ndubina']}','{$bonusdress['nmech']}','{$bonusdress['nfire']}','{$bonusdress['nwater']}','{$bonusdress['nair']}','{$bonusdress['nearth']}','{$bonusdress['nlight']}','{$bonusdress['ngray']}','{$bonusdress['ndark']}','{$bonusdress['mfkrit']}','{$bonusdress['mfakrit']}','{$bonusdress['mfuvorot']}','{$bonusdress['mfauvorot']}','{$bonusdress['bron1']}','{$bonusdress['bron2']}','{$bonusdress['bron3']}','{$bonusdress['bron4']}','{$bonusdress['maxu']}','{$bonusdress['minu']}','{$bonusdress['magic']}','{$bonusdress['nlevel']}','{$bonusdress['nalign']}','".(($bonusdress['goden'])?($bonusdress['goden']*24*60*60+time()):"")."','{$bonusdress['goden']}','{$bonusdress['razdel']}','{$bonusdress['gmp']}','{$bonusdress['gmeshok']}','{$bonusdress['group']}','{$bonusdress['letter']}' ".$sql." ,'{$bonusdress['ab_mf']}','{$bonusdress['ab_bron']}','{$bonusdress['ab_uron']}') ;");						
							
							
						$bonus_vid='cap'.mysql_insert_id();
						$bonus_txt.=$bonusdress['name'].", ";
							
						mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr,addition) values (450,'KO','0','{$tonick['login']}','{$bonusdress['ecost']}','5');");
							
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
				 	}
				////////////////////////////////////////////////////////////////

					//������ �� �������  �������� - ������
					if ((time()>1336003201-14400) and (time()<1336089599-14400))
						{
						// �����
						$add_bonuss_art=round(($dress[ecost]*0.1),2);
						if ($bank_id>0)
							{
							$tobank[id]=$bank_id;
							}
							else
							{						
							$tobank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = '{$tonick[id]}' LIMIT 1;"));
							}
							
							if ($tobank[id]>0)
								{
								mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$add_bonuss_art}' WHERE `id` = '{$tobank[id]}' LIMIT 1;");
								mysql_query("INSERT INTO oldbk.`dilerdelo` (dilerid,dilername,bank,owner,ekr) values (450,'KO','{$tobank[id]}','{$tonick[login]}','{$add_bonuss_art}');");

								//new_delo
			  		    			$rec['owner']=$tonick[id];
								$rec['owner_login']=$tonick[login];
								$rec['owner_balans_do']=$tonick['money'];
								$rec['owner_balans_posle']=$tonick['money'];
								$rec['target']=450;
								$rec['target_login']='������������ �����';
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
						}
					/////////////////////////////
							if ( $tonick['odate'] > (time()-60)  )
							{
							addchp('<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b>. ������� �� �������!','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
							if ($bon_ok==1)
								{
							addchp('<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_bonuss_art.' ���. ����� �� ���.������. ������� �� �������!','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
								}						
	
							if ($bonus_txt!='')	
							{
							$bonus_txt=substr($bonus_txt,0,-2);
							addchp('<font color=red>��������!</font> ��� ������� ����� �� ���.������ <b>'.$bonus_txt.'</b>. ������� �� �������!','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
							}
						
							} else {
							// ���� � ���
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� <b>'.$dress['name'].'</b>. ������� �� �������!'."');");
							if ($bon_ok==1)
							{
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> �� ��� ���� �'.$tobank[id].' ���������� '.$add_bonuss_art.' ���. ����� �� ���.������. ������� �� �������!'."');");
							}
							
							if ($bonus_txt!='')	
							{
							$bonus_txt=substr($bonus_txt,0,-2);						
							mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".'<font color=red>��������!</font> ��� ������� ����� �� ���.������ <b>'.$bonus_txt.'</b>. ������� �� �������!'. "');");
							}
							
							}
					
					 // ���������
					CheckRealPartners($telo_id,$dress[ecost],0);
					 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$telo_id}' LIMIT 1;"));
				     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	 if ($p_user['partner']!='' and $p_user['fraud']!=1)
				       {
				       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$telo_id}','{$dress[ecost]}','{$tobank[id]}','".time()."');");
				      	 $bonus=round(($dress[ecost]/100*$partner['percent']),2);
				      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$dress[ecost]}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				      }					
							
					//��� ���	
				       return true;
							
				}
			 	
			   	
			  }
			  else
			  {
			  		return false;//������� �� ������
			  }
			  
			}
			else {
				return false; //����� �� ������
			} 
	  
	}

////////////������� �������� - �������� , ����������� ��������� ������
    	$akkcosts[1]=5; $strtype[1]='Silver'; $exp_bonus[1]="0.1"; $eff_type[1]=4999;
    	$akkcosts[2]=20; $strtype[2]='Gold'; $exp_bonus[2]="0.15"; $eff_type[2]=5999;
    	$akkcosts[3]=35; $strtype[3]='Platinum'; $exp_bonus[3]="0.20"; $eff_type[3]=6999; 	    

    	$akks_types=array(107,114,130,207,214,230,307,314,330);//101 201 301
    			/*
				����-�������
				1. ����-������� ������ 1 ����, ��������� 2 ���
				     ��� ������� ������� "�����������" (� ��������� 4��.)
				     ��� ������� ������� "����� ������ � ������" (� ��������� 1��.)
			*/
	$gold_set_abils[1][1]=0; 
	$gold_set_abils[1][4848]=0; 
			/*
			2. ����-������� ������ 7 ����, ��������� 8 ���
		     ������ ������ "�����������" 1 ��. (� ��������� 4��.)
		     ��� ������� ������� "����� ������ � ������" (� ��������� 1��.)
		     */
	$gold_set_abils[7][1]=1; 
	$gold_set_abils[7][4848]=0; 
			/*
			3. ����-������� ������ 14 ����, ��������� 12 ���
			������ ������ "�����������" 2 ��. (� ��������� 4��.)
			��� ������� ������� "����� ������ � ������" (� ��������� 1��.)
			*/
	$gold_set_abils[14][1]=2; 
	$gold_set_abils[14][4848]=0; 
			
			/*
			4. �� 30 ����
			*/			
	$gold_set_abils[30][1]=4; 
	$gold_set_abils[30][4848]=1;    	
    		
    		/*
		    ��������-�������
	    1. ��������-������� ������ 1 ����, ��������� 3$
	     �� ���� ������� "������� � ����� 0/1", ��������, (� ��������� 5��.)
	     ��� ������� "�����������" (� ��������� 4��.)
	     ��� ������� "����� ������ � ������" (� ��������� 4��.)
		*/
		$plat_set_abils[1][4016]=0;
		$plat_set_abils[1][1]=0;	
		$plat_set_abils[1][4848]=0;		
		/*
		2. ��������-������� ������ 7 ����, ��������� 12$
		     ������ "������� � ����� 0/1", ��������, 1 �� (� ��������� 5��.)
		     ������ "�����������" 1 �� (� ��������� 4��.)
		     ������ "����� ������ � ������" 1 �� (� ��������� 4��.)
		*/
		$plat_set_abils[7][4016]=1;
		$plat_set_abils[7][1]=1;	
		$plat_set_abils[7][4848]=1;		
		
		/*
		3. ��������-������� ������ 14 ����, ��������� 21$
		     ������ "������� � ����� 0/1", ��������, 2 �� (� ��������� 5��.)
		     ������ "�����������" 2 �� (� ��������� 4��.)
		     ������ "����� ������ � ������" 2 �� (� ��������� 4��.)    		
    		*/
		$plat_set_abils[14][4016]=2;
		$plat_set_abils[14][1]=2;	
		$plat_set_abils[14][4848]=2;

		/*
		4, ������ �� 30 ����
		*/
		$plat_set_abils[30][4016]=5;
		$plat_set_abils[30][1]=4;	
		$plat_set_abils[30][4848]=4;
    		
    	
	function setup_acc_new($telo,$acctype,$dill,$add_time=0,$kdays=30)
	{
	//��������� ������ ������ ��������
	 global $akkcost,$strtype,$db_city,$exp_bonus,$eff_type,$plat_set_abils,$gold_set_abils;
    	$akkcosts[1]=5; $strtype[1]='Silver'; $exp_bonus[1]="0.1"; $eff_type[1]=4999;
    	$akkcosts[2]=20; $strtype[2]='Gold'; $exp_bonus[2]="0.15"; $eff_type[2]=5999;
    	$akkcosts[3]=35; $strtype[3]='Platinum'; $exp_bonus[3]="0.20"; $eff_type[3]=6999; 	    
	
	telepost('Bred','<font color=red>setup_acc_new_EXP_1</font>kdays:'.$kdays.'/telo id:'.$telo['id'].'/expbon:'.$exp_bonus[$acctype]); 	 	

	
	$exp=(time()+60*60*24*$kdays)+$add_time; 	 
	$sqlt="UPDATE ".$db_city[$telo[id_city]]."users set prem = {$acctype}  , expbonus=expbonus+'{$exp_bonus[$acctype]}'   WHERE id = '{$telo['id']}' LIMIT 1;";
	mysql_query($sqlt);
	
 	telepost('Bred','<font color=red>setup_acc_new</font>city:'.$db_city[$telo[id_city]].'/acctype:'.$acctype.'/expb:'.$exp_bonus[$acctype].'/teloid:'.$telo['id']);
	
	
	mysql_query("insert into ".$db_city[$telo[id_city]]."effects (`type`, `name`, `owner`, `time`) VALUES  ('{$eff_type[$acctype]}','{$strtype[$acctype]} account','".$telo[id]."','".$exp."') ;");
	
		if ($acctype==2)
			{
			//������ �����
			get_gold_abil($telo,$dill,$kdays);
			}
		elseif ($acctype==3)
			{
			//������ �������
			get_platinum_abil($telo,$dill,$kdays);
			}
	return $exp;
	}
	
	function get_gold_abil($telo,$dill,$kdays=30)
	{
 	 global $gold_set_abils;
	
	//1. 3 ��������� (������ ��� �������) +1 ��������� =4 ��
		
		if ($gold_set_abils[$kdays][1] >0)
			{
			mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=1,`allcount`='{$gold_set_abils[$kdays][1]}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$gold_set_abils[$kdays][1]}' ;");
			}
			
	//2. ��������� - 1 ������� ��� � �����
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=55,`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");
	//3.�������� - 2�� (30���) ��� � �����
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=15,`dailyc`=2,`daily`=2  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+2, `daily`=`daily`+2 ;");
	//8. ������ �������� - 1�� � ����� (������ �� ���� � ������ �������)
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=4847,`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");		
	//4. 2 ���������� ������ �� ��������� ��������� (�������� ��� �������)
	//get_bonus_bill_loto($telo,1,$dill);
		
		//6. ���������� ��������� ������ (������ ��� ������� � ���� ������ � ������� 30 ����, � ������� ������� ����� �������, ���� ���� �� �������)
		if ($gold_set_abils[$kdays][4848] >0)
		{
		$exp=(time()+60*60*24*$kdays); 
		mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=4848,`allcount`='{$gold_set_abils[$kdays][4848]}', `findata`='{$exp}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$gold_set_abils[$kdays][4848]}', `findata`='{$exp}' ;");
		}
	
	
	}
	
	function get_platinum_abil($telo,$dill,$kdays=30)
	{
	 global $plat_set_abils,$premlastuseid;
	
	$abil[1]=5007152; //����  1; // �����
	$abil[2]=5007154; //������ ���� wrath_ground   2  ����� 
	$abil[3]=5007153; //����������/ wrath_air 3; //������ (����, ������
	$abil[4]=5007155; //���������� ����	wrath_water  4; //���� 
	
	$need_astih=get_mag_stih($telo); // �������� �� ������
	$need_astih=$need_astih[0]; //�� 0� ����� ������ ������
		
	//3.�������� - 2�� (30���) ��� � �����
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=15,`dailyc`=2,`daily`=2  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+2, `daily`=`daily`+2 ;");
		
	//2. ��������� - 1 ������� ��� � �����
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=55,`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");


	if (!$premlastuseid || $premlastuseid < 858500017) {
		//1. 2 ��������� � ����� => 1 �����
		mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`='{$abil[$need_astih]}',`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");
	}

	//2. ������� ����� ����� �� ���� ��� ������� - 1�� � �����
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=57,`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");
	//3. 2 �������� ���� � �����
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=56,`dailyc`=2,`daily`=2  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+2, `daily`=`daily`+2 ;");
	//4. �������� - 1�� � �����
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=2526,`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");	
	
	
	//6. ���������� ��������� ������ � ������ (������ � ������) - 1 �������������, ������ (� ������� 30 ���� ����� ������� ���� �������� �� �������)

	
	if ($plat_set_abils[$kdays][4848] > 0)
	{
	$exp=(time()+60*60*24*$kdays); 
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=4848,`allcount`='{$plat_set_abils[$kdays][4848]}', `findata`='{$exp}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$plat_set_abils[$kdays][4848]}', `findata`='{$exp}' ;");
	}

	//7. 5 ���������� ������� �� ��������� ��������� (������)
	//get_bonus_bill_loto($telo,3,$dill);
	
	//8. ������ �������� - 5�� � ����� (������ �� ���� � ������ �������)
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=4847,`dailyc`=5,`daily`=5  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+5, `daily`=`daily`+5 ;");		
	
	//9. ������ �� ��������� ����� - 3 ��� (������-������ � ������ ������� ����� ������� ����� � �������� ������ 3 ����)
	//mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=4846,`allcount`=1  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+1 ;");
	

		if ($plat_set_abils[$kdays][1] >0)	
		{
		//10.  ������� (������ ��� �������)
		mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=1,`allcount`='{$plat_set_abils[$kdays][1]}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$plat_set_abils[$kdays][1]}' ;");
		}
	
	//11. 1 ���������� (������ ��� �������)
	///mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=1111,`allcount`=1  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+1 ;");


		if ($plat_set_abils[$kdays][4016] >0 && (!$premlastuseid || $premlastuseid < 858500017))
		{
			// ��������: ������� � ����� 0/1, ��������, 5 ��.
			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='4016' ;"));
			$dress['present']='�����';
			for ($i=0;$i<$plat_set_abils[$kdays][4016];$i++) 
						{
						by_item_bank_dil($telo,$dress,$dill,1);
						}
		}

	// �������� ������ ������ "������� ��������" (5��./�����)
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=54,`dailyc`=5,`daily`=5  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+5, `daily`=`daily`+5 ;");
 	
 	// �������� ������ ������ "������ �� ����� �� ���� ���" (1��./�����)
 	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=556557 ,`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");
 	
	//�������� ������ ������ "������ �� ����� ������" (1��./�����)
	mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$telo[id]}',`magic_id`=557561 ,`dailyc`=1,`daily`=1  ON DUPLICATE KEY UPDATE `dailyc`=`dailyc`+1, `daily`=`daily`+1 ;");
	
	}
	
	
    	function get_bonus_bill_loto($telo,$kol,$dill)
    	{
	
		$get_lot=mysql_fetch_array(mysql_query("select * from oldbk.item_loto_ras where status=1 LIMIT 1;"));
		$bilprice=2;
		
		$dill['getfrom']=(int)$dill['getfrom']; // ������ 
		
		
		if ($get_lot[id] >0)
			     {
			        for ($kkk=1;$kkk<=$kol;$kkk++)
			        	{

			        	if(mysql_query("INSERT INTO oldbk.`item_loto` SET `loto`={$get_lot[id]},`owner`={$telo[id]},`dil`={$dill[id]},`lotodate`='".date("Y-m-d H:i:s",$get_lot[lotodate])."';"))
						{
						$new_bil_id=mysql_insert_id();
						mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`name`,`duration`,`maxdur`,`cost`,`owner`,`nlevel`,`nsila`,`nlovk`,`ninta`,`nvinos`,`nintel`,`nmudra`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nalign`,`minu`,`maxu`,`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`img`,`text`,`dressed`,`bron1`,`bron2`,`bron3`,`bron4`,`dategoden`,`magic`,`type`,`present`,`sharped`,`massa`,`goden`,`needident`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`letter`,`isrep`,`update`,`setsale`,`prototype`,`otdel`,`bs`,`gmp`,`includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`,`gmeshok`,`tradesale`,`karman`,`stbonus`,`upfree`,`ups`,`mfbonus`,`mffree`,`type3_updated`,`bs_owner`,`nsex`,`present_text`,`add_time`,`labonly`,`labflag`,`prokat_idp`,`prokat_do`,`arsenal_klan`,`repcost`,`up_level`,`ecost`,`group`,`ekr_up`,`unik`,`add_pick`,`pick_time`,`sowner`,`idcity`,`ekr_flag`)
						VALUES ('{$dill['getfrom']}','���������� ����� �����',0,1,0,{$telo[id]},0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'oldbkloto.gif','',0,0,0,0,0,0,0,210,'������� �����',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'"."����� �".$new_bil_id."<br>����� �".$get_lot[id]."<br>C�������� ".date("Y-m-d H:i:s",$get_lot[lotodate])."',1,'".date("Y-m-d H:i:s")."',0,33333,'6',0,0,0,0,0,'',0,0,0,0,0,0,0,{$get_lot[id]},0,0,{$new_bil_id},0,0,0,NULL,0,0,0,0,NULL,'',0,0,2,0,NULL,0,NULL,NULL,0,'{$dill[id_city]}','1');");
						$dress[id]=mysql_insert_id();
						$dress[idcity]=$dill[id_city];
						
						//new_delo
	  		    			$rec['owner']=$telo[id];
						$rec['owner_login']=$telo[login];
						$rec['owner_balans_do']=$telo['money'];
						$rec['owner_balans_posle']=$telo['money'];
						$rec['target']=$dill[id];
						$rec['target_login']='������������ �����';
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
						$ok=true;
						}
						else 
						{
						echo mysql_error();
						$ok=false;
						}
			        	}
			        if ($ok)	
			        	{
			        	return false;
			        	}
			     }
	return false;
    	}

	function main_prem_akk($tonick,$acctype,$dill,$kdays=30) 
	{
	global $db_city, $gold_set_abils, $plat_set_abils , $premlastuseid;


	switch($tonick[prem])
				{
					case 0:
						//���� ������
						//������ �����
						$exp=setup_acc_new($tonick,$acctype,$dill,0,$kdays);
						break;
					case 1:
						// ���� �������
						$prod=mysql_fetch_array(mysql_query('select * from '.$db_city[$tonick[id_city]].'effects where owner ='.$tonick[id].' AND type =4999 LIMIT 1;'));
						
						 if ($acctype==1)
						 	{
						 	//���������� �������
							if($prod[id]>0)
								{
								mysql_query("UPDATE ".$db_city[$tonick[id_city]]."effects SET `time`=`time`+(60*60*24*{$kdays}) where id={$prod[id]}");
								$exp=$prod['time']+(60*60*24*$kdays);
								}
								else
								{
								return false;
								}
						 	}
						elseif ($acctype==2)
						 		{
						 		//��������� �� ����
						 		if($prod[id]>0)
							 		{
						 			$add_time=(int)(($prod[time]-time())/4);//������� �������� �������
							 		mysql_query("DELETE from  ".$db_city[$tonick[id_city]]."effects where id='{$prod[id]}' ; "); //������� ������ ��������
							 		mysql_query("UPDATE ".$db_city[$tonick[id_city]]."users SET expbonus=expbonus-0.1 where id='{$tonick[id]}'  ");
							 		$exp=setup_acc_new($tonick,2,$dill,$add_time,$kdays);
							 		}
							 		else
									{
									return false;
									}
						 		}
						 elseif ($acctype==3)
						 		{
						 		//��������� �� ������
						 		if($prod[id]>0)
						 			{
						 			$add_time=(int)(($prod[time]-time())/7);//������� �������� �������
							 		mysql_query("DELETE from  ".$db_city[$tonick[id_city]]."effects where id='{$prod[id]}' ; "); //������� ������ ��������
							 		mysql_query("UPDATE ".$db_city[$tonick[id_city]]."users SET expbonus=expbonus-0.1 where id='{$tonick[id]}'  ");
							 		$exp=setup_acc_new($tonick,3,$dill,$add_time,$kdays);						 			
						 			}
						 			else
									{
									return false;								
									}
						 		}
						break;
					case 2:
					//���� ����
						$prod=mysql_fetch_array(mysql_query('select * from '.$db_city[$tonick[id_city]].'effects where owner ='.$tonick[id].' AND type =5999 LIMIT 1;'));
						if ($acctype==2)
						 		{
						 		//���������� ����
						 		if($prod[id]>0)
									{
									mysql_query("UPDATE ".$db_city[$tonick[id_city]]."effects SET `time`=`time`+(60*60*24*{$kdays}) where id={$prod[id]}");
									//�������� ���������!!
									
										//���������� ������������
										if ($gold_set_abils[$kdays][1] >0)
											{
											//1. 3 ��������� (������ ��� �������)
											mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=1,`allcount`='{$gold_set_abils[$kdays][1]}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$gold_set_abils[$kdays][1]}' ;");
											}
											if ($gold_set_abils[$kdays][4848] >0)
											{
											$aexp=(time()+60*60*24*$kdays); 
											mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=4848,`allcount`='{$gold_set_abils[$kdays][4848]}', `findata`='{$aexp}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$gold_set_abils[$kdays][4848]}', `findata`=`findata`+(60*60*24*{$kdays}) ;");								
											}

									$exp=$prod['time']+(60*60*24*$kdays);
									}
									else
									{
									return false;								
									}
						 		}
						 elseif ($acctype==3)
						 		{
						 		//��������� �� ������
						 		if($prod[id]>0)
						 				{
						 				//������� ������ �����
								 		mysql_query("DELETE from  ".$db_city[$tonick[id_city]]."effects where id='{$prod[id]}' ; "); //������� ������ �����
								 		mysql_query("UPDATE ".$db_city[$tonick[id_city]]."users SET expbonus=expbonus-0.1 where id='{$tonick[id]}'  ");								 		
							 			$add_time=(int)(($prod[time]-time())/1.75);//������� �������� �������
						 				//������� ������ ����� ��������
						 				//��������� - 1 ������� ��� � �����
					 					mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$tonick[id]}' and `magic_id`=55;");
						 				//�������� - 2�� (30���) ��� � �����
										mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-2 where `owner`='{$tonick[id]}' and `magic_id`=15;");						 				
										//������ �������� 1 �� � �����
										mysql_query("UPDATE `oldbk`.`users_abils` SET `dailyc`=0,`daily`=`daily`-1 where `owner`='{$tonick[id]}' and `magic_id`=4847;");						 				
																				
										//������ �������
										$exp=setup_acc_new($tonick,3,$dill,$add_time,$kdays);
						 				}
						 				else
						 				{
										return false;									
						 				}
						 		}
						break;
					case 3:
						//���� ������
						$prod=mysql_fetch_array(mysql_query('select * from '.$db_city[$tonick[id_city]].'effects where owner ='.$tonick[id].' AND type =6999 LIMIT 1;'));
						if ($acctype==3)
						 		{
						 		//���������� ������
							 		if($prod[id]>0)
							 			{
							 			mysql_query("UPDATE ".$db_city[$tonick[id_city]]."effects SET `time`=`time`+(60*60*24*{$kdays}) where id={$prod[id]}");
							 			//�������� ���������!!
										//���������� ������������
										//9. ������ �� ��������� ����� - 3 ��� (������-������ � ������ ������� ����� ������� ����� � �������� ������ 3 ����)
										//mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=4846,`allcount`=1  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+1 ;");
										
						 				//���������� ��������� ������ (������ ��� ������� � ���� ������ � ������� 30 ����, � ������� ������� ����� �������, ���� ���� �� �������)
						 				if ($plat_set_abils[$kdays][4848] >0)
						 				{
										mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=4848,`allcount`='{$plat_set_abils[$kdays][4848]}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$plat_set_abils[$kdays][4848]}', `findata`=`findata`+(60*60*24*{$kdays}) ;");
										}
										

										if ($plat_set_abils[$kdays][1] >0)
										{
										//  ��������� (������ ��� �������)
										mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=1,`allcount`='{$plat_set_abils[$kdays][1]}'  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+'{$plat_set_abils[$kdays][1]}' ;");
										}

										//11. 1 ���������� (������ ��� �������)
										///mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$tonick[id]}',`magic_id`=1111,`allcount`=1  ON DUPLICATE KEY UPDATE `allcount`=`allcount`+1 ;");
										
										//7. 5 ���������� ������� �� ��������� ��������� (������)
										//get_bonus_bill_loto($tonick,3,$dill);

	telepost('Bred','<font color=red>setup_acc_new_platina_prod</font>days:'.$kdays.'/item:'.$plat_set_abils[$kdays][4016].'/teloid:'.$tonick['id']);

										if ($plat_set_abils[$kdays][4016] >0 && (!$premlastuseid || $premlastuseid < 858500017))
										{
										// ��������: ������� � ����� 0/1, ��������, 5 ��.
										$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='4016' ;"));
										$dress['present']='�����';
										for ($i=0;$i<$plat_set_abils[$kdays][4016];$i++) 
													{
													by_item_bank_dil($tonick,$dress,$dill,1);
													}
										}

							 			
										$exp=$prod['time']+(60*60*24*$kdays);
							 			}
							 			else
							 			{
										return false;								
							 			}
						 		
						 		}
						break;				
				}
	

		return $exp;
	}

	function by_prem_from_bank($tonick,$acctype,$bank,$exp,$dil=false,$sub_type) // ������������ ������ � �����
	{
	global  $new_akks_prise , $strtype;
	//��������� +5 ���
	//mysql_query("UPDATE oldbk.`bank` set `ekr` = (ekr+5) WHERE `id` = '{$bank['id']}' LIMIT 1;");
	$dilindx[1]=7;
	$dilindx[2]=17;			
	$dilindx[3]=117;			
			
			if ($dil==false)
			{
			$dil['id']=83;
			$dil['login']='������';
			$dil['target_login']='������������ �����';
			}
			else
			{
			$dil['target_login']=$dil['login'];
			}

			
	mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr,addition) values ('{$dil['paysys']}','{$dil['id']}','{$dil['login']}','{$bank['id']}','{$tonick[login]}','{$new_akks_prise[$acctype][$sub_type]}','{$dilindx[$acctype]}');");
	$id_ins_part_del=mysql_insert_id();
				//new_delo
	    			$rec['owner']=$tonick[id];
				$rec['owner_login']=$tonick[login];
				$rec['owner_balans_do']=$tonick['money'];
				$rec['owner_balans_posle']=$tonick['money'];
				$rec['target']=$dil['id'];
				$rec['target_login']=$dil['target_login'];
					$actty[1]=59;
					$actty[2]=359;
					$actty[3]=358;					
				$rec['type']=$actty[$acctype] ;//������� silvera/gold/platinum �� �������
				$rec['sum_kr']=0;
				$rec['sum_ekr']=$new_akks_prise[$acctype][$sub_type];
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

				//mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�������� <b>5 ���.</b> (����� �� ������� ������� ��������) ','{$bank['id']}');");


				// ���������
				CheckRealPartners($tonick['id'],$new_akks_prise[$acctype][$sub_type],0);
				$p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				$partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				if ($p_user['partner']!='' and $p_user['fraud']!=1)
				{
					mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$new_akks_prise[$acctype][$sub_type]}','{$bank['id']}','".time()."');");
					$bonus=round(($new_akks_prise[$acctype][$sub_type]/100*$partner['percent']),2);
					mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$new_akks_prise[$acctype][$sub_type]}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				}

				addchp('<font color=red>��������!</font> ��� �������� '.$strtype[$acctype].' account. ','{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);

return true;
}


	function test_larec($btype,$telo)
	{
//	return true;		
	include "ny_events.php";
	if ((time()>$ny_events['larcistart']) and (time()<$ny_events['larciend']))
	   {
		$q = mysql_query('SELECT * FROM oldbk.boxs_history WHERE owner = '.$telo['id'].' and selldate = "'.date("d/m/Y").'" and box_type = '.$btype);
		$today_by=mysql_num_rows($q);
		if ($today_by>=50)
		{
			return false;		
		}
		else
		{
			$get_all_boxes=mysql_fetch_array(mysql_query("select box_type , count(id) as kol from oldbk.boxs where item_id=0 and box_type=".$btype));
			if ($get_all_boxes['kol']>0)
			{
			return true;		
			}
			else
			{
			return false;
			}
		}
	   }
	   else
		{
		return false;
		}
	}

//������� ��������
function by_item_bank_dil($tonick,$dress,$dil,$msg_off=0)
{

if (is_array($dil))
	{
	$str1='�� ������ '.$dil['login'];
	}
	else
	{
	$str1='';
	$dil['id']=83;
	$dil['login']='������';	
	}
	
		if ($dress['dategoden']>0)
		{
				$goden_do = $dress['dategoden'];
				$goden = $dress['goden'];		
		}
		elseif ($dress['goden']>0)
		{
				$goden_do = time()+($dress['goden']*24*3600);
				$goden = $dress['goden'];
		}
		else
			{
			$goden_do = 0;
			$goden = 0;
			}
	
	if ($dress['prototype']==0)
		{
		$dress['prototype']=$dress['id'];
		}

mysql_query("INSERT INTO oldbk.`inventory`
							(`update`,`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
							`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,
							`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
							`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`group`,`mfbonus`,`stbonus`,`gmp`,`idcity`,`ab_mf`,`ab_bron`,`ab_uron`, `includemagic` , `includemagicdex` , `includemagicmax` , `includemagicname` , `includemagicuses` , `includemagiccost` , `includemagicekrcost`, `present`, `add_time`,`sowner`,`letter`,`ekr_flag`,`img_big`,`rareitem`,`unik`
							)
							VALUES
							('".date("Y-m-d H:i:s")."',30,'{$dress['prototype']}','{$tonick['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']}, '{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
							'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}',
							'{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$goden_do."',
							'{$goden}','{$dress['razdel']}','{$dress['group']}','{$dress['mfbonus']}','{$dress['stbonus']}','{$dress['gmp']}','{$tonick['id_city']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','{$dress['includemagic']}' , '{$dress['includemagicdex']}' , '{$dress['includemagicmax']}' , '{$dress['includemagicname']}' , '{$dress['includemagicuses']}' , '{$dress['includemagiccost']}' , '{$dress['includemagicekrcost']}', '{$dress['present']}',".time().",'{$dress['sowner']}', '{$dress['letter']}', '{$dress['ekr_flag']}', '{$dress['img_big']}', '{$dress['rareitem']}','{$dress['unik']}'
							) ;");

 if (mysql_affected_rows()>0)	
						{
							$dress[id]=mysql_insert_id();
							//new_delo
		  		    			$rec['owner']=$tonick[id];
							$rec['owner_login']=$tonick[login];
							$rec['owner_balans_do']=$tonick['money'];
							$rec['owner_balans_posle']=$tonick['money'];
							$rec['target']=$dil[id];
							$rec['target_login']=$dil[login];
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
							
							if ($msg_off==0) { telepost_new($tonick,'<font color=red>��������!</font> ��� ������� ������� <b>'.$dress[name].'</b> '.$str1.'. ������� �� �������!');	 }
							
						return	true;
						}
return false;
}

function present_bonus_sert($telo,$dill,$code='CP1251')
	{

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='541' ;"));
				if ($code!='CP1251')
				{
				$dress['present']=iconv("UTF-8","CP1251",'�����');					
				}
				else
				{
				$dress['present']='�����';
				}
			$dress['dategoden']=mktime(23,59,59,8,31,2016); 
			$dress['goden']=round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}
			for ($i=0;$i<4;$i++) 
						{
						by_item_bank_dil($telo,$dress,$dill,1);
						}
			if ($i>0)	
				{
					if ($code!='CP1251')
					{
					$mesg=iconv("UTF-8","CP1251",'��������!</font> ��� ������� �������');					
					}
					else
					{
					$mesg='��������!</font> ��� ������� �������';
					}
				
				telepost_new($telo,'<font color=red>'.$mesg.' <b>'.$dress[name].'</b> '.$i.' ��. ');	 
				}

			$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='540' ;"));

			if ($code!='CP1251')
				{
				$dress['present']=iconv("UTF-8","CP1251",'�����');					
				}
				else
				{
				$dress['present']='�����';
				}
			$dress['dategoden']=mktime(23,59,59,8,31,2016); 
			$dress['goden']=round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}			
			for ($i=0;$i<4;$i++) 
						{
						by_item_bank_dil($telo,$dress,$dill,1);
						}							
			if ($i>0)	
				{
					if ($code!='CP1251')
					{
					$mesg=iconv("UTF-8","CP1251",'��������!</font> ��� ������� �������');					
					}
					else
					{
					$mesg='��������!</font> ��� ������� �������';
					}
				
				telepost_new($telo,'<font color=red>'.$mesg.' <b>'.$dress[name].'</b> '.$i.' ��. ');	 
				}
	}

function act_x2bonus_limit($telo,$type,$k)
{
$stl=100+$type;
$getset=mysql_fetch_array(mysql_query("select * from oldbk.stol where owner='{$telo['id']}' and stol='{$stl}' "));
if ($getset['count']>0)
	{
	//���� ������� ��� ������� ���� 
	return false;
	}
	else
	{
	//������� ���
	// ������ ���� 1- ����  2-����  3-������
	//(�������� 15 ���, 9000 ���������, 300 ������� �����)
	$limits[1]=15;
	$limits[2]=9000;
	$limits[3]=300;
	$limits=$limits[$type];
	if ($k>$limits)
		{
		$k=$limits;
		}
	//������ �������
	mysql_query("INSERT INTO `oldbk`.`stol` SET `owner`='{$telo['id']}' ,`stol`='{$stl}',`count`='{$k}';");
	 if (mysql_affected_rows()>0)	
	 	{
 		return $k;
	 	}	
	}
return false;
}

function get_buy_bilet($telo,$fsize,$cost,$selname)
{

	//���� ���.�������
	$last_bil_id=mysql_fetch_array(mysql_query("select id from bilet ORDER by id desc limit 1;"));
	
	if ($last_bil_id[id]<70)
	{
				
     	 if (($telo[align] !=4) and ($telo[block] ==0) )
     	  {
     	  $ttdate=date("Y-m-d H:i:s",time());
     	  
 	    $vip=0;
 	    mysql_query("INSERT INTO `oldbk`.`bilet` SET `selname`='{$selname}',`owner_nick`='{$telo[login]}',`owner`='{$telo[id]}',`fio`='',`vip`='{$vip}',`price`='{$cost}',`sdate`='{$ttdate}', `fsize`='{$fsize}' ;");

 	    	
 	    	
	 	if (mysql_affected_rows()>0)	 	    	
 	    	 {
			$bil_id=mysql_insert_id();
			$bil_name="".(($vip>0)?"VIP ":"")."����� �$bil_id �� 8-����� �����.";
		        $bil_text="<b>".$bil_name."</b><br>���������� �� ������������ 8-�� ��������� �����, ������� ��������� 20.01.2018 � 17:00 � BBQ & Grill Club \"�������\" �� ������: ���������� ��������, ������� �����, ��������� (2�� ������ �����-���������).<br><i>� ���������, ������������� �����</i>";
	        
			mysql_query("INSERT INTO oldbk.`inventory` (`owner`,`name`,`type`,`massa`,`cost`,`img`,`letter`,`maxdur`,`isrep`,`present`,  `prototype`,  `notsell`,`can_drop` )VALUES('{$telo[id]}','{$bil_name}','50',0,0,'8_year.gif','{$bil_text}',1,0,'������������� �����', 1238, 1, 0) ;");
 	    	 
	 	    	 if (mysql_affected_rows()>0)	 	    	
	 		    	 {
				telepost_new($telo,'<font color=red>��������!</font> ��� ������� <b>��������������� ����� �� 8-����� �����</b>!');	
				return "����� ����� �{$bil_id}, ��� ��������� {$telo['login']}.";
				}
		 	    	 else
		 	    	 {
		 	    	 echo "err 2";
		 	    	 }
 	    	 }
 	    	 else
 	    	 {
 	    	 echo "err 1";
 	    	 }

 	  }
	}

return false;
}
















?>