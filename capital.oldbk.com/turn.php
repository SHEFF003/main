<?
session_start();
if (!($_SESSION['uid'] >0)) {header("Location: index.php");  die();}
include "connect.php";
include "functions.php";
header("Cache-Control: no-cache");
  $user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
  $batl=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE  var='battle'  LIMIT 1;"));
if ($user[id]!=14897)
{
  if ($batl[val]==0)   { die('������ �������� ���� ���...');   }
  if ($batl[val]!=$user[battle])   { die('������ �������� ���� ���...');   }
   $lider=mysql_fetch_array(mysql_query("SELECT * FROM `place_battle` WHERE (var='leader1' and  val='".$user[id]."') OR (var='leader2' and val='".$user[id]."') OR (var='leader3' and val='".$user[id]."') LIMIT 1;"));
    if (($lider['val']==$user[id])and($lider['var']=='leader1'))
	{
	//��� ���� � ������ ����
	$lid=1;
	}
	 elseif (($lider['val']==$user[id])and($lider['var']=='leader2'))
	   {
	   //��� ����� � 2� ����
	  $lid=2;
	    }
	 elseif (($lider['val']==$user[id])and($lider['var']=='leader3'))
	   {
	   //��� ����� � 3� ����
	  $lid=3;
	    }	    
	    else
	      {
		//�� �����
	      die('�� �� ����� � ���� ���...');
	      }
}
else
{
$lid=1;
}
	      
$i[1]='�����';
$i[2]='����';
$i[3]='��������';
/////////////////////////////////////////
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<script type="text/javascript" src="/i/globaljs.js"></script>
<META Http-Equiv=Expires Content=0>
		<script>
			function refreshPeriodic()
			{
				location.href='turn.php?';//reload();
								timerID=setTimeout("refreshPeriodic()",6000);
			}
			timerID=setTimeout("refreshPeriodic()",6000);
		</script>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=#D7D7D7 >
<?
if (($_POST[dolid])and($_POST[newlid]))
	{
	$_POST[newlid]=htmlspecialchars(mysql_real_escape_string($_POST[newlid]));
        $newlider=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `hp`>0 and `battle`='{$batl[val]}' and `login`='{$_POST[newlid]}' LIMIT 1;")) ;

	 if ($newlider[id]>0)
	  {
	  //���� �� ������� � ������ ������ � ������ ���
	   $tb=mysql_fetch_array(mysql_query("select * from battle where `win`=3 and `id`='{$batl[val]}' and (t{$lid} like '%;{$newlider['id']};%' or t{$lid} like '{$newlider['id']};%' or t{$lid} like '%;{$newlider['id']}') LIMIT 1; "));

	  if ($tb[id]==$batl[val])
	       {
	       echo "���������� �����...<br>";
       	       echo "<font color=red><b>�� �������� ���������...<br></font>";
  
		$outtxt=str_replace(':','^',nick33($newlider['id']));
       	       addlog($batl['val'],"!:X:".time().':'.nick_new_in_battle($user).':'.($user[sex]+100).":".$outtxt."\n");
       	       
	       addch ("<b>".nick7($user['id'])."</b> �������".$sexi." ��������� <b>".nick7($newlider['id'])."</b>",$user['room']);
	       mysql_query("update `place_battle` SET val='{$newlider[id]}' where var='leader{$lid}';");
	       echo '<div align=center><input type=button onclick="window.close();" value="�������"></div>
	       </boby>
		</html>
	       ';
	       die();
	       }
	       else
	       {
	       echo "<font color=red>����� ����� ��������� ".$_POST[newlid]." �� ������.</font>";
	       }

	  }
	  else
	  {
	  echo "<font color=red>����� ����� ��������� ".$_POST[newlid]." �� ������.</font>";
	  }


	}



?>


<table border="0" width="100%">
	<tr bgcolor=#C0C0C0>
		<td colspan="3" align="center"><b> �� ����� <?=$i[$lid];?> � ������ ��������� �������� ����� � ���.</b></td>
	</tr>
