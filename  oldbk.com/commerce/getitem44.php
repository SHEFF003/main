<?
session_start();
include "/www/oldbk.com/connect.php";

$nclass_name[0]='�����';     //����������� = ������ ��������
$nclass_name[1]='���������';
$nclass_name[2]='��������';
$nclass_name[3]='����';
$nclass_name[4]='�����';     //����� ������ ����� = ����� ��������


function MK_UP_ART($dress,$nup)
{
//����� ��� ������� ���
$up=array();
$up[7] = array(	"level" => 7, 	"hp" => 6,	"bron" => 1,	"stat" => 1,	"mf" => 5,	"udar" => 1,	"nparam" => 1,	"duration" => 5,	"destiny" => false,	"nintel" => 0	);
$up[8] = array(	"level" => 8,	"hp" => 8,	"bron" => 1,	"stat" => 1,	"mf" => 7,	"udar" => 2,	"nparam" => 1,	"duration" => 5,	"destiny" => false,	"nintel" => 0	);
$up[9] = array(	"level" => 9,	"hp" => 10,	"bron" => 1,	"stat" => 1,	"mf" => 10,	"udar" => 3,	"nparam" => 1,	"duration" => 10,	"destiny" => false,	"nintel" => 0	);
$up[10] = array(	"level" => 10,	"hp" => 12,	"bron" => 1,	"stat" => 1,	"mf" => 12,	"udar" => 4,	"nparam" => 1,	"duration" => 10,	"destiny" => false,	"nintel" => 0	);
$up[11] = array(	"level" => 11,	"hp" => 15,	"bron" => 1,	"stat" => 1,	"mf" => 15,	"udar" => 1,	"nparam" => 1,	"duration" => 15,	"destiny" => false,	"nintel" => 0	);
$up[12] = array(	"level" => 12,	"hp" => 20,	"bron" => 1,	"stat" => 1,	"mf" => 17,	"udar" => 1,	"nparam" => 1,	"duration" => 15,	"destiny" => false,	"nintel" => 0	);
$up[13] = array(	"level" => 13,	"hp" => 27,	"bron" => 1,	"stat" => 1,	"mf" => 22,	"udar" => 2,	"nparam" => 1,	"duration" => 15,	"destiny" => false,	"nintel" => 0 ) ;
$up[14] = array(	"level" => 14, "hp" => 35,	"bron" => 1,	"stat" => 1,	"mf" => 27,	"udar" => 2,	"nparam" => 1,	"duration" => 15,	"destiny" => false,	"nintel" => 0 );

//��������� ��� ��� ������ ����
$upgrade=array();

for($i=$dress['nlevel']+1;$i<=$nup;$i++)
	{
	$upgrade['level']=$up[$i]['level'];
	$upgrade['hp']+=$up[$i]['hp'];	
	$upgrade['bron']+=$up[$i]['bron'];
	$upgrade['stat']+=$up[$i]['stat'];
	$upgrade['mf']+=$up[$i]['mf'];
	$upgrade['udar']+=$up[$i]['udar'];
	$upgrade['nparam']+=$up[$i]['nparam'];
	$upgrade['duration']+=$up[$i]['duration'];	
	}

//����� ��������
			$sharp=explode("+",$dress['name']);
			$basename=$sharp[0];
			if ((int)($sharp[1])>0) {$is_sharp="+".$sharp[1]; } else {$is_sharp='';}
			$newname = $basename." [".$upgrade['level']."]".$is_sharp;

///����� ������ ������
$dress['name']= $newname;
$dress['nlevel']=$upgrade['level'];
$dress['up_level']=$upgrade['level'];
$dress['maxdur']+=$upgrade['duration'];

		if ($dress['type'] == 3)
			{
			$dress['minu']+=$upgrade['udar'];
			$dress['maxu']+=$upgrade['udar'];
			}
		else
			{
		  	if ($dress['ghp'] > 0) {  $dress['ghp']+=$upgrade['hp']; }
			if ($dress['bron1'] > 0) { $dress['bron1']+=$upgrade['bron']; }
			if ($dress['bron2'] > 0) { $dress['bron2']+=$upgrade['bron']; }
			if ($dress['bron3'] > 0) { $dress['bron3']+=$upgrade['bron']; }
			if ($dress['bron4'] > 0) { $dress['bron4']+=$upgrade['bron']; }
			if (($dress['gsila'] != 0) OR ($dress['glovk']!=0) OR ($dress['ginta']!=0) OR ($dress['gintel']!=0) OR ($dress['stbonus']!=0)) { $dress['stbonus']+=$upgrade['stat']; }
			if (($dress['mfkrit'] !=0) OR ($dress['mfakrit']!=0) OR ($dress['mfuvorot']!=0) OR ($dress['mfauvorot']!=0) OR ($dress['mfbonus']!=0) ) { $dress['mfbonus']+=$upgrade['mf']; }
			}
		
		if ($dress['nsila'] > 0) { $dress['nsila']+=$upgrade['nparam']; }
		if ($dress['nlovk'] > 0) { $dress['nlovk']+=$upgrade['nparam']; }
		if ($dress['ninta'] > 0) { $dress['ninta']+=$upgrade['nparam']; }
		if ($dress['nvinos'] > 0) { $dress['nvinos']+=$upgrade['nparam']; }
		if ($dress['nnoj'] > 0) { $dress['nnoj']+=$upgrade['nparam']; }
		if ($dress['ntopor'] > 0) { $dress['ntopor']+=$upgrade['nparam']; }
		if ($dress['ndubina'] > 0) { $dress['ndubina']+=$upgrade['nparam']; }
		if ($dress['nmech'] > 0) { $dress['nmech']+=$upgrade['nparam']; }


return $dress;
}

function s_nick($id,$align,$klan,$login,$level)
{

  if($align!=''){
  $align="<img src=https://i.oldbk.com/i/align_".$align.".gif border=0>";
  }
  else
  {
   $align='';
  }
  if($klan!=''){
  $klan="<img src=https://i.oldbk.com/i/klan/".$klan.".gif border=0>";
        }
        else
        {
         $klan='';
        }

  $r_info=$align.$klan."<b>".$login."</b>[".$level."]<a target=_blank href=/inf.php?".$id."><img border=0 src=https://i.oldbk.com/i/inf.gif></a>";
  return $r_info;

}

