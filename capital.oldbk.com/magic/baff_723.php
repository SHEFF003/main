<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$targ=($_POST['target']);

$sub_name[3]='�������';
$sub_name[2]='������������';
$sub_name[6]='��������';
$get_align=(int)($user[align]);
if ($get_align==1) {$get_align=6;}

$baff_name='������ '.$sub_name[$get_align].' �������';
$baff_type=723;

if ($user['battle'] >0) {	
	echo "��� �� ������ �����..."; 
} elseif ($user['in_tower']) {
	echo "��� ��� ������������ ������..."; 
} else {
	
		$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}' and battle>0  and hp>0   LIMIT 1;"));
	
		if ($jert[id] >0)
		{
			
			$q = mysql_query("SELECT * FROM battle WHERE id = ".$jert['battle']);
			$bd = mysql_fetch_assoc($q);
			if ($bd['type'] == 40 || $bd['type'] == 41 || $bd['type'] == 61 || $bd['type'] == 100 || $bd['type'] == 101) 
			{
				err("������ ������� � ���� ��� � ������� ���� ������...");
				return;
			}
	
			$get_jert_align=(int)($jert[align]);
			if ($get_jert_align==1) {$get_jert_align=6;}
		
		 	if ($get_align==$get_jert_align)		
			{	
				//��������� ������� �� ��������
				// �������� � ��� ����, ���� ������ ������ ������� ���� � ���� �������� ��� ���� ������ �� ���� ������� �� ������� ������
				$get_dbat=mysql_fetch_array(mysql_query("select count(id) as kol  from users where battle='{$jert[battle]}' and ( ( get_align(align)='{$get_align}' and battle_t!='{$jert[battle_t]}') OR ( get_align(align)!='{$get_align}' and battle_t='{$jert[battle_t]}') )"));
				
				if ($get_dbat[0]>0)
				{
					err('�� �� ������ ������� � ��� ���� ���������!');
				}
				else
				{	
					$zastup=true;
					include('helpbatl.php');
					
					if ($sbet==1)
					{
						//��������� ������ �� ��� ���� - ��� ����� ��������
						mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}',`time`=1999999999,`owner`='{$user[id]}',`lastup`=3,`battle`='{$jert[battle]}';");
						
						if ($user[hidden]>0 and $user[hiddenlog]=='') { $action = ""; }
						elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user);  if ($fuser[sex]==0) {$action="�"; } else {$action="";} }
						elseif ($user['sex'] == 1) {$action=""; }
						else { $action="�"; }
						
						$bet=1;
						$sbet = 1;
						echo "��� ������ ������!";
						$MAGIC_OK=1;
					}
				}
				
			}
			else
			{
		     	err('��������  "'.$targ.'"  ��� �� ������!');		
			}	
		}
		else
		{
			err('��������  "'.$targ.'"  �� � ��� ��� ��� �����!');
		}


	} 
	


?>
