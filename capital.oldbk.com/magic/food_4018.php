<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }



$addstat1='maxhp';
$addvalue1=150;

$addstat2='lovk';
$addvalue2=4;

$addstat3='expbonus';
$addvalue3=0.30; //30%

$addstat4='';
$addvalue4=0;

$addstat5='';
$addvalue5=0;

$addtxt='������� ����� +150HP,�������� +4,���� +30%';

include "food_base_obed.php"
?>
