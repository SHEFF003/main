<?
// drop list for fsystem
//$DROP=true;

$DROP=false;

if ((time() >= mktime(0,0,0,4,1) && time() <= mktime(23,59,59,4,1))) {
	$DROP=true;

	// setings:
	$MIN_DROP_DM=1; // ����������� ����
	$MIN_DROP_EXP=1; // 0 - ��� ;
	$MIN_DROP_LEVEL=4;
	$DROP_CHANSE=75; //50% �� ��� �����

	//list:
	$items[0] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "300407" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"1",
			 "dategoden"=> mktime(0,0,0,4,2),
	 		 "present"=> ""
		);

	$items[1] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "300408" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"1",
			 "dategoden"=> mktime(0,0,0,4,2),
	 		 "present"=> ""
		);

	$items[2] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "300409" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"1",
			 "dategoden"=> mktime(0,0,0,4,2),
	 		 "present"=> ""
		);

	$items[3] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "300410" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"1",
			 "dategoden"=> mktime(0,0,0,4,2),
	 		 "present"=> ""
		);
	$items[4] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "300411" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"1",
			 "dategoden"=> mktime(0,0,0,4,2),
	 		 "present"=> ""
		);
	$items[5] = array(
			 "shop" => "eshop", // ����� �����
	 		 "id" => "300412" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "cost"=>0,
			 "goden"=>"1",
			 "dategoden"=> mktime(0,0,0,4,2),
	 		 "present"=> ""
		);

}

?>
