<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

//�� ���<br>� ������� ����� +70HP<br>� C��� +2<br>� �������� +2<br>� �������� +2<br>� ���� +20%<br>

$addstat1='maxhp';
$addvalue1=70;

$addstat2='sila';
$addvalue2=2;

$addstat3='expbonus';
$addvalue3=0.20; //10%

$addstat4='lovk';
$addvalue4=2;

$addstat5='inta';
$addvalue5=2;

$addtxt='������� ����� +70HP,C��� +2,�������� +2,�������� +2,���� +20%';

include "food_base_obed.php"
?>
