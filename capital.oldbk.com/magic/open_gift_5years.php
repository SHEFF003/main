<?
if (!($_SESSION['uid'] >0)) header("Location: index.php");

$rowm = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`inventory` WHERE `owner` = ".$_SESSION['uid']." AND `id` = ".$_GET['use'].";"));

if((int)$rowm['magic'] > 0) {
	$magic = mysql_fetch_array(mysql_query("SELECT * FROM `magic` WHERE `id` = ".$rowm['magic']." LIMIT 1;"));
}

$begin1=mktime(0,0,1,01,14,date("Y")); // ��������� ����

if($rowm[id]>0 && $magic[id]>0) {
	echo "<font color=red><B>";

	if($begin1 < time()) {
		if ($user['battle']>0) { 
			echo "�� � ���!"; 
		} else {

			$last_days = 30;
			$godendo = mktime(23,59,59,2,13,date("Y"));

	       		$gifts=array(
			'5 ��� �����!'=>	array('name'=>'5 ��� �����!',			'maxdur'=>'1',	'cost'=>'5','owner'=>$user[id],'img'=>'5Y_card.gif',		'type'=>'200',	'magic'=>0, 	'massa'=>0.1,	'isrep'=>0,'prototype'=>15276,	'otdel'=>72,	'add_time'=>time(),	'goden'=>'',		'dategoden'=>'','letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'������������'=>	array('name'=>'������������',			'maxdur'=>'10',	'cost'=>'5','owner'=>$user[id],'img'=>'mirror.gif',		'type'=>'12',	'magic'=>1616,	'massa'=>1,	'isrep'=>0,'prototype'=>119,  	'otdel'=>51,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'���������� �����'=>	array('name'=>'���������� �����',		'maxdur'=>'10',	'cost'=>'5','owner'=>$user[id],'img'=>'antimirror.gif',		'type'=>'12',	'magic'=>1717,	'massa'=>1,	'isrep'=>0,'prototype'=>120,	'otdel'=>51,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'�����������'=>		array('name'=>'�����������',			'maxdur'=>'10',	'cost'=>'5','owner'=>$user[id],'img'=>'helpbattle_e.gif', 	'type'=>'12',	'magic'=>5353,	'massa'=>1,	'isrep'=>0,'prototype'=>353,	'otdel'=>51,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'�������� ���������'=>	array('name'=>'�������� ���������',		'maxdur'=>'10',	'cost'=>'5','owner'=>$user[id],'img'=>'attackb.gif',		'type'=>'12',	'magic'=>4545,	'massa'=>1,	'isrep'=>0,'prototype'=>134,	'otdel'=>51,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'������ III'=>		array('name'=>'������ III',			'maxdur'=>'10',	'cost'=>'5','owner'=>$user[id],'img'=>'call_animals_3e.gif',	'type'=>'12',	'magic'=>5007004,'massa'=>0.5,	'isrep'=>0,'prototype'=>14003,	'otdel'=>51,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'������ III'=>		array('name'=>'������ III',			'maxdur'=>'10',	'cost'=>'5','owner'=>$user[id],'img'=>'recall_animals_3e.gif',	'type'=>'12',	'magic'=>5007005,'massa'=>0.5,	'isrep'=>0,'prototype'=>15003,	'otdel'=>51,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),		
			'����'=>		array('name'=>'����������� ����',		'maxdur'=>'20',	'cost'=>'5','owner'=>$user[id],'img'=>'gift_tort5year.gif',		'type'=>'50',	'magic'=>8,	'massa'=>1,	'isrep'=>0,'prototype'=>105,	'otdel'=>61,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'���� ����� III'=>		array('name'=>'���� ����� III',		'maxdur'=>'10',	'cost'=>'30','owner'=>$user[id],'img'=>'wrath_ares_90_ekr.gif',		'type'=>'12',	'magic'=>155,	'massa'=>0.1,	'isrep'=>0,'prototype'=>150155,	'otdel'=>5,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'������ ���� 100'=>		array('name'=>'������ ���� 100',		'maxdur'=>'1',	'cost'=>'1','owner'=>$user[id],'img'=>'exp_runs_0100.gif',		'type'=>'50',	'magic'=>87,	'massa'=>1,	'isrep'=>0,'prototype'=>571,	'otdel'=>6,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����'),
			'���� �������'=>		array('name'=>'���� �������',		'maxdur'=>'1',	'cost'=>'5','owner'=>$user[id],'img'=>'lord_ch_item3.gif',		'type'=>'50',	'magic'=>0,	'massa'=>0.1,	'isrep'=>0,'prototype'=>3001003,	'otdel'=>6,	'add_time'=>time(),	'goden'=>$last_days,	'dategoden'=>$godendo,	'letter'=>'����������� � 5-�� ��������� ���������� �����! ������ ���������� ����, ������������� ����, ������� ������� � ����� ����� � ������� ������! � ����������! � ���������, ������������� �����',	'present'=>'������������� �����')						
			);


	   		$txt='';
	      		foreach ($gifts as $k=>$v) {
	            		$sql='insert into oldbk.inventory
			         (name, 		maxdur,	cost,		owner,		img,	type,		magic,		letter,		massa,		isrep,		prototype,	otdel,	add_time,		present_text,		present, goden, dategoden)
			    	 VALUES

			    	 ("'.$v[name].'",'.$v[maxdur].','.$v[cost].','.$v[owner].',"'.$v[img].'",'.$v[type].','.$v[magic].',"'.$v[letter].'",'.$v[massa].','.$v[isrep].','.$v[prototype].','.$v[otdel].','.$v[add_time].',"'.$v[present_text].'","'.$v[present].'","'.$v[goden].'","'.$v[dategoden].'");';

				mysql_query($sql);


                		$it_id[id]=mysql_insert_id();
	            		$it_id[idcity]=$user[id_city];
	            		$dressid = get_item_fid($it_id);

				$rec['owner']=$user[id];
				$rec['owner_login']=$user[login];
				$rec['owner_balans_do']=$user[money];
				$rec['owner_balans_posle']=$user[money];
				$rec['target']=0;
				$rec['target_login']='�������� �������.';
				$rec['type']=300;//
				$rec['sum_kr']=0;
				$rec['sum_ekr']=0;
				$rec['sum_kom']=0;
				$rec['item_id']=$dressid;
				$rec['item_name']=$v[name];
				$rec['item_count']=1;
				$rec['item_type']=$v[type];
				$rec['item_cost']=$v[cost];
				$rec['item_dur']=0;
				$rec['item_maxdur']=$v[maxdur];
				$rec['item_ups']=0;
				$rec['item_unic']=0;
				$rec['item_incmagic']='';
				$rec['item_incmagic_count']='';

				add_to_new_delo($rec);
                		$txt.=$k.', ';
            		}

            		$txt=substr($txt, 0,-2);

			echo "�� ������� �������! <br>
			�� ��������: ".$txt;
			$bet=1;
			$sbet = 1;
		 }
	} else {		echo '�������� ��� �� ��������...';	}
	echo "</B></FONT>";
}
?>