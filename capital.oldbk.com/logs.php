<?
//��������� ��� �����
///////////////////////////

    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {
    $miniBB_gzipper_encoding = 'x-gzip';
    }
    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    $miniBB_gzipper_encoding = 'gzip';
    }
    if (isset($miniBB_gzipper_encoding)) {
    ob_start();
    }
    function percent($a, $b) {
    $c = $b/$a*100;
    return $c;
    }
//////////////////////////////
session_start();
include "connect.php";
include "functions.php";
include "strings.php";

 if(isset($_GET['page'])) {
	 $page = (int)$_GET['page'];
	 if($page < 0) { die; }
	 $_GET['page'] = $page;
 }

 if(isset($_REQUEST['log'])) {
	 $log = (int)$_REQUEST['log'];
 if($log < 0) { die ;}
	 $_REQUEST['log'] = $log;
 }

 if((isset($_GET['myonly'])) and ($user['id']>0) )
 {
 $_GET['flogin']=$user['login'];

 }
 else
 if(isset($_GET['flogin']))
 	{
 	if ($_GET['flogin']=='') unset ($_GET['flogin']);
 	}

 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script type="text/javascript" src="i/showthing.js"></script>
<script type="text/javascript" src="/i/globaljs.js"></script>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=5 marginheight=5 bgcolor=e2e0e0>
<H3  style="margin-bottom: 0px;">���������� ���� <a href="http://oldbk.com/">oldbk.com</a></H3>
<FORM METHOD=GET ACTION="logs.php">
<INPUT TYPE=hidden name=page value="<?=$_GET['page']?>">
<INPUT TYPE=hidden name=log value="<?=$_REQUEST['log']?>">
<?


if (CITY_ID==0)
	{
	$log4=49383315; //����� ����� ����� ��� ��������
	}
else if (CITY_ID==1)
	{
	$log4=12622595;	//����� ����� ����� ��� �������
	}
else if (CITY_ID==2)
	{
	$log4=100;	//����� ����� ����� ��� �������
	}
else
	{
	$log4=50000000000;	//�����
	}


 if ($user[klan]=='radminion') {
  echo "Admin-info:<!- GZipper_Stats -> <br>";
 }

function countliveinbattle($t) {
	$ret = 0;
	$t = explode(";",$t);
	while(list($k,$v) = each($t)) {
		if ($v < _BOTSEPARATOR_) {
			$ret++;
		}
	}
	return $ret;
}
if ($_REQUEST['log']!='')
	{
	$data = mysql_fetch_array(mysql_query ("SELECT *, UNIX_TIMESTAMP(`date`) as `udate` FROM `battle` WHERE `id` = ".$_REQUEST['log'].""));
	$admin_data_coment=$data['coment'];
	}


if (ADMIN)
	{
	echo "Type:{$data['type']} / ";
	echo "Coment:<input type=text readonly value='{$admin_data_coment}' style=\"width:200px;\" ><br>";
	}

if ($data['win'] != 3 && ($user['align'] == "1.99" || ADMIN)) {

	$t1 = explode(";",$data['t1']);
	$t2 = explode(";",$data['t2']);
	$t3 = explode(";",$data['t3']);
	while(list($k,$v) = each($t1)) {
		if (empty($v) || $v > _BOTSEPARATOR_) unset($t1[$k]);
	}
	while(list($k,$v) = each($t2)) {
		if (empty($v) || $v > _BOTSEPARATOR_) unset($t2[$k]);
	}
	while(list($k,$v) = each($t3)) {
		if (empty($v) || $v > _BOTSEPARATOR_) unset($t3[$k]);
	}
	$alllist = array_merge($t1,$t2,$t3);
	$allrender = array();

	if (count($alllist)>0)
	{
	$q = mysql_query('SELECT * FROM users WHERE id IN ('.implode(",",$alllist).')');
	while($u = mysql_fetch_assoc($q)) {
		$u['hidden'] = 0;
		$u['hiddenlog'] = "";
		$allrender[$u['id']] = nick_align_klan($u);
	}
	}

	reset($t1);
	reset($t2);
	reset($t3);
	if (count($t1)) {
		echo 'Team 1: ';
		while(list($k,$v) = each($t1)) {
			echo $allrender[$v]." ";
		}
		echo '<br>';
	}
	if (count($t2)) {
		echo 'Team 2: ';
		while(list($k,$v) = each($t2)) {
			echo $allrender[$v]." ";
		}
		echo '<br>';
	}

	if (count($t3)) {
		echo 'Team 3: ';
		while(list($k,$v) = each($t3)) {
			echo $allrender[$v]." ";
		}
		echo '<br>';
	}
	//echo '<br><br>';
}

if (($data['teams']=='AFB') and (!ADMIN) )
	{
	die("<center><b>��� ��� �����!</center></body></html>");
	}

