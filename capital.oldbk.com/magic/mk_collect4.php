<?
//print_r($_POST);
//print_r($_GET);
if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) {
	header("Location: index.php");
	die();
}


$che=(int)($_GET['use']);
$item = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory WHERE id='{$che}' and owner = '{$_SESSION['uid']}' and (sowner=0 or sowner = '{$user['id']}') AND type=99 AND bs_owner = '".$user[in_tower]."' AND `setsale`=0 ;"));

if (($item['id']>0) and  ($item['prototype']==114010)) //������ ��������� �4';
	{
		//���������
		$get_all_cards=mysql_query("select * from oldbk.inventory where owner = '{$_SESSION['uid']}'  and prototype>=114001 and prototype<=114008 group by prototype");
		$ccids=array();
		$ckol=0;
		while($rcards = mysql_fetch_assoc($get_all_cards)) 
			{
			$ccids[]=$rcards['id'];
			$ckol++;
			}
		
		if ($ckol==8)
			{
				mysql_query("DELETE FROM oldbk.inventory where owner = '{$_SESSION['uid']}' and id in (".implode(",",$ccids).") ");
				if (mysql_affected_rows()==8)
				{
				//���������
				        $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.shop WHERE `id` = '114000' LIMIT 1;"));
					if ($dress['id']>0)
							{
							//������ �������� ������
							
							//include("cards_config.php");
							include "/www/capitalcity.oldbk.com/cards_config.php";

							$dress['goden']=30; 
							$dress['dategoden']=$dress['goden']*24*60*60+time();							
							
							if (mysql_query("INSERT INTO oldbk.`inventory`
							(`prototype`,`owner`,`sowner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,
								`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
								`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`letter`
							)
							VALUES
							('{$dress['id']}','{$user['id']}','0','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
							'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','�����','0','0','{$dress['group']}','{$user['id_city']}','{$dress['letter']}'
							) ;") )
						     	{
						     		$dress['id']=mysql_insert_id();
 	      	            
										if (mysql_affected_rows()>0)
											{
												// ����� � ����
								 				$rec=array();
								 				$rec['owner']=$user['id'];
												$rec['owner_login']=$user['login'];
												$rec['owner_balans_do']=$user['money'];
												$rec['owner_balans_posle']=$user['money'];
								 				$rec['target'] = 0;
												$rec['target_login'] = '���������';
												$rec['type']=1144;
												$rec['sum_kr']=0;
												$rec['sum_ekr']=0;
												$rec['sum_kom']=0;
												$rec['item_count']=0;
												$rec['item_id']=get_item_fid($dress);
												$rec['item_name']=$dress['name'];
												$rec['item_count']=1;
												$rec['item_type']=$dress['type'];
												$rec['item_cost']=$dress['cost'];
												$rec['item_dur']=$dress['duration'];
												$rec['item_maxdur']=$dress['maxdur'];
												$rec['add_info']="��������� ������ ������� �����! �� ����:(".implode(",",$ccids).") ������:".$che;
												add_to_new_delo($rec); //�����
								 				$rec=array();

					 						$getitems1=DropBonusItem(4018,$user,'�����','��������� ������ ������� �����',30,1,37,true,true);
											echo "<font color=red><b>�����������! ������ ������� ��������� ������ ������� �����!<b></font> ";
											$bet=1;
											$sbet = 1;
											}
							}
							}
				}
			}
			else
			{
			echo "<font color=red><b>������������ ��������� ��� ��������� ���������!<b></font> ";
			}
	}


?>