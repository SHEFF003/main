<?php
session_start();
if ( ($_SESSION['save_proto_memory']) and ($_SESSION['uid']) and  ($_SESSION['save_proto_memory']['isart']==1))
{

//��������� �������� ����� �� ����� ���������
$gif_width[1]=60;
$gif_height[1]=20;
$gif_width[2]=60;
$gif_height[2]=20;
$gif_width[3]=60;
$gif_height[3]=60;
$gif_width[4]=60;
$gif_height[4]=80;
$gif_width[5]=20;
$gif_height[5]=20;
$gif_width[8]=60;
$gif_height[8]=60;
$gif_width[9]=60;
$gif_height[9]=40;
$gif_width[10]=60;
$gif_height[10]=60;
$gif_width[11]=60;
$gif_height[11]=40;
$gif_width[27]=60;
$gif_height[27]=80;
$gif_width[28]=60;
$gif_height[28]=80;


	$error = "";
	$msg = "";
	$fileElementName = 'fileToUpload';
	if(!empty($_FILES[$fileElementName]['error']))
	{
		switch($_FILES[$fileElementName]['error'])
		{

			case '1':
				$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				break;
			case '2':
				$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				break;
			case '3':
				$error = 'The uploaded file was only partially uploaded';
				break;
			case '4':
				$error = 'No file was uploaded.';
				break;

			case '6':
				$error = 'Missing a temporary folder';
				break;
			case '7':
				$error = 'Failed to write file to disk';
				break;
			case '8':
				$error = 'File upload stopped by extension';
				break;
			case '999':
			default:
				$error = 'No error code avaiable';
		}
	}elseif(empty($_FILES['fileToUpload']['tmp_name']) || $_FILES['fileToUpload']['tmp_name'] == 'none')
	{
		$error = 'No file was uploaded..';
	}else 
	{
	$valid_types = array("gif");
	#���������� ���������� �����
        $ext = substr($_FILES['fileToUpload']['name'], 1 + strrpos($_FILES['fileToUpload']['name'], "."));
	$type_upload = GetImageSize($_FILES['fileToUpload']["tmp_name"]);
	//������ 0 �������� ������/width ����������� � ��������. ������ 1 �������� ������/height. 
	//������ 2 ��� ����, ����������� ��� �����������.1 = GIF, 
	
		if($_FILES['fileToUpload']["size"] > 80*1024)
		   {
		    $error ="������ ����� ��������� 100 ��.";
		   }
	       elseif ((!in_array($ext, $valid_types)) OR ($type_upload[2]!=1))
		   {
		         $error = "����� ��������� ������: .gif-�����.";
		   }
		elseif ($type_upload[0]!=$gif_width[$_SESSION['save_proto_memory']['type']])
		  {
		  $error = "��� ������� ���� �������� ������ ����������� ������ ���� ".$gif_width[$_SESSION['save_proto_memory']['type']]." px";
		  }   
		elseif ($type_upload[1]!=$gif_height[$_SESSION['save_proto_memory']['type']])
		  {
		  $error = "��� ������� ���� �������� ������ ����������� ������ ���� ".$gif_height[$_SESSION['save_proto_memory']['type']]." px";
		  }      
	   // ��������� �������� �� ����		   
	       elseif(is_uploaded_file($_FILES['fileToUpload']["tmp_name"]))
		   {
		     // ���� ���� �������� �������, ���������� ���
		     // �� ��������� ���������� � ��������
		     //+ ���� ����� ���
		     $new_file_name="art_".$_SESSION['uid']."_t".$_SESSION['save_proto_memory']['type']."_d".time().".gif";
		     move_uploaded_file($_FILES['fileToUpload']["tmp_name"], "/www/oldbk.com/commerce/upload/".$new_file_name);
		   } 
		else 
		   {
		      $error = "������ �������� �����";
		   }
			
			$msg .= "<img src='upload/".$new_file_name."'>";
			$_SESSION['save_proto_memory']['new_art_img']=$new_file_name;
			//for security reason, we force to remove all uploaded file
			@unlink($_FILES['fileToUpload']);		
			
			
			
			
	}		
}	
else
{
$error = "������ �������� �����";
}
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "'\n";
	echo "}";

?>