if (($data[win]==3) and ($data[status_flag]>0) and (!($_SESSION['uid'] >0)) ) {

$cnam[0]='Capital City';
$cnam[1]='Avalon City';
$cnam[2]='Angels City';

die("<center><b>��� �������� ���������� ��� �����. <br>��� ��������� ������� � <a href='http://oldbk.com' target=_blank>����</a> � ������������� � {$cnam[CITY_ID]}!</b> </center></body></html>");

}
else
if (($data[status_flag] ==4) and (!($_SESSION['uid'] >0)) ) {

$cnam[0]='Capital City';
$cnam[1]='Avalon City';
$cnam[2]='Angels City';

die("<center><b>��� ���������� ��� �����. <br>��� ��������� ������� � <a href='http://oldbk.com' target=_blank>����</a> � ������������� � {$cnam[CITY_ID]}!</b> </center></body></html>");

}



if ($_GET['stat']!='1')
{

//if ((int)($_REQUEST['log']) > 10312000)
{
$_REQUEST['log']=(int)($_REQUEST['log']);
$logdir=(int)($_REQUEST['log']/1000);


$logdir="/www/data/combat_logs/".$logdir."000";
$NEW_LOG=true;

$filename=$logdir."/battle".$_REQUEST['log'].".txt";


	if (file_exists($filename))
	{
	//���� ���� ���� ��������� �� ��������� ���
	$log = file($filename);

	if ($user['klan']=='radminion') { echo '������ ����� ' . $filename . ': ' . filesize($filename) . ' ���� <br>';	 }

	if ($NEW_LOG)
	{
	//������� �����
	$out_log=array();

		foreach ($log as $line)
			{


			if ($FINISHLOG!=true)
			{
			//�������� - ����� ����� ������ ��� ���������� �������� � ���������� ��������
			if (strpos($line,"<BR>") > 0)
				{
				//� ������ ������ ��������� ����
					$oldlog = explode("<BR>",$line);
					 foreach ($oldlog as $oldline)
						{
						if ($oldline!='') $out_log[]=$oldline;
						}
				}
				else
				{
				$out_log[]=$line;
				}

				/*
				if (strpos($line,'!:F:') !== FALSE) // ������ ��������� ��� - ��������� �����
					{
					$FINISHLOG=true;
					}
				*/
			}

			}

		$log=$out_log;
	  }
	  else
	  {
	  	$log = explode("<BR>",$log[0]);
	  }

	}
	else
	{
	//���� ��� ���������� ����� ������� ������� ���
	$filename.=".gz";
	if (file_exists($filename))
		{
		//������ ���-���
		$gzlog = gzfile($filename);
		unset($log);
		//����� ��� � ���� �.�. ��� ������ ����������� ����������
		foreach ($gzlog as $line) {  $log.=$line; }
		$log = explode("<BR>",$log);
		}
		else
		{
		echo "<h4>��� ����� ��� �� ������!</h4>";
		die("</body></html>");
		}
	}

}

?>
<?

	if (($data['coment']=='<b>����-����</b>') and ($user[klan]=='radminion') )
	{

		if ($data['win']==3)
		{
			$get_data=mysql_query("select sum(GetLevelPoint(if(`exp`>8000000000,14,`level`))) as tpoints, battle_t from users where battle='{$data['id']}' and hp>0 group by battle_t");
			if (mysql_num_rows($get_data) > 0)
			{
				while($row=mysql_fetch_array($get_data))
				{
				$teams[$row['battle_t']]=$row['tpoints'];
				}
				echo "<b><i>���� ����-����:  {$teams[1]}  /   {$teams[2]}  </i></b><br> ";
			}
		}

			$fllog="/www_logs7/goto_log/".$data['id'].".txt";
			if (file_exists($fllog))
				{
				$kuchalog = file($fllog);
				echo "<small><hr>������� �����:<br>";
				foreach ($kuchalog as $kl)
						{
							$logkl = explode("|",$kl);
							 echo '<span class=date>'.date("H:i:s",$logkl[0]).'</span> ';
							 if ($logkl[3]==1)  { echo "<b>".$logkl[1]."</b><";} else { echo $logkl[1]; }
							 if ($logkl[3]==0)  { echo " = "; }
							 if ($logkl[3]==2)  { echo "<b>>".$logkl[2]."</b>";} else { echo $logkl[2]; }
							echo " for ".$logkl[5]."<br>";
						}
				echo "</small><hr>";
				}

	}


			if (($data['coment']=='<b>��� � ������� ��������</b>') and ($data['id']>222482354) and time()<1462060800 )
			{
			$data['coment']='<b>��������� �������</b>';
			}

			if (($data['coment']=='<b>#zlevels</b>') or ($data['coment']=='#zlevels') or ($data['coment']=='<b>#zbuket</b>') or ($data['coment']=='<b>#zelka</b>') )
				{
				$data['coment']='<b>����������</b>';
				}

			$data_coment=$data['coment'];

			if($data['coment']!='') {$data['coment'] = ", <b>''{$data['coment']}''</b>";}

			if ($data['type'] == 20) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype20.gif\" WIDTH=20 HEIGHT=20 ALT=\"���������� ��������\"> (���������� ��������)";
			}elseif ($data['type'] == 10) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> (�������� � ����� ������)";
			}elseif ($data['type'] == 1010) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> (�������� � ����� ������)";
			}elseif ($data['type'] == 30) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype30.gif\" WIDTH=20 HEIGHT=20 ALT=\"��� � ��������� �����\"> (��� � ��������� �����)";
			}elseif ($data['type'] == 60) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� �������� ����-����\"> ".$data['coment']." (��� �� ����� �����)";
			}
			elseif ($data['blood'] && ($data['type'] == 5 OR $data['type'] == 4)) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype5.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"><IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> (�������� �������� ��������{$data['coment']})";
			}
			elseif ($data['blood'] && ($data['type'] == 2 OR $data['type'] == 3 OR $data['type'] == 6)) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> (�������� ��������{$data['coment']})";
			}
			elseif ($data['type'] == 5 OR $data['type'] == 4) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype4.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ���\"> (�������� ��������{$data['coment']})";
			}
			elseif ($data['blood']>0 && $data['type'] == 7) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��� \"><IMG SRC=\"http://i.oldbk.com/i/fighttype7.gif\" WIDTH=20 HEIGHT=20 ALT=\"��� �� �����\"> (�������� ��� �� ����� {$data['coment']})";
			}
			elseif ($data['blood']==0 && $data['type'] == 7) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype7.gif\" WIDTH=20 HEIGHT=20 ALT=\"��� �� �����\"> (��� �� ����� {$data['coment']})";
			}
			elseif ($data['blood']>0 && $data['type'] == 8) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��� \"><IMG SRC=\"http://i.oldbk.com/i/fight_flowers.png\" WIDTH=20 HEIGHT=20 ALT=\"��� �� �������\"> (�������� ��� �� ������� {$data['coment']})";
			}
			elseif ($data['blood']==0 && $data['type'] == 8) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fight_flowers.png\" WIDTH=20 HEIGHT=20 ALT=\"��� �� ������� \"> (��� �� ������� {$data['coment']})";
			}
			elseif (($data['type'] == 3 OR $data['type'] == 2) AND ($data['CHAOS']>0) )  {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype3.gif\" WIDTH=20 HEIGHT=20 ALT=\"����������� ���\"> (����������� ��������{$data['coment']})";
			}
			elseif (($data['type'] == 3 && $data_coment != "��� �����������") OR $data['type'] == 2) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype3.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ���\"> (��������� ��������{$data['coment']})";
			}
			elseif ($data['type'] == 1) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype1.gif\" WIDTH=20 HEIGHT=20 ALT=\"���������� ���\"> (���������� ��������{$data['coment']})";
			}
			elseif ($data['type'] == 100 || $data['type'] == 101 ) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> (�������� �����)"; //������
			}
			elseif ($data['type'] == 140 || $data['type'] == 141 ) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> (�������� �������� �����)";
			}
			elseif ($data['type'] == 150 || $data['type'] == 151 ) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype6.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������\"> (�������� ���������� �����)";
			}
			elseif ($data['type'] == 40 || $data_coment == "��� �����������") {
				if ($data_coment == "��� �����������") {
					$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype40.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������������\"> (��������������)";
				} else {
					$bd_levels=explode("|",$data['damage']);
					if ($bd_levels[1]==$bd_levels[0])
						{
						$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype40.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������������\"> (��������������) ".$bd_levels[0].'-������ ';
						}
						else
						{
						$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype40.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������������\"> (��������������) ".$bd_levels[0].'-'.$bd_levels[1].'������ ';
						}
				}
			}
			elseif ($data['type'] == 41) {
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype41.gif\" WIDTH=20 HEIGHT=20 ALT=\"�������� ��������������\"> (�������� ��������������) ".$data['damage'].'-������ ';
			}
			else
			{
			$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype3.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ���\"> (��������� ��������{$data['coment']})";
			}

			if ( ($data['type'] >= 210) AND ($data['type'] <239) )
				{
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype".$data['type'].".gif\" WIDTH=20 HEIGHT=20 TITLE='�������� ��������' ALT='�������� ��������'>".$data[coment];
				}
			elseif ( ($data['type'] >= 240) AND ($data['type'] <269) )
				{
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype".$data['type'].".gif\" WIDTH=20 HEIGHT=20 TITLE='�������� ��������' ALT='�������� ��������'>".$data[coment];
				}
			elseif ( ($data['type'] ==11) OR ($data['type'] ==12 ) )
				{
				$rr = "<IMG SRC=\"http://i.oldbk.com/i/fighttype".$data['type'].".gif\" WIDTH=20 HEIGHT=20 TITLE='��� � ������' ALT='��� � ������'>".$data[coment];
				}





			if (($data['CHAOS']>1) or ($data['CHAOS']==-1))
					{
					$rr.= "<IMG SRC=\"http://i.oldbk.com/i/achaos.gif\" WIDTH=20 HEIGHT=20 ALT=\"��������� ��� � ����������\">";
					}

			if(($data['win']==3) and ($data['status']!=1) and ($data['id']>1))
			{
			// new fsystem
			//��������� ������ ������ � ����� � ������ - ������ �����
			$people=mysql_query("select id, login, hp, maxhp,battle_t, hidden, hiddenlog from users where battle='{$data['id']}' and hp >0  UNION select id, login, hp, maxhp, battle_t, hidden, hiddenlog from users_clons where battle='{$data['id']}' and hp>0	");

			$boec_t1=array ();
			$boec_t2=array ();
			$boec_t3=array ();
			while ($rowa = mysql_fetch_array($people))
			{
			//����������� ����� � ����
				if ($rowa[battle_t]==1)
				 {
				 $boec_t1[$rowa[id]]=$rowa;
				 }
				 elseif ($rowa[battle_t]==2)
				 {
				 $boec_t2[$rowa[id]]=$rowa;
				 }
				 elseif ($rowa[battle_t]==3)
				 {
				 $boec_t3[$rowa[id]]=$rowa;
				 }

			}


			///////////////////////////////////////////////////////
			// ����� � ������ �������
			$ffs ='';
			if ($data[t1]!='')
			{
				$i=0;
				$T1=explode(";",$data[t1]);
				foreach ($T1 as $k => $v)
				{


				if ( ($boec_t1[$v]!='')  )
					{
					++$i;
					if ($i > 1) { $cc = ', '; } else { $cc = ''; }

					if ( ($data[type]==61))
					{
					$ffs .= $cc.bat_nick_team_nl($boec_t1[$v],"B11");
					}
					else
					{
					$ffs .= $cc.bat_nick_team_nl($boec_t1[$v],"B1");
					}

					 }
				}
			if ($i>0)
			{
				if ( ($data[type]==61))
				{
				$kom1_echo="(".countliveinbattle($data['t1']).") <img src='http://i.oldbk.com/i/align_6.gif'> ".$ffs;
				}
				else
				{
				$kom1_echo=$ffs;
				}

			$A=1;
			}
			else
			{
				if ( ($data[type]==61))
				{
				$kom1_echo="<img src='http://i.oldbk.com/i/align_6.gif'>  <i>(��� ����� ����������)</i> ";
				}
			}

			$i=0;
			}

			if ($data[t2]!='')
			{
				if ($A) {  $kom2_echo=" ������ "; }
				$ffs ='';
				$T2=explode(";",$data[t2]);
				foreach ($T2 as $k => $v)
				{
				if ( ($boec_t2[$v][login]!='')  )
					{
					++$i;
					if ($i > 1) { $cc = ', '; } else { $cc = ''; }

					if ( ($data[type]==61))
					{
					$ffs .= $cc.bat_nick_team_nl($boec_t2[$v],"B12");
					}
					else
					{
					$ffs .= $cc.bat_nick_team_nl($boec_t2[$v],"B2");
					}
				 	}
				}
			if ($i>0)
			{
				if ( ($data[type]==61))
				{
				$kom2_echo.="(".countliveinbattle($data['t2']).") <img src='http://i.oldbk.com/i/align_3.gif'> ".$ffs;
				}
				else
				{
				$kom2_echo.=$ffs;
				}
			}
			else
			{
				if ( ($data[type]==61))
				{
				$kom2_echo.="<img src='http://i.oldbk.com/i/align_3.gif'> <i>(��� ����� ����������)</i>";
				}
			}


			$i=0;
			$B=1;
			}

			if ($data[t3]!='')
			{
			if (($A)OR($B)) {  $kom3_echo=" ������ "; }
			$ffs ='';
			$T3=explode(";",$data[t3]);
			foreach ($T3 as $k => $v)
			{
				if ( ($boec_t3[$v][login]!='')  )
				{
				++$i;
				if ($i > 1) { $cc = ', '; } else { $cc = ''; }


				if ( ($data[type]==61))
				{
				$ffs .= $cc.bat_nick_team_nl($boec_t3[$v],"B13");
				}
				else
				{
				$ffs .= $cc.bat_nick_team_nl($boec_t3[$v],"B3");
				}
	 			}
			}
			if ($i>0)
			{
				if ( ($data[type]==61))
				{
				$kom3_echo.="(".countliveinbattle($data['t3']).") <img src='http://i.oldbk.com/i/align_2.gif'> ".$ffs;
				}
				else
				{
				$kom3_echo.=$ffs;
				}
			}
			else
			{
				if ( ($data[type]==61) )
				{
				$kom3_echo.="<img src='http://i.oldbk.com/i/align_2.gif'> <i>(��� ����� ����������)</i>";
				}
			}


			$i=0;
			$C=1;
			}

$ffs=$kom1_echo.$kom2_echo.$kom3_echo;







			}

			if (($data['status_flag'] == 10) and ($data['type'] == 7) ) {
				$battle_status = "<h3>�������� ��� �� �����</h3>";
			}else
			if (($data['status_flag'] == 10) and ($data['type'] == 8) ) {
				$battle_status = "<h3>�������� ��� �� �������</h3>";
			}
			else
			if (($data[type]==101) and ($data[status_flag]==0))
			{
				$battle_status = "<h3>������� �������� �����!</h3>";
			}
			elseif (($data[type]==141) and ($data[status_flag]==0))
			{
				$battle_status = "<h3>������� �������� �����!</h3>";
			}
			elseif (($data[type]==151) and ($data[status_flag]==0))
			{
				$battle_status = "<h3>������� �������� �����!</h3>";
			}
			elseif ($data['status_flag'] == 10) {
				$battle_status = "<h3>������� ����������� ���!</h3>";
			}
			elseif ($data['status_flag'] == 3) {
				$battle_status = "<h3>��������� �����!</h3>";
			}elseif ($data['status_flag'] == 2) {
				$battle_status = "<h3>���������� �����!</h3>";
			}elseif ($data['status_flag'] == 1) {
				$battle_status = "<h3>������� �����!</h3>";
			}elseif ($data['status_flag'] == 4)
			{
				if ($data['id'] == 232196922)
					{
					$battle_status = "<h3>��� ���������� �������-����!</h3>";
					}
					else
					{
					$battle_status = "<h3>������ ����!</h3>";
					}
			}elseif ($data['status_flag'] == 6) {
				$battle_status = "������� �����! ���� - ����! ";

			if  ($data[win]==3)
				{
				$get_info=mysql_query("select * from place_battle where (var='battle' and val=".$data[id].") or var='close' ");
				if (mysql_affected_rows()==2)
				  {
				  $get_closetime=mysql_fetch_array($get_info);
   				  $get_closetime=mysql_fetch_array($get_info);

   				    if ($get_closetime[val]>time())
					{
					$HH=floor(($get_closetime[val]-time())/60/60);
					$MM=round((($get_closetime[val]-time())/60)-(floor(($get_closetime[val]-time())/3600)*60));
					if ($MM>=60) {$MM=59;}
				        echo "<font color=red><b>��� ��������� �����: ".$HH." �. ".$MM." ���.</b></font><br>";
				        }
				  }
				}



			}



			if((int)$data['status_flag'] > 1 && (int)$data['type'] == 5)
			{
				$battle_status = "<h3>������� ����������� �����!</h3>";
			}

			echo $battle_status;



			if ($data['type'] !=30)
		{
			$co=0;
		if ($data['t1']!='')
			{
			$ttt=explode(";",$data['t1']);
			foreach($ttt as $k=>$v)
					{
					if (($v > _BOTSEPARATOR_) and ($v < 1000000000 ))
				 			{
				 			//�����
				 			}
				 			else
				 			{
							$co++;
							}
					}
			}
	if ($data['t2']!='')
			{
			$ttt=explode(";",$data['t2']);
			foreach($ttt as $k=>$v)
					{
					if (($v > _BOTSEPARATOR_) and ($v < 1000000000 ))
				 			{
				 			//�����
				 			}
				 			else
				 			{
							$co++;
							}
					}
			}
	if ($data['t3']!='')
			{
			$ttt=explode(";",$data['t3']);
			foreach($ttt as $k=>$v)
					{
					if (($v > _BOTSEPARATOR_) and ($v < 1000000000 ))
				 			{
				 			//�����
				 			}
				 			else
				 			{
							$co++;
							}
					}
			}


echo "<table border=0 width=100% > <tr> <td width=33%>";
			if ($data['inf']>0)
			{
			$co-=$data['inf'];
			}

			if ($co>0)
				{
				echo "� ���: <b>".$co."</b> ������� <br>";
				}
			}

			if($data['type'] == 61)
			{
			$cc=mysql_fetch_array(mysql_query("select * from place_logs where battle='{$data['id']}'"));
			if ($cc[usrc]>0) echo "����. ���-�� ���������� ��� ������ ����������: <b>{$cc[usrc]}</b> �������<br>";
			}


			if(($data['type'] != 10) and ($data['type'] != 1010) and ($data['type'] != 11) and ($data['type'] != 12))  {
			$timeo = "��� ���� � ��������� {$data['timeout']} ���.";

			if (($data['id']==337326646) and ($data['teams']=='') )
				{
				$finish_time=mktime(0,0,0,8,25,2017);

				if (($finish_time-time())>0)
					{
					$timeo .="<br><font color=red><b>��� ����� ������ �� ������������� ����� ".prettyTime(null,$finish_time)."</b></font><br>";
					}
				}

			}
			if(($data['type'] == 11) or  ($data['type'] == 12))
			{
			$timeo .= "��� � ������ ";
			}

			if($data['fond']>0)
			{
			$data['fond'] = round($data['fond']*0.9,2);
			$timeo .= "��� �� ������. �������� ����: {$data['fond']} ��.";
			$timeo .= "<br>��� ������ �� ������������ �� �������. ";
			}
			else
			{
				if ($data['teams']!='')
					{
					$h=explode(":||:",$data['teams']);
					      if ($h[0]==20000)
					      	{
							$timeo .= " ��� ����������...";
					      	}
					      	else
				      		{
							$timeo .= "  ��� ������ �� ������������...{$data['teams']}";
						}
					}
			}

			if($data['nomagic'] == 1)
					{
					$timeo .= "<br>��� ��� �����.";
					}

			/*
			if ($data['status'] == 0 && $data['win'] == 3 && $data['t1_dead'] == "") {
				if ($data['type'] == 40 || $data['type'] == 41) {
					if ($data['t1'] == "" || $data['t2'] == "" || $data['t3'] == "") {
						if (($data['udate'] + (15*60)) >= time()) {
							$timeo .= '<br><font color=red>��� ����� ������ ��� ������������� ������� ���������� ����� '.floor((($data['udate'] + (15*60))-time())/60).' �����</font><br>';
						}
					}
				}
			}
			*/

				echo "{$timeo}</td><td width=33%>";

				/////////////// ���� ����� �������� ��� - ����
				if ($data['type'] == 40 ||  $data['type'] == 41 || $data['type'] == 140 ||  $data['type'] == 141 || $data['type'] == 150 || $data['type'] == 151 ||  $data_coment == "<b>��� �� ����������� �������</b>")
				{
				 	$get_wes=mysql_fetch_array(mysql_query("SELECT * from `battle_war` where battle='{$data[id]}' "));
					if  ($get_wes['active']==1)
					{
					  if ( ($get_wes['t1'] >= $get_wes['wmax']) AND ($get_wes['t2'] < $get_wes['t1']) )     {   $vclass1='ves1n';   }   else   {  $vclass1='ves1';   }
					  if ( ($get_wes['t2'] >= $get_wes['wmax']) AND ($get_wes['t1'] < $get_wes['t2']) )     {   $vclass2='ves2n';   }   else   {  $vclass2='ves2';   }

					  $ves1=$get_wes['t1'];   $ves2=$get_wes['t2'];  $planka=$get_wes['wmax'];

						echo "<center><table border=0 height=50 width=157 style=\"background-image: url(http://i.oldbk.com/i/ves_jpg.jpg);   background-position: center center; background-repeat: no-repeat;\">
						<tr align=center>
						<td  width=52 class=$vclass1> $ves1 </td>
						<td  width=52 class=vesp> $planka </td>
						<td  width=52 class=$vclass2> $ves2 </td>
						</table>
						</center>";

					}
					 else 	 {
						   $vclass1='ves1';  $vclass2='ves2';  $ves1=0;  $ves2=0;  $planka=0;

						echo "<center><table border=0 height=50 width=157 style=\"background-image: url(http://i.oldbk.com/i/ves_jpg.jpg);   background-position: center center; background-repeat: no-repeat; opacity: 0.2; -ms-filter: 'alpha(opacity=20)'; filter: alpha(opacity=20);\">
						<tr align=center>
						<td  width=52 class=$vclass1> $ves1 </td>
						<td  width=52 class=vesp> $planka </td>
						<td  width=52 class=$vclass2> $ves2 </td>
						</table>
						</center>";


					   	}


				}
				////////////////////////////////////////////////////////////////////

				echo "</td><td width=33%>";


			if ($_GET['stat']!='1')
			{
			echo "<div align=right><form method=get><input type=hidden name='log' value='".(int)$_GET['log']."'><input type=hidden name='stat' value='1'><input type=submit value='���������� ���'></form></div>";
			}

			echo "<div align=right><FORM METHOD=GET ACTION='logs.php'>
			<INPUT TYPE=hidden name='page' value='".$_GET['page']."'>
			<INPUT TYPE=hidden name='log' value='".$_REQUEST['log']."'>
			����������� �� ����:<INPUT TYPE='text' name='flogin' value='".$_GET['flogin']."'>
			<INPUT TYPE=submit name=filt value=\"��������\"><br>";
			if ($user['id']>0)
				{
				echo "<INPUT TYPE=submit name=myonly value=\"������ ��� �������\"><br>";
				}
			echo "
			<INPUT TYPE=submit name='analiz2' value=\"��������\">
			 </form></div>
			 </td>
			 </tr>
			 </table> ��� ���: ";
			echo $rr;


