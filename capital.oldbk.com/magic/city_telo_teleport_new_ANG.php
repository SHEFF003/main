<?
if (!($_SESSION['uid'] >0)) {  header("Location: index.php"); die(); }

if ($user['klan'] != "radminion") {
	echo "<font color=red>����� �������� �� ��������!</font>";
	return;
}


$telo=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$_POST['target']}'  LIMIT 1;"));

if  ( (($user[battle]!=0) OR ($user[battle_fin]!=0))  OR (($telo[battle]!=0) OR ($telo[battle_fin]!=0)) )
{
echo "<font color=red>�� � ���!</font>";
}
elseif ($telo[login]==$user[login])
{
$_POST['target']=$_POST['city'];
include('city_teleport.php');

}
elseif ($user[zayavka]>0)
{
echo "<font color=red>�� � ������!</font>";
}
elseif ($user[id_city]!=$telo[id_city])
{
echo "<font color=red>���� � ������ ������!</font>";
}
elseif ($telo[bot]!=0)
{
echo "<font color=red>��� ������ ���������!</font>";
}
elseif ($telo[zayavka]>0)
{
echo "<font color=red>���� � ������!</font>";
}
elseif (!($telo[id]>0))
{
echo "<font color=red>�������� �� ������!</font>";
}
elseif ($telo['ldate'] < (time()-60) ) {
	echo "�������� �� � ����!";
} elseif ($telo['hidden'] > 0) {
	echo "�������� �� � ����!";
}
elseif ( 2==1)
{
echo "<font color=red>�������� ������, ���������� �����...</font>";
}
elseif ((( ($user[room]!=20) AND ($user[room]!=21) AND ($user[room]!=66) AND ($user[room]!=26) AND ($user[room]!=50))) and ($user[klan]!='radminion') and ($user[klan]!='Adminion') )
{
echo "<font color=red>������������ �������� ����� ������ �� ����� ��� �������!</font>"; 
}
elseif($user[room]!=$telo[room])
{
echo "<font color=red>�������� � ������ �������!</font>";
}
elseif($user[id_city]!=$telo[id_city])
{
echo "<font color=red>�������� � ������ ������!</font>";
}

