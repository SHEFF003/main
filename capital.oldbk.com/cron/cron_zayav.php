#!/usr/bin/php
<?php
ini_set('display_errors','On');
$CITY_NAME='capitalcity';
include "/www/".$CITY_NAME.".oldbk.com/cron/init.php";
if( !lockCreate("cron_zayav_job") ) {
    exit("Script already running.");
}

//V4.1
//���. �������: ��� ������ +- ���� ���� ������� �������� ������
//[18:25:00] Deni: ��� ������ ������������� - ������ ��������
/*
������ �� ������������� �������
����� ����� ����� ������ ������ � ��-�����. �������� ��� ��� � ������, � ���, ��� �����. ����� ���������� ����� �� 5 � �������� �����-�������� ����� � ������ �� ���� �������. ���� ��� ����� ���������� ��������, �� ��������� ��� � ������� ����������. ���� ��� ����� ������ 6, �� ������ ��� ����� �������� �� 6 �������.
���� ����� ���������� � � �������� �������� 5-7 ������� � 12-13. ����� ������ ���� ������ �� ������.
*/

$time = time();

//$nomagic=(date("i")%2); //  ����� ������ ������ ��� �����
$time_to_start=600; //  ����� ������� ����� ������
$zhide=4; // ����� ������� ������ ������ ������

$h=date("H");

echo "��� : $h <br>";

$zlevls=array(6,7,8,9,10,11,12,13,14); //13.5

function get_zcount($lmin,$lmax)
{
$get_zc=mysql_fetch_array(mysql_query("select  * from `oldbk`.`variables` WHERE `var`='zlvl{$lmin}_{$lmax}';"));
//echo "select  * from `oldbk`.`variables` WHERE `var`='zlvl{$lmin}_{$lmax}';" ;
//print_r($get_zc);
return $get_zc['value'];
}

function mk_zcount($lmin,$lmax,$r)
{
	if ($r==0)
	{
	mysql_query("UPDATE `oldbk`.`variables` SET `value`=0 WHERE `var`='zlvl{$lmin}_{$lmax}';");
	}
	else
	{
	mysql_query("UPDATE `oldbk`.`variables` SET `value`=`value`+{$r} WHERE `var`='zlvl{$lmin}_{$lmax}';");
	}
}

