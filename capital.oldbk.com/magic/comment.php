<?php
// magic �������
if (!($_SESSION['uid'] >0)) header("Location: index.php");

if(!$_POST['target']) {
	//?><script>okno('������� �����������', 'main.php?edit=1&use=<?=$_GET['use']?>','comment')"</scirpt><?
	//die();
}  else if ( strlen($_POST['target'])>200)
		{
		echo "<font color=red>����� ������� ���������!</font> ";
		}
else if ($user[slp]>0)
		{
		echo "<font color=red>�� ��� �������� �������� ��������!</font> ";
}		
else
{
		//$magic = mysql_fetch_array(mysql_query("SELECT `chanse` FROM `magic` WHERE `id` = '9' ;"));

    /* ���� ����� ���� ������������, ������������!!! - ��� ������
	elseif($klan_abil==1)    //���� ������� ��� ������ (�������� �� �����, ���� 100%)
	{
		$int=101;
	}*/

		//echo
		echo "<font color=red><B>";
		if (!$user['battle']) { echo "�������� �� ��������� � ��������!"; }
		else {

			if (1==1) {   // 100%
				
				
				if ($user[hidden]>0 and $user[hiddenlog]=='') 	{ $user[sex]=1;	}
				elseif ($user[hidden]>0 and $user[hiddenlog]!='') {  $fuser=load_perevopl($user); $user[sex]=$fuser[sex]; }				

				if ($user['sex'] == 1) {$action="";}
				else {$action="�";}
				if ($user['id'] == 190672) {$action="�";}

				$klansm = "";
				if (strlen($user['klan'])) $klansm = ' or (owner = 0 and klan = "'.$user['klan'].'")';
				$q = mysql_query('SELECT * FROM oldbk.smiles WHERE (klan = "" and (owner = 0 OR owner = '.$user['id'].')) '.$klansm);
	
				while($ss = mysql_fetch_assoc($q)) {
					$lsml[] = "/:".$ss['name'].":/";
					$lsml2[] = "<img width=".$ss['w']." height=".$ss['h']." src=\"http://i.oldbk.com/i/smiles/".$ss['name'].".gif\">";
				}
	

				$_POST['target'] = preg_replace($lsml, $lsml2, $_POST['target'], 3);

//				addlog($user['battle'],'<span class=date>'.date("H:i").'</span> '.nick_in_battle($user,$user[battle_t]).' ���������'.$action.': <b>'.$_POST['target'].'</b><BR>');
				$btext="<b>".str_replace(':','^',$_POST['target'])."</b>";//������������� ���������
		       	       addlog($user['battle'],"!:X:".time().':'.nick_new_in_battle($user).':'.($user[sex]+700).":".$btext."\n");

				
				echo "����� ��������";
				$bet=1;
				$sbet = 1;
			}
		 	else {
				echo "������ ���������� � ����� �����...";
				$bet=1;
			}
		}
		echo "</B></FONT>";

}
?>
