<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$baff_name='������ ������';
$baff_type=2020;
$tlive=false;

if ($user[battle]>0)
{
	$test_live=mysql_query("select id from users where battle='{$user['battle']}' and battle_t!='{$user['battle_t']}' and hp>0 limit 1");
	if (mysql_num_rows($test_live) > 0)
	{
		$tlive=true;
	}
}


if ($user['battle'] == 0)
{
	err("��� ������ �����...");
}
elseif ($tlive==false)
{
	err('��� ����� �����������!');
}
elseif($user['hp']<=0) {      err('��� ��� ��� �������!');        }
else
{



	$q = mysql_query('START TRANSACTION') or die("error 1");

	// ������ ������� ��� ��� ��� �������� ����

	$q = mysql_query("select * from effects where battle='{$user[battle]}' and `lastup`='{$user['battle_t']}' and type='{$baff_type}' and `time`>".time()." FOR UPDATE ") or die("error 2");

	if (mysql_num_rows($q) > 0)
	{
		$get_test_baff = mysqli_fetch_array($q); // ��� ��������
		$add_info=explode(":",$get_test_baff['add_info']) ;


		//[0] login
		//[1] �������

		//[2]id-mast-2
		//[3]login-2

		//[4]id-mast-3
		//[5]login-3

		if (($get_test_baff['owner']==$user['id']) OR ($add_info[2]==$user['id']) OR ($add_info[4]==$user['id']) )
		{
			err('���� ���� ��� �� �������!');
		}
		elseif ((int)$add_info[2]==0)
		{
			//� 2� ��� ������� ����
			//�������� ������
			//����� � ���
			mysql_query("UPDATE `effects` SET `add_info`=CONCAT(`add_info`,':{$user['id']}:{$user['login']}') WHERE `id`='{$get_test_baff['id']}';");
			if (mysql_affected_rows()>0)
			{
				mysql_query('COMMIT') or die("error 114");

				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
				addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(��������� ����...)</i>\n");

				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;

			}

		}
		else
		{
			mysql_query("DELETE from `effects` where `id`='{$get_test_baff['id']}';");
			if (mysql_affected_rows()>0)
			{
				mysql_query('COMMIT') or die("error 113");
				$dbattle=mysql_fetch_array(mysql_query("SELECT * FROM battle where id={$user['battle']} ; "));
				if (($dbattle['win']==3)	and  ($dbattle['t1_dead']=='') and ($dbattle['status']==0))
				{
					//��� ����
					$rndt=mt_rand(3,5);
//echo "kol: {$rndt} <br>";
					/*
					 ���� ���� �������� 3 ������, �� ������� 10% �� ������ � �������
				  ���� ���� �������� 4 ������, �� � 3� ������� 10%, � � 1�� 20%
				  ���� ���� �������� 5 �������, �� � 3� ������� 10%, � � 2� �� 20%
				  */
					$cmdmag[3]=array(0=>0.1, 1=>0.1, 2=>0.1);
					$cmdmag[4]=array(0=>0.2, 1=>0.1, 2=>0.1, 3=>0.1);
					$cmdmag[5]=array(0=>0.2, 1=>0.2, 2=>0.1, 3=>0.1, 4=>0.1);
					$kdmg=$cmdmag[$rndt];
//echo "<br>";
//print_r($kdmg);

					$output_attack_text="!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(������ ����...)</i>\n";

					$memorize=array();
					$filt='';

					$total_dmg=0;


					foreach ($kdmg as $n => $d)
					{
//echo "����� ���� {$n}";
						if (count($memorize)>0)
						{
							$filt=" and users.`id` not in  (".implode(",",$memorize).")  " ; //��������� ��� �� ��� ������ ������
						}


						//$jrtelo=mysql_fetch_array(mysql_query("select * from users where battle='{$user['battle']}' and battle_t!='{$user['battle_t']}' and hp>(1+maxhp*{$d}) ".$filt." ORDER BY RAND() limit 1"));
						$jrtelo=mysql_fetch_array(mysql_query("select * from users where battle='{$user['battle']}' and battle_t!='{$user['battle_t']}' and hp>0 ".$filt." ORDER BY RAND() limit 1"));


						if ($jrtelo['id']>0)
						{
//echo " ���� ���� �� {$d}" ;
							$dmg=(int)($jrtelo['maxhp']*$d);

							$new_hp=($jrtelo['hp']-$dmg);

							if ($new_hp<=0)
							{
								$new_hp=0;
								//���� �������
							}

							//mysql_query("UPDATE users set hp=hp-{$dmg} where id='{$jrtelo['id']}' and battle='{$user['battle']}' and hp>(1+maxhp*{$d})  LIMIT 1; ");
							mysql_query("UPDATE users set hp={$new_hp} where id='{$jrtelo['id']}' and battle='{$user['battle']}'  and hp>0 LIMIT 1; ");
							if (mysql_affected_rows()>0)
							{
								$memorize[]=$jrtelo['id'];
								$uron_str=$dmg;

								$prhp=$new_hp;

								$total_dmg+=(int)($dmg/3);  // ���� ����� �� ����� � �������

								//hidden �������������
								if  (  (($jrtelo['hidden'] > 0) and ($jrtelo['hiddenlog'] =='')) OR ( strpos($jrtelo['login'],"��������� (����" ) !== FALSE ) )
								{   $txtdm='[??/??]';  $uron_str=$dmg."|??";   } else  {  $txtdm='['.$prhp.'/'.$jrtelo['maxhp'].']';    }


								$output_attack_text.="\n!:Z:".time().":".nick_new_in_battle($jrtelo).":".(320+$jrtelo['sex'])."::".nick_new_in_battle($user).":{$add_info[0]}:{$add_info[3]}:::".$uron_str.":".$txtdm;

								if ($new_hp==0)
								{
									$output_attack_text.="\n"."!:D:".time().":".nick_new_in_battle($jrtelo).":".get_new_dead($jrtelo);
								}

								if ($jrtelo['battle_t']==1)
								{
									$boec_t1[$jrtelo['id']]['hp']=$new_hp ;
								}
								elseif ($jrtelo['battle_t']==2)
								{
									$boec_t2[$jrtelo['id']]['hp']=$new_hp ;
								}
								elseif ($jrtelo['battle_t']==3)
								{
									$boec_t3[$jrtelo['id']]['hp']=$new_hp ;
								}

							}
						}
						else
						{
//echo " ��� ���� �� {$d}" ;
						}
					}

//echo "total_dmg: {$total_dmg} <br>";

					if ($total_dmg>0)
					{
						$mag_dmg=$total_dmg;

						//��������� ���� ����
						//1.
						solve_exp($dbattle,$user,$user,$my_wearItems['allsumm'],$my_wearItems['allsumm'],$mag_dmg,$my_wearItems['elka_aura_ids'],$dbattle['win'],$mag_dmg);


						$my_friends=array();
						$my_friends[]=(int)$get_test_baff['owner'];
						$my_friends[]=(int)$add_info[2];

						foreach ($my_friends as $frid)
						{
							if ($frid>0)
							{
								$friend=mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = '{$frid}' LIMIT 1;"));
								$friend_eff=load_battle_eff_pre($friend,$dbattle); //������
								$friend_prof=GetUserProfLevels($friend); //�������� ����� �����
								$friend_wearItems=load_mass_items_by_id($friend,$friend_eff,$friend_prof); // �������� ������
								solve_exp($dbattle,$friend,$friend,$friend_wearItems['allsumm'],$friend_wearItems['allsumm'],$mag_dmg,$friend_wearItems['elka_aura_ids'],$dbattle['win'],$mag_dmg);//����
							}
						}


					}

					addlog($user['battle'],$output_attack_text);




				}

				$bet=1;
				$sbet = 1;
				echo "��� ������ ������!";
				$MAGIC_OK=1;
			}
		}
	}
	else
	{
		//��� ������ ��� ����� � ������
		//�������
		//����� 3m!
		$add_inf=$user['login'].":".$user['battle_t'];
		mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`add_info`='{$add_inf}' ,`time`='".(time()+180)."',`owner`='{$user[id]}',`lastup`='{$user['battle_t']}',`battle`='{$user[battle]}';");
		if (mysql_affected_rows()>0)
		{
			mysql_query('COMMIT') or die("error 115");

			if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
			elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
			addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type."::<i>(����� ����...)</i>\n");

			$bet=1;
			$sbet = 1;
			echo "��� ������ ������!";
			$MAGIC_OK=1;

		}
	}


	if($MAGIC_OK === 1) { //checker for quest engine
		try {
			global $app;
			$User = new \components\models\User($user);
			$Quest = $app->quest
				->setUser($User)
				->get();
			$Checker = new \components\Component\Quests\check\CheckerMagic();
			$Checker->magic_id = 2020;
			if(($Item = $Quest->isNeed($Checker)) !== false) {
				$Quest->taskUp($Item);
			}
		} catch (Exception $ex) {
			$app->logger->emerg($ex->getMessage(), [
				'magic' => '2020',
				'error' => $ex->getMessage(),
				'trace' => $ex->getTraceAsString()
			]);
		}
	}
}




?>
