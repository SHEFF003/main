<?
		if (!($_SESSION['uid'] >0)) header("Location: index.php");

		if ($INinlude!=true)
			{
			$mapid=(int)$_POST["target"];
			}

		echo "�����:".$mapid;
		echo "<br>";
		$map=file('/www/capitalcity.oldbk.com/labmaps/'.$mapid.'.map');
$GX=strlen($map[1]);
if (($GX > 58) or ($GX ==27) ) {$LAB='4';} 
elseif ($GX > 27) {$LAB='2';} else {$LAB='';}

if ($user['id']==14897)
	{
	echo $GX."/".$LAB."<br>";
	}

		if ($INinlude!=true)
			{
			$mapid=(int)$_POST["target"];
			 if ($LAB=='4')
			 	{
				 	if ($GX ==27)
				 	{
				 	$floor=0;					 	
				 	$get_flr=mysql_fetch_array(mysql_query("select * from labirint_users where map='{$mapid}'  limit 1"));
					 	if ($get_flr['flr']>0)
					 		{
							$floor=$get_flr['flr'];
					 		}
						
						if (($floor>=1) and ($floor<=4))
						{
						include ("labconfig_4_".(int)$floor.".php"); // ���������			 	
						}
						else
						{
						include ("labconfig_s3d.php"); // ���������			 							
						}
				 	}
			 		else
			 		{
					include ("labconfig_s3d.php"); // ���������			 	
					}
			 	}
			 	else
			 	{
				include ("labconfig_s2.php"); // ���������
				}
			}

//////////////////////////////////////////////////////////////////////////		
/// Load J-mobs
/// ��������� - ���������� - ����������� ��
$stopt=count($map);
$JMOB=array();
$JMOB_id=array();

$SJMOB=array();
$SJMOB_id=array();


$jm_count=0;
$sjm_count=0;
$jmmob=count($jmob); // ������� ����
$sjmmob=count($sjmob); // ������� ����
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
		}
		else	if ($map[$ii][$jj]=='�')
		{
		$sjm_count++;
		if ($sjm_count>$sjmmob) { $sjm_count=1;}
		$SJMOB[$ii][$jj]=$sjmob[$sjm_count][name];
		$SJMOB_id[$ii][$jj]=$sjmob[$sjm_count][id];
		}
	}
		

///////////////////LOAD MY TEAM ////////////////////////////////////////////////////////////////////////////
$team=mysql_query("SELECT * from `labirint_users` where `map`='".$mapid."' ;  ");

		$TA=array();
		$Tcount=0;
		while ($reamrow = mysql_fetch_array($team)) 
		{
		$Tcount++;
			$Displ_team.=" ".nick33($reamrow[owner])." X[".$reamrow[x]."]/Y[".$reamrow[y]."] <br>";
			$TA[$reamrow[x]][$reamrow[y]].=nick7($reamrow[owner])." ";
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
			 	}
			 else
			 if ($row[item]=='9')
			 	{
 				$map[$row[x]][$row[y]]=$ukaz[$row[val]]; //����������� ������ �����
			 	}			 	
			 	else
			 	{
				$Aitems[$row[x]][$row[y]]=$row[item];
				$Aitems_val[$row[x]][$row[y]]=$row[val];
				$Aitems_count[$row[x]][$row[y]]=$row[count];
				}
			}

?>
<html>
<head>
	<link rel=stylesheet type="text/css" href="i/main.css">
	<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
	<style>
		body {
			background-repeat: no-repeat;
			background-position: top right;
		}
		.INPUT {
			width:50px; height:50px;
			BORDER-RIGHT: #b0b0b0 1pt solid; BORDER-TOP: #b0b0b0 1pt solid; MARGIN-TOP: 1px; FONT-SIZE: 10px; MARGIN-BOTTOM: 2px; BORDER-LEFT: #b0b0b0 1pt solid; COLOR: #191970; BORDER-BOTTOM: #b0b0b0 1pt solid; FONT-FAMILY: MS Sans Serif
		}
	</style>
	


</head>
<body leftmargin=5 topmargin=0 marginwidth=0 marginheight=0 bgcolor=#e2e0e0>
<?		
		
