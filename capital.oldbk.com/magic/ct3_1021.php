<?php

$us = mysql_fetch_array(mysql_query("SELECT *  FROM `users` WHERE `login` = '".mysql_real_escape_string($_POST['target'])."' LIMIT 1;"));
if ($us['id']>0)
{
$owntravmadb = mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$us['id']." AND (`type`=12 OR `type`=11 OR `type`=13) ;");
$ownt = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$us['id']." AND (`type`=12 OR `type`=11 OR `type`=13) LIMIT 1 ;"));
$magic = magicinf(21);
 if($user['room']==45 &&  $us['lab']>0)
{
	$us['room']=$user['room'];
}

$int=101;

if($user['id'] == '188' || $user['klan'] == 'radminion') {$int = 101;}

if ($us['id']!=$user['id'])
	{
	//���� ����� �� ���� - ����� ��������
	if (test_lic_med($user))
		{
		$lic_lek=true;
		}
		else
		{
		$lic_lek=false;
		}
	}
	else
	{
	$lic_lek=true;
	}

if ($lic_lek==false)
{
	echo "��� ������� ������ ���������� ���������� �������� ������...";
}
else
if ($user['battle'] > 0) {
	echo "�� � ���...";
} elseif ($us['battle'] > 0) {
	echo "�������� � ���...";
} elseif (!$ownt['type']) {
	echo "� ��������� ��� �������, ������� ��� ������ �����...";
} elseif ($user['room'] != $us['room']) {
	echo "�������� � ������ �������!";
} elseif ($us['ldate'] < (time()-60) ) {
	echo "�������� �� � ����!";
} elseif (rand(1,100) < $int) {

			if ($user['sex'] == 1) {$action="�������";}
			else {$action="��������";}
			if (($user['align'] > '2' && $user['align'] < '3') && $user['align'] != '2.4')  {
				$angel="�����";
			}
			elseif ($user['align'] > '1' && $user['align'] < '2') {
				$angel="��������";
			}

			$travm="������";
			$tt = 11;
			$bet=1;
			$sbet = 1;
			while ($owntravma = mysql_fetch_array($owntravmadb)) {
				if ($owntravma['type'] > $tt) {
					$tt = $owntravma['type'];
				}
				deltravma($owntravma['id']);
			}
			echo "�������� &quot;{$_POST['target']}&quot; �������!";

			if ($tt == 11) $travm = "������";
			if ($tt == 12) $travm = "�������";
			if ($tt == 13) $travm = "������";
// hidden by fred

		if($user[hidden]>0)
		 {
				if($us[hidden]>0) {
				addch("<img src=i/magic/cure3.gif> ".$angel." &quot;<i>���������</i>&quot; ".$action." �� {$travm} ����� &quot;<i>���������</i>&quot;",$user['room'],$user['id_city']);
				} else {
				addch("<img src=i/magic/cure3.gif> ".$angel." &quot;<i>���������</i>&quot; ".$action." �� {$travm} ����� &quot;{$_POST['target']}&quot;");
				}
}
else
{
				if($us[hidden]>0) {
				addch("<img src=i/magic/cure3.gif> ".$angel." &quot;{$user['login']}&quot; ".$action." �� {$travm} ����� &quot;<i>���������</i>&quot;",$user['room'],$user['id_city']);
				} else {
				addch("<img src=i/magic/cure3.gif> ".$angel." &quot;{$user['login']}&quot; ".$action." �� {$travm} ����� &quot;{$_POST['target']}&quot;",$user['room'],$user['id_city']);
				}
}
	 		
} else {
	echo "������ ���������� � ����� �����...";
	$bet=1;
}
 }
 else
 	{
 	echo "�������� �� ������...";
 	}
?>
