<?

if (isset($_SESSION['uid']) && in_array($_SESSION['uid'], [546433, 698171, 7937])) {
	require_once 'components/Component/Quests/dialog_checker.php';
}


//�������� � ���� ������
mysql_close($mysql);
?>