<?
session_start();
include "/www/oldbk.com/connect.php";
include "art_templ.php";

$artid=(int)($_GET[artid]);

$nclass_name[0]='�����';     //����������� = ������ ��������
$nclass_name[1]='���������';
$nclass_name[2]='��������';
$nclass_name[3]='����';
$nclass_name[4]='�����';     //����� ������ ����� = ����� ��������



function ShowAit($row,$needmf)
{
global $art_tmpl, $nclass_name;

if (($_GET[act]=='mkpersonalart') OR ($_GET[act]=='mkclanart')  )
 {
 $action=$_GET[act];
 }
 else
 {
 $action='';
 }

if ($row[isart]==1)
{
$artun=1;
}

		
			//��������� ���� ��
		
			if ($needmf==1)									
			{
			
			if ($row[type]==3)
				{
				//������
				$up_stats = 0;
				$up_hp = 0;
				$up_bron = 0; 
				$row[mfbonus]=0;								
				$row[minu]+=5;
				$row[maxu]+=5;			
				$row[name].=' +5';
				}
				else
				{
				//��������
				$up_stats = 3;
				$up_hp = 20;
				$up_bron = 3; 
				$row[mfbonus]=25;				
				$row[ups]=5;
				}
			//��������� ���� ��
			$row['unik']=1;
			if (is_array($_SESSION['mkartch']))
				{
				$row['unik']=$_SESSION['mkartch']['unik'];		
				// if ($row['unik']==2) $up_stats++;		
				 
				 if ($row['unik']==0) { $row['unik']=1; } // ���� �� ���� ������� �� ���������� ������ (��� ����� ��������)
				 
//				print_r($_SESSION['mkartch']);
				} 
			
			
			if (($row['gsila'] == 0) and ($row['glovk'] == 0) and ($row['ginta'] == 0) and ($row['gintel'] == 0) )
			{
				$up_stats = 0;
			}
			
			
			
			if (($row['mfkrit']==0) and ($row['mfakrit']==0) and ($row['mfuvorot']==0) and ($row['mfauvorot']==0) )
			{
			$row[mfbonus]=0;
			}
			
			$row[stbonus]=$up_stats;			
			$row['cost']=900;
			$row['bron1'] = (($row['bron1'] > 0) ? ($row['bron1'] + $up_bron) : "0");
			$row['bron2'] = (($row['bron2'] > 0) ? ($row['bron2'] + $up_bron) : "0");
			$row['bron3'] = (($row['bron3'] > 0) ? ($row['bron3'] + $up_bron) : "0");
			$row['bron4'] = (($row['bron4'] > 0) ? ($row['bron4'] + $up_bron) : "0");
			$row['ghp'] = (($row['ghp'] > 0) ? ($row['ghp'] + $up_hp):"0");
			
			$row[ups]=5;
			
			}
			else
			{
			$row['maxdur']=500;
			}
			


			
///��������� ������

echo "<table align=center border=0 cellpadding=0 cellspacing=0  >
	<TR align=left>
		<td bgcolor=\"#f9f7ee\" align=center width=150 valign=top class=\"tbl_inside\"><br>";



			
		echo "<div id=\"old_img\">";
		if ($row[new_art_img])
		{
			if (!(strpos($row[new_art_img], 'art_temp') !== false) )
			{
			echo "<img src=upload/$row[new_art_img]>";
			}
		}
		else
		{
			if ((is_array($_SESSION['mkartch'])) AND ($_SESSION['mkartch_new_slot']!=true) )
			{
			//����� ������ ����
		  	echo "<img src=https://i.oldbk.com/i/sh/{$_SESSION['mkartch'][img]}>";
		  	$img_print=true;
			}
			else
			if ($artun==1) 
			{
			//echo "<img src=https://i.oldbk.com/i/sh/wish_t{$row[type]}.gif><br><br>";			
			}
			else
			{
			echo "<img src=https://i.oldbk.com/i/sh/$row[img]><br><br>";
			}
		}
		echo "</div>";
		
		
		if ($artun==1)
		  	{
	echo "
	<script type=\"text/javascript\">
	function ajaxFileUpload()
	{
		$(\"#loading\")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});

		$.ajaxFileUpload
		(
			{
				url:'doajaxfileupload.php',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				data:{name:'logan', id:'id'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							document.getElementById('old_img').innerHTML='';
							document.getElementById('new_img_load').innerHTML=data.msg;
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;

	}
	
	function Calcst(p)
	{
	var clst=0;
	if (p==true) 
	 {
	 clst=document.getElementById('sum_ch_stat').value;
	 clst++;
	 }
	 else
	 {
	 clst=document.getElementById('sum_ch_stat').value;
	 clst--;	 
	 }
 	document.getElementById('sum_ch_stat').value=clst;	
 	
	 if (clst<2)
	 {
	 document.getElementById('amc_sila').disabled=false;
	 document.getElementById('amc_lovk').disabled=false;
	 document.getElementById('amc_inta').disabled=false;
	 document.getElementById('amc_intel').disabled=false;
	 document.getElementById('amc_gmp').disabled=false;
	 }
	 else 
	 {
	  if (!(document.getElementById('amc_sila').checked)) {  document.getElementById('amc_sila').disabled='disabled'; }
	  if (!(document.getElementById('amc_lovk').checked)) { document.getElementById('amc_lovk').disabled='disabled'; }
	  if (!(document.getElementById('amc_inta').checked)) { document.getElementById('amc_inta').disabled='disabled'; }
	  if (!(document.getElementById('amc_intel').checked)) { document.getElementById('amc_intel').disabled='disabled'; }
	  if (!(document.getElementById('amc_gmp').checked)) { document.getElementById('amc_gmp').disabled='disabled'; }
	 }
	SetVarVal();
	}
	
	function Calcmf(p)
	{
	var clst=0;
	if (p==true) 
	 {
	 clst=document.getElementById('sum_ch_mf').value;
	 clst++;
	 }
	 else
	 {
	 clst=document.getElementById('sum_ch_mf').value;
	 clst--;	 
	 }
 	document.getElementById('sum_ch_mf').value=clst;	
 	
	 if (clst<2)
	 {
	 document.getElementById('amc_mkrit').disabled=false;
	 document.getElementById('amc_makrit').disabled=false;
	 document.getElementById('amc_muvorot').disabled=false;
	 document.getElementById('amc_mauvorot').disabled=false;
	 }
	 else 
	 {
	  if (!(document.getElementById('amc_mkrit').checked)) {  document.getElementById('amc_mkrit').disabled='disabled'; }
	  if (!(document.getElementById('amc_makrit').checked)) { document.getElementById('amc_makrit').disabled='disabled'; }
	  if (!(document.getElementById('amc_muvorot').checked)) { document.getElementById('amc_muvorot').disabled='disabled'; }
	  if (!(document.getElementById('amc_mauvorot').checked)) { document.getElementById('amc_mauvorot').disabled='disabled'; }
	 }
	SetVarVal();
	}	
	
	function SetVarVal()
	{
	nartn=document.getElementById('new_art_name').value;
	mark_sila=document.getElementById('amc_sila').checked;
	mark_lovk=document.getElementById('amc_lovk').checked;
	mark_inta=document.getElementById('amc_inta').checked;
	mark_intel=document.getElementById('amc_intel').checked;
	mark_gmp=document.getElementById('amc_gmp').checked;
	mark_krit=document.getElementById('amc_mkrit').checked;
	mark_akrit=document.getElementById('amc_makrit').checked;
	mark_uvorot=document.getElementById('amc_muvorot').checked;
	mark_auvorot=document.getElementById('amc_mauvorot').checked;
	$.get('https://oldbk.com/commerce/setvars.php', {new_art_name:nartn,mark_sila:mark_sila,mark_lovk:mark_lovk,mark_inta:mark_inta,mark_intel:mark_intel,mark_gmp:mark_gmp,mark_krit:mark_krit,mark_akrit:mark_akrit,mark_uvorot:mark_uvorot,mark_auvorot:mark_auvorot}, function(data){

	 if (data!='true')
	 	{
	 	
		window.document.location.href ='index.php?exit=3144&act=logout';
	 	}
	 });
	
	}
	

	</script>  	";
		  	
		  	if ((is_array($_SESSION['mkartch'])) AND ($_SESSION['mkartch_new_slot']!=true) )
		  	{
		  	//����� ������ �������� �� ������� ����
		  	 if ($img_print!=true) {
						  	echo "<img src=https://i.oldbk.com/i/sh/{$_SESSION['mkartch'][img]}>";
				  			}
		  	}
		  	else
		  	{
		  		echo "<img src=https://i.oldbk.com/i/arts/art_templ_{$row['razdel']}.gif>";
		  		$_SESSION['save_proto_memory']['new_art_img']="art_templ_{$row['razdel']}.gif";
		  		/*
			  	echo "
			  	<div id=\"new_img_load\"></div>
				<img id=\"loading\" src=\"loading.gif\" style=\"display:none;\">
				<form name=\"form\" method=\"POST\" enctype=\"multipart/form-data\">
				<input id=\"fileToUpload\" type=\"file\" size=\"5\" name=\"fileToUpload\"  accept='image/gif' onchange=\"return ajaxFileUpload();\" style='border: 1px solid #b0b0b0; background: #eaeaea;color:#323231; font-size: 11px;  height:18px;font-family:Tahoma;font-weight:bold;'  >";
				echo '<br><br><b style="color:#800000"><small><center>��������� �����������<br>��������� (*.gif)</center></small></b>';
				echo "</form>";
				*/
			}
	  		echo "<br>";
			
		  	}		
		
		
		echo "</td>
		<td>";
		echo "<form method='get' accept-charset=utf-8 >";		
		//alina
	echo "<table align=left border=0 cellpadding=10 cellspacing=0 class=\"tbl_inside\" >";	
	$co[1]='#f4f2e9';
	$co[2]='#f9f7ee';
	$c=2;
	echo '<tr bgcolor="'.$co[$c].'"><td>';
	
	//alina

		
		if ($row['nalign']==1) 
				{
				$print_align='1.5';
				}
				else
				{
				$print_align=$row['nalign'];
				}

 		$ehtml=str_replace('.gif','',$row['img']);
            $razdel=array(1=>"kasteti", 11=>"axe", 12=>"dubini", 13=>"swords", 14=>"bow", 2=>"boots", 21=>"naruchi", 22=>"robi", 23=>"armors",
            24=>"helmet", 3=>"shields",4=>"clips", 41=>"amulets", 42=>"rings", 5=>"mag1", 51=>"mag2", 6=>"amun");

            $row['otdel']==''?$xx=$row['razdel']:$xx=$row['otdel'];

            if($razdel[$xx]=='')
            {
            	$razdel[$xx]='predmeti';
            }
            else
            {
            	$razdel[$xx]=$razdel[$xx]."/".$ehtml;
            }
            	if ($artun==1)
            	{
//print_r($row)  ;
		//            	echo "<input type=text size=35 name='new_art_name' id='new_art_name' value='".(($row[new_art_name])?$row[new_art_name]:"������� �������� ���������")."' onchange=\"SetVarVal();\"  >";
            	echo "<input type=hidden size=35 name='new_art_name' readonly=true id='new_art_name' value='".$art_tmpl[$row['razdel']]."' ><B>".$art_tmpl[$row['razdel']]."</B>";
		$_SESSION['save_proto_memory'][new_art_name]=$art_tmpl[$row['razdel']];
            	}
            	else 
            	{
		echo "<a href=https://oldbk.com/encicl/".$razdel[$xx].".html target=_blank><b>{$row['name']}</b></a>";
		}
		
		echo "<img src=https://i.oldbk.com/i/align_{$print_align}.gif> (�����: {$row['massa']})".(($row['present'])?' <IMG SRC="https://i.oldbk.com/i/podarok.gif" WIDTH="16" HEIGHT="18" BORDER=0 TITLE="���� ������� ��� ������� '.$row['present'].'. �� �� ������� �������� ���� ������� ����-���� ���." ALT="���� ������� ��� ������� '.$row['present'].'. �� �� ������� �������� ���� ������� ����-���� ���.">':"")."<BR>";

echo "<BR>������������� : {$row['duration']}/{$row['maxdur']}<BR>
		";
		echo (($row['ups']>0)?"���������:<b>{$row['ups']} ���</b><BR>":"");
		
		if (($artun==1) and ($row['unik']==2))
			{
			$fixuu=1;
			}
			else
			{
			$fixuu=0;
			}
		
		echo (($row['stbonus']>0)?"��������� ����������: ".($artun==1?"<font color=red>":"")."<b>".($row['stbonus']+$fixuu)."</b>".($artun==1?" </font><b class=text2><font color=red>(� ��������� ������������� ����� ������������ ���������)</font></b>":"")."<BR>":"");
		echo (($row['mfbonus']>0)?"��������� ���������� ��: ".($artun==1?"<font color=red>":"")."<b>{$row['mfbonus']}</b>".($artun==1?" </font><b class=text2><font color=red>(� ��������� ������������� ����� ������������ ���������)</font></b>":"")."</b><BR>":"");

		echo (($magic['chanse'])?"����������� ������������: ".$magic['chanse']."%<BR>":"")."
		".(($magic['time'])?"����������������� �������� �����: ".$magic['time']." ���.<BR>":"")."
		".(($row['goden'])?"���� ��������: {$row['goden']} ��. ".(((!$row[GetShopCount()])or($_SERVER['PHP_SELF']=='/comission.php')or($_SERVER['PHP_SELF']=='/main.php'))?"(�� ".date("d.m.Y H:i",$row['dategoden']).")":"")."<BR>":"")."
		".(($row['nsex']==1)?"� ���: <b>�������</b><br>":"")."
		".(($row['nsex']==2)?"� ���: <b>�������</b><br>":"");
	
		echo (($row['nsila'] OR $row['nlovk'] OR $row['ninta'] OR $row['nvinos'] OR $row['nlevel'] OR $row['nintel'] OR $row['nmudra'] OR $row['nnoj'] OR $row['ntopor'] OR $row['ndubina'] OR $row['nmech'] OR $row['nfire'] OR $row['nwater'] OR $row['nair'] OR $row['nearth'] OR $row['nearth'] OR $row['nlight'] OR $row['ngray'] OR $row['ndark'] OR ($row['nclass'] >0)  )?"<br>��������� �����������:<BR>":"");
		
			if ($row['nclass'] >0) 
			{
				if ($nclass_name[$row['nclass']]!='')
				{	
				echo "� ����� ���������: <b>{$nclass_name[$row['nclass']]}</b><br>";
				}
			}
	
		echo (($row['nsila']>0)?"� ����: {$row['nsila']}</font><BR>":"")."
		".(($row['nlovk']>0)?"� ��������: {$row['nlovk']}</font><BR>":"")."
		".(($row['ninta']>0)?"� ��������: {$row['ninta']}</font><BR>":"")."
		".(($row['nvinos']>0)?"� ������������: {$row['nvinos']}</font><BR>":"")."
		".(($row['nlevel']>0)?"� �������: {$row['nlevel']}</font><BR>":"")."
		".(($row['nintel']>0)?"� ���������: {$row['nintel']}</font><BR>":"")."
		".(($row['nmudra']>0)?"� ��������: {$row['nmudra']}</font><BR>":"")."
		".(($row['nnoj']>0)?"� ���������� �������� ������ � ���������: {$row['nnoj']}</font><BR>":"")."
		".(($row['ntopor']>0)?"� ���������� �������� �������� � ��������: {$row['ntopor']}</font><BR>":"")."
		".(($row['ndubina']>0)?"� ���������� �������� �������� � ��������: {$row['ndubina']}</font><BR>":"")."
		".(($row['nmech']>0)?"� ���������� �������� ������: {$row['nmech']}</font><BR>":"")."
		".(($row['nfire']>0)?"� ���������� �������� ������� ����: {$row['nfire']}</font><BR>":"")."
		".(($row['nwater']>0)?"� ���������� �������� ������� ����: {$row['nwater']}</font><BR>":"")."
		".(($row['nair']>0)?"� ���������� �������� ������� �������: {$row['nair']}</font><BR>":"")."
		".(($row['nearth']>0)?"� ���������� �������� ������� �����: {$row['nearth']}</font><BR>":"")."
		".(($row['nlight']>0)?"� ���������� �������� ������ �����: {$row['nlight']}</font><BR>":"")."
		".(($row['ngray']>0)?"� ���������� �������� ����� ������: {$row['ngray']}</font><BR>":"")."
		".(($row['ndark']>0)?"� ���������� �������� ������ ����: {$row['ndark']}</font><BR>":"")."
		".(($row['gmeshok'] OR $row['gsila'] OR $row['mfkrit'] OR $row['mfakrit']  OR $row['mfuvorot'] OR $row['mfauvorot']  OR $row['glovk'] OR $row['ghp'] OR $row['ginta'] OR $row['gintel'] OR $row['gnoj'] OR $row['gtopor'] OR $row['gdubina'] OR $row['gmech'] OR $row['gfire'] OR $row['gwater'] OR $row['gair'] OR $row['gearth'] OR $row['gearth'] OR $row['glight'] OR $row['ggray'] OR $row['gdark'] OR $row['minu'] OR $row['maxu'] OR $row['bron1'] OR $row['bron2'] OR $row['bron3'] OR $row['bron4'])?"<br>��������� ��:<br>":"")."
		".(($row['minu'])?"� ����������� ��������� �����������: ".($row[type]==3?"":"+")."{$row['minu']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$row[artminu]})</font></b>":"")."<BR>":"")."
		".(($row['maxu'])?"� ������������ ��������� �����������: ".($row[type]==3?"":"+")."{$row['maxu']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$row[artmaxu]})</font></b>":"")."<BR>":"");

		if ($artun==1) { 
			echo "</td></tr>
				<tr><td>
				<div class=text3><b style=\"color:#800000\">�������� ��� �����, � ������� ����� �������� ������������ ��������� ���������� � ���������.<b></div><br>
				<div class=text2><b style=\"color:#800000\"><u>��������!</u></b>
				<br><b style=\"color:#7c6547\">����� ������� ���������, �� ������� ������������ ��������� ����� ������ � ��������� ���� ������ ���������<br>
				� �� � ����� ������. ����� ������� ��������� ���� ����� ����� ���������� ��������!</b></div>
				</td></tr>
				<tr bgcolor='#f9f7ee'><td>"; 
			}

		echo ((($row['gsila']) or ($artun==1) )?"<BR>� ����: ".(($row['gsila']>0 )?"+":"")."{$row['gsila']}":"");
		echo (( ($row['stbonus']>0) and ( $row['gsila']!=0) and ($artun==0) )?"<a href='?act={$action}&edit=1&sila=1&setup={$row['id']}'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		echo ((($row['gsila']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_sila id=amc_sila value=1 onclick='Calcst(this.checked);' />  <small>����� �������� ����������</small>":"")."":"");
		
	
		
		
		echo ((($row['glovk']) or ($artun==1))?"<BR>� ��������: ".(($row['glovk']>0)?"+":"")."{$row['glovk']}":"");
		echo (( ($row['stbonus']>0) and ( $row['glovk']!=0 ) and ($artun==0))?"<a href='?act={$action}&edit=1&lovk=1&setup={$row['id']}'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
	
		// �������� ��������� ����������� ��������	
		//	���� ��������� ����������� �������� � ��������		
		if (($row['nclass']!=2) AND  ($row['nclass']!=3))
		{
		echo ((($row['glovk']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_lovk id=amc_lovk value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"");
		}
		else
		{
		echo (($artun==1)?"<input type=hidden name=amc_lovk id=amc_lovk value=0/>":"");			
		}
		
		
		echo ((($row['ginta']) or ($artun==1))?"<BR>� ��������: ".(($row['ginta']>0)?"+":"")."{$row['ginta']}":"");
		echo (( ($row['stbonus']>0) and ($row['ginta']!=0) and ($artun==0))?"<a href='?act={$action}&edit=1&inta=1&setup={$row['id']}'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		
		//������ ��������� ����������� ��������
		//	���� ��������� ����������� �������� � ��������
		if (($row['nclass']!=1) AND  ($row['nclass']!=3))
		{
		echo ((($row['ginta']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_inta id=amc_inta value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"");
		}
		else
		{
		echo (($artun==1)?"<input type=hidden name=amc_inta id=amc_inta value=0/>":"");			
		}
		
		
		echo ((($row['gintel']) or ($artun==1))?"<BR>� ���������: ".(($row['gintel']>0)?"+":"")."{$row['gintel']}":"");
		echo (( ($row['stbonus']>0) and ($row['gintel']!=0) and ($artun==0))?"<a href='?act={$action}&edit=1&intel=1&setup={$row['id']}'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		echo ((($row['gintel']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_intel id=amc_intel value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"");
		
		
		echo ((($row['gmp']) or ($artun==1))?"<BR>� ��������: ".(($row['gmp']>0)?"+":"")."{$row['gmp']}":"");
		echo (( ($row['stbonus']>0) and ($row['gmp']!=0) and ($artun==0))?"<a href='?act={$action}&edit=1&gmp=1&setup={$row['id']}'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		echo ((($row['gmp']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_gmp id=amc_gmp value=1 onclick='Calcst(this.checked);'/>  <small>����� �������� ����������</small>":"")."":"");
		
		

	
	 if ($artun==1)	
	 {
	 $ch_st_count=0;
	  //���������� �������� ��� ������ ���� ��� ���� � ������
	   if ($row[mark_sila]==true)
	   	{
	   	$js_fix=" document.getElementById('amc_sila').checked=true; \n";
	   	$ch_st_count++;
	   	}
	   if ($row[mark_lovk]==true)
	   	{
	   	$js_fix.=" document.getElementById('amc_lovk').checked=true; \n";
	   	$ch_st_count++;
	   	}	   	
	   if ($row[mark_inta]==true)
	   	{
	   	$js_fix.=" document.getElementById('amc_inta').checked=true; \n";
	   	$ch_st_count++;	   	
	   	}
	   if ($row[mark_intel]==true)
	   	{
	   	$js_fix.=" document.getElementById('amc_intel').checked=true; \n";
	   	$ch_st_count++;	   	
	   	}
	   if ($row[mark_gmp]==true)
	   	{
	   	$js_fix.=" document.getElementById('amc_gmp').checked=true; \n";
	   	$ch_st_count++;
	   	}	   		   		  

	if ($js_fix!='')
	 	{
		$ch_st_count--;
	   	if ($ch_st_count>1) {$ch_st_count=1;}	 	
	 	echo "
		<script type=\"text/javascript\">
		".$js_fix."
		Calcst(true);
		</script>";
		}
		
	 }
	
	echo "<input type=hidden id=sum_ch_stat value={$ch_st_count}>";
	
	if ($artun==1) { 
			echo "</td></tr>
				<tr><td>
				<div class=text3><b style=\"color:#800000\">�������� �������� ���������� ���������� �� � �����. ����� ��������� �� �� ���� ����� ��� ��������.<b></div><br>
				<div class=text2><b style=\"color:#800000\"><u>��������!</u></b>
				<br><b style=\"color:#7c6547\">��������� �� � ����� ���������� �� ������� 5 �� = 1 �����.<br>����� ������� ��������� �������� ���� ����� ����� ����������!</b></div>
				</td></tr>
				<tr bgcolor='#f9f7ee'><td>"; 
			}
	echo ((($row['ghp'])OR($artun==1))?"<BR>� ������� �����: +{$row['ghp']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$row[artghp]})</font></b> ".(($row[artbron1]>0)?"<a style=\"padding:0;\" href='?act={$action}&edit=1&arthp=1&setup={$row['id']}'><img src='https://i.oldbk.com/i/up.gif'   alt='���������' title='���������'></a>":"")."  ".(($row[artghp] > 0)?"<a  style=\"padding:0;\" href='?act={$action}&edit=1&arthpd=1&setup={$row['id']}'><img src='https://i.oldbk.com/i/down.gif' alt='���������' title='���������'></a>":"")." (5 HP = 1 �����)  ":"")."":"");	

	if ($artun==1) { 
				echo "</td></tr>
					<tr><td>
					<div class=text3><b style=\"color:#800000\">�������� ��� ������������, � ������� ����� �������� ������������ ��������� ���������� � ���������.<b></div><br>
				<div class=text2><b style=\"color:#800000\"><u>��������!</u></b>
				<br><b style=\"color:#7c6547\">����� ������� ���������, �� ������� ������������ ��������� ����� ������ � ��������� ���� ������ ���������<br>
				� �� � ����� ������. ����� ������� ��������� ���� ����� ����� ���������� ��������!</b></div>
				</td></tr>
				<tr bgcolor='#f9f7ee'><td>"; 
				}
	

		echo ((($row['mfkrit']) or ($artun==1))?"<BR>� ��. ����������� ������: ".(($row['mfkrit']>0)?"+":"")."{$row['mfkrit']}%":"");
		
		if (($row['nclass']!=1) AND  ($row['nclass']!=3))
		{
		echo (( ($row['mfbonus']>0) and ( $row['mfkrit']!=0 ) and ($artun==0))?"<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ����\",\"1\")) { window.location=\"?act={$action}&edit=1&mfsetup={$row['id']}&krit=\"+obj+\"\"; }' href='#'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		echo ((($row['mfkrit']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_mkrit id=amc_mkrit value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"");
		}
		else
			{
			echo (($artun==1)?"<input type=hidden name=amc_mkrit id=amc_mkrit value=0/>":"");			
			}
		

		echo ((($row['mfakrit']) or ($artun==1))?"<BR>� ��. ������ ����. ������: ".(($row['mfakrit']>0)?"+":"")."{$row['mfakrit']}%":"");
		echo (( ($row['mfbonus']>0) and ( $row['mfakrit']!=0 ) and ($artun==0))?"<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ��������\",\"1\")) { window.location=\"?act={$action}&edit=1&mfsetup={$row['id']}&akrit=\"+obj+\"\"; }' href='#'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		echo ((($row['mfakrit']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_makrit id=amc_makrit value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"");

		echo ((($row['mfuvorot']) or ($artun==1))?"<BR>� ��. ������������: ".(($row['mfuvorot']>0)?"+":"")."{$row['mfuvorot']}%":"");		
		if (($row['nclass']!=2) AND  ($row['nclass']!=3))
		{
		echo (( ($row['mfbonus']>0) and ( $row['mfuvorot']!=0 ) and ($artun==0) )?"<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ������\",\"1\")) { window.location=\"?act={$action}&edit=1&mfsetup={$row['id']}&uvorot=\"+obj+\"\"; }' href='#'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		echo ((($row['mfuvorot']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_muvorot id=amc_muvorot value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"");
		}
		else
		{
			echo (($artun==1)?"<input type=hidden name=amc_mkrit id=amc_muvorot value=0/>":"");			
		}
		

		
		echo ((($row['mfauvorot']) or ($artun==1))?"<BR>� ��. ������ ��������.: ".(($row['mfauvorot']>0)?"+":"")."{$row['mfauvorot']}%":"");
		echo (( ($row['mfbonus']>0) and ( $row['mfauvorot']!=0 ) and ($artun==0) )?"<a onclick='var obj; if (obj = prompt(\"������� ���������� �� ������������ � ����������\",\"1\")) { window.location=\"?act={$action}&edit=1&mfsetup={$row['id']}&auvorot=\"+obj+\"\"; }' href='#'><img src='https://i.oldbk.com/i/up.gif' alt='���������' title='���������'></a>":"");
		echo ((($row['mfauvorot']) or ($artun==1))?"".(($artun==1)?"&nbsp;<input type=checkbox name=amc_mauvorot id=amc_mauvorot value=1 onclick='Calcmf(this.checked);' />  <small>����� �������� ����������</small>":"")."":"");


	 if ($artun==1)	
	 {
	 $js_fix='';
	 $ch_mf_count=0;
	  //���������� �������� ��� ������ ���� ��� ���� � ������
	   if ($row[mark_krit]==true)
	   	{
	   	$js_fix=" document.getElementById('amc_mkrit').checked=true; \n";
		$ch_mf_count++;
	   	}
	   if ($row[mark_akrit]==true)
	   	{
	   	$js_fix.=" document.getElementById('amc_makrit').checked=true; \n";
		$ch_mf_count++;
	   	}	   	
	   if ($row[mark_uvorot]==true)
	   	{
	   	$js_fix.=" document.getElementById('amc_muvorot').checked=true; \n";
		$ch_mf_count++;
	   	}
	   if ($row[mark_auvorot]==true)
	   	{
	   	$js_fix.=" document.getElementById('amc_mauvorot').checked=true; \n";
		$ch_mf_count++;   	
	   	}
	if ($js_fix!='')
	 	{
		$ch_mf_count--;
		if ($ch_mf_count>1) { $ch_mf_count=1;}	 	
	 	echo "
		<script type=\"text/javascript\">
		".$js_fix."
		Calcmf(true);
		</script>";
		}
		
	 }
	
	
	echo "<input type=hidden id=sum_ch_mf value={$ch_mf_count}>";	
	echo "<BR>";
echo (($row['gnoj'])?"� ���������� �������� ������ � ���������: +{$row['gnoj']}<BR>":"")."
		".(($row['gtopor'])?"� ���������� �������� �������� � ��������: +{$row['gtopor']}<BR>":"")."
		".(($row['gdubina'])?"� ���������� �������� �������� � ��������: +{$row['gdubina']}<BR>":"")."
		".(($row['gmech'])?"� ���������� �������� ������: +{$row['gmech']}<BR>":"")."
		".(($row['gfire'])?"� ���������� �������� ������� ����: +{$row['gfire']}<BR>":"")."
		".(($row['gwater'])?"� ���������� �������� ������� ����: +{$row['gwater']}<BR>":"")."
		".(($row['gair'])?"� ���������� �������� ������� �������: +{$row['gair']}<BR>":"")."
		".(($row['gearth'])?"� ���������� �������� ������� �����: +{$row['gearth']}<BR>":"")."
		".(($row['glight'])?"� ���������� �������� ������ �����: +{$row['glight']}<BR>":"")."
		".(($row['ggray'])?"� ���������� �������� ����� ������: +{$row['ggray']}<BR>":"")."
		".(($row['gdark'])?"� ���������� �������� ������ ����: +{$row['gdark']}<BR>":"")."
		".(($row['bron1'])?"� ����� ������: {$row['bron1']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$row[artbron1]})</font></b>":"")." <BR>":"")."
		".(($row['bron2'])?"� ����� �������: {$row['bron2']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$row[artbron2]})</font></b>":"")."<BR>":"")."
		".(($row['bron3'])?"� ����� �����: {$row['bron3']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$row[artbron3]})</font></b>":"")."<BR>":"")."
		".(($row['bron4'])?"� ����� ���: {$row['bron4']} ".($artun==1?"<b class=text3><font color=red> &nbsp;&nbsp;��������� ������� (+{$row[artbron4]})</font></b>":"")."<BR>":"")."
		".(($row['gmeshok'])?"� ����������� ������: +{$row['gmeshok']}<BR>":"")."
		".(($row['present'])?"<br>������� ��: <b>".$row['present']."</b><br>":"")."
		".(($row['letter'])?"���������� ��������: ".strlen($row['letter'])."<br>":"")."
		".(($row['letter'])?"�� ������ ������� �����:<div style='background-color:FAF0E6;'> ".$row['letter']."</div>":"")."
		".(($row['prokat_idp']>0)?"��������:".floor(($row['prokat_do']-time())/60/60)." �. ".round((($row['prokat_do']-time())/60)-(floor(($row['prokat_do']-time())/3600)*60))." ���.<br>":"")."
		".(($magic['name'] && $row['type'] != 50)?"<font color=maroon>�������� ��������:</font> ".$magic['name']."<BR>":"")."
		".(($magic['name'] && $row['type'] == 50)?"<font color=maroon>��������:</font> ".$magic['name']."<BR>":"")."
		".(($row['text'])?"�� ����� ������������� �������:<center>".$row['text']."</center><BR>":"")."
		".(($row['present_text'])?"�� ������� ������� �����:<br />".$row['present_text']."<BR>":"")."
		".(($incmagic['max'])?"	�������� �������� <img src=\"https://i.oldbk.com/i/magic/".$incmagic['img']."\" title=\"".$incmagic['name']."\"> ".$incmagic['cur']." ��.	<BR> "."��������� �������: ".$incmagic['nlevel']." <BR> ":"")."
		".(($incmagic['max'])? "�-�� �����������: ".$incmagic['uses']."<br/>" : "")."
		".(($row['labonly']==1)?"<small><font color=maroon>������� �������� ����� ������ �� ���������</font></small><BR>":"")."
		".((!$row['isrep'])?"<small><font color=maroon>������� �� �������� �������</font></small><BR>":"");

if ($row[type]==27)
			{
			echo "<br>�����������:<br>� ����� ��������� �� �����<br>";
			}
			elseif ($row[type]==28)
			{
			echo "<br>�����������:<br>� ����� ��������� ��� �����<br>";
			}

		if  ( ($row[ab_mf]>0) or ($row[ab_bron]>0) or ($row[ab_uron]>0))
		   {
		    echo "<br>��������:<br>";
		     if ($row[ab_mf]>0) echo "� ������������� ��.:+{$row[ab_mf]}%<br>";
		     if ($row[ab_bron]>0) echo "� �����:+{$row[ab_bron]}%<br>";
		     if ($row[ab_uron]>0) echo "� �����:+{$row[ab_uron]}%<br>";
		   }
		
		if ($artun==1)
			{
			echo "</td></tr>
				<tr><td>
				<div class=text3><b style=\"color:#800000\">�������� ���� �� ���� �������, ������� ����� ������ ��� ��������.<b></div><br>
				<div class=text2><b style=\"color:#800000\"><u>��������!</u></b>
				<br><b style=\"color:#7c6547\">����� ������� ��������� �������� ���� ����� ����� ����������!</b></div>
				
			</td></tr>
			<tr bgcolor='#f9f7ee'><td>";
			echo "<label><input type=\"radio\" name=\"art_bonus\" value=\"1\" ".(($_GET[art_bonus]==1)?" checked='checked' ":"")." />+ 10% �����</label> <br />";
			echo "<label><input type=\"radio\" name=\"art_bonus\" value=\"2\" ".(($_GET[art_bonus]==2)?" checked='checked' ":"")." />+5% � ���� ��</label><br />";
			echo "<label><input type=\"radio\" name=\"art_bonus\" value=\"3\" ".(($_GET[art_bonus]==3)?" checked='checked' ":"")." />+3% � ���� �� � 1% � �����</label><br />";
			}
//echo "!!!";
//print_r($row);
		if($row[unik]==2 && $artun!=1)
		{
			echo "<br><font color=#990099><small><b>���� � ���������� ���������� ������������.</b></small></font><br>&nbsp;";
		}
		else		
		if($row[unik]==1 && $artun!=1)
		{
			echo "<br><font color=red><small><b>���� � ���������� ������������.</b></small></font><br>&nbsp;";
		}
		
		if ($artun==0)
		{
		if ($c==1) {$c=2;} else {$c=1;}
		echo '</td></tr><tr bgcolor="'.$co[$c].'"><td><b style="color:#800000">������������ ��������� ����� � ������������ ��� �������� ��������� ���������.</b><br>';
		if ($c==1) {$c=2;} else {$c=1;}
		echo '</td></tr><tr bgcolor="'.$co[$c].'"><td class="text2"><b style="color:#800000"><u>��������!</u></b><br><b style="color:#7c6547">����� ���������� ��������� ��� ������ �������� �������������� ������� ��������� � ������������,
		<br>������� ����� � ��������� ������������� � �������� � ������ � ��������� ����������, �� ������ �� ������ ���������. <br>
		��������� ���� �������� ��������� ����������, � ����� ������ � ������� ���������, �������������� ������ ���������,
		<br>����� ���������� �������� ��� ��������.</b></font>
		';		
		echo "<br><br><br><br><center><input type=submit class=button2 name=saveproto value='��������� ��������'  ";			
		if (($row[mfbonus]==0) and ($row[stbonus]==0))
			{
		echo "></center><br>";
			}
		else	{
		echo ' disabled="disabled" ></center><br>';
			}		
		}
		else
		if ($artun==1)
		{
		
		echo "<br><br><br><br><center><input type=submit class=button2 name=saveart value='��������� ��������'   ";	
		echo "></center><br>";		
		}
		
		
		


		echo "<input type=hidden name=act value='{$action}'>";
		echo ' </form> ';		
//		echo "	</td></TR>";

	echo "</td></tr></table></td></tr></table><br><br><br><br>";




$_SESSION['save_proto_memory']=$row;

}


if ($_SESSION['uid'])
{
	
	if ($artid>0)	
	{
	
		if ((is_array($_SESSION['mkartch'])) AND ($_SESSION['mkartch_new_slot']==true) )
		{

			$get_user_alig=mysql_fetch_array(mysql_query("select  id,login,align, klan, level  from oldbk.users where id='{$_SESSION['uid']}' "));
		        
		        if ($get_user_alig['klan']=='pal')
		        {
		        $add_align="nalign=6 or nalign=1 or ";
		        }
		        else if ($get_user_alig['align']>0)
		        {
		        $ali=(int)($get_user_alig['align']);
		        $add_align="nalign={$ali} or ";
		        }
		        else
		        {
		        $add_align="";
		        }
				//�������� ����� ��������� ��� ������
					if ($_SESSION['mkartch_new_slot_from_hram']==true)
					{
					$nlvlsql=""; // ����� �������
					}
					elseif ($get_user_alig['level']>=14)
					{
					$nlvlsql="and  nlevel>='14' ";
					}
					else
					{
					$nlvlsql="and  nlevel='{$get_user_alig['level']}' ";
					}
				
				$get_proto=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.shop where id='{$artid}' and (new_item>0 or (type = 3 and nlevel >= 7)) and artproto > 0 AND ({$add_align} nalign=0) {$nlvlsql}"));
				

		}
		elseif (is_array($_SESSION['mkartch']))
		{

			$get_user_alig=mysql_fetch_array(mysql_query("select  id,login,align, klan, level  from oldbk.users where id='{$_SESSION['uid']}' "));
		        
		        if ($get_user_alig['klan']=='pal')
		        {
		        $add_align="nalign=6 or nalign=1 or ";
		        }
		        else if ($get_user_alig['align']>0)
		        {
		        $ali=(int)($get_user_alig['align']);
		        $add_align="nalign={$ali} or ";
		        }
		        else
		        {
		        $add_align="";
		        }

				//�������� ����� ��������� ��� ������
				if (is_array($_SESSION['ekrids']))
				{
				//�������
					if ($get_user_alig['level']>=14)
					{
					$nlvlsql="and  nlevel='14' ";
					}
					else
					{
					$nlvlsql="and  nlevel='{$get_user_alig['level']}' ";
					}
				
				
					$get_proto=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.shop where id='{$artid}' and (new_item>0 or (type = 3 and nlevel >= 7)) AND ({$add_align} nalign=0) {$nlvlsql} and type={$_SESSION['mkartch']['type']} and artproto > 0 "));
				}
				else
				{
				//����������
							$add_align="nalign={$_SESSION['mkartch']['nalign']} or ";				
							$get_proto=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.shop where id='{$artid}' and (new_item>0 or (type = 3 and nlevel >= 7)) AND ({$add_align} nalign=0) and nlevel='{$_SESSION['mkartch']['nlevel']}'  and type={$_SESSION['mkartch']['type']} and artproto > 0  "));
				}
		}
		else
		{
		//�������� ������ ����

		$get_user_alig=mysql_fetch_array(mysql_query("select  id,login,align, klan, level  from oldbk.users where id='{$_SESSION['uid']}' "));
			$add_SQL=" and  nlevel <='{$get_user_alig['level']}' ";		
		
			$get_proto=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.shop where id='{$artid}' and (new_item>0 or (type = 3 and nlevel >= 7)) and artproto > 0 ".$add_SQL));       			

		}
	
	

		if  ($get_proto[id]>0)
		{
		//echo "<table border=0>";
		ShowAit($get_proto,1); 
		//echo "</table>";
		}
		else
		{
		echo '<font color=red>������ ������ ���������, ������ �������� ����������!</font>';	
		//echo "SELECT id,name,razdel,cost,nlevel, 0 as type FROM oldbk.shop where id='{$artid}' and artproto>0   AND ({$add_align} nalign=0) and nlevel='{$_SESSION['mkartch']['nlevel']}'  and type={$_SESSION['mkartch']['type']}  " ;
		}
	}
	else if ($_SESSION['save_proto_memory'])
	{
	$get_proto=$_SESSION['save_proto_memory'];
		if  ($get_proto[id]>0)
		{
		//echo "<table border=0>";
		ShowAit($get_proto,0); 
		//echo "</table>";
		}
	}
}
else
{
 die("<script>location.href='index.php?exit=314';</script>");
}
?>