<?
$log = fopen("/www/paylogs/paypal.log", "a");
fwrite($log, "\n\nipn - " . gmstrftime ("%b %d %Y %H:%M:%S", time()) . "\n");

$req = "cmd=_notify-validate";
foreach($_POST as $key=>$val)
{
   $req.= "&".$key."=".urlencode($val);
   fwrite($log,$key."=".$val."\n");
}

$header = "POST http://www.paypal.com/cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen ($req) . "\r\n\r\n";
$fp = fsockopen ("www.paypal.com", 80, $errno, $errstr, 30);

if (!$fp)
{
   echo "$errstr ($errno)";
   fwrite($log, "Failed to open HTTP connection!\n");
   fwrite($log, $errstr." ".$errno);
   fclose ($log);
   return;
}

fputs ($fp, $header . $req);

$res="";
while (!feof($fp))
   $res .= fgets ($fp, 1024);
fclose ($fp);

if (strpos($res, "VERIFIED")===FALSE)
{
   fwrite($log,"ERROR - UnVERIFIIED payment\r\nPayPal response:");
   fwrite($log,$res);
   fclose($log);
   return;
}

fwrite($log,"payment VERIFIIED\r\n");

if ($_POST["payment_status"]!="Completed")
{
   if ($_POST["payment_status"]=="Pending" )
{
   fwrite($log,"ERROR - payment status is not Completed - $_POST[payment_status] | $_POST[pending_reason]\r\n");
   fclose($log);
// � ��� �������� ����� ��� ����������, �� ��������� ������������� ������ �� ������� �����������
// ����� ������ �����, �� ��� �� ������ � ����� ���������������.
   return;

}

   fwrite($log,"ERROR - payment status is not Completed - $_POST[payment_status] | $_POST[pending_reason]\r\n");
   fclose($log);
   return;
   //update order status

}

if ( (!(isset($_POST[item_number]))) and (isset($_POST[item_number1])) )
	{
	$_POST[item_number]=$_POST[item_number1];
	}
	

