<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }


$addstat1='maxhp';
$addvalue1=100;

$addstat2='sila';
$addvalue2=3;

$addstat3='expbonus';
$addvalue3=0.20; //20%


$addtxt='������� ����� +100HP, C��� +3, ���� +20%';

include "food_base_obed.php"
?>
