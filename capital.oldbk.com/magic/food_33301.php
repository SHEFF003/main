<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$addstat['maxhp']=$user['maxhp']*0.5;
$addstat['sila']=2;
$addstat['lovk']=2;
$addstat['inta']=2;
$addstat['intel']=2;
$addstat['mudra']=2;
$addstat['expbonus']=1; //100%
$addtxt='������� ����� +50%, C��� +2, �������� +2,��������� +2, �������� +2, �������� +2, ���� +100%';
include "food_base_time.php";
	

?>
 