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
        $productsPricing  = 'productsPricingDEV';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $userData = 'userData';
        $freightOption = 'freightOption';
        $OnDemandStockTable = 'OnDemandStock';

    }else{
        $pc = 'productsCurrent';
        $colourSearchTable = 'colourSearch';
        $changeTypeTable = 'productChangeTypes';
        $productsChangesTable = 'productsChanges';
        $pageTrackerTable = 'CMSeditPageTracker';
        $productsPricing  = 'productsPricing';
        $productsStock = 'productsStock';
        $segmentStockCode = 'segmentStockCode';
        $userData = 'userData';
        $freightOption = 'freightOption';
        $OnDemandStockTable = 'OnDemandStock';
    } 

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
     
    $conn = Db::getInstance();  

 

    
    if($request->option == 1){
        $code = $request->code;  

        //$req = $conn->prepare("SELECT Code, PartName, ComponentCode, OnDemandStock FROM ".$productsStock." INNER JOIN  ".$OnDemandStock." ON ".$productsStock.".Code=".$OnDemandStock.".FGCode  AND ".$productsStock.".ComponentCode=".$OnDemandStock.".RMCode  WHERE ".$productsStock.".Code = :code"  ); 
        $req = $conn->prepare("SELECT Code, PartName, ComponentCode  FROM ".$productsStock." WHERE Code = :code"  ); 
        $req->execute(array('code' => $code));
        $results = $req->fetchAll();

        $reqDemand = $conn->prepare("SELECT FGCode, RMCode, OnDemandStock  FROM ".$OnDemandStockTable." WHERE FGCode = :fgcode"  ); 
        $reqDemand->execute(array('fgcode' => $code));
        $resultsDemand = $reqDemand->fetchAll();

        //print_r($resultsDemand);
        
            $json_data=array();
            /*foreach($results as $rec)//foreach loop  
            {   
                $json_array['Code']=$rec['Code'];   
                $json_array['PartName']=$rec['PartName'];  
                $json_array['ComponentCode']=$rec['ComponentCode'];  

                foreach($resultsDemand as $dem){
                    if($rec['Code'] == $dem['FGCode'] && $rec['ComponentCode'] == $dem['RMCode']){
                        $json_array['OnDemandStock'] = $dem['OnDemandStock'];  
                    }else{
                        $json_array['OnDemandStock']=null;  
                    }
                }
                
                array_push($json_data, $json_array);
            } */

           for($i = 0; $i < count($results); $i++ ){
                $json_array['Code']=$results[$i]['Code'];    
                $json_array['PartName']=$results[$i]['PartName'];   
                $json_array['ComponentCode']=$results[$i]['ComponentCode'];    
                $json_array['OnDemandStock'] = null; 
                foreach($resultsDemand as $dem){
                    if($results[$i]['Code'] == $dem['FGCode'] && $results[$i]['ComponentCode'] == $dem['RMCode']){
                        $json_array['OnDemandStock'] = $dem['OnDemandStock'];  
                    } 
                }

                array_push($json_data, $json_array);
            } 
        
        if(count($results) > 0){
                $someJSON = json_encode($json_data);
        }else{
                $someJSON = 0;
        }
        
       
        echo $someJSON;  
    }

    //Save Stocks
    if($request->option == 2){
        
        // print_r($request->StocksLists);
        // print_r($request->ondemand);
        /*if($request->ondemand){
           print_r($request->ondemand);
        } */
        $results = null;
        if($request->StocksLists){
           $count = count($request->StocksLists); 
           for($i = 0; $i < $count; $i++){

                $StockCode[$i] = $request->StocksLists[$i]->Code;
                $StockComponent[$i] = $request->StocksLists[$i]->ComponentCode;
                $StockOnDemand[$i] = $request->StocksLists[$i]->OnDemandStock;

                
                //If OnDemand Exist and Update
                if($request->ondemand->$i != "" || $request->ondemand->$i > 0){ 
                    $StockOnDemand[$i] = $request->ondemand->$i;
                    
                } 
                //echo $StockCode[$i]. " / " .$StockComponent[$i]. " / " .$StockOnDemand[$i]. "  \n ";
                //Complete check
               if($StockCode[$i] && $StockComponent[$i] ){
                    //echo $StockCode[$i]. " / " .$StockComponent[$i]. " / " .$StockOnDemand[$i]. "  \n ";
                    $stmt = $conn->prepare("SELECT * FROM ".$OnDemandStockTable." WHERE  FGCode = '".$StockCode[$i]."' AND RMCode = '".$StockComponent[$i]."'  "); 
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC); 


                    if($StockOnDemand[$i] == null || $StockOnDemand[$i] == "" || $StockOnDemand[$i] == 0 || $StockOnDemand[$i] == "-" || $StockOnDemand[$i] == " - "  || $StockOnDemand[$i] == "- "){
                        $StockOnDemand[$i] = "0";
                    }
                    
                    //If Exist then UPDATE
                    if($row > 0){ 
                        $updateStock="UPDATE ".$OnDemandStockTable."  SET OnDemandStock='".$StockOnDemand[$i]."'  WHERE FGCode = '".$StockCode[$i]."' AND RMCode = '".$StockComponent[$i]."' ";
                        if ($conn->query($updateStock) == TRUE) {
                            $results = 1; 
                        }  
        
                    }else{
                        //IF NOT EXIST THEN INSERT 
                        
                        $insertStock = $conn->prepare("INSERT INTO ".$OnDemandStockTable." (FGCode, RMCode, OnDemandStock) VALUES(?, ?, ?)"); 
                        $insertStockDone = $insertStock->execute(array($StockCode[$i], $StockComponent[$i], $StockOnDemand[$i]));   
                        $results = 1;
                    }

                }  
           }

           echo $results;  
        }
        
    }


    if($request->option == 3){

                //Delete the empty Ondemand Stock
               
                if($request->code &&  $request->rm ){ 
                    
                        $command = " DELETE FROM ".$OnDemandStockTable." WHERE FGCode=:code AND RMCode = :rmcode   ";
                        $dels = $conn ->prepare($command);
                        $dels->bindParam(':code', $request->code, PDO::PARAM_INT);
                        $dels->bindParam(':rmcode', $request->rm, PDO::PARAM_INT); 
                        $done = $dels->execute();
                        echo "1";
                    
                }

    }   
?>