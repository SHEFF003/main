<?php
if (!($_SESSION['uid'] >0))  { header("Location: index.php"); die();}
$baff_name='����� ��������';
				$effect = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user[id]}' and `type` = '2' and pal=0 LIMIT 1;"));
				if ($effect['time'])
				{
					mysql_query("DELETE FROM`effects` WHERE `owner` = '{$user['id']}' and `type` = '2' and pal=0 ;");
					if (mysql_affected_rows()>0)
						{

							$qtype2 = mysql_query('SELECT * FROM effects WHERE type = 2 and owner = '.$effect['owner']);
							if (mysql_num_rows($qtype2) == 0) {
								mysql_query("UPDATE users set slp=0 where id='{$user[id]}' ; ");
							}


						
							 $mag_gif='<img src=i/magic/sleep_off.gif>';
							 if(($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
							 {
							 $fuser['login']='<i>���������</i>';
							 $sexi='�����������';
							 }
							 else
						 	{
							 $fuser=load_perevopl($user); //�������� � �������� ��������� ���� ����
							 if ($fuser['sex'] == 1) {$sexi='�����������';  }	else { $sexi='������������';}
							 }
				
						addch($mag_gif." <B>{$fuser['login']}</B>, ����������� ����� &quot;".$baff_name."&quot;",$user['room'],$user['id_city']);
						$bet=1;
						$sbet = 1;
						echo "��� ������ ������!";
						$MAGIC_OK=1;
						}
						else 
						{
						err('��������� ������!');
						}
					
				}
				else 
				{
					err("�� ��� ��� �������� ��������(��������)");
				}

?>
