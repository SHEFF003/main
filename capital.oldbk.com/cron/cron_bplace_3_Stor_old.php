#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php";

if( !lockCreate("cron_bplace_job") ) {
    exit("Script already running.");
}
$VER='6.0';
//����� ���� ��� - ������ �� ����������! �� ����� ��� 3-� ���������� ���

function make_align_coff($lvl)
{
global $CITY_NAME;

if ($lvl!=21)
{

 if ($CITY_NAME=='capitalcity')
 	{
	 $get_all_align=mysql_query("select count(id) as kol,align from oldbk.users where level={$lvl} and id_city=0 and block=0 and bot=0 and ldate>=(".time()."-13*24*60*60) and align>0 group by align");
	 }
	 else if ($CITY_NAME=='avaloncity')
	 {
	 $get_all_align=mysql_query("select count(id) as kol,align from avalon.users where level={$lvl} and id_city=1 and block=0 and bot=0 and ldate>=(".time()."-13*24*60*60) and align>0 group by align");
	 }
	 else if ($CITY_NAME=='angelscity')
	 {
	 $get_all_align=mysql_query("select count(id) as kol,align from angels.users where level={$lvl} and id_city=2 and block=0 and bot=0 and ldate>=(".time()."-13*24*60*60) and align>0 group by align");
	 }	 
 
 	$count=array();
 
     while($al = mysql_fetch_array($get_all_align)) 
     	{
	     	$align=(int)($al[align]);
	     	if ($align==1) {$align=6;} //���� = ����
	     	if (($align==2) OR ($align==6) OR ($align==3))
	     	{
	     	$count[$align]+=$al[kol];
	     	}
     	}
 
 $coff=min($count); // ����� �����������

if (($coff>30) and ($coff<51))  {$coff=round($coff*0.8); }
elseif (($coff>50) and ($coff<71))  {$coff=round($coff*0.75); }
elseif (($coff>70) and ($coff<101))  {$coff=round($coff*0.7); }
elseif (($coff>100) and ($coff<151))  {$coff=round($coff*0.6); }
elseif ($coff>150)  {$coff=round($coff*0.45); }

 if ($coff<30) {$coff=30;} // ���� ������ 30 ����� 30;
}
else
{
$coff=1000;
}

//����� �� ��� ���������� � �����������
mysql_query("UPDATE `place_battle` SET `val`='{$coff}' WHERE `var`='maxusers';");

return $coff;
}


function do_new_zay()
{
 //  mysql_query("INSERT INTO `place_zay` SET `coment`='���� VS T���',`type`=61,`team1`='',`t1data`='',`team2`='',`t2data`='',`start`='".(time()+777600)."',`timeout`=5,`t1min`=7,`t1max`=21,`t2min`=7,`t2max`=21,`level`=6,`podan`='19:00',`t1c`=30,`t2c`=30,`blood`=1,`active`=0;");
}


function winNETRAL()
{
//������� 3
global $zayava;
     {
    //������� ������ ������
    mysql_query("DELETE FROM `place_zay` WHERE id='".$zayava[id]."' ; ");
    mysql_query("UPDATE `place_battle` SET `val`=2 WHERE `var`='master' ; "); //2 ��������
    mysql_query("UPDATE `place_battle` SET `val`=3 WHERE `var`='winers' ; ");	// �������� 3-� �������
    mysql_query("UPDATE `place_battle` SET `val`=`val`+1 WHERE `var`='netral_count' ; ");
     // ������� ������ � �����
   mysql_query("UPDATE `users` SET `bpalign`=0, `bpstor`=0, `bpzay`=0 WHERE `bpzay`>0 ; ");
    do_new_zay();
     }
}

function winT()
{
//������� 2
global $zayava;
     {
    //������� ������ ������
    mysql_query("DELETE FROM `place_zay` WHERE id='".$zayava[id]."' ; ");
    // ���� ����� - ��� ������ ����
    // ���������� ���� � ���� � ��������� ����
    mysql_query("UPDATE `place_battle` SET `val`=3 WHERE `var`='master' ; ");
    mysql_query("UPDATE `place_battle` SET `val`=2 WHERE `var`='winers' ; ");	
    mysql_query("UPDATE `place_battle` SET `val`=`val`+1 WHERE `var`='darck_count' ; ");
     // ������� ������ � �����
   mysql_query("UPDATE `users` SET `bpalign`=0, `bpstor`=0, `bpzay`=0 WHERE `bpzay`>0 ; ");
    //���������
   // addch2all('<font color=red>��������!</font> ��� ����-����, �� ����� �������� �� ������� "���� �� �������"!');
    // ������� ��������� ������ �� 
    do_new_zay();
     }
}

