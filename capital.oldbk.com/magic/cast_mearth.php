<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
//$targ=($_POST['target']);
$baff_name='����� ������';
$baff_type=920;// 5007154 - ������ /920,921,922,923,924,925,926  ������������ ������ 920

if ($ABIL>=1)
	{
	
		if ($ABIL==2)
		{
		$magic = magicinf(5017154);
		$magic['time']=360;
		}
		else
		{
		$magic = magicinf(5007154);
		}
	}


if ($user['battle'] > 0) 
{	
	echo "������ ������������ � ���..."; 
}
else {
	
//	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}'   LIMIT 1;"));
	$jert = $user;
	if (($jert['id'] ==$user['id'])  and (($magic['id']==920) OR ($magic['id']==921) OR ($magic['id']==922)) ) //  ��� ����� �������� ���� �������� �����������
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
	else if (($jert['id'] >0) AND  ($jert['mearth']<=0) AND ($jert['id'] !=$user['id']) )
	{
	err('� ��������� '.$jert[login].' ����������� ��������: ������ �����!');
	}	
	elseif ($jert['id'] >0)
	{
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$jert['id']}' and (type='{$baff_type}' or type=150 or type=130 or type=930) ; "));
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
	 
	 if ( (($magic['id']==923) OR ($magic['id']==924) OR ($magic['id']==925)  OR ($magic['id']==926)  OR ($magic['id']==927)   OR ($magic['id']==928)  OR ($magic['id']==5007154) or ($magic['id']==5017154)  ) AND ($jert['id'] == $user['id']) )
	 {
	 
	 $lpow=12;
	 
	 //���� �� ���� � ���� � ���� ���� ������
	 	if ($user['mearth']<1)
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
	 
	 $earth= $far[$lpow];

 	$magictime=time()+($magic['time']*60);
	 
	 			//���� ���� � ���
	 			if ($jert[battle]>0)
	 			{
	 			//� ���	 
		
	 			$nmana[920]=10;
	 			$nmana[921]=20;	 			
	 			$nmana[922]=30;	 			

	 			
	 			$nmana[923]=10;
	 			$nmana[924]=20;	 			
	 			$nmana[925]=30;	 	

	 			$nmana[926]=30;	 		 			
	 			$nmana[927]=30;	 
	 			$nmana[928]=30;	 	 				 			
	 			
	 			$nmana[5007154]=30;	 		 
	 			$nmana[5017154]=30;	 		 	 			
	 						
	 					
	 			
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
	 					$rowm['img']='scroll_wrath_ground0_2.gif';
	 					}
	 				$rkm=get_rkm_bonus_by_magic($magic[id]);
	 				mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}', add_info='{$rowm['img']}:{$earth}:{$rkm}'  ,`time`='".$magictime."', `owner`='{$jert[id]}' ".$addsqlin."  ;");//������� � ����
					if (mysql_affected_rows()>0)
					{
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					//����� � ����
					/* ��� �������� ���� ����� */
					$mags[920]=$rowm['img'];
					$mags[921]=$rowm['img'];
					$mags[922]=$rowm['img'];
					$mags[923]=$rowm['img'];
					$mags[924]=$rowm['img'];
					
					
					$mags[925]='scroll_wrath_ground0_2.gif';	
					$mags[926]='scroll_wrath_ground3_2.gif';					
					$mags[927]='scroll_wrath_ground2_2.gif';					
					$mags[928]='scroll_wrath_ground1_2.gif';															
					
					$mags[5007154]='scroll_wrath_ground0_2.gif';						
					$mags[5017154]='scroll_wrath_ground0_2.gif';											
					

					$magstxt[920]='����� ������ I';
					$magstxt[921]='����� ������ II';
					$magstxt[922]='����� ������ III';
					$magstxt[923]='����� ������ I';
					$magstxt[924]='����� ������ II';
					
					
					$magstxt[925]='����� ������ ������ �������';	
					$magstxt[926]='����������� ������ ������ �������';						
					$magstxt[927]='������� ������ ������ �������';						
					$magstxt[928]='������� ������ ������ �������';																
					
					
					$magstxt[5007154]='����� ������';
					$magstxt[5017154]='����� ������';
					
					
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