function check_users_city_data($id)
{
    $user_city=mysql_fetch_array(mysql_query('SELECT * from oldbk.`users` where id="'.$id.'";'));
	if(!$user_city)
	{
		$user_city=FALSE;
	}
	else
    if($user_city['id_city']==1)
	{
		$user_city=mysql_fetch_array(mysql_query('SELECT * from avalon.`users` where id="'.$id.'";'));
	}
    return  $user_city;
}


$unikid = explode("_",$_GET['id']);
if (count($unikid) != 2) die();

function ShowARTForm($oldart,$newart) {
global $nclass_name;
	$us = check_users_city_data($_SESSION['uid']);

	$newart['present']=$oldart['present'];

	echo "<table align=center border=0 cellpadding=10 cellspacing=0 class=\"tbl_inside\" width=\"80%\" >";	
	$co[1]='#f4f2e9';
	$co[2]='#f9f7ee';
	$c=2;
	echo '<tr bgcolor="'.$co[$c].'"><td valign=top width="45%">';
echo "<div align=center><b>�� �������:</b></div>";
	echo "<div id=\"old_img\">";
	echo "<img src=https://i.oldbk.com/i/sh/$oldart[img]><br><br>";
	echo "</div>";

	if ($oldart['nalign']==1) {
		$print_align='1.5';
	} else {
		$print_align=$oldart['nalign'];
	}

	$ehtml=str_replace('.gif','',$oldart['img']);
	$razdel=array(1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
	24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun");

	$oldart['otdel']==''?$xx=$oldart['razdel']:$xx=$oldart['otdel'];
	if($razdel[$xx]=='') {
		$razdel[$xx]='predmeti';
	} else {
		$razdel[$xx]=$razdel[$xx]."/".$ehtml;
	}

		if ( ($oldart['includemagic']>0) AND ($oldart['includemagicuses']>0)  )
		{
		$incmagic=mysql_fetch_array(mysql_query("select * from oldbk.magic  where id=".$oldart['includemagic']));
		///������� ������� �� ������� ����
						$newart['includemagic']=$oldart['includemagic'];
						$newart['includemagicdex']=$oldart['includemagicdex'];
						$newart['includemagicmax']=$oldart['includemagicmax'];
						$newart['includemagicname']=$oldart['includemagicname'];
						$newart['includemagicuses']=$oldart['includemagicuses'];
						$newart['includemagiccost']=$oldart['includemagiccost'];
						$newart['includemagicekrcost']=$oldart['includemagicekrcost'];
						$newart['nintel']=$newart['nintel']<$oldart['nintel']?$oldart['nintel']:$newart['nintel'];
						$newart['nmudra']=$newart['nmudra']<$oldart['nmudra']?$oldart['nmudra']:$newart['nmudra'];
						$newart['nfire']=$newart['nfire']<$oldart['nfire']?$oldart['nfire']:$newart['nfire'];
						$newart['nwater']=$newart['nwater']<$oldart['nwater']?$oldart['nwater']:$newart['nwater'];
						$newart['nair']=$newart['nair']<$oldart['nair']?$oldart['nair']:$newart['nair'];
						$newart['nearth']=$newart['nearth']<$oldart['nearth']?$oldart['nearth']:$newart['nearth'];
						$newart['nlight']=$newart['nlight']<$oldart['nlight']?$oldart['nlight']:$newart['nlight'];
						$newart['ngray']=$newart['ngray']<$oldart['ngray']?$oldart['ngray']:$newart['ngray'];
						$newart['ndark']=$newart['ndark']<$oldart['ndark']?$oldart['ndark']:$newart['ndark'];

		$incmagic['max']=$newart['includemagicmax'];
		$incmagic['name']=$newart['includemagicname'];
		$incmagic['cur']=$newart['includemagicdex'];
		$incmagic['uses']=$newart['includemagicuses'];
		}
	
		if ($oldart['sowner']>0)
			{
			$sowner= '<font color=red>������ ���� ����� ������ ������</font> '.s_nick($us['id'],$us['align'],$us['klan'],$us['login'],$us['level']);	
			}


	echo "<a href=https://oldbk.com/encicl/".$razdel[$xx].".html target=_blank><b>{$oldart['name']}</b></a>";
	echo "<img src=https://i.oldbk.com/i/align_{$print_align}.gif> (�����: {$oldart['massa']})".(($oldart['present'])?' <IMG SRC="https://i.oldbk.com/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="���� ������� ��� ������� '.$oldart['present'].'. �� �� ������� �������� ���� ������� ����-���� ���." ALT="���� ������� ��� ������� '.$oldart['present'].'. �� �� ������� �������� ���� ������� ����-���� ���.">':"")."<BR>";
	echo $sowner;
	echo "<BR>������������� : {$oldart['duration']}/{$oldart['maxdur']}<BR>";
	echo (($oldart['ups']>0)?"���������:<b>{$oldart['ups']} ���</b><BR>":"");
	echo (($oldart['stbonus']>0)?"��������� ����������: ".($artun==1?"<font color=red>":"")."<b>{$oldart['stbonus']}</b>".($artun==1?" </font><b class=text2><font color=red>(� ��������� ������������� ����� ������������ ���������)</font></b>":"")."<BR>":"");
	echo (($oldart['mfbonus']>0)?"��������� ���������� ��: ".($artun==1?"<font color=red>":"")."<b>{$oldart['mfbonus']}</b>".($artun==1?" </font><b class=text2><font color=red>(� ��������� ������������� ����� ������������ ���������)</font></b>":"")."</b><BR>":"");
	echo (($magic['chanse'])?"����������� ������������: ".$magic['chanse']."%<BR>":"")."
	".(($magic['time'])?"����������������� �������� �����: ".$magic['time']." ���.<BR>":"")."
	".(($oldart['goden'])?"���� ��������: {$oldart['goden']} ��. ".(((!$oldart[GetShopCount()])or($_SERVER['PHP_SELF']=='/comission.php')or($_SERVER['PHP_SELF']=='/main.php'))?"(�� ".date("d.m.Y H:i",$oldart['dategoden']).")":"")."<BR>":"")."
	".(($oldart['nsex']==1)?"� ���: <b>�������</b><br>":"")."
	".(($oldart['nsex']==2)?"� ���: <b>�������</b><br>":"");
	
	
	echo (($oldart['nsila'] OR $oldart['nlovk'] OR $oldart['ninta'] OR $oldart['nvinos'] OR $oldart['nlevel'] OR $oldart['nintel'] OR $oldart['nmudra'] OR $oldart['nnoj'] OR $oldart['ntopor'] OR $oldart['ndubina'] OR $oldart['nmech'] OR $oldart['nfire'] OR $oldart['nwater'] OR $oldart['nair'] OR $oldart['nearth'] OR $oldart['nearth'] OR $oldart['nlight'] OR $oldart['ngray'] OR $oldart['ndark'] OR ($oldart['nclass'] >0)  )?"<br>��������� �����������:<BR>":"");
	
				if ($oldart['nclass'] >0) 
			{
				if ($nclass_name[$oldart['nclass']]!='')
				{	
				echo "� ����� ���������: <b>{$nclass_name[$oldart['nclass']]}</b><br>";
				}
			}
	
	echo (($oldart['nsila']>0)?"� ����: {$oldart['nsila']}</font><BR>":"")."
	".(($oldart['nlovk']>0)?"� ��������: {$oldart['nlovk']}</font><BR>":"")."
	".(($oldart['ninta']>0)?"� ��������: {$oldart['ninta']}</font><BR>":"")."
	".(($oldart['nvinos']>0)?"� ������������: {$oldart['nvinos']}</font><BR>":"")."
	".(($oldart['nlevel']>0)?"� �������: {$oldart['nlevel']}</font><BR>":"")."
	".(($oldart['nintel']>0)?"� ���������: {$oldart['nintel']}</font><BR>":"")."
	".(($oldart['nmudra']>0)?"� ��������: {$oldart['nmudra']}</font><BR>":"")."
	".(($oldart['nnoj']>0)?"� ���������� �������� ������ � ���������: {$oldart['nnoj']}</font><BR>":"")."
	".(($oldart['ntopor']>0)?"� ���������� �������� �������� � ��������: {$oldart['ntopor']}</font><BR>":"")."
	".(($oldart['ndubina']>0)?"� ���������� �������� �������� � ��������: {$oldart['ndubina']}</font><BR>":"")."
	".(($oldart['nmech']>0)?"� ���������� �������� ������: {$oldart['nmech']}</font><BR>":"")."
	".(($oldart['nfire']>0)?"� ���������� �������� ������� ����: {$oldart['nfire']}</font><BR>":"")."
	".(($oldart['nwater']>0)?"� ���������� �������� ������� ����: {$oldart['nwater']}</font><BR>":"")."
	".(($oldart['nair']>0)?"� ���������� �������� ������� �������: {$oldart['nair']}</font><BR>":"")."
	".(($oldart['nearth']>0)?"� ���������� �������� ������� �����: {$oldart['nearth']}</font><BR>":"")."
	".(($oldart['nlight']>0)?"� ���������� �������� ������ �����: {$oldart['nlight']}</font><BR>":"")."
	".(($oldart['ngray']>0)?"� ���������� �������� ����� ������: {$oldart['ngray']}</font><BR>":"")."
	".(($oldart['ndark']>0)?"� ���������� �������� ������ ����: {$oldart['ndark']}</font><BR>":"")."
	".(($oldart['gmeshok'] OR $oldart['gsila'] OR $oldart['mfkrit'] OR $oldart['mfakrit']  OR $oldart['mfuvorot'] OR $oldart['mfauvorot']  OR $oldart['glovk'] OR $oldart['ghp'] OR $oldart['ginta'] OR $oldart['gintel'] OR $oldart['gnoj'] OR $oldart['gtopor'] OR $oldart['gdubina'] OR $oldart['gmech'] OR $oldart['gfire'] OR $oldart['gwater'] OR $oldart['gair'] OR $oldart['gearth'] OR $oldart['gearth'] OR $oldart['glight'] OR $oldart['ggray'] OR $oldart['gdark'] OR $oldart['minu'] OR $oldart['maxu'] OR $oldart['bron1'] OR $oldart['bron2'] OR $oldart['bron3'] OR $oldart['bron4'])?"<br>��������� ��:":"")."
	".(($oldart['minu'])?"� ����������� ��������� �����������: ".($oldart[type]==3?"":"+")."{$oldart['minu']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$oldart[artminu]})</font></b>":"")."<BR>":"")."
	".(($oldart['maxu'])?"� ������������ ��������� �����������: ".($oldart[type]==3?"":"+")."{$oldart['maxu']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$oldart[artmaxu]})</font></b>":"")."<BR>":"");
	echo ((($oldart['gsila']) or ($artun==1) )?"<BR>� ����: ".(($oldart['gsila']>0 )?"+":"")."{$oldart['gsila']}":"")."
	".(( ($oldart['stbonus']>0) and ( $oldart['gsila']!=0) and ($artun==0) )?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['gsila']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_sila id=amc_sila value=1 onclick='Calcst(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($oldart['glovk']) or ($artun==1))?"<BR>� ��������: ".(($oldart['glovk']>0)?"+":"")."{$oldart['glovk']}":"")."
	".(( ($oldart['stbonus']>0) and ( $oldart['glovk']!=0 ) and ($artun==0))?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['glovk']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_lovk id=amc_lovk value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"")."
	".((($oldart['ginta']) or ($artun==1))?"<BR>� ��������: ".(($oldart['ginta']>0)?"+":"")."{$oldart['ginta']}":"")."
	".(( ($oldart['stbonus']>0) and ($oldart['ginta']!=0) and ($artun==0))?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['ginta']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_inta id=amc_inta value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"")."
	".((($oldart['gintel']) or ($artun==1))?"<BR>� ���������: ".(($oldart['gintel']>0)?"+":"")."{$oldart['gintel']}":"")."
	".(( ($oldart['stbonus']>0) and ($oldart['gintel']!=0) and ($artun==0))?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['gintel']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_intel id=amc_intel value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"")."
	".((($oldart['gmp']) or ($artun==1))?"<BR>� ��������: ".(($oldart['gmp']>0)?"+":"")."{$oldart['gmp']}":"")."
	".(( ($oldart['stbonus']>0) and ($oldart['gmp']!=0) and ($artun==0))?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['gmp']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_gmp id=amc_gmp value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"");
	echo ((($oldart['ghp'])OR($artun==1))?"<BR>� ������� �����: +{$oldart['ghp']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$oldart[artghp]})</font></b> ".(($oldart[artbron1]>0)?"<a style=\"padding:0;\"><img src='https://i.oldbk.com/i/up.gif'   alt='���������' title='���������'></a>":"")."  ".(($oldart[artghp] > 0)?"<a  style=\"padding:0;\" ><img src='https://i.oldbk.com/i/down.gif' alt='���������' title='���������'></a>":"")." (5 HP = 1 �����)  ":"")."":"");	
	echo ((($oldart['mfkrit']) or ($artun==1))?"<BR>� ��. ����������� ������: ".(($oldart['mfkrit']>0)?"+":"")."{$oldart['mfkrit']}%":"")."
	".(( ($oldart['mfbonus']>0) and ( $oldart['mfkrit']!=0 ) and ($artun==0))?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['mfkrit']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_mkrit id=amc_mkrit value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($oldart['mfakrit']) or ($artun==1))?"<BR>� ��. ������ ����. ������: ".(($oldart['mfakrit']>0)?"+":"")."{$oldart['mfakrit']}%":"")."
	".(( ($oldart['mfbonus']>0) and ( $oldart['mfakrit']!=0 ) and ($artun==0))?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['mfakrit']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_makrit id=amc_makrit value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($oldart['mfuvorot']) or ($artun==1))?"<BR>� ��. ������������: ".(($oldart['mfuvorot']>0)?"+":"")."{$oldart['mfuvorot']}%":"")."
	".(( ($oldart['mfbonus']>0) and ( $oldart['mfuvorot']!=0 ) and ($artun==0) )?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['mfuvorot']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_muvorot id=amc_muvorot value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($oldart['mfauvorot']) or ($artun==1))?"<BR>� ��. ������ ��������.: ".(($oldart['mfauvorot']>0)?"+":"")."{$oldart['mfauvorot']}%":"")."
	".(( ($oldart['mfbonus']>0) and ( $oldart['mfauvorot']!=0 ) and ($artun==0) )?"<a><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($oldart['mfauvorot']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_mauvorot id=amc_mauvorot value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"");
	echo "<BR>";
	echo (($oldart['gnoj'])?"� ���������� �������� ������ � ���������: +{$oldart['gnoj']}<BR>":"")."
	".(($oldart['gtopor'])?"� ���������� �������� �������� � ��������: +{$oldart['gtopor']}<BR>":"")."
	".(($oldart['gdubina'])?"� ���������� �������� �������� � ��������: +{$oldart['gdubina']}<BR>":"")."
	".(($oldart['gmech'])?"� ���������� �������� ������: +{$oldart['gmech']}<BR>":"")."
	".(($oldart['gfire'])?"� ���������� �������� ������� ����: +{$oldart['gfire']}<BR>":"")."
	".(($oldart['gwater'])?"� ���������� �������� ������� ����: +{$oldart['gwater']}<BR>":"")."
	".(($oldart['gair'])?"� ���������� �������� ������� �������: +{$oldart['gair']}<BR>":"")."
	".(($oldart['gearth'])?"� ���������� �������� ������� �����: +{$oldart['gearth']}<BR>":"")."
	".(($oldart['glight'])?"� ���������� �������� ������ �����: +{$oldart['glight']}<BR>":"")."
	".(($oldart['ggray'])?"� ���������� �������� ����� ������: +{$oldart['ggray']}<BR>":"")."
	".(($oldart['gdark'])?"� ���������� �������� ������ ����: +{$oldart['gdark']}<BR>":"")."
	".(($oldart['bron1'])?"� ����� ������: {$oldart['bron1']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$oldart[artbron1]})</font></b>":"")." <BR>":"")."
	".(($oldart['bron2'])?"� ����� �������: {$oldart['bron2']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$oldart[artbron2]})</font></b>":"")."<BR>":"")."
	".(($oldart['bron3'])?"� ����� �����: {$oldart['bron3']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$oldart[artbron3]})</font></b>":"")."<BR>":"")."
	".(($oldart['bron4'])?"� ����� ���: {$oldart['bron4']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$oldart[artbron4]})</font></b>":"")."<BR>":"")."
	".(($oldart['gmeshok'])?"� ����������� ������: +{$oldart['gmeshok']}<BR>":"")."
	".(($oldart['present'])?"<br>������� ��: <b>".$oldart['present']."</b><br>":"")."
	".(($oldart['letter'])?"���������� ��������: ".strlen($oldart['letter'])."<br>":"")."
	".(($oldart['letter'])?"�� ������ ������� �����:<div style='background-color:FAF0E6;'> ".$oldart['letter']."</div>":"")."
	".(($oldart['prokat_idp']>0)?"��������:".floor(($oldart['prokat_do']-time())/60/60)." �. ".round((($oldart['prokat_do']-time())/60)-(floor(($oldart['prokat_do']-time())/3600)*60))." ���.<br>":"")."
	".(($magic['name'] && $oldart['type'] != 50)?"<font color=maroon>�������� ��������:</font> ".$magic['name']."<BR>":"")."
	".(($magic['name'] && $oldart['type'] == 50)?"<font color=maroon>��������:</font> ".$magic['name']."<BR>":"")."
	".(($oldart['text'])?"�� ����� ������������� �������:<center>".$oldart['text']."</center><BR>":"")."
	".(($oldart['present_text'])?"�� ������� ������� �����:<br />".$oldart['present_text']."<BR>":"")."
	".(($incmagic['max'])?"	�������� �������� <img src=\"https://i.oldbk.com/i/magic/".$incmagic['img']."\" title=\"".$incmagic['name']."\"> ".$incmagic['cur']." ��.	<BR> "."��������� �������: ".$incmagic['nlevel']." <BR> ":"")."
	".(($incmagic['max'])? "�-�� �����������: ".$incmagic['uses']."<br/>" : "")."
	".(($oldart['labonly']==1)?"<small><font color=maroon>������� �������� ����� ������ �� ���������</font></small><BR>":"")."
	".((!$oldart['isrep'])?"<small><font color=maroon>������� �� �������� �������</font></small><BR>":"");

	if ($oldart[type]==27) {
		echo "<br>�����������:<br>� ����� ��������� �� �����<br>";
	} elseif ($oldart[type]==28) {
		echo "<br>�����������:<br>� ����� ��������� ��� �����<br>";
	}

	echo '</td><td valign=center width="10%"><img src="https://i.oldbk.com/i/greenarrow.png"></td>';
	echo '<td valign=top width="45%">';
