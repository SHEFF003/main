<?php
if (!($_SESSION['uid'] >0)) header("Location: index.php");

if ($_GET['clearstored']!=1)
{
if ($user['battle'] > 0) {
	echo "�� � ���...";
} 
else
if (($user['lab'] ==0 ) OR ($user['lab'] ==1 ))
	{
	echo "<font color=red>����� ������������ ������ � ����������� ��� ����������� ���������...</font>";
	}
else
	{
	$target=explode("-",$_POST['target']);
	$X=(int)($target[0]);
	$Y=(int)($target[1]);
	
	$usr_map = mysql_fetch_array(mysql_query("select * from labirint_users where owner='{$user['id']}' "));
	$mapa=$usr_map['map'];
	
	$chpoint= mysql_fetch_array(mysql_query("select * from labirint_items where map='{$mapa}' and item='T' and x='{$X}' and y='{$Y}'  and (owner='{$user['id']}' or owner=0 )  LIMIT 1;"));
	//$svitok = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `name` = '�������� ���������' AND `owner` = '{$user['id']}' LIMIT 1;"));
	if ($chpoint[map]>0)
	{
	   
	   
		if (mysql_query("UPDATE labirint_users SET `x` ='{$X}', `y`='{$Y}' WHERE  `map`='{$mapa}' and `owner` = {$user[id]} LIMIT 1;"))
			{
			
				//������� ���������
				if (($chpoint['val']==1) and ($chpoint['owner']==$user['id']))
					{
					mysql_query("DELETE from labirint_items where map='{$mapa}' and item='T' and x='{$X}' and y='{$Y}'  and  owner='{$user['id']}' and val =1");
					}
				
			
			echo "<font color=red>������ ������������: <i>�������� ���������</i>...</font>";
			if ($user[sex]==1) { $sexi='�����������'; } else { $sexi='������������'; }
			addch("<img src=i/magic/labteleport.gif> {$user[login]} ".$sexi." <i>�������� ���������</i>",$user['room'],$user['id_city']);
			$bet=1;
			$sbet = 1;
			}
			else {
				echo "<font color=red><b>��������� ������!<b></font>";
			}

	   
	   
	}
	else
	{
	echo "<font color=red><b>������������ ���������� ������� <b></font>";
	}

}
}
?>