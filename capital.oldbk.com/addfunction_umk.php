<?
// �������������� ������� by Umich
$eff_align_type=5001;
$eff_align_time=time()+60*60*24*30*2;
$war_price=100;

    if($user['sex']){
       $prem_shad=array('1001','1002','1003','1004','1005','1006','1007','1008','1009','1010');
    }
    	else
    {
       $prem_shad=array('1001','1002','1003','1004','1005','1006','1007','1008','1009','1010');
    }


	function del_clan_war_files($klan_short,$enemy)
	{
		if (file_exists("/www_logs/combats_wars/".$klan_short))
		{
			$load = file("/www_logs/combats_wars/".$klan_short);
	        $load=implode('',$load);
	        $load=explode(',',$load);
	        foreach($load as $k=>$v)
	        {
	        	if(in_array($v,$enemy))
	        	{
	        		unset($load[$k]);
	        	}
	        }
	   //      print_r($load);
		}

		if(count($load)>0)
		{
			$load=implode(',',$load);
			$save = fopen("/www_logs/combats_wars/".$klan_short,"w");
			fwrite($save,$load);
			fclose($save);
		}
		else
		{
            unlink("/www_logs/combats_wars/".$klan_short);
            mysql_query("DELETE FROM `clans_war_city_sync` WHERE `name`='{$klan_short}'");

		}
	}

	function write_clan_war_files($klan_short,$enemy)
	{
		if (!file_exists("/www_logs/combats_wars/".$klan_short))
		{
			$save = fopen("/www_logs/combats_wars/".$klan_short,"w");
		}
        else
        {
        	$load = file("/www_logs/combats_wars/".$klan_short);
	        $load=implode('',$load);
			$enemy=$load.','.$enemy;
			$save = fopen("/www_logs/combats_wars/".$klan_short,"w");
        }
		fwrite($save,$enemy);
		fclose($save);
	}

	function open_clan_war_files($klan_short)
	{
       	if (!file_exists("/www_logs/combats_wars/".$klan_short))
		{
			return FALSE;
		}
		else
		{
			$load = file("/www_logs/combats_wars/".$klan_short);
			return $load;
        }
	}

    function check_7_days($klan,$own_klan)
    {

       $data=mysql_query('select * from oldbk.`clans_war_2`
       where
       `date`>'.(time()-60*60*24*7).'
       AND
       	(
       		(defender='.$klan.' AND agressor='.$own_klan.')
       		OR
       		(defender='.$own_klan.' AND agressor='.$klan.')
       	);');
	   if(mysql_num_rows($data)>0)
	   {
           return '���� ���� ��� ����� �����, ��� �� ����� ������ ������� ��������....';
       }
       else
       {
       	  return false;
       }
    }

    function add_to_delo($price,$delo_txt,$glava=0)
	{
	  	if($glava==0)
	  	{
	  		$glava=$_SESSION['uid'];
	  	}

	  	if($price>0)
	  	{
	  		$price=$price*0.8;
	  	}
	  	// mysql_query('UPDATE users set money=money+'.$price.' WHERE id='.$glava.';');


		 mysql_query("INSERT INTO oldbk.`delo`
		 (`id` , `author` ,`pers`, `text`, `type`, `date`)
		 	VALUES
		 ('','0','".$glava."','".$delo_txt."',1,'".time()."');");
	}


    function check_wars_exist($klan,$check=0)
    {
    	$data=mysql_query('select * from oldbk.`clans_war_2` where (agressor='.$klan.' OR defender='.$klan.') AND date>'.time().' order by osnova desc;');
   	    if(mysql_num_rows($data)>0)
   	    {
	   		while($row=mysql_fetch_array($data))
    		{
    			$war_exist[$row[war_id]][$row[id]]=$row;
    		}
    		return $war_exist;
		}
		else
    	{
    		return false;
    	}
    }

    function show_klan_name($short,$align)
    {
        if($short=='pal')
        {
        	$align='1.99';
        }
        $klan='<img src=http://i.oldbk.com/i/align_'.$align.'.gif><img title='.($short=='pal'?'����� ���������':$short).' src=http://i.oldbk.com/i/klan/'.$short.'.gif><b>'.($short=='pal'?'����� ���������':$short).'</b><a target=_blank href=http://oldbk.com/encicl/klani/clans.php?clan='.$short.'><img src=http://i.oldbk.com/i/inf.gif></a>';
        return $klan;
    }

     //�������� ������ �� �����.
    function check_wars($klan,$check=0)
    {
   	    $data=mysql_query("select * from oldbk.`clans_war_vizov` where (agressor_id='".$klan."' OR defender_id='".$klan."') AND status=0;");
   	    if(mysql_num_rows($data)>0)
   	    {
	   		while($row=mysql_fetch_array($data))
    		{
    			$zayavka_exist[$row[id]]=$row;
    		}
    		return $zayavka_exist;
		}
		else
    	{
    		return false;
    	}
    }
    //�������� ����
    function check_ally($klan,$check=0)
    {
   	    if($check==0)
   	    {
	   	    $data=mysql_query("select * from oldbk.`clans_war_ally` where (war_klan='".$klan."' OR helper_klan='".$klan."');");
	   	    if(mysql_num_rows($data)>0)
	   	    {
		   		while($row=mysql_fetch_array($data))
	    		{
	    			$zayavka_exist[$row[id]]=$row;
	    		}
	    		return $zayavka_exist;
			}
			else
	    	{
	    		return false;
	    	}
	  	}
	  	elseif($check==1)
	  	{
            $data=mysql_query("select * from oldbk.`clans_war_ally` where helper_klan='".$klan."' AND helper_answer=1;");
	   	    if(mysql_num_rows($data)>0)
	   	    {
		   		while($row=mysql_fetch_array($data))
	    		{
	    			$zayavka_exist[$row[id]]=$row;
	    		}
	    		return $zayavka_exist;
			}
			else
	    	{
	    		return false;
	    	}
	  	}
    }
    //����� ������
    function check_start_war_time($number,$value)
    {
    	if($number=='2')
    	{

    		$timer=round(((($value-60*60*24-time())==0?1:($value-60*60*24-time()))/60),1);

	}
	else
	if($number=='24')
	{
		$timer=round((($value-time())>0?(($value-time())/60/60):0),1);
	}
        else
        if($number=='2st')
        {
           $timer=time()+60*60*24;
        }
        else
        if($number=='24st')
        {
           $timer=time();
        }
        return $timer;
    }

 function fields_name($table_name)
 {
   $res = mysql_query("select * from {$table_name} LIMIT 1");
	for($i=0;$i<mysql_num_fields($res);$i++)
		{
			$fields[$i]=mysql_field_name($res, $i);
		}
	$fields[] = $table_name;
    return $fields;
 }

 function n_fields($ff)
 {
  	if($ff=='stats')
  	{
  		$rr=array('gsila','glovk','ginta','gintel','gmp');
  	}
  	if($ff=='mfs')
  	{
  		$rr=array('mfkrit','mfakrit','mfuvorot','mfauvorot');
  	}
  	if($ff=='ups')
  	{
        $rr=array('nnoj','ntopor','ndubina','nmech',
        'nlevel','name','maxdur','delta_mf',
        'nsila','nlovk','ninta','nvinos','nintel',
        'minu','maxu',
        'gsila','glovk','ginta','gintel',
        'mfkrit','mfakrit','mfuvorot','mfauvorot',
        'bron1','bron2','bron3','bron4',
        'ghp','delta_stat');
  	}
  return $rr;
 }
  function downgrade_item($row,$rr,$chk=0,$riht=0)
 {
	global $user;
	$prot = mysql_query_cache("SELECT * FROM oldbk.`shop` WHERE  id = '".$row[prototype]."' AND id!=20000 LIMIT 1;",false,600); //������� ��������
	if (isset($prot[0])) {
		$prot = $prot[0];
	}

	if (!($prot[id]>0))
	{
		$prot = mysql_query_cache("SELECT * FROM oldbk.`eshop` WHERE  id = '".$row[prototype]."' AND id!=20000 LIMIT 1;",false,600); //������� ��������
		if (isset($prot[0])) {
			$prot = $prot[0];
		}
	}

	//��� ���� ��� ��������� ������  � ��������� �� � �������� ��� � �� ���������� ��������� �� � �����
	 if ($row['art_param']!='')
	 	{


	 		$get_art_bonus=mysql_fetch_assoc(mysql_query("select * from oldbk.art_bonus where itemid='{$row['id']}' "));

	 		if ($get_art_bonus['info'] !='')
	 			{
	 				$bonus_array=unserialize($get_art_bonus['info']); //��� ������
	 				if (is_array($bonus_array))
	 					{

							 foreach($bonus_array as $blevel=>$dat)
							 	{
							 	//������ �� �������
										 foreach($dat as $k=>$v)
										 	{
										 	//������ �� ������
										 	//��������� �� � ���������
											$prot[$k]+=$v;
									 	 	}
							 	}
	 					}

	 			}
	 	}
	  if  ($row['charka']!='')
	  	{
	  	$chrka_stat=0;
	  	$chrka_mf=0;
	  	$charka_bron=0;
	  	$chrka_hp=0;

  			$charka=substr($row['charka'], 2,strlen($row['charka'])-1); //���������� ������ ��� �������
			$inputbonus=unserialize($charka); //��� ������
				if (is_array($inputbonus))
					{
						foreach($inputbonus as $blevl => $bdata)
						{
								foreach($bdata as $pk => $pv)
									{
									foreach($pv as $k => $v)
										{
										$prot[$k]+=$v;

										//���������� ��� ��������
										if (($k=='gsila') or ($k=='glovk') or ($k=='ginta') or ($k=='gintel'))
											{
											$chrka_stat+=$v;
											}
										else
											if (($k=='mfkrit') or ($k=='mfakrit') or ($k=='mfuvorot') or ($k=='mfauvorot'))
											{
											$chrka_mf+=$v;
											}
										elseif ($k=='ghp')
											{
										  	$chrka_hp+=$v;
											}
										elseif ($k=='gbron')
											{
											$charka_bron+=$v;
											}
										}
									}
						}
					}

	  	}
	//	else 	 	if ($user['id']==14897) echo "ND1<br>";

	/////////////////////////////////////////////////////////////////////////////////////////



    	$st=0;
        for($i=0;$i<count($rr);$i++)
        {
		$dn_item[$rr[$i]]=$prot[$rr[$i]];   //�������� ������ ���� �� ��������� � ���� ������� ����� ��������
        }
        //��� ������ ������� ���, ���� ������ � �� � ��
	$dn_item[sh_stat]=$row[gsila]+$row[glovk]+$row[ginta]+$row[gintel]+$row[gmp]+$row[stbonus];
	$dn_item[sh_stat_b]=$row[gsila]+$row[glovk]+$row[ginta]+$row[gintel]+$row[gmp];

	$dn_item[prot_stat]=$prot[gsila]+$prot[glovk]+$prot[ginta]+$prot[gintel]+$prot[gmp]; // ����� �� ��� ���� �����



	$dn_item[delta_stat]=$dn_item[sh_stat]-$dn_item[prot_stat]+$chrka_stat;

	if ($chrka_stat>0) { $dn_item[delta_stat]-=$chrka_stat; }

		if ($user['id']==14897)
		{
//		echo "STCH:".$chrka_stat."/".$dn_item[delta_stat]."<br>";
		}


	$dn_item[up_cost]=$prot[cost]/2;
	$dn_item[pr_stat]=$dn_item[delta_stat]*5;

        $dn_item[sh_mf]=$row[mfkrit]+$row[mfakrit]+$row[mfuvorot]+$row[mfauvorot]+$row[mfbonus];
        $dn_item[sh_mf_b]=$row[mfkrit]+$row[mfakrit]+$row[mfuvorot]+$row[mfauvorot];
        $dn_item[prot_mf]=$prot[mfkrit]+$prot[mfakrit]+$prot[mfuvorot]+$prot[mfauvorot];//����� �� ��� ���� �����
        $dn_item[delta_mf]=$dn_item[sh_mf]-$dn_item[prot_mf]+$chrka_mf;

        if ($chrka_mf>0)
        	{
        	$dn_item[delta_mf]-=$chrka_mf;
        	}

        $dn_item[pr_mf]=round($row[cost]/10);

        //� ����������� �� ���� ��� ���������� - ���������� �����/��  ��������� �����/��  � ����� ����� ��� ���������� � ���������
        $dn_item[money]=0;
        if(in_array('gsila',$rr))
        {
		$dn_item[stbonus]=$dn_item[delta_stat];
		$dn_item[money]=$dn_item[pr_stat]+$dn_item[money];
	}
	if(in_array('mfkrit',$rr))
	{
		$dn_item[mfbonus]=$dn_item[delta_mf];
		$dn_item[money]=$dn_item[pr_mf]+$dn_item[money];
	}
		//������� ������ �������� ������.
		//�������� - ����� �� ���������� ���� ���� ������ ������� ����������... � �� ��� ����� �� �����
	if($chk==1)
	{
            //������� ��� ���, ���� ������� �������.
		$min_shmot_lvl=($prot[nlevel]<7?6:$prot[nlevel]);
		$dn_item[min_shmot_lvl]=$min_shmot_lvl;
		$dn_item[row_nlevel]=$row[nlevel];
		$dn_item[row_up_level]=$row[up_level];
		$dn_item[prot_nlevel]=$prot[nlevel];
		$dn_item['count_bron']=0;
		$dn_item['up_stats']=0;
		$bronia=array('bron1','bron2','bron3','bron4');
		$stats=n_fields('stats');
		$st_ups_nstats=array('nsila','nlovk','ninta','nvinos','nintel','nnoj','ntopor','ndubina','nmech');
		$uron_ups=array('minu','maxu');

		if(
			($row[up_level]>$prot[nlevel] &&
			($row[up_level]>$min_shmot_lvl) &&
			($row[nlevel]>$min_shmot_lvl) &&
			($dn_item[prot_mf]==$dn_item[sh_mf_b]) &&
			($dn_item[sh_stat_b]==$dn_item[prot_stat])) || ($riht==1 && $dn_item[sh_stat_b]>0)
		)

		{
	                $ups=$row[up_level]-$min_shmot_lvl;
	                $st1=$row[up_level];
	                $dn_item[check_IF]='DEAP_OK';
				//������ ���� ����� ����� ������, ������� ���� �������� ����� ������, � �������� ��������� ���
				//�� ���������� ������. � ��� �� ������� ������
			for($st=($ups+$min_shmot_lvl);$st>($min_shmot_lvl);$st--)
			{

				include "magic/upgrade".$st.".php";
				$dn_item['up_stats']+=$upgrade['stat'];

				for($i=0;$i<count($rr);$i++)
	    			{

                        		if(in_array($rr[$i],$bronia))
	    	  			{
            					if($row[$rr[$i]]>0)
	    	  				{
							$row[$rr[$i]]=$row[$rr[$i]]>0?$row[$rr[$i]]-$upgrade[bron]:$row[$rr[$i]];
							if($st1==$st)  //��� �������� ������ �� ������ ������, ������ ����� ������� � ������� ������� ��������� �� ���� ���������� ������.
							{
								$dn_item['lvld_'.$rr[$i]]=$row[$rr[$i]];
							}
	    					}
	    	  			}
	    	  			elseif(in_array($rr[$i],$uron_ups) && $prot['type']==3)
	    	  			{
            				if($row[$rr[$i]]>0)
	    	  				{
							$row[$rr[$i]]=$row[$rr[$i]]>0?$row[$rr[$i]]-$upgrade[udar]:$row[$rr[$i]];
							if($st1==$st)  //��� �������� ������ �� ������ ������, ������ ����� ������� � ������� ������� ��������� �� ���� ���������� ������.
							{
								$dn_item['lvld_'.$rr[$i]]=$row[$rr[$i]];
							}
	    					}
	    	  			}
	    	  			elseif(in_array($rr[$i],$st_ups_nstats))
	    	  			{
            				if($row[$rr[$i]]>0)
	    	  				{
							$row[$rr[$i]]=$row[$rr[$i]]>0?$row[$rr[$i]]-$upgrade[nparam]:$row[$rr[$i]];
							if($st1==$st)  //��� �������� ������ �� ������ ������, ������ ����� ������� � ������� ������� ��������� �� ���� ���������� ������.
							{
								$dn_item['lvld_'.$rr[$i]]=$row[$rr[$i]];
							}
	    					}
	    	  			}
					elseif($rr[$i]=='ghp')
	    	  			{
	    	  				if($row[$rr[$i]]>0)
	    	  				{
							$row[$rr[$i]]=$row[$rr[$i]]>0?$row[$rr[$i]]-$upgrade[hp]:$row[$rr[$i]];
							if($st1==$st)//��� �������� ������ �� ������ ������, ������ ����� ������� � ������� ������� ��������� �� ���� ���������� ������.
							{
								$dn_item['lvld_'.$rr[$i]]=$row[$rr[$i]];
							}
	    	  				}
	    	  			}
	    	  			elseif($rr[$i]=='maxdur')
	    	  			{
						if($row[$rr[$i]]>0) // ���� � ��� ���� ���� ��� ��������
						{

							//if($user[id]==28453)
							{
								if($st1==$st)
								{
									if($row[$rr[$i]]-$upgrade['duration']<=0)
									{
										$dn_item[stop]='����� ������� �����. ������ �������� ��...';
									}
									else
									{
										$dn_item[t2_upgr_prev]=$row[$rr[$i]]-$upgrade['duration'];
									}
								}
							}

						}
						/* OLD duration wia UPGRADE
						else
						{

							if($st1==$st)
							{
								$dn_item[t1_curr]=$row[$rr[$i]];
								$dn_item[t2_upgr]=$upgrade['duration'];
								$dn_item[t2_upgr_prev]=$dn_item['maxdur'];
							}

	    	  				    	if(($st1-1)==$st)
	    	  					{
	            					  	$dn_item[t2_upgr_prev]=$upgrade['duration'];
	    	  					}
						}*/
	    	  			}
	    	  		    	elseif($rr[$i]=='delta_stat')
	    	  			{
	    	  				if($dn_item['delta_stat']>0)
	    	  				{
							if($st1==$st)//��� �������� ������ �� ������ ������, ������ ����� ������� � ������� ������� ��������� �� ���� ���������� ������.
							{
								$dn_item['lvld_stbonus']=$dn_item[delta_stat]-$upgrade['stat'];
							}
	    	  				}
	    	  			}
                        		elseif($rr[$i]=='delta_mf')
	    	  			{
	    	  				if($dn_item['delta_mf']>0)
	    	  				{
							if($st1==$st)//��� �������� ������ �� ������ ������, ������ ����� ������� � ������� ������� ��������� �� ���� ���������� ������.
							{
								$dn_item['lvld_mfbonus']=$dn_item[delta_mf]-$upgrade['mf'];
							}
	    	  				}
	    	  			}
	    	  			elseif($rr[$i]=='name')
	    	  			{
						if($st1==$st)//��� �������� ������ �� ������ ������, ������ ����� ������� � ������� ������� ��������� �� ���� ���������� ������.
						{
							if(($st-1)>$min_shmot_lvl)
							{
								$dn_item[newlvl]=($st-1);
								$ttxt1=' ['.($st-1).']';
							}
							else
							{
								$dn_item[newlvl]=$dn_item[nlevel];
								$ttxt1='';
							}
							$is_mf = !(strpos($row['name'], '(��)') === false);
							$sharp=explode("+",$row['name']);
							if ((int)($sharp[1])>0) {$is_sharp="+".$sharp[1]; } else {$is_sharp='';}

							$dn_item['lvld_name']=$dn_item[name].$ttxt1.(($is_mf) ? ' (��)':'');
							$dn_item['lvld_name']=$dn_item['lvld_name'].$is_sharp;
							$dn_item['lvld_cost']=$dn_item[cost];
						}
	    	  			}

	    			}

			}

									//30                   20
			//if($user[id]==28453)
			if(!$dn_item['stop'])
			{
				$dn_item['lvld_maxdur']=$dn_item[t2_upgr_prev];
			}
			/* OLD duration upgrade
			else
			{
				if($dn_item[t1_curr]>$dn_item[t2_upgr_prev])
				{
					if($dn_item[maxdur]>$dn_item[t2_upgr_prev])
					{
						$dn_item['lvld_maxdur']=$dn_item[t1_curr];
					}
					else
					{
						$dn_item['lvld_maxdur']=$dn_item[t2_upgr_prev];
					}
				}
				else
				{
					$dn_item['lvld_maxdur']=$dn_item[t1_curr];
				}
			}*/

		}

             //echo $row[up_level];
	   	for($i=0;$i<count($rr);$i++)
		{  //�������� ������ ���� �� ��������� � ���� ������� ����� ����������
			if(in_array($rr[$i],$bronia))
			{   //����� ��������. ���� ������ ���������
				if($row[$rr[$i]]>0)
				{
					$dn_item['count_bron']+=1;
					$dn_item['gbron']=$row[$rr[$i]]-$prot[$rr[$i]];
				}
			}
			elseif($rr[$i]=='ghp')
			{
				if($row[$rr[$i]]>0)
				{
					$dn_item[$rr[$i]]=$row[$rr[$i]]-$prot[$rr[$i]];
				}
			}
		}
		$maxhp=20;
		$maxbron=3;
		$maxstat=2;

		$price_hp= 5;
		$price_stat= 10;
		$price_bron= 5;

		$price_hp_kr= 200;
		$price_stat_kr= 400;
		$price_bron_kr= 200;

if ($row['id']==624608706)
	{
	echo $chrka_hp ;
	print_r($dn_item);
	}

		if(($dn_item[ghp])>0)
		{
			if((($maxhp-($dn_item[ghp]))*$price_hp)>0)
			{
				$dn_item[ekr_hp]=($maxhp-$dn_item[ghp])*$price_hp + 5;
				$dn_item[add_hp]=($maxhp-$dn_item[ghp]);
			}

			if((($maxhp-$dn_item[ghp])*$price_hp_kr)>0)
			{
				$dn_item[kr_hp]=($maxhp-$dn_item[ghp])*$price_hp_kr + 5;
				$dn_item[add_hp]=($maxhp-$dn_item[ghp]);
			}
	        }

	        if(($dn_item[gbron]-$charka_bron)>0)
	        {
		        if(($maxbron - ($dn_item[gbron]-$charka_bron)) * $dn_item[count_bron] * $price_bron>0)
		        {
		        	$dn_item[ekr_bron]=($maxbron - $dn_item[gbron]-$charka_bron) * $dn_item[count_bron] * $price_bron + 5;
		        	$dn_item[add_bron]=($maxbron - $dn_item[gbron]-$charka_bron);
		        }

		        if(($maxbron - ($dn_item[gbron]-$charka_bron)) * $dn_item[count_bron] * $price_bron_kr>0)
		        {
		        	$dn_item[kr_bron]=($maxbron - $dn_item[gbron]-$charka_bron) * $dn_item[count_bron] * $price_bron_kr + 5;
		        	$dn_item[add_bron]=($maxbron - $dn_item[gbron]-$charka_bron);
		        }
	        }

            	$dn_item[rezzzstat]=$dn_item[sh_stat]-($dn_item[prot_stat]+$dn_item[up_stats]);

	        if(($dn_item[rezzzstat]+$chrka_stat)<$maxstat && $dn_item[sh_stat]!=0)
	        {
	        	$dn_item[ekr_stat]=$price_stat;
	        	$dn_item[kr_stat]=$price_stat_kr;
	        	$dn_item[add_stat]=$maxstat-$dn_item[rezzzstat]-$chrka_stat;
	        }
	}

	if($row[up_level]>=7)
	{
		$dn_item[pr_up]=0;
		if($dn_item[delta_stat]>0&&($dn_item[sh_stat]-$row[stbonus])!=$dn_item[prot_stat])
		{
			$dn_item[pr_up]+=$dn_item[pr_stat];
		}
		if($dn_item[delta_mf]>0&&($dn_item[sh_mf]-$row[mfbonus])!=$dn_item[prot_mf])
		{
			$dn_item[pr_up]+=$dn_item[pr_mf];
		}
		if($dn_item[pr_up]==0)
		{
			$dn_item[pr_up]=5;
		}
		$dn_item[sh_lvl]=$row[up_level];

	}
		return $dn_item;
}
 //������� ������ - ������ ����, ��������� ���������, ���-�� ��.
      function upgrade_item($up_cost,$max_ups_left){
      	$costs[up_cost]=$up_cost;
  		if($max_ups_left == 5)
		{
            $costs[mfbonusadd]=2;
			$costs[cur_cost]= $costs[up_cost]+round($costs[up_cost] / 2, 0);
			$costs[up_cost] = round($costs[cur_cost] / 2, 0);
			$costs[cost_add] = round($costs[cur_cost] * 0.2, 0);//cost wich will pluseed to item cost after mf
		}
		elseif($max_ups_left == 4)
		{
			$costs[mfbonusadd]=3;
			$costs[cur_cost]= $costs[up_cost]+round($costs[up_cost] / 2, 0);
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.2,0); //cost after previos UP
			$costs[up_cost] = round($costs[cur_cost] / 2, 0);
			$costs[cost_add] = round($costs[cur_cost] * 0.2, 0);//cost wich will pluseed to item cost after UP
		}
		elseif($max_ups_left == 3)
		{
			$costs[mfbonusadd]=4;
			$costs[cur_cost]= $costs[up_cost]+round($costs[up_cost] / 2, 0);
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.2,0); //cost after 1 UP
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.2,0); //cost after 2 UP
			$costs[up_cost] = round($costs[cur_cost] / 2, 0);
			$costs[cost_add] = round($costs[cur_cost] * 0.4, 0);//cost wich will pluseed to item cost after UP
		}
		elseif($max_ups_left == 2)
		{
			$costs[mfbonusadd]=6;
			$costs[cur_cost]= $costs[up_cost]+round($costs[up_cost] / 2, 0);
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.2,0); //cost after 1 UP
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.2,0); //cost after 2 UP
		    $costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.4,0); //cost after 3 UP
			$costs[up_cost] = round($costs[cur_cost] / 2, 0);
			$costs[cost_add] = round($costs[cur_cost] * 0.7, 0);//cost wich will pluseed to item cost after UP
		}
		elseif($max_ups_left == 1)
		{
			$costs[mfbonusadd]=10;
			$costs[cur_cost]= $up_cost+round($up_cost / 2, 0);
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.2,0); //cost after 1 UP
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.2,0); //cost after 2 UP
		    $costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.4,0); //cost after 3 UP
			$costs[cur_cost]=$costs[cur_cost]+round($costs[cur_cost]*0.7,0); //cost after 4 UP
			$costs[up_cost] = round($costs[cur_cost] / 2, 0);
			$costs[cost_add] = round($costs[cur_cost] * 0.1, 0);//cost wich will pluseed to item cost after UP
		}
			$costs[up_cost]=round($costs[up_cost]*0.7);
		    return $costs;
	 }

