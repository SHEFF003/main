<?
//����� ���� ���� - �������


function get_voins($war_id,$stor)
{
global $klan;



$voin=array();
$get_voin=mysql_query("SELECT *  from oldbk.clans_war_new_voin where war_id='{$war_id}' order by level ");
/*
if ($user['id']==10638)
{
echo $stor;
echo "<br>";
echo "SELECT *  from oldbk.clans_war_new_voin where war_id='{$war_id}' order by level ";
}
*/

	while($row=mysql_fetch_array($get_voin))
		{
		
			if ($stor==$row['stor'])
				{
				//�������������� ���� �������
				
					if ($row['clan_id']==$klan['id'])
					{
					//����� �����
					$voin['my_clan'][$row['level']]+=$row['voin'];
					}
				$voin['my'][$row['level']]+=$row['voin'];	//����� �� �������				
				$voin['my']['total']+=$row['voin']; //�����
				}
				else
				{
				$voin['en'][$row['level']]+=$row['voin'];				
				$voin['en']['total']+=$row['voin'];				
				}
		
		}
return $voin;
}


function print_mk_war($whoklan,$rulit=0)
{
global $klan_kazna, $user, $klan ,$recrut,$wpers,$wteam;
//����� ���������� �����
$war_price[1]=100; //�������� �����
$war_price[2]=200; //���������� �����

$start_timer[1]=10800; //3 ���� �� ����������
$start_timer[2]=86400;//1 ����� �� ����������

$fin_timer[1]=$start_timer[1]+86400;//������� ������ ����� ����� ����������
$fin_timer[2]=$start_timer[2]+172800;//������� ������ 2 ����� ����� ����������

$prop_timer[1]=$fin_timer[1]+604800; //����� ����� ��� � ������ 7 ���� �������
$prop_timer[2]=$fin_timer[2]+604800; //����� ����� ��� � ������ 7 ���� �������

$protect_attak=86400; // ������: ���� ���� ������� ����� �� � ���� ���� ����� ����� �� ��������� � �����

/*
//�������� �������
$start_timer[1]=600; //3 ���� �� ����������
$start_timer[2]=600;//1 ����� �� ����������

$fin_timer[1]=$start_timer[1]+3600;//������� ������ ����� ����� ����������
$fin_timer[2]=$start_timer[2]+3600;//������� ������ 2 ����� ����� ����������

$prop_timer[1]=$fin_timer[1]+600; //����� ����� ��� � ������ 7 ���� �������
$prop_timer[2]=$fin_timer[2]+600; //����� ����� ��� � ������ 7 ���� �������
*/
$buff='';
$show_form=true;

	$havewar=chk_war($whoklan);

	if (is_array($havewar))
		{
		//���� �����
			//1. ���������  � ����� ��������� �����
				
			if ( (strtotime($havewar['ztime'])<=time() ) AND (strtotime($havewar['stime'])>=time() )  )
				{
				//����������
					if ($havewar['wtype']==1)
					{
					//�������� �����- ��� ����������� �������� �������					
					$buff.=err("� ��� �������� �����, � ��� ����������� �������� �������!");
					
					if ((($havewar['defender']==$klan['id'])OR($havewar['agressor']==$klan['id']))  and ($rulit==1))
					  {
						//�� ����� ����� - ����� ����� ��������� � ����� ������ ����� - �� ����� ��������� ������
						

							 if ($_SERVER['REQUEST_METHOD'] == "POST")
							 {
							 $buff.=do_naims($havewar,$rulit);
							 }
//echo "�����1:".$rulit;							 
							$buff.=show_naims();
					   }
					   else
						{
						//������� ����� ������� � �������
						//� ���� ���� ��� ��������
						}
					
					}
					elseif ($havewar['wtype']==2)
					{
					//echo "���������� � ����� - �������� ������";
					$buff.=err("� ��� ���������� �����, �� ����� ���������� ����� �������� �������!");

					if ((($havewar['defender']==$klan['id'])OR($havewar['agressor']==$klan['id']))  and ($rulit==1))	
					 {	
						      	if ($havewar['defender']==$klan['id'])
						      		{
						      		$stor='defender';
						      		$protiv=$havewar['agressor'];
						      		}
						      		else
						      		{
						      		$stor='agressor';
						      		$protiv=$havewar['defender'];
							      	}
					 
							//������� ������� ��� ������ ���� � ����� �������
							$get_ally_count=mysql_fetch_array(mysql_query("SELECT count(id) as kol  from oldbk.clans_war_new_ally where warid='{$havewar['id']}' and active=1 and {$stor}='{$klan['id']}' ;"));
							if ($get_ally_count['kol']>=2)
							{
							$buff.=err("� ��� ��� ���� ��� ����� � �������!");
							}
							else
							{
							//��������� 
						      	//����� ��� ������ �����  ��� �������
						      		if (strtotime($havewar['stime'])>=(time()+3600) ) 
						      		{
								$buff.=show_mk_ally($klan['id'],$havewar['id'],$rulit,$protiv,$stor);
								}
							}
				
						//����� ������� ��������� ����� ����� ��������� � ����� ������ �����
						 if ($_SERVER['REQUEST_METHOD'] == "POST")
						 {
						 $buff.=do_naims($havewar,$rulit);
						 }
						$buff.=show_naims();
						
					}
					 else
						{
						//������� ����� ������� � �������
							if (($havewar['clanid']==$klan['id']) and ($havewar['allyagr']>0))
							{
							$buff.="<br>�� ��� � ������� ������: ".$havewar['def_txt'];
							}
							elseif (($havewar['clanid']==$klan['id']) and ($havewar['allydef']>0))
							{
							$buff.="<br>�� ��� � ������� ������: ".$havewar['agr_txt'];						
							}
						}	
						
					}
					
					$buff.=err("<br> ����� </font> ".$havewar['agr_txt']." ������ ".$havewar['def_txt']." <br><font color=red> ��������:<b>".$havewar['stime']."</b>");
					
					
					if (($havewar['defender']==$klan['id']) and ($rulit==1)) 
							{
							//���� ������� ���� ������ � ���� ������ - � ���� ���� ����������� ����������  10 ��� ���������
								if ($klan['warcancel']<0)
								{
									//����� ���������
									if ($_POST['warcancel'])
									{
									$buff.=mk_warcancel($havewar,$klan);
									}
									else
									{
									$buff.= "<br>����� ���������� ��������� �� ����� ��� ".$klan['warcancel']." ���.<form method=POST>";
									$buff.= "<input type=submit name=warcancel value='����������'></form>";
									}
								}
								else
								{
								
								
								//����� �� ������
									if ($_POST['warcancel'])
									{
									$buff.=mk_warcancel($havewar,$klan);
									}
									else
									{
									$m=$klan['warcancel']*1000+1000;
									$buff.= "<br>����� ���������� �� ����� �� ".$m." ��.<form method=POST>";
									$buff.= "<input type=submit name=warcancel value='����������'></form>";
									}
								}
							}
					
				}
			else
				{
//				echo  "����� � ��������";
				$wrtxttype[1]='�������� �����';
				$wrtxttype[2]='���������� �����';				
				$buff.=err("<br> ".$wrtxttype[$havewar['wtype']]." </font> ".$havewar['agr_txt']." ������ ".$havewar['def_txt']."<br> <font color=red> ���������:<b>".$havewar['ftime']."</b><br>");	
				$buff.='<a href=towerlog.php?war='.$havewar['id'].' target=_blank> �� </a>';								

					if (($havewar['defender']==$klan['id']) OR ( $havewar['clanid']==$klan['id'] AND $havewar['allydef']>0) )
						{
						$my_side_is='def';							
						}
					elseif 	(($havewar['agressor']==$klan['id']) OR ( $havewar['clanid']==$klan['id'] AND $havewar['allyagr']>0) )
					 	{
						$my_side_is='agr';	
					 	}
				$buff.="<br>";
				if ($havewar['wtype']==2)
						{
						$voin=get_voins($havewar['id'],$my_side_is);


							
						$buff.=err("�������������� � ����� ������ �����: ".(int)($voin['my_clan'][0])." , ����� �������:<b>".(int)($voin['my']['total'])." ������ ".(int)($voin['en']['total'])."</b>");
						}
				elseif ($havewar['wtype']==1)
						{
						$voin=get_voins($havewar['id'],$my_side_is);
						$buff.="�������������� �� �������:
							<table border=1>
							<tr>
								<td>�������:</td>
								<td>��� ����</td>
								<td>���������</td>								
								<td>�����</td>									
							</tr>";
							$total_my_wins=0;
							$total_en_wins=0;							

							foreach ($voin['my'] as $lvl=>$val)
								{
							if ($lvl!='total')
								{
							$buff.="<tr>
								<td>".(int)($lvl)."</td>
								<td>".(int)($voin['my_clan'][$lvl])."</td>
								<td>".(int)($voin['en'][$lvl])."</td>";

								if ($val>$voin['en'][$lvl])
									{
									$buff.="<td><img src='http://i.oldbk.com/i/flag.gif' title='��� ���� ��������' alt='��� ���� ��������' border=0></td>";
									$total_my_wins++;
									}
									elseif ($val<$voin['en'][$lvl])
									{
									$buff.="<td>&nbsp;</td>";
									$total_en_wins++;
									}
									else
									{
									$buff.="<td>&nbsp;</td>";
									}
							$buff.="</tr>";
								}
								}
						$buff.="</table><br> ����� �����: $total_my_wins / $total_en_wins ";
						}
						
				$buff.="<br>";

					 	
				if ((($havewar['defender']==$klan['id'])OR($havewar['agressor']==$klan['id']))  and ($rulit==1))
					{
					//���� ������� ���� ������� ����� ��� ���� ������� ����������
					 
					 if (strtotime($havewar['ftime'])>=time()) //������ ������ �����������
					 	{
						//����� ����� ��������� � ����� ������ �����
						 if ($_SERVER['REQUEST_METHOD'] == "POST")
						 {
						 $buff.=do_naims($havewar,$rulit);
						 }
						$buff.=show_naims();
						}
					}
					else
					{
					//������� ����� ������� � �������
						if (($havewar['clanid']==$klan['id']) and ($havewar['allyagr']>0))
						{
							$buff.="<br>�� ��� � ������� ������: ".$havewar['def_txt'];
							$my_side_is='agr';							
						}
						elseif (($havewar['clanid']==$klan['id']) and ($havewar['allydef']>0))
						{
							$buff.="<br>�� ��� � ������� ������: ".$havewar['agr_txt'];		
							$my_side_is='def';
						}
					}
					
						if (strtotime($havewar['ftime'])>=time())
							{
							$start_bat=true;
							}
							else
							{
							$start_bat=false;
							}
					$buff.="<br>".print_do_attak($havewar,$my_side_is,$start_bat,$voin);
				}



		}
		else
		{
		//��� ����
		//��������� ������� �� ���������� � ������
		$arr_zay_all=chk_ally_req($whoklan);	

				//��������� ���������� ��� ����� ��������
		if ($rulit>0)
			{
				if ((($_GET['ally_yes']) AND ((int)($_GET['ally_yes'])>0)) and (is_array($arr_zay_all)) )
						{
						//������������� � ��������� � ������
						$ally_id=(int)($_GET['ally_yes']);
						$komu_row=$arr_zay_all[$ally_id];
						$nwrid=$komu_row['id']; //�� �����						
						
						
						// ��������� ��� ��������  ������  ��� ������� �� ����� ����� � ���� ����� - � ������� ����� ����� � ������
							if ($komu_row['allyagr']>0)
							{
							//���� ������ �� ���������� - ����� �������� ��� ��������
							$look_clan_protiv=$komu_row['defender'];//������ ����
							$look_clan_za=$komu_row['allyagr'];//�� ����
							$look_clan_za_txt=$komu_row['agr_txt'];//�� ���� �����
					      		$stor='agressor';
							}
							elseif ($komu_row['allydef']>0)
							{
							//� ��������
							$look_clan_protiv=$komu_row['agressor'];//������ ����
							$look_clan_za=$komu_row['defender']; //������
							$look_clan_za_txt=$komu_row['def_txt'];//�� ���� �����							
							$stor='defender';							
							}

						// ������ ���  �������� ������� -� ���� �����
						$get_all_ally=mysql_query("SELECT *  from oldbk.clans_war_new_ally where warid='{$nwrid}' and active=1");		
						$get_ally_count=0;
						$clan_all_protiv=array();
						$clan_all_protiv[0]=$look_clan_protiv;
						while($ally_row=mysql_fetch_array($get_all_ally))
							{
								if ($ally_row[$stor]==$look_clan_za)
									{
									//������� ���.�������� ������ � ������� �� ��� ���� ������� �������� �����
									$get_ally_count++;
									}
									else
									{
									//���������� �� ����� ������ �������� �������� �����
									$clan_all_protiv[]=$ally_row['clanid'];
									
									}
							}			
//print_r($clan_all_protiv);
//echo "<br>";
						// ��������� ������� ����� ������� ������ � ������ - ������ ���� ������ ����������
						/*
						foreach ($clan_all_protiv as $i=>$v)
							{
							$test_timers=get_timers_kl($klan['id'],$v);
							if (is_array($test_timers))
							 	{
							 	break;
							 	}
							}
						if (is_array($test_timers)) // ������
						 {
						  	$buff.=err("<br> ��� ���� �� ����� ����� � ���� ������, �.�. � ������ ����� �� ������� ����� ��������� �� ���� �� ������ ������� ����������!<br>");
						 }
						 else	*/
						
					   if($klan_kazna['kr']>=50) // ������� ����������� � ������ - 50��. (��������� �� �������� �����)
						{	
						$get_myclan_naim=mysql_fetch_array(mysql_query("select count(id) as kol  from oldbk.users where klan='{$klan['short']}' and naim_war='{$nwrid}' and  naim='{$look_clan_protiv}' and id_city=0")); //������� �� ����
//						$get_myclan_naim_ava=mysql_fetch_array(mysql_query("select count(id) as kol  from avalon.users where klan='{$klan['short']}' and naim_war='{$nwrid}' and  naim='{$look_clan_protiv}' and id_city=1")); //������� �� ���

						if ($get_myclan_naim['kol'] >0 )
						{
							$buff.=err("<br> ��� ���� �� ����� ����� � ���� ������, �.�. ��� ���������� ����� ��������� �� ������� ����������!<br>");
						}
						else
						{
					
						//�������� �������� �� ���������� ������ � ������� - ���� ������ 2� ��� �� ������ !!!
							if ($get_ally_count>=2)
							{
								$buff.=err("� ".$look_clan_za_txt." ��� ���� ��� ����� � �������!<br>");
							}
						else
							{
							$coment='�������� ����������� � ������.';
					   		if (by_from_kazna($klan['id'],1,50 ,$coment))							
							{
							// �����������  ��������� ����
							mysql_query("UPDATE oldbk.clans_war_new_ally  SET active=1  WHERE id='{$ally_id}' AND active=0 AND clanid='{$whoklan}' ;");
							 if (mysql_affected_rows()>0)
							{
							
								//��� �������� ���� ��� ����� ������ ������ �� ��������� �� �������� ������� - ��� ���� �����
								if ($get_ally_count>=1)
								{
								mysql_query("DELETE FROM  oldbk.clans_war_new_ally  WHERE warid='{$nwrid}'  AND active=0 ");
								}
							
							// ������� ��������� ������
							mysql_query("DELETE FROM oldbk.clans_war_new_ally WHERE id!='{$ally_id}' AND clanid='{$whoklan}' ;");
							
							//��������� ��� ����� � ��� �����
							$add_clan_a=getall_inf_clan($klan); //���� ����� ����� � �������� ���� ����
							$add_clan=$add_clan_a['html'];
				   		 	$nwt=$komu_row['wtype']; // ��� �����  �� ������� ���� ����� � ������
				   		 	
							$look_clan_protiv_name=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$look_clan_protiv.' LIMIT 1;'));
							$protiv_clan_a=getall_inf_clan($look_clan_protiv_name);

				   		 				
				   		 				mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$klan['short']}','{$protiv_clan_a['txt']}','{$nwrid}', '{$komu_row['stime']}' ) ON DUPLICATE KEY UPDATE war_with=CONCAT(war_with,',{$protiv_clan_a['txt']}') ");
							   		 	if ($klan['rekrut_klan']>0)
								   			{
											$myclan2=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$klan['rekrut_klan'].' LIMIT 1;'));
								   		 	mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$myclan2['short']}','{$protiv_clan_a['txt']}','{$nwrid}', '{$komu_row['stime']}' ) ON DUPLICATE KEY UPDATE war_with=CONCAT(war_with,',{$protiv_clan_a['txt']}') ");
											}
										mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$look_clan_protiv_name['short']}','{$add_clan_a['txt']}','{$nwrid}', '{$komu_row['stime']}' ) ON DUPLICATE KEY UPDATE war_with=CONCAT(war_with,',{$add_clan_a['txt']}') ");
										if ($look_clan_protiv_name['rekrut_klan']>0)
											{
											$clan2=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$look_clan_protiv_name['rekrut_klan'].' LIMIT 1;'));
											mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$clan2['short']}','{$add_clan_a['txt']}','{$nwrid}', '{$komu_row['stime']}' ) ON DUPLICATE KEY UPDATE war_with=CONCAT(war_with,',{$add_clan_a['txt']}') ");
											}
											

				   		 	
							if ($komu_row['allyagr']>0)
									{
										$help_to=$komu_row['agr_txt']; 
										mysql_query("UPDATE oldbk.clans_war_new SET agr_txt=CONCAT(agr_txt,',".$add_clan."') where id='{$nwrid}' ");
										//�������� � �������
										// � ���� �������� ������� ������ ���� ���������� ���������������� �������!!!
										/* - ��� �� ���� "� �������� - ���������������� ������ �� ��� ��� �������� � ��������, � �� �� �������. �.�. ��� ��� ���� �����. "
										foreach ($clan_all_protiv as $i=>$v)
										{
							   		 	mysql_query("INSERT INTO `oldbk`.`clans_war_new_times` SET `kl1`='{$klan['id']}',`kl2`='{$v}',`fintime`=NOW() + INTERVAL ".$prop_timer[$nwt]." SECOND "); 										
							   		 	}
							   		 	*/
									}
								elseif ($komu_row['allydef']>0)
									{
										$help_to=$komu_row['def_txt'];
										mysql_query("UPDATE oldbk.clans_war_new SET def_txt=CONCAT(def_txt,',".$add_clan."') where id='{$nwrid}' ");										
										//�������� � �������
										// � ���� �������� ������� ������ ���� ���������� ���������������� �������!!!	
										/* - ��� �� ���� "� �������� - ���������������� ������ �� ��� ��� �������� � ��������, � �� �� �������. �.�. ��� ��� ���� �����. "
										foreach ($clan_all_protiv as $i=>$v)									
										{
							   		 	mysql_query("INSERT INTO `oldbk`.`clans_war_new_times` SET `kl2`='{$klan['id']}',`kl1`='{$v}',`fintime`=NOW() + INTERVAL ".$prop_timer[$nwt]." SECOND "); 																				
							   		 	}
							   		 	*/
									}

							$buff.=err("<br> ��� ���� �����  � ������  �  ".$help_to."!<br>");
						 	unset($arr_zay_all);//��������  ���� �����
						 	$show_form=false;
							}
							
						     }
						     }	
							
						   }
						  }
						  else
						  	{
						  	$buff.=err("<br> � ����� �� ������� �������!<br>");
						  	}
						
						}
				elseif ((($_GET['ally_no']) AND ((int)($_GET['ally_no'])>0)) AND (is_array($arr_zay_all)) )
						{
						//����� � ���������� � ������
						$ally_id=(int)($_GET['ally_no']);
						$komu_row=$arr_zay_all[$ally_id];
						mysql_query("DELETE FROM oldbk.clans_war_new_ally WHERE id='{$ally_id}' AND clanid='{$whoklan}' ;");
						 if (mysql_affected_rows()>0)
						 	{
						 		if ($komu_row['allyagr']>0)
									{
										$help_to=$komu_row['agr_txt']; 
									}
								elseif ($komu_row['allydef']>0)
									{
										$help_to=$komu_row['def_txt'];
									}
						 	$buff.=err("<br> ��������� � ������� ".$help_to."!<br>");
						 	unset($arr_zay_all[$ally_id]); // �������� ������ ��������� ������
						 	}
						 	
						 //��������� ���������� ����� � ��� ��� �� ��������
						}
				 }
				else
				{
				 	//$buff.=err("<br> � ��� ������������ ���� �������!<br>");
				}


		if ((is_array($arr_zay_all)) AND (count($arr_zay_all)>0))
		{
			$buff.="<b>������ �� ���������� � ������:</b><br>";
				//���� ������ �� ��������� � ������
				
					foreach ($arr_zay_all as $zid=>$ro)
					{
						if ($ro['allyagr']>0)
							{
							$help_to=$ro['agr_txt'];
							}
						elseif ($ro['allydef']>0)
							{
							$help_to=$ro['def_txt'];
							}
					
					if ($rulit>0)
					{
					$buff.="<br> ����� </font> ".$ro['agr_txt']." ������ ".$ro['def_txt']."  ��������:<b>".$ro['stime']."</b> <br> ����� � ������ � ".$help_to."  <a href=?razdel=wars&ally_yes=".$zid.">��</a> / <a href=?razdel=wars&ally_no=".$zid.">���</a>  ";
					}
					else
					{
					$buff.="<br> ����� </font> ".$ro['agr_txt']." ������ ".$ro['def_txt']."  ��������:<b>".$ro['stime']."</b> <br> ����������� � ������ � ".$help_to."  - ���������. ";
					}

					}
				
		}
		else
		{

				if (time()<mktime(23,59,59,5,31,2016) )
				{
				$show_form=false;
				unset($_POST['mkwarto']);
				}
			
//			$show_form=false;
//			unset($_POST['mkwarto']);
		
		//��� ������ �� ���������� � ������� 
		// ������ ����� ��� ���� + ���������
			
			$mkwarto=(int)($_POST['mkwarto']);
			$wt=(int)($_POST['wt']);
			if (($_POST['addwar']) AND ($rulit>0) AND ($wt==1||$wt==2) AND ($mkwarto>0) )
			{
			if (file_exists("/www/locks/clanwarclock.txt")) 
			{
			//���� ��� ����
			    	$buff.=err('���������� ��� ���!');
			} else 
			{
			// ����� ��� ������ ��� ����
			$fp = fopen ("/www/locks/clanwarclock.txt","a"); //��������
			flock ($fp,LOCK_EX); 
			fputs($fp , time()); 
			fflush ($fp); 
			flock ($fp,LOCK_UN); 
			fclose ($fp);
			$war_cost=$war_price[$wt]; //������ ��������� ����� �� ����

			if(\components\Helper\Captcha::validate()) {
			     if($klan_kazna)
			     {
			     //��������� ������ � �����
			     if($klan_kazna['kr']>=$war_cost)
			      {
				//������� �������� �����
				//1. ��������� ���� �������� -�� ��� ��������� �������
				$get_clan_targ=mysql_fetch_array(mysql_query("SELECT * from oldbk.clans where id='{$mkwarto}' and id!=81 and id!=34 and id!=78 and base_klan=0 and time_to_del=0 "));
				
				if (($get_clan_targ['id']==34) or ($get_clan_targ['id']==78) or  ($get_clan_targ['id']==81)or  ($get_clan_targ['id']==458)  )
				{
			   	$buff.=err("��� ���������� �����, � ����� �� ������� ������ :) ");
				}
				else
				if (($get_clan_targ['id']>0) and ($klan['id']!=$get_clan_targ['id']) )
				{
				//���� ������
				//1.1 - �������� �� ������ �����
				$get_clan_protect=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_protect where clanid='{$get_clan_targ['id']}' "));
				 if (!($get_clan_protect['id']>0))
				 	{
				 	//1.2 - �������� ������ �������
					$get_clan_protect_my=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_protect where clanid='{$klan['id']}' "));
				 	if (!($get_clan_protect_my['id']>0))
				 	{
				 	//�������� ����� � ����� 
				 	$get_clan_pip=mysql_fetch_array(mysql_query("select count(id) as kolpip  from users  where klan='{$get_clan_targ['short']}' "));
				 	
				 	if ($get_clan_pip['kolpip']>0)
				 	{
					//2. ��������� �����
					if ($get_clan_targ['glava']>0)
						{
						 $targ_glava =check_users_city_data($get_clan_targ['glava']);
						 	if ($targ_glava['id']>0)
						 	{
						 	//3. �������� �� ����� �� ����
						 		$test_targ_war=chk_war($get_clan_targ['id']);
						 		if (!(is_array($test_targ_war)))
						 		{
						 			$gtimers=get_timers_kl($klan['id'],$get_clan_targ['id']);
							 		if (!(is_array($gtimers)))
							 		//��������� ������� �� ����
						 			{
							 		//��� ������ �����  ����� ������  $war_cost �� �����
							 		$coment='���������� ����� ����� <b>'.$get_clan_targ['short'].'</b>';
							   		if (by_from_kazna($klan['id'],1,$war_cost ,$coment))
							   		{
							   		//�������
							   		$agr_text_a=getall_inf_clan($klan);
							   		$agr_text=$agr_text_a['html'];
							   		$def_text_a=getall_inf_clan($get_clan_targ);				   		
							   		$def_text=$def_text_a['html'];
							   		mysql_query("INSERT INTO `oldbk`.`clans_war_new` SET `agressor`='{$klan['id']}',`defender`='{$get_clan_targ['id']}', `agr_txt`='{$agr_text}',`def_txt`='{$def_text}', `wtype`='{$wt}',`ztime`=NOW(),`stime`=NOW() + INTERVAL ".$start_timer[$wt]." SECOND ,`ftime`=NOW() + INTERVAL ".$fin_timer[$wt]." SECOND ,`winner`=0;");
							   		 if (mysql_affected_rows()>0)
							   		 	{
							   		 	$new_war_id = mysql_insert_id();
							   		 	//������� ������ � ��� ����� ������ ������
							   		 	mysql_query("INSERT INTO `oldbk`.`clans_war_new_times` SET `kl1`='{$klan['id']}',`kl2`='{$get_clan_targ['id']}',`fintime`=NOW() + INTERVAL ".$prop_timer[$wt]." SECOND "); 
							   		 	
								   		$buff.=err('�� �������� ����� �����:'.$def_text);
								   		$wrtxttype[1]='��������';
										$wrtxttype[2]='����������';
								   		//���������� ����������  ���� �������� � ��� ��� ��������� �����
								   		send_tele_to_clan($get_clan_targ['short'],"������ ����� ��������� ".$wrtxttype[$wt]." ����� �� �����: ".$agr_text." ");
								   		
							   		 	mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$get_clan_targ['short']}','{$agr_text_a['txt']}','{$new_war_id}', (NOW() + INTERVAL ".$start_timer[$wt]." SECOND) ) ");
								   		
								   		 if ($get_clan_targ['rekrut_klan']>0)
								   		 	{
								   		 	$clan2=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$get_clan_targ['rekrut_klan'].' LIMIT 1;'));
									   		send_tele_to_clan($clan2['short'],"������ ����� ��������� ".$wrtxttype[$wt]." ����� �� �����: ".$agr_text." ");								   		 	
							   		 		mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$clan2['short']}','{$agr_text_a['txt']}','{$new_war_id}' , (NOW() + INTERVAL ".$start_timer[$wt]." SECOND) ) ");
								   		 	}
								   		//���������� ������ ������ �����
								   		$wrtxttype[1]='��������';
										$wrtxttype[2]='����������';
										
								   		send_tele_to_clan($klan['short'],"�������� \"".$user['login']."\" ������� ".$wrtxttype[$wt]." ����� �����: ".$def_text." ");
								   		
							   		 	mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$klan['short']}','{$def_text_a['txt']}','{$new_war_id}' , (NOW() + INTERVAL ".$start_timer[$wt]." SECOND) ) ");
								   		
								   		if ($klan['rekrut_klan']>0)
								   			{
											$myclan2=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$klan['rekrut_klan'].' LIMIT 1;'));
									   		send_tele_to_clan($myclan2['short'],"�������� \"".$user['login']."\" ������� ".$wrtxttype[$wt]." ����� �����: ".$def_text." ");			
								   		 	mysql_query("INSERT INTO oldbk.clans_war_city_sync (name,war_with,war_id,stime) VALUES ('{$myclan2['short']}','{$def_text_a['txt']}','{$new_war_id}', (NOW() + INTERVAL ".$start_timer[$wt]." SECOND) ) ");
								   			}

								   		
								   		
								   		$show_form=false;
								   		}
								   		else
								   		{
								   		$buff.=err('��������� ������!');
								   		}
							   		}
							   	    }
							   	    else
							   	    {
							   	   $buff.=err('�� �� ������ ������� �� ���� ���� �� <b>'.$gtimers['fintime'].'</b>');
							   	 
							   	    }
						 		}
						 		else
						 		{
								$buff.=err("���� ���� ��� �����!");						 		
						 		}
						 	}
						 	else
							{
							$buff.=err("� ����� ����� ��� �����!");
							}
						}
						else
						{
						$buff.=err("� ����� ����� ��� �����!");
						}
						
					   }
					   else
					    {
					    $buff.=err("� ����� ����� ��� �����!");
					    }
					 
					   }
					   else
					   {
						$buff.=err("��� ���� �� ����� �������� ��:".$get_clan_protect_my['fintime']);					   
					   }	
						
					}	
					else
					{
					//$buff.=err("� ����� ����� ������ �� ��������� ��:".$get_clan_protect['fintime']);
					 $buff.=err('�� �� ������ ������� �� ����, ������� ������� �������� ���������� �����. ���������� ����� ��� ���.');							   	   
					}
				}
				else
				{
				$buff.=err("����� ���� �� ������");
				}
			     }
			     else
			     {
			   	$buff.=err("��� ���������� �����, � ����� �� ������� ������!");			     
			     }
			   }
			   else
			   {
			   	$buff.=err("��� ���������� �����, ��� ���������� ����� �����!");
			   }
                        }
			else
                          {
			   	$buff.=err("�� ������ ������!");
			  }
			
			unlink("/www/locks/clanwarclock.txt"); //������� ����������
			}
			}

		//��� ����� - ������ -����� ��� ������

			if (time()<mktime(23,59,59,5,31,2016) )
				{
				$show_form=false;
		  		$buff.='�������� ��������� ��: 31/05/2016 23:59:59';				
				}

