<?php
if (!($_SESSION['uid'] >0))  { header("Location: index.php"); die();}
$baff_name='���������� ����� ������';
$can_use_rooms=array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,26,36,50,51,52,53,54,55,56,57,66);

  function count_kr($current_exp,$exptable) {

    $cl = 0; $money = 0; $stats = 3; $vinos = 3; $master = 1;
    while($exptable) {
      if($current_exp >= $exptable[$cl][5]) {
        /* 0stat  1umen  2vinos 3kred, 4level, 5up*/
        $cl = $exptable[$cl][5];
        $stats = $stats+$exptable[$cl][0];
        $master = $master+$exptable[$cl][1];
        $vinos = $vinos+$exptable[$cl][2];
      }
      	else
      {
      	$arr = array('stats'=>$stats,'master'=>$master,'vinos'=>$vinos,'cl'=>$exptable[$cl][5]);
      	return $arr;
      }
    }
  }


$get_effect = mysql_fetch_array(mysql_query("SELECT `id` FROM `effects` WHERE `owner` = ".$user[id]." AND (type=12 OR type=13 OR type=11 OR type=14 OR type=200 or type=1111 or type=826) LIMIT 1 ;"));

if ($user['battle'] != 0) 
{	
	echo "��� �� ������ �����..."; 
}
elseif (!(in_array($user[room],$can_use_rooms)))
{
err('������������ �����!');
}
elseif($user[zayavka]>0)
{
err('������������ �����, �� � ������ �� ���!');
}
elseif($user["stats"] > 0)
{
err('� ��� ���� ���������������� �����!');
}
elseif($user["hidden"] > 0)
{
err('����� �������� ����� ��� ������ �������!');
}
elseif (($user['noj']+$user['mec']+$user['topor']+$user['dubina']+$user['mfire']+$user['mwater']+$user['mair']+$user['mearth']+$user['mlight']+$user['mgray']+$user['mdark'])==0)
{
err("� ��� ��� ������������� ������!");
}
elseif ($get_effect)
{
err("�� �� ������ �������� �����  ���� ������! ���� ���� ����� \"������� ���������\"!");
}
else
		{
		mysql_query("DELETE from users_bonus where owner='{$user[id]}'  ;");
		undressall($user[id]);
		$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$user[id]}' LIMIT 1;"));

				$arra=count_kr($user['exp'],$exptable);
				$user_stamina=$arra['vinos'];

				$user_stats = ((int)$user["sila"]-(int)$user['bpbonussila']) +
				(int)$user["lovk"] + (int)$user["inta"] + (int)$user["vinos"] +
				(int)$user["intel"] + (int)$user["mudra"] - 9 - $user_stamina;

			    	$user_hp=$user_stamina*6+$user['bpbonushp'];

				$sil=$user['bpbonussila']+3;

				mysql_query("UPDATE `users` SET `sila` = '{$sil}', `lovk` = '3', `inta` = '3', `vinos` = '{$user_stamina}', `intel` = '0',	`mudra` = '0', `mana`=0 , `maxmana`=0 , `hp` = '{$user_hp}', `maxhp` = '{$user_hp}', `stats` = '{$arra[stats]}'  , `master` ='{$arra[master]}', noj=0,mec=0,topor=0,dubina=0,mfire=0,mwater=0,mair=0,mearth=0,mlight=0,mgray=0,mdark=0 	WHERE id='{$user[id]}' LIMIT 1; ");
				if (mysql_affected_rows()>0)
				{
				$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));

					
							 $mag_gif='<img src=i/magic/downgrade.gif>';
							 if(($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
							 {
							 $fuser['login']='<i>���������</i>';
							 $sexi='�����������';
							 }
							 else
						 	{
							 $fuser=load_perevopl($user); //�������� � �������� ��������� ���� ����
							 if ($fuser['sex'] == 1) {$sexi='�����������';  }	else { $sexi='������������';}
							 }
				
							addch($mag_gif." <B>{$fuser['login']}</B>, ����������� ����� &quot;".$baff_name."&quot;",$user['room'],$user['id_city']);
							$bet=1;
							$sbet = 1;
							echo "��� ������ ������!";
							$MAGIC_OK=1;
				}
						
		}


?>