if ($newart['id']>0)
{
echo "<div align=center><b>�� ���������:</b></div>";
	echo "<div id=\"old_img\">";
	echo "<img src=https://i.oldbk.com/i/sh/$newart[img]><br><br>";
	echo "</div>";


	if ($newart['nalign']==1) {
		$print_align='1.5';
	} else {
		$print_align=$newart['nalign'];
	}

	$ehtml=str_replace('.gif','',$newart['img']);
	$razdel=array(1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
	24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun");

	$newart['otdel']==''?$xx=$newart['razdel']:$xx=$newart['otdel'];
	if($razdel[$xx]=='') {
		$razdel[$xx]='predmeti';
	} else {
		$razdel[$xx]=$razdel[$xx]."/".$ehtml;
	}

	/*
	if ($newart['gsila'] > 0 || $newart['glovk'] || $newart['ginta'] || $newart['gintel'] || $newart['gmudra']) $newart['stbonus'] += 3;
	if ($newart['ghp'] > 0) $newart['ghp'] += 20;

	if ($newart['bron1'] > 0) $newart['bron1'] += 3;
	if ($newart['bron2'] > 0) $newart['bron2'] += 3;
	if ($newart['bron3'] > 0) $newart['bron3'] += 3;
	if ($newart['bron4'] > 0) $newart['bron4'] += 3;
	$newart['name'].= ' (��)';
	*/
	
					
					
						//������� ��������� ���
						if ($oldart['nlevel']>$newart['nlevel'])
						{
						$newart=MK_UP_ART($newart,$oldart['nlevel']);
						}
					
					
					//������� ����� ���� ��� �����
					if (($oldart['type']==3) AND ($newart['type']==3) )
					{
						//���� �������
						if (strpos($oldart['name'], '+') == true)
						{
						$tempa=explode("+",$oldart['name']);
						$sharp=(int)($tempa[1]);
												
							
							if ($sharp>0)
							{
					 		 $newart['minu']+=$sharp;
					 		 $newart['maxu']+=$sharp;
					 		 $newart['cost']+=30;
					 		 $newart['name']=$newart['name']."+".$sharp;
					 		 $newart['sharped']=1;
					 		 
					 		 $newart['otdel']=$newart['razdel'];//�.�. ����� �� ������
					 		 
								 if ($newart['otdel']==1) 
								 		{ 
								 		$newart['nnoj']+=$sharp;
								 		$newart['ninta']+=$sharp;
								 		}
								 else
								 if ($newart['otdel']==11) 
								 		{
					 					$newart['ntopor']+=$sharp;
					 					$newart['nsila']+=$sharp;
								 		}
								 else
								 if ($newart['otdel']==12) 
								 		{
										$newart['ndubina']+=$sharp;
										$newart['nlovk']+=$sharp;
										}
								else
					 			 if ($newart['otdel']==13) 
					 			 		{
									 	$newart['nmech']+=$sharp;
									 	$newart['nvinos']+=$sharp;
									 	}
							}
						} 
					
					}
					elseif (($oldart['type']==3) AND (strpos($oldart['name'], '+') == true) )
					{
					//���� ������ ������� ���� � ������ � ����� �����
						$tempa=explode("+",$oldart['name']);
						$add_sharp_scroll=(int)($tempa[1]);
						
						$otdel = $oldart['otdel'];
							
							$z = array(
								1 => array(
									1 => 163,
									2 => 164,
									3 => 165,		
									4 => 166,
									5 => 167,
								),
								11 => array(
									1 => 157157,
									2 => 156156,
									3 => 155,		
									4 => 154,
									5 => 85,
								),
								12 => array(
									1 => 158,
									2 => 159,
									3 => 160,		
									4 => 161,
									5 => 162,
								),
								13 => array(
									1 => 150,
									2 => 151,
									3 => 152,		
									4 => 153,
									5 => 84,
								),
							);
							$zz = array(6 => 9090, 7 => 190190, 8=>190191 , 9=>190192);

							if ($add_sharp_scroll <= 5) {
								$dress = mysql_query('SELECT * FROM oldbk.shop WHERE id = '.$z[$oldart['otdel']][$add_sharp_scroll]) or die("Errr0001");								
							} else {
								$dress = mysql_query('SELECT * FROM oldbk.eshop WHERE id = '.$zz[$add_sharp_scroll]) or die("Errr00011");
							}
							$sharp_scroll = mysql_fetch_assoc($dress);
						
						
						
					}
	

	

	echo "<a href=https://oldbk.com/encicl/".$razdel[$xx].".html target=_blank><b>{$newart['name']}</b></a>";
	echo "<img src=https://i.oldbk.com/i/align_{$print_align}.gif> (�����: {$newart['massa']})".(($newart['present'])?' <IMG SRC="https://i.oldbk.com/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="���� ������� ��� ������� '.$newart['present'].'. �� �� ������� �������� ���� ������� ����-���� ���." ALT="���� ������� ��� ������� '.$newart['present'].'. �� �� ������� �������� ���� ������� ����-���� ���.">':"")."<BR>";
	echo $sowner;
	echo "<BR>������������� : {$newart['duration']}/{$newart['maxdur']}<BR>";
	echo (($newart['ups']>0)?"���������:<b>{$newart['ups']} ���</b><BR>":"");
	echo (($newart['stbonus']>0)?"��������� ����������: ".($artun==1?"<font color=red>":"")."<b>{$newart['stbonus']}</b>".($artun==1?" </font><b class=text2><font color=red>(� ��������� ������������� ����� ������������ ���������)</font></b>":"")."<BR>":"");
	echo (($newart['mfbonus']>0)?"��������� ���������� ��: ".($artun==1?"<font color=red>":"")."<b>{$newart['mfbonus']}</b>".($artun==1?" </font><b class=text2><font color=red>(� ��������� ������������� ����� ������������ ���������)</font></b>":"")."</b><BR>":"");
	echo (($magic['chanse'])?"����������� ������������: ".$magic['chanse']."%<BR>":"")."
	".(($magic['time'])?"����������������� �������� �����: ".$magic['time']." ���.<BR>":"")."
	".(($newart['nsex']==1)?"� ���: <b>�������</b><br>":"")."
	".(($newart['nsex']==2)?"� ���: <b>�������</b><br>":"");
	
			
	echo (($newart['nsila'] OR $newart['nlovk'] OR $newart['ninta'] OR $newart['nvinos'] OR $newart['nlevel'] OR $newart['nintel'] OR $newart['nmudra'] OR $newart['nnoj'] OR $newart['ntopor'] OR $newart['ndubina'] OR $newart['nmech'] OR $newart['nfire'] OR $newart['nwater'] OR $newart['nair'] OR $newart['nearth'] OR $newart['nearth'] OR $newart['nlight'] OR $newart['ngray'] OR $newart['ndark'] OR ($newart['nclass'] >0) )?"<br>��������� �����������:<BR>":"");
	
		if ($newart['nclass'] >0) 
			{
				if ($nclass_name[$newart['nclass']]!='')
				{	
				echo "� ����� ���������: <b>{$nclass_name[$newart['nclass']]}</b><br>";
				}
			}
	
	echo (($newart['nsila']>0)?"� ����: {$newart['nsila']}</font><BR>":"")."
	".(($newart['nlovk']>0)?"� ��������: {$newart['nlovk']}</font><BR>":"")."
	".(($newart['ninta']>0)?"� ��������: {$newart['ninta']}</font><BR>":"")."
	".(($newart['nvinos']>0)?"� ������������: {$newart['nvinos']}</font><BR>":"")."
	".(($newart['nlevel']>0)?"� �������: {$newart['nlevel']}</font><BR>":"")."
	".(($newart['nintel']>0)?"� ���������: {$newart['nintel']}</font><BR>":"")."
	".(($newart['nmudra']>0)?"� ��������: {$newart['nmudra']}</font><BR>":"")."
	".(($newart['nnoj']>0)?"� ���������� �������� ������ � ���������: {$newart['nnoj']}</font><BR>":"")."
	".(($newart['ntopor']>0)?"� ���������� �������� �������� � ��������: {$newart['ntopor']}</font><BR>":"")."
	".(($newart['ndubina']>0)?"� ���������� �������� �������� � ��������: {$newart['ndubina']}</font><BR>":"")."
	".(($newart['nmech']>0)?"� ���������� �������� ������: {$newart['nmech']}</font><BR>":"")."
	".(($newart['nfire']>0)?"� ���������� �������� ������� ����: {$newart['nfire']}</font><BR>":"")."
	".(($newart['nwater']>0)?"� ���������� �������� ������� ����: {$newart['nwater']}</font><BR>":"")."
	".(($newart['nair']>0)?"� ���������� �������� ������� �������: {$newart['nair']}</font><BR>":"")."
	".(($newart['nearth']>0)?"� ���������� �������� ������� �����: {$newart['nearth']}</font><BR>":"")."
	".(($newart['nlight']>0)?"� ���������� �������� ������ �����: {$newart['nlight']}</font><BR>":"")."
	".(($newart['ngray']>0)?"� ���������� �������� ����� ������: {$newart['ngray']}</font><BR>":"")."
	".(($newart['ndark']>0)?"� ���������� �������� ������ ����: {$newart['ndark']}</font><BR>":"")."
	".(($newart['gmeshok'] OR $newart['gsila'] OR $newart['mfkrit'] OR $newart['mfakrit']  OR $newart['mfuvorot'] OR $newart['mfauvorot']  OR $newart['glovk'] OR $newart['ghp'] OR $newart['ginta'] OR $newart['gintel'] OR $newart['gnoj'] OR $newart['gtopor'] OR $newart['gdubina'] OR $newart['gmech'] OR $newart['gfire'] OR $newart['gwater'] OR $newart['gair'] OR $newart['gearth'] OR $newart['gearth'] OR $newart['glight'] OR $newart['ggray'] OR $newart['gdark'] OR $newart['minu'] OR $newart['maxu'] OR $newart['bron1'] OR $newart['bron2'] OR $newart['bron3'] OR $newart['bron4'])?"<br>��������� ��:":"")."
	".(($newart['minu'])?"<BR>� ����������� ��������� �����������: ".($newart[type]==3?"":"+")."{$newart['minu']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$newart[artminu]})</font></b>":"")."<BR>":"")."
	".(($newart['maxu'])?"� ������������ ��������� �����������: ".($newart[type]==3?"":"+")."{$newart['maxu']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$newart[artmaxu]})</font></b>":"")."<BR>":"");
	echo ((($newart['gsila']) or ($artun==1) )?"<BR>� ����: ".(($newart['gsila']>0 )?"+":"")."{$newart['gsila']}":"")."
	".(( ($newart['stbonus']>0) and ( $newart['gsila']!=0) and ($artun==0) )?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['gsila']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_sila id=amc_sila value=1 onclick='Calcst(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($newart['glovk']) or ($artun==1))?"<BR>� ��������: ".(($newart['glovk']>0)?"+":"")."{$newart['glovk']}":"")."
	".(( ($newart['stbonus']>0) and ( $newart['glovk']!=0 ) and ($artun==0))?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['glovk']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_lovk id=amc_lovk value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"")."
	".((($newart['ginta']) or ($artun==1))?"<BR>� ��������: ".(($newart['ginta']>0)?"+":"")."{$newart['ginta']}":"")."
	".(( ($newart['stbonus']>0) and ($newart['ginta']!=0) and ($artun==0))?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['ginta']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_inta id=amc_inta value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"")."
	".((($newart['gintel']) or ($artun==1))?"<BR>� ���������: ".(($newart['gintel']>0)?"+":"")."{$newart['gintel']}":"")."
	".(( ($newart['stbonus']>0) and ($newart['gintel']!=0) and ($artun==0))?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['gintel']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_intel id=amc_intel value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"")."
	".((($newart['gmp']) or ($artun==1))?"<BR>� ��������: ".(($newart['gmp']>0)?"+":"")."{$newart['gmp']}":"")."
	".(( ($newart['stbonus']>0) and ($newart['gmp']!=0) and ($artun==0))?"<a href='?act={$action}&edit=1&gmp=1&setup={$newart['id']}'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"")."
	".((($newart['gmp']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_gmp id=amc_gmp value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"");
	echo ((($newart['ghp'])OR($artun==1))?"<BR>� ������� �����: +{$newart['ghp']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$newart[artghp]})</font></b> ".(($newart[artbron1]>0)?"<a style=\"padding:0;\" href='?act={$action}&edit=1&arthp=1&setup={$newart['id']}'><img src='https://i.oldbk.com/i/up.gif'   alt='���������' title='���������'></a>":"")."  ".(($newart[artghp] > 0)?"<a  style=\"padding:0;\" href='?act={$action}&edit=1&arthpd=1&setup={$newart['id']}'><img src='https://i.oldbk.com/i/down.gif' alt='���������' title='���������'></a>":"")." (5 HP = 1 �����)  ":"")."":"");	
	echo ((($newart['mfkrit']) or ($artun==1))?"<BR>� ��. ����������� ������: ".(($newart['mfkrit']>0)?"+":"")."{$newart['mfkrit']}%":"")."
	".(( ($newart['mfbonus']>0) and ( $newart['mfkrit']!=0 ) and ($artun==0))?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['mfkrit']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_mkrit id=amc_mkrit value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($newart['mfakrit']) or ($artun==1))?"<BR>� ��. ������ ����. ������: ".(($newart['mfakrit']>0)?"+":"")."{$newart['mfakrit']}%":"")."
	".(( ($newart['mfbonus']>0) and ( $newart['mfakrit']!=0 ) and ($artun==0))?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['mfakrit']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_makrit id=amc_makrit value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($newart['mfuvorot']) or ($artun==1))?"<BR>� ��. ������������: ".(($newart['mfuvorot']>0)?"+":"")."{$newart['mfuvorot']}%":"")."
	".(( ($newart['mfbonus']>0) and ( $newart['mfuvorot']!=0 ) and ($artun==0) )?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['mfuvorot']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_muvorot id=amc_muvorot value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"")."
	".((($newart['mfauvorot']) or ($artun==1))?"<BR>� ��. ������ ��������.: ".(($newart['mfauvorot']>0)?"+":"")."{$newart['mfauvorot']}%":"")."
	".(( ($newart['mfbonus']>0) and ( $newart['mfauvorot']!=0 ) and ($artun==0) )?"<img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'>":"")."
	".((($newart['mfauvorot']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_mauvorot id=amc_mauvorot value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"");
	echo "<BR>";
	echo (($newart['gnoj'])?"� ���������� �������� ������ � ���������: +{$newart['gnoj']}<BR>":"")."
	".(($newart['gtopor'])?"� ���������� �������� �������� � ��������: +{$newart['gtopor']}<BR>":"")."
	".(($newart['gdubina'])?"� ���������� �������� �������� � ��������: +{$newart['gdubina']}<BR>":"")."
	".(($newart['gmech'])?"� ���������� �������� ������: +{$newart['gmech']}<BR>":"")."
	".(($newart['gfire'])?"� ���������� �������� ������� ����: +{$newart['gfire']}<BR>":"")."
	".(($newart['gwater'])?"� ���������� �������� ������� ����: +{$newart['gwater']}<BR>":"")."
	".(($newart['gair'])?"� ���������� �������� ������� �������: +{$newart['gair']}<BR>":"")."
	".(($newart['gearth'])?"� ���������� �������� ������� �����: +{$newart['gearth']}<BR>":"")."
	".(($newart['glight'])?"� ���������� �������� ������ �����: +{$newart['glight']}<BR>":"")."
	".(($newart['ggray'])?"� ���������� �������� ����� ������: +{$newart['ggray']}<BR>":"")."
	".(($newart['gdark'])?"� ���������� �������� ������ ����: +{$newart['gdark']}<BR>":"")."
	".(($newart['bron1'])?"� ����� ������: {$newart['bron1']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$newart[artbron1]})</font></b>":"")." <BR>":"")."
	".(($newart['bron2'])?"� ����� �������: {$newart['bron2']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$newart[artbron2]})</font></b>":"")."<BR>":"")."
	".(($newart['bron3'])?"� ����� �����: {$newart['bron3']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$newart[artbron3]})</font></b>":"")."<BR>":"")."
	".(($newart['bron4'])?"� ����� ���: {$newart['bron4']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$newart[artbron4]})</font></b>":"")."<BR>":"")."
	".(($newart['gmeshok'])?"� ����������� ������: +{$newart['gmeshok']}<BR>":"")."
	".(($newart['letter'])?"���������� ��������: ".strlen($newart['letter'])."</div>":"")."
	".(($newart['present'])?"<br>������� ��: <b>".$newart['present']."</b><br>":"")."
	".(($newart['letter'])?"�� ������ ������� �����:<div style='background-color:FAF0E6;'> ".$newart['letter']."</div>":"")."
	".(($newart['prokat_idp']>0)?"��������:".floor(($newart['prokat_do']-time())/60/60)." �. ".round((($newart['prokat_do']-time())/60)-(floor(($newart['prokat_do']-time())/3600)*60))." ���.<br>":"")."
	".(($magic['name'] && $newart['type'] != 50)?"<font color=maroon>�������� ��������:</font> ".$magic['name']."<BR>":"")."
	".(($magic['name'] && $newart['type'] == 50)?"<font color=maroon>��������:</font> ".$magic['name']."<BR>":"")."
	".(($newart['text'])?"�� ����� ������������� �������:<center>".$newart['text']."</center><BR>":"")."
	".(($newart['present_text'])?"�� ������� ������� �����:<br />".$newart['present_text']."<BR>":"")."
	".(($incmagic['max'])?"	�������� �������� <img src=\"https://i.oldbk.com/i/magic/".$incmagic['img']."\" title=\"".$incmagic['name']."\"> ".$incmagic['cur']." ��.	<BR> "."��������� �������: ".$incmagic['nlevel']." <BR> ":"")."
	".(($incmagic['max'])? "�-�� �����������: ".$incmagic['uses']."<br/>" : "")."
	".(($newart['labonly']==1)?"<small><font color=maroon>������� �������� ����� ������ �� ���������</font></small><BR>":"")."
	".((!$newart['isrep'])?"<small><font color=maroon>������� �� �������� �������</font></small><BR>":"");

	if ($newart[type]==27) {
		echo "<br>�����������:<br>� ����� ��������� �� �����<br>";
	} elseif ($newart[type]==28) {
		echo "<br>�����������:<br>� ����� ��������� ��� �����<br>";
	}
	
	
	if ($sharp_scroll)
	{
	echo "<br>";
	echo "<b>� �������� ��� ��:</b> ";
	echo "<img src='https://i.oldbk.com/i/sh/{$sharp_scroll['img']}' alt='{$sharp_scroll['name']}' title='{$sharp_scroll['name']}'>";
	echo "<br><small>������ ������� �������� ��������, ����� ������������� ������� ����� �������� � ���������.</small>";
	}
	
	
}
else	
	{
	echo "&nbsp;";
	}
	echo "</td></tr></table><br><br><br><br>";

		
		
	//������ ���������
	if ($oldart['type']==$newart['type'])	
		{
		$need_cost=20; //40
		}
		else
		{
		$need_cost=40; //80
		}
		

	$qexists = mysql_query('SELECT * FROM inventory WHERE owner = '.$us['id'].' AND setsale=0 and (prototype = 541) ORDER BY ecost DESC');	

	if ((($oldart['type']==$newart['type']) AND ($oldart['type']==3)) || mysql_num_rows($qexists))		
	{
	
	echo '

	<style>
	#snaptarget { height: 140px; background-color:#f2efe8;width:700px;border: 4px; border-style:double; border-color: #908869;}
	</style>
	<center>
	
	<div id="all2vconstr">
		<div id="snaptarget">
		����������� ���� ��������� ������ � ���.����� ��� ����������� �� ���������� ����� ��������� � �λ
	</div><br>';

	$ids = array();

	if ((($oldart['type']==$newart['type']) AND ($oldart['type']==3))) {
		$addsql = "prototype=100000 or ";
	} else {
	}
		
	$q = mysql_query('SELECT * FROM inventory WHERE owner = '.$us['id'].' AND setsale=0 and ('.$addsql.' prototype = 541) ORDER BY ecost DESC');	
if (mysql_num_rows($q) > 0) {
		while($i = mysql_fetch_assoc($q)) {
			$ids[] = $i['id'];
			echo '<span name="prot'.$i['prototype'].'" style="display:inline-block;" id="drag'.$i['id'].'"> <img alt="'.$i['name'].'" title="'.$i['name'].'" src="https://i.oldbk.com/i/sh/'.$i['img'].'"> </span> ';
		}
		echo '
		<script type="text/javascript">
		var spans = [];
		function CheckF() 
		{
			if (confirm("�� ������� ? ")) 
			{
				document.getElementById("mkec").submit();
			}
		}
	
		$("#all2vconstr span" ).draggable({ containment: "#all2vconstr", scroll: false});
		
		$("#all2vconstr span" ).bind( "dragstop", function(event, ui) 
		{
			spans.splice(0,spans.length) ;
			$("#all2vconstr span").each(function(index,item){
				m = $("#all2vconstr").offset().top ;
	
				if ( ($(item).offset().top-m) < ($("#snaptarget").height()-$(item).height())) 
				{ 
					spans.push(item);
				}
			});
	

	
			var ids = new Array();
	
			for (key in spans) {
				var n = spans[key];
				itemid = n.id;
				itemid = itemid.substring(4);
				if (isNaN(parseInt(itemid))) continue;
				itemproto = $("#"+n.id).attr("name");
				itemproto = itemproto.substr(4);
				ids.push(itemid);
			
				
				
				
			}                     
			document.getElementById("mkdartids").value = ids.join();

		});
		</script>';
		
	} else {
		echo '� ��� ��� ����������� ���������. ������ ������ ����� ���������� ����!';
	}	
	
	echo '</div></center></div>';
	}
	else
		{
		echo '
		<script>
		var spans = [];
		function CheckF() {
			

			if (confirm("�� �������?")) {
				document.getElementById("mkec").submit();
			}
			
		}
		</script>';
		
		
		}

	echo '<br><br><center>';
	$get_bank=mysql_query("select * from oldbk.bank where owner='{$us['id']}' ");

	$BANKS = "";
	
	if (mysql_num_rows($get_bank) > 0) {
		$BANKS="<select style='width:150px' name=bankid>";
		while($row = mysql_fetch_assoc($get_bank)) {
			$BANKS.="<option>".$row['id']."</option>";
		}
		$BANKS.="</select>";
	}
										
	echo '<form id="mkec" method="POST">
		<input type="hidden" id="new_art_proto" name="new_art_proto" value="'.$newart['id'].'">
		<input type="hidden" id="my_oldart" name="my_oldart" value="'.$oldart['id'].'">	
		<input type="hidden" id="mkdartids" name="mkdartids" value=""><table>
	';

	if (strlen($BANKS)) echo '<tr><td><input type="radio" name="paytype" value="0"></td><td>���������� ����: '.$BANKS.' ������ <input type=password size=8 name=bankpass></td></tr>';
	echo '<tr><td><input type="radio" name="paytype" value="1"></td><td>�������� ��������, � ��� � ������� <b>'.$us['gold'].'</b> �����</td></tr></table><br>';
	echo '<input type="button" value="��������" class="button2" name="��������" OnClick="CheckF();"></form><br>';				
	echo '</center>';
}

if ($_SESSION['uid']) {
	
	if ($unikid[0] > 0) {
		$id = intval($unikid[0]);
		$shop = intval($unikid[1]);
		
		if (!($id>0)) die();
	
		$get_proto = mysql_fetch_array(mysql_query("select * from oldbk.eshop where id in (2000,2001,2002,260,262,284,283,18210,18229,18247,18527) AND id = ".$id));
	
		if  ($get_proto[id]>0) {
			ShowARTForm($_SESSION['artinfo_old'],$get_proto); 
		} else {
			ShowARTForm($_SESSION['artinfo_old'],null); 
			//echo '<font color=red>������ ������ ���������, ������ �������� ����������!</font>';	
		}
	}
} else {
	die("<script>location.href='index.php?exit=314';</script>");
}

?>