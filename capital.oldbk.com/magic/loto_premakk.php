<?
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die(); }

$string_p[1]='Silver';
$string_p[2]='Gold';
$string_p[3]='Platinum';
include "/www/".CITY_DOMEN."/bank_functions.php"; 

global $premlastuseid;

/*
    if (($user[prem]>$acctype) and ($acctype>0))
       	{
       	err('�� �� ������ ���������� '.$string_p[$acctype].' account, � ��� ��� ���������� '.$string_p[$user[prem]].'  account!');
      	}
else*/

// ��������� �� �������
	$get_debils=mysql_fetch_array(mysql_query("SELECT * FROM `effects` WHERE `owner` = '{$user['id']}' and type in (4999,5999,6999) limit 1;"));
	if ($get_debils['time']==1)
	{
	err("�� ������ ��� �������� ������� �������, ��������� ��� ��������!");	
	}
else
if (($acctype>=1) and ($acctype<=3))
	{
	
	if 	(($user['prem']==$acctype) or ($user['prem']==0) )
		{

							 $dill[id_city]=$user[id_city];
							 $dill[id]=450;
							 $dill[login]='KO';
							 if ($days>0)
							 	{
							 	$d=$days;
							 	}
							 	else
							 	{
							 	$d=30; // default
							 	}
							 $premlastuseid = $rowm['id'];
	     					         $exp=main_prem_akk($user,$acctype,$dill,$d);

						          if ($exp>0)
							           {
									$rec['owner']=$user[id];
									$rec['owner_login']=$user[login];
									$rec['owner_balans_do']=$user['money'];
									$rec['owner_balans_posle']=$user['money'];
									$rec['target']=$user[id];
									$rec['target_login']=$user[login];
									$actty[1]=59;
									$actty[2]=359;
									$actty[3]=358;					
									$rec['type']=$actty[$acctype] ;//������� silvera/gold/platinum �� �������
									$rec['sum_kr']=0;
									$rec['sum_ekr']=0;
									$rec['sum_kom']=0;
									$rec['item_id']=get_item_fid($rowm);
									$rec['item_name']=$rowm[name];
									$rec['item_count']=1;
									$rec['item_type']=$rowm[type];
									$rec['item_cost']=$rowm[cost];
									$rec['item_dur']=$rowm[duration];
									$rec['item_maxdur']=$rowm[maxdur];
									$rec['item_ups']=$rowm['ups'];
									$rec['item_unic']=$rowm['unik'];
									$rec['item_incmagic']=$rowm['includemagicname'];
									$rec['item_incmagic_count']=$rowm['includemagicuses'];
									$rec['item_arsenal']='';
									$rec['bank_id']=$get_my_bank['id'];
									$rec['add_info']=(date('d-m-Y',$exp));
									add_to_new_delo($rec); //�����
									$message="<font color=red>��������!</font> ��� ��������  ".$string_p[$acctype]." account �� ".$d." ���� ";
									telepost_new($user,$message);
									err("��� ��������  ".$string_p[$acctype]." account �� ".$d." ����.");
									$MAGIC_OK=1;
									$bet=1;
									$sbet = 1;  
           								
							           }		
							           else
							           {
							           err('������!');
							           }
	    		}
	    		else
	    		{
	    		
			err("����������� ��� ��������� <b>".$string_p[$user['prem']]." �������</b> ��� �������� ������� � ������� �<a href='main.php?effects=1'>���������</a>�.");		    		
	    		}
	    	
	}	
	else
	{
	err("������ ��������� ������� ��������!");	
	}
?>

