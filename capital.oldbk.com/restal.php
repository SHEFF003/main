<?
session_start();
if (!($_SESSION['uid'] >0)) { header("Location: index.php"); die();}
include ("connect.php");
include "functions.php";
if (($user['battle']>0) OR ($user['battle_fin'] >0))  { header("Location: fbattle.php"); die(); }

if (($user['room']>=210) and ($user['room']<239))
{
	header('location: restal210.php');
	die();
}
else if (($user['room']>=240) and ($user['room']<269))
{
	header('location: restal240.php');
	die();
}
else if ((($user['room']>=270) and ($user['room']<299)) OR ($user[in_tower]==3) )
{
	header('location: restal270.php');
	die();
}
elseif ($user['room']==300)
{
	header('location: restal300.php');
	die();
}
else if ($user['room']!=200) { header("Location: main.php"); die(); }

if (($_GET['got'] && $_GET['level4']) and  ($user[battle]==0))
{
	//mysql_query("UPDATE `users` SET `users`.`room` = '21' WHERE  `users`.`id`  = '{$user[id]}' ;");
	//header('location: city.php?strah=1&tmp=0.984564546654433177');
	MoveToLoc('city.php','������ �� ����������� �����',21);
}
else
	if (($_GET['got'] && $_GET['level300']) and  ($user[battle]==0))
	{
		// ��������

		if (true)
		{
			mysql_query("UPDATE `users` SET `users`.`room` = '300' WHERE  `users`.`id`  = '{$user[id]}' ;");
			header('location: restal300.php');
			die();
		}
		else
		{
			echo "<font color=red>�������� �� ���������...</font>";
			echo '<script type="text/javascript" >alert(\'�������� �� ���������...\');</script>';
		}

	}
	else
		if (($_GET['got'] && $_GET['level210']) and  ($user[battle]==0))
		{
			// ��������
			//�������� �����
			$gerb=mysql_fetch_array(mysql_query("select * from oldbk.inventory where owner='{$user['id']}' and prototype=5111 and setsale=0 limit 1"));
			if ($gerb['id'] >0)
			{
				mysql_query("UPDATE `users` SET `users`.`room` = '210' WHERE  `users`.`id`  = '{$user[id]}' ;");
				header('location: restal210.php');
				die();
			}
			else
			{
				echo "<font color=red>�������� �� ���������...</font>";
				echo '<script type="text/javascript" >alert(\'�������� �� ���������...\');</script>';
			}

		}
		else
			if (($_GET['got'] && $_GET['level199']) and  ($user[battle]==0))
			{
				if (true)
				{
					mysql_query("UPDATE `users` SET `users`.`room` = '90' WHERE  `users`.`id`  = '{$user[id]}' ;");
					header('location: lord.php');
					die();
				}
				else

				{
					echo "<font color=red>��� �� �����...</font>";
					echo '<script type="text/javascript" >alert(\'��� �� �����...\');</script>';
				}

			}
			else
				if (($_GET['got'] && $_GET['level270']) and  ($user[battle]==0))
				{
					// ��������
					/*			if ($user[klan]!='radminion')
								{
								echo "<font color=red>�������� �� ���������...</font>";
								echo '<script type="text/javascript" >alert(\'�������� �� ���������...\');</script>';
								}
								else
					*/
					{
						mysql_query("UPDATE `users` SET `users`.`room` = '270', `id_grup`=0  WHERE  `users`.`id`  = '{$user[id]}' ;");
						header('location: restal270.php');
						die();
					}
				}
				else
					if (($_GET['got'] && $_GET['level240']) and  ($user[battle]==0))
					{
						// ��������
						/*if ($user[klan]!='radminion')
							{
							echo "<font color=red>��������...</font>";
							}
							else */
						{
							mysql_query("UPDATE `users` SET `users`.`room` = '240' ,  id_grup=0  WHERE  `users`.`id`  = '{$user[id]}' ;");
							header('location: restal240.php');
							die();
						}

					}

