<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }


$addstat1='maxhp';
$addvalue1=30;

$addstat2='sila';
$addvalue2=1;

$addstat3='expbonus';
$addvalue3=0.10; //10%

$addstat4='lovk';
$addvalue4=1;

$addstat5='inta';
$addvalue5=1;

$addstat6='mudra';
$addvalue6=1;


$addtxt='������� ����� +30HP,C��� +1,�������� +1,�������� +1,�������� +1,���� +10%';

include "food_base_obed.php";
if ($bet==1) {
	include "dragon_illuz.php";
}
?>
