<?
// drop list for fsystem

include "ny_events.php";



if ((time() > mktime(0,0,0,12,1,2018) && time() < mktime(23,59,59,2,28,2019) ) )
{
// ��������� ������� ��� ��������� ���������
	$DROP = true;
} else {
	$DROP=false;
}

// setings:
$MIN_DROP_DM=10; // ����������� ����
$MIN_DROP_EXP=1; // 0 - ��� ;
$MIN_DROP_LEVEL=6;
$DROP_CHANSE=50; //50% �� ��� �����

$items=array();

//list:

// ��� ������� ��������� = ��� ��������
$items[0] = array(
	"shop" => "shop", // ����� �����
	"id" => "300300" , // �� �� ������ - ����������� ������
	"maxdur" => "1",
	"cost"=>0,
	"present"=> "�����"
);

$NYDROP = false;
if ((time() > $ny_events['elkadropstart'] && time() < $ny_events['elkadropend']))
{
	$NYDROP = true;
}
if ($NYDROP ==true)
{
	$DROP = true;
	$vetgoden = $ny_events_cur_m == 12 ? mktime(23,59,59,2,28,$ny_events_cur_y+1) : mktime(23,59,59,2,28,$ny_events_cur_y);
	$vetdgoden = floor(($vetgoden - time()) / 86400);
	if ($vetdgoden < 1) $vetdgoden = 1;


	if (($data_battle['type'] == 7) and ($data_battle['win'] == $user['battle_t']) )
	{
		//������ ������ ��� ����� ��������
		$items[7] = array(
			"shop" => "shop", // ����� �����
			"id" => "50105" , //���������� �������
			"maxdur" => "5",
			"magic" => 8,
			"goden"=> 1,
			"cost"=>0,
			"present"=> "�����"
		);
	}

	$items[6] = array(
		"shop" => "shop", // ����� �����
		"id" => "20001" , // �� �� ������ - ����������� ������
		"maxdur" => "1",
		"goden"=> $vetdgoden,
		"dategoden"=> $vetgoden,
		"cost"=>1,
		"present"=> ""
	);


	$items[1] = array(
		"shop" => "shop", // ����� �����
		"id" => "20002" , // �� �� ������ - ����������� ������
		"maxdur" => "1",
		"goden"=> $vetdgoden,
		"dategoden"=> $vetgoden,
		"cost"=>1,
		"present"=> ""
	);

	$items[2] = array(
		"shop" => "shop", // ����� �����
		"id" => "20003" , // �� �� ������ - ����������� ������
		"maxdur" => "1",
		"goden"=> $vetdgoden,
		"dategoden"=> $vetgoden,
		"cost"=>1,
		"present"=> ""
	);

	$items[3] = array(
		"shop" => "shop", // ����� �����
		"id" => "20004" , // �� �� ������ - ����������� ������
		"goden"=> $vetdgoden,
		"dategoden"=> $vetgoden,
		"maxdur" => "1",
		"cost"=>1,
		"present"=> ""
	);
	$items[4] = array(
		"shop" => "shop", // ����� �����
		"id" => "20005" , // �� �� ������ - ����������� ������
		"maxdur" => "1",
		"goden"=> $vetdgoden,
		"dategoden"=> $vetgoden,
		"cost"=>1,
		"present"=> ""
	);

	$items[5] = array(
		"shop" => "shop", // ����� �����
		"id" => "20006" , // �� �� ������ - ����������� ������
		"goden"=> $vetdgoden,
		"dategoden"=> $vetgoden,
		"maxdur" => "1",
		"cost"=>0.01,
		"present"=> ""
	);

}

if  ($DROP==false)
{
	$items=array();
}

?>