function s_klan($align,$short)
{
  if ($short=='pal')
   {
    $align="1.99";
    $short='Paladins';
   }
   if ($data['short']=='���� �������')
   {
    return '';
   }                                          //pal.gif
 $qq=
 "<img src='http://i.oldbk.com/i/align_".$align.".gif' border='0'>
 ".($short!=""?"<img src='http://i.oldbk.com/i/klan/".($short=='Paladins'?'pal':$short).".gif' border='0'>".$short:"");
 return $qq;
}



/*
�������� ���� ������� � ������� ����� 1.5
�������� ���� � ���� � ������ ����� 1.91
 */
function check_rights($user)
{
	$data=mysql_query("SELECT * FROM oldbk.`pal_rights` WHERE pal_id='".$user['id']."' LIMIT 1");
	if(mysql_num_rows($data)>0)
	{
		$pal_rights=mysql_fetch_assoc($data);
	}

	$access=array();
	if ( (($user[align]>2 && $user[align] <3)) )
	{
		$access[i_angel]=$user[align];
	}
	if(($user[align]>1 && $user[align] <2) || $access[i_angel]>0 || $user[align]==7 || $user[align]==5 || $user['id']==697032 || $user['id']==5 )
	{
	//��������� ��������.
		$access[i_pal]			=$user[align];
		$access[can_forum_del]		=(($user[align]>='1.5'&&$user[align]<2) || $user[align]==7 ||$access[i_angel]>0)?1:0;	//�������� ������ (�������)
		$access[can_forum_restore]	=(($user[align]>='1.91'&&$user[align]<2)|| $user[align]==7 ||$access[i_angel]>0)?1:0;
		$access[can_close_top]		=(($user[align]>='1.5'&&$user[align]<2) || $user[align]==7 ||$access[i_angel]>0)?1:0;
		$access[can_open_top]		=(($user[align]>='1.5'&&$user[align]<2) || $user[align]==7 ||$access[i_angel]>0)?1:0;
		$access[can_del_top]		=(($user[align]>='1.5'&&$user[align]<2) || $user[align]==7||$access[i_angel]>0)?1:0;     	//�������� �������(�������)
		$access[can_del_top_all]	=(($user[align]>='1.91'&&$user[align]<2)||$access[i_angel]>0)?1:0;
		$access[can_rest_top_all]	=(($user[align]>='1.91'&&$user[align]<2)||$access[i_angel]>0)?1:0;
		$access[can_del_pal_comments]	=(($user[align]>='1.91'&&$user[align]<2)||$access[i_angel]>0)?1:0;
		$access[can_create_votes]	=(($user[align]>='1.91'&&$user[align]<2)||$access[i_angel]>0)?1:0;

		$access[view_ekr]		=($access[i_angel]>0)?1:0;  //������ ���� � ���������
		$access[can_comment]		=(($pal_rights['red_forum']==1)||$access[i_angel]>0)?1:0;		//���������� � �����
		$access[can_top_move]		=(($pal_rights['top_move']==1)||$access[i_angel]>0)?1:0;
		$access[perevodi]		=(($pal_rights['logs']==1)||$access[i_angel]>0)?5:0; //������� �������� + ����������
		$access[item_hist]		=(($pal_rights['ext_logs']==1)||$access[i_angel]>0)?1:0; //��������� ��� ������� �����
		$access[pal_tel]		=(($pal_rights['pal_tel']==1)||$access[i_angel]>0)?1:0;	//��� ��������
		$access[zhhistory]		=(($pal_rights['zhhistory']==1)||$access[i_angel]>0)?1:0;	//��� ������


		$access[klans_kazna_view]	=(($pal_rights['klans_kazna_view']==1)||$access[i_angel]>0)?1:0; //�������� ����� ������
		$access[klans_kazna_logs]	=(($pal_rights['klans_kazna_logs']==1)||$access[i_angel]>0)?1:0; //�������� ����� ����� ������
		$access[klans_ars_logs]		=(($pal_rights['klans_ars_logs']==1)||$access[i_angel]>0)?1:0; //�������� ����� ��������� ������

		$access[klans_ars_put]		=(($pal_rights['klans_ars_put']==1)||$access[i_angel]>0)?1:0; //������� ���� �� �������� (����������� � ����) � ����� ����������� ����������� ���� � ��������.

		$access[pals_delo]		=(($pal_rights['pals_delo']==1)||$access[i_angel]>0)?1:0; //�������� ��� ����
		$access[pals_online]		=(($pal_rights['pals_online']==1)||$access[i_angel]>0)?1:0; //�������� ����� ������

		$access[anonim_hist]		=(($user[align]>='1.91'&&$user[align]<2)||$access[i_angel]>0)?1:0; //����� ������� �� ���
		$access[abils]			= $pal_rights['abils'];
		$access[loginip]		= $pal_rights['loginip'];
		$access[viewmanyips]		= $pal_rights['viewmanyips'];
	}



	if ($user['id']==648)
		{
		$access[view_ekr]=1;
		}
	return $access;
}


