<?
// drop list for fsystem

$DROP=false;

//if ((time() >= mktime(0,0,0,10,13) && time() <= mktime(23,59,59,11,13))) 
if (false) // ������ 2016
	{
	$DROP=true;
	// setings:
	$MIN_DROP_DM=1; // ����������� ����
	$MIN_DROP_EXP=1; // 0 - ��� ;
	$MIN_DROP_LEVEL=4;
	$DROP_CHANSE=98; //50% �� ��� �����

///���������� ����
	//list:
	$items[0] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "304013" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=> round((mktime(23,59,59,11,13)-time())/60/60/24),
			 "dategoden"=> mktime(23,59,59,11,13),
	 		 "present"=> "Halloween"
		);

	$items[1] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "304014" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>round((mktime(23,59,59,11,13)-time())/60/60/24),
			 "dategoden"=> mktime(23,59,59,11,13),
	 		 "present"=> "Halloween"
		);

	$items[2] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "304015" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>round((mktime(23,59,59,11,13)-time())/60/60/24),
			 "dategoden"=> mktime(23,59,59,11,13),
	 		 "present"=> "Halloween"
		);

	$items[3] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "304016" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>round((mktime(23,59,59,11,13)-time())/60/60/24),
			 "dategoden"=> mktime(23,59,59,11,13),
	 		 "present"=> "Halloween"
		);

	$items[4] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "304017" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>round((mktime(23,59,59,11,13)-time())/60/60/24),
			 "dategoden"=> mktime(23,59,59,11,13),
	 		 "present"=> "Halloween"
		);

	$items[5] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "304018" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>round((mktime(23,59,59,11,13)-time())/60/60/24),
			 "dategoden"=> mktime(23,59,59,11,13),
	 		 "present"=> "Halloween"
		);

	$items[6] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "304019" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>round((mktime(23,59,59,11,13)-time())/60/60/24),
			 "dategoden"=> mktime(23,59,59,11,13),
	 		 "present"=> "Halloween"
		);
	
}
else
	if ( ( (time()>mktime(0,0,1,4,1,date("Y"))) and (time()<mktime(23,59,59,4,7,date("Y"))) )   )  
	{
	//list: ��������������� ���� ����
	
	$DROP=true;
	// setings:
	$MIN_DROP_DM=1; // ����������� ����
	$MIN_DROP_EXP=1; // 0 - ��� ;
	$MIN_DROP_LEVEL=4;
	$DROP_CHANSE=98; 
	$APRIL=true;
	
	$items[0] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "404001" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"7",
			 "dategoden"=> mktime(23,59,59,4,7),
	 		 "present"=> ""
		);

	$items[1] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "404002" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"7",
			 "dategoden"=> mktime(23,59,59,4,7),
	 		 "present"=> ""
		);

	$items[2] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "404003" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"7",
			 "dategoden"=> mktime(23,59,59,4,7),
	 		 "present"=> ""
		);

	$items[3] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "404004" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"7",
			 "dategoden"=> mktime(23,59,59,4,7),
	 		 "present"=> ""
		);
	$items[4] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "404005" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"7",
			 "dategoden"=> mktime(23,59,59,4,7),
	 		 "present"=> ""
		);
	$items[5] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "404006" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"7",
			 "dategoden"=> mktime(23,59,59,4,7),
	 		 "present"=> ""
		);
	}
	
//print_r($items);
?>
