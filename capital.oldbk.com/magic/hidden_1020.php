<?php
$magic = magicinf(1020);
//$effect = mysql_fetch_array(mysql_query("SELECT `time` FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '200' LIMIT 1;"));

$int=101;

	$KO_start_time20=mktime(16,0,0,6,1,2016);
	$KO_fin_time20 =mktime(23,59,59,6,30,2016);


if ($user['battle'] > 0) {echo "�� � ���...";}
elseif ($user['zayavka'] > 0) {echo "�� � ������...";}
elseif (($user['lab']>0) or ($user['room']==45) or ($user['room']==31) or ($user[in_tower] > 0) )  {
	echo "�� � ���� �������!";
}
elseif ((time()>=$KO_start_time20)and (time()<=$KO_fin_time20))    { 	echo "��� ����� �������� �� ��������, �� ".date("d.m.Y H:i",$KO_fin_time20);  }
elseif ($user[room]==60) { 	echo "�� � ���� �������!"; }
elseif ($user[room]==999) { 	echo "�� � ���� �������!"; }
elseif ($user['hidden'] > 0) {echo "�� ��������� ��� ���� �������..."; }
elseif (($user['room'] >=210)AND($user['room'] <299)) { echo "��� ��� �� ��������..."; }
elseif (rand(1,100) < $int) {

      $duration = $magic['time']*60;
        if ($user[mudra]>5)
	      	{
	      	/*
	      	Bred: 120 ������ + ( mudra*10 �� �� ����� 120)
			������: ��
	      	*/
	      	$addd=($user[mudra]-5)*10;
	      	if ($addd>120) {$addd=120;}
	      	$duration=$duration+($addd*60);
	      	}


      
	//addch("<img src=i/magic/hidden.gif>�������� &quot;{$user['login']}&quot; ����������� � ���������..");

//$md=date("His");
//$ren=rand(1000,9999);
$idiluz=rand(10,99).date("H").rand(1,9).date("i").rand(1,9).date("s");

			mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`idiluz`) values ('".$user['id']."','������� �����������',".(time()+$duration).",200,'".$idiluz."');");
			mysql_query("UPDATE `users` SET `hidden`='{$idiluz}' where `id`='{$user['id']}';");
			echo "<font color=red><b>�� ����������� �������...</b></font>";
			$bet=1;
			$sbet = 1;

	
} else {
	
				echo "������ ���������� � ����� �����...";
				$bet=1;
			}
?>
