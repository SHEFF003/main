<?
	session_start();
	if (!($_SESSION['uid'] >0))
	{
	 header("Location: index.php");
	 die();
	}
	include "connect.php";
	include "functions.php";
	
	if ($user['klan']!='radminion') 
	{ 
	die('go away'); 
	}




function showitem_edit ($row, $orden = 0, $check_price = false,$color='',$act='',$rep_rate=0, $priv=0,$retdata = 0) {
	global $user, $klan_ars_back, $giftars, $IM_glava, $anlim_show, $anlim_items, 	$nodress  ;
	$vau4 = array(100005,100015,100020,100025,100040,100100,100200,100300);
	$unikrazdel = array(6,2,21,22,23,24,3,4,41,42);

	$ret = "";

	if($row['add_pick'] != '' && $row['pick_time']>time()) {
       		$row['img'] = $row['add_pick'];
	}

	if (($row['type'] == 30) and ($row['owner']==$user['id']) ) // ������� �� ���� �������
	{
	// ����������  ��� ���� ���� ������
		if ($row['ups'] >= $row['add_time']) 
		{
		$mig=explode(".",$row['img']);
		$row['img']=$mig[0]."_up.".$mig[1];
		}
	}


	$magic = magicinf ($row['magic']);

	$incmagic = magicinf($row['includemagic']);
	$incmagic['name'] = $row['includemagicname'];
	$incmagic['cur'] = $row['includemagicdex'];
	$incmagic['max'] = $row['includemagicmax'];
	$incmagic['uses'] = $row['includemagicuses'];

	if(!$magic) {
		$magic['chanse'] = $incmagic['chanse'];
		$magic['time'] = $incmagic['time'];
		$magic['targeted'] = $incmagic['targeted'];
	}

	$artinfo = "";
	$issart = 0;
	if ((($row['ab_uron'] > 0 || $row['ab_bron'] > 0 || $row['ab_mf'] > 0 || $row['art_param'] != "")  AND $row['type'] != 30) || ($row['type'] == 30 && $row['up_level'] > 5)) 
	{
		if ($row['type'] != 30) $artinfo = ' <IMG SRC="http://i.oldbk.com/i/artefact.gif" WIDTH="18" HEIGHT="16" BORDER=0 TITLE="��������" alt="��������"> ';
		$issart = 1;
	}

	if ($row['prototype'] == 1236) {
		$act = '<a target="_blank" href="printticket.php?id='.$row['id'].'">�����������</a>';
	}


	
		$ch=0;

		$ret .= "<TR bgcolor=".$color.">";
		$ret .= "<TD align=center width=150 ";
		$ret .= " >";
		$ret .= "<img  src='http://i.oldbk.com/i/sh/".$row['img']."'><BR>";
		
		$ret .= "<b><small>PROTO_ID:{$row['id']} </small></b> ";
		
		if ($row['new_item']==1)
			{
			$ret .= '<small>(�����)</small>';
			}

	    	$ret .= "<td valign=top>";
	

	if ($row['nalign']==1) {
		$row['nalign']='1.5';
	}


	



	$add_name=''; if (!($row['new_item']==1)) $add_name=' (�����)';
	
		

	
	$ret .= "<b>��������:</b><input type=text name='name' value='".$row['name'].$add_name."' size=60> ";
	



	$eshopadd = "";

	if ((isset($_GET['otdel']) && (in_array($_GET['otdel'],$unikrazdel) ) && ($_SERVER['PHP_SELF'] == "/_eshop.php" || $_SERVER['PHP_SELF'] == "/eshop.php")  ) or ($row['ekr_flag']>0) ) { 

		$addimg = '<img src="http://i.oldbk.com/i/berezka06.gif" title="������� �� �������" alt="������� �� �������"> ';
	} else {
		$addimg = "";
	}


 
	
	$ret .= "<img src=http://i.oldbk.com/i/align_".$row['nalign'].".gif> (�����: <input type=text name='massa' value='".$row['massa']."' size=10>) ".$addimg." ".$artinfo.$anlim_txt.' <BR>';
	

        if($row['sowner'] > 0) {
		if($row['sowner'] != $user['id']) {
			$so = mysql_query_cache('SELECT * from oldbk.users WHERE id = '.$row['sowner'].' AND id_city = 0',false,600);
			if (!count($so)) {
	        		$so = mysql_query_cache('SELECT * from avalon.users WHERE id = '.$row['sowner'].' AND id_city = 1',false,600);
			}
			if (!count($so)) {
	        		$so = mysql_query_cache('SELECT * from angels.users WHERE id = '.$row['sowner'].' AND id_city = 2',false,600);
			}

			if (count($so)) {
				$so = $so[0];
	        		$sowner = s_nick($so['id'],$so['align'],$so['klan'],$so['login'],$so['level']);
			}
        	} else {
	        	$sowner = s_nick($user['id'],$user['align'],$user['klan'],$user['login'],$user['level']);
		}

        	if ($row['type'] == 250) {
        		$ret .= '<font color=red>������ ���� �����������</font> '.$sowner.'<br>';
		} elseif ($row['type'] == 210) {
			$ret .= '<font color=red>������ ���� ����� ������������</font> '.$sowner.'<br>';
		} elseif ($row['type'] == 200) {
			$ret .= '<font color=red>���� ������� ����� �������� ������</font> '.$sowner.'<br>';
		} elseif (($row['prototype'] >=56661 ) and  ($row['prototype'] <=56663 )) {
			$ret .= '<font color=red>����� ������������� �� �������, �� ������ �������� � ��������� '.$sowner.'</font><br>';
		}
		else {
        		$ret .= '<font color=red>������ ���� ����� ������ ������</font> '.$sowner.'<br>';
		}
	}

	 
		$ret .= "<b>����: <input type=text name='cost' value='".$row['cost']."' size=12>��.</b>  &nbsp; <br>";
		$ret .= "<b>����: <input type=text name='repcost' value='".$row['repcost']."' size=12> ���.</b> &nbsp; <br>";		
		$ret .= "<b>����: <input type=text name='ecost' value='".$row['ecost']."' size=12> ���.</b> &nbsp; &nbsp; <br>";


	 

	if ((($row['is_owner']==1) and ($row['id']>=56661 ) and ($row['id']<=56663 ) ) and ($check_price && $priv) )
	{
		$ret .= '<br><small><font color=red>����� ������������� �� �������, �� ������ �������� � ���������!</font></small>';
	}
	elseif($check_price && $priv) {
		$ret .= '<br><small><font color=red>����� ������� ���� ����� ��������� � ���������.</font></small>';
	}  elseif ($row['is_owner']==1) {
		$ret .= '<br><small><font color=red>����� ������� ���� ����� ��������� � ���������.</font></small>';
	} elseif (($_SERVER['PHP_SELF'] == '/cshop.php') AND ($row['id'] == 1000001 || $row['id'] == 1000002 || $row['id'] == 1000003)) {
		$ret .= '<br><small><font color=red>����� ������� ������� ����� ���������� ��������.</font></small>';
	}

	if ($row['type'] == 30) {
		// ���������� ������� ����
		$addlvl = "";
		if ($row['ups'] >= $row['add_time']) {
			$addlvl = ' <a href="?edit=1&uprune='.$row['id'].'" style="color:red;"><img src="http://i.oldbk.com/i/up.gif" border="0"></a> ';
		}

		if (isset($row['ups'])) {
			$ret .= "<br><b>�������: ".$row['up_level']." </b> ����: <b><a href=\"http://oldbk.com/encicl/?/runes_opyt_table.html\" target=\"_blank\">".$row['ups']."</b></a> (".$row['add_time'].") ".$addlvl;
		} else {
			$ret .= "<br><b>�������: ".(int)($row[up_level])." </b> ";
		}
	}

	$ret .= "<BR>�������������: <input type=text name='duration' value='".$row['duration']."' size=5>/<input type=text name='maxdur' value='".$row['maxdur']."' size=5><BR>";

	if (!$row['needident']) {
		// ���������� ������ � ��� �����������
		$art_param = explode(',',$row['art_param']);

		if ($row['type'] != 30) {
			 // ���� ups - ��� ��� ������������ ��� �������� ����� ���� ��� �������� �� �������
			if ($row['ups'] > 0) {
				$ret .= "���������: <b>".$row['ups']." ���</b><BR>";
			}
		}

		if ($row['stbonus'] > 0) {
			$ret .= "��������� ����������: <b>".$row['stbonus']."</b><BR>";
		}
		if ($row['mfbonus'] > 0) {
			$ret .= "��������� ���������� ��: <b>".$row['mfbonus']."</b><BR>";
		}

		if ($magic['chanse']) {
			$ret .= "����������� ������������: ".$magic['chanse']."%<BR>";
		}
		if ($magic['time']) {
			$ret .= "����������������� �������� �����: ".get_delay_time($magic['time'])." <BR>";
		}
		if ($row['goden']) {
			$ret .= "���� ��������: {$row['goden']} ��. ";
			if (!$row[GetShopCount()] or $_SERVER['PHP_SELF'] == '/comission.php' or $_SERVER['PHP_SELF'] == '/main.php') {
				$ret .= "(�� ".date("d.m.Y H:i",$row['dategoden']).")";
			}
			$ret .= "<BR>";
		}
		if ($row['nsex'] == 1) {
			$ret .= "� ���: <b>�������</b><br>";
		}

		if ($row['nsex'] == 2) {
			$ret .= "� ���: <b>�������</b><br>";
		}

		$ret .= "<b>��������� �����������:</b><BR>";

				$ret .= "�������: <input type=text size=5 name=nlevel value='".(int)($row['nlevel'])."'><br>";
		
				$ret .= "<b>���������� � ������:</b><BR>";
				$ret .= "����: <input type=text size=5 name=nsila value='".(int)($row['nsila'])."'><br>";
				$ret .= "��������: <input type=text size=5 name=nlovk value='".(int)($row['nlovk'])."'><br>";
				$ret .= "��������: <input type=text size=5 name=ninta value='".(int)($row['ninta'])."'><br>";
				$ret .= "������������: <input type=text size=5 name=nvinos value='".(int)($row['nvinos'])."'><br>";
				$ret .= "���������: <input type=text size=5 name=nintel value='".(int)($row['nintel'])."'><br>";
				$ret .= "��������: <input type=text size=5 name=nmudra value='".(int)($row['nmudra'])."'><br>";
		
	
				$ret .= "<b>���������� � ������:</b><BR>";
				$ret .= "���������� �������� ������ � ���������: <input type=text size=5 name=nnoj value='".(int)($row['nnoj'])."'><br>";
				$ret .= "���������� �������� �������� � ��������: <input type=text size=5 name=ntopor value='".(int)($row['ntopor'])."'><br>";
				$ret .= "���������� �������� �������� � ��������: <input type=text size=5 name=ndubina value='".(int)($row['ndubina'])."'><br>";
				$ret .= "���������� �������� ������: <input type=text size=5 name=nmech value='".(int)($row['nmech'])."'><br>";
			

				$ret .= "<b>���������� � �����:</b><BR>";
				$ret .= "���������� �������� ������� ����: <input type=text size=5 name=nfire value='".(int)($row['nfire'])."'><br>";
				$ret .= "���������� �������� ������� ����: <input type=text size=5 name=nwater value='".(int)($row['nwater'])."'><br>";
				$ret .= "���������� �������� ������� �������: <input type=text size=5 name=nair value='".(int)($row['nair'])."'><br>";
				$ret .= "���������� �������� ������� �����: <input type=text size=5 name=nearth value='".(int)($row['nearth'])."'><br>";
				$ret .= "���������� �������� ������ �����: <input type=text size=5 name=nlight value='".(int)($row['nlight'])."'><br>";
				$ret .= "���������� �������� ����� ������: <input type=text size=5 name=ngray value='".(int)($row['ngray'])."'><br>";
				$ret .= "���������� �������� ������ ����: <input type=text size=5 name=ndark value='".(int)($row['ndark'])."'><br>";

				$ret .= "<b>����� ���������:</b> 
					<select name='nclass'>
					<option value='0' ".($row['nclass']==0?"selected":"")." >�����</option>
					<option value='1' ".($row['nclass']==1?"selected":"").">���������</option>
					<option value='2' ".($row['nclass']==2?"selected":"").">��������</option>
					<option value='3' ".($row['nclass']==3?"selected":"").">����</option></select><br>";

		$ret .= "<b>��������� ��:</b><hr>";
		
		if ($row['type']==3)
		{
		$ret .= "<b>�����������.:</b><BR>";
		$ret .= "� ����������� ��������� �����������: <input type=text size=5 name=minu value='".(int)($row['minu'])."'><br>";
		$ret .= "� ������������ ��������� �����������: <input type=text size=5 name=maxu value='".(int)($row['maxu'])."'><br>";
		}
		
		$ret .= "<b>����� � �����.:</b><BR>";
		$ret .= "� ����: +<input type=text size=5 name=gsila value='".(int)($row['gsila'])."'><br>";
		$ret .= "� ��������: +<input type=text size=5 name=glovk value='".(int)($row['glovk'])."'><br>";
		$ret .= "� ��������: +<input type=text size=5 name=ginta value='".(int)($row['ginta'])."'><br>";			
		$ret .= "� ���������: +<input type=text size=5 name=gintel value='".(int)($row['gintel'])."'><br>";			
		$ret .= "� ��������: +<input type=text size=5 name=gmp value='".(int)($row['gmp'])."'><br>";						
		$ret .= "� ������� �����: +<input type=text size=5 name=ghp value='".(int)($row['ghp'])."'><br>";												

		$ret .= "<b>��.:</b><BR>";
		$ret .= "� ��. ����������� ������: <input type=text size=5 name=mfkrit value='".(int)($row['mfkrit'])."'><br>";
		$ret .= "� ��. ������ ����. ������: <input type=text size=5 name=mfakrit value='".(int)($row['mfakrit'])."'><br>";			
		$ret .= "� ��. ������������: <input type=text size=5 name=mfuvorot value='".(int)($row['mfuvorot'])."'><br>";			
		$ret .= "� ��. ������ ��������.: <input type=text size=5 name=mfauvorot value='".(int)($row['mfauvorot'])."'><br>";									
			
		$ret .= "<b>����������:</b><BR>";
		$ret .= "� ���������� �������� ������ � ���������: +<input type=text size=5 name=gnoj value='".(int)($row['gnoj'])."'><br>";
		$ret .= "� ���������� �������� �������� � ��������: +<input type=text size=5 name=gtopor value='".(int)($row['gtopor'])."'><br>";
		$ret .= "� ���������� �������� �������� � ��������: +<input type=text size=5 name=gdubina value='".(int)($row['gdubina'])."'><br>";
		$ret .= "� ���������� �������� ������: +<input type=text size=5 name=gmech value='".(int)($row['gmech'])."'><br>";
		$ret .= "� ���������� �������� ������� ����: +<input type=text size=5 name=gfire value='".(int)($row['gfire'])."'><br>";
		$ret .= "� ���������� �������� ������� ����: +<input type=text size=5 name=gwater value='".(int)($row['gwater'])."'><br>";
		$ret .= "� ���������� �������� ������� �������: +<input type=text size=5 name=gair value='".(int)($row['gair'])."'><br>";
		$ret .= "� ���������� �������� ������� �����: +<input type=text size=5 name=gearth value='".(int)($row['gearth'])."'><br>";
		$ret .= "� ���������� �������� ������ �����: +<input type=text size=5 name=glight value='".(int)($row['glight'])."'><br>";
		$ret .= "� ���������� �������� ����� ������: +<input type=text size=5 name=ggray value='".(int)($row['ggray'])."'><br>";
		$ret .= "� ���������� �������� ������ ����: +<input type=text size=5 name=gdark value='".(int)($row['gdark'])."'><br>";
		$ret .= "<b>�����:</b><BR>";
		$ret .= "� ����� ������: <input type=text size=5 name=bron1 value='".(int)($row['bron1'])."'><br>";
		$ret .= "� ����� �������: <input type=text size=5 name=bron2 value='".(int)($row['bron2'])."'><br>";
		$ret .= "� ����� �����: <input type=text size=5 name=bron3 value='".(int)($row['bron3'])."'><br>";
		$ret .= "� ����� ���: <input type=text size=5 name=bron4 value='".(int)($row['bron4'])."'><br>";


		$ret .= "<b>�������� (������):</b><br>";
		$ret .= "� ������������� ��.:<input type=text size=5 name=ab_mf value='".$row['ab_mf']."'><br>";
		$ret .= "� �����:+<input type=text size=5 name=ab_bron value='".$row['ab_bron']."'><br>";
		$ret .= "� �����:+<input type=text size=5 name=ab_uron value='".$row['ab_uron']."'><br>";

		
		if($row['present'] != '') 
		{
			$prez = explode(':|:',$row['present']);
		}
		
		if($row['gmeshok']) $ret .= "� ����������� ������: +".$row['gmeshok']."<BR>";
		
		if($row['letter'] && $user['in_tower'] != 16 && $row['prototype'] != 3006000) $ret .= "���������� ��������: ".strlen($row['letter'])."<BR>";
		if($row['present']) $ret .= "������� ��: <b>".$prez[0]."</b><br>";
		if($row['letter'] && $user['in_tower'] != 16 && $row['prototype'] != 3006000) $ret .= "�� ������ ������� �����:<div style='background-color:FAF0E6;'> ".$row['letter']."</div>";
		if($row['prokat_idp']>0) $ret .= "��������:".floor(($row['prokat_do']-time())/60/60)." �. ".round((($row['prokat_do']-time())/60)-(floor(($row['prokat_do']-time())/3600)*60))." ���.<br>";
		if($magic['name'] && $row['type'] != 50) $ret .= "<font color=maroon>�������� ��������:</font> ".$magic['name']."<BR>";
		if($magic['img'] && $row['type'] == 12 && $row['labonly']==0 && $row['dategoden'] == 0) $ret .= "<font color=maroon>��������:</font> ����� ������������ � ����</font> <BR>";
		if((!$magic['img'] || $row['labonly']==1 || $row['dategoden'] > 0) && $row['type'] == 12 ) $ret .= "<font color=maroon>��������:</font> �� ����� ������������ � ����</font> <BR>";
		
		if ($row['magic'] == 8888) {
			$ret .=  "<font color=maroon>��������:</font> ����� ���� ����������� ������ �� ���� �������<br>";
		}
		
		if (($row['id'] == 30012) OR ($row['prototype'] == 30012)) {
			$ret .=  "<font color=maroon>��������:</font>� ��� ���� ����������� ���� �������� ������<br>";
		}
		
		if (($row['id'] == 501) OR ($row['prototype'] == 501) OR ($row['id'] == 502) OR ($row['prototype'] == 502) ) {
			$ret .=  "<font color=maroon>��������:</font>��� ������������ �����<br>";
		}		
		
		
		if ($magic['name'] && $row['type'] == 50) {
			$ret .= "<font color=maroon>��������:</font> ".$magic['name']."<BR>";
		}
		if ($row['text'] && $row[type]==3) {
			$ret .= "�� ����� ������������� �������:<center>".$row['text']."</center><BR>";
		}
		if ($row['text'] && $row[type]==5) {
			$ret .= "�� ������ ������������� �������:<center>".$row['text']."</center><BR>";
		}
		if ($row['present_text']) {
			$ret .= "�� ������� ������� �����:<br />".$row['present_text']."<BR>";
		}
		if ($incmagic['max']) {
			$ret .= "�������� �������� <img src=\"http://i.oldbk.com/i/magic/".$incmagic['img']."\" title=\"".$incmagic['name']."\"> ".$incmagic['cur']."/".$incmagic['max']." ��.<BR> ";
			if ($incmagic['nlevel'] > $user['level']) {
				$ret .= "<font color=red>��������� �������: ".$incmagic['nlevel']."</font>";
			} else {
				$ret .= "��������� �������: ".$incmagic['nlevel'];
			}
			$ret .= "<br>";
		}
		if($incmagic['max']) {
			$ret .= "�-�� �����������: ".$incmagic['uses']."<br>";
		}
		if ($row['labonly']==1) {
			$ret .= "<small><font color=maroon>������� �������� ����� ������ �� ���������</font></small><BR>";
		}
		if(!$row['isrep']) {
			$ret .= "<small><font color=maroon>������� �� �������� �������</font></small><BR>";
		}
	} else { 
		$ret .= "<font color=maroon><B>�������� �������� �� ����������������</B></font><BR>";
	}

	if ($row['type'] == 27)	{
		$ret .= "�����������:<br>� ����� ��������� �� �����<br>";
	} elseif ($row['type'] == 28) {
		$ret .= "�����������:<br>� ����� ��������� ��� �����<br>";
	}


	if  (($row['ab_mf'] > 0) or ($row['ab_bron'] > 0) or ($row['ab_uron']>0) || ($row['prototype'] >= 55510301 && $row['prototype'] <= 55510401)) {
		
/*
		$ekr_elka = array(55510312,55510313,55510314,55510315,55510316,55510317,55510318,55510319,55510320,55510321,55510322,55510334,55510335,55510336,55510337,55510338,55510339);
		$art_elka = array(55510323,55510324,55510325,55510326,55510327,55510340,55510341,55510342,55510343,55510344);
*/

		$ekr_elka = array(55510350);
		$art_elka = array(55510351);

	
		$elkabonus = 0;						
		if ((($row['prototype'] >= 55510301) AND ($row['prototype'] <= 55510311)) || (($row['prototype'] >= 55510328) AND ($row['prototype'] <= 55510333))) {
			//�������� ����
			$elkabonus = 1;
		} elseif (in_array($row['prototype'],$ekr_elka)) {
			//������� ����
			$elkabonus = 2;
		} elseif (in_array($row['prototype'],$art_elka)) {
			//������� ����
			$elkabonus = 3;
		}
		if ($elkabonus > 0) {
			$ret .= "� ������� �����:+".$elkabonus."%<br>";
		}

		if ($row['prototype'] == 55510351)
		{
			$ret .= "� �����:+10%<br>";
		}
		
		
	} elseif (($_SERVER['PHP_SELF'] == '/cshop.php') AND (($row['id']>=6000) AND ($row['id'] <=6017))) {
		$runs_5lvl_param=array(
			"6000" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6001" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6002" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6003" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6004" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6005" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6006" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6007" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6008" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6009" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6010" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6011" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6012" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6013" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6014" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
			"6015" =>array("ab_mf"=>0,"ab_bron"=>0,"ab_uron"=>1),
			"6016" =>array("ab_mf"=>0,"ab_bron"=>3,"ab_uron"=>0),
			"6017" =>array("ab_mf"=>1,"ab_bron"=>0,"ab_uron"=>0),
		);

		//������ ����������� ��� � cshop
		$ab = $runs_5lvl_param[$row[id]];
		$ret .= "��������:<br>";

		if ($ab['ab_mf'] > 0) $ret .= "� ������������� ��.:0%<br>";
		if ($ab['ab_bron'] > 0) $ret .= "� �����:0%<br>";
		if ($ab['ab_uron'] > 0) $ret .= "� �����:0%<br>";
	}

	//����������� ��������� �� �����
	if (($row['bonus_info']!='') or ($row['charka']!='') )
		{
		$bohtml=array(
		'bron1' => '����� ������',
		'bron2' => '����� �������',
		'bron3' => '����� �����',
		'bron4' => '����� ���',
		'ghp' =>'������� �����' ,
		'mfkrit' =>'��. ����������� ������' ,
		'mfakrit' => '��. ������ ����. ������' ,
		'mfuvorot' => '��. ������������', 
		'mfauvorot' =>'��. ������ ��������.',
		'gsila' =>'����' ,
		'glovk' => '��������' ,
		'ginta' => '��������', 
		'gintel' =>'���������',
		'gmp' =>'��������',
		
		'fstat' =>'��������� ����������',
		'fmf' =>  '��������� ���������� ��' ,
		'gw' => '���������� �������� �������' ,
		 'gm' => '���������� ���������� c�����',
		
		'gnoj' =>'���������� �������� ������ � ���������' ,
		'gtopor' =>'���������� �������� �������� � ��������',
		'gdubina' => '���������� �������� ��������, ��������', 
		'gmech' =>'���������� �������� ������',
		'gfire' =>'���������� ���������� c����� ����',
		'gwater' => '���������� ���������� c����� ����',
		'gair' => '���������� ���������� c����� �������',
		'gearth' => '���������� ���������� c����� �����',
		'ab_mf' =>'�������� ������������� ��',
		'ab_bron' => '�������� �����',
		'ab_uron' => '�������� �����');
		
		$pp=array(
		'mfkrit' =>'%' ,
		'mfakrit' => '%' ,
		'mfuvorot' => '%', 
		'mfauvorot' =>'%',
		'ab_mf' =>'%',
		'ab_bron' => '%',
		'ab_uron' => '%');
		
			if ($row['bonus_info']!='')
			{
				$inputbonus=unserialize($row['bonus_info']); //��� ������
			if (is_array($inputbonus))
				{
					$ret .= "<small><b><a onclick=\"showhide('art_{$row['id']}');\" href=\"javascript:Void();\">������ ���������:</a></small><BR>";
					$ret .= "<div id=art_{$row['id']} style=\"display:none;\"><small><b>";
					ksort($inputbonus);
					foreach($inputbonus as $blevl => $bdata) {
						$outtxt = 'X';
						if ($blevl == 1) $outtxt = 'I';
						if ($blevl == 2) $outtxt = 'II';
						if ($blevl == 3) $outtxt = 'III';
						if ($blevl == 4) $outtxt = 'IV';
						if ($blevl == 5) $outtxt = 'V';
						if ($blevl == 6) $outtxt = 'VI';

						$ret .= "&nbsp;&nbsp;��������� {$outtxt} ������:<br>";
								foreach($bdata as $k => $v)											
									{
									$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
									}
						}
					$ret .= "</b></small></div>";						
				}
			}
			if ($row['charka']!='')
			{

			$charka=substr($row['charka'], 2,strlen($row['charka'])-1); //���������� ������ ��� �������
			$inputbonus=unserialize($charka); //��� ������

			if (is_array($inputbonus))
				{
					$ret .= "<small><b><a onclick=\"showhide('art_{$row['id']}');\" href=\"javascript:Void();\">������ ���������:</a></small><BR>";
					$ret .= "<div id=art_{$row['id']} style=\"display:none;\"><small><b>";
					ksort($inputbonus);
					foreach($inputbonus as $blevl => $bdata)			
						{

						$outtxt = 'X';
						if ($blevl == 1) $outtxt = 'I';
						if ($blevl == 2) $outtxt = 'II';
						if ($blevl == 3) $outtxt = 'III';
						if ($blevl == 4) $outtxt = 'IV';
						if ($blevl == 5) $outtxt = 'V';
						if ($blevl == 6) $outtxt = 'VI';

						$ret .= "&nbsp;&nbsp;��������� {$outtxt} ������:<br>";
								foreach($bdata as $pk => $pv)											
									{
									foreach($pv as $k => $v) 
										{
										$ret .= "&nbsp;&nbsp;� ".$bohtml[$k].": +{$v}".$pp[$k]."<br>";
										}
									}
						}
					$ret .= "</b></small></div>";						
				}			
			}
			

				
	}


	if (isset($_GET['otdel']) && in_array($_GET['otdel'],$unikrazdel) && ($_SERVER['PHP_SELF'] == "/_eshop.php" || $_SERVER['PHP_SELF'] == "/eshop.php")) {
		$ret .= "<small><b><a onclick=\"showhide('unik_{$row['id']}');return false;\" href=\"#\">�����������:</a></small><BR>";
		$ret .= "<div id=unik_{$row['id']} style=\"display:none;\"><small><b>";


		if ($row['gsila'] > 0 || $row['glovk'] > 0 || $row['ginta'] > 0 || $row['gintel'] > 0 || $row['gmudra'] > 0) {
			$ret .= "� �����: +3<br>";
		}
		if ($row['ghp'] > 0) $ret .= "� ������� �����: +20<br>";
		if ($row['bron1'] > 0 || $row['bron2'] || $row['bron3'] || $row['bron4']) $ret .= "� �����: +3<br>";

		$ret .= "</b></small></div>";
	}

	if (($row['idcity']==1) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'avaloncity.oldbk.com'))) {
		$ret .= "<small>������� � AvalonCity</small>";
	} elseif (($row['idcity']==2) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'angelscity.oldbk.com'))) {
		$ret .= "<small>������� � AngelsCity</small>";
	} elseif (($row['idcity'] == 0) OR (($row['idcity'] == null) AND ($_SERVER["SERVER_NAME"] == 'capitalcity.oldbk.com'))) {
		$ret .= "<small>������� � CapitalCity</small>";
	}
			
	if($row['unik']==1) {
		$ret .= "<br><font color=red><small><b>���� � ���������� ������������.</b></small></font>";
	}
	elseif(($row['unik']==2) and ($row['type']!=200) )  {
		$ret .= "<br><font color=#990099><small><b>���� � ���������� ���������� ������������.</b></small></font>";
	}
	
	if($row['type'] == 555) {
		$ret .= "<br><small><font color=red>������ ������ �������� �� ����������� � �������. �������� ������ �� ����� ����� � ��������� ����������. ������� ������ ����� ��������� �� ������ � ���� ���� - <a target=_blank href=http://oldbk.com/forum.php?topic=228962139>http://oldbk.com/forum.php?topic=228962139</a>. ������������� �����</red></small>"; 
	}
	
	

		if (($row['bs_owner']==0) and ($user['ruines']==0) and ($row['labonly']==0) and ($row['prototype']!=55510000)  )
		{
		$ups_types=array(1,2,3,4,5,8,9,10,11);
		$ebarr=array(128,17,149,148);
		
		
		if ((strpos($row['name'], '[') == true) AND (in_array($row['prototype'],$ebarr) ) )
		{
		$ret .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ ���� ����� � ��������� ����������, ����� ���  ���������� ���������� ����� 00:00 27.09.14.</red></small>";
		}
		else
		if ((strpos($row['name'], '[') == true) AND ($row['art_param']!='') )
		{//�� ����� ������:
		$ret .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ � ������������ ������, ����� ���  ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 		
		}
		elseif ((strpos($row['name'], '[') == true) AND (($row['type']==28) OR $row['prototype']==100028 OR $row['prototype']==100029 OR $row['prototype']==173173 OR $row['prototype']==2003 OR $row['prototype']==195195) )
		{
		//�� ����� ������� ���� �������:
		$ret .= "<br><small><font color=red>��������! ��� ���� ���������� ��������� �������� � ��������� ����������, ����� ��� ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 			
		}
		elseif ( (strpos($row['name'], '[') == true) AND (in_array($row['type'],$ups_types)) AND $row['ab_mf']==0  AND $row['ab_bron']==0  AND $row['ab_uron']==0   ) // �� ���� ���� 
		{
		//�� �������	
		$ret .= "<br><small><font color=red>��������! ��� ���� �������� ����������� ������ � ��������� ����������, ����� ��� ���������� ���������� ����� 00:00 27.09.14.</red></small>"; 
		}		
		}
	
	if($row['type']==556) {
		$ret .= "<br><small><font color=red>������ ������� ������� �� ����������� � �������. ������������� �����</red></small>"; 
	}		
	$ret .= "</td></TR>";
	if ($retdata > 0) {
		return $ret;
	} else {
		echo $ret;
	}
}

	
	
	
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content=no-cache>
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<SCRIPT src='i/commoninf.js'></SCRIPT>
<script type="text/javascript" src="/i/globaljs.js"></script>
<SCRIPT>


