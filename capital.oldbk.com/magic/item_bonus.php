<?
if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) {
	header("Location: index.php");
	die();
}

 if (!isset($_GET['clearstored']))
 	{
 	
$mag_config[100011]=array(
'ghp'=> array (5) , // �� �� 1 �� 5 ������ ����� �� ��.������ ghp ���� array (1,2,3,4,5) ,
'stat'=> array (1=> array ('gsila' => 1) , 2=> array('glovk' => 1) , 3 => array ('ginta' => 1), 4=> array( 'gintel' => 1)) , 
'mf' =>array( 1=> array ('mfkrit' =>10), 2=> array ('mfakrit' => 10) , 3 => array( 'mfuvorot' => 10),  4=> array('mfauvorot' => 10))) ; 

$mag_config[100012]=array(
'ghp'=> array (15) , // �� �� 6 �� 15 ������ ����� �� ��.������ ���� array (6,7,8,9,10, 11, 12, 13, 14, 15)
'stat'=> array (1=> array ('gsila' => 2) , 2=> array('glovk' => 2) , 3 => array ('ginta' => 2), 4=> array( 'gintel' => 2)) , 
'mf'=> array( 1=> array ('mfkrit' =>20), 2=> array ('mfakrit' => 20) , 3 => array( 'mfuvorot' => 20),  4=> array('mfauvorot' => 20)),
'mast'=> array (  2 => array( 'gtopor' => 1) , 3 => array( 'gdubina' => 1), 4=> array ( 'gmech' => 1)));  //1=> array ('gnoj' =>1),

$mag_config[100013]=array(
'ghp'=> array (25) , // �� �� 16 �� 25 ������ ����� �� ��.������ ���� array (16,17,18,19, 20, 21, 22, 23, 24, 25)
'stat'=> array (1=> array ('gsila' => 3) , 2=> array('glovk' => 3) , 3 => array ('ginta' => 3), 4=> array( 'gintel' => 3)) , 
'mf'=> array( 1=> array ('mfkrit' =>30), 2=> array ('mfakrit' => 30) , 3 => array( 'mfuvorot' => 30),  4=> array('mfauvorot' => 30)),
'magic'=> array (1=> array ('gfire' =>1), 2=> array ('gwater' => 1) , 3=> array('gair' => 1), 4=> array ('gearth' => 1)));  

$mag_config[100015]=array(
'ghp'=> array (35) , // �������� ��: 35
'stat'=> array (1=> array ('gsila' => 4) , 2=> array('glovk' => 4) , 3 => array ('ginta' => 4), 4=> array( 'gintel' => 4), 5=> array( 'gmp' => 4)) , 
'mf'=> array( 1=> array ('mfkrit' =>40), 2=> array ('mfakrit' => 40) , 3 => array( 'mfuvorot' => 40),  4=> array('mfauvorot' => 40)),
'mast'=> array (  2 => array( 'gtopor' => 1) , 3 => array( 'gdubina' => 1), 4=> array ( 'gmech' => 1)),
'magic'=> array (1=> array ('gfire' =>1), 2=> array ('gwater' => 1) , 3=> array('gair' => 1), 4=> array ('gearth' => 1)));  

$bohtml=array(
		'bron1' => '����� ������',
		'bron2' => '����� �������',
		'bron3' => '����� �����',
		'bron4' => '����� ���',
		'ghp' =>'������� �����' ,
		'mfkrit' =>'��. ����������� ������' ,
		'mfakrit' => '��. ������ ����. ������' ,
		'mfuvorot' => '��. ������������', 
		'mfauvorot' =>'��. ������ ��������.',
		'gsila' =>'����' ,
		'glovk' => '��������' ,
		'ginta' => '��������', 
		'gintel' =>'���������',
		'gmp' =>'��������',
		'gnoj' =>'���������� �������� ������ � ���������' ,
		'gtopor' =>'���������� �������� �������� � ��������',
		'gdubina' => '���������� �������� ��������, ��������', 
		'gmech' =>'���������� �������� ������',
		'gfire' =>'���������� ���������� c����� ����',
		'gwater' => '���������� ���������� c����� ����',
		'gair' => '���������� ���������� c����� �������',
		'gearth' => '���������� ���������� c����� �����',
		'ab_mf' =>'�������� ������������� ��',
		'ab_bron' => '�������� �����',
		'ab_uron' => '�������� �����');
		
		$pp=array(
		'mfkrit' =>'%' ,
		'mfakrit' => '%' ,
		'mfuvorot' => '%', 
		'mfauvorot' =>'%',
		'ab_mf' =>'%',
		'ab_bron' => '%',
		'ab_uron' => '%');



$mag_config_levels[100011]=1;
$mag_config_levels[100012]=2;
$mag_config_levels[100013]=3;
$mag_config_levels[100015]=4;

$used_blevel=$mag_config_levels[$magic[id]];

$item=(int)($_POST['target']);
if (($used_blevel>=1) and ($used_blevel<=4))
{
//1. ��������� �������
						
	/*if ($used_blevel==1)
		{
		$addsql=" (isnull(charka) or LEFT(charka,1)>=0)  ";
		}
		else
		{
		$addsql=" (LEFT(charka,1)>=".($used_blevel-1).") ";
		}
	
$item = mysql_fetch_array(mysql_query("select * from oldbk.inventory where id='{$item}' and  owner = '{$_SESSION['uid']}'  and dressed=0  and (art_param='' or  isnull(art_param) ) and ab_uron= 0 and ab_bron=0 and ab_mf = 0 and  `setsale`=0 AND  `bs_owner`='{$user[in_tower]}'  AND present!='�������� �����'   AND (arsenal_klan = '' OR arsenal_owner=1 ) AND type in (1,2,3,4,5,8,9,10,11) and ".$addsql));
*/

$nlevel=0;
if ($rowm['nlevel']>0)
	{
	$nlevel=$rowm['nlevel'];
	}

if ($rowm['sowner']>0)
	{
	$item = mysql_fetch_array(mysql_query("select * from oldbk.inventory where naem = 0 and id='{$item}' and (name like '%(��)%' ) and  owner = '{$_SESSION['uid']}'  and (sowner=0 or sowner='{$_SESSION['uid']}' )  and dressed=0 and nlevel>='{$nlevel}' and (art_param='' or  isnull(art_param) ) and ab_uron= 0 and ab_bron=0 and ab_mf = 0 and  `setsale`=0 AND  `bs_owner`='{$user[in_tower]}'  AND present!='�������� �����'    AND `prokat_idp`=0  AND arsenal_klan = ''  AND type in (1,2,3,4,5,8,9,10,11)   and prototype not in (169,170,601,632,946,947,948,949,950,951,952,953,954,955,956,957) and gmeshok = 0 AND NOT ((`prototype` >= 410001  and `prototype` <= 410030) or (`prototype` >= 55510301  and `prototype` <= 55510401))"));
	}
else
	{
	$item = mysql_fetch_array(mysql_query("select * from oldbk.inventory where naem = 0 and id='{$item}' and (name like '%(��)%' ) and  owner = '{$_SESSION['uid']}'  and dressed=0 and nlevel>='{$nlevel}' and (art_param='' or  isnull(art_param) ) and ab_uron= 0 and ab_bron=0 and ab_mf = 0 and  `setsale`=0 AND  `bs_owner`='{$user[in_tower]}'  AND present!='�������� �����'    AND `prokat_idp`=0  AND arsenal_klan = ''  AND type in (1,2,3,4,5,8,9,10,11)   and prototype not in (169,170,601,632,946,947,948,949,950,951,952,953,954,955,956,957) and gmeshok = 0 AND NOT ((`prototype` >= 410001  and `prototype` <= 410030) or (`prototype` >= 55510301  and `prototype` <= 55510401))"));
	}


if ($item['arsenal_klan'] != "") {
	echo '�������� ����������.';
	return;
}



 if ($item['id']>0)
 		{
 		//������ ��������� III �� ������
		//	if ( (($rowm['getfrom']==42) and (($magic[id]==100013) OR ($magic[id]==100015)) ) and ($item['sowner']>0) and ($item['sowner']!=$user['id'] ) )
			if (($item['sowner']>0) and ($item['sowner']!=$user['id'] ) )
			{
			$whocan=mysql_fetch_array(mysql_query("select * from users where  id='{$item['sowner']}' "));
			err('���������� ���� ������� ����� ������ '.s_nick($whocan['id'],$whocan['align'],$whocan['klan'],$whocan['login'],$whocan['level']));
			}
		else
		{	
		if (is_array($mag_config[$magic[id]]))
			{
			$conf_array=$mag_config[$magic[id]];  // ����� ��� ������� �� ��������������� ������ ������

			if ($item['charka']!='')
				{
				$charka=substr($item['charka'], 2,strlen($item['charka'])-1); //���������� ������ ��� �������
				$inputbonus=unserialize($charka); //��� ������
				$charka_level=(int)($item['charka'][0]); //������ ������ ��� �������
				}
				else
				{
				$charka_level=0;
				$inputbonus=array();
				}

						 if (($charka_level > 0) and ($charka_level == $used_blevel) and (count($inputbonus)>0) and ($item['charka']!='') )
						{
						//�������� �� ������� ������������  ���������� ��� �������������
										foreach($conf_array as $n=>$ar) // ���������� �� ���� ��� ���� ������
										{
											if ($n=='ghp')	
													{ 
													foreach($inputbonus[$used_blevel] as $pn=>$pv)
														{
														 if ($pv['ghp']>0)
														 	{
															$del_hp_key=array_search($pv['ghp'], $ar); 
															//unset($conf_array['ghp'][$del_hp_key]);
															break;
															}
														}
														
													} 
													else 
													{ 
														foreach($inputbonus[$used_blevel] as $pn=>$pv)
															{
															$del_key=array_search($pv, $ar); 
																if ($del_key>0)
																	{
																	unset($conf_array[$n][$del_key]);
																	break;
																	}
															}
													}
										}
						}
					
			$array_to_add=array(); //������� ����� ��� ���������� ����������
			foreach($conf_array as $n=>$ar) // ���������� �� ���� ��� ���� ������
			{
				$add_param=$ar; // ��������� ����				
				shuffle($add_param); // ������ ������
				if ($n=='ghp')	{ $array_to_add[$used_blevel][]=array('ghp'=> $add_param[0]); } else { $array_to_add[$used_blevel][]=$add_param[0]; }
			}

			//��������� ��������� �� �������


			 if (is_array($array_to_add))
			 	{
			 	//���� ���������
				//print_r($array_to_add);

							//��� ��
								//������ ������ ������. ���� ��� ���� �  ��������� ������ �� ������  (��� ������) ��� � �������� ������ - �� ���� ������� ������
								 if (($charka_level > 0) /*and ($charka_level >= $used_blevel) */ and (count($inputbonus)>0) )
								 {
								// echo "���������� ������������� - ������� ������";
								 	
								 	//������ ���� ��� �������  $used_blevel  ������ ������ �� ��������

								 	foreach($inputbonus as $lvl=>$todel)
							 			{
							 				$upsql='';
											foreach($todel as $k=>$v)
									 	 	{
									 	 		foreach($v as $pole=>$val) { $upsql.=" `{$pole}`=`{$pole}` - {$val} ,"; }
									 	 	}
									 		$upsql= substr($upsql,0,-1);
											 	 
											mysql_query("UPDATE oldbk.inventory SET $upsql WHERE id= '{$item['id']}' ");
											if (mysql_affected_rows()>0)
									 		{
											 // echo "������ ������ �����";
											unset($inputbonus[$lvl]); //������� ������ ������ �� �������
											$new_update=true;
											}
							 			}
							 		
								 	
								 }
								 else
								 {
								 $new_update=true;
								 }


									if ($new_update)
									{
									$upsql="";
	
										if (count($inputbonus)>0)
											{
											$new_config=$inputbonus+$array_to_add;
											}
											else
											{
											$new_config=$array_to_add;
											}

									 	 foreach($array_to_add[$used_blevel] as $k=>$v)
									 	 	{
									 	 		foreach($v as $pole=>$val) { $upsql.=" `{$pole}`=`{$pole}`+ {$val} ,"; }
									 	 	}
									 	 $upsql= substr($upsql,0,-1);
										
										
										
										
							//			if ($used_blevel>$charka_level) {$new_level=$used_blevel;} else {$new_level=$charka_level;}
										$new_level=$used_blevel;
										
										if ($item['getfrom']==1)
														{
														//�� ������� ������� ���� ������ � �������
														$add_sowner="";														
														}
										elseif ($rowm['sowner']>0 || $magic['id'] == 100013)
														{
														$add_sowner="  `sowner`= '{$user['id']}' , ";
														}
														else
														{
														$add_sowner="  `sowner`= 0 , ";
														}
																				
									 	mysql_query("UPDATE oldbk.inventory SET $upsql  , ".$add_sowner." `charka`='".$new_level."|".serialize($new_config)."'  WHERE id= '{$item['id']}' ");
									 	// echo "���������� ����� ����� <br>";		
										 	if (mysql_affected_rows()>0)							
										 		{
								 				echo "<font color=red>������ ������������ ����� <b>\"{$rowm['name']}\"<br>";
								 				
												ksort($new_config);
												$infoc=" ���������: ";
												$infoc2="������� ������� ��������� ��������������:<br>";
												foreach($new_config as $blevl => $bdata)			
													{
													$infoc .= "{$blevl}� ���������:";
															foreach($bdata as $pk => $pv)											
																{
																foreach($pv as $k => $v) 
																	{
																	$infoc .= "&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k].";";
																	$infoc2 .= "&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]." <br>";
																	}
																}
													}
								 				echo $infoc2."</b></font>" ;
								 				$rec=array();
								 				$rec['owner']=$user['id'];
												$rec['owner_login']=$user['login'];
												$rec['owner_balans_do']=$user['money'];
												$rec['owner_balans_posle']=$user['money'];
								 				$rec['target'] = 0;
												$rec['target_login'] = '���������';
												$rec['type']=1179;
												$rec['sum_kr']=0;
												$rec['sum_ekr']=0;
												$rec['sum_kom']=0;
												$rec['item_count']=0;
												$rec['item_id']=get_item_fid($item);
												$rec['item_name']=$item['name'];
												$rec['item_count']=1;
												$rec['item_type']=$item['type'];
												$rec['item_cost']=$item['cost'];
												$rec['item_dur']=$item['duration'];
												$rec['item_maxdur']=$item['maxdur'];
												$rec['item_ups']=$item['ups'];
												$rec['item_unic']=$item['unik'];
												$rec['item_incmagic']=$item['includemagicname'];
												$rec['item_incmagic_count']=$item['includemagicuses'];
												$rec['add_info']="(id:".$rowm['id'].") ".$rowm['name']." ".$infoc;

												add_to_new_delo($rec); //�����
								 				$rec=array();
								 				
												$sbet = 1;
												$bet=1;
										 		}
										 		else
										 		{
										 		echo "<font color=red>������ ������������� ����� <b>\"{$magic[name]}\"</b></font>";
										 		}
									}
									
					
			 	}
			 		else
					{
					echo err('������ �������� ������!');
					}			 			
			}
			else
					{
					echo err('������ �������� �����!');
					}
			}
			}
	 		else
	 		{
			echo err('������: ������� �� ������!');					 		
	 		}						 		
}
		else
		{
		echo err('������ ������!');
		}	 		
	}
?>