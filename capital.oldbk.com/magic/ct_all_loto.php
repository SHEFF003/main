<?php
$us = mysql_fetch_array(mysql_query("SELECT *  FROM `users` WHERE `login` = '".mysql_real_escape_string($_POST['target'])."' LIMIT 1;"));
if ($us['id']>0)
{
if (ADMIN) {
	$travma = mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$us['id']."' AND (`type`='11' OR `type`='12' OR `type`='13' OR `type`='14');");
} else {
	$travma = mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$us['id']."' AND (`type`='11' OR `type`='12' OR `type`='13');");
}
if($user['room']==45 &&  $us['lab']>0)
{
	$us['room']=$user['room'];
}
if($user['klan']== 'radminion' || $user['klan']== 'Adminion')
{
	$us['room']=$user['room'];
	$us['ldate']=time();
}

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
} elseif ($user['in_tower'] > 0) {
	echo "�� �������� � ��...";
}
 elseif ($us['battle'] > 0) {
	echo "�������� � ���...";
} elseif ($user['room'] != $us['room']) {
	echo "�������� � ������ �������!";
} elseif ($us['ldate'] < (time()-60) ) {
	echo "�������� �� � ����!";
} else
 {

			if ($user['sex'] == 1) {$action="�������";}
			else {$action="��������";}
			if ($user['align'] > '2' && $user['align'] < '3')  {
				$angel="�����";
			}
			elseif ($user['align'] > '1' && $user['align'] < '2') {
				$angel="��������";
			}


				while ($owntravma=mysql_fetch_array($travma)) {
					deltravma($owntravma['id']);
				$c++;
				}
				if ($c ==0)
					{
					echo "� ��������� ��� �����...";
					}
				else {
				
				if ($user[hidden]>0)
				{
				$nickk='<i>���������</i>';
				$angel='';
				}
				else
				{
				$nickk=$user['login'];				
				}


				if ($us['hidden'] > 0) {
					$_POST['target'] = '<i>���������</i>';
				}

				addch("<img src=i/magic/cure3.gif> $angel &quot;{$nickk}&quot; ".$action." �� ����� &quot;{$_POST['target']}&quot;",$user['room'],$user['id_city']);
				echo "<b>��� ������ ������!</b>";
				$bet=1;
				$sbet = 1;
					}

}
 }
 else
 	{
 	echo "�������� �� ������...";
 	}
?>