<?
//echo "//������� ������ V.5.1 - 22/12/2012 + NEW_LOG";

		// ������� �������� ����
		function fteam ( $team ) {
			$team = explode(";",$team);
			unset($team[count($team)-1]);
			return $team;
		}


		// ������� ��������� ������ ������ - ����������
		function getlist ($razdel = 1, $level = null, $id = null )
		{

			if($level == 0) {$level = null;}

			if ($razdel==3) { $dgv="  (am1>0 or am2>0 or ae1>0 or ae2>0)  "; } else { $dgv=" (am1=0 and am2=0 and ae1=0 and ae2=0) "; }

			$fict = mysql_query("SELECT * FROM `zayavka` WHERE  ".$dgv." AND   ".
				(( $level != null )? " ((`t1min` <= '{$level}' OR `t1min` = '99') AND (`t1max` >= '{$level}' OR `t1max` = '99') ".(($razdel==4)?"OR ((`t2min` <= '{$level}' OR `t2min` = '99') AND (`t2max` >= '{$level}' OR `t2max` = '99'))":"").") AND " : "" ).
				" `level` = {$razdel} ".
				(( $id != null )? " AND `id` = {$id} " : "")
				." ORDER by `id` DESC;" );



		if (mysql_num_rows($fict))
		  {
			while ( $row = mysql_fetch_array($fict) )
			{
			$zay[$row['id']] = $row;
			}
			return $zay;
		  }
		   else return false;
		}



		// ���������� � ���� ����� - �����������
		function addteam ( $team = 1, $telo, $telo_eff, $zay , $zid)
			{
			global $OKADD,$user; //��� ������� � �����
			//$zay -�����
			if ($zay[start]<=time())
					{
						return "�� �� ������...";
					}

			if ($zay['subtype']==1)
			{
				if ($telo['weap']>0)
				{
				$chek_elka=mysql_fetch_array(mysql_query("select id,name from oldbk.inventory where  id='{$telo['weap']}'   ; "));

					if (strpos($chek_elka['name'], '��������� ����') === false)
					{
						return "� ��� �� ����� ����....";
					}
				}
				else
				{
				return "� ��� �� ����� ����....";
				}
			}
			elseif ($zay['subtype']==2)
				{
					if ($telo['weap']>0)
					{
					$chek_elka=mysql_fetch_array(mysql_query("select id,name,prototype from oldbk.inventory where  id='{$telo['weap']}'   ; "));

						if (!( (($chek_elka['prototype'] >=410130 ) and ($chek_elka['prototype'] <= 410136 )) || (($chek_elka['prototype'] >=410001 ) and ($chek_elka['prototype'] <= 410008 )) || (($chek_elka['prototype'] >=410021 ) and ($chek_elka['prototype'] <= 410028 ))  ))
						{
							return "� ��� �� ���� �����...";
						}
					}
					else
					{
							return "� ��� �� ���� �����...";
					}
				}
			elseif ($zay['subtype']==3)
			{

				if ($telo['uclass']==0)
				{
					return "��� �������� ��� ���������� ������������ ����� ���������, ������� � �������...";
				}
				elseif (!(	($telo['sergi'] >0) AND
						    ($telo['kulon'] >0) AND
						    ($telo['weap'] >0) AND
						    ($telo['bron']  >0) AND
						    ($telo['r1'] >0) AND
						    ($telo['r2'] >0) AND
						    ($telo['r3']>0) AND
						    ($telo['helm']>0) AND
						    ($telo['perchi']>0)  AND
						    ($telo['shit'] > 0) AND
						    ($telo['boots']>0) AND
						    ($telo['nakidka']>0) AND
						    ($telo['rubashka']>0) ) )
				{
					return "��� �������� � ������ ��������� �����...";
				}

			}
			elseif ($zay['coment'] =='<b>#zlevels</b>' )
			{


				if ($telo['weap']>0)
				{
					if ($telo['level']>7)
					{
					$chek_elka=mysql_fetch_array(mysql_query("select id,name,prototype, nlevel, otdel from oldbk.inventory where  id='{$telo['weap']}'   ; "));

						if ( (($chek_elka['prototype'] >=55510301 ) AND ($chek_elka['prototype'] <=55510352) ) OR ($chek_elka['prototype'] ==1006233 ) OR ($chek_elka['prototype'] ==1006232 ) OR ($chek_elka['prototype'] ==1006234 ) OR (($chek_elka['prototype'] >=410130  ) AND ($chek_elka['prototype'] <=410136) ) OR (($chek_elka['prototype'] >=410001  ) AND ($chek_elka['prototype'] <=410008) ) OR (($chek_elka['prototype'] >=410021  ) AND ($chek_elka['prototype'] <=410028) ) )
						{
						//����� � ������ ����� ���������

						}
						else
						if  ( (($chek_elka['nlevel']<$telo['level']) and ($telo['level']<14)) OR  (($chek_elka['nlevel']<($telo['level']-1)) and ($telo['level']>13)) )
						{
							return "������ ����� � ������� ���� ������ ������!";
						}
					}
				}
				else
				{
						return "� ��� ��� ������!";
				}
			}


			if (($telo_eff['owntravma'])>=1) //������ ������ ������
			{
					if (($telo_eff[12]>0)  && ($zay[type]!=4 AND $zay[type]!=5))
						{
						return "� ��� ������� ������, �������� � ������� ������� ������ ��� ���...";
						}
					else if ($telo_eff[13]>0 )
						{
						return "� ��� ������� ������, �� �� ������� �������...";
						}
					else if ($telo_eff[14]>0 )
						{
						return "� ��� ������� ������, �� �� ������� �������...";
						}
					else if ( ($telo_eff['owntravma'])>1)
						{
						return "� ��� ������� ������, �� �� ������� �������...";
						}
			}



			if  ($zay[nomagic]>0)
				{
				//�������� ������
				$booksa=mysql_fetch_assoc(mysql_query("select * from effects where owner='{$telo[id]}' AND type IN (791,792,793,794,795) LIMIT 1;"));
					 if ($booksa[id]>0)
					 {
					 return "��� ������ �� ����� ���� ������� ����. ��� ��� ����� - ������ ����� � ��������������� �������.";
					 }

				if (($telo['hidden']>0)AND($telo['hiddenlog']==''))
					 {
					 return "��� ������ �� ����� ���� ������� ��� ��������� �����������. ��� ��� �����!";
					 }
				elseif (($telo['hidden']>0)AND($telo['hiddenlog']!=''))
					 {
					 return "��� ������ �� ����� ���� ������� ��� ��������� ��������������. ��� ��� �����!";
					 }
				}


			if ($telo['hp'] < $telo['maxhp']*0.33)
			{
				return "�� ������� ��������� ��� ���, ��������������.";
			}

			if ( ustatus($telo) != 0) { return "��� ������ �� ����� ���� ������� ����.(2)"; }

			if ($zay['level']==7)
			{
			//��� ����� ��� ���� �������

			}
			else
			// Captcha
			if (($zay['type'] == 3 || $zay['type'] == 5) AND ($telo[prem]!=3) )
			{

			$load_captime=mysql_fetch_array(mysql_query("select UNIX_TIMESTAMP(captime) as captime from users_capcha_time where owner='{$telo['id']}' "));
			if (time()-$load_captime['captime'] < 3600) //1 �.
			{
				unset($_SESSION['securityCode']);
			}
			else
				{
				if ((!isset($_POST['securityCode1']) && !isset($_POST['securityCode2'])) || !isset($_SESSION['securityCode']) || (!strlen($_POST['securityCode1']) && !strlen($_POST['securityCode2']))) return "�� �� ����� �������� ���!";
				$code = (isset($_POST['securityCode1']) && strlen($_POST['securityCode1'])) ? $_POST['securityCode1'] : $_POST['securityCode2'];
				if ($code !== $_SESSION['securityCode']) {
					unset($_SESSION['securityCode']);
					return "�������� �������� ���!";
				}
				unset($_SESSION['securityCode']);
				//����� ����� ����� ��������� ����� �����
				mysql_query("INSERT INTO `oldbk`.`users_capcha_time` SET `owner`='{$telo['id']}', captime=NOW() ON DUPLICATE KEY UPDATE captime=NOW();");
				}

			}


			//������
		if ($zay['type'] == 20)
				{
		//check dressed items
					$check1=mysql_fetch_array(mysql_query("select count(*) from oldbk.inventory where owner='{$telo[id]}' and dressed=1 and magic!=51; "));
					$check2=mysql_fetch_array(mysql_query("select count(*) from oldbk.inventory where owner='{$telo[id]}' and dressed=1 and prototype>1000 and prototype<1045 and includemagic=0;"));
					if (($check1[0]!= $check2[0]) or ($check2[0]!=4))
						{
							return "�� ����� �� �� �����...(1)";
						}
				}

			$rr='';
			if ($team == 1) { $teamz = 2; } else { $teamz = 1; }

			if (($zay['type'] == 2 ) and ($zay['level'] == 4 ))
			{

			//�������� ������������� ����

				//1. �������� �� �������� ���� ��� ����
				 if ($zay['alig'.$team] >1)
						{

						//���� ����� �������
						$ual=(int)($telo['align']);
						if ($ual==1) $ual=4; // ����
						if ($ual==6) $ual=4; // ����
						//2=����,3-���� 4- ����
						if ($zay['alig'.$team]!=$ual) 	return "��� ������ �� ����� ���� ������� ����. ������������ ����������.";
						}
				//2. �������� �� ������ ���� ��� ����
						$my_klan_id=0;
						if ($telo[klan]!='')
						{
						$my_klan=mysql_fetch_array(mysql_query('select * from oldbk.clans where short = "'.$telo[klan].'";'));
						$my_klan_id=$my_klan['id'];
						}

					 if  (($zay['klan'.$team] >0) OR ($zay['reklan'.$team] >0) )
					 	{

					 	 if  ( ($zay['klan'.$team] !=$my_klan_id) and ($zay['reklan'.$team] !=$my_klan_id and ($my_klan_id >0)  ) ) return "��� ������ �� ����� ���� ������� ����. �� ��� ����.";
					 	 if  ( ($my_klan_id==0) and ($zay['klan'.$team] >0)) return "��� ������ �� ����� ���� ������� ����. � ��� ��� �����!";

					 	}

				//3. �������� �� �������
				//����������� ����


			}
			else
			if ($zay['type'] == 3 OR $zay['type'] == 5)
			{

			}
			else
			{


				if ($telo[klan]!='')
				{
				$my_klan=mysql_fetch_array(mysql_query('select * from oldbk.clans where short = "'.$telo[klan].'";'));
				if ($my_klan !== FALSE)
				{
					$my_klan_array=array('"'.$telo[klan].'"');

					if ($my_klan[base_klan]>0)
					{
					//� ����� ���� ������
						$my_klan_add=mysql_fetch_array(mysql_query('select * from oldbk.clans where id = "'.$my_klan[base_klan].'";'));
						if ($my_klan_add[short]!='')
						 {
							$my_klan_array[]='"'.$my_klan_add[short].'"';
						}
					}
					else
					if ($my_klan[rekrut_klan]>0)
					{
					//� ����� ���� �������
						$my_klan_add=mysql_fetch_array(mysql_query('select * from oldbk.clans where short = "'.$my_klan[rekrut_klan].'";'));
						if ($my_klan_add[short]!='')
						{
						$my_klan_array[]='"'.$my_klan_add[short].'"';
						}
					}


					$get_test_klns = mysql_fetch_array(mysql_query("select * from users where zayavka='{$zay[id]}' and battle_t='{$teamz}' and klan in (".implode(",",$my_klan_array).")  LIMIT 1;"));

					if($get_test_klns)
					{
					//���� ���� ���� ���� �� ����� ��� ������ ��� ������� - ������
					return "����� ����� ����� ��������.";
					}
				}
				}


			 if ( (($zay['am1']!=0) OR ($zay['am2']!=0) or ($zay['ae1']!=0) or ($zay['ae1']!=0)) AND ((int)($telo[align])>0)  )
			    {
			    //��� ����������� � � ���� ���� �������
			    $telo_align=(int)($telo[align]);
			    if  ($telo_align==1) { $telo_align=6;  }; //���� = ����

			    if ($team==1)
			    	{
			    	   if (($telo_align!=$zay['am1']) and ($zay['am1']!=0)) { return "��� ������ �� ����� ���� ������� ����."; }
			    	   if (($telo_align!=$zay['am2']) and ($zay['am2']!=0)) { return "��� ������ �� ����� ���� ������� ����."; }
			    	}
			    	elseif ($team==2)
			    	{
			    	   if (($telo_align!=$zay['ae1']) and ($zay['ae1']!=0)) { return "��� ������ �� ����� ���� ������� ����."; }
			    	   if (($telo_align!=$zay['ae2']) and ($zay['ae2']!=0)) { return "��� ������ �� ����� ���� ������� ����."; }
			    	}
			   }


			} // fin by type

		$t_arr=fteam($zay['team'.$team]);

			if($zay['t'.$team.'min'] == 99)
				{
				// �������� ������
				if ($telo[klan]!='')
					{
					if ($t_arr[0]!='') //������ ��� ����
					  {
						//�������� �������� ����� - ���� ������� ������ � ������� - ���� ���� ����� �����
						$toper = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='{$t_arr[0]}' LIMIT 1;"));
						if($toper['klan']!='')
						{
						if($user['klan']!=$toper['klan']) { return "��� ������ �� ����� ���� ������� ����!"; }
						}
						else
						{
						return "��� ������ �� ����� ���� ������� ����!";
						}
					  }

					}
					else
					{
					return "��� ������ �� ����� ���� ������� ����. �� �� � �����!3";
					}
				}
				else
				{
					if ($telo['level'] > 0  &&!($zay['t'.$team.'min'] <= $telo['level'] && $zay['t'.$team.'max'] >= $telo['level'])) { return "��� ������ �� ����� ���� ������� ����. ������� �� ���!"; }
				}

			if (($zay['type']==3) and ($zay['level']!=7))
				{
				//��� �������
				if ( $zay['zcount'] >= $zay['t1c'] ) { return "������ ��� �������."; }
				}
				else
				{
				if ( count($t_arr) >= $zay['t'.$team.'c'] ) { return "������ ��� �������."; }
				}

			// money
			if($zay['price']>0)
			{

			   if($telo[hidden] > 0)
			   		{
					return "� ����� ������� ������ ������� ������ �� ������...";
					}
					else
					{
						if($zay['price']>$telo[money])
						{
						return "� ��� ������������ �������� ��� �������� ���� ������.";
						}
					}

				$sql_money=" `users`.money=`users`.money-{$zay['price']} ,   ";
				$sql_money_a=" and  `users`.money >={$zay['price']}  ";

			}
			else
			{
				$sql_money="";
				$sql_money_a="";
			}

			mysql_query("UPDATE `users`, `zayavka` SET
							`users`.battle_t={$team},
							`users`.zayavka = {$zid}, ".$sql_money."
							`zayavka`.team{$team}= CONCAT(`zayavka`.team{$team},'".$telo[id].";'),
							`zayavka`.t{$team}hist=CONCAT(`zayavka`.t{$team}hist,'".BNewHist($telo)."'),
							`zayavka`.zcount=`zayavka`.zcount+1,
							`zayavka`.fond=`zayavka`.fond+".$zay['price']."
						WHERE `users`.id = {$telo[id]}  AND `zayavka`.id = {$zay[id]} AND `users`.battle=0 AND  `users`.zayavka=0 ".$sql_money_a." ");
			if (mysql_affected_rows()>0)
					{
						$ret = "�� ������� ������ �� ���";
						if($zay['price']>0)
						{
						  $ret .= ", � ��������� {$zay['price']} ��.";

		  		    			$rec['owner']=$telo[id];
							$rec['owner_login']=$telo['login'];
							$rec['owner_balans_do']=$telo['money'];
							$rec['owner_balans_posle']=$telo['money']-$zay['price'];
							$rec['target']=0; $rec['target_login']='';
							$rec['type']=6;
							$rec['sum_kr']=$zay['price'];
							$rec['sum_ekr']=0; $rec['sum_kom']=0; $rec['item_id']='';
							$rec['item_name']=''; $rec['item_count']=0; $rec['item_type']=0; $rec['item_cost']=0; $rec['item_dur']=0; $rec['item_maxdur']=0;
							$rec['item_ups']=0; $rec['item_unic']=0; $rec['item_incmagic']=''; $rec['item_incmagic_count']=''; $rec['item_arsenal']='';
							add_to_new_delo($rec); //�����
						}
					$OKADD=true;
					$user[zayavka]=$zid;
					$user[battle_t]=$team;
					return $ret;
					}
					else
					{
						return "��� ������ �� ����� ���� ������� ����!";
					}
		}

		// �������� ������ ;) - �����������
		function delteam ( $team = 2,$telo)
		{
		global $OKBB;

			mysql_query("UPDATE  `zayavka` SET team{$team} ='' ,  t{$team}hist =''   WHERE	id = {$telo[zayavka]} and team{$team}='{$telo[id]};' LIMIT 1;");
			if(mysql_affected_rows()>0)
				{
				mysql_query("UPDATE `users` SET zayavka = '0' , battle_t=0  WHERE  id = {$telo[id]} and  `zayavka` = {$telo[zayavka]} and battle_t={$team} ;");
				if(mysql_affected_rows()>0)
					{
					$OKBB=true;

					return "�� �������� ������";
					}
					else
					{
					return "������ 18!";
					}
				}
				else
				{
				return "������ 19!";
				}

		}

		// ������ ������ - ������������
		function addzayavka ( $start = 10, $timeout = 3, $t1c, $t2c, $type, $t1min, $t2min, $t1max, $t2max, $coment, $telo, $telo_eff , $level = 1, $stavka, $blood=0, $price=0, $nomagic=0 ,$autob=0, $am1=0, $am2=0, $ae1=0, $ae2=0,$in_att=0,$hrandom=0,$klan1=0,$reklan1=0,$klan2=0,$reklan2=0,$alig1=0,$alig2=0)
		{
		global $user;
		$timeout = 3; //������ � �����
		 $subtype=0;


			if ( $level ==10)
				{
				//��� �� �����
				 $level=5; // ����������  �������� �����;
				 $subtype=1; //  ��� �� �����
				 $type=3;// �� �����
				}
			elseif ( $level ==11)
				{
				//��� �� �����
				 $level=5; // ����������  �������� �����;
				 $subtype=2; //  ��� �� �������
				 $type=3;// �� �����
				}
			elseif ( $level ==12)
				{
				//���  �������
				 $level=5; // ����������  �������� �����;
				 $subtype=3; //  ���  �������
				 $type=3;// �� �����
				}


			if ( ($level==7)  ) //and (($user['klan']=='radminion') OR ($user['klan']=='testTest') )
			 {
			 //��������� ���� ������ ������
			 }
			elseif ((int)$level<1 || (int)$level>5) return "������...";

			if ($level==7)
			{
			//��� ����� ��� ���� �������

			}
			elseif (($type == 3 || $type == 5) and ($telo[prem]!=3))
			{
			// Captcha
			$load_captime=mysql_fetch_array(mysql_query("select UNIX_TIMESTAMP(captime) as captime from users_capcha_time where owner='{$telo['id']}' "));
			if (time()-$load_captime['captime'] < 3600) //6 �.
			{
				unset($_SESSION['securityCode']);
			}
			else
				{
				if (!isset($_POST['securityCode']) || !isset($_SESSION['securityCode']) || !strlen($_POST['securityCode'])) return "�� �� ����� �������� ���!";
				if ($_POST['securityCode'] != $_SESSION['securityCode']) {
					unset($_SESSION['securityCode']);
					return "�������� �������� ���!";
				}
				unset($_SESSION['securityCode']);
				//����� ����� ����� ��������� ����� �����
				mysql_query("INSERT INTO `oldbk`.`users_capcha_time` SET `owner`='{$telo['id']}', captime=NOW() ON DUPLICATE KEY UPDATE captime=NOW();");
				}
			}

		if ($subtype==1)
		{
			if ($telo['weap']>0)
			{
			$chek_elka=mysql_fetch_array(mysql_query("select id,name from oldbk.inventory where  id='{$telo['weap']}'   ; "));

				if (strpos($chek_elka['name'], '��������� ����') === false)
				{
					return "� ��� �� ����� ����....3";
				}
			}
			else
			{
			return "� ��� �� ����� ����....4";
			}
		}
		elseif ($subtype==2)
		{
			if ($telo['weap']>0)
			{
			$chek_elka=mysql_fetch_array(mysql_query("select id,name,prototype from oldbk.inventory where  id='{$telo['weap']}'   ; "));

				if (!( (($chek_elka['prototype'] >=410130 ) and ($chek_elka['prototype'] <= 410136 )) || (($chek_elka['prototype'] >=410001 ) and ($chek_elka['prototype'] <= 410008 )) || (($chek_elka['prototype'] >=410021 ) and ($chek_elka['prototype'] <= 410028 )) ))
				{
					return "� ��� �� ���� �����...";
				}
			}
			else
			{
					return "� ��� �� ���� �����...";
			}
		}
		elseif( $subtype==3)
		{

				if ($telo['uclass']==0)
				{
					return "��� �������� ��� ���������� ������������ ����� ���������, ������� � �������...";
				}
				elseif (!(	($telo['sergi'] >0) AND
						    ($telo['kulon'] >0) AND
						    ($telo['weap'] >0) AND
						    ($telo['bron']  >0) AND
						    ($telo['r1'] >0) AND
						    ($telo['r2'] >0) AND
						    ($telo['r3']>0) AND
						    ($telo['helm']>0) AND
						    ($telo['perchi']>0)  AND
						    ($telo['shit'] > 0) AND
						    ($telo['boots']>0) AND
						    ($telo['nakidka']>0) AND
						    ($telo['rubashka']>0) ) )
				{
					return "��� �������� � ������ ��������� �����...";
				}
		}
		elseif ($type!=20)
		{
			if ($level==1 && ($type!=1 && $type!=4)) $type=1;
			if ($level==2 && ($type!=1 && $type!=4 && $type!=6)) $type=1;
			if ($level==4 && ($type!=2 && $type!=4)) $type=2;
			if ($level==5 && ($type!=3 && $type!=5)) $type=3;
			if ($level==3 && ($type==2)) $type=2; //��� ���!!
		}
		else
		{
		//check dressed items
		$check1=mysql_fetch_array(mysql_query("select count(*) from oldbk.inventory where owner='{$telo[id]}' and `dressed`='1' and `magic`!='51'; "));
		$check2=mysql_fetch_array(mysql_query("select count(*) from oldbk.inventory where owner='{$telo[id]}' and `dressed`='1' and `prototype`>1000 and `prototype`<1045 and `includemagic`='0';"));
		if (($check1[0]!= $check2[0]) or ($check2[0]!=4))
				{
				return "�� ����� �� �� �����....";
				}
		}

		if ( $start == 5 OR $start == 10 OR $start == 15 ) //OR $start == 30 OR $start == 45 OR $start == 60
		{
		} else { $start = 10; }

		if( $timeout == 3 OR  $timeout == 4 OR $timeout == 5 OR  $timeout == 7 OR  $timeout == 10)
		{
		} else { $timeout = 3; }


			if (($telo_eff['owntravma'])>=1) //������ ������ ������
			{
					if (($telo_eff[12]>0) && ($type!=4 AND $type!=5))
						{
						return "� ��� ������� ������, �������� � ������� ������� ������ ��� ���...";
						}
					else if ($telo_eff[13]>0 )
						{
						return "� ��� ������� ������, �� �� ������� �������...";
						}
					else if ($telo_eff[14]>0 )
						{
						return "� ��� ������� ������, �� �� ������� �������...";
						}
					else if ( ($telo_eff['owntravma'])>1)
						{
						return "� ��� ������� ������, �� �� ������� �������...";
						}
			}

			if  ($nomagic>0)
				{
				//�������� ������
				$booksa=mysql_fetch_assoc(mysql_query("select * from effects where owner='{$telo[id]}' AND type IN (791,792,793,794,795) LIMIT 1;"));
					 if ($booksa[id]>0)
					 {
					 return "��� ��� ����� - ������ ����� � ��������������� �������.";
					 }

				if (($telo['hidden']>0)AND($telo['hiddenlog']==''))
					 {
					 return "�� �� ������ ������� ��� ������ ��� ��������� �����������. ��� ��� �����!";
					 }
				elseif (($telo['hidden']>0)AND($telo['hiddenlog']!=''))
					 {
					 return "�� �� ������ ������� ��� ������ ��� ��������� ��������������. ��� ��� �����!";
					 }

				}



			if ($level!=3)
			{
				if (!$telo['klan'] && $t1min == 99)
				{
				return "�� �� �������� � �����.";
				}
			}
			// ��
			if ($telo['hp'] < $telo['maxhp']*0.33)
			{
				return "�� ������� ��������� ��� ���, ��������������.";
			}


			$price = round($price,0);
			if ($price>0)
				{
				if($price>$telo[money]) {return "� ��� ��������� ����� ��� ������ ������!";}
				$fond = $price;
				$stavka = round($stavka,2);
				$price_out = ", money=money-{$price}";
				$price_text=", � ��������� {$price} ��.";
				}
				else
				{
				$fond = 0;
				$price=0;
				}

				$rsql='';
				$rsqlv='';
				//�������������
				if ($type==2)
					{
					$rsql=" , `klan1`, `klan2` , `reklan1` , `reklan2` , `alig1` , `alig2` ";
					$rsqlv=" , '{$klan1}', '{$klan2}' , '{$reklan1}' , '{$reklan2}' , '{$alig1}' ,  '{$alig2}' ";
					}


			$start = time()+$start*60;
			mysql_query("INSERT INTO `zayavka`
				(`bcl` , `nomagic`,`price`,`fond`,`start`, `timeout`, `t1c`, `t2c`, `type`, `level`, `coment`, `team1`, `stavka`, `t1min`, `t2min`, `t1max`, `t2max`,`podan`,`blood`,`autoblow`, `am1` , `am2` , `ae1` , `ae2`, `t1hist`,`subtype`, `zcount` , `hz` ".$rsql." ) values
				('{$in_att}','{$nomagic}','{$price}','{$fond}','{$start}','{$timeout}','{$t1c}','{$t2c}','{$type}','{$level}','".mysql_real_escape_string($coment)."','{$telo[id]};','{$stavka}','{$t1min}', '{$t2min}', '{$t1max}', '{$t2max}', '".date("H:i")."', '{$blood}','{$autob}', '{$am1}', '{$am2}' , '{$ae1}' , '{$ae2}' , '".BNewHist($telo)."' , '{$subtype}' , '1', '{$hrandom}' ".$rsqlv." );");

			$NEW_ID_Z=mysql_insert_id();
			if (mysql_affected_rows()>0)
				{
					mysql_query("UPDATE `users` SET  battle_t=1 , `zayavka` = ".$NEW_ID_Z." ".$price_out." WHERE `id` = {$telo[id]};");

					$user[zayavka]=$NEW_ID_Z;
					$user[battle_t]=1;

					if($price>0)
						{
							$rec['owner']=$telo[id];
							$rec['owner_login']=$telo['login'];
							$rec['owner_balans_do']=$telo['money'];
							$rec['owner_balans_posle']=$telo['money']-$price;
							$rec['target']=0; $rec['target_login']='';
							$rec['type']=6;
							$rec['sum_kr']=$price;
							$rec['sum_ekr']=0; $rec['sum_kom']=0; $rec['item_id']='';
							$rec['item_name']=''; $rec['item_count']=0; $rec['item_type']=0; $rec['item_cost']=0; $rec['item_dur']=0; $rec['item_maxdur']=0;
							$rec['item_ups']=0; $rec['item_unic']=0; $rec['item_incmagic']=''; $rec['item_incmagic_count']=''; $rec['item_arsenal']='';
							add_to_new_delo($rec); //�����

						}
				return "�� ������ ������ �� ���".$price_text;
				}
				else
				{
				return "������ �������� ������!";
				}
		}

		// ����� ������ - ������������
		function delzayavka ()
		{
		global $OKD, $user;
		//��������� ���� ������ ���������� ��� ������ ���� ��� �� ������� ����������
		 if (($user[zayavka]>0)	and ($user[battle_t]==1))
		 	{
		 	$get_test_zay=mysql_fetch_array(mysql_query("SELECT * from zayavka where id='{$user[zayavka]}' and team1='{$user[id]};' and team2='' LIMIT 1;"));
				if ($get_test_zay[id]>0)
				{
					mysql_query("DELETE FROM `zayavka` WHERE id='{$user[zayavka]}' and team1='{$user[id]};' and team2='' ");
					if (mysql_affected_rows()>0)
						{
						mysql_query("UPDATE `users` SET `zayavka` = 0, battle_t=0  WHERE `id` = {$user[id]} LIMIT 1;");
						$user[zayavka]=0;
						$user[battle_t]=0;
						$OKD=ture;
						return '�� �������� ������.';
						}
						else
						{
						return '�� �� ������ �������� ��� ������.';
						}
				}
				else
				{
				return '�� �� ������ �������� ��� ������.';
				}
			}
			else
			{
				return '�� �� ������ �������� ��� ������.';
			}
		}

		//���������� ���� ��� �� ���� �����
		function showsbots($botsids)
		{

					global $user, $time_to_bot;

		$out='';

			foreach($botsids as $k=>$v)
			{
			if (time()-$_SESSION['bottout'][$k]>$time_to_bot)
				{
				$kk+=120;
				$out.="<INPUT TYPE=radio ".($user[zayavka]>0?"disabled ":"")." NAME='gocombat' value={$k}><font class=date>".date("H:i",time()-(200+$kk))."</font> ";
				$out.= BNewRender($v);
				$out.= "&nbsp; ��� ���: ";
				$out.= "<IMG SRC=\"http://i.oldbk.com/i/fighttype1.gif\" WIDTH=20 HEIGHT=20 ALT=\"���������� ���\"> ";
				$out.= " (������� 3 ���.) <BR>";
				}
			}

		return $out;
		}

		// �������� ���������� ������ -����������
		function showfiz ( $row ) {
			global $user;
			$rr = "<INPUT TYPE=radio ".($user[zayavka]>0?"disabled ":"")." NAME='gocombat' value={$row['id']}><font class=date>{$row['podan']}</font> ";

			$rr .= BNewRender($row[t1hist]);

			if($row['team2'])
				{
				$rr .= " <i>������</i> ";
				$rr .= BNewRender($row[t2hist]);
				}

			$rr .= "&nbsp; ��� ���: ";
			if ($row['type'] == 4) {
				$rr .= "<IMG SRC=\"http://i.oldbk.com/i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"> ";
			}
			elseif ($row['type'] == 6) {
				$rr .= "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"> ";
			}
			elseif ($row['type'] == 1) {
				$rr .= "<IMG SRC=\"http://i.oldbk.com/i/fighttype1.gif\" WIDTH=20 HEIGHT=20 ALT=\"���������� ���\"> ";
			}
			$rr .= " (������� {$row['timeout']} ���.) <BR>";
			return $rr;
		}

		// �������� ��������� ������ -����������
		function showgroup ( $row )
		{
	            global $user;
			if ($row[level]==3)
				{
				$alish1="";$alish2="";
					if ($row[am1]>0) {$alish1.="<img src='http://i.oldbk.com/i/align_{$row[am1]}.gif'>";}
					if ($row[am2]>0) {$alish1.="<img src='http://i.oldbk.com/i/align_{$row[am2]}.gif'>";}
					if ($row[ae1]>0) {$alish2.="<img src='http://i.oldbk.com/i/align_{$row[ae1]}.gif'>";}
					if ($row[ae2]>0) {$alish2.="<img src='http://i.oldbk.com/i/align_{$row[ae2]}.gif'>";}
				}
				else
				{
				$alish1="";$alish2="";
				}

			if($row['t1min']==99)
			{
				$range1 = "<i>����</i>";
			}
			else
			{
				$range1 = "{$row['t1min']}-{$row['t1max']}";
			}
			if($row['t2min']==99)
			{
				$range2 = "<i>����</i>";
			}
			else
			{
				$range2 = "{$row['t2min']}-{$row['t2max']}";
			}
			$rr = "<INPUT TYPE=radio ".(($user[zayavka]>0)?"disabled ":"")." NAME=gocombat value={$row['id']}><font class=date>{$row['podan']}</font> <b>{$row['t1c']}</b>({$range1} {$alish1} ) (";

			if (count($row['team1']) ==0) { $rr.= "<i>������ �� �������</i>"; }
								else
								{
								$rr .= BNewRender($row[t1hist]);
								}
			$rr .= ") <i>������</i> <b>{$row['t2c']}</b>({$range2} {$alish2} )(";
			if (count($row['team2']) ==0) { $rr.= "<i>������ �� �������</i>"; }
									else
									{
									$rr .= BNewRender($row[t2hist],1);
									}

			if ($row['blood'] && $row['type'] == 5)
			{
				$rr .= "<IMG SRC=\"i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"\">";
			}

			$rr .= ")&nbsp; ��� ���: ";
			if ($row['blood'] && $row['type'] == 4)
			{
				$rr .= "<IMG SRC=\"i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"><IMG SRC=\"i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
			}
			elseif ($row['blood'] && $row['type'] == 2) {
				$rr .= "<IMG SRC=\"i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
			}
			elseif ($row['type'] == 2 ) {
				$rr .= "<IMG SRC=\"i/fighttype2.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ���\">";
			}
			elseif ($row['type'] == 20 ) {
				$rr .= "<IMG SRC=\"i/fighttype20.gif\" WIDTH=20 HEIGHT=20 ALT=\"���������� ��������\" title=\"���������� ��������\">";
			}
			elseif ($row['type'] == 4) {
				$rr .= "<IMG SRC=\"i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������� ���\">";
			}
			$rr .= "(������� {$row['timeout']} ���.) <span style='color:gray;'><i >��� �������� ����� ".round((($row['start'])-time())/60,1)." ���. ".(($row['coment'])?"(".$row['coment'].")":"")."</i></span>";

			if ($row['price'] >0 ) { $rr .= " (��� �� ������:".$row['price']."��.<u>������� ����:".$row['fond']."��. </u>)"; }

		if ($user['klan']=='radminion')
			{
			$rr .= "<a href='?zid={$row['id']}&do=del'><img src='i/clear.gif' title='�������� ������'></a>";
			}

			if (($user['align']>1.4 && $user['align']<2) || ($user['align']>2 && $user['align']<3))
			{
				$rr .= "<a href='?zid={$row['id']}&do=clear'><img src='i/clear.gif' title='������� �����������'></a><BR>";
			}
			else {
				$rr .= "<BR>";
			}

			return $rr;
		}

		// �������� ����������� ������ - ����������
	function showhaos ( $row ) {
            global $user;

          /*  if (($user['klan']!='radminion') and ($row['team1']=='') )
            	{
            	return ;
            	}
          */



			$rr = "<input type=hidden name='price{$row['id']}' id='price{$row['id']}' value='{$row['price']}'>
			<INPUT TYPE=radio ".(($user[zayavka]>0)?"disabled ":"")." NAME=gocombat id=gocombat value={$row['id']}><font class=date>{$row['podan']}</font> (";
			$all_in=0;
			$T1_array=fteam($row['team1']);
//			$all_in=count($T1_array);
			$all_in=$row['zcount'];

			if ($row['hide']==1)
				{
				$rr.='<i>��������� ������</i>';
				$zp=', ';
				}
				else
					if ($row['t1hist']!='')
							{
							$rr.=BNewRender($row['t1hist']);
							$zp='';
							}

			$rr .= "";
			if ($all_in ==0) { $rr.= $zp."<i>������ �� �������</i>"; }


			$rr .= ") ({$row['t1min']}-{$row['t1max']}) &nbsp; ��� ���: ";
			if ($row['autoblow']==1)
					{
					$rr .= "<IMG SRC=\"i/achaos.gif\" WIDTH=20 HEIGHT=20 ALT=\"��� � ����������\">";
					}

			if ($row['subtype']==1)
					{
					$rr .= "<IMG SRC=\"http://i.oldbk.com/i/fighttype7.gif\" WIDTH=20 HEIGHT=20 ALT=\"��� �� �����\" TITLE=\"��� �� �����\">";
					}
			elseif ($row['subtype']==2)
					{
					$rr .= "<IMG SRC=\"http://i.oldbk.com/i/fight_flowers.png\" WIDTH=20 HEIGHT=20 ALT=\"��� �� �����\" TITLE=\"��� �� �������\">";
					}

			if ($row['blood'] && $row['type'] == 5) {
				$rr .= "<IMG SRC=\"i/fighttype5.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"><IMG SRC=\"i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
			}
			elseif ($row['blood'] && $row['type'] == 3) {
				$rr .= "<IMG SRC=\"i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\">";
			}
			elseif ($row['type'] == 3) {
				$rr .= "<IMG SRC=\"i/fighttype3.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ���\">";
			}
			elseif ($row['type'] == 5) {
				$rr .= "<IMG SRC=\"i/fighttype5.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������� ���\">";
			}


			if( ($all_in==1) && ($T1_array[0]==$user['id']) && ($row['coment'] !='<b>������� ����������� ���!</b>') && ($row['coment'] !='<b>#zlevels</b>' ) && ($row['coment'] !='<b>#zbuket</b>' ) && ($row['coment'] !='<b>#zelka</b>' ) )
			{
				$rr .=' <a href="?haos_del='.$row['id'].'&level=haos">�������� ������</a> ';
			}

			if ($row['coment'] =='<b>#zlevels</b>' ) { $row['coment'] ='<b>����������</b>'; $dd=true; }
			if ($row['coment'] =='<b>#zbuket</b>' ) { $row['coment'] ='<b>����������</b>'; $dd=true; }
			if ($row['coment'] =='<b>#zelka</b>' ) { $row['coment'] ='<b>����������</b>'; $dd=true; }
			if ($row['coment'] =='#zlevels' ) { $row['coment'] ='<b>����������</b>'; $dd=true; }
			if ($row['coment'] =='<b>������� ����������� ���!</b>') {  $dd=true; }

			if ($row['subtype'] == 3) { $rr.=' <b>��� �������</b> '; }

			$rr .= "(������� {$row['timeout']} ���.) <span style='color:gray;'><i>��� �������� ����� ".round((($row['start']+10)-time())/60,1)." ���. ".(($row['coment'])?"(".$row['coment'].")":"")."</i></span>";
			if (($user['align']>1.4 && $user['align']<2) || ($user['align']>2 && $user['align']<3))
			{
				if ($dd!=true)
				{
				$rr .= "<a href='?zid={$row['id']}&do=clear'><img src='i/clear.gif'></a>";
				}
			}
			if($row['price']>0) {
				if($row['nomagic'] == 1) {$nomagic = ", <u>��� �����</u>";}
				$row['fond'] = round($row['fond']*0.9,2);
				$rr .= "<BR>��� �� ������{$nomagic}: <b>{$row['price']}��.</b> (������� ����: {$row['fond']}��.)";
			}

			if($row['hz']>0)
			{
			$rr .=" <u>��������</u> ";
			}




			$rr.=' (� ������ '.$row['zcount'].'/'.$row['t1c'].' ���.)';
			$rr .= "<BR><BR>";


			return $rr;
		}

		// user status - ������������
		function ustatus ($telo)
		{
		if(($telo[zayavka]>0) and ($telo[battle_t]==1))	{ return 1; }
		elseif(($telo[zayavka]>0) and ($telo[battle_t]==2))	{ return 2; }
		elseif($telo[zayavka]==0) { return 0; }
		else { return -1; }
		}

		// ���������� ���!
		function battlestart ( $telo, $zay, $r)
		{
		$lvl_info='';


		if ($zay[id]>0)
		{
		//$telo - ����� -������������ ��� - ���� ��� ����(��������� ���)- ���� � ���� ���������� �� ����� � CHAOS - ������� ���� �� ����� ��� ������ ��������� ������ �� �������
		//$zay - ����� ������ ����� ������� ���� ���������
		//$r - ��������� ������� ������
              	//if ($zay['coment'] =='#zlevels' ) { $row['coment'] ==''; }

		$T1_array=fteam($zay[team1]);
		$T2_array=fteam($zay[team2]);
		$time = time();

		$mk_satus=0;//�����������

		if ($r==5) {$chaos_flag=1;} else {$chaos_flag=0;} //chos_flag

		if ($r==3)
				{
				// ������ �� ���� ������� - ���������� ���� ����� �� ��������� 1;2;3;4
				  $aligns_battle=$z['am1'].";".$z['am2'].";".$z['ae1'].";".$z['ae2'] ;
				} else { $aligns_battle=''; }

		if (($chaos_flag==1) and ($zay['autoblow']==1))
				{
				$chaos_flag=2;//CHAOS =2-���� � ���� �������
				}

			// ������� ����, ���� �������
		if ($zay['type'] == 4 OR $zay['type'] == 5)
			{
				foreach($T1_array as $k=>$v)
				{
					undressall($v);
				}
				foreach($T2_array as $k=>$v)
				{
					undressall($v);
				}
			}

		if ($zay['subtype']==1)
			{
			$zay['type']=7; // ������ ��� ��� �� ����� 7
			//��� �� �����
			//���� ����� ��� ���� � ���� ������
			$get_noelk=mysql_query("select id , login from users u where zayavka='{$zay['id']}'  and weap not in (select id from inventory where id=u.weap and name like '%��������� ����%'  ) ");
			if (mysql_num_rows($get_noelk))
				  {
					while ( $row = mysql_fetch_array($get_noelk) )
					{
					//���������� � ���� ��� ����
					undressall($row['id']);
					}
				  }

			}
		elseif ($zay['subtype']==2)
			{
			$zay['type']=8; // ������ ��� ��� �� ������� 8
			//���� ����� ��� ������ � ���� ������
			$get_noelk=mysql_query("select id , login from users u where zayavka='{$zay['id']}'  and weap not in (select id from inventory where id=u.weap and prototype in (410130,410131,410132,410133,410134,410135,410136,410001,410002,410003,410004,410005,410006,410007,410008,410021,410022,410023,410024,410025,410026,410027,410028)) ");
			if (mysql_num_rows($get_noelk))
				  {
					while ( $row = mysql_fetch_array($get_noelk) )
					{
					//���������� � ���� ��� ����
					undressall($row['id']);
					}
				  }

			}
			elseif ($zay['subtype']==3)
			{
				$lvl_info=$zay['t1min'].'|'.$zay['t1max'];//������ ��� ������ � ���


					$get_noelk=mysql_query("select u.id, u.login, u.level, u.align,u.klan,u.room,u.id_city from users u where u.zayavka='{$zay['id']}' and  (`sergi`=0 OR `kulon`=0 OR `weap`=0 OR `bron`=0 OR `r1`= 0  OR `r2`=0 OR `r3`=0 OR `helm`=0 OR `perchi`=0 OR `shit` = 0 OR `boots`=0 OR `nakidka`=0 OR `rubashka`=0 ) ");

				if (mysql_num_rows($get_noelk))
					  {

						while ( $row = mysql_fetch_array($get_noelk) )
						{


							//��������� ���������
							undressall($row['id']);
						         //���������� ��������
						         addchp ('<font color=red>��������!</font> � ��� ���� ����� ��� �������������� ����� ����, ������ ��� � ��� ��� �� ������ ������� �����!','{[]}'.$row['login'].'{[]}',$row['room'],$row['id_city']);

						}
					  }
			}
			elseif ($zay['coment'] =='<b>#zlevels</b>' )
			{
			$lvl_info=$zay['t1min'].'|'.$zay['t1max'];//������ ��� ������ � ���
			//����  ���� �������
		 	//addchp ('<font color=red>Z1</font> , id: '.$zay['id'].'  ','{[]}Bred{[]}');
				$get_noelk=mysql_query("select u.id, u.login, u.level, u.align,u.klan,u.room,u.id_city, i.prototype from users u LEFT JOIN oldbk.inventory i ON  i.id=u.weap where u.zayavka='{$zay['id']}' and u.level>7 and (u.weap=0 or (((i.nlevel<u.level and u.level<14) or (i.nlevel<u.level-1 and u.level>13)) and (i.prototype not in (1006233,1006232,1006234,410130,410131,410132,410133,410134,410135,410136,410001,410002,410003,410004,410005,410006,410007,410008,410021,410022,410023,410024,410025,410026,410027,410028) and (i.prototype<55510301 or i.prototype>55510352)) ) )");

				if (mysql_num_rows($get_noelk))
					  {

						while ( $row = mysql_fetch_array($get_noelk) )
						{


							//��������� ���������
							undressall($row['id']);
						         //���������� ��������
						         addchp ('<font color=red>��������!</font> � ��� ���� ����� ��� �������������� ����� ��������� ����, ������ ��� ���� ������ �� ������������� ������ ������!','{[]}'.$row['login'].'{[]}',$row['room'],$row['id_city']);
				  		 	//addchp ('<font color=red>undress in </font> zid: '.$zay['id'].' telo id '.$row['id'].'  ','{[]}Bred{[]}');

						}
					  }
					  else
					  {
		  		 	//addchp ('<font color=red>Z3 none</font> , id: '.$zay['id'].'  ','{[]}Bred{[]}');
					  }
			}
			elseif ($r==7) //��� �������
			{
			$lvl_info=$zay['t1min'].'|'.$zay['t1max'];//������ ��� ������ � ���
			$zay['type']=22; //  ���������  23 - � ������ � ����� ������ ��� ���  ��� �������
				//���� �������  ������� ����� ����������� ������
				/*
				$get_no_class_items=mysql_query("select * from inventory where owner in (select id from users where zayavka='{$zay['id']}') and dressed=1 and type not in (30,28,27,12) and nclass=0  group by owner");

				if (mysql_num_rows($get_no_class_items))
					  {
					  $unr_array=array(); // ����� ������ �� ����������

						while ( $its = mysql_fetch_array($get_no_class_items) )
						{
						//���������� �������� ��� ������
						$unr_array[]=$its['owner'];
						}

						foreach($unr_array as $k=>$ownerid)
							{
								$ttelo=check_users_city_data($ownerid);
								if ($ttelo['id']>0)
									{
									undressall($ttelo['id']);
									 //���������� ��������
									addchp ('<font color=red>��������!</font> � ��� ���� ����� ��� ��������������, ������ ��� �� ��� ���� ������ �������� ������� �� ������ ������!','{[]}'.$ttelo['login'].'{[]}',$ttelo['room'],$ttelo['id_city']);
								        }


							}


					  }
				*/

			}



		if($zay['timeout'] != 3 AND $zay['timeout'] != 4 AND $zay['timeout'] != 5 AND $zay['timeout'] != 7 AND $zay['timeout'] != 10)  {  $zay['timeout'] = 3;	}



				if ($zay['subtype']==3)
				{
				$battle_in_deny='<b>��� �������</b>';
				}
				else
				if ($zay['coment']=='<b>������� ����������� ���!</b>')
				{
				$battle_in_deny='��������� ���';
				}
				elseif (($zay['t1max']==$zay['t2max']) AND ($zay['t1max']<=4))
				{
				$battle_in_deny='��� ��������';
				}
				elseif ($zay['bcl']>0)
				{
				$battle_in_deny='��������� ���';
				}
				elseif ($zay['level']==6) //����� ��� �����������
				{
				$battle_in_deny=$zay['coment']; //��������� ����������
				$chaos_flag = -1;
				}
				elseif (($zay['type'] == 2 ) and ($zay['level'] == 4 ))
				{
				$battle_in_deny='������������� ���'; //��������� ����������
				$chaos_flag = -1; // ���� ��������
				$zay['type']=22; // ������ ��� ��� �������������
				}
				else
				{
				$battle_in_deny='';
				}

			include "config_ko.php";
			if (((time()>$KO_start_time46) and (time()<$KO_fin_time46)) )  // '������ ����������';
				{
				if ($battle_in_deny=='��������� ���')
					{
					$battle_in_deny='';
					}
				}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if ($r== 3 OR $r == 4 OR $r==5 OR $r==7 )
			{
				$haot_start_count=4;

					/*if  ( ( $zay['coment']='<b>#zbuket</b>') and ($zay['t1min']==14) and ($zay['t1max']==14) )
						{
						//http://tickets.oldbk.com/issue/oldbk-2586
						$haot_start_count=8;
						}
					*/


					 //������ ������ ������� �� ���������
					if  (
					 (((count($T2_array) !=$zay['t1c'] )or(count($T1_array) !=$zay['t1c'])) AND ($zay['type']==20)) //���������� - ������
					 OR ( (count($T1_array) < $haot_start_count) and ($r==5)  )    //������ �� ��������� 4� ��� � ����
					 OR ( (count($T2_array) ==0 ) and  $r!=5   ) ) // ������ � ������� ����� ����� �� ��� ������� ������� � ������ �� (5) ����

					{
					 mysql_query("DELETE FROM `zayavka` WHERE `id`= '".$zay[id]."';"); // ������� ������

					 if ((count($T1_array)>0) or (count($T2_array)>0 ))
					    {
						$price = $zay['price'];
						if($price>0) { $return_text = "���������� {$price} ��.";  $sql_money=" ,  money=money+{$price}  ";  } else { $sql_money=""; }


						foreach(array_merge($T1_array,$T2_array) as $v)
					   	{
						if($price > 0)
							{
						        $current_money = mysql_fetch_array(mysql_query("select * from users where id={$v} and zayavka={$zay[id]}"));
						        if ($current_money[id]>0)
							{
							$rec['owner']=$current_money[id];
							$rec['owner_login']=$current_money['login'];
							$rec['owner_balans_do']=$current_money['money'];
							$rec['owner_balans_posle']=$current_money['money']+$price;
							$rec['target']=0; $rec['target_login']='';
							$rec['type']=7;
							$rec['sum_kr']=$price;
							$rec['sum_ekr']=0; $rec['sum_kom']=0; $rec['item_id']='';
							$rec['item_name']=''; $rec['item_count']=0; $rec['item_type']=0; $rec['item_cost']=0; $rec['item_dur']=0; $rec['item_maxdur']=0;
							$rec['item_ups']=0; $rec['item_unic']=0; $rec['item_incmagic']=''; $rec['item_incmagic_count']=''; $rec['item_arsenal']='';
							add_to_new_delo($rec); //�����
							}
							}
						$mess_ids[]=$v;
					  	}

						 mysql_query("UPDATE `users` SET `zayavka`=0, battle_t=0 ".$sql_money."   WHERE `zayavka` = '".$zay[id]."';");

						 if ($zay['type']==20)
						 	{
							addch_group('<font color=red>��������!</font> ��� ��� �� ����� �������� �� ������� "������ �� ������� '.$zay['t1c'].' �������". '.$return_text.'  ',$mess_ids);
							}
							else
							{
							addch_group('<font color=red>��������!</font> ��� ��� �� ����� �������� �� ������� "������ �� �������". '.$return_text.'  ',$mess_ids);
							}
					}

	      				return;
					}
			}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//������� �� ���
			    $zay['price'] = round($zay['price'],0);
			    $zay['fond'] = round($zay['fond'],0);
				$zay['coment'] = mysql_real_escape_string($zay['coment']);
mysql_query("INSERT INTO `battle` ( `id`,`teams`,`damage`,`status_flag`,`nomagic`,`price`,`fond`,`coment`,`timeout`,`type`,`status`,`to1`,`to2`,`blood`,`CHAOS`,`exp` ) 	VALUES	( NULL,'{$battle_in_deny}','{$lvl_info}','{$mk_satus}','{$zay['nomagic']}','{$zay['price']}','{$zay['fond']}','{$zay['coment']}','{$zay['timeout']}','{$zay['type']}','1','".$time."','".$time."','".$zay['blood']."','".$chaos_flag."' , '".$aligns_battle."' )");
if (mysql_affected_rows()>0)
{
//��� �������
$battle_id = mysql_insert_id();
	 mysql_query("DELETE FROM `zayavka` WHERE `id`= '".$zay[id]."';"); // ������� ������ �� ����!
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		if (($r==5) and ( $zay['hz']==1))
		{
		//������ �������������
		//addchp ('<font color=red>��������!</font>RANDOM HAOS start Zid:'.$zay['id'],'{[]}Bred{[]}',-1,-1);

				//����� ��������
				$get_all_gamer=mysql_query("select *  FROM users  WHERE zayavka='{$zay[id]}' and battle=0 ORDER by rand() DESC");

				//make masss
				$all_gamers_data=array();
				$cc=0;
				$co=0;
				$tt=1;

				while($gamer=mysql_fetch_array($get_all_gamer))
					{
						$cc++;
						$all_gamers_data[$gamer[id]]=$gamer;
					}

				$to_battle_id['team1'] = array();
				$to_battle_id['team2'] = array();
				$to_battle_login['team1'] = array();
				$to_battle_login['team2'] = array();
				$to_battle_data['team1'] = array();
				$to_battle_data['team2'] = array();
				$to_battle_hist['team1'] = array();
				$to_battle_hist['team2'] = array();
				$to_battle_var=array();

				foreach ($all_gamers_data as $id => $gamer)
				{
				$co++;

				             if ($tt==1)
				                {
       				                $tt=2;
				                $to_battle_id['team1'][]=$id; // �� ����� �� �������
				                $to_battle_data['team1'][]=make_html_login_battle($all_gamers_data[$id]);  // html ���� ��� ����
                				$to_battle_hist['team1'][]=BNewHist($all_gamers_data[$id]); // ko� - ��� ������� � battle
						$to_battle_login['team1'][]=make_login_battle($all_gamers_data[$id]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$id}','{$time}','1','0')";	// ������ ��� ������� � battle_vars
				                }
				                else
				                {
				                $tt=1;
						//������ � ������� ���
						$to_battle_id['team2'][] =$id;
						$to_battle_data['team2'][]=make_html_login_battle($all_gamers_data[$id]);  // html ���� ��� ����
                				$to_battle_hist['team2'][]=BNewHist($all_gamers_data[$id]); // ko� - ��� ������� � battle
						$to_battle_login['team2'][]=make_login_battle($all_gamers_data[$id]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$id}','{$time}','1','0')";	// ������ ��� ������� � battle_vars
				                }
				  }

				  if ($zay['coment']=='<b>������� ����������� ���!</b>')
				  {
				  $mk_satus=10;
				  }
				  elseif ($zay['coment']=='<b>#zbuket</b>')
				  {
				  $mk_satus=10;
				  }
					elseif ($zay['coment']=='<b>#zelka</b>')
					{
					$mk_satus=10;
					}
				  else
				 if ( ($zay['type']==5) OR ($zay['type']==4))
				  {
				  //������� �� ����� ���� ���������� 12 /12 /2013
				  $mk_satus=0;
				  }
				  else  if (($co >=50) and (($zay['subtype']==1)OR($zay['subtype']==2)))
				  	{
				  	$mk_satus=10; // ������ ������� ���� ���� ��� �� �����/�������
				  	//$mk_satus=0; // �� ������
				  	}
				  	else  if ($co >=100)
				  	{
				  	$mk_satus=10; //������ ����� ���� ������ 100 ���
				  	}
		}
		else
		// ������� ����	 - ���� ���� - �������-������
		if ($r==5)
			{
				//����� ��������
				$get_all_gamer=mysql_query("select ((level*10000) + sila + lovk + inta + vinos + intel + mudra + stats + IFNULL((select (sum(mfkrit)) + sum(mfakrit) + sum(mfuvorot) + sum(mfauvorot) + (sum(bron1)*10) + (sum(bron2)*10) + (sum(bron3)*10) + (sum(bron4)*10) + (sum(cost)) + (sum(maxu)*10) + (sum(ecost)) FROM oldbk.inventory WHERE owner = users.id AND dressed=1 AND type!=12),0) ) as glsum , users.*  FROM users
				WHERE zayavka='{$zay[id]}' and battle=0 ORDER by glsum DESC;");

				//make masss
				$all_gamers=array();
				$all_gamers_data=array();
				$cc=0;
				while($gamer=mysql_fetch_array($get_all_gamer))
					{
						$cc++;
						$all_gamers[$gamer[id]]=$gamer[glsum];
						$all_gamers_data[$gamer[id]]=$gamer;
					}

				if (!(($cc/2) == round($cc/2))) { $cc--;} //���� �������� �� �� ������ ���. -1;

				// haos grup sex ))
				$co=0; $tt=1; $lr=1; $all_sum1=0;$all_sum2=0;

				$to_battle_id['team1'] = array();
				$to_battle_id['team2'] = array();
				$to_battle_login['team1'] = array();
				$to_battle_login['team2'] = array();
				$to_battle_data['team1'] = array();
				$to_battle_data['team2'] = array();
				$to_battle_hist['team1'] = array();
				$to_battle_hist['team2'] = array();
				$to_battle_var=array();

				foreach ($all_gamers as $id => $glsum)
				{
				$co++;
				      if ($co<=$cc)
				          {
				          //�� �����
				             if ($tt==1)
				                {
				                $to_battle_id['team1'][]=$id; // �� ����� �� �������
				                $to_battle_data['team1'][]=make_html_login_battle($all_gamers_data[$id]);  // html ���� ��� ����
                				$to_battle_hist['team1'][]=BNewHist($all_gamers_data[$id]); // ko� - ��� ������� � battle
						$to_battle_login['team1'][]=make_login_battle($all_gamers_data[$id]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$id}','{$time}','1','0')";	// ������ ��� ������� � battle_vars
     			                            $all_sum1+=$glsum;
			                         // ������ � ������ ����
			                          if ($lr==1)
			                            {
			                            //����������
    				                    $tt=2;$lr=2;
    				                    }
    				                    else
    				                    {
			                            //����������
    				                    $tt=1;$lr=1;
    				                    }
				                }
				                else
				                {
						//������ � ������� ���
						$to_battle_id['team2'][] =$id;
						$to_battle_data['team2'][]=make_html_login_battle($all_gamers_data[$id]);  // html ���� ��� ����
                				$to_battle_hist['team2'][]=BNewHist($all_gamers_data[$id]); // ko� - ��� ������� � battle
						$to_battle_login['team2'][]=make_login_battle($all_gamers_data[$id]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$id}','{$time}','1','0')";	// ������ ��� ������� � battle_vars

		      		                $all_sum2+=$glsum;
			                          if ($lr==1)
			                            {
			                            //����������
    				                    $tt=1;$lr=2;
    				                    }
    				                    else
    				                    {
			                            //����������
    				                    $tt=2;$lr=1;
    				                    }
				                }
				          }
				          else
				          {
				          // ������ �������� ���������� � ���������� ������ � ������ �������
				           if ($all_sum1 > $all_sum2)
				             {
						$to_battle_id['team2'][] =$id;
						$to_battle_data['team2'][]=make_html_login_battle($all_gamers_data[$id]);  // html ���� ��� ����
                				$to_battle_hist['team2'][]=BNewHist($all_gamers_data[$id]); // ko� - ��� ������� � battle
						$to_battle_login['team2'][]=make_login_battle($all_gamers_data[$id]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$id}','{$time}','1','0')";	// ������ ��� ������� � battle_vars
				             }
				             else
				             {
						$to_battle_id['team1'][]=$id; // �� ����� �� �������
				                $to_battle_data['team1'][]=make_html_login_battle($all_gamers_data[$id]);  // html ���� ��� ����
                				$to_battle_hist['team1'][]=BNewHist($all_gamers_data[$id]); // ko� - ��� ������� � battle
						$to_battle_login['team1'][]=make_login_battle($all_gamers_data[$id]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$id}','{$time}','1','0')";	// ������ ��� ������� � battle_vars
				             }
				          }
				  }
				  // ������ ������ ��� ����� ���� �� ������ 100 �����

				 if ( ($zay['type']==5) OR ($zay['type']==4))
				  {
				  //������� �� ����� ���� ���������� 12 /12 /2013
				  $mk_satus=0;
				  }
				  else  if (($co >=50) and (($zay['subtype']==1)OR($zay['subtype']==2)))
				  	{
				  	$mk_satus=10; // ������ ������� ���� ���� ��� �� �����
				  	//$mk_satus=0; // �� ������ ������� ���� ���� ��� �� �����
				  	}
				  	else  if ($co >=100)
				  	{
				  	$mk_satus=10; //������ ����� ���� ������ 100 ���
				  	}


			}
		else
				{
				///���������� ������ ��� ������ ����� ����
				// �������� ������
				$to_battle_id['team1'] = array();
				$to_battle_id['team2'] = array();
				$to_battle_login['team1'] = array();
				$to_battle_login['team2'] = array();
				$to_battle_data['team1'] = array();
				$to_battle_data['team2'] = array();
				$to_battle_hist['team1'] = array();
				$to_battle_hist['team2'] = array();
				$to_battle_var=array();
				$cc=0;

				if ($zay['level']==6)
				{
				//����� ��� ������� ��
				$get_all_can=mysql_query("select *  FROM users	WHERE zayavka in (select id from zayavka_turn where zayid={$zay[id]}) and battle=0 "); //�������� �� ������� �� �� �������� ������
				}
				else
				{
				$get_all_can=mysql_query("select *  FROM users	WHERE zayavka={$zay[id]} and battle=0 ");
				}

				while($gamer=mysql_fetch_array($get_all_can))
					{
						$cc++;
						$all_gamers_data[$gamer[id]]=$gamer;
					}

				//������� �1 - � ������� ������ ������
					foreach ($T1_array as $cid)
					{
					if (is_array($all_gamers_data[$cid]))
						{
						$to_battle_id['team1'][] = $cid;
						$to_battle_data['team1'][]=make_html_login_battle($all_gamers_data[$cid]);  // html ���� ��� ����
               					$to_battle_hist['team1'][]=BNewHist($all_gamers_data[$cid]); // ko� - ��� ������� � battle
						$to_battle_login['team1'][]=make_login_battle($all_gamers_data[$cid]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$cid}','{$time}','1','0')"; // ������ ��� ������� � battle_vars
						}
					}

				//������� �2 - � ������� ������ ������
					foreach ($T2_array as $cid)
					{
					if (is_array($all_gamers_data[$cid]))
						{
						$to_battle_id['team2'][] = $cid;
						$to_battle_data['team2'][]=make_html_login_battle($all_gamers_data[$cid]);  // html ���� ��� ����
               					$to_battle_hist['team2'][]=BNewHist($all_gamers_data[$cid]); // ko� - ��� ������� � battle
						$to_battle_login['team2'][]=make_login_battle($all_gamers_data[$cid]); // ������ ������ ������
						$to_battle_var[]="('{$battle_id}','{$cid}','{$time}','1','0')";	// ������ ��� ������� � battle_vars
						}
					}
				}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////// ������� ���� � ��� �� ��������� ��� ������
		//////////��������� ����� ������ � battle_vars
		mysql_query("INSERT INTO battle_vars (battle,owner,update_time,type,napal) VALUES  ".implode(",",$to_battle_var)."  ");

///////////mysql_query("INSERT IGNORE INTO battle_dam_exp (battle,owner) VALUES ('{$id}','{$v}')");--�������� ����� �� ������!?

		// ������� ���
		$rr = "<b>".implode(",",$to_battle_data['team1'])."</b> � <b>".implode(",",$to_battle_data['team2'])."</b>"; //��� ������ � ��� ���
		$rrc="<b>".implode(",",$to_battle_login['team1'])."</b> � <b>".implode(",",$to_battle_login['team2'])."</b>"; //��� ������ � ���
		$hist1=implode("",$to_battle_hist['team1']);//�������� ������� ��� T1 ��� battle
		$hist2=implode("",$to_battle_hist['team2']);//�������� ������� ��� T2 ��� battle



		if ($zay['level']==6)
		{
		//����� ��� ������� ��
			//��������� ����� ��� ������
			if ((is_array($to_battle_id['team1'])) and (count($to_battle_id['team1'])>0 )  )
			{
			mysql_query("UPDATE users SET `battle` ={$battle_id},`zayavka`=0, `battle_t`=1,`last_battle`=0, `battle_fin`=0  WHERE `id` in (".implode(",",$to_battle_id['team1']).")");
			}

			if ((is_array($to_battle_id['team2'])) and (count($to_battle_id['team2'])>0 )  )
			{
			mysql_query("UPDATE users SET `battle` ={$battle_id},`zayavka`=0, `battle_t`=2,`last_battle`=0, `battle_fin`=0  WHERE `id` in (".implode(",",$to_battle_id['team2']).")");
			}

			//������� �� �������
			mysql_query("DELETE FROM `zayavka_turn` WHERE zayid='{$zay[id]}' ");

		}
		else
		{
			//��������� ����� ��� ������
			if ((is_array($to_battle_id['team1'])) and (count($to_battle_id['team1'])>0 )  )
			{
			mysql_query("UPDATE users SET `battle` ={$battle_id},`zayavka`=0, `battle_t`=1,`last_battle`=0, `battle_fin`=0  WHERE zayavka={$zay[id]} and `id` in (".implode(",",$to_battle_id['team1']).")");
			}

			if ((is_array($to_battle_id['team2'])) and (count($to_battle_id['team2'])>0 )  )
			{
			mysql_query("UPDATE users SET `battle` ={$battle_id},`zayavka`=0, `battle_t`=2,`last_battle`=0, `battle_fin`=0  WHERE zayavka={$zay[id]} and `id` in (".implode(",",$to_battle_id['team2']).")");
			}
		}

		//��� ���
		addlog($battle_id,"!:S:".time().":".$hist1.":".$hist2."\n");


		//���������� ������ � ��� � ������ - ��������� �� ������ � �� �������, � ������ ��������
		mysql_query("UPDATE battle SET `status_flag`={$mk_satus} , `status`=0, `t1`='".implode(";",$to_battle_id['team1'])."' , `t2`='".implode(";",$to_battle_id['team2'])."' , `t1hist` ='{$hist1}',`t2hist`='{$hist2}' where id={$battle_id} ;");

		//���������� ��������� ��������
		addch_group('<font color=red>��������!</font> ��� ��� �������! <BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ', array_merge($to_battle_id['team1'],$to_battle_id['team2']));

		//��������
		if ($telo[room]) addch ("<a href=logs.php?log=".$battle_id." target=_blank>��������</a> ����� <B>".$rrc."</B> �������.   ",$telo['room'],CITY_ID);

	}
///=======================================================================================
 }
}

	function make_html_login_battle($telo)
	{
		if ( ($telo[hidden] > 0) and ($telo[hiddenlog] == '' ))
		{
		return  nick_hist($telo);
		}
		elseif ( ($telo[hidden] > 0) and ($telo[hiddenlog] != '' ))
		{
		$flogin=load_perevopl($telo);
		return nick_hist($flogin);
		}
		else
		{
		return  nick_hist($telo);
		}
	}

	function make_login_battle($telo)
	{
		if ( ($telo[hidden] > 0) and ($telo[hiddenlog] == '' ))
		{
		return  "<i>���������</i>";
		}
		elseif ( ($telo[hidden] > 0) and ($telo[hiddenlog] != '' ))
		{
		$flogin=load_perevopl($telo);
		return $flogin[login];
		}
		else
		{
		return  $telo[login];
		}
	}

?>
