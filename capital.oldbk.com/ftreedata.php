<?
	session_start();
	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
	include "connect.php";
	include "functions.php";
	require_once('config_ko.php');
	
	if ($user['klan']=='radminion') 
	{
	$KO_start_time22=time()-1;
	$KO_fin_time22=time()+1;	
	}
	
	if ( ( ((time()>$KO_start_time22) and (time()<$KO_fin_time22)) and ($user['room']==21) ) OR 
	     ( ((time()>$KO_start_time42) and (time()<$KO_fin_time42)) and ($user['room']==21) ) )
	{
	//print_r($_GET);
?>

<style>
.close {
    position: absolute; z-index: 350;  right: 10px; top: 10px; width: 15px; height: 15px; background-image: url("http://i.oldbk.com/i/diz/close.png"); cursor: pointer;
    }
.close:hover {
    background-image: url("http://i.oldbk.com/i/diz/close_h.png");
}

.list {
    position: relative;
    max-height: 100px;
    margin: 0px 0 0 0px;
    text-align: left;
    overflow: hidden;
    background-color:#CCC3AA;
}

</style>
<div class="close"  onclick="closeinfo();";></div>
 <div class="list">
        <ul>
            <?
	echo "<center><b>������ �������</b></center>";
            ?>
        </ul>
    </div>
	<?
	if ($_GET['step']==0)
	{
	//������ ����� , ����� ��������
	?>
    <table border=0 CELLSPACING='5' CELLPADDING='5' >
    <tr valign=top>
    <td>
    		<?
    			if ((time()>$KO_start_time22) and (time()<$KO_fin_time22))
    				{
				echo "<img src='http://i.oldbk.com/i/city/sub/ftree_png2.png' border=1>";    				
    				}
				elseif ((time()>$KO_start_time42) and (time()<$KO_fin_time42))
				{
				echo "<img src='http://i.oldbk.com/i/city/sub/autumn_ftree2.png' border=1>";    				
				}
    		?>

	 </td>
	<td> <div align="justify">
�� ����� ������� 
<?
	if ((time()>$KO_start_time22) and (time()<$KO_fin_time22))
		{
		echo "�<b><a href=http://oldbk.com/encicl/?/fight_flowers.html target=_blank>��������� �����</a></b>� � �������� ���� ����� �������� �<b>������� ��������</b>� � �������� �� �� �<b>������ �������</b>�, ����� ������� ���� �� ��������, ���������� ��� ��� �������.<br>";
		}
	elseif ((time()>$KO_start_time42) and (time()<$KO_fin_time42))
		{
		echo "�<b><a href=http://oldbk.com/encicl/?/autumn_even.html target=_blank>������� �����</a></b>� � ����������� ���� ����� �������� �<b>������� ��������</b>� � �������� �� �� �<b>������ �������</b>�, ����� ������� ���� �� ��������, ���������� ��� ��� �������.<br>";
		}
?>
  </div>
	</td>
	<td width=20>&nbsp;</td>
	</tr>
	<tr align=center>
		<?
			$get_len=mysql_query("select * from oldbk.inventory where owner='{$user['id']}' and prototype=411000 and setsale=0"); 

			if (mysql_num_rows($get_len) > 0) 
			{
					$ret .= "<td colspan=3><b>��� ��������:</b> <br><br><table border=2  WIDTH=80% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
					while($row = mysql_fetch_assoc($get_len)) {
						if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
			
						$ret .= showitem($row,0,false,$color,'<a href="#" onclick="getftreedata('.$row['id'].',1,event);"  > �������� </a>',0,0,1);
					}
					$ret .= "</table><br><br><br></td>"; 
					echo $ret ;
					
			} else {
				echo '	<td colspan=3><br><center> <b> � ��� ��� �������� ��� ������ ������� :( </b></center></td> ' ;
				}
		?>
	
	</tr>
	</table>
	<?
		}
		elseif ( ($_GET['step']>=1) and ((int)($_GET['id'])>0) )
		{
			//���������  �����
			$lentaid=(int)($_GET['id']);
			
				$test_lena=mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where id='{$lentaid}' and setsale=0 and owner='{$user['id']}' and prototype=411000")); 
				if ($test_lena['id']>0)
				{
				// ���� ����� ����� 
					
					if ($_GET['step']==1)	
					{
						//������ �������
						$sunduk=array(1,2,3,4,5,6);
						shuffle($sunduk);
						echo '	<div align=center><br> <b>��������� ���� ������ � �������� ���� �� ��������</b> <br><br><br>
						<table border=0  WIDTH=60% CELLSPACING=0 CELLPADDING=0>
						<tr>
						<td><a href=#  onclick="getftreedata('.$test_lena['id'].',2,event);" ><img src="http://i.oldbk.com/i/sunduk2015_flowers'.$sunduk[0].'.gif"></a></td>
						<td><a href=#  onclick="getftreedata('.$test_lena['id'].',3,event);" ><img src="http://i.oldbk.com/i/sunduk2015_flowers'.$sunduk[1].'.gif"></a></td>
						<td><a href=#  onclick="getftreedata('.$test_lena['id'].',4,event);" ><img src="http://i.oldbk.com/i/sunduk2015_flowers'.$sunduk[2].'.gif"></a></td>
						</tr></table>
						</div> ' ;
					}
					else
					{
					//��� ������ �� ������ , ��������� �������
					// ������� �����  = ������ � ����
					//���� ���-�� ������ , �������� �������� � �������� � ����
					/*
					<<< ������ �� ������:
						1 ������� � ����� - ��������  shop 4016
						2 ������� ���� - ��������  shop 5100
						3 ��������� ���� - �������� shop 5000
						4������� ������ � �������� -20% shop 19107
						5������� ����� ������� ����� -20% shop 19106
						6������� ��������� -20% shop 19105
						7������� ��������� ����� -20% shop 19104
						8������ ���� +20% shop 19103
						9���� +20% shop 19102
						10��������� +20% eshop 19020
						11�������� ��������� ��������� (�� �������) eshop 145145
						12����������� (�� �������) eshop 301
						13�������������� (�� �������) eshop 101111
						14���� ������� (�� �������) eshop 3001003
					*/
					
					
					
					
					
					            $items_array[1]['id']=4016;$items_array[1]['shop']='shop';   //������� � ����� �����������                                                        
					            $items_array[2]['id']=20106;$items_array[2]['shop']='shop';  //������� ������ �������� ����� ������� ����� -50%�  
					            $items_array[3]['id']=20105;$items_array[3]['shop']='shop';  //������� ������ �������� ��������� -50%�                                                               
					            $items_array[4]['id']=20104;$items_array[4]['shop']='shop';  //������� ������ �������� ��������� ����� -50%�  
					            $items_array[5]['id']=580;$items_array[5]['shop']='shop';  // ������ "������ ���� 1�"    
				        	    $items_array[6]['id']=3001003;$items_array[6]['shop']='eshop';   //���� �������   
					            $items_array[7]['id']=105103;$items_array[7]['shop']='shop'; $items_array[7]['goden']=30;  //������ ������� 
					            $items_array[8]['id']=249249;$items_array[8]['shop']='shop'; //������� ������ ��������������� 180HP� 
					            $items_array[9]['id']=271271;$items_array[9]['shop']='shop'; //������� ������ ��������������� 360HP�                                        
					            $items_array[10]['id']=3001002;$items_array[10]['shop']='shop'; //���� �����
					            $items_array[11]['id']=106102;$items_array[11]['shop']='shop'; $items_array[11]['goden']=14; //������� ����� ����
					            $items_array[12]['id']=105;$items_array[12]['shop']='shop'; $items_array[12]['goden']=7; //������ �������
					            $items_array[13]['id']=55557;$items_array[13]['shop']='shop'; //������� ������ ������� �� ����� 
					            $items_array[14]['id']=313;$items_array[14]['shop']='shop'; //������� ������ ��������������� 90 ����� 
					            $items_array[15]['id']=14005;$items_array[15]['shop']='shop'; //������� ������ ������� 
					            $items_array[16]['id']=119119;$items_array[16]['shop']='shop'; //������� ������ �������������
					            $items_array[17]['id']=314;$items_array[17]['shop']='shop'; //������� ������ ��������������� 180 �����
					            $items_array[18]['id']=19020;$items_array[18]['shop']='shop'; //��������� +20% 
					            $items_array[19]['id']=1002224;$items_array[19]['shop']='shop'; //������� �������
					            $items_array[20]['id']=19103;$items_array[20]['shop']='shop'; //������ ���� +20%
					            $items_array[21]['id']=55558;$items_array[21]['shop']='shop'; //������� ������ ������� �� ����� 
					            $items_array[22]['id']=106103;$items_array[22]['shop']='shop'; $items_array[22]['goden']=30; //������� ����� ���� 
					            $items_array[23]['id']=34007;$items_array[23]['shop']='eshop'; $items_array[23]['goden']=10; //����
					            $items_array[24]['id']=5100;$items_array[24]['shop']='shop'; //��������� ���� (x2)							
							mysql_query("DELETE from oldbk.inventory where id='{$lentaid}' and setsale=0 and owner='{$user['id']}' and prototype=411000");												
							if (mysql_affected_rows()>0)							
										{
										$random_item=mt_rand(1,24); //50% ����
											
											 if (is_array($items_array[$random_item]))
											 	{
											 	// ������
												 	  $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`{$items_array[$random_item]['shop']}` WHERE `id` = '{$items_array[$random_item]['id']}' LIMIT 1;")); 
												 	   if ($dress['id']>0)
												 	   			{
												 	   			$dress['present']='������ �������';
												 	   			
												 	   			if ($items_array[$random_item]['goden']>0)
												 	   				{
												 	   				$dress['goden']=$items_array[$random_item]['goden']; // ���� �������� �� �������
												 	   				}
												 	   				else
												 	   				{
												 	   				//���� ��� � ������� ������ 30 ����
													 	   			$dress['goden']=30; //��� ������ ������� ���� �������� 30 ����
													 	   			}
																	$dress['notsell'] = 1;
													 	   			
	 	   														$dress['dategoden']=(($dress['goden'])?($dress['goden']*24*60*60+time()):"");
												 	   			
																if (mysql_query("INSERT INTO oldbk.`inventory`
																(`getfrom`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`, `ecost` ,`img`,`img_big`,`maxdur`,`isrep`,
																	`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
																	`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`notsell`,`letter`
																)
																VALUES
																('21','{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']}, {$dress['ecost']} ,'{$dress['img']}','{$dress['img_big']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
																'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$dress['present']}','{$dress['labonly']}','0','{$dress['group']}','{$user[id_city]}','{$dress['notsell']}','{$dress['letter']}'
																) ;") )
															     {
															     		$dress['id']=mysql_insert_id();
															     		$dress['idcity']=$user[id_city];
															     		//new delo
																	$rec['owner']=$user[id]; $rec['owner_login']=$user[login];
																	$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];					
																	$rec['target']=0;$rec['target_login']='������ �������';
																	$rec['type']=6060;//�������  ��������
																	$rec['sum_kr']=0; $rec['sum_ekr']=0;
																	$rec['sum_kom']=0; $rec['item_id']=get_item_fid($dress);
																	$rec['item_name']=$dress['name'];
																	$rec['item_count']=1;
																	$rec['item_type']=$dress['type'];
																	$rec['item_cost']=$dress['cost'];
																	$rec['item_ecost']=$dress['ecost'];																	
																	$rec['item_dur']=$dress['duration'];
																	$rec['item_maxdur']=$dress['maxdur'];
																	$rec['item_ups']=0;
																	$rec['item_unic']=0;
																	$rec['add_info']='�����:id'.$lentaid;
																	add_to_new_delo($rec); 
															   		addchp ('<font color=red>��������!</font> �� �������� <b>'.link_for_item($dress).'</b> ','{[]}'.$user[login].'{[]}',$user['room'],$user['id_city']);
															   		echo "<center><table border=0  WIDTH=80% align=center>
															   		<tr>
															   		<td colspan=\"2\" align=center><b> ��� ���������� �����!<br>
															   		������ ������� �������� ���:</td>
															   		</tr>
															   		<tr><td align=right><br><br><br><img src=http://i.oldbk.com/i/sh/".$dress['img']."></td>
															   		<td><br><br><br><b>".link_for_item($dress)."</b><br></td></tr>
															   		<tr><td colspan=\"2\" align=center><br><br><br>
															   		<a href=# onclick=\"getftreedata(0,0,event);\"> ����������� ��� ���! </a> </td></tr></table></center> ";												 	   			
									            						}
												 	   			
																
																//��������
																
												 	   			}
												 	   			else
												 	   			{
												 	   			echo "<table border=0  WIDTH=80% align=center><tr><td><br><b>������! ���� ������� �� ���� ��� �� �������...</b><br></td></tr><tr><td align=center><br><br><br><br><a href=# onclick=\"getftreedata(0,0,event);\"> ����������� ��� ���! </a> </td></tr></table> ";												 	   			
												 	   			}
												 	   			
											 	}
											 	else
												{
												echo "<table border=0  WIDTH=80% align=center><tr><td><br><b>��� �� �������, ���� ������� �� ���� ��� �� �������...</b><br></td></tr><tr><td align=center><br><br><br><br><a href=# onclick=\"getftreedata(0,0,event);\"> ����������� ��� ���! </a> </td></tr></table> ";
												//����� � ����
												/// �� �����!
													$rec['owner']=$user[id]; $rec['owner_login']=$user[login];
													$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];					
													$rec['target']=0;$rec['target_login']='������ �������';
													$rec['type']=6061;//�� �������  ��������
													$rec['sum_kr']=0; $rec['sum_ekr']=0;
													$rec['sum_kom']=0; $rec['item_id']=get_item_fid($test_lena);
													$rec['item_name']=$test_lena['name'];
													$rec['item_count']=1;
													$rec['item_type']=$test_lena['type'];
													$rec['item_cost']=$test_lena['cost'];
													$rec['item_dur']=$test_lena['duration'];
													$rec['item_maxdur']=$test_lena['maxdur'];
													$rec['item_ups']=0;
													$rec['item_unic']=0;
													$rec['add_info']='�����:id'.$lentaid;
													add_to_new_delo($rec); 
												}
										
										
										
										
										}
										else
										{
										echo "<table border=0  WIDTH=80% align=center><tr><td><br><b>����� �� �������, ���� ������� �� ���� ��� �� �������...</b><br></td></tr><tr><td align=center><br><br><br><br><a href=# onclick=\"getftreedata(0,0,event);\"> ����������� ��� ���! </a> </td></tr></table> ";
										}
																																																								
							
					
					}

				
				
				}
				else
				{
				echo "Error id item";
				}
		}
	
	}
	?>
    
