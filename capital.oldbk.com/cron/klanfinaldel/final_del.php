<?php

session_start();
	if (!($_SESSION['uid'] >0)) Redirect("index.php");

	include "connect.php";
	include "functions.php";
	
if($user[id]!=28453)
{
	die('�������� �� �������');
}	



$data=mysql_query("SELECT * FROM oldbk.clans WHERE time_to_del < '".time()."';");
while($klan=mysql_fetch_assoc($data))
{
	

}

function save_del_klan_data($kl_name,$table_name,$txt_data)
{
	if (is_dir("/www/klans/".$kl_name)) {
		//��� ����
	}
	else
	{
		mkdir("/www/klans/".$kl_name);
	}
	$fp = fopen("/www/klans/".$kl_name."/".$table_name.".txt","a"); //��������
	flock ($fp,LOCK_EX);
	foreach($txt_data as $k=>$v)
	{
		fputs((implode("{|=|}",$v))." \r\n"); //������ � ������
	}	
	fflush ($fp); //�������� ��������� ������ � ������ � ����	
	flock ($fp,LOCK_UN); //������ ����������
	fclose ($fp); //��������
}


function delete_klan($kl)
{ 
 	//�������� �����	
	include 'clouddndtrack/cloud_api.php';
	
	$data_img=mysql_query("SELECT * FROM oldbk.gellery_prot WHERE klan_owner='".$kl[id]."';");
	if((mysql_num_rows($data_img))>0)
	{
		while($img=mysql_fetch_array($data_img))
		{
			//echo $img[img];
			CloudDelete('oldbkstatic','i/sh/',$img[img]);	
			//�������� � ������
		}
	}
	
	//������ ���� �������� �� ����
	mysql_query("DELETE FROM oldbk.gellery_prot WHERE klan_owner='".$kl[id]."';");
	//===================================
	//http://i.oldbk.com/i/shadow/gTarmans.gif
	//������� ������
	$data_img=mysql_query("SELECT * FROM oldbk.users_shadows WHERE klan='".$kl[id]."';");
	if(mysql_num_rows($data_img)>0)
	{
		while($img=mysql_fetch_array($data_img))
		{
			$img[name]=($img[sex]==1?'m':'g').$img[name];
			$rr=CloudDelete('oldbkstatic','i/shadow/',$img[name].'.gif');	
			//print_r($rr);		
			//�������� � ������
		}
	}
	//������ ���� �������� �� ����
	mysql_query("DELETE FROM oldbk.users_shadows WHERE klan='".$kl[id]."';");


	//������� � �������  ������� �����
	$txt=array();
	$data=mysql_query("SELECT * FROM oldbk.eshop WHERE klan='".$kl[short]."';");
	$i=0;
	while($row=mysql_fetch_assoc($data))
	{
		$txt[$i]=$row;
		$i++;		
	}
	save_del_klan_data($kl[short],"eshop",$txt);
	mysql_query("DELETE FROM oldbk.eshop WHERE klan='".$kl[short]."';");

	//������� ������ ����� � ���� � ���� �������� � ������.
	$txt=array();
	$kl=mysql_fetch_assoc(mysql_query("SELECT * FROM oldbk.clans WHERE id='".$kl[id]."';"));
	$txt[0]=$kl;
	save_del_klan_data($kl[short],"clans",$txt);
	mysql_query("DELETE FROM oldbk.clans WHERE id='".$kl[id]."';");
	
	//�������� � ������ �������� �����
	CloudDelete('oldbkstatic','i/klan/',$kl[short].'.gif');
	CloudDelete('oldbkstatic','i/klan/',$kl[short].'_big.gif');
			

	
	//===================================
	//������� �������, � ������� ��� �� ���� (������ �� ������, ������� ��� ��������� � �������
	//������ ����� "���������" ����: ��������������� ����� �������� �� ���, ���� ����� � �����������, �� �� ������, ��� ������� ���� �� ��������� ���.
	//�������� � ������� �������� ������, �������� �� ���� (� �� ��� �� �� �������������... �� � �������� � �������)
	
	
	//��������� �������. ��� ������, ��� ��� ������ � ������� �������� ��� �������� � ���. ��� ������ � �����

	$id=array();
	$data=mysql_query("SELECT * FROM oldbk.clans_arsenal WHERE klan_name='".$kl[short]."' AND owner_original=1;");
	if(mysql_num_rows($data)>0)
	{
		while($row=mysql_fetch_assoc($data))
		{
			$id[$row[id]]=$row[id];			
		}
		$data2=mysql_query("SELECT * FROM oldbk.inventory WHERE id in (".(implode(',',$id)).");");

		for($i=0;$i<mysql_num_fields($data2);$i++)
		{
			$fields[$i]=mysql_field_name($data2, $i);
			$sql1.='`' . mysql_field_name($data2, $i) . '`, ';
		}
	 	$sql1='INSERT INTO oldbk.`inventory_aftr_del` (`deltime`, '.substr($sql1,0,-2). ') 
	 	VALUES ';
		
		while($row2=mysql_fetch_assoc($data2))
		{
			$sql1.='("'.time().'", ';
			for($iii=0;$iii<count($fields);$iii++)
			{
				$sql1.=" '".$row2[$iii]."', ";
			}
			$sql1=substr($sql1,0,-2). '),';
		}
		$sql1=substr($sql1,0,-2). ');';
		mysql_query($sql1);
		//������� ����
		mysql_query("DELETE FROM oldbk.inventory WHERE id in (".(implode(',',$id)).");");
	}
	
	//������� �  ������� ���� ��������
	$txt=array();
	$data=mysql_query("SELECT * FROM oldbk.clans_arsenal_log WHERE klan='".$kl[short]."';");
	$i=0;
	while($row=mysql_fetch_assoc($data))
	{
		$txt[$i]=$row;
		$i++;		
	}
	save_del_klan_data($kl[short],"clans_arsenal_log",$txt);
	mysql_query("DELETE FROM oldbk.clans_arsenal_log WHERE klan='".$kl[short]."';");
	
	//������ ������� � ��������
	mysql_query("DELETE FROM oldbk.clans_arsenal_access WHERE klan_id='".$kl[id]."';");
	
	
	
	//������� � ������� �����
	$txt=array();
	$data=mysql_query("SELECT * FROM oldbk.clans_kazna WHERE clan_id='".$kl[id]."';");
	$i=0;
	while($row=mysql_fetch_assoc($data))
	{
		$txt[$i]=$row;
		$i++;		
	}
	save_del_klan_data($kl[short],"clans_kazna",$txt);
	mysql_query("DELETE FROM oldbk.clans_kazna WHERE clan_id='".$kl[id]."';");
	
	
	//������� � ������� ���� �����
	$txt=array();
	$data=mysql_query("SELECT * FROM oldbk.clans_kazna_log WHERE clan_id='".$kl[id]."';");
	$i=0;
	while($row=mysql_fetch_assoc($data))
	{
		$txt[$i]=$row;
		$i++;		
	}
	save_del_klan_data($kl[short],"clans_kazna_log",$txt);
	mysql_query("DELETE FROM oldbk.clans_kazna_log WHERE clan_id='".$kl[id]."';");
	
	//������ + �����������
	
	
	$txt=array();
	$data=mysql_query("SELECT * FROM oldbk.abil_buy_clans WHERE klan_id='".$kl[id]."';");
	$i=0;
	while($row=mysql_fetch_assoc($data))
	{
		$txt[$i]=$row;
		$i++;		
	}
	save_del_klan_data($kl[short],"abil_buy_clans",$txt);
	mysql_query("DELETE FROM oldbk.abil_buy_clans WHERE klan_id='".$kl[id]."';");
	
	// ������ ������ ����
	mysql_query("DELETE FROM oldbk.chanels WHERE klan='".$kl[short]."';");
	// ������ ������ ��������
	mysql_query("DELETE FROM oldbk.chat_chanels WHERE clan1='".$kl[short]."' OR clan2='".$kl[short]."';");
	//������ �������� �������
	mysql_query("DELETE FROM oldbk.users_notepad WHERE type=1 AND owner='".$kl[id]."';");
	
	
}
	


?>