<?
if (!($_SESSION['uid'] >0)) header("Location: index.php");

if ($user['battle'] > 0) {
	echo "<font color=red>�� � ���...</font>";
} else	{

if (($user['lab'] ==0 ) OR ($user['lab'] ==1 ))
	{
	echo "<font color=red>����� ������������ ������ � ����������� ���������...</font>";
	}
	else
	{
			$usrlab=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_users` WHERE `owner` = '{$user[id]}' LIMIT 1;"));
			
			if (($usrlab[map]>0)AND($usrlab[x]>0)and($usrlab[y]>0)	)
			{
			//9-��� ����� ���� ��� �� ������ ���� ���������
			mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`,`val`) 
				values('".$usrlab[map]."','9','".$usrlab[x]."','".$usrlab[y]."','1','1','1' ) 
				ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
			echo "<font color=red>������ ������������: <i>���������</i>...</font>";
			if ($user[sex]==1) { $sexi='���������'; } else { $sexi='����������'; }
			addch("<img src=i/magic/lab_ukaz.gif> {$user[login]} ".$sexi." <i>��������� �����������</i>",$user['room'],$user['id_city']);
			$bet=1;
			$sbet = 1;
			}
			else
			{
			echo "<font color=red>��� ����� ������������...</font>";
			}
	   
	  }	
	  
	
	

}
?>

