<?
// drop list for fsystem
$DROP=true;
$DROP_noob=true;

	// setings:
	$MIN_DROP_DM=1; // ����������� ����
	$MIN_DROP_EXP=1; // 0 - ��� ;
	$MIN_DROP_LEVEL=1;
	$DROP_CHANSE=70; 

	//list:	#97, 98 , 99 , 100
	
	$items[0] = array(
			 "shop" => "shop", // ����� �����
	 		 "id" => "98" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "magic" => 10,			 
			 "cost"=>0,
	 		 "present"=> "�����"
		);

		
	$items[1] = array(
			 "shop" => "shop", // ����� �����
	 		 "id" => "100" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "magic" => 12,
			 "cost"=>0,
	 		 "present"=> "�����"
		);	

//	if (mt_rand(1,4)==4)
		{
	$items[2] = array(
			 "shop" => "shop", // ����� �����
	 		 "id" => "4005" , // �� �� ������ - ����������� ������
			 "maxdur" => "1",
			 "magic" => 66,
			  "goden"=> 30,
			 "cost"=>0,
			 "notsell"=>1,
	 		 "present"=> "�����"
			);		

		}
		

?>
