<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='������ �����';
$baff_type=828;

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
elseif (($user['room'] >= 210) AND ($user['room'] <= 300))   
{
echo "� ��������� ���� ������ �������� ��������!"; 
}
else {
	
	
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type=828 ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��� ������������ ��� ��������, �������� ��� ���������!');
	}
	else
	 {
		//2. ���������  ������� ���� ��� � ���� ��� ������������� ��� ���������� 
		$get_count_baff=mysql_query("select  * from effects where battle='{$user[battle]}' and type=828  and owner in (select id from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp >0); ");
		$kow=0;
		
		
		$bots_ar[4]=554;
		$bots_ar[5]=555;		
		$bots_ar[6]=556;		
		$bots_ar[7]=557;		
		$bots_ar[8]=558;		
		$bots_ar[9]=559;		
		$bots_ar[10]=560;		
		$bots_ar[11]=561;				
		$bots_ar[12]=562;				
		$bots_ar[13]=563;				
		
		$bot_lvl=0;
		
		while ($baff_owners = mysql_fetch_array($get_count_baff))
			   	{
				$kow++;
				$remem_own[$kow]=$baff_owners[owner];
				$remem_time[$kow]=$baff_owners[time];
				$remem_baff_id[$kow]=$baff_owners[id];
				$bot_lvl+=(int)($baff_owners[add_info]);
			   	}
		
			if ($kow==0)
			{
			//������ � �������
				mysql_query("INSERT INTO `effects` SET `type`='828',`name`='������ ������ �����', `time`='".(time()+60)."', `owner`='{$user[id]}', `add_info`='{$user[level]}' , `battle`='{$user[battle]}';");//1 ������
				if (mysql_affected_rows()>0)
				{
				
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>. <i>(����� ����...)</i> <BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(����� ����...)</i>\n");
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			}
			else if ($kow==1)
			{
			//���� 1 � ���������
				mysql_query("INSERT INTO `effects` SET `type`='828',`name`='����������� ������ �����',`time`='".$remem_time[1]."',`owner`='{$user[id]}',  `add_info`='{$user[level]}' ,  `battle`='{$user[battle]}';");//����� ��������� � ������ ������
				if (mysql_affected_rows()>0)
				{

					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>. <i>(��������� ����...)</i> <BR>');
		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(��������� ����...)</i>\n");
				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				}
			}
			else
			{
			//���� ���� � ������� � ������� ���
			$bot_lvl+=$user[level];
			$bot_lvl=round($bot_lvl/3);
			if ($bot_lvl<=4) { $bot_lvl=4; }
			if ($bot_lvl>13) { $bot_lvl=13; }
							
			//������� ������ ����
			foreach($remem_own as $ic=>$owner)
				{
				mysql_query("DELETE from effects where `type`='828' and owner='{$owner}' and battle='{$user[battle]}'  ;"); 	
				}
				
				///������ ����
				$clon_count=mysql_fetch_array(mysql_query("select * from battle_vars WHERE battle='".$user['battle']."' and owner='".$user['id']."' ORDER BY `bots_use` DESC LIMIT 1; "));

				$bot_data=mysql_fetch_array(mysql_query("select * from users where id='{$bots_ar[$bot_lvl]}' ;"));
				$bot_data[login]=$bot_data[login]." (".($clon_count[bots_use]+1).")";
				
				require_once('fsystem.php');
				$bots_items=load_mass_items_by_id($bot_data);
				
				//$bots_items['allsumm']=$bots_items['allsumm']*0.4;//�������� ��������� ������
				mysql_query("INSERT INTO `users_clons` SET `login`='".$bot_data[login]."',`sex`='{$bot_data['sex']}',
					`level`='{$bot_data['level']}',`align`='{$bot_data['align']}',`klan`='{$bot_data['klan']}',`sila`='{$bot_data['sila']}',
					`lovk`='{$bot_data['lovk']}',`inta`='{$bot_data['inta']}',`vinos`='{$bot_data['vinos']}',
					`intel`='{$bot_data['intel']}',`mudra`='{$bot_data['mudra']}',`duh`='{$bot_data['duh']}',`bojes`='{$bot_data['bojes']}',`noj`='{$bot_data['noj']}',
					`mec`='{$bot_data['mec']}',`topor`='{$bot_data['topor']}',`dubina`='{$bot_data['dubina']}',`maxhp`='{$bot_data['maxhp']}',`hp`='{$bot_data['hp']}',
					`maxmana`='{$bot_data['maxmana']}',`mana`='{$bot_data['mana']}',`sergi`='{$bot_data['sergi']}',`kulon`='{$bot_data['kulon']}',`perchi`='{$bot_data['perchi']}',
					`weap`='{$bot_data['weap']}',`bron`='{$bot_data['bron']}',`r1`='{$bot_data['r1']}',`r2`='{$bot_data['r2']}',`r3`='{$bot_data['r3']}',`helm`='{$bot_data['helm']}',
					`shit`='{$bot_data['shit']}',`boots`='{$bot_data['boots']}',`nakidka`='{$bot_data['nakidka']}',`rubashka`='{$bot_data['rubashka']}',`shadow`='{$bot_data['shadow']}',`battle`='{$user['battle']}',`bot`=1,
					`id_user`='{$bot_data['id']}',`at_cost`='{$bots_items['allsumm']}',`kulak1`=0,`sum_minu`='{$bots_items['min_u']}',
					`sum_maxu`='{$bots_items['max_u']}',`sum_mfkrit`='{$bots_items['krit_mf']}',`sum_mfakrit`='{$bots_items['akrit_mf']}',
					`sum_mfuvorot`='{$bots_items['uvor_mf']}',`sum_mfauvorot`='{$bots_items['auvor_mf']}',`sum_bron1`='{$bots_items['bron1']}',
					`sum_bron2`='{$bots_items['bron2']}',`sum_bron3`='{$bots_items['bron3']}',`sum_bron4`='{$bots_items['bron4']}',`ups`='{$bots_items['ups']}',
					`injury_possible`=0, `battle_t`='{$user['battle_t']}', `mklevel`='{$bot_lvl}';");
					
				$bot_data[id] = mysql_insert_id();
				$time = time();
				$ttt=$user[battle_t];
				// ��������� � ������ ������
				if ($user[battle_t]==1)
				  {
				  $boec_t1[$bot_data[id]]=$bot_data;
				  // ��������� ������	
		         	  $data_battle[t1].=";".$bot_data[id];
				  }
				  elseif ($user[battle_t]==2)
				  {
				  $boec_t2[$bot_data[id]]=$bot_data;
		  		  // ��������� ������	
		         	  $data_battle[t2].=";".$bot_data[id];
				  }elseif ($user[battle_t]==3)
				  {
				  $boec_t3[$bot_data[id]]=$bot_data;
		  		  // ��������� ������	
		         	  $data_battle[t3].=";".$bot_data[id];
				  }
				  
				  
				$temp_bot_name=BNewHist($bot_data);		
				$temp_bot_namea = nick_align_klan($bot_data);							
				$all_bots_namea=$temp_bot_namea;
				$all_bots_name=$temp_bot_name;
				$all_bots_id=$bot_data[id];	
				$all_bots_hist=$temp_bot_name;

				mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`bots_use`) values('".$user['battle']."', '".$user['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `bots_use` =`bots_use`+1;");
				mysql_query('UPDATE battle SET to1='.$time.', to2='.$time.', t'.$ttt.'=CONCAT(t'.$ttt.',\';'.$all_bots_id.'\') , t'.$ttt.'hist=CONCAT(t'.$ttt.'hist,\''.$all_bots_hist.'\')    WHERE id = '.$user['battle'].' ;');
				
		
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					
					if ($user[sex]==0) {$action='�';}

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, � �������'.$action.' '.$all_bots_namea.'  <i>(������ ����...)</i> <BR>');									

		       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::, � �������{$action} {$all_bots_namea}  <i>(������{$action} ����...)</i>\n");

				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				
			   }
			  
	}
			
} 
	



?>
