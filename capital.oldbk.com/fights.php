#!/usr/bin/php
<?php
$VER_f='v.9.2.2 04/28/2017';

$lvlkof=0.01;
$EXP_TO_LOSE=0; //1- ��� / 0-����
$EXP_WIN=1; // 100%  ������� ����������
$attkof=0.1; // ��������� �� ���� �����
$attkritkof=0.1; // ��������� �� ���� ����� ��������
$kritblokkof=0.1; // ��������� �� ���� ����� �������� ����� ����

$kritkof=1.3; // ��������� �� ����
$uvorotkof=1.3; // �������� �� ����

$output_attack_magic_dem=0;
$input_attack_magic_dem=0;

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

$input_fix_cost_level=0;
$output_fix_cost_level=0;

$min_uron=1; // ����������� ���� ���� 10
// ����� ������� ����� ������ ��� ������� ������
//������� ����� ��� ������ ������ + ��������� (��������) v.4.1a +add set time out by clons+add Bs +add ClanWar
    // ���������� mysql, ���������� �������
	ini_set('display_errors','On');

    include "/www/capitalcity.oldbk.com/connect.php";
    include "/www/capitalcity.oldbk.com/functions.php";
    include "/www/capitalcity.oldbk.com/functions.zayavka.php";
    include "/www/capitalcity.oldbk.com/fsystem.php";
    include "/www/capitalcity.oldbk.com/fuc1.php";





