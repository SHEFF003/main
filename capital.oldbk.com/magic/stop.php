<?php


if (!($_SESSION['uid'] >0)) header("Location: index.php");

// ������ ��� ������ ����� ������ ���� �� ����������� ����
$canuse = false;
$stop=false;
$rowm = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `id` = '{$_GET['use']}';"));
$magic = magicinf($rowm['magic']);
if(!$rowm[id])
{
	$stop='� ��� ��� ������ ��������.';
}

if ($user['ruines'] > 0)
{
	$map = mysql_fetch_array(mysql_query("SELECT * FROM ruines_map WHERE id = ".$user['ruines']));

	$attacktime = 60*3; // �������� �� ����

	if (($map['starttime'] + $attacktime) > time())
	{
		echo '<font color=red><b>�������� ���� ����� ������ ����� 3� ����� ������ �������.</b></font>';
	}
	else
	{
		$canuse = true;
	}
}
else
	if(($user['room']==31) || ($user['room']==60) || $user['room'] == 402)
	{
		$stop='������ ������������ ��� �����!';
	}
	else
	{
		$canuse = true;
	}


if ($canuse && !$stop)
{

	$magictime=time()+($magic['time']*60);

	$target=$_POST['target'];
	$tar = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['target']}' LIMIT 1;"));
	if (!$tar['id']) {
		$tar = mysql_fetch_array(mysql_query("SELECT * FROM `users_clons` WHERE `login` = '{$_POST['target']}' and id_user = 84;"));
		$tar['room'] = $tar['bot_room'];
	}

	if ($tar['id'])
	{
		if(($tar[klan]=='Adminion' || $tar[klan]=='radminion') and ($user[klan]!='radminion'))
		{
			$tar=$user;
			$target=$user[login];
		}

		if ($user['ruines'] > 0)
		{
			$effect = mysql_fetch_array(mysql_query("SELECT `time` FROM `effects` WHERE `owner` = '{$tar['id']}' and `type` = '10' AND `time` >= ".time()." LIMIT 1;"));
		}
		else
		{
			$effect = mysql_fetch_array(mysql_query("SELECT `time` FROM `effects` WHERE `owner` = '{$tar['id']}' and `type` = '10' LIMIT 1;"));
		}

		if ($tar['ldate'] < (time()-60) && !isset($tar['bot_room']) && $user['ruines'] == 0) {
			echo "�������� �� � ����!";
		}
		elseif ($effect['time'])
		{
			echo "<font color=red><b>�� ��������� \"$target\" ��� ���� ���� </b></font>";
		}
		else
		{

			if ($tar['room']==$user['room'])
			{
				if (mysql_query("INSERT INTO `effects` (`owner`,`name`,`time`,`type`) values ('".$tar['id']."','����','$magictime',10);"))
				{
					if ($tar[bot]==0)
					{
						//������������� ����� ��������� ��� - � ������ � ����� ���
						mysql_query("UPDATE users set odate='{$magictime}', ldate='{$magictime}' where id='{$tar['id']}'  LIMIT 1;");
					}

					$ldtarget=$target;

					if(($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
					{
						$fuser['login']='<i>���������</i>';
						$fuser['id']=$user['hidden'];
						$action="�������";
					}
					else
					{
						$fuser=load_perevopl($user); //�������� � �������� ��������� ���� ����
						if ($fuser['sex'] == 1) {$action="�������";}  else {$action="��������";}
					}

					addch("<img src=http://i.oldbk.com/i/sh/chains.gif>".link_for_user($fuser)." ����������� ����� &quot;".link_for_magic('chains.gif','����')."&quot;, �������� ".$action." ���� �� ��������� ".link_for_user($tar).".",$user['room'],$user['id_city']);

					echo "<font color=red><b>�� �������� ���� �� ��������� \"$target\"</b></font>";
					$bet=1;
					$sbet = 1;
				}
				else
				{
					echo "<font color=red><b>��������� ������!<b></font>";
				}
			}
			else
			{
				echo "<font color=red><b>�������� � ������ �������<b></font>";
			}
		}
	}
	else
	{
		echo "<font color=red><b>�������� \"$target\" �� ����������!<b></font>";
	}
}
else
{
	echo '<font color=red><b>'.$stop.'<b></font>';
}

?>