else
//id_city=0-��� / 1-������
if ( (strtolower($_POST['city'])=='capital') OR ( strtolower($_POST['city'])=='capitalcity') OR ( strtolower($_POST['city'])=='cap') ) 
	{
	$rowm=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE id = ".$rowm[id]." limit 1 "));
	
		if ($telo[id_city]!=0)
		{
		
		// �������� ������
		$bonus = array();
		$q = mysql_query('SELECT * FROM users_bonus WHERE owner = '.$telo['id']);
		while($b = mysql_fetch_assoc($q)) {
			$bonus[] = $b;
		}
		
		mysql_query('DELETE from users_bonus where owner='.$telo['id'].';');
		//�����������
		$sexi[0]='�';$sexi[1]='';
		//echo "��������...";

		mysql_query("UPDATE users set odate=0 , id_city=0 where id={$telo[id]} and id_city!=0 and battle = 0;");

		if (mysql_affected_rows()>0)
		{

		// ���������
		while(list($k,$v) = each($bonus)) 
		{
			mysql_query('
			INSERT INTO oldbk.users_bonus (owner,sila,sila_count,lovk,lovk_count,inta,inta_count,intel,intel_count,mudra,mudra_count,maxhp,maxhp_count,expbonus,expbonus_count,refresh,battle,usec) 
			VALUES ("'.$v['owner'].'","'.$v['sila'].'","'.$v['sila_count'].'","'.$v['lovk'].'","'.$v['lovk_count'].'","'.$v['inta'].'","'.$v['inta_count'].'","'.$v['intel'].'","'.$v['intel_count'].'","'.$v['mudra'].'","'.$v['mudra_count'].'","'.$v['maxhp'].'","'.$v['maxhp_count'].'","'.$v['expbonus'].'","'.$v['expbonus_count'].'","'.$v['refresh'].'","'.$v['battle'].'","'.$v['usec'].'")
			');
		}


		if ($NOCHANGECITY != 1) {
			// ������ ����� �� �����
			$q = mysql_query('SELECT * FROM oldbk.map_qvar WHERE owner = '.$telo['id'].' AND var = "lastcity"');
			if (mysql_num_rows($q) > 0) {
				// ���� ���� �����
				$lastcity = mysql_fetch_assoc($q) or die();
				$t = explode(":",$lastcity['val']);
				$t[1] = 0;
				mysql_query('UPDATE oldbk.map_qvar SET val = "'.implode(":",$t).'" WHERE owner = '.$telo['id'].' AND var = "lastcity"');
			}
		}

		//bug fix
		mysql_query("DELETE from oldbk.effects where owner={$telo[id]}");

		//����� ��������� ������
		mysql_query("INSERT INTO oldbk.effects SELECT NULL,`type`,`name`,`time`,`sila`,`lovk`,`inta`,`vinos`, `intel` , `owner`, `lastup`, `idiluz`,`pal`, `add_info`, `battle` ,`eff_bonus`  from effects where owner={$telo[id]}");
		//������� �����
		mysql_query("DELETE from effects where owner={$telo[id]}");
		
		$bet=1;
		$sbet = 1;
		//�������� ��������� c �������� �� ��� �������� ���� ������� � ����� � �������� �������� ������!
		
		addch("<img src=i/magic/port_2.gif> <B>{$user['login']}</B>, �����������".$sexi[$user[sex]]." <i>��������</i> � ��������������".$sexi[$user[sex]]." <b>{$telo[login]}</b> � CapitalCity. ",$user['room'],$user['id_city']);
		addchp('<font color=red>��������!</font> ��� ��������������'.$sexi[$user[sex]].' <B>'.$user['login'].'</B> � CapitalCity.<BR>\'; top.frames[\'main\'].location=\'index.php\'; var z = \'   ','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']); 
		}
		 else
		  {
		  echo "������ ���������!";
		  }
		
		}
		else
		{
		echo "<font color=red>��������  ��� ��� :)</font>";
		}
	}
 else if ( ( strtolower($_POST['city'])=='avalon') OR ( strtolower($_POST['city'])=='avaloncity')  OR ( strtolower($_POST['city'])=='ava') ) 
       {
       $rowm=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE id = ".$rowm[id]." limit 1 "));


       if ($telo[id_city]!=1)
		{
		
		// �������� ������
		$bonus = array();
		$q = mysql_query('SELECT * FROM users_bonus WHERE owner = '.$telo['id']);
		while($b = mysql_fetch_assoc($q)) {
			$bonus[] = $b;
		}
		
		
		mysql_query('DELETE from users_bonus where owner='.$telo['id'].';');
		$sexi[0]='�';$sexi[1]='';
		//echo "��������...";

		mysql_query("UPDATE users set odate=0 , id_city=1 where id={$telo[id]} and id_city!=1 and battle = 0;");
		if (mysql_affected_rows()>0)
		{

		// ���������
		while(list($k,$v) = each($bonus)) 
		{
			mysql_query('
			INSERT INTO avalon.users_bonus (owner,sila,sila_count,lovk,lovk_count,inta,inta_count,intel,intel_count,mudra,mudra_count,maxhp,maxhp_count,expbonus,expbonus_count,refresh,battle,usec) 
			VALUES ("'.$v['owner'].'","'.$v['sila'].'","'.$v['sila_count'].'","'.$v['lovk'].'","'.$v['lovk_count'].'","'.$v['inta'].'","'.$v['inta_count'].'","'.$v['intel'].'","'.$v['intel_count'].'","'.$v['mudra'].'","'.$v['mudra_count'].'","'.$v['maxhp'].'","'.$v['maxhp_count'].'","'.$v['expbonus'].'","'.$v['expbonus_count'].'","'.$v['refresh'].'","'.$v['battle'].'","'.$v['usec'].'")
			');
		}


		if ($NOCHANGECITY != 1) {
			// ������ ����� �� �����
			$q = mysql_query('SELECT * FROM oldbk.map_qvar WHERE owner = '.$telo['id'].' AND var = "lastcity"');
			if (mysql_num_rows($q) > 0) {
				// ���� ���� �����
				$lastcity = mysql_fetch_assoc($q) or die();
				$t = explode(":",$lastcity['val']);
				$t[1] = 1;
				mysql_query('UPDATE oldbk.map_qvar SET val = "'.implode(":",$t).'" WHERE owner = '.$telo['id'].' AND var = "lastcity"');
			}
		}

		//bug fix
		mysql_query("DELETE from avalon.effects where owner={$telo[id]}");
		mysql_query("INSERT INTO avalon.effects SELECT NULL,`type`,`name`,`time`,`sila`,`lovk`,`inta`, `intel` , `vinos`, `owner`, `lastup`, `idiluz`,`pal`, `add_info`, `battle` ,`eff_bonus`  from effects where owner={$telo[id]}");
		//������� �����
		mysql_query("DELETE from effects where owner={$telo[id]}");
				
		$bet=1;
		$sbet = 1;
		
		addch("<img src=i/magic/port_2.gif> <B>{$user['login']}</B>, �����������".$sexi[$user[sex]]." <i>��������</i> � ��������������".$sexi[$user[sex]]." <b>{$telo[login]}</b> � AvalonCity. ",$user['room'],$user['id_city']);
		addchp ('<font color=red>��������!</font> ��� ��������������'.$sexi[$user[sex]].' <B>'.$user['login'].'</B> � AvalonCity.<BR>\'; top.frames[\'main\'].location=\'index.php\'; var z = \'   ','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']); 
	

		}
		 else
		  {
		  echo "������ ���������!";
		  }
		
		}
		else
		{
		echo "<font color=red>��������  ��� ��� :)</font>";
		}
       }
