<?php
// ������
if (!isset($mlquest)) die();

$diag = <<<DIAG
<table id="questdiag" width=500 border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="http://i.oldbk.com/i/map/dialog_top.png"></td>
</tr>
<tr>
<td background="http://i.oldbk.com/i/map/dialog_middle.png"><div style="margin: 0 5px;">%TEXT%</div></td>
</tr>
<tr>
<td><img src="http://i.oldbk.com/i/map/dialog_bottom_left.png" align="bottom"></td>
</tr>
</table>
DIAG;

$diagmy = <<<DIAGMY
<table id="questdiag" width=500 border="0" cellspacing="0" cellpadding="0">
<tr>
<td><img src="http://i.oldbk.com/i/map/dialog_top.png"></td>
</tr>
<tr>
<td background="http://i.oldbk.com/i/map/dialog_middle.png"><div style="margin: 0 5px;">%TEXT%</div></td>
</tr>
<tr>
<td><img src="http://i.oldbk.com/i/map/dialog_bottom_middle.png" align="bottom"></td>
</tr>
</table>
DIAGMY;

$emptydiags = array(
	0 => array(
		0 => "������, ����� �� ��������, ��� ����?",
		11111 => "��� ������, �������, ������� �� �������. ����.",
	),
	1 => array(
		0 => "������, �� �� ������� �� �������. ����� � ��������� ���.",
		11111 => "������, � ����� �������. ����",
	),
	2 => array(
		0 => "������, ������, ��� ��������, �� � ������ ����� �� �����. ����� �������",
		11111 => "������, � ����� � ��������� ���. ����",
	),
	3 => array(
		0 => "������, �������, ��� �� ��������� � ������������ � �����. ��� ����?",
		11111 => "��� ������, �������� ����������. ����� ������, ����.",
	),
	4 => array(
		0 => "������, ������� ��� ����������, ������� ���� ����������. ������� ��� ���-������.",
		11111 => "������, �� ���� ������. ����",
	),
	5 => array(
		0 => "������, ��������� ��  � �������������, �� ���� ��� ����. ����� � ������ ���.",
		11111 => "������, ������� ���, ����� ������������. ����",
	),
);

function ShowMLDialog($sd) {
	global $diag,$diagmy,$mlquest;
	$t = explode("/",$mlquest);
	$ret = '<div style="z-index:3; position: absolute; left: '.($t[0]).'px; top: '.($t[1]).'px;">';
	list($k,$bottext) = each($sd);
	$ret .= str_replace('%TEXT%','<b>'.$bottext.'</b>',$diag);
	$ret .= '<br>';
	
	while(list($k,$v) = each($sd)) {
		$ret .= $diagmy;
		if (strpos($v,'<!-- NOLINK -->') === FALSE) {
			$ret = str_replace('%TEXT%','<a href="?qaction='.$k.'">'.$v.'</a>',$ret);
		} else {
			$ret = str_replace('%TEXT%',$v,$ret);
		}

	}
	return $ret.'</div>';
}

$show = 1;
if (isset($_GET['qaction']) && ($_GET['qaction'] == "11111" || $_GET['qaction'] == "11112")) $show = 0;

if ($show == 1) {
	if (!isset($mldiag) || !count($mldiag)) {
		$rempty = $emptydiags[mt_rand(0,count($emptydiags)-1)];
		echo ShowMLDialog($rempty);
	} else {
		echo ShowMLDialog($mldiag);
	}	
}
?>