<?php
		if (!($_SESSION['uid'] >0))
		{
			header("Location: index.php");
			die();
		}

if ($user['battle'] > 0) {
	echo "�� � ���...";
}
else if ($user['trv'] > 0) {
	echo "�� ��� ��������...";
} else {
		if ($user[hidden]>0 and $user[hiddenlog]=='') 
		{
		addch("<img src=i/magic/no_cure2.gif>�������� &quot;<i>���������</i>&quot; ��������� �� ����� �� ���..",$user['room'],$user['id_city']);
		}
		elseif ($user[hidden]>0 and $user[hiddenlog]!='') 
		{ 
		 $fuser=load_perevopl($user); 
 		addch("<img src=i/magic/no_cure2.gif>�������� &quot;{$fuser['login']}&quot; ��������� �� ����� �� ���..",$user['room'],$user['id_city']);
		 }
		 else
		 {
		 addch("<img src=i/magic/no_cure2.gif>�������� &quot;{$user['login']}&quot; ��������� �� ����� �� ���..",$user['room'],$user['id_city']);
		}

		mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$user['id']."','������ �� ����� �� ���',1999999999,556);");
		mysql_query("UPDATE `users` SET `trv`='1' where `id`='{$user['id']}';");
		echo "<font color=red><b>�� ���������� �� ����� �� ���...</b></font>";

		$bet=1;
		$sbet = 1;
	}

?>
