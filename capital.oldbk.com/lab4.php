<?

//��������� ��� ����
///////////////////////////
    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {
    $miniBB_gzipper_encoding = 'x-gzip';
    }
    if (strpos(' ' . $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {
    $miniBB_gzipper_encoding = 'gzip';
    }
    if (isset($miniBB_gzipper_encoding)) {
    ob_start();
    }
    function percent($a, $b) {
    $c = $b/$a*100;
    return $c;
    }
//////////////////////////////
//ini_set('display_errors','On');
//v.11 3D
$maxkoldrop=2; // ������������ ������� ������ � 1 ���
$rep_kof=2; // ��������� ��������� �� �� ������ ������� �� ��� �������
$MAX_DEAD=5;

		session_start();

		if (!($_SESSION['uid'] >0)) { header("Location: index.php");die(); }
		include "connect.php";
		include "functions.php";
		header("Cache-Control: no-cache");
		//if ($user[klan]=='radminion') {  echo "Admin-info:<!- GZipper_Stats -> <br>"; }		
		if ($user['lab'] == 0) { header("Location: startlab.php"); die(); }
		if ($user['lab'] == 1) { header("Location: lab.php"); die(); }
		if ($user['lab'] == 2) { header("Location: lab2.php"); die(); }
		if ($user['lab'] == 3) { header("Location: lab3.php"); die(); }

	//	if ($user[klan]!='radminion') { die();}

		$LAB=4;
		
		if ($user['battle'] > 0) {  header("Location: fbattle.php"); die();  }
		if (!(isset($_SESSION['looklab']))) { $_SESSION['looklab']=0 ;}
		if (!(isset($_SESSION['lab_bg']))) { $_SESSION['lab_bg']=0 ;}		

		
		if ($_GET['look']==1)
		{
			if ($_SESSION['looklab']<=0)
			{
			$_SESSION['looklab']=270;
			}
			else
			{
			$_SESSION['looklab']-=90;
			}
		}
		elseif ($_GET['look']==2)
		{
			if ($_SESSION['looklab']>=270)
			{
			$_SESSION['looklab']=0;
			}
			else
			{
			$_SESSION['looklab']+=90;
			}
		}

			$nap[0][1]=1; 	$nap[0][2]=2; 	$nap[0][3]=3; 	$nap[0][4]=4;  			
			$nap[90][1]=4; 	$nap[90][2]=1;  $nap[90][3]=2;	$nap[90][4]=3;
			$nap[180][1]=3;	$nap[180][2]=4;	$nap[180][3]=1;	$nap[180][4]=2;
			$nap[270][1]=2;	$nap[270][2]=3;	$nap[270][3]=4;	$nap[270][4]=1;

	   if ($_SERVER["SERVER_NAME"]=='capitalcity.oldbk.com') { $cityname='capitalcity' ;  }
	    else if ($_SERVER["SERVER_NAME"]=='avaloncity.oldbk.com') { $cityname='avaloncity' ;  }
		else {$cityname='noname' ; }

		
			//��������� ��� ������ � ������ �� �������
			$doors=array(1=>"D",2=>"Z",3=>"X",4=>"C");
			$dkey=array(1=>3301,2=>3302,3=>3303,4=>3304); // l_keys.gif  w_keys.gif e_keys.gif  k_keys.gif
			/////////////////////////////////////////////
		if ($user[id]==14897)
		 {
		 $inff=$_SERVER["REQUEST_URI"];
		//addchp ('<font color=red>��������!</font>user:'.$user[login].'/log:'.$inff,'{[]}Bred{[]}');
		 }

function check_and_clean($oldmap)
{
 if ($oldmap>0)
 	{
	$get_test=mysql_fetch_array(mysql_query("select * from `labirint_users` where `map`='{$oldmap}' Limit 1 "));
		
		if ($get_test['owner']>0)
		{
		//���� ��� ���� �� ���� �����
		return;
		}
		else
		{
		//����� ���... ��������
		//������ ����� �� �����
		mysql_query("DELETE FROM `labirint_items` where `map`='".$oldmap."'; ");

		//������� ���� �����
		$oldmap_file='/www/capitalcity.oldbk.com/labmaps/'.$oldmap.'.map';
		if(file_exists($oldmap_file)) 
			{
			unlink($oldmap_file);		
			}
		}
	}

return;
}

function sumrak_count_test($x,$y)
{
global $map,$Aitems;

$mp=array('R','�','J',"O",'H','D','Z','X','C','S','P','�','�','2','5','L','W','Y','K','�','�','�','B');

  	if (in_array($map[$x][$y],$mp))
  	{
  	 // ������� �� �������
  	return false;
  	}

  	if ($Aitems[$x][$y]=='�')
  	{
  	 // ������� �� �������
  	return false;
  	}  	

  	if ($Aitems[$x][$y]=='�')
  	{
  	 // ������� �� �������
  	return false;
  	}    	

  	if ($Aitems[$x][$y]=='�')
  	{
  	 // ������� �� �������
  	return false;
  	}  	
  	
	if ($Aitems[$x][$y]=='B')
  	{
  	 // ������� �� �������
  	return false;
  	}  

return true;
}

function bg_item_fix($proto)
{
$arra=array(3301,3302,3303,3304,3301,3333,15561,15562,15563,15564,15565,15566,15567,15568,15551,15552,15553,15554,15555,15556,15557,15558);
if (in_array($proto,$arra))
	{
	return true;
	}
return false;
}

////
function get_door_xy($D)
{
global $map,$Aitems,$labpoz;
if (($map[$labpoz[x]][$labpoz[y]+1]==$D) AND ($Aitems[$labpoz[x]][$labpoz[y]+1]!=$D))
		{
		$DOOR[is]=true;
		$DOOR[x]=$labpoz[x];
		$DOOR[y]=$labpoz[y]+1;
		return $DOOR;
		}
else
	if (($map[$labpoz[x]][$labpoz[y]-1]==$D) AND ($Aitems[$labpoz[x]][$labpoz[y]-1]!=$D))
		{
		$DOOR[is]=true;
		$DOOR[x]=$labpoz[x];
		$DOOR[y]=$labpoz[y]-1;
		return $DOOR;
		}
else
	if (($map[$labpoz[x]-1][$labpoz[y]]==$D) AND ($Aitems[$labpoz[x]-1][$labpoz[y]]!=$D))
		{
		$DOOR[is]=true;
		$DOOR[x]=$labpoz[x]-1;
		$DOOR[y]=$labpoz[y];
		return $DOOR;
		}
else
	if (($map[$labpoz[x]+1][$labpoz[y]]==$D) AND ($Aitems[$labpoz[x]+1][$labpoz[y]]!=$D))
		{
		$DOOR[is]=true;
		$DOOR[x]=$labpoz[x]+1;
		$DOOR[y]=$labpoz[y];
		return $DOOR;
		}
else
	{
	return false;
	}

}
/////

function move_remember($Shovka,$lpoz)
{

if (isset($Shovka['owner']))
	{
		$upd=explode(":",$Shovka['add_info']);
		$upd[2]=$lpoz['x'];
		$upd[3]=$lpoz['y'];
		mysql_query("UPDATE `oldbk`.`effects` SET `add_info`='".implode(":",$upd)."' WHERE `id`='{$Shovka['id']}' limit 1;");
		
		if (mysql_affected_rows()>0) 
			{
			return true;			
			}
	}

return false;
}

function print_doski($level)
{
global $map,$view3dx,$g,$labpoz,$left,$top,$view3dy;

$d3_out='';

if ($level==0)
{
if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='') or ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='M'))
				{
				//����� �����
						if ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='') or ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='M') )
						{
						//���� ������ ������
						$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+50).'px;top:'.($top+193).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_left_1.png  alt="�����" title="�����"   border=0></DIV>';
						}
						else
						{
						//��� ������
						$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+200).'px;top:'.($top+193).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_right_1.png  alt="�����" title="�����"   border=0></DIV>';
						}

				}
				else
				{
				//����� ����� ���
				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+140).'px;top:'.($top+193).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_center_1.png  alt="�����" title="�����"   border=0></DIV>';
				}
}
else
if ($level==1)
{
if ( ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='') or ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='M') )
				{
				//����� �����
						if ( ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='M') )
						{
						//���� ������ ������
						$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+93).'px;top:'.($top+153).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_left_2.png  alt="�����" title="�����"   border=0></DIV>';
						}
						else
						{
						//��� ������
						$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+200).'px;top:'.($top+153).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_right_2.png  alt="�����" title="�����"   border=0></DIV>';
						}

				}
				else
				{
				//����� ����� ���
				$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+153).'px;top:'.($top+153).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_center_2.png  alt="�����" title="�����"   border=0></DIV>';
				}
}
else
if ($level==2)
{
if ( ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='') or ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='M') )
				{
				//����� �����
						if ( ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='') or ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='M') )
						{
						//���� ������ ������
						$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+120).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_left_3.png  alt="�����" title="�����"   border=0></DIV>';
						}
						else
						{
						//��� ������
						$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+200).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_right_3.png  alt="�����" title="�����"   border=0></DIV>';
						}

				}
				else
				{
				//����� ����� ���
				$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_center_3.png  alt="�����" title="�����"   border=0></DIV>';
				}
}
else
if ($level==3)
{
if ( ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='') or ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='M') )
				{
				//����� �����
						if ( ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='') or ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='M') )
						{
						//���� ������ ������
						$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+132).'px;top:'.($top+123).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_left_4.png  alt="�����" title="�����"   border=0></DIV>';
						}
						else
						{
						//��� ������
						$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+200).'px;top:'.($top+123).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_right_4.png  alt="�����" title="�����"   border=0></DIV>';
						}

				}
				else
				{
				//����� ����� ���
				$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+166).'px;top:'.($top+122).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/desk_center_4.png  alt="�����" title="�����"   border=0></DIV>';
				}
}


return $d3_out;
}

function use_item_update($item)
{
    if ( ($item['duration']+1)>=$item['maxdur'] )
    	{
	            //�������
   			mysql_query("delete from oldbk.inventory where id={$item[id]} limit 1 ; ");
   			if (mysql_affected_rows()>0) 
   				{
   				return true;
   				}
    	}
    	else
    	{
    	//-1
    		mysql_query("UPDATE oldbk.inventory SET duration=duration+1 where id={$item[id]} limit 1; ");
   			if (mysql_affected_rows()>0) 
   				{
   				return true;
   				}    		
    	}
return false;
}

