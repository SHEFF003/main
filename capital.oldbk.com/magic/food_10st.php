<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }


$addstat1='sila';
$addvalue1=10;

$addstat2='lovk';
$addvalue2=10;

$addstat3='intel';
$addvalue3=10;

$addstat4='inta';
$addvalue4=10;

$addstat5='mudra';
$addvalue5=10;

$addtxt='C��� +10,�������� +10,�������� +10,��������� +10,�������� +10';

include "food_base_obed.php";
if ($bet==1)
		{
		$baff_type=3052;
		$baff_name="����� ���� �������";
		mysql_query("INSERT INTO `effects` SET `type`='{$baff_type}',`name`='{$baff_name}', `time`='1999999999', `owner`='{$user[id]}'  ;");
		include "dragon_illuz.php";
		}	
?>