///Paint map prep
////////////////////////////////////////////////////////////////////////////////
//set user poz to mass
///����������� �������� �������� �����////////////////
$disp=10-5;
$dispy=10-5;
if ($disp < 1) {$disp=1;}
if ($dispy < 1) {$dispy=1;}
if ($disp < 1) {$disp=1;}
if ($dispy < 1) {$dispy=1;}
if ($dispy > strlen($map[1])-12)  {$dispy=strlen($map[1])-12;} //������������ ������ ����� �� y
if ($disp > count($map)-11) 	{ $disp=count($map)-11;  } //������������ ������ ����� �� �
$dispfin=$disp+10; //������� ������� � ���
$dispfiny=$dispy+10; //������� ������� y ���
/////////////////////////////////////////////

// for ($i=$disp;$i<=$dispfin;$i++)




 for ($i=1;$i<=$GX;$i++)
	{
 	$linte=""; // for visualimage
//	for ($j=$dispy;$j<=$dispfiny;$j++)
	for ($j=1;$j<=$GX;$j++)
		{


if ($LAB==4)
		{
		// ��������� ��� 3� ����

switch($map[$i][$j])
			{

case "I":
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/os'.$LAB.'.gif title="����" alt="����">';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">';
			}
		 } // ����
break;

case "F":
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/of'.$LAB.'.gif title="�����" alt="�����">';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">';
			}
		 } // �����
break;

case "O":
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">';
			}
		 } // ������
break;

case "Q":
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif  title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">';
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
		 if ($TA[$i][$j]=='')
			{
			if ($Aitems[$i][$j]!='R')
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/r'.$LAB.'.gif title="������� ����" alt="������� ����">'; // �������� ������
					}
					else
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ���� �������
					}

			}
			else
			{
				if ($Aitems[$i][$j]!='R')
					{
					$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������
					}
					else
					{
					 if ($Aitems_val[$i][$j]>0)
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$TA[$i][$j].' - � ���" alt="'.$TA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������-�����
						}


					}
			}
		 } // mob
break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
			if ($Aitems[$i][$j]!='�')
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/j'.$LAB.'.gif title="'.$SJMOB[$i][$j].'" alt="'.$SJMOB[$i][$j].'">'; // �������� ������
					/*echo "FFFFF";
					echo $i;
					echo "/";
					echo $j;
				        echo $Aitems[$i][$j];
       					echo "<br>";	*/
					}
					else
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ���� �������
					}

			}
			else
			{
				if ($Aitems[$i][$j]!='�')
					{
					$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������
					}
					else
					{
					 if ($Aitems_val[$i][$j]>0)
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$TA[$i][$j].' - � ���" alt="'.$TA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������-�����
						}


					}
			}
		 } // mob
break;

case 'J' :
		{
		 if ($TA[$i][$j]=='')
			{
			if ($Aitems[$i][$j]!='J')
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/j'.$LAB.'.gif title="'.$JMOB[$i][$j].'" alt="'.$JMOB[$i][$j].'">'; // �������� ������
					/*echo "FFFFF";
					echo $i;
					echo "/";
					echo $j;
				        echo $Aitems[$i][$j];
       					echo "<br>";	*/
					}
					else
					{
					  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ���� �������
					}

			}
			else
			{
				if ($Aitems[$i][$j]!='J')
					{
					$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������
					}
					else
					{
					 if ($Aitems_val[$i][$j]>0)
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/rt'.$LAB.'.gif title="'.$TA[$i][$j].' - � ���" alt="'.$TA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������-�����
						}


					}
			}
		 } // mob
break;


case 'B' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='B')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case 'G' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='G')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$_SESSION['looklab']][3].'.gif alt="����������� �����" title="����������� �����" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$_SESSION['looklab']][4].'.gif alt="����������� ����" title="����������� ����" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$_SESSION['looklab']][2].'.gif alt="����������� ������" title="����������� ������" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/'.$ukazkam[$_SESSION['looklab']][1].'.gif alt="����������� �������" title="����������� �������" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '1' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='1')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '2' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='2')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case '5' : // ������� �� ��.����
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='5')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;



case 'A' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='A')
					{
					if (($_SESSION['looklab']==90) OR ($_SESSION['looklab']==180) )
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;

case 'E' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='E')
					{
					if (($_SESSION['looklab']==90) OR ($_SESSION['looklab']==180) )
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ���
			}
		 } //

break;


case 'D' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='D')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case 'T' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='T')
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/t'.$LAB.'.gif alt="������ X:'.$i.'/Y:'.$j.'" title="������ X:'.$i.'/Y:'.$j.'" >'; // ��������
					}
					else
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>'; // ��������
					}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� �
			}
		 } //

break;

case 'X' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='X')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case 'Z' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='Z')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;

case 'C' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='C')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����
			}
		 } //

break;