else if ( ( ( strtolower($_POST['city'])=='angels') OR ( strtolower($_POST['city'])=='angelscity')  OR ( strtolower($_POST['city'])=='ang') ) AND ($user[id]==14897) )
       {
       $rowm=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE id = ".$rowm[id]." limit 1 "));


       if ($telo[id_city]!=2)
		{
		
		// �������� ������
		$bonus = array();
		$q = mysql_query('SELECT * FROM users_bonus WHERE owner = '.$telo['id']);
		while($b = mysql_fetch_assoc($q)) {
			$bonus[] = $b;
		}
		
		
		mysql_query('DELETE from users_bonus where owner='.$telo['id'].';');
		$sexi[0]='�';$sexi[1]='';
		//echo "��������...";

		mysql_query("UPDATE users set odate=0 , id_city=2 where id={$telo[id]} and id_city!=2 and battle = 0;");
		if (mysql_affected_rows()>0)
		{

		// ���������
		while(list($k,$v) = each($bonus)) 
		{
			mysql_query('
			INSERT INTO angels.users_bonus (owner,sila,sila_count,lovk,lovk_count,inta,inta_count,intel,intel_count,mudra,mudra_count,maxhp,maxhp_count,expbonus,expbonus_count,refresh,battle,usec) 
			VALUES ("'.$v['owner'].'","'.$v['sila'].'","'.$v['sila_count'].'","'.$v['lovk'].'","'.$v['lovk_count'].'","'.$v['inta'].'","'.$v['inta_count'].'","'.$v['intel'].'","'.$v['intel_count'].'","'.$v['mudra'].'","'.$v['mudra_count'].'","'.$v['maxhp'].'","'.$v['maxhp_count'].'","'.$v['expbonus'].'","'.$v['expbonus_count'].'","'.$v['refresh'].'","'.$v['battle'].'","'.$v['usec'].'")
			');
		}


		if ($NOCHANGECITY != 1) {
			// ������ ����� �� �����
			$q = mysql_query('SELECT * FROM oldbk.map_qvar WHERE owner = '.$telo['id'].' AND var = "lastcity"');
			if (mysql_num_rows($q) > 0) {
				// ���� ���� �����
				$lastcity = mysql_fetch_assoc($q) or die();
				$t = explode(":",$lastcity['val']);
				$t[1] = 2;
				mysql_query('UPDATE oldbk.map_qvar SET val = "'.implode(":",$t).'" WHERE owner = '.$telo['id'].' AND var = "lastcity"');
			}
		}

		//bug fix
		mysql_query("DELETE from angels.effects where owner={$telo[id]}");
		mysql_query("INSERT INTO angels.effects SELECT NULL,`type`,`name`,`time`,`sila`,`lovk`,`inta`, `intel` , `vinos`, `owner`, `lastup`, `idiluz`,`pal`, `add_info`, `battle` ,`eff_bonus`  from  effects where owner={$telo[id]}");
		//������� �����
		mysql_query("DELETE from effects where owner={$telo[id]}");
				
		$bet=1;
		$sbet = 1;
		
		addch("<img src=i/magic/port_2.gif> <B>{$user['login']}</B>, �����������".$sexi[$user[sex]]." <i>��������</i> � ��������������".$sexi[$user[sex]]." <b>{$telo[login]}</b> � AngelsCity. ",$user['room'],$user['id_city']);
		addchp ('<font color=red>��������!</font> ��� ��������������'.$sexi[$user[sex]].' <B>'.$user['login'].'</B> � AngelsCity.<BR>\'; top.frames[\'main\'].location=\'index.php\'; var z = \'   ','{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']); 
	

		}
		 else
		  {
		  echo "������ ���������!";
		  }
		
		}
		else
		{
		echo "<font color=red>��������  ��� ��� :)</font>";
		}
       }       
  else
    {
    echo "<font color=red>������ ������ ���!</font>";
    }
?>