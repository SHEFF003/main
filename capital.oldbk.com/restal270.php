<?
//��������� ��� ����
///////////////////////////

    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {
    $miniBB_gzipper_encoding = 'x-gzip';
    }
    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    $miniBB_gzipper_encoding = 'gzip';
    }
    if (isset($miniBB_gzipper_encoding)) {
    ob_start();
    }
    function percent($a, $b) {
    $c = $b/$a*100;
    return $c;
    }
//////////////////////////////

		session_start();
		$MAG_OFF=1; //������������� ������� ���������!
		if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die();}
		include ("connect.php");		
		include "functions.php";
		if (($user['battle']>0) OR ($user['battle_fin'] >0))  { header("Location: fbattle.php"); die(); }
		
		
		$my_tur_type=8; // ���� �� ��������� 4�
		$llevl=8;
		
		
		/*
		if($_GET[lvl]==8) 
		{ 
		$llevl=8;
		}
		elseif($_GET[lvl]==4) 
		{ 
		$llevl=4;
		}
		else if ($user[level] >= 8)
		{
		$llevl=8;
		} 
		*/

		

	function count_free($arr)
	{
	$ret=0;
		for ($i=1;$i<=16;$i++)
		{
		$pm="o".$i;
		 if ( $arr[$pm]>0 )
		 	{
			$ret++;	 	
		 	}
		}
	return (16-$ret);
	}

	function get_last_count($arr)		
	{
		for ($i=1;$i<=16;$i++)
		{
		$pm="o".$i;
		 if ( $arr[$pm]==0 )
		 	{
			return $pm;
		 	}
		}	
	return false;
	}
		


//if ($user[klan]=='radminion') { echo "Admin-info:<!- GZipper_Stats -> <br>";  }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="windows-1251">
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<META HTTP-EQUIV="imagetoolbar" CONTENT="no">
    <title>Old BK - �������: ��������� �������� (��� �����).</title>
    <link rel="StyleSheet" href="newstyle_loc4.css" type="text/css">
    <script type="text/javascript" src="/i/globaljs.js"></script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


	<SCRIPT LANGUAGE="JavaScript">
	function refreshPeriodic()
				{
				location.href='restal270.php?onlvl=<?=$onlvl;?>';//reload();
				timerID=setTimeout("refreshPeriodic()",30000);
				}
				timerID=setTimeout("refreshPeriodic()",30000);
	</SCRIPT>
    <style>
        table#questdiag {
            width: 500px;
        }
        table#questdiag td img {
            display: block;
        }

        #page-wrapper #questdiag {
            table-layout: auto;
        }

        #page-wrapper #questdiag td {
            padding: 0px;
        }
    </style>
    