case 'P' :
		{
		 if ($TA[$i][$j]=='')
			{
				if (($Aitems[$i][$j]!='P') AND ($Aitems[$i][$j]!='�') )
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/pt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // BOX P) �������

break;


case 'S' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='S')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/st'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'W' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='W')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'Y' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='Y')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'L' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='L')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case 'K' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='K')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // ������

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
					if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ht'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� �������� � �����
			}
		 } 

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
					if ($Aitems[$i][$j]!='�')
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/tz'.$LAB.'.gif  alt="������ �����������" title="������ �����������"  >';
							}
							else
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';	// ������ �����
							}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� �������� � �����
			}
		 } 

break;



case 'H' :
		{
		 if ($TA[$i][$j]=='')
			{
					if ($Aitems[$i][$j]!='H')
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/h'.$LAB.'.gif alt="����� ����" title="����� ����" >'; // �����
							}
							else
							{
							  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/oo'.$LAB.'.gif>';	// ������ �����
							}

			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ht'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� �������� � �����
			}
		 } // �����

break;

case 'U' :
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/u'.$LAB.'.gif title="�" alt="�">'; // � �� �����
			}
			else
			{
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/ut'.$LAB.'.gif title="� ,'.$TA[$i][$j].'" alt="�, '.$TA[$i][$j].'">'; //� � ��� ����� �� ����
			}
		 } // user
break;




			}		
		
		
		}
else
			{	
switch($map[$i][$j])
			{

case "I":
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://i.oldbk.com/llabb/os'.$LAB.'.gif title="����" alt="����">';
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">';		
			}
		 } // ����
break;


case "F":
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://i.oldbk.com/llabb/of'.$LAB.'.gif title="�����" alt="�����">';
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">';		
			}
		 } // �����
break;

case "O":
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>';
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">';		
			}
		 } // ������
break;

case 'M' :  
		{
		$linte.='<img src=http://i.oldbk.com/llabb/m'.$LAB.'.gif>';
		} // ������
break;


case 'N' :  
		{
		$linte.='<img src=http://i.oldbk.com/llabb/n.gif>';
		} // ������
break;

case 'R' : 	
		{
		 if ($TA[$i][$j]=='')
			{
			if ($Aitems[$i][$j]!='R') 
					{
					  $linte.='<img src=http://i.oldbk.com/llabb/r'.$LAB.'.gif title="������� ����" alt="������� ����">'; // �������� ������
					}
					else
					{
					  $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // ���� �������
					}
			
			}
			else 
			{
				if ($Aitems[$i][$j]!='R') 
					{
					$linte.='<img src=http://i.oldbk.com/llabb/rt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � ������� 
					}
					else 
					{
					 if ($Aitems_val[$i][$j]>0) 
						{
						$linte.='<img src=http://i.oldbk.com/llabb/rt'.$LAB.'.gif title="'.$TA[$i][$j].' - � ���" alt="'.$TA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������-�����		
						}

				
					}
			}
		 } // mob
break;



case 'J' : 	
		{
		 if ($TA[$i][$j]=='')
			{
			if ($Aitems[$i][$j]!='J') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/j'.$LAB.'.gif title="'.$JMOB[$i][$j].'" alt="'.$JMOB[$i][$j].'">'; // �������� ������
					}
					else
					{
					  $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // ���� �������
					}
			
			}
			else 
			{
				if ($Aitems[$i][$j]!='J') 
					{
					$linte.='<img src=http://i.oldbk.com/llabb/rt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � ������� 
					}
					else 
					{
					 if ($Aitems_val[$i][$j]>0) 
						{
						$linte.='<img src=http://i.oldbk.com/llabb/rt'.$LAB.'.gif title="'.$TA[$i][$j].' - � ���" alt="'.$TA[$i][$j].' - � ���">'; // ����� ��� � �������-� ���
						}
						else
						{
						$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� � �������-�����		
						}

				
					}
			}
		 } // mob
break;


case 'B' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='B') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/b'.$LAB.'.gif alt="�������" title="�������" >'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� �������
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������		
			}
		 } // �������

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;


case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case '�' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�')
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
			$linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/bt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������
			}
		 } // �������

break;

case 'G' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='G') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/g.gif  >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case '�' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�') 
					{
					 $linte.='<img src=http://capitalcity.oldbk.com/i/plab/map/gg4.gif>'; //�������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case '�' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/uk3.gif alt="����������� �����" title="����������� �����" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case '�' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/uk4.gif alt="����������� ����" title="����������� ����" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case '�' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/uk2.gif alt="����������� �����" title="����������� �����" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case '�' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='�') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/uk1.gif alt="����������� ������" title="����������� ������" >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case '1' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='1') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/kz.gif alt="�����" title="�����" >'; // �����
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case '2' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='2') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/2.gif alt="������ ����" title="������ ����" >'; // �����
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;


