<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

if($magic[id]==22228)
{
	$_POST['target']=$user[login];
}

$target=mysql_fetch_array(mysql_query('select * from users where login = "'.$_POST['target'].'"'));


if ($user['battle'] > 0) 
{	
	echo "��� �� ������ �����..."; 
}
else
if($target[id]==$user[id] && $magic[id]!=22228)
{
	echo "��� ������ ������������ �� ����..."; 
}
else
if(($target['klan'] == 'radminion' || ($target['align'] > '2' && $target['align'] < '3')) && $user['klan'] != 'radminion')
{
	echo "�� ����� ��� ������..."; 
}
else
if($target[odate]<time()-60)
{
	echo '<font color=red><b>��������� ��� � �����</b></font>';
}
else
if($target[room]!=$user[room])
{
	echo '<font color=red><b>�������� � ������ �������</b></font>';
}
else 
{
	
	$get_test_prikol= mysql_fetch_array(mysql_query("select * from effects where owner='".$target[id]."' and type in (22223,22224,22225,22226,22227,22228); "));
	
	if($magic[id]==22228 && $get_test_prikol[id]>0 && $get_test_prikol[type]!=22228)
	{
		
		mysql_query("DELETE from effects WHERE owner='".$user[id]."' AND type in (22223,22224,22225,22226,22227,22228)");
		if(mysql_affected_rows()>0)
		{
			mysql_query("INSERT INTO `effects` SET `type`='".$magic[id]."', `name`='".$magic[name]."', `time`='".(time()+30*60)."', `owner`='".$user[id]."' ");//30 �����
			if (mysql_affected_rows()>0)
			{
				$bet=1;
				$sbet = 1;
				echo "�� ������ ������������ ".$magic[name];
				$MAGIC_OK=1;
			}
		}
		//������ + ������
	}
	else
	{
		
		if (($get_test_prikol[id] > 0) )
		{
			echo '<font color=red><b>�� ��������� '.$target[login].' ��� ������������ ������� �������� ��� ������� ������. ���������� �����</b></font>';	
		}
		else
		{
			if($magic[id]==22223)
			{
				$sql=", add_info='".$user[login]."'";
			}
			mysql_query("INSERT INTO `effects` SET `type`='".$magic[id]."', `name`='".$magic[name]."', `time`='".(time()+30*60)."', `owner`='".$target[id]."' ".$sql);//30 �����
			if (mysql_affected_rows()>0)
			{
				if ($user[hidden]>0 and $user[hiddenlog]=='') { $action = ""; }
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user);  if ($fuser[sex]==0) {$action="�"; } else {$action="";} }
				elseif ($user['sex'] == 1) {$action=""; }
				else { $action="�"; }
				
				addch("<img src=http://i.oldbk.com/i/magic/1april_item_".$magic[id].".gif> ".$user[login]." ����������� ".$magic[name]." �� ".$target[login] ,$user['room'],$user['id_city']);
				
				$bet=1;
				$sbet = 1;
				echo "�� ������ ������������ ".$magic[name];
				$MAGIC_OK=1;
			}	
		}
	}	
} 

unset($target);



?>
