<?php       
	require_once('ruines_rooms.php');

	if (isset($_SESSION['uid'])) $frpath = '/www/cache/usertimes/r'.$_SESSION["uid"];
	$frrelpath = '/www/cache/usertimes/r';

	$team_colors = array(1 => "blue", 2 => "red");

	$bot_id = array();
	$bot_id[8] = array("start" => array("501" => 2, "502" => 3), "end" => array("507" => 3, "508" => 3));
	$bot_id[9] = array("start" => array("503" => 2, "504" => 3), "end" => array("509" => 3, "510" => 3));;
	$bot_id[10] = array("start" => array("505" => 2, "506" => 3), "end" => array("511" => 3, "512" => 3));;

	$keyexcluderooms = array(75,77,51,41,42,52,31,32,76,9,10,19,20,29,30);

	$gomoney = 10; // �� ��� ����� � ������ ��� ��������

	$iupgrade = array(
				7 => array(
					"level" => 7,
					"hp" => 6,
					"bron" => 1,
					"stat" => 1,
					"mf" => 5,
					"udar" => 1,
					"nparam" => 1,
					"duration" => 30
				),
				8 => array(
					"level" => 8,
					"hp" => 8,
					"bron" => 1,
					"stat" => 1,
					"mf" => 7,
					"udar" => 2,
					"nparam" => 1,
					"duration" => 40
				),
				9 => array(
					"level" => 9,
					"hp" => 10,
					"bron" => 1,
					"stat" => 1,
					"mf" => 10,
					"udar" => 3,
					"nparam" => 1,
					"duration" => 50
				),
				10 => array(
					"level" => 10,
					"hp" => 12,
					"bron" => 1,
					"stat" => 1,
					"mf" => 12,
					"udar" => 4,
					"nparam" => 1,
					"duration" => 50
				)
	);

	$ritems = array();

	// ������

	// �������
	$ritems[194] = array(0 => array("scroll" => 1, "count" => 6));
	// �����
	$ritems[119] = array(0 => array("scroll" => 1, "count" => 4));
	// ��������
	$ritems[120] = array(0 => array("scroll" => 1, "count" => 4));
	// ����
	$ritems[121] = array(0 => array("scroll" => 1, "count" => 6));
	// ������
	$ritems[9] = array(0 => array("scroll" => 1, "count" => 10));

	// ����� 90/120/150/180
	$ritems[246] = array(0 => array("scroll" => 1, "count" => 12));
	$ritems[249] = array(0 => array("scroll" => 1, "count" => 12));

	// ����� �������
	$ritems[605605] = array(0 => array("scroll" => 1, "count" => 3));

	// ������ ���������
	$ritems[666666] = array(0 => array("scroll" => 1, "count" => 3));

	// ������ ��������� ��
	$ritems[666667] = array(0 => array("scroll" => 1, "count" => 24));

	// �����
	//$ritems[102] = array(0 => array("scroll" => 1, "count" => 6));

	// ������ ������� ����
	$ritems[222222231] = array(
		// ���� 5�
		0 => array(
			"addname" => " (��)",
			"glovk" => 3,
			"bron1" => 3,
			"bron2" => 3,
			"bron3" => 3,
			"bron4" => 3,
			"mfuvorot" => 25,
			"directionmf" => "mfuvorot",
			"directionstats" => "glovk",
			"count" => 1
    		)
	);
	
	$ritems[222222233] = array(
		//������ ������������ �����
 		// �� ���� �� 5�
    		0 => array(
     			"addname" => " (��)",
     			"ginta" => 2,
     			"bron1" => 2,
     			"bron2" => 2,
     			"bron3" => 2,
     			"bron4" => 2,
     			"mfauvorot" => 25,
     			"directionmf" => "mfauvorot",
     			"directionstats" => "ginta",
     			"count" => 2
    		)
	);

	$ritems[222222230] = array(
		// ������ ���� �������
		// �� ���� �� 4�
    		0 => array(
     			"addname" => " (��)",
     			"ginta" => 2,
     			"bron1" => 2,
     			"bron2" => 2,
     			"bron3" => 2,
     			"bron4" => 2,
     			"mfkrit" => 15,
     			"directionmf" => "mfkrit",
     			"directionstats" => "ginta",
     			"count" => 3
    		)
	);

	$ritems[222222232] = array(
		//������ ������� ����������
		// �� ���� �� 3�
    		0 => array(
     			"addname" => " (��)",
     			"ginta" => 2,
     			"bron1" => 2,
     			"bron2" => 2,
     			"bron3" => 2,
     			"bron4" => 2,
     			"mfakrit" => 9,
     			"directionmf" => "mfakrit",
     			"directionstats" => "ginta",
     			"count" => 4
		)
	);


 	$ritems[222222237] = array(
		// ������ �����
    		// ����, 5�
    		0 => array(
		     "addname" => " (��)",
		     "ginta" => 3,
		     "bron1" => 3,
		     "bron2" => 3,
		     "bron3" => 3,
		     "bron4" => 3,
		     "mfakrit" => 25,
		     "directionmf" => "mfakrit",
		     "directionstats" => "ginta",
		     "count" => 2
    		)
	);

	$ritems[222222236] = array(
		//������ ���������
	 	// �� ����, 5�
		0 => array(
		     "addname" => " (��)",
		     "ginta" => 2,
		     "bron1" => 2,
		     "bron2" => 2,
		     "bron3" => 2,
		     "bron4" => 2,
		     "mfkrit" => 25,
		     "directionmf" => "mfkrit",
		     "directionstats" => "ginta",
		     "count" => 3
		)
	);

	$ritems[222222238] = array(
		//������ ��������
		// �� ���� 4�
		0 => array(
		     "addname" => " (��)",
		     "glovk" => 2,
		     "bron1" => 2,
		     "bron2" => 2,
		     "bron3" => 2,
		     "bron4" => 2,
		     "mfuvorot" => 15,
		     "directionmf" => "mfuvorot",
		     "directionstats" => "glovk",
		     "count" => 6
    		)
	);

	$ritems[222222239] = array(
		//������ ������
		 // �� ���� �� �� 3�
		0 => array(
		     "addname" => " (��)",
		     "ginta" => 2,
		     "bron1" => 2,
		     "bron2" => 2,
		     "bron3" => 2,
		     "bron4" => 2,
		     "mfauvorot" => 9,
		     "directionmf" => "mfauvorot",
		     "directionstats" => "ginta",
		     "count" => 9
	    	)
	);

 	// ������ �����
 	$ritems[222222240] = array(
		    // ���� �� ��, 5�
		0 => array(
		     "addname" => " (��)",
		     "ghp" => 20,
		     "gsila" => 3,
		     "bron1" => 3,
		     "bron2" => 3,
		     "bron3" => 3,
		     "bron4" => 3,
		     "mfakrit" => 25,
		     "directionmf" => "mfakrit",
		     "directionstats" => "gsila",
		     "count" => 1
		)
	);


	$ritems[222222241] = array(
		//������ ������
		 // ���� �� ��, 5�
		0 => array(
		     "addname" => " (��)",
		     "ghp" => 20,
		     "gsila" => 3,
		     "bron1" => 3,
		     "bron2" => 3,
		     "bron3" => 3,
		     "bron4" => 3,
		     "mfauvorot" => 25,
		     "directionmf" => "mfauvorot",
		     "directionstats" => "gsila",
		     "count" => 1
		)
	);
	

	
	// ������ �����
	$ritems[16] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gintel" => 3,
					"bron1" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"bron4" => 3,
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 3
				),

				// �� ���� �� � 5�
				1 => array(
					"addname" => " (��)",
					"gintel" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfkrit" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "ginta",
					"count" => 4
				),

				// �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"gintel" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfakrit" => 15,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 9
				),

				// �� ���� �� � 3�
				3 => array(
					"addname" => " (��)",
					"gintel" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfkrit" => 9,
					"directionmf" => "mfkrit",
					"directionstats" => "ginta",
					"count" => 14
				),
	);
	

	// ������ ���������� �����
	$ritems[2000] = array(
				0 => array(
					"addname" => " +5",
					"minu" => 5,
					"maxu" => 5,
					"count" => 3
				),
	);

	// ������� ����� ��������
	$ritems[284] = $ritems[2000];
	$ritems[284][0]["count"] = 2;

	// ��� �������� �����
	$ritems[2001] = $ritems[2000];

	// ����� ������ �������
	$ritems[2002] = $ritems[2000];
	
	// ����� ����������
	$ritems[242] = $ritems[2000];

	// ����� ������
	$ritems[108] = $ritems[2000];

	// ������ ����� �����
	$ritems[236] = $ritems[2000];

	// �������� �����
	$ritems[82] = $ritems[2000];

	// ��� ������ ����� 
	$ritems[234] = $ritems[2000];

	// ������� ����� �����
	$ritems[142] = $ritems[2000];

	// ����� ����������
	$ritems[229] = $ritems[2000];

	// ������
	$ritems[78] = $ritems[2000];

	// ����� ����������
	$ritems[131] = $ritems[2000];

	// ���������
	$ritems[96] = $ritems[2000];

	// �������� ������ �����������
	$ritems[265] = $ritems[2000];
	$ritems[265][0]["count"] = 2;

	// �������� �����
	$ritems[267] = $ritems[2000];
	$ritems[267][0]["count"] = 2;

	// ��� �������������
	$ritems[271] = $ritems[2000];
	$ritems[271][0]["count"] = 2;


	// ������ ���������� ����� - 260
	$ritems[260] = array(
				// ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"glovk" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
                                        "ghp" => "20",
					"count" => 2
				)
	);


	//  ������� ������ �������� - 283
	$ritems[283] = array(
				// ��
				0 => array(
					"addname" => "",
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
					"count" => 1
				),
				// ��
				1 => array(
					"addname" => "",
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 1
				)
	);

	// ������� ��������� ����
	$ritems[266] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 1
				),
				// ���� �� ��, 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 1
				)
	);

	// ���� �������� ����� - 262
	$ritems[262] = array(
				// ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"ginta" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"mfkrit" => 25,
					"directionmf" => "mfkrit",
					"directionstats" => "ginta",
                                        "ghp" => "20",
					"count" => 2
				)
	);



	// ����� ������
	$ritems[62] = array(
				// ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"mfkrit" => 25,
					"directionmf" => "mfkrit",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 2
				),

				// �� ���� �� � 4�
				2 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"mfauvorot" => 15,
					"directionmf" => "mfuvorot",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 5
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"mfauvorot" => 9,
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 7
				),
	);

	// ������ ��� �����
	$ritems[63] = array(
				// ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 1
				),

				// �� ���� �� � 4�
				2 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"mfakrit" => 15,
					"directionmf" => "mfkrit",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 1
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 2
				),
	);

        // ����� ��������
        $ritems[73] = array(
                                // ���� �� ��, 5�
                                0 => array(
					"addname" => " (��)",
					"ginta" => 3,
					"bron1" => 3,
					"mfauvorot" => 25,
					"ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 1
				),

                                // �� ���� �� � 5�
				1 => array(
					"addname" => " (��)",
					"ginta" =>2 ,
					"bron1" => 2,
					"mfkrit" => 25,
					"directionmf" => "mfkrit",
					"directionstats" => "ginta",
                                        "ghp" => "20",
					"count" => 1
                                ),

                                // �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"bron1" => 2,
					"mfauvorot" => 15,
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
                                        "ghp" => "20",
					"count" => 2
                                ),

                                // �� ���� �� � 3�
				3 => array(
					"addname" => " (��)",
					"ginta" =>2 ,
					"bron1" => 2,
					"mfauvorot" => 9,
					"directionmf" => "mfkrit",
					"directionstats" => "ginta",
                                        "ghp" => "20",
					"count" => 3
				)
	);

	// ����� ������� ���������
	$ritems[74] = array(
				// ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"glovk" => 3,
                                        "bron1" => 3,
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
                                        "ghp" => "20",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"bron1" => 3,
					"ghp" => "20",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 2
				),

				// �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"bron1" => 3,
					"mfauvorot" => 15,
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
                                        "ghp" => "20",
					"count" => 2
				),

				// �� ���� �� � 3�
				3 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"bron1" => 3,
					"mfuvorot" => 9,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
                                        "ghp" => "20",
					"count" => 3
				),
	);

	// ���� ���������� 
	$ritems[259] = array(
			
				// ���� �� �� 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
                                        "bron1" => 3,
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 2
				),
				// ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 3,
                                        "bron1" => 3,
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
                                        "ghp" => "20",
					"count" => 2
				),
	);

	// ������������ ����
	$ritems[235] = array(
			
				// �� ���� �� �� 5�
				0 => array(
					"addname" => " (��)",
					"ginta" => 2,
                                        "bron1" => 2,
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
                                        "ghp" => "20",
					"count" => 1
				),

				// �� ���� �� � 4�
				1 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
                                        "bron1" => 2,
					"mfuvorot" => 15,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 2
				),

				// �� ���� �� �K 3�
				2=> array(
					"addname" => " (��)",
					"ginta" => 2,
                                        "bron1" => 2,
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
                                        "ghp" => "20",
					"count" => 3
				),
	);

         // ����� ������
	$ritems[270] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"bron1" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"bron4" => 3,
					"gsila" => 3,
					"ghp" => "20",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 2
				),
	);


         // ����� ����������� �������
	$ritems[24] = array(
				// ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"glovk" => 3,
					"ghp" => "20",
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"ghp" => "20",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"ghp" => "20",
					"mfakrit" => 15,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 3
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"mfuvorot" => 9,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 5
				),
				
	);
           // �������-��������
	$ritems[22] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"ginta" => 3,
					"ghp" => "20",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"glovk" => 2,
					 "ghp" => "20",
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "glovk",
					"count" => 2
				),

				// �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"ghp" => "20",
					"mfakrit" => 15,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 3
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"glovk" => 2,
					 "ghp" => "20",
					"mfauvorot" => 9,
					"directionmf" => "mfauvorot",
					"directionstats" => "glovk",
					"count" => 4
				),
	);
           // C������ ���������
	$ritems[32] = array(
				//  �� ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
                                        "gsila" => 2,
					"ghp" => "20",
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "gsila",
					"count" => 1
				),

				// �� ���� �� �� 4�
				1 => array(
					"addname" => " (��)",
                                        "ginta" => 2,
					"ghp" => "20",
					"mf�uvorot" => 15,
					"directionmf" => "mf�uvorot",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� �� 3�
				2 => array(
					"addname" => " (��)",
                                        "ginta" => 2,
					"ghp" => "20",
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 3
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
                                        "gsila" => 2,
					"ghp" => "20",
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 2
				),
	);
        // ���������� ������
	$ritems[28] = array(
				// ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"ginta" => 3,
					"ghp" => "20",
					"mfkrit" => 25,
					"directionmf" => "mfkrit",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� � 3�
				1 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"ghp" => "20",
					"mfkrit" => 9,
					"directionmf" => "mfkrit",
					"directionstats" => "ginta",
					"count" => 2
				),

				// �� ���� �� �� 4�
				3 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"ghp" => "20",
					"mfauvorot" => 15,
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 2
				
				),
	);

	// �������� ������ ���������
	$ritems[273] = array(
				//  ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"ghp" => "20",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 1
				),

				//  ���� �� ��, 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"ghp" => "20",
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
					"count" => 1
				),
	);

	// ������� ������
	$ritems[27] = array(
				//  �� ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"ghp" => "20",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 1
				),

				// �� ���� �� � 4�
				1 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"ghp" => "20",
					"mfuvorot" => 15,
					"directionmf" => "mfuvorot",
					"directionstats" => "gsila",
					"count" => 1
				),

				// �� ���� �� � 3�
				2 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"ghp" => "20",
					"mfuvorot" => 9,
					"directionmf" => "mfuvorot",
					"directionstats" => "gsila",
					"count" => 3
				),

				//   ���� �� �, 5�
				3 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"ghp" => "20",
					"mfkrit" => 25,
					"directionmf" => "mfkrit",
					"directionstats" => "gsila",
					"count" => 1
				),
	);

	// ������ ����� ��������
	$ritems[31] = array(
				//  �� ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"ghp" => "20",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"count" => 1
				),

				// �� ���� �� � 4�
				1 => array(
					"addname" => " (��)",
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"ghp" => "20",
					"mfuvorot" => 15,
					"directionmf" => "mfuvorot",
					"count" => 1
				),

				// �� ���� �� � 3�
				2 => array(
					"addname" => " (��)",
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"ghp" => "20",
					"mfuvorot" => 9,
					"directionmf" => "mfuvorot",
					"count" => 3
				),

				//   ���� �� �, 5�
				3 => array(
					"addname" => " (��)",
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"ghp" => "20",
					"mfkrit" => 25,
					"directionmf" => "mfkrit",
					"count" => 1
				),
	);
         // �������� ��������
	$ritems[231] = array(
				//  �� ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"mfkrit" => 25,
					"directionmf" => "mfkrit",
					"ghp" => "20",
					"count" => 1
				),

				// �� ���� �� �� 4�
				1 => array(
					"addname" => " (��)",
					"mf�krit" => 15,
					"directionmf" => "mf�krit",
					  "ghp" => "20",
					"count" => 2
				),

				// �� ���� �� �� 3�
				2 => array(
					"addname" => " (��)",
					"mfauvorot" => 9,
					"directionmf" => "mfauvorot",
					"ghp" => "20",
					"count" => 2
				)
				
	);

	

	// �������� ��������
	$ritems[263] = array(
				// ��� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"ghp" => "20",
					"count" => 2
				),
				// ���  �� ��, 5�
				1 => array(
					"addname" => " (��)",
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"ghp" => "20",
					"count" => 2
				)
	);

         // ������������ ��������
	$ritems[228] = array(
				//  �� ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"mf�krit" => 25,
					"directionmf" => "mf�krit",
					"ghp" => "20",
					"count" => 1
				),
				

				// �� ���� �� � 4�
				1 => array(
					"addname" => " (��)",
					"mfkrit" => 15,
					"directionmf" => "mfkrit",
					"ghp" => "20",
					"count" => 2
				),

				// �� ���� �� � 3�
				2 => array(
					"addname" => " (��)",
					"mfuvorot" => 9,
					"directionmf" => "mfuvorot",
					"ghp" => "20",
					"count" => 2

				),
	);

	// �������� �� ����� �������
	$ritems[178] = array(
				//  �� ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"mf�uvorot" => 25,
					"directionmf" => "mf�uvorot",
					"ghp" => "20",
					"count" => 1
				),

				// �� ���� �� �� 4�
				1 => array(
					"addname" => " (��)",
					"mfakrit" => 15,
					"directionmf" => "mfakrit",
					"ghp" => "20",
					"count" => 2
				),

				// �� ���� �� �� 3�
				2 => array(
					"addname" => " (��)",
					"mf�uvorot" => 9,
					"directionmf" => "mf�uvorot",
					"ghp" => "20",
					"count" => 2
				),
	);
         // �������� �������
	$ritems[177] = array(
				//  �� ���� �� �, 5�
				0 => array(
					"addname" => " (��)",
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"ghp" => "20",
					"count" => 1
				),

				// �� ���� �� �� 4�
				1 => array(
					"addname" => " (��)",
					"mf�uvorot" => 15,
					"directionmf" => "mf�uvorot",
					"ghp" => "20",
					"count" => 2
				),

				// �� ���� �� �� 3�
				2 => array(
					"addname" => " (��)",
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"ghp" => "20",
					"count" => 2
				),
	);

	// ������� ��������� ��� 
	$ritems[269] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron1" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"bron4" => 3,
					"mfakrit" => 25,
					"ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 2
				)
	);

	// ��� ��������
	$ritems[172] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"glovk" => 3,
					"bron1" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"bron4" => 3,
					"mfakrit" => 25,
					"ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfauvorot" => 25,
                                        "ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfakrit" => 15,
                                        "ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� �� 3�
				3 => array(
				        "addname" => " (��)",
					"glovk" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfauvorot" => 9,
					"ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "glovk",
					"count" => 2
				),
	);

        // ��� ������
	$ritems[35] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron1" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"bron4" => 3,
					"mfakrit" => 25,
                                        "ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfauvorot" => 25,
					"ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
					"count" => 1
				),

				// �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfakrit" => 15,
                                        "ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 1
				),

				// �� ���� �� �� 3�
				3 => array(
				        "addname" => " (��)",
					"gsila" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" => 2,
					"mfauvorot" => 9,
					"ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
					"count" => 2
				),
	);

        // ����������� ���
	$ritems[33] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron1" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"bron4" =>3,
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" =>2,
					"mfauvorot" => 25,
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� �� 4�
				2 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" =>2,
					"mfauvorot" => 15,
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 3
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"gsila" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" =>2 ,
					"mf�uvorot" => 9,
					"directionmf" => "mf�uvorot",
					"directionstats" => "ginta",
					"count" => 2
				),
	);

        // ��� ������
	$ritems[244] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"ginta" => 3,
					"bron1" => 3,
					"bron2" => 3,
					"bron3" => 3,
					"bron4" =>3,
					"mfauvorot" => 25,
					"ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� �� 5�
				1 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" =>2,
					"mfauvorot" => 25,
					"ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "ginta",
					"count" => 1
				),

				// �� ���� �� � 4�
				2 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" =>2,
					"mfakrit" => 15,
					"ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "ginta",
					"count" => 3
				),

				// �� ���� �� � 3�
				3 => array(
					"addname" => " (��)",
					"ginta" => 2,
					"bron1" => 2,
					"bron2" => 2,
					"bron3" => 2,
					"bron4" =>2,
					"mfuvorot" => 9,
					"ghp" => "20",
					"directionmf" => "mfuvorot",
					"directionstats" => "ginta",
					"count" => 3
				),
	);

        // ������ ��������
	$ritems[268] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron4" => 3,
					"mfakrit" => 25,
                                        "ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "gsila",
					"count" => 1
				),
				// ���� �� ��, 5�
				1 => array(
					"addname" => " (��)",
					"gsila" => 3,
					"bron4" => 3,
					"mfauvorot" => 25,
                                        "ghp" => "20",
					"directionmf" => "mfauvorot",
					"directionstats" => "gsila",
					"count" => 1
				)
	);

        // ������ ������ �������
	$ritems[174] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"glovk" => 3,
					"bron4" => 3,
					"mfakrit" => 25,
                                        "ghp" => "20",
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� � 5�
				1 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� � 4�
				2 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfuvorot" => 15,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 2
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 3
				),
	);

        // ������������ �������
	$ritems[233] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"glovk" => 3,
					"ghp" => "20",
					"bron4" => 3,
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� � 5�
				1 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� � 4�
				2 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfuvorot" => 15,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 2
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 3
				),
	);

	// ������ �����������
	$ritems[245] = array(
				// ���� �� ��, 5�
				0 => array(
					"addname" => " (��)",
					"glovk" => 3,
					"ghp" => "20",
					"bron4" => 3,
					"mfakrit" => 25,
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� � 5�
				1 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfuvorot" => 25,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 1
				),

				// �� ���� �� � 4�
				2 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfuvorot" => 15,
					"directionmf" => "mfuvorot",
					"directionstats" => "glovk",
					"count" => 2
				),

				// �� ���� �� �� 3�
				3 => array(
					"addname" => " (��)",
					"glovk" => 2,
					"ghp" => "20",
					"bron4" => 2,
					"mfakrit" => 9,
					"directionmf" => "mfakrit",
					"directionstats" => "glovk",
					"count" => 3
				),
	);

?>