case 'A' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='A') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/a'.$LAB.'.gif  >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;

case 'E' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='E') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/e'.$LAB.'.gif  >'; // �������� ����������� ������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� 	
			}
		 } // 

break;


case 'D' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='D') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/d.gif alt="�����" title="�����" >'; // �������� 
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����	
			}
		 } // 

break;

case 'T' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='T') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/t'.$LAB.'.gif alt="������ X:'.$i.'/Y:'.$j.'" title="������ X:'.$i.'/Y:'.$j.'" >'; // �������� 
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� �
			}
		 } // 

break;

case 'X' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='X') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/x.gif alt="�����" title="�����" >'; // �������� 
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����	
			}
		 } // 

break;

case 'Z' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='Z') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/z.gif alt="�����" title="�����" >'; // �������� 
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����	
			}
		 } // 

break;

case 'C' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='C') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/c.gif alt="�����" title="�����" >'; // �������� 
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� 
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �����	
			}
		 } // 

break;

case 'P' :	
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='P') 
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/p'.$LAB.'.gif alt="���� �������" title="���� �������">'; // �������� �������
					}
					else
					{
					 $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>'; // �������� �������
					}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/pt'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������		
			}
		 } // BOX P) �������

break;


case 'S' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='S')  
							{ 
							$linte.='<img src=http://i.oldbk.com/llabb/s'.$LAB.'.gif alt="������" title="������">' ; //������ 
							}
							else 
							{
							$linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>' ;  //������ ������	
							}
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/st'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������		
			}
		 } // ������

break;

case 'W' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='W')  
							{ 
							$linte.='<img src=http://i.oldbk.com/llabb/w'.$LAB.'.gif alt="�����" title="�����">' ; //������ 
							}
							else 
							{
							$linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>' ;  //������ ������	
							}
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������		
			}
		 } // ������

break;

case 'Y' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='Y')  
							{ 
							$linte.='<img src=http://i.oldbk.com/llabb/y'.$LAB.'.gif alt="�����" title="�����">' ; //������ 
							}
							else 
							{
							$linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>' ;  //������ ������	
							}
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������		
			}
		 } // ������

break;

case 'L' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='L')  
							{ 
							$linte.='<img src=http://i.oldbk.com/llabb/l'.$LAB.'.gif alt="�����" title="�����">' ; //������ 
							}
							else 
							{
							$linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>' ;  //������ ������	
							}
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������		
			}
		 } // ������

break;

case 'K' :
		{
		 if ($TA[$i][$j]=='')
			{
				if ($Aitems[$i][$j]!='K')  
							{ 
							$linte.='<img src=http://i.oldbk.com/llabb/k'.$LAB.'.gif alt="�����" title="�����">' ; //������ 
							}
							else 
							{
							$linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>' ;  //������ ������	
							}
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ot'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; //����� ��� �������� � �������		
			}
		 } // ������

break;

case 'H' :	
		{
		 if ($TA[$i][$j]=='')
			{
					if ($Aitems[$i][$j]!='H') 
							{
							  $linte.='<img src=http://i.oldbk.com/llabb/h'.$LAB.'.gif alt="����� ����" title="����� ����" >'; // �����
							}
							else 
							{
							  $linte.='<img src=http://i.oldbk.com/llabb/o'.$LAB.'.gif>';	// ������ �����
							}

			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ht'.$LAB.'.gif title="'.$TA[$i][$j].'" alt="'.$TA[$i][$j].'">'; // ����� ��� �������� � �����		
			}
		 } // �����

break;

case 'U' :	
		{
		 if ($TA[$i][$j]=='')
			{
			  $linte.='<img src=http://i.oldbk.com/llabb/u'.$LAB.'.gif title="�" alt="�">'; // � �� �����
			}
			else 
			{
			$linte.='<img src=http://i.oldbk.com/llabb/ut'.$LAB.'.gif title="� ,'.$TA[$i][$j].'" alt="�, '.$TA[$i][$j].'">'; //� � ��� ����� �� ����		
			}
		 } // user
break;




			}
			}

            }
	  $MAP_SCREEN.=$linte."<br>\n";
	}

/// map prep

echo $MAP_SCREEN;
?>

</body>
</html>