function get_max_users($lvl)
{

$onl = mysql_fetch_array(mysql_query("select  count(id) as kol from `users`  WHERE `level` in (".implode(",",$lvl).") and lab=0 and battle=0 and zayavka=0 and in_tower=0 and room<10000  and  `ldate` >= ".(time()-80)." ;"));

$online=$onl['kol'];
print_r($lvl);
echo "online= $online <br>\n";
$p=(int)($online/6);
if ($p%2) { $p-=1; }

if ($p<6) { $p=6; }

$h=date("H");
if (($h>=0) and ($h<=11))
	{
	//c 00 �� 11 ����  http://tickets.oldbk.com/issue/oldbk-2586
	if (($lvl[0]==14) and ($p<6) ) { $p=6; } // http://tickets.oldbk.com/issue/oldbk-2586
	}
	else
	{
	if (($lvl[0]==14) and ($p<8) ) { $p=8; } // http://tickets.oldbk.com/issue/oldbk-2586
	}





/*[11:01:16] ����� Ը�����: ������ �������� �������� ���������� ��� ������ 13 ������� ������� � 10 �� 6
*/
/*
if (($lvl[0]==13) and ($lvl[1]!=13) )
	{
	//� ���� �������  ��� 13 -13 ��. ������� ������������ ���������� ����� ������ �� ������ 10 ���
	if ($p<10) { $p=10; }
	}


$h=date("H");

	if (($h>=0) and ($h<=11))
	{
	//c 00 �� 11 ����  http://tickets.oldbk.com/issue/oldbk-1877
	//��������� ����� ������� ��� ��������� ������ ����� (�� 11 ����) ����������, �� �� ����� 6-��.
	$p=(int)($p*0.5);
	if ($p%2) { $p-=1; }
	if ($p<6) { $p=6; }
	}
*/
echo " mk pip= $p <br>\n";
return $p;
}


		foreach($zlevls as $k=>$lv)
		{
		echo "$lv <br>";
				//if ((!(($h>=11) and ($h<22))) and  ($lv==6) )
				if ($lv==6)
				{
				echo "��������� 5-7 <br> ";
				//5  �� 7
				$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".($lv-1)." and `t1max`=".($lv+1)." and `t2min`=".($lv-1)." and `t2max`=".($lv+1)." and `level`=5 and `coment`='<b>#zlevels</b>' "));
				}
				//elseif ((!(($h>=11) and ($h<22))) and  ($lv==7) )
				elseif ($lv==7)
				{
				echo "���������� 7� <br> ";
				continue; //����������
				}
				/*elseif ((!(($h>=11) and ($h<=23))) and  ($lv==12) )
				{
				//12  �� 13
				echo "��������� 12-13 <br> ";
				$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".($lv)." and `t1max`=".($lv+1)." and `t2min`=".($lv)." and `t2max`=".($lv+1)." and `level`=5 and `coment`='<b>#zlevels</b>' "));
				}*/
				elseif ($lv==13.5)
				{
				 //continue; //����������
				//12  �� 13
					$tlv=13;
					echo "��������� 13-14 <br> ";
					$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".($tlv)." and `t1max`=".($tlv+1)." and `t2min`=".($tlv)." and `t2max`=".($tlv+1)." and `level`=5 and `coment`='<b>#zlevels</b>' "));

				}
				else
				{
				echo "��������� ��������� <br> ";
				///��������� ����� ��� ������� ������ � 11.00 �� ������� �� 23.00 �� �������
				$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".$lv." and `t1max`=".($lv)." and `t2min`=".$lv." and `t2max`=".($lv)." and `level`=5 and `coment`='<b>#zlevels</b>' "));
				}
				/*
				1) ������� ����� ��������� �������� 5-7 ���������� � 22:00, �����-�� ��������� 5, 6 � 7 ��������� � ��� �� ����� � �� 11 ����
				2) ��� ���� ��������� �������� 12-13 ������ ���������� � 00:00, �����-�� ���������� 12 � 13 ����������� � ��� ����� � �� 11 ����
				*/




			if ($get_have_zay[id]>0)
				{
				//���� ��������� ������ �� ����������� ���
				}
				else
				{
				echo "��� ������ ���� ������� ";
						//if ((!(($h>=11) and ($h<22))) and  ($lv==6) )
						if ($lv==6)
							{
							echo "������� 5-6-7";

										$look=array();
										$look[]=($lv-1);
										$look[]=$lv;
										$look[]=($lv+1);
//										$maxu=get_max_users($look);
										$maxu=6; 	//http://tickets.oldbk.com/issue/oldbk-1027

										$zh=1;
										mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zlevels</b>',`type`=3,`team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".($lv-1).",`t1max`=".($lv+1).",`t2min`=".($lv-1).",`t2max`=".($lv+1).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`subtype`=0,`zcount`=0,`hz`=1;") ;


							}
						/*elseif ((!(($h>=11) and ($h<=23))) and  ($lv==12) )
							{
							echo "12-13 ";
										$look=array();
										$look[]=$lv;
										$look[]=($lv+1);
										$maxu=get_max_users($look);
										$zh=1;
										mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zlevels</b>',`type`=3,`team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".($lv).",`t1max`=".($lv+1).",`t2min`=".($lv).",`t2max`=".($lv+1).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`subtype`=0,`zcount`=0,`hz`=1;") ;
							}*/
						elseif ($lv==13.5)
							{
							$tlv=13;
							echo "13-14 ";
										$look=array();
										$look[]=$tlv;
										$look[]=($tlv+1);
										$maxu=get_max_users($look);

										$zh=1;
										mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zlevels</b>',`type`=3,`team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".($tlv).",`t1max`=".($tlv+1).",`t2min`=".($tlv).",`t2max`=".($tlv+1).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`subtype`=0,`zcount`=0,`hz`=1;") ;
							}
							else
							{
							echo " ���������";
										//��������� ��� ������
										$look=array();
										$look[]=$lv;
										$maxu=get_max_users($look);
										/*
										 if	(get_zcount($lv,$lv)>=$zhide)
										 	{
											mk_zcount($lv,$lv,0);
											$zh=1;
										 	}
										 	else
										 	{
											$zh=0;
											mk_zcount($lv,$lv,1);
										 	}
										*/
										$zh=0;
										mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zlevels</b>',`type`=3,`team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".$lv.",`t1max`=".($lv).",`t2min`=".$lv.",`t2max`=".($lv).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`subtype`=0,`zcount`=0,`hz`=1;") ;
							}
				}


		}
