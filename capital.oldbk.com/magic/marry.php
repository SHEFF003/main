<?php
// magic �������������
	//if (rand(1,2)==1) {


		if (!($_SESSION['uid'] >0)) header("Location: index.php");

		$m = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`married`,`sex`,`login` FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
		$w = mysql_fetch_array(mysql_query("SELECT `id`,`align`,`married`,`sex`,`login` FROM `users` WHERE `login` = '{$_POST['target1']}' LIMIT 1;"));
		
			
		

		$muzh=$_POST['target'];
		$zhena=$_POST['target1'];
		if ($m['id'] and $w['id']) 
		{
			$m=check_users_city_data($m[id]);
			$w=check_users_city_data($w[id]);
			if($m[id_city]==$user[id_city] && $w[id_city]==$user[id_city])
			{
				if ($m['married']) {
					echo "<font color=red><b>�������� ".$_POST['target']." ��� ������� � �����!<b></font>";
				}
				elseif ($w['married']) {
					echo "<font color=red><b>�������� ".$_POST['target1']." ��� ������� � �����!<b></font>";
				}
				elseif ($m['sex'] != 1) {
					echo "<font color=red><b>������������ ��� ������!<b></font>";
				}
				elseif ($w['sex'] != 0) {
					echo "<font color=red><b>������������ ��� �������!<b></font>";
				}
				else {
					if ((($user['align'] > '2' && $user['align'] < '3') || ($user['align'] > '1.4' && $user['align'] < '2')) && $moj[$_POST['use']]==1) {
						if (mysql_query("UPDATE `users` SET `married`='{$w['id']}' WHERE `id` = '{$m['id']}' LIMIT 1;") && mysql_query("UPDATE `users` SET `married`='{$m['id']}' WHERE `id` = '{$w['id']}' LIMIT 1;")) 
						{
							
							$i=0;
							$y=0;
						 	$sql=mysql_query("select * from users where room = '".$user[room]."' AND married='' AND odate > ".(time()-60).";");
							while($in_room=mysql_fetch_array($sql))
							{
								if($in_room[sex]==0)
								{
									$uu[0][$i]=$in_room;
									$i++;
								}
								else
								{
									$uu[1][$y]=$in_room;
									$y++;
								}				
							}
							
							foreach($uu[1] as $k=>$v)
							{
								// ��� ����� �������� ���� �������� ��������
								/*
								if($v[id]==14284)
								{
								//�������� �������� =)))
									$exist=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory where owner = 14284 AND prototype=12376"));
									if($exist[id]>0)
									{
									
									}
									else
									{
										$mm=$uu[1][$k];
										$m_stop=1;
									}
								}*/
							}
							
							
							$gg=$uu[0][mt_rand(0,($i-1))];
							if($m_stop==1)
							{
							}
							else
							{
								$mm=$uu[1][mt_rand(0,($y-1))];
							}

							if ($mm['id'] > 0) {
								mysql_query("insert into oldbk.inventory (name,maxdur,cost,owner,img,`type`,massa,letter,prototype,otdel,add_time,present) values
								('�������� �� ������',1,20,'".$mm[id]."','sv_podv.gif',200,0.1,'������� �� ������� ". $m[login] . " � ".$w[login] . " ".(date('d-m-Y',time()))."',12376,'72',".time().",'".$muzh."')");
							}
							
							if ($gg['id'] > 0) {						
								mysql_query("insert into oldbk.inventory 
								(name,maxdur,cost,owner,img,`type`,massa,letter,prototype,otdel,add_time,present) values
								('����� �������',1,20,'".$gg[id]."','sv_flow.gif','200','0.1','������ �� ������� ". $m[login] . " � ".$w[login] . " ".(date('d-m-Y',time()))."','12377','72',".time().",'".$zhena."')");
							}
							
							
							if($mm[login])
							{
								addch("<img src=i/magic/sv_podv.gif> <B>".$mm[login]."</B> ������ ��������.",$user['room'],$user['id_city']);
							}
							
							if($gg[login])
							{
								addch("<img src=i/magic/sv_flow.gif> <B>".$gg[login]."</B> ������� �����.",$user['room'],$user['id_city']);
							}
	
							$mess="����������� ����� ����� &quot;$muzh&quot; � &quot;$zhena&quot;, ����������� &quot;{$user['login']}&quot;.";
							
							mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$m['id']."','$mess','".time()."');");
							mysql_query("INSERT INTO oldbk.`lichka`(`id`,`pers`,`text`,`date`) VALUES ('','".$w['id']."','$mess','".time()."');");
							mysql_query("INSERT INTO oldbk.`paldelo`(`id`,`author`,`text`,`date`,`m_type`) VALUES ('','".$_SESSION['uid']."','$mess','".time()."','3');");
							echo "<font color=red><b>������� ��������������� ���� ����� \"$muzh\" � \"$zhena\"!</b></font>";
						}
						else 
						{
							echo "<font color=red><b>��������� ������!<b></font>";
						}
					}
					else {
						echo "<font color=red><b>�� �� ������ ���������������� ����!<b></font>";
					}
				}
			}	
			else
			{
				echo "<font color=red><b>��������(�) \"$target\" � ������ ������!<b></font>";
			}	
		}
		else 
		{
			echo "<font color=red><b>�������� \"$muzh\" ��� \"$zhena\" �� ����������!<b></font>";
		}
?>
