<?php
if (!($_SESSION['uid'] >0)) {  header("Location: index.php"); die(); }
$magic = magicinf(1111);
$target = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));

	$KO_start_time20=mktime(16,0,0,6,1,2016);
	$KO_fin_time20 =mktime(23,59,59,6,30,2016);


	if ($klan_abil != 1)
	{
		$int=$magic['chanse'] + ($user['intel'] - 1)*3;
		if ($int>99){$int=101;}

	}
	elseif($klan_abil==1)    //���� ������� ��� ������ (�������� �� �����, ���� 100%)
	{
		$int=101;
	}
	else {
		$int=0;
	}
	



if ($user['battle'] > 0) {echo "�� � ���...";}
elseif ($user['zayavka'] > 0) {echo "�� � ������...";}
elseif (($user['lab']>0) or ($user['room']==45) or ($user['room']==31) or ($user[in_tower] > 0) )  {
	echo "�� � ���� �������!";
}
elseif ((time()>=$KO_start_time20)and (time()<=$KO_fin_time20))    { 	echo "��� ����� �������� �� ��������, �� ".date("d.m.Y H:i",$KO_fin_time20);  }
elseif ($user[room]==60) { 	echo "�� � ���� �������!"; }
elseif ($user[room]==999) { 	echo "�� � ���� �������!"; }
elseif ($user['hidden'] > 0) {echo "�� ��������� ��� ���� �������..."; }
elseif (($user['room'] >=210)AND($user['room'] <299)) {  echo "��� ��� �� ��������..."; }
elseif(!($target[id])) { echo "����� �������� �� ������..."; }
elseif(!($target[bot]==0)) { echo "����� �������� �� ������..."; }
elseif( ($target[klan]=='radminion') OR ($target['align'] > 2 && $target['align'] < 3) OR $target['bot'] > 0 OR ($target['deal'] > 0) OR ($target['id']==190672) OR ($target[klan]=='Adminion') OR ($target[klan]=='pal'))   { echo "����� �������� �� ������..."; }
elseif($target[id_city]!=$user[id_city] ) { echo "�������� � ������ ������..."; }
elseif ($target['ldate'] < (time()-60) ) { echo "�������� �� � ����!!"; }
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

	    $idiluz=mt_rand(10,99).date("H").mt_rand(1,9).date("i").mt_rand(1,9).date("s");
	   $hiddenlog=$target[id].",".$target[login].",".$target[level].",".$target[align].",".$target[sex].",".$target[klan];
	   
		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`idiluz`,`add_info`) values ('".$user['id']."','������� �����������',".(time()+$duration).",1111,'".$idiluz."','{$hiddenlog}');");
		mysql_query("UPDATE `users` SET `hidden`='{$idiluz}' , hiddenlog='{$hiddenlog}' where `id`='{$user['id']}';");
		echo "<font color=red><b>�� ��������������� � {$target[login]} </b></font>";

		$bet=1;
		$sbet = 1;
		
		
	}
	else
	{
;
		echo "������ ���������� � ����� �����...";
		$bet=1;
	}
?>
