<?php
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }
//$targ=($_POST['target']);
$baff_name='���� �����';
$baff_type=150;//151/152/153/154/155/156/5007152- ������������ ������ 150

if ($ABIL>=1)
	{

		if ($ABIL==2)
		{
		$magic = magicinf(5017152);		
		$magic['time']=360;
		}
		else
		{
		$magic = magicinf(5007152);	
		}
	}


if ($user['battle'] > 0) 
{	
	echo "������ ������������ � ���..."; 
}
else {
	
//	$jert = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `login` = '{$targ}'   LIMIT 1;"));
	$jert = $user;
	if (($jert['id'] ==$user['id'])  and (($magic['id']==150) OR ($magic['id']==151) OR ($magic['id']==152)) ) // ������ ����� �� ���� � ���� �����
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
	else if (($jert['id'] >0) AND  ($jert['mfire']<=0) AND ($jert['id'] !=$user['id']) )
	{
	err('� ��������� '.$jert[login].' ����������� ��������: ������ ����!');
	}	
	elseif ($jert['id'] >0)
	{
	$get_test_baff= mysql_fetch_array(mysql_query("select * from effects where owner='{$jert['id']}' and (type='{$baff_type}' or type=130 or type=920  or type=930) ; "));
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
	 $far[8]=10;
	 $far[9]=10;	 
	 $far[10]=10;	 
	 $far[11]=10;	 
	 $far[12]=10;	 
	 
	 $addsqlin="";
	 
	 if ( (($magic['id']==153) OR ($magic['id']==154)OR ($magic['id']==156) OR ($magic['id']==157) OR ($magic['id']==158)  OR ($magic['id']==155) OR ($magic['id']==5007152) OR ($magic['id']==5017152)    ) AND ($jert['id'] == $user['id']) )
	 {
	 
	 $lpow=12;
	 
	 //���� �� ���� � ���� � ���� ���� ������
	 	if ($user['mfire']<3)
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
	 
	 $fire= $far[$lpow];

 	$magictime=time()+($magic['time']*60);
	 
	 			//���� ���� � ���
	 			if ($jert[battle]>0)
	 			{
	 			//� ���	 			
	 			$nmana[150]=10;
	 			$nmana[151]=20;	 			
	 			$nmana[152]=30;	 			
	 			
	 			$nmana[153]=10;
	 			$nmana[154]=20;	 			
	 			$nmana[155]=30;	 	
	 			$nmana[156]=30;	 	 			
	 			$nmana[157]=30;	 		 			
	 			
	 			$nmana[5007152]=30;	 		 			
	 			$nmana[5017152]=30;	 		 				 					
	 			
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
	 					$rowm['img']='scroll_wrath_ares0_2.gif';						
	 					}
	 				$rkm=get_rkm_bonus_by_magic($magic[id]);
	 				mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}', add_info='{$rowm['img']}:{$fire}:{$rkm}'  ,`time`='".$magictime."', `owner`='{$jert[id]}' ".$addsqlin."  ;");//������� � ����
					if (mysql_affected_rows()>0)
					{
					if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
					elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }
					//����� � ����
					$mags[150]=$rowm['img'];
					$mags[151]=$rowm['img'];
					$mags[152]=$rowm['img'];
					$mags[153]=$rowm['img'];
					$mags[154]=$rowm['img'];
					
					
					$mags[155]='scroll_wrath_ares0_2.gif';	
					$mags[156]='scroll_wrath_ares3_2.gif';						
					$mags[157]='scroll_wrath_ares2_2.gif';						
					$mags[158]='scroll_wrath_ares1_2.gif';			
					$mags[5007152]='scroll_wrath_ares0_2.gif';						
					$mags[5017152]='scroll_wrath_ares0_2.gif';						

					$magstxt[150]='���� ����� I';
					$magstxt[151]='���� ����� II';
					$magstxt[152]='���� ����� III';
					$magstxt[153]='���� ����� I';
					$magstxt[154]='���� ����� II';
					
					$magstxt[155]='����� ������ ����� �����';	
					$magstxt[156]='����������� ������ ����� �����';	
					$magstxt[157]='������� ������ ����� �����';						
					$magstxt[158]='������� ������ ����� �����';				
							
					$magstxt[5007152]='���� �����';						
					$magstxt[5017152]='���� �����';						
					
					
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
