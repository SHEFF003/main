<?php
	session_start();

	if (!($_SESSION['uid'] >0)) header("Location: index.php");
	include "connect.php";
	include "functions.php";	

	
	if ($user['room'] != 46) { header("Location: main.php"); die(); }
	
	if (isset($_GET['exit'])) {
		mysql_query("UPDATE `users` SET `users`.`room` = '66' WHERE `users`.`id` = '{$_SESSION['uid']}' ;") or die();
		{ header("Location: city.php"); die(); }
	}
	else
	if ((isset($_GET['bankexit'])) 	 and ($_SESSION['bankid']>0) ) 
	{
		unset($_SESSION['bankid']);
	}

	if (isset($_POST['fall'])) {
		$_SESSION['fall']=(int)$_POST['fall'];
	} else {
		$_POST['fall']=(int)$_SESSION['fall'];	
	}

		
	if ($_POST['fall']>0) {$viewlevel=true; } 

	
		$otels[1]="������: �������,����";
		$otels[11]="������: ������";
		$otels[12]="������: ������,������";
		$otels[13]="������: ����";
		$otels[2]="������: ������";
		$otels[21]="������: ��������";
		$otels[22]="������: ������ �����";
		$otels[23]="������: ������� �����";
		$otels[24]="������: �����";
		$otels[3]="����";
		$otels[4]="��������� ������: ������";
		$otels[41]="��������� ������: ��������";
		$otels[42]="��������� ������: ������";
		$otels[5]="����������: �����������";
		$otels[51]="����������: ������ � ��������";
		$otels[52]="������";
		$otels[6]="��������";
		$otels[61]="���";
		$otels[7]="��������: ��������";
		$otels[71]="��������: ������ �������";
		$otels[73]="��������: �������";
		$otels[72]="���������� �������";
		
		$_GET['otdel']=(int)$_GET['otdel'];
		$otel=$otels[$_GET['otdel']];
		if ($otel=='') 
			{
			$otel=$otels[2];
			$_GET['otdel']=2;
			}

	
	
	$d[0] = getmymassa($user);
	$prokat_count=mysql_fetch_array(mysql_query("select count(*) from oldbk.inventory where prokat_idp > 0 and  `owner` = '{$_SESSION['uid']}' ; "));

	if ($user['battle'] != 0) { header('location: fbattle.php'); die(); }
	//$_GET['otdel'] = 1;

	if($_POST['enter']!='' && $_POST['pass']!='') {
					$data = mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = '".$user['id']."' AND `id`= '".$_POST['id']."' AND `pass` = '".md5($_POST['pass'])."';");

					$data = mysql_fetch_array($data);
					if($data) {
						$_SESSION['bankid'] = $_POST['id'];
						//$error='������� ����.';
					}
					else
					{
					$error='������ �����.';
					}
	}

	if ($_SESSION['bankid']>0)
	{
	$bank = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`bank` WHERE `id` = ".$_SESSION['bankid'].";"));
	}


# Fix 22.04.2010, by 2FED
if($_SESSION['bankid']>0) {
$bank_owner = mysql_query("SELECT owner FROM oldbk.bank WHERE id='{$_SESSION['bankid']}'");
$bank_owner = mysql_fetch_array($bank_owner);
}

