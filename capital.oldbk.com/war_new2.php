<?php
//ini_set('display_errors','On');
//ob_start("ob_gzhandler");
//	echo 'VER 2'; //��� ��������� ��������������� ��� //--  --//
	if($user[id]==28453)
	{		$debag=0;	}

//��������� �� ������ � �������. � ����� ������� ��� ���� � �������. �� ������ ������ � ����� ������.

	if(($user['id']==$klan[glava] || $polno[$user['id']][8]==1 )&& $klan[base_klan]==0)
	{		$rulit=1;	}
	else
	{		$rulit=0;	}

	//��� ������� ������� �� ������ ID ������(�� �������)


if($klan[base_klan]>0)
{
	$kl=$klan[base_klan];
	$kl_sql=$klan[base_klan].','.$klan['id'];
}
else
{
	$kl=$klan['id'];
	$kl_sql= $klan['id'];
}
$stop_check_zayavka=1;
$can_answer_ally=1;

//������� ID �����, ���� �������, � ���������� ����� ��� ���
$sql='select * from oldbk.`clans_war_2`
where (agressor='.$kl.' OR defender='.$kl.') AND date>'.time().' ;';

if($debag==1)
{
	echo $sql.'<br>';
}
$data=mysql_query($sql);
if(mysql_num_rows($data)>0)
{
	while($row=mysql_fetch_assoc($data))
	{
		$war_id[$row[war_id]]=$row[war_id];
		if($row[def_active]==1)
		{
			$stop_check_zayavka=0;
			$can_answer_ally=0;
		}
		else
		if($row[def_active]==0 && $row[defender]==$kl)
		{
			$stop_check_zayavka=0;
			$can_answer_ally=1;
		}
	}
}