?>
&nbsp;
��������:
<?


	if ($NEW_LOG) {	$all = count($log); } else  { $all = count($log)-1; }
	$pgs = $all/50;

if (isset($_REQUEST['analiz2']))
 {
$_GET['page']=(int)$pgs;
 }

if (!isset($_GET['flogin']))
{
$dp=0;$op=0;
$pgs=(int)$pgs;
	for ($i=0;$i<=$pgs;++$i) {

	   if (($_GET['page']-100) > $i)
	    {
	     if ($op==0)
	     	{
	     	echo ' <a href="?log=',$_GET['log'],'&page=0">1</a> ';
	     	 $op=1;echo "...";
	     	}
	    }
	  else
	   if (($_GET['page']+100) < $i)
	   	{
	   	 if ($dp==0)
	   	 	{
		   	$dp=1;	echo "...";
		   	echo ' <a href="?log=',$_GET['log'],'&page=',$pgs,'">',($pgs+1),'</a> ';
		   	}
	   	}
	   else
	   {
		if ($_GET['page']==$i) {
			echo ' <a href="?log=',$_GET['log'],'&page=',$i,'"><font color=#8f0000>',($i+1),'</font></a> ';
		}
		else {
			echo ' <a href="?log=',$_GET['log'],'&page=',$i,'">',($i+1),'</a> ';
		}
	    }
	}
}
else
{
echo "1";
}