//�������������� ������� ������ � ��� ����
function make_hil_battle($telo,$cure_value)
{
 if (($telo[hp]>0) and ($cure_value>0) and ($telo[hp] < $telo[maxhp] ) )
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
 		mysql_query("UPDATE `users` SET   `hp` = `hp` + '{$add_hp}'    WHERE `id` = '{$telo[id]}' and hp>0 ");
 		if (mysql_affected_rows()>0)
		{
	
		if (( $telo['hidden'] > 0 ) and ( $telo['hiddenlog'] =='' ) ) { $telo['sex']==1 ; }
		elseif (( $telo['hidden'] > 0 ) and ( $telo['hiddenlog'] !='' ) )
		{
		 $ftelo = load_perevopl($telo);  
		 $telo[sex]=$ftelo[sex];
		}

		if (($telo['hidden'] > 0) and ( $telo['hiddenlog'] =='' ))
		{
			addlog($telo['battle'],"!:H:".time().':'.nick_new_in_battle($telo).":".(($telo[sex]*100)+1).":".(($telo[sex]*100)+1)."::::::".$cure_value."|??:[??/??]\n");		
			
		} else {
			addlog($telo['battle'],"!:H:".time().':'.nick_new_in_battle($telo).":".(($telo[sex]*100)+1).":".(($telo[sex]*100)+1)."::::::".$cure_value.":[".($hp)."/".$telo['maxhp']."]\n");		
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




addchp ('<font color=red>��������!</font> start Cron fights '.$VER_f.' ('.CITY_DOMEN.') ','{[]}Bred{[]}',-1,-1);
addchp ('<font color=red>��������!</font> start Cron fights '.$VER_f.' ('.CITY_DOMEN.') ','{[]}����{[]}',-1,-1);
addchp ('<font color=red>��������!</font> start Cron fights '.$VER_f.' ('.CITY_DOMEN.') ','{[]}�������{[]}',-1,-1);
	// ���������� ������� ������� ��������� ���
	$time_zayavka = 0;
	$time_status_fights = 0;
	// �������� �������� � ��������
	$zayavka = 10;
	$status_fights = 10;

	// ������� �������� ������ ��� �����
function check_zayavka($time_now) 
	{
	//����������� ��� ����������� ��� ������
	//3,4,5- �������,������,�����
	//�� ������� ��� ��������� ��� �������
	$get_all_zay=mysql_query("select * from zayavka where ((`start`<={$time_now}  or ((substrCount(team1,';')>=t1c) AND (substrCount(team2,';')>=t2c)) or (level=5 and zcount>=t1c)  )  AND level in (3,4,5,7) ) OR (`start`<={$time_now} and level=6) ");
	if (mysql_num_rows($get_all_zay))
		  {
			while ( $row = mysql_fetch_array($get_all_zay) ) 
			{
				battlestart( "CHAOS", $row, $row[level] );

			}
		  }
	}


/// ������� ����������� ��������� ����
function check_status_fights()
{
		// �������� ������ ������� ���� ������� ���� ������ ����
		$time_shift = time()+3600; // 60*60 = 3600
		//7200 - 2 ���� �������  � �����������
		//�������� ��� ��������� � ��� � ���� ������
		$q = "SELECT * FROM battle WHERE ( CHAOS=-1 OR CHAOS=2 OR status_flag>0 ) and win='3' and status=0 "; // ������ 0 - �� � ����������

		$bdq = mysql_query("$q"); // win=3 ��� ������ ������������� ���.

		while($bd = mysql_fetch_array($bdq)) {

		if (($bd['type']==4) OR ($bd['type']==5))
		{
		//���  ������� - ������ ���� ����� ���� ���� ������� �� ������� 21/12/2013
		 $do_auto=1; 
		 $auto_flag=-1;
		}
		else		
		if (($bd['type']==40) OR ($bd['type']==41) or ($bd['type']==100) or ($bd['type']==101) )
		{
		//��� �������������� ������ ������ �������� ������� �� �������
		 $do_auto=1; 
		 $auto_flag=-1;
		}
		else	
		 if (($bd['status_flag']!=10) and ($bd['type']!=7) )
		 {
				// ������ ������� �������� ������� � ���� ���.
				$cnt = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM users WHERE battle='".$bd['id']."'"));
				$countall = $cnt[0];
				$current_status = $bd['status_flag'];
				$auto_flag=$bd['CHAOS'];
				$new_status=0;
				$mk_blood='';
				
				if (!($bd['type'] == 3 && $bd['CHAOS'] > 0)) {
					if ($countall >= 666) 
					{
						$new_status=4;
						 if ($bd['blood']==0)
						 	{
							$mk_blood=' , blood=1 ';
							}
					}
					else 
					if ($countall >= 200) 
					{
						$new_status=3;
					} 
					elseif ($countall >= 150) 
					{
						$new_status=2;
					} 
					elseif ($countall >= 100) 
					{
						$new_status=1;
					} 
					else 
					{
						$new_status=0;
					}
				}
				

				// ����������� ����� ������ ���� �� ��������� � ���� ���� �������� ��������
				if(($new_status != $current_status) && $new_status > $current_status)
				{
					
				      if ($bd['coment']!='<b>��� � �������</b>')
				      	{
			      		$newtimeout=', `timeout`=3 '; //����� ������ 3 ���. �����
			      		}

					mysql_query("UPDATE battle SET status_flag='".$new_status."'  ".$newtimeout."  ".$mk_blood."  WHERE id='".$bd['id']."'");

					  // ���� ����� ���� ����� ��� ����������
					  // �� ��������� - ����� ��������
					  $t=time();
					  mysql_query("UPDATE battle_fd SET time_blow='{$t}' WHERE battle='".$bd['id']."'");


				}
				else
				 {
				 $do_auto=1;
				 }
		} else
		{

		// fix 1/03/2012
		 // ���� � ������� ������
		   if ((($bd['status_flag']==10) and ($bd['timeout']!=3)) and ($bd['coment']!='<b>��� � �������</b>') ) 
		   		{
		   		//���� ������� ���� � ���� �� 3 ������ �� ������ ��� �� ��� ������
		   		mysql_query("UPDATE battle SET timeout=3 WHERE id='".$bd['id']."'");
		   		}
		   		
		 $do_auto=1;	
		 $auto_flag=2;
		}	 
				
				if ($do_auto==1)
				{
					
				// ���� ������ �� ���������
				 /// � ������� ������ ������ 0, ��
				   if ( ($current_status > 0) or ($auto_flag==2) or ($auto_flag==-1) )
				     {
				     		
				     $need_time=($bd['timeout']*60)-60;
				     $sqll="select fd.id, fd.battle, fd.owner, fd.razmen_to, fd.razmen_from, fd.attack, fd.attack2, fd.block, fd.time_blow, fd.lab, usr1.id as usr1id, usr2.id as usr2id from battle_fd as fd
					 inner JOIN users as usr1 on usr1.id=fd.razmen_to
					  inner JOIN users as usr2 on usr2.id=fd.razmen_from
						where fd.battle=".$bd['id']."
						 and
						 (usr1.hp > 0) and (usr2.hp > 0)
						 and
						((usr1.level - usr2.level) = 0 or
						 (usr1.level - usr2.level) = 1 or
						 (usr1.level - usr2.level) = -1 or
						 ( usr1.in_tower=3 AND usr2.in_tower=3)
						 )
						and (fd.time_blow+".$need_time.") <= UNIX_TIMESTAMP() LIMIT 1 ";
				
					$sqlusers=mysql_query($sqll);

				     //���� ������� ������ ������� ������� ����� ���� ������ �� 60 ��� �� �����
				     // � ���� +/- 1 ������� - �� � �������������� � ���� ��� $bd['id']
				     /// ��� ���� ����� ����� � ������� ���������� ������� � ���� ���
					     while($users = mysql_fetch_array($sqlusers))
					     {
					     		
					     // ��������
					     // ���� ����� �� ���� ��� ����������
					     // � �� ���� ��� ��������
					     // ��������� ��� ������� ������
					     ///��������� ������ �������� ���� ������� ��� � fbattle
					     // ������ ��� ������ ����� ����
					    // echo "����� �� ";

					//������ ���������������� ������ ����� �.�. �� ��� ��� ���������
					  $user=mysql_fetch_array(mysql_query("select * from users where id='{$users[usr1id]}' ;"));
					
					  
					  $my_wearItems=load_mass_items_by_id($user); // ��������
					  $my_magicItems=$my_wearItems[incmagic]; // ���������� �����
					  
					  $data_battle=mysql_fetch_array(mysql_query("select * from battle where id='{$bd[id]}' ")); //����������� ���������� ������
					  
					  $BSTAT[win]=$data_battle[win];


					 $real_enemy=mysql_fetch_array(mysql_query("select * from users where id='{$users[usr2id]}' ;"));
				
				          
				        
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 {
	//  $_POST[attack]=(int)($_POST[attack]);
	//  $_POST[defend]=(int)($_POST[defend]);
	//  $_POST[enemy]=(int)($_POST[enemy]);
// $attack=mt_rand(1,4);
 $attack=0;
// $defend=mt_rand(1,4);
 $defend=0; //��������� ������
 
$output_attack_magic_dem=0;
$input_attack_magic_dem=0;

$input_fix_cost_level=0;
$output_fix_cost_level=0;
 
 	    // 1. �������� ������� �� ��� ���� ���� ����� ���� � ���� �� � �� ��� �� ����
	     $TABLE='users';
	     $HID='id';

	if (($real_enemy[id] > 0) AND ($real_enemy[hp]>0) AND ($user[id] > 0) AND ($user[hp]>0) AND ($data_battle[win]==3) AND ($data_battle[status]==0) AND ($data_battle[t1_dead]=='')  ) // �������� ��� ��� ���� � ��� ����
	{
	//echo "f 8 <br>";
	/// �� ��������� ���� � �����
	// 2. ��������� ���� ������ �� ����� � ���� ��������
	
     //��������� ����� ������� �� ������� �����
    mysql_query("INSERT INTO `battle_user_time` SET `battle`='{$data_battle[id]}',`owner`='{$user[id]}',`timer{$real_enemy[battle_t]}`='".time()."' ON DUPLICATE KEY UPDATE `timer{$real_enemy[battle_t]}`='".time()."'");	
	$my_enemy_do[id]=$users[0];
	$my_enemy_do[battle]=$users[1];
	$my_enemy_do[owner]=$users[2];
	$my_enemy_do[razmen_to]=$users[3];
	$my_enemy_do[razmen_from]=$users[4];
	$my_enemy_do[attack]=$users[5];
	$my_enemy_do[attack2]=$users[6];	
	$my_enemy_do[block]=$users[7];
	$my_enemy_do[time_blow]=$users[8];
	$my_enemy_do[lab]=$users[9];


	      	 // �� -  ����� ���� � �������� ������� ����
	      	 //�������� ������� / ��_��� / ������ ��� ������ ������� / �� ���� ��� ������� / ���� ����� ������� / ���� ������ ������� /....
	      	 // ������ � ����� ����� ������ ����� � �������
		// ������� ����� "��������������" - ���������� - ��������� ��� ���� - ���������� - ���� ���� ��� - � �������� ���� �� ����
		// �������� � ������ ������ �����
		////////////////////////////////////////////////////
		//��������� ��� ������ ��� ����� ����� � �������� � ������ ����� ���� ��������
	$en_wearItems=load_mass_items_by_id($real_enemy); // ��������
	
	
	//��������� ������ ������ ��� � ����� ���� ���� �� ����
			if ($user[id] < _BOTSEPARATOR_ )
			{
				$user_eff=load_battle_eff($user,$data_battle);
			}
			if ($real_enemy[id] < _BOTSEPARATOR_ )
			{
			$real_enemy_eff=load_battle_eff($real_enemy,$data_battle);
			}
	
		//////////////////////////////////////////////////
		/// 1. ����� / ��� ��� - ��� ��������� - ���� ���� - ��� ���� -������ �����
		
		if ($my_enemy_do['attack2']>0)
			{
			$my_enemy_do_attack=array($my_enemy_do['attack'],$my_enemy_do['attack2']);
			}
			else
			{
			$my_enemy_do_attack=$my_enemy_do['attack'];
			}
		
		
		$input_attack=do_attack_in($data_battle,$user,$real_enemy,$my_enemy_do_attack,$defend,$my_wearItems,$en_wearItems,$user_eff,$real_enemy_eff,'from_fights');

		/// 2. ������ / ��� ��������� / ��� ��� / ���� ���� - ��� ���� - ���������� �����

		//��������� ��������������
		$my_wearItems[min_u]=$my_wearItems[min_u]*0.5; // 50% min ���� ������������ �����
		$my_wearItems[max_u]=$my_wearItems[max_u]*0.5; //50%  max ����
		
		$my_wearItems[min_u2]=$my_wearItems[min_u2]*0.5; // 50% min ���� ������������ �����
		$my_wearItems[max_u2]=$my_wearItems[max_u2]*0.5; //50%  max ����
		
		// ����� �������� ����� ����� ���������


		$output_attack=do_attack_out($data_battle,$user,$real_enemy,$attack,$my_enemy_do[block],$my_wearItems,$en_wearItems,$user_eff,$real_enemy_eff,'from_fights');
	

		if ( trim($input_attack[text])!='' ) {	$input_attack[text]=$input_attack[text].":1" ; }
		if ( trim($output_attack[text]) !='' ) { $output_attack[text]=$output_attack[text].":1"; }


		///2.1 - ��� ������ �������� - ��� �������� � ������� SQL
		//
		//� ������� ������ �������� ���������� � ������ ���������� ����� �������
		mysql_query("INSERT INTO `battle_user_time` SET `battle`='{$data_battle[id]}',`owner`='{$real_enemy[id]}',`timer{$user[battle_t]}`='".time()."' ON DUPLICATE KEY UPDATE `timer{$user[battle_t]}`='".time()."'");			 

				$HH=(int)(date("H",time()));
			  	 if (($HH>=9) and ($HH<21)) 
				{
				//echo "����";
				//���� ���������
				if ($real_enemy[pasbaf]==852)
				 	{
			  		$trvkrit=-10;//10%
			  		}
			  	//	���� �������
			  		else if ($real_enemy[pasbaf]==861)
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
				if ($user[pasbaf]==840)
			  		{
			  		$trvkrit=10;//+10%
			  		}
			  		else
			  		{
			  		$trvkrit=0;
			  		}
				}

	/*
	if ($data_battle[t3]!='')
		{
		$rez=mysql_fetch_array(mysql_query("select do_razmen({$data_battle[id]},{$user[id]},{$user[battle_t]},{$real_enemy[id]},{$real_enemy[battle_t]},{$output_attack[dem]},{$input_attack[dem]},'{$output_attack[type]}','{$input_attack[type]}','{$data_battle[type]}','{$trvkrit}') as ret;"));		
		}
		else
		{
		$rez=mysql_fetch_array(mysql_query("select do_razmen2({$data_battle[id]},{$user[id]},{$user[battle_t]},{$real_enemy[id]},{$real_enemy[battle_t]},{$output_attack[dem]},{$input_attack[dem]},'{$output_attack[type]}','{$input_attack[type]}','{$data_battle[type]}','{$trvkrit}') as ret;"));
		}
	*/	

	if (($user['id']==14897) OR ($real_enemy['id']==14897) )
		{
		addchp('<font color=red>��������!</font> ����� in fights 1'.$user['login'].'  VS '.$real_enemy['login'].' : DEM='.$input_attack['dem'],'{[]}Bred{[]}',-1,0);	
		}

		  $rez[0]=do_razmen_to_telo($data_battle,$user,$user['battle_t'],$real_enemy,$real_enemy['battle_t'],$output_attack['dem'],($input_attack['dem']-=$input_attack['stone']),$output_attack['type'],$input_attack['type'],$data_battle['type'],$trvkrit);				
	
		if (($user['id']==14897) OR ($real_enemy['id']==14897) )
		{
		addchp('<font color=red>��������!</font> ����� in fights 2'.$user['login'].'  VS '.$real_enemy['login'].' : DEM='.$input_attack['dem'],'{[]}Bred{[]}',-1,0);	
		}
	
	$USER_MANA=true;
	$ENEMY_MANA=true;
	
	if ($user['mana']<=0)
	{
	$USER_MANA=false;
	}
	
	if ($real_enemy['mana']<=0)
	{
	$ENEMY_MANA=false;
	}	

if ($data_battle[nomagic]==0)
{
////////////////////////////		//////////////////////////// //////////////////////////// //////////////////////////// //////////////////////////// //////////////////////////// ////////////////////////////
//930 ������ ���� - ���� �� �����
if ((is_array($real_enemy_eff[930]) && $real_enemy['in_tower'] == 0) and ($input_attack[dem]==0) and ($ENEMY_MANA==true)  )// �� � ��
		{
		//�� ���� ����� - ������ ����� ��� ������� ������� ���������
			mysql_query("UPDATE `effects` SET add_info='0'  where owner='{$real_enemy[id]}' AND type=930");
		}
		else
//930 ������ ����
if ((is_array($real_enemy_eff[930]) && $real_enemy['in_tower'] == 0) and ($input_attack[dem]>0) and ($ENEMY_MANA==true)  )// �� � ��
				{
				//������ +1 ���� �� ������ 4 ����
				if ($real_enemy_eff[930]['add_info']<4)
					{
					mysql_query("UPDATE `effects` SET add_info=add_info+1  where owner='{$real_enemy[id]}' AND type=930");
					}
				
				$prhp=$user[hp]-$input_attack[dem];
				
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
					
					if ($baf_dem_min>1000) {$baf_dem_min=1000; }				
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }
					
					if ($baf_dem_max<1) {$baf_dem_max=1;}
					if ($baf_dem_min<1) {$baf_dem_min=1;}
					
					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }					
					
					$baf_dem_baza=mt_rand($baf_dem_min,$baf_dem_max); //100% 
					
					if (!(in_array(4,get_mag_stih($real_enemy,$real_enemy_eff)))) { $baf_dem_baza=(int)($baf_dem_baza*0.5); } // -50% ���� ���� ������� �� ������
					
					$koluda=(int)($real_enemy_eff[930]['add_info']); // ��� �������� ������� ������ ������� ������
					
					$demag[0][0]=1; //��� ������ ������� ��������� ������� ���� ���� 100% �� ����������
					$demag[1][0]=0.5; $demag[1][1]=0.5; //��� ������ (������ ���� �����) ������� ������� 50% � �������� +- ����� 50%
					$demag[2][0]=0.5; $demag[2][1]=0.25; $demag[2][2]=0.25; //��� ������� (������ ����� ��) ������� ������� 50% ������� �������� 25% �������� 25%
					$demag[3][0]=0.5; $demag[3][1]=0.1;   $demag[3][2]=0.2; $demag[4][3]=0.3; //��� ��������� (������) ������� 50% ������� 30% �������� 20% ���������� 10%
					$demag[4][0]=0.4; $demag[4][1]=0.1;   $demag[4][2]=0.1; $demag[4][3]=0.2;  $demag[4][4]=0.3; //	��� ����� ����� (������) ������� 40% ������� 30% �������� 20% ����������� � ������ �� 10%
					
					$demaga=$demag[$koluda]; //����������  ������ ����� ��� ���������� ������� ����������
					
					
					$baf_dem=round($baf_dem_baza*$demaga[0]); // [0] = ���� ��� ������ ������

					if (is_array($user_eff[557])) $baf_dem = round($baf_dem * $user_eff[557]['add_info']); // ������� 30% ��� ������ �� �����
				
					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}
				
					if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$user[id]}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$user[id]}' and hp>0 LIMIT 1; ");
						}
						
					if (mysql_affected_rows()>0)
						{
						$uron_str=$baf_dem;
						//hidden �������������
						if (($user[hidden] > 0) and ($user[hiddenlog] ==''))
 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$user[maxhp].']';    }
						$input_attack[text].="\n!:L:".time().":".nick_new_in_battle($user).":".(220+$user[sex])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;
						
						$input_attack_magic_dem=$baf_dem;//����� � ��� ����
						
						if ($prhp<=0)
							{
							$input_attack[text].="\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user);
				
								if (!isset($real_enemy[id_user]) AND ($user['level'] >= ($real_enemy['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
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
								elseif (!isset($real_enemy[id_user]) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
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
							 for ($io=0;$io<count($demaga);$io++)
							 {
										 if (count($memorize)>0)
										{
										$filt=" and users.`id` not in  (".implode(",",$memorize).")  " ; //��������� ��� �� ��� ������ �����
										}
						 		$demaga[$io]=round($baf_dem_baza*$demaga[$io]);	 //���� ����� 
							 	$pesh=mysql_fetch_array(mysql_query("select users.*,effects.type,effects.add_info from users LEFT JOIN effects ON users.id = effects.owner and effects.type = 557 where users.battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and (level>=".($real_enemy['level']-1)." and level<=".($real_enemy['level']+1).")   and hp>'{$demaga[$io]}' ".$filt." order by Rand() limit 1 ;"));
							 	if ($pesh['id']>0)
							 		{

									if ($pesh['type'] == 557) $demaga[$io] = round($demaga[$io] * $pesh['add_info']); // 30% ������ �� �����

							 		mysql_query("UPDATE users set hp=hp-'{$demaga[$io]}' where id='{$pesh['id']}' and hp>'{$demaga[$io]}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
									 				$memorize[]=$pesh['id']; // ���������� ��
			 										$uron_str=$demaga[$io];
			 										$pesh['hp']-=$demaga[$io];
													if (($pesh[hidden] > 0) and ($pesh[hiddenlog] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$demaga[$io]."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$input_attack[text].="\n!:L:".time().":".nick_new_in_battle($pesh).":".(220+$pesh['sex'])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;
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
if ((is_array($real_enemy_eff[920]) && $real_enemy['in_tower'] == 0) and ($input_attack[dem]>0) and ($ENEMY_MANA==true) )// �� � ��
				{
				$prhp=$user[hp]-$input_attack[dem];
				
				//������� 
				if (($real_enemy_eff[920]['lastup']>0) AND ($real_enemy['mearth']<1))
					{
					$real_enemy['mearth']=(int)($real_enemy_eff[920]['lastup']);
					}
				
				if (($prhp>0) AND ($real_enemy['mearth']>0))
				{ 
					//���� ���� ����� � � ���� ���
					if ($real_enemy['mearth']>100) { $real_enemy['mearth']=100; }
					
					$real_enemy_mudra=round($real_enemy['mudra']);
					
					if ($real_enemy_mudra>50) {$real_enemy_mudra=50;}

					$baf_dem_min=(int)($real_enemy_mudra/5) ; //5 �������� - 1 ����������� ����
					$baf_dem_max=(int)($real_enemy['mearth'])  ; //������ ������ = ������������� �����
					
					if ($baf_dem_min>1000) {$baf_dem_min=1000; }				
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }
					
					if ($baf_dem_min<1) {$baf_dem_min=1; }
					if ($baf_dem_max<1) {$baf_dem_max=1;}
					

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }					
					
					$baf_dem=mt_rand($baf_dem_min,$baf_dem_max); // ����
					
					if (!(in_array(2,get_mag_stih($real_enemy,$real_enemy_eff)))) { $baf_dem=(int)($baf_dem*0.5); } // -50% ���� ���� ������� �� ������
					$baf_dem=(int)($baf_dem*0.5);
					if ($baf_dem < 1) $baf_dem = 1;


					if (is_array($user_eff[557])) $baf_dem = round($baf_dem * $user_eff[557]['add_info']); // ������� 30% ��� ������ �� �����
					
					/* ������ �������	
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
													if (($pesh[hidden] > 0) and ($pesh[hiddenlog] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$mass_magic_data.=nick_new_in_battle($pesh)."#".(220+$pesh['sex'])."#".$uron_str."#".$txtdm."#";
													$input_attack_magic_dem+=$baf_dem;//����� � ��� ���� - ��� �������� �����
								 				}
							 		}
							 }
							 
							$input_attack[text].="\n!:J:".time().":".$mass_magic_data.":".$all_render."::".nick_new_in_battle($real_enemy).":::::".$uron_str_all.":";
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
								$owners_magp[strval($puser['add_info'])][]=$puser['owner']; // �� �� ������� ������
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
						foreach ($owners_magp as $protect => $powners)
							{
								$pdmage=round($baf_dem*$protect);
								$all_pip=0;
								mysql_query_100("UPDATE users set hp=hp-'".$pdmage."' where battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and hp>'".$pdmage."' and id in (".implode(",",$powners).") ");
								$all_pip = mysql_affected_rows();	
								if ($all_pip>0)
									{
									$all_render_porotect[]="\n!:G:".time().":".$pdmage.":".$all_pip.":".$user['battle_t'].":".nick_new_in_battle($real_enemy).":::::".$pdmage*$all_pip.":";
									$total_summ_all_pip+=$pdmage*$all_pip;
									}
							}
						}	

				 		if ($all_render1 >0 || count($all_render_porotect)>0 ) 
				 		{
							if($all_render1 >0) {
								$input_attack['text'].="\n!:G:".time().":".$baf_dem.":".$all_render1.":".$user['battle_t'].":".nick_new_in_battle($real_enemy).":::::".$baf_dem*$all_render1.":";
							}
						
							if (count($all_render_porotect)>0)
							{
								foreach ($all_render_porotect as $k => $render)
									{
									$input_attack['text'].=$render;
									}
							}

							$uron_str_all = round(($all_render1*$baf_dem)+($pdmage*$all_pip));

							//������ ����
							$input_fix_cost_level=1; // ���� ��� ����� ��� �����
							$input_attack_magic_dem+=$uron_str_all;//����� � ��� ���� - ��� �������� �����
			 			}
			 			set_telo_mana($real_enemy,$input_attack_magic_dem);
			 		}
							
				}
			}
		else
//������ ������� ������ ������ - ��� ������ ����������
			if ((is_array($real_enemy_eff[130]) && $real_enemy['in_tower'] == 0) and ($input_attack[dem]>0) and ($ENEMY_MANA==true) )// �� � ��
				{
				$prhp=$user[hp]-$input_attack[dem];
				
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
					
					if ($real_enemy_mudra>50) {$real_enemy_mudra=50; }
					
					$baf_dem_min=round(($real_enemy_mudra)+$real_enemy['mair']);
					
					$vl=explode(":",$real_enemy_eff[130]['add_info']);
					$real_enemy_eff[130]['add_info']=$vl[1];
					
					$baf_dem_max=((int)($real_enemy_eff[130]['add_info'])*$real_enemy['mair'])  ;
					
					if ($baf_dem_min>1000) {$baf_dem_min=1000; }				
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }					
					
					$baf_dem_baza=mt_rand($baf_dem_min,$baf_dem_max);
					
					if (!(in_array(3,get_mag_stih($real_enemy,$real_enemy_eff)))) { $baf_dem_baza=(int)($baf_dem_baza*0.5); } // -50% ���� ���� ������� �� ������
					
					$baf_dem=round($baf_dem_baza*0.4); //�� ��� �������� ��������� � ������� � ����� �������� 40% ����� 
					
					$baf_dem_f[1]=round($baf_dem_baza*0.3);//���� ������ �������� ������ +- ����� �������� 30% 20% � 10% ������������� (����� 100%)
					$baf_dem_f[2]=round($baf_dem_baza*0.2);
					$baf_dem_f[3]=round($baf_dem_baza*0.1);
					
					if (is_array($user_eff[557])) $baf_dem = round($baf_dem * $user_eff[557]['add_info']); // ������� 30% ��� ������ �� �����					
				
					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}
				
					if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$user[id]}' and hp>0 LIMIT 1; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$user[id]}' and hp>0 LIMIT 1; ");
						}
						
					if (mysql_affected_rows()>0)
						{
						$uron_str=$baf_dem;
						//hidden �������������
						if (($user[hidden] > 0) and ($user[hiddenlog] ==''))
 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$user[maxhp].']';    }
						$input_attack[text].="\n!:Z:".time().":".nick_new_in_battle($user).":".(220+$user[sex])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;
						
						$input_attack_magic_dem=$baf_dem;//����� � ��� ����
						
						if ($prhp<=0)
							{
							$input_attack[text].="\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user);
				
								if (!isset($real_enemy[id_user]) AND ($user['level'] >= ($real_enemy['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
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
								elseif (!isset($real_enemy[id_user]) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
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
										
							 	$pesh=mysql_fetch_array(mysql_query("select users.*,effects.type,effects.add_info from users LEFT JOIN effects ON users.id = effects.owner and effects.type = 557 where users.battle='{$data_battle['id']}' and battle_t='{$user['battle_t']}' and hp>'{$baf_dem_f[$io]}' ".$filt." order by Rand() limit 1 ;"));
							 	if ($pesh['id']>0)
							 		{

									if ($pesh['type'] == 557) $baf_dem_f[$io] = round($baf_dem_f[$io] * $pesh['add_info']); // 30% ������ �� �����

							 		mysql_query("UPDATE users set hp=hp-'{$baf_dem_f[$io]}' where id='{$pesh['id']}' and hp>'{$baf_dem_f[$io]}'  ");
								 		if (mysql_affected_rows()>0)
								 				{
									 				$memorize[]=$pesh['id']; // ���������� ��
			 										$uron_str=$baf_dem_f[$io];
			 										$pesh['hp']-=$baf_dem_f[$io];
													if (($pesh[hidden] > 0) and ($pesh[hiddenlog] ==''))
							 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem_f[$io]."|??";   } else  {  $txtdm='['.$pesh['hp'].'/'.$pesh['maxhp'].']';    }
													$input_attack[text].="\n!:Z:".time().":".nick_new_in_battle($pesh).":".(220+$pesh['sex'])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;
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
	///��� �� ����� - ������ ������ �� ����� �.�.  ����� � ���� ����� 0
	//����� �� �����- ��� ������ ����������
			if ((is_array($real_enemy_eff[150]) && $real_enemy['in_tower'] == 0) and ($input_attack[dem]>0) and ($ENEMY_MANA==true)  )// �� � ��
				{
				$prhp=$user[hp]-$input_attack[dem];
				
				//������� 
				if (($real_enemy_eff[150]['lastup']>0) AND ($real_enemy['mfire']<3))
					{
					$real_enemy['mfire']=(int)($real_enemy_eff[150]['lastup']);
					}
				
				if (($prhp>0) AND ($real_enemy[mfire]>0))
				{ 
					//���� ���� ����� � � ���� ���
					if ($real_enemy[mfire]>100) { $real_enemy[mfire]=100; }
					
					$real_enemy_mudra=$real_enemy[mudra];
					
					if ($real_enemy_mudra>50) {$real_enemy_mudra=50; }
					
					$baf_dem_min=round(($real_enemy_mudra)+$real_enemy[mfire]);
					
					$vl=explode(":",$real_enemy_eff[150]['add_info']);
					$real_enemy_eff[150]['add_info']=$vl[1];					
					
					$baf_dem_max=((int)($real_enemy_eff[150][add_info])*$real_enemy[mfire])  ;
					
					if ($baf_dem_min>1000) {$baf_dem_min=1000; }				
					if ($baf_dem_max>1000) {$baf_dem_max=1000; }
					
					if ($baf_dem_min<1) {$baf_dem_min=1; }				
					if ($baf_dem_max<1) {$baf_dem_max=1; }					

					if ($baf_dem_min>$baf_dem_max) {$baf_dem_min=$baf_dem_max; }					
					
					$baf_dem=mt_rand($baf_dem_min,$baf_dem_max);
					if (!(in_array(1,get_mag_stih($real_enemy,$real_enemy_eff)))) { $baf_dem=(int)($baf_dem*0.5) ;  } // -50% ���� ���� ������� �� ������					

					if (is_array($user_eff[557])) $baf_dem = round($baf_dem * $user_eff[557]['add_info']); // ������� 30% ��� ������ �� �����
				
					if ($baf_dem<$prhp) {$prhp-=$baf_dem;}else {$prhp=0;}
				
					if ($prhp>0)
						{
						mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$user[id]}' and hp>0 ; ");
						}
						else
						{
						mysql_query("UPDATE users set hp=0 where id='{$user[id]}' and hp>0 ; ");
						}
						
					if (mysql_affected_rows()>0)
						{
						
						$uron_str=$baf_dem;
						//hidden �������������
						if (($user[hidden] > 0) and ($user[hiddenlog] ==''))
 		               			{   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$user[maxhp].']';    }
						$input_attack[text].="\n!:Y:".time().":".nick_new_in_battle($user).":".(220+$user[sex])."::".nick_new_in_battle($real_enemy).":::::".$uron_str.":".$txtdm;
						
						if ($prhp<=0)
							{
							$input_attack[text].="\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user);
							
							if (!isset($real_enemy[id_user]) AND ($user['level'] >= ($real_enemy['level']-1)) AND ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61 ) )
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
								elseif (!isset($real_enemy[id_user]) and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
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
	}//$data_battle[nomagic]
	



	$STING='REZ'.$rez[0];
		switch ($STING)
	     {
		case "REZ11":
		{
		//echo "11";
		// ��� ����� �������� � ���
		addlog($data_battle[id],$input_attack[text]."\n".$output_attack[text]."\n");

		//�������� � ������
		$user[hp]-=$input_attack[dem];
		// �������� � ������
		if ($user[battle_t]==1) 
			{ 
			$boec_t1[$user[id]][hp]-=$input_attack[dem];
			} 
			elseif ($user[battle_t]==2) 
			{
			$boec_t2[$user[id]][hp]-=$input_attack[dem] ;
			}
			elseif ($user[battle_t]==3) 
			{
			$boec_t3[$user[id]][hp]-=$input_attack[dem] ;
			}			
			
		if ($real_enemy[battle_t]==1) 
			{$boec_t1[$real_enemy[id]][hp]-=$output_attack[dem];
			} 
			elseif ($real_enemy[battle_t]==2) 
			 {$boec_t2[$real_enemy[id]][hp]-=$output_attack[dem] ;}
			elseif ($real_enemy[battle_t]==3) 
			 {$boec_t3[$real_enemy[id]][hp]-=$output_attack[dem] ;}			 
			 
/////////////// ������������ - ����������� �������� ���� ������ ���������� - � ����� �� ���� ����� ����
			if (mt_rand(1,10)==5) // ������� ������������
			{
		if ($battle_data['type']==20)
						{
						addlog($data_battle[id],get_comment_fifa()."\n"); // ����������� ��� ����������
						}
						else
						{
						addlog($data_battle[id],get_comment()."\n"); // ����������� ������
						}
			}
		}
		break;

		case "REZ01":
		 {
		// echo "01";
		
		addlog($data_battle[id],$input_attack[text]."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n");

 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($input_attack[type]=='krit') OR ($input_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$user[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
	 		addlog($data_battle[id],"!:T:".time().":".nick_new_in_battle($user).":".$user[sex].":".$eff[name]."\n");
	 		 }
 		 	}

		//�������� � ������
		$user[hp]=0;
		$STEP = 4;
		// �������� � ������
		if ($user[battle_t]==1) {unset($boec_t1[$user[id]]);} 
		elseif ($user[battle_t]==2)
		 {unset($boec_t2[$user[id]]);}
		elseif ($user[battle_t]==3)
		 {unset($boec_t3[$user[id]]);}

		}
		break;


		case "REZ10":
		 {
 		// echo "10";
		 //  ��������

		addlog($data_battle[id],$input_attack[text]."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n");		

 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($output_attack[type]=='krit') OR ($output_attack[type]=='krita'))
 		 	{
 		 	$sexi[0]='�';$sexi[1]='';
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$real_enemy[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
	 		addlog($data_battle[id],"!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy[sex].":".$eff[name]."\n");	 		
	 			}
 		 	}


		//�������� � ������ /
		$user[hp]-=$input_attack[dem];
		// �������� � ������
		if ($user[battle_t]==1) {$boec_t1[$user[id]][hp]-=$input_attack[dem];} 
		elseif ($user[battle_t]==2)
		 {$boec_t2[$user[id]][hp]-=$input_attack[dem] ;}
		elseif ($user[battle_t]==3)
		 {$boec_t3[$user[id]][hp]-=$input_attack[dem] ;}

		 
		// ������������ �����
		if ($real_enemy[battle_t]==1) {unset($boec_t1[$real_enemy[id]]);} 
		elseif ($real_enemy[battle_t]==2)
		 {unset($boec_t2[$real_enemy[id]]) ;}
		elseif ($real_enemy[battle_t]==3)
		 {unset($boec_t3[$real_enemy[id]]) ;}		 
		 }
		break;


		case "REZ00":
		 {
 		// echo "00";
		 // �������� - �� ��� ���� ������

		addlog($data_battle[id],$input_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n");	
 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($input_attack[type]=='krit') OR ($input_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$user[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
			addlog($data_battle[id],"!:T:".time().":".nick_new_in_battle($user).":".$user[sex].":".$eff[name]."\n");
	 				}
 		 	}

 		addlog($data_battle[id],"!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n"); 		
 		
 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($output_attack[type]=='krit') OR ($output_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$real_enemy[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
			 		addlog($data_battle[id],"!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy[sex].":".$eff[name]."\n");
	 				}
 		 	}

		//�������� � ������
		$user[hp]=0;
		 $STEP = 4;
		// �������� � ������
		if ($user[battle_t]==1) {unset($boec_t1[$user[id]]);} 
		elseif ($user[battle_t]==2) {unset($boec_t2[$user[id]]);}
		elseif ($user[battle_t]==3) {unset($boec_t3[$user[id]]);}
		
		// ����
		if ($real_enemy[battle_t]==1) {unset($boec_t1[$real_enemy[id]]);} 
		elseif ($real_enemy[battle_t]==2) {unset($boec_t2[$real_enemy[id]]) ;}
		elseif ($real_enemy[battle_t]==3) {unset($boec_t3[$real_enemy[id]]) ;}		
		 }
		break;


		case "REZ1010":
		{
		// echo "1010";
		// ��������� ������ ���� ���������� ����� ������ ������� �����
		$fin_add_log=$input_attack[text]."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";		

 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($output_attack[type]=='krit') OR ($output_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$real_enemy[id]} and (type=11 OR type=12 OR type=13 OR type=14) ;"));
 		 	 if ($eff[id] > 0 ) {
	 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy[sex].":".$eff[name]."\n";	 				
	 				}
 		 	}


 		############################################
 		$win_team_hist='t'.$user[battle_t].'hist';
 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";		
		
 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
 		if (mysql_affected_rows()>0)
	 			{
	 			//���� ������ ������ �� �����
		 		addlog($data_battle[id],$fin_add_log);
		 		}
 		////////////////////////

		//��� ������ ���� ����� ��� = ������ ������� $user[battle_t];
		$BSTAT[win]=($user[battle_t]==3?4:$user[battle_t]);
 		############################################
		//�������� � ������ / ������ ����� �� ������� �.�. ��� �� ���� :)
		$user[hp]-=$input_attack[dem];
		// �������� � ������
		if ($user[battle_t]==1) {$boec_t1[$user[id]][hp]-=$input_attack[dem];} 
		elseif ($user[battle_t]==2) {$boec_t2[$user[id]][hp]-=$input_attack[dem] ;}
		elseif ($user[battle_t]==3) {$boec_t3[$user[id]][hp]-=$input_attack[dem] ;}
		
		if ($real_enemy[battle_t]==1) {unset($boec_t1[$real_enemy[id]]);} 
		elseif ($real_enemy[battle_t]==2) {unset($boec_t2[$real_enemy[id]]) ;}
		elseif ($real_enemy[battle_t]==3) {unset($boec_t3[$real_enemy[id]]) ;}
		$STEP = 5;
		}
		break;



		case "REZ0101":
		{
		// echo "0101";
		// ��������� ������ ���� ����� �� �� ����� ������ ���� �����
		$fin_add_log=$input_attack[text]."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";

 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($input_attack[type]=='krit') OR ($input_attack[type]=='krita'))
 		 	{

 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$user[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
	 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user[sex].":".$eff[name]."\n";
	 				}
 		 	}

 		############################################
 		$win_team_hist='t'.$real_enemy[battle_t].'hist';
 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";

			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////

		//��� ������ ���� ����� ��� = ������ ������� $real_enemy;
		$BSTAT[win]=($real_enemy[battle_t]==3?4:$real_enemy[battle_t]);
		
 		############################################
		//�������� � ������
		$user[hp]=0;
		// �������� � ������
		if ($user[battle_t]==1) {unset($boec_t1[$user[id]]);} 
		elseif ($user[battle_t]==2)	 {unset($boec_t2[$user[id]]);}
		elseif ($user[battle_t]==3)	 {unset($boec_t3[$user[id]]);}

		 $STEP = 5;
		}
		break;



		case "REZ0001":
		{
		// echo "0001";
		// ���� ����� ���������  � ���� ����� ������� ����� �������� �.�. �������� �����
		$fin_add_log=$input_attack[text]."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";		
		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($input_attack[type]=='krit') OR ($input_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$user[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
		 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user[sex].":".$eff[name]."\n";
	 				}
 		 	}

		$fin_add_log.="!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";
		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($output_attack[type]=='krit') OR ($output_attack[type]=='krita'))
 		 	{

 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$real_enemy[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
	 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy[sex].":".$eff[name]."\n";
	 				}
 		 	}

 		############################################
 		$win_team_hist='t'.$real_enemy[battle_t].'hist';
 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////

		//��� ������ ���� ����� ��� = ������ ������� $real_enemy;
		$BSTAT[win]=($real_enemy[battle_t]==3?4:$real_enemy[battle_t]);
 		############################################
		//�������� � ������
		$user[hp]=0;
		// �������� � ������
		if ($user[battle_t]==1) {unset($boec_t1[$user[id]]);} 
		elseif ($user[battle_t]==2) {unset($boec_t2[$user[id]]);}
		elseif ($user[battle_t]==3) {unset($boec_t2[$user[id]]);}		

		// ����� �� ������� �.�. ������
		 $STEP = 5;
		}
		break;



		case "REZ0010":
		{
		// echo "0010";
		// ���� ����� � ���� ����� ���������  ������� ����� �������� �.�. �������� �����
		$fin_add_log=$input_attack[text]."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";
 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($input_attack[type]=='krit') OR ($input_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$user[id]} and (type=11 OR type=12 OR type=13 OR type=14) ;"));
 		 	 if ($eff[id] > 0 ) {
	 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user[sex].":".$eff[name]."\n";
	 				}
 		 	}

 		$fin_add_log.="!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";
 		// ���� ���� ������� ��������� ���� ��� ���� ����� ���� - �������� ��������� �� ������
 		 if (($output_attack[type]=='krit') OR ($output_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$real_enemy[id]} and (type=11 OR type=12 OR type=13 OR type=14)  ;"));
 		 	 if ($eff[id] > 0 ) {
	 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy[sex].":".$eff[name]."\n";
			 		}
 		 	}

 		############################################
 		$win_team_hist='t'.$user[battle_t].'hist';
 		$fin_add_log.="!:F:".time().":0:".$data_battle[$win_team_hist]."\n";
 		
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////

		//��� ������ ���� ����� ��� = ������ ������� $user;
		$BSTAT[win]=($user[battle_t]==3?4:$user[battle_t]);
 		############################################
		//�������� � ������
		$user[hp]=0;
		// �������� � ������
		if ($user[battle_t]==1) {unset($boec_t1[$user[id]]);} 
		elseif ($user[battle_t]==2)  {unset($boec_t2[$user[id]]);}
		elseif ($user[battle_t]==3)  {unset($boec_t3[$user[id]]);}		
		// ����� �� ������� �.�. ������
		 $STEP = 5;
		}
		break;

		case "REZ0000":
		{
		// echo "0000";
		// ����� ����� � ��������� ��������
		$fin_add_log=$input_attack[text]."\n".$output_attack[text]."\n"."!:D:".time().":".nick_new_in_battle($user).":".get_new_dead($user)."\n";

		 if (($input_attack[type]=='krit') OR ($input_attack[type]=='krita'))
 		 	{
 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$user[id]} and (type=11 OR type=12 OR type=13 OR type=14) ;"));
 		 	 if ($eff[id] > 0 ) {
	 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($user).":".$user[sex].":".$eff[name]."\n";
	 				}
 		 	}

		$fin_add_log.="!:D:".time().":".nick_new_in_battle($real_enemy).":".get_new_dead($real_enemy)."\n";

		 if (($output_attack[type]=='krit') OR ($output_attack[type]=='krita'))
 		 	{

 		 	$eff=mysql_fetch_array(mysql_query("select * from effects where battle={$data_battle[id]} and owner={$real_enemy[id]} and (type=11 OR type=12 OR type=13 OR type=14) ;"));
 		 	 if ($eff[id] > 0 ) {
		 				$fin_add_log.="!:T:".time().":".nick_new_in_battle($real_enemy).":".$real_enemy[sex].":".$eff[name]."\n";
			 		}
 		 	}

 		############################################
 		$fin_add_log.="!:F:".time().":0\n";

			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////

		//��� ������ ���� ����� ��� = �����
		$BSTAT[win]=0;
 		############################################
		//�������� � ������
		$user[hp]=0;

		// �������� � ������

		if ($user[battle_t]==1) {unset($boec_t1[$user[id]]);} 
		elseif ($user[battle_t]==2) {unset($boec_t2[$user[id]]);}
		elseif ($user[battle_t]==3) {unset($boec_t3[$user[id]]);}		
		// ����
		if ($real_enemy[battle_t]==1) {unset($boec_t1[$real_enemy[id]]);} 
		elseif ($real_enemy[battle_t]==2) {unset($boec_t2[$real_enemy[id]]) ;}
		elseif ($real_enemy[battle_t]==3) {unset($boec_t3[$real_enemy[id]]) ;}		
		 $STEP = 5;
		}
		break;

	     } // fin switch


			////795-��� - ����� ���� 
			if ( ((is_array($user_eff[795])) and ($user[hp]>0)) AND ($data_battle[nomagic]==0)  )
				{
				$hil_p=0.5; //50% � ������
				$dlev=($user[level]-$real_enemy[level])*0.1;
				$hil_p-=$dlev;
				$cure_value = round($output_attack[dem]*$hil_p);				
				if ($cure_value > 0 ) 
					{
					//�������
					$fadd=make_hil_battle($user,$cure_value);
					 if ($fadd) { $user[hp]+=$fadd; }
					}
				}

			////795-��� - ����� ���� 
			if ( ((is_array($real_enemy_eff[795])) and ($real_enemy[hp]>0)) AND ($data_battle[nomagic]==0)  )
				{
				$hil_p=0.5; //50% � ������
				$dlev=($real_enemy[level]-$user[level])*0.1;
				$hil_p-=$dlev;
				$cure_value = round($input_attack[dem]*$hil_p);				
				if ($cure_value > 0 ) 
					{
					//�������
					 $fadd=make_hil_battle($real_enemy,$cure_value);
					 if ($fadd) { $real_enemy[hp]+=$fadd; }
					}
				}


		if (!isset($real_enemy[id_user]) && ($STING=='REZ10' || $STING=='REZ00' || $STING=='REZ1010' || $STING=='REZ0010' || $STING=='REZ0001') && ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61)) {
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
		elseif (!isset($real_enemy[id_user]) and ($STING=='REZ10' || $STING=='REZ00' || $STING=='REZ1010' || $STING=='REZ0010' || $STING=='REZ0001') and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($user);
								}

		if (!isset($real_enemy[id_user]) && ($STING=='REZ01' || $STING=='REZ00' || $STING=='REZ0101' || $STING=='REZ0010' || $STING == 'REZ0001') && ($data_battle['type'] == 40 || $data_battle['type'] == 41 || $data_battle['type'] == 61)) {
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
		elseif (!isset($real_enemy[id_user]) and ($STING=='REZ01' || $STING=='REZ00' || $STING=='REZ0101' || $STING=='REZ0010' || $STING == 'REZ0001') and ( $data_battle['type'] ==150 || $data_battle['type'] ==140 ) )
								{
								//�������� �����
								get_kv_bonus($real_enemy);
								}


	     // ���� � ���� ����������� ������ ��� ������ ���� ����������
    		//������� ���� ��� ��� ���� ����� � ����� � ����
		if ($output_attack[dem] > 0 )
			{
			 solve_exp($data_battle,$user,$real_enemy,$my_wearItems[allsumm],$en_wearItems[allsumm],$output_attack[dem],$my_wearItems['elka_aura_ids'],$BSTAT[win],0);
			}
		// ������� ��� � ��������� ���� � ���� ���� ���
		if ($input_attack[dem] > 0 )
			{
			
					if ($input_fix_cost_level==1)
					{
					//����������� � ��������� ����� ��������
					if ($input_attack_magic_dem>0)
						{
						//���� ���� ��� ���� � ������ �� ����� ����� � ������� ����� ��� � ����� 
						 solve_exp($data_battle,$real_enemy,$real_enemy,$en_wearItems['allsumm'],$en_wearItems['allsumm'],$input_attack_magic_dem,$en_wearItems['elka_aura_ids'],$BSTAT[win],$input_attack_magic_dem);
						 }
					 
					 solve_exp($data_battle,$real_enemy,$user,$en_wearItems['allsumm'],$my_wearItems['allsumm'],($input_attack['dem']+$input_attack['stone']),$en_wearItems['elka_aura_ids'],$BSTAT[win],0);					 
					
					if (($user['id']==14897) OR ($real_enemy['id']==14897) )
					{
					addchp('<font color=red>��������!</font> ����� in fights 3'.$user['login'].'  VS '.$real_enemy['login'].' : DEM='.($input_attack['dem']+$input_attack['stone']),'{[]}Bred{[]}',-1,0);	
					}
					
					}
					else
					{
					//���� ���� ����� �� 1 �� ��� ��� ������ ������
					 solve_exp($data_battle,$real_enemy,$user,$en_wearItems['allsumm'],$my_wearItems['allsumm'],$input_attack['dem']+$input_attack['stone']+$input_attack_magic_dem,$en_wearItems['elka_aura_ids'],$BSTAT[win],$input_attack_magic_dem);
					 
					 if (($user['id']==14897) OR ($real_enemy['id']==14897) )
					{
					addchp('<font color=red>��������!</font> ����� in fights 4'.$user['login'].'  VS '.$real_enemy['login'].' : DEM='.($input_attack['dem']+$input_attack['stone']+$input_attack_magic_dem),'{[]}Bred{[]}',-1,0);	
					}
					 
					 }
			}

		 //2.2 �������� �� ��������� ���

		if ($BSTAT[win]==1)
		 {
		 // ������ ������� 1
		 // �������� ������
		 $data_battle[win]=1;
 		 if ($data_battle[fond] > 0) {   get_win_money_logs($data_battle);  }
	 	   $winrez[0]=finish_battle(1,$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);
		 if ($data_battle[blood]>0) { 	 addlog($data_battle[id],get_text_travm($data_battle)); }
		 addlog($data_battle[id],get_text_broken($data_battle));
			//��
			if ($data_battle[type]==10)
			{
				check_bs($data_battle);
			}
		 }
		 else if ($BSTAT[win]==2)
		 {
		 //������ ������� 2
 		 // �������� ������
		 $data_battle[win]=2;
 		 $winrez[0]=finish_battle(2,$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);
 		 if ($data_battle[blood]>0) { 	 addlog($data_battle[id],get_text_travm($data_battle)); }
		 addlog($data_battle[id],get_text_broken($data_battle));
 			//��
			if ($data_battle[type]==10)
			{
			check_bs($data_battle);
			}
		 }
		 else if ($BSTAT[win]==4)
		 {
		 //������ ������� 3
		 $data_battle[win]=4;
 		 $winrez[0]=finish_battle(4,$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);
 		 if ($data_battle[blood]>0) { 	 addlog($data_battle[id],get_text_travm($data_battle)); }
		 addlog($data_battle[id],get_text_broken($data_battle));
 			//��
			if ($data_battle[type]==10)
			{
			check_bs($data_battle);
			}
		 }		 
		 else if ($BSTAT[win]==0)
		 {
		 // �����
 		 // �������� ������
		 $data_battle[win]=0;
 		 $winrez[0]=finish_battle(0,$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);
		 addlog($data_battle[id],get_text_broken($data_battle));
		//��
			if ($data_battle[type]==10)
			{
			check_bs($data_battle);
			}
		 }
		 else
		 {
		 // ��� ����
		/// 3. ������� �������
		// �� ��������� ���� ������� ������ �� ������� ��������
		 mysql_query("delete from `battle_fd` where `battle`={$data_battle[id]} and `razmen_from`={$real_enemy[id]} and `razmen_to`={$user[id]} ; ");
		 }

  }
 }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

					//	print_r($user);
					  //   echo "<br>";
     					//	print_r($en);
					 //    echo "<br>";



					     }




				     }

				}
		}
	}


//////////////////////////////////////////////////////////////////////////////
// ������ ������
	$count_no_sleeps = 0;
	$good_exit=0;

   while($good_exit<=1)
     {
    ////////////////////////////////
	$ddd=mysql_fetch_array(mysql_query("select * from `variables` where `var`='fights_exit' ; "));
	if ($ddd[value]>0)
	{
	//���������� ����� �����
	mysql_query("update `variables` set `value`=0 where  `var`='fights_exit' ; ");
	$good_exit=1;
	break;
	}
    ///////////////////////////////
	$time_now = time();
	$count_no_sleeps++;
	// ��������� ������
	if($time_now >= $time_zayavka+$zayavka) 
	{
		$time_zayavka = $time_now;
		check_zayavka($time_now);
	}


// ��������� 	���������� ��������� ���� � ���� ������
	if($time_now >= $time_status_fights+$status_fights) 
	{
		$time_status_fights = $time_now;
		check_status_fights();
	}


	// ��������
    if($count_no_sleeps == 20) { sleep(1); $count_no_sleeps = 0;}
    }

addchp ('<font color=red>��������!</font> fights exit - '.CITY_DOMEN,'{[]}Bred{[]}',-1,0);	
addchp ('<font color=red>��������!</font> fights exit - '.CITY_DOMEN,'{[]}����{[]}',-1,0);	
addchp ('<font color=red>��������!</font> fights exit - '.CITY_DOMEN,'{[]}�������{[]}',-1,0);	


?>
