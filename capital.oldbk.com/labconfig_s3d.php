<?
//��������� ����� ������� ������ 0 - ������� 10
// mob id - kol

$mt_rand_23=mt_rand(2,3);
$mt_rand_34=mt_rand(3,4);
$mt_rand_45=mt_rand(4,5);

$mob[1]= array(
		"name" =>"�������� ���a�",
		"id" =>261,
		"kol" => 1);

$mob[2]= array(
		"name"=> "A���o���",
		"id"=>262,
		"kol" => $mt_rand_23);

$mob[3]= array(
		"name" =>"�������� ���a�",
		"id" =>261,
		"kol" =>$mt_rand_23);

$mob[4]= array(
		"name" =>"�������",
		"id"=>266,
		"kol" => 1);

$mob[5]= array(
		"name"=>"������",
		"id" => 263,
		"kol" => $mt_rand_23);
		
$mob[6]= array(
		"name" => "�����a",
		"id" => 267,
		"kol" => 1);		
		
$mob[7]= array(
		"name" => "������",
		"id" => 264,
		"kol" => $mt_rand_23,
		);

$mob[8]= array(
		"name" => "�a��a��",
		"id"=>268,
		"kol" => 1);
		
$mob[9]= array(
		"name" => "�������",
		"id"=>266,
		"kol" => $mt_rand_34);

$mob[10]= array(
		"name" => "������",
		"id"=>265,
		"kol" => $mt_rand_34);

$mob[11]= array(
		"name" => "�����a",
		"id"=>267,
		"kol" => $mt_rand_34);		
		
$mob[12]= array(
		"name" => "�a��a��",
		"id"=>268,
		"kol" => $mt_rand_23);		

$mob[13]= array(
		"name" => "������",
		"id"=>263,
		"kol" => 1);		

$mob[14]= array(
		"name" => "������",
		"id"=>264,
		"kol" => $mt_rand_23);		


$mob[15]= array(
		"name" => "������",
		"id"=>265,
		"kol" => $mt_rand_23);		


$mob[16]= array(
		"name" => "������",
		"id"=>269,
		"kol" => $mt_rand_23);		

$mob[17]= array(
		"name" => "��������",
		"id"=>271,
		"kol" => $mt_rand_34);		


$mob[18]= array(
		"name" => "�����",
		"id"=>272,
		"kol" => 1);		

$mob[19]= array(
		"name" => "�����",
		"id"=>272,
		"kol" => $mt_rand_23);		

$mob[20]= array(
		"name" => "��������",
		"id"=>273,
		"kol" => $mt_rand_34);		

$mob[21]= array(
		"name" => "��������",
		"id"=>271,
		"kol" => 1);		

$mob[22]= array(
		"name" => "������",
		"id"=>265,
		"kol" => $mt_rand_34);		

$mob[23]= array(
		"name" => "������",
		"id"=>264,
		"kol" => $mt_rand_45);		


$mob[24]= array(
		"name" => "������",
		"id"=>269,
		"kol" => $mt_rand_45);		

$mob[25]= array(
		"name" => "������",
		"id"=>265,
		"kol" => $mt_rand_23);		


$mob[26]= array(
		"name" => "�a��a��",
		"id"=>268,
		"kol" => $mt_rand_34);		


//////////
$sjmob[1]= array(
		"name"=> "�����",
		"id" => 270);


////////////��������� ����� ��� J-�����

$jmob[1]= array(
		"name"=> "�����",
		"id" => 219,
		"top"=>25, 
		"left" =>90 );
$jmob[2]= array(
		"name"=> "���������",
		"id" => 220,
		"top"=>7, 
		"left" =>48 );		

$jmob[3]= array(
		"name"=> "��������",
		"id" => 221,
		"top"=>25, 
		"left" =>90 );
$jmob[4]= array(
		"name"=> "��� �����",
		"id" => 222,
		"top"=>0, 
		"left" =>-5 );		
		
$jmob[5]= array(
		"name"=> "������",
		"id" => 223,
		"top"=>28, 
		"left" =>68 );
$jmob[6]= array(
		"name"=> "�������",
		"id" => 224,
		"top"=>25, 
		"left" =>80 );

$jmob[7]= array(
		"name"=> "������",
		"id" => 227,
		"top"=>25, 
		"left" =>80 );		
		
		
$jmob[8]= array(
		"name"=> "�����",
		"id" => 228,
		"top"=>5, 
		"left" =>50 );		

$jmob[9]= array(
		"name"=> "����� �����",
		"id" => 275,
		"top"=>25, 
		"left" =>90 );		

$jmob[10]= array(
		"name"=> "�������",
		"id" => 274,
		"top"=>50, 
		"left" =>110 );		

$jmob[11]= array(
		"name"=> "������ �����",
		"id" => 276,
		"top"=>50, 
		"left" =>95 );			

$jmob[12]= array(
		"name"=> "������",
		"id" => 277,
		"top"=>43, 
		"left" =>115 );			

$jmob[13]= array(
		"name"=> "��������",
		"id" => 278,
		"top"=>60, 
		"left" =>90 );			

$jmob[14]= array(
		"name"=> "����",
		"id" => 279,
		"top"=>50, 
		"left" =>135 );			
								
/////////////////////////////////////////////////	
// ��������� ����� �� �����
// $mdrop[id-����] =  "���� %" => ���� �� �� ����
// ��� ����� � ���� ����������� � ����!
//4000 - �������
//3001 -������
//3002 - �����
//3003 - �����
//3004 - ����
//3005 - ����
//3006- ������ ������
//3007 - ����� ���������� �������
//3008 -������� ������ 
//3009 -������
//3010 -�������
//3011 -�������
//3012 - �����

//������ ���� ����� ��������
$mdrop[261]=array(
		"3013" => 10,  //+
		"3014" => 10,  //+
		"3012" => 10, //�����
		"4303" =>10,
		"0" => 20 // �����
		);

$mdrop[262]=array(
		"3009" => 5,  //������
		"3011" => 5,  //�����
		"3021" => 10, //����
		"4300" =>10,		
		"3020" => 15, //�����
		"3019" => 10, //��� ���+
		"0" => 70 // �����
		);

//������ ���� ����� ��������
$mdrop[263]=array(
		"3013" => 10, //����+
		"3015" => 10, //��� ���+
		"4304" => 10,
		"0" => 60 // �����
		);

$mdrop[264]=array(
		"3006" => 5,  
		"3017" => 5, 
		"3013" => 5, 
		"3014" => 5, 
		"4303" =>10,		
		"3012" => 5, 
		"0" => 30 // �����
		);


$mdrop[265]=array(
		"3014" => 15, 
		"3015" => 15, 
		"3006" => 15, 
		"3017" => 2, 
		"3018" => 2,  
		"3011" => 2,  //�����
		"4304" => 10, 
		"0" => 30 // �����
		);


$mdrop[266]=array(
		"4304" => 10, //����+
		"3020" => 10, //����+
		"3013" => 10,  //����� 
		"3014" => 10, //������
		"0" => 30 // �����
		);

$mdrop[267]=array(
		"3019" => 10, //����+
		"3018" => 10,  //����� 
		"3017" => 10, //������
		"4304" => 20, //�������		
		"3021" => 10,  //�������
		"3020" => 10,  //�����
		"3012" => 10, //�����
		"0" => 40 // �����
		);


$mdrop[268]=array(
		"3018" => 10,  //������
		"3017" => 10,  //�����
		"3021" => 5, //����
		"4304" => 5, //�����
		"3019" => 5, //��� ���+
		"0" => 70 // �����
		);

$mdrop[269]=array(
		"3013" => 15,  //������
		"3014" => 10,  //�����
		"4303" => 10, 
		"3006" => 15, //�����
		"3017" => 10, //��� ���+
		"0" => 70 // �����
		);

