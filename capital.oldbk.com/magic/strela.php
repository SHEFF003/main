<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$targ=($_POST['target']);
$baff_name='������� �������������';
$baff_type=2025;

if ($targ=='')
{
err('��������  �� ������!');
}
else
if ($user['battle'] > 0) 
{	
	echo "������ ������������ � ���..."; 
}
else {
	
	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}'   LIMIT 1;"));
	if (($jert['id'] ==$user['id']) ) // ������ ����� �� ���� � ���� �����
	{
	err('������ ������������ �� ���� :(');
	}
	else if (($jert['id'] >0) AND  ($jert['id_city']!=$user['id_city']) )
	{
	err('�������� � ������ ������...');
	}
	else if (($jert['id'] >0) AND  ($jert['room']!=$user['room']) )
	{
	err('�������� � ������ �������...');
	}
	elseif ($jert['id'] >0)
			{
			$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$jert['id']}' and (type='{$baff_type}') ; "));
			if (($get_test_baff[id] > 0) )
			{
				err('�� ��������� ��� ���� ��� �����!');
			}
			else
			 {
			 $magictime=time()+3*60*60;
			 				mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}', `time`='".$magictime."', `owner`='{$jert[id]}'  ;");
							if (mysql_affected_rows()>0)
							{
							addchp('<font color=red>��������! ��������! �������� '.$user['login'].' ������� ��� ������� �����! ������� ������ ������� �������������.</font>  ','{[]}'.$jert['login'].'{[]}',-1,$jert['id_city']);
							$bet=1;
							$sbet = 1;
							echo "��� ������ ������!";
							$MAGIC_OK=1;
						 	}
						}
			}
			else
			     {
			     err('��������  "'.$targ.'"  �� ������!');
			     }
	
}



	



?>