//		$show_form=false;
//		$buff.='�������� ����� �������� ���������.';	
			
			if (($rulit>0) and ($show_form))
			{
			//������ � ������ ������ ������
			//+ ���� ������ ����������� � �������
		 		$buff.='<form method=post><table border=0><tr><td>�����:</td></tr><tr>
  				<td>�������� ����� �����  <select size="1" name="mkwarto">
  				<option value=""></option>';
			$sql=mysql_query("select co.id,co.short,cr.id as rid,cr.short as rshort  from oldbk.`clans` co  left join oldbk.`clans` cr  on co.rekrut_klan=cr.id where co.base_klan=0 AND co.id !='".$whoklan."' AND (co.short not in ('Adminion','radminion','pal','ytesters','ztesters','xtesters','3testers','4testers','3testers1','4testers1','5testers','6testers','6testers1','testTest','r�dminion')) AND co.time_to_del=0   order by short");
			while($data=mysql_fetch_array($sql))
			{
					$buff.= '<option  value="'.$data['id'].'">'.$data['short'].($data['rid']>0?' - '.$data['rshort']:'').'</option>';
			}
					$buff.= '</select><br>';

	  		$buff.= '</td></tr>
	  		<tr>
	  			<td><input type=radio name=wt value=1>�������� ����� (��������� '.$war_price[1].' ��.) <br>
	  			<input type=radio name=wt value=2>���������� ����� (��������� '.$war_price[2].' ��.) 
	  			</td>
	  		</tr>';

	  		$buff.= '<tr><td align=center>';
			if($klan_kazna)
					{

					$buff.= \components\Helper\Captcha::render();
					$buff.= '<input type="submit" name="addwar" value="��������"> <br> <small>(� ����� '.$klan_kazna['kr'].'��.)</small>';
					}
					else
					{
					$buff.= '��� ������ ���������� ������� �����.';
					}
	  		$buff.= '</td></tr>';
	  		$buff.= '</table></form>';
  			}
			 
			
		
		
		  }
		
		
			if  ( ((int)($_GET['post_attack'])>0) and ($user['naim']>0) )
				{
				die('<script>location.href = "main.php?edit=1&effects=1&post_attack='.$_GET['post_attack'].')";</script>');			
				}
		
		
		}
		
		
		
		