function insert_lab_item($dress,$user)
{
if ($dress['name']=='') return false;

$dress['lab_flag']=1;

if ( ($dress['id']==4307) OR ($dress['id']==4308) OR ($dress['id']==4310)  )
	{
	$dress['lab_flag']=0;	
	}
	
if ($dress['labonly']>0)
	{
	$dress['nclass']=1;
	}

mysql_query("INSERT INTO oldbk.`inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`, `img_big`,`getfrom`,`rareitem`,`ekr_flag` ,`duration`,`maxdur`,`isrep`,`nclass`,
					`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`labonly`,`labflag`,`present`,`group`,`letter`,`sowner`,`ecost`,`idcity`
				)
				VALUES
				('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}',  '{$dress['img_big']}' , '14','{$dress['rareitem']}','{$dress['ekr_flag']}',{$dress['duration']},{$dress['maxdur']},{$dress['isrep']},'{$dress['nclass']}','{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$dress['labonly']}','{$dress['lab_flag']}','{$dress['present']}','{$dress['group']}','{$dress['letter']}','{$dress['sowner']}','{$dress['ecost']}','{$user[id_city]}'
				) ;");

		           				if (mysql_affected_rows()>0) 
							{
								if  ($dress['labonly']==0)
									{
							     		//add to new delo
									$rec['owner']=$user['id']; 
									$rec['owner_login']=$user['login'];
									$rec['owner_balans_do']=$user['money'];
									$rec['owner_balans_posle']=$user['money'];					
									$rec['target']=0;
									$rec['target_login']='�������� �����';
									$rec['type']=700;
									$rec['item_id']="cap".mysql_insert_id();
									$rec['item_name']=$dress['name'];
									$rec['item_count']=1;
									$rec['item_type']=$dress['type'];
									$rec['item_cost']=$dress['cost'];
									$rec['item_ecost']=$dress['ecost'];
									$rec['item_dur']=$dress['duration'];
									$rec['item_maxdur']=$dress['maxdur'];
									$rec['battle']=$user['battle'];
									add_to_new_delo($rec); 
									}
								return true;
							}
return false;
}

	
///////////////////���������� ��������
if ($_POST['settings_save'])
			{
				if ($_POST['settings_north']=='true') { $sn=1;} else { $sn=0;}
				mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'settings_north', '$sn' ) ON DUPLICATE KEY UPDATE `val` ='$sn';");
				if ($_POST['settings_norotation']=='true') { $sr=1;} else { $sr=0;}
				mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'settings_norotation', '$sr' ) ON DUPLICATE KEY UPDATE `val` ='$sr';");							
				if ($_POST['settings_control']=='true') { $sc=1;} else { $sc=0;}
				mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'settings_control', '$sc' ) ON DUPLICATE KEY UPDATE `val` ='$sc';");											
				if ($_POST['settings_invert']=='true') { $sc=1;} else { $sc=0;}
				mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'settings_invert', '$sc' ) ON DUPLICATE KEY UPDATE `val` ='$sc';");															
				
				
			}	
////////////load user poz///////////////////////////////////////////////////////////////////////////////////
$labpoz=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_users` WHERE `owner` = '{$_SESSION['uid']}' LIMIT 1;"));

	if (($labpoz['flr']>=1) and ($labpoz['flr']<=4))
	{
	$lab_floor=(int)$labpoz['flr'];

	$lab_floor_next=$lab_floor+1;
	$lab_floor_next_str[2]='������';
	$lab_floor_next_str[3]='������';		
	$lab_floor_next_str[4]='���������';				
	$lab_floor_next_str=$lab_floor_next_str[$lab_floor_next];
	
	include ("labconfig_4_".$lab_floor.".php"); // ��������� ������
	}
	else
	{
	include ("labconfig_s3d.php"); // ��������� ������ - ��� ������� - ��������
	}

////////////////////////////////////////////load map file//////////////////////////////////////////////////
		$mapid=$labpoz[map];

			//��� ��������� �����
			if ( (isset($_GET[lookmap])) AND ((int)($_GET[lookmap]) >0 ))
			{
			$mmitid=(int)($_GET[lookmap]);
			$tested=mysql_fetch_array(mysql_query("select * from oldbk.inventory where id='{$mmitid}' and owner='{$user[id]}' and setsale=0 and prototype=50078 and labflag>0 and labonly>0 and letter!='' LIMIT 1;"));
			if ($tested[id]>0)
				{
				$INinlude=true;
				include("./magic/lookmap.php");
				die();
				}
				else
				{
				unset($_GET[lookmap]);
				}
			}


		$map_echo="�����:<b>".$mapid."</b><br>";
		
		//$map=file('/www/capitalcity.oldbk.com/labmaps/'.$mapid.'.map');
		$mfile='/www/capitalcity.oldbk.com/labmaps/'.$mapid.'.map';
		if (file_exists($mfile)) 
			{
				$map=file($mfile);
			} else 
			{
			copy('/www/capitalcity.oldbk.com/labmaps/default_lab4.map', $mfile);
			$map=file($mfile);
			}

function do_auto($itm)
{
global $user;
	if ($itm>0)
	{
		if (getcheck_auto_get($user)==1)
			{
			$AUTO_GET_ITEM="<script> location.href='?getitem={$itm}'; </script>";
			}
			else
			{
			$AUTO_GET_ITEM="";
			}
		echo $AUTO_GET_ITEM;
	}
}

$LAST_ITEM_TO_GET=0;
	
	/*if ($user['id']==14897)
		{
		echo $map[0]."<br>";
		}
	*/

/////////LOAD MY EFFECTS
$SUMRAK=0;
//�������� ������ ��������
	$load_eff=mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND (`type` in (11,12,13,7777,75)) ");
	$STRAHOVKA=array();
	while ($eff = mysql_fetch_array($load_eff))	
		{
			if ($eff['type']==7777)
				{
				$STRAHOVKA=$eff;
				}
			elseif ($eff['type']==75)
				{
				$addinf=explode("::",$eff['add_info']);
				$SUMRAK=$addinf[1];
				$SUMRAK_info=$eff;
				$SUMRAK_info['img']=$addinf[0];
				$SUMRAK_info['add_info']=$addinf[1];				
				}
		}

//////////////////////////////////////////////////////////////////////////
///mobs
/// ��������� - ���������� - ����������� ��
$stopt=count($map);
$JMOB=array();
$JMOB_id=array();

$JMOBFIX=array();

$RMOB=array();
$RMOB_id=array();
$RMOB_kol=array();



$SJMOB=array();
$SJMOB_id=array();

$jm_count=0;
$sjm_count=0;
$rjm_count=0;

$jmmob=count($jmob); // ������� ����
$sjmmob=count($sjmob); // ������� ����
$rjmmob=count($mob); // ������� ����

//load
for ($ii=1;$ii<$stopt;$ii++)
 for ($jj=1;$jj<$stopt;$jj++)
	{
	if ($map[$ii][$jj]=='J')
		{
		$jm_count++;
		if ($jm_count>$jmmob) { $jm_count=1;}
		$JMOB[$ii][$jj]=$jmob[$jm_count][name];
		$JMOB_id[$ii][$jj]=$jmob[$jm_count][id];
		$JMOBFIX[$jmob[$jm_count][id]]=array("top"=>$jmob[$jm_count]['top'] , "left" => $jmob[$jm_count]['left'] );
		}
		elseif ($map[$ii][$jj]=='�')
		{
		$sjm_count++;
		if ($sjm_count>$sjmmob) { $sjm_count=1;}
		$SJMOB[$ii][$jj]=$sjmob[$sjm_count][name];
		$SJMOB_id[$ii][$jj]=$sjmob[$sjm_count][id];
		}
		elseif ($map[$ii][$jj]=='R')
		{
		$rjm_count++;
		if ($rjm_count>$rjmmob) { $rjm_count=1;}
		$RMOB[$ii][$jj]=$mob[$rjm_count][name];
		$RMOB_id[$ii][$jj]=$mob[$rjm_count][id];
		$RMOB_kol[$ii][$jj]=$mob[$rjm_count][kol];
		}
	}


/*
$JMOB[30][22]="TEST-ALL";
$JMOB_id[30][22]=279;

		"id" => 219); +++
		"id" => 220);+++
		"id" => 221);+++
		"id" => 222);+++
		"id" => 223);+++
		"id" => 224);+++
		"id" => 227);+++
		"id" => 228);+++
		"id" => 275);+++
		"id" => 274);	+++
		"id" => 276);	+++	
		"id" => 277);	+++	
		"id" => 278);	+++
		"id" => 279);	+
*/


///////////////////////////////////////////////////////////////////////////
// Load quests is
/*
     if ($_SESSION['quest']=='')
     				{
     				$qu=mysql_fetch_array(mysql_query("select * from users_quest where owner='{$user[id]}' and status=0 and city='{$cityname}' ;"));
     				}

             if   (($qu[id] >0) OR ($_SESSION['quest']=='ihave'))
		      {
		  		$_SESSION['quest']='ihave';
     			        if (($qu[id] >0)OR($_SESSION['questid']==''))
     		        	{
				$_SESSION['questid']=$qu[quest_id];
				$_SESSION['questdata']=mysql_fetch_array(mysql_query("select * from quests where id='{$_SESSION['questid']}' ;"));
 				 }

       		      if ($_SESSION['questdata'][id] > 0)
       		          {

	                      //���������� ����� ����
		                include('./quests/quest'.$_SESSION['questdata'][id].'.php');
             	                  
             	                   
             	                   echo "<b>���� �������:".$_SESSION['questdata'][qname].":";
             	                   get_qcount($_SESSION['questdata'],$user,$mapid);
		                   echo "</b><br>";
		                   
				$fmap='/www/capitalcity.oldbk.com/labmapsq/'.$mapid.'-'.$user[id].'.qst';

				 if (file_exists($fmap))
			           {
				   // echo "The file $fmap exists";
				    //���� ���� ��������� �� ���� ������ - �.�.
				    $qdata_array = file($fmap);
						foreach($qdata_array as $qi=>$qstring)
					                        {
					                        $qmas=explode("::","$qstring");
					                        $Qmap[$qmas[0]][$qmas[1]]=(int)$qmas[2];
					                        if ( ($map[$qmas[0]][$qmas[1]]!='R') AND ($map[$qmas[0]][$qmas[1]]!='J') AND ($map[$qmas[0]][$qmas[1]]!='�')  ) //����������� ���� ����� �� ������
					                          {
					                          $map[$qmas[0]][$qmas[1]]='Q'; // ����������� � ����� ���� ����� ����������� ������
					                          }
								}

				   } else
				   {
				    //echo "The file $fmap does not exist";
				    //����� �������� ��� ���� ��������� �����
				    make_qstart($_SESSION['questdata'],$user,$mapid) ;

				   }
			}
		      }
		      else
		      {
		      $_SESSION['quest']='none';
		      }
//$Qmap - ����� � ������������ - ��������� ���������
*/
/////////////////////////////////////////////////////////////////////////
		//setup start point
		if ( ($labpoz[x] ==0 ) OR ($labpoz[y] ==0 ) )
		{
						if ($labpoz[dead] >= $MAX_DEAD)
						{
						$_GET['exit']=true;
						$msg = "<font color=red>�� ��������� ��������...</font><br>";
						
						$_SESSION['quest']='';
						$_SESSION['questid']='';
						unset($_SESSION['quest']); //�������
					     	unset($_SESSION['questdata']);//�������
					     	unset($_SESSION['questid']);//�������
					     	
						}
						else
						{
							
							if (($labpoz[dead] > 0) and isset($STRAHOVKA['owner']) )
									{
									$need_poz=explode(":",$STRAHOVKA['add_info']);
									mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`,`owner`,`val`,`add_info`) values('{$mapid}','T','".$need_poz[2]."','".$need_poz[3]."','1','1','{$user['id']}','1','���������')  ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
								     	//������� ���������
								     	mysql_query("DELETE FROM `oldbk`.`effects` WHERE owner='{$user['id']}' and `type`=7777 ");
									}
						
							foreach($map as $k=>$v ) if (strpos($v,"I")) $startx=$k;
							//echo $startx;
							mysql_query("UPDATE `labirint_users` SET `x`='".$startx."', `y`=1 WHERE `owner`='".$user[id]."' LIMIT 1;");
							//
							$labpoz[x]=$startx;
							$labpoz[y]=1;
							// add hp if dead and hp=0
							 if ($user[hp]<=0)
							 	{
							 	mysql_query("UPDATE `users` SET `hp`=30 WHERE `id`='".$user[id]."' LIMIT 1;");
							 	}
						}
		}



////////////////////LOAD ITEMS POZ ///////////////////////////////////////////////////////////////////////
$items=mysql_query("SELECT * FROM `labirint_items` WHERE  (`owner`=0 OR `owner`='{$user[id]}')  and  `active`=1 and  `map`='".$mapid."'  ;");

// ���� ������� ���� ����� ������ ����...+
			$Aitems=array();
			$ukaz[1]='�';
			$ukaz[2]='�';
			$ukaz[3]='�';
			$ukaz[4]='�';
			while ($row = mysql_fetch_array($items))
			{
			 if ($row[item]=='T')
			 	{
 				$map[$row[x]][$row[y]]='T';
				$add_info='';
				if ($row['add_info']!='') $add_info=' ('.$row['add_info'].')';
						
 				$Aitems[$row[x]][$row[y]]='������ X:'.$row[x].'/Y:'.$row[y].$add_info;
			 	
			 	/*if ($user['id']==14897)
			 		{
			 		echo $Aitems[$row[x]][$row[y]] ;
			 		echo "<br>";
			 		}
			 	*/
			 	}
			 else
			 if (($row[item]=='�') )
			 	{
 				$map[$row[x]][$row[y]]='O';
				$Aitems[$row[x]][$row[y]]=$row[item];
				$Aitems_val[$row[x]][$row[y]]=$row[val];
				$Aitems_count[$row[x]][$row[y]]=$row[count]; 				
			 	} 
			 else
			 if ($row[item]=='9')
			 	{
 				$map[$row[x]][$row[y]]=$ukaz[$row[val]]; //����������� ������ �����
			 	}
			 	else
			 	{
			 		    if (!((strpos($Aitems[$row[x]][$row[y]], '������') !== false)))
			 		    	{
						$Aitems[$row[x]][$row[y]]=$row[item];
						$Aitems_val[$row[x]][$row[y]]=$row[val];
						$Aitems_count[$row[x]][$row[y]]=$row[count];
						}
				}
			}

//if ($user[id]==14897) { echo "<br>��".$Aitems[$labpoz[x]][$labpoz[y]]; }

if (($Aitems[$labpoz[x]][$labpoz[y]]!='R') AND ($Aitems[$labpoz[x]][$labpoz[y]]!='J') AND ($Aitems[$labpoz[x]][$labpoz[y]]!='�') )  // �� ������ Q-�����
{
   if ($Qmap[$labpoz[x]][$labpoz[y]]!='') // ������ ������� ���� � ����� ������
     {
     // ���� ���� ��������� ���� �� ����� �� ���� ��������� ��������� ��� ���
      // echo "Q-item<br>";
         if ($Aitems[$labpoz[x]][$labpoz[y]]=='Q')
            {
            // if ($user[id]==14897) { echo "���� � ���� ���<br>"; }
            }
            else
            {
          //  if ($user[id]==14897) { echo "��� � ���� ���� ����������<br>"; }
            make_qpoint($_SESSION['questdata'],$user,$mapid);
            $Aitems[$labpoz[x]][$labpoz[y]]='Q';
            $Aitems_val[$labpoz[x]][$labpoz[y]]=$Qmap[$labpoz[x]][$labpoz[y]];
            $Aitems_count[$labpoz[x]][$labpoz[y]]=1;
            }
     }
}
//if ($user[id]==14897) {echo "<br>�����".$Aitems[$labpoz[x]][$labpoz[y]];}

	/////////LOAD USERS VARs//////////////////
	$uvars=mysql_query("SELECT * FROM `labirint_var` WHERE  `owner`='".$user[id]."' ;");
	$print_effe_lab='';
	/// ������ ������ � ������ ���������� � �� ������ ������ � � ��������� �� ��������
	while ($row = mysql_fetch_array($uvars))
	{
			if ($row['var']=='settings_north')
			{
			//��������� ������� �����
				$settings_north=$row['val'];
			}
			elseif ($row['var']=='settings_norotation')
			{
			//��������� �� ������� ���������
			$settings_norotation=$row['val'];
			}
			elseif ($row['var']=='settings_control')
			{
			//��������� �� ������� ���������
			$settings_control=$row['val'];
			}			
			elseif ($row['var']=='settings_invert')
			{
			//��������� �� ������� ���������
			$settings_invert=$row['val'];
			}
			else
			{
			//��������
			$delay=round(($row[val]-time())/60,2);
			if ($delay < 0 )
			{
			if ($row['var']=='timer_trap') { $_SESSION['time_trap']=0;}

			mysql_query("DELETE FROM `labirint_var` WHERE  (`var`='timer_trap' or `var`='poison_trap' or `var`='stat_trap' )     and  `owner`='".$user[id]."' and `var`='".$row['var']."' ;");

					if ($row['var']=='poison_trap')
					{
							// del poison flag
					mysql_query("UPDATE users set `podarokAD`=0 where id='{$user[id]}';");
					}
			if ($row['var']=='stat_trap')
					{
					// del poison
					mysql_query("UPDATE users set sila=sila+1, lovk=lovk+1, inta=inta+1  where id='{$user[id]}';");
					}

			$row['var']='';

			}
			else
			{
				if ($row['var']=='poison_trap')
					{
				// ������
					$print_effe_lab.="<img src=i/magic/event_poison_trap.gif alt='��' title='��'>-<i>������� ����� -20HP � ������ (��������:".prettyTime(null,$row[val]).")</i><br>\n";

				//������ - ���� � ����!!


					}
				else if ($row['var']=='timer_trap')
					{
				// ������
				$print_effe_lab.="<img src=i/magic/event_timer_trap.gif alt='����' title='����'>-<i>����� �������� +6 ������� (��������:".prettyTime(null,$row[val]).")</i><br>\n";
				$_SESSION['time_trap']=1;
				//������
					}
			else if ($row['var']=='stat_trap')
					{
				// ������
				$print_effe_lab.="<img src=i/magic/event_stat_trap.gif alt='��' title='��'>-<i>��������� �������������� (��������:".prettyTime(null,$row[val]).")</i><br>\n";
				//������
					}

			}
		   }
		}


	if ($settings_north==1)
	{
		if ($_GET['goto']=='p'.$nap[$_SESSION['looklab']][4])
			{
			echo '���';
					if ($_SESSION['looklab']>=270)
						{
						$_SESSION['looklab']=0;
						}
						else
						{
						$_SESSION['looklab']+=90;
						}
			}			
		elseif ($_GET['goto']=='p'.$nap[$_SESSION['looklab']][2])
			{
			echo '����';
					if ($_SESSION['looklab']<=0)
							{
							$_SESSION['looklab']=270;
							}
							else
							{
							$_SESSION['looklab']-=90;
							}
			}						
	}

/////////
$g=$_SESSION['looklab'];

//echo $g;



$view3dx[0][42]=-4; $view3dx[0][41]=-4; $view3dx[0][4]=-4; $view3dx[0][43]=-4; $view3dx[0][44]=-4;			       $view3dy[0][42]=-2;  $view3dy[0][41]=-1; $view3dy[0][4]=0; $view3dy[0][43]=1; $view3dy[0][44]=2; // 0 - �������� , ���������� 4-�� ����
$view3dx[0][32]=-3; $view3dx[0][31]=-3; $view3dx[0][3]=-3; $view3dx[0][33]=-3; $view3dx[0][34]=-3;			       $view3dy[0][32]=1;  $view3dy[0][31]=-1; $view3dy[0][3]=-1; $view3dy[0][33]=1; $view3dy[0][34]=0; // 0 - �������� , ���������� 3-�� ����
$view3dx[0][22]=-2; $view3dx[0][21]=-2; $view3dx[0][2]=-2; $view3dx[0][23]=-2; $view3dx[0][24]=-2;			       $view3dy[0][22]=0;  $view3dy[0][21]=-1; $view3dy[0][2]=-1; $view3dy[0][23]=1; $view3dy[0][24]=1; // 0 - �������� , ���������� 2-�� ����
$view3dx[0][12]=-1; $view3dx[0][11]=-1; $view3dx[0][1]=-1; $view3dx[0][13]=0; $view3dx[0][14]=0;			       $view3dy[0][12]=0;  $view3dy[0][11]=-1; $view3dy[0][1]=1;       $view3dy[0][13]=0; $view3dy[0][14]=0; // 0 - �������� , ���������� 1-�� ����
$view3dx[0][52]=-1; $view3dx[0][51]=-1; $view3dx[0][5]=0; $view3dx[0][53]=0; 	$view3dx[0][54]=0;			       	$view3dy[0][52]=1;  $view3dy[0][51]=-1; $view3dy[0][5]=-1; $view3dy[0][53]=1; 		$view3dy[0][54]=0; // 0 - �������� , ���������� 0-�� ����


$view3dx[90][42]=2;  $view3dx[90][41]=1; $view3dx[90][4]=0; $view3dx[90][43]=-1; $view3dx[90][44]=-2; 		 	    $view3dy[90][42]=-4;  $view3dy[90][41]=-4; $view3dy[90][4]=-4; $view3dy[90][43]=-4; $view3dy[90][44]=-4; // 90 - �������� , ���������� 4-�� ����
$view3dx[90][32]=-1; $view3dx[90][31]=1; $view3dx[90][3]=1; $view3dx[90][33]=-1; $view3dx[90][34]=0;			   $view3dy[90][32]=-3;  $view3dy[90][31]=-3; $view3dy[90][3]=-3; $view3dy[90][33]=-3; $view3dy[90][34]=-3; // 90 - �������� , ���������� 3-�� ����
$view3dx[90][22]=0; $view3dx[90][21]=1; $view3dx[90][2]=1; $view3dx[90][23]=-1; $view3dx[90][24]=-1;			  $view3dy[90][22]=-2;  $view3dy[90][21]=-2; $view3dy[90][2]=-2; $view3dy[90][23]=-2; $view3dy[90][24]=-2; // 90 - �������� , ���������� 2-�� ����
$view3dx[90][12]=0; $view3dx[90][11]=1; $view3dx[90][1]=-1; $view3dx[90][13]=0; $view3dx[90][14]=0;			       $view3dy[90][12]=-1;  $view3dy[90][11]=-1; $view3dy[90][1]=-1;       $view3dy[90][13]=0; $view3dy[90][14]=0; // 90 - �������� , ���������� 1-�� ����
$view3dx[90][52]=-1; $view3dx[90][51]=1; $view3dx[90][5]=1; $view3dx[90][53]=-1; 	$view3dx[90][54]=0;			       	    $view3dy[90][52]=-1;  $view3dy[90][51]=-1; $view3dy[90][5]=0; $view3dy[90][53]=0; 		$view3dy[90][54]=0; // 90 - �������� , ���������� 0-�� ����


$view3dx[180][42]=4;  $view3dx[180][41]=4; $view3dx[180][4]=4; $view3dx[180][43]=4; $view3dx[180][44]=4; 		$view3dy[180][42]=2;  $view3dy[180][41]=1; $view3dy[180][4]=0;  $view3dy[180][43]=-1; $view3dy[180][44]=-2; // 180 - �������� , ���������� 4-�� ����
$view3dx[180][32]=3; $view3dx[180][31]=3; $view3dx[180][3]=3; $view3dx[180][33]=3; $view3dx[180][34]=3;			$view3dy[180][32]=-1;  $view3dy[180][31]=1; $view3dy[180][3]=1; $view3dy[180][33]=-1; $view3dy[180][34]=0; // 180 - �������� , ���������� 3-�� ����
$view3dx[180][22]=2; $view3dx[180][21]=2; $view3dx[180][2]=2; $view3dx[180][23]=2; $view3dx[180][24]=2;		 	$view3dy[180][22]=0;  $view3dy[180][21]=1; $view3dy[180][2]=1;  $view3dy[180][23]=-1; $view3dy[180][24]=-1; // 180 - �������� , ���������� 2-�� ����
$view3dx[180][12]=1; $view3dx[180][11]=1; $view3dx[180][1]=1; $view3dx[180][13]=0; $view3dx[180][14]=0;			$view3dy[180][12]=0;  $view3dy[180][11]=1; $view3dy[180][1]=-1; $view3dy[180][13]=0; $view3dy[180][14]=0; // 180 - �������� , ���������� 1-�� ����
$view3dx[180][52]=1; $view3dx[180][51]=1; $view3dx[180][5]=0; $view3dx[180][53]=0; 	$view3dx[180][54]=0;		    $view3dy[180][52]=-1;  $view3dy[180][51]=1; $view3dy[180][5]=1; $view3dy[180][53]=-1; 		$view3dy[180][54]=0; // 180 - �������� , ���������� 0-�� ����


$view3dx[270][42]=-2;  $view3dx[270][41]=-1; $view3dx[270][4]=0; $view3dx[270][43]=1; $view3dx[270][44]=2; 			$view3dy[270][42]=4;  $view3dy[270][41]=4; $view3dy[270][4]=4; $view3dy[270][43]=4; $view3dy[270][44]=4; // 270 - �������� , ���������� 4-�� ����
$view3dx[270][32]=1; $view3dx[270][31]=-1; $view3dx[270][3]=-1; $view3dx[270][33]=1; $view3dx[270][34]=0;			$view3dy[270][32]=3;  $view3dy[270][31]=3; $view3dy[270][3]=3; $view3dy[270][33]=3; $view3dy[270][34]=3; // 270 - �������� , ���������� 3-�� ����
$view3dx[270][22]=0; $view3dx[270][21]=-1; $view3dx[270][2]=-1; $view3dx[270][23]=1; $view3dx[270][24]=1;		 	$view3dy[270][22]=2;  $view3dy[270][21]=2; $view3dy[270][2]=2; $view3dy[270][23]=2; $view3dy[270][24]=2; // 270 - �������� , ���������� 2-�� ����
$view3dx[270][12]=0; $view3dx[270][11]=-1; $view3dx[270][1]=1; $view3dx[270][13]=0; $view3dx[270][14]=0;			$view3dy[270][12]=1;  $view3dy[270][11]=1; $view3dy[270][1]=1; $view3dy[270][13]=0; $view3dy[270][14]=0; // 270 - �������� , ���������� 1-�� ����
$view3dx[270][52]=1; $view3dx[270][51]=-1; $view3dx[270][5]=-1; $view3dx[270][53]=1; 	$view3dx[270][54]=0;		    	    $view3dy[270][52]=1;  $view3dy[270][51]=1; $view3dy[270][5]=0; $view3dy[270][53]=0; 		$view3dy[270][54]=0; // 270 - �������� , ���������� 0-�� ����


///////////////////LOAD MY TEAM - NEW  ///////////////////////////////////////////////////////////////////////////
$team=mysql_query("SELECT id, login, level, klan, align, l.x , l.y ,  l.flr  from `users` u LEFT JOIN labirint_users l ON u.id=l.owner where `room`='".$user['room']."' and `id`!='".$user[id]."' ;");

		$TA=array();
		$Tcount=0;
		while ($reamrow = mysql_fetch_array($team))
		{
		$Tcount++;
				if ($reamrow['flr']>0)
					{
					$str_rfloor='<small>'.$reamrow['flr'].'-� ��.</small>';
					}
					else
					{
					$str_rfloor='';
					}
		
			$Displ_team.=" ".s_nick($reamrow['id'],$reamrow['align'],$reamrow['klan'],$reamrow['login'],$reamrow['level']) ." X[".$reamrow[x]."]/Y[".$reamrow[y]."] ".$str_rfloor."<br>";
			$TA[$reamrow[x]][$reamrow[y]].=$reamrow['login']." ";
		}


/////////////////IPUT VAR USERS///////////////////////////////////////////////////////////////////////////
	if (($_REQUEST[talk]==75)and($map[$labpoz[x]][$labpoz[y]]=='2'))
	{
	// �������� �� �������� - ������ ������� �� ������ ����� �� ����� ��� ��������
	$OPEN_FROM_LAB=TRUE;
	$T_BOT=75;

	include('qbattle.php');
	die();
	}
else
	if (($_REQUEST['next_floor']=='yes')and($map[$labpoz[x]][$labpoz[y]]=='5'))
	{
	// �������� �� �������� - ������ ������� �� ������ ����� �� ����� 
	//������������� ����� ����. ���� ���� ����
	
	if (($lab_floor_next>=2) and ($lab_floor_next<=4))
		{
		 //1. ��������� ���� �� ��� ����������� �� ����� �����

		 $strow='flr'.$lab_floor_next;
		 
		 if ($labpoz[$strow]>0)
		 	{

		 	//���� ������ �����
		 	$floormapid=$labpoz[$strow];
		 	//���� ����� ���� � ��� �����
			 	
				// �������� ������ ������� �����
				$next_floor_map='/www/capitalcity.oldbk.com/labmaps/'.$floormapid.'.map';
				if(file_exists($next_floor_map)) 
					{
					///����� ����
			 		mysql_query("update `labirint_users` SET `map`='{$labpoz[$strow]}',  x=0,y=0,flr='{$lab_floor_next}' where `owner`='{$user['id']}'; ");
		
					//�������� ������ �����
					check_and_clean($labpoz['map']);
					
					
					//������������
					header("Location: lab4.php?start_next_floor=".mt_rand(1111,9999));
					die(); 
					}
					else
					{
					echo "������ ����� �����!";
					}
		 	}
		 	else
		 	{
		 	//��� ������ - � ������
		 	//1. ������� ����� �� ����� �� ������
	 		mysql_query("INSERT INTO `oldbk`.`labirint_zayav` SET `lab`=10");
		 		if (mysql_affected_rows()>0) 
		 			{
			 		$new_floor_map_id=mysql_insert_id();
					//2. ����������� ���� ������ �������
					mysql_query("update `labirint_users` SET `{$strow}`='{$new_floor_map_id}' where `owner` in (select id from users where room='{$user['room']}' ) ");
				 	//3. ������� �� ���� ���� �����
					// �������� ������ ������� �����
					$next_floor_map='/www/capitalcity.oldbk.com/labmaps/'.$new_floor_map_id.'.map';
					if(!(file_exists($next_floor_map)) )
						{
						//��� ����� �����
						$gen_map=true;
						include ('labogenerator4_'.$lab_floor_next.'.php');
						}
				 	//4. ��������� ���� ����
				 	mysql_query("update `labirint_users` SET `map`='{$new_floor_map_id}', x=0,y=0,flr='{$lab_floor_next}' where `owner`='{$user['id']}'; ");
				 	
				 	//5. ������ ������ ������ 
				 		mysql_query("DELETE FROM `labirint_zayav` WHERE `Id`='{$new_floor_map_id}'");
				 		
					//�������� ������ �����
					check_and_clean($labpoz['map']);
				 		
					//������������
					header("Location: lab4.php?start_next_floor=".mt_rand(1111,9999));
					die(); 
					}
		 	}
		}
	}
else
	if (($_GET[e])and($map[$labpoz[x]][$labpoz[y]+1]=='1'))
	{
	// �������� �� �������� - ������ ������� �� ������ ����� �� ����� ��� ��������
	//$OPEN_FROM_LAB=TRUE;
	//include('kuznya.php');
	die();
	}
else
if (($_GET[exit_good])and($map[$labpoz[x]][$labpoz[y]]=='F'))
		{
		// ���������� �����
		$_SESSION['quest']='';
		$_SESSION['questid']='';
		unset($_SESSION['quest']); //�������
	     	unset($_SESSION['questdata']);//�������
	     	unset($_SESSION['questid']);//�������
	     	unset($_SESSION['time_trap']);//�������
	     	//��������� �� ���?



		$msg="�������...� ������ ������.";
		// ������� ������ ��������
		 if(!$_SESSION['beginer_quest'][none])
		     {
		     	  $last_q=check_last_quest(9);
			      if($last_q)
			      {
			          quest_check_type_91($last_q);
			      }
		     }

		//$get_mobs=mysql_fetch_array(mysql_query("select count(*) as mobs from labirint_items where map={$mapid} AND  item='R' and val=0"));
		$get_mobs=mysql_fetch_array(mysql_query("select val  from labirint_var where owner='{$user[id]}' and var='labkillrep'; "));

		$add_rep=$rep_kof*(int)($get_mobs[0]);

		//perm
		$ar = 0;
		if ($user['prem']) $ar += 0.1;
		
						//�������������� �����
						$eff = mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}'  and `type` = '9101' ;")); 	
						if ($eff['id']>0)
							{
							 $ar +=$eff['add_info'];
							}
		
		$ua = intval($user['align']);
		if ($ua == 1) $ua = 6;
		if (GetOpRs() == $ua) $ar += 0.05; 

		$add_rep = intval($add_rep * (1+$ar));
		
		$add_rep=(int)($add_rep);
		addch("<img src=i/magic/event_exit_yes.gif> {$user[login]} ����� ����� �� ���������, � ������� <b>".$add_rep."</b> ���������!");
		addchp ('<font color=red>��������!</font> �� �������� <b>'.$add_rep.'</b> ��������� �� ����������� ���������!','{[]}'.$user['login'].'{[]}',45,$user['id_city']);
					//new delo
					$rec['owner']=$user[id]; 
					$rec['owner_login']=$user[login];
					$rec['owner_balans_do']=$user[money];
					$rec['owner_balans_posle']=$user[money];					
					$rec['owner_rep_do']=$user[repmoney];
					$rec['owner_rep_posle']=($user[repmoney]+$add_rep);					
					$rec['target']=0;
					$rec['target_login']='����2';
					$rec['type']=251;
					$rec['sum_kr']=0;
					$rec['sum_ekr']=0;
					$rec['sum_kom']=0;
					$rec['sum_rep']=$add_rep;					
					$rec['item_id']='';
					$rec['item_name']="";
					$rec['item_count']=0;
					$rec['item_type']=0;
					$rec['item_cost']=0;
					$rec['item_dur']=0;
					$rec['item_maxdur']=0;
					$rec['item_ups']=0;
					$rec['item_unic']=0;
					$rec['item_incmagic']='';
					$rec['item_incmagic_count']='';
					$rec['item_arsenal']='';
					add_to_new_delo($rec);

		mysql_query("DELETE FROM `labirint_users` WHERE `owner`='".$user[id]."';");
		mysql_query("DELETE FROM `labirint_var` WHERE owner='{$user[id]}' and var='labkillrep'; ");

	     	// ������� ������� ���� ���� �� �����
	     	$i_have_st=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_var` WHERE  var='stat_trap'  and  `owner`='".$user[id]."' ;"));
		if ($i_have_st[owner]==$user[id])
		{
		// ����
		mysql_query("UPDATE users set sila=sila+1, lovk=lovk+1, inta=inta+1  where id='{$user[id]}';");
		}

		mysql_query("DELETE FROM `labirint_var` WHERE  (`var`='stat_trap'  or   `var`='timer_trap'  or `var`='poison_trap' or `var`='labcount' ) and `owner`='".$user[id]."';");

		if ($user['klan']!='radminion')
		{
		mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'labstarttime', '".time()."' ) ON DUPLICATE KEY UPDATE `val` ='".time()."';");
		}

		mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'labgoodexit', '1' ) ON DUPLICATE KEY UPDATE `val` =`val`+1;");

	//��������� �� ����� �� �� ��� ������ ���� ��������
	$testdress=mysql_fetch_array(mysql_query("select `id` from oldbk.`inventory` where `dressed`=1 and `labonly`=1 and `owner`='".$user[id]."' LIMIT 1; "));
	if ($testdress[id] >0)
		{
		//���� �������
		undressall($user[id]);
		}



		mysql_query("DELETE FROM oldbk.`inventory` WHERE  (`labonly`=1 ) and `owner`='".$user[id]."';");
		mysql_query("UPDATE oldbk.`inventory` SET `labflag`=0  WHERE  `labflag`=1 and `owner`='".$user[id]."';");



				mysql_query("UPDATE `users` SET  `podarokAD`=0 ,`labzay`='0', `lab`=0 , `room`=45, battle=0, `rep`=`rep`+'".$add_rep."', `repmoney` = `repmoney` + '".$add_rep."'  WHERE `id`='".$user[id]."' ; ");


				if ($Tcount==0)
				{
				echo "� ��������� �����!<br>";
				//������ ����� �� �����
				mysql_query("DELETE FROM `labirint_items` where `map`='".$mapid."'; ");

				//������� ���� �����
				unlink('/www/capitalcity.oldbk.com/labmaps/'.$mapid.'.map');

				}
//

			header("Location: startlab.php");
			die("<script>location.href='startlab.php';</script>");
		}
	else
		if (($_GET['exit']))
					{
					$_SESSION['quest']='';
					$_SESSION['questid']='';
				     	unset($_SESSION['time_trap']);//�������
				     	//��������� �� ���?

					/*if (mt_rand(1,2)==2)
					{
					$LAB=2;
					$RUN_FROM_LAB=1;
					include ("make_lbot.php"); // ���������
					}*/

					$msg="�������...� ������ ��� ���������.";
		//�������� � ���
		addch("<img src=i/magic/event_exit_no.gif> {$user[login]} ����� �� ���������...");

		mysql_query("DELETE FROM `labirint_users` WHERE `owner`='".$user[id]."';");
		mysql_query("DELETE FROM `labirint_var` WHERE owner='{$user[id]}' and var='labkillrep'; ");

	     	// ������� ������� ���� ���� �� �����
	     	$i_have_st=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_var` WHERE  var='stat_trap'  and  `owner`='".$user[id]."' ;"));
		if ($i_have_st[owner]==$user[id])
		{
		// ����
		mysql_query("UPDATE users set sila=sila+1, lovk=lovk+1, inta=inta+1  where id='{$user[id]}';");
		}

		mysql_query("DELETE FROM `labirint_var` WHERE  (`var`='stat_trap'  or `var`='timer_trap'  or `var`='poison_trap' or `var`='labcount'  ) and `owner`='".$user[id]."';");

		if ($user['klan']!='radminion')
		{
			mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'labstarttime', '".time()."' ) ON DUPLICATE KEY UPDATE `val` ='".time()."';");
		}

		mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'labexitfalse', '1' ) ON DUPLICATE KEY UPDATE `val` =`val`+1;");

		//���� �������
		undressall($user[id]);

			//�������� �������� 
			$get_all_items=mysql_query("select * from oldbk.`inventory` WHERE  (`labonly`=1 or `labflag`=1) and `owner`='".$user[id]."';");
			while ($rw = mysql_fetch_array($get_all_items))
				{
								//add to new delo
								$rec['owner']=$user['id']; 
								$rec['owner_login']=$user['login'];
								$rec['owner_balans_do']=$user['money'];
								$rec['owner_balans_posle']=$user['money'];					
								$rec['target']=0;
								$rec['target_login']='�������� �����';
								$rec['type']=707;
								$rec['item_id']=get_item_fid($rw);
								$rec['item_name']=$rw['name'];
								$rec['item_count']=1;
								$rec['item_type']=$rw['type'];
								$rec['item_cost']=$rw['cost'];
								$rec['item_ecost']=$rw['ecost'];
								$rec['item_dur']=$rw['duration'];
								$rec['item_maxdur']=$rw['maxdur'];
								$rec['battle']=$user['battle'];
								add_to_new_delo($rec); 				
				}			
			//�������
		mysql_query("DELETE FROM oldbk.`inventory` WHERE  (`labonly`=1 or `labflag`=1) and `owner`='".$user[id]."';");



				mysql_query("UPDATE `users` SET `podarokAD`=0, `labzay`='0', `lab`=0 , `room`=45, battle=0 WHERE `id`='".$user[id]."' ; ");
				//mysql_query("UPDATE `online` SET `room`='45' WHERE `id`='".$user[id]."' ; ");

if ($Tcount==0)
	{
	//// ��� ���� �������� ���������
	//// ���� � ��������� � ��������� �� ���� ����� ��� �����
	/// ����� ��� ����� � ����� �������� ���� �����
	echo "� ��������� �����!<br>";
	//������ ����� �� �����
	mysql_query("DELETE FROM `labirint_items` where `map`='".$mapid."'; ");
	}



			echo "
			<script>
				function cityg(){
					location.href='startlab.php';
				}
				setTimeout('cityg()', 1000);
			</script>
			";

		die("<script>location.href='startlab.php';</script>");
					}
else
if ($_GET[chukaz])
	{
	// ������ �� ����� ���������
	//1. �������� ������ ���������
	 $getukaz=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_items` WHERE  (`owner`=0 OR `owner`='{$user[id]}') and item='9' and x='{$labpoz[x]}' and y='{$labpoz[y]}'  and  `active`=1 and  `map`='".$mapid."'  ;"));
	  if ($getukaz[map]>0)
	    {
	    // ���� ��� ���������
	    $new_ukaz=$getukaz[val]+1;
	    if ($new_ukaz>=5)
	        {
	        $new_ukaz=1;
	        }
	     //��������� � ����
	    mysql_query("UPDATE `labirint_items` SET val='{$new_ukaz}' WHERE  item='9' and x='{$labpoz[x]}' and y='{$labpoz[y]}'  and  `active`=1 and  `map`='".$mapid."'  ;");
	    //��������� � ������
	    $map[$labpoz[x]][$labpoz[y]]=$ukaz[$new_ukaz]; //����������� ������ �����
    	    $msg='<font color=red>���������...</font>';
	    }
	    else
	    {
	    $msg='<font color=red>��� �����...:(</font>';
	    }

	}
else
if ($_GET[getitem])
				{

			           //������� ����
			           //1. ��������������� ������
			           $getitem=mysql_fetch_array(mysql_query("SELECT *,  (select `massa` from oldbk.eshop WHERE id=`labirint_items`.val) as massa  FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `active`=0 and `item`='I' and `count` >=0 and (`owner`=0 OR `owner`='{$user[id]}') and `val`='".(int)($_GET[getitem])."' LIMIT 1;"));

			           if ($getitem[0]>0)
			           {
			           //���� ����� ����
			           		//��������� ������ ����� ���� �����
			           		$my_massa=0;    
						$q = mysql_query("SELECT IFNULL(sum(`massa`),0) as massa , setsale,  dressed  FROM oldbk.inventory WHERE `owner` = '{$user['id']}'   GROUP by setsale,dressed ");
						while ($row = mysql_fetch_array($q)) 
						{
						if (($row['setsale'] ==0 )  AND  ($row['dressed'] ==0 )  )
							{
							$my_massa+=$row['massa'];
							}
						}

		           		if (($getitem['massa']+$my_massa) > (get_meshok())) {	$msg.="<font color=red><b>������������ ����� � �������.</b></font>";}
		           		else
		           		{
		           		//all is good
		           		//del item from map
		           		//��� �������� �� ������
		          ///old 		if (mysql_query("DELETE FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `active`=0 and `item`='I' and `val`='".$getitem[val]."' LIMIT 1;"))
		          			if (mysql_query("UPDATE `labirint_items` SET `active`=1 where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `active`=0 and `item`='I' and `val`='".$getitem[val]."' LIMIT 1;"))
		           		{
		           		//add item to ivent
				         $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` WHERE `id` = '{$getitem[val]}' LIMIT 1;"));

			            if ($dress['id'] > 1010000) {
		 	         			$checkok=get_qitem_check($_SESSION['questdata'],$user,$mapid);
          				                         }else{ $checkok="TRUE"; }

				   if ($checkok=="TRUE")
				    {
       				         $msg='<font color=red>�� ������� "'.$dress[name].'" </font>';
       				         if (   (($dress['id']>3000) and ($dress['id']<3030)) OR // ����
	       				        (($dress['id']>103000) and ($dress['id']<103030)) OR // ���� �������       				         
       				         	(($dress['id']>2966) and ($dress['id']<2975)) OR  // ������ �������
       				         	(($dress['id']>15560) and ($dress['id']<15570))       	 ) // �������
       				         {
       				         $needpres='��������';
       				         }
       				         else

       				         {
       				         $needpres='';
       				         }
       				         //////////
       				         // ������ ��������� ���������
	         		         if ($dress['id'] > 1010000)
        	 		         	{
				         	$needpres='��������';
        	 		         	$soown=$user[id];
        	 		         	get_qitem($_SESSION['questdata'],$user,$mapid) ;

        	 		         	}
        	 		         	else
        	 		         	{
        	 		         	$soown='';
        	 		         	}

       				         ///////fix new 22 12 2010 ������ �� �������
					  if (($dress['id']==105) or ($dress['id']==105101) )
       				          {
       				          $dress['cost']=1;
       				          $needpres='��������';
					 $dress['ekr_flag']=0;
       				          }
       				         //fix ��� �����
       				         $labonly=0;
       				         if ( ($dress['id']>3100)and($dress['id']<3210))
       				         	{
       				         	$labonly=1;
       				         	}
					if ( ($dress['id']>=56661)and($dress['id']<=56663))
       				        {
       				        $needpres='��������';
       	 		         	$soown=$user[id];
       				        }       				         

					$dress['labonly']=$labonly;
					$dress['present']=$needpres;					
					$dress['sowner']=$soown;

					insert_lab_item($dress,$user);
		           		
		           		}
		           		else
		           		   {
		           		    $msg='<font color=red>"'.$checkok.'" </font>';
		           		   }
		           		}


		           		}

			           }
			           else
			           {
				   $msg="��� �� �����, ��� �������...";
			           }



				}
else
//////////
 if ($_GET[useitem])
 	{
 	// �������������
 	//  ���������
	$useitem=(int)$_GET['useitem'];
	//1. �������� ������� �������� 
	$get_use_item=mysql_fetch_array(mysql_query("select * from oldbk.inventory where id='{$useitem}' and owner='{$user[id]}' and setsale=0;"));
	if ($get_use_item['id']>0)
	{
		//������� ����
		//  ���������� ��� ������������
		if (($get_use_item['prototype']==3301)  OR  ($get_use_item['prototype']==3302)  OR  ($get_use_item['prototype']==3303)  OR  ($get_use_item['prototype']==3304) )
			{
			//������������ ������

				$dk=array_search($get_use_item['prototype'], $dkey); //����� 
				$test_door=$doors[$dk];; //����� �����
		 		$DOOR=get_door_xy($test_door);	// ������� ������� ������ ����� ��� ��� ��� ������ ���� + �������
 				//������ �������
 				if ($DOOR)
				{
					if (use_item_update($get_use_item))
						{
						//������������
							mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','{$test_door}','".$DOOR[x]."','".$DOOR[y]."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
							$Aitems[$DOOR[x]][$DOOR[y]]=$test_door;//�������� � ������
						 	$msg="<font color=red>�� ������������ ���� � ������� �����.</font>";
						}
				}
				else
				{
				$msg="<font color=red>�� ��� ������...</font>";
				}
			}
		elseif ($get_use_item['prototype']==3333)
			{
			//������������� ������
				
				//�������� ����� �����?
				if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
				{
								if (use_item_update($get_use_item))
									{
									$Dx=$labpoz['x']+$view3dx[$g][12];
									$Dy=$labpoz['y']+$view3dy[$g][12];
									//������������
										mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','�','".$Dx."','".$Dy."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
										$Aitems[$Dx][$Dy]='�';//�������� � ������
									 	$msg="<font color=red>�� ������������ ������ ���� � ��� ����� ������� �����.</font>";
									}				
				}
				else
				{
				//���� ����� �����
				foreach($doors as $k=>$test_door)
					{
						$DOOR=get_door_xy($test_door);	
						if ($DOOR)
							{	
								if (use_item_update($get_use_item))
									{
									//������������
										mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','{$test_door}','".$DOOR[x]."','".$DOOR[y]."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
										$Aitems[$DOOR[x]][$DOOR[y]]=$test_door;//�������� � ������
									 	$msg="<font color=red>�� ������������ ������ ���� � ��� ����� ������� �����.</font>";
									}
							break;
							}
					}
					reset($doors);
				}
			}
			elseif ($get_use_item['prototype']==4310)
			{
				//������������� �����
				//3. ��� ������� = �����
					if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
					{
								if (use_item_update($get_use_item))
									{
									//������������
									$yamx=$labpoz['x']+$view3dx[$g][12];
									$yamy=$labpoz['y']+$view3dy[$g][12];
										mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','�','".$yamx."','".$yamy."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
										$Aitems[$yamx][$yamy]='�';//�������� � ������
									 	$msg="<font color=red>�� ��������� ����������� ������� ����������� ����� ������ �������. ������ ����� ���� ������.</font>";
									}
					}
				else	
				//4 ��� ��� = �����
					if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
					{

								if (use_item_update($get_use_item))
									{
									//������������
										$yamx=$labpoz['x']+$view3dx[$g][12];
										$yamy=$labpoz['y']+$view3dy[$g][12];
											  
										mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','�','".$yamx."','".$yamy."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
										$Aitems[$yamx][$yamy]='�';//�������� � ������
									 	$msg="<font color=red>�� ��������� ����������� ������� ����������� ����� ������ �������. ������ ����� ���� ������.</font>";
									}
					
					}
					else
					{
					 $msg="��� ��� �� �������... :(";			
					}
			
			}
		elseif ($get_use_item['prototype']==4307)
			{
				//������������� ����� � �����
				//3. ��� �����
					if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
					{
								if (use_item_update($get_use_item))
									{
									//������������
									$yamx=$labpoz['x']+$view3dx[$g][12];
									$yamy=$labpoz['y']+$view3dy[$g][12];
										mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','�','".$yamx."','".$yamy."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
										$Aitems[$yamx][$yamy]='�';//�������� � ������
									 	$msg="<font color=red>����� ������� �� ������������� ����� ���� � �������� �������. ����� ����� � ������ ����� ���� ������.</font>";
									}
					}
				/*else	
				//4 ��� ��� = �����
					if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
					{

								if (use_item_update($get_use_item))
									{
									//������������
										$yamx=$labpoz['x']+$view3dx[$g][12];
										$yamy=$labpoz['y']+$view3dy[$g][12];
											  
										mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','�','".$yamx."','".$yamy."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
										$Aitems[$yamx][$yamy]='�';//�������� � ������
									 	$msg="<font color=red>������ ����� ������...</font>";
									}
					
					} */
					else
					{
					 $msg="��� ��� �� �������... :(";			
					}
			
			}			
			elseif (($get_use_item['prototype']==4304) or ($get_use_item['prototype']==4305) )
			{
				if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='G') )
					
						{
						$greenx=$labpoz['x']+$view3dx[$g][12];
						$greeny=$labpoz['y']+$view3dy[$g][12];
						
							if (use_item_update($get_use_item))
									{
									//��������� � ����� ��������� 
									mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','G','".$greenx."','".$greeny."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
									$Aitems[$greenx][$greeny]='G';//�������� � ������
									//$map[$greenx][$greeny]='O';
									$msg= "<font color=red><b>�� ���������� ������� ����� ������� ���������, ���������� ������. ����� ���������� �����.</b></font>";
									}
						}
						else
						{
					       $msg="��� ��� �� �������... :(";			
						}
			}
			elseif (($get_use_item['prototype']==4308) )
			{
				if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
					
						{
						$greenx=$labpoz['x']+$view3dx[$g][12];
						$greeny=$labpoz['y']+$view3dy[$g][12];
						
							if (use_item_update($get_use_item))
									{
									//��������� � ����� ��������� 
									mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','�','".$greenx."','".$greeny."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
									$Aitems[$greenx][$greeny]='�';//�������� � ������
									$map[$greenx][$greeny]='O';									
									$msg= "<font color=red><b>����� ������ �����������, �������� �������. ������ ����� ���� ������.</b></font>";
									}
						}
						else
						{
					       $msg="��� ��� �� �������... :(";			
						}
			}			
			elseif ( ($get_use_item['prototype']==4303) ) //($get_use_item['prototype']==4300) or ($get_use_item['prototype']==4301) or ($get_use_item['prototype']==4302) or
			{
				if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
					
						{
						$greenx=$labpoz['x']+$view3dx[$g][12];
						$greeny=$labpoz['y']+$view3dy[$g][12];
						
							if (use_item_update($get_use_item))
									{
									//��������� � ����� ��������� ������� ������
									mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','�','".$greenx."','".$greeny."','1','1' ) ON DUPLICATE KEY UPDATE `active` =1, `count`=`count`+1;");
									$Aitems[$greenx][$greeny]='�';//�������� � ������
									//$map[$greenx][$greeny]='O';
									$msg= "<font color=red><b>��������� ������ ������ � ������� ����� ��������� ������� �������� ��������� ��� ��� ����. ������ ����� ������.</b></font>";
									}
						}
						else
						{
					       $msg="��� ��� �� �������... :(";			
						}
			}	
			elseif (($get_use_item['prototype']==4306))
			{
				if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='E') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='E') and ($labpoz['x']+$view3dx[$g][12]>$labpoz['x'])  )
						{
							if (use_item_update($get_use_item))
									{
									$dress=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`shop` WHERE `id` = '4307' LIMIT 1;"));
									if ($dress['id']>0)
										{
										if (insert_lab_item($dress,$user))
											{
											$msg= "<font color=red><b>�������! ������ � ��� ���� ����� � ����� � �������� ������� ������ ��� ��� �� ��������! ����� ����� ���������� �����.</b></font>";
											}
										}
									}
						}
						else
						{
					       $msg="��� ��� �� �������... :(";			
						}
			}
			elseif (($get_use_item['prototype']==4313))
			{
				if ( (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') ) OR  // �������� ���
				   (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='A') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='A') and ($labpoz['x']+$view3dx[$g][12]<$labpoz['x']) )  ) // �������� �����
						{
							if (use_item_update($get_use_item))
									{
									$dress=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`shop` WHERE `id` = '4308' LIMIT 1;"));
									if ($dress['id']>0)
										{
										if (insert_lab_item($dress,$user))
											{
											$msg= "<font color=red><b>�������, ������ � ��� ���� ������� �����! ����������� ���� ������ �� ������ ��� ����������.</b></font>";
											}
										}
									}
						}
						else
						{
					       $msg="��� ��� �� �������... :(";			
						}
			}			
			elseif (($get_use_item['prototype']>=2170) and ($get_use_item['prototype']<=2173) )
			{
			//��  ������� �������
					$_GET['use']=$get_use_item['id'];
					ob_start();
					
					if (usemagic($get_use_item['id'],'')==1)
						{
						$ueff=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '".$user['id']."' AND (`type`=75) "));
						if ($ueff['id']>0)
							{
							$addinf=explode("::",$ueff['add_info']);
							$SUMRAK=$addinf[1];
							$SUMRAK_info=$ueff;
							$SUMRAK_info['img']=$addinf[0];
							$SUMRAK_info['add_info']=$addinf[1];				
							}
						}
						else
						{
						//echo "D1";
						}
					$cont = ob_get_contents();
					ob_clean ();
					ob_end_clean();
			}
			elseif (($get_use_item['prototype']==4311))
			{
			//�� ����
					$_GET['use']=$get_use_item['id'];
					ob_start();
					usemagic($get_use_item['id'],'');
					$cont = ob_get_contents();
					ob_clean ();
					ob_end_clean();
					$msg=$cont;
					$user['hp']+=500;
					if ($user['hp']>$user['maxhp']) $user['hp']=$user['maxhp'];
			}			
			elseif (($get_use_item['prototype']==4312))
			{
			//�� ��������
					$_GET['use']=$get_use_item['id'];
					ob_start();
					usemagic($get_use_item['id'],'');
					$cont = ob_get_contents();
					ob_clean ();
					ob_end_clean();
					$msg=$cont;
			}
			elseif (($get_use_item['prototype']==4300) or ($get_use_item['prototype']==4301) or ($get_use_item['prototype']==4302) )
			{
			//�� �������� 
				if (($map[$labpoz['x']][$labpoz['y']]=='P') and ($Aitems[$labpoz['x']][$labpoz['y']]=='P') )				
					{
					if (use_item_update($get_use_item))
									{
									mysql_query("UPDATE `oldbk`.`labirint_items` SET `item`='�' WHERE `map`=".$mapid." AND `item`='P' AND `x`=".$labpoz[x]." AND `y`=".$labpoz[y]." AND `active`=1;"); //������� ��� ������ ����
									if (mysql_affected_rows()>0) 
										{
										$Aitems[$labpoz['x']][$labpoz['y']]="�"; //������� ��� ������ ����
										mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','0','4310' ) ON DUPLICATE KEY UPDATE `active` =0, `val`='4310' ;"); // ���� �����
											{
											$msg= "<font color=red><b>�������, ������ ��� ������� �����.</b></font>";
											}
										}
									}
					}
			
			
			}
			else
			{
		        $msg="��� ��� �� �������... :(";			
			}
	
	}
 	else
 	{
	       $msg="� ��� ��� ������ ��������... :(";
 	}


 	}
 else
//////////
if ($_GET[keybox]) {

 			if (($map[$labpoz[x]][$labpoz[y]]==$Aitems[$labpoz[x]][$labpoz[y]]) and
 			    (
	       			($map[$labpoz[x]][$labpoz[y]]=='L') OR
	       			($map[$labpoz[x]][$labpoz[y]]=='W') OR
	       			($map[$labpoz[x]][$labpoz[y]]=='Y') OR
	       			($map[$labpoz[x]][$labpoz[y]]=='K')
 			    )   )
			{
			$msg="��� ���-�� ������...";
			}
			else
				if ($map[$labpoz[x]][$labpoz[y]]=='L')
				{
				
			mysql_query("INSERT IGNORE `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','L','".$labpoz[x]."','".$labpoz[y]."','1','1' ) ;");
			if(mysql_affected_rows()>0)
					{
				$Aitems[$labpoz[x]][$labpoz[y]]='L';
				$Aitems_count[$labpoz[x]][$labpoz[y]]++;
				//������ �����
				mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','0','3301' ) ON DUPLICATE KEY UPDATE `active` =0, `val`='3301' ;");
				//�������� � ���
				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
				addch("<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box);
				$msg.= "<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box."<br>";
					}
				}
			else
			if ($map[$labpoz[x]][$labpoz[y]]=='W')
				{
			mysql_query("INSERT IGNORE `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','W','".$labpoz[x]."','".$labpoz[y]."','1','1' )");	
			if(mysql_affected_rows()>0)
					{
				$Aitems[$labpoz[x]][$labpoz[y]]='W';
				$Aitems_count[$labpoz[x]][$labpoz[y]]++;
				//������ �����
				mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','0','3302' ) ON DUPLICATE KEY UPDATE `active` =0, `val`='3302' ;");
				//�������� � ���
				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
				addch("<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box);
				$msg.= "<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box."<br>";
					}
				}
			else
			if ($map[$labpoz[x]][$labpoz[y]]=='Y')
				{

		mysql_query("INSERT IGNORE `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','Y','".$labpoz[x]."','".$labpoz[y]."','1','1' ) ");
		if(mysql_affected_rows()>0)		
					{
				$Aitems[$labpoz[x]][$labpoz[y]]='Y';
				$Aitems_count[$labpoz[x]][$labpoz[y]]++;
				//������ �����
				mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','0','3303' ) ON DUPLICATE KEY UPDATE `active` =0, `val`='3303' ;");
				//�������� � ���
				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
				addch("<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box);
				$msg.= "<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box."<br>";
					}
				}
			else
			if ($map[$labpoz[x]][$labpoz[y]]=='K')
				{
		mysql_query("INSERT IGNORE `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','K','".$labpoz[x]."','".$labpoz[y]."','1','1' ) ;");			
		if(mysql_affected_rows()>0)	
					{		
				$Aitems[$labpoz[x]][$labpoz[y]]='K';
				$Aitems_count[$labpoz[x]][$labpoz[y]]++;
				//������ �����
				mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','0','3304' ) ON DUPLICATE KEY UPDATE `active` =0, `val`='3304' ;");
				//�������� � ���
				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
				addch("<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box);
				$msg.= "<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." �����...".$kom_box."<br>";
					}
				}

			else
			{
			$msg='�� ���� ����� ���� ������ �����...';
			}

 }
/////////
else
 if ($_GET[openbox]) {

 			if (($map[$labpoz[x]][$labpoz[y]]==$Aitems[$labpoz[x]][$labpoz[y]]) and ($map[$labpoz[x]][$labpoz[y]]=='P')  )
			{
			$msg="��� ���-�� ������...";
			}
			else
			if ( ($map[$labpoz[x]][$labpoz[y]]=='P') and ($Aitems[$labpoz[x]][$labpoz[y]]!='�' ) ) // �� "�" - �� �������� ��� ����
			{
			$Aitems[$labpoz[x]][$labpoz[y]]='P';



			$dpbox=count($pbox); // ������ �������
			$dpbox=round(($labpoz[y]*$dpbox/(strlen($map[1])))); // �������� ������� ��������� ������������ �� ��������� ����� � ������.
				$rs=$dpbox-2;
				if ($rs < 0) {  $rs=0; }
				$rmt=rand($rs,$dpbox);

					if ($rmt>=13)
					{
					//���� ������ �������� ����� ��������� �����
					$get_ivent=mysql_fetch_array(mysql_query("select * from oldbk.ivents where id=1"));
					if ($get_ivent['stat']==1)
							{
							//����� ��������
							$get_day_key_drop=mysql_fetch_array(mysql_query("select * from `variables` where var='lab_key_count_d' "));
							if ($get_h_key_drop['value']<=480)	//� ����
							  {
								$get_h_key_drop=mysql_fetch_array(mysql_query("select * from `variables` where var='lab_key_count_h' "));
								if ($get_h_key_drop['value']<20) //� ���
								{
								//��������� ���.��������
								$get_kycount=mysql_fetch_array(mysql_query("select * from labirint_var where owner='{$user['id']}' and var='keylab'"));
								$tk=(int)($get_kycount['val']);
								if ($tk==0)
									{
									//������� �����
									$pbox[$rmt] = array("labkey" => 4001);
									mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user['id']."','keylab','1') ON DUPLICATE KEY UPDATE `val`=`val`+1;");
									mysql_query("UPDATE `variables` SET `value`=`value`+1 WHERE `var`='lab_key_count_h' or `var`='lab_key_count_d'");
									}
								}
							  }
							}
					}

				foreach ($pbox[$rmt] as $item_name=>$v)
					{

					if (($item_name!='poison_trap') and ($item_name!='timer_trap'))
					{
					//������ �����
				mysql_query("INSERT IGNORE `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`) values('".$mapid."','P','".$labpoz[x]."','".$labpoz[y]."','1','1' ) ;");
				if(mysql_affected_rows()>0)	
						{		
					$Aitems_count[$labpoz[x]][$labpoz[y]]++; // ������� ������ �����
					mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','0','".$v."' ) ON DUPLICATE KEY UPDATE `active` =0, `val`='".$v."' ;");
						}
					}
					else
					{
					//������ ������� ��������� ��
				//var global B count
				$trap_name=$item_name;
				mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', '".$trap_name."', '".(time()+($v*60))."' ) ON DUPLICATE KEY UPDATE `val` =`val`+".($v*60).";");


				//�������� � ���
				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
				if ($trap_name=='timer_trap') { $_SESSION['time_trap']=1; $kom_trap='<i>����� �������� +6 ������� (������������:+'.$v.'���.)</i> '; }
				else if ($trap_name=='poison_trap') {
									// add poison flag
									mysql_query("UPDATE users set `podarokAD`=1 where id='{$user[id]}';");
									$kom_trap='<i>������� ����� -20HP � ������ (������������:+'.$v.'���.)</i>';
									}
				else {$kom_trap='';}

				addch("<img src=i/magic/event_".$trap_name.".gif> {$user[login]} ".$sexi." � �������...".$kom_trap);
				$msg.="<img src=i/magic/event_".$trap_name.".gif> {$user[login]} ".$sexi." � �������...".$kom_trap."<br>";

					}
//var global B count
//				mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', '".$trap_name."', '".(time()+($v*60))."' ) ON DUPLICATE KEY UPDATE `val` =`val`+".($v*60).";");
					} //���� ��������� �����
					if ($Aitems_count[$labpoz[x]][$labpoz[y]]==0)
					{
					$kom_box='<i>� ��� ������ ���.</i>';
					mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active` ) values('".$mapid."','P','".$labpoz[x]."','".$labpoz[y]."','1' ) ON DUPLICATE KEY UPDATE `active` =1 ;");
					}

//�������� � ���

				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }

				addch("<img src=i/magic/event_pandbox.gif> {$user[login]} ".$sexi." ���� �������...".$kom_box);
				$msg.= "<img src=i/magic/event_pandbox.gif> {$user[login]} ".$sexi." ���� �������...".$kom_box."<br>";


			}
else
			{
			$msg='�� ���� ����� ���� ������ �����...';
			}

 }
 else
 if ($_GET[hill])
		{

// ��������� ������� ��  ��� ���.
/// �����
/// ��������� � ������ ����� ��������� � ����������
			if (($map[$labpoz[x]][$labpoz[y]]==$Aitems[$labpoz[x]][$labpoz[y]]) and ($map[$labpoz[x]][$labpoz[y]]=='H'))
			{
			$msg="��� ���-�� �����...";
			}
			else
			if ($map[$labpoz[x]][$labpoz[y]]=='H')
			{

				$dhils=count($hils); // ������ �������
				$dhils=round(($labpoz[y]*$dhils/(strlen($map[1])))); // �������� ������� ��������� ������������ �� ��������� ����� � ������.
				$rs=$dhils-2;
				if ($rs < 0) {  $rs=0; }
				$rmt=rand($rs,$dhils);
				foreach ($hils[$rmt] as $H=>$v)
				{
		if ($H=='H')
			{

				        $hilka=mysql_query_cache("SELECT * FROM oldbk.`shop` WHERE `id` = '4311' LIMIT 1;",false,24*3600);
					$hilka = $hilka[0];	
					$hilka['labonly']=1;
		
					if (insert_lab_item($hilka,$user))
						{
						 $msg='<font color=red>�� ������� "'.$hilka[name].'" </font>';
						mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`) values('".$mapid."','H','".$labpoz[x]."','".$labpoz[y]."','1' ) ON DUPLICATE KEY UPDATE `active` =1;");
						$Aitems[$labpoz[x]][$labpoz[y]]="H";
						mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'hcount', '1' ) ON DUPLICATE KEY UPDATE `val` =`val`+1;");
						}
						else
						{
						//echo "Error";
						}

			}

				}

			//
			}
			else
			{
			$msg='�� ���� ����� ���� ������ �����...';
			}
		 }
		else
if ($_GET[antidot])
		{
// ��������� ������� ��  ��� ���.
/// ��������� � ������ ����� ��������� � ����������
			if (($map[$labpoz[x]][$labpoz[y]]==$Aitems[$labpoz[x]][$labpoz[y]]) and ($map[$labpoz[x]][$labpoz[y]]=='�'))
			{
			$msg="��� ���-�� �����...";
			}
			else
			if ($map[$labpoz[x]][$labpoz[y]]=='�')
			{
				        $hilka=mysql_query_cache("SELECT * FROM oldbk.`shop` WHERE `id` = '4312' LIMIT 1;",false,24*3600);
					$hilka = $hilka[0];	
					$hilka['labonly']=1;
		
					if (insert_lab_item($hilka,$user))
						{
						 $msg='<font color=red>�� ������� "'.$hilka[name].'" </font>';
						mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`) values('".$mapid."','�','".$labpoz[x]."','".$labpoz[y]."','1' ) ON DUPLICATE KEY UPDATE `active` =1;");
						$Aitems[$labpoz[x]][$labpoz[y]]="�";
						mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'hcount', '1' ) ON DUPLICATE KEY UPDATE `val` =`val`+1;");
						}
						else
						{
						//echo "Error";
						}
			}
			else
			{
			$msg='�� ���� ����� ���� ������ �����...';
			}
		 }
else		
if ($_GET[attak])
			{

			$msg='����������...';

			}
	else
if ($_GET[sunduk])
			{
			if (($map[$labpoz[x]][$labpoz[y]]==$Aitems[$labpoz[x]][$labpoz[y]]) and ($map[$labpoz[x]][$labpoz[y]]=='S'))
			{
			$msg="������ ����...��� ���-�� ������..";
			}
			else if ($map[$labpoz[x]][$labpoz[y]]=='S')
			{

			//������ ������
			// drop item from sundul ^)
				$dsund=count($sund); // ������ �������
				$dsund=round(($labpoz[y]*$dsund/(strlen($map[1])))); // �������� ������� ��������� ������������ �� ��������� ����� � ������.
				$delta=round(($labpoz[y]*10/(strlen($map[1])))); //5%
				$rs=$dsund-$delta; //-5%
				$rf=$dsund+$delta; //+5%

				if ($rs < 0) {  $rs=0; }
				if ($rf > (strlen($map[1]))) {  $rf=(strlen($map[1])); }
				/// ��� ��������� ������� ������
				$kkk=0;
				//echo "$rs - $rf <br>";
				do
				{
				//echo "$kkk <br>";
				 	$rmt=rand($rs,$rf);
					$param=$sund[$rmt];
					$povtorov=$reitem[$param[id]]; // �������� �������� ������� �� �������
				//echo "$param[id] <br>";
				 if ($povtorov >0 ) // ���� ���� ��������� ������� �� ��������
				  {
					$history=mysql_fetch_array(mysql_query("select count(*) FROM `labirint_items` where `item`='I' and `map`='{$mapid}' and `active`=1 and `val`='{$param[id]}' ;"));
					if ( ($history[0]<$povtorov) )
					  {
					  $kkk=10;
						  }
				  }
				  else
				  {
				  $kkk=10;
				  }
				}
				while ($kkk++<5) ;
			// ���� �� � �������� �� ����� ������� ������ �������� �������� �� ������� ��� ���� ����
			// �� ���� � ���� ������
			if (( ($history[0]>$povtorov) and ($povtorov > 0)) or ($param[id]==0))
			{
			 if (CITY_ID==1)
			    {
			    $param[id]=103001;
			    }
			    else
			    {
			    $param[id]=3001;
			    }
			$param[shop]="eshop";
			$param[labonly]=0;
			$param[maxdur]=1;
			$param[present]="��������";
			}



			if ($param[id] > 0)
			{
			mysql_query("INSERT IGNORE  `labirint_items` (`map`,`item`,`x`,`y`,`active`) values('".$mapid."','S','".$labpoz[x]."','".$labpoz[y]."','1' ) ;");
			if(mysql_affected_rows()>0)			
					{			
			      $dress = mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`{$param[shop]}` WHERE `id` = '{$param[id]}' LIMIT 1;"));
			      
			if ($param[labonly]>0)
       				         {
					 $dress['nclass']=4;
					 }			      
			      
				// � ������� ������ �������� ���� �� � ����� =1 ����� ��� ����������� ����������
				mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','1','".$dress['id']."' ) ON DUPLICATE KEY UPDATE `active` =1, `val`='".$dress['id']."' ;");
				mysql_query("INSERT INTO oldbk.`inventory`
				(`prototype`,`owner`,`name`,`type`,`massa`,`cost`,`img`, `img_big`,`getfrom`,`rareitem`,`ekr_flag` ,`duration`,`maxdur`,`isrep`,`nclass`,
					`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`needident`,`nsila`,`nlovk`,`ninta`,`nintel`,`nmudra`,`nvinos`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,
					`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`bron1`,`bron2`,`bron3`,`bron4`,`maxu`,`minu`,`magic`,`nlevel`,`nalign`,`dategoden`,`goden`,`nsex`,`otdel`,`present`,`labonly`,`labflag`,`group`,`idcity`
				)
				VALUES
				('{$dress['id']}','{$user['id']}','{$dress['name']}','{$dress['type']}',{$dress['massa']},{$dress['cost']},'{$dress['img']}' ,  '{$dress['img_big']}' , '14','{$dress['rareitem']}','{$dress['ekr_flag']}' ,{$dress['duration']},{$param['maxdur']},{$dress['isrep']},'{$dress['nclass']}','{$dress['gsila']}','{$dress['glovk']}','{$dress['ginta']}','{$dress['gintel']}','{$dress['ghp']}','{$dress['gnoj']}','{$dress['gtopor']}','{$dress['gdubina']}','{$dress['gmech']}','{$dress['gfire']}','{$dress['gwater']}','{$dress['gair']}','{$dress['gearth']}','{$dress['glight']}','{$dress['ggray']}','{$dress['gdark']}','{$dress['needident']}','{$dress['nsila']}','{$dress['nlovk']}','{$dress['ninta']}','{$dress['nintel']}','{$dress['nmudra']}','{$dress['nvinos']}','{$dress['nnoj']}','{$dress['ntopor']}','{$dress['ndubina']}','{$dress['nmech']}','{$dress['nfire']}','{$dress['nwater']}','{$dress['nair']}','{$dress['nearth']}','{$dress['nlight']}','{$dress['ngray']}','{$dress['ndark']}',
				'{$dress['mfkrit']}','{$dress['mfakrit']}','{$dress['mfuvorot']}','{$dress['mfauvorot']}','{$dress['bron1']}','{$dress['bron2']}','{$dress['bron3']}','{$dress['bron4']}','{$dress['maxu']}','{$dress['minu']}','{$dress['magic']}','{$dress['nlevel']}','{$dress['nalign']}','".(($dress['goden'])?($dress['goden']*24*60*60+time()):"")."','{$dress['goden']}','{$dress['nsex']}','{$dress['razdel']}','{$param['present']}','{$param['labonly']}','1','{$dress['group']}','{$user[id_city]}'
				) ;");
				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
				$msund='<i>� '.$sexi.' "'.$dress[name].'" </i>';
				
						if ((mysql_affected_rows()>0) and ($dress['labonly']==0) )
							{
						     		//add to new delo
								$rec['owner']=$user['id']; 
								$rec['owner_login']=$user['login'];
								$rec['owner_balans_do']=$user['money'];
								$rec['owner_balans_posle']=$user['money'];					
								$rec['target']=0;
								$rec['target_login']='�������� �����';
								$rec['type']=701;
								$rec['item_id']="cap".mysql_insert_id();
								$rec['item_name']=$dress['name'];
								$rec['item_count']=1;
								$rec['item_type']=$dress['type'];
								$rec['item_cost']=$dress['cost'];
								$rec['item_ecost']=$dress['ecost'];
								$rec['item_dur']=$dress['duration'];
								$rec['item_maxdur']=$dress['maxdur'];
								$rec['battle']=$telo['battle'];
								add_to_new_delo($rec); 
							}
				
					}
					else
					{
					$msund='<i>� �� ����.</i>';
					}
			
			}
			else
			{
			$msund='<i>� �� ����.</i>';
			}
///

			if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
			$msg="<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." ������...".$msund;
			addch("<img src=i/magic/event_sunduk.gif> {$user[login]} ".$sexi." ������...".$msund);



			//setup count user lab var
			mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'scount', '1' ) ON DUPLICATE KEY UPDATE `val` =`val`+1;");
			//
			$Aitems[$labpoz[x]][$labpoz[y]]="S";
			}
			else
			{
			$msg='���������� ��� ��� ������...';
			}
		 }
	else
		if($_GET[go])
		{
		$msg="<font color=red>��� ?</font>";
		//telepost('Bred','<font color=red>��������! laba-BOT </font> ��������:'.$user[login]);
		}
		if ($_GET['goto']) {



		if ($_SESSION['time_trap']==1) {$time_go=6;} else {$time_go=1;}


			if($_SESSION['time'] >= time()) //>=
			{
				$msg="<font color=red>�� ��� ������</font>";
			}
			else
			switch($_GET['goto']) {

				case "p1":
					//$msg="P1<br>";
				if (($map[$labpoz[x]-1][$labpoz[y]]=="A")   and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ������ ������ � ������ �������...</b></font>";
					//��������� � ����� ��������� ������� ������
					}
				else
				if (($map[$labpoz[x]-1][$labpoz[y]]=="G") and ($Aitems[$labpoz[x]-1][$labpoz[y]]!="G")  and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ����������...</b></font>";
					}
				else
				if (($map[$labpoz[x]-1][$labpoz[y]]=="�") and ($Aitems[$labpoz[x]-1][$labpoz[y]]!="�")  and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� �����...</b></font>";
					}					
				else
				if (($map[$labpoz[x]-1][$labpoz[y]]=="�") and ($Aitems[$labpoz[x]-1][$labpoz[y]]!="�")   and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>�����... ����� ����������...</b></font>";
					}					
				else
				if (
					(($map[$labpoz[x]-1][$labpoz[y]]=="D") OR
					($map[$labpoz[x]-1][$labpoz[y]]=="Z") OR
					($map[$labpoz[x]-1][$labpoz[y]]=="X") OR
					($map[$labpoz[x]-1][$labpoz[y]]=="C") OR ($map[$labpoz[x]-1][$labpoz[y]]=="�") )
					and ($Aitems[$labpoz[x]-1][$labpoz[y]]=='')
					)
					{
					if ($SUMRAK==0 )
						{
						$msg= "�����...�������!";
						}
						else
						{
						$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
						}
					}
				else
				if ((($map[$labpoz[x]-1][$labpoz[y]]=="N") OR ($map[$labpoz[x]-1][$labpoz[y]]=="M") OR ($map[$labpoz[x]-1][$labpoz[y]]==" ")) and ($SUMRAK==0 ))
					{
					$msg= "�����..";
					}
					else
					{
					if (($SUMRAK>0) and ( ($map[$labpoz[x]-1][$labpoz[y]]=="N")   OR ($labpoz[x]==2) OR ($labpoz[y]==1) OR ($labpoz[y]==strlen($map[1])-2) ))
					  {
	 				$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
					  }
					  else
					  {
					  	
					  
					  	if (sumrak_count_test($labpoz[x]-1,$labpoz[y]))
					  		{
							  if ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
							 }
					  
					  mysql_query("UPDATE `labirint_users` SET  `x`=`x`-1 WHERE `owner`='".$user[id]."' LIMIT 1;");
					  $labpoz[x]=$labpoz[x]-1;
					  if ($_SESSION[lab_bg]==0) {$_SESSION[lab_bg]=1;} else {$_SESSION[lab_bg]=0;}		
					  move_remember($STRAHOVKA,$labpoz);			  
					  }
					}
					$_SESSION['time'] = time()+$time_go;

				break;
				case "p2":
					//$msg="P2<br>";
				if (($map[$labpoz[x]][$labpoz[y]+1]=="1")   and ($SUMRAK==0))
					{
					//$msg= "<font color=red><b>�������...</b></font><script>location.href='kuznya.php';</script>";
					//$OPEN_FROM_LAB=TRUE;
					//include('kuznya.php');
					die();
					}
				else
				if (($map[$labpoz[x]][$labpoz[y]+1]=="E")   and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ������ ������ � ������ �������...</b></font>";
					}
				else
					if (($map[$labpoz[x]][$labpoz[y]+1]=="G")  and ($Aitems[$labpoz[x]][$labpoz[y]+1]!="G")  and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ����������...</b></font>";
					}
				else
					if (($map[$labpoz[x]][$labpoz[y]+1]=="�")  and ($Aitems[$labpoz[x]][$labpoz[y]+1]!="�")  and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>�����... ����� �����...</b></font>";
					}					
				else
					if (($map[$labpoz[x]][$labpoz[y]+1]=="�")  and ($Aitems[$labpoz[x]][$labpoz[y]+1]!="�")  and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ����������...</b></font>";
					//��������� � ����� ��������� ������� ������
					}					
					else
					if ((($map[$labpoz[x]][$labpoz[y]+1]=="D") OR
					($map[$labpoz[x]][$labpoz[y]+1]=="Z") OR
					($map[$labpoz[x]][$labpoz[y]+1]=="X") OR
					($map[$labpoz[x]][$labpoz[y]+1]=="C") )
					and ($Aitems[$labpoz[x]][$labpoz[y]+1]==''))
					{
					if ($SUMRAK==0 )
						{
						$msg= "�����...�������!";
						}
						else
						{
						$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
						}
					}
				else
				if (ord($map[$labpoz[x]][$labpoz[y]+1])==10)
				{
					$msg= "�����������! �� ����� �����...!";
				}
				else
				if (( ($map[$labpoz[x]][$labpoz[y]+1]=="N")  OR ($map[$labpoz[x]][$labpoz[y]+1]=="M") OR ($map[$labpoz[x]][$labpoz[y]+1]==" ") ) and ($SUMRAK==0 ))
					{
					$msg= "<font color=red><b>�����...</b></font>";
					}
					else
					{
					if (($SUMRAK>0) and ( ($map[$labpoz[x]][$labpoz[y]+1]=="N")  OR  ($labpoz[y]==(strlen($map[1])-3)) ) )
					  {
	 				$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
					  }
					  else
					  {
							if (sumrak_count_test($labpoz[x],$labpoz[y]+1))					  		
					  		{
							  if ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
							  }
					//���
					  mysql_query("UPDATE `labirint_users` SET  `y`=`y`+1 WHERE `owner`='".$user[id]."' LIMIT 1;");
					  $labpoz[y]=$labpoz[y]+1;
					  if ($_SESSION[lab_bg]==0) {$_SESSION[lab_bg]=1;} else {$_SESSION[lab_bg]=0;}		
					  move_remember($STRAHOVKA,$labpoz);			  
					  }
					}
					$_SESSION['time'] = time()+$time_go;

				break;
				case "p3":
					//$msg="P3<br>";
					if (($map[$labpoz[x]+1][$labpoz[y]]=="E")   and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ������ ������ � ������ �������...</b></font>";
					//��������� � ����� ��������� ������� ������
					}
				else
					if (($map[$labpoz[x]+1][$labpoz[y]]=="G") and ($Aitems[$labpoz[x]+1][$labpoz[y]]!="G")   and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ����������...</b></font>";
					}
				else
					if (($map[$labpoz[x]+1][$labpoz[y]]=="�") and ($Aitems[$labpoz[x]+1][$labpoz[y]]!="�")   and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>�����... ����� �����...</b></font>";
					}					
				else
					if (($map[$labpoz[x]+1][$labpoz[y]]=="�") and ($Aitems[$labpoz[x]+1][$labpoz[y]]!="�")    and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ����������...</b></font>";
					}					
				else
					if ((($map[$labpoz[x]+1][$labpoz[y]]=="D") OR
					($map[$labpoz[x]+1][$labpoz[y]]=="Z") OR
					($map[$labpoz[x]+1][$labpoz[y]]=="X") OR
					($map[$labpoz[x]+1][$labpoz[y]]=="C") )
					and ($Aitems[$labpoz[x]+1][$labpoz[y]]==''))
					{
					if ($SUMRAK==0 )
						{
						$msg= "�����...�������!";
						}
						else
						{
						$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
						}
					}
				else
				if (( ($map[$labpoz[x]+1][$labpoz[y]]=="N")  OR  ($map[$labpoz[x]+1][$labpoz[y]]=="M") OR ($map[$labpoz[x]+1][$labpoz[y]]==" ") ) and ($SUMRAK==0 ))
					{
					$msg= "<font color=red><b>�����...</b></font>";
					}
					else
					{
					if (($SUMRAK>0) and ( ($map[$labpoz[x]+1][$labpoz[y]]=="N")  OR  ($labpoz[x]==(count($map)-2)) OR ($labpoz[y]==1) OR ($labpoz[y]==strlen($map[1])-2) ) )
					  {
	 				$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
					  }
					  else
					  {
					  	
						if (sumrak_count_test($labpoz[x]+1,$labpoz[y]))					  	
					  		{
							  if ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
							  }
					  mysql_query("UPDATE `labirint_users` SET  `x`=`x`+1 WHERE `owner`='".$user[id]."' LIMIT 1;");
					  $labpoz[x]=$labpoz[x]+1;
					   if ($_SESSION[lab_bg]==0) {$_SESSION[lab_bg]=1;} else {$_SESSION[lab_bg]=0;}					  
					   move_remember($STRAHOVKA,$labpoz);
					  }
					}
					$_SESSION['time'] = time()+$time_go;

				break;
				case "p4":
					//$msg="P4<br>";
				if (($map[$labpoz[x]][$labpoz[y]-1]=="A")   and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ������ ������ � ������ �������...</b></font>";
					}
				else
					if ((($map[$labpoz[x]][$labpoz[y]-1]=="D") OR
					($map[$labpoz[x]][$labpoz[y]-1]=="Z") OR
					($map[$labpoz[x]][$labpoz[y]-1]=="X") OR
					($map[$labpoz[x]][$labpoz[y]-1]=="C") )
					and ($Aitems[$labpoz[x]][$labpoz[y]-1]==''))
					{
					if ($SUMRAK==0 )
						{
						$msg= "�����...�������!";
						}
						else
						{
						$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
						}
					}
				else
				if (($map[$labpoz[x]][$labpoz[y]-1]=="G") and ($Aitems[$labpoz[x]][$labpoz[y]-1]!="G")    and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ����������...</b></font>";
					}
				else
				if (($map[$labpoz[x]][$labpoz[y]-1]=="�") and ($Aitems[$labpoz[x]][$labpoz[y]-1]!="�")    and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>�����...����� �����...</b></font>";
					}
				else				
				if (($map[$labpoz[x]][$labpoz[y]-1]=="�") and ($Aitems[$labpoz[x]][$labpoz[y]-1]!="�")  and ($SUMRAK==0))
					{
					$msg= "<font color=red><b>����� ����������...</b></font>";
					}					
				else
				if (ord($map[$labpoz[x]][$labpoz[y]-1])==32)
				{
				 $msg= "<font color=red><b>���� ����� ���!</b></font>";
				}
				else
				if (( ($map[$labpoz[x]][$labpoz[y]-1]=="N")  OR  ($map[$labpoz[x]][$labpoz[y]-1]=="M") OR ($map[$labpoz[x]][$labpoz[y]-1]==" ")) and ($SUMRAK==0 ))
					{
					$msg= "<font color=red><b>�����...</b></font>";
					}
					else
					{
					if (($SUMRAK>0) and ( ($map[$labpoz[x]][$labpoz[y]-1]=="N")  OR ($labpoz[y]==2) ))
					  {
	 				$msg= "<font color=red><b>����� ����� �� �������..</b></font>";
					  }
					  else
					  {
					  	
						if (sumrak_count_test($labpoz[x],$labpoz[y]-1))					  	
					  		{
							  if ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
							  }
					  mysql_query("UPDATE `labirint_users` SET  `y`=`y`-1 WHERE `owner`='".$user[id]."' LIMIT 1;");
					  $labpoz[y]=$labpoz[y]-1;
					  if ($_SESSION[lab_bg]==0) {$_SESSION[lab_bg]=1;} else {$_SESSION[lab_bg]=0;}	
					  move_remember($STRAHOVKA,$labpoz);				  
					  }
					}
					$_SESSION['time'] = time()+$time_go;

				break;
			}
			//header("Location: lab.php"); //FREFRESH!!
			// ��� ���������� ������� ���� �� ���!!
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/*
if (($map[$labpoz[x]][$labpoz[y]]!='R') and ($map[$labpoz[x]][$labpoz[y]]!='J') and ($map[$labpoz[x]][$labpoz[y]]!='�') ) // �� ������ Q-����� - �� ������ ��� ����� ���� ��� �� ������!!!
{
   if ($Qmap[$labpoz[x]][$labpoz[y]]!='') // ������ ������� ���� � ����� ������
     {
     // ���� ���� ��������� ���� �� ����� �� ���� ��������� ��������� ��� ���
      // echo "Q-item<br>";
         if ($Aitems[$labpoz[x]][$labpoz[y]]=='Q')
            {
            // if ($user[id]==14897) { echo "���� � ���� ���<br>"; }
            }
            else
            {
            make_qpoint($_SESSION['questdata'],$user,$mapid);
            $Aitems[$labpoz[x]][$labpoz[y]]='Q';
            $Aitems_val[$labpoz[x]][$labpoz[y]]=$Qmap[$labpoz[x]][$labpoz[y]];
            $Aitems_count[$labpoz[x]][$labpoz[y]]=1;
            }
     }
}
*/

/////////


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
/*echo "/";
echo $view3dx[$g][12];
echo "/";
echo $labpoz['x'];		
*/
////��� ����������� ��������� ����� - ������ � ����� �.�. ��� ����������� ������ ���� � ������ ���
/////////////////////////////////////////////////////////////////////////////////////////////////////////


?>
<html>
<head>
	<link rel=stylesheet type="text/css" href="i/main.css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="i/showthing.js"></script>
	<script type="text/javascript" src="/i/globaljs.js"></script>
	<script>
   
					
					 $(document).ready(function () 	{
						 var isCtrl = false;
						document.onkeyup=function(e){ if(e.which == 17) isCtrl=false; }
						document.onkeydown=function(e) 
							{
							    if(e.which == 17) isCtrl=true;
							
							    if(e.which == 38) 
							    {
							        location.href='lab4.php?goto=p<?=$nap[$_SESSION['looklab']][1];?>';    
							    }
							    else if(e.which == 40) 
							    {
							        location.href='lab4.php?goto=p<?=$nap[$_SESSION['looklab']][3];?>';    
							    }
							    else if(e.which == 37 && isCtrl === true) {
							        location.href='lab4.php?look=2';    
 							       return false;
							    }
							    else if(e.which == 37) 
							    {
							        location.href='lab4.php?goto=p<?=$nap[$_SESSION['looklab']][4];?>';    
							    }			
							    else if(e.which == 39 && isCtrl === true) {
							        location.href='lab4.php?look=1';    
 							       return false;
							    }							    	
							    else if(e.which == 39) 
							    {
							        location.href='lab4.php?goto=p<?=$nap[$_SESSION['looklab']][2];?>';    
							    }										    			    
  							        return false;
							}
						
							$jq1113('a#settings').click( function(event){ 
								event.preventDefault(); 
								$jq1113('#overlay').fadeIn(400, 
								 	function(){ 
										$jq1113('#modal_form') 
											.css('display', 'block') 
											.animate({opacity: 1, top: '50%'}, 200); 
								});
							});

							$jq1113('#modal_close, #overlay').click( function(){ 
								$jq1113('#modal_form')
									.animate({opacity: 0, top: '45%'}, 200,  
										function(){ 
											$jq1113(this).css('display', 'none'); 
											$jq1113('#overlay').fadeOut(400); 
										}
									);
							});

							
						    });
					
						var $jq1113 = jQuery.noConflict( true );
						var invitemclicked = 0;

						function absInvPosition(obj) {
							var x = y = 0;
							while(obj) {
								x += obj.offsetLeft;
								y += obj.offsetTop;
								obj = obj.offsetParent;
							}
							return {x:x, y:y};
						}

						function ToggleInvP(id) {
							if (invitemclicked) {
								var tmp = invitemclicked;
								invitemclicked = 0;
								//HideInvThing(null,"info"+tmp);
								HideInvThing($jq1113('[data-id="'+tmp+'"]'));
							} else {
								invitemclicked = id;
							}
						}

						$jq1113(function(){
							$jq1113(document.body).on('mouseover', '.gift-block', function(e){
								if(invitemclicked)
									return;
								e = e || window.event;

								var $self = $jq1113(this).addClass('active');
								var item_id = $self.data('id');

								var windowSize = getWindowSize();
								var hint_x = e.pageX + 10;
								var hint_y = e.pageY + 10;

								var $hint = $jq1113('#info' + item_id).css({'max-width':'500px','min-width':'200px'});
								if (e.clientX + $hint.width() >= windowSize.w && (e.clientX - $hint.width()) > 20) {
									hint_x = hint_x - $hint.width() - 20;
								}
								if (e.clientY + $hint.height() >= windowSize.h && (e.clientY - $hint.height()) > 20) {
									hint_y = hint_y - $hint.height() - 10;
								}
								//console.log(hint_y, $hint.height(), windowSize.h);

								$hint.css({'left': hint_x, 'top': hint_y}).show();
							});

							$jq1113(document.body).on('mouseout', '.gift-block', function(e){
								HideInvThing($jq1113(this));
							});
						});

						function getWindowSize() {
							var myWidth = 0, myHeight = 0;
							if( typeof( window.innerWidth ) == 'number' ) {
								//Non-IE
								myWidth = window.innerWidth;
								myHeight = window.innerHeight;
							} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
								//IE 6+ in 'standards compliant mode'
								myWidth = document.documentElement.clientWidth;
								myHeight = document.documentElement.clientHeight;
							} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
								//IE 4 compatible
								myWidth = document.body.clientWidth;
								myHeight = document.body.clientHeight;
							}

							return {w: myWidth, h: myHeight};
						}

						function HideInvThing($self) {
							if(invitemclicked)
								return;

							$self.removeClass('active');
							var item_id = $self.data('id');
							$jq1113('#info' + item_id).hide();
						}

						function ShowInvThing(obj, id) {
							//console.log(obj, id);
							var $self = $(obj);
							if (!invitemclicked) {
								//console.log($self);
								var item_id = $self.data('id');
								var $hint = $('#info' + item_id).show();

								var $imgclear = $('#imgclear' + item_id);
								if ($imgclear.length) {
									$imgclear.show();
								}

								var $imgapply = $('#imgapply' + item_id);
								if ($imgapply.length) {
									$imgapply.show();
								}

								var $imginv = $('#imginv' + item_id);
								if ($imginv) {
									$imginv.css({'opacity':'0.2'});
								}

								img_x = absInvPosition(obj).x; // ������� ������ ���������
								img_y = absInvPosition(obj).y;
								yshift = 75; // ����������� ��������
								xshift = 75;

								//console.log('�����', img_x, img_y);
								//console.log('����', $hint.width(), $hint.height());
								//console.log('����', $(window).width(), $(window).height());

								//alert('���������� ����: ' + img_x + ' - ' + img_y);
								//alert('������: ' + $("#"+id).width() + ' - ' + $("#"+id).height());
								//alert('����: ' + $(window).width() + ' - ' + $(window).height());
								//alert('���� ����: ' + $('body').width() + ' - ' + $('body').height());

								//1305 + 944 1419
								if (img_x + $hint.width() >= $(window).width()) { // ���� ������� ����� + ������ ������� ������ ������
									img_x = img_x - $hint.width() + xshift; // �� �� ������� ������� �������� ������ �������
								} else {
									img_x=img_x+xshift;
								}

								if (img_y + $hint.height() >= $(window).height()) {
									img_y = img_y - $hint.height() + yshift;
								} else {
									img_y=img_y+yshift;
								}

								//alert('���������� ����: ' + img_x + ' - ' + img_y);

								$hint.css({'top': img_y + "px", 'left': img_x + "px"});
							}

						}

					
						
						
			


	</script>
	<style type="text/css">
	html { overflow:  hidden; }
	
	body 
	{
			background-repeat: no-repeat;
			background-position: top right;
	}
	
	.INPUT {
			width:50px; height:50px;
			BORDER-RIGHT: #b0b0b0 1pt solid; BORDER-TOP: #b0b0b0 1pt solid; MARGIN-TOP: 1px; FONT-SIZE: 10px; MARGIN-BOTTOM: 2px; BORDER-LEFT: #b0b0b0 1pt solid; COLOR: #191970; BORDER-BOTTOM: #b0b0b0 1pt solid; FONT-FAMILY: MS Sans Serif
		}
			.decor_left {
			height: 363px;
			width: 118px;
			background-repeat: no-repeat;
			background-position: right center;
			background-image: url(http://i.oldbk.com/i/imglab/decor_left.jpg);
			}
			.msg_center {
			position: relative;
			height: 50px;
			}

			.decor_right {
			height: 363px;
			width: 118px;
			background-repeat: no-repeat;
			background-position: left center;
			background-image: url(http://i.oldbk.com/i/imglab/decor_right.jpg);
			}
			.mainroom_center {
			height: 363px;
			width: 391px;
			background-image: url(http://i.oldbk.com/i/imglab/main_center.jpg);
			background-position: center center;
			background-repeat: no-repeat;
			}
			.mainroom_right {
			height: 363px;
			width: 244px;
			background-image: url(http://i.oldbk.com/i/imglab/main_right.jpg);
			background-position: center center;
			background-repeat: no-repeat;
			vertical-align: top;
			}
			.mianroom_left {
			height: 363px;
			width: 244px;
			background-image: url(http://i.oldbk.com/i/imglab/main_left.jpg);
			background-position: center center;
			background-repeat: no-repeat;
			}
			.navwind {
			font-size: 0px;
			}
			
			.room_items {
			
			}
			
			.compass {
			position: relative;
			top:25px;
			}
			
			.progressbar {
			background-image: url(http://i.oldbk.com/i/imglab/ldot.png);			
			background-repeat: repeat-x;
			position: relative;
			height: 15px;
			width: 0px;
			max-width:240px;
			left:22px;
			}

			.invthing {
				position:absolute;
				z-index:500;
				border:1px solid black;
				background-color:#ffffe1;
				min-width:10px;
				max-width:500px;
				padding-left:5px;
				padding-right:5px;
				padding-top:2px;
				padding-bottom:2px;
				box-shadow:5px 5px 10px rgba(0,0,0,0.5);
				-moz-box-shadow:5px 5px 10px rgba(0,0,0,0.5);
				-webkit-box-shadow:5px 5px 10px rgba(0,0,0,0.5);
				border-radius:5px 0px 5px 5px;
				-moz-border-radius:5px 0px 5px 5px;
				-webkit-border-radius:5px 0px 5px 5px;
				line-height:10px;
				font-size:9px;
			}
			.invclear {
				position:absolute;
				top:2px;
				left:3px;
				display:none;
			}
			.invapply {
				position:absolute;
				top:2px;
				left:41px;
				display:none;
			}
			.invgroupcount {
				position:absolute;
				top:41px;
				left:3px;
				font-weight:bold;
				background-color:#717070;
				width:30px;
				#color:#06F;
				#color:#038;
				#color:#0066CC;
				color:white;
				filter:alpha(opacity=90);
				-moz-opacity:0.9;
				opacity:0.9;
				text-align:center;
			}
			.gift-block {
				margin-top:5px;
				width:64px;
			}
			.gift-block .gift-image {
				opacity:1;
			}
			.gift-block.active .gift-image {
				opacity:0.8;
				-ms-filter:"alpha(opacity=20)";
				filter:alpha(opacity=20);
			}
			.gift-block.active .invclear,.gift-block.active .invapply {
				display:block;
			}
				
			
			#modal_form {
				width: 400px; 
				height: 200px;
				border-radius: 5px;
				border: 1px #000 solid;
				background: #e2e0e0;
				position: fixed;
				top: 45%; 
				left: 50%;
				margin-top: -150px;
				margin-left: -150px;
				display: none;
				opacity: 0; 
				z-index: 505;
				padding: 20px 10px;
			}

			#modal_form #modal_close {
				width: 21px;
				height: 21px;
				position: absolute;
				top: 10px;
				right: 10px;
				cursor: pointer;
				display: block;
			}

			#overlay {
				z-index:503;
				position:fixed; 
				background-color:#e2e0e0; 
				opacity:0.8;
				-moz-opacity:0.8;
				filter:alpha(opacity=80);
				width:100%; 
				height:100%;
				top:0; 
				left:0;
				cursor:pointer;
				display:none;
			}						
			
	</style>
	
	<script LANGUAGE="JavaScript">
	 window.interest = <? 
	 				$startp=($_SESSION['time']-time()); 
 					if ($startp<1) 
	 					{
	 					echo "99";
	 					}
	 					else
	 					{
	 					echo "0";
	 					}
	
	 ?>;
			function refreshPeriodic()
			{
				location.href='lab4.php?';//reload();
								timerID=setTimeout("refreshPeriodic()",30000000);
			}
			timerID=setTimeout("refreshPeriodic()",30000000);

			function confirmSubmit()
			{
			var agree=confirm('������������� ������ ����� � �������� ��� ���������?');
			if (agree)
				location.href='lab4.php?exit=true';
			else
				return false ;
			}
			
			var intervalID = setInterval("go()",<?=(($_SESSION['time_trap']==1)?"60":"10");?>);			
			
			function go()
			{
				if(interest <= 100) 
				{
					interest++;
					
					document.getElementById('progressbar').style.width = interest * 2 + 'px';
				}
				else
				{
				clearInterval(intervalID);
				
				}
		
			}	

					
						

			
	</script>


</head>
<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0  >
<div id="modal_form">
	<span id="modal_close">X</span>
		<form action="" method="post">
			<h3>���������</h3>
			<p>
			 <input type="checkbox" name="settings_north" value="true" <?=($settings_north==1?"checked":"");?>>�������������� � ������� ��������.<Br>
			 <input type="checkbox" name="settings_norotation" value="true" <?=($settings_norotation==1?"checked":"");?>>�� ������� ���������.<Br> 
			 <input type="checkbox" name="settings_control" value="true" <?=($settings_control==1?"checked":"");?>>���������� ������������ �� ���������.<Br> 			 
			 <input type="checkbox" name="settings_invert" value="true" <?=($settings_invert==1?"checked":"");?>>�������� ������� "�����������".<Br> 			 			 
			</p>
			<p style="text-align: center; padding-bottom: 10px;"><br><br>
			<input type="submit" name="settings_save" value="���������" />
			</p>
		</form>
</div>
<div id="overlay"></div>
<div id=hint3 class=ahint style="z-index:500;"></div>
<?
if ($labpoz['flr']>0)
					{
					$my_str_rfloor='<small>'.$labpoz['flr'].'-� ��.</small>';
					}
					else
					{
					$my_str_rfloor='';
					}

$map_echo.=" ���������� : X=<b>".$labpoz['x']."</b>  Y=<b>".$labpoz['y']."</b> ".$my_str_rfloor." <br>";

///Paint map prep
////////////////////////////////////////////////////////////////////////////////
//set user poz to mass
$room_map=$map[$labpoz['x']][$labpoz['y']];
$map[$labpoz['x']][$labpoz['y']]='U';


//////////////////////////////////////////////////////////////////////////

$lookmap=$map; //�������
$lookTA=$TA;
$lookAitems=$Aitems;
$lookJMOB=$JMOB;
$lookSJMOB=$SJMOB;
$lookRMOB=$RMOB;



///����������� �������� �������� �����////////////////
$disp=$labpoz[x]-5;
$dispy=$labpoz[y]-5;

$razmery=strlen($lookmap[1])-12;
$razmer=count($lookmap)-11; 



	if ($_SESSION['looklab']==90)
	{
	//������� �� ������� ������� �����
	$lookmap=array();
	$lookTA=array();
	if ($labpoz[x]<5) { $fixx=1;} else {$fixx=0;}
	
		for ($jj=1;$jj<$stopt;$jj++)
			 for ($ii=1;$ii<$stopt;$ii++)
			{
				$lookmap[$ii][$jj]=$map[$stopt-$jj-$fixx][$ii-0];
				$lookTA[$ii][$jj]=$TA[$stopt-$jj-$fixx][$ii-0];
				$lookAitems[$ii][$jj]=$Aitems[$stopt-$jj-$fixx][$ii-0];
				$lookJMOB[$ii][$jj]=$JMOB[$stopt-$jj-$fixx][$ii-0];				
				$lookSJMOB[$ii][$jj]=$SJMOB[$stopt-$jj-$fixx][$ii-0];								
				$lookRMOB[$ii][$jj]=$RMOB[$stopt-$jj-$fixx][$ii-0];								
				
				if ($lookmap[$ii][$jj]=='U')
				{
				$disp=$ii-5;
				$dispy=$jj-5;
				$razmery-=1;
				
				}
				
			}
	}	
	else
	if ($_SESSION['looklab']==180)
	{
	$lookmap=array();
	$lookTA=array();
	if ($labpoz[x]<5) { $fixx=1;} else {$fixx=0;}
		for ($jj=1;$jj<$stopt;$jj++)
			 for ($ii=1;$ii<$stopt;$ii++)
			{
				$lookmap[$ii][$jj]=$map[$stopt-$ii-$fixx][$stopt-$jj-0];
				$lookTA[$ii][$jj]=$TA[$stopt-$ii-$fixx][$stopt-$jj-0];
				$lookAitems[$ii][$jj]=$Aitems[$stopt-$ii-$fixx][$stopt-$jj-0];				
				$lookJMOB[$ii][$jj]=$JMOB[$stopt-$ii-$fixx][$stopt-$jj-0];						
				$lookSJMOB[$ii][$jj]=$SJMOB[$stopt-$ii-$fixx][$stopt-$jj-0];										
				$lookRMOB[$ii][$jj]=$RMOB[$stopt-$ii-$fixx][$stopt-$jj-0];														
				if ($lookmap[$ii][$jj]=='U')
				{
				$disp=$ii-5;
				$dispy=$jj-5;
					$razmer-=1;	
				}
				
			}	
	}
	elseif ($_SESSION['looklab']==270)
	{
		$lookmap=array();
		$lookTA=array();		
		for ($jj=1;$jj<$stopt;$jj++)
			 for ($ii=1;$ii<$stopt;$ii++)
			{
				$lookmap[$ii][$jj]=$map[$jj][$stopt-$ii-0];
				$lookTA[$ii][$jj]=$TA[$jj][$stopt-$ii-0];				
				$lookAitems[$ii][$jj]=$Aitems[$jj][$stopt-$ii-0];								
				$lookJMOB[$ii][$jj]=$JMOB[$jj][$stopt-$ii-0];												
				$lookSJMOB[$ii][$jj]=$SJMOB[$jj][$stopt-$ii-0];																
				$lookRMOB[$ii][$jj]=$RMOB[$jj][$stopt-$ii-0];						
				if ($lookmap[$ii][$jj]=='U')
				{
				$disp=$ii-5;
				$dispy=$jj-5;
				}
			}
	}	

$ukazka[0][1]='ar';$ukazka[0][2]='al';$ukazka[0][3]='af';$ukazka[0][4]='ab';
$ukazka[90][3]='ar';$ukazka[90][4]='al';$ukazka[90][2]='af';$ukazka[90][1]='ab';
$ukazka[180][2]='ar';$ukazka[180][1]='al';$ukazka[180][4]='af';$ukazka[180][3]='ab';
$ukazka[270][4]='ar';$ukazka[270][3]='al';$ukazka[270][1]='af';$ukazka[270][2]='ab';




$ukazkam[0][1]='uk1';$ukazkam[0][2]='uk2';$ukazkam[0][3]='uk3';$ukazkam[0][4]='uk4';
$ukazkam[90][3]='uk1';$ukazkam[90][4]='uk2';$ukazkam[90][2]='uk3';$ukazkam[90][1]='uk4';
$ukazkam[180][2]='uk1';$ukazkam[180][1]='uk2';$ukazkam[180][4]='uk3';$ukazkam[180][3]='uk4';
$ukazkam[270][4]='uk1';$ukazkam[270][3]='uk2';$ukazkam[270][1]='uk3';$ukazkam[270][2]='uk4';


	if ($settings_norotation==1)	
	{
				$wlookmap=$map;
				$wlookTA=$TA;
				$wlookAitems=$Aitems;
				$wlookJMOB=$JMOB;				
				$wlookSJMOB=$SJMOB;								
				$wlookRMOB=$RMOB;
				$wlookukaz=0;
				$disp=$labpoz[x]-5;
				$dispy=$labpoz[y]-5;
	}
	else
		{
				$wlookmap=$lookmap;
				$wlookTA=$lookTA;
				$wlookAitems=$lookAitems;
				$wlookJMOB=$lookJMOB;
				$wlookSJMOB=$lookSJMOB;
				$wlookRMOB=$lookRMOB;
				$wlookukaz=$_SESSION['looklab'];				
		}


	
				//�������������� ����������  ����������� �������� ��������
				if ($disp < 1) {$disp=1;}
				if ($dispy < 1) {$dispy=1;}
				///����������� �������� �������� �����////////////////
				if ($dispy > $razmery)  {$dispy=$razmery;} //������������ ������ ����� �� y
				if ($disp > $razmer) 	{ $disp=$razmer;  } //������������ ������ ����� �� �
				$dispfin=$disp+10; //������� ������� � ���
				$dispfiny=$dispy+10; //������� ������� y ���
				/////////////////////////////////////////////					

/*echo $disp." === ".$dispfin;
echo "<br>";
echo $dispy." === ".$dispfiny;
*/




 for ($i=$disp;$i<=$dispfin;$i++)
	{
 	$linte=""; // for visualimage
	for ($j=$dispy;$j<=$dispfiny;$j++)
		{






switch($wlookmap[$i][$j])
			{

case "I":
		{
		 if ($wlookTA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/os'.$LAB.'.gif title="����" alt="����">';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">';
			}
		 } // ����
break;

case "F":
		{
		 if ($wlookTA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/of'.$LAB.'.gif title="�����" alt="�����">';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">';
			}
		 } // �����
break;

case "O":
		{
		 if ($wlookTA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">';
			}
		 } // ������
break;

case "Q":
		{
		 if ($wlookTA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif  title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">';
			}
		 } // ������ 2 ��� ������
break;

case 'M' :
		{
		$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/m'.$LAB.'.gif>';
		} // ������
break;


case 'N' :
		{
		$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/n'.$LAB.'.gif>';
		} // ������
break;

case 'R' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
			if ($wlookAitems[$i][$j]!='R')
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/r'.$LAB.'.gif title="'.$wlookRMOB[$i][$j].'" alt="'.$wlookRMOB[$i][$j].'">'; // �������� ������
					}
					else
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ���� �������
					}

			}
			else
			{
				if ($wlookAitems[$i][$j]!='R')
					{
					$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� � �������
					}
					else
					{
					 if ($wlookAitems_val[$i][$j]>0)
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$wlookTA[$i][$j].' - � ���" alt="'.$wlookTA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� � �������-�����
						}


					}
			}
		 } // mob
break;

case '�' : //�����
		{
		 if ($wlookTA[$i][$j]=='')
			{
			if ($wlookAitems[$i][$j]!='�')
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/j'.$LAB.'.gif title="'.$wlookSJMOB[$i][$j].'" alt="'.$wlookSJMOB[$i][$j].'">'; // �������� ������
					/*echo "FFFFF";
					echo $i;
					echo "/";
					echo $j;
				        echo $wlookAitems[$i][$j];
       					echo "<br>";	*/
					}
					else
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ���� �������
					}

			}
			else
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� � �������
					}
					else
					{
					 if ($wlookAitems_val[$i][$j]>0)
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$wlookTA[$i][$j].' - � ���" alt="'.$wlookTA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� � �������-�����
						}


					}
			}
		 } // mob
break;

case 'J' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
			if ($wlookAitems[$i][$j]!='J')
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/j'.$LAB.'.gif title="'.$wlookJMOB[$i][$j].'" alt="'.$wlookJMOB[$i][$j].'">'; // �������� ������
					/*echo "FFFFF";
					echo $i;
					echo "/";
					echo $j;
				        echo $wlookAitems[$i][$j];
       					echo "<br>";	*/
					}
					else
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ���� �������
					}

			}
			else
			{
				if ($wlookAitems[$i][$j]!='J')
					{
					$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� � �������
					}
					else
					{
					 if ($wlookAitems_val[$i][$j]>0)
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$wlookTA[$i][$j].' - � ���" alt="'.$wlookTA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� � �������-�����
						}


					}
			}
		 } // mob
break;


case 'B' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='B')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/b'.$LAB.'.gif alt="�������" title="�������" >'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // �������� �������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/b'.$LAB.'.gif alt="���-�������" title="���-�������" >'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // �������� �������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/tz'.$LAB.'.gif alt="������ �����������" title="������ �����������" >'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // �������� �������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/fire'.$LAB.'.gif alt="�������� ���-�������" title="�������� ���-�������" >'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // �������� �������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ice'.$LAB.'.gif alt="������� ���-�������" title="������� ���-�������" >'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // �������� �������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case 'G' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='G')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/g'.$LAB.'.gif>'; 
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/gg'.$LAB.'.gif>'; //�������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$wlookukaz][3].'.gif alt="����������� �� �����" title="����������� �� �����" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$wlookukaz][4].'.gif alt="����������� �� ��" title="����������� �� ��" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$wlookukaz][2].'.gif alt="����������� ������" title="����������� �� �����" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$wlookukaz][1].'.gif alt="����������� �������" title="����������� �� ������" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '1' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='1')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/kz.gif alt="�����" title="�����" >'; // �����
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '2' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='2')
					{
					
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/2'.$LAB.'.gif alt="����������" title="����������" >'; // ����������					 
					
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;


case '5' : // ������� �� ��.����
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='5')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/5'.$LAB.'.gif alt="������� �� ��������� ����" title="������� �� ��������� ����" >'; // ����������					 
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case 'A' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='A')
					{
					if ( (($_SESSION['looklab']==90) OR ($_SESSION['looklab']==180) ) and $settings_norotation!=1 )					
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/e'.$LAB.'.gif  >';					
					}
					else
						{
						 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/a'.$LAB.'.gif  >';
						 }
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case 'E' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='E')
					{
					if ( (($_SESSION['looklab']==90) OR ($_SESSION['looklab']==180) ) and $settings_norotation!=1 )
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/a'.$LAB.'.gif  >'; 					
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/e'.$LAB.'.gif  >'; 
					 }
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ���
			}
		 } //

break;


case 'D' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='D')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/d'.$LAB.'.gif alt="�����" title="�����" >'; // ��������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/d'.$LAB.'.gif alt="�����" title="�����" >'; // ��������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case 'T' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
	//			if ($wlookAitems[$i][$j]!='T')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/t'.$LAB.'.gif alt="'.$wlookAitems[$i][$j].'" title="'.$wlookAitems[$i][$j].'" >'; // ��������
					}
	/*				else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}
	*/
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� �
			}
		 } //

break;

case 'X' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='X')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/x'.$LAB.'.gif alt="�����" title="�����" >'; // ��������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case 'Z' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='Z')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/z'.$LAB.'.gif alt="�����" title="�����" >'; // ��������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case 'C' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='C')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/c'.$LAB.'.gif alt="�����" title="�����" >'; // ��������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;


case 'P' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if (($wlookAitems[$i][$j]!='P') AND ($wlookAitems[$i][$j]!='�') )
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/p'.$LAB.'.gif alt="���� �������" title="���� �������">'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // �������� �������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/pt'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // BOX P) �������

break;


case 'S' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='S')
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/s'.$LAB.'.gif alt="������" title="������">' ; //������
							}
							else
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>' ;  //������ ������
							}
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/st'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'W' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='W')
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/w'.$LAB.'.gif alt="�����" title="�����">' ; //������
							}
							else
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>' ;  //������ ������
							}
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'Y' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='Y')
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/y'.$LAB.'.gif alt="�����" title="�����">' ; //������
							}
							else
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>' ;  //������ ������
							}
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'L' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='L')
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/l'.$LAB.'.gif alt="�����" title="�����">' ; //������
							}
							else
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>' ;  //������ ������
							}
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'K' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
				if ($wlookAitems[$i][$j]!='K')
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/k'.$LAB.'.gif alt="�����" title="�����">' ; //������
							}
							else
							{
							$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>' ;  //������ ������
							}
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case '�' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
					if ($wlookAitems[$i][$j]!='�')
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ah'.$LAB.'.gif alt="�������" title="�������" >';
							}
							else
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';	// ������ �����
							}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ht'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� �������� � �����
			}
		 } 

break;

case 'H' :
		{
		 if ($wlookTA[$i][$j]=='')
			{
					if ($wlookAitems[$i][$j]!='H')
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/h'.$LAB.'.gif alt="������� �����" title="������� �����" >'; // �����
							}
							else
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';	// ������ �����
							}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ht'.$LAB.'.gif title="'.$wlookTA[$i][$j].'" alt="'.$wlookTA[$i][$j].'">'; // ����� ��� �������� � �����
			}
		 } // �����

break;

case 'U' :// � �� �����
		{

		if ($settings_norotation==1) 		
			{
				$tolook['0']='<span style="position:absolute;top:-6px;left:0px;"><img src=http://capitalcity.oldbk.com/i/plab/map/look3.gif></span>'; 
				$tolook['90']='<span style="position:absolute;top:-3px;left:-5px;"><img src=http://capitalcity.oldbk.com/i/plab/map/look2.gif></span>';
				
				$tolook['180']='<span style="position:absolute;top:9px;left:0px;"><img src=http://capitalcity.oldbk.com/i/plab/map/look4.gif></span>'; 
				
				$tolook['270']='<span style="position:absolute;top:-3px;left:14px;"><img src=http://capitalcity.oldbk.com/i/plab/map/look1.gif></span>';
				$tolook=$tolook[$_SESSION['looklab']];
			}
			else
			{
				$tolook='<span style="position:absolute;top:-6px;left:0px;"><img src=http://capitalcity.oldbk.com/i/plab/map/look3.gif></span>'; //c
			}
		
		 if ($wlookTA[$i][$j]=='')
			{
			  $linte.='<span style="position:relative;"><img src=http://capitalcity.oldbk.com/i/plab/map/u'.$LAB.'.gif title="�" alt="�">'.$tolook.'</span>';	  
			}
			else
			{
			$linte.='<span style="position:relative;"><img src=http://capitalcity.oldbk.com/i/plab/map/ut'.$LAB.'.gif title="� ,'.$wlookTA[$i][$j].'" alt="�, '.$wlookTA[$i][$j].'">'.$tolook.'</span>'; //� � ��� ����� �� ����
			}
		 } // user
break;




			}

            }
	  $MAP_SCREEN.=$linte."<br>\n";
	}

//echo $MAP_SCREEN;

///3D - view
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
echo $room_map;
echo "<br>";
echo $map[$labpoz['x']-1][$labpoz['y']-2] ;
echo $map[$labpoz['x']-1][$labpoz['y']-1] ;
echo $map[$labpoz['x']-1][$labpoz['y']] ;
echo $map[$labpoz['x']-1][$labpoz['y']+1] ;
echo $map[$labpoz['x']-1][$labpoz['y']+2] ;
echo "<br>";
echo $map[$labpoz['x']][$labpoz['y']-2] ;
echo $map[$labpoz['x']][$labpoz['y']-1] ;
echo $map[$labpoz['x']][$labpoz['y']] ;
echo $map[$labpoz['x']][$labpoz['y']+1] ;
echo $map[$labpoz['x']][$labpoz['y']+2] ;
*/

		$IN_ROOM_PRINT='';
		$IN_ROOM_DO_PRINT=array();
		
		//��������� ����� �������� ����������
		$fitemsid=array();
		
		//0 . �����
		$unukey=0;
		foreach($doors as $did=>$dname)
		{
		if (get_door_xy($dname))
			{
 			$fitemsid[]=$dkey[$did];
 				
 				
			 if ($unukey==0)
				 	{
		 			$fitemsid[]=3333;
		 			$unukey=1;
				 	}
			}
		}

		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
			{
			$fitemsid[]=4308;
			}

		// 1. ������ = ����� ������ �������
		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='G') )
			{
			$fitemsid[]=4304;
			$fitemsid[]=4305;
			}
		//2. �������� ��� = ���� ����� � �����
		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )		
			{
			$fitemsid[]=4307;
			$fitemsid[]=4313; //  ������ ���			
			}
		//3. ��� ������� = �����
		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
			{
			$fitemsid[]=4310;
			}
		//4 ��� ��� = �����
		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
			{
			$fitemsid[]=4310;
			}
		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
			{
			//$fitemsid[]=4300;
			//$fitemsid[]=4301;
			//$fitemsid[]=4302;
			$fitemsid[]=4303;			
			}
		//����� �����
		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') and ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�') )
			{
			//���� ���
			$fitemsid[]=3333;
			
			}
		
		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='E') and ($labpoz['x']+$view3dx[$g][12]>$labpoz['x'])  )
			{
			$fitemsid[]=4306; //  ������ �����
			}

		if (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='A') and  ($labpoz['x']+$view3dx[$g][12]<$labpoz['x']) )
			{
			$fitemsid[]=4313; //  ������ ���
			}
		

		if (($room_map=='P') and ($Aitems[$labpoz['x']][$labpoz['y']]=='P') )
			{
			// ������� ���� �������
			//���� �������
			$fitemsid[]=4300;
			$fitemsid[]=4301;
			$fitemsid[]=4302;
			}		
		
		//������ ����� ���� ����
			
		if ($user['hp']!=$user['maxhp'] )
			{
			$fitemsid[]=4311; // ���� ���
			}

		if ($print_effe_lab!='')
			{
			$fitemsid[]=4312; 
			}		
		
		//�������� ��������� ��� �������������
		$mol=0;
		$nog=0;
		$smur=0;
		
		
		//��������� ������ �������
		$fitemsid[]=2170; 
		$fitemsid[]=2171; 		
		$fitemsid[]=2172; 		
		$fitemsid[]=2173; 		
		
		
if (count($fitemsid)>0)		
{
		$get_useitems=mysql_query("select *, count(id) as kol from oldbk.inventory where  prototype in (".implode(",",$fitemsid).") and owner='{$user[id]}' and setsale=0 GROUP by  prototype order by prototype");
			while ($r = mysql_fetch_array($get_useitems))
				{
				$bg=false;
					/*
					//����������� �� ������������� ���������
					if (($r['prototype']==4300) OR ($r['prototype']==4301) OR ($r['prototype']==4302) )
						{
						//�������
							if ($mol==0)
								{
								$IN_ROOM_DO_PRINT[]=showitem2($r,$r['kol'], 1, 0, false,'#',0);						
								$mol=count($IN_ROOM_DO_PRINT);
								}
								else
								{
								//�������������� ����� ������
								$IN_ROOM_DO_PRINT[$mol-1]=showitem2($r,$r['kol'], 1, 0, false,'#',0);						
								}
						}
						elseif (($r['prototype']==4304) OR ($r['prototype']==4305) )
						{
						//�������
							if ($nog==0)
								{
								$IN_ROOM_DO_PRINT[]=showitem2($r,$r['kol'], 1, 0, false,'#',0);						
								$nog=count($IN_ROOM_DO_PRINT);
								}
								else
								{
								//�������������� ����� ������
								$IN_ROOM_DO_PRINT[$nog-1]=showitem2($r,$r['kol'], 1, 0, false,'#',0);						
								}
						} */
						
						//����������� ������� �������
						
						
						if (($r['prototype']==3301)  OR  ($r['prototype']==3302)  OR  ($r['prototype']==3303)  OR  ($r['prototype']==3304))
							{
							
							$dk=array_search($r['prototype'], $dkey); 
							$dname=$doors[$dk];
							
					 		$link_use_key_a[$dname]="<a href=?useitem={$r['id']}>";
					 		$link_use_key_h[$dname]="</a>";
							}
							
						if($r['prototype']==3333) 
						{
						
						 if ($link_use_key_a['C']=='')  { $link_use_key_a['C']="<a href=?useitem={$r['id']}>"; 		$link_use_key_h['C']="</a>"; }
						 if ($link_use_key_a['D']=='')  { $link_use_key_a['D']="<a href=?useitem={$r['id']}>"; 		$link_use_key_h['D']="</a>";}
						  if ($link_use_key_a['�']=='')  { $link_use_key_a['�']="<a href=?useitem={$r['id']}>"; 	$link_use_key_h['�']="</a>";}
						 if ($link_use_key_a['X']=='')  { $link_use_key_a['X']="<a href=?useitem={$r['id']}>"; 		$link_use_key_h['X']="</a>";}				 		
						 if ($link_use_key_a['Z']=='')  { $link_use_key_a['Z']="<a href=?useitem={$r['id']}>";		$link_use_key_h['Z']="</a>";}				 		
						}

						if (($r['prototype']==2170) OR ($r['prototype']==2171) OR ($r['prototype']==2172) OR ($r['prototype']==2173) )
						{
						
							if ($smur==0)
								{
								$IN_ROOM_DO_PRINT[]=showitem2($r,$r['kol'], 1, 0, false,"location.href='?useitem={$r['id']}'",0);						
								$smur=count($IN_ROOM_DO_PRINT);
								}
								else
								{
								//�������������� ����� ������
								$IN_ROOM_DO_PRINT[$smur-1]=showitem2($r,$r['kol'], 1, 0, false,"location.href='?useitem={$r['id']}'",0);						
								}
						}
						else
						{
						$IN_ROOM_DO_PRINT[]=showitem2($r,$r['kol'], 1, 0, false,"location.href='?useitem={$r['id']}'",0,bg_item_fix($r['prototype']));						
						}
						
				}
}

$d3_out='';

    $left=0;
    $top=0;




{
////////////////////////////////////////�-4
if ( ($map[$labpoz['x']+$view3dx[$g][42]][$labpoz['y']+$view3dy[$g][42]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][42]][$labpoz['y']+$view3dy[$g][42]]=='') OR ($map[$labpoz['x']+$view3dx[$g][42]][$labpoz['y']+$view3dy[$g][42]]=='M')  )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_2.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][42]][$labpoz['y']+$view3dy[$g][42]]=='G')  )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_2_g.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][42]][$labpoz['y']+$view3dy[$g][42]]=='A')  )
	{
	  		if ($labpoz['x']+$view3dx[$g][42]>$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{		
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_2_f.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][42]][$labpoz['y']+$view3dy[$g][42]]=='E')  )
	{
	  		if ($labpoz['x']+$view3dx[$g][42]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_2_w.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][42]][$labpoz['y']+$view3dy[$g][42]]=='�')  )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_2_i.png  width=352 height=240></div>';
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='') or ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='M') 
or ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='�') or ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='C') or ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='D') or ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='X') or ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='Z') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_1.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='G') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_1_g.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='A') )
	{
	  		if ($labpoz['x']+$view3dx[$g][41]>$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{		
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_1_f.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='E') )
	{
	  		if ($labpoz['x']+$view3dx[$g][41]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_1_w.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][41]][$labpoz['y']+$view3dy[$g][41]]=='�') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_1_i.png  width=352 height=240></div>';
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='') or ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='G') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_g.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='A') )
	{
	  		if ($labpoz['x']+$view3dx[$g][4]>$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_f.png  width=352 height=240></div>';
			}
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='E') )
	{
	  		if ($labpoz['x']+$view3dx[$g][4]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_w.png  width=352 height=240></div>';
			}
	}		
	elseif ( ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_i.png  width=352 height=240></div>';
		}
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][43]][$labpoz['y']+$view3dy[$g][43]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][43]][$labpoz['y']+$view3dy[$g][43]]=='') or ($map[$labpoz['x']+$view3dx[$g][43]][$labpoz['y']+$view3dy[$g][43]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_2.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][43]][$labpoz['y']+$view3dy[$g][43]]=='G') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_2_g.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][43]][$labpoz['y']+$view3dy[$g][43]]=='A') )
	{
		if ($labpoz['y']+$view3dy[$g][43] > $labpoz['y'])
		{
		//�����
		}
		else
		{		
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_2_f.png  width=352 height=240></div>';
		}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][43]][$labpoz['y']+$view3dy[$g][43]]=='E') )
	{
		if ($labpoz['y']+$view3dy[$g][43] < $labpoz['y'])
		{
		//�����
		}
		else
		{	
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_2_w.png  width=352 height=240></div>';
		}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][43]][$labpoz['y']+$view3dy[$g][43]]=='�') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_2_i.png  width=352 height=240></div>';
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='') or ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='M') 
or ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='�')or ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='C') or ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='D') or ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='X') or ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='Z') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_1.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='G') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_1_g.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='A') )
	{
		if ($labpoz['y']+$view3dy[$g][44] > $labpoz['y'])
		{
		//�����
		}
		else
		{	
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_1_f.png  width=352 height=240></div>';
		}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='E') )
	{
		if ($labpoz['y']+$view3dy[$g][44] < $labpoz['y'])
		{
		//�����
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_1_w.png  width=352 height=240></div>';
		}
	}		
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][44]][$labpoz['y']+$view3dy[$g][44]]=='�') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/4_1_i.png  width=352 height=240></div>';
	}	

//�����	

if ( ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='�')  or ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='X') or ($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='Z') )
	{
		$door_type=$map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]];
		if ($door_type=='�') { $door_type='DD'; }		
		
			if ($Aitems[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]!=$map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]])
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_'.$door_type.'_c.png  title="�������" alt="�������" width=352 height=240></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_'.$door_type.'_o.png  width=352 height=240></div>';									
			}

	}
	elseif($map[$labpoz['x']+$view3dx[$g][4]][$labpoz['y']+$view3dy[$g][4]]=='�')
	{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_dark.png  width=352 height=240></div>';									
	}
	
//////////////////x-3
if ( ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='') or ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/3_0.png  width=352 height=240></div>';
	}
	else
	//�������� �����  ������ 3-� ���
	if ( ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='G') OR ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='Z') )
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='G')
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/3_0_g0.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/3_0_g.png  width=352 height=240></div>';
		}
	}
	elseif ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='�') 
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='�') 
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/3_0_ig.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/3_0_i.png  width=352 height=240></div>';
		}
	}	
	else
	if ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='A') 
	{
		if ($labpoz['y']+$view3dy[$g][32] > $labpoz['y'])
			{
			// �����
			}
			else
			{	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/3_0_f.png  width=352 height=240></div>';
			}
	}	
	else
	if ($map[$labpoz['x']+$view3dx[$g][32]][$labpoz['y']+$view3dy[$g][32]]=='E') 
	{
		if ($labpoz['y']+$view3dy[$g][32] < $labpoz['y'])
			{
			// �����
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/3_0_w.png  width=352 height=240></div>';
			}
	}	
		
if ( ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='') or ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/3_0.png  width=352 height=240></div>';
	}
	else
	//�������� ����� 3-� ��� ���
	if ( ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='G') OR ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='Z') )
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='G')
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/3_0_g0.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/3_0_g.png  width=352 height=240></div>';
		}
		
	}
	elseif ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='�') 
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='�') 
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/3_0_ig.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/3_0_i.png  width=352 height=240></div>';
		}
	}	
	else
	if ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='A') 
	{
	  		if ( $labpoz['x']+$view3dx[$g][31]>$labpoz['x'] )
	  		{
	  		// �����
	  		}
	  		else
	  		{	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/3_0_f.png  width=352 height=240></div>';
			}
	}	
	else
	if ($map[$labpoz['x']+$view3dx[$g][31]][$labpoz['y']+$view3dy[$g][31]]=='E') 
	{
	  		if ( $labpoz['x']+$view3dx[$g][31]<$labpoz['x'] )
	  		{
	  		// �����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/3_0_w.png  width=352 height=240></div>';
			}
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='') or ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='M') 
or ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='�') or ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='C')or ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='D')or ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='X')or ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='Z')  )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_1.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='G') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='G') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_1_g0.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_1_g.png  width=352 height=240></div>';
		}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='A') )
	{
		if ($labpoz['x']+$view3dx[$g][3] > $labpoz['x'])
		{
		//�����
		}
		else
		{	
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_1_f.png  width=352 height=240></div>';
		}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='E') )
	{
	  		if ($labpoz['x']+$view3dx[$g][3]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_1_w.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][3]][$labpoz['y']+$view3dy[$g][3]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_1_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_1_i.png  width=352 height=240></div>';
		}
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='') or ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='M') or 
($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='�') or ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='C') or ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='D') or ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='X') or ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='Z') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/3_1.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='G') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='G') )
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/3_1_g0.png  width=352 height=240></div>';
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/3_1_g.png  width=352 height=240></div>';
			}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='A') )
	{
		if ($labpoz['y']+$view3dy[$g][33] > $labpoz['y'])
		{
		//�����
		}
		else
		{	
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/3_1_f.png  width=352 height=240></div>';
		}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='E') )
	{
		if ($labpoz['y']+$view3dy[$g][33] < $labpoz['y'])
		{
		//�����
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/3_1_w.png  width=352 height=240></div>';
		}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][33]][$labpoz['y']+$view3dy[$g][33]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/3_1_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/3_1_i.png  width=352 height=240></div>';
		}
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='') or ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='G') OR ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='G') )
	{
	$wl="";
	if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='G')
			{
			//������� ��� �������
			$wl=0;
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_g'.$wl.'.png  width=352 height=240></div>';			
			}
	
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_g'.$wl.'.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='A') )
	{
			if ($labpoz['x']+$view3dx[$g][34]>$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_f.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='E') )
	{
			if ($labpoz['x']+$view3dx[$g][34]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_w.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_i.png  width=352 height=240></div>';
		}
	}	

if  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='I')
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_start.png  width=352 height=240></div>';				
	}
elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='F')	
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/4_0_fin.png  width=352 height=240></div>';					
	}

//�����	
if ( ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='D')  OR ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  or ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='X') or ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='Z') )
	{
	$door_type=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]];
	if ($door_type=='�') { $door_type='DD'; }	
	
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_'.$door_type.'_c.png  title="�������" alt="�������" width=352 height=240></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_'.$door_type.'_o.png  width=352 height=240></div>';									
			}
	
	}
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')
	{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_dark.png  width=352 height=240></div>';									
	}
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='J')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
				{
					$d3_out.='<DIV style="position:absolute;z-index:0;left:'.($left+144).'px;top: '.($top+60).'px;"><IMG src=/i/plab/Left/Front/4_0_j_'.$JMOB_id[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'.png title="'.$JMOB[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'" alt="'.$JMOB[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'" ></div>';											
				}
			}
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
				{
					$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+130).'px;top: '.($top+70).'px;"><IMG src=/i/plab/Left/Front/4_0_j_'.$SJMOB_id[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'.png title="'.$SJMOB[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'" alt="'.$SJMOB[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'" ></div>';											
				}
			}			
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='R')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
				{
					$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+144).'px;top: '.($top+60).'px;"><IMG src=/i/plab/Left/Front/4_0_j_'.$RMOB_id[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'.png title="'.$RMOB[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'" alt="'.$RMOB[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]].'" ></div>';
				}
			}
			
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='S')  //������	
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_4.png" alt="������" title="������"   border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_4_open.png" alt="�������� ������" title="�������� ������"  border=0 ></div>';									
			}
		}	  
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='H')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+170).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/heal_4.png" alt="������� �����" title="������� �����"  border=0 ></a></div>';						
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+170).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������"  border=0 ></div>';									
			}
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+170).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/cure_4.png" alt="�������" title="�������"  border=0 ></a></div>';						
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+170).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������"  border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='W')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_on_4.png" alt="�����" title="�����"  border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_off_4.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='K')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_on_4.png" alt="�����" title="�����"  border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_off_4.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='L')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_on_4.png" alt="�����" title="�����"  border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_off_4.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='Y')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_on_4.png" alt="�����" title="�����"  border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+160).'px;top:'.($top+128).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_off_4.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='P')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!='�')
			{		
				if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
				{
				$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+150).'px;top:'.($top+115).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_4.png" alt="���� �������" title="���� �������" border=0 ></div>';						
				}
				else
				{
				$d3_out.='<DIV style="position:absolute;z-index:30;left:'.($left+150).'px;top:'.($top+115).'px; overflow: hidden;"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_4open.png" alt="�������� ���� �������" title="�������� ���� �������" border=0 ></div>';									
				}
			}
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='T')  //������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+105).'px;top:'.($top+70).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_t.png  alt="������ X:'.($labpoz['x']+$view3dx[$g][12]).'/Y:'.($labpoz['y']+$view3dy[$g][12]).'" title="������ X:'.($labpoz['x']+$view3dx[$g][12]).'/Y:'.($labpoz['y']+$view3dy[$g][12]).'" width="40%"   border=0></div>';								
		}					
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='2')  //����������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+130).'px;top:'.($top+60).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_star.gif  alt="����������" title="����������"   border=0 width=117 height=80></div>';								
		}	
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='5')  //������-�� ����
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+105).'px;top:'.($top+70).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_t.png  alt="�������  �� '.$lab_floor_next_str.' ����" title="������� �� '.$lab_floor_next_str.' ����" width="40%"   border=0></div>';								
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+150).'px;top:'.($top+70).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][1].'.png  alt="���������" title="���������"   border=0 width=88 height=60></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+150).'px;top:'.($top+70).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][2].'.png  alt="���������" title="���������"   border=0 width=88 height=60></div>';								
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+150).'px;top:'.($top+70).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][3].'.png  alt="���������" title="���������"   border=0 width=88 height=60></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+150).'px;top:'.($top+70).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][4].'.png  alt="���������" title="���������"   border=0 width=88 height=60></div>';								
		}	
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  //���
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+125).'px;top:'.($top+125).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap2_4.png  alt="���-�������" title="���-�������"   border=0  ></div>';								
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			//��� �����
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(3);
			}
		
		}									
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  //��� �����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+125).'px;top:'.($top+125).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap3_4.png  alt="�������� ���-�������" title="�������� ���-�������"   border=0  ></div>';								
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+125).'px;top:'.($top+125).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap3_4_o.png  alt="����� �������" title="����� �������"   border=0  ></div>';								
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]=='�')  //��� ���
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+125).'px;top:'.($top+125).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap1_4.png  alt="������� ���-�������" title="������� ���-�������"   border=0  ></div>';								
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]]!=$map[$labpoz['x']+$view3dx[$g][34]][$labpoz['y']+$view3dy[$g][34]])
			{
			//��� �����
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(3);
			}
		
		}		
		
/////////////////////////x-2

if ( ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='') or ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='G') )
	{
			if ( ($Aitems[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='G') )
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_g0.png  width=352 height=240></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_g.png  width=352 height=240></div>';
			}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='A') )
	{
	  		if ( $labpoz['x']+$view3dx[$g][21]>$labpoz['x'] )
	  		{
	  		// �����
	  		}
	  		else
	  		{	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_f.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='E') )
	{
	  		if ( $labpoz['x']+$view3dx[$g][21]<$labpoz['x'] )
	  		{
	  		// �����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_w.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_ig.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_i.png  width=352 height=240></div>';
		}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]=='Z'))
	{
		$door_type=$map[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]];
	
		if ($Aitems[$labpoz['x']+$view3dx[$g][21]][$labpoz['y']+$view3dy[$g][21]]!=$door_type)
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_door_c.png  width=352 height=240></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/2_0_door_o.png  width=352 height=240></div>';			
			}
		
	}
	
	
if ( ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='') or ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='M') 
or ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='�') or ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='C') or ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='D') or ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='X') or ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='Z') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_1.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='G') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='G') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_1_g0.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_1_g.png  width=352 height=240></div>';
		}
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='A') )
	{
	  		if ($labpoz['x']+$view3dx[$g][2]>$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_1_f.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='E') )
	{
	  		if ($labpoz['x']+$view3dx[$g][2]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_1_w.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][2]][$labpoz['y']+$view3dy[$g][2]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_1_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_1_i.png  width=352 height=240></div>';
		}
	}	
	
if ( ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='') or ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='G') )
	{
			if ( ($Aitems[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='G') )
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_g0.png  width=352 height=240></div>';				
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_g.png  width=352 height=240></div>';
			}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='A') )
	{
		if ($labpoz['y']+$view3dy[$g][23] > $labpoz['y'])
		{
		//�����
		}
		else
		{	
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_f.png  width=352 height=240></div>';
		}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='E') )
	{
		if ($labpoz['y']+$view3dy[$g][23] < $labpoz['y'])
		{
		//�����
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_w.png  width=352 height=240></div>';
		}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_i.png  width=352 height=240></div>';
		}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]=='Z') )
	{
			$door_type=$map[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]];
			if ($Aitems[$labpoz['x']+$view3dx[$g][23]][$labpoz['y']+$view3dy[$g][23]]!=$door_type)
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_door_c.png  width=352 height=240></div>';
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/2_0_door_o.png  width=352 height=240></div>';
			}
	}
	
if ( ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='') or ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='M') 
or ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='�')or ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='C') or ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='D') or ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='X') or ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='Z') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/2_1.png  width=352 height=240></div>';
	}
	else
	if (  ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='G') )
	{
		if (  ($Aitems[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='G') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/2_1_g0.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/2_1_g.png  width=352 height=240></div>';
		}
	}
	else
	if (  ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='A') )
	{
		if ($labpoz['y']+$view3dy[$g][24] > $labpoz['y'])
		{
		//�����
		}
		else
		{	
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/2_1_f.png  width=352 height=240></div>';
		}
	}	
	else
	if (  ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='E') )
	{
		if ($labpoz['y']+$view3dy[$g][24] < $labpoz['y'])
		{
		//�����
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/2_1_w.png  width=352 height=240></div>';
		}
	}	
	else
	if (  ($map[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='�') )
	{
		if (  ($Aitems[$labpoz['x']+$view3dx[$g][24]][$labpoz['y']+$view3dy[$g][24]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/2_1_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/2_1_i.png  width=352 height=240></div>';
		}
	}	

if ( ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='') or ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;z-index:50;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0.png  width=352 height=240></div>';
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='G') OR ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='G') )
	{
	$wl="";
	if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='G')
			{
			//������� ��� �������
			$wl=0;
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_g'.$wl.'.png  width=352 height=240></div>';			
			}
	
	
	$d3_out.='<DIV style="position:absolute;z-index:50;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_g'.$wl.'.png  width=352 height=240></div>';
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='A') )
	{
			if ($labpoz['x']+$view3dx[$g][22]>$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{	
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_f.png  width=352 height=240></div>';
			}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='E') )
	{
		if ($labpoz['x']+$view3dx[$g][22]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_w.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�') )
	{
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�') 
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_ig.png  width=352 height=240></div>';						
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_ig.png  width=352 height=240></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_i.png  width=352 height=240></div>';
			}
	}	

if ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='I')	
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_start.png  width=352 height=240></div>';			
	}
elseif ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='F')	
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/3_0_fin.png  width=352 height=240></div>';				
	}
	
	
//����� 	
if ( ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�') or ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='X') or ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='Z') )
	{
	$door_type=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]];
	if ($door_type=='�') { $door_type='DD'; }
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_'.$door_type.'_c.png  title="�������" alt="�������" width=352 height=240></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:40;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_'.$door_type.'_o.png  width=352 height=240></div>';						
			}
	
	}
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')
	{
		$d3_out.='<DIV style="position:absolute;z-index:40;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_dark.png  width=352 height=240></div>';							
	}
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='J')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
				{
				//��� ���� ����
					$d3_out.='<DIV style="position:absolute;z-index:0;left:'.($left+130).'px;top: '.($top+50).'px;"><IMG src=/i/plab/Left/Front/3_0_j_'.$JMOB_id[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'.png title="'.$JMOB[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'" alt="'.$JMOB[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'" ></div>';			
				}
			}				
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
				{
				//��� ���� ����
					$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+130).'px;top: '.($top+50).'px;"><IMG src=/i/plab/Left/Front/3_0_j_'.$SJMOB_id[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'.png title="'.$SJMOB[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'" alt="'.$SJMOB[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'" ></div>';			
				}
			}			
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='R')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
				{
					$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+130).'px;top: '.($top+50).'px;"><IMG src=/i/plab/Left/Front/3_0_j_'.$RMOB_id[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'.png title="'.$RMOB[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'" alt="'.$RMOB[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]].'" ></div>';			
				}
			}			
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='S')  //������	
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+148).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_3.png" alt="������" title="������"   border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+148).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_3_open.png" alt="�������� ������" title="�������� ������" border=0 ></div>';									
			}
		}	  
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='H')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden;"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/heal_3.png" alt="������� �����" title="������� �����" border=0 ></a></div>';						
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; width: 28px;  height: 28px;"><IMG style="position:relative;left: -1px; top: -1px;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������" width=30px height=30px border=0 ></div>';									
			}
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden;"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/cure_3.png" alt="�������" title="�������" border=0 ></a></div>';						
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; width: 28px;  height: 28px;"><IMG style="position:relative;left: -1px; top: -1px;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������" width=30px height=30px border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='W')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden;"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_on_3.png" alt="�����" title="�����" border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_off_3.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='K')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_on_3.png" alt="�����" title="�����" border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_off_3.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='L')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_on_3.png" alt="�����" title="�����" border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_off_3.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='Y')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_on_3.png" alt="�����" title="�����" border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+160).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_off_3.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='P')  
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!='�')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
				{
				$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+140).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_3.png" alt="���� �������" title="���� �������" border=0 ></div>';						
				}
				else
				{
				$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+140).'px;top:'.($top+130).'px; overflow: hidden;"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_3open.png" alt="�������� ���� �������" title="�������� ���� �������"  border=0 ></div>';									
				}
			}
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='T')  //������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+108).'px;top:'.($top+55).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_t.png  alt="������ X:'.($labpoz['x']+$view3dx[$g][12]).'/Y:'.($labpoz['y']+$view3dy[$g][12]).'" title="������ X:'.($labpoz['x']+$view3dx[$g][12]).'/Y:'.($labpoz['y']+$view3dy[$g][12]).'" width="60%"   border=0></div>';								
		}					
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='2')  //����������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+150).'px;top:'.($top+43).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/3_0_j_280.png  alt="����������" title="����������"   border=0 ></div>';								
		}	
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='5')  //������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+108).'px;top:'.($top+55).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_t.png  alt="������� �� '.$lab_floor_next_str.' ����" title="������� �� '.$lab_floor_next_str.' ����" width="60%"   border=0></div>';								
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+130).'px;top:'.($top+60).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][1].'.png  alt="���������" title="���������"   border=0 width=117 height=80></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+130).'px;top:'.($top+60).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][2].'.png  alt="���������" title="���������"   border=0 width=117 height=80></div>';								
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+130).'px;top:'.($top+60).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][3].'.png  alt="���������" title="���������"   border=0 width=117 height=80></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+130).'px;top:'.($top+60).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][4].'.png  alt="���������" title="���������"   border=0 width=117 height=80></div>';								
		}	
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  //���
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+110).'px;top:'.($top+130).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap2_3.png  alt="���-�������" title="���-�������"   border=0  ></div>';								
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			//��� �����
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(2);
			}
		
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  //��� �����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
				{
				$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+110).'px;top:'.($top+130).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap3_3.png  alt="�������� ���-�������" title="�������� ���-�������"   border=0  ></div>';								
				}
				else
				{
				$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+110).'px;top:'.($top+130).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap3_3_o.png  alt="����� �������" title="����� �������"   border=0  ></div>';								
				}
		}	
	elseif  ($map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]=='�')  //��� ���
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+110).'px;top:'.($top+130).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/trap1_3.png  alt="������� ���-�������" title="������� ���-�������"   border=0  ></div>';								
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]]!=$map[$labpoz['x']+$view3dx[$g][22]][$labpoz['y']+$view3dy[$g][22]])
			{
			//��� �����
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(2);
			}
		}

	
	
////////////////////////x-1 =====1

	
		
if ( ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='') or ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='M') or ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='G') or ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='A') or ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='E')   or ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='�') OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='D')  OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='Z')  )
	{
	 if ( ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='') or ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='M')  or ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G') /*or ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='A') or ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='E')  or ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') */ )
	  {
	  	if ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G')
	  	{
	  	 $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_g.png  width=352 height=240></div>';
	  	}
	  	elseif ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='G') )
	  	{
	  	
	  	}
	  	/*elseif ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='A')
	  	{
	  	 $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_f.png  width=352 height=240></div>';
	  	}
	  	elseif ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='E')
	  	{
	  	 $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_w.png  width=352 height=240></div>';
	  	}
	  	elseif ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')
	  	{
	  	 $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_i.png  width=352 height=240></div>';
	  	}*/
	  	else
	  	{
	  		if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='D')  OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='Z') )
	  		{
	  		//�������� ������ ��� �����
	  		}
	  		else
	  		{
		  	  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1.png  width=352 height=240></div>';
		  	 }
	  	 }
	  }
	  else
	  {
	  	if ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='G')
	  	{
	  		if ($Aitems[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='G')
	  		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_g0.png  width=352 height=240></div>';	  		  		
	  		}
	  		else
	  		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_g.png  width=352 height=240></div>';	  	
			  }
	  	}
	  	elseif ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='A')
	  	{
	  		if ($labpoz['x']+$view3dx[$g][11]>$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{	  	
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_f.png  width=352 height=240></div>';	  	
			  }
	  	}
	  	elseif (($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='E') )
	  	{
	  		if ($labpoz['x']+$view3dx[$g][11]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			 $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_w.png  width=352 height=240></div>';	  	
			 }
	  	}
	  	elseif ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='�')
	  	{
	  		if ($Aitems[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='�')
	  		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_ig.png  width=352 height=240></div>';	  		  		
	  		}
	  		else
	  		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_i.png  width=352 height=240></div>';	  	
			 }
	  	}
	  	elseif ( ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='D')  OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]=='Z') )
	  	{
			$door_type=$map[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]];
			
			if ($Aitems[$labpoz['x']+$view3dx[$g][11]][$labpoz['y']+$view3dy[$g][11]]!=$door_type)
				{
				
				$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_'.$door_type.'_c.png  width=352 height=240></div>';	   	
				}
				else
				{
				
				  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0_'.$door_type.'_o.png  width=352 height=240></div>';	  
				}

	  	
	  	}
	  	else
	  	{
		  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/1_0.png  width=352 height=240></div>';
		}
	  }
	  
	}
if ( ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='M') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='G') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='A') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='E')  or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='�')   /*or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='C') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='D') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='X') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='Z') */ )
	{
	 if ( ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='N') OR 	  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='') or 	   ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='M') or    ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G') or  /*  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='A') or    ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='E') or  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  OR */   ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='C') OR  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='D') OR  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='X') OR   ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='Z') )
	   {
	   	
	   	if ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G')
	   	{	
	   	
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_g.png  width=352 height=240></div>';	   	

	   	}
	   	elseif ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='G') )
	   	{
	   	
	   	}
	   	/*elseif ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='A')
	   	{
		   $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_f.png  width=352 height=240></div>';	   	
	   	}
	   	elseif ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='E')
	   	{
		   $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_w.png  width=352 height=240></div>';	   	
	   	}
	   	elseif ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')
	   	{
		   $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_i.png  width=352 height=240></div>';	   	
	   	}*/
	   	else
	   	{
//		   $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1.png  width=352 height=240></div>';
		}
	   }
	   else
	   {
	   	if ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='G')
	   	{
	   		if ($Aitems[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='G')
	   		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_g0.png  width=352 height=240></div>';	   		   		
	   		}
	   		else
	   		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_g.png  width=352 height=240></div>';	   	
			}
	   	}
		elseif ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='A')
	   	{
			if ($labpoz['y']+$view3dy[$g][1]>$labpoz['y'])
	   		{
	   		//�����
	   		}
	   		else
	   		{	   	
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_f.png  width=352 height=240></div>';	   	
			 }
	   	}	   	
		elseif ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='E')
	   	{
	   		if ($labpoz['y']+$view3dy[$g][1]<$labpoz['y'])
	   		{
	   		//�����
	   		}
	   		else
	   		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_w.png  width=352 height=240></div>';	   	
			 }
	   	
	   	}	   	
	   	elseif ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='�')
	   	{	
		   	if ($Aitems[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='�')
		   	{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_ig.png  width=352 height=240></div>';	   			   	
		   	}
		   	else
		   	{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_i.png  width=352 height=240></div>';	   	
			 }
	   	}
	   	elseif ( ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='C') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='D') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='X') or ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='Z') )
	   	{
	   	$door_type=$map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]];
	   		
	   		if ($Aitems[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]!=$door_type)
	   		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_'.$door_type.'_c.png  width=352 height=240></div>';	   	
	   		}
	   		else
	   		{
			  $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_'.$door_type.'_o.png  width=352 height=240></div>';	   	
	   		}

	   	}
	   	
	   	else
	   	{
		   $d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0.png  width=352 height=240></div>';
		 }
	   }
	   
	}
	elseif (
	   	 ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='C') OR  
	   	 ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='D') OR  	 
	   	 ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='X') OR  	   
	   	 ($map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]=='Z') )
	   	{

	   		$door_type=$map[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]];
			
				if ($Aitems[$labpoz['x']+$view3dx[$g][1]][$labpoz['y']+$view3dy[$g][1]]!=$door_type)
				{
				$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_'.$door_type.'_c.png  width=352 height=240></div>';
				}
				else
				{
				$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/1_0_'.$door_type.'_o.png  width=352 height=240></div>';				
				}	   		
	   	
	   	}


if ( ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='') or ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='M')  )
	{
	
		if  ($room_map=='�')
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_ig.png  width=352 height=240></div>';			
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_ig.png  width=352 height=240></div>';	
			} 
		elseif  ($room_map=='G')
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_g0.png  width=352 height=240></div>';			
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_g0.png  width=352 height=240></div>';	
			}
	
	$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0.png  width=352 height=240></div>';
	}
	elseif  ($room_map=='�') 
	{
			if ($Aitems[$labpoz['x']][$labpoz['y']]==$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left).'px;top:'.($top).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/1_0_ig.png   border=0></DIV>';
			}
	}	
	elseif (( $map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  )
	{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_dark.png  width=352 height=240></div>';

	}
	elseif (( $map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G') OR ( $Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G') )
	{
	$wl="";
	if ( $Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='G')
			{
			//������� ��� �������
			$wl=0;
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_g'.$wl.'.png  width=352 height=240></div>';			
			}
	//������� ��� ������ ��� ������
	$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_g'.$wl.'.png  width=352 height=240></div>';
	}
	elseif ( ($Aitems[$labpoz['x']+$view3dx[$g][54]][$labpoz['y']+$view3dy[$g][54]]=='G') )
	{
	//������ �� ������ ������� :)	
	$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_g0.png  width=352 height=240></div>';
	
	}
	elseif( ( $map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='A'))
	{

	
	if ($labpoz['x']+$view3dx[$g][12]>$labpoz['x'])
	   		{
	   		//�����
	   		}
	   		else
	   		{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_f.png  width=352 height=240></div>';
			}
	}	
	elseif ( ( $map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='E')  )
	{
		if ($labpoz['x']+$view3dx[$g][12]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_w.png  width=352 height=240></div>';
			}
	}	
	elseif ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') 
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�') 
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_ig.png  width=352 height=240></div>';						
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_ig.png  width=352 height=240></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_i.png  width=352 height=240></div>';
			}
	}	


if  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='I') 
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_start.png title="�������" alt="�������" width=352 height=240></div>';			
	}
	else
	if  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='F') 
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/2_0_fin.png  width=352 height=240></div>';			
	}

else
///�����
if  (($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  OR ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='Z')   )
	{
	$door_type=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]];
	if ($door_type=='�') { $door_type='DD'; }				
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{

				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;">'.$link_use_key_a[$door_type].'<IMG src=/i/plab/Left/Front/1_0_'.$door_type.'_c.png title="�������" alt="�������" width=352 height=240>'.$link_use_key_h[$door_type].'</div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_'.$door_type.'_o.png  width=352 height=240></div>';						
			}
	

	}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='J')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
				{
				//��� ���� ����
					$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+$JMOBFIX[$JMOB_id[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]]['left']).'px;top: '.($top+$JMOBFIX[$JMOB_id[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]]['top']).'px;"><a href=?goto=p'.$nap[$_SESSION['looklab']][1].'><IMG src=/i/plab/Left/Front/2_0_j_'.$JMOB_id[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'.png title="'.$JMOB[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'" alt="'.$JMOB[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'" ></a></div>';			
				}
			}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
				{
				//��� ���� ����
					$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+90).'px;top: '.($top+45).'px;"><a href=?goto=p'.$nap[$_SESSION['looklab']][1].'><IMG src=/i/plab/Left/Front/2_0_j_'.$SJMOB_id[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'.png title="'.$SJMOB[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'" alt="'.$SJMOB[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'" </a></div>';			
				}
			}			
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='R')
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
				{
					$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+110).'px;top: '.($top+25).'px;"><a href=?goto=p'.$nap[$_SESSION['looklab']][1].'><IMG src=/i/plab/Left/Front/2_0_j_'.$RMOB_id[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'.png title="'.$RMOB[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'" alt="'.$RMOB[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]].'" </a></div>';			
				}
			}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='S')  //������	
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_2.png" alt="������" title="������"  border=0 ></div>';						
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_2_open.png" alt="�������� ������" title="�������� ������" border=0 ></div>';									
			}
		}					
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='H')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+160).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/heal_2.png" alt="������� �����" title="������� �����"  border=0 ></a></div>';						
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+160).'px;top:'.($top+150).'px; overflow: hidden; width: 38px;  height: 38px;"><IMG style="position:relative;left: -1px; top: -1px;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������" width=40px height=40px border=0 ></div>';									
			}
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+160).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/cure_2.png" alt="�������" title="�������"  border=0 ></a></div>';						
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+160).'px;top:'.($top+150).'px; overflow: hidden; width: 38px;  height: 38px;"><IMG style="position:relative;left: -1px; top: -1px;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������" width=40px height=40px border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='W')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_on_2.png" alt="�����" title="�����" border=0></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_off_2.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='K')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden;"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_on_2.png" alt="�����" title="�����" border=0></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden;"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_off_2.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='L')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_on_2.png" alt="�����" title="�����" border=0></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"   src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_off_2.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='Y')  //�����
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_on_2.png" alt="�����" title="�����" border=0></div>';			
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+130).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"   src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_off_2.png" alt="�������� �����" title="�������� �����" border=0 ></div>';									
			}
		}				
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='P')  //�������
		{
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!='�' ) //�� �������� �������
			{
				if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
				{
				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+100).'px;top:'.($top+130).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_2.png" alt="���� �������" title="���� �������"  border=0 ></div>';						
				}
				else
				{
				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+110).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_2open.png" alt="�������� ���� �������" title="�������� ���� �������" border=0 ></div>';									
				}
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='T')  //������
		{
		$d3_out.='<DIV style="position:absolute;z-index:101;left:'.($left+107).'px;top:'.($top+52).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_t.png  alt="������ X:'.($labpoz['x']+$view3dx[$g][12]).'/Y:'.($labpoz['y']+$view3dy[$g][12]).'" title="������ X:'.($labpoz['x']+$view3dx[$g][12]).'/Y:'.($labpoz['y']+$view3dy[$g][12]).'" width="80%"   border=0></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='2')  //����������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+135).'px;top:'.($top+25).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/2_0_j_280.png  alt="����������" title="����������"   border=0 ></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='5')  //������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+107).'px;top:'.($top+52).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_t.png  alt="������� �� '.$lab_floor_next_str.' ����" title="������� �� '.$lab_floor_next_str.' ����" width="80%"   border=0></div>';								
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+100).'px;top:'.($top+50).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][1].'.png  alt="���������" title="���������"   border=0 width=176 height=120></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+100).'px;top:'.($top+50).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][2].'.png  alt="���������" title="���������"   border=0 width=176 height=120></div>';								
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+100).'px;top:'.($top+50).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][3].'.png  alt="���������" title="���������"   border=0 width=176 height=120></div>';								
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+100).'px;top:'.($top+50).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][4].'.png  alt="���������" title="���������"   border=0 width=176 height=120></div>';								
		}				
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  // ���
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+75).'px;top:'.($top+155).'px; overflow: hidden; "><a href="?yama=1"><IMG src=/i/plab/Left/Front/trap2_2.png  alt="���-�������" title="���-�������"   border=0></a></div>';								
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			//����� � �������
			
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(1);
			}
		
		}
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  // ��� �����
		{
			
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+75).'px;top:'.($top+155).'px; overflow: hidden; "><a href="?fyama=1"><IMG src=/i/plab/Left/Front/trap3_2.png  alt="�������� ���-�������" title="�������� ���-�������"   border=0></a></div>';								
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+75).'px;top:'.($top+155).'px; overflow: hidden; "><a href="?fyama=1"><IMG src=/i/plab/Left/Front/trap3_2_o.png  alt="����� �������" title="����� �������"   border=0></a></div>';											
			}
		}		
	elseif  ($map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]=='�')  // ���  ���
		{
		$d3_out.='<DIV style="position:absolute;z-index:50;left:'.($left+75).'px;top:'.($top+155).'px; overflow: hidden; "><a href="?lyama=1"><IMG src=/i/plab/Left/Front/trap1_2.png  alt="������� ���-�������" title="������� ���-�������"   border=0></a></div>';								
		
			if ($Aitems[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]]!=$map[$labpoz['x']+$view3dx[$g][12]][$labpoz['y']+$view3dy[$g][12]])
			{
			//����� � �������
			
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(1);
			}
				
		}		
		
/////////////////////x  ==========0
if ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='') or ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='G') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='G') )
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_g0.png  width=352 height=240></div>';
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_g.png  width=352 height=240></div>';
			}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='A') )
	{
			if ($labpoz['y']+$view3dy[$g][52]<$labpoz['y'])
	   		{
	   		//�����
	   		}
	   		else
	   		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_f.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='E')  )
	{
		if ($labpoz['y']+$view3dy[$g][52]>$labpoz['y'])
	   		{
	   		//�����
	   		}
	   		else
	   		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_w.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_i.png  width=352 height=240></div>';
		}
	}	
	/*elseif ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='�') OR ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='Z') )
	{

				$door_type=$map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]];
				
				if ($Aitems[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]!=$door_type)
				{
				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_'.$door_type.'_c.png  width=352 height=240></div>';
				}
				else
				{
				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_'.$door_type.'_o.png  width=352 height=240></div>';				
				}
	}*/

	
if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='') or ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='G') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='G') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_g0.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_g.png  width=352 height=240></div>';
		}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='A') )
	{
		if ($labpoz['x']+$view3dx[$g][51]>$labpoz['x'])
			   		{
			   		//�����
			   		}
			   		else		
			   		{
					$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_f.png  width=352 height=240></div>';
					}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='E')  )
	{
		if ($labpoz['x']+$view3dx[$g][51]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_w.png  width=352 height=240></div>';
			}
	}		
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='�') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='�') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_i.png  width=352 height=240></div>';
		}
	}	
	/*else
	if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='D')  OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='Z') )
	{
		$door_type=$map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]];
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]!=$door_type)
			{
			//����
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_'.$door_type.'_c.png  width=352 height=240></div>';
			}
			else
			{
			//����
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_'.$door_type.'_o.png  width=352 height=240></div>';
			}
		
	}*/	
	
if ( ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='') or ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='�') )
	{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_dark.png  width=352 height=240></div>';
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='G') )
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='G') 
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_g0.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_g.png  width=352 height=240></div>';
		}
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='A') )
	{
		if ($labpoz['x']+$view3dx[$g][5]>$labpoz['x'])
	   		{
	   		//�����
	   		}
	   		else
	   		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_f.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='E') )
	{
			if ($labpoz['x']+$view3dx[$g][5]<$labpoz['x']) 
	  		{
				//�����
	  		}
	  		else
	  		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_w.png  width=352 height=240></div>';
			}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='�') )
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='�') 
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_ig.png  width=352 height=240></div>';
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_i.png  width=352 height=240></div>';
		}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]=='Z') )
	{
	// "����� ����� ����� ������� �������� ����";
	 	$door_type=$map[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]];
	 		
	 			if ($Aitems[$labpoz['x']+$view3dx[$g][5]][$labpoz['y']+$view3dy[$g][5]]!=$door_type)
	 			{
	 				$d3_out.='<DIV style="position:absolute;z-index:10;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_'.$door_type.'_c.png  width=352 height=240 ></div>';
	 			}
	 			else
	 			{
	 				$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0_'.$door_type.'_o.png  width=352 height=240></div>';
	 			}
	}
	
	
if ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='N') OR ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='') or ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='M') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='�') )
	{
	$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_dark.png  width=352 height=240></div>';
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='G') )
	{
		if ( ($Aitems[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='G') )
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_g0.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_g.png  width=352 height=240></div>';
		}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='A')  )
	{
			if ( ($labpoz['x']+$view3dx[$g][53]>$labpoz['x']) OR ($labpoz['y']+$view3dy[$g][53]>$labpoz['y']))
	   		{
	   		//�����
	   		}
	   		else
	   		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_f.png  width=352 height=240></div>';
			}
	}	
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='E')  )
	{
			if (($labpoz['y']+$view3dy[$g][53]<$labpoz['y']) or ($labpoz['x']+$view3dx[$g][53]<$labpoz['x']) )
	   		{
	   		//�����
	   		}
	   		else
	   		{
			$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_w.png  width=352 height=240></div>';
			}
	}		
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='�') )
	{
		if ($Aitems[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='�') 
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_ig.png  width=352 height=240></div>';		
		}
		else
		{
		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_i.png  width=352 height=240></div>';
		}
	}	
	elseif ( ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]=='Z') )
	{
	 //����� ����� ������ ������� �������� ����
	 	$door_type=$map[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]];
	 		
	 			if ($Aitems[$labpoz['x']+$view3dx[$g][53]][$labpoz['y']+$view3dy[$g][53]]!=$door_type)
	 			{
	 				$d3_out.='<DIV style="position:absolute;z-index:10;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_'.$door_type.'_c.png  width=352 height=240 ></div>';
	 			}
	 			else
	 			{
	 				$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0_'.$door_type.'_o.png  width=352 height=240></div>';
	 			}
	}
	elseif ( ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='�') OR ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='D') OR ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]=='Z') )
	{
				$door_type=$map[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]];
				if ($Aitems[$labpoz['x']+$view3dx[$g][52]][$labpoz['y']+$view3dy[$g][52]]!=$door_type)
				{
				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_'.$door_type.'_c.png  width=352 height=240></div>';
				}
				else
				{
				$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/Front/1_1_'.$door_type.'_o.png  width=352 height=240></div>';				
				}
	}
	else
	if ( ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='C') OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='D')  OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='X') OR ($map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]=='Z') )
	{
		$door_type=$map[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]];
		
		if ($Aitems[$labpoz['x']+$view3dx[$g][51]][$labpoz['y']+$view3dy[$g][51]]!=$door_type)
			{
			//����
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_'.$door_type.'_c.png  width=352 height=240></div>';
			}
			else
			{
			//����
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_1_'.$door_type.'_o.png  width=352 height=240></div>';
			}
		
	}		
	
	
	
// fix start
 if (($g==0) and ($room_map=='I') )
 	{
 		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/0_0.png  width=352 height=240></div>';
 	}
 	elseif (($g==90) and ($room_map=='I') )
 	{
 		$d3_out.='<DIV style="position:absolute;z-index:101;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_start.png  width=352 height=240></div>';
 	}
 	elseif (($g==180) and ($room_map=='I') )
 	{
 		$d3_out.='<DIV style="position:absolute;z-index:101;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0.png  width=352 height=240></div>';
 	}
// fix exit
 if (($g==0) and ($room_map=='F') )
 	{
 		$d3_out.='<DIV style="position:absolute;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0.png  width=352 height=240></div>';
 	}
 elseif (($g==270) and ($room_map=='F') )
 	{
 		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.$left.'px;top: '.$top.'px;"><a href=?exit_good=true><IMG src=/i/plab/Left/Front/1_0_fin.png  width=352 height=240 border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/1_0_fin_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/1_0_fin.png'\"></a></div>";
 	} 	
 	elseif (($g==90) and ($room_map=='I') )
 	{
 		$d3_out.='<DIV style="position:absolute;z-index:101;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Left/Front/1_0_start.png  width=352 height=240></div>';
 	}
 	elseif (($g==180) and ($room_map=='I') )
 	{
 		$d3_out.='<DIV style="position:absolute;z-index:101;left:'.$left.'px;top: '.$top.'px;"><IMG src=/i/plab/Right/0_0.png  width=352 height=240></div>';
 	}
	
/////////////////////////////////////////////////////////////////////
	if  ($room_map=='�') 
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+34).'px;top:'.($top+196).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/trap2_1.png  alt="���-�������" title="���-�������"   border=0></DIV>';		
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			//����� � ������� -50% �� ������
			
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(0);
			}
		}
	else
		if  ($room_map=='�') 
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+34).'px;top:'.($top+196).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/trap3_1.png  alt="�������� ���-�������" title="�������� ���-�������"   border=0></DIV>';
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+34).'px;top:'.($top+196).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/trap3_1_o.png  alt="����� �������" title="����� �������"   border=0></DIV>';
			}
		}
	else
	if  ($room_map=='�') 
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+34).'px;top:'.($top+196).'px; overflow: hidden; "><IMG style="position:relative;"  <IMG src=/i/plab/Left/Front/trap1_1.png  alt="������� ���-�������" title="������� ���-�������"   border=0></DIV>';
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			//����� � �������
			
			}
			else
			{
			//����������� � ������ ���������
			$d3_out.=print_doski(0);
			}
		}
	else	
	if  ($room_map=='S')  //������	
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><a href="?sunduk=get"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_1.png" alt="������" title="������" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/ach_1_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/ach_1.png'\"></a></div>";
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/ach_1_open.png" alt="�������� ������" title="�������� ������" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/ach_1_open_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/ach_1_open.png'\"></div>";
			}
		}
	elseif  ($room_map=='H')  //�����
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+150).'px;top:'.($top+170).'px; overflow: hidden; "><a href="?hill=1"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/heal_1.png" alt="������� �����" title="������� �����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/heal_1_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/heal_1.png'\"></a></div>";
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+150).'px;top:'.($top+170).'px; overflow: hidden; width: 58px;  height: 58px;"><IMG style="position:relative;left: -1px; top: -1px;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������" border=0 ></div>';									
			}
		}
	elseif  ($room_map=='�')
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+150).'px;top:'.($top+170).'px; overflow: hidden; "><a href="?antidot=get"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/cure_1.png" alt="�������" title="�������" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/cure_1_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/cure_1.png'\"></a></div>";
			}
			else
			{
			//$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+150).'px;top:'.($top+170).'px; overflow: hidden; width: 58px;  height: 58px;"><IMG style="position:relative;left: -1px; top: -1px;"  src="http://i.oldbk.com/llabb/use_heal_off.gif" alt="������ �������" title="������ �������" border=0 ></div>';									
			}
		}		
	elseif  ($room_map=='W')  //�����
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><a href="?keybox=get"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_on.png" alt="�����" title="�����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_on_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_on.png'\"></a></div>";
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_off.png" alt="�������� �����" title="�������� �����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_off_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_w_off.png'\"></div>";
			}
		}		
	elseif  ($room_map=='K')  //�����
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><a href="?keybox=get"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_on.png" alt="�����" title="�����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_on_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_on.png'\"></a></div>";
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_off.png" alt="�������� �����" title="�������� �����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_off_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_k_off.png'\"></div>";
			}
		}		
	elseif  ($room_map=='L')  //�����
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><a href="?keybox=get"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_on.png" alt="�����" title="�����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_on_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_on.png'\"></div>";
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_off.png" alt="�������� �����" title="�������� �����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_off_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_l_off.png'\"></div>";
			}
		}		
	elseif  ($room_map=='Y')  //�����
		{
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><a href="?keybox=get"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_on.png" alt="�����" title="�����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_on_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_on.png'\"></a></div>";
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+120).'px;top:'.($top+150).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_off.png" alt="�������� �����" title="�������� �����" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_off_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/kb_y_off.png'\"></div>";
			}
		}		
	elseif  ($room_map=='P')  //�������
		{
		if  ($Aitems[$labpoz[x]][$labpoz[y]]!='�' ) //�� �������� �������
		   {
			if ($Aitems[$labpoz['x']][$labpoz['y']]!=$room_map)
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+80).'px;top:'.($top+170).'px; overflow: hidden; "><a href="?openbox=1"><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_1.png" alt="������� ���� �������" title="������� ���� �������" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_1_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_1.png'\"></a></div>";
			}
			else
			{
			$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+80).'px;top:'.($top+170).'px; overflow: hidden; "><IMG style="position:relative;"  src="http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_1open.png" alt="�������� ���� �������" title="�������� ���� �������" border=0'." onmouseover=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_1open_hover.png'\" onmouseout=\"this.src='http://capitalcity.oldbk.com/i/plab/Left/Front/pandora_1open.png'\"></div>";
			}
		   }
		}		
	elseif  ($room_map=='T')  //������
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+100).'px;top:'.($top+70).'px; overflow: hidden; "><IMG src=/i/plab/Left/Front/1_0_t.png  alt="������ X:'.$labpoz['x'].'/Y:'.$labpoz['y'].'" title="������ X:'.$labpoz['x'].'/Y:'.$labpoz['y'].'"  border=0></div>';						
		}		
	elseif  ($room_map=='2')  //����������
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+115).'px;top:'.($top+7).'px; overflow: hidden; "><a href=?talk=75><IMG src=/i/plab/Left/Front/1_0_j_280.png  alt="����������" title="����������"   border=0></a></div>';								
		}		
	elseif  ($room_map=='5')  //������
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left+100).'px;top:'.($top+70).'px; overflow: hidden; "><a href=?next_floor=yes><IMG src=/i/plab/Left/Front/1_0_t.png  alt="������� �� '.$lab_floor_next_str.' ����"  title="������� �� '.$lab_floor_next_str.' ����"  border=0></a></div>';						
		}		
	elseif  ($room_map=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left).'px;top:'.($top).'px; overflow: hidden; "><a href=?chukaz=1><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][1].'.png  alt="���������" title="���������"   border=0></a></div>';								
		}
	elseif  ($room_map=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left).'px;top:'.($top).'px; overflow: hidden; "><a href=?chukaz=1><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][2].'.png  alt="���������" title="���������"   border=0></a></div>';								
		}		
	elseif  ($room_map=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left).'px;top:'.($top).'px; overflow: hidden; "><a href=?chukaz=1><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][3].'.png  alt="���������" title="���������"   border=0></a></div>';								
		}
	elseif  ($room_map=='�')  // �������
		{
		$d3_out.='<DIV style="position:absolute;z-index:100;left:'.($left).'px;top:'.($top).'px; overflow: hidden; "><a href=?chukaz=1><IMG src=/i/plab/Left/Front/1_0_'.$ukazka[$g][4].'.png  alt="���������" title="���������"   border=0></a></div>';								
		}		
		
}


//echo $room_map;
//print_r($_POST);
	

if (!(function_exists('load_wep'))) 
{
// ������ ������ + ��������������� ����������
function load_wep($r_wep,$telo)
{
$tout= array();
// ���� ������� ����� . �� �� �����
switch($r_wep['otdel'])
			 	{
			 	case 0:
			 		{
			 	//�����
				$tout[chem]='kulak';
				$tout[mast]=0;
			 		}
				break;
				########

			 	case 1:
			 		{
			 	//���� �������
				$tout[chem]='noj';
				$tout[mast]=$telo[noj];
			 		}
				break;
				########
		 		case 6:
			 		{
			 			// ����� ��� 50
				 		if ($r_wep[type]==50)
				 		{
						$tout[chem]='buket';
						$tout[mast]=0;
				 		} else
				 		{ // ��� ����� ����� ������� ����� ���� ��� ������ �����
				 	//����� ��������
					$tout[chem]='meshok';
					$tout[mast]=0;
						}

			 		}
				break;
				########
		 		case 11:
			 		{
			 	//������
				$tout[chem]='topor';
				$tout[mast]=$telo[topor];
			 		}
				break;
				########
		 		case 12:
			 		{
			 	//������
				$tout[chem]='dubina';
				$tout[mast]=$telo[dubina];

			 		}
				break;
				########
		 		case 13:
			 		{
			 	//����
				$tout[chem]='mec';
				$tout[mast]=$telo[mec];

			 		}
				break;
		 		case 14:
			 		{
			 	//���
				$tout[chem]='luk';
				$tout[mast]=0; // ���

			 		}
				break;


			 	}
return $tout;
}
}

if (!(function_exists('load_mass_items_by_id')))
{
function load_mass_items_by_id($telo)
{

//��������� ������ ��� ����� ����� � �������� � ������ ����� ���� ��������
// ����������� ����� ���� ����� ��� �������� � �����������
//$query_telo_dess = mysql_query("SELECT * FROM oldbk.inventory WHERE dressed = 1 AND `type`!=12 AND owner ={$telo[id]} ");
$query_telo_dess =mysql_query_cache("SELECT * FROM oldbk.inventory WHERE dressed = 1 AND `type`!=12 AND owner ={$telo[id]} ",false,24*3600);
	$telo_magicIds   = array();
	$telo_magicIds[] = 0;
	$telo_wearItems  = array();

////////////////////////////////
	$totsumm=0;
$telo_wearItems[krit_mf]=0;
$telo_wearItems[akrit_mf]=0;
$telo_wearItems[uvor_mf]=0;
$telo_wearItems[auvor_mf]=0;
$telo_wearItems[bron1]=0;
$telo_wearItems[bron2]=0;
$telo_wearItems[bron3]=0;
$telo_wearItems[bron4]=0;
$telo_wearItems[min_u]=0;
$telo_wearItems[max_u]=0;
$telo_wearItems[allsumm]=0;
$telo_wearItems[ups]=0;
$telo_wep[mast]=0;
$telo_wearItems[�hem]='';

//// ��� ����� ����� ��������� ��� ���� ��� ����
/// � ���� ����� ������� ���� ���������� ��� ����������� ������
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//while($row = mysql_fetch_assoc($query_telo_dess)) {
	while(list($k,$row) = each($query_telo_dess)) {	
	    $telo_wearItems[$row['id']] = $row;
	        $totsumm+=$row['cost'];
	$telo_wearItems[krit_mf]+=$row[mfkrit];
	$telo_wearItems[akrit_mf]+=$row[mfakrit];
	$telo_wearItems[uvor_mf]+=$row[mfuvorot];
	$telo_wearItems[auvor_mf]+=$row[mfauvorot];
		$telo_wearItems[bron1]+=$row[bron1];
		$telo_wearItems[bron2]+=$row[bron2];
		$telo_wearItems[bron3]+=$row[bron3];
		$telo_wearItems[bron4]+=$row[bron4];
	$telo_wearItems[min_u]+=$row[minu];
	$telo_wearItems[max_u]+=$row[maxu];
		$telo_wearItems[ups]+=$row[ups];

		if($row['includemagic'] > 0) {
	        $telo_magicIds[] = $row['includemagic'];
		}
		// �� �� �����
		if ($row[id]==$telo[weap])
		 	{
			$telo_wep=load_wep($row,$telo);
		 	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	} // end of while
//////////////////////////////////////////////////////////////////////////////////////////////////////
	$telo_wearItems[allsumm]=$totsumm; // �������� ����� ��������� ����� ������
	//fix ���� ����� � ������ �� ���� ����������
		if (($telo[weap]==0) and (!$telo_wep))
		 	{
		 	$kulak[otdel]=0;
		 	$telo_wep=load_wep($kulak,$telo);
		 	}
//////////////////////////////////////////////////////////////////////////////////////////////////////
	// ������� ���������� ��� - ���� ���� ��� ����
	$telo_wearItems[min_u] = round((floor($telo['sila']/3) + 1) + $telo['level'] + $telo_wearItems[min_u] * (1 + 0.07 * $telo_wep[mast]));
	$telo_wearItems[max_u] = round((floor($telo['sila']/3) + 4) + $telo['level'] + $telo_wearItems[max_u] * (1 + 0.07 * $telo_wep[mast]));
//////////////////////////////////////////////////////////////////////////////////////////////////////
// ��������� ��������� �� ������
 	$telo_wearItems[�hem]=$telo_wep[chem];
 	$telo_wearItems[mast]=$telo_wep[mast];
///  fix �� ������ ������ ��� ������� ������� �� ����� //////////////////////////////////
	if($telo_wearItems[�hem] == 'kulak' && (int)$telo['level'] < 4)
				{
					$telo_wearItems[min_u] += 3;
					$telo_wearItems[max_u] += 6;
				}
////////// ����� � ������� ��������� ���������� + ���� �������	////////////////////////
	if($telo_wearItems[�hem] == 'kulak' && (int)$telo['align'] ==2)
				{
					$telo_wearItems[min_u] += $telo[level];
					$telo_wearItems[max_u] += $telo[level];
				}
///////////////////////////////////////////////////////////////////////////////////
///�������� �������� ��� ����� ���������
//	$query_telo_mag = mysql_query("SELECT * FROM magic WHERE id IN (" . implode(", ", $telo_magicIds) . ")");
//	while($row = mysql_fetch_assoc($query_telo_mag)) {
//	    $telo_magicItems[$row['id']] = $row;
//	}
//////////////////////////////////////////////////////////////////////////////////
	$telo_wearItems[incmagic]=$telo_magicItems;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

return $telo_wearItems;
}
}
		


$IN_ROOM_TRAP_PRINT='';	

							if (($room_map=="R") OR ($room_map=="J") OR ($room_map=="�") )
																{
																$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '{$_SESSION['uid']}' LIMIT 1;"));
																if  (($Aitems_val[$labpoz[x]][$labpoz[y]]>0) and ($user['battle'] == 0))     // ��� ���� ��� ��� ���� ��������� �� �����
																			{
																				$batl_id=$Aitems_val[$labpoz[x]][$labpoz[y]];
																				// ���� ���� ��������� ������ ���
																				$test_bttle=mysql_fetch_array(mysql_query("SELECT `win` from battle where `id`='".$batl_id."' LIMIT 1; "));
																					if (($test_bttle[win]==3) and ($user['battle'] == 0) )
																					{
																					//��� ��� ����
																					///�����������
																							$ttt = 1; //���� �� ������� �������
																							addch (nick_hist($user)." �������� � <a href=logs.php?log=".$batl_id." target=_blank>�������� ��</a>.  ",$user['room']);
																							$user[battle_t]=$ttt;
																							$ac=($user[sex]*100)+mt_rand(1,2);
																							addlog($batl_id,"!:W:".time().":".BNewHist($user).":".$user[battle_t].":".$ac."\n");	
																							$time = time();
																							mysql_query('UPDATE `battle` SET to1='.$time.', to2='.$time.', `t1`=CONCAT(`t1`,\';'.$user['id'].'\'), `t1hist`=CONCAT(`t1hist`,\''.BNewHist($user).'\')  WHERE `id` = '.$batl_id.' ;');
																							mysql_query("UPDATE users SET `battle` =".$batl_id.",`zayavka`=0, `battle_t`=1 WHERE `id`= ".$user['id']);
																							mysql_query("INSERT `battle_vars` (battle,owner,update_time,type)  VALUES ('{$batl_id}','{$user['id']}','{$time}','1') ON DUPLICATE KEY UPDATE `update_time` = '{$time}' ;");
																							die("<script>location.href='fbattle.php';</script>");
																					}
																			}
																else
																      if ( (($Aitems[$labpoz[x]][$labpoz[y]]!='J') and  ($Aitems[$labpoz[x]][$labpoz[y]]!='R') and  ($Aitems[$labpoz[x]][$labpoz[y]]!='�') )  and (!$Aitems_val[$labpoz[x]][$labpoz[y]]>0)  )
																       // ���� ��� �� ������
																			{
																			// ������ ������ ��� ������� ����
																			//$_SESSION[runb]=1;
																			//��� �� �� 0 � ���������� � ���
																			if ($user[hp]==0)
																			{
																			mysql_query("UPDATE `users` SET `hp` = `hp`+2  WHERE `id` = '".$user[id]."' LIMIT 1;");
																			}
																			// ������� ��� � ������� ������
																			//��� ����� � ������ ������� ������� ������
																			
																			/*
																			$dmob=count($mob); // ������ ������� ��������-����
																			$dmob=round(($labpoz[y]*$dmob/(strlen($map[1])))); // �������� ������� ��������� ������������ �� ��������� ����� � ������.
																			$rs=$dmob-2;
																			if ($rs < 0) {  $rs=0; }
																			$rmt=mt_rand($rs,$dmob);*/
																			
																			//get goup mobs
																			/////������� ����������� ���������� ���� ���� �� ���� � ������ � �� ������ ���� ������ �����
																			/*
																			   if   ( ($_SESSION['questdata'][q_bot] > 0) AND  ( $Qmap[$labpoz[x]][$labpoz[y]]>0) )
																				    {
																					    make_qpoint($_SESSION['questdata'],$user,$mapid);// ����� ����� ��� ��������� ��� �������� -����������� ����������� ��� � ��������� ����������
																				    }
																				    */
																			$c=0;
																			$mobrmt=array();
																			if ($room_map=="J")
																				{
																				/// ���� J MOB
																				$J_MOB=array( $JMOB_id[$labpoz[x]][$labpoz[y]] => 1);
																				$mobrmt=$J_MOB;
																				}
																			elseif ($room_map=="�")
																				{
																				$SJ_MOB=array( $SJMOB_id[$labpoz[x]][$labpoz[y]] => 1);
																				$mobrmt=$SJ_MOB;
																				}
																			else
																				{
																				//  ������� ����
																				$R_MOB=array( $RMOB_id[$labpoz[x]][$labpoz[y]] => $RMOB_kol[$labpoz[x]][$labpoz[y]]);
																				$mobrmt=$R_MOB;
																				}

																			//������� �����
																			foreach ($mobrmt as $k=>$v)
																						{
																						for ($l=0;$l<$v;$l++)
																							{
																									$c++;
																									$BOT=mysql_query_cache("SELECT * from `users` where `id`='".$k."' ;",false,24*3600);
																									$BOT = $BOT[0];						
																					
																									$BOT['login'].=" (k�o� ".$c.")";

																									
																									
																									$BOT_items=load_mass_items_by_id($BOT);
																									
																									$userlevel=$user['level'];
																									if ($userlevel<8) $userlevel=8;
																									if ($userlevel>15) $userlevel=15;

																										//��� ������� ����� , ������ �� ����
																										
																										
																										$BOT['level']=$bot_setup[$userlevel][$BOT['id']]['level'];
																										$BOT['maxhp']=$bot_setup[$userlevel][$BOT['id']]['maxhp'];
																										
																										$BNAME_chat=nick_hist($BOT);
																										$BNAME=BNewHist($BOT);																										
																																																				
																										$BOT_items['min_u']=$bot_setup[$userlevel][$BOT['id']]['sum_minu'];
																										$BOT_items['max_u']=$bot_setup[$userlevel][$BOT['id']]['sum_maxu'];
																										$BOT_items['krit_mf']=$bot_setup[$userlevel][$BOT['id']]['sum_mfkrit'];
																										$BOT_items['akrit_mf']=$bot_setup[$userlevel][$BOT['id']]['sum_mfakrit'];
																										$BOT_items['uvor_mf']=$bot_setup[$userlevel][$BOT['id']]['sum_mfuvorot'];
																										$BOT_items['auvor_mf']=$bot_setup[$userlevel][$BOT['id']]['sum_mfauvorot'];
																										$BOT_items['bron1']=$bot_setup[$userlevel][$BOT['id']]['sum_bron1'];
																										$BOT_items['bron2']=$bot_setup[$userlevel][$BOT['id']]['sum_bron2'];
																										$BOT_items['bron3']=$bot_setup[$userlevel][$BOT['id']]['sum_bron3'];
																										$BOT_items['bron4']=$bot_setup[$userlevel][$BOT['id']]['sum_bron4'];
																										$BOT_items['allsumm']=$bot_setup[$userlevel][$BOT['id']]['at_cost'];
																										$BOT_items['ups']=11;
																									
																										mysql_query("INSERT INTO `users_clons` SET `login`='".$BOT['login']."',`sex`='{$BOT['sex']}',
																										`level`='{$BOT['level']}',`align`='{$BOT['align']}',`klan`='{$BOT['klan']}',`sila`='{$BOT['sila']}',
																										`lovk`='{$BOT['lovk']}',`inta`='{$BOT['inta']}',`vinos`='{$BOT['vinos']}',
																										`intel`='{$BOT['intel']}',`mudra`='{$BOT['mudra']}',`duh`='{$BOT['duh']}',`bojes`='{$BOT['bojes']}',`noj`='{$BOT['noj']}',
																										`mec`='{$BOT['mec']}',`topor`='{$BOT['topor']}',`dubina`='{$BOT['dubina']}',`maxhp`='{$BOT['maxhp']}',`hp`='{$BOT['maxhp']}',
																										`maxmana`='{$BOT['maxmana']}',`mana`='{$BOT['mana']}',`sergi`='{$BOT['sergi']}',`kulon`='{$BOT['kulon']}',`perchi`='{$BOT['perchi']}',
																										`weap`='{$BOT['weap']}',`bron`='{$BOT['bron']}',`r1`='{$BOT['r1']}',`r2`='{$BOT['r2']}',`r3`='{$BOT['r3']}',`helm`='{$BOT['helm']}',
																										`shit`='{$BOT['shit']}',`boots`='{$BOT['boots']}',`nakidka`='{$BOT['nakidka']}',`rubashka`='{$BOT['rubashka']}',`shadow`='{$BOT['shadow']}',`battle`=1,`bot`=1,
																										`id_user`='{$BOT['id']}',`at_cost`='{$BOT_items['allsumm']}',`kulak1`=0,`sum_minu`='{$BOT_items['min_u']}',
																										`sum_maxu`='{$BOT_items['max_u']}',`sum_mfkrit`='{$BOT_items['krit_mf']}',`sum_mfakrit`='{$BOT_items['akrit_mf']}',
																										`sum_mfuvorot`='{$BOT_items['uvor_mf']}',`sum_mfauvorot`='{$BOT_items['auvor_mf']}',`sum_bron1`='{$BOT_items['bron1']}',
																										`sum_bron2`='{$BOT_items['bron2']}',`sum_bron3`='{$BOT_items['bron3']}',`sum_bron4`='{$BOT_items['bron4']}',`ups`='{$BOT_items['ups']}',
																										`injury_possible`=0, `battle_t`=2;");
																					
																									$id_bot[$c]=mysql_insert_id();
																										if ($bot_team!='') 
																										{
																												$bots_names.=$BNAME;
																												$bots_names_chat.=", ".$BNAME_chat;
																												$bot_team.=";".$id_bot[$c];
																												$bot_team_sql.=",".$id_bot[$c];
																										}
																										else
																											{
																												$bots_names=$BNAME;
																												$bots_names_chat=$BNAME_chat;							
																												$bot_team=$id_bot[$c];
																												$bot_team_sql=$id_bot[$c];
																											}
																							}
																						$allch[$k]=$mdrop[$k]; // ���������� ��� ����� �� ������ �� �����
																						}
																			
																				//fix bag ������ ���� ��� �� ����������� win=0
																				mysql_query("INSERT INTO `battle` (`id`,`coment`,`teams`,`timeout`,`type`,`status`,`t1`,`t2`,`to1`,`to2`,`win`,`t1hist`,`t2hist`)
																									VALUES
																									(NULL,'��� � ��������� �����','','10','30','0','".$user[id].";','".$bot_team."','".time()."','".time()."',0,'".BNewHist($user)."','{$bots_names}')");
																																				
																				$id_battl=mysql_insert_id();
																			
																						//������� ������ � ��� ��� ��� � ��������� �������
																						
																						mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`) values('".$mapid."','".$room_map."','".$labpoz[x]."','".$labpoz[y]."','1','".$id_battl."' ) ON DUPLICATE KEY UPDATE `active` =1;");
																						mysql_query("UPDATE `users_clons` SET `battle` = {$id_battl} WHERE `id` in (".$bot_team_sql.") ");
																			
																						// ������� ���
																								$rr = "<b>".nick_hist($user)."</b> � <b>".$bots_names_chat."</b>";
																								addlog($id_battl,"!:S:".time().":".BNewHist($user).":".$bots_names."\n");
																								mysql_query("UPDATE users SET `battle` ={$id_battl},`zayavka`=0, `battle_t`=1 WHERE `id`= '".$user[id]."';");

																			// ������ ����� ����� ������
																			$cs=0;
																			
																			if ($c==1) {$maxkoldrop=1;}
																			
																			//$qeff = mysql_query('SELECT * FROM effects WHERE type = 813 AND owner = '.$_SESSION['uid']);
																			$qeff=mysql_query_cache('SELECT * FROM effects WHERE type = 813 AND owner = '.$_SESSION['uid'],false,60);
																			
																			//if (mysql_num_rows($qeff) > 0) {
																			if (count($qeff) > 0) {
																				$maxkoldrop = $maxkoldrop * 2;
																				$dooble=true;
																			}
																			$ar_shans=array();
																			foreach ($allch as $BOT=>$ARRAY)
																				{
																				foreach ($ARRAY as $iditema=>$shans)
																					{
																					if ($dooble) {$shans=$shans*2;}
																					for ($ss=0;$ss<$shans;$ss++)
																						{
																						$cs++;
																						$ar_shans[$cs]=$iditema;
																						}
																			
																					}
																				}
																			
																			if (count($ar_shans)>0) 
																				{
																				shuffle($ar_shans);//������
																				}
																			$prev=0;
																			
																			for ($ss=0;$ss<$maxkoldrop;$ss++)
																			{
																			$rnd=rand(0,count($ar_shans));
																			if($ar_shans[$rnd]>0)
																			   	{
																			   	if ($prev==$ar_shans[$rnd]) {$ss--;}
																					else
																					{
																			   		mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`,`val`) values('".$mapid."','I','".$labpoz[x]."','".$labpoz[y]."','0','-1','".$ar_shans[$rnd]."' ) ON DUPLICATE KEY UPDATE `active` =1, `val`='".$ar_shans[$rnd]."' ;");
																			   		$prev=$ar_shans[$rnd];
																			   		}
																			   	}
																			}
																			//////////////////////
																						//fix bag ����� ��� ������ win=3 � ��������� ���
																			
																						mysql_query("UPDATE `battle` set win=3 where id={$id_battl};");
																								header("Location: fbattle.php");
																								die("<script>location.href='fbattle.php';</script>");
																		
																			
																		}
																			else
																			{
																			mysql_query("UPDATE `labirint_items` SET `count`=0  WHERE `map`='".$mapid."' and `item`='I' and `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `count`=-1 ;");
																			// ��� ���� ���� ��� ������ ���� �������� ���� ���������� �����
																			$dropitems=mysql_query("SELECT * FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `count` >=0 and `active`=0 and  (`owner`=0 OR `owner`='{$user[id]}')  and `item`='I' ; ");
																			   	while ($row = mysql_fetch_array($dropitems))
																					{
																					
																					$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` where `id`='".$row[val]."'  LIMIT 1;    "));
																					//$IN_ROOM_PRINT.=" <a href=?getitem={$row[val]}><IMG SRC=\"http://i.oldbk.com/i/sh/{$itis['img']}\" BORDER=0 alt='{$itis[name]}' title='{$itis[name]}'></a> ";
																					$itis['no']=1;
																					$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?getitem={$itis['id']}'",0,bg_item_fix($itis['id']));						
																					$LAST_ITEM_TO_GET=$itis['id'];
																					}
															
																			}
															
					}
		else
		if (($room_map=="P") OR ($room_map=="�") )
			{
			if (($Aitems[$labpoz[x]][$labpoz[y]]=="P") OR ($Aitems[$labpoz[x]][$labpoz[y]]=="�") )
				{

				//$IN_ROOM_PRINT.=" <img src=http://i.oldbk.com/llabb/panbox_off.gif alt='�������� ����' title='�������� ����'> ";

				   //��������� 			$Aitems_count;
				  // if ($Aitems_count[$labpoz[x]][$labpoz[y]]>0)
				   if (true)	
				   	{
				   	//���� ���������� �����
					$dropitems=mysql_query("SELECT * FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `count` >=0 and `active`=0 and `item`='I' ; ");
				   	while ($row = mysql_fetch_array($dropitems))
						{
						$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` where `id`='".$row[val]."'  LIMIT 1;    "));
						//$IN_ROOM_PRINT.= " <a href=?getitem={$row[val]}><IMG SRC=\"http://i.oldbk.com/i/sh/{$itis['img']}\" BORDER=0 alt='{$itis[name]}' title='{$itis[name]}'></a> ";
						$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?getitem={$itis['id']}'",0,bg_item_fix($itis['id']));						
						$LAST_ITEM_TO_GET=$itis['id'];
						}
				   	}
				   	

				}
				else
				{
				//$IN_ROOM_PRINT.=" <a href=?openbox=1><img src=http://i.oldbk.com/llabb/panbox_on.gif alt='������� ���� �������' title='������� ���� �������' ></a> ";
				}
			// "<br>";
				}
		else
		if (($room_map=="B"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="B")
				{
				/// "<br>������� ����������...";
				}
				elseif ($SUMRAK==0)
				{
				//�������
				// ��� �������� ����� ������� ��������� � ��

				$dlov=count($lov); // ������ �������
				$dlov=round(($labpoz[y]*$dlov/(strlen($map[1])))); // �������� ������� ��������� ������������ �� ��������� ����� � ������.
				$rs=$dlov-2;
				if ($rs < 0) {  $rs=0; }
				$rmt=rand($rs,$dlov);
				foreach ($lov[$rmt] as $trap_name=>$v)
					{
				mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`) values('".$mapid."','B','".$labpoz[x]."','".$labpoz[y]."','1' ) ON DUPLICATE KEY UPDATE `active` =1;");

				//�������� � ���
				if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
				if ($trap_name=='timer_trap') { $_SESSION['time_trap']=1; $kom_trap='<i>����� �������� +6 ������� (������������:+'.$v.'���.)</i> '; }
				else if ($trap_name=='poison_trap') 
									{
									// add poison flag
									mysql_query("UPDATE users set `podarokAD`=1 where id='{$user[id]}';");
									$kom_trap='<i>������� ����� -20HP � ������ (������������:+'.$v.'���.)</i>';
									}
				else if ($trap_name=='stat_trap') 
								{
									//
									$i_have_st=mysql_fetch_array(mysql_query("SELECT * FROM `labirint_var` WHERE  var='stat_trap'  and  `owner`='".$user[id]."' ;"));
									if ($i_have_st[owner]==$user[id])
									{
									// ��� ���� ����� ������ �����
									// "Tcnm";
									}
									else
									{
									//���� ������
									mysql_query("UPDATE users set sila=sila-1, lovk=lovk-1, inta=inta-1  where id='{$user[id]}';");
									}
									$kom_trap='<i>��������� �������������� (������������:+'.$v.'���.)</i>';
								}
				else {$kom_trap='';}

				//var global B count
				mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', '".$trap_name."', '".(time()+($v*60))."' ) ON DUPLICATE KEY UPDATE `val` =`val`+".($v*60).";");

				addch("<img src=i/magic/event_".$trap_name.".gif> {$user[login]} ".$sexi." � �������...".$kom_trap);
				$IN_ROOM_TRAP_PRINT.="<img src=i/magic/event_".$trap_name.".gif> {$user[login]} ".$sexi." � �������...".$kom_trap;

					}
				}
				elseif ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
			}
		else
		if (($room_map=="�"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="�")
				{
				///  ������� ���������
				}
				elseif ($SUMRAK==0)
				{
				//�������

				$rndyama=mt_rand(20,40); //20-40% �� ���� ��
				$rndyama=round($user['maxhp']*($rndyama*0.01));
				
				$deadm='';	
				$trmsg=false;			
				
				if ($user['hp']-$rndyama<=0)
					{
						//  ������ � �������
						//�������� � ���
						if ($user[sex]==1) { $sexid='�����'; } else { $sexid='�������'; }

						mysql_query("UPDATE users set `hp`=0 where id='{$user[id]}';");
						if (mysql_affected_rows()>0) 
							{
					                mysql_query("UPDATE `labirint_users` SET `x`=0 , `y`=0, `dead`=`dead`+1  WHERE owner='{$user['id']}' ;");
							$deadm=' � '.$sexid.'!';	
							$user['hp']=0;							
							$trmsg=true;		
							$labpoz[x]=0;
							$labpoz[y]=0;		                
					                }
					}
					else
					{
						mysql_query("UPDATE users set `hp`=`hp`-'{$rndyama}'  where id='{$user[id]}';");
						$user['hp']-=$rndyama;
						if (mysql_affected_rows()>0) 
							{
							$trmsg=true;							
							}
					}
				
				if  ($trmsg==true)
					{
					//�������� � ���
					if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
					addch("<font color=red>��������!</font> {$user[login]} ".$sexi." � ���, ������� ����� -".$rndyama." HP".$deadm,$user['room'],$user['id_city']);
					$IN_ROOM_TRAP_PRINT.="�� ������� � ���, ������� ����� -".$rndyama." HP".$deadm;
					}
				}
				elseif ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
			}				
		else
		if (($room_map=="�"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="�")
				{
				///  ������� ���������
				}
				elseif ($SUMRAK==0)
				{
				//�������
				$rndyama=mt_rand(30,40);
				$rndyama=round($user['maxhp']*($rndyama*0.01));				
				
				
				$deadm='';	
				$trmsg=false;			
				
				if ($user['hp']-$rndyama<=0)
					{
						//  ������ � �������
						//�������� � ���
						if ($user[sex]==1) { $sexid='�����'; } else { $sexid='�������'; }

						mysql_query("UPDATE users set `hp`=0 where id='{$user[id]}';");
						if (mysql_affected_rows()>0) 
							{
					                mysql_query("UPDATE `labirint_users` SET `x`=0 , `y`=0, `dead`=`dead`+1  WHERE owner='{$user['id']}' ;");
							$deadm=' � '.$sexid.'!';	
							$user['hp']=0;							
							$trmsg=true;		
							$labpoz[x]=0;
							$labpoz[y]=0;		                
					                }
					}
					else
					{
						mysql_query("UPDATE users set `hp`=`hp`-'{$rndyama}'  where id='{$user[id]}';");
						$user['hp']-=$rndyama;
						if (mysql_affected_rows()>0) 
							{
							$trmsg=true;	
							//+ ������ �����
							$v=mt_rand(5,10); // 5-10 �����
							mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'poison_trap', '".(time()+($v*60))."' ) ON DUPLICATE KEY UPDATE `val` =`val`+".($v*60).";");
							// add poison flag
							mysql_query("UPDATE users set `podarokAD`=1 where id='{$user[id]}';");
							$deadm=' � ������� ����� <i>������� ����� -20HP � ������ (������������:+'.$v.'���.)</i>';
							}
					}
				
				if  ($trmsg==true)
					{
					//�������� � ���
					if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
					addch("<font color=red>��������!</font> {$user[login]} ".$sexi." � �������� ���, ������� ����� -".$rndyama." HP".$deadm,$user['room'],$user['id_city']);
					$IN_ROOM_TRAP_PRINT.="�� ������� � �������� ���, ������� ����� -".$rndyama." HP".$deadm;
					}
				}
				elseif ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
			}
		else
		if (($room_map=="�"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="�")
				{
				///  ������� ���������
				}
				elseif ($SUMRAK==0)
				{
				//�������
				$rndyama=mt_rand(20,50);
				$rndyama=round($user['maxhp']*($rndyama*0.01));				
								
				$deadm='';	
				$trmsg=false;			
				
				if ($user['hp']-$rndyama<=0)
					{
						//  ������ � �������
						//�������� � ���
						if ($user[sex]==1) { $sexid='�����'; } else { $sexid='�������'; }

						mysql_query("UPDATE users set `hp`=0 where id='{$user[id]}';");
						if (mysql_affected_rows()>0) 
							{
					                mysql_query("UPDATE `labirint_users` SET `x`=0 , `y`=0, `dead`=`dead`+1  WHERE owner='{$user['id']}' ;");
							$deadm=' � '.$sexid.'!';	
							$user['hp']=0;		
							$labpoz[x]=0;
							$labpoz[y]=0;					
							$trmsg=true;				                
					                }
					}
					else
					{
						mysql_query("UPDATE users set `hp`=`hp`-'{$rndyama}'  where id='{$user[id]}';");
						$user['hp']-=$rndyama;
						if (mysql_affected_rows()>0) 
							{
							$trmsg=true;	
							//+ ������ �����
							$v=mt_rand(5,10); // 5-10 �����
							mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$user[id]."', 'timer_trap', '".(time()+($v*60))."' ) ON DUPLICATE KEY UPDATE `val` =`val`+".($v*60).";");
							// add poison flag
							$_SESSION['time_trap']=1; 
							$deadm=' � ������� ����������� <i>����� �������� +6 ������� (������������:+'.$v.'���.)</i>';
							}
					}
				
				if  ($trmsg==true)
					{
					//�������� � ���
					if ($user[sex]==1) { $sexi='������'; } else { $sexi='�������'; }
					addch("<font color=red>��������!</font> {$user[login]} ".$sexi." � ������� ���, ������� ����� -".$rndyama." HP".$deadm,$user['room'],$user['id_city']);
					$IN_ROOM_TRAP_PRINT.="�� ������� � ������� ���, ������� ����� -".$rndyama." HP".$deadm;
					}
				}
				elseif ($SUMRAK>0) {$SUMRAK=$SUMRAK-1;}
			}				
		else
		if (($room_map=="S"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="S")
			{
			//$IN_ROOM_PRINT.=" <img src='http://i.oldbk.com/llabb/use_sunduk_off.gif' alt='�������� ������' title='�������� ������' border=0> ";
			}
			else {
			//$IN_ROOM_PRINT.= " <a href=?sunduk=get><img src='http://i.oldbk.com/llabb/use_sunduk_on.gif' alt='������' title='������' border=0></a> ";
				}
			// "<br>";
				}
		else
/////////////////////////////////////////
///////////////////////////////
		if (($room_map=="Y"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="Y")
			{
			//$IN_ROOM_PRINT.= " <img src='http://i.oldbk.com/llabb/kb_y_off.gif' alt='�������� �����' title='�������� �����' border=0> ";

			//////���������  $Aitems_count;
				   if ($Aitems_count[$labpoz[x]][$labpoz[y]]>0)
				   	{
				   	//���� ���������� �����
					$dropitems=mysql_query("SELECT * FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `count` >=0 and `active`=0 and `item`='I' ; ");
				   	while ($row = mysql_fetch_array($dropitems))
						{
						
						$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` where `id`='".$row[val]."'  LIMIT 1;    "));
//						$IN_ROOM_PRINT.= " <a href=?getitem={$row[val]}><IMG SRC=\"http://i.oldbk.com/i/sh/{$itis['img']}\" BORDER=0 alt='{$itis[name]}' title='{$itis[name]}'></a> ";
						$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?getitem={$itis['id']}'",0,bg_item_fix($itis['id']));						
						$LAST_ITEM_TO_GET=$itis['id'];						
						}
				   	}
			//////////////////////////////////////////////////////////////////////////

			}
			else {
			//$IN_ROOM_PRINT.= " <a href=?keybox=get><img src='http://i.oldbk.com/llabb/kb_y_on.gif' alt='�����' title='�����' border=0></a> ";
				}
			// "<br>";
				}
		else
		if (($room_map=="L"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="L")
			{
			//$IN_ROOM_PRINT.= " <img src='http://i.oldbk.com/llabb/kb_l_off.gif' alt='�������� �����' title='�������� �����' border=0> ";

			//////���������  $Aitems_count;
				   if ($Aitems_count[$labpoz[x]][$labpoz[y]]>0)
				   	{
				   	//���� ���������� �����
					$dropitems=mysql_query("SELECT * FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `count` >=0 and `active`=0 and `item`='I' ; ");
				   	while ($row = mysql_fetch_array($dropitems))
						{

						$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` where `id`='".$row[val]."'  LIMIT 1;    "));
//						$IN_ROOM_PRINT.= " <a href=?getitem={$row[val]}><IMG SRC=\"http://i.oldbk.com/i/sh/{$itis['img']}\" BORDER=0 alt='{$itis[name]}' title='{$itis[name]}'></a> ";
						$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?getitem={$itis['id']}'",0,bg_item_fix($itis['id']));												
						$LAST_ITEM_TO_GET=$itis['id'];
						}
				   	}
			//////////////////////////////////////////////////////////////////////////


			}
			else {
			//$IN_ROOM_PRINT.= " <a href=?keybox=get><img src='http://i.oldbk.com/llabb/kb_l_on.gif' alt='�����' title='�����' border=0></a> ";
				}
			// "<br>";
				}
		else
		if (($room_map=="W"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="W")
			{
			//$IN_ROOM_PRINT.=" <img src='http://i.oldbk.com/llabb/kb_w_off.gif' alt='�������� �����' title='�������� �����' border=0> ";
			//////���������  $Aitems_count;
				   if ($Aitems_count[$labpoz[x]][$labpoz[y]]>0)
				   	{
				   	//���� ���������� �����
					$dropitems=mysql_query("SELECT * FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `count` >=0 and `active`=0 and `item`='I' ; ");
				   	while ($row = mysql_fetch_array($dropitems))
						{
						
						$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` where `id`='".$row[val]."'  LIMIT 1;    "));
//						$IN_ROOM_PRINT.= " <a href=?getitem={$row[val]}><IMG SRC=\"http://i.oldbk.com/i/sh/{$itis['img']}\" BORDER=0 alt='{$itis[name]}' title='{$itis[name]}'></a> ";
						$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?getitem={$itis['id']}'",0,bg_item_fix($itis['id']));																		
						$LAST_ITEM_TO_GET=$itis['id'];						
						}
				   	}
			//////////////////////////////////////////////////////////////////////////


			}
			else {
			//$IN_ROOM_PRINT.= " <a href=?keybox=get><img src='http://i.oldbk.com/llabb/kb_w_on.gif' alt='�����' title='�����' border=0></a> ";
				}
			// "<br>";
				}
		else
		if (($room_map=="K"))
			{
			if ($Aitems[$labpoz[x]][$labpoz[y]]=="K")
			{
			//$IN_ROOM_PRINT.= " <img src='http://i.oldbk.com/llabb/kb_k_off.gif' alt='�������� �����' title='�������� �����' border=0> ";

			//////���������  $Aitems_count;
				   if ($Aitems_count[$labpoz[x]][$labpoz[y]]>0)
				   	{
				   	//���� ���������� �����
					$dropitems=mysql_query("SELECT * FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and `count` >=0 and `active`=0 and `item`='I' ; ");
				   	while ($row = mysql_fetch_array($dropitems))
						{

						$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` where `id`='".$row[val]."'  LIMIT 1;    "));
						//$IN_ROOM_PRINT.= " <a href=?getitem={$row[val]}><IMG SRC=\"http://i.oldbk.com/i/sh/{$itis['img']}\" BORDER=0 alt='{$itis[name]}' title='{$itis[name]}'></a> ";
						$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?getitem={$itis['id']}'",0,bg_item_fix($itis['id']));
						$LAST_ITEM_TO_GET=$itis['id'];						
						}
				   	}
			//////////////////////////////////////////////////////////////////////////

			}
			else {
			//$IN_ROOM_PRINT.= " <a href=?keybox=get><img src='http://i.oldbk.com/llabb/kb_k_on.gif' alt='�����' title='�����' border=0></a> ";
				}
			// "<br>";
				}
		else
///////////////////////////////////
		if (($room_map=="Q"))
			{
			   if ($Aitems_count[$labpoz[x]][$labpoz[y]]>0)
				   	{
				   	//���� ���������� �����
					$dropitems=mysql_query("SELECT * FROM `labirint_items` where `x`='".$labpoz[x]."' and `y`='".$labpoz[y]."' and `map`='".$mapid."' and (`owner`=0 OR `owner`='{$user[id]}') and `count` >=0 and `active`=0 and `item`='I' ; ");
				   	while ($row = mysql_fetch_array($dropitems))
						{
			
						$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`eshop` where `id`='".$row[val]."'  LIMIT 1;    "));
//						$IN_ROOM_PRINT.= " <a href=?getitem={$row[val]}><IMG SRC=\"http://i.oldbk.com/i/sh/{$itis['img']}\" BORDER=0 alt='{$itis[name]}' title='{$itis[name]}'></a> ";
						$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?getitem={$itis['id']}'",0,bg_item_fix($itis['id']));												
						$LAST_ITEM_TO_GET=$itis['id'];						
						}
				   	}
			}
		else
		if (($room_map=="H"))
			{
				if ($Aitems[$labpoz[x]][$labpoz[y]]=="H")
				{
				//$IN_ROOM_PRINT.= " <img src=http://i.oldbk.com/llabb/use_heal_off.gif alt='������ �������' title='������ �������' border=0> ";
				}
				else
				{
					$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`shop` where `id`='4311'  LIMIT 1;    "));
					//$IN_ROOM_PRINT.= "<a href=?hill=1><img src=http://i.oldbk.com/i/sh/heal1.gif alt='������� �����' title='������� �����' border=0></a>";					
					$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?hill={$itis['id']}'",0,bg_item_fix($itis['id']));												

				}
			// "<br>";
				}
		else
		if (($room_map=="�"))
			{
				if ($Aitems[$labpoz[x]][$labpoz[y]]=="�")
				{
				//$IN_ROOM_PRINT.= " <img src=http://i.oldbk.com/llabb/use_heal_off.gif alt='������ �������' title='������ �������' border=0> ";
				}
				else
				{
					$itis=mysql_fetch_array(mysql_query("SELECT * FROM oldbk.`shop` where `id`='4312'  LIMIT 1;    "));
					$IN_ROOM_PRINT.=showitem2($itis,1, 1, 0, false,"location.href='?antidot={$itis['id']}'",0,bg_item_fix($itis['id']));												

				}
			// "<br>";
				}				
		else
		if (($room_map=="T"))
			{
			$IN_ROOM_PRINT.= ' <img src=http://i.oldbk.com/llabb/port.gif alt="������ X:'.$labpoz[x].'/Y:'.$labpoz[y].'" title="������ X:'.$labpoz[x].'/Y:'.$labpoz[y].'" border=0 style=\'background-image:url(http://i.oldbk.com/i/blink.gif);\' > ';
			// "<br>";
				}
		else
		if (($room_map=="�"))
			{
			$IN_ROOM_PRINT.= ' <a href=?chukaz=1><img src=http://i.oldbk.com/llabb/ukaz_1.gif alt="��������� ���������" title="��������� ���������" border=0 style=\'background-image:url(http://i.oldbk.com/i/blink.gif); cursor: pointer\' ></a> ';
			// "<br>";
				}
		else
		if (($room_map=="�"))
			{
			$IN_ROOM_PRINT.= ' <a href=?chukaz=1><img src=http://i.oldbk.com/llabb/ukaz_2.gif alt="��������� ���������" title="��������� ���������" border=0 style=\'background-image:url(http://i.oldbk.com/i/blink.gif); cursor: pointer\' ></a> ';
			// "<br>";
				}
		else
		if (($room_map=="�"))
			{
			$IN_ROOM_PRINT.= ' <a href=?chukaz=1><img src=http://i.oldbk.com/llabb/ukaz_3.gif alt="��������� ���������" title="��������� ���������" border=0 style=\'background-image:url(http://i.oldbk.com/i/blink.gif); cursor: pointer\' ></a> ';
			// "<br>";
				}
		else
		if (($room_map=="�"))
			{
			$IN_ROOM_PRINT.= ' <a href=?chukaz=1><img src=http://i.oldbk.com/llabb/ukaz_4.gif alt="��������� ���������" title="��������� ���������" border=0 style=\'background-image:url(http://i.oldbk.com/i/blink.gif); cursor: pointer\' ></a> ';
			// "<br>";
				}
		else
		if (($room_map=="F"))
			{
			// "<br>�����������, �� ����� �����...<br>";
			//$IN_ROOM_PRINT.= " <form method=POST><input type=submit name=exit_good value='��� �����!'></form> ";
			// "<br>";
				}
		if (($room_map=="2"))
			{
			$IN_ROOM_PRINT.= "  <INPUT TYPE=button onclick=\"location.href='?talk=75';\" value=\"���������� c� ������������\" name=\"talk\" style=\"background-color:#A9AFC0\"> ";
			// "<br>";
			}
		
$IN_ROOM_SUMR_PRINT='';		
	//������
		
		if ( ($SUMRAK_info['add_info']!=$SUMRAK) and $SUMRAK_info['add_info']>0)
			{
			//����������
					
					if ($SUMRAK==0)
						{
						//�������
						mysql_query("DELETE FROM `effects` WHERE `id`='{$SUMRAK_info['id']}'  limit 1; ");
						}
						else
						{
						//���������
						$mtype=$SUMRAK_info['img']."::".$SUMRAK;
						mysql_query("UPDATE `effects` SET  add_info='{$mtype}'  WHERE `id`='{$SUMRAK_info['id']}' ");
						}
			
			}
			
		if ($SUMRAK>0)
			{
			$IN_ROOM_SUMR_PRINT="<small><img src=http://i.oldbk.com/i/sh/".$SUMRAK_info['img']." alt='{$SUMRAK_info['name']}' title='{$SUMRAK_info['name']}'>-<i>����� ����� ������ �����: <b>".$SUMRAK."</b> ���(�)</i></small><br>\n";
			}		
		
//////////////////////////////////			//////////////////////////////////			//////////////////////////////////			//////////////////////////////////			//////////////////////////////////			//////////////////////////////////			
echo '<TABLE border=0 width=100% cellspacing="10" cellpadding="0">';		
echo "<tr><td valign=top align=left width=250>";
ob_start();
showpersinv($user);
$persout=ob_get_contents();
ob_clean ();
ob_end_clean();
$persout=str_replace('<a href="?', '<a href="main.php?', $persout);
$persout=str_replace('<img src="http://i.oldbk.com/i/shadow/','<a href="main.php?edit=1"><img src="http://i.oldbk.com/i/shadow/',$persout);
$persout=str_replace(' alt="'.$user['login'].'">',' alt="������� � ���������" onMouseOut="HideThing(this)" onMouseOver="ShowThing(this,17,80,\'������� � ���������\')" ></a>',$persout);
echo $persout;
echo "<br>";
echo "<small>".$map_echo."</small>";

if ($IN_ROOM_SUMR_PRINT!='')
								{
								echo $IN_ROOM_SUMR_PRINT;
								}

 if ($labpoz[dead] >0)
					{
					echo "<small> �� ������� � ���������:<b>".($labpoz[dead])." �� ".$MAX_DEAD."-�</b> ���</small><br>";
					}
if ($Displ_team!="")
			{
			echo "<U>���� ������</U><br>";
			echo 	$Displ_team;
			echo "<br>";
			}
echo "<small>".$print_effe_lab."</small>";
echo "</td>";		
echo "<td>";	
//echo "<br>";
//echo $room_map;
	//if (($room_map!="2")) {	$_SESSION['sysmess']=0;	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/*
       if ($user[id]==14897)
	{
	echo "ROOM:";
	print_r($room_map);
	echo "<br> Qmap:";
	print_r($Qmap);
	echo "<br>Aitem:";
	print_r($Aitems);
	echo "<br>Ait_val";
	print_r($Aitems_val);
	echo "<br>$Aite_cout";
	print_r($Aitems_count);
	echo "<br>";
	}

����� ���
-----------------*/
?>

					<div style="text-align: center;">
					<table style="width: 1115px; text-align: left; margin-left: auto; margin-right: auto; height: 363px;" border="0" cellpadding="0" cellspacing="0">
					<tbody align="center">
					<tr align="center">
					<td style="text-align: center;" class="decor_left"></td>
					<td style="text-align: right;" class="mianroom_left">
					<table style="width: 244px; height: 360px; text-align: center; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">
					<tbody>
					<tr style="width: 244px; text-align: center;">
					<td>
						<?
						//���������� �������
							if ($_SESSION['looklab']==0)
								{
								$kompas="compass_n.png";
								}
							elseif ($_SESSION['looklab']==180)
								{
								$kompas="compass_s.png";
								}
							elseif ($_SESSION['looklab']==270)
								{
								$kompas="compass_e.png";
								}
							elseif ($_SESSION['looklab']==90)
								{
								$kompas="compass_w.png";
								}								
						
						echo "<img class='compass' src='http://i.oldbk.com/i/imglab/{$kompas}'>";
						?>
						</td>
					</tr>
					<tr>
					 <td width="165" height="244">
					  <? echo $MAP_SCREEN; ?>					
					  </td>
					</tr>
					</tbody>
					</table>
					</td>
					<td style="text-align: center;" class="mainroom_center">
						
							
							<table style="width: 391px; height: 363px; text-align: center; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">
							<tr>
							<td  style="width: 391px; height: 280px;">
						    <?
						    //������� �����
							$leftb=19;
							$topb=0;
							echo "<DIV style=\"position:relative;background-color:black;left:".$leftb."px;top: ".$topb."px;background-repeat:no-repeat; width:352px; height:240px; background: url('http://capitalcity.oldbk.com/i/plab/bg".$_SESSION[lab_bg].".jpg');\">";
							echo $d3_out;
							echo "</div>";
							?>
							</td>
							</tr>
							<tr>
							<td  style="width: 391px; height: 83px;">
									<table style="width: 391px; height: 83px; text-align: center; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<td style="width: 10px; height: 83px; text-align: center;" >
										<?
										for ($rr=0;$rr<6;$rr++)
											{
											echo "<td style=\"width: 60px; height: 83px; text-align: center;\" >";
												if ($IN_ROOM_DO_PRINT[$rr]!='')	
													{
													echo $IN_ROOM_DO_PRINT[$rr];
													}
											echo "</td>";											
											}
										?>	
									<td style="width: 10px; height: 83px; text-align: center;" >																			
									</tr>
									</table>

							</td>
							</table>

						</td>
					<td style="text-align: center;" class="mainroom_right">
					<table class="navwind" style="width: 242px;" border="0" cellpadding="0" cellspacing="0">
					<tbody>
					<tr align="center">
					<td style="height: 14px;" colspan="5"></td>
					</tr>
					<tr>
					<?
						if ($settings_control==1)
							{
							$napnap=0;
							}
							else
							{
							$napnap=$_SESSION['looklab'];
							}
						
					?>
					<td style="text-align: center; width: 60px; height: 45px;"></td>
					<td style="text-align: center; width: 45px; height: 45px;"><img src="http://i.oldbk.com/i/imglab/n1_normal.jpg"></td>
					<td style="text-align: center; width: 40px; height: 45px;"><a href="#" onclick='location.href="lab4.php?goto=p<?=$nap[$napnap][1];?>";'><img src="http://i.oldbk.com/i/imglab/n2_normal.jpg"  title="������" alt="������" onmouseover="this.src='http://i.oldbk.com/i/imglab/n2_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/n2_normal.jpg'"></a></td>
					<td style="text-align: center; width: 45px; height: 45px;"><img src="http://i.oldbk.com/i/imglab/n3_normal.jpg"></td>
					<td style="height: 45px;"></td>
					</tr>
					<tr>
					<td style="text-align: center; width: 60px; height: 40px;"></td>
					<td style="text-align: center; width: 40px; height: 40px;"><a href="#" onclick='location.href="lab4.php?goto=p<?=$nap[$napnap][4];?>";'><img src="http://i.oldbk.com/i/imglab/n4_normal.jpg"  title="������" alt="������" onmouseover="this.src='http://i.oldbk.com/i/imglab/n4_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/n4_normal.jpg'"></a></td>
					<td style="text-align: center; width: 40px; height: 40px;"><a href="#" onclick='location.href="lab4.php?refresh=<?=mt_rand(1111,9999);?>";'><img src="http://i.oldbk.com/i/imglab/n5_normal.jpg"  title="��������" alt="��������" onmouseover="this.src='http://i.oldbk.com/i/imglab/n5_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/n5_normal.jpg'"></a></td>
					<td style="text-align: center; width: 40px; height: 40px;"><a href="#" onclick='location.href="lab4.php?goto=p<?=$nap[$napnap][2];?>";'><img src="http://i.oldbk.com/i/imglab/n6_normal.jpg"  title="�������" alt="�������" onmouseover="this.src='http://i.oldbk.com/i/imglab/n6_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/n6_normal.jpg'"></a></td>
					<td style="height: 40px;"></td>
					</tr>
					<tr>
					<td style="text-align: center; height: 45px; width: 60px;"></td>
					<td style="text-align: center; height: 45px; width: 45px;"><a href=?look=<? if ($settings_invert==1) { echo "1"; } else { echo "2"; } ?>><img src="http://i.oldbk.com/i/imglab/n7_normal.jpg" title="����������� <? if ($settings_invert==1) { echo "�������"; } else { echo "������"; } ?>" onmouseover="this.src='http://i.oldbk.com/i/imglab/n7_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/n7_normal.jpg'"></a></td>
					<td style="text-align: center; height: 45px;"><a href="#" onclick='location.href="lab4.php?goto=p<?=$nap[$napnap][3];?>";'><img src="http://i.oldbk.com/i/imglab/n8_normal.jpg" title="�����" alt="�����" onmouseover="this.src='http://i.oldbk.com/i/imglab/n8_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/n8_normal.jpg'"></a></td>
					<td style="text-align: center; height: 45px;"><a href=?look=<? if ($settings_invert==1) { echo "2"; } else { echo "1"; } ?>><img src="http://i.oldbk.com/i/imglab/n9_normal.jpg" title="����������� <? if ($settings_invert==1) { echo "������"; } else { echo "�������"; } ?>" onmouseover="this.src='http://i.oldbk.com/i/imglab/n9_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/n9_normal.jpg'"></a></td>
					<td style="height: 45px;"></td>
					</tr>
						<tr>
							<td style="height: 20px;" colspan="5"></td>
						</tr>
			
						<tr>
						<td style="height: 60px;" colspan="5">
						
							<table  style="height: 60px;width: 240px;"  border="0" cellpadding="0" cellspacing="0">
							<tr>
							  <td style="height: 60px;width: 20px;" ></td>
							  <td style="height: 60px;" >
								<div class="room_items">
								<?
								echo $IN_ROOM_PRINT;
								do_auto($LAST_ITEM_TO_GET);
								?>
								</div>
							 </td>								
							 <td style="height: 60px;width: 20px;" ></td>
							 </tr>
							 </table>
							 
						</td>
						</tr>
						
						<tr>
						<td style="height: 60px;" colspan="5">
							<table  style="height: 60px;width: 240px;"  border="0" cellpadding="0" cellspacing="0">
							<tr>
							  <td style="height: 60px;width: 20px;" ></td>
							  <td style="height: 60px;" >
								<div class="room_items">
								<?
								echo $IN_ROOM_PRINT2;
								?>
								</div>
							 </td>								
							 <td style="height: 60px;width: 20px;" ></td>
							 </tr>
							 </table>
						</td>
						</tr>					

					<tr>
					  <td style="height: 10px;" colspan="5"></td>
					</tr>
					<tr>
					  <td style="height: 15px;width: 240px;" colspan="5"><div class="progressbar" id="progressbar"></div></td>

					</tr>
					<tr>
					  <td style="height: 10px;" colspan="5"></td>
					</tr>
					<tr>
							<td style="height: 23px;" colspan="5">
							
								<table style="width: 242px; height: 23px; text-align: center; margin-left: auto; margin-right: auto;" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<td style="width: 19px; height: 23px; text-align: center;" ></td>
										<td style="width: 51px; height: 23px; text-align: center;" ><a href="#" onclick="return confirmSubmit()" ><img src="http://i.oldbk.com/i/imglab/butt1.jpg" title="����� � �������� ��� ���������!" alt="����� � �������� ��� ���������!" onmouseover="this.src='http://i.oldbk.com/i/imglab/butt1_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/butt1.jpg'"></a></td>
										<td style="width: 51px; height: 23px; text-align: center;" ><a href="#" id="settings"><img src="http://i.oldbk.com/i/imglab/butt2.jpg" title="���������" alt="���������" onmouseover="this.src='http://i.oldbk.com/i/imglab/butt2_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/butt2.jpg'"></a></td>										
										<td style="width: 51px; height: 23px; text-align: center;" ><a href="#" onclick='location.href="lab4.php?refresh=<?=mt_rand(1111,9999);?>";'><img src="http://i.oldbk.com/i/imglab/butt3.jpg" title="��������" alt="��������" onmouseover="this.src='http://i.oldbk.com/i/imglab/butt3_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/butt3.jpg'"></a></td>										
										<td style="width: 51px; height: 23px; text-align: center;" ><a href="main.php?edit=1" ><img src="http://i.oldbk.com/i/imglab/butt4.jpg" title="���������" alt="���������" onmouseover="this.src='http://i.oldbk.com/i/imglab/butt4_hover.jpg'" onmouseout="this.src='http://i.oldbk.com/i/imglab/butt4.jpg'"></a></td>										
									<td style="width: 19px; height: 23px; text-align: center;" ></td>								

									</tr>
								</table>

							
							</td>
					</tr>
					</tbody>
					</table>
					</td>
					<td style="text-align: right;" class="decor_right"></td>
					</tr>
					</tbody>
					</table>
						<table align=center>
						<tr>
							<td>
							<div  class="msg_center">
							<?
							if ($IN_ROOM_TRAP_PRINT!='')
								{
								$msg.="<font color=red>".$IN_ROOM_TRAP_PRINT."</font>";
								}
							
							
							if ($msg!='')
								{
								echo $msg;
								}
								else
								{
								echo "<br>";
								}
							?>
							</div>
						</td>
						</tr>
						</table>
					</div>


</td>
<td valign=top align=left width=250></td>
</tr>
</table>

<?
include "end_files.php";
?>
<div align=right>
<br><br><br>
			<!--LiveInternet counter--><script type="text/javascript"><!--
			document.write("<a href='http://www.liveinternet.ru/click' "+
			"target=_blank><img style='float:right; ' src='http://counter.yadro.ru/hit?t54.2;r"+
			escape(document.referrer)+((typeof(screen)=="undefined")?"":
			";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
			screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
			";"+Math.random()+
			"' alt='' title='LiveInternet: �������� ����� ���������� �"+
			" ����������� �� 24 ����' "+
			"border='0' ><\/a>")
			//--></script><!--/LiveInternet-->

<!--Rating@Mail.ru counter-->
<script language="javascript" type="text/javascript"><!--
d=document;var a='';a+=';r='+escape(d.referrer);js=10;//--></script>
<script language="javascript1.1" type="text/javascript"><!--
a+=';j='+navigator.javaEnabled();js=11;//--></script>
<script language="javascript1.2" type="text/javascript"><!--
s=screen;a+=';s='+s.width+'*'+s.height;
a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth);js=12;//--></script>
<script language="javascript1.3" type="text/javascript"><!--
js=13;//--></script><script language="javascript" type="text/javascript"><!--
d.write('<a href="http://top.mail.ru/jump?from=1765367" target="_blank">'+
'<img src="http://df.ce.ba.a1.top.mail.ru/counter?id=1765367;t=49;js='+js+
a+';rand='+Math.random()+'" alt="�������@Mail.ru" border="0" '+
'height="31" width="88"><\/a>');if(11<js)d.write('<'+'!-- ');//--></script>
<noscript><a target="_blank" href="http://top.mail.ru/jump?from=1765367">
<img src="http://df.ce.ba.a1.top.mail.ru/counter?js=na;id=1765367;t=49"
height="31" width="88" border="0" alt="�������@Mail.ru"></a></noscript>
<script language="javascript" type="text/javascript"><!--
if(11<js)d.write('--'+'>');//--></script>
<!--// Rating@Mail.ru counter-->
</div>
</body>
</html>
<?

/////////////////////////////////////////////////////////////////////////////////////////////////
    if (isset($miniBB_gzipper_encoding)) {
    $miniBB_gzipper_in = ob_get_contents();
    $miniBB_gzipper_inlenn = strlen($miniBB_gzipper_in);
    $miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
    $miniBB_gzipper_lenn = strlen($miniBB_gzipper_out);
    $miniBB_gzipper_in_strlen = strlen($miniBB_gzipper_in);
    $gzpercent = percent($miniBB_gzipper_in_strlen, $miniBB_gzipper_lenn);
    $percent = round($gzpercent);
    $miniBB_gzipper_in = str_replace('<!- GZipper_Stats ->', 'Original size: '.strlen($miniBB_gzipper_in).' GZipped size: '.$miniBB_gzipper_lenn.' �ompression: '.$percent.'%<hr>', $miniBB_gzipper_in);
    $miniBB_gzipper_out = gzencode($miniBB_gzipper_in, 2);
    ob_clean();
    header('Content-Encoding: '.$miniBB_gzipper_encoding);
    echo $miniBB_gzipper_out;
    }
////////////////////////////////////////////////////////////////////////////////////////

?>