$mdrop[270]=array(
		"3009" => 5,  //������
		"3011" => 5,  //�����
		"4310" => 10, //����
		"3017" => 15, //�����
		"3006" => 10, //��� ���+
		"0" => 70 // �����
		);


$mdrop[271]=array(
		"3009" => 5,  //������
		"3011" => 5,  //�����
		"3015" => 15, //����
		"3006" => 15, //�����
		"3017" => 10, //��� ���+
		"4313" => 5,
		"0" => 70 // �����
		);
////////J-mob drop
$mdrop[272]=array(
		"4313" => 50, 
		"3015" => 49,	
		"5205"=>2,//����� 180		
		"50077"	=> 3, // ������			
		"15566" => 1, //15566-��������� ������		
		"0" => 10 // �����
		);
		
$mdrop[273]=array(
		"3017" => 50, //��� 
		"3019" => 49,  	//���
		"5205"=>2,//����� 180		
		"50077"	=> 3, // ������
		"4310" => 1, //�������	
		"15566" =>1, 
		"3203"=>1,//��� 20 ��
		"0" => 10); // �����
		
$mdrop[274]=array(
		"3017" => 50, //��� 
		"3019" => 49,  	//���
		"5205"=>2,//����� 180		
		"50077"	=> 3, // ������
		"15566" =>1, //15566- ��������� ���		
		"3203"=>1,//��� 20 ��
		"0" => 10 // �����
		);		
	
$mdrop[275]=array(
		"5205"=>30,//����� 180		
		"50077"	=> 40, // ������
		"4313" =>10,
		"4304" =>10,		
		"4306" => 10,
		"4313"=>10,
		"15566" =>10, 
		"3204"=>20,//��� 20 ��
		);	
		
$mdrop[276]=array(
		"3017" => 50, //��� 
		"3019" => 49,  	//���
		"5205"=>2,//����� 180		
		"50077"	=> 3, // ������
		"4310" => 3,
//		"5000" => 2, //����					
		"15566" =>1, //15566- ��������� ���		
		"3203"=>1,//��� 20 ��
		"0" => 10); // �����
		
$mdrop[277]=array(
		"3017" => 50, //��� 
		"3019" => 49,  	//���
		"5205"=>2,//����� 180		
		"50077"	=> 3, // ������
		"4304" => 3,
		"15566" =>1, 
		"3203"=>1,//��� 20 ��
		"0" => 10 // �����
		);				
		
$mdrop[278]=array(
		"3020" => 50,
		"3021" => 49,	
		"5205"=> 2,//����� 180	
		"4303" => 2, 
		"15564" =>1, //15564-��������� ����		
		"0" => 10 // �����
		);		
	
$mdrop[279]=array(
		"3017" => 50, //��� 
		"3019" => 49,  	//���
		"5205"=>2,//����� 180		
		"50077"	=> 3, // ������
		"4304" => 5, 
		"4306" => 2, 
		"15566" =>1, //15566- ��������� ���		
		"3203"=>1,//��� 20 ��
		"0" => 10 // �����
		);			
		
$mdrop[220]=array(
		"3014" => 50,  
		"3006" => 49,
		"5205"=>2,//����� 180		  
		"50076"=> 3, // ��������		
		"15562" =>1, //��������� �����	
		"3204" =>1, //��� 50 ��
		"0" => 10 // �����
		);
$mdrop[221]=array(
		"3017" => 50, //��� 
		"3019" => 49,  	//���
		"5205"=>2,//����� 180		
		"50077"	=> 3, // ������
		"15566" =>1, //15566- ��������� ���		
		"3203"=>1,//��� 20 ��
		"0" => 10 // �����
		);
		
$mdrop[222]=array(
		"3018" => 50, //���
		"3020" => 49, //���
		"5205"=>2,//����� 180
		"50078" =>2, //�����	
		"4313" => 2, 
		"50076"=> 3, // ��������
		"0" => 10 // �����
		);
$mdrop[223]=array(
		"3020" => 50,
		"3021" => 49,	
		"5205"=> 2,//����� 180	
		"15564" =>1,
		"0" => 10 // �����
		);
		
$mdrop[224]=array(
		"3020" => 50,
		"3021" => 49,		
		"50077"	=> 3, // ������			
		"4313" => 10, //�������		
		"4310"=>10,		
		"50078" =>2, //�����	
		"0" => 10 // �����
		);

$mdrop[227]=array(
		"3020" => 49,  //������
		"3021" => 49,  //�����
		"50077"	=> 3, // ������	
		"5205"=>2,//����� 180	
		"4306" => 20, 
		"4310"=>10,
		"15563" => 1,
		"0" => 20 // �����
		);

$mdrop[228]=array(
		"3009" => 45,  //������
		"3011" => 49,  //�����
		"4306" => 2, //����				
		"15565" => 1, //15565 - ��������� ��������
		"0" => 30 // �����
		);

								

/////////////////////////////////////////////////	
//��������� �������  ������� 0 - ������� - 10
// ���� ���� � ����������  � �����
$lov[0]=array(
// magic - time min
		"timer_trap" => "5" // ���� �� 2 ���
		);

$lov[1]=array(
// magic - time min
		"poison_trap" => "2" // �� �� 2 ���
		);

$lov[2]=array(
// magic - time min
		"stat_trap" => "4" //
		);

$lov[3]=array(
// magic - time min
		"poison_trap" => "4" // �� �� 4 ���
		);


$lov[4]=array(
// magic - time min
		"timer_trap" => "13" //���� �� 8 ���
		);

$lov[5]=array(
// magic - time min
		"stat_trap" => "8" // �� �� 8 ���
		);

$lov[6]=array(
// magic - time min
		"timer_trap" => "15" //���� �� 9 ���
		);

$lov[7]=array(
// magic - time min
		"poison_trap" => "9" // �� �� 9 ���
		);

$lov[8]=array(
// magic - time min
		"stat_trap" => "10" //���� �� 9 ���
		);

$lov[9]=array(
// magic - time min
		"poison_trap" => "9" // �� �� 9 ���
		);		

$lov[10]=array(
// magic - time min
		"stat_trap" => "15" //���� �� 9 ���
		);
		
///////////////////////////////////////////////
//��������� �����
// ���� ���� � ����������  � �����
$hils[0]=array(
		"H" => 20 // 10%
		);

$hils[1]=array(
		"H" => 20 // 20%
		);

$hils[2]=array(
		"H" => 30 // 30%
		);

$hils[4]=array(
		"H" => 40 // 40%
		);

$hils[5]=array(
		"H" => 50 // 50%
		);

$hils[6]=array(
		"H" => 50 // 50%
		);

$hils[6]=array(
		"H" => 60 // 60%
		);

$hils[7]=array(
		"H" => 75 // 75%
		);

$hils[8]=array(
		"H" => 80 // 80%
		);

$hils[9]=array(
		"H" => 90 // 90%
		);

$hils[10]=array(
		"H" => 99 // 99%
		);

/////////////////////////////////////////////////
// ��������� BOX-��
//��� ��� � �������� ����� �������� �� ����
//����� ���������� ������� � ������!

$pbox[0]=array(
///�������� ��� ������� �� ������, �.�. ����� ���������� �� ���� ���� � ���������, �� ��������� ��
		"alf" => 3019,
		"antidot" => 4306		
		);
$pbox[1]=array(
		"bet" => 3020, //��������� ��� - � ���������� �� �� ���������
		"vostanovlenie_HP" => 246
//		"buter" => 105, 
		); 
$pbox[2]=array(
		"timer_trap" => "16" 
		);
$pbox[3]=array(
		"gamm" => 3021, // ��������� ��� - � ���������� �� �� ���������
		"ugol" => 3015 		
		); 
$pbox[4]=array(
		"gold" => 3018,
		"ugol" => 3014 		
		);