return $buff;		
}

function print_do_attak($havewar,$my_side_is,$startbattle,$voin)
{
global $klan,$user;
//print_r($_GET);
//print_r($_POST);
					///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////					
					//�������� ��������� + ������
					
		        		$buff.= '<br><a href="#" onclick="javascript:runmagic1(\'���������\',\'post_attack\',\'target\') "><img title="�������� ���������" src="http://i.oldbk.com/i/klan_attak_p.gif"></a>';

						//�������� ���.������������� - ��� ������ 			 		
			 			//��������� ������� ������ ���� � ���� �������
		 			 	if ($my_side_is=='agr')
		 			 	{
 				 			$get_count_arkan=(int)$havewar['agr_ark'];
		 			 		$my_need_ark =(int)($voin['my']['total']/500)+3; // 3 ����������� ������ 
		 			 		
		 			 	}
		 				 elseif ($my_side_is=='def')
		 			 	{
 				 			$get_count_arkan=(int)$havewar['def_ark'];		 			 	
		 			 		$my_need_ark =(int)($voin['my']['total']/500)+3; // 3 ����������� ������ 
		 			 	}
						
						$can_use_arkan=false;
						/*
		 				if ($get_count_arkan<$my_need_ark)
		 				{
			        			$buff.='<a href="#" onclick="javascript:runmagic1(\'�����\',\'post_attack2\',\'target\') "><img title="����� '.$get_count_arkan.'/'.$my_need_ark.'"  src="http://i.oldbk.com/i/klan_arkan_p.gif"></a>';        		
			        			$can_use_arkan=true;
			        		}
			        		else
			        		{
		        				$buff.='<img title="����� '.$get_count_arkan.'/'.$my_need_ark.'" src="http://i.oldbk.com/i/klan_arkan_p.gif">';
			        			$can_use_arkan=false;		        				
		        			}
		        			*/

//////////////////////////////////////////////////���������///////////////////////////////////////////////////////////////////////////////////////////////////////////
						if ( (isset($_POST['target'])) OR ((int)$_GET['post_attack']>0))
						{
						$stop=false;
						$_GET['post_attack']=(int)$_GET['post_attack'];
						
						if ($_GET['post_attack']>0)
						{
						//�������� �� ���� - �� ������� �������� ����� � �� �������
						$_POST['use']='post_attack';							
						}
						else
					        if (($_POST['use']=='post_attack2') AND ($can_use_arkan==false))
					        {
					        	$buff.=err('<br>������ ����������� :( <br>');
							$stop=true;
					        }
						elseif ($_POST['use']=='post_attack2')
						{
						$_POST['use']='post_attack';	
						$USE_ARKAN=true;
						}
	
						if ($user['ruines']>0)
						{
							$buff.=err('<br>��� ��� �� �������...<br>');
							$stop=true;								
						}
						elseif($_POST['use']=='post_attack') 
							{
								if ($_GET['post_attack']>0)
								{
							        $telo=mysql_fetch_array(mysql_query('SELECT * from users where id = "'.$_GET['post_attack'].'" LIMIT 1'));
							        }
							        else
							        {
							        $telo=mysql_fetch_array(mysql_query('SELECT * from users where login = "'. strip_tags($_POST['target']).'" LIMIT 1'));
							        $_GET['post_attack']=$telo['id'];
							        }
							
							
							if  (  ($telo['id']>0) AND (($telo['klan']!='') OR ($telo['naim_war'] == $havewar['id']) )  )
							{
							   $test_naim=false;
							//���� ���� � � ����� ��� ���� ������� � ����� ����
								//��������� ����
								if ($telo['klan']!='')
										{
										//��������� ����� ���� ���� ����
									   	    $target_clan=mysql_fetch_array(mysql_query('SELECT * from oldbk.clans where short ="'.$telo['klan'].'" LIMIT 1'));
										    $target_clan['id']=($target_clan['base_klan']>0?$target_clan['base_klan']:$target_clan['id']); // ���� ���� ���� ������ = ����� �� ����� ������									   	    
										   
										   if ($telo['naim_war'] == $havewar['id'])
										   	{
											    $test_naim=true; //  ��������� �� ����
											 }
									   	 }
									   	else
									   	{
									   	//���� ���� - �� ��������� ���� ��������
									   	    $target_clan=mysql_fetch_array(mysql_query('SELECT * from oldbk.clans where id ="'.$telo['naim'].'" LIMIT 1'));
									   	}
							   	    

								 //������ ��������� ����� �� �� �� ���� �������
								    if ($my_side_is=='agr')
								    	{
									 		if ( ($havewar['defender']==$telo['naim']) and ($telo['naim_war'] == $havewar['id']))
									 		{
									 		//��� �� ��� ���� - ����� ��������
									 		
									 		}
									 		elseif ($havewar['defender']!=$target_clan['id']) // ���� ���� �� ������� �������� ������� �� ������ ����
									 		{
											// ���� �������� �� ���� �� �������� �������� ������� - �� ����  � �������� ���������
											$target_clan_ally=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_ally where warid='{$havewar['id']}' and defender='{$havewar['defender']}' and clanid='{$target_clan['id']}'"));
												if (!($target_clan_ally['id']>0))
													{
													$buff.=err('<br>� ��� ��� ����� � ���� ������!<br>');
													$stop=true;		
													}
									 		}
								    	}
								    else
								    	{
								    			if ( ($havewar['agressor']==$telo['naim']) and ($telo['naim_war'] == $havewar['id']))
									 		{
									 		//��� �� ��� ���� - ����� ��������
									 		
									 		}
									 		elseif ($havewar['agressor']!=$target_clan['id']) // ���� ���� �� ������� �������� ������� �� ������ ����
									 		{
											// ���� �������� �� ���� �� ������� �������� ������� - �� ����  � �������� ���������
											$target_clan_ally=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_ally where warid='{$havewar['id']}' and agressor='{$havewar['agressor']}' and clanid='{$target_clan['id']}'"));
												if (!($target_clan_ally['id']>0))
													{
													$buff.=err('<br>� ��� ��� ����� � ���� ������!<br>');
													$stop=true;		
													}
									 		}
								    	}
						
							}
							elseif (($telo['id']>0) AND ($telo['klan']==''))
							{
							$buff.=err('<br>���� �������� �� � �����!<br>');
							$stop=true;						
							}
							else
							{
							$buff.=err('<br>����� �������� �� ������!<br>');
							$stop=true;						
							}
						     }
						
					        	if($stop==false)
							{
							//$buff.="���� ��";
							
								//���� ��� ��� �� �������� ������
								$klan_war=true;
								//$startbattle - ����� �� �������� ���
								//$USE_ARKAN - ��� ���� ����������� �����
								$buff.="<br>";
								include "magic/klanattack_new.php";
								//�������� ������ ���������
								//���� � ��� - �� � �����? � ����� �� ���������?
								//���� �� � ��� - �� ��������.
								if($napal==1)
								{
								header("Location: fbattle.php");
								die('<script>location.href = "fbattle.php";</script>');
								}
							
							}
							elseif ($user['naim'] >0 )
							{
							$buff.=err('<br>������� ������� ��� �������...<br>');
							die('<script>location.href = "main.php?edit=1&effects=1&post_attack='.$_GET['post_attack'].')";</script>');
							}
							

						}
						else
						{
						//print_r($_GET);
						//echo "<br>";
						//print_r($_POST);
						}
return $buff;
}