function winS()
{
//������� 1
global $zayava;
    {
     //������� ������ ������
     mysql_query("DELETE FROM `place_zay` WHERE id='".$zayava[id]."' ; ");
     // ���� ���� - ��� ������ �����
    // ���������� ���� � ���� � ��������� ����    
    mysql_query("UPDATE `place_battle` SET `val`=6 WHERE `var`='master' ; ");
    mysql_query("UPDATE `place_battle` SET `val`=1 WHERE `var`='winers' ; ");	    
    mysql_query("UPDATE `place_battle` SET `val`=`val`+1 WHERE `var`='light_count' ; ");
    //���������
   // addch2all('<font color=red>��������!</font> ��� ����-����, �� ����� �������� �� ������� "���� �� �������"!');
     // ������� ������ � �����
    mysql_query("UPDATE `users` SET `bpalign`=0, `bpstor`=0, `bpzay`=0 WHERE `bpzay`>0 ; ");
   // ������� ��������� ������ ��������
    do_new_zay();

    }
}

function winN()
{
global $zayava;
    {
    //������� ������ ������
     mysql_query("DELETE FROM `place_zay` WHERE id='".$zayava[id]."' ; ");
    // � ��� ��� ������ c ����� ������
    // ���������� ���� � �����
    mysql_query("UPDATE `place_battle` SET `val`=0 WHERE `var`='master' ; ");
    mysql_query("UPDATE `place_battle` SET `val`=0 WHERE `var`='winers' ; ");	
    //���������
   // addch2all('<font color=red>��������!</font> ��� ����-����, �� ����� �������� �� ������� "����� �� ������ :("!');
    // ������� ��������� ������ ��������
    do_new_zay();
    }
}

function nickbp($uid)
{
$rout=array();
$rout[id]=0;


$usrdata=mysql_fetch_array(mysql_query("SELECT `id`, `login`, `level`, `klan` , `room`, `align`, hp  FROM `users` WHERE `hp` > 0 and `room`=60 and `id` = '".$uid."' ;"));

if (($usrdata[id] >0) and ($usrdata[ldate] >= (time()-60) ))
	{

	$rout[id]=$usrdata[id];
	$rout[login]=$usrdata[login];

	$mm = "<img src=\"http://i.oldbk.com/i/align_".($usrdata['align']>0 ? $usrdata['align']:"0").".gif\">";
	if ($usrdata[klan]!="")
	{

	$mm.= '<img title="'.$usrdata['klan'].'" src="http://i.oldbk.com/i/klan/'.$usrdata['klan'].'.gif">'; 
	}
	$mm.= "<B>{$usrdata['login']}</B> [{$usrdata['level']}]<a href=inf.php?{$usrdata['id']} target=_blank><IMG SRC=http://i.oldbk.com/i/inf.gif WIDTH=12 HEIGHT=11 ALT=\"���. � {$usrdata['login']}\"></a>";
	 
	$rout[logintext]=$mm;
	}
return $rout;
}


//$zayava=mysql_fetch_array(mysql_query("SELECT * FROM `place_zay` WHERE  `level`=6 and `active`=1 LIMIT 1;"));
$zayava=mysql_fetch_array(mysql_query("select * from place_zay ORDER by `start` LIMIT 1;")); // �������� ����� ��������� �����

	$t=time();
	echo $t;
	echo "<br>";
	echo $zayava['start'];
	echo "<br>";

