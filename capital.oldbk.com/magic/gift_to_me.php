<?
if (!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0) {
	header("Location: index.php");
	die();
}


	if($rowm['present']=='')
		{
							$rowm['duration']=-1; // �������� ���� �� ���������
							mysql_query("UPDATE oldbk.`inventory` SET duration=-1, maxdur=1, `present`='������', magic=0 , add_time='".time()."'  WHERE `id` = {$rowm['id']} LIMIT 1;");
							if (mysql_affected_rows() > 0) 	
								{
								echo "��� ������ ������! ������� ����� ��������� ��� � ������� ������.";
								$sbet = 1;
								$bet = 1;
								}
		}
		else
			{
				echo "���� ������� ��� ��� �������!";
			}

?>