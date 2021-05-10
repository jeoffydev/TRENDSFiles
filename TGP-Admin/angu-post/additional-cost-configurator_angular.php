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
 
     
        $pc = 'productsCurrent';
        
        $productsCurrentTable = 'productsCurrent';
        $productsPricingTable = 'productsPricing'; 

        $productsCurrentTableDEV = 'productsCurrentDEV';
        $productsPricingTableDEV = 'productsPricingDEV';
       
         
        $additionalOptionsTemp = 'additionalOptionsTemp';
        $additionalOptions = 'additionalOptions';
    

     
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

 
   
    $conn = Db::getInstance();  

   
    $serverPath = $_SERVER['DOCUMENT_ROOT']; 
    $pathUrl = $serverPath.'/TGP-Admin/json/'; 



    /********* Component API  ******************/
     include("component_api.php");
     
   /********* Component API  ******************/

   

    if($request->option == 1){  
       $id= $request->id;
       $code= $request->code;

        $results['componentAPI'] =  Components($code);

        //echo "YEEES " .$id." / " . $code;

        $req = $conn->prepare("SELECT * FROM ".$additionalOptionsTemp." WHERE   ProductCode = ".$code."  ORDER BY orderRow ASC  ");  
        $req->execute();
        $results['dataItems'] = $req->fetchAll();

        /*
        if(count($results['dataItems']) > 0){ 
            $results['found'] = 1;
        }else{
            $results['found'] = 0;
        }  */

        //Get Branding Options
        $reqBrand = $conn->prepare("SELECT * FROM ".$productsCurrentTable." WHERE    Code = ".$code."    ");  
        $reqBrand->execute();
        $resultsBranding = $reqBrand->fetch(PDO::FETCH_ASSOC);

         
        for($b = 1; $b < 10; $b++){ 
            if($resultsBranding['PrintType'.$b]){
                $brandArray[] =  array('pm' => $resultsBranding['PrintType'.$b], 'pa' =>   $resultsBranding['PrintDescription'.$b]); 
            }  
        }  
        $brandArray[] =  array('pm' => 'None', 'pa' =>   '');

        $results['brandingOptions'] = $brandArray;
       
       
        //Get the pricing type
        $reqPT = $conn->prepare("SELECT DISTINCT PricingType FROM ".$productsPricingTable." WHERE   Coode = ".$code."  ORDER BY PriceOrder ASC  ");  
        $reqPT->execute();
        $results['pricingTypeList'] = $reqPT->fetchAll(); 
        

         

        $someJSON = json_encode($results);
        echo $someJSON;  
    }

    // Number 8 here transfered 
    if($request->option == 8){  

        $itemCode = $request->itemCode; 
        $PriceType = $request->PriceType;

        $req = $conn->prepare("SELECT * FROM ".$additionalOptionsTemp." WHERE   ProductCode = ".$itemCode." AND PricingType = '".$PriceType."'  ORDER BY orderRow ASC  ");  
        $req->execute();
        $results['dataItems'] = $req->fetchAll();
 
         
        /*
        $x = 0;
        
        foreach($results['dataItems'] as $row){
            $search = $conn->prepare('SELECT * FROM '.$additionalOptions.'  WHERE   ProductCode = '.$row['ProductCode'].' AND additionalCostID = "'.$row['additionalCostID'].'"  '); 
            $search->execute();
            $row = $search->fetch(PDO::FETCH_ASSOC); 
            if($row > 0)
            {
                $results['dataItems'][$x]['ConvertedRow'] = 1;
            }else{
                $results['dataItems'][$x]['ConvertedRow'] = 0;
            }  
           $x++;
        } */

        $getConvert =  $conn->prepare("SELECT Converted FROM ".$productsPricingTable." WHERE   Coode = ".$itemCode." AND PricingType = '".$PriceType."'       ");
        $getConvert->execute();  
        $resultsConvert = $getConvert->fetchAll();
        //print_r($results['convertedItem']);

        $results['ConvertedRow'] = 0;
        if(count($resultsConvert) > 0){ 
            foreach($resultsConvert as $row){ 
                if($row['Converted'] == 1){
                    $results['ConvertedRow'] = 1;
                }
            }
        }else{ 
            if($resultsConvert[0] == 1){
                $results['ConvertedRow'] = 1;
            } 
        }  
        if(count($results['dataItems']) > 0){ 
            $results['found'] = 1;
        }else{
            $results['found'] = 0;
        }  
 

        $someJSON = json_encode($results);
        echo $someJSON;  


    }

    if($request->option == 2){  
        $pricetype= $request->pricetype;
        $code= $request->code;
        $brand= $request->brand;


        $req = $conn->prepare("SELECT * FROM ".$additionalOptionsTemp." WHERE   ProductCode = ".$code." AND PricingType = '".$pricetype."' AND brandingMethod = '".$brand."' ");  
        $req->execute();
        $results = $req->fetch(PDO::FETCH_ASSOC);

        $result = array();
        
        /*if($results > 0){ 
            $result['Exist'] = 1;
        }else{*/

            $result['Exist'] = 0;

            //NZD
            $reqGetNZD =  $conn->prepare("SELECT * FROM ".$productsPricingTable." WHERE   Coode = ".$code." AND PricingType = '".$pricetype."' AND  Currency = 'NZD'  ");
            $reqGetNZD->execute();  
            $getNZD = $reqGetNZD->fetch(PDO::FETCH_ASSOC);
 
            for($a = 1; $a < 12; $a++){ 
                if($getNZD['AdditionalCostDesc'.$a]){
                    $additionalPricingNZD[] =  array('desc' => $getNZD['AdditionalCostDesc'.$a], 'ucost' =>   $getNZD['AdditionalCost'.$a], 'setup' => $getNZD['SetupCharge'.$a]); 
                }  
            }   
            $result['AdditionalPricingNZD'] = $additionalPricingNZD;

            //AUD

            $reqGetAUD =  $conn->prepare("SELECT * FROM ".$productsPricingTable." WHERE   Coode = ".$code." AND PricingType = '".$pricetype."' AND  Currency = 'AUD'  ");
            $reqGetAUD->execute();  
            $getAUD = $reqGetAUD->fetch(PDO::FETCH_ASSOC);
 
            for($a = 1; $a < 12; $a++){ 
                if($getAUD['AdditionalCostDesc'.$a]){
                    $additionalPricingAUD[] =  array('desc' => $getAUD['AdditionalCostDesc'.$a], 'ucost' =>   $getAUD['AdditionalCost'.$a], 'setup' => $getAUD['SetupCharge'.$a]); 
                }  
            }   
            $result['AdditionalPricingAUD'] = $additionalPricingAUD;

            
       // }  

        $someJSON = json_encode($result);
        echo $someJSON;    
     }

     if($request->option == 3){  
            
            $PricingType = null;
            $itemCode = null;
            $itemName = null;
            $additionalOptionCategory = null;
            $brandingMethod = null;
            $brandingArea = null;

            $BrandingOption = null;
            $PrintMethod = null;
            $PrintArea = null;

            $costDescription = null;

            $PrizingNZD = null;
            $PrizingNZDUnitCost  = 0.00;
            $PrizingNZDSetup = 0;

            $PrizingAUD = null;
            $PrizingAUDUnitCost = 0.00;
            $PrizingAUDSetup = 0;

            $PrizingSGD = null;
            $PrizingSGDUnitCost = 0.00;
            $PrizingSGDSetup = 0;

            $PrizingMYR = null;
            $PrizingMYRUnitCost = 0.00;
            $PrizingMYRSetup = 0;

            $order = 0;
            $pricePerUnitItemCode= null;
            $pricePerOrderCode = null;
            $maxPerUnit = null; 
            

            if($request->PriceType){
                $PricingType = $request->PriceType;
            }
            if($request->itemCode){
                $itemCode = $request->itemCode;
            }
            if($request->itemName){
                $itemName = $request->itemName;
            }
            if($request->additionalOptionCategory){
                $additionalOptionCategory = $request->additionalOptionCategory;
                if($additionalOptionCategory == "Decoration Option"){
                    $additionalOptionCategory = "DO";
                }
                if($additionalOptionCategory == "Optional Extra"){
                    $additionalOptionCategory = "OE";
                }

                if($additionalOptionCategory == "Decoration Charge on Optional Extra"){
                    $additionalOptionCategory = "DCOE";
                }
               
            }
            if($request->brandingMethod){
                $brandingMethod = $request->brandingMethod;

                if($brandingMethod == "None"){
                    $brandingMethod = null;
                }
            }
            if($request->brandingArea){
                $brandingArea = $request->brandingArea;
            }
            if($request->BrandingOption){
                $BrandingOption = $request->BrandingOption; 
                $PrintMethod = $BrandingOption->pm;
                $PrintArea = $BrandingOption->pa;
                //echo "Branding option " .$BrandingOption->pm . " " .$BrandingOption->pa;
            }
            if($request->costDescription){
                $costDescription = $request->costDescription;
            }
            if($request->PrizingNZD){
                $PrizingNZD = $request->PrizingNZD;
                $PrizingNZDUnitCost = $PrizingNZD->ucost;
                $PrizingNZDSetup = $PrizingNZD->setup;
                //echo " / Pricing NZD is " .$PrizingNZD->ucost. " and " .$PrizingNZD->setup; 
            }
            if($request->PrizingAUD){
                $PrizingAUD = $request->PrizingAUD;
                $PrizingAUDUnitCost = $PrizingAUD->ucost;
                $PrizingAUDSetup = $PrizingAUD->setup;
                //echo " / Pricing NZD is " .$PrizingAUD->ucost. " and " .$PrizingAUD->setup; 
            }

            if($request->PrizingSGD){
                $PrizingSGD = $request->PrizingSGD;
                $PrizingSGDUnitCost = $PrizingSGD->ucost;
                $PrizingSGDSetup = $PrizingSGD->setup;
                //echo " / Pricing NZD is " .$PrizingAUD->ucost. " and " .$PrizingAUD->setup; 
            }

            if($request->PrizingMYR){
                $PrizingMYR = $request->PrizingMYR;
                $PrizingMYRUnitCost = $PrizingMYR->ucost;
                $PrizingMYRSetup = $PrizingMYR->setup;
                //echo " / Pricing NZD is " .$PrizingAUD->ucost. " and " .$PrizingAUD->setup; 
            }


            if($request->order){
                $order = $request->order; 
            }
            if($request->pricePerUnitItemCode){
                $pricePerUnitItemCode= $request->pricePerUnitItemCode;
            }
            if($request->pricePerOrderCode){
                $pricePerOrderCode = $request->pricePerOrderCode;
            }

            if($request->maxPerUnit){
                $maxPerUnit = $request->maxPerUnit;
            }

            
            // error_reporting(E_ALL);
            //ini_set('display_errors', 1);
             

            print_r($request);

            echo $itemCode. " / " .$PricingType. " / " .$costDescription. " / " .$brandingMethod. " / " .$brandingArea. " / " .$maxPerUnit. " / " .$additionalOptionCategory. " / " .$order. " / " .$pricePerUnitItemCode. " / " .$pricePerOrderCode. " / " .$PrizingNZDUnitCost. " / " .$PrizingNZDSetup. " / " .$PrizingAUDUnitCost. " / " .$PrizingAUDSetup. " / " .$PrizingSGDUnitCost. " / " .$PrizingSGDSetup. " / " .$PrizingMYRUnitCost. " / " .$PrizingMYRSetup ;

            //INSERT HERE 
           $sql = $conn->prepare("INSERT INTO ".$additionalOptionsTemp."  (ProductCode, PricingType, costDescription, brandingMethod, brandingArea, maxPerUnit, additionalOptionCategory, orderRow, pricePerUnitItemCode, pricePerOrderCode, NZDUnitPrice, NZDOrderPrice, AUDUnitPrice, AUDOrderPrice, SGDUnitPrice, SGDOrderPrice, MYRUnitPrice, MYROrderPrice ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
           $insertAdditionalOptions = $sql->execute(array($itemCode, $PricingType, $costDescription, $brandingMethod, $brandingArea, $maxPerUnit, $additionalOptionCategory, $order, $pricePerUnitItemCode, $pricePerOrderCode, $PrizingNZDUnitCost, $PrizingNZDSetup, $PrizingAUDUnitCost, $PrizingAUDSetup, $PrizingSGDUnitCost, $PrizingSGDSetup,  $PrizingMYRUnitCost, $PrizingMYRSetup  )); 





     }

     if($request->option == 4){
         
        $code = $request->code;
        $pricetype = $request->pricetype;

        $search = "".$additionalOptionsTemp." WHERE   ProductCode = ".$code." AND PricingType = '".$pricetype."' ";
        
        $req = $conn->prepare("SELECT * FROM  ".$search." ");  
        $req->execute();
        $results  = $req->fetchAll();

        if(count($results) > 0){ 
            
            $req = $conn->prepare("SELECT MAX(orderRow) as maxOrder  FROM  ".$search."  "); 
            $req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC); 
            echo $result['maxOrder'];

        }else{
            echo "none";
        }  


        
        

     }


     if($request->option == 5){
            print_r($request);

            $bad = 0;    
            $error = array();   

            if(!$request->PriceType){
                $bad = 1;
                $error[] = "Price Set";   
            }

            if(!$request->additionalOptionCategory || $request->additionalOptionCategory == '--Select--'){
                $bad = 1;
                $error[] = "Type";   
            } 

            if(!$request->BrandingOption->pm || !$request->BrandingOption->pa){
                $bad = 1;
                $error[] = "Branding Option";  
            }

            if(!$request->PrizingNZD->desc ){
                $bad = 1;
                $error[] = "Pricing NZD";  
            }

            if(!$request->PrizingAUD->desc){
                $bad = 1;
                $error[] = "Pricing AUD";  
            }
            
            if($bad == 0){
                echo "UPDATES IS ALL GOOD HERE!";
            }
             

            $array = array('results' => $bad, 'error'=> $error);

            $someJSON = json_encode($array);
            echo $someJSON;  

            
       
     }

     if($request->option == 6){ 
         
        $adds = $request->datas;
        array_unshift($adds,"");
        unset($adds[0]);
        //print_r($adds);
        $countLoop =  count($adds);
        

        if($countLoop > 1){
            for($i = 1; $i <= $countLoop; $i++){ 
               
                $id = $adds[$i]->additionalCostID;
                $sqlOrder = "UPDATE ".$additionalOptionsTemp." SET  orderRow ='" .$i. "'    
                WHERE additionalCostID ='".$id."' ";
                $order = $conn->query($sqlOrder);  
            }
        } 

        echo "1";

     }

     /* Get the Old and New datas for conversion */
     if($request->option == 7){ 
         
            //echo "Yes get me";
           
            

           if($request->data->ProductCode){

                
                $code = $request->data->ProductCode; 
                $pricingtype = $request->data->PricingType; 
                $resultsFinal = array();


                /******************************** OLD *****************************************************************/

                // Branding Old
                $req = $conn->prepare("SELECT * FROM ".$productsCurrentTable." WHERE    Code = ".$code."    ");  
                $req->execute();
                $results = $req->fetch(PDO::FETCH_ASSOC); 
              
                for($b = 1; $b < 10; $b++){ 
                    if($results['PrintType'.$b]){
                        $brandArray[] =  array('title' => $results['PrintType'.$b], 'desc' =>   $results['PrintDescription'.$b]); 
                    }  
                }  
                $resultsFinal['BrandingOld'] = $brandArray;
               

                // Additional Cost NZD Old
                $reqnzd = $conn->prepare("SELECT * FROM ".$productsPricingTable." WHERE    Coode = ".$code." and PricingType = '".$pricingtype."' and Currency = 'NZD'    ");  
                $reqnzd->execute();
                $resultsAdditionalNZD = $reqnzd->fetch(PDO::FETCH_ASSOC);

                for($a = 1; $a < 10; $a++){ 
                    if($resultsAdditionalNZD['AdditionalCostDesc'.$a]){
                        $additionalNZDOldArray[] =  array('desc' => $resultsAdditionalNZD['AdditionalCostDesc'.$a], 'unit' =>   $resultsAdditionalNZD['AdditionalCost'.$a], 'setup' => $resultsAdditionalNZD['SetupCharge'.$a]); 
                    }  
                }   
                $resultsFinal['AdditionalCostNZDOld'] = $additionalNZDOldArray;



                 // Additional Cost AUD  Old
                 $reqaud = $conn->prepare("SELECT * FROM ".$productsPricingTable." WHERE    Coode = ".$code." and PricingType = '".$pricingtype."' and Currency = 'AUD'    ");  
                 $reqaud->execute();
                 $resultsAdditionalAUD = $reqaud->fetch(PDO::FETCH_ASSOC);
 
                 for($a = 1; $a < 10; $a++){ 
                     if($resultsAdditionalAUD['AdditionalCostDesc'.$a]){
                         $additionalAUDOldArray[] =  array('desc' => $resultsAdditionalAUD['AdditionalCostDesc'.$a], 'unit' =>   $resultsAdditionalAUD['AdditionalCost'.$a], 'setup' => $resultsAdditionalAUD['SetupCharge'.$a]); 
                     }  
                 }   
                 $resultsFinal['AdditionalCostAUDOld'] = $additionalAUDOldArray;



                 /******************************** NEW *****************************************************************/

                // Branding Options New
                $reqBrandNew = $conn->prepare("SELECT brandingMethod, brandingArea FROM ".$additionalOptionsTemp." WHERE    ProductCode = ".$code." AND   PricingType = '".$pricingtype."'  ORDER BY orderRow ASC  ");  
                $reqBrandNew->execute();
                $resultsBrandNew =  $reqBrandNew->fetchAll(); 
                $resultsFinal['BrandingOptionsNew'] = $resultsBrandNew; 


                // Additional Cost NZD New
                $reqAdditionalNZDNew = $conn->prepare("SELECT costDescription, brandingMethod, brandingArea, NZDUnitPrice, NZDOrderPrice FROM ".$additionalOptionsTemp." WHERE    ProductCode = ".$code." AND   PricingType = '".$pricingtype."' ORDER BY orderRow ASC  ");  
                $reqAdditionalNZDNew->execute();
                $resultsAdditionalNZDNew =  $reqAdditionalNZDNew->fetchAll();

                $resultsFinal['AdditonalCostNZDNew'] = $resultsAdditionalNZDNew; 


                 // Additional Cost AUD New
                 $reqAdditionalAUDNew = $conn->prepare("SELECT costDescription, brandingMethod, brandingArea, AUDUnitPrice, AUDOrderPrice FROM ".$additionalOptionsTemp." WHERE    ProductCode = ".$code." AND   PricingType = '".$pricingtype."' ORDER BY orderRow ASC  ");  
                 $reqAdditionalAUDNew->execute();
                 $resultsAdditionalAUDNew =  $reqAdditionalAUDNew->fetchAll();
 
                 $resultsFinal['AdditionalCostAUDNew'] = $resultsAdditionalAUDNew; 



                // JSON Results compile
                $someJSON = json_encode($resultsFinal);
                echo $someJSON;  
            }
           
            
     }




     if($request->option == 9){ 

        $additionalCostID = $request->thisID;
        $code  = $request->code;
        $pricingtype = $request->pricingtype;

        $search = $conn->prepare('SELECT Converted FROM '.$productsPricingTable.' WHERE  Coode = '.$code.' AND PricingType = "'.$pricingtype.'" AND Converted = 1  '); 
        $search->execute();
        $row = $search->fetchAll(); 

        
        if(count($row) > 0)
        {
            echo "duplicated";
        }else{ 
           
            $req = $conn->prepare("INSERT INTO ".$additionalOptions."    SELECT * FROM ".$additionalOptionsTemp." WHERE  ProductCode = ".$code." AND PricingType = '".$pricingtype."'   " );   
            if($req->execute()){ 

                $success = 1; 

                if($success){

                    if($pricingtype == 'Stock'){

                        $getBranding = $conn->prepare(" SELECT brandingMethod, brandingArea FROM ".$additionalOptionsTemp." WHERE  ProductCode = ".$code." AND PricingType = '".$pricingtype."' ORDER BY orderRow ASC  "); 
                        $getBranding->execute();
                        $rowBranding = $getBranding->fetchAll(); 

                        // print_r($rowBranding);
                        for($x = 0; $x < count($rowBranding); $x++){
                            //echo $rowBranding[$x]['brandingMethod']. " / " .cleanString($rowBranding[$x]['brandingArea']);
                            
                            $print = $x + 1;
                            $sqlBranding = "UPDATE ".$productsCurrentTable." SET  PrintType".$print."  ='" .$rowBranding[$x]['brandingMethod']. "', PrintDescription".$print."  ='" .cleanString($rowBranding[$x]['brandingArea']). "' WHERE Code =".$code." ";
                            $branding = $conn->query($sqlBranding);  
                        } 

                    }

                    /***** NZD Pricing  Update  **********************/
                    $getNZD = $conn->prepare(" SELECT PricingType, costDescription, NZDUnitPrice, NZDOrderPrice, orderRow FROM ".$additionalOptionsTemp." WHERE  ProductCode = ".$code." AND PricingType = '".$pricingtype."' ORDER BY orderRow ASC  "); 
                    $getNZD->execute();
                    $rowNZD = $getNZD->fetchAll(); 

                    //print_r($rowNZD);

                    for($nzd = 0; $nzd < count($rowNZD); $nzd++){

                        //echo $rowNZD[$nzd]['costDescription']. " / ".$rowNZD[$nzd]['NZDUnitPrice']. " / ".$rowNZD[$nzd]['NZDOrderPrice'];

                        $addNzd = $nzd + 1;
                        $sqlNZD = "UPDATE ".$productsPricingTable." SET  AdditionalCostDesc".$addNzd."  ='".$rowNZD[$nzd]['costDescription']."', AdditionalCost".$addNzd."  ='" .$rowNZD[$nzd]['NZDUnitPrice']."', SetupCharge".$addNzd." = '" .$rowNZD[$nzd]['NZDOrderPrice']."'  WHERE Coode =".$code." AND PricingType = '".$pricingtype."' AND Currency = 'NZD'  ";
                        $updateNZD= $conn->query($sqlNZD);  

                    }

                    /**********AUD Pricing Update  **********************/

                    $getAUD = $conn->prepare(" SELECT PricingType, costDescription, AUDUnitPrice, AUDOrderPrice, orderRow FROM ".$additionalOptionsTemp." WHERE  ProductCode = ".$code." AND PricingType = '".$pricingtype."' ORDER BY orderRow ASC  "); 
                    $getAUD->execute();
                    $rowAUD = $getAUD->fetchAll();  
                    //print_r($rowAUD);

                    for($aud = 0; $aud < count($rowAUD); $aud++){ 

                        $addAud = $aud + 1;
                        $sqlAUD = "UPDATE ".$productsPricingTable." SET  AdditionalCostDesc".$addAud."  ='".$rowAUD[$aud]['costDescription']."', AdditionalCost".$addAud."  ='" .$rowAUD[$aud]['AUDUnitPrice']."', SetupCharge".$addAud." = '" .$rowAUD[$aud]['AUDOrderPrice']."'  WHERE Coode =".$code." AND PricingType = '".$pricingtype."' AND Currency = 'AUD'  ";
                        $updateAUD= $conn->query($sqlAUD);  

                    }

                    /***** UPDATE the Pricing Table converted to 1  */

                    $sqlUpdate = "UPDATE ".$productsPricingTable." SET  Converted = 1    WHERE Coode =".$code." AND PricingType = '".$pricingtype."'  ";
                    $sqlUpdateDone = $conn->query($sqlUpdate);  


                    
                    echo "success";
                }
               
            
            }else{
                echo "failed";
            }  
        } 
 

       

        

     }

     if($request->option == 10){ 
        

        $additionalCostID = $request->thisID;

        $command = " DELETE FROM ".$additionalOptionsTemp." WHERE additionalCostID=:additionalCostID";
        $stmt = $conn ->prepare($command);
        $stmt->bindParam(':additionalCostID', $additionalCostID, PDO::PARAM_INT);
        $done = $stmt->execute();
        
        if($done){
            echo "deleted";
        }
     }


     
     /* NEW FORMAT Get the Old and New datas for conversion */
    if($request->option == 11){ 
        

       if($request->code){

            $pricingTypeList = $request->pricingTypeList;    
            $code = $request->code;  
            $resultsFinal = array();


             //print_r($pricingTypeList);

             foreach($pricingTypeList as $ptRow){
                $pricetypeArray[] = $ptRow->PricingType; 
             }

             $resultsFinal['PricingTypes'] = $pricetypeArray; 

             /****************** Branding Old ************************/

             
             $req = $conn->prepare("SELECT * FROM ".$productsCurrentTable." WHERE    Code = ".$code."    ");  
             $req->execute();
             $results = $req->fetch(PDO::FETCH_ASSOC); 
           
             for($b = 1; $b < 10; $b++){ 
                 if($results['PrintType'.$b]){
                     $brandArray[] =  array('title' => $results['PrintType'.$b], 'desc' =>   $results['PrintDescription'.$b]); 
                 }  
             }  
             $resultsFinal['BrandingOld'] = $brandArray; 

            /****************** OLD NZD PRICINGLIST ************************/

            foreach($pricingTypeList as $ptRow){

                $pricingtype =  $ptRow->PricingType; 
                // Additional Cost NZD Old
                $reqnzd = $conn->prepare("SELECT * FROM ".$productsPricingTable." WHERE    Coode = ".$code." and PricingType = '".$pricingtype."' and Currency = 'NZD'    ");  
                $reqnzd->execute();
                $resultsAdditionalNZD = $reqnzd->fetch(PDO::FETCH_ASSOC);

                for($a = 1; $a < 10; $a++){ 
                    if($resultsAdditionalNZD['AdditionalCostDesc'.$a]){
                        $additionalNZDOldArray[$pricingtype][$a] =  array('ptype'=> $pricingtype,'desc' => $resultsAdditionalNZD['AdditionalCostDesc'.$a], 'unit' =>   $resultsAdditionalNZD['AdditionalCost'.$a], 'setup' => $resultsAdditionalNZD['SetupCharge'.$a]); 
                    }  
                }   


                 // Additional Cost NZD Old
                 $reqaud = $conn->prepare("SELECT * FROM ".$productsPricingTable." WHERE    Coode = ".$code." and PricingType = '".$pricingtype."' and Currency = 'AUD'    ");  
                 $reqaud->execute();
                 $resultsAdditionalAUD = $reqaud->fetch(PDO::FETCH_ASSOC);
 
                 for($a = 1; $a < 10; $a++){ 
                     if($resultsAdditionalAUD['AdditionalCostDesc'.$a]){
                         $additionalAUDOldArray[$pricingtype][$a] =  array('ptype'=> $pricingtype,'desc' => $resultsAdditionalAUD['AdditionalCostDesc'.$a], 'unit' =>   $resultsAdditionalAUD['AdditionalCost'.$a], 'setup' => $resultsAdditionalAUD['SetupCharge'.$a]); 
                     }  
                 }   

            }

            $resultsFinal['AdditionalCostNZDOld'] = $additionalNZDOldArray; 
            $resultsFinal['AdditionalCostAUDOld'] = $additionalAUDOldArray; 

             /****************** OLD AUD PRICINGLIST ************************/

             

            


             /************************* BRANDING NEW  *******/
             $bn = 0;
            foreach($pricingTypeList as $ptRow2){

                $pricingtype =  $ptRow2->PricingType; 



                $reqBrandNew = $conn->prepare("SELECT PricingType, brandingMethod, brandingArea FROM ".$additionalOptionsTemp." WHERE    ProductCode = ".$code." AND   PricingType = '".$pricingtype."'  ORDER BY orderRow ASC  ");  
                $reqBrandNew->execute();
                $resultsBrandNew[$pricingtype] =  $reqBrandNew->fetchAll(); 

                 // Additional Cost NZD New
                $reqAdditionalNZDNew = $conn->prepare("SELECT PricingType, costDescription,  NZDUnitPrice, NZDOrderPrice FROM ".$additionalOptionsTemp." WHERE    ProductCode = ".$code." AND   PricingType = '".$pricingtype."' ORDER BY orderRow ASC  ");  
                $reqAdditionalNZDNew->execute();
                $resultsAdditionalNZDNew[$pricingtype] =  $reqAdditionalNZDNew->fetchAll(); 


                 // Additional Cost AUD New
                 $reqAdditionalAUDNew = $conn->prepare("SELECT PricingType, costDescription,  AUDUnitPrice, AUDOrderPrice FROM ".$additionalOptionsTemp." WHERE    ProductCode = ".$code." AND   PricingType = '".$pricingtype."' ORDER BY orderRow ASC  ");  
                 $reqAdditionalAUDNew->execute();
                 $resultsAdditionalAUDNew[$pricingtype] =  $reqAdditionalAUDNew->fetchAll(); 

                $bn++;
            } 


            $resultsFinal['BrandingOptionsNew'] = $resultsBrandNew; 
            $resultsFinal['AdditionalCostNZDNew'] = $resultsAdditionalNZDNew; 
            $resultsFinal['AdditionalCostAUDNew'] = $resultsAdditionalAUDNew; 
            
             

            // JSON Results compile
            $someJSON = json_encode($resultsFinal);
            echo $someJSON; 
        }
       
        
 }



 

 if($request->option == 12){ 

    
    $code  = $request->code;
    $pricingTypeList = $request->pricingTypeList;
     
    $search = $conn->prepare('SELECT Converted FROM '.$productsPricingTable.' WHERE  Coode = '.$code.'  AND Converted = 1  '); 
    $search->execute();
    $row = $search->fetchAll(); 

     

    
    if(count($row) > 0)
    {
        echo "duplicated";
    }else{ 

        

       //$req = $conn->prepare("INSERT INTO ".$additionalOptions."    SELECT * FROM ".$additionalOptionsTemp." WHERE  ProductCode = '".$code."'    " );   
       //if($req->execute()){ 

        $searchTemp = $conn->prepare('SELECT ProductCode, PricingType, costDescription, brandingMethod, brandingArea, maxPerUnit, additionalOptionCategory, orderRow, pricePerUnitItemCode, pricePerOrderCode, NZDUnitPrice, NZDOrderPrice, AUDUnitPrice, AUDOrderPrice, SGDUnitPrice, SGDOrderPrice, MYRUnitPrice, MYROrderPrice  FROM '.$additionalOptionsTemp.' WHERE  ProductCode = '.$code.'  '); 
        $searchTemp->execute();
        $rowTemp = $searchTemp->fetchAll(); 

        if(count($rowTemp) > 0)
        {
           //print_r( $pricingTypeList);
           //INSERT FRIST TO ADDITIONALCOST TABLE
            foreach($rowTemp as $insertRows){
               
                //echo $insertRows['ProductCode']. "/ ".$insertRows['PricingType']. "/ ".$insertRows['costDescription']. "/ ".$insertRows['brandingMethod']. "/ ".$insertRows['brandingArea']. "/ ".$insertRows['maxPerUnit']. "/ ".$insertRows['additionalOptionCategory']. "/ ".$insertRows['orderRow'];

                    $insertTemp = $conn->prepare("INSERT INTO ".$additionalOptions." 
                    (ProductCode, PricingType, costDescription, brandingMethod, brandingArea, maxPerUnit, additionalOptionCategory, orderRow, pricePerUnitItemCode, pricePerOrderCode, NZDUnitPrice, NZDOrderPrice, AUDUnitPrice, AUDOrderPrice, SGDUnitPrice, SGDOrderPrice, MYRUnitPrice, MYROrderPrice) 
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )"); 
                    $insertTempDone = $insertTemp->execute(
                        array(
                                $insertRows['ProductCode'], 
                                $insertRows['PricingType'],
                                $insertRows['costDescription'],
                                $insertRows['brandingMethod'],
                                $insertRows['brandingArea'],
                                $insertRows['maxPerUnit'],
                                $insertRows['additionalOptionCategory'],
                                $insertRows['orderRow'],
                                $insertRows['pricePerUnitItemCode'],
                                $insertRows['pricePerOrderCode'],
                                $insertRows['NZDUnitPrice'],
                                $insertRows['NZDOrderPrice'],
                                $insertRows['AUDUnitPrice'],
                                $insertRows['AUDOrderPrice'],
                                $insertRows['SGDUnitPrice'],
                                $insertRows['SGDOrderPrice'],
                                $insertRows['MYRUnitPrice'],
                                $insertRows['MYROrderPrice'] 

                            )
                    );  
                    $success =  $insertTempDone;  
            }
        
         

            //if($success){
                    
                 ////////////////////////////Branding Update 
                    $bn = 0;
                    foreach($pricingTypeList as $ptRow){

                        $pricingtype =  $ptRow->PricingType; 
                        $reqBrandNew = $conn->prepare("SELECT brandingMethod, brandingArea FROM ".$additionalOptionsTemp." WHERE    ProductCode = ".$code." AND   PricingType = '".$pricingtype."'  ORDER BY orderRow ASC  ");  
                        $reqBrandNew->execute();
                        $resultsBrandNew[$pricingtype] =  $reqBrandNew->fetchAll(); 

                        foreach($resultsBrandNew[$pricingtype] as $orderRow){

                            if($orderRow['brandingMethod']){
                                $newBrandingArray[] = $orderRow; //This will order and save into productsCurrent branding columns
                            } 
                        }

                        $bn++;
                    }

                     
                    for($x = 0; $x < count($newBrandingArray); $x++){  
                        $print = $x + 1;
                        $sqlBranding = "UPDATE ".$productsCurrentTable." SET  PrintType".$print."  ='" .$newBrandingArray[$x]['brandingMethod']. "', PrintDescription".$print."  ='" .cleanString($newBrandingArray[$x]['brandingArea']). "' WHERE Code =".$code." ";
                        $branding = $conn->query($sqlBranding);  
                    } 


                    //////////////////////////////// NZD Pricing  Update
                    foreach($pricingTypeList as $ptRow){

                            $pricingtype =  $ptRow->PricingType;  
                            $getNZD = $conn->prepare(" SELECT PricingType, costDescription, NZDUnitPrice, NZDOrderPrice, orderRow FROM ".$additionalOptionsTemp." WHERE  ProductCode = ".$code." AND PricingType = '".$pricingtype."' ORDER BY orderRow ASC  "); 
                            $getNZD->execute();
                            $rowNZD = $getNZD->fetchAll(); 

                              //Clear and remove first
                            for($nzd = 0; $nzd < 11; $nzd++){ 
                                $addNzd = $nzd + 1;
                                $sqlNZDClear = "UPDATE ".$productsPricingTable." SET  AdditionalCostDesc".$addNzd."  ='', AdditionalCost".$addNzd."  ='', SetupCharge".$addNzd." = ''  WHERE Coode =".$code." AND PricingType = '".$pricingtype."' AND Currency = 'NZD'  ";
                                $updateNZDClear= $conn->query($sqlNZDClear);   
                            }

                            for($nzd = 0; $nzd < count($rowNZD); $nzd++){   
                                $addNzd = $nzd + 1;
                                $sqlNZD = "UPDATE ".$productsPricingTable." SET  AdditionalCostDesc".$addNzd."  ='".$rowNZD[$nzd]['costDescription']."', AdditionalCost".$addNzd."  ='" .$rowNZD[$nzd]['NZDUnitPrice']."', SetupCharge".$addNzd." = '" .$rowNZD[$nzd]['NZDOrderPrice']."'  WHERE Coode =".$code." AND PricingType = '".$pricingtype."' AND Currency = 'NZD'  ";
                                $updateNZD= $conn->query($sqlNZD);   
                            }

                    }

                    //////////////////////////////// AUD Pricing  Update

                    foreach($pricingTypeList as $ptRow){ 
                        $pricingtype =  $ptRow->PricingType;  

                        $getAUD = $conn->prepare(" SELECT PricingType, costDescription, AUDUnitPrice, AUDOrderPrice, orderRow FROM ".$additionalOptionsTemp." WHERE  ProductCode = ".$code." AND PricingType = '".$pricingtype."' ORDER BY orderRow ASC  "); 
                        $getAUD->execute();
                        $rowAUD = $getAUD->fetchAll();  
                        //print_r($rowAUD);

                         //Remove first and clear
                        for($aud = 0; $aud < 11; $aud++){  
                            $addAud = $aud + 1; 
                            $sqlAUDClear = "UPDATE ".$productsPricingTable." SET  AdditionalCostDesc".$addAud."  ='', AdditionalCost".$addAud."  ='', SetupCharge".$addAud." = ''  WHERE Coode =".$code." AND PricingType = '".$pricingtype."' AND Currency = 'AUD'  ";
                            $updateAUDClear= $conn->query($sqlAUDClear);   

                        }

                        for($aud = 0; $aud < count($rowAUD); $aud++){ 

                            $addAud = $aud + 1; 

                            $sqlAUD = "UPDATE ".$productsPricingTable." SET  AdditionalCostDesc".$addAud."  ='".$rowAUD[$aud]['costDescription']."', AdditionalCost".$addAud."  ='" .$rowAUD[$aud]['AUDUnitPrice']."', SetupCharge".$addAud." = '" .$rowAUD[$aud]['AUDOrderPrice']."'  WHERE Coode =".$code." AND PricingType = '".$pricingtype."' AND Currency = 'AUD'  ";
                            $updateAUD= $conn->query($sqlAUD);  

                        }


                    }


                    //////////////////////////////// UPDATE the Pricing Table converted to 1   

                    foreach($pricingTypeList as $ptRow){ 
                        $pricingtype =  $ptRow->PricingType;  

                        $sqlUpdate = "UPDATE ".$productsPricingTable." SET  Converted = 1    WHERE Coode =".$code." AND PricingType = '".$pricingtype."'  ";
                        $sqlUpdateDone = $conn->query($sqlUpdate);   

                    } 
                   

                    echo "success"; 
            //}else{
               // echo "failed";
            //} 
        
        
        
        }
        
       
            

             
        //}  //IF INSERT  

         
 
    }  //IF NOT DUPLICATED

 }


     function cleanString($string ){
		 
		$res = $string;
 
		$specChars = array(    
			'&amp;' => '&',    '\'' => '',   
			 '*' => '',   '₹' => '',     
			'/-' => '',    ':' => '',    ';' => '',
			'<' => '',    '=' => '',    '>' => '',
			'?' => '',    '@' => '',    '[' => '',
			'\\' => '',   ']' => '',    '^' => '',
			'_' => '',    '`' => '',    '{' => '',
			'|' => '',    '}' => '',    '~' => '',
			'-----' => '-',    '----' => '-',    '---' => '-',
			'--' => '-',   '/_' => '-',  '&039'=> '', '&#039'=> '', '&#039;'=> '’',
			'&039;'=>'', 'â€”' => '-', 'â€™'=>'’', 'â€“'=>'-', 'â€˜'=>'’',
			'â€¢' => '', 'Â'=> '', '&nbsp;'=>'', '&nbsp'=>'', "Ã¢â‚¬â„¢s"=> "", "Ã¢â‚¬â„¢"=>'',
			"Ã¢â‚¬Ëœ"=>'', "Ã‚Â®"=> "®", "â„¢" => "™", '&quot;'=> '"',   'quot;'=> '"' 
		);
	
		foreach ($specChars as $k => $v) {
			$res = str_replace($k, $v, $res);
		}
	 
		return $res;
	}
 
 
 
?>