# Fix 22.04.2010, by 2FED
if($bank_owner['owner'] > 0 && ($bank_owner['owner'] != $user['id'])) {  err('������� ����...'); $_SESSION['bankid'] = null; }





	if (($_GET['set'] OR $_POST['set'])) {
		if ($_GET['set']) { $set =(int)($_GET['set']); }
		if ($_POST['set']) { $set =(int)($_POST['set']); }
		if ($_POST['count'] < 1) { $_POST['count'] =1; }
		$_POST['count']=(int)($_POST['count']);

		$dress = mysql_fetch_array(mysql_query("select *  from oldbk.shop id LEFT JOIN prokat itemid ON id=itemid where  `kol` > 0 AND `idp` = '{$set}' LIMIT 1;"));

		if ($dress[0]>0)
		 {
	 		$test=mysql_fetch_array(mysql_query("select count(*) from oldbk.inventory where prototype='{$dress[id]}' and prokat_idp > 0 and  `owner` = '{$_SESSION['uid']}' ; "));
		 }


		if ($_POST['count'] == 1)
			{
			$needpay=$dress['startpay'];
			$date_do_stamp=time()+86400; //������ + �����;
			 }
			 else
			 {
			$needpay=$dress['startpay']+($dress['daypay']*($_POST['count']-1));
			$date_do_stamp=time()+(86400*$_POST['count']); //������ + �����*���;
			 }
					 
		if ((int)$_GET['pveks']>0)
			{
			$pveks=(int)$_GET['pveks'];
			$load_veks=mysql_fetch_array(mysql_query("select * from oldbk.inventory where id='{$pveks}' and  owner='{$user['id']}' and prototype in (2016011,2016012,2016013,2016014,2016015,2016016) and setsale=0 "));
				if ($load_veks['id']>0)
					{
					$needpay=0;
					$time_config['2016011']=90;//�����
					$time_config['2016012']=60;//�����			
					$time_config['2016013']=30;//�����
					$time_config['2016014']=30;//�����
					$time_config['2016015']=30;//�����
					$time_config['2016016']=30;//�����			
					$add_days=$time_config[$load_veks['prototype']];
					if ($add_days<1) $add_days=1; // ��������
					$_POST['count']=$add_days;
					$date_do_stamp=time()+(86400*$add_days); //������ + �����*���;			
					}
			}
			 
		$date_do=date("d/m/Y H:i:s",$date_do_stamp);

 		if (($dress[0]>0) and ($test[0]>0))
 		{
		 $error = "<font color=red><b>� ��� � ������ ��� ���� ������ ���� �������.</b></font>";
 		}
		elseif($prokat_count[0]>2)
		 {
		 $error = "<font color=red><b>� ��� � ������ ��� ���� ��� ��������.</b></font>";
		 }
		 elseif (($dress['massa']+$d[0]) > (get_meshok())) {
			$error = "<font color=red><b>������������ ����� � �������.</b></font>";
		}
		elseif((($bank['ekr']>= ($needpay)) && ($dress['kol'] >= 1)) or
			 (($load_veks['id']>0) && ($dress['kol'] >= 1))	) 
		{


		if (give_count($user['id'],1) )
		{
		if (((int)($dress['mag'])>0) and ($dress['magname']!=''))
		 {
		$includemagic=$dress['mag'];
		$includemagicname=$dress['magname'];
		$includemagicdex=$dress['magcount'];
		$includemagicmax=$dress['magcount'];
		$includemagicuses='200';
		$includemagiccost=$dress['magcost'];
		 }
		 else
		 {
 		$includemagic='';
		$includemagicname='';
		$includemagicdex='';
		$includemagicmax='';
		$includemagicuses='';
		$includemagiccost='';
		 }

		$dress['name'].=' (������)';

			//������� ���� �������� ������� = �� ���
			$new_cost=0;
			for ($yy=1;$yy<=5;$yy++)
			{
			$new_cost_a=upgrade_item($dress['cost'],$yy);
			$new_cost+=$new_cost_a['cost_add'];
			}
		//� �� ��+���		
		$dress['cost']+=round($dress['cost']/2)+$new_cost+10;
		
		
		$dress['ghp']+=$dress['addhp'];

		$dress['bron1']=$dress['bron1']!=0 ?$dress['bron1']+$dress['addbron']:0;
		$dress['bron2']=$dress['bron2']!=0 ?$dress['bron2']+$dress['addbron']:0;		
		$dress['bron3']=$dress['bron3']!=0 ?$dress['bron3']+$dress['addbron']:0;				
		$dress['bron4']=$dress['bron4']!=0 ?$dress['bron4']+$dress['addbron']:0;				

		$mffbroninfo=0;
		if (($dress['bron1']>0) OR ($dress['bron2']>0) OR ($dress['bron3']>0) OR ($dress['bron4']>0))
		{
		$mffbroninfo=$dress['addbron'];
		}

		$dress['mfinfo']='a:3:{s:5:"stats";i:'.$dress['fstat'].';s:2:"hp";i:'.$dress['addhp'].';s:4:"bron";i:'.$mffbroninfo.';}';

		if ($dress['new_item']>0)			
		{
		//����� ��� ��������� ������
		$dress['charka']='5|a:1:{i:5;a:5:{i:0;a:1:{s:3:"ghp";i:35;}i:1;a:1:{s:5:"fstat";i:5;}i:2;a:1:{s:3:"fmf";i:60;}i:3;a:1:{s:2:"gw";i:2;}i:4;a:1:{s:2:"gm";i:2;}}}';
		$dress['ghp']+=35;
		$dress['fstat']+=5;
		$dress['fmf']+=60;
		$dress['gnoj']+=2;
		$dress['gtopor']+=2;
		$dress['gdubina']+=2;
		$dress['gmech']+=2;
		$dress['gfire']+=2;
		$dress['gwater']+=2;
		$dress['gair']+=2;
		$dress['gearth']+=2;
			/*
			������ ���������:
			��������� V ������:
			� ������� �����: +35
			� ��������� ����������: +5
			� ��������� ���������� ��: +60
			� ���������� �������� �������: +2
			� ���������� ���������� c�����: +2		
			*/
		}
		else
		{
		$dress['charka']='4|a:1:{i:4;a:5:{i:0;a:1:{s:3:"ghp";i:25;}i:1;a:1:{s:5:"fstat";i:3;}i:2;a:1:{s:3:"fmf";i:30;}i:3;a:1:{s:2:"gw";i:1;}i:4;a:1:{s:2:"gm";i:1;}}}';
		$dress['ghp']+=25;
		$dress['fstat']+=3;
		$dress['fmf']+=30;
		$dress['gnoj']+=1;
		$dress['gtopor']+=1;
		$dress['gdubina']+=1;
		$dress['gmech']+=1;
		$dress['gfire']+=1;
		$dress['gwater']+=1;
		$dress['gair']+=1;
		$dress['gearth']+=1;
		}


		 if(mysql_query("INSERT INTO oldbk.`inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`,`maxdur`,`isrep`,`nclass`,`mfinfo`,
					`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`otdel`,`unik`,
					`letter`,`present`, `includemagic`, `includemagicdex`, `includemagicmax`, `includemagicname`, `includemagicuses`, `includemagicekrcost`, `stbonus`, `ups`, `mfbonus`, `prokat_idp`, `prokat_do`,`idcity`,`charka`,`getfrom`
				)
				VALUES
				('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['nclass']}' , '{$dress['mfinfo']}'  , '{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','0','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['razdel']}',2,
				'������ ��: {$date_do}','��������� �����','{$includemagic}','{$includemagicdex}','{$includemagicmax}','{$includemagicname}','{$includemagicuses}','{$includemagiccost}','{$dress['fstat']}','{$dress['fups']}','{$dress['fmf']}','{$dress[idp]}','{$date_do_stamp}','{$user[id_city]}','{$dress['charka']}','44'
				) ;"))
				{
				
				if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com')
					{
					$mc='cap';
					}
				elseif ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com')
					{
					$mc='ava';
					}
				else   {
					$mc='none';
					}
				$dressid = $mc.mysql_insert_id();
				
				mysql_query("UPDATE `prokat` SET `kol`=`kol`-1 WHERE `idp` = '{$set}' LIMIT 1;");
				

				
				if ($load_veks['id']>0)
						{
								mysql_query("DELETE from oldbk.inventory where id='{$load_veks['id']}' LIMIT 1; ");
								$veks_info=" �������� ��������:(id:{$load_veks['id']}) {$load_veks['name']}  ";
						}
					else
					{
					mysql_query("UPDATE oldbk.`bank` set `ekr` = `ekr`- '".($needpay)."' WHERE id = {$bank['id']}");
					$bank['ekr'] -=$needpay;
					mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','������ ������ \"".$dress['name']."\"  <b>{$needpay} ���.</b>, <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$bank['id']}');");
					}


				//new_delo
  		    			$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='��������� �����';
					$rec['type']=8;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$needpay;
					$rec['sum_kom']=0;
					$rec['item_id']=$dressid;
					$rec['item_name']=$dress['name'];
					$rec['item_count']=1;
					$rec['item_type']=$dress['type'];
					$rec['item_cost']=$dress['cost'];
					$rec['item_dur']=$dress['duration'];
					$rec['item_maxdur']=$dress['maxdur'];
					$rec['item_ups']=$dress['fups'];
					$rec['item_unic']=0;
					$rec['item_incmagic']=$includemagicname;
					$rec['item_incmagic_count']=$includemagicuses;
					$rec['item_arsenal']='';
					$rec['bank_id']=$bank['id'];
					$rec['add_info']=$date_do.$veks_info;
					add_to_new_delo($rec); //�����				
				
				
				$error = "<font color=red><b>�� ���������� \"{$dress['name']}\" ������  {$_POST['count']} ����� �� {$needpay} ���. <i>(��: {$date_do})</i>.<br>{$veks_info}</b></font>";
				$prokat_count[0]++;
				}
				else {
					$error = "<font color=red><b>������ �������, �������� �������������.</b></font>";
				}



		}
		else
		{
		$error = "<font color=red><b>� ��� ������������ ������ �������!</b></font>";
		}



		}
		else {
			$error = "<font color=red><b>������������ ����� ��� ��� ����� � �������.</b></font>";
		}
	}
	else if (($_POST['setprod']) OR ($_GET['setprod']))
		{
		$_POST['prodlenie']=true; // ��� �� �������� �� ������ ��� �����������

		if ($_GET['setprod']) { $setprod =(int)($_GET['setprod']); }
		if ($_POST['setprod']) { $setprod =(int)($_POST['setprod']); }
		if ($_POST['count'] < 1) { $_POST['count'] =1; }
		$_POST['count']=(int)($_POST['count']);
		//���� �����
		$dress = mysql_fetch_array(mysql_query("select *  from oldbk.`inventory` LEFT JOIN `prokat` ON `prokat_idp`=`idp` where prokat_idp >0 and owner='{$user[id]}' and id={$setprod} LIMIT 1;"));
		// ������� �� ������� ��������
		$needpay=$dress['daypay']*($_POST['count']);
		$date_do_stamp=$dress['prokat_do']+(86400*$_POST['count']); // + �����*���;
		$date_do=date("d/m/Y H:i:s",$date_do_stamp);
		// ��������� ���� �� ����� � ����
		if(($bank['ekr']>= ($needpay)) && ($dress['prokat_idp'] > 0))
			{
	//����������
			if (
			mysql_query("UPDATE oldbk.`inventory` SET `prokat_do`='{$date_do_stamp}', `letter`='������ ��: {$date_do}'  WHERE `owner`='{$user[id]}' and `id`='{$dress[id]}' and `prokat_idp`='{$dress[idp]}' LIMIT 1 ;")
			)
			{
			//������� �����
			//new_delo
  		    			$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user['money'];
					$rec['owner_balans_posle']=$user['money'];
					$rec['target']=0;
					$rec['target_login']='��������� �����';
					$rec['type']=9;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=$needpay;
					$rec['sum_kom']=0;
					$rec['item_id']=get_item_fid($dress);
					$rec['item_name']=$dress['name'];
					$rec['item_count']=1;
					$rec['item_type']=$dress['type'];
					$rec['item_cost']=$dress['cost'];
					$rec['item_dur']=$dress['duration'];
					$rec['item_maxdur']=$dress['maxdur'];
					$rec['item_ups']=$dress['fups'];
					$rec['item_unic']=0;
					$rec['item_incmagic']=$dress['includemagicname'];
					$rec['item_incmagic_count']=$dress['includemagicuses'];
					$rec['item_arsenal']='';
					$rec['bank_id']=$bank['id'];
					$rec['add_info']=$date_do;
					add_to_new_delo($rec); //�����
			
			if (olddelo==1)
			{
			mysql_query("INSERT INTO oldbk.`delo` (`id` , `author` ,`pers`, `text`, `type`, `date`) VALUES ('','0','{$user['id']}','\"".$user['login']."\" ������� ������ ��������: \"".$dress['name']."\" id:(".get_item_fid($dress).") [{$dress['duration']}/".$dress['maxdur']."]/����.�����:{$includemagicname}/ups:{$dress['fups']}/ ������� ������  {$_POST['count']} ����� �� {$needpay} ���. (��: {$date_do})',1,'".time()."');");
			}
			mysql_query("UPDATE oldbk.`bank` set `ekr` = `ekr`- '".($needpay)."' WHERE id = {$bank['id']}");
			$bank['ekr'] -=$needpay;
			mysql_query("INSERT INTO `oldbk`.`bankhistory`(`date` , `text` , `bankid`) VALUES ('".time()."','��������� ������ ������ \"".$dress['name']."\"  <b>{$needpay} ���.</b>, <i>(�����: {$bank['cr']} ��., {$bank['ekr']} ���.)</i>','{$bank['id']}');");
			$error = "<font color=red><b>�� �������� ������ \"{$dress['name']}\" ��� �� {$_POST['count']} ����� �� {$needpay} ���. <i>(��: {$date_do})</i>.</b></font>";
			}
			else
			{
			$error = "<font color=red><b>������ ��������� ������, �������� �������������.</b></font>";
			}




			}
			else
			{
			$error="<font color=red><b>������������ ����� ��� � ��� ��� ������ ��������.</b></font>";
			}




		}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<META Http-Equiv=Cache-Control Content=no-cache>
	<meta http-equiv=PRAGMA content=NO-CACHE>
	<META Http-Equiv=Expires Content=0>
	<script type="text/javascript" src="/i/globaljs.js"></script>    
	<title>Old BK - ��������� �����</title>
	<link rel="StyleSheet" href="newstyle_loc4.css" type="text/css">
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<SCRIPT LANGUAGE="JavaScript">
	function AddDay(varname, name, txt, cost) {
	    var el = document.getElementById("hint3");
		el.innerHTML = '<form method=post style="margin:0px; padding:0px;" name="getd"><table border=0 width=100% cellspacing=1 cellpadding=0 bgcolor="#CCC3AA"><tr><td align=center><B>������ �� ��������� ����</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</TD></tr><tr><td colspan=2>'+
		'<table border=0 width=100% cellspacing=0 cellpadding=0 bgcolor="#FFF6DD"><tr><INPUT TYPE="hidden" name="'+varname+'" value="'+name+'"><td colspan=2 align=center><B>'+txt+' �� '+cost+' ���. �� <INPUT TYPE="text" NAME="count" ID="count" size=4 > �����</B></td></tr><tr><td align=center colspan=2>'+
		'<a href="javascript:void(0);" class="button-mid btn" title="����������" onClick="document.getd.submit();">����������</a>'+
		'</TD></TR></TABLE></td></tr></table></form>';
		el.style.visibility = "visible";
			el.style.left = (document.body.scrollLeft - 20) + 100 + 'px';
		el.style.top = (window.pageYOffset + 5) + 100 + 'px';
		document.getElementById("count").focus();

	}
	// ��������� ����
	function closehint3()
	{
		document.getElementById("hint3").style.visibility="hidden";
	}
	
	function showhide(id)
	{
	 if (document.getElementById(id).style.display=="none")
	 	{document.getElementById(id).style.display="block";}
	 else
	 	{document.getElementById(id).style.display="none";}
	}
	
	</SCRIPT>    
</head>
<body id="arenda-body">
<div id="page-wrapper">

    <div class="title">
        <div class="h3">��������� �����</div>
        <div id="buttons">
            <a class="button-dark-mid btn" href="javascript:void(0);" title="���������" onclick="window.open('help/prokat.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes');">���������</a>            
            <a class="button-mid btn" href="javascript:void(0);" title="��������" onclick="location.href='prokat.php?refresh='+Math.random();" >��������</a>                    
            <a class="button-mid btn" href="javascript:void(0);" title="���������" onclick="location.href='prokat.php?exit=1';">���������</a>
        </div>
    </div>



<?

if(!$_SESSION['bankid']) {
?>
    <div id="prokat">
        <table cellspacing="0" cellpadding="0">
            <colgroup>
                <col width="313px">
                <col width="900px">
                <col>
            </colgroup>
            <tbody>
            <tr>
                <td id="auth">
                    <div class="auth-block"><form method=post name="loginbank" action="prokat.php">
                        <div class="inner-auth">
                            <div class="auth-num">
                                <strong>�</strong>
<?


	$banks = mysql_query("SELECT * FROM oldbk.`bank` WHERE `owner` = ".$user['id'].";");
	echo "<select style='width:150px' name=id>";
	while ($rah = mysql_fetch_array($banks)) {
			echo "<option>",$rah['id'],"</option>";
	}
	echo "</select>";
?>
                            </div>
                            <div class="auth-pass">
                                <strong>������</strong> <input type=password name=pass size=21>
									   <input type=hidden name='enter' value='yes'>
                            </div>
                            <div class="center enter">
                                <a href="javascript:void(0);" class="button-big btn" title="�����" onClick="document.loginbank.submit();">�����</a>			
                            </div>
                        </div>
                        <div class="hint-block center"><? if ($error) {echo '<strong>'.$error.'</strong>'; }?>
                            ������������� ��� ���������� ������� �� <strong>���</strong>
                        </div>
                        </form>
                    </div>
                </td>

                <td style="padding-left: 50px;">
                    <div>
                                   <br><br>
                        <strong>
                            <span style="color: #003585;">���� �� ������ ��������� � ������ �� ��� ���������, ��������� ����� ������������� ��� ����� �����������.</span>
                        </strong>
                    </div>

                    <div style="margin-top: 20px;">
                        ����� ����� ����� ��������� ������ ��� �������������� �� ���� ��� ��������� ����. <br><br>
                        ������ ������� ���������.<br><br>
                        �� ������ ���������� �� 3� ��������� ����� ������������.<br><br>
                        ���������� ����� � ������ ��� ���������� ����.<br>
                    </div>
                    <br>
                    <div style="margin-top: 20px;">
                        ��� ������ ������� ����� �� ��������� ����, ������� �� 2�� ��� � ������ ��������� ������, ������, ��������� ������� ��� ����������� ������� ����������.<br><br>
                        �� ��������� ����� ������� ����� �������� ������ ����, �� ���������, ����� ���� ����� ���������� � �����.<br><br>
			<font color=#003388><b>�� ��������� ��������� � ��������� ���� ��������� �������</b></font>, ��� �� ��������� ����� ���� ����� ������������� ����� � ��� � ���������� � ��������� �����, ���� ���� � ��� ����� �� ������ � ���.</font><br><br>
                    </div>
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
<?
	die();
}
?>
    <div id="aukcion">
    <?=$error;?>
	 <table cellspacing="0" cellpadding="0" border="0">
            <colgroup>
                <col>
                <col width="300px">
            </colgroup>
            <tbody>
<TR>
	<TD valign=top align=left>

 <table cellspacing="0" cellpadding="0"  border="0" bgcolor="#A5A5A5">
<?
if ($_REQUEST['prodlenie']) { $otel="��������� ������" ; }
?>

<TR>
	<TD align=center><B><?=$otel;?></B></TD>
</TR>
<TR><TD>
<TABLE CLASS="a_strong" BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
<?

 if ($_POST['prodlenie'])
	{
	
		$data = mysql_query("select *  from oldbk.`inventory` LEFT JOIN `prokat` ON `prokat_idp`=`idp` where prokat_idp >0 and owner='{$user[id]}' ORDER by `prokat_do` ASC;");
	while($row = mysql_fetch_array($data)) {
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }

		if($row['add_pick']!=''&&$row['pick_time']>time())
			{
			$row['img']=$row['add_pick'];
			}

		echo "<TR bgcolor={$color}><TD align=center style='width:150px'><IMG SRC=\"http://i.oldbk.com/i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A HREF="prokat.php?otdel=<?=$_GET['otdel']?>&setprod=<?=$row['id']?>&sid=">�������� �� �����</A>
		<IMG SRC="i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="�������� �� ��������� ����" style="cursor: pointer" onclick="AddDay('setprod','<?=$row['id']?>', '<?=$row['name']?>','<?=$row['daypay']?>')"></TD>
		<?php
		echo "<TD valign=top>";
		$row['count']=1; // ��������

		echo "��������� ������:<b>$row[daypay] ���. �� �����</b><br>";
		$row[needident]=0;
		showitem ($row);
		echo "</TD></TR>";
	}

	}
else
	{
	
	if ($viewlevel==true) 
  		{
/*
  			if ($user['level']>13)
  			{
	  		$addlvl=" and nlevel='13'  ";  			
  			}
  			else
  			{*/
	  		$addlvl=" and nlevel='{$user['level']}'  ";
	  		//}
  		}
  		else
  		{
  		$addlvl="";
  		}
  		
	$bonus_veks=array();
	$load_veks=mysql_query("select * from oldbk.inventory where owner='{$user['id']}' and prototype in (2016011,2016012,2016013,2016014,2016015,2016016) and setsale=0 ");
	if (mysql_num_rows($load_veks) > 0) 
		{	
		while($veks = mysql_fetch_array($load_veks)) 
			{
			$bonus_veks[$veks[id]]=$veks;
			}
		}
	
	
	$data = mysql_query("select *  from oldbk.shop id LEFT JOIN prokat itemid ON id=itemid where  `kol` > 0  ".$addlvl." AND `razdel` = '".(int)$_GET['otdel']."'  ORDER by `startpay` ASC;");
	while($row = mysql_fetch_array($data)) 
	{
		if ($i==0) { $i = 1; $color = '#C7C7C7';} else { $i = 0; $color = '#D5D5D5'; }
		echo "<TR bgcolor={$color}><TD align=center style='width:150px;vertical-align:middle;'><IMG SRC=\"http://i.oldbk.com/i/sh/{$row['img']}\" BORDER=0>";
		?>
		<BR><A HREF="prokat.php?otdel=<?=$_GET['otdel']?>&set=<?=$row['idp']?>&sid=">���������� �� �����</A>
		<IMG SRC="i/up.gif" WIDTH=11 HEIGHT=11 BORDER=0 ALT="���������� �� ��������� ����" style="cursor: pointer" onclick="AddDay('set','<?=$row['idp']?>', '<?=$row['name']?>','<?=$row['daypay']?>')">
		<BR>
		<?
				$showarr=array();
			    foreach($bonus_veks as $id => $val) 
			    {
			    	
			    	if ($showarr[$val['prototype']]==0)
			    		{
					    echo "<br><a href='prokat.php?otdel={$_GET['otdel']}&set={$row['idp']}&pveks={$id}'><img src=http://i.oldbk.com/i/sh/{$val['img']} title='�������� �������� {$val['name']}'></a><br><small><b>�������� ��������</b></small><br>";
					    $showarr[$val['prototype']]=1;
					}
			    }
		?>
		</TD>
		<?php
		echo "<TD valign=top>";
		
		$row['name'].=' (������)';
		
		
		//������� ���� �������� ������� = �� ���
			$new_cost=0;
			for ($yy=1;$yy<=5;$yy++)
			{
			$new_cost_a=upgrade_item($row['cost'],$yy);
			$new_cost+=$new_cost_a['cost_add'];
			}
		//� �� ��+���		+ 10 ��
		$row['cost']+=round($row['cost']/2)+$new_cost+10;
		
		$row[GetShopCount()]=$row['kol'];
		$row[needident]=0;
		if ((int)($row['mag'])>0)
		 {
			$row['includemagic']=$row['mag'];
			$row['includemagicname']=$row['magname'];
			$row['includemagicdex']=$row['magcount'];
			$row['includemagicmax']=$row['magcount'];
			$row['includemagicuses']=200;			
			
		 }
 		if ($row['fups'] >0)
 		{
		 $row['ups']=$row['fups'];
		 }
		if ($row['fstat'] >0)
		{
		$row['stbonus']=$row['fstat'];
		}
		if ($row['fmf'] >0)
		{
		$row['mfbonus']=$row['fmf'];
		}
		
		$row['unik']=2;
		
		$row['ghp']+=$row['addhp'];

		$row['bron1']=$row['bron1']!=0 ?$row['bron1']+$row['addbron']:0;
		$row['bron2']=$row['bron2']!=0 ?$row['bron2']+$row['addbron']:0;		
		$row['bron3']=$row['bron3']!=0 ?$row['bron3']+$row['addbron']:0;				
		$row['bron4']=$row['bron4']!=0 ?$row['bron4']+$row['addbron']:0;	
		
		$mffbroninfo=0;
		if (($row['bron1']>0) OR ($row['bron2']>0) OR ($row['bron3']>0) OR ($row['bron4']>0))
		{
		$mffbroninfo=$row['addbron'];
		}

		$row['mfinfo']='a:3:{s:5:"stats";i:'.$row['fstat'].';s:2:"hp";i:'.$row['addhp'].';s:4:"bron";i:'.$mffbroninfo.';}';

		if ($row['new_item']>0)			
		{
		//����� ��� ��������� ������
		$row['charka']='5|a:1:{i:5;a:5:{i:0;a:1:{s:3:"ghp";i:35;}i:1;a:1:{s:5:"fstat";i:5;}i:2;a:1:{s:3:"fmf";i:60;}i:3;a:1:{s:2:"gw";i:2;}i:4;a:1:{s:2:"gm";i:2;}}}';
		$row['ghp']+=35;
		$row['stbonus']+=5;
		$row['mfbonus']+=60;
		$row['gnoj']+=2;
		$row['gtopor']+=2;
		$row['gdubina']+=2;
		$row['gmech']+=2;
		$row['gfire']+=2;
		$row['gwater']+=2;
		$row['gair']+=2;
		$row['gearth']+=2;
		}
		else
		{
		$row['charka']='4|a:1:{i:4;a:5:{i:0;a:1:{s:3:"ghp";i:25;}i:1;a:1:{s:5:"fstat";i:3;}i:2;a:1:{s:3:"fmf";i:30;}i:3;a:1:{s:2:"gw";i:1;}i:4;a:1:{s:2:"gm";i:1;}}}';
		$row['ghp']+=25;
		$row['stbonus']+=3;
		$row['mfbonus']+=30;
		$row['gnoj']+=1;
		$row['gtopor']+=1;
		$row['gdubina']+=1;
		$row['gmech']+=1;
		$row['gfire']+=1;
		$row['gwater']+=1;
		$row['gair']+=1;
		$row['gearth']+=1;
		}		
		

		
		

		echo "������ ���� ������:<b>{$row['startpay']} ���.</b><br>";
		echo "�����������:<b>{$row['daypay']} ���. �� �����</b><br>";
		showitem ($row);
		echo "</TD></TR>";
	}
}


?>
</TABLE>
</TD></TR>
</TABLE>

	</TD>
	<TD valign=top width=280>
			<div style="text-align:right;">
			<form method="post" name="cont">
			<input type=hidden name=prodlenie value='yes'>
	                 <a href="javascript:void(0);" class="button-big btn" title="�������� ������" onClick="document.cont.submit();">�������� ������</a><br>
			 <a class="button-big btn" href="javascript:void(0);" title="������� ����" onclick="location.href='prokat.php?bankexit=1';">������� ����</a>
			</form>
			</div>

<table id="filter" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr>
                            <td align="left">
                                 <strong>��� ���� ����� �����: <span class="money"><? echo $d[0].'/'.get_meshok();?></span></strong><br>
                                � ��� � �������: <span class="money"><strong><?=$bank['ekr']?></strong></span><strong> ���.</strong><br>
                                ��� � ������: <span class="money"><strong><?=$prokat_count[0]?>/3</strong></span><strong> �����</strong><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="hint-block size11 center">
                                <strong><span class="money">
                                <div style="text-align:left;">
					<form method=post>
					<small>
					<input type="radio" name=fall value=0 <? if ((int)($_POST['fall'])==0) { echo 'checked="checked"' ; } ?> onchange="submit();">���������� ��� ����<br>
					<input type="radio" name=fall value=1 <? if ($_POST['fall']>0) { echo 'checked="checked"' ; $viewlevel=true; } ?> onchange="submit();">���������� ���� ������ ����� ������
					</small>
					</form>
				</div>
                                </span></strong>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
		<?
echo '
<tr>
                            <td class="filter-title">������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
                                        <a HREF="?tmp='.mt_rand(1111,9999).'&otdel=1">������� � ����</a>
                                    </li>
                                    <li>
					<a href="?tmp='.mt_rand(1111,9999).'&otdel=11">������</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=12">������ � ������</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=13">����</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="filter-title">������ � �����</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=2">������</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=21">��������</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=22">������ �����</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=23">������� �����</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=24">�����</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=3&">����</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="filter-title">��������� ������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=4">������</a>
                                    </li>
                                    <li>
                                       <a href="?tmp='.mt_rand(1111,9999).'&otdel=41">��������</a>
                                    </li>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=42">������</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td class="filter-title">������</td>
                        </tr>
                        <tr>
                            <td class="filter-item">
                                <ul>
                                    <li>
                                        <a href="?tmp='.mt_rand(1111,9999).'&otdel=6">��������</a>
                                    </li>
                                </ul>
                            </td>
                        </tr>';
	?>
                        <tr>
                            <td style="text-align: right;">
                                <img src="http://i.oldbk.com/i/images/arenda/arenda_illustration.jpg">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    
	<div id="hint3" class="ahint" style="position: absolute;width: 340px;FONT-SIZE: 13px;color:#000000;"></div>
    </TD>
    </FORM>
</TR>
</TABLE>


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
<!--// Rating@Mail.ru counter-->
	
	</div>
</div>
</body>
</html>
