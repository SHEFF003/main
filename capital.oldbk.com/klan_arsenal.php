<?php
/*
// add by Fred 25/10/2011 + NEW - owner_ars=22125
//��������� ��� ����
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
*/
	session_start();
	if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
	include "connect.php";
	include "functions.php";
	include "clan_kazna.php";	
	//if ($user[klan]=='radminion') {  echo "Admin-info:<!- GZipper_Stats -> <br>"; }	
	if ($_SESSION['boxisopen']!='open') { header('location: main.php?edit=1'); die(); }
	if ($user['klan'] == '') {    	die();	}
	if ($user['in_tower'] == 4) { header('Location: jail.php'); die(); }	

	$_SESSION['ars_razdel'] = isset($_GET['ars_razdel']) ? max(0, min(11, intval($_GET['ars_razdel']))) : (isset($_SESSION['ars_razdel']) ? $_SESSION['ars_razdel'] : 0);		

			$ars_types[0]=1; // ��� 1 ������ ����� 4
			$ars_types[1]=2; // ��� 2 �������� ����� 41
			$ars_types[2]=5; // ��� 5 ������
			$ars_types[3]=3; // ��� 3 ������
			$ars_types[4]=28; // ��� 28 ������
			$ars_types[5]=4; // ���  4  ���
			$ars_types[6]=27; // ���  4 27 �����
			$ars_types[7]=8; // ���  8 ����			
			$ars_types[8]=9; // ���  9 ����						
			$ars_types[9]=10; // ���  10 ����
			$ars_types[10]=11; // ���  11 �����
			$ars_types[11]=3; // ��� ��������
			

			
			$st=(int)($ars_types[$_SESSION['ars_razdel']]);
			if ($st<0) $st=0; 
			
	 
/*	if ($user['battle'] > 0) {
	echo "�� � ���....";
    	die();
	}
*/

	function clac_mybox()
	{
	 global $user;
	$re[massa]=0;
	$d = mysql_query("SELECT sum(massa) as massa, sum(gmeshok) as gmeshok FROM oldbk.`inventory` WHERE `owner` = 488 AND arsenal_owner='{$user[id]}'; ");
	while ($summesh = mysql_fetch_array($d))
	  {
	  $re[massa]+=$summesh[massa];
	  $re[gsum]+=$summesh[gmeshok];
	  }
	$re[gsum]+=100;
	return $re;
	}

	$klan = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`clans` WHERE `short` = '{$user['klan']}' LIMIT 1;"));
	$polno = array();
	$polno = unserialize($klan['vozm']);
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<script type="text/javascript" src="/i/globaljs.js"></script>
<style>
	.row {
		cursor:pointer;
	}