function showhide(id)
	{
	 if (document.getElementById(id).style.display=="none")
	 	{document.getElementById(id).style.display="block";}
	 else
	 	{document.getElementById(id).style.display="none";}
	}
</SCRIPT>

</HEAD>
<body bgcolor=e2e0e0><div id=hint3 class=ahint></div><div id=hint4 class=ahint></div>
<H3>�������� ����������</H3>
	
	<?
	
	
		if (($_POST['fbyproto'])  or  ($_POST['fbyname']) )
				{
			
									if ($_POST['fbyproto'])
									{
									$proto=(int)($_POST['findproto']);									
									echo "<h5>���������� ������ �� ���������: {$proto}</h5>";												
									$sql=" id='{$proto}'  ";
									}
									elseif ($_POST['fbyname'])
									{
									$name=mysql_real_escape_string($_POST['findname']);									
									echo "<h5>���������� ������ �� ��������: {$name}</h5>";			
									$sql=" name like '%{$name}%'";
									}
					
					
						echo "<h4>����� {$shops[$i]['name']} </h4>";
						
						$data=mysql_query("select * from oldbk.shop where {$sql} AND (type <12 OR type=28 OR type=27) order by id desc");

						$kol_f=mysql_num_rows($data);
						if ($kol_f >0)
							{
							echo "<table border=1  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";							
							while($row=mysql_fetch_array($data))
									{
									if ($col==0) { $col = 1; $color = '#C7C7C7';} else { $col = 0; $color = '#D5D5D5';}
									echo "<tr BGCOLOR={$color}>";
									echo "<td align=center><IMG SRC=\"http://i.oldbk.com/i/sh/{$row['img']}\" BORDER=0><br>
									<small>{$row['cost']} ��. <br> {$row['ecost']} ���. <br> {$row['repcost']} ���. <br>
									(PROTO_ID:{$row['id']}) 
									
									  <form method=\"post\">
									  <input name=\"new_it\" type=\"hidden\" value='".$row[id]."'>
								          &nbsp;<input type=submit value=�������������>
									</form>
									</small></td>";
									
									echo "<td>";
									if ($row[count]<=0) { $row[count]=1; }
									

									showitem ($row,0,false,$color,'',0, 0,0,'');
									echo "</td>";
									echo "</tr>";
									}
							echo "</table>";
							}
							else
							{
							echo "�������� �� ������!";
							}
				}
				elseif ($_POST[new_it])
								{

								$ret = "";
								$itm=(int)$_POST[new_it];
									
										
										
											if($_POST[savecopy])
											{
											//echo "TEst 1";
											
											unset($_POST[savecopy]);					
											unset($_POST[new_it]);		
												
												//������ ��������
												$citem=mysql_fetch_assoc(mysql_query("select * from oldbk.shop where id='{$itm}'  AND (type <12 OR type=28 OR type=27) "));
												
												if ($citem['id']>0)
												{
												$stop=true;
						
						
												if ($citem['new_item']==1)
												{
												//����������� ����� ������� ������ ������
														$stop=false;
												}
												else
													{
													//��� ������ �������  = ������� ����� �� ���������
													
														$get_last_ok_id=mysql_fetch_assoc(mysql_query("select * from shop where (id>=40000 and id<=50000) order by id desc limit 1"));
														$new_next_id=($get_last_ok_id[id]+1);
														if ($new_next_id>50000)
															{
															 echo "<b><font color=red>������! ����������� ��������� id ��� ����������</font></b>";	
															}
															else
															{
															$stop=false;
															}
													}
													
													
													
													if ($stop!=true)
													{
													
															//����������� ���������
															foreach($_POST as $k => $v) 
																{
																$citem[$k]=$v;
																}
																
															$citem['count']=0;															
															$citem['avacount']=0;																
															$citem['angcount']=0;	
															$citem['wopen']=0;																
															$citem['unikflag']=0;
															

													
															
														if ($citem['new_item']==1)
														{
															//������� ����� 
															foreach($citem as $k => $v) 
																{
																$sqlstr.="`".mysql_real_escape_string($k)."`='".$v."' , ";
																}														
														//������
														

														$sqlstr=substr($sqlstr,0,-2);
														mysql_query('update oldbk.shop  set '.$sqlstr.'   where id='.$citem['id']);
														
														if (mysql_affected_rows()>0) 
															{
															 echo "<b><font color=red>��� ��������� ������� ���������! �������� ������� {$citem['name']} </font></b>";	
															}
															else
															{
															 echo "<b><font color=red>������! ".mysql_error()."</font></b>";	
															}
														
														

														
														}
														else
														{
														
																$citem['id']=$new_next_id;
																$citem['new_item']=1;	
																$citem['dressroom']=0;	
																$citem['artproto']=0;
																
																
																
															//������� ����� 
															foreach($citem as $k => $v) 
																{
																$sqlstr.="`".mysql_real_escape_string($k)."`='".$v."' , ";
																}																															
													
														$sqlstr=substr($sqlstr,0,-2);
														mysql_query('insert into  oldbk.shop  set '.$sqlstr.' ; ');
														if (mysql_affected_rows()>0) 
															{
															$new_cr_id=mysql_insert_id();
															 echo "<b><font color=red>��� ��������� ������� ���������! ������ ����� ������� {$citem['name']} ['".$new_cr_id."'] </font></b>";	
															$itm=$new_cr_id;
															}
															else
															{
															 echo "<b><font color=red>������! ".mysql_error()."</font></b>";	
															}
														}
													}
												}
												else
													{
													 echo "<b><font color=red>������! �������� �� ������!</font></b>";	
													}
											}
								
								
									
									$q=mysql_query("select * from oldbk.shop where id='{$itm}'  AND (type <12 OR type=28 OR type=27) ");
									


									if (mysql_num_rows($q) > 0) 
									{
										$ret .= "<table border=2  WIDTH=100% CELLSPACING='0' CELLPADDING='2' BGCOLOR='#A5A5A5'>";
										while($row = mysql_fetch_assoc($q)) 
										{
											if ($ff==0) { $ff = 1; $color = '#C7C7C7';} else { $ff = 0; $color = '#D5D5D5'; }
								
											$ret .= showitem_edit($row,0,false,$color,'',0,0,1);
										}
										$ret .= "</table>";
									
									echo "<form method=post>";
									echo "<input name=new_it type=hidden value=".$itm.">";
									echo $ret;
									echo "<input type=submit name=savecopy value='���������'><br></form>";
									} 
									else
									{
									 echo "<b><font color=red>������! ".mysql_error()."</font></b>";	
									}
								}





		echo "<hr>";
		echo "<form method=post>";
		echo "����� �� ��������� <input type=text name='findproto' value='".(int)($_POST['findproto'])."'>";	echo "<input type=submit name='fbyproto' value='�����'><br>";
		echo "����� �� ��������<input type=text name=findname value='".mysql_real_escape_string($_POST['findname'])."'>";	echo "<input type=submit name='fbyname' value='�����'><br>";
		echo "</form>";				

		
	
	?>




</BODY>
</HTML>

