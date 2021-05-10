<?php

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) { 
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 ); 
        die( header( 'location: /' ) ); 
    } 

      //Required for authorization
      include('../config.php');
      include('../settings.php');  
      include('../authenticate.php');   
       
      
      $headerCookies = explode('; ', getallheaders()['Cookie']); 
      
      $cookiesID = getHeaders($headerCookies); 
      $cookiesID =  rawurldecode($cookiesID); 
      $finalResult = Authenticate($cookiesID);
     
      if(!$finalResult['userID'] || $finalResult['urlAllow']  == 0):
         return http_response_code(401); 
         exit;
      endif;
      //Required for authorization

    //Mysql table settings
    if($devStuff == 1) {
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChangesDEV';
        $pageTrackerTable = 'CMSeditPageTracker';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $complianceFramework = 'complianceFramework';
        $pdfWires = 'pdfWires';
    }else{
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChanges';
        $pageTrackerTable = 'CMSeditPageTracker';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $complianceFramework = 'complianceFramework';
        $pdfWires = 'pdfWires';
    } 

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
    
    $conn = Db::getInstance();  

   
    $serverPath = $_SERVER['DOCUMENT_ROOT']; 
    $pathUrl1 = $serverPath.'/Downloads-folder/'; 
    


 
 

    if($_POST['options'] == 1){ 
        
        
        if(!empty($_FILES))  
        {  
             
            //Not more than 6MB
            if($_FILES['file']['size'] < 6291456){ 
                uploadEachPDF($pathUrl1, $_FILES['file']['name'], $_FILES["file"]);   
                echo "1"; 
            }else{
                echo "0";
            }


        }
         
    }

    if($request->option == 2){  
        if($request->fileName){
            $pdfPath = $pathUrl1.$request->fileName;
            unlink($pdfPath);
            echo "1"; 
        }
        
    }

    function uploadEachPDF($pathUrl1, $baseFilename, $file ){

        $uploaddir = $pathUrl1;
        $uploadfile = $uploaddir . basename($baseFilename);
        $myFile = $file;

        if ($myFile["error"] !== UPLOAD_ERR_OK) {
            $results = "<p>An error occurred.</p>";
            exit;
        } 
        // ensure a safe filename
        $name =   $myFile["name"];  
        // preserve file from temporary directory
        $success = move_uploaded_file($myFile["tmp_name"], $uploadfile); 
            //print_r($success);
        if (!$success) { 
            $results = "<p>Unable to save file.</p>";
            exit;
        } 
        // set proper permissions on the new file
        $resultsA = chmod($uploaddir. $name, 0644);  

        return $resultsA;

    }

  
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
 
 
?>