</head>
<body>
<?
make_quest_div(true);
?>
<div id="page-wrapper">
    <div class="title">
        <div class="h3">
            �������: ��������� �������� <i>(��� �����)</i>.
        </div>
        <div style="color:#8f0000;">������� ���� ����� �� ���������� ������ � �������� ������� � ���������!</div>
        <div id="buttons">
            <a class="button-dark-mid btn" style="font-weight: bold;" href="javascript:void(0);" title="���������" onclick="window.open('help/r270.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes');">�������</a>
            <a class="button-mid btn" href="javascript:void(0);" title="��������" onclick="location.href='restal270.php?refresh=<?echo mt_rand(1111,9999);?>';" >��������</a>
           <?
            if ($user[in_tower]==0)
            {
            ?>
            <a class="button-mid btn" href="javascript:void(0);" title="���������" onclick="location.href='restal270.php?got=1&level=200';" >���������</a>
            <?
            }
            ?>
            
            
        </div>
    </div>


 <?
   $nazv[4]='<i>(��������)</i> '; $skl[4]=" type = '304'"; 
   $nazv[8]='<i>(�����)</i>'; $skl[8]=" type = '308'"; 
 
     
 
  if ($user[in_tower]==3)
  {
  
                         if(!$_SESSION['beginer_quest'][none])
					     {
					     	  $last_q=check_last_quest(11);
						      if($last_q)
						      {
						          quest_check_type_11($last_q,$_SESSION[uid],'ON');
						       }
					     }  
  
  
  $get_tur_info=mysql_fetch_array(mysql_query("select *, UNIX_TIMESTAMP(stat_time) as uns_time from ntur_users where id='{$user[id_grup]}' and stat>0"));
  
  
/*   	echo "<div align=right>
	<form method=GET action='restal270.php'>";
	echo "<input value=\"������� �������������\" style=\"background-color:#A9AFC0\" onclick=\"window.open('restal_profile.php', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')\" type=\"button\"> 
	</form></div>";*/
   

   echo "
   <TABLE width=100% height=100% border=0 cellspacing=0 cellpadding=0>
	<TR valign=top>
	<TD width=5% align=center>&nbsp;</TD>
	<TD width=85%>";

   //������ ������ ���� �������� ���
		if ($get_tur_info[stat]==2)
		{
		   $de_time=time()-$get_tur_info[uns_time];
		   
		   /*
			2-� ����, ��� 16 �������� ��������� - ����� �� �������� 3 ������ 180
			3-� ����, ��� 8 ������� ��������� - ����� �� �������� 4 ������ 240
			4-� ����, ��� 4 �������� ��������� - ����� �� �������� 5 ������ 300
			5-� ����, ��� 2 �������� ��������� - ����� �� �������� 5 �����
		   */
		   
		   $faz=300;
		   $fazatime[1]=180;
		   $fazatime[2]=240;		   
		   
		   if ($fazatime[$get_tur_info['faza']]>0) { $faz=$fazatime[$get_tur_info['faza']]; }
		   
		   $de_time=$faz-$de_time;
		   
		   echo "<font color=red>";
		    if ($de_time>0)
		   	{
		  	   echo "��� ��� �������� �����:<b>".$de_time." ���.</b> ";
		   	}
		   	else
		   	{
		   	   echo "��� ��� �������� �����:<b>��������� ������.</b> ";
		   	}
		   echo "���� ��������� �������������� ��������� � ���������. ��� ���������� ������� � ������������ ����� �� ������ ���.";
		   echo "</font><br><br>";
		}
	
		$get_tur_log=mysql_fetch_array(mysql_query("select * from ntur_logs where id='{$get_tur_info[id]}' ;"));
		
		if ($get_tur_log[logs]!='')		{
									 $log_txt=str_replace("<BR>","<BR><HR>",$get_tur_log[logs]);
									 echo $log_txt; 
									 
									 }

	echo "</TD>
	<TD width=10% align=center><div>";
	
	//�����
	$hilled=$user[maxhp]-$user[hp];
	if (($_GET[hill]==1)and($hilled>0))
		{
			 $ss[1]='';
			 $ss[0]='a';
  			 mysql_query("UPDATE `users` set hp=maxhp where id='{$user[id]}' ");
		  	echo "<font color=red>�� ��������� ��������:<b>+".$hilled."HP</b></font>";
  	 		echo "<br><img src=http://i.oldbk.com/llabb/use_heal_off.gif alt='������ �������' title='������ �������' border=0>";
		}
		else
		if ($hilled>0)
		{
		echo "<br><br><a href=?hill=1><img src=http://i.oldbk.com/llabb/use_heal_on.gif alt='������������� �����' title='������������� �����' border=0></a>";
		}
		else
		{
		echo "<br><br><img src=http://i.oldbk.com/llabb/use_heal_off.gif alt='������ �������' title='������ �������' border=0>";
		}
	echo "</div></TD>			
	</TR>	
	</TABLE>";
  
  }
 else  if ($user[room]==270)
  {
  

			//temp fix- baggg
			mysql_query("DELETE from oldbk.inventory where bs_owner=3 and owner='{$user[id]}';");
				if (mysql_affected_rows()>0)
					{
					addchp('<font color=red>�������� 270!</font> FIX ��������� �� ID:'.$user[id].'  ','{[]}Bred{[]}',-1,0);
					}
  

  
  // ���� � �������� 
  // ����������
  // ������� ���������� ���� - ���������� �� ������� ��
	 ?>
	<div id="ristal"><BR>
        <table cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="60%">
                <col width="40%">
            </colgroup>
            <tbody>
            <tr>
                <td>
                    <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr class="head-line">
                            <th>
                                <div class="head-left"></div>
                                <div class="head-title">������� ������� � �������</div>
                                <div class="head-right"></div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="even">
                            <td>
	<?
	$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND ((`type` >=11 AND `type` <= 14) OR type=8270 )  ;"));
		

		$cost_prise[4]=1;
		$cost_prise[8]=20;
		$cpr=$cost_prise[$my_tur_type];
		
		if ( ($_GET[delname]) AND (($user[klan]=='radminion') OR ($user[klan]=='pal') OR ($user[klan]=='Adminion') ) )
		{
		$did=(int)($_GET[delname]);
			mysql_query("UPDATE `ntur_users` SET `nazva`='�������' WHERE `id`={$did} and stat=0 ;");
			if (mysql_affected_rows() >0)
			{
			err('�������� �������!');
			}
		}
		elseif (($_GET[delkom]) AND (($user[klan]=='radminion') OR ($user[klan]=='pal') OR ($user[klan]=='Adminion') ) )
		{
		$did=(int)($_GET[delkom]);
			mysql_query("UPDATE `ntur_users` SET `koment`='�������' WHERE `id`={$did} and stat=0 ;");
			if (mysql_affected_rows() >0)
			{
			err('����������� ������!');
			}
		}
		else
		if (($_GET['got'] && $_GET['level']==200) and  ($user[battle]==0) and ($user[room]==270))
		{
		if ($user[id_grup]!=0)
			{
			echo "<font color=red><b>�� � ������ �� ������!</b></font><br>";										
			}
			else
			{
			mysql_query("UPDATE `users` SET `users`.`room` = '200' WHERE  `users`.`id`  = '{$user[id]}' ;");
			header('location: city.php?strah=1&tmp=0.984564546654433177');
			die();
			}
		}		
	else
	//// ������� �������� �� ���� + �������� �� ������ 
	if ($eff[id]>0)
	{
		if ($eff[type]==8270)
		    {
		     if (($eff['time']-time())<0)
		     	{
		     	$out_dt=60-date("s")+2; //2 ������� ������
			echo "<font color=red>�� ������ �������� \"��������� ��������\" ����� ".$out_dt." ���.</font>";		     	
		     	}
		     	else
		     	{
		     	$out_dt=$eff['time']-time();
			echo "<font color=red>�� ������ �������� \"��������� ��������\" ����� ".floor(($out_dt)/60/60)." �. ".round((($out_dt)/60)-(floor(($out_dt)/3600)*60))." ���.</font>";		     	
		     	}

		    }
		    else
		    {
		    echo "<font color=red>�������������� ���� �� �������....</font>";		    
		    }
	}
	elseif ($user[level] < 8 ) 
		{ 
		echo "<font color=red><b>� ��� ������� �������!</b></font>";				
		} 
	elseif ($user[hidden]>0)
		{
		echo "<font color=red><b>��������� ����� ������ ���������...</b></font>";		
		}
	elseif ($user[align]==4)
		{
		echo "<font color=red><b>���� ����� ������ ���������...</b></font>";
		}	
	elseif (($_POST[nazv]) AND ($user[id_grup]==0) )
		{
		if ($user[money]>=$cpr)
			{
			mysql_query("UPDATE users set  money=money-'{$cpr}' where id='{$user[id]}' and money>='{$cpr}' LIMIT 1;");					
				if (mysql_affected_rows() >0)
				{		
				//������� ����� ������
							if ($_POST[mkpass]!='')
								{
								$ps=mysql_real_escape_string($_POST[mkpass]);
								}
								else
								{
								$ps='';
								}
				
				mysql_query("INSERT INTO `ntur_users` SET `ntype`='{$my_tur_type}',`stat`=0,`nazva`='".htmlspecialchars(mysql_real_escape_string($_POST[nazv]))."',`pas`='{$ps}',`koment`='".htmlspecialchars(mysql_real_escape_string($_POST[mkcom]))."',`o1`='{$user[id]}';");
				if (mysql_affected_rows() >0)
					{
					$newid_grup=mysql_insert_id();
					mysql_query("UPDATE users set  id_grup='{$newid_grup}' where id='{$user[id]}' LIMIT 1 ;");					
					echo "<font color=red><b>����� ������ ������!</b></font><br>";										
					$user[id_grup]=$newid_grup;
					//����� � ����
					$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user[money];
					$user['money'] -= $cpr;
					$rec['owner_balans_posle']=$user[money];
					$rec['target']=0;
					$rec['target_login']='���������';
					$rec['type']=366;//�������
					$rec['sum_kr']=$cpr;
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;
					$rec['item_id']='';
					$rec['item_name']='';
					$rec['item_count']='';
					$rec['item_type']='';
					$rec['item_cost']='';
					$rec['item_dur']='';
					$rec['item_maxdur']='';
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					add_to_new_delo($rec); 
					}
					else
					{
					mysql_query("UPDATE users set  money=money+'{$cpr}' where id='{$user[id]}' LIMIT 1 ;");//������ ������
					echo "<font color=red><b>������ �������� ������ �������!</b></font><br>";					
					}
				}
				else
				{
					echo "<font color=red><b>������ �������� ������ �������! �� ������� �������� ��� �������� �������!</b></font><br>";
				}
			}
			else
			{
					echo "<font color=red><b>������ �������� ������ �������! �� ������� �������� ��� �������� �������!</b></font><br>";
			}
		} 
		else if  (  ((int)($_POST[ntid]) > 0) AND ($_POST[goin]) AND ($user[id_grup]==0) ) 
		{
			$wntid=(int)($_POST[ntid]);
			if ($user[money]>=$cpr)
			{
				//��������  ����� �� ������� � ������������� ������
				$test_tur=mysql_fetch_array(mysql_query("select * from ntur_users where id='{$wntid}' and stat=0"));
				if ($test_tur[id]>0)
				{
					$us_cel=get_last_count($test_tur);
					if ($us_cel)
					{

						//��� �������� ���� �� �������� ����� ���� ��� � ������� - ������
						$get_test_telo=mysql_fetch_array(mysql_query("select * from ntur_users where  id='{$wntid}' and (o1='{$user[id]}' or o2='{$user[id]}' or o3='{$user[id]}' or o4='{$user[id]}' or o5='{$user[id]}' or o6='{$user[id]}' or o7='{$user[id]}' or o8='{$user[id]}' or o9='{$user[id]}'  or o10='{$user[id]}' or o11='{$user[id]}' or o12='{$user[id]}' or o13='{$user[id]}' or o14='{$user[id]}' or o15='{$user[id]}'  or o16='{$user[id]}' or o17='{$user[id]}' or o18='{$user[id]}'  or o19='{$user[id]}' or o20='{$user[id]}' or o21='{$user[id]}' or o22='{$user[id]}'  or o23='{$user[id]}' or o24='{$user[id]}' or o25='{$user[id]}' or o26='{$user[id]}'  or o27='{$user[id]}' or o28='{$user[id]}' or o29='{$user[id]}' or o30='{$user[id]}' or o31='{$user[id]}'  or o32='{$user[id]}') "));

						if ($get_test_telo['id']>0)
						{
							//������ ���� ��� ���� � �������
							//�� ������
							mysql_query("UPDATE users set  id_grup='{$wntid}' where id='{$user[id]}' LIMIT 1 ;");
							$user[id_grup]=$wntid;
						}
						else
						{
							//�������� ������
							$allook=true;
							if  ($test_tur['pas']!='')
							{
								if  ($test_tur['pas']!=$_POST['gopass'])
								{
									echo "<font color=red><b>������! �������� ������!</b></font><br>";
									$allook=false;
								}
							}

							try {
								$_can = \components\Helper\location\BaseLocation::getLocation(
									\components\Helper\location\BaseLocation::LOCATION_NTUR,
									$user
								);
								if(!$_can->can($wntid)) {
									throw new Exception();
								}
							} catch (Exception $ex) {
							    echo '<B><FONT COLOR=red>� ������ IP ��� ������ ������ �� �������.</FONT></B>';
								$allook = false;
							}

							if ($allook)
							{
								mysql_query("UPDATE users set  money=money-'{$cpr}' where id='{$user[id]}' and money>='{$cpr}' LIMIT 1;");
								if (mysql_affected_rows() >0)
								{
									if ($us_cel=='o16') { $add_sql=" , stat=1 "; } else { $add_sql=""; } //��������� ���������� - � ������ ������ �� 1 - ������ �������

									mysql_query("UPDATE  `ntur_users` SET `{$us_cel}`='{$user[id]}' ".$add_sql."  WHERE `id`='{$wntid}' and stat=0 and `{$us_cel}`=0 ;");

									if (mysql_affected_rows() >0)
									{
										mysql_query("UPDATE users set  id_grup='{$wntid}' where id='{$user[id]}' LIMIT 1 ;");
										echo "<font color=red><b>�� ����� � ������ ".($test_tur[nazva]!=''?"�{$test_tur[nazva]}�":"")."!</b></font><br>";
										$user[id_grup]=$wntid;
										//����� � ����

										$rec['owner']=$user[id];
										$rec['owner_login']=$user[login];
										$rec['owner_balans_do']=$user[money];
										$user['money'] -= $cpr;
										$rec['owner_balans_posle']=$user[money];
										$rec['target']=0;
										$rec['target_login']='���������';
										$rec['type']=366;//�������
										$rec['sum_kr']=$cpr;
										$rec['sum_ekr']=0;
										$rec['sum_kom']=0;
										$rec['item_id']='';
										$rec['item_name']='';
										$rec['item_count']='';
										$rec['item_type']='';
										$rec['item_cost']='';
										$rec['item_dur']='';
										$rec['item_maxdur']='';
										$rec['item_ups']=0;
										$rec['item_unic']=0;
										$rec['item_incmagic']='';
										$rec['item_incmagic_count']='';
										$rec['item_arsenal']='';
										$rec['add_info']='������ �'.$wntid;
										add_to_new_delo($rec);

									}
									else
									{
										mysql_query("UPDATE users set  money=money+'{$cpr}' where id='{$user[id]}' LIMIT 1 ;");//������ ������
										echo "<font color=red><b>������ ����� � ������!</b></font><br>";
									}
								}
								else
								{
									echo "<font color=red><b>������! �� ������� �������� ��� �������!</b></font><br>";
								}
							}

						}

					}
					else
					{
						echo "<font color=red><b>������! �� �� ������! ������ ��� ������!</b></font><br>";
					}
				}
				else
				{
					echo "<font color=red><b>������! ������ �� ������!</b></font><br>";
				}
			}
			else
			{
				echo "<font color=red><b>������! �� ������� �������� ��� �������� �������!</b></font><br>";
			}
			
		}
		else if  (  ((int)($_POST[ntid]) > 0) AND ($_POST[cancel]) AND ($user[id_grup]>0) ) 
		{

			mysql_query("UPDATE ntur_users set stat=5  where id='{$user[id_grup]}' and o1='{$user[id]}' and stat=0 and o2=0 and o3=0;");	 
			if (mysql_affected_rows() >0)		
				{
					$cpr=$cost_prise[$my_tur_type];				
					mysql_query("UPDATE users set  money=money+'{$cpr}' , room=270, id_grup=0 where id='{$user[id]}' LIMIT 1 ;");//������ ������

					//����� � ����
					$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user[money];
					$rec['owner_balans_posle']=($user[money]+$cpr);					
					$rec['target']=0;
					$rec['target_login']='���������';
					$rec['type']=367;//�������
					$rec['sum_kr']=$cpr;
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;
					$rec['item_id']='';
					$rec['item_name']='';
					$rec['item_count']='';
					$rec['item_type']='';
					$rec['item_cost']='';
					$rec['item_dur']='';
					$rec['item_maxdur']='';
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					add_to_new_delo($rec); 
					
		   	     		addchp ('<font color=red>��������!</font> �� ���������� �� �������. ��� ���������� '.$cpr.' ��. ','{[]}'.$user[login].'{[]}',$user[room],$user[id_city]);					

		    	     	}
		

		}
                            
                            
                         	if (!($user[id_grup]>0))
					{
				echo '
        	                    <form method=post name="fml">
                	                �������� �������: <input type=text name=nazv size=20> �����������: <input type=text name=mkcom size=15> ������: <input type=text name=mkpass size=10><a href="javascript:void(0);" class="button-big btn" title="������� ������" onClick="document.fml.submit();" >������� ������</a>
                        	        </form>';
					}
                            ?>
                            </td>
                        </tr>
                        <tr class="odd">
                            <td>
                                <ul>
				
				<?
					//������ ������ �� ��������� ���������
					$get_all_free=mysql_query("select * , UNIX_TIMESTAMP(mktime) as utm  from ntur_users where (stat=0 or stat=1 )  and ntype='{$my_tur_type}' order by stat,mktime ");
				
				   if (mysql_num_rows($get_all_free)  > 0)
				   	{
					while ($frow = mysql_fetch_array($get_all_free)) 
							{
							
							echo '<li>';
							
							$free=count_free($frow);	
							if (($user[id_grup]==0) and ($frow[stat]==0))	echo "<form method=post name='frm".$frow[id]."'> ";
				 			if ($user[id_grup]==$frow[id]) { echo ""; }
				 			if (($user[id_grup]==$frow[id]) AND ($free==15)) { echo "<form method=post name='frm".$frow[id]."'> "; }

				 				$txt_cansel_time=1800-(time()-$frow[utm]);
				 				if ($txt_cansel_time<0) { $txt_cansel_time=0; }
				 				
				 				$txt_cansel_time_m=(int)($txt_cansel_time/60);
				 				$txt_cansel_time_s=$txt_cansel_time-($txt_cansel_time_m*60);
				 				
				 				$txt_cansel="  (������ ������ �����: {$txt_cansel_time_m} ��� {$txt_cansel_time_s} ���)";
				 										
				 				if (($user[klan]=='radminion') OR ($user[klan]=='pal') OR ($user[klan]=='Adminion') )
								{
								if ($frow[nazva]!='�������') { $del_name="<a href=?delname=$frow[id]><img src='http://i.oldbk.com/i/clear.gif' alt='������� ��������' title='������� ��������'></a>"; }
								if ($frow[koment]!='�������') {	$del_kom="<a href=?delkom=$frow[id]><img src='http://i.oldbk.com/i/clear.gif' alt='������� �����������' title='������� �����������'></a> ";	}
								}
							
				 			
				 			if ($frow[stat]==0) 
				 			{
				 			echo "<div class=date>".($frow['mktime'])."</div><em> ������� ������ �� ������: <strong>".($frow[nazva]!=''?"�".$frow[nazva]."� {$del_name}  ":"")."</strong> �������� {$free} ���� �� 16� ".($frow[koment]!=''?"({$frow[koment]})</em> {$del_kom}":""); 
				 			}
				 			elseif ($frow[stat]==1) 
				 			{ 
				 			echo "<div class=date>".($frow['mktime'])."</div><em> ������ �� ������: ".($frow[nazva]!=''?"<i>�".$frow[nazva]."�</i>":"")."</strong>������� ��������� ������ ������� ".($frow[koment]!=''?"({$frow[koment]})</em> ":""); 
				 			}
				 			
				 			if ($user[id_grup]==$frow[id]) 	{echo "";  }
				 			if (($user[id_grup]==$frow[id]) AND ($free==15))
				 				{
				 				echo "<input type=hidden name=ntid value='{$frow[id]}'><input type=hidden name=cancel value='1'>";
				                                echo '<a href="javascript:void(0);" class="button-big btn" title="�������� ������" onClick="document.frm'.$frow[id].'.submit();"  >�������� ������</a>';
               			                                echo '<div class="mhint">'.$txt_cansel.'</div></form>'; 
				 				}
				 			elseif (($user[id_grup]==0) and ($frow[stat]==0))
				 			{ 
				 			echo "<input type=hidden name=ntid value='{$frow[id]}'><input type=hidden name=goin value='1'>";
				 			if ($frow['pas']!='')
				 					{
									echo "������: <input type=text name=gopass size=10>";
				 					}
			                                echo '<a href="javascript:void(0);" class="button-big btn" title="����� � ������ ('.$cpr.'��)" onClick="document.frm'.$frow[id].'.submit();"  >����� � ������ ('.$cpr.'��)</a>';
			                                echo '<div class="mhint">'.$txt_cansel.'</div></form>'; 
			                                } 
								else
								{
				                                echo '<div class="mhint">'.$txt_cansel.'</div>';
								}
							
				                        echo '</li>';
							}
					}		
					else
					{
					echo "<li><b>��� �������� ������!</b></li>";
					}
				?>
                                </ul>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                              
                                <em style="color: red;">��������� ������� � ������� <?=$cpr;?> ��������.</em> 
                              
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="info">
                        �� ������ ������� �� ������ ��������������� "��������� �������������", ����� ������� ��������� ������� ��� ���
                        ��������, ������� ��� ������������� ����� ����������� ��� ������������ � �������. ��� ����� ���� �������� �������
                        ��� ������������� ������.
                    </div>
                    <?
                    //��� �� ��������

$head = <<<HEAD
	<font color=red><b>%ERROR%</b></font>
				<tbody>%PROFILES%</tbody>	
<BR>	
HEAD;


$main = <<<MAIN
	<script>
		function countall() {
			document.getElementById('stats').value = %USERALL%-Math.abs(document.getElementById('sila').value)-Math.abs(document.getElementById('lovk').value)-Math.abs(document.getElementById('inta').value)-Math.abs(document.getElementById('vinos').value)-Math.abs(document.getElementById('intel').value)-Math.abs(document.getElementById('mudra').value);
		}
	</script>

	<form method="POST" name=statsform>
		��������: <input type="text" name="name" value="%CURRENT%">
		
		<table class="stats" cellspacing="0" cellpadding="0">
                                    <colgroup>
                                        <col width="100px">
                                        <col width="100px">
                                        <col width="100px">
                                        <col width="100px">
                                        <col>
                                    </colgroup>
                                    <tbody>
                                        <tr>
                                            <td>����</td>
                                            <td>
						<input type="text" id="sila" size=4 onblur="countall();" value="%SILA%" name="sila">
                                            </td>
                                            <td>
                                                ���������
                                            </td>
                                            <td>
						<input type="text" id="intel" size=4 onblur="countall();" value="%INTEL%" name="intel">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>��������</td>
                                            <td>
						<input type="text" id="lovk" size=4 onblur="countall();" value="%LOVK%" name="lovk">
                                            </td>
                                            <td>
                                                ��������
                                            </td>
                                            <td>
						<input type="text" id="mudra" size=4 onblur="countall();" value="%MUDRA%" name="mudra">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>��������</td>
                                            <td>
							<input type="text" id="inta" size=4 onblur="countall();" value="%INTA%" name="inta">
                                            </td>
                                            <td>
                                                ���������
                                            </td>
                                            <td>
                                                <input type="text" id="stats" name="stats" size=4 disabled value="%USERALLLEFT%">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>������������</td>
                                            <td>
						<input type="text" id="vinos" size=4 onblur="countall();" value="%VINOS%" name="vinos">
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
		
		 <a href="javascript:void(0);" class="button-big btn" title="���������/��������" OnClick="if (document.getElementById('stats').value != 0) { alert('������ ������������� ������! '); return false; }else{ document.statsform.submit(); } ">���������/��������</a>
	 	</form>
MAIN;
                    
                    
                    	if (isset($_GET['delsn'])) 
                    	{
			$prof_view=true;
				if ($user['zayavka'] == 0) {
			$_GET['delsn'] = intval($_GET['delsn']);
			mysql_query('DELETE FROM `ntur_profile` WHERE `id` = '.$_GET['delsn'].' AND `owner` = '.$user['id']) or die();
			} 
			else 
				{
					$head = str_replace('%ERROR%','������ ������� � ������',$head);
				}
			}
			elseif	(isset($_GET['setcopy']))
			{
	                $prof_view=true;			
				$_GET['setcopy'] = intval($_GET['setcopy']);
				$q = mysql_query('SELECT * FROM ntur_profile WHERE `owner` =0 AND id = '.$_GET['setcopy']) or die();
				if (mysql_num_rows($q) > 0) 
				{
				
					
				
					$df=mysql_fetch_assoc($q) or die();

					mysql_query('UPDATE `ntur_profile` SET `def` = 0 WHERE `owner` = '.$user['id']) or die();
					
					$q = mysql_query('INSERT `ntur_profile` 
									(`owner`,`name`,`sila`,`lovk`,`inta`,`vinos`,`intel`,`mudra`, `def`)
									VALUES (
										"'.$user['id'].'",
										"'.$df['name'].'",
										"'.abs($df['sila']).'",
										"'.abs($df['lovk']).'",
										"'.abs($df['inta']).'",
										"'.abs($df['vinos']).'",
										"'.abs($df['intel']).'",
										"'.abs($df['mudra']).'",
										"1"
									) ON DUPLICATE KEY UPDATE
										`sila` = "'.abs($df['sila']).'",
										`lovk` = "'.abs($df['lovk']).'",
										`inta` = "'.abs($df['inta']).'",
										`vinos` = "'.abs($df['vinos']).'",
										`intel` = "'.abs($df['intel']).'",
										`mudra` = "'.abs($df['mudra']).'",
										`def`=1
									') or die();
					$head = str_replace('%ERROR%','��������������� ������� ������ � ���������� �� ���������!)',$head);
				}
			
			}
			elseif (isset($_GET['setdef'])) 
			{
	                $prof_view=true;			
				$_GET['setdef'] = intval($_GET['setdef']);
				$q = mysql_query('SELECT * FROM ntur_profile WHERE `owner` = '.$user['id'].' AND id = '.$_GET['setdef']) or die();
				if (mysql_num_rows($q) > 0) 
				{
				mysql_query('UPDATE `ntur_profile` SET `def` = 1 WHERE `owner` = '.$user['id'].' AND  `id` = '.$_GET['setdef']) or die();
				mysql_query('UPDATE `ntur_profile` SET `def` = 0 WHERE `owner` = '.$user['id'].' AND  `id` <> '.$_GET['setdef']) or die();
				}
				$head = str_replace('%ERROR%','���������',$head);
			}
			
			
				$sts[4] = 50;
				$sts[8] = 98;
				
				$my_tur_type=8; // ���� �� ��������� 4�
				//if ($user[level] >= 8 ) { $my_tur_type=8; } //���� 8�� =8�
				
				$stats = $sts[$my_tur_type];
                    
 				if(isset($_POST['name']))
 				{
		                $prof_view=true;
							// ��������� ����� ������
							$postedstats = abs($_POST['sila'])+abs($_POST['lovk'])+abs($_POST['inta'])+abs($_POST['vinos'])+abs($_POST['intel'])+abs($_POST['mudra']);
							if ($stats == $postedstats && abs($_POST['vinos']) > 0) {
								$q = mysql_query('
									INSERT `ntur_profile` 
									(`owner`,`name`,`sila`,`lovk`,`inta`,`vinos`,`intel`,`mudra`, `def`)
									VALUES (
										"'.$user['id'].'",
										"'.$_POST['name'].'",
										"'.abs($_POST['sila']).'",
										"'.abs($_POST['lovk']).'",
										"'.abs($_POST['inta']).'",
										"'.abs($_POST['vinos']).'",
										"'.abs($_POST['intel']).'",
										"'.abs($_POST['mudra']).'",
										"0"
									) ON DUPLICATE KEY UPDATE
										`sila` = "'.abs($_POST['sila']).'",
										`lovk` = "'.abs($_POST['lovk']).'",
										`inta` = "'.abs($_POST['inta']).'",
										`vinos` = "'.abs($_POST['vinos']).'",
										`intel` = "'.abs($_POST['intel']).'",
										`mudra` = "'.abs($_POST['mudra']).'"
								') or die();
								$head = str_replace('%ERROR%','���������',$head);
							} else {
								$head = str_replace('%ERROR%','���-�� �� �� �� �������... ����� ���������. ���������� ������������ ��� �����!',$head);
							}
					}
					
						$main = str_replace("%USERALL%",$stats,$main);
						$main = str_replace("%BONUSSILA%",$user['bpbonussila'],$main);                   
				
					if (isset($_GET['id'])) 
					{
			                $prof_view=true;
					$q = mysql_query('SELECT * FROM ntur_profile WHERE (`owner` = '.$user['id'].' OR `owner`=0)   AND `id` = '.intval($_GET['id'])) or die();
					if (mysql_num_rows($q) == 0) Redirect('restal_profile.php');
					$current = mysql_fetch_assoc($q) or die();
			
					$main = str_replace("%USERALLLEFT%",$stats-$current['sila']-$current['lovk']-$current['inta']-$current['vinos']-$current['intel']-$current['mudra'],$main);
					$main = str_replace("%CURRENT%",$current['name'],$main);
					$main = str_replace("%SILA%",$current['sila'],$main);
					$main = str_replace("%LOVK%",$current['lovk'],$main);
					$main = str_replace("%INTA%",$current['inta'],$main);
					$main = str_replace("%VINOS%",$current['vinos'],$main);
					$main = str_replace("%INTEL%",$current['intel'],$main);
					$main = str_replace("%MUDRA%",$current['mudra'],$main);
					} else {
					$main = str_replace("%USERALLLEFT%",$stats,$main);
					$main = str_replace("%CURRENT%",'',$main);
					$main = str_replace("%SILA%",'',$main);
					$main = str_replace("%LOVK%",'',$main);
					$main = str_replace("%INTA%",'',$main);
					$main = str_replace("%VINOS%",'',$main);
					$main = str_replace("%INTEL%",'',$main);
					$main = str_replace("%MUDRA%",'',$main);
					}
			
				$prof = "";
				$data = mysql_query('SELECT * FROM `ntur_profile` WHERE `owner`=0 OR  `owner` = '.$user['id']) or die();
				while($row = mysql_fetch_array($data)) 
				{
				        $prof .='<tr><td>
                                                <a class="item" href="javascript:void(0);" onclick=\'location.href="restal270.php?id='.$row['id'].'";\'  >'.$row['name'].($row['owner']==0 ? " (��������������� �������)":"").'</a>
                                            </td>
                                            <td class="center">';
                                            
                                       if ($row['owner']==0)
                                		{
                                            	$prof .='<a href="?setcopy='.$row['id'].'" class="status"> ���������� </a>';
                                		}
                                		else
                                		{
                                            $prof .='<a href="?setdef='.($row['def'] ? "" : $row['id']).'"'.($row['def'] ? ' class="status active"> �� ���������' : 'class="status"> ����������').'</a>';
                                                }
                                           $prof .='</td>
                                            <td class="center">';
                                         if ($row['owner']!=0) $prof .='<a class="delete" href="?delsn='.$row['id'].'">x</a>';
                                         $prof .='</td></tr>';
				}
	
				$head = str_replace('%ERROR%','',$head);
				$head = str_replace('%PROFILES%',$prof,$head);
                    

                    
                    ?>
                    
                    
                    <table class="profile-stats" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr class="head-line">
                            <th>
                                <div class="head-left"></div>
                                <div class="head-title">������� �������������</div>
                                <div class="head-right"></div>
                                <a class="spoiler right spoiler-<? if ($prof_view) { echo 'up';} else { echo 'down';} ?>" href="javascript:void(0);"></a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                         if ($prof_view)
                         	{
                         	echo '<tr>';
                         	}
                         	else
                         	{
                         	echo '<tr  class="hidden" >';
                         	}
                        ?>
                            <td>
                                <table class="profile" cellspacing="0" cellpadding="0">
                                    <colgroup>
                                        <col>
                                        <col width="150px">
                                        <col width="100px">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>�������� �������</th>
                                            <th>������</th>
                                            <th>�������</th>
                                        </tr>
                                    </thead>
                                 <? echo $head; ?>
                                </table>
                            </td>
                        </tr>
                        <?
	                  if ($prof_view)
                         	{
                         	echo '<tr>';
                         	}
                         	else
                         	{
                         	echo '<tr  class="hidden" >';
                         	}
                        ?>
                            <td>
                             <? echo $main;  ?>
                            </td>
                        </tr>
                        <?
                          if ($prof_view)
                         	{
                         	echo '<tr class="even">';
                         	}
                         	else
                         	{
                         	echo '<tr class="even hidden">';
                         	}
                         ?>
                            <td>
                               
                            </td>
                        </tr>
                        </tbody>
                    </table>


	                 <table class="table" cellspacing="0" cellpadding="0">
                        <thead>
                        <tr class="head-line">
                            <th>
                                <div class="head-left"></div>
                                <div class="head-title">������� �������</div>
                                <div class="head-right"></div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
	<?
	
	$get_all_run=mysql_query("select *  from ntur_users where (stat=2 or stat=3 )  order by mktime ");
	if (mysql_num_rows($get_all_run)  > 0)
   	{
	while ($frow = mysql_fetch_array($get_all_run)) 
			{
			echo '<tr class="even"><td>';		
			echo "<FONT class=date>".($frow['mktime'])."</FONT> ������� ������ ".$nazv[$frow[ntype]]." : ".($frow[nazva]!=''?"<i>�".$frow[nazva]."�</i>":"")." ".($frow[koment]!=''?", <i>({$frow[koment]})</i> ":"")."<a href=/nturlog.php?id={$frow['id']} target=\"_blank\"> �� </a><br>"  ; 
			echo '</td></tr>';			 
			}
	}		
	else
	{
	echo '    <tr class="even">
                            <td>� ������ ������ ��� ������� ��������!</td>
                        </tr>';
	}

	?>
          </tbody>
          </table>	
	
 <table class="table" cellspacing="0" cellpadding="0">
                        <colgroup>
                            <col>
                            <col width="90px">
                            <col width="80px">
                        </colgroup>
                        <thead>
                        <tr class="head-line">
                            <th>
                                <div class="head-left"></div>
                                <div class="head-title">���������� 10-�� ���������� ��������: <span id="top10-title"><?=$nazv[$llevl];?></span></div>
                            <? /*  <div class="head-separate"></div> */ ?>
                            </th>
                            
                            <?
                            /*
                            <th>
                                <div class="head-title">
                                    <a class="top10-tab <? if ($llevl==4) echo 'active';?>" data-for="top10-newbie" href="?lvl=4">�������</a>
                                </div>
                                <div class="head-separate"></div>
                            </th>
                            <th>
                                <div class="head-title">
                                    <a class="top10-tab <? if ($llevl==8) echo 'active';?>" data-for="top10-obsh" href="?lvl=8">�����</a>
                                </div>
                                <div class="head-right"></div>
                            </th>
                             */
                            ?>

                            <th>
                                <div class="head-title">
                                </div>
                            </th>
                            <th>
                                <div class="head-title">
                                </div>
                                <div class="head-right"></div>
                            </th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="even">
                            <td colspan="3">
                                 <ul class="top10 active" id="top10-obsh">
                            <?
                            $tr = mysql_query("SELECT * FROM `ntur_logs` WHERE  ".$skl[$llevl]." and active=0 ORDER BY end_time DESC LIMIT 10;");
				if (mysql_num_rows($tr) > 0)
				{
				$kk=1;
				while ($trow = mysql_fetch_array($tr)) 
						{
						if ($trow['winer']=='') {$trow['winer']='<i>��� ����������</i>';}
						echo '<li>
		                                        <div class="num">'.$kk++.'</div>
		                                        <div class="win">����������:</div>
		                                        <div>
		                                            '.$trow['winer'].' ������ ������� <div class="date">'.date("d.m.y H:i",$trow['start_time']).'</div>
		                                            ����������������� <div class="date">'.floor(($trow['end_time']-$trow['start_time'])/60/60)." �. ".floor(($trow['end_time']-$trow['start_time'])/60-floor(($trow['end_time']-$trow['start_time'])/60/60)*60).'</div>
		                                            <a href="/nturlog.php?id='.$trow['id'].'" target="_blank"><strong>������� �������</strong></a>
		                                        </div>
		                                    </li>';
						}
				}
				else
				{
				echo "<li><i>���� ������� ���...</i></li>";
				}
                            ?>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
 <?
 }
 ?>
                </td>
                <td align="center" style="position:relative;vertical-align:top; background: url(http://i.oldbk.com/i/map/rista_270_fon.png) no-repeat; background-position-x:center;">
				<a href="?quest=1"><img  src="http://i.oldbk.com/i/map/rista_270_npc.png" alt="�������� ������" title="�������� ������" class="aFilter2" onmouseover="this.src='http://i.oldbk.com/i/map/rista_270_npc_hover.png'" onmouseout="this.src='http://i.oldbk.com/i/map/rista_270_npc.png'"/></a>
                <?php
				$mldiag = [];
				$mlquest = "30/30";
				if(isset($_GET['qaction']) && isset($_GET['d'])) {
					$BotDialog = new \components\Component\Quests\QuestDialogNew(\components\Helper\BotHelper::BOT_JAMES);
					//����� � ������ �������
					$dialog_id = isset($_GET['d']) ? (int)$_GET['d'] : null;
					$action_id = isset($_GET['a']) ? (int)$_GET['a'] : null;
					$dialog = $BotDialog->dialog($dialog_id, $action_id);
					if($dialog !== false) {
						$mldiag[0] = $dialog['message'];
						foreach ($dialog['actions'] as $action) {
							$key = '&a='.$action['action'];
							if(isset($action['dialog'])) {
								$key .= '&d='.$action['dialog'];
							}
							$mldiag[$key] = $action['message'];
						}
					}
				}

				if (isset($_GET['quest']) && empty($mldiag)) {
					$BotDialog = new \components\Component\Quests\QuestDialogNew(\components\Helper\BotHelper::BOT_JAMES);

					$mldiag[0] = '- ����������� ����, '.($user['sex'] == 1 ? "����" : "�����������").'!';

					foreach ($BotDialog->getMainDialog() as $dialog) {
						$key = '&d='.$dialog['dialog'];
						$mldiag[$key] = $dialog['title'];
					}

					$mldiag[4] = '- �������, � ���������.';

				}
				if(!empty($mldiag)) {
					require_once('mlquest.php');
				}
                ?>
				</div>
			</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $(document.body).on('click', '.spoiler', function(){
            var $self = $(this);
            var $table = $self.closest('table');
            var $td = $table.find('tr td');
            $td.slideToggle('fast');
            if($self.hasClass('spoiler-down')) {
                $self.removeClass('spoiler-down').addClass('spoiler-up');
            } else {
                $self.removeClass('spoiler-up').addClass('spoiler-down');
            }
        });

        $(document.body).on('click', 'a.top10-tab:not(.active)', function(){
            var $self = $(this);
            $('a.top10-tab').removeClass('active');
            $self.addClass('active');

            $('ul.top10').hide();
            $('ul#'+$self.data('for')).show();

            $self.closest('table').find('#top10-title').html($self.text());
        });
    });
</script>
</body>
</html>
<?
/////////////////////////////////////////////////////
    if (isset($miniBB_gzipper_encoding)) {
    $miniBB_gzipper_in = ob_get_contents();
    $miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
    $miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
    $miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
    $miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
    $gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
    $percent = round($gzpercent);
    $miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
    $miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
    ob_clean();
    header('Content-Encoding: '.$miniBB_gzipper_encoding);
    echo $miniBB_gzipper_out;
    }
/////////////////////////////////////////////////////
?>