<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$addstat='expbonus';
$addvalue=0.10; //10%
$addtxt='����';
include "food_base.php"
?>
