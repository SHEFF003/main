<?php
		if (!($_SESSION['uid'] >0))
		{
			header("Location: index.php");
			die();
		}

if ($user['battle'] > 0) {echo "�� � ���...";}
elseif ($user['trv'] > 0) {echo "�� ��� �������� �� �����...";}

else {

if ($ABIL>0) 
	{
	$magid=4846;
	}
	else
	{
	$magid=555;
	}

$magic = magicinf($magid);

$duration = $magic['time']*60;
		
		if ($user[hidden]>0 and $user[hiddenlog]=='') 
		{
		addch("<img src=i/magic/no_cure2.gif>�������� &quot;<i>���������</i>&quot; ��������� �� �����..",$user['room'],$user['id_city']);
		}
		elseif ($user[hidden]>0 and $user[hiddenlog]!='') 
		{ 
		 $fuser=load_perevopl($user); 
 		addch("<img src=i/magic/no_cure2.gif>�������� &quot;{$fuser['login']}&quot; ��������� �� �����..",$user['room'],$user['id_city']);
		 }
		 else
		 {
		 addch("<img src=i/magic/no_cure2.gif>�������� &quot;{$user['login']}&quot; ��������� �� �����..",$user['room'],$user['id_city']);
		}

		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','������ �� �����',".(time()+$duration).",555);");
		mysql_query("UPDATE `users` SET `trv`='1' where `id`='{$user['id']}';");
		echo "<font color=red><b>�� ���������� �� ����� �� 72 ����.</b></font>";

		$bet=1;
		$sbet = 1;

	}

?>
