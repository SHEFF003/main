<?
if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) {
	header("Location: index.php");
	die();
}

 if (!isset($_GET['clearstored']))
 	{
 	
$mag_config[100001]=array(
1=> array ('bron1' => 3,'bron2' => 3,'bron3' => 3,'bron4' => 3, 'ghp' =>40) ,
2=> array ('bron1' => 11,'bron2' => 11,'bron3' => 11,'bron4' => 11) ,
3=> array ('ghp' =>55) );

$mag_config[100002]=array(
1=> array ('mfkrit' =>70) ,
2=> array ('mfakrit' => 70) ,
3=> array ('mfuvorot' => 70), 
4=> array ('mfauvorot' =>70) ); 	


$mag_config[100003]=array(
1=> array ('gsila' =>7) ,
2=> array ('glovk' => 7) ,
3=> array ('ginta' => 7), 
4=> array ('gintel' =>7),
5=> array ('gmp' =>7) );

$mag_config[100004]=array(
1=> array ('gnoj' =>2) ,
2=> array ('gtopor' => 2) ,
3=> array ('gdubina' => 2), 
4=> array ('gmech' =>2));

$mag_config[100005]=array(
1=> array ('gfire' =>2) ,
2=> array ('gwater' => 2) ,
3=> array ('gair' => 2), 
4=> array ('gearth' =>2) );

$mag_config[100006]=array(
1=> array ('ab_mf' =>3) ,
2=> array ('ab_bron' => 6) ,
3=> array ('ab_mf' =>1 , 'ab_uron' => 1));

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

$used_blevel=$magic[id]-100000;
$item=(int)($_POST['target']);
if (($used_blevel>=1) and ($used_blevel<=6))
{
//1. ��������� �������
						
	if ($used_blevel==1)
		{
		$addsql=" (b.blevel>=0 or ISNULL(b.blevel) ) ";
		}
		else
		{
		$addsql="  b.blevel>=".($used_blevel-1)." ";
		}

	
$item = mysql_fetch_array(mysql_query("select i.*, b.blevel as bonus_level , ifnull(b.info,'') as bonus_info from oldbk.inventory as i LEFT JOIN oldbk.art_bonus as b ON i.id=b.itemid where id='{$item}' and owner = '{$_SESSION['uid']}' and sowner = '{$_SESSION['uid']}'  and art_param!='' and dressed=0 and ".$addsql." and  `setsale`=0 AND  `bs_owner`='{$user[in_tower]}' AND present!='�������� �����'   AND (arsenal_klan = '' OR arsenal_owner=1 )  "));	

 if ($item['id']>0)
 		{
		
		if (is_array($mag_config[$magic[id]]))
			{
			$conf_array=$mag_config[$magic[id]];  // ����� ��� ������� �� ��������������� ������ ������
			
				if ($item['bonus_info']!='')
					{
					$inputbonus=unserialize($item['bonus_info']); //��� ������
					$prep_array=$inputbonus[$used_blevel]; //�� ��� ���� ��� ��������������� ������
					 if (is_array($prep_array) )
					 	{
						$get_used_key = array_search($prep_array, $conf_array); // ������� ����� ������ ��� � ������� ��� ��� ������� ������
						//echo "��������� ������ $get_used_key !!! <br>";
						unset($conf_array[$get_used_key]); // ������� �� ������������ ������ ������!
						}
						else
						{
						//echo "���  ��� ����� ������ ������ ������";
						}
					
					}
			

			shuffle($conf_array); // ������������ ������ ������
			
			//print_r($conf_array);
			
			$conf_array=$conf_array[0]; // ����� ������ - ����� ��� ����������� ������ �� 0
			 if (is_array($conf_array))
			 	{
			 	//���� ���������
								//��� ��
								//������ ������ ������. ���� ��� ���� �  ��������� ������ �� ������  (��� ������) ��� � �������� ������ - �� ���� ������� ������
								 if (($item['bonus_info']!="") and ($item['bonus_level'] >= $used_blevel) )
								 	{
								 	$old_bonus=unserialize($item['bonus_info']);
								 	//������ ���� ��� �������  $used_blevel  ������ ������ �� ��������
								 	$todel=$old_bonus[$used_blevel];
								 	
								 	if ($conf_array!=$todel)
								 		{
											 	$upsql='';
											 	 foreach($todel as $k=>$v)
											 	 	{
												 	$upsql.=" `{$k}`=`{$k}`-{$v} ,";
											 	 	}
											 	 $upsql= substr($upsql,0,-1);
			
											 	mysql_query("UPDATE oldbk.inventory SET $upsql WHERE id= '{$item['id']}' ");
									 		if (mysql_affected_rows()>0)
									 		{
											 	// echo "������ ������ �����";
											 	// echo "<br>";
											 	 // ������ �����
											 	 unset($old_bonus[$used_blevel]); // �������� ������
											 	// echo "��������� ����� <br>";
												$old_bonus[$used_blevel]=$conf_array; //����� �����
			
												//��������� ������ � ������� ������ - ������������ ������� ������ �� �������
												 mysql_query("UPDATE `oldbk`.`art_bonus` SET `info`='".serialize($old_bonus)."' where `itemid`='{$item['id']}' ;");
													
													if (mysql_affected_rows()>0)
														{
														$new_update=true;
														}
											}
											else
											{
											echo "������ �������� ������� ������!";								 		 	
											}
								 		 }
								 		 else
								 		 	{
								 		 	echo "������ ��������, ������ �� ��������� � ��������!";
								 		 	}
								 	}
								 	elseif (($used_blevel > $item['bonus_level'] ) and ($item['bonus_info']!="") ) // ���� ������ �������� ������ �� �� �������� ������ � ������ ������ ������
								 	{
								 	$old_bonus=unserialize($item['bonus_info']);
								 	$old_bonus[$used_blevel]=$conf_array; //����� �����
								 	//��������� ������ � ������� ������
								 	//echo "��������� ������� ������ - ��������� ����� ���������<br>";
									 mysql_query("UPDATE `oldbk`.`art_bonus` SET `blevel`='{$used_blevel}',`info`='".serialize($old_bonus)."' where `itemid`='{$item['id']}' ;");
										
										if (mysql_affected_rows()>0)
											{
											$new_update=true;
											}
								 	
								 	}
								 	else
								 	{
									//������ ������ � ������� �������
									$new_bonus[$used_blevel]=$conf_array;
									
										
									//������ ���� � 0� ������� ���� ���������� ������ � ���������
									mysql_query("INSERT INTO `oldbk`.`art_bonus` SET `itemid`='{$item['id']}',`blevel`='{$used_blevel}',`info`='".serialize($new_bonus)."' ON DUPLICATE KEY UPDATE `blevel`='{$used_blevel}',`info`='".serialize($new_bonus)."' ");
									if (mysql_affected_rows()>0)
											{
											$new_update=true;
											}										

									}
									
									
									if ($new_update)
									{
									$upsql="";
									 	 foreach($conf_array as $k=>$v)
									 	 	{
										 	$upsql.=" `{$k}`=`{$k}`+ {$v} ,";
									 	 	}
									 	 $upsql= substr($upsql,0,-1);
	
									 	mysql_query("UPDATE oldbk.inventory SET $upsql WHERE id= '{$item['id']}' ");
									 	// echo "���������� ����� ����� <br>";		
										 	if (mysql_affected_rows()>0)							
										 		{
								 				echo "<font color=red>������ ������������ ����� <b>\"{$magic[name]}\"</b></font><br>";
								 				
								 				
												$infoc=" ���������: ";
												$infoc2="������� ������� ��������� ��������������:<br>";
												foreach($conf_array as $k => $v)											
														{
														$infoc .= "&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k].";";
														$infoc2 .= "&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]." <br>";
													}

								 				echo $infoc2."</b></font>" ;
								 				$rec=array();
								 				$rec['owner']=$user['id'];
												$rec['owner_login']=$user['login'];
												$rec['owner_balans_do']=$user['money'];
												$rec['owner_balans_posle']=$user['money'];
								 				$rec['target'] = 0;
												$rec['target_login'] = '���������';
												$rec['type']=1180;
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
	 		else
	 		{
			echo err('������: �������� �� ������!');					 		
	 		}						 		
}
		else
		{
		echo err('������ ������!');
		}	 		
	}
?>