<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
//$targ=($_POST['target']);
$baff_name='��� �������';
$baff_type=130;// 5007153 - ������ / 130,131,132,133,134,135,136  ������������ ������ 130


if ($ABIL>=1)
	{
		if ($ABIL==2)
		{
		$magic = magicinf(5017153);
		$magic['time']=360;
		}
		else
		{
		$magic = magicinf(5007153);
		}
	}

if ($user['battle'] > 0) 
{	
	echo "������ ������������ � ���..."; 
}
else {
	
//	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}'   LIMIT 1;"));
	$jert = $user;
	if (($jert['id'] ==$user['id'])  and (($magic['id']==130) OR ($magic['id']==131) OR ($magic['id']==132)) ) //  ��� ����� �������� ���� �������� �����������
	//if (1==2)
	{
	err('������ ������������ �� ���� :(');
	}
	else if (($jert['id'] >0) AND  ($jert['id_city']!=$user['id_city']) )
	{
	err('�������� � ������ ������...');
	}
	else if (($jert['id'] >0) AND  ($jert['room']!=$user['room']) )
	{
	err('�������� � ������ �������...');
	}
	else if (($jert['id'] >0) AND  ($jert['level']<8) AND ($jert['id'] !=$user['id']) )
	{
	err('�������� ���� 8-�� ������...');
	}	
	else if (($jert['id'] >0) AND  ($jert['mair']<=0) AND ($jert['id'] !=$user['id']) )
	{
	err('� ��������� '.$jert[login].' ����������� ��������: ������ �������!');
	}	
	elseif ($jert['id'] >0)
	{
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$jert['id']}' and (type='{$baff_type}' or type=150  or type=920 or type=930 ) ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��������� ��� ���� ����� ������!');
	}
	else
	 {
	$i_can_use_magic=false;	 
	 /*
	 12 - 1-10 �� ���� ������ � ���������
	11 - 1-8  �� ���� ������ � ���������
	10 - 1-6  �� ���� ������ � ���������
	9 - 1-4   �� ���� ������ � ���������
	8 - 1-2   �� ���� ������ � ���������
	 */
	 $far[8]=2;
	 $far[9]=4;	 
	 $far[10]=6;	 
	 $far[11]=8;	 
	 $far[12]=10;	 
	 
	 $addsqlin="";
	 
	 if ( (($magic['id']==133) OR ($magic['id']==134) OR ($magic['id']==135) OR ($magic['id']==136)  OR ($magic['id']==137)  OR ($magic['id']==138)  OR ($magic['id']==5007153) OR ($magic['id']==5017153)    ) AND ($jert['id'] == $user['id']) )
	 {
	 
	 $lpow=12;
	 
	 //���� �� ���� � ���� � ���� ���� ������
	 	if ($user['mair']<3)
	 	{
	 	$addsqlin=" ,  `lastup`=3  ";
	 	}
	 	
	 
	 }
	 else
	 {
	 $lpow=$user[level];	 
	 }
	 
	 
	 if ($lpow>12) {$lpow=12;}
	 if ($lpow<=7) {$lpow=8;}	 
	 
	 $air= $far[$lpow];

 	$magictime=time()+($magic['time']*60);
	 
	 			//���� ���� � ���
	 			if ($jert[battle]>0)
	 			{
	 			//� ���	 
		
	 			$nmana[130]=10;
	 			$nmana[131]=20;	 			
	 			$nmana[132]=30;	 			

	 			
	 			$nmana[133]=10;
	 			$nmana[134]=20;	 			
	 			$nmana[135]=30;	 	
	 			$nmana[136]=30;	
	 			 		 			
	 			$nmana[137]=30;		 			
	 			$nmana[138]=30;		 			
	 			
	 			$nmana[5007153]=30;	 		 			
	 			$nmana[5017153]=30;	 		 			
	 			
	 					
	 			
	 			$need_mana=$nmana[$magic[id]]; //����� ��� ������
	 				if ($jert[mana]>=$need_mana)
	 				{
	 				//��������� ���� ����
	 				mysql_query("UPDATE users set mana=mana-'{$need_mana}'  where id='{$jert[id]}' and mana>='{$jert[mana]}' LIMIT 1; ");
		 				if (mysql_affected_rows()>0)
						{
			 			$i_can_use_magic=true;	 				
			 			}
	 				}
	 				else
	 				{
	 				//�� ������� ����
 					err('� ��������� '.$jert[login].' �� ������� ���� ��� ���� ����� � ���!');
	 				}
	 			
	 			}
	 			else
	 			{
				//�� � ���	 			
	 			$i_can_use_magic=true;
	 			}
	 			
	 		
	 		
		 		if ($i_can_use_magic==true)
	 			{
	 				if ($rowm['img']=='')
	 					{
	 					$rowm['img']='scroll_wrath_air0_2.gif';						
	 					}
	 					
	 				$rkm=get_rkm_bonus_by_magic($magic[id]);
	 				
	 				mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}', add_info='{$rowm['img']}:{$air}:{$rkm}'  ,`time`='".$magictime."', `owner`='{$jert[id]}' ".$addsqlin."  ;");//������� � ����
					if (mysql_affected_rows()>0)
					{
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					//����� � ����
					/* ��� �������� ���� ����� */
					$mags[130]=$rowm['img'];
					$mags[131]=$rowm['img'];
					$mags[132]=$rowm['img'];
					$mags[133]=$rowm['img'];
					$mags[134]=$rowm['img'];
					
					
					$mags[135]='scroll_wrath_air0_2.gif';	
					$mags[136]='scroll_wrath_air3_2.gif';	
					$mags[137]='scroll_wrath_air2_2.gif';	
					$mags[138]='scroll_wrath_air1_2.gif';											
					
					$mags[5007153]='scroll_wrath_air0_2.gif';						
					$mags[5017153]='scroll_wrath_air0_2.gif';											

					$magstxt[130]='��� ������� I';
					$magstxt[131]='��� ������� II';
					$magstxt[132]='��� ������� III';
					$magstxt[133]='��� ������� I';
					$magstxt[134]='��� ������� II';
					
					
					$magstxt[135]='����� ������ ���� �������';	
					$magstxt[136]='����������� ������ ���� �������';						
					$magstxt[137]='������� ������ ���� �������';						
					$magstxt[138]='������� ������ ���� �������';																
					
					
					$magstxt[5007153]='��� �������';						
					$magstxt[5017153]='��� �������';						

					
					
					$mag_gif='<img src=i/magic/'.$mags[$magic[id]].'>';

					 if(($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
					 {
					 $fuser['login']='<i>���������</i>';
					 $sexi='�����������';
					 $fuser['id']=$user['hidden'];					 					 
					 }
					 else
					 {
					 $fuser=load_perevopl($user); 
					 if ($fuser['sex'] == 1) {$sexi='�����������';  }	else { $sexi='������������';}
					 }
					 
					 if(($jert['hidden'] > 0) and ($jert['hiddenlog'] ==''))
					 {
					 $fjert['login']='<i>���������</i>';
					$fjert['id']=$jert['hidden'];					 					 
					 }
					 else
					 {
					 $fjert=load_perevopl($jert); 
					 }
					 
					 
					
					
					if ($fjert['id']==$fuser['id'])
					{
					$mag_gif='<img src=http://i.oldbk.com/i/sh/'.$rowm['img'].'>';
					addch($mag_gif." ".link_for_user($fuser)." ����������� ����� &quot;".link_for_magic($rowm['img'],$magstxt[$magic[id]])."&quot;, �� ����.",$user['room'],$user['id_city']);					
					}
					else
					{
					$mag_gif='<img src=http://i.oldbk.com/i/sh/'.$rowm['img'].'>';
					addch($mag_gif." ".link_for_user($fuser)." ����������� ����� &quot;".link_for_magic($rowm['img'],$magstxt[$magic[id]])."&quot;, �� ��������� ".link_for_user($fjert).".",$user['room'],$user['id_city']);
					}
					
		
					$bet=1;
					$sbet = 1;
					echo "��� ������ ������!";
					$MAGIC_OK=1;

						try {
							global $app;

							$UserObj = new \components\models\User($user);
							$Quest = $app->quest->setUser($UserObj)->get();

							$Checker = new \components\Component\Quests\check\CheckerMagic();
							$Checker->magic_id = $baff_type;
							if (($Item = $Quest->isNeed($Checker)) !== false) {
								$Quest->taskUp($Item);
							}

							unset($UserObj);
							unset($Quest);
						} catch (Exception $ex) {
							\components\Helper\FileHelper::writeException($ex, 'cast_mearth');
						}
						
				 	}
				}
	   }
	
	}
	else
	     {
	     err('��������  "'.$targ.'"  �� ������!');
	     }


	} 
	



?>
