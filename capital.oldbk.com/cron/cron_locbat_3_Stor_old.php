#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php";
if( !lockCreate("cron_locbat_job") ) {
    exit("Script already running.");
}

	//��� 3-� ���������� ��� - ������ + ������� V6
	
function get_all_in_t($t,$b)
{
$cc=mysql_fetch_array(mysql_query("select count(*) from users  WHERE  battle={$b} and battle_t={$t};"));
return $cc[0];
}

function get_maxusers()
{
$cc=mysql_fetch_array(mysql_query("select * from place_battle where var='maxusers'"));
return $cc['val'];
}	

$battle = mysql_fetch_array(mysql_query("SELECT val from place_battle WHERE var = 'battle' LIMIT 1"));
$starttime = mysql_fetch_array(mysql_query("SELECT val from place_battle WHERE var = 'starttime' LIMIT 1"));
$battle_on_blow = mysql_fetch_array(mysql_query("SELECT val from place_battle WHERE var = 'battle_on_blow' LIMIT 1"));
$current= mysql_fetch_array(mysql_query("SELECT * from battle WHERE id = '".$battle[0]."' LIMIT 1"));


echo '���: '.$battle[0] .'<br>';
echo '����� ������: '.$starttime[0] .'<br>';
echo '����� (���) ��� ����������� ������: '.$battle_on_blow[0] .'<br>';

echo '<br>';
$lid1_change=false;
$lid2_change=false;
$lid3_change=false;

  //���� ��� battle ���� ��������� ������� ����� � starttime
