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
$output_attack_magic_dem=0;
$input_attack_magic_dem=0;
function log_deb_eff($text)
{
/*
	$fp = fopen ("/www/other/magpr.txt","a"); //��������
	flock ($fp,LOCK_EX); //���������� �����
	fputs($fp , $text."\n"); //������ � ������
	fflush ($fp); //�������� ��������� ������ � ������ � ����
	flock ($fp,LOCK_UN); //������ ����������
	fclose ($fp); //��������
*/
}

session_start();
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die; }
if (isset($_GET['login_target'])) { $_POST['login_target']=$_GET['login_target'];}

if (isset($_POST['target'])) $_POST['target'] = trim($_POST['target']);
if (isset($_POST['login_target'])) $_POST['login_target'] = trim($_POST['login_target']);
if (isset($_GET['login_target'])) $_GET['login_target'] = trim($_GET['login_target']);

// ���������� ������������
$lvlkof=0.01;
$EXP_TO_LOSE=0; //1- ��� / 0-����
$input_fix_cost_level=0;
$output_fix_cost_level=0;

//maxdur-��� �������
$maxdur[1002222]=1;
$maxdur[1002223]=1;
$maxdur[1002224]=2;
$maxdur[1002225]=5;
$maxdur[1002226]=10;

$mk_active_flag=false;
include "ny_events.php";

if(time()>$ny_events['ngloseexpstart'] && time()< $ny_events['ngloseexpend']) {
	$EXP_TO_LOSE=1;
}

if(time()>$ny_events['hbloseexpstart'] && time()< $ny_events['hbloseexpend']) {
	$EXP_TO_LOSE=1;
}



    $date=date("l", time());
    if($date=='Saturday' || $date=='Sunday')
    {
    	$EXP_TO_LOSE=1;
    }


$EXP_WIN=1; // 100%  ������� ����������
$attkof=0.1; // ��������� �� ���� �����
$attkritkof=0.1; // ��������� �� ���� ����� ��������
$kritblokkof=0.1; // ��������� �� ���� ����� �������� ����� ����

$kritkof=1.3; // ��������� �� ����
$uvorotkof=1.3; // �������� �� ����

$rabota_boni_vinos=true; // ������������� , true= �������� ��������� ����� �� ������� , false - �������� ��������� �� ��� ����

if ($rabota_boni_vinos==true)
	{
	$rabota_boni_delta=0.2; // ������
	}
	else
	{
	$rabota_boni_delta=0.5; // ������
	$rabota_boni=0.5; // ��������� �� ������ ����� ���� 0.3 - ����� 11/09/2011=0.315 , 5/18/2016 =0.515
	$rabota_boni_krit=0.5; // ��������� �� ������ ����� ��� �����
	$rabota_boni_krit_a=0.5; // ��������� �� ������ ����� ��� ����� ����� ����
	}





$min_uron=1; // ����������� ���� ���� 10
//1/10/2013
// new fsystem v.8 mana


    $_SESSION['ccc']=($_SESSION['ccc']?$_SESSION['ccc']:0);
    $_SESSION['cca']=($_SESSION['cca']?$_SESSION['cca']:0);

    	if($_POST['chng_sett']==1 && $_POST['autostart']>'0')
    	{
		$_SESSION['autostart']=1;  //��������� $_SESSION[auto_f] - � ������ ���������� ���������� ��� � �����
	}
	elseif($_POST['chng_sett']==1 && !$_POST['autostart'])
	{
		$_SESSION['autostart']=0;
	}

	$_SESSION['u1']=($_SESSION['u1']>='0'?$_SESSION['u1']:25);
	$_SESSION['u2']=($_SESSION['u2']>='0'?$_SESSION['u2']:25);
	$_SESSION['u3']=($_SESSION['u3']>='0'?$_SESSION['u3']:25);
	$_SESSION['u4']=($_SESSION['u4']>='0'?$_SESSION['u4']:25);

	if(($_SESSION['u1']+$_SESSION['u2']+$_SESSION['u3']+$_SESSION['u4'])!=100)
	{
		$_SESSION['u1']=25;
		$_SESSION['u2']=25;
		$_SESSION['u3']=25;
		$_SESSION['u4']=25;
	}
        if(($_SESSION['b1']+$_SESSION['b2']+$_SESSION['b3']+$_SESSION['b4'])!=100)
	{
		$_SESSION['b1']=25;
		$_SESSION['b2']=25;
		$_SESSION['b3']=25;
		$_SESSION['b4']=25;
	}
	$_SESSION['b1']=(!$_SESSION['b1']>='0'?$_SESSION['b1']:25);
	$_SESSION['b2']=(!$_SESSION['b2']>='0'?$_SESSION['b2']:25);
	$_SESSION['b3']=(!$_SESSION['b3']>='0'?$_SESSION['b3']:25);
	$_SESSION['b4']=(!$_SESSION['b4']>='0'?$_SESSION['b4']:25);



	if(($_POST['u1']+$_POST['u2']+$_POST['u3']+$_POST['u4'])==100)
	{
		$_SESSION['u1']=((int)$_POST['u1']>='0'?$_POST['u1']:25);
		$_SESSION['u2']=((int)$_POST['u2']>='0'?$_POST['u2']:25);
		$_SESSION['u3']=((int)$_POST['u3']>='0'?$_POST['u3']:25);
		$_SESSION['u4']=((int)$_POST['u4']>='0'?$_POST['u4']:25);
	}

	if(($_POST['b1']+$_POST['b2']+$_POST['b3']+$_POST['b4'])==100)
	{
		$_SESSION['b1']=((int)$_POST['b1']>='0'?$_POST['b1']:25);
		$_SESSION['b2']=((int)$_POST['b2']>='0'?$_POST['b2']:25);
		$_SESSION['b3']=((int)$_POST['b3']>='0'?$_POST['b3']:25);
		$_SESSION['b4']=((int)$_POST['b4']>='0'?$_POST['b4']:25);
    }


	if($_POST['marinad']>0)
	{
		$_SESSION['marinad']=((int)$_POST['marinad']>0?$_POST['marinad']:0);
		$_SESSION['nextattack']=$_SESSION['marinad']+time();
	}
        if($_POST['marinad']=='0')
	{
		$_SESSION['marinad']=0;
	}

    if($_POST['kickcount']>'0')
    {
    	$_SESSION['kickcount']=((int)$_POST['kickcount']>0?$_POST['kickcount']:0);
    	$_SESSION['kickcounter']=($_SESSION['kickcount']>0?$_SESSION['kickcount']:0);
    }
    if($_POST['kickcount']=='0')
    {
    	$_SESSION['kickcount']=0;
    	$_SESSION['kickcounter']=0;
    }


    if($_POST['hpstop']>'0')
    {
    	$_SESSION['hpstop']=((int)$_POST['hpstop']>0?$_POST['hpstop']:0);
	$_SESSION['temp_hpstop']=$_SESSION['hpstop'];
    }
    if($_POST['hpstop']=='0')
    {
    	$_SESSION['hpstop']=0;
    	$_SESSION['temp_hpstop']=$_SESSION['hpstop'];
    }


	$reloadpage=($_SESSION['marinad']>0?$_SESSION['marinad']:0);

  //  echo $_SESSION[kickcount] . ' '.$_SESSION[kickcounter];

	$matrix_a= array();
	$matrix_b= array();
     $xx='1';
     $xy='1';
     $persent_a=$_SESSION['u'.$xx];
     $persent_b=$_SESSION['b'.$xy];
	 for ($i=1;$i<=100;$i++)
	 {
	  if ($i <= $persent_a)
	   {
	      $matrix_a[$i]=$xx;
	   }
	   else
	   {
	     $xx++;
	     if($_SESSION['u'.$xx]>0)
	     {
	     	$persent_a+=$_SESSION['u'.$xx];
	     	$matrix_a[$i]=$xx;
	     }
	     else
	     {
	         $xx++;
		     if($_SESSION['u'.$xx]>0)
		     {
		     	$persent_a+=$_SESSION['u'.$xx];
		     	$matrix_a[$i]=$xx;
		     }
		     else
		     {
	             $xx++;
			     if($_SESSION['u'.$xx]>0)
			     {
			     	$persent_a+=$_SESSION['u'.$xx];
			     	$matrix_a[$i]=$xx;
			     }
		     }
	     }

	   }
	   if ($i <= $persent_b )
	   {
	      $matrix_b[$i]=$xy;
	   }
	   else
	   {
	     $xy++;
	     if($_SESSION['b'.$xy]>0)
	     {
	       $persent_b+=$_SESSION['b'.$xy];
	       $matrix_b[$i]=$xy;
	     }
	     else
	     {
              	 $xy++;
		     if($_SESSION['b'.$xy]>0)
		     {
		       $persent_b+=$_SESSION['b'.$xy];
		       $matrix_b[$i]=$xy;
		     }
		     else
		     {
                 if($_SESSION['b'.$xy]>0)
			     {
			       $persent_b+=$_SESSION['b'.$xy];
			       $matrix_b[$i]=$xy;
			     }
		     }
	     }
	   }
     }

    if($_SESSION['nextattack']<time())
	{
	   $_SESSION['nextattack']=time()+$reloadpage;
    }


	//print_r($matrix_a);

    shuffle($matrix_a);
    shuffle($matrix_b);

    $key=mt_rand(1,100);
    $a_attack=$matrix_a[$key];
    $a_block=$matrix_b[$key];

function countinteam($t) {
	$ret = 0;
	$t = explode(";",$t);
	while(list($k,$v) = each($t)) {
		if ($v < _BOTSEPARATOR_) {
			$ret++;
		}
	}
	return $ret;
}


//�������������� ������� �� ���� ����
function get_hil_bot($telo)
{
global $mob_hil;

$needh=(int)$mob_hil[$telo['id_user']];

$cure_value=180; //  ���������

	if ($telo['id_user'] == 12) $cure_value = 1000; //���� �����������
	if (($telo['id_user']==86) or ($telo['id_user']==87) or ($telo['id_user']==63) or ($telo['id_user']==89) ) 	{ 	$cure_value=1000;  }	//�������
	if (($telo['id_user']>=42) and ($telo['id_user']<=62)) 	{ 	$cure_value=360;  }	//�������
	if ($telo['id_user']==108)	{ 	$cure_value=360;  }	//��-11
	if ($telo['id_user']==109)	{ 	$cure_value=360;  }	//��-12
	if ($telo['id_user']==110)	{ 	$cure_value=360;  }	//��-13
	if ($telo['id_user']==101)	{ 	$cure_value=720;  }	//��-14
	if  ($telo['id_user']==190672)  {$cure_value = 1000; } // ������a
	if  ($telo['id_user']==9)  {$cure_value = 1000; } // �����
	if  ($telo['id_user']==10000)  {$cure_value = 1000; } // �����
	if (($telo['id_user']==190672) and ($telo['bot_online']!=2) ) {$needh=0; } // �� ����� ������ �������
	if (($telo['id_user']==10000) and ($telo['bot_online']!=2) ) {$needh=0; } // �� ����� ������ �������

if (( ($telo['hp']+($cure_value-1))<$telo['maxhp']) AND ($telo['hil']<$needh) )
	{

		if(($telo['hp'] + $cure_value) > $telo['maxhp'])
		{
			$hp = $telo['maxhp'];
		}
		else
		{
			$hp = $telo['hp'] + $cure_value;
		}
		if ((strpos($telo['login'],"��������� (����" ) !== FALSE )) {$telo['sex']=1;}

	mysql_query("UPDATE `users_clons` SET  `hil`=`hil`+1, `hp` = ".$hp." WHERE `id` = ".$telo['id']." and hp>0 ;");
	if (mysql_affected_rows()>0)
		{
		addlog($telo['battle'],"!:H:".time().':'.nick_new_in_battle($telo).":".(($telo['sex']*100)+1).":".(($telo['sex']*100)+1)."::::::".$cure_value.":[".($hp)."/".$telo['maxhp']."]\n");

		return $hp;
		}


	}

	return false;
}

//�������������� ������� ������ � ��� ����
function make_hil_battle($telo,$cure_value)
{
 if (($telo['hp']>0) and ($cure_value>0) and ($telo['hp'] < $telo['maxhp'] ) )
 	{

	 	if(($telo['hp'] + $cure_value) > $telo['maxhp'])
		{
			$hp = $telo['maxhp'];
			$add_hp=$telo['maxhp']-$telo['hp'];
		}
		else
		{
			$hp = $telo['hp'] + $cure_value;
			$add_hp=$cure_value;
		}
 		mysql_query("UPDATE `users` SET   `hp` = `hp` + '{$add_hp}'    WHERE `id` = '{$telo['id']}' and hp>0 ");
 		if (mysql_affected_rows()>0)
		{

		if (( $telo['hidden'] > 0 ) and ( $telo['hiddenlog'] =='' ) ) { $telo['sex']==1 ; }
		elseif (( $telo['hidden'] > 0 ) and ( $telo['hiddenlog'] !='' ) )
		{
		 $ftelo = load_perevopl($telo);
		 $telo['sex']=$ftelo['sex'];
		}

		if (($telo['hidden'] > 0) and ( $telo['hiddenlog'] =='' ))
		{
			addlog($telo['battle'],"!:H:".time().':'.nick_new_in_battle($telo).":".(($telo['sex']*100)+1).":".(($telo['sex']*100)+1)."::::::".$cure_value."|??:[??/??]\n");

		} else {
			addlog($telo['battle'],"!:H:".time().':'.nick_new_in_battle($telo).":".(($telo['sex']*100)+1).":".(($telo['sex']*100)+1)."::::::".$cure_value.":[".($hp)."/".$telo['maxhp']."]\n");
		}


		return $add_hp;
		}
		else
		{
	 	return false;
		}
 	}
 	else
 	{
 	return false;
 	}
return false;
}

function mk_vduh($u)
{
$telo=mysql_fetch_array(mysql_query("select * from users where id='{$u['id']}' ;"));
$send_mes=false;
	/*
	����� ������ �� ������, � ������� ������ ��������� ����� �� ���� �������� ����� � ��� ��������:
	�����! ����� "���������" ������ ���� �������, ������� �� ������ "���������" ���������.
	*/

	if (($telo['wcount']==1) or ($telo['wcount']==5) or ($telo['wcount']==10) )
	{
	//������ ������ ���

		$nn[1]='I';
		$nn[5]='II';
		$nn[10]='III';
		$nn=$nn[$telo['wcount']];
		$send_mes=true;
	}




			//��������� ���� �� ���
                        $get_bon=mysql_fetch_array(mysql_query("SELECT * from effects where owner='{$telo['id']}' and (type=1001 OR type=1002 OR type=1003 ) ;"));

                       	if ( ($telo['wcount']==5) and (!($get_bon[id]>0)) )
			{
			//��� ���� � ������� ���� 5
			// ������ ������ ���
			        //��� �������� ����
                        	//������ ������� ����
                        	mk_need_vduh($telo,1,0,0);
			}
                       	elseif ( ($telo['wcount']==10) and (!($get_bon[id]>0)) )
			{
			//��� ���� � ������� ���� 10

			        //��� �������� ����
                        	mk_need_vduh($telo,2,0,0);
			}
                       	elseif ( ($telo['wcount']==15) and (!($get_bon[id]>0)) )
			{
			//��� ���� � ������r 15
                        	mk_need_vduh($telo,3,0,0);
                        	//$wcounts="0";
				mysql_query("UPDATE users SET  `wcount`=0  where `id`='{$telo['id']}' ; ");
                        	$telo['wcount']=0;
			}
			elseif (($get_bon['type']==1001) and ($telo['wcount']==10)  )
                        {
	                        //���� ��� ������ ���
	                        //������ �� ������� ������ ���
                        	mk_need_vduh($telo,2,$get_bon['id'],$get_bon['add_info']);
			}
			elseif (($get_bon['type']==1001) and ($telo['wcount']==5)  )
                        {
	                  //���� ��� ������ ���
	                        //������ �� �������  ������� ������
                        	mk_need_vduh($telo,1,$get_bon['id'],$get_bon['add_info']);
			}
			elseif (($get_bon['type']==1002) and ($telo['wcount']==15)  )
                        {
                        //���� 2�
					//������ �� ������� -3� ���
                		       	mk_need_vduh($telo,3,$get_bon['id'],$get_bon['add_info']);
	                         	//$wcounts="0";
					mysql_query("UPDATE users SET  `wcount`=0  where `id`='{$telo['id']}' ; ");
	                        	$telo['wcount']=0;
			}
			elseif (($get_bon['type']==1002) and ($telo['wcount']==10)  )
                        {
                        //2� ����
                        	//��������� �����
                		 mk_need_vduh($telo,2,$get_bon['id'],$get_bon['add_info']);
			}
			elseif (($get_bon['type']==1003) and ($telo['wcount']==15)  )
                        {
                        //3� ����
                        	//��������� �����
                		 mk_need_vduh($telo,3,$get_bon['id'],$get_bon['add_info']);
                         	//$wcounts="0";
                       		mysql_query("UPDATE users SET  `wcount`=0  where `id`='{$telo['id']}' ; ");
                        	$telo['wcount']=0;
			}


if ($send_mes==true)

	{
        addchp ('<font color=red>��������!</font> � ��� ��������� ����� ������� ��������� ��� ��������� '.$nn.'�! ����������� �������� ����� ����� ������ �<a href="javascript:void(0)" onclick='.(!is_array($_SESSION['vk'])?"top.":"parent.").'cht("http://capitalcity.oldbk.com/main.php?edit=1&effects=1#quests")>���������</a>� ���������.','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);
        }
}


function mk_need_vduh($telo,$bo,$delid=0,$e=0)
{

$tlvl[7]['rand']=100;
$tlvl[7]['proto']=246; //	100% 	120 ��.����� ������ ��������������� 90HP�

$tlvl[8]['rand']=100;
$tlvl[8]['proto']=249;//	100% 	180 ��. ����� ������ ��������������� 180HP�

$tlvl[9]['rand']=70;
$tlvl[9]['proto']=249;//	70% 	180 ��. ����� ������ ��������������� 180HP�

$tlvl[10]['rand']=60;
$tlvl[10]['proto']=249;//	60% 	180 ��. ����� ������ ��������������� 180HP�

$tlvl[11]['rand']=50;
$tlvl[11]['proto']=200271; //11 ��. 	50% 	360 ��. ����� ������ ��������������� 360HP�

$tlvl[12]['rand']=40;
$tlvl[12]['proto']=200271; //12 ��. 	40% 	360 ��. ����� ������ ��������������� 360HP�

$tlvl[13]['rand']=10;
$tlvl[13]['proto']=200271; //13 ��. 	10% 	360 ��. ����� ������ ��������������� 360HP�

$tlvl[14]['rand']=10;
$tlvl[14]['proto']=200271; //13 ��. 	10% 	360 ��. ����� ������ ��������������� 360HP�


$trand=$tlvl[$telo['level']]['rand'];
$tproto=$tlvl[$telo['level']]['proto'];



				 				$boname[1]='�������� ��� ��������� I'; $boname[2]='�������� ��� ��������� II'; $boname[3]='�������� ��� ��������� III';
	                        				$botype[1]=1001;$botype[2]=1002;$botype[3]=1003;
	                          				$bons[4][1]=10;   $bons[4][2]=20;   $bons[4][3]=30;
       					                        $bons[5][1]=20;   $bons[5][2]=40;   $bons[5][3]=60;
	                          				$bons[6][1]=30;   $bons[6][2]=60;   $bons[6][3]=90;
       					                        $bons[7][1]=40;   $bons[7][2]=80;   $bons[7][3]=120;
								$bons[8][1]=60;   $bons[8][2]=120;  $bons[8][3]=180;
								$bons[9][1]=80;   $bons[9][2]=160;  $bons[9][3]=240;
								$bons[10][1]=100; $bons[10][2]=200; $bons[10][3]=300;
								$bons[11][1]=120; $bons[11][2]=240; $bons[11][3]=360;
								$bons[12][1]=140; $bons[12][2]=280; $bons[12][3]=420;
								$bons[13][1]=160; $bons[13][2]=320; $bons[13][3]=480;

								$bons[14][1]=160; $bons[14][2]=320; $bons[14][3]=480;

								$bons_val=$bons[$telo['level']][$bo];

								$adde[1]=0.05;$adde[2]=0.1;$adde[3]=0.15; // ���������� �����

								$timer=time()+14400;//4 ����



					if ($delid>0)
					{
						mysql_query("DELETE FROM effects where id='{$delid}'  "); // ������� ������ ����� - ��������� ������!
						if (mysql_affected_rows()>0)
							{
			                                 //1. ���� ������ �� ������- ������ �����
	        		                         $newhp=$telo['maxhp']-$telo['bpbonushp'];//maxhp ��� ������� ������
	                        		         $newhp=$newhp+$bons_val;// + ����� �����

	                        		         $new_exp=$telo['expbonus']-$e;//��������� ������ �����
	                        		         $new_exp=$new_exp+$adde[$bo];//�������� ����� ����� �� ����

	                        		         }
	                        			else
		   	                                 {
				                       	 $newhp=$telo['maxhp']+$bons_val;// + ����� �����
							 $new_exp=$telo['expbonus']+$adde[$bo];//�������� ����� ����� �� ����
   	                        		         }
   	                                 }
   	                                 else
   	                                 {
		                       	 $newhp=$telo['maxhp']+$bons_val;// + ����� �����
					 $new_exp=$telo['expbonus']+$adde[$bo];//�������� ����� ����� �� ����
   	                                 }

   	                                 //������ �����
	                                 mysql_query("INSERT INTO `effects` SET `type`='{$botype[$bo]}', `name`='{$boname[$bo]}',`time`='{$timer}',`owner`='{$telo['id']}',`lastup`='{$bons_val}', `add_info`='{$adde[$bo]}'  ;");

				         //���������� ��������
				         addchp ('<font color=red>��������!</font> ������� ��������� ������� <b>�'.$boname[$bo].'�</b>! ������� ������ +'.$bons_val.'HP,  +'.($adde[$bo]*100).'% �����','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);

					// ����� ����
			          	mysql_query("UPDATE users SET  `bpbonushp`='{$bons_val}' ,  `maxhp`='{$newhp}'  , `expbonus`='{$new_exp}'   where `id`='{$telo['id']}' ; ");

					if (mt_rand(1,100)<=$trand)
						{
							put_bonus_item($tproto,$telo,'�����');
							//����������
							mysql_query("INSERT INTO `oldbk`.`stats_drop_info` SET `owner`='{$telo['id']}',`lvl`='{$telo['level']}',`proto`='{$tproto}';");
						}

}


function check_fight_condition($need_list, $condition_list)
{
	try {
		$flag_response = false;
		foreach ($need_list as $fight_type) {
			if(isset($condition_list[$fight_type]) && $condition_list[$fight_type] === true) {
				$flag_response = true;
				break;
			}
		}

		return $flag_response;
	} catch (Exception $ex) {

	}

	return false;
}

function count_rep_lab($user,$real_enemy)
{
include 'repa_conf.php';
$aadd_rep=(int)($mob_rep[$real_enemy['id_user']]);
mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user['id']."', 'labkillrep', '".$aadd_rep."' ) ON DUPLICATE KEY UPDATE `val` =`val`+".$aadd_rep.";");
}
//	ini_set('display_errors','On');

	include 'connect.php';
	include 'fuc1.php';
	include 'functions.php';
	if ($user['room']==300)
		{
		include 'hill_config_300.php'; //��������� ��� ���.����� � ��� �����
		}
		else
		{
		include 'hill_config.php'; //��������� ��� ���.����� � ��� �����
		}
	include 'strings.php';

$QuestComponentList = array();
/**
 * @param \components\models\User $User
 * @return \components\Component\Quests\Quest
 */
function getQuestComponent($User)
{
	global $app, $QuestComponentList;

	if(!isset($QuestComponentList[$User->id])) {
		$QuestComponentList[$User->id] = $app->quest->setUser($User)->get();
	}

	return $QuestComponentList[$User->id];
}

function log_php_memory($position = 'end')
{
	return;
	global $user;
	if(isset($user) && isset($user['id']) && $user['id'] == 11718) {
		try {
			$memory_string = sprintf('%s fbattle. Pic: %sMB. Current: %sMB', $position, memory_get_peak_usage(true)/1024/1024, memory_get_usage(true)/1024/1024);
			\components\Helper\FileHelper::write($memory_string, 'memory_11718');
		} catch (Exception $ex) {

		}
	}
}

	if ($user['battle'] > 0 && ($user['in_tower'] == 15 || $user['in_tower'] == 2)) {
		$_SESSION['dtlastattack'] = time();
		$_SESSION['ruineslastattack'] = time();
	}


	if ($user['room']==44)
		{

		//header("Location: fbattle.php"); die;

		$FROM_BOTS=false; // ���������� �������� ������
		$NEW_TEST_BONUS=true;
		//�������� ������� = ��������� �������� ���������
		///load params
		$file_params= file ('params.txt');
		foreach ($file_params as $line_num => $line)
		   {
			 $par=explode("::",$line);
			 if (($par[0]!='') and ($par[1]!=''))
			 {
			 $PARAMS[$par[0]]=floatval($par[1]);
		 	}
		    }

		   print_r($PARAMS);
		   echo "<hr>";
		}
		else
		{
		include 'fsys_config.php';
		}




	if ($user['klan']=='radminion') {  echo "Admin-info:<!- GZipper_Stats -> <br>"; }


/*
if($user['id']==28453)
{
	print_r($_POST);
	echo '<br>';
	print_r($_SESSION);
	echo '<br>';
	echo $_SESSION['nextattack'] . ' ' .time() . ' ' .$nxt . ' count:' . $_SESSION[ccc] . ' countreloads:'.$_SESSION[cca];
}
*/
	//fix battle=1
//	if ( ($user['battle']==1) and ( ($user['room']==20) OR ($user['room']==21) or ($user['room']==26) or ($user['room']==50) or ($user['room']==66) ))
	if ($user['battle']==1)
		{
		  mysql_query("UPDATE `users` SET `battle`=0 where id='".$user['id']."' LIMIT 1;   ");
		  header("Location: main.php");
		  die;
		}

	if ($user['battle'] > 1 && $user['battle_t'] == 0 && $user['ruines'] > 0) {
		// ���� ��� ���� � battle_t = 0
		$q = mysql_query('SELECT * FROM battle WHERE id = '.$user['battle']);
		$b = mysql_fetch_assoc($q);
		if ($b !== FALSE) {
			$t1 = explode(";",$b['t1']);
			$t2 = explode(";",$b['t2']);
			$t3 = explode(";",$b['t3']);
			if (in_array($user['id'],$t1) !== FALSE) {
				$t = 1;
			} elseif (in_array($user['id'],$t2) !== FALSE) {
				$t = 2;
			} elseif (in_array($user['id'],$t3) !== FALSE) {
				$t = 3;
			}
			else {
				$t = mt_rand(1,3);
			}

			mysql_query('UPDATE users SET battle_t = '.$t.' WHERE id = '.$user['id']);
		}

		addchp('<font color=red>��������!</font> FIX ��� � battle_t = 0: '.$user['battle'].' ���: '.$user['login'],'{[]}�������{[]}',-1,0);
		addchp('<font color=red>��������!</font> FIX ��� � battle_t = 0: '.$user['battle'].' ���: '.$user['login'],'{[]}�������{[]}',-1,1);
		header("Location: fbattle.php");
		die;
	}

	if ($user['battle'] > 1 && $user['battle_t'] == 0 && $user['room'] >= 50000 && $user['room'] <= 53600 && $user['id_grup'] > 0) {
		// ���� ��� ��������
		$q = mysql_query('SELECT * FROM battle WHERE id = '.$user['battle']);
		$b = mysql_fetch_assoc($q);
		if ($b !== FALSE) {
			$t1 = explode(";",$b['t1']);
			$t2 = explode(";",$b['t2']);
			if (in_array($user['id'],$t1) !== FALSE) {
				$t = 1;
			} elseif (in_array($user['id'],$t2) !== FALSE) {
				$t = 2;
			} else {
				$t = mt_rand(1,2);
			}

			mysql_query('UPDATE users SET battle_t = '.$t.' WHERE id = '.$user['id']);
		}

		addchp('<font color=red>��������!</font> FIX ��� � battle_t = 0: '.$user['battle'].' � �������� ���: '.$user['login'],'{[]}�������{[]}');
		//addchp('<font color=red>��������!</font> FIX ��� � battle_t = 0: '.$user['battle'].' � �������� ���: '.$user['login'],'{[]}�������{[]}',-1,1);
		header("Location: fbattle.php");
		die;
	}

	if ($user['battle'] > 1 && $user['in_tower'] ==3)
	{
		// ���� ��� ���� � battle_t = 0
		$q = mysql_query('SELECT * FROM battle WHERE id = '.$user['battle']);
		$b = mysql_fetch_assoc($q);
		if ($b !== FALSE) {
			$t1 = explode(";",$b['t1']);
			$t2 = explode(";",$b['t2']);
			$t3 = explode(";",$b['t3']);
			if (in_array($user['id'],$t1) !== FALSE) {
				$t = 1;
			} elseif (in_array($user['id'],$t2) !== FALSE) {
				$t = 2;
			} elseif (in_array($user['id'],$t3) !== FALSE) {
				$t = 3;
			}
			else {
				$t = mt_rand(1,3);
			}

			if ($user['battle_t']!=$t)
			{
			mysql_query('UPDATE users SET battle_t = '.$t.' WHERE id = '.$user['id']);
			//addchp('<font color=red>��������!</font> FINFO ��� � battle_t = 0: '.$user['battle'].' ���: '.$user['login'],'{[]}Bred{[]}',-1,0);
			//addchp('<font color=red>��������!</font> FINFO ��� � battle_t = 0: '.$user['battle'].' ���: '.$user['login'],'{[]}bred{[]}',-1,1);
			header("Location: fbattle.php");
			die;
			}
		}


	}


	// bug fix
	if ($user['hp'] > $user['maxhp'])  { mysql_query("UPDATE `users` SET `hp`=`maxhp` where id='".$user['id']."' LIMIT 1;   "); }

	//����������� ���������� ��� - + ������ ������ ��� battle_fin
	if (($user['battle']>0) and ($user['last_battle']!=$user['battle']) )
	{
	if ($_SESSION['tsound']==1) { $do_sound="<object width=\"1\" height=\"1\"
codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\">
<param name=\"quality\" value=\"high\" /><param name=\"src\" value=\"/sound/startbat.swf\" />
<embed type=\"application/x-shockwave-flash\" width=\"1\" height=\"1\" src=\"/sound/startbat.swf\" quality=\"high\">
</embed>
</object>"; } else {$do_sound=''; }

		mysql_query("UPDATE `users` SET `last_battle`='{$user['battle']}' , `battle_fin`=1, `stamina`=0  , `change`=0  WHERE `id`='{$user['id']}' ; ");
		//������ � ������ �������� �� ���

		mysql_query("UPDATE  `users_bonus` set battle='{$user['battle']}'  where owner='{$user['id']}' ; ");



		// �� ����������� �� ��� ������� � ��������
		if (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290) or ($user['in_tower']>0) ))
		{
		//�� ���������
		mysql_query("UPDATE `effects` SET battle='{$user['battle']}'  where owner='{$user['id']}' AND type IN (791,792,793,794,795,556,557,302)");
		}

		$i_need_zerro_930_baf=true;//���� ������� � ��� ��� ���� ��������� 930 ��� � ��������
		/*if ($user['id']==14897)
		{
		echo "i_need_zerro_930_baf = true";
		}*/

		//��������� �������� �� ������
		if ($user['room']!=76)
		{
		ref_drop ($user['id']);
		}

		// ���������� ������ ��� � ������ ������� � ���� � ���
		mysql_query("UPDATE  oldbk.inventory set battle='{$user['battle']}' where  id IN (".GetDressedItems($user,DRESSED_ITEMS).") ; ");


		// ������ ��� � battle_runs_exp` ���� ��� ���� �� �������
		   $tbat=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user['battle']} ; "));
		 if (
				 		($tbat['type']!=30) AND //�� ��� � �����
				 		($tbat['type']!=312) AND
				 		($tbat['type']!=314) AND
				 		( $tbat['type']!=11) AND //�� �����
				 		( $tbat['type']!=10)  AND //�� ��
				 		( $tbat['type']!=22)  AND //�� ��������������
				 		( $tbat['type']!=1010)  AND //�� ��
				 		( $tbat['type']!=12)  AND //�� �����
				 		( $tbat['type']!=15) AND // �� ��� � �������� ������ ����� - ��������� ���
				 		(!($tbat['type']>=240 AND $tbat['type'] <=260)) // �� �������� ������ �����
				 	) //��� - ��� �� �������� - �� ������ ���
		{
		$rkm_bonus=0;
		$activ_stih_mag=mysql_fetch_array(mysql_query("select * from effects where owner='{$user['id']}' and  `type` in (150,930,920,130) "));
		//addchp ('<font color=red>fbattle.php</font> set to battle_runs_exp 1','{[]}Bred{[]}');
				if ($activ_stih_mag['id']>0)
				{
					//addchp ('<font color=red>fbattle.php</font> set to battle_runs_exp ','{[]}Bred{[]}');
					 if ($activ_stih_mag['type']==930) //'���� �����' - � ��� ������ �������� � �����
					 	{
					 	$tmpinf=explode(":",$activ_stih_mag['name']);
					 	$rkm_bonus=(int)($tmpinf[2]);
					 	}
					 	else
					 	{
					 	$tmpinf=explode(":",$activ_stih_mag['add_info']);
					 	$rkm_bonus=(int)($tmpinf[2]);
					 	}

					if ($rkm_bonus>0)
					{
					//���������� ���

						$runs=0; // ������� ���. ��� � ����� � ���
						if ($user['runa1']>0) $runs++;
						if ($user['runa2']>0) $runs++;
						if ($user['runa3']>0) $runs++;

						if ($runs>0)
						{
						//���� ���� ����!!
						mysql_query("INSERT INTO `oldbk`.`battle_runs_exp` SET `battle`='{$user[battle]}' ,`owner`='{$user['id']}', `runs`='{$runs}'  ,`rkm_bonus`='{$rkm_bonus}' ON DUPLICATE KEY UPDATE `rkm_bonus`='{$rkm_bonus}' ");
						}
					}
				}
		}

		//���������� ��� ��� �������� �  �������
		$mk_active_flag=true;

	//$_SESSION['usemagic_count']=0;
	$_SESSION['get_exp']=0;//����� ������ ����� � ������
        $_SESSION['auto_f']=0;
        if(!$_SESSION['hpstop'])
        {
        	$_SESSION['hpstop']=$_SESSION['temp_hpstop'];
        }

	if($_SESSION['autostart']==1 && ($_SESSION['hpstop']<$user['hp'] || $_SESSION['temp_hpstop']<$user['hp']))
	{
		$_SESSION['auto_f']=1;
	}

	$_SESSION['nextattack']=(time()+1);
        $_SESSION['kickcounter']=$_SESSION['kickcount'];
        $_SESSION['ccc']=0;
        $_SESSION['cca']=0;
        $_SESSION['was_target']=0;//����� ������ ����
	}
						if(($_SESSION['nextattack']-(time()+1))<=0)
						{
							$nxt='700';
						}
						elseif(($_SESSION['nextattack']-(time()+1))>0 && $_SESSION['marinad']>0)
						{
							$nxt=($_SESSION['nextattack']-time()).'000';
						}
                        else
                        {
                        	$nxt='1000';
                        }


	//�������� �� ��������� �� ����
	if (($_POST['end'])and($user['lab']==1))   header("Location: lab.php");
	if (($_POST['end'])and($user['lab']==2))  header("Location: lab2.php");
	if (($_POST['end'])and($user['lab']==3))  header("Location: lab3.php");

	//if ($_POST['end'] != null)  header("Location: main.php");


	/// ���� �� ���� ����� ����� ��� ���
	// $redis = new Redis();
	//$redis->connect('redissrv', 6379);

////////////////////////
//// LOAD quest items if need
			       if ($_SESSION['quest']=='') // ���� ���������� ������ ������������ �� ����
     				{
     				if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com') { $cityname='capitalcity' ;  }
    				else if ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com') { $cityname='avaloncity' ;  }
 				else if ($_SERVER["SERVER_NAME"]=='angelscity.oldbk.com') { $cityname='angelscity' ;  }
    				else {$cityname='noname' ; }
     				$qu=mysql_fetch_array(mysql_query("select * from users_quest where owner='{$user['id']}' and status=0 and city='{$cityname}' ;"));
     				}
///-----------------------------------------------------------------
		 	//////////////
		 	 if   (($qu['id'] >0) OR ($_SESSION['quest']=='ihave')) // ���� � ���� ���� ��� �������� ��� ����� ����
		      {
 	 		      $_SESSION['quest']='ihave';
		  			      if (($qu['id'] >0)OR($_SESSION['questid']=='')) // ���� � ������ ��� ������ ������ �� ������������
		     		        	{
						$_SESSION['questid']=$qu['quest_id']; //����������
						$_SESSION['questdata']=mysql_fetch_array(mysql_query("select * from quests where id='{$_SESSION['questid']}' ;"));
    						//echo "sql2- read<br>";
		 				 }
		       		 if ($_SESSION['questdata']['id'] > 0) // ���������� ������ ���� ������
	       			  {
			                   //���������� ����� ����
			                   include('./quests/quest'.$_SESSION['questdata']['id'].'.php');
			     		   $fmap='/www/capitalcity.oldbk.com/labmapsq/'.$mapid.'-'.$user['id'].'.qst'; //�������� ������ ������
						   if (file_exists($fmap))
					           {
						   //���� ���� ��������� �� ���� ������ - �.�.
						   $qdata_array = file($fmap);
								foreach($qdata_array as $qi=>$qstring)
							                        {
							                        $qmas=explode("::","$qstring");
							                        $Qmap[$qmas[0]][$qmas[1]]=(int)$qmas[2];
							                        $map[$qmas[0]][$qmas[1]]='Q'; // ����������� � ����� ���� ����� ����������� ������
										}

						   } else
						   {
						   // ��� ���� ���� �� ������ �.�. �� ������� :) ���� �� ��������� ����� -������ ����� ���� ������ ���� � ����� ��� �� ������ ���� ����
						    //echo "The file $fmap does not exist";
						    //����� �������� ��� ���� ��������� �����
						    //make_qstart($_SESSION['questdata'],$user,$mapid) ;
						   }
					  }
		      }
		      else
		      {
		      $_SESSION['quest']='none';
      		      //echo "none<br>";
      		      //��� ������ � �������� ���������� ��� ��� ������ � ������ �� ���� ������ �� �����
		      }
///////////////////


/////////functions ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
include "fsystem.php";
///end functions////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$vinst_arr[0]=1;$vinst_arr[1]=1;$vinst_arr[2]=1;$vinst_arr[3]=1;$vinst_arr[4]=1;$vinst_arr[5]=1;$vinst_arr[6]=1;$vinst_arr[7]=1;
$vinst_arr[8]=0.88;$vinst_arr[9]=0.83;$vinst_arr[10]=0.5;$vinst_arr[11]=0.29;$vinst_arr[12]=0.17;$vinst_arr[13]=0.13;$vinst_arr[14]=0.13;


	//��������� �������. ���� �������� ������� ������, ��� ���� ���� �� ������ ������ ��� �������
   // print_r($_POST);

    if(($_SESSION['auto_f']==1 && $_SESSION['kickcount']>0 && $_SESSION['kickcounter']==0) || ($_SESSION['hpstop']>=$user['hp'] && $_SESSION['hpstop']!=0))
    {
    		$_SESSION['auto_f']=0;
    		$_SESSION['temp_hpstop']=$_SESSION['hpstop'];
    		unset($_SESSION['hpstop']);
        	unset($_POST['attack']);
        	unset($_POST['attack2']);
		unset($_POST['defend']);
		unset($_POST['enemy']);
		unset($_POST['batl']);

    }

	if ( ($_POST['attack']) AND ($_POST['defend']) AND ($_POST['enemy']) AND (!$_POST['myid']) AND ($_POST['batl']) )
	 {
 	//���� ���������� $_POST[myid] �� ������ ���������� ��������� = �.�. ������ ����� �������� ���
		unset($_POST['attack']);
		unset($_POST['attack2']);
		unset($_POST['defend']);
		unset($_POST['enemy']);
		unset($_POST['batl']);
	 }
	 else
	 if ( ($_POST['attack']) AND ($_POST['defend']) AND ($_POST['enemy']) AND ($_POST['myid']) AND ($_POST['batl']) )
	 {
	 	if (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290) or ($user['in_tower']>0) and ($user['lab']>0 ) ) )
		{
		//�� ���������
		$dda=1;
		}
		else
		{
		$dda=1;
		}
	  if	( (  ((int)($_POST['myid'])) < time() ) AND (((int)($_POST['myid'])) > 1 )  AND  (((int)($_POST['myid'])) > $_SESSION['fbtime']+$dda )  )
	//// ���� ������ ������� �� ����������� ��������� ������ ($_POST[myid]) ���� ������
	// � �� ����� �� ��������� �.�. ������ ��� ������� ���� � �� � ������ ���� ������

	      {
//	      addchp ('<font color=red>��������!</font> GOOOD ','{[]}Bred{[]}');
       	      	$_SESSION['fbtime']=(int)($_POST['myid']); //���������� ��� ���������� ����
       	      	$_SESSION['kickcounter'] -= 1;
       	      	$_SESSION['nextattack']=time()+$reloadpage;
       	      	$nxt=$reloadpage.'000';
       	      	$_SESSION['ccc']+=1;
       	      	$_SESSION['cca']+=1;
	      }
	      else
	      {
	      //����
      	   //   addchp ('<font color=red>��������!</font> Fuck ','{[]}Bred{[]}');
      	   	   $_SESSION['nextattack']=time()+$reloadpage;
       	       $nxt=$reloadpage.'000';
       	       $_SESSION['cca']+=1;
	      	   unset($_POST);//������� ���� ������ �����
	      }
	 }
/////////////////////////////////////////////////////////////////////////////////////////////
// ������ �� �������� � ���� ������


 if (($_POST['enemy']) AND ($_SESSION['mem_enemy']) )
	{
		if ($_SESSION['mem_enemy']!=$_POST['enemy'])
		{
		//��������� ������ - ���� ������ ����� ������� �� ��� ������� �� ������
		unset($_POST['enemy']);
		}
	}
unset($_SESSION['mem_enemy']);
//////////////////////////////////////////////////////////////////////////////////////////
	/*
	if($_GET['ch_auto']=='1' || $_GET['ch_auto']=='0')
	{
		//echo 'HERE' . $_GET[ch_auto];
		mysql_query('update users set autofight = '.($_GET['ch_auto']==1?'1':'0').' WHERE id = '.$_SESSION['uid'].';' );

		$user['autofight']=$_GET['ch_auto'];
	}
	*/
	$user['autofight']=0;
   //  print_r($_GET);

	if($_GET['ch_auto_a']=='1' || $_GET['ch_auto_a']=='0')
	{
		$_SESSION['auto_f']=$_GET['ch_auto_a'];
		$_SESSION['kickcounter']=$_SESSION['kickcount'];

		if(!$_SESSION['hpstop'] && $_SESSION['temp_hpstop']>0 && $user['hp']>$_SESSION['temp_hpstop'])
		{
			$_SESSION['hpstop']=$_SESSION['temp_hpstop'];
		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// �������� ���
	if ( (($user['battle'] > 0) AND ($user['battle']==$user['last_battle']) ) OR (($user['battle'] > 0) AND ($user['battle_fin'] ==0) )  ) // ����  ������ if ($user['battle'] > 0)
	 {
	 //fix flag
	   if ($user['battle_fin']!=1)
	   		{
	   		mysql_query("UPDATE `users` SET `battle_fin`=1 WHERE `id`='{$user['id']}' ; ");
	   		}
           // ��� ���� ���� ����� � ��� ������ ��� ����
	   $data_battle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user['battle']} ; "));
	   //
	   if ($data_battle['win']==3)
	   {
	   // ��� ��� ��� ����
	   $battle_ok=true; // ���� ����� ������
	   				if ($mk_active_flag==true)
	   					{
	   					//������ 1 ���� ��� ������
											if ( ($user['ruines']==0)  AND  ($user['lab']==0) AND ($user['in_tower']==0) AND ($data_battle['type']!=15) AND (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290)))   )
												     {
												     mysql_query(" INSERT INTO `oldbk`.`active_battle` SET `owner`='{$user['id']}',`bdate`= NOW() ,`val`=1 ON DUPLICATE KEY UPDATE val=val+1");
												     }

	   					}
	   }
	   else
	   {
	   /// ��� ��� ��������  �� ��� �� �������� ���� � �� �������� ���� �� ���
	   $battle_ok=false; // �� ���� ������ �������� ���
	   }

	 } ///
	 else
	 { 	  	//���� �� ���� ��������� ������ ���� 20 (��� �� ��������� ���) � ���� �����.


	  if ($user['battle_fin']==1)
	    {

			log_php_memory('final display');
	    	// ��������� �����

		    if(!$_SESSION['beginer_quest']['none'])
	     	{
	 		    $last_q=check_last_quest(20);
	 		}
	 		if (($user['id']==14897) OR ($user['id']==188) )
	 		{
		 		print_r($last_q);
		 	}
	 	//	echo '<br>';
	    	// ��������� ��������� ��� ����
	      	 $data_battle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user['last_battle']} ; "));
		 if ($data_battle['id'] >0)
		 {
	      	 //�������� ������ � ����� ������� ��� ��� �.�. ������ ������� ����� ��� ����������
			$tt1 = explode(";",$data_battle['t1']);
			$tt2 = explode(";",$data_battle['t2']);
			$tt3 = explode(";",$data_battle['t3']);
			if (in_array($user['id'],$tt1) !== FALSE)
			{
				$user['battle_t'] = 1;
			} elseif (in_array($user['id'],$tt2) !== FALSE)
			{
				$user['battle_t'] = 2;
			} elseif (in_array($user['id'],$tt3) !== FALSE)
			{
				$user['battle_t'] = 3;
			}
	     	 // ���� - ���� - �������� � ��� � ������
		      	 if (($data_battle['type']==61) OR ($data_battle['type']==60) OR ($data_battle['type']==62) )
		         {
		             $get_bit=mysql_fetch_array(mysql_query("SELECT count(*) FROM bonus_items where owner={$user['id']} and flag=1 and battle='".$data_battle['id']."' ; "));
		             if ($get_bit[0] > 0)
		             {
		    	     	addchp ('<font color=red>��������!</font> � ��� ���� ����� <i>"����������� ����� -50%"</i> �� '.$get_bit[0].' �����. ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
		             }
		         }

				if($data_battle['coment']=='��� � �������� �����' || $data_battle['coment']=='<b>��� � ����� �������</b>')
	                	{

	                	//��� ��������� ��
					mysql_query("INSERT INTO oldbk.users_progress set owner='{$user['id']}', abattlehaos=1 ON DUPLICATE KEY UPDATE abattlehaos=abattlehaos+1");
				}


	       //������ ����� � �����


                if($data_battle['type'] == 8) {
			// �� ������� � ��� ��� +1 � �������
			mysql_query('UPDATE users SET buketbat = buketbat + 1 WHERE id = '.$user['id']);
			if (true) {
				$medals = array(
					250 => array(
						"link" => "http://i.oldbk.com/i/icon_flowers250.png",
						"repmoney" => "2500",
						"stage" => 0,
					),
					750 => array(
						"link" => "http://i.oldbk.com/i/icon_flowers750.png",
						"repmoney" => "7500",
						"stage" => 1,
					),
					1500 => array(
						"link" => "http://i.oldbk.com/i/icon_flowers1500.png",
						"repmoney" => "15000",
						"stage" => 2,
					),
				);

				/** @var \components\models\UserBadge $Badge */
				$Badge = \components\models\UserBadge::whereRaw('user_id = ? and rate_unique = ?', [$user['id'], \components\models\UserBadge::TYPE_BUKET])->first();
				if ($Badge) {
					$Badge = $Badge->toArray();
				}
				while(list($k,$v) = each($medals)) {
					if ($user['buketbat'] >= $k) {
						// ���������� ������
						if ($Badge) {
							// ���� ��������
							if ($v['stage'] <= $Badge['stage']) {
								// �� ������ �� ������� �����
								continue;
							} else {
								// ������� ��������
        							$ended = new \DateTime();
        							$ended->modify('+365 day');
							        $_data = array(
								            'img'               => $v['link'],
								            'description'       => $k." ��� �� �������",
								            'alt'               => $k." ��� �� �������",
							        	    'show_ended_at'     => $ended->getTimestamp(),
						            		    'rate_unique'       => \components\models\UserBadge::TYPE_BUKET,
							    		    'stage'		=> $v['stage'],
							        );

        							\components\models\UserBadge::find($Badge['id'])->update($_data);
							}
						} else {
							// ������ �������� - ���� ������ ������ � �����
						        $ended = new \DateTime();
						        $ended->modify('+365 day');

						        $_data = array(
						            'user_id'           => $user['id'],
						            'img'               => $v['link'],
						            'description'       => $k." ��� �� �������",
						            'alt'               => $k." ��� �� �������",
						            'created_at'        => time(),
						            'is_enabled'        => 1,
						            'show_time'         => 1,
						            'show_started_at'   => time(),
						            'show_ended_at'     => $ended->getTimestamp(),
						            'rate_unique'       => \components\models\UserBadge::TYPE_BUKET,
							    'stage'		=> $v['stage'],
						        );

						        \components\models\UserBadge::insert($_data);
						}

						$User = new \components\models\User($user);
						$GiveRep = new \components\Helper\item\ItemRep($User, $v['repmoney']);
						if($GiveRep->give()) {
							$_data = array(
								'target_login'          => '�����',
								'type'                  => \components\models\NewDelo::TYPE_QUEST_REWARD_REP,
						                'add_info'              => '��� �� �������',
							);

							if($GiveRep->newDeloGive($_data)) {
								// ��������
								\components\models\Chat::addToChatSystem("�� �������� <b>".$v['repmoney']." ���������</b> �� ���������� <b>�".$k." ��� �� ��������</b>.",$user);
							}
						}

						break;
					}
				}
			}
		}


	       $damexp=get_damexp($user['last_battle'], $user['id']);
	       //����� ������ �� ������, ��� ���  ���� ��� ����� � ������ ����
          	$get_var=mysql_fetch_array(mysql_query("SELECT * from battle_vars where owner='{$user['id']}' and battle='{$data_battle['id']}' ;"));

                   	//������� ������ ��� ��������
                    	if ( ($get_var['napal']==0) and ($data_battle['CHAOS']>0) and ($data_battle['type']!=5) and ($data_battle['type']!=4) and ($data_battle['type']!=22)  and ($data_battle['type']!=308) and ($data_battle['type']!=304) and ($data_battle['type']!=311) and ($data_battle['type']!=312) and ($data_battle['type']!=313) and ($data_battle['type']!=314)  and ($damexp['damage']>0 && $data_battle['coment'] != '��� � �������� �����'  && $user['level']>3) )
                    	{
				$cancel_count=false;


				if ($data_battle['win']==$user['battle_t'])
				{
				//������ ������
				$sql = 'UPDATE oldbk.map_var SET val = val + 1 WHERE owner = '.$user['id'].' AND var = "q32s41"';
				$q = mysql_query($sql);
					if (mysql_affected_rows() > 0)
					{
					//$cancel_count=true;
					}
				}


				if ($cancel_count==false)
				{
	                    		mysql_query("INSERT INTO `oldbk`.`ristalka` SET `owner`={$user['id']},`chaos`=1 ON DUPLICATE KEY UPDATE chaos=chaos+1");
				}
                    	}

			//������� ������ c  �������
                    	if ( $get_var['napal']==0 and $data_battle['type']==8   and $damexp['damage']>0 )
                    		{
                    		/*
					�������� �������� ���� ������.
					���� �� � ����� � ������� 1 ���� (�������) �� ������������� ����� ����� 1 �������
					���� �� � ����� � ������� 2 ���� (�������), �� ������������� ����� ����� 3 �������.
					������������� ������ ��� ��������� ������ 1 �����.
                    		*/

				//���� �����-�����
				$get_buket=mysql_fetch_array(mysql_query("select id, name, prototype from oldbk.inventory where owner='{$user['id']}' and type=3 and naem=0 and battle='{$data_battle['id']}' "));
				if (($get_buket['prototype'] >410000 ) and ($get_buket['prototype'] < 410015 ) )
					{
					//�������
					$add_buket_count=1;
					}
				elseif (($get_buket['prototype'] >410020 ) and ($get_buket['prototype'] < 410031 ) )
					{
					//������� 410027 - 410028
					$add_buket_count=3;
					}
				else
					{
					$add_buket_count=0;
					}

				         if ($add_buket_count>0)
				         	{
			         		//������� ������� ����
			         		$get_buket_battle=mysql_fetch_array(mysql_query("select * from oldbk.battle_buket where owner='{$user['id']}' "));

					/*
					������ 21 ������� ������, � ��������� ������ ��������, ������� ���������� "�������� �� ������ �������".
						�������� �� �������� ��������� (������ �����).
					*/

					if (($get_buket_battle['bcount']+$add_buket_count)<21 )
				         		{
					         	//���������
			                    		mysql_query("INSERT INTO `oldbk`.`battle_buket` SET `owner`={$user['id']},`bcount`='{$add_buket_count}' ON DUPLICATE KEY UPDATE bcount=bcount+'{$add_buket_count}' ");
			                    		}
			                 else
							{
			                    		//��������
			                    		$add_buket_count=$get_buket_battle['bcount']+$add_buket_count-21;
			                    		mysql_query("UPDATE `oldbk`.`battle_buket` SET `bcount`='{$add_buket_count}'  WHERE `owner`={$user['id']}");
				            		//�������� �����

				            				 // ���� ������� ��� �����
				     	      	            $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`shop` WHERE `id` = '411000' LIMIT 1;")); //�������� �� ������ �������

								if ($dress['id']>0)
											{

											$dress['dategoden']=mktime(23,59,59,8,31,date("Y"));
											$dress['goden']=round(($dress['dategoden']-time())/60/60/24);
											$dress['img']="item_treelenta".mt_rand(1,8).".gif";
											$dress['present']='�����';

											if (mysql_query("INSERT INTO oldbk.`inventory`
											(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`img_big`,`maxdur`,`isrep`,
												`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
												`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`letter`
											)
											VALUES
											('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}','{$dress['img_big']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
											'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$dress['present']}','{$dress['labonly']}','0','{$dress['group']}','{$user['id_city']}','{$user['letter']}'
											) ;") )
										     {
										     		$dress['id']=mysql_insert_id();
										     		$dress['idcity']=$user['id_city'];
										     		//new delo
												$rec['owner']=$user['id']; $rec['owner_login']=$user['login'];
												$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];
												$rec['target']=0;$rec['target_login']='���';
												$rec['type']=60;//������� � ���
												$rec['sum_kr']=0; $rec['sum_ekr']=0;
												$rec['sum_kom']=0; $rec['item_id']=get_item_fid($dress);
												$rec['item_name']=$dress['name'];
												$rec['item_count']=1;
												$rec['item_type']=$dress['type'];
												$rec['item_cost']=$dress['cost'];
												$rec['item_dur']=$dress['duration'];
												$rec['item_maxdur']=$dress['maxdur'];
												$rec['item_ups']=0;
												$rec['item_unic']=0;
												$rec['item_incmagic']='';
												$rec['item_incmagic_count']='';
												$rec['item_arsenal']='';
												$rec['battle']=$data_battle['id'];
												add_to_new_delo($rec);
										   		addchp ('<font color=red>��������!</font> �� �������� � ��� <b>'.link_for_item($dress).'</b> ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);

												 try {
													 $User = new \components\models\User($user);
													 $QuestComponent = getQuestComponent($User);

													 $Checker = new \components\Component\Quests\check\CheckerDrop();
													 $Checker->item_id = 411000;
													 $Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
													 if (($Item = $QuestComponent->isNeed($Checker)) !== false) {
														 $QuestComponent->taskUp($Item);
													 }
													 unset($Checker);
													 unset($User);
												 } catch (Exception $ex) {
													 \components\Helper\FileHelper::writeException($ex, 'fbattle_drop_lenta');
												 }

				            						}
				            						}

				            		}



		                    		}



                    		}


	if (true)
		{
		//�������������� ���� � �������� �����
		$tts='';
		if ($data_battle['type'] == 311)
			{
			// ������� ����� (��� ������): ������ ��������
				if ($data_battle['win']==$user['battle_t'])
					{
					//��� ������
					put_bonus_item(2017001, $user, '�����');
					$tts='win';
					}
					else
					{
					$tts='lose';
					}
			}
		elseif ($data_battle['type'] == 312)
			{
					if ($data_battle['win']==$user['battle_t'])
					{
					//� �������� (��� ������): �������� �����
					put_bonus_item(2017002, $user, '�����');
					$tts='win';
					}
					else
					{
					$tts='lose';
					}
			}
		elseif ($data_battle['type'] == 313)
			{
			//� ������������: ���������� ������
					if ($data_battle['win']==$user['battle_t'])
					{
					put_bonus_item(2017003, $user, '�����');
					$tts='win';
					}
					else
					{
					$tts='lose';
					}
			}
		elseif ($data_battle['type'] == 314)
			{
					if ($data_battle['win']==$user['battle_t'])
					{
					//� ���� � ���. ������ ���� �� ������
					$tts='win';
					}
					else
					{
					$tts='lose';
					}
			}

		if ($tts!='')
			{
			mysql_query("INSERT `get_lock_bots_stats` (`owner`,`bt".$data_battle['type']."_".$tts."`) values('".$user['id']."', 1) ON DUPLICATE KEY UPDATE `bt".$data_battle['type']."_".$tts."` =`bt".$data_battle['type']."_".$tts."`+1;");
			}

		}

		if ($data_battle['coment'] == '<b>#zlevels</b>' && $damexp['damage'] > 0) {
		 	require_once('config_ko.php');

				if (get_chance(80))
				{
				if ((time()>$KO_start_time47) and (time()<$KO_fin_time47))
					{
					$prival_end = $KO_fin_time47;
					if ($prival_end >= time()) {
						$prival_goden = round(($prival_end-time())/60/60/24);
						if ($prival_goden<1) {$prival_goden=1;}
					  	put_bonus_item(590, $user, '�����',array(),array('goden' => $prival_goden, 'dategoden' => $prival_end));
					}
					}
				}

				//��������: ��������� �����������
				if ( ((time()>$KO_start_time18) and (time()<$KO_fin_time18)) and ($data_battle['win']==$user['battle_t'])	)
					{
						if (get_chance(75))
						{
							$protorh=array(405001,405002,405003,405004);
							shuffle($protorh);
							$protoid=$protorh[0];

							$prival_end = $KO_fin_time18;
							if ($prival_end >= time()) {
								$prival_goden = round(($prival_end-time())/60/60/24);
								if ($prival_goden<1) {$prival_goden=1;}
							  	put_bonus_item($protoid, $user, '�����',array(),array('goden' => $prival_goden, 'dategoden' => $prival_end));
								}
						}

					}

				// ��������� � ���� ������-���������� � ������ 50%, ���������� �� ������/���������    ������� �������� �1  � �������� �� �����
				if (get_chance(50))
				{
					if ((time()>$KO_start_time53) and (time()<$KO_fin_time53))
						{
						  	put_bonus_item(2018412, $user, '�����');
						}

				}


	     	}
	     	elseif ((($data_battle['coment'] == '��� � �������� �����') OR ($data_battle['type'] == 311)  OR ($data_battle['coment'] == '<b>����-����</b>') OR ($data_battle['type'] == 313)   OR ($data_battle['coment'] == '��� � ������ ������������') OR ($data_battle['type'] == 312))  and ($damexp['damage']>0)) {
		 	require_once('config_ko.php');
			$prival_end = $KO_fin_time47;
			if ((time()>$KO_start_time47) and (time()<$KO_fin_time47))
			{
			if ($prival_end >= time()) {
				$prival_goden = round(($prival_end-time())/60/60/24);
				if ($prival_goden<1) {$$prival_goden=1;}
			  	put_bonus_item(591, $user, '�����',array(),array('goden' => $prival_goden, 'dategoden' => $prival_end));
			}
			}

			if ($data_battle['coment'] == '<b>����-����</b>')
			{

				// ��������� � ���� ����-���� (�����������) � ������ 100%, ���������� �� ������/���������     ������� �������� �2  � �������� �� �����
				if ((time()>$KO_start_time53) and (time()<$KO_fin_time53))
						{
						  	put_bonus_item(2018413, $user, '�����');
						}

			}

		}


		if ($data_battle['coment'] == '<b>��� � ������� ��������</b>' && $damexp['damage'] > 0 && ($data_battle['win']==$user['battle_t']) )
			{
				require_once('config_ko.php');
				// ��������� � ���� � ��������� � ������ 100%, ������� ������ ������� �������� �3  � �������� �� �����
				if ((time()>$KO_start_time53) and (time()<$KO_fin_time53))
						{
						  	put_bonus_item(2018414, $user, '�����');
						}

			}
		/*elseif ($data_battle['coment'] == '<b>��� � ����������� �����</b>' && $damexp['damage'] > 0 &&  ($damexp['dflag']<=1) && ($data_battle['win']==$user['battle_t']) )
			{

				if (get_chance(50))
						{
						// 15561 - 15568
						  	put_bonus_item(mt_rand(15561,15568), $user, '�����',array(),array('notsell' => 1));
						}

			}*/
      elseif ($data_battle['coment'] == '<b>��� � ����������� �����</b>' && $damexp['damage'] >=$user['maxhp'] &&  ($damexp['dflag']==0) && ($data_battle['win']==$user['battle_t']) )
        {
			put_bonus_item(20181001, $user, '�����',array(),array('notsell' => 1));
			try {
				$HelloweenRating = new \components\Helper\rating\HelloweenRating();
				$HelloweenRating->value_add = 1;

				$app->applyHook('event.rating', $user, $HelloweenRating);
			} catch (Exception $ex) {
				$app->logger->addEmergency((string)$ex);
			}

			try {
				$User = new \components\models\User($user);
				/** @var \components\Component\Quests\Quest $Quest */
				$Quest = getQuestComponent($User);

				$Checker = new \components\Component\Quests\check\CheckerDrop();
				$Checker->item_id = 20181001;
				$Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
				$Items = $Quest->isNeed($Checker, true);
				if($Items) {
					$Quest->taskUpMultiple($Items);
                }
			} catch (Exception $ex) {
				$app->logger->addEmergency((string)$ex);
			}
        }


			if (($data_battle['type']==30) OR ($data_battle['type']==31)  OR ($data_battle['coment'] =='��� � �������� �����') OR ($data_battle['coment'] == '<b>��� � ������� ��������</b>') OR ($data_battle['coment'] == '<b>����-����</b>') )   //30-���� 31-��� ��� ��� ������
			//if ($data_battle['type']==31)
			{
				$get_drop_scroll=mysql_query("select * from get_lock_bots where  battle='{$data_battle['id']}'  and owner='{$user['id']}'  "); // ����
				if (mysql_num_rows($get_drop_scroll) > 0)
					{
						//���� -���� ���� ���� �����
						$todels=array(); //����� ��� ��������
						while ($dscroll=mysql_fetch_assoc($get_drop_scroll))
						{
						if ($dscroll['item_id']==1)
							{
							//������ ��������
								$param_array=array('name_bot'=>$dscroll['name_bot'], 'used_proto' => $dscroll['used_proto'] , 'level_bot' => $dscroll['level_bot']) ;
								$scrldrop_id=put_bonus_item(133131,$user,$param_array); //���� ������ �������
								//����������� �� � ����
								if ($scrldrop_id>1)
									{
									mysql_query("UPDATE `oldbk`.`get_lock_bots` SET `item_id`='{$scrldrop_id}' WHERE `id`='{$dscroll['id']}'");
									$tmp_bot_name=$dscroll['name_bot']." [".$dscroll['level_bot']."]";
									mysql_query("UPDATE `oldbk`.`inventory` SET `letter`=CONCAT(`letter`, ' {$tmp_bot_name}' )  WHERE `id`='{$scrldrop_id}'");
									}
							}
							else
							{
							$todels[]=$dscroll['id'];
							//����� �������� ��� ������ ��������
							addchp ('<font color=red>��������!</font> ��� �� ������� ������� ������� <b>'.$dscroll['name_bot'].'</b>.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
							}
						}

						if (count($todels)>0)
							{
							mysql_query("DELETE FROM `get_lock_bots` WHERE id in (".implode(",",$todels).") ");
							unset($todels);
							}
					}
			}

			if ($user['room']==300)
			{
			//��� ��� �� ���� � ������ ... �������� �������
			mysql_query("UPDATE `oldbk`.`battle_hist_rist300` SET `win`='{$data_battle['win']}', `fin_time`=NOW()  WHERE `battle_id`='{$data_battle['id']}' ");

			}



		if  ($data_battle['type']==22)
		{
		//��������� ������������� ������������� ���
				if (  (($data_battle['win']==$user['battle_t']) OR (($data_battle['win']==4) and ($user['battle_t']==3)))  and ( $data_battle['win']!=0))
					{
					//������ � ��������������
				     addchp ('<font color=red>��������!</font> ��� �������. ����� ���� �������� ����� '.$damexp['damage'].' HP. ������������� ���!','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
					}
					elseif  ($data_battle['win']!=0)
					{
					//���������
				     addchp ('<font color=red>��������!</font> ��� �������. ����� ���� �������� ����� '.$damexp['damage'].' HP. ������������� ���!','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
					}
					else
					{
					//�����
					     addchp ('<font color=red>��������!</font> ��� ������� ������. ����� ���� �������� ����� '.$damexp['damage'].' HP. ������������� ���!'.'. '.$trrep.'  ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
					}

		}
		else
	      if (  (($data_battle['win']==$user['battle_t']) OR (($data_battle['win']==4) and ($user['battle_t']==3)))  and ( $data_battle['win']!=0))
	      {


			require_once('config_ko.php');

			if ((time()>$KO_start_time3) and (time()<$KO_fin_time3))
				{
				//������ ���
				$YES_DUH=false;

				if (($user['lab']==0) AND ($user['in_tower']==0) AND ($damexp['damage']>=1) AND (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290))) and
				(!($user['room'] >= 49998 && $user['room'] <= 53600))
				 AND ( ( ($data_battle['type']!=1) AND ($data_battle['type']!=4) AND ($data_battle['type']!=5) AND ($data_battle['type']!=13) AND ($data_battle['type']!=14) AND ($data_battle['type']!=15) )  OR  (($data_battle['CHAOS']>0) AND ($data_battle['type']!=5) ) ) )
				 	{
					$YES_DUH=true;
							 	//�������� ��������� ��� � ������
							 	$protiv=($user['battle_t']==1?'t2':'t1');
							 	$testteam=explode(";",$data_battle[$protiv]);
							 	if (count($testteam)==1)
							 		{
							 		// ������ ���� ���� ����
							 		// ��������� ��� �������
							 		$get_telo=mysql_fetch_array(mysql_query("select * from users where id='{$testteam[0]}' "));
							 		if (($user['level']-$get_telo['level'])>=3)
							 			{
										$YES_DUH=false;
							 			}
							 		}

					}

					if ( ($data_battle['coment']=='��� � �������� �����') || ($data_battle['coment'] == "<b>����-����</b>" ) || ($data_battle[coment] =='<b>��� � ������� ��������</b>') )
						{
						$YES_DUH=true;
						}



				 	if ($YES_DUH==true)
				 		{
				 		mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`cbattle`=1,`tbattle`=NOW() ON DUPLICATE KEY UPDATE `cbattle`=`cbattle`+1,`tbattle`=NOW() ;");

				 		$get_user_day=mysql_fetch_array(mysql_query("select * from oldbk.users_timer where owner='{$user['id']}' "));
								if ($get_user_day)
									{
										//�� ���
										$prsbat=10; //10% �� ���
										if ($get_user_day['cday']==6) $prsbat=5; //5 �� ���
										$myp=$get_user_day['cbattle']*$prsbat;
										if ($myp>50) $myp=50;
										//�� ������
										$mypo=$get_user_day['ctime']*10;
										if ($mypo>50) $mypo=50;
										$myp+=$mypo;

										if ($myp==10)
										{
										//���������� ��������
										$txtdata[0]='������� ��� ���������: ���� ������';
										$txtdata[1]='������� ��� ���������: ���� ������';
										$txtdata[2]='������� ��� ���������: ���� ������';
										$txtdata[3]='������� ��� ���������: ���� ���������';
										$txtdata[4]='������� ��� ���������: ���� �����';
										$txtdata[5]='������� ��� ���������: ���� ������';
										$txtdata[6]='������� ��� ���������: ���� �������';

										$txtdata=$txtdata[$get_user_day['cday']];

										$mtext="� ��� ��������� ����� ������� <a href=http://oldbk.com/encicl/?/act_line.html target=_blank>".$txtdata."</a>! ����������� �������� ����� ����� ������ �<a href=\"javascript:void(0)\" onclick=top.cht(\"http://capitalcity.oldbk.com/main.php?edit=1&effects=1#quests\")>���������</a>� ���������.";
										addchp ('<font color=red>��������!</font> '.$mtext,'{[]}'.$user[login].'{[]}',$user['room'],$user['id_city']);
										}
									}
				 		}


				 }
			elseif ((time()>$KO_start_time4) and (time()<$KO_fin_time4))
				{
				if (($user['lab']==0) AND ($user['in_tower']==0) AND ($damexp['damage']>=1) AND (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290)))
				 AND ( ( ($data_battle['type']!=1)	AND ($data_battle['type']!=4) AND ($data_battle['type']!=5) AND ($data_battle['type']!=15) )  OR  (($data_battle['CHAOS']>0) AND ($data_battle['type']!=5) ) ) )
				 	{
				 	mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`cbattle`=1,`tbattle`=NOW() ON DUPLICATE KEY UPDATE `cbattle`=`cbattle`+1,`tbattle`=NOW() ;");
				 	}

				 }




			if (($last_q) AND ($data_battle['type']!=5) AND ($data_battle['type']!=4) ) //���� ������ �����
			{
				// addchp ('<font color=red>��������!</font> ������','{[]}A-Tech{[]}');
		//		echo '�� ������� <br>';
			        if($get_var['napal']==0 && $data_battle['CHAOS']==0 && $damexp['damage']>0 && ($data_battle['type']==1 || $data_battle['type']==4 || ($data_battle['type']==6 && $data_battle['blood']>0)))
				{
					$lookok=true;
					if ($data_battle['type']==1) //����
						{
						//�������� ��� � ������
						$tm2=explode(";",$data_battle['t2']);
						 if  ($tm2[0] > _BOTSEPARATOR_ ) // ������ � ������ ��� , ���� ��� � ������ - �� ���� � �����
						 	{
	 						$lookok=false;
						 	}
						}


					if ($lookok==true)
					{
			            	quest_check_type_20($last_q,$_SESSION['uid'],'ON',2); //���� �������, ��������, �������. ��� �� ������
			            	}
			            //	addchp ('<font color=red>��������!</font> 2','{[]}A-Tech{[]}');
			      //      	echo '2<br>';
				}
		                else
		                if(($data_battle['type']==10  || $data_battle['type']==1010) && $damexp['damage']>0)
		                {
		                	quest_check_type_20($last_q,$_SESSION['uid'],'ON',10); //������� ��� � ��
		                	/*
		                	if($user['hp']>0)
			                	{
			                  		$ls = mysql_fetch_array(mysql_query("select count(`id`) as cc from `users` WHERE hp>0 AND in_tower=1;"));
			                        if($ls[cc]==1)
			                        {
		                            	//� ���� � ��, ������ ������� ��!
		                            	echo '100<br>';
		                                quest_check_type_20($last_q,$_SESSION[uid],'ON',100);
			                        }
		                        }
		                     */
		                }
		                else
		                 if($data_battle['type']>210 && $data_battle['type']<239 && $damexp['damage']>0)
		                {
		                	quest_check_type_20($last_q,$_SESSION['uid'],'ON',6); //������� ��� �� ���������
		                }

		                if($data_battle['teams']=='��� �����������' && $damexp['damage']>0) {
					$qicount = 0;

					$q = mysql_query('SELECT count(id) AS icount FROM inventory WHERE owner = '.$user['id'].' AND battle = '.$data_battle['id'].' and type != 30');
					if ($q) {
						$qicount = mysql_fetch_assoc($q);
						$qicount = $qicount['icount'];
					}

					if ($qicount >= 13) {
		                    		quest_check_type_20($last_q,$_SESSION['uid'],'ON',14); //������������. ������.
					}
		                }

	                if($data_battle['type']==6) //��� ���������.
	                {
	                 	//$test_bot=mysql_fetch_array(mysql_query("select * from users_clons where id_user=102 and battle='{$data_battle['id']}'"));
	                 	$test_t2_align=explode(';',$data_battle['t2']);
	                 	$first_frag=0;
	                 	$first_frag_c=0;
	                 	foreach($test_t2_align as $k => $v)
	                 	{
	                 		if($v<_BOTSEPARATOR_)
	                 		{
	                 			$first_frag=$v;
	                    			$first_frag_c=$k;
	                 			break;
	                 		}
	                 	}

	                 	if($first_frag>0 && $first_frag_c==0)//���� ������ ����� � ��� �� ���
	                 	{
	                 		$test_t2_align=mysql_fetch_array(mysql_query('select * from users where id = '.$first_frag.';'));
	                 		echo $test_t2_align['id'].$test_t2_align['login'].'<br>';
	                 	}

	                	if($data_battle['coment']=='��� � �������� �����' || $data_battle['coment']=='<b>��� � ����� �������</b>')
	                	{


	                		if($user['battle_t']==1 && $damexp['damage']>0 && (strpos($data_battle['t2hist'],'������� �����') || strpos($data_battle['t2hist'],'��� �������')))
					{
	                			//������ �� ������. ��� ������� (������, ��������� �� ����� ���� ����)
		                		quest_check_type_20($last_q,$_SESSION['uid'],'ON',16); //������ ��� ��������
		                		//addchp ('<font color=red>��������!</font> 16','{[]}A-Tech{[]}');
					}
					else
					if($user['battle_t']==2 && $damexp['damage']>0 && (strpos($data_battle['t1hist'],'������� �����') || strpos($data_battle['t1hist'],'��� �������')))
					{
	                			//������ �� ������. ��� ������� (������, ��������� �� ����� ���� ����)
		                		quest_check_type_20($last_q,$_SESSION['uid'],'ON',16); //������ ��� ��������
		                		//addchp ('<font color=red>��������!</font> 16','{[]}A-Tech{[]}');
					}

	                	}
	                	else
	                	{
		                        $mest=0;
		                        if($user['align']==2 && ($test_t2_align['align']==3 || $test_t2_align['align']==6 || ($test_t2_align['align']>1 && $test_t2_align['align']<2)))
		                        {
		                        	//��������� ������� � ��������
		                        	$mest=1;
		                        }
		                        elseif($user['align']==3 && ($test_t2_align['align']==2 || $test_t2_align['align']==6 || ($test_t2_align['align']>1 && $test_t2_align['align']<2)))
		                        {
		                           ///��������� �������� � ��������
		                           $mest=1;
		                        }
		                        elseif(($user['align']==6 || ($user['align']>1 && $user['align']<2)) && ($test_t2_align['align']==3 || $test_t2_align['align']==2))
		                        {
		                           //��������� �������� � �������
		                           $mest=1;
		                        }

		                        if($mest==1)
		                        {
		                			quest_check_type_20($last_q,$_SESSION['uid'],'ON',15); // ���������

		                	}

	         				//echo '15<br>';
	                	}
	                }



	               if (($data_battle['coment'] == '<b>#zlevels</b>' && $damexp['damage']>0 ) and ($get_var['napal']==0) )
	                {
					$qicount = 0;

					$q = mysql_query('SELECT count(id) AS icount FROM inventory WHERE owner = '.$user['id'].' AND battle = '.$data_battle['id'].' and type != 30');
					if ($q) {
						$qicount = mysql_fetch_assoc($q);
						$qicount = $qicount['icount'];
					}

					if ($qicount >= 13) {
						quest_check_type_20($last_q,$_SESSION['uid'],'ON',142);
					}
	                }


	                if($data_battle['type'] == 8 && $damexp['damage'] > 0) {
				$qicount = 0;

				$q = mysql_query('SELECT count(id) AS icount FROM inventory WHERE owner = '.$user['id'].' AND battle = '.$data_battle['id'].' and type != 30');
				if ($q) {
					$qicount = mysql_fetch_assoc($q);
					$qicount = $qicount['icount'];
				}

				if ($qicount >= 13) {
	                    		quest_check_type_20($last_q,$_SESSION['uid'],'ON',143); //��� �� �������
				}
	                }

		}

	        if (($data_battle['CHAOS']>0) and ($data_battle['type']!=5) and ($data_battle['type']!=4) and ($data_battle['type']!=22)  and ($data_battle['type']!=308) and ($data_battle['type']!=304)  and ($user['level']>3))
	        {
	        	// ���� ��� � ������� ���� ������

	        	if ($get_var['id']>0)
	             {
	                 // ���� ������ - ���� ����� ���������� - ��������������� ������ �� battle_vars
	                 if ($get_var['napal']==1) // ��� �������� ��� ����� 0 ����� � �����
	                    {
	                    // ��� ���� � ��� - � ������� ���� ������� ������ ��� ���� ����
	                    }
	                    else
	                    {

	                    	if($data_battle['type']>=211 && $data_battle['type']<290)
				{
				 //�������� � ����������
				}
				else
				if($last_q && $damexp['damage']>0 && $data_battle['coment'] != '��� � �������� �����' ) //���� ������ �����  � ��� �� � �������� � �� ��������
				{   //���� �� ����� ( ������)

					quest_check_type_20($last_q,$_SESSION['uid'],'ON',1); //����� ����, ������ - ������ ������ ��� 1


					$qicount = 0;


					$q = mysql_query('SELECT count(id) AS icount FROM inventory WHERE owner = '.$user['id'].' AND battle = '.$data_battle['id'].' and type != 30');
					if ($q) {
						$qicount = mysql_fetch_assoc($q);
						$qicount = $qicount['icount'];
					}

					if ($qicount >= 13) {
						quest_check_type_20($last_q,$_SESSION['uid'],'ON',7); // ����, ����� ����, ������ - ������ ������ ��� 1
					} elseif ($qicount >= 3 && $qicount < 13) {
						quest_check_type_20($last_q,$_SESSION['uid'],'ON',141); //�������, ����� ����, ������ - ������ ������ ��� 1
					} elseif ($qicount > 0 && $qicount < 3) {

						if ($get_var['napal']==0)
							{
							quest_check_type_20($last_q,$_SESSION['uid'],'ON',140); //��������, ����� ����, ������ - ������ ������ ��� 1
							}
					}

					if(($data_battle['blood']>0) and ($get_var['napal']==0) )
					{
						quest_check_type_20($last_q,$_SESSION['uid'],'ON',3); //�������� ����, ������ - ������ ������ ��� 3
					}
				}

			if (!((time()>$KO_start_time5) and (time()<$KO_fin_time5)) )
			{
			//����� - ����� �� ��������!!!!!!!!! - ������� ���
	                    //��� �� ������ - ���� ����
	                     // ���������� ����� ������ $user[wcount]
	                     // ����������� �����
	                      if ( ($user['wcount']==5) OR ($user['wcount']==10) OR  ($user['wcount']==15))
	                         {
	                          //�������� ��������
	                           $bo=$user['wcount'];
	                           $boname[5]='��� ��������� 1'; $boname[10]='��� ��������� 2'; $boname[15]='��� ��������� 3';
	                           $botype[5]=1001;$botype[10]=1002;$botype[15]=1003;
	                           				   $bons[4][5]=10;   $bons[4][10]=20;   $bons[4][15]=30;
       					                           $bons[5][5]=20;   $bons[5][10]=40;   $bons[5][15]=60;
	                          				   $bons[6][5]=30;   $bons[6][10]=60;   $bons[6][15]=90;
       					                           $bons[7][5]=40;   $bons[7][10]=80;   $bons[7][15]=120;
								   $bons[8][5]=60;   $bons[8][10]=120;  $bons[8][15]=180;
								   $bons[9][5]=80;   $bons[9][10]=160;  $bons[9][15]=240;
								   $bons[10][5]=100; $bons[10][10]=200; $bons[10][15]=300;
								   $bons[11][5]=120; $bons[11][10]=240; $bons[11][15]=360;
								   $bons[12][5]=140; $bons[12][10]=280; $bons[12][15]=420;
								   $bons[13][5]=160; $bons[13][10]=320; $bons[13][15]=480;

								   $bons[14][5]=160; $bons[14][10]=320; $bons[14][15]=480;

								   $bons_val=$bons[$user['level']][$bo];
								   $timer=time()+14400;//4 ����

	                          $get_bon=mysql_fetch_array(mysql_query("SELECT * from effects where owner='{$user['id']}' and (type=1001 OR type=1002 OR type=1003) ;"));
	                          if ($get_bon['id'] >0 )
	                           {
		                          // ���� �����
		                          // ���������� ����� ����
		                             $bl[1001]=1;$bl[1002]=2;$bl[1003]=3;
		                             $blvl=$bl[$get_bon['type']];
		                          // ���������� ����� ����� ������ ���
		                             $nb[5]=1;$nb[10]=2;$nb[15]=3;
		                             $nblvl=$nb[$user['wcount']];
		                          ////////////////
		                          // ���� �������� ����� ������ �������
	                               if ($nblvl > $blvl )
	                                 {
	                                 // �� ��� ����� �����
	                                 //1. ���� ������ �� ������- ������ �����
	                                 $newhp=$user['maxhp']-$user['bpbonushp'];//maxhp ��� ������� ������
	                                 $newhp=$newhp+$bons_val;// + ����� �����
   	                                 mysql_query("DELETE FROM effects where id='{$get_bon['id']}' and owner='{$user['id']}';"); // ������� ������ ����� - ��������� ������!
   	                                 //������ �����
	                                  mysql_query("INSERT INTO `effects` SET `type`='{$botype[$bo]}', `name`='{$boname[$bo]}',`time`='{$timer}',`owner`='{$user['id']}',`lastup`='{$bons_val}';");

							          /// ��������� ��������� +100
							          $add_repp=100;
								  if ($user['prem']>0) {$add_repp=$add_repp*1.1;}

								 	  $add_repp=(int)($add_repp);
							          addchp ('<font color=red>��������!</font> �� �������� <b>'.$add_repp.'</b> ��������� �� ��������� ������!','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);

				        			  mysql_query("UPDATE users SET  `rep`=`rep`+'".$add_repp."', `repmoney` = `repmoney` + '".$add_repp."' ,   `bpbonushp`='{$bons_val}' , `maxhp`='{$newhp}' where `id`='{$user['id']}' ; ");

	                                 }
	                                 else
	                                 {
	                                 // ��� ������� ������� ����� ������ ������ ��������� ����� � ���
	                                 $timer=time()+14400;//4 ����
	                                 // �� - ����� ��� ���� ���� �������� ���� ��� �� ������ ������� - ����� ��������� �� �����
	                                 mysql_query("UPDATE effects SET `time`='{$timer}' where id='{$get_bon['id']}' and owner='{$user['id']}';");
	                                 }

	                           }
	                           else
	                           {
			                            /// ��������� ��������� +100
						          $add_repp=100;
							  if ($user['prem']>0) {$add_repp=$add_repp*1.1;}
						 	  $add_repp=(int)($add_repp);
						          addchp ('<font color=red>��������!</font> �� �������� <b>'.$add_repp.'</b> ��������� �� ��������� ������!','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);

			                           //��� ������ - ������ ������ �����
						   	mysql_query("INSERT INTO `effects` SET `type`='{$botype[$bo]}', `name`='{$boname[$bo]}',`time`='{$timer}',`owner`='{$user['id']}',`lastup`='{$bons_val}';");
					          	mysql_query("UPDATE users SET  `rep`=`rep`+'".$add_repp."', `repmoney` = `repmoney` + '".$add_repp."' ,  `bpbonushp`='{$bons_val}' , `maxhp`=`maxhp`+{$bons_val} where `id`='{$user['id']}' ; ");
	                           }
	                         }
	                       }
	                       else
	                       {
	                      //����� - ����� ��������!!!!!!!!!
	                       //����� ���� ���� ����� ��� � ������� + ����
				if (( $damexp['damage']>0) and ($user['klan']!='testTest' ) )
					{
					//����� ���� ���� ����
					mk_vduh($user);
		       			//addchp('<font color=red>��������!</font> FINFO 1 : '.$user['battle'].' ���: '.$user['login'],'{[]}Bred{[]}',-1,0);
					}
	                      ////////////////////////////////////////////////////////////
	                       }




	                    }
	             }
	        }
       //     echo '����� ������<br>';
	        // ������
     	    // ���������� ����� � ���
		    $pocent=round($user['expbonus']*100);
    		    $pocent_telo_baza=$pocent; // ��������� �������� �����



			if (($data_battle['type']==60) OR  ($data_battle['type']==61))
			{
					$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=10"));
					if ($get_ivent['stat']==1)
					{
					$arena_week=true;
					//���� ���������
					$EXP_WIN=2.25; //225 % ����� � ��� ����/����
					$pocent+=50;
					}
					else
					{
					$EXP_WIN=1.5; //150 % ����� � ��� ����/����
					//$pocent+=100;
					}
			}
			if ($data_battle['type']==62)
			{
			$EXP_WIN=4; //400 % ����� � ��� ����/����
			}

			if (($data_battle['type']==101) OR ($data_battle['type']==141) OR ($data_battle['type']==151) )
				{
				$EXP_WIN=1.1; // ������� �������� ���
				}

			///������ � ��������� ���
			if ($data_battle['status_flag']==1)
				{
				$EXP_WIN=2;
				}
			else if ($data_battle['status_flag']==2)
				{
				$EXP_WIN=2.5;
				}
			else if ($data_battle['status_flag']==3)
				{
				$EXP_WIN=3;
				}
			else if ($data_battle['status_flag']==4)
				{
				$EXP_WIN=5;
				}
			else if ($data_battle['status_flag']==10)
				{
				$EXP_WIN=1.2;
				}
////////////////////////////////////////////////////////////
/* ������ ��� �� �����		if (($data_battle['type']==170) OR ($data_battle['type']==171))
			{
				$EXP_WIN=1;
				$rrep=$damexp['exp']*0.0175;
				if ($user['prem']>0) { $rrep=$rrep*1.1; }
				$rrep=round($rrep);
				if ($rrep >= 10000) $rrep = 10000;
				$trrep=' �������� ���������: '.$rrep;
			}
			else*/
			$trrep='';
			$prebonusp=0;
			$naem_exp=0;
			$naem_debonus=0;


			//�������� ��� �������� � ������� �� ������� ���� ����
	    	      	$naem=mysql_fetch_array(mysql_query("select * from users_clons where owner='{$user['id']}' and naem_status=1 and last_battle='{$data_battle['id']}' limit 1;"));
    	      		if ($naem['id']>0)
    	      			{
    	      			//��� � ��� ���� ��������
    	      			$get_naem_exp=mysql_fetch_array(mysql_query("select * from battle_dam_exp where owner='{$naem['id']}' and battle='{$data_battle['id']}' limit 1"));
				$naem_dmg=0;
    	      			$naem_exp=0;
	      				if ($get_naem_exp['id']>0)
	      				{
					$naem_dmg=$get_naem_exp['damage'];
	    	      			$naem_exp=$get_naem_exp['exp'];

	    	      				//������� �������� ��������� ����� �����
	    	      				if (($damexp['exp']==0) and ($naem_exp>0) )
	    	      				{
	    	      				//�������� ���� ������� 0 �����
	    	      				//�������� ���� ����� �����
	    	      				mysql_query("UPDATE users_clons SET `exp`=`exp` - {$naem_exp} where id='{$naem['id']}' ") ;
	    	      				$naem_exp=0;
	    	      				}

	      				}

	      			//$naem_debonus=20;
    	      			}


			if (($data_battle['coment'] == "<b>��� �� ����������� �������</b>" ) )
			{
				$get_wes=mysql_fetch_array(mysql_query("SELECT * from `battle_war` where battle='{$data_battle['id']}' "));
				if  ($get_wes['active']==1)
				{
				$EXP_WIN=1.5;
				$rrep=$damexp['exp']*0.023;
				$rep_kof=$vinst_arr[$user['level']];
				if ($rep_kof>0) { $rrep=$rrep*$rep_kof; }
				if ($rrep>2000) {$rrep=2000;}
				if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }

				$rrep=round($rrep);

				$rrep=round($rrep*$user['rep_bonus']);
				$trrep=' �������� ���������: '.$rrep." (".(($user['rep_bonus']*100)+$prebonusp)."%) ";

				}
			}
			else if (($data_battle['coment'] == '<b>#zlevels</b>') or ($data_battle['type']==23) )
			{

				$maxrep=100;
				if ($user['prem']>0) { $bnp=1.1; $prebonusp=10; } else { $bnp=1; }

					$rp=($damexp['damage']/$user['maxhp']);
					if ($rp>=1)
					 {
						 $rrep=round($maxrep*$bnp);
					 }
					 else
					 {
 						 $rrep=round($rp*$maxrep*$bnp);
					 }

				$trrep=' �������� ���������: '.$rrep." (".(($user['rep_bonus']*100)+$prebonusp)."%) ";
			}
			elseif (( $data_battle['status_flag'] > 0) or ($data_battle['type']==7) or ($data_battle['type']==8) or ($data_battle['type']==23) OR ($data_battle['type'] == 311)  OR ($data_battle['type'] == 313)  )
			{

			if ($data_battle['status_flag']==6)
				{
				 if ($arena_week==true)
				 	{
					$rrep=$damexp['exp']*0.0258;
					$prebonusp=20;
				 	}
				 	else
				 	{
					$rrep=$damexp['exp']*0.0175;
					}
				}
				else
				{
				$rrep=$damexp['exp']*0.023;
				}
			$rep_kof=$vinst_arr[$user['level']];
			if ($rep_kof>0) { $rrep=$rrep*$rep_kof;  }

			$rrep_nobonus=$rrep; // ��� ������ ����. ��������

			$dragon_week=false;
			$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=14"));
						//������ ����� ��������
						if ($get_ivent['stat']==1)
						{
						$dragon_week=true;
						}



				if ($data_battle['type'] == 313)
				{
				if ($rrep>500) {$rrep=500;}
					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
					$rrep=round($rrep);
				}
				elseif (($data_battle['coment'] == "<b>����-����</b>" ) )
				{
				if ($rrep>2000) {$rrep=2000;}
					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
					$rrep=round($rrep);
				}elseif (($dragon_week==true) and ($data_battle['coment'] == "<b>��� � ������� ��������</b>" ) )
				{
					if ($rrep>2000) {$rrep=2000;}
					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
					$rrep=round($rrep);
				}
				elseif ($data_battle['type']==7)
				{
				//��� �� �����
					if ( ((countinteam($data_battle['t1'])+countinteam($data_battle['t2']))>=50) OR ($data_battle['coment']=='<b>#zelka</b>') )
						{
							if ($rrep>250) {$rrep=250;} //�����
						}
						else
						{
						$rrep=0;
						}
					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
					$rrep=round($rrep);

				}
				elseif (($data_battle['type']==8) and ($data_battle['status_flag']==0) )
				{


					if ($rrep_nobonus>100) {$rrep_nobonus=100;} //�����
					if ($user['prem']>0)
					{
					$rrep=round($rrep_nobonus*1.1);
					$prebonusp=10;
					}
					else
					{

					$rrep=round($rrep_nobonus);
					}

				}
				elseif (($data_battle['type']==8) and ($data_battle['status_flag']==10) )
				{

					if ($rrep_nobonus>200) {$rrep_nobonus=200;} //�����
					if ($user['prem']>0)
					{
					$prebonusp=10;
					$rrep=round($rrep_nobonus*1.1);
					}
					else
					{
					$rrep=round($rrep_nobonus);
					}

				}
				elseif ($data_battle['status_flag']==10)
				{
				if ($rrep>100) {$rrep=100;} //�����
					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
					$rrep=round($rrep);

				}
				elseif (($data_battle['coment']=='��� � �������� �����' ) OR ($data_battle['type'] == 311)    )
				{
				if ($rrep>1000) {$rrep=1000;} //�����
					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
					$rrep=round($rrep);

				}
				else
				{
				if ($rrep>10000) {$rrep=10000;}
					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp+=10; }
					$rrep=round($rrep);
				}

			$rrep=round($rrep*$user['rep_bonus']);
			$trrep=' �������� ���������: '.$rrep." (".(($user['rep_bonus']*100)+$prebonusp)."%) ";
			}

		if ($data_battle['type']==313)
		{
		$EXP_WIN=1.2;
		}
		elseif ($data_battle['type']==311)
		{
		$EXP_WIN=3;
		}
		elseif ($data_battle['type']==23)
	 	{
		$EXP_WIN=1;
	 	}
		else
		if (($data_battle['CHAOS']>0) and ($data_battle['type']!=4) and ($data_battle['type']!=7)  and ($data_battle['type']!=2) and $data_battle['type']<=20  and ($data_battle['coment'] != '��� � �������� �����' ) )
		{
		//���� ���� �� ������� ���� �� �����
					$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=11"));
					if ($get_ivent['stat']==1)
					{
					$EXP_WIN=1.5;
					}
					elseif ($data_battle['coment'] =='<b>#zlevels</b>')
					{
					//� ���� ������ 130% ����� �� �������
					$EXP_WIN=1.3;
					}

		}
		else if (($data_battle['type']==4) or ($data_battle['type']==2) )
		{
		//������ �����
					$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=12"));
					if ($get_ivent['stat']==1)
					{
					$EXP_WIN=1.5;
					}

		}
		else if ($data_battle['type']==7)
		{
		//���� ���� - ���� �� ������� ���� �� �����
					$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=11"));
					if ($get_ivent['stat']==1)
					{
					$EXP_WIN=2.5;
					}
					else
					{
					$EXP_WIN=2;
					}
		}

	     	$damexp['exp']=round($damexp['exp']*$EXP_WIN);

	     	$pocent+=round(($EXP_WIN-1)*100);


			///�������������� ������� ��������� � ��������
			///���� ��� �������
			 if($user['align']==4) {
			      	$pocent=round($pocent*0.5);
	                    }
			///���� ��� ��������
			if (($data_battle['blood']>0) or ($data_battle['coment']=='<b>����-����</b>') OR ($data_battle['type'] == 313)  )
			   {
			     $pocent+=100; //+100% ���� ��� �������� � ������!
			   }
			///���� � ������
			if  (($data_battle['CHAOS']>0) and ($data_battle['type']!=7) )
				    	{
				      	$pocent+=30;
				      	}
				      	//��������� ���
				      	else if ($data_battle['type']==2)
				      	{
				      	$pocent+=50;
				      	}
			////////////////////////
		$_SESSION['get_exp']=$damexp['exp'];//�������� � ������
		if(time()>mktime(0,0,0,12,11,2018) && time()<mktime(23,59,59,12,12,2018))
		{
		     $pocent+=100; //+100%
		}

		$addsysexp='';
		if ($damexp['dflag']>0) { $addsysexp=', (���� �������� ��-�� ������� � �������)'; }

    	     addchp ('<font color=red>��������!</font> ��� �������. ����� ���� �������� ����� '.$damexp['damage'].' HP. �������� ����� '.$damexp['exp'].' (<b>'.($pocent-$naem_debonus).'%</b>)'.$addsysexp.'. '.$trrep.'  ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);


		if ($naem['id']>0)
		{
	      			//% �� ���� ���
	      			//$naem_exp=round($naem_exp*$EXP_WIN);
	      			//$pocent_naem=$pocent-$pocent_telo_baza+round($naem['expbonus']*100); // �������� ��������
	      			$pocent_naem=100;

			        addchp ('<font color=red>��������!</font> ��� �������. ����� ����� ��������� <b>'.$naem['login'].'</b> �������� ����� '.$naem_dmg.' HP. �������� ����� '.$naem_exp.' (<b>'.$pocent_naem.'%</b>)'.'.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
				if ($naem_exp>0)
				{
					lvl_up_naem($user,$naem);
				}
				mysql_query("DELETE from battle_dam_exp WHERE  owner='{$naem['id']}'");  // ������

		}

    	    //������ ������ �� ���� ���
    	     $get_runs_exp=mysql_fetch_array(mysql_query("select * from battle_runs_exp where owner='{$user['id']}' and battle='{$user['last_battle']}' ; "));
    	     if (($get_runs_exp['id']>0) and (($get_runs_exp['point']>0) or ($get_runs_exp['rkm_bonus']>0))  )
    	     	{
    	     	$RKF=runs_battle_get_kof($data_battle);
    	     	$get_rex=0;
    	     	$get_runs_exp['rkm_bonus']=(int)$get_runs_exp['rkm_bonus'];
    	     	$get_runs_exp['point']=(int)$get_runs_exp['point'];
		if ($RKF>0)
			{
					if ($get_runs_exp['rkf_bonus']>0)
					{
					$RKF=round(($RKF+($get_runs_exp['rkf_bonus']/100)),2);
					}

				if ($user['align']==4)
				{
				$str_rkf=round($RKF*0.5*100);
				}
				else
				{
				$str_rkf=($RKF*100);
				}

					 if ($get_runs_exp['battle_flag']>0)
					 {
					$all_p=5;
					 }
					 else
					 {
					$all_p=0;
					 }

					if (($dragon_week==true) and ($data_battle['coment'] == "<b>��� � ������� ��������</b>" ) )
				          {
				          $ddrkof=1; //100%
			         	  $str_rkf=round($str_rkf);
			    	     	 $str_rkf="(<a href=http://oldbk.com/encicl/?/rk_table.html target=_blank>�� {$str_rkf}%</a>)";
				         }
				       elseif (($all_p<5) and ( $data_battle['type']!=171 ) and ( $data_battle['type']!=40 ) and ( $data_battle['type']!=41 ))
				      {
				           $ddrkof=0.1; //10%
				           $str_rkf=round($str_rkf/10);
			    	     	 $str_rkf="(<a href=http://oldbk.com/encicl/?/rk_table.html target=_blank>�� {$str_rkf}%</a>)";
				      }
				      else
				      {
				          $ddrkof=1; //100%
			    	     	 $str_rkf="(<a href=http://oldbk.com/encicl/?/rk_table.html target=_blank>�� {$str_rkf}%</a>)";
				      }

				      if ($get_runs_exp['point']>0)
					{
				    	 $get_rex=round((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof);
				    	 }
				    	 else
				    	 {
				    	 $get_rex=0;
				    	 }


			    	 	//�������� �� ���
			    	 	$rkm_msg='';
			    	 	$get_rex_rkm=0;
			    	 	if (($get_runs_exp['rkm_bonus']>0) and ($damexp['mag_damage'] >0) and ($get_runs_exp['runs']>0) )
			    	 	{
				 	//��������� ���� ��� ����� ��������� � �������, �������� ��� ���� �� ���� � ����������� �� ���. ���
					$get_rex_rkm=round(($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs']);
			    	 	}



			    	 /* ��������! �� �������� 20 ����� ��� ������ ���� (������� ��-�� �������� � ���������).
					�������� ����� � ����� ������ �� ������ � ������ ������
				*/
					if (($data_battle[coment] =='��� � �������� �����') OR ($data_battle['type'] == 311)  OR ($data_battle[coment] =='<b>��� � ����� �������</b>') OR ($data_battle[coment] =='<b>��� � ������� ��������</b>') OR ($data_battle['type'] == 312) )
					{
						if ($get_rex_rkm>0)
						{
						 //��������! �� �������� ��� ������ ����: 9 ������� ����� (�� 200%) � 18 ������� ����� �� ���������� ���������� ���� � ��� (��� 1%). �����: 9 ������� ����� ��� ������ ����.
			   		    	 addchp ('<font color=red>��������!</font> �� �������� ��� ������ ����: '.$get_rex.' ������� ����� (������� ��-�� �������� � ���������) � '.$get_rex_rkm.' ������� ����� �� ���������� ���������� ���� � ��� (��� '.$get_runs_exp['rkm_bonus'].'%). �����: '.($get_rex+$get_rex_rkm).' ������� ����� ��� ������ ����.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
						}
						else
						{
			   		    	 addchp ('<font color=red>��������!</font> �� �������� '.$get_rex.' ����� ��� ������ ���� (������� ��-�� �������� � ���������).','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
			   		    	}
					}
					else
					{
						if ($get_rex_rkm>0)
						{

			   		    	 addchp ('<font color=red>��������!</font> �� �������� ��� ������ ����: '.$get_rex.' ������� ����� '.$str_rkf.' � '.$get_rex_rkm.' ������� ����� �� ���������� ���������� ���� � ��� (��� '.$get_runs_exp['rkm_bonus'].'%). �����: '.($get_rex+$get_rex_rkm).' ������� ����� ��� ������ ����.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
						}
						else
						{
			   		    	 addchp ('<font color=red>��������!</font> �� �������� '.$get_rex.' ����� ��� ������ ����. '.$str_rkf,'{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
			   		    	}
		   		    	 }



		    	}
   	    	     mysql_query("DELETE FROM `battle_runs_exp` WHERE `owner`='{$user['id']}' ");
    	     	}


		//����� �����
			require_once('config_ko.php');

    	     		if ((time()>$KO_start_time29) and (time()<$KO_fin_time29)) // '������� ��������� ���
    	     		{
			if ( ($data_battle['type']==61) OR // ��� �� �����
			     ($data_battle['coment'] == "<b>����-����</b>" ) OR //����
			     ($data_battle['teams']=='��� �����������')  )
    	     		{


				if ($data_battle['teams']=='��� �����������')
				{
					$max_ta=25;
					$max_tb=25;
				// �������� ��� ���� �����������
						if (($damexp['damage']>0) and ($get_runs_exp['point']>0)  )
						{
						$baza_kof=round(($damexp['damage']/$user['maxhp']),2);
						if ($baza_kof>1) $baza_kof=1;
			    	     		$add_znak_a=round(($get_runs_exp['point']/($user['maxhp']*0.21)*3)*$baza_kof);
		    		     		if ($add_znak_a>$max_ta) $add_znak_a=$max_ta;
		    		     		}
		    		     		else
		    		     		{
		    		     		$add_znak_a=0;
		    		     		}


						$add_znak_b=round($damexp['damage']/100);
						if ($add_znak_b>$max_tb) $add_znak_b=$max_tb;
				}
				else
				{
					$max_ta=30;
					$max_tb=20;
				//�������� ��� ���� ���� � �����

						if (($damexp['damage']>=$user['maxhp']) and ($get_runs_exp['point']>0)  )
								{
						    	     		$add_znak_a=round($get_runs_exp['point']/($user['maxhp']*0.21)*3);
					    		     		if ($add_znak_a>$max_ta) $add_znak_a=$max_ta;
				    		     		}
				    		     		else
				    		     		{
					    		     		$add_znak_a=0;
				    		     		}

		  	     		$add_znak_b=round(($damexp['damage']/$user['maxhp'])*2);
    			     		if ($add_znak_b>$max_tb) $add_znak_b=$max_tb;
    		     		}

    			$add_znak=$add_znak_a+$add_znak_b;

    	     		if ($add_znak>0)
    	     			{
    	     			//��������� ����
    	     								mysql_query("UPDATE users SET  `znak`=`znak`+'{$add_znak}'  where `id`='{$user['id']}' ; ");
									if (mysql_affected_rows()>0)
									{
																		$rec['owner']=$user['id']; $rec['owner_login']=$user['login'];
																		$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];
																		$rec['target']=0;$rec['target_login']='���';
																		$rec['type']=6044;
																		$rec['item_id']='proto:404400';
																		$rec['item_name']='���� �����';
																		$rec['item_count']=$add_znak;
																		$rec['item_type']=0;
																		$rec['item_maxdur']=1;
																		$rec['battle']=$data_battle['id'];
																		$rec['add_info']='������ ��:'.$user['znak']." / �����:".($user['znak']+$add_znak).' ������ �����';
																		add_to_new_delo($rec);
																		addchp ('<font color=red>��������!</font> �� �������� <b>����� ������</b> �'.$add_znak.' ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);

									}

    	     			}
    	     		}
    	     		}

    	     # ����� � ��� ���������� � ���������� ���� ����� � ������� ��� ���� �� ��� �� �����

    	     if ($data_battle['fond']>0)
    	       {
    			//����������� ��������
    			if (olddelo==1)
    			 {
    	   		 $info_delo=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.delo where pers='{$user['id']}' and battle={$user['last_battle']} ; "));
	     		 addchp ('<font color=red>��������!</font> '.$info_delo['text'].'','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
	     		 }
	     		 else
	     		 {
	     		 //load from new delo
     	   		 $info_delo=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.new_delo where owner='{$user['id']}' and battle={$user['last_battle']} and (type=15 or type=16) ; "));
     	   		 $out_delo_type[15]="�� �������� {$info_delo['sum_kr']} ��. �� ������ � �������� �{$info_delo['battle']}";
			 $out_delo_type[16]="�� �������� {$info_delo['sum_kr']} ��. �� ����� � �������� �{$info_delo['battle']}";
			 if ($out_delo_type[$info_delo['type']])
			 	{
 		     		 addchp ('<font color=red>��������!</font> '.$out_delo_type[$info_delo['type']].'','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
			 	}
	     		 }
    	       }

		//���� �������� -  �����
		//� ����������� ���� ������� ��������
		//     ���� ����� �������� 20% � ������ ������ � ����������� ���
		//    ���� �������� �������� �� 23:59 30 ������
		if (($data_battle['CHAOS']>0) and ($data_battle['type']!=4) and ($data_battle['type']!=7)  and ($data_battle['type']!=2) and $data_battle['type']<=20  and ($data_battle['coment'] != '��� � �������� �����' ) )
		//if (false) // ���� ����������
		{
	 	require_once('config_ko.php');
	 	if ((time()>$KO_start_time42) and (time()<$KO_fin_time42))
			if (mt_rand(1,100)<=20)
			{
					 // ���� ������� ��� �����
				     	      	            $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`shop` WHERE `id` = '411000' LIMIT 1;")); //�������� �� ������ �������

								if ($dress['id']>0)
											{

											$dress['dategoden']=mktime(23,59,59,11,30,2016);
											$dress['goden']=round(($dress['dategoden']-time())/60/60/24);
											$dress['img']="item_treelenta".mt_rand(1,8).".gif";
											$dress['present']='�����';

											if (mysql_query("INSERT INTO oldbk.`inventory`
											(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`img_big`,`maxdur`,`isrep`,
												`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
												`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`letter`
											)
											VALUES
											('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}','{$dress['img_big']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
											'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$dress['present']}','{$dress['labonly']}','0','{$dress['group']}','{$user['id_city']}','{$user['letter']}'
											) ;") )
										     {
										     		$dress['id']=mysql_insert_id();
										     		$dress['idcity']=$user['id_city'];
										     		//new delo
												$rec['owner']=$user['id']; $rec['owner_login']=$user['login'];
												$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];
												$rec['target']=0;$rec['target_login']='���';
												$rec['type']=60;//������� � ���
												$rec['sum_kr']=0; $rec['sum_ekr']=0;
												$rec['sum_kom']=0; $rec['item_id']=get_item_fid($dress);
												$rec['item_name']=$dress['name'];
												$rec['item_count']=1;
												$rec['item_type']=$dress['type'];
												$rec['item_cost']=$dress['cost'];
												$rec['item_dur']=$dress['duration'];
												$rec['item_maxdur']=$dress['maxdur'];
												$rec['item_ups']=0;
												$rec['item_unic']=0;
												$rec['item_incmagic']='';
												$rec['item_incmagic_count']='';
												$rec['item_arsenal']='';
												$rec['battle']=$data_battle['id'];
												add_to_new_delo($rec);
										   		addchp ('<font color=red>��������!</font> �� �������� � ��� <b>'.link_for_item($dress).'</b> ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
										   	}
										}
			}
		}

		//���� ���������� ��������
		//�������, ��, �������, ��������� � ������ 10%. OR ($data_battle['type'] == 311 OR ($data_battle['type'] == 313 OR ($data_battle['type'] == 312
		if ((($data_battle['coment'] == '��� � �������� �����')   OR ($data_battle['coment'] == '<b>����-����</b>')   OR ($data_battle['coment'] == '<b>��� � ������� ��������</b>') ) and ($damexp['damage']>0) )
		{
				if (mt_rand(1,100)<=10)
				{
					//���������  �������� ��
					  $check_5671=mysql_fetch_array(mysql_query("select * from stol where owner='{$user['id']}' and  stol=5671"));
					  if (!($check_5671))
					  	{
					  	//��� �� ������
					  	put_bonus_item(5671, $user, '�����');
					  	mysql_query("INSERT INTO `oldbk`.`stol` SET `owner`='{$user['id']}',`stol`=5671,`count`='1' ");

					  	}

				}
		}


		//���� �������� - ����� ������
		if (($data_battle['CHAOS']>0) and ($data_battle['type']!=4) and ($data_battle['type']!=7)  and ($data_battle['type']!=2) and $data_battle['type']<=20  and ($data_battle['coment'] != '��� � �������� �����' ) )
		{
		// �����
			if ($damexp['damage']>0)
				{
				//���� ���� �� ��� ������� - ����� ���
				include "fdroplist_haot.php";

				//���� ������� ����, ��������� ������� �� ������ 1 = ���� ����� 50%
					if (mt_rand(1,100)<=50) //50
						{
						$rand_keys = array_rand($grp1, 1);
						$dropid=$grp1[$rand_keys];
						 put_bonus_item($dropid, $user, '�����');
						}
			    if (($get_runs_exp['id']>0) and ($get_runs_exp['useabil']>0) )
			    	{
				//���� � ��� ���� ������������ ������ ���������� (����� ����������� � ���), ��������� ������� �� ������ 2  ���� ����� 35%
					if (mt_rand(1,100)<=35) //35
						{
						$rand_keys = array_rand($grp2, 1);
						$dropid=$grp2[$rand_keys];
						 put_bonus_item($dropid, $user, '�����');
						}
				}

				// ���� �� ������ ���������� ��� � ��������� �������� ����� 50% ��, ��������� ������� �� ������ 3 ���� ����� 20%
				if ($user['hp']>=($user['maxhp']*0.5))
				{
					if (mt_rand(1,100)<=20) //20
							{
							$rand_keys = array_rand($grp3, 1);
							$dropid=$grp3[$rand_keys];
							 put_bonus_item($dropid, $user, '�����');
							}
				}

				// ���� ���������� ���� ������ ����� ���� ��, ��������� ������� �� ������ 4  ���� ����� 10%
				if ($damexp['damage']>$user['maxhp'])
				{
					if (mt_rand(1,100)<=10) //10
							{
							$rand_keys = array_rand($grp4, 1);
							$dropid=$grp4[$rand_keys];
							 put_bonus_item($dropid, $user, '�����');
							}

				}

				 //���� �������������� ����� ������� (������ �� 180 � ����), ��������� ������� �� ������ 5  ����� 5%
				 if (($get_runs_exp['id']>0) and ($get_runs_exp['useabil']>0) )
				 {
					if (mt_rand(1,100)<=5) //5
							{
							$rand_keys = array_rand($grp5, 1);
							$dropid=$grp5[$rand_keys];
							 put_bonus_item($dropid, $user, '�����');
							}

				 }


				}

		}


	     }
	     else
	     {

	     if ( $data_battle['win']!=0)
	    {
	//������ ������ �� ���� ��� - ���� �� �����
	//��� ������� ������� ����� �� ���� ���� (��� ������ ������ ���� � ������������� � �������� �� http://oldbk.com/encicl/?/rk_table.html ���� �� �������� �������� �� ��������
	    $get_runs_exp=mysql_fetch_array(mysql_query("select * from battle_runs_exp where owner='{$user['id']}' and battle='{$user['last_battle']}' ; "));

	     if (($get_runs_exp['id']>0) and (($get_runs_exp['point']>0) or ($get_runs_exp['rkm_bonus']>0))  )
    	     	{
    	     	$RKF=runs_battle_get_kof($data_battle);
    	     	$get_rex=0;
    	     	$get_runs_exp['rkm_bonus']=(int)$get_runs_exp['rkm_bonus'];
    	     	$get_runs_exp['point']=(int)$get_runs_exp['point'];

		if ($RKF>0)
			{
					if ($get_runs_exp['rkf_bonus']>0)
					{
					$RKF=round(($RKF+($get_runs_exp['rkf_bonus']/100)),2);
					}


					if ($user['align']==4)
					{
					$str_rkf=round($RKF*0.5*100);
					}
					else
					{
					$str_rkf=($RKF*100);
					}

					 if ($get_runs_exp['battle_flag']>0)
						 {
						$all_p=5;
						 }
						 else
						 {
						$all_p=0;
						 }

				if (($data_battle['type']==601) OR ( $data_battle['type']==602) OR ( $data_battle['type']==603) OR ( $data_battle['type']==604) )
				{
				$str_rkf=round($str_rkf);
				}
			        elseif ($data_battle['teams']=='��� �����������' )
		         	 {
		         	 $ddrkof=1; //100%
		         	$str_rkf=round($str_rkf/1.5);
		         	 }
		         	 elseif (($dragon_week==true) and ($data_battle['coment'] == "<b>��� � ������� ��������</b>" ) )
			          {
			          $ddrkof=1; //100%
		         	  $str_rkf=round($str_rkf);
			         }
			         elseif (($data_battle['coment'] == "<b>����-����</b>" ) OR ($data_battle['type'] == 313) )
		         	 {
		         	 $ddrkof=1; //100%
		         	 $str_rkf=round($str_rkf/2);
		         	 }
			         elseif ( ($data_battle['coment'] == "<b>��� � �������</b>" )  OR ($data_battle['coment'] == "<b>��� � ������</b>" ))
		         	 {
		         	 $ddrkof=1; //100%
		         	$str_rkf=round($str_rkf);
		         	 }
			         elseif ($data_battle['type'] == 61 ) // //����� �����
		         	 {
		         	 $ddrkof=1; //100%
		         	$str_rkf=round($str_rkf);
		         	 }
		         	elseif ($data_battle['status_flag']==4)
		         	{
		         	$ddrkof=1; //100%
		         	$str_rkf=round($str_rkf);
		         	}
				elseif (($all_p<5) and ( $data_battle['type']!=171 ) and ( $data_battle['type']!=40 ) and ( $data_battle['type']!=41 ))
				{
				         $ddrkof=0.1; //10%
				         $str_rkf=round(($str_rkf/10)/4);
				}
				else
				{
				        $ddrkof=1; //100%
			         	$str_rkf=round($str_rkf/4);
				}

				$str_rkf="(<a href=http://oldbk.com/encicl/?/rk_table.html target=_blank>�� {$str_rkf}%</a>)";
				///////////////////////////////////////////////////////////////////////////////////////////////////////////
			      if (($data_battle['type']==601) OR ( $data_battle['type']==602) OR ( $data_battle['type']==603) OR ( $data_battle['type']==604) )
			      	{
			      	$get_rex=round(($get_runs_exp['point']*$RKF)/$get_runs_exp['runs']);
			      	}
			      	elseif ($data_battle['teams']=='��� �����������' )
			      	{
			      	 $get_rex=round(((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof)/1.5);
			      	}
			      	elseif (($dragon_week==true) and ($data_battle['coment'] == "<b>��� � ������� ��������</b>" ) )
			      	{
			      	 $get_rex=round(((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof));
			      	}
			      	elseif (($data_battle['coment'] == "<b>����-����</b>" ) OR ($data_battle['type'] == 313) )
			      	{
			      	 $get_rex=round(((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof)/2);
			      	}
			      	elseif ( ($data_battle['coment'] == "<b>��� � �������</b>" ) OR ($data_battle['coment'] == "<b>��� � ������</b>" ) )
			      	{
			      	 $get_rex=round(((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof));
			      	}
			      	elseif ($data_battle['type'] == 61 ) // //����� �����
			      	{
			      	 $get_rex=round(((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof));
			      	}
				elseif ($data_battle['status_flag']==4)
		         	{
			    	 $get_rex=round(((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof));
		         	}
		         	else
		         	{
			    	 $get_rex=round(((($get_runs_exp['point']*$RKF)/$get_runs_exp['runs'])*$ddrkof)/4);
			    	}


		    	 	//�������� �� ���
		    	 	$rkm_msg='';
		    	 	$get_rex_rkm=0;
		    	 	if (($get_runs_exp['rkm_bonus']>0) and ($damexp['mag_damage'] >0) )
		    	 	{
			 	//��������� ���� ��� ����� ��������� � �������, �������� ��� ���� �� ���� � ����������� �� ���. ���
						$RKM_STR=4;
						    if (($data_battle['type']==601) OR ( $data_battle['type']==602) OR ( $data_battle['type']==603) OR ( $data_battle['type']==604) )
						      	{
							$get_rex_rkm=round(($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs']);
							$RKM_STR=1;
						      	}
						      	elseif ($data_battle['teams']=='��� �����������' )
						      	{
							$get_rex_rkm=round((($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs'])/1.5);
							$RKM_STR=1.5;
						      	}
						      	elseif (($data_battle['coment'] == "<b>����-����</b>" ) OR ($data_battle['type'] == 313) )
						      	{
							$get_rex_rkm=round((($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs'])/2);
							$RKM_STR=2;
						      	}
						      	elseif (($data_battle['coment'] == "<b>��� � �������</b>" ) OR ($data_battle['coment'] == "<b>��� � ������</b>" ) )
						      	{
							$get_rex_rkm=round((($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs']));
							$RKM_STR=1;
						      	}
						      	elseif ($data_battle['type'] == 61 ) // //����� �����
						      	{
							$get_rex_rkm=round((($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs']));
							$RKM_STR=1;
						      	}
							elseif ($data_battle['status_flag']==4)
					         	{
							$get_rex_rkm=round((($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs']));
							$RKM_STR=1;
					         	}
					         	else
					         	{
							$get_rex_rkm=round((($damexp['mag_damage']*(0.01*$get_runs_exp['rkm_bonus']))/$get_runs_exp['runs'])/4);
							$RKM_STR=4;
						    	}
		    	       }


				if ($get_rex_rkm>0)
				{

			   	 addchp ('<font color=red>��������!</font> �� �������� ��� ������ ����: '.$get_rex.' ������� ����� '.$str_rkf.' � '.$get_rex_rkm.' ������� ����� �� ���������� ���������� ���� � ��� (��� '.round($get_runs_exp['rkm_bonus']/$RKM_STR,2).'%). �����: '.($get_rex+$get_rex_rkm).' ������� ����� ��� ������ ����.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
				}
				else
				{
	   		    	addchp ('<font color=red>��������!</font> �� �������� '.$get_rex.' ����� ��� ������ ����. '.$str_rkf,'{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
	   		    	}
		    	}
   	    	     mysql_query("DELETE FROM `battle_runs_exp` WHERE `owner`='{$user['id']}' ");
    	     	}
	    	}

	        // ���� �� ������ (�.�. ��������� ��� �����)
     	    // ���������� ����� � ���
    	      $damexp=get_damexp($user['last_battle'], $user['id']);

    	      		require_once('config_ko.php');

			/* - ������ ��� ������� ���� ������ ��� ������
			if ((time()>$KO_start_time3) and (time()<$KO_fin_time3))
				{
				if (($user['lab']==0) AND ($user['in_tower']==0) AND ($damexp['damage']>=1) AND (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290)))
				 AND ( ( ($data_battle['type']!=1)	AND ($data_battle['type']!=4) AND ($data_battle['type']!=5) AND ($data_battle['type']!=15) )  OR  (($data_battle['CHAOS']>0) AND ($data_battle['type']!=5) ) ) )
				 	{
				 	mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`cbattle`=1,`tbattle`=NOW() ON DUPLICATE KEY UPDATE `cbattle`=`cbattle`+1,`tbattle`=NOW() ;");
				 	}

				 }
			*/

			if ((time()>$KO_start_time4) and (time()<$KO_fin_time4))
				{
				if (($user['lab']==0) AND ($user['in_tower']==0) AND ($damexp['damage']>=1) AND (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290)))
				 AND ( ( ($data_battle['type']!=1)	AND ($data_battle['type']!=4) AND ($data_battle['type']!=22)  AND ($data_battle['type']!=5) AND ($data_battle['type']!=15) )  OR  (($data_battle['CHAOS']>0) AND ($data_battle['type']!=5) ) ) )
				 	{
				 	mysql_query("INSERT INTO `oldbk`.`users_timer` SET `owner`='{$user['id']}',`cbattle`=1,`tbattle`=NOW() ON DUPLICATE KEY UPDATE `cbattle`=`cbattle`+1,`tbattle`=NOW() ;");
				 	}

				 }
			/*elseif ((time()>$KO_start_time5) and (time()<$KO_fin_time5))
				{
				//����� �������� ��� ��� ������������ ��� �����
					if ((($data_battle['CHAOS']>0) and ($data_battle['type']!=5) and ($data_battle['type']!=4) and ($data_battle['type']!=308) and ($data_battle['type']!=304)  and ($user['level']>3)) and ( $damexp['damage']>0) )
					{
					//���� ���� , ���� ��� ������ 3 � ��� ���� ���� ����
					mk_vduh($user);
       		       			//addchp('<font color=red>��������!</font> FINFO 2 : '.$user['battle'].' ���: '.$user['login'],'{[]}Bred{[]}',-1,0);
					}

				}*/




			  if ( $data_battle['win']!=0)
			  {
			  $EXP_LOSE=0;
				  //��������� � ��������� ��� ����� 0,5% ����
				  	if ((($data_battle['status_flag'] > 0) AND ($data_battle['status_flag']!=4) AND ($data_battle['status_flag']!=10)  )  )
					{

					if (($data_battle['type']==60) OR  ($data_battle['type']==61))
						{
							//��������� �����
							$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=10"));
							if ($get_ivent['stat']==1)
							{
							$arena_week=true; //�����������  ���� 0,75%
							$rrep=$damexp['exp']*0.0075;
							}
							else
							{
							$rrep=$damexp['exp']*0.005;
							}
						}
						else
							{
							$rrep=$damexp['exp']*0.005;
							}

					$rep_kof=$vinst_arr[$user['level']];
					if ($rep_kof>0) { $rrep=$rrep*$rep_kof; }


						if ($data_battle['type'] == 313)
						{
						if ($rrep>500) {$rrep=500;}
						if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
						$rrep=round($rrep);
						}
						elseif (($data_battle['coment'] == "<b>����-����</b>" )  )
						{
						if ($rrep>2000) {$rrep=2000;}
						if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
						$rrep=round($rrep);
						}
						elseif ($data_battle['type']==7)
						{
						//if ($rrep>250) {$rrep=250;}
								//��� �� ����� +100 ���� ����
								//if ($damexp['exp']>0) {$rrep+=100;}
						$rrep=0;
						}
						elseif ($data_battle['type']==8)
						{
						if ($rrep>200) {$rrep=200;}
						if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
						$rrep=round($rrep);
						}
						elseif ($data_battle['status_flag']==10)
						{
						$rrep=0;
						}
						else
						{
						if ($rrep>10000) {$rrep=10000;}
						if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
						$rrep=round($rrep);
						}

					$rrep=round($rrep*$user['rep_bonus']);
					$trrep=' �������� ���������: '.$rrep." (".(($user['rep_bonus']*100)+$prebonusp)."%) ";
					}
					else
					if ($data_battle['status_flag'] ==4 )
					{
					$rrep=$damexp['exp']*0.025;

					$rep_kof=$vinst_arr[$user['level']];
					if ($rep_kof>0) { $rrep=$rrep*$rep_kof; }

					if ($rrep>10000) {$rrep=10000;}

					if ($user['prem']>0) { $rrep=$rrep*1.1; $prebonusp=10; }
					$rrep=round($rrep);

					$rrep=round($rrep*$user['rep_bonus']);
					$trrep=' �������� ���������: '.$rrep." (".(($user['rep_bonus']*100)+$prebonusp)."%) ";

					}
					else { $trrep=''; }

			$pocent=(int)($user['expbonus']*100)-100;
			$pocent_telo_baza=$pocent;

			if (($data_battle['type']>=601) and ($data_battle['type']<=604) )
				{
				     $damexp['exp']=round($damexp['exp']);	//100% �� ����� ����������� ������� � ����� ������ ������ ��������
				     $EXP_LOSE=1;
				     $pocent+=100;
				}
			 else
			 // �� ����� �.�. ����������. 172 ��� - ����� ������ ����� ��������
			 if ((($data_battle['type']>240 ) and  ($data_battle['type'] <269)) || $data_battle['type'] == 172)
				{
					//��������� �����
					$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=4"));
					if ($get_ivent['stat']==1)
					{
					$addekof=1.5;
				     	$pocent+=150;
					}
					else
					{
					$addekof=1;
				     	$pocent+=100;
					}

				     $damexp['exp']=round($damexp['exp'] * $addekof );	//100% ��� 150 ���� ����� �� ����� ����������� ������� � ����� ������ ������ ��������
				     $EXP_LOSE=$addekof;
				}
			 	else
			 	if (($data_battle['type']==171))
				{
				     $damexp['exp']=round($damexp['exp']*0.3);	//30% �� ����� ����������� ������� � ����� ���� ����
				     $pocent+=30;
				     $EXP_LOSE=0.3;
				}
			 	else
			 	if (($data_battle['type']==7))
				{
				     $damexp['exp']=round($damexp['exp']*0.1);	//10% �� ����� ����������� �������
				     $pocent+=10;
     				     $EXP_LOSE=0.1;
				}
			 	else
				if (($data_battle['type']==60) OR  ($data_battle['type']==61))
				{
					if ($arena_week==true)
					{
					//���� ���������
					     $damexp['exp']=round($damexp['exp']*1.35);	//105% �� ����� ����������� ������� � ����� ���� ����
					     $pocent+=210;
	     				     $EXP_LOSE=1.35;
					}
					else
					{
					     $damexp['exp']=round($damexp['exp']*0.9);
	     				     $EXP_LOSE=0.9;
					     $pocent+=140;
					}

				}
				else
				if ($data_battle['status_flag']==1)
					{
					$damexp['exp']=round($damexp['exp']*0.2);
				        $pocent+=20;
					$EXP_LOSE=0.2;

				       if (($data_battle['blood']>0) or ($data_battle['coment']=='<b>����-����</b>') OR ($data_battle['type'] == 313)  )
					   {
					     $pocent=$pocent*2;
					   }

					}
				else
				if ($data_battle['status_flag']==10)
					{
					$damexp['exp']=round($damexp['exp']*0.1);
				        $pocent+=10;
					$EXP_LOSE=0.1;
					}
				else
				if ($data_battle['status_flag']==2)
					{
					$damexp['exp']=round($damexp['exp']*0.4);
				        $pocent+=40;
					$EXP_LOSE=0.4;

				       if (($data_battle['blood']>0) or ($data_battle['coment']=='<b>����-����</b>') OR ($data_battle['type'] == 313)  )
					   {
					     $pocent=$pocent*2;
					   }

					}
				else
				if (($data_battle['status_flag']==3) OR ($data_battle['type'] == 311) )
					{
					$damexp['exp']=round($damexp['exp']*0.6);
				        $pocent+=60;
					$EXP_LOSE=0.6;

				       if (($data_battle['blood']>0) or ($data_battle['coment']=='<b>����-����</b>')  )
					   {
					     $pocent=$pocent*2;
					   }

					}
				else
				if ($data_battle['status_flag']==4)
					{
					$damexp['exp']=round($damexp['exp']*3);
					$EXP_LOSE=3;
				        $pocent+=300;
					///�������������� ������� ��������� � ��������
					///���� ��� �������
					 if($user['align']==4) {
				      	$pocent=round($pocent*0.5);
			                    }
					///���� ��� ��������
					if (($data_battle['blood']>0) or ($data_battle['coment']=='<b>����-����</b>') OR ($data_battle['type'] == 313)  )
					   {
					     $pocent+=100; //+100% ���� ��� �������� � ������!
					   }
					///���� � ������
					if  ($data_battle['CHAOS']>0)
					    	{
					      	$pocent+=30;
					      	}
					      	//��������� ���
					      	else if ($data_battle['type']==2)
					      	{
					      	$pocent+=50;
					      	}
						////////////////////////
					}
				elseif ($EXP_TO_LOSE==1)
				    {
					$damexp['exp']=round($damexp['exp']*0.1);
					$EXP_LOSE=0.1;
					$pocent+=10;
				}
				else
				{
					$damexp['exp']=0;
					$pocent=0;
					$EXP_LOSE=0;
				}

				$_SESSION['get_exp']=$damexp['exp'];//�������� � ������


			if(time()>mktime(0,0,0,12,11,2018) && time()<mktime(23,59,59,12,12,2018))
			{
			     $pocent+=100; //+100%
			}

				//�������� �������� � ��������� http://tickets.oldbk.com/issue/oldbk-278
				$trrep=''; //[10:54:26] Deni: � ����, ���������, �� ������ ���� ���, ��� �� ��� ������� ���� ��� ���������
				addchp ('<font color=red>��������!</font> ��� �������. ����� ���� �������� ����� '.$damexp['damage'].' HP. �������� ����� '.$damexp['exp'].' ('.$pocent.'%)'.'. '.$trrep.'  ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);

	  	    	    	 //�������� ��� �������� � ������� �� ������� ���� ����
		    	      	$naem=mysql_fetch_array(mysql_query("select * from users_clons where owner='{$user['id']}' and naem_status=1 and last_battle='{$data_battle['id']}' limit 1;"));
	    	      		if ($naem['id']>0)
	    	      			{
	    	      			//��� � ��� ���� ��������
	    	      			$get_naem_exp=mysql_fetch_array(mysql_query("select * from battle_dam_exp where owner='{$naem['id']}' and battle='{$data_battle['id']}' limit 1"));
					$naem_dmg=0;
	    	      			$naem_exp=0;
		      				if ($get_naem_exp['id']>0)
		      				{
						$naem_dmg=$get_naem_exp['damage'];
		    	      			//$naem_exp=$get_naem_exp['exp'];
		      				}

		      			//% �� ���� ���
		      			//$naem_exp=round($naem_exp*$EXP_LOSE);
		      			//$pocent_naem=$pocent-$pocent_telo_baza+(round($naem['expbonus']*100)-100); // �������� ��������
		      			$pocent_naem=0;

				        addchp ('<font color=red>��������!</font> ��� �������. ����� ����� ��������� <b>'.$naem['login'].'</b> �������� ����� '.$naem_dmg.' HP. �������� ����� '.$naem_exp.' (<b>'.$pocent_naem.'%</b>)'.'.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
					if ($naem_exp>0)
						{
						lvl_up_naem($user,$naem);
						}
					mysql_query("DELETE from battle_dam_exp WHERE  owner='{$naem['id']}'");  // ������
	    	      			}


			  }
			  else
			  {
			 //
			 		$_SESSION['get_exp']=0;//�������� � ������
					addchp ('<font color=red>��������!</font> ��� ������� ������. ����� ���� �������� ����� '.$damexp['damage'].' HP. �������� ����� 0   ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);

		  	    	    	 //�������� ��� �������� � ������� �� ������� ���� ����
			    	      	$naem=mysql_fetch_array(mysql_query("select * from users_clons where owner='{$user['id']}' and naem_status=1 and last_battle='{$data_battle['id']}' limit 1;"));
		    	      		if ($naem['id']>0)
		    	      			{
		    	      			//��� � ��� ���� ��������
		    	      			$get_naem_exp=mysql_fetch_array(mysql_query("select * from battle_dam_exp where owner='{$naem['id']}' and battle='{$data_battle['id']}' limit 1"));
						$naem_dmg=0;
		    	      			$naem_exp=0;
			      				if ($get_naem_exp['id']>0)
			      				{
							$naem_dmg=$get_naem_exp['damage'];
			    	      			$naem_exp=0;
			      				}
					        addchp ('<font color=red>��������!</font> ��� �������. ����� ����� ��������� <b>'.$naem['login'].'</b> �������� ����� '.$naem_dmg.' HP. �������� ����� '.$naem_exp.'.','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
						mysql_query("DELETE from battle_dam_exp WHERE  owner='{$naem['id']}'");  // ������
		    	      			}

			  }
	     }

	     //���� �� �������
		if  (($data_battle['coment']=='<b>��� � �������</b>') and ($damexp['damage'] >0) )
		{
			/*
		     ���� ������� http://i.oldbk.com/i/sh/friday.gif, ���� 25% (������� 1 ����� �������), �������� �� �������, ���� �������� 180����, �������� ��������:
		     PROTO_ID:33008 ����, ���� ����� 25% (������� 1 ����� �������), �������� �� �������
		     */
			if (mt_rand(0,100)<25)
			{
				put_bonus_item(12001, $user, '�������');
			}
			elseif (mt_rand(0,100)<25)
			{
				put_bonus_item(33008, $user, '�������');
			}
		}
		elseif  (($data_battle['coment']=="<b>��� � ������</b>") and ($damexp['damage'] >0) )
		{
		     	$TKV_RND=mt_rand(1,100);
			if ($TKV_RND>=50) //			� 50% 2017101 ����������� ����� tykva2017_0.gif
			{
				put_bonus_item(2017101, $user, '�����');
			}
			elseif ($TKV_RND>=35) // 			� 35% 2017102 ����������� ����� tykva2017_1.gif
			{
				put_bonus_item(2017102, $user, '�����');
			}
			else 		//� 15% 2017103 ����������� ����� tykva2017_2.gif
			{
				put_bonus_item(2017103, $user, '�����');
			}
		}

	  if ( (($data_battle['coment']=='<b>��� � ������� ��������</b>') OR ($data_battle['type'] == 312))  and ($damexp['damage'] >0) and ($data_battle['win']==$user['battle_t']) )
	  {
	  $rand_ok=1;

	  	 if ($data_battle['type'] == 312)
	  	 	{
	  	 	//������� - ��������� ���� ��������� ����� �� 50% �� �������� ��������
	  	 	$rand_ok=mt_rand(0,1);
	  	 	}
		if ($rand_ok==1)
		{
		$item_4016_ch=1;
			     /*
				�������� ���� ��������� ����� � ���� � ���������, ��� �������
			     ������ ���������
			     ���� ��� ������� ����
			     �����! �� ���� ��� �������� �� ����� ������ �������� ����� ����� �� ���������.
				*/

				/*
					http://tickets.oldbk.com/issue/oldbk-2460
					������ ���� ��������� �������� � ����� PROTO_ID:4016 � ������ �������� 10%
				*/
				if ($dragon_week==true)
					{
					//	$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=14"));
					//������ ����� ��������
					//	if ($get_ivent['stat']==1)
						$item_4016_ch=10;
					}



				/*
					http://tickets.oldbk.com/issue/oldbk-2596
					1) ������ �� ����� �������� ��������� �����
					- ����� ���� ������� PROTO_ID:33052
					- ������� ���� ������� PROTO_ID:33053
					- ����� ���� ������� PROTO_ID:33054
					- ������� ���� ������� PROTO_ID:33055

				if (mt_rand(0,100)<=1)
				{
				put_bonus_item(33052, $user, '�����'); //	�� �������� ���� �������-����� ���� ������� (��� ������� - 33052) - ���� 2%
				}
				else*/

				if (mt_rand(0,100)<=$item_4016_ch)
				{
				put_bonus_item(4016, $user, '�����'); //	������ � ������ 1% ���� ������� � ����� �� �������� ��� ������ 0/1 ��, ���� �������� 7 ����, �������� �� �����
				}
				/*elseif (mt_rand(0,100)<=1)
				{
				put_bonus_item(33053, $user, '�����');//�� �������� ���� �������-   ������� ���� ������� (��� ������� - 33053) - ���� 1%
				}
				*/

				elseif ( (mt_rand(0,100)<=5) and ( ($user['level']>=7) and ($user['level']<=12)) )
				{
					/*
					2. ��� ���������� 7-�� ������: ���� ������� [7] 33037 - ���� 10%
					3. ��� ���������� 8-�� ������: ���� ������� [8] 33038 - ���� 10%
					4. ��� ���������� 9-�� ������: ���� ������� [9] 33039 - ���� 10%
					5. ��� ���������� 10-�� ������: ���� ������� [10] 33040 - ���� 10%
					6. ��� ���������� 11-�� ������: ���� ������� [11] 33041 - ���� 10%
					7. ��� ���������� 12-�� ������: ���� ������� [12] 33042 - ���� 10%
					*/
					$cfgd=array(7=>33037,8=>33038,9=>33039,10=>33040,11=>33041,12=>33042);
					$cfgid=$cfgd[$user['level']];
					put_bonus_item($cfgid, $user, '�����');
				}
				elseif ( (mt_rand(0,100)<=2) and ($user['level']>=13) )
				{
					put_bonus_item(33051, $user, '�����'); //��� ���������� 13/14-�� ������: ���� ������� [12] 33051 - ���� 5%
				}
		}
	}
			 log_php_memory('before new quest');
	     //���� ��� �� ����� + �����
	    if (($data_battle['type']==61) OR ($data_battle['type']==60) OR ($data_battle['type']==62) )
	     {
	     	require_once('config_ko.php');

			if ((time()>$KO_start_time17-14400) and (time()<$KO_fin_time17-14400))
			{

	       		 $info_delo=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.new_delo where owner='{$user['id']}' and battle={$data_battle['id']} and type=1515 ; "));
     	   		 $out_delo_type[1515]="�� �������� {$info_delo['sum_kr']} ��. � �������� �{$info_delo['battle']}";
			 if ( ($out_delo_type[$info_delo['type']]) AND ($info_delo['sum_kr']>0) )
			 	{
 		     			 addchp ('<font color=red>��������!</font> '.$out_delo_type[$info_delo['type']].'','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
			 	}
			 }
	     }

	     //��� �� ����� ���� ����� �����: ���� �������� �����
	     if (($data_battle['type']==61) OR ($data_battle['type']==60) OR ($data_battle['type']==62) )
	     {

		if (get_chance(get_chance_point($user,$damexp,$get_runs_exp)))
			{
				$agoden=90;
				$adategoden=$agoden*24*60*60+time();
				put_bonus_item(4016, $user, '�����',array(),array('notsell'=>1  , 'goden' => $agoden, 'dategoden' => $adategoden));
			 }

	     }


		  if ( ($data_battle['type'] ==11) or ($data_battle['type'] ==12) or ($data_battle['type']==308) or ($data_battle['type']==304)  or (($data_battle['coment']=='��� �����������') and ($data_battle['type']==3) ) )
  			{
  			///���� ���������� ��������
	  			//����� ���������� �������
	  			/*
	  			��������� ����, �������� �� �����, ���� �������� 7 ����
				������ �� ������� � ������, ������� ��������� �������� (����� �� 2 �����), ������� ��,
				���� �������� = 50%, ��������� ������ ���, � ���� ������� ����� �3.  */
				if(get_chance(50)) {
					try {
						$User = new \components\models\User($user);
						/** @var \components\Component\Quests\Quest $Quest */
						$Quest = getQuestComponent($User);

						$Checker = new \components\Component\Quests\check\CheckerDrop();
						$Checker->item_id = 3003224;
						$Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;

						if(($Item = $Quest->isNeed($Checker)) !== false && $Quest->taskUp($Item) !== false) {
							put_bonus_item(3003224, $user, '�����');
						}
					} catch (Exception $ex) {
						$app->logger->emergency($ex);
					}
					unset($User);
				}

  			}
			elseif ($data_battle['coment']=='<b>����-����</b>') 	 // ��� �� �����������
			{
				/*
				4) ���������� ����������
				��������� ����, �������� �� �����, ���� �������� 7 ����
				������ �� ���� �� �����������, ���������� �� ������/���������, ���� ����� =70%,
				*/

				//if(get_chance(70)) {
				if (true) {
					try {
						$User = new \components\models\User($user);
						/** @var \components\Component\Quests\Quest $Quest */
						$Quest = getQuestComponent($User);

						$Checker = new \components\Component\Quests\check\CheckerDrop();
						$Checker->item_id = 3003225;
						$Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;

						if(($Item = $Quest->isNeed($Checker)) !== false && $Quest->taskUp($Item) !== false) {
							put_bonus_item(3003225, $user, '�����');
						}
					} catch (Exception $ex) {
						$app->logger->emergency($ex);
					}
					unset($User);
				}
			}

			$condition_list = array(
				'fight_align' 	=> ($data_battle['type']==3 && $data_battle['coment']=='��� �����������'),
				'fight_haos' 	=> (strpos($data_battle['t2hist'], '������� �����') !== false),
				'fight_dragon' 	=> (strpos($data_battle['t2hist'], '������') !== false),
				'fight_auto' 	=> ($data_battle['coment']=='<b>#zlevels</b>'),
				'fight_kucha' 	=> ($data_battle['coment']=='<b>����-����</b>'),
				'fight_elka' 	=> ($data_battle['type']==7),
				'fight_arena'	=> (in_array($data_battle['type'], array(60, 61, 62))),
				'fight_zaga'	=> (in_array($data_battle['type'], array(13, 14, 15))),
				'fight_cp'		=> ($data_battle['coment']=='<b>��� �� ����������� �������</b>'),
				'fight_flower'	=> ($data_battle['type']==8),
				'fight_fiz'		=> ($data_battle['type']==1),
				'fight_ruine_sokra' => ($data_battle['type']==12 && $data_battle['coment']=='��� � ������ �� ���������'),
		 		'fight_laba' 	=> ($data_battle['type']==30 && $data_battle['coment']=='��� � ��������� �����'), //Type:30 / Coment: ��� � ��������� �����
				'fight_bs'		=> ($data_battle['type']==1010 && $data_battle['coment']=='��� � ����� ������'),
				'fight_ruine'	=> ($data_battle['type']==11 && $data_battle['coment']=='��� � ������'),
			);

			 try {
				 $Battle = new \components\models\Battle($data_battle);
				 $Battle->user_damage = $damexp['damage'];
				 $app->applyHook('fight.user.finished', $user, $Battle);
			 } catch (Exception $ex) {
			     $app->logger->emergency($ex);
			 }

			 /*if(check_fight_condition(array(
			 	'fight_fiz','fight_flower','fight_align','fight_cp',
				 'fight_zaga',
				 'fight_bs',
				 //'fight_laba',
				 'fight_auto','fight_arena','fight_elka','fight_ruine_sokra',
				 'fight_ruine', 'fight_haos', 'fight_kucha', 'fight_dragon'), $condition_list)) {
				 try {
					 $User = new \components\models\User($user);
					 $Quest = getQuestComponent($User);

					 $Checker = new \components\Component\Quests\check\CheckerFight();
					 $Checker->damage = $damexp['damage'];
					 $Checker->is_win = $data_battle['win'] == $user['battle_t'];
					 $Checker->fight_type = $data_battle['type'];
					 $Checker->fight_comment = $data_battle['coment'];
					 $Checker->battle = new \components\models\Battle($data_battle);
					 if (($Item = $Quest->isNeed($Checker)) !== false) {
						 $Quest->taskUp($Item);
					 }

					 unset($Checker);
					 unset($User);
				 } catch (Exception $ex) {
					 \components\Helper\FileHelper::writeException($ex, 'fbattle');
				 }
			 }*/

			 //region drop
			 if(check_fight_condition(array('fight_auto', 'fight_elka'), $condition_list) && get_chance(50)) {
				 try {
					 $User = new \components\models\User($user);
					 /** @var \components\Component\Quests\Quest $Quest */
					 $Quest = getQuestComponent($User);
					 if($Quest->haveQuest(64)) {
						 put_bonus_item(3003223, $user, '�����');
					 }
				 } catch (Exception $ex) {
					 \components\Helper\FileHelper::writeException($ex, 'fbattle');
				 }
				 unset($User);
			 }
			 //endregion drop

			 if(check_fight_condition(array('fight_align', 'fight_haos', 'fight_dragon', 'fight_auto', 'fight_kucha'), $condition_list)) {
					try {
						$User = new \components\models\User($user);
						/** @var \components\Component\Quests\Quest $Quest */
						$Quest = getQuestComponent($User);
						if($Quest->havePart(19, 27)) {
							$_chance = array(
								'fight_align' 	=> 90, //80
								'fight_haos' 	=> 90, //50
								'fight_dragon' 	=> 90, //80
								'fight_auto' 	=> 25, //15
								'fight_kucha' 	=> 90, //50
							);

							foreach ($_chance as $_f_type => $_chance_value) {
								if(!isset($condition_list[$_f_type])
									|| $condition_list[$_f_type] == false
									|| !get_chance($_chance_value)) {
									continue;
								}

								$Checker = new \components\Component\Quests\check\CheckerDrop();
								$Checker->item_id = 506608;
								$Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
								if (($Item = $Quest->isNeed($Checker)) !== false) {
									$Quest->taskUp($Item);
									put_bonus_item(506608, $user, false, array(
										'target_login' 	=> '�����',
										'add_info' 		=> '������� ������',
										'type'			=> 253
									));
								}
								unset($Checker);
							}
						}
						unset($User);

					} catch (Exception $ex) {

					}
			 }

			 if(check_fight_condition(array('fight_auto'), $condition_list)) {
				 try {
					 $User = new \components\models\User($user);
					 /** @var \components\Component\Quests\Quest $Quest */
					 $Quest = getQuestComponent($User);
					 if($Quest->havePart(19, 28)) {
						 $_fight_hit = mysql_fetch_assoc(mysql_query(sprintf('select dcount from battle_dam_exp where owner = %d', $User->id)));

						 $Checker = new \components\Component\Quests\check\CheckerEvent();
						 $Checker->event_type = \components\Component\Quests\pocket\questTask\EventTask::EVENT_FIGHT_HIT;
						 $Checker->count = isset($_fight_hit['dcount']) ? $_fight_hit['dcount'] : 0;

						 $Battle = new \components\models\Battle($data_battle);
						 $Battle->damage = $damexp['damage'];
						 $Battle->is_win = $data_battle['win'] == $user['battle_t'];

						 $Checker->battle = $Battle;
						 if ($Checker->count > 0 && ($Item = $Quest->isNeed($Checker)) !== false) {
							 $Quest->taskUp($Item);
						 }
						 unset($Checker);
					 }
					 unset($User);

				 } catch (Exception $ex) {

				 }
			 }

			 $fight_for_drop_condition = ((in_array($data_battle['coment'], array('<b>��� � ������� ��������</b>', '<b>����-����</b>')))
			 	|| ($data_battle['type']==8))
			 ;
			 if ( $fight_for_drop_condition )
			 {

				 try {
					 $User = new \components\models\User($user);
					 /** @var \components\Component\Quests\Quest $Quest */
					 $Quest = getQuestComponent($User);

					 switch (true) {
						 case ($data_battle['coment'] == '<b>��� � ������� ��������</b>' && $data_battle['win'] == $user['battle_t'] && $damexp['damage'] >= 1 && $Quest->haveQuest(5)):
							 $_condition_list = array(
								 75 => true,
								 50 => $damexp['damage'] > $user['maxhp'], //���� ����� ������� ������ ����
								 25 => $get_runs_exp['point'] > 0 //���� ���� ������������ �����
							 );

							 $_drop_items = array(505501, 505502, 505503, 505504, 505505);
							 shuffle($_drop_items);
							 foreach ($_condition_list as $_chance => $_value) {
								 if ($_value === false) {
									 continue;
								 }

								 if (get_chance($_chance)) {
									 $_drop_item_id = array_shift($_drop_items);
									 $Checker = new \components\Component\Quests\check\CheckerDrop();
									 $Checker->item_id = $_drop_item_id;
									 $Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
									 if (($Item = $Quest->isNeed($Checker)) !== false && $Quest->taskUp($Item) !== false) {
										 put_bonus_item($_drop_item_id, $user, '�����');
									 }
									 unset($Checker);
								 }
							 }

						 case (in_array($data_battle['coment'], array('<b>��� � ������� ��������</b>', '<b>����-����</b>')) && ($Quest->haveQuest(15) || $Quest->haveQuest(51))):
							 $Checker = new \components\Component\Quests\check\CheckerDrop();
							 $Checker->item_id = 16022;
							 $Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
							 if (($Item = $Quest->isNeed($Checker)) !== false) {
								 $Quest->taskUp($Item);
								 put_bonus_item(16022, $user, false);
							 }
							 unset($Checker);

						 case ($data_battle['type']==8 && $Quest->haveQuest(7)):
							 $_drop_items = array(506601, 506602, 506603, 506604, 506605, 506606, 506607);
							 shuffle($_drop_items);
							 $_drop_item_id = array_shift($_drop_items);
							 $Checker = new \components\Component\Quests\check\CheckerDrop();
							 $Checker->item_id = $_drop_item_id;
							 $Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
							 if (get_chance(75) && ($Item = $Quest->isNeed($Checker)) !== false) {
								 $Quest->taskUp($Item);
								 put_bonus_item($_drop_item_id, $user, '����������');
							 }
							 unset($Checker);

					 }

					 unset($User);
				 } catch (Exception $ex) {
					 \components\Helper\FileHelper::writeException($ex, 'fbattle');
				 }
			 }

			 $condition_ruine_fight = ($data_battle['comment'] == '��� � ������' || $data_battle['type'] == 11);
			 if($condition_ruine_fight) {
				 try {
					 $isDusha = (strpos($data_battle['t1hist'], '��������� �y�a') !== false
						 || strpos($data_battle['t2hist'], '��������� �y�a') !== false);
					 if($damexp['damage'] >= 1 && $isDusha) {
						 $Checker = new \components\Component\Quests\check\CheckerDrop();
						 $Checker->item_id = 506600;
						 $Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;

						 $User = new \components\models\User($user);
						 $Quest = getQuestComponent($User);
						 if($Quest->havePartNumber(4, 1) && ($Item = $Quest->isNeed($Checker)) !== false && get_chance(50)) {
							 $Quest->taskUp($Item);
							 put_bonus_item(506600, $user, '��������� ����');
						 }
						 unset($Checker);
					 }
				 } catch (Exception $ex) {
					 \components\Helper\FileHelper::writeException($ex, 'fbattle');
				 }
			 }
			 log_php_memory('after new quest');


	     	if ($data_battle['type'] == 7 || $data_battle['comment'] == '<b>#zelka</b>') {

			if ($damexp['damage'] >= 1 && $data_battle['win'] == $user['battle_t']) {

				// ������� �������
				$qicount = 0;

				$q = mysql_query('SELECT count(id) AS icount FROM inventory WHERE owner = '.$user['id'].' AND battle = '.$data_battle['id'].' and type != 30');
				if ($q) {
					$qicount = mysql_fetch_assoc($q);
					$qicount = $qicount['icount'];
				}

				if ($qicount >= 13) {
					$q = mysql_query('SELECT * FROM ny_quest_var WHERE owner = '.$user['id'].' and var = "q1"');
					$questinfo = mysql_fetch_assoc($q);

					if ($questinfo['val'] >= 24) {
						// �����������
						$_SESSION['ny_quest_q1'] = 1;
						mysql_query('DELETE FROM ny_quest_var WHERE owner = '.$user['id'].' and var = "q1"');

						// ����� �������
						addchp ('<font color=red>��������!</font> �� ���������� ������ �� �������� 6000 ��������� � ������� "��������� �����"!','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);

			          		mysql_query("UPDATE users SET  `rep`=`rep`+6000, `repmoney` = `repmoney` + 6000  where `id`='{$user['id']}'");

		                		$rec['owner'] = $user['id'];
						$rec['owner_login'] = $user['login'];
						$rec['owner_balans_do'] = $user['money'];
						$rec['owner_balans_posle'] = $user['money'];
						$rec['owner_rep_do'] = $user['repmoney'];
						$user['repmoney'] += 6000;
						$rec['owner_rep_posle'] = $user['repmoney'];
						$rec['target']=0;
						$rec['target_login']="������";
						$rec['type']=182;//���� �� �����
						$rec['sum_kr']=0;
						$rec['sum_ekr']=0;
						$rec['sum_rep']=6000;
						$rec['sum_kom']=0;
						$rec['add_info']="������� �������";
						add_to_new_delo($rec);

						$dress = mysql_fetch_assoc(mysql_query('SELECT * FROM shop WHERE id = 545'));

						$godenmax = mktime(23,59,59,02,28,2019);
						if (time()+24*3600*7 >= mktime(23,59,59,02,28,2019)) {
							$godentime = mktime(23,59,59,02,28,2019);
						} else {
							$godentime = time()+24*3600*7;
						}

						$godendate = ceil(($godentime-time())/24/3600);

						mysql_query('INSERT INTO oldbk.`inventory`
							(`present`,`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`duration`,`maxdur`,`isrep`,
								`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,
								`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`
								,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
								`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,
								`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`bs_owner`,`group`, `letter`, `gmp`, `includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`gmeshok`,`tradesale`,`bs`,`idcity`
							)
								VALUES	(
									"�����",
									'.$dress['id'].',
									"'.$user['id'].'",
									"'.mysql_real_escape_string($dress['name']).'",
									'.$dress['type'].',
									"'.$dress['massa'].'",
									"'.$dress['cost'].'",
									"'.$dress['ecost'].'",
									"'.mysql_real_escape_string($dress['img']).'",
									'.$dress['duration'].',
									'.$dress['maxdur'].',
									'.$dress['isrep'].',
									'.$dress['gsila'].',
									'.$dress['glovk'].',
									'.$dress['ginta'].',
									'.$dress['gintel'].',
									'.$dress['ghp'].',
									'.$dress['gnoj'].',
									'.$dress['gtopor'].',
									'.$dress['gdubina'].',
									'.$dress['gmech'].',
									'.$dress['gfire'].',
									'.$dress['gwater'].',
									'.$dress['gair'].',
									'.$dress['gearth'].',
									'.$dress['glight'].',
									'.$dress['ggray'].',
									'.$dress['gdark'].',
									'.$dress['needident'].',
									'.$dress['nsila'].',
									'.$dress['nlovk'].',
									'.$dress['ninta'].',
									'.$dress['nintel'].',
									'.$dress['nmudra'].',
									'.$dress['nvinos'].',
									'.$dress['nnoj'].',
									'.$dress['ntopor'].',
									'.$dress['ndubina'].',
									'.$dress['nmech'].',
									'.$dress['nfire'].',
									'.$dress['nwater'].',
									'.$dress['nair'].',
									'.$dress['nearth'].',
									'.$dress['nlight'].',
									'.$dress['ngray'].',
									'.$dress['ndark'].',
									'.$dress['mfkrit'].',
									'.$dress['mfakrit'].',
									'.$dress['mfuvorot'].',
									'.$dress['mfauvorot'].',
									'.$dress['bron1'].',
									'.$dress['bron2'].',
									'.$dress['bron3'].',
									'.$dress['bron4'].',
									'.$dress['maxu'].',
									'.$dress['minu'].',
									'.$dress['magic'].',
									'.$dress['nlevel'].',
									'.$dress['nalign'].',
									"'.$godentime.'","'.$godendate.'",
									'.$dress['razdel'].',
									"0",
									'.$dress['group'].',"'.mysql_real_escape_string($dress['letter']).'",0,0,0,0,"",0,0,0,"0",'.$user['id_city'].'
							)
						');

					} else {
						// ��������� �������
						mysql_query('UPDATE ny_quest_var SET val = val + 1 WHERE owner = '.$user['id'].' and var = "q1"');
					}
				}


			}
		}

	     /////////////��������� ������� �����
	                if($last_q) //���� ������ �����
			{
				//addchp ('<font color=red>��������!</font> �������: '.$_SESSION[uid].'-'.$user['id'].';','{[]}A-Tech{[]}');
         		//echo '�� ������� <br>';
                	// ��� ������� ������� � ���. ������ ��� ����� - ������� ��� �������� �����.

			if  ($data_battle['type']==304  OR $data_battle['type']==308)     //���������, ���������� - �����
	                {
	                	if ( ($damexp['damage']>=1) AND ($data_battle['win']==$user['battle_t']) )
	                //������ � ��������� ��������
	                	{
	                	quest_check_type_20($last_q,$_SESSION['uid'],'ON',6); // ����� ����� 105
	                	}
	                	//addchp('<font color=red>��������!</font> ���������, '.$cityname.' ����:'.$user['id'].'  ��� ���:'.$data_battle['type'].' ID ���:'.$data_battle['id'],'{[]}Bred{[]}',-1,0);
	                }

	               else
	                if($data_battle['type']==61)  //��� �� ����� �����. � ���� ����
	                {
		                if ($damexp['damage']>=1)
		                {
	                	quest_check_type_20($last_q,$_SESSION['uid'],'ON',61);
	                //	addchp ('<font color=red>��������!</font> 61','{[]}A-Tech{[]}');
	          		//echo '61<br>';
	          		}
	                }
			else
	                if($data_battle['type']==2 && $data_battle['exp']!='')
	                {
	                    quest_check_type_20($last_q,$_SESSION['uid'],'ON',13); //������������. ������� �������.
	                //    addchp ('<font color=red>��������!</font> 13','{[]}A-Tech{[]}');
	           			//echo '13<br>';
	                }
			else
	                if ($data_battle['CHAOS']>0 and $data_battle['type']!=5 and $data_battle['type']!=4 and $user['level']>3 and $data_battle['coment'] != '��� � �������� �����' and $data_battle['coment'] != '<b>��� � ����� �������</b>'    )
	        	{
				if($data_battle['type']>=211 && $data_battle['type']<290)
				{
				 //�������� � ����������
				}
				else if (($data_battle['type']!=5) and ($data_battle['type']!=4) )
				{
			        //���� �� ����� ( ������)

					if ($get_var['napal']==0 && $damexp['damage']>=1)
					{
					        quest_check_type_20($last_q,$_SESSION['uid'],'ON',11); //����� ����
				        }


        			}
          		}

	          	if($data_battle['status_flag']>0 && $data_battle['coment'] != '��� � �������� �����' && $data_battle['coment'] != '<b>��� � ����� �������</b>')
	          	{
	          		//������� � ����� ��������� ���
	          		quest_check_type_20($last_q,$_SESSION['uid'],'ON',4); //����� ���������
	          	}

	            }
	     ///////////////////////////////

	     //�� ������������
	     //���� ���� ���� � ������
	     //
	     // ������ +1 ���� � ����� ��������
	     /*
	     if (time()<mktime(23,59,59,5,4,2016) ) // [11:57:34] �������: ���� �� ������� �� ������ ������ 4 ��� ��������
		{
		     if  (($damexp['damage'] >=1 ) and ($data_battle['coment']=='<b>����-����</b>') and ($data_battle['win'] == $user['battle_t']) and (mt_rand(1,100)<=5) )
		     	{
				mysql_query("UPDATE users SET  `znak`=`znak`+1  where `id`='{$user['id']}' ; ");
				if (mysql_affected_rows()>0)
				{
													$rec['owner']=$user['id']; $rec['owner_login']=$user['login'];
													$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];
													$rec['target']=0;$rec['target_login']='���';
													$rec['type']=6044;
													$rec['item_id']='proto:404400';
													$rec['item_name']='���� �����';
													$rec['item_count']=1;
													$rec['item_type']=0;
													$rec['item_maxdur']=1;
													$rec['battle']=$data_battle['id'];
													$rec['add_info']='������ ��:'.$user['znak']." / �����:".($user['znak']+1).' ������ �����';
													add_to_new_delo($rec);
				addchp ('<font color=red>��������!</font> �� �������� <b>����� ������</b> �1 ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
				}
		     	}
		}
		*/


	      	/////////////////
		 //��������� ������ ������� �����';
    	 	 if ( ($data_battle['win'] == $user['battle_t']) and ($data_battle['type']==11 OR $data_battle['type']==12) ) // ������ ������ ��� ��������� ������ ������� �����';
    	 	 {
//addchp('<font color=red>��������!</font> FINFO R1 '.$user['battle'].' ���: '.$user['login'],'{[]}Bred{[]}',-1,0);
    	 	 			 $CARD_DROP_CHANSE=15;
					 if ($data_battle['type'] == 12)
					 	{
				     	  	$CARD_DROP_CHANSE=25;
				     	  	}

			     	  	if (mt_rand(1,100)<$CARD_DROP_CHANSE)
			     	  		{
			     	  		$cardid=mt_rand(114001,114008);
				     	  	DropBonusItem($cardid,$user,"�����","��������� �4: ������ ������� �����",0,1,20,true);
				     	  	}


    	 	 }

	     //���� �� ��� ���� �� ���� � �� ��
//echo "DD1";
	     if ((($data_battle['type']!=30) and ($data_battle['type']!=1010) and ($data_battle['type']!=10) AND ($data_battle['type']!=11) and ($data_battle['type']!=12) and ($data_battle['type']!=22) and ($data_battle['type']<50)) OR ($data_battle['type'] == 312))  //��� ��� ����� �������
	     	{
//echo "DD2";
		 if (($data_battle['coment']=='<b>��� � ������� ��������</b>') OR ($data_battle['type'] == 312))
		 {
		 //���������� ���� �� ��������
		  include("fdroplist_dragon.php");
		 }
		else
		 {

		 //���������� ����� 848
	 	$get_848_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user['id']}'  and type='848' ; "));

		 if (($get_848_baff['id']>0) and ($get_848_baff['lastup']<10) && $user['in_tower'] == 0)
		 	{
				     	 include("fdroplist848.php"); //$items[]

		 	}
			else
			{
					 //�����������  ����
				     	 include("fdroplist.php"); //$items[]
				   //  include("fdroplist_sneg.php");
			}
	     	 }

	     	 if ($DROP != 'true')
	     	 {
	     	 //���� �� ����� �� ������� ���� - �� ������� ���������� ���� �� ������� ����� - ������ �����
		     	 if (( ($data_battle['type']!=30) and ($data_battle['type']!=10) and ($data_battle['type']!=1010) ) AND ($data_battle['CHAOS']>0) ) // �����
			{
				if ($data_battle['coment'] != '<b>��� � ������� ��������</b>') {
				  	include("fdroplist_sneg.php");

				}
			}
		 }



    	 	     	 if (($DROP!='true') and ($data_battle['type']==1) and ($data_battle['win']==1) and ($user['level']>=2) and ($user['level']<=7) and (strpos($data_battle['t2'],';') === false) and   ($data_battle['t2']> _BOTSEPARATOR_ ) )
    	 	     	 {
    	 	     	 //��� ������ ������� = ������ ������
			 include("fdroplist_noob.php");
    	 	     	 }


			if (($data_battle['CHAOS']>0) and ($data_battle['type'] == 3) OR ($data_battle['type'] == 2)  OR ($data_battle['type'] == 8) OR ($data_battle['type'] == 7) )
		     	  {
		     	  //����+ ���������
			     	  include("fdroplist_cards.php");
			     	  if ( ($DROP_CARDS==true) and ($user['level'] >=$CARD_MIN_DROP_LEVEL) and  ($damexp['damage'] >=$CARD_MIN_DROP_DM ) and ($damexp['exp'] >= $CARD_MIN_DROP_EXP ) )
			     	  {
			     	  	if (mt_rand(1,100)<$CARD_DROP_CHANSE)
			     	  		{
			     	  		$ke=mt_rand(0,8);
			     	  		$param=$carditems[$ke];
			     	  		 if ($param['shop']=='') { $param['shop']='shop'; }
						DropBonusItem($param['id'],$user,$param['present'],'',0,1,20,true,true,60,$param['shop'],false,$data_battle['id']);
			     	  		}
			     	  }
		     	 }


			if ( ($data_battle['type'] == 61) OR  ($data_battle['teams']=='��� �����������')  )
		     	  {
		     	  //
			     	  include("fdroplist_cards.php");
			     	  if ( ($DROP_CARDS2==true) and ($user['level'] >=$CARD2_MIN_DROP_LEVEL) and  ($damexp['damage'] >=$CARD2_MIN_DROP_DM ) and ($damexp['exp'] >= $CARD2_MIN_DROP_EXP ) )
			     	  {
			     	  	if (mt_rand(1,100)<$CARD2_DROP_CHANSE)
			     	  		{
			     	  		$ke=mt_rand(0,2);
			     	  		$param=$carditems2[$ke];
			     	  		 if ($param['shop']=='') { $param['shop']='shop'; }
		     	      	  	         DropBonusItem($param['id'],$user,$param['present'],'',0,1,20,true,true,60,$param['shop'],false,$data_battle['id']);
			     	  		}
			     	  }
		     	 }

			////////////

			include("cards_config.php");

			////// ������� ���������
	 		if (((time()>$coll3_start) and (time()<$coll3_end)) and  ($data_battle['win'] == $user['battle_t']) ) // ������ ������ ��� ���� ������ ���������
			 {
				if ( ($data_battle['type'] == 7) OR ($data_battle['coment'] == '<b>��� �� ������ �����</b>')  OR ($data_battle['coment'] == '<b>����-����</b>') OR ($data_battle['type'] == 313)   ) // ��������� � ������� ������ (10% �������� �����)   /  ��������� � ��� �� ������ �� (35% �������� �����),
		     	  {
			     	  $carditem=array();
			     	  include("fdroplist_113010.php");

			     	  if ($data_battle['type'] == 7) {  $CARD_DROP_CHANSE=10; }
			     	  elseif (($data_battle['coment'] == '<b>����-����</b>') OR ($data_battle['type'] == 313))  { $CARD_DROP_CHANSE=10;  }
			     	  	else { $CARD_DROP_CHANSE=35;  }


			     	  	if (mt_rand(1,100)<$CARD_DROP_CHANSE)
			     	  		{
			     	  		$ke=mt_rand(0,7);
			     	  		$param=$carditems[$ke];
			     	  		 if ($param['shop']=='') { $param['shop']='shop'; }

						DropBonusItem($param['id'],$user,$param['present'],'',0,1,20,true,true,60,$param['shop'],$coll3_end,$data_battle['id']);

				     	  	}

		     	 	}
		     	 }
			/////////////////
				if ( ($data_battle['type'] == 7) AND  ($data_battle['win'] != $user['battle_t']) )
				{
				//�������� � ������� ��� - ���� ��������
					if (mt_rand(1,100)<20)
			     	  		{

							$param = array(
									 "shop" => "shop", // ����� �����
							 		 "id" => "60105" , //���������� �������
									 "maxdur" => "1",
									 "goden"=> 1,
									 "cost"=>0,
							 		 "present"=> "�����"
								);

		     	      	  	          $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`{$param['shop']}` WHERE `id` = '{$param['id']}' LIMIT 1;"));
							if ($dress['id']>0)
									{


											if ($param['goden']>0) { $dress['goden']=$param['goden']; }
											$dress['dategoden']=(($dress['goden'])?($dress['goden']*24*60*60+time()):"");
											if ($param['dategoden']>0) { $dress['dategoden']=$param['dategoden']; }

											if (mysql_query("INSERT INTO oldbk.`inventory`
											(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`img_big`,`maxdur`,`isrep`,
												`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
												`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`letter`
											)
											VALUES
											('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$param['cost']},'{$dress['img']}','{$dress['img_big']}',{$param['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
											'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$param['present']}','{$param['labonly']}','0','{$dress['group']}','{$user['id_city']}','{$dress['letter']}'
											) ;") )
										     {
										     		$dress['id']=mysql_insert_id();
										     		$dress['idcity']=$user['id_city'];
										     		//new delo
												$rec['owner']=$user['id']; $rec['owner_login']=$user['login'];
												$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];
												$rec['target']=0;$rec['target_login']='���';
												$rec['type']=60;//������� � ���
												$rec['sum_kr']=0; $rec['sum_ekr']=0;
												$rec['sum_kom']=0; $rec['item_id']=get_item_fid($dress);
												$rec['item_name']=$dress['name'];
												$rec['item_count']=1;
												$rec['item_type']=$dress['type'];
												$rec['item_cost']=$dress['cost'];
												$rec['item_dur']=$dress['duration'];
												$rec['item_maxdur']=$dress['maxdur'];
												$rec['item_ups']=0;
												$rec['item_unic']=0;
												$rec['item_incmagic']='';
												$rec['item_incmagic_count']='';
												$rec['item_arsenal']='';
												$rec['battle']=$data_battle['id'];
												add_to_new_delo($rec);
										   		addchp ('<font color=red>��������!</font> �� �������� � ��� <b>'.$dress['name'].'</b> ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
											     }
										}
				     	  		}


				}


			////


		 if (($data_battle['coment']=='<b>��� � ������� ��������</b>') OR ($data_battle['type'] == 312) )
		 {
		 //���������� ���� �� ��������
		  include("fdroplist_dragon.php");
		 }



		     	 if ((($DROP=='true') AND ($data_battle['CHAOS']>0) or ($data_battle['coment']=='<b>��� � ������� ��������</b>') OR ($data_battle['type'] == 312) ) or ($DROP_noob==true) )
		     	 {

						if ($WIN_ONLY==true)
							{
							// ��������� ������ ��� ���
								if ( $data_battle['win'] == $user['battle_t'] )
								{
								//�� ������
								$WINST=true;
								}
								else
								{
								$WINST=false;
								}
							}
							else
							{
							$WINST=true;
							}



		     	  if   ( ($user['level'] >=$MIN_DROP_LEVEL) and
		     	       ($damexp['damage'] >=$MIN_DROP_DM ) and
		     	       ($damexp['exp'] >= $MIN_DROP_EXP ) and ($WINST==true) )
	     	       {
	     	      	 $co_items=count($items); // ������ �������

	     	      	 $porciya=(int)($DROP_CHANSE/$co_items); $pstep=$porciya; $nd=0;

	     	      	 $dit = array();
	     	      	 for ($ki=1;$ki<=100;$ki++)
	     	      	   {
	     	      	   if (($ki <= $pstep ) and ($ki <$DROP_CHANSE))
	     	      	             {
	     	      	             $dit[$ki]="$nd";
	     	      	             if ($ki==$pstep) {$nd++; $pstep=$pstep+$porciya;}
	     	      	             }
	     	      	             else
	     	      	             {
	     	      	             $dit[$ki]='N';
	     	      	             }
	     	      	   }
	     	      	   shuffle($dit);//������
	     	      	   $key=mt_rand(0,99); // ������ ������� � ����
	     	      	   if ($dit[$key]!='N')
	     	      	      {
	     	      	      $ddd=$dit[$key];
	     	      	      $param=$items[$ddd];
	     	      	      // ���� ������� ��� �����
	     	      	      if ($param['shop']=='') { $param['shop']='shop'; }
	     	      	       $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`{$param['shop']}` WHERE `id` = '{$param['id']}' LIMIT 1;"));


				if ($dress['id']>0)
							{

							if ($param['goden']>0) { $dress['goden']=$param['goden']; }
							$dress['dategoden']=(($dress['goden'])?($dress['goden']*24*60*60+time()):"");
							if ($param['dategoden']>0) { $dress['dategoden']=$param['dategoden']; }
							if ($param['notsell']>0) { $dress['notsell']=$param['notsell']; }

							$_prototype_id_ = $dress['id'];
							if (mysql_query("INSERT INTO oldbk.`inventory`
							(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`img_big`,`maxdur`,`isrep`,
								`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
								`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`,`notsell`
							)
							VALUES
							('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$param['cost']},'{$dress['img']}','{$dress['img_big']}',{$param['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
							'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$param['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".$dress['dategoden']."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$param['present']}','{$param['labonly']}','0','{$dress['group']}','{$user['id_city']}','{$dress['notsell']}'
							) ;") )
						     {
						     		$dress['id']=mysql_insert_id();
						     		$dress['idcity']=$user['id_city'];
						     		//new delo
								$rec['owner']=$user['id']; $rec['owner_login']=$user['login'];
								$rec['owner_balans_do']=$user['money'];$rec['owner_balans_posle']=$user['money'];
								$rec['target']=0;$rec['target_login']='���';
								$rec['type']=60;//������� � ���
								$rec['sum_kr']=0; $rec['sum_ekr']=0;
								$rec['sum_kom']=0; $rec['item_id']=get_item_fid($dress);
								$rec['item_name']=$dress['name'];
								$rec['item_count']=1;
								$rec['item_type']=$dress['type'];
								$rec['item_cost']=$dress['cost'];
								$rec['item_dur']=$dress['duration'];
								$rec['item_maxdur']=$dress['maxdur'];
								$rec['item_ups']=0;
								$rec['item_unic']=0;
								$rec['item_incmagic']='';
								$rec['item_incmagic_count']='';
								$rec['item_arsenal']='';
								$rec['battle']=$data_battle['id'];
								add_to_new_delo($rec);
									if ($APRIL)
									{
									$fz1[0]='���� ���������� ������� ����� ��� ����� ���';
									$fz1[1]='�����, ��� ������ ��������� ��� �������� ������� ����';
									$fz1[2]='�������� ������ � ������� �� ���� �����������';
									$fz1[3]='�������, �� ����� ���� �������';
									$fz1[4]='����������� ����� ���';
									$fz1[5]='����� ���, ��� �������� ���� ���';
									$fz1[6]='��������� ���� �����������';
									$fz1[7]='������ �������';
									$fz1[8]='������������ ������';

									$f1=mt_rand(0,8);
									$fz1=$fz1[$f1];

									$fz2[0]='�������� �� ��������';
									$fz2[1]='��������� �� ������';
									$fz2[2]='�������� �� ����';
									$fz2[3]='������� � �������� ������';
									$fz2[4]='������������ ��������� ���� �������� � ������';


									$f2=mt_rand(0,4);
									$fz2=$fz2[$f2];

									$fz3[0]='�������';
									$fz3[1]='�������';
									$fz3[2]='��������� �������';
									$fz3[3]='��������� ��������';
									$fz3[4]='������ ������� ������';

									$f3=mt_rand(0,4);
									$fz3=$fz3[$f3];

									if ($user['battle_t']==1) {  $lt='t2hist'; } else {  $lt='t1hist'; }
									$enname=BNewRender_one_rand($data_battle[$lt]);
							   		addchp (''.$fz1.', �� '.$fz2.' '.$enname.' � '.$fz3.'  <b>'.$dress['name'].'</b> ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
									}
									else
									{
							   		addchp ('<font color=red>��������!</font> �� �������� � ��� <b>'.$dress['name'].'</b> ','{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);
							   		}

						     //���� ���� �� ����
						     	if ($get_848_baff['id']>0)
						     		{
						     		//������ ������� ������ +1
						     		mysql_query("update effects set lastup=lastup+1 where id='{$get_848_baff['id']}' ; ");
						     		}

								 try {
									 $User = new \components\models\User($user);
									 $QuestComponent = getQuestComponent($User);

									 $Checker = new \components\Component\Quests\check\CheckerDrop();
									 $Checker->item_id = $_prototype_id_;
									 $Checker->shop_id = \components\Helper\ShopHelper::TYPE_ALL;
									 if (($Item = $QuestComponent->isNeed($Checker)) !== false) {
										 $QuestComponent->taskUp($Item);
									 }
									 unset($Checker);
									 unset($User);
								 } catch (Exception $ex) {
									 \components\Helper\FileHelper::writeException($ex, 'fbattle_drop_config');
								 }

						     }
						     }

	     	      	      }

	     	      		//�������������� ���� ��� ��������
	     	      		// ������������� � ������������ 50% ����� �������� ��� ���� �������, ���� � ��� ���� �������� ����� �����, ��� ���� ����
	     	      		if (($DRAGONS==true) and (mt_rand(1,100)<=50) and  ($damexp['damage'] >=$user['maxhp'] ) and ($WINST==true) )
	     	      		{
	     	      			$krnd=mt_rand(0,4);
	     	      			if ($items[$krnd]>0) {	put_bonus_item($items[$krnd],$user,'�����'); }
	     	      		}

				// ������������� � ������������ 25% ����� �������� ��� ���� �������, ���� � ��� ���� ������������ ����� �����
	     	      		if (($DRAGONS==true) and (mt_rand(1,100)<=25) and  ($damexp['damage'] >=$user['maxhp'] ) and ($WINST==true) and ($get_runs_exp['point']>0) )
	     	      		{
	     	      			$krnd=mt_rand(0,4);
	     	      			if ($items[$krnd]>0) {	put_bonus_item($items[$krnd],$user,'�����'); }
	     	      		}

	     	      	}
	     	     }
	     	} // ����


    	     // ������ ������� ����� � �����

		mysql_query("DELETE from battle_dam_exp WHERE  owner='{$user['id']}'"); // ������ ��� �� ����

		$del_eff_sql='';

	    ///�������� ������ �������������� �� ����
		if (  (($data_battle['type'] >210 )and ( $data_battle['type'] <240)) OR  (($data_battle['type'] >270 )and ( $data_battle['type'] <290)) )
				{
				///��������� ��� - ���������
				///��������� ��� - �������� �������
				}
				else
				{
				        mysql_query("DELETE FROM users_bonus where owner='{$user['id']}' and isnull(finish_time)  ; ");
				}
	    //�������� ������ �� ���� �� �����
	    if ($data_battle['win']!=3)
	    	{
	    	//���� ��� ��������� - �� ������
            	mysql_query("delete from  battle_vars  WHERE battle='{$user['last_battle']}' and owner='{$user['id']}'");
            	}
	 //  mysql_query("delete from  battle_vars  WHERE  owner='{$user['id']}'"); //������� ������ �� ���� ��� ���

		if (  (($data_battle['type'] >210 )and ( $data_battle['type'] <240)) OR  (($data_battle['type'] >270 )and ( $data_battle['type'] <290)) )
		{
				///��������� ��� - ���������
				///��������� ��� - �������� �������
		  }
		  else
		  {
		  //������ ����������� � ���� ����������
		   mysql_query("delete  from effects where owner='{$user['id']}' and type=202");
		   if (mysql_affected_rows()>0)
		   	{
		   	//���������
		   	//1. �������� ���� �� ������ ��������� ������ � ���������
		   	// ������������ ����� ���� ��� �� / ��� ��!
		   		$get_test_hidden=mysql_fetch_array(mysql_query("select * from effects where owner='{$user['id']}'  and (type='200' or type='1111' ) LIMIT 1; "));
		   		if ($get_test_hidden['id']>0)
		   		{
		   		//���� ���� - ������ ������ ������
		   		$eff_off=" , hidden='{$get_test_hidden['idiluz']}' , hiddenlog='{$get_test_hidden['add_info']}'  " ;
		   		}
		   		else
		   		{
		   		//���� ����
		   		$eff_off=" , hidden='0' , hiddenlog=''  " ;
		   		}

		   	}
		   	else
		   	{
	   		$eff_off='';
		   	}



 		//������ �� 1730,1731,1732 - �������
		   mysql_query("delete  from effects where owner='{$user['id']}' and  (type=1730 or type=1731 or type=1732)");
		   if (mysql_affected_rows()>0)
		   	{
		   	$del_eff_sql=' , trv=0  ';
		   	}
		   	else
		   	{
		   	$del_eff_sql='';
		   	}
		  }




   	     //������� ��� �����
   	     }

   	     		//������ ������ ����� ���� �������� ������ ����� ��� ������ �2
   	     		if (($data_battle['type'] >240 )and ( $data_battle['type'] <270))
   	     			{
   	     						  $get_eff_5100=mysql_fetch_array(mysql_query("select * from effects where owner='{$user['id']}' and type=5100 LIMIT 1"));
   	     						  if ($get_eff_5100['id']>0)
   	     						  	{
			  					mysql_query("UPDATE users set expbonus=expbonus-'{$get_eff_5100['add_info']}' where id='{$user['id']}' ; ");
   	     						  	mysql_query("DELETE from effects where  id={$get_eff_5100['id']} LIMIT 1;");
   	     						  	}
   	     			}


     		  //������ ������ ������� �������������
		  $get_eff_441=mysql_fetch_array(mysql_query("select * from effects where owner='{$user['id']}' and type=441 LIMIT 1"));
		  if ($get_eff_441['id']>0)
		  			{
		  			$mpr=explode(":",$get_eff_441['add_info']);
					$mpr_hp=$mpr[1];
					if (($user['hp']-$mpr_hp)>0)
						{
			  			$eff_441_hp=",  `maxhp`=`maxhp`-'{$mpr_hp}'  , `hp`=`hp`-'{$mpr_hp}' " ;
			  			}
			  			else
			  			{
			  			$eff_441_hp=",  `maxhp`=`maxhp`-'{$mpr_hp}'  " ;
			  			}
					mysql_query("DELETE from effects where  id={$get_eff_441['id']} LIMIT 1;");
		  			}
		  			else
		  			{
		  			$eff_441_hp="";
		  			}

   	     // ���� �����_� �� �����  �.�. ��� ������ ������� ��� �� ��� �������� � ������ �������
   	     if ($user['klan']=='radminion')
   	     	{
   	     ///	echo "UPDATE users SET `battle_fin`=0 ".$del_eff_sql."  ".$eff_off."  ".$eff_441_hp." where `id`='{$user['id']}' ; " ;
   	     	}
	     mysql_query("UPDATE users SET `battle_fin`=0 ".$del_eff_sql."  ".$eff_off."  ".$eff_441_hp." where `id`='{$user['id']}' ; ");
	     $user['battle_fin']=0;


		//�������� ������ �� ��������� ���
		if (!(($user['in_tower']==3) OR ($user['room']==270)))
			{
			ref_drop ($user['id']);
			}

	   // die("DDDDDDDDDDDDDDDD");
			log_php_memory('end all fight');
	    }
	    else
	    {
	    // ��� ��� ������� ��� �����������...
	    header("Location: main.php");
	    die();
	    }
	 }


//��������� ��� ������ ��� ����� ����� ��� �������� � ������ ����� ���� ��������
// ����������� ����� ���� ����� ��� �������� � �����������

			//��������� ������ ������ - ������� ����� - �� �������� ������
			$user_eff=load_battle_eff_pre($user,$data_battle);
			$user_prof=array();
			$user_prof=GetUserProfLevels($user);

			if (($i_need_zerro_930_baf==true) and (is_array($user_eff[930])) and ($user_eff[930]['add_info']>0) )
			{
			//����� ���� �����
				/*
				if ($user['id']==14897)
				{
				echo "i_need_zerro_930_baf = ".$i_need_zerro_930_baf;
				}*/

			mysql_query("UPDATE `effects` SET add_info='0'  where owner='{$user['id']}' AND type=930");
			$user_eff[930]['add_info']=0;
			}
			$i_need_zerro_930_baf=false; // � ����� ������  ������ ��� ���������� � false

$WEAP_ITYPE=0; // ��� ���������� ��� ��������

$my_wearItems=load_mass_items_by_id($user,$user_eff,$user_prof); // ��������
$my_magicItems=$my_wearItems['incmagic']; // ���������� �����

$OPEN_AUTO=false;

	if ( (($data_battle['type']>=601) and ($data_battle['type']<=604) ) OR  // � �����
		 ($data_battle['coment']=='��� � �������� �����') OR ($data_battle['type'] == 311) OR
		 ($data_battle['coment'] =='<b>��� � ������� ��������</b>') OR ($data_battle['type'] == 312) OR
		 ($data_battle['type']==30) OR // ��� � ����
 		 ($data_battle['type']==15) ) //��������� ��� ��������
 	{
	$OPEN_AUTO=true; // �������� ������� ��������
 	}



// ��� ���� � ���� �����
	if ($user['battle_t']>0)
		{
		$my_team_n=$user['battle_t'];
		//$en_team_n -��� �� ��������� - ���� ����� !=$my_team_n
		}


	//////////////////////////////////////////////////////
	// �������� ������ ���� ��� � ��� ����� �� �����
	// ������� ����������� ���������� ������� � ��� ���� ��������
	// ������ ��� ����������
	//$people=mysql_query("select * from `users` where `battle`={$data_battle['id']} and `hp` > 0 ");
	// �������� ��� ����������� ������ ������ ����
	$people=mysql_query("select id, login, hp, maxhp, level,  battle, battle_t, hidden, hiddenlog from `users` where `battle`={$data_battle['id']} and `hp` > 0 ");
	$boec_t1=array ();
	$boec_t2=array ();
	$boec_t3=array ();
	while ($rowa = mysql_fetch_array($people))
	{

		//����������� ����� � ����
		if ($rowa['battle_t']==1)
		 {
		 $boec_t1[$rowa['id']]=$rowa;
		 }
		 else	if ($rowa['battle_t']==2)
		 {
		 $boec_t2[$rowa['id']]=$rowa;
		 }
		 else if ($rowa['battle_t']==3)
		 {
		 $boec_t3[$rowa['id']]=$rowa;
		 }

	}

	// ������ ������ � ����� - ������ - �����!
//	$bots=mysql_query("select  *  from `users_clons` where `battle`={$data_battle['id']} and `hp` > 0 ");
	//�� ������ ������ - ������ ������ ����!!

	$bots=mysql_query("select id, login, hp, maxhp, level,  battle, battle_t, hidden, hiddenlog  from `users_clons` where `battle`='{$data_battle['id']}' and `hp` > 0 ");

	while ($rowa = mysql_fetch_array($bots))
	{

		//����������� ����� � ����
		if ($rowa['battle_t']==1)
		 {
		 $boec_t1[$rowa['id']]=$rowa;
		// ������������ ������� ��  ����� �.�. ���� ���� �� ������ �������� �����������	�� ������ ���������
		if (($rowa['battle_t']!=$my_team_n) and ($rowa['id'] > _BOTSEPARATOR_))
			{
			$boec_t1[$rowa['id']]['razm']=1;
			}
		 }
		 else	if ($rowa['battle_t']==2)
		 {
		 $boec_t2[$rowa['id']]=$rowa;
 		// ������������ ������� ��  ����� �.�. ���� ���� �� ������ �������� �����������	�� ������ ���������
		if (($rowa['battle_t']!=$my_team_n) and ($rowa['id'] > _BOTSEPARATOR_))
			{
			$boec_t2[$rowa['id']]['razm']=1;
			}

		 }
		 else	if ($rowa['battle_t']==3)
		 {
		 $boec_t3[$rowa['id']]=$rowa;
 		// ������������ ������� ��  ����� �.�. ���� ���� �� ������ �������� �����������	�� ������ ���������
		if (($rowa['battle_t']!=$my_team_n) and ($rowa['id'] > _BOTSEPARATOR_))
			{
			$boec_t3[$rowa['id']]['razm']=1;
			}

		 }

	}

$BSTAT['win']=$data_battle['win'];

$IH_wait=120;
$battle_start_time=strtotime($data_battle['date']);


		if ((($data_battle['coment']=='��� � �������� �����' || $data_battle['coment']=='<b>��� � ������� ��������</b>' ) and ( (time()-$battle_start_time)< $IH_wait ) and (($BSTAT['win']==3) and ($data_battle['status']==0))  )  )
					{
					  	$STEP=2;
						$data_battle['status']=1;
						$TEXT_WAIT='�������� ���: '.($IH_wait-(time()-$battle_start_time))." ���. ";

						if ($data_battle['timeout']<=3)
							{
							mysql_query('UPDATE battle SET timeout =3 WHERE id = '.$data_battle['id']);
							}

					}


if (($BSTAT['win']==3) and ($data_battle['status']==0))
{

if ($user['hp']>0) // ���� � �� ����
{
			if ($user['battle_t']==1)
			{
			$ak=count($boec_t2)+count($boec_t3);
			}
			else if ($user['battle_t']==2)
			{
			$ak=count($boec_t1)+count($boec_t3);
			}
			else if ($user['battle_t']==3)
			{
			$ak=count($boec_t1)+count($boec_t2);
			}

if ($_GET['useb794'] && $user['in_tower'] == 0) {
	if ($data_battle['nomagic']>0) {
		err('�� �� ������ ������������ � ���� ���!');
	} else {
		$q = mysql_query('SELECT * FROM effects WHERE owner = '.$user['id'].' and type = 794 and lastup < 1');
		if (mysql_num_rows($q) > 0) {
			$m = mysql_fetch_assoc($q);

			// ����� �����
			echo "<font color=red>";
			$CHAOS = true;
			include("./magic/cure2000.php");
			echo "</font>";
			if ($bet) {
				mysql_query('UPDATE effects SET lastup = lastup + 1 WHERE id = '.$m['id']);
			}
		}

	}
}

if ($_GET['abiluse'] && $user['in_tower'] == 0 && $_SESSION['show_users_babil']==true )
	{
	//
	$deny_rooms=array(197,198,199,211,212,213,214,215,216,217,218,219,220,221,222,271,272,273,274,275,276,277,278,279,280,281,282);

	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$user['id']}'  and type=805  ; "));


	 if (($get_test_baff['id']>0) and (time()<$get_test_baff['time']))
	 {
	 err("�� �� ������ ������������ �������, ��� ".floor(($get_test_baff['time']-time())/60/60)." �. ".round((($get_test_baff['time']-time())/60)-(floor(($get_test_baff['time']-time())/3600)*60))." ���.");
	 }
	 elseif ($data_battle['nomagic']>0)
	 {
	 err('�� �� ������ ������������ ������� � ���� ���!');
	 }
	 elseif (in_array($user['room'],$deny_rooms))
	 {
	 err('�� �� ������ ������������ ������� � ���������!');
	 }
	else
	{
	$abaid=(int)$_GET['abiluse'];
	$get_abil=mysql_fetch_array(mysql_query("select * from oldbk.users_babil ab LEFT JOIN magic m ON ab.magic=m.id where ab.owner='{$user['id']}' and ab.magic='{$abaid}' and ab.dur!=ab.maxdur and ab.btype=1 ;"));
	if ($get_abil['magic']>0)
		{
		$ABIL=1;
		$GO_OK=true;

		if (($get_abil['targeted']==1) AND (trim($_POST['target']) !=$user['login']) )
			{
			// ��������� ���� �� �� ���� ��� ������ 728
			$get_immun=mysql_fetch_array(mysql_query("select * from effects where owner=(select id from users where login='".mysql_real_escape_string(trim($_POST['target']))."') and type=728")) ;
			if ($get_immun['id']>0)
					{
					$GO_OK=false;
					err('� ����� ��������� ���� ��������� �� ������������� �������!');
					}
			}

		 if ($GO_OK==true)
			{
			echo "<font color=red>";
			include("./magic/".$get_abil['file']);
			echo "</font>";
			if ($sbet==1)
				{
				mysql_query("update oldbk.users_babil set dur=dur+1  where owner='{$user['id']}' and magic='{$get_abil['magic']}' ;");

				//��������� �������� ������������� ������
				mysql_query("INSERT INTO `oldbk`.`battle_runs_exp` SET `battle`='{$user[battle]}' ,`owner`='{$user['id']}', `useabil`='1' ON DUPLICATE KEY UPDATE `useabil`=`useabil`+1 ;");

				}
			}
		}
		else
		{
		err('� ��� ��� ����� �����!');
		}
	 unset($_POST['enemy']);
	 unset($_GET['enemy']);
	 }
	}
else
//

//////////////////////////////////////
			//echo "$ak <br>";
 // ����� ��������� ���� ��1
 if ( ( ($_GET['use']) and ($_GET['enemy']) and ($_GET['defend'])) OR
     (  ($_GET['use']) and ($_POST['enemy']) and ($_POST['defend']) and ($_POST['target']) and ($_POST['target']!=$user['login']) )  )
 {
 // ������� - ���� ��� ���������� ������ ������ ����� �������
  if ($_POST['enemy']) { $_GET['enemy']=$_POST['enemy']; unset($_POST['enemy']); }
  if ($_POST['defend']) { $_GET['defend']=$_POST['defend']; unset($_POST['defend']); }


 $_GET['use']=(int)($_GET['use']);
 $_GET['enemy']=(int)($_GET['enemy']);
 $_GET['defend']=(int)($_GET['defend']);
 if (($_GET['use'] > 0) and ($_GET['enemy'] > 0) and ( $_GET['defend'] > 0) and ($_GET['defend'] < 5) )
    {
    	// ���� ��������� �����
    	if (($_GET['enemy'] > _BOTSEPARATOR_) and ($_GET['enemy'] < 1000000000 )) { $TABLE='users_clons'; } else { $TABLE='users'; }
     	if ($_GET['enemy'] > 1000000000) { $HID='hidden'; $adsh='';  } else
     			{
     			$HID='id';
     			 if ($TABLE=='users') { $adsh=' and hidden=0 ';  } else { $adsh='';  }
     			}
      	$test_enemy=mysql_fetch_array(mysql_query("select * from ".$TABLE." where hp>0 and ".$HID."='{$_GET['enemy']}'  ".$adsh." and  battle_t!={$my_team_n} and battle={$data_battle['id']} LIMIT 1;"));
	if ($test_enemy['id'] > 0)
	{
        // ������ ���� ��������� ��� �� �� ���� � ����� ����� ������� � ���� - �������� �� ����� �����
         	$rezm_test=mysql_fetch_array(mysql_query("select * from battle_fd where battle={$data_battle['id']} and razmen_to={$test_enemy['id']} and razmen_from={$user['id']}   LIMIT 1;"));
		if ($rezm_test['id'] > 0)
		{
			echo "<font color=red><b>�� ��� �������� �� ����� ����������!</b></font>";
		}
           	else
		{

			$get_vars=mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$data_battle['id']}' and owner='{$user['id']}' ;"));

		        // ��� ��� ������:
		         // ���� ��������� ����� �� �����������
		         $all_help_ok=false;
		         if ($get_vars['help_use']==0)
		         	{
			         $all_help_ok=true;
		         	}
				elseif ( ($get_vars['help_proto']>0) and ($get_vars['help_use'] < $maxdur[$get_vars['help_proto']]) )
				{
					$get_item_help=mysql_fetch_array(mysql_query("select id from oldbk.inventory where id='{$_GET['use']}' and owner='{$user['id']}'  and nlevel<='{$user['level']}' and ngray<='{$user['mgray']}' and nintel<='{$user['intel']}'  and prototype='{$get_vars['help_proto']}'  and setsale=0 and bs_owner='{$user['in_tower']}' ;"));
					if ($get_item_help['id']>0)
					{
					$all_help_ok=true;
					}
				}

			if ($_GET['h']==1 && $all_help_ok==true)
			{
			//���� ������ �������� - ��� ������������� ������� =1 �������
				$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=207"));
			}
			elseif ($_GET['h']==2 && $all_help_ok==true)
			{
			//���� ������ �������� - ��� ������������� �����
				$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=1616"));
			}
			elseif ($_GET['h']==3 && $all_help_ok==true)
			{
			//���� ������ �������� - ��� ������������� �������������
				$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=1717"));
			}
			elseif ($_GET['h']==4 && $all_help_ok==true)
			{
			//���� ������ �������� - ��� ������������� �������������!! 310311  310312
				$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=310310"));
			}
			else
			{
			//��� ���������
			if ($user['id']==14897) { echo "start test magic. ";}
				$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=(select magic from oldbk.inventory where owner=".$user['id']." and id='".$_GET['use']."' and dressed=1) or id=(select includemagic from oldbk.inventory where owner=".$user['id']." and id='".$_GET['use']."' and dressed=1)"));

			if ($user['id']==14897)
				{
				print_r($test_magic);
				}
			}

			if (($data_battle['nomagic']==0) OR ($test_magic['id']==51)) //51 ������� ������������
			{

				if ( ($test_magic['id']>0) and ($test_magic['need_block'] >0))
				{

				if ($user['id']==14897) { echo "start use magic. ";}

					$MAGIC_OK=usemagic($_GET['use'],"".$_POST['target']);
					if ($MAGIC_OK==1)
					{
					//$_SESSION['usemagic_count']++;
						// ����� ����������
						// �������� ������ ��� ��������� �������
						$_POST['attack']=0;
						$_POST['attack2']=0;
						$_POST['defend']=$_GET['defend'];
						$_POST['enemy']=$_GET['enemy'];
						$_POST['myid']=time();
						$_POST['batl']=$data_battle['id'];
					}
					else
					{
					unset($_GET['use']);
					if ($user['id']==14897)
						{
						echo "<font color=red><b>������ ������!</b></font>";
						}

					}
				}
				else
				{
					// �� ����� ���� ��� ���� ����� ��� ��� ��� ���������� ����� ��������� ������� ����
				}
			}
			else
			{
			// � ��� ��������� ����� �����
			}
		}
        }
        else
        {
	echo "<font color=red><b>��������� �� ������!</b></font>";
        }

//////////////////////
     }
     else
     {
    // echo "<font color=red><b>������!</b></font>";
     }

 }
 else if ( (isset($_GET['naem'])) and ($user['battle'] > 0) and ($user['room']!=90) and ($user['lab']==0 or $user['id']==14897) and (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290) or ($user['in_tower']>0) )) ) // ��������  �������� ������ �������� � ������, ��, �����
 	{
 	//������ ��������
 			$naem=mysql_fetch_array(mysql_query("select * from users_clons where owner='{$user['id']}' and naem_status=1 limit 1;"));
			if (($naem['id']>0) and ($_GET['naem']===$naem['id']) )
			{
			if ($naem['battle']==0)
				{
						//1. �������� ���
						//2. ������ �����
						//3. ������ ��� + ���

						if ((($naem['fullentime']>0) and ($naem['energy']>=1))  OR ($naem['fullentime']==0) ) //  ���� ����� OR ($naem['fullentime']==0)
						{
						   if (($data_battle['win']==3)	and  ($data_battle['t1_dead']=='') and ($data_battle['status']==0))
						   	{
					   		if (($user['hp']>0) and ($user['battle']==$data_battle['id']))
					   			{
				   				$time = time();
				   				$ttt=$user['battle_t'];
		   						mysql_query('UPDATE battle SET to1='.$time.', to2='.$time.',  t'.$ttt.'=CONCAT(t'.$ttt.',\';'.$naem['id'].'\') , t'.$ttt.'hist=CONCAT(t'.$ttt.'hist,\''.BNewHist($naem).'\')    WHERE id = '.$user['battle'].'  and `win`=3 and `status`=0 and `t1_dead`="" ;');
					   			if (mysql_affected_rows()>0)
						   				{

										$naem = ref_dropnaem($naem);

							   			//������ ���� �� � ��� ����
							   			//�������� ��� ���� � ���� 0 �������
							   			if ($naem['fullentime']==0)
							   				{
								   			mysql_query("UPDATE `oldbk`.`users_clons` SET `hp`=`maxhp`,`mana`=`maxmana` ,`battle`='{$data_battle['id']}', `last_battle`='{$data_battle['id']}'  ,`battle_t`='{$user['battle_t']}'  WHERE `id`='{$naem['id']}' limit 1;");
								   			}
								   			else
								   			{
								   			//����� ����� ������
								   			mysql_query("UPDATE `oldbk`.`users_clons` SET `energy`=`energy`-1, `hp`=`maxhp`,`mana`=`maxmana` ,`battle`='{$data_battle['id']}', `last_battle`='{$data_battle['id']}'  ,`battle_t`='{$user['battle_t']}'  WHERE `id`='{$naem['id']}' limit 1;");
								   			}
							   			$naem['hp']=$naem['maxhp'];
							   			$naem['mana']=$naem['maxmana'];
							   			$naem['energy']=$naem['energy']-1;
							   			$naem['battle']=$data_battle['id'];
							   			$naem['last_battle']=$data_battle['id'];
							   			$naem['battle_t']=$user['battle_t'];

							   			//������ ��������� ����� �� ���
					   					mysql_query("UPDATE  oldbk.inventory set battle='{$user['battle']}' where  id IN (".GetDressedItems($naem,DRESSED_ITEMS).") ; ");

							   			//������ ���� ����� = ���� �� ����� ������
							   			$baseexp = array("0" => "5","1" => "10","2" => "20","3" => "30","4" => "60","5" => "120","6" => "180","7" => "300","8" => "450","9" => "600","10" => "1200","11" => "2400","12" => "4800","13" => "6800","14" => "4800","15" => "4800","16" => "4800","17" => "4800","18" => "4800","19" => "4800","20" => "4800","21" => "4800"); // ������ �������� �����
							   			$ret=$baseexp[$naem['level']];
										mysql_query('INSERT `battle_dam_exp` (`battle`,`owner`,`damage`,`mag_damage`,`exp`,`dcount`) values (\''.$data_battle['id'].'\',\''.$naem['id'].'\',\'0\',\'0\',\''.$ret.'\',\'0\' ) ; ');

							   			$btext=str_replace(':','^',nick_in_battle($naem,$ttt));
								       	       	 addlog($user['battle'],"!:X:".time().':'.nick_new_in_battle($user).':'.($user[sex]+310).":".$btext."\n");

						   					//����������� ����� � ����
											if ($user['battle_t']==1)
											 {
											 $boec_t1[$naem['id']]=$naem;
											 $data_battle['t1'].=';'.$naem['id'];
											 $data_battle['t1hist'].=BNewHist($naem);
											 }
											 elseif ($user['battle_t']==2)
											 {
											 $boec_t2[$naem['id']]=$naem;
											 $data_battle['t2'].=';'.$naem['id'];
											 $data_battle['t2hist'].=BNewHist($naem);
											 }
											 else if ($user['battle_t']==3)
											 {
											 $boec_t3[$user['id']]=$naem;
											 $data_battle['t3'].=';'.$naem['id'];
											 $data_battle['t3hist'].=BNewHist($naem);
											 }

						   				}
						   				else
									   	{
									    	echo "<font color=red><b>��� �������!!!</b></font>";
									   	}

					   			}
					   			else
					   			{
		  						    	echo "<font color=red><b>��� ��� ��� ��� �������!</b></font>";
					   			}
						   	}
						   	else
						   	{
						    	echo "<font color=red><b>��� �������!</b></font>";
						   	}
						   }
						   else
						   {
						   	echo "<font color=red><b>������� ������� ���� ��� ���, ���������� ������������ ��� �������!</b></font>";
						   }
				}
			else
				{
				echo "<font color=red><b>������� ��� � ���!</b></font>";
				}
			}
			else
			{
		    	echo "<font color=red><b>����� ������� � ��� �� ������ ��� �� �����������!</b></font>";
			}
 	}



////
//������� ���� �� ���� ����� ����������, �������� ������� �� ������
$user_eff_711=mysql_fetch_array(mysql_query("select * from effects where owner='{$user['id']}' and battle='{$user['battle']}' and type=711 order by id  LIMIT 1;"));


// ��� �������� ����
 if ( ( ( ($_POST['batl']) and ($_POST['enemy']) and ($_POST['myid']) and ($_POST['attack']) and ($_POST['defend'])) and ($ak > 0 )  ) OR
      ($MAGIC_OK==1) )
 {

	if ($user['ruines'] > 0) {
		if (!isset($_SESSION['ruinesactivity']['battle'])) {
			$_SESSION['ruinesactivity']['battle'] = 1;
			$q = mysql_query('SELECT * FROM ruines_activity_log WHERE mapid = '.$user['ruines'].' and owner = '.$user['id'].' and var = "battle"');
			if (mysql_num_rows($q) == 0) {
				mysql_query('INSERT INTO ruines_activity_log (mapid,owner,var,val) VALUES("'.$user['ruines'].'","'.$user['id'].'","battle","1")');
			}
		}

		$q = mysql_query('SELECT * FROM ruines_activity_log WHERE mapid = '.$user['ruines'].' and owner = '.$user['id'].' and var = "path"');
		if (mysql_num_rows($q) == 0) {
			// nothing
		} else {
			mysql_query('UPDATE ruines_activity_log SET val = '.time().' WHERE mapid = '.$user['ruines'].' and owner = '.$user['id'].' and var = "path"');
		}

	}


  $_POST['attack']=(int)($_POST['attack']);

  $_POST['attack2']=(int)($_POST['attack2']);
  $AT2_check=false;

  if (($_POST['attack2']>0) and ($_POST['attack2']<5)) { $AT2_check=true; }
  if ($WEAP_ITYPE!=2) { unset($_POST['attack2']);  $AT2_check=true; }


  $_POST['defend']=(int)($_POST['defend']);
  $_POST['enemy']=(int)($_POST['enemy']);
  if ( ( ($_POST['attack']>0) and ($_POST['attack']<5) and ($_POST['defend'] > 0 ) and ($_POST['defend'] < 5) and  ($_POST['enemy'] > 0) and ($AT2_check==true) ) OR
     ( ($MAGIC_OK==1) ))
  {
  //echo "1 <br>";

     // 1. �������� ������� �� ��� ���� ���� ����� ���� � ���� �� � �� ��� �� ����

     if (($_POST['enemy'] > _BOTSEPARATOR_) and ($_POST['enemy'] < 1000000000 ))
     {
     	$TABLE='users_clons';
     }
     else
     {
     	$TABLE='users';
     }

     if ($_POST['enemy'] > 1000000000)
	 {
	 	//���������
  	 	$HID='hidden';
	 }
	 else
	 {
	 	//�������
	 	$HID='id';
	 }


     $real_enemy=mysql_fetch_array(mysql_query("select * from ".$TABLE." where hp>0 and ".$HID."='{$_POST['enemy']}' and battle_t!={$my_team_n} and battle={$data_battle['id']} LIMIT 1;"));


    if ($real_enemy['id'] > 0)
     {
     	 if (($user_eff_711['id']>0) and ((int)($user_eff_711['add_info'])==$real_enemy['id']))
     	 	{
     	 	bet_battle_eff($user_eff_711);
     	 	}

     //��������� ����� ������� �� ������� �����
    mysql_query("INSERT INTO `battle_user_time` SET `battle`='{$data_battle['id']}',`owner`='{$user['id']}',`timer{$real_enemy['battle_t']}`='".time()."' ON DUPLICATE KEY UPDATE `timer{$real_enemy['battle_t']}`='".time()."'");

	/// �� ��������� ���� � �����
	// 2. ��������� ���� ������ �� ����� � ���� ��������
		$my_enemy_do=mysql_fetch_array(mysql_query("select * from battle_fd where battle={$data_battle['id']} and razmen_from={$real_enemy['id']} and razmen_to={$user['id']} ORDER by time_blow LIMIT 1;"));

		if (($my_enemy_do['id'] > 0) or ($real_enemy['id'] > _BOTSEPARATOR_)) // ��� ���� ������ �� �������� ��� ��� �� ����
	      {
	      	//echo "3 <br>";
	     	//���� ��� �� ���� ������ ���� � ������
	      	if ($real_enemy['id'] > _BOTSEPARATOR_)
	         {
	         	//����� ��� ����
		        $hhh=get_hil_bot($real_enemy);
				if ($hhh>0)
				{
				$real_enemy['hp']=(int)$hhh;
				}


		         $my_enemy_do['attack']=mt_rand(1,4);
		         $my_enemy_do['block']=mt_rand(1,4);
	         }
	      	 // �� -  ����� ���� � �������� ������� ����
	      	 //�������� ������� / ��_��� / ������ ��� ������ ������� / �� ���� ��� ������� / ���� ����� ������� / ���� ������ ������� /....
	      	 // ������ � ����� ����� ������ ����� � �������

			//��������� ������ ������ ��� � ����� ���� ���� �� ����-�������� ���� � ���������
			if ($user['id'] < _BOTSEPARATOR_ )
			{
				$user_eff=load_battle_eff($user,$data_battle);
			}

			//��������� ������ ������ ����� ���� ���� �� ����
			$enemy_prof=array();
			if ($real_enemy['id'] < _BOTSEPARATOR_ )
			{
			$real_enemy_eff=load_battle_eff($real_enemy,$data_battle);
			$enemy_prof=GetUserProfLevels($real_enemy);
			}

			// ������� ����� "��������������" - ���������� - ��������� ��� ���� - ���������� - ���� ���� ��� - � �������� ���� �� ����
			// �������� � ������ ������ �����
			////////////////////////////////////////////////////
			//��������� ��� ������ ��� ����� ����� � �������� � ������ ����� ���� ��������
			$en_wearItems=load_mass_items_by_id($real_enemy,$real_enemy_eff,$enemy_prof); // ��������

			{
			//////////////////////////////////////////////////
			/// 1. ����� / ��� ��� - ��� ��������� - ���� ���� - ��� ���� -������ �����

			//���� ���� ������ ����
			$my_enemy_do_attack=$my_enemy_do['attack'];

			if ($my_enemy_do['attack2']>0)
				{
				$my_enemy_do_attack=array($my_enemy_do['attack'],$my_enemy_do['attack2']);
				}


			$input_attack=do_attack_in($data_battle,$user,$real_enemy,$my_enemy_do_attack,$_POST['defend'],$my_wearItems,$en_wearItems,$user_eff,$real_enemy_eff,'from_fbattle');

			//write_stat($input_attack[stat],$data_battle['id']); // ����� ����������
			//write_stat_adm("USER:".$user['login']."|VRAG:".$real_enemy['login']."|in|UV_ME_P:".$input_attack[uvorotme_p]."|UV_ME_R:".$input_attack[uvorotme_rez]."|KRIT_HE_P:".$input_attack[krithe_p]."|KRIT_HE_R:".$input_attack[krithe_rez]."|UVE:".$input_attack[uve]."|out:".$input_attack[mstep],$data_battle['id']); //����� ����� ����





			/// 2. ������ / ��� ��������� / ��� ��� / ���� ���� - ��� ���� - ���������� �����

			$my_user_do_attack=$_POST['attack'];

			//echo " ������ ���� �� ������ {$_POST['attack2']}; ";

			if (($_POST['attack2']>=1) and ($_POST['attack2']<=4) )
				{
				$my_user_do_attack=array($_POST['attack'],$_POST['attack2']);
				}


			$output_attack=do_attack_out($data_battle,$user,$real_enemy,$my_user_do_attack,$my_enemy_do['block'],$my_wearItems,$en_wearItems,$user_eff,$real_enemy_eff,'from_fbattle');
			//write_stat($output_attack[stat],$data_battle['id']); // ����� ����������
			//write_stat_adm("USER:".$real_enemy['login']."|VRAG:".$user['login']."|out|UV_ME_P:".$output_attack[uvorotme_p]."|UV_ME_R:".$output_attack[uvorotme_rez]."|KRIT_HE_P:".$output_attack[krithe_p]."|KRIT_HE_R:".$output_attack[krithe_rez]."|UVE:".$output_attack[uve]."|out:".$output_attack[mstep],$data_battle['id']); //����� ����� ����
			///2.1 - ��� ������ �������� - ��� �������� � ������� SQL
			//
			# ��� / � / ���� / ���� ��� / ���� �� ��� �� ����� / ���� ����� �� ����
			 if ($real_enemy['id'] > _BOTSEPARATOR_)
			 {
			 // �������� ��������� ������� ������� ������ ����
			 // � ����� ���������� �������� � ����������� ����� ��� ��� �� �����


					$rez[0]=do_razmen_to_bot($data_battle,$user,$user['battle_t'],$real_enemy,$real_enemy['battle_t'],($output_attack['dem']-=$output_attack['stone']),($input_attack['dem']-=$input_attack['stone']),$output_attack['type'],$input_attack['type'],$data_battle['type']);


			 }
		 	else
			 {
			//� ������� ������ �������� ���������� � ������ ���������� ����� �������
			mysql_query("INSERT INTO `battle_user_time` SET `battle`='{$data_battle['id']}',`owner`='{$real_enemy['id']}',`timer{$user['battle_t']}`='".time()."' ON DUPLICATE KEY UPDATE `timer{$user['battle_t']}`='".time()."'");

			  	$HH=(int)(date("H",time()));
			  	 if (($HH>=9) and ($HH<21))
				{
				//echo "����";
				//���� ���������
				if ($real_enemy['pasbaf']==852 && $real_enemy['in_tower'] == 0)
				 	{
			  		$trvkrit=-10;//10%
			  		}
			  	//	���� �������
			  		else if ($real_enemy['pasbaf']==861 && $real_enemy['in_tower'] == 0)
				 	{
			  		$trvkrit=-10;//10%
			  		}
			  		else
			  		{
			  		$trvkrit=0;
			  		}

				}
				else
				{
				//� 21:00 �� 09:00
				//echo "����";
			  	//���� ������
				if ($user['pasbaf']==840 && $user['in_tower'] == 0)
			  		{
			  		$trvkrit=10;//+10%
			  		}
			  		else
			  		{
			  		$trvkrit=0;
			  		}
				}

				if (is_array($user_eff[838]) && $user['in_tower'] == 0)
					{
					//���� ����� ��� �� ��������� ����� ����� �� ����
					$trvkrit+=10;//+10%
					}

				if (is_array($real_enemy_eff[838]) && $real_enemy['in_tower'] == 0)
					{
					//���� ����� ��� �� ����� �� �������� ����
					$trvkrit-=10;//-10%
					}

					if ($enemy_prof['carpenterlevel']>0)
						{
						//�������      ���� �������� ������ � ���: +...%      2% �� ������ ������� ����������
						//�������� ���� ��������� ������ �� �����
						$trvkrit-=$enemy_prof['carpenterlevel']*2;
						}

					//��� �������� ����� � ���� ��������� � ������� �� �������� ����  ���� ��� ���� ������
				  $rez[0]=do_razmen_to_telo($data_battle,$user,$user['battle_t'],$real_enemy,$real_enemy['battle_t'],($output_attack['dem']-=$output_attack['stone']),($input_attack['dem']-=$input_attack['stone']),$output_attack['type'],$input_attack['type'],$data_battle['type'],$trvkrit);

			 }


			$STING='REZ'.$rez[0];
			//echo " MAIN REZ:".$STING."<br>" ;


			//����� ��������� ��� ���� - ���������� � �������
		 		 	 if (($user['hidden'] > 0) and ($user['hiddenlog'] =='') )    { $user['sex']=1; $K_hnik='���������'; }
		 		 	 elseif (($user['hidden'] > 0) and ($user['hiddenlog'] !='') )    {  $kfake=explode(",",$user['hiddenlog']);
																$user['sex'] = $kfake[4];
																$K_hnik=$kfake[1];
																 }

		 		 	 if (($real_enemy['hidden'] > 0) and ($real_enemy['hiddenlog'] =='') )    { $real_enemy['sex']=1; $P_hnik='���������'; }
		 		 	 elseif (($real_enemy['hidden'] > 0) and ($real_enemy['hiddenlog'] !='') )    {  $kfake=explode(",",$real_enemy['hiddenlog']);
																$real_enemy['sex'] = $kfake[4];
																$P_hnik=$kfake[1];
																 }
			////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

				/*if (($user['id']==239005) or ($user['id']==303957) OR ($user['id']==14897) OR ($user['id']==370706))
					{
					//echo "TEST BAFF:";
					log_deb_eff(print_r($user_eff,true));
					}
				*/

if ($data_battle['nomagic']==0)
		{

					//����� ��������� ��������
					/*
					     ������ �����
					    � ��� ������� � ���������, ���� �� ����� ����, �� ������ ���� �� ���� ����
					    � ���� ������������ ������ 5%
					$skill[10002]['power']=100;
					$skill[10002]['chance']=5;
					*/
				 if ($real_enemy['id'] > _BOTSEPARATOR_)
				 {
					if ($real_enemy['skills']!='')
						{

						$skill=unserialize($real_enemy['skills']);
						if ($skill['10002']['id']==10002) //"������ �����";
								{
								if (($input_attack['dem']>0) and (!(isset($input_attack['ok_skill']))) and ($real_enemy['hp']<$real_enemy['maxhp']) and ($real_enemy['hp']>0) )
										{
										$add_hp=round($input_attack['dem']*($skill[10002]['power']*0.01));
										$td=$real_enemy['maxhp']-$real_enemy['hp'];
										if ($td<$add_hp) { $add_hp=$td;}
											if ($add_hp>0)
											{
											$skrnd=mt_rand(1,100);
											if ($skrnd<=$skill[10002]['chance'])
													{
													mysql_query("UPDATE `users_clons` SET `hp` =`hp`+ ".$add_hp."  WHERE `id` = '{$real_enemy['id']}' and battle='{$data_battle['id']}' and hp>0 ;");
													if (mysql_affected_rows()>0)
														{
												       	       	//addlog($data_battle['id'],"!:M:".time().':'.nick_new_in_battle($real_enemy).':'.($real_enemy[sex]+510).":10002::������� ����� <B>+".$add_hp."</B> [".$real_enemy['hp']."/".$real_enemy['maxhp']."]\n");
												       	       	$real_enemy=mysql_fetch_array(mysql_query("select * from `users_clons` where id='{$real_enemy['id']}' "));
												       	       	// ����� ������ +fix
														if ($real_enemy['battle_t']==1)
														{
														$boec_t1[$real_enemy['id']]['hp']=$real_enemy['hp']+$output_attack['dem'];
														}
														else if ($real_enemy['battle_t']==2)
														{
														$boec_t2[$real_enemy['id']]['hp']=$real_enemy['hp']+$output_attack['dem'];
														}
														else if ($real_enemy['battle_t']==3)
														{
														$boec_t3[$real_enemy['id']]['hp']=$real_enemy['hp']+$output_attack['dem'];
														}

												       	       	//$input_attack
												       	       	$output_attack['text'].="\n!:M:".time().':'.nick_new_in_battle($real_enemy).':'.($real_enemy[sex]+510).":10002::������� ����� <B>+".$add_hp."</B> [".$real_enemy['hp']."/".$real_enemy['maxhp']."]\n";
														}

													}
											}
										}
								}
						}
				}

$ALLMAGIC=true;

$USER_MANA=true;

if ($user['mana']<=0)
{
$USER_MANA=false;
}

// ������� ��� �������� ������ ����� ��� � ����� ��� ������ �����
if ( (($user['room']>240 and $user['room']<270) ) OR  ($user['room']==90) OR  ($user['lab'] >0)   OR ($data_battle['coment'] == "<b>��� � �������</b>" ) OR ($data_battle['coment'] == "<b>��� � ������</b>" ) OR ($data_battle['coment'] == "<b>��� ���������� �������-����</b>" ) OR ($data_battle['coment'] == "<b>��� � ������� ��������</b>" ) OR ($data_battle['coment'] == "<b>��� � ����������� �����</b>" )  OR ($data_battle['coment'] == "��� � �������� �����" ) OR ($data_battle['type'] == 311) OR ($data_battle['type'] == 312)   )
	{
	$ALLMAGIC=false;
	}
////////////////////////////		//////////////////////////// //////////////////////////// //////////////////////////// //////////////////////////// //////////////////////////// ////////////////////////////


if ( (($user['room']>240 and $user['room']<270) ) OR  ($user['lab'] >0)  )
	{
	$USER_MANA=true;
	}



	$ENEMY_MANA=true;



	if ($real_enemy['mana']<=0)
	{
	$ENEMY_MANA=false;
	}



//930 ������ ���� - ���� �� �����
if ((is_array($real_enemy_eff[930]) && $real_enemy['in_tower'] == 0) and ($input_attack['dem']==0) and ($ALLMAGIC==true) and ($ENEMY_MANA==true)  )// �� � ��
		{
		//�� ���� ����� - ������ ����� ��� ������� ������� ���������
			mysql_query("UPDATE `effects` SET add_info='0'  where owner='{$real_enemy['id']}' AND type=930");
		}
		else
//930 ������ ����
if ((is_array($real_enemy_eff[930]) && $real_enemy['in_tower'] == 0) and ($input_attack['dem']>0) and ($ALLMAGIC==true) and ($ENEMY_MANA==true) )// �� � ��
				{
				//������ +1 ���� �� ������ 4 ����
				if ($real_enemy_eff[930]['add_info']<4)
					{
					mysql_query("UPDATE `effects` SET add_info=add_info+1  where owner='{$real_enemy['id']}' AND type=930");
					}

				$prhp=$user['hp']-$input_attack['dem'];

				//�������
				if (($real_enemy_eff[930]['lastup']>0) AND ($real_enemy['mwater']<3))
					{
					$real_enemy['mwater']=(int)($real_enemy_eff[930]['lastup']);
					}

				if (($prhp>0) AND ($real_enemy['mwater']>0))
				{
					//���� ���� ����� � � ���� ���
					if ($real_enemy['mwater']>100) { $real_enemy['mwater']=100; }

					$real_enemy_mudra=round($real_enemy['mudra']);

					if ($real_enemy_mudra>50) {$real_enemy_mudra=50;}

					$baf_dem_min=(int)($real_enemy_mudra+$real_enemy['mwater']) ;

					$baf_dem_max=(int)($real_enemy['mwater']*10)  ; //������ ������ = ������������� �����


					if ($enemy_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$enemy_prof['magelevel']);
						$baf_dem_max+=(2*$enemy_prof['magelevel']);
						}


					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_max<1) {$baf_dem_max=1;}
					if ($baf_dem_min<1) {$baf_dem_min=1;}

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }



					$baf_dem_baza=mt_rand($baf_dem_min,$baf_dem_max); //100%

					if (!(in_array(4,get_mag_stih($real_enemy,$real_enemy_eff)) )) { $baf_dem_baza=(int)($baf_dem_baza*0.5); } // -50% ���� ���� ������� �� ������


					$koluda=(int)($real_enemy_eff[930]['add_info']); // ��� �������� ������� ������ ������� ������

					$demag[0][0]=1; //��� ������ ������� ��������� ������� ���� ���� 100% �� ����������
					$demag[1][0]=0.5; $demag[1][1]=0.5; //��� ������ (������ ���� �����) ������� ������� 50% � �������� +- ����� 50%
					$demag[2][0]=0.5; $demag[2][1]=0.25; $demag[2][2]=0.25; //��� ������� (������ ����� ��) ������� ������� 50% ������� �������� 25% �������� 25%
					$demag[3][0]=0.5; $demag[3][1]=0.1;   $demag[3][2]=0.2; $demag[4][3]=0.3; //��� ��������� (������) ������� 50% ������� 30% �������� 20% ���������� 10%
					$demag[4][0]=0.4; $demag[4][1]=0.1;   $demag[4][2]=0.1; $demag[4][3]=0.2;  $demag[4][4]=0.3; //	��� ����� ����� (������) ������� 40% ������� 30% �������� 20% ����������� � ������ �� 10%

					$demaga=$demag[$koluda]; //����������  ������ ����� ��� ���������� ������� ����������

					$baf_dem=round($baf_dem_baza*$demaga[0]); // [0] = ���� ��� ������ ������


					$mag_prot_bonus=1; //100% ����
					if (is_array($user_eff[557]))
							{
							$mag_prot_bonus=$user_eff[557]['add_info'];// ��������� �� ������
							}
					if ($user_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����


					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}

					//708
						if ( (($user_eff[708]) and ($user_eff[708]['lastup']>0)) and ($prhp<=1))
						{
							//��������� ������
							$baf_dem=($user['hp']-$input_attack['dem'])-1;
							$prhp=1;
						}

						$fix706u=0;
						//�������� �� ����� 706-��
						if ( (($user_eff[706]) and ($user_eff[706]['lastup']>0)) and ($input_attack['dem']==1))
						{
							//��������� ������
							$prhp=$user['hp']-$input_attack['dem'];
							$baf_dem=0;
							$fix706u=1;
						}


					if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$user['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$user['id']}' and hp>0 LIMIT 1; ");
						}

					if( (mysql_affected_rows()>0) or ($fix706u==1) )
						{

						$uron_str=$baf_dem;
						//hidden �������������
						if (($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$user['maxhp'].']';    }
						$input_attack['text'].="\n!:L:".time().":".nick_new_in_battle($user).":".(220+$user['sex'])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;

						$input_attack_magic_dem=$baf_dem;//����� � ��� ����

						if ($prhp<=0)
							{
							$input_attack['text'].="\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user);

							$user_mag_dead=true; // ������ ������� ��� ���� �����

							//�������� � ������
							$user['hp']=0;
							$STEP = 4;
							// �������� � ������
							if ($user['battle_t']==1)
							{unset($boec_t1[$user['id']]);}
							elseif ($user['battle_t']==2)
							 {unset($boec_t2[$user['id']]);}
							elseif ($user['battle_t']==3)
							 {unset($boec_t3[$user['id']]);}

								if (!isset($real_enemy['id_user']) AND ($user['level'] >= ($real_enemy['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
								{

									if (!isset($user_eff[5577]) || $user_eff[5577]['add_info'] < 10) {
										if(!isset($user_eff[5577])) {
											mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$user['id'].'",1999999999,1) ');
										} else {
											mysql_query('UPDATE `effects` SET add_info = '.($user_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$user['id']);
										}

										mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
										VALUES(
											'.$data_battle['id'].',
											'.$real_enemy['id'].',
											1,
											'.$real_enemy['battle_t'].'
										)
										ON DUPLICATE KEY UPDATE
											`value` = `value` + 1');
									}
								}
								elseif (!isset($real_enemy['id_user']) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($real_enemy);
								}
							}


						if ($koluda>0) // ����  ���� ��� ������� �����
							{
							//���� ���������� ���� ���  ����
							$memorize=array();
							$memorize[]=$user['id']; // ���������� ��
							$filt='';
							 for ($io=1;$io<count($demaga);$io++) // �������� � 1 �������
							 {
										 if (count($memorize)>0)
										{
										$filt=" and users.`id` not in  (".implode(",",$memorize).")  " ; //��������� ��� �� ��� ������ �����
										}
						 		$demaga[$io]=round($baf_dem_baza*$demaga[$io]);	 //���� �����
							 	$pesh=mysql_fetch_array(mysql_query("select users.*, effects.type, effects.add_info, (SELECT alchemistlevel FROM oldbk.users_craft WHERE owner =users.id) as alchemistlevel from users LEFT JOIN effects ON users.id = effects.owner and effects.type = 557 where users.battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and (level>=".($real_enemy['level']-1)." and level<=".($real_enemy['level']+1).")   and hp>'{$demaga[$io]}' ".$filt." order by Rand() limit 1 ;"));
							 	if ($pesh['id']>0)
							 		{
									$pesh_amag=1;
									if ($pesh['type'] == 557)
										{
										$pesh_amag=$pesh['add_info'];
										}
									if ($pesh['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
										{
										$pesh_amag-=(0.02*$pesh['alchemistlevel']); //��������� �� �����
										}
									$demaga[$io] = round($demaga[$io] * $pesh_amag); // ������ �� �����

							 		mysql_query("UPDATE users set hp=hp-'{$demaga[$io]}' where id='{$pesh['id']}' and hp>'{$demaga[$io]}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
									 				$memorize[]=$pesh['id']; // ���������� ��
			 										$uron_str=$demaga[$io];
			 										$pesh['hp']-=$demaga[$io];
													if (($pesh['hidden'] > 0) and ($pesh['hiddenlog'] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$demaga[$io]."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$input_attack['text'].="\n!:L:".time().":".nick_new_in_battle($pesh).":".(220+$pesh['sex'])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;
													$input_attack_magic_dem+=$demaga[$io];//����� � ��� ����
								 				}
							 		}
							 		else
							 		{
							 		break ; // ��� ������ ������ ������
							 		}
							 }
							}


						set_telo_mana($real_enemy,$input_attack_magic_dem);
						}
				}
			}
else
//920 - ������ �����
if ((is_array($real_enemy_eff[920]) && $real_enemy['in_tower'] == 0) and ($input_attack['dem']>0) and ($ALLMAGIC==true) and ($ENEMY_MANA==true) )// �� � ��
				{
				$prhp=$user['hp']-$input_attack['dem'];

				//�������
				if (($real_enemy_eff[920]['lastup']>0) AND ($real_enemy['mearth']<1))
					{
					$real_enemy['mearth']=(int)($real_enemy_eff[920]['lastup']);
					}

				if (($prhp>0) AND ($real_enemy['mearth']>0))
				{
					//���� ���� ����� � � ���� ���
					if ($real_enemy['mearth']>100) { $real_enemy['mearth']=100; }

					$real_enemy_mudra=round($real_enemy['mudra']); //��������

					if ($real_enemy_mudra>50) {$real_enemy_mudra=50;}

					$baf_dem_min=(int)($real_enemy_mudra/5) ; //5 �������� - 1 ����������� ����



					$baf_dem_max=(int)($real_enemy['mearth'])  ; //������ ������ = ������������� �����

					if ($enemy_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$enemy_prof['magelevel']);
						$baf_dem_max+=(2*$enemy_prof['magelevel']);
						}

					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min<1) {$baf_dem_min=1; }
					if ($baf_dem_max<1) {$baf_dem_max=1;}

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }

					$baf_dem=mt_rand($baf_dem_min,$baf_dem_max); // ����

					if (!(in_array(2,get_mag_stih($real_enemy,$real_enemy_eff)))) { $baf_dem=(int)($baf_dem*0.5); } // -50% ���� ���� ������� �� ������

					$baf_dem=(int)($baf_dem*0.5);

					if ($baf_dem < 1) $baf_dem = 1;


					/*
					$mag_prot_bonus=1; //100% ����
					if (is_array($user_eff[557]))
							{
							$mag_prot_bonus=$user_eff[557]['add_info'];// ��������� �� ������
							}
					if ($user_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����
					*/


					/* - ������ �������
					//���� ���������� ����  ��� ���
					$get_all_life=mysql_query("select * from users where battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and hp>'{$baf_dem}'  ;");
					$all_cast=mysql_num_rows($get_all_life);

					if ($all_cast>0)
							{
							$mass_magic_data='';
							$uron_str=0;
							$uron_str_all=0;
							$all_render=0;
							while($pesh = mysql_fetch_array($get_all_life))
							 {
							 	if ($pesh['id']>0)
							 		{
							 		mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$pesh['id']}' and hp>'{$baf_dem}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
								 				$all_render++;
			 										$uron_str=$baf_dem;
			 										$pesh['hp']-=$baf_dem;
			 										$uron_str_all+=$baf_dem; // ����� ���� �� ���� ��� ����������
													if (($pesh['hidden'] > 0) and ($pesh['hiddenlog'] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$mass_magic_data.=nick_new_in_battle($pesh)."#".(220+$pesh['sex'])."#".$uron_str."#".$txtdm."#";
													$input_attack_magic_dem+=$baf_dem;//����� � ��� ���� - ��� �������� �����
								 				}
							 		}
							 }

							$input_attack['text'].="\n!:J:".time().":".$mass_magic_data.":".$all_render."::".nick_new_in_battle($real_enemy).":::::".$uron_str_all.":";
							 }
					*/
					if ($baf_dem>0) {

							//�������� ���� � ���� ������ �� �����
							$owners_all_p=array();
							$owners_magp=array();
							$sql_protectmag="";

							$get_all_magprot=mysql_query("SELECT * FROM effects WHERE type = 557 and battle='{$data_battle['id']}'");
							while($puser = mysql_fetch_array($get_all_magprot))
								{
								$owners_all_p[]=$puser['owner']; //�� ���� � ���� ������ �����
								$owners_magp[strval($puser['add_info'])][]=$puser['owner']; //  �� ������� ������
								}

							//�������� ���� � ���� ������� �������� ������ 0 � ������ ��� � ������ �������
							$get_all_magprot=mysql_query("SELECT owner, alchemistlevel FROM oldbk.users_craft WHERE owner in (select id from users where battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and hp>0) and alchemistlevel>0");
							while($puser = mysql_fetch_array($get_all_magprot))
								{
								$tkey = array_search($puser['owner'], $owners_all_p);  // ���� ����� ������������ � ������ � �������� �������
								if ($tkey !== false)
										{
										//���� ��� ��������� �� ����
										// ���� ����������� �� ���� � ������  ��������
												reset($owners_magp);
												foreach ($owners_magp as $pct => $pow)
												{
														//���� ��  id  ���� � ������ $pow
														$dlkey = array_search($puser['owner'], $pow);
														if ($dlkey !== false)
																{
																//�����
																//������� �� �� ������
																unset($owners_magp[$pct][$dlkey]);
																//������ ��������� � ����� ������ ��������� ��� ����
																// ������ ����� $pct - (0.02*$puser['alchemistlevel'])
																$new_pct=$pct-(0.02*$puser['alchemistlevel']); // ��� ���. �����
																//������ �� ���� � ���������� ������
																$owners_magp[strval($new_pct)][]=$puser['owner'];
																//����� �������
																break;
																}
												}
										}
										else
										{
										//���� ������ ��������� � ������ ������
											$owners_all_p[]=$puser['owner']; //�� ����
											$bonus_amag=1-(0.02*$puser['alchemistlevel']); //100%-2%*��.��������
											$owners_magp[strval($bonus_amag)][]=$puser['owner']; //  �� ������� ������
										}
								}


							if (count($owners_all_p)>0)
								{
									$sql_protectmag="  and id not in (".implode(",",$owners_all_p).")  ";
								}

						//��� ����� ��������
						mysql_query_100("UPDATE users set hp=hp-'{$baf_dem}' where battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and hp>'{$baf_dem}' ".$sql_protectmag);
						$all_render1 = mysql_affected_rows();

						//��������� ��� � ���� ���� ������
						$all_render_porotect=array();
						$total_summ_all_pip=0;


						if (count($owners_magp)>0)
						{
						$deb_eff="Type1_battle_on_kof:{$data_battle['id']}".print_r($owners_magp,true);
									//������ ����������� �� ����� �.�. �� ������� �������
									$array_of_dm=array();
									reset($owners_magp);
									foreach ($owners_magp as $protect => $powners)
									{
											$pdmage=round($baf_dem*$protect);
											if (count($array_of_dm[$pdmage])>0)
													{
													$array_of_dm[$pdmage]=array_merge($array_of_dm[$pdmage],$powners);
													}
													else
													{
													$array_of_dm[$pdmage]=$powners;
													}
									}
						krsort($array_of_dm);
						$deb_eff.="Type1_battle_on_dm:{$data_battle['id']}".print_r($array_of_dm,true);


									foreach ($array_of_dm as $pd => $powners)
										{
										$pdmage=$pd;
										$all_pip=0;
										$deb_eff.="(1)Try dmag {$pd} to \n";
										$deb_eff.=print_r($powners,true);
											if (count($powners)>0)
											{
											mysql_query("UPDATE users set hp=hp-'".$pdmage."' where battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and hp>'".$pdmage."' and id in (".implode(",",$powners).") ");
											$all_pip = mysql_affected_rows();
											if ($all_pip>0)
												{
												$all_render_porotect[]="\n!:G:".time().":".$pdmage.":".$all_pip.":".$user['battle_t'].":".nick_new_in_battle($real_enemy).":::::".$pdmage*$all_pip.":";
												$total_summ_all_pip+=$pdmage*$all_pip;
												}
											}
										$deb_eff.="(1) Res all pip {$all_pip}  \n";
										}

						}

				 		if ($all_render1 >0 || count($all_render_porotect)>0 )
				 		{

							if($all_render1 >0)
								{
								$input_attack['text'].="\n!:G:".time().":".$baf_dem.":".$all_render1.":".$user['battle_t'].":".nick_new_in_battle($real_enemy).":::::".$baf_dem*$all_render1.":";
								$deb_eff.="log_>"."\n!:G:".time().":".$baf_dem.":".$all_render1.":".$user['battle_t'].":".nick_new_in_battle($real_enemy).":::::".$baf_dem*$all_render1.":";
								$sum_dmg_1=$all_render1*$baf_dem; // ����� ����� ����� - ��� ��� ��� ������
								}

							if (count($all_render_porotect)>0)
							{
								foreach ($all_render_porotect as $k => $render)
									{
									$input_attack['text'].=$render;
									$deb_eff.="log_>".$render;
									}
							}

							$uron_str_all = round($sum_dmg_1+$total_summ_all_pip);

							//������ ����
							$input_fix_cost_level=1; // ���� ��� ����� ��� �����
							$input_attack_magic_dem+=$uron_str_all;//����� � ��� ���� - ��� �������� �����
							$deb_eff.="total_>".$input_attack_magic_dem;
			 			}
						set_telo_mana($real_enemy,$input_attack_magic_dem);
						log_deb_eff($deb_eff);
			 		}

				}
			}
		else
//������ ������� ������ ������ - ��� ������ ����������
			if ((is_array($real_enemy_eff[130]) && $real_enemy['in_tower'] == 0) and ($input_attack['dem']>0) and ($ALLMAGIC==true) and ($ENEMY_MANA==true) )// �� � ��
				{
				$prhp=$user['hp']-$input_attack['dem'];

				//�������
				if (($real_enemy_eff[130]['lastup']>0) AND ($real_enemy['mair']<3))
					{
					$real_enemy['mair']=(int)($real_enemy_eff[130]['lastup']);
					}

				if (($prhp>0) AND ($real_enemy['mair']>0))
				{
					//���� ���� ����� � � ���� ���
					if ($real_enemy['mair']>100) { $real_enemy['mair']=100; }

					$real_enemy_mudra=$real_enemy['mudra'];

					if ($real_enemy_mudra>50) { 	$real_enemy_mudra=50 ;}

					$baf_dem_min=round($real_enemy_mudra+$real_enemy['mair']);

					$vl=explode(":",$real_enemy_eff[130]['add_info']);
					$real_enemy_eff[130]['add_info']=$vl[1];

					$baf_dem_max=((int)($real_enemy_eff[130]['add_info'])*$real_enemy['mair'])  ;

					if ($enemy_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$enemy_prof['magelevel']);
						$baf_dem_max+=(2*$enemy_prof['magelevel']);
						}

					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }

					$baf_dem_baza=mt_rand($baf_dem_min,$baf_dem_max);

					if (!(in_array(3,get_mag_stih($real_enemy,$real_enemy_eff)))) { $baf_dem_baza=(int)($baf_dem_baza*0.5); } // -50% ���� ���� ������� �� ������

					$baf_dem=round($baf_dem_baza*0.4); //�� ��� �������� ��������� � ������� � ����� �������� 40% �����

					$mag_prot_bonus=1; //100% ����
					if (is_array($user_eff[557]))
							{
							$mag_prot_bonus=$user_eff[557]['add_info'];// ��������� �� ������
							}
					if ($user_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����


					$baf_dem_f[1]=round($baf_dem_baza*0.3);//���� ������ �������� ������ +- ����� �������� 30% 20% � 10% ������������� (����� 100%)
					$baf_dem_f[2]=round($baf_dem_baza*0.2);
					$baf_dem_f[3]=round($baf_dem_baza*0.1);

					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}

						//708
						if ( (($user_eff[708]) and ($user_eff[708]['lastup']>0)) and ($prhp<=1))
						{
							//��������� ������
							$baf_dem=($user['hp']-$input_attack['dem'])-1;
							$prhp=1;
						}

						$fix706u=0;
						//�������� �� ����� 706-��
						if ( (($user_eff[706]) and ($user_eff[706]['lastup']>0)) and ($input_attack['dem']==1))
						{
							//��������� ������
							$prhp=$user['hp']-$input_attack['dem'];
							$baf_dem=0;
							$fix706u=1;
						}

					if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$user['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$user['id']}' and hp>0 LIMIT 1; ");
						}

					if ((mysql_affected_rows()>0) or ($fix706u==1) )
						{
						$uron_str=$baf_dem;
						//hidden �������������
						if (($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$user['maxhp'].']';    }
						$input_attack['text'].="\n!:Z:".time().":".nick_new_in_battle($user).":".(220+$user['sex'])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;

						$input_attack_magic_dem=$baf_dem;//����� � ��� ����

						if ($prhp<=0)
							{
							$input_attack['text'].="\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user);
							$user_mag_dead=true; // ������ ������� ��� ���� �����
							//�������� � ������
							$user['hp']=0;
							$STEP = 4;
							// �������� � ������
							if ($user['battle_t']==1)
							{unset($boec_t1[$user['id']]);}
							elseif ($user['battle_t']==2)
							 {unset($boec_t2[$user['id']]);}
							elseif ($user['battle_t']==3)
							 {unset($boec_t3[$user['id']]);}

								if (!isset($real_enemy['id_user']) AND ($user['level'] >= ($real_enemy['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
								{

									if (!isset($user_eff[5577]) || $user_eff[5577]['add_info'] < 10) {
										if(!isset($user_eff[5577])) {
											mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$user['id'].'",1999999999,1) ');
										} else {
											mysql_query('UPDATE `effects` SET add_info = '.($user_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$user['id']);
										}

										mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
										VALUES(
											'.$data_battle['id'].',
											'.$real_enemy['id'].',
											1,
											'.$real_enemy['battle_t'].'
										)
										ON DUPLICATE KEY UPDATE
											`value` = `value` + 1');
									}
								}
								elseif (!isset($real_enemy['id_user']) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($real_enemy);
								}
							}

							//���� ���������� ���� ��� ������
							$memorize=array();
							$memorize[]=$user['id']; // ���������� ��
							$filt='';
							 for ($io=1;$io<=3;$io++)
							 {
										 if (count($memorize)>0)
										{
										$filt=" and users.`id` not in  (".implode(",",$memorize).")  " ; //��������� ��� �� ��� ������ ������
										}

							 	$pesh=mysql_fetch_array(mysql_query("select users.*,effects.type, effects.add_info, (SELECT alchemistlevel FROM oldbk.users_craft WHERE owner =users.id) as alchemistlevel from  users LEFT JOIN effects ON users.id = effects.owner and effects.type = 557 where users.battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and hp>'{$baf_dem_f[$io]}' ".$filt." order by Rand() limit 1 ;"));
							 	if ($pesh['id']>0)
							 		{
									$pesh_amag=1;
									if ($pesh['type'] == 557)
										{
										$pesh_amag=$pesh['add_info'];
										}
									if ($pesh['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
										{
										$pesh_amag-=(0.02*$pesh['alchemistlevel']); //��������� �� �����
										}
									$baf_dem_f[$io] = round($baf_dem_f[$io] * $pesh_amag); // ������ �� �����

							 		mysql_query("UPDATE users set hp=hp-'{$baf_dem_f[$io]}' where id='{$pesh['id']}' and hp>'{$baf_dem_f[$io]}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
									 				$memorize[]=$pesh['id']; // ���������� ��
			 										$uron_str=$baf_dem_f[$io];
			 										$pesh['hp']-=$baf_dem_f[$io];
													if (($pesh['hidden'] > 0) and ($pesh['hiddenlog'] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem_f[$io]."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$input_attack['text'].="\n!:Z:".time().":".nick_new_in_battle($pesh).":".(220+$pesh['sex'])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;
													$input_attack_magic_dem+=$baf_dem_f[$io];//����� � ��� ����
								 				}
							 		}
							 		else
							 		{
							 		break ;
							 		}
							 }



						set_telo_mana($real_enemy,$input_attack_magic_dem);
						}
				}
			}
			else
			//����� �� �����- ��� ������ ����������
			if ((is_array($real_enemy_eff[150]) && $real_enemy['in_tower'] == 0) and ($input_attack['dem']>0) and ($ALLMAGIC==true) and ($ENEMY_MANA==true) )// �� � ��
				{

				$prhp=$user['hp']-$input_attack['dem'];

				//�������
				if (($real_enemy_eff[150]['lastup']>0) AND ($real_enemy['mfire']<3))
					{
					$real_enemy['mfire']=(int)($real_enemy_eff[150]['lastup']);
					}

				if (($prhp>0) AND ($real_enemy['mfire']>0))
				{
					//���� ���� ����� � � ���� ���
					if ($real_enemy['mfire']>100) { $real_enemy['mfire']=100; }

					$real_enemy_mudra=$real_enemy['mudra'];
					if ($real_enemy_mudra>50) { 	$real_enemy_mudra=50 ;}
					$baf_dem_min=round(($real_enemy_mudra)+$real_enemy['mfire']);

					$vl=explode(":",$real_enemy_eff[150]['add_info']);
					$real_enemy_eff[150]['add_info']=$vl[1];

					$baf_dem_max=((int)($real_enemy_eff[150]['add_info'])*$real_enemy['mfire'])  ;


					if ($enemy_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$enemy_prof['magelevel']);
						$baf_dem_max+=(2*$enemy_prof['magelevel']);
						}

					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min<1) {$baf_dem_min=1; }
					if ($baf_dem_max<1) {$baf_dem_max=1; }

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }



					$baf_dem=mt_rand($baf_dem_min,$baf_dem_max);

					if (!(in_array(1,get_mag_stih($real_enemy,$real_enemy_eff))) ) { $baf_dem=(int)($baf_dem*0.5) ;  } // -50% ���� ���� ������� �� ������


					$mag_prot_bonus=1; //100% ����
					if (is_array($user_eff[557]))
							{
							$mag_prot_bonus=$user_eff[557]['add_info'];// ��������� �� ������
							}
					if ($user_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����


					if ($baf_dem<$prhp) {$prhp-=$baf_dem;  }else {$prhp=0; }


					//708
					if ( (($user_eff[708]) and ($user_eff[708]['lastup']>0)) and ($prhp<=1))
					{
						//��������� ������
						$baf_dem=($user['hp']-$input_attack['dem'])-1;
						$prhp=1;
					}

					$fix706u=0;
					//�������� �� ����� 706-��
					if ( (($user_eff[706]) and ($user_eff[706]['lastup']>0)) and ($input_attack['dem']==1))
					{
						//��������� ������
						$prhp=$user['hp']-$input_attack['dem'];
						$baf_dem=0;
						$fix706u=1;
					}


					if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$user['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$user['id']}' and hp>0 LIMIT 1; ");
						}

					if ( (mysql_affected_rows()>0) or ($fix706u==1) )
						{
						$uron_str=$baf_dem;
						//hidden �������������
						if (($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$user['maxhp'].']';    }
						$input_attack['text'].="\n!:Y:".time().":".nick_new_in_battle($user).":".(220+$user['sex'])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;

						if ($prhp<=0)
							{
							$input_attack['text'].="\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user);
							$user_mag_dead=true; // ������ ������� ��� ���� �����
							//�������� � ������
							$user['hp']=0;
							$STEP = 4;
							// �������� � ������
							if ($user['battle_t']==1)
							{unset($boec_t1[$user['id']]);}
							elseif ($user['battle_t']==2)
							 {unset($boec_t2[$user['id']]);}
							elseif ($user['battle_t']==3)
							 {unset($boec_t3[$user['id']]);}

								if (!isset($real_enemy['id_user']) AND ($user['level'] >= ($real_enemy['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
								{

									if (!isset($user_eff[5577]) || $user_eff[5577]['add_info'] < 10) {
										if(!isset($user_eff[5577])) {
											mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$user['id'].'",1999999999,1) ');
										} else {
											mysql_query('UPDATE `effects` SET add_info = '.($user_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$user['id']);
										}

										mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
										VALUES(
											'.$data_battle['id'].',
											'.$real_enemy['id'].',
											1,
											'.$real_enemy['battle_t'].'
										)
										ON DUPLICATE KEY UPDATE
											`value` = `value` + 1');
									}
								}
								elseif (!isset($real_enemy['id_user']) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($real_enemy);
								}
							}

						$input_attack_magic_dem=$baf_dem;
						set_telo_mana($real_enemy,$input_attack_magic_dem);
						}
				}
				}
////////////////////////////////////////////////////////
// ������� ��� �������� ������ ����� ��� � �����
if (($ALLMAGIC!=true ) and ($USER_MANA==true))
{
//����� �������� �� �������� ����� ������ ���� ����

		if ( ( ( (is_array($user_eff[150])) OR (is_array($user_eff[930])) OR (is_array($user_eff[920])) OR (is_array($user_eff[130]) ) )  && $user['in_tower'] == 0) and ($output_attack['dem']>0) )// �� � ��
		//���� ����� ������ + ����
				{
				$prhp=$real_enemy['hp']-$output_attack['dem'];

					if (is_array($user_eff[150]))
						{
						$user_mast=$user['mfire'];
						}
						elseif (is_array($user_eff[930]))
						{
						$user_mast=$user['mwater'];
						}
						elseif (is_array($user_eff[920]))
						{
						$user_mast=$user['mearth'];
						}
						elseif (is_array($user_eff[130]))
						{
						$user_mast=$user['mair'];
						}


				if (($prhp>0) AND ($user_mast>0))
				{
					if ($user_mast>100) { $user_mast=100; }

					$user_mudra=$user['mudra'];
					if ($user_mudra>50) {$user_mudra=50; }

					//���� ���� ����� � � ���� ���
					$baf_dem_min=$user_mudra+($user_mast*2);
					$baf_dem_max=10*$user_mast;

					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$user_prof['magelevel']);
						$baf_dem_max+=(2*$user_prof['magelevel']);
						}

					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min<1) {$baf_dem_min=1; }
					if ($baf_dem_max<1) {$baf_dem_max=1; }

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }

					$baf_dem=mt_rand($baf_dem_min,$baf_dem_max);

					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}

					//708
					if ( (($real_enemy_eff[708]) and ($real_enemy_eff[708]['lastup']>0)) and ($prhp<=1))
					{
						//��������� ������
						$baf_dem=($real_enemy['hp']-$output_attack['dem'])-1;
						$prhp=1;
					}

					//�������� �� ����� 706-��
					$fix706u=0;
					if ( (($real_enemy_eff[706]) and ($real_enemy_eff[706]['lastup']>0)) and ($output_attack['dem']==1) )
					{
						//��������� ������
						$prhp=$real_enemy['hp']-$output_attack['dem'];
						$baf_dem=0;
						$fix706u=1;
					}

					if ($real_enemy['id'] < _BOTSEPARATOR_ )
					{
					//for real users
						if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
					}
					else
					{
					//for  clons and bots
						if ($prhp>0)
						{
						mysql_query("UPDATE users_clons set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users_clons set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						if (($user['lab']>0) AND ($real_enemy['id_user'] > 0))
							{
							count_rep_lab($user,$real_enemy);
							}
						}
					}

					if ((mysql_affected_rows()>0) or ($fix706u==1) )
					{

					$uron_str=$baf_dem;
					//hidden �������������
					if  (  (($real_enemy['hidden'] > 0) and ($real_enemy['hiddenlog'] =='')) OR ( strpos($real_enemy['login'],"��������� (����" ) !== FALSE ) )
 	               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$real_enemy['maxhp'].']';    }
					$output_attack['text'].="\n!:O:".time().":".nick_new_in_battle($real_enemy).":".(220+$real_enemy['sex'])."::".nick_new_in_battle($user).":::::".$uron_str.":".$txtdm;

					if ($prhp<=0)
							{
							$input_attack['text'].="\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy);
							$enemy_mag_dead=true; // ������ ������� ��� ����  �����
							// ����
							if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
							elseif ($real_enemy['battle_t']==2)  {unset($boec_t2[$real_enemy['id']]) ;}
							elseif ($real_enemy['battle_t']==3)  {unset($boec_t3[$real_enemy['id']]) ;}
							/*
							if (!isset($real_enemy[id_user]) AND ($real_enemy['level'] >= ($user['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
								{

									if (!isset($real_enemy_eff[5577]) || $real_enemy_eff[5577]['add_info'] < 10) {
										if(!isset($real_enemy_eff[5577])) {
											mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$real_enemy['id'].'",1999999999,1) ');
										} else {
											mysql_query('UPDATE `effects` SET add_info = '.($real_enemy_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$real_enemy['id']);
										}

										mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
										VALUES(
											'.$data_battle['id'].',
											'.$user['id'].',
											1,
											'.$user['battle_t'].'
										)
										ON DUPLICATE KEY UPDATE
											`value` = `value` + 1');
									}

							 	}
							*/
							}


					$output_attack_magic_dem=$baf_dem;
					set_telo_mana($user,$output_attack_magic_dem);
					}
				}
				}
}
else
//930 - ���� ���� �� �����
if ((is_array($user_eff[930]) && $user['in_tower'] == 0) and ($output_attack['dem']==0) and ($ALLMAGIC==true) and ($USER_MANA==true) )// �� � ��
	{
	//�� ���� ����� - ������ ����� ��� ������� ������� ���������
	mysql_query("UPDATE `effects` SET add_info='0'  where owner='{$user['id']}' AND type=930");
	$user_eff[930]['add_info']=0;
	}
else
//930 -����
if ((is_array($user_eff[930]) && $user['in_tower'] == 0) and ($output_attack['dem']>0) and ($ALLMAGIC==true) and ($USER_MANA==true) )// �� � ��
				{
				$prhp=$real_enemy['hp']-$output_attack['dem'];
				if ($user_eff[930]['add_info']<4)
					{
					//������ +1 ������� ���� ���� �������� 4 � ����
					mysql_query("UPDATE `effects` SET add_info=add_info+1  where owner='{$user['id']}' AND type=930");
					}

				//�������
				if (($user_eff[930]['lastup']>0) AND ($user['mwater']<3))
					{
					$user['mwater']=(int)($user_eff[930]['lastup']);
					}

				if (($prhp>0) AND ($user['mwater']>0))
				{
					if ($user['mwater']>100) { $user['mwater']=100; }

					$user_mudra=round($user['mudra']);

					if ($user_mudra>50) {$user_mudra=50;}

					$baf_dem_min=(int)($user_mudra+$user['mwater']) ;
					$baf_dem_max=(int)($user['mwater']*10)  ; //������ ������ = ������������� �����

					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$user_prof['magelevel']);
						$baf_dem_max+=(2*$user_prof['magelevel']);
						}

					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_max<1) {$baf_dem_max=1;}
					if ($baf_dem_min<1) {$baf_dem_min=1;}

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }

					$baf_dem_baza=mt_rand($baf_dem_min,$baf_dem_max); //100%

					if (!(in_array(4,get_mag_stih($user,$user_eff)))) { $baf_dem_baza=(int)($baf_dem_baza*0.5); } // -50% ���� ���� ������� �� ������

					$koluda=(int)($user_eff[930]['add_info']); // ��� �������� ������� ������ ������� ������

					$demag[0][0]=1; //��� ������ ������� ��������� ������� ���� ���� 100% �� ����������
					$demag[1][0]=0.5; $demag[1][1]=0.5; //��� ������ (������ ���� �����) ������� ������� 50% � �������� +- ����� 50%
					$demag[2][0]=0.5; $demag[2][1]=0.25; $demag[2][2]=0.25; //��� ������� (������ ����� ��) ������� ������� 50% ������� �������� 25% �������� 25%
					$demag[3][0]=0.5; $demag[3][1]=0.1;   $demag[3][2]=0.2; $demag[4][3]=0.3; //��� ��������� (������) ������� 50% ������� 30% �������� 20% ���������� 10%
					$demag[4][0]=0.4; $demag[4][1]=0.1;   $demag[4][2]=0.1; $demag[4][3]=0.2;  $demag[4][4]=0.3; //	��� ����� ����� (������) ������� 40% ������� 30% �������� 20% ����������� � ������ �� 10%

					$demaga=$demag[$koluda]; //����������  ������ ����� ��� ���������� ������� ����������

					$baf_dem=round($baf_dem_baza*$demaga[0]); // [0] = ���� ��� ������ ������


					$mag_prot_bonus=1; //100% ����
					if (is_array($real_enemy_eff[557]))
							{
							$mag_prot_bonus=$real_enemy_eff[557]['add_info'];// ��������� �� ������
							}
					if ($enemy_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����

					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}


					//708
					if ( (($real_enemy_eff[708]) and ($real_enemy_eff[708]['lastup']>0)) and ($prhp<=1))
					{
						//��������� ������
						$baf_dem=($real_enemy['hp']-$output_attack['dem'])-1;
						$prhp=1;
					}

					//�������� �� ����� 706-��
					$fix706u=0;
					if ( (($real_enemy_eff[706]) and ($real_enemy_eff[706]['lastup']>0)) and ($output_attack['dem']==1) )
					{
						//��������� ������
						$prhp=$real_enemy['hp']-$output_attack['dem'];
						$baf_dem=0;
						$fix706u=1;
					}


					if ($real_enemy['id'] < _BOTSEPARATOR_ )
					{
					//for real users
						if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
					}
					else
					{
					//for  clons and bots
						if ($prhp>0)
						{
						mysql_query("UPDATE users_clons set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users_clons set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						if (($user['lab']>0) AND ($real_enemy['id_user'] > 0))
							{
							count_rep_lab($user,$real_enemy);
							}
						}
					}

					if ((mysql_affected_rows()>0) or ($fix706u==1) )
					{

					$uron_str=$baf_dem;
					$output_attack_magic_dem=$baf_dem;
					//hidden �������������
					if  (  (($real_enemy['hidden'] > 0) and ($real_enemy['hiddenlog'] =='')) OR ( strpos($real_enemy['login'],"��������� (����" ) !== FALSE ) )
 	               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$real_enemy['maxhp'].']';    }
					$output_attack['text'].="\n!:L:".time().":".nick_new_in_battle($real_enemy).":".(220+$real_enemy['sex'])."::".nick_new_in_battle($user).":::::".$uron_str.":".$txtdm;

					if ($prhp<=0)
							{
							$input_attack['text'].="\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy);
							$enemy_mag_dead=true; // ������ ������� ��� ����  �����
							// ����
							if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
							elseif ($real_enemy['battle_t']==2)  {unset($boec_t2[$real_enemy['id']]) ;}
							elseif ($real_enemy['battle_t']==3)  {unset($boec_t3[$real_enemy['id']]) ;}
							if (!isset($real_enemy['id_user']) AND ($real_enemy['level'] >= ($user['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
								{

									if (!isset($real_enemy_eff[5577]) || $real_enemy_eff[5577]['add_info'] < 10) {
										if(!isset($real_enemy_eff[5577])) {
											mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$real_enemy['id'].'",1999999999,1) ');
										} else {
											mysql_query('UPDATE `effects` SET add_info = '.($real_enemy_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$real_enemy['id']);
										}

										mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
										VALUES(
											'.$data_battle['id'].',
											'.$user['id'].',
											1,
											'.$user['battle_t'].'
										)
										ON DUPLICATE KEY UPDATE
											`value` = `value` + 1');
									}

							 	}
							 	elseif (!isset($real_enemy['id_user']) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($user);
								}
							}

						if ($koluda>0) // ����  ���� ��� ������� �����
							{
							//���� ���������� ���� ��� ������
							$memorize=array();
							$memorize[]=$real_enemy['id']; // ���������� ��
							$filt='';
							 for ($io=1;$io<count($demaga);$io++) // � ������!!
							 {
								if (count($memorize)>0)
										{
										$filt=" and users.`id` not in  (".implode(",",$memorize).")  " ; //��������� ��� �� ��� ������ ������
										}
						 		$demaga[$io]=round($baf_dem_baza*$demaga[$io]);

							 	$pesh=mysql_fetch_array(mysql_query("select users.*,effects.type,effects.add_info, (SELECT alchemistlevel FROM oldbk.users_craft WHERE owner =users.id) as alchemistlevel from users LEFT JOIN effects ON users.id = effects.owner and effects.type = 557 where users.battle='{$data_battle['id']}' and battle_t='{$real_enemy['battle_t']}' and (level>=".($user['level']-1)." and level<=".($user['level']+1).")  and  hp>'{$demaga[$io]}'  ".$filt." order by Rand() limit 1;"));
							 	if ($pesh['id']>0)
							 		{

									$pesh_amag=1;
									if ($pesh['type'] == 557)
										{
										$pesh_amag=$pesh['add_info'];
										}
									if ($pesh['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
										{
										$pesh_amag-=(0.02*$pesh['alchemistlevel']); //��������� �� �����
										}
									$demaga[$io] = round($demaga[$io] * $pesh_amag); // ������ �� �����

							 		mysql_query("UPDATE users set hp=hp-'{$demaga[$io]}' where id='{$pesh['id']}' and hp>'{$demaga[$io]}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
								 				$memorize[]=$pesh['id']; // ���������� ��

			 										$uron_str=$demaga[$io];
			 										$pesh['hp']-=$demaga[$io];
													if (($pesh['hidden'] > 0) and ($pesh['hiddenlog'] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$demaga[$io]."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$input_attack['text'].="\n!:L:".time().":".nick_new_in_battle($pesh).":".(220+$pesh['sex'])."::".nick_new_in_battle($user).":::::".$uron_str.":".$txtdm;
													$output_attack_magic_dem+=$demaga[$io];//����� � ��� ����
								 				}
							 		}
							 		else
							 		{
							 		break ;
							 		}
							 }
							 }


					//output_attack_magic_dem ��� ����
					//�������� ����
					set_telo_mana($user,$output_attack_magic_dem);
					}
				}
			}
	else
//������ ��� - �����
		if ((is_array($user_eff[920]) && $user['in_tower'] == 0) and ($output_attack['dem']>0) and ($ALLMAGIC==true) and ($USER_MANA==true) )// �� � ��
				{
				$prhp=$real_enemy['hp']-$output_attack['dem'];

				//�������
				if (($user_eff[920]['lastup']>0) AND ($user['mearth']<1))
					{
					$user['mearth']=(int)($user_eff[920]['lastup']);
					}

				if (($prhp>0) AND ($user['mearth']>0))
				{
					if ($user['mearth']>100) { $user['mearth']=100; }

					$user_mudra=round($user['mudra']);
					if ($user_mudra>50) { $user_mudra=50; }

					$baf_dem_min=(int)($user_mudra/5) ; //5 �������� - 1 ����������� ����
					$baf_dem_max=(int)($user['mearth'])  ; //������ ������ = ������������� �����


					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$user_prof['magelevel']);
						$baf_dem_max+=(2*$user_prof['magelevel']);
						}

					if ($baf_dem_min<1) {$baf_dem_min=1; }
					if ($baf_dem_max<1) {$baf_dem_max=1;}

					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }

					$baf_dem=mt_rand($baf_dem_min,$baf_dem_max); // ����

					if (!(in_array(2,get_mag_stih($user,$user_eff)))) { $baf_dem=(int)($baf_dem*0.5);  } // -50% ���� ���� ������� �� ������
					$baf_dem=(int)($baf_dem*0.5);
					if ($baf_dem < 1) $baf_dem = 1;



					/*$mag_prot_bonus=1; //100% ����
					if (is_array($real_enemy_eff[557]))
							{
							$mag_prot_bonus=$real_enemy_eff[557]['add_info'];// ��������� �� ������
							}
					if ($enemy_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����
					*/


					/* ������
					//���� ���������� ����  ��� ���
					$get_all_life=mysql_query("select * from users where battle='{$data_battle['id']}' and battle_t='{$real_enemy['battle_t']}'  and hp>'{$baf_dem}'  ;");
					$all_cast=mysql_num_rows($get_all_life);

							if ($all_cast>0)
							{
							$mass_magic_data='';
							$uron_str=0;
							$uron_str_all=0;
							$all_render=0;
							while($pesh = mysql_fetch_array($get_all_life))
							 {
							 	if ($pesh['id']>0)
							 		{
							 		mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$pesh['id']}' and hp>'{$baf_dem}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
								 				$all_render++;
			 										$uron_str=$baf_dem;
			 										$pesh['hp']-=$baf_dem;
			 										$uron_str_all+=$baf_dem; // ����� ���� �� ���� ��� ����������
													if (($pesh['hidden'] > 0) and ($pesh['hiddenlog'] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$mass_magic_data.=nick_new_in_battle($pesh)."#".(220+$pesh['sex'])."#".$uron_str."#".$txtdm."#";
													$output_attack_magic_dem+=$baf_dem;//����� � ��� ���� - ��� �������� �����
								 				}
							 		}
							 }

 							$input_attack['text'].="\n!:J:".time().":".$mass_magic_data.":".$all_render."::".nick_new_in_battle($user).":::::".$uron_str_all.":";
							 }
					*/
					if ($baf_dem>0)
					{

							//�������� ���� � ���� ������ �� �����
							$owners_all_p=array();
							$owners_magp=array();
							$sql_protectmag="";

							$get_all_magprot=mysql_query("SELECT * FROM effects WHERE type = 557 and battle='{$data_battle['id']}'");
							while($puser = mysql_fetch_array($get_all_magprot))
								{
								$owners_all_p[]=$puser['owner']; //�� ���� � ���� ������ �����
								$owners_magp[strval($puser['add_info'])][]=$puser['owner']; // �� �� ������� ������
								}

							//�������� ���� � ���� ������� �������� ������ 0 � ������ ��� � ������ �������
							$get_all_magprot=mysql_query("SELECT owner, alchemistlevel FROM oldbk.users_craft WHERE owner in (select id from users where battle='{$data_battle['id']}' and battle_t='{$real_enemy['battle_t']}' and hp>0) and alchemistlevel>0");
							while($puser = mysql_fetch_array($get_all_magprot))
								{
								$tkey = array_search($puser['owner'], $owners_all_p);  // ���� ����� ������������ � ������ � �������� �������
								if ($tkey !== false)
										{
										//���� ��� ��������� �� ����
										// ���� ����������� �� ���� � ������  ��������
												reset($owners_magp);
												foreach ($owners_magp as $pct => $pow)
												{
														//���� ��  id  ���� � ������ $pow
														$dlkey = array_search($puser['owner'], $pow);
														if ($dlkey !== false)
																{
																//�����
																//������� �� �� ������
																unset($owners_magp[$pct][$dlkey]);
																//������ ��������� � ����� ������ ��������� ��� ����
																// ������ ����� $pct - (0.02*$puser['alchemistlevel'])
																$new_pct=$pct-(0.02*$puser['alchemistlevel']); // ��� ���. �����
																//������ �� ���� � ���������� ������
																$owners_magp[strval($new_pct)][]=$puser['owner'];
																//����� �������
																break;
																}
												}
										}
										else
										{
										//���� ������ ��������� � ������ ������
											$owners_all_p[]=$puser['owner']; //�� ����
											$bonus_amag=1-(0.02*$puser['alchemistlevel']); //100%-2%*��.��������
											$owners_magp[strval($bonus_amag)][]=$puser['owner']; //  �� ������� ������
										}
								}


							if (count($owners_all_p)>0)
								{
									$sql_protectmag="  and id not in (".implode(",",$owners_all_p).")  ";
								}

					//��� ����� ��������
					mysql_query_100("UPDATE users set hp=hp-'{$baf_dem}' where battle='{$data_battle['id']}' and  battle_t='{$real_enemy['battle_t']}'   and hp>'{$baf_dem}' ".$sql_protectmag);
					$all_render1=mysql_affected_rows();

						//��������� ��� � ���� ���� ������
						$all_render_porotect=array();
						$total_summ_all_pip=0;

						if (count($owners_magp)>0)
						{

						$deb_eff="Type2_battle_on_kof:{$data_battle['id']}".print_r($owners_magp,true);
									//������ ����������� �� ����� �.�. �� ������� �������
									$array_of_dm=array();
									reset($owners_magp);
									foreach ($owners_magp as $protect => $powners)
									{
											$pdmage=round($baf_dem*$protect);
											if (count($array_of_dm[$pdmage])>0)
													{
													$array_of_dm[$pdmage]=array_merge($array_of_dm[$pdmage],$powners);
													}
													else
													{
													$array_of_dm[$pdmage]=$powners;
													}
									}
									krsort($array_of_dm);
						$deb_eff.="Type2_battle_on_dm:{$data_battle['id']}".print_r($array_of_dm,true);


									foreach ($array_of_dm as $pd => $powners)
										{
										$pdmage=$pd;
										$all_pip=0;
										$deb_eff.="(2)Try dmag {$pd} to \n";
										$deb_eff.=print_r($powners,true);
											if (count($powners)>0)
											  {
											mysql_query("UPDATE users set hp=hp-'".$pdmage."' where battle='{$data_battle['id']}' and battle_t='{$real_enemy['battle_t']}'   and hp>'".$pdmage."' and id in (".implode(",",$powners).") ");
											$all_pip = mysql_affected_rows();
											if ($all_pip>0)
												{
												$all_render_porotect[]="\n!:G:".time().":".$pdmage.":".$all_pip.":".$real_enemy['battle_t'].":".nick_new_in_battle($user).":::::".$pdmage*$all_pip.":";
												$total_summ_all_pip+=$pdmage*$all_pip;
												}
										  	}
										$deb_eff.="(2) Res all pip {$all_pip}  \n";
										}


						}

				 		if ($all_render1 >0 || count($all_render_porotect)>0 )
				 		{
							if($all_render1 >0)
								{
								$input_attack['text'].="\n!:G:".time().":".$baf_dem.":".$all_render1.":".$real_enemy['battle_t'].":".nick_new_in_battle($user).":::::".$baf_dem*$all_render1.":";
								$deb_eff.="log_>"."\n!:G:".time().":".$baf_dem.":".$all_render1.":".$real_enemy['battle_t'].":".nick_new_in_battle($user).":::::".$baf_dem*$all_render1.":";
								$sum_dmg_1=$all_render1*$baf_dem; // ����� ����� ����� - ��� ��� ��� ������
								}

								if (count($all_render_porotect)>0)
								{
									foreach ($all_render_porotect as $k => $render)
										{
										$input_attack['text'].=$render;
										$deb_eff.="log_>".$render;
										}
								}
							$uron_str_all = round($sum_dmg_1+$total_summ_all_pip);

							//������ ����
							$output_fix_cost_level=1; // ���� ��� ����� ��� �����
							$output_attack_magic_dem+=$uron_str_all;//����� � ��� ���� - ��� �������� �����
							$deb_eff.="total_>".$output_attack_magic_dem;

							set_telo_mana($user,$output_attack_magic_dem);

				 		}

				 		log_deb_eff($deb_eff);

			 		}
				}
			}
			else
//������ ������� ������ ������ - ��� ������ �����
			if ((is_array($user_eff[130]) && $user['in_tower'] == 0) and ($output_attack['dem']>0) and ($ALLMAGIC==true) and ($USER_MANA==true) )// �� � ��
				{
				$prhp=$real_enemy['hp']-$output_attack['dem'];

				//�������
				if (($user_eff[130]['lastup']>0) AND ($user['mair']<3))
					{
					$user['mair']=(int)($user_eff[130]['lastup']);
					}

				if (($prhp>0) AND ($user['mair']>0))
				{
					if ($user['mair']>100) { $user['mair']=100; }
					//���� ���� ����� � � ���� ���
					$user_mudra=$user['mudra'];
					if ($user_mudra>50) {$user_mudra=50; }

					$baf_dem_min=round(($user_mudra)+$user['mair']);

					$vl=explode(":",$user_eff[130]['add_info']);
					$user_eff[130]['add_info']=$vl[1];

					$baf_dem_max=((int)($user_eff[130]['add_info'])*$user['mair']);

					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$user_prof['magelevel']);
						$baf_dem_max+=(2*$user_prof['magelevel']);
						}

					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }

					$baf_dem_baza=mt_rand($baf_dem_min,$baf_dem_max);
					if (!(in_array(3,get_mag_stih($user,$user_eff)))) { $baf_dem_baza=(int)($baf_dem_baza*0.5); } // -50% ���� ���� ������� �� ������

					$baf_dem=round($baf_dem_baza*0.4); //�� ��� �������� ��������� � ������� � ����� �������� 40% �����

					$baf_dem_f[1]=round($baf_dem_baza*0.3);//���� ������ �������� ������ +- ����� �������� 30% 20% � 10% ������������� (����� 100%)
					$baf_dem_f[2]=round($baf_dem_baza*0.2);
					$baf_dem_f[3]=round($baf_dem_baza*0.1);


					$mag_prot_bonus=1; //100% ����
					if (is_array($real_enemy_eff[557]))
							{
							$mag_prot_bonus=$real_enemy_eff[557]['add_info'];// ��������� �� ������
							}
					if ($enemy_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����


					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}

					if ($real_enemy['id'] < _BOTSEPARATOR_ )
					{
					//for real users
						if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
					}
					else
					{
					//for  clons and bots
						if ($prhp>0)
						{
						mysql_query("UPDATE users_clons set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users_clons set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						if (($user['lab']>0) AND ($real_enemy['id_user'] > 0))
							{
							count_rep_lab($user,$real_enemy);
							}
						}
					}

					//708
					if ( (($real_enemy_eff[708]) and ($real_enemy_eff[708]['lastup']>0)) and ($prhp<=1))
					{
						//��������� ������
						$baf_dem=($real_enemy['hp']-$output_attack['dem'])-1;
						$prhp=1;
					}

					//�������� �� ����� 706-��
					$fix706u=0;
					if ( (($real_enemy_eff[706]) and ($real_enemy_eff[706]['lastup']>0)) and ($output_attack['dem']==1) )
					{
						//��������� ������
						$prhp=$real_enemy['hp']-$output_attack['dem'];
						$baf_dem=0;
						$fix706u=1;
					}


					if ( (mysql_affected_rows()>0) or ($fix706u==1) )
					{

					$uron_str=$baf_dem;
					$output_attack_magic_dem=$baf_dem;
					//hidden �������������
					if  (  (($real_enemy['hidden'] > 0) and ($real_enemy['hiddenlog'] =='')) OR ( strpos($real_enemy['login'],"��������� (����" ) !== FALSE ) )
 	               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$real_enemy['maxhp'].']';    }
					$output_attack['text'].="\n!:Z:".time().":".nick_new_in_battle($real_enemy).":".(220+$real_enemy['sex'])."::".nick_new_in_battle($user).":::::".$uron_str.":".$txtdm;

					if ($prhp<=0)
							{
							$input_attack['text'].="\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy);
							$enemy_mag_dead=true; // ������ ������� ��� ����  �����
							// ����
							if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
							elseif ($real_enemy['battle_t']==2)  {unset($boec_t2[$real_enemy['id']]) ;}
							elseif ($real_enemy['battle_t']==3)  {unset($boec_t3[$real_enemy['id']]) ;}

							if (!isset($real_enemy['id_user']) AND ($real_enemy['level'] >= ($user['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
								{

									if (!isset($real_enemy_eff[5577]) || $real_enemy_eff[5577]['add_info'] < 10) {
										if(!isset($real_enemy_eff[5577])) {
											mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$real_enemy['id'].'",1999999999,1) ');
										} else {
											mysql_query('UPDATE `effects` SET add_info = '.($real_enemy_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$real_enemy['id']);
										}

										mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
										VALUES(
											'.$data_battle['id'].',
											'.$user['id'].',
											1,
											'.$user['battle_t'].'
										)
										ON DUPLICATE KEY UPDATE
											`value` = `value` + 1');
									}

							 	}
							 	elseif (!isset($real_enemy['id_user']) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($user);
								}
							}

					//���� ���������
							//���� ���������� ���� ��� ������
							$memorize=array();
							$memorize[]=$real_enemy['id']; // ���������� ��
							$filt='';
							 for ($io=1;$io<=3;$io++)
							 {
								if (count($memorize)>0)
										{
										$filt=" and users.`id` not in  (".implode(",",$memorize).")  " ; //��������� ��� �� ��� ������ ������
										}


							 	$pesh=mysql_fetch_array(mysql_query("select users.*,effects.type,effects.add_info, (SELECT alchemistlevel FROM oldbk.users_craft WHERE owner =users.id) as alchemistlevel from users LEFT JOIN effects ON users.id = effects.owner and effects.type = 557 where users.battle='{$data_battle['id']}' and battle_t='{$real_enemy['battle_t']}' and hp>'{$baf_dem_f[$io]}'  ".$filt." order by Rand() limit 1;"));
							 	if ($pesh['id']>0)
							 		{
									$pesh_amag=1;
									if ($pesh['type'] == 557)
										{
										$pesh_amag=$pesh['add_info'];
										}
									if ($pesh['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
										{
										$pesh_amag-=(0.02*$pesh['alchemistlevel']); //��������� �� �����
										}
									$baf_dem_f[$io] = round($baf_dem_f[$io] * $pesh_amag); // ������ �� �����

							 		mysql_query("UPDATE users set hp=hp-'{$baf_dem_f[$io]}' where id='{$pesh['id']}' and hp>'{$baf_dem_f[$io]}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
								 				$memorize[]=$pesh['id']; // ���������� ��

			 										$uron_str=$baf_dem_f[$io];
			 										$pesh['hp']-=$baf_dem_f[$io];
													if (($pesh['hidden'] > 0) and ($pesh['hiddenlog'] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem_f[$io]."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$input_attack['text'].="\n!:Z:".time().":".nick_new_in_battle($pesh).":".(220+$pesh['sex'])."::".nick_new_in_battle($user).":::::".$uron_str.":".$txtdm;
													$output_attack_magic_dem+=$baf_dem_f[$io];//����� � ��� ����
								 				}
							 		}
							 		else
							 		{
							 		break ;
							 		}
							 }


					set_telo_mana($user,$output_attack_magic_dem);
					}
				}
			}
			else
//�� ����� ��� �����
			if ((is_array($user_eff[150]) && $user['in_tower'] == 0) and ($output_attack['dem']>0) and ($ALLMAGIC==true) and ($USER_MANA==true) )// �� � ��
				{
				$prhp=$real_enemy['hp']-$output_attack['dem'];

				//�������
				if (($user_eff[150]['lastup']>0) AND ($user['mfire']<3))
					{
					$user['mfire']=(int)($user_eff[150]['lastup']);
					}

				if (($prhp>0) AND ($user['mfire']>0))
				{
					if ($user['mfire']>100) { $user['mfire']=100; }

					$user_mudra=$user['mudra'];
					if ($user_mudra>50) {$user_mudra=50; }

					//���� ���� ����� � � ���� ���
					$baf_dem_min=round(($user_mudra)+$user['mfire']);

					$vl=explode(":",$user_eff[150]['add_info']);
					$user_eff[150]['add_info']=$vl[1];

					$baf_dem_max=((int)($user_eff[150]['add_info'])*$user['mfire']);


					if ($user_prof['magelevel']>0)
						{
						// ���     ����� ����������� �����:      1-10 �� ������ ������� ���������� (� ����������� � ������������ ����)
						$baf_dem_min+=(1*$user_prof['magelevel']);
						$baf_dem_max+=(2*$user_prof['magelevel']);
						}


					if ($baf_dem_min>1000) {$baf_dem_min=1000; }
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min<1) {$baf_dem_min=1; }
					if ($baf_dem_max<1) {$baf_dem_max=1; }

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }

					$baf_dem=mt_rand($baf_dem_min,$baf_dem_max);

					if (!(in_array(1,get_mag_stih($user,$user_eff)))) { $baf_dem=(int)($baf_dem*0.5); } // -50% ���� ���� ������� �� ������


					$mag_prot_bonus=1; //100% ����
					if (is_array($real_enemy_eff[557]))
							{
							$mag_prot_bonus=$real_enemy_eff[557]['add_info'];// ��������� �� ������
							}
					if ($enemy_prof['alchemistlevel']>0)		//  �������      ������ �� �����:+...%      2% �� ������ ������� ����������
						{
						$mag_prot_bonus-=(0.02*$user_prof['alchemistlevel']); //��������� �� �����
						}
					$baf_dem = round($baf_dem * $mag_prot_bonus); //�������� ������ �� �����


					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}


					//708
					if ( (($real_enemy_eff[708]) and ($real_enemy_eff[708]['lastup']>0)) and ($prhp<=1))
					{
						//��������� ������
						$baf_dem=($real_enemy['hp']-$output_attack['dem'])-1;
						$prhp=1;
					}

					//�������� �� ����� 706-��
					$fix706u=0;
					if ( (($real_enemy_eff[706]) and ($real_enemy_eff[706]['lastup']>0)) and ($output_attack['dem']==1) )
					{
						//��������� ������
						$prhp=$real_enemy['hp']-$output_attack['dem'];
						$baf_dem=0;
						$fix706u=1;
					}

					if ($real_enemy['id'] < _BOTSEPARATOR_ )
					{
					//for real users
						if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
					}
					else
					{
					//for  clons and bots
						if ($prhp>0)
						{
						mysql_query("UPDATE users_clons set hp=hp-'{$baf_dem}' where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users_clons set hp=0 where id='{$real_enemy['id']}' and hp>0 LIMIT 1; ");
						if (($user['lab']>0) AND ($real_enemy['id_user'] > 0))
							{
							count_rep_lab($user,$real_enemy);
							}
						}
					}

					if ((mysql_affected_rows()>0) or ($fix706u==1) )
					{

					$uron_str=$baf_dem;
					//hidden �������������
					if  (  (($real_enemy['hidden'] > 0) and ($real_enemy['hiddenlog'] =='')) OR ( strpos($real_enemy['login'],"��������� (����" ) !== FALSE ) )
 	               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$real_enemy['maxhp'].']';    }
					$output_attack['text'].="\n!:Y:".time().":".nick_new_in_battle($real_enemy).":".(220+$real_enemy['sex'])."::".nick_new_in_battle($user).":::::".$uron_str.":".$txtdm;

					if ($prhp<=0)
							{
							$input_attack['text'].="\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy);
							$enemy_mag_dead=true; // ������ ������� ��� ����  �����

							// ����
							if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
							elseif ($real_enemy['battle_t']==2)  {unset($boec_t2[$real_enemy['id']]) ;}
							elseif ($real_enemy['battle_t']==3)  {unset($boec_t3[$real_enemy['id']]) ;}

							if (!isset($real_enemy['id_user']) AND ($real_enemy['level'] >= ($user['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
								{

									if (!isset($real_enemy_eff[5577]) || $real_enemy_eff[5577]['add_info'] < 10) {
										if(!isset($real_enemy_eff[5577])) {
											mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$real_enemy['id'].'",1999999999,1) ');
										} else {
											mysql_query('UPDATE `effects` SET add_info = '.($real_enemy_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$real_enemy['id']);
										}

										mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
										VALUES(
											'.$data_battle['id'].',
											'.$user['id'].',
											1,
											'.$user['battle_t'].'
										)
										ON DUPLICATE KEY UPDATE
											`value` = `value` + 1');
									}

							 	}
							 	elseif (!isset($real_enemy['id_user']) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($user);
								}
							}


					$output_attack_magic_dem=$baf_dem;
					set_telo_mana($user,$output_attack_magic_dem);
					}
				}
				}
			}	//$data_battle[nomagic]

if ($user['room']==44)
{
echo "<br>REZ:$STING<br>";
}

			if ( (($user_mag_dead==true) and ($enemy_mag_dead==true) )  OR  (($STING=='REZ1010') and ($user_mag_dead==true)) OR (($STING=='REZ0101') AND  ($enemy_mag_dead==true) )  )
			{
if ($user['room']==44)
{
echo "FIX-user: $user_mag_dead <br>";
echo "FIX-ENEM: $enemy_mag_dead <br>";
}
			//��� �������
			// ��������� ���� �� �����

				$get_test_team=mysql_fetch_array(mysql_query("select count(*) as kol from users where battle='{$data_battle['id']}' and hp>0"));

				if (!($get_test_team['kol']>0))
					{
					//����� ��� �����
					//��������� �����
					$get_test_team_bots=mysql_fetch_array(mysql_query("select count(*) as kol from users_clons where battle='{$data_battle['id']}' and hp>0"));

						if (!($get_test_team_bots['kol']>0))
							{
							//��� �����
							if ($STING=='REZ0101')
								{
								$fin_add_log="!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";
								}
							else
							if ($STING=='REZ1010')
								{
								$fin_add_log="!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";
								}
							//������ ������ �����
							$MAGIC_FATAL_ALL=true;
							$STING='REZ0000';
							}


					}

			}





			////////////////////////////////////////////////////
			switch ($STING)
		     {
				case "REZ11":
				{
				//echo "11";
				// ��� ����� �������� � ���
				//��� ������ ����� ��� �� ��������������
				addlog($data_battle['id'],$input_attack['text']."\n".$output_attack['text']."\n");

				//�������� � ������
				$user['hp']-=$input_attack['dem'];
				// �������� � ������
				if ($user['battle_t']==1)
				{ $boec_t1[$user['id']]['hp']-=$input_attack['dem']; }
				else if ($user['battle_t']==2)
				{ $boec_t2[$user['id']]['hp']-=$input_attack['dem'] ;	}
				else if ($user['battle_t']==3)
				{ $boec_t3[$user['id']]['hp']-=$input_attack['dem'] ;	}

				if ($real_enemy['battle_t']==1)
					{$boec_t1[$real_enemy['id']]['hp']-=$output_attack['dem'];}
				else if ($real_enemy['battle_t']==2)
					{$boec_t2[$real_enemy['id']]['hp']-=$output_attack['dem'] ;}
				else if ($real_enemy['battle_t']==3)
					{$boec_t3[$real_enemy['id']]['hp']-=$output_attack['dem'] ;}

		/////////////// ������������ - ����������� �������� ���� ������ ���������� - � ����� �� ���� ����� ����

			if (mt_rand(1,5)==5) // ������� ������������
					{
					if ($data_battle['type']==20)
								{
								addlog($data_battle['id'],get_comment_fifa()."\n"); // ����������� ��� ����������
								}
								else
								{
								addlog($data_battle['id'],get_comment()."\n"); // ����������� ������
								}
					}
				}
				break;

				case "REZ01":
				{
				  // echo "01";
				  // $user ���� - $real_enmy -���
				  //��� ������ �����, ���� �������� ������ ���� ����� �� ����
					addlog($data_battle['id'],$input_attack['text']."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n");
			 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
		 		    if (($input_attack['type']=='krit') OR ($input_attack['type']=='krita'))
		 		 	{
		 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$user['id']} and  (type=11 OR type=12 OR type=13 OR type=14)   ;"));
		 		 	 if ($eff['id'] > 0 )
		 		 	 {
			 		addlog($data_battle['id'],"!:T:".time().":".nick_new_in_battle($user).":".$user['sex'].":".$eff['name']."\n");
			 		 }
		 		 	}

					//�������� � ������
					$user['hp']=0;
					$STEP = 4;
					// �������� � ������
					if ($user['battle_t']==1)
					{unset($boec_t1[$user['id']]);}
					elseif ($user['battle_t']==2)
					 {unset($boec_t2[$user['id']]);}
					elseif ($user['battle_t']==3)
					 {unset($boec_t3[$user['id']]);}

				}
				break;


				case "REZ10":
				 {
			 		// echo "10";
					 //  ��������
					 //���� ������� ����������, ������ �����.
					addlog($data_battle['id'],$input_attack['text']."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n");
		 			// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
		 		 	if (($output_attack['type']=='krit') OR ($output_attack['type']=='krita'))
		 		 	{
		 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$real_enemy['id']} and (type=11 OR type=12 OR type=13 OR type=14) ;"));
		 		 	 if ($eff['id'] > 0 )
		 		 	 	{
				 		addlog($data_battle['id'],"!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy['sex'].":".$eff['name']."\n");
			 			}
		 		 	}


					//�������� � ������ /
					$user['hp']-=$input_attack['dem'];
					// �������� � ������
					if ($user['battle_t']==1)	 {$boec_t1[$user['id']]['hp']-=$input_attack['dem'];}
					 elseif ($user['battle_t']==2) {$boec_t2[$user['id']]['hp']-=$input_attack['dem'] ;}
					 elseif ($user['battle_t']==3) {$boec_t3[$user['id']]['hp']-=$input_attack['dem'] ;}
					// ������������ �����
					if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
					else if ($real_enemy['battle_t']==2) {unset($boec_t2[$real_enemy['id']]) ;}
					else if ($real_enemy['battle_t']==3) {unset($boec_t3[$real_enemy['id']]) ;}
				 }
				break;


				case "REZ00":
				 {
			 		//��� ������. ������ �����������, + ��������� ���� �� ������� ������ � ����������
			 		// echo "00";
					// �������� - �� ��� ���� ������
					addlog($data_battle['id'],$input_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n");
			 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
			 		 if (($input_attack['type']=='krit') OR ($input_attack['type']=='krita'))
		 		 	{
		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$user['id']} and  (type=11 OR type=12 OR type=13 OR type=14)   ;"));
		 		 	 	if ($eff['id'] > 0 ) {
			 				addlog($data_battle['id'],"!:T:".time().":".nick_new_in_battle($user).":".$user['sex'].":".$eff['name']."\n");
			 			}
		 		 	}
			 		//addlog($data_battle['id'],"!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n");
			 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
			 		 if (($output_attack['type']=='krit') OR ($output_attack['type']=='krita'))
		 		 	{
		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$real_enemy['id']} and (type=11 OR type=12 OR type=13 OR type=14)   ;"));
		 		 	 	if ($eff['id'] > 0 ) {
					 		addlog($data_battle['id'],"!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy['sex'].":".$eff['name']."\n");
			 			}
		 		 	}

					//�������� � ������
					$user['hp']=0;
				 	$STEP = 4;
					// �������� � ������

					if ($user['battle_t']==1) {unset($boec_t1[$user['id']]);}
					elseif ($user['battle_t']==2) {unset($boec_t2[$user['id']]);}
					elseif ($user['battle_t']==3) {unset($boec_t3[$user['id']]);}
					// ����
					if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
					elseif ($real_enemy['battle_t']==2)  {unset($boec_t2[$real_enemy['id']]) ;}
					elseif ($real_enemy['battle_t']==3)  {unset($boec_t3[$real_enemy['id']]) ;}
				 }
				break;


				case "REZ1010":
				{

					//	 echo "1010";
					// ��������� ������ ���� ���������� ����� ������ ������� �����
					//���� ���� � �������. ������� ������.
					$fin_add_log=$input_attack['text']."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";
			 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
		 		 	if (($output_attack['type']=='krit') OR ($output_attack['type']=='krita'))
		 		 	{
		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$real_enemy['id']} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
		 		 	 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy['sex'].":".$eff['name']."\n";
			 			}
		 		 	}


			 		############################################
			 		$win_team_hist='t'.$user['battle_t'].'hist';
			 		//Fix - 29/07/2011
			 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";


			 		//fix 29/07/2011
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle['id']} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle['id'],$fin_add_log);
				 		}
				 	////////////////////////

					//��� ������ ���� ����� ��� = ������ ������� $user['battle_t'];
					$BSTAT['win']=($user['battle_t']==3?4:$user['battle_t']);
			 		############################################
					//�������� � ������ / ������ ����� �� ������� �.�. ��� �� ���� :)
					$user['hp']-=$input_attack['dem'];
					// �������� � ������
					if ($user['battle_t']==1) {$boec_t1[$user['id']]['hp']-=$input_attack['dem'];}
					elseif ($user['battle_t']==2) {$boec_t2[$user['id']]['hp']-=$input_attack['dem'] ;}
					elseif ($user['battle_t']==3) {$boec_t3[$user['id']]['hp']-=$input_attack['dem'] ;}

					if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
						elseif ($real_enemy['battle_t']==2) {unset($boec_t2[$real_enemy['id']]) ;}
						elseif ($real_enemy['battle_t']==3) {unset($boec_t3[$real_enemy['id']]) ;}

					$STEP = 5;
				}
				break;



				case "REZ0101":
				{
					// echo "0101";
					// ��������� ������ ���� ����� �� �� ����� ������ ���� �����
					//����� �����, � ������ �����, ������� ���� ����� - ���� �������.
					$fin_add_log=$input_attack['text']."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";
		 			// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
		 			 if (($input_attack['type']=='krit') OR ($input_attack['type']=='krita'))
		 		 	{
		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$user['id']} and  (type=11 OR type=12 OR type=13 OR type=14)   ;"));
		 		 	 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user['sex'].":".$eff['name']."\n";
			 			}
		 		 	}

			 		############################################
			 		$win_team_hist='t'.$real_enemy['battle_t'].'hist';
			 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle['id']} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle['id'],$fin_add_log);
				 		}
				 	////////////////////////

					//��� ������ ���� ����� ��� = ������ ������� $real_enemy;
					$BSTAT['win']=($real_enemy['battle_t']==3?4:$real_enemy['battle_t']);
			 		############################################
					//�������� � ������
					$user['hp']=0;
					// �������� � ������
					if ($user['battle_t']==1) {unset($boec_t1[$user['id']]);}
					elseif ($user['battle_t']==2) {unset($boec_t2[$user['id']]);}
					elseif ($user['battle_t']==3) {unset($boec_t3[$user['id']]);}

					 $STEP = 5;
				}
				break;



				case "REZ0001":
				{
					// echo "0001";
					// ���� ����� ���������  � ���� ����� ������� ����� �������� �.�. �������� �����
					//��� ������, ��� ��������, ������ �� ���� �����.
					//������ ���������, ���� ����� ���������.
					$fin_add_log=$input_attack['text']."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";
					// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
		 			 if (($input_attack['type']=='krit') OR ($input_attack['type']=='krita'))
		 		 	{
		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$user['id']} and  (type=11 OR type=12 OR type=13 OR type=14)   ;"));
		 		 	 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user['sex'].":".$eff['name']."\n";
			 			}
		 		 	}

		 			$fin_add_log.="!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";

					// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
		 		 	if (($output_attack['type']=='krit') OR ($output_attack['type']=='krita'))
		 		 	{

		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$real_enemy['id']} and  (type=11 OR type=12 OR type=13 OR type=14)   ;"));
			 		 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy['sex'].":".$eff['name']."\n";
			 			}
		 		 	}

			 		############################################
			 		$win_team_hist='t'.$real_enemy['battle_t'].'hist';
			 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle['id']} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle['id'],$fin_add_log);
				 		}
				 	////////////////////////

					//��� ������ ���� ����� ��� = ������ ������� $real_enemy;
					$BSTAT['win']=($real_enemy['battle_t']==3?4:$real_enemy['battle_t']);
			 		############################################
					//�������� � ������
					$user['hp']=0;
					// �������� � ������
					if ($user['battle_t']==1) {unset($boec_t1[$user['id']]);}
					elseif ($user['battle_t']==2) {unset($boec_t2[$user['id']]);}
					elseif ($user['battle_t']==3) {unset($boec_t3[$user['id']]);}
					// ����� �� ������� �.�. ������
					 $STEP = 5;
				}
				break;



				case "REZ0010":
				{
					// echo "0010";
					// ���� ����� � ���� ����� ���������  ������� ����� �������� �.�. �������� �����
                    			//��� ������, ��� ��������, ������ �����.
					//������ ���������, ���� ����� ���������.
					$fin_add_log=$input_attack['text']."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";
			 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
			 		 if (($input_attack['type']=='krit') OR ($input_attack['type']=='krita'))
		 		 	{

		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$user['id']} and  (type=11 OR type=12 OR type=13 OR type=14)   ;"));
		 		 	 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user['sex'].":".$eff['name']."\n";
			 			}
		 		 	}

			 		$fin_add_log.="!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";
			 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
		 		 	if (($output_attack['type']=='krit') OR ($output_attack['type']=='krita'))
		 		 	{
		 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$real_enemy['id']} and  (type=11 OR type=12 OR type=13 OR type=14)  ;"));
		 		 	 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy['sex'].":".$eff['name']."\n";
					 	}
		 		 	}
			 		############################################
			 		$win_team_hist='t'.$user['battle_t'].'hist';
			 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";

			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle['id']} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle['id'],$fin_add_log);
				 		}
				 	////////////////////////

					//��� ������ ���� ����� ��� = ������ ������� $user;
					$BSTAT['win']=($user['battle_t']==3?4:$user['battle_t']);
			 		############################################
					//�������� � ������
					$user['hp']=0;
					// �������� � ������
					if ($user['battle_t']==1) {unset($boec_t1[$user['id']]);}
					elseif ($user['battle_t']==2) {unset($boec_t2[$user['id']]);}
					elseif ($user['battle_t']==3) {unset($boec_t3[$user['id']]);}
					// ����� �� ������� �.�. ������
					 $STEP = 5;
				}
				break;

				case "REZ0000":
				{
					// echo "0000";
					// ����� ����� � ��������� ��������
					//��� ������, ��� ��������, �����
					//������ ���������, ���� ����� ���������.

				if ($MAGIC_FATAL_ALL!=true) //���� �� ������� ��� ������� ���� ����� ������
				{
				    $fin_add_log=$input_attack['text']."\n".$output_attack['text']."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";

				    if (($input_attack['type']=='krit') OR ($input_attack['type']=='krita'))
		 		 	{
		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$user['id']} and  (type=11 OR type=12 OR type=13 OR type=14)  ;"));
		 		 	 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user['sex'].":".$eff['name']."\n";
			 			}
		 		 	}

					$fin_add_log.="!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";

				    if (($output_attack['type']=='krit') OR ($output_attack['type']=='krita'))
		 		 	{
		 		 		$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle['id']} and owner={$real_enemy['id']} and  (type=11 OR type=12 OR type=13 OR type=14)  ;"));
			 		 	if ($eff['id'] > 0 ) {
			 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy['sex'].":".$eff['name']."\n";
				 		}
		 		 	}
				  }
				  else
				  {
				   $fin_add_log.=$input_attack['text']."\n".$output_attack['text']."\n";
				  }
			 		############################################
			 		$fin_add_log.="!:F:".time().":0\n";

			 		//fix 29/07/2011
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle['id']} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle['id'],$fin_add_log);
				 		}
				 	////////////////////////

					//��� ������ ���� ����� ��� = �����
					$BSTAT['win']=0;
			 		############################################
					//�������� � ������
					$user['hp']=0;

					// �������� � ������
					if ($user['battle_t']==1) {unset($boec_t1[$user['id']]);}
					elseif ($user['battle_t']==2) {unset($boec_t2[$user['id']]);}
					elseif ($user['battle_t']==3) {unset($boec_t3[$user['id']]);}
					// ����
					if ($real_enemy['battle_t']==1) {unset($boec_t1[$real_enemy['id']]);}
					elseif ($real_enemy['battle_t']==2)  {unset($boec_t2[$real_enemy['id']]) ;}
					elseif ($real_enemy['battle_t']==3)  {unset($boec_t3[$real_enemy['id']]) ;}
					 $STEP = 5;
				}
				break;

		     } // fin switch

		if  ($STING!="REZ_ERR") //���� �� ������ -
		{
			////795-��� - ����� ����
			if ( ((is_array($user_eff[795])) and ($user['hp']>0)) AND ($data_battle['nomagic']==0)  )
				{
				$hil_p=0.5; //50% � ������
				$dlev=($user['level']-$real_enemy['level'])*0.1;
				$hil_p-=$dlev;
				$cure_value = round($output_attack['dem']*$hil_p);
				if ($cure_value > 0 )
					{
					//�������
					$fadd=make_hil_battle($user,$cure_value);
					 if ($fadd)
					 {
					 $user['hp']+=$fadd;
					 //������ ������ 1 ��� �� ���
			 		mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_795_use`) values('".$user['battle']."', '".$user['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_795_use` =`baf_795_use`+1;");
					 }
					}
				}

			////795-��� - ����� ����
			if ( ((is_array($real_enemy_eff[795])) and ($real_enemy['hp']>0)) AND ($data_battle['nomagic']==0)  )
				{
				$hil_p=0.5; //50% � ������
				$dlev=($real_enemy['level']-$user['level'])*0.1;
				$hil_p-=$dlev;
				$cure_value = round($input_attack['dem']*$hil_p);
				if ($cure_value > 0 )
					{
					//�������
					 $fadd=make_hil_battle($real_enemy,$cure_value);
					 if ($fadd)
					 {
					 $real_enemy['hp']+=$fadd;
 					 //������ ������ 1 ��� �� ���
			 		mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_795_use`) values('".$real_enemy['battle']."', '".$real_enemy['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_795_use` =`baf_795_use`+1;");
					 }
					}
				}


			//////////////////////////////
			//// quest event-���� ���� � ���� ����� � ������� ���� �������
			if (
				 ($_SESSION['quest']=='ihave') AND // � ���� �����
				 ($_SESSION['questdata']['id'] > 0) AND // ����� ����� ��
		 		 ( ($_SESSION['questdata']['q_bot'] ==$real_enemy[id_user]) AND ($_SESSION['questdata']['q_bot'] > 0) )  AND // ���� ������� ��� � ������� ��� ��������� ���
		 		 (  ( $STING=='REZ10') OR ( $STING=='REZ00') OR ( $STING=='REZ1010') OR ( $STING=='REZ0010') ) // ����� ������� ��� ���� ����
			   )
			{
		   	       // ����� �������� - ��������� ����
			       if ($user['lab'] > 0)
			  		{
			  		// � � ���� - ������� � ���� ��������� ���� -�� � ���������� ����������-������������ ���� ��� ����� �������-��� ������ - ���� ��� ����� ����
			  		//��������� ���������� ���� �� ����
			  		$labpoz=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_users` WHERE `owner` = '{$user['id']}' LIMIT 1;"));
			  		 if (($labpoz['map']>0) AND ($labpoz['x']>0) AND ($labpoz['y']>0) )
			  		  {
			  		  get_kill_bot($_SESSION['questdata'],$user,$labpoz['map']) ;
			  		  }
			  		}
			}
			/////////////////
			//// �������� ���� � ���� ������ � ���
				if (($user['lab']>0) AND ($real_enemy['id_user'] > 0)  AND //$real_enemy[id_user] - � ������ ����� ����� ��������� ����!!!!
				 (  ( $STING=='REZ10') OR ( $STING=='REZ00') OR ( $STING=='REZ1010') OR ( $STING=='REZ0010') ) // ����� ������� ��� ���� ����
				 )
				 {
				 count_rep_lab($user,$real_enemy);
				 }

			if (!isset($real_enemy['id_user']) && ($STING=='REZ10' || $STING=='REZ00' || $STING=='REZ1010' || $STING=='REZ0010' || $STING=='REZ0001') && ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ))
			{
				if ($real_enemy['level'] >= ($user['level']-1)) {
					if (!isset($real_enemy_eff[5577]) || $real_enemy_eff[5577]['add_info'] < 10) {
						if(!isset($real_enemy_eff[5577])) {
							mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$real_enemy['id'].'",1999999999,1) ');
						} else {
							mysql_query('UPDATE `effects` SET add_info = '.($real_enemy_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$real_enemy['id']);
						}

						mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
									VALUES(
										'.$data_battle['id'].',
										'.$user['id'].',
										1,
										'.$user['battle_t'].'
									)
									ON DUPLICATE KEY UPDATE
										`value` = `value` + 1
						');
					}
				}
			}
			elseif (!isset($real_enemy['id_user']) and ($STING=='REZ10' || $STING=='REZ00' || $STING=='REZ1010' || $STING=='REZ0010' || $STING=='REZ0001')  and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($user);
								}


			if (!isset($real_enemy['id_user']) && ($STING=='REZ01' || $STING=='REZ00' || $STING=='REZ0101' || $STING=='REZ0010' || $STING == 'REZ0001') && ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ))
			{
				if ($user['level'] >= ($real_enemy['level']-1)) {
					if (!isset($user_eff[5577]) || $user_eff[5577]['add_info'] < 10) {
						if(!isset($user_eff[5577])) {
							mysql_query('INSERT INTO `effects` (`type`,`name`,`owner`,`time`,`add_info`) VALUES(5577,"�������������� - ������","'.$user['id'].'",1999999999,1) ');
						} else {
							mysql_query('UPDATE `effects` SET add_info = '.($user_eff[5577]['add_info']+1).' WHERE type = 5577 AND owner = '.$user['id']);
						}

						mysql_query('INSERT INTO `op_battle_index` (`battle`,`owner`,`value`,`team`)
									VALUES(
										'.$data_battle['id'].',
										'.$real_enemy['id'].',
										1,
										'.$real_enemy['battle_t'].'
									)
									ON DUPLICATE KEY UPDATE
										`value` = `value` + 1
						');
					}
				}
			}
			elseif (!isset($real_enemy['id_user']) and ($STING=='REZ01' || $STING=='REZ00' || $STING=='REZ0101' || $STING=='REZ0010' || $STING == 'REZ0001')  and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($real_enemy);
								}


	     // ���� � ���� ����������� ������ ��� ������ ���� ����������
    		//������� ���� ��� ��� ���� ����� � ����� � ����
			if ($output_attack['dem'] > 0 )
				{
					if ($output_fix_cost_level==1)
					{
						if ($output_attack_magic_dem>0)
						{
						 solve_exp($data_battle,$user,$user,$my_wearItems['allsumm'],$my_wearItems['allsumm'],$output_attack_magic_dem,$my_wearItems['elka_aura_ids'],$BSTAT['win'],$output_attack_magic_dem);
						}
					 solve_exp($data_battle,$user,$real_enemy,$my_wearItems['allsumm'],$en_wearItems['allsumm'],($output_attack['dem']+$output_attack['stone']),$my_wearItems['elka_aura_ids'],$BSTAT['win'],0);
					}
					else
					{
					 solve_exp($data_battle,$user,$real_enemy,$my_wearItems['allsumm'],$en_wearItems['allsumm'],$output_attack['dem']+$output_attack['stone']+$output_attack_magic_dem,$my_wearItems['elka_aura_ids'],$BSTAT['win'],$output_attack_magic_dem);
					 }
				}
			// ������� ��� � ��������� ���� � ���� ���� ���
			if ($input_attack['dem'] > 0 )
				{
					if ($input_fix_cost_level==1)
					{
					//����������� � ��������� ����� ��������
					if ($input_attack_magic_dem>0)
						{
						//���� ���� ��� ���� � ������ �� ����� ����� � ������� ����� ��� � �����
						 solve_exp($data_battle,$real_enemy,$real_enemy,$en_wearItems['allsumm'],$en_wearItems['allsumm'],$input_attack_magic_dem,$en_wearItems['elka_aura_ids'],$BSTAT['win'],$input_attack_magic_dem);
						 }

					 solve_exp($data_battle,$real_enemy,$user,$en_wearItems['allsumm'],$my_wearItems['allsumm'],($input_attack['dem']+$input_attack['stone']),$en_wearItems['elka_aura_ids'],$BSTAT['win'],0);
					}
					else
					{
					//���� ���� ����� �� 1 �� ��� ��� ������ ������
					 solve_exp($data_battle,$real_enemy,$user,$en_wearItems['allsumm'],$my_wearItems['allsumm'],$input_attack['dem']+$input_attack['stone']+$input_attack_magic_dem,$en_wearItems['elka_aura_ids'],$BSTAT['win'],$input_attack_magic_dem);
					 }
				}

		 //2.2 �������� �� ��������� ���

			if ($BSTAT['win']==1)
			 {
			 // ������ ������� 1
			 // �������� ������
			 $data_battle['win']=1;
	 		 if ($data_battle['fond'] > 0) {   get_win_money_logs($data_battle);  }
			$winrez[0]=finish_battle(1,$data_battle,$data_battle['blood'],$data_battle['type'],$data_battle['fond']);
			 if ($data_battle['blood']>0) { 	 addlog($data_battle['id'],get_text_travm($data_battle)); }
			 addlog($data_battle['id'],get_text_broken($data_battle));
		 	}
			else if ($BSTAT['win']==2)
			 {
			 //������ ������� 2
	 		 // �������� ������
			 $data_battle['win']=2;
	 		 $winrez[0]=finish_battle(2,$data_battle,$data_battle['blood'],$data_battle['type'],$data_battle['fond']);
	 		 if ($data_battle['blood']>0) { 	 addlog($data_battle['id'],get_text_travm($data_battle)); }
			 addlog($data_battle['id'],get_text_broken($data_battle));
			 }
			else if ($BSTAT['win']==4) //������ ������� 3!!
			 {
			 //������ ������� 3
	 		 // �������� ������
			 $data_battle['win']=4;
	 		 $winrez[0]=finish_battle(4,$data_battle,$data_battle['blood'],$data_battle['type'],$data_battle['fond']);
	 		 if ($data_battle['blood']>0) { 	 addlog($data_battle['id'],get_text_travm($data_battle)); }
			 addlog($data_battle['id'],get_text_broken($data_battle));
			 }
			 else if ($BSTAT['win']==0)
			 {
			 // �����
	 		 // �������� ������
			 $data_battle['win']=0;
	 		 $winrez[0]=finish_battle(0,$data_battle,$data_battle['blood'],$data_battle['type'],$data_battle['fond']);
			 addlog($data_battle['id'],get_text_broken($data_battle));
			 }
			 else
			 {
			// �� ��������� ���� ������� ������ �� ������� ��������
			 mysql_query("delete from `battle_fd` where `battle`={$data_battle['id']} and `razmen_from`={$real_enemy['id']} and `razmen_to`={$user['id']} ; ");
			 }
		   }	 //"REZ_ERR" //���� �� ������
		 }//������ ���-������

		 if (($user_eff['STOP']) OR ($real_enemy_eff['STOP']))
			{

				if ($user_eff['STOP'])
				{
					echo_bat_exit($user);
					$user['hp']=0;
					$user['battle']=0;
				}
				else if ($real_enemy_eff['STOP'])
				{
				echo_bat_exit($real_enemy);
				}
			}



	      }
	      else
	      {
	     // echo "4 <br>";
	      // ��� - ����� ������ ������ � ����
	      // ���� ��� � ���� �� ������� �� ������ �.�. �������� 2 ������ ����
	   if ($user['lab']==0)
		 {
	      mysql_query("INSERT `battle_fd`
	      (`battle`,`razmen_from`,`from_t`,`razmen_to`,`to_t`,`attack`,`attack2`,`block`, `time_blow`, `lab`)
	      values
	      ('{$data_battle['id']}','{$user['id']}','{$user['battle_t']}','{$real_enemy['id']}','{$real_enemy['battle_t']}','{$_POST['attack']}','{$_POST['attack2']}','{$_POST['defend']}', '".time()."' , '{$user['lab']}' )
	      ON DUPLICATE KEY UPDATE  `lab`={$user['lab']} ;"); // ��� ���� �������� ���� ���� ���������� ������ ����� �� ����� ��������� ���� ��� ��� - ���� �������� ��� - ����� ���� ������ ���
	         }

	      }


    }
  }
 } //�� ���� �������
  else if ($user_eff_711['id']>0)
 {

  $targ_test=mysql_fetch_array(mysql_query("select * from users where battle={$data_battle['id']} and battle_t!={$my_team_n} and hp>0  and id='{$user_eff_711['add_info']}' LIMIT 1;"));
     if (!($targ_test['id']>0))
   		{
   		//��� ��� �������� ��� ����� ������� ���
     	 	bet_battle_eff($user_eff_711);
     	 	$STEP=1;
   		}
   		else
   		{
		  $nexten=$targ_test;
		  $enemy=$nexten['id'];
		  $targ_razmen_test=mysql_fetch_array(mysql_query("select * from battle_fd where battle={$data_battle['id']} and razmen_to={$targ_test['id']} and razmen_from={$user['id']}   LIMIT 1;"));
			if ($targ_razmen_test)
			{
			$STEP=2;
			}
			else
			{
			$STEP=1;
			}
		}

 }
 else if (($_POST['login_target']) and ($ak >0))
 {

 $_POST['login_target']=htmlspecialchars(mysql_real_escape_string($_POST['login_target']));
   $_POST['login_target']=str_replace('&amp;lt;u&amp;gt;','',$_POST['login_target']);
     $_POST['login_target']=str_replace('&amp;lt;/u&amp;gt;','',$_POST['login_target']);
     $_POST['login_target']=trim($_POST['login_target']);

 // ������ �� ����� ����
 // 1. ���� �������� ����� ������ + � ������ ��� + � ������� �����

 //�������� ����� ����� �� �����?
   $GTB = "";
   $targ_test = false;

   if ( (strpos($_POST['login_target'],"(����" ) !== FALSE) OR  (strpos($_POST['login_target'],"(k�o�" ) !== FALSE) ) {
	$GTB='users_clons';
	$hidu='';
   } elseif((strpos($_POST['login_target'],"(" ) !== FALSE ) AND (strpos($_POST['login_target'],")" ) !== FALSE )) {
   } else {
	$GTB='users';
	$hidu="and hidden=0";
   }

   if(strlen($GTB) > 0) $targ_test=mysql_fetch_array(mysql_query("select * from ".$GTB." where battle={$data_battle['id']} and battle_t!={$my_team_n} and hp>0  ".$hidu."  and login='{$_POST['login_target']}' LIMIT 1;"));

  if ($targ_test['id']>0)
  {
   //2+ ������� �� ��� ��� �� �����

   $targ_razmen_test=mysql_fetch_array(mysql_query("select * from battle_fd where battle={$data_battle['id']} and razmen_to={$targ_test['id']} and razmen_from={$user['id']}   LIMIT 1;"));

   if ($targ_razmen_test)
	{
	echo "<font color=red><b>��������� ��� �� ������� ���!</b></font>";
	}
	else
	{
	$nexten=$targ_test;
	$enemy=$nexten['id'];
	$STEP=1;
	}
  }
  else
  {

	echo "<font color=red><b>�������� �� ������!</b></font>";
  }
 } // ������ ������� ��� ����� ����
  	else if (($_GET['use']) and ($ak > 0))
	{
		$get_vars=mysql_fetch_array(mysql_query("select * from battle_vars where battle='{$data_battle['id']}' and owner='{$user['id']}' ;"));
		$_GET['use']=(int)($_GET['use']);
		// ��� ���� ������ ������ �� �������
		// � �������� ������ ���������� - ���� �������� ���� ������ ����� ������ �����

		$all_help_ok=false;
	         if ($get_vars['help_use']==0)
		         	{
			         $all_help_ok=true;
		         	}
				elseif ( ($get_vars['help_proto']>0) and ($get_vars['help_use'] < $maxdur[$get_vars['help_proto']]) )
				{
					$get_item_help=mysql_fetch_array(mysql_query("select id from oldbk.inventory where id='{$_GET['use']}' and owner='{$user['id']}'  and nlevel<='{$user['level']}' and ngray<='{$user['mgray']}' and nintel<='{$user['intel']}'  and prototype='{$get_vars['help_proto']}'  and setsale=0 and bs_owner='{$user['in_tower']}' ;"));
					if ($get_item_help['id']>0)
					{
					$all_help_ok=true;
					}
				}

		if ($_GET['h']==1 && $all_help_ok==true)
		{
			$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=207"));
		}
		elseif ($_GET['h']==2 && $all_help_ok==true)
		{
			$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=1616"));
		}
		elseif ($_GET['h']==3 && $all_help_ok==true)
		{
			$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=1717"));
		}
		elseif ($_GET['h']==4 && $all_help_ok==true)
		{
		//���� ������ �������� - ��� ������������� �������������!! 310311  310312
			$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=310310"));
		}
		else
		{
			$test_magic=mysql_fetch_array(mysql_query("select * from oldbk.magic where id=(select magic from oldbk.inventory where owner=".$user['id']." and id='".$_GET['use']."' and dressed=1) or id=(select includemagic from oldbk.inventory where owner=".$user['id']." and id='".$_GET['use']."' and dressed=1)"));
		}

		if (($data_battle['nomagic']==0) OR ($test_magic['id']==51)) //51 ������� ������������
	      	{

			if ( ($test_magic['id']>0) and ($test_magic['battle_use']==1))
			 {
			 // ����� ���� ��������� ���������� - ��������� ������
			  if ($test_magic['need_block']==1)
			     {
			     // ����� ������� ���� ��� ����
			     // ��������� ����
			     echo "<font color=red><b>�� �� ��������� ����. </b></font>";
			     }
			     else
				if ($test_magic['need_block']==2)
			     {
			     // ����� ���� ��� ��� ���� ���� �� �
			      if ($_POST['target']==$user['login'])
			        {
				        usemagic($_GET['use'],"".$_POST['target']);
			        }
			        else
			        {
				        echo "<font color=red><b>�� �� ��������� ����..</b></font>";
			        }
			     }
				else
				{

				 $uzmag= usemagic($_GET['use'],"".$_POST['target']);


				}

			 }
	        } // nomagic

 	} // ����� �� ����������� �����

 ////////////////����� ��������� ���� ���� �������� ������

 ///
  if ($STEP!=5)
  {
 	// ��������� ������ ����� ��������
	// ������ ����� ������ � ������� �������� ����� ��� ��� ���� ��� ������� �� ���� - �������� �� �������
	// �� � ����������� �������� � ������ �������� �� hp > 0+
	//if (!$enemy >0) // ���� ���� �� ������
	{
	$nexten_test_all=mysql_query("select * from battle_fd as fd where battle={$data_battle['id']} and razmen_to={$user['id']} and razmen_from in (select id from users where battle=fd.battle and battle_t!={$my_team_n} and hp>0 ) ORDER by time_blow ;");
	// ��� ������� ��������� ��� ��� ����� ������� ��� ������� ������ ������
	$ko=0; $remem=0;
	$all_fd=mysql_num_rows($nexten_test_all);
	while($trow = mysql_fetch_array($nexten_test_all))
	{
	$ko++;

	if (!$enemy >0) // ���� ����� ������ ���������
	{
	//������� ���������� ���� ��� �� ��� ��� ������ ��� ��� � � ������� �� ������ 1


	 if ($remem==0)
	 //������ ���������� ��� ���
	 {

	 if ($all_fd>1)
	 	{
	 	//���� � ������� ������ ������ ���������� �� ��� ������ ��������� ����� ����� ������� ����������������
	 	if ($trow['razmen_from']!=$_SESSION['was_target'])
	 		{
	 		//���� ������ ������ �� ����� ���� ��� ��� �� ������ �� ����������
	 		$nexten_test=$trow; //���������� ������� ����
	 		$remem=1; // �������� ��� ���������
	 		}
	 	}
	 	else
	 	{
	 	$nexten_test=$trow; //���������� ������� ����
 		$remem=1; // �������� ��� ���������
	 	}

	 }


 	 }



	if ($my_team_n==1)
	{
	   $boec_t2[$trow['razmen_from']]['razm']=1;
	   $boec_t3[$trow['razmen_from']]['razm']=1;
	  ///��������� � ��� 60 61 ��� ���� ���� =2
	   if (( ($data_battle['status_flag'] >0) OR ($data_battle['CHAOS']==2) OR ($data_battle['CHAOS']==-1) )  AND  ( ($trow['time_blow']+(($data_battle['timeout']*60)-120)) <= time() ) )
	   {
		$boec_t2[$trow['razmen_from']]['blow']=1;
		$boec_t3[$trow['razmen_from']]['blow']=1;
	   }
	}
	elseif ($my_team_n==2)
	{
	   $boec_t1[$trow['razmen_from']]['razm']=1;
	   $boec_t3[$trow['razmen_from']]['razm']=1;
	  ///��������� � ��� 60 61 ��� ���� ���� =2
	   if (( ($data_battle['status_flag'] >0) OR ($data_battle['CHAOS']==2) OR ($data_battle['CHAOS']==-1) )  AND  ( ($trow['time_blow']+(($data_battle['timeout']*60)-120)) <= time() ) )
	   {
		$boec_t1[$trow['razmen_from']]['blow']=1;
		$boec_t3[$trow['razmen_from']]['blow']=1;
	   }
	}
	elseif ($my_team_n==3)
	{
	   $boec_t1[$trow['razmen_from']]['razm']=1;
	   $boec_t2[$trow['razmen_from']]['razm']=1;
	  ///��������� � ��� 60 61 ��� ���� ���� =2
	   if (( ($data_battle['status_flag'] >0) OR ($data_battle['CHAOS']==2) OR ($data_battle['CHAOS']==-1) )  AND  ( ($trow['time_blow']+(($data_battle['timeout']*60)-120)) <= time() ) )
	   {
		$boec_t1[$trow['razmen_from']]['blow']=1;
		$boec_t2[$trow['razmen_from']]['blow']=1;
	   }
	}

	}
/////////////////////////////////////////////////////////////
	if (!$enemy >0) // ���� ����� ������ ���������
	{
	if ( $nexten_test['id'] > 0 )
	 {
	$nexten=mysql_fetch_array(mysql_query("SELECT * FROM users as u WHERE battle ={$data_battle['id']} AND battle_t !={$my_team_n} AND hp >0 AND id={$nexten_test['razmen_from']} LIMIT 1;"));

		if ($nexten['id'] > 0)
		    {
		     $enemy=$nexten['id'];
		     $STEP=1;
		     }
		     else
		     {
		     $enemy=0;
		     }

	 }
	 else
	 {
	 // ���� ��� �������� ���� ����������� ����� � ���� ������ ����� � ����� � �������� hp
	 // �� ���� ����� �� �������� ��� ������ �������!!!
	$nexten=mysql_fetch_array(mysql_query("SELECT * FROM users as u WHERE battle ={$data_battle['id']} AND battle_t !={$my_team_n} AND hp >0 AND u.id not in (select razmen_to from battle_fd as fd where  u.battle=fd.battle and razmen_from = {$user['id']}) LIMIT 1;"));

	  if ($nexten['id'] > 0)
	    {
	     $enemy=$nexten['id'];
	     $STEP=1;
	     }
	     else
	     {
	          //��� ���� ��������� ���� �� ���� + fix 1/07/2011 ����� ������� �� �������� - � ������-����� ��� �� !
		  $nexten=mysql_fetch_array(mysql_query("SELECT * FROM users_clons as u WHERE battle ={$data_battle['id']} AND battle_t !={$my_team_n} AND hp >0 ORDER BY hp DESC LIMIT 1;"));
	              if ($nexten['id'] > 0)
		      {
			$enemy=$nexten['id'];
		        $STEP=1;
		      }
		      else
		      {
	     	     $enemy=0;
	     	     // �������� ��� �������� � ����
			if  ((($data_battle['type'] >240 )and ( $data_battle['type'] <269 )) OR ($data_battle['type']==172))
	  		{
		  	 $STEP=2;

	 		}
	 		else
	 		{
	     	        //echo "B";
	     	        // �������� ������ ���������� ����� � ������� �����
	     	        if ($user['battle_t']==1)    { $ak=count($boec_t2)+count($boec_t3) ; }
	     	        elseif ($user['battle_t']==2) {$ak=count($boec_t1)+count($boec_t3);}
	     	        elseif ($user['battle_t']==3) {$ak=count($boec_t2)+count($boec_t1);}

	     	       // ��� ���� ������ ���  ��� ����� ��� ��� ���� ��� �������� ����
     			if ( $ak > 0) {$STEP=2; } else
     					{
	     				$STEP=5;
	     				 if (($data_battle['win']==3) and ($data_battle['status']==0))
	     				      {
		    				$vrag_exit=1;
	     				      }

	     				}
	     		 }
		     }
	     }
	  }
  }
}

	// �������� �����


	if ($enemy > 0)
	{
	////////////////////////////////////////////////////
	//��������� ��� ������ ��� ����� ����� � �������� � ������ ����� ���� ��������
	// ����������� ����� ���� ����� ��� �����������
    	$en_wearItems=load_mass_items_by_id($nexten); // ��������
    	$en_magicItems=$en_wearItems['incmagic'];
    	// ����� ��� �� ���� ���
	///////////////////////////////////////////////////
	}

    } // ���� $STEP!=5
  } //�������� �� ��
   else
   {
   // ���� ����
  	 $STEP=4;

   }

 } /////// �������� �� ��� ��� �����
	 else
	 {
	 	$STEP = 5;
	 }




 // �������� �� ����� �����

  if (($STEP==2)OR($vrag_exit==1))
   {

   //�������� �����
   //print_r($data_battle);
       if ((get_timeout($data_battle,$user) ) OR ($vrag_exit==1))
	       {

	       	$STEP=3;

	       	//��� �������� �� ���������� �����
	       	if ((isset($_POST['victory_time_out'])) OR ($vrag_exit==1)) {
		// ������� �������� ����� ������ ���
		mysql_query("UPDATE battle set status=1 where id={$data_battle['id']}");
	//fix 1/07/2011 - ������ ���� ��� � ����
	if (mysql_affected_rows() > 0)
	    { // fix
		if ($vrag_exit==1)
			{
				$t1_count=count($boec_t1);
				$t2_count=count($boec_t2);
				$t3_count=count($boec_t3);

			 	if (($t1_count > $t2_count) and ($t1_count > $t3_count) ) { $data_battle['win']=1; }
			 	else if (($t2_count > $t1_count) and ($t2_count > $t3_count) ) { $data_battle['win']=2; }
			 	 else if (($t3_count > $t1_count) and ($t3_count > $t1_count) ) { $data_battle['win']=4; }
			 }
			 else
			 {
			 $data_battle['win']=($user['battle_t']==3?4:$user['battle_t']);

			if ($data_battle['type']!=10 && $data_battle['type']!=1010)	//���� ��� �� � ��
	 		   {
	 		    // ��� ���� ��������� ������ ���� ��� �������
	 		    $my_team_n=$user['battle_t'];
	 		     if ($data_battle['type']!=1) //�� ���
	 		       {
				if ($data_battle['blood']==2)
				{
				     	 		         mysql_query("UPDATE users SET hp=0 ,
     	 		         					sila = IF((@RR:=100*RAND())<30, settravmatv2_new(id,'sila',sila,level,{$data_battle['id']},{$data_battle['type']},align,trv,pasbaf), sila),
     	 		         					lovk = IF(@RR>=30 AND @RR<60, settravmatv2_new(id,'lovk',lovk,level,{$data_battle['id']},{$data_battle['type']},align,trv,pasbaf), lovk),
     	 		         					inta = IF(@RR>=60, settravmatv2_new(id,'inta',inta,level,{$data_battle['id']},{$data_battle['type']},align,trv,pasbaf), inta)
     	 		         					where battle={$data_battle['id']} and battle_t!={$my_team_n} and hp > 0 and `level` > 3 and align!=5;");

			 		$err_text=mysql_error();
			 		 if ($err_text!='') {	addchp ('<font color=red>fbattle.php</font> travm-error  '.$err_text,'{[]}Bred{[]}'); }

				}
				else
				{
     	 		         mysql_query("UPDATE users SET hp=0 ,
     	 		         					sila = IF((@RR:=100*RAND())<30, settravmat2(id,'sila',sila,level,{$data_battle['id']},{$data_battle['type']},trv), sila),
     	 		         					lovk = IF(@RR>=30 AND @RR<60, settravmat2(id,'lovk',lovk,level,{$data_battle['id']},{$data_battle['type']},trv), lovk),
     	 		         					inta = IF(@RR>=60, settravmat2(id,'inta',inta,level,{$data_battle['id']},{$data_battle['type']},trv), inta)
     	 		         					where battle={$data_battle['id']} and battle_t!={$my_team_n} and hp > 0 and `level` > 3 and align!=5;");

		 		$err_text=mysql_error();
 				 if ($err_text!='') {	addchp ('<font color=red>fbattle.php</font> travm-error  '.$err_text,'{[]}Bred{[]}'); }
	 		        }
	 		       }
	 		       else
	 		       {
	 		       //��� - ��������� ��� �� 4 ��� ������ �� ��������
				if ($data_battle['blood']==2)
				{
				 mysql_query("UPDATE users SET hp=0 ,
	 		         sila = IF((@RR:=100*RAND())<30, settravmatv2_new(id,'sila',sila,level,{$data_battle['id']},{$data_battle['type']},align,trv,pasbaf), sila),
	 		         lovk = IF(@RR>=30 AND @RR<60, settravmatv2_new(id,'lovk',lovk,level,{$data_battle['id']},{$data_battle['type']},align,trv,pasbaf), lovk),
	 		         inta = IF(@RR>=60, settravmatv2_new(id,'inta',inta,level,{$data_battle['id']},{$data_battle['type']},align,trv,pasbaf), inta) where battle={$data_battle['id']} and battle_t!={$my_team_n} and hp > 0 and `level` > 3 and align!=5 ;");

					$err_text=mysql_error();
					 if ($err_text!='') {	addchp ('<font color=red>fbattle.php</font> travm-error  '.$err_text,'{[]}Bred{[]}'); }
				}
				else
				{
	 		         mysql_query("UPDATE users SET hp=0 ,
	 		         sila = IF((@RR:=100*RAND())<30, settravmat2(id,'sila',sila,level,{$data_battle['id']},{$data_battle['type']},trv), sila),
	 		         lovk = IF(@RR>=30 AND @RR<60, settravmat2(id,'lovk',lovk,level,{$data_battle['id']},{$data_battle['type']},trv), lovk),
	 		         inta = IF(@RR>=60, settravmat2(id,'inta',inta,level,{$data_battle['id']},{$data_battle['type']},trv), inta) where battle={$data_battle['id']} and battle_t!={$my_team_n} and hp > 0 and `level` > 3 and align!=5 ;");

       			 		$err_text=mysql_error();
			 		 if ($err_text!='') {	addchp ('<font color=red>fbattle.php</font> travm-error  '.$err_text,'{[]}Bred{[]}'); }
	 		         }


	 		       }
	 		    }
			 }

			$win_team_hist='t'.$user['battle_t'].'hist';

			//fix 29/07/2011
			//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			mysql_query("update battle set t1_dead='finlog' where id={$data_battle['id']} and t1_dead='' ;");
			if (mysql_affected_rows()>0)
					{
					//���� ������ ������ �� �����
			 		addlog($data_battle['id'],"!:F:".time().":".($vrag_exit==1?"0":"1").":".$data_battle[$win_team_hist]."\n");
			 		}
			////////////////////////


 		 // �������� ������



 		 	$winrez[0]=finish_battle($data_battle['win'],$data_battle,$data_battle['blood'],$data_battle['type'],$data_battle['fond']);
						 addlog($data_battle['id'],get_text_travm($data_battle));
						 addlog($data_battle['id'],get_text_broken($data_battle));
		   } //fix
		  // ���� ��������� � ����� ���
		  $STEP = 5;

	       						}
	       	   else
		     if ((isset($_POST['victory_time_out2'])) AND (!(($user['room']>=210)AND($user['room']<299))))
		      {
		     // ������� �������� ����� ������ ���
		     mysql_query("UPDATE battle set status=1 where id={$data_battle['id']}");
		    if (mysql_affected_rows() > 0)
	    		{ // fix

		     	//fix 29/07/2011
			//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			mysql_query("update battle set t1_dead='finlog' where id={$data_battle['id']} and t1_dead='' ;");
			if (mysql_affected_rows()>0)
					{
					//���� ������ ������ �� �����
		 			 addlog($data_battle['id'],"!:F:".time().":1\n");
			 		}
			////////////////////////
		 // �����
 		 // �������� ������
		    $data_battle['win']=0;

 		    $winrez[0]=finish_battle(0,$data_battle,$data_battle['blood'],$data_battle['type'],$data_battle['fond']);
		       addlog($data_battle['id'],get_text_broken($data_battle));
		       }
		  // ���� ��������� � ����� ���
		        $STEP = 5;
		     					 }

	       }

   }

if (($user['hp'] <=0) and ($STEP==1))
  {
  $STEP=4;
 // echo "fix";
  }

//echo "<br><font color=red>STEP:<b> $STEP </b></font><BR>";
//echo "POST:";
//print_r($_POST);
//echo "<br>GET:";
//print_r($_GET);

//////////////==================HTMLs
?>
<HTML>
<HEAD>
<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main2.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT LANGUAGE="JavaScript" SRC="http://i.oldbk.com/i/sl2.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="http://i.oldbk.com/i/js/clipboard.min.js"></SCRIPT>
<script type="text/javascript" src="/i/globaljs.js"></script>
<SCRIPT LANGUAGE="JavaScript" SRC="http://i.oldbk.com/i/js/ch5.js" charset="windows-1251"></SCRIPT>
<script type="text/javascript" src="http://i.oldbk.com/i/showthing.js"></script>
<script>
var loc = parent.location.href.toString();
if (loc.indexOf("/map.php") != -1) {
	parent.location.href = "fbattle.php";
}
</script>
<SCRIPT>
var Hint3Name = '';

function setDEF()
{
if (document.getElementById('fdefend') !=null )
	{
	document.getElementById('fdefend').value=document.getElementById('txtblockzone').value;
	}

if (document.getElementById('fenemy') !=null )
	{
	document.getElementById('fenemy').value=document.getElementById('penemy').value;
	}
}
// ���������, �������� �������, ��� ���� � �������

function findlogin(title, script, name){
	document.all("hint3").innerHTML = '<form action="'+script+'" method=POST name="fndl"><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
	'������� ����� ���������:<small><BR>(����� �������� �� ������ � ����)</TD></TR><TR><TD width=50% align=right><INPUT type=hidden id=fenemy name=enemy> <INPUT type=hidden id=fdefend name=defend><INPUT TYPE=text id="enterlogin" NAME="'+name+'" ID="'+name+'" OnKeyup="if (event.keyCode===13) { document.fndl.submit();};" ></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></td></tr></table></form>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	setDEF();
	document.all(name).focus();
	Hint3Name = name;
}


function ChangeEnemy(login) {
	if (document.all("hint3").style.visibility == "visible" && document.getElementById("enterlogin") != null) {
		document.getElementById("enterlogin").value = login;
		document.getElementById("enterlogin").focus();
	} else {
		location.href='/fbattle.php?login_target='+login;
	}
}

function selectFrend(login) {
	if (document.all("hint3").style.visibility == "visible" && document.getElementById("enterlogin") != null) {
		document.getElementById("enterlogin").value = login;
		document.getElementById("enterlogin").focus();
	} else {
		top.AddTo(login);
	}
}


function settings(){
	clearTimeout(timerID);
	document.all("hint3").innerHTML = '<form action="" method=POST>'+
	'<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>��������� �������</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr>'+
	'<tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td valign=top align=left width=130><INPUT type=hidden name=chng_sett style="width: 30px;" value=1> '+
	'<small>���������: <INPUT type=checkbox name=autostart <?=($_SESSION['autostart']==1?' checked ':'')?> value=1><br>'+
    '���� ������ <br><INPUT type=text name=marinad style="width: 40px;" value=<?=$_SESSION['marinad']?>> ������</small></td>'+
    '<td valign=top align=left width=110><small>���� <br>'+
    '<INPUT type=text name=u1 style="width: 30px;" value=<?=$_SESSION['u1']?>> � ������(%)<br>'+
    '<INPUT type=text name=u2 style="width: 30px;" value=<?=$_SESSION['u2']?>> � ������(%)<br>'+
    '<INPUT type=text name=u3 style="width: 30px;" value=<?=$_SESSION['u3']?>> � ����(%)<br>'+
    '<INPUT type=text name=u4 style="width: 30px;" value=<?=$_SESSION['u4']?>> � ����(%)<br>'+
	'</small></TD>'+
    '<td valign=top align=left  width=140><small>�������<br>'+
    '<INPUT type=text name=b1 style="width: 30px;" value=<?=$_SESSION['b1']?>> ������+������(%)<br>'+
    '<INPUT type=text name=b2 style="width: 30px;" value=<?=$_SESSION['b2']?>> ������+����(%)<br>'+
    '<INPUT type=text name=b3 style="width: 30px;" value=<?=$_SESSION['b3']?>> ����+����(%)<br>'+
    '<INPUT type=text name=b4 style="width: 30px;" value=<?=$_SESSION['b4']?>> ����+������(%)<br>'+
	'</small></TD>'+
	'<TD valign=top align=left><small>'+
    '���������� ������:<br><INPUT type=text name=kickcount style="width: 40px;" value=<?=($_SESSION['kickcount']>0?$_SESSION['kickcount']:0)?>>*0 ���������<br>'+
    '������� HP ��� ���������:<br><INPUT type=text name=hpstop style="width: 40px;" value=<?=($_SESSION['temp_hpstop']>0?$_SESSION['temp_hpstop']:0)?>>*0 ��� ���������<br>'+
	'</small></TD></TR>'+
	'<TR><TD></TD><TD></TD><TD></TD><TD align=right><INPUT TYPE="submit" value=" ��������� �� "></TD></TR></TABLE>'+
	'</td></tr></table></form>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	document.all("hint3").style.width = 520;
	document.all("hint3").focus();
	Hint3Name = "settings";
}

function comment_fight(title, script, name){
	document.all("hint3").innerHTML = '<form action="'+script+'" method=POST><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><form action="'+script+'" method=POST><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
	'������� ����� �����������:<small><BR>(�������� ��������)</TD></TR><TR><TD width=80% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=20%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></td></tr></table></form>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	document.all(name).focus();
	Hint3Name = name;
}

function okno(title, script, name,coma){
	document.all("hint3").innerHTML = '<form action="'+script+'" method=POST><table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
	'<table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><INPUT TYPE=hidden name=sd4 value="6"><td colspan=2>'+
	'������� �������� ��������</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR></TABLE></td></tr></table></form>';
	document.all("hint3").style.visibility = "visible";
	document.all("hint3").style.left = 100;
	document.all("hint3").style.top = 100;
	document.all(name).focus();
	Hint3Name = name;
}

var attack=true;
var defend=true;

function check(f,r)
{
   if (((! attack) || (! defend)) && (r!=1))
   {
   		alert('���� ��� ���� �� ������.');
   		return false;
   }
   else
   {
	   	if (r=='1' && ((! attack) || (! defend)))
	   	{
	   		return false;
	   	}
        else
        {
   			f.go.disabled = 1;
   			f.submit();
   			return true;
   		}
   }
}
function Prv(logins)
{
	top.frames['bottom'].window.document.F1.text.focus();
	top.frames['bottom'].document.forms[0].text.value = logins + top.frames['bottom'].document.forms[0].text.value;
}
function setattack(f) {
	attack=true;
	if(f){
		check(f,1);
	}
}
function setdefend(zone,f)
{
	defend=true
	document.getElementById('txtblockzone').value = zone;
	setDEF();
	if(f){
		check(f,1);
	}
}

		function refreshPeriodic()
		{
			<?
			if($data_battle['status'] == 0)
			{
				if (!(isset($_REQUEST['batl'])))
				{
					if ($data_battle['id']>0) { $_REQUEST['batl']=$data_battle['id']; }
                    elseif ($user['battle']>0)  { $_REQUEST['batl']=$user['battle']; }
                    elseif ($user['last_battle']>0)  { $_REQUEST['batl']=$user['last_battle']; }
				}
				echo "location.href='".$_SERVER['PHP_SELF']."?batl=".$_REQUEST['batl']."';//reload();";
			} else {
				echo "location.href.reload()";
			}
			?>

            var timeout = <?=($_SESSION['auto_f']==1?($nxt<5000?5000:30000):30000)?>;
			timerID=setTimeout("refreshPeriodic()", timeout);
		}
		timerID=setTimeout("refreshPeriodic()",<?=($_SESSION['auto_f']==1?($nxt<5000?5000:30000):30000)?>);



<?

                	if($_SESSION['auto_f']==1)
					{
					    if($nxt<=0)
					    {
					    	$nxt='700';
					    }
						if($_SESSION['nextattack']<time())
						{
						   $_SESSION['nextattack']=time()+$reloadpage+$nxt;
					    }
					}
?>

function bodyload()
{
    top.setHP(<?=$user['hp']?>,<?=$user['maxhp']?>);
    <?
    if( ($user['prem']>0 || $OPEN_AUTO==true)  && $_SESSION['auto_f']==1)
  	{?>
    		window.setTimeout("auto()",<?=$nxt?>);

	<?}

	?>

}

</script>

<style type="text/css">
.menu {
  background-color: #d2d0d0;
  border-color: #ffffff #626060 #626060 #ffffff;
  border-style: solid;
  border-width: 1px;
  position: absolute;
  left: 0px;
  top: 0px;
  visibility: hidden;
}

a.menuItem {
  border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none;
}

a.menuItem:hover {
  background-color: #a2a2a2;
  color: #0066FF;
}

span.menuItem:hover {
  background-color: #a2a2a2;
  color: #0066FF;
}

span.menuItem {
  border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none;
}

span {
  FONT-SIZE: 10pt;
  FONT-FAMILY: Verdana, Arial, Helvetica, Tahoma, sans-serif;
  text-decoration: none;
  FONT-WEIGHT: bold;
  cursor: pointer;
}
.my_clip_button {   border: 0px solid #000000;
  color: #003388;
  display: block;
  font-family: MS Sans Serif, Arial, Tahoma,sans-serif;
  font-size: 8pt;
  font-weight: bold;
  padding: 2px 12px 2px 8px;
  text-decoration: none; }
.my_clip_button.hover { background-color: #a2a2a2; color: #0066FF; }
</style>

</HEAD>

<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor=e2e0e0 onLoad="bodyload();">
<div id=hint3 class=ahint style="z-index:100;"></div>
<?
 if ($do_sound!='') {echo $do_sound;}
 	if ($nexten['hidden'] >0 )
 	{
 	$enemy_id=$nexten['hidden'];
 	}
 	else
 	{
	 $enemy_id=$enemy;
	 }
?>
<FORM action="<?=$_SERVER['PHP_SELF']?>" id="att" method=POST>
<TABLE width=100% cellspacing=0 cellpadding=0 border=0>
<input type=hidden value='<?=($user['battle']?$user['battle']:$_REQUEST['batl'])?>' name=batl><input type=hidden value='<?=$enemy_id?>' name=enemy1>
<INPUT TYPE=hidden name=myid value="<?=time();?>">
<TR><TD valign=top>
<TABLE width=250 cellspacing=0 cellpadding=0><TR>
<TD valign=top width=250 nowrap><CENTER>

<?
//����� ���������� ������
$user=mysql_fetch_array(mysql_query("select * from users where id='{$user['id']}' ;"));
$my_naem=false;

if (true)
	{


	$naem=mysql_fetch_array(mysql_query("select * from users_clons where owner='{$user['id']}' and naem_status=1 limit 1;"));
	if ($naem['id']>0)
			{
			if  (($user['battle'] > 0) and ($user['lab']==0) and ($user['room']!=90) and (!(($user['room']>=211 and $user['room']<240) or ($user['room']>240 and $user['room']<270) or ($user['room']>270 and $user['room']<290) or ($user['in_tower']>0) )) )
				{
				//�����
					if ($naem['battle']==0)
					{

						if ((($naem['fullentime']>0) and ($naem['energy']>=1))  OR ($naem['fullentime']==0) )
						{
						//�����
						$my_naem="<a href=?naem={$naem['id']}><img src='http://i.oldbk.com/i/icon_naembattle.gif' width='31px' title='�������� �������� {$naem['login']} '></a>";
						}
						else
						{
						//������
						$my_naem="<img src='http://i.oldbk.com/i/icon_naembattle.gif' style=\"opacity: 0.2; cursor: pointer;\"  width='31px' title='������� ������� ���� ��� ���, ���������� ������������ ��� �������!'>";
						}
					}
					else
					{
					//���
					$my_naem="<img src='http://i.oldbk.com/i/icon_naembattle.gif' style=\"opacity: 0.2; cursor: pointer;\"  width='31px' title='������� ��� � ���.'>";
					}
				}
				else
				{
				//������
				$my_naem="<img src='http://i.oldbk.com/i/icon_naembattle.gif' style=\"opacity: 0.2; cursor: pointer;\"  width='31px' title='���������� ��������� �������� � ���� ���.'>";
				}


			}

	}

showtelo($user,$my_wearItems,$my_magicItems,$user_eff,$my_naem);
?>

</TD></TR>
</TABLE>

</td>
<td  valign=top width=80%>
<?
 			$battle_status[0] = "��������";
			$battle_status[1] = "������� �����!";
			$battle_status[2] = "���������� �����!";
			$battle_status[3] = "��������� �����!";
			$battle_status[4] = "������ ����!";

			if (($data_battle['status_flag'] == 4) AND ($data_battle['coment']=='<b>��� ���������� �������-����</b>' ) )
				{
				$battle_status[4] = "��� ���������� �������-����!";
				}

			$battle_status[6] = "��������� �����! ����-����!";
			$battle_status[10] = "������� ����������� ���!";
			$battle_status[17] = "�������� ��� �� �����!";
			$battle_status[18] = "�������� ��� �� �������!";


			$a=0;
			$aa=($_SESSION['auto_f']==0?0:1);
			$af='';
			$af1='';
			//print_r($user[autofight]);
			$user['autofight']=0;
			if($user['autofight']==1)
			{
				$a=1;
				$af='this.form';
				$af1=',this.form';
			}

			$_SESSION['show_users_babil']=false; //  ��������� ������

	switch($STEP) {
		case 1 :
			{

						if($user['prem']>0  || $OPEN_AUTO==true )
							{
							?>
							<script>
								function auto()
								{

								         var f1 = <?=$a_attack?>;
										 var f2 = <?=$a_block?>;
										 document.all['A'+f1].checked = true;
										 document.all['D'+f2].checked = true;
										 attack=true;
										 defend=true;
									 	 document.forms["att"].submit();
								}
							</script>
							<?
							}

						if($user['id']==28453)
						{
							echo 'window.setTimeout("auto()",'.$nxt.');';
						}
                    ?>

						<TABLE width=100% border=0 cellspacing=0 cellpadding=0 ><TR><TD colspan=3><h3 style="margin-bottom: 0px;">
						<?
						if (( ($data_battle['type']==101) OR ($data_battle['type']==141) OR ($data_battle['type']==151)) and ($data_battle['status_flag']==0))
						{ echo "������� �������� �����!"; }
						elseif  (($data_battle['type']==7)  and  ($data_battle['status_flag']==10) )
							{
							echo $battle_status[17] ;
							}
						elseif  (($data_battle['type']==8)  and  ($data_battle['status_flag']==10) )
							{
							echo $battle_status[18] ;
							}
						else
						{
						echo $battle_status[$data_battle['status_flag']] ;
						}
				/////////////// ���� ����� �������� ��� - ����
				if ($data_battle['type'] == 40 ||  $data_battle['type'] == 41 ||  $data_battle['type'] == 140 ||  $data_battle['type'] == 141 || $data_battle['type'] == 150 || $data_battle['type'] == 151 ||  $data_battle['coment'] == "<b>��� �� ����������� �������</b>" ||  $data_battle['coment'] == "<b>����-����</b>"  )
				{
				 	$get_wes=mysql_fetch_array(mysql_query("SELECT * from `battle_war` where battle='{$data_battle['id']}' "));
					if  ($get_wes['active']==1)
					{
					  if ( ($get_wes['t1'] >= $get_wes['wmax']) AND ($get_wes['t2'] < $get_wes['t1']) )     {   $vclass1='ves1n';   }   else   {  $vclass1='ves1';   }
					  if ( ($get_wes['t2'] >= $get_wes['wmax']) AND ($get_wes['t1'] < $get_wes['t2']) )     {   $vclass2='ves2n';   }   else   {  $vclass2='ves2';   }
					  $ves1=$get_wes['t1'];   $ves2=$get_wes['t2'];  $planka=$get_wes['wmax'];
					echo "<center><table border=0 height=50 width=157 style=\"background-image: url(http://i.oldbk.com/i/ves_jpg.jpg);   background-position: center center; background-repeat: no-repeat;\">
					<tr align=center>
					<td  width=52 class=$vclass1> $ves1 </td>
					<td  width=52 class=vesp> $planka </td>
					<td  width=52 class=$vclass2> $ves2 </td>
					</table>
					</center>";
					}
					 else 	 {   $vclass1='ves1';  $vclass2='ves2';  $ves1=0;  $ves2=0;  $planka=0;

				echo "<center><table border=0 height=50 width=157 style=\"background-image: url(http://i.oldbk.com/i/ves_jpg.jpg);   background-position: center center; background-repeat: no-repeat; opacity: 0.2; -ms-filter: 'alpha(opacity=20)'; filter: alpha(opacity=20);\">
				<tr align=center>
				<td  width=52 class=$vclass1> $ves1 </td>
				<td  width=52 class=vesp> $planka </td>
				<td  width=52 class=$vclass2> $ves2 </td>
				</table>
				</center>";
					 }


				}
				////////////////////////////////////////////////////////////////////


						?></TD></TR>
							<TR><TD width=45% >&nbsp;</TD>
							<TD align=center style="margin-bottom: 0px;"><font color=660000><B>��� ���</B></font></TD>
							<TD width=45% align=right>&nbsp;</TD>
						</TR></TABLE>
						<BR>
						<CENTER>
				<?

					if($user['level'] > 3)
					{
					// ����� ��� ��� ������



					// ������� ��������� - �� ����
						if ($_GET['buf'])
						{
							echo "<font color=red><b>".$_GET['buf']."</b></font><BR>";
						}
					//�������
						 if (($user['level']>=6) and ($user['in_tower']==0 || $user['in_tower']==16) and ($user['ruines']==0) )

						{
						 if   (!((($user['room']>=211) and ($user['room']<=222)) OR (($user['room']>=271) and ($user['room']<=282)) ))
						 	{
							echohelper($user,$data_battle);
							}
						}

						//������
						if ($data_battle['type'] == 171) {
							$slots=array($users['m1'],$users['m2'],$users['m3'],$users['m4'],$users['m5']);
							$all_slotsc=5;
						} else {
							$slots=array($users['m1'],$users['m2'],$users['m3'],$users['m4'],$users['m5'],$users['m6'],$users['m7'],$users['m8'],$users['m9'],$users['m10']);
							$all_slotsc=10;

							$repcount = (int)$user['rep']/ 20000;
							if($repcount < 0) $repcount = 0;
							if($repcount > 5) $repcount = 5;
							$all_slotsc+=$repcount;
							for($i = 11; $i <= $repcount; $i++)
							{
								$slots[]=$user['m'.$i];
							}

							if ($user['prem'] > 0 && $user['in_tower'] == 0) {
								for($i = 16; $i <= getMaximumSlot($user['prem']); $i++) {
									$slots[]=$user['m'.$i];
								}
							}
						}

/*
						//load data
						$all_scroll=mysql_query("SELECT * FROM oldbk.`inventory` WHERE `id` in (".implode(",",$slots).")  LIMIT 1;");
						echo "SELECT * FROM oldbk.`inventory` WHERE `id` in (".implode(",",$slots).")  LIMIT 1;" ;

						while ($scroll = mysql_fetch_array($all_scroll))
						{
						$data_scroll[$scroll]=$scroll;
						}
*/

						//print
						for($i = 1; $i <= $all_slotsc; $i++)
						{
						echoscroll('m'.$i,$data_scroll[$user['m'.$i]]);
						if (!($i % 10)) echo '<br>';
						}
						if ($user['prem'] > 0 && $user['in_tower'] == 0) {
							for($i = 16; $i <= getMaximumSlot($user['prem']); $i++) {
								echoscroll('m'.$i,$data_scroll[$user['m'.$i]]);
							}
						}



						if (($user['in_tower'] == 0) AND ($data_battle['nomagic']==0))
						{
							$q = mysql_query('SELECT * FROM effects WHERE owner = '.$user['id'].' and type = 794 and lastup < 1');
							if (mysql_num_rows($q) > 0) {
								$m = mysql_fetch_assoc($q);
								// ������
								echo "<a onclick=\"";
									echo "if(confirm('������������ ������?')) {
								 	window.location='fbattle.php?useb794=1&enemy='+document.getElementById('penemy').value+'&defend='+document.getElementById('txtblockzone').value;

								}";
								echo "\" href='#'>";
								echo '<img src="http://i.oldbk.com/i/magic/cure600.gif" width=40 title="������� �������������� �������  ��������� '.$m['lastup'].'/1"  height=25 alt="������������  ������� �������������� �������\n��������� "'.$m['lastup'].'"/5"></a>';
							}
						}
					}



						if ( ($user['lab']>0) OR ($user['room']>240 and $user['room']<270) OR ($user['room']>270 and $user['room']<290) )
						 {
						 // ���� ���� � ����� ������ �����  �� ������� ����
						 }
						 else
						{
							if (  ((is_array($user_eff[150])) OR (is_array($user_eff[930])) OR (is_array($user_eff[920])) OR (is_array($user_eff[130]) ) ) AND ($user['mana']<=0) )
							{
							echo "<center><font color=red><small><b>�������� ����� ���� ��������, ����� ������ �� �������!</b></small></font></center>";
							}
						}

							$AT=mt_rand(1,4);
							$DF=mt_rand(1,4);

//echo "IType:{$WEAP_ITYPE}";
							?>
							<TABLE cellspacing=0 cellpadding=0>
							<TR>
								<TD align=center bgcolor=f2f0f0><b>�����</b></TD>
								<TD>&nbsp;</TD>
								<TD align=center bgcolor=f2f0f0><b>������</b></TD>
							</TR>
							<TR><TD>
							<?
						if ($WEAP_ITYPE==0)
						{
						//������ ��������� ��-���������
						?>

								<TABLE cellspacing=0 cellpadding=0>
				   					<TR><TD><INPUT TYPE=radio ID=A1 NAME=attack value=1 <? if ($AT==1) { echo "checked"; } echo $user['test']['1']['1']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A1>���� � ������</LABEL></TD></TR>
									<TR><TD><INPUT TYPE=radio ID=A2 NAME=attack value=2 <? if ($AT==2) { echo "checked"; } echo $user['test']['1']['2']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A2>���� � ������</LABEL></TD></TR>
			    					<TR><TD><INPUT TYPE=radio ID=A3 NAME=attack value=3 <? if ($AT==3) { echo "checked"; }echo $user['test']['1']['3']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A3>���� � ����(���)</LABEL></TD></TR>
			   					    <TR><TD><INPUT TYPE=radio ID=A4 NAME=attack value=4 <?  if ($AT==4) { echo "checked"; } echo $user['test']['1']['4']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A4>���� �� �����</LABEL></TD></TR>
								</TABLE>

							</TD><TD>&nbsp;</TD><TD>

								<TABLE cellspacing=0 cellpadding=0>
								<TR><TD><INPUT TYPE=radio ID=D1 NAME=defend value=1 <? if ($DF==1) { echo "checked"; } echo $user['test']['0']['1']; ?> onClick="setdefend(1<?=$af1?>)"><LABEL FOR=D1>���� ������ � �������</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D2 NAME=defend value=2 <? if ($DF==2) { echo "checked"; } echo $user['test']['0']['2']; ?> onClick="setdefend(2<?=$af1?>)"><LABEL FOR=D2>���� ������� � �����</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D3 NAME=defend value=3 <? if ($DF==3) { echo "checked"; }  echo $user['test']['0']['3']; ?> onClick="setdefend(3<?=$af1?>)"><LABEL FOR=D3>���� ����� � ���</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D4 NAME=defend value=4 <? if ($DF==4) { echo "checked"; } echo $user['test']['0']['4']; ?> onClick="setdefend(4<?=$af1?>)"><LABEL FOR=D4>���� ������ � ���</LABEL></TD></TR>
								</TABLE>
						<?
						}
						elseif ($WEAP_ITYPE==1)
						{
						//� ���� �������� - ��� ���� - ���� ������ ����
						?>

								<TABLE cellspacing=0 cellpadding=0>
				   					<TR><TD><INPUT TYPE=radio ID=A1 NAME=attack value=1 <? if ($AT==1) { echo "checked"; } echo $user['test']['1']['1']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A1>���� � ������</LABEL></TD></TR>
									<TR><TD><INPUT TYPE=radio ID=A2 NAME=attack value=2 <? if ($AT==2) { echo "checked"; } echo $user['test']['1']['2']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A2>���� � ������</LABEL></TD></TR>
			    					<TR><TD><INPUT TYPE=radio ID=A3 NAME=attack value=3 <? if ($AT==3) { echo "checked"; }echo $user['test']['1']['3']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A3>���� � ����(���)</LABEL></TD></TR>
			   					    <TR><TD><INPUT TYPE=radio ID=A4 NAME=attack value=4 <?  if ($AT==4) { echo "checked"; } echo $user['test']['1']['4']; ?> onClick="setattack(<?=$af?>)"><LABEL FOR=A4>���� �� �����</LABEL></TD></TR>
								</TABLE>

							</TD><TD>&nbsp;</TD><TD>

								<TABLE cellspacing=0 cellpadding=0>
								<TR><TD><INPUT TYPE=radio ID=D1 NAME=defend value=1 <? if ($DF==1) { echo "checked"; } echo $user['test']['0']['1']; ?> onClick="setdefend(1<?=$af1?>)"><LABEL FOR=D1>���� ������</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D2 NAME=defend value=2 <? if ($DF==2) { echo "checked"; } echo $user['test']['0']['2']; ?> onClick="setdefend(2<?=$af1?>)"><LABEL FOR=D2>���� �������</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D3 NAME=defend value=3 <? if ($DF==3) { echo "checked"; }  echo $user['test']['0']['3']; ?> onClick="setdefend(3<?=$af1?>)"><LABEL FOR=D3>���� �����</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D4 NAME=defend value=4 <? if ($DF==4) { echo "checked"; } echo $user['test']['0']['4']; ?> onClick="setdefend(4<?=$af1?>)"><LABEL FOR=D4>���� ���</LABEL></TD></TR>
								</TABLE>
						<?
						}
						elseif ($WEAP_ITYPE==2)
						{
						$AT2=mt_rand(1,4);
						?>

								<TABLE cellspacing=0 cellpadding=0>
				   				<TR><TD><INPUT TYPE=radio ID=A1 NAME=attack value=1 <? if ($AT==1) { echo "checked"; }  ?> onClick="setattack(<?=$af?>)">
					   				<INPUT TYPE=radio ID=AA1 NAME=attack2 value=1 <? if ($AT2==1) { echo "checked"; } ?> onClick="setattack(<?=$aaf?>)">
				   					<LABEL FOR=A1>���� � ������</LABEL></TD></TR>

								<TR><TD><INPUT TYPE=radio ID=A2 NAME=attack value=2 <? if ($AT==2) { echo "checked"; } ?> onClick="setattack(<?=$af?>)">
									<INPUT TYPE=radio ID=AA2 NAME=attack2 value=2 <? if ($AT2==2) { echo "checked"; } ?> onClick="setattack(<?=$aaf?>)">
									<LABEL FOR=A2>���� � ������</LABEL></TD></TR>

			    					<TR><TD><INPUT TYPE=radio ID=A3 NAME=attack value=3 <? if ($AT==3) { echo "checked"; } ?> onClick="setattack(<?=$af?>)">
									<INPUT TYPE=radio ID=AA3 NAME=attack2 value=3 <? if ($AT2==3) { echo "checked"; } ?> onClick="setattack(<?=$aaf?>)">
			    					<LABEL FOR=A3>���� � ����(���)</LABEL></TD></TR>

			   					<TR><TD><INPUT TYPE=radio ID=A4 NAME=attack value=4 <?  if ($AT==4) { echo "checked"; }  ?> onClick="setattack(<?=$af?>)">
									<INPUT TYPE=radio ID=AA4 NAME=attack2 value=4 <?  if ($AT2==4) { echo "checked"; }  ?> onClick="setattack(<?=$aaf?>)">
			   					<LABEL FOR=A4>���� �� �����</LABEL></TD></TR>
								</TABLE>

							</TD><TD>&nbsp;</TD><TD>

								<TABLE cellspacing=0 cellpadding=0>
								<TR><TD><INPUT TYPE=radio ID=D1 NAME=defend value=1 <? if ($DF==1) { echo "checked"; }  ?> onClick="setdefend(1<?=$af1?>)"><LABEL FOR=D1>���� ������</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D2 NAME=defend value=2 <? if ($DF==2) { echo "checked"; }  ?> onClick="setdefend(2<?=$af1?>)"><LABEL FOR=D2>���� �������</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D3 NAME=defend value=3 <? if ($DF==3) { echo "checked"; }  ?> onClick="setdefend(3<?=$af1?>)"><LABEL FOR=D3>���� �����</LABEL></TD></TR>
								<TR><TD><INPUT TYPE=radio ID=D4 NAME=defend value=4 <? if ($DF==4) { echo "checked"; }  ?> onClick="setdefend(4<?=$af1?>)"><LABEL FOR=D4>���� ���</LABEL></TD></TR>
								</TABLE>
						<?

						}
						elseif ($WEAP_ITYPE==3)
						{


						}

						?>
							</TD></TR>
							<TR>
							<TD colspan=3 align=center bgcolor=f2f0f0>
							<table cellspacing=0 cellpadding=0 width=100% border=0>
							<tr>
							<td align=center>&nbsp;<INPUT TYPE=submit id=go name=go value="������ !!!" onClick="return check(this.form)">
							<?
							if($user['prem']>0  || $OPEN_AUTO==true )
							{
							//onClick="return auto(this.form)" nClick="auto()"
								?>
							    &nbsp;
								<a onclick="settings();" style="cursor: pointer"  align="absmiddle"><small>���������</small></a>
                                				<INPUT TYPE=button id=go1 name=go1 value="������� <?=($aa==1?'����':'���')?>" onclick="location.href='?ch_auto_a=<?=($aa==1?'0':'1')?>'" >

		                    <?
		                    }
		                    ?>
							</td>

							<?
							if (($data_battle['type']==60 or $data_battle['type']==61) OR ($data_battle['status_flag']==6))
							{
							$lider1=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE var='leader1' ; "));
							if ($lider1['val']==$user['id'])
							  {
							  echo '<td valign=top style="width:16px; padding-left:2px;">';
							  echo "<a href=\"javascript:;\" onclick=\"window.open('turn.php','','scrollbars=yes,toolbar=no,status=no,resizable=yes,width=400,height=400')\"><img src='http://i.oldbk.com/i/leader.gif' width=16 height=19 style='cursor:pointer' title='���������' alt='���������'></a>";
							  echo '</td>';
							  }
							  else
							  {
							  $boec_t1[$lider1['val']]['lid']=1;
							  }
							$lider2=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE var='leader2' ; "));
							if ($lider2['val']==$user['id'])
							  {
							  echo '<td valign=top style="width:16px; padding-left:2px;">';
							  echo "<a href=\"javascript:;\" onclick=\"window.open('turn.php','','scrollbars=yes,toolbar=no,status=no,resizable=yes,width=400,height=400')\"><img src='http://i.oldbk.com/i/leader.gif' width=16 height=19 style='cursor:pointer' title='���������' alt='���������'></a>";
							  echo '</td>';
							  }
							  else
							  {
							  $boec_t2[$lider2['val']]['lid']=1;
							  }

							 $lider3=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE var='leader3' ; "));
							  if ($lider3['val']==$user['id'])
							  {
							  echo '<td valign=top style="width:16px; padding-left:2px;">';
							  echo "<a href=\"javascript:;\" onclick=\"window.open('turn.php','','scrollbars=yes,toolbar=no,status=no,resizable=yes,width=400,height=400')\"><img src='http://i.oldbk.com/i/leader.gif' width=16 height=19 style='cursor:pointer' title='���������' alt='���������'></a>";
							  echo '</td>';
							  }
							  else
							  {
							  $boec_t3[$lider3['val']]['lid']=1;
							  }

							}

								?>
									<td valign=top style="width:16px; padding-left:2px;">
										<?/*
										<a align="absmiddle" href=?ch_auto=<?=($a==1?'0':'1')?>>
										<img src='http://i.oldbk.com/i/aft<?=($a==1?'0':'1')?>.gif' width=16 height=19 style='cursor:pointer' title='����������������� ����� <?=($a==1?'���������':'��������')?>' alt='����������������� ����� <?=($a==1?'���������':'��������')?>'>
										</a>*/?>
									</td>
									<td valign=top style="width:16px; padding-left:2px;">
										<a onclick="findlogin('������� ����� ���������', '<?=$_SERVER['PHP_SELF']?>?batl=<?=$_REQUEST['batl']?>', 'login_target');" align="absmiddle">
										<img src='http://i.oldbk.com/i/en_change.gif' width=16 height=19 style='cursor:pointer' title='������� ����������' alt='������� ����������'>
										</a>
									</td>
									<td valign=top style="width:16px; padding-left:2px;">
										<a onClick="location.href='<?=$_SERVER['PHP_SELF']?>?batl=<?=$_REQUEST['batl']?>';">
										<img src='http://i.oldbk.com/i/ico_refresh.gif' width=16 height=19 style='cursor:pointer' alt='��������'></a>
									</td>
								</tr>
							</table>
							</TD>
						</TR>
						<TR>
						<TD align=center colspan=4>
						<?
							if ($user['in_tower'] == 0)
							{
							$_SESSION['show_users_babil']=true; // ����� ������������
							echo_users_babil($user);
							}

						?></TD>
						</TR>
						 <?
						//hide id for hideens by fred
						if ($nexten['hidden'] >0)
						{
						$enemyidout=$nexten['hidden'];
						//echo "FFF 1";
						}
						else
						{
						$enemyidout=$enemy;
						//echo "FFF 2";
						}
						 ?>
						<INPUT TYPE=hidden name=enemy id=penemy value="<?=$enemyidout?>">
					</TABLE>
					</CENTER>
			<?
			}
		break;
		case 2 :
			{
				echo '<FONT COLOR=red>������� ���� ����������...</FONT><BR><CENTER><INPUT TYPE=submit value="��������" name=',(($user['battle']>0)?"battle":"end"),'>';
					if($user['prem']>0  || $OPEN_AUTO==true)
					{
					//onClick="return auto(this.form)" nClick="auto()"
						?><script>
								function auto()
								{

								}
						   </script>
					    &nbsp;
					    	<a onclick="settings();" style="cursor: pointer"  align="absmiddle"><small>���������</small></a>
						<INPUT TYPE=button id=go1 name=go1 value="������� <?=($aa==1?'����':'���')?>" onclick="location.href='?ch_auto_a=<?=($aa==1?'0':'1')?>'" >
                    <?
                    }

				echo '<BR></CENTER>';
			}
		break;
		case 3 :
		    {
		    		 if($user['prem']>0  || $OPEN_AUTO==true )
						{
							?>
							<script>
								function auto()
								{
								}
							</script>
							<?
						}

				echo "<center><BR>��������� ����� �� ������ ���� ���, �� ������ ��������� ��� �����������<BR>
					<INPUT TYPE=submit value=\"��, � �������!!!\" name=victory_time_out id=\"refreshb\"><BR>";
				if  (!$user['in_tower'] && $user['room']!=200 && $user['ruines']==0 )
				 {
				   if (!(($user['room']>210)AND($user['room']<299)) )
				      {
					echo "��� �������� �����<BR>
					<INPUT TYPE=submit id=\"refreshb\" value=\"�������, ��� ����� ��� �� ����\" name=victory_time_out2><BR>";
				      }

				}

				if (!(($user['room']>210)AND($user['room']<299)) )
				      {
				      echo "���<BR><INPUT TYPE=submit value=\"��������� ��� �������\" name=",(($user['battle']>0)?"battle":"end"),">";
				      }
				echo "	</center>";
			}
		break;
		case 4:
		      {
				if($user['prem']>0  || $OPEN_AUTO==true )
						{
							?>
							<script>
								function auto()
								{
								}
							</script>
							<?
						}

		//�������� ������ �� ��������� ���
		if (!(($user['in_tower']==3) OR ($user['room']==270)))
			{
			ref_drop ($user['id']);
			}

				$_SESSION['auto_f']=0;
				echo '<FONT COLOR=red>�������, ���� ��� �������� ������ ������...</FONT><BR><CENTER><INPUT TYPE=submit value="��������" name=',(($user['battle']>0)?"battle":"end"),'><BR></CENTER>';
		      }
		break;

		case 5:
		    {
		   // echo "Win: $data_battle['win'] , T: $user['battle_t'] <br>";
		    // ��� 5-�� ���� ������� ��� � ����� ������

		      if($user['prem']>0  || $OPEN_AUTO==true )
						{
							?>
							<script>
								function auto()
								{
								}
							</script>
							<?
						}

		    if (!$damexp) {

			          if($user['battle']>0) {

			          	 $ll = $user['battle'];
			          	 	}
			          	 	else {

			          	 	 $ll = $user['last_battle'];
			          	 	 }
		        	  $damexp = get_damexp($ll, $user['id']);
		        	  }
				$win_team=($user['battle_t']==3?4:$user['battle_t']);
				if (  ( ($data_battle['win']!=$win_team) and ( $data_battle['win']!=0))  OR  ( $data_battle['win']==0))
				{
				// �������� ��� �����


				  // ������
				   if ($data_battle['win']!=0)
				      {

		//if ($user['battle']!=0)



					if (($data_battle['type']>=601) and ($data_battle['type']<=604) )
					{

					     $damexp['exp']=round($damexp['exp']);
					}
					elseif (($data_battle['type']>240) AND ($data_battle['type'] < 269))
					   {

					   //��������� �����
					   	/*
						$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=4"));
						if ($get_ivent['stat']==1)
						{
						$addekof=1.5;
					     	$pocent+=150;
						}
						else
						{
						$addekof=1;
					     	$pocent+=100;
						}
					     $damexp['exp']=round($damexp['exp'] * $addekof );	//100% ��� 150 ���� ����� �� ����� ����������� ������� � ����� ������ ������ ��������
					     */
					   }
					elseif (($data_battle['type']==60) OR ($data_battle['type']==61))
					   {

					   $get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=10"));
						if ($get_ivent['stat']==1)
						{
						//���� ���������
						     $damexp['exp']=round($damexp['exp']*1.05);
						}
						else
						{
						     $damexp['exp']=round($damexp['exp']*0.7);
						}
					   }
					elseif ($data_battle['status_flag']==1)
					{
					$damexp['exp']=round($damexp['exp']*0.1);
					}
					elseif ($data_battle['status_flag']==10)
					{
					$damexp['exp']=round($damexp['exp']*0.1);
					}
					elseif ($data_battle['status_flag']==2)
					{
					$damexp['exp']=round($damexp['exp']*0.2);
					}
					elseif ($data_battle['status_flag']==3)
					{
					$damexp['exp']=round($damexp['exp']*0.3);
					}
					elseif ($data_battle['status_flag']==4)
					{
					$damexp['exp']=round($damexp['exp']*1);
					}
					elseif ($data_battle['type']==7)
					{
					$damexp['exp']=round($damexp['exp']*0.1);
					}
					 elseif($EXP_TO_LOSE==1)
					 {

					  	 $damexp['exp']=round($damexp['exp']*0.1);
					  }
					 else
					 {

  					     $damexp['exp']=0;
					 }

				      }  //������
				      else
				      {
				      //�����
					 $damexp['exp']=0;
					 }
				}
				 else
				{

				  // ������
		 		  //��������� ����
				  if ($data_battle['type']==30)
								{
									$labpoz=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_users` WHERE `owner` = '{$user['id']}' LIMIT 1;"));
									mysql_query("UPDATE `labirint_items` SET `val`=0  WHERE `map`='".$labpoz['map']."' and (`item`='R' OR `item`='J'  OR `item`='�'  )and `x`='".$labpoz['x']."' and `y`='".$labpoz['y']."' and `active`=1 ;");
									mysql_query("UPDATE `labirint_items` SET `count`=0  WHERE `map`='".$labpoz['map']."' and `item`='I' and `x`='".$labpoz['x']."' and `y`='".$labpoz['y']."' and `count`=-1 ;");
								}
				}
				if ($damexp['exp']==0)
				 {
				 $damexp['exp']=$_SESSION['get_exp'];
				 }


		 if ($TEXT_WAIT)
		 	{
				echo '<CENTER><BR><B><FONT COLOR=red>'.$TEXT_WAIT.'</FONT></B>';
				echo '<BR><INPUT TYPE=submit value="��������" name="refresh"><BR></CENTER>';
		 	}
			else
				 	{

				/*	 	if ($finref!='')
				 		{
						echo '<CENTER><BR><B><FONT COLOR=red>'.$finref.'</FONT></B>';
				 		}
				 		else */
				 		{
						echo '<CENTER><BR><B><FONT COLOR=red>��� ��������! ����� ���� �������� ����� ',$damexp['damage'],' HP. �������� ����� ',$damexp['exp'],'.</FONT></B>';
						}





				 if (($user['battle_fin']==1) and ($data_battle['win']!=3) )
				 	{

					$tu=mysql_fetch_array(mysql_query("select * from users where id='$user[id]' "));


						if ($tu['battle']==$data_battle['id'])
							{
								if ($user['id']==14897)   echo "IN BATTLE";
							}
							else
							{
							//if ($user['id']==14897) die('stop');

							echo '<BR><INPUT TYPE=submit value="��������" name="end"><BR></CENTER>
							<script>
							location.href = "fbattle.php";
							</script>';
							}
				 	}
				 	else
				 	{
					echo '<BR><INPUT TYPE=submit value="���������" name="end"><BR></CENTER>';
					}


					}


			//fix bag
			 if (($data_battle['win']!=3) and ($data_battle['status']==1) and ($data_battle['t1_dead']=='finbatt') and ($user['battle']>0) )
			 	{
			 	//sleep(5);
		   		//mysql_query("UPDATE `users` SET `battle`=0, `battle_t`=0, `battle_fin`=0 WHERE `id`='{$user['id']}' and battle='{$user['battle']}' ; ");
				//$bug_rez=mysql_affected_rows();
				// if ($bug_rez!=0)
				/// 	{
		 	 	//	addchp ('<font color=red>fbattle.php</font> ��������� ���� ������� �����:'.$user['login'].'/��� '.$user['battle'].' ���������:'.$bug_rez.'  ','{[]}Bred{[]}');
		 	 	//	addchp ('<font color=red>fbattle.php</font> ��������� ���� ������� �����:'.$user['login'].'/��� '.$user['battle'].' ���������:'.$bug_rez.'  ','{[]}�������{[]}');
		 	 	//	}
			 	}





		    }
		break;

	}

if($STEP!=5)
{ // ������ �������
?>
</CENTER>
<HR>
<div id=mes>
<?
$ffs ='';
$i=0;
if ($data_battle['t1']!='')
{
	$i=0;
	$T1=explode(";",$data_battle['t1']);
	foreach ($T1 as $k => $v)
	{

	if ( ($boec_t1[$v]!='')  )
	{
		++$i;
		if ($i > 1) { $cc = ', '; } else { $cc = ''; }


		if ($data_battle['type']==61)
		{
		$ffs .= $cc.bat_nick_team($boec_t1[$v],"B11");
		}
		else
		{
		$ffs .= $cc.bat_nick_team($boec_t1[$v],"B1");
		}

	 }
	}


	if (isset($_GET['tfon']))
	{
	$_SESSION['tfon']=(int)$_GET['tfon'];
	}
		if ($_SESSION['tfon']==1) { echo "<a href='fbattle.php?tfon=0' ><img src='http://i.oldbk.com/i/tfon.gif' width=16 height=19 style='cursor:pointer' title='�������� ������� ������' alt='�������� ������� ������'></a>"; }
						else { echo "<a href='fbattle.php?tfon=1' ><img src='http://i.oldbk.com/i/tfoff.gif' width=16 height=19 style='cursor:pointer' title='��������� ������� ������' alt='��������� ������� ������'></a>";}

	if ($i>0)
	{
	if ($data_battle['type']==61) { echo "<img src='http://i.oldbk.com/i/align_6.gif'> "; }

	echo '<IMG SRC=http://i.oldbk.com/i/lock.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="������ ������� 1" style="cursor:pointer" onClick="Prv(\'private [team-1] \')">';
	echo $ffs;
	$A=1;
	}
$i=0;
}
if ($data_battle['t2']!='')
{
	if ($A) {  $kom2_echo=" ������ "; } else {  $kom2_echo=" "; }
	$ffs ='';
	$T2=explode(";",$data_battle['t2']);
	foreach ($T2 as $k => $v)
	{
	if ( ($boec_t2[$v]['login']!='')  )
	{
		++$i;
		if ($i > 1) { $cc = ', '; } else { $cc = ''; }

		if ($data_battle['type']==61)
		{
		$ffs .= $cc.bat_nick_team($boec_t2[$v],"B12");
		}
		else
		{
		$ffs .= $cc.bat_nick_team($boec_t2[$v],"B2");
		}

	 }
	}
	if ($i>0)
	{
	if ($data_battle['type']==61) { $kom2_echo.="<img src='http://i.oldbk.com/i/align_3.gif'> "; }
	$kom2_echo.='<IMG SRC=http://i.oldbk.com/i/lock.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="������ ������� 2" style="cursor:pointer" onClick="Prv(\'private [team-2] \')">';
	$kom2_echo.=$ffs;
	echo $kom2_echo;
	}

$i=0;

$B=1;
}
if ($data_battle['t3']!='')
{
	if (($A)OR($B)) {  $kom3_echo=" ������ "; }
	$ffs ='';
	$T3=explode(";",$data_battle['t3']);
	foreach ($T3 as $k => $v)
	{
	if ( ($boec_t3[$v]['login']!='')  )
	{
		++$i;
		if ($i > 1) { $cc = ', '; } else { $cc = ''; }

		if ($data_battle['type']==61)
		{
		$ffs .= $cc.bat_nick_team($boec_t3[$v],"B13");
		}
		else
		{
		$ffs .= $cc.bat_nick_team($boec_t3[$v],"B3");
		}


	 }
	}
	if ($i>0)
	{
	if ($data_battle['type']==61) { $kom3_echo.="<img src='http://i.oldbk.com/i/align_2.gif'> "; }
	$kom3_echo.= '<IMG SRC=http://i.oldbk.com/i/lock.gif WIDTH=20 HEIGHT=15 BORDER=0 ALT="������ ������� 3" style="cursor:pointer" onClick="Prv(\'private [team-3] \')">';
	$kom3_echo.=$ffs;
	echo $kom3_echo;
	}

$i=0;
$C=1;
}

?>

<HR>
</div>
<?
} else {
	echo "<HR>";
}
echo "�� ������ ������ ���� �������� �����:";
if ($user['battle']>0)
{
$damexp=get_damexp($user['battle'], $user['id']);
}
echo "<B>".$damexp['damage']." HP</B>.<br>";

if (($user['in_tower']==0) or ($data_battle['type']==1210) )
	{
	echo '<font class=dsc>(��� ���� � ��������� '.$data_battle['timeout'].' ���.)</font><BR>';
 	}

/// ��������� ��� ���

 	if($user['battle']) { $ll = $user['battle'];} else { $ll = $user['last_battle']; }


		//������ �� �����
		$logdir=(int)($ll/1000);


		$logdir="/www/data/combat_logs/".$logdir."000";



		$log_file_name=$logdir."/battle".$ll.".txt";

if (file_exists($log_file_name))
{
		$fs = filesize($log_file_name);
		$fh = fopen($log_file_name, "r");// or die("Can't open file!");
		fseek($fh, -1024, SEEK_END);
//		$log[0] = fread($fh, 4256);
		$log=array();
		while(!feof($fh))
			{
			 $tmp=fgets($fh);
				 if (strpos($tmp,"<BR>") > 0)
				 {
				 	$oldlog = explode("<BR>",$tmp);
					 foreach ($oldlog as $oldline)
					 	{
					 	$log[]=$oldline;
					 	}
				 }
				 else
				 {
				 $log[]=$tmp;
				 }
			 }
		fclose($fh);
		$ic =(int)(count($log)-2);
		if ($ic<0) { $ic=0; }


		if ($fs >= 1024) {
				$max = 1;
			} else {
				$max = 0;
			}
//echo "DD:$ic <br>";
		for($i=$ic;$i>=0+$max;--$i)
			{
//echo "i:$i <br>";
			$temp_line=$log[$i];
			$log[$i]=get_log_string($log[$i]);

			if(stripos($temp_line,$user['login']) !== false)
				{
				$log[$i] = str_replace("<span class=date>","<span class=date2>",$log[$i]);
				}
			$log[$i]=trim($log[$i]);
			if ( $log[$i] !='' ) { echo $log[$i]."<BR>\n"; }
			}

		unset($ic);

if ($max == 1 )
	{
	echo '�������� ��� ���������� ������ ����������. ������ ������ �������� <a href="logs.php?log='.($user['battle']>0 ? $user['battle']:$user['last_battle']).'" target="_blank">�����&raquo;</a><BR>';
	}
}
 ?>
<BR>
</td>
<TD  valign=top align=rigth>
<TABLE width=250 cellspacing=0 cellpadding=0><TR>
<TD valign=top width=250 nowrap><CENTER>
<?


if($STEP==1){



	if  ($nexten['id'] < _BOTSEPARATOR_ )
		{
		$nexten_eff=load_battle_eff_pre($nexten,$data_battle);
		}


	showtelo($nexten,$en_wearItems,$en_magicItems,$nexten_eff);

	if ($nexten['hidden']>0)
		{
		$_SESSION['mem_enemy']=$nexten['hidden'];//���������� ���� ������� ���� �������� �� ������
		}
		else
		{
		$_SESSION['mem_enemy']=$nexten['id'];//���������� ���� ������� ���� �������� �� ������
		}
	$_SESSION['was_target']=$nexten['id'];//������ ����
}else{

	if ($data_battle['type']==4 OR $data_battle['type']==5) {
		$a = array(6,16);
		echo "<img src='http://i.oldbk.com/i/im/",$a[mt_rand(0,1)],".gif'>";
	} elseif ($STEP > 1) {
		echo "<img src='http://i.oldbk.com/i/im/",mt_rand(1,34),".jpg'>";
	} elseif($exp[$user['id']] > 0) {    // ������������ � ����� � ����� �������� ���... ����� ������������ �� �������� ������ ������ ������.??????
		echo "<img src='http://i.oldbk.com/i/im/",mt_rand(113,115),".jpg'>";
	} else {
		echo "<img src='http://i.oldbk.com/i/im/",mt_rand(110,112),".jpg'>";
	}
   //random box

    	{
    	 include ('random_box.php');
    	 $rnd_i=mt_rand(0,count($rnd_mess)-1);

    	echo '<table width="98%" border="0" cellspacing="1" cellpadding="0">';
	echo '<tr>';
	echo '<td>';
   	echo '<br><div align=center><a>� ������ �� ��, ���...</a></div>';
    	echo "&nbsp;&nbsp;".$rnd_mess[$rnd_i];
	echo '</td> </tr></table>';


    	}
}



?>
</TD></TR>
</TABLE>

</TD></TR>
</TABLE>

</td></tr>
</TABLE>
<input type='hidden' id='txtblockzone' value='<? echo $DF;?>'/>
</FORM>

<DIV ID="oMenu" style="width:auto;position:absolute; border:1px solid #666; background-color:#CCC; display:none; "></DIV>

<TEXTAREA ID=holdtext STYLE="display:none;"></TEXTAREA>
<?
log_php_memory('end');

include "end_files.php";
?>
</BODY>
</HTML>
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
