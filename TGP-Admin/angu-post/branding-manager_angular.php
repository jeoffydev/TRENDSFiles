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
    $pathUrl1 = $serverPath.'/PDFWires/'; 
    
    if($request->option == 1){
        $id = $request->id;    
        $req = $conn->prepare("SELECT * FROM ".$pdfWires." WHERE code =  :id  "); 
        $req->execute(array('id' => $id));
        $results = $req->fetchAll(); 
        $someJSON = json_encode($results);
        echo $someJSON; 
    }

    
    if($_POST['options'] == 2){ 
        if(!empty($_FILES))  
        {  
            if($_FILES['file']['type'] == 'application/pdf'){ 
                //Not more than 3MB
                if($_FILES['file']['size'] > 4194304){ 
                    $results = 1; 
                }else{
                    $pdf = $_FILES['file']['name'];
                    $stmt = $conn->prepare("SELECT * FROM  ".$pdfWires." WHERE  filename =?"); 
                    $stmt->bindParam(1, $pdf, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    //print_r($row);
                    //If no found duplicates
                    if(!$row)
                    {   
                        //If  no found duplicates then search if the PDF exist in folder
                        $pdfPath = $pathUrl1.$pdf;
                        if(file_exists($pdfPath)) {
                            $results = 2;
                        }else{
                            $results = 3;
                        }  
                    }else{
                         //If  found duplicates
                        $results = 2;
                    } 
                }
                
            }else{
                $results = 0;
            } 
            
            echo $results; 
        } 
         
    }

    if($_POST['options'] == 3){ 
        
        $results = array();
        if(!empty($_FILES))  
        {  
            $getFilename = $_FILES['file']['name']; 
            $dotSeparated = explode('.', $getFilename);


            if($_FILES['file']['type'] == 'application/pdf' ){ 
                $pdf = $_FILES['file']['name'];
                $pdfSize = $_FILES['file']['size'];
                $formattedSize = formatSizeUnits($pdfSize);
                $pdfCodeArray = explode('.', $pdf);
                $pdfCode = $pdfCodeArray[0];

                //Not more than 3MB
                if($_FILES['file']['size'] > 4194304){ 
                    $pdf = $_FILES['file']['name'];
                    $results['filename'] = $pdf;
                    $results['validate'] = 1; 
                }elseif($pdfCode != $_POST['itemCode']){
                    $results['filename'] = $pdf;
                    $results['validate'] = 4; 
                }else{
                    
                    $stmt = $conn->prepare("SELECT * FROM  ".$pdfWires." WHERE  filename =?"); 
                    $stmt->bindParam(1, $pdf, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if(!$row)
                    {   
                        //If  no found duplicates then search if the PDF exist in folder
                        $pdfPath = $pathUrl1.$pdf;
                        if(file_exists($pdfPath)) {
                            $results['filename'] = $pdf;
                            $results['validate'] = 2;
                        }else{
                            $results['filename'] = $pdf;
                            $results['validate'] = 3;

                            //Upload file
                            $uploaddir = $pathUrl1;
                            $uploadfile = $uploaddir . basename($_FILES['file']['name']);
                            $myFile = $_FILES["file"];
                
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

                            //Good 
                            $sql = $conn->prepare("INSERT INTO ".$pdfWires." (code, filename, filesize, formattedSize) VALUES(?, ?, ?, ?)"); 
                            $insert = $sql->execute(array($pdfCode, $pdf, $pdfSize, $formattedSize));  
                        }  
                    }else{
                         //If  found duplicates
                        $results['filename'] = $pdf;
                        $results['validate'] = 2;
                    } 
                }
                
            }else{
                $results['filename'] = 'PDF is over 2MB or ';
                $results['validate'] = 0;
            } 
            $someJSON = json_encode($results);
            echo $someJSON; 
        } 
    }

    if($request->options == 4){
        //echo $request->code;
        //echo $request->filename;
        $pdfPath = $pathUrl1.$request->filename;
        unlink($pdfPath);
        $command = " DELETE FROM ".$pdfWires."  WHERE code=:id";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':id', $request->code, PDO::PARAM_INT);
        $results = $stmt->execute();
        $someJSON = json_encode($results);
        echo $someJSON; 
    }
    
    if($request->options == 5){

        $stat = $request->stat;

        if($stat == 1){
            $Where = '  AND '.$pc.'.Active=1';
        }
        if($stat == 0){
                $Where = '  AND '.$pc.'.Active=0';
        } 
       /*if($stat == null){
           $Where = ''; 
       }*/
       //echo 'SELECT '.$pc.'.Code, '.$pc.'.Name, '.$pc.'.Active FROM '.$pc.' LEFT JOIN '.$pdfWires.'  ON '.$pc.'.Code=pdfWires.code WHERE '.$pdfWires.'.code IS NULL  '.$Where.' ORDER BY '.$pc.'.Code ASC ';


       //echo 'SELECT '.$pc.'.Code, '.$pc.'.Name, '.$pc.'.Active FROM '.$pc.' LEFT JOIN '.$pdfWires.'  ON '.$pc.'.Code=pdfWires.code WHERE '.$pdfWires.'.code IS NULL  '.$Where.' ORDER BY '.$pc.'.Code ASC ';
       $query = $conn->prepare('SELECT '.$pc.'.Code, '.$pc.'.Name, '.$pc.'.Active FROM '.$pc.' LEFT JOIN '.$pdfWires.'  ON '.$pc.'.Code=pdfWires.code WHERE '.$pdfWires.'.code IS NULL  '.$Where.' ORDER BY '.$pc.'.Code ASC '); 
       $query->execute(); 
       $results = $query->fetchAll(PDO::FETCH_ASSOC);   
       
       $someJSON = json_encode($results);
       echo $someJSON; 

    }

    if($request->options == 6){
        $stat = $request->stat;
        $field = $request->field;
        if($stat == 1){
            $orderTab = '  DESC ';
        }
        if($stat == 0){
            $orderTab = '  ASC  ';
        } 
        if($field == 1){
            $fieldTab = '  filesize ';
        }
        if($field == 2){
            $fieldTab = ' code  ';
            $orderTab = '  ASC  ';
        }

      // echo 'SELECT * FROM '.$pdfWires.' ORDER BY '.$fieldTab.' '.$orderTab.'';

        $query = $conn->prepare('SELECT * FROM '.$pdfWires.' ORDER BY '.$fieldTab.' '.$orderTab.''); 
        $query->execute(); 
        $results = $query->fetchAll(PDO::FETCH_ASSOC);   
        $someJSON = json_encode($results);
        echo $someJSON; 
    }



    if($_POST['options'] == 7){ 
        
        $id = $_POST['id'];
        
        $results = array();
        if(!empty($_FILES))  
        {  
            if($_FILES['file']['type'] == 'application/pdf'){ 
                $pdf = $_FILES['file']['name'];
                $pdfSize = $_FILES['file']['size'];
                $formattedSize = formatSizeUnits($pdfSize);
                $pdfCodeArray = explode('.', $pdf);
                $pdfCode = $pdfCodeArray[0];

                //Not more than 3MB
                if($_FILES['file']['size'] > 4194304){ 
                    $pdf = $_FILES['file']['name'];
                    $results['filename'] = $pdf;
                    $results['validate'] = 1; 
                }else{
                    
                    $stmt = $conn->prepare("SELECT * FROM  ".$pdfWires." WHERE  filename =?"); 
                    $stmt->bindParam(1, $pdf, PDO::PARAM_INT);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if(!$row)
                    {   
                        //If  no found duplicates then search if the PDF exist in folder
                        $pdfPath = $pathUrl1.$pdf;
                        if(file_exists($pdfPath)) {
                            $results['filename'] = $pdf;
                            $results['validate'] = 5;

                            uploadEachPDF($pathUrl1, $_FILES['file']['name'], $_FILES["file"]);  
                            $sql = "UPDATE ".$pdfWires."  SET filesize ='".$pdfSize."', formattedSize = '".$formattedSize."' WHERE filename='".$pdf."'  "; 
                            $conn->query($sql); 

                        }else{
                            $results['filename'] = $pdf;
                            $results['validate'] = 3; 
                            uploadEachPDF($pathUrl1, $_FILES['file']['name'], $_FILES["file"]);

                            //Upload file
                           /* $uploaddir = $pathUrl1;
                            $uploadfile = $uploaddir . basename($_FILES['file']['name']);
                            $myFile = $_FILES["file"];
                
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
                            $resultsA = chmod($uploaddir. $name, 0644);  */

                            //Good 
                            $sql = $conn->prepare("INSERT INTO ".$pdfWires." (code, filename, filesize, formattedSize) VALUES(?, ?, ?, ?)"); 
                            $insert = $sql->execute(array($pdfCode, $pdf, $pdfSize, $formattedSize));  
                        }  
                    }else{
                         //If  found duplicates
                        $results['filename'] = $pdf;
                        $results['validate'] = 5; 
                        
                        uploadEachPDF($pathUrl1, $_FILES['file']['name'], $_FILES["file"]);  
                        $sql = "UPDATE ".$pdfWires."  SET filesize ='".$pdfSize."', formattedSize = '".$formattedSize."' WHERE filename='".$pdf."'  "; 
                        $conn->query($sql); 
                        
                    } 
                }
                
            }else{
                $results['filename'] = $pdf;
                $results['validate'] = 0;
            } 
            $someJSON = json_encode($results);
            echo $someJSON; 
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

    function cleanValue($Val){
        $newVal = htmlspecialchars($Val, ENT_QUOTES); 
        return $newVal;
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