<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$addstat='maxhp';
$addvalue=10;
$addtxt='������� �����';
include "food_base.php"
?>
