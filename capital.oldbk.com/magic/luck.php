<?php
$us = mysql_fetch_array(mysql_query("SELECT *  FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));		

			if ($user['sex'] == 1) {$action="�����������";}
			else {$action="������������";}		
			if ($user['align'] > '2' && $user['align'] < '3')  {
				$angel="�����";
			}
			elseif ($user['align'] > '1' && $user['align'] < '2') {
				$angel="��������";
			}
			
				addch("<img src=i/magic/spell_luck.gif> ".$angel." &quot;{$user['login']}&quot; ".$action." &quot;{$_POST['target']}&quot;",$us['room'],$us['id_city']);
				//deltravma($owntravma['id']);
				//echo "<font color=red><b>�� ��������� \"{$_POST['target']}\" �������� �������� �������� </b></font>";			
				$bet=1;
				$sbet = 1;

?>