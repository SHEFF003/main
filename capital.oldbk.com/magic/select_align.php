<?php
if (!($_SESSION['uid'] >0)) {
	header("Location: index.php");
	die();
}
$ust=(int)($_POST['target']);
$ual=(int)$user['align'];

$eff_align_type=5001;
$eff_align_time=time()+60*60*24*30*2;

$st[2]='�����������';
$st[3]='������';
$st[6]='�������';

if ($ust==$ual)
{
	err("�����?");
	return;
}
else
if (($ust==2) or ($ust==3) or ($ust==6))
	{
		if ($user['battle'] > 0) {
			err("�� � ���...");
			return;
		} 
		
		
		
		if ($user['klan']!='') {
			err("������ ������������ �������� � �����!");
			return;
		}

		if ($user['align']==4) {
			err("������ ������������, �������� � �����!");
			return;
		}		

		
		
		
		mysql_query("UPDATE `oldbk`.`users` SET `align`='{$ust}' WHERE `id`='{$user['id']}' ");
		if (mysql_affected_rows()>0)
				{
					
						$cheff=mysql_fetch_array(mysql_query("SELECT * from  effects WHERE type = '".$eff_align_type."' AND owner = '".$user['id']."' LIMIT 1;"));
						if ($cheff['id']>0)
							{
							//������� �� ��� ����!
							mysql_query("DELETE from  effects WHERE id='{$cheff['id']}' LIMIT 1; ");
							//����� ���� � �����
							//���������� ������ �������
							mysql_query("INSERT INTO users_last_align (`owner`,`align`) VALUES      ('".$user['id']."','".$cheff['add_info']."')	ON DUPLICATE KEY UPDATE align='".$cheff['add_info']."';");
							}

							//����� ����� �������
							$sql="INSERT INTO effects (`type`, `name`, `owner`, `time`, `add_info`)  VALUES  ('".$eff_align_type."','����� �������','".$user['id']."','".$eff_align_time."','".$ust."');";
							mysql_query($sql);
							
						
				
				echo "��� ������ ������! �� �������� <b>".$st[$ust]." ����������</b>! ";
				$bet=1;
				$sbet = 1;
				}
				else
				{
				echo "���-�� ����� �� ���!";
				}

	}

?>