?><HR>
<?

if (isset($_GET['raw']) && ADMIN) {
	echo '<pre>'.implode("\r\n",$log).'</pre>';
}

include "abiltxt.php";

  foreach($atext as $index => $val)
	{
	$atext[$index]="<a style=\"cursor: pointer\" onMouseOut=\"HideThing(this);\" onMouseOver=\"ShowThing(this,25,25,'{$val}');\" >".str_replace('/','',$abn[$index])."</a>";
	}

ksort($atext);
ksort($abilname);


	if (isset($_GET['flogin']))
	{
	$start = 0;
	$stop=$all;
	}
	else
	{
	$start = 50*$_GET['page'];
	if(50*$_GET['page']+50 <= $all) {
		$stop = 50*$_GET['page']+50;
	} else {
		$stop = 50*$_GET['page']+($all-50*$_GET['page'])-1;
	}
	//echo $stop;
	 if ($_GET['page']>0) { $start++; }
	}

	$cc=0;

	for($i=$start;$i<=$stop;$i++)
	{

		if ($NEW_LOG)
		{
			/*
			if (($log[$i][2]=='D') and ($i>$start+2) ) //���� ����������
			{
			$strtemp=explode(":",$log[$i]);
			$tmpnik=explode("|",$strtemp[3]);
			$tmpnik[0]; //�����

				$strtemp2=explode(":",$log[$i-2]);
				$tmpnik2=explode("|",$strtemp2[6]);
				if (($tmpnik[0]==$tmpnik2[0]) and ($strtemp2[12][1]!=0))
					{
					//������ ������
					//!:K:1415810561:��������_������|1|:110:101:�����|2|:103:33:45:2:124:[22/398]
					$fixhp=explode("/",$strtemp2[12]);
					$strtemp2[12]="[0/".$fixhp[1];
					$log[$i-2]=implode(":",$strtemp2);
					$logout[$i-2]=get_log_string($log[$i-2]);
					}
			}
			*/
				if (isset($_GET['flogin']))
				{
					$get_arr_line=explode(":",$log[$i]); //6- ��� ����������


					if (( ((strpos($log[$i],$_GET['flogin'])) > 0) and  (((strpos($get_arr_line[3],'���������')) !==false) and ((strpos($get_arr_line[3],$_GET['flogin'])) !==false) ) or (((strpos($get_arr_line[6],'���������')) !==false) and ((strpos($get_arr_line[6],$_GET['flogin'])) !==false) )  ) AND (!(($_GET['flogin']==$user['login']) and ($user['id']>0))) )
					{
						//�� �������� - �.�. ������� ��� ��� �������

					}
					elseif ((strpos($log[$i],$_GET['flogin'])) > 0)
					{
						$logout[]=get_log_string($log[$i]);
					}
				$cc++;
				}
				else
				{
				$logout[]=get_log_string($log[$i]);
				$cc++;
				}

			//if ($cc>100) break;
		}
		else
		{
			$logout[]=preg_replace($abilname,$atext,$log[$i]);
		}


	}

	$print_flag=false;
	//for($i=$start;$i<=$stop;$i++)
	$cc=0;
	foreach ($logout as $i => $li)
		{


					$li=trim($li);
					if ( $li !='' )
						{
						echo $li."<BR>\n";
						$print_flag=true;
						}

			$cc++;
			//if ($cc>100) break;
		}

	if ((isset($_GET['flogin'])) and ($print_flag==false) )
		{
			echo "<center><b>������� � ��� �� �������.</b></center><BR>";
		}
