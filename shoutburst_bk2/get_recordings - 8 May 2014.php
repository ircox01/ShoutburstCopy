<?php
	/*$ftp_server = "92.238.96.125";
		$ftp_username = "enrich01";
		$ftp_userpass = 'enrich01#';
		$port = 22;
				
		$filepath="/"; #TODO: need to set live path

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'sftp://@'.$ftp_server.$filepath);
		curl_setopt($curl, CURLOPT_USERPWD, "$ftp_username:$ftp_userpass");
		curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
		curl_setopt($curl, CURLOPT_PORT, $port);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FTPLISTONLY, TRUE);

		$ftp_connect = curl_exec($curl);
		//var_dump($curl);
		if(curl_exec($curl) === false)
		{
			echo 'Curl error: ' . curl_error($curl);
		}*/
ini_set("display_errors",1);
try
{
	$list = array();
	
	$connection=new PDO('mysql:host=localhost;dbname=shoutburst', 'shoutburst', 'shO!tBl3$st');
	//$connection=new PDO("mysql:host=localhost;dbname=shoutburst", "root", "");
	$query="SELECT sur_id,recording FROM surveys WHERE recorded=1 AND action='record' AND downloaded=0";

	$result = $connection->query($query);
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$list=$result->fetchAll();

	if(!empty($list))
	{
		# Establish SFTP Connection
		/*$ftp_server="ftp.nextgeni.us";
		$ftp_username="pt@nextgeni.us";
		$ftp_userpass ='nextgeni123';
		$port = 22;*/
		
		$ftp_server = "92.238.96.125";
		$ftp_username = "enrich01";
		$ftp_userpass = 'enrich01#';
		$port = 22;
				
		$filepath="/"; #TODO: need to set live path

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'sftp://@'.$ftp_server.$filepath);
		curl_setopt($curl, CURLOPT_USERPWD, "$ftp_username:$ftp_userpass");
		curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
		curl_setopt($curl, CURLOPT_PORT, $port);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FTPLISTONLY, TRUE);

		$ftp_connect = curl_exec($curl);

		$updated= false;
		if($ftp_connect)
		{
			echo "Ftp connected";
			$file_list = preg_split("/[\s]+/",$ftp_connect);
			curl_close ($curl);
			
echo'---> <pre>';print_r($file_list);echo'</pre>';
			
			if(!empty($file_list))
			{
				foreach($list as $lst)
				{
					foreach ($file_list as $file)
					{
						if($file!="." || $file!=".." || $file!="")
						{
							if(preg_match("/^({$lst['recording']}.*.)/i" , $file))
							{
								$update="UPDATE surveys SET recording='{$file}', downloaded=1  WHERE sur_id=".$lst['sur_id'];
								$result = $connection->query($update);
								$updated=true;
								break;
							}
						}
					}
				}
				if($updated)
					echo "Records updated sucessfully";
			}
		}else
		{
			echo "FTP connecting error";
		}
	}else
	{
		echo "No such files found to download";
	}
}
catch(PDOException $ex)
{
  echo $ex->getMessage();
}

?>