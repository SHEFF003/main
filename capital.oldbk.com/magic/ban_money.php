<?php
		if (!($_SESSION['uid'] >0)) header("Location: index.php");

		$tar = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
		$target=$_POST['target'];
		if ($tar['id'])
		{

			$bantime = "";
			$bantimetxt = "";
			if (!empty($_POST['bantime'])) {
				$b = explode("-",$_POST['bantime']);
				if (count($b) == 3) {
					$bantime = ", bantime = ".(mktime(0,0,0,$b[1],$b[0],$b[2])-1);
					$bantimetxt = ", ��: ".$_POST['bantime'];
				}
			}
		
			$wmz=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`users_money`  WHERE `owner` = '{$tar['id']}' LIMIT 1;"));
			if ($wmz)
				{
				
				//���� ������
				mysql_query("UPDATE `oldbk`.`users_money` SET `ban`=1 ".$bantime." WHERE `owner`='{$tar['id']}' ; ");
					if (mysql_affected_rows()>0)
					{
					$mess = '<font color=red>'.$user['login']." ������� ��������: \"������ ������ �����\", �������: ".htmlspecialchars($_POST['reasonbl'],ENT_QUOTES).$bantimetxt.'</font>';
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
					echo "<font color=red><b>������� �������� ��������: \"������ ������ �����\" �� ���������: \"$target\"</b></font>";
					}
					else 
					{
						echo "<font color=red><b>��������� ������! � ���������  \"$target\"  ��� ���� ������!<b></font>";
					}				
				}
				else
				{
					//��� ������ ������ ������ � �����
					mysql_query("INSERT INTO `oldbk`.`users_money` SET `owner`='{$tar['id']}',`wmz`='{$tar['id']}',`ban`=1 ".$bantime);
					if (mysql_affected_rows()>0)
					{
					$mess = '<font color=red>'.$user['login']." ������� ��������: \"������ ������ �����\", �������: ".htmlspecialchars($_POST['reasonbl'],ENT_QUOTES).$bantimetxt.'</font>';
					mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$tar['id']."','$mess','".time()."');");
					echo "<font color=red><b>������� �������� ��������: \"������ ������ �����\" �� ���������: \"$target\"</b></font>";
					}
					else 
					{
						echo "<font color=red><b>��������� ������! ���������� ��� ���!<b></font>";
					}
				}
				
		}
		else 
		{
			echo "<font color=red><b>�������� \"$target\" �� ����������!<b></font>";
		}
?>
