#!/usr/bin/php
<?php
ini_set('display_errors','On');
$CITY_NAME='capitalcity';
include "/www/".$CITY_NAME.".oldbk.com/cron/init.php";
include "/www/".$CITY_NAME.".oldbk.com/repa_conf.php"; // ��������� ��� ���� �� �����
include "/www/".$CITY_NAME.".oldbk.com/hill_config.php"; //��������� ��� ���.����� � ��� �����


if( !lockCreate("cron_bot_job") ) {
   exit("Script already running.");
}
echo "Running bot fights...\n";
//addchp ('<font color=red>��������!</font> ���� ����� ','{[]}Bred{[]}');

//������� ����� ���� ������ ����� v.4.1a +add set time out by clons+add Bs +add ClanWar
// ���������� ������������
$lvlkof=0.01;

$attkof=0.1; // ��������� �� ���� �����
$attkritkof=0.1; // ��������� �� ���� ����� ��������
$kritblokkof=0.1; // ��������� �� ���� ����� �������� ����� ����

$kritkof=1.3; // ��������� �� ����
$uvorotkof=1.3; // �������� �� ����

$rabota_boni=0.315; // ��������� �� ������ �����
$rabota_boni_krit=0.315; // ��������� �� ������ ����� ��� �����
$rabota_boni_krit_a=0.315; // ��������� �� ������ ����� ��� ����� ����� ����

$min_uron=10; // ����������� ����

// mt_rand() � 4 ���� ������� radn();



	//$user = mysql_fetch_array(mysql_query('SELECT * FROM `users_clons` WHERE `id` = 10069752 LIMIT 1;'));
	//$real_enemy = mysql_fetch_array(mysql_query('SELECT * FROM `users_clons` WHERE `id` = 10069756 LIMIT 1;'));

	//include 'functions.php';



