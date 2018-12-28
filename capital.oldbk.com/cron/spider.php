<?


function get_directory_list($path)
{
$max_dir=10; //����������� ����� �� ������


if ($handle = opendir($path))
{
$c=0;
    while (false !== ($file = readdir($handle)))
    { 
        if ($file != "." && $file != "..")
        {
        //���� ����� - ��������� �� ����������� �� � ����� ����� ��������
       	   $stat=stat($path.$file);
	   $data_mod=$stat[9];
	   $data_now=time();
           if ($data_now-$data_mod > (3*24*60*60) ) 
           	{
           	//���� ��� ���
           	//������ ���� � ����� txt �����
           	$fc=0;
           	foreach (glob($path.$file."/*.txt") as $filename) 
           		{
           		$fc++;
           			//���� ���� ���� ��� �����

           			$zip_name=$filename.".gz"; 
           			$data = implode("", file($filename));
				$gzdata = gzencode($data, 9);
				$fp = fopen($zip_name, "w");
				fwrite($fp, $gzdata);
				fclose($fp);
				
				//������� ��������
				unlink($filename);
				//echo "$zip_name <br>";
	 		 	//  echo "$filename size " . filesize($filename) . "\n";
	 		 
			}
		 if ($fc>0)
		 	{
		 	echo "GZIP:".$fc."files <br>\n";
		 	//���� ������ 0 ������ � ������ �������� ������ ����� ���� +1
	 	       $c++; 
		 	}
			
    		}
    	//echo $path.$file;
    	//echo "<br>";	
        } 
     if ($c>$max_dir) return;
    }
    closedir($handle); 
} 

}

$input_dir='/www_logs3/combats_log/';
get_directory_list($input_dir);


?>