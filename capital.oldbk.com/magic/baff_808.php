<?php
function BRedirect($path) {
	header("Location: ".$path); 
	die();
} 

function BMyDie() {
	BRedirect("fbattle.php");
}


if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
$targ=($_POST['target']);
$baff_name='������ ���������';
$baff_type=808;

if ($user['battle'] == 0) {	
	echo "��� ������ �����..."; 
} elseif($user[hp]<=0) {      
	err('��� ��� ��� �������!');        
} else {
	//if ($user[battle_t]==1)  {  $enem_t=2; 	}  else {  $enem_t=1; }
	$q = mysql_query('START TRANSACTION') or bmydie();
	$q = mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}' and battle='{$user[battle]}' and battle_t!='{$user[battle_t]}' and hp>0 FOR UPDATE") or bmydie();

	$jert = mysql_fetch_array($q);
	if ($jert[id] > 0) {
		$q = mysql_query("select * from effects where owner='{$user[id]}' and battle='{$user[battle]}' and type='{$baff_type}' ; ") or bmydie();
		$get_test_baff= mysql_fetch_array($q);
		if (($get_test_baff[id] > 0) ) {
			err('�� ��� ������������ ��� ��������, �������� ��� ���������!');
		} else {
			$q = mysql_query("select * from battle_vars where battle='{$jert[battle]}' and owner='{$jert[id]}' ;") or bmydie();
 	 		$get_var_baff= mysql_fetch_array($q);
	 		if ($get_var_baff[baf_808_use]>0) {
				err("� \"".$jert[login]."\" ��������� �� ������������� ����� �������� �� ����� ���!");			
			} else {
				//2. ���������  ������� ���� ��� � ���� ��� ������������� ��� ���������� + �������� ���� ������ � add_info
				$get_count_baff=mysql_query("select  * from effects where battle='{$user[battle]}' and type=808 and add_info='{$jert[id]}' and owner in (select id from users where battle='{$user[battle]}' and battle_t='{$user[battle_t]}' and hp >0); ") or bmydie();
				$kow=0;
				$sumpr = 0;
				while ($baff_owners = mysql_fetch_array($get_count_baff)) {
					$kow++;
					$remem_own[$kow]=$baff_owners[owner];
					$remem_time[$kow]=$baff_owners[time];
					$remem_baff_id[$kow]=$baff_owners[id];
					$sumpr += $baff_owners[lastup];
			   	}
		
				if ($kow==0) {
					//������ � �������
					mysql_query("INSERT INTO `effects` SET `type`='808',`name`='������ ������� ���������', lastup = '".$user['level']."', add_info='{$jert[id]}'  ,`time`='".(time()+60)."', `owner`='{$user[id]}',`battle`='{$user[battle]}';") or bmydie();//1 ������
					if (mysql_affected_rows()>0) {

					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }

//						addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� ��������� '.nick_in_battle($jert,$jert[battle_t]).'. <i>(����� ����...)</i> <BR>');
				       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":<i>(����� ����...)</i>\n");
						$bet=1;
						$sbet = 1;
						echo "��� ������ ������!";
						$MAGIC_OK=1;
					}
				} else if ($kow==1) {
					//���� 1 � ���������
					mysql_query("INSERT INTO `effects` SET `type`='808',`name`='����������� ������� ���������', lastup = '".$user['level']."', add_info='{$jert[id]}' ,`time`='".$remem_time[1]."',`owner`='{$user[id]}',`battle`='{$user[battle]}';") or bmydie();//����� ��������� � ������ ������
					if (mysql_affected_rows()>0) {

					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					
//						addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� ��������� '.nick_in_battle($jert,$jert[battle_t]).'. <i>(��������� ����...)</i> <BR>');
				       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":<i>(��������� ����...)</i>\n");
						$bet=1;
						$sbet = 1;
						echo "��� ������ ������!";
						$MAGIC_OK=1;
					}
				} else {
					//���� ���� � ������� � ������� ���
					//������� ������ ����
					foreach($remem_own as $ic=>$owner) {
						mysql_query("DELETE from effects where `type`='808' and owner='{$owner}' and battle='{$user[battle]}' and add_info='{$jert[id]}'  ;") or bmydie();
					}
				
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
				
					// �������� ��
					$sumpr += $user['level'];
					$sumpr = $sumpr / 100;
					$del_hp=(int)($jert[hp]*$sumpr);
	
					mysql_query("UPDATE `users` SET `hp` =`hp`- ".$del_hp."  WHERE `id` = ".$jert['id']." and hp>0 ") or bmydie();
					$jert[hp]-=$del_hp;
					// ����� ������

					if ($jert[battle_t]==1) { 
						$boec_t1[$jert[id]][hp]=$jert[hp] ;  
					} elseif ($jert[battle_t]==2) {  
						$boec_t2[$jert[id]][hp]=$jert[hp];  
					} elseif ($jert[battle_t]==3) {  
						$boec_t3[$jert[id]][hp]=$jert[hp];  
					}
					
//					addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' �����������'.$action.' �������� <b>"'.$baff_name.'"</b>, �� ��������� '.nick_in_battle($jert,$jert[battle_t]).', ������� ����� -<b><font color=red>'.((($jert[hidden]>0)and($jert[hiddenlog]==''))?"??</font></b> [??/??]":"{$del_hp}</font></b> [{$jert[hp]}/{$jert[maxhp]}]").'  <i>(������ ����...)</i> <BR>');								
			       	       addlog($user['battle'],"!:M:".time().':'.nick_new_in_battle($user).':'.($user[sex]+500).":".$baff_type.":".nick_new_in_battle($jert).":, ������� ����� -<b><font color=red>".((($jert[hidden]>0)and($jert[hiddenlog]==''))?"??</font></b> [??/??]":"{$del_hp}</font></b> [{$jert[hp]}/{$jert[maxhp]}]")."  <i>(������ ����...)</i>\n");								
					//������ ������� ������
					mysql_query("INSERT `battle_vars` (`battle`,`owner`,`update_time`,`baf_808_use`) values('".$jert['battle']."', '".$jert['id']."', '".time()."' , '1' ) ON DUPLICATE KEY UPDATE `baf_808_use` =`baf_808_use`+1;") or bmydie();

					$bet=1;
					$sbet = 1;
					echo "��� ������ ������!";
					$MAGIC_OK=1;
				}
			}			
	   	}	
	} else {
		err('����� ����� ������ "'.$targ.'"  �� ������!');
	}
	$q = mysql_query('COMMIT') or bmydie();
}       
?>
