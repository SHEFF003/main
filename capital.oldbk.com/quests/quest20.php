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

  if ($qcount[qitem] > ($quest[q_item_count]*0.5)  ) 
  		{
		$k_it=$quest[q_item_count]-$qcount[qitem];
  		}
      else
      {
      $k_it=round(($quest[q_bot_count])*0.5);
      }

 $it=$quest[q_item];
 $maxc=count($map);
			$k_it++;//������� 1 ������
$stopc=0;
  while (($k_it > 0) and ($stopc!=600) )
	{

	$rx=mt_rand(8,$maxc-2); // ������������ ����� ������ - �� ������ ������ ����
	$ry=mt_rand(8,$maxc-2);

	
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
	$Q_MOB=array( $quest[q_bot] => 1);
	$mob[$rmt]=$mob[$rmt]+$Q_MOB; // ��������� ������� � ������������ �����
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
global $labpoz,$mysql ;
//�������� �� �������� - ����� ���� - ������������ ���  ���� ��� ����� �������
mysql_query("INSERT `labirint_items` (`map`,`item`,`x`,`y`,`active`,`count`,`val`,`owner`) values('".$labir."','I','".$labpoz[x]."','".$labpoz[y]."','0','-1','{$_SESSION['questdata'][q_item]}','{$telo[id]}' ) ON DUPLICATE KEY UPDATE `active` =1 ;");
}

function get_qcount($quest,$telo,$labir) //������� ����������� ������� ������� ���� ����
{
global $map ,$labpoz,$Qmap,$mysql ;
$qcount=mysql_fetch_array(mysql_query("select count(id) as qitem from inventory where owner='{$telo[id]}' and sowner='{$telo[id]}' and prototype='{$quest[q_item]}' and setsale=0 ;"));
echo $qcount[qitem];
echo "/";
echo $quest[q_item_count];
echo "<br>";
if ($qcount[qitem]>=$quest[q_item_count]) { return true; } else {return false;}
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
mysql_query("delete from inventory where owner='{$telo[id]}' and prototype='{$quest[q_item]}' and setsale=0 and sowner='{$telo[id]}'");

  if(mysql_affected_rows() > 10) //���� ���� ������������� �� ���� ����� 
  	{
		/*
		mysql_query("INSERT INTO `inventory` (`name`,`duration`,`maxdur`,`cost`,`owner`,`nlevel`,`nsila`,`nlovk`,`ninta`,`nvinos`,`nintel`,`nmudra`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nalign`,`minu`,`maxu`,`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`img`,`text`,`dressed`,`bron1`,`bron2`,`bron3`,`bron4`,`dategoden`,`magic`,`type`,`present`,`sharped`,`massa`,`goden`,`needident`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`letter`,`isrep`,`update`,`setsale`,`prototype`,`otdel`,`bs`,`gmp`,`includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`,`gmeshok`,`tradesale`,`karman`,`stbonus`,`upfree`,`ups`,`mfbonus`,`mffree`,`type3_updated`,`bs_owner`,`nsex`,`present_text`,`add_time`,`labonly`,`labflag`,`prokat_idp`,`prokat_do`,`arsenal_klan`,`repcost`,`up_level`,`ecost`,`group`,`ekr_up`,`unik`,`add_pick`,`pick_time`,`sowner`) VALUES ('���� �� ���������',0,1,5,'{$telo[id]}',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'labticket_e.gif','',0,0,0,0,0,0,66,50,'',0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,'',0,4001,'52',0,0,0,0,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,0,NULL,'',0,0,0,0,NULL,0,NULL,NULL,0);");
		echo "<br><font color=red><b>�� ��������:\"���� �� ���������\" �� �������������� �����<b></font>";				
		*/

	mysql_query("INSERT INTO `inventory` (`getfrom`,`name`,`duration`,`maxdur`,`cost`,`owner`,`nlevel`,`nsila`,`nlovk`,`ninta`,`nvinos`,`nintel`,`nmudra`,`nnoj`,`ntopor`,`ndubina`,`nmech`,`nalign`,`minu`,`maxu`,`gsila`,`glovk`,`ginta`,`gintel`,`ghp`,`mfkrit`,`mfakrit`,`mfuvorot`,`mfauvorot`,`gnoj`,`gtopor`,`gdubina`,`gmech`,`img`,`text`,`dressed`,`bron1`,`bron2`,`bron3`,`bron4`,`dategoden`,`magic`,`type`,`present`,`sharped`,`massa`,`goden`,`needident`,`nfire`,`nwater`,`nair`,`nearth`,`nlight`,`ngray`,`ndark`,`gfire`,`gwater`,`gair`,`gearth`,`glight`,`ggray`,`gdark`,`letter`,`isrep`,`update`,`setsale`,`prototype`,`otdel`,`bs`,`gmp`,`includemagic`,`includemagicdex`,`includemagicmax`,`includemagicname`,`includemagicuses`,`includemagiccost`,`includemagicekrcost`,`gmeshok`,`tradesale`,`karman`,`stbonus`,`upfree`,`ups`,`mfbonus`,`mffree`,`type3_updated`,`bs_owner`,`nsex`,`present_text`,`add_time`,`labonly`,`labflag`,`prokat_idp`,`prokat_do`,`arsenal_klan`,`repcost`,`up_level`,`ecost`,`group`,`ekr_up`,`unik`,`add_pick`,`pick_time`,`sowner`) VALUES ('10','���� �666',0,10,1,'{$telo[id]}',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'unik_key.gif','',0,0,0,0,0,0,0,50,'',0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,'',0,3333,'52',0,0,0,0,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0,0,NULL,0,0,0,0,NULL,'',0,0,0,1,NULL,0,NULL,NULL,0);");
	echo "<br><font color=red><b>�� ��������:\"���� �666\" �� �������������� �����<b></font>";	


	}

}

?>