/////////functions ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
include "/www/".$CITY_NAME.".oldbk.com/fsystem.php";
///end functions////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//�������������� ������� �� ���� ����
function get_hil_bot($telo)
{
global $mob_hil;
$needh=(int)$mob_hil[$telo[id_user]];
//if ($telo[battle]==5288147)
{
//echo 'test';  echo "$telo[id_user]....$telo[hp]/$telo[maxhp] ....$telo[hil]....$needh.....battle:$telo[battle]<br>";
if (( ($telo[hp]+179)<$telo[maxhp]) AND ($telo[hil]<$needh) )
	{
		$cure_value=180;

		if(($telo['hp'] + $cure_value) > $telo['maxhp'])
		{
			$hp = $telo['maxhp'];
		}
		else
		{
			$hp = $telo['hp'] + $cure_value;
		}
		echo 'hill...';
		if ($telo['sex'] == 1) { $action = ""; }
		else { $action="�"; }

	mysql_query("UPDATE `users_clons` SET  `hil`=`hil`+1, `hp` = ".$hp." WHERE `id` = ".$telo['id']." and hp>0 ;");
	if (mysql_affected_rows()>0)
		{
		addlog($telo['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($telo,$telo[battle_t]).' �����������'.$action.' �������� �������������� ������� � �����������'.$action.' ������� ����� <B>+'.$cure_value.'</B> ['.($hp).'/'.$telo['maxhp'].']<BR>');
		return $hp;
		}


	}
  }
return false;
}

   // �������� ����� ����� � �1
   $bots1=mysql_query('SELECT * FROM `users_clons` WHERE hp >0 and battle_t=1 ;');
   $membattle=array(); $ke=0;
   // ���������� �� �������
while ($user = mysql_fetch_array($bots1))
{

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ��� ���� ���� ����� � ��� ������ ��� ����
   $data_battle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user[battle]} ; "));
	   //
	   if ($data_battle[win]==3)
	   {
	   // ��� ��� ��� ����
	   $battle_ok=true; // ���� ����� ������
	   }
	   else
	   {
	   /// ��� ��� ��������  �� ��� �� �������� ���� � �� �������� ���� �� ���
	   $battle_ok=false; // �� ���� ������ �������� ���
	   
	   	if (($data_battle[status]==1) and ($data_battle[t1_dead]=='finbatt'))
	   		{
	   		//��� �������� ������� ����� �����
	   		mysql_query("DELETE FROM users_clons WHERE id='{$user[id]}';");
	   		}
	   }

if ($battle_ok)
{
$hhh=0;
	//��� � ������� ����� 1
	$hhh=get_hil_bot($user);
	if ($hhh>0)
		{
		$use_ok=1;
		$user[hp]=(int)$hhh;
		}
		else
		{
		$use_ok=0;
		}
   $ke++;
   $cko=0;
   $membattle[$ke]=$user[battle]; // ���������� ������� ���� ��� �� ���������� � ������� �� ���� ������� 2 ��. ����

// ������ �������  ���������� ���� ���� �� ���� � ���� ��� - ������!
   $bots2=mysql_query('SELECT * FROM `users_clons` WHERE hp >0 and battle_t=2 and battle='.$user[battle].' ;');
    while ($real_enemy = mysql_fetch_array($bots2))
	{
	$hhh=0;
	$hhh2=0;
	  	if ($use_ok==1)
	  	{
	  	//������ ��� ��������� ������ � 0 ��� ���������� ����
	  	$use_ok=0;
	  	}
	  	else
	  	{
	  	   //��� � ������� ����� 1
	  	      $hhh=get_hil_bot($user);
		      if ($hhh > 0) {$user[hp]=$hhh;}
		}

		//����� ���� ���� ���� ���������
		//��� � ������� ����� 2
		$hhh2=get_hil_bot($real_enemy);
		if ($hhh2>0) { $real_enemy=$hhh2; }


	   $cko++;
//��������� ��� ������ ��� ����� ����� ��� �������� � ������ ����� ���� ��������
// ����������� ����� ���� ����� ��� �������� � �����������
		$my_wearItems=load_mass_items_by_id($user); // ��������
		$my_magicItems=$my_wearItems[incmagic]; // ���������� �����



		// ��� ���� � ���� �����
		if ($user[battle_t]==1) { $my_team_n=1; $en_team_n=2; } else { $my_team_n=2; $en_team_n=1; }

		$BSTAT[win]=$data_battle[win];
		if (($BSTAT[win]==3) and ($data_battle[status]==0))
		{

			if ($user[hp]>0) // ���� � �� ����
		  {
//////////////////////////////////////////
	         $my_enemy_do[attack]=mt_rand(1,4);
	         $my_enemy_do[block]=mt_rand(1,4);

	         $im_do[defend]=mt_rand(1,4);
	         $im_do[attack]=mt_rand(1,4);
////////////////////////////////////////////////////////////

			if ($user[id] < _BOTSEPARATOR_ )
			{
				$user_eff=load_battle_eff($user,$data_battle);
			}
			if ($real_enemy[id] < _BOTSEPARATOR_ )
			{
			$real_enemy_eff=load_battle_eff($real_enemy,$data_battle);
			}

			$en_wearItems=load_mass_items_by_id($real_enemy); // ��������
		//////////////////////////////////////////////////
			$input_attack=do_attack_in($data_battle,$user,$real_enemy,$my_enemy_do[attack],$im_do[defend],$my_wearItems,$en_wearItems,$user_eff,$real_enemy_eff,'from_cron_bot');
			write_stat($input_attack[stat],$data_battle[id]); // ����� ����������

			$output_attack=do_attack_out($data_battle,$user,$real_enemy,$im_do[attack],$my_enemy_do[block],$my_wearItems,$en_wearItems,$user_eff,$real_enemy_eff,'from_cron_bot');
			write_stat($output_attack[stat],$data_battle[id]); // ����� ����������

	 // � ����� ���������� �������� � ����������� ����� ��� ��� �� �����
			$rez=mysql_fetch_array(mysql_query("select do_razmen_to_bot_from_bot({$data_battle[id]},{$user[id]},{$user[battle_t]},{$real_enemy[id]},{$real_enemy[battle_t]},{$output_attack[dem]},{$input_attack[dem]}, {$data_battle[type]}) as ret;"));

			echo "<b>MAIN RESULT: $rez[0] </b><br> ";
			$STING='REZ'.$rez[0];
			switch ($STING)
		     {
				case "REZ11":
				{
				//echo "11";
				// ��� ����� �������� � ���
				addlog($data_battle[id],$input_attack[text].$output_attack[text]);
		/////////////// ������������ - ����������� �������� ���� ������ ���������� - � ����� �� ���� ����� ����
				if ($battle_data['type']==20)
								{
								addlog($data_battle[id],get_comment_fifa()); // ����������� ��� ����������
								}
								else
								{
								addlog($data_battle[id],get_comment()); // ����������� ������
								}

				}
				break;

				case "REZ01":
				 {
					// echo "01";
					 // $user ���� - $real_enmy -���
					$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
			 		addlog($data_battle[id],$input_attack[text].$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' <b>'.$action[$rda].$sexi[$user[sex]].'</b>!<BR>');

					//�������� � ������
					$user[hp]=0;
					$STEP = 4;
				}
				break;

				case "REZ10":
				{
			 		// echo "10";
					 //  ��������
					$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
					addlog($data_battle[id],$input_attack[text].$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($real_enemy,$real_enemy[battle_t]).' <b>'.$action[$rda].$sexi[$real_enemy[sex]].'</b>!<BR>');
					//�������� � ������ /
					$user[hp]-=$input_attack[dem];
		 		}
				break;
				case "REZ00":
				 {
			 		// echo "00";
					 // �������� - �� ��� ���� ������
			 		$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
					addlog($data_battle[id],$input_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' '.$action[$rda].$sexi[$user[sex]].'!<BR>'.$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($real_enemy,$real_enemy[battle_t]).' '.$action[$rda].$sexi[$real_enemy[sex]].'!<BR>');
					//�������� � ������
					$user[hp]=0;
					 $STEP = 4;
				 }
				break;

				case "REZ1010":
				{
					// echo "1010";
					// ��������� ������ ���� ���������� ����� ������ ������� �����
					$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
					//fix 29/07/2011
					$fin_add_log=$input_attack[text].$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($real_enemy,$real_enemy[battle_t]).' <b>'.$action[$rda].$sexi[$real_enemy[sex]].'</b>!<BR>';

			 		############################################
			 		$win_team_hist='t'.$user[battle_t].'hist';
			 		$fin_add_log.='<span class=date>'.date("H:i").'</span> ��� ��������, ������ �� <b>'.BNewRender($data_battle[$win_team_hist]).'</b>!<BR>';
			 		//fix 29/07/2011
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////

					//��� ������ ���� ����� ��� = ������ ������� $user[battle_t];
					$BSTAT[win]=$user[battle_t];
			 		############################################
					//�������� � ������ / ������ ����� �� ������� �.�. ��� �� ���� :)
					$user[hp]-=$input_attack[dem];
					$STEP = 5;
				}
				break;

				case "REZ0101":
				{
					// echo "0101";
					// ��������� ������ ���� ����� �� �� ����� ������ ���� �����
					//fix 29/07/2011
					$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
					$fin_add_log=$input_attack[text].$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' <b>'.$action[$rda].$sexi[$user[sex]].'</b>!<BR>';
			 		############################################
			 		$win_team_hist='t'.$real_enemy[battle_t].'hist';
			 		$fin_add_log.='<span class=date>'.date("H:i").'</span> ��� ��������, ������ �� <b>'.BNewRender($data_battle[$win_team_hist]).'</b>!<BR>';
			 		//fix 29/07/2011
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////
					//��� ������ ���� ����� ��� = ������ ������� $real_enemy;
					$BSTAT[win]=$real_enemy[battle_t];
			 		############################################
					//�������� � ������
					$user[hp]=0;
					 $STEP = 5;
				}
				break;

				case "REZ0001":
				{
					// echo "0001";
					// ���� ����� ���������  � ���� ����� ������� ����� �������� �.�. �������� �����
					$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
					//fix 29/07/2011
					$fin_add_log=$input_attack[text].$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' <b>'.$action[$rda].$sexi[$user[sex]].'</b>!<BR>';
			 		$fin_add_log.='<span class=date>'.date("H:i").'</span> '.nick_in_battle($real_enemy,$real_enemy[battle_t]).' <b>'.$action[$rda].$sexi[$real_enemy[sex]].'</b>!<BR>';
			 		############################################
			 		$win_team_hist='t'.$real_enemy[battle_t].'hist';
			 		$fin_add_log.='<span class=date>'.date("H:i").'</span> ��� ��������, ������ �� <b>'.BNewRender($data_battle[$win_team_hist]).'</b>!<BR>';

			 		//fix 29/07/2011
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////


					//��� ������ ���� ����� ��� = ������ ������� $real_enemy;
					$BSTAT[win]=$real_enemy[battle_t];
			 		############################################
					//�������� � ������
					$user[hp]=0;
					// ����� �� ������� �.�. ������
					 $STEP = 5;
				}
				break;
				case "REZ0010":
				{
					// echo "0010";
					// ���� ����� � ���� ����� ���������  ������� ����� �������� �.�. �������� �����
					$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
					$fin_add_log=$input_attack[text].$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' <b>'.$action[$rda].$sexi[$user[sex]].'</b>!<BR>';
			 		$fin_add_log.='<span class=date>'.date("H:i").'</span> '.nick_in_battle($real_enemy,$real_enemy[battle_t]).' <b>'.$action[$rda].$sexi[$real_enemy[sex]].'</b>!<BR>';
			 		############################################
			 		$win_team_hist='t'.$user[battle_t].'hist';
			 		$fin_add_log.='<span class=date>'.date("H:i").'</span> ��� ��������, ������ �� <b>'.BNewRender($data_battle[$win_team_hist]).'</b>!<BR>';
			 		//fix 29/07/2011
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],$fin_add_log);
				 		}
				 	////////////////////////
					//��� ������ ���� ����� ��� = ������ ������� $user;
					$BSTAT[win]=$user[battle_t];
			 		############################################
					//�������� � ������
					$user[hp]=0;
					// ����� �� ������� �.�. ������
					 $STEP = 5;
				}
				break;

				case "REZ0000":
				{
					// echo "0000";
					// ����� ����� � ��������� ��������
					$sexi[0]='��';$sexi[1]=''; $action[0]='����';$action[1]='�����';$rda=mt_rand(0,1);
					$fin_add_log=$input_attack[text].$output_attack[text].'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' <b>'.$action[$rda].$sexi[$user[sex]].'</b>!<BR>';
					$fin_add_log.='<span class=date>'.date("H:i").'</span> '.nick_in_battle($real_enemy,$real_enemy[battle_t]).' <b>'.$action[$rda].$sexi[$real_enemy[sex]].'</b>!<BR>';

			 		############################################
			 		$fin_add_log.='<span class=date>'.date("H:i").'</span> ��� ��������. �����.<BR>';
			 		//fix 29/07/2011
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
					 $STEP = 5;
				}
				break;

	         } // fin switch

/////
// �������� ����� ������ ��������� ��������
// ���������� ����� ��������� � $user
if (    ($real_enemy[id_user] > 89) AND ($real_enemy[id_user] < 230) 	  AND //$real_enemy[id_user] - � ������ ����� ����� ��������� ����!!!!
	 (  ( $STING=='REZ10') OR ( $STING=='REZ00') OR ( $STING=='REZ1010') OR ( $STING=='REZ0010') ) // ����� ������� ��� ���� ����
	 )
	 {
 	$aadd_rep=(int)($mob_rep[$real_enemy[id_user]]);
 	//addchp ('<font color=red>��������!</font> ����� ���������� ����'.$aadd_rep,'{[]}Bred{[]}');
 	///$user[id_user] - ������ ����� � ������� �1
	mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id_user]."', 'labkillrep', '".$aadd_rep."' ) ON DUPLICATE KEY UPDATE `val` =`val`+".$aadd_rep.";");

	 }

////



	     // ���� � ���� ����������� ������ ��� ������ ���� ����������
	    		//������� ���� ��� ��� ���� ����� � ����� � ����
			if ($output_attack[dem] > 0 )
				{
				 solve_exp($data_battle,$user,$real_enemy,$my_wearItems[allsumm],$en_wearItems[allsumm],$output_attack[dem]);
				}
		// ������� ��� � ��������� ���� � ���� ���� ���
			if ($input_attack[dem] > 0 )
				{
				 solve_exp($data_battle,$real_enemy,$user,$en_wearItems[allsumm],$my_wearItems[allsumm],$input_attack[dem]);
				}

		 //2.2 �������� �� ��������� ���

			if ($BSTAT[win]==1)
			 {
			 // ������ ������� 1
			 // �������� ������
			 	$data_battle[win]=1;
			 //
				mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
				 $winrez[0]=finish_battle(1,$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);
			 //������ �������� ������ � finish_battle
			 //mysql_query("delete from `battle_fd` where `battle`={$data_battle[id]} ; ");
			 //mysql_query("delete from `users_clons` where `battle`={$data_battle[id]} ; ");

	 		 	if ($data_battle[blood]>0) { 	 addlog($data_battle[id],get_text_travm($data_battle)); }
			 	addlog($data_battle[id],get_text_broken($data_battle));



			 }
			 else if ($BSTAT[win]==2)
			 {
				 //������ ������� 2
		 		 // �������� ������
				 $data_battle[win]=2;
				 mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
				 $winrez[0]=finish_battle(2,$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);
				 //������ �������� ������ � finish_battle
				 //mysql_query("delete from `battle_fd` where `battle`={$data_battle[id]} ; ");
				 //mysql_query("delete from `users_clons` where `battle`={$data_battle[id]} ; ");

		 		 if ($data_battle[blood]>0) { 	 addlog($data_battle[id],get_text_travm($data_battle)); }
				 addlog($data_battle[id],get_text_broken($data_battle));


			 }
			 else if ($BSTAT[win]==0)
			 {
				 // �����
		 		 // �������� ������
				 $data_battle[win]=0;
				 mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
				 $winrez[0]=finish_battle(0,$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);
				 //������ �������� ������ � finish_battle
				 //mysql_query("delete from `battle_fd` where `battle`={$data_battle[id]} ; ");
				 //mysql_query("delete from `users_clons` where `battle`={$data_battle[id]} ; ");

		 // 		 if ($data_battle[blood]>0) { 	 addlog($data_battle[id],get_text_travm($data_battle)); }
				 addlog($data_battle[id],get_text_broken($data_battle));

			 	

			 }
			 else
			 {
			 // ��� ����
			/// 3. ������� �������
			/*-----*/
			// �� ��������� ���� ������� ������ �� ������� ��������
	//		 mysql_query("delete from `battle_fd` where `battle`={$data_battle[id]} and `razmen_from`={$real_enemy[id]} and `razmen_to`={$user[id]} ; ");
			 }



		  } //�������� �� ��
		   else
		   {
		   // ���� ����


		   }

 		} /////// �������� �� ��� ��� �����
	 else
	 {
	 	$STEP = 5;
	 }

 // �������� �� ����� �����
	  if ($STEP==2)
	   {
	   //�������� �����
	   //print_r($data_battle);
	       if (get_timeout($data_battle,$user) )
		       {
		       	$STEP=3;
		       }

	   }


	} //$bots2 ����

	if   ($cko==0)
	 {
	 // ��� ���� �� � ��� ��� ��������� ���� �� ������� 2
	 // ��� ���� ����� ��������� ���� �� �� ������ �� �����
	 	$data_battle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user[battle]} ; "));
	 	if (($data_battle[win]==3) and ($data_battle[status]==0))
	      {
	      	if (get_timeout($data_battle,$user) )
	      	{
	      			// �����
	      			mysql_query("UPDATE battle set status=1 where id={$data_battle[id]}");
	      			$data_battle[win]=$user[battle_t];
		 		//$data_battle[blood]=1;// ������ �� ���� ����������� �������� ������
		 		if ($data_battle[type]!=10)	//���� ��� �� � ��
			 		 {
			 		    // ��� ���� ��������� ������ ���� ��� �������
			 		    if ($user[battle_t]==1) { $my_team_n=1; $en_team_n=2; } else { $my_team_n=2; $en_team_n=1; }
			 		    
		 		    if ($data_battle[blood]==2)
			 		      {
			 		         mysql_query("UPDATE users SET hp=0 , sila = IF((@RR:=100*RAND())<30, settravmatv2_new(id,'sila',sila,level,{$data_battle[id]},{$data_battle[type]},align,trv,pasbaf), sila), lovk = IF(@RR>=30 AND @RR<60, settravmatv2_new(id,'lovk',lovk,level,{$data_battle[id]},{$data_battle[type]},align,trv,pasbaf), lovk), inta = IF(@RR>=60, settravmatv2_new(id,'inta',inta,level,{$data_battle[id]},{$data_battle[type]},align,trv,pasbaf), inta) where battle={$data_battle[id]} and battle_t={$en_team_n} and hp > 0 and `level` > 3 and align!=5;");
			 		      }
			 		    else
			 		     if ($data_battle[type]!=1) //�� ���
			 		       {
			 		         mysql_query("UPDATE users SET hp=0 , sila = IF((@RR:=100*RAND())<30, settravmat2(id,'sila',sila,level,{$data_battle[id]},{$data_battle[type]},trv), sila), lovk = IF(@RR>=30 AND @RR<60, settravmat2(id,'lovk',lovk,level,{$data_battle[id]},{$data_battle[type]},trv), lovk), inta = IF(@RR>=60, settravmat2(id,'inta',inta,level,{$data_battle[id]},{$data_battle[type]},trv), inta) where battle={$data_battle[id]} and battle_t={$en_team_n} and hp > 0 and `level` > 3 and align!=5;");
						$errrr=mysql_error();
						//addchp ('<font color=red>��������!</font>'.$errrr,'{[]}Bred{[]}');				 		         
			 		       }
			 		       else
			 		       {
			 		       //��� - ��������� ��� �� 4 ��� ������ �� ��������
		       	 		       mysql_query("UPDATE users SET hp=0 , sila = IF((@RR:=100*RAND())<30, settravmat2(id,'sila',sila,level,{$data_battle[id]},{$data_battle[type]},trv), sila), lovk = IF(@RR>=30 AND @RR<60, settravmat2(id,'lovk',lovk,level,{$data_battle[id]},{$data_battle[type]},trv), lovk), inta = IF(@RR>=60, settravmat2(id,'inta',inta,level,{$data_battle[id]},{$data_battle[type]},trv), inta) where battle={$data_battle[id]} and battle_t={$en_team_n} and hp > 0 and `level` > 3 and align!=5;");
			 		       }
				     }



		 		$win_team_hist='t'.$data_battle[win].'hist';

		 		//fix 29/07/2011
			 		//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 		mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 		if (mysql_affected_rows()>0)
			 			{
			 			//���� ������ ������ �� �����
				 		addlog($data_battle[id],'<span class=date>'.date("H:i").'</span> ��� �������� '.($vrag_exit==1?"":"�� ��������").', ������ �� <b>'.BNewRender($data_battle[$win_team_hist]).'</b>!<BR>');
							if ($vrag_exit!=1)
							{
				 			mysql_query("INSERT INTO `battle_time_out` SET `battle`='{$data_battle[id]}',`owner`='{$user[id]}',`login`='{$user[login]}';");
				 			}

				 		}
				 	////////////////////////



				$winrez[0]=finish_battle($data_battle[win],$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);

				 addlog($data_battle[id],get_text_travm($data_battle));
				 addlog($data_battle[id],get_text_broken($data_battle));

	      			//addchp ('<font color=red>��������!</font> ���� �� ����� � �1 ('.$data_battle[id].') ','{[]}Bred{[]}');
	      	}
	      }
	 }


}//������� ���� ��� ����

} // $bots1 ����

	///// ���������� ����� ��� ����� ������� 2
	// �������� ������ � ���� ������ ������� 2 �� �������� � ������ �������� ����������� �� ���� ���� � �������
	//  � ����� ��� ����� ������ �� ����� ������� - �� ����� ������ ������ ���� ������
	//$restal_bots_arr=array(247,248,249,250,251);	
	
	
	//$bots2=mysql_query('SELECT * FROM `users_clons` WHERE hp >0 and battle_t=2 and battle not in (".implode(",",$membattle).") GROUP BY battle ;');
	$bots2=mysql_query('SELECT * FROM `users_clons` WHERE hp >0 and battle_t=2 GROUP BY battle  ;');
	
	  // ���������� �� �������
	   while ($user = mysql_fetch_array($bots2))
	    {
	     $data_battle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user[battle]} ; "));
	    	 
	    	 
	    	if (($data_battle[win]==3) and ($data_battle[status]==0))
	      	{
	      	//��� ����
		      if (get_timeout($data_battle,$user) )
	      			{
	      			// �����
		      			mysql_query("UPDATE battle set status=1 where id={$data_battle[id]}");
		      			$data_battle[win]=$user[battle_t];
	 		 //$data_battle[blood]=1;// ������ �� ���� ����������� �������� ������
	 		  //if ($data_battle[blood]!=1) // ���� ��� �� �������� �� ������ ���� ��� ������� ������, ���� �������� - ��! � ��� ��� �������!
	 		  if ($data_battle[type]!=10)	//���� ��� �� � ��
				 		   {
				 		    // ��� ���� ��������� ������ ���� ��� �������
				 		    if ($user[battle_t]==1) { $my_team_n=1; $en_team_n=2; } else { $my_team_n=2; $en_team_n=1; }
				 		    
				 		    if ($data_battle[blood]==2)
				 		      {
				 		         mysql_query("UPDATE users SET hp=0 , sila = IF((@RR:=100*RAND())<30, settravmatv2_new(id,'sila',sila,level,{$data_battle[id]},{$data_battle[type]},align,trv,pasbaf), sila), lovk = IF(@RR>=30 AND @RR<60, settravmatv2_new(id,'lovk',lovk,level,{$data_battle[id]},{$data_battle[type]},align,trv,pasbaf), lovk), inta = IF(@RR>=60, settravmatv2_new(id,'inta',inta,level,{$data_battle[id]},{$data_battle[type]},align,trv,pasbaf), inta) where battle={$data_battle[id]} and battle_t={$en_team_n} and hp > 0 and `level` > 3 and align!=5;");
				 		      }
				 		    else
				 		     if ($data_battle[type]!=1) //�� ���
				 		       {
				 		         mysql_query("UPDATE users SET hp=0 , sila = IF((@RR:=100*RAND())<30, settravmat2(id,'sila',sila,level,{$data_battle[id]},{$data_battle[type]},trv), sila), lovk = IF(@RR>=30 AND @RR<60, settravmat2(id,'lovk',lovk,level,{$data_battle[id]},{$data_battle[type]},trv), lovk), inta = IF(@RR>=60, settravmat2(id,'inta',inta,level,{$data_battle[id]},{$data_battle[type]},trv), inta) where battle={$data_battle[id]} and battle_t={$en_team_n} and hp > 0 and `level` > 3 and align!=5;");
				 		       }
				 		       else
				 		       {
				 		       //��� - ��������� ��� �� 4 ��� ������ �� ��������
			       	 		       mysql_query("UPDATE users SET hp=0 , sila = IF((@RR:=100*RAND())<30, settravmat2(id,'sila',sila,level,{$data_battle[id]},{$data_battle[type]},trv), sila), lovk = IF(@RR>=30 AND @RR<60, settravmat2(id,'lovk',lovk,level,{$data_battle[id]},{$data_battle[type]},trv), lovk), inta = IF(@RR>=60, settravmat2(id,'inta',inta,level,{$data_battle[id]},{$data_battle[type]},trv), inta) where battle={$data_battle[id]} and battle_t={$en_team_n} and hp > 0 and `level` > 3 and align!=5;");
				 		       }
						 }




				 		$win_team_hist='t'.$data_battle[win].'hist';
						//fix 29/07/2011
			 			//������ ������� � ��� � ��� ��� ������ ��������� ���-��� �� �����������
			 			mysql_query("update battle set t1_dead='finlog' where id={$data_battle[id]} and t1_dead='' ;");
			 			if (mysql_affected_rows()>0)
			 			{
				 		addlog($data_battle[id],'<span class=date>'.date("H:i").'</span> ��� �������� '.($vrag_exit==1?"":"�� ��������").', ������ �� <b>'.BNewRender($data_battle[$win_team_hist]).'</b>!<BR>');
							if ($vrag_exit!=1)
							{
				 			mysql_query("INSERT INTO `battle_time_out` SET `battle`='{$data_battle[id]}',`owner`='{$user[id]}',`login`='{$user[login]}';");
				 			}				 		

				 		}

						$winrez[0]=finish_battle($data_battle[win],$data_battle,$data_battle[blood],$data_battle[type],$data_battle[fond]);


					 addlog($data_battle[id],get_text_travm($data_battle));
					 addlog($data_battle[id],get_text_broken($data_battle));


	      			//addchp ('<font color=red>��������!</font> ���� �� ����� T2 ('.$data_battle[id].') ','{[]}Bred{[]}');
	      			}
		}
		else
		{
		//��� �������
		// ��������� ����� �� ��� ����������� ���� �� ������ ����� � ���� ��� ��� ������� �2
			if (($data_battle[status]==1) and ($data_battle[t1_dead]=='finbatt') and ($data_battle[win]!=3))
	   		{
	   		//��� �������� ������� ����� �����
	   		mysql_query("DELETE FROM users_clons WHERE battle='{$data_battle[id]}';");
	   		}
		
		
		
		}

	    }


echo "Finishing script. Destroy lock.\n";
lockDestroy("cron_bot_job");
?>