function show_palcomment($mess,$id,$access=0)
{

	echo "<BR>";
	$mess=explode('|',$mess);
	$show_comment='<br><font color=red>';

	for($jj=0;$jj<(count($mess)-1);$jj++)  //�������� ���������� ������ ��������
	{
		$pl_inf=explode('_;_',$mess[$jj]);
		$mess_autor_txt=array();
		for($ff=0;$ff<count($pl_inf);$ff++)   // ��������� ����� �������
		{
			$mess_autor_txt[$ff]=$pl_inf[$ff];
		}
		$author=return_info($mess_autor_txt[0],$mess_autor_txt[1],4);
		$show_comment.=$author.' '.$mess_autor_txt[2];
		if($access[can_del_pal_comments]==1)
		{
			$show_comment.="<a OnClick=\"if (!confirm('������� �����������?')) { return false; } \" href='?konftop=".$_GET['konftop']."&topic=".$_GET['topic']."&page=".$_GET['page']."&com=".$id."&dc=".$jj."'>&nbsp;<img src='http://i.oldbk.com/i/clear.gif'></a>";
		}
		$show_comment.='<br>';
	}

	$show_comment=substr($show_comment,0,-4).'</font>';
	return $show_comment;

}

function return_info($id, $info,$aa=1)
{
	global $user;
	$inf=explode(',',$info);
	if($user[id]==28453)
	{
		$qwe='.';
	}
	//A-Tech,radminion,2.4,8,0
	if($aa!=2)
	{
		if($aa<4)
		{
			if ($inf[2]>1.1 && $inf[2]<2) {$angel="���������";}
			if ($inf[2]>2 && $inf[2]<3) {$angel="�������";}
		}
		else
		{
			$angel='';
		}
		if ($inf[4]>0 && $aa==1)
		{
			$print='<img border="0" src="http://i.oldbk.com/i/align_0.gif"><b><i>����������</i></b>[??]<a href="http://capitalcity.oldbk.com/inf.php?'.$inf[4].'" target="_blank"><img border="0" src="http://i.oldbk.com/i/inf.gif"></a>';
		}
		elseif($inf[4]>0 && ($aa==0 || $aa==4))
		{
			$print='<img border="0" src="http://i.oldbk.com/i/align_0.gif"><b><i>���������</i></b>[??]<a href="http://capitalcity.oldbk.com/inf.php?'.$inf[4].'" target="_blank"><img border="0" src="http://i.oldbk.com/i/inf.gif"></a>';
		}
		else
		{
			$inf1=s_nick($id,$inf[2],$inf[1],$inf[0],$inf[3]);
			$print=($aa==1?$angel.' ':'').$inf1;
		}
	}
	elseif($aa==2)
	{
		if($inf[4]>0)
		{
			$print='<i>���������</i>';
		}
		else
		{
			$print=$inf[0];
		}
	}
	return $print.$qwe;
}

	if(strpos($rvs_readers,$_SESSION[uid])!==false || ($_SESSION['align']>=1.9 && $_SESSION['align']<2))
	{
	if ((int)($_SESSION[uid])>0)
		{
	        $user=mysql_fetch_assoc(mysql_query('select * from users where id = '.$_SESSION[uid].';'));
        	$rs = mysql_query("SELECT * FROM oldbk.`telegraph` WHERE `owner` = '".$_SESSION[uid]."';");
		    mysql_query("DELETE FROM oldbk.`telegraph` WHERE `owner` = '".$_SESSION[uid]."';");
		    while($r = mysql_fetch_assoc($rs)) {
			addchp ($r['text'],'{[]}'.$user['login'].'{[]}');
	   		}
	   	}
	}

	function show_medals($medal)
	{
		switch ($medal)
		{
			case "esti16ekr":
				echo ' <img src="http://i.oldbk.com/i/easter_icon2016_e.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� ���������� �����!!\')" > ';
			break;

			case "esti16kr":
				echo ' <img src="http://i.oldbk.com/i/easter_icon2016_kr.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'� ������!\')" > ';
			break;
			case "003":
				echo ' <img src="http://i.oldbk.com/i/003.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ��������!\')" width=20> ';
			break;
			case "048":
				echo ' <img src="http://i.oldbk.com/i/048.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ��������� ����� 2010-2011!\')"> ';
			break;
			case "049":
				echo ' <img src="http://i.oldbk.com/i/049.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ��������� ����� � �������������� ���������� �������!\')"> ';
			break;
			case "062":
				echo ' <img src="http://i.oldbk.com/i/062.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'� ������������� �� �������� ����� � �������������� ����� �������!\')"> ';
			break;
			case "104":
				echo ' <a href=http://oldbk.com/encicl/tvorchestvo.html target=_blank><img src="http://i.oldbk.com/i/104.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ���������� ������ �������������� � ���������� �����\')"></a> ';
			break;
			case "004":
				echo ' <img src="http://i.oldbk.com/i/004.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ ����� ���� VS ����!\')" width=20> ';
			break;
			case "medal_19":
				echo ' <img src="http://i.oldbk.com/i/medal_19.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ � ������������ �������� <������������ � ��>\')" width=20> ';
			break;
			case "005":
				echo ' <img src="http://i.oldbk.com/i/005.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ��������� � �������� �������!\')" > ';
			break;
			case "006":
				echo ' <img src="http://i.oldbk.com/i/006.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ �������!\')" width=31> ';
			break;
			case "007":
				echo ' <img src="http://i.oldbk.com/i/007.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���������� �������� - ���������� ����!\')"> ';
			break;
		      	case "008":
				echo ' <img src="http://i.oldbk.com/i/008.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'RDJ Radio OldFM!\')"> ';
			break;
			case "012":
				echo ' <img src="http://i.oldbk.com/i/012.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'RDJ Radio RusFM!\')"> ';
			break;
		      	case "009":
				echo ' <img src="http://i.oldbk.com/i/009.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'Best RDJ Radio OldFM!\')"> ';
			break;


		      	case "rdj05":
				echo ' <img src="http://i.oldbk.com/i/RDJ_0_5.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� RDJ � ������ Non Stop Music!\')"> ';
			break;

		      	case "rdj1":
				echo ' <img src="http://i.oldbk.com/i/RDJ_1_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'1 ��� RDJ � ������ Non Stop Music!\')"> ';
			break;

		      	case "rdj2":
				echo ' <img src="http://i.oldbk.com/i/RDJ_2_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'2 ���� RDJ � ������ Non Stop Music!\')"> ';
			break;

		      	case "rdj3":
				echo ' <img src="http://i.oldbk.com/i/RDJ_3_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'3 ���� RDJ � ������ Non Stop Music!\')"> ';
			break;

		      	case "rdj4":
				echo ' <img src="http://i.oldbk.com/i/RDJ_4_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'4 ���� RDJ � ������ Non Stop Music!\')"> ';
			break;


		      	case "ruin3_0":
				echo ' <img src="http://i.oldbk.com/i/ruin3_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � III ��������� ������� �� ������ �����!\')"> ';
			break;

		      	case "ruin3_1":
				echo ' <img src="http://i.oldbk.com/i/ruin3_1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ � III ��������� ������� �� ������ �����!\')"> ';
			break;

		      	case "ruin3_2":
				echo ' <img src="http://i.oldbk.com/i/ruin3_2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ ����� � III ��������� ������� �� ������ �����!\')"> ';
			break;

		      	case "ruin3_3":
				echo ' <img src="http://i.oldbk.com/i/ruin3_3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ ����� � III ��������� ������� �� ������ �����!\')"> ';
			break;

		      	case "ru15_0":
				echo ' <img src="http://i.oldbk.com/i/ruins2015_f0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ���������� ������� �� ������ 2015!\')"> ';
			break;

		      	case "ru15_1":
				echo ' <img src="http://i.oldbk.com/i/ruins2015_f1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� 1-� ����� � ���������� ������� �� ������ 2015!\')"> ';
			break;

		      	case "ru15_2":
				echo ' <img src="http://i.oldbk.com/i/ruins2015_f2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� 2-� ����� � ���������� ������� �� ������ 2015!\')"> ';
			break;

		      	case "ru15_3":
				echo ' <img src="http://i.oldbk.com/i/ruins2015_f3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� 3-� ����� � ���������� ������� �� ������ 2015!\')"> ';
			break;

			case "014":
				echo ' <img src="http://i.oldbk.com/i/014.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������ �������� �������!\')"> ';
			break;
			case "015":
				echo ' <img src="http://i.oldbk.com/i/015.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������ �������� �������!\')"> ';
			break;
			case "016":
				echo ' <img src="http://i.oldbk.com/i/016.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������ �������� �������!\')"> ';
			break;
			case "017":
				echo ' <img src="http://i.oldbk.com/i/017.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ �������� �������!\')"> ';
			break;
			case "018":
				echo ' <img src="http://i.oldbk.com/i/018.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'� ������������� �� ����� � �������� �������!\')"> ';
			break;
			case "019":
				echo ' <img src="http://i.oldbk.com/i/019.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������������ ������� �����!\')"> ';
			break;
			case "011":
				echo ' <img src="http://i.oldbk.com/i/medal_hram_011.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ���������\')"> ';
			break;
			case "020":
				echo ' <a href="http://olddarkclan.com/gal/photos/5ef698cd9fe650923ea331c15af3b160.jpg" target=_blank><img src="http://i.oldbk.com/i/020.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����� �������� ������� �� ��������� ����� 15.01.11\')"></a> ';
			break;
			case "025":
				echo ' <a href="http://olddarklan.ru/images/photoalbum/album_22/zigan.jpg" target=_blank><img src="http://i.oldbk.com/i/025.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����� �������� ������ �� ��������� ����� 15.01.11\')"></a> ';
			break;
			case "022":
				echo ' <a href="http://olddarklan.ru/images/photoalbum/album_22/alexey4ysh2.jpg" target=_blank><img src="http://i.oldbk.com/i/022.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����� �������� ���� �� ��������� ����� 15.01.11\')"></a> ';
			break;
			case "023":
				echo ' <a href="http://olddarklan.ru/images/photoalbum/album_22/alexey4ysh2.jpg" target=_blank><img src="http://i.oldbk.com/i/023.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����� �������� ���� �� ��������� ����� 15.01.11\')"></a> ';
			break;
			case "024":
				echo ' <a href="http://olddarkclan.com/gal/photos/76dc611d6ebaafc66cc0879c71b5db5c.jpg" target=_blank><img src="http://i.oldbk.com/i/024.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ����������� �������� ����� �������� ������� �� ��������� ����� 15.01.11\')"></a> ';
			break;
			case "030":
				echo ' <img src="http://i.oldbk.com/i/030.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ����� 2010 - I �����!\')"> ';
			break;
			case "031":
				echo ' <img src="http://i.oldbk.com/i/031.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ����� 2010 - II �����!\')"> ';
			break;
			case "032":
				echo ' <img src="http://i.oldbk.com/i/032.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ����� 2010 - III �����!\')"> ';
			break;
			case "033":
				echo ' <img src="http://i.oldbk.com/i/033.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ����� 2010 - ���� ��������  �� �������������!\')"> ';
			break;
			case "035":
				echo ' <img src="http://i.oldbk.com/i/035.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�������� ������������ ����� ����-���� 5 ������� 2011!\')"> ';
			break;

			case "060":
				echo ' <img src="http://i.oldbk.com/i/060.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ ����� �� ����� �����\')"> ';
			break;
			case "061":
				echo ' <img src="http://i.oldbk.com/i/061.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ����� ������ ����� �� ����� �����\')"> ';
			break;

			case "055":
				echo ' <img src="http://i.oldbk.com/i/m5.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ����� ������� ���\')"> ';
			break;


			case "bm1701":
				echo ' <img src="http://i.oldbk.com/i/bm17_gold.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������� �� �������� � ����� 7-� ����� �����!\')"> ';
			break;

			case "bm1702":
				echo ' <img src="http://i.oldbk.com/i/bm17_silver.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������� �� �������� � ����� 7-� ����� �����!\')"> ';
			break;

			case "bm1703":
				echo ' <img src="http://i.oldbk.com/i/bm17_bronza.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������� �� �������� � ����� 7-� ����� �����!\')"> ';
			break;

			case "bm1704":
				echo ' <img src="http://i.oldbk.com/i/bm17_uchastniki.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ������� �� �������� � ����� 7-� ����� �����!\')"> ';
			break;

			case "bm1705":
				echo ' <img src="http://i.oldbk.com/i/bm17_bolelshiki.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�������� ��������� �� ������� �� �������� � ����� 7-� ����� �����!\')"> ';
			break;

			case "bm1605":
				echo ' <img src="http://i.oldbk.com/i/znakbmks_05.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ��������� � ������� �� �������� � ����� 6-����� �����!\')"> ';
			break;
			case "bm1604":
				echo ' <img src="http://i.oldbk.com/i/znakbmks_04.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� �� �������� � ����� 6-����� �����!\')"> ';
			break;
			case "bm1603":
				echo ' <img src="http://i.oldbk.com/i/znakbmks_03.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������� �� �������� � ����� 6-����� �����!\')"> ';
			break;
			case "bm1602":
				echo ' <img src="http://i.oldbk.com/i/znakbmks_02.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������� �� �������� � ����� 6-����� �����!\')"> ';
			break;
			case "bm1601":
				echo ' <img src="http://i.oldbk.com/i/znakbmks_01.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������� �� �������� � ����� 6-����� �����!\')"> ';
			break;


			case "010":
				echo ' <img src="http://i.oldbk.com/i/010.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� �� II-� ������� �� �������� ����� ������ ���������\')"> ';
			break;
			case "0111":
				echo ' <img src="http://i.oldbk.com/i/011.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ �� II-� ������� �� �������� ����� ������ ���������\')"> ';
			break;
			case "038":
				echo ' <img src="http://i.oldbk.com/i/038.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ���������� ������� ������ ����������\')"> ';
			break;
			case "039":
				echo ' <img src="http://i.oldbk.com/i/039.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� ���������� ���� ������������� � �����!\')"> ';
			break;
			case "040":
				echo ' <img src="http://i.oldbk.com/i/040.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ������� ������� �������� �� ���������!\')"> ';
			break;
			case "041":
				echo ' <img src="http://i.oldbk.com/i/041.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������ ������� �������� �� ���������!\')"> ';
			break;
			case "042":
				echo ' <img src="http://i.oldbk.com/i/042.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������ ������� �������� �� ���������!\')"> ';
			break;
			case "043":
				echo ' <img src="http://i.oldbk.com/i/043.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� ����� �� �������� 30.06.11!\')"> ';
			break;
			case "044":
				echo ' <img src="http://i.oldbk.com/i/044.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� ����� �� �������� 30.06.11!\')"> ';
			break;
			case "045":
				echo ' <img src="http://i.oldbk.com/i/045.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� ����� �� �������� 30.06.11!\')"> ';
			break;
			case "046":
				echo ' <img src="http://i.oldbk.com/i/046.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���������� ���������� �� ������� �����!\')"> ';
			break;
			case "047":
				echo ' <img src="http://i.oldbk.com/i/047.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� ����� �� �������� 30.06.11!\')"> ';
			break;
			case "069":
				echo ' <img src="http://i.oldbk.com/i/pal4.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ��������� � �������� ������ �����!\')"> ';
			break;
			case "063":
				echo ' <img src="http://i.oldbk.com/i/063.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� �������� ������ ����� III �������!\')"> ';
			break;
			case "064":
				echo ' <img src="http://i.oldbk.com/i/064.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� �������� ������ ����� II �������!\')"> ';
			break;
			case "065":
				echo ' <img src="http://i.oldbk.com/i/065.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� �������� ������ ����� I �������!\')"> ';
			break;
			case "066":
				echo ' <img src="http://i.oldbk.com/i/066.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� �������� ������ � ������ ����� III �������!\')"> ';
			break;
			case "067":
				echo ' <img src="http://i.oldbk.com/i/067.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� �������� ������ � ������ ����� II �������!\')"> ';
			break;
			case "068":
				echo ' <img src="http://i.oldbk.com/i/068.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� �������� ������ � ������ ����� I �������!\')"> ';
			break;
			case "071":
				echo ' <img src="http://i.oldbk.com/i/071.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� ����� �� �������� 21.10.11!\')"> ';
			break;
			case "072":
				echo ' <img src="http://i.oldbk.com/i/072.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� ����� �� �������� 21.10.11!\')"> ';
			break;
			case "070":
				echo ' <img src="http://i.oldbk.com/i/070.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� ����� �� �������� 21.10.11!\')"> ';
			break;
			case "073":
				echo ' <img src="http://i.oldbk.com/i/073.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � ������� ����� �� �������� 21.10.11!\')"> ';
			break;
			case "074":
				echo ' <img src="http://i.oldbk.com/i/074.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� ����� �� �������� 21.10.11!\')"> ';
			break;
			case "075":
				echo ' <img src="http://i.oldbk.com/i/075.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � ������� ����� �� �������� 21.10.11!\')"> ';
			break;
			case "079":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� ����� �� ������ 10.12.11!\')"> ';
			break;
			case "080":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� ����� �� ������ 10.12.11!\')"> ';
			break;
			case "081":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� ����� �� ������ 10.12.11!\')"> ';
			break;
			case "082":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� ����� �� ������ 10.12.11!\')"> ';
			break;

			case "179":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ ������� ����� �� ������ 27.02.2013!\')"> ';
			break;
			case "180":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������ ������� ����� �� ������ 27.02.2013!\')"> ';
			break;
			case "181":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������ ������� ����� �� ������ 27.02.2013!\')"> ';
			break;
			case "182":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������ ������� ����� �� ������ 27.02.2013!\')"> ';
			break;

			case "miss150":
				echo ' <img src="http://i.oldbk.com/i/miss2015_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� �������� ���� ������� 2015!\')"> ';
			break;

			case "miss151":
				echo ' <img src="http://i.oldbk.com/i/miss2015_1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2015 - I �����!\')"> ';
			break;

			case "miss152":
				echo ' <img src="http://i.oldbk.com/i/miss2015_2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2015 - II �����!\')"> ';
			break;

			case "miss153":
				echo ' <img src="http://i.oldbk.com/i/miss2015_3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2015 - III �����!\')"> ';
			break;

			case "miss154":
				echo ' <img src="http://i.oldbk.com/i/miss2015_4.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2015 ���� ����������� ��������!\')"> ';
			break;

			case "miss155":
				echo ' <img src="http://i.oldbk.com/i/miss2015_5.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ���� ������� 2015!\')"> ';
			break;

			case "miss156":
				echo ' <img src="http://i.oldbk.com/i/miss2015_5.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ���� ������� 2015!\')"> ';
			break;

			case "083":
				echo ' <img src="http://i.oldbk.com/i/083.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� ����� �� �������� � ����� 18.11.11!\')"> ';
			break;
			case "084":
				echo ' <img src="http://i.oldbk.com/i/084.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� ����� �� �������� � ����� 18.11.11!\')"> ';
			break;
			case "085":
				echo ' <img src="http://i.oldbk.com/i/085.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� ����� �� �������� � ����� 18.11.11!\')"> ';
			break;
			case "086":
				echo ' <img src="http://i.oldbk.com/i/086.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� ����� �� �������� � ����� 18.11.11!\')"> ';
			break;
			case "087":
				echo ' <img src="http://i.oldbk.com/i/087.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � ������� ����� �� �������� � ����� 18.11.11!\')"> ';
			break;
			case "088":
				echo ' <img src="http://i.oldbk.com/i/088.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � ������� ����� �� �������� � ����� 18.11.11!\')"> ';
			break;
			case "089":
				echo ' <img src="http://i.oldbk.com/i/089.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������ �����!\')"> ';
			break;
			case "090":
				echo ' <img src="http://i.oldbk.com/i/090.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ��������� - ��������� ����� 2011!\')"> ';
			break;
			case "dt1":
				echo ' <img src="http://i.oldbk.com/i/dt1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'25 ����� � ����� ������\')"> ';
			break;
			case "dt2":
				echo ' <img src="http://i.oldbk.com/i/dt2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'50 ����� � ����� ������\')"> ';
			break;
			case "dt3":
				echo ' <img src="http://i.oldbk.com/i/dt3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'100 ����� � ����� ������\')"> ';
			break;
			case "dt4":
				echo ' <img src="http://i.oldbk.com/i/dt4.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'150 ����� � ����� ������\')"> ';
			break;
			case "dt5":
				echo ' <img src="http://i.oldbk.com/i/dt5.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'250 ����� � ����� ������\')"> ';
			break;
			case "100":
				echo ' <img src="http://i.oldbk.com/i/100.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'100 ����� � ������ ������� �����\')"> ';
			break;
			case "101":
				echo ' <img src="http://i.oldbk.com/i/101.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'300 ����� � ������ ������� �����\')"> ';
			break;
			case "102":
				echo ' <img src="http://i.oldbk.com/i/102.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'500 ����� � ������ ������� �����\')"> ';
			break;
			case "103":
				echo ' <img src="http://i.oldbk.com/i/103.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'1000 ����� � ������ ������� �����\')"> ';
			break;
			case "214":
				echo ' <img src="http://i.oldbk.com/i/214.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � �������� ���� ���� 2014 �� ����� MiB\')"> ';
			break;
			case "215":
				echo ' <img src="http://i.oldbk.com/i/215.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � �������� ���� ���� 2014 �� ����� MiB\')"> ';
			break;
			case "216":
				echo ' <img src="http://i.oldbk.com/i/216.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � �������� ���� ���� 2014 �� ����� MiB\')"> ';
			break;
			case "3110":
				echo ' <img src="http://i.oldbk.com/i/helloween_2011m2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� Halloween 31.10.11!\')"> ';
			break;
			case "2011":
				echo ' <img src="http://i.oldbk.com/i/nov_god_2011.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ����� �� ������ 2011 �����!\')"> ';
			break;
			case "2012":
				echo ' <img src="http://i.oldbk.com/i/nov_god_2012.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ����� �� ������ 2012 �����!\')"> ';
			break;
			case "2013":
				echo ' <img src="http://i.oldbk.com/i/nov_god_2013.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ����� �� ������ 2013 �����!\')"> ';
			break;
			case "2014":
				echo ' <img src="http://i.oldbk.com/i/nov_god_2014.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ����� �� ������ 2014 �����!\')"> ';
			break;
			case "2015":
				echo ' <img src="http://i.oldbk.com/i/nov_god_2015.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ����� �� ������ 2015 �����!\')"> ';
			break;
			case "2016":
				echo ' <img src="http://i.oldbk.com/i/nov_god_2016.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� ������ 2016 �����!\')"> ';
			break;

			case "2017":
				echo ' <img src="http://i.oldbk.com/i/nov_god_2017.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� ������ 2017 �����!\')"> ';
			break;

			case "1000":
				echo ' <img src="http://i.oldbk.com/i/avalon_1000.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ������ AvalonCity!\')"> ';
			break;
			case "2001":
				echo ' <img src="http://i.oldbk.com/i/ruins_u4astie.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ �������������� ������� � ������\')"> ';
			break;
			case "2002":
				echo ' <img src="http://i.oldbk.com/i/ruins1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������ �������������� ������� � ������\')"> ';
			break;
			case "2003":
				echo ' <img src="http://i.oldbk.com/i/ruins2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������ �������������� ������� � ������\')"> ';
			break;
			case "2004":
				echo ' <img src="http://i.oldbk.com/i/ruins3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������ �������������� ������� � ������\')"> ';
			break;

			case "bst_117":
				echo ' <img src="http://i.oldbk.com/i/svet_tma2017_01.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������������ ����� ���� vs ���� 04.03.2017 �� ������� ���������!\')"> ';
			break;

			case "bst_217":
				echo ' <img src="http://i.oldbk.com/i/svet_tma2017_02.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������������ ����� ���� vs ���� 04.03.2017 �� ������� �����������!\')"> ';
			break;



			case "s16m1":
				echo '<a href=/sturlog.php?id=1 target=_blank><img src="http://i.oldbk.com/i/stur_2016msk_1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ � ���������� ��������� ������� � ����� 6-����� �����!\')"></a> ';
			break;

			case "s16m2":
				echo '<a href=/sturlog.php?id=1 target=_blank><img src="http://i.oldbk.com/i/stur_2016msk_2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ ����� � ���������� ��������� ������� � ����� 6-����� �����!\')"></a> ';
			break;

			case "s16m3":
				echo '<a href=/sturlog.php?id=1 target=_blank><img src="http://i.oldbk.com/i/stur_2016msk_3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ���������� ��������� ������� � ����� 6-����� �����!\')"></a> ';
			break;



			case "2005":
				echo ' <img src="http://i.oldbk.com/i/ruins_u4astie.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� �� ������ �������������� ������� � ������\')"> ';
			break;
			case "2006":
				echo ' <img src="http://i.oldbk.com/i/ruins1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� �� ������ �������������� ������� � ������\')"> ';
			break;
			case "2007":
				echo ' <img src="http://i.oldbk.com/i/ruins2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� �� ������ �������������� ������� � ������\')"> ';
			break;
			case "2008":
				echo ' <img src="http://i.oldbk.com/i/ruins3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� �� ������ �������������� ������� � ������\')"> ';
			break;

			case "olg2013":
				echo ' <img src="http://i.oldbk.com/i/olimp_gold_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ������ �� ������ ��������� ����� - ���� 2013\')"> ';
			break;

			case "ols2013":
				echo ' <img src="http://i.oldbk.com/i/olimp_silver_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����������� ������ �� ������ ��������� ����� - ���� 2013\')"> ';
			break;

			case "olb2013":
				echo ' <img src="http://i.oldbk.com/i/olimp_bronz_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ������ �� ������ ��������� ����� - ���� 2013\')"> ';
			break;

			case "ol2013":
				echo ' <img src="http://i.oldbk.com/i/olimp_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ������ ��������� ����� - ���� 2013\')"> ';
			break;

			case "ruin20141":
				echo ' <img src="http://i.oldbk.com/i/ruin2014.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ���������� ������� �� ������, ����������� 4-� ����� �����\')"> ';
			break;
			case "ruin201419":
				echo ' <img src="http://i.oldbk.com/i/sh/runin_key41.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ���������� ������� �� ������, ����������� 4-� ����� �����\')"> ';
			break;
			case "ruin20142":
				echo ' <img src="http://i.oldbk.com/i/ruin2014.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ���������� ������� �� ������, ����������� 4-� ����� �����\')"> ';
			break;

			case "ruin20143":
				echo ' <img src="http://i.oldbk.com/i/ruin2014.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ���������� ������� �� ������, ����������� 4-� ����� �����\')"> ';
			break;

			case "ruin2014":
				echo ' <img src="http://i.oldbk.com/i/ruin2014.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ���������� ������� �� ������, ����������� 4-� ����� �����\')"> ';
			break;

			case "700":
				echo ' <img src="http://i.oldbk.com/i/700_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���������� ������� �� ��������!\')"> ';
			break;

			case "701":
				echo ' <img src="http://i.oldbk.com/i/701_1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������� �� ��������!\')"> ';
			break;

			case "702":
				echo ' <img src="http://i.oldbk.com/i/702_2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������� �� ��������!\')"> ';
			break;

			case "703":
				echo ' <img src="http://i.oldbk.com/i/703_3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������� �� ��������!\')"> ';
			break;

			case "704":
				echo ' <img src="http://i.oldbk.com/i/704_f.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����������� ������� �� ��������!\')"> ';
			break;

			case "705":
				echo ' <img src="http://i.oldbk.com/i/705_m.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����������� ������� �� ��������!\')"> ';
			break;
			case "091":
				echo ' <img src="http://i.oldbk.com/i/091.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� �� II ����� ������� ���\')"> ';
			break;
			case "991sd":
				echo ' <img src="http://i.oldbk.com/i/991sd.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ����� ������� ��� 16-19.10.2012\')"> ';
			break;
			case "093":
				echo ' <img src="http://i.oldbk.com/i/071.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� ����� �� �������� � ������ 17.02.12!\')"> ';
			break;
			case "094":
				echo ' <img src="http://i.oldbk.com/i/072.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� ����� �� �������� � ������ 17.02.12!\')"> ';
			break;
			case "092":
				echo ' <img src="http://i.oldbk.com/i/070.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� ����� �� �������� � ������ 17.02.12!\')"> ';
			break;
			case "095":
				echo ' <img src="http://i.oldbk.com/i/073.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � ������� ����� �� �������� � ������ 17.02.12!\')"> ';
			break;
			case "096":
				echo ' <img src="http://i.oldbk.com/i/074.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� ����� �� �������� � ������ 17.02.12!\')"> ';
			break;
			case "097":
				echo ' <img src="http://i.oldbk.com/i/075.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � ������� ����� �� �������� � ������ 17.02.12!\')"> ';
			break;
			case "105":
				echo ' <img src="http://i.oldbk.com/i/105.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ����� 2012 - ���������� �������� �� ����� Brigada!\')"> ';
			break;
			case "106":
				echo ' <img src="http://i.oldbk.com/i/106.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ����� 2012 - ���������� �������� �� ����� Brigada!\')"> ';
			break;
			case "107":
				echo ' <img src="http://i.oldbk.com/i/107.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ���� ����� 2012 - ���������� �������� �� ����� Brigada!\')"> ';
			break;
			case "108":
				echo ' <img src="http://i.oldbk.com/i/108.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � �������� ������ 2011!\')"> ';
			break;
			case "109":
				echo ' <img src="http://i.oldbk.com/i/109.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � �������� ������ 2011!\')"> ';
			break;
			case "110":
				echo ' <img src="http://i.oldbk.com/i/110.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � �������� ������ 2011!\')"> ';
			break;
			case "112":
				echo ' <img src="http://i.oldbk.com/i/ruins1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������ ������� � ������ 2012\')"> ';
			break;
			case "113":
				echo ' <img src="http://i.oldbk.com/i/ruins2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������ ������� � ������ 2012\')"> ';
			break;
			case "114":
				echo ' <img src="http://i.oldbk.com/i/ruins3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������ ������� � ������ 2012\')"> ';
			break;

			case "210":
				echo ' <img src="http://i.oldbk.com/i/ruins210.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� �� II ��������� ������� �� ������ �����!\')"> ';
			break;
			case "211":
				echo ' <img src="http://i.oldbk.com/i/ruins211.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ �� II ��������� ������� �� ������ �����!\')"> ';
			break;
			case "212":
				echo ' <img src="http://i.oldbk.com/i/ruins212.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ ����� �� II ��������� ������� �� ������ �����!\')"> ';
			break;
			case "213":
				echo ' <img src="http://i.oldbk.com/i/ruins213.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ ����� �� II ��������� ������� �� ������ �����!\')"> ';
			break;

			case "115":
				echo ' <img src="http://i.oldbk.com/i/083.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � 4� ������� ����� �� �������� � ������ 25.08.12!\')"> ';
			break;
			case "116":
				echo ' <img src="http://i.oldbk.com/i/084.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � 4� ������� ����� �� �������� � ������ 25.08.12!\')"> ';
			break;
			case "117":
				echo ' <img src="http://i.oldbk.com/i/085.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � 4� ������� ����� �� �������� � ������ 25.08.12!\')"> ';
			break;
			case "118":
				echo ' <img src="http://i.oldbk.com/i/086.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � 4� ������� ����� �� �������� � ������ 25.08.12!\')"> ';
			break;
			case "119":
				echo ' <img src="http://i.oldbk.com/i/087.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � 4� ������� ����� �� �������� � ������ 25.08.12!\')"> ';
			break;
			case "120":
				echo ' <img src="http://i.oldbk.com/i/088.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � 4� ������� ����� �� �������� � ������ 25.08.12!\')"> ';
			break;
			case "122":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������ ������� ����� �� ������ 2012!\')"> ';
			break;
			case "123":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������ ������� ����� �� ������ 2012!\')"> ';
			break;
			case "124":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������ ������� ����� �� ������ 2012!\')"> ';
			break;
			case "125":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� ������� ����� �� ������ 28.11.2012!\')"> ';
			break;
			case "126":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� ������� ����� �� ������ 28.11.2012!\')"> ';
			break;
			case "127":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� ������� ����� �� ������ 28.11.2012!\')"> ';
			break;
			case "128":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� ������� ����� �� ������ 28.11.2012!\')"> ';
			break;
			case "129":
				echo ' <img src="http://i.oldbk.com/i/129.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "130":
				echo ' <img src="http://i.oldbk.com/i/130.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "131":
				echo ' <img src="http://i.oldbk.com/i/131.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "132":
				echo ' <img src="http://i.oldbk.com/i/132.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "133":
				echo ' <img src="http://i.oldbk.com/i/133.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ���������� ����� ����������� �� ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "134":
				echo ' <img src="http://i.oldbk.com/i/134.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ���������� ����� ����������� �� ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "135":
				echo ' <img src="http://i.oldbk.com/i/135.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ���������� ����� ����������� �� ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "136":
				echo ' <img src="http://i.oldbk.com/i/136.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ��������� �� ������� �� �������� � ������ � ����� 3�-����� �����!\')"> ';
			break;
			case "137":
				echo ' <img src="http://i.oldbk.com/i/mb1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������ �������� ������� �� �������� ��� �� DarkClan!\')"> ';
			break;
			case "138":
				echo ' <img src="http://i.oldbk.com/i/mb2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������ �������� ������� �� �������� ��� �� DarkClan!\')"> ';
			break;
			case "139":
				echo ' <img src="http://i.oldbk.com/i/mb3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������ �������� ������� �� �������� ��� �� DarkClan!\')"> ';
			break;
			case "140":
				echo ' <img src="http://i.oldbk.com/i/mb.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�������� ������� ��������� ������� �� �������� ��� �� DarkClan!\')"> ';
			break;
			case "141":
				echo ' <img src="http://i.oldbk.com/i/141.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ �������!\')"> ';
			break;
			case "142":
				echo ' <img src="http://i.oldbk.com/i/142.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������!\')"> ';
			break;
			case "143":
				echo ' <img src="http://i.oldbk.com/i/143.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ���� ������!\')"> ';
			break;
			case "144":
				echo ' <img src="http://i.oldbk.com/i/144.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ��� ���� ������ � ���� ������!\')"> ';
			break;
			case "145":
				echo ' <img src="http://i.oldbk.com/i/145.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� ���� ������ � ���� ������!\')"> ';
			break;
			case "146":
				echo ' <img src="http://i.oldbk.com/i/146.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ��� ������ � ���� ������!\')"> ';
			break;
			case "147":
				echo ' <img src="http://i.oldbk.com/i/147.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� ������ � ���� ������!\')"> ';
			break;
			case "148":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � �������� ������� ����� �� ������ 29.05.2013!\')"> ';
			break;
			case "149":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � �������� ������� ����� �� ������ 29.05.2013!\')"> ';
			break;
			case "150":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � �������� ������� ����� �� ������ 29.05.2013!\')"> ';
			break;
			case "151":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � �������� ������� ����� �� ������ 29.05.2013!\')"> ';
			break;

			case "191":
				echo ' <img src="http://i.oldbk.com/i/bowling_Imesto2018.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������� �� �������� � ����� 8 ����� �����!\')"> ';
			break;

			case "192":
				echo ' <img src="http://i.oldbk.com/i/bowling_IImesto2018.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������� �� �������� � ����� 8 ����� �����!\')"> ';
			break;

			case "193":
				echo ' <img src="http://i.oldbk.com/i/bowling_IIImesto2018.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������� �� �������� � ����� 8 ����� �����!\')"> ';
			break;

			case "194":
				echo ' <img src="http://i.oldbk.com/i/bowling_users2018.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���������� ������� �� �������� � ����� 8 ����� �����!\')"> ';
			break;

			case "195":
				echo ' <img src="http://i.oldbk.com/i/bowling_fan2018.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ���������� �� ������� �� �������� � ����� 8 ����� �����!\')"> ';
			break;

			case "301":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � �������� ������� ����� �� ������ 07.06.2015!\')"> ';
			break;
			case "302":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � �������� ������� ����� �� ������ 07.06.2015!\')"> ';
			break;
			case "303":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\' �� III ����� � �������� ������� ����� �� ������ 07.06.2015!\')"> ';
			break;

			case "2148":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � �������� ������� ����� �� ������ 31.05.2014!\')"> ';
			break;
			case "2149":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � �������� ������� ����� �� ������ 31.05.2014!\')"> ';
			break;
			case "2150":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � �������� ������� ����� �� ������ 31.05.2014!\')"> ';
			break;
			case "2151":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � �������� ������� ����� �� ������ 31.05.2014!\')"> ';
			break;


			case "pkr1113_0":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������� ������� ����� �� ������ 27.11.2013!\')"> ';
			break;
			case "pkr1113_1":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������� ������� ����� �� ������ 27.11.2013!\')"> ';
			break;
			case "pkr1113_2":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������� ������� ����� �� ������ 27.11.2013!\')"> ';
			break;
			case "pkr1113_3":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������� ������� ����� �� ������ 27.11.2013!\')"> ';
			break;

			case "pkr1115_1":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������� ������� ����� �� ������ 29.112015!\')"> ';
			break;
			case "pkr1115_2":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������� ������� ����� �� ������ 29.112015!\')"> ';
			break;
			case "pkr1115_3":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������� ������� ����� �� ������ 29.112015!\')"> ';
			break;


			case "152":
				echo ' <img src="http://i.oldbk.com/i/048.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� �����. �� �������� ���� ��������� (2013)!\')"> ';
			break;
			case "098":
				echo ' <img src="http://i.oldbk.com/i/098.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ���������� �������!\')"> ';
			break;
			case "099":
				echo ' <img src="http://i.oldbk.com/i/099.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� ����� �����������!\')"> ';
			break;
			case "200":
				echo ' <img src="http://i.oldbk.com/i/200.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� ����� �����������!\')"> ';
			break;
			case "201":
				echo ' <img src="http://i.oldbk.com/i/201.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� ����� �����������!\')"> ';
			break;
			case "k202":
				echo ' <img src="http://i.oldbk.com/i/202medal.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� �����!\')"> ';
			break;
			case "k203":
				echo ' <img src="http://i.oldbk.com/i/203medal.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'����������� ����!\')"> ';
			break;
			case "chgk4":
				echo ' <img src="http://i.oldbk.com/i/chgk4.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ������ ����?���?�����?�\')"> ';
			break;
			case "chgk5":
				echo ' <img src="http://i.oldbk.com/i/chgk5.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ������ ���������� ����? ���? �����?�\')"> ';
			break;
			case "ev2012":
				echo ' <img src="http://i.oldbk.com/i/euro2012v10.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'Euro 2012\')"> ';
			break;
			case "hell2012":
				echo ' <img src="http://i.oldbk.com/i/helloween_2011m2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� Halloween 31.10.12\')"> ';
			break;
			case "hell2013":
				echo ' <img src="http://i.oldbk.com/i/helloween_2011m2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� Halloween 31.10.13\')"> ';
			break;
			case "hell2014":
				echo ' <img src="http://i.oldbk.com/i/helloween_2011m2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� Halloween 31.10.2014-01.11.2014  \')"> ';
			break;
			case "hell2015":
				echo ' <img src="http://i.oldbk.com/i/helloween_2011m2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� Halloween 31.10.2015-01.11.2015  \')"> ';
			break;
			case "hell2016":
				echo ' <img src="http://i.oldbk.com/i/helloween_2011m2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� Halloween-2016\')"> ';
			break;
      case "hell2018":
				echo ' <img src="http://i.oldbk.com/i/helloween_2011m2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ��� �� Halloween-2018\')"> ';
			break;
			case "pkr2013_1":
				echo ' <img src="http://i.oldbk.com/i/poker_leto_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'1-� ����� � ������ ������� ����� �� ������ 28.08.2013\')"> ';
			break;
			case "pkr2013_2":
				echo ' <img src="http://i.oldbk.com/i/poker_leto_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'2-� ����� � ������ ������� ����� �� ������ 28.08.2013\')"> ';
			break;

			case "pkr2013_3":
				echo ' <img src="http://i.oldbk.com/i/poker_leto_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'3-� ����� � ������ ������� ����� �� ������ 28.08.2013\')"> ';
			break;
			case "pkr2013_0":
				echo ' <img src="http://i.oldbk.com/i/poker_leto_2013.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ ������� ����� �� ������ 28.08.2013\')"> ';
			break;

			case "pk151":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������ ������� ����� �� ������ 30.08.2015\')"> ';
			break;
			case "pk152":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������ ������� ����� �� ������ 30.08.2015\')"> ';
			break;

			case "rui15_0":
				echo ' <img src="http://i.oldbk.com/i/ruins15_0.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � IV ��������� ������� �� ������ �����!\')"> ';
			break;

			case "rui15_1":
				echo ' <img src="http://i.oldbk.com/i/ruins15_1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ � IV ��������� ������� �� ������ �����!\')"> ';
			break;

			case "rui15_2":
				echo ' <img src="http://i.oldbk.com/i/ruins15_2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � IV ��������� ������� �� ������ �����!\')"> ';
			break;

			case "rui15_3":
				echo ' <img src="http://i.oldbk.com/i/ruins15_3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � IV ��������� ������� �� ������ �����!\')"> ';
			break;


			case "p2015a1":
				echo ' <img src="http://i.oldbk.com/i/poker_2015a1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ � ������ �������� ������� �� ������ �����!\')"> ';
			break;

			case "p2015a2":
				echo ' <img src="http://i.oldbk.com/i/poker_2015a3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������ �������� ������� �� ������ �����!\')"> ';
			break;

			case "p2015a3":
				echo ' <img src="http://i.oldbk.com/i/poker_2015a2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������ �������� ������� �� ������ �����!\')"> ';
			break;

			case "p2015a4":
				echo ' <img src="http://i.oldbk.com/i/poker_2015a4.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ �������� ������� �� ������ �����!\')"> ';
			break;

			case "hist2013":
				echo ' <img src="http://i.oldbk.com/i/hist_2013.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���������� �������� ������� ������ 2013\')"> ';
			break;
			case "153":
				echo ' <img src="http://i.oldbk.com/i/083.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � 6� ������� ����� �� �������� � ������ 02.11.13!\')"> ';
			break;
			case "154":
				echo ' <img src="http://i.oldbk.com/i/084.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � 6� ������� ����� �� �������� � ������ 02.11.13!\')"> ';
			break;
			case "155":
				echo ' <img src="http://i.oldbk.com/i/085.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � 6� ������� ����� �� �������� � ������ 02.11.13!\')"> ';
			break;
			case "156":
				echo ' <img src="http://i.oldbk.com/i/086.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � 6� ������� ����� �� �������� � ������ 02.11.13!\')"> ';
			break;
			case "157":
				echo ' <img src="http://i.oldbk.com/i/087.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � 6� ������� ����� �� �������� � ������ 02.11.13!\')"> ';
			break;
			case "158":
				echo ' <img src="http://i.oldbk.com/i/088.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� ��������� � 6� ������� ����� �� �������� � ������ 02.11.13!\')"> ';
			break;
			case "159":
				echo ' <img src="http://i.oldbk.com/i/159.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�������� ������� 2013 - I �����!\')"> ';
			break;
			case "160":
				echo ' <img src="http://i.oldbk.com/i/160.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� �������� �������� ������� 2013!\')"> ';
			break;
			case "161":
				echo ' <img src="http://i.oldbk.com/i/159.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�������� ������� 2013 - II �����!\')"> ';
			break;
			case "162":
				echo ' <img src="http://i.oldbk.com/i/159.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�������� ������� 2013 - III �����!\')"> ';
			break;
			case "er13_1":
				echo ' <img src="http://i.oldbk.com/i/er13_1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2013 - I �����!\')"> ';
			break;
			case "er13_2":
				echo ' <img src="http://i.oldbk.com/i/er13_2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2013 - II �����!\')"> ';
			break;
			case "er13_3":
				echo ' <img src="http://i.oldbk.com/i/er13_3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2013 - III �����!\')"> ';
			break;
			case "er13_4":
				echo ' <img src="http://i.oldbk.com/i/er13_4.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� �������� ���� ������� 2013!\')"> ';
			break;
			case "170":
				echo ' <img src="http://i.oldbk.com/i/mbu.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�������� ��������� ������� �� ��������� ���� �� Dark Clan! 2014\')"> ';
			break;
			case "171":
				echo ' <img src="http://i.oldbk.com/i/mb1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � �������� ������� �� ��������� ���� �� Dark Clan! 2014\')"> ';
			break;
			case "172":
				echo ' <img src="http://i.oldbk.com/i/mb2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � �������� ������� �� ��������� ���� �� Dark Clan! 2014\')"> ';
			break;
			case "173":
				echo ' <img src="http://i.oldbk.com/i/mb3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � �������� ������� �� ��������� ���� �� Dark Clan! 2014\')"> ';
			break;
			case "174":
				echo ' <img src="http://i.oldbk.com/i/048.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ ��������� ����� (2013-2014)!\')"> ';
			break;

			case "175":
				echo ' <img src="http://i.oldbk.com/i/fifa2014.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'World Cup 2014!\')"> ';
			break;

			case "pkr214_0":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ ������� ����� �� ������ 28.02.2014!\')"> ';
			break;
			case "pkr214_1":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'I ����� � ������ ������� ����� �� ������ 28.02.2014!\')"> ';
			break;
			case "pkr214_2":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'II ����� � ������ ������� ����� �� ������ 28.02.2014!\')"> ';
			break;
			case "pkr214_3":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'III ����� � ������ ������� ����� �� ������ 28.02.2014!\')"> ';
			break;

			case "pkr314_0":
				echo ' <img src="http://i.oldbk.com/i/079.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � ������ ������ �� ������ ����� 28.02.2015!\')"> ';
			break;
			case "pkr314_1":
				echo ' <img src="http://i.oldbk.com/i/080.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� I ����� � ������ ������ �� ������ ����� 28.02.2015!\')"> ';
			break;
			case "pkr314_2":
				echo ' <img src="http://i.oldbk.com/i/081.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� II ����� � ������ ������ �� ������ ����� 28.02.2015!\')"> ';
			break;
			case "pkr314_3":
				echo ' <img src="http://i.oldbk.com/i/082.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� III ����� � ������ ������ �� ������ ����� 28.02.2015!\')"> ';
			break;

			case "501":
				echo ' <img src="http://i.oldbk.com/i/ruini_03.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� � I ��������� ������� �� ������ �����!\')"> ';
			break;
			case "502":
				echo ' <img src="http://i.oldbk.com/i/ruini_09.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ � I ��������� ������� �� ������ �����!\')"> ';
			break;
			case "503":
				echo ' <img src="http://i.oldbk.com/i/ruini_07.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ ����� � I ��������� ������� �� ������ �����!\')"> ';
			break;
			case "504":
				echo ' <img src="http://i.oldbk.com/i/ruini_05.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������ ����� � I ��������� ������� �� ������ �����!\')"> ';
			break;
			case "505":
				echo ' <img src="http://i.oldbk.com/i/miss1.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2014 - 3 �����!\')"> ';
			break;
			case "506":
				echo ' <img src="http://i.oldbk.com/i/miss2.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2014 - 1 �����!\')"> ';
			break;
			case "507":
				echo ' <img src="http://i.oldbk.com/i/miss3.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2014 - 2 �����!\')"> ';
			break;
			case "508":
				echo ' <img src="http://i.oldbk.com/i/miss5.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'���� ������� 2014 - ����������� ��������!\')"> ';
			break;
			case "509":
				echo ' <img src="http://i.oldbk.com/i/miss4.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� �������� ���� ������� 2014!\')"> ';
			break;
			case "510":
				echo ' <img src="http://i.oldbk.com/i/miss4.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������� �������� ���� ������� 2014!\')"> ';
			break;
			case "511":
				echo ' <img src="http://i.oldbk.com/i/battzagorod.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'��������� ����������� ������� 21.09.2014!\')"> ';
			break;
			case "512":
				echo ' <img src="http://i.oldbk.com/i/lordraz1png.png" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������������� ����� �����������!\')"> ';
			break;
			case "513":
				echo ' <img src="http://i.oldbk.com/i/513.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'������ �������� ����� 2011-2015!\')"> ';
			break;


			case "521":
				echo ' <img src="http://i.oldbk.com/i/1_place_ruintourn.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'1-� ����� �� II ������ ���� ����!\')"> ';
			break;

			case "522":
				echo ' <img src="http://i.oldbk.com/i/2_place_ruintourn.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'2-� ����� �� II ������ ���� ����!\')"> ';
			break;

			case "523":
				echo ' <img src="http://i.oldbk.com/i/3_place_ruintourn.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'3-� ����� �� II ������ ���� ����!\')"> ';
			break;

			case "524":
				echo ' <img src="http://i.oldbk.com/i/uchastie_ruintourn.gif" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,25,25,\'�� ������� �� II ������ ���� ����!\')"> ';
			break;


		}

	}

