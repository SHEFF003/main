<?
//��������� ����� ������� ������ 0 - ������� 10
// mob id - kol

$mt_rand_23=mt_rand(2,3);
$mt_rand_34=mt_rand(3,4);
$mt_rand_45=mt_rand(4,5);

$mob[1]= array(
		"name" => "������",
		"id"=>263,
		"kol" => 1);		

$mob[2]= array(
		"name" => "������",
		"id"=>264,
		"kol" => $mt_rand_23);		


$mob[3]= array(
		"name" => "������",
		"id"=>265,
		"kol" => $mt_rand_23);		


$mob[4]= array(
		"name" => "������",
		"id"=>269,
		"kol" => $mt_rand_23);		

$mob[5]= array(
		"name" => "��������",
		"id"=>271,
		"kol" => $mt_rand_34);		


$mob[6]= array(
		"name" => "�����",
		"id"=>272,
		"kol" => 1);		

	
/*
$mob[20]= array(
		"name" => "��������",
		"id"=>273,
		"kol" => $mt_rand_34);		

*/

//////////
$sjmob[1]= array(
		"name"=> "��������",
		"id" => 273);


////////////��������� ����� ��� J-�����


$jmob[1]= array(
		"name"=> "�����",
		"id" => 228,
		"top"=>5, 
		"left" =>50 );		

$jmob[2]= array(
		"name"=> "�������",
		"id" => 274,
		"top"=>50, 
		"left" =>110 );		

$jmob[3]= array(
		"name"=> "������ �����",
		"id" => 276,
		"top"=>50, 
		"left" =>95 );			

$jmob[4]= array(
		"name"=> "������",
		"id" => 277,
		"top"=>43, 
		"left" =>115 );			

$jmob[5]= array(
		"name"=> "��������",
		"id" => 278,
		"top"=>60, 
		"left" =>90 );			

/////////////////////////////////////////////////	
//��������� �������  ������� 0 - ������� - 10
// ���� ���� � ����������  � �����
$lov[0]=array(
// magic - time min
		"timer_trap" => "13" // ���� 
		);

$lov[1]=array(
// magic - time min
		"poison_trap" => "14" // �� 
		);

$lov[2]=array(
// magic - time min
		"stat_trap" => "16" // �����
		);

$lov[3]=array(
// magic - time min
		"poison_trap" => "18" // �� 
		);
		
///////////////////////////////////////////////
//��������� �����
// ���� ���� � ����������  � �����

$hils[0]=array(
		"H" => 50 // 50%
		);

$hils[1]=array(
		"H" => 50 // 50%
		);

$hils[2]=array(
		"H" => 50 // 50%
		);

$hils[3]=array(
		"H" => 60 // 60%
		);

$hils[4]=array(
		"H" => 75 // 75%
		);

$hils[5]=array(
		"H" => 80 // 80%
		);


/////////////////////////////////////////////////
// ��������� BOX-��
//��� ��� � �������� ����� �������� �� ����
//����� ���������� ������� � ������!

$pbox[0]=array(
		"alzss" => 3006, 
		"pvedro" => 4306,
		"antidot" => 4000		
		);
$pbox[1]=array(
		"items" => 3002, // ��������� ��� - � ���������� �� �� ���������
		"pvedro"=>4306		
	      ); 
$pbox[2]=array(
		"buter" => 105, 
		"gold" => 3013,
		"pvedro"=>4306
		);
$pbox[3]=array(
		"poison_trap" => "8" // �� �� 8 ���
		);

$pbox[4]=array(
		"almaz" => 3006,
		"ugolk" => 3014, 	
		"vostanovlenie_HP" => 246			
		);

$pbox[5]=array(
		"gold" => 3009,
		"pvedro"=>4306
		);
/////////////////////////////////////////////////
	
//��������� ����� �� �������� ������� 0 - ����� - 10
// labonly - ���������� ������ �� ����

$sund[0]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "195"
			);

$sund[1]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "208"
			);

$sund[2]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "204"
			);


$sund[3]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "201"
			);
			
$sund[4]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "205"
			);


$sund[5]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "198"
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