if($current[win]==3) 
	{
  if (((time()-$starttime[0]) >= ($battle_on_blow[0]*60)) and ($starttime[0] > 0) and ($battle_on_blow[0] > 0) )
    {
    	echo '������� ������� <br>';

	//��������� ���� �� ����� ��� �1
		$lid1 = mysql_fetch_array(mysql_query("SELECT val from place_battle WHERE var = 'leader1' LIMIT 1"));
		if ($lid1[0]>0)
		{
		// ���� �����
		// ��������� ������ �� ��
		// ���� ��� ������� ������� ������� ���
		$onl=mysql_fetch_array(mysql_query("SELECT * from users WHERE id = '{$lid1[0]}' LIMIT 1"));
	    	if (((time()-$onl['ldate']) >= (2*60)) OR ($onl['hp'] <=0 ))
	    	{
			// ���� ������ 5 ����� ������� ��� �� �������
		        mysql_query("UPDATE place_battle SET val = '0' WHERE var='leader1'");
	       	       if (($onl[hidden]>0) and ($onl[hiddenlog]==''))
	       	       	{
	       	       	$onl[sex]=1;
	       	       	} else 
	       	       	{
	       	       	 $fuser=load_perevopl($onl); $onl[sex]=$fuser[sex]; 
	       	       	}
	       	       
//	       	       addlog($battle[0],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($onl,$onl[battle_t]).' �������'.$sexi.' ��������� <BR>');
       		       addlog($battle[0],"!:X:".time().':'.nick_new_in_battle($onl).':'.($onl[sex]+110)."\n");
	       	       
	       	       addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ������ ������ �1 ','{[]}Bred{[]}');
		       addch ("<b>".nick_in_battle($onl,$onl[battle_t])."</b> �������".$sexi." ��������� ",60);
		}
	        $lid1_change=true;
		}
		elseif(!$lid1[0] || $lid1_change==true)
		{
		// ��� ������ ��� �1
			$leader1=mysql_fetch_array(mysql_query("select u.*, be.damage from users u LEFT JOIN battle_dam_exp be ON u.battle=be.battle and  u.id=be.owner  where be.battle='{$battle[0]}' and hp>0 and battle_t=1 and  u.ldate >= ".(time()-60)."   ORDER BY damage DESC LIMIT 1"));
			if ($leader1[0] > 0)
		  	{
		        mysql_query("UPDATE place_battle SET val = '".$leader1[0]."' WHERE var='leader1'");
//  	       	       addlog($battle[0],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($leader1,$leader1[battle_t]).' ����� ����� ����� <BR>');
       		       addlog($battle[0],"!:X:".time().':'.nick_new_in_battle($leader1).":121\n");

		       addch ("<b>".nick_in_battle($leader1,$leader1[battle_t])."</b> ����� ����� ����� ",60);
        	       echo '����� k1:' . $leader1[login] . ' �����:'.$leader1[damage] . '<br>' ;
       	       	       addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ����� ����� �1 ','{[]}Bred{[]}');
        	 	}
    		}

    		//��������� ���� �� ����� ��� �2
		$lid2 = mysql_fetch_array(mysql_query("SELECT val from place_battle WHERE var = 'leader2' LIMIT 1"));
		if ($lid2[0]>0)
		{
		$onl=mysql_fetch_array(mysql_query("SELECT * from users WHERE id = '{$lid2[0]}' LIMIT 1"));
		 if (((time()-$onl['ldate']) >= (2*60)) OR ($onl['hp'] <=0 ))
    			{
			// ���� ������ 5 ����� ������� ��� �� �������
		        mysql_query("UPDATE place_battle SET val = '0' WHERE var='leader2'");
	       	       if (($onl[hidden]>0) and ($onl[hiddenlog]==''))
	       	       	{
	       	       	$onl[sex]=1;
	       	       	} else 
	       	       	{
	       	       	 $fuser=load_perevopl($onl); $onl[sex]=$fuser[sex]; 
	       	       	}
	       	      // addlog($battle[0],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($onl,$onl[battle_t]).' �������'.$sexi.' ��������� <BR>');
     		       addlog($battle[0],"!:X:".time().':'.nick_new_in_battle($onl).':'.($onl[sex]+110)."\n");
	       	      
		       addch ("<b>".nick_in_battle($onl,$onl[battle_t])."</b> �������".$sexi." ��������� ",60);
	       	       addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ������ ������ �2 ','{[]}Bred{[]}');
			}
	         $lid2_change=true;
		}
		elseif(!$lid2[0] || $lid2_change==true)
		{
		//����
    		// ��� ������ ��� �2
		$leader2=mysql_fetch_array(mysql_query("select u.*, be.damage from users u LEFT JOIN battle_dam_exp be ON u.battle=be.battle and  u.id=be.owner  where be.battle='{$battle[0]}' and hp>0 and battle_t=2 and  u.ldate >= ".(time()-60)."   ORDER BY damage DESC LIMIT 1"));		
		if ($leader2[0] > 0)
		  {
		       mysql_query("UPDATE place_battle SET val = '".$leader2[0]."' WHERE var='leader2'");
		     //  addlog($battle[0],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($leader2,$leader2[battle_t]).' ����� ����� ���� <BR>');
       		       addlog($battle[0],"!:X:".time().':'.nick_new_in_battle($leader2).":122\n");		     
		       addch ("<b>".nick_in_battle($leader2,$leader2[battle_t])."</b> ����� ����� ���� ",60);
	       		echo '<br>����� k2:' . $leader2[login] . ' �����:'.$leader2[damage] . '<br>' ;
       	       		addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ����� ����� �2 ','{[]}Bred{[]}');
	       	  }
	       }

  		//��������� ���� �� ����� ��� �3
		$lid3 = mysql_fetch_array(mysql_query("SELECT val from place_battle WHERE var = 'leader3' LIMIT 1"));
		if ($lid3[0]>0)
		{
		$onl=mysql_fetch_array(mysql_query("SELECT * from users WHERE id = '{$lid3[0]}' LIMIT 1"));
		 if (((time()-$onl['ldate']) >= (2*60)) OR ($onl['hp'] <=0 ))
    			{
			// ���� ������ 5 ����� ������� ��� �� �������
		        mysql_query("UPDATE place_battle SET val = '0' WHERE var='leader3'");
	       	       if (($onl[hidden]>0) and ($onl[hiddenlog]==''))
	       	       	{
	       	       	$onl[sex]=1;
	       	       	} else 
	       	       	{
	       	       	 $fuser=load_perevopl($onl); $onl[sex]=$fuser[sex]; 
	       	       	}
	       	      // addlog($battle[0],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($onl,$onl[battle_t]).' �������'.$sexi.' ��������� <BR>');
    		       addlog($battle[0],"!:X:".time().':'.nick_new_in_battle($onl).':'.($onl[sex]+110)."\n");
		       addch ("<b>".nick_in_battle($onl,$onl[battle_t])."</b> �������".$sexi." ��������� ",60);
	       	       addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ������ ������ �3 ','{[]}Bred{[]}');
			}
	         $lid3_change=true;
		}
		elseif(!$lid3[0] || $lid3_change==true)
		{
		//����
    		// ��� ������ ��� �3
		$leader3=mysql_fetch_array(mysql_query("select u.*, be.damage from users u LEFT JOIN battle_dam_exp be ON u.battle=be.battle and  u.id=be.owner  where be.battle='{$battle[0]}' and hp>0 and battle_t=3 and  u.ldate >= ".(time()-60)."   ORDER BY damage DESC LIMIT 1"));		
		if ($leader3[0] > 0)
		  {
		       mysql_query("UPDATE place_battle SET val = '".$leader3[0]."' WHERE var='leader3'");
		      // addlog($battle[0],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($leader3,$leader3[battle_t]).' ����� ����� ��������� <BR>');
       		       addlog($battle[0],"!:X:".time().':'.nick_new_in_battle($leader3).":123\n");		     
		       addch ("<b>".nick_in_battle($leader3,$leader3[battle_t])."</b> ����� ����� ��������� ",60);
	       		echo '<br>����� k3:' . $leader3[login] . ' �����:'.$leader3[damage] . '<br>' ;
       	       		addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ����� ����� �3 ','{[]}Bred{[]}');
	       	  }
	       }
		
		



    }
	else
	{
		echo '�� ������� ������� =) - ������� �� ������� <br>';
	}
///////////
// ��� ��� ��� ���� 
//////////////////////////////////////
// ����� ���� ��������� ������� - ���� ���� - ��� ������� ������� ������� ���� ���
$maxp=30; // ������������ �����
// ���������� ������� �� ������� ���� ����
function get_life_in_t($t,$b)
{
$cc=mysql_fetch_array(mysql_query("select count(*) from users  WHERE  hp >0 and battle={$b} and battle_t={$t};"));
return $cc[0];
}


  $batl=mysql_fetch_array(mysql_query("SELECT p.*, b.win, b.status FROM `place_battle` as p  LEFT JOIN battle as b  ON val=id WHERE   var='battle'  LIMIT 1;"));
  if ( ($batl[win]==3) and ($batl[status]==0)) // ����������� ���� - ��� ����� �� ������ ����� ����� ��� ��������� ��� �������������
  {
  echo "//��� ����  <br>";
	//��� ����  
	// 1. ������ ������� ����� � ������� 1
	$t1life=get_life_in_t('1',$batl[val]);
	$t2life=get_life_in_t('2',$batl[val]);
	$t3life=get_life_in_t('3',$batl[val]);	


	$MAX_USERS_LIM=get_maxusers();//����������� ��������� � ���.
	
	$ALL_IN_T1=get_all_in_t(1,$batl[val]);
	$ALL_IN_T2=get_all_in_t(2,$batl[val]);
	$ALL_IN_T3=get_all_in_t(3,$batl[val]);		

	
	
	 if (($t1life < $maxp ) and ($t1life>0))
	 {
	echo "	  // ����� ������� � ��� t1 <br>";
	  // ����� ������� � ���
	 $turn=mysql_fetch_array(mysql_query("SELECT * FROM `place_turn` WHERE  t='1' ORDER BY poz LIMIT 1;"));
	 if ($turn[owner] >0 )
	  {
	    // ���� ��������
	    // �� �������
 				$ttt = 1; //���� �� ������� �������
				$time = time();
	 $kand=mysql_fetch_array(mysql_query("select * from users where id='{$turn[owner]}';"));
	 
	if (($kand[battle]==0) and ($kand[hp] > 2) and  ($ALL_IN_T1<$MAX_USERS_LIM) ) 		
	  {
		if(mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', to3='.$time.', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$turn[owner].'\') , `t'.$ttt.'hist`=CONCAT(`t'.$ttt.'hist`,\''.BNewHist($kand).'\')   WHERE  `win`=3 and `status`=0 and `id` = '.$batl[val].' ;'))
		{				

				mysql_query("UPDATE users SET `battle` ={$batl[val]}, `battle_t`=1 ,  `bpalign`=1, `bpstor`=0, `bpzay`=0 WHERE `id`= ".$turn[owner]);
				mysql_query("INSERT `battle_vars` (battle,owner,update_time,type)  VALUES ('{$batl[val]}','{$turn[owner]}','{$time}','1') ON DUPLICATE KEY UPDATE `update_time` = '{$time}' ;");
				$kand[bpalign]=1;
				$kand[battle_t]=1;
				addch ("<b>".nick_in_battle($kand,$kand[battle_t])."</b> �������� � <a href=logs.php?log=".$batl[val]." target=_blank>�������� ��</a>.  ",60);
				
				//addlog($batl[val],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($kand,$kand[battle_t]).' �������� � ��������!<BR>');				
				$ac=($kand[sex]*100)+mt_rand(1,2);
//				addlog($batl[val],"!:V:".time().":".nick_new_in_battle($kand).":".$ac."\n");				
				addlog($batl[val],"!:W:".time().":".BNewHist($kand).":".$kand[battle_t].":".$ac."\n");					
		
				addchp ('<font color=red>��������!</font> ��� ��� �������! <BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$kand[login].'{[]}');	
		       	       	addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ������� ������ �� ������� �1 ','{[]}Bred{[]}');		
       	       		    	mysql_query("DELETE FROM `place_turn` WHERE  t='1' and owner='{$turn[owner]}'; ");
       	       	}
	 }
	 else	
	        {
	        //������� �� ������� , �������� ���� �����
	         mysql_query("DELETE FROM `place_turn` WHERE  t='1' and owner='{$turn[owner]}'; ");
		 mysql_query("UPDATE users set bpzay='0' where  `id`= '{$turn[owner]}' ");
	        }
    	}
	  
	 }
	 ///////////////////����  2////////////
	 if ( ($t2life < $maxp ) and ($t2life>0))
	 {
	  // ����� ������� � ���
	 	$turn=mysql_fetch_array(mysql_query("SELECT * FROM `place_turn` WHERE  t='2' ORDER BY poz LIMIT 1;"));
		 if ($turn[owner] > 0 )
		    {
				$ttt = 2; //���� �� ������� �������
				$time = time();
				$kand=mysql_fetch_array(mysql_query("select * from users where id='{$turn[owner]}';"));
			
			if (($kand[battle]==0) and ($kand[hp] > 2) and  ($ALL_IN_T2<$MAX_USERS_LIM) ) 	
			      {				
					if(mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', to3='.$time.', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$turn[owner].'\') , `t'.$ttt.'hist`=CONCAT(`t'.$ttt.'hist`,\''.BNewHist($kand).'\')   WHERE  `win`=3 and `status`=0 and `id` = '.$batl[val].' ;'))
					{
				mysql_query("UPDATE users SET `battle` ={$batl[val]}, `battle_t`=2 ,   `bpalign`=2, `bpstor`=0, `bpzay`=0   WHERE `id`= ".$turn[owner]);
				mysql_query("INSERT `battle_vars` (battle,owner,update_time,type)  VALUES ('{$batl[val]}','{$turn[owner]}','{$time}','1') ON DUPLICATE KEY UPDATE `update_time` = '{$time}' ;");
				$kand[bpalign]=2;
				$kand[battle_t]=2;
				addch ("<b>".nick_in_battle($kand,$kand[battle_t])."</b> �������� � <a href=logs.php?log=".$batl[val]." target=_blank>�������� ��</a>.  ",60);
				//addlog($batl[val],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($kand,$kand[battle_t]).' �������� � ��������!<BR>');						
				$ac=($kand[sex]*100)+mt_rand(1,2);
//				addlog($batl[val],"!:V:".time().":".nick_new_in_battle($kand).":".$ac."\n");								
				addlog($batl[val],"!:W:".time().":".BNewHist($kand).":".$kand[battle_t].":".$ac."\n");					
				addchp ('<font color=red>��������!</font> ��� ��� �������! <BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$kand[login].'{[]}');	
       	       			addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ������� ������ �� ������� �2 ','{[]}Bred{[]}');				
		      		    //������� �� �������
				mysql_query("DELETE FROM `place_turn` WHERE  t='2' and owner='{$turn[owner]}'; ");
       	       				}
            			}
            			else
	        		{
				mysql_query("DELETE FROM `place_turn` WHERE  t='2' and owner='{$turn[owner]}'; ");
				mysql_query("UPDATE users set bpzay='0' where  `id`= '{$turn[owner]}' ");				
			        }
	    	}
	 }
	 
	 ///////////////////����  3////////////
	 if ( ($t3life < $maxp ) and ($t3life>0))
	 {
	  $turn=mysql_fetch_array(mysql_query("SELECT * FROM `place_turn` WHERE  t='3' ORDER BY poz LIMIT 1;"));
	  if ($turn[owner] > 0 )
	    {
				$ttt = 3; //���� �� ������� �������
				$time = time();
				$kand=mysql_fetch_array(mysql_query("select * from users where id='{$turn[owner]}' ;"));
				if (($kand[battle]==0) and ($kand[hp] > 2) and  ($ALL_IN_T3<$MAX_USERS_LIM) ) 	
			      {				
				if(mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', to3='.$time.', `t'.$ttt.'`=CONCAT(`t'.$ttt.'`,\';'.$turn[owner].'\') , `t'.$ttt.'hist`=CONCAT(`t'.$ttt.'hist`,\''.BNewHist($kand).'\')   WHERE  `win`=3 and `status`=0 and `id` = '.$batl[val].' ;'))
					{				
				mysql_query("UPDATE users SET `battle` ={$batl[val]}, `battle_t`=3 ,  `bpalign`=3, `bpstor`=0, `bpzay`=0  WHERE `id`= ".$turn[owner]);
				mysql_query("INSERT `battle_vars` (battle,owner,update_time,type)  VALUES ('{$batl[val]}','{$turn[owner]}','{$time}','1') ON DUPLICATE KEY UPDATE `update_time` = '{$time}' ;");
				$kand[bpalign]=3;
				$kand[battle_t]=3;
				addch ("<b>".nick_in_battle($kand,$kand[battle_t])."</b> �������� � <a href=logs.php?log=".$batl[val]." target=_blank>�������� ��</a>.  ",60);
				//addlog($batl[val],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($kand,$kand[battle_t]).' �������� � ��������!<BR>');						
				$ac=($kand[sex]*100)+mt_rand(1,2);
//				addlog($batl[val],"!:V:".time().":".nick_new_in_battle($kand).":".$ac."\n");								
				addlog($batl[val],"!:W:".time().":".BNewHist($kand).":".$kand[battle_t].":".$ac."\n");													
				addchp ('<font color=red>��������!</font> ��� ��� �������! <BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$kand[login].'{[]}');	
		       	       	addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ������� ������ �� ������� �3 ','{[]}Bred{[]}');				
       	       			    //������� �� �������
			   mysql_query("DELETE FROM `place_turn` WHERE  t='3' and owner='{$turn[owner]}'; ");
       	       				}
            	 		}
            	 		else
		        	{
					mysql_query("DELETE FROM `place_turn` WHERE  t='2' and owner='{$turn[owner]}'; ");
					mysql_query("UPDATE users set bpzay='0' where  `id`= '{$turn[owner]}' ");								    
		        	}

	    }
	  
	 }	 
	 
	
  }
  



//////////////////////////////////////////////////	
	
	
}
else
{
	echo '��� ��������';
	
	if ($starttime[0]>0)
	{
	// ������
	//������ ������� ���� ��� ��������
	mysql_query("TRUNCATE `place_turn`;");
	//������ bpzay bpstor
	mysql_query("UPDATE `users` set bpzay=0, bpstor=0, bpalign=0 where bpzay!=0 or bpstor!=0 or bpalign!=0;");
	//����� ������ ������� ���
        mysql_query("UPDATE place_battle SET val = '0' WHERE var='starttime' OR  var='leader1' OR  var='leader2' OR  var='leader3'  OR var='t1_count' OR var='t2_count' OR var='t3_count'  ;");
	mysql_query("UPDATE `place_logs` SET `active`=0 WHERE `battle`='".$current[id]."'");
	echo "������ ������ ������...��<br>";
       	addchp ('<font color=red>��������!</font> start arena-turn cron v6.0 : ������ ������ ������... ','{[]}Bred{[]}');		
	}
	
	

}


lockDestroy("cron_locbat_job");


/*

*/