function chk_war($clanid)
{
//�������� �� ���������� �� ������� ����� � �����
$get_wars=mysql_fetch_array(mysql_query("select cw.* , cy.clanid , cy.clan_txt, cy.agressor as allyagr, cy.defender as allydef  from oldbk.clans_war_new  cw LEFT join oldbk.clans_war_new_ally cy on cy.warid=cw.id and cy.active=1 where cw.winner=0 and (cw.agressor='{$clanid}' or cw.defender='{$clanid}' or cy.clanid='{$clanid}' )")); 
	if ($get_wars['id']>0)
		{
		return $get_wars;	//���� ����� ���������� �� �����
		}
return false;
}

function chk_ally_req($clanid)
{
//�������� ��  ����������� � ������ � ����� �� �������� 0
//���� ����� �� ������� ���� �����������
	$get_req=mysql_query("select cy.id as zid, cy.clanid, cy.clan_txt as allytxt, cy.agressor as allyagr, cy.defender as allydef, cw.*   from oldbk.clans_war_new_ally cy left join oldbk.clans_war_new cw on cy.warid=cw.id where clanid='{$clanid}' "); /// and stime>NOW()+ INTERVAL 1 HOUR
	if (mysql_num_rows($get_req) >0)
			{
					while($row=mysql_fetch_assoc($get_req))
					{

					// �������� ������� ����� - ���������� � ������ ����� ������ � ������ ������������� �� 1 ���
					
					if ((strtotime($row['ztime'])<=time()) AND ( strtotime($row['stime'])>=(time()+3600) ) )
						{
						$out[$row['zid']]=$row;
						}
						else
						{
						//������������ ������� �� ���������
						//������� ������� �� �������
						mysql_query("DELETE FROM oldbk.clans_war_new_ally WHERE id='{$row['zid']}';");
						}
					}
			}
			else
			{
			return false;
			}

return $out;
}