/*
$dayof=date("w");
$h=date("G");

//������ �� ������

 if ( ( (($dayof==0) or ($dayof==6))  and ($h>=14) and ($h<=18) )  OR       // � �������� ��� 14:00-18:00
      ( (($dayof>=1) and ($dayof<=5)) and ($h>=19) and ($h<=22) )  )  //     � ������ 19:00-22:00
      {
      // ��������� ��� �� ����� ������
			     $get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=1 and `t1max`=21 and `t2min`=1 and `t2max`=21 and `level`=5 and  `coment`='<b>������� ����������� ���!</b>' "));
			     if ($get_have_zay[id]>0)
				{
				//���� ��������� ������ �� ����������� ���
				}
				else
				{
				//���, ���� �������
				mysql_query("INSERT INTO `oldbk`.`zayavka` SET `coment`='<b>������� ����������� ���!</b>',`type`=3,`team1`='',`team2`='',`start`='".(time()+1800)."',`timeout`=3,`t1min`=1,`t1max`=21,`t2min`=1,`t2max`=21,`level`=5,`podan`='".date("H:i")."',`t1c`=50,`t2c`=50,`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=0,`subtype`=0,`zcount`=0,`hz`=1;") ;
				}
      }
      else
      {
      echo "��� �� ����� ��� ������";
      }

*/
echo "--------------------------------------\n";

