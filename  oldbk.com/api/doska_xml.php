<?php
//memcach
$rooms = array ("��������� �������","������� ��� ��������","������� ��� �������� 2","������� ��� �������� 3","������� ��� �������� 4","��� ������ 1","��� ������ 2","��� ������ 3","�������� ���",
	"��������� ���","����� �������-�����","���������� ���","����� �����","���������� �����","�������� ���","��� ���������","����� ������ ��������","��� ����","������� ����","������",
	"����������� �������","����������� �����","�������","��������� ����������","���������� ����","������������ �������","�������� �����","�����","������������ ������","����","���",
	"����� ������","���������� �����","�������� �����","��������� �������","������� '�������'","��� ������","���������� ����� - ��������","���������� ����� - �������","���������� ����� - ���������� ����",
	"���������� ����� - ����������","���������� ����� - ������� ������","������� ���������","������� �������","������� �44","���� � �������� �����","��������� �����","�������� �����","�������� �����","���� �������","�������� �������",
	"������� ��������","������� ��������","��������� ��������","��� �����","������� �����","������� ������","��� �������� ����","������� �58","������� �59","����� �����","������� �61","������� �62","������� �63","������� �64","������� �65","66"=>'�������� �����',
"200"=> "���������","401"=> "����� ���");

header ("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";


include "/www/oldbk.com/connect.php";
require_once('/www/oldbk.com/memcache.php');

function CheckOpDay() {
	$q = mysql_query('SELECT * FROM oldbk.variables WHERE var = "opposition_today"');
	if (mysql_num_rows($q) > 0) {
		$v = mysql_fetch_assoc($q);
		if ($v !== FALSE) {
			if (date("d/m/Y",time()+(24*3600*4)) == $v['value']) {
				if (date("H") >= 6) {
					return true;
				}
			}
		}
	}
	return false;
}



function prettyTime($start_timestamp = null, $end_timestamp = null)
{
    $start_datetime = new DateTime();
    if($start_timestamp !== null) {
        $start_datetime->setTimestamp($start_timestamp);
    }

    $end_datetime = new DateTime();
    if($end_timestamp !== null) {
        $end_datetime->setTimestamp($end_timestamp);
    }

    if(($end_datetime->getTimestamp() - $start_datetime->getTimestamp()) <= 60) {
       return '����� ������';
    }

    $interval = $end_datetime->diff($start_datetime);

    $time_type = array(
        'm' => '%m ���.',
        'd' => '%d ��.',
        'h' => '%h �.',
        'i' => '%i ���.',
    );
    $format_arr = array();
    foreach($time_type as $property => $format) {
        if($interval->{$property} != 0) {
            $format_arr[] = $format;
        }
    }

    if(empty($format_arr)) {
        return null;
    }

    return $interval->format(implode(' ', $format_arr));
}

echo "<message refresh=\"".time()."\">";
 
  
   echo '<event name="������� �����" ';

  // $get_lot=mysql_fetch_array(mysql_query("select * from oldbk.item_loto_ras where status=1 LIMIT 1;"));
	$get_lot=mysql_query_cache("select * from oldbk.item_loto_ras where status=1 LIMIT 1;",false,3600);
	$get_lot=$get_lot[0];

   if ($get_lot[id] >0)
   {
   echo "description=\"��������� ����� � $get_lot[id] ��������� ".date("d-m-Y H:i",$get_lot[lotodate])."\">";
   }
   else
   {
   echo "description=\"��� ������\"> ";
   }
   echo "</event>\n";

   $data=mysql_query_cache('select * from place_zay order by start limit 5',false,300);
 
	while(list($k,$row) = each($data)) 
   {
      echo "<event name=\"��������� ��� �� ����� ����� ���� VS T��� - CapitalCity\" ";
      echo "description=\"������� ".($row[t1min]==$row[t1max]?$row[t1min]:$row[t1min].'-'.$row[t1max]).": ".date('d-m-Y', $row[start])." � ".date('H:i:s', $row[start])."  (".$row[coment].")\">";
      echo "</event>\n";
   }

/*   
$data=mysql_query_cache('select * from avalon.place_zay order by start limit 5',false,300);
   
	while(list($k,$row) = each($data)) 
   {
      echo "<event name=\"��������� ��� �� ����� ����� ���� VS T��� - AvalonCity\" ";
      echo "description=\"������� ".($row[t1min]==$row[t1max]?$row[t1min]:$row[t1min].'-'.$row[t1max]).": ".date('d-m-Y', $row[start])." � ".date('H:i:s', $row[start])."  (".$row[coment].")\">";
      echo "</event>\n";
   }
*/

/*      
   //��������� �������
   $nt=mysql_query_cache("select * from tur_raspis where tur_type=210 LIMIT 1;",false,120);
   $nt= $nt[0];

        echo "<event name=\"��������� �������� (6-10 ������ �� ���������) - CapitalCity\" ";
	if ($nt[status]==0)
		{
		echo "description=\"".date('d-m-Y', $nt[start_time])." � ".date('H:i:s', $nt[start_time])."\">";
		}
		else
		if ($nt[status]==1)
		{
		echo "description=\"������ ������ �����!\">";
		}
		else
		if ($nt[status]==2)
		{
		echo "description=\"������ ��� ����!\">";
		}

      	echo "</event>\n";
	
   /////////////////////////////////////////////////////
 //��������� �������
 $nt=mysql_query_cache("select * from avalon.tur_raspis where tur_type=210 LIMIT 1;",false,120);
   $nt= $nt[0];
   
	
        echo "<event name=\"��������� �������� (6-10 ������ �� ���������) - AvalonCity\" ";
	if ($nt[status]==0)
		{
		echo "description=\"".date('d-m-Y', $nt[start_time])." � ".date('H:i:s', $nt[start_time])."\">";
		}
		else
		if ($nt[status]==1)
		{
		echo "description=\"������ ������ �����!\">";
		}
		else
		if ($nt[status]==2)
		{
		echo "description=\"������ ��� ����!\">";
		}

      	echo "</event>\n";
	
   /////////////////////////////////////////////////////



   //������ �������
    $nt=mysql_query_cache("select * from tur_raspis where tur_type=270 LIMIT 1;",false,120);
    $nt= $nt[0];

	    echo "<event name=\"�������� ������� (6-10 ������ �� ���������) - CapitalCity\" ";
	if ($nt[status]==0)
		{
		echo "description=\"".date('d-m-Y', $nt[start_time])." � ".date('H:i:s', $nt[start_time])."\">";
		}
		else
		if ($nt[status]==1)
		{
		echo "description=\"������ ������ �����!\">";
		}
		else
		if ($nt[status]==2)
		{
		echo "description=\"������ ��� ����!\">";
		}

      	echo "</event>\n";
	
   /////////////////////////////////////////////////////
   
 //������ �������
 $nt=mysql_query_cache("select * from avalon.tur_raspis where tur_type=270 LIMIT 1;",false,120);
 $nt= $nt[0];
   
	    echo "<event name=\"�������� ������� (6-10 ������ �� ���������) - AvalonCity\" ";
	if ($nt[status]==0)
		{
		echo "description=\"".date('d-m-Y', $nt[start_time])." � ".date('H:i:s', $nt[start_time])."\">";
		}
		else
		if ($nt[status]==1)
		{
		echo "description=\"������ ������ �����!\">";
		}
		else
		if ($nt[status]==2)
		{
		echo "description=\"������ ��� ����!\">";
		}

      	echo "</event>\n";

   /////////////////////////////////////////////////////   


 //������ �������
//  $nt=mysql_query_cache("select * from tur_raspis where tur_type=240 LIMIT 1;",false,120);
//  $nt= $nt[0];
$nt[status]=1;
$nt[start_time]=time();
 
	  echo "<event name=\"��������� �������� (7-10 ������ �� ���������) - CapitalCity\" ";
	if ($nt[status]==0)
		{
		echo "description=\"".date('d-m-Y', $nt[start_time])." � ".date('H:i:s', $nt[start_time])."\">";
		}
		else
		if ($nt[status]==1)
		{
		echo "description=\"������ ������ �����!\">";
		}
		else
		if ($nt[status]==2)
		{
		echo "description=\"������ ��� ����!\">";
		}

	   echo "</event>\n";

   /////////////////////////////////////////////////////

 //������ �������
//    $nt=mysql_query_cache("select * from avalon.tur_raspis where tur_type=240 LIMIT 1;",false,120);
//   $nt= $nt[0];
$nt[status]=1;
$nt[start_time]=time();
	  echo "<event name=\"��������� �������� (7-10 ������ �� ���������) - Avalon.City\" ";
	if ($nt[status]==0)
		{
		echo "description=\"".date('d-m-Y', $nt[start_time])." � ".date('H:i:s', $nt[start_time])."\">";
		}
		else
		if ($nt[status]==1)
		{
		echo "description=\"������ ������ �����!\">";
		}
		else
		if ($nt[status]==2)
		{
		echo "description=\"������ ��� ����!\">";
		}

	   echo "</event>\n";
   /////////////////////////////////////////////////////
*/

	$bs=mysql_query_cache('SELECT * FROM dt_var WHERE var = "nextdt"',false,120);
	while(list($k,$row) = each($bs)) 
	{
		$nextdt=$row;
	}

	$tbs=mysql_query_cache("SELECT * FROM dt_var WHERE var='nextdttype'",false,120);
	while(list($tk,$trow) = each($tbs)) 
	{
		$nextdttype=$trow;
	}
   
	$min_bet = 5;
	$min_up = 3;

	if($nextdttype['valint'] > 0) {
		$min_bet = 10;
		$min_up = 5;
	}
   
   $txt=(($nextdt['valint']<time())?'������ ��� �������':date("d.m.Y H:i",$nextdt['valint']));
   echo "<event name=\"������ ��������� ����� ������ ".$min_up."-".$min_bet." ��. ".($nextdttype['valint']>0?'(�������)':'')." - CapitalCity\" ";
   echo "description=\"".$txt."\">";
   echo "</event>\n";      

//////////////////

   /////////////////////////////////////////////////////

/*
	$bs=mysql_query_cache("select * from avalon.`variables` where `var` in ('startbs','bs_type','bs_level')",false,120);
	while(list($k,$row) = each($bs)) 
	{
		if ($row['var']=='startbs') {$bs[value]=$row[value] ; } 
		elseif ($row['var']=='bs_type') {$bs_type[value]=$row[value] ; } 
		elseif ($row['var']=='bs_level') {$bs_level[value]=$row[value] ; } 		
	}

   
   //$cur_bs=mysql_fetch_array(mysql_query('select * from `deztow_turnir` where active=true LIMIT 1'));
   
   $txt=(($bs[value]<time())?'������ ��� �������':date("d-m-Y � H:i", $bs[value]));
   echo "<event name=\"������ ��������� ����� ������ ".$bs_level[value]."-��. ".($bs_type[value]==2?'(�������)':'')." - AvalonCity\" ";
   echo "description=\"".$txt."\">";
   echo "</event>\n";      
*/

   /////////////////////////////////////////////////////
	$op = CheckOpDay();

		if ($op == true) 
				{
				// ��������������
				   echo "<event name=\"���� ��������������\" ";
				   echo "description=\"�������\">";
				   echo "</event>\n";      
				} else 
				{
				// ����� ����� ������� ��� ����
				
				$opd=mysql_query_cache('SELECT * FROM oldbk.variables WHERE var = "opposition_today"',false,120);
				while(list($ok,$orow) = each($opd)) 
				{
				$v=$orow;
				}
				
				$st=str_replace('/', '-', $v['value'])." 06:00";
				$next_op_time = strtotime($st);
					if (date("d/m/Y",time()+(24*3600*4)) == $v['value']) {
						$txt= "����� ".prettyTime(null,mktime(6,0,0));	
					} else {
						$txt= "����� ".prettyTime(null,$next_op_time);	
					}
				   echo "<event name=\"���� ��������������\" ";
				   echo "description=\"".$txt."\">";
				   echo "</event>\n"; 
				}
	
//////////////////

//////////////////





		$t=mysql_query_cache("select * from variables where var='ghost_all_time' ; ",false,60);
		$t=$t[0];

		$freedomt=$t[value];
		echo "<event name=\"������� �����\" ";

		if ($freedomt-time() > 0)
			{
				$Xonline=false;			   
			}
			else
			{
			 $get_bot_next=mysql_query_cache("select id, login, bot_room  from users_clons where id_user=(select value from variables where var='ghost_next_id')",false,300);
       			    $get_bot_next=$get_bot_next[0];
				if ($get_bot_next[login]!='')
				{
				$Xonline=true;
				}
				else
				{
				$Xonline=false;
				}
			
			}
			
		if ($Xonline==false)
		   {
   		    $get_bot_next=mysql_query_cache("select id, login  from users where id=(select value from variables where var='ghost_next_id')",false,300);
   		    $get_bot_next=$get_bot_next[0];
   		    
		     if   ($freedomt-time() > 0)
		     {
		     echo "description=\"".$get_bot_next[login]." - ������� �� ������� �����: ".prettyTime(null,$freedomt)."\" ";
		     }
		     else
		     {
			echo "description=\"".$get_bot_next[login]." - ��� � ����.\" ";		     
		     }
		   
		   
		    echo " bot_id=\"$get_bot_next[id]\" >";
		    }
		    else
		    {
		       echo "description=\"".$get_bot_next[login]."- ������\"";
		       echo " bot_id=\"$get_bot_next[id]\" bot_room=\"".$rooms[$get_bot_next['bot_room']]."\" >";
		    }
		    
		echo "</event>\n";       
		

//////////////////

/*
		$t=mysql_query_cache("select * from avalon.variables where var='ghost_all_time' ; ",false,60);
		$t=$t[0];
		
		$freedomt=$t[value];
		echo "<event name=\"��� �������\" ";
		
		if ($freedomt-time() > 0)
				{
				$Donline=false;		
				}
				else
				{
				    $get_bot_next=mysql_query_cache("select id, login, bot_room  from avalon.users_clons where id_user=(select value from avalon.variables where var='ghost_next_id')",false,300);
		       		    $get_bot_next=$get_bot_next[0];
       		    
		       		    if ($get_bot_next[login]!='')
					{
					$Donline=true;
					}
					else
					{
					$Donline=false;
					}

				}
		
		if ($Donline==false)
		   {
   		    $get_bot_next=mysql_query_cache("select id, login  from avalon.users where id=(select value from avalon.variables where var='ghost_next_id')",false,300);
   		    $get_bot_next=$get_bot_next[0];
   		    
   		 if   ($freedomt-time() > 0)
   		    	{
			    echo "description=\"".$get_bot_next[login]." - ������� �� ������� �����:".floor(($freedomt-time())/60/60)." �. ".round((($freedomt-time())/60)-(floor(($freedomt-time())/3600)*60))." ���.\" ";
			  }
			  else
			  {
			    echo "description=\"".$get_bot_next[login]." - ��� � ����.\"";
			  }
		    echo " bot_id=\"$get_bot_next[id]\" >";
		    }
		    else
		    {
		       echo "description=\"".$get_bot_next[login]."- ������\"";
		       echo " bot_id=\"$get_bot_next[id]\" bot_room=\"".$rooms[$get_bot_next['bot_room']]."\" >";
		    }
		echo "</event>\n";       
*/
//////////////////������� 

		$data=mysql_query_cache("select * from variables where var like 'bots_start_time_level_%'",false,60);
		$bots=array();
		while(list($k,$row) = each($data)) 
		   {
		   $in=explode("_",$row['var']);
		   $bots[$in[4]]=$row['value'];
		   }
		
		ksort($bots); 
		
		foreach($bots as $lvl=>$dat)  
			{
		      
				echo "<event name=\"����� �� �������� ".$lvl."-� �������\"  level=\"".$lvl."\" outtime=\"".$dat."\"  outdate=\"".date("Y.m.d H:i:s",$dat)."\" ";
				if ($dat <= time())
				   {
				       echo "description=\"������� �����\"";
				       echo ">";
				    }
				    else
				    {
				    echo "description=\"�����: ".prettyTime(null,$dat)."\" ";
				    echo "  >";				    
				    }
				    
				echo "</event>\n";  
		      			
			}				   
    
//�������

		$data=mysql_query_cache("select * from variables where var='friday_time'  ",false,60);
		$bots=array();
		while(list($k,$row) = each($data)) 
		   {
		   $bots['friday']=$row['value'];
		   }
		
		foreach($bots as $n=>$dat)  
			{
		      
				echo "<event name=\"�������\"  outtime=\"".$dat."\"  outdate=\"".date("Y.m.d H:i:s",$dat)."\" ";
				if ($dat <= time())
				   {
				       echo "description=\"������\"";
				       echo ">";
				    }
				    else
				    {
				    echo "description=\"�����: ".prettyTime(null,$dat)."\" ";
				    echo "  >";				    
				    }
				    
				echo "</event>\n";  
		      			
			}	
//�������
	

		$data=mysql_query_cache("select * from `variables` where `var`='drevos_out_time'  or `var`='drevos_out'",false,60);
		$bots=array();
		while(list($k,$row) = each($data)) 
		   {
		   	if ($row['var']=='drevos_out_time')
		   		{
				   $bots[0]['h']=$row['value'];
				 }
				 else
			if ($row['var']=='drevos_out')
		   		{
				   $bots[0]['out']=$row['value'];
				 }
		   }
		
		foreach($bots as $n=>$dat)  
			{
					
			$out_bot=mktime($dat['h'],0,0,date("n"),date("d"),date("Y"));
			echo "<event name=\"����������\"  outtime=\"".$out_bot."\"  outdate=\"".date("Y.m.d H:i:s",$out_bot)."\" ";					
				if ($dat[out]>0)
					{
					//����
					echo "description=\"��� ���� ��������\"";
				        echo ">";					
					}
					else
					{
					//�����
					    echo "description=\"�����: ".prettyTime(null,$out_bot)."\" ";
					    echo "  >";				    
					}
				    
				echo "</event>\n";  
		      			
			}	

echo "</message>";
?>