<?
////////////////////////////////////////
$_GET[f]=(int)($_GET[f]);
if (($_GET[up])and($_GET[f]>0))
{
$tpoz=mysql_fetch_array(mysql_query("SELECT * from `place_turn` where t='".$lid."' and owner='".$_GET[f]."' ; "));

if ($tpoz[id]>0)
   {
	if ($tpoz[poz]>1)
	{
	//mysql_query("UPDATE `place_turn` SET `poz`=`poz`+1 WHERE  t='".$lid."' and `poz`='".($tpoz[poz]-1)."' ;  ");
	//mysql_query("UPDATE `place_turn` SET `poz`=`poz`-1 WHERE  t='".$lid."' and owner='".$_GET[f]."'  ;" );
	  mysql_query("UPDATE `place_turn` SET `poz`=`poz`+1 WHERE  t='".$lid."' and `poz`<{$tpoz[poz]} and owner !={$_GET[f]} ; ");
	  mysql_query("UPDATE `place_turn` SET `poz`=1 WHERE  t='".$lid."' and owner='".$_GET[f]."'  ;" );


	}
   }
}
else if (($_GET[down])and($_GET[f]>0))
{
$tpoz=mysql_fetch_array(mysql_query("SELECT * from `place_turn` where t='".$lid."' and owner='".$_GET[f]."' ; "));
if ($tpoz[id]>0)
   {
   $all=mysql_fetch_array(mysql_query("select max(poz) from `place_turn` where t='".$lid."';"));

	if ($tpoz[poz]<$all[0])
	{
	//mysql_query("UPDATE `place_turn` SET `poz`=`poz`-1 WHERE  t='".$lid."' and `poz`='".($tpoz[poz]+1)."' ;  ");
	//mysql_query("UPDATE `place_turn` SET `poz`=`poz`+1 WHERE  t='".$lid."' and owner='".$_GET[f]."'  ;" );
	  mysql_query("UPDATE `place_turn` SET `poz`=`poz`-1 WHERE  t='".$lid."' and `poz`>{$tpoz[poz]} and owner !={$_GET[f]} ; ");
	  mysql_query("UPDATE `place_turn` SET `poz`={$all[0]} WHERE  t='".$lid."' and owner='".$_GET[f]."'  ;" );


	}
   }

}


///
// �������� ������ ������ �� ���� � ��� ��� ������� $lid
$turn=mysql_query("select t.*, u.login, u.ldate from place_turn t LEFT JOIN users u ON u.id=t.owner where t='".$lid."' ORDER BY poz;");

$p=0;
$f=mysql_num_rows($turn);
 while($row = mysql_fetch_array($turn))
	{
	$p++;
	$loginowner=$row[login];
	
	if ($cc==1) { $c="#C0C0C0"; $cc=0; } else { $c="#C0C0CA";  $cc=1; }
	if ($p==1)
		{
		 $linkup="<img src='http://i.oldbk.com/i/fighttype30.gif' title='��������� � ���' alt='��������� � ���'>";
 		 $linkdown="<a href=?&f=$row[owner]&down=1><img src=/i/d.gif title='��������� ����' alt='��������� ����'></a>";
		}
		else if ($p==$f)
		{
		 $linkup="<a href=?&f=$row[owner]&up=1><img src=/i/u.gif title='��������� �����' alt='��������� �����'></a>";
		 $linkdown="&nbsp;";
		}
		else
		{
		 $linkup="<a href=?&f=$row[owner]&up=1><img src=/i/u.gif title='��������� �����' alt='��������� �����'></a>";
		 $linkdown="<a href=?&f=$row[owner]&down=1><img src=/i/d.gif title='��������� ����' alt='��������� ����'></a>";
		}

	 echo "<tr bgcolor=$c >
		<td align=center>&nbsp;";
		if ($row[ldate] >= (time()-90))
		{
		?>
		<A HREF="javascript:<?php if(!is_array($_SESSION['vk'])) echo"top."; else echo"parent." ?>AddToPrivate('<?=$loginowner;?>', <?php if(!is_array($_SESSION['vk'])) echo"top."; else echo"parent." ?>CtrlPress)" target=refreshed><img src="http://i.oldbk.com/i/lock.gif" title="������" width=20 height=15></A>
		<?		
		}
		else
		{
		echo '<img src="http://i.oldbk.com/i/lock1.gif" title="������" width=20 height=15>';
		}
		echo ($row[owner_data])."</td>
		<td align=center>&nbsp;<b>$p</b></td>
		<td align=center>$linkup<br>$linkdown</td>
	</tr>";

      }

?>
</table>
<div align=center>
<form method=POST action=turn.php>
<b>�������� ���������:</b>
<INPUT TYPE=text name=newlid >
<INPUT TYPE=submit name=dolid value="��������">
<INPUT TYPE=submit name=ref value="��������">
</form>
</div>
</boby>
</html>