.m {background: #99CCCC;text-align: center;}
.s {background: #BBDDDD;text-align: center;}
.s2 {background: #C0D6D4;text-align: center;}

A.menu {
	FONT-WEIGHT: bold; FONT-SIZE: 8pt; COLOR: #959595; TEXT-DECORATION: none

}
A.menu2 {
	FONT-WEIGHT: bold; FONT-SIZE: 8pt; COLOR: #8F0000; TEXT-DECORATION: none

}
A.menu:hover {
	FONT-WEIGHT: bold; FONT-SIZE: 8pt; COLOR: #8F0000; TEXT-DECORATION: none

}
.menu22{
  FONT-WEIGHT: bold; FONT-SIZE: 8pt; COLOR: #003388; TEXT-DECORATION: none
}
.menu221{
background-color: #A5A5A5;
text-align: center;
}
</style>
<script type="text/javascript">

function showhide(id)
	{
	 if (document.getElementById(id).style.display=="none")
	 	{document.getElementById(id).style.display="block";}
	 else
	 	{document.getElementById(id).style.display="none";}
	}

  function show(ele) {
      var srcElement = document.getElementById(ele);
      if(srcElement != null) {
          if(srcElement.style.display == "block") {
            srcElement.style.display= 'none';
          }
          else {
            srcElement.style.display='block';
          }
      }
  }


var Hint3Name = '';
function findlogin(title, script, name){
    var el = document.getElementById("hint3");
	el.innerHTML = '<table width=100% cellspacing=1 cellpadding=0 bgcolor=CCC3AA><tr><td align=center><B>'+title+'</td><td width=20 align=right valign=top style="cursor: pointer" onclick="closehint3();"><BIG><B>x</td></tr><tr><td colspan=2>'+
	'<form action="'+script+'" method="POST"><table width=100% cellspacing=0 cellpadding=2 bgcolor=FFF6DD><tr><td colspan=2><INPUT TYPE=hidden name=sd4 value="6">'+
	'������� ����� ���������, ������� ������� �������:</TD></TR><TR><TD width=50% align=right><INPUT TYPE=text id="'+name+'" NAME="'+name+'"></TD><TD width=50%><INPUT TYPE="submit" value=" �� "></TD></TR><tr><Td colspan=2><input type="checkbox" name="iagree"> � �������� � ���, ��� ��������� ������ ����� ����� ������ ������ ����� ������������ �����.</td></tr></TABLE></FORM></td></tr></table>';
	el.style.visibility = "visible";
	el.style.left = 100;
	el.style.top = 100;
	document.getElementById(name).focus();
	Hint3Name = name;
}


function closehint3(){
	document.getElementById("hint3").style.visibility="hidden";
    Hint3Name='';
}

function showhidden(id,pn)
{


var st=document.getElementById(pn+'id_'+id).style.display;
if (st == 'none')
	{
		document.getElementById(pn+'id_'+id).style.display = 'block';
		document.getElementById(pn+'txt_'+id).style.display = 'none';
		document.getElementById(pn+'txt1_'+id).style.display = 'block';
	}
	else
	{
		document.getElementById(pn+'id_'+id).style.display = 'none';
		document.getElementById(pn+'txt_'+id).style.display = 'block';
		document.getElementById(pn+'txt1_'+id).style.display = 'none';

	}
}

</script>
</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#d7d7d7><div id=hint3 class=ahint></div>
<table width=100%>
<tr>
<td colspan=2 valign=top align=right>
<input type="button" title="���������" value="���������" onclick="location.href='main.php';">
</td>
</tr>
<tr>
<td width=50% rowspan=2 valign=top>
<center>
<table border=0 width=956>
<tr>
<td width=956 style="background-image: url(http://i.oldbk.com/i/frames/menu_bg33.jpg); background-repeat: no-repeat" >
	<table border=0 cellpadding=4 cellspacing=3>
	<tr height=38>
		<td width="15">&nbsp;</td>
		<td align="center" width=127 valign=top><a class=<?=($_GET['razdel']=='main'?'"menu2"':'"menu"')?> href=klan.php?razdel=main>�������</a></td>
		<td align="center" width=127 valign=top><a class=<?=($_GET['razdel']=='kazna'?'"menu2"':'"menu"')?> href=klan.php?razdel=kazna>�����</a></td>
		<td align="center" width=140 valign=top><a class=menu2 href=klan_arsenal.php>�������</a></td>
		<td align="center" width=143 valign=top><a class=<?=($_GET['razdel']=='wars'?'"menu2"':'"menu"')?> href=klan.php?razdel=wars>����� � �����</a></td>
		<td align="center" width=140 valign=top><a class=<?=($_GET['razdel']=='message'?'"menu2"':'"menu"')?> href=klan.php?razdel=message>���������</a></td>
		<td align="center" width=132 valign=top><a class=menu href="klan_castles.php">�����</a></td>
		<td align="center" width=122 valign=top><a class=<?=($_GET['razdel']=='maintains'?'"menu2"':'"menu"')?> href=klan.php?razdel=maintains>����������</a></td>
		<td width="5">&nbsp;</td>
	</tr>
	</table>
</td>
</tr>
</table>
<?php
//echo '<h3>������� ����� <img src="http://i.oldbk.com/i/klan/',$klan['short'],'.gif">',$klan['name'],'</h3>';
//echo '<input type="button" value="��������� � �����" onclick="location.href=\'klan.php\'"/><p>';
//echo '</center>';
/* print_r($_GET);
 echo '<br>';
 print_r($_POST);
*/
	if ($user['in_tower'] == 1) {
	echo "�� � �����....";
    	die("</body></html>");
	}
	if ((($user['room']>=210)AND($user['room']<299)) OR ($user[in_tower]==3) )
	{
	echo "�� � ���������....";
    	die("</body></html>");
	 }
	
	if ($user['ruines'] > 0)
	{
	echo "�� � ������....";
    	die("</body></html>");
	}
	 
	if (($user['room'] >=197)AND($user['room'] <=199)) 
	{
	echo "������������ �����....";
    	die("</body></html>");
									
	}
		
		//��������� ����� ������� ��� ���� ����� ����� ���� �� �� ����� - ���� ����� �� ����� ����
		if  ($klan['glava'] !=$user['id'] )
		{
			$array_access=array();
			$dataaccess = mysql_query("SELECT * from oldbk.clans_arsenal_access where klan_id='{$klan[id]}' and owner='{$user[id]}' ;");
			while($rowaccess= mysql_fetch_array($dataaccess)) 
				{
				$array_access[]=$rowaccess[item];
				}
		}
		else
		 { $IM_glava=1; }
		 
		 if (($IM_glava==1) and ($_POST[sit_access]) )
		 {

		 //ars_razdel=2
		 
		 if (($st==3) and ($_SESSION['ars_razdel']==3) )
				{
				$st_sql=" type='{$st}' and otdel!=6 ";				
				}
			elseif ($st==3)
				{
				$st_sql=" type='{$st}' and otdel=6 ";				
				}
				else
				{
				$st_sql=" type='{$st}'  ";
				}

		 //���� � ����� � �������� ������ �� ��������� ����� ����
		 //������ ���� ����� � 0; - ������ � ������� �������		 
		 
		 mysql_query("update oldbk.clans_arsenal set all_access=0 where klan_name='{$klan[short]}' and owner_original=1 and owner_current=0 and id_inventory in (select id from inventory where id=id_inventory and {$st_sql} );");
		 // mysql_query("update oldbk.clans_arsenal set all_access=0 where klan_name='{$klan[short]}' and owner_original=1 and owner_current=0;");

		 foreach ($_POST[mass_cl] as $mass_cl_key => $mass_cl_val)
		 		{

				 if ($mass_cl_val=='on')
				 	{
				 	$ids_to_update.=(int)($mass_cl_key).",";
				 	}
		 		}
		 		
		 		$ids_to_update=substr($ids_to_update,0,-1);		
			 	if (($ids_to_update!='') and ($ids_to_update!='0') )
		 		{
		 		//������ 1 ������ ��� ���� ����
				mysql_query("update oldbk.clans_arsenal set all_access=1 where id_inventory in (".$ids_to_update.") and  klan_name='{$klan[short]}' and owner_original=1 and owner_current=0;");
		 		}
		 	
		 
		 }
		 	
		 
		 

if ((($klan['glava']==$user['id'] OR $polno[$user['id']][2] == 1) ) and (!(isset($_GET['mybox']))) )  {

		if($_GET['get'] == 1 && $_GET['item'])
		{
		 $itm_id=(int)$_GET['item'];
		 if ($itm_id>0)
		 {
		    {
			
				 // ������� ��� �� ����
				 $item = mysql_fetch_array(mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access  FROM oldbk.inventory i WHERE arsenal_klan='{$user['klan']}' and i.type != 300 and i.type != 301 and id='".$itm_id."'"));
				 
					if (($item['arsenal_klan'] == $user['klan']) and ($item[id]>0))
					{
						 if($item['owner'] == 22125) 
						 {
						  // ���� ����� �� ������������
						  //�������� �� ������� ����
						     
						     if($item[add_pick]!='')
								        {
								         	undress_img($item);
								        }
							if (($item['type']==556) AND  ($IM_glava!=1))
							{
							   err("���� ������� ������ ����� �� ��������!<br>");
							}
							else								        
						       if($item['arsenal_owner'] == $user['id']) {
								// ��� ������ ������ ��� ��� ��������

									if(mysql_query("update oldbk.inventory set owner='{$item['arsenal_owner']}', arsenal_klan='', arsenal_owner=0 , present='' where id='{$item['id']}' and owner='22125'")) {
										// ���������� ����

										$log_text = '"'.$user[login].'" ������ �� �������� "'.$item[name].'" ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item[unik].'/inc:'.$item['includemagicname'].']';
										$delo_text = '"'.$user[login].'" ������ �� �������� ����� "'.$user[klan].'" "'.$item[name].'" id:('.get_item_fid($item).') ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item[unik].'/inc:'.$item['includemagicname'].']';
										mysql_query("DELETE FROM oldbk.clans_arsenal WHERE id_inventory='{$item[id]}'");
										 //new_delo
					  		    			$rec['owner']=$user[id]; 
										$rec['owner_login']=$user[login];
										$rec['owner_balans_do']=$user[money];
										$rec['owner_balans_posle']=$user[money];
										$rec['target']=22125;
										$rec['target_login']='�������';
										$rec['type']=61;//������ �� ����
										$rec['sum_kr']=0;
										$rec['sum_ekr']=0;
										$rec['sum_kom']=0;
										$rec['item_id']=get_item_fid($item);
										$rec['item_name']=$item['name'];
										$rec['item_count']=1;
										$rec['item_type']=$item['type'];
										$rec['item_cost']=$item['cost'];
										$rec['item_dur']=$item['duration'];
										$rec['item_maxdur']=$item['maxdur'];
										$rec['item_ups']=$item['ups'];
										$rec['item_unic']=$item['unic'];
										$rec['item_incmagic']=$item['includemagicname'];
										$rec['item_incmagic_count']=$item['includemagicuses'];
										$rec['item_arsenal']=$user[klan];
										add_to_new_delo($rec); 
										if (olddelo==1)
										{
										mysql_query("INSERT INTO oldbk.delo (pers,text,type,date) VALUES ('{$user[id]}','{$delo_text}',1,'".time()."')");
										}
										mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
										echo "<b><font color=red>�� ������� {$item[name]} �� �������� �����</font></b><br/><br/>";
									}
							 }
							 else
							 {
							 // ��������� ������� ������ ��� ����� �� ��������
							   $aget_ars=mysql_fetch_array(mysql_query("select count(id) from oldbk.inventory where owner={$user[id]} and arsenal_klan!='';"));
							   if ($aget_ars[0] >=5)
							    {
							       err("�� ��� ����� ".$aget_ars[0]." ��������� �� ��������!<br>");
							    }
							    else
							    {
							    
							    if (($item[all_access]==1) OR ($IM_glava==1) OR (in_array($item[id], $array_access)) )
							    //���� ������� ���� ��� � ����� ��� ������ ������ �� ��������� �����
							    {
							   // ���� ����� ��� ��� �� �� ������ - �� ������ �� ����� - ��� ���� ���������� ���������
							   /// �������� �� ������
							   $bb_time=time()+604800;
									if(mysql_query("update oldbk.inventory set owner='{$user['id']}', present='���� {$user[klan]}' , `letter`='����� ��: ".date("d/m/Y H:i",$bb_time)."' , `prokat_do`='".$bb_time."' where id='{$item['id']}' and owner='22125'")) 
									{
										// ���������� ����
										$log_text = '"'.$user[login].'" ���� �� �������� "'.$item[name].'"'.$ttt.' ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item[unik].'/inc:'.$item['includemagicname'].']';
										$delo_text = '"'.$user[login].'" ���� �� �������� ����� "'.$user[klan].'" "'.$item[name].'" id:('.get_item_fid($item).') ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].']';
										mysql_query("UPDATE oldbk.clans_arsenal SET owner_current='{$user[id]}' WHERE id_inventory='{$item[id]}'");
										
										 //new_delo
					  		    			$rec['owner']=$user[id]; 
										$rec['owner_login']=$user[login];
										$rec['owner_balans_do']=$user[money];
										$rec['owner_balans_posle']=$user[money];
										$rec['target']=22125;
										$rec['target_login']='�������';
										$rec['type']=62;//���� ������� �� ����
										$rec['sum_kr']=0;
										$rec['sum_ekr']=0;
										$rec['sum_kom']=0;
										$rec['item_id']=get_item_fid($item);
										$rec['item_name']=$item['name'];
										$rec['item_count']=1;
										$rec['item_type']=$item['type'];
										$rec['item_cost']=$item['cost'];
										$rec['item_dur']=$item['duration'];
										$rec['item_maxdur']=$item['maxdur'];
										$rec['item_ups']=$item['ups'];
										$rec['item_unic']=$item['unic'];
										$rec['item_incmagic']=$item['includemagicname'];
										$rec['item_incmagic_count']=$item['includemagicuses'];
										$rec['item_arsenal']=$user[klan];
										$rec['add_info']=date("d/m/Y H:i",$bb_time);
										add_to_new_delo($rec); 
										if (olddelo==1)
										{
										mysql_query("INSERT INTO oldbk.delo (pers,text,type,date) VALUES ('{$user[id]}','{$delo_text}',1,'".time()."')");
										}
										mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
										echo "<b><font color=red>�� ����� {$item[name]} �� �������� ����� ��:".date("d/m/Y H:i",$bb_time)."</font></b><br/><br/>";
									}
								   }
								   else
								   {
								   err("������� �� ������!<br>");
								   }
									
									
								}	
							} 
						 }
						 else
						 {
						 //���� ������������
							if($_GET['getmy'] == 1) {
							      //��������� ������� �� ��� ��� �������� �� ��������
								if($item['arsenal_owner'] == $user['id']) {
								
								if($item[add_pick]!='')
								        {
								         	undress_img($item);
								        }
								
									// ok
									// �� ��������� � ���� ������ ��� �� ����
									$cur = check_users_city_data($item['owner']);
									
									if($cur['in_tower'] ==1) 
									{
									echo "<b><font color=red>�������� ''{$cur['login']}'' ������ � ����� ������. ���������.</font></b><br/><br/>";
									}
									elseif($cur['in_tower'] > 1) 
									{
									echo "<b><font color=red>�������� ''{$cur['login']}'' ������ � ������. ���������.</font></b><br/><br/>";
									}
									elseif( ($cur['room']>=197 and $cur['room']<=199) or ($cur['room']>=211 and $cur['room']<240) or ($cur['room']>240 and $cur['room']<270) or ($cur['room']>270 and $cur['room']<290) )
									{
									echo "<b><font color=red>�������� ''{$cur['login']}'' ������ � ���������. ���������.</font></b><br/><br/>";
									}
									else
									if($cur['battle'] > 0) {
										echo "<b><font color=red>�������� ''{$cur['login']}'' ������ � ���. ���������.</font></b><br/><br/>";
									} else {
									//������ ���� - �� �������� �� ����� �� ���!
									//���� ����� �� ������� ��� - � ��������� ������ ��� ����
										if($item[dressed] == 1)		{  undressall($item[owner],$cur[id_city]);	}												
										$txt_fid=get_item_fid($item);
										//�������� ���� ������ ���� ��������
										$sql_zabiram="update oldbk.inventory set owner='{$item['arsenal_owner']}', arsenal_klan='', present='', `letter`='' , `prokat_do`='' , arsenal_owner=0  where id='{$item['id']}' and owner='{$item['owner']}'";

										if(mysql_query($sql_zabiram)) {
											// ���������� ����
											$log_text = '"'.$user[login].'" ������ ����������� ���� "'.$item[name].'"'.$ttt.' ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].'] � "'.$cur['login'].'"';
											$delo_text = '"'.$user[login].'" ������ ����������� ���� ����� "'.$user[klan].'" "'.$item[name].'"'.$ttt.' id:('.$txt_fid.') ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].'] � ��������� "'.$cur[login].'"';
											mysql_query("DELETE FROM oldbk.clans_arsenal WHERE id_inventory='{$item[id]}'");
											
										 //new_delo
					  		    			$rec['owner']=$user[id]; 
										$rec['owner_login']=$user[login];
										$rec['owner_balans_do']=$user[money];
										$rec['owner_balans_posle']=$user[money];
										$rec['target']=22125;
										$rec['target_login']='�������';
										$rec['type']=63;//������ � ����
										$rec['sum_kr']=0;
										$rec['sum_ekr']=0;
										$rec['sum_kom']=0;
										$rec['item_id']=get_item_fid($item);
										$rec['item_name']=$item['name'];
										$rec['item_count']=1;
										$rec['item_type']=$item['type'];
										$rec['item_cost']=$item['cost'];
										$rec['item_dur']=$item['duration'];
										$rec['item_maxdur']=$item['maxdur'];
										$rec['item_ups']=$item['ups'];
										$rec['item_unic']=$item['unic'];
										$rec['item_incmagic']=$item['includemagicname'];
										$rec['item_incmagic_count']=$item['includemagicuses'];
										$rec['item_arsenal']=$user[klan];
										$rec['add_info']=$cur['login'];
										add_to_new_delo($rec); 
										$rec['owner']=$cur[id]; 
										$rec['owner_login']=$cur[login];
										$rec['owner_balans_do']=$cur[money];
										$rec['owner_balans_posle']=$cur[money];
										$rec['type']=64;//�������� � ����
										$rec['add_info']=$user['login'];										
										add_to_new_delo($rec); 										
											
											if (olddelo==1)
											{
											mysql_query("INSERT INTO oldbk.delo (pers,text,type,date) VALUES ('{$user[id]}','{$delo_text}',1,'".time()."')");
											mysql_query("INSERT INTO oldbk.delo (pers,text,type,date) VALUES ('{$item[owner]}','{$delo_text}',1,'".time()."')");
											}
											
											mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
											/// ��� ����� � ��� ��������
											echo "<b><font color=red>�� ������� {$item[name]} � ��������� ".global_nick($item[owner])."</font></b><br/><br/>";

										}

									}
								} else {
									// no
									echo "��� �� ���� ����! �� �� ������ ������������� �� �������!";
								}
							} else {
								echo "��� ���� ������������ ".global_nick($item['arsenal_owner']).", �� ������ ������� ������.";
							}
						 }
					}
					else
					{
					echo "������ ������������ - 2.";
					}
				
				
		      }
		}
		}
		
	// ����� �� �� �������� ����...
	if (($_GET['put'] == 1) OR ($_GET['put'] == 2)) {
		// return
		if (time()< mktime(23, 59, 59,12,14,2011) )  { $GIFT_TO_ARS=1; } else { $GIFT_TO_ARS=0; }
		
		if ($klan['glava']!=$user['id'])  {$_GET['put']=1;} //�� ����� �����
		if ($GIFT_TO_ARS!=1)  {$_GET['put']=1;} //�� ����� �����		
		
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		echo "���� ������ �����, ������� �� ������ ����� � �������, �� ����� �� ����� <b>5 ���������</b>.<br>";
		$get_all_put=mysql_fetch_array(mysql_query("SELECT count(id) as all_my_put  FROM oldbk.inventory WHERE arsenal_klan='{$user[klan]}' and arsenal_owner='{$user['id']}';"));

if ($GIFT_TO_ARS==1)		 
	{
		 if ($klan['glava']==$user['id'])
		 { $get_all_gift=mysql_fetch_array(mysql_query("SELECT count(gift) as kol_gift FROM oldbk.clans_arsenal WHERE klan_name='{$user[klan]}' and gift=1;")); }
  	}
		 
		// ����� � �������
	   if  ( ($_GET['put'] == 1)  and ($_GET['item'] ) and ($get_all_put[all_my_put] >=5)) { err("<b>��������! ��� ��������� ����� ����� � �������!</b><br>"); }
	   else
    	   	if  ( ($_GET['put'] == 2)  and ($_GET['item'] ) and ($get_all_gift[kol_gift] >=50)) { err("<b>��������! ��� ��������� ����� �������� � �������!</b><br>"); }
	     else
	     {
		if($_GET['item'] ) {
			// ����� ����
			
				$item = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory WHERE id='".(int)$_GET['item']."' and `labflag`=0 and `labonly`=0 and type in (1,2,3,4,5,6,7,8,9,10,11,28,27);"));

				if($item[id] == $_GET['item'] && $item['sowner'] == 0 && $item[owner] == $user['id'] && $item[dressed] == 0 && $item[cost] > 0 && $item[present] == ''&& $item[prokat_idp] == 0 && $item[setsale] == 0)
				{

				   if($item[add_pick]!='')
			       {
			         undress_img($item);
			         $ok1=1;
			       }
					else
					{
						$ok1=1;
					}

					// �������� ��������, ����� ����
                    if($ok1==1)
                    {
                     				
                        			$it_fid=get_item_fid($item);
                        			                        			
                    					if ($_GET['put'] == 2)  { $set_ars_owner=1; $set_ars_txt='�������'; $set_ars_dtype=86; $set_ars_gift=1;  } else {$set_ars_owner=$user['id']; $set_ars_txt='����'; $set_ars_dtype=65; $set_ars_gift=0;  }
                    				
                    				//������ oldbk. �.�. ��� ������ �������� ����� � ��������
						if(mysql_query("update oldbk.inventory set owner='22125', arsenal_klan='{$user[klan]}', arsenal_owner='{$set_ars_owner}'   where id='{$item[id]}' and owner='{$user['id']}' and bs_owner=0")) 
							{
							// ���������� ���� � ��������� ������������ ���������
							$log_text = '"'.$user[login].'" '.$set_ars_txt.' � ������� "'.$item[name].'"'.$ttt.' ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].']';
							$delo_text = '"'.$user[login].'" '.$set_ars_txt.' � ������� ����� "'.$user[klan].'"'.$ttt.' "'.$item[name].'" id:('.$it_fid.') ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].']';
						
							mysql_query("INSERT INTO oldbk.clans_arsenal (id_inventory, klan_name, owner_original, gift)  VALUES  ('{$item[id]}','{$user['klan']}','{$set_ars_owner}','{$set_ars_gift}')");

										//new_delo
					  		    			$rec['owner']=$user[id]; 
										$rec['owner_login']=$user[login];
										$rec['owner_balans_do']=$user[money];
										$rec['owner_balans_posle']=$user[money];
										$rec['target']=22125;
										$rec['target_login']='�������';
										$rec['type']=$set_ars_dtype;//���� ���� � ���
										$rec['sum_kr']=0;
										$rec['sum_ekr']=0;
										$rec['sum_kom']=0;
										$rec['item_id']=get_item_fid($item);
										$rec['item_name']=$item['name'];
										$rec['item_count']=1;
										$rec['item_type']=$item['type'];
										$rec['item_cost']=$item['cost'];
										$rec['item_dur']=$item['duration'];
										$rec['item_maxdur']=$item['maxdur'];
										$rec['item_ups']=$item['ups'];
										$rec['item_unic']=$item['unic'];
										$rec['item_incmagic']=$item['includemagicname'];
										$rec['item_incmagic_count']=$item['includemagicuses'];
										$rec['item_arsenal']=$user[klan];
										add_to_new_delo($rec); 							
							if (olddelo==1)
							{
							mysql_query("INSERT INTO oldbk.delo (pers,text,type,date) VALUES ('{$user[id]}','{$delo_text}',1,'".time()."')");
							}
							mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
							if ($_GET['put'] == 2) {
										echo "<b><font color=red>�� �������� {$item[name]} � ������� �����</font></b><br/><br/>"; 
										$get_all_gift[kol_gift]++;
										} 
										else 
										{
										 echo "<b><font color=red>�� ����� {$item[name]} � ������� �����</font></b><br/><br/>"; 
			 							$get_all_put[all_my_put]++;
										 }
							
							}
					}
					else
					{
						echo '������ ������ ��������.';
					}

				}
				else
				{
					echo "������ ������ ������.";
				}
			
		}
		}
		echo "�� ����� �����:<b>".$get_all_put[all_my_put]." ���������</b>.<br>";
		// ����� ����� ��������� ��� ����� � �������
		if ($GIFT_TO_ARS==1)		 
		{
		if ($klan['glava']==$user['id']) { $giftars=1; echo "�� ������ �������� � ������� ���:<b>".(50-$get_all_gift[kol_gift])."</b> ���������"; }
		}
		
			echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">

			
		<TR>
			<TD>
			<TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 0) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=0">&nbsp;������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 1) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=1">&nbsp;��������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 2) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=2">&nbsp;������</A></TD>				
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 3) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=3">&nbsp;������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 4) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=4">&nbsp;������ �����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 5) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=5">&nbsp;������� �����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 6) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=6">&nbsp;�����</A></TD>				
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 7) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=7">&nbsp;�����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 8) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=8">&nbsp;��������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 9) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=9">&nbsp;����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 10) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=10">&nbsp;������</A></TD>				
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 11) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?put=1&ars_razdel=11">&nbsp;��������</A></TD>								
				</TR>
			</TABLE>
			</TD>
		</TR>

			';
			
			if (($st==3) and ($_SESSION['ars_razdel']==3) )
				{
				$st_sql=" type='{$st}' and otdel!=6 ";				
				}
			elseif ($st==3)
				{
				$st_sql=" type='{$st}' and otdel=6 ";				
				}
				else
				{
				$st_sql=" type='{$st}'  ";
				}			
			
			
			$data = mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$_SESSION['uid']}' AND `dressed` = 0 AND `present` = '' AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `labonly`=0 AND cost>0  and sowner = 0 AND `setsale`=0 and ".$st_sql."  ORDER by `update` DESC; ");

			while($row = mysql_fetch_array($data)) {                 if($row[otdel]==7 || $row[otdel]==71|| $row[otdel]==72|| $row[otdel]==73)
				{
					$inv_shmot[0][0][$row[otdel]][]=$row;
				}
				else //���� ��� ���������� - �� �� �� ���������
				{
					$inv_shmot[0][0][$row[prototype]][]=$row;
				}
		  		$inv_gr_key[$row[prototype]]=0;
		 		$count++;


			}
            foreach ($inv_shmot as $key2 => $value2)
				{
				  foreach ($value2 as $key => $value)
					 {
					      foreach ($value as $key1 => $value1)
						{
		                   //��� ���� �������� ���������� �� �������, ���� ����������� ���������..
		                         $div_group=0;
		                         echo '<tr><td>';
							    if($inv_gr_key[$key1]==1)
							    {
					      			$group_key=1;
								}
								else
								{
						        	$group_key=count($value1);
								}
								for($i=0;$i<$group_key;$i++)
								{
					                $showed=0;
                                    $value1[$i][chk_arsenal]=3;    //0-�� ����� ����������� ���. 1 ��� ������ � "����� �� ��������"  2-��� ���� �������. 3-��� ���� ��������

					               // if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								    $color = '#C7C7C7';
								    $value1[$i]['inv']=1;
									if($value1[$i]['group']==1)
									{
					                   $value1[$i]['group_by']=1;
									}

									if($inv_gr_key[$key1]==1)
								    {
								    	$value1[$i]['count'] =  count($value1);
										echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
										showitem($value1[$i],0,false,$color,'');
										echo '</table>';
										$showed=1;
								    }
									else
									{
										$value1[$i]['count'] = 1;

												if($group_key>1 && $i==0){
													$div_group=1;
													echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
                                      									showitem($value1[$i],0,false,$color,'');
													echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
													echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a></div>";
													echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div>
													</td></tr>";
				                                	echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
													$showed=1;
												}
									}
									if($showed==0)
								    {
			                              	echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
											showitem($value1[$i],0,false,$color,'');
											echo "</table>";
			         				}
					              if($i==($group_key-1) && $div_group==1)
		                            {
		                            	echo '</div>';
		                            }

								}
		                       echo '</td></tr>';
						}
			        }
			     }







			echo '</TABLE>';
	} elseif ($_GET['log'] == 1 || $_POST['log'] == 1) {
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';

			if (!$_POST['logs']) {$_POST['logs']=date("d.m.y");}
			echo '<TABLE><TR><TD colspan=3><FORM METHOD=POST ACTION=klan_arsenal.php>
			����������� ������� �������� �� <INPUT TYPE=text NAME=logs size=12 value="'.$_POST['logs'].'"> <input type=hidden name=log value="1"><INPUT TYPE=submit value="�����������!"></form></TD>
			</tr><tr><td><FORM METHOD=POST ACTION=klan_arsenal.php><input type=hidden name=log value="1">
			<INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)-1, "20".substr($_POST['logs'],6,2))).'">
			<INPUT TYPE=submit value="   �   "></form></TD>
			<TD valign=top align=center>������� �������� ����� <b>"'.$user['klan'].'"</b> ��  <b>'.$_POST['logs'].'</b></TD>
			<TD><FORM METHOD=POST ACTION=klan_arsenal.php><INPUT TYPE=hidden NAME=logs value="'.date("d.m.y",mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2)+1, "20".substr($_POST['logs'],6,2))).'">
			<input type=hidden name=log value="1"> <INPUT TYPE=submit value="   �   "></form></TD>
			</TR></TABLE></form>';
			if($_POST['logs']) {
					$ddate1=mktime(0, 0, 0, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
					$ddate2=mktime(23, 59, 59, substr($_POST['logs'],3,2), substr($_POST['logs'],0,2), "20".substr($_POST['logs'],6,2));
					$logs = mysql_query("SELECT * FROM oldbk.`clans_arsenal_log` WHERE `klan` = '{$user['klan']}' AND `date` > '$ddate1' AND `date` < '$ddate2' ORDER by `id` ASC;");
					
					echo '<table  border="0" cellspacing="0" cellpadding="0"><tr><td><small>';
					while($row = @mysql_fetch_array($logs)) {
						$dat=date("d.m.y H:i",$row['date']);
						echo "<span class=date>{$dat}</span> {$row['text']}<br>";
					}
					echo '</small></td></tr></table>';
			}


	} 
