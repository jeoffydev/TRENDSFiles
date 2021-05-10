<?php

    
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
    }else{
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChanges';
        $pageTrackerTable = 'CMSeditPageTracker';
    } 

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

  
    
    $conn = Db::getInstance();  
    
    if($request->option == 1){
        $req = $conn->prepare("SELECT Code, Name, featuredItem FROM ".$pc." WHERE featuredItem > 0 AND Active != 0 ORDER BY featuredItem "); 
        $req->execute();
        $results = $req->fetchAll();
        $array = array();

        $id = $request->id;
        $code = $request->code;
        $name = $request->name;
        $featured = $request->featured;  
        //$arrs = array('Code'=> $code, 'Name'=>$name, 'featuredItem'=>$featured );
        
        //array_push($results, $arrs);
        $someJSON = json_encode($results);
        echo $someJSON;  
    }

    
    if($request->option == 2){
        $data = array();
        
        $vals =  $request->vals; 
        $valOrig =  $request->valOrig; 
        //print_r($valOrig);

        //Original  and saved featured items
        $origCount = count($valOrig);  
        if($origCount > 0){
            for ($i = 0; $i <= $origCount; $i++){
                $arrA = (array) $valOrig[$i];
                //print_r($arrA);
                 $sqlA = "UPDATE ".$pc." SET  featuredItem ='0',   
                updated = NOW()    WHERE Prim ='".$arrA['Prim']."'";
                $updateA = $conn->query($sqlA); 
               // echo $arrA['Prim']. "<br />"; 
            }
        }
            

        //New Featured updates
        $valsCount = count($vals);   
        array_unshift($vals,"");
        unset($vals[0]);
        //print_r($vals);
        if($valsCount > 0){
            for ($x = 1; $x <= $valsCount; $x++){ 
            $arrB = (array) $vals[$x]; 
            //print_r($arrB);
               $sqlB = "UPDATE ".$pc." SET  featuredItem ='" .$x. "',   
                updated = NOW()    WHERE Prim ='".$arrB['Prim']."'";
                $updateB = $conn->query($sqlB);  
            //echo $arrB['Prim']. " => " .$x. " / ";
            $success = 1;
            }
        }else{
            $success = 0;
        }
        
        $data["success"] = $success;
        echo json_encode($data);  
    }
?>