$pbox[5]=array(
		"silver" => 3017,
		"ugol" => 3013, 
		"molot" => 4300
		);
$pbox[6]=array(
		"almaz" => 3015,
		"pvedro"=>4306,
		"buter" => 105, 		
		);
$pbox[7]=array(
		"timer_trap" => "15" //���� �� 8 ���		
		);
$pbox[8]=array(
		"alzss" => 3006, 
		"pvedro" => 4306
		);
$pbox[9]=array(
		"items" => 3002, // ��������� ��� - � ���������� �� �� ���������
		"pvedro"=>4306		
	      ); 
$pbox[10]=array(
		"buter" => 105, 
		"gold" => 3013,
		"pvedro"=>4306
		);
$pbox[11]=array(
		"poison_trap" => "8" // �� �� 8 ���
		);

$pbox[12]=array(
		"almaz" => 3006,
		"ugolk" => 3014, 		
		);
$pbox[13]=array(
		"timer_trap" => "18" //���� �� 8 ���
		);
$pbox[14]=array(
		"gold" => 3009,
		"pvedro"=>4306
		);
$pbox[15]=array(
		"rudas" => 3017,
		"antidot" => 4000
		);
$pbox[16]=array(
		"vostanovlenie_HP" => 246
//		"buter" => 105
		);
$pbox[17]=array(
		"timer_trap" => "15" //���� �� 8 ���		
		);
$pbox[18]=array(
		"items" => 3018, 
		"antidot" => 4313
		);
$pbox[19]=array(
		"granit" => 3012, 
		"gold" => 3021 
		);
$pbox[20]=array(
		"gold" => 3020,
		"items" => 3011
		);



/////////////////////////////////////////////////
	
//��������� ����� �� �������� ������� 0 - ����� - 10
// labonly - ���������� ������ �� ����

$sund[0]=array(
//������ 1 ���� � ����������� � ������ - ��������� ��������� �������� �� ���������������� ��������
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "1",
		 "present"=> "",
		 "id" => "50177"
			);
$sund[2]=array(
		 "shop" => "eshop",
		 "labonly" => "1",
		 "maxdur" => "5",
 		 "present"=> "",
		 "id" => "5205"
			);

$sund[3]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "206"
			);


$sund[4]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "202"
			);

$sund[5]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "199"
			);			

$sund[6]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "200"
			);

$sund[7]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "210"
			);


$sund[8]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "209"
			);


$sund[9]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "197" ///!!!
			);

$sund[10]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "1",
 		 "present"=> "",
		 "id" => "50176"
			);

$sund[11]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
		 "present"=> "",
		 "id" => "196" 
			);


$sund[12]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "195"
			);

$sund[13]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "208"
			);

$sund[14]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "204"
			);


$sund[15]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "201"
			);
			
$sund[16]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "205"
			);


$sund[17]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "198"
			);
$sund[18]=array(
		 "shop" => "shop",
		 "labonly" => "1",
		 "maxdur" => "3",
 		 "present"=> "",
		 "id" => "203"
			);
/*
$sund[19]=array(
		 "shop" => "eshop",
		 "labonly" => "0",
		 "maxdur" => "1",
 		 "present"=> "��������",
		 "id" => "3010"
			);

$sund[20]=array(
		 "shop" => "eshop",
		 "labonly" => "0",
		 "maxdur" => "1",
 		 "present"=> "��������",
		 "id" => "3011"
			);
		*/	
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

