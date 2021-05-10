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
        $pc = 'productsCurrentDEV';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChangesDEV';
        $pageTrackerTable = 'CMSeditPageTracker';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $complianceFramework = 'complianceFramework';
    }else{
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChanges';
        $pageTrackerTable = 'CMSeditPageTracker';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $complianceFramework = 'complianceFramework';
    } 

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
    
    $conn = Db::getInstance();  

   
    $serverPath = $_SERVER['DOCUMENT_ROOT']; 
    $pathUrl1 = $serverPath.'/compliancePDF/'; 
    
    if($request->option == 1){
        $id = $request->id;    
        $req = $conn->prepare("SELECT * FROM ".$complianceFramework." WHERE itemCode =  :id ORDER BY sort ASC"); 
        $req->execute(array('id' => $id));
        $results = $req->fetchAll(); 
        $someJSON = json_encode($results);
        echo $someJSON; 
    }

    
    if($_POST['options'] == 2){ 

        $PDFName = $_POST['PDFName'];    
        $PDFDesc = $_POST['PDFDesc']; 
        $PDFCode = $_POST['PDFCode']; 
        
        if(!empty($_FILES))  
        {    
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
            $results = chmod($uploaddir. $name, 0644); 
 

        }else{
            $name =   null;  
        }    

        $uniqid = uniqid();
        $stmt = $conn->prepare("SELECT max(sort) FROM ".$complianceFramework." WHERE itemCode=?"); 
        $stmt->bindParam(1, $PDFCode, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        
        if($row['max(sort)'] == 0){
            $sort = 1;
        }else{
            $sort = $row['max(sort)'] + 1;
        }
        //insert the Data of compliance PDF and filename
         
        $sql = $conn->prepare("INSERT INTO ".$complianceFramework." (itemCode, standard, pdfFilename, sort, uniqueID, description) VALUES(?, ?, ?, ?, ?, ?)"); 
        $insertResults = $sql->execute(array($PDFCode, $PDFName, $name, $sort, $uniqid, $PDFDesc));  
        $results = "okay";   

        $someJSON = json_encode($results);
        echo $someJSON; 
    }

    //Alternative 
    if($request->options == 4){ 

        $PDFName = $request->PDFName;    
        $PDFDesc = $request->PDFDesc; 
        $PDFCode = $request->PDFCode;  
        $uniqid = uniqid();
        $stmt = $conn->prepare("SELECT max(sort) FROM ".$complianceFramework." WHERE itemCode=?"); 
        $stmt->bindParam(1, $PDFCode, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        
        if($row['max(sort)'] == 0){
            $sort = 1;
        }else{
            $sort = $row['max(sort)'] + 1;
        }
        //insert the Data of compliance PDF and filename
         
        $sql = $conn->prepare("INSERT INTO ".$complianceFramework." (itemCode, standard, pdfFilename, sort, uniqueID, description) VALUES(?, ?, ?, ?, ?, ?)"); 
        $insertResults = $sql->execute(array($PDFCode, $PDFName, $name, $sort, $uniqid, $PDFDesc));  
        $results = "okay";   

        $someJSON = json_encode($results);
        echo $someJSON; 
    }


    if($_POST['options'] == 3){ 
        //Validation on change/upload
        if(!empty($_FILES))  
        {  
            if($_FILES['file']['type'] == 'application/pdf'){ 
                //Not more than 3MB
                if($_FILES['file']['size'] > 2097152){ 
                    $results = 1; 
                }else{
                    $pdf = $_FILES['file']['name'];
                    $stmt = $conn->prepare("SELECT * FROM  ".$complianceFramework." WHERE  pdfFilename =?"); 
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
            $someJSON = json_encode($results);
            echo $someJSON; 
        }    
    }


    //Ordering 
    if($request->options == 5){ 
        $PDFCode = $request->PDFCode;    
        $PDFOrder = $request->PDFOrder; 
        array_unshift($PDFOrder,"");
        unset($PDFOrder[0]);
        //print_r($PDFOrder);
        $countI = count($PDFOrder); 
        $counter=1;
      foreach($PDFOrder as $key=>$val)
        {    
             $query="UPDATE ".$complianceFramework."  SET sort=".$counter." WHERE id=".$PDFOrder[$counter]->id;
            if ($conn->query($query) == TRUE) {
                $sorted = 1;
            } else {
                $sorted = 0;
            } 
            
            $counter++;
        }
        $results = "update_sort";
        $someJSON = json_encode($results);
        echo $someJSON;  
    }

    
    if($request->options == 6){
        $pdfID = $request->pdfID; 
        $field = $request->field; 
        $pdfValue = $request->pdfValue;
         
        $query="UPDATE ".$complianceFramework."  SET ".$field."='".$pdfValue."' WHERE id=".$pdfID;

        if ($conn->query($query) == TRUE) {
            $results = "update_standard";
        } else {
            $results = "failed";
        } 

        
        $someJSON = json_encode($results);
        echo $someJSON;  
    }

    if($request->options == 7){
        $pdfID = $request->pdfID; 
        $pdfFileName = $request->pdfFileName; 
        $uploaddir = $pathUrl1;
        $uploadfile = $uploaddir . $pdfFileName;
        unlink($uploadfile);
        $query="UPDATE ".$complianceFramework."  SET  pdfFilename= null  WHERE id=".$pdfID; 
        if ($conn->query($query) == TRUE) {
            $results = "removed_pdf_info_file";
        } else {
            $results = "failed";
        } 
        $someJSON = json_encode($results);
        echo $someJSON;  
    }

    if($_POST['options'] == 8){ 

        $pdfFilename = $_POST['pdfFilename'];    
        $pdfID = $_POST['pdfID']; 
        $PDFCode = $_POST['PDFCode']; 
        
        if(!empty($_FILES))  
        {    
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

            $query="UPDATE ".$complianceFramework."  SET  pdfFilename='".$name."'  WHERE id=".$pdfID; 
            if ($conn->query($query) == TRUE) {
                $results = "save_new_pdf";
            } else {
                $results = "failed";
            } 
        }  
        $someJSON = json_encode($results);
        echo $someJSON; 
    }

    //Delete all compliance and PDF file
    if($request->options == 9){
        $pdfids = $request->pdfids;
        $pdfFile = $request->pdfFile;

        $command = " DELETE FROM ".$complianceFramework."  WHERE id=:id";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':id', $pdfids, PDO::PARAM_INT);
        $done = $stmt->execute();

        if($pdfFile){
            $uploaddir = $pathUrl1;
            $uploadfile = $uploaddir . $pdfFile;
            unlink($uploadfile);
        }
    }
    

    function uploadPDFFile($file, $path){
                if(move_uploaded_file($file, $path))  
                {   
                    $msg =  'File Uploaded';    
                }else{
                    $msg =  "Not uploaded";
                } 
                return $msg;  
    }
     

    function cleanValue($Val){
        $newVal = htmlspecialchars($Val, ENT_QUOTES); 
        return $newVal;
    }
 
 
?>