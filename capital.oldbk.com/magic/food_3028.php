<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

//�� ���<br>� ������� ����� +10HP<br>� C��� +1<br>� �������� +1<br>� �������� +1<br>� ���� +10%<br>

$addstat1='maxhp';
$addvalue1=10;

$addstat2='sila';
$addvalue2=1;

$addstat3='expbonus';
$addvalue3=0.10; //10%

$addstat4='lovk';
$addvalue4=1;

$addstat5='inta';
$addvalue5=1;

$addtxt='������� ����� +10HP,C��� +1,�������� +1,�������� +1,���� +10%';

include "food_base_obed.php"
?>