function show_mk_ally($clanid,$warid,$rulit,$look_clan_protiv,$stor)
{
global $klan_kazna;
//�������� ������� �� ������ + �����
$show_form=true;	
$ally_cost=50;
		
			if (($_SERVER['REQUEST_METHOD'] == "POST") AND ($_POST['addally']) AND ($rulit>0) )
				{
				$mkally=(int)($_POST['mkally']);
					if ($mkally>0)
					{
					$get_clan_targ=mysql_fetch_array(mysql_query("SELECT * from oldbk.clans where id='{$mkally}' and id!=81 and id!=34 and id!=78  and id!=458 and base_klan=0 and time_to_del=0 "));					
					if ($get_clan_targ['id']>0)
					{
					$get_clan_mess=mysql_fetch_array(mysql_query("SELECT * from oldbk.clans_war_new_ally  where  `warid`='{$warid}' and  `clanid`='{$get_clan_targ['id']}' "));					
						if ($get_clan_mess['id']>0)
						{
						$buff.=err('<br>���� ���� ��� ����� ����������� � ������ � ���� �����!<br>');
						}
					else
					{
					$targ_glava =check_users_city_data($get_clan_targ['glava']);
					if ($targ_glava['id']>0)
					{
//					print_r($_POST);
					//1 ��������� �� ����� �� ����
					$clan_havewar=chk_war($mkally);
					if (is_array($clan_havewar))
						{
						//����� ��� ��������� � �����
						$buff.=err('<br>���� ���� ��� ����� ��� ��������� � �����, ��� ������ ������� � ������!<br>');
						}
						else
						{
						//2. ��������� ��������� - ����� �����(� ��� ��������) - �� ������ �� ��� - � ���� �����
						$add_sql=" klan='{$get_clan_targ['short']}' ";
	
								if ($get_clan_targ['rekrut_klan']>0)
								{
								$get_rekr=mysql_fetch_array(mysql_query("SELECT * from oldbk.clans where id='{$get_clan_targ['rekrut_klan']}' "));					
								if ($get_rekr['id']>0)
									{
									$add_sql=" ( klan='{$get_clan_targ['short']}' OR klan='{$get_rekr['short']}'  )";
									}
								}
																
						 $get_aclan_naim=mysql_fetch_array(mysql_query("select count(id) as kol  from oldbk.users where ".$add_sql." and naim_war='{$warid}' and  naim='{$look_clan_protiv}' and id_city=0")); //������� �� ����
						 
							if ($get_aclan_naim['kol']>0)
								{
								$buff.=err('<br>� ����� ����� ���� ������� ������� ����� ������ ���, ���� ���� ������ ������� � ������!<br>');
								}
								else
								{
								  if($klan_kazna['kr']>=$ally_cost)
								  	{
								  	//2. 
								  	//�������� ������ �������
									$get_clan_protect_my=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_protect where clanid='{$get_clan_targ['id']}' "));
								 	if (!($get_clan_protect_my['id']>0))
									{								  	
									//3. ���� ��� ���
									// 4. ������� ������  � ������� �����������								
									$coment='����������� � ������ ����� <b>'.$get_clan_targ['short'].'</b>';
							   		if (by_from_kazna($clanid,1,$ally_cost ,$coment))
							   			{

							   			$kl_txt=getall_inf_clan($get_clan_targ);
										$kl_txt=$kl_txt['html'];							   			
							   			mysql_query("INSERT INTO `oldbk`.`clans_war_new_ally` SET `warid`='{$warid}',`clanid`='{$get_clan_targ['id']}',`clan_txt`='{$kl_txt}', ".$stor."='{$clanid}'  ,`active`=0;");
							   				 if (mysql_affected_rows()>0)
							   				{
							   				$buff.=err('<br>����������� � ������ ������ ����������:'.$kl_txt.'<br>');		

							   			//���������� ����� � �����������							   				
				   							send_tele_to_clan($get_clan_targ['short'],"������ ����� ������ ����������� � ���������� � ������!");
											if ($get_clan_targ['rekrut_klan']>0)
								   		 	{
								   		 	$clan2=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$get_clan_targ['rekrut_klan'].' LIMIT 1;'));
									   		send_tele_to_clan($clan2['short'],"������ ����� ������ ����������� � ���������� � ������!");								   		 	
								   		 	}				   							
							   				
							   											
							   				}
							   			
							   			}
							   		   }
							   		   else
							   		   {
										$buff.=err('<br>���� ���� �� ����� ����� � ������ ��:'.$get_clan_protect_my['fintime'].'<br>');																   		   
							   		   }
									}
									else
									{
									$buff.=err('<br>��������� �������� �� ������!<br>');									
									}
								}
						}

					}
					else
						{
						$buff.=err("<br>� ����� ����� ��� �����!<br>");
						}
						
					 }
					}
					else
						{
						$buff.=err('<br>���� ���� ������ ������� � ������!<br>');						
						}
					}				
				}
			
			
		
			if (($rulit>0) and ($show_form))
			{
			$buff.='<form method=post>
  				������� � ������ ('.$ally_cost.' ��) <select size="1" name="mkally">
  				<option value="">������ ��������� � ������</option>';
				$sql=mysql_query("select co.id,co.short,cr.id as rid,cr.short as rshort  from oldbk.`clans` co  left join oldbk.`clans` cr  on co.rekrut_klan=cr.id where co.base_klan=0 AND co.id !='".$clanid."' AND (co.short not in ('Adminion','radminion','pal','ytesters','ztesters','xtesters','3testers','4testers','3testers1','4testers1','5testers','6testers','6testers1','testTest','r�dminion')) AND co.time_to_del=0   order by short");
				while($data=mysql_fetch_array($sql))
				{
					$buff.= '<option  value="'.$data['id'].'">'.$data['short'].($data['rid']>0?' - '.$data['rshort']:'').'</option>';
				}
				$buff.= '</select>';
			$buff.= '<input type="submit" name="addally" value="��������� ������"> ';
	  		$buff.= '</form>';
			}

