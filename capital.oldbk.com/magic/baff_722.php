<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='������ ����';
$baff_type=722;//822

if ($user['battle'] == 0) 
{	
	echo "��� ������ �����..."; 
}
elseif($user[hp]<=0) {      err('��� ��� ��� �������!');        }
elseif (can_hill($user))	{  err('�� �������� �� ������ ������������ �������������� �����.'); }
else {
	
	
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type=822 ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��� ������������ ��� ��������, �������� ��� ���������!');
	}
	else
	 {
 	 $get_var_baff= mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$user[battle]}' and owner='{$user[id]}' ;"));
	 if ($get_var_baff[baf_722_use]>0)
		{
			err('����� ������������ ������ ��� � ���!');
		}
		else
		{
		//2. ���������  ������� ���� ��� � ���� ��� ������������� ��� ���������� 
		$get_count_baff=mysql_query("select  * from effects where battle='{$user[battle]}' and type=822  and owner in (select id from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp >0); ");
		$kow=0;
		while ($baff_owners = mysql_fetch_array($get_count_baff))
			   	{
				$kow++;
				$remem_own[$kow]=$baff_owners[owner];
				$remem_time[$kow]=$baff_owners[time];
				$remem_baff_id[$kow]=$baff_owners[id];
			   	}
		
			if ($kow==0)
			{
			//������ � �������
				mysql_query("INSERT INTO `effects` SET `type`='822',`name`='������ ������ ����', `time`='".(time()+60)."', `owner`='{$user[id]}',`battle`='{$user[battle]}';");//1 ������
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
				mysql_query("INSERT INTO `effects` SET `type`='822',`name`='����������� ������ ����',`time`='".$remem_time[1]."',`owner`='{$user[id]}',`battle`='{$user[battle]}';");//����� ��������� � ������ ������
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
			//������� ����?
			$cure_value=25;
			if(($user['hp'] + $cure_value) > $user['maxhp'])  {  $add_hp=$user['maxhp']-$user['hp']; 	}  else  {  $add_hp=$cure_value; }
			
			//�����
			$nohp=0;
			if ($add_hp>0)
			{ mysql_query("UPDATE `users` SET `hp` =`hp`+ ".$add_hp."  WHERE `id` = '{$user[id]}' and hp>0 ;"); }
			else { $nohp=1; }
		if ((mysql_affected_rows()>0) OR ($nohp==1))
		     {	
		     $user[hp]+=$add_hp ;  	
			// ����� ������
				if ($user[battle_t]==1) 
				{ 
				$boec_t1[$user[id]][hp]=$user[hp] ;  
				}
				else if ($user[battle_t]==2) 
				{  
				$boec_t2[$user[id]][hp]=$user[hp];  
				}
				else if ($user[battle_t]==3) 
				{  
				$boec_t3[$user[id]][hp]=$user[hp];  
				}
			//������ ������ ����
			mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`=1999999999,`owner`='{$user[id]}',`lastup`=5,`battle`='{$user[battle]}';");						
			//������ �������  ����
			mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_722_use`) values('".$user['battle']."', '".$user[id]."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_722_use` =`baf_722_use`+1;");				
			
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
				
//			addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, ������� ����� +<B>'.((($user[hidden]>0)and($user[hiddenlog]==''))?"??</B> [??/??]":"{$cure_value}</B> [{$user[hp]}/{$user[maxhp]}]").'  <i>(������ ����...)</i> <BR>');									

	       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::, ������� ����� +<b><font color=red>".((($user[hidden]>0)and($user[hiddenlog]==''))?"??</font></b> [??/??]":"{$cure_value}</font></b> [{$user[hp]}/{$user[maxhp]}]")."  <i>(������ ����...)</i>\n");												
				
			//������� ������ ����
			foreach($remem_own as $ic=>$owner)
				{
				mysql_query("DELETE from effects where `type`='822' and owner='{$owner}' and battle='{$user[battle]}'  ;"); 	

				$cut_telo=mysql_fetch_array(mysql_query("select * from users where battle='{$user[battle]}' and id='{$owner}' and hp > 0 ;"));

				 if ($cut_telo[id] >0)
				 {
				//������ �������  ����
				mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_722_use`) values('".$user['battle']."', '".$owner."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_722_use` =`baf_722_use`+1;");
				//������ ������ ����
				mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`=1999999999,`owner`='{$owner}',`lastup`=5,`battle`='{$user[battle]}';");						
			
				//��������� ����� +25 ��
				$cure_value=25;
				if(($cut_telo['hp'] + $cure_value) > $cut_telo['maxhp'])  {  $add_hp=$cut_telo['maxhp']-$cut_telo['hp']; }  else  {  $add_hp=$cure_value; }
				
				//�����
				$nohp=0;
				if ($add_hp>0) { mysql_query("UPDATE `users` SET `hp` =`hp`+ ".$add_hp."  WHERE `id` = ".$cut_telo[id]." and hp>0 ;"); 	}
						else { 	$nohp=1; }
				if ( (mysql_affected_rows()>0) OR ($nohp==1))
					{	
					$cut_telo['hp']+=$add_hp ;  	
					// ����� ������
					if ($cut_telo[battle_t]==1) {  	$boec_t1[$cut_telo[id]][hp]=$cut_telo[hp] ;  }
					elseif ($cut_telo[battle_t]==2) {  $boec_t2[$cut_telo[id]][hp]=$cut_telo[hp];  	}
					elseif ($cut_telo[battle_t]==3) {  $boec_t3[$cut_telo[id]][hp]=$cut_telo[hp];  	}					
					//�����
					//addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($cut_telo,$cut_telo[battle_t]).', ������� ����� +<b>'.((($cut_telo[hidden]>0)and($cut_telo[hiddenlog]==''))?"??</B> [??/??]":"{$cure_value}</B> [{$cut_telo[hp]}/{$cut_telo[maxhp]}]").' <BR>');								

//					if ($cut_telo[hidden]>0 and $cut_telo[hiddenlog]=='') 	{ $cut_telo[sex]=1;	}
//					elseif ($cut_telo[hidden]>0 and $cut_telo[hiddenlog]!='') {  $fcut_telo=load_perevopl($cut_telo); $cut_telo[sex]=$fcut_telo[sex]; }				      
				      
				        addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($cut_telo).":0:::, ������� ����� +<b><font color=red>".((($cut_telo[hidden]>0)and($cut_telo[hiddenlog]==''))?"??</font></b> [??/??]":"{$cure_value}</font></b> [{$cut_telo[hp]}/{$cut_telo[maxhp]}]")."\n");
					}
					
				 }	
				}
				

				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
				
			   }
			   else
			   {
				err('������ ������ ������!');    
			   }
			}
		}	
		
	   }	
	
	


	} 
	



?>
