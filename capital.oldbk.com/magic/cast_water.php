<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
//$targ=($_POST['target']);
$baff_name='���� �����';
$baff_type=930;// 5007155 - ������ /930,931,932,933,934,935,936  ������������ ������ 930

if ($ABIL>=1)
	{

		if ($ABIL==2)
		{
		$magic = magicinf(5017155);		
		$magic['time']=360;
		}
		else
		{
			$magic = magicinf(5007155);
		}
	}



if ($user['battle'] > 0) 
{	
	echo "������ ������������ � ���..."; 
}
else {
	
//	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}'   LIMIT 1;"));
	$jert = $user;
	if (($jert['id'] ==$user['id'])  and (($magic['id']==930) OR ($magic['id']==931) OR ($magic['id']==932)) ) //  ��� ����� �������� ���� �������� �����������
	//if (1==2)
	{
	err('������ ������������ �� ���� :(');
	}
	else  if (($jert['id'] >0) AND  ($jert['id_city']!=$user['id_city']) )
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
	else if (($jert['id'] >0) AND  ($jert['mwater']<=0) AND ($jert['id'] !=$user['id']) )
	{
	err('� ��������� '.$jert[login].' ����������� ��������: ������ ����!');
	}	
	elseif ($jert['id'] >0)
	{
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$jert['id']}' and (type='{$baff_type}' or type=150 or type=920 or type=130) ; "));
	if (($get_test_baff[id] > 0) )
	{
		err('�� ��������� ��� ���� ����� ������!');
	}
	else
	 {
	$i_can_use_magic=false;	 
	 /*
		1   �� ���� ������ � ���������
	 */
	 $far[8]=1;
	 $far[9]=1;	 
	 $far[10]=1;	 
	 $far[11]=1;	 
	 $far[12]=1;	 
	 
	 $addsqlin="";
	 
	 if ( (($magic['id']==933) OR ($magic['id']==934) OR ($magic['id']==935)OR ($magic['id']==936) OR ($magic['id']==937) OR ($magic['id']==938) OR ($magic['id']==5007155) OR ($magic['id']==5017155)    ) AND ($jert['id'] == $user['id']) )
	 {
	 
	 $lpow=12;
	 
	 //���� �� ���� � ���� � ���� ���� ������
	 	if ($user['mwater']<1)
	 	{
	 	$addsqlin=" ,  `lastup`=1  ";
	 	}
	 	
	 
	 }
	 else
	 {
	 $lpow=$user[level];	 
	 }
	 
	 
	 if ($lpow>12) {$lpow=12;}
	 if ($lpow<=7) {$lpow=8;}	 
	 
	 $water= $far[$lpow];

 	$magictime=time()+($magic['time']*60);
	 
	 			//���� ���� � ���
	 			if ($jert[battle]>0)
	 			{
	 			//� ���	 
		
	 			$nmana[930]=10;
	 			$nmana[931]=20;	 			
	 			$nmana[932]=30;	 			

	 			
	 			$nmana[933]=10;
	 			$nmana[934]=20;	 			
	 			$nmana[935]=30;	 	
	 			
	 			$nmana[936]=30;	 	
	 			$nmana[937]=30;	 		 			
	 			$nmana[938]=30;	 		 			
	 			
	 			$nmana[5007155]=30;	 		 			
	 			$nmana[5017155]=30;	 		 				 			
	 			
	 					
	 			
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
	 					$rowm['img']='scroll_wrath_water0_2.gif';
	 					}
	 					
	 				$rkm=get_rkm_bonus_by_magic($magic[id]);
	 			
	 				mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$rowm['img']}:{$baff_name}:{$rkm}', add_info='0'  ,`time`='".$magictime."', `owner`='{$jert[id]}' ".$addsqlin."  ;");//������� � ����
					if (mysql_affected_rows()>0)
					{
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					//����� � ����
					/* ��� �������� ���� ����� */
					$mags[930]=$rowm['img'];
					$mags[931]=$rowm['img'];
					$mags[932]=$rowm['img'];
					$mags[933]=$rowm['img'];
					$mags[934]=$rowm['img'];

					
					$mags[935]='scroll_wrath_water0_2.gif';	
					$mags[936]='scroll_wrath_water3_2.gif';						
					$mags[937]='scroll_wrath_water2_2.gif';						
					$mags[938]='scroll_wrath_water1_2.gif';																
					$mags[5007155]='scroll_wrath_water0_2.gif';
					$mags[5017155]='scroll_wrath_water0_2.gif';					


					$magstxt[930]='���� ����� I';
					$magstxt[931]='���� ����� II';
					$magstxt[932]='���� ����� III';
					$magstxt[933]='���� ����� I';
					$magstxt[934]='���� ����� II';
					
					$magstxt[935]='����� ������ ����� ������';	
					$magstxt[936]='����������� ������ ����� ������';	
					$magstxt[937]='������� ������ ����� ������';	
					$magstxt[938]='������� ������ ����� ������';											
					
					$magstxt[5007155]='���� �����';						
					$magstxt[5017155]='���� �����';											
					
					$mag_gif='<img src=i/magic/'.$mags[$magic[id]].'>';

					 if(($user['hidden'] > 0) and ($user['hiddenlog'] ==''))
					 {
					 $fuser['login']='<i>���������</i>';
					$fuser['id']=$user['hidden'];					 					 
					 $sexi='�����������';
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