return $buff;
}

function getall_inf_clan($clan)
{
//����� ��� ���� ����� - ������� ����� ����� ������

$out['html']=show_klan_name($clan['short'],$clan['align']);
$out['txt']=$clan['short'];

 if ($clan['rekrut_klan']>0)
 	{
 	$clan2=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$clan['rekrut_klan'].' LIMIT 1;'));
 	$out['html'].=" � ������� ".show_klan_name($clan2['short'],$clan2['align']);
 	$out['txt'].=",".$clan2['short'];
 	}
return $out;
}

function get_timers_kl($k1,$k2)
{
//�������� �������� ����� �������
$get_test=mysql_fetch_assoc(mysql_query("SELECT * FROM clans_war_new_times WHERE ((kl1='{$k1}' and kl2='{$k2}' ) OR (kl2='{$k1}' and kl1='{$k2}' ) ) and fintime>NOW()  LIMIT 1"));
	if (is_array($get_test))
	{
	return $get_test;
	}
	
return false;	
}

function mk_warcancel($havewar,$klan)
{
global $klan_kazna, $user ;
$war_price[1]=100; //�������� �����
$war_price[2]=200; //���������� �����

$OK=false;
//����� �����
	if ($klan['warcancel']>=0)
	{
	//������� ������ �� �����
		if($klan_kazna)
		{
		$m=$klan['warcancel']*1000+1000;
			 if($klan_kazna['kr']>=$m)
			      {
					$coment='����� � ����� ����� '.$havewar['agr_txt'];
			   		if (by_from_kazna($klan['id'],1,$m ,$coment))
			   		{
			   		//��������
		   			$OK=true;
			   		}
					else
					{
					$buff.= err('<br>��� ������ ����� � ����� �� ������� ������! ');				
					}			   		
				}
				else
				{
				$buff.= err('<br>��� ������ ����� � ����� �� ������� ������! ');				
				}
		}
		else
		{
		$buff.= err('<br>��� ������ ���������� ������� �����.');
		}
		
	}
	else
	{
	$OK=true;
	}

	if ($OK==true)
		{
		//
		mysql_query("UPDATE oldbk.clans_war_new set winner=4 where id='{$havewar['id']}' and winner=0;");
		 if (mysql_affected_rows()>0)
		 	{
		 	//����������� ������� �������
		 	mysql_query("UPDATE oldbk.clans set warcancel=warcancel+1 where id='{$klan['id']}' ");
		 	
		 	//������� ��� ������� ��� ���� ����� �������� � ���
		 	mysql_query("DELETE from oldbk.clans_war_new_ally where warid='{$havewar['id']}';");
		 	
		 	//������� ����������� ���������
		 	mysql_query("DELETE from oldbk.naim_message where war_id='{$havewar['id']}';");
		 	//������� ��� ��������� ������� ��� ����� - �������� ��������� �� �������� oldbk.naim_message
		 	
			//������ ��� ��� ����
			mysql_query("delete from `oldbk`.`clans_war_city_sync` where war_id='{$havewar['id']}';");
		 	
		 	//���������� ����� ����� ������� �� ������� �� ������
			// 	���� ����� �������� �� ����� �� ��� 100-200 �� �� ���������� ������������ � �����
			//$war_price
			$back_money=$war_price[$havewar['wtype']];
			mysql_query("UPDATE oldbk.clans_kazna set kr=kr+{$back_money}   WHERE `clan_id` = '{$havewar['agressor']}' ;");
//			echo "UPDATE oldbk.clans_kazna set kr=kr+{$back_money}   WHERE `clan_id` = '{$havewar['agressor']}' ;" ;
			 if (mysql_affected_rows()>0)
			 	{
			 	//����� � ��� � �����  ���������
			 	$txt='������� '.$back_money.' �� ���������� ����� �����:'. $havewar['def_txt'];
			 	txt_to_kazna_log(1,1,$havewar['agressor'],$txt,$user);
			 	}
			 	else
			 	{
			 	//echo "ERROR KAZNA";
			 	}

		 	//���������� ���������� ��������
			$clan1=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$havewar['agressor'].' LIMIT 1;'));
			send_tele_to_clan($clan1['short'],"���� : ".$havewar['def_txt']." ��������� �� �����!");
			if ($clan1['rekrut_klan']>0)
			{
			$clan2=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$clan1['rekrut_klan'].' LIMIT 1;'));
			send_tele_to_clan($clan2['short'],"���� : ".$havewar['def_txt']." ��������� �� �����!");
			}
		 	
		 	//��� ������ - ��� ������ � ��������� ������? ��������� � ��� ��� � ��� ������� - ���� ��������
		 	
		 	$buff.= err('<br>������ ��������� � �����!');
		 	}
		 	else
		 	{
		 	$buff.= err('<br>��������� ������ -������ � �����!');
		 	}
		}

	
