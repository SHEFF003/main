<?                          //http://capitalcity.oldbk.com/klan.php?war=211&a=2
	if (!($_SESSION['uid'] >0) ) { header("Location: index.php"); die(); }
	$wpers = array( 0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0,7=>1, 8=>3, 9=>9,10=>27,11=>81,12=>243,13=>729);
	$wteam=array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>3,8=>3,9=>10,10=>29,11=>83,12=>263,13=>790);
	
if($user[id]==14897)
	{
		echo '<font color=RED><b>'.$user[login].'</b></font><br>';
		echo $_COOKIE[PHPSESSID];
	}


function print_paysyst()
{
			
			
	
		/* ������ ����
			echo '<table  cellspacing=10 cellpadding=0 border=0>';
			echo "<tr align=center>";
			echo "<td><a href=\"#\" onClick=\"getformdata(4,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� \"WMR\"' ></a></td>";									
			echo "<td><a href=\"#\" onClick=\"getformdata(2,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a></td></tr>";				
			echo "<tr align=center>";			
			echo "<td><a href=\"#\" onClick=\"getformdata(20,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a></td>";
			echo "<td><a href=\"#\" onClick=\"getformdata(23,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";										
			echo "</td></tr></table>";
			
		*/

		/*
		echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
		echo "<td>";
		
		echo "<a href=\"#\" onClick=\"getformdata(45,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_yandex.gif title='�������� � ������� ������� \"Yandex ������\"' >";
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";		
		echo "<a href=\"#\" onClick=\"getformdata(46,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_qiwi.gif title='�������� � ������� \"QIWI - �������\"' ></a>";			
		echo "</td></tr><tr><td>";		

		echo "<a href=\"#\" onClick=\"getformdata(41,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_mts.gif title='�������� � ������� \"���\"' ></a>";			
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(42,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_tele2.gif title='�������� � ������� \"Tele2\"'></a>";	
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(43,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_beeline.gif title='�������� � ������� \"Beeline\"' ></a>";					
		echo "</td><td>";		
		echo "<a href=\"#\" onClick=\"getformdata(44,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_megafon.gif title='�������� � ������� \"�������\"' ></a>";					
		echo "</td></tr><tr><td>";		

		
		echo "<a href=\"#\" onClick=\"getformdata(47,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' ></a>";			
		echo "</td><td>";				
		echo "<a href=\"#\" onClick=\"getformdata(48,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";	
		echo "</td><td>";				
		//echo "<a href=\"#\" onClick=\"getformdata(49,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"Visa & MasterCard\"' ></a>";			
		echo "<a href=\"#\" onClick=\"getformdata(23,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";										
		echo "</td><td>";				
		echo "<a href=\"#\" onClick=\"getformdata(20,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa_k.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";	

		//echo "<a href=\"#\" onClick=\"getformdata(40,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa_k.gif title='�������� � ������� \"OKpay\"' ></a>";
		echo "</td><td>";		
		//echo "<a href=\"#\" onClick=\"getformdata(23,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";								
		echo "</td><td>";				
		//echo "<a href=\"#\" onClick=\"getformdata(40,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_okpay.gif title='�������� � ������� \"OKpay\"' ></a>";
		echo "</td><td>";				
		//echo "<a href=\"#\" onClick=\"getformdata(50,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WM - ����' ></a>"; 
		echo "</td></tr></table>";				
		*/
		
		echo "<table border=0 cellspacing=5 cellpadding=0> <tr>";
		echo "<td>";
		

		echo "<a href=\"#\" onClick=\"getformdata(5,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_aclick.gif title='�������� � ������� \"�����-����\"' >"; //wmr
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(4,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmr.gif title='�������� � ������� WMR' ></a>"; // ���
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(2,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_wmz.gif title='�������� � ������� WMZ' ></a>"; // ���
		echo "</td><td>";		
		echo "<a href=\"#\" onClick=\"getformdata(6,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_brs2.gif title='�������� � ������� \"������� ��������\"' ></a>";			
		echo "</td></tr><tr><td>";		

		echo "<a href=\"#\" onClick=\"getformdata(7,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_promsvyazbank.gif title='�������� � ������� \"�������������\"' ></a>"; 
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(8,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_sberbank.gif title='�������� � ������� \"��������\"' ></a>";	
		echo "</td><td>";
		echo "<a href=\"#\" onClick=\"getformdata(23,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_paypal.gif title='�������� � ������� ������� \"PayPal\"' ></a>";										
		echo "</td><td>";		
		echo "<a href=\"#\" onClick=\"getformdata(20,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa.gif title='�������� � ������� \"���������� �����\"' ></a>";	//LiqPay
		echo "</td></tr><tr><td>";		
		
				
		//echo "<a href=\"#\" onClick=\"getformdata(13,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_visa_k.gif title='�������� � ������� \"Visa & MasterCard\"' ></a>"; //wmr
		echo "</td><td>";				
		echo "<a href=\"#\" onClick=\"getformdata(10,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_vtb24.gif title='�������� � ������� \"���24\"' ></a>";			
		echo "</td><td>";				
		echo "<a href=\"#\" onClick=\"getformdata(11,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_pochtarf.gif title='�������� � ������� \"����� ��\"' ></a>";	
		echo "</td><td>";				
		//echo "<a href=\"#\" onClick=\"getformdata(12,0,event);\"><img src=http://i.oldbk.com/i/bank/knopka_bitcoin.gif title='�������� � ������� \"Bitcoin\"' ></a>";
		echo "</td></tr></table>";	
				


}

	
function show_logs_kazna($klan,$of=false)
{
					    if (isset($_POST[look_log]))
					       {

					        if (isset($_POST[looklog_date]))
					            {
					            //29.09.11
					            $log_date_all=explode(".",$_POST[looklog_date]);
					            $log_date = sprintf("%02d.%02d.%04d", (int)($log_date_all[0]), (int)($log_date_all[1]), (int)($log_date_all[2]));
					            }
					            else
					            {
					            $log_date = date("d.m.Y");
					            }
					            
					        if (isset($_POST[looklog_date_f]))
					            {
					            //29.09.11
					            $log_date_all_f=explode(".",$_POST[looklog_date_f]);
					            $log_date_f = sprintf("%02d.%02d.%04d", (int)($log_date_all_f[0]), (int)($log_date_all_f[1]), (int)($log_date_all_f[2]));
					            }
					            else
					            {
					            $log_date_f = date("d.m.Y");
					            }					            
					            
					            
					       } else { $log_date = date("d.m.Y"); $log_date_f = date("d.m.Y");   }


					 if ((isset($_POST[look_log])) and (isset($log_date_all)))
					   {
			
			echo "</tr>";
			if ($of==false) { echo "<tr><td colspan=3>"; } else { echo "<tr><td>"; }
			echo "<fieldset style=\"text-align:justify;\"><legend align=center><b>������������� �������� ����� � {$log_date} �� {$log_date_f}  :</b></legend>";			
					   
					   $stamp_start=mktime(0, 0, 0, (int)($log_date_all[1]), (int)($log_date_all[0]), (int)($log_date_all[2]));
					   $stamp_fin=mktime(23, 59, 59,(int)($log_date_all_f[1]), (int)($log_date_all_f[0]), (int)($log_date_all_f[2]));

					   $get_log_kazna=mysql_query("select * from oldbk.clans_kazna_log where clan_id='{$klan['id']}' and kdate>='{$stamp_start}' and kdate<='{$stamp_fin}'  ");
					if (mysql_num_rows($get_log_kazna) >0)
					  {
					   while($row_log=mysql_fetch_array($get_log_kazna))
					     {
					      echo "<small>";
					       if ($row_log[method]==1)
					       	 { echo "<b>-></b>" ; }
					       	  else if ($row_log[method]==2)
					       	   {
					       	    echo "<b><-</b>";
					       	    }
					       	    else
					       	    {
					       	    echo "<b>(!)</b>";
					       	    }
					      echo " <font class=date>".date("d.m.Y H:i",$row_log[kdate])."</font>"." ".$row_log[target];
					      echo "</small><br>";
					     }
					     }
					     else
					     {
						err("�� ��� ���� ��� ������!");
					     }
			echo "</fieldset >";						     
			echo "</td>";			 
				   }



}	
	
	//show_caln_messages ��������� � ������ ���������
function show_caln_messages($post=null,$get=null,$faction)
{
	global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
        if($user[id]==28453)
        {
        	$have_access=3;
        }

	if($klan['glava']==$user['id'] || $polno[$user['id']][0]==1 || $polno[$user['id']][1]==1)
	{
		$have_access=1;
		if($klan['glava']==$user['id'])
		{
			$have_access=2;
		}
	}

	// ���������� ��������� �� �������� ������
	if($get['add_message']==1)
	{
	   	$get['del_message']=(int)$get['del_message'];
	   	if($get['del_message']>0)
	   	{
			$delmess=mysql_fetch_array(mysql_query('Select * FROM oldbk.`users_notepad` WHERE type=1 and owner = '.$klan['id'].' and id="'.$get['del_message'].'" limit 1;'));
	           	$inf=explode(';',$delmess['author']);

			if($klan['glava']==$user['id'] || $polno[$user['id']][0]==1 || $polno[$user['id']][1]==1 || $user['id']==$inf[0])
			{
	           		mysql_query('DELETE FROM oldbk.`users_notepad` WHERE type=1 and owner = '.$klan['id'].' AND id="'.$get['del_message'].'";');
			}
	          	echo "<script>location.href='?razdel=message';</script>";

	   	}
	   	else
	   	if($post['text'] && $post['post_mess'] && !$post['add_spase'])
	   	{
		        $data_count=mysql_fetch_array(mysql_query('Select count(id) as count_id FROM oldbk.`users_notepad` WHERE type=1 and owner = '.$klan['id'].';'));
		        if($data_count['count_id']<$klan['messages'])
		        {
				//���������
				$author=$user['id'].';'.$user['align'].';'.$user['klan'].';'.$user['login'].';'.$user['level'];
				
				$text1=$post['text'];
				$text1 = preg_replace("~&amp;~i","&",$text1);
				$text1 = preg_replace("~&lt;B&gt;~i","<B>",$text1);
				$text1 = preg_replace("~&lt;/B&gt;~i","</B>",$text1);
				$text1 = preg_replace("~&lt;U&gt;~i","<U>",$text1);
				$text1 = preg_replace("~&lt;/U&gt;~i","</U>",$text1);
				$text1 = preg_replace("~&lt;I&gt;~i","<I>",$text1);
				$text1 = preg_replace("~&lt;/I&gt;~i","</I>",$text1);
				$text1 = preg_replace("~&lt;CODE&gt;~i","<CODE>",$text1);
				$text1 = preg_replace("~&lt;/CODE&gt;~i","</CODE>",$text1);
				$text1 = preg_replace("~&lt;b&gt;~i","<b>",$text1);
				$text1 = preg_replace("~&lt;/b&gt;~i","</b>",$text1);
				$text1 = preg_replace("~&lt;u&gt;~i","<u>",$text1);
				$text1 = preg_replace("~&lt;/u&gt;~i","</u>",$text1);
				$text1 = preg_replace("~&lt;i&gt;~i","<i>",$text1);
				$text1 = preg_replace("~&lt;/i&gt;~i","</i>",$text1);
				$text1 = preg_replace("~&lt;code&gt;~i","<code>",$text1);
				$text1 = preg_replace("~&lt;/code&gt;~i","</code>",$text1);
				$text1 = preg_replace("~&lt;br&gt;~i","<br>",$text1);
				$text1 = makeClickableLinks($text1);
				
				preg_match_all("/(\<b\>)/i", $text1, $unclosed11);
				preg_match_all("/(\<\/b\>)/i", $text1, $unclosed12);
				$unclosed_count11 = count($unclosed11[1]);
				$unclosed_count12 = count($unclosed12[1]);
				$diff1 = $unclosed_count11-$unclosed_count12;
				if($diff1 > 0) { for($i = 0; $i < $diff1; $i++) {$text1 = $text1."</B>";}}
				# Tag I
				preg_match_all("/(\<i\>)/i", $text1, $unclosed21);
				preg_match_all("/(\<\/i\>)/i", $text1, $unclosed22);
				$unclosed_count21 = count($unclosed21[1]);
				$unclosed_count22 = count($unclosed22[1]);
				$diff1 = $unclosed_count21-$unclosed_count22;
				if($diff1 > 0) { for($i = 0; $i < $diff1; $i++) {$text1 = $text1."</I>";}}
				# Tag U
				preg_match_all("/(\<u\>)/i", $text1, $unclosed31);
				preg_match_all("/(\<\/u\>)/i", $text1, $unclosed32);
				$unclosed_count31 = count($unclosed31[1]);
				$unclosed_count32 = count($unclosed32[1]);
				
				$diff1 = $unclosed_count31-$unclosed_count32;
				if($diff1 > 0) { for($i = 0; $i < $diff1; $i++) {$text1 = $text1."</U>";}}
				# Tag CODE
				preg_match_all("/(\<code\>)/i", $text1, $unclosed41); preg_match_all("/(\<\/code\>)/i", $text1, $unclosed42);
				$unclosed_count41 = count($unclosed41[1]);         $unclosed_count42 = count($unclosed42[1]);
				$diff1 = $unclosed_count41-$unclosed_count42;
				if($diff1 > 0) { for($i = 0; $i < $diff1; $i++) {$text1 = $text1."</CODE>";}}
				
				if(strlen($text1)>500)
				{
					$text1=substr($text1, 0, 500);
				}
	
				mysql_query('Insert into oldbk.`users_notepad` set owner = '.$klan['id'].', txt="'.mysql_real_escape_string(nl2br($text1)).'",type=1, author="'.$author.'";');
				echo "<script>location.href='?razdel=message';</script>";
				die();
	
		        }
		        else
		        {
		        	 echo '<font color=red><b>������ ������ �������� ���������</b></font>';
		        	 unset($post['text']);
		        }
	
		}
	    	else
	    	if($post['add_spase']&& !$post['post_mess'] && $klan['glava']==$user['id'])
		{
		
		  if($klan['messages']==30)
		  {
		  	  echo '<font color=red><b>� ��� � ��� ��� 30 ����...</b></font>';
		  }
		  else
		  if($user['money']<100)
		  {
		     echo '<font color=red><b>������������ �����</b></font>';
		  }
		  else
		  {
		  	   if( mysql_query('UPDATE clans SET messages=messages+5 WHERE id='.$klan['id'].';'))
		  	   {
		   				$klan['messages']+=5;
		
						$rec['owner']=$user[id];
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user[money];
						$user['money'] -= 100;
						$rec['owner_balans_posle']=$user[money];
						$rec['target']=0;
						$rec['target_login']='�������� ���������';
						$rec['type']=130;//������ ���������
						$rec['sum_kr']=100;
						$rec['item_count']=0;
						add_to_new_delo($rec);
		
		             mysql_query("UPDATE `users` set money=money-100 WHERE id='".$user[id]."';");
		    		 if(olddelo==1)
						 {
							$delo_txt="\"".$user['login']."\" �������� 100��. �� ���������� 5 ������ �������� ��������� (".$klan['messages'].").";
			              	add_to_delo((-100),$delo_txt,$user['id']);
		            	 }
		
		
		
		      	    echo '<font color=red><b>��������� 5 ���� ��� ���������. ������ �� '.$klan['messages'].'</b></font>';
		
		      }
		  }
		}
	}

	echo "<BR><fieldset ><legend><b>���������:</b></legend>";
	$ex_count=0;
	echo '<table width=100%>';
	$data=mysql_query('Select * FROM oldbk.`users_notepad` WHERE type=1 and owner = '.$klan['id'].';');
	if(mysql_num_rows($data)>0)
	{
		while($row=mysql_fetch_array($data))
		{
			if ($ff==0)
			{
				$ff = 1; $color = '#C7C7C7';
			}
			else
			{
				$ff = 0; $color = '#E1E1E3';
			}
			$inf=explode(';',$row['author']);
			//s_nick($id,$align,$klan,$login,$level)
			
			$kk1=substr_count($row['txt'], '"');
			$kk2=substr_count($row['txt'], "'");
			$add1=($kk1%2)?'"':"";
			$add2=($kk2%2)?"'":"";
			

			
			echo '<tr><td align=left width=100% bgcolor='.$color.'><table width=100% border=0><tr><td valign=top>'.close_tags_new($row['txt'].$add1.$add2).'</td><td valign=top align=right>'.s_nick($inf[0],$inf[1],$inf[2],$inf[3],$inf[4]);
			if($have_access>0 || $user[id]==$inf[0])
			{
				echo "<a OnClick=\"if (!confirm('������� ���������?')) { return false; } \" href='?razdel=message&add_message=1&del_message=".$row['id']."'>&nbsp;<img src='http://i.oldbk.com/i/clear.gif'></a>";
			}
			echo '</td></tr></table>';
			$ex_count+=1;
		}
	}

	echo '</table>';
	echo '<form  action="?'.$faction.'&add_message=1" method="post">';
	echo '<b>�������� ��������� ('.$ex_count.'/'.$klan['messages'].') ����.500 ������</b><br><textarea name="text" rows=3 cols=85 wrap="on" maxlength="500">'.$post['text'].'</textarea><br>';
	echo '<input type="submit" name="post_mess" value="��������">';
	if($have_access>1 && $klan['messages']<30)
	{
	   echo "&nbsp;&nbsp;&nbsp;<input type='submit' OnClick=\"if (!confirm('������ ��� 5 �������? ��� ����� ������ ��� 100��.')) { return false; } \" href='?razdel=message&add_message=1' name='add_spase' value='������ ��� 5 ������� (���� 30), 100��.'><br>";
	}
	echo '</form>';
	?>
	<SMALL>����������� �������������
        ����� �������������� ������:<BR><FONT
        color=#990000>&lt;b&gt;</FONT><B>������</B><FONT
        color=#990000>&lt;/b&gt; &lt;i&gt;</FONT><I>���������</I><FONT
        color=#990000>&lt;/i&gt; &lt;u&gt;</FONT><U>������������</U><FONT
        color=#990000>&lt;/u&gt;</FONT>,<BR>� ��� ��������� ������ ��������,
        ����������� <FONT color=#990000>&lt;code&gt; ...
        &lt;/code&gt;</FONT><BR>� �� ��������� ��������� ����! <FONT
        color=#990000>&lt;/b&gt;&lt;/i&gt;&lt;/u&gt;&lt;/code&gt;</FONT> :)
        </SMALL>

	<?
	echo "</fieldset>";
}


function show_change_clans_right($post=null,$get=null,$faction)
{global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
	if ($user['id']==$klan['glava'] || $user['id']==28453 || $user['id']==326)
	{
		$access['glava']= 1;
		if($user['klan']=='pal' || $user['id']==28453 || $user['id']==326)
		{
			$access['glava_pal']= 1;
		}
	}

	if($access['glava'])
	{
		if ((isset($post[savetoall])) and ( ($post[setmklanchen]!='')    or  ($post[setklanchen]!='')   ))
		{
			$Kcha = mysql_query("select id, (select name from oldbk.chanels where user=users.id and klan=users.klan) as name,
			(select mname from oldbk.chanels where user=users.id and klan=users.klan) as mname from users where `klan`='".$user['klan']."' ;");
			
			while ($rows = mysql_fetch_array($Kcha))
			{
			
				$chnls = explode(",",$rows[mname]);
				$chnlsk = explode(",",$rows[name]);
				if((!in_array((int)($post[setmklanchen]),$chnls)) and  (($post[setmklanchen]!='')) )
				{
					if ($rows[mname]!='')
					{
						$new_mname=$rows[mname].",".(int)($post[setmklanchen]);
						mysql_query("UPDATE oldbk.`chanels`  SET `mname`='".$new_mname."' WHERE `klan`='".$user['klan']."' AND `user` = '".$rows[id]."';");
					}
					else
					{
						$new_mname=(int)($post[setmklanchen]);
						mysql_query('INSERT oldbk.`chanels` (`klan`,`user`,`mname`) values(\''.$user['klan'].'\','.$rows[id].',\''.$new_mname.'\' ) ON DUPLICATE KEY UPDATE `mname` =\''.$new_mname.'\';');
					}
				}
				if((!in_array((int)($post[setklanchen]),$chnlsk)) and  (($post[setklanchen]!='')) )
				{
					if ($rows[name]!='')
					{
						$new_name=$rows[name].",".(int)($post[setklanchen]);
						mysql_query("UPDATE oldbk.`chanels`  SET `name`='".$new_name."' WHERE `klan`='".$user['klan']."' AND `user` = '".$rows[id]."';");
					}
					else
					{
						$new_name=(int)($post[setklanchen]);
						mysql_query('INSERT oldbk.`chanels` (`klan`,`user`,`name`) values(\''.$user['klan'].'\','.$rows[id].',\''.$new_name.'\' ) ON DUPLICATE KEY UPDATE  `name` =\''.$new_name.'\';');
					}
				}
			}
		}
		elseif( (isset($post[deltoall])) and ( ($post[setmklanchen]!='')    or  ($post[setklanchen]!='')   ))
		{
			$Kcha = mysql_query("SELECT `name`, `mname` , `user` FROM oldbk.`chanels` WHERE `klan`='".$user['klan']."' ;");
			while ($rows = mysql_fetch_array($Kcha))
			{
				$chnls = explode(",",$rows[mname]);
				$chnlsk = explode(",",$rows[name]);
				if((in_array((int)($post[setmklanchen]),$chnls)) and  (($post[setmklanchen]!='')) )
				{
					if ($rows[mname]!='')
					{
						$new_mname=$rows[mname];
						$new_mname = str_replace(",".(int)($post[setmklanchen]),"",$new_mname);
						$new_mname = str_replace((int)($post[setmklanchen]).",","",$new_mname);
						$new_mname = str_replace((int)($post[setmklanchen]),"",$new_mname);
						mysql_query("UPDATE oldbk.`chanels`  SET `mname`='".$new_mname."' WHERE `klan`='".$user['klan']."' AND `user` = '".$rows[user]."';");
					}
				}
				
				if((in_array((int)($post[setklanchen]),$chnlsk)) and  (($post[setklanchen]!='')) )
				{
					if ($rows[name]!='')
					{
						$new_name=$rows[name];
						$new_name = str_replace(",".(int)($post[setklanchen]),"",$new_name);
						$new_name = str_replace((int)($post[setklanchen]).",","",$new_name);
						$new_name = str_replace((int)($post[setklanchen]),"",$new_name);
						mysql_query("UPDATE oldbk.`chanels`  SET `name`='".$new_name."' WHERE `klan`='".$user['klan']."' AND `user` = '".$rows[user]."';");
					}
				}
			
			}			
		}
	}
	
	$action=(isset($post['action'])?true:false);
	if($action && $access['glava']== 1 || $polno[$user['id']][1]==1 || $polno[$user['id']][0]==1)
	{
		$soklan_id=(int)$post['soklan_id'];
	
		if($user[id]==28453 || $user[id]==326)
		{
			$sok=mysql_fetch_array(mysql_query('SELECT * FROM users where id='.$soklan_id.' and (align>2 and align<3);'));
		}
		
		$sok=mysql_fetch_array(mysql_query('SELECT * FROM users where id='.$soklan_id.' AND klan="'.$user[klan].'";'));
		
		if($sok[id_city]!=$user[id_city])
		{
			$sok=mysql_fetch_array(mysql_query('SELECT * FROM '.$db_other_city.'`users` where id='.$soklan_id.' AND klan="'.$user[klan].'";'));
			
			if($user[id]==28453 || $user[id]==326)
			{
				$sok=mysql_fetch_array(mysql_query('SELECT * FROM '.$db_other_city.'users where id='.$soklan_id.' and (align>2 and align<3);'));
			}
		
		}
	
		if($polno[$user['id']][0]==1 || $access['glava']==1)
		{
			$klan_channels=(isset($post['klan_channels'])?$post['klan_channels']:'');
			$klan_mchannels=(isset($post['klan_mchannels'])?$post['klan_mchannels']:'');
			$kc=explode(',',$klan_channels);
			for($i=0;$i<count($kc);$i++)
			{
				if($kc[$i]==0)
				{
					unset($kc[$i]);
				}
			}
			$klan_channels=implode(',',$kc);
		}

		$status = "";	
		if($polno[$user['id']][1]==1 || $access['glava']==1)
		{
			$status=(isset($post['status'])?$post['status']:'');
		}
		if($user[id]==102904)
		{
			//print_r($post);
		}
	
		if($access['glava']==1)
		{

			$priem_vigon=(isset($post['priem_vigon'])?1:0);
			$change_status=(isset($post['change_status'])?1:0);
			$change_gifts=(isset($post['change_gifts'])?1:0);
			$ars_access=(isset($post['ars_access'])?1:0);
			$ars_item_access=(isset($post['ars_item_access'])?1:0);
			$kazn_access=(isset($post['kazn_access'])?1:0);
			$kazn_logs_access=(isset($post['kazn_logs_access'])?1:0);
			$telegraf_access=(isset($post['telegraf_access'])?1:0);
			$war_access=(isset($post['war_access'])?1:0);
			$castle_access=(isset($post['castle_access'])?1:0);
			$castleb_access=(isset($post['castleb_access'])?1:0);
		
				
			if($access['glava_pal']==1)
			{
				$logs=(isset($post['logs'])?1:0);
				$ext_logs=(isset($post['ext_logs'])?1:0);
				$red_forum=(isset($post['red_forum'])?1:0);
				$pal_tel=(isset($post['pal_tel'])?1:0);
				$top_move=(isset($post['top_move'])?1:0);
				$klans_kazna_view=(isset($post['klans_kazna_view'])?1:0);
				$klans_kazna_logs=(isset($post['klans_kazna_logs'])?1:0);
				$klans_ars_logs=(isset($post['klans_ars_logs'])?1:0);
				$pals_delo=(isset($post['pals_delo'])?1:0);
				$pals_online=(isset($post['pals_online'])?1:0);
				$zhhistory=(isset($post['zhhistory'])?1:0);
				$loginip=(isset($post['loginip'])?1:0);
				$viewmanyips=(isset($post['viewmanyips'])?1:0);
			}
		}
	
		if(isset($status) && $status != '')
		{
			$status = strip_tags($status);
			$status = str_ireplace("&lt;b&gt;","<b>",$status);
			$status = str_ireplace("&lt;/b&gt;","</b>",$status);
			$status = str_ireplace("&lt;i&gt;","<i>",$status);
			$status = str_ireplace("&lt;/i&gt;","</i>",$status);
			$status = str_ireplace("&lt;u&gt;","<u>",$status);
			$status = str_ireplace("&lt;/u&gt;","</u>",$status);
		}
	
		$rez='';
		if(($castle_access>0 || $war_access>0 || $priem_vigon>=0 || $change_status>=0 || $ars_access>=0 || $kazn_access>=0 || $ars_item_access>=0 || $change_gifts>=0 || $telegraf_access>=0 || $klans_kazna_view>=0 || $klans_kazna_logs || $klans_ars_logs))
		{
			$bcp[$soklan_id]=$polno[$soklan_id];
			
			if($access['glava']==1)
			{
				$polno[$soklan_id][0]=$priem_vigon;
				$polno[$soklan_id][1]=$change_status;
				$polno[$soklan_id][2]=$ars_access;
				$polno[$soklan_id][3]=$kazn_access;
				$polno[$soklan_id][4]=$kazn_logs_access;
				$polno[$soklan_id][5]=$ars_item_access;
				$polno[$soklan_id][6]=$change_gifts;
				$polno[$soklan_id][7]=$telegraf_access;
				$polno[$soklan_id][8]=$war_access;
				$polno[$soklan_id][9]=$castle_access;
				$polno[$soklan_id][11]=$castleb_access;
				
				if($access['glava_pal']==1)
				{
						
						$sql="INSERT INTO oldbk.`pal_rights` 
						(`pal_id`,`logs`,`ext_logs`,`red_forum`,`top_move`,`klans_kazna_view`,`klans_kazna_logs`,`klans_ars_logs`,`pal_tel`)
						VALUES
						('".$soklan_id."','".$logs."','".$ext_logs."','".$red_forum."','".$top_move."','".$klans_kazna_view."','".$klans_kazna_logs."','".$klans_ars_logs."','".$pal_tel."')
						ON DUPLICATE KEY UPDATE 
						`logs` = '".$logs."', 
						`ext_logs` = '".$ext_logs."',
						`red_forum` = '".$red_forum."',
						`pal_tel` = '".$pal_tel."',
						`top_move` = '".$top_move."',
						`klans_kazna_view` ='".$klans_kazna_view."',
						`klans_kazna_logs` ='".$klans_kazna_logs."',
						`klans_ars_logs`='".$klans_ars_logs."',
						`pals_delo`='".$pals_delo."',
						`zhhistory`='".$zhhistory."',
						`loginip`='".$loginip."',
						`viewmanyips`='".$viewmanyips."',
						`pals_online`='".$pals_online."';";						
						mysql_query($sql);						
				}
			}
			
			if($bcp[$soklan_id]!=$polno[$soklan_id])
			{
				if(mysql_query('UPDATE oldbk.`clans` SET vozm="'.(serialize($polno)).'" WHERE short="'.$user['klan'].'"'))
				{
					$rez.='����� �������� ��������. ';
				}
			}
		}
	
		if(($access['glava']==1 || $polno[$user['id']][0]==1))
		{
		
			$echannels=mysql_fetch_array(mysql_query('SELECT * FROM oldbk.`chanels` where user='.$soklan_id.' AND klan="'.$user[klan].'";'));
			if($echannels['name']!=$klan_channels)
			{
				if(mysql_query('INSERT oldbk.`chanels` (`klan`,`name`,`user`)values(\''.$user['klan'].'\',\''.$klan_channels.'\','.$soklan_id.')
						 				ON DUPLICATE KEY UPDATE `name` =\''.$klan_channels.'\';'))
				{
					$rez.='�������� ������ ��������. ';
				}
			}
			
			if($echannels['mname']!=$klan_mchannels)
			{
				if (mysql_query('INSERT oldbk.`chanels` (`klan`,`mname`,`user`)values(\''.$user['klan'].'\',\''.$klan_mchannels.'\','.$soklan_id.')
						 				ON DUPLICATE KEY UPDATE `mname` =\''.$klan_mchannels.'\';'))
				{
					$rez.='����������� ������ ��������.';
				}
			}
		}
		
		if($status!='' && ($polno[$user['id']][1]==1 || $access['glava']==1))
		{
			if($sok['status']!=$status)
			{
				//$patterns = ;
				if ($sok[id_city]==0) {$sok_db_other_city='oldbk.';}
				else if ($sok[id_city]==1) {  $sok_db_other_city='avalon.';}
				else { $sok_db_other_city='' ; }
					
				
				if($klan[glava]==$soklan_id)
				{
					$status='<font color=#008080><b>����� �����</b></font>';
				}
				
				if(mysql_query('UPDATE '.$sok_db_other_city.'`users` SET status = "'.$status.'" WHERE id = "'.$soklan_id.'" AND klan="'.$user[klan].'";'))
				{
					//�����������
					mysql_query("INSERT INTO `oldbk`.`clan_status_log` SET `who`='".$user['id']."',`owner`='".$soklan_id."' ,`text`='".$status."' ");
				
					$rez.='������ �������. ';
				}
			}
		}
	
	}

	echo '<font color=red><b>'. $rez.'&nbsp;</b></font><br>';
	$echo_='
	<table border=0>
	
	<tr>
	<td class=menu221>
	<font class=menu22><b>���</b> </font>
	</td>';
	echo $echo_;
	$to_div='<tr>
	<td class=menu221>
	<font class=menu22><b>���</b> </font>
	</td>';
	$colspan=1;
	
	
	if($access['glava']==1)
	{
		$echo_='<td class=menu221>
		<font class=menu22><b>���������<br>/<br>��������<br> ������ �����</b> </font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������<br>������</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������� <br>����-��������</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������ <br>�<br>��������</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������ <br>� ������� <br>����������� ����</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������ <br>�<br>�����</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������ <br>�<br>����� �����</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������ <br>�<br>���������</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>���������� �������</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>����� �� �����</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>������������� ���������� ����</b></font>
		</td>

		';
		echo $echo_;
		
		$to_div.=$echo_;
		$colspan+=9;
		if($access['glava_pal']==1) //����� ������
		{
			$echo_='
			<td class=menu221>
			<font class=menu222><b>������ <br>�<br>���������</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>����������� <br>������ <br>�<br>���������</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>�����������</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>�� ������ �������</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>������� �����</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>�������� ����� ������</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>���� ����� ������</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>���� ���� ������</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>�������� �����</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>����� � ����</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>������� �����</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>�������� �����/��</b></font>
			</td>
			<td class=menu221>
			<font class=menu222><b>100 IP</b></font>
			</td>
			';
			echo $echo_;
			$to_div.=$echo_;
			$colspan+=10;
		}
		
	}
	if($polno[$user['id']][0]==1 || $access['glava']==1 )
	{
		$echo_='
		<td class=menu221>
		<font class=menu22><b>���������<br>������ <br>(1,2,3,4...)</b></font>
		</td>
		<td class=menu221>
		<font class=menu22><b>��������� <br>������� ������ <br>(0,1,2,3...)</b> </font>
		</td>';
		echo $echo_;
		$to_div.=$echo_;
		$colspan+=2;
		
	}
	if($polno[$user['id']][1]==1 || $access['glava']==1)
	{
		$echo_='<td class=menu221>
		<font class=menu22><b>������</b> </font>
		</td>';
		echo $echo_;
		$to_div.=$echo_;
		$colspan+=1;
	}
	
		$echo_='<td class=menu221>
			<font class=menu22><b>��������� <br>���������</b>  </font>
		</td>';
		echo $echo_;
		$to_div.=$echo_;
				 
	$colspan+=1;
	/*
	if($polno['change_channel_access']==1)
	{
	
	}
	*/
	echo '</tr>';
	echo '<tr><td colspan='.$colspan.' align=middle>'.'<h3>'.$city_name[$user[id_city]].'</h3></td></tr>';
	  /*
	   	   echo '<input type=checkbox name=vin ';  if ($polno[$sok['id']][0]==1) { echo ' checked '; }  echo '>����� ���������/�������� ������ �����<BR>
	       <input type=checkbox name=tus ';  if ($polno[$sok['id']][1]==1) { echo ' checked '; }   echo '>����� ������ ������ ������ �����<BR>';
	      echo '<input type=checkbox name=ars ';  if ($polno[$sok['id']][2]==1) { echo ' checked '; }  echo '>����� ������ � ��������<BR>';
	      echo '<input type=checkbox name=kazna '; if ($polno[$sok['id']][3]==1) { echo ' checked '; }  echo '>����� ������ � �������� �����<BR>';
	      echo '<input type=checkbox name=kazna_log ';   if ($polno[$sok['id']][4]==1) { echo ' checked '; }  echo '>����� ������ � ��������� ����� �������� �����<BR>'

	    */
	$channels=array();
	$data= mysql_query("SELECT * FROM oldbk.`chanels` WHERE `klan`='".$user['klan']."' ;");
	while($row=mysql_fetch_array($data))
	{
		$channels[$row['user']]=$row;
	}
	
	if($access['glava_pal']) //��������� �������� ��� ���� �����
	{
		$data= mysql_query("SELECT * FROM oldbk.`pal_rights`;");
		while($row=mysql_fetch_array($data))
		{
			$pal_rights[$row['pal_id']]=$row;
		}	
	}

			//������ �������� � ������� � ���������

	
	if($user[id]==28453 || $user[id]==326)
	{
		$data=mysql_query("SELECT * FROM `users` WHERE  id_city=".$user['id_city']." and ((align>2 and align<3) or align=7) order by  align desc, login asc;");
	}
	else
	{
		$data=mysql_query("SELECT * FROM `users` WHERE  id_city=".$user['id_city']." and klan='".$klan['short']."' order by  align desc, login asc;");
	}
	$strc=0;
	while ($row = mysql_fetch_array($data))
	{
	
		if($strc==6)
		{
			echo $to_div;
			$strc=0;
		}
		else
		{
			$strc++;
		}
	
		if ($ff==0)
		{
			$ff = 1; $color = '#C7C7C7';
		} 
		else
		{
			$ff = 0; $color = '#E1E1E3';
		}
		echo '<tr>';
		echo '<td align=left bgcolor="'.$color.'">
		<form method="post" action="?'.$faction.'" id="form_'.$row['id'].'" name=fff><img src="http://i.oldbk.com/i/align_'.$row['align'].'.gif"><b>'.$row['login'].'</b><input name="soklan_id" type="hidden" value="'.$row['id'].'"></td>
		<input name="action" type="hidden" value="1">';
		if($access['glava']==1)
		{
			?>
			<td align=center  bgcolor="<?=$color?>"> <!--<b>���������/��������<br> ������ �����</b>-->
			<input name="priem_vigon"  type="checkbox" <?=($polno[$row['id']][0]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������<br>������</b>-->
			<input name="change_status" type="checkbox" <?=($polno[$row['id']][1]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������ � ���� ��������</b>-->
			<input name="change_gifts" type="checkbox" <?=($polno[$row['id']][6]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������ �<br>��������</b>-->
			<input name="ars_access" type="checkbox" <?=($polno[$row['id']][2]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������� ����������� ����</b>-->
			<input name="ars_item_access" type="checkbox" <?=($polno[$row['id']][5]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--������ �<br>�����</b>-->
			<input name="kazn_access" type="checkbox" <?=($polno[$row['id']][3]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--������ �<br>����� �����</b>-->
			<input name="kazn_logs_access" type="checkbox" <?=($polno[$row['id']][4]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--������ �<br>���������</b>-->
			<input name="telegraf_access" type="checkbox" <?=($polno[$row['id']][7]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--���������� �������</b>-->
			<input name="war_access" type="checkbox" <?=($polno[$row['id']][8]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--���������� �������</b>-->
			<input name="castle_access" type="checkbox" <?=($polno[$row['id']][9]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--���������� �������</b>-->
			<input name="castleb_access" type="checkbox" <?=($polno[$row['id']][11]==1?"checked ":"")?> value=1>
			</td>
			<?
			if($access['glava_pal']==1) //����� ������
			{
				?>
				<td align=center bgcolor="<?=$color?>"> <!--������ �<br>���������</b>-->
				<input name="logs" type="checkbox" <?=($pal_rights[$row['id']]['logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--����������� ������ �<br>���������</b>-->
				<input name="ext_logs" type="checkbox" <?=($pal_rights[$row['id']]['ext_logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--�����������</b>-->
				<input name="pal_tel" type="checkbox" <?=($pal_rights[$row['id']]['pal_tel']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--�� ������ �������</b>-->
				<input name="red_forum" type="checkbox" <?=($pal_rights[$row['id']]['red_forum']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--������� �����</b>-->
				<input name="top_move" type="checkbox" <?=($pal_rights[$row['id']]['top_move']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--�������� �����</b>-->
				<input name="klans_kazna_view" type="checkbox" <?=($pal_rights[$row['id']]['klans_kazna_view']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--���� ����� ������</b>-->
				<input name="klans_kazna_logs" type="checkbox" <?=($pal_rights[$row['id']]['klans_kazna_logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--���� ���� ������</b>-->
				<input name="klans_ars_logs" type="checkbox" <?=($pal_rights[$row['id']]['klans_ars_logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--�������� �����</b>-->
				<input name="pals_delo" type="checkbox" <?=($pal_rights[$row['id']]['pals_delo']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--����� � ����</b>-->
				<input name="pals_online" type="checkbox" <?=($pal_rights[$row['id']]['pals_online']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--����� � ����</b>-->
				<input name="zhhistory" type="checkbox" <?=($pal_rights[$row['id']]['zhhistory']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--��������� �����-��</b>-->
				<input name="loginip" type="checkbox" <?=($pal_rights[$row['id']]['loginip']==1?"checked ":"")?> value=1>
				</td>			
				<td align=center bgcolor="<?=$color?>"> <!--��������� �����-��</b>-->
				<input name="viewmanyips" type="checkbox" <?=($pal_rights[$row['id']]['viewmanyips']==1?"checked ":"")?> value=1>
				</td>			
				<?
			}
		}
		if($polno[$user['id']][0]==1 || $access['glava']==1)
		{
			?>
			<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ������</b>-->
			<input name="klan_channels" type="text" value="<?=($channels[$row['id']]['name'])?>">
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ����������� ������</b>-->
			<input name="klan_mchannels" type="text" value="<?=($channels[$row['id']]['mname'])?>">
			</td>
			<?
		}
		
		if($polno[$user['id']][1]==1 || $access['glava']==1)
		{
			?>
			<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ����������� ������</b>-->
			<input name="status" type="text" value="<?=$row['status']?>">
			</td>
			<?
		}
		?>
		<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ����������� ������</b>
		<input type="button" onclick="javascript:check_form('<?=$row['id']?>');" value="���������">    -->
		<input type="submit" value="���������">
		</td>
		
		<?
		
		
		echo '</form></tr>';
	}

      	echo '<tr><td colspan='.$colspan.' align=center>'.'<h3>'.$city_name[$id_other_city].'</h3></td></tr>';

	if($user[id]==28453 || $user[id]==326)
	{
		$data=mysql_query("SELECT * FROM ".$db_other_city."`users` WHERE  id_city=".$id_other_city." and align>2 and align<3 AND id not in (".$user['id'].",".$klan['glava'].")   order by  align desc, login asc;");
	}
	else
	{
		$data=mysql_query("SELECT * FROM ".$db_other_city."`users` WHERE  id_city=".$id_other_city." and klan='".$klan['short']."' AND id not in (".$user['id'].",".$klan['glava'].")   order by  align desc, login asc;");
	}
	
	while ($row = mysql_fetch_array($data))
	{
		if($strc==6)
		{
			echo $to_div;
			$strc=0;
		}
		else
		{
			$strc++;
		}
		
		echo '<tr>';
		echo '<td align=left bgcolor="'.$color.'">
		<form method="post" action="?'.$faction.'" id="form_'.$row['id'].'" name=fff><img src="http://i.oldbk.com/i/align_'.$row['align'].'.gif"><b>'.$row['login'].'</b><input name="soklan_id" type="hidden" value="'.$row['id'].'"></td>
		<input name="action" type="hidden" value="1">';
		if($access['glava']==1)
		{
			?>
			<td align=center  bgcolor="<?=$color?>"> <!--<b>���������/��������<br> ������ �����</b>-->
			<input name="priem_vigon"  type="checkbox" <?=($polno[$row['id']][0]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������<br>������</b>-->
			<input name="change_status" type="checkbox" <?=($polno[$row['id']][1]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������ � ���� ��������</b>-->
			<input name="change_gifts" type="checkbox" <?=($polno[$row['id']][6]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������ �<br>��������</b>-->
			<input name="ars_access" type="checkbox" <?=($polno[$row['id']][2]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>������� ����������� ����</b>-->
			<input name="ars_item_access" type="checkbox" <?=($polno[$row['id']][5]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--������ �<br>�����</b>-->
			<input name="kazn_access" type="checkbox" <?=($polno[$row['id']][3]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--������ �<br>����� �����</b>-->
			<input name="kazn_logs_access" type="checkbox" <?=($polno[$row['id']][4]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--������ �<br>���������</b>-->
			<input name="telegraf_access" type="checkbox" <?=($polno[$row['id']][7]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--���������� �������</b>-->
			<input name="war_access" type="checkbox" <?=($polno[$row['id']][8]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--���������� �������</b>-->
			<input name="castle_access" type="checkbox" <?=($polno[$row['id']][9]==1?"checked ":"")?> value=1>
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--���������� �������</b>-->
			<input name="castleb_access" type="checkbox" <?=($polno[$row['id']][11]==1?"checked ":"")?> value=1>
			</td>
			<?
			if($access['glava_pal']==1) //����� ������
			{
				?>
				<td align=center bgcolor="<?=$color?>"> <!--������ �<br>���������</b>-->
				<input name="logs" type="checkbox" <?=($pal_rights[$row['id']]['logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--����������� ������ �<br>���������</b>-->
				<input name="ext_logs" type="checkbox" <?=($pal_rights[$row['id']]['ext_logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--�����������</b>-->
				<input name="pal_tel" type="checkbox" <?=($pal_rights[$row['id']]['pal_tel']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--�� ������ �������</b>-->
				<input name="red_forum" type="checkbox" <?=($pal_rights[$row['id']]['red_forum']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--������� �����</b>-->
				<input name="top_move" type="checkbox" <?=($pal_rights[$row['id']]['top_move']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--������� �����</b>-->
				<input name="klans_kazna_view" type="checkbox" <?=($pal_rights[$row['id']]['klans_kazna_view']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--������� �����</b>-->
				<input name="klans_kazna_logs" type="checkbox" <?=($pal_rights[$row['id']]['klans_kazna_logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--������� �����</b>-->
				<input name="klans_ars_logs" type="checkbox" <?=($pal_rights[$row['id']]['klans_ars_logs']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--�������� �����</b>-->
				<input name="pals_delo" type="checkbox" <?=($pal_rights[$row['id']]['pals_delo']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--����� � ����</b>-->
				<input name="pals_online" type="checkbox" <?=($pal_rights[$row['id']]['pals_online']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--����� � ����</b>-->
				<input name="zhhistory" type="checkbox" <?=($pal_rights[$row['id']]['zhhistory']==1?"checked ":"")?> value=1>
				</td>
				<td align=center bgcolor="<?=$color?>"> <!--��������� �����-��</b>-->
				<input name="loginip" type="checkbox" <?=($pal_rights[$row['id']]['loginip']==1?"checked ":"")?> value=1>
				</td>			
				<td align=center bgcolor="<?=$color?>"> <!--��������� �����-��</b>-->
				<input name="viewmanyips" type="checkbox" <?=($pal_rights[$row['id']]['viewmanyips']==1?"checked ":"")?> value=1>
				</td>			
				<?
			}
		}
		
		if($polno[$user['id']][0]==1 || $access['glava']==1)
		{
			?>
			<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ������</b>-->
			<input name="klan_channels" type="text" value="<?=($channels[$row['id']]['name'])?>">
			</td>
			<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ����������� ������</b>-->
			<input name="klan_mchannels" type="text" value="<?=($channels[$row['id']]['mname'])?>">
			</td>
			<?
		}
		if($polno[$user['id']][1]==1 || $access['glava']==1)
		{
			?>
			<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ����������� ������</b>-->
			<input name="status" type="text" value="<?=$row['status']?>">
			</td>
			<?
		}
		?>
		<td align=center bgcolor="<?=$color?>"> <!--<b>��������� ����������� ������</b>
		<input type="button" onclick="javascript:check_form('<?=$row['id']?>');" value="���������">    -->
		<input type="submit" value="���������">
		</td>
		
		<?
		
		
		echo '</form></tr>';
	}
	echo '</tr></table><br><table><tr><td><fieldset><legend><b>��������� �������: </b></legend>';
	if($klan[glava]==$user[id])
	{
		echo "<form action=\"?".$faction."\" method=POST>";
		echo '�����  ���� ������:  <input type=text value="" name=setklanchen size=4>&nbsp;&nbsp;';
		echo '�����  ���.���� ������: <input type=text value="" name=setmklanchen size=4><BR><BR>';
		echo '<input type=submit value="���������� ���� �����������" name=savetoall>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input type=submit value="������� ���� �����������" name=deltoall>';
		echo "</form></fieldset></td></tr></table>";
	}
	echo '</body>';

}


function show_clans_war_rendering($post=null,$get=null,$faction,$full_render=true)
{	global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna,$war_price,$rooms;
		
		if ($user[klan]!='')  
		 {
		     	echo '
		        <form action="?'.$faction.'" method=POST>
		        <fieldset><legend><b>�������� ������ ������: </b></legend>
			<table>
				<tr>
				<td> ';
               			$get['delusr']=(int)$get['delusr'];

					if ($post['FindLogin']!="") {						$sql="SELECT id,klan FROM oldbk.users WHERE login='".mysql_escape_string($post['FindLogin'])."' and bot=0 ";
						if($user[id]==28453)
						{
						echo $sql;
						}
						$us=mysql_fetch_row(mysql_query($sql));
						if ((int)$us[0]==0) echo "�������� � ����� ����� �� ������ � ���� ������";
						elseif ((int)$us[0]==$_SESSION['uid']) echo "���������� ���-����? ;)<br>";
						elseif ($us[1] === $user['klan']) {echo "�� ��� �� ������???<br>";}
						else {
							if (!mysql_query("INSERT INTO oldbk.friends (owner, friend, status, comment, type, klan_list)VALUES(".(int)$_SESSION['uid'].",".$us[0].",0,'".mysql_escape_string($post['commentusr'])."','1','".$user[klan]."')")) echo "<font color=#A42323><b>������ ��� ����������. �������� ���� ����� ��� � ��� � ������?</b></font><br><br>";
							else echo "<font color=red><b>�������� �������� � ������ ������.</b></font><br>";
							}
					}
					if ($get['delusr']>0) {
							if (!preg_match('/^(http:\/\/)((capitalcity|avaloncity)\.|top\.|admin\.)?(oldbk.com)((\/klan.php(.)*)|(\b))/i',trim($_SERVER['HTTP_REFERER']))>0) die("������... �������� ������� ������..");
							else { mysql_query("DELETE FROM oldbk.friends WHERE friend='".$get['delusr']."' AND type=1 AND klan_list='".$user[klan]."'"); echo "�������� ����� �� ������ ������.<br>"; }
						//	echo "<meta http-equiv='refresh' content='0;url=/klan.php'>";
					}

	                 			 $on1=0; $on2=0;
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//�����  � ���� ������

					$data=mysql_query("SELECT u.*, f.owner, f.comment, f.friend, b.blood, b.type as btype, (select `type` from `effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
					FROM  oldbk.friends f, `users` u
					left join `battle` b
					on u.battle= b.id
					WHERE u.id=f.friend AND f.klan_list='".$user['klan']."' AND f.type=1 and u.id_city={$user[id_city]} order by u.login asc ;");


					$to_print_online='';
					$to_print_offline='';
					while ($row = mysql_fetch_array($data))
					{
					if ($row['status'] != '') { $kl_status=" - ".$row['status']; } else  { $kl_status="";}
					 // �������� ����� ��� ��� � ������� � �� �������
				 	 if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
				 		{
							$to_print_online.='<A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
							$to_print_online.=nick_hist($row).'&nbsp;';
							$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
						
							//fix blood
							if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }
							
							$to_print_online.=($row['battle']>0?'<a target=_blank href=http://capitalcity.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
				   			$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'');

							$to_print_online.=$kl_status;
						  if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
						  elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
						  elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }							  
						   elseif ($row['ruines'] > 0) { $rrm = '�����'; }
						  elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
						   else { $rrm = $rooms[$row['room']]; }
						$to_print_online.=' - <i>'.$rrm.'</i>';
						$to_print_online.=" - (".$row['comment'].") �������(�) <i><b>".global_nick($row[owner])."</b></i>
								<a OnClick=\"if (!confirm('������� �������� �� ������ ������?')) { return false; } \" href='?".$faction."&delusr=".$row[friend]."'><img src='https://i.oldbk.com/i/clear.gif' width=15 height=15 alt='�������' title='�������'> </a>
								<BR>";

				 		}
					  else  {
						$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
						$row[hidden]=0; // fix ��� ����������
						$to_print_offline.=nick_hist($row);
						$to_print_offline.=$kl_status;
						$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i>';
						$to_print_offline.=" - (".$row['comment'].") �������(�) <i><b>".global_nick($row[owner])."</b></i>
								<a OnClick=\"if (!confirm('������� �������� �� ������ ������?')) { return false; } \" href='?".$faction."&delusr=".$row[friend]."'><img src='https://i.oldbk.com/i/clear.gif' width=15 height=15 alt='�������' title='�������'> </a>
								<BR>";
					  	}
					}////////////////////
					//������� ������������ �������
					if (($to_print_online!='') or ($to_print_offline!=''))
					{
					echo "<h3>".$city_name[$user[id_city]]."</h3>";
					echo $to_print_online;
					echo $to_print_offline;
					}
					else
					{
					$on1=1;
					}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					// ����� � ������ ������
					$data=mysql_query("SELECT u.*,f.owner, f.comment,f.friend,b.blood, b.type as btype, (select `type` from ".$db_other_city."`effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
					FROM oldbk.friends f,".$db_other_city."`users` u
					left join ".$db_other_city."`battle` b
					on u.battle= b.id
					WHERE u.id=f.friend AND f.klan_list='".$user['klan']."' AND f.type=1 and u.id_city={$id_other_city}  order by u.login asc ;");


					$to_print_online='';
					$to_print_offline='';
					while ($row = mysql_fetch_array($data))
					{
					if ($row['status'] != '') { $kl_status=" - ".$row['status']; } else  { $kl_status="";}
					 // �������� ����� ��� ��� � ������� � �� �������
				 	 if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
				 		{
							$to_print_online.='<A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
							$to_print_online.=nick_hist($row).'&nbsp;';
							$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
							
							//fix blood
							if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }
							
							$to_print_online.=($row['battle']>0?'<a target=_blank href=http://capitalcity.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
				   			$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'');

							$to_print_online.=$kl_status;
						  if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
						  elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
						  elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }							  
						   elseif ($row['ruines'] > 0) { $rrm = '�����'; }
						  elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
						   else { $rrm = $rooms[$row['room']]; }
						$to_print_online.=' - <i>'.$rrm.'</i>';
						$to_print_online.=" - (".$row['comment'].") �������(�) <i><b>".global_nick($row[owner])."</b></i>
								<a OnClick=\"if (!confirm('������� �������� �� ������ ������?')) { return false; } \" href='?".$faction."&delusr=".$row[friend]."'><img src='http://i.oldbk.com/i/clear.gif'></a>
								<BR>";
				 		}
					  else  {
						$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
						$row[hidden]=0; // fix ��� ����������
						$to_print_offline.=nick_hist($row);
						$to_print_offline.=$kl_status;
						$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i>';
						$to_print_offline.=" - (".$row['comment'].") �������(�) <i><b>".global_nick($row[owner])."</b></i>
								<a OnClick=\"if (!confirm('������� �������� �� ������ ������?')) { return false; } \" href='?".$faction."&delusr=".$row[friend]."'><img src='http://i.oldbk.com/i/clear.gif'></a>
								<BR>";

					  	}
					}
					////////////////////
					//������� ������������ �������
					if (($to_print_online!='') or ($to_print_offline!=''))
					{
					echo "<h3>".$city_name[$id_other_city]."</h3>";
					echo $to_print_online;
					echo $to_print_offline;
					}
					else
					{
					$on2=1;
					}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    if($on1==1&&$on2==1){
                    	echo "������ ������ ���� :(<br>";
                    }

						echo "<br>
							</td>
						</tr>
						</table>
					<br>

					<table>
						<tr>
							<td align=left>
										<form method=post action=?".$faction.">
									�������� ����� � ������
											<table>
												<tr>
													<td>
													������� ��� ���������<br><small>(����� �������� �� ������ � ����)</small><td><input name='FindLogin'>
											        </td>
												</tr>
												<tr>
													<td>��������:</td><td><input name=commentusr><tr><td colspan=2 align=right><input type=submit value='��������'></td>
												</tr>
											</table>
										</form>";

				echo '  		</td>
							</tr>
						</table>
                	</fieldset>
                	<br>
				<fieldset><legend><b>������ ����: </b></legend>
				<table border=0  width=100% align=left>
					<tr><td align=middle valign=top> ����� �������������� �����: <b>'.$klan['voinst'].'</b>

					</td></tr>
					<tr><td align=middle valign=top>';


		 	   		//��������� �� ������ � �������. � ����� ������� ��� ���� � �������. �� ������ ������ � ����� ������.
					if(($user['id']==$klan['glava'] || $polno[$user['id']][8]==1 )&& $klan['base_klan']==0)
					{
					$rulit=1;
					}
					else
					{
					$rulit=0;
					}
					//��� ������� ������� �� ������ ID ������(�� �������)
					if($klan['base_klan']>0)
					{
					$kl=$klan['base_klan'];
					$klan['id']=$klan['base_klan'];
					$kl_sql=$klan['base_klan'].','.$klan['id'];
					}
					else
					{
					$kl=$klan['id'];
					$kl_sql= $klan['id'];
					}
					//////////////////////////////////////	
					include ('klan_war_new.php');
		 	   	   	echo print_mk_war($kl,$rulit);

					
			 	echo '</td></tr></table></fieldset>';
			
		}

	}

	function show_klans_names($post=null,$get=null,$faction)
	{		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
		echo '<center><h3>';
		echo show_klan_name($klan['short'],$klan['align']) ;
		if($recrut)
			{
				echo '<br>������-���� - '. show_klan_name($recrut['short'],$recrut['align']);
			}
		if($base_klan)
			{
				echo '<br>����-������ - '.show_klan_name($base_klan['short'],$base_klan['align']);
			}
        echo '</h3></center>';	}

	function show_main_klan_info($post=null,$get=null,$faction)
	{        global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna,$rooms;



		echo '<fieldset><legend><b>������ �����: </b></legend><table >
				<tr>
				<td align=left>';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//��� ����- � ���� ������
						$data=mysql_query("SELECT u.*, b.blood, b.type as btype, (select `type` from `effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
											FROM `users` u
												left join `battle` b
												on u.battle= b.id
												WHERE `klan` = '".$klan['short']."' and id_city={$user[id_city]}

						order by login asc ;");
						$to_print_online='';
						$to_print_offline='';
						while ($row = mysql_fetch_array($data))
						{
						 //if ($row['id'] == $klan['glava']) { $kl_status=" - <font color=#008080><b>����� �����</b></font>"; } else  { $kl_status=" - ".$row['status'];}
						 $kl_status=" - ".$row['status'];
						 // �������� ����� ��� ��� � ������� � �� �������
					 	  if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
					 	  {                  //http://i.oldbk.com/i/lock2.gif
								$to_print_online.='<A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
								$to_print_online.=nick_hist($row).'&nbsp;';
								$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
								
								//fix blood
								if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }
								
								$to_print_online.=($row['battle']>0?'<a target=_blank href=http://'.(strtolower($city_name[$user[id_city]])).'.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
	                            				$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'').$kl_status;

								if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
								elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
								  elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }									
								elseif ($row['ruines'] > 0) { $rrm = '�����'; }
							  	elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
								elseif ($row['room'] >= 49998 && $row['room'] <= 60000) {
									include "map_config.php";
									reset($map_locations);
									$bfound = false;
									while(list($k,$v) = each($map_locations)) {
										if ($row['room'] == $v['room']) {
										    	$rrm = $v['name'];
											$bfound = true;
										}
									}
									if (!$bfound) $rrm = '�������'; 
								}
								else { $rrm = $rooms[$row['room']]; }
								$to_print_online.=' - <i>'.$rrm.'</i><BR>';
					 	  }
						  else
						  {
							$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
							$row[hidden]=0; // fix ��� ����������
							$to_print_offline.=nick_hist($row);
							$to_print_offline.=$kl_status;
							$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i><BR>';
						  	}
						}////////////////////
					//������� ������������ �������
					if (($to_print_online!='') or ($to_print_offline!=''))
					{
						
					echo "<h3>".$city_name[$user[id_city]]."</h3>";
					echo $to_print_online;
					echo $to_print_offline;
					}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//��� ����- � ������ ������


						$data=mysql_query("SELECT  u.*, b.blood, b.type as btype, (select `type` from ".$db_other_city."`effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
											FROM ".$db_other_city."`users` u
                         					left join ".$db_other_city."`battle` b
											on u.battle= b.id
						WHERE u.`klan` = '".$klan['short']."' and u.id_city={$id_other_city} order by login asc ;");

						$to_print_online='';
						$to_print_offline='';
						while ($row = mysql_fetch_array($data))
						{
						//if ($row['id'] == $klan['glava']) { $kl_status=" - <font color=#008080><b>����� �����</b></font>"; } else  { $kl_status=" - ".$row['status'];}
						$kl_status=" - ".$row['status'];
						 // �������� ����� ��� ��� � ������� � �� �������
					 	 if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
					 		{ 								
								$to_print_online.='<A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
								$to_print_online.=nick_hist($row).'&nbsp;';
								$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
								
								//fix blood
								if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }
								
								$to_print_online.=($row['battle']>0?'<a target=_blank href=http://'.(strtolower($city_name[$id_other_city])).'.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
	                        				$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'').$kl_status;

								if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
								elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
							  elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }									
								elseif ($row['ruines'] > 0) { $rrm = '�����'; }
							  	elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
								elseif ($row['room'] >= 49998 && $row['room'] <= 60000) {
									include "map_config.php";
									reset($map_locations);
									$bfound = false;
									while(list($k,$v) = each($map_locations)) {
										if ($row['room'] == $v['room']) {
										    	$rrm = $v['name'];
											$bfound = true;
										}
									}
									if (!$bfound) $rrm = '�������'; 
								}
								else { $rrm = $rooms[$row['room']]; }
								$to_print_online.=' - <i>'.$rrm.'</i><BR>';
					 		}
						  else  {
							$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
							$row[hidden]=0; // fix ��� ����������
							$to_print_offline.=nick_hist($row);
							$to_print_offline.=$kl_status;
							$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i><BR>';
						  	}
						}////////////////////
						//������� ������������ �������
						if (($to_print_online!='') or ($to_print_offline!=''))
						{
						echo "<h3>".$city_name[$id_other_city]."</h3>";
						echo $to_print_online;
						echo $to_print_offline;
						}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					//�������:
					if($klan[rekrut_klan]>0)
					{
					  echo '<h3>������ ����</h3>';
					//����- � ���� ������
						$data=mysql_query("SELECT u.*, b.blood, b.type as btype, (select `type` from `effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
											FROM `users` u
											left join `battle` b
											on u.battle = b.id
											WHERE `klan` = '".$recrut['short']."' and id_city={$user[id_city]} order by login asc ;");
						$to_print_online='';
						$to_print_offline='';
						while ($row = mysql_fetch_array($data))
						{
						//if ($row['id'] == $klan['glava']) { $kl_status=" - <font color=#008080><b>����� �����</b></font>"; } else  { $kl_status=" - ".$row['status'];}
						$kl_status=" - ".$row['status'];
						 // �������� ����� ��� ��� � ������� � �� �������
					 	 if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
					 		{

								$to_print_online.='<A HREF="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
								$to_print_online.=nick_hist($row).'&nbsp;';
								$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
								
								//fix blood
								if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }
								
								$to_print_online.=($row['battle']>0?'<a target=_blank href=http://'.(strtolower($city_name[$user[id_city]])).'.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
	                            				$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'').$kl_status;

							  	if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
							  	elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
							  elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }								  	
								elseif ($row['ruines'] > 0) { $rrm = '�����'; }
							  	elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
								elseif ($row['room'] >= 49998 && $row['room'] <= 60000) {
									include "map_config.php";
									reset($map_locations);
									$bfound = false;
									while(list($k,$v) = each($map_locations)) {
										if ($row['room'] == $v['room']) {
										    	$rrm = $v['name'];
											$bfound = true;
										}
									}
									if (!$bfound) $rrm = '�������'; 
								}
							   else { $rrm = $rooms[$row['room']]; }
							$to_print_online.=' - <i>'.$rrm.'</i><BR>';
					 		}
						  else  {
							$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
							$row[hidden]=0; // fix ��� ����������
							$to_print_offline.=nick_hist($row);
							$to_print_offline.=$kl_status;
							$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i><BR>';
						  	}
						}////////////////////
					//������� ������������ �������
						if (($to_print_online!='') or ($to_print_offline!=''))
						{
						echo "<h3>".$city_name[$user[id_city]]."</h3>";
						echo $to_print_online;
						echo $to_print_offline;
						}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//����- � ������ ������
						$data=mysql_query("SELECT  u.*, b.blood, b.type as btype, (select `type` from ".$db_other_city."`effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
											FROM ".$db_other_city."`users` u
                         					left join ".$db_other_city."`battle` b
											on u.battle= b.id
						WHERE u.`klan` = '".$recrut['short']."' and id_city={$id_other_city} order by login asc ;");

						$to_print_online='';
						$to_print_offline='';
						while ($row = mysql_fetch_array($data))
						{
						//if ($row['id'] == $klan['glava']) { $kl_status=" - <font color=#008080><b>����� �����</b></font>"; } else  { $kl_status=" - ".$row['status'];}
						$kl_status=" - ".$row['status'];
						 // �������� ����� ��� ��� � ������� � �� �������
					 	 if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
					 		{
								$to_print_online.='<A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
								$to_print_online.=nick_hist($row).'&nbsp;';
								$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
								
								//fix blood
								if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }
								
								$to_print_online.=($row['battle']>0?'<a target=_blank href=http://'.(strtolower($city_name[$id_other_city])).'.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
	                            				$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'').$kl_status;

							  if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
							  elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
							   elseif ($row['ruines'] > 0) { $rrm = '�����'; }
							  elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
							   elseif ($row['room'] >= 49998 && $row['room'] <= 60000) {
									include "map_config.php";
									reset($map_locations);
									$bfound = false;
									while(list($k,$v) = each($map_locations)) {
										if ($row['room'] == $v['room']) {
										    	$rrm = $v['name'];
											$bfound = true;
										}
									}
									if (!$bfound) $rrm = '�������'; 
								}
							   else { $rrm = $rooms[$row['room']]; }
							$to_print_online.=' - <i>'.$rrm.'</i><BR>';
					 		}
						  else  {
							$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
							$row[hidden]=0; // fix ��� ����������
							$to_print_offline.=nick_hist($row);
							$to_print_offline.=$kl_status;
							$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i><BR>';
						  	}
						}////////////////////
					//������� ������������ �������
						if (($to_print_online!='') or ($to_print_offline!=''))
						{
						echo "<h3>".$city_name[$id_other_city]."</h3>";
						echo $to_print_online;
						echo $to_print_offline;
						}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					}
					//�������� ��� (����� � ������)
					else
					if($klan[base_klan]>0)
					{
						echo '<h3>�������� ����</h3>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
					//����- � ���� ������
						$data=mysql_query("SELECT u.*, b.blood, b.type as btype, (select `type` from `effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
											FROM `users` u
											left join `battle` b
											on u.battle = b.id
											WHERE `klan` = '".$base_klan['short']."' and id_city={$user[id_city]} order by login asc ;");
						$to_print_online='';
						$to_print_offline='';
						while ($row = mysql_fetch_array($data))
						{
						//if ($row['id'] == $klan['glava']) { $kl_status=" - <font color=#008080><b>����� �����</b></font>"; } else  { $kl_status=" - ".$row['status'];}
						$kl_status=" - ".$row['status'];
						 // �������� ����� ��� ��� � ������� � �� �������
					 	 if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
					 		{
								$to_print_online.='<A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
								$to_print_online.=nick_hist($row).'&nbsp;';
								$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
								
								//fix blood
								if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }								
								
								$to_print_online.=($row['battle']>0?'<a target=_blank href=http://capitalcity.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
	                            				$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'').$kl_status;

							  if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
							  elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
							  elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }								  
							   elseif ($row['ruines'] > 0) { $rrm = '�����'; }
							  elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
							   elseif ($row['room'] >= 49998 && $row['room'] <= 60000) {
									include "map_config.php";
									reset($map_locations);
									$bfound = false;
									while(list($k,$v) = each($map_locations)) {
										if ($row['room'] == $v['room']) {
										    	$rrm = $v['name'];
											$bfound = true;
										}
									}
									if (!$bfound) $rrm = '�������'; 
								}
							   else { $rrm = $rooms[$row['room']]; }
							$to_print_online.=' - <i>'.$rrm.'</i><BR>';
					 		}
						  else  {
							$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
							$row[hidden]=0; // fix ��� ����������
							$to_print_offline.=nick_hist($row);
							$to_print_offline.=$kl_status;
							$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i><BR>';
						  	}
						}////////////////////
						//������� ������������ �������
						if (($to_print_online!='') or ($to_print_offline!=''))
						{
						echo "<h3>".$city_name[$user[id_city]]."</h3>";
						echo $to_print_online;
						echo $to_print_offline;
						}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					// ����- � ������ ������
						$data=mysql_query("SELECT  u.*, b.blood, b.type as btype, (select `type` from ".$db_other_city."`effects` where owner = u.id AND type in (11,12,13,14) limit 1) as etype
											FROM ".$db_other_city."`users` u
                         					left join ".$db_other_city."`battle` b
											on u.battle= b.id
						WHERE u.`klan` = '".$base_klan['short']."' and id_city={$id_other_city} order by login asc ;");
						$to_print_online='';
						$to_print_offline='';
						while ($row = mysql_fetch_array($data))
						{
						//if ($row['id'] == $klan['glava']) { $kl_status=" - <font color=#008080><b>����� �����</b></font>"; } else  { $kl_status=" - ".$row['status'];}
						 $kl_status=" - ".$row['status'];
						 // �������� ����� ��� ��� � ������� � �� �������
					 	 if ( ($row['hidden']==0) and ($row['odate']>=(time()-60)) )
					 		{
								$to_print_online.='<A href="#" OnClick="top.AddToPrivate(\''.$row['login'].'\', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock'.($row[battle]>0?'2':'').'.gif" width=20 height=15></A>';
								$to_print_online.=nick_hist($row).'&nbsp;';
								$to_print_online.=($row['slp']>0?'<img src="http://i.oldbk.com/i/sleep2.gif">':'');
								
								//fix blood
								if (($row['btype']==6) and ($row['blood']==0)) { $row['btype']=3; }
								
								$to_print_online.=($row['battle']>0?'<a target=_blank href=http://capitalcity.oldbk.com/logs.php?log='.$row['battle'].'><img src="http://i.oldbk.com/i/fighttype'.$row['btype'].'.gif"></a>':'');
	                            				$to_print_online.=($row['etype']>0?'<img src="http://i.oldbk.com/i/travma2.gif">':'').$kl_status;

							  if($row['room'] > 500 && $row['room'] < 561) { $rrm = '����� ������, ��������� � �������';}
							  elseif ($row['lab'] > 0) { $rrm = '�������� �����'; }
							  elseif ($row['in_tower'] ==3) { $rrm = '�������:��������� ��������'; }								  
							 elseif ($row['ruines'] > 0) { $rrm = '�����'; }
							  elseif ($row['room'] >= 70000 && $row['room'] <= 72000) { $rrm =  '�����'; }
							 elseif ($row['room'] >= 49998 && $row['room'] <= 60000) {
									include "map_config.php";
									reset($map_locations);
									$bfound = false;
									while(list($k,$v) = each($map_locations)) {
										if ($row['room'] == $v['room']) {
										    	$rrm = $v['name'];
											$bfound = true;
										}
									}
									if (!$bfound) $rrm = '�������'; 
								}
							   else { $rrm = $rooms[$row['room']]; }
							$to_print_online.=' - <i>'.$rrm.'</i><BR>';
					 		}
						  else  {
							$to_print_offline.='<img src="http://i.oldbk.com/i/lock1.gif" width=20 height=15>';
							$row[hidden]=0; // fix ��� ����������
							$to_print_offline.=nick_hist($row);
							$to_print_offline.=$kl_status;
							$to_print_offline.=' - <i><small><font color=gray>�������� �� � �����</font></small></i><BR>';
						  	}
						}////////////////////
						//������� ������������ �������
						if (($to_print_online!='') or ($to_print_offline!=''))
						{
						echo "<h3>".$city_name[$id_other_city]."</h3>";
						echo $to_print_online;
						echo $to_print_offline;
						}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


			echo '</td>
				</tr>
			</table></fieldset>';
	}

	function show_use_klan_telegraph($post=null,$get=null,$faction)
	{		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna,$telegr;
		if ($polno[$user['id']][7]==1 || $user['id']==$klan['glava'])
		{
			if((int)$post[teleg]&&$post[gr]&&($post[mass_cl]||$post[mass_rec]))
			{
			   //��������
		               //������� �����.
		               if ($user[money] >= 1 )
		               {
		               		$post[gr]=strip_tags($post[gr]);

               				$rec['owner']=$user[id];
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user[money];
					$user['money'] -= 1;
					$rec['owner_balans_posle']=$user[money];
					$rec['target']=0;
					$rec['target_login']='��������';
					$rec['type']=131;//������ ���������
					$rec['sum_kr']=1;
					$rec['item_count']=0;
					add_to_new_delo($rec);

		                     	mysql_query("UPDATE `users` set money=money-1 WHERE id='".$user[id]."';");
		            		
			               //�������� � ��

			                
			                if($klan[rekrut_klan]>0 || $klan[base_klan]>0)
					{
					//���� ���� ������� ��� ������
				                if($post[mass_cl])  {$i[]="klan =  '".$user[klan]."'";}
		              			if($post[mass_rec]) {$i[]="klan =  '".$telegr."'";}
		               		}
		               		else
		               			{
		               			//���� ��� �������� � ������ �� , ������ ������ ����� - ���  �����
						$i[]="klan =  '".$user[klan]."'";
		               			}
		               		
			                $filtr='';
			                for($g=0;$g<count($i);$g++)
			                {
			                	$filtr.='('.$i[$g] . ') or ';
			                }
			                $filtr = substr($filtr, 0, -4);
		
			               	$querry="SELECT * FROM `users` WHERE ".$filtr." ;";
if ($user['id']==14897)			             
{
echo $querry;
}
			                $rez=mysql_query($querry);
				   	while ($pals = mysql_fetch_assoc($rez)) 
				   	{
						
						telegraph_new($pals,$post['gr'],'1',time()+(7*24*3600));
				   	}
				   	echo '<b><font color=red>��� ���������</font></b><br>';
				}
				else
				{
					echo '<b><font color=red>� ��� ��������� ��. :(</font></b><br>';
				}
		    	}
	            	echo '<fieldset><legend><b>��������: </b></legend>';
		        echo '�� ������ ��������� �������� ��������� ����� ����������� �/��� �������� (����  ��� � ��� ����...) ,
		        	���� ���� ��� ��������� � offline ��� ������ ������.<br>';
				echo '<form method=post style="margin:5px;" action=?'.$faction.'>
				<input name="teleg" type="hidden" value="1">
				C��������: <input type=text size=80 name="gr" maxLength="500">*500 ��������<br> ';
				
	
	 		if($klan[base_klan]>0)
			{
				echo '�������� �����������: <input type="checkbox" name="mass_cl">&nbsp;&nbsp;&nbsp;';
		 		echo '�������� ������'.$rass_name.': <input type="checkbox" name="mass_rec">';
	 		}
		        elseif($klan[rekrut_klan]>0)
			{
				echo '�������� �����������: <input type="checkbox" name="mass_cl">&nbsp;&nbsp;&nbsp;';
				echo '�������� ��������'.$rass_name.': <input type="checkbox" name="mass_rec">';
		        }
		        else
		        	{
		        	echo ' <input type="hidden" name="mass_cl" value=true>';
		        	}
		        
			echo '<br><input type="submit" value="���������"></form>';
			echo '</fieldset><br>';
        	}	}

	function show_use_klan_arsenal($post=null,$get=null,$faction)
	{		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
		if($get[ars]=='takeall')
		{
			Test_Arsenal_Items($user,1);
			echo '<font color=red><b>���� �������</b></font>';
		}
		//backall
		if($get[ars]=='backall')
		{
			Test_Arsenal_Items($user,2);
			echo '<font color=red><b>���� ������</b></font>';
		}
        ///////////////////������ ���� ��������
		if (($klan['glava']==$user['id'] OR $polno[$user['id']][2] == 1) || $user['id'] == 188) {
			echo '<input type="button" value="�������� �������" onclick="location.href=\'klan_arsenal.php\';"><BR/>';
		}
		else{
			echo '<input type="button" value="������� ��� ���� �� ��������" onclick="location.href=\'?'.$faction.'&ars=takeall\';"><BR/>';
		    echo '<input type="button" value="����� ��� ���� � �������" onclick="location.href=\'?'.$faction.'&ars=backall\';"><BR/>';
		}
	}

	function pay_for_clan($post=null,$get=null,$faction)
	{
		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
		if(($klan['glava']==$user['id'] || $polno[$user['id']][3] == 1) && $klan[base_klan]==0) //
 		{
 			$cur_time=time();
 			$summ_topay=30;
 			
 			if($klan[rekrut_klan]>0)
			{
				$summ_topay*=2;
			}
 			//if
 			//������ ������ �����
 			if($get[pay]==1)
 			{
 			
 				if($klan[tax_date]<$cur_time && $klan[tax_timer]>0 || $klan[tax_date]<($cur_time+60*60*24*7) && $klan_kazna )
	 			{
					if($klan_kazna[kr]>$summ_topay)
					{
						by_from_kazna($klan['id'],1,$summ_topay,'(����� �� ����)');
						$id=$klan['id'];
						if($klan[rekrut_klan]>0)
						{
							$id.=','.$klan[rekrut_klan];	
						}
						mysql_query("UPDATE oldbk.clans SET tax_timer=0, tax_date='".($klan[tax_date]+60*60*24*31)."' WHERE id in (".$id.");");
						$klan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.clans WHERE id='".$klan['id']."';"));
						echo '<font color=red><b>�� �������� ����� '.$summ_topay.'��. �� ����� �����.</b></font><br>';
						$klan_kazna[kr]-=$summ_topay;
					}
					else
					{
						echo '<font color=red><b>������������ �����</b></font><br>';
					}
				}
				else
	 			{
	 				echo '<font color=red><b>��� ����...</b></font><br>';
	 			}
					
 			}
 			
 			
 			//������ ���
 			if($klan[tax_date]>$cur_time)
 			//����� �������
 			{
 				echo '<b><font color=red>�������� ����� ������� �� '.date('d-m-y H:i',$klan[tax_date]).'.</font></d>'; 
 				if($klan[tax_date]<($cur_time+60*60*24*7))
 				{
 					if ($klan[tax_date]<$cur_time && $klan[tax_timer]>0 || $klan[tax_date]<($cur_time+60*60*24*7) && $klan_kazna)
					{
						echo '<br><a href="?'.$faction.'&pay=1">�������� ('.$summ_topay.'��.)</a>';
	 				}
 				}
 			}
 			else
 			if($klan[tax_date]<$cur_time && $klan[tax_timer]>0)
 			//��������� ��������� ������ �� ������
 			{
 				$tt=$klan[tax_timer]-$cur_time;
 				//echo $tt;
 				if($tt>60*60*24)
 				{
 					$tt= round(($tt/24/60/60),2);
 					if($tt>4)
 					{
 						$txt='����';
 					}
 					else
 					if($tt>1 && $tt<5)
 					{
 						$txt='���';
 					}
 					else
 					{
 						$txt='����';
 					}
 				}
 				else
 				if($tt<60*60*24 && $tt>0)
 				{
 					$tt= round(($tt/60/60),2);
 					if($tt>4 && $tt<21)
 					{
 						$txt='�����';
 					}
 					else
 					if($tt>1 && $tt<5 || $tt>21 && $tt<25 || $tt<1)
 					{
 						$txt='����';
 					}
 					else
 					{
 						$txt='���';
 					}
 				}
 				
 				
 				echo '<b><font color=red>�� ��������������� ����� �������� '.$tt.' '.$txt.'. �������� �������� �����!.</font></d>';
				if ($klan_kazna)
				{
					echo '<br><a href="?'.$faction.'&pay=1">�������� ('.$summ_topay.'��.)<a>';
 				}
 				else
 				{
 					echo '<br>������� �������� �����.';
 				}

 			}
 			
 		}
	
	
	}
	
	function show_use_klan_kazna($post=null,$get=null,$faction)
	{
		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna,$akkcosts,$strtype,$exp_bonus,$eff_type;
		 $KURS=40;
		
 		if ($klan_kazna)
		   {
		   

		   //��������� ����� = ��� ������� ����� ��� ������!
		   	if ( (isset($post[add])) and (isset($post[add_kr])) )
	       		{
	       		 $post[add_kr_txt]=htmlspecialchars(mysql_real_escape_string($post[add_kr_txt]));
	       		 $gad='block';
	       		 $add_kr=round((floatval($post[add_kr])),2);
	       		  if ($user[money]<$add_kr)
	       		      {
	       		      	err("� ��� ��� � ������� ����� �����!");
	       		      }
	       		  elseif ($post[add_kr_txt]=='')
	       		      {
	       		      	err("������� ����������!");
	       		      }
	       		      else
	       		      {
	       		       if (put_to_kazna($klan['id'],1,$add_kr,"",false,$post[add_kr_txt]))
	       		         {
	                                $rec['owner']=$user[id];
									$rec['owner_login']=$user[login];
									$rec['owner_balans_do']=$user[money];
									$user['money'] -= $add_kr;
									$rec['owner_balans_posle']=$user[money];
									$rec['target']=0;
									$rec['target_login']=$user['klan'];
									$rec['type']=134;//���������� �����
									$rec['sum_kr']=$add_kr;
									$rec['item_count']=0;
									$rec['add_info'] = $post[add_kr_txt];
									add_to_new_delo($rec);
				  					mysql_query("update users set money=(money-{$add_kr}) where id='".$user[id]."';");
	       		            		$klan_kazna[kr]+=$add_kr;
	       		         }
	       		      }
	       		}
	       		else $gad='none';
		   }

		//����� ��� ��� ���� ����� ���� 3
			if (($klan['glava']==$user['id'] OR $polno[$user['id']][3] == 1) )
    			{

				 if ($klan_kazna)
				     {

					if ($klan['glava']==$user['id'])
					   {
					    if ((isset($post[old_kr_pass])) and (isset($post[new_kr_pass])) and (isset($post[chpkrass])))
					      {
					      $dch='block';
					        if (ch_pass_kazna($klan['id'],1,mysql_real_escape_string($post[old_kr_pass]),mysql_real_escape_string($post[new_kr_pass])))
					           {
					           err('������ ��� ���������� ����� �����, ������� ������!');
					           }
					           else
					           {
					           err('������ ����� ������, ��������� ����� ������!');
					           }
					      }
					      else
					      if ((isset($post[old_ekr_pass])) and (isset($post[new_ekr_pass])) and (isset($post[chpekrass])))
					      {
					      $dch='block';
					        if (ch_pass_kazna($klan['id'],2,mysql_real_escape_string($post[old_ekr_pass]),mysql_real_escape_string($post[new_ekr_pass])))
					           {
					           err('������ ��� ��������� ����� �����, ������� ������!');
					           }
					           else
					           {
					           err('������ ����� ������, ��������� ����� ������!');
					           }
					      }
					      else $dch='none';
					   }

					 if (((isset($post[give_kr])) and ($post[give_kr]!='')) and ((isset($post[give_kr_login])) and ($post[give_kr_login]!='') ) and (isset($post[give])) )
					 {
					 $post[give_kr_login]=htmlspecialchars(mysql_real_escape_string(trim($post[give_kr_login])));
					 $post[give_kr_txt]=htmlspecialchars(mysql_real_escape_string($post[give_kr_txt]));
					 $gkd='block';
					  if ($post[give_kr_pass]=='')
					   {
					   err("������� ������ ������� � ���������� ����� �����!");
					   }
					   elseif ($post[give_kr_txt]=='')
					   {
					   err("������� ����������!");
					   } 
					 else
					 {
					  $give_kr=round((floatval($post[give_kr])),2);
					  if ($give_kr>0)
					   {
					    $get_soklan=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE klan='{$user[klan]}'  and id_city='{$user[id_city]}' and login='".$post[give_kr_login]."' LIMIT 1;"));
					    if ($get_soklan[id]>0)
					     {
					        $kkr_out=(give_to_skol_from_kazna($klan['id'],$get_soklan,$give_kr,1,mysql_real_escape_string($post[give_kr_pass]),$post[give_kr_txt]));
					        if ($kkr_out)
					           {
					           err("�������� ������� ���������!");
					            unset($post[give_kr_login]);
					            unset($give_kr);
					            unset($post[give_kr_txt]);
					            $klan_kazna[kr]-=$kkr_out;
					           }
					     }
					     else
					     err("������ ���������� ��� � ���� ������!");
					   }
					  }
					 }
					 else $gkd='none';

						/*
					  if (((isset($post[give_ekr])) and ($post[give_ekr]!='')) and ((isset($post[give_ekr_login])) and ($post[give_ekr_login]!='') ) and (isset($post[giveb])) )
					   {
					   $ged='block';
					    $post[give_ekr_login]=htmlspecialchars(mysql_real_escape_string(trim($post[give_ekr_login])));
					    $post[give_ekr_txt]=htmlspecialchars(mysql_real_escape_string($post[give_ekr_txt]));
   					  if ($post[give_ekr_pass]=='')
					   {
					   err("������� ������ ������� � ��������� ����� �����!");
					   }
					   else
					   {
					      $give_bank=(int)($post[give_bank]);
					       if ($give_bank <=0)
					      {
					       err("������� ����� ����� ����������!");
					      }
					      else
					      {
					      $give_ekr=round((floatval($post[give_ekr])),2);
					       if ($give_ekr>0)
					        {
					        $get_soklan=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE klan='{$user[klan]}' and login='".$post[give_ekr_login]."' LIMIT 1;"));
					        if ($get_soklan[id]>0)
					         {
	     					    $get_soklan_bank=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE  owner='{$get_soklan[id]}' and id={$give_bank}  LIMIT 1;"));
	     					        if ($get_soklan_bank[id]>0)
	     					         {
	     					         $get_soklan[ekr_bank_id]=$get_soklan_bank[id];
	     					         $get_soklan[ekr_bank_ekr]=$get_soklan_bank[ekr];
	     					            $kkr_out=(give_to_skol_from_kazna($klan['id'],$get_soklan,$give_ekr,2,mysql_real_escape_string($post[give_ekr_pass]),$post[give_ekr_txt]));
					        		if ($kkr_out)
							           {
							           err("�������� ������� ���������!");
							            unset($post[give_ekr_login]);
							            unset($give_ekr);
							            unset($give_bank);
							            unset($post[give_ekr_txt]);
							            $klan_kazna[ekr]-=$kkr_out;
							           }
	     					         }
	     					         else
         						  err("������ ���� �������� ��� ������������� ������ ����������!");
					         }
					         else
						  err("����� ���������� �� ������!");
					       }
					       }
					    }
					   } else $ged='none';
					   */

					if (((isset($post[�hange_ekr])) and ($post[�hange_ekr]!='')) and (isset($post[�hange])) )
					{
					$gcd='block';
					if ($post[�hange_ekr_pass]=='')
					   {
					   err("������� ������ ������� � ��������� ����� �����!");
					   }
					   else
					   {
					    $�hange_ekr=round((floatval($post[�hange_ekr])),2);
					       if ($�hange_ekr>0)
					        {
					         $kkr_out=�hange_ekr_kazna($klan['id'],$�hange_ekr,EKR_TO_KR,mysql_real_escape_string($post[�hange_ekr_pass]));
					          if ($kkr_out)
							           {
							           err("�������� ������� ���������!");
							            unset($�hange_ekr);
							            $klan_kazna[ekr]-=$kkr_out[dekr];
							            $klan_kazna[kr]+=$kkr_out[dkr];
							           }

					        }
					   }
					} else $gcd='none';

/*
					  if (((isset($post[silver_bank])) and ((int)($post[silver_bank])>0)) and ((isset($post[silver_login])) and ($post[silver_login]!='') ) and (isset($post[silver])) )
					 {

					 $gsd='block';
					 $acctype=(int)$post[acctype];	
					 $post[silver_login]=htmlspecialchars(mysql_real_escape_string(trim($post[silver_login])));
					 $silver_bank=(int)($post[silver_bank]);
					 $akkcost=$akkcosts[$acctype];
					$string_p[1]='Silver';
					$string_p[2]='Gold';
					$string_p[3]='Platinum';
					
					 if (!($acctype>=1 AND $acctype<=3))
					 	{
 						   err("������� ��� ������� ��������!");
					 	}
					 else
					 if ($post[silver_pass]=='')
					   {
					   err("������� ������ ������� � ��������� ����� �����!");
					   }
					   else if ($post['silver_pass'] != $klan_kazna['ekr_pass']) {
						   err("������ ������� � ����� �� �����!");
					   } else if ($akkcost>$klan_kazna[ekr])
					   {
					   err("� ����� �� ������� ������ ��� ������!");
					   }
					   else
					   {
					   $get_soklan=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE klan='{$user[klan]}' and id_city='{$user[id_city]}' and login='".$post[silver_login]."' LIMIT 1;"));
					        if ($get_soklan[id]>0)
					        {
			        		    if 	($get_soklan[prem]>$acctype)
					        	{
					        	err('�� �� ������ ���������� '.$string_p[$acctype].' account, � ����� ��������� ��� ���������� '.$string_p[$get_soklan[prem]].'  account!');
					        	}
					        else if ($akkcost>0)
					        {
					       // echo "Start";
					       // echo $akkcost;
					        
					         $get_soklan_bank=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE  owner='{$get_soklan[id]}' and id={$silver_bank}  LIMIT 1;"));
	     					        if ($get_soklan_bank[id]>0)
	     					         {

	     					         //������ �� ��� ����
	     					         $dill[id_city]=$user[id_city];
							 $dill[id]=450;
							 $dill[login]='KO';
	     					         $exp=main_prem_akk($get_soklan,$acctype,$dill);
						          //echo "EXP".$exp;
						          if ($exp>0)
							           {
							         //�������� ����� � �����  
			          				mysql_query("UPDATE oldbk.clans_kazna set ekr=ekr-{$akkcost} WHERE `clan_id` = '{$klan_kazna[clan_id]}' ;");
			          				//echo "Er1:".mysql_error();
								mysql_query("UPDATE oldbk.`bank` set `ekr` = (ekr+5) WHERE `id` = '{$get_soklan_bank['id']}' LIMIT 1;");
			          				//echo "Er2:".mysql_error();								
								mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date`, `text` , `bankid`) VALUES ('".time()."','�������� <b>5 ���.</b> �� \'{$user[login]}\' ��� ������� ".$string_p[$acctype]." ��������, <i>�����:".($get_soklan_bank[ekr]+5)." ���.</i> ','{$get_soklan_bank['id']}');");
			          				//echo "Er3:".mysql_error();								
							         
					    			$rec['owner']=$get_soklan[id];
								$rec['owner_login']=$get_soklan[login];
								$rec['owner_balans_do']=$get_soklan['money'];
								$rec['owner_balans_posle']=$get_soklan['money'];
								$rec['target']=$user[id];
								$rec['target_login']=$user[login];
								$actty[1]=59;
								$actty[2]=359;
								$actty[3]=358;					
								$rec['type']=$actty[$acctype] ;//������� silvera/gold/platinum �� �������
								$rec['sum_kr']=0;
								$rec['sum_ekr']=$akkcost;
								$rec['sum_kom']=0;
								$rec['item_id']='';
								$rec['item_name']='';
								$rec['item_count']=0;
								$rec['item_type']=0;
								$rec['item_cost']=0;
								$rec['item_dur']=0;
								$rec['item_maxdur']=0;
								$rec['item_ups']=0;
								$rec['item_unic']=0;
								$rec['item_incmagic']='';
								$rec['item_incmagic_count']='';
								$rec['item_arsenal']='';
								$rec['bank_id']=$get_soklan_bank['id'];
								$rec['add_info']=(date('d-m-Y',$exp)). '. ������ ����� �� '.$get_soklan_bank[ekr]. ' ����� ' .($get_soklan_bank[ekr]+5);
								add_to_new_delo($rec); //�����
								$message="<font color=red>��������!</font> ��� ��������  ".$string_p[$acctype]." account ����������� ".$user[login]." � ���������� 5 ���. �� ��� ���� �\"".$get_soklan_bank['id']."\". ";
								telepost_new($get_soklan,$message);
								$txt="\"".$user['login']."\", ���������/������� ".$string_p[$acctype]."  account ���������� {$get_soklan[login]}, �����:".$akkcost." ���. ";
						            	txt_to_kazna_log(3,2,$klan_kazna[clan_id],$txt);  

						           		err("�������� ������� ���������!");
							            unset($silver_bank);
							            unset($post[silver_login]);
							            $klan_kazna[ekr]-=$akkcost;
							           }
	     					         }
	     					         else
         						  err("������ ���� �������� ��� ������������� ������ ����������!");
         					   }
         					   else
         					   {
         					   err("������!");
         					   }
					        }
					        else
						  err("����� ���������� �� ������ � ���� ������!");
					   }
					 }
					 else $gsd='none';
					 */
////////////////////////////////
			if (($klan['glava']==$user['id'] OR $polno[$user['id']][4] == 1) )
					{

					if ((isset($post[yesvau])) and ((int)($post[vauid])>0) )
					 {
							 	if ( (isset($post[vaupass])) AND  ($klan_kazna[kr_pass]==$post[vaupass]))
							 	{
								 //���������
								 //���� �������
								 $itemid=(int)$post[vauid];
							 	if ($itemid>0)
							 		{
							 		$get_item=mysql_fetch_array(mysql_query("select i.*, pre.owner as powner from oldbk.inventory i LEFT JOIN oldbk.clans_preset pre ON i.id=pre.itemid where pre.itemid='{$itemid}' and pre.klanid='{$klan[id]}' and i.owner=460"));
							 			if ($get_item[id]>0)
							 			{
							 			//��������� ����� �� �������� �� �������							 			
							 		       $need_kr=$get_item[ecost]*$KURS;
							 			if (($need_kr<=$klan_kazna[kr]) and ($need_kr>0))
							 			{
							 			//������� �� ��������
							 			mysql_query("DELETE FROM oldbk.`clans_preset` WHERE `itemid`='{$itemid}' and klanid='{$klan[id]}' LIMIT 1; ");
								 			if(mysql_affected_rows()>0)
							 				{
							 				//������� ��  ��������� � ������� 460-�������
								 			mysql_query("DELETE FROM oldbk.inventory  WHERE `id`='{$itemid}' and owner=460  LIMIT 1; ");
									 			if(mysql_affected_rows()>0)
									 				{
									 				mysql_query("UPDATE oldbk.clans_kazna set kr=kr-{$need_kr}, ekr=ekr+{$get_item[ecost]}  WHERE `clan_id` = '{$klan[id]}' ;");
									 				$klan_kazna[ekr]+=$get_item[ecost];
									 				$klan_kazna[kr]-=$need_kr;									 				
									 				
										 			if(mysql_affected_rows()>0)
										 				{
									 						$gtelo=mysql_fetch_array(mysql_query("select * from oldbk.users where id ='{$get_item[powner]}'  "));
										 					if ($gtelo[id_city]==1) 
										 						{ 
										 							$dbc='avalon.' ; 
										 							$gtelo=mysql_fetch_array(mysql_query("select * from avalon.users where id ='{$get_item[powner]}'  "));
										 							 } else { $dbc='oldbk.' ; }
										 				
										 				//����� � ��� �����
										 				$txt1="\"{$user[login]}\" ���������� ������� ������� �� <b>$get_item[ecost]</b> ���. ���������  \"{$gtelo[login]}\" ��������� <b>{$need_kr} ��.</b>   ";
										 				$txt2="\"{$user[login]}\" �������� ����� �������� �� <b>$get_item[ecost]</b> ���. ";
										 				
										 				mysql_query("INSERT INTO oldbk.`clans_kazna_log` (`method` ,`ktype`, `clan_id`, `owner`, `target`, `kdate`)   VALUES  ('2','1','{$klan[id]}','{$user[id]}','".$txt1."','".time()."'), ('1','2}','{$klan[id]}','{$user[id]}','".$txt2."','".time()."')   ;");
										 				
										 				//��� ���������
										 				//����������� ���� �����

										 					mysql_query("UPDATE {$dbc}users set money=money+{$need_kr} where id ='{$get_item[powner]}'  LIMIT 1;");
												 			if(mysql_affected_rows()>0)										 					
												 			{
												 			//����� � ���� � ���������� ������
								 					 	        $rec['owner']=$gtelo[id];
															$rec['owner_login']=$gtelo[login];
															$rec['owner_balans_do']=$gtelo['money'];
															$rec['owner_balans_posle']=$gtelo['money']+$need_kr;
															$rec['target']=0;
															$rec['target_login']='����� '.$klan['short'];
															$rec['type']=342;//������� �� �� ����� �� �������� ������
															$rec['sum_kr']=$need_kr;
															$rec['sum_ekr']=0;
															$rec['sum_kom']=0;
															$rec['item_id']='';
															$rec['item_name']='';
															$rec['item_count']=0;
															$rec['item_type']=0;
															$rec['item_cost']=0;
															$rec['item_dur']=0;
															$rec['item_maxdur']=0;
															$rec['item_ups']=0;
															$rec['item_unic']=0;
															$rec['item_incmagic']='';
															$rec['item_incmagic_count']='';
															$rec['item_arsenal']='';
															$rec['add_info']=$klan['short'];
														        add_to_new_delo($rec); 
												 			$message="<font color=red>��������!</font> �������� \"{$user[login]}\" ������� ���� ������ �� ������� ������� <b>{$get_item[ecost]} ���.</b> � ������� <b>".$need_kr." ��.</b> �� �������� ����� \"".$klan['short']."\". ";
															telepost_new($gtelo,$message);
											 				err("������ �� ������� ������� <b>{$get_item[ecost]} ���.</b> ������� ��������.<br>
											 				��������� \"{$gtelo[login]}\" ���������� <b>$need_kr ��</b> �� �������� �����.<br>");
												 			}
										 					
										 				}
									 				
									 				}
							 				}
							 			}
							 			else
							 			{
							 			err("��� ���������� �������� ������������ ����� � �������� ����� �����!");
							 			}
							 			
							 			}
							 			else
							 			{
							 			err("����� ������ �� ������!");
							 			}
							 		}
							 	}
							 	else
							 	{
							 	err('�� ������ ������ �� ������� �����!');
							 	}
							 }
							 else if (isset($post[novau]))
							 {
							 // ����������
							 $itemid=(int)$post[vauid];
								if ($itemid>0)
								{
						 		$get_item=mysql_fetch_array(mysql_query("select i.*, pre.owner as powner from oldbk.inventory i LEFT JOIN oldbk.clans_preset pre ON i.id=pre.itemid where pre.itemid='{$itemid}' and pre.klanid='{$klan[id]}' and i.owner=460"));
				 					
				 					if ($get_item[id]>0)
				 						{
					 					mysql_query("UPDATE `oldbk`.`inventory` SET `owner`='{$get_item[powner]}'  WHERE `id`='{$get_item[id]}' LIMIT 1;");
					 					
					 					if(mysql_affected_rows()>0)										 					
												{
									 			mysql_query("DELETE FROM oldbk.`clans_preset` WHERE `itemid`='{$itemid}' and klanid='{$klan[id]}' LIMIT 1; ");
												
												 //����� � ���� � ���������� ������
						 						$gtelo=mysql_fetch_array(mysql_query("select * from oldbk.users where id ='{$get_item[powner]}'  "));
							 					if ($gtelo[id_city]==1) { $gtelo=mysql_fetch_array(mysql_query("select * from avalon.users where id ='{$get_item[powner]}'  "));} 
												 			
								 					 	        $rec['owner']=$gtelo[id];
															$rec['owner_login']=$gtelo[login];
															$rec['owner_balans_do']=$gtelo['money'];
															$rec['owner_balans_posle']=$gtelo['money'];
															$rec['target']=0;
															$rec['target_login']='����� '.$klan['short'];
															$rec['type']=341;
															$rec['sum_kr']=0;
															$rec['sum_ekr']=0;
															$rec['sum_rep']=0;					
															$rec['sum_kom']=0;
															$rec['item_id']=get_item_fid($get_item);
															$rec['item_name']=$get_item[name];
															$rec['item_count']=1;
															$rec['item_type']=$get_item[type];
															$rec['item_cost']=$get_item[cost];
															$rec['item_dur']=$get_item[duration];
															$rec['item_maxdur']=$get_item[maxdur];
															$rec['item_ups']=0;
															$rec['item_unic']=0;
															$rec['item_incmagic']='';
															$rec['item_incmagic_count']='';
															$rec['item_arsenal']='';
															$rec['add_info']=$klan['short'];
														        add_to_new_delo($rec); 
												 			$message="<font color=red>��������!</font> �������� \"{$user[login]}\" �������� ���� ������ �� ������� ������� <b>{$get_item[ecost]} ���.</b> � �������� ����� \"".$klan['short']."\". ";
															telepost_new($gtelo,$message);
															err("������ ��������� ��������� \"{$gtelo[login]}\" � ������� ������� <b>{$get_item[ecost]} ���. !");
												 }
												 
					 					}
					 					else
							 			{
							 			err("����� ������ �� ������!");
							 			}
				 				}
							 
							 
							 }					 
					 }
					 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<br><center><b>�������� �����: <FONT COLOR='#339900'>".$klan_kazna[kr]."</FONT> ��, <FONT COLOR='#339900'>".$klan_kazna[ekr]."</FONT> ���.</b></center>";
	echo "<table border=0  width=100%>";
	echo "<tr valign=top>";
		echo "<td width=50%>";
		
					echo "<BR><fieldset ><legend align=center><b>�������� �����:</b></legend>";
					echo "<table width=100%>";
					echo "<tr><td width=45% align=center>";
					echo "<a href=\"#\" onClick=\"getformdata(131,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_kr_in_2.png' title='��������� �����'></a>";
					echo "</td><td width=10%>&nbsp;</td><td width=45%>";
					echo "<a href=\"#\" onClick=\"getformdata(132,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_kr_out_2.png' title='������ �� �����'></a>";
					echo "</td></tr></table>";					
					echo "</fieldset >";		

		if (($klan['glava']==$user['id'] OR $polno[$user['id']][4] == 1) )
				{
					echo "<BR><fieldset ><legend align=center><b>������������:</b></legend>";
					
					if ($klan['glava']==$user['id'])
						{
						echo "<table width=100%>";
						echo "<tr><td width=45% align=center>";
						echo "<a href=\"#\" onClick=\"getformdata(141,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_log_2.png' title='��� �����'></a>";
						echo "</td><td width=10%>&nbsp;</td><td width=40%>";
						echo "<a href=\"#\" onClick=\"getformdata(142,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_pass_2.png' title='������� ������'></a>";
						echo "</td></tr></table>";					
						echo "</fieldset >";		
						}
						else
						{
						echo "<table width=100%>";
						echo "<tr><td width=100% align=center>";
						echo "<a href=\"#\" onClick=\"getformdata(141,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_log_2.png' title='��� �����'></a>";
						echo "</td></tr></table>";					
						echo "</fieldset >";		
						}
				}	

		echo "</td>";
		echo "<td width=2% >&nbsp;";
		echo "</td>";
		echo "<td width=50%>";		
		
					echo "<BR><fieldset ><legend align=center><b>������� �����:</b></legend>";
					
					/*
					if (($klan['glava']==$user['id'] OR $polno[$user['id']][4] == 1) )
						{
						$awidth=26;
						$ashow=true;
						}
						else
						{
						$awidth=45;						
						}
					*/
					$awidth=100;						
					echo "<table width=100%>";
					echo "<tr><td width={$awidth}% align=center>";
					//echo "<a href=\"#\" onClick=\"getformdata(151,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_ekr_out_2.png' title='��������� ��� �� ����'></a>";
					//echo "</td><td width=10%>&nbsp;</td><td width={$awidth}% align=center>";
					echo "<a href=\"#\" onClick=\"getformdata(152,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_ekr_kr_2.png' title='�������� ��� �� �������'></a>";
					echo "</td>";
					
					/*if ($ashow)
						{
						echo "<td width=10%>&nbsp;</td><td width={$awidth}% align=center>";
						
						$get_all_vau=mysql_query("SELECT * FROM `oldbk`.`clans_preset` where klanid='{$klan[id]}' ORDER BY `pdate` ;");
						if(mysql_num_rows($get_all_vau)>0)
							{
							echo "<a href=\"#\" onClick=\"getformdata(171,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_lot_in_2.gif' title='������ �� ����� ��������'></a>";
							}
							else
							{
							echo "<a href=\"#\" onClick=\"getformdata(171,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_lot_2.png' title='������ �� ����� ��������'></a>";
							}
						echo "</td>";
						}
						*/
					
					echo "</tr></table>";					
					echo "</fieldset >";		
					echo "<br>";
					
					echo "<table border=0 width=100% >";
					echo "<tr valign=top><td width=100%>";

					echo "<fieldset style=\"text-align:justify; width:500px; height:220;\">";
					echo "<legend align=center><b>��������� ��� ����� � �������:</b></legend>";

					echo "<div align=center>";

					print_paysyst();


					echo "</div>";					
					
					echo "</fieldset >";					
					
					echo "</td></tr></table>";
						

		
		echo "</td>";		


		if (($klan['glava']==$user['id'] OR $polno[$user['id']][4] == 1) )
					   {
					   show_logs_kazna($klan);
					    }


		echo "</tr></table>";


				     }
				     else
				     {
				       $test_ban=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.clans_kazna WHERE `clan_id` = '{$klan['id']}' and ban=1 ;"));
				      if (!$test_ban[ban])
				      {
      				        if ((isset($post[make])) AND (isset($post[kr_pass])) and (isset($post[ekr_pass])) AND (isset($post[make])))
       				        {
       				        make_clan_kazna($klan['id'],mysql_real_escape_string($post[kr_pass]),mysql_real_escape_string($post[ekr_pass]));
       				        }
				       else
				       if ((isset($get[kazna])) AND ($get[kazna]=='start'))
				       {
				       //from make kazna
				       echo "<form method=post>";
				       echo "������ ������� ��� ���������� �����:<input type=text name=kr_pass size=12 maxlength=12><br>";
				       echo "������ ������� ��� ��������� �����:<input type=text name=ekr_pass size=12 maxlength=12><br>";
				       echo "<input type=submit name=make value='������� �������� �����'>";
				       echo "</form>";
				       }
				       else
				       {
				       echo '<input type="button" value="������� �������� �����" onclick="location.href=\'?'.$faction.'&kazna=start\';"><BR/>';
				       }
				       }
				       else
				       {
				       echo "<font color=red><b>���� ����� �������� ����������!</b>".$test_ban[ban_txt]."</font>";
				       }
				     }
			}
			else
			{
				// ��������� ������ ������� - ������� � ����� ���������
				 if ($klan_kazna)
				    {
				echo "<center>";
				echo "<br><b>�������� �����: <FONT COLOR='#339900'>".$klan_kazna[kr]."</FONT> ��, <FONT COLOR='#339900'>".$klan_kazna[ekr]."</FONT> ���.</b><br>";
				
    				echo "<br><fieldset  style=\"width:300px; height:130px;\"><legend align=center><b>�������� �����:</b></legend>";
				echo "<br><a href=\"#\" onClick=\"getformdata(131,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_kr_in1.png' title='��������� �����'></a>";
				
				if ($polno[$user['id']][4] == 1)
				{
				echo "<a href=\"#\" onClick=\"getformdata(141,0,event);\"><img src='http://i.oldbk.com/i/kazna/kazna_log_2.png' title='��� �����'></a>";
				}
				
				echo "</fieldset>";
				
				echo "<br>";
				
				echo "<fieldset style=\"text-align:justify; width:500px; height:220;\">";
    				echo "<legend align=center><b>��������� ��� ����� � �������:</b></legend><br>";
				echo "<div align=center>";

				print_paysyst();
				echo "</div>";					
					
				echo "</fieldset >";	

				
				
					if ($polno[$user['id']][4] == 1) 
					   {
					echo "<br><table><tr>";					   
					   show_logs_kazna($klan,true);
			  		echo "</tr></table>";
					    }
				echo "</center>";				    
				    }
				    else
				    {
				     echo "<BR><fieldset ><legend><b>�������� �����:</b></legend>";
				     echo "� ������ ����� ���� ��� �����!";
				     echo "</fieldset>";
				    }

			}


    }

	function work_with_klan_chennels($post=null,$get=null,$faction)
    {       global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
       $get[mkdel�]=(int)$get[mkdel�];

		if ($get[mkdel�] >0)
		{
			if (mysql_query("delete FROM oldbk.chat_chanels where  id='".($get[mkdel�])."' and ( (clan1='".$user['klan']."') or (clan2='".$user['klan']."')    ) ;"))
			{
				echo "<b><font color=red>������ ������.</font></b>";
			}
			 else {echo "<b><font color=red>������ ��������.</font></b>";	}
		}

		else
		if ((int)$get[mkdel] >0 )
		{
		$get[mkdel]=(int)$get[mkdel];
			if (mysql_query("delete FROM oldbk.chat_chanels where  id='".($get[mkdel])."' and ( (clan1='".$user['klan']."') or (clan2='".$user['klan']."')    ) ;"))
			{
				echo "<b><font color=red>������ ������.</font></b>";
					// ������� ������� ������ ���� ����� �������� ��� - ���� ��������
				if (isset($get[delchanl]))
				{
					$Kcha = mysql_query("SELECT `mname`, `user` FROM oldbk.`chanels` WHERE `klan`='".$user['klan']."' ;");
					while ($rows = mysql_fetch_array($Kcha))
					{
						$chnls = explode(",",$rows[mname]);
						if(in_array((int)($get[delchanl]),$chnls))
						{
							if ($rows[mname]!='')
							{
								$new_mname=$rows[mname];
								$new_mname = str_replace(",".(int)($get[delchanl]),"",$new_mname);
								$new_mname = str_replace((int)($get[delchanl]).",","",$new_mname);
								$new_mname = str_replace((int)($get[delchanl]),"",$new_mname);

								mysql_query("UPDATE oldbk.`chanels`  SET `mname`='".$new_mname."' WHERE `klan`='".$user['klan']."' AND `user` = '".$rows[user]."';");
							}
						}
					}
				}
		//
			}
	 		else
	 		{
	 			echo "<b><font color=red>������ ��������.</font></b>";
	 		}
		}
		else
		if( ($post['savechatmklan']) and ($post['chatmkaln']!='') and ($post['chatmkalnpass']!='')  )
		{
			if( $post['chatmkaln']==$user['klan'])
			{
					echo "<b><font color=red>��� �� ��� ���� :)</font></b>";
			}
			else
			{
				$mk_test=mysql_fetch_array(mysql_query("select * from oldbk.clans where short='".$post['chatmkaln']."';"));
					if ($mk_test[0])
					{

					//clan is found
						$mk_test2=mysql_fetch_array(mysql_query("select * from oldbk.chat_chanels where  (clan1='".$user['klan']."' and clan2='".$mk_test[short]."') or (clan2='".$user['klan']."' and clan1='".$mk_test[short]."')  ;"));
					  	if ($mk_test2[0])
						{
							echo "<b><font color=red>����� ���� ��� ����!</font></b>";
						}
						else
						{


						//get chatnom
							$chatnom=(int)($post[chatnom]);
							$chnls = explode(",",$klan[chat]);
							if(in_array($chatnom,$chnls))
							  {

								$mk_test4=mysql_fetch_array(mysql_query("select * from oldbk.chat_chanels
									where  (clan2='".$user['klan']."' and chanel2='".$chatnom."')
									or (clan1='".$user['klan']."' and chanel='".$chatnom."')  ;"));
								if ($mk_test4[0])
								{
									echo "<b><font color=red>� ��� ���� ����� �����, �� �������� ������ �������������� �����.</font></b>";
								}
								else
								{
									//save mklan chat
									mysql_query("INSERT oldbk.chat_chanels (clan1,clan2,pass,chanel) values ('".$user['klan']."','".$mk_test[short]."','".$post['chatmkalnpass']."','".$chatnom."') ; ");
									//�������� ������ �����

									$Kcha = mysql_fetch_array(mysql_query("SELECT `mname` FROM oldbk.`chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';"));
									$chnls = explode(",",$Kcha[mname]);
									if(!in_array($chatnom,$chnls))
									{
										if ($Kcha[mname]!='') {	$new_mname=$Kcha[mname].",".$chatnom; } else {$new_mname=$chatnom; }
										mysql_query("UPDATE oldbk.`chanels`  SET `mname`='".$new_mname."' WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';");
									}
									//
								}
							  }
							  else
							  {
								echo "<b><font color=red>������ ������ � ��� ���!</font></b>";
							  }

						}

					}
					else
					{
						echo "<b><font color=red>������ ����� �� ��������!</font></b>";
					}
	  		}
		}
		else if (($post[confmkalnpass]) and ($post[confmkid]>0))
		{
		    $post[confmkid]=(int)$post[confmkid];
			$mk_confim=mysql_fetch_array(mysql_query("select * from oldbk.chat_chanels where  clan2='".$user['klan']."' and id='".(int)$post[confmkid]."' and active=0  and pass='".$post[confmkalnpass]."'  ;"));
			if ($mk_confim[0])
			{
			//get chek chanel
				$chnls = explode(",",$klan[chat]);
				$tochanl=(int)($post['tochanl']);
				if(in_array($tochanl,$chnls))
				{

					$mk_confim_test=mysql_fetch_array(mysql_query("select * from oldbk.chat_chanels where (clan2='".$user['klan']."' and chanel2='".$tochanl."') or (clan1='".$user['klan']."' and chanel='".$tochanl."')  ;"));
					if ($mk_confim_test[0])
					{
						echo "<b><font color=red>����� $tochanl - � ��� �����, �� �������� ������ �������������� �����.</font></b>";
					}
					else
					{
						///UPDATE all is good
						mysql_query("update oldbk.chat_chanels set active=1, chanel2='".$tochanl."' where  clan2='".$user['klan']."' and id='".(int)$post[confmkid]."' and pass='".$post[confmkalnpass]."'  ; ");
						echo "<b><font color=red>������ ������!</font></b>";
						//�������� ������ �����

						$Kcha = mysql_fetch_array(mysql_query("SELECT `mname` FROM oldbk.`chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';"));
						$chnls = explode(",",$Kcha[mname]);
						if(!in_array($tochanl,$chnls))
						{
							if ($Kcha[mname]!='') {	$new_mname=$Kcha[mname].",".$tochanl;} else {$new_mname=$tochanl;}
							mysql_query("UPDATE oldbk.`chanels`  SET `mname`='".$new_mname."' WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';");
						}
					}
				}
				else
				{
					echo "<b><font color=red>� ��� ��� ������ ������, �� �������� ������ �������������� �����.</font></b>";
				}
			}
			else
			{
				echo "<b><font color=red>������������ ������ �������!</font></b>";
			}


		}
		else if ($post[getnewchanel])
		{
			if($klan_kazna[kr] >= 100)
			{
				$chnls = explode(",",$klan[chat]);
				$i=count($chnls);
				if ($i>=10)
				{
					echo "<b><font color=red>��������� ������ �������!</font></b>";
				}
				else
				{
				if (by_from_kazna($klan['id'],1,100,'(�������  ��������������� ������������ ������)'))
					{
					echo "<b><font color=red>�� ������ �������������� ����������� �����.</font></b>";
					$klan[chat]=$klan[chat].",".($i);
						/*
					    $rec['owner']=$user[id];
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user[money];
						$user['money'] -= 100;
						$rec['owner_balans_posle']=$user[money];
						$rec['target']=0;
						$rec['target_login']='������� ������';
						$rec['type']=132;//������ �����
						$rec['sum_kr']=100;
						$rec['item_count']=0;
						add_to_new_delo($rec);
						*/
					mysql_query("update oldbk.`clans` set `chat` = '".$klan[chat]."' WHERE `id` = '".$klan[id]."';");
					}
				}

			}
			else
			{
				echo "<b><font color=red>�� ������� ����� � ����� �����. !</font></b>";
			}
		}
		else if($post[save_defch])
		{
			if(($polno[$user['id']][0]==1) OR ($klan['glava']==$user['id']))
			{
					
					$defch=(int)$post[defch];
					mysql_query("UPDATE oldbk.clans SET defch='".$defch."' WHERE id='".$klan[id]."';");
					$klan[defch]=$defch;
					
			}
		
		}

		{
			echo "<BR><fieldset ><legend><b>����������� ������:</b></legend>";
				///
			$my_clan_list= mysql_query("select * from oldbk.chat_chanels where clan1='".$klan['short']."' or clan2='".$klan['short']."' order by active DESC , chanel  ;");

			while ($rows = mysql_fetch_array($my_clan_list))
			{
				echo "<form name=fnmk$rows[id] action=\"?".$faction."\" method=POST><input type=hidden name=confmkid value=$rows[id]> \n";

				if ($rows[clan1]==$klan['short'])
				{
				//� ��������
					echo "�����:$rows[chanel]; ";
					echo "<img src='http://i.oldbk.com/i/klan/".$rows[clan1].".gif'> $rows[clan1] -  <img src='http://i.oldbk.com/i/klan/".$rows[clan2].".gif'>$rows[clan2]";
					if ($rows[active]==1) { echo "- <i>��������</i><a href='?razdel=maintains&mkdel=$rows[id]&delchanl=$rows[chanel]'><img src='http://i.oldbk.com/i/clear.gif' title='�������' alt='�������' ></a>";}
					else { echo " - <i>��������� �������������</i> "; echo "<a href='?razdel=maintains&mkdel=$rows[id]&delchanl=$rows[chanel]'><img src='http://i.oldbk.com/i/clear.gif' title='�������' alt='�������'></a> ";}
				}
				elseif ($rows[clan2]==$klan['short'])
				{
					//�������
					if ($rows[active]==1)
								{
								echo "�����:$rows[chanel2]; ";
								echo "<img src='http://i.oldbk.com/i/klan/".$rows[clan1].".gif'> $rows[clan1] - <img src='http://i.oldbk.com/i/klan/".$rows[clan2].".gif'>$rows[clan2]";
								echo "- <i>�����������</i><a href='?razdel=maintains&mkdel=$rows[id]&delchanl=$rows[chanel2]'><img src='http://i.oldbk.com/i/clear.gif' title='�������' alt='�������'></a>";
								}
					else
					 {
					echo "<img src='http://i.oldbk.com/i/klan/".$rows[clan1].".gif'> $rows[clan1] - <img src='http://i.oldbk.com/i/klan/".$rows[clan2].".gif'>$rows[clan2]";
					echo ' - ������ : <input type=password value="" name=confmkalnpass size=12>, ����� :<input type=text value="0" name=tochanl size=4> <INPUT TYPE="submit" value=">>">  ';echo "<a href='?razdel=maintains&mkdel�=$rows[id]'> <img src='http://i.oldbk.com/i/clear.gif' titel='�������' alt='�������' > </a>\n";
					}
	      		}


				echo "</form>\n";


			}

			echo "<hr> <b>�������:</b> (0 - ���������� �����)<br>";
			///
			echo "<form action=\"?".$faction."\" method=POST>";
			echo '�������� �����:<input type=text value="" name=chatmkaln size=15>&nbsp;&nbsp;';
			echo '� ������:<input type=text value="0" name=chatnom size=2>&nbsp;&nbsp;';
			echo '������ ������:<input type=text value="" name=chatmkalnpass><BR>';
			echo '<input type=submit value="���������" name=savechatmklan size=15>';



			echo "</form>";

			echo "<hr> <b>��������� ������</b><br>";
			if(($polno[$user['id']][0]==1) OR ($klan['glava']==$user['id']))
			{
					
					echo "<br><form action=\"?".$faction."\" method=POST>";
					echo '������� ��������:<input type=text value="'.$klan[defch].'" name=defch size=7>&nbsp;&nbsp;<small>(����� ���������� � ������� ������� � ������ �������� � ����)</small>';
					echo '<br><input type=submit value="���������" name=save_defch size=15><br>';
					
			}
			
			$chnls = explode(",",$klan[chat]);
			foreach ($chnls as $v)
			{
				if ($v!=0)
				{
					?><A href="#" OnClick="top.AddToPrivate('mklan-<?=$v?>', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A> mklan-<?=$v?>  <?
				}
				else
				{
					?><A href="#" OnClick="top.AddToPrivate('mklan', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A> mklan - ����������  <?
				}
			}




			echo "  ";

			echo '<form action="?'.$faction.'" method=POST> <input type=submit value="������ �����" name=getnewchanel> (��� ��� ��������� � <b>100</b> ��.) </form>';

			echo '</fieldset><BR>';

		}
    }

	function show_use_add_drive_members($post=null,$get=null,$faction)
	{        	global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna,$eff_align_type,$eff_align_time,$db_city;
        	echo '<fieldset><legend><b>���������� ������������: </b></legend><br>';
		if(($polno[$user['id']][0]==1) OR ($klan['glava']==$user['id']))
		{
			

	             if ($post['login3'] && ($klan['glava']==$user['id']) && $user['battle'] == 0)
	             {
				$sok = mysql_fetch_array(mysql_query('SELECT * FROM oldbk.`users` WHERE `klan` = \''.$klan['short'].'\' AND `login` = \''.$post['login3'].'\' LIMIT 1;'));				
				
				//print_r($sok);
				//echo 'wer';
				$sok =  check_users_city_data($sok[id]);
				if (strtotime($klan['chglava'])>time() )	
				{
				err(" ���������� �������� ���������� ��� ".prettyTime(null,strtotime($klan['chglava']))."!<br>");
				}
				else				
				if($sok[id] && $sok['battle'] == 0)
				{
					
					
					echo '<br>';
	
					unset($polno[$sok[id]]);
					
					$polno[$user[id]][0]=0;
					$polno[$user[id]][1]=0;
					$polno[$sok[id]][0]=1;
					$polno[$sok[id]][1]=1;
	
					mysql_query('update oldbk.`clans` set `glava` = \''.$sok['id'].'\', vozm = "'.serialize($polno).'" , `chglava`=(NOW() + INTERVAL 30 DAY)  WHERE `id` = '.$klan['id'].';');
	
					mysql_query('update avalon.`users` set `status` = \'<font color=#008080><b>����� �����</b></font>\' WHERE `id` = '.$sok['id'].';');
					mysql_query('update oldbk.`users` set `status` = \'<font color=#008080><b>����� �����</b></font>\' WHERE `id` = '.$sok['id'].';');
	
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$sok['id']."','�������� ���������� ����� ".$klan['short']." �� ".$user['login']." � ".$sok['login']."','".time()."');");
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$user['id']."','�������� ���������� ����� ".$klan['short']." �� ".$user['login']." � ".$sok['login']."','".time()."');");
	
					$new_room=$user[room];
	
					$new_room=((int)$user[room]==18?17:$new_room);
			                $new_room=((int)$user[room]==56?36:$new_room);
			                $new_room=((int)$user[room]==55?54:$new_room);	
		          
		            		mysql_query('update oldbk.`users` set `status` = \'����\', room='.$new_room.' WHERE `id` = '.$user['id'].';');
					mysql_query('update avalon.`users` set `status` = \'����\', room='.$new_room.' WHERE `id` = '.$user['id'].';');
					$del_channel='DELETE FROM oldbk.`chanels` WHERE user = "'.$user[id].'"';
		            		mysql_query($del_channel);
					$klan['glava'] = $sok['id'];
	            		}
	            		else
	            		{
	            			echo '��� ������ ���������� ��� �� � ���.';
	            		}
			}
			else
			{				echo '��� ������ ���������� ��� �� � ���.';			}
            //    echo $user[room];

				echo '<INPUT TYPE="button" onclick="findlogin(\'������� � ����\', \'?'.$faction.'\', \'login2\');" value="������� � ����" title="������� � ����">';
				echo ' (��� ��� ��������� � <B>100</B> ��.';
				if ($klan_kazna) { echo ' <i>������ �� �����</i>';}
				echo ')<BR><INPUT TYPE="button" onclick="findlogin(\'������� �� �����\', \'?'.$faction.'\', \'login1\');" value="������� �� �����" title="������� �� �����"> (��� ��� ��������� � <B>30</B> ��.';
				if ($klan_kazna) { echo ' <i>������ �� �����</i>';}
				echo ')<BR>';


		   		if($post['login2'] && (($polno[$user['id']][0]==1) OR ($klan['glava']==$user['id'])) )
				{
					
					
					$clan = mysql_query('SELECT * FROM oldbk.clans WHERE short = "'.$user['klan'].'"');
					$clan = mysql_fetch_assoc($clan);
					
					 if ($clan['base_klan']>0)
					 	{
						 	$klanid=$clan['base_klan'];
					 	}
					 	else
					 	{
					 		$klanid=$clan['id'];
					 	}
					
					$get_wars=mysql_fetch_array(mysql_query("select cw.* , cy.clanid , cy.clan_txt, cy.agressor as allyagr, cy.defender as allydef  from oldbk.clans_war_new  cw LEFT join oldbk.clans_war_new_ally cy on cy.warid=cw.id and cy.active=1 where cw.winner=0 and (cw.agressor='{$klanid}' or cw.defender='{$klanid}' or cy.clanid='{$klanid}' )")); 
					
					if  ((time()<1379534400) AND ($post['login2']!='���������'))  // �� 19,09,2013 - ������ ����� � ����
					{
						echo "<font color=red><b>����� � ���� �������� �� �������� �� 19.09.13</b></font>";
					}
					else
					if ($get_wars['id']>0)
					{
						echo "<font color=red><b>�� ����� ����� ����� � ���� ������.</b></font>";
					}
					else
					{
						$all = 0;
						$q = mysql_query('SELECT * FROM users WHERE klan = "'.$user['klan'].'"');
						$all += mysql_num_rows($q);

			
						if ($clan['rekrut_klan'] > 0) {
							// �� ���� ������
							$q = mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$clan['rekrut_klan']);
							$clan = mysql_fetch_assoc($q);
		
							$q = mysql_query('SELECT * FROM users WHERE klan = "'.$clan['short'].'"');
							$all += mysql_num_rows($q);

						} elseif ($clan['base_klan'] > 0) {
							// �� ���� ������
							$q = mysql_query('SELECT * FROM oldbk.clans WHERE id = '.$clan['base_klan']);
							$clan = mysql_fetch_assoc($q);

							$q = mysql_query('SELECT * FROM users WHERE klan = "'.$clan['short'].'"');
							$all += mysql_num_rows($q);
						}


						
						if ($all < 150) {
							$sok = mysql_fetch_array(mysql_query('SELECT * FROM `users` WHERE  `klan` = \'\' AND `align` = \'0\' AND `login` = \''.$post['login2'].'\'  AND id_city='.$user[id_city].' LIMIT 1;'));
							if ($sok[id]>0)
						 	{
			                	
							        $cheff=mysql_fetch_array(mysql_query("SELECT * from `effects` WHERE type = '".$eff_align_type."' AND owner = '".$sok['id']."' LIMIT 1;"));
								$already = mysql_fetch_assoc(mysql_query('SELECT * FROM effects WHERE type = 110110 and owner = '.$sok['id'].' and add_info = "'.$user['klan'].'"'));
	
								if($cheff['time']>time() && (int)$cheff['add_info']!=(int)$user[align])
								{
									echo '<font color=red><b>� ������� ��������� ��� �� ����� ����� �� ����� ����������</b></font>';
								} elseif ($already['id'] > 0) {
									echo '<font color=red><b>� ������� ��������� ��� ���� ����������� �� ������ �����</b></font>';
								}
								else
			                   			{
	
									$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$sok['id']."' AND `type` = 20 LIMIT 1;"));
	
									if ($klan_kazna)
									{
										 $hava_money=$klan_kazna[kr];
									}
									else
									{
										$hava_money=$user['money'];
									}
	
									if (!$eff)
									{
										echo '<font color=red><b>��� ��������!</b></font>';
									}
									elseif($sok['level']>0 && $hava_money >= 100) 
									{
										     
									     
										     echo '<font color=red>��������� "',$sok['login'],'" ������� �������� ����������� �������� � ����.</font>';
	
										if ($klan_kazna)
										{
										//������� �� �����
											by_from_kazna($klan['id'],1,100,'(����������� �� ����� � ���� ���������: '.$sok['login'].')');
										}
										else
										{
											//������� �� ������� �����
											$rec['owner']=$user[id];
											$rec['owner_login']=$user[login];
											$rec['owner_balans_do']=$user[money];
											$user['money'] -= 100;
											$rec['owner_balans_posle']=$user[money];
											$rec['target']=$sok['id'];
											$rec['target_login']=$sok['login'];
											$rec['type']=135;//������ � ����
											$rec['sum_kr']=100;
											$rec['item_count']=0;
											add_to_new_delo($rec);
											mysql_query('update `users` set `money` = `money` - 100 WHERE `id` = "'.$user[id].'";');
										}
	
										// ��������� ������ - ����������� 110100
										mysql_query('INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`add_info`) VALUES ('.$sok['id'].',"����������� � ����",'.(time()+(3600*24*3)).',110110,"'.$user['klan'].'")');


										$messtel = '��� ������� ����������� �������� � ���� <b>'.$user['klan'].'</b>. ������� ��� ��� ���������� �� ������ ����� ������ �<a href="javascript:void(0)" onclick='.(!is_array($_SESSION['vk'])?"top.":"parent.").'cht("http://capitalcity.oldbk.com/main.php?edit=1&effects=1")>���������</a>�.';
										


										if ($sok['odate'] > (time()-120)) {
											addchp('<font color=red>��������!</font> '.$messtel,'{[]}'.$sok['login'].'{[]}',$sok['room'],$sok['id_city']);
										} else {
											mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`,`deltime`) values ('".$sok['id']."','','<font color=red>��������!</font> ".$messtel."',".(time()+(3*24*3600)).");");
										}
	
									}
									else
									{
										echo "<font color=red>�� ������� �����, ��� ��� �������� �� ����������.</font>";
									}
								}
							}
						  	else
						  	{
						   		echo "<font color=red>�������� �� ������ � ���� ������ ���� ������ �������� ��� � ����� ��� ����� ����������!</font>";
						  	}
						} else {
					   		echo "<font color=red>�� �������� ������ ���������� ����� � ����� � �� ������ ������� � ���� ������ ���������.</font>";
						}
					}
				}
			}
             			

            		$post[login4]=strip_tags($post[login4]);
			if($post[login4]&&($klan[rekrut_klan]>0) && $user[id]==$klan[glava])
			{
				
				$telo=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.users WHERE login='".$post[login4]."' LIMIT 1;"));
				$telo=check_users_city_data($telo[id]);
			// ��������� - � �� ������� ��� ���� ���������!!
					if($telo[id]==$user[id])
					{
						echo '<font color=red><b><br>� ������� ���� ���� �� �������� ������?..<br></b></font>';
					}
					elseif($telo[id]==$recrut[glava])
					{
						echo '<font color=red><b><br>� ������� �������� �� �������� ������?..<br></b></font>';
					}
					else
			                {
			            			// echo 'test1';
			            			if($user[id]==28453)
							   {
							  	//print_r($telo);
							   }
			              			Test_Arsenal_Items($telo);
			
				                      //  echo 'test 2';
				                      if($telo[klan]==$user[klan])
				                      {
				                      //	echo 'test3';
				                      	//������ � �������
							foreach($db_city as $k=>$v)
							{
								mysql_query("UPDATE ".$v."users SET klan='".$recrut[short]."', status='����' WHERE login='".$post[login4]."';");
							}
				                        $sql2="insert oldbk.lichka SET  text='�������� ��������� �� ����� ".$user[klan]." � ���� ".$recrut[short]." ������ ".$user[login].".', pers='".$telo[id]."', date=".time()." ;";
				                         // echo $sql2;
				                       mysql_query($sql2);
				                       $sql='select * from oldbk.gellery_prot where klan_owner = '.$klan[rekrut_klan].';';
				                          //echo $sql;
			
				                                      //��������� �������� ��������, ���� ������� ����...
				                       $data=mysql_query($sql);
				                        while($row=mysql_fetch_array($data))
				                        {
				                           	$sql='insert into oldbk.gellery set owner='.$telo[id].',img="'.$row[img].'", exp_date='.$row[exp_date].',otdel='.$row[otdel].';';
								mysql_query($sql);
				                        }
				                                echo '<font color=red><b><br>'.$post[login4].' ���������.<br></b></font>';
				                          	mysql_query('delete from oldbk.chanels where `user` = '.$telo[id].';');
				                      }
				                      
				                      if($telo[klan]==$recrut[short])
				                      {
				                      	
					                        foreach($db_city as $k=>$v)
								{
					                          	mysql_query("UPDATE ".$v."users SET klan='".$user[klan]."', status='����' WHERE login='".$post[login4]."';");
								}
					                       	  mysql_query("insert oldbk.lichka SET  text='�������� ��������� �� ����� ".$recrut[short]." � ���� ".$user[klan]." ������ ".$user[login].".', pers='".$telo[id]."', date=".time().";");
					                          $sql='select * from oldbk.gellery_prot where klan_owner = '.$klan[id].';';
					                                      //echo $sql;
				
					                       $data=mysql_query($sql);
					                        while($row=mysql_fetch_array($data))
					                        {
					                           $sql='insert into oldbk.gellery set owner='.$telo[id].',img="'.$row[img].'", exp_date='.$row[exp_date].',otdel='.$row[otdel].';';
								   mysql_query($sql);
					                        }
					                          echo '<font color=red><b><br>'.$post[login4].' ���������.<br></b></font>';
					                          mysql_query('delete from oldbk.chanels where `user` = '.$telo[id].';');
				                      }

			        	}
	        	}

			if($get[login1]) {$post[login1]=$get[login1];}
			if(($post['login1'] && $polno[$user['id']][0]==1) || ($post['login1']==$user[login] && $klan['glava']!=$user['id']))
			{
			 if ($klan['base_klan']>0)
			 	{
			 	$klanid=$klan['base_klan'];
			 	}
			 	else
			 	{
			 	$klanid=$klan['id'];
			 	}
			
			$get_wars=mysql_fetch_array(mysql_query("select cw.* , cy.clanid , cy.clan_txt, cy.agressor as allyagr, cy.defender as allydef  from oldbk.clans_war_new  cw 
			LEFT join oldbk.clans_war_new_ally cy on cy.warid=cw.id and cy.active=1 where cw.winner=0 and (cw.agressor='{$klanid}' or cw.defender='{$klanid}' or cy.clanid='{$klanid}' )")); 

			if ($get_wars['id']>0)	
			{
				echo "<font color=red><b>�� ����� ����� ����� �� ����� ������.</b></font>";
			}
			else	
			    if($post['login1']==$user[login] && $klan['glava']==$user['id'])
		            {
		            	echo '<font color=red><b>������� ������ ����? :)</b></font></br>';
		            }
		            elseif($post['login1']==$user[login] && $user[klan]=='pal')
		            {
		           		echo '<font color=red><b>�� ��������� ������ ��� �� ����...</b></font></br>';
		            }
		            else
		            {
					$sok = mysql_fetch_array(mysql_query('SELECT * FROM `users` WHERE  `klan` = \''.$klan['short'].'\' AND `login` = \''.$post['login1'].'\' AND id_city='.$user[id_city].'  LIMIT 1;'));
					$sok=check_users_city_data($sok[id]);
					if($sok[battle]>0)
					{
						echo "<font color=red>������ �������� ����, �������� � ���!..</font>";
					}
					else
					if ($sok[id]>0)
					{

							if ($klan_kazna) { $hava_money=$klan_kazna[kr]; } else {$hava_money=$user['money'];}
							if($post['login1']==$user[login]) {$hava_money=$user['money'];}

							if ($sok && $hava_money >= 30 && $klan['glava']!=$sok['id']) {
							   echo '<font color=red>�������� "',$sok['login'],'" ������� ����.</font>';
							   Test_Arsenal_Items($sok);
							    if($post['login1']==$user[login])
							    {
							    	$txt='�������������� ����� �� ����� ' .$klan['short'];
							    	$txt1='������� 30 �� �� ����� �� ����� '.$klan['short'];
									mysql_query('update `users` set `money` = `money` - 30 WHERE `id` = '.$_SESSION['uid'].';');
							    }
							    else
							    {
							    	$txt="������ �� ����� ".$klan['short']." ���������� ".$user['login']."";
							    	$txt1='������� 30 �� �� �������� '.$user['login'].' �� ����� '.$klan['short'];
							    	if ($klan_kazna)
									{
									// �� �����
										by_from_kazna($klan['id'],1,30,'(�������� �� ����� ���������:'.$sok['login'].')');
									}
									else
									{
										$rec['owner']=$user[id];
										$rec['owner_login']=$user[login];
										$rec['owner_balans_do']=$user[money];
										$user['money'] -= 30;
										$rec['owner_balans_posle']=$user[money];
										$rec['target']=$sok['id'];
										$rec['target_login']='�������� �� ����� ���������:'.$sok['login'].'';
										$rec['type']=133;//��������
										$rec['sum_kr']=30;
										$rec['item_count']=0;
										add_to_new_delo($rec);
	                                   				 	mysql_query('update `users` set `money` = `money` - 30 WHERE `id` = '.$user['id'].';');
									}
							    }



								$exp=0;
							   	$exp=($sok[align]==1.5?($exp-0.1):$exp);
					                        $exp=($sok[align]==1.7?($exp-0.2):$exp);
					                        $exp=($sok[align]==1.75?($exp-0.3):$exp);
					                        $exp=($sok[align]==1.9?($exp-0.3):$exp);
					                        $exp=($sok[align]==1.91?($exp-0.4):$exp);
					                        $exp=($sok[align]==1.99?($exp-0.5):$exp);

				              // print_r($post);

                               					$new_room=$sok[room];
								$new_room=((int)$sok[room]==18 || $sok[room]==17?1:$new_room);
						                    $new_room=((int)$sok[room]==56 || $sok[room]==36?1:$new_room);
						                    $new_room=((int)$sok[room]==55 || $sok[room]==54?1:$new_room);
                                				$new_room=((int)$sok[room]==15 || $sok[room]==16?1:$new_room);

								foreach($db_city as $k=>$v)
								{
								mysql_query('update '.$v.'`users` set `klan` = \'\', `status` = \'\', `align` = 0, room= '.$new_room.', expbonus=expbonus+'.$exp.' WHERE `id` = '.$sok['id'].';');
								}
								//mysql_query('update oldbk.`users` set `klan` = \'\', `status` = \'\', `align` = 0, room= '.$new_room.', expbonus=expbonus+'.$exp.' WHERE `id` = '.$sok['id'].';');
								undressall($sok['id'],$sok['id_city']); 
								if ($user[id]==14897)	echo mysql_error();

								mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$sok['id']."','".$txt."','".time()."');");


								mysql_query('delete from oldbk.chanels where `user` = '.$sok['id'].';');
							}
							else
							{
						 		echo '<font color=red>�� ������� ����� ��� ��������!</font>';
				        		}
				        }
					else
					{
						echo "<font color=red>�������� �� ������ � ���� ������!</font>";
					}
				}
			}

	 		if ($klan['glava']==$user['id'])
			{
				if($klan[base_klan]==0)
				{
					echo '
					<br><br>
					<INPUT TYPE="button" onclick="findlogin(\'������� ����\', \'?'.$faction.'\', \'login4\');" value="������� ����" title="������� ����"> (������� ������� � ������, � ��������)<BR>
					';
				}
				echo '
				<br>
				<INPUT TYPE="button" onclick="findlogin(\'������� ����� �����\', \'?'.$faction.'\', \'login3\');" value="������� ����� �����" title="������� ����� �����"> (����� ����� ������ ������� � ���� ����������, �������� ������ ����� ������� ���������)<BR>
			    	 ���������� �������� �������� ���� ��� � 30 ����.<br>';
	
					if (strtotime($klan['chglava'])>time() )	
					{
					err(" ���������� �������� ���������� ��� ".prettyTime(null,strtotime($klan['chglava']))."!<br>");
					}

	        }

	 		echo '<br>';
	 		if($user[klan]!='pal'){
		    	echo "<input type=button  onclick=\"if(confirm('������� ��� ������ ����� �� �����?')) { window.location='?".$faction."&login1=".$user['login']."';}\" value='����� �� �����'>(��� ��� ��������� � <B>30</B> ��.)<br>";
		    }
          	echo '</fieldset>';
 	}

	function  klan_reiting($post=null,$get=null,$faction)
 	{
 		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
 		if($klan['glava']==$user['id'] || $polno[$user['id']][0]==1 || $user[id]==28453 || $user[id]==326)
		{
			echo "<fieldset><legend><b>���������� ������� � ��������: </b></legend>";

			$kl=$user[klan];
			if($kl=='pal')
			{
				$kl='align_1.99';
			}
			
			if($post[sitename])
			{
				$register=true;
				$sitename=stripslashes($post[sitename]);
				
				$url=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.clans where short='".$user[klan]."'"));
				
				$data=mysql_query('SELECT * FROM topsites.top WHERE klan="'.$kl.'" LIMIT 1');
				if(mysql_num_rows($data)>0)
				{
					//���������� ������
					$row=mysql_fetch_assoc($data);
					mysql_query("UPDATE topsites.top set sitename='".$sitename."' WHERE klan='".$kl."'");
					if(mysql_affected_rows()>0)
					{
						echo '<br><font color=red><b>������ ���������. </b></font>';
					}
					$register=falce;
				}
				else
				if($url[homepage]!='')
				{
					//������ �����������
					$url=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.clans where short='".$user[klan]."'"));
					mysql_query("insert into topsites.top set sitename='".$sitename."', url='".$url[homepage]."', klan='".$kl."', ban=1, reg_flag=1");
					
					
					if(mysql_insert_id()>0)
					{
						echo '<br><font color=red><b>�� ������ ������ �� ����������� � �������� ������. ������ ����� ��������� � ��������� �����. </b></font>';
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('326','','<font color=blue><b>[".date("d.m.Y H:i")."] ���� ".$user[klan]." ����� ������ �� ������� � ��������.</b></font>')");
						mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('28453','','<font color=blue><b>[".date("d.m.Y H:i")."] ���� ".$user[klan]." ����� ������ �� ������� � ��������.</b></font>')");
						echo mysql_error();
						//������ �����
					}
					else
					{
						echo '<br><font color=red><b>��������� ������ ��� ���������� ������.</b></font>';
					}
					
				}
				else
				{
					echo '<br><font color=red><b>������ ��� ������...</b></font>';
				}
				//print_r($post);
			}
			
			
			
			$register=true;
			$url=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.clans where short='".$user[klan]."'"));
			
			
			$data=mysql_query('SELECT * FROM topsites.top WHERE klan="'.$kl.'" LIMIT 1');
			if(mysql_num_rows($data)>0)
			{
				$row=mysql_fetch_assoc($data);
				$register=false;
			}
			
			if($register==true)
			{
				if($url[homepage]!='')
				{
					echo '<font color=red><b>������������������ � �������� ������:</b></font><br><br>';
				}
				else
				{
					echo '<font color=red><b>��� ����������� � �������� ���������� �������� ����� ����� � ����������.<br></b></font><small>�������� ��� �������� ����� ����� ����� � ������������ ������ �� ������������ �����.</small><br><br>

						<font color=red><b>����� ������������ � ��������, ���������, ��� �� ����� ����� ���������� �������  mail.ru.<br></b></font><small>��� ���������� �� ����� �������� mail.ru, ��� ����� ���� �������� � �����������.</small>';
					die();
				}	
			}
			if($row[ban]==1)
			{
				echo '<font color=red><b>������ � �������� �� ������������.</b></font>';
			}
			echo "<form action=?".$faction." method=post>";
				echo "<table border=1>
					<tr>
						<td align=left valign=top>�������� �/��� �������� �����: <br><small>(�� ����� 60 ��������)</small><br></td><td align=left valign=middle><input type='text' maxlength=60 name='sitename' size=80 value='".$row[sitename]."'></td>
					</tr>
					<tr>
						<td align=left valign=top>URL �����: <br><small>(����� �������� � ������������ ������)</small></td><td align=left valign=middle><input disabled type='text' name='url' size=80 value='".$url[homepage]."'></td>
					</tr>
					<tr>
						<td align=left valign=top>�������� �������� �����:<br></td><td align=left valign=middle><input type='text' disabled name='klan' value='".$user[klan]."'></td>
					</tr>";
					if($register==false)
					{ //��������� �����
						echo "<tr>
							<td align=left valign=top>��� �������� �����<br>(<small>�� �������� �������� ���� ��� �� ��� ����</small>) </td><td align=left valign=top><textarea rows=5 cols=80><a href=\"http://top.oldbk.com/stats.php?id=".$row[memberid]."\" target=\"_blank\"><img src=\"http://top.oldbk.com/img.php?id=".$row[memberid]."\" border=\"0\"></a></textarea></td>
						</tr>";
					}
					echo "<tr>
						<td align=center valign=top colspan=2><br><input type='submit' value='���������'></td>
					</tr>
				";
					
			
			echo "</table></form></legend>";
		}
	}

 	function  show_use_clan_chat($post=null,$get=null,$faction)
 	{ 		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;

 		$Kcha = mysql_fetch_array(mysql_query("SELECT `name`,`mname`, `filt_name` , `filt_mname` FROM oldbk.`chanels` WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';"));
		if($user[id]==326 || $user[id]==28453)
		{
			$Kcha_pal = mysql_fetch_array(mysql_query("SELECT `name`,`mname`, `filt_name` , `filt_mname` FROM oldbk.`chanels` WHERE `klan`='pal' AND `user` = '".$user['id']."';"));
			$filt_name_pal = array();
			$filt_name_pal = unserialize($Kcha_pal[filt_name]);		
			
		}


		$filt_name = array();
		$filt_name = unserialize($Kcha[filt_name]);

		$filt_mname = array();
		$filt_mname = unserialize($Kcha[filt_mname]);



///
		if ($get[offmch]!='')
		{
			$fchnl=(int)$get[offmch];
			$filt_mname[$fchnl]=1;
			mysql_query("UPDATE oldbk.chanels SET `filt_mname`='".serialize($filt_mname)."' WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';");

		}
		else if ($get[onmch]!='')
		 {
			$fchnl=(int)$get[onmch];
			$filt_mname[$fchnl]=0;
			mysql_query("UPDATE oldbk.chanels SET `filt_mname`='".serialize($filt_mname)."' WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';");
		  }
		else if ($get[offch]!='')
		 {
			$fchnl=(int)$get[offch];
			$filt_name[$fchnl]=1;
			mysql_query("UPDATE oldbk.chanels SET `filt_name`='".serialize($filt_name)."' WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';");

		  }
		else if ($get[onch]!='')
		 {
			$fchnl=(int)$get[onch];
			$filt_name[$fchnl]=0;
			mysql_query("UPDATE oldbk.chanels SET `filt_name`='".serialize($filt_name)."' WHERE `klan`='".$user['klan']."' AND `user` = '".$user['id']."';");
		 }
		else if ($get[offch_p]!='' && ($user[id]==326 || $user[id]==28453))
		 {
			$fchnl=(int)$get[offch_p];
			$filt_name_pal[$fchnl]=1;
			mysql_query("UPDATE oldbk.chanels SET `filt_name`='".serialize($filt_name_pal)."' WHERE `klan`='pal' AND `user` = '".$user['id']."';");
		  }
		else if ($get[onch_p]!='' && ($user[id]==326 || $user[id]==28453))
		 {
			$fchnl=(int)$get[onch_p];
			$filt_name_pal[$fchnl]=0;
			mysql_query("UPDATE oldbk.chanels SET `filt_name`='".serialize($filt_name_pal)."' WHERE `klan`='pal' AND `user` = '".$user['id']."';");
		 } 
		 
		 
		 
		  //mclan
		  
		$my_list=(mysql_query("select * from oldbk.chat_chanels where (clan1='".$user['klan']."' or clan2='".$user['klan']."') and active=1 order by active DESC , chanel  ;"));
		$list=array();
		$MClanname=array();
		while ($rows = mysql_fetch_array($my_list))
		{
			if ($rows[clan1]==$user['klan']) {$list[]=$rows[chanel]; $MClanname[$rows[chanel]]=$rows[clan2];}
			else if ($rows[clan2]==$user['klan']) {$list[]=$rows[chanel2];$MClanname[$rows[chanel2]]=$rows[clan1];}
		}

		$chnls = explode(",",$Kcha[mname]);
		echo '
		<fieldset><legend><b>������ ����: </b></legend>
			<table border=0>
				<tr align=left >';
					if ($chnls[0]!='')
					{
						echo "
						<td width=30>&nbsp;</td>
						<td align=left><font color=#850404><b>";
						foreach ($chnls as $v)
						{

							if(in_array($v,$list)) 
							{
								if ($v!=0) 
								{
									?>
									<A href="#" OnClick="top.AddToPrivate('mklan-<?=$v?>', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A> mklan-<?echo "$v - <img src=\"http://i.oldbk.com/i/klan/$MClanname[$v].gif\">$MClanname[$v]";
									if ((int)($filt_mname[$v])==0) 
									{ 
										echo " [<a href='?".$faction."&offmch=$v'><img src='http://i.oldbk.com/i/clear.gif' alt='���������' title='���������'></a>] " ; 
									}
									else 
									{ 
										echo " [<a href='?".$faction."&onmch=$v'><img src='http://i.oldbk.com/i/up.gif' alt='��������' title='��������'></a>] " ;  
									}
                                    		echo '<br>';
								}
								else
								{
									?><A href="#" Onclick="top.AddToPrivate('mklan', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A> mklan - <?echo "<img src=\"http://i.oldbk.com/i/klan/$MClanname[$v].gif\">$MClanname[$v]";

									if ((int)($filt_mname[0])==0) 
									{ 
										echo " [<a href='?".$faction."&offmch=0'><img src='http://i.oldbk.com/i/clear.gif' alt='���������' title='���������'></a>] " ; 
									}
									else 
									{ 
										echo " [<a href='?".$faction."&onmch=0'><img src='http://i.oldbk.com/i/up.gif' alt='��������' title='��������'></a>] " ;  
									}
                            echo '<br>';
								}
							}
						}
									echo "</b></font>
					</td><td width=30>&nbsp;</td></tr>";
					}
					
					?>
				<tr>
					<td></td>
					<td height=10></td>
					<td></td>
				
				
				<tr align=left >
					<td width=30 ><br>&nbsp;</td>
					<td align="left">
				<font color=#000000><b><A href="#" OnClick="top.AddToPrivate('klan', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A>����������
				<?                              
	/*			if ((int)($filt_name[0])==0) { echo "[<a href='klan.php?offch=0'><img src='http://i.oldbk.com/i/clear.gif' alt='���������' title='���������'></a>]  " ; }
										else { echo "[<a href='klan.php?onch=0'><img src='http://i.oldbk.com/i/up.gif' alt='��������' title='��������'></a>]  " ;  }*/

				if (!isset($_SESSION['offclanchat']) || $_SESSION['offclanchat'] == 0) 
				{
					echo "[<a href='?".$faction."&offall=1'><img src='http://i.oldbk.com/i/clear.gif' alt='���������' title='���������'></a>]";
				} 
				else 
				{
					echo "[<a href='?".$faction."&offall=0'><img src='http://i.oldbk.com/i/up.gif' alt='��������' title='��������'></a>]";
				}

				echo "<BR>";
					$cha = explode(",",$Kcha[name]);
					if($cha[0]) 
					{
						foreach ($cha as $v)
						{
							?><A href="#" OnClick="top.AddToPrivate('klan-<?=$v?>', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A> klan-<?=$v?> <?
								if ((int)($filt_name[$v])==0) { echo "[<a href='?".$faction."&offch=$v'><img src='http://i.oldbk.com/i/clear.gif' alt='���������' title='���������'></a>]  " ; }
								else { echo "[<a href='?".$faction."&onch=$v'><img src='http://i.oldbk.com/i/up.gif' alt='��������' title='��������'></a>]  " ;  }
								echo '<br>';
						}
					}
					if($user[id]==28453 || $user[id]==326)
					{
						$cha_pal = explode(",",$Kcha_pal[name]);
						if($cha_pal[0]) 
						{
							foreach ($cha_pal as $v)
							{
								?><A href="#" OnClick="top.AddToPrivate('klan-pal-<?=$v?>', top.CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" width=20 height=15></A> klan-pal-<?=$v?> <?
									if ((int)($filt_name_pal[$v])==0) { echo "[<a href='?".$faction."&offch_p=$v'><img src='http://i.oldbk.com/i/clear.gif' alt='���������' title='���������'></a>]  " ; }
									else { echo "[<a href='?".$faction."&onch_p=$v'><img src='http://i.oldbk.com/i/up.gif' alt='��������' title='��������'></a>]  " ;  }
									echo '<br>';
							}
						}
					
					
					
					
					
					}
					
					
					
				echo "</b></font><td width=30>&nbsp;</td></tr></table></fieldset>";
 	}

	function  change_abils($post=null,$get=null,$faction)
{
	global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
	if($user[id]==$klan[glava])
	{   
	    	$soklans=array();
	        $soklans[0]=array(1);

			if($post['change'])
			{				$post['id']=(int)$post['id'];
				$u=mysql_fetch_array(mysql_query('SELECT * FROM users WHERE id ="'.$post['id'].'" and klan="'.$user[klan].'" LIMIT 1;'));				if($u[id]>0)
				{					
						$self_abil=mysql_query("select * from oldbk.clans_abil where klan='".$user['klan']."';");
						while ($rows = mysql_fetch_assoc($self_abil))
						{
							$post[$rows['magic']]=(int)$post[$rows['magic']];
							if(isset($post[$rows['magic']])>=0) //������ ���� � ID �����
							{								$u_abils=unserialize($rows['users']);
								if($u_abils[$post['id']]>0)
								{
									unset($u_abils[$post['id']]);
								}
								
								if($post[$rows['magic']]>0)
								{
									$u_abils[$post['id']][$rows['magic']]=$post[$rows['magic']];
								}
							}
							$new_ab=serialize($u_abils);
							mysql_query('UPDATE oldbk.clans_abil SET users="'.$new_ab.'" WHERE klan="'.$user[klan].'" AND magic="'.$rows[magic].'";');
						}
					
					
					/*if($post[city_1]==1)
					{
						$self_abil=mysql_query("select * from avalon.clans_abil where klan='".$user['klan']."';");
						while ($rows = mysql_fetch_assoc($self_abil))
						{
							$post[$rows['magic']]=(int)$post[$rows['magic']];
							if(isset($post[$rows['magic']])>=0) //������ ���� � ID �����
							{
								$u_abils=unserialize($rows['users']);
								if($u_abils[$post['id']]>0)
								{
									unset($u_abils[$post['id']]);
								}
								
								if($post[$rows['magic']]>0)
								{
									$u_abils[$post['id']][$rows['magic']]=$post[$rows['magic']];
								}
							}
							$new_ab=serialize($u_abils);
							mysql_query('UPDATE avalon.clans_abil SET users="'.$new_ab.'" WHERE klan="'.$user[klan].'" AND magic="'.$rows[magic].'";');
						}
					}
					*/
					
									}
			}
		$rr=0;
		$i=0;
	        $data=mysql_query('select * from users where klan="'.$user['klan'].'" AND id !='.$klan[glava].';');
	        while ($rows = mysql_fetch_array($data))
		{			$soklans[$rows[id]]=$rows;
			if($rr==6)
			{
				$soklans[(0-$i)]='$nbsp;';
				$rr=0;
			}
			else
			{
				$rr++;
			}
			$i++;
		}

	      	$self_abil=mysql_query("select * from clans_abil
		LEFT JOIN magic mg
		ON clans_abil.magic=mg.id
		where klan='".$user['klan']."';");

		$f=array();
		$cols_name[0]='���';
		$j=1;
		
		while ($rows = mysql_fetch_array($self_abil))
		{
			
			$cols_name[$rows['magic']]=$rows;
		//	$users_m[$rows['magic']]=unserialize($rows['users']);
            		$j++;
		}

		//������ �������� �����
		echo '
		<small>� ������� ������������ ���������� ������, �������������� ����� �����������.</small><br>
		<table border=0>';	
		
		foreach($soklans as $uid=>$uvalue)
		{
		
			if ($ff==0)
			{
				$ff = 1; $color = '#C7C7C7';
			} 
			else
			{
				$ff = 0; $color = '#E1E1E3';
			}
			
			echo '<tr><form action="?'.$faction.'" method="post"><input name="change" type="hidden" value="1"><input name="id" type="hidden" value="'.$uid.'">';
			foreach($cols_name as $mid => $mvalues)
			{
				
				$users_m=unserialize($mvalues['users']);
				if($uid<=0)  //������ � ����������
				{					$mvalues[img]=($mvalues[magic]==66?'labticket.gif':$mvalues[img]);
					//$mvalues[img]=($mvalues[magic]==51?'note.gif':$mvalues[img]);
					$mvalues[img]=($mvalues[magic]==2525?'attackbv.gif':$mvalues[img]);
					$mvalues[img]=($mvalues[magic]==82?'lmap.gif':$mvalues[img]);										
					echo '<td bgcolor=#A5A5A5> '.($mid>0?'<img alt="'.$mvalues[name].'" title="'.$mvalues[name].'" src="http://i.oldbk.com/i/sh/'.$mvalues['img'].'"> (<b>'.$mvalues['maxcount'].'</b>)':'<font color="#003388"><b>���</b> </font> ').'</td>';
				}
				else
				{					echo ($mid==0?'<td bgcolor='.$color.'><b>'.$uvalue['login'].'</b>':'<td bgcolor='.$color.'><input type="text" size="5" name="'.$mid.'" value="'.($users_m[$uid]?$users_m[$uid][$mid]:'0').'">').'</td>';				}
			}
			echo ($uid<=0?'<td bgcolor=#A5A5A5>':'<td bgcolor='.$color.'><input type="submit" value="���������">').'</td>';
			echo '</form></tr>';
		}
		echo '</table></td>';
		echo '</tr></table>';
	}}

	function use_klan_abils($post=null,$get=null,$faction)
	{		global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;
      	if (
			(isset($post['sd4']))
			and
			(isset($post['use']))
			and
			(isset($post['target']))
		)
		{
			$post['use']=(int)$post['use'];
			//test inputs
			/*
			$tabil = mysql_fetch_array(mysql_query("select * from clans_abil
												LEFT JOIN oldbk.`magic` mg
												ON clans_abil.magic=mg.id
												where magic='".$post['use']."' and maxcount!=count
												and maxcount!=0 and klan='".$user['klan']."' LIMIT 1;"));
			*/
			$tabil = mysql_fetch_array(mysql_query("select clans_abil.* , mg.* , ifnull(abc.all_count,0) as byed_count  from clans_abil 
							LEFT JOIN oldbk.`magic` mg
							ON clans_abil.magic=mg.id
                            LEFT JOIN oldbk.abil_buy_clans abc                            
                            ON clans_abil.magic=abc.magic_id and clans_abil.klan=abc.klan_name
							where magic='".($post['use'])."' and ((count<maxcount and maxcount>0) or abc.all_count > 0) and klan='".$user['klan']."';"));
			
												

			if ($tabil[magic])
			{
			//check users
			    $klan_abil=1;

				$dostup= array();
				$dostup=unserialize($tabil['users']);
				$ucount=array();
				$ucount=unserialize($tabil['userscount']);
                $bet=0;

  		     	if ($user[ruines]>0 || $user['in_tower'] > 0)
			     {

					echo "<font color=red><B>��� ��� �� �������...</b></font><br>";
			     }
				else
			    if ((($dostup[$user['id']][$tabil[magic]] >$ucount[$user['id']][$tabil[magic]]) and ($dostup[$user['id']][$tabil[magic]] != 0 )) OR ($klan['glava']==$user['id']))
				{

		 			$klan_abil=1; $ABIL=1;
		 			
			//		echo "$tabil[magic] / $tabil[count] / $tabil[maxcount]";
			//		echo "Use magic...<br>";
			//		echo $dostup[$user['id']][$tabil[magic]];
					echo "<b>";
					include("magic/".$tabil[file]);
					echo "</b><br>";
				}
				else
				{
					echo "<font color=red><B>��� ���, �� ������� ����� ��������....</b></font><br>";
				}
				
				
				if($bet==1)
				{
					//�������� 1 ���
					if (($tabil[maxcount]-$tabil[count])>0)
					{
					// -1 �� �� ����������					
					$ucount[$user['id']][$tabil[magic]]=$ucount[$user['id']][$tabil[magic]]+1;
					mysql_query("update clans_abil set `count`=`count`+1, `userscount`='".serialize($ucount)."' where magic='".(int)($post['use'])."' and maxcount!=count and maxcount!=0 and klan='".$user['klan']."'  ; ");
					mysql_query("INSERT clans_abil_log (`owner`, `klan` , `magic`, `date`, `msg`) values ('".$user['id']."', '".$user['klan']."', '".(int)($post['use'])."' , NOW() , '(�� ����������)' ) ; ");
					}
					else
					{
					//-1 �� �������
					$ucount[$user['id']][$tabil[magic]]=$ucount[$user['id']][$tabil[magic]]+1;
					//������� �������� ����
					mysql_query("update clans_abil set `userscount`='".serialize($ucount)."' where magic='".(int)($post['use'])."' and klan='".$user['klan']."'  ; ");
					//������� �� ������� ������� -1
					mysql_query("UPDATE `oldbk`.`abil_buy_clans` SET `all_count`=`all_count`-1 WHERE `magic_id`='".(int)($post['use'])."' AND `klan_name`='".$user['klan']."' ;");
					//����� ���
					mysql_query("INSERT clans_abil_log (`owner`, `klan` , `magic`, `date`, `msg`) values ('".$user['id']."', '".$user['klan']."', '".(int)($post['use'])."' , NOW() , '(�� �������)' ) ; ");					
					}
					
					$rec=array();
  		    			$rec['owner']=$user['id'];
					$rec['owner_login']=$user['login'];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='�������� �������!';
					$rec['type']=3232;
					$rec['item_name']=$tabil['name'];
					$rec['battle']=$user['battle'];
					add_to_new_delo($rec);
					
				}
			}
			elseif($post['use']!='post_attack')
			{
				echo "<font color=red><B>�� ������� ����� ��������...</b></font><br>";
			}
			                                                   //   if(confirm('������������ ������?')) {window.location='main.php?use=9157079&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;}
		}
		echo "<BR><fieldset><legend><b>�������� �������:</b></legend>";
         echo '<table border=0><tr><td width=500 align=left>';
		
		/*
		$abil=mysql_query("select * from clans_abil
							LEFT JOIN oldbk.`magic` mg
							ON clans_abil.magic=mg.id
							where maxcount>0  and klan='".$user['klan']."';");
		*/
		$abil=mysql_query("select clans_abil.* , mg.* , ifnull(abc.all_count,0) as byed_count  from clans_abil 
							LEFT JOIN oldbk.`magic` mg
							ON clans_abil.magic=mg.id
                            LEFT JOIN oldbk.abil_buy_clans abc                            
                            ON clans_abil.magic=abc.magic_id and clans_abil.klan=abc.klan_name
							where (maxcount>0 or abc.all_count > 0 ) and klan='".$user['klan']."';");

		while ($rows = mysql_fetch_array($abil))
		{
		$ALL_ABIL_COUNT=($rows[maxcount]-$rows[count])+$rows[byed_count];  //������� ����� ��������
		
	//check users
			$dostup= array();
			$dostup=unserialize($rows['users']);
			$ucount=array();
			$ucount=unserialize($rows['userscount']);
			if($user['id']==$klan['glava'])
			{                $iabil++;
				$m=$rows[magic];
				$im=$sok['id'];
				$magic_name=$rows[name];
				//�������� �� �������� �������������� �����, �� ��������� � �����������
				$rows[img]=($rows[magic]==66?'labticket.gif':$rows[img]);
		               // $rows[img]=($rows[magic]==51?'note.gif':$rows[img]);
		                $rows[img]=($rows[magic]==2525?'attackbv.gif':$rows[img]);
		                $rows[img]=($rows[magic]==82?'lmap.gif':$rows[img]);

		                
				
				if ($rows['magic']==59)
				{
				$chout=array();

					$get_chash=mysql_query("select *  from oldbk.clans_abil_war_new where klan=".$klan['id']." order by `count`");
					while ($cha = mysql_fetch_array($get_chash))
					{
						for($ii=1;$ii<=$cha['leftdays'];$ii++)
						{
						$chout[$ii]=$cha['count'];
						}
					}
				
				$strch='';
				foreach ($chout as $k => $v)
				{
				$strch.="����: <font color=green>".date("d-m-Y", mktime(0, 0, 0, date("m"), date("d")+$k, date("Y")))."</font>: <b>".$v." ��.</b> <br>" ;
				}
				//echo $strch;
				if ($strch=='')	{$strch="<b>�� ��������� ����� � ��� ��� ���.</b>"; }
				
				echo "<a onclick=\"javascript:new_runmagic('".$magic_name."','".$rows[magic]."','target','target1','".$rows[targeted]."'); \" href='#'><img src='http://i.oldbk.com/i/magic/".$rows[img]."' title='".$magic_name."'></a>&nbsp;";
				echo "�������� �������: <br>(���������� $rows[count]/$rows[maxcount]) (���������: $rows[byed_count] ��.) ";
				echo "(���� �� �����: <a href=# onMouseOut=\"HideThing(this)\" onMouseOver=\"ShowThing(this,35,25,'".$strch."')\">".$rows['chasha']." ��.</a>)<br>";

				}
				else
				{
				echo "<a onclick=\"javascript:new_runmagic('".$magic_name."','".$rows[magic]."','target','target1','".$rows[targeted]."'); \" href='#'><img src='http://i.oldbk.com/i/magic/".$rows[img]."' title='".$magic_name."'></a>&nbsp;";				
				echo $rows['name'];
				echo ": (���������� $rows[count]/$rows[maxcount]) (���������: $rows[byed_count] ��.)<br>";
				}
				
				
			}
			else
			if ((((int)($dostup[$user['id']][$rows[magic]]) >(int)($ucount[$user['id']][$rows[magic]])) and ((int)($dostup[$user['id']][$rows[magic]]) != 0 )   ) )
			{
				$iabil++;
				$rows[img]=($rows[magic]==66?'labticket.gif':$rows[img]);
    				//$rows[img]=($rows[magic]==51?'note.gif':$rows[img]);
		                $rows[img]=($rows[magic]==2525?'attackbv.gif':$rows[img]);
		                $rows[img]=($rows[magic]==82?'lmap.gif':$rows[img]);
                		//$script_name=($rows[magic]==51?"comment_fight":"runmagic".$rows[targeted]);
				
				$m=$rows[magic];
				$magic_name=$rows[name];
				echo "<a onclick=\"javascript:new_runmagic('".$magic_name."','".$rows[magic]."','target','target1','".$rows[targeted]."'); \" href='#'><img src='http://i.oldbk.com/i/magic/".$rows[img]."' title='".$magic_name."'></a>&nbsp;";				
				echo "$rows[name]: ";
				
					//if ($rows['magic']==59) { echo "<br>";}
					
				echo (int)($ucount[$user['id']][$rows[magic]])."/";
				
				//��� 
				if ((int)($dostup[$user['id']][$rows[magic]]) > $ALL_ABIL_COUNT ) 
				{ 
				//���� ��������� ������ ��� ������� �������� �� ������ �������
				echo $ALL_ABIL_COUNT.""; 
				}
				else
				{
				//���� ��������� ��� ���� ������ �� ������������ ����� ��� ��� ���������
				echo (int)($dostup[$user['id']][$rows[magic]])."";
				}
				
				if ($rows[byed_count]>0)
				{
				 echo "(�� ��� ���������: ".($rows[maxcount]-$rows[count])." ��.)";
				 //echo "(��������:$rows[byed_count]��.)";
				}
				
				if ($rows['magic']==59)
				{
				$chout=array();

					$get_chash=mysql_query("select *  from oldbk.clans_abil_war_new where klan=".$klan['id']." order by `count`");
					while ($cha = mysql_fetch_array($get_chash))
					{
						for($ii=1;$ii<=$cha['leftdays'];$ii++)
						{
						$chout[$ii]=$cha['count'];
						}
					}
				
				$strch='';
				foreach ($chout as $k => $v)
				{
				$strch.="����: <font color=green>".date("d-m-Y", mktime(0, 0, 0, date("m"), date("d")+$k, date("Y")))."</font>: <b>".$v." ��.</b> <br>" ;
				}
				if ($strch=='')	{$strch="<b>�� ��������� ����� � ��� ��� ���.</b>"; }
				echo " (���� �� �����: <a href=# onMouseOut=\"HideThing(this)\" onMouseOver=\"ShowThing(this,35,25,'".$strch."')\">".$rows['chasha']." ��.</a>)<br>";
				}

				
				echo "<br>";
			}
		}

		if ($iabil==0) {
			echo '� ������ ����� ��� ��������, ��� ����� ����� ��� �� �� �����������. ;)';
		}
		else
		{
            if($klan[glava]==$user[id])
            {
				if (!isset($post[abillogs]))
				{
					echo "<br><form method=post>";
					echo "<input type=submit name='abillogs' value='������������� �������� �� �������.'>";
					echo "</form>";
				}
				else
				{
					$Nd=date("Y-m-d ");
					echo "<hr><b>������������� ��������:</b><br>";
					$logabil=mysql_query("select * from clans_abil_log LEFT JOIN magic mg ON clans_abil_log.magic=mg.id  where   `date` < '".$Nd." 23:59:59' and `date` > '".$Nd." 00:00:00' and klan='".$user['klan']."' ORDER by `date` DESC ;");
					while ($rows = mysql_fetch_array($logabil))
					{
						$Wd=explode(" ",$rows['date']);
						echo  $Wd[1].":�������� ".nick33($rows['owner'])." ����������� <i>$rows[name]</i> $rows[msg]<br>\n";
					}
				}
           }
		}

		echo "</td></tr></table></fieldset><br>";
	}

	function pal_change_abils($post=null,$get=null,$faction)
{
	global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;

	if($user[klan]=='pal')
	{
		$abils=array('sleep','sleep_off','sleepf','sleepf_off','obezl','obezl_off','haosn','haosn_off','death','death_off','ldadd','attack','battack','ct_all','marry','unmarry','check');	
		$sql_add='';
	}
	
	if($user[klan]=='Adminion' || $user[klan]=='radminion')
	{

		$abils=array('sleep','sleep_off','sleepf','sleepf_off','obezl','obezl_off','haosn','haosn_off','death','death_off','teleportadmin','ldadd','attack','battack','ct_all','marry','unmarry','bexit','ch_nick','ch_date','ch_pass','lookmap','lookpass','bclose','ch_pol','my_city_teleport','haos_vamp1','haos_vamp2','haos_attak','haos_attakb','haos_travm','haos_bexit','haos_hill180','haos_sleep','haos_unclone','adm_formul','adm_formulb', 'ban_money', 'unban_money','check');
		$sql_add=" or u.klan='Adminion' or u.klan='radminion' or u.align = 5 or (align >2 and align <3) or id=2  or id=5 or id=697032 ";
	}

	if($post)
	{
		$new_abils=array();
		$post[id]=(int)$post[id];
		$pal=mysql_fetch_array(mysql_query("select * from oldbk.users u where u.id='".$post[id]."' and (u.klan='pal' ".$sql_add.") limit 1"));
		if($pal[id])
		{	
			foreach($abils as $k=>$v)
			{
				
				if($post[$v])
				{
					$new_abils[$v]=1;
				}
				else
				{
					$new_abils[$v]=0;
				}
			}	
			$new_abils=serialize($new_abils);
			mysql_query("INSERT INTO pal_rights (`pal_id`,`abils`) VALUES
			('".$pal[id]."','".$new_abils."') 
			 ON DUPLICATE KEY UPDATE `abils`='".$new_abils."';");
			echo '<font color=red><b>��������� ��� '.$pal[login].' ���������</b></font>';
		}
		else
		{
			echo '����� �������� �� ������...';
		}
	}


	echo '<table border=1>';	
	$data=mysql_query("SELECT * FROM oldbk.users u
		left join  pal_rights pr
		on u.id=pr.pal_id
		WHERE u.klan='pal' ".$sql_add."
		order by u.align desc
		");
	echo '<tr><td>���</td>';
	$to_div.='<tr><td>&nbsp</td>';
	foreach($abils as $k=>$name)
	{
		$to_div.='<td><img src="http://i.oldbk.com/i/magic/'.$name.'.gif"></td>';
		echo '<td><img src="http://i.oldbk.com/i/magic/'.$name.'.gif"></td>';
	}
	echo '<td></td></tr>';
	$to_div.='<td></td></tr>';
	$strn=0;
	while($row=mysql_fetch_assoc($data))
	{
		echo '
		<tr>
			<td>
			<form action=?'.$faction.' method="post">
			<input type="hidden" name="id" value="'.$row[id].'">
				<img src="http://i.oldbk.com/i/align_'.$row[align].'.gif"><b>'.$row[login].'</b><a target=_blank href="http://capitalcity.oldbk.com/inf.php?'.$row[id].'"><img src="http://i.oldbk.com/i/inf.gif"></a>
			</td>';
			
			$rights=unserialize($row[abils]);
			foreach($abils as $k=>$name)
			{
				if($rights[$name]==1)
				{
					echo '<td><input name="'.$name.'" type="checkbox" checked></td>';
				}
				else
				{
					echo '<td><input name="'.$name.'" type="checkbox"></td>';
				}
			}
			
		echo '<td><input type="submit" value="���������"></form></td>
		</tr>';
		if($strn==6)
		{
			echo $to_div;
			$strn=0;
		}
		else
		{
			$strn++;
		}
	}
	
	echo '</table>';
	
}

	function change_abils_rec($post=null,$get=null,$faction)
{    	global $klan,$user,$polno,$db_other_city,$id_other_city,$city_name,$recrut,$base_klan,$klan_kazna;

        echo '<h3>���������� ��������� � ���������</h3>';
        if($post[abilcladd])
	{
		$error='';
		$ok='';
		$sql='';

		$self_abil=mysql_query("select * from clans_abil
		LEFT JOIN magic mg ON clans_abil.magic=mg.id  where klan='".$user['klan']."';");
		while ($rows = mysql_fetch_array($self_abil))
		{
			if((int)$post[$rows[magic]]>=0)
			{

				$chg_magic[$rows[magic]]=(int)$post[$rows[magic]]; //��� �� �� ��� ���� �����
			}
				$my_magic[$rows[magic]]=$rows[maxcount];  //���-�� � ������
				$my_uses[$rows[magic]]=$rows['count'];  //��� ������
		}

		$abil=mysql_query("select * from clans_abil
		LEFT JOIN magic mg ON clans_abil.magic=mg.id  where klan='".$recrut['short']."';");
		while ($rows = mysql_fetch_array($abil))
		{
			$rc_magic[$rows[magic]]=$rows[maxcount]; //���-�� � �����
			$rc_uses[$rows[magic]]=$rows['count'];   //��� �����
		}

		foreach ($chg_magic as $k=>$v)
		{
			$max_mag=$my_magic[$k]+$rc_magic[$k]; //����� ����� (������ + ������)

			// echo  'mag '.$k.' new val '.$v.'<br>';
			// echo ' ����:' .$max_mag .'<br>';
			if($max_mag>=$v)
			{
				//  echo ' ��� �����:'. $my_magic[$k].' ���:'.$my_uses[$k].'<br>';
				//  echo ' ��� �����:'. $rc_magic[$k].' ���:'.$rc_uses[$k].'<br>';
				//�������� � �������
				if($rc_magic[$k]>$v)
				{
					if(($rc_magic[$k]-$rc_uses[$k])>=abs(($v-$rc_magic[$k])))
					{
						//  echo '������ ��������<br>';
						$sql_my ='UPDATE clans_abil SET maxcount=(maxcount-'.($v-$rc_magic[$k]).'),recrut_count=(recrut_count+'.($v-$rc_magic[$k]).') WHERE klan="'.$user['klan'].'" AND magic="'.$k.'";';
						$sql_rec='UPDATE clans_abil SET maxcount=(maxcount+'.($v-$rc_magic[$k]).') WHERE klan="'.$recrut['short'].'" AND magic="'.$k.'";';
						mysql_query($sql_my);
						mysql_query($sql_rec);
					}
					else
					{
						$add_uses=abs(($v-$rc_magic[$k]))-($rc_magic[$k]-$rc_uses[$k]);
						$sql_my ='UPDATE clans_abil SET maxcount=(maxcount-'.($v-$rc_magic[$k]).'), count=(count+'.$add_uses.'),recrut_count=recrut_count+('.($v-$rc_magic[$k]).')  WHERE klan="'.$user['klan'].'" AND magic="'.$k.'";';
						$sql_rec='UPDATE clans_abil SET maxcount=(maxcount+'.($v-$rc_magic[$k]).'), count=(count-'.$add_uses.')  WHERE klan="'.$recrut['short'].'" AND magic="'.$k.'";';
						mysql_query($sql_my);
						mysql_query($sql_rec);
					}
				}
				//������ �������
				if($rc_magic[$k]<$v)
				{
					if(($my_magic[$k]-$my_uses[$k])>=abs(($v-$rc_magic[$k])))
					{
						$sql_my ='UPDATE clans_abil SET maxcount=(maxcount-'.($v-$rc_magic[$k]).'),recrut_count=(recrut_count+'.($v-$rc_magic[$k]).') WHERE klan="'.$user['klan'].'" AND magic="'.$k.'";';
						$sql_rec='UPDATE clans_abil SET maxcount=(maxcount+'.($v-$rc_magic[$k]).') WHERE klan="'.$recrut['short'].'" AND magic="'.$k.'";';
						mysql_query($sql_my);
						mysql_query($sql_rec);
					}
					else
					{
						$add_uses=($v-$rc_magic[$k])-($my_magic[$k]-$my_uses[$k]);
						$sql_my ='UPDATE clans_abil SET maxcount=(maxcount-'.($v-$rc_magic[$k]).'), count=(count-'.$add_uses.'),recrut_count=(recrut_count+'.($v-$rc_magic[$k]).')  WHERE klan="'.$user['klan'].'" AND magic="'.$k.'";';
						$sql_rec='UPDATE clans_abil SET maxcount=(maxcount+'.($v-$rc_magic[$k]).'), count=(count+'.$add_uses.')  WHERE klan="'.$recrut['short'].'" AND magic="'.$k.'";';
						mysql_query($sql_my);
						mysql_query($sql_rec);
					}
				}
			}
			else
			{
				$error1 = '�� ������ �������� ������ ��� ��� ������...';
				echo '�� ������ �������� ������ ��� ��� ������...<br>';
			}

		}
	}

	echo '<form action="?'.$faction.'" method="post">';
	$my_magic=array();
	$count=array();

	$abil_id=array(1,54,55,56,57,15,14,59,82,2525,53,212,5521,5520,10000,5500,5501,5502,5503,5504,5505,5506,5507,5508,5509,5510,5511,5512,5513,5514,5515,5516,5517,5518,5519);
             //  1,54,55,56,57,51,15,14,59,82
	$self_abil=mysql_query("select * from clans_abil
	LEFT JOIN oldbk.magic mg
	ON clans_abil.magic=mg.id
	where klan='".$user['klan']."';");
	
	
	
	while ($rows = mysql_fetch_array($self_abil))
	{
		$my_magic[$rows[magic]]=$rows[maxcount];
		$count_uses[$rows[magic]]=$rows['count'];

		$rows[img]=($rows[magic]==66?'labticket.gif':$rows[img]);
        	//$rows[img]=($rows[magic]==51?'note.gif':$rows[img]);
                $rows[img]=($rows[magic]==2525?'attackbv.gif':$rows[img]);
                $rows[img]=($rows[magic]==82?'lmap.gif':$rows[img]);        	

		$img[$rows[magic]]=$rows[img];
		$name[$rows[magic]]=$rows[name];
		$rekr_count[$rows[magic]]=$rows[recrut_count];
	}


	$abil=mysql_query("select * from clans_abil ca
	LEFT JOIN magic mg ON ca.magic=mg.id  where klan='".$recrut['short']."';");
	

	
	
	if(mysql_num_rows($abil)>0)
	{
		while ($rows = mysql_fetch_array($abil))
		{
			$rec_magic[$rows[magic]]=$rows[maxcount];
			$rec_count_uses[$rows[magic]]=$rows['count'];
			$count[$rows[magic]]=$rows[maxcount];

		}
	}
	
	
	/*if ($user[id]==14897)
	{
	print_r($my_magic);
	echo '<br>';
	print_r($rec_magic);
	echo '<br>qwe';
	}
	*/
	echo "<table border=0><tr><td align=left>";

	for($aa=0;$aa<count($abil_id);$aa++)
	{
	
		if(!(isset($rec_magic[$abil_id[$aa]])))
		{
		
			mysql_query('INSERT into clans_abil (klan,magic) values	("'.$recrut['short'].'",'.$abil_id[$aa].')');
			$rec_magic[$abil_id[$aa]]=0;
			$rec_count_uses[$abil_id[$aa]]=0;

		}
		else
		{
			//if ($user[id]==14897) echo "ok magic!";
			
		}

		$mmm=$my_magic[$abil_id[$aa]]+$rec_magic[$abil_id[$aa]];
		$mmn=$my_magic[$abil_id[$aa]]-$rec_count_uses[$abil_id[$aa]];


		if($mmm>0){
		echo "<img src='http://i.oldbk.com/i/sh/".$img[$abil_id[$aa]]."' alt='".$name[$abil_id[$aa]]."' title='".$name[$abil_id[$aa]]."'>
				".$name[$abil_id[$aa]]." /0-���./".$mmm."-����.<input type=text name='".$abil_id[$aa]."'
				value='".$count[$abil_id[$aa]]."' size=6> ����� �������� ���-".$my_magic[$abil_id[$aa]] ;
			
			if ($user[id]==14897)				
				{
				echo " ��������� ��������: {$rekr_count[$abil_id[$aa]]}  ";
				}
				echo "<br>";
		}
	}
	echo "</td></tr><table>";
	echo "<input type=submit name='abilcladd' value='����������'>";
	echo "</form>";
	//print_r($my_magic);
	echo '<br>';

}
?>