require_once("/www/capitalcity.oldbk.com/config_ko.php");
			///���� ������ � ��������
			if (((time()>$KO_start_time22) and (time()<$KO_fin_time22)) OR ((time()>mktime(0,0,0,3,7,2018) ) and (time()<mktime(23,59,59,3,16,2018) )) )
			{
			echo "�������� �������� ����� \n <br>";
			foreach($zlevls as $k=>$lv)
					{
					echo "$lv <br>";
							if ($lv==6)
							{
							echo "��������� 5-7 <br> ";
							//5  �� 7
							$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".($lv-1)." and `t1max`=".($lv+1)." and `t2min`=".($lv-1)." and `t2max`=".($lv+1)." and `level`=5 and  subtype=2 and `coment`='<b>#zbuket</b>' "));
							}
							elseif ($lv==7)
							{
							echo "���������� 7� <br> ";
							continue; //����������
							}
							elseif ($lv==13.5)
							{
								$tlv=13;
								echo "��������� 13-14 <br> ";
								$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".($tlv)." and `t1max`=".($tlv+1)." and `t2min`=".($tlv)." and `t2max`=".($tlv+1)." and `level`=5 and  subtype=2 and `coment`='<b>#zbuket</b>'  "));
							}
							else
							{
							echo "��������� ��������� <br> ";
							$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".$lv." and `t1max`=".($lv)." and `t2min`=".$lv." and `t2max`=".($lv)." and `level`=5 and  subtype=2 and `coment`='<b>#zbuket</b>'  "));
							}


						if ($get_have_zay[id]>0)
							{
							//���� ��������� ������ �� ����������� ���
							}
							else
							{
							echo "��� ������ ���� ������� ";
									if ($lv==6)
										{
										echo "������� 5-6-7";

													$look=array();
													$look[]=($lv-1);
													$look[]=$lv;
													$look[]=($lv+1);
			//										$maxu=get_max_users($look);
													$maxu=6; 	//http://tickets.oldbk.com/issue/oldbk-1027

													$zh=1;
													mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zbuket</b>',`type`=3, `subtype`=2 , `team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".($lv-1).",`t1max`=".($lv+1).",`t2min`=".($lv-1).",`t2max`=".($lv+1).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`zcount`=0,`hz`=1;") ;



										}
									elseif ($lv==13.5)
										{
										$tlv=13;
										echo "13-14 ";
													$look=array();
													$look[]=$tlv;
													$look[]=($tlv+1);
													$maxu=get_max_users($look);

													$zh=1;
													mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zbuket</b>',`type`=3, `subtype`=2 , `team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".($tlv).",`t1max`=".($tlv+1).",`t2min`=".($tlv).",`t2max`=".($tlv+1).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`zcount`=0,`hz`=1;") ;
										}
										else
										{
										echo " ���������";
													//��������� ��� ������
													$look=array();
													$look[]=$lv;
													$maxu=get_max_users($look);
													$zh=0;
													mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zbuket</b>',`type`=3, `subtype`=2 , `team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".$lv.",`t1max`=".($lv).",`t2min`=".$lv.",`t2max`=".($lv).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`zcount`=0,`hz`=1;") ;
										}
							}


					}



			}
			else
			{
			echo "�� ����� �������� ���� \n";
			}
      ///���� ������ � ������
			if (    (time()>$KO_start_time19) and (time()<$KO_fin_time19) )
			{
			echo "�������� �������� ����� \n <br>";
			foreach($zlevls as $k=>$lv)
					{
					echo "$lv <br>";
							if ($lv==6)
							{
							echo "��������� 5-7 <br> ";
							//5  �� 7
							$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".($lv-1)." and `t1max`=".($lv+1)." and `t2min`=".($lv-1)." and `t2max`=".($lv+1)." and `level`=5 and  subtype=1 and `coment`='<b>#zelka</b>' "));
							}
							elseif ($lv==7)
							{
							echo "���������� 7� <br> ";
							continue; //����������
							}
							elseif ($lv==13.5)
							{
								$tlv=13;
								echo "��������� 13-14 <br> ";
								$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".($tlv)." and `t1max`=".($tlv+1)." and `t2min`=".($tlv)." and `t2max`=".($tlv+1)." and `level`=5 and  subtype=1 and `coment`='<b>#zelka</b>'  "));
							}
							else
							{
							echo "��������� ��������� <br> ";
							$get_have_zay=mysql_fetch_array(mysql_query("select * from zayavka where `type`=3 and `t1min`=".$lv." and `t1max`=".($lv)." and `t2min`=".$lv." and `t2max`=".($lv)." and `level`=5 and  subtype=1 and `coment`='<b>#zelka</b>'  "));
							}


						if ($get_have_zay[id]>0)
							{
							//���� ��������� ������ �� ����������� ���
							}
							else
							{
							echo "��� ������ ���� ������� ";
									if ($lv==6)
										{
										echo "������� 5-6-7";

													$look=array();
													$look[]=($lv-1);
													$look[]=$lv;
													$look[]=($lv+1);
			//										$maxu=get_max_users($look);
													$maxu=6; 	//http://tickets.oldbk.com/issue/oldbk-1027

													$zh=1;
													mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zelka</b>',`type`=3, `subtype`=1 , `team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".($lv-1).",`t1max`=".($lv+1).",`t2min`=".($lv-1).",`t2max`=".($lv+1).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`zcount`=0,`hz`=1;") ;



										}
									elseif ($lv==13.5)
										{
										$tlv=13;
										echo "13-14 ";
													$look=array();
													$look[]=$tlv;
													$look[]=($tlv+1);
													$maxu=get_max_users($look);

													$zh=1;
													mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zelka</b>',`type`=3, `subtype`=1 , `team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".($tlv).",`t1max`=".($tlv+1).",`t2min`=".($tlv).",`t2max`=".($tlv+1).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`zcount`=0,`hz`=1;") ;
										}
										else
										{
										echo " ���������";
													//��������� ��� ������
													$look=array();
													$look[]=$lv;
													$maxu=get_max_users($look);
													$zh=0;
													mysql_query("INSERT INTO `oldbk`.`zayavka` SET  `hide`='{$zh}' , `coment`='<b>#zelka</b>',`type`=3, `subtype`=1 , `team1`='',`team2`='',`start`='".(time()+$time_to_start)."',`timeout`=3,`t1min`=".$lv.",`t1max`=".($lv).",`t2min`=".$lv.",`t2max`=".($lv).",`level`=5,`podan`='".date("H:i")."',`t1c`={$maxu},`t2c`={$maxu},`stavka`=0,`blood`=0,`fond`=0,`price`=0,`nomagic`=0,`autoblow`=1,`am1`=0,`am2`=0,`ae1`=0,`ae2`=0,`t1hist`='',`t2hist`='',`bcl`=1,`zcount`=0,`hz`=1;") ;
										}
							}


					}



			}
			else
			{
			echo "�� ����� ���� ���� \n";
			}





lockDestroy("cron_zayav_job");
?>
