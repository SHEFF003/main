<?php
// ����� "������ �� ����� �������"
if (!($_SESSION['uid'] >0)) header("Location: index.php");

	$sn[0] = " ������ ���������� ";
	$sn[1] = " ���������";
	$sn[2] = " ������";
	$sn[3] = " �����";
	$sn[4] = " ������";
	$sn[5] = " �����";
	$sn[6] = " ������� ����������";
	$sn[7] = " ";
	$sn[8] = " ��������";
	$sn[9] = " �����";
	$sn[10] = " ��������";
	$sn[11] = " ������";
	$sn[12] = " �������";
	$sn[13] = " ��������";
	$sn[14] = " ������ ";
	
	$uron=rand(1,3);

	$txt='black';
	$ch=rand(0,count($sn)-1);
	$ball=$sn[$ch];
	if($ch==14)
	{
		$comm=1;
		$commen='������� ��... �� ��� ������ ����!';
		$uron=10;
		$txt='red';
	}

	/*
	if($user[klan]=='Adminion'||$user[klan]=='radminion')
	{

		$comm=1;
		$commen='������� ��... �� ��� ������ ����!';
		$uron=16;
		$txt='red';
		$obm=1;

	}*/
	
	$sn1[] = " �������";
	$sn1[] = " ������ �����";
	$sn1[] = " ������� �����";
	$sn1[] = " ������� �����";
	$sn1[] = " ������� �����";
	$ball1=$sn1[rand(0,count($sn1)-1)];

	$sn2[] = ($user[sex]==1?' �����':' ������');
	$sn2[] = ($user[sex]==1?' ������':' �������');
	$sn2[] = ($user[sex]==1?' ���������':' ����������');
	$sn2[] = ($user[sex]==1?' �������':' ��������');
	$sn2[] = ($user[sex]==1?' �������':' ��������');
	$att=$sn2[rand(0,count($sn2)-1)];

	$sn3[] = " �";
	$sn3[] = " ����� �";
	$sn3[] = " ����� �";
	$sn3[] = " � ���";
	$sn3[] = " � �����";
	$sn3[] = " ������ ���������� �";
	$sn3[] = " �� ��������";
	$sn3[] = " � ����";
	$sn3[] = " �� ������";
	$sn3[] = " �� �����";
	$sn3[] = " � �����";
	$sn3[] = " �� ����";
	$where=$sn3[rand(0,count($sn3)-1)];

		$coma = $att.$ball.$ball1.$where. ' <b>&quot;'.$_POST['target'].'&quot;</b>';

		$target=mysql_fetch_array(mysql_query('select * from users where login = "'.$_POST['target'].'"'));
		
	if (($target[odate]<time()-60) and  ($target[battle]==0))
	{
		echo '<font color=red><b>��������� ��� � �����</b></font>';
	}
	else
	if($user[room]==31)
	{
		echo '<font color=red><b>��� ������ ������������ ����... ���������� ���������...</b></font>';
	}
    else
    {
		//bonus by Fred ^)))
		$get_eff=mysql_fetch_array(mysql_query('select * from effects where type=33 and owner = "'.$target[id].'"'));
		if ($get_eff[id] >0 ) {$uron=$uron*15+(mt_rand(1,9)); $obm=0; }

		if ($obm==1)
		   {
		  	 mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$target[id]."','�����������',".(time()+900).",33);");
		   }
		/////////////////////
		if($target[login]==$user[login])
		{
			echo '<font color=red><b>������ � ����?..<b></font>';
		}
		elseif (($target['battle']>0) and ($user['battle']==$target['battle'])) 
		{
			//if (($user['id']==14897) or ($user['id']==188))
			{
			//��� � ����� ���!
			if ($target['hp']>30)
			{
			$baf_dem=rand(10,30);
			
				mysql_query("UPDATE users set hp=hp-'{$baf_dem}' where id='{$target['id']}' and hp>30 LIMIT 1; ");

				if (mysql_affected_rows()>0)
					{

			       	       $uron_str=$baf_dem;
       					$prhp=$target['hp']-$baf_dem;
			       	       
					if (($target['hidden'] > 0) and ($target['hiddenlog'] ==''))
		 		        {   $txtdm='[??/??]';  $uron_str=$baf_dem."|??";   } else  {  $txtdm='['.$prhp.'/'.$target['maxhp'].']';    }
		 		             			
					$add_log="\n!:1:".time().":".nick_new_in_battle($target).":".(100*$user['sex']+mt_rand(1,5))."::".nick_new_in_battle($user).":".mt_rand(0,14).":".mt_rand(1,5).":".mt_rand(1,12)."::".$uron_str.":".$txtdm;
					addlog($user['battle'],$add_log."\n");
					$bet=1;
					$sbet = 1;
					$MAGIC_OK=1;
					
					if (mt_rand(1,100)==1) //������ ������ � ��� 1%  �� �����
						{
						drop_card($user);
						}

                        try {
                            global $app;
                            $User = new \components\models\User($user);
                            $Quest = $app->quest
                                ->setUser($User)
                                ->get();
                            $Checker = new \components\Component\Quests\check\CheckerMagic();
                            $Checker->magic_id = 5276;
                            if(($Item = $Quest->isNeed($Checker)) !== false) {
                                $Quest->taskUp($Item);
                            }
                        } catch (Exception $ex) {
                            \components\Helper\FileHelper::writeArray(array(
                                'magic' => '5276',
                                'error' => $ex->getMessage(),
                                'trace' => $ex->getTraceAsString()
                            ), 'error_log');
                        }
					}
			}
		       	 else
		       	 {
				echo '<font color=red><b>�������� ������ ����, �� ������ ��� ����� �������...<b></font>';		       	 
		       	 }      
		       }	 
		}
		elseif (($target[battle]>0) and ($user['battle']==0))
		{
			echo '���� �������� � ���';
		}		
		elseif(($target[room]!=$user[room]) and ($user['klan']!='radminion') )
		{
			echo '<font color=red><b>�������� � ������ �������...<b></font>';
		}
		else
		{
			if ($user[hidden]>0) { $usnik="<i>���������</i>"; } else {$usnik=$user[login]; }
			$messch ="<b>&quot;{$usnik}&quot;</b> {$coma} <b>(<font color={$txt}>-{$uron}</font>)</b>";
		 	if ($uron>$target[hp]) { $uron=$target[hp]; }
			mysql_query("UPDATE `users` SET `hp` = (hp-".$uron.") WHERE `id` = ".$target['id'].";");
			addch("<img src=i/magic/snezhok.gif> $messch",$user['room'],$user['id_city']);
				if($comm==1)
				{
					addchp($commen,"�����������",$user['room'],$user['id_city']);
				}
			echo "<font color=red><b>�� ������ ������ � ".$target[login]."<b></font>";
			$bet=1;
			$sbet = 1;
		}
	}

?>