function unset_klan($klan_name=false)
{
	global $db_city;
	//���������
	$sql="select c.*,u.id as uid from oldbk.clans c
	 left join oldbk.users u
	 on u.klan=c.short
	where c.tax_date>0 AND c.tax_timer>0 AND c.tax_timer<(".time()."+60*60*24)  AND c.msg=0 AND c.time_to_del=0";
	$data=mysql_query($sql);
	if(mysql_num_rows($data)>0)
	{
		while($row=mysql_fetch_assoc($data))
		{
			$to_telo=check_users_city_data($row[uid]);
			//���� ���������
			telepost_new($to_telo,'<font color=red><b>��������! ���� ����� ������������� � ������� ����� � ����� � ��������� ������.</b></font>');
			mysql_query("UPDATE oldbk.clans SET msg=1 WHERE id=".$row[id].";");
		}

	}

	$sql="select c.*,u.id as uid from oldbk.clans c
	 left join oldbk.users u
	 on u.klan=c.short
	where c.tax_date>0 AND c.tax_timer>0 AND c.tax_timer<(".time()."+60*60*12)  AND c.msg=0 AND c.time_to_del=0";
	$data=mysql_query($sql);
	if(mysql_num_rows($data)>0)
	{
		while($row=mysql_fetch_assoc($data))
		{
			$to_telo=check_users_city_data($row[uid]);
			//���� ���������
			telepost_new($to_telo,'<font color=red><b>��������! ���� ����� ������������� � ������� 12 ����� � ����� � ��������� ������.</b></font>');
		}
		mysql_query("UPDATE oldbk.clans SET msg=2 WHERE id=".$row[id].";");
	}



	if($klan_name)
	{
		$kl_data=mysql_query("SELECT * FROM oldbk.clans WHERE short='".$klan_name."' ;");
	}
	else
	{
		$kl_data=mysql_query("SELECT * FROM oldbk.clans WHERE tax_timer>0 AND tax_timer<'".time()."' AND time_to_del=0 ;");
	}




	if(mysql_num_rows($kl_data)>0)
	{
		while($kl=mysql_fetch_array($kl_data))
		{
			$data=mysql_query("select * from oldbk.users where klan='".$kl[short]."';");
		 	while($sok=mysql_fetch_array($data))
		 	{
		 		$sok=check_users_city_data($sok[id]); //��������� ��� ����

		 		Test_Arsenal_Items($sok); //������ ��� �������� ����� � ���������
		 		$sql="insert oldbk.lichka SET  text='����� ����� ".$sok[klan]." � ���������� ��������������� �����.', pers='".$sok[id]."', date=".time()." ;";
				mysql_query($sql); //���������� � ����� ������� ��������

				foreach($db_city as $k=>$v)
				{
					//��������� ����� � ������ ������� �� ������
					mysql_query('update '.$v.'`users` set `klan` = \'\', `status` = \'\', `align` = 0 WHERE `id` = '.$sok['id'].';');
				}
				//�������

				mysql_query("INSERT INTO oldbk.users_klandel_hist SET
				uid=".$sok[id].",
				kid=".$kl[id].",
				deldate=".time().";");

				telegraph_new($sok,'���� ������������� � ����� � ��������� ������.');
		 	}
			mysql_query("UPDATE oldbk.clans SET rekrut_klan='' , base_klan='', time_to_del = '".(time()+60*60*24*60)."' WHERE id = '".$kl[id]."';");
			mysql_query('UPDATE topsites.top SET ban = 1 WHERE klan = "'.$kl['short'].'"');



		}
	}
}

?>
