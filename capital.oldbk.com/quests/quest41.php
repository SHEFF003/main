<?
//�������� ������ ����� quests
// �������� user
//�������� ������ �����:
//   labir  ���� �����


function make_qstart($quest,$telo,$labir) // ���������� ��� �������� ����� � ���� ��������� ��� ��� ���� ������� 
{
global $map ;
make_qitem($quest,$telo,$labir);
//echo "start QUEST FUNCTION";
}

function make_qitem($quest,$telo,$labir) //�������� ����� �������// ������������ ��� �������� �����
 {
global $map, $mysql ; //  -����� ����� ����� - ��������� ��� ���������
 
 $fmap='/www/capitalcity.oldbk.com/labmapsq/'.$labir.'-'.$telo[id].'.qst'; // ������� ������ ��������� ������ - ��� �� ���� � ������� �������� ������ � ���������� ��������� ������
 
 $qcount=mysql_fetch_array(mysql_query("select val as qitem from labirint_var  where owner='{$telo[id]}' and var='qlab_count_bot' ")); 
  
 $itemsmap = fopen($fmap,"a+");
 
 if ($qcount[qitem] < $quest[q_bot_count])
  {
  $k_it=1;
  }
  else
  {
   $k_it=0;
  }
 

 $it=1020000; // �����_�����
 $maxc=count($map);


  $stopc=0;
  while (($k_it > 0) and ($stopc!=600) )
	{

	$rx=mt_rand(5,$maxc-2); // ������������ ����� ������ - �� ������ ������ ����
	$ry=mt_rand(5,$maxc-2);

	
	if ($map[$rx][$ry]=='R') // ������ ����� ������ ��� ��� �������
		{
	 	$map[$rx][$ry]='Q'; 
		$k_it--;
		// ���������� � ����� ��������� ��� ���� ���������� ����� ���������� �����
		//
		fwrite($itemsmap,$rx.'::'.$ry.'::'.$it."\n");
		}
	$stopc++;			
	}

fclose($itemsmap);
 
 }

//$labpoz - ����� x,y
//$Qmap - ����� ����������� ������
function make_qpoint($quest,$telo,$labir) // �������� �� ����� ����� ��� ���������� ����� ��� �����
{
global $mob,$rmt ;
//��� �� ����� ������ ��������
	////////////////////////////////////////id => ���.
	$Q_MOB=array( $quest[q_bot] => 5);
	
	$mob[$rmt]=$Q_MOB; // ��������� ������� � ������������ �����
}

function get_qitem($quest,$telo,$labir)  // �������� � ���� ���������� �����
{
// ������� ���������� � ���� ����
//global $map ,$labpoz,$Qmap,$mysql ;
//echo "�������� ��������";
//addchp ('<font color=red>��������!</font> '.$quest[qsystem],'{[]}'.$telo['login'].'{[]}');

}

function get_drop_qitem($quest,$telo,$labir) //��������� �� ����
{



}

function get_kill_bot($quest,$telo,$labir) // �������� ����
{
global $labpoz,$mysql ;
//�������� �� �������� - ����� ���� - ������������ ���  ���� ��� ����� �������
//mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`,`val`,`owner`) values('".$labir."','I','".$labpoz[x]."','".$labpoz[y]."','0','-1','{$_SESSION['questdata'][q_item]}','{$telo[id]}' ) ON DUPLICATE KEY UPDATE `active` =1 ;");

   mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$telo[id]."', 'qlab_count_bot', '1' ) ON DUPLICATE KEY UPDATE `val` =`val`+1;");
addchp ('<font color=red>��������!</font> '.$quest[qsystem],'{[]}'.$telo['login'].'{[]}');
}

function get_qcount($quest,$telo,$labir) //������� ����������� ������� ������� ���� ����
{
global $map ,$labpoz,$Qmap,$mysql ;

$qcount=mysql_fetch_array(mysql_query("select val as qitem from labirint_var  where owner='{$telo[id]}' and var='qlab_count_bot' ")); 
echo $qcount[qitem];
echo "/";
echo $quest[q_bot_count];
echo "<br>";
if ($qcount[qitem]>=$quest[q_bot_count]) { return true; } else {return false;}
}

function get_qitem_check($quest,$telo,$labir) // �������� �� ������������ ���������� �������� ���� �� ���������
{
return "TRUE";
}

function make_qfin($quest,$telo) // ��������� ������
{
if (get_qcount($quest,$telo,0)==true)
             {
	     return true;             
             }
             else
             {
	     return false;
	     }
}

function make_qfin_del($quest,$telo) // ��������� ������ - �������� �������� ����� ����� ������
{
global $mysql ;

  mysql_query("INSERT `labirint_var` (`owner`,`var`,`val`) values('".$telo[id]."', 'qlab_count_bot', '0' ) ON DUPLICATE KEY UPDATE `val` =0;");
}

?>