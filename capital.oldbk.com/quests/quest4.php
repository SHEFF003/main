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
 
 $qcount=mysql_fetch_array(mysql_query("select count(id) as qitem from inventory where owner='{$telo[id]}' and sowner='{$telo[id]}' and prototype='{$quest[q_item]}' and setsale=0 ;"));
 
 $itemsmap = fopen($fmap,"a+");
 $k_it=$quest[q_item_count]-$qcount[qitem];
 $it=$quest[q_item];
 $maxc=count($map);

$stopc=0;
  while (($k_it > 0) and ($stopc!=600) )
	{
	$rx=mt_rand(12,$maxc-2); // ������� �� ������
	$ry=mt_rand(12,$maxc-2);
	
	if ($map[$rx][$ry]=='O')
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
global $map ,$labpoz,$Qmap,$mysql ;
mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`,`val`,`owner`) values('".$labir."','Q','".$labpoz[x]."','".$labpoz[y]."','1','1','{$Qmap[$labpoz[x]][$labpoz[y]]}','{$telo[id]}' ) ON DUPLICATE KEY UPDATE `active` =1 ;");
mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`val`,`owner`) values('".$labir."','I','".$labpoz[x]."','".$labpoz[y]."','0','{$Qmap[$labpoz[x]][$labpoz[y]]}','{$telo[id]}' ) ON DUPLICATE KEY UPDATE `active` =1 ;");
//��� �� ����� ������ ��������
}

function get_qitem($quest,$telo,$labir)  // �������� � ���� ���������� �����
{
// ������� ���������� � ���� ����
global $map ,$labpoz,$Qmap,$mysql ;
//echo "�������� ��������";
addchp ('<font color=red>��������!</font> '.$quest[qsystem],'{[]}'.$telo['login'].'{[]}',$telo['room'],$telo['id_city']);

}

function get_drop_qitem($quest,$telo,$labir) //��������� �� ����
{
}

function get_kill_bot($quest,$telo,$labir) // �������� ����
{

}

function get_qcount($quest,$telo,$labir) //������� ����������� ������� ������� ���� ����
{
global $map ,$labpoz,$Qmap,$mysql ;
$qcount=mysql_fetch_array(mysql_query("select count(id) as qitem from inventory where owner='{$telo[id]}' and sowner='{$telo[id]}' and prototype='{$quest[q_item2]}' and setsale=0 ;"));
echo $qcount[qitem];
echo "/";
echo $quest[q_item2_count];
echo "<br>";
if ((int)($qcount[qitem])>=(int)($quest[q_item2_count])) 
			{ 
			return true; 
			} else 
			{
			return false;
			}
}

function get_qitem_check($quest,$telo,$labir) // �������� �� ������������ ���������� �������� ���� �� ���������
{
global $map ,$labpoz,$Qmap,$mysql,$dress ;

 if ((int)($Qmap[$labpoz[x]][$labpoz[y]])==(int)($quest[q_item])) 
   {
   //���������� ����� -� ������� �� ������
   $dress = mysql_fetch_array(mysql_query("SELECT * FROM `eshop` WHERE `id` = '{$quest[q_item2]}' LIMIT 1;"));
  return "TRUE";
   }
 else
  {
  return "TRUE";
  }
}

function make_qfin($quest,$telo) // ��������� ������
{
if (get_qcount($quest,$telo,0)==true)
             {
//             echo "1";
	     return true;   
	               
             }
             else
             {
//                         echo "2";
	     return false;
	     }
}

function make_qfin_del($quest,$telo) // ��������� ������ - �������� �������� ����� ����� ������
{
global $mysql ;
mysql_query("delete from inventory where owner='{$telo[id]}' and prototype='{$quest[q_item2]}' and setsale=0 and sowner='{$telo[id]}'");
}

?>