<?
//��������� ����� ������� ������ 0 - ������� 10
// mob id - kol

$mt_rand_23=mt_rand(2,3);
$mt_rand_34=mt_rand(3,4);
$mt_rand_45=mt_rand(4,5);


$mob[1]= array(
		"name" => "�����a",
		"id" => 267,
		"kol" => 1);		
		
$mob[2]= array(
		"name" => "������",
		"id" => 264,
		"kol" => $mt_rand_23,
		);

$mob[3]= array(
		"name" => "�a��a��",
		"id"=>268,
		"kol" => 1);
		
$mob[4]= array(
		"name" => "�������",
		"id"=>266,
		"kol" => $mt_rand_34);

$mob[5]= array(
		"name" => "������",
		"id"=>265,
		"kol" => $mt_rand_34);

$mob[6]= array(
		"name" => "�����a",
		"id"=>267,
		"kol" => $mt_rand_34);		
		
	
/*
$mob[13]= array(
		"name" => "������",
		"id"=>263,
		"kol" => 1);		
*/		

//////////
$sjmob[1]= array(
		"name"=> "������",
		"id" => 263);

////////////��������� ����� ��� J-�����

$jmob[1]= array(
		"name"=> "������",
		"id" => 223,
		"top"=>28, 
		"left" =>68 );
$jmob[2]= array(
		"name"=> "�������",
		"id" => 224,
		"top"=>25, 
		"left" =>80 );

$jmob[3]= array(
		"name"=> "������",
		"id" => 227,
		"top"=>25, 
		"left" =>80 );		
		
		
$jmob[4]= array(
		"name"=> "�����",
		"id" => 228,
		"top"=>5, 
		"left" =>50 );		
								
/////////////////////////////////////////////////	
//��������� �������  ������� 0 - ������� - 10
// ���� ���� � ����������  � �����
$lov[0]=array(
// magic - time min
		"timer_trap" => "8" // ���� 
		);

$lov[1]=array(
// magic - time min
		"poison_trap" => "11" // �� 
		);

$lov[2]=array(
// magic - time min
		"stat_trap" => "10" // �����
		);

$lov[3]=array(
// magic - time min
		"poison_trap" => "15" // �� 
		);
		
///////////////////////////////////////////////
//��������� �����
// ���� ���� � ����������  � �����

$hils[0]=array(
		"H" => 30 // 30%
		);

$hils[1]=array(
		"H" => 30 // 30%
		);
		
$hils[2]=array(
		"H" => 40 // 40%
		);

$hils[3]=array(
		"H" => 50 // 50%
		);

$hils[4]=array(
		"H" => 50 // 50%
		);

$hils[5]=array(
		"H" => 60 // 60%
		);

/////////////////////////////////////////////////
// ��������� BOX-��
//��� ��� � �������� ����� �������� �� ����
//����� ���������� ������� � ������!

$pbox[0]=array(
		"almaz" => 3015,
		"pvedro"=>4306,
		"buter" => 105, 		
		);
$pbox[1]=array(
		"timer_trap" => "15" //���� �� 8 ���		
		);
$pbox[2]=array(
		"alzss" => 3006, 
		"pvedro" => 4306
		);
$pbox[3]=array(
		"items" => 3002, // ��������� ��� - � ���������� �� �� ���������
		"pvedro"=>4306		
	      ); 
$pbox[4]=array(
		"buter" => 105, 
		"gold" => 3013,
		"pvedro"=>4306
		);
$pbox[5]=array(
		"poison_trap" => "8" // �� �� 8 ���
		);
/////////////////////////////////////////////////
	
//��������� ����� �� �������� ������� 0 - ����� - 10
// labonly - ���������� ������ �� ����


$sund[0]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "200"
			);

$sund[1]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "210"
			);


$sund[2]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "209"
			);


$sund[3]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "197" ///!!!
			);

$sund[4]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "1",
 		 "present"=> "",
		 "id" => "50176"
			);

$sund[5]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "196" 
			);

////��������� ��� ���������� �����
// [id] - ����� � ����� ��������
/// ���� ����� � ������� ��� �� ��������������

$reitem[210]=1;
$reitem[209]=1;
$reitem[208]=1;
$reitem[206]=1;
$reitem[205]=1;
$reitem[204]=1;
$reitem[203]=1;
$reitem[202]=1;
$reitem[201]=1; 
$reitem[200]=1;
$reitem[199]=1;
$reitem[198]=1;
$reitem[197]=1;
$reitem[196]=1;
$reitem[195]=1;

include ("labconfig_4.php"); // ��������� ����� � ����� 		
?>