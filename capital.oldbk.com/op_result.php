<?php
	if (!isset($_GET['key']) || !isset($_GET['data']) || $_GET['key'] != "25tyvu574yvmu345gkisrgnkjir") die();

	$fp = fopen ("./cron/cron_op_result","w"); //��������
	flock ($fp,LOCK_EX);
	fputs($fp ,$_GET['data']); //������ � ������
	fflush ($fp);
	flock ($fp,LOCK_UN);
	fclose ($fp);
?>