if($zayava[id] >0 ) // ���� �� ���� ������
{

if ($zayava[active]==1) //������ ��������
 {
	if ( ($zayava[id]>0) and ($zayava['start'] <= $t) )
	   {
	   // ���� �����
	   //������������ ����� ��� ������
	   mysql_query("UPDATE `place_zay` SET `active`=0 WHERE id='".$zayava[id]."' ; ");
	 
   ///
    if (($zayava[team1]=='')and($zayava[team2]=='') and ($zayava[team3]==''))
    {
    winN();
    }
    else
    if (($zayava[team1]=='')and($zayava[team2]!='') and ($zayava[team3]==''))
	{
	winT();
	}
    else
    if (($zayava[team1]!='')and($zayava[team2]=='') and ($zayava[team3]==''))
	{
	winS();
	}
    else
    if (($zayava[team3]!='')and($zayava[team2]=='') and ($zayava[team1]==''))
	{
	winNETRAL();
	}	
    else
    {
    //��� ����
    //echo "���� ���� ������� ���!";
     ////////////////////////
    // ������� ������ ������     
      mysql_query("DELETE FROM `place_zay` WHERE id='".$zayava[id]."' ; ");
  //// ����� ���������� ���  
     		{
				$cc=mysql_fetch_array(mysql_query("select * from place_battle where var='maxusers'"));

			    	$time = time(); 
				//������� ��� � ������� ������
				mysql_query("INSERT INTO `battle`
						(
							`id`,`nomagic`,`price`,`fond`,`coment`,`teams`,`timeout`,`type`,`status`,`status_flag`,`t1`,`t2`,`t3`,`to1`,`to2`,`to3`,`blood`,`CHAOS`
						)
						VALUES
						(
							NULL,'0','0','0','{$zayava[coment]}','','{$zayava['timeout']}','{$zayava['type']}','1','6','','','','".$time."','".$time."','".$time."','".$zayava['blood']."','0'
						)");
						
				$id = mysql_insert_id();
				//
				
				
				//
				mysql_query("INSERT INTO `place_logs` (`startdate`, `findate`, `win`, `battle`, `active`, `usrc` ) VALUES ('".date("Y.m.d H.i")."', '".date("Y.m.d H.i")."', '0', '".$id."', 1, '".$cc['val']."');");
				$bplogid = mysql_insert_id();
				
				mysql_query("UPDATE place_battle set val={$id} where var='battle'; ");
				mysql_query("UPDATE place_battle set val='".$time."' where var='starttime'; ");
				
				
				//1. ���������� ��� ��� ��� ����� ������ ��� � ������� 
				mysql_query("update users  set `battle`='{$id}', `battle_t`=`bpstor`, bpzay=0 where bpzay>0 AND room=60 AND ldate >= (".(time()-60).") AND bpstor>0 AND hidden=0 AND battle=0 AND zayavka=0 AND hp>1 AND sila>0 AND lovk>0 AND inta>0;");
				echo "SQL1:".mysql_error();
				mysql_query("COMMIT;");
				//2. ������� ��� ������� ��� ��� �����
				$GET_ALL=mysql_query("SELECT * from users where battle='{$id}'");
				$t1_hist=''; $t1_id=''; $new_t1='';
				$t2_hist=''; $t2_id='';	 $new_t2='';
				$t3_hist=''; $t3_id='';	 $new_t3='';				
				while ($rowa = mysql_fetch_array($GET_ALL))
				{
				//�����������
				if ($rowa[battle_t]==1)
				 {
				 $t1_hist.=nick_align_klan($rowa).", ";
				 $new_t1.=BNewHist($rowa);
				 $t1_id.=$rowa[id].";";
				 }
				 elseif ($rowa[battle_t]==2)
				 {
				 $t2_hist.=nick_align_klan($rowa).", ";
				 $new_t2.=BNewHist($rowa);				 
				 $t2_id.=$rowa[id].";";
				 }
				 elseif ($rowa[battle_t]==3)
				 {
				 $t3_hist.=nick_align_klan($rowa).", ";
				 $new_t3.=BNewHist($rowa);				 
				 $t3_id.=$rowa[id].";";
				 }				 
				 
				addchp ('<font color=red>��������!</font> ��� ��� �������! <BR>\'; top.frames[\'main\'].location=\'fbattle.php\'; var z = \'   ','{[]}'.$rowa[login].'{[]}');
				}
				
				if ($t1_hist=='') { $t1_hist ="<i>���� �� �������</i>  "; $erst1=1; }
				if ($t2_hist=='') { $t2_hist ="<i>���� �� �������</i>  "; $erst2=1; }
				if ($t3_hist=='') { $t3_hist ="<i>�������� �� �������</i>  "; $erst3=1; }				
				/////////////////////////////////////////////////////////////////////////
			        //make logs
				$t1_hist=substr($t1_hist, 0, -2);
				$t2_hist=substr($t2_hist, 0, -2);
				$t3_hist=substr($t3_hist, 0, -2);				
				 
				 $t1_id=substr($t1_id, 0, -1);
				 $t2_id=substr($t2_id, 0, -1);
				 $t3_id=substr($t3_id, 0, -1);				 

				// ������� ���
				$rr1 = "<b>".$t1_hist."</b>"; 
				$rr2 = "<b>".$t2_hist."</b>";
				$rr3 = "<b>".$t3_hist."</b>";				
				$rr=$rr1." � ".$rr2." � ".$rr3;
				
				// ��������� �������� �� ����
				if (($erst1==1)and($erst2==1)and($erst3==1))
				{
				// ��� ������� �� ������ ���� � ���� �����
				winN();
				addch ("<a href=logs.php?log=".$id." target=_blank>��������</a> <B>".$zayava[coment]."</B> �������.   ",60);
				addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ����, ���� � �������� ������� ����� ���� �����. \n");
				addlog($id,'<span class=date>'.date("H:i").'</span> '.'��� ������� �� ������� �� ���\n');
				addlog($id,'<span class=date>'.date("H:i").'</span> '.'��� ��������. �����.\n');
				mysql_query("UPDATE `battle` SET `status`=1,`win`='0', `t1hist`='".$new_t1."', `t2hist`='".$new_t2."' , `t3hist`='".$new_t3."'  WHERE `id`='".$id."' ; ");
				mysql_query("UPDATE `place_logs` SET `active`=0 WHERE `id`='".$bplogid."'");
				addch ("<a href=logs.php?log=".$id." target=_blank>��� ��������.</a> <B>".$zayava[coment]."</B> �����.",60);
				mysql_query("UPDATE users SET battle=0, battle_t=0 where battle='{$id}'");
				}
				elseif ( ($erst1==1) and ($erst3==1) )
				{
				// ������ ���� - ���� � �������� �� � ������
				winT();
				addch ("<a href=logs.php?log=".$id." target=_blank>��������</a> <B>".$zayava[coment]."</B> �������.   ",60);
				addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. \n");
				addlog($id,'<span class=date>'.date("H:i").'</span> '.'��� ��������. ������ �� �����!\n');
				mysql_query("UPDATE `battle` SET `status`=1,`win`='2', `t1hist`='".$new_t1."', `t2hist`='".$new_t2."' WHERE `id`='".$id."' ; ");
				mysql_query("UPDATE `place_logs` SET `active`=0, `win`='2' WHERE `id`='".$bplogid."'");
				addch ("<a href=logs.php?log=".$id." target=_blank>��� ��������.</a> <B>".$zayava[coment]."</B> ������ �� �����!",60);		
				mysql_query("UPDATE users SET battle=0, battle_t=0 where battle='{$id}'");
				}
				elseif (($erst2==1)  and ($erst3==1) )
				{
				// ������ ����� = ���� � �������� �� ������
				winS();
				addch ("<a href=logs.php?log=".$id." target=_blank>��������</a> <B>".$zayava[coment]."</B> �������.   ",60);
				addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. \n");
				addlog($id,'<span class=date>'.date("H:i").'</span> '.'��� ��������. ������ �� ������!\n');
				mysql_query("UPDATE `battle` SET `status`=1,`win`='1', `t1hist`='".$new_t1."', `t2hist`='".$new_t2."'  , `t3hist`='".$new_t3."'  WHERE `id`='".$id."' ; ");				
				mysql_query("UPDATE `place_logs` SET `active`=0, `win`='1' WHERE `id`='".$bplogid."'");
				addch ("<a href=logs.php?log=".$id." target=_blank>��� ��������.</a> <B>".$zayava[coment]."</B> ������ �� ������!",60);
				mysql_query("UPDATE users SET battle=0, battle_t=0 where battle='{$id}'");
				}
				elseif (($erst1==1)  and ($erst3==1) )
				{
				// ������ ��������� = ���� � ���� �� ������
				winNETRAL();
				addch ("<a href=logs.php?log=".$id." target=_blank>��������</a> <B>".$zayava[coment]."</B> �������.   ",60);
				addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. \n");
				addlog($id,'<span class=date>'.date("H:i").'</span> '.'��� ��������. ������ �� ����������!\n');
				mysql_query("UPDATE `battle` SET `status`=1,`win`='1', `t1hist`='".$new_t1."', `t2hist`='".$new_t2."'  , `t3hist`='".$new_t3."'  WHERE `id`='".$id."' ; ");				
				mysql_query("UPDATE `place_logs` SET `active`=0, `win`='4' WHERE `id`='".$bplogid."'");
				addch ("<a href=logs.php?log=".$id." target=_blank>��� ��������.</a> <B>".$zayava[coment]."</B> ������ �� ����������!",60);
				mysql_query("UPDATE users SET battle=0, battle_t=0 where battle='{$id}'");
				}				
				else
				{
				// ���� ��� �����
				mysql_query("UPDATE `battle` SET `status`=0,`win`='3', `t1`='{$t1_id}', `t2`='{$t2_id}', `t3`='{$t3_id}' ,`t1hist`='".$new_t1."', `t2hist`='".$new_t2."', `t3hist`='".$new_t3."' WHERE `id`='".$id."' ; ");				
				addch ("<a href=logs.php?log=".$id." target=_blank>��������</a> <B>".$zayava[coment]."</B> �������.   ",60);
				//addlog($id,"���� ���������� <span class=date>".date("Y.m.d H.i")."</span>, ����� ".$rr." ������� ����� ���� �����. <BR>");
				addlog($id,"!:S:".time().":".$new_t1.":".$new_t2.":".$new_t3."\n");
				
			        // ������� ��������� ������ �� �������� - ���������� ����� ���!! -��������� �� ����� �� 7 ����� 
				do_new_zay();
				// ������ ����� ������ ������� �� ������ � ���
				mysql_query("UPDATE users SET `bpzay`=0 WHERE `bpzay`>0 ");
				}
		}
     
     
     
     /// � ����� ��� 
    // �������� ���� bpstor - ����
    
    }

   
   
   }
   else if (($zayava[sys_mess_10m]==0) and (($zayava['start']-600) <= $t) )
   {
 	mysql_query("UPDATE `place_zay` SET `sys_mess_10m`=1 WHERE id='".$zayava[id]."' ; ");
	$TEXT='<font color=red>��������!</font> �� "����� �����" ����� 10 ����� ��������� ��� "'.$zayava[coment].'", ������ ����� ������ �� ���! ����� �� ������ �� ������ ���������� � �������!';
	      addch2all($TEXT,$bot_city);

   }

} //�������� ������
else
{
echo " ������ �� ��������";
//��������� �� ������ �� ������������
   if ( ($zayava[id]>0) and (($zayava['start']-3600) <= $t) ) // �� ��� ���������
   {
   
   mysql_query("UPDATE `place_zay` SET `active`=1 WHERE id='".$zayava[id]."' ; ");
   mysql_query("UPDATE `place_battle` SET `val`='{$zayava['t1max']}' WHERE `var`='max_level';");
   mysql_query("UPDATE `place_battle` SET `val`='{$zayava['t1min']}' WHERE `var`='min_level';");

   mysql_query("UPDATE `place_battle` SET `val`='{$zayava['type']}' WHERE `var`='type';");  
   mysql_query("UPDATE `place_battle` SET `val`=0 WHERE `var`='master';"); // ��������� ������� � �����������
   echo "������������\n";
   
   $maxusers=make_align_coff($zayava[t1max]);
   
   // ���������� �������� � ��� ��� �������� ����� � ������
   if ($maxusers==1000)
   {
      mysql_query("UPDATE `place_battle` SET `val`='".($zayava['start']+21600)."' WHERE `var`='close';");   //close 6 �����
      $TEXT='<font color=red>��������!</font> �� "����� �����" ����� 1 ��� ��������� ��� "'.$zayava[coment].'", ������ ����� ������ �� ���! ';
   }
   else
   {
   mysql_query("UPDATE `place_battle` SET `val`='".($zayava['start']+36000)."' WHERE `var`='close';");   //close 10 �����
   $TEXT='<font color=red>��������!</font> �� "����� �����" ����� 1 ��� ��������� ��� "'.$zayava[coment].'", ������ ����� ������ �� ���! ������������ ���������� ���������� ��� ������ ����������:'.$maxusers;
   }
    addch2all($TEXT,$bot_city);
   
   
   
   }
   else
   {
   echo "��� �� ����� �����������";
   }


}


} // ���� �� ������

lockDestroy("cron_bplace_job");

?>