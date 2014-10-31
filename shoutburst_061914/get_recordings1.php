<?php
ini_set("display_errors",1);
try
{
        $list = array();

        $connection=new PDO('mysql:host=localhost;dbname=shoutburst', 'shoutburst', 'shO!tBl3$st');
        $query="SELECT sur_id,recording,date_time FROM surveys WHERE recorded=1 AND action='record' AND downloaded=0";

        $result = $connection->query($query);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $list=$result->fetchAll();

        if(!empty($list))
        {
				// server 1
                $sftp_server = "92.238.96.125";
                $sftp_username = "enrich01";
                $sftp_userpass = 'enrich01#';
				
				// server 2
				//$sftp_server = "92.238.96.126";
                //$sftp_username = "enrich01e";
                //$sftp_userpass = 'enrich03#';

				
                $port = 22;

                $filepath="/"; #TODO: need to set live path
                $pathToDownload = 'recordings'; #TODO: need to set live path

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'sftp://@'.$sftp_server.$filepath);
                curl_setopt($curl, CURLOPT_USERPWD, "$sftp_username:$sftp_userpass");
                curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
                curl_setopt($curl, CURLOPT_PORT, $port);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl, CURLOPT_FILETIME, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_FTPLISTONLY, TRUE);

                $ftp_connect = curl_exec($curl);


                $updated= false;
                if($ftp_connect)
                {
                        echo "SFTP connected";
                        $file_list = preg_split("/[\s]+/",$ftp_connect);
                        curl_close ($curl);

                        $count=0;
						
						print_r($file_list);
                        if(!empty($file_list))
                        {
                                foreach($list as $lst)
                                {
                                        foreach ($file_list as $file)
                                        {

                                                if($file!="." || $file!=".." || $file!="")
                                                {

                                                        $recping_date = $lst['date_time'];
                                                        $parts = explode("_",$file);
                                                        $db_parts = explode("_",$lst['recording']);
                                                        $db_icon_id = $db_parts[3];
														
                                                        // OFFSET FROM VM: 1 HOUR (TODO: DYNAMIC NX)
														// server .125 is screwy cuz of 1 hr ahead
														if ($sftp_server == "92.238.96.125") {
															$db_ts = strtotime($recping_date);
														} else {
															$db_ts = strtotime($recping_date);
														}
														
                                                        if (count($parts) == 5) {
                                                                $ftp_icon_id = $parts[3];
                                                                $ftp_ts = str_replace(".wav","",$parts[4]);
                                                                $ftp_ts = substr($ftp_ts, 0, 10);
                                                                $time_diff = abs($ftp_ts - $db_ts);
																
																//echo "$ftp_icon_id / $db_icon_id / $time_diff\n";
																//echo "time diff: $time_diff\n";
                                                                // check from last 10 mins - TODO: Ensure interval is fair (assumption: icon id would not have rotated in last 10 mins)
                                                                if ($ftp_icon_id == $db_icon_id && $time_diff < 600) {
                                                                        echo "HIT! -- [$ftp_ts / $db_ts] - $file/".$lst['recording']."\n";

																		$fp = fopen($pathToDownload . '/' .$file, 'w+');
																		$curl = curl_init();
																		curl_setopt($curl, CURLOPT_URL, 'sftp://@'.$sftp_server.$filepath.'/'.$file);
																		curl_setopt($curl, CURLOPT_USERPWD, "$sftp_username:$sftp_userpass");
																		curl_setopt($curl, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
																		curl_setopt($curl, CURLOPT_PORT, $port);
																		curl_setopt($curl, CURLOPT_HEADER, 0);
																		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
																		// Set CURL to write to disk
																		curl_setopt($curl, CURLOPT_FILE, $fp);
																		// Execute download
																		curl_exec ($curl);
																		curl_close ($curl);

																		$update="UPDATE surveys SET recording='{$file}', downloaded=1, ftp_path='".$sftp_server.$filepath."' WHERE sur_id=".$lst['sur_id'];
																		
																		$result = $connection->query($update);
																		$updated=true;
																		$count++;
																		echo "Marked download {$lst['sur_id']}\n";
																		
                                                                }
                                                        }

                                                }
                                        }
                                }
                                if($updated)
                                        echo $count." File(s) downloaded.";

                        }else
                        {
                                echo "No files found on ".$ftp_server.$filepath;
                        }
                }else
                {
                        echo "SFTP connecting error";
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
