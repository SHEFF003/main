<?php
if (!($_SESSION['uid'] >0)) header("Location: index.php");
$ust=(int)($_POST['target']);

if ($user['battle']>0) 
{ 
	echo "�������� ��������� � ��������!"; 
} elseif ($ust==$user['smagic'] )
{
	echo "� ��� ��� ����������� ����� ������! "; 
} elseif (($ust>=1) and ($ust<=4) )
{
		$st[1]='����';
		$st[2]='�����';
		$st[3]='�������';
		$st[4]='����';
		
				$abil[1]=5007152; //����  1; // �����
				$abil[2]=5007154; //������ ���� wrath_ground   2  ����� 
				$abil[3]=5007153; //����������/ wrath_air 3; //������ (����, ������
				$abil[4]=5007155; //���������� ����	wrath_water  4; //���� 
		
	mysql_query("UPDATE `users` SET `smagic`='{$ust}' WHERE `id`='{$user['id']}' ");
	if (mysql_affected_rows()>0)
		{
			if (($user['prem']==3) )
				{
				//�������
					//��������� ������
					$get_mag_abil=mysql_query("select * from  `oldbk`.`users_abils`  where `owner`='{$user['id']}' and `magic_id` in (5007152,5007154,5007153,5007155) ");
					while ($row = mysql_fetch_array($get_mag_abil)) 
					{
						$new_row['allcount']+=$row['allcount'];
						$new_row['dailyc']+=$row['dailyc'];						
						$new_row['daily']+=$row['daily'];												
					}
					//print_r($new_row);
					//������� ��� ����
					mysql_query("DELETE from `oldbk`.`users_abils`  where `owner`='{$user['id']}' and `magic_id` in (5007152,5007154,5007153,5007155) ");
			
					//��������� ����� ���  � ����� ����������
					mysql_query("INSERT INTO `oldbk`.`users_abils` SET `owner`='{$user[id]}',`magic_id`='{$abil[$ust]}', `allcount`='{$new_row['allcount']}' ,`dailyc`='{$new_row['dailyc']}',`daily`='{$new_row['daily']}';");
					
					
				}
			
			echo "��� ������ ������! �� ���������� ������ <b>".$st[$ust]."</b>! ";
			$bet=1;
			$sbet = 1;
		}
}
?>