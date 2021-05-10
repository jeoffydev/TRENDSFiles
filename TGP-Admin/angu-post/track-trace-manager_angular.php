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
        $dhl_status_table = 'dhl_status_table';
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
        $dhl_status_table = 'dhl_status_table';
    } 

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
    
    $conn = Db::getInstance();  

    
    if($request->option == 1){
        $id = $request->id;
        $arrive = $request->arrive; 

        $req = $conn->prepare("SELECT * FROM ".$dhl_status_table." WHERE id =  :id  "); 
        $req->execute(array('id' => $id));
        $results = $req->fetchAll();  
 
        $results["arriveUpdate"] = $arrive;
        
        $someJSON = json_encode($results);
        echo $someJSON; 
    }

    if($request->option == 2){
            $hawb = $request->hawb;
 
            $req = $conn->prepare("SELECT * FROM ".$dhl_status_table." WHERE HawbReference =  :id  "); 
            $req->execute(array('id' => $hawb));
            $results = $req->fetchAll(); 
    
            if($results){
                echo "1";
            }else{
                echo "0";
            }
    }

    if($request->option == 3){
        $hawbreference = $request->hawbreference;
        $departdunedin = $request->departdunedin;
        if($request->arriveddestination){
            $arriveddestination =  $request->arriveddestination;
        }else{
            $arriveddestination =  null;
        }
        if($request->headport){
            $headport =  $request->headport;
        }else{
            $headport =  null;
        }
        
        $sql = $conn->prepare("INSERT INTO ".$dhl_status_table." (HawbReference, departDunedin, arriveDestination, headport) VALUES(?, ?, ?, ?)"); 
        $insert = $sql->execute(array($hawbreference, $departdunedin, $arriveddestination, $headport));   

        if($insert){
            echo "1";
        } 

    }

    
    if($request->option == 4){
        $id = $request->id;
 
        $command = " DELETE FROM ".$dhl_status_table." WHERE  id= '".$id."' ";
        $stmt = $conn ->prepare($command); 
        $done = $stmt->execute();  

        if($done){
            echo "1";
        }
    }

    if($request->option == 5){
       
       //print_r($request);
        $comboClass = array();
        foreach ($request as $key => $object) {
            $id = $object->id;
            $hawbreference = $object->HawbReference;
            $departdunedin = $object->departDunedin;
            $headport = $object->headport;
            $arriveDestination = $object->arriveDestination;
            $comboClass[] = array($id, $hawbreference, $departdunedin, $headport, $arriveDestination);
        }  

        //print_r($comboClass);
         
        $Id = $comboClass[0][0];
        $Hawbreference = $comboClass[0][1];
        $Departdunedin = $comboClass[0][2];
        $Headport = $comboClass[0][3];
        $ArriveDestination = $comboClass[0][4];
 
       // $sql = "UPDATE ".$dhl_status_table." SET   HawbReference= '".$hawbreference."', departDunedin = '".$departdunedin."', arriveDestination = '".$arriveDestination."',  headport  = '".$headport."' WHERE id='".$id."'";
        $sql = "UPDATE ".$dhl_status_table." SET    HawbReference= '".$Hawbreference."', departDunedin = '".$Departdunedin."', headport  = '".$Headport."',  arriveDestination = '".$ArriveDestination."'  WHERE id='".$Id."'";
        $hawbUpdated = $conn->query($sql); 
        if($hawbUpdated){
            echo "1";
        }  
        //07/01/2019 5:00PM

    }
    

 
?>