/*
	elseif (($_GET[changeclanart]) and ($klan['glava']==$user['id'] ) )
	{
		// ������� ������ ���� �����
		$klan_art_ecost=1000;
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		$klan_kazna=clan_kazna_have($klan['id']);	

		if ($_SERVER['REQUEST_METHOD'] != "POST") {
			if ($klan_kazna) { echo "<br>� ����� �����:<font color=green><b>{$klan_kazna[ekr]} ���.</b></font><br><br>" ; }
		}

		if (!isset($_GET['change'])) {
			echo "���� ������ �������� ����������, ������� �� ������ ��������. ���� ������ - <b>100 ���.</b><br/><br/>";
			echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
			$data = mysql_query("select * from oldbk.inventory where owner=22125 and arsenal_klan='{$klan[short]}' and art_param!=''");
			while($row = mysql_fetch_array($data))                                                   
			{
				 $color = '#C7C7C7';
				 $row[showbill]=true;
				 $row[ecost]=$klan_art_ecost;
			 	
			 	if ($klan_kazna)
			 	{
			 	$links_bill="<a href=klan_arsenal.php?changeclanart=1&change={$row[id]}>�������</a>";
			 	}
			 	else
			 	{
			 	$links_bill="��� ����� �����";
			 	}
			 
				showitem($row,0,false,$color,$links_bill);
			}
			echo '</TABLE>';
		} elseif (isset($_GET['change']) && !isset($_GET['tochange'])) {
			$_GET['change'] = intval($_GET['change']);

			$fromart = mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where owner=22125 and arsenal_klan='{$klan[short]}' and art_param!='' and id = ".$_GET['change']));
			if ($fromart === FALSE) die();

			echo "���� ������ �������� ����������, �� ������� �� ������ ��������.<br/><br/>";
			echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
			$data = mysql_query("select * from oldbk.art_prototype where arsenal_klan='{$klan[short]}' and id != ".$fromart['prototype']." and art_status=2");
			while($row = mysql_fetch_array($data)) 
			{
			 $color = '#C7C7C7';
			 $row[showbill]=true;
			 $row[ecost]=$klan_art_ecost;

			 	
			 	if ($klan_kazna)
			 	{
			 	$links_bill="<a href=klan_arsenal.php?changeclanart=1&change=".$_GET['change']."&tochange={$row[id]}>�����</a>";
			 	}
			 	else
			 	{
			 	$links_bill="��� ����� �����";
			 	}
			 
				showitem($row,0,false,$color,$links_bill);
			}
			echo '</TABLE>';
		} elseif (isset($_GET['change']) && isset($_GET['tochange'])) {
			if ($klan_kazna) {
				$showform = 1;
				if ($_SERVER['REQUEST_METHOD'] == "POST") {
					echo '<br><br>';
					if ($klan_kazna['ekr_pass'] == $_POST['ekr_pass']) {
						if ($klan_kazna['ekr'] >= 100) {
							$fromart = mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where owner=22125 and arsenal_klan='{$klan[short]}' and art_param!='' and id = ".intval($_GET['change'])));
							if (!$fromart) die();
							$toart = mysql_query("select * from oldbk.art_prototype where arsenal_klan='{$klan[short]}' and id != ".$fromart['prototype']." and art_status=2 and id = ".intval($_GET['tochange']));
							if (mysql_num_rows($toart) > 0) {
								$toart = mysql_fetch_assoc($toart);
	
								// �������� �����

								$artinfo = $fromart;
								$us = $user;
								$test_art_bill = $toart;

								// ������
								$q = mysql_query('START TRANSACTION') or die();

 		  			 			//��������� �����  � ����� �����
 		  			  			$get_pay=by_from_kazna($klan[id],2,100,"(����� ��������� ���������  �� {$test_art_bill[name]}, ���� �".$toart['id'].").");


 		  			  			if ($get_pay) {
			 		  			  	if ($test_art_bill[nlevel] > 6) {
						     				$uplevel=$test_art_bill[nlevel];
						     			} else {
									     	$uplevel=6;
								     	}

									mysql_query("INSERT INTO `oldbk`.`inventory` SET 
										`name`='{$test_art_bill[name]}',
										`duration`='{$test_art_bill[duration]}',`maxdur`='{$test_art_bill[maxdur]}',`cost`='{$test_art_bill[cost]}',`owner`='{$test_art_bill[owner]}',
										`nlevel`='{$test_art_bill[nlevel]}',`nsila`='{$test_art_bill[nsila]}',`nlovk`='{$test_art_bill[nlovk]}',`ninta`='{$test_art_bill[ninta]}',`nvinos`='{$test_art_bill[nvinos]}',`nintel`='{$test_art_bill[nintel]}',
										`nmudra`='{$test_art_bill[nmudra]}',`nnoj`='{$test_art_bill[nnoj]}',`ntopor`='{$test_art_bill[ntopor]}',`ndubina`='{$test_art_bill[ndubina]}',`nmech`='{$test_art_bill[nmech]}',
										`nalign`='{$test_art_bill[nalign]}',`minu`='{$test_art_bill[minu]}',`maxu`='{$test_art_bill[maxu]}',
										`gsila`='{$test_art_bill[gsila]}',`glovk`='{$test_art_bill[glovk]}',`ginta`='{$test_art_bill[ginta]}',
										`gintel`='{$test_art_bill[gintel]}',`ghp`='{$test_art_bill[ghp]}',
										`mfkrit`='{$test_art_bill[mfkrit]}',`mfakrit`='{$test_art_bill[mfakrit]}',`mfuvorot`='{$test_art_bill[mfuvorot]}',`mfauvorot`='{$test_art_bill[mfauvorot]}',
										`gnoj`='{$test_art_bill[gnoj]}',`gtopor`='{$test_art_bill[gtopor]}',`gdubina`='{$test_art_bill[gdubina]}',`gmech`='{$test_art_bill[gmech]}',
										`img`='{$test_art_bill[img]}',`text`='',`dressed`=0,
										`bron1`='{$test_art_bill[bron1]}',`bron2`='{$test_art_bill[bron2]}',`bron3`='{$test_art_bill[bron3]}',`bron4`='{$test_art_bill[bron4]}',
										`dategoden`=0,`magic`=0,
										`type`='{$test_art_bill[type]}',
										`present`='',`sharped`=0,
										`massa`='{$test_art_bill[massa]}',
										`goden`=0,`needident`=0,
										`nfire`='{$test_art_bill[nfire]}',`nwater`='{$test_art_bill[nwater]}',`nair`='{$test_art_bill[nair]}',`nearth`='{$test_art_bill[nearth]}',`nlight`='{$test_art_bill[nlight]}',`ngray`='{$test_art_bill[ngray]}',
										`ndark`='{$test_art_bill[ndark]}',`gfire`='{$test_art_bill[gfire]}',`gwater`='{$test_art_bill[gwater]}',`gair`='{$test_art_bill[gair]}',`gearth`='{$test_art_bill[gearth]}',`glight`='{$test_art_bill[glight]}',`ggray`='{$test_art_bill[ggra]}',`gdark`='{$test_art_bill[gdark]}',
										`letter`='',`isrep`=1,`update`='',`setsale`=0,
										`prototype`='{$test_art_bill[prototype]}',
										`otdel`='{$test_art_bill[otdel]}',`bs`=0,	`gmp`='{$test_art_bill[gmp]}',
										`includemagic`=0,`includemagicdex`=0,`includemagicmax`=0,`includemagicname`='',`includemagicuses`=0,`includemagiccost`=0,`includemagicekrcost`=0,
										`gmeshok`=0,`tradesale`=0,`karman`=0,
										`stbonus`={$test_art_bill[stbonus]},`upfree`=0,`ups`=5,
										`mfbonus`={$test_art_bill[mfbonus]},`mffree`=0,
										`type3_updated`=1,`bs_owner`=0,`nsex`=0,
										`present_text`='',`add_time`=0,`labonly`=0,`labflag`=0,`prokat_idp`=0,`prokat_do`=0,
										`arsenal_klan`='{$test_art_bill[arsenal_klan]}',`arsenal_owner`='{$test_art_bill[arsenal_owner]}',
										`repcost`='{$test_art_bill[repcost]}',
										`up_level`='{$uplevel}',
										`ecost`='{$klan_art_ecost}',
										`group`=0,`ekr_up`='{$test_art_bill[ekr_up]}',
										`unik`=1,
										`add_pick`='',`pick_time`=0,
										`sowner`='{$test_art_bill[sowner]}',
										`idcity`=0,`battle`=0,`t_id`=0,
										`ab_mf`='{$test_art_bill[ab_mf]}',`ab_bron`='{$test_art_bill[ab_bron]}',`ab_uron`='{$test_art_bill[ab_uron]}',
										`art_param` ='{$test_art_bill[art_param]}' ;") or die();

					  			  		//����� � ��� ��������!
					  			  		//����� � ���. ��������+���
									  	$inserted_id=mysql_insert_id();
										mysql_query("INSERT INTO oldbk.clans_arsenal (id_inventory, klan_name, owner_original, gift) VALUES  ('{$inserted_id}','{$test_art_bill[arsenal_klan]}','1','0')") or die();


										$lognew = "cap";
										if (CITY_ID == 1) $lognew = "ava";

										$log_text = '����� ��������� ��������� "'.$fromart[name].'" ('.get_item_fid($fromart).')  ['.$fromart[duration].'/'.$fromart[maxdur].'] [ups:'.$fromart['ups'].'/unik:'.$fromart['unik'].'/inc:'.$fromart['includemagicname'].']" �� "'.$test_art_bill[name].'" ('.$lognew.$inserted_id.') ['.$test_art_bill[duration].'/'.$test_art_bill[maxdur].'] [ups:'.$test_art_bill['ups'].'/unik:'.$test_art_bill['unik'].'/inc:'.$test_art_bill['includemagicname'].']';

										mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$test_art_bill[arsenal_klan]}','1','{$log_text}','".time()."')") or die();
				 		  			  	err("�� �������� �������� �������� <b>{$fromart[name]}</b> �� <b>{$test_art_bill[name]}</b>.<br>");
 		  			  	
			 		  			  		$klan_kazna[ekr]-=100;
		 		  			  	} else {
									die("�� ���������� ������� � �������� �����");
								}

								// ������� ������ ���
								mysql_query('DELETE FROM oldbk.inventory WHERE id = '.$fromart['id']) or die();
								mysql_query('DELETE FROM oldbk.clans_arsenal WHERE id_inventory = '.$fromart['id']) or die();


								// ����� ���������� ����� � ����� � ����
								if ($artinfo['includemagic'] > 0) {
									$dress = mysql_query('SELECT * FROM oldbk.shop WHERE magic = '.$artinfo['includemagic'].' AND name = "'.$artinfo['includemagicname'].'"') or die();
									if (mysql_num_rows($dress) == 0) {
										$dress = mysql_query('SELECT * FROM oldbk.eshop WHERE magic = '.$artinfo['includemagic'].' AND name = "'.$artinfo['includemagicname'].'"') or die();
									}						
									$dress = mysql_fetch_assoc($dress);
									if ($dress !== FALSE) {
										mysql_query("INSERT INTO oldbk.`inventory`
											(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
											`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
											`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
											`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`
											)
											VALUES
											('{$dress['id']}','{$us['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
											'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
											'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
											,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','0'
											);
										") or die();
	
										//new_delo
										$rec = array();
					  		    			$rec['owner']=$us[id];
										$rec['owner_login']=$us[login];
										$rec['owner_balans_do']=$us['money'];
										$rec['owner_balans_posle']=$us['money'];
										$rec['target_login']="��";
										$rec['type']=99; // ������� �������
										$rec['sum_kr']=0;
										$rec['sum_ekr']=0;
										$rec['sum_kom']=0;
										$rec['item_id']=get_item_fid(array("idcity" => $us['id_city'], "id" => mysql_insert_id()));
										$rec['item_name']=$dress[name];
										$rec['item_count']=1;
										$rec['item_type']=$dress['type'];
										$rec['item_cost']=$dress['cost'];
										$rec['item_dur']=$dress['duration'];
										$rec['item_maxdur']=$dress['maxdur'];
										$rec['item_ups']=$dress['ups'];
										$rec['item_unic']=$dress['unic'];
										$rec['item_incmagic']=$dress['includemagicname'];
										$rec['item_incmagic_count']=$dress['includemagicuses'];
										$rec['item_arsenal']='';
										$rec['item_proto']=$dress['prototype'];
										$rec['item_sowner']=($dress['sowner']>0?1:0);
										$rec['item_incmagic_id']=$dress['includemagic'];
										if (add_to_new_delo($rec) === FALSE) die();
			
										err("������� ����� ������ ".$dress['name']." <img src=\"http://i.oldbk.com/i/sh/".$dress['img']."\"><br>");
									}

									// ����� �������� �������� - ����� � ����� � ����
									$dress = mysql_query('SELECT * FROM oldbk.shop WHERE id = 168') or die();
									$dress = mysql_fetch_assoc($dress);
									if ($dress !== FALSE) {
										mysql_query("INSERT INTO oldbk.`inventory`
											(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
											`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
											`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
											`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`
											)
											VALUES
											('{$dress['id']}','{$us['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
											'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
											'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
											,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','0'
											);
										") or die();
	
										//new_delo
										$rec = array();
					  		    			$rec['owner']=$us[id];
										$rec['owner_login']=$us[login];
										$rec['owner_balans_do']=$us['money'];
										$rec['owner_balans_posle']=$us['money'];
										$rec['target_login']="��";
										$rec['type']=99; // ������� �������
										$rec['sum_kr']=0;
										$rec['sum_ekr']=0;
										$rec['sum_kom']=0;
										$rec['item_id']=get_item_fid(array("idcity" => $us['id_city'], "id" => mysql_insert_id()));
										$rec['item_name']=$dress[name];
										$rec['item_count']=1;
										$rec['item_type']=$dress['type'];
										$rec['item_cost']=$dress['cost'];
										$rec['item_dur']=$dress['duration'];
										$rec['item_maxdur']=$dress['maxdur'];
										$rec['item_ups']=$dress['ups'];
										$rec['item_unic']=$dress['unic'];
										$rec['item_incmagic']=$dress['includemagicname'];
										$rec['item_incmagic_count']=$dress['includemagicuses'];
										$rec['item_arsenal']='';
										$rec['item_proto']=$dress['prototype'];
										$rec['item_sowner']=($dress['sowner']>0?1:0);
										$rec['item_incmagic_id']=$dress['includemagic'];
										if (add_to_new_delo($rec) === FALSE) die();
			
										err("������� ����� ������ ".$dress['name']." <img src=\"http://i.oldbk.com/i/sh/".$dress['img']."\"><br>");
									}
								}
	
								// ����� ������� ���� ����
								if ($artinfo['type'] == "3" && $artinfo['sharped'] == "1") {
									// ��������� �������
									preg_match('~\+([\d]+)~iU',$artinfo['name'],$m);
									if (isset($m[1])) {
										// ���� �������
										// ����� - 11
										// ������ - 12
										// ������ - 1
										// ���� - 13
										$otdel = $artinfo['otdel'];
								
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
										$zz = array(6 => 9090, 7 => 190190);
		
										if ($m[1] <= 5) {
											$dress = mysql_query('SELECT * FROM oldbk.shop WHERE id = '.$z[$artinfo['otdel']][$m[1]]) or die();								
										} else {
											$dress = mysql_query('SELECT * FROM oldbk.eshop WHERE id = '.$zz[$m[1]]) or die();
										}
	
										$dress = mysql_fetch_assoc($dress);
	
										if ($dress !== FALSE) {
											mysql_query("INSERT INTO oldbk.`inventory`
												(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
												`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
												`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
												`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`
												)
												VALUES
												('{$dress['id']}','{$us['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
												'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
												'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
												,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','0'
												);
											") or die();
	
											//new_delo
											$rec = array();
						  		    			$rec['owner']=$us[id];
											$rec['owner_login']=$us[login];
											$rec['owner_balans_do']=$us['money'];
											$rec['owner_balans_posle']=$us['money'];
											$rec['target_login']="��";
											$rec['type']=99; // ������� �������
											$rec['sum_kr']=0;
											$rec['sum_ekr']=0;
											$rec['sum_kom']=0;
											$rec['item_id']=get_item_fid(array("idcity" => $us['id_city'], "id" => mysql_insert_id()));
											$rec['item_name']=$dress[name];
											$rec['item_count']=1;
											$rec['item_type']=$dress['type'];
											$rec['item_cost']=$dress['cost'];
											$rec['item_dur']=$dress['duration'];
											$rec['item_maxdur']=$dress['maxdur'];
											$rec['item_ups']=$dress['ups'];
											$rec['item_unic']=$dress['unic'];
											$rec['item_incmagic']=$dress['includemagicname'];
											$rec['item_incmagic_count']=$dress['includemagicuses'];
											$rec['item_arsenal']='';
											$rec['item_proto']=$dress['prototype'];
											$rec['item_sowner']=($dress['sowner']>0?1:0);
											$rec['item_incmagic_id']=$dress['includemagic'];
											if (add_to_new_delo($rec) === FALSE) die();
	
											err("������� ����� ������ ".$dress['name']." <img src=\"http://i.oldbk.com/i/sh/".$dress['img']."\"><br>");
										}
									}
								}
			
								$uplist = "";
								// ����� ��� ������� �������� � ����� � ����
								preg_match('~\[([\d]*)\]~iU',$artinfo['name'],$m);
								if (isset($m[1])) {
									// ���� ������
									$upslvl = array(
										7 => 6218,
										8 => 6219,
										9 => 6220,
										10 => 6221,
										11 => 6321,
									);
	
	
									$nlevel = 7;
									$artproto = mysql_query('SELECT * FROM oldbk.art_prototype WHERE id = '.$artinfo['prototype']) or die();
									$artproto = mysql_fetch_assoc($artproto);
									if ($artproto !== FALSE) {
										$nlevel = $artproto['nlevel'];
										if ($nlevel < 6) $nlevel = 6;
									}
						
	
									for ($i = $m[1]; $i > $nlevel; $i--) {
										$dress = mysql_query('SELECT * FROM oldbk.eshop WHERE id = '.$upslvl[$i]) or die();
										$dress = mysql_fetch_assoc($dress);
							
			
										if ($dress !== FALSE) {
											mysql_query("INSERT INTO oldbk.`inventory`
												(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
												`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
												`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
												`present`,`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`
												)
												VALUES
												('{$dress['id']}','{$us['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
												'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
												'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
												,'������������ �����','{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','0'
												);
											") or die();

											//new_delo
											$rec = array();
						  		    			$rec['owner']=$us[id];
											$rec['owner_login']=$us[login];
											$rec['owner_balans_do']=$us['money'];
											$rec['owner_balans_posle']=$us['money'];
											$rec['target_login']="��";
											$rec['type']=99; // ������� �������
											$rec['sum_kr']=0;
											$rec['sum_ekr']=0;
											$rec['sum_kom']=0;
											$rec['item_id']=get_item_fid(array("idcity" => $us['id_city'], "id" => mysql_insert_id()));
											$rec['item_name']=$dress[name];
											$rec['item_count']=1;
											$rec['item_type']=$dress['type'];
											$rec['item_cost']=$dress['cost'];
											$rec['item_dur']=$dress['duration'];
											$rec['item_maxdur']=$dress['maxdur'];
											$rec['item_ups']=$dress['ups'];
											$rec['item_unic']=$dress['unic'];
											$rec['item_incmagic']=$dress['includemagicname'];
											$rec['item_incmagic_count']=$dress['includemagicuses'];
											$rec['item_arsenal']='';
											$rec['item_proto']=$dress['prototype'];
											$rec['item_sowner']=($dress['sowner']>0?1:0);
											$rec['item_incmagic_id']=$dress['includemagic'];
											if (add_to_new_delo($rec) === FALSE) die();
	
											$uplist .= $dress['name']." <img src=\"http://i.oldbk.com/i/sh/".$dress['img']."\">, ";
										}
									}
								}

								if (strlen($uplist)) {
									$uplist = substr($uplist,0,strlen($uplist)-1);
									err("������� �����(�) ".$uplist."<br>");
								}
	
								echo '<br><br>';
								// �� ��, ���������
								$q = mysql_query('COMMIT') or die();
								$showform = 0;
							}
						}
					} else {
						echo '<font color=red>�������� ������ �� ������� ����� �����.</font>';
					}
				}

				if ($showform) {
					$fromart = mysql_fetch_assoc(mysql_query("select * from oldbk.inventory where owner=22125 and arsenal_klan='{$klan[short]}' and art_param!='' and id = ".intval($_GET['change'])));
					if (!$fromart) die();
					$toart = mysql_fetch_assoc(mysql_query("select * from oldbk.art_prototype where arsenal_klan='{$klan[short]}' and id != ".$fromart['prototype']." and art_status=2 and id = ".intval($_GET['tochange'])));
					if (!$toart) die();

					$color = '#C7C7C7';

					$fromart[showbill]=true;
					$fromart[ecost]=$klan_art_ecost;

					$toart[showbill]=true;
					$toart[ecost]=$klan_art_ecost;
				 	$links_bill=" ";


					echo '<table><tr><td><table>';
					showitem($fromart,0,false,$color,$links_bill);
					echo '</table></td><td> <img src="http://i.oldbk.com/i/greenarrow.png"> </td><td><table>';
					showitem($toart,0,false,$color,$links_bill);					
					echo '</table></td></tr></table><br><br>';
					echo '<b>� �������� ������� ����� ����� ������� 100��� � ���� ������ ������ ������ ��������� ���������</b><br>';
					echo '<b>�������� � ������ ���� ������������ � ��������� ���������.</b><br><br>';
					echo '<form method="POST">';
					echo '������ �� ������� ����� �����: <input name="ekr_pass" type="text"><br>';
					echo '<input type="submit" value="��������">';
					echo '</form>';
				}
			}
		}
	}
	elseif (($_GET[getclanart]) and ($klan['glava']==$user['id'] ) )
	{
		$klan_art_ecost=1000;
		// ������� ��������� ���� �����
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		echo "���� ������ �������� ����������, ������� �� ������ ��������.<br/><br/>";
		$klan_kazna=clan_kazna_have($klan['id']);	

		 if (($_GET[bill]) and ($klan_kazna))
		 {
		 //���� 
		 $billid=(int)($_GET[bill]);
		 if ($billid>0)
		 	{
			 $test_art_bill=mysql_fetch_array(mysql_query("select * from oldbk.art_prototype where arsenal_klan='{$klan[short]}' and art_status=2 and id='{$billid}' ;"));
			  if ($test_art_bill[id]>0)
			  	{
  				 //��������� �����
  				 if ($klan_kazna[ekr]>=$klan_art_ecost)
  				 	{
 		  			 //��������� ����� 
 		  			  $get_pay=by_from_kazna($klan[id],2,$klan_art_ecost,"(������� ��������� ��������� {$test_art_bill[name]}, ���� �{$billid}).");
 		  			  if ($get_pay)
 		  			  	{
 		  			  	//���������� ���
 		  			  	/////////////////////////////////////////
 		  			  	if ($test_art_bill[nlevel]>6)
					     	{
					     	$uplevel=$test_art_bill[nlevel];
					     	}
					     	else
					     	{
					     	$uplevel=6;
					     	}
		$price_item_ecost=2000;//��� ������� � ���������
		mysql_query("INSERT INTO `oldbk`.`inventory` SET 
		`name`='{$test_art_bill[name]}',
		`duration`='{$test_art_bill[duration]}',`maxdur`='{$test_art_bill[maxdur]}',`cost`='{$test_art_bill[cost]}',`owner`='{$test_art_bill[owner]}',
		`nlevel`='{$test_art_bill[nlevel]}',`nsila`='{$test_art_bill[nsila]}',`nlovk`='{$test_art_bill[nlovk]}',`ninta`='{$test_art_bill[ninta]}',`nvinos`='{$test_art_bill[nvinos]}',`nintel`='{$test_art_bill[nintel]}',
		`nmudra`='{$test_art_bill[nmudra]}',`nnoj`='{$test_art_bill[nnoj]}',`ntopor`='{$test_art_bill[ntopor]}',`ndubina`='{$test_art_bill[ndubina]}',`nmech`='{$test_art_bill[nmech]}',
		`nalign`='{$test_art_bill[nalign]}',`minu`='{$test_art_bill[minu]}',`maxu`='{$test_art_bill[maxu]}',
		`gsila`='{$test_art_bill[gsila]}',`glovk`='{$test_art_bill[glovk]}',`ginta`='{$test_art_bill[ginta]}',
		`gintel`='{$test_art_bill[gintel]}',`ghp`='{$test_art_bill[ghp]}',
		`mfkrit`='{$test_art_bill[mfkrit]}',`mfakrit`='{$test_art_bill[mfakrit]}',`mfuvorot`='{$test_art_bill[mfuvorot]}',`mfauvorot`='{$test_art_bill[mfauvorot]}',
		`gnoj`='{$test_art_bill[gnoj]}',`gtopor`='{$test_art_bill[gtopor]}',`gdubina`='{$test_art_bill[gdubina]}',`gmech`='{$test_art_bill[gmech]}',
		`img`='{$test_art_bill[img]}',`text`='',`dressed`=0,
		`bron1`='{$test_art_bill[bron1]}',`bron2`='{$test_art_bill[bron2]}',`bron3`='{$test_art_bill[bron3]}',`bron4`='{$test_art_bill[bron4]}',
		`dategoden`=0,`magic`=0,
		`type`='{$test_art_bill[type]}',
		`present`='',`sharped`=0,
		`massa`='{$test_art_bill[massa]}',
		`goden`=0,`needident`=0,
		`nfire`='{$test_art_bill[nfire]}',`nwater`='{$test_art_bill[nwater]}',`nair`='{$test_art_bill[nair]}',`nearth`='{$test_art_bill[nearth]}',`nlight`='{$test_art_bill[nlight]}',`ngray`='{$test_art_bill[ngray]}',
		`ndark`='{$test_art_bill[ndark]}',`gfire`='{$test_art_bill[gfire]}',`gwater`='{$test_art_bill[gwater]}',`gair`='{$test_art_bill[gair]}',`gearth`='{$test_art_bill[gearth]}',`glight`='{$test_art_bill[glight]}',`ggray`='{$test_art_bill[ggra]}',`gdark`='{$test_art_bill[gdark]}',
		`letter`='',`isrep`=1,`update`='',`setsale`=0,
		`prototype`='{$test_art_bill[prototype]}',
		`otdel`='{$test_art_bill[otdel]}',`bs`=0,	`gmp`='{$test_art_bill[gmp]}',
		`includemagic`=0,`includemagicdex`=0,`includemagicmax`=0,`includemagicname`='',`includemagicuses`=0,`includemagiccost`=0,`includemagicekrcost`=0,
		`gmeshok`=0,`tradesale`=0,`karman`=0,
		`stbonus`={$test_art_bill[stbonus]},`upfree`=0,`ups`=5,
		`mfbonus`={$test_art_bill[mfbonus]},`mffree`=0,
		`type3_updated`=1,`bs_owner`=0,`nsex`=0,
		`present_text`='',`add_time`=0,`labonly`=0,`labflag`=0,`prokat_idp`=0,`prokat_do`=0,
		`arsenal_klan`='{$test_art_bill[arsenal_klan]}',`arsenal_owner`='{$test_art_bill[arsenal_owner]}',
		`repcost`='{$test_art_bill[repcost]}',
		`up_level`='{$uplevel}',
		`ecost`='{$price_item_ecost}',
		`group`=0,`ekr_up`='{$test_art_bill[ekr_up]}',
		`unik`=1,
		`add_pick`='',`pick_time`=0,
		`sowner`='{$test_art_bill[sowner]}',
		`idcity`=0,`battle`=0,`t_id`=0,
		`ab_mf`='{$test_art_bill[ab_mf]}',`ab_bron`='{$test_art_bill[ab_bron]}',`ab_uron`='{$test_art_bill[ab_uron]}',
		`art_param` ='{$test_art_bill[art_param]}' ;");
	  	////////////////////////////////////////
					  	 if (mysql_affected_rows()>0)
					  	{
	  			  		//����� � ��� ��������!
	  			  		//����� � ���. ��������+���
					  	$inserted_id=mysql_insert_id();
						mysql_query("INSERT INTO oldbk.clans_arsenal (id_inventory, klan_name, owner_original, gift) VALUES  ('{$inserted_id}','{$test_art_bill[arsenal_klan]}','1','0')");
						$log_text = '�������� � ������� �������� �������� "'.$test_art_bill[name].'"  ['.$test_art_bill[duration].'/'.$test_art_bill[maxdur].'] [ups:'.$test_art_bill['ups'].'/unik:'.$test_art_bill['unik'].'/inc:'.$test_art_bill['includemagicname'].']';
						mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$test_art_bill[arsenal_klan]}','1','{$log_text}','".time()."')");				
 		  			  	err("�� �������� �������� ��������: <b>{$test_art_bill[name]}</b>. ");
 		  			  	}
 		  			  	
 		  			  	
 		  			  	$klan_kazna[ekr]-=$klan_art_ecost;
 		  			  	}
  				 	}
  				 	else
  				 	{
  				 	err('� �������� ����� ��������� �������!');
  				 	}

			  	}
			  	else
			  	{
				 err("�� ������ ����� �����!");			  	
			  	}
			 
			 }
			 else
			 {
			 err("�� ������ ����� �����!");
			 }
		 
		 }
		
		if ($klan_kazna) { echo "<br>� ����� �����:<font color=green><b>{$klan_kazna[ekr]} ���.</b></font>" ; }		
		echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
		$data = mysql_query("select * from oldbk.art_prototype where arsenal_klan='{$klan[short]}' and art_status=2");			
		while($row = mysql_fetch_array($data)) 
		{
		 $color = '#C7C7C7';
		 $row[ecost]=$klan_art_ecost;
		 $row[showbill]=true;
		 	
		 	if ($klan_kazna)
		 	{
		 	$links_bill="<a href=klan_arsenal.php?getclanart=1&bill={$row[id]}>��������</a>";
		 	}
		 	else
		 	{
		 	$links_bill="��� ����� �����";
		 	}
		 
			showitem($row,0,false,$color,$links_bill);
		}
		echo '</TABLE>';
	
	}
*/
	elseif (($_GET[giveclanart]) and ($klan['glava']==$user['id']))	
	{
	/*
		$klan_kazna=clan_kazna_have($klan['id']);		
		if (((int)($_GET[bill])>0) AND $klan_kazna) {
			$it=(int)($_GET[bill]);
			$item =mysql_fetch_array(mysql_query("SELECT * FROM  oldbk.`inventory` WHERE id='{$it}' and owner=22125  and arsenal_klan='{$user[klan]}' AND arsenal_owner='1'  and (art_param !='' OR  ab_mf>0 OR  ab_bron>0 OR ab_uron>0 ) ; "));
			if ($item[id]>0 && $item['duration'] == 0) {
				if ($item[art_param]!='') {
					$cost=500;
				} else {
					$cost=round(($item[ecost]*0.3),2);
				}

				if ($item['prototype'] == "260" || $item['prototype'] == "262" || $item['prototype'] == "2000" || $item['prototype'] == "2001" || $item['prototype'] == "2002" || $item['prototype'] == "2003" || $item['prototype'] == "283" || $item['prototype'] == "284") {
					mysql_query("DELETE FROM  oldbk.`inventory` WHERE id='{$it}' LIMIT 1;");
					if (mysql_affected_rows()>0) {
						$nodelo=true;
						if (put_to_kazna($klan['id'],2,$cost,'',false,"������� ��������� ��������� {$item[name]}")) {
							mysql_query("DELETE FROM oldbk.clans_arsenal  where id_inventory='{$item[id]}' LIMIT 1 ;");
							mysql_query('DELETE from clans_arsenal_access where item='.$item['id']);
							$log_text = '������ �� �������� ����� �������� "'.$item[name].'"  ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].'] �� <b>'.$cost.' ���.</b>';
							mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$item[arsenal_klan]}','1','{$log_text}','".time()."')");				
							err("�� ������� �������� ��������: <b>{$item[name]}</b> �� {$cost} ���. � ����� �����!");
							$klan_kazna[ekr]+=$cost;
						}
					}
				} else {
					if (isset($_POST['iagree'])) {
						$who = check_users_city_datal($_POST['whologin']);
						if ($who) {
							if ($who['klan'] == $user['klan']) {
								mysql_query("DELETE FROM  oldbk.`inventory` WHERE id='{$it}' LIMIT 1;");
								mysql_query('DELETE from clans_arsenal_access where item='.$item['id']);
								mysql_query("DELETE FROM oldbk.clans_arsenal  where id_inventory='{$item[id]}' LIMIT 1 ;");
								$log_text = '������ �� �������� ����� �������� "'.$item[name].'"  ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].'] �� ������� ��������� <b>'.$who['login'].'</b>!.';
								mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$item[arsenal_klan]}','1','{$log_text}','".time()."')");
								err("�� ������� �������� ��������: <b>{$item[name]}</b> �� ������� ��������� <b>".$who['login']."</b>!");

								$us = $who;
								$dress = mysql_query('SELECT * FROM oldbk.shop WHERE id = 3005000') or die();
								$dress = mysql_fetch_assoc($dress);
								if ($dress !== FALSE) {
									mysql_query("INSERT INTO oldbk.`inventory`
										(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`ecost`,`img`,`maxdur`,`isrep`,
										`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
										`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,
										`otdel`,`gmp`,`gmeshok`, `group`,`letter`, `ab_mf`,`ab_bron`,`ab_uron`,`sowner`,`present`
										)
										VALUES
										('{$dress['id']}','{$us['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},{$dress['ecost']},'{$dress['img']}',{$dress['maxdur']},{$dress['isrep']},'{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
										'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}',
										'{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}'
										,'{$dress['razdel']}','{$dress['gmp']}','{$dress['gmeshok']}','{$dress['group']}','{$dress['letter']}','{$dress['ab_mf']}','{$dress['ab_bron']}','{$dress['ab_uron']}','0','������������ �����'
									);
									") or die();

									//new_delo
									$rec = array();
				  		    			$rec['owner']=$us[id];
									$rec['owner_login']=$us[login];
									$rec['owner_balans_do']=$us['money'];
									$rec['owner_balans_posle']=$us['money'];
									$rec['target_login']=$user['login'];
									$rec['type']=99; // ������� �������
									$rec['sum_kr']=0;
									$rec['sum_ekr']=0;
									$rec['sum_kom']=0;
									$rec['item_id']=get_item_fid(array("idcity" => $us['id_city'], "id" => mysql_insert_id()));
									$rec['item_name']=$dress[name];
									$rec['item_count']=1;
									$rec['item_type']=$dress['type'];
									$rec['item_cost']=$dress['cost'];
									$rec['item_dur']=$dress['duration'];
									$rec['item_maxdur']=$dress['maxdur'];
									$rec['item_ups']=$dress['ups'];
									$rec['item_unic']=$dress['unic'];
									$rec['item_incmagic']=$dress['includemagicname'];
									$rec['item_incmagic_count']=$dress['includemagicuses'];
									$rec['item_arsenal']='';
									$rec['item_proto']=$dress['prototype'];
									$rec['item_sowner']=($dress['sowner']>0?1:0);
									$rec['item_incmagic_id']=$dress['includemagic'];
									if (add_to_new_delo($rec) === FALSE) die();

									$text = "�������� \"".$user['login']."\" ����� ��� \"�������\" �� ������ ��������";

									if ($us['odate'] > (time()-60)) {
										addchp('<font color=red>��������!</font> '.mysql_real_escape_string($text).'.','{[]}'.$us['login'].'{[]}',$us['room'],$us['id_city']);
									} else {
										mysql_query("INSERT INTO oldbk.`telegraph` (`owner`,`date`,`text`) values ('".$us['id']."','','<font color=red>��������!</font> ".mysql_real_escape_string($text).".');");
									}

								}
							} else {
								err("�������� �� � ����� �����");
							}
						} else {
							err("�������� �� ������");
						}
					} else {
						err("�� ������ ������� ������� �������");
					}
				}
			}
		}
		
		

		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		echo "���� ������ �������� ����������, ������� �� ������ �������.<br/><br/>";
		if ($klan_kazna) { echo "<br>� ����� �����:<font color=green><b>{$klan_kazna[ekr]} ���.</b></font>" ; }		
		echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';		
		$data = mysql_query("SELECT * FROM  oldbk.`inventory` WHERE owner=22125  and arsenal_klan='{$user[klan]}' AND arsenal_owner='1'  and (art_param !='' OR  ab_mf>0 OR  ab_bron>0 OR ab_uron>0 ) ORDER by `update` DESC; ");			
			while($row = mysql_fetch_array($data)) 
			{
			
				$color = '#C7C7C7';
				
				if ($row[art_param]!='')
				{
				$cost=500;
				}
				else
				{
				$cost=round(($row[ecost]*0.3),2);
				}

		 	
		 	if ($klan_kazna)
		 	{

				if ($row['prototype'] == "260" || $row['prototype'] == "262" || $row['prototype'] == "2000" || $row['prototype'] == "2001" || $row['prototype'] == "2002" || $row['prototype'] == "2003" || $row['prototype'] == "283" || $row['prototype'] == "284") {
				 	$links_bill="<a href=klan_arsenal.php?giveclanart=1&bill={$row[id]}>������� �� {$cost} ���</a>";
				} else {
					if ($row['duration'] > 0) {
				 		$links_bill='<a href="#" OnClick="alert(\'���������� ��������� ��������!\');">����� �� �������</a>';
					} else {
				 		$links_bill='<a href="#" OnClick="findlogin(\'����� �� �������\',\'klan_arsenal.php?giveclanart=1&bill='.$row['id'].'\',\'whologin\');">����� �� �������</a>';
					}
				}
		 	}
		 	else
		 	{
		 	$links_bill="��� ����� �����";
		 	}
			
			showitem($row,0,false,$color,$links_bill);
			}
		echo '</TABLE>';
	*/		
	}
	elseif ($_GET['my'] == 1) {
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		// ����� ����� �� ��������
			echo "���� ������ �����, ������� ����� ��. �� ������ ������� �������������� ���� �����, ���� ������������� ������� ���� ���� � ��������� ������� �� ����������.<br/><br/>";
			echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
			$data = mysql_query("SELECT * FROM  oldbk.`inventory` WHERE arsenal_klan='{$user[klan]}' AND arsenal_owner='{$user[id]}' ORDER by `update` DESC; ");			
			while($row = mysql_fetch_array($data)) {
			 if ($row[owner]!=22125) { $row[owner_current]=$row[owner]; } else { $row[owner_current]=0; }
			$row[id_ars]=$row[id];
			
             	if($row[otdel]==7 || $row[otdel]==71|| $row[otdel]==72|| $row[otdel]==73)
				{
					$inv_shmot[0][0][$row[otdel]][]=$row;
				}
				else //���� ��� ���������� - �� �� �� ���������
				{
					$inv_shmot[0][0][$row[prototype]][]=$row;
				}
		  		$inv_gr_key[$row[prototype]]=0;
		 		$count++;
			}

			foreach ($inv_shmot as $key2 => $value2)
				{
				  foreach ($value2 as $key => $value)
					 {
					      foreach ($value as $key1 => $value1)
						{
		                   //��� ���� �������� ���������� �� �������, ���� ����������� ���������..
		                         $div_group=0;
		                         echo '<tr><td>';
							    if($inv_gr_key[$key1]==1)
							    {
					      			$group_key=1;
								}
								else
								{
						        	$group_key=count($value1);
								}
								for($i=0;$i<$group_key;$i++)
								{
					                $showed=0;
				                    
                                    $value1[$i][chk_arsenal]=2;    //0-�� ����� ����������� ���. 1 ��� ������ � "����� �� ��������"  2-��� ���� �������. 3-��� ���� ��������

					               // if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								    $color = '#C7C7C7';
								    $value1[$i]['inv']=1;
									if($value1[$i]['group']==1)
									{
					                   $value1[$i]['group_by']=1;
									}

									if($inv_gr_key[$key1]==1)
								    {
								    	$value1[$i]['count'] =  count($value1);
										echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
										showitem($value1[$i],0,false,$color,'');
										echo '</table>';
										$showed=1;
								    }
									else
									{
										$value1[$i]['count'] = 1;

												if($group_key>1 && $i==0){
													$div_group=1;
													echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
                                      				showitem($value1[$i],0,false,$color,'');
													echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
													echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a></div>";
													echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div>
													</td></tr>";
				                                	echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
													$showed=1;
												}
									}
									if($showed==0)
								    {
			                              	echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
											showitem($value1[$i],0,false,$color,'');
											echo "</table>";
			         				}
					              if($i==($group_key-1) && $div_group==1)
		                            {
		                            	echo '</div>';
		                            }

								}
		                       echo '</td></tr>';
						}
			        }
			     }
			echo '</TABLE>';
	}
	elseif (($_GET['back'] == 1) and (($klan['glava']==$user['id'] OR $polno[$user['id']][5] == 1) ))  {
	$klan_ars_back=1;
	
		if ($_GET[item])
		 {
		 $it_id=(int)($_GET[item]);
		 // ��������
		// ���� �������
		  $it=mysql_fetch_array(mysql_query("SELECT * FROM  oldbk.`inventory` WHERE id='{$it_id}' and arsenal_klan='{$user[klan]}' AND owner!=22125 and arsenal_owner=1;"));
		  if ($it[id]>0)
		  {
		//���� ���� 
		  $telo=check_users_city_data($it[owner]);
		  
		  if ($telo['id']==445)
		       {
		       	err("������� ��������� �� ��������!");
		       }
		     else  
		    if ($telo[battle] > 0)
		       {
		       	err("���������� � ���, ���������� ����� ���!");
		       }
			elseif($telo['in_tower'] ==1) 
			{
			echo "<b><font color=red>�������� ''{$telo['login']}'' ������ � ����� ������. ���������.</font></b><br/><br/>";
			}
			elseif($telo['in_tower'] > 1) 
			{
			echo "<b><font color=red>�������� ''{$telo['login']}'' ������ � ������. ���������.</font></b><br/><br/>";
			}
			elseif( ($telo['room']>=197 and $telo['room']<=199) or ($telo['room']>=211 and $telo['room']<240) or ($telo['room']>240 and $telo['room']<270) or ($telo['room']>270 and $telo['room']<290) )
			{
			echo "<b><font color=red>�������� ''{$telo['login']}'' ������ � ���������. ���������.</font></b><br/><br/>";
			}
		       else
		       {
		       
		         if ($it[dressed] > 0 )
		            {
		            // ������� ���� ���� ��� �����
		            	undressall($telo[id],$telo['id_city']);
		            // ���� ����
		            }
		            //��������� ������� � �������
		            	if($it['add_pick']!='')
				{
					undress_img($it);
				}
				$sql_return="update oldbk.inventory set owner='22125', arsenal_klan='{$user[klan]}', present='',  `letter`='' , `prokat_do`=''  where id='{$it[id]}' and  bs_owner=0 and dressed=0 and owner='{$telo['id']}'";		            
				mysql_query($sql_return);
				if(mysql_affected_rows()>0)
				       {
						// ���������� ���� � ��������� ������������ ���������
						$log_text = '"'.$user[login].'" ����� �� "'.$telo[login].'" � ������� "'.$it[name].'"'.$ttt.' ['.$it[duration].'/'.$it[maxdur].'] [ups:'.$it['ups'].'/unik:'.$it['unik'].'/inc:'.$it['includemagicname'].']';
						$delo_text = '"'.$user[login].'" ����� �� "'.$telo[login].'" � ������� ����� "'.$user[klan].'" "'.$it[name].'" id:('.get_item_fid($it).') ['.$it[duration].'/'.$it[maxdur].'] [ups:'.$it['ups'].'/unik:'.$it['unik'].'/inc:'.$it['includemagicname'].']';
						// ������ ��
						$item_idd=$it[id];
						mysql_query("UPDATE oldbk.clans_arsenal SET owner_current='0' WHERE id_inventory='{$item_idd}'");
						
										 //new_delo
	  		    			$rec['owner']=$telo[id]; 
						$rec['owner_login']=$telo[login];
						$rec['owner_balans_do']=$telo[money];
						$rec['owner_balans_posle']=$telo[money];
						$rec['target']=22125;
						$rec['target_login']='�������';
						$rec['type']=66;//������ � ���� ��������
						$rec['sum_kr']=0;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=get_item_fid($it);
						$rec['item_name']=$it['name'];
						$rec['item_count']=1;
						$rec['item_type']=$it['type'];
						$rec['item_cost']=$it['cost'];
						$rec['item_dur']=$it['duration'];
						$rec['item_maxdur']=$it['maxdur'];
						$rec['item_ups']=$it['ups'];
						$rec['item_unic']=$it['unic'];
						$rec['item_incmagic']=$it['includemagicname'];
						$rec['item_incmagic_count']=$it['includemagicuses'];
						$rec['item_arsenal']=$user[klan];
						$rec['add_info']=$user['login'];
						add_to_new_delo($rec); 
								
						if (olddelo==1)
						{
							mysql_query("INSERT INTO oldbk.delo (pers,text,type,date) VALUES ('{$telo[id]}','{$delo_text}',1,'".time()."')");
						}
						mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
						addchp('<font color=red>��������!</font> � ��� ����� ������� '.$it[name].' � �������� �������!','{[]}'.$telo['login'].'{[]}');						
						echo "<b><font color=red>�� ������ {$it[name]} � ������� �����</font></b><br/><br/>";
					}				
				
		            

		       }
		  }
		 
		 }
	
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		// ����� ����� �� ��������
			echo "���� ������ ����� �������� �� ����� �����, ������� ��������� � ��������. �� ������ ������� �� ���� ��� �� � ���!<br/><br/>";
			echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
			// ��� ���� ����������� �������� ��� ����� ����
			$data = mysql_query("SELECT * FROM  oldbk.`inventory` WHERE arsenal_klan='{$user[klan]}' AND owner!=22125 AND arsenal_owner=1 ORDER by `update` DESC; ");
			while($row = mysql_fetch_array($data)) {
             	if($row[otdel]==7 || $row[otdel]==71|| $row[otdel]==72|| $row[otdel]==73)
				{
					$inv_shmot[0][0][$row[otdel]][]=$row;
				}
				else //���� ��� ���������� - �� �� �� ���������
				{
					$inv_shmot[0][0][$row[prototype]][]=$row;
				}
		  		$inv_gr_key[$row[prototype]]=0;
		 		$count++;
			}

			foreach ($inv_shmot as $key2 => $value2)
				{
				  foreach ($value2 as $key => $value)
					 {
					      foreach ($value as $key1 => $value1)
						{
		                   //��� ���� �������� ���������� �� �������, ���� ����������� ���������..
		                         $div_group=0;
		                         echo '<tr><td>';
							    if($inv_gr_key[$key1]==1)
							    {
					      			$group_key=1;
								}
								else
								{
						        	$group_key=count($value1);
								}
								for($i=0;$i<$group_key;$i++)
								{
					                $showed=0;
                                    $value1[$i][chk_arsenal]=5;    //0-�� ����� ����������� ���. 1 ��� ������ � "����� �� ��������"  2-��� ���� �������. 3-��� ���� �������� 4-�������  5-������ ������� ��� ������ � ����

					               // if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								    $color = '#C7C7C7';
								    $value1[$i]['inv']=1;
									if($value1[$i]['group']==1)
									{
					                   $value1[$i]['group_by']=1;
									}

									if($inv_gr_key[$key1]==1)
								    {
								    	$value1[$i]['count'] =  count($value1);
										echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";

										showitem($value1[$i],0,false,$color,'');
										echo '</table>';
										$showed=1;
								    }
									else
									{
										$value1[$i]['count'] = 1;

												if($group_key>1 && $i==0){
													$div_group=1;
													echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
													
                                      				showitem($value1[$i],0,false,$color,'');
													echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
													echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a></div>";
													echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div>
													</td></tr>";
				                                	echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
													$showed=1;
												}
									}
									if($showed==0)
								    {
			                              	echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";

											showitem($value1[$i],0,false,$color,'');
											echo "</table>";
			         				}
					              if($i==($group_key-1) && $div_group==1)
		                            {
		                            	echo '</div>';
		                            }

								}
		                       echo '</td></tr>';
						}
			        }
			     }
			echo '</TABLE>';
	}
	elseif ($_GET['return'] == 1) {
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';

		if($_GET['item']) {
			
				$item = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory WHERE id='".(int)$_GET['item']."' and dressed=0"));

				if($item['owner'] == $user['id'] && $item['arsenal_klan'] == $user['klan']) {
				
				if($item[add_pick]!='')
			        {
			         	undress_img($item);
			        }
				
				//����������� ���� 
				// 
					
						//��� ��� ���������� ��������� � ���� ��� ������ :)
						$sql_return="update oldbk.inventory set owner='22125', arsenal_klan='{$user[klan]}', present='',  `letter`='' , `prokat_do`=''  where id='{$item[id]}' and  bs_owner=0 and dressed=0 and owner='{$user['id']}'";
						
				
				
					if(mysql_query($sql_return)) {
						// ���������� ���� � ��������� ������������ ���������


						$log_text = '"'.$user[login].'" ������ � ������� "'.$item[name].'"'.$ttt.' ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].']';
						$delo_text = '"'.$user[login].'" ������ � ������� ����� "'.$user[klan].'" "'.$item[name].'"'.$ttt.' id:('.get_item_fid($item).') ['.$item[duration].'/'.$item[maxdur].'] [ups:'.$item['ups'].'/unik:'.$item['unik'].'/inc:'.$item['includemagicname'].']';


						// ������ ��
						$item_idd=$item[id];
						
						mysql_query("UPDATE oldbk.clans_arsenal SET owner_current='0' WHERE id_inventory='{$item_idd}'");
						
						
						 //new_delo
			    			$rec['owner']=$user[id]; 
						$rec['owner_login']=$user[login];
						$rec['owner_balans_do']=$user[money];
						$rec['owner_balans_posle']=$user[money];
						$rec['target']=22125;
						$rec['target_login']='�������';
						$rec['type']=67;//������ �������� ����
						$rec['sum_kr']=0;
						$rec['sum_ekr']=0;
						$rec['sum_kom']=0;
						$rec['item_id']=get_item_fid($item);
						$rec['item_name']=$item['name'];
						$rec['item_count']=1;
						$rec['item_type']=$item['type'];
						$rec['item_cost']=$item['cost'];
						$rec['item_dur']=$item['duration'];
						$rec['item_maxdur']=$item['maxdur'];
						$rec['item_ups']=$item['ups'];
						$rec['item_unic']=$item['unic'];
						$rec['item_incmagic']=$item['includemagicname'];
						$rec['item_incmagic_count']=$item['includemagicuses'];
						$rec['item_arsenal']=$user[klan];
						add_to_new_delo($rec); 						
						if (olddelo==1)
						{
						mysql_query("INSERT INTO oldbk.delo (pers,text,type,date) VALUES ('{$user[id]}','{$delo_text}',1,'".time()."')");
						}
						
						mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
						echo "<b><font color=red>�� ������� {$item[name]} � ������� �����</font></b><br/><br/>";
					}
				}
			
		}
		// ����� ����� �� ��������
			echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
			$data = mysql_query("SELECT * FROM oldbk.`inventory` WHERE arsenal_klan='{$user[klan]}' AND owner='{$user['id']}' AND dressed='0' ORDER by `update` DESC; ");
			while($row = mysql_fetch_array($data)) {
							if($row[otdel]==7 || $row[otdel]==71|| $row[otdel]==72|| $row[otdel]==73)
							{
								$inv_shmot[0][0][$row[otdel]][]=$row;
							}
							else //���� ��� ���������� - �� �� �� ���������
							{
								$inv_shmot[0][0][$row[prototype]][]=$row;
							}
					  		$inv_gr_key[$row[prototype]]=0;
					 		$count++;
					 		$have_items=1;
			}
			foreach ($inv_shmot as $key2 => $value2)
				{
				  foreach ($value2 as $key => $value)
					 {
					      foreach ($value as $key1 => $value1)
						{
		                   //��� ���� �������� ���������� �� �������, ���� ����������� ���������..
		                         $div_group=0;
		                         echo '<tr><td>';
							    if($inv_gr_key[$key1]==1)
							    {
					      			$group_key=1;
								}
								else
								{
						        	$group_key=count($value1);
								}
								for($i=0;$i<$group_key;$i++)
								{
					                $showed=0;
                                    $value1[$i][chk_arsenal]=4;    //0-�� ����� ����������� ���. 1 ��� ������ � "����� �� ��������"  2-��� ���� �������. 3-��� ���� ��������. 4 ������� ��� ����

					               // if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								    $color = '#C7C7C7';
								    $value1[$i]['inv']=1;
									if($value1[$i]['group']==1)
									{
					                   $value1[$i]['group_by']=1;
									}

									if($inv_gr_key[$key1]==1)
								    {
								    	$value1[$i]['count'] =  count($value1);
										echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
										showitem($value1[$i],0,false,$color,'');
										echo '</table>';
										$showed=1;
								    }
									else
									{
										$value1[$i]['count'] = 1;

												if($group_key>1 && $i==0){
													$div_group=1;
													echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
                                      				showitem($value1[$i],0,false,$color,'');
													echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
													echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a></div>";
													echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div>
													</td></tr>";
				                                	echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
													$showed=1;
												}
									}
									if($showed==0)
								    {
			                              	echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
											showitem($value1[$i],0,false,$color,'');
											echo "</table>";
			         				}
					              if($i==($group_key-1) && $div_group==1)
		                            {
		                            	echo '</div>';
		                            }

								}
		                       echo '</td></tr>';
						}
			        }
			     }
			echo '</TABLE>';

			if($have_items != 1) {
				echo "<p><font color=red>�� �� ����� �� ����� ���� �� ��������, ���������� ������ :-)</font></p>";
			}
	} elseif ($_GET['magicpages'] == 1) {
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		echo "����� ��� ���� ������ ���� �������� ���������� ����<br><br>";

		$data = mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access FROM  oldbk.`inventory` i WHERE i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner!='{$user[id]}' and i.type = 300 ORDER by i.prototype ASC, i.`update` DESC; ");
		$nofound = true;	
		$cexists = array();
		if (mysql_num_rows($data)>0) {
			$nofound = false;
			while($row = mysql_fetch_array($data)) {
				//��������� �������
				$row[owner_original]=$row[arsenal_owner];
				$row[id_ars]=$row[id];
				$inv_shmot[$row[prototype]][]=$row;
		 		$count++;
				$color = floor(($row['prototype'] - 3003100) / 5);
				$cexists[$color]++;
			}
		}
			
		echo '<TABLE>';
		foreach ($inv_shmot as $key1 => $value1) {
			$div_group=0;
			echo '<tr><td>';

			$group_key=count($value1);

			for($i=0;$i<$group_key;$i++) {
				$showed=0;
				$value1[$i][chk_arsenal]=55;
				$color = '#C7C7C7';
				$value1[$i]['inv']=1;

				if($value1[$i]['group']==1) {
					$value1[$i]['group_by']=1;
				}

				$value1[$i]['count'] = 1;

				if($group_key > 1 && $i==0) {
					$div_group=1;
					echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
					showitem($value1[$i],0,false,$color,'');
					echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
					echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
					echo "<a href=#".$value1[$i]['prototype']." onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a></div>";
					echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
					echo "<a href=#".$value1[$i]['prototype']." onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div></td></tr>";
					echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
					$showed=1;
				}

				if($showed==0) {
					echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
					showitem($value1[$i],0,false,$color,'');
					echo "</table>";
				}

				if($i==($group_key-1) && $div_group==1) {
					echo '</div>';
				}

			}
			echo '</td></tr>';
		}

		if ($nofound) echo '<tr><td><b>� ������ ����� ��� ������� ���������� ����</b></td></tr>';
		echo '</TABLE>';
	} elseif (isset($_GET['usebook'])) {
		if ($polno[$user['id']][11] == 1) {
			$data = mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access FROM  oldbk.`inventory` i WHERE i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner!='{$user[id]}' and i.type = 301 AND id = ".intval($_GET['usebook']));
			if ($data !== FALSE) {
				$item = mysql_fetch_assoc($data);
				$sbet = false;
				switch($item['prototype']) {
					case 3003131:
						if ($user['battle'] > 0) 
						{
						echo '�� � ���...';
						} else
						{
						// �������
							require_once('./magic/baff_792.php');
							$log_text = "\"".$user['login']."\" ����������� ������ ����� id:(".get_item_fid($item).")";
							if ($sbet) mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
						}
					break;
					case 3003132:
						// �������
						if ($user['battle'] > 0) 
						{
						echo '�� � ���...';
						} else
						{
							require_once('./magic/baff_791.php');
							$log_text = "\"".$user['login']."\" ����������� ������� ����� id:(".get_item_fid($item).")";
							if ($sbet) mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
						}
					break;
					case 3003133:
						// �����
						if ($user['battle'] > 0) 
						{
						echo '�� � ���...';
						} else
						{
							require_once('./magic/baff_793.php'); 
							$log_text = "\"".$user['login']."\" ����������� Ƹ���� ����� id:(".get_item_fid($item).")";
							if ($sbet) mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
						}
					break;
					case 3003134:
						// �����
						require_once('./magic/baff_795.php');
						$log_text = "\"".$user['login']."\" ����������� ����� ����� id:(".get_item_fid($item).")";
						if ($sbet) mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");

					break;
					case 3003135:
						// ������
						require_once('./magic/baff_794.php');
						$log_text = "\"".$user['login']."\" ����������� ׸���� ����� id:(".get_item_fid($item).")";
						if ($sbet) mysql_query("INSERT INTO oldbk.clans_arsenal_log (klan,pers,text,date) VALUES ('{$user[klan]}','{$user[id]}','{$log_text}','".time()."')");
					break;
				}
				if ($sbet) {
					if ($item['duration'] + 1 >= $item['maxdur']) {
						mysql_query("DELETE FROM oldbk.`inventory` WHERE `id` = ".intval($_GET['usebook']));
					} else {
						mysql_query("UPDATE oldbk.`inventory` SET `duration` = `duration` + 1 WHERE `id` = ".intval($_GET['usebook']));
					}
				}
			}
		}
	} elseif ($_GET['magicbooks'] == 1) {
		echo '<TABLE>';
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		echo "����� ��� ���� ������ ���� ���������� �����, ������� �� ������ ������������, ���� ����� ����� ��� ��� ������.<br><br>";

		if ($polno[$user['id']][11] == 1) {
			$data = mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access FROM  oldbk.`inventory` i WHERE i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner!='{$user[id]}' and i.type = 301 ORDER by i.prototype ASC, i.`update` DESC; ");
		} else {
			$data = arraY();
		}
		$nofound = true;	
		$cexists = array();
		if (mysql_num_rows($data)>0) {
			$nofound = false;
			while($row = mysql_fetch_array($data)) {
				//��������� �������
				$row[owner_original]=$row[arsenal_owner];
				$row[id_ars]=$row[id];
				$inv_shmot[$row[prototype]][]=$row;
		 		$count++;
				$color = floor(($row['prototype'] - 3003100) / 5);
				$cexists[$color]++;
			}
		}
			
		echo '<TABLE>';
		foreach ($inv_shmot as $key1 => $value1) {
			$div_group=0;
			echo '<tr><td>';

			$group_key=count($value1);

			for($i=0;$i<$group_key;$i++) {
				$showed=0;
				$value1[$i][chk_arsenal]=$value1[$i]['prototype'];
				$color = '#C7C7C7';
				$value1[$i]['inv']=1;

				if($value1[$i]['group']==1) {
					$value1[$i]['group_by']=1;
				}

				$value1[$i]['count'] = 1;

				if($group_key > 1 && $i==0) {
					$div_group=1;
					echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
					showitem($value1[$i],0,false,$color,'');
					echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
					echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
					echo "<a href=#".$value1[$i]['prototype']." onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a></div>";
					echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
					echo "<a href=#".$value1[$i]['prototype']." onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div></td></tr>";
					echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
					$showed=1;
				}

				if($showed==0) {
					echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
					showitem($value1[$i],0,false,$color,'');
					echo "</table>";
				}

				if($i==($group_key-1) && $div_group==1) {
					echo '</div>';
				}

			}
			echo '</td></tr>';
		}

		if ($nofound) echo '<tr><td><b>� ������ ����� ��� ���������� ���� ��� � ��� ��� � ��� �������.</b></td></tr>';
		echo '</TABLE>';
	} else {
	
		echo '<center>
		<table><tr valign=top><td align=center>
		<fieldset style="width:400px; height:155px;" ><legend align=center><b>����:</b></legend>
		<a href="klan_arsenal.php?put=1"><img src="http://i.oldbk.com/i/ars/ars_give.png" title="����� ����"></a>&nbsp;&nbsp;&nbsp;
		<a href="klan_arsenal.php?my=1"><img src="http://i.oldbk.com/i/ars/ars_myself.png" title="��� ����"></a><br>		
		<a href="klan_arsenal.php?return=1"><img src="http://i.oldbk.com/i/ars/ars_return.png" title="������� ����"></a>&nbsp;&nbsp;&nbsp;
		';// <a href="klan_arsenal.php?mybox=1"><img src="http://i.oldbk.com/i/ars/ars_box.png" title="������ ������"></a><br>
		if (($klan['glava']==$user['id'] OR $polno[$user['id']][5] == 1) )
		  {
		  echo ' <a href="klan_arsenal.php?back=1"><img src="http://i.oldbk.com/i/ars/ars_confiscate.png" title="������ ����"></a>';
		  }
		echo '</fieldset></td><td>&nbsp;&nbsp;</td>';
		
		
		
		echo '<td><fieldset  style="width:200px; height:105px;"><legend align=center><b>�����:</b></legend><center>	
		 <a href="klan_arsenal.php?magicpages=1"><img src="http://i.oldbk.com/i/ars/ars_pages.png" title="�������� ���������� ����"></a><br>
		 <a href="klan_arsenal.php?magicbooks=1"><img src="http://i.oldbk.com/i/ars/ars_book.png" title="���������� �����"></a></center>
		 </fieldset></td><td>&nbsp;&nbsp;</td>';
		

		echo '<td><fieldset style="width:200px; height:105px;"><legend align=center><b>������:</b></legend><center>';

		//�������� ������ �����!
		if ($klan['glava']==$user['id'] )
		{
		//� �����
			//echo '<a href="klan_arsenal.php?giveclanart=1"><img src="http://i.oldbk.com/i/ars/ars_give_art.png" title="������� �������� ��������"></a><br>';
		//��������� ����
			$get_myclan_arts=mysql_fetch_array(mysql_query("select count(*) from oldbk.art_prototype where arsenal_klan='{$klan[short]}' and art_status=2"));
			if ($get_myclan_arts[0]>0)
			{
			/*
			echo '
			<a href="klan_arsenal.php?getclanart=1"><img src="http://i.oldbk.com/i/ars/ars_pay_art.png" title="�������� �������� ��������"></a><br> 
			<a href="klan_arsenal.php?changeclanart=1"><img src="http://i.oldbk.com/i/ars/ars_replace_art.png" title="�������� �������� ��������"></a>&nbsp;&nbsp;&nbsp;';			
			*/
			}
		}
		
		echo ' <a href="klan_arsenal.php?log=1"><img src="http://i.oldbk.com/i/ars/ars_log.png" title="���������� ���"></a>';
		echo '</center></fieldset></td>';		 	


		



		echo '</tr></table>
		 </center>
		<br/>';
		

		
		// ����� ����� �� ��������
		echo "����� ���������� ����� �������� � �������� ������� <b>�� ����� 5 �����</b><br>
		����� ���������� ����� ����� �� ��������� �������� <b>�� ����� 5 ����� �� ���� �� ����� ������ (7 ����)</b>. 
		<br>����� ������ ���� ������������� �������� � �������, ����� ����, ��� �������, ���� ����� ����� �����.<br>
��������, ���������� ���� ���� � �������, ����� ������� �� ���� �������, ���� ���� �� � ������� ����������. <br>
		���� ���� ����������� ����� (������� ����� �������� �����), ������� �� � ������� ����� ����� ����� ���� ���������� �������� ��� �� ��� ������. <br><br> ";	
			echo "������������ ������ ���� ������� ������� ������� ����� � �������� �� ���� �����. <br/>���� ���� � �������� ����� ���������� ������� ''��� ����''";			
			$_GET['only_magic'] = (int)$_GET['only_magic']; $_GET['only_items'] = (int)$_GET['only_items'];
			echo '<br/><br/>
			<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">
			
		<TR>
			<TD>
			<TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 0) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=0">&nbsp;������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 1) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=1">&nbsp;��������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 2) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=2">&nbsp;������</A></TD>				
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 3) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=3">&nbsp;������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 4) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=4">&nbsp;������ �����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 5) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=5">&nbsp;������� �����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 6) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=6">&nbsp;�����</A></TD>				
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 7) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=7">&nbsp;�����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 8) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=8">&nbsp;��������</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 9) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=9">&nbsp;����</A></TD>
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 10) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=10">&nbsp;������</A></TD>				
				<TD align=center bgcolor="'.(($_SESSION['ars_razdel'] === 11) ? "#A5A5A5":"#C7C7C7").'"><A HREF="?ars_razdel=11">&nbsp;��������</A></TD>								

				</TR>
			</TABLE>
			</TD>
		</TR>
			
			';

			
			// ��� ������ ����� - ������� �������� ���
			//$data = mysql_query("SELECT * FROM  oldbk.`inventory` WHERE arsenal_klan='{$user[klan]}' AND owner='22125' AND arsenal_owner!='{$user[id]}' ORDER by `update` DESC; ");
			if (($st==3) and ($_SESSION['ars_razdel']==3) )
				{
				$st_sql=" i.type='{$st}' and otdel!=6 ";				
				}
			elseif ($st==3)
				{
				$st_sql=" i.type='{$st}' and otdel=6 ";				
				}
				else
				{
				$st_sql=" i.type='{$st}'  ";
				}
			
			$data = mysql_query("SELECT *,(select `all_access` from oldbk.clans_arsenal ars where ars.id_inventory=i.id) as all_access FROM  oldbk.`inventory` i WHERE i.arsenal_klan='{$user[klan]}' AND i.owner='22125' AND i.arsenal_owner!='{$user[id]}' and  ".$st_sql."  ORDER by i.`update` DESC; ");			


			
			if (mysql_num_rows($data)>0)
			{
				//� ����� ������ ����� ��� ��������
				 if ($IM_glava==1)  
				 { echo "<form method=post> ";  }
			
			
			while($row = mysql_fetch_array($data)) 
			{
			//��������� �������
			if ($row[arsenal_owner]==1) // ���� ������ ��������
			{			
			//���� ���� ����� ��� ������� ���� �� ���������� ��� ������� ��� ���� �����
			 if (($row[all_access]==1) or ($klan['glava'] ==$user['id'] ))
			 	{
			 	//���������� ��
				$load_ok=1;
				}
				else
				{
				//����� ���������  ������ ���� �� ������
				 if (in_array($row[id], $array_access))
				 		{
						$load_ok=1;				 		
				 		}
				 		else
				 		{
						$load_ok=0;				 		
				 		} 
				}
			}
			else
			{
			//�� �������� ���������� ��
			$load_ok=1;
			}
			
		
			
					if ($load_ok==1)	
						{
							$row[owner_original]=$row[arsenal_owner];
							$row[id_ars]=$row[id];
							if($row[otdel]==7 || $row[otdel]==71|| $row[otdel]==72|| $row[otdel]==73)
							{
								$inv_shmot[0][0][$row[otdel]][]=$row;
							}
							else //���� ��� ���������� - �� �� �� ���������
							{
								$inv_shmot[0][0][$row[prototype]][]=$row;
							}
					  		$inv_gr_key[$row[prototype]]=0;
					 		$count++;
					      }
			}
			
		
			foreach ($inv_shmot as $key2 => $value2)
				{
				  foreach ($value2 as $key => $value)
					 {
					      foreach ($value as $key1 => $value1)
						{
		                   //��� ���� �������� ���������� �� �������, ���� ����������� ���������..
		                         $div_group=0;
		                         echo '<tr><td>';
							    if($inv_gr_key[$key1]==1)
							    {
					      			$group_key=1;
								}
								else
								{
						        	$group_key=count($value1);
								}
								for($i=0;$i<$group_key;$i++)
								{
					                $showed=0;
                                    $value1[$i][chk_arsenal]=1;    //0-�� ����� ����������� ���. 1 ��� ������ � "����� �� ��������"  2-��� ���� �������. 3-��� ���� ��������

					               // if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								    $color = '#C7C7C7';
								    $value1[$i]['inv']=1;
									if($value1[$i]['group']==1)
									{
					                   $value1[$i]['group_by']=1;
									}

									if($inv_gr_key[$key1]==1)
								    {
								    	$value1[$i]['count'] =  count($value1);
										echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
										showitem($value1[$i],0,false,$color,'');
										echo '</table>';
										$showed=1;
								    }
									else
									{
										$value1[$i]['count'] = 1;

												if($group_key>1 && $i==0){
													$div_group=1;
													echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
                                      				showitem($value1[$i],0,false,$color,'');
													echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
													echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a></div>";
													echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div>
													</td></tr>";
				                                	echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
													$showed=1;
												}
									}
									if($showed==0)
								    {
			                              	echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
											showitem($value1[$i],0,false,$color,'');
											echo "</table>";
			         				}
					              if($i==($group_key-1) && $div_group==1)
		                            {
		                            	echo '</div>';
		                            }

								}
		                       echo '</td></tr>';
						}
			        }
			     }
			     
    				 if ($IM_glava==1)
    				 {
    				  echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=sit_access value='��������� ������'> </form></td></tr> ";
    				    }
			     
			     }
			     else
			     	{
				echo '
			<TR>
			<TD>
				<center><strong>�������� �� �������.</strong></center>
			</TD>
		</TR>
				
				';
								     	
			     	
			     	}
			echo '</TABLE>';
	}
	// ��� ���� ������� ��� ���� � ��������


} else  {
    if (!(isset($_GET['mybox']))) {
    	 echo "����� ����� �� ����������� ��� ���������� ��� ������������� ��������.<br>"; 


	// echo '<input type="button" value="������ ������"  onclick="location.href=\'klan_arsenal.php?mybox=1\'"/> '; 
   	 
    	 }
}
	//////////////////////////my-box
	unset($_GET['mybox']);
	if ($_GET['mybox'] > 0) {
	
	 if (($_GET['mybox']==1)and(((int)$_GET[item])>0))
	 	{
	 	$itm_id=(int)$_GET[item];
	 	//�������� �� �������
	 	
	 		//���� �������
	 		$getitem = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.inventory WHERE owner=488 AND arsenal_owner='{$user[id]}' and id='".$itm_id."'"));
 		
	 		if ($getitem[id]>0)
	 			{
	 			//�������� �� �����
	 			$boxsize=clac_mybox();
				if (($getitem[gmeshok]>0) and ($boxsize[massa]>($boxsize[gsum]-$getitem[gmeshok])))
				{
				err('<b>�� �������� ������� ���� �������, ����� ��� ����� ������� ��������!</b><br>');
				}
	 			else
	 			{
	 			mysql_query("UPDATE oldbk.inventory SET owner='{$user[id]}', arsenal_owner=0  WHERE owner=488 AND arsenal_owner='{$user[id]}' and id='".$itm_id."'");
	 			}
	 			}
	 			
	 		
	 	}
		elseif (($_GET['mybox']==1)and(((int)$_GET[grp])>0))
		{
		$grp_id=(int)$_GET[grp];
	 	//�������� �� ������� - ������
	 		
	 		//���� �������� �� ����� � �����
	 		$getitem = mysql_fetch_array(mysql_query("SELECT count(id) as kol, sum(massa) as massa , sum(gmeshok) as gmeshok  FROM oldbk.inventory WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."'"));
	 		 if ($getitem[kol]>0)
	 		 	{
	 		 	$boxsize=clac_mybox();
				if (($getitem[gmeshok]>0) and ($boxsize[massa]>($boxsize[gsum]-$getitem[gmeshok])))
				{
				err('<b>�� �������� ������� ���� �������, ����� ��� ����� ������� ��������!</b><br>');
				}
	 			else
	 			{
	 			mysql_query("UPDATE oldbk.inventory SET owner='{$user[id]}', arsenal_owner=0  WHERE owner=488 AND arsenal_owner='{$user[id]}' and prototype='".$grp_id."'");
	 			}
	 		 	}
	 		
		} 	
		elseif (($_GET['mybox'] ==2) and (((int)$_GET[item])>0))
		{
	 	$itm_id=(int)$_GET[item];
		//������ � �������
		
		$boxsize=clac_mybox();
		 if ($boxsize[massa]<$boxsize[gsum])
		 	{
			
	 		//���� �������
	 		$getitem = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `labonly`=0 AND (cost>0 OR ecost>0  )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and id='".$itm_id."'"));
	 		if ($getitem[id]>0)
	 			{
	 			
	 				if($getitem[add_pick]!='') 
	 				{
					undress_img($getitem);
					}
	 			
	 			mysql_query("UPDATE oldbk.inventory SET owner=488, arsenal_owner='{$user[id]}'  WHERE owner='{$user[id]}' and id='".$itm_id."'");
	 			}

	 		
	 		}
	 		else
	 		{
	 		err('<b>������ ��������� �����!</b><br>');
	 		}

		}
		elseif (($_GET['mybox'] ==2) and (((int)$_GET[grp])>0))
		{
	 	$grp_id=(int)$_GET[grp];
		//������ � ������� ������
		
 		//���� ��������
 		$getitem = mysql_fetch_array(mysql_query("SELECT count(id) as kol, sum(massa) as massa, sum(gmeshok) as gmeshok  FROM oldbk.`inventory` WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `labonly`=0 AND  (cost>0 OR ecost>0 )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and prototype='".$grp_id."'"));
 		if ($getitem[kol]>0)
 		{
		 $boxsize=clac_mybox();
		 if (($boxsize[massa]+$getitem[massa]) <$boxsize[gsum])
		 	{
 			mysql_query("UPDATE oldbk.inventory SET owner=488, arsenal_owner='{$user[id]}'  WHERE `owner` = '{$user[id]}' AND `dressed` = 0 AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `labonly`=0 AND  (cost>0 OR ecost>0  )  AND `setsale`=0 and dategoden=0 and arsenal_klan='' and prototype='".$grp_id."'");
	 		}
	 		else
	 		{
	 		err('<b>��� �������� �� ���������� � ������!</b><br>');
	 		}
	 	}
		
		}
	////////
		echo '<center><a href="klan_arsenal.php"><img src="http://i.oldbk.com/i/ars/ars_back.png" title="��������� � ��������"></a></center><br>';
		// ����� ����� �� ��������
			echo "������ ������, ��� �� ������ ������� ���� ������ ����.<br/><br/>";
			
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td width="49%" valign=top>';
			///��� � �������
			$sunduk=clac_mybox();
			echo "<div align=center><b>������ (�����:{$sunduk[massa]}/{$sunduk[gsum]})</b></div>";
$_SESSION['brazdel'] = isset($_GET['brazdel']) ? max(0, min(5, intval($_GET['brazdel']))) : (isset($_SESSION['brazdel']) ? $_SESSION['brazdel'] : 0);
echo '<TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
		<TD align=center bgcolor="'.(($_SESSION['brazdel'] === 0)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&brazdel=0">&nbsp;��������������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['brazdel'] === 1)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&brazdel=1">&nbsp;��������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['brazdel'] === 2)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&brazdel=2">&nbsp;������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['brazdel'] === 4)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&brazdel=4">&nbsp;�������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['brazdel'] === 5)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&brazdel=5">&nbsp;�������</A></TD>
		</TR>
	</TABLE>';
			echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';

$brazdel=(intval($_SESSION['brazdel']));

	  switch(intval($_SESSION['brazdel'])) {
		    case 1: //zakljatija
			$bwhere = "AND `type` = 12 ";

			break;
			case 2: //pro4ee
			$bwhere = "AND `type` > 12 AND `type` NOT IN (200,27,28,30)  AND ( (`prototype` < 3001 or `prototype` > 3030) and (`prototype` < 103001 or `prototype` > 103030)  ) ";
			break;
			case 3: //karman
			$bwhere = "AND `karman` = 1 ";
			break;
			case 4: //podarki
			$bwhere = "AND `type` IN (200) ";
			break;
			case 5: //�������
			$bwhere = "AND ( (`prototype` > 3000 and `prototype` < 3030) or (`prototype` > 103000 and `prototype` < 103030) )";
			break;

			default: //abmundir
			$bwhere = "AND (`type` < 12 OR `type` in (27,28,30)  ) ";
			break;
		}
			
			//488 -- ��������� �� ��� �������� ������ ���� ������
			$data = mysql_query("SELECT * FROM  oldbk.`inventory` WHERE owner=488 ".$bwhere." AND arsenal_owner='{$user[id]}' ORDER by `update` DESC; ");			
			$count=0;
			while($row = mysql_fetch_array($data)) {
			//$row[id_ars]=$row[id];
			
             	if($row[otdel]==7 || $row[otdel]==71|| $row[otdel]==72|| $row[otdel]==73)
				{
					$inv_shmot[0][0][$row[otdel]][]=$row;
				}
				else //���� ��� ���������� - �� �� �� ���������
				{
					$inv_shmot[0][0][$row[prototype]][]=$row;
				}
		  		$inv_gr_key[$row[prototype]]=0;
		 		$count++;
			}
		if ($count>0)
			{
			foreach ($inv_shmot as $key2 => $value2)
				{
				  foreach ($value2 as $key => $value)
					 {
					      foreach ($value as $key1 => $value1)
						{
		                   //��� ���� �������� ���������� �� �������, ���� ����������� ���������..
		                         $div_group=0;
		                         echo '<tr><td>';
							    if($inv_gr_key[$key1]==1)
							    {
					      			$group_key=1;
								}
								else
								{
						        	$group_key=count($value1);
								}
								for($i=0;$i<$group_key;$i++)
								{
					                $showed=0;
				                    
                                    $value1[$i][chk_arsenal]=6;    //0-�� ����� ����������� ���. 1 ��� ������ � "����� �� ��������"  2-��� ���� �������. 3-��� ���� ��������

					               // if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								    $color = '#C7C7C7';
								    $value1[$i]['inv']=1;
									if($value1[$i]['group']==1)
									{
					                   $value1[$i]['group_by']=1;
									}

									if($inv_gr_key[$key1]==1)
								    {
								    	$value1[$i]['count'] =  count($value1);
										echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
										showitem($value1[$i],0,false,$color,'');
										echo '</table>';
										$showed=1;
								    }
									else
									{
										$value1[$i]['count'] = 1;

												if($group_key>1 && $i==0){
													$div_group=1;
													echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
                                      									showitem($value1[$i],0,false,$color,'');
													echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
													echo '<div  id=ltxt_'.$value1[$i]['prototype'].' style="display: block;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','l');\" >�������� ��� ".($group_key-1)."��.</a>";
													echo "<br><a href=?mybox=1&grp=".$value1[$i]['prototype']."> [������� ���]</a></div>";
													echo '<div  id=ltxt1_'.$value1[$i]['prototype'].' style="display: none;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','l');\" >������</a></div>
													</td></tr>";
				                                	echo '</table><div style="display: none;" id=lid_'.$value1[$i]['prototype'].'>';
													$showed=1;
												}
									}
									if($showed==0)
								    {
			                              	echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
											showitem($value1[$i],0,false,$color,'');
											echo "</table>";
			         				}
					              if($i==($group_key-1) && $div_group==1)
		                            {
		                            	echo '</div>';
		                            }

								}
		                       echo '</td></tr>';
						}
			        }
			     }
			  }
			  else
			  {
			  echo "<div align=center><b>��� ���������!</b></div>";
			  }
			echo '</TABLE>';
			echo '	</td>
			<td width="2%" valign=top>&nbsp;</td>
			<td width="49%" valign=top>';