?>
<HR>
<?
	echo "<center>".$ffs."</center><HR>";
?>
<FORM METHOD=GET ACTION="logs.php">
<INPUT TYPE=hidden name=page value="<?=$_GET['page']?>">
<INPUT TYPE=hidden name=log value="<?=$_REQUEST['log']?>">

<INPUT TYPE=submit name=analiz2 value="��������">
</form>

<?
if (!isset($_GET['flogin']))
{
echo '&nbsp;��������:';
$dp=0;$op=0;
$pgs=(int)$pgs;
	for ($i=0;$i<=$pgs;++$i) {

	   if (($_GET['page']-100) > $i)
	    {
	     if ($op==0)
	     	{
	     	echo ' <a href="?log=',$_GET['log'],'&page=0">1</a> ';
	     	 $op=1;echo "...";
	     	}
	    }
	  else
	   if (($_GET['page']+100) < $i)
	   	{
	   	 if ($dp==0)
	   	 	{
		   	$dp=1;	echo "...";
		   	echo ' <a href="?log=',$_GET['log'],'&page=',$pgs,'">',($pgs+1),'</a> ';
		   	}
	   	}
	   else
	   {
		if ($_GET['page']==$i) {
			echo ' <a href="?log=',$_GET['log'],'&page=',$i,'"><font color=#8f0000>',($i+1),'</font></a> ';
		}
		else {
			echo ' <a href="?log=',$_GET['log'],'&page=',$i,'">',($i+1),'</a> ';
		}
	    }
	}
}
echo "<br><br><form method=get><input type=hidden name='log' value='".(int)$_GET['log']."'><input type=hidden name='stat' value='1'><input type=submit value='���������� ���'></form>";
}
else { echo "<form method=get><input type=hidden name='log' value='".(int)$_GET['log']."'><input type=submit value='��� ���'></form>";
//if ((int)($_REQUEST['log'])>=$log4)
			 {
				include('battle_stat_new.php');
			 }
			 //else { include('battle_stat.php');  }
echo "<br><form method=get><input type=hidden name='log' value='".(int)$_GET['log']."'><input type=submit value='��� ���'></form>";
}
?>

