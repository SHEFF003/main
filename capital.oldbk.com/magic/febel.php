<?php
		if (!($_SESSION['uid'] >0))
		{
			header("Location: index.php");
			die();
		}
		$chck=mysql_fetch_array(mysql_query('select * from effects where owner ="'.$user[id].'" AND type=4997 LIMIT 1;'));

		if($chck[id]>0)
		{
			if (date("n") == 2) {
				echo '�� �������������� � ���������...  ;)';				
			} elseif (date("n") == 3) {
				echo '�� �������������� � ���������...  ;)';
			}
		}
		else
		{
			$sql='insert into effects
			(`type`,`name`,`time`,`owner`,`add_info`)
			VALUES
			("4997","����","'.(time()+60*60*2).'","'.$user[id].'", "0.5"),
			("4998","���������","'.(time()+60*60*2).'","'.$user[id].'", "");';
			//��� 4998  ���� ����������� �������� ����� ��� � ����. ���� ������ ����� � �������� ������ �����..
            		//4997 - ������ �� �������� �����..
			mysql_query($sql);
			if(mysql_affected_rows()>0)
			{
				mysql_query('update users set `expbonus`=`expbonus`+"0.5" where id='.$user[id].';');
				
				$bet=1;
				$sbet = 1;

				if (date("n") == 2) {
			        	echo '�� ��������... ';
				} elseif (date("n") == 3) {
			        	echo '������� ��������... ';
				}
	        	}
        }
?>