if(count($war_id)>0)
{
	if ($_POST[addnaim] && $rulit==1 && $_POST[naimid] > 0)
        {
       // echo "Start add,...";
        	$mwar_id=0;
     		$war_exist=check_wars_exist($kl); //���������, ���� �� � ���� �����
		if($war_exist)
		{
			foreach($war_exist as $wid=>$wlist)
			{
				foreach($wlist as $id => $value)
				{	
					if(($value[defender]==$kl || $value[agressor]==$kl) && $value[def_active]==1)
					{
	        				if($value[defender]==$kl)
	        				{
	        					$side='def';
	        				}
	        				else
	        				if($value[agressor]==$kl)
	        				{
	        					$side='agrr';
	        				}
	        				$mwar_id=$wid; // �� �������� ����� ������� �����
					}
				}								
			}
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
         		$get_test_message=mysql_fetch_array(mysql_query("select * from oldbk.naim_message  where owner='".$get_test_naim[id]."' AND in_klan_id='{$kl}' ;"));	
        		 if (!($get_test_message))	
        			{
        			 if ($get_test_naim[naim]==0)
        			 	{
        			 	$good_to_add=0;
        			 	 if ($get_test_naim[klan]!='')
        			 	 	{

        			 	 	//�������������� �������� ���� ���� � �����
        			 	 	 $get_naim_clan=mysql_fetch_array(mysql_query("SELECT * from oldbk.clans where short='{$get_test_naim[klan]}' ; "));
        			 	 	 if ($get_naim_clan[id]==$kl)
        			 	 	 {
	        			 	 	err('������� �� ������ �����, �� � ��� �� ��� :)<br>');
        			 	 	 }
        			 	 	 elseif ($get_naim_clan[base_klan]==$kl)
        			 	 	 {
	        			 	 	err('������� �� ������ ������ �����, �� � ��� �� ��� :)<br>'); 
        			 	 	 }
        			 	 	 else
        			 	 	 {
        			 	 	 $good_to_add=1; //  ������ �� ��������� ��� ��� ���������

        			 	 	 	if($get_naim_clan[base_klan]>0)
        			 	 	 	{
        			 	 	 		$get_naim_clan[id]=$get_naim_clan[base_klan]; //�������� �������� � ������ �����
        			 	 	 	}
        			 	 	 	
        			 	 	 	$data=mysql_query("SELECT * FROM oldbk.clans_war_2 WHERE war_id='".$mwar_id."';");
        			 	 	 	while($naim_check=mysql_fetch_assoc($data))
        			 	 	 	{
        			 	 	 		if($side=='agrr' && $naim_check[defender]==$get_naim_clan[id]) //� �������, ��������� ���� ���������� � �����.
        			 	 	 		{
									err('������� �� ����� ������� ������ �����, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;
       			 	 	 			 	break;
        			 	 	 		}
        			 	 	 		else
        			 	 	 		if($side=='def' && $naim_check[agressor]==$get_naim_clan[id]) //� ��������, ��������� ���� ���������� � �����
        			 	 	 		{
        			 	 	 			err('������� �� ����� ������� ������ �����, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;      
       			 	 	 			 	break;       			 	 	 			 	  			 	 	 			
        			 	 	 		}
        			 	 	 		else
        			 	 	 		if($side=='agrr' && $naim_check[agressor]==$get_naim_clan[id]) //� �������, ��������� ���� ���������� � �����.
        			 	 	 		{
									err('������� �� ����� ������ �������, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;
       			 	 	 			 	break;       			 	 	 			 	
        			 	 	 		}
        			 	 	 		else
        			 	 	 		if($side=='def' && $naim_check[defender]==$get_naim_clan[id]) //� �������, ��������� ���� ���������� � �����.
        			 	 	 		{
									err('������� �� ����� ������ �������, �� �������� ��� �������...<br>');
       			 	 	 			 	$good_to_add=0;
       			 	 	 			 	break;       			 	 	 			 	
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
		        			//$kl - ��� ���� �����. � ����� ������ �������������.
		        			//� ��� ��� ���� ��������... ��� ��� ���� ����� ��� �� ������ (����� ���� �� � �� � ��, ������ � ������ ���� � ���� ���������� ����� (��� ������ ���� � ������), ��� ��� � ���� ����� ���� ������� ������ ����������� ����, �� ������ ���� ��������. � ����������� ������ ������ ����. � �������� �����.
		        			$my_clan_name=$user[klan]; // �������� ����� �����
		        			$my_war_name=''; // ����� ����� ��� ������ ���� �������� �������� ����� �� $mwar_id
        					// ������� ������ �����
       						// ��������� �������� ������ - �� �����
       						if (by_from_kazna($kl,1,30,'����� ��������'))
       						   {
	        					mysql_query("INSERT INTO `oldbk`.`naim_message` SET `owner`='{$get_test_naim[id]}',`in_klan_id`='{$kl}',`stat`=0,`sender`='{$user[id]}',`war_id`=$mwar_id;");
							if (mysql_affected_rows() >0 )
							{
	        					//+���������� ���  ��������� - ��������� ����������� ���������
        						 if($get_test_naim[odate] >= (time()-60))
								                        {
							                        	addchp ('<font color=red>��������!</font> ����  '.$my_clan_name.', � ���� '.$user[login].', ������ ��� ������ � ����� '.$my_war_name.'. ������� ��� �������� �� ������ �� ������� "���������" !','{[]}'.$get_test_naim['login'].'{[]}');
								                        }
								                        else
								                        {
								                         mysql_query("INSERT INTO oldbk.`telegraph`   (`owner`,`date`,`text`) values ('".$get_test_naim['id']."','','<font color=red>��������!</font> ���� ".$my_clan_name.", � ���� ".$user[login].", ������ ��� ������ � ����� ".$my_war_name.". ������� ��� �������� �� ������ �� ������� \"���������\" !');");
								                        }
							 err("����������� �������� ������ �����������!<br>");
							}
        					   }
        					}
        				}
        				else
        				{
        				err('���� ������� ��� �����!<br>');
        				}
        			 }
        			 else
        			 {
        			 err('���� ������� ��� ������� �� ��� �����������!<br>');
        			 }
        			}
	        		else
        			{
        			err('� �������� ��� ��������!<br>');
        			}
        		}
        		else
        		{
        		err('������� �� ������<br>');
        		}
        	
        	}
        	else
        	{
        		err('� ��� ��� ���������� �����!<br>');
        	}
        	
        }


	//������ �������� �������� � �������
	$ii=0;
	foreach($war_id as $war_id_key =>$war_id_value)
	{
		$win1=0;
		$win2=0;
		$wins=array();
		
		$sql1='select * from oldbk.`clans_war_2` WHERE war_id='.$war_id_key.' order by id desc;';
		if($debag==1)
		{
			echo $sql1.'<br>';
		}
		$defs_ally=array();
		$data=mysql_query($sql1);
		while($row=(mysql_fetch_array($data)))
		{
			
			if ($row[agressor]==$kl)
			{
				$my_side_is='agrr';
			}
			else
			if ($row[defender]==$kl)
			{
				$my_side_is='def';
			}

			$wins[a][$row[agressor]]=$row[win1];
			$wins[d][$row[defender]]=$row[win2];
			$defs_ally[$row[defender]]=$row[defender];
			if ($row[def_active]==1)
			{
				$answer[$row[war_id]]=1;
			}
			
		}
		if($debag==1)
		{
			/*
			echo '<br>';
			print_r($wins);
			echo '<br>';
			print_r($dfs_ally);
			echo '<br>';
			*/
		}
        	$kl_sql=implode(',',$defs_ally);

		foreach($wins as $k1=>$v1)
		{
		
			if($debag==1)
			{
			// echo $k1.' ';  print_r($v1); echo '<br>';
			}
			if($k1=='a')
			{
				foreach($v1 as $kk1 => $vv1)
				{
					$win1+=$vv1;
				}
			}
			else
			if($k1=='d')
			{
				foreach($v1 as $kk1 => $vv1)
				{
					$win2+=$vv1;
				}
			}
		}

                if($debag==1)
                {                    echo $win1 .' '.$win2.'<br>';                }

//		if($ii==0)
		{
		
        		echo '<a href="#" onclick="javascript:runmagic1(\'���������\',\'post_attack\',\'target\',\'target1\') "><img title="�������� ���������" src="http://i.oldbk.com/i/klan_attak_p.gif"></a>';
 
	 		$get_count_arkan=mysql_fetch_array(mysql_query("select * from oldbk.clans_war_log where war_id='{$war_id_key}' and winner=0 and type=2;"));
	 		if ($get_count_arkan[id]>0)
 			{
	 			$ccamax=$my_side_is."_arkan_maxcount";
	 			$ccacount=$my_side_is."_arkan_count";
 			
 			//��������� ������� ������ ���� � ���� �������
 			 	if ($my_side_is=='agrr')
 			 	{
 			 		$my_need_ark =(int)($win1/500)+3; // 3 ����������� ������ 
 			 	}
 				 elseif ($my_side_is=='def')
 			 	{
 			 		$my_need_ark =(int)($win2/500)+3; // 3 ����������� ������ 
 			 	}
 			///////////////////////////////
 				if ($my_need_ark>$get_count_arkan[$ccamax])
 				{
 					//���� ���������� ������ ��� ������ ���� �� �������� ������ ����� �������
					mysql_query("UPDATE oldbk.clans_war_log SET {$ccamax}={$my_need_ark} where war_id='{$war_id_key}'  ; ");					
	 				$get_count_arkan[$ccamax]=$my_need_ark;
 				}
 				if ($get_count_arkan[$ccacount]<$get_count_arkan[$ccamax])
 				{
	        			echo '<a href="#" onclick="javascript:runmagic1(\'�����\',\'post_attack2\',\'target\',\'target1\') "><img title="����� '.$get_count_arkan[$ccacount].'/'.$get_count_arkan[$ccamax].'"  src="http://i.oldbk.com/i/klan_arkan_p.gif"></a>';        		
	        		}
	        		else
	        		{
	        			echo '<img title="����� '.$get_count_arkan[$ccacount].'/'.$get_count_arkan[$ccamax].'" src="http://i.oldbk.com/i/klan_arkan_p.gif">';
	        		}
        		}
		}
		
		
		$ii++;
		if ($answer[$war_id_key]==1)
		 	{
		 	
			echo '<form method=post>';
  			echo "������� �������� (30 ��):	<select size=\"1\" name=\"naimid\">";
  			echo '<option value="">������ ��������� � �����</option>';
  			$snaim=mysql_query("select e.*, u.login, u.level , u.id as uid from oldbk.effects e LEFT JOIN oldbk.users u ON e.owner=u.id where e.type=2000 and u.id_city=0 and naim=0 and u.klan!='{$klan[short]}' and u.klan!='radminion'
  							UNION select e.*, u.login, u.level , u.id as uid from avalon.effects e LEFT JOIN avalon.users u ON e.owner=u.id where e.type=2000 and u.id_city=1 and naim=0 and u.klan!='{$klan[short]}' and u.klan!='radminion' ");
  			while($ndata=mysql_fetch_array($snaim))
			{
			echo '<option   value="'.$ndata[uid].'">'.$ndata[login].'['.$ndata[level].'] - ��������� ���. '.date("d-m-Y H:i",$ndata[time]).' </option>';
			}
  			echo '</select><br>';
			echo '<input type="submit" name="addnaim" value="��������"> <br> ';  			
			echo '</form>';
			}
		
		$war_ally=array();
		echo '<table border=1 cellpadding=2 cellspacing=2>
            		<tr>
            			<td align=center>&nbsp;&nbsp;���������&nbsp;&nbsp;</td>
            			<td align=center>&nbsp;&nbsp;���������&nbsp;&nbsp;</td>
            			<td align=center>���������</td>
            			<td align=center>��������������</td>
            		</tr>';


			$sql1='select cw2.*,c1.align as agrr_align,c1.short as agrr_short,c2.align as
			def_align,c2.short as def_short
         	from oldbk.`clans_war_2` cw2

         	left join oldbk.`clans` c1
         	on c1.id = cw2.agressor
         	left join oldbk.`clans` c2
         	on c2.id = cw2.defender

        	where cw2.war_id='.$war_id_key.' AND date >'.time().'
        	order by cw2.osnova desc;';
	 	if($debag==1)
		{
			echo $sql1.'<br>';
		}
 		$data=mysql_query($sql1);


        	echo '<tr><td colspan=2 align=center>����� ����� �������:</td><td>&nbsp;</td><td></td></tr>';
            	while($row=mysql_fetch_assoc($data))
    		{
			if($row[osnova]==1)
	                {				echo '<tr>
				<td align=center>'.(show_klan_name($row['agrr_short'],$row['agrr_align'])).'</td>
				<td align=center>'.(show_klan_name($row['def_short'],$row['def_align'])).'</b></td>
				<td align=center>'.(date('d-m-Y H:i',$row['date'])).'</td>
				<td align=center><b>'.$win1.'/'.$win2.'</b></td>
				</tr>';
				$agrr_ex=$row[agressor];
				$deff_ex=$row[defender];	                }
			else
			{				if($agrr_ex!=$row[agressor])
				{
					$war_ally[agressor][$row[agressor]]=$row;
				}
				else
				{					$war_ally[agressor][0]='';				}
				
				if($deff_ex!=$row[defender])
				{
					$war_ally[defender][$row[defender]]=$row;				}
				else
				{
					$war_ally[defender][0]='';
				}
			}
      		}



      		echo '<tr><td colspan=2 align=center><b>������:</b></td><td>&nbsp;</td><td>&nbsp;</td></tr><tr>';

      		foreach($war_ally as $k=>$v)
      		{
                	echo '<td align=center valign=top>';			foreach($v as $kk=>$vv)
			{
				if($k=='agressor')
				{		                        if($vv!=0)
		                        {
		                       		echo show_klan_name($vv['agrr_short'],$vv['agrr_align']).'<br>';					}
				}

				if($k=='defender')
				{
					if($vv!=0)
					{               					echo (show_klan_name($vv['def_short'],$vv['def_align'])).'<br>';
               				}				}			}
                	echo '</td>';      		}
            	echo '<td>&nbsp;</td><td>&nbsp;</td></tr></table><br><br>';


    	}}



if($stop_check_zayavka==1)
{
        $_POST[tr_klan]=(int)$_POST[tr_klan];
        $_POST[al_klan]=(int)$_POST[al_klan];
        $_GET['ally']=(int)$_GET['ally'];

        if($_POST[addwar] && $rulit==1)
        {
			if(!$klan_kazna)
			{
				$stop='��� ���������� � ������������� ���� ��� ����� �������� �����.';
			}
	            
	            if($_POST[tr_klan]>0)
	            {
	             	$stop='���������� ���� �������� �������..';
/*	            
	                if($_POST[tr_klan]==$kl || $_POST[tr_klan]==$klan[rekrut_klan])
	                {	                	$stop='�������� �� ������ ����?..';	                }
         		elseif($klan_kazna[kr]>=$war_price)
         		{
	         		$rekrut=mysql_fetch_array(mysql_query('select * from oldbk.`clans` where id="'.$_POST[tr_klan].'" LIMIT 1;'));

                    		//�������� �� ����������.
        			//���� ������, �� ������ ID ����������� �� ID ������
		        	if($rekrut[base_klan]>0)
		        	{		        		$_POST[tr_klan]=$rekrut[base_klan];		        	}
		        	$can_add=0;
		                $my_ally_exist=check_ally($kl,1);  		//��������� � �� �������� �� �� ��� ���� �� ���������
		                $ag_ally_exist=check_ally($_POST[tr_klan],1);   //��������� � �� �������� �� ���������� ��� ���� �� ���������
	                        $had_war_7_days=check_7_days($_POST[tr_klan],$kl);

	                        if($had_war_7_days)
	                        {	                        	$stop=$had_war_7_days;
	                        }
	                        else
		                if($my_ally_exist)
		                {
		            		$stop='�� ��� ��������� ������ �������, � �� ������ ������� �����.';
			        }
			        else
			        if($ag_ally_exist)
			        {			        	$stop='���� ���� ��� �������� ������ �������, � �� ����� ������� �����.';			        }
			        else
			        if(($rekrut[short]=='Adminion' || $rekrut[short]=='radminion') && $debag!=1)
	         		{
	         			$stop='�� ����� ������ �����...';
	         		}

				//echo $kl;
				$war_exist=check_wars_exist($kl); //���������, ���� �� � ���� �����
				//print_r($war_exist);
				if($war_exist)
				{
					foreach($war_exist as $wid=>$wlist)
					{
						foreach($wlist as $id => $value)
						{	
							if(($value[defender]==$kl || $value[agressor]==$kl) && $value[def_active]==1)
							{
								$stop='�� ��� ������';	
							}
						}								
					}
				}
			
			
				$war_exist=check_wars_exist($_POST[tr_klan]); //���������, ���� �� ����������� �����
				if($war_exist)
				{
					foreach($war_exist as $wid=>$wlist)
					{
						foreach($wlist as $id => $value)
						{
//							if(($value[defender]==$_POST[tr_klan] || $value[agressor]==$_POST[tr_klan]) && $value[def_active]==1)
							if(($value[defender]==$_POST[tr_klan] || $value[agressor]==$_POST[tr_klan]) )
							{
								$stop='���� ���� ��� �����';	
							}
						}
					}
				}

			        //��������� ���� ������
			        $zayavka_exist=check_wars($kl);


			      //    [id] => 176[agressor_id] => 78 [defender_id] => 279 [def_receive] => 1 [defender_answer] => 0 [timer] => 1316814531 [status] => 0 )
				if($zayavka_exist)
				{
				    	foreach($zayavka_exist as $zay_id=>$value)
					{
			                //��������� ������� ������.
				               if($value['status']==0)// ����� ������
				               {
					               if(
					               	    ($value[timer]>(time()-(60*60*24*7)) || $value[timer]==0)
					               		&&
					               		(
					               			($value[agressor_id]==$kl && $value[defender_id]==$_POST[tr_klan])
					               			||
					               			($value[defender_id]==$kl && $value[agressor_id]==$_POST[tr_klan])
					            		)

					               )
					               {					               	    $stop='������ ������� ���� ����. ��� ���� ������ � ���, ��� �� ����� ������ �����.';					               }
					               elseif($value[defender_answer]==2)
					               {					               		$arg_name=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$value[agressor_id].' LIMIT 1;'));
					                    	$def_name=mysql_fetch_assoc(mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$value[defender_id].' LIMIT 1;'));
					               		$stop='������ ������� ���� ����. � ��� ��� ���� ����� � '.($kl==$value[agressor_id]?(show_klan_name($def_name['short'],$def_name['align'])):(show_klan_name($arg_name['short'],$arg_name['align']))).'<br>';					               }
					               elseif($value[defender_id]==$kl && $value[def_receive] == 1 && $value[defender_answer] == 0)
					               {					               		$stop='�� ��� �� �������� �� ��������� �����...';					               }
					               elseif($value[agressor_id]==$kl && $value[def_receive] == 1 && $value[defender_answer] == 0)
					               {
					               		$stop='������ ��������. ��� ��� �� �������� �� �����...';
					               }
					               elseif($value[defender_id]==$kl && $value[def_receive] == 1 && $value[defender_answer] == 1)
					               {
					               		$stop='� ��� ���� ����������� �����... ������ ��������.';
					               }
			               		}
			         	}
            			}
				//��������� ������ ����������� �����.
			        $zayavka_exist_post=check_wars($_POST[tr_klan]);
			     
			       // [id] => 183 [agressor_id] => 193 [defender_id] => 184 [def_receive] => 1 [defender_answer] => 0 [timer] => 1316816958
			        foreach($zayavka_exist_post as $zay_id=>$value)
				{
				        if($value['status']==0)
				        {
						if($value[defender_answer]==2)
						{
							$stop='������ ������� ���� ����. ���� ���� ��� �����.';
						}
						elseif($value[defender_id] == $_POST[tr_klan] && $value[defender_answer]==1)
						{							$stop='������ ������� ���� ����. ���� ���� ��� �����.';						}
						elseif($value[defender_id] == $_POST[tr_klan] && $value[defender_answer]==0)
						{							$stop='������ ������� ���� ����. ��� �� ������� ����� �� ��������� ������.';						}
						elseif(($value[defender_id] == $_POST[tr_klan] || $value[agressor_id] == $_POST[tr_klan]) && $value[def_receive] == 1 && $value[defender_answer] == 0)
						{							$stop='� ����� ����� ��� ���� ������������ ������';						}
		                   	}
		        	}

			}
	                else
	                {	                	$stop='� ��� ������������ �����.';	                }
	
	                if(!$stop)
	        	{
	        		$can_add=1;
	        	}
*/
	        }
	        elseif((int)$_POST[al_klan]>0)
	        {
	        	$rekrut=mysql_fetch_array(mysql_query('select * from oldbk.`clans` where id="'.$_POST[al_klan].'" LIMIT 1;'));
	        	if($rekrut[base_klan]>0)
	        	{
	        		$_POST[al_klan]=$rekrut[base_klan];
	        	}
	        	//��������� �� ���� � ��
	        	if($_POST[al_klan]==$kl || $_POST[al_klan]==$klan[rekrut_klan])
	                {
	                	$stop='����� ������ ����?..';
	                }
         		elseif($klan_kazna[kr]>=($war_price*0.5))
         		{
		        	if(!$stop)
		        	{
		        					
					$war_exist=check_wars_exist($_POST[al_klan]); //���������, ���� �� ����������� �����
					if($war_exist)
					{
						foreach($war_exist as $wid=>$wlist)
						{
							foreach($wlist as $id => $value)
							{
								/* -- ������� ����
								if(($value[defender]==$_POST[tr_klan] || $value[agressor]==$_POST[tr_klan]) && $value[def_active]==1)
								{
									$stop='���� ���� ��� �����';	
								}
								*/
								
								if(($value[defender]==$_POST[al_klan] || $value[agressor]==$_POST[al_klan]) && $value[def_active]==1)
								{
									$stop='���� ���� ��� �����';	
								}								
							}
						}
					}

		        	
		        	    //��������� ���� ������
			            	$zayavka_exist=check_wars($kl);

					foreach($zayavka_exist as $zay_id=>$value)
					{

				               echo '<br>';
				               //��������� ������� ������.

				               if(($value[timer]>(time()-(60*60*24*7)) && $value[defender_answer]==2)
				               		&&
				               	  ($value[agressor_id]==$kl || $value[defender_id]==$kl)
		                           	&&
		                          	($value[agressor_id]==$_POST[al_klan] || $value[defender_id]==$_POST[al_klan])
				               )
				               {
				               	  $stop='������ ������� ���� ����. �� � ��� ������... ��� �� ����� ������ ���������� �����.';
				               	//  echo 'k1';
				               	   $can_add=0;
				               }
				               elseif(($value[timer]>time() && $value[defender_answer]==2)
				               		&&
				               	     ($value[agressor_id]==$kl || $value[defender_id]==$kl))
				               {				               	//	echo 'k2';
				               	//	print_r($value);
				               		$id_zayavka=$value['id'];
				               		$can_add=2;
				               }
				        }

		                	$zayavka_exist=check_wars($_POST[al_klan]);
		                //	echo '<br>====';
		                	//print_r($zayavka_exist);
		                //	echo '<br>====';
					foreach($zayavka_exist as $zay_id=>$value)
					{
				        	if(($value[timer]>time() && $value[defender_answer]==2)
				               		&&
				               	  ($value[agressor_id]==$_POST[al_klan] || $value[defender_id]==$_POST[al_klan])
			                           &&
			                          ($value[agressor_id]!=$kl && $value[defender_id]!=$kl)
				               	)
				               {
				           //    	   echo 'k3';
				               		$stop='������ ������� ���� ����. �� ��� �����...';
				               	  	$can_add=0;
				               }
				               elseif(($value[timer]>time() && $value[defender_answer]==2)
				               		&&
				               	  ($value[agressor_id]==$kl || $value[defender_id]==$kl)
			                           &&
			                          ($value[agressor_id]==$_POST[al_klan] || $value[defender_id]==$_POST[al_klan]))
				               {				               	  $stop='������ ������� ���� ����. �� � ��� ������...';
				         //      	  echo 'k4';
				               	   $can_add=0;				               }
				               else
				               {
				        //       		echo 'k5';
				               		//$id_zayavka=$value['id'];
				        //       		print_r($value);
				               		$can_add=2;
				               }
				        }
					//�������� �������� �� ������!!!!
					$ally_exist=check_ally($_POST[al_klan],1);
					foreach($ally_exist as $id=>$value)
		        		{	
		        			if($_POST[al_klan]==$value[helper_klan] && $id_zayavka==$value[id_zayavka])
		        			{
		        				 $stop='������ ������� ���� ����. �� ��� ����� � ���� �����...';
		        			}
		        		
		        		}		

				        $ally_count=mysql_fetch_array(mysql_query('select count(id) as count_id from oldbk.`clans_war_ally` where war_klan='.$kl.' AND helper_answer=1 and status=0;'));
					if($ally_count['count_id']>1)
		            		{
		            	//		echo 'k6';
		            			$can_add=0;
		            			$stop='������ ���������� ������.';
		            		}
			        	 //	$zayavka_exist_post=check_wars($_POST[al_klan]);
		        	}	        	}
	        	else
	                {
	                	$stop='� ��� ������������ �����.';
	                }
	        }
	        else
	        {	        	$can_add=0;
	        	$stop='�� ���� ��� ������...';	        }

		if(!$stop && $rulit==1 && $klan_kazna)
            	{           	
		   $def_klan=mysql_fetch_array(mysql_query('SELECT * from oldbk.`clans` where id="'.$_POST[tr_klan].'";'));
		   $def_glava=check_users_city_data($def_klan[glava]);
		   if ($def_klan[short]!=$def_glava[klan])
		    {
			err('� ����� �������� ��� �����!');
		    }
		   else	 if($can_add==1)
	                	{
				
				//���� ������ - ������ � �������
				
		                //--if((time()-60)<$def_glava[odate]) --//������ �������� �� ������� ����� � �������, ����� ������ "���������� ������ ������, �� ����� � 2-� ����� �������� �� 1 �����, 
		                if(1==1)
		                {
	                       		if($def_klan['rekrut_klan']>0)
				        {
			           	  	$a2=mysql_fetch_array(mysql_query('SELECT * from oldbk.`clans` WHERE id="'.$def_klan['rekrut_klan'].'";'));
			           	  	$txt_def_rec=' � ������� <img src=http://i.oldbk.com/i/align_'.$a2['align'].'.gif><img title='.$a2['short'].' src=http://i.oldbk.com/i/klan/'.$a2['short'].'.gif><b>'.$a2['short'].'</b>';
				        }

	                    		//������
	                    						
	                        	$sql=' ,def_receive=1, timer="'.(time()+(60*60*24)+(60*60*24)).'" ';

                  			//������ ������������ ������ ��� � ��������
               			  	mysql_query('DELETE from oldbk.`clans_war_vizov` WHERE def_receive=0 AND agressor_id="'.$kl.'";');  
               			  	//-- �������, ��� ��� ��� �������� �� ����� ����������, ���� ����� ��������� ����� ��������
					$toched=0;
		                      	$toched=mysql_affected_rows();
		                 	//���������� ����� ��������� �� ��� ������������ ������
					if($toched>0)
					{
						$klan_kazna_aggr=clan_kazna_have($kl);
						if($klan_kazna_aggr)
						{
							put_to_kazna($kl,1,($war_price*$toched*0.8),$user[klan]);	
						}
						else
						{
							$rec['owner']=$user[id];
							$rec['owner_login']=$user[login];
							$rec['owner_balans_do']=$user[money];
							$user['money'] += ($war_price*$toched*0.8);
							$rec['owner_balans_posle']=$user[money];
							$rec['target']=0;
							$rec['target_login']='��, ����������� �� ������ �� �����';
							$rec['type']=105;//��������� ������ �� ��
							$rec['sum_kr']=($war_price*$toched*0.8);
							$rec['item_count']=$toched;
							add_to_new_delo($rec);
							mysql_query("UPDATE `users` set money=money+'".($war_price*$toched*0.8)."' WHERE id='".$user[id]."';");
						}
					}

		                      	$toched=0;
		                  //������� ������������ ������ � ����, ���� �� ������ �����
					mysql_query('DELETE from oldbk.`clans_war_vizov` WHERE def_receive=0 AND agressor_id="'.$_POST[tr_klan].'";');
						   //���������� �����  ���������
					$toched=mysql_affected_rows();
					if($toched>0)
					{
						$glava=mysql_fetch_array(mysql_query('select u.*,c.id as cid from oldbk.`clans` c
	                         		left join oldbk.`users` u
	                         		on u.id=c.glava
	                         		where c.id  = "'.$_POST[tr_klan].'" limit 1; '));
	                         		
						$klan_kazna_aggr=clan_kazna_have($glava[cid]);
						if($klan_kazna_aggr)
						{
							put_to_kazna($glava[cid],1,($war_price*$toched*0.8),$glava[klan],$glava);	
						}
						else
						{
	                        			$glava=check_users_city_data($glava[id]);
	
	              					$rec['owner']=$glava[id];
							$rec['owner_login']=$glava[login];
							$rec['owner_balans_do']=$glava[money];
							$glava['money'] += ($war_price*$toched*0.8);
							$rec['owner_balans_posle']=$glava[money];
							$rec['target']=0;
							$rec['target_login']='��, ����������� �� ������ �� �����';
							$rec['type']=105;//��������� ������ �� ��
							$rec['sum_kr']=($war_price*$toched*0.8);
							$rec['item_count']=$toched;
							add_to_new_delo($rec);
	
		                         	 	mysql_query("UPDATE ".$db_city[$glava['id_city']]."`users` set money=money+'".($war_price*$toched*0.8)."' WHERE id='".$glava[id]."';");
                    			 	}
					}
	                      		//��� �������� ����� ���� ���������� ��� ����-��. ��� ���� ���������, ������� ������
					$data=mysql_query('select * from oldbk.`clans_war_vizov` where def_receive=0 AND defender_id='.$value[agressor_id].';');
					if(mysql_num_rows($data)>0)
					{
		                         	while($row=mysql_fetch_array($data))
		                         	{
	                         		//�������� ������ ��������� ����� ���������.
		                         		mysql_query('DELETE from oldbk.`clans_war_vizov` WHERE id='.$row[id].';');
		                         		$glava=mysql_fetch_array(mysql_query('select u.*,c.id as cid from oldbk.`clans` c
		                         			left join oldbk.`users` u
		                         			on u.id=c.glava
		                         			where c.id  = '.$row[agressor_id].' limit 1; '));
		                         			
		                         		$klan_kazna_aggr=clan_kazna_have($glava[cid]);
							if($klan_kazna_aggr)
							{
								put_to_kazna($glava[cid],1,($war_price*0.8),$glava[klan],$glava);	
							}
							else
							{
		                         			
			                         		$glava=check_users_city_data($glava[id]);
	
			                         		$rec['owner']=$glava[id];
								$rec['owner_login']=$glava[login];
								$rec['owner_balans_do']=$glava[money];
								$glava['money'] += ($war_price*0.8);
								$rec['owner_balans_posle']=$glava[money];
								$rec['target']=0;
								$rec['target_login']='��';
								$rec['type']=105;//��������� ������ �� ��
								$rec['sum_kr']=($war_price*0.8);
								$rec['item_count']=1;
	  							add_to_new_delo($rec);
	
		                         			mysql_query("UPDATE ".$db_city[$glava['id_city']]."`users` set money=money+'".($war_price*0.8)."' WHERE id='".$glava[id]."';");
                            				}
	                         		}
	             		  	}

	                    		$txt='���� '.(show_klan_name($def_klan['short'],$def_klan['align'])).$txt_def_rec.' �������� �����.';
					echo '<font color=red><b>'.$txt.' ������� '.$war_price.' ��.</b></font><br>';
	                	}
	                	/*//--
		                else
		                {
		                	 $kl_txt='���� '.$def_klan[short].' '.($rekrut[base_klan]>0?' � ��� ������� ':' ');
		                	 $sql='';
		                	 echo '<font color=red><b>'.$kl_txt. ($rekrut[base_klan]>0?'�������':'�������').' ��� �����, ����� ����� �������� � �������. -'.$war_price.' ��.</b></font><br>';
		                }
				*///--


	                    
	                        
	                        //--telepost_new($def_glava,$message);--//
	                   if ($def_klan[short]!='')
	                   {
				$message="<font color=red>��������!</font> ���� <b>".(show_klan_name($klan['short'],$klan['align']))."</b> ������ ��� ����� �� �����;";	                   
				$querry="select * from oldbk.users where klan='{$def_klan[short]}' and id_city=0 
				UNION 	 select * from avalon.users where klan='{$def_klan[short]}' and id_city=1";
	                	$rez=mysql_query($querry);
			   	while ($soklans = mysql_fetch_assoc($rez)) 
			   	{
					telegraph_new($soklans,$message,'2');
			   	}
			   }	
			   
			  if ($klan[short]!='')
			  	{
				$message="<font color=red>��������!</font> <b>".$user['login']."</b> ������ ����� ����� ".(show_klan_name($def_klan['short'],$def_klan['align'])).";";				
//				$querry="SELECT * FROM `users` WHERE klan = '".$user[klan]."';";
				$querry="select * from oldbk.users where klan='{$klan[short]}' and id_city=0 
				UNION 	 select * from avalon.users where klan='{$klan[short]}' and id_city=1";
	                		$rez=mysql_query($querry);
			   		while ($soklans = mysql_fetch_assoc($rez)) 
			   		{
					telegraph_new($soklans,$message,'2');
			   		}
			   	}
			   	
			   	if($klan_kazna)
			   	{
			   		//echo 'QWE';
			   		$coment='���������� �����';
			   		by_from_kazna($kl,1,$war_price,$coment);
			   		$klan_kazna=clan_kazna_have($klan['id']);
			   	}
			   	else
			   	{
			   		/*
	       				$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user[money];
					$user['money'] -= ($war_price);
					$rec['owner_balans_posle']=$user[money];
					$rec['target']=0;
					$rec['target_login']=$def_klan['short'];
					$rec['type']=106;//����� �� �����
					$rec['sum_kr']=($war_price);
					$rec['item_count']=0;
					add_to_new_delo($rec);
	
	        			mysql_query("UPDATE `users` set money=money-'".$war_price."' WHERE id='".$user[id]."';");
	        			*/
				}
				mysql_query('insert into oldbk.`clans_war_vizov` set agressor_id='.$kl.', defender_id='.$_POST[tr_klan].' '.$sql.' ;');	            	}
	            	elseif($can_add==2)
                	{				$al_klan=mysql_fetch_array(mysql_query('SELECT * from oldbk.`clans` where id="'.$_POST[al_klan].'";'));
				if($al_klan[id]>0)
				{
				
				$al_glava=check_users_city_data($al_klan['glava']);
				if ($al_glava['klan']==$al_klan['short'])
					{
					$sql="insert into oldbk.`clans_war_ally` set
					war_klan='".$kl."', helper_klan='".$al_klan[id]."', id_zayavka='".$id_zayavka."';";
	                     		mysql_query($sql);
	                     		if(mysql_affected_rows()>0)
	                     		{

		                    //$glava=check_users_city_data($glava[id]);
			                    if($klan_kazna)
					   	{
					   		
					   		$coment='������ ������ ����';
					   		by_from_kazna($kl,1,($war_price*0.5),$coment);
				   			$klan_kazna=clan_kazna_have($kl);
					   	}
					   	else
					   	{
	                        			
	                        			/*
	                        			$rec['owner']=$user[id];
							$rec['owner_login']=$user[login];
							$rec['owner_balans_do']=$user[money];
							$user['money'] -= ($war_price*0.5);
							$rec['owner_balans_posle']=$user[money];
							$rec['target']=0;
							$rec['target_login']=$al_klan['short'];
							$rec['type']=107;//������ �� ������
							$rec['sum_kr']=($war_price*0.5);
							$rec['item_count']=0;
	       						add_to_new_delo($rec);
	
	                        			mysql_query("UPDATE `users` set money=money-'".($war_price*0.5)."' WHERE id='".$user[id]."';");
	                        			*/
						}
						
						$kl_txt='�� ������� ������ � ������ ����� '.$al_klan[short].' '.($al_klan[base_klan]>0?' � ��� ������� ':' ');
						$message="<font color=red>��������!</font> ���� <b>".(show_klan_name($klan['short'],$klan['align']))."</b> ������ ��� ������ � ������ � �����;";
                        	 		
                        	 		$querry="SELECT * FROM `users` WHERE klan = '".$al_glava['klan']."';";
			                	$rez=mysql_query($querry);
					   	while ($soklans = mysql_fetch_assoc($rez)) 
					   	{
							telegraph_new($soklans,$message,'2');
					   	}
					   	
					   	$message="<font color=red>��������!</font> <b>".$user['login']."</b> ��������� � ������ ".(show_klan_name($al_klan['short'],$al_klan['align'])).";";
                        	 		$querry="SELECT * FROM `users` WHERE klan = '".$user['klan']."';";
			                	$rez=mysql_query($querry);
					   	while ($soklans = mysql_fetch_assoc($rez)) 
					   	{
							telegraph_new($soklans,$message,'2');
					   	}
                        	 		//telepost_new($al_glava,$message);
		                 	}
					else
					{						$kl_txt='�� ��� ������� ���� ����';					}
	         			echo '<font color=red><b>'.$kl_txt.'</b></font></br>';
	         		   }
	         		   else
	         		   {
	         			echo '<font color=red><b> ������ ������� ���� � �������� ��� �����!</b></font></br>';
	         		   }	
	         		}                	}
            	}
            	else
   		{
   			echo '<font color=red><b>'.$stop.'</b></font><br>';
   		}
	
	
	}
        
        //��������� ���� ������ (���� �� ��� ��������� ����, � �������� ������� ������. ������ � �� ���� ������ �������)
	//def_receive 0 -�� �������.  1 - �������, 2 ���� ������� ��������.
        //defender_answer 0 - ��� �� �������. 1-���(��� �� �����). 2-��.


	$zayavka_exist=check_wars($kl);

	foreach($zayavka_exist as $zay_id=>$value)
	{
		$start_timer2=check_start_war_time('2',$value[timer]);
		$start_timer24=check_start_war_time('24',$value[timer]);
			//��� ��� ��������� ���������.
		if($value[agressor_id]==$kl)
		{	            	$def_klan=mysql_fetch_array(mysql_query("select * from oldbk.`clans` where id='".$value[defender_id]."' limit 1;"));
	            	if($def_klan[id]>0)
            		{
	            		if((int)$_GET[war]==$zay_id && $value[timer]==0 && $_GET[del]==1)
				{
	      				mysql_query("delete from oldbk.`clans_war_vizov` where agressor_id='".$kl."' AND id='".$zay_id."';" );
					//$klan_kazna_aggr=clan_kazna_have($glava[cid]);
					if($klan_kazna)
					{
						put_to_kazna($klan[id],1,($war_price*0.8),$user[klan]);	
					}
					else
					{
							
	      				//$glava=check_users_city_data($glava[id]);
		      				$rec['owner']=$user[id];
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user[money];
						$user['money'] += ($war_price*0.8);
						$rec['owner_balans_posle']=$user[money];
						$rec['target']=0;
						$rec['target_login']=$def_klan['short'];
						$rec['type']=108;//������� ������ �� �����
						$rec['sum_kr']=($war_price*0.8);
						$rec['item_count']=1;
	       					add_to_new_delo($rec);
	
	                        		mysql_query("UPDATE `users` set money=money+'".($war_price*0.8)."' WHERE id='".$user[id]."';");
						
						echo '������ ��������. '.($war_price*0.8).' ��. ����������.';
		      				$user[money]+=$war_price*0.8;
	      				}
				}
		                elseif($value[def_receive]==0)
		            	{		            		echo '���� '.(show_klan_name($def_klan['short'],$def_klan['align'])).' ��� �� ������� ��� �����... <a href=?'.$faction.'&war='.$zay_id.'&del=1>��������?..</a><br>';		            	}
				elseif($value[def_receive]==1)
				{					if($value[defender_answer]<1)
					{						if($start_timer2>60)
						{
							$echo_time=(round(($start_timer2/60),1)).' ����(��)';
						}
						else
						{
							$echo_time=$start_timer2.' �����';
						}
						echo '���� '.(show_klan_name($def_klan['short'],$def_klan['align'])).' ������� ��� �����... ������� ������ ��� '.$echo_time.'...<br>';					}
					elseif($value[defender_answer]==1)
					{					//���������� ��������� ������� ���������      start_timer2>0 �� ������
						echo '���� '.(show_klan_name($def_klan['short'],$def_klan['align'])).' �� ������ �����. ����� ��������� ����������... ��������� �� �����... ������ �����  '.$start_timer24.' �����...<br>';					}
					elseif($value[defender_answer]==2)
					{
					//���������� ��������� ������� ���������      start_timer2>0 �� ������
						echo '���� '.(show_klan_name($def_klan['short'],$def_klan['align'])).' ������ �����. ��������� ������... ������ �����  '.$start_timer24.' �����...<br>';
						$cr_ally=1;
					}				}
	            	}            	}


//��� ��� ��������� ���������.
		if($value[defender_id]==$kl && $value[def_receive]==1)
		{
			$agrr_klan=mysql_fetch_array(mysql_query('select * from oldbk.`clans` where  id = '.$value['agressor_id'].';'));
			if($agrr_klan[id]>0)
			{
				if($value[defender_answer]<1)
				{
					//�������� �� ������
					if((int)$_GET[war]==$zay_id && (int)$_GET[a]==1 && $start_timer2>0 && $rulit==1)
					{
					    	$begin=time()+60*60*24;

						mysql_query("update oldbk.`clans_war_vizov` set defender_answer='1', timer='".$begin."' where defender_id='".$kl."' AND id='".$zay_id."' AND status=0" );

                            			if($agrr_klan[rekrut_klan]>0)
					        {
					           	$agrr_klan_rek=mysql_fetch_array(mysql_query("select * from oldbk.`clans` where  id = '".$agrr_klan['rekrut_klan']."';"));
					           	$txt_agrr_rec=' � �������� '.(show_klan_name($agrr_klan_rek['short'],$agrr_klan_rek['align']));
					        }

						if($klan['rekrut_klan']>0)
						{
							$txt_def_rec=' � ������� '.(show_klan_name($recrut['short'],$recrut['align']));
						}
						
						//�������� � ������ ��
						
				            	$txt1='���� '.(show_klan_name($klan['short'],$klan['align'])).$txt_def_rec; //�������� �������
				            	$txt=(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).$txt_agrr_rec; // ����������
				            	$beg=', ������ ����������� ����� '.(date('d-m-Y H:i',$begin)); 
                        			
                        			
                        			$print='<br>'.$txt1.' �������� � ������ �� '.$txt.$beg.'<br>';
                        			
                        			echo $print;
                        			
				    		mysql_query("update oldbk.`clans_war_vizov` set defender_answer=1 where id='".$zay_id."';");
				      		mysql_query("insert into oldbk.`clans_war_log` set txt='".$txt."', txt1='".$txt1."',def_answer=1, begin_txt='".$beg."', type=1, start_time='".$begin."', war_id='".$value['id']."';");
						echo '����� ��������. ����� �������� ����� '.$start_timer24.' �����. ��������� �� �����...<br>';
						
						$message="<font color=red>��������!</font> ���� ".(show_klan_name($klan['short'],$klan['align']))." ��������� ��������� ���� �����, ����� ����� �����������;";
                        	 		$querry="SELECT * FROM `users` WHERE klan = '".$agrr_klan[short]."';";
			                	$rez=mysql_query($querry);
					   	while ($soklans = mysql_fetch_assoc($rez)) 
					   	{
							telegraph_new($soklans,$message,'2');
					   	}
						
						$message="<font color=red>��������!</font> <b>".$user['login']."</b> ��������� ��������� ����� �� ����� ".(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).", ����� ����� �����������;";
                        	 		$querry="SELECT * FROM `users` WHERE klan = '".$user[klan]."';";
			                	$rez=mysql_query($querry);
					   	while ($soklans = mysql_fetch_assoc($rez)) 
					   	{
							telegraph_new($soklans,$message,'2');
					   	}
						
					}
					else
					if((int)$_GET[war]==$zay_id && (int)$_GET[a]==2 && $start_timer2>0 && $rulit==1 && $klan_kazna)
					{						if($klan_kazna[kr]>=$war_price)
						{							$begin=time()+60*60*24;

                                    			mysql_query("update oldbk.`clans_war_vizov` set defender_answer='2', timer='".$begin."' where defender_id='".$kl."' AND id='".$zay_id."' AND status=0");

		                            		if($agrr_klan[rekrut_klan]>0)
							{
						           	$agrr_klan_rek=mysql_fetch_array(mysql_query("select * from oldbk.`clans` where  id = '".$agrr_klan['rekrut_klan']."';"));
						           	$txt_agrr_rec=' � �������� '.(show_klan_name($agrr_klan_rek['short'],$agrr_klan_rek['align']));
							}
						        if($klan['rekrut_klan']>0)
						        {
								$txt_def_rec=' � ������� '.(show_klan_name($recrut['short'],$recrut['align']));
						        }
							//answe=2 ������ ����� �� 
							$txt1='���� '.(show_klan_name($klan['short'],$klan['align'])).$txt_def_rec; //�������� ������ �����
							$txt=(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).$txt_agrr_rec;//����������
							$beg=', ������ '.(date('d-m-Y H:i',$begin)); 
							
							$print='<br>'.$txt1.' ������ ����� �� '.$txt.$beg.'<br>';
                        			
                        				echo $print;

						      	mysql_query("insert into oldbk.`clans_war_log` set txt='".$txt."', txt1='".$txt1."', def_answer=2, begin_txt='".$beg."', type=1, start_time='".$begin."', war_id='".$value['id']."';");
						      	if($debag==1)
						      	{						      		echo mysql_error();						      	}
						      		//$glava=check_users_city_data($glava[id]);
						      		
						      
							if($klan_kazna)
							{
								$coment='�������� �����';
			   					by_from_kazna($kl,1,$war_price,$coment);
							}
							else
							{	
				      				/*
				      				$rec['owner']=$user[id];
								$rec['owner_login']=$user[login];
								$rec['owner_balans_do']=$user[money];
								$user['money'] -= ($war_price);
								$rec['owner_balans_posle']=$user[money];
								$rec['target']=0;
								$rec['target_login']=$agrr_klan['short'];
								$rec['type']=109;//�������� �� �����
								$rec['sum_kr']=($war_price);
								$rec['item_count']=1;
		       						add_to_new_delo($rec);
	
			                        		mysql_query("UPDATE `users` set money=money-'".($war_price)."' WHERE id='".$user[id]."';");
			                        		*/
							}
		                            
							echo '����� ������. ����� �������� ����� '.$start_timer24.' �����. � ��� ��� ���� ����� ������� ���������.<br>';
							
							$message="<font color=red>��������!</font> <b>".$user['login']."</b> ������ ����� �� ����� ".(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).", ��������� ������!;";
	                        	 		$querry="SELECT * FROM `users` WHERE klan = '".$user[klan]."';";
				                	$rez=mysql_query($querry);
						   	while ($soklans = mysql_fetch_assoc($rez)) 
						   	{
								telegraph_new($soklans,$message,'2');
						   	}
						   	
						   	$message="<font color=red>��������!</font> ���� ".(show_klan_name($klan['short'],$klan['align']))." ������ ���� �����, ��������� ������!;";
	                        	 		$querry="SELECT * FROM `users` WHERE klan = '".$agrr_klan[short]."';";
				                	$rez=mysql_query($querry);
						   	while ($soklans = mysql_fetch_assoc($rez)) 
						   	{
								telegraph_new($soklans,$message,'2');
						   	}						}
						else
						{							echo '� ��� ������������ �������...';						}
					}
					else
					{
						if($klan_kazna)
						{
							echo '���� '.(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).' ������ ��� �����. ���� �������� �� ������, (� ����� '.$klan_kazna[kr].'��.)<br>'. 
							($rulit==1?' <a href=?'.$faction.'&war='.$zay_id.'&a=2>�� ('.$war_price.'��.)</a>/<a href=?'.$faction.'&war='.$zay_id.'&a=1>���</a>':'').'. <br>������������� ��������� <b>���</b> ����� '.$start_timer2.' �����<br>';
						}
						else
						{
							echo '���� '.(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).' ������ ��� �����. ������� ����� ����� ������ ��� ������� �����.<br>'. 
							($rulit==1?'<a href=?war='.$zay_id.'&a=1>���</a>':'').'. <br>������������� ��������� <b>���</b> ����� '.$start_timer2.' �����<br>'; 
						
						}
						
					}				}
				elseif($value[defender_answer]==1)
				{
					echo '�� �� �������� �� ����� ����� '.(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).'. �� �� ������� �������� �������. ����� �������� ����� '.$start_timer24 .' �����';
				}
				elseif($value[defender_answer]==2)
				{					echo '�� �������� �� ����� ����� '.(show_klan_name($agrr_klan['short'],$agrr_klan['align'])).'. ����� �������� ����� '.$start_timer24 .' �����. ��������� ������!';					$cr_ally=1;
				}
			}		}

		echo '<br>';	}
}


if($stop_check_zayavka==1 || $can_answer_ally==1)
{
        if((int)$_GET['ally']&& $rulit==1)
	{		$ally_exist=check_ally($kl);
		if($debag==1)
		{
			print_r($ally_exist);
			/*
			Array ( [26] => Array 
					( [id] => 26 [id_zayavka] => 156 [war_klan] => 421  
						[helper_klan] => 34 [helper_answer] => 0  [status] => 0 ) )
			*/
		}
		
		
		foreach($ally_exist as $id=>$value)
	        {
			if($value['helper_klan']==$kl)
			{
				$war=mysql_fetch_array(mysql_query("select * from oldbk.`clans_war_vizov` where id='".$value['id_zayavka']."';"));
				//���� �������� �� ����� ������ - �������������.
				if($value['helper_answer']==0 && $_GET['ally']==1 && (int)$_GET['id']==$id)
				{
	            			//��������� ���-�� ������. ���� ������ ��� ����  - ������� ������.
	              			$ally_count=mysql_fetch_array(mysql_query("select count(id) as count_id 
	              					from oldbk.`clans_war_ally` where id_zayavka='".$war['id']."' 
	              					AND helper_answer=1 and status=0 AND war_clan='".$value['war_klan']."';"));
	              					
		            		if($ally_count['count_id']<2)
		            		{
		            			mysql_query("update oldbk.`clans_war_ally` set helper_answer=1 WHERE id='".$id."' AND helper_klan='".$kl."';");
		            			$ally_count['count_id']+=1;
		            		}

					if($ally_count['count_id']==2)
					{
						//������� ������������ ������ �� �����, � ������� � �������. �� ��� �������
						$toched=0;
						mysql_query("delete from oldbk.`clans_war_ally` WHERE id_zayavka='".$war['id']."' AND war_klan='".$value['war_klan']."' AND helper_answer=0;");
						$toched=mysql_affected_rows();
						if($toched>0)
						{
														$klan_owner=mysql_fetch_array(mysql_query('SELECT u.*,c.id as cid from oldbk.`clans`
							left join users u
							on u.id=c.glava
							where c.id='.$value['war_klan'].';'));
							$klan_kazna_aggr=clan_kazna_have($klan_owner[cid]);
							if($klan_kazna_aggr)
							{
								put_to_kazna($klan_owner[cid],1,($war_price*$toched*0.5),$klan_owner[klan],$klan_owner);
								
							}
							else
							{
	                      					
	                      					$klan_owner=check_users_city_data($klan_owner[id]);
			      					$rec['owner']=$klan_owner[id];
								$rec['owner_login']=$klan_owner[login];
								$rec['owner_balans_do']=$klan_owner[money];
								$klan_owner['money'] += ($war_price*$toched*0.5);
								$rec['owner_balans_posle']=$klan_owner[money];
								$rec['target']=0;
								$rec['target_login']='��, ������� �� ����� ������� ������';
								$rec['type']=110;//����� ������, ������������� ������
								$rec['sum_kr']=($war_price*$toched*0.5);
								$rec['item_count']=$toched;
		       						add_to_new_delo($rec);
	
		                        			mysql_query("UPDATE `users` set money=money+'".($war_price*$toched*0.5)."' WHERE id='".$klan_owner[id]."';");
							}	            		   		}
	            			}
	            			$value['helper_answer']=1;
                       //����� ���
                       /////
                       //������ ����� ������ � � ��� � � ���
					$ally_klan=mysql_fetch_array(mysql_query('select * from oldbk.`clans` where  id = '.$value['war_klan'].';'));
				        $txt='���� '.(show_klan_name($klan['short'],$klan['align'])).' ������� � ������ � ������ '.(show_klan_name($ally_klan['short'],$ally_klan['align']));
				       
				       
				        //��������� ���� � ������� �������
				        $sql="insert into oldbk.`clans_war_log` set txt='".$txt."', type=1, start_time='".$begin."', war_id='".$value['id_zayavka']."';";
				        mysql_query($sql);
					$time_st=time()+60*60;
					 
				        //��������� ���������� ����� �� ������ ����� (���� ����� ���� - ������ ���)
				        if($time_st>$war[timer])
				        {
				        	$beg=', ������ ����� '.(date('d-m-Y H:i',$time_st)); 
				        	mysql_query("UPDATE oldbk.clans_war_vizov SET timer='".$time_st."' WHERE id='".$war[id]."';");
				        	mysql_query("UPDATE oldbk.clans_war_log SET start_time='".$time_st."', begin_txt='".$beg."' WHERE war_id='".$war[id]."' AND begin_txt!='';");
				        	//�������� ������ ����, �� ����� ����������... �������� �� ��� c ������� ����������
				        }
				        
				       
				      	   //////////////////////
                   //���� �������� ����������
					$sys_ally=array();
					$data5=mysql_query("SELECT cw.*, u.login, u.id_city, u.odata
					FROM oldbk.`clans_war_ally` cw, oldbk.`clans` c, oldbk.`users` u
					WHERE
					id_zayavka='".$value['id_zayavka']."'
					AND (cw.war_klan=c.id OR cw.helper_klan=c.id)
					AND c.glava=u.id;");

					while($row5=mysql_fetch_array($data5))
					{
						telepost_new($row5,$txt);					}

				      	//� ������ ������� �, ������ ������ �� ���� �� ������� �.
					$data=mysql_query("select * from oldbk.`clans_war_ally` WHERE id_zayavka='".$war['id']."' AND helper_klan='".$kl."' AND helper_answer=0;");
					$del_ids=array();
					if(mysql_num_rows($data)>0)
					{   //���� ��� �������...
						while($row=mysql_fetch_array($data))
						{	                                   			$klan_owner=mysql_fetch_array(mysql_query('SELECT u.*,c.id as cid from oldbk.`clans` c
							left join oldbk.users u
							on u.id=c.glava
							where c.id='.$row['war_klan'].';'));
							
							$klan_kazna_aggr=clan_kazna_have($klan_owner[cid]);
							
							if($klan_kazna_aggr)
							{
								put_to_kazna($klan_owner[cid],1,($war_price*0.5),$klan_owner[klan],$klan_owner);	
							}
							else
							{
			            		   	   	$klan_owner=check_users_city_data($klan_owner[id]);
	
			      					$rec['owner']=$klan_owner[id];
								$rec['owner_login']=$klan_owner[login];
								$rec['owner_balans_do']=$klan_owner[money];
								$klan_owner['money'] += ($war_price*0.5);
								$rec['owner_balans_posle']=$klan_owner[money];
								$rec['target']=0;
								$rec['target_login']='��, ������� �� ����� ������� ������';
								$rec['type']=110;//����� ������, ������������� ������
								$rec['sum_kr']=($war_price*0.5);
								$rec['item_count']=1;
		       						add_to_new_delo($rec);
	
			                        		mysql_query("UPDATE `users` set money=money+'".($war_price*0.5)."' WHERE id='".$klan_owner[id]."';");
							}
		                          
                           			}
                           			mysql_query('DELETE from oldbk.`clans_war_ally` WHERE id_zayavka='.$war['id'].' AND helper_klan='.$kl.' AND helper_answer=0;');				      	}
	            		   	echo '<font color=red><b>�� �������� �� ������</b></font><br>';
	            		}
		                elseif($value['helper_answer']==0 && $_GET['ally']==2 && $_GET['id']==$id)
		                {
		             		mysql_query("delete from oldbk.`clans_war_ally` WHERE id='".$id."' AND helper_klan='".$kl."' AND helper_answer=0 and status=0;");
		             		if(mysql_affected_rows()>0)
	                        	{                            			$l_ally_klan=mysql_fetch_array(mysql_query("select * from oldbk.`clans` where id = '".$value['war_klan']."' limit 1;"));

                            			$l_ally_glava=mysql_fetch_array(mysql_query("select * FROM users where id = '".$l_ally_klan['glava']."' LIMIT 1;"));
                    				
                    				$klan_kazna_aggr=clan_kazna_have($l_ally_klan[id]);
							
						if($klan_kazna_aggr)
						{
							put_to_kazna($l_ally_klan[id],1,($war_price*0.5*0.8),$l_ally_glava[klan],$l_ally_glava);	
						}
						else
						{
	                    				$l_ally_glava=check_users_city_data($l_ally_glava[id]);
	
		      					$rec['owner']=$l_ally_glava[id];
							$rec['owner_login']=$l_ally_glava[login];
							$rec['owner_balans_do']=$l_ally_glava[money];
							$l_ally_glava['money'] += ($war_price*0.5*0.8);
							$rec['owner_balans_posle']=$l_ally_glava[money];
							$rec['target']=0;
							$rec['target_login']=$l_ally_klan['short'];
							$rec['type']=111;//����� ������, ������������� ������
							$rec['sum_kr']=($war_price*0.5*0.8);
							$rec['item_count']=1;
	       						add_to_new_delo($rec);
	
	                        			mysql_query("UPDATE `users` set money=money+'".($war_price*0.5*0.8)."' WHERE id='".$l_ally_glava[id]."';");
                        			}
	            		    		echo '<font color=red><b>�� �������� ����� '.(show_klan_name($l_ally_klan['short'],$l_ally_klan['align'])).' � ������</b></font><br>';
	            			}
            				$value['helper_answer']=1000;//������ � �������, ���� ������ ������ �� ��������
	                	}
	            	}
	            	else
	            	if($value['war_klan']==$kl)
	            	{             			$war=mysql_fetch_array(mysql_query("select * from oldbk.`clans_war_vizov` where id='".$value['id_zayavka']."';"));
				if($value['helper_answer']==0 && $_GET['ally']==3 && $_GET['id']==$id && $rulit==1)
				{
                       			$sql="delete from oldbk.`clans_war_ally` WHERE id_zayavka='".$war['id']."' AND helper_klan='".$value['helper_klan']."' AND helper_answer=0;";
 					mysql_query($sql);					if(mysql_affected_rows()>0)
					{
						$ally_klan=mysql_fetch_array(mysql_query("select u.*, c.id as uid from oldbk.`clans` c 
										left join oldbk.users u 
										on u.klan=c.short
										where c.id = '".$value['helper_klan']."' limit 1;"));                  				//$l_ally_glava=check_users_city_data($l_ally_glava[id]);
						
						
						if($klan_kazna)
						{
							echo 'kzn';
							put_to_kazna($kl,1,($war_price*0.5*0.8),$user[klan],$user);	
							$klan_kazna=clan_kazna_have($kl);
						}
						else
						{
	      						echo 'prs';
	      						$rec['owner']=$user[id];
							$rec['owner_login']=$user[login];
							$rec['owner_balans_do']=$user[money];
							$user['money'] += ($war_price*0.5*0.8);
							$rec['owner_balans_posle']=$user[money];
							$rec['target']=0;
							$rec['target_login']=$ally_klan['short'];
							$rec['type']=112;//����� ������, ������������� ������
							$rec['sum_kr']=($war_price*0.5*0.8);
							$rec['item_count']=1;
       							add_to_new_delo($rec);

                        				mysql_query("UPDATE `users` set money=money+'".($war_price*0.5*0.8)."' WHERE id='".$user[id]."';");
                        			}
                           				}
                    		}	            	}
		}

	}

	$ally_exist=check_ally($kl);
	foreach($ally_exist as $id=>$value)
	{
        	if($value['war_klan']==$kl )
        	{        		$klan_helper=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` where id = '".$value['helper_klan']."' LIMIT 1"));
        		if($klan_helper[id]>0)
        		{	        		if($value['helper_answer']==0)
	        		{	                		echo '������ ����� '.(show_klan_name($klan_helper['short'],$klan_helper['align'])).' ����������. '.($rulit==1?'<a href=?'.$faction.'&ally=3&id='.$id.'>��������?</a>':'');
	        			echo '<br>';
	        		}
	        		elseif($value['helper_answer']==1 && $value['status']==0)
	        		{	        			echo '���� '.(show_klan_name($klan_helper['short'],$klan_helper['align'])).' ����� �������� ��� � ���� �����.';
	        			echo '<br>';	        		}
        		}        	}
            	elseif($value['helper_klan']==$kl)
            	{	            	$sql="select cwv.*,ca.short as agrr_short, ca.align as agrr_align, cd.short as def_short, cd.align as def_align
	            	from oldbk.`clans_war_vizov` cwv

	            	left join oldbk.`clans` ca
	            	on cwv.agressor_id=ca.id

	            	left join oldbk.`clans` cd
	            	on cwv.defender_id=cd.id

	            	where cwv.id='".$value['id_zayavka']."';";
	            	if($debag==1)
	            	{	            		// echo $sql;	            	}
            		$war=mysql_fetch_array(mysql_query($sql));


            		$klan_helper=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` where id = '".$value['helper_klan']."' LIMIT 1"));
            		$klan_war=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` where id = '".$value['war_klan']."' LIMIT 1"));

	            	if($value['helper_answer']==0)
	            	{
	            		echo '�������� ������ �� ������ �� ����� '.(show_klan_name($klan_war['short'],$klan_war['align'])).' ������ �����
	            		'.($value['war_klan']==$war['agressor_id']?(show_klan_name($war['def_short'],$war['def_align'])):(show_klan_name($war['agrr_short'],$war['agrr_align']))).
	            		($rulit==1?'<a href=?'.$faction.'&ally=1&id='.$id.'>�������� � ������??</a>  <a href=?'.$faction.'&ally=2&id='.$id.'>��������� �����������??</a>  ':'');	            	}
	            	elseif($value['helper_answer']==1)
	            	{
	            		echo '�� ��������� ����� '.(show_klan_name($klan_war['short'],$klan_war['align'])).' � ����� ������ ����� '.
	            		($value['war_klan']==$war['agressor_id']?(show_klan_name($war['def_short'],$war['def_align'])):(show_klan_name($war['agrr_short'],$war['agrr_align'])));	            	}
	            	echo '<br>';            	}        }
         //����� ������ � ��������
	if($rulit==1 && $stop_check_zayavka==1)
	{
 		echo '<form method=post>
			<table border=1>
				<tr>
					<td>
					�����:
					</td>
				</tr>';
  			echo '<tr>
  					<td> ';
			     //����� ������ ������
			echo ($cr_ally==1?'�������� � ������ ('.($war_price*0.5).'��.):':'�������� ����� ����� ('.($war_price).'��.):').' <select size="1" name="'.($cr_ally==1?'al_klan':'tr_klan').'">
			<option value=""></option>';
			
			$sql=mysql_query("select co.id,co.short,cr.id as rid,cr.short as rshort
			from oldbk.`clans` co
			left join oldbk.`clans` cr
			on co.rekrut_klan=cr.id
			where co.base_klan=0 AND co.id !='".$kl."' AND (co.short !='Adminion' or co.short!='radminion')
			order by short");
			while($data=mysql_fetch_array($sql))
			{
				//if (($data[id]!=34) and ($data[id]!=78) and ($data[id]!=87))
			    //{
					echo '<option  '.($_POST[tr_klan]==$data[id]?'selected':'').'  value="'.$data[id].'">'.$data[short].($data[rid]>0?' - '.$data[rshort]:'').'</option>';
			    //}
			}
					echo '</select><br>';
					if($klan_kazna)
					{
					//	echo '<input type=checkbox value=1 name=kazna> ��������� �� �����. <br> ';
						echo '<input type="submit" name="addwar" value="'.($cr_ally==1?'��������!':'��������!').'"> <br> <small>'.($cr_ally==1?'(��� ��� ����� ������ '.$war_price.')':'').'(� ����� '.$klan_kazna[kr].'��.)</small>';
					}
					else
					{
						echo '��� ������ ���������� ������� �����.';
					}
			// �������� - ����� ������� ������ ��������
			// ��������� ���� �� � ���� �����
					 
	  		echo '
	  			</td>
	  		</tr></table>
	  	</form>';
  	}}



	?>
