<?php
// magic �������
if (!($_SESSION['uid'] >0)) header("Location: index.php");

echo "<font color=red><B>";
if (!$user['battle']) { 
	echo "�������� �� ��������� � ��������!"; 
} else {
	if ($user['hidden']>0 and $user['hiddenlog']=='') { 
		$user['sex']=1;	
	} elseif ($user['hidden']>0 and $user['hiddenlog']!='') {  
		$fuser=load_perevopl($user); 
		$user['sex']=$fuser['sex']; 
	}

	$_POST['target'] = "�� ����� ������ ����� �� ����� ���������!";

	$btext = "<b>".str_replace(':','^',$_POST['target'])."</b>"; //������������� ���������

	addlog($user['battle'],"!:X:".time().':'.nick_new_in_battle($user).':'.($user['sex']+700).":".$btext."\n");
	echo $_POST['target'];
	$bet=1;
	$sbet = 1;

    try {
        global $app;
        $User = new \components\models\User($user);
        $Quest = $app->quest
            ->setUser($User)
            ->get();
        $Checker = new \components\Component\Quests\check\CheckerMagic();
        $Checker->magic_id = 2026;
        if(($Item = $Quest->isNeed($Checker)) !== false) {
            $Quest->taskUp($Item);
        }
    } catch (Exception $ex) {
        \components\Helper\FileHelper::writeArray(array(
            'magic' => '2026',
            'error' => $ex->getMessage(),
            'trace' => $ex->getTraceAsString()
        ), 'error_log');
    }
}

echo "</B></FONT>";
?>