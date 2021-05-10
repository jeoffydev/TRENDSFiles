<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	$errororr1 = 0;
	$errororr2 = 0;
	$errororr3 = 0;

	function human_filesize($bytes, $decimals = 2,$format = "GB") {
		if($format == "GB"){
			$final = (($bytes /1024)/1024)/1024;
		} else {
			$final = ($bytes /1024)/1024;
		}
		return round($final,$decimals).$format;
		//$size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
		//$factor = floor((strlen($bytes) - 1) / 3);
		//return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

	function dbPuller($queryInput,$queryMode,$showOutput=1,$frame=0) {
		//if($showOutput == 1){ debug_to_console( "queryInput: ".$queryInput);}
		$rnd1 = rand(1,5);
		do {
		  $rnd2 = rand(1,5);
		} while ($rnd1 == $rnd2);
		
		$queryTXT = str_replace(array("'", "\"", "&quot;","\n", "\t"), "", $queryInput);
		
		//if($showOutput == 1){ debug_to_console( "queryTXT: ".$queryTXT);}
		
		$SQLHost = "localhost";
	
		$SQLNameRD = "trends_WebView".$rnd1;
		$SQLNameRDBackup = "trends_WebView".$rnd2;
		$SQLPwdRD = "JtmNbJ06yA";
		
		$SQLNameWR = "trends_WebWrite";
		$SQLPwdWR = "cwpTtvtC5VkA3kOVyFko";
		
		$SQLdb = "trends_collection";
		
		if($queryMode == 0) { //read mode
			$userUsed = "Main";
			//if($showOutput == 1){ debug_to_console( "READ MODE, Main: ".$SQLNameRD.", Backup: ".$SQLNameRDBackup.", Used: ".$userUsed.", Query: ".$queryTXT);}
			
			$global_dbh = mysqli_connect($SQLHost, $SQLNameRD, $SQLPwdRD, $SQLdb, 3306);
			
			$queryOutput = mysqli_query( $global_dbh, $queryInput);
			
			global $rowsReturned;
			$rowsReturned = mysqli_num_rows($queryOutput);
			
			if(!$queryOutput) {
				$global_dbh = mysqli_connect($SQLHost, $SQLNameRDBackup, $SQLPwdRD, $SQLdb, 3306);
				$queryOutput = mysqli_query( $global_dbh, $queryInput);
				$userUsed = "Backup";
			}
			if($showOutput == 1){
				//debug_to_console( "Number of Rows returned: ".$rowsReturned);
			}
			
		} else { //write mode
			//if($showOutput == 1){ debug_to_console( "WRITE MODE, Query: ".$queryTXT);}
			$global_dbh = mysqli_connect($SQLHost, $SQLNameWR, $SQLPwdWR, $SQLdb, 3306);
			$queryOutput = mysqli_query( $global_dbh, $queryInput);
			if($queryMode == 2) {
				$queryOutput = mysqli_insert_id($global_dbh);
				//if($showOutput == 1){ debug_to_console( "New Primary key: ".$queryOutput);}
			}
		}
		
		if(!$queryOutput) {
			if($showOutput == 1){
				//debug_to_console("Error: ".mysqli_error($queryOutput));
				error_log("mySQLi Error: '".$queryInput."' (".$_SERVER['REMOTE_ADDR'].", )".basename($_SERVER['PHP_SELF']),0);
			}
			if($queryMode == 0) {
				if($frame == 0) {
					include("Error.php");
				} else {
					include("ErrorFrame.php");
				}
			} else {
				echo "<div class='bodyText'>There was an database issue, please try again.</div>";
			}
			exit;	
		}
		
		//mysqli_close($global_dbh);
		//mysqli_close($global_dbh_Backup);
		
		return $queryOutput;
	}
	
	$tableItems = "productsCurrent";
	
	/* creates a compressed zip file */
	function create_zip($files = array(),$destination = '',$overwrite = false) {
		
		$zipStatuses[0] = "No error";
		$zipStatuses[1] = "Multi-disk zip archives not supported";
		$zipStatuses[2] = "Renaming temporary file failed";
		$zipStatuses[3] = "Closing zip archive failed";
		$zipStatuses[4] = "Seek error";
		$zipStatuses[5] = "Read error";
		$zipStatuses[6] = "Write error";
		$zipStatuses[7] = "CRC error";
		$zipStatuses[8] = "Containing zip archive was closed";
		$zipStatuses[9] = "No such file";
		$zipStatuses[10] = "File already exists";
		$zipStatuses[11] = "Can't open file";
		$zipStatuses[12] = "Failure to create temporary file";
		$zipStatuses[13] = "Zlib error";
		$zipStatuses[14] = "Malloc failure";
		$zipStatuses[15] = "Entry has been changed";
		$zipStatuses[16] = "Compression method not supported";
		$zipStatuses[17] = "Premature EOF";
		$zipStatuses[18] = "Invalid argument";
		$zipStatuses[19] = "Not a zip archive";
		$zipStatuses[20] = "Internal error";
		$zipStatuses[21] = "Zip archive inconsistent";
		$zipStatuses[22] = "Can't remove file";
		$zipStatuses[23] = "Entry has been deleted";
		
		//if the zip file already exists and overwrite is false, return false
		if(file_exists($destination) && !$overwrite) { return false; }
		//vars
		$valid_files = array();
		//if files were passed in...
		if(is_array($files)) {
			//cycle through each file
			foreach($files as $file) {
				//make sure the file exists
				if(file_exists($file)) {
					$valid_files[] = $file;
				}
			}
		}
		//if we have good files...
		if(count($valid_files)) {
			//create the archive
			$zip = new ZipArchive();
			if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				return false;
			}
			//add the files
			foreach($valid_files as $file) {
				$new_filename = substr($file,strrpos($file,'/') + 1);
				$zip->addFile($file,$new_filename);
			}
			//debug			
			echo '   Zip contains ',$zip->numFiles,' files with a status of ',$zipStatuses[$zip->status];
			$outputr = $zip->status;
			
			//close the zip -- done!
			$zip->close();
			
			//check to make sure the file exists
			return $outputr;
		} else {
			return false;
		}
	}
	
	//-------------------------------------------------------------------------------------------------------------------------------------
	
	$timeStart1 = time();
	$timeStartReadable1 = date("F j, Y, g:i a", $timeStart1);
	echo "Zip Maker NZ--------------------------------------------------------\n";
	echo "   Start Time: ".$timeStartReadable1."\n";
	
	//$query1 = "SELECT Code, Status, ImageCount, Active FROM ".$tableItems." WHERE Active != 0 AND Status NOT LIKE 'D' AND ExclusiveItem != '1' ORDER BY Code";
	$query1 = "SELECT Code, Status, ImageCount, Active FROM ".$tableItems." WHERE Active != 0 AND Status NOT LIKE 'D' AND ExclusiveItem != '1' ORDER BY Code";
	
	$result1 = dbPuller($query1,0);
	
	$files_to_zip1 = array();
	
	while($dat1 = mysqli_fetch_array($result1)) {

		$x1 = 0;
		while($x1 <= $dat1['ImageCount']) {
			array_push($files_to_zip1, "/home/www/trends.nz/public_html/Images/ProductImg/".$dat1['Code']."-".$x1.".jpg");
			//echo("Images/ProductImg/".$dat1['Code']."-".$x1.".jpg\n");
			$x1++;
		}
	}
	
	
	//if true, good; if false, zip creation failed
	$oldFile1 = "/Images/Products.zip";
	$newFile1 = "/Images/Products-New.zip";
	
	if(file_exists("/home/www/trends.nz/public_html".$newFile1)) {
		echo "   Temp file exists, trying to delete\n";
		if(unlink("/home/www/trends.nz/public_html".$newFile1)) {
			echo "      Sucessfully deleted '".$newFile1."'\n";
		} else {
			echo "      Something went wrong :/\n";
			$errororr1 = 1;
		}
	}
	
	$result1 = create_zip($files_to_zip1,"/home/www/trends.nz/public_html".$newFile1);
	
	
	if(($result1 == 0) && ($errororr1 == 0)){
		echo "\n   File size of '".$oldFile1."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$oldFile1),3)."\n";
		echo "   File size of '".$newFile1."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$newFile1),3)."\n";
		
		echo "   Trying to delete old file\n";
		if(unlink("/home/www/trends.nz/public_html".$oldFile1)) {
			echo "      Sucessfully deleted '".$oldFile1."'\n";
		} else {
			echo "      Something went wrong :/\n";
			$errororr1 = 1;
		}
		
		rename("/home/www/trends.nz/public_html".$newFile1,"/home/www/trends.nz/public_html".$oldFile1);
		echo "   Renaming '".$newFile1."'\n      to '".$oldFile1."'\n";
		echo "   File size of '".$oldFile1."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$oldFile1),3)."\n";
	} else {
		if($result1 == 0) {
			echo "   Zip Error: ".$result1."\n";
		} else {
			echo "   File Error\n";
		}
	}
	
	$timeEnd1 = time();
	$timeEndReadable1 = date("g:i a", $timeEnd1);
	$timeTime1 = ltrim(date('i:s',$timeEnd1 - $timeStart1));
	echo "   End Time: ".$timeEndReadable1."\n";
	echo "   Time Taken: ".$timeTime1."\n";
	echo "-----------------------------------------------------------------------\n";
	echo "\n";
	//-------------------------------------------------------------------------------------------------------------------------------------
	
	$timeStart2 = time();
	$timeStartReadable2 = date("F j, Y, g:i a", $timeStart2);
	echo "Zip Maker New Files NZ----------------------------------------------\n";
	echo "   Start Time: ".$timeStartReadable2."\n";
	
	//$query2 = "SELECT Code, Status, ImageCount, Active FROM ".$tableItems." WHERE Status LIKE 'N' AND Active != 0 AND ExclusiveItem != '1' ORDER BY Code";
	$query2 = "SELECT Code, Status, ImageCount, Active FROM ".$tableItems." WHERE Status LIKE 'N' AND Active != 0  ORDER BY Code";

	$result2 = dbPuller($query2,0);
	
	$files_to_zip2 = array();
	
	while($dat2 = mysqli_fetch_array($result2)) {
		$x2 = 0;
		while($x2 <= $dat2['ImageCount']) {
			array_push($files_to_zip2,  "/home/www/trends.nz/public_html/Images/ProductImg/".$dat2['Code']."-".$x2.".jpg");
			//echo("Images/ProductImg/".$dat2['Code']."-".$x2.".jpg\n");
			$x2++;
		}
	}
	
	
	//if true, good; if false, zip creation failed
	$oldFile2 = "/Images/New-Products.zip";
	$newFile2 = "/Images/New-Products-New.zip";
	
	if(file_exists( "/home/www/trends.nz/public_html".$newFile2)) {
		echo "   Temp file exists, trying to delete\n";
		if(unlink( "/home/www/trends.nz/public_html".$newFile2)) {
			echo "      Sucessfully deleted '".$newFile2."'\n";
		} else {
			echo "      Something went wrong :/\n";
			$errororr2 = 1;
		}
	}
	
	$result2 = create_zip($files_to_zip2, "/home/www/trends.nz/public_html".$newFile2);
	
	
	if(($result2 == 0) && ($errororr2 == 0)){
		echo "\n   File size of '".$oldFile2."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$oldFile2),0,"MB")."\n";
		echo "   File size of '".$newFile2."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$newFile2),0,"MB")."\n";
		
		echo "   Trying to delete old file\n";
		if(unlink( "/home/www/trends.nz/public_html".$oldFile2)) {
			echo "      Sucessfully deleted '".$oldFile2."'\n";
		} else {
			echo "      Something went wrong :/\n";
			$errororr2= 1;
		}
		
		rename("/home/www/trends.nz/public_html".$newFile2,"/home/www/trends.nz/public_html".$oldFile2);
		echo "   Renaming '".$newFile2."'\n      to '".$oldFile2."'\n";
		echo "   File size of '".$oldFile2."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$oldFile2),0,"MB")."\n";
	} else {
		if($result2 == 0) {
			echo "   Zip Error: ".$result2."\n";
		} else {
			echo "   File Error\n";
		}
	}
	
	$timeEnd2 = time();
	$timeEndReadable2 = date("g:i a", $timeEnd2);
	$timeTime2 = ltrim(date('i:s',$timeEnd2 - $timeStart2));
	echo "   End Time: ".$timeEndReadable2."\n";
	echo "   Time Taken: ".$timeTime2."\n";
	echo "-----------------------------------------------------------------------\n";
	echo "\n";
	//-------------------------------------------------------------------------------------------------------------------------------------
	
	$timeStart3 = time();
	$timeStartReadable3 = date("F j, Y, g:i a", $timeStart3);
	echo "Zip Maker Exclusive NZ----------------------------------------------\n";
	echo "   Start Time: ".$timeStartReadable3."\n";
	
	$query3 = "SELECT Code, Status, ImageCount, Active FROM ".$tableItems." WHERE Status LIKE 'N' AND Active != 0 AND ExclusiveItem = '1' ORDER BY Code";
	
	$result3 = dbPuller($query3,0);
	
	if(mysqli_num_rows($result3) !==0) {
		$files_to_zip3 = array();
		
		while($dat3 = mysqli_fetch_array($result3)) {
			$x3 = 0;
			while($x3 <= $dat3['ImageCount']) {
				array_push($files_to_zip3,  "/home/www/trends.nz/public_html/Images/ProductImg/".$dat3['Code']."-".$x3.".jpg");
				//echo("Images/ProductImg/".$dat3['Code']."-".$x3.".jpg\n");
				$x3++;
			}
		}
		
		
		//if true, good; if false, zip creation failed
		$oldFile3 = "/Images/Exclusive-Products.zip";
		$newFile3 = "/Images/Exclusive-Products-New.zip";
		
		if(file_exists( "/home/www/trends.nz/public_html".$newFile3)) {
			echo "   Temp file exists, trying to delete\n";
			if(unlink( "/home/www/trends.nz/public_html".$newFile3)) {
				echo "      Sucessfully deleted '".$newFile3."'\n";
			} else {
				echo "      Something went wrong :/\n";
				$errororr3 = 1;
			}
		}
		
		$result3 = create_zip($files_to_zip3,"/home/www/trends.nz/public_html".$newFile3);
		
		
		if(($result3 == 0) && ($errororr3 == 0)){
			echo "\n   File size of '".$oldFile3."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$oldFile3),0,"MB")."\n";
			echo "   File size of '".$newFile3."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$newFile3),0,"MB")."\n";
			
			echo "   Trying to delete old file\n";
			if(unlink( "/home/www/trends.nz/public_html".$oldFile3)) {
				echo "      Sucessfully deleted '".$oldFile3."'\n";
			} else {
				echo "      Something went wrong :/\n";
				$errororr3= 1;
			}
			
			rename("/home/www/trends.nz/public_html".$newFile3,"/home/www/trends.nz/public_html".$oldFile3);
			echo "   Renaming '".$newFile3."'\n      to '".$oldFile3."'\n";
			echo "   File size of '".$oldFile3."': ".human_filesize(filesize("/home/www/trends.nz/public_html".$oldFile3),0,"MB")."\n";
		} else {
			if($result3 == 0) {
				echo "   Zip Error: ".$result3."\n";
			} else {
				echo "   File Error\n";
			}
		}
	} else {
		echo "   Nothing to Zip!\n";
	}
	$timeEnd3 = time();
	$timeEndReadable3 = date("g:i a", $timeEnd3);
	$timeTime3 = ltrim(date('i:s',$timeEnd3 - $timeStart3));
	echo "   End Time: ".$timeEndReadable3."\n";
	echo "   Time Taken: ".$timeTime3."\n";
	echo "-----------------------------------------------------------------------\n";
?>