<?
//���������� �� ���������
//��������� �� �� �� ��� �������� ����
// �� ����� ������ ��� ���� ���� ������ � ���� ����� 
//+����� ��������
	session_start();
	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
	include "connect.php";
	include "functions.php";
	if ($user['klan'] == '') {
    	die();
	}
	if ($user['in_tower'] == 1) {
	echo "�� � �����....";
    	die();
	}
	if (($user['room']>=210)AND($user['room']<299))
	{
	echo "�� � ���������....";
    	die();
	 }
	
	if ($user['ruines'] > 0)
	{
	echo "�� � ������....";
    	die();
	 }
	 
	if (($user['room'] >=197)AND($user['room'] <=199)) {
	echo "�� � ���������....";
    	die();
									}
	 
/*	if ($user['battle'] > 0) {
	echo "�� � ���....";
    	die();
	}
*/

	$klan = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
	if  ($klan['glava'] !=$user['id'] )
	{
	echo "�� �� �����...";
    	die();
	}

echo "<HTML><HEAD>";
echo "<link rel=stylesheet type=\"text/css\" href=\"http://i.oldbk.com/i/main.css\">";
echo "<meta content=\"text/html; charset=windows-1251\" http-equiv=Content-type>";
echo "<META Http-Equiv=Cache-Control Content=\"no-cache, max-age=0, must-revalidate, no-store\">";
echo "<meta http-equiv=PRAGMA content=NO-CACHE>";
echo "<META Http-Equiv=Expires Content=0>";
echo '<script type="text/javascript" src="/i/globaljs.js"></script>';
echo "<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#d7d7d7>";
$ait=(int)($_GET[it]);
echo "<center>";
echo "<h3>���������� �������� � ��������� ��������</h3>";
$item = mysql_fetch_array(mysql_query("SELECT * FROM  oldbk.`inventory` i WHERE  i.id='{$ait}' and i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner='1'  ; "));
	if ($item[id]>0)
	{
	echo "�������:<b>{$item[name]}</b><br><br>";
	//������������ ������ ���� ��� ������
	if ($_POST[onw_acc])
		{
		$add_owner=(int)($_POST[onw_acc]);
		 if ($add_owner>0)	
		 	{
		 	//��������� ����
		 	$test_telo = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.users  where id='{$add_owner}'   and klan='{$klan[short]}'  ;"));
		 	 if ($test_telo[id]>0)
		 	 	{
		 	 	//���� ����� � ����� - ��������� ��� � �������
		 	 	mysql_query("INSERT INTO `oldbk`.`clans_arsenal_access` SET `item`='{$item[id]}',`klan_id`='{$klan[id]}',`klan_name`='{$klan[short]}',`owner`='{$test_telo[id]}',`owner_login`='{$test_telo[login]}' ON DUPLICATE KEY UPDATE `klan_id`='{$klan[id]}',`klan_name`='{$klan[short]}',`owner`='{$test_telo[id]}',`owner_login`='{$test_telo[login]}'  ;");
		 	 	//� ������ �������  ������ �����
		 	 	mysql_query("update oldbk.clans_arsenal set all_access=0 where id_inventory ='{$item[id]}' and  klan_name='{$klan[short]}' and owner_original=1 and owner_current=0;");
		 	 	
		 	 	}
		 	 	else
		 	 	{
		 	 	err('�������� � ����� ����� �� ������!');
		 	 	}
		 	
		 	}
		}
		else if ($_GET[del])
			{
			$del_owner=(int)($_GET[del]);
			mysql_query("DELETE FROM oldbk.`clans_arsenal_access` WHERE `item`='{$item[id]}' AND `owner`='{$del_owner}' and `klan_id`='{$klan[id]}' ;");
			}
	
	
	
	
	//��������� ������� � ��������
	echo "<table border=0 width=80%>";
		$rr=1;
			$dataaccess = mysql_query("SELECT * from oldbk.clans_arsenal_access where klan_id='{$klan[id]}' and item='{$item[id]}' ;");
			while($rowaccess= mysql_fetch_array($dataaccess)) 
				{
				echo "<tr width=500 "; 
				if ($ff==0)  {	$ff = 1; echo "bgcolor='#C7C7C7' " ; } 	else { 	$ff = 0; echo "bgcolor='#E1E1E3' " ;  }				
				echo ">";
				echo "<td align=center>";
				echo "<b>$rowaccess[owner_login]</b>";
				echo "</td>";				
				echo "<td align=center><a href=?it={$item[id]}&del={$rowaccess[owner]}>�������</a> </td>";
				echo "</tr>";
				}
	echo "</table>";	
		echo "<br><form method=post>";	
		echo "<select size='1' name='onw_acc'><option value=0>�������� ����������</option>";
		 $sql_klan=mysql_query("SELECT * FROM oldbk.users  where klan='{$klan[short]}' ;");
	        while($kl=mysql_fetch_array($sql_klan))
        	{
	        echo "<option value=".$kl[id]."  >".$kl[login]."</option>";
        	}
		echo "</select>";
		
		echo "<input type=submit name=add_acc value='��������'>";
		echo "<br><br><input type=button value='�������' OnClick=\"window.close();\">";
		echo "</form>";			
	
	
	}
	else
	{
	err('������� �� ������!');
	}
echo "</center>";
echo "</body>";
echo "</html>";
?>

