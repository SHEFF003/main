<?
session_start();
?>
<HTML><HEAD>
<link rel=stylesheet type="text/css" href="i/main.css">
<meta content="text/html; charset=windows-1251" http-equiv=Content-type>
<META Http-Equiv=Cache-Control Content="no-cache, max-age=0, must-revalidate, no-store">
<meta http-equiv=PRAGMA content=NO-CACHE>
<META Http-Equiv=Expires Content=0>
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="http://i.oldbk.com/i/jscal/css/steel/steel.css" />
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/jscal2.js"></script>
<script type="text/javascript" src="http://i.oldbk.com/i/jscal/js/lang/ru2.js"></script>
<script>
function absPosition(obj) {
      var x = y = 0;
      while(obj) {
            x += obj.offsetLeft;
            y += obj.offsetTop;
            obj = obj.offsetParent;
      }
      return {x:x, y:y};
}
function alt(id, name){
		//alert('');


	var ourDiv = document.getElementById(id);

        var xx;
        var yy;
		xx=absPosition(ourDiv).x;
		yy=absPosition(ourDiv).y;

        var ss;
        yy=+yy+20;
        xx=+xx+23;
        ss=' <b>'+name+'</b>';


        document.getElementById("result").style.left=xx;
        document.getElementById("result").style.top=yy;
		showdiv();
		document.getElementById('result').innerHTML = ss;
      }


      function hidediv() {
if (document.getElementById)
	{
	document.getElementById('result').style.visibility = 'hidden';
	}
}

function showdiv() {
	if (document.getElementById)
	{
	document.getElementById('result').style.visibility = 'visible';
	}
}
</script>

<style>
	.row {
		cursor:pointer;
	}
</style>

</HEAD>
<body leftmargin=5 topmargin=5 marginwidth=0 marginheight=0 bgcolor=#e2e0e0 >
<div id="result" style="border: solid 1px black; background: #fc0; visibility: hidden; z-index: 10;  position: absolute; left: 10px; top: 10px;">����������� � �������</div>
<table align=right><tr><td><INPUT TYPE="button" onClick="location.href='main.php';" value="���������" title="���������"></table>

<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

	include "connect.php";
	include "functions.php";
	
$access=check_rights($user);
	

if($user[klan]!='Adminion' && $user[klan]!='radminion' && ($access[pals_delo]!=1 || $access[pals_online]!=1))
{
	die('�������� �� �������...');
}

if (isset($_POST[sit_hist]) || isset($_POST[delo]))
{
	if (isset($_POST[new_delo_date]))
	{
	//29.09.11
		$new_delo_date_all=explode(".",$_POST[new_delo_date]);
		$new_delo_date = sprintf("%02d.%02d.%04d", (int)($new_delo_date_all[0]), (int)($new_delo_date_all[1]), (int)($new_delo_date_all[2]));
	}
	else
	{
		$log_date = date("d.m.Y");
	}
	
	if (isset($_POST[new_delo_fdate]))
	{
	//29.09.11
		$new_delo_fdate_all=explode(".",$_POST[new_delo_fdate]);
		$new_delo_fdate = sprintf("%02d.%02d.%04d", (int)($new_delo_fdate_all[0]), (int)($new_delo_fdate_all[1]), (int)($new_delo_fdate_all[2]));
	}
	else
	{
		$new_delo_fdate = date("d.m.Y");
	}
}
else
{
	$new_delo_date = "01.12.2011";
	$new_delo_fdate = date("d.m.Y");
}
echo '<br><br><br><h3>�������� �������� ���������</h3><br><br><br>

