<?php
if (!($_SESSION['uid'] >0)) header("Location: index.php");

if ($_POST['target'] != '') {
	if ($user['battle'] > 0) {
		echo "�� � ���...";
	} else {
	    	$row = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE bs_owner=0 AND (sowner = 0 or sowner = ".$user['id'].") AND (arsenal_klan = '' OR arsenal_owner=1 ) AND present!='�������� �����'  AND  prokat_idp = 0 AND `dressed` = 0 AND owner=".$_SESSION['uid']." AND name like '%(��)%'  AND `setsale`=0 and id = ".intval($_POST['target'])));
		if ($row !== false) {
			$magictoitem = $row;
			$magictoitem['add_info'] = "+1 �����";
			$rr=array('bron1','bron2','bron3','bron4','ghp','delta_stat');

		    	$newit = downgrade_item($row,$rr,1,1);
			if ($newit['add_bron'] > 0) {
				$fields=array('bron1','bron2','bron3','bron4');
				$addfields=array('add_bron','add_bron','add_bron','add_bron');

				$str = "";

			    	for($q=0;$q<count($addfields)&&$q<4;$q++) {
			    		$str.=$fields[$q].' = if('.$fields[$q].'>0,'.$fields[$q].' + 1,'.$fields[$q].'), ';
				}
	
				$str = substr($str,0,-2);

				if (strlen($row['mfinfo'])) {
					$mfinfo = unserialize($row['mfinfo']); 
					$mfinfo['bron']++;
					$mfinfo = serialize($mfinfo);
					$str .= ', mfinfo = "'.mysql_real_escape_string($mfinfo).'" ';
				}
		
	
				$str = 'UPDATE oldbk.inventory set '.$str.' WHERE id = '.intval($_POST['target'].' LIMIT 1');
				mysql_query($str);
				$bet=1;
				$sbet = 1;
				$MAGIC_OK=1;
				echo '���� ������ �����������';
			} else {
				echo '���� �� ��������� � ��������';
			}		
		} else {
			echo '���� �� �������';
		}
	}
}

?>