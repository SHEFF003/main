<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

if ($get_mag)
	{
	$magic =$get_mag;
	}
	else
	if ($tabil[magic])
	{
	$magic = magicinf($tabil[magic]);	
	}


 if (!$magic)
 	{
	$magic = magicinf(656);
	}

 if (!$magic['time']) {
	$tmp = magicinf(656);
	$magic['time'] = $tmp['time'];
 }

$effect = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and `type` = '656' LIMIT 1;"));

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
elseif (($user['lab']>0) or ($user['room']==45) or ($user['room']==10000) or ($user['room']==31) or ($user[in_tower] > 0) )  {
	echo "�� � ���� �������!";
}
elseif ($user[room]==60) { 	echo "�� � ���� �������!"; }
elseif ($user[room]==999) { 	echo "�� � ���� �������!"; }
elseif ($effect['id'] > 0) {echo "�� ��������� ��� ���� ����������"; }
elseif (($user['room'] >=210)AND($user['room'] <299)) {  echo "��� ��� �� ��������..."; }
elseif (rand(1,100) < $int) {

	     $duration = $magic['time']*60;

      
	//addch("<img src=i/magic/hidden.gif>�������� &quot;{$user['login']}&quot; ����������� � ���������..");

	    
	    $add_info='';
	    
	    
	    if (($rowm['name']!='') and ($rowm['includemagic']==0))
	    	{
		$add_info=$rowm['name']."::".$rowm['img'];
		}
		else
		   if (($rowm['name']!='') and ($rowm['includemagic']>0))
		    	{
			$add_info="����������::scroll_immunity0_2.gif";
			}
		
		

		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`,`add_info`) values ('".$user['id']."','����������',".(time()+$duration).",656,'".$add_info."');");
		
		echo "<font color=red><b>�� ���������� �� ���������...</b></font>";

		$bet=1;
		$sbet = 1;

		
		//fclose($f);
	}
	else
	{
		echo "������ ���������� � ����� �����...";
		$bet=1;
	}
?>