/////////////////��������� �����
//////BOTS FOR 8 level /////
		
					$bot_setup[8][261]=array(
					"level"=>8,
					"maxhp"=>1000,
					"sum_minu"=>120,
					"sum_maxu"=>130,
					"sum_mfkrit"=>1200,
					"sum_mfakrit"=>500,
					"sum_mfuvorot"=>450,
					"sum_mfauvorot"=>600,
					"sum_bron1"=>60,
					"sum_bron2"=>60,
					"sum_bron3"=>60,
					"sum_bron4"=>60,
					"at_cost"=>25000);
					
					$bot_setup[8][262]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[8][261]=array(
					"level"=>8,
					"maxhp"=>1400,
					"sum_minu"=>80,
					"sum_maxu"=>100,
					"sum_mfkrit"=>400,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>500,
					"sum_mfauvorot"=>600,
					"sum_bron1"=>65,
					"sum_bron2"=>65,
					"sum_bron3"=>65,
					"sum_bron4"=>65,
					"at_cost"=>22000);
					
					$bot_setup[8][266]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[8][263]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][267]=array(
					"level"=>8,
					"maxhp"=>1000,
					"sum_minu"=>120,
					"sum_maxu"=>130,
					"sum_mfkrit"=>1200,
					"sum_mfakrit"=>500,
					"sum_mfuvorot"=>450,
					"sum_mfauvorot"=>600,
					"sum_bron1"=>60,
					"sum_bron2"=>60,
					"sum_bron3"=>60,
					"sum_bron4"=>60,
					"at_cost"=>25000);
					
					$bot_setup[8][264]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[8][268]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[8][266]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[8][265]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][267]=array(
					"level"=>8,
					"maxhp"=>1400,
					"sum_minu"=>80,
					"sum_maxu"=>100,
					"sum_mfkrit"=>400,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>500,
					"sum_mfauvorot"=>600,
					"sum_bron1"=>65,
					"sum_bron2"=>65,
					"sum_bron3"=>65,
					"sum_bron4"=>65,
					"at_cost"=>22000);
					
					$bot_setup[8][268]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[8][263]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][264]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[8][265]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][269]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[8][271]=array(
					"level"=>9,
					"maxhp"=>1680,
					"sum_minu"=>96,
					"sum_maxu"=>120,
					"sum_mfkrit"=>480,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>600,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>78,
					"sum_bron2"=>78,
					"sum_bron3"=>78,
					"sum_bron4"=>78,
					"at_cost"=>26400);
					
					$bot_setup[8][272]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[8][272]=array(
					"level"=>9,
					"maxhp"=>1680,
					"sum_minu"=>96,
					"sum_maxu"=>120,
					"sum_mfkrit"=>480,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>600,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>78,
					"sum_bron2"=>78,
					"sum_bron3"=>78,
					"sum_bron4"=>78,
					"at_cost"=>26400);
					
					$bot_setup[8][273]=array(
					"level"=>8,
					"maxhp"=>1000,
					"sum_minu"=>120,
					"sum_maxu"=>130,
					"sum_mfkrit"=>1200,
					"sum_mfakrit"=>500,
					"sum_mfuvorot"=>450,
					"sum_mfauvorot"=>600,
					"sum_bron1"=>60,
					"sum_bron2"=>60,
					"sum_bron3"=>60,
					"sum_bron4"=>60,
					"at_cost"=>25000);
					
					$bot_setup[8][271]=array(
					"level"=>9,
					"maxhp"=>1680,
					"sum_minu"=>96,
					"sum_maxu"=>120,
					"sum_mfkrit"=>480,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>600,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>78,
					"sum_bron2"=>78,
					"sum_bron3"=>78,
					"sum_bron4"=>78,
					"at_cost"=>26400);
					
					$bot_setup[8][265]=array(
					"level"=>8,
					"maxhp"=>1100,
					"sum_minu"=>60,
					"sum_maxu"=>80,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>400,
					"sum_mfuvorot"=>950,
					"sum_mfauvorot"=>1400,
					"sum_bron1"=>75,
					"sum_bron2"=>75,
					"sum_bron3"=>75,
					"sum_bron4"=>75,
					"at_cost"=>21000);
					
					$bot_setup[8][264]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[8][269]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[8][265]=array(
					"level"=>8,
					"maxhp"=>1100,
					"sum_minu"=>60,
					"sum_maxu"=>80,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>400,
					"sum_mfuvorot"=>950,
					"sum_mfauvorot"=>1400,
					"sum_bron1"=>75,
					"sum_bron2"=>75,
					"sum_bron3"=>75,
					"sum_bron4"=>75,
					"at_cost"=>21000);
					
					$bot_setup[8][268]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[8][219]=array(
					"level"=>7,
					"maxhp"=>0,
					"sum_minu"=>0,
					"sum_maxu"=>0,
					"sum_mfkrit"=>0,
					"sum_mfakrit"=>0,
					"sum_mfuvorot"=>0,
					"sum_mfauvorot"=>0,
					"sum_bron1"=>0,
					"sum_bron2"=>0,
					"sum_bron3"=>0,
					"sum_bron4"=>0,
					"at_cost"=>0);
					
					$bot_setup[8][220]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][221]=array(
					"level"=>8,
					"maxhp"=>1400,
					"sum_minu"=>80,
					"sum_maxu"=>100,
					"sum_mfkrit"=>400,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>500,
					"sum_mfauvorot"=>600,
					"sum_bron1"=>65,
					"sum_bron2"=>65,
					"sum_bron3"=>65,
					"sum_bron4"=>65,
					"at_cost"=>22000);
					
					$bot_setup[8][222]=array(
					"level"=>8,
					"maxhp"=>1100,
					"sum_minu"=>60,
					"sum_maxu"=>80,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>400,
					"sum_mfuvorot"=>950,
					"sum_mfauvorot"=>1400,
					"sum_bron1"=>75,
					"sum_bron2"=>75,
					"sum_bron3"=>75,
					"sum_bron4"=>75,
					"at_cost"=>21000);
					
					$bot_setup[8][223]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][224]=array(
					"level"=>8,
					"maxhp"=>1000,
					"sum_minu"=>120,
					"sum_maxu"=>130,
					"sum_mfkrit"=>1200,
					"sum_mfakrit"=>500,
					"sum_mfuvorot"=>450,
					"sum_mfauvorot"=>600,
					"sum_bron1"=>60,
					"sum_bron2"=>60,
					"sum_bron3"=>60,
					"sum_bron4"=>60,
					"at_cost"=>25000);
					
					$bot_setup[8][227]=array(
					"level"=>8,
					"maxhp"=>1100,
					"sum_minu"=>60,
					"sum_maxu"=>80,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>400,
					"sum_mfuvorot"=>950,
					"sum_mfauvorot"=>1400,
					"sum_bron1"=>75,
					"sum_bron2"=>75,
					"sum_bron3"=>75,
					"sum_bron4"=>75,
					"at_cost"=>21000);
					
					$bot_setup[8][228]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][275]=array(
					"level"=>9,
					"maxhp"=>1680,
					"sum_minu"=>96,
					"sum_maxu"=>120,
					"sum_mfkrit"=>480,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>600,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>78,
					"sum_bron2"=>78,
					"sum_bron3"=>78,
					"sum_bron4"=>78,
					"at_cost"=>26400);
					
					$bot_setup[8][274]=array(
					"level"=>8,
					"maxhp"=>1100,
					"sum_minu"=>60,
					"sum_maxu"=>80,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>400,
					"sum_mfuvorot"=>950,
					"sum_mfauvorot"=>1400,
					"sum_bron1"=>75,
					"sum_bron2"=>75,
					"sum_bron3"=>75,
					"sum_bron4"=>75,
					"at_cost"=>21000);
					
					$bot_setup[8][276]=array(
					"level"=>8,
					"maxhp"=>1200,
					"sum_minu"=>100,
					"sum_maxu"=>115,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1700,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>70,
					"sum_bron2"=>70,
					"sum_bron3"=>70,
					"sum_bron4"=>70,
					"at_cost"=>25000);
					
					$bot_setup[8][277]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[8][278]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[8][279]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[8][270]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>2200, //1200
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>2200,
					"sum_bron1"=>230, //130
					"sum_bron2"=>230,
					"sum_bron3"=>230,
					"sum_bron4"=>230,
					"at_cost"=>44000);
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		//////NEXT LEVEL//////
		//////BOTS FOR 9 level /////
		
					$bot_setup[9][261]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[9][262]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[9][261]=array(
					"level"=>9,
					"maxhp"=>1680,
					"sum_minu"=>96,
					"sum_maxu"=>120,
					"sum_mfkrit"=>480,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>600,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>78,
					"sum_bron2"=>78,
					"sum_bron3"=>78,
					"sum_bron4"=>78,
					"at_cost"=>26400);
					
					$bot_setup[9][266]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[9][263]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][267]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[9][264]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[9][268]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[9][266]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[9][265]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][267]=array(
					"level"=>9,
					"maxhp"=>1680,
					"sum_minu"=>96,
					"sum_maxu"=>120,
					"sum_mfkrit"=>480,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>600,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>78,
					"sum_bron2"=>78,
					"sum_bron3"=>78,
					"sum_bron4"=>78,
					"at_cost"=>26400);
					
					$bot_setup[9][268]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[9][263]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][264]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[9][265]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][269]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[9][271]=array(
					"level"=>10,
					"maxhp"=>2100,
					"sum_minu"=>120,
					"sum_maxu"=>150,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>750,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>98,
					"sum_bron2"=>98,
					"sum_bron3"=>98,
					"sum_bron4"=>98,
					"at_cost"=>33000);
					
					$bot_setup[9][272]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[9][272]=array(
					"level"=>10,
					"maxhp"=>2100,
					"sum_minu"=>120,
					"sum_maxu"=>150,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>750,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>98,
					"sum_bron2"=>98,
					"sum_bron3"=>98,
					"sum_bron4"=>98,
					"at_cost"=>33000);
					
					$bot_setup[9][273]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[9][271]=array(
					"level"=>10,
					"maxhp"=>2100,
					"sum_minu"=>120,
					"sum_maxu"=>150,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>750,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>98,
					"sum_bron2"=>98,
					"sum_bron3"=>98,
					"sum_bron4"=>98,
					"at_cost"=>33000);
					
					$bot_setup[9][265]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[9][264]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[9][269]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[9][265]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[9][268]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[9][219]=array(
					"level"=>8,
					"maxhp"=>1100,
					"sum_minu"=>60,
					"sum_maxu"=>80,
					"sum_mfkrit"=>300,
					"sum_mfakrit"=>400,
					"sum_mfuvorot"=>950,
					"sum_mfauvorot"=>1400,
					"sum_bron1"=>75,
					"sum_bron2"=>75,
					"sum_bron3"=>75,
					"sum_bron4"=>75,
					"at_cost"=>21000);
					
					$bot_setup[9][220]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][221]=array(
					"level"=>9,
					"maxhp"=>1680,
					"sum_minu"=>96,
					"sum_maxu"=>120,
					"sum_mfkrit"=>480,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>600,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>78,
					"sum_bron2"=>78,
					"sum_bron3"=>78,
					"sum_bron4"=>78,
					"at_cost"=>26400);
					
					$bot_setup[9][222]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[9][223]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][224]=array(
					"level"=>9,
					"maxhp"=>1200,
					"sum_minu"=>144,
					"sum_maxu"=>156,
					"sum_mfkrit"=>1440,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>540,
					"sum_mfauvorot"=>720,
					"sum_bron1"=>72,
					"sum_bron2"=>72,
					"sum_bron3"=>72,
					"sum_bron4"=>72,
					"at_cost"=>30000);
					
					$bot_setup[9][227]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[9][228]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][275]=array(
					"level"=>10,
					"maxhp"=>2100,
					"sum_minu"=>120,
					"sum_maxu"=>150,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>750,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>98,
					"sum_bron2"=>98,
					"sum_bron3"=>98,
					"sum_bron4"=>98,
					"at_cost"=>33000);
					
					$bot_setup[9][274]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[9][276]=array(
					"level"=>9,
					"maxhp"=>1440,
					"sum_minu"=>120,
					"sum_maxu"=>138,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>720,
					"sum_mfuvorot"=>2040,
					"sum_mfauvorot"=>1080,
					"sum_bron1"=>84,
					"sum_bron2"=>84,
					"sum_bron3"=>84,
					"sum_bron4"=>84,
					"at_cost"=>30000);
					
					$bot_setup[9][277]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[9][278]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[9][279]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[9][270]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>2260,
					"sum_mfuvorot"=>2050,
					"sum_mfauvorot"=>2260,
					"sum_bron1"=>337,
					"sum_bron2"=>337,
					"sum_bron3"=>337,
					"sum_bron4"=>337,
					"at_cost"=>46200);
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		//////NEXT LEVEL//////
		//////BOTS FOR 10 level /////
		
					$bot_setup[10][261]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[10][262]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[10][261]=array(
					"level"=>10,
					"maxhp"=>2100,
					"sum_minu"=>120,
					"sum_maxu"=>150,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>750,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>98,
					"sum_bron2"=>98,
					"sum_bron3"=>98,
					"sum_bron4"=>98,
					"at_cost"=>33000);
					
					$bot_setup[10][266]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[10][263]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][267]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[10][264]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[10][268]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[10][266]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[10][265]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][267]=array(
					"level"=>10,
					"maxhp"=>2100,
					"sum_minu"=>120,
					"sum_maxu"=>150,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>750,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>98,
					"sum_bron2"=>98,
					"sum_bron3"=>98,
					"sum_bron4"=>98,
					"at_cost"=>33000);
					
					$bot_setup[10][268]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[10][263]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][264]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[10][265]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][269]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[10][271]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>130,
					"sum_bron2"=>130,
					"sum_bron3"=>130,
					"sum_bron4"=>130,
					"at_cost"=>44000);
					
					$bot_setup[10][272]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[10][272]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>130,
					"sum_bron2"=>130,
					"sum_bron3"=>130,
					"sum_bron4"=>130,
					"at_cost"=>44000);
					
					$bot_setup[10][273]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[10][271]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>130,
					"sum_bron2"=>130,
					"sum_bron3"=>130,
					"sum_bron4"=>130,
					"at_cost"=>44000);
					
					$bot_setup[10][265]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[10][264]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[10][269]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[10][265]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[10][268]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[10][219]=array(
					"level"=>9,
					"maxhp"=>1320,
					"sum_minu"=>72,
					"sum_maxu"=>96,
					"sum_mfkrit"=>360,
					"sum_mfakrit"=>480,
					"sum_mfuvorot"=>1140,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>25200);
					
					$bot_setup[10][220]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][221]=array(
					"level"=>10,
					"maxhp"=>2100,
					"sum_minu"=>120,
					"sum_maxu"=>150,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>750,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>98,
					"sum_bron2"=>98,
					"sum_bron3"=>98,
					"sum_bron4"=>98,
					"at_cost"=>33000);
					
					$bot_setup[10][222]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[10][223]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][224]=array(
					"level"=>10,
					"maxhp"=>1500,
					"sum_minu"=>180,
					"sum_maxu"=>195,
					"sum_mfkrit"=>1800,
					"sum_mfakrit"=>750,
					"sum_mfuvorot"=>675,
					"sum_mfauvorot"=>900,
					"sum_bron1"=>90,
					"sum_bron2"=>90,
					"sum_bron3"=>90,
					"sum_bron4"=>90,
					"at_cost"=>37500);
					
					$bot_setup[10][227]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[10][228]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][275]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>130,
					"sum_bron2"=>130,
					"sum_bron3"=>130,
					"sum_bron4"=>130,
					"at_cost"=>44000);
					
					$bot_setup[10][274]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[10][276]=array(
					"level"=>10,
					"maxhp"=>1800,
					"sum_minu"=>150,
					"sum_maxu"=>173,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>900,
					"sum_mfuvorot"=>2550,
					"sum_mfauvorot"=>1350,
					"sum_bron1"=>105,
					"sum_bron2"=>105,
					"sum_bron3"=>105,
					"sum_bron4"=>105,
					"at_cost"=>37500);
					
					$bot_setup[10][277]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[10][278]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[10][279]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[10][270]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>2440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>2440,
					"sum_bron1"=>356,
					"sum_bron2"=>356,
					"sum_bron3"=>356,
					"sum_bron4"=>356,
					"at_cost"=>52800);
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		//////NEXT LEVEL//////
		//////BOTS FOR 11 level /////
		
					$bot_setup[11][261]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[11][262]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[11][261]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>130,
					"sum_bron2"=>130,
					"sum_bron3"=>130,
					"sum_bron4"=>130,
					"at_cost"=>44000);
					
					$bot_setup[11][266]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[11][263]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][267]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[11][264]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[11][268]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[11][266]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[11][265]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][267]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>130,
					"sum_bron2"=>130,
					"sum_bron3"=>130,
					"sum_bron4"=>130,
					"at_cost"=>44000);
					
					$bot_setup[11][268]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[11][263]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][264]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[11][265]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][269]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[11][271]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>1050,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>137,
					"sum_bron2"=>137,
					"sum_bron3"=>137,
					"sum_bron4"=>137,
					"at_cost"=>46200);
					
					$bot_setup[11][272]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[11][272]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>1050,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>137,
					"sum_bron2"=>137,
					"sum_bron3"=>137,
					"sum_bron4"=>137,
					"at_cost"=>46200);
					
					$bot_setup[11][273]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[11][271]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>1050,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>137,
					"sum_bron2"=>137,
					"sum_bron3"=>137,
					"sum_bron4"=>137,
					"at_cost"=>46200);
					
					$bot_setup[11][265]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[11][264]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[11][269]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[11][265]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[11][268]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[11][219]=array(
					"level"=>10,
					"maxhp"=>1650,
					"sum_minu"=>90,
					"sum_maxu"=>120,
					"sum_mfkrit"=>450,
					"sum_mfakrit"=>600,
					"sum_mfuvorot"=>1425,
					"sum_mfauvorot"=>2100,
					"sum_bron1"=>113,
					"sum_bron2"=>113,
					"sum_bron3"=>113,
					"sum_bron4"=>113,
					"at_cost"=>31500);
					
					$bot_setup[11][220]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][221]=array(
					"level"=>11,
					"maxhp"=>2800,
					"sum_minu"=>160,
					"sum_maxu"=>200,
					"sum_mfkrit"=>800,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1000,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>130,
					"sum_bron2"=>130,
					"sum_bron3"=>130,
					"sum_bron4"=>130,
					"at_cost"=>44000);
					
					$bot_setup[11][222]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[11][223]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][224]=array(
					"level"=>11,
					"maxhp"=>2000,
					"sum_minu"=>240,
					"sum_maxu"=>260,
					"sum_mfkrit"=>2400,
					"sum_mfakrit"=>1000,
					"sum_mfuvorot"=>900,
					"sum_mfauvorot"=>1200,
					"sum_bron1"=>120,
					"sum_bron2"=>120,
					"sum_bron3"=>120,
					"sum_bron4"=>120,
					"at_cost"=>50000);
					
					$bot_setup[11][227]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[11][228]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][275]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>1050,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>137,
					"sum_bron2"=>137,
					"sum_bron3"=>137,
					"sum_bron4"=>137,
					"at_cost"=>46200);
					
					$bot_setup[11][274]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[11][276]=array(
					"level"=>11,
					"maxhp"=>2400,
					"sum_minu"=>200,
					"sum_maxu"=>230,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>3400,
					"sum_mfauvorot"=>1800,
					"sum_bron1"=>140,
					"sum_bron2"=>140,
					"sum_bron3"=>140,
					"sum_bron4"=>140,
					"at_cost"=>50000);
					
					$bot_setup[11][277]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[11][278]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[11][279]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[11][270]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>2560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>2560,
					"sum_bron1"=>469,
					"sum_bron2"=>469,
					"sum_bron3"=>469,
					"sum_bron4"=>469,
					"at_cost"=>57200);
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		//////NEXT LEVEL//////
		//////BOTS FOR 12 level /////
		
					$bot_setup[12][261]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[12][262]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[12][261]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>1050,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>137,
					"sum_bron2"=>137,
					"sum_bron3"=>137,
					"sum_bron4"=>137,
					"at_cost"=>46200);
					
					$bot_setup[12][266]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[12][263]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][267]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[12][264]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[12][268]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[12][266]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[12][265]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][267]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>1050,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>137,
					"sum_bron2"=>137,
					"sum_bron3"=>137,
					"sum_bron4"=>137,
					"at_cost"=>46200);
					
					$bot_setup[12][268]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[12][263]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][264]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[12][265]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][269]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[12][271]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>52800);
					
					$bot_setup[12][272]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[12][272]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>52800);
					
					$bot_setup[12][273]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[12][271]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>52800);
					
					$bot_setup[12][265]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[12][264]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[12][269]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[12][265]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[12][268]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[12][219]=array(
					"level"=>11,
					"maxhp"=>2200,
					"sum_minu"=>120,
					"sum_maxu"=>160,
					"sum_mfkrit"=>600,
					"sum_mfakrit"=>800,
					"sum_mfuvorot"=>1900,
					"sum_mfauvorot"=>2800,
					"sum_bron1"=>150,
					"sum_bron2"=>150,
					"sum_bron3"=>150,
					"sum_bron4"=>150,
					"at_cost"=>42000);
					
					$bot_setup[12][220]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][221]=array(
					"level"=>12,
					"maxhp"=>2940,
					"sum_minu"=>168,
					"sum_maxu"=>210,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>1050,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>137,
					"sum_bron2"=>137,
					"sum_bron3"=>137,
					"sum_bron4"=>137,
					"at_cost"=>46200);
					
					$bot_setup[12][222]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[12][223]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][224]=array(
					"level"=>12,
					"maxhp"=>2100,
					"sum_minu"=>252,
					"sum_maxu"=>273,
					"sum_mfkrit"=>2520,
					"sum_mfakrit"=>1050,
					"sum_mfuvorot"=>945,
					"sum_mfauvorot"=>1260,
					"sum_bron1"=>126,
					"sum_bron2"=>126,
					"sum_bron3"=>126,
					"sum_bron4"=>126,
					"at_cost"=>52500);
					
					$bot_setup[12][227]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[12][228]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][275]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>52800);
					
					$bot_setup[12][274]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[12][276]=array(
					"level"=>12,
					"maxhp"=>2520,
					"sum_minu"=>210,
					"sum_maxu"=>242,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>1260,
					"sum_mfuvorot"=>3570,
					"sum_mfauvorot"=>1890,
					"sum_bron1"=>147,
					"sum_bron2"=>147,
					"sum_bron3"=>147,
					"sum_bron4"=>147,
					"at_cost"=>52500);
					
					$bot_setup[12][277]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[12][278]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[12][279]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[12][270]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>3620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>3620,
					"sum_bron1"=>476,
					"sum_bron2"=>476,
					"sum_bron3"=>476,
					"sum_bron4"=>476,
					"at_cost"=>59400);
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		//////NEXT LEVEL//////
		//////BOTS FOR 13 level /////
		
					$bot_setup[13][261]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[13][262]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[13][261]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>52800);
					
					$bot_setup[13][266]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[13][263]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][267]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[13][264]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[13][268]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[13][266]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[13][265]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][267]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>52800);
					
					$bot_setup[13][268]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[13][263]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][264]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[13][265]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][269]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[13][271]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>169,
					"sum_bron2"=>169,
					"sum_bron3"=>169,
					"sum_bron4"=>169,
					"at_cost"=>57200);
					
					$bot_setup[13][272]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[13][272]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>169,
					"sum_bron2"=>169,
					"sum_bron3"=>169,
					"sum_bron4"=>169,
					"at_cost"=>57200);
					
					$bot_setup[13][273]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[13][271]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>169,
					"sum_bron2"=>169,
					"sum_bron3"=>169,
					"sum_bron4"=>169,
					"at_cost"=>57200);
					
					$bot_setup[13][265]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[13][264]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[13][269]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[13][265]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[13][268]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[13][219]=array(
					"level"=>12,
					"maxhp"=>2310,
					"sum_minu"=>126,
					"sum_maxu"=>168,
					"sum_mfkrit"=>630,
					"sum_mfakrit"=>840,
					"sum_mfuvorot"=>1995,
					"sum_mfauvorot"=>2940,
					"sum_bron1"=>158,
					"sum_bron2"=>158,
					"sum_bron3"=>158,
					"sum_bron4"=>158,
					"at_cost"=>44100);
					
					$bot_setup[13][220]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][221]=array(
					"level"=>13,
					"maxhp"=>3360,
					"sum_minu"=>192,
					"sum_maxu"=>240,
					"sum_mfkrit"=>960,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>1200,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>52800);
					
					$bot_setup[13][222]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[13][223]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][224]=array(
					"level"=>13,
					"maxhp"=>2400,
					"sum_minu"=>288,
					"sum_maxu"=>312,
					"sum_mfkrit"=>2880,
					"sum_mfakrit"=>1200,
					"sum_mfuvorot"=>1080,
					"sum_mfauvorot"=>1440,
					"sum_bron1"=>144,
					"sum_bron2"=>144,
					"sum_bron3"=>144,
					"sum_bron4"=>144,
					"at_cost"=>60000);
					
					$bot_setup[13][227]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[13][228]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][275]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>169,
					"sum_bron2"=>169,
					"sum_bron3"=>169,
					"sum_bron4"=>169,
					"at_cost"=>57200);
					
					$bot_setup[13][274]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[13][276]=array(
					"level"=>13,
					"maxhp"=>2880,
					"sum_minu"=>240,
					"sum_maxu"=>276,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>1440,
					"sum_mfuvorot"=>4080,
					"sum_mfauvorot"=>2160,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>60000);
					
					$bot_setup[13][277]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[13][278]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[13][279]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[13][270]=array(
					"level"=>16,
					"maxhp"=>3920,
					"sum_minu"=>224,
					"sum_maxu"=>280,
					"sum_mfkrit"=>1120,
					"sum_mfakrit"=>3800,
					"sum_mfuvorot"=>1400,
					"sum_mfauvorot"=>3800,
					"sum_bron1"=>482,
					"sum_bron2"=>482,
					"sum_bron3"=>482,
					"sum_bron4"=>482,
					"at_cost"=>61600);
					
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		//////NEXT LEVEL//////
		//////BOTS FOR 14 level /////
		
					$bot_setup[14][261]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[14][262]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[14][261]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>169,
					"sum_bron2"=>169,
					"sum_bron3"=>169,
					"sum_bron4"=>169,
					"at_cost"=>57200);
					
					$bot_setup[14][266]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[14][263]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][267]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[14][264]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[14][268]=array(
					"level"=>16,
					"maxhp"=>3360,
					"sum_minu"=>280,
					"sum_maxu"=>322,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>4760,
					"sum_mfauvorot"=>2520,
					"sum_bron1"=>196,
					"sum_bron2"=>196,
					"sum_bron3"=>196,
					"sum_bron4"=>196,
					"at_cost"=>70000);
					
					$bot_setup[14][266]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[14][265]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][267]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>169,
					"sum_bron2"=>169,
					"sum_bron3"=>169,
					"sum_bron4"=>169,
					"at_cost"=>57200);
					
					$bot_setup[14][268]=array(
					"level"=>16,
					"maxhp"=>3080,
					"sum_minu"=>168,
					"sum_maxu"=>224,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1120,
					"sum_mfuvorot"=>2660,
					"sum_mfauvorot"=>3920,
					"sum_bron1"=>210,
					"sum_bron2"=>210,
					"sum_bron3"=>210,
					"sum_bron4"=>210,
					"at_cost"=>58800);
					
					$bot_setup[14][263]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][264]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[14][265]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][269]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[14][271]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>176,
					"sum_bron2"=>176,
					"sum_bron3"=>176,
					"sum_bron4"=>176,
					"at_cost"=>59400);
					
					$bot_setup[14][272]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[14][272]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>176,
					"sum_bron2"=>176,
					"sum_bron3"=>176,
					"sum_bron4"=>176,
					"at_cost"=>59400);
					
					$bot_setup[14][273]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[14][271]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>176,
					"sum_bron2"=>176,
					"sum_bron3"=>176,
					"sum_bron4"=>176,
					"at_cost"=>59400);
					
					$bot_setup[14][265]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[14][264]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[14][269]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[14][265]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[14][268]=array(
					"level"=>16,
					"maxhp"=>3360,
					"sum_minu"=>280,
					"sum_maxu"=>322,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>4760,
					"sum_mfauvorot"=>2520,
					"sum_bron1"=>196,
					"sum_bron2"=>196,
					"sum_bron3"=>196,
					"sum_bron4"=>196,
					"at_cost"=>70000);
					
					$bot_setup[14][219]=array(
					"level"=>13,
					"maxhp"=>2640,
					"sum_minu"=>144,
					"sum_maxu"=>192,
					"sum_mfkrit"=>720,
					"sum_mfakrit"=>960,
					"sum_mfuvorot"=>2280,
					"sum_mfauvorot"=>3360,
					"sum_bron1"=>180,
					"sum_bron2"=>180,
					"sum_bron3"=>180,
					"sum_bron4"=>180,
					"at_cost"=>50400);
					
					$bot_setup[14][220]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][221]=array(
					"level"=>14,
					"maxhp"=>3640,
					"sum_minu"=>208,
					"sum_maxu"=>260,
					"sum_mfkrit"=>1040,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>1300,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>169,
					"sum_bron2"=>169,
					"sum_bron3"=>169,
					"sum_bron4"=>169,
					"at_cost"=>57200);
					
					$bot_setup[14][222]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[14][223]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][224]=array(
					"level"=>14,
					"maxhp"=>2600,
					"sum_minu"=>312,
					"sum_maxu"=>338,
					"sum_mfkrit"=>3120,
					"sum_mfakrit"=>1300,
					"sum_mfuvorot"=>1170,
					"sum_mfauvorot"=>1560,
					"sum_bron1"=>156,
					"sum_bron2"=>156,
					"sum_bron3"=>156,
					"sum_bron4"=>156,
					"at_cost"=>65000);
					
					$bot_setup[14][227]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[14][228]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][275]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>176,
					"sum_bron2"=>176,
					"sum_bron3"=>176,
					"sum_bron4"=>176,
					"at_cost"=>59400);
					
					$bot_setup[14][274]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[14][276]=array(
					"level"=>14,
					"maxhp"=>3120,
					"sum_minu"=>260,
					"sum_maxu"=>299,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1560,
					"sum_mfuvorot"=>4420,
					"sum_mfauvorot"=>2340,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>65000);
					
					$bot_setup[14][277]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[14][278]=array(
					"level"=>16,
					"maxhp"=>3080,
					"sum_minu"=>168,
					"sum_maxu"=>224,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1120,
					"sum_mfuvorot"=>2660,
					"sum_mfauvorot"=>3920,
					"sum_bron1"=>210,
					"sum_bron2"=>210,
					"sum_bron3"=>210,
					"sum_bron4"=>210,
					"at_cost"=>58800);
					
					$bot_setup[14][279]=array(
					"level"=>16,
					"maxhp"=>3360,
					"sum_minu"=>280,
					"sum_maxu"=>322,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>4760,
					"sum_mfauvorot"=>2520,
					"sum_bron1"=>196,
					"sum_bron2"=>196,
					"sum_bron3"=>196,
					"sum_bron4"=>196,
					"at_cost"=>70000);
					
					$bot_setup[14][270]=array(
					"level"=>17,
					"maxhp"=>4060,
					"sum_minu"=>232,
					"sum_maxu"=>290,
					"sum_mfkrit"=>1160,
					"sum_mfakrit"=>4200,
					"sum_mfuvorot"=>1450,
					"sum_mfauvorot"=>4200,
					"sum_bron1"=>489,
					"sum_bron2"=>489,
					"sum_bron3"=>489,
					"sum_bron4"=>489,
					"at_cost"=>63800);
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		//////NEXT LEVEL//////
		//////BOTS FOR 15 level /////
		
					$bot_setup[15][261]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[15][262]=array(
					"level"=>16,
					"maxhp"=>3360,
					"sum_minu"=>280,
					"sum_maxu"=>322,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>4760,
					"sum_mfauvorot"=>2520,
					"sum_bron1"=>196,
					"sum_bron2"=>196,
					"sum_bron3"=>196,
					"sum_bron4"=>196,
					"at_cost"=>70000);
					
					$bot_setup[15][261]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>176,
					"sum_bron2"=>176,
					"sum_bron3"=>176,
					"sum_bron4"=>176,
					"at_cost"=>59400);
					
					$bot_setup[15][266]=array(
					"level"=>16,
					"maxhp"=>3080,
					"sum_minu"=>168,
					"sum_maxu"=>224,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1120,
					"sum_mfuvorot"=>2660,
					"sum_mfauvorot"=>3920,
					"sum_bron1"=>210,
					"sum_bron2"=>210,
					"sum_bron3"=>210,
					"sum_bron4"=>210,
					"at_cost"=>58800);
					
					$bot_setup[15][263]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][267]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[15][264]=array(
					"level"=>16,
					"maxhp"=>3080,
					"sum_minu"=>168,
					"sum_maxu"=>224,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1120,
					"sum_mfuvorot"=>2660,
					"sum_mfauvorot"=>3920,
					"sum_bron1"=>210,
					"sum_bron2"=>210,
					"sum_bron3"=>210,
					"sum_bron4"=>210,
					"at_cost"=>58800);
					
					$bot_setup[15][268]=array(
					"level"=>17,
					"maxhp"=>3480,
					"sum_minu"=>290,
					"sum_maxu"=>334,
					"sum_mfkrit"=>870,
					"sum_mfakrit"=>1740,
					"sum_mfuvorot"=>4930,
					"sum_mfauvorot"=>2610,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>72500);
					
					$bot_setup[15][266]=array(
					"level"=>16,
					"maxhp"=>3080,
					"sum_minu"=>168,
					"sum_maxu"=>224,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1120,
					"sum_mfuvorot"=>2660,
					"sum_mfauvorot"=>3920,
					"sum_bron1"=>210,
					"sum_bron2"=>210,
					"sum_bron3"=>210,
					"sum_bron4"=>210,
					"at_cost"=>58800);
					
					$bot_setup[15][265]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][267]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>176,
					"sum_bron2"=>176,
					"sum_bron3"=>176,
					"sum_bron4"=>176,
					"at_cost"=>59400);
					
					$bot_setup[15][268]=array(
					"level"=>17,
					"maxhp"=>3190,
					"sum_minu"=>174,
					"sum_maxu"=>232,
					"sum_mfkrit"=>870,
					"sum_mfakrit"=>1160,
					"sum_mfuvorot"=>2755,
					"sum_mfauvorot"=>4060,
					"sum_bron1"=>218,
					"sum_bron2"=>218,
					"sum_bron3"=>218,
					"sum_bron4"=>218,
					"at_cost"=>60900);
					
					$bot_setup[15][263]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][264]=array(
					"level"=>16,
					"maxhp"=>3080,
					"sum_minu"=>168,
					"sum_maxu"=>224,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1120,
					"sum_mfuvorot"=>2660,
					"sum_mfauvorot"=>3920,
					"sum_bron1"=>210,
					"sum_bron2"=>210,
					"sum_bron3"=>210,
					"sum_bron4"=>210,
					"at_cost"=>58800);
					
					$bot_setup[15][265]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][269]=array(
					"level"=>16,
					"maxhp"=>2800,
					"sum_minu"=>336,
					"sum_maxu"=>364,
					"sum_mfkrit"=>3360,
					"sum_mfakrit"=>1400,
					"sum_mfuvorot"=>1260,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>70000);
					
					$bot_setup[15][271]=array(
					"level"=>16,
					"maxhp"=>3920,
					"sum_minu"=>224,
					"sum_maxu"=>280,
					"sum_mfkrit"=>1120,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>1400,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>61600);
					
					$bot_setup[15][272]=array(
					"level"=>16,
					"maxhp"=>2800,
					"sum_minu"=>336,
					"sum_maxu"=>364,
					"sum_mfkrit"=>3360,
					"sum_mfakrit"=>1400,
					"sum_mfuvorot"=>1260,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>70000);
					
					$bot_setup[15][272]=array(
					"level"=>16,
					"maxhp"=>3920,
					"sum_minu"=>224,
					"sum_maxu"=>280,
					"sum_mfkrit"=>1120,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>1400,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>61600);
					
					$bot_setup[15][273]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[15][271]=array(
					"level"=>16,
					"maxhp"=>3920,
					"sum_minu"=>224,
					"sum_maxu"=>280,
					"sum_mfkrit"=>1120,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>1400,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>61600);
					
					$bot_setup[15][265]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[15][264]=array(
					"level"=>16,
					"maxhp"=>3360,
					"sum_minu"=>280,
					"sum_maxu"=>322,
					"sum_mfkrit"=>840,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>4760,
					"sum_mfauvorot"=>2520,
					"sum_bron1"=>196,
					"sum_bron2"=>196,
					"sum_bron3"=>196,
					"sum_bron4"=>196,
					"at_cost"=>70000);
					
					$bot_setup[15][269]=array(
					"level"=>16,
					"maxhp"=>2800,
					"sum_minu"=>336,
					"sum_maxu"=>364,
					"sum_mfkrit"=>3360,
					"sum_mfakrit"=>1400,
					"sum_mfuvorot"=>1260,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>70000);
					
					$bot_setup[15][265]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[15][268]=array(
					"level"=>17,
					"maxhp"=>3480,
					"sum_minu"=>290,
					"sum_maxu"=>334,
					"sum_mfkrit"=>870,
					"sum_mfakrit"=>1740,
					"sum_mfuvorot"=>4930,
					"sum_mfauvorot"=>2610,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>72500);
					
					$bot_setup[15][219]=array(
					"level"=>14,
					"maxhp"=>2860,
					"sum_minu"=>156,
					"sum_maxu"=>208,
					"sum_mfkrit"=>780,
					"sum_mfakrit"=>1040,
					"sum_mfuvorot"=>2470,
					"sum_mfauvorot"=>3640,
					"sum_bron1"=>195,
					"sum_bron2"=>195,
					"sum_bron3"=>195,
					"sum_bron4"=>195,
					"at_cost"=>54600);
					
					$bot_setup[15][220]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][221]=array(
					"level"=>15,
					"maxhp"=>3780,
					"sum_minu"=>216,
					"sum_maxu"=>270,
					"sum_mfkrit"=>1080,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>1350,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>176,
					"sum_bron2"=>176,
					"sum_bron3"=>176,
					"sum_bron4"=>176,
					"at_cost"=>59400);
					
					$bot_setup[15][222]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[15][223]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][224]=array(
					"level"=>15,
					"maxhp"=>2700,
					"sum_minu"=>324,
					"sum_maxu"=>351,
					"sum_mfkrit"=>3240,
					"sum_mfakrit"=>1350,
					"sum_mfuvorot"=>1215,
					"sum_mfauvorot"=>1620,
					"sum_bron1"=>162,
					"sum_bron2"=>162,
					"sum_bron3"=>162,
					"sum_bron4"=>162,
					"at_cost"=>67500);
					
					$bot_setup[15][227]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[15][228]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][275]=array(
					"level"=>16,
					"maxhp"=>3920,
					"sum_minu"=>224,
					"sum_maxu"=>280,
					"sum_mfkrit"=>1120,
					"sum_mfakrit"=>1680,
					"sum_mfuvorot"=>1400,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>182,
					"sum_bron2"=>182,
					"sum_bron3"=>182,
					"sum_bron4"=>182,
					"at_cost"=>61600);
					
					$bot_setup[15][274]=array(
					"level"=>15,
					"maxhp"=>2970,
					"sum_minu"=>162,
					"sum_maxu"=>216,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1080,
					"sum_mfuvorot"=>2565,
					"sum_mfauvorot"=>3780,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>56700);
					
					$bot_setup[15][276]=array(
					"level"=>15,
					"maxhp"=>3240,
					"sum_minu"=>270,
					"sum_maxu"=>311,
					"sum_mfkrit"=>810,
					"sum_mfakrit"=>1620,
					"sum_mfuvorot"=>4590,
					"sum_mfauvorot"=>2430,
					"sum_bron1"=>189,
					"sum_bron2"=>189,
					"sum_bron3"=>189,
					"sum_bron4"=>189,
					"at_cost"=>67500);
					
					$bot_setup[15][277]=array(
					"level"=>16,
					"maxhp"=>2800,
					"sum_minu"=>336,
					"sum_maxu"=>364,
					"sum_mfkrit"=>3360,
					"sum_mfakrit"=>1400,
					"sum_mfuvorot"=>1260,
					"sum_mfauvorot"=>1680,
					"sum_bron1"=>168,
					"sum_bron2"=>168,
					"sum_bron3"=>168,
					"sum_bron4"=>168,
					"at_cost"=>70000);
					
					$bot_setup[15][278]=array(
					"level"=>17,
					"maxhp"=>3190,
					"sum_minu"=>174,
					"sum_maxu"=>232,
					"sum_mfkrit"=>870,
					"sum_mfakrit"=>1160,
					"sum_mfuvorot"=>2755,
					"sum_mfauvorot"=>4060,
					"sum_bron1"=>218,
					"sum_bron2"=>218,
					"sum_bron3"=>218,
					"sum_bron4"=>218,
					"at_cost"=>60900);
					
					$bot_setup[15][279]=array(
					"level"=>17,
					"maxhp"=>3480,
					"sum_minu"=>290,
					"sum_maxu"=>334,
					"sum_mfkrit"=>870,
					"sum_mfakrit"=>1740,
					"sum_mfuvorot"=>4930,
					"sum_mfauvorot"=>2610,
					"sum_bron1"=>203,
					"sum_bron2"=>203,
					"sum_bron3"=>203,
					"sum_bron4"=>203,
					"at_cost"=>72500);
					
					$bot_setup[15][270]=array(
					"level"=>18,
					"maxhp"=>4200,
					"sum_minu"=>240,
					"sum_maxu"=>300,
					"sum_mfkrit"=>1200,
					"sum_mfakrit"=>5800,
					"sum_mfuvorot"=>1500,
					"sum_mfauvorot"=>5800,
					"sum_bron1"=>495,
					"sum_bron2"=>495,
					"sum_bron3"=>495,
					"sum_bron4"=>495,
					"at_cost"=>66000);
					/* 
		����������: 8
		���� ����������: 8
		�����������: 13
		��������������: 12
		*/
		
?>