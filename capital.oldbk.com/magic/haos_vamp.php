<?php
$coma = array (
"������ �� ����� ��������� ��������.",
"��� ���������� ���-�� �������������.",
"�������� ������ ����� ��� ���� � ���� � ��� �������.",
"��-�����, ���� � ���� ���� ����� :(",
"��, ���� �� ����������, � � ����� ��� �� ������.",
"��� ���������� ���-�� �������������.",
"� ����� �� ���������� ����.",
"���������� ���� ���������!",
"������� � ����� �� ��������.",
"���������, ��� ������ �������...",
"�� ��� �� ��� ��������???",
"������ ��� ����� �� ��� ������.",
"��� � ���� ������ ���������.",
"�������� ������ - �� ����� ��������...�� ��� ��� ��� ���������....",
"��� ���������� ���-�� �������������.");

if ($user['battle'] > 0) {
	echo "�� � ���...";
}
elseif (($user['room'] >=210)AND($user['room'] <299)) {
	echo "��� ��� �� ��������...";
}

 else {
		if (!($_SESSION['uid'] >0)) header("Location: index.php");
		$target=$_POST['target'];
		$us = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
		$effs = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$us['id']}' and (`type`=222) ;"));
		//echo
		if ($us['battle']) { echo "�������� ��������� � ��������!"; }
		elseif ($us['zayavka']) { echo "�������� ������� ��������!"; }
		elseif ($effs[id]>0) { echo "�������� ��� ��� ������������ �����!"; }
		elseif ($us['id'] == $user['id']) { echo "�� ������ ����? ��.... ����� ��� � ���� ���� ��������? :)"; }
		elseif ($us['align'] == 5) { echo "��� � �� �������, ���?! &quot;{$us['login']}&quot; - ����  ������!"; }
		elseif ($user['hp'] > $user['maxhp']*0.66) { echo "��� ������������� ������, ���� ����� ������������� ���� "; }
		elseif ($user['hp'] < $user['maxhp']*0.33) { echo "�� ������� ��������� ��� �����."; }
		elseif ($us['hp'] < $us['maxhp']*0.33) { echo "������ ������� �����."; }
		elseif ($us['level'] < 2) { echo "������ ������� �������, ��� �������� ������������!"; }
		elseif ($us['align'] > 2 && $us['align'] < 3) { echo "�� ������ ������� ������? ;)"; }
		elseif ($user['room'] != $us['room']) { echo "�������� ��������� � ������ �������.)"; }
		elseif ($user['battle']) { echo "�� � ���..."; }
		elseif ($user['zayavka']) { echo "�� � ������..."; }
		elseif ($user['room'] == 31 || $user['room'] == 43 || $user['room'] == 200) { echo "������ ������� � ���� �������!"; }
		elseif ($us['level'] > $user['level']) { echo "������ ������� ��������� �������� ������!)"; }
		elseif ( ($CHAOS==2)AND($us[align]==4)) { echo "��� ��� ��� �� �������....";}
		elseif ( ($CHAOS==2)AND($us[klan]!='')) { echo "���� ������ ��� ����������....";}
		elseif ( ($CHAOS==2)AND($us[align]!=0)) { echo "���� ������ ��� ����������....";}		
		elseif ($us['odate'] < (time()-60)  && ($user['room']<501 || $user['room']> 560)) { echo "�������� ��������� � ��������"; }

		else {
			if ($user['sex'] == 1) {$action="�����"; $golod="�����������"; $pil="�����";}
			else {$action="������"; $golod="�����������"; $pil="������";}
			
			if ($us['sex'] == 1) {$otvet="�� ���"; $who="���";}
			else {$otvet="��� ����"; $who="�";}
			
			if ((int)($us[align]==1)) {  $new_align[0]=3; $new_align[1]=2; $nn=mt_rand(0,1);  }
			 else
		            if ((int)($us[align]==2)) {  $new_align[0]=3; $new_align[1]=6; $nn=mt_rand(0,1);  }
				else
				  if ((int)($us[align]==3)) {  $new_align[0]=2; $new_align[1]=6; $nn=mt_rand(0,1);  }
				    else
					if ((int)($us[align]==6)) {  $new_align[0]=2; $new_align[1]=3; $nn=mt_rand(0,1);  }
					 else
					  { 
					   $new_align[0]=2; $new_align[1]=3; $new_align[1]=6; $nn=mt_rand(0,2); 
					    }
					 $new_align=$new_align[$nn];
			
				
				if ($us['align']!=4)
					{
						if ($CHAOS!=2)
						{
						$tti=time()+60*60;
						mysql_query("INSERT INTO `effects` SET `type`=222,`name`='���� ����������� �����',`time`={$tti},`owner`={$us[id]},`add_info`='{$us[align]}' ");
						addchp ('<font color=red>��������!</font> �� ����������� ����� ������������ ����� �� 60 �����','{[]}{$us[login]}{[]}',$us['room'],$us['id_city']);						
						}
						else
						{
						$skl[2]='�����������'; $skl[3]='������'; $skl[6]='�������';
						mysql_query("INSERT INTO `delo`(`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$us['id']}','������� ".$skl[$new_align]." ���������� �� ����� ".$user['login']." ',1,'".time()."');");
						
						mysql_query("INSERT INTO `lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$us['id']."','������� ".$skl[$new_align]." ���������� �� ����� ".$user['login']." ','".time()."');");
						addchp ('<font color=red>��������!</font> �� ����������� ����� ������������ �����','{[]}{$us[login]}{[]}',$us['room'],$us['id_city']);												
						}
					
					mysql_query("UPDATE `users` SET  align='{$new_align}',  `hp` = 1 WHERE `id` = '".$us['id']."';");
					mysql_query("UPDATE `users` SET `hp` = `hp`+'".((($user['maxhp']-$user['hp'])<= $us['hp'])?($user['maxhp']-$user['hp']):$us['hp'])."' WHERE `id` = '".$user['id']."';");
				}
				else
					{
					$tti=time()+60*60; 
					mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`sila`,`lovk`,`inta`,`vinos`) values ('".$us[id]."','������ ���...',".$tti.",11,'25','0','0','0');");
					mysql_query("INSERT INTO `effects` SET `type`=222,`name`='���� ����������� �����',`time`={$tti},`owner`={$us[id]},`add_info`='{$us[align]}' ");					
					mysql_query("UPDATE `users` SET  sila=sila-25,  `hp` = 1 WHERE `id` = '".$us['id']."';");
					mysql_query("UPDATE `users` SET `hp` = `hp`+'".((($user['maxhp']-$user['hp'])<= $us['hp'])?($user['maxhp']-$user['hp']):$us['hp'])."' WHERE `id` = '".$user['id']."';");
					}

				if ( $user['hidden'] > 0 )
				{
							addch("<img src=i/magic/vampir.gif>{$golod} &quot;���������&quot; {$action} �� &quot;{$target}&quot; � {$pil} ��� {$who} �������.",$user['room'],$user['id_city']);
				}
				else
				{
							addch("<img src=i/magic/vampir.gif>{$golod} &quot;{$user['login']}&quot; {$action} �� &quot;{$target}&quot; � {$pil} ��� {$who} �������.",$user['room'],$user['id_city']);
				}

				addchp($coma[rand(0,count($coma)-1)],"�����������",$us['room'],$us['id_city']);
				echo "��� ������ ������!";
				$bet=1;
				$sbet = 1;
			
			 
			
			
			

		}

}
?>
