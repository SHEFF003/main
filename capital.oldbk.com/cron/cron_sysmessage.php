#!/usr/bin/php
<?php
include "/www/capitalcity.oldbk.com/cron/init.php";

 echo date("d.m.y H:i:s").'\r\n';
	

$data=mysql_query("SELECT * from ".$db_city[CITY_ID]."variables where var='snow_man' AND value=1");
if(mysql_num_rows($data)>0) //��������� �������
{
	$prise_data=mysql_query("SELECT * FROM 
		".$db_city[CITY_ID]."`newyear_snowman` 
		");
	while($row=mysql_fetch_assoc($prise_data))
	{
		$to_telo=check_users_city_data($row[owner]);
		mysql_query("
		insert into oldbk.inventory 
		(name, maxdur,cost,owner,nlevel,img,dategoden,magic,type,present,massa,goden,prototype,otdel,`group`)
		values
		('������',10,0,".$row[owner].",1,'snezhok.gif',".(time()+60*60*24*10).",1001,12,'��������',1,10,5256,5,1)");		

		 telepost_new($to_telo,"<font color=darkblue>��������� �� ��������� �� </font><span oncontextmenu=OpenMenu()>��������</span>:������� �� ��, ��� ���� ���������! ����� ��������!");			 
	}
	
	//�������� - ������� ������ ��� ���� ����
	mysql_query("TRUNCATE TABLE ".$db_city[CITY_ID]."newyear_snowman;");
	
	mysql_query("UPDATE ".$db_city[CITY_ID]."`variables` SET `value`=0 WHERE `var`='snowmans_out';");	
	mysql_query("UPDATE ".$db_city[CITY_ID]."`variables` SET value=0 WHERE var='snow_man';");
		
}


//��� � ��� ���� ������

//$TEXT='<font color=red>��������</font> <b>����� �����</b> �� ����� <a href="http://art.oldbk.com/" target=_blank> ���������� �������</a>! ������ ���������� ������ �� ������ <a href="http://art.oldbk.com/oldfm/" target=_blank>OldFM</a>! ������ ������� ������ �� ������ <a href="http://art.oldbk.com/rusfm/" target=_new>RusFM </a>! ����������� ���� ������� �����, ����������� ������� �������, ����������� � ���������� ��������� � ����������! ������� ���� � ����������� ����������! <img style=\"cursor:pointer;\" onclick=S(\"radio003\") src=http://i.oldbk.com/i/smiles/radio003.gif>';

//addch2all($TEXT);

///������ ��� ������

//mysql_query("delete dm from battle_dam_exp dm LEFT JOIN battle b ON dm.battle=b.id where b.win !=3");



?>