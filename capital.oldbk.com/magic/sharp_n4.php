<?php
if ($_POST['target']!='')
{
$need_str[1]='������� �� ����';
$need_str[11]='������� �� ������';
$need_str[12]='������� ��  ������,������';
$need_str[13]='������� ��  ����';

if ($user['battle'] > 0) {
	echo "�� � ���...";
} else	{
	if ($user['intel'] >= 4) {
		$int=81 + $user['intel'] - 4;
		if ($int>100){$int=100;}
	}
	else {$int=0;}
	if (rand(1,100) < $int) {

		if (!($_SESSION['uid'] >0)) header("Location: index.php");

		$dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE naem = 0 and present!='�������� �����' AND `setsale`=0 AND `bs_owner`='{$user[in_tower]}' AND (arsenal_klan = '' OR arsenal_owner=1 ) AND `owner` = '{$user['id']}' AND `id` = '{$_POST['target']}' AND `sharped` = 0 and gmeshok = 0 LIMIT 1;"));
		$svitok = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `name` = '������� �� ���� +4' AND `setsale`=0 AND `bs_owner`='{$user[in_tower]}' AND (arsenal_klan = '' OR arsenal_owner=1 )  AND  `owner` = '{$user['id']}' LIMIT 1;"));


		if (($dress[otdel]==1) && $svitok) 
		{
			if (mysql_query("UPDATE oldbk.`inventory` SET `sharped` = 1, `name` = CONCAT(`name`,'+4'), `minu` = `minu`+4, `maxu`=`maxu`+4, `cost` = `cost`+24, `nnoj` = `nnoj`+4, `ninta` = `ninta`+4 WHERE `id` = {$dress['id']} LIMIT 1;")) {
				echo "<font color=red><b>������� \"{$dress['name']}\" ������ ������� +4.<b></font> ";
				$bet=1;
				$sbet = 1;
				if(!$_SESSION['beginer_quest'][none]) 
				{				
					// �����
				        $last_q=check_last_quest(30);
				        if($last_q) 
					{
						quest_check_type_30($last_q,$user[id],6,1);
					}
				      
				}
			}
			else {
				echo "<font color=red><b>��������� ������!<b></font>";
			}
		} 
		else if ($need_str[$dress[otdel]]!='')
			{
			//����� ������ ����� 
			echo "<font color=red><b>��� ����� ������ ��������� ������ \"{$need_str[$dress[otdel]]}\"<b></font>";			
			}
		else {
			echo "<font color=red><b>������������ ��� �������� ��� ������������ ������<b></font>";
		}
	} else
	{
		echo "<font color=red><b>��������...<b></font>";
		$bet=1;
	}
}
}
?>