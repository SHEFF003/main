<?php

$us = mysql_fetch_array(mysql_query("SELECT *  FROM `users` WHERE `login` = '".mysql_real_escape_string($_POST['target'])."' LIMIT 1;"));
if ($us['id']>0)
{
$owntravma = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = ".$us['id']." AND `type`=11;"));
$magic = magicinf(19);
if($user['room']==45 &&  $us['lab']>0)
{
	$us['room']=$user['room'];
}
if ($user['intel'] >= 4) {
		$int=$magic['chanse'] + ($user['intel'] - 4)*3;
		$int = $int * 0.95; //8/08/2012 - ���+����� ������ ���������		
		if ($int>98){$int=99;}
	}
else {$int=0;}

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
} elseif (!$owntravma['id']) {
	echo "� ��������� ��� ������ �����...";
} elseif ($user['room'] != $us['room']) {
	echo "�������� � ������ �������!";
} elseif ($us['ldate'] < (time()-60) ) {
	echo "�������� �� � ����!";
} elseif (rand(1,100) < $int) {

			if ($user['sex'] == 1) 
			{$action="�������";}
			else 
			{$action="��������";}
			
			
			if (($user['align'] > '2' && $user['align'] < '3') && $user['align'] != '2.4')  {
				$angel="�����";
			}
			elseif ($user['align'] > '1' && $user['align'] < '2') {
				$angel="��������";
			}
			
			$bet=1;
			$sbet = 1;			
			echo "�������� &quot;{$_POST['target']}&quot; �������!";
// hidden by fred

			
			if ($owntravma['type'] == 12) 
			{
				$travm="�������";
			}
			else
			if ($owntravma['type'] == 11)
			{
				$travm="������";
			}
			else
			if($owntravma['type'] == 13)
			{
				$travm="�������";
			}
			deltravma($owntravma['id']);
		


			if($user[hidden]>0)
			 {
				if($us[hidden]>0) {
				addch("<img src=i/magic/cure1.gif> ".$angel." &quot;<i>���������</i>&quot; ".$action." �� {$travm} ����� &quot;<i>���������</i>&quot;",$user['room'],$user['id_city']);
				addchp ("<font color=red>��������!</font> ��� ".$action." ".$angel." &quot;<i>���������</i>&quot;  �� {$travm} �����","{[]}".$us['login']."{[]}",$user['room'],$user['id_city']); 

				} else {
				addch("<img src=i/magic/cure1.gif> ".$angel." &quot;<i>���������</i>&quot; ".$action." �� {$travm} ����� &quot;{$_POST['target']}&quot;",$user['room'],$user['id_city']);
				addchp ("<font color=red>��������!</font> ��� ".$action." ".$angel." &quot;<i>���������</i>&quot;  �� {$travm} ����� ","{[]}".$us['login']."{[]}",$user['room'],$user['id_city']); 
			
				}
			}
			else
			{
				if($us[hidden]>0) {
				addch("<img src=i/magic/cure1.gif> ".$angel." &quot;{$user['login']}&quot; ".$action." �� {$travm} ����� &quot;<i>���������</i>&quot;",$user['room'],$user['id_city']);
				} else {
				addch("<img src=i/magic/cure1.gif> ".$angel." &quot;{$user['login']}&quot; ".$action." �� {$travm} ����� &quot;{$_POST['target']}&quot;",$user['room'],$user['id_city']);
				}
				addchp ("<font color=red>��������!</font> ��� ".$action." ".$angel." &quot;{$user['login']}&quot;  �� {$travm} ����� ","{[]}".$us['login']."{[]}",$user['room'],$user['id_city']); 
			}
			
			
			if($us['id'] != $user['id'] && !$_SESSION['beginer_quest'][none]) 
			{				
				// �����
			        $last_q=check_last_quest(30);
			        if($last_q) 
				{
					quest_check_type_30($last_q,$user[id],3,1);
				}
			      
			}

				deltravma($owntravma['id']);

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