<div>
<table><tr><td>&nbsp
<form action="?" method=post>
	<input type=text name=login value="'.$_POST[login].'"> ��� ��������. <br>
	';
	echo "c:<input type=text name='new_delo_date' value='{$new_delo_date}' id=\"delocalendar-inputField1\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"delocalendar-trigger1\" value='...'>";
	echo "
		<script>
		Calendar.setup({
		trigger    : \"delocalendar-trigger1\",
		inputField : \"delocalendar-inputField1\",
		dateFormat : \"%d.%m.%Y\",
		onSelect   : function() { this.hide() }
				});
		document.getElementById('delocalendar-trigger1').setAttribute(\"type\",\"BUTTON\");
		</script>";
	echo "��:<input type=text name='new_delo_fdate' value='{$new_delo_fdate}' id=\"delocalendar-inputField2\" style='width: 70px; padding-left: 2px; height:18px; padding-bottom: 0px;' >";
	echo "<input type=button id=\"delocalendar-trigger2\" value='...'>";
	echo "
		<script>
		Calendar.setup({
		trigger    : \"delocalendar-trigger2\",
		inputField : \"delocalendar-inputField2\",
		dateFormat : \"%d.%m.%Y\",
		onSelect   : function() { this.hide() }
				});
		document.getElementById('delocalendar-trigger2').setAttribute(\"type\",\"BUTTON\");
		</script><br>";
	echo '
	<input type="checkbox" name=check '.(isset($_POST[check])?'checked':'').'> ��������;<br>
	<input type="checkbox" name=marry '.(isset($_POST[marry])?'checked':'').'> ��������;<br>
	<input type="checkbox" name=obezlich '.(isset($_POST[obezlich])?'checked':'').'> ����������;<br>
	<input type="checkbox" name=haos '.(isset($_POST[haos])?'checked':'').'> ����;<br>
	<input type="checkbox" name=sleep '.(isset($_POST[sleep])?'checked':'').'> �����;<br>
	<input type="checkbox" name=fsleep '.(isset($_POST[fsleep])?'checked':'').'> � �����;<br>
	<input type="checkbox" name=death '.(isset($_POST[death])?'checked':'').'> ���� ������;<br>
	';
	
/*
		1 ��������
		2 �������� � ��
		3 ��������
		4 ������
		5 ������� �� �����
		6 ����������
		7 ��������� ����
		8 ����
		9 ���� ���
		10 �����
		11 ����� ���
		12 � �����
		13 � ����� ���
		14 ���� ������
		15 ���� ������ ���

*/
	
	
	echo '<input type=submit name="delo" value="��������">&nbsp;&nbsp;&nbsp;<input type=submit name="sit_hist" value="������� �������">
	</form></div>
';
echo '</td></tr><tr><td>';

$stamp_start=mktime(0, 0, 0, (int)($new_delo_date_all[1]), (int)($new_delo_date_all[0]), (int)($new_delo_date_all[2]));
$stamp_fin=mktime(23, 59, 59,(int)($new_delo_fdate_all[1]), (int)($new_delo_fdate_all[0]), (int)($new_delo_fdate_all[2]));
			
if($_POST[delo] && $access[pals_delo]==1)
{
	
	$sql=array();
	$types=array();
	$name=array();
	if(isset($_POST[check]))
	{
		$sql[1]=1;
		$name[1]='��������';
	}
	if(isset($_POST[marry]))
	{
		$sql[3]=3;
		$sql[4]=4;
		$name[3]='�������';
		$name[4]='������';
	}
	if(isset($_POST[obezlich]))
	{
		$sql[6]=6;
		$name[6]='�����.';
		$sql[7]=7;
		$name[7]='�����.������';
		
	}
	if(isset($_POST[haos]))
	{
		$sql[8]=8;
		$name[8]='����';
		$sql[9]=9;
		$name[9]='����';
	}
	if(isset($_POST[sleep]))
	{
		$sql[10]=10;
		$name[10]='��������';
		$sql[11]=11;
		$name[11]='������.��������';
	}
	if(isset($_POST[fsleep]))
	{
		$sql[12]=12;
		$name[12]='�������';
		$sql[13]=13;
		$name[13]='������.�������';
	}
	if(isset($_POST[death]))
	{
		$sql[14]=14;
		$name[14]='����';
		$sql[15]=15;
		$name[15]='������.�����';
	}
	
	
	$pal=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.users where login = '".$_POST[login]."' limit 1"));
	
	$data=mysql_query("SELECT * FROM oldbk.paldelo where author='".$pal[id]."' AND `date` > '".$stamp_start."' AND `date` < '".$stamp_fin."' ".(count($sql)>0?(' AND m_type in ('.(implode(',',$sql)).')'):'')." ;");
	/*
		���� ��:
		1 ��������
		2 �������� � ��
		3 ��������
		4 ������
		5 ������� �� �����
		6 ����������
		7 ��������� ����
		8 ����
		9 ���� ���
		10 �����
		11 ����� ���
		12 � �����
		13 � ����� ���
		14 ���� ������
		15 ���� ������ ���
		
	
	*/
	$counts=array();
	while($row=mysql_fetch_assoc($data))
	{
		$row[text]=preg_replace("/&quot;(.*?)&quot;/i","<a target=_blank href=inf.php?login=\\1>\\1</a>", $row[text]);
		echo  date("d.m.y",$row['date']).' '.$row[text];
		echo '<br>';
		$count[$row[m_type]]+=1;
	}
	
	echo '<hr>�����: ';
	foreach($count as $k=>$v)
	{
		echo $name[$k].': '.$v.'; ';
	}
}
else
if($_POST[sit_hist] && $access[pals_online]==1)
{

	$moder_room=array(1=>'��',2=>'��2',3=>'��3',4=>'��4',5=>'��1',6=>'��2',7=>'��3',8=>'��',9=>'��',10=>'���',
		11=>'��',12=>'��',13=>'��',14=>'��',15=>'��',16=>'���',17=>'��',18=>'��',19=>'�',20=>'��',
		21=>'��',22=>'���',23=>'��',24=>'ͨ',25=>'��',26=>'��',27=>'���',28=>'��',29=>'���',30=>'���',
		31=>'��',32=>'��',33=>'��',34=>'��',35=>'��',37=>'����',38=>'����',39=>'����',40=>'���',41=>'����',
		42=>'��',43=>'��',44=>'44',46=>'46',47=>'47',48=>'48',49=>'49',50=>'���',51=>'���',
		52=>'���',53=>'���',54=>'��',55=>'���',56=>'���',
		57=>"���",58=>"�58",59=>"�59",60=>"��",61=>"�61",62=>"�62",63=>"�63",64=>"�64",65=>"�65",66=>'��',
		200=> "����",401=> "��",
		70 => "���",
		71 => "���");
	

	$room=array(
		1=>'��',2=>'��2',3=>'��3',4=>'��4',5=>'��1',6=>'��2',7=>'��3',8=>'��',9=>'��',10=>'���',
		11=>'��',12=>'��',13=>'��',14=>'��',15=>'��',16=>'���',17=>'��',18=>'��',19=>'�',20=>'��',
		21=>'��',22=>'���',23=>'��',24=>'ͨ',25=>'��',26=>'��',27=>'���',28=>'��',29=>'���',30=>'���',
		31=>'��',32=>'��',33=>'��',34=>'��',35=>'��',37=>'����',38=>'����',39=>'����',40=>'���',41=>'����',
		42=>'��',43=>'��',44=>'44',45=>'45',46=>'46',47=>'47',48=>'48',49=>'49',50=>'���',51=>'���',
		52=>'���',53=>'���',54=>'��',55=>'���',56=>'���',
		57=>"���",58=>"�58",59=>"�59",60=>"��",61=>"�61",62=>"�62",63=>"�63",64=>"�64",65=>"�65",66=>'��',
		200=> "����",401=> "��",
		70 => "���",
		"71" => "���",
	//�������
	
	"197"=>"��",
	"198"=>"��",
	"199"=>"��",
	
	"210"=>"���",
	"211"=> "��[1]",
	"212"=> "��[2]",
	"213"=> "��[3]",
	"214"=> "��[4]",
	"215"=> "��[5]",
	"216"=> "��[6]",
	"217"=> "��[7]",
	"218"=> "��[8]",
	"219"=> "��[9]",
	"220"=> "��[10]",
	"221"=> "��[11]",
	"222"=> "��[12]",
	// ��������� ��������
	"240"=>"���",
	"241"=> "��[1]",
	"242"=> "��[2]",
	"243"=> "��[3]",
	"244"=> "��[4]",
	"245"=> "��[5]",
	"246"=> "��[6]",
	"247"=> "��[7]",
	"248"=> "��[8]",
	"249"=> "��[9]",
	"250"=> "��[10]",
	"251"=> "��[11]",
	"252"=> "��[12]",
	//�������� �������
	"270"=>"���",
	"271"=> "��[1]",
	"272"=> "��[2]",
	"273"=> "��[3]",
	"274"=> "��[4]",
	"275"=> "��[5]",
	"276"=> "��[6]",
	"277"=> "��[7]",
	"278"=> "��[8]",
	"279"=> "��[9]",
	"280"=> "��[10]",
	"281"=> "��[11]",
	"282"=> "��[12]",
	
	// ��
	"501" => "��",
	"502" => "��",
	"503" => "��",
	"504" => "��",
	"505" => "��",
	"506" => "��",
	"507" => "��",
	"508" => "��",
	"509" => "��",
	"510" => "��",
	"511" => "��",
	"512" => "��",
	"513" => "��",
	"514" => "��",
	"515" => "��",
	"516" => "��",
	"517" => "��",
	"518" => "��",
	"519" => "��",
	"520" => "��",
	"521" => "��",
	"522" => "��",
	"523" => "��",
	"524" => "��",
	"525" => "��",
	"526" => "��",
	"527" => "��",
	"528" => "��",
	"529" => "��",
	"530" => "��",
	"531" => "��",
	"532" => "��",
	"533" => "��",
	"534" => "��",
	"535" => "��",
	"536" => "��",
	"537" => "��",
	"538" => "��",
	"539" => "��",
	"540" => "��",
	"541" => "��",
	"542" => "��",
	"543" => "��",
	"544" => "��",
	"545" => "��",
	"546" => "��",
	"547" => "��",
	"548" => "��",
	"549" => "��",
	"550" => "��",
	"551" => "��",
	"552" => "��",
	"553" => "��",
	"554" => "��",
	"555" => "��",
	"556" => "��",
	"557" => "��",
	"558" => "��",
	"559" => "��",
	"560" => "��" ,
	
	"999" => "��"
	);


	$pal=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.users where login = '".$_POST[login]."' limit 1"));
	
	
	$pals_date=array();
	$pals_date_off=array();
	$data=mysql_query("SELECT * FROM oldbk.pal_vizits where owner='".$pal[id]."' AND (`date` > ".$stamp_start." AND `date` < ".$stamp_fin.") ;");
	while($row=mysql_fetch_assoc($data))
	{
		$d=date("d.m.y",$row['date']);
		$pals_date[$d][(round_time($row['date'],15))]=$row['room'];
		$pals_date_off[$d][(round_time($row['date'],15))]=$row['chatactive'];
	}

	echo '<table border=0>
		<tr>
			<td> ���������� �� '.($pal[deal]==-1?'���������':'��������').' <h1>'.$_POST[login].'</h1></td></tr>';
	$min_15=60*15;
	$rez_per=0;
	$off_all = 0;
	foreach($pals_date as $date_date => $val)
	{
		
		$rez_day=0;
		$rez_moder_day=0;
		$rez_off = 0;
		$dd=explode('.',$date_date);
		$day_beg=mktime(0,0,0,$dd[1],$dd[0],$dd[2]);
		$day_end=mktime(23,59,59,$dd[1],$dd[0],$dd[2]);
		
		echo '<tr><td lign=left><b>'.$date_date.'</b></td></tr>';
			
		echo '<tr><td><table border=1><tr>';
		for($i=0;$i<24;$i++)
		{
			
			
			echo '<td align=middle>'.$i.'<br><table border=0 cellpadding=0 cellspacing=0><tr>';
				for($j=0;$j<4;$j++)
				{
					if(!$ch_day)
					{
						$ch_day=$day_beg;
					}
					else
					{
						$ch_day+=$min_15;
					}
				
					if($val[$ch_day])
					{

						if (!$pals_date_off[$date_date][$ch_day]) {
							$rez_off += 15;
						} else {
							echo '<td bgcolor="'.($moder_room[$val[$ch_day]]?'SkyBlue':'yellow').'" id="'.(date('d.m.y H:i',($ch_day-60*15))).'-'.(date('H:i',($ch_day))).'" style="cursor: pointer;" onmouseover="javascript:alt(\''.(date('d.m.y H:i',($ch_day-60*15))).'-'.(date('H:i',($ch_day))).'\',\''.($rooms[$val[$ch_day]]).'\');" onmouseout="javascript:hidediv();" title="'.(date('H:i',($ch_day-60*15))).'-'.(date('H:i',($ch_day))).'">&nbsp'.$room[$val[$ch_day]].'</td>';
							$rez_day+=15;
							if($moder_room[$val[$ch_day]])
							{
								$rez_moder_day+=15;
							}
						}
					}
					else
					{
						echo '<td bgcolor="gray">&nbsp</td>';
					}
					
				}
			
			echo '</tr></table></td>';
			
		}
		unset($ch_day);	
		$off_all += $rez_off;
		$rez_per+=$rez_day;
		$rez_per_moder_day+=$rez_moder_day;	
		echo '</tr></table><b>'.($rez_moder_day>0?$rez_moder_day/60:0).'. <small>('.($rez_day>0?$rez_day/60:0).')</small> <small>('.($rez_off>0?$rez_off/60:0).')</small></b> (� �����)<br><br></td></tr>';
		//echo  . ' ' . $row['date'].' '.($rooms[$row['room']]?$rooms[$row['room']]:$row['room']);
		
	}
	echo '</table>';
	echo '<b>����� ����� �� ��������� ������:'.($rez_per_moder_day>0?$rez_per_moder_day/60:0).'('.($rez_per>0?$rez_per/60:0).') ('.($off_all>0?$off_all/60:0).')</b>(� �����)</b>';
	
}
echo '</td></tr></table>';







?>