////////////////////////��������� ���� ��� ����� � �������

echo "<div align=center><b>������ (�����: ";
$d = mysql_fetch_array(mysql_query("SELECT sum(`massa`) FROM oldbk.`inventory` WHERE `owner` = '{$_SESSION['uid']}' AND bs_owner='".$user[in_tower]."' AND `dressed` = 0 AND `setsale` = 0 ; "));
if(!$d[0]){$d[0]='0';}
echo $d[0];
echo "/";
echo get_meshok();
echo ")</b></div>";

unset($inv_shmot);
unset($inv_gr_key);
$_SESSION['razdel'] = isset($_GET['razdel']) ? max(0, min(5, intval($_GET['razdel']))) : (isset($_SESSION['razdel']) ? $_SESSION['razdel'] : 0);
echo '<TABLE border=0 width=100% cellspacing="0" cellpadding="3" bgcolor=#d4d2d2><TR>
		<TD align=center bgcolor="'.(($_SESSION['razdel'] === 0)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&razdel=0">&nbsp;��������������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['razdel'] === 1)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&razdel=1">&nbsp;��������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['razdel'] === 2)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&razdel=2">&nbsp;������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['razdel'] === 4)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&razdel=4">&nbsp;�������</A></TD>
		<TD align=center bgcolor="'.(($_SESSION['razdel'] === 5)?"#A5A5A5":"#C7C7C7").'"><A HREF="?mybox=1&razdel=5">&nbsp;�������</A></TD>
		</TR>
	</TABLE>';
