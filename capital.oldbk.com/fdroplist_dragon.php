<?
// drop list for fsystem
// for dragons!!!!!!!!!!!!!!!
//$DROP=true;
$DROP=false;

if ($DROP==true)
{
// setings:
$MIN_DROP_DM=1;
$MIN_DROP_EXP=1; 
$WIN_ONLY=true; //true- ������ ����������, false(default) - ���
$MIN_DROP_LEVEL=7;
$DROP_CHANSE=75;
$DRAGONS=true;

/*
����
 ����� �������� ������ � ������ ������ � ���� � ���������
 ���� ����� ������ ������ �������� 75%, ���� ���� �������� ��� ������� 1 �����
 �������� � ����� ��� ����� �������� 3 ��������

*/

//list:
/*
$items[0] = array(
	"shop" => "eshop", // 25% 16022 - ���������� ����������
	"id" => "16022" , // �� �� ������ - ����������� ������
	"maxdur" => "1",
	"cost"=>0,
);
*/
$items[0] = array(
	"shop" => "shop", 
	"id" => "505501", //����� �������
	"maxdur" => "1",
	"cost"=>0
);

$items[1] = array(
	"shop" => "shop", 
	"id" => "505502", //����� �������
	"maxdur" => "1",
	"cost"=>0
);

$items[2] = array(
	"shop" => "shop", 
	"id" => "505503", //	����� �������
	"maxdur" => "1",
	"cost"=>0
);

$items[3] = array(
	"shop" => "shop", 
	"id" => "505504", //���� �������
	"maxdur" => "1",
	"cost"=>0
);

$items[4] = array(
	"shop" => "shop", 
	"id" => "505505", //������ �������
	"maxdur" => "1",
	"cost"=>0
);
}
?>
