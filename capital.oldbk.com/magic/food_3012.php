<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

//�� ���<br>� ������� ����� +20HP<br>� C��� +1<br>� ���� +10%<br>

$addstat1='maxhp';
$addvalue1=20;

$addstat2='sila';
$addvalue2=1;

$addstat3='expbonus';
$addvalue3=0.10; //10%

$addstat4='';
$addvalue4=0;

$addstat5='';
$addvalue5=0;

$addtxt='������� ����� +20HP,C��� +1,���� +10%';

include "food_base_obed.php"
?>