?>
<HTML><HEAD>
    <link rel=stylesheet type="text/css" href="http://i.oldbk.com/i/main.css">
    <link rel="stylesheet" href="/i/btn.css" type="text/css">
    <meta content="text/html; charset=windows-1251" http-equiv=Content-type>
    <META Http-Equiv=Cache-Control Content=no-cache>
    <meta http-equiv=PRAGMA content=NO-CACHE>
    <META Http-Equiv=Expires Content=0>
    <META HTTP-EQUIV="imagetoolbar" CONTENT="no">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="i/js/noty/packaged/jquery.noty.packaged.min.js"></script>
    <script type="text/javascript" src="i/js/noty/packaged/custom.js"></script>
    <script type="text/javascript" src="/i/globaljs.js"></script>
    <style>
        IMG.aFilter { filter:Glow(Color=d7d7d7,Strength=9,Enabled=0); cursor:hand }
        .noty_message { padding: 5px !important;}
    </style>
    <style type="text/css">
        img, div { behavior: url(/i/city/ie/iepngfix.htc) }
    </style>

    <SCRIPT LANGUAGE="JavaScript">
        function solo(n)
        {

			<?php if(!is_array($_SESSION['vk'])) echo'top.'; else echo'parent.'; ?>changeroom=n;
            window.location.href='restal.php?got=1&level'+n+'=1';

        }

        function imover(im)
        {
            im.filters.Glow.Enabled=true;
//	im.style.visibility="hidden";
        }

        function imout(im)
        {
            im.filters.Glow.Enabled=false;
//	im.style.visibility="visible";
        }

        function returned2(s){
            location.href='restal.php?'+s+'tmp='+Math.random();
        }




		<?

		///////////////���� ����

		{
		?>
        function refreshPeriodic()
        {
            location.href='restal.php';//reload();
            timerID=setTimeout("refreshPeriodic()",30000);
        }
        timerID=setTimeout("refreshPeriodic()",30000);

    </SCRIPT>
</HEAD>
<body leftmargin=0 topmargin=0 marginwidth=0 marginheight=0 bgcolor="#d7d7d7">
<TABLE width=100% height=100% border=0 cellspacing="0" cellpadding="0">
    <TR>
        <TD align=center></TD>
        <TD align=right>
            <div class="btn-control">
                <INPUT class="button-dark-mid btn" TYPE="button" value="���������" style="background-color:#A9AFC0" onclick="window.open('help/city<?=$user[room]?>.html', 'help', 'height=300,width=500,location=no,menubar=no,status=no,toolbar=no,scrollbars=yes')">
            </div>
        </TD></TR>
    <TR><TD align=center  valign=top colspan=2>
			<?
			function buildset($id,$img,$top,$left,$des) {
				$imga = ImageCreateFromPNG("i/city/sub/".$img.".png");
				#Get image width / height
				$x = ImageSX($imga);
				$y = ImageSY($imga);
				unset($imga);

// echo $_SERVER['HTTP_USER_AGENT'];

				if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE 6.0"))
				{
					echo "<div style=\"";
					echo "cursor: pointer; ";
					echo "position:absolute; left:{$left}px; top:{$top}px; width:{$x}; height:${y}; z-index:90; filter:progid:DXImageTransform.Microsoft.Alpha( Opacity=100, Style=0);\"
	 ><img src=\"http://i.oldbk.com/i/city/sub/{$img}.png\" width=\"${x}\" height=\"${y}\" alt=\"{$des}\" title=\"{$des}\" class=\"aFilter\" onmouseover=\"this.src='http://i.oldbk.com/i/city/sub/{$img}2.png'\" onmouseout=\"this.src='http://i.oldbk.com/i/city/sub/{$img}.png'\"
	 id=\"{$id}\" ";
					echo " onclick=\"solo({$id})\" ";
					echo "/></div>";
				}
				else
				{
					echo "<div style=\"";
					echo "cursor: pointer; ";
					echo "position:absolute; left:{$left}px; top:{$top}px; width:{$x}; height:${y}; z-index:90; \"
	 ><img src=\"http://i.oldbk.com/i/city/sub/{$img}.png\" width=\"${x}\" height=\"${y}\" alt=\"{$des}\" title=\"{$des}\" class=\"aFilter2\" onmouseover=\"this.src='http://i.oldbk.com/i/city/sub/{$img}2.png'\" onmouseout=\"this.src='http://i.oldbk.com/i/city/sub/{$img}.png'\"
	 id=\"{$id}\" ";
					echo " onclick=\"solo({$id})\" ";
					echo " /></div>";
				}



			}

			////////////////////////////////////////////////////
			/////////////������� ����

			$VR_GODA=date("n");
			$ZIMA_array=array(12,1,2);
			$VESNA_array=array(3,4,5);
			$LETO_array=array(6,7,8);
			$OSEN_array=array(9,10,11);

			if (in_array($VR_GODA,$ZIMA_array)) {
				$ZIMA=true;
			} elseif (in_array($VR_GODA,$VESNA_array)) {
				$VESNA=true;
			} elseif (in_array($VR_GODA,$OSEN_array)) {
				$OSEN=true;
			} else {
				$LETO=true;
			}
			////////////////////////////////////////////////////



			IF (CITY_ID==0)
			{
				//��������� ����/����
				if((int)date("H") > 5 && (int)date("H") < 22)
				{
					if ($ZIMA) {
						$fon = 'zima_rist_bg_day2';
					} elseif ($LETO) {
						$fon = 'cap_rist_bg_d';
					} elseif ($VESNA) {
						$fon = 'vesna_cap_bg_d2';
					} elseif ($OSEN) {
						$fon = 'osen_rist_day2';
					}
				}
				else
				{
					if ($ZIMA) {
						$fon = 'zima_rist_bg_night2';
					} elseif ($LETO) {
						$fon = 'cap_rist_bg_n2';
					} elseif ($VESNA) {
						$fon = 'vesna_cap_bg_n2';
					} elseif ($OSEN) {
						$fon = 'osen_rist_night2';
					}
				}


				echo "<table width=1><tr><td>";

				echo "<div style=\"position:relative;left: 0px;top: 0px;\" id=\"bar_box\" name=\"bar_box\">";
				progress_bar_city(1);
				echo "</div>";

				echo "<div style=\"position:relative; \" id=\"ione\">";

				if($ZIMA) //���������� ���� :)
				{
					echo "<img src=\"http://i.oldbk.com/i/snow_transp.gif\" alt=\"\" border=\"0\" style=\"position:absolute;\"  />";
				}
				echo "<img src=\"http://i.oldbk.com/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";



				if ($ZIMA) {
					buildset(4,"zima_cap_arr_uleft",240,30,"����������� �����");
					buildset(270,"zima_cap_rist_solo",210,160,"���� � ��������� ��������");

					buildset(240,"zima_cap_rist_monstr",145,570,"���� � ��������� ��������");
					buildset(102,"cap_rist_arr_right",245,708,"������ ������");

					buildset(199,"zima_lord_castle",110,310,"����� ����� �����������");

					buildset(300,"zima_cap_rist_group",243,340,"��� � ���������� ���������");
					//	buildset(210,"zima_cap_rist_group",243,340,"���� � �������� �������");


				} elseif ($LETO || $OSEN) {
					buildset(4,"cap_rist_arr_left",240,30,"����������� �����");
					buildset(270,"cap_rist_solo",210,160,"���� � ��������� ��������");

					buildset(199,"lord_castle",110,310,"����� ����� �����������");


					buildset(300,"cap_rist_group",243,340,"��� � ���������� ���������");
					//buildset(210,"cap_rist_group",243,340,"���� � �������� �������");

					buildset(240,"cap_rist_monstr",145,570,"���� � ��������� ��������");
					buildset(102,"cap_rist_arr_right",245,708,"������ ������");
				} elseif ($VESNA) {
					buildset(4,"cap_rist_arr_left",240,30,"����������� �����");
					buildset(270,"vesna_cap_rist_solo",210,160,"���� � ��������� ��������");

					buildset(199,"lord_castle",110,310,"����� ����� �����������");

					buildset(300,"vesna_cap_rist_group",243,340,"��� � ���������� ���������");
					//buildset(210,"vesna_cap_rist_group",243,340,"���� � �������� �������");



					buildset(240,"vesna_cap_rist_monstr",145,570,"���� � ��������� ��������");
					buildset(102,"cap_rist_arr_right",245,708,"������ ������");
				}

				echo "</td></tr></table>";
			}
			else if (CITY_ID==1)
			{
				//��������� ����/����
				if((int)date("H") > 5 && (int)date("H") < 22)
				{
					$fon = 'av_rist_day';
				}
				else
				{
					$fon = 'av_rist_night';
				}
				$restal1='av_rist_solo';
				$restal2='av_rist_otrjad';
				$restal3='av_rist_group';
				echo "<table width=1><tr><td>";
				echo "<div style=\"position:relative;left: 0px;top: 0px;\" id=\"bar_box\" name=\"bar_box\">";
				progress_bar_city(1);
				echo "</div>";
				echo "<div style=\"position:relative; \" id=\"ione\"><img src=\"http://i.oldbk.com/i/city/",$fon,".jpg\" alt=\"\" border=\"0\"/>";
				buildset(4,"ava_st_left",255,25,"����������� �����");
				buildset(210,$restal1,185,160,"���� � ��������� ��������");
				buildset(270,$restal2,240,330,"���� � �������� �������");
				buildset(240,$restal3,80,540,"���� � ��������� ��������");
//	buildset(102,"cap_rist_arr_right",250,708,"������ ������");
				buildset(102,"cap_rist_arr_right",255,720,"������ ������");
				echo "</td></tr></table>";
			}

			if (strlen($msg)) {
				echo '	
			<script>
				var n = noty({
					text: "'.addslashes($msg).'",
				        layout: "topLeft2",
				        theme: "relax2",
					type: "'.($typet == "e" ? "error" : "success").'",
				});
			</script>
		';
			}

			}
			?>
</body>
</html>
