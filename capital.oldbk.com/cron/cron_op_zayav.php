#!/usr/bin/php
<?php
ini_set('display_errors','On');
$CITY_NAME='capitalcity';
include "/www/".$CITY_NAME.".oldbk.com/cron/init.php";
if( !lockCreate("cron_op_zayav_job") ) {
    exit("Script already running.");
}


//addchp ('<font color=red>��������!</font> Start OP ZAYAV','{[]}Bred{[]}');

$time = time();

$nomagic=(date("i")%2); //  ����� ������ ������ ��� �����


//(06:00-10:00 � 16:00-18:00 ������� 3*3, 4*4 �����)
$h=date("H");

if ((($h>=6)and($h<=10)) OR (($h>=16)and($h<=18)) )
	{
	$kkol=4;
	}
	else
	{
	$kkol=5;
	}



$aligns_array=array(3,2,6);//3-����. 2-������� 6-����


function search_users($lvel,$aligns,$kol=5)
{
//����� ���������� ���

				if ($lvel==13)
				{
				//13 � 14 ������
				$q = mysql_query("select * from zayavka_turn where lvl>=".($lvel)." and lvl<=".($lvel+1)." and align in (".(implode(",",$aligns)).") and zayid=0 order by lvl desc, align , id limit ".$kol);
				echo "select * from zayavka_turn where lvl>=".($lvel)." and lvl<=".($lvel+1)." and align in (".(implode(",",$aligns)).") and zayid=0 order by lvl desc, align , id limit ".$kol ;
				}
				else
				{
				$q = mysql_query("select * from zayavka_turn where lvl=".($lvel)."  and align in (".(implode(",",$aligns)).") and zayid=0 order by lvl desc, align , id limit ".$kol);
				echo "select * from zayavka_turn where lvl=".($lvel)."  and align in (".(implode(",",$aligns)).") and zayid=0 order by lvl desc, align , id limit ".$kol ;

				}
				
				echo "<br>";		

				if (mysql_num_rows($q) == $kol) 
				{
				//���� ������ ����������
				$out_array=array();	
					while($row = mysql_fetch_array($q)) 
						{
						$out_array['ids'][]=$row['owner']; //�� �����
						$out_array['aligns'][$row['align']]++; // ������� �������
						}
					return $out_array;
				}
return false;				
}


function get_str_align($arr)
{
$str[2]=array('<img src="http://i.oldbk.com/i/align_2.gif">�������', '<img src="http://i.oldbk.com/i/align_2.gif">��������', '<img src="http://i.oldbk.com/i/align_2.gif">���������');
$str[3]=array('<img src="http://i.oldbk.com/i/align_3.gif">������', '<img src="http://i.oldbk.com/i/align_3.gif">������', '<img src="http://i.oldbk.com/i/align_3.gif">������');
$str[6]=array('<img src="http://i.oldbk.com/i/align_6.gif">�������', '<img src="http://i.oldbk.com/i/align_6.gif">�������', '<img src="http://i.oldbk.com/i/align_6.gif">�������');
$out_st='';
foreach($arr as $k=>$v)
	{
	$out_st.=declOfNum($v,$str[$k]).", ";
	}
$out_st=substr($out_st,0,-2);	
return $out_st;
}

for ($Li=9;$Li<=13;$Li++)
{
$team=array();
$fails=0;

		
		if ($Li==13)
			{
			echo "����� ��� ������ ".$Li." � ".($Li+1)."  ������� <br>\n";
			}
			else
			{
			echo "����� ��� ������ ".$Li."  ������� <br>\n";
			}
		
		
		for ($t=1;$t<=2;$t++)		
		{
		echo "����� ��� ������� ".$t."<br>\n";		
				foreach($aligns_array as $k=>$v)
					{
						
						if ($t==1)
							{
							//����� ��� ������ �������
							$tmp_users=search_users($Li,array("0"=>$v),$kkol);
							$old_align_key=$k;
							
							if ($tmp_users)
								{
								echo "users for team 1 ok <br>\n";
								$team[$t]=$tmp_users;
								unset($tmp_users);
								break;
								}
								else
								{
								echo "no users for team 1<br>\n";
								}
							}
							else
							{
							$al=$aligns_array;
							unset($al[$old_align_key]);
							$tmp_users=search_users($Li,$al,$kkol);		
							
								if ($tmp_users==false)
								{
								echo "no users for team 2<br>\n";
								unset($tmp_users);
								break;
								}
								else
								{
								echo "���� ��� �������!!! <br>\n";
								$team[$t]=$tmp_users;								
								unset($tmp_users);								
										//������ ������ �� 60 ���
										//���� ������: (5 ������) : (3 �������, 2 ��������),
										
										if ($Li==13)
											{
											$tmin=13;
											$tmax=14;
											}
											else
											{
											$tmin=$Li;
											$tmax=$Li;
											}
										
										mysql_query("INSERT INTO `zayavka` SET `coment`='��� �����������',`type`=3,`team1`='".implode(";",$team[1]['ids']).";',`team2`='".implode(";",$team[2]['ids']).";',`start`=".(time()+60).",`timeout`=2,`t1min`=".($tmin).",`t1max`=".$tmax.",`t2min`=".($tmin).",`t2max`=".$tmax.",`level`=6,`podan`='".date("H:i")."',`t1c`=".count($team[1]['ids']).",`t2c`=".count($team[2]['ids']).",`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`='{$nomagic}',`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='".get_str_align($team[1]['aligns'])."',`t2hist`='".get_str_align($team[2]['aligns'])."',`bcl`=0,`subtype`=0,`zcount`=0,`hz`=0;");
										echo "INSERT INTO `zayavka` SET `coment`='��� �����������',`type`=3,`team1`='".implode(";",$team[1]['ids']).";',`team2`='".implode(";",$team[2]['ids']).";',`start`=".(time()+60).",`timeout`=2,`t1min`=".($tmin).",`t1max`=".$tmax.",`t2min`=".($tmin).",`t2max`=".$tmax.",`level`=6,`podan`='".date("H:i")."',`t1c`=".count($team[1]['ids']).",`t2c`=".count($team[2]['ids']).",`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`='{$nomagic}',`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='".get_str_align($team[1]['aligns'])."',`t2hist`='".get_str_align($team[2]['aligns'])."',`bcl`=0,`subtype`=0,`zcount`=0,`hz`=0;";	
										
										if (mysql_affected_rows()>0)
											{
												$new_zay_id=mysql_insert_id();
												$all_owners=array_merge($team[1]['ids'], $team[2]['ids']);
												mysql_query("UPDATE zayavka_turn set zayid='{$new_zay_id}' where owner in (".implode(",",$all_owners).") ");
												echo "UPDATE zayavka_turn set zayid='{$new_zay_id}' where owner in (".implode(",",$all_owners).") ";
												//���������� ��������� ��� 
												$txt='<font color=red>��������!</font> ��� �������� ����������� �������� ����� 60 ���.';
												addch_group($txt,$all_owners);
											}


								break;	
								}
							}
					$fails++;
					}
					
				if ((count($aligns_array)==$fails) and ($t==1))
				{
				//������� ������ �������� � ��� � �� ������� �1
				//�2 ��� ������ ������
				break;				
				}
		}
		unset($old_align_key);
		
		
		
}


lockDestroy("cron_op_zayav_job");
?>