echo '<TABLE BORDER=0 WIDTH=100% CELLSPACING="1" CELLPADDING="2" BGCOLOR="#A5A5A5">';
$razdel=(intval($_SESSION['razdel']));

	  switch(intval($_SESSION['razdel'])) {
		    case 1: //zakljatija
			$where = "AND `type` = 12 ";

			if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp1']; } else {$_SESSION['curp1']=$_GET['page'];}
			break;
			case 2: //pro4ee
			$where = "AND `type` > 12 AND `type` NOT IN (200,27,28,30)  AND ( (`prototype` < 3001 or `prototype` > 3030) and (`prototype` < 103001 or `prototype` > 103030)  ) ";

			if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp2']; } else {$_SESSION['curp2']=$_GET['page'];}
			break;
			case 3: //karman
			$where = "AND `karman` = 1 ";

			if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp3']; } else {$_SESSION['curp3']=$_GET['page'];}
			break;
			case 4: //podarki
			$where = "AND `type` IN (200) ";

			if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp4']; } else {$_SESSION['curp4']=$_GET['page'];}
			break;
			case 5: //�������
			$where = "AND ( (`prototype` > 3000 and `prototype` < 3030) or (`prototype` > 103000 and `prototype` < 103030) )";

			if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp5']; } else {$_SESSION['curp5']=$_GET['page'];}
			break;

			default: //abmundir
			$where = "AND (`type` < 12 OR `type` in (27,28,30) ) ";

			if (!isset($_GET['page'])) { $_GET['page']=$_SESSION['curp0']; } else {$_SESSION['curp0']=$_GET['page'];}
			break;
		}




			$data = mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = '{$_SESSION['uid']}' ".$where." AND `dressed` = 0 AND  present != '�������� �����' and present != '��������� �����'  AND prokat_idp = 0 AND bs_owner=0  AND `labflag` = 0 AND `labonly`=0 AND (cost>0 OR ecost>0)   AND `setsale`=0 and dategoden=0 and arsenal_klan='' ORDER by `update` DESC; ");
			$count=0;
			while($row = mysql_fetch_array($data)) {                 if($row[otdel]==7 || $row[otdel]==71|| $row[otdel]==72|| $row[otdel]==73)
				{
					$inv_shmot[0][0][$row[otdel]][]=$row;
				}
				else //���� ��� ���������� - �� �� �� ���������
				{
					$inv_shmot[0][0][$row[prototype]][]=$row;
				}
		  		$inv_gr_key[$row[prototype]]=0;
		 		$count++;


			}
		if ($count>0)
		{
		 foreach ($inv_shmot as $key2 => $value2)
				{
				  foreach ($value2 as $key => $value)
					 {
					      foreach ($value as $key1 => $value1)
						{
		                   //��� ���� �������� ���������� �� �������, ���� ����������� ���������..
		                         $div_group=0;
		                         echo '<tr><td>';
							    if($inv_gr_key[$key1]==1)
							    {
					      			$group_key=1;
								}
								else
								{
						        	$group_key=count($value1);
								}
								for($i=0;$i<$group_key;$i++)
								{
					                $showed=0;
                                    $value1[$i][chk_arsenal]=7;    //0-�� ����� ����������� ���. 1 ��� ������ � "����� �� ��������"  2-��� ���� �������. 3-��� ���� ��������

					               // if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								    $color = '#C7C7C7';
								    $value1[$i]['inv']=1;
									if($value1[$i]['group']==1)
									{
					                   		$value1[$i]['group_by']=1;
									}

									if($inv_gr_key[$key1]==1)
								    {
								    	$value1[$i]['count'] =  count($value1);
										echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
										showitem($value1[$i],0,false,$color,'');
										echo '</table>';
										$showed=1;
								    }
									else
									{
										$value1[$i]['count'] = 1;

												if($group_key>1 && $i==0){
													$div_group=1;
													echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
                                      				showitem($value1[$i],0,false,$color,'');
													echo "<tr BGCOLOR='".$color."' ><td colspan=2>";
													echo '<div  id=rtxt_'.$value1[$i]['prototype'].' style="display: block;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >�������� ��� ".($group_key-1)."��.</a>";
													echo "<br><a href=?mybox=2&grp=".$value1[$i]['prototype']."> [�������� ���]</a></div>";
													echo '<div  id=rtxt1_'.$value1[$i]['prototype'].' style="display: none;">';
													echo "<a href=#".$value1[$i]['prototype']."
													onclick=\"showhidden('".$value1[$i]['prototype']."','r');\" >������</a></div>
													</td></tr>";
				                                	echo '</table><div style="display: none;" id=rid_'.$value1[$i]['prototype'].'>';
													$showed=1;
												}
									}
									if($showed==0)
								    {
			                              	echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
											showitem($value1[$i],0,false,$color,'');
											echo "</table>";
			         				}
					              if($i==($group_key-1) && $div_group==1)
		                            {
		                            	echo '</div>';
		                            }

								}
		                       echo '</td></tr>';
						}
			        }
			     }
	 		}
	 		else
	 		{
	 		echo "<div align=center><b>��� ���������� ���������!</b></div>";
	 		}






			echo '</TABLE>';



			echo '</td></tr></table>';

			
			
	}

	/////////////////////////my-box 




?>

</center>
</td>
</tr>
</table>
</body>
</html>
<?
/*
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
*/
?>