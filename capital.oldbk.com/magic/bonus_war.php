<?
if (!($_SESSION['uid'] >0)) header("Location: index.php");
if (!$user['battle'] == 0) {	echo "�� � ���..."; }
else
{
 mysql_query("UPDATE `oldbk`.`users` SET `winstbat`=`winstbat`+1000 where  `id`='".$user['id']."' ");
  if (mysql_affected_rows()>0)
 	{
		 mysql_query("Insert into ristalka set `owner`='{$user[id]}', labp=1 on DUPLICATE key update labp=1"); //������ ����
		 $out_text="�� ������������ ".link_for_magic($rowm['img'],$rowm['name'])." � �������� +1000 ������� ����� � ����� �����������.";
		 //$mag_gif='<img src=http://i.oldbk.com/i/sh/'.$rowm['img'].'>';
		 //addch($mag_gif." {$user[login]} �����������{$a} ".link_for_magic($rowm['img'],$rowm['name'])."...",$user['room'],$user['id_city']);
		 
		echo $out_text;
		addchp ('<font color=red>��������!</font> '.$out_text,'{[]}'.$user['login'].'{[]}',$user['room'],$user['id_city']);		 
		    $bet=1;
		    $sbet = 1;
	}
}



?>