return $buff;
}


function show_naims()
{
global $klan, $rulit;
//echo "�����".$rulit;
			$out='<form method=post>';
  			$out.="������� �������� (30 ��):	<select size=\"1\" name=\"naimid\">";
  			$out.= '<option value="">������ ��������� � �����</option>';
  			$snaim=mysql_query("select e.*, u.login, u.level , u.id as uid from oldbk.effects e LEFT JOIN oldbk.users u ON e.owner=u.id where e.type=2000 and u.id_city=0 and naim=0 and u.klan!='{$klan[short]}' and u.klan!='radminion'
  							UNION select e.*, u.login, u.level , u.id as uid from avalon.effects e LEFT JOIN avalon.users u ON e.owner=u.id where e.type=2000 and u.id_city=1 and naim=0 and u.klan!='{$klan[short]}' and u.klan!='radminion' ");
  			while($ndata=mysql_fetch_array($snaim))
			{
			$out.= '<option   value="'.$ndata[uid].'">'.$ndata[login].'['.$ndata[level].'] - ��������� ���. '.date("d-m-Y H:i",$ndata[time]).' </option>';
			}
  			$out.='</select>';
			$out.='<input type="submit" name="addnaim" value="����������"> <br> ';  			
			$out.='</form>';
return $out;
}

function do_naims($wararr,$rulit=0)
{
global $klan, $user;
$buf='';
	if ($_POST[addnaim] && $rulit==1 && $_POST[naimid] > 0)
        {
		if(is_array($wararr))
		{
			if($wararr['defender']==$klan['id'])
	        	{
	        		$myside='defender';
	        		$enside='agressor';
	        		
	        	}
	        	else
	        	if($wararr['agressor']==$klan['id'])
	        	{
	        		$myside='agressor';
	        		$enside='defender';	        		
	        	}
		$mwar_id=$wararr['id']; // �� ����� 
		}
///////////////////////////////////////////////////				
        if ($mwar_id>0)
        {
        
        	$naim=(int)($_POST[naimid]);
        	$get_test_naim=check_users_city_data($naim);
        	if ($get_test_naim[id]>0)
        		{
	        	$ucit[0]='oldbk.';
	        	$ucit[1]='avalon.';
			// ��������� ������ � �����
        		$get_test_eff=mysql_fetch_array(mysql_query("select * from ".$ucit[$get_test_naim[id_city]]."effects where owner='".$get_test_naim[id]."' AND type= 2000  limit 1;"));
        		//��������� ���� �� ��� � ���� �������
        		if ($get_test_eff[id]>0)
        			{
         		$get_test_message=mysql_fetch_array(mysql_query("select * from oldbk.naim_message  where owner='".$get_test_naim[id]."' AND in_klan_id='{$klan['id']}' ;"));	
        		 if (!($get_test_message))	
        			{
        			 if ($get_test_naim['naim']==0)
        			 	{
        			 	$good_to_add=0;
        			 	 if ($get_test_naim['klan']!='')
        			 	 	{
	 	 	
        			 	 	//�������������� �������� ���� ���� � �����
        			 	 	 $get_naim_clan=mysql_fetch_array(mysql_query("SELECT * from oldbk.clans where short='{$get_test_naim['klan']}' ; "));
        			 	 	 if ($get_naim_clan['id']==$klan['id'])
        			 	 	 {
	        			 	 $buf.=err('<br>������� �� ������ �����, �� � ��� �� ��� :)<br>');
        			 	 	 }
        			 	 	 elseif ($get_naim_clan['base_klan']==$klan['id'])
        			 	 	 {
	        			 	 $buf.=err('<br>������� �� ������ ������ �����, �� � ��� �� ��� :)<br>'); 
        			 	 	 }
        			 	 	 elseif ($get_naim_clan['id']==$wararr[$enside])
        			 	 	 {
	        			 	 $buf.=err('<br>������� �� ����� ������ �����...��� ������ �������!<br>'); 
        			 	 	 }        			 	 	 
        			 	 	 elseif (($get_naim_clan['base_klan']==$wararr[$enside]) and ($get_naim_clan['base_klan']>0))
        			 	 	 {
	        			 	 $buf.=err('<br>������� �� ������ ����� ������ �����...��� ������ �������!<br>'); 
        			 	 	 }         			 	 	 
						else
        			 	 	 {
        			 	 	 $good_to_add=1; //  ������ �� ��������� ��� ��� ���������
        			 	 	 	if($get_naim_clan['base_klan']>0)
        			 	 	 	{
        			 	 	 		$get_naim_clan['id']=$get_naim_clan['base_klan']; //�������� �������� � ������ �����
        			 	 	 	}
        			 	 	 	//������ ���� ��������� ����� ������� �� ��� � ������ � �� �������� ������
        			 	 	 	$get_test_inally=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_new_ally where clanid='{$get_naim_clan['id']}' and warid='{$mwar_id}' ; "));
        			 	 	 	
        			 	 	 	if ($get_test_inally['id']>0)
        			 	 	 	{
        			 	 	 	   if  ($get_test_inally['active']==1)
        			 	 	 	     {	
        			 	 	 		if ($get_test_inally[$myside]==$klan['id']) 
        			 	 	 		{
	        			 	 	 		$buf.=err('<br>������� �� ����� ������ �������, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;
        			 	 	 		}
        			 	 	 		else
        			 	 	 		{
        			 	 	 			$buf.=err('<br>������� �� ����� ������� ������ �����, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;
        			 	 	 		}
        			 	 	 	    }
        			 	 	 	    else
        			 	 	 	    {
	   			 	 	 		if ($get_test_inally[$myside]==$klan['id']) 
        			 	 	 		{
	        			 	 	 		$buf.=err('<br>���� �������� ��� �� ������� �� ��� ������ �������, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;
        			 	 	 		}
        			 	 	 		else
        			 	 	 		{
        			 	 	 			$buf.=err('<br>���� �������� ��� �� ������� �� ������ ������� ������ �����, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;
        			 	 	 		}
        			 	 	 	    }
        				 	 	}
        			 	 	 }
				        	}
				        	else
				        	{
			        		$good_to_add=1;
				        	}

						if ($good_to_add==1)
						{
		        			$my_clan_name=$user['klan']; // �������� ����� �����
		        			$my_war_name=''; // ����� ����� ��� ������ ���� �������� �������� ����� �� $mwar_id
        					// ������� ������ �����
       						// ��������� �������� ������ - �� �����
       						if (by_from_kazna($klan['id'],1,30,'����� ��������:'.$get_test_naim['login']))
       						   {
	        					mysql_query("INSERT INTO `oldbk`.`naim_message` SET `owner`='{$get_test_naim['id']}',`in_klan_id`='{$klan['id']}',`stat`=0,`sender`='{$user['id']}',`war_id`=$mwar_id;");
							if (mysql_affected_rows() >0 )
							{
	        					//+���������� ���  ��������� - ��������� ����������� ���������
        						 if($get_test_naim[odate] >= (time()-60))
								                        {
							                        	addchp ('<font color=red>��������!</font> ����  '.$my_clan_name.', � ���� '.$user['login'].', ������ ��� ������ � ����� '.$my_war_name.'. ������� ��� �������� �� ������ �� ������� "���������" !','{[]}'.$get_test_naim['login'].'{[]}');
								                        }
								                        else
								                        {
								                         mysql_query("INSERT INTO oldbk.`telegraph`   (`owner`,`date`,`text`) values ('".$get_test_naim['id']."','','<font color=red>��������!</font> ���� ".$my_clan_name.", � ���� ".$user['login'].", ������ ��� ������ � ����� ".$my_war_name.". ������� ��� �������� �� ������ �� ������� \"���������\" !');");
								                        }
							 $buf.=err("<br>����������� �������� ������ ����������!<br>");
							}
        					   }
        					   else
        					   {
        					   	 $buf.=err("<br>����������� �������� �� ����������!<br>");
        					   }
        					}
        				}
        				else
        				{
        				$buf.=err('<br>���� ������� ��� �����!<br>');
        				}
        			 }
        			 else
        			 {
        			 $buf.=err('<br>���� ������� ��� ������� �� ��� �����������!<br>');
        			 }
        			}
	        		else
        			{
        			$buf.=err('<br>� �������� ��� ��������!<br>');
        			}
        		}
        		else
        		{
        		$buf.=err('<br>������� �� ������<br>');
        		}
        	
        	}
        	else
        	{
        		$buf.=err('� ��� ��� �����!<br>');
        	}
        	
        }
return $buf;
}

function send_tele_to_clan($klan_name,$msg)
{
						 		$data=mysql_query("select * from oldbk.users where klan='".$klan_name."';");
		 						while($sok=mysql_fetch_array($data))
							 	{
	 							telegraph_new($sok,$msg,'2',time()+(2*24*3600));
							 	}
}

//�� ������ ��������� � ��� ������  ���������
//�� ������ � ��������� ��������� ����� ����� � ������� ������ ��� �������������


?>