fwrite($log,"OK - payment received $_POST[item_number].\r\n");
fclose($log);
// ��� �������� ����� ����������.
// ������ ��� �� ����� ��������
$resultCode=300;
if (($_POST['item_number']>0) and ($_POST['payment_status']=='Completed') )
	{
	include "connect.php";
	include "functions.php";
	include "bank_functions.php";	
	include "config_ko.php";
	include "clan_kazna.php";
	//�������� ������
	$order_id=(int)($_POST['item_number']);
	$transaction_id=$_POST['ipn_track_id'];
	$sender_mail=$_POST['payer_email'];
	mysql_query("update oldbk.trader_balance_paypal set `status`=1 ,  `transaction_id`='{$transaction_id}' , `sender_mail`='{$sender_mail}'   where `id`='{$order_id}' and `status`=0  ;");  
	if (mysql_affected_rows()>0)
	{
	//������ ��������� �������� ������ ������ 
	 $qiwi=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.trader_balance_paypal WHERE `id`='{$order_id}' ;"));
	addchp ('Debug PayPal 1:'.$qiwi[owner_id].'/PARAM:'.$qiwi[param].'/SUM:'.$qiwi[sum_ekr],'{[]}Bred{[]}');		
	 
	  	  if ((($qiwi[id]>0) and ($qiwi[owner_id]>0)  and ($qiwi[sum_ekr]>0)) and ($qiwi[param]==300) ) //��������� 
			  {
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 

				if ($tonick['id']) 
				{
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
					
	
				mysql_query("UPDATE ".$cit[$tonick[id_city]]."`users` SET  `rep`=`rep`+'$add_rep'  WHERE `id`= '".$tonick['id']."' LIMIT 1;"); 
				mysql_query("UPDATE ".$cit[$tonick[id_city]]."`users` SET  `repmoney` = `repmoney` + '$add_rep' WHERE `id`= '".$tonick['id']."' LIMIT 1;"); 
				if (mysql_affected_rows()>0)
				{
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','300','{$tonick[login]}','{$balamount}');");

					      // ���������
						CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('124836','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
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
					$rec['target']=124836;
					$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
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
					$rec['add_info']=iconv("CP1251","CP1251",'�����: PayPal. ������ ��� �� '.$tonick[repmoney]. ' ����� ' .($tonick[repmoney]+$add_rep).$add_bonus_str);
					add_to_new_delo($rec); //�����
					$tonick[repmoney]+=$add_rep;
					
					telepost_new($tonick,'<font color=red>��������!</font> ��� ��������� '.$add_rep.' ���������. ������� ����!'); 
					
					if ($add_bonus_str_chat!='')
						{
						telepost_new($tonick,$add_bonus_str_chat); 
						}
					
					$dil['id']=124836;
					$dil['login']=iconv("CP1251","CP1251",'DarliBank');
					$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}' and owner='{$tonick[id]}'; "));
					
					if ($get_bankid['id']>0)
						{
						//make_ekr_add_bonus($tonick,$get_bankid,$balamount,$dil);
						}
						
					make_discount_bonus($tonick,$balamount,3);	
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$qiwi[sum_ekr]}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�	
					  $resultCode=0;
				}
				else
			 	{
			       	$resultCode=300;	 	
			 	}	
				
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
			  }
			else
			   if ((($qiwi[id]>0) and ($qiwi[owner_id]>0)  and ($qiwi[sum_ekr]>0)) and ($qiwi[param]==666) ) //��������� 
			  	{
  				
			  	//��������� �������� ���������� ����� �����
		  	  	$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				
				  	 $tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE id='{$qiwi[owner_id]}'  LIMIT 1;"));
				 	  $dbc='oldbk.';
	 	  			  if ($tonick[id_city]==1)
					  {
					  $tonick = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE id='{$qiwi[owner_id]}' LIMIT 1;"));				
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
								

				if (put_to_kazna($klan_name[id],2,$add_klan_kazna_ekr,$klan_name[short],$tonick,$coment=iconv("CP1251","CP1251",'���������� ����� PayPal, �� ��������� '.$tonick[login]) ))
			   	{
				$fc_nom=100000000+$klan_name[id];
				$fc_name=iconv("CP1251","CP1251",'����-�����:�'.$klan_name[short].'�');
				
				mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fc_nom}','".$fc_name."','{$balamount}');");							
				mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�	
				
				if ($ko_bonus > 0)  {  mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('',450,'".iconv("CP1251","CP1251",'KO')."','{$fc_nom}','{$fc_name}','{$ko_bonus}');"); }
				if ($addbonekr>0) {  mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('',450,'".iconv("CP1251","CP1251",'KO')."','{$fc_nom}','{$fc_name}','{$addbonekr}');"); }
				
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> �������� ������ �������� ����� �� '.($add_klan_kazna_ekr).' ���. '));	
		   		}			
		   			else
		   			{
					addchp (iconv("CP1251","CP1251",'<font color=red>��������!</font>���������� �����, ������ ������ paypal, �� ������ ���������, teloid:'.$tonick[id]),'{[]}Bred{[]}',-1,-1); 			       				 			   		
				       	$resultCode=300;
		   			}
				}
			else
				{
				addchp (iconv("CP1251","CP1251",'<font color=red>��������!</font>���������� �����, ������ ������ , �� ��� �� ������/���������� �����, teloid:'.$tonick[id]),'{[]}Bred{[]}',-1,-1); 			       				 			   		
			       	$resultCode=300;
				}				

	  	
		  	    $resultCode=0;
			    
			  }
				else if ( ($qiwi['owner_id']>0) and ($qiwi['param']==10000) and ($qiwi['sub_trx'] > 0) )
				{
				//��������� �������� �����
					$tonick = check_users_city_data($qiwi['owner_id']);
					$balamount = $qiwi['sum_ekr'];
					$bankid =$qiwi['bank_id'];
					$param=$qiwi['param'];
					$PaymentMethod='paypal';
			  		
					if ($tonick['id']>0)
					{
							$fid = $param; // param
						
							$get_sub_trx=mysql_fetch_array(mysql_query("select * from `oldbk`.`trader_partn_trans` where id='{$qiwi['sub_trx']}' limit 1; "));
														
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
													mysql_query("INSERT INTO oldbk.`dilerdelo` (sub_trx,paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('{$get_sub_trx['id']}','{$PaymentMethod}','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$balamount}','{$bankid}' );");
													mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�	
						
												      	// ���������
													CheckRealPartners($tonick['id'],$balamount,0);
													     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
													     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
													     if ($p_user['partner']!='' and $p_user['fraud']!=1)
													      {
													       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('124836','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
													       $id_ins_part_del=mysql_insert_id();
													       $bonus=round(($balamount/100*$partner['percent']),2);
													       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
													      }
									
																			//������ � ����!
																			$rec['owner']=$tonick[id];
																			$rec['owner_login']=$tonick[login];
																			$rec['owner_balans_do']=$tonick['money'];
																			$rec['owner_balans_posle']=$tonick['money'];
																			$rec['target']=124836;
																			$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
																			$rec['type']=5858;
																			$rec['sum_kr']=0;
																			$rec['sum_ekr']=$balamount;
																			$rec['sum_kom']=0;
																			$rec['item_id']='';
																			$rec['add_info'] = iconv("CP1251","CP1251",'������ ����� �'.$get_sub_trx['id'].' - '.$ger_par_info['par_serv_desc'].',  ����� Paypal '.$balamount);
																			add_to_new_delo($rec);
													
													telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ������ ������� ���� �'.$get_sub_trx['id'].' - '.$ger_par_info['par_serv_desc'].'. ������� ����!')); 
													$resultCode=0;
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
						else
						{
						$resultCode=800;
						}
			} 
			elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==88000||$qiwi[param]==88200||$qiwi[param]==88500||$qiwi[param]==881000) ) //���������  ������� ������� ����� 200-500-1000
			  {
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];	

					$fid = 3003060; // �������  ������� ������� ����� �������
					if ($qiwi[param]==88000) 
						{ 
						 $kol=$balamount*20;
						}
					elseif ($qiwi[param]==88200) { $kol=200; }
					elseif ($qiwi[param]==88500) { $kol=500; }
					elseif ($qiwi[param]==881000) { $kol=1000; }
					
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
					mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$balamount}','{$qiwi[bank_id]}' );");
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$balamount}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										

				      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
											//������ � ����!
											$rec['owner']=$tonick[id];
											$rec['owner_login']=$tonick[login];
											$rec['owner_balans_do']=$tonick['money'];
											$rec['owner_balans_posle']=$tonick['money'];
											$rec['target']=124836;
											$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
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
					}
					else
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal: Pay:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
						
				 $resultCode=0;
							
			  
		}
			else if ((($qiwi[id]>0) and ($qiwi[bank_id]>0) and ($qiwi[sum_ekr]>0)) and (($qiwi['param']==602||$qiwi['param']==603||$qiwi['param']==606 ) ) ) 
			{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];	
				
				$sklonka = $qiwi['param']-600;
				$ali_cos=15;	
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
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$sklonka}','{$tonick[login]}','{$ali_cos}','{$qiwi[bank_id]}' );");
						//������
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$ali_cos}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										

						
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
						$rec['target']=124836;
						$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
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
						mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tonick['id']."','".iconv("CP1251","CP1251","����� &quot;DarliBank&quot; �������� &quot;").$tonick['login']."&quot; ".$skl2." ".iconv("CP1251","CP1251","����������")."','".time()."');");
						//� ���
						telepost_new($tonick,'<font color=red>'.iconv("CP1251","CP1251","��������! ").'</font> '.iconv("CP1251","CP1251","������� ������ ���������� �1 ��������� � ").'<a href="javascript:void(0)" onclick='.(!is_array($_SESSION['vk'])?"top.":"parent.").'cht("http://capitalcity.oldbk.com/myabil.php#my")>'.iconv("CP1251","CP1251","������ ����� ������ ��������").'</a>.');	
						
						//�������� �����
						$dil['id']=124836;
						$dil['login']='DarliBank';
						present_bonus_sert($tonick,$dil);						
						
					}
				else
					{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> Paypay: Pay:{$amount} Param {$param} , UserID {$tonick[id]}, new-align error . ');");							    										
					}
			 $resultCode=0;
			}			
			else if ((($qiwi[id]>0) and ($qiwi[bank_id]>0) and ($qiwi[sum_ekr]>0)) and (in_array($qiwi['param'],$leto_bukets) ) ) // ������� �������
			  {
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];	
				
				$fid = $qiwi['param'];
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['prototype'] = $fid;	
				$dress['unik'] = 2;
				
				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=1;
				$werrcount=0;
				$k=0;
				
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
					}
						else
						{
						$werrcount++;
						}
					
					
									      // ���������
					CheckRealPartners($tonick['id'],$balamount,0);
					     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
					     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
					     if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      {
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal: Pay:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
							
			  
		}				  
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==94) ) //���������  ������� �����
			  {
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];	
				$fid = 2014103;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
				$dress['ecost'] = 5;
				$dress['prototype'] = $fid;	
				$dress['present'] =iconv("CP1251","CP1251",'�����');		
				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=1;
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal: Pay:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
							
			  
		}
	  	elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==60) ) //���������  ������� �����
			  {
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];	
				$fid = 56664;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 15;
				$dress['prototype'] = $fid;	

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal: Pay:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
							
			  
		}		
  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==90||$qiwi[param]==89) ) //���������  �������  ���������
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = 4016;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 3;
				$dress['goden']=90;
				$dress['ekr_flag']=1;
				$dress['prototype'] = $fid;	
	
				if ($qiwi[param]==89)
						{
						$prise=2;						
						}
						else
						{
						$prise=3;
						}

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$prise); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$prise}','{$qiwi[bank_id]}' );");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 				
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}		
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==81) ) //���������  �������  
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = 3001005;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['prototype'] = $fid;	

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 				
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}		
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==91) ) //���������  �������  
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = 100199;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 5;
				//$dress['present'] =iconv("CP1251","CP1251",'����');	
				$dress['prototype'] = $fid;	

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 				
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and (in_array($qiwi['param'],$exprun_param))  ) //���������  �������  ������ ����� ���
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = $qiwi['param'];
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
					
				$dress['ecost']=$exprun_prise[$fid];
				$dress['prototype'] = $fid;	
				$dress['ekr_flag']=1;		

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 				
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and (in_array($qiwi['param'],$artup_param))  ) //���������  �������  ������ ����� ���
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = $qiwi['param'];
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
					
				$dress['ecost']=$artup_prise[$fid];
				$dress['prototype'] = $fid;	
	

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 				
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}				
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==51 or $qiwi[param]==52 or $qiwi[param]==53 ) ) //���������  �������  
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
						if ($qiwi[param]==53)
						{
							$fid = 14200;
						}
						else				
						if ($qiwi[param]==51)
						{
							$fid = 2016614;
						}
						else
						{
							$fid = 2016615;
						}
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));

						if ($qiwi[param]==53)
						{
						$dress['ecost'] = 50;
						}
						else					
						if ($qiwi[param]==51)
						{
						$dress['ecost'] = 5;
						}
						else
						{
						$dress['ecost'] = 2;
						}
				$dress['prototype'] = $fid;	
				$dress['ekr_flag']=1;		
				
						
					if ( ($qiwi[param]==51) or ($qiwi[param]==52) )						
						{
						$dress['dategoden']=mktime(23,59,59,7,11,2016); 
						$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); if ($dress['goden']<1) {$dress['goden']=1;}				
						}

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 				
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}				
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==84) ) //���������  ������� ���
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = 2016001;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
				$dress['ecost'] = 5;
				$dress['prototype'] = $fid;	
				
				$dress['dategoden'] = mktime(23,59,59,5,2); //���� �������� ��� �� 23:59 2 ���.
				$dress['goden'] = round(($dress['dategoden']-time())/60/60/24); 
				if ($dress['goden']<1) {$dress['goden']=1;}
				
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");

						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}			
	  		elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==95) ) //���������  ������� ��������
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = 3006000;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='{$fid}' ;"));
				$dress['ecost'] = 1;

				$dress['prototype'] = $fid;	

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$fid}','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						make_ekr_add_bonus($tonick,$bank,null,1,1);
						$bank['ekr']+=1;
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",') � ��������� ').($k).iconv("CP1251","CP1251",' ��� �� ���������� ���� �').$bankid.iconv("CP1251","CP1251",'. ������� ����!!')); 
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}	
	elseif (($qiwi[id]>0) and ($qiwi[owner_id]>0) and ($qiwi[bank_id]>0)  and ($qiwi[sum_ekr]>0) and ($qiwi[param]==92) ) //���������  ������� ����������
		{
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				if (($tonick['id'])  )
				{	
				$fid = 910;
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$fid}' ;"));
				$dress['ecost'] = 1;
				$dress['prototype'] = $fid;	

				$bank=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}'   LIMIT 1;"));
				$kol=round($balamount/$dress['ecost']); //����� ����� � ��� ����� �� ��������� = ���������� ����������
				$werrcount=0;
				$k=0;
				for ($i=0;$i<$kol;$i++) 
					{
					if (by_item_bank_dil($tonick,$dress,null,1))
					{
					$k++;
						mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','555','{$tonick[login]}','{$dress['ecost']}','{$qiwi[bank_id]}' );");
						mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$dress['ecost']}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
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
					       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
					       $id_ins_part_del=mysql_insert_id();
					       $bonus=round(($balamount/100*$partner['percent']),2);
					       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					      }
	
					
				if ($k>0)
				{
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",'). ������� ����!!')); 
				}					
					
					if ($werrcount>0)
						{
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('14897','','<font color=red>Warning!</font> paypal:{$amount} Param {$param} , UserID {$tonick[id]}, werrcount:{$werrcount} . ');");							    										
						}
				 $resultCode=0;
				}
			 	else
			 	{
			       	$resultCode=300;	 	
			 	}			
			  
		}			
			else
	  	  if ((($qiwi[id]>0) and ($qiwi[owner_id]>0)  and ($qiwi[sum_ekr]>0)) and ($qiwi[param]==33333) ) //���������   
			  {
			    //������� ����
    				$cit[0]='oldbk.';
				$cit[1]='avalon.';
				$cit[2]='angels.';	
				
			    $tonick = check_users_city_data($qiwi[owner_id]);
			
				$balamount = number_format($qiwi[sum_ekr],2,'.','');
				
				$bilprice=2; //2 ��� - �����
				$kol=round($balamount/$bilprice);
				
				if ($tonick['id']) 
				{
				
				$get_lot=mysql_fetch_array(mysql_query("select * from oldbk.item_loto_ras where status=1 LIMIT 1;"));
				if ($get_lot[id] >0)
				     {
					//if (($get_lot[lotodate]-300) >=time() ) // ��������� �����
					{
					for ($kkk=1;$kkk<=$kol;$kkk++)
					{
					if(mysql_query("INSERT INTO oldbk.`item_loto` SET `loto`={$get_lot[id]},`owner`={$tonick[id]},`dil`=124836,`lotodate`='".date("Y-m-d H:i:s",$get_lot[lotodate])."';"))
					{
					$good = 1;
					$new_bil_id=mysql_insert_id();
					mysql_query("INSERT INTO oldbk.`inventory` (`getfrom`,`name`,`duration`,`maxdur`,`cost`,`owner`,`nlevel`,`nsila`,`nlovk`,`ninta`,`nvinos`,`nintel`,`nmudra`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nalign`,`minu`,`maxu`,`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`img`,`text`,`dressed`,`bron1`,`bron2`,`bron3`,`bron4`,`dategoden`,`magic`,`type`,`present`,`sharped`,`massa`,`goden`,`needident`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`letter`,`isrep`,`update`,`setsale`,`prototype`,`otdel`,`bs`,`gmp`,`includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`,`gmeshok`,`tradesale`,`karman`,`stbonus`,`upfree`,`ups`,`mfbonus`,`mffree`,`type3_updated`,`bs_owner`,`nsex`,`present_text`,`add_time`,`labonly`,`labflag`,`prokat_idp`,`prokat_do`,`arsenal_klan`,`repcost`,`up_level`,`ecost`,`group`,`ekr_up`,`unik`,`add_pick`,`pick_time`,`sowner`,`idcity`,`ekr_flag`)
					VALUES (30,'".iconv("CP1251","CP1251",'���������� ����� �����')."',0,1,0,{$tonick[id]},0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'oldbkloto.gif','',0,0,0,0,0,0,0,210,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'".iconv("CP1251","CP1251","����� �".$new_bil_id."<br>����� �".$get_lot[id]."<br>C�������� ".date("Y-m-d H:i:s",$get_lot[lotodate]))."',1,'".date("Y-m-d H:i:s")."',0,33333,'6',0,0,0,0,0,'',0,0,0,0,0,0,0,{$get_lot[id]},0,0,{$new_bil_id},0,0,0,NULL,0,0,0,0,NULL,'',0,0,2,0,NULL,0,NULL,NULL,0,'{$tonick[id_city]}','1');");
					$dress[id]=mysql_insert_id();
					$dress[idcity]=$tonick[id_city];
					}
					else 
					{
						$good = 0;
					}

				if ($good) 
					{
					mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr,addition) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','0','{$tonick['login']}','$bilprice','33333');");
					$id_ins_part_del=mysql_insert_id();
					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=124836;
					$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
					$rec['type']=54;//������� ������� �� �������
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$bilprice;
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($dress);
					$rec['item_name']=iconv("CP1251","CP1251",'���������� ����� �����');
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
					$rec['add_info']=iconv("CP1251","CP1251",'����� PayPal');
					add_to_new_delo($rec); //�����


					  // ���������
					CheckRealPartners($tonick['id'],$bilprice,0);
				    	 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
				     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	  if ($p_user['partner']!='' and $p_user['fraud']!=1)
					      	 {
				       	 	mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('124836','{$partner['id']}','{$tonick['id']}','{$bilprice}','0','".time()."');");
					      	 $bonus=round(($bilprice/100*$partner['percent']),2);
					      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$bilprice}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
					     	 }
					}
					}
					
					if ($good) 
					{
					 $resultCode=0;
					 
					 if ($tonick['odate'] > (time()-60) )
					{
						addchp(iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� <b>���������� ����� ����� x'.$kol.' </b>. ������� �� �������!'),'{[]}'.$tonick['login'].'{[]}',$tonick['room'],$tonick['id_city']);
					} else {
						// ���� � ���
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$tonick['id']."','','".iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� <b>���������� ����� ����� x'.$kol.'</b>. ������� �� �������! ')."');");
					}
					 
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$qiwi[sum_ekr]}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank� 
					 
					}
					else
				 	{
				       	$resultCode=300;	 	
				 	}
					
				    }
				
				}
				else
			 	{
			       	$resultCode=300;	 	
			 	}	
				
				}
				else
			 	{
			       	$resultCode=300;	 	
			 	}	
			    
			    
			    }
	 else
	  if ((($qiwi[id]>0) and ($qiwi[bank_id]>0) and ($qiwi[sum_ekr]>0)) and ($qiwi[param]==0) )
	  {
	  //��������� ���
	  
	  $tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE id='{$qiwi[owner_id]}'  LIMIT 1;"));
	  if ($tonick[id_city]==1)
	  {
	  $tonick = mysql_fetch_array(mysql_query("SELECT * FROM avalon.`users` WHERE id='{$qiwi[owner_id]}' LIMIT 1;"));				
	  }
	  

				/*  if (BONUS_REAL_PREM)
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
					$add_ekr_to_kazna=round($qiwi[sum_ekr]*0.5,2);
						
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
					$ko_bonus=round(($qiwi[sum_ekr]*($pbm+$KO_A_BONUS)) ,2); 
				}
				elseif ((time()>$KO_start_time38) and (time()<$KO_fin_time38)) 
				{
					$kb=act_x2bonus_limit($tonick,1,$qiwi[sum_ekr]);
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
					$ko_bonus=round(($qiwi[sum_ekr]*$pbm) ,2);
				}
	  
	  mysql_query("UPDATE `oldbk`.`bank` SET `ekr` = `ekr` + '".($qiwi[sum_ekr]+$ko_bonus)."' WHERE `id`= '{$qiwi[bank_id]}' LIMIT 1;");
	  
	///����� � ������� �����
	mysql_query("INSERT INTO `oldbk`.`exchange_log` SET `owner`='{$qiwi[owner_id]}' , `dilekr`='".($qiwi[sum_ekr]+$ko_bonus)."'  ON DUPLICATE KEY UPDATE dilekr=dilekr+'".($qiwi[sum_ekr]+$ko_bonus)."' ");
	  
	  if (mysql_affected_rows()>0)
	      {
		$rezbank = mysql_fetch_array(mysql_query("SELECT * FROM `oldbk`.`bank` WHERE `id`= '{$qiwi[bank_id]}' ;"));
	      
	 				 //new_delo
  		    			$rec['owner']=$qiwi[owner_id]; 
					$rec['owner_login']=$qiwi['owner'];
					$rec['target']=124836;
					$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
					$rec['type']=261;
					$rec['sum_ekr']=$qiwi[sum_ekr]+$ko_bonus;
					$rec['bank_id']=$qiwi[bank_id];
					$rec['add_info']=iconv("CP1251","CP1251",'���������� PayPal');
					add_to_new_delo($rec); 
					mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$qiwi[bank_id]}','".$qiwi['owner']."','{$qiwi[sum_ekr]}');");					
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','".iconv("CP1251","CP1251","�� ��������� ���� ����  �� ����� <b>{$qiwi[sum_ekr]}</b> ���. <i>(�����: {$rezbank['cr']} ��., {$rezbank['ekr']} ���.)</i>")."','{$qiwi[bank_id]}');");					
					
					telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> �� ��� ���� �'.$qiwi[bank_id].' ���������� '.($qiwi[sum_ekr]).' ���. ������� �� �������!'));	
					
					//������ ��� ������
					if ($ko_bonus > 0)					
					{
					mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr) values ('','450','".iconv("CP1251","CP1251",'KO')."','{$qiwi[bank_id]}','".$qiwi['owner']."','{$ko_bonus}');");					
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','".iconv("CP1251","CP1251","����� �� ������� ������������ <b>{$ko_bonus}</b> ���.")."','{$qiwi[bank_id]}');");		
					
					if ((time()>$KO_start_time) and (time()<$KO_fin_time)) 
							{
							telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> �� ��� ���� �'.$qiwi[bank_id].' ��������� ����� '.($ko_bonus).' ���. � ������ <a href="http://oldbk.com/encicl/?/act_ekr.html" target="_blank">�����</a>. '));	
							}
					elseif ((time()>$KO_start_time38) and (time()<$KO_fin_time38)) 
							{
							telepost_new($tonick,'<font color=red>��������!</font> �� ��� ���� �'.$qiwi[bank_id].' ���������� '.$ko_bonus.' ���. ��  ������������� ������, � ������ ����� <a href="http://oldbk.com/encicl/?/act_x2bonus.html" target="_blank">�������� ������</a>. ����� �������� �������� � �� ���������������� �� ����������� ������� ���� ������.');	
							}
							else
							{
							$yyy[1]='Silver';
							$yyy[2]='Gold';
							$yyy[3]='Platinum';
							
							telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> �� ��� ���� �'.$qiwi[bank_id].' ��������� ����� '.($ko_bonus).' ���. �� ������� "'.$yyy[$tonick[prem]].' account" '));
							}
					
								
					}

					 // ���������
					CheckRealPartners($qiwi[owner_id],$qiwi[sum_ekr],0);
					 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$qiwi[owner_id]}' LIMIT 1;"));
				     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
				   	 if ($p_user['partner']!='' and $p_user['fraud']!=1)
				       {
				       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('124836','{$partner['id']}','{$qiwi[owner_id]}','{$qiwi[sum_ekr]}','{$qiwi[bank_id]}','".time()."');");
				      	 $bonus=round(($qiwi[sum_ekr]/100*$partner['percent']),2);
				      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$qiwi[sum_ekr]}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
				      }
					
					$dil['id']=124836;
					$dil['login']=iconv("CP1251","CP1251",'DarliBank');
					$get_bankid=mysql_fetch_array(mysql_query("select * from oldbk.bank where id='{$qiwi[bank_id]}' and owner='{$tonick[id]}'; "));
					if ($get_bankid['id']>0)
						{
						//make_ekr_add_bonus($tonick,$get_bankid,$qiwi[sum_ekr],$dil);
						}
					
					make_discount_bonus($tonick,$qiwi['sum_ekr'],2);	
					
	       $resultCode=0;
      					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$qiwi[sum_ekr]}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�
	       }
	       else
	       {
	       	$resultCode=300;
	       }
	       	  	  
	  }
	  else if ((($qiwi[id]>0) and ($qiwi[bank_id]>0) and ($qiwi[sum_ekr]>0)) and (in_array($qiwi[param],$akks_types))  )
	  {
	  //��������� �����
	  
					  if ($qiwi[param]>300)
						{
						//�������
						$sub_type=$qiwi[param]-300;
						$qiwi[param]=3;
						}
						elseif ($qiwi[param]>200)
						{
						//����
						$sub_type=$qiwi[param]-200;
						$qiwi[param]=2;
						}
						else
						{
						//�������
						$sub_type=$qiwi[param]-100;
						$qiwi[param]=1;
						}
	  
		$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '{$qiwi[owner_id]}' LIMIT 1;"));
		$tonick = check_users_city_data($tonick[id]);
		
		$chbnkpr= mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = '".$tonick[id]."' AND id='".$qiwi[bank_id]."' LIMIT 1;"));
		if($tonick[id]>0 && $chbnkpr[id]>0)
		{
			if ( (($tonick[prem]==$qiwi[param]) or ($tonick[prem]==0) ) and ($tonick[id]>0))		    
		    	{
		    	$dill[id_city]=0;
		    	$dill[id]=124836;
		    	$dill[login]='DarliBank';
		    	$dill[paysys]='paypal';		    	
		    	
		    		$exp=main_prem_akk($tonick,$qiwi[param],$dill,$sub_type);
				if ($exp>0)
					{
					by_prem_from_bank($tonick,$qiwi[param],$chbnkpr,$exp,$dill,$sub_type);
					
					$resultCode=0;	 	
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$qiwi[sum_ekr]}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�					
					}
				 	else
				 	{
		       			$resultCode=300;
 							//addchp ('<font color=red>��������!</font>Debug1 qiwi','{[]}Bred{[]}'); 			       				 	
				 	}
		    	}
		 	else
		 	{
		       	$resultCode=300;	 	
 							//addchp ('<font color=red>��������!</font>Debug2 qiwi','{[]}Bred{[]}'); 			       	
		 	}
	  	}
	  	else
	 	{
		       	$resultCode=300;	
 							//addchp ('<font color=red>��������!</font>Debug3 qiwi','{[]}Bred{[]}'); 	
	 	}
	  }
	  
	 else if ((($qiwi[id]>0) and ($qiwi[bank_id]>0) and ($qiwi[sum_ekr]>0)) and (($qiwi[param]>=2014001) and ($qiwi[param]<=2014004) )  )
	  {
	  //��������� ������
		$tonick = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `id` = '{$qiwi[owner_id]}' LIMIT 1;"));
		$tonick = check_users_city_data($tonick[id]);
		
		$par=$qiwi[param];
		$lartid=$par;
		if (test_larec($larec_type[$par],$tonick))
			{
			//���� �� ������� ����� ������ - ������ �����
				$get_my_box=mysql_fetch_array(mysql_query("select * from oldbk.boxs where box_type='{$larec_type[$par]}' and item_id=0 ORDER BY id  LIMIT 1"));
				if ($get_my_box[id] > 0) {
					$dress=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id='{$lartid}' ;"));
					if ($dress[id]>0)  {
						mysql_query("update oldbk.boxs set item_id=1 where id='{$get_my_box[id]}' ;");
						if (mysql_affected_rows() > 0) {
						
							$goden_do = mktime(23,59,59,1,31,date("Y")+1); 
							$goden = round(($goden_do-time())/60/60/24); if ($goden<1) {$goden=1;}
								
								if(mysql_query("INSERT INTO oldbk.`inventory`
									(`getfrom`,`prototype`,`owner`, `sowner` ,`name`,`type`,`massa`,`cost`, `ecost`, `img`,`maxdur`,`isrep`,
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
									mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,bank,owner,ekr,addition) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','{$qiwi[bank_id]}','".$qiwi['owner']."','{$qiwi[sum_ekr]}','2013');");														
									mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$qiwi[sum_ekr]}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�										
									//new_delo
				  		    			$rec['owner']=$tonick['id'];
									$rec['owner_login']=$tonick['login'];
									$rec['owner_balans_do']=$tonick['money'];
									$rec['owner_balans_posle']=$tonick['money'];
									$rec['target']=83;
									$rec['target_login']=iconv("CP1251","CP1251",'������������ �����');
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
									$rec['add_info']=iconv("CP1251","CP1251",'����� PayPal');
									add_to_new_delo($rec); //�����
	
									mysql_query('INSERT INTO oldbk.boxs_history (`owner`,`box_type`,`selldate`) VALUES("'.$tonick['id'].'","'.$larec_type[$par].'","'.date("d/m/Y").'")');
									
									 // ���������
									CheckRealPartners($qiwi[owner_id],$qiwi[sum_ekr],0);
									 $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$qiwi[owner_id]}' LIMIT 1;"));
								     	 $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
								   	 if ($p_user['partner']!='' and $p_user['fraud']!=1)
									      {
									       	 mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$qiwi[owner_id]}','{$qiwi[sum_ekr]}','{$qiwi[bank_id]}','".time()."');");
									      	 $bonus=round(($qiwi[sum_ekr]/100*$partner['percent']),2);
									      	 mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$qiwi[sum_ekr]}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
									      }
									      
									telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress['name'].iconv("CP1251","CP1251",'</b> 1��. ������� ����!!'));	
									      
		     	 						$resultCode=0;	 
								}
								else
									{
									// ����� ���� ��� ������ ���� �������� �������������
									telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ������! ���������� �������� ����� - �������� �������������!. '));	
								       	$resultCode=304;
									}
						} 
						else
						{
						// ����� ���� ��� ������ ���� �������� �������������
						telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ������! ���������� �������� ����� - �������� �������������!. '));	
					       	$resultCode=303;
						}
						
		   			} 
				}
				else
				{
				// ����� ���� ��� ������ ���� �������� �������������
				telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ������! ���������� �������� ����� - �������� �������������!. '));	
			       	$resultCode=302;
				}

			}
			else
			{
			// ����� ���� ��� ������ ���� �������� �������������
			telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ������! ���������� �������� ����� - �������� �������������!. '));	
		       	$resultCode=301;
			}
	  }
else if ((($qiwi[id]>0) and ($qiwi[bank_id]>0) and ($qiwi[sum_ekr]>0)) and (in_array($qiwi[param],$bukets) ) )
	  	{	
  		addchp ('Debug 2 paypal if:'.$qiwi[owner_id].'/PARAM:'.$qiwi[param].'/SUM:'.$qiwi[sum_ekr],'{[]}Bred{[]}');			  	
 			 //������� ����
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				require_once('ny_events.php');
				
				if (($tonick['id']) AND ((time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend'])) ) 
				{
				$tobank	= mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = '{$bankid}' LIMIT 1;"));
				$elkaid=(int)$qiwi[param];
				$prise=$bukets_prise[$elkaid];
				
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
					
					mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','2011','{$tonick[login]}','{$prise}','{$qiwi[bank_id]}' );");
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$prise}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�																											
					
					//new_delo
  		    			$rec['owner']=$tonick[id];
					$rec['owner_login']=$tonick[login];
					$rec['owner_balans_do']=$tonick['money'];
					$rec['owner_balans_posle']=$tonick['money'];
					$rec['target']=124836;
					$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
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
					$rec['add_info']=iconv("CP1251","CP1251",'����� PayPal');					
					add_to_new_delo($rec); //�����


												      // ���������
												     CheckRealPartners($tonick['id'],$balamount,0);
												     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
												     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
												     if ($p_user['partner']!='' and $p_user['fraud']!=1)
												      {
												       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('83','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
												       $id_ins_part_del=mysql_insert_id();
												       $bonus=round(($balamount/100*$partner['percent']),2);
												       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
												      }
					telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� �������� <b>').$bukname.iconv("CP1251","CP1251",'</b>. ������� ����!'));	
					$resultCode=0;	 
					/*
					//������ �� �����
					$dr=mysql_fetch_array(mysql_query("select * from oldbk.eshop where id=55555"));
					$dr['ecost'] = 1;
					$dr['prototype'] = 55555;
					$dr['sowner']=$tonick['id'];				
					$dr['present'] =iconv("CP1251","CP1251",'�����');							
					by_item_bank_dil($tonick,$dr,null);
					*/
		}		else  $resultCode=311;	 
		}	 	else  $resultCode=312;	 
		}	 	else  $resultCode=313;	 	  	
	}
	  else if ((($qiwi[id]>0) and ($qiwi[bank_id]>0) and ($qiwi[sum_ekr]>0)) and (in_array($qiwi[param],$podar) ) )
	  	{
	  	//������� ���������� ������������
				$tonick = check_users_city_data($qiwi[owner_id]);
				$balamount = number_format($qiwi[sum_ekr],2,'.',''); 
				$bankid=$qiwi[bank_id];
				$param=$qiwi[param];
				if ($tonick['id']) 
				{
				require_once('ny_events.php');
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
												
												mysql_query("INSERT INTO oldbk.`dilerdelo` (paysyst,dilerid,dilername,addition,owner,ekr,bank) values ('paypal','124836','".iconv("CP1251","CP1251",'DarliBank')."','55','{$tonick[login]}','{$prise}','{$qiwi[bank_id]}' );");

												//new_delo
													$rec=array();
								  		    			$rec['owner']=$tonick[id];
													$rec['owner_login']=$tonick[login];
													$rec['owner_balans_do']=$tonick['money'];
													$rec['owner_balans_posle']=$tonick['money'];
													$rec['target']=124836;
													$rec['target_login']=iconv("CP1251","CP1251",'DarliBank');
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
													$rec['add_info']=iconv("CP1251","CP1251",'����� PayPal');
													add_to_new_delo($rec); //�����
													
												mysql_query("UPDATE oldbk.`bank` set `ekr` = ekr+'{$ekr_bonus}' WHERE `id` = '{$bankid}' LIMIT 1;");
												$tobank['ekr']+=$ekr_bonus;
												mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','".iconv("CP1251","CP1251","����� �� ������� ����������� �����������<b> {$ekr_bonus} ���.</b>,<i>(�����: {$tobank[cr]} ��., {$tobank['ekr']} ���.)</i>")."','{$bankid}');");
												$total_summ+=$prise;
												telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> ��� ������� ������� <b>').$dress['name'].iconv("CP1251","CP1251",'</b> � ').$ekr_bonus.iconv("CP1251","CP1251",'��� �� ���� �').$bankid.iconv("CP1251","CP1251",'. ������� �� �������!'));	
													}
												}
											  } //for

												      // ��������� �� ��� �����
												CheckRealPartners($tonick['id'],$balamount,0);
												     $p_user = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners_users` WHERE `id` = '{$tonick['id']}' LIMIT 1;"));
												     $partner = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`partners` WHERE `id` = '{$p_user['partner']}' LIMIT 1;"));
												     if ($p_user['partner']!='' and $p_user['fraud']!=1)
												      {
												       mysql_query("INSERT INTO oldbk.`partners_delo` (dealer_id,partner_id,owner_id,ekr,bank,transfer_time) values ('124836','{$partner['id']}','{$tonick['id']}','{$balamount}','0','".time()."');");
												       $id_ins_part_del=mysql_insert_id();
												       $bonus=round(($balamount/100*$partner['percent']),2);
												       mysql_query("UPDATE oldbk.`partners` set `all_ekr` = `all_ekr`+'{$balamount}', `money`=`money`+'{$bonus}' WHERE `id` = '{$partner['id']}' LIMIT 1;");
												      }											
											  
									//�����
								//	make_ekr_add_bonus($tonick,$tobank,$total_summ,null);	

  			    		$resultCode=0;	 	
					mysql_query("UPDATE oldbk.`dealers` set `sumekr` = sumekr-'{$qiwi[sum_ekr]}' WHERE `owner` = '124836' LIMIT 1;"); //  �������  �� �������  DarliBank�
	  			        }	  	
  	
	  	}
	  else
	  {
	  $resultCode=210;
	  }
	  
	  			/* http://tickets.oldbk.com/issue/oldbk-2069#tab=Comments
				if (($resultCode==0) and ($tonick['id']>0) and ($qiwi[sum_ekr]>=500))
				{
				
				$dress=mysql_fetch_array(mysql_query("select * from oldbk.shop where id='636' ;"));
				$dress['present']=iconv("CP1251","CP1251",'�����������');
				if (by_item_bank_dil($tonick,$dress,null,1))
					{
					telepost_new($tonick,iconv("CP1251","CP1251",'<font color=red>��������!</font> �� �������� <b>').$dress[name].iconv("CP1251","CP1251",'</b> (x').$k.iconv("CP1251","CP1251",')  �� ������� ������� ������� ������.')); 
					}
				
				}
				*/


	}
	else
	{
	//������ - ��� ��� ����� ������
	$resultCode=210;
	}

	}
	
	$text = "status:".$resultCode;
	header('content-type: text/html; charset=UTF-8');
	echo $text;

?>