</FORM>
<A name=end></A>
<div align=right>
<!--LiveInternet counter--><script type="text/javascript"><!--
			document.write("<a href='http://www.liveinternet.ru/click' "+
			"target=_blank><img style='float:right; ' src='http://counter.yadro.ru/hit?t54.2;r"+
			escape(document.referrer)+((typeof(screen)=="undefined")?"":
			";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
			screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
			";"+Math.random()+
			"' alt='' title='LiveInternet: �������� ����� ���������� �"+
			" ����������� �� 24 ����' "+
			"border='0' ><\/a>")
			//--></script><!--/LiveInternet-->

<!--Rating@Mail.ru counter-->
<script language="javascript" type="text/javascript"><!--
d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
<script language="javascript1.1" type="text/javascript"><!--
a+=';j='+navigator.javaEnabled();js=11;//--></script>
<script language="javascript1.2" type="text/javascript"><!--
s=screen;a+=';s='+s.width+'*'+s.height;
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
<script language="javascript1.3" type="text/javascript"><!--
js=13;//--></script><script language="javascript" type="text/javascript"><!--
d.write('<a href="http://top.mail.ru/jump?from=1765367" target="_blank">'+
'<img src="http://df.ce.ba.a1.top.mail.ru/counter?id=1765367;t=49;js='+js+
a+';rand='+Math.random()+'" alt="�������@Mail.ru" border="0" '+
'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_blank" href="http://top.mail.ru/jump?from=1765367">
<img src="http://df.ce.ba.a1.top.mail.ru/counter?js=na;id=1765367;t=49"
height="31" width="88" border="0" alt="�������@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script>


</div>



</BODY>
</HTML>
<?php
function bat_nick_team_nl($telo,$st)
{

if ( ($telo[hidden] > 0) and ($telo[hiddenlog] ==''))
   {
	$telo['login']='<b><i>���������</i></b>';
	$telo['hp']='??';
	$telo['maxhp']='??';
   }
   else
	if (strpos($telo[login],"��������� (����" ) !== FALSE )
		{
		$telo['login']='<b><i>'.$telo['login'].'</i></b>';
		$telo['hp']='??';
		$telo['maxhp']='??';
		}
$telo=load_perevopl($telo);
if ($telo[razm]==1)
{
$telo['login']="<u>".$telo['login']."</u>";
}
if($telo[lid]==1)
{
$lid="<img src='http://i.oldbk.com/i/leader.gif' width=16 height=19 style='cursor:pointer' title='�����' alt='�����'>";
}
else {$lid='';}


if ($telo[bpstor]>0)
	{


	//����� 3-� ��������� ��� ������ ������ B11 , b12 ,b13
	 if ($st=='B1') $st='B11';
	 if ($st=='B2') $st='B12';
	 if ($st=='B3') $st='B13';
	}


//������ ����� ���� ������ ���� ��������� � ���� 60 61
/*
if ($telo[blow]==1)
  {
  $st='B3';
  }
*/

$outstring=$lid."<span class={$st}>".$telo['login']."</span> [".$telo['hp']."/".$telo['maxhp']."]";

return $outstring;
}

/////////////////////////////////////////////////////
    if (isset($miniBB_gzipper_encoding)) {
    $miniBB_gzipper_in = ob_get_contents();
    $miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
    $miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
    $miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
    $miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
    $gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
    $percent = round($gzpercent);
    $miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
    $miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
    ob_clean();
    header('Content-Encoding: '.$miniBB_gzipper_encoding);
    echo $miniBB_gzipper_out;
    }

/////////////////////////////////////////////////////

?>
