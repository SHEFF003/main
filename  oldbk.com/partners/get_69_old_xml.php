<?	
	require_once('../mysql-ext.php');

	//������������ ������� � �� �������������.	
	$passcode = 'dyJc31gt';
	$pid=69;
	// ------- CONFIG -----------
	header ("content-type: text/xml");
	/*echo '<?xml version="1.0" encoding="UTF-8" ?>';*/
	//���������� � �� �������������.
	$db = @mysql_connect("oldbkfastdb.c4c2zvyoc0zt.eu-west-1.rds.amazonaws.com","oldbk","Psh2nDye09hlq29mz");

	if(!$db){
		echo '<error>DB ERROR</error>';
		die;
	} else {
		mysql_select_db ("oldbk") or die('<error>DB ERROR</error>');
	}

/*
	try {
		//��������� XML �� ���������� �������, ������� �������� �������� ���������� �������
		$xml = @new SimpleXMLElement($_POST['xml']);
		//���� � UNIX TIMESTAMP
		$date_from = (int) $xml->date_from;
		$date_to = (int) $xml->date_to;
	} catch (Exception $e) {
		echo '<error>REQUEST ERROR</error>'; die;
	}
*/


	if ($_REQUEST['pass'] != md5($passcode)) {
		echo '<error>AUTH ERROR</error>'; 
		die;
	}
	
	//��������� XML-������ ��� ���������� ��������
	/*echo '<?xml version="1.0"?>';*/
	echo '<items>';
	
       $date_from=(int)($_REQUEST[date1]);
       $date_to=(int)($_REQUEST[date2]);

	//������� ������ ��� XML-������ �� ������� � �� �������������
	$squl='SELECT *  FROM  xml_data_69 WHERE lbid=461 and stamp >= '.$date_from.' AND  stamp <= '.$date_to.' ORDER BY id';
	//echo $squl;
	$res = mysql_query($squl);
	while ($row = mysql_fetch_assoc($res)) 
	{
	echo '<item>';
		echo '<id>'.$row[trid].'</id>';
		echo '<sid>'.$row[sid].'</sid>';
	        echo '<lbid>'.$row[lbid].'</lbid>';
	        echo '<status>1</status>';	        
	        echo '<price>'.$row[price].'</price>';
	        echo '<date>'.date("Y-m-d H:i:s",$row[stamp]).'.'.$row[micro].'</date>';
	echo '</item